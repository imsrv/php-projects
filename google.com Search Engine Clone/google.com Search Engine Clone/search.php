<?

// insert your google key here, if you don't have one http://www.google.com/apis/ (it's free)
$yourGoogleKey = "RYffrqdQFHLkxmjMQv196fMU37pfKKde";

// insert your website url here  
$yourWebsite = "http://www.search.Endless-4um.com/";              


//----------------------------------------------------------------------------------------------
// build search query and connect to google
//----------------------------------------------------------------------------------------------

require_once("nusoap.php");

if($_GET) { extract($_GET, EXTR_PREFIX_SAME, "get_"); }
if($_POST) { extract($_POST, EXTR_PREFIX_SAME, "post_"); }

if ($yourGoogleKey == "insert your Google key here") { 
  echo "You didn't insert a Google Key Yet ! Get one at www.google.com/apis/ ..";
  break;
}

if ($query && $www) {

  $q = urldecode($query);
  if ($www != "true") { $q.= " site:$yourWebsite"; }
  if(!$start) { $start=0; } else { $start = intval($start); }

  $parameters = array( 
    "key"         => $yourGoogleKey,   // google developer key
    "q"           => $q,               // search query
    "start"       => $start,           // result start index
    "maxResults"  => 10,               // 10 is the maximum
    "filter"      => false,            // filtering similar entries
    "restrict"    => "",               // country and topic restrictions
    "safeSearch"  => false,            // adult content filter
    "lr"          => "",               // language restrictions
    "ie"          => "",               // deprecated and ignored parameter
    "oe"          => ""                // deprecated and ignored parameter
  );

  $soapclient = new soapclient("http://api.google.com/search/beta2");
  $result = $soapclient->call("doGoogleSearch", $parameters, "urn:GoogleSearch");
  $begin = $start + 1;
  $end = $start + $parameters["maxResults"];
  $total = $result["estimatedTotalResultsCount"];
}

//----------------------------------------------------------------------------------------------
// html headers, stylesheet and search form
//----------------------------------------------------------------------------------------------

?>

<?php include("header_search.php");?>


<? 

//----------------------------------------------------------------------------------------------
// display results table if a search has been done
//----------------------------------------------------------------------------------------------

if ($query && $www) {

  echo "<table width=\"609\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\">\n";
  echo "<tr class=\"row\"><td width=\"90%\" class=\"row\"></td></tr>\n";
  

  if ($total == 0){
  	echo "<tr><td class=\"alert\">Your search returned no results ..</td></tr>\n";
  }
  
  if ($total > 0) {
    $result = $result["resultElements"]; 
    for ($i = 0; $i < $parameters["maxResults"]; $i++) {
      $element = $result[$i];
      $url = $element["URL"];
      $title = $element["title"];
      $snippet = $element["snippet"];
      if ($url != "") {
	    
		   echo "<tr>\n"; 
		
		echo "<td><span class='list'>".($i+$begin).".</span> <a href='$url' class='link'>$title</a><br><span class='gray_small'>$snippet</span><br><a href='$url' class='link_small'>$url</a></td></tr>\n";
      } 
	}
  }
       

  echo "<tr><td><br>";
  if($begin > 1) { echo "<a href=\"google.php?query=$query&www=$www&start=".($start - 10)."\">previous 10 results</a> | "; } 
  echo "showing $begin to $end of $total results";

  if ($end < $total) { echo " | <a href=\"search.php?query=$query&www=$www&start=".($start + 10)."\">next 10 results</a>"; }
  echo "</td></tr>\n";
  
  echo "</table>";
}

//----------------------------------------------------------------------------------------------
// html credits and footer  ||| PLEASE DO NOT REMOVE COPYRIGHTS, Thanks ||| www.Endless-4um.com
//----------------------------------------------------------------------------------------------

?><?php include("footer_search.php");?>