<?php
/*
RIOT API limits calls to :
1 / sec
10 request(s) every 10 second(s)
500 request(s) every 10 minute(s)
If you go over your rate you get a 429 webresponse.
*/
namespace Repos;

class Apicaller{

  static public function get_data_from_api($url){
        $json_data = file_get_contents($url);
        return json_decode($json_data, true);
  }
}
?>
