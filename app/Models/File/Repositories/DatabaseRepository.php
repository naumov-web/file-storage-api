<?php

namespace App\Models\File\Repositories;

use App\Models\Common\DTO\ListDTO;
use App\Models\File\Composers\FileDTOComposer;
use App\Models\File\Contracts\IFileDatabaseRepository;
use App\Models\File\DTO\FileDTO;
use App\Models\File\DTO\GetUserFilesDTO;
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

    /**
     * @inheritDoc
     */
    public function delete(FileDTO $dto): void
    {
        Model::query()
            ->where('id', $dto->id)
            ->delete();
    }

    /**
     * @inheritDoc
     */
    public function getFile(int $fileId): ?FileDTO
    {
        /**
         * @var Model|null $model
         */
        $model = Model::query()
            ->where('id', $fileId)
            ->first();

        if (!$model) {
            return null;
        }

        /**
         * @var FileDTO $dto
         */
        $dto = $this->composer->getFromModel($model);

        return $dto;
    }

    /**
     * @inheritDoc
     */
    public function getUserFilesList(GetUserFilesDTO $dto): ListDTO
    {
        $result = new ListDTO();
        $query = Model::query()
            ->where('user_owner_id', $dto->userOwnerId)
            ->with(['links']);
        $result->count = $query->count();

        if (isset($dto->limit) && isset($dto->offset)) {
            $query->limit($dto->limit);
            $query->offset($dto->offset);
        }

        if ($dto->sortBy && $dto->sortDirection) {
            $query->orderBy($dto->sortBy, $dto->sortDirection);
        } else {
            $query->orderBy('id', 'asc');
        }

        $result->items = $this->composer->getFromCollection($query->get());

        return $result;
    }
}
