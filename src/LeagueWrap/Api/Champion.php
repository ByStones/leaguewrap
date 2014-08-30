<?php

namespace LeagueWrap\Api;

use LeagueWrap\Dto\Champion as Champ;
use LeagueWrap\Dto\ChampionList;

class Champion extends AbstractApi {

    /**
     * Valid versions for this api call.
     *
     * @var array
     */
    protected $versions = [
        'v1.2',
    ];

    /**
     * Gets all the champions in the given region.
     *
     * @return ChampionList
     */
    public function all() {
        $params = [
            'freeToPlay' => 'false',
        ];

        $array = $this->request('champion', $params);

        // set up the champions
        return new ChampionList($array);
    }

    /**
     * Gets the information for a single champion
     *
     * @param int $id
     * @return Champ
     */
    public function championById($id) {
        $info = $this->request('champion/' . $id);
        return new Champ($info);
    }

    /**
     * Gets all the free champions for this week.
     *
     * @return championList
     */
    public function free() {
        $params = [
            'freeToPlay' => 'true',
        ];

        $array = $this->request('champion', $params);

        // set up the champions
        return new ChampionList($array);
    }

}
