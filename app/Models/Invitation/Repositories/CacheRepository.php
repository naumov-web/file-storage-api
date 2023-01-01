<?php

namespace App\Models\Invitation\Repositories;

use App\Models\Invitation\Contacts\IInvitationCacheRepository;
use App\Models\Invitation\Contacts\IInvitationRepository;
use App\Models\Invitation\DTO\InvitationDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Class CacheRepository
 * @package App\Models\Invitation\Repositories
 */
final class CacheRepository implements IInvitationCacheRepository
{
    /**
     * CacheRepository constructor
     * @param IInvitationRepository $databaseRepository
     */
    public function __construct(private IInvitationRepository $databaseRepository) {}

    /**
     * @inheritDoc
     */
    public function getVersionNumber(): string
    {
        return '1';
    }

    /**
     * @inheritDoc
     */
    public function getDirectoryKey(): string
    {
        return 'invitations/v' . $this->getVersionNumber();
    }

    /**
     * @inheritDoc
     */
    public function resetAllInvitationsCache(): void
    {
        $keyName = $this->getDirectoryKey() . '/index';
        Cache::forget($keyName);
    }

    /**
     * @inheritDoc
     */
    public function getInvitationByEmail(string $email): InvitationDTO|null
    {
        $items = $this->getInvitations();

        foreach ($items as $item) {
            /**
             * @var InvitationDTO $item
             */
            if ($item->email === $email) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Get invitations collection
     *
     * @return Collection
     */
    public function getInvitations(): Collection
    {
        $keyName = $this->getDirectoryKey() . '/index';
        $items = Cache::get($keyName);

        if ($items) {
            return $items;
        } else {
            $items = $this->databaseRepository->getInvitations();
            Cache::put(
                $keyName,
                $items
            );

            return $items;
        }
    }

    /**
     * @inheritDoc
     */
    public function getInvitationByCode(string $code): InvitationDTO|null
    {
        $items = $this->getInvitations();

        foreach ($items as $item) {
            /**
             * @var InvitationDTO $item
             */
            if ($item->invitationCode === $code) {
                return $item;
            }
        }

        return null;
    }
}
