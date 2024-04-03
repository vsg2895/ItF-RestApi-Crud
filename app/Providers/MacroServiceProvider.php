<?php

namespace App\Providers;

use App\Services\ExternalApiService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;


class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        /**
         * Macros for Response Class
         */
        Response::macro('success', function ($result = [], $message = "", $code = 200, $headers = []) {
            $response = [
                'success' => $code < 300,
                'data' => $result
            ];
            if (!empty($message)) {
                $response['message'] = $message;
            }
            return response()->json($response, $code)->withHeaders($headers);
        });

        Response::macro('fail', function ($e, $message = "Something went wrong! Process not completed", $status = 500) {
            DB::rollBack();
            Log::channel('external-api')->error('Fail ',
                [
                    'message' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ]);
            throw new HttpResponseException(response()->json(["message" => $message], $status));
        });

        Response::macro('exception', function ($data, $message = "Something went wrong! Process not completed", $status = 422) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => $message,
                'data' => $data,
            ], $status));
        });

        /**
         * Macros for Http Class
         */
        $externalApiService = new ExternalApiService();
        foreach ($externalApiService::GET_EXTERNAL_API_ALIASES as $external_api_alias) {
            Http::macro($external_api_alias, function ($params) use ($external_api_alias) {
                $correspondedConfigName = 'external_apis.' . $external_api_alias . '.base_url';
                $url = count($params) ? Config::get($correspondedConfigName) . '?' . http_build_query($params)
                                      : Config::get($correspondedConfigName);
                return Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->get($url);
            });
        }

    }
}
