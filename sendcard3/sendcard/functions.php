<?php

/*
 *  Functions for sendcard.
 *  Copyright Peter Bowyer <sendcard@f2s.com>, 2001.
 *  This script is released under the TrollTech QPL
 *  
 *  
 */


class DB_Sendcard extends DB_Sql {
  var $Debug         = 0;     ## Set to 1 for debugging messages.
  var $Halt_On_Error = "yes"; ## "yes" (halt with message), "no" (ignore errors quietly), "report" (ignore errror, but spit a warning)

  function DB_Sendcard($query = "") {
    global $dbhost;
    global $dbpass;
    global $dbuser;
    global $dbdatabase;

    $this->Host = $dbhost;
    $this->Password = $dbpass;
    $this->User = $dbuser;
    $this->Database = $dbdatabase;

    $this->DB_Sql($query);
  }
}

Class Sendcard_Template extends Template {

  function Sendcard_Template($root = ".", $unknowns = "remove") {
    if ($this->debug & 4) {
      echo "<p><b>Template:</b> root = $root, unknowns = $unknowns</p>\n";
    }
    $this->set_root($root);
    $this->set_unknowns($unknowns);
  }
	/*
	 * private:
	 */
	function del_block($container, $handle) {
		$this->set_block($container, $handle);
		$this->set_var($handle, "");
	}

  /***************************************************************************/
  /* private: loadfile(string $varname)
   * varname:  load file defined by varname, if it is not loaded yet.
   */
  function loadfile($varname) {
    if (!isset($this->file[$varname])) {
      // $varname does not reference a file so return
      return true;
    }

    if (isset($this->varvals[$varname])) {
      // will only be unset if varname was created with set_file and has never been loaded
      // $varname has already been loaded so return
      return true;
    }
    $filename = $this->file[$varname];

    /* use @file here to avoid leaking filesystem information if there is an error */
//   $str = implode("", @file($filename));
	if (floor(phpversion()) == 3) {
		$str = implode("", @file($filename));
	} else {
		$str = _parseFile($filename);
	}
    if (empty($str)) {
      $this->halt("loadfile: While loading $varname, $filename does not exist or is empty.");
      return false;
    }

    $this->set_var($varname, $str);

    return true;
  }
	
} // End Class Sendcard_Template

/**
 * This function allows PHP in the templates to be executed.
 *
 * @author	Robin Vickery <robinv@ecosse.net>
 * @param		$match, the array of items matched using preg_replace_callback.
 * @return	The contents of the file.
 */
function _parseFile( $filename ) {
    ob_start();
      include($filename);
      $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

/**
 * This function checks that the supplied email addresses are vaild.
 *
 * @author Peter Bowyer
 * @param	$email, array of email addresses.
 * @return returns 1 on success, 0 on failure.
 */
function validate_email ($email) {
for ($i=0; $i < count($email); $i++){
    if (eregi ("^([a-z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,4}\$", $email[$i])) {
        return 1;
        }else{
        return 0;
        break;  // Do I need break in here??????  Beats me!
        }// End if
}// End for
}// End function validate_email

/**
 * This function checks that the sender's email addresses are vaild.
 *
 * @author	Peter Bowyer
 * @param	$email, email address.
 * @return	returns 1 on success, 0 on failure.
 */
function validate_from_email ($email) {
    if (eregi ("^([a-z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,4}\$", $email)) {
        return 1;
        }else{
        return 0;
        break;  // Do I need break in here??????  Beats me!
        }// End if
}// End function validate_from_email

// Check that both email addresses validate
if ( isset($preview) ) {
        if (!validate_email($to_email)) {
        unset ($preview);
        $invalid_to_email = 1;
        }
        if (!validate_from_email($from_email)){
        unset ($preview);
        $invalid_from_email = 1;
        }
}

/**
 * This function changes any URLs surrounded by <> into clickable URLs in
 * the message.
 *
 * @author	Peter Bowyer
 * @param	$text, the message from the postcard.
 * @return	returns $text, the message with hyperlinks in it.
 */
function makeurl($text) {
$text = eregi_replace("&lt;([http|news|ftp]+://[^ >\n\t]+)&gt;", "<a href=\"\\1\" target=\"_blank\">\\1</a>", $text);
$text = eregi_replace("&lt;(mailto:)([^ >\n\t]+)&gt;", "<a href=\"\\1\\2\">\\2</a>", $text);
return $text;

}


/**
 * Returns the size of the image - needed to stop the contents of the card
 * shifting when the image loads.
 *
 * @author	Peter Bowyer
 * @param	$text, the message from the postcard.
 * @return	returns $text, the message with hyperlinks in it.
 */
function img_width($image) {
	global $img_path;
	if($image !="") {
		$size = GetImageSize($img_path . $image);
		return $size[0];
	}
}

function img_height($image) {
	global $img_path;
	if ($image != "") {
		$size = GetImageSize($img_path . $image);
		return $size[1];
	}
}


/**
 * Used instead of htmlspecialchars(), as that caused problems when displaying
 * Hebrew text.
 *
 * @author	Peter Bowyer
 * @param	$str, a string of text.
 * @return	returns $text, the message with hyperlinks in it.
 */
function makesafe($str){
	global $tpl_path;
	$file = file($tpl_path . "replace.txt");
	for($i=0; $i < count($file); $i++) {
		$parts = split("\t", $file[$i]);
		$parts[1] = trim($parts[1]);
		if($parts[0] != "") {
			$str = str_replace($parts[0], $parts[1], $str);
		}
	}
	return $str;
}


/**
 * Creates part of the id for the card.
 *
 * @author	Peter Bowyer
 * @return $str, the id of the card (less two digits)
 */
function advancetime($month="", $day="", $year="") {
	if ($month == "" || $day == "" || $year == "") {
		return time();
	} else {
		$now = getdate();
		$mktime = mktime($now["hours"],$now["minutes"],$now["seconds"],$month,$day,$year);
		return $mktime;
	} // End if
} // End function

     /*
     ** Function: DateSelector
     ** Version v2.0
     ** Last Updated: 2000-05-01
     ** Author: Leon Atkinson <leon@leonatkinson.com>
     ** Creates three form fields for get month/day/year
     ** Input: Prefix to name of field, default date
     ** Output: HTML to define three date fields
     ** This version highly modified by Peter Bowyer
     */
    function DateSelector($inName, $useDate=0){
        //create array so we can name months
        $monthName = array(1=> "January",  "February",  "March",
            "April",  "May",  "June",  "July",  "August",
            "September",  "October",  "November",  "December");

        //if date invalid or not supplied, use current time
        if($useDate == 0)
        {
            $useDate = time();
        }

        /*
        ** make day selector
        */
        $month  = "<select name=\"day\">\n";
        for($currentDay=1; $currentDay <= 31; $currentDay++)
        {
            $month  .= "<option value=\"$currentDay\"";
            if(intval(date( "d", $useDate))==$currentDay)
            {
                $month  .= " selected";
            }
            $month  .= ">$currentDay</option>\n";
        }
        $month  .= "</select>&nbsp;\n\n\n";

        /*
        ** make month selector
        */
        $month .= "<select name=\"month\">\n";
        for($currentMonth = 1; $currentMonth <= 12; $currentMonth++)
        {
            $month  .= "<option value=\"";
            $month  .= intval($currentMonth);
            $month  .= "\"";
            if(intval(date( "m", $useDate))==$currentMonth)
            {
                $month  .= " selected";
            }
            $month  .= ">" . $monthName[$currentMonth] .  "</option>\n";
        }
        $month  .= "</select>&nbsp;\n\n\n";

        /*
        ** make year selector
        */
        $month  .= "<select name=\"year\">\n";
        $startYear = date( "Y", $useDate);
        for($currentYear = $startYear /* - 5 */; $currentYear <= $startYear +1; $currentYear++)
        {
            $month  .= "<option value=\"$currentYear\"";
            if(date( "Y", $useDate)==$currentYear)
            {
                $month  .= " selected";
            }
            $month  .= ">$currentYear</option>\n";
        }
        $month  .= "</select>\n\n";
    return $month;
    }

/**
 * This code sees whether the image string has .swf at the end.  If so then
 * it removes the image code from form.tpl and message.tpl.  Otherwise, it
 * removes the code for the Flash movie.
 * @author	Peter Bowyer
 * @param		$image, the image name.
 *
 */
function set_img_block($image) {
	Global $tpl;
	Global $applet_name;
	if( $applet_name != "" || eregi("\.(class|jar)$", trim($image)) ) {
		$tpl->set_block("img_tags", "java_block_$applet_name");
		$code = $tpl->get_var("java_block_$applet_name");
	} elseif(eregi("\.(swf)$", trim($image))) {
		$tpl->set_block("img_tags", "swf_block");
		$code = $tpl->get_var("swf_block");
	} elseif( eregi("\.(jpg|jpeg|gif|png)$", trim($image)) ) {
		$tpl->set_block("img_tags", "img_block");
		$code = $tpl->get_var("img_block");
	} elseif( eregi("\.(mov)$", trim($image)) ) {
		$tpl->set_block("img_tags", "quicktime_block");
		$code = $tpl->get_var("quicktime_block");
	} else {
		// Don't know what the file is, so we'll try embedding it.
		$tpl->set_block("img_tags", "embed_block");
		$code = $tpl->get_var("embed_block");
	}
	$tpl->set_var("IMG", $code);
}


/**
 * This function returns the first 3 numbers of the PHP version.
 * For example, if you are using PHP 4.0.6 it will return 406.
 *
 * @author	Peter Bowyer
 * @return	$ver, the version.
 */
function get_phpversion () {
	$ver = "";
	$temp = explode(".", phpversion());
	for($i = 0; $i < 3; $i++) {
		$ver .= $temp[$i];
	}
	return $ver;
}

/**
 * Replaces the placeholders in the emails with actual values.
 *
 * @author	Peter Bowyer
 * @param		$str, string containing the placeholders
 * @param		$to, the recipients name
 * @param		$to_email, the recipients email address
 * @param		$id, the id of the card
 * @return	$str, the string with the placeholders substituted.
 */
function subst_placeholders($str, $to, $to_email, $id = "") {
	global $from, $from_email;
	global $sendcard_http_path, $date, $message;
	$str = str_replace("[to]", $to, $str);
	$str = str_replace("[to_email]", $to_email, $str);
	$str = str_replace("[from]", $from, $str);
	$str = str_replace("[from_email]", $from_email, $str);
	$str = str_replace("[card_url]", $sendcard_http_path . "sendcard.php?view=1&id=$id", $str);
	$str = str_replace("[date]", $date, $str);
	$str = str_replace("[message]", $message, $str);
	$str = str_replace("[sender_card_url]", $sendcard_http_path . "sendcard.php?view=1&sender_view=1&id=$id", $str);
	return $str;
}

?>