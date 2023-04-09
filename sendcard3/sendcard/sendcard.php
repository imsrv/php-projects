<?php
/*
 *  sendcard
 *  Copyright Peter Bowyer <sendcard@f2s.com>
 *  This script is released under the TrollTech QPL
 *  Please see docs/index.html for more details.
 *  
 *  
 */

// This prints the format: "Sunday 8th October at 09:57 GMT"
$date = date("l jS F")." at ".date("H:i T");

/*
 * Declare variables used from files below to remove security risk
 */

$dbfile = "";

if (!isset($from)) { $from = ""; }
if (!isset($to)) { $to = ""; }
if (!isset($image)) { $image = ""; }
if (!isset($caption)) { $caption = ""; }
if (!isset($bgcolor)) { $bgcolor = ""; }
if (!isset($to_email)) { $to_email = ""; }
if (!isset($from_email)) { $from_email = ""; }
if (!isset($fontface)) { $fontface = ""; }
if (!isset($fontcolor)) { $fontcolor = ""; }
if (!isset($message)) { $message = ""; }
if (!isset($music)) { $music = ""; }
if (!isset($notify)) { $notify = ""; }
if (!isset($template)) { $template = ""; }
if (!isset($id)) { $id = ""; }
if (!isset($applet_name)) { $applet_name = ""; }
if (!isset($user1)) { $user1 = ""; }
if (!isset($user2)) { $user2 = ""; }


/*** plugin top_file ***/

/*
 * Include all the necessary files
 */
include ("./sendcard_setup.php");
include ("./include/".$dbfile);
include("./include/template.inc");
include ("./functions.php");

$db = new DB_Sendcard;

/*****************************************************************************/
if ( isset($preview) ) {
/*****************************************************************************/

// Preview the card

$message = stripslashes($message);
$message = makesafe($message);

/*** plugin preview_top ***/

$notify = isset($notify);

if( !isset($month) ) {
	$month = "";
}
if( !isset($day) ) {
	$day = "";
}
if( !isset($year) ) {
	$year = "";
}

if ( !isset($template) || $template == "") {
	$template = "message";
}

$id = advancetime($month, $day, $year);

$caption = addslashes($caption);

$send_button = "
		<form method=\"post\" action=\"sendcard.php\">
		<input type=\"hidden\" name=\"image\" value=\"$image\">
		<input type=\"hidden\" name=\"caption\" value=\"$caption\">
		<input type=\"hidden\" name=\"bgcolor\" value=\"$bgcolor\">";
	$loop_num = count($to_email);
    for ($i=0; $i < $loop_num; $i++){
$send_button .= "
		<input type=\"hidden\" name=\"to[$i]\" value=\"$to[$i]\">
		<input type=\"hidden\" name=\"to_email[$i]\" value=\"$to_email[$i]\">";
    }

$send_button .= "
		<input type=\"hidden\" name=\"from\" value=\"$from\">
		<input type=\"hidden\" name=\"from_email\" value=\"$from_email\">
		<input type=\"hidden\" name=\"fontface\" value=\"$fontface\">
		<input type=\"hidden\" name=\"fontcolor\" value=\"$fontcolor\">
		<input type=\"hidden\" name=\"message\" value=\"$message\">
		<input type=\"hidden\" name=\"music\" value=\"$music\">
		<input type=\"hidden\" name=\"notify\" value=\"$notify\">
		<input type=\"hidden\" name=\"id\" value=\"$id\">
		<input type=\"hidden\" name=\"template\" value=\"$template\">
		<input type=\"hidden\" name=\"des\" value=\"$des\">
		<input type=\"hidden\" name=\"img_width\" value=\"$img_width\">
		<input type=\"hidden\" name=\"img_height\" value=\"$img_height\">
		<input type=\"hidden\" name=\"applet_name\" value=\"$applet_name\">";
if ($user1 != "") {
$send_button .= "		<input type=\"hidden\" name=\"user1\" value=\"$user1\">";
}
if ($user2 != "") {
$send_button .= "		<input type=\"hidden\" name=\"user2\" value=\"$user2\">";
}
$send_button .= "		<input type=\"submit\" name=\"send\" value=\"" . $send_button_label . "\">";

/*** plugin preview_send_button ***/

$send_button .= "
        </form>";


$message = makeurl($message);
$caption = stripslashes($caption);

$tpl = new Sendcard_Template($tpl_path);
$tpl->set_file(array("message" => "$template.tpl", "card" => "$des.tpl", "img_tags" => "image.tpl"));

set_img_block($image);

$tpl->set_var("IMG_PATH", $img_path);
$tpl->set_var("IMAGE", $image);
$tpl->set_var("CAPTION", $caption);
$tpl->set_var("BGCOLOR", "$bgcolor");
$tpl->set_var("TO", $to[0]);
$tpl->set_var("TO_EMAIL", $to_email[0]);
$tpl->set_var("FROM", $from);
$tpl->set_var("FROM_EMAIL", $from_email);
$tpl->set_var("FONTFACE", $fontface);
$tpl->set_var("FONTCOLOR", $fontcolor);
$tpl->set_var("IMG_WIDTH", $img_width);
$tpl->set_var("IMG_HEIGHT", $img_height);
$tpl->set_var("MESSAGE", nl2br($message));
$tpl->set_var("MUSIC", $music_path . $music);
$tpl->set_var("APPLET_NAME", $applet_name);
$tpl->set_var("USER1", $user1);
$tpl->set_var("USER2", $user2);

/*** plugin preview_bottom ***/

if ($music == "") {
	$tpl->del_block("message", "music_block");
}
$tpl->set_var("FOOTER", $send_button);

$tpl->parse("CONTENT", array("message", "card"));
$tpl->p("CONTENT", "card");

/*****************************************************************************/
}elseif ( isset($send) ) {
/*****************************************************************************/

/**
 *
 * Send the card
 *
 */
//echo($id . "<br>" . time() );
if ($id > time()) {
$emailsent = 0;
}else{
$emailsent = 1;
}

/*** plugin send_top ***/

if(!get_magic_quotes_gpc()){
	$loop_num = count($to);
    for($i=0;$i< $loop_num; $i++){
         $to[$i] = addslashes($to[$i]);
    }
    $from = addslashes($from);
}
//$message = makesafe($message);
$message = nl2br($message);

if(!get_magic_quotes_gpc()){
     $message = addslashes($message);
     $caption = addslashes($caption);
     $user1 = addslashes($user1);
     $user2 = addslashes($user2);
}

mt_srand ((double) microtime() * getmypid() );
$loop_num =  count($to_email);
for ($i = 0; $i < $loop_num; $i++){
     $randid = mt_rand (0, 99);
	// If the number < 10, we pad it.
	while ( strlen($randid) != 2){
		$randid = "0" . $randid;
	}
     $id_bak = $id;
     $id .= $randid . $i;
     $sql = "INSERT INTO $tbl_name (image, caption, bgcolor, towho, to_email, fromwho, from_email, fontcolor, fontface, message, music, id, notify, emailsent, template, des, img_width, img_height, applet_name, user1, user2";
	/*** plugin send_loop_sql_1 ***/
	$sql .= ") VALUES ('$image', '$caption', '$bgcolor', '$to[$i]', '$to_email[$i]', '$from', '$from_email', '$fontcolor', '$fontface', '$message', '$music', '$id', '$notify', '$emailsent', '$template', '$des', '$img_width', '$img_height', '$applet_name', '$user1', '$user2'";
     /*** plugin send_loop_sql_2 ***/
	$sql .= ")";
     $db->query($sql);

     /*** plugin send_loop ***/



	if ($emailsent == 1) {
		$youhavecard_subject_p = subst_placeholders($youhavecard_subject, $to[$i], $to_email[$i], $id);
		$youhavecard_p = subst_placeholders($youhavecard, $to[$i], $to_email[$i], $id);
		@mail ("$to_email[$i]", "$youhavecard_subject_p", "$youhavecard_p", "From: $from_email\r\nX-Mailer:sendcard $sc_version - PHP/" . phpversion());
    }// End if

	$id = $id_bak;
}//End for



$tpl = new Sendcard_Template($tpl_path);
$tpl->set_file(array("card" => "$des.tpl"));
/*** plugin send_bottom ***/
$tpl->set_var("CONTENT", $thankyou);
$tpl->pparse("GLOBAL", "card");

/*****************************************************************************/
}elseif ( isset($view) ){
/*****************************************************************************/

/*** plugin view_top ***/

$query = "SELECT * FROM $tbl_name where id='$id'";
$db->query($query);

while($db->next_record()) {
$image = $db->f("image");
$caption = stripslashes($db->f("caption"));
$bgcolor = $db->f("bgcolor");
$to = stripslashes( $db->f("towho") ) ;
$to_email = $db->f("to_email");
$from = stripslashes($db->f("fromwho"));
$from_email = $db->f("from_email");
$message = stripslashes($db->f("message"));
$fontface = $db->f("fontface");
$fontcolor = $db->f("fontcolor");
$template = $db->f("template");
$music = $db->f("music");
$notify = $db->f("notify");
$des = $db->f("des");
$img_width = $db->f("img_width");
$img_height = $db->f("img_height");
$applet_name = $db->f("applet_name");
$user1 = stripslashes($db->f("user1"));
$user2 = stripslashes($db->f("user2"));
$id = $db->f("id");
}

// If we have the printer friendly version requested:
if($print) {
	$des = "print";
	$view_message = $print_view_message;
}

$tpl = new Sendcard_Template($tpl_path);
$tpl->set_file(array("message" => "$template.tpl",
				"card" => "$des.tpl",
				"img_tags" => "image.tpl"));



// Check to see if there was a matching row in the database
if($to != "") {
$message = makeurl($message);
set_img_block($image);

/*** plugin view_middle ***/

$tpl->set_var("IMG_PATH", $img_path);
$tpl->set_var("IMAGE", $image);
$tpl->set_var("CAPTION", $caption);
$tpl->set_var("BGCOLOR", "$bgcolor");
$tpl->set_var("TO", $to);
$tpl->set_var("TO_EMAIL", $to_email);
$tpl->set_var("FROM", $from);
$tpl->set_var("FROM_EMAIL", $from_email);
$tpl->set_var("FONTFACE", "$fontface");
$tpl->set_var("FONTCOLOR", "$fontcolor");
$tpl->set_var("MESSAGE", $message);
$tpl->set_var("MUSIC", $music_path . $music);
$tpl->set_var("IMG_WIDTH", $img_width);
$tpl->set_var("IMG_HEIGHT", $img_height);
$tpl->set_var("APPLET_NAME", $applet_name);
$tpl->set_var("USER1", $user1);
$tpl->set_var("USER2", $user2);
$tpl->set_var("FOOTER", $view_message);
if ($music == "") {
	$tpl->del_block("message", "music_block");
}
$tpl->parse("CONTENT", "message");
$tpl->pparse("CONTENT", "card");


// Check to see that the sender has asked to be notified, and that it isn't the sender viewing the card.
if ($notify == 1 && $sender_view != "1"){
	$cardreceived_subject = subst_placeholders($cardreceived_subject, $to, $to_email, $id);
	$cardreceived = subst_placeholders($cardreceived, $to, $to_email, $id);
	@mail ($from_email, $cardreceived_subject, $cardreceived, "From: $to_email\r\nX-Mailer:sendcard $sc_version - PHP/" . phpversion());


$query = "UPDATE $tbl_name SET notify='0' where id=".$id;
$db->query($query);
}

$time = time();
$oldtime = $time - $kept;
$oldtime .= "000";

$clearout = ("DELETE FROM $tbl_name where id < $oldtime");
$db->query($clearout);
/*** plugin view_bottom ***/

// If no data was found, we print an apologetic message.
} else{
	$tpl->set_var("CONTENT", $no_card_msg);
	$tpl->pparse("CONTENT", "card");
} // End else

/*****************************************************************************/
}else{
/*****************************************************************************/

/*
 * This is where we generate the form to fill in the card.
 */
if( !isset($num_recipients) ){
    $num_recipients = 1;
}

// Now we test to see if the image width and height have been specified. If not,
// we get them from the image.  We can only get them from GIF, JPG, PNG or SWF files
if(!isset($img_width) && !isset($img_height) ) {
	$img_width = img_width($image);
	$img_height = img_height($image);
}

if(!isset($form) || $form == ""){
	$form = "form";
}
if(!isset($des) || $des == ""){
	$des = "card";
}
if($template != "" ){
	$template_specified = 1;
	//$template = "message";
}

/*** plugin form_top ***/

$tpl = new Sendcard_Template($tpl_path);
$tpl->set_file(array("form" => "$form.tpl", "card" => "$des.tpl", "img_tags" => "image.tpl"));
$tpl->set_block("form", "recipient_block", "recipient");

set_img_block($image);



$tpl->set_var("APPLET_NAME", $applet_name);

$tpl->set_var("IMG_PATH", $img_path);
$tpl->set_var("IMAGE", $image);


$tpl->set_var("CAPTION", $caption);
$tpl->set_var("DES", $des);
$tpl->set_var("TEMPLATE", $template);
$tpl->set_var("IMG_WIDTH", $img_width);
$tpl->set_var("IMG_HEIGHT", $img_height);

for($i=0; $i<$num_recipients;$i++){
    $tpl->set_var("TO", $to[$i]);
    $tpl->set_var("TO_EMAIL", $to_email[$i]);
    $tpl->set_var("I", $i);
    $tpl->parse("recipient", "recipient_block", true);
}

$tpl->set_var("FROM", $from);
$tpl->set_var("FROM_EMAIL", $from_email);

if($use_adv_date) {
$tpl->set_var("DATE", DateSelector("Now"));
} else {
$tpl->set_var("DATE", "");
}
$tpl->set_var("APPLET_NAME", $applet_name);
$tpl->set_var("USER1", $user1);
$tpl->set_var("USER2", $user2);
$tpl->set_var("MESSAGE", $message);
$tpl->set_var("NUM_RECIPIENTS", $num_recipients);

if ( isset($invalid_to_email) ) {
$tpl->set_var("INVALIDTO_EMAIL", $email_error);
}else{
$tpl->set_var("INVALIDTO_EMAIL", "");
}
if ( isset($invalid_from_email) ) {
$tpl->set_var("INVALIDFROM_EMAIL", $email_error);
}else{
$tpl->set_var("INVALIDFROM_EMAIL", "");
}

$preview_button = "  <input type=\"hidden\" name=\"image\" value=\"$image\">
  <input type=\"hidden\" name=\"caption\" value=\"$caption\">
  <input type=\"hidden\" name=\"num_recipients\" value=\"$num_recipients\">
  <input type=\"hidden\" name=\"des\" value=\"$des\">
  <input type=\"hidden\" name=\"img_width\" value=\"$img_width\">
  <input type=\"hidden\" name=\"img_height\" value=\"$img_height\">
  <input type=\"hidden\" name=\"applet_name\" value=\"$applet_name\">";
if ($user1 != "") {
$preview_button .= "  <input type=\"hidden\" name=\"user1\" value=\"$user1\">";
}
if ($user2 != "") {
$preview_button .= "		<input type=\"hidden\" name=\"user2\" value=\"$user2\">";
}
  
if( isset($template_specified) && $template_specified == 1) {
	$tpl->del_block("form", "layout_block");
	$preview_button .= "  <input type=\"hidden\" name=\"template\" value=\"$template\">";
}

/*** plugin form_bottom ***/

$tpl->set_var("FOOTER", $preview_button);



$tpl->parse("CONTENT", "form");
$tpl->pparse("CONTENT", "card");

}//End else
