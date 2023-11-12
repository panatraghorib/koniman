<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cabor extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $with = ['users'];


    protected $fillable = [
        'cabor_name',
        'initial',
        'logo',
        'description',
    ];

    protected $table = null;

    public function __construct($attributes = [])
    {
        $prefix = config('apptra.database.prefix');
        $this->table = $prefix . 'cabor';
        parent::__construct($attributes);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'organization_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($cabor) {
            $relationMethods = ['users'];
            foreach ($relationMethods as $relationMethod) {
                if ($cabor->{$relationMethod}->count() > 0) {
                    return false;
                }
            }
        });
    }
}
