<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\NotificationsEmailJob;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'to_notify',
        'user_switch_uuid',
        'job_id'
    ];

    // Types of event
    public static string $TYPE_MESSAGE = 'message';
    public static string $TYPE_FILE = 'file';
    public static string $TYPE_STATUS = 'status';

    private static int $id_counter = 0;

    public static function create_mail_job(string $user_switch_uuid)
    {
        //NotificationsEmailJob::dispatch($id_counter, $user_switch_uuid)->delay(now()->addMinutes(10));
        NotificationsEmailJob::dispatch($id_counter, $user_switch_uuid)->delay(now()->addSeconds(20));
        $id_counter += 1;
    }

    // Belongs to
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_switch_uuid');
    }
}
