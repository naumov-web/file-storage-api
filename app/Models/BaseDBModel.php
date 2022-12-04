<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseDBModel
 * @package App\Models
 */
abstract class BaseDBModel extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];
}
