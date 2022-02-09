<?php

namespace App\EventListener;

use App\Entity\User;
use App\Event\CreateUserCommandExecutedEvent;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserCommandExecutedListener
{
    protected $doctrine;
    protected $passwordHasher;

    public function __construct(ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher)
    {
        $this->doctrine = $doctrine;
        $this->passwordHasher = $passwordHasher;
    }

    public function onCreateUserCommandExecuted(CreateUserCommandExecutedEvent $event, )
    {
        $user = new User();
        $user->setUsername($event->getUsername());
        $user->setRoles(['ROLE_ADMIN']);

        
        $hashedPassword = $this->passwordHasher->hashPassword($user, $event->getPassword());
        $user->setPassword($hashedPassword);

        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($user);

        $entityManager->flush();
    }
}