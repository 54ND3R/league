<?php
/*
Plugin Name: League
Plugin URI: none
Description: League of Legends service for getting data by API.
Version: 0.0.1
Author: Sander De Bleecker
Author URI: none
License: GPL by default. Wordpress users may only edit direct wordpress code and solid deriatives...
Text Domain: League
*/

$league = new League();

class League {
  public function __construct(){
    $this->register_shortcodes();
  }

  const apikey = "e302425c-5283-4c4d-b798-1a9c606ce775";
  const api_region = "euw";
  private $champions;
  //Header

  //add_action( 'init', 'get_static_data');
  function register_shortcodes(){

  }
  function get_static_data(){
    //$champions = get_champions();
  }

  //Summoner Repository
  private function get_summoner_by_name($name) {
    $url = "https://".self::api_region.".api.pvp.net/api/lol/euw/v1.4/summoner/by-name/".str_replace(' ', '%20', $name)."?api_key=".self::apikey;
    $json_data = file_get_contents($url);
    return json_decode($json_data, true);
  }
  //League Repository
  public function get_league_by_name($name) {
    $summoner = $this->get_summoner_by_name($name)[str_simple($name)];
    $league = $this->get_league_by_id($summoner["id"]);
    return $league[$summoner["id"]][0];
  }
  private function get_league_by_id($summoner_id) {
    $url = "https://".self::api_region.".api.pvp.net/api/lol/euw/v2.5/league/by-summoner/".$summoner_id."/entry?api_key=".self::apikey;
    $json_data = file_get_contents($url);
    return json_decode($json_data, true);
  }
  //Matchhistory Repository
  public function get_lastest_matches($name) {
    $summoner = $this->get_summoner_by_name($name)[str_simple($name)];
    $match_history = $this->get_match_history($summoner["id"]);
    $last_matches = $this->get_matches_from_history($match_history);
    return $match_history;
  }
  private function get_match_history($summoner_id) {
    $url = "https://".self::api_region.".api.pvp.net/api/lol/euw/v2.2/matchhistory/".$summoner_id."?rankedQueues=RANKED_SOLO_5x5&api_key=".self::apikey;
    $match_history = json_decode(file_get_contents($url));
    return $match_history;
  }
  //Match Repository
  private function get_matches_from_history($match_history) {
    $matches=[];
    foreach ($match_history as $array_index => $array) {
      foreach($array as $entry){
        $matches[$entry->matchId]=$this->get_match($entry->matchId);
        break;
      }
      //var_dump($entry);
    }
    var_dump($matches);
    return $matches;
  }
  private function get_match($match_id) {
    $url = "https://".self::api_region.".api.pvp.net/api/lol/euw/v2.2/match/".$match_id."?api_key=".self::apikey;
    $match = json_decode(file_get_contents($url));
    return $match;
  }

  //Staticdata Repository
  function get_champions() {
    $url = "https://global.api.pvp.net/api/lol/static-data/euw/v1.2/champion?dataById=true&champData=all&api_key=".$apikey;
    $champions = json_decode(file_get_contents($url));
  }

}
//Misc
function str_simple($string){
  $string = preg_replace('/\s*/', '', $string);
  return strtolower($string);
}
