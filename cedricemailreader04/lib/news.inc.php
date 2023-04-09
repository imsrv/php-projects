<?
// *** WARNING : this file is here only for exemple and don't have been tested in version 0.4

// **********************************************************
// * Bibliothèque de fonctions pour la lecture des messages *
// * d'un newsgroup.                                        *
// * Function library for IMAP email reading.               *
// * Realisation : Cedric AUGUSTIN <cedric@isoca.com>       *
// * Web : www.isoca.com                                    *
// * Version : 0.4                                          *
// * Date : Sept 2001                                       *
// **********************************************************

// This job is licenced under GPL Licence.





// Open connection to the IMAP mail server
function open_mailbox($servername, $userlogin, $userpassword) {
   $imaphost = "{".$servername.":119/nntp"."}"."INBOX";
   $imapmsgbox = imap_open ($imaphost, $userlogin, $userpassword);
   return $imapmsgbox;
}

// Close connection to the IMAP mail server
function close_mailbox($imapmsgbox) {
   imap_close($imapmsgbox);
};


// Get detailled email header
function getdetailledheader($imapmsgbox, $msgnb) {
   $mailheader=imap_header($imapmsgbox, $msgnb);
   $rawsubject = imap_mime_header_decode($mailheader->subject);
   $mheaderarray[0]=$rawsubject[0]->text;
   $mheaderarray[1]=htmlspecialchars(str_replace("\"","",$mailheader->fromaddress));
   $mheaderarray[2]=$mailheader->toaddress;
   $mheaderarray[3]=$mailheader->reply_toaddress;
   $mheaderarray[4]=$mailheader->Date;
   return $mheaderarray;
};


// Get a raw message body
function getrawmessagebody($imapmsgbox, $msgnb){
   $mailraw=imap_body($imapmsgbox,$msgnb);
   return $mailraw;
};


// Get the mime type of a subpart MIME email
// *** Not used anymore ***
function get_mime_type(&$structure) { 
  $primary_mime_type = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER"); 
  if($structure->subtype) { 
    return $primary_mime_type[(int) $structure->type] . '/' . $structure->subtype; 
  };
  return "TEXT/PLAIN"; 
};


// Get a defined subpart of a MIME email
// *** Not used anymore ***
function get_part($stream, $msg_number, $mime_type, $structure = false, $part_number = false) { 
  if(!$structure) { 
    $structure = imap_fetchstructure($stream, $msg_number); 
  } 
  if($structure) { 
    if($mime_type == get_mime_type($structure)) { 
      if(!$part_number) { 
        $part_number = "1"; 
      } 
      $text = imap_fetchbody($stream, $msg_number, $part_number); 
      if($structure->encoding == 3) { 
        // $text = str_replace(" =\r\n","\r\n",$text);
        return imap_base64($text); 
      } 
      else
        if($structure->encoding == 4) { 
          return imap_qprint($text); 
        } 
        else { 
          return $text; 
        } 
      } 

      if($structure->type == 1) { /* multipart */ 
        while(list($index, $sub_structure) = each($structure->parts)) { 
          if($part_number) { 
            $prefix = $part_number . '.'; 
          } 
          $data = get_part($stream, $msg_number, $mime_type, $sub_structure, $prefix . ($index + 1)); 
          if($data) { 
            return $data; 
          } 
        }
        // Forwarded email, $part_number is 2 or 3
        $part_number = "2";
        while(list($index, $sub_structure) = each($structure->parts)) { 
          if($part_number) { 
            $prefix = $part_number . '.'; 
          } 
          $data = get_part($stream, $msg_number, $mime_type, $sub_structure, $prefix . ($index + 1)); 
          if($data) { 
            return $data; 
          } 
        } 

 
      }
  } 
  return false; 
};


// Get Header of a MIME email
function get_header($stream, $msg_number) { 
  $structure = imap_fetchstructure($stream, $msg_number); 
  $text = imap_fetchbody($stream, $msg_number, "0"); 
  return $text; 
} 

// Chunk-split text every 75 chars
function splittext($text){
	return word_wrap($text, 75, "");
};


/* word_wrap($string, $cols, $prefix)
 *
 * Takes $string, and wraps it on a per-word boundary (does not clip
 * words UNLESS the word is more than $cols long), no more than $cols per
 * line. Allows for optional prefix string for each line. (Was written to
 * easily format replies to e-mails, prefixing each line with "> ".
 *
 * Copyright 1999 Dominic J. Eidson, use as you wish, but give credit
 * where credit due.
 */
    function word_wrap ($string, $cols = 80, $prefix = "") {

	$t_lines = split( "\n", $string);
        $outlines = "";

	while(list(, $thisline) = each($t_lines)) {
	    if(strlen($thisline) > $cols) {

		$newline = "";
		$t_l_lines = split(" ", $thisline);

		while(list(, $thisword) = each($t_l_lines)) {
		    while((strlen($thisword) + strlen($prefix)) > $cols) {
			$cur_pos = 0;
			$outlines .= $prefix;

			for($num=0; $num < $cols-1; $num++) {
			    $outlines .= $thisword[$num];
			    $cur_pos++;
			}

			$outlines .= "\n";
			$thisword = substr($thisword, $cur_pos, (strlen($thisword)-$cur_pos));
		    }

		    if((strlen($newline) + strlen($thisword)) > $cols) {
			$outlines .= $prefix.$newline."\n";
			$newline = $thisword." ";
		    } else {
			$newline .= $thisword." ";
		    }
		}

		$outlines .= $prefix.$newline."\n";
	    } else {
		$outlines .= $prefix.$thisline."\n";
	    }
	}
	return $outlines;
    }

?>