<?php

use LeagueWrap\Api;

class ApiStatsTest extends TestCase {

    public function testSummary() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.3/stats/by-summoner/74602/summary', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/stats.summary.74602.season4.json'));

        $api = new Api('key', $this->provider);
        $stats = $api->stats()->summary(74602);
        $this->assertTrue($stats instanceof LeagueWrap\Dto\PlayerStatsSummaryList);
    }

    public function testSummaryArrayAccess() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.3/stats/by-summoner/74602/summary', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/stats.summary.74602.season4.json'));

        $api = new Api('key', $this->provider);
        $stats = $api->stats()->summary(74602);
        $this->assertTrue($stats[0] instanceof LeagueWrap\Dto\PlayerStatsSummary);
    }

    public function testSummarySummoner() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.3/stats/by-summoner/74602/summary', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/stats.summary.74602.season4.json'));
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/bakasan', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/summoner.bakasan.json'));

        $api = new Api('key', $this->provider);
        $bakasan = $api->summoner()->info('bakasan');
        $api->stats()->summary($bakasan);
        $this->assertTrue($bakasan->stats->playerStat(0) instanceof LeagueWrap\Dto\PlayerStatsSummary);
    }

    public function testRanked() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.3/stats/by-summoner/74602/ranked', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/stats.ranked.74602.season4.json'));

        $api = new Api('key', $this->provider);
        $stats = $api->stats()->ranked(74602);
        $this->assertTrue($stats->champion(0) instanceof LeagueWrap\Dto\ChampionStats);
    }

    public function testRankedArrayAccess() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.3/stats/by-summoner/74602/ranked', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/stats.ranked.74602.season4.json'));

        $api = new Api('key', $this->provider);
        $stats = $api->stats()->ranked(74602);
        $this->assertTrue($stats[0] instanceof LeagueWrap\Dto\ChampionStats);
    }

}
