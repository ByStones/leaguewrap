<?php

namespace LeagueWrap\Method;

use LeagueWrap\Dto\StaticData\Champion;
use LeagueWrap\Dto\StaticData\ChampionList;
use LeagueWrap\Dto\StaticData\Item;
use LeagueWrap\Dto\StaticData\ItemList;
use LeagueWrap\Dto\StaticData\Mastery;
use LeagueWrap\Dto\StaticData\MasteryList;
use LeagueWrap\Dto\StaticData\Rune;
use LeagueWrap\Dto\StaticData\RuneList;
use LeagueWrap\Dto\StaticData\SummonerSpell;
use LeagueWrap\Dto\StaticData\SummonerSpellList;
use LeagueWrap\Dto\StaticData\Realm;

class StaticdataMethod extends AbstractMethod {

    /**
     * The locale you want the response in. By default it is not 
     * passed (null).
     *
     * @var string
     */
    protected $locale = null;

    /**
     * The version of League of Legends that we want data from. By default
     * it is not passed (null).
     *
     * @var string
     */
    protected $DDversion = null;

    /**
     * Valid version for this api call.
     *
     * @var array
     */
    protected $versions = [
        'v1.2',
    ];

    /**
     * Sets the locale the data should be returned in. Null returns
     * the default local for that region.
     *
     * @param string $locale
     * @chainable
     */
    public function setLocale($locale) {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Sets the DDversion to be used in the query. Null will return
     * the most recent version.
     *
     * @param string $DDversion
     * @chainable
     */
    public function setDDversion($DDversion = null) {
        $this->DDversion = $DDversion;

        return $this;
    }

    const CHAMPION_DATA_ALL = 'all';
    const CHAMPION_DATA_ALLYTIPS = 'allytips';
    const CHAMPION_DATA_ALTIMAGES = 'altimages';
    const CHAMPION_DATA_BLURB = 'blurb';
    const CHAMPION_DATA_ENEMYTIPS = 'enemytips';
    const CHAMPION_DATA_IMAGE = 'image';
    const CHAMPION_DATA_INFO = 'info';
    const CHAMPION_DATA_LORE = 'lore';
    const CHAMPION_DATA_PARTYPE = 'partype';
    const CHAMPION_DATA_PASSIVE = 'passive';
    const CHAMPION_DATA_RECOMMENDED = 'recommended';
    const CHAMPION_DATA_SKINS = 'skins';
    const CHAMPION_DATA_SPELLS = 'spells';
    const CHAMPION_DATA_STATS = 'stats';
    const CHAMPION_DATA_TAGS = 'tags';

    /**
     * Gets all static champion data with the given $data option.
     *
     * @param string #data
     * @retrn ChampionList
     */
    public function getChampions($data = null) {
        return $this->getChampion(null, $data);
    }

    /**
     * Gets the static champion data of all champions if $id is null.
     * If $id is set it will attempt to get info for that champion only.
     *
     * @param int $id
     * @param string $data
     * @return ChampionList|Champion
     */
    public function getChampion($id, $data = null) {
        $params = $this->setUpParams($id, $data, 'champData');
        $array = $this->makeRequest('champion', $id, $params);

        return $this->appendId($id) ? new staticChampion($array) : new ChampionList($array);
    }

    const ITEM_DATA_ALL = 'all';
    const ITEM_DATA_COLLOQ = 'colloq';
    const ITEM_DATA_CONSUME_ON_FULL = 'consumeOnFull';
    const ITEM_DATA_CONSUMED = 'consumed';
    const ITEM_DATA_DEPTH = 'depth';
    const ITEM_DATA_FROM = 'from';
    const ITEM_DATA_GOLD = 'gold';
    const ITEM_DATA_GROUPS = 'groups';
    const ITEM_DATA_HIDE_FROM_ALL = 'hideFromAll';
    const ITEM_DATA_IMAGE = 'image';
    const ITEM_DATA_IN_STORE = 'inStore';
    const ITEM_DATA_INTO = 'into';
    const ITEM_DATA_MAPS = 'maps';
    const ITEM_DATA_REQUIRED_CHAMPION = 'requiredChampion';
    const ITEM_DATA_SANITIZED_DESCRIPTION = 'sanitizedDescription';
    const ITEM_DATA_SPECIAL_RECIPE = 'specialRecipe';
    const ITEM_DATA_STACKS = 'stacks';
    const ITEM_DATA_TAGS = 'tags';
    const ITEM_DATA_TREE = 'tree';

    /**
     * Gets static data on all items.
     *
     * @param string $data
     * @return ItemList
     */
    public function getItems($data = null) {
        return $this->getItem(null, $data);
    }

    /**
     * Gets the static item data of all items if $id is null.
     * If $id is set it will attempt to get info for that item only.
     *
     * @param int $id
     * @param string $data
     * @return ItemList|Item
     */
    public function getItem($id, $data = null) {
        $params = $this->setUpParams($id, $data, 'itemListData', 'itemData');
        $array = $this->makeRequest('item', $id, $params);

        return $this->appendId($id) ? new staticItem($array) : new ItemList($array);
    }

    const MASTERY_DATA_ALL = 'all';
    const MASTERY_DATA_IMAGE = 'image';
    const MASTERY_DATA_PREREQ = 'preqreq';
    const MASTERY_DATA_RANKS = 'ranks';
    const MASTERY_DATA_SANITIZED_DESCRIPTION = 'sanitizedDescription';
    const MASTERY_DATA_TREE = 'tree';

    /**
     * Gets static data on all masteries.
     *
     * @param string $data
     * @return MasteryList
     */
    public function getMasteries($data = null) {
        return $this->getMastery(null, $data);
    }

    /**
     * Gets the mastery data of all masteries if $id is null.
     * If $id is a set it will attempt to get info for that mastery only.
     *
     * @param int $id
     * @param string $data
     * @return MasteryList|Mastery
     */
    public function getMastery($id, $data = null) {
        $params = $this->setUpParams($id, $data, 'masteryListData', 'masteryData');
        $array = $this->makeRequest('mastery', $id, $params);

        return $this->appendId($id) ? new staticMastery($array) : new MasteryList($array);
    }

    const RUNE_DATA_ALL = 'all';
    const RUNE_DATA_BASIC = 'basic';
    const RUNE_DATA_COLLOQ = 'colloq';
    const RUNE_DATA_CONSUME_ON_FULL = 'consumeOnFull';
    const RUNE_DATA_CONSUMED = 'consumed';
    const RUNE_DATA_DEPTH = 'depth';
    const RUNE_DATA_FROM = 'from';
    const RUNE_DATA_GOLD = 'gold';
    const RUNE_DATA_HIDE_FROM_ALL = 'hideFromAll';
    const RUNE_DATA_IMAGE = 'image';
    const RUNE_DATA_IN_STORE = 'inStore';
    const RUNE_DATA_INTO = 'into';
    const RUNE_DATA_MAPS = 'maps';
    const RUNE_DATA_REQUIRED_CHAMPION = 'requiredChampion';
    const RUNE_DATA_SANITIZED_DESCRIPTION = 'sanitizedDescription';
    const RUNE_DATA_SPECIAL_RECIPE = 'specialRecipe';
    const RUNE_DATA_STACKS = 'stacks';
    const RUNE_DATA_STATS = 'stats';
    const RUNE_DATA_TAGS = 'tags';
    const RUNE_DATA_TREE = 'tree';

    /**
     * Gets static data on all runes.
     *
     * @param string $data
     * @return RuneList
     */
    public function getRunes($data = null) {
        return $this->getRune('all', $data);
    }

    /**
     * Gets the rune data of all runes if $id is null.
     * If $id is set it will attempt to get info for that rune only.
     *
     * $param int $id
     * @param string $data
     * @return RuneList|Rune
     */
    public function getRune($id, $data = null) {
        $params = $this->setUpParams($id, $data, 'runeListData', 'runeData');
        $array = $this->makeRequest('rune', $id, $params);

        return $this->appendId($id) ? new staticRune($array) : new RuneList($array);
    }

    const SUMMONER_SPELL_DATA_ALL = 'all';
    const SUMMONER_SPELL_DATA_COOLDOWN = 'cooldown';
    const SUMMONER_SPELL_DATA_COOLDOWN_BURN = 'cooldownBurn';
    const SUMMONER_SPELL_DATA_COST = 'cost';
    const SUMMONER_SPELL_DATA_CUST_BURN = 'costBurn';
    const SUMMONER_SPELL_COST_TYPE = 'costType';
    const SUMMONER_SPELL_EFFECT = 'effect';
    const SUMMONER_SPELL_EFFECT_BURN = 'effectBurn';
    const SUMMONER_SPELL_IMAGE = 'image';
    const SUMMONER_SPELL_KEY = 'key';
    const SUMMONER_SPELL_LEVELTIP = 'leveltip';
    const SUMMONER_SPELL_MAXRANK = 'maxrank';
    const SUMMONER_SPELL_MODES = 'modes';
    const SUMMONER_SPELL_RANGE = 'range';
    const SUMMONER_SPELL_RANGE_BURN = 'rangeBurn';
    const SUMMONER_SPELL_RESOURCE = 'resource';
    const SUMMONER_SPELL_SANITIZED_DESCRIPTION = 'sanitizedDescription';
    const SUMMONER_SPELL_SANITIZED_TOOLTIP = 'sanitizedTooltip';
    const SUMMONER_SPELL_TOOLTIP = 'tooltip';
    const SUMMONER_SPELL_VARS = 'vars';

    /**
     * Gets static data on all summoner spells.
     *
     * @param string $data
     * @return SummonerSpellList
     */
    public function getSummonerSpells($data = null) {
        return $this->getSummonerSpell('all', $data);
    }

    /**
     * Gets the summoner spell data of all spells if $id is null
     * If $id is set it will attept to get info for that spell only.
     * 
     * @param int $id
     * @param string $data
     * @return SummonerSpell|SummonerSpellList
     */
    public function getSummonerSpell($id, $data = null) {
        $params = $this->setUpParams($id, $data, 'spellData');
        $array = $this->makeRequest('summoner-spell', $id, $params);

        return $this->appendId($id) ? new staticSummonerSpell($array) : new SummonerSpellList($array);
    }

    /**
     * Get the realm information for the current region.
     *
     * @return Realm
     */
    public function getRealm() {
        $params = $this->setUpParams();
        $array = $this->makeRequest('realm', null, $params);

        return new staticRealm($array);
    }

    /**
     * Get the version information for the current region.
     *
     * @return Array
     */
    public function version() {
        $params = $this->setUpParams();
        return $this->makeRequest('versions', null, $params);
    }

    /**
     * Make the request given the proper information.
     *
     * @param string $path
     * @param mixed $id
     * @param array $params
     * @return array
     */
    protected function makeRequest($path, $id, array $params) {
        if ($this->appendId($id)) {
            $path .= "/$id";
        }

        return $this->request($path, $params, true);
    }

    /**
     * Set up the boiler plat for the param array for any 
     * static data call.
     *
     * @param mixed $id
     * @param mixed $data
     * @param string $listData
     * @param string $itemData
     * @return array
     */
    protected function setUpParams($id = null, $data = null, $listData = '', $itemData = '') {
        $params = [];
        if (!is_null($this->locale)) {
            $params['locale'] = $this->locale;
        }
        if (!is_null($this->DDversion)) {
            $params['version'] = $this->DDversion;
        }
        if (!$this->appendId($id) and
                $itemData == '' and
                $listData != '') {
            // add the dataById argument
            $params['dataById'] = 'true';
        }
        if (!is_null($data)) {
            if ($this->appendId($id)) {
                $params[$itemData] = $data;
            } else {
                $params[$listData] = $data;
            }
        }
        return $params;
    }

    /**
     * Check if we should append the id to the end of the 
     * url or not.
     *
     * @param mixed $id
     * @return bool
     */
    protected function appendId($id) {
        return !is_null($id) && $id != 'all';
    }

}
