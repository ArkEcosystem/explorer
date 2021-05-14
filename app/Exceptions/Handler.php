<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use App\Exceptions\TransactionNotFoundException;

final class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param Throwable $exception
     *
     * @throws Exception
     *
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request   $request
     * @param Throwable $exception
     *
     * @throws Throwable
     *
     * @return Response
     */
    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * Get the view used to render HTTP exceptions.
     *
     * @param  HttpExceptionInterface  $e
     * @return string
     */
    protected function getHttpExceptionView(HttpExceptionInterface $e)
    {
        if ($e->getPrevious() instanceof TransactionNotFoundException) {
            return "errors::404_entity";
        }

        return "errors::{$e->getStatusCode()}";
    }

}
