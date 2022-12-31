<?php

namespace App\Models\Role\Repositories;

use App\Models\Common\Repositories\BaseDatabaseRepository;
use App\Models\Role\Composers\RoleDTOComposer;
use App\Models\Role\Contracts\IRoleDatabaseRepository;
use App\Models\Role\DTO\RoleDTO;
use App\Models\Role\Model;
use Illuminate\Support\Collection;

/**
 * Class DatabaseRepository
 * @package App\Models\Role\Repositories
 */
final class DatabaseRepository extends BaseDatabaseRepository implements IRoleDatabaseRepository
{
    /**
     * DatabaseRepository constructor
     * @param RoleDTOComposer $dtoComposer
     */
    public function __construct(private RoleDTOComposer $dtoComposer) {}

    /**
     * @inheritDoc
     */
    protected function getModelsClass(): string
    {
        return Model::class;
    }

    /**
     * Get all roles collection
     *
     * @return Collection
     */
    public function getAllRoles(): Collection
    {
        $query = $this->getQuery();

        return $this->dtoComposer->getFromCollection($query->get());
    }

    /**
     * @inheritDoc
     */
    public function create(RoleDTO $dto): RoleDTO
    {
        $query = $this->getQuery();
        $model = $query->create([
            'name' => $dto->name,
            'system_name' => $dto->systemName
        ]);

        $dto->id = $model->id;

        return $dto;
    }
}
