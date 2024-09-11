<?php

declare(strict_types=1);

namespace App\UseCase\Transaction;

use App\Dto\Request\Transaction\UpdateTransactionDto;
use App\Entity\Transaction;

class UpdateTransactionUseCase
{
    public function __construct() {
    }

    public function updateTransaction(Transaction $transaction, UpdateTransactionDto $transactionDto): Transaction
    {
        $transaction->setLocalization($transactionDto->getLocalization());

        return $transaction;
    }
}
