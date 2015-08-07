
//I have all the matches , I do not need all the details instantly so I load them one by one

$(function(){
  <?php
  if( !session_id() )
      session_start();
  ?>
  retrieve_matches();
});


function retrieve_matches(){
  var matches = <?php echo($_SESSION["matches"]) ?>;
  $.each(matches,function(index, match){
    setTimeout(load_match, index * 1200, match);//IE9 incompatibility
  });
}
function load_match(match){
  $.ajax({
    type: "POST",
  //  url: "<?php echo $_SERVER['PHP_SELF']; ?>",
    url: "<?php echo $_SESSION['plugin_url'].'/Service.php'; ?>",
    data: {load_match : match},
    dataType:"json",
    success: match_loaded,
  });
}
function match_loaded(match){
  console.log(match);
  var container = $('#display_latest_games');
  var league_match =
  '<div id="league_match">'+
    '<div id="league_title">'+get_winner(match["teams"])+' team wins</div>'+
    '<div id="league_teams">';
      $.each(match["participants"],function(index,participant){
        if(index==0){
          league_match+=
          '<div id="league_blue" class="league_team">';
        }
        if(index==5){
          league_match+=
          '<div id="league_red" class="league_team">';
        }
        league_match+=
           '<div id="league_champion">'+
            '<div id="league_portrait">'+
               '<img src="http://ddragon.leagueoflegends.com/cdn/5.2.1/img/champion/Aatrox.png" class="champicon">'+
             '</div>'+
             '<div id="league_summoners">'+
               '<img src="http://ddragon.leagueoflegends.com/cdn/5.2.1/img/spell/SummonerFlash.png" class="champsum">'+
               '<img src="http://ddragon.leagueoflegends.com/cdn/5.2.1/img/spell/SummonerExhaust.png" class="champsum">'+
             '</div>'+
             '<div id="league_stats">'+
               '<div>Dunks R Us - '+participant["champion_name"]+'</div>'+
               '<div>KDA '+participant["stats"]["kills"]+'/'+participant["stats"]["deaths"]+'/'+participant["stats"]["assists"]+' </div>'+
             '</div>'+
             '<div id="league_items">'+
               print_item_icon(participant["stats"]["item0"])+
               print_item_icon(participant["stats"]["item1"])+
               print_item_icon(participant["stats"]["item2"])+
               print_item_icon(participant["stats"]["item3"])+
               print_item_icon(participant["stats"]["item4"])+
               print_item_icon(participant["stats"]["item5"])+
             '</div>'+
           '</div>';
        if(index==4 || index==9){
          league_match+=
          '</div>';
        }
      });
  league_match+=
    '</div>'+
  '</div>';
  container.append(league_match);
}
function print_item_icon(item){
  if(item<1) return '';
  return '<img src="http://ddragon.leagueoflegends.com/cdn/5.2.1/img/item/'+item+'.png" class="item">';
}
function get_winner(teams){
  if(teams[0]["winner"]){
    return "Blue";
  }else{
    return "Red";
  }
}
