<?php

use LeagueWrap\Region;

class RegionTest extends PHPUnit_Framework_TestCase {

    public function testGetDomain() {
        $region = new Region(Region::EUW);
        
        $this->assertEquals('https://euw.api.pvp.net/api/lol/', $region->getDomain());
    }

    public function testGetDomainStaticData() {
        $region = new Region(Region::NA);

        $this->assertEquals('https://global.api.pvp.net/api/lol/static-data/', $region->getDomain(true));
    }

    public function testRegionConvertsToString() {
        $region = new Region(Region::EUNE);

        $this->assertEquals('eune', (string) $region);
    }

}
