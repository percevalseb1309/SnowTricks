<?php

namespace SnowTricksBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class VideoType extends AbstractType
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
        $builder->add('url', TextType::class, array(
            'attr' => array('placeholder' => 'Paste video URL in the field'),
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
            'data_class' => 'SnowTricksBundle\Entity\Video'
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
        // return 'snowtricksbundle_video';
        return 'VideoType';
    }


}
