<?php

namespace Wa\BackBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Wa\BackBundle\Repository\CategoryRepository;
use Wa\BackBundle\Repository\MarqueRepository;


class ProductType extends AbstractType
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
            ->add('price', 'number')
            ->add('quantity', 'integer')
            ->add('dateCreated', 'date',
                array(
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy'
                )
            )
            ->add('category'
                , 'entity',
                array(
                    'class' => 'Wa\BackBundle\Entity\Category',
                    'choice_label' => 'title',
                    'query_builder' => function (CategoryRepository $cr){
                        return $cr->getCategoriesOrderByPosition();
                    },
                    'read_only' => true
                )
            )
            ->add('marque'
                , 'entity',
                array(
                    'class' => 'Wa\BackBundle\Entity\Marque',
                    'choice_label' => 'title',
                    'query_builder' => function (MarqueRepository $mr){
                        return $mr->getMarqueOrderByTitleAsc();
                    },
                    'read_only' => true
                )
            )
            ;
            //Le bouton submit est à ajouter de préférence en static dans les vues
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wa\BackBundle\Entity\Product'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wa_backbundle_product';
    }
}
