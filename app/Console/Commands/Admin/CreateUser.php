<?php

namespace App\Console\Commands\Admin;

use App\Enums\UseCaseSystemNamesEnum;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\UseCaseFactory;
use App\UseCases\User\InputDTO\CreateUserInputDTO;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class CreateUser
 * @package App\Console\Commands\Admin
 */
final class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'admin:create-user';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Create new user';

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
     * @return int
     * @throws UseCaseNotFoundException
     * @throws BindingResolutionException
     */
    public function handle(): int
    {
        $inputDto = new CreateUserInputDTO();
        $inputDto->email = $this->ask('Please, enter user\'s email');
        $inputDto->name = $this->ask('Please, enter user\'s name');
        $inputDto->password = $this->ask('Please, enter user\'s password');
        $inputDto->roleSystemNames =
            $this->ask('Please, enter user\'s roles\' system names, separated by commas');

        $useCase = $this->useCaseFactory->createUseCase(UseCaseSystemNamesEnum::CREATE_USER);
        $useCase->setInputDTO($inputDto);
        $useCase->execute();

        return Command::SUCCESS;
    }
}
