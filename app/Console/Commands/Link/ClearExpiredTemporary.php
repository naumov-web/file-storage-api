<?php

namespace App\Console\Commands\Link;

use App\Enums\UseCaseSystemNamesEnum;
use App\UseCases\Common\Exceptions\UseCaseNotFoundException;
use App\UseCases\UseCaseFactory;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class ClearExpiredTemporary
 * @package App\Console\Commands\Links
 */
final class ClearExpiredTemporary extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'link:clear-expired-temporary';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Remove all expired temporary links';

    /**
     * ClearExpiredTemporary constructor
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
        $useCase = $this->useCaseFactory
            ->createUseCase(UseCaseSystemNamesEnum::CLEAR_EXPIRED_TEMPORARY_LINKS);
        $useCase->execute();

        return Command::SUCCESS;
    }
}
