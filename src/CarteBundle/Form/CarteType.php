<?php

namespace CarteBundle\Form;

use CarteBundle\Entity\Carte;
use CarteBundle\Entity\Extension;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarteType extends AbstractType
{
    private $createur;
    private $extension;

    function __construct($createur,$extension) {
        $this->createur = $createur;
        $this->extension = $extension;

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Carte::class,
            'createur' => null,
            'extension' => null
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $extension = $this->extension;
        $createur = $this->createur;

        $builder
            ->add('nom', 'text',array('label'=>'Nom de la carte : '))
            ->add('cout', 'integer',array('label'=>'Coût de la carte : '))
            ->add('pouvoir', 'text',array('label'=>'Pouvoir de la carte : '))
            ->add('image', 'text',array('label'=>'Image de la carte : '))
            ->add('type', 'choice',array(
                'mapped' => false,
                'expanded' => true,
                'multiple' => false,
                'choices' => array('sort' => "Sort", 'crea' => "Creature"),
            ))
            ->add('dieu', EntityType::class, array(
                'class' => 'CarteBundle:Dieu',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nom', 'ASC');
                },
                'choice_label' => 'nom',
            ))
        ;
        $formModifier = function (FormInterface $form, $type = null) {
            if(strcmp($type,"crea") == 0) {
                $form->add('pdv', 'integer', array('mapped' => false))
                    ->add('atk', 'integer', array('mapped' => false))
                    ->add('atk', 'integer', array('mapped' => false))
                    ->add('classe', 'text', array('mapped' => false));
            }
        };
        if($extension == false){
            $builder->add('extension', EntityType::class, array(
                'class' => 'CarteBundle:Extension',
                'query_builder' => function (EntityRepository $er) use ($createur) {
                    return $er->createQueryBuilder('u')
                        ->where('u.createur = :createur')
                        ->setParameter('createur', $createur)
                        ->orderBy('u.nom', 'ASC');
                },
                'choice_label' => 'nom',
            ));
        }
    }
}