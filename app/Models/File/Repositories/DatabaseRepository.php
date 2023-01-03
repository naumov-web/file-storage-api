<?php

namespace App\Models\File\Repositories;

use App\Models\File\Composers\FileDTOComposer;
use App\Models\File\Contracts\IFileDatabaseRepository;
use App\Models\File\DTO\FileDTO;
use App\Models\File\Model;
use Illuminate\Support\Collection;

/**
 * Class DatabaseRepository
 * @package App\Models\File\Repositories
 */
final class DatabaseRepository implements IFileDatabaseRepository
{
    /**
     * DatabaseRepository constructor
     * @param FileDTOComposer $composer
     */
    public function __construct(private FileDTOComposer $composer) {}

    /**
     * @inheritDoc
     */
    public function create(FileDTO $dto): FileDTO
    {
        /**
         * @var Model $model
         */
        $model = Model::query()->create([
            'user_owner_id' => $dto->userOwnerId,
            'name' => $dto->name,
            'mime' => $dto->mime,
            'size' => $dto->size,
            'path' => $dto->path,
            'sha1' => $dto->sha1,
            'description' => $dto->description,
        ]);

        $dto->id = $model->id;

        return $dto;
    }

    /**
     * @inheritDoc
     */
    public function getUserFiles(int $userOwnerId): Collection
    {
        $items = Model::query()
            ->where('user_owner_id', $userOwnerId)
            ->get();

        return $this->composer->getFromCollection($items);
    }
}
