<?php

namespace LeagueWrap\Method;

use LeagueWrap\Dto\RankedStats;
use LeagueWrap\Dto\PlayerStatsSummaryList;

class StatsMethod extends AbstractMethod {

    const SEASON3 = 'SEASON3';
    const SEASON4 = 'SEASON4';

    /**
     * Valid version for this api call.
     *
     * @var array
     */
    protected $versions = [
        'v1.3',
    ];

    public function findSummaryBySummonerId($id, $season) {
        $params['season'] = $season;

        $array = $this->request('stats/by-summoner/' . $id . '/summary', $params);
        $stats = new PlayerStatsSummaryList($array);

        return $stats;
    }

    /**
     * Gets the stats for ranked queues only by summary id.
     *
     * @param mixed $identity
     * @return array
     */
    public function findRankedBySummonerId($id, $season) {
        $params['season'] = $season;

        $array = $this->request('stats/by-summoner/' . $id . '/ranked', $params);
        $stats = new RankedStats($array);

        return $stats;
    }

}
