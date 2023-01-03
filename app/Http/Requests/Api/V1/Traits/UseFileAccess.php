<?php

namespace App\Http\Requests\Api\V1\Traits;

use App\Models\User;
use App\Models\File;

/**
 * Trait UseFileAccess
 * @package App\Http\Requests\Api\V1\Traits
 */
trait UseFileAccess
{
    /**
     * Check file access
     *
     * @param File\Model|null $file
     * @return bool
     */
    protected function checkFileAccess(?File\Model $file): bool
    {
        /**
         * @var User\Model $user
         */
        $user = auth()->user();

        if ($file && $user) {
            return $file->user_owner_id === $user->id;
        }

        return true;
    }
}
