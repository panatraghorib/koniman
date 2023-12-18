<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = null;
    protected $fillable = [
        'key',
        'value',
        'type',
        'display_name'
    ];

    public function __construct($attributes = [])
    {

        $prefix = config('apptra.database.prefix');
        $this->table = $prefix . 'settings';
        parent::__construct();
    }

    /**
     * Store a value for setting to database
     */
    public static function add(string $key, string $val, string $type = 'string')
    {
        if (self::has($key)) {
            return self::set($key, $val, $type);
        }

        return self::create([
            'key' => $key,
            'value' => $val,
            'type' => $type,
            'display_name' => $key,
        ]) ? $val : false;
    }

    /**
     * Set a value untuk setting cache
     */
    public static function set($key, $val, $type = 'string')
    {
        if ($setup = self::getAllSetups()->where('key', $key)->first()) {
            $setup->update([
                'key' => $key,
                'value' => $val,
                'type' => $type,
                'display_name' => $key,
            ]) ? $val : false;
        }
    }

    /**
     * get setting data value
     */
    public static function get($key, $default = null)
    {
        if (self::has($key)) {
            $setup = self::getAllSetups()->where('key', $key)->first();

            return self::castVal($setup->value, $setup->type);
        }



        return self::getDefaultVal($key, $default);
    }

    // get all Setup
    public static function getAllSetups()
    {
        return Cache::rememberForever('setups.all', fn () => self::all());
    }

    /**
     * cast value into respective type
     */
    public static function castVal($val, $castTo)
    {
        switch ($castTo) {
            case 'int':
            case 'integer':
                return intval($val);
                break;

            case 'bool':
            case 'boolean':
                return boolval($val);
                break;

            default:
                return $val;
        }
    }

    /**
     * get default value from config if no value passed
     */
    private static function getDefaultVal($key, $default)
    {
        return is_null($default) ? self::getDefaultValField($key) : $default;
    }

    /**
     *  Get default value for a setting
     */
    public static function getDefaultValField($field)
    {
        return self::getDefinedSetupFields()->pluck('value', 'name')
            ->get($field);
    }

    /**
     * get all setup field from config
     * returns a new Collection instance with the items currently in the collection
     */
    public static function getDefinedSetupFields()
    {
        // pluck: pluck method retrieves all of the values for a given key
        // flatten: flattens a multi-dimensional collection into a single dimentions
        return collect(config('settings'))->pluck('elements')->flatten(1);
    }

    /**
     * Get the validation rules for setting fields.
     */
    public static function getValidationRules()
    {
        return self::getDefinedSetupFields()->pluck('rules', 'name')
            ->reject(fn ($val) => is_null($val))->toArray();
    }

    /**
     * check existing setting
     */
    public static function has($key)
    {
        return (bool) self::getAllSetups()->whereStrict('key', $key)->count();
    }

    /**
     * remove setting
     */
    public static function remove($key)
    {
        if (self::has($key)) {
            return self::whereName($key)->delete();
        }

        return false;
    }

    /**
     * get Data Type of Setting
     */
    public static function getDataType($field)
    {
        $typ = self::getDefinedSetupFields()
            ->pluck('data', 'name')
            ->get($field);
        return is_null($typ) ? 'string' : $typ;
    }

    /**
     * Flush the cache
     */
    public static function flushCache()
    {
        Cache::forget('setups.all');
    }

    /**
     * the booting model
     */
    public static function boot()
    {
        parent::boot();

        static::updated(function () {
            self::flushCache();
        });

        static::saving(
            function () {
                self::flushCache();
            }
        );

        static::created(function () {
            self::flushCache();
        });

        static::deleted(function () {
            self::flushCache();
        });
    }
}
