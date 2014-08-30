<?php

use LeagueWrap\Api;

class SummonerSpellTest extends StaticTestCase {

    public function testGetSummonerSpellDefault() {
        $this->setUpProviderRequest('na/v1.2/summoner-spell', [
            'api_key' => 'key',
            'dataById' => 'true',
        ], 'summonerspell.json');

        $api = new Api('key', $this->provider);
        $spells = $api->staticData()->getSummonerSpells();
        $spell = $spells->getSpell(12);
        $this->assertEquals('Teleport', $spell->name);
    }

    public function testArrayAccess() {
        $this->setUpProviderRequest('na/v1.2/summoner-spell', [
            'api_key' => 'key',
            'dataById' => 'true',
        ], 'summonerspell.json');

        $api = new Api('key', $this->provider);
        $spells = $api->staticData()->getSummonerSpells();
        $this->assertEquals('Teleport', $spells[12]->name);
    }

    public function testGetSummonerSpellRegionTR() {
        $this->setUpProviderRequest('tr/v1.2/summoner-spell', [
            'api_key' => 'key',
            'dataById' => 'true',
        ], 'summonerspell.tr.json');

        $api = new Api('key', $this->provider);
        $spells = $api->setRegion('tr')
                        ->staticData()->getSummonerSpells();
        $spell = $spells->getSpell(6);
        $this->assertEquals('Hayalet', $spell->name);
    }

    public function testGetSummonerSpellById() {
        $this->setUpProviderRequest('na/v1.2/summoner-spell/1', [
            'api_key' => 'key',
        ], 'summonerspell.1.json');

        $api = new Api('key', $this->provider);
        $spell = $api->staticData()->getSummonerSpell(1);
        $this->assertEquals('2', $spell->summonerLevel);
    }

    public function testGetSummonerSpellAll() {
        $this->setUpProviderRequest('na/v1.2/summoner-spell', [
            'api_key' => 'key',
            'dataById' => 'true',
            'spellData' => 'all',
        ], 'summonerspell.all.json');

        $api = new Api('key', $this->provider);
        $spells = $api->staticData()->getSummonerSpells('all');
        $spell = $spells->getSpell(7);
        $this->assertEquals('f1', $spell->vars[0]->key);
    }

}
