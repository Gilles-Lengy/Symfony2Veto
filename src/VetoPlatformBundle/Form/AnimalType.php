<?php

namespace VetoPlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('nom', 'text')
                ->add('dateNaissance', 'date', array('required' => false))
                ->add('commentaire', 'textarea', array('required' => false))
                ->add('classeAnimal', 'entity', array(
                    'class' => 'VetoPlatformBundle:ClasseAnimal',
                    'property' => 'nom',
                    'multiple' => false))
                ->add('save', 'submit');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'VetoPlatformBundle\Entity\Animal'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'vetoplatformbundle_animal';
    }

}
