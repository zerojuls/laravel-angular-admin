<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as HttpResponse;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('returnJson', function ($data, $exception = null, $http_code = HttpResponse::HTTP_OK, $auth = null, $headers = []) {

            $http_response_success = ($http_code == HttpResponse::HTTP_NOT_FOUND || $http_code == HttpResponse::HTTP_UNPROCESSABLE_ENTITY) ? false : true;

            $msg = !empty($exception) ? ($exception->getMessage() !== "" ? $exception->getMessage() : "Sorry, the page you are looking for could not be found") : 'Ok';

            $response = [
                'success' => $http_response_success,
                'code' => $http_code,
                'auth' => (empty($auth) && $http_code !== HttpResponse::HTTP_UNPROCESSABLE_ENTITY) ? true : false,
                'locale' => \App::getLocale(),
                'message' => $msg,
                'data' => $data
            ];

            return Response::json($response)->header('Access-Control-Allow-Origin', '*'); // TODO:  Agregar deteccion de headers en variable headers del Response::macro() paera agregar mas headers aparte de este, tipo Response::json($response)->header($headers);
        });
    }
}
