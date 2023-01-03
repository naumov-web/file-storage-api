<?php

namespace App\Models\File;

use App\Models\BaseDBModel;

/**
 * Class Model
 * @package App\Models\File
 *
 * @property-read int $id
 * @property int $user_owner_id
 * @property string $name
 * @property string $mime
 * @property int $size
 * @property string $path
 * @property string|null $sha1
 * @property string|null $description
 */
final class Model extends BaseDBModel
{
    /**
     * Table name for model
     * @var string
     */
    protected $table = 'files';
}
