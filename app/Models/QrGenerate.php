<?php

namespace App\Models;

use App\Models\Admin\SubjectModel;
use Illuminate\Database\Eloquent\{Factories\HasFactory, Model};

class QrGenerate extends Model
{
    use HasFactory;
    protected $fillable = [
        'subject_id',
        'teacher_id',
        'qr_code_id',
        'created_at',
        'updated_at'
    ];

    public function subject()
    {
        return $this->belongsTo(SubjectModel::class, 'subject_id');
    }
}
