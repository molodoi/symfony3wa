<?php

namespace Wa\BackBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Wa\BackBundle\Repository\GroupeRepository;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Wa\BackBundle\Form\Type\TelType;
use Wa\BackBundle\Form\Type\GenderType;

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
            //->add('gender',  new GenderType()
            ->add('gender',  'gender'
                /*, array(
                'choices'  => array('0' => 'Homme', '1' => 'Femme'),
                )*/
            )
            ->add('address', 'text')
            ->add('phone', new TelType())
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
            ->add('agree', 'checkbox',
                array(
                    "mapped" => false // permet d'ajouter un champ non mappé de l'entité User
                )
            )
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA,
            array(
                $this, 'editUser'
            )
        );
    }

    public function editUser(FormEvent $event)
    {
        $user = $event->getData(); // objet user
        $form = $event->getForm(); // le formulaire

        // Si j'ai un utilisateur et que l'id de l'utilisateur existe =
        // je suis entrain de faire une modification
        if ($user && $user->getId())
        {
            $form->remove('login');
        }
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