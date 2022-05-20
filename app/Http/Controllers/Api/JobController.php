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
use Illuminate\Http\Request;

class JobController extends Controller
{
    // TODO: perhaps dependance injection -> https://laravel.com/docs/9.x/controllers#dependency-injection-and-controllers

    // API Standard function
    public function index()
    {
        return JobResource::collection(Job::all());
    }

    public function show($id)
    {
        // TODO: verify $id input

        $job = Job::findOrFail($id);
        return new JobResource($job);
    }

    public function store(StoreJobRequest $request)
    {
        // TODO: add event

        // TODO: add files
        /*foreach($request_files as $file) {
            File::store_file($file, $request->job_id);
            // TODO: add event
        }*/

        $job = Job::create($request->validated());

        //Notify all the technicians that a new job is available. Then don't need the timeline and files
        //broadcast(new JobPusherEvent($newJob, 0))->toOthers();

        return new JobResource($job);
    }

    public function update(UpdateJobRequest $request)
    {
        $req_validated = $request->validated();

        // TODO: manage files update -> only via files route
        // here only job info

        $job = Job::findOrFail($request->id);
        $job->update($req_validated);
        return new JobResource($job);
    }

    public function destroy($id)
    {
        // TODO: verify $id input

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

    public function user_jobs($switch_uuid)
    {
        // TODO: verify $switch_uuid input

        return JobResource::collection(Job::get_user_jobs($switch_uuid));
    }

    public function user_as_client_jobs($switch_uuid)
    {
        // TODO: verify $switch_uuid input

        return JobResource::collection(Job::get_client_jobs($switch_uuid));
    }
    
    public function user_as_worker_jobs($switch_uuid)
    {
        // TODO: verify $switch_uuid input

        return JobResource::collection(Job::get_worker_jobs($switch_uuid));
    }

    public function user_as_validator_jobs($switch_uuid)
    {
        // TODO: verify $switch_uuid input

        return JobResource::collection(Job::get_validator_jobs($switch_uuid));
    }

    public function assign_worker(UpdateJobAssignWorkerRequest $request)
    {
        $req_validated = $request->validated();

        // Update worker
        $job = Job::findOrFail($request->id);
        $job->update($req_validated);

        // Update status
        $job->status = 'assigned';
        $job->save();

        return new JobResource($job);
    }

    public function update_status(UpdateJobStatusRequest $request)
    {
        $req_validated = $request->validated();

        /*if ($req_validated->fails()) {
            return response()->json([
                'message' => "error"
            ], 400);
        }*/

        $job = Job::findOrFail($request->id);
        $job->update($req_validated);

        // TODO: add event

        return new JobResource($job);
    }

    public function update_rating(UpdateJobRatingRequest $request)
    {
        $req_validated = $request->validated();

        $job = Job::findOrFail($request->id);

        if ($job->status != 'completed') {
            return response()->json([
                'message' => "You can't rate of a job that is not completed!"
            ], 400);
        }

        // TODO: do we suppress files and message if completed?

        // Update rating
        $job->update($req_validated);

        // Update status
        $job->status = 'terminated';
        $job->save();

        // TODO: add event

        return new JobResource($job);
    }
}
