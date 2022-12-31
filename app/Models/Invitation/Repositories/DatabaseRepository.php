<?php

namespace App\Models\Invitation\Repositories;

use App\Models\Invitation\Composers\InvitationDTOComposer;
use App\Models\Invitation\Contacts\IInvitationDatabaseRepository;
use App\Models\Invitation\DTO\InvitationDTO;
use App\Models\Invitation\Enums\StatusesEnum;
use App\Models\Invitation\Model;
use Illuminate\Support\Collection;

/**
 * Class DatabaseRepository
 * @package App\Models\Invitation\Repositories
 */
final class DatabaseRepository implements IInvitationDatabaseRepository
{
    /**
     * DatabaseRepository constructor
     * @param InvitationDTOComposer $composer
     */
    public function __construct(private InvitationDTOComposer $composer) {}

    /**
     * @inheritDoc
     */
    public function create(InvitationDTO $dto): InvitationDTO
    {
        /**
         * @var Model $model
         */
        $model = Model::query()->create([
            'email' => $dto->email,
            'name' => $dto->name,
            'password' => $dto->password,
            'status_id' => $dto->statusId,
            'expired_at' => $dto->expiredAt,
            'invitation_code' => $dto->invitationCode,
        ]);

        $dto->id = $model->id;

        return $dto;
    }

    /**
     * @inheritDoc
     */
    public function getInvitations(): Collection
    {
        $models = Model::query()
            ->where('status_id', StatusesEnum::WAIT)
            ->get();

        return $this->composer->getFromCollection($models);
    }
}
