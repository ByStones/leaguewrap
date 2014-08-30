<?php

namespace LeagueWrap;

class Region {

    const BR = 'br';
    const EUNE = 'eune';
    const EUW = 'euw';
    const KR = 'kr';
    const LAN = 'lan';
    const LAS = 'las';
    const NA = 'na';
    const OCE = 'oce';
    const RU = 'ru';
    const TR = 'tr';
    const PBE = 'pbe';

    /**
     * The region that this object represents.
     *
     * @param string
     */
    protected $region;

    /**
     * The default domain to attempt to query
     */
    protected $defaultDomain = 'https://%s.api.pvp.net/api/lol/';

    /**
     * The default domain for static queries
     */
    protected $defaultStaticDomain = 'https://global.api.pvp.net/api/lol/static-data/';

    public function __construct($region) {
        $this->region = strtolower($region);
    }

    /**
     * Returns the region that was passed in the constructor.
     *
     * @return string
     */
    public function getRegion() {
        return $this->region;
    }

    /**
     * Returns the domain that this region needs to make its request.
     *
     * @param bool $static
     * @return string
     */
    public function getDomain($static = false) {
        if ($static === true) {
            return $this->getStaticDataDomain();
        }

        return sprintf($this->defaultDomain, $this->getRegion());
    }

    /**
     * Returns the static data domain that this region needs to make its request.
     *
     * @return string
     */
    public function getStaticDataDomain() {
        return $this->defaultStaticDomain;
    }

    public function __toString() {
        return (string) $this->region;
    }

}
