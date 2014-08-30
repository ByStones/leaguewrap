<?php

use LeagueWrap\Api;

class ApiTeamTest extends TestCase {

    public function testTeam() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.4/team/by-summoner/492066', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/team.492066.json'));

        $api = new Api('key', $this->provider);
        $teams = $api->team()->team(492066);
        $this->assertEquals('C9', $teams['TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa']->tag);
    }

    /**
     * @expectedException LeagueWrap\Exception\ListMaxException
     */
    public function testTeamListMaxException() {
        $api = new Api('key', $this->provider);
        $teams = $api->team()->team([
            0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
            10, 11, 12,
        ]);
    }

    public function testTeamArrayAccess() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.4/team/by-summoner/492066', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/team.492066.json'));

        $api = new Api('key', $this->provider);
        $teams = $api->team()->team(492066);
        $c9 = $teams['TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa'];
        $this->assertTrue($c9[0] instanceof LeagueWrap\Dto\Team\Match);
    }

    public function testTeamRosterArrayAccess() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.4/team/by-summoner/492066', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/team.492066.json'));

        $api = new Api('key', $this->provider);
        $teams = $api->team()->team(492066);
        $c9 = $teams['TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa'];
        $this->assertTrue($c9->roster[19302712] instanceof LeagueWrap\Dto\Team\Member);
    }

    public function testTeamSummoner() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.4/team/by-summoner/492066', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/team.492066.json'));
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/C9 Hai', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/summoner.c9hai.json'));

        $api = new Api('key', $this->provider);
        $hai = $api->summoner()->info('C9 Hai');
        $api->team()->team($hai);
        $this->assertTrue($hai->teams['TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa'] instanceof LeagueWrap\Dto\Team);
    }

    public function testTeamSummonerMember() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.4/team/by-summoner/492066', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/team.492066.json'));
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/C9 Hai', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/summoner.c9hai.json'));

        $api = new Api('key', $this->provider);
        $hai = $api->summoner()->info('C9 Hai');
        $team = $api->team()->team($hai)['TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa'];
        $this->assertEquals('MEMBER', $team->roster->member(19302712)->status);
    }

    public function testTeamMultiple() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.4/team/by-summoner/18991200,492066', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/team.18991200.492066.json'));

        $api = new Api('key', $this->provider);
        $teams = $api->team()->team([
            18991200,
            492066,
        ]);
        $this->assertTrue($teams[18991200]['TEAM-00e058f0-bb04-46c5-bac1-07cebcc1cef1'] instanceof LeagueWrap\Dto\Team);
    }

    public function testTeamSummonerMultiple() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.4/summoner/18991200,492066', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/summoner.18991200.492066.json'));
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.4/team/by-summoner/492066,18991200', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/team.18991200.492066.json'));

        $api = new Api('key', $this->provider);
        $summoners = $api->summoner()->info([
            18991200,
            492066,
        ]);
        $api->team()->team($summoners);
        $team = $summoners['C9 Hai']->teams['TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa'];
        $this->assertEquals('C9', $team->tag);
    }

}
