<?php

namespace App\UseCases;

use App\UseCases\Common\DTO\BaseUseCaseDTO;

/**
 * Class BaseUseCase
 * @package App\UseCases
 */
abstract class BaseUseCase
{
    /**
     * Input DTO instance
     * @var BaseUseCaseDTO
     */
    protected BaseUseCaseDTO $inputDto;

    /**
     * Get available input InputDTO class name
     *
     * @return string|null
     */
    abstract protected function getInputDTOClass(): ?string;

    /**
     * Execute use case
     *
     * @return void
     */
    abstract public function execute(): void;

    /**
     * Set input DTO instance
     *
     * @param BaseUseCaseDTO $inputDto
     * @return void
     */
    public function setInputDTO(BaseUseCaseDTO $inputDto): void
    {
        $this->inputDto = $inputDto;
    }
}
