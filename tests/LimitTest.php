<?php

use Mockery as m;

class LimitTest extends PHPUnit_Framework_TestCase {

    protected $limit1;
    protected $limit2;
    protected $provider;

    public function setUp() {
        $this->limit1 = m::mock('LeagueWrap\LimitInterface');
        $this->limit2 = m::mock('LeagueWrap\LimitInterface');
        $this->provider = m::mock('LeagueWrap\ProviderInterface');
    }

    public function tearDown() {
        m::close();
    }

    /**
     * @expectedException LeagueWrap\Exception\LimitReachedException
     */
    public function testSingleLimit() {
        $this->limit1->shouldReceive('setRate')
                ->once()
                ->with(1, 10)
                ->andReturn(true);
        $this->limit1->shouldReceive('hit')
                ->twice()
                ->with(1)
                ->andReturn(true, false);
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.2/champion', [
                    'freeToPlay' => 'true',
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/champion.free.json'));

        $api = new LeagueWrap\Api('key', $this->provider);
        $api->limit(1, 10, $this->limit1);
        $champion = $api->champion();
        $champion->free();
        $champion->free();
    }

    /**
     * @expectedException LeagueWrap\Exception\LimitReachedException
     */
    public function testDoubleLimit() {
        $this->limit1->shouldReceive('setRate')
                ->once()
                ->with(5, 10)
                ->andReturn(true);
        $this->limit1->shouldReceive('hit')
                ->times(3)
                ->with(1)
                ->andReturn(true);
        $this->limit2->shouldReceive('setRate')
                ->once()
                ->with(2, 5)
                ->andReturn(true);
        $this->limit2->shouldReceive('hit')
                ->times(3)
                ->with(1)
                ->andReturn(true, true, false);
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.2/champion', [
                    'freeToPlay' => 'true',
                    'api_key' => 'key',
                ])->twice()
                ->andReturn(file_get_contents('tests/Json/champion.free.json'));

        $api = new LeagueWrap\Api('key', $this->provider);
        $api->limit(5, 10, $this->limit1);
        $api->limit(2, 5, $this->limit2);
        $champion = $api->champion();
        $champion->free();
        $champion->free();
        $champion->free();
    }

}
