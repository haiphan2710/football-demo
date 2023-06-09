<?php

namespace App\Services\Football;

use GuzzleHttp\Exception\GuzzleException;

class OddService extends BaseApiService
{
    protected $mainRoute = 'odds';

    /**
     * API live
     * Query params: fixture(integer)
     *
     * @return array
     * @throws GuzzleException
     */
    public function preMatch(): array
    {
        return $this->getResponse(
            $this->client->get(
                $this->mainRoute,
                ['query' => $this->params ?? []]
            )->getBody()->getContents()
        );
    }

    public function bookmakers()
    {
        return $this->getResponse(
            $this->client->get(
                $this->mainRoute . '/bookmakers',
                ['query' => $this->params ?? []]
            )->getBody()->getContents()
        );
    }
}
