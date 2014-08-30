<?php

use LeagueWrap\Api;

class RuneTest extends StaticTestCase {

    public function testGetRuneDefault() {
        $this->setUpProviderRequest('na/v1.2/rune', [
            'api_key' => 'key',
        ], 'rune.json');

        $api = new Api('key', $this->provider);
        $runes = $api->staticData()->getRunes();
        $rune = $runes->getRune(5129);
        $this->assertEquals('Mark of Critical Chance', $rune->name);
    }

    public function testArrayAccess() {
        $this->setUpProviderRequest('na/v1.2/rune', [
            'api_key' => 'key',
        ], 'rune.json');

        $api = new Api('key', $this->provider);
        $runes = $api->staticData()->getRunes();
        $this->assertEquals('Mark of Critical Chance', $runes[5129]->name);
    }

    public function testGetRuneRegionKR() {
        $this->setUpProviderRequest('kr/v1.2/rune', [
            'api_key' => 'key',
        ], 'rune.kr.json');

        $api = new Api('key', $this->provider);
        $runes = $api->setRegion('kr')
                        ->staticData()->getRunes();
        $rune = $runes->getRune(5267);
        $this->assertEquals('상급 주문력 표식', $rune->name);
    }

    public function testGetRuneById() {
        $this->setUpProviderRequest('na/v1.2/rune/5267', [
            'api_key' => 'key',
        ], 'rune.5267.json');

        $api = new Api('key', $this->provider);
        $rune = $api->staticData()->getRune(5267);
        $this->assertEquals('3', $rune->rune->tier);
    }

    public function testGetRuneImage() {
        $this->setUpProviderRequest('na/v1.2/rune/5001', [
            'api_key' => 'key',
            'runeData' => 'image',
        ], 'rune.5001.image.json');

        $api = new Api('key', $this->provider);
        $rune = $api->staticData()->getRune(5001, 'image');
        $this->assertEquals('r_1_1.png', $rune->image->full);
    }

    public function testGetRuneAll() {
        $this->setUpProviderRequest('na/v1.2/rune', [
            'api_key' => 'key',
            'runeListData' => 'all',
        ], 'rune.all.json');

        $api = new Api('key', $this->provider);
        $runes = $api->staticData()->getRunes('all');
        $rune = $runes->getRune(5001);
        $this->assertEquals('0.525', $rune->stats->FlatPhysicalDamageMod);
    }

}
