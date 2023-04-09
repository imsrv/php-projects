<?php
   $DB_SERVER="xxxxxxx";                      // Database Server machine
   $DB_LOGIN="xxxxxxx";                     // Database login
   $DB_PASSWORD="xxxxxx";                  // Database password
   $DB="xxxxx";                         // Database containing the tables
   $HTTP_HOST="http://xxxxx";      // HTTP Host
   $DOCROOT="banner";             // Path, where application is installed
               
$connection = mysql_connect($DB_SERVER, $DB_LOGIN, $DB_PASSWORD)
          or die ("Couldn't connect to server.");

$db = mysql_select_db($DB, $connection)
        or die ("Couldn't select database.");


 if(!isset($bannerID)){
       $query =  "select bannerID, banner, src, alt, width, height from banners WHERE local_banner='1' AND active='true'ORDER by RAND()";
       $res = mysql_query($query,$connection)
          or die ("Couldn't select records!1");
             $ban = mysql_fetch_array($res);
            $bannerID=$ban[bannerID];
            } else {

           $query =  "select bannerID, url from banners WHERE bannerID='".$bannerID."'";
       $res = mysql_query($query,$connection)
          or die ("Couldn't select records!2");
           $stat = mysql_fetch_array($res);
            }

            $date=
          $query =  "INSERT into banner_stat SET ";
            if(isset($click_banner))
              $query=$query." clicks='1' ";
            else
              $query=$query." views='1' ";

              $query=$query.",  bannerID='".$bannerID."' ,";
              $query=$query." date='".date("Y-m-d")."', id=''";
       $insert = mysql_query($query,$connection)
          or die ("Couldn't insert records!3");

if(isset($click_banner)){
   header("Location:$stat[url]");
   exit();
}

 echo "<A HREF=$HTTP_HOST/$DOCROOT/FrontPageBanner.php?bannerID=".$bannerID."&click_banner=True TARGET=\"_TOP\"><img src=\"$ban[src]\" width=\"$ban[width]\" height=\"$ban[height]\" alt=\"$ban[alt]\" border=0></A>" ;