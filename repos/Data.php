<?php
namespace Repos;

class Data extends Generic{
  public function get_champions() {
    $url = "https://global.api.pvp.net/api/lol/static-data/".self::API_REGION."/v1.2/champion?dataById=true&api_key=".self::APIKEY;
    return Apicaller::get_data_from_api($url);
  }
}

?>
