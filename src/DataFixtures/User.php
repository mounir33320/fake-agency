<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class User extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new \App\Entity\User();
        $user
            ->setUsername("test")
            ->setPassword($this->encoder->encodePassword($user,"test"))
            ->setRoles(["ROLE_ADMIN"]);

        $manager->persist($user);
        $manager->flush();
    }
}
