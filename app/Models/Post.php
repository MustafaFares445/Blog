<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    CONST DEFAULT_STATUS = "pending";
    protected $fillable = [
      'author_id',
      'category',
      'title',
      'content',
    ];

    public function user() : BelongsTo
    {
       return $this->belongsTo(User::class);
    }
    public function categories() : BelongsToMany
    {
        return $this->belongsToMany(Category::class , "post_category");
    }

    public function tags()
    {
       return $this->belongsToMany(Tag::class , "post_tag");
    }

    public function photos(): HasMany
    {
        return $this->hasMany(PhotoPost::class);
    }
}
