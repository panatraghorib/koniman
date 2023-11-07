<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Database\Factories\UserFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = null;

    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'mobile',
        'gender',
        'date_of_birth',
        'organization_id',
        'avatar',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_of_birth' => 'date',
    ];

    public function __construct(array $attributes = [])
    {
        $prefix = config('apptra.database.prefix');
        $this->table = $prefix . 'users';
        parent::__construct($attributes);
    }

    protected function dateOfBirth(): Attribute
    {
        return Attribute::make(
            fn ($value) => ($value !== null)
                ? (new \DateTime($value))->format('Y-m-d')
                : "",
            fn ($value) => (new \DateTime($value))->format('Y-m-d')
        );
    }
}
