<?php

namespace LeagueWrap\Provider;

use GuzzleHttp\Client as Guzzle;
use LeagueWrap\ProviderInterface;

class GuzzleProvider implements ProviderInterface {

    protected $guzzle = null;

    public function __construct(Guzzle $guzzle) {
        $this->guzzle = $guzzle;
    }

    public function request($path, array $params = []) {
        $uri = $path . '?' . http_build_query($params);
        $response = $this->guzzle->get($uri);

        return $response->getBody();
    }

}
