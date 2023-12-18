<?php

namespace App\Http\Resources\Blog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
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
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "intro" => $this->intro,
            "content" => $this->content,
            "type" => $this->type,
            "category_id" => $this->category_id,
            "isFeatured" => $this->is_featured,
            "featured_image" => $this->featured_image ? URL::route('image', ['path' => $this->featured_image]) : null,
            "meta_title" => $this->meta_title,
            "meta_keywords" => $this->meta_keywords,
            "meta_description" => $this->meta_description,
            "meta_og_image" => $this->meta_og_image,
            "meta_og_url" => $this->meta_og_url,
            "hits" => $this->hits,
            "order" => $this->order,
            "approval" => $this->approval,
            "approval_formated" => $this->approval_formated,
            "status" => $this->status,
            "status_formated" => $this->status_formated,
            "moderated_by" => $this->moderated_by,
            "moderated_at" => $this->moderated_at,
            // "created_by" => $this->created_by,
            "created_by_name" => $this->created_by_name,
            "created_by_alias" => $this->created_by_alias,
            // "updated_by" => $this->updated_by,
            // "deleted_by" => $this->deleted_by,
            // "published_at" => $this->published_at,
            // "created_at" => $this->created_at,
            // "updated_at" => $this->updated_at,
            // "deleted_at" => $this->deleted_at,
            // "category" => $this->category,
            "category" => new CategoryResource($this->whenLoaded('category')),
        ];
    }
}
