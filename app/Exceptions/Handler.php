<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        
            if ($exception instanceof ValidationException) {
            $errores=$exception->validator->getMessageBag();
            $jsonErrores=json_encode($errores);
            $jsonErrores=json_decode($jsonErrores,true);
            $mensaje["ews_mensaje"]="";
            foreach ($jsonErrores as $key => $value) {
                    $mensaje["ews_mensaje"]=  $mensaje["ews_mensaje"] .",".$value[0];
            }
            $mensaje["ews_mensaje"]=substr($mensaje["ews_mensaje"],1);
            return response()->json( $mensaje, 400);
        }
        return parent::render($request, $exception);
    }
}
