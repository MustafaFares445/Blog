<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'category_id',
      'title',
      'content',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function user()
    {
       return $this->belongsTo(User::class);
    }

    public function tags()
    {
       return $this->hasMany(Tag::class);
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
