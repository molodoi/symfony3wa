<?php


namespace Wa\BackBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wa\BackBundle\Entity\User;


class CreateCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('mattmatt:user:create')
            ->setDescription('Créer un utilisateur.')
            ->setDefinition(array(
                new InputArgument('username', InputArgument::REQUIRED, 'username'),
                new InputArgument('password', InputArgument::REQUIRED, 'password'),
                new InputArgument('email', InputArgument::OPTIONAL, 'email'),
            ));
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username   = $input->getArgument('username');
        $password   = $input->getArgument('password');
        $email   = $input->getArgument('email');



        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $user = new User();

        $factory = $this->getContainer()->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);

        $user->setLogin($username);
        $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
        $user->setEmail($email);

        $em->persist($user);
        $em->flush();

        $output->writeln(sprintf('Créer <comment>%s</comment>', $username));

    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('username')) {
            $username = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a username:',
                function($username) {
                    if (empty($username)) {
                        throw new \Exception('Username NE PEUT PAS ÊTRE VIDE');
                    }

                    return $username;
                }
            );
            $input->setArgument('username', $username);
        }

        if (!$input->getArgument('password')) {
            $password = $this->getHelper('dialog')->askHiddenResponseAndValidate(
                $output,
                'Please choose a password:',
                function($password) {
                    if (empty($password)) {
                        throw new \Exception('Password can not be empty');
                    }

                    return $password;
                }
            );
            $input->setArgument('password', $password);
        }
    }
}