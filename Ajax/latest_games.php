<?php
if(isset($_POST["load_match"])){
  header('Content-Type: application/json');
  echo json_encode($service->get_match_details($_POST["load_match"]["matchId"]));
}
?>
