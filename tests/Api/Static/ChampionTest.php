<?php

use LeagueWrap\Api;

class ChampionTest extends StaticTestCase {

    public function testGetChampionDefault() {
        $this->setUpProviderRequest('na/v1.2/champion', [
            'api_key' => 'key',
            'dataById' => 'true',
        ], 'champion.json');

        $api = new Api('key', $this->provider);
        $champions = $api->staticData()->getChampions();
        $champion = $champions->getChampion(53);
        $this->assertEquals('Blitzcrank', $champion->name);
    }

    public function testArrayAccess() {
        $this->setUpProviderRequest('na/v1.2/champion', [
            'api_key' => 'key',
            'dataById' => 'true',
        ], 'champion.json');

        $api = new Api('key', $this->provider);
        $champions = $api->staticData()->getChampions();
        $this->assertEquals('Blitzcrank', $champions[53]->name);
    }

    public function testGetChampionRegionFR() {
        $this->setUpProviderRequest('na/v1.2/champion', [
            'api_key' => 'key',
            'dataById' => 'true',
            'locale' => 'fr_FR',
        ], 'champion.fr.json');

        $api = new Api('key', $this->provider);
        $champions = $api->staticData()->setLocale('fr_FR')
                ->getChampions();
        $champion = $champions->getChampion(69);
        $this->assertEquals('Étreinte du serpent', $champion->title);
    }

    public function testGetChampionById() {
        $this->setUpProviderRequest('na/v1.2/champion/266', [
            'api_key' => 'key',
            'locale' => 'fr_FR',
        ], 'champion.266.fr.json');

        $api = new Api('key', $this->provider);
        $champion = $api->staticData()->setLocale('fr_FR')
                ->getChampion(266);
        $this->assertEquals('Aatrox', $champion->name);
    }

    public function testGetChampionTags() {
        $this->setUpProviderRequest('na/v1.2/champion', [
            'api_key' => 'key',
            'dataById' => 'true',
            'locale' => 'fr_FR',
            'champData' => 'tags',
        ], 'champion.fr.tags.json');

        $api = new Api('key', $this->provider);
        $champions = $api->staticData()->setLocale('fr_FR')
                ->getChampion('all', 'tags');
        $champion = $champions->getChampion(412);
        $this->assertEquals('Support', $champion->tags[0]);
    }

    public function testGetChampionAll() {
        $this->setUpProviderRequest('na/v1.2/champion', [
            'api_key' => 'key',
            'dataById' => 'true',
            'champData' => 'all',
        ], 'champion.all.json');

        $api = new Api('key', $this->provider);
        $champions = $api->staticData()->getChampions('all');
        $champion = $champions->getChampion(412);
        $this->assertEquals('beginner_Starter', $champion->recommended[0]->blocks[0]->type);
    }

}
