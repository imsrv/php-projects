<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// This file includes several useful functions..
// -----------------------------------------------------------------------

// You may want to set this, if when attaching a file to the message the connection
// hangs up due to time out.
set_time_limit(0);

function url_redirect($url = "") {
    global $BSX_BASEHREF, $is_ssl, $is_js, $is_alldomains, $SESSID;

    if($url == "") $url = $BSX_BASEHREF;
    if($is_ssl || $GLOBALS["SERVER_PORT"] == 443) {
	if(eregi("\?", $url)) 
		$url .= "&is_ssl=" . ($is_ssl > 0 ? $is_ssl : 1);
	else
		$url .= "?is_ssl=" . ($is_ssl > 0 ? $is_ssl : 1);
	$url = ereg_replace("http://", "https://", $url);
    }
    if($is_js) {
	if(eregi("\?", $url)) 
		$url .= "&is_js=" . $is_js;
	else
		$url .= "?is_js=" . $is_js;
    }
    if($SESSID) {
	if(eregi("\?", $url))
		$url .= "&SESSID=" . $SESSID;
	else
		$url .= "?SESSID=" . $SESSID;
    }
    if($is_alldomains) {
	if(eregi("\?", $url))
		$url .= "&is_alldomains=" . $is_alldomains;
	else
		$url .= "?is_alldomains=" . $is_alldomains;
    }
    Header("Location: " . $url);
    exit();
}

// gets the array index of a domain
function domain2index($domain) {
    global $bsx_domains, $bsx_domains_cnt;
    $domain1 = strtolower($domain);
    for($i = 0 ; $i < $bsx_domains_cnt ; $i++) {
       $domain2 = strtolower($bsx_domains[$i]["domain"]);
       if($domain1 == $domain2) return $i;
    }
    return -1;
}


// gets the domain name of an index
function index2domain($indx) {
    global $bsx_domains;
    $domain = $bsx_domains[$indx]["domain"];
    if($domain == "") return false;
    return $domain;
}


// Turkce karakterler (turkish characters)
// tr  -> us
// 199 -> 67
// 208 -> 71
// 214 -> 79
// 220 -> 85
// 221 -> 73
// 222 -> 83
// 231 -> 99
// 240 -> 103
// 246 -> 111
// 252 -> 117
// 253 -> 105
// 254 -> 115

function make_readable($name) {
   $newname = "";
   for($i = 0 ; $i < strlen($name) ; $i++) {
      $z = ord($name[$i]);
      switch($z) {
       case 199:
	 $newname .= chr(67);
	 break;
       case 208:
	 $newname .= chr(71);
	 break;
       case 214:
	 $newname .= chr(79);
	 break;
       case 220:
	 $newname .= chr(85);
	 break;
       case 221:
	 $newname .= chr(73);
	 break;
       case 222:
	 $newname .= chr(83);
	 break;
       case 231:
	 $newname .= chr(99);
	 break;
       case 240:
	 $newname .= chr(103);
	 break;
       case 246:
	 $newname .= chr(111);
	 break;
       case 252:
	 $newname .= chr(117);
	 break;
       case 253:
	 $newname .= chr(105);
	 break;
       case 254:
	 $newname .= chr(115);
	 break;
       default:
	 $newname .= chr($z);
      }
   }
   // we converted the tr chars to us chars
   
   // now we need to get rid of unreadable chars
   // i.e we allow: A-Z, a-z, 0-9 and blank
   $name2 = $newname;
   $newname = "";
   for($i = 0 ; $i < strlen($name2) ; $i++) {
      $z = ord($name2[$i]);
      if($z == 32) $newname .= " ";
      if(($z < 48) || (($z > 57) && ($z < 65)) ||
	 (($z > 90) && ($z < 97)) || ($z > 122)) continue;
      $newname .= $name2[$i];
   }
   return $newname;
}

// convert the size in bytes to kB/mB
function convert_size($byte) {
   if($byte == 0) // no need to calculate
     return "0kB";
   if($byte < 1000) // i guess users dont want to see the size like 1020 bytes
     return "$byte" . " B";
   $rem = $byte / 1024.0;
   $kb = sprintf("%.1f", $rem);
   $remkb = sprintf("%d", $rem);
   if($remkb < 1000)  // kilobytes is ok
     return "$kb" . "kB";
   $rem2 = $remkb / 1024.0;
   $mb = sprintf("%.1f", $rem2);
   return "$mb" . "mB"; // finally megabytes
}

// simple decrypt of a string
function decode_strip($str) {
   $str2 = stripslashes(urldecode($str));
   return trans_tr($str2);
}

function decode_mime($string) {
   if(eregi("=?([A-Z,0-9,-]+)?([A-Z,0-9,-]+)?([A-Z,0-9,-,=,_]+)?=", $string)) {
      $coded_strings = explode('=?', $string);
      $counter = 1;
      $string = $coded_strings[0];
      while($counter < count($coded_strings)) {
	 $elements = explode('?', $coded_strings[$counter]);
	 if(eregi("Q", $elements[1])) {
	    $elements[2] = str_replace('_', ' ', $elements[2]);
	    $elements[2] = eregi_replace("=([A-F,0-9]{2})", "%\\1", $elements[2]);
	    $string .= urldecode($elements[2]);
	 } else {
	    $elements[2] = str_replace('=', '', $elements[2]);
	    if ($elements[2]) { $string .= base64_decode($elements[2]); 
	    }
	 }
	 if(isset($elements[3]) && $elements[3] != '') {
	    $elements[3] = ereg_replace("^=", '', $elements[3]);
	    $string .= $elements[3];
	 }
	 $string .= " ";
	 $counter++;
      }
   }
   return $string;
}

function handle_emails($str) {
    global $BSX_BASEHREF, $BSX_LAUNCHER;
    global $is_js, $is_ssl, $SESSID;

    $url = $BSX_BASEHREF . "/" . $BSX_LAUNCHER . "?RequestID=CMPSNEW&premail=-1";
    if($SESSID) $url .= "&SESSID=$SESSID";
    if($is_js) $url .= "&is_js=$is_js";
    if($is_ssl || $GLOBALS["SERVER_PORT"] == 443) $url .= "&is_ssl=" . $is_ssl;
    $url .= "&cmps_to";
    return(ereg_replace("([A-Za-z0-9._-]+\@[[:alnum:].[a-zA-Z0-9_-]+[a-zA-Z]+)",
			  "<a href=\"$url=\\1\">\\1</a>", $str));
}

function handle_urls($str) {
    return(eregi_replace("(http|https|ftp)://([[:alnum:]/\n+-=&%:_.~?]+[#[:alnum:]+]*)","<a href=\"\\1://\\2\" target=_new>\\1://\\2</a>",  $str));
}

function put_ahref($href, $name, $linkid = "", $title = "") {

    $url = $GLOBALS["BSX_BASEHREF"] . "/" . $GLOBALS["BSX_LAUNCHER"] . "?" . $href;
    if($GLOBALS["SESSID"]) $url .= "&SESSID=" . $GLOBALS["SESSID"];
    if($GLOBALS["is_js"]) $url .= "&is_js=" . $GLOBALS["is_js"];
    if($GLOBALS["is_ssl"] || $GLOBALS["SERVER_PORT"] == 443) $url .= "&is_ssl=" . $GLOBALS["is_ssl"];
    if($GLOBALS["expand_folders"]) $url .= "&expand_folders=1";

    $output = "<a href=\"$url\"";
    if($linkid != "") $output .= " id=\"$linkid\"";
    if($title != "") $output .= " title=\"" . htmlspecialchars($title) . "\"";

    $output .= ">$name</a>";
    echo $output;
}

function nbsp($str) {
    if(is_string($str)) {
	    if(empty($str)) return "&nbsp;";
	    return "&nbsp;$str&nbsp;";
    }
    return "&nbsp;$str&nbsp;";
}

function start_form($name, $extra = "") {
    global $BSX_BASEHREF, $BSX_LAUNCHER;
    global $is_ssl;
   
    $posturl = $BSX_BASEHREF . "/" . $BSX_LAUNCHER;
    echo "<form name=\"$name\" method=\"POST\" action=\"$posturl\" $extra>\n";
}

function stop_form() {
    global $SESSID, $is_js, $is_ssl, $is_nocookie, $is_alldomains;
    if($SESSID)
       echo "<input type=\"hidden\" name=\"SESSID\" value=\"$SESSID\">";
    if($is_js)
       echo "<input type=\"hidden\" name=\"is_js\" value=\"$is_js\">";
    if($is_ssl | $GLOBALS["SERVER_PORT"] == "443") 
       echo "<input type=\"hidden\" name=\"is_ssl\" value=\"$is_ssl\">";
    if($is_nocookie) 
       echo "<input type=\"hidden\" name=\"is_nocookie\" value=\"$is_nocookie\">";
    if($is_alldomains) 
       echo "<input type=\"hidden\" name=\"is_alldomains\" value=\"$is_alldomains\">";
    echo "</form>\n";
}

// push the pages of the mbox
function push_pages($nmsgs) {
    global $sort, $fromMsg, $fromPage, $lng, $mbox, $nextPage, $prevPage;
    global $pluspsize;
    global $user_set;

    // print the More pages stuff
    // --
    // well, this is not necessary for most of us, but hey, may be we use this feature? 
    // --
    // this routine is written just for the people who has hundreds (may be thousands) of messages
    // staying just in one mailbox.
    // --
    // kinda complicated stuff but it works.
    // --
    $pages = ceil($nmsgs / $user_set["psize"]);
    $pgcnt = 0;
    if($pages != 1) { // if we have pages
       echo $lng->p(228);
       if($fromPage) {
           $prevPage = $fromPage - 10; // if we are not on the firstPage
           if($fromPage * $user_set["psize"] == $fromMsg) $prevMsg = $fromMsg - $user_set["psize"]; // if this page is x1 (e.g 21, 31, 41, etc)
           else $prevMsg = $fromMsg - (10 * $user_set["psize"]); // if this page is x1 make it (x-1)1 (e.g 23 -> 13, 45 -> 35, etc)
           put_ahref("RequestID=MBOXLST&mbox=" . urlencode($mbox) . "&sort=" . $sort . "&fromMsg=" . $prevMsg . "&fromPage=" . $prevPage, "&nbsp;&#171;&nbsp;");
       } else $fromPage = 0;
       for($i = $fromPage ; $i < $pages ; $i++, $pgcnt++) {
           $this_from = $i * $user_set["psize"];
           if($pgcnt == 10) {
              $nextPage = $i;
              if(($nextPage - 1) * $user_set["psize"] == $fromMsg) $nextMsg = $fromMsg + $user_set["psize"];
	      else {
	          $nextMsg = $fromMsg + (10 * $user_set["psize"]);
		  if($nextMsg > $nmsgs) // what if the next page does not exist?
		     $nextMsg = $nextPage * $user_set["psize"]; // if so, make the next page the first page of the next 10
              }
              put_ahref("RequestID=MBOXLST&mbox=" . urlencode($mbox) . "&sort=" . $sort . "&fromMsg=" . $nextMsg . "&fromPage=" . $nextPage, "&nbsp;&#187;");
              break; // not user set (max 10 "more pages")
           }
           $j = $i + 1;
           if($pgcnt) echo "&nbsp;<small>&#183;</small>&nbsp;";
           if($this_from != $fromMsg) 
              put_ahref("RequestID=MBOXLST&mbox=" . urlencode($mbox) . "&sort=" . $sort . "&fromMsg=" . $this_from . "&fromPage=" . $fromPage, $j);
           else echo "<b>$j</b>";
       }
    }

    // attach the nextPage stuff to the Previous|XXX|Next.
    if((($fromPage + 1) * $user_set["psize"]) == $pluspsize) $prevPage = $fromPage - 10;
    else $prevPage = $fromPage;
    if((($fromPage + 10) * $user_set["psize"]) == $pluspsize) $nextPage = $fromPage + 10;
    else $nextPage = $fromPage;
}

function push_errinfo() {
    global $err_msg, $info_msg;
    if(!empty($err_msg)) {
        echo "<!-- ERROR MSG : START-->";
        echo "<table width=\"90%\" border=\"0\" cellpadding=\"1\" cellspacing=\"1\">\n";
	echo "<tr><td align=\"center\" class=\"error\">&nbsp;$err_msg&nbsp;</td></tr>\n";
        echo "</table>";
        echo "<!-- ERROR MSG : FINISH -->\n";
    } else if(!empty($info_msg)) {
        echo "<!-- INFO MSG : START -->";
        echo "<table width=\"90%\" border=\"0\" cellpadding=\"1\" cellspacing=\"1\">\n";
	echo "<tr><td align=\"center\" class=\"info\">&nbsp;$info_msg&nbsp;</td></tr>\n";
        echo "</table>";
        echo "<!-- INFO MSG : FINISH -->\n";
    }
}

function push_pagehdr() {
	$m = $GLOBALS["pagehdr_msg"];
	$u = $GLOBALS["username"];
	$d = $GLOBALS["domain_name"];
	echo "<table border=\"0\" cellpadding=\"3\" cellspacing=\"0\" width=\"95%\">";
	echo "<tr><td align=\"left\" class=\"pagehdr\"><b>";
	echo $m . ":</b>&nbsp;" . $u . "@" . $d;
	echo "</td></tr></table>\n";
}

// select box for settings
function push_langs() {
	global $bsx_lang;
	global $set_lang;

	echo "<select name='set_lang' size='1'>\n";
	for($i = 0 ; $i < count($bsx_lang) ; $i++) {
		echo "<option value='$i'";
		if($i == $set_lang) echo " selected";
		echo ">" . $bsx_lang[$i]["long"] . "</option>\n";
	}
	echo "</select>\n";
}

// build the js array for theme preview
function push_jsthemes() {
	global $bsx_theme;

	echo "<script language=\"Javascript\"><!-- //\n";
	echo "var bsxThemes = new Array();\n";
	for($i = 0 ; $i < count($bsx_theme) ; $i++) {
		echo "bsxThemes[$i] = '" . $bsx_theme[$i]["dir"] . "';\n";
	}
	echo "// --></script>\n";
}

// select box for themes
function push_themes() {
	global $bsx_theme, $set_theme, $theme_stats;
	global $BSX_BASEHREF;

	echo "<select name='set_theme' size='1' onChange='javascript:previewTheme(\"$BSX_BASEHREF\", this);'>\n";
	for($i = 0 ; $i < count($bsx_theme) ; $i++) {
		if(!$bsx_theme[$i]["active"]) continue;
		echo "<option value='$i'";
		if($i == $set_theme) echo " selected";
		$stat = $theme_stats[$i] + 1 - 1;
		if($i)
			echo ">" . $bsx_theme[$i]["desc"] . " ($stat)</option>\n";
		else
			echo ">" . $bsx_theme[$i]["desc"] . "</option>\n";
	}
	echo "</select>\n";
}

// if the server basilix runs on has lots of virtual domains, and if you want their 
// users use this webmail system, they need to select their domain from the select box
// and login. so if the user types "abc.com" as an address which is one of the virtual domains
// hosted on that machine, we'll push him a login form not selectable but abc.com instead.
function check_desired_domain() {
	global $bsx_domains, $bsx_domains_cnt;
	
	$http_host = strtolower($GLOBALS["HTTP_HOST"]);
	for($i = 0 ; $i < $bsx_domains_cnt ; $i++) {
		if(strtolower($bsx_domains[$i]["domain"]) == $http_host) return $i;
	}
	return -1;
}

// safe exec
function sexec($cmd) {
	// cleanup the cmd to prevent running of shell commands
	// on exec() call.
	$cmd = eregi_replace("[^-A-Za-z0-9_/\. ]", "", $cmd);
	@exec($cmd);
}

// correct strings (if they have "../")
function sstrings() {
	$okg = 0;
	while(list($gk, $gv) = each($GLOBALS)) {
		if($okg || $gk == "PHP_SELF")  {
			if(is_string($GLOBALS[$gk])) {
				$GLOBALS[$gk] = ereg_replace("\.\./", "", $gv);
			}
			$okg = 1;

		}
	}
}

// correct turkish chars wrt the translation table
function trans_tr($str) {
	$trans = array(
		"&#305;"	=>	"ý",
		"&#287;"	=>	"ð",
		"&#351;"	=>	"þ",
		"&#286;"	=>	"Ð",
		"&#350;"	=>	"Þ",
		"&#304;"	=>	"Ý"
	);
	return strtr($str, $trans);
}
sstrings();
?>
