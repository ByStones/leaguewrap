<?php

use LeagueWrap\Api;

class ApiGameTest extends TestCase {

    public function testRecent() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.3/game/by-summoner/74602/recent', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/game.recent.74602.json'));

        $api = new Api('key', $this->provider);
        $games = $api->game()->recent(74602);
        $this->assertTrue($games instanceof LeagueWrap\Dto\RecentGames);
    }

    public function testRecentArrayAccess() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.3/game/by-summoner/74602/recent', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/game.recent.74602.json'));

        $api = new Api('key', $this->provider);
        $games = $api->game()->recent(74602);
        $this->assertTrue($games[0] instanceof LeagueWrap\Dto\Game);
    }

    public function testRecentSummoner() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.3/game/by-summoner/74602/recent', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/game.recent.74602.json'));
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/bakasan', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/summoner.bakasan.json'));

        $api = new Api('key', $this->provider);
        $bakasan = $api->summoner()->info('bakasan');
        $games = $api->game()->recent($bakasan);
        $this->assertTrue($bakasan->recentGame(0) instanceof LeagueWrap\Dto\Game);
    }

    public function testRecentStatsSummoner() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.3/game/by-summoner/74602/recent', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/game.recent.74602.json'));
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/bakasan', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/summoner.bakasan.json'));

        $api = new Api('key', $this->provider);
        $bakasan = $api->summoner()->info('bakasan');
        $games = $api->game()->recent($bakasan);
        $game = $bakasan->recentGame(0);
        $this->assertEquals(13, $game->stats->level);
    }

}
