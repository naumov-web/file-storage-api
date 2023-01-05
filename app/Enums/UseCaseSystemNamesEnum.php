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

    /**
     * Use case "Confirm invitation"
     * @var string
     */
    public const CONFIRM_INVITATION = 'confirm_invitation';

    /**
     * Use case "Create user file"
     * @var string
     */
    public const CREATE_USER_FILE = 'create_user_file';

    /**
     * Use case "Delete user file"
     * @var string
     */
    public const DELETE_USER_FILE = 'delete_user_file';

    /**
     * Use case "Get handbooks"
     * @var string
     */
    public const GET_HANDBOOKS = 'get_handbooks';

    /**
     * Use case "Create file link"
     * @var string
     */
    public const CREATE_FILE_LINK = 'create_file_link';
}
