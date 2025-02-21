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


        if ($this->debugMode) {
            info('------------------- Make Request -------------------');
            info('makeRequest url: ' . $url);
            info('makeRequest data: ' . json_encode($data));
            info('------------------- End Make Request -------------------');
        }

        if ($method == 'GET') {
            $response = $response->get($url, $data);
        } else {
            $response = $response->post($url, $data);
        }

        return $response;
    }

    private function makeLegacyRequest($apiKey, $url, $body, $method = 'POST')
    {
        $headers = [
            'Ocp-Apim-Subscription-Key' => $apiKey,
            'Content-Type' => 'application/json'
        ];

        $response = Http::withHeaders($headers)->acceptJson();

        if ($this->debugMode) {
            info('------------------- Make Request -------------------');
            info('makeRequest url: ' . $url);
            info('makeRequest data: ' . json_encode($body));
            info('------------------- End Make Request -------------------');
        }

        if ($method == 'GET') {
            $response = $response->get($url, $body);
        } else {
            $response = $response->post($url, $body);
        }
    }

    // private function sendToEft() {
    //     $sender = [
    //         'accountNumber' => '1234567890',
    //         'address1' => '1234',
    //         'address2' => '1234',
    //         'address3' => '1234',
    //         'address4' => '1234',
    //         'cif' => '1234',
    //         'country' => 'KE',
    //         'name' => 'John Doe'
    //     ];

    //     $beneficiary = [
    //         'accountNumber' => '1234567890',
    //         'address1' => '1234',
    //         'address2' => '1234',
    //         'address3' => '1234',
    //         'address4' => '1234',
    //         'bankBIC' => '1234',
    //         'bankName' => '1234',
    //         'bankSwiftCode' => '1234',
    //         'city' => '1234',
    //         'country' => 'KE',
    //         'name' => 'John Doe',
    //         'currency' => 'KES'
    //     ];
    // }

}
