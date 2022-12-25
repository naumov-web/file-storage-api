<?php

namespace App\Models\Common\Composers;

use App\Models\BaseDBModel;
use App\Models\Common\DTO\ModelDTO;
use Illuminate\Foundation\Auth\User as Authentication;
use Illuminate\Support\Collection;

/**
 * Class BaseDTOComposer
 * @package App\Models\Common\Composers
 */
abstract class BaseDTOComposer
{
    /**
     * Get InputDTO class name
     *
     * @return string
     */
    abstract function getDTOClass(): string;

    /**
     * Get collection of InputDTO from other collection
     *
     * @param Collection $items
     * @return Collection
     */
    public function getFromCollection(Collection $items): Collection
    {
        $result = [];
        $className = $this->getDTOClass();

        foreach ($items as $item) {
            /**
             * @var ModelDTO $resultItem
             */
            $resultItem = new $className();
            $resultItem->fillFromModel($item);

            $result[] = $resultItem;
        }

        return collect($result);
    }

    /**
     * Get DTO instance from model
     *
     * @param BaseDBModel|Authentication $model
     * @return ModelDTO
     */
    public function getFromModel(BaseDBModel|Authentication $model): ModelDTO
    {
        $className = $this->getDTOClass();
        /**
         * @var ModelDTO $result
         */
        $result = new $className();
        $result->fillFromModel($model);

        return $result;
    }
}
