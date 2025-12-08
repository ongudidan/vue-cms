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
        // Delete old images that were removed during update
        static::updating(function ($model) {
            if ($model->isDirty('images')) {
                $oldImages = $model->getOriginal('images');
                $newImages = $model->images;

                if ($oldImages) {
                    $oldImages = is_string($oldImages) ? json_decode($oldImages, true) : $oldImages;
                    $newImages = is_string($newImages) ? json_decode($newImages, true) : $newImages;

                    // Find images that were removed
                    $imagesToDelete = array_diff($oldImages ?? [], $newImages ?? []);

                    // Delete removed images from storage
                    foreach ($imagesToDelete as $image) {
                        if ($image && \Illuminate\Support\Facades\Storage::disk('public')->exists($image)) {
                            \Illuminate\Support\Facades\Storage::disk('public')->delete($image);
                        }
                    }
                }
            }
        });

        // Delete all images when service is deleted
        static::deleting(function ($model) {
            if ($model->images) {
                $images = is_string($model->images) ? json_decode($model->images, true) : $model->images;

                foreach ($images ?? [] as $image) {
                    if ($image && \Illuminate\Support\Facades\Storage::disk('public')->exists($image)) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($image);
                    }
                }
            }
        });
    }
}
