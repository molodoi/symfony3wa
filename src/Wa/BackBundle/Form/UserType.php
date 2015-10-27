<?php

namespace Wa\BackBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Wa\BackBundle\Repository\GroupeRepository;


class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', 'text')
            ->add('lastname', 'text')
            ->add('email', 'email')
            ->add('login', 'text')
            ->add('password', 'repeated', array(
                'type' => 'password',
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
            ->add('gender', 'choice', array(
                'choices'  => array('0' => 'Homme', '1' => 'Femme'),
            ))
            ->add('address', 'text')
            ->add('phone', 'text')
            ->add('groupes', 'entity',
                array(
                    'class' => 'Wa\BackBundle\Entity\Groupe',
                    'multiple' => true, //Pour du ManyToMany
                    'choice_label' => 'name',
                    'query_builder' => function (GroupeRepository $gr){
                        return $gr->findAllGroupe();
                    },
                    'read_only' => true
                )
            )
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wa\BackBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wa_backbundle_user';
    }
}