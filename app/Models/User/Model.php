<?php

namespace App\Models\User;

use App\Models\BaseDBModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Model
 * @package App\Models\User
 *
 * @property-read int $id
 * @property string $email
 * @property string $password
 * @property string $name
 * @property string|null $confirmation_code
 */
final class Model extends BaseDBModel
{
    /**
     * Table name for model
     * @var string
     */
    protected $table = 'users';

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
}
