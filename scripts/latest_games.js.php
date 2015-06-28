<?php
if( !session_id() )
    session_start();
?>
console.log(<?php echo($_SESSION["matches"]) ?>);
