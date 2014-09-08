<?php

namespace LeagueWrap\Method;

use LeagueWrap\Region;

class MatchhistoryMethod extends AbstractMethod {

    /**
     * Valid version for this api call.
     *
     * @var array
     */
    protected $versions = [
        'v2.2',
    ];

    /**
     * A list of all permitted regions for the Champion api call.
     *
     * @param array
     */
    protected $permittedRegions = [
        Region::BR,
        Region::EUNE,
        Region::EUW,
        Region::LAN,
        Region::LAS,
        Region::NA,
        Region::OCE,
        Region::RU,
        Region::TR,
        Region::KR,
        Region::PBE,
    ];

    public function findBySummonerId($id) {
        $array = $this->request('matchhistory/' . $id);
        $matchhistory = new \LeagueWrap\Dto\MatchHistory($array);

        return $matchhistory;
    }

}
