<?php

namespace LeagueWrap\Api;

use LeagueWrap\Region;

class Match extends AbstractApi {

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
     * Get the match by match id.
     *
     * @param int $id
     * @param bool $includeTimeline
     * @return Match
     */
    public function match($id, $includeTimeline = false) {
        if ($includeTimeline) {
            $response = $this->request('match/' . $id, array('includeTimeline' => $includeTimeline));
        } else {
            $response = $this->request('match/' . $id);
        }

        return new \LeagueWrap\Dto\Match($response);
    }

}
