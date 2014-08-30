<?php

namespace LeagueWrap\Api;

use LeagueWrap\Dto\RecentGames;

class Game extends AbstractApi {

    /**
     * Valid version for this api call.
     *
     * @var array
     */
    protected $versions = [
        'v1.3',
    ];

    /**
     * Get the recent games by summoner id.
     *
     * @param mixed $id
     * @return array
     */
    public function recent($identity) {
        $id = $this->extractId($identity);

        $array = $this->request('game/by-summoner/' . $id . '/recent');
        $games = new RecentGames($array);

        $this->attachResponse($identity, $games, 'recentGames');

        return $games;
    }

}
