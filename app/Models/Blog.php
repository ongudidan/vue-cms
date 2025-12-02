<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'tags',
        'date',
        'details',
        'active',
        'user_id',
    ];

    protected $casts = [
        'tags' => 'json',
        'active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all media for the blog.
     */
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable')->ordered();
    }

    protected static function booted()
    {
        // Auto-set user_id to the currently logged-in user on create
        static::creating(function ($model) {
            if (Auth::check() && !$model->user_id) {
                $model->user_id = Auth::id();
            }
        });
    }
}
