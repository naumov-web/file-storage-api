<?php

namespace App\Models\Invitation\Enums;

/**
 * Class StatusesEnum
 * @package App\Models\Invitation\Enums
 */
final class StatusesEnum
{
    /**
     * Status "Wait"
     * @var int
     */
    public const WAIT = 1;

    /**
     * Status "Accepted"
     * @var int
     */
    public const ACCEPTED = 2;

    /**
     * Status "Expired"
     * @var int
     */
    public const EXPIRED = 3;
}
