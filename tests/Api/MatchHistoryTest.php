<?php

use LeagueWrap\Api;

class ApiMatchHistoryTest extends TestCase {

    public function testMatchHistory() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.2/matchhistory/74602', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/matchhistory.74602.json'));

        $api = new Api('key', $this->provider);
        $matches = $api->matchHistory()->history(74602);
        $this->assertTrue($matches instanceof LeagueWrap\Dto\MatchHistory);
    }

    public function testMatchHistoryArrayAccess() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.2/matchhistory/74602', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/matchhistory.74602.json'));

        $api = new Api('key', $this->provider);
        $matches = $api->matchHistory()->history(74602);
        $this->assertTrue($matches->match(0) instanceof LeagueWrap\Dto\Match);
    }

    public function testHistorySummoner() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.2/matchhistory/74602', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/matchhistory.74602.json'));
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/bakasan', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/summoner.bakasan.json'));

        $api = new Api('key', $this->provider);
        $bakasan = $api->summoner()->info('bakasan');
        $matches = $api->matchHistory()->history($bakasan);
        ;
        $this->assertTrue($bakasan->matchhistory->match(0) instanceof LeagueWrap\Dto\Match);
    }

    public function testParticipant() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.2/matchhistory/74602', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/matchhistory.74602.json'));

        $api = new Api('key', $this->provider);
        $matches = $api->matchHistory()->history(74602);
        $this->assertEquals(100, $matches->match(0)->participant(0)->teamId);
    }

    public function testParticipantStats() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.2/matchhistory/74602', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/matchhistory.74602.json'));

        $api = new Api('key', $this->provider);
        $matches = $api->matchHistory()->history(74602);
        $this->assertEquals(17, $matches->match(0)->participant(0)->stats->champLevel);
    }

    public function testParticipantTimeline() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.2/matchhistory/74602', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/matchhistory.74602.json'));

        $api = new Api('key', $this->provider);
        $matches = $api->matchHistory()->history(74602);
        $this->assertEquals("BOTTOM", $matches->match(0)->participant(0)->timeline->lane);
    }

    public function testParticipantIdentity() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.2/matchhistory/74602', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/matchhistory.74602.json'));

        $api = new Api('key', $this->provider);
        $matches = $api->matchHistory()->history(74602);
        $this->assertEquals(0, $matches->match(0)->identity(0)->participantId);
    }

}
