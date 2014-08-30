<?php

use LeagueWrap\Api;

class RealmTest extends StaticTestCase {

    public function testGetRealmNA() {
        $this->setUpProviderRequest('na/v1.2/realm', [
            'api_key' => 'key',
        ], 'realm.json');

        $api = new Api('key', $this->provider);
        $na = $api->staticData()->getRealm();
        $this->assertEquals('en_US', $na->l);
    }

    public function testGetRealmKR() {
        $this->setUpProviderRequest('kr/v1.2/realm', [
            'api_key' => 'key',
        ], 'realm.kr.json');

        $api = new Api('key', $this->provider);
        $kr = $api->setRegion('kr')
                        ->staticData()->getRealm();
        $this->assertEquals('ko_KR', $kr->l);
    }

}
