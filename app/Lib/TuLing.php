<?php

namespace App\Lib;

use GuzzleHttp\Client;
use Log;

class TuLing {

    private $apiUrl = 'http://openapi.tuling123.com/openapi/api/v2';
    private $apiKey = '3b55e6db981a45f689d9bc8b1d9c583b';

    public function bot($text, $userId = 1) {
        $sendData = [
            'perception' => [
                'inputText' => [
                    'text' => $text
                ]
            ],
            'userInfo' => [
                'apiKey' => $this->apiKey,
                'userId' => $userId
            ]
        ];
        $client = new Client(['http_errors' => false]);
        $response = $client->request('POST', $this->apiUrl, ['json' => $sendData]);
        $res = json_decode((string) $response->getBody(), true);
        $results = $res['results'][0];
        $message = $results['values'][$results['resultType']];
        return $message;
    }

}
