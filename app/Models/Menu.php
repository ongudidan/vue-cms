<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    protected $fillable = [
        'page_id',
        'title',
        'type',
        'url',
        'has_children',
        'child_type',
        'component',
        'parent_id',
        'order',
    ];


    protected $casts = [
        'parent_id' => 'integer',
        'has_children' => 'boolean',
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function pages()
    {
        return $this->belongsToMany(Page::class, 'menu_page', 'menu_id', 'page_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order', 'asc');
    }

    public function getChildItems()
    {
        if ($this->child_type === 'pages' || $this->child_type === 'page') {
            return $this->pages;
        }

        if ($this->child_type === 'components' || $this->child_type === 'component') {
            $component = strtolower($this->component);

            if ($component === 'projects') {
                return \App\Models\Project::where('active', true)->get();
            }
            if ($component === 'blogs') {
                return \App\Models\Blog::where('active', true)->get();
            }
            if ($component === 'services') {
                return \App\Models\Service::where('active', true)->get();
            }
            if ($component === 'events') {
                return \App\Models\Event::where('active', true)->get();
            }
        }

        return $this->children;
    }
}
