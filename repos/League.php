<?php
namespace Repos;

class League extends Generic{
  public function get_league_by_id($summoner_id) {
    $url = "https://".self::API_REGION.".api.pvp.net/api/lol/euw/v2.5/league/by-summoner/".$summoner_id."/entry?api_key=".self::APIKEY;
    return Apicaller::get_data_from_api($url);
  }
}

?>
