<?php

namespace LeagueWrap\Method;

use LeagueWrap\Dto\Summoner;
use LeagueWrap\Api;
use LeagueWrap\Region;
use LeagueWrap\ProviderInterface;
use LeagueWrap\Limit\Collection;
use LeagueWrap\Exception\RegionException;
use LeagueWrap\Exception\LimitReachedException;
use LeagueWrap\Exception\InvalidIdentityException;

abstract class AbstractMethod {

    protected $provider;

    /**
     * The collection of limits to be used on this api.
     *
     * @var Collection
     */
    protected $collection;

    /**
     * The key to be used by the api.
     *
     * @param string
     */
    protected $key;

    /**
     * The region to be used by the api.
     *
     * @param Region
     */
    protected $region;

    /**
     * Provides access to the api object to perform requests on
     * different api endpoints.
     */
    protected $api;

    /**
     * A list of all permitted regions for this API call. Leave
     * it empty to not lock out any region string.
     *
     * @param array
     */
    protected $permittedRegions = [
        Region::BR,
        Region::EUNE,
        Region::EUW,
        Region::LAN,
        Region::LAS,
        Region::NA,
        Region::OCE,
        Region::RU,
        Region::TR,
        Region::KR,
    ];

    /**
     * The version we want to use. If null use the first
     * version in the array.
     *
     * @param string|null
     */
    protected $version = null;

    /**
     * A count of the amount of API request this object has done
     * so far.
     *
     * @param int
     */
    protected $requests = 0;

    /**
     * Should we attach static data to the requests done by this object?
     *
     * @var bool
     */
    protected $attachStaticData = false;

    /**
     * Default DI constructor.
     *
     * @param ProviderInterface $provider
     * @param Collection $collection
     * @param Api $api
     */
    public function __construct(ProviderInterface $provider, Collection $collection, Api $api) {
        $this->provider = $provider;
        $this->collection = $collection;
        $this->api = $api;
    }

    /**
     * Returns the amount of requests this object has done
     * to the api so far.
     *
     * @return int
     */
    public function getRequestCount() {
        return $this->requests;
    }

    /**
     * Set the key to be used in the api.
     *
     * @param string $key
     * @chainable
     */
    public function setKey($key) {
        $this->key = $key;

        return $this;
    }

    /**
     * Set the region to be used in the api.
     *
     * @param string $region
     * @chainable
     */
    public function setRegion($region) {
        $this->region = new Region($region);

        return $this;
    }

    protected function request($path, $params = [], $static = false) {
        // get version
        $version = reset($this->versions);

        // get and validate the region
        if (!in_array($this->region->getRegion(), $this->permittedRegions)) {
            throw new RegionException('The region "' . $this->region->getRegion() . '" is not permited to query this API.');
        }

        // add the key to the param list
        $params['api_key'] = $this->key;

        $uri = $this->region->getDomain($static) . $this->region->getRegion() . '/' . $version . '/' . $path;

        // check if we have hit the limit
        if (!$static AND ! $this->collection->hitLimits()) {
            throw new LimitReachedException('You have hit the request limit in your collection.');
        }
        $content = $this->provider->request($uri, $params);

        // request was succesful
        ++$this->requests;

        // decode the content
        return json_decode($content, true);
    }

}
