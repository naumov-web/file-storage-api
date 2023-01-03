<?php

namespace App\Gateways\File;

use App\Gateways\Contracts\IFileGatewayInterface;
use App\Models\Common\DTO\FilePathDTO;

/**
 * Class LocalGateway
 * @package App\Gateways\File
 */
final class LocalGateway implements IFileGatewayInterface
{

    /**
     * @inheritDoc
     */
    public function saveContent(string $name, string $content): FilePathDTO
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

        $result = new FilePathDTO();
        $result->path = $path;
        $result->fullPath = storage_path($path);

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function delete(string $path): void
    {
        @unlink(storage_path($path));
    }
}
