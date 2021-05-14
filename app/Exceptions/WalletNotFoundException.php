<?php

namespace App\Exceptions;

use App\Exceptions\Contracts\EntityNotFoundInterface;
use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Konceiver\BladeComponents\View\Components\TruncateMiddle;

class WalletNotFoundException extends ModelNotFoundException implements EntityNotFoundInterface
{
    public function getCustomMessage(): HtmlString
    {
        $truncateMiddle = new TruncateMiddle();

        [$walletID] = $this->getIds();

        $truncatedWalletID = $truncateMiddle->render()([
            'slot' => $walletID,
            'attributes' => ['length' => 17]
        ]);

        $message = trans('errors.wallet_not_found', [
            'truncatedWalletID' => $truncatedWalletID,
            'walletID' => $walletID,
        ]);

        return new HtmlString($message);
    }
}
