<?php

namespace Wa\BackBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Wa\BackBundle\Form\DataTransformer\TagTransformer;
use Wa\BackBundle\Form\TagWithoutMarqueType;

class BrandType extends AbstractType
{

    private $em;

    public function __construct($doctrine){
        $this->em = $doctrine;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', 'text');
            /*->add('tags', 'entity'
                , array(
                'multiple' => true,
                'class' => 'WaBackBundle:Tag',
                'choice_label' => 'title'
            ))*/
        $builder->add(
            $builder->create('tags','collection',array(
                'type' => new TagWithoutMarqueType(),
                'allow_add' => true
            ))->addModelTransformer(new TagTransformer($this->em))
        );
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wa\BackBundle\Entity\Brand'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wa_backbundle_brand';
    }
}
