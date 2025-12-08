<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'details',
        'tags',
        'status',
        'active',
    ];

    protected $casts = [
        'tags' => 'json',
        'active' => 'boolean',
    ];

    /**
     * Get all media for the project.
     */
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable')->ordered();
    }
}
