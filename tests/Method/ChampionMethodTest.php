<?php 

use LeagueWrap\Api;
use LeagueWrap\Dto;

class ChampionMethodTest extends MethodTestCase {

    public function testFindAll() {
        $this->setUpProviderRequest('na', 'na/v1.2/champion', [
            'api_key' => 'key',
        ], 'champion.json');

        $api = new Api('key', $this->provider);
        $championList = $api->champion->findAll();

        $this->assertTrue($championList instanceof Dto\ChampionList);
        $this->assertEquals(118, count($championList));
    }

    public function testFindFreeToPlay() {
        $this->setUpProviderRequest('na', 'na/v1.2/champion', [
            'api_key' => 'key',
            'freeToPlay' => 'true',
        ], 'champion.free.json');

        $api = new Api('key', $this->provider);
        $championList = $api->champion->findFreeToPlay();

        $this->assertTrue($championList instanceof Dto\ChampionList);
        $this->assertEquals(10, count($championList));
    }

    public function testFindById() {
        $this->setUpProviderRequest('na', 'na/v1.2/champion/10', [
            'api_key' => 'key',
        ], 'champion.10.json');

        $api = new Api('key', $this->provider);
        $champion = $api->champion->findById(10);

        $this->assertTrue($champion instanceof Dto\Champion);
        $this->assertTrue($champion->active);
    }

}
