<?php

namespace LeagueWrap\Api;

use LeagueWrap\Dto;
use LeagueWrap\Dto\RunePage;
use LeagueWrap\Dto\Rune;
use LeagueWrap\Dto\MasteryPage;
use LeagueWrap\Dto\Mastery;
use LeagueWrap\Exception\ListMaxException;

class Summoner extends AbstractApi {

    /**
     * The summoners we have loaded.
     *
     * @var array
     */
    protected $summoners = [];

    /**
     * Valid version for this api call.
     *
     * @var array
     */
    protected $versions = [
        'v1.4',
    ];

    /**
     * Attempt to get a summoner by key.
     *
     * @param string $key
     * @return object|null
     */
    public function __get($key) {
        return $this->get($key);
    }

    /**
     * Attempt to get a summoner by key.
     *
     * @param string $key
     * @return object|null
     */
    public function get($key) {
        $key = strtolower($key);
        if (array_key_exists($key, $this->summoners)) {
            return $this->summoners[$key];
        }

        return null;
    }

    /**
     * Gets the information about the user by the given identification.
     *
     * @param mixed $identities
     * @param bool $strict (Optional) True to require IDs to be of type int, false to allow string IDs. Default false.
     * @return Dto\Summoner
     */
    public function info($identities, $strict = false) {
        $ids = [];
        $names = [];
        if (is_array($identities)) {
            foreach ($identities as $identity) {
                if (filter_var($identity, FILTER_VALIDATE_INT) !== FALSE &&
                        (!$strict || gettype($identity) === 'integer')) {
                    // it's the id
                    $ids[] = $identity;
                } else {
                    // the summoner name
                    $names[] = $identity;
                }
            }
        } else {
            if (filter_var($identities, FILTER_VALIDATE_INT) !== FALSE &&
                    (!$strict || gettype($identities) === 'integer')) {
                // it's the id
                $ids[] = $identities;
            } else {
                // the summoner name
                $names[] = $identities;
            }
        }
        $summoners = [];
        if (count($ids) > 0) {
            // it's the id
            $ids = $this->infoById($ids);
            if (!is_array($ids)) {
                $ids = [$ids->name => $ids];
            }
        }
        if (count($names) > 0) {
            // the summoner name
            $names = $this->infoByName($names);
            if (!is_array($names)) {
                $names = [$names->name => $names];
            }
        }

        $summoners = $ids + $names;

        return count($summoners) === 1 ? reset($summoners) : $summoners;
    }

    /**
     * Attempts to get all information about this user. This method
     * will make 3 requests!
     *
     * @param mixed $identities
     * @return Dto\Summoner;
     */
    public function allInfo($identities) {
        $summoners = $this->info($identities);
        $this->runePages($summoners);
        $this->masteryPages($summoners);

        return $summoners;
    }

    /**
     * Gets the name of each summoner from a list of ids.
     *
     * @param mixed $identities
     * @return array
     */
    public function name($identities) {
        $ids = $this->extractIds($identities);
        $ids = implode(',', $ids);

        $array = $this->request('summoner/' . $ids . '/name');

        return $array;
    }

    /**
     * Gets all rune pages of the given user object or id.
     *
     * @param mixed $identities
     * @return array
     */
    public function runePages($identities) {
        $ids = $this->extractIds($identities);
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

        $this->attachResponses($identities, $summoners, 'runePages');

        return count($summoners) === 1 ? reset($summoners) : $summoners;
    }

    /**
     * Gets all the mastery pages of the given user object or id.
     *
     * @param mixed $identities
     * @return array
     */
    public function masteryPages($identities) {
        $ids = $this->extractIds($identities);
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

        $this->attachResponses($identities, $summoners, 'masteryPages');

        return count($summoners) === 1 ? reset($summoners) : $summoners;
    }

    /**
     * Gets the information by the id of the summoner.
     *
     * @param array $ids
     * @return Dto\Summoner|Dto\Summoner[];
     * @throws ListMaxException
     */
    protected function infoById($ids) {
        if (is_array($ids)) {
            if (count($ids) > 40) {
                throw new ListMaxException('This request can only support a list of 40 elements, ' . count($ids) . ' given.');
            }
            $ids = implode(',', $ids);
        }
        $array = $this->request('summoner/' . $ids);
        $summoners = [];
        foreach ($array as $id => $info) {
            $summoner = new Dto\Summoner($info);
            $name = $summoner->name;
            $this->summoners[$name] = $summoner;
            $summoners[$name] = $summoner;
        }

        return count($summoners) === 1 ? reset($summoners) : $summoners;
    }

    /**
     * Gets the information by the name of the summoner.
     *
     * @param mixed $name
     * @return Dto\Summoner|Dto\Summoner[];
     * @throws ListMaxException
     */
    protected function infoByName($names) {
        if (is_array($names)) {
            if (count($names) > 40) {
                throw new ListMaxException('this request can only support a list of 40 elements, ' . count($ids) . ' given.');
            }
            $names = implode(',', $names);
        }

        // clean the name
        $names = htmlspecialchars($names);
        $array = $this->request('summoner/by-name/' . $names);
        $summoners = [];
        foreach ($array as $name => $info) {
            $summoner = new Dto\Summoner($info);
            $this->summoners[$name] = $summoner;
            $summoners[$name] = $summoner;
        }

        return count($summoners) === 1 ? reset($summoners) : $summoners;
    }

}
