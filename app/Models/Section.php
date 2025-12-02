<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'page_id',
        'type',
        'sub_title',
        'title',
        'details',
        'component_type',
        'order',
        'include_contact_cards',
        'section_has_image',
        'section_image_first',
        'has_cta_buttons',
        'section_has_map',
        'sliding_hero_section',
        'section_has_bg',
        'section_background_type',
        'section_background_color',
        'section_style',
        'map_link',
        'active',
    ];
}
