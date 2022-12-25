<?php

namespace App\UseCases\User;

use App\UseCases\BaseUseCase;
use App\UseCases\User\InputDTO\AuthorizeUserInputDTO;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthorizeUserUseCase
 * @package App\UseCases\User
 */
final class AuthorizeUserUseCase extends BaseUseCase
{
    /**
     * Token prefix
     * @var string
     */
    public const TOKEN_PREFIX = 'Bearer ';

    /**
     * Token value
     * @var string
     */
    private string $token;

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return AuthorizeUserInputDTO::class;
    }

    /**
     * @inheritDoc
     * @throws AuthorizationException
     */
    public function execute(): void
    {
        $credentials = [
            'email' => $this->inputDto->email,
            'password' => $this->inputDto->password
        ];

        $token = Auth::attempt($credentials);

        if (!$token) {
            throw new AuthorizationException();
        }

        $this->token = self::TOKEN_PREFIX . $token;
    }

    /**
     * Get token value
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}
