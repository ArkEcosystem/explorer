<?php

namespace App\Exceptions\Contracts;

use Illuminate\Support\HtmlString;

interface EntityNotFoundInterface
{
    public function getCustomMessage(): HtmlString;
}
