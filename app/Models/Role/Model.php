<?php

namespace App\Models\Role;

use App\Models\BaseDBModel;

/**
 * Class Model
 * @package App\Models\Role
 *
 * @property-read int $id
 * @property string|null $system_name
 * @property string $name
 */
final class Model extends BaseDBModel
{
    /**
     * Table name for model
     * @var string
     */
    protected $table = 'roles';
}
