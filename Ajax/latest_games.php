<?php
if(isset($_POST["load_match"])){
  header('Content-Type: application/json');
  $match=$service->get_match_details($_POST["load_match"]["matchId"]);
  $match["mapId"]=10;
  foreach($match["participants"] as &$participant){
    $participant["champion_name"]=$service->champions[$participant["championId"]["name"]];
  }
  echo json_encode($match);
  unset($participant);
}
?>
