<?php
   include "config.php";
   include "db_file.php";
   DB_connect();
   if ((!isset($_GET['user']))||(!isset($_GET['tempstore']))) {
      print $connection_error;
      exit;
   }
   $query="SELECT * FROM LFchat_room WHERE user='".$_GET['user']."' AND d8_init=".$_GET['tempstore'];
   $result=mysql_query($query) or die(mysql_error());
   if (mysql_num_rows($result)==0) {
      print $connection_error;
      exit;
   }
?>

<html><head>
<title>Chat by Liquid Frog - Get your free copy of this script at www.liquidfrog.com</title>

<script type="text/javascript">
var ID=<?php print('"'.$_GET['user'].'"'); ?>;
var user=<?php print('"'.$_GET['user'].'"'); ?>;

var dt_connect=<?php print(date("YmdHis")); ?>;
var lastd8_in=1; var dt_last_connect=1; var last_chatd8=1;
var refresh_val=<?php print($refresh_period*1000); ?>; var delai_connect=""; var delai_chat="";
var top_wait=1;

var load_main=0; var load_process=0; var load_main=0
var get_fr=0; var top_wait=0;
var msg=""; var color="";

function process() {
   if (get_fr==0) {
      DetectLoad();
   }
   if (get_fr==1) {
      connecttoprocess();
      load=9;
      setTimeout("process()",refresh_val);
   }
   if (get_fr==9) {
      connecttoprocess();
      setTimeout("process()",refresh_val);
   }
}

function connecttoprocess() {
   if (msg=="") {
      top_wait=1;
      frames["menu"].frames["process"].location="process.php?lastd8_in="+lastd8_in+"&user="+ID+"&last_chatd8="+last_chatd8;
   }
}

function processload() {
   top_wait=0;
   msg="";
}

function DetectLoad() {
   if ((load_main==1)&&(load_process==1)&&(load_main==1)) {
      get_fr=1;
   }
   setTimeout("process()",250);
}

function SendMsg(f) {
   if (msg=="") {
      msg=f.msg.value;
      if (msg!="") {
         msg=msg.replace("+","plus");
         color=f.color.options[f.color.selectedIndex].value;
         f.msg.value="";
         msg="&msg="+msg+"&color="+color;
         frames["menu"].frames["process"].location="process.php?lastd8_in="+lastd8_in+"&user="+ID+"&last_chatd8="+last_chatd8+msg;
      }
   } else {
   }
}


function PrintMsg(themsg) {
   top.frames['main'].document.getElementById('layermsg').innerHTML=themsg;
   var height=top.frames['main'].document.getElementById('layermsg').clientHeight;
   if (height><?=($GLOBALS['use_banners']?"430":"510")?>) {
      top.frames['main'].document.getElementById('layermsg').style.top=<?=($GLOBALS['use_banners']?"430":"510")?>-height;
   } else {
      top.frames['main'].document.getElementById('layermsg').style.top=0;
   }
}


function AddUser(user) {
   val=parent.frames['main'].document.forms["post"].elements["msg"];
   val.value=user+" > "+val.value;
   val.focus();
}
function leave( make_sure ) {
      if( !make_sure || confirm( "<?php print(str_replace("(user)", $_GET['user'], $sure_to_quit)); ?>" ) )
      {
         top.location="quit.php?user="+ID;
      }
}
function Popup() {
// top.focus();
// top.frames["main"].post.msg.focus();
}



process();


</script>
</head>

<frameset cols="510,*"  border=0 frameborder=0 onunload="leave( false )"> <!-- Changes the width of the left hand chat frame  -->
   <frame name="main" src="main.php" marginwidth=0 marginheight=0 noresize frameborder=0 scrolling='no' border=0>
   <frame name="menu" src="menu.php?user=<?php print $_GET['user']; ?>" marginwidth=0 marginheight=0 noresize frameborder=0 scrolling='no' border=0>
</frameset>
</html>