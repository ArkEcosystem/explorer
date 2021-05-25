<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Http\Request;
use App\Http\Middleware\EncryptCookies;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Session\Middleware\StartSession;
use App\Exceptions\Contracts\EntityNotFoundInterface;
use Closure;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        }

        return $this->withSession($request, fn ($request) => parent::render($request, $exception));
    }

    private function withSession(Request $request, Closure $next): Response
    {
        return app(EncryptCookies::class)->handle($request, function ($request) use ($next) {
            return app(StartSession::class)->handle($request, fn ($request) => $next($request));
        });
    }

    private function shouldShowEntity404Page(Request $request, Throwable $exception): bool
    {
        $expectedException     = $this->prepareException($this->mapException($exception));
        $mainNotFoundException = $expectedException->getPrevious();

        return $this->isARegularGetRequest($request)
            && $mainNotFoundException !== null
            && is_a($mainNotFoundException, EntityNotFoundInterface::class);
    }

    private function getNotFoundEntityResponse(Throwable $exception): HttpResponse
    {
        $expectedException = $this->prepareException($this->mapException($exception));

        return response()->view('errors.404_entity', [
            'exception' => $expectedException,
        ], 404);
    }

    private function isARegularGetRequest(Request $request): bool
    {
        return $request->method() === 'GET' && ! $request->expectsJson();
    }
}
