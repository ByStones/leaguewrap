<?php

namespace LeagueWrap;

interface ProviderInterface {

    public function request($uri, array $params = null);

}
