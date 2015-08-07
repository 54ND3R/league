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



require "autoload.php";
$service = new Service();

class Service {
  public function __construct(){
    $this->rep_league=new Repos\League();
    $this->rep_summoner=new Repos\Summoner();
    $this->rep_match_history=new Repos\Matchhistory();
    $this->rep_match=new Repos\Match();
    $this->rep_data=new Repos\Data();
    $this->init();

  }
  private function init(){
    if(isset($_POST["load_match"])) {
      $this->rep_data=new Repos\Data();
      $this->champions=$this->rep_data->get_champions()["data"];

      $match_details = $this->get_match_details($_POST["load_match"]["matchId"]);
      echo json_encode($match_details);
    }else{
      $this->load();
      $this->register_shortcodes();
    }
  }
  private function load(){
    if( !session_id() )
        session_start();
    $this->champions=$this->rep_data->get_champions()["data"];
  }
  private function register_shortcodes(){
    add_shortcode( "latest_games" , array( $this , "display_latest_games" ) );
  }

  private $champions;
  private $rep_summoner;
  private $rep_league;
  private $rep_match_history;
  private $rep_match;
  private $rep_data;

  function get_static_data(){
    //$champions = get_champions();
  }
  //Shortcode
  function display_latest_games($atts) {
    echo "<div id='display_latest_games'></div>";
    $name = "Dunks R Us";
    $matches = $this->get_lastest_matches($name);
    $_SESSION['matches'] = json_encode($matches["matches"]);
    $_SESSION['plugin_url']=plugins_url(plugin_basename(__DIR__));
    //display
    $plugin_url =  plugins_url(plugin_basename(__DIR__));
    wp_enqueue_style( 'latest_games', $plugin_url.'/Stylesheets/latest_games.css' );
    wp_enqueue_script( 'latest_games', $plugin_url. '/Scripts/latest_games.js.php');
  }
  //Summoner Repository

  //League Repository
  public function get_league_by_name($name) {
    $summoner = $this->rep_summoner->get_summoner_by_name($name)[str_simple($name)];
    $league = $this->rep_league->get_league_by_id($summoner["id"]);
    return $league[$summoner["id"]][0];
  }

  //Matchhistory Repository
  public function get_lastest_matches($name) {
    $summoner = $this->rep_summoner->get_summoner_by_name($name)[str_simple($name)];
    $match_history = $this->rep_match_history->get_match_history($summoner["id"]);
    return $match_history;
  }

  //Match Repository
  public function get_match_details($match_id) {
    $match = $this->rep_match->get_match($match_id);
    foreach($match->participants as $participant){
      $participant->championId=$this->champions[$participant->championId];

    }
    return $match;
  }
  //Staticdata Repository
  function get_champions() {
    $url = "https://global.api.pvp.net/api/lol/static-data/euw/v1.2/champion?dataById=true&champData=all&api_key=".$APIKEY;
    $champions = json_decode(file_get_contents($url));
  }

}
//Ajax
function receive_post(){
  if(isset($_POST["load_match"])){
    include "/Ajax/latest_games.php";
  }
}

//Misc
function str_simple($string){
  $string = preg_replace('/\s*/', '', $string);
  return strtolower($string);
}
