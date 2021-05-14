<?php

namespace App\Exceptions;

use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Konceiver\BladeComponents\View\Components\TruncateMiddle;

class TransactionNotFoundException extends ModelNotFoundException
{
    public function getCustomMessage(): HtmlString
    {
        $truncateMiddle = new TruncateMiddle();

        [$transactionID] = $this->getIds();

        $truncatedTransactionID = $truncateMiddle->render()([
            'slot' => $transactionID,
            'attributes' => ['length' => 17]
        ]);

        $message = trans('errors.transaction_not_found', ['transactionID' => $truncatedTransactionID]);

        return new HtmlString($message);
    }
}
