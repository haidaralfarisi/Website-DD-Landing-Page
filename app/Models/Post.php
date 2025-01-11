<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'meta_keyword',
        'meta_description',
        'meta_thumbnail',
        'image',
        'description',
        'publish_date',
        'status',
        'unit',
        'user_id',
    ];
}
