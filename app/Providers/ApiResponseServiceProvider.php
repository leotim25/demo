<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ApiResponseServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('success', function ($data = array()) {
            $return = array();
            $return['status'] = true;
            if (isset($data) && ! empty($data)) {
                $return['data'] = $data;
            }
            return Response::json($return, 200);
        });
        Response::macro('error', function ($message, $status = 400) {
            return Response::json([
                'status' => false,
                'message' => $message,
                'error_code' => $status
            ], $status);
        });
    }
}
