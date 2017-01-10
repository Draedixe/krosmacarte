<?php
/**
 * Created by PhpStorm.
 * User: Draedixe
 * Date: 08/01/2017
 * Time: 20:58
 */

namespace CarteBundle\Controller;

use CarteBundle\Form\CarteType;
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
        $form = $this->createForm(new CarteType($this->getUser(),false),$carte);
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
        }
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($carte);
            $em->flush();
            return $this->redirect($this->generateUrl('affichage_extension',array('idExt'=>$carte->getExtension()->getId())));
        }
        return $this->render('CarteBundle:Formulaires:creer_carte.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function creationCarteExtAction($idExt)
    {
        $carte = new Carte();
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('CarteBundle:Extension');
        $extension = $repository->find($idExt);
        $form = $this->createForm(new CarteType($this->getUser(),true),$carte);
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
        }
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $carte->setExtension($extension);
            $em->persist($carte);
            $em->flush();
            return $this->redirect($this->generateUrl('affichage_extension',array('idExt'=>$idExt)));
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

    public function affichageExtensionAction($idExt)
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('CarteBundle:Extension');
        $ext = $repository->find($idExt);
        return $this->render('CarteBundle:Affichages:affichage_extension.html.twig', array(
            'extension' => $ext
        ));
    }

    public function affichageListeExtensionAction()
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('CarteBundle:Extension');
        $extensions = $repository->findAll();
        return $this->render('CarteBundle:Affichages:liste_extensions.html.twig', array(
            'extensions' => $extensions
        ));
    }

    public function affichageListeExtensionPersoAction()
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('CarteBundle:Extension');
        $extensions = $repository->findBy(array('createur' => $this->getUser()));
        return $this->render('CarteBundle:Affichages:liste_extensions.html.twig', array(
            'extensions' => $extensions
        ));
    }
}