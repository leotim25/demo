<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;


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
    public function render_bak($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }
    public function render($request, Exception $exception)
    {
        if (strpos($request->getUri(), '/api') !== false) {
            $retval = $this->getJsonResponseForException($request, $exception);
            //$retval = parent::render($request, $exception);
        } else {
            $retval = parent::render($request, $exception);
        }
        return $retval;
    }
    
    public  function getJsonResponseForException($request, Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'status' => false,
                'message' => 'Resource not found',
                'error_code' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        } elseif ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'status' => false,
                'message' => 'NotFound',
                'error_code' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        } elseif ($exception instanceof JWTException) {
            return response()->json([
                'status' => false,
                'message' => 'JWT Token could not be parsed from the request',
                'error_code' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            'status' => false,
            'message' => $exception->getMessage(),
            'error_code' => Response::HTTP_BAD_REQUEST
        ], Response::HTTP_BAD_REQUEST);
    }
}
