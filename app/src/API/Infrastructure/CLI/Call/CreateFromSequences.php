<?php

namespace App\API\Infrastructure\CLI\Call;

use App\API\Application\Bus\Command\Calls\GenerateCalls;
use Broadway\CommandHandling\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateFromSequences extends Command
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:call:generate');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @uses \App\API\Application\Bus\Command\Calls\GenerateCallsHandler::handleGenerateCalls */
        $this->commandBus->dispatch(GenerateCalls::fromArray([]));

        $output->writeln('Calls generated succesfully');
    }
}
