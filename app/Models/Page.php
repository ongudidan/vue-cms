<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'published',
        'content',
        'is_homepage',
        'theme_id',
    ];

    protected $casts = [
        'content' => 'array',
        'published' => 'boolean',
        'is_homepage' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        // Ensure only one page can be set as homepage
        static::saving(function ($page) {
            if ($page->is_homepage) {
                // Unset is_homepage for all other pages
                static::where('id', '!=', $page->id)
                    ->where('is_homepage', true)
                    ->update(['is_homepage' => false]);
            }
        });
    }

    public function scopeHomepage($query)
    {
        return $query->where('is_homepage', true)->where('published', true);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }
}
