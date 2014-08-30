<?php

use LeagueWrap\Api;

class LeagueMethodTest extends TestCase {

    public function testFindBySummonerId() {
        $this->setUpProviderRequest('na', 'na/v2.5/league/by-summoner/272354', [
            'api_key' => 'key',
        ], 'league.272354.json');

        $api = new Api('key', $this->provider);
        $leagues = $api->league->findBySummonerId(272354);

        $this->assertTrue($leagues[0] instanceof LeagueWrap\Dto\League);
        $this->assertEquals($leagues[0]->name, 'Zilean\'s Urfriders'); 
    }

    public function testFindBySummonerIdsThrowsExceptionOnTooManyIds() {
        $api = new Api('key', $this->provider);

        $this->setExpectedException('LeagueWrap\Exception\ListMaxException');
        $leagues = $api->league()->league(range(1, 11));
    }

    public function testFindBySummonerIds() {
        $this->setUpProviderRequest('na', 'na/v2.5/league/by-summoner/74602,272354', [
            'api_key' => 'key',
        ], 'league.74602.272354.json');

        $api = new Api('key', $this->provider);
        $summoners = $api->league->findBySummonerIds([
            74602,
            272354,
        ]);

        $this->assertTrue($summoners[272354][0] instanceof LeagueWrap\Dto\League);
    }

    public function testFindBySummonerIdOnlyMyself() {
        $this->setUpProviderRequest('na', 'na/v2.5/league/by-summoner/74602/entry', [
            'api_key' => 'key',
        ], 'league.74602.entry.json');

        $api = new Api('key', $this->provider);
        $league = $api->league->findBySummonerId(74602, true);

        $this->assertTrue($league[0] instanceof LeagueWrap\Dto\League);
        $this->assertTrue($league[0]->entries[0] instanceof LeagueWrap\Dto\LeagueEntry);
        $this->assertEquals(1, count($league[0]->entries));
    }

    public function testFindBySummonerIdsShowOnlyMyself() {
        $this->setUpProviderRequest('na', 'na/v2.5/league/by-summoner/272354,7024,74602/entry', [
            'api_key' => 'key',
        ], 'league.74602.272354.7024.entry.json');

        $api = new Api('key', $this->provider);
        $summoners = $api->league->findBySummonerIds([272354, 7024, 74602], true);

        $this->assertTrue($summoners[74602][0] instanceof LeagueWrap\Dto\League);
        $this->assertEquals(1, count($summoners[74602][0]));
    }

    public function testFindChallenger() {
        $this->setUpProviderRequest('na', 'na/v2.5/league/challenger', [
            'api_key' => 'key',
            'type' => 'RANKED_SOLO_5x5',
        ], 'league.challenger.json');

        $api = new Api('key', $this->provider);
        $league = $api->league->findChallenger();

        $this->assertEquals(799, $league->entry('C9 Hai')->leaguePoints);
    }

    public function testFindByTeamId() {
        $this->setUpProviderRequest('euw', 'euw/v2.5/league/by-team/TEAM-1d0ef4a0-2117-11e2-8499-782bcb4ce61a', [
            'api_key' => 'key',
        ], 'league.1d0.json');

        $api = new Api('key', $this->provider);
        $api->setRegion('euw');
        $league = $api->league->findByTeamId('TEAM-1d0ef4a0-2117-11e2-8499-782bcb4ce61a');

        $this->assertTrue($league[0] instanceof LeagueWrap\Dto\League);
        $this->assertEquals(70, count($league[0]->entries));
        $this->assertEquals('Master Yi\'s Swashbucklers', $league[0]->name);
    }

    public function testFindByTeamIds() {
        $this->setUpProviderRequest('euw', 'euw/v2.5/league/by-team/TEAM-1d0ef4a0-2117-11e2-8499-782bcb4ce61a,TEAM-771a9f55-ec02-11e3-8ec3-782bcb4ce61a', [
            'api_key' => 'key',
        ], 'league.1d0.771.json');

        $api = new Api('key', $this->provider);
        $api->setRegion('euw');
        $league = $api->league->findByTeamIds([
            'TEAM-1d0ef4a0-2117-11e2-8499-782bcb4ce61a',
            'TEAM-771a9f55-ec02-11e3-8ec3-782bcb4ce61a',
        ]);

        $this->assertTrue($league['TEAM-1d0ef4a0-2117-11e2-8499-782bcb4ce61a'][0] instanceof LeagueWrap\Dto\League);
        $this->assertEquals(70, count($league['TEAM-1d0ef4a0-2117-11e2-8499-782bcb4ce61a'][0]->entries));
        $this->assertEquals('Master Yi\'s Swashbucklers', $league['TEAM-1d0ef4a0-2117-11e2-8499-782bcb4ce61a'][0]->name);
    }

    public function testFindByTeamIdShowOnlyMyself() {
        $this->markTestIncomplete('TODO');
    }

    public function testFindByTeamIdsShowOnlyMyself() {
        $this->markTestIncomplete('TODO');
    }

}
