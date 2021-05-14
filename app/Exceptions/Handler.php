<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Contracts\EntityNotFoundInterface;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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
        if ($this->shouldShowEntity404Page($request, $exception)) {
            return $this->getNotFoundEntityResponse($exception);
        } elseif ($this->shouldShow404Page($request, $exception)) {
            return redirect()->route('error.404');
        }

        return parent::render($request, $exception);
    }

    private function shouldShowEntity404Page(Request $request, Throwable $exception): bool
    {
        $expectedException     = $this->prepareException($this->mapException($exception));
        $mainNotFoundException = $expectedException->getPrevious();

        return $this->isARegularGetRequest($request)
            && is_a($mainNotFoundException, EntityNotFoundInterface::class);
    }

    private function getNotFoundEntityResponse(Throwable $exception): HttpResponse
    {
        $expectedException = $this->prepareException($this->mapException($exception));

        return response()->view('errors.404_entity', [
            'exception' => $expectedException,
        ], 404);
    }

    private function shouldShow404Page(Request $request, Throwable $exception): bool
    {
        $expectedException     = $this->prepareException($this->mapException($exception));
        $mainNotFoundException = $expectedException->getPrevious();

        return $this->isARegularGetRequest($request)
            && $expectedException instanceof NotFoundHttpException
            && ! is_a($mainNotFoundException, EntityNotFoundInterface::class);
    }

    private function isARegularGetRequest(Request $request): bool
    {
        return $request->method() === 'GET' && ! $request->expectsJson();
    }
}
