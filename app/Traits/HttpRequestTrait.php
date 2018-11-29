<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait HttpRequestTrait
{
    public function client($option)
    {
        return new Client($option);
    }

    /**
     * @param $uri
     * @param $params
     * @param array $option
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function makePostRequest($uri, $params, $option = [])
    {
        $client = $this->client($option);
        $res = $client->request('POST', $uri, [
            'form_params' => $params
        ]);
        return json_decode($res->getBody(), true);
    }
}