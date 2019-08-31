<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Helper\MessagesHelper;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

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
        dump($exception);
        if ($exception instanceof AuthenticationException) {
            return response()->json(array('code' => -2100002,
                'error' => MessagesHelper::get(-2100002)), 400);
        }

        if ($exception instanceof UnauthenticatedException) {
            return response()->json(array('code' => -2100002,
                'error' => MessagesHelper::get(-2100002)), 400);
        }

        if ($exception instanceof DoctorAppException) {
            return response()->json(array('code' => (int)$exception->getMessage(),
                'error' => MessagesHelper::get($exception->getMessage())), 400);
        }

        if($exception instanceof ValidationException){
            $code = (int)$exception->validator->errors()->first();
            $message = $exception->validator->errors();
            return response()->json(array(
                'code' => $code,
                'error' => MessagesHelper::get($code),
                'message' => $message
            ), 400);
        }

        return response()->json(array(
            'code' => -9999999,
            'error' => $exception->getMessage(),
            'exception' => get_class($exception)
        ), 400);
    }
}
