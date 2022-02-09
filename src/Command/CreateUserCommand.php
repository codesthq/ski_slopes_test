<?php

namespace App\Command;

use App\Event\CreateUserCommandExecutedEvent;
use App\EventListener\CreateUserCommandExecutedListener;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcher;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';
    protected static $defaultDescription = 'Creates a new user with admin privileges.';
    protected $listener;

    public function __construct(CreateUserCommandExecutedListener $listener)
    {
        $this->listener = $listener;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('username', InputArgument::REQUIRED, 'Username')
            ->addArgument('password', InputArgument::REQUIRED, 'Password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');

        $dispatcher = new EventDispatcher();
        $event = new CreateUserCommandExecutedEvent($username, $password);

        $dispatcher->addListener('create_user_command.executed', [$this->listener, 'onCreateUserCommandExecuted']);
        $dispatcher->dispatch($event, CreateUserCommandExecutedEvent::NAME);

        $io->success('Create user command executed event has been dispatched.');

        return Command::SUCCESS;
    }
}
