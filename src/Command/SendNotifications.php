<?php
namespace App\Command;

use App\Service\MailerService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: "subscription:send_notifications")]
class SendNotifications extends Command
{
    private $mailerService;
    protected static $defaultDescription = 'Send notifications.';


    public function __construct(MailerService $mailerService)
    {
        $this->mailerService=$mailerService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command allows you to send a notifications...')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('');
        $this->mailerService->sendEmail();
        return Command::SUCCESS;
    }
}