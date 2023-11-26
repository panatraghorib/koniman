<?php

namespace App\Models\Blog;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = null;

    protected $fillable = [
        "name",
        "slug",
        "description",
        "group_name",
        "image",
        "meta_title",
        "meta_description",
        "meta_keyword",
        "order",
        "status",
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function __construct($attributes = [])
    {

        $prefix = config("apptra.database.prefix");
        $this->table = $prefix . "categories";
        parent::__construct($attributes);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }

    protected function posts(): HasMany
    {
        return $this->hasMany(Post::class, "category_id", "id");
    }
}
