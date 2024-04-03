<?php

namespace App\Services;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class ExternalApiService
{
    /**
     * Get Api Types
     */
    const GET_EXTERNAL_API_ALIASES = [
      'country_codes', 'timezone'
    ];

    /**
     * Prepare Data For Correctly Response
     */
    public function convertToResponsableData($result, $externalApiType) {
        $resultStatus = $result->successful() && !$result->failed() && !$result->clientError() && !$result->serverError();
        if ($resultStatus) {
            return json_decode($result->getBody(),true);
        } else {
            return Response::fail(new \Exception(), "Api Error " . $externalApiType, 500);
        }
    }

    /**
     * Get Data To Endpoint
     */
    public function getData($externalApiType, $params = []): array
    {
        if (in_array($externalApiType, self::GET_EXTERNAL_API_ALIASES)) {
            $seconds = Config::get('external_apis.result_caching_expiration');
            return Cache::remember($externalApiType, $seconds, function () use($externalApiType, $params) {
                $result = call_user_func_array([Http::class, $externalApiType], [$params]);
                return $this->convertToResponsableData($result, $externalApiType);
            });
        } else {
            return Response::fail(throw new HttpResponseException(response()->json(["message"=> "Undefined Api Type " . $externalApiType], 500)));
        }
    }
}
