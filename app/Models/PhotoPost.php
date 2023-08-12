<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoPost extends Model
{
    use HasFactory;

    protected $fillable = [
      'post_id',
      'photo'
    ];

    public function post()
    {
        $this->belongsTo(Post::class);
    }
}
