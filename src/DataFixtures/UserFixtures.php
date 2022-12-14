<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        

        $user = new User();
        $user->setEmail('admin@admin.com')
             ->setPassword($this->hasher->hashPassword($user, 'admin'))
             ->setPseudo('admin')
             ->setRoles(['ROLE_ADMIN']);
        
        $manager->persist($user);
        $manager->flush();
    }
}
