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

    public function findChampions(array $data = [], $dataById = false) {
        $params = $this->setUpParams([
            'dataById' => $dataById ? 'true' : 'false',
            'champData' => implode(',', $data),
        ]);

        $array = $this->request('champion', $params, true);
        return new ChampionList($array);
    }

    public function findChampionById($id, array $data = []) {
        $params = $this->setUpParams([
            'champData' => implode(',', $data),
        ]);

        $array = $this->request('champion/' . $id, $params, true);
        return new Champion($array);
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

    public function findItems(array $data = []) {
        $params = $this->setUpParams([
            'itemListData' => implode(',', $data),
        ]);

        $array = $this->request('item', $params, true);
        return new ItemList($array);
    }

    public function findItemById($id, array $data = []) {
        $params = $this->setUpParams([
            'itemData' => implode(',', $data),
        ]);

        $array = $this->request('item/' . $id, $params, true);
        return new Item($array);
    }

    const MASTERY_DATA_ALL = 'all';
    const MASTERY_DATA_IMAGE = 'image';
    const MASTERY_DATA_PREREQ = 'preqreq';
    const MASTERY_DATA_RANKS = 'ranks';
    const MASTERY_DATA_SANITIZED_DESCRIPTION = 'sanitizedDescription';
    const MASTERY_DATA_TREE = 'tree';

    public function findMasteries(array $data = []) {
        $params = $this->setUpParams([
            'masteryListData' => implode(',', $data),
        ]);

        $array = $this->request('mastery', $params, true);
        return new MasteryList($array);
    }

    public function findMasteryById($id, array  $data = []) {
        $params = $this->setUpParams([
            'masteryList' => implode(',', $data),
        ]);

        $array = $this->request('mastery/' . $id, $params, true);
        return new Mastery($array);
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

    public function findRunes(array $data = []) {
        $params = $this->setUpParams([
            'runeListData' => implode(',', $data),
        ]);

        $array = $this->request('rune', $params, true);
        return new RuneList($array);
    }

    public function findRuneById($id, array $data = []) {
        $params = $this->setUpParams([
            'runeData' => implode(',', $data),
        ]);

        $array = $this->request('rune/' . $id, $params, true);
        return new Rune($array);
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

    public function findSummonerSpells(array $data = []) {
        $params = $this->setUpParams([
            'spellListData' => implode(',', $data),
        ]);

        $array = $this->request('spell', $params, true);
        return new SummonerSpellList($array);
    }

    public function findSummonerSpellById($id, array $data = []) {
        $params = $this->setUpParams([
            'spellData' => implode(',', $data),
        ]);

        $array = $this->request('spell/' . $id, $params, true);
        return new SummonerSpell($array);
    }

    /**
     * Get the realm information for the current region.
     *
     * @return Realm
     */
    public function findRealm() {
        $array = $this->request('realm');

        return new Realm($array);
    }

    public function findVersions() {
        $array = $this->request('verions');

        return $array;
    }

    protected function setUpParams(array $params) {
        if ($this->locale !== null) {
            $params['locale'] = $this->locale;
        }

        if ($this->DDversion !== null) {
            $params['version'] = $this->DDversion;
        }

        return $params;
    }

}
