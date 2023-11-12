<?php

namespace App\Models\Blog;

use Carbon\Carbon;
use App\Models\Blog\Category;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;
    use LogsActivity;

    protected $table = null;

    public function __construct($attributes = [])
    {
        $prefix = config("apptra.database.prefix");
        $this->table = $prefix . 'posts';
        parent::__construct($attributes);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName($this->table);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(15)
            ->usingSeparator('-')
            ->doNotGenerateSlugsOnUpdate();
    }

    protected function metaTitle(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => empty($value)
                ? trim(ucwords($this->name)) : trim(ucwords($value))
        );
    }

    protected function metaDescription(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => empty($value)
                ? trim(ucwords($this->name)) : trim($value)
        );
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', '=', 'Yes')
            ->where('status', '=', '1')
            ->where('published_at', '<=', Carbon::now());
    }

    public function scopePublished($query)
    {
        return $query->where('status', '=', '1')
            ->where('published_at', '<=', Carbon::now());
    }

    /**
     * Get the list of Recently Published Articles.
     *
     * @param [type] $query [description]
     * @return [type] [description]
     */
    public function scopeRecentlyPublished($query)
    {
        return $query->where('status', '=', '1')
            ->whereDate('published_at', '<=', Carbon::today()->toDateString())
            ->orderBy('published_at', 'desc');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
