<?php

namespace App\DataFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture 
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordEncoder)
    {
    }

    public function load(ObjectManager $manager): void
    {


        $userList = [
            [
                'Username' => 'AD',
                'email' => 'ad@hotmail.com',
                'password' => 'password',
                'roles' => ['ROLE_USER'],
            ],
        ];

        foreach ($userList as $userItem) {
            $user = new User();
            $user->setUserName($userItem['Username']);
            $user->setEmail($userItem['email']);
            $user->setRoles($userItem['roles']);
            $user->setPassword($this->passwordEncoder->hashPassword($user, $userItem['password']));
            $manager->persist($user);
        }
        $manager->flush();
        // // silver gold pink red blue white black green
    }
}