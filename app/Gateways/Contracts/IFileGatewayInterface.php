<?php

namespace App\Gateways\Contracts;

use App\Models\Common\DTO\FilePathDTO;

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
     * @return FilePathDTO
     */
    public function saveContent(string $name, string $content): FilePathDTO;

    /**
     * Delete file by path
     *
     * @param string $path
     * @return void
     */
    public function delete(string $path): void;
}
