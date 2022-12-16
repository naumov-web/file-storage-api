<?php

namespace App\Models\User\Repositories;

use App\Models\User\Contracts\IUserCacheRepository;
use App\Models\User\Contracts\IUserRepository;
use App\Models\User\DTO\UserDTO;
use Illuminate\Support\Facades\Cache;

/**
 * Class CacheRepository
 * @package App\Models\User\Repositories
 */
final class CacheRepository implements IUserCacheRepository
{
    public function __construct(private IUserRepository $databaseRepository)
    {
    }

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
        return 'roles/v' . $this->getVersionNumber();
    }

    /**
     * @inheritDoc
     */
    public function getUserByEmail(string $email): ?UserDTO
    {
        $keyName = $this->getDirectoryKey() . '/by-email/' . $email;
        $item = Cache::get($keyName);

        if ($item) {
            return $item;
        } else {
            $item = $this->databaseRepository->getUserByEmail($email);

            if ($item) {
                Cache::put($keyName, $item);

                return $item;
            }
        }

        return null;
    }
}
