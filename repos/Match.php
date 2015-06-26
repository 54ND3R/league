<?php
namespace Repos;

class Match extends Generic{
  public function get_matches_from_history($match_history) {
    $matches=[];
    foreach ($match_history as $array_index => $array) {
      foreach($array as $entry){
        $matches[$entry->matchId]=$this->get_match($entry["matchId"]);
        break;
      }
    }
    var_dump($matches);
    return $matches;
  }
  public function get_match($match_id) {
    $url = "https://".self::API_REGION.".api.pvp.net/api/lol/euw/v2.2/match/".$match_id."?api_key=".self::APIKEY;
    $match = json_decode(file_get_contents($url));
    return $match;
  }
}
?>
