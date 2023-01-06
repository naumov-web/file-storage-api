<?php

namespace App\Models\File\Composers;

use App\Models\BaseDBModel;
use App\Models\Common\Composers\BaseDTOComposer;
use App\Models\File\DTO\FileDTO;
use App\Models\Link\DTO\LinkDTO;
use App\Models\Role\DTO\RoleDTO;
use Illuminate\Foundation\Auth\User as Authentication;

/**
 * Class FileDTOComposer
 * @package App\Models\File\Composers
 */
final class FileDTOComposer extends BaseDTOComposer
{

    /**
     * @inheritDoc
     */
    function getDTOClass(): string
    {
        return FileDTO::class;
    }

    /**
     * Get DTO from model
     *
     * @param BaseDBModel|Authentication $model
     * @return FileDTO
     */
    public function getFromModel(BaseDBModel|Authentication $model): FileDTO
    {
        /**
         * @var FileDTO $result
         */
        $result = parent::getFromModel($model);

        if ($model->relationLoaded('links')) {
            $result->links = [];

            foreach ($model->links as $link) {
                $dto = new LinkDTO();
                $dto->fillFromModel($link);

                $result->links[] = $dto;
            }
        }

        return $result;
    }
}
