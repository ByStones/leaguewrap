<?php

namespace LeagueWrap\Api;

use LeagueWrap\Dto;
use LeagueWrap\Exception\ListMaxException;

class Team extends AbstractApi {

    /**
     * A list of all the teams we have received so far.
     *
     * @param array
     */
    protected $teams = [];

    /**
     * Valid version for this api call.
     *
     * @var array
     */
    protected $versions = [
        'v2.4',
    ];

    /**
     * A list of all permitted regions for the Champion api call.
     *
     * @param array
     */
    protected $permittedRegions = [
        'br',
        'eune',
        'euw',
        'lan',
        'las',
        'na',
        'oce',
        'ru',
        'tr',
        'kr',
    ];

    /**
     * Gets the team information by summoner id or list of summoner ids.
     *
     * @param mixed $identity
     * @return array
     * @throws ListMaxException
     */
    public function team($identities) {
        if (is_array($identities) && count($identities) > 10) {
            throw new ListMaxException('This request can only support a list of 10 elements, ' . count($identities) . ' given.');
        }

        $ids = $this->extractIds($identities);
        $ids = implode(',', $ids);

        $array = $this->request('team/by-summoner/' . $ids);

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

        $this->attachResponses($identities, $summoners, 'teams');

        return is_array($identities) ? $summoners : reset($summoners);
    }

}
