<?php
namespace App\Command;

use App\Repository\SubscriptionsRepository;
use ResponseService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
#[AsCommand(name: "subscription:update_price")]
class UpdatePrice extends Command
{
    protected static $defaultDescription = 'Update price.';
    private $subscriptionsRepository;
    private $responseService;

    public function __construct(SubscriptionsRepository $subscriptionsRepository,
                                ResponseService $responseService)
    {
        $this->subscriptionsRepository = $subscriptionsRepository;
        $this->responseService=$responseService;

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
        $subs = $this->subscriptionsRepository->findAll();
        $total = 0;
        foreach ($subs as $sub) {
            $url = $sub->getUrl();
            $price = $this->responseService->checkResponse($url, 200,"application/json; charset=utf-8", 'price');
            $this->subscriptionsRepository->updateSelectedPrice($sub->getId(), $price);
            echo $url . " - " . $price . "\n";
            $total += 1;
        }

        echo "Total: $total\n";
        return Command::SUCCESS;
    }

}