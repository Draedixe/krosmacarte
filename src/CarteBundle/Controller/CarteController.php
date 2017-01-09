<?php
/**
 * Created by PhpStorm.
 * User: Draedixe
 * Date: 08/01/2017
 * Time: 20:58
 */

namespace CarteBundle\Controller;

use CarteBundle\Entity\Carte;
use CarteBundle\Entity\Extension;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CarteController extends Controller
{
    public function creationCarteAction()
    {
        $carte = new Carte();
        $formBuilder = $this->createFormBuilder($carte)
            ->add('nom', 'text',array('label'=>'Nom de la carte : '))
            ->add('cout', 'integer',array('label'=>'Coût de la carte : '))
            ->add('pouvoir', 'text',array('label'=>'Pouvoir de la carte : '))
            ->add('image', 'text',array('label'=>'Image de la carte : '))
            ->add('dieu', EntityType::class, array(
                'class' => 'CarteBundle:Dieu',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nom', 'ASC');
                },
                'choice_label' => 'nom',
            ))
            ->add('extension', EntityType::class, array(
                'class' => 'CarteBundle:Extension',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.createur = :createur')
                        ->setParameter('createur', $this->getUser())
                        ->orderBy('u.nom', 'ASC');
                },
                'choice_label' => 'nom',
            ));
        $form = $formBuilder->getForm();
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
        }
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($carte);
            $em->flush();
            return $this->redirect($this->generateUrl('liste_cartes',array()));
        }
        return $this->render('CarteBundle:Formulaires:creer_carte.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function creationExtensionAction()
    {
        $extension = new Extension();
        $formBuilder = $this->createFormBuilder($extension)
            ->add('nom', 'text',array('label'=>"Nom de l'extension : "));
        $form = $formBuilder->getForm();
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
        }
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $extension->setCreateur($this->getUser());
            $em->persist($extension);
            $em->flush();
            return $this->redirect($this->generateUrl('liste_cartes',array()));
        }
        return $this->render('CarteBundle:Formulaires:creer_extension.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function affichageListeCartesAction()
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('CarteBundle:Carte');
        $cartes = $repository->findAll();
        return $this->render('CarteBundle:Affichages:liste_cartes.html.twig', array(
            'cartes' => $cartes
        ));
    }
}