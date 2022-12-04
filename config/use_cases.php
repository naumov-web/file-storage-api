<?php

use App\Enums\UseCaseSystemNamesEnum;
use App\UseCases\Role\CreateRoleUseCase;

return [
    'mapping' => [
        UseCaseSystemNamesEnum::CREATE_ROLE => CreateRoleUseCase::class
    ]
];
