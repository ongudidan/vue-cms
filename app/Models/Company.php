<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
  protected $fillable = [
        'code',
        'name',
        'email',
        'primary_phone',
        'secondary_phone',
        'country',
        'state',
        'city',
        'website',
        'physical_address',
        'postal_address',
        'tax_identification_pin',
        'logo',
        'footer_logo',
        'favicon',
        'x_profile',
        'fb_profile',
        'ig_profile',
        'tiktok_profile',
        'pinterest_profile',
        'youtube_profile',
        'has_footer_logo',
    ];
}
