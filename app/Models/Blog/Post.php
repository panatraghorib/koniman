<?php

namespace App\Models\Blog;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Blog\Category;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Blog\Presenters\PostPresenter;
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

    use PostPresenter;

    protected $table = null;
    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'published_at' => 'datetime:Y-m-d h:i:s',
        'approval' => 'boolean',
    ];

    protected $appends = [
        'status_formated',
        'approval_formated',
        'created_at_format',
    ];

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

    protected static function boot()
    {
        parent::boot();

        // create a event to happen on creating
        static::creating(function ($table) {
            $table->created_by = Auth::id();
            $table->created_at = Carbon::now();
        });

        // create a event to happen on updating
        static::updating(function ($table) {
            $table->updated_by = Auth::id();
        });

        // create a event to happen on saving
        static::saving(function ($table) {
            $table->updated_by = Auth::id();
        });

        // create a event to happen on deleting
        static::deleting(function ($table) {
            $table->deleted_by = Auth::id();
            $table->save();
        });
    }

    function approvalFormated(): Attribute
    {
        return Attribute::make(
            get: function ($value, array $attributes) {
                if ($attributes['approval'] == false && $attributes['status'] == 1) {
                    return "Butuh Persetujuan Admin";
                }
            }
        );
    }

    protected function metaTitle(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => empty($value)
                ? trim(ucwords($this->name)) : trim(ucwords($value))
        );
    }

    public function createdByAlias(): Attribute
    {

        return Attribute::make(
            set: fn ($value, array $attributes) => empty($value) ? $attributes['created_by_name'] : $value

        );
    }

    protected function metaDescription(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => empty($value)
                ? trim(ucwords($this->name)) : trim($value)
        );
    }


    /**
     * Set the meta meta_og_image
     * If no value submitted use the 'Title'.
     *
     * @param [type]
     */
    public function metaOgImage(): Attribute
    {

        return Attribute::make(
            set: fn ($value) =>
            !empty($value) ? $value
                : (empty($value) && isset($this->featured_image) ? $this->featured_image : null)

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

    /**
     * Get the list of Unapproved Published Articles.
     *
     * @param [type] $query [description]
     * @return [type] [description]
     */
    public function scopeNotApproved($query)
    {
        return $query->where('status', '=', '1')
            ->where('approval', 0)
            ->whereDate('published_at', '<=', Carbon::today()->toDateString())
            ->orderBy('published_at', 'desc');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id')->select(['id', 'name', 'avatar'])->with(['cabor', 'roles']);
    }
}
