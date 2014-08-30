<?php

abstract class StaticTestCase extends PHPUnit_Framework_TestCase {

    protected $provider;

    public function setUp() {
        $this->provider = Mockery::mock('LeagueWrap\ProviderInterface');
    }

    public function tearDown() {
        Mockery::close();
    }

    protected function setUpProviderRequest($suffix, array $params, $fileSuffix) {
        $return = file_get_contents('tests/Json/Static/' . $fileSuffix);

        $this->provider->shouldReceive('request')
            ->with('https://global.api.pvp.net/api/lol/static-data/' . $suffix, $params)
            ->once()
            ->andReturn($return);
    }

}
