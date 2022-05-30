<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Class BaseRepository.
 *
 * Modified from: https://github.com/kylenoland/laravel-base-repository
 */
abstract class HttpBaseService
{
    /**
     * The repository model.
     *
     * @var $url
     */
    protected static $url;

    /**
     * Get Request
     *
     * @param string $endPoint
     * @param string $returnType
     * @param array $query
     * @param bool $isCompleteUrl
     * @return mixed
     */
    public static function get(string $endPoint, string $returnType, array $query = [], bool $isCompleteUrl = false)
    {
        $url = config('constants.api_url') . $endPoint;
        if ($isCompleteUrl) {
            $url = $endPoint;
            $response = Http::withHeaders(self::headers())->get($url);
        } else if (empty($query)) {
            $response = Http::withHeaders(self::headers())->get($url);
        } else {
            $response = Http::withHeaders(self::headers())->get($url, $query);
        }

        /*if ($response->status() === 401)
        {
            if (Auth::isAuthenticated()) {
                Auth::refreshToken();
            }
        }*/

        switch (Str::lower($returnType)) {
            case 'json':
                $response = $response->json();
                break;
            case 'object':
                $response = $response->object();
                break;
            case 'collect':
                $response = $response->collect();
                break;
            default:
                $response = $response->body();
                break;
        }
        return $response;
    }

    /**
     * Get Request
     *
     * @param string $endPoint
     * @param array $payload
     * @param string $returnType
     * @param array $attachments
     * @return mixed
     */
    public static function post(string $endPoint, array $payload, array $attachments = [])
    {
        $url = config('constants.api_url') . $endPoint;
        $response = Http::withHeaders(self::headers());

        /*Attaching file into HTTP(Curl)*/
        if (count($attachments) && is_array($attachments['attachment_files'])) {
            foreach($attachments['attachment_files'] as $k => $file)
            {
                $response = $response->attach($attachments['attachment_name'].'['.$k.']', fopen($file, 'r'));
            }
        }
        if (count($attachments) && !is_array($attachments['attachment_files'])) {
            $response = $response->attach($attachments['attachment_name'], fopen($attachments['attachment_files'], 'r'));
        }

        try {
            $response = $response->post($url, $payload);
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
        return $response;
    }

    /**
     * Common header for all requests
     *
     * @return array
     */
    private static function headers(): array
    {
        $headers = [
            'Content-Type' => 'application/json'
        ];

        return $headers;
    }

}
