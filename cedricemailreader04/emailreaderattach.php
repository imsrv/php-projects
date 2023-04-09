<?
// ************************************************************
// * Cedric email reader, lecture des emails d'une boite IMAP.*
// * Function library for IMAP email reading.                 *
// * Realisation : Cedric AUGUSTIN <cedric@isoca.com>         *
// * Web : www.isoca.com                                      *
// * Version : 0.4                                            *
// * Date : Septembre 2001                                    *
// ************************************************************

// This job is licenced under GPL Licence.

include('lib/emailreader_execute_on_each_page.inc.php');

$mimetype = array('text', 'multipart', 'message', 'application', 'audio', 'image', 'video', 'other'); 

// Open message box and read message structure and part
$mbox = open_mailbox($server, $username, $password);
$structure = imap_fetchstructure($mbox,$msgid); 
$attach_body = imap_fetchbody($mbox,$msgid, $partnumber+1);
close_mailbox($mbox);

// Get the Mime Type
$atype = $structure->parts[$partnumber]->type;
if($atype == "") $atype = 0; // Text
$asubtype = $structure->parts[$partnumber]->subtype;
if($asubtype == "") $asubtype = 'PLAIN';

$attach_type = $mimetype[$atype]."/".$asubtype;
$attach_name = $structure->parts[$partnumber]->parameters[0]->value;
if($attach_name = '') $attach_name = 'noname';

// Get the encode and decode
$anencode = $structure->parts[$partnumber]->encoding;
if($anencode == 3){
	$return_content = imap_base64($attach_body);
} else if($anencode == 4){
	$return_content = imap_qprint($attach_body);
} else {
	$return_content = $attach_body;
}

Header("Content-type: $attach_type");
if(($atype != 0) && ($atype != 5)){ // not a text or an image, so download
	Header( "Content-Disposition: attachment; filename=$attach_name" );
};
echo $return_content;

?>