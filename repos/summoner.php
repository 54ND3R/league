<?php
namespace Repos;

class Summoner extends Generic{
  public function get_summoner_by_name($name) {
    $url = "https://".self::API_REGION.".api.pvp.net/api/lol/euw/v1.4/summoner/by-name/".str_replace(' ', '%20', $name)."?api_key=".self::APIKEY;
    $json_data = file_get_contents($url);
    return json_decode($json_data, true);
  }
}
?>
