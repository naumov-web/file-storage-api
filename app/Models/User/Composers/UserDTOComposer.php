<?php

namespace App\Models\User\Composers;

use App\Models\BaseDBModel;
use App\Models\Common\Composers\BaseDTOComposer;
use App\Models\Common\DTO\ModelDTO;
use App\Models\Role\DTO\RoleDTO;
use App\Models\User\DTO\UserDTO;
use Illuminate\Foundation\Auth\User as Authentication;

/**
 * Class UserDTOComposer
 * @package App\Models\User\Composers
 */
final class UserDTOComposer extends BaseDTOComposer
{

    /**
     * @inheritDoc
     */
    function getDTOClass(): string
    {
        return UserDTO::class;
    }

    /**
     * Get DTO from model
     *
     * @param BaseDBModel|Authentication $model
     * @return UserDTO
     */
    public function getFromModel(BaseDBModel|Authentication $model): UserDTO
    {
        $result = parent::getFromModel($model);

        if ($model->relationLoaded('roles')) {
            $result->roles = [];

            foreach ($model->roles as $role) {
                $dto = new RoleDTO();
                $dto->fillFromModel($role);

                $result->roles[] = $dto;
            }
        }

        return $result;
    }
}
