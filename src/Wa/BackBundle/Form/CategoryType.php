<?php

namespace Wa\BackBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text')
            ->add('description', 'textarea')
            ->add('dateCreated', 'date',
                array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy'
                )
            )

            ->add('active', 'checkbox',
                array(
                    'label'    => 'Activer la catégorie',
                    'required' => true,
                )
            )
            ->add('position')
        ;
        //Le bouton submit est à ajouter de préférence en static dans les vues
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wa\BackBundle\Entity\Category'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wa_backbundle_category';
    }
}
