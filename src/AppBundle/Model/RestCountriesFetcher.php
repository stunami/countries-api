<?php

namespace AppBundle\Model;

class RestCountriesFetcher
{
    private $endpoint = null;

    public function __construct($endpoint = 'https://restcountries.eu/rest/v1/all')
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Pretty dump fetcher.
     *
     * @return mixed
     */
    public function fetch()
    {
        return json_decode(file_get_contents($this->endpoint), true);
    }
}