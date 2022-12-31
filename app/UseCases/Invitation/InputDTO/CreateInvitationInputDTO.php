<?php

namespace App\UseCases\Invitation\InputDTO;

use App\UseCases\Common\DTO\BaseUseCaseDTO;

/**
 * Class CreateInvitationInputDTO
 * @package App\UseCases\Invitation\InputDTO
 */
final class CreateInvitationInputDTO extends BaseUseCaseDTO
{
    /**
     * Email value
     * @var string
     */
    public string $email;

    /**
     * Password value
     * @var string|null
     */
    public string|null $password = null;

    /**
     * Name value
     * @var string
     */
    public string $name;

    /**
     * Expired at value
     * @var string
     */
    public string $expiredAt;
}
