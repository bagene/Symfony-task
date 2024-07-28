<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Console\Commands;

use App\Shared\Application\Response\ErrorResponse;
use App\User\Domain\Service\UserImporterServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'import:users', description: 'Import Users from randomuser.me')]
final class UserImportCommand extends Command
{
    public function __construct(private readonly UserImporterServiceInterface $userImporterService)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $response = $this->userImporterService->handle();

        if ($response instanceof ErrorResponse) {
            $output->writeln($response->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
