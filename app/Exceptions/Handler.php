<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        // Si la excepción es de tipo NotFoundHttpException (ruta no encontrada)
        if ($exception instanceof NotFoundHttpException) {
            // Retornar una respuesta JSON con el mensaje "Ruta no encontrada" y código de estado 404
            return response()->json([
                'error' => 'Ruta no encontrada'
            ], 404);
        }

        // En caso contrario, se maneja la excepción de la manera estándar
        return parent::render($request, $exception);
    }
}
