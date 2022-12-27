<?php

use App\Enums\UseCaseSystemNamesEnum;
use App\UseCases\Role\CreateRoleUseCase;
use App\UseCases\User\AuthorizeUserUseCase;
use App\UseCases\User\CreateUserUseCase;
use App\UseCases\User\GetUserUseCase;

return [
    'mapping' => [
        UseCaseSystemNamesEnum::CREATE_ROLE => CreateRoleUseCase::class,
        UseCaseSystemNamesEnum::CREATE_USER => CreateUserUseCase::class,
        UseCaseSystemNamesEnum::AUTHORIZE_USER => AuthorizeUserUseCase::class,
        UseCaseSystemNamesEnum::GET_USER => GetUserUseCase::class,
    ]
];
