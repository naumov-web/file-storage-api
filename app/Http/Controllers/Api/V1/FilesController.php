<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UseCaseSystemNamesEnum;
use App\Http\Controllers\BaseController;
use App\Models\Link\Exceptions\LinkDoesntExistException;
use App\Models\Link\Exceptions\LinkExpiredException;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\File\GetFileByCodeUseCase;
use App\UseCases\File\InputDTO\GetFileByCodeInputDTO;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class FilesController
 * @package App\Http\Controllers\Api\V1
 */
final class FilesController extends BaseController
{
    /**
     * Download file by link code
     *
     * @param string $linkCode
     * @return Application|RedirectResponse|Redirector|BinaryFileResponse
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function download(string $linkCode): Application|RedirectResponse|Redirector|BinaryFileResponse
    {
        $inputDto = new GetFileByCodeInputDTO();
        $inputDto->linkCode = $linkCode;

        /**
         * @var GetFileByCodeUseCase $useCase
         */
        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::GET_FILE_BY_CODE);
        $useCase->setInputDTO($inputDto);
        try {
            $useCase->execute();
        } catch (LinkDoesntExistException) {
            return redirect($this->getRedirectToNotFoundLink());
        } catch (LinkExpiredException) {
            return redirect($this->getRedirectToForbiddenLink());
        }

        return response()->download($useCase->getFullFilePath());
    }
}
