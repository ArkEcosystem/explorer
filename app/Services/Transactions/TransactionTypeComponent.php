<?php

declare(strict_types=1);

namespace App\Services\Transactions;

use App\Models\Transaction;

final class TransactionTypeComponent
{
    private TransactionTypeSlug $slug;

    public function __construct(Transaction $transaction)
    {
        $this->slug = new TransactionTypeSlug($transaction);
    }

    public function header(): string
    {
        return $this->getView('header');
    }

    public function details(): string
    {
        return $this->getView('details');
    }

    public function extension(): string
    {
        // @TODO: rename folder to extension
        return $this->getView('extra');
    }

    private function getView(string $group): string
    {
        if ($view = sprintf("transaction.$group.".$this->slug->exact())) {
            return $view;
        }

        if ($view = sprintf("transaction.$group.".$this->slug->generic())) {
            return $view;
        }

        return "transaction.$group.fallback";
    }
}
