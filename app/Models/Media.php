<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $fillable = [
        'mediable_type',
        'mediable_id',
        'file_path',
        'file_name',
        'mime_type',
        'size',
        'order',
        'alt_text',
    ];

    protected $casts = [
        'size' => 'integer',
        'order' => 'integer',
    ];

    protected $appends = ['url'];

    /**
     * Get the parent mediable model (Service, Project, etc.).
     */
    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the public URL for the media file.
     */
    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn () => '/media-file/' . $this->file_path,
        );
    }


    /**
     * Scope to order media by the order column.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Boot method to handle model events.
     */
    protected static function booted()
    {
        // Delete the file from storage when media record is deleted
        static::deleting(function ($media) {
            if ($media->file_path && Storage::disk('public')->exists($media->file_path)) {
                Storage::disk('public')->delete($media->file_path);
            }
        });
    }
}
