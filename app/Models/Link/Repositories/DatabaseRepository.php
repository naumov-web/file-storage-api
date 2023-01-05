<?php

namespace App\Models\Link\Repositories;

use App\Models\Link\Composers\LinkDTOComposer;
use App\Models\Link\Contracts\ILinkDatabaseRepository;
use App\Models\Link\DTO\LinkDTO;
use App\Models\Link\Model;
use Illuminate\Support\Collection;

/**
 * Class DatabaseRepository
 * @package App\Models\Link\Repositories
 */
final class DatabaseRepository implements ILinkDatabaseRepository
{
    /**
     * DatabaseRepository constructor
     * @param LinkDTOComposer $composer
     */
    public function __construct(private LinkDTOComposer $composer) {}

    /**
     * @inheritDoc
     */
    public function create(LinkDTO $dto): LinkDTO
    {
        $model = Model::query()->create([
            'file_id' => $dto->fileId,
            'type_id' => $dto->typeId,
            'code' => $dto->code,
            'expired_at' => $dto->expiredAt,
            'is_enabled' => $dto->isEnabled,
            'opens_count' => $dto->opensCount
        ]);

        $dto->id = $model->id;

        return $dto;
    }

    /**
     * @inheritDoc
     */
    public function getLinks(int $fileId): Collection
    {
        return $this->composer->getFromCollection(
            Model::query()
                ->where('file_id', $fileId)
                ->get()
        );
    }
}
