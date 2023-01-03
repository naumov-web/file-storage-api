<?php

namespace App\Models\File\Composers;

use App\Models\Common\Composers\BaseDTOComposer;
use App\Models\File\DTO\FileDTO;

/**
 * Class FileDTOComposer
 * @package App\Models\File\Composers
 */
final class FileDTOComposer extends BaseDTOComposer
{

    /**
     * @inheritDoc
     */
    function getDTOClass(): string
    {
        return FileDTO::class;
    }
}
