<?php

use App\Enums\UseCaseSystemNamesEnum;
use App\UseCases\File\CreateUserFileUseCase;
use App\UseCases\File\DeleteUserFileUseCase;
use App\UseCases\Handbook\GetHandbooksUseCase;
use App\UseCases\Invitation\ConfirmInvitationUseCase;
use App\UseCases\Invitation\CreateInvitationUseCase;
use App\UseCases\Link\CreateFileLinkUseCase;
use App\UseCases\Role\CreateRoleUseCase;
use App\UseCases\User\AuthorizeUserUseCase;
use App\UseCases\User\CreateUserUseCase;
use App\UseCases\User\GetUserUseCase;
use App\UseCases\User\UpdateUserUseCase;

return [
    'mapping' => [
        UseCaseSystemNamesEnum::CREATE_ROLE => CreateRoleUseCase::class,
        UseCaseSystemNamesEnum::CREATE_USER => CreateUserUseCase::class,
        UseCaseSystemNamesEnum::AUTHORIZE_USER => AuthorizeUserUseCase::class,
        UseCaseSystemNamesEnum::GET_USER => GetUserUseCase::class,
        UseCaseSystemNamesEnum::UPDATE_USER => UpdateUserUseCase::class,
        UseCaseSystemNamesEnum::CREATE_INVITATION => CreateInvitationUseCase::class,
        UseCaseSystemNamesEnum::CONFIRM_INVITATION => ConfirmInvitationUseCase::class,
        UseCaseSystemNamesEnum::CREATE_USER_FILE => CreateUserFileUseCase::class,
        UseCaseSystemNamesEnum::DELETE_USER_FILE => DeleteUserFileUseCase::class,
        UseCaseSystemNamesEnum::GET_HANDBOOKS => GetHandbooksUseCase::class,
        UseCaseSystemNamesEnum::CREATE_FILE_LINK => CreateFileLinkUseCase::class
    ]
];
