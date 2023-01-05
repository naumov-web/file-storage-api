<?php

namespace App\UseCases\Handbook;

use App\Models\Handbook\DTO\HandbooksDTO;
use App\UseCases\BaseUseCase;

/**
 * Class GetHandbooksUseCase
 * @package App\UseCases\Handbook
 */
final class GetHandbooksUseCase extends BaseUseCase
{
    /**
     * Handbook DTO instance
     * @var HandbooksDTO
     */
    private HandbooksDTO $result;

    /**
     * Get result instance
     *
     * @return HandbooksDTO
     */
    public function getResult(): HandbooksDTO
    {
        return $this->result;
    }

    /**
     * @inheritDoc
     */
    protected function getInputDTOClass(): ?string
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $this->result = new HandbooksDTO();
        $this->result->linkTypes = config('handbooks.linkTypes');
    }
}
