<?php

namespace LeagueWrap\Api;

use LeagueWrap\Region;

class Matchhistory extends AbstractApi {

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

    /**
     * Get the match history by summoner id.
     *
     * @param mixed $id
     * @return array
     */
    public function history($identity) {
        $id = $this->extractId($identity);

        $array = $this->request('matchhistory/' . $id);
        $matchhistory = new \LeagueWrap\Dto\MatchHistory($array);

        $this->attachResponse($identity, $matchhistory, 'matchhistory');

        return $matchhistory;
    }

}
