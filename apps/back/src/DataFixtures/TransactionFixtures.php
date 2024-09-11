<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TransactionFixtures extends Fixture
{
    public function __construct() {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new Transaction();
        $user->setTransactionDate('2024-09-11 03:26:29');
        $user->setUserId(2);
        $user->setLatitude('48.8498° N');
        $user->setLongitude('2.3550° E');
        $user->setAmount(250.00);
        $user->setPaymentLabel('TD10JPVNW0');
        $user->setLocalization('La Tour d\'Argent');

        $manager->persist($user);
        $manager->flush();
    }
}
