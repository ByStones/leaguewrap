<?php

use LeagueWrap\Api;

class ApiChampionTest extends TestCase {

    public function testAll() {
        $this->setUpProviderRequest('na', 'na/v1.2/champion', [
            'freeToPlay' => 'false',
            'api_key' => 'key',
        ], 'champion.json');

        $api = new Api('key', $this->provider);
        $champion = $api->champion();
        $champions = $champion->all();
        $this->assertTrue($champions->getChampion(53) instanceof LeagueWrap\Dto\Champion);
    }

    public function testAllArrayAccess() {
        $this->setUpProviderRequest('na', 'na/v1.2/champion', [
            'freeToPlay' => 'false',
            'api_key' => 'key',
        ], 'champion.json');

        $api = new Api('key', $this->provider);
        $champion = $api->champion();
        $champions = $champion->all();
        $this->assertTrue($champions[53] instanceof LeagueWrap\Dto\Champion);
    }

    public function testAllIterator() {
        $this->setUpProviderRequest('na', 'na/v1.2/champion', [
            'freeToPlay' => 'false',
            'api_key' => 'key',
        ], 'champion.json');

        $api = new Api('key', $this->provider);
        $champion = $api->champion();
        $champions = $champion->all();
        $count = 0;
        foreach ($champions as $champion) {
            ++$count;
        }
        $this->assertEquals(count($champions), $count);
    }

    public function testFree() {
        $this->setUpProviderRequest('na', 'na/v1.2/champion', [
            'freeToPlay' => 'true',
            'api_key' => 'key',
        ], 'champion.free.json');

        $api = new Api('key', $this->provider);
        $free = $api->champion()->free();
        $this->assertEquals(10, count($free->champions));
    }

    public function testFreeCountable() {
        $this->setUpProviderRequest('na', 'na/v1.2/champion', [
            'freeToPlay' => 'true',
            'api_key' => 'key',
        ], 'champion.free.json');

        $api = new Api('key', $this->provider);
        $free = $api->champion()->free();
        $this->assertEquals(10, count($free));
    }

    public function testChampionById() {
        $this->setUpProviderRequest('na', 'na/v1.2/champion/10', [
            'api_key' => 'key',
        ], 'champion.10.json');

        $api = new Api('key', $this->provider);
        $kayle = $api->champion()->championById(10);
        $this->assertEquals(true, $kayle->rankedPlayEnabled);
    }

    public function testAllRegionKR() {
        $this->setUpProviderRequest('kr', 'kr/v1.2/champion', [
            'freeToPlay' => 'false',
            'api_key' => 'key',
        ], 'champion.kr.json');

        $api = new Api('key', $this->provider);
        $api->setRegion('kr');
        $champion = $api->champion();
        $champions = $champion->all();
        $this->assertTrue($champions->getChampion(53) instanceof LeagueWrap\Dto\Champion);
    }

    public function testAllRegionRU() {
        $this->setUpProviderRequest('ru', 'ru/v1.2/champion', [
            'freeToPlay' => 'false',
            'api_key' => 'key',
        ], 'champion.kr.json');

        $api = new Api('key', $this->provider);
        $api->setRegion('RU');
        $champion = $api->champion();
        $champions = $champion->all();
        $this->assertTrue($champions->getChampion(53) instanceof LeagueWrap\Dto\Champion);
    }

}
