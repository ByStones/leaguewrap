<?php

namespace LeagueWrap\Method;

use LeagueWrap\Dto;
use LeagueWrap\Dto\RunePage;
use LeagueWrap\Dto\Rune;
use LeagueWrap\Dto\MasteryPage;
use LeagueWrap\Dto\Mastery;
use LeagueWrap\Exception\ListMaxException;

class SummonerMethod extends AbstractMethod {

    /**
     * Valid version for this api call.
     *
     * @var array
     */
    protected $versions = [
        'v1.4',
    ];

    public function findSummonerNameBySummonerId($id) {
        $data = $this->findSummonerNamesBySummonerIds([$id]);

        return $data[$id];
    }

    public function findSummonerNamesBySummonerIds(array $ids) {
        $ids = implode(',', $ids);

        $array = $this->request('summoner/' . $ids . '/name');

        return $array;
    }

    public function findRunePagesBySummonerId($id) {
        $data = $this->findRunePagesBySummonerIds([$id]);

        return $data[$id];
    }

    public function findRunePagesBySummonerIds(array $ids) {
        $ids = implode(',', $ids);

        $array = $this->request('summoner/' . $ids . '/runes');
        $summoners = [];
        foreach ($array as $summonerId => $data) {
            $runePages = [];
            foreach ($data['pages'] as $info) {
                if (!isset($info['slots'])) {
                    // no runes in this page
                    $info['slots'] = [];
                }

                $slots = $info['slots'];
                unset($info['slots']);

                $runePage = new RunePage($info);

                // set runes
                $runes = [];
                foreach ($slots as $slot) {
                    $id = $slot['runeSlotId'];
                    $rune = new Rune($slot);
                    $runes[$id] = $rune;
                }
                $runePage->runes = $runes;
                $runePages[] = $runePage;
            }
            $summoners[$summonerId] = $runePages;
        }

        return $summoners;
    }

    public function findMasteryPagesBySummonerId($id) {
        $data = $this->findMasteryPagesBySummonerIds([$id]);

        return $data[$id];
    }

    public function findMasteryPagesBySummonerIds($ids) {
        $ids = implode(',', $ids);

        $array = $this->request('summoner/' . $ids . '/masteries');
        $summoners = [];
        foreach ($array as $summonerId => $data) {
            $masteryPages = [];
            foreach ($data['pages'] as $info) {
                if (!isset($info['masteries'])) {
                    // seting the talents to an empty array
                    $info['masteries'] = [];
                }

                $masteriesInfo = $info['masteries'];
                unset($info['masteries']);
                $masteryPage = new MasteryPage($info);
                // set masterys
                $masteries = [];
                foreach ($masteriesInfo as $mastery) {
                    $id = $mastery['id'];
                    $mastery = new Mastery($mastery);
                    $masteries[$id] = $mastery;
                }
                $masteryPage->masteries = $masteries;
                $masteryPages[] = $masteryPage;
            }
            $summoners[$summonerId] = $masteryPages;
        }

        return $summoners;
    }

    public function findById($id) {
        $data = $this->findByIds([$id]);

        return $data[$id];
    }

    public function findByIds(array $ids) {
        if (count($ids) > 40) {
            throw new ListMaxException('This request can only support a list of 40 elements, ' . count($ids) . ' given.');
        }

        $ids = implode(',', $ids);
        $array = $this->request('summoner/' . $ids);
        $summoners = [];
        foreach ($array as $id => $info) {
            $summoner = new Dto\Summoner($info);
            $name = $summoner->name;
            $this->summoners[$name] = $summoner;
            $summoners[$name] = $summoner;
        }

        return $summoners;
    }

    public function findByName($name) {
        $data = $this->findByNames([$name]);

        return $data[$name];
    }

    public function findByNames(array $names) {
        if (count($names) > 40) {
            throw new ListMaxException('this request can only support a list of 40 elements, ' . count($names) . ' given.');
        }

        $names = implode(',', $names);

        //Check whether the names need be escaped and if that should be done here
        $array = $this->request('summoner/by-name/' . $names);

        $summoners = [];
        foreach ($array as $name => $info) {
            $summoner = new Dto\Summoner($info);
            $this->summoners[$name] = $summoner;
            $summoners[$name] = $summoner;
        }

        return $summoners;
    }

}
