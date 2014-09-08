<?php

use LeagueWrap\Api;
use LeagueWrap\Dto\MatchTimeline;

class MatchMethodTest extends MethodTestCase {

    public function testMatch() {
        $this->setUpProviderRequest('na', 'na/v2.2/match/1399898747', [
            'api_key' => 'key',
        ], 'matchhistory.match.1399898747.json');

        $api = new Api('key', $this->provider);
        $match = $api->match->findById(1399898747);

        $this->assertTrue($match instanceof LeagueWrap\Dto\Match);
    }

    public function testTeams() {
        $this->setUpProviderRequest('na', 'na/v2.2/match/1399898747', [
            'api_key' => 'key',
        ], 'matchhistory.match.1399898747.json');

        $api = new Api('key', $this->provider);
        $match = $api->match->findById(1399898747);

        $this->assertTrue($match->team(0) instanceof LeagueWrap\Dto\MatchTeam);
    }

    public function testBans() {
        $this->setUpProviderRequest('na', 'na/v2.2/match/1399898747', [
            'api_key' => 'key',
        ], 'matchhistory.match.1399898747.json');

        $api = new Api('key', $this->provider);
        $match = $api->match->findById(1399898747);

        $this->assertTrue($match->team(0)->ban(0) instanceof LeagueWrap\Dto\Ban);
    }

    public function testIncludeTimeline() {
        $this->setUpProviderRequest('na', 'na/v2.2/match/1399898747', [
            'api_key' => 'key',
            'includeTimeline' => 'true',
        ], 'matchhistory.match.1399898747.timeline.json');

        $api = new Api('key', $this->provider);
        $match = $api->match->findById(1399898747, true);

        $this->assertTrue($match instanceof LeagueWrap\Dto\Match);
    }

    public function testTimeline() {
        $this->setUpProviderRequest('na', 'na/v2.2/match/1399898747', [
            'api_key' => 'key',
            'includeTimeline' => 'true',
        ], 'matchhistory.match.1399898747.timeline.json');

        $api = new Api('key', $this->provider);
        $match = $api->match->findById(1399898747, true);

        $this->assertTrue($match->timeline instanceof MatchTimeline);
    }

    public function testTimelineFrame() {
        $this->setUpProviderRequest('na', 'na/v2.2/match/1399898747', [
            'api_key' => 'key',
            'includeTimeline' => 'true',
        ], 'matchhistory.match.1399898747.timeline.json');

        $api = new Api('key', $this->provider);
        $match = $api->match->findById(1399898747, true);
        $frame = $match->timeline->frames[1];

        $this->assertTrue($frame instanceof LeagueWrap\Dto\TimelineFrame);
        $this->assertTrue($frame->participantFrame(1) instanceof LeagueWrap\Dto\TimelineParticipantFrame);
        $this->assertTrue($frame->events[0] instanceof LeagueWrap\Dto\TimelineFrameEvent);
    }

}
