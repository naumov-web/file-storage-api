<?php

namespace App\UseCases\File\InputDTO;

use App\UseCases\Common\DTO\BaseUseCaseDTO;

/**
 * Class GetFileByCodeInputDTO
 * @package App\UseCases\File\InputDTO
 */
final class GetFileByCodeInputDTO extends BaseUseCaseDTO
{
    /**
     * Link code value
     * @var string
     */
    public string $linkCode;
}
