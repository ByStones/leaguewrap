<?php

use LeagueWrap\Api;

class ApiChampionTest extends PHPUnit_Framework_TestCase {

	protected $api;

	public function setUp()
	{
		$key = trim(file_get_contents('tests/key.txt'));
		$this->api = new Api($key);
	}

	public function testAll()
	{
		$champion = $this->api->champion();
		$champion->all();
		$this->assertEquals(103, $champion->ahri->id);
	}

	public function testFree()
	{
		$free = $this->api->champion()->free();
		$this->assertEquals(10, count($free));
	}
}

