<?php

namespace App\Models\Invitation\DTO;

use App\Models\Common\DTO\ModelDTO;

/**
 * Class InvitationDTO
 * @package App\Models\Invitation\DTO
 */
final class InvitationDTO extends ModelDTO
{
    /**
     * User id value
     * @var int
     */
    public int $id;

    /**
     * User email value
     * @var string
     */
    public string $email;

    /**
     * User password value
     * @var string|null
     */
    public string|null $password;

    /**
     * User name value
     * @var string
     */
    public string $name;

    /**
     * Invitation code value
     * @var string
     */
    public string $invitationCode;

    /**
     * Status id value
     * @var int
     */
    public int $statusId;

    /**
     * Expired at value
     * @var string
     */
    public string $expiredAt;
}
