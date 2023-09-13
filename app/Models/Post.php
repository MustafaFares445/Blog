<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Post extends Model
{
    use HasFactory;

    CONST DEFAULT_STATUS = "pending";
    CONST APPROVED_STATUS = "approved";
    CONST REJECTED_STATUS = "rejected";

    protected $fillable = [
      'author_id',
      'category',
      'title',
      'content',
    ];

    public function author() : BelongsTo
    {
       return $this->belongsTo(Author::class);
    }
    public function categories() : BelongsToMany
    {
        return $this->belongsToMany(Category::class , 'post_categories');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(PhotoPost::class , 'post_id');
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class , 'taggable');
    }
}
