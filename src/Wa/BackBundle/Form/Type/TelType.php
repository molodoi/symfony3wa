<?php
namespace Wa\BackBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TelType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(array(
            'attr' => array(
                'class' => 'telephone form-control'
            )
        ));

    }

    public function getName()
    {
        return 'tel';

    }

    public function getParent()
    {
        return 'text';

    }
}