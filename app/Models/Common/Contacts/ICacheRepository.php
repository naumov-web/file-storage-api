<?php

namespace App\Models\Common\Contacts;

/**
 * Interface ICacheRepository
 * @package App\Models\Common\Contacts
 */
interface ICacheRepository
{
    /**
     * @return string
     */
    public function getVersionNumber(): string;

    /**
     * Get directory key value
     *
     * @return string
     */
    public function getDirectoryKey(): string;
}
