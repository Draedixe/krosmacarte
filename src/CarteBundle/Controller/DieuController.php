<?php
/**
 * Created by PhpStorm.
 * User: Draedixe
 * Date: 08/01/2017
 * Time: 21:02
 */

namespace CarteBundle\Controller;


use CarteBundle\Entity\Dieu;
use CarteBundle\Entity\FondCarte;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DieuController extends Controller
{

    public function creationDieuAction()
    {
        $dieu = new Dieu();
        $formBuilder = $this->createFormBuilder($dieu)
            ->add('nom', 'text',array('label'=>'Nom du dieu : '));
        $form = $formBuilder->getForm();
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
        }
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dieu);
            $em->flush();
            return $this->redirect($this->generateUrl('liste_dieux',array()));
        }
        return $this->render('CarteBundle:Formulaires:creer_dieu.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function affichageListeDieuxAction()
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('CarteBundle:Dieu');
        $dieux = $repository->findAll();
        return $this->render('CarteBundle:Affichages:liste_dieux.html.twig', array(
            'dieux' => $dieux
        ));
    }
}