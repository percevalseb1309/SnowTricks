<?php

namespace SnowTricksBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;

class PictureType extends AbstractType
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
        $builder->add('file', FileType::class, array(
            'image_property' => 'webPath',
            // 'label' => false,
            // 'attr'  => array('class' => 'my-position'),
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
            'data_class' => 'SnowTricksBundle\Entity\Picture'
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
        // return 'snowtricksbundle_picture';
        return 'PictureType';
    }
}
