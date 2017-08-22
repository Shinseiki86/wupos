<?php

namespace Wupos\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        //dump( get_class($e) );
        //Si está en modo depuración y no es una excepción de SOAP
        if (!env('APP_DEBUG', false)){
                //Si la ruta no existe, mostar view 404.
                if($e instanceof \ReflectionException OR
                    $e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
                ){
                    return response(view('errors.404'), 404);
                }

                //Si hay una excepción de los siguientes tipos...
                if($e instanceof \ErrorException OR
                    $e instanceof \BadMethodCallException OR
                    $e instanceof \SoapFault OR
                    $e instanceof \PDOException OR
                    $e instanceof \Symfony\Component\Debug\Exception\FatalErrorException
                ){// ... entonces renderizar vista para error 500
                    return $this->returnResponseError($e);
                }
        }

        return parent::render($request, $e);
    }


    private function returnResponseError(Exception $e)
    {
        $errorFile = last(explode('\\', $e->getFile()));
        $errorMsg = $errorFile.' (Línea '.$e->getLine().'): '.$e->getMessage();
        $errorCode = method_exists('getStatusCode', $e) ? $e->getStatusCode() : 500;
        return response(
                    view('errors.'.$errorCode, compact('errorMsg')),
                    $errorCode
                );
    }
}
