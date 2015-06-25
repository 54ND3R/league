<?php
namespace Repos;

class Matchhistory extends Generic{
  public function get_match_history($summoner_id) {
    $url = "https://".self::API_REGION.".api.pvp.net/api/lol/euw/v2.2/matchhistory/".$summoner_id."?rankedQueues=RANKED_SOLO_5x5&api_key=".self::APIKEY;
    $match_history = json_decode(file_get_contents($url));
    return $match_history;
  }
}

?>
