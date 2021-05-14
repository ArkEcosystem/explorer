<?php

namespace App\Exceptions;

use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Konceiver\BladeComponents\View\Components\TruncateMiddle;
use App\Exceptions\Contracts\EntityNotFoundInterface;

class BlockNotFoundException extends ModelNotFoundException implements EntityNotFoundInterface
{
    public function getCustomMessage(): HtmlString
    {
        $truncateMiddle = new TruncateMiddle();

        [$blockID] = $this->getIds();

        $truncatedBlockID = $truncateMiddle->render()([
            'slot' => $blockID,
            'attributes' => ['length' => 17]
        ]);

        $message = trans('errors.block_not_found', ['blockID' => $truncatedBlockID]);

        return new HtmlString($message);
    }
}
