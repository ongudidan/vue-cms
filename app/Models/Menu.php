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
}
