<?php

use App\Models\Link\Enums\TypesEnum;

return [
    'linkTypes' => [
        [
            'id' => TypesEnum::PERMANENT,
            'name' => 'Permanent'
        ],
        [
            'id' => TypesEnum::TEMPORARY,
            'name' => 'Temporary'
        ],
    ]
];
