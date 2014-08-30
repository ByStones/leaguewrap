<?php

namespace LeagueWrap;

use LeagueWrap\Api\AbstractApi;
use LeagueWrap\ProviderInterface;
use LeagueWrap\LimitInterface;
use LeagueWrap\Limit\Limit;
use LeagueWrap\Limit\Collection;
use LeagueWrap\Exception\NoKeyException;
use LeagueWrap\Exception\ApiClassNotFoundException;
use LeagueWrap\Exception\ApiMethodNotFoundException;

/**
 * @method \LeagueWrap\Api\Champion champion()
 * @method \LeagueWrap\Api\Game game()
 * @method \LeagueWrap\Api\League league()
 * @method \LeagueWrap\Api\Staticdata staticData()
 * @method \LeagueWrap\Api\Stats stats()
 * @method \LeagueWrap\Api\Summoner summoner()
 * @method \LeagueWrap\Api\Team team()
 */
class Api {

    /**
     * The region to be used. Defaults to 'na'.
     *
     * @var string
     */
    protected $region = Region::NA;

    /**
     * The provider used to connect with the riot API.
     *
     * @var object
     */
    protected $provider;

    /**
     * The collection of limits to be used for all requests in this api.
     *
     * @var Collection
     */
    protected $limits = null;

    /**
     * Whould we attach static data to all requests done on the api?
     *
     * @var bool
     */
    protected $attachStaticData = false;

    /**
     * This is the api key, very important.
     *
     * @var string
     */
    private $key;

    /**
     * Previously created API methods will be stored here, so they do not need
     * to be created twice.
     *
     * @var array
     */
    protected $apiMethodCache = [];

    /**
     * Initiat the default provider and key.
     *
     * @param string $key
     * @throws NoKeyException
     */
    public function __construct($key = null, ProviderInterface $provider = null) {
        if (is_null($key)) {
            throw new NoKeyException('No API key was given');
        }

        //If no provider is given setup a Guzzle provider
        if ($provider === null) {
            $provider = new Provider\GuzzleProvider(new \GuzzleHttp\Client());
        }

        $this->provider = $provider;

        // add the key
        $this->key = $key;

        // set up the limit collection
        $this->collection = new Collection();
    }

    public function __get($property) {
        $className = 'LeagueWrap\Method\\' . ucfirst(strtolower($property)). 'Method';

        if (!class_exists($className) || !is_subclass_of($className, 'LeagueWrap\Method\AbstractMethod')) {
            throw new ApiMethodNotFoundException('The api method "' . $property . '" does not exist or is not valid');
        }

        if (array_key_exists($className, $this->apiMethodCache)) {
            return $this->apiMethodCache[$className];
        }

        $api = new $className($this->provider, $this->collection, $this);
        $api->setKey($this->key)->setRegion($this->region)->attachStaticData($this->attachStaticData);

        $this->apiMethodCache[$className] = $api;

        return $api;
    }

    /**
     * This is the primary service locater if you utilize the api (which you should) to 
     * load instance of the abstractApi. This is the method that is called when you attempt
     * to invoke "Champion()", "League()", etc.
     *
     * @param string $method
     * @param array $arguments
     * @return AbstractApi
     * @throws ApiClassNotFoundException
     */
    public function __call($method, $arguments) {
        $className = 'LeagueWrap\\Api\\' . ucwords(strtolower($method));
        if (!class_exists($className)) {
            // This class does not exist
            throw new ApiClassNotFoundException('The api class "' . $className . '" was not found.');
        }
        $api = new $className($this->provider, $this->collection, $this);
        if (!$api instanceof AbstractApi) {
            // This is not an api class.
            throw new ApiClassNotFoundException('The api class "' . $className . '" was not found.');
        }

        $api->setKey($this->key)
                ->setRegion($this->region)
                ->attachStaticData($this->attachStaticData);

        return $api;
    }

    /**
     * Set the region code to a valid string.
     *
     * @param string $region
     * @chainable
     */
    public function setRegion($region) {
        $this->region = $region;

        return $this;
    }

    /**
     * Sets a limit to be added to the collection.
     *
     * @param int $hits
     * @param int $seconds
     * @param Limit $limit
     * @chainable
     */
    public function limit($hits, $seconds, LimitInterface $limit = null) {
        if ($limit === null) {
            // use the built in limit interface
            $limit = new Limit();
        }

        $limit->setRate($hits, $seconds);

        $this->collection->addLimit($limit);

        return $this;
    }

    /**
     * @return array of Limit
     */
    public function getLimits() {
        return $this->collection->getLimits();
    }

    /**
     * Set wether or not to attach static data to all requests done on this
     * api.
     *
     * @param bool $attach
     * @chainable
     */
    public function attachStaticData($attach = true) {
        $this->attachStaticData = $attach;

        return $this;
    }

}
