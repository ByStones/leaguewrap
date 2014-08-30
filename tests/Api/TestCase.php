<?php

abstract class TestCase extends PHPUnit_Framework_TestCase {

    protected $provider;

    public function setUp() {
        $this->provider = Mockery::mock('LeagueWrap\ProviderInterface');
    }

    public function tearDown() {
        Mockery::close();
    }

    protected function setUpProviderRequest($region, $suffix, array $params, $fileSuffix) {
        $return = file_get_contents('tests/Json/' . $fileSuffix);

        $this->provider->shouldReceive('request')
            ->with('https://'. $region . '.api.pvp.net/api/lol/' . $suffix, $params)
            ->once()
            ->andReturn($return);
    }

}

