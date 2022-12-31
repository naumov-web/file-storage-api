<?php

namespace App\Models\User;

use Illuminate\Foundation\Auth\User as Authentication;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/**
 * Class Model
 * @package App\Models\User
 *
 * @property-read int $id
 * @property string $email
 * @property string $password
 * @property string $name
 * @property string|null $confirmation_code
 *
 * @property Collection $roles
 */
final class Model extends Authentication implements JWTSubject
{
    /**
     * Table name for model
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * User roles relation
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            \App\Models\Role\Model::class,
            'user_roles',
            'user_id',
            'role_id'
        );
    }

    /**
     * Get role system names list
     *
     * @return array
     */
    public function getRoleSystemNames(): array
    {
        return $this->roles->pluck('system_name')->toArray();
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
