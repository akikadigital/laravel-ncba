<?php

namespace Akika\LaravelNcba\Traits;

use Illuminate\Support\Facades\Http;

trait NcbaTrait
{
    public function makeRequest($url, $data, $method = 'POST')
    {
        $response = Http::acceptJson();

        if ($method == 'GET') {
            $response = $response->get($url, $data);
        } else {
            $response = $response->post($url, $data);
        }

        return $response;
    }
}
