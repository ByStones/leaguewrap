<?php

namespace LeagueWrap\Method;

use LeagueWrap\Region;

class MatchMethod extends AbstractMethod {

    /**
     * Valid version for this api call.
     *
     * @var array
     */
    protected $versions = [
        'v2.2',
    ];

    public function findById($id, $includeTimeline = false) {
        $params = [];
        if ($includeTimeline) {
            $params = [
                'includeTimeline' => 'true',
            ];
        }
        $response = $this->request('match/' . $id, $params);

        return new \LeagueWrap\Dto\Match($response);
    }

}
