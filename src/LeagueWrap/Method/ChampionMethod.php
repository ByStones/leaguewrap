<?php

namespace LeagueWrap\Method;

use LeagueWrap\Dto\Champion;
use LeagueWrap\Dto\ChampionList;

class ChampionMethod extends AbstractMethod {

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
    public function findAll($onlyFreeToPlay = false) {
        $params = [];

        if ($onlyFreeToPlay === true) {
            $params['freeToPlay'] = 'true';
        }

        $array = $this->request('champion', $params);

        return new ChampionList($array);
    }

    /**
     * Gets the information for a single champion
     *
     * @param int $id
     * @return Champ
     */
    public function findById($id) {
        $info = $this->request('champion/' . $id);

        return new Champion($info);
    }

    /**
     * Gets all the free champions for this week.
     *
     * @return championList
     */
    public function findFreeToPlay() {
        return $this->findAll(true);
    }

}
