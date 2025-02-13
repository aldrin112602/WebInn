<?php

namespace App\Models\Teacher;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\{
    Database\Eloquent\Factories\HasFactory,
    Foundation\Auth\User as Authenticatable,
    Notifications\Notifiable,
    Support\Facades\Hash
};

use App\Models\Message;
use App\Models\TeacherGradeHandle;

class TeacherAccount extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_number',
        'name',
        'gender',
        'role',
        'position',
        'username',
        'password',
        'email',
        'profile',
        'phone_number',
        'address',
        'extension_name'

    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }


    public function sentMessages()
    {
        return $this->morphMany(Message::class, 'sender');
    }

    public function receivedMessages()
    {
        return $this->morphMany(Message::class, 'receiver');
    }

    public function grade_handle() 
    {
        return $this->belongsTo(TeacherGradeHandle::class, 'teacher_id');
    }
}
