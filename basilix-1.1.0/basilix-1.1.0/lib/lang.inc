<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

require("$BSX_LIBDIR/lang.class");

// Load the desired language msg files
// -----------------------------------------------------------------------

function lang_init($lang) {
    global $lng;
    return $lng->init($lang);
}

function lang_load($section) {
    global $lng;
    $lng->load($section);
}

function lang_start($lang) {
    global $RequestID;

    $charset = lang_init($lang);

    // find the suitable language msg
    if($RequestID == "") $tmp = "DUMMY";
    else $tmp = $RequestID;
    switch($tmp) {
        case LOGIN:
	case CHUSER:
	case CHSLANG:
        case DUMMY:
	    $section = "login";
	    break;
        case FOLDERS:
	case CRTFOL:
	case DELFOL:
	case RENFOL:
	case EMPTFOL:
	    $section = "folders";
	    break;
	case ABOOK:
	    $section = "addrbook";
	    break;
	case SETTINGS:
	    $section = "settings";
	    break;
	case LOGOUT:
	    $section = "logout";
	    break;
	case READMSG:
	case SHOWHDR:
	case DELMSG:
	case PRINTMSG:
	    $section = "msgs";
	    break;
	case REPMSG:
	case REPAMSG:
	case FORWMSG:
	case CMPSNEW:
	case CMPSABOOK:
	case CMPSATCH:
	case CMPSSEND:
	case CMPSMENU:
	    $section = "compose";
	    break;
	case MBOXLST:
	case MBOXACT:
	    $section = "mboxlst";
	    break;
	case FINDMSG:
	    $section = "findmsg";
	    break;
    }
    lang_load($section);
    return $charset;
}

function getLangID($isolang) { // code by Benoit
    global $bsx_lang, $BSX_Lang;

    reset($bsx_lang);
    while(list($j, $spknlang) = each($bsx_lang)) {
          if($isolang == $spknlang["short"]) {
             // we found one
             return $j;
          }
    }
    return -1;
}

// --
if(empty($BSX_Lang)) {	// code by Benoit.
   // try to find a browser-accepted language that we speak
   // note : below, main language means the 2-letters iso code without the country code
   // as in en-US where en is the main language and US the country code

   $BSX_Lang = -1;
   $tmp_langarr = explode(",", $HTTP_ACCEPT_LANGUAGE);

   // now we're supposed to have items like "en-GB;q=0.5"
   $lastmainlang = substr($HTTP_ACCEPT_LANGUAGE, 0, 2); //initialise

   // for each accepted language...
   while(list($i, $acptlang) = each($tmp_langarr)) {
         // we simply ignore local languages like en_US as opposed to en_GB
         // (this is BAD! we should address this in a future release)
         $li = explode(";", $acptlang);
         $lang = trim($li[0]); // get language code only, not quality value
         $mainlang = substr($lang, 0, 2); // get the 2-letters main language code
         if($mainlang != $lastmainlang) {
            // we have a new main language
            if($lastmainlang != "") {
               // we haven't checked the main language yet (without country code)
               $BSX_Lang = getLangID($lastmainlang);
                if ($BSX_Lang != -1) break; // we speak that language, let's get out of here
            }
            $lastmainlang = $mainlang;  // remember this main language for later use
         } else if(strlen($lang) == 2) {
            // this is a main language, we are going to test it in this loop,
            // so we won't need to check it later
            $lastmainlang = "";
         }
         // ...search in the list of languages that we speak
         $BSX_Lang = getLangID($lang);
         if($BSX_Lang != -1) break; // we speak that language, let's get out of here
   }

}

// note: if we haven't found any language above, then $BSX_Lang == -1
$charset = lang_start($BSX_Lang);
// --
?>
