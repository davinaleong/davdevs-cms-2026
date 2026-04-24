<?php

namespace App\Models;

use Database\Factories\PostMetaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostMeta extends BaseModel
{
    /** @use HasFactory<PostMetaFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'post_id',
        'meta_title',
        'meta_description',
        'canonical_url',
        'og_image',
        'json_ld',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'json_ld' => 'array',
        ];
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
