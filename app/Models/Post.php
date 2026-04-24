<?php

namespace App\Models;

use App\Enums\PostType;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends BaseModel
{
    /** @use HasFactory<PostFactory> */
    use HasFactory, SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'post_type',
        'slug',
        'excerpt',
        'content_md',
        'status',
        'published_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'post_type' => PostType::class,
            'published_at' => 'datetime',
        ];
    }

    public function meta(): HasOne
    {
        return $this->hasOne(PostMeta::class);
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(PostBlock::class)->orderBy('position');
    }

    public function tool(): HasOne
    {
        return $this->hasOne(Tool::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')->whereNotNull('published_at');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
