<?php

namespace App\API\Infrastructure\CLI\Call;

use App\API\Application\Bus\Command\Call\ProcessCalls as ProcessCallsCommand;
use Broadway\CommandHandling\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProcessCalls extends Command
{
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:call:process');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @uses \App\API\Application\Bus\Command\Call\ProcessCallsHandler::handleProcessCalls */
        $this->commandBus->dispatch(ProcessCallsCommand::fromArray([]));

        $output->writeln('Call report generated succesfully');
    }
}
