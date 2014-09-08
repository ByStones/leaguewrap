<?php

use LeagueWrap\Api;

class MatchhistoryMethodTest extends MethodTestCase {

    public function testMatchHistory() {
        $this->setUpProviderRequest('na', 'na/v2.2/matchhistory/74602', [
            'api_key' => 'key',
        ], 'matchhistory.74602.json');

        $api = new Api('key', $this->provider);
        $matches = $api->matchhistory->findBySummonerId(74602);

        $this->assertTrue($matches instanceof LeagueWrap\Dto\MatchHistory);
    }

    public function testMatchHistoryArrayAccess() {
        $this->setUpProviderRequest('na', 'na/v2.2/matchhistory/74602', [
            'api_key' => 'key',
        ], 'matchhistory.74602.json');

        $api = new Api('key', $this->provider);
        $matches = $api->matchhistory->findBySummonerId(74602);

        $this->assertTrue($matches->match(0) instanceof LeagueWrap\Dto\Match);
    }

    public function testParticipant() {
        $this->setUpProviderRequest('na', 'na/v2.2/matchhistory/74602', [
            'api_key' => 'key',
        ], 'matchhistory.74602.json');

        $api = new Api('key', $this->provider);
        $matches = $api->matchhistory->findBySummonerId(74602);
        
        $this->assertEquals(100, $matches->match(0)->participant(0)->teamId);
    }

    public function testParticipantStats() {
        $this->setUpProviderRequest('na', 'na/v2.2/matchhistory/74602', [
            'api_key' => 'key',
        ], 'matchhistory.74602.json');

        $api = new Api('key', $this->provider);
        $matches = $api->matchhistory->findBySummonerId(74602);

        $this->assertEquals(17, $matches->match(0)->participant(0)->stats->champLevel);
    }

    public function testParticipantTimeline() {
        $this->setUpProviderRequest('na', 'na/v2.2/matchhistory/74602', [
            'api_key' => 'key',
        ], 'matchhistory.74602.json');

        $api = new Api('key', $this->provider);
        $matches = $api->matchhistory->findBySummonerId(74602);

        $this->assertEquals("BOTTOM", $matches->match(0)->participant(0)->timeline->lane);
    }

    public function testParticipantIdentity() {
        $this->setUpProviderRequest('na', 'na/v2.2/matchhistory/74602', [
            'api_key' => 'key',
        ], 'matchhistory.74602.json');

        $api = new Api('key', $this->provider);
        $matches = $api->matchhistory->findBySummonerId(74602);

        $this->assertEquals(0, $matches->match(0)->identity(0)->participantId);
    }

}
