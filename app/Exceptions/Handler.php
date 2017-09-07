<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if((!empty($request->path()) && (explode("/", $request->path())[0] !== 'api')) ) {
            return parent::render($request, $exception);
        }

        $auth = null;
        $http_code = Response::HTTP_OK;

        if ($exception instanceof NotFoundHttpException) {

            $http_code = Response::HTTP_NOT_FOUND;
            $auth = Response::HTTP_UNAUTHORIZED;
            $request = [];
        } elseif ($exception instanceof AuthenticationException) {

            $auth = Response::HTTP_UNAUTHORIZED;
            $request = [];
        }

        return response()->returnJson($request, $exception, $http_code, $auth);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        $http_code = Response::HTTP_OK;
        $auth = Response::HTTP_UNAUTHORIZED;

        return response()->returnJson([], $exception, $http_code, $auth); // TODO: Agregar opcion para header para enviar Access-Control-Allow-Origin : * u otro header
    }
}
