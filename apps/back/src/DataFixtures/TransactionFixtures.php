<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Transaction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TransactionFixtures extends Fixture
{
    public function __construct() {
    }

    public function load(ObjectManager $manager): void
    {
        $transaction = new Transaction();
        $transaction->setTransactionDate(new \DateTime());
        $transaction->setUserId('test-user');
        $transaction->setLatitude('48.857399');
        $transaction->setLongitude('2.359078');
        $transaction->setAmount(250.00);
        $transaction->setPaymentLabel('TD10JPVNW0');
        $transaction->setLocalization('L\'As du Fallafel');
        $manager->persist($transaction);

        $transaction = new Transaction();
        $transaction->setTransactionDate(new \DateTime());
        $transaction->setUserId('test-user');
        $transaction->setLatitude('48.854179');
        $transaction->setLongitude('2.332503');
        $transaction->setAmount(250.00);
        $transaction->setPaymentLabel('LKXIDVNK5Q');
        $transaction->setLocalization('');
        $manager->persist($transaction);

        $transaction = new Transaction();
        $transaction->setTransactionDate(new \DateTime());
        $transaction->setUserId('test-user');
        $transaction->setLatitude('48.866089');
        $transaction->setLongitude('2.304284');
        $transaction->setAmount(200.00);
        $transaction->setPaymentLabel('DBBM8MSUEM');
        $transaction->setLocalization('');
        $manager->persist($transaction);

        $transaction = new Transaction();
        $transaction->setTransactionDate(new \DateTime());
        $transaction->setUserId('test-user');
        $transaction->setLatitude('48.871265');
        $transaction->setLongitude('2.362855');
        $transaction->setAmount(250.00);
        $transaction->setPaymentLabel('UL0YJN4IXP');
        $transaction->setLocalization('');
        $manager->persist($transaction);

        $transaction = new Transaction();
        $transaction->setTransactionDate(new \DateTime());
        $transaction->setUserId('test-user');
        $transaction->setLatitude('48.832310');
        $transaction->setLongitude('2.372647');
        $transaction->setAmount(150.00);
        $transaction->setPaymentLabel('VL23B19KS2');
        $transaction->setLocalization('');
        $manager->persist($transaction);

        $manager->flush();
    }
}
