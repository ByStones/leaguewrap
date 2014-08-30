<?php

use LeagueWrap\Api;

class ApiLeagueTest extends TestCase {

    public function testLeague() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.5/league/by-summoner/272354', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/league.272354.json'));

        $api = new Api('key', $this->provider);
        $leagues = $api->league()->league(272354);
        $this->assertTrue($leagues[0] instanceof LeagueWrap\Dto\League);
    }

    /**
     * @expectedException LeagueWrap\Exception\ListMaxException
     */
    public function testLeagueListMaxException() {
        $api = new Api('key', $this->provider);
        $leagues = $api->league()->league([
            0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
            10, 11, 12,
        ]);
    }

    public function testLeagueSummoner() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.5/league/by-summoner/272354', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/league.272354.json'));
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/GamerXz', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/summoner.gamerxz.json'));

        $api = new Api('key', $this->provider);
        $gamerxz = $api->summoner()->info('GamerXz');
        $api->league()->league($gamerxz);
        $this->assertTrue($gamerxz->league('GamerXz') instanceof LeagueWrap\Dto\League);
    }

    public function testLeagueSummonerEntry() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.5/league/by-summoner/272354', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/league.272354.json'));
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/GamerXz', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/summoner.gamerxz.json'));

        $api = new Api('key', $this->provider);
        $gamerxz = $api->summoner()->info('GamerXz');
        $api->league()->league($gamerxz);
        $first = $gamerxz->league('GamerXz')->entry(19382070);
        $this->assertEquals('Waraight', $first->playerOrTeamName);
    }

    public function testLeagueEntryArrayAccess() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.5/league/by-summoner/272354', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/league.272354.json'));

        $api = new Api('key', $this->provider);
        $leagues = $api->league()->league(272354);
        $first = $leagues[0][0];
        $this->assertEquals('Midget1', $first->playerOrTeamName);
    }

    public function testLeagueSummonerPlayerOrTeam() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.5/league/by-summoner/272354', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/league.272354.json'));
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/GamerXz', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/summoner.gamerxz.json'));

        $api = new Api('key', $this->provider);
        $gamerxz = $api->summoner()->info('GamerXz');
        $api->league()->league($gamerxz);
        $myTeam = $gamerxz->league('gamerxz')->entry('B Manager');
        $this->assertEquals(2, $myTeam->miniSeries->target);
    }

    public function testLeagueMultiple() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.5/league/by-summoner/74602,272354', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/league.74602.272354.json'));

        $api = new Api('key', $this->provider);
        $summoners = $api->league()->league([
            74602,
            272354,
        ]);
        $this->assertTrue($summoners[272354][0] instanceof LeagueWrap\Dto\League);
    }

    public function testLeagueMultipleSummoners() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.4/summoner/74602,272354,7024', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/summoner.74602.272354.7024.json'));
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.5/league/by-summoner/272354,7024,74602', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/league.74602.272354.7024.json'));

        $api = new Api('key', $this->provider);
        $summoners = $api->summoner()->info([
            74602,
            272354,
            7024,
        ]);
        $api->league()->league($summoners);
        $this->assertTrue($summoners['bakasan']->leagues[0] instanceof LeagueWrap\Dto\League);
    }

    public function testEntry() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.5/league/by-summoner/74602/entry', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/league.74602.entry.json'));

        $api = new Api('key', $this->provider);
        $league = $api->league()->league(74602, true);
        $this->assertEquals(10, $league[0]->playerOrTeam->leaguePoints);
    }

    public function testEntrySummoners() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v1.4/summoner/74602,272354,7024', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/summoner.74602.272354.7024.json'));
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.5/league/by-summoner/272354,7024,74602/entry', [
                    'api_key' => 'key',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/league.74602.272354.7024.entry.json'));

        $api = new Api('key', $this->provider);
        $summoners = $api->summoner()->info([
            74602,
            272354,
            7024,
        ]);
        $api->league()->league($summoners, true);
        $this->assertTrue($summoners['GamerXz']->leagues[0] instanceof LeagueWrap\Dto\League);
    }

    public function testChallenger() {
        $this->provider->shouldReceive('request')
                ->with('https://na.api.pvp.net/api/lol/na/v2.5/league/challenger', [
                    'api_key' => 'key',
                    'type' => 'RANKED_SOLO_5x5',
                ])->once()
                ->andReturn(file_get_contents('tests/Json/league.challenger.json'));

        $api = new Api('key', $this->provider);
        $league = $api->league()->challenger();
        $this->assertEquals(799, $league->entry('C9 Hai')->leaguePoints);
    }

}
