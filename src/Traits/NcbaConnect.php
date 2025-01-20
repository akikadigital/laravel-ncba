<?php

namespace Akika\LaravelNcba\Traits;

use Illuminate\Support\Facades\Http;

trait NcbaConnect
{

    /**
     * 
     * Performs a request to the API
     * @param string $url - the URL to send the request to
     * @param array $data - the data to send
     * 
     * @return mixed - The result of the request: \Illuminate\Http\Client\Response
     */

    private function makeRequest($url, $data, $method = 'POST')
    {

        $response = Http::withHeaders([
            'apiKey' => $this->apiKey
        ])->acceptJson();


        if ($this->debugMode) info('makeRequest url: ' . $url);
        if ($this->debugMode) info('makeRequest data: ' . json_encode($data));

        if ($method == 'GET') {
            $response = $response->get($url, $data);
        } else {
            $response = $response->post($url, $data);
        }

        return $response;
    }
}
