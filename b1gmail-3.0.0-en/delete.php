<? header("Cache-Control: no-cache"); 

 session_start();
 include ("config.inc.php");

$nmail = 0;


$usermail = strtolower($user."@".$sdomain);



 $filename = "templates/${template}/delete.htm";
 $fd = fopen ($filename, "r");
  $tmpl = fread ($fd, filesize ($filename));
 fclose ($fd); 


  $output = str_replace ( "%ID%", "$id", $tmpl);
  $output = str_replace ( "%COPYRIGHT%", "$copyright", $output);

  $output = stripslashes ($output);
 
  echo ($output);
?>
