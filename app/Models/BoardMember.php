<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class BoardMember extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'position',
        'details',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Get all media for the board member.
     */
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable')->ordered();
    }

    /**
     * Booted method to handle model events.
     */
    protected static function booted()
    {
        static::deleting(function ($boardMember) {
            $boardMember->media()->each(function ($media) {
                $media->delete();
            });
        });
    }
}
