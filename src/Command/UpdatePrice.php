<?php
namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\SubscriptionService;
#[AsCommand(name: "subscription:update_price")]
class UpdatePrice extends Command
{
    protected static $defaultDescription = 'Update price.';
    private $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService=$subscriptionService;

        parent::__construct();
    }
    protected function configure(): void
    {
        $this->setHelp('This command allows you to update a prices...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('');
        $this->subscriptionService->updPrice();
        return Command::SUCCESS;
    }

}