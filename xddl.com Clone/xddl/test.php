<?php 
   function post_it($datastream, $url) { 
echo($url);  
$url = preg_replace("@^http://@i", "", $url); 
  $host = substr($url, 0, strpos($url, "/")); 
  $uri = strstr($url, "/"); 
  $reqbody = ""; 
      foreach($datastream as $key=>$val) { 
      $reqbody.= "&"; 
      $reqbody.= $key."=".urlencode($val); 
      } 
  $contentlength = strlen($reqbody); 
     $reqheader =  "POST $uri HTTP/1.1\r\n". 
                   "Host: $host\n". "User-Agent: PostIt\r\n". 
     "Content-Type: application/x-www-form-urlencoded\r\n". 
     "Content-Length: $contentlength\r\n\r\n". 
     "$reqbody\r\n"; 
  $socket = fsockopen($host, 80, $errno, $errstr); 

  if (!$socket) { 
   $result["errno"] = $errno; 
   $result["errstr"] = $errstr; 
   return $result; 
} 

fputs($socket, $reqheader); 

while (!feof($socket)) { 
   $result[] = fgets($socket, 4096); 
} 

fclose($socket); 

return $result; 

} 

  $data["title[]1"] =$title1; 
  $data["url[]1"] = $url1;
  
  $data["title[]2"] =$title2; 
  $data["url[]2"] = $url2;
  
  $data["title[]3"] =$title3; 
  $data["url[]3"] = $url3;
  
  $data["title[]4"] =$title4; 
  $data["url[]4"] = $url4;
  
  $data["title[]5"] =$title5; 
  $data["url[]5"] = $url5;
  
  $data["title[]6"] =$title6; 
  $data["url[]6"] = $url6;
  
  $data["title[]7"] =$title7; 
  $data["url[]7"] = $url7;
  
  $data["title[]8"] =$title8; 
  $data["url[]8"] = $url8;

   
  $data["title[]9"] =$title9; 
  $data["url[]9"] = $url9;
   
  $data["title[]10"] =$title10; 
  $data["url[]10"] = $url10;
  
  $data["surl"] = $_GET["surl"];
  $data["email"] = $_GET["email"];
  $data["sname"] = $_GET["sname"];
  


$result = post_it($data, "http://www.ddlgalaxy.com/submit.php");
$result = post_it($data, "http://www.vipddl.com/submit.php");
$result = post_it($data, "http://www.gigaddls.com/submit.php");
$result = post_it($data, "http://www.ddlworld.com/submit.php");
$result = post_it($data, "http://www.gotwarez.net/submit.php");
$result = post_it($data, "http://www.ddlspot.com/submit.php");
$result = post_it($data, "http://www.antoddl.com/submit.php");
$result = post_it($data, "http://www.ddloutpost.com/submit.php");
$result = post_it($data, "http://www.directdl.com/submit.php");
$result = post_it($data, "http://www.warezfreaks.com/submit.php");
$result = post_it($data, "http://www.ddl2.com/submit.php");
$result = post_it($data, "http://www.atomicddl.com/submit.php");
$result = post_it($data, "http://www.phazeddl.com/submit.php");
$result = post_it($data, "http://www.katz.ws/submit.php");

$result = post_it($data, "http://www.ddl.best-appz.com/submit.php");
$result = post_it($data, "http://66.90.118.83/~ip/submit.php");
$result = post_it($data, "http://www.novoting.com/submit.php");
$result = post_it($data, "http://www.gotwarez.net/submit.php");
$result = post_it($data, "http://www.warezdownloads.info/addddl.php");
$result = post_it($data, "http://www.asmodeusoft.com/submit.php");
$result = post_it($data, "http://www.directwarez.com/submit.php");
$result = post_it($data, "http://www.matrix-downloads.net/submit.php");
$result = post_it($data, "http://www.morewarez.com/submit.php");
$result = post_it($data, "http://www.warezpost.org/submit.php");
$result = post_it($data, "http://www.ddlporn.com/submit.php");


$result = post_it($data, "http://www.ddlnetwork.net/submit.php");
$result = post_it($data, "http://www.ddldirect.com/submit.php");
$result = post_it($data, "http://www.2warez.de/submit.php");
$result = post_it($data, "http://66.90.118.83/~area51/fullddl/submit.php");
$result = post_it($data, "http://ddl.220volt.info/submit.php");
$result = post_it($data, "http://www.ultimateddl.com/submit.php");
$result = post_it($data, "http://www.gotwarez.com/submit.php");
$result = post_it($data, "http://www.qualityddl.com/submit.php");
$result = post_it($data, "http://www.ddlcenter.com/submit.php");


$result = post_it($data, "http://www.asmodeusoft.com/submit.php");
$result = post_it($data, "http://www.gigaddls.com/submit.php");
$result = post_it($data, "http://satanwarez.com/submit.php");
$result = post_it($data, "http://warezlist.online.fr/submit.php");


$result = post_it($data, "http://amddl.kicks-ass.org/submit.php");
$result = post_it($data, "http://www.ddlz.info/submit.php");


$result = post_it($data, "http://www.submissionz.com/ddl/submit.php");
$result = post_it($data, "http://www.katzwarez.com/ddl/submit.php");
$result = post_it($data, "http://www.datowarez.info/ddl/submit.php");
$result = post_it($data, "http://www.mywarez.net/my_files/ddl/submit.php");
$result = post_it($data, "http://www.easywarez.biz/submit.php"); 
$result = post_it($data, "http://warezbs.com/submit.php"); 

$result = post_it($data, "http://katz.ws/submit.php");
$result = post_it($data, "http://www.ddldestination.com/submit.php");
$result = post_it($data, "http://www.sexywarez.net/submit.php");
$result = post_it($data, "http://216.180.247.111/ny/submit.php");
$result = post_it($data, "http://www.muchwarez.com/ddl/submit.php");
$result = post_it($data, "http://www.warezterminal.com/submit.php");
$result = post_it($data, "http://www.robowarez.com/submit.php");
$result = post_it($data, "http://ddl.phrozex.com/submit.php");
$result = post_it($data, "http://www.gwarez.net/submit.php");
$result = post_it($data, "http://networkpost.net/submit.php");
$result = post_it($data, "http://www.silverddl.com/submit.php");
$result = post_it($data, "http://www.grizzlyddl.com/submit.php");


$result = post_it($data, "http://www.xtremedl.com/submit.php");
$result = post_it($data, "http://www.ddls.ws/submit.php");
$result = post_it($data, "http://www.warezddl.mtvgr.com/ddlcenter/submit.php");
$result = post_it($data, "http://www.directdl.com/submit.php");
$result = post_it($data, "http://www.warezddl.org/submit.php");
$result = post_it($data, "http://www.limneos.net/submit.php");


$result = post_it($data, "http://www.warezcollector.com/submit.php");
$result = post_it($data, "http://66.90.118.83/~master/submit.php");
$result = post_it($data, "http://www.rus-ddl.com/submit.php");
$result = post_it($data, "http://www.ddlplanet.com/submit.php");
$result = post_it($data, "http://www.ultimateddl.com/submit.php");

exit;
 

  if (isset($result["errno"])) { 
    $errno = $result["errno"]; 
    $errstr = $result["errstr"]; 
    echo "<B>Error $errno</B> $errstr"; 
    exit; 
  } else { 

    for($i=0;$i< count($result); $i++) echo $result[$i]; 

  } 

?>   










