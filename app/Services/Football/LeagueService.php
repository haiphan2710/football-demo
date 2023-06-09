<?php

namespace App\Services\Football;

use GuzzleHttp\Exception\GuzzleException;

class LeagueService extends BaseApiService
{
    protected $mainRoute = 'leagues';

    /**
     * API get all
     * Query params:
     *      + code(string) - 2 characters
     *      + season(integer) - Format: YYYY
     *
     * @return array
     * @throws GuzzleException
     */
    public function all(): array
    {
        return $this->getResponse(
            $this->client->get($this->mainRoute, ['query' => $this->params ?? []])->getBody()->getContents()
        );
    }
}
