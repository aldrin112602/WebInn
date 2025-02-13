<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model};

class StudentOtpAccount extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'otp', 'expires_at'];

    public $timestamps = false;
}
