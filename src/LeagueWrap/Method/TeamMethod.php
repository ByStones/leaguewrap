<?php

namespace LeagueWrap\Method;

use LeagueWrap\Dto;
use LeagueWrap\Exception\ListMaxException;

class TeamMethod extends AbstractMethod {

    /**
     * Valid version for this api call.
     *
     * @var array
     */
    protected $versions = [
        'v2.4',
    ];

    public function findBySummonerId($id) {
        $data = $this->findBySummonerIds([$id]);

        return $data[$id];
    }

    public function findBySummonerIds(array $ids) {
        if (count($ids) > 10) {
            throw new ListMaxException('This request can only support a list of 10 elements, ' . count($ids) . ' given.');
        }

        $array = $this->request('team/by-summoner/' . implode(',', $ids));

        $summoners = [];
        foreach ($array as $summonerId => $summonerTeams) {
            $teams = [];
            foreach ($summonerTeams as $info) {
                $id = $info['fullId'];
                $team = new Dto\Team($info);
                $teams[$id] = $team;
            }
            $summoners[$summonerId] = $teams;

            foreach ($teams as $id => $team) {
                $this->teams[$id] = $team;
            }
        }

        return $summoners;
    }

}
