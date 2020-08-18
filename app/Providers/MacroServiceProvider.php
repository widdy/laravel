<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     *
     * @return void
     */
    public function boot()
    {

        /**
         * success
         * @param  $msg string
         * @param  $data mixed
         * @return \Illuminate\Http\JsonResponse
         */
        Response::macro('success', function (string $msg = 'success', $data = null) {
            $ret = ['code' => 0, 'message' => $msg, 'data' => $data];
            if (!is_string($msg)) {
                list($data, $msg) = [$msg, $data ?? 'success'];
            }
            if ($ret['data'] === null) {
                unset($ret['data']);
            }

            return Response::json($ret,
                200, ['Content-Type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
        });

        /**
         * error
         * @param  $msg string
         * @param  $data mixed
         * @return \Illuminate\Http\JsonResponse
         */
        Response::macro('error', function (string $msg = 'error', $data = null) {
            $ret = ['code' => 1, 'message' => $msg, 'data' => $data];
            if ($data === null) {
                unset($ret['data']);
            }
            return Response::json($ret,
                200, ['Content-Type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
        });

        /**
         * system error, illegal request ...
         * @param  $msg string
         * @param  $data mixed
         * @return \Illuminate\Http\JsonResponse
         */
        Response::macro('bad', function (string $msg = 'service unavailable ', $data = null) {
            $ret = ['code' => 1, 'message' => $msg, 'data' => $data];
            if ($data === null || !config('app.debug')) { //data is null or debug is false
                unset($ret['data']);
            }
            return Response::json($ret,
                200, ['Content-Type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
        });

        /**
         * unauthenticated or token expired
         * @param  $msg string
         * @param  $data mixed
         * @return \Illuminate\Http\JsonResponse
         */
        Response::macro('unauthenticated', function (string $msg = 'unauthenticated', $data = null) {

            $ret = ['code' => 40001, 'message' => $msg, 'data' => $data];
            if ($data === null || !config('app.debug')) { //data is null or debug is false
                unset($ret['data']);
            }
            return Response::json($ret,
                200, ['Content-Type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);

        });
    }
}
