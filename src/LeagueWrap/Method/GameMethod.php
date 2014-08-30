<?php

namespace LeagueWrap\Method;

use LeagueWrap\Dto\RecentGames;

class GameMethod extends AbstractMethod {

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
    public function findRecentBySummonerId($id) {
        $array = $this->request('game/by-summoner/' . $id . '/recent');

        return new RecentGames($array);
    }

}
