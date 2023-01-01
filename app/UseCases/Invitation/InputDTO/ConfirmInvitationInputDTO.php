<?php

namespace App\UseCases\Invitation\InputDTO;

use App\UseCases\Common\DTO\BaseUseCaseDTO;

/**
 * Class ConfirmInvitationInputDTO
 * @package App\UseCases\Invitation\InputDTO
 */
final class ConfirmInvitationInputDTO extends BaseUseCaseDTO
{
    /**
     * Invitation code value
     * @var string
     */
    public string $code;
}
