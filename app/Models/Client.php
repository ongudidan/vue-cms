<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Client extends Model
{
    protected $fillable = [
        'name',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Get all media for the client.
     */
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable')->ordered();
    }
}
