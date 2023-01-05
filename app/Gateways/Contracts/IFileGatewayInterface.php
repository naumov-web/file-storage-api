<?php

namespace App\Gateways\Contracts;

use App\Models\Common\DTO\FileSavingResultDTO;

/**
 * Interface FileGatewayInterface
 * @package App\Gateways\Contracts
 */
interface IFileGatewayInterface
{
    /**
     * Save content to file
     *
     * @param string $name
     * @param string $content
     * @return FileSavingResultDTO
     */
    public function saveContent(string $name, string $content): FileSavingResultDTO;

    /**
     * Delete file by path
     *
     * @param string $path
     * @return void
     */
    public function delete(string $path): void;

    /**
     * Get full path by path
     *
     * @param string $path
     * @return string
     */
    public function getFullPath(string $path): string;
}
