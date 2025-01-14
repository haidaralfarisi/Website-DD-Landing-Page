<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function posts()
    {
        return $this->hasMany(Post::class, 'unit_id', 'id');
    }

    public function categories()
    {
        return $this->hasMany(Categories::class, 'unit_id', 'id');
    }

    public function slider()
    {
        return $this->hasMany(Slider::class, 'unit_id', 'id');
    }

    public function video()
    {
        return $this->hasMany(Video::class, 'unit_id', 'id');
    }


    public function user()
    {
        return $this->hasMany(User::class, 'unit_id', 'id');
    }

    public function achievement()
    {
        return $this->hasMany(User::class, 'unit_id', 'id');
    }

}
