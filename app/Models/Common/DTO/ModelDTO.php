<?php

namespace App\Models\Common\DTO;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ModelDTO
 * @package App\Models\Common\InputDTO
 */
abstract class ModelDTO
{
    /**
     * Get fields list
     *
     * @return array
     */
    protected function getFields(): array
    {
        $result = [];
        $reflection = new \ReflectionClass($this);

        foreach ($reflection->getProperties() as $property) {
            $result[] = $property->getName();
        }

        return $result;
    }

    /**
     * Fill model InputDTO instance
     *
     * @param Model $model
     * @return void
     */
    public function fillFromModel(Model $model): void
    {
        $fields = $this->getFields();

        foreach ($fields as $field) {
            if (isset($model->{$field})) {
                $this->{$field} = $model->{$field};
            }
        }
    }
}
