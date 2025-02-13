<?php

namespace App\Models\Guidance;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model};

class GuidanceOtpAccount extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'otp', 'expires_at'];

    public $timestamps = false;
}
