<?php

use LeagueWrap\Api;
use LeagueWrap\Method\StatsMethod;

class StatsMethodTest extends MethodTestCase {

    public function testSummary() {
        $this->setUpProviderRequest('na', 'na/v1.3/stats/by-summoner/74602/summary', [
            'api_key' => 'key',
            'season' => 'SEASON4',
        ], 'stats.summary.74602.season4.json');

        $api = new Api('key', $this->provider);
        $stats = $api->stats->findSummaryBySummonerId(74602, StatsMethod::SEASON4);

        $this->assertTrue($stats instanceof LeagueWrap\Dto\PlayerStatsSummaryList);
    }

    public function testSummaryArrayAccess() {
        $this->setUpProviderRequest('na', 'na/v1.3/stats/by-summoner/74602/summary', [
            'api_key' => 'key',
            'season' => 'SEASON4',
        ], 'stats.summary.74602.season4.json');

        $api = new Api('key', $this->provider);
        $stats = $api->stats->findSummaryBySummonerId(74602, StatsMethod::SEASON4);

        $this->assertTrue($stats[0] instanceof LeagueWrap\Dto\PlayerStatsSummary);
    }

    public function testRanked() {
        $this->setUpProviderRequest('na', 'na/v1.3/stats/by-summoner/74602/ranked', [
            'api_key' => 'key',
            'season' => 'SEASON4',
        ], 'stats.ranked.74602.season4.json');

        $api = new Api('key', $this->provider);
        $stats = $api->stats->findRankedBySummonerId(74602, StatsMethod::SEASON4);

        $this->assertTrue($stats->champion(0) instanceof LeagueWrap\Dto\ChampionStats);
    }

    public function testRankedArrayAccess() {
        $this->setUpProviderRequest('na', 'na/v1.3/stats/by-summoner/74602/ranked', [
            'api_key' => 'key',
            'season' => 'SEASON4',
        ], 'stats.ranked.74602.season4.json');

        $api = new Api('key', $this->provider);
        $stats = $api->stats->findRankedBySummonerId(74602, StatsMethod::SEASON4);

        $this->assertTrue($stats[0] instanceof LeagueWrap\Dto\ChampionStats);
    }

}
