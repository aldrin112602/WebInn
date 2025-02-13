<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\AdminAccount as Admin;

class FaceRecognitionKey extends Model
{
    use HasFactory;
    protected $fillable = [
        'pattern',
        'created_by_admin_id',
        'updated_by_admin_id',
        'image_path'
    ];

    public function setPatternAttribute($value)
    {
        if (!Hash::needsRehash($value)) {
            $this->attributes['pattern'] = $value;
        } else {
            $this->attributes['pattern'] = Hash::make($value);
        }
    }




    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by_admin_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by_admin_id');
    }
}
