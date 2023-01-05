<?php

namespace App\Models\Link\Composers;

use App\Models\Common\Composers\BaseDTOComposer;
use App\Models\Link\DTO\LinkDTO;

/**
 * Class LinkDTOComposer
 * @package App\Models\Link\Composers
 */
final class LinkDTOComposer extends BaseDTOComposer
{

    /**
     * @inheritDoc
     */
    function getDTOClass(): string
    {
        return LinkDTO::class;
    }
}
