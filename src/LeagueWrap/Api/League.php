<?php

namespace LeagueWrap\Api;

use LeagueWrap\Dto;
use LeagueWrap\Exception\ListMaxException;

class League extends AbstractApi {

    /**
     * Valid version for this api call.
     *
     * @var array
     */
    protected $versions = [
        'v2.5',
    ];

    /**
     * Gets the league information by summoner id or list of summoner ids. To only
     * get the single entry information for the summoner(s) ensure that $entry
     * is set to true.
     *
     * @param mixed $identity
     * @param bool $entry
     * @return array
     * @throws ListMaxException
     */
    public function league($identities, $entry = false) {
        if (is_array($identities) && count($identities) > 10) {
            throw new ListMaxException('This request can only support a list of 10 elements, ' . count($identities) . ' given.');
        }

        $ids = $this->extractIds($identities);
        $ids = implode(',', $ids);
        if ($entry) {
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

        $this->attachResponses($identities, $summoners, 'leagues');

        return is_array($identities) ? $summoners : reset($summoners);
    }

    /**
     * Gets the league information for the challenger teams.
     *
     * @param string $type
     * @return array
     */
    public function challenger($type = 'RANKED_SOLO_5x5') {
        $info = $this->request('league/challenger', ['type' => $type]);
        $info['id'] = null;

        return new Dto\League($info);
    }

}
