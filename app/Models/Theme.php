<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Theme extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'path',
        'is_active',
        'config',
        'description',
        'version',
        'author',
    ];

    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the pages that use this theme.
     */
    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    /**
     * Scope a query to only include active themes.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the currently active theme.
     */
    public static function getActive(): ?self
    {
        return static::where('is_active', true)->first();
    }

    /**
     * Get the theme configuration.
     */
    public function getConfig(?string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->config;
        }

        return data_get($this->config, $key, $default);
    }

    /**
     * Get available sections for this theme.
     */
    public function getSections(): array
    {
        return $this->getConfig('sections', []);
    }

    /**
     * Get the theme's view path.
     */
    public function getViewPath(string $view): string
    {
        return "themes.{$this->slug}.views.{$view}";
    }

    /**
     * Get the theme's asset path.
     */
    public function getAssetPath(string $asset): string
    {
        return "themes/{$this->slug}/assets/{$asset}";
    }
}
