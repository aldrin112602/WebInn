<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model
};

class AdminOtpAccount extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'otp', 'expires_at'];

    public $timestamps = false;
}
