<?php

namespace App\Command;

use App\Repository\SubscriptionsRepository;
use App\Service\MailerService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: "subscription:send_notifications")]
class SendNotifications extends Command
{
    private $mailerService;

    private $subscriptionsRepository;
    protected static $defaultDescription = 'Send notifications.';


    public function __construct(MailerService $mailerService, SubscriptionsRepository $subscriptionsRepository)
    {
        $this->mailerService = $mailerService;

        $this->subscriptionsRepository = $subscriptionsRepository;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command allows you to send a notifications...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('');
        $arr = $this->subscriptionsRepository->findNewUpdatedPrice();
        $send_emails = 0;
        foreach ($arr as $ar) {
            $mailTo = $ar->getUserId()->getEmail();
            $name = $ar->getUserId()->getName();
            $price = $ar->getPrice();
            $result = $this->mailerService->sendEmail($name, $price, $mailTo);
            if ($result === true) $send_emails += 1;
            else echo "Error send email";
        }
        echo "Total: $send_emails\n";
        return Command::SUCCESS;
    }
}