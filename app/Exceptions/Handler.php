<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Log, Auth;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
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
        $user_id = "";
        if(Auth::user())
            $user_id = Auth::user()->id;

        $class_parts = explode('\\', get_class($e));
        Log::warning(
            end( $class_parts ) . " - " . $request->method() . " - " . $request->path() .
            "\nIP: " . $request->ip() .
            "\nUser ID: " . $user_id .
            "\nTrace: " . $e->getTraceAsString()
        );

        if ($e instanceof TokenMismatchException) {
            return redirect()->back()->withInput()->with('error_message', 'Bir hata ile karşılaşıldı. Sayfayı yenileyip işleminizi tekrar deneyin. <br> Eğer hata almaya devam ederseniz <strong>teknik@leyladansonra.com</strong> adresi ile iletişime geçin.');
        }
        return parent::render($request, $e);
    }


}
