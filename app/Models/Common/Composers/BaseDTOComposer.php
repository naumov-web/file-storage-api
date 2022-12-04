<?php

namespace App\Models\Common\Composers;

use App\Models\Common\DTO\ModelDTO;
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
}
