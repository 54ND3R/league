<?php
if(isset($_POST["test"])){
  header('Content-Type: application/json');
  ob_start();
}

if( !session_id() )
    session_start();
?>
//I have all the matches , I do not need all the details instantly we can load them one by one
var matches = <?php echo($_SESSION["matches"]) ?>;
$.each(matches,function(index, match){
  setTimeout(loadMatch, index * 1000, match);//IE9 incompatibility
});

function loadMatch(match){
  $.ajax({
    type: "POST",
    url: "<?php echo $_SERVER['PHP_SELF'];?>",
    data: {test : match},
    dataType:"json",
    success: matchLoaded,
  });
}
function matchLoaded(data){
  console.log("Ive had succes!");
  console.log(data);
}
<?php
if(isset($_POST["test"])){
  ob_end_clean();
  echo json_encode($_POST["test"]);
}
?>
