<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Transaction;
use App\Security\Enum\Right;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Transaction\TransactionInterface;

/** @phpstan-extends Voter<string, Transaction|null> */
class TransactionVoter extends Voter
{
    public const CREATE_TRANSACTION = 'CREATE_TRANSACTION';
    public const EDIT_ANY_TRANSACTION = 'EDIT_ANY_TRANSACTION';
    public const VIEW_ANY_TRANSACTION = 'VIEW_ANY_TRANSACTION';
    public const DELETE_ANY_TRANSACTION = 'DELETE_ANY_TRANSACTION';

    public function __construct(private readonly Security $security)
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return \in_array($attribute, [
            self::CREATE_TRANSACTION,
            self::VIEW_ANY_TRANSACTION,
            self::EDIT_ANY_TRANSACTION,
            self::DELETE_ANY_TRANSACTION,
        ]);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        return match ($attribute) {
            self::CREATE_TRANSACTION => $this->canCreate(),
            self::EDIT_ANY_TRANSACTION, self::DELETE_ANY_TRANSACTION => $this->canEdit($subject),
            self::VIEW_ANY_TRANSACTION => $this->canView(),
            default => false
        };
    }

    private function canCreate(): bool
    {
        return $this->security->isGranted(Right::ROLE_RIGHT_TRANSACTION_CREATE->value);
    }

    private function canEdit(mixed $subject): bool
    {
        if (! $subject instanceof Transaction) {
            throw new \RuntimeException('Subject of voter should be a ' . Transaction::class);
        }

        return $this->security->isGranted(Right::ROLE_RIGHT_TRANSACTION_UPDATE->value)
            && ! $subject->hasRole('ROLE_ADMIN');
    }

    private function canView(): bool
    {
        return $this->security->isGranted(Right::ROLE_RIGHT_TRANSACTION_READ->value);
    }
}
