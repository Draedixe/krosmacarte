<?php
/**
 * Created by PhpStorm.
 * User: Draedixe
 * Date: 08/01/2017
 * Time: 20:58
 */

namespace CarteBundle\Controller;

use CarteBundle\Entity\Creature;
use CarteBundle\Entity\Note;
use CarteBundle\Form\CarteType;
use CarteBundle\Entity\Carte;
use CarteBundle\Entity\Extension;
use Doctrine\ORM\EntityRepository;
use SplFileInfo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CarteController extends Controller
{

    public function creationCarteAction()
    {
        $repositoryE = $this->getDoctrine()
            ->getManager()
            ->getRepository('CarteBundle:Extension');
        $repositoryD = $this->getDoctrine()
            ->getManager()
            ->getRepository('CarteBundle:Dieu');
        $repositoryR = $this->getDoctrine()
            ->getManager()
            ->getRepository('CarteBundle:Rarete');

        $extensions = $repositoryE->findBy(array('createur' => $this->getUser()));
        $dieux = $repositoryD->findAll();
        $raretes = $repositoryR->findAll();
        return $this->render('CarteBundle:Formulaires:creer_carte.html.twig', array(
            'dieux' => $dieux,
            'extensions' => $extensions,
            'raretes' => $raretes,
        ));
    }

    public function creationCarteExtAction($idExt)
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('CarteBundle:Extension');
        $extension = $repository->find($idExt);

        $repositoryD = $this->getDoctrine()
            ->getManager()
            ->getRepository('CarteBundle:Dieu');
        $repositoryR = $this->getDoctrine()
            ->getManager()
            ->getRepository('CarteBundle:Rarete');
        $dieux = $repositoryD->findAll();
        $raretes = $repositoryR->findAll();
        return $this->render('CarteBundle:Formulaires:creer_carte.html.twig', array(
            'dieux' => $dieux,
            'extension' => $extension,
            'raretes' => $raretes,
        ));
    }

    public function validerCarteAction()
    {

        $request = $this->get('request');
        $carte = new Carte();
        $nom = $request->get("nom");
        $cout = $request->get("cout");
        $dieu = $request->get("dieu");
        $pouvoir = $request->get("pouvoir");
        $image = $request->get("image");
        $rarete = $request->get("rarete");
        $extensionN = $request->get("extension");
        $type = $request->get("type");

        $info = new SplFileInfo($image);
        if(strcmp ($info->getExtension(),"png") == 0 || strcmp ($info->getExtension(),"jpeg") == 0 || strcmp ($info->getExtension(),"jpg") == 0){
            $repositoryE = $this->getDoctrine()
                ->getManager()
                ->getRepository('CarteBundle:Extension');
            $repositoryD = $this->getDoctrine()
                ->getManager()
                ->getRepository('CarteBundle:Dieu');
            if(strcmp ($dieu,"Infinite") != 0){
                $repositoryR = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('CarteBundle:Rarete');
                $rarete = $repositoryR->findOneBy(array('nom' => $rarete));
                $carte->setRarete($rarete);
            }else{
                $type = $request->get("niveau");
            }
            $extension = $repositoryE->find(substr($extensionN,10));
            $dieu = $repositoryD->findOneBy(array('nom' => $dieu));


            if($nom != null && $cout != null && $dieu != null && $pouvoir != null && $image != null && $extension != null)
            {
                if($extension->getCreateur() == $this->getUser()){
                    $carte->setNom(substr($nom,0,18));
                    $carte->setCout($cout);
                    $carte->setDieu($dieu);
                    $carte->setPouvoir($pouvoir);
                    $carte->setImage($image);
                    $carte->setExtension($extension);
                    $carte->setDate(new \DateTime());
                    $em = $this->getDoctrine()->getManager();
                    if($type != null){
                        if(strcmp ($type,"crea") == 0 || is_numeric($type)){
                            $creature = new Creature();
                            $atk = $request->get("atk");
                            $pm = $request->get("pm");
                            $pdv = $request->get("pdv");
                            $classe = $request->get("classe");
                            if($atk != null && $pm != null && $pdv != null && $classe != null)
                            {
                                $creature->setAtk($atk);
                                $creature->setPm($pm);
                                $creature->setPdv($pdv);
                                $creature->setClasse(substr($classe,0,24));
                                $em->persist($creature);
                                $carte->setCreature($creature);
                            }

                        }
                    }

                    $em->persist($carte);
                    $em->flush();

                    $imagesDir = $this->get('kernel')->getRootDir() . '/../web/images/';
                    $creationDir = $this->get('kernel')->getRootDir() . '/../web/creations/';
                    $urlFont = $this->get('kernel')->getRootDir() . '/../web/fonts/';
                    $carte->genererCartePNG($imagesDir,$creationDir,$urlFont,$type);


                    return $this->redirect($this->generateUrl('affichage_extension',array('idExt' => $extension->getId())));
                }

            }

        }
        return $this->redirect($this->generateUrl('creation_carte',array()));

    }
    public function voterCarteAction($idCarte){
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('CarteBundle:Carte');
        $carte = $repository->find($idCarte);

        if($carte->getExisteVote($this->getUser())){
            $carte->removeVote($this->getUser());
        }else{
            $carte->addVote($this->getUser());
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($carte);
        $em->flush();
        return $this->redirect($this->generateUrl('affichage_extension', array('idExt' => $carte->getExtension()->getId())));
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
            $extension->setDate(new \DateTime());
            $note = new Note();
            $em->persist($note);
            $extension->setNote($note);
            $em->persist($extension);
            $em->flush();
            return $this->redirect($this->generateUrl('liste_extension_perso',array()));
        }
        return $this->render('CarteBundle:Formulaires:creer_extension.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function affichageListeCartesAction($page)
    {
        $cartes = $this->getDoctrine()->getRepository('CarteBundle:Carte')->findAll();



        $nbLien = count($cartes);
        if ($nbLien%10==0)
        {
            $nbPages=(int)($nbLien/10);
        }
        else
        {
            $nbPages=(int)($nbLien/10)+1;
        }
        if ($nbPages==0)
        {
            $nbPages=1;
        }
        return $this->render('CarteBundle:Affichages:liste_cartes.html.twig', array(
            'cartes' => array_slice($cartes, 10*($page-1), 10),
            'nbPages' => $nbPages,
            'currentPage' => $page
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

    public function supprimerCarteAction($idCarte)
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('CarteBundle:Carte');
        $carte = $repository->find($idCarte);

        if($carte != null) {
            $extension = $carte->getExtension();
            if ($extension->getCreateur() == $this->getUser()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($carte);
                $em->flush();

            }
            return $this->redirect($this->generateUrl('affichage_extension', array('idExt' => $extension->getId())));
        }
        else{
            return $this->redirect($this->generateUrl('liste_extension_perso',array()));
        }

    }
    public function supprimerExtensionAction($idExt)
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('CarteBundle:Extension');
        $extension = $repository->find($idExt);

        if($extension != null) {
            if ($extension->getCreateur() == $this->getUser()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($extension);
                $em->flush();

            }
        }
        return $this->redirect($this->generateUrl('liste_extension_perso',array()));
    }

    public function modifierCarteAction($idCarte){
        //TODO
    }
}