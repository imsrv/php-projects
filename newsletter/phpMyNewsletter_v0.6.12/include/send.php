<?
include("./config.inc.php");
include("./cls.php");
$news = new newsletter; 

$news->get_config($f_host,$f_db,$f_user,$f_passwd,$f_tableconfig); 
require("$news->langfile");

switch($step) 
{
 case "1" : 
   $logFile = new logFile("sending.log");
 
 
   $limit=30; // nombre de messages envoyés pas boucles.
   if(!isset($debut)) $debut=0;
   
   
   $mysql_result= mysql_db_query($news->db,"SELECT * FROM $news->tablelog ORDER BY id DESC LIMIT 0,1")  OR print mysql_error();
   while($row = mysql_fetch_row($mysql_result))
     {
       $format=$row[2];
       $subject=$row[3];
       $msg=$row[4];
     }
   
   
   $mysql_result = mysql_db_query($news->db,"SELECT * FROM $news->tablenews limit $debut,$limit") OR print mysql_error();
   while($row = mysql_fetch_row($mysql_result))
     {
       if($news->send_email($row[0], stripslashes($subject) , stripslashes($msg),  $format))
	 $logFile->write("[".$row[0]."]\t\t\t OK\n<BR>");
       else 
	 $logFile->write("[".$row[0]."]\t\t\t ERROR\n<BR>");
     }
      
   $deb=$debut+$limit;
   if ($deb<=$nrows) header("location:send.php?debut=".$deb."&step=1&nrows=".$nrows."");
   else 
     header("location:../admin.php?mode=envoi&msg=go");
        
   break;
   
   
   
 default : 
   $sujet=addslashes($sujet);
   $message=addslashes(urldecode($message));
   
   $date=date("Ymd His");
   $mysql_result = mysql_db_query( $news->db ,"insert into $news->tablelog (date,type,sujet,message) VALUES ('$date','$format','$sujet','$message')") OR print MYSQL_ERROR();
   
   
   $mysql_link =  @MYSQL_CONNECT($news->host,$news->user,$news->passwd) OR DIE("Impossible de trouver le serveur");
   @mysql_select_db($news->db ,$mysql_link ) or die("Impossible de trouver la base");
   $mysql_result = mysql_db_query($news->db ,"SELECT * FROM $news->tablenews") OR print mysql_error();
   $nrows=mysql_num_rows($mysql_result);

   if(is_writable("./") && file_exists("sending.log"))
     unlink("sending.log");
   header("location:send.php?step=1&debut=0&nrows=$nrows");
   
   
   break;
}



?>
