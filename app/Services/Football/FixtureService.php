<?php

namespace App\Services\Football;

use GuzzleHttp\Exception\GuzzleException;

class FixtureService extends BaseApiService
{
    protected $mainRoute = 'fixtures';

    /**
     * API live
     * Query params:
     *      + league(integer) - required
     *      + season(integer) - required - YYYY
     *      + current(bool)
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
