<?php

use LeagueWrap\Api;

class MasteryTest extends StaticTestCase {

    public function testGetMasteryDefault() {
        $this->setUpProviderRequest('na/v1.2/mastery', [
            'api_key' => 'key',
        ], 'mastery.json');

        $api = new Api('key', $this->provider);
        $masteries = $api->staticData()->getMasteries();
        $mastery = $masteries->getMastery(4231);
        $this->assertEquals('Oppression', $mastery->name);
    }

    public function testArrayAccess() {
        $this->setUpProviderRequest('na/v1.2/mastery', [
            'api_key' => 'key',
        ], 'mastery.json');

        $api = new Api('key', $this->provider);
        $masteries = $api->staticData()->getMasteries();
        $this->assertEquals('Oppression', $masteries[4231]->name);
    }

    public function testGetMasteryRegionKR() {
        $this->setUpProviderRequest('na/v1.2/mastery', [
            'api_key' => 'key',
            'locale' => 'ko_KR',
        ], 'mastery.kr.json');

        $api = new Api('key', $this->provider);
        $masteries = $api->staticData()->setLocale('ko_KR')
                ->getMasteries();
        $mastery = $masteries->getMastery(4111);
        $this->assertEquals('양날의 검', $mastery->name);
    }

    public function testGetMasteryById() {
        $this->setUpProviderRequest('na/v1.2/mastery/4111', [
            'api_key' => 'key',
        ], 'mastery.4111.json');

        $api = new Api('key', $this->provider);
        $mastery = $api->staticData()->getMastery(4111);
        $this->assertEquals('Double-Edged Sword', $mastery->name);
    }

    public function testGetMasteryRank() {
        $this->setUpProviderRequest('na/v1.2/mastery/4322', [
            'api_key' => 'key',
            'masteryData' => 'ranks',
        ], 'mastery.4322.ranks.json');

        $api = new Api('key', $this->provider);
        $mastery = $api->staticData()->getMastery(4322, 'ranks');
        $this->assertEquals(3, $mastery->ranks);
    }

    public function testGetMasteryAll() {
        $this->setUpProviderRequest('na/v1.2/mastery', [
            'api_key' => 'key',
            'masteryListData' => 'all',
        ], 'mastery.all.json');

        $api = new Api('key', $this->provider);
        $masteries = $api->staticData()->getMasteries('all');
        $mastery = $masteries->getMastery(4322);
        $this->assertEquals('Reduces the cooldown of Summoner Spells by 10%', $mastery->description[2]);
    }

}
