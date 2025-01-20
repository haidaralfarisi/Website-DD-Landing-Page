<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategories extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function posts()
    {
        return $this->hasMany(Post::class, 'post_category_id', 'id');
    }
    public function units()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
}
