<?php

declare(strict_types=1);

namespace App\Controller;

use App\DevTools\PHPStan\ThisRouteDoesntNeedAVoter;
use App\Dto\Request\Transaction\UpdateTransactionDto;
use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use App\Security\Voter\TransactionVoter;
use App\UseCase\Transaction\UpdateTransactionUseCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class TransactionController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TransactionRepository $transactionRepository,
        private readonly UserRepository $userRepository,
        private readonly UpdateTransactionUseCase $updateTransaction,
    ) {
    }

    #[Route('/transactions', name: 'list_transactions', methods: ['GET'])]
    #[ThisRouteDoesntNeedAVoter]
    public function listTransactions(\Symfony\Bundle\SecurityBundle\Security $security): JsonResponse
    {
        $transactions = $this->transactionRepository->findForUser(2);

        return new JsonResponse($transactions);
    }

    #[Route('/transactions/{id}', name: 'update_transaction', methods: ['PUT'])]
    public function updateTransaction(Transaction $transaction, #[MapRequestPayload]
    UpdateTransactionDto $transactionDto,): JsonResponse
    {
        $transaction = $this->updateTransaction->updateTransaction($transaction, $transactionDto);

        $this->entityManager->flush();

        return new JsonResponse([
            'id' => $transaction->getId(),
        ]);
    }
}
