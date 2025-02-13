<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Factories\HasFactory, Model};
use App\Models\Teacher\TeacherAccount;

class Announcement extends Model
{
    use HasFactory;
    protected $fillable = [
        'teacher_id',
        'grade_handle_id',
        'title',
        'announcement',
        'file_path',
        'created_at',
        'updated_at'
    ];

    public function teacher()
    {
        return $this->belongsTo(TeacherAccount::class, 'teacher_id');
    }

    public function seenAnnouncements()
    {
        return $this->hasMany(SeenAnnouncement::class, 'announcement_id');
    }
}
