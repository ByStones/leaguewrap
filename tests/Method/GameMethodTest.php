<?php

use LeagueWrap\Api;

class GameMethodTest extends MethodTestCase {

    public function testRecent() {
        $this->setUpProviderRequest('na', 'na/v1.3/game/by-summoner/74602/recent', [
            'api_key' => 'key',
        ], 'game.recent.74602.json');

        $api = new Api('key', $this->provider);
        $games = $api->game->findRecentBySummonerId(74602);

        $this->assertTrue($games instanceof LeagueWrap\Dto\RecentGames);
        $this->assertEquals(10, count($games));
    }

    public function testRecentArrayAccess() {
        $this->setUpProviderRequest('na', 'na/v1.3/game/by-summoner/74602/recent', [
            'api_key' => 'key',
        ], 'game.recent.74602.json');

        $api = new Api('key', $this->provider);
        $games = $api->game->findRecentBySummonerId(74602);

        $this->assertTrue($games[0] instanceof LeagueWrap\Dto\Game);
    }

    public function testRecentStatsSummoner() {
        $this->setUpProviderRequest('na', 'na/v1.3/game/by-summoner/74602/recent', [
            'api_key' => 'key',
        ], 'game.recent.74602.json');

        $api = new Api('key', $this->provider);
        $games = $api->game->findRecentBySummonerId(74602);

        $this->assertEquals(13, $games[0]->stats->level);
    }

}
