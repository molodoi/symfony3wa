<?php
namespace Wa\BackBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MyCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('mycommand:test')
            ->setDescription('Permet de faire une commande de test')
            ->addArgument('quantity', InputArgument::OPTIONAL, 'Veuillez entrer la quantité')
            ->addOption('color', 'c', InputOption::VALUE_NONE, 'Permet de metre de la couleur')
            ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Récupération de doctrine
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $quantity = $input->getArgument('quantity');

        $produits = $em->getRepository('WaBackBundle:Product')->findProductByQuanity($quantity);


        //$prenom = $input->getArgument('quantity');
        //$optionColor = $input->getOption('color');
        $output->writeln($produits);


    }
}