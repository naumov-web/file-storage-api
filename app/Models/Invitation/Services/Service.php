<?php

namespace App\Models\Invitation\Services;

use App\Models\Invitation\Contacts\IInvitationCacheRepository;
use App\Models\Invitation\Contacts\IInvitationDatabaseRepository;
use App\Models\Invitation\Contacts\IInvitationService;
use App\Models\Invitation\DTO\InvitationDTO;
use App\Models\Invitation\Enums\StatusesEnum;
use App\Models\Invitation\Exceptions\InvitationForEmailAlreadyExistsException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class Service
 * @package App\Models\Invitation\Services
 */
final class Service implements IInvitationService
{
    /**
     * Password default length
     * @var int
     */
    const PASSWORD_DEFAULT_LENGTH = 8;

    /**
     * Invitation code default length
     * @var int
     */
    const INVITATION_CODE_DEFAULT_LENGTH = 30;

    /**
     * Service constructor
     * @param IInvitationCacheRepository $cacheRepository
     * @param IInvitationDatabaseRepository $databaseRepository
     */
    public function __construct(
        private IInvitationCacheRepository $cacheRepository,
        private IInvitationDatabaseRepository $databaseRepository
    ) {}

    /**
     * @inheritDoc
     * @throws InvitationForEmailAlreadyExistsException
     */
    public function create(InvitationDTO $dto): InvitationDTO
    {
        if ($this->cacheRepository->getInvitationByEmail($dto->email)) {
            throw new InvitationForEmailAlreadyExistsException();
        }

        if (!$dto->password) {
            $dto->password = Str::random(self::PASSWORD_DEFAULT_LENGTH);
        }

        $originPassword = $dto->password;
        $dto->password = Hash::make($dto->password);
        $dto->invitationCode = Str::random(self::INVITATION_CODE_DEFAULT_LENGTH);
        $dto->statusId = StatusesEnum::WAIT;

        $dto = $this->databaseRepository->create($dto);
        $this->cacheRepository->resetAllInvitationsCache();

        $dto->password = $originPassword;

        return $dto;
    }
}
