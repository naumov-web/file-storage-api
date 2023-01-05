<?php

namespace App\Models\Link;

use App\Models\BaseDBModel;

/**
 * Class Model
 * @package App\Models\Link
 *
 * @property int $id
 * @property int $file_id
 * @property int $type_id
 * @property string $code
 * @property string|null $expired_at
 * @property boolean $is_enabled
 * @property int $opens_count
 */
final class Model extends BaseDBModel
{
    /**
     * Table name for model
     * @var string
     */
    protected $table = 'links';
}
