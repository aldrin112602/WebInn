<?php

namespace App\Models\Student;

use Illuminate\{
    Database\Eloquent\Factories\HasFactory,
    Foundation\Auth\User as Authenticatable,
    Notifications\Notifiable,
    Support\Facades\Hash
};

use App\Models\{Message, StudentImage, Admin\SubjectModel, StudentHandle};
use App\Models\Student\AttendanceHistory;


class StudentAccount extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id_number',
        'name',
        'gender',
        'strand',
        'section',
        'grade',
        'parents_contact_number',
        'parents_email',
        'username',
        'password',
        'email',
        'role',
        'profile',
        'phone_number',
        'address',
        'extension_name',
        'lrn',
        'birthdate'
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

    public function images()
    {
        return $this->hasMany(StudentImage::class, 'student_id');
    }

    // Define the subjects relationship
    public function subjects()
    {
        return $this->belongsToMany(SubjectModel::class, 'student_subjects', 'student_id', 'subject_id');
    }



    public function attendaceHistories()
    {
        return $this->hasMany(AttendanceHistory::class, 'student_id');
    }

    public function attendanceHistories()
    {
        return $this->hasMany(AttendanceHistory::class, 'student_id');
    }


    public function studentHandles()
    {
        return $this->hasMany(StudentHandle::class, 'student_id');
    }

    public function handles()
{
    return $this->hasMany(StudentHandle::class, 'student_id', 'id');
}

}
