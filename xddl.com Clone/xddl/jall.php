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

  $data["le[user]"] = $_GET["user"];
  $data["le[pass]"] = $_GET["pass"];
  $data["le[email]"] = $_GET["email"];
  $data["le[name]"] = $_GET["name"];
  $data["le[url]"] = $_GET["url"];
  


$result = post_it($data, "http://www.ddlgalaxy.com/join.php");
//$result = post_it($data, "http://www.vipddl.com/join.php");
//$result = post_it($data, "http://www.gigaddls.com/join.php");
$result = post_it($data, "http://www.ddlworld.com/join.php");
$result = post_it($data, "http://www.gotwarez.net/join.php");
$result = post_it($data, "http://www.ddlspot.com/join.php");
$result = post_it($data, "http://www.antoddl.com/join.php");
$result = post_it($data, "http://www.ddloutpost.com/join.php");
//$result = post_it($data, "http://www.directdl.com/join.php");
$result = post_it($data, "http://www.warezfreaks.com/join.php");
$result = post_it($data, "http://www.ddl2.com/join.php");
//$result = post_it($data, "http://www.atomicddl.com/join.php");
$result = post_it($data, "http://www.phazeddl.com/join.php");
$result = post_it($data, "http://www.katz.ws/join.php");


$result = post_it($data, "http://www.ddl.best-appz.com/join.php");
//$result = post_it($data, "http://66.90.118.83/~ip/join.php");
$result = post_it($data, "http://www.novoting.com/join.php");
$result = post_it($data, "http://www.gotwarez.net/join.php");
$result = post_it($data, "http://www.warezdownloads.info/addddl.php");
$result = post_it($data, "http://www.asmodeusoft.com/join.php");
$result = post_it($data, "http://www.directwarez.com/join.php");
$result = post_it($data, "http://www.matrix-downloads.net/join.php");
$result = post_it($data, "http://www.morewarez.com/join.php");
$result = post_it($data, "http://www.warezpost.org/join.php");
$result = post_it($data, "http://www.ddlporn.com/join.php");


$result = post_it($data, "http://www.ddlnetwork.net/join.php");
$result = post_it($data, "http://www.ddldirect.com/join.php");
$result = post_it($data, "http://www.2warez.de/join.php");
//$result = post_it($data, "http://66.90.118.83/~area51/fullddl/join.php");
$result = post_it($data, "http://ddl.220volt.info/join.php");
$result = post_it($data, "http://www.ultimateddl.com/join.php");
$result = post_it($data, "http://www.gotwarez.com/join.php");
$result = post_it($data, "http://www.qualityddl.com/join.php");
$result = post_it($data, "http://www.ddlcenter.com/join.php");


$result = post_it($data, "http://www.asmodeusoft.com/join.php");
//$result = post_it($data, "http://www.gigaddls.com/join.php");
$result = post_it($data, "http://satanwarez.com/join.php");
$result = post_it($data, "http://warezlist.online.fr/join.php");


$result = post_it($data, "http://amddl.kicks-ass.org/join.php");
//$result = post_it($data, "http://www.ddlz.info/join.php");


$result = post_it($data, "http://www.submissionz.com/ddl/join.php");
//$result = post_it($data, "http://www.katzwarez.com/ddl/join.php");
$result = post_it($data, "http://www.datowarez.info/ddl/join.php");
$result = post_it($data, "http://www.mywarez.net/my_files/ddl/join.php");
$result = post_it($data, "http://www.easywarez.biz/join.php"); 
$result = post_it($data, "http://warezbs.com/join.php"); 

//$result = post_it($data, "http://katz.ws/join.php");
//$result = post_it($data, "http://www.ddldestination.com/join.php");
//$result = post_it($data, "http://www.sexywarez.net/join.php");
$result = post_it($data, "http://216.180.247.111/ny/join.php");
$result = post_it($data, "http://www.muchwarez.com/ddl/join.php");
//$result = post_it($data, "http://www.warezterminal.com/join.php");
//$result = post_it($data, "http://www.robowarez.com/join.php");
//$result = post_it($data, "http://ddl.phrozex.com/join.php");
//$result = post_it($data, "http://www.gwarez.net/join.php");
//$result = post_it($data, "http://networkpost.net/join.php");
//$result = post_it($data, "http://www.silverddl.com/join.php");
$result = post_it($data, "http://www.grizzlyddl.com/join.php");


//$result = post_it($data, "http://www.xtremedl.com/join.php");
$result = post_it($data, "http://www.ddls.ws/join.php");
$result = post_it($data, "http://www.warezddl.mtvgr.com/ddlcenter/join.php");
//$result = post_it($data, "http://www.directdl.com/join.php");
$result = post_it($data, "http://www.warezddl.org/join.php");
$result = post_it($data, "http://www.limneos.net/join.php");


$result = post_it($data, "http://www.warezcollector.com/join.php");
$result = post_it($data, "http://66.90.118.83/~master/join.php");
$result = post_it($data, "http://www.rus-ddl.com/join.php");
$result = post_it($data, "http://www.ddlplanet.com/join.php");
$result = post_it($data, "http://www.ultimateddl.com/join.php");


  if (isset($result["errno"])) { 
    $errno = $result["errno"]; 
    $errstr = $result["errstr"]; 
    echo "<B>Error $errno</B> $errstr"; 
    exit; 
  } else { 

    for($i=0;$i< count($result); $i++) echo $result[$i]; 

  } 

?>   










