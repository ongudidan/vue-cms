<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Partner extends Model
{
    protected $fillable = [
        'name',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Get all media for the partner.
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
        static::deleting(function ($partner) {
            $partner->media()->each(function ($media) {
                $media->delete();
            });
        });
    }
}
