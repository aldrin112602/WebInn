<?php

namespace App\Models\Guidance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Guidance\GuidanceAccount;

class GuidanceNotification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'user_id',
        'title',
        'message',
        'is_seen',
        'url',
        'icon',
        'priority',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_seen' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user associated with the notification.
     */
    public function user()
    {
        return $this->belongsTo(GuidanceAccount::class);
    }

    /**
     * Scope a query to only include unseen notifications.
     */
    public function scopeUnseen($query)
    {
        return $query->where('is_seen', false);
    }

    /**
     * Mark the notification as seen.
     */
    public function markAsSeen()
    {
        $this->update(['is_seen' => true]);
    }
}
