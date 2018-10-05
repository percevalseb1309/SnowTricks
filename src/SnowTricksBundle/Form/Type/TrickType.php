<?php

namespace SnowTricksBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TrickType extends AbstractType
{
    /**
     * @access public
     * @param FormBuilderInterface $builder 
     * @param array $options 
     * @return void
     * 
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('pictures', CollectionType::class, array(
            // 'entry_options' => array('label' => false),
            'label'        => 'Pictures',
            'entry_type'   => PictureType::class,
            'allow_add'    => true,
            'allow_delete' => true,
            'prototype'    => true,
            'required'     => false,
            'by_reference' => false,
            // 'delete_empty' => true,
            'attr'         => array('class' => 'pictures-collection'),
        ))
        ->add('videos', CollectionType::class, array(
            'label'        => 'Videos',
            'entry_type'   => VideoType::class,
            'allow_add'    => true,
            'allow_delete' => true,
            'prototype'    => true,
            'required'     => false,
            'by_reference' => false,
            'attr'         => array('class' => 'videos-collection'),
        ))
        ->add('name', TextType::class)
        ->add('description',TextareaType::class, array(
            'attr' => ['rows' => '5'],
        ))
        ->add('tricksGroup', EntityType::class, array(
            'class'        => 'SnowTricksBundle:TricksGroup',
            'choice_label' => 'name',
            'expanded'     => false,
            'multiple'     => false,
            'placeholder'  => 'Choose a Group',
        ))
        ->add('submit', SubmitType::class, array(
            'label' => 'Submit'
        ));
    }

    /**
     * @access public
     * @param OptionsResolver $resolver 
     * @return void
     * 
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SnowTricksBundle\Entity\Trick'
        ));
    }

    /**
     * @access public
     * @return string
     * 
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        // return 'snowtricksbundle_trick';
        return 'TrickType';
    }
}
