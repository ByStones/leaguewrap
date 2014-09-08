<?php

use LeagueWrap\Api;

class TeamMethodTest extends MethodTestCase {

    public function testTeam() {
        $this->setUpProviderRequest('na', 'na/v2.4/team/by-summoner/492066', [
            'api_key' => 'key',
        ], 'team.492066.json');

        $api = new Api('key', $this->provider);
        $teams = $api->team->findBySummonerId(492066);

        $this->assertEquals('C9', $teams['TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa']->tag);
    }

    public function testTeamListMaxException() {
        $api = new Api('key', $this->provider);

        $this->setExpectedException('LeagueWrap\Exception\ListMaxException');
        $teams = $api->team->findBySummonerIds(range(1, 11));
    }

    public function testTeamArrayAccess() {
        $this->setUpProviderRequest('na', 'na/v2.4/team/by-summoner/492066', [
            'api_key' => 'key',
        ], 'team.492066.json');

        $api = new Api('key', $this->provider);
        $teams = $api->team->findBySummonerId(492066);
        $c9 = $teams['TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa'];

        $this->assertTrue($c9[0] instanceof LeagueWrap\Dto\Team\Match);
    }

    public function testTeamRosterArrayAccess() {
        $this->setUpProviderRequest('na', 'na/v2.4/team/by-summoner/492066', [
            'api_key' => 'key',
        ], 'team.492066.json');

        $api = new Api('key', $this->provider);
        $teams = $api->team->findBySummonerId(492066);
        $c9 = $teams['TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa'];

        $this->assertTrue($c9->roster[19302712] instanceof LeagueWrap\Dto\Team\Member);
    }

    public function testTeamMultiple() {
        $this->setUpProviderRequest('na', 'na/v2.4/team/by-summoner/18991200,492066', [
            'api_key' => 'key',
        ], 'team.18991200.492066.json');

        $api = new Api('key', $this->provider);
        $teams = $api->team->findBySummonerIds([
            18991200,
            492066,
        ]);

        $this->assertTrue($teams[18991200]['TEAM-00e058f0-bb04-46c5-bac1-07cebcc1cef1'] instanceof LeagueWrap\Dto\Team);
    }

}
