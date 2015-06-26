<?php
namespace Repos;

class Apicaller{
  static $available=true;

  static public function get_data_from_api($url){
      if(!self::available){
        usleep(1000);
        get_data_from_api($url);
      }else{
        $json_data = file_get_contents($url);
        return json_decode($json_data, true);
      }
  }
}
?>
