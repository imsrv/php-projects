<?php
########################################
#### Check and validate a given domain name ####
########################################
function check_domain($dname) {
global $errormsg, $text_17, $text_18, $text_19, $minlength, $maxlength, $reserved;
// Check if special chars are in there
	if(ereg("[^a-zA-Z0-9\-]",$dname)) { 
		$errormsg = "$text_19<br>";
	}
// Check, if length is right
	if (strlen($dname) < $minlength || strlen($dname) > $maxlength) {
		$errormsg .= "$text_18<br>";
	}
// Check, if domain name is reserved by admin
	$reserved = explode("--",$reserved);
	if (in_array("$dname", $reserved)) {
		$errormsg .= "$text_17<br>";
	}
	return $errormsg;
}

###############################################
#### Checks, wether a domain name is available or not, ####
#### and if the extension is valid.                                        ####
###############################################
function check_domain2($dname, $extension) {
global $errormsg, $domain_table, $redir_table, $text_24, $text_20;
	$ext_query = mysql_num_rows(mysql_query("select * from $domain_table where domain='$extension'"));
	if($ext_query!="1") { // No match for a valid extension...
		$errormsg .= "$text_24<br>";
		}	
	$checkname = "$dname.$extension";
	$checkdom=mysql_num_rows(mysql_query("select * from $redir_table where host='$checkname'"));
	if($checkdom!="0") {
		$errormsg .="$text_20";
	}
	return $errormsg;
}

###################################
#### Checks a string on invalid content ####
###################################
function check_string($string) {
	if(ereg("[^a-zA-Z0-9\-\.]",$string)) { 
	return 1;
	}
	else {
	return 0;
	}
}

##########################################################
#### Generate random password - thanks to karl from toastman.com :-) ####
##########################################################
$i = 1;
$str = "";
Function randomstring($len) {
  	global $i;
	global $str;
	srand(date( "s")); 
  while($i<$len) { 
   $str.=chr((rand()%26)+97); 
   $i++; 
  } 
  return $str; 
 }

######################################
#### Calculates percentage of 2 numbers      ####
######################################
function percentcalc($part, $total) {
$perc = round((100 * $part / $total), 2);
return $perc;
}

######################################
#### Check an email adrress for correctness ####
######################################
function verify_email($email) {
  if(eregi("^[_a-z0-9-]+(\\.[_a-z0-9-]+)*@[a-z0-9-]+(\\.[a-z0-9-]+)*(\\.[a-z]{2,4})$", trim($email))) {
    return 1;
  } else {
    return 0;
  }
}

######################################
#### Replaces the weekday name          ####
######################################
function replace_dayname($dayname) {
global $text_209,$text_210,$text_211,$text_212,$text_213,$text_214,$text_215;
switch($dayname) {
	case "Monday":
		return $text_209;
		break;
	case "Tuesday":
		return $text_210;
		break;
	case "Wednesday":
		return $text_211;
		break;
	case "Thursday":
		return $text_212;
		break;
	case "Friday":
		return $text_213;
		break;
	case "Saturday":
		return $text_214;
		break;
	case "Sunday":
		return $text_215;
		break;
	default:
		return "unknown";
	}
}

################################
#### Grab metatags from a given url ####
################################
function spider($url1) {
	if(!preg_match("=://=", $url1)) {
		return 0;
		exit;
		}
	$fh = @fopen("$url1", "r");
	if(!$fh) {
		return 0;
		exit;
		}
	$grabfile = fread($fh, 3000);
	preg_match("|<title[^>]*>(.*)</title>|siU", $grabfile, $title);
	$metatags = get_meta_tags("$url1");

	$title = $title[1];
	$description = $metatags["description"];
	$keywords = $metatags["keywords"];
	$revisit = $metatags["revisit"];

	@fclose($fh);

	return array($title,$description,$keywords,$revisit);
}

#################################################
#### Checks, if target homepage contains forbidden words ####
#### It checks the whole indexpage of the target homepage ####
##################################################
function check_forbidden($url1) {
	global $forbidden;
	$forbidden = explode("--",$forbidden);
	$fh = @fopen("$url1", "r");
	if(!$fh) {
		return 0;
		exit;
		}
	$grabpage = fread($fh, 20000);
	foreach($forbidden as $match) {
		if ($match!="") {
		if(ereg("$match", $grabpage)) {
			@fclose($fh);
			return 1;
			exit;
			}
			}
		}
	@fclose($fh);
	return 0;
}

##################################################
#### Class for a simple template engine                                     ####
#### Based on a book by Tobias Ratschiller and Till Gerken ####
##################################################
class MyredTemplate
{
    var $error = "";                // Last error message will be stored here
    
    var $tags = array();            // For the tag values pairs, as defined by assign()
    
    function MyredTemplate($template_file)
    {
        if(!file_exists($template_file))
        {
            $this->error = "The template file $template_file does not exist.";
        }
        $this->template_file = $template_file;
    }

    function assign($tag, $value)
    {
        if(empty($tag))
        {
            $this->error = "Tag is empty";
            return(false);
        }
        
        $this->tags[$tag] = $value;
        return(true);
    }

    function myred_parse()
    {
        $contents = @implode("", (@file($this->template_file)));

        while(list($key, $value) = each($this->tags))
        {
            $tag = '{'.$key.'}';
            $contents = str_replace($tag, $value, $contents);
        }   
        return($contents);    
    }

    function myred_print()
    {
        $ret = $this->myred_parse();
        if($ret == false)
        {
            return(false);
        }
        print($ret);
        return(true);
    }
}

#############################################################
#### This is a set of functions to authenticate, login and logout users ####
#############################################################

// Checks, if given hostname and password fit to the ones stored in the mysqlDB
function login_user($user_name, $pass_word) {
global $redir_table;
// form our sql query
$result = mysql_query("SELECT * FROM $redir_table WHERE host ='$user_name'") or die (mysql_error());

if(!$result || mysql_num_rows($result)!=1) {
// no user is found
	$success = 0;
	return $success;
	}

$row = mysql_fetch_array($result);
if (($row["host"] == $user_name) AND ($row["passwd"] == $pass_word) AND ($user_name != "")) { 

 // User has been authenticated, send a cookie
	$user_id = $row["host"];
 
	 SetCookie("myred14", "$user_id:$pass_word", time()+7200); // expires two hours from now
	$success = 1; 
	}
else {
	$success = 0; 
	}
return $success; 
} 

// Check, if cookie is valid
function verify_auth($cookie) {
global $redir_table;

// Split the cookie up into host and md5(password) 
$auth = explode(":", $cookie);
// Look, if host exits
$query = mysql_query("SELECT * FROM $redir_table WHERE host = '$auth[0]'"); 
$row = mysql_fetch_array($query); 
 
if (($row["host"] == $auth[0]) AND ($row["passwd"] == $auth[1]) AND ($auth[0] != "")) {
	$success = 1;
	}
else {
	$success = 0; 
	}
return $success; 
}

################################################################
#### This is a set of functions for showing and browsing the member directory ####
################################################################

function GetNumberOfLinks($cat) {
   global $category_table, $redir_table;
// Get the numbers of members for this category
     $result = mysql_query("SELECT * FROM $redir_table WHERE cat='$cat' and active='on'") or die (mysql_error());
     $total = mysql_num_rows($result);
     return $total;
}

?>