<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\BaseController;
use Illuminate\Contracts\View\Factory;

/**
 * Class DocsController
 * @package App\Http\Controllers\Web
 */
final class DocsController extends BaseController
{
    /**
     * Get swagger file content
     *
     * @return string
     */
    public function swaggerFile() : string
    {
        return file_get_contents(base_path('docs/swagger.yaml'));
    }

    /**
     * Render view with docs
     *
     * @return Factory
     */
    public function form()
    {
        return view('docs.form');
    }
}
