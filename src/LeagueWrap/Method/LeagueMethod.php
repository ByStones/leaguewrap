<?php

namespace LeagueWrap\Method;

use LeagueWrap\Dto;
use LeagueWrap\Exception\ListMaxException;

class LeagueMethod extends AbstractMethod {

    const RANKED_SOLO_5x5 = 'RANKED_SOLO_5x5';
    const RANKED_TEAM_5x5 = 'RANKED_TEAM_5x5';
    const RANKED_TEAM_3x3 = 'RANKED_TEAM_3x3';

    /**
     * Valid version for this api call.
     *
     * @var array
     */
    protected $versions = [
        'v2.5',
    ];

    public function findBySummonerId($id, $showOnlyMyself = false) {
        $leagues = $this->findBySummonerIds([$id], $showOnlyMyself);

        return $leagues[$id];
    }

    public function findBySummonerIds(array $ids, $showOnlyMyself = false) {
        if (count($ids) > 10) {
            throw new ListMaxException('This request can only support a list of 10 elements, ' . count($ids) . ' given.');
        }

        $ids = implode(',', $ids);
        if ($showOnlyMyself === true) {
            $ids .= '/entry';
        }

        $array = $this->request('league/by-summoner/' . $ids);

        $summoners = [];
        foreach ($array as $id => $summonerLeagues) {
            $leagues = [];

            foreach ($summonerLeagues as $info) {
                if (isset($info['participantId'])) {
                    $info['id'] = $info['participantId'];
                } else {
                    $info['id'] = $id;
                }

                $league = new Dto\League($info);
                $leagues[] = $league;
            }

            $summoners[$id] = $leagues;
        }

        return $summoners;
    }

    /**
     * Gets the league information for the challenger teams.
     *
     * @param string $type
     * @return array
     */
    public function findChallenger($type = self::RANKED_SOLO_5x5) {
        $info = $this->request('league/challenger', ['type' => $type]);
        $info['id'] = null;

        return new Dto\League($info);
    }

    public function findByTeamId($teamId, $showOnlyMyself = false) {
        $leagues = $this->findByTeamIds([$teamId], $showOnlyMyself);

        return $leagues[$teamId];
    }

    public function findByTeamIds(array $teamIds, $showOnlyMyself = false) {
        if (count($teamIds) > 10) {
            throw new ListMaxException('This request can only support a list of 10 elements, ' . count($teamIds) . ' given.');
        }

        $uri = 'league/by-team/' . implode(',', $teamIds);

        if ($showOnlyMyself === true) {
            $uri .= '/entry';
        }

        $array = $this->request($uri);

        $teams = [];
        foreach ($array as $id => $teamLeague) {
            $leagues = [];

            foreach ($teamLeague as $info) {
                $info['id'] = $id;
                $league = new Dto\League($info);
                $leagues[] = $league;
            }

            $teams[$id] = $leagues;
        }

        return $teams;
    }

}
