<?php
namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
#[AsCommand(name: "subscription:update_price")]
class UpdatePrice extends Command
{
    protected static $defaultDescription = 'Update price.';

    protected function configure(): void
    {
        $this
            // сообщение помощи команды, отображаемое при запуске команды с опцией "--help"
            ->setHelp('This command allows you to update a prices...')
        ;
    }

}