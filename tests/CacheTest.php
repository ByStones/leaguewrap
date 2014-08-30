<?php

use Mockery as m;

class CacheTest extends PHPUnit_Framework_TestCase {

    protected $cache;
    protected $client;

    public function setUp() {
        $this->cache = m::mock('LeagueWrap\CacheInterface');
        $this->client = m::mock('LeagueWrap\Client');
    }

    public function tearDown() {
        m::close();
    }

    public function testRememberChampion() {
        $champions = file_get_contents('tests/Json/champion.free.json');
        $this->cache->shouldReceive('set')
                ->once()
                ->with($champions, '4be3fe5c15c888d40a1793190d77166b', 60)
                ->andReturn(true);
        $this->cache->shouldReceive('has')
                ->twice()
                ->with('4be3fe5c15c888d40a1793190d77166b')
                ->andReturn(false, true);
        $this->cache->shouldReceive('get')
                ->once()
                ->with('4be3fe5c15c888d40a1793190d77166b')
                ->andReturn($champions);

        $this->client->shouldReceive('baseUrl')
                ->twice();
        $this->client->shouldReceive('request')
                ->with('na/v1.2/champion', [
                    'freeToPlay' => 'true',
                    'api_key' => 'key',
                ])->once()
                ->andReturn($champions);

        $api = new LeagueWrap\Api('key', $this->client);
        $champion = $api->champion()
                ->remember(60, $this->cache);
        $champion->free();
        $champion->free();
        $this->assertEquals(1, $champion->getRequestCount());
    }

}
