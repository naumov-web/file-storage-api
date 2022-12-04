<?php

namespace App\Console\Commands\Admin;

use App\Enums\UseCaseSystemNamesEnum;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\Role\InputDTO\CreateRoleInputDTO;
use App\UseCases\UseCaseFactory;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use function __;

/**
 * Class CreateRole
 * @package App\Console\Admin
 */
final class CreateRole extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'admin:create-role';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Create new role';

    /**
     * CreateRole constructor
     * @param UseCaseFactory $useCaseFactory
     */
    public function __construct(private UseCaseFactory $useCaseFactory)
    {
        parent::__construct();
    }

    /**
     * Execute console command
     *
     * @throws BindingResolutionException
     * @throws UseCaseNotFoundException
     */
    public function handle(): int
    {
        $inputDto = new CreateRoleInputDTO();
        $inputDto->name = $this->ask(__('messages.please_enter_role_name'));
        $inputDto->systemName = $this->ask(__('messages.please_enter_role_system_name'));

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_ROLE);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        return Command::SUCCESS;
    }
}
