<?php

namespace App\Gateways\File;

use App\Gateways\Contracts\IFileGatewayInterface;
use App\Models\Common\DTO\FileSavingResultDTO;

/**
 * Class LocalGateway
 * @package App\Gateways\File
 */
final class LocalGateway implements IFileGatewayInterface
{

    /**
     * @inheritDoc
     */
    public function saveContent(string $name, string $content): FileSavingResultDTO
    {
        $path = 'files/' . uniqid();
        $dirPath = storage_path($path);

        mkdir(
            $dirPath,
            0777,
            $recursive = true
        );

        $path .= ('/' . $name);

        file_put_contents(
            storage_path($path),
            base64_decode($content)
        );

        $result = new FileSavingResultDTO();
        $result->path = $path;
        $result->fullPath = storage_path($path);
        $result->size = filesize($result->fullPath);
        $result->sha1 = sha1_file($result->fullPath);

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function delete(string $path): void
    {
        @unlink(storage_path($path));
    }

    /**
     * @inheritDoc
     */
    public function getFullPath(string $path): string
    {
        return storage_path($path);
    }
}
