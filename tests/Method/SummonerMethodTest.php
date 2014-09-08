<?php

use LeagueWrap\Api;

class SummonerMethodTest extends MethodTestCase {

    public function testName() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.4/summoner/74602/name', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/summoner.name.74602.json'));

        $api = new Api('key', $this->provider);
        $name = $api->summoner->findSummonerNameBySummonerId(74602);

        $this->assertEquals('bakasan', $name);
    }

    public function testNameArray() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.4/summoner/74602,7024,97235/name', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/summoner.name.74602,7024,97235.json'));

        $api = new Api('key', $this->provider);
        $names = $api->summoner->findSummonerNamesBySummonerIds([
            74602,
            7024,
            97235,
        ]);

        $this->assertEquals('Jigsaw', $names[7024]);
    }

    public function testRunes() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.4/summoner/74602/runes', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/summoner.runes.74602.json'));

        $api = new Api('key', $this->provider);
        $runes = $api->summoner->findRunePagesBySummonerId(74602);

        $this->assertTrue($runes[0] instanceof LeagueWrap\Dto\RunePage);
    }

    public function testRuneArrayAccess() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.4/summoner/74602/runes', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/summoner.runes.74602.json'));

        $api = new Api('key', $this->provider);
        $runes = $api->summoner->findRunePagesBySummonerId(74602);

        $this->assertTrue($runes[0][30] instanceof LeagueWrap\Dto\Rune);
    }

    public function testMasteries() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.4/summoner/74602/masteries', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/summoner.masteries.74602.json'));

        $api = new Api('key', $this->provider);
        $masteries = $api->summoner->findMasteryPagesBySummonerId(74602);
        
        $this->assertTrue($masteries[0] instanceof LeagueWrap\Dto\MasteryPage);
    }

    public function testMasteriesArrayAccess() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.4/summoner/74602/masteries', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/summoner.masteries.74602.json'));

        $api = new Api('key', $this->provider);
        $masteries = $api->summoner->findMasteryPagesBySummonerId(74602);

        $this->assertTrue($masteries[0][4342] instanceof LeagueWrap\Dto\Mastery);
    }

}
