<?php

namespace App\Enums;

/**
 * Class UseCaseSystemNamesEnum
 * @package App\Enums
 */
final class UseCaseSystemNamesEnum
{
    /**
     * Use case "Create role"
     * @var string
     */
    public const CREATE_ROLE = 'create_role';

    /**
     * Use case "Create user"
     * @var string
     */
    public const CREATE_USER = 'create_user';

    /**
     * Use case "Authorize user"
     * @var string
     */
    public const AUTHORIZE_USER = 'authorize_user';

    /**
     * Use case "Get user"
     * @var string
     */
    public const GET_USER = 'get_user';

    /**
     * Use case "Update user"
     * @var string
     */
    public const UPDATE_USER = 'update_user';

    /**
     * Use case "Create invitation"
     * @var string
     */
    public const CREATE_INVITATION = 'create_invitation';
}
