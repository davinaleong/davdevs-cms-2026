<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'post_type' => $this->post_type?->value ?? $this->post_type,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content_md' => $this->content_md,
            'status' => $this->status,
            'published_at' => $this->published_at?->toISOString(),
            'likes_count' => $this->likes_count ?? 0,
            'meta' => $this->whenLoaded('meta', fn () => [
                'meta_title' => $this->meta?->meta_title,
                'meta_description' => $this->meta?->meta_description,
                'canonical_url' => $this->meta?->canonical_url,
                'og_image' => $this->meta?->og_image,
                'json_ld' => $this->meta?->json_ld,
            ]),
            'blocks' => $this->whenLoaded('blocks', fn () => $this->blocks->map(fn ($block) => [
                'id' => $block->id,
                'type' => $block->type,
                'position' => $block->position,
                'payload' => $block->payload,
            ])->all()),
            'tool' => $this->whenLoaded('tool', fn () => [
                'component_name' => $this->tool?->component_name,
                'bundle_path' => $this->tool?->bundle_path,
                'props' => $this->tool?->props,
                'is_active' => $this->tool?->is_active,
            ]),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
