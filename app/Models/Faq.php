<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{

    protected $fillable = [
        'question',
        'answer',
        'parent_id',
        'active',
        'order',
    ];

    protected $casts = [
        'parent_id' => 'integer'
    ];

    // public function determineOrderColumnName(): string
    // {
    //     return 'order';
    // }

    // public function determineParentColumnName(): string
    // {
    //     return '';
    // }
}
