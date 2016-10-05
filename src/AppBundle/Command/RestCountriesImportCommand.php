<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RestCountriesImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('countries:import')
            // the short description shown while running "php bin/console list"
            ->setDescription('Imports Countries from Rest Countries Endpoint')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp("This command allows you to import and update countries");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $importer = $this->getContainer()->get('countries.importer');

        $importer->import();
    }
}