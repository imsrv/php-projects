<?
switch ($som){
  case "semsom":
     $pieces = explode("|",$linha[4]);
     $msg.="<p>$pieces[0]</p>";
     break;
  case "msom":
     $pieces = explode("|",$linha[4]);
     if($pieces[1] != "nada"){
        $msg.="<p>$pieces[0]<bgsound src=sound/$pieces[1].wav loop=1></p>";
     }else{
        $msg.="<p>$pieces[0]</p>";
     }
     break;
  case "nsom":
      $pieces = explode("|",$linha[4]);
      if($pieces[1] != "nada"){
         $msg.="<p>$pieces[0]<embed src=sound/$pieces[1].wav loop=1 autostart=true></p>";
      }else{
         $msg.="<p>$pieces[0]</p>";
      }
      break;
}
?>