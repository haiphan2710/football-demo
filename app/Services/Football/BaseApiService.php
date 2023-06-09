<?php

namespace App\Services\Football;

use GuzzleHttp\Client;

/**
 * API Document: https://www.api-football.com/documentation-v3
 */
abstract class BaseApiService
{
    /** @var Client $client */
    protected $client;

    /** @var $params */
    protected $params = null;

    public function __construct()
    {
        /** @var Client $client */
        $this->client = new Client([
            'base_uri' => config('football.base_uri'),
            'headers'  => config('football.headers'),
        ]);
    }

    /**
     * Set Params
     *
     * @param array $params
     * @return $this
     */
    public function setParams(array $params): self
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Get Response
     *
     * @param $response
     * @return array
     */
    protected function getResponse($response): array
    {
        return json_decode($response, true);
    }
}
