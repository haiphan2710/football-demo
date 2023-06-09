<?php

namespace App\Services\Football;

use GuzzleHttp\Exception\GuzzleException;

class CountryService extends BaseApiService
{
    protected $mainRoute = 'countries';

    /**
     * API get all countries
     *
     * @return array
     * @throws GuzzleException
     */
    public function all(): array
    {
        return $this->getResponse(
            $this->client->get($this->mainRoute, $this->params ?? [])->getBody()->getContents()
        );
    }
}
