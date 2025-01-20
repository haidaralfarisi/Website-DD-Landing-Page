<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user() // Ganti 'users' menjadi 'user'
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function postcategory() // Ganti 'categories' menjadi 'category'
    {
        return $this->belongsTo(PostCategories::class, 'post_category_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
}
