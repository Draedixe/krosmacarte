<?php
namespace CarteBundle\Command;


use CarteBundle\Entity\Dieu;
use CarteBundle\Entity\Rarete;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use SplFixedArray;

/**
 * Created by PhpStorm.
 * User: Draedixe
 * Date: 15/01/2017
 * Time: 17:37
 */
class InitialisationCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('initialisation:cartes')
            ->setDescription('Remplir la bdd avec les dieux et raretés')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $output->writeln("===== Creation des Dieux =====");

        $newDieux = new SplFixedArray(10);
        $newDieux[0] = new Dieu();
        $newDieux[0]->setNom("Iop");
        $newDieux[1] = new Dieu();
        $newDieux[1]->setNom("Eniripsa");
        $newDieux[2] = new Dieu();
        $newDieux[2]->setNom("Xelor");
        $newDieux[3] = new Dieu();
        $newDieux[3]->setNom("Cra");
        $newDieux[4] = new Dieu();
        $newDieux[4]->setNom("Ecaflip");
        $newDieux[5] = new Dieu();
        $newDieux[5]->setNom("Sram");
        $newDieux[6] = new Dieu();
        $newDieux[6]->setNom("Sacrieur");
        $newDieux[7] = new Dieu();
        $newDieux[7]->setNom("Sadida");
        $newDieux[8] = new Dieu();
        $newDieux[8]->setNom("Infinite");
        $newDieux[9] = new Dieu();
        $newDieux[9]->setNom("Neutre");
        foreach($newDieux as $dieu)
        {
            $em->persist($dieu);
            $output->writeln($dieu->getNom()." ajoute");
        }
        $output->writeln("===== Creation des Raretes =====");
        $newRarete = new SplFixedArray(4);
        $newRarete[0] = new Rarete();
        $newRarete[0]->setNom("Commune");
        $newRarete[1] = new Rarete();
        $newRarete[1]->setNom("Peu Commune");
        $newRarete[2] = new Rarete();
        $newRarete[2]->setNom("Rare");
        $newRarete[3] = new Rarete();
        $newRarete[3]->setNom("Krosmique");
        foreach($newRarete as $rarete)
        {
            $em->persist($rarete);
            $output->writeln($rarete->getNom()." ajoute");
        }
        $em->flush();

    }
}