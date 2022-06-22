<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequests\StoreJobRequest;
use App\Http\Requests\UpdateRequests\UpdateJobRequest;
use App\Http\Requests\UpdateRequests\UpdateJobAssignWorkerRequest;
use App\Http\Requests\UpdateRequests\UpdateJobStatusRequest;
use App\Http\Requests\UpdateRequests\UpdateJobRatingRequest;
use App\Http\Resources\JobResource;
use App\Models\Job;
use App\Models\File;
use App\Models\Event;
use App\Events\JobAssignedEvent;
use App\Events\JobCreatedEvent;
use App\Events\JobStatusUpdatedEvent;
use App\Events\JobTerminatedEvent;

// TODO: add notifications and websockets with: https://beyondco.de/docs/laravel-websockets/getting-started/introduction
// php artisan websockets:serve --host=127.0.0.1 -> to communicate only on localhost that is possible, wait and see if it works
// php artisan websockets:serve --port=3030 -> TODO: define an port for websockets 80 or 443 -> perhaps 8000

class JobController extends Controller
{
    // API Standard function
    public function index()
    {
        return JobResource::collection(Job::all());
    }

    public function show(int $id)
    {
        // TODO: verify $id input

        $job = Job::findOrFail($id);
        return new JobResource($job);
    }

    public function store(StoreJobRequest $request)
    {
        $job = Job::create($request->validated());

        // Add files to job
        if ($request->has('files')) {
            $files = $request->file('files');
            foreach ($files as $req_file) {
                File::store_file($req_file, $job->id);
            }
        }

        // Notifications
        broadcast(new JobCreatedEvent($job));

        // Create and save Event (notify worker)
        if ($job->worker_switch_uuid != null) {
            Event::create([
                'type' => Event::T_STATUS,
                'to_notify' => true,
                'data' => Job::S_NEW,
                'user_switch_uuid' => $job->worker_switch_uuid,
                'job_id' => $job->id
            ]);
        }

        return new JobResource($job);
    }

    // Manage files update only via files route
    // Here only job info are updated
    public function update(UpdateJobRequest $request)
    {
        $req_validated = $request->validated();

        // Notifications
        // TODO: ?
        //broadcast(new JobCreatedEvent($job));
        //broadcast(new JobCreatedEvent($job))->toOthers();

        $job = Job::findOrFail($request->id);
        $job->update($req_validated);
        return new JobResource($job);
    }

    public function destroy(int $id)
    {
        // TODO: verify $id input

        // TODO: only admin or creator?

        Job::findOrFail($id)->delete();
        return response()->json([
            'message' => "Job deleted successfully!"
        ], 200);
    }

    // Others function
    public function unassigned_jobs()
    {
        //TODO: The timeline, files and messages must be attached to each job as additional properties
        return JobResource::collection(Job::get_unassigned_jobs());
    }

    public function user_jobs(string $switch_uuid)
    {
        // TODO: verify $switch_uuid input
        // TODO: check how validate with request GET params
        // https://laravel.com/docs/9.x/routing#required-parameters

        return JobResource::collection(Job::get_user_jobs($switch_uuid));
    }

    public function user_as_client_jobs(string $switch_uuid)
    {
        // TODO: verify $switch_uuid input

        return JobResource::collection(Job::get_client_jobs($switch_uuid));
    }

    public function user_as_worker_jobs(string $switch_uuid)
    {
        // TODO: verify $switch_uuid input

        return JobResource::collection(Job::get_worker_jobs($switch_uuid));
    }

    public function user_as_validator_jobs(string $switch_uuid)
    {
        // TODO: verify $switch_uuid input

        return JobResource::collection(Job::get_validator_jobs($switch_uuid));
    }

    // TODO: perhaps route for assign multiple jobs

    public function assign_worker(UpdateJobAssignWorkerRequest $request)
    {
        $req_validated = $request->validated();

        $job = Job::findOrFail($request->id);

        // Verify if job is unassigned
        if ($job->worker_switch_uuid != null) {
            return response()->json([
                'message' => "Job is already assigned to a worker!"
            ], 400);
        }

        $job->update($req_validated);

        // Update status
        $job->status = Job::S_ASSIGNED;
        $job->save();

        // Notifications
        broadcast(new JobAssignedEvent($job))->toOthers();

        // Create and save Event (notify client)
        $event = Event::create([
            'type' => Event::T_STATUS,
            'to_notify' => true,
            'data' => Job::S_ASSIGNED,
            'user_switch_uuid' => $job->client_switch_uuid,
            'job_id' => $job->id
        ]);

        // Emails
        Event::create_mail_job($job->client_switch_uuid);

        return new JobResource($job);
    }

    public function update_status(UpdateJobStatusRequest $request)
    {
        $req_validated = $request->validated();

        $job = Job::findOrFail($request->id);

        if ($request->worker_switch_uuid != $job->worker_switch_uuid) {
            return response()->json([
                'message' => "You can't update a job that is not assigned to you!"
            ], 400);
        }

        $job->update($req_validated);

        // Notifications
        broadcast(new JobStatusUpdatedEvent($job)); //->toOthers();

        // Create and save Event (notify client)
        Event::create([
            'type' => Event::T_STATUS,
            'to_notify' => true,
            'data' => $job->status,
            'user_switch_uuid' => $job->client_switch_uuid,
            'job_id' => $job->id
        ]);

        // Emails
        Event::create_mail_job($job->client_switch_uuid);

        return new JobResource($job);
    }

    public function update_rating(UpdateJobRatingRequest $request)
    {
        $req_validated = $request->validated();

        $job = Job::findOrFail($request->id);

        if ($job->status != Job::S_COMPLETED) {
            return response()->json([
                'message' => "You can't rate of a job that is not completed!"
            ], 400);
        }

        // TODO: do we suppress files and message if completed?

        // Update rating
        $job->update($req_validated);

        // Update status
        $job->status = Job::S_CLOSED;
        $job->save();

        // Notifications
        broadcast(new JobTerminatedEvent($job)); //->toOthers();

        // Create and save Event (notify worker)
        $event = Event::create([
            'type' => Event::T_STATUS,
            'to_notify' => true,
            'data' => Job::S_CLOSED,
            'user_switch_uuid' => $job->worker_switch_uuid,
            'job_id' => $job->id
        ]);

        // Emails
        Event::create_mail_job($job->worker_switch_uuid);

        return new JobResource($job);
    }

    // Called when a user has checked the job and needs to remove the notify flag
    // We assume that when a user has seen a job, he has seen all messages, new files and new status
    public function update_notifications(int $id)
    {
        $job = Job::findOrFail($id);

        //All of the events are updated
        $events = Event::where('job_id', $job->id)->get();
        foreach ($events as $event) {
            $event->to_notify = false;
            $event->save();
            $event->delete();
        }

        return $job;
    }
}
