<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;

    // Primary key options
    protected $primaryKey = 'switch_uuid';
    protected $keyType = 'string';

    protected $fillable = [
        'switch_uuid',
        'email',
        'name',
        'surname',
        'password',
        'require_status_email',
        'require_files_email',
        'require_messages_email',
        'last_email_sent'
    ];

    // Default values
    protected $attributes = [
        'require_status_email' => true,
        'require_files_email' => true,
        'require_messages_email' => true
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'last_email_sent'
    ];

    // Options
    public $timestamps = false;
    public $incrementing = false;

    // Has many
    public function requestor_jobs()
    {
        return $this->hasMany(Job::class, 'client_switch_uuid');
    }

    public function worker_jobs()
    {
        return $this->hasMany(Job::class, 'worker_switch_uuid');
    }

    public function validator_jobs()
    {
        return $this->hasMany(Job::class, 'validator_switch_uuid');
    }

    public function sended_messages()
    {
        return $this->hasMany(Message::class, 'sender_switch_uuid');
    }

    public function received_messages()
    {
        return $this->hasMany(Message::class, 'receiver_switch_uuid');
    }

    // Belongs to many
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
