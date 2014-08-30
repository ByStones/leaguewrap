<?php

use LeagueWrap\Api;

class ItemTest extends StaticTestCase {

    public function testGetItemDefault() {
        $this->setUpProviderRequest('na/v1.2/item', [
            'api_key' => 'key',
        ], 'items.json');

        $api = new Api('key', $this->provider);
        $items = $api->staticData()->getItems();
        $item = $items->getItem(1001);
        $this->assertEquals('Boots of Speed', $item->name);
    }

    public function testArrayAccess() {
        $this->setUpProviderRequest('na/v1.2/item', [
            'api_key' => 'key',
        ], 'items.json');

        $api = new Api('key', $this->provider);
        $items = $api->staticData()->getItems();
        $this->assertEquals('Boots of Speed', $items[1001]->name);
    }

    public function testGetItemRegionKR() {
        $this->setUpProviderRequest('na/v1.2/item', [
            'api_key' => 'key',
            'locale' => 'ko_KR',
        ], 'items.kr.json');

        $api = new Api('key', $this->provider);
        $items = $api->staticData()->setLocale('ko_KR')
                ->getItems();
        $item = $items->getItem(1042);
        $this->assertEquals('단검', $item->name);
    }

    public function testGetItemById() {
        $this->setUpProviderRequest('na/v1.2/item/1051', [
            'api_key' => 'key',
        ], 'item.1051.json');

        $api = new Api('key', $this->provider);
        $item = $api->staticData()->getItem(1051);
        $this->assertEquals('Brawler\'s Gloves', $item->name);
    }

    public function testGetItemGold() {
        $this->setUpProviderRequest('na/v1.2/item/1051', [
            'api_key' => 'key',
            'itemData' => 'gold',
        ], 'item.1051.gold.json');

        $api = new Api('key', $this->provider);
        $item = $api->staticData()->getItem(1051, 'gold');
        $this->assertEquals(400, $item->gold->base);
    }

    public function testGetItemAll() {
        $this->setUpProviderRequest('na/v1.2/item', [
            'api_key' => 'key',
            'itemListData' => 'all',
        ], 'items.all.json');

        $api = new Api('key', $this->provider);
        $items = $api->staticData()->getItems('all');
        $item = $items->getItem(1042);
        $this->assertEquals(0.12, $item->stats->PercentAttackSpeedMod);
    }

}
