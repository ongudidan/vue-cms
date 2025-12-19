<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Service extends Model
{

    protected $fillable = [
        'title',
        'slug',
        'details',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Get all media for the service.
     */
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable')->ordered();
    }


    protected static function booted()
    {
        // Delete all media when service is deleted
        static::deleting(function ($service) {
            $service->media()->each(function ($media) {
                $media->delete();
            });
        });
    }
}
