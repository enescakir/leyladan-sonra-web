<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
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

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
