<?php
include("prepend.php");
?>

<html>
<head>
<title>sendcard properties</title>
</head>
<body bgcolor="#FFFFFF">
<?php

if ( isset($submit) ) {

if(!get_magic_quotes_gpc()){
$view_message = addslashes($view_message);
$thankyou = addslashes($thankyou);
$email_error = addslashes($email_error);
$no_card_msg = addslashes($no_card_msg);
}

$kept1 = 24 * 3600 * $kept;

$datafile = "<?php";

$datafile .= "

// Enter your database details
 \$dbhost     = \"$dbhost\";
 \$dbdatabase = \"$dbdatabase\";
 \$dbuser     = \"$dbuser\";
 \$dbpass = \"$dbpass\";

// Choose your database file
\$dbfile = \"$dbfile\";

// The subject of the message sent to the receipient
\$youhavecard_subject = \"$youhavecard_subject\";

// This is the message sent to the recipient of the card.
//It can span multiple lines
\$youhavecard = \"$youhavecard\";

// The subject of the message sent to the sender
\$cardreceived_subject = \"$cardreceived_subject\";

// This is the message sent to the sender to notify him that the card
// has been received.  It can span multiple lines.
\$cardreceived = \"$cardreceived\";

// How long you want the postcard kept for in seconds e.g. 1209600 = 14 days!
// You can work it out using the following formula:
// {num of days} x 24 x 3600 = num of seconds.
// So 21 days is: 21 x 24 x 3600 = 1814400

\$kept = $kept1;

// Message to appear at the bottom of the received card
\$view_message = \"$view_message\";

// Name of the table the postcards are stored in
\$tbl_name = \"$tbl_name\";

// Message shown when the card has been sent
\$thankyou = \"$thankyou\";

// If you want to use the feature that allows a visitor to send a card on an advance date, set this variable to 1.  Otherwise, set it to 0.  Remember to remove the \"Send the card when?:\" message from form.tpl :-)
\$use_adv_date = $use_adv_date;
\$use_fontface = $use_fontface;
\$use_fontcolor = $use_fontcolor;
\$use_bgcolor = $use_bgcolor;
\$use_music = $use_music;
\$use_stats = $use_stats;
\$sc_version = \"$sc_version\";
// Define the label to appear on the submit button
\$send_button_label = \"$send_button_label\";

// Define the message that appears if the card cannot be found
\$no_card_msg = \"$no_card_msg\";
\$email_error = \"$email_error\";

\$sendcard_http_path = \"$sendcard_http_path\";

// Advanced options
// Path to the template directory: either relative to sendcard.php or the full directory path.
\$tpl_path = \"$tpl_path\";
// Path to image directory
\$img_path = \"$img_path\";
// Path to music directory
\$music_path = \"$music_path\";
// Are you going to allow PHP code in the templates?
\$php_in_tpl = $php_in_tpl;
// The format of the date - COMING SOON!
";
$datafile .= '?';
$datafile .= '>';

$datafile = str_replace("\r", "", $datafile);

$file = fopen(DOCROOT . "sendcard_setup.php", "w+");
// $file = fopen("sendcard_setup.php", "w+");

fwrite ($file, $datafile);
fclose ($file);

echo('<h2 align="center">Settings updated.</h2>');
}

$to = "[to]";
$to_email = "[to_email]";
$from = "[from]";
$time = "[time]";
$date = "[date]";
$id = "\$id";

include(DOCROOT . "sendcard_setup.php");
// include("sendcard_setup.php");

$kept = $kept /(24 * 3600);
$cardreceived_subject = stripslashes($cardreceived_subject);
$cardreceived = stripslashes($cardreceived);
$thankyou = stripslashes($thankyou);

?> <!-- BEGIN content_block --> 
<form method="post" action="mod_properties.php">
  <p>Modify the messages given in the script:<br>
	These variables can be used: <br>
	[to] : Name of recipient<br>
	[to_email] : Recipient's email address<br>
	[from] : Name of sender<br>
	[from_email] : Sender's email address<br>
	[message] : The card's message <br>
	[date] : Date when the postcard was viewed<br>
	[card_url] : The URL for the recipient to pick up the card.<br>
	[sender_card_url] : Put in the sender's card. Allows them to view the card 
	without sending notification to themselves.</p>
  <p>Modify the email sent to the recipient:<br>
            subject:
            <input type="text" name="youhavecard_subject" value="<?php echo $youhavecard_subject; ?>" size="70" class="inputs">
            <br>
	Message:<br>
            <textarea name="youhavecard" cols="60" rows="10" class="inputs"><?php echo $youhavecard; ?></textarea>
          </p>
          <p>&nbsp;</p>
          <p>Modify the email sent to the sender when the card has been viewed:<br>
            subject:
            <input type="text" name="cardreceived_subject" value="<?php echo $cardreceived_subject; ?>" size="70" class="inputs">
            <br>
            Message:<br>
            <textarea name="cardreceived" cols="60" rows="10" class="inputs"><?php echo $cardreceived; ?></textarea>
          </p>
          <p>The message shown when the card has been sent:<br>
            <textarea name="thankyou" cols="70" class="inputs" wrap="VIRTUAL"><?php echo $thankyou; ?></textarea>
          </p>
          <p>Name of the table storing the postcards.  This will be used as the basename for the other tables created<br>
            <input type="text" name="tbl_name" value="<?php echo $tbl_name; ?>" class="inputs">
          </p>
          
  <p>Message to appear at bottom of received card. <br>
	Tip: if you include sendcard.php?view=1&id=$id&print=1 as a link, it will 
	use print.tpl as the template, allowing you to have a print-friendly layout. 
	<br>
	<textarea name="view_message" cols="70" rows="5" class="inputs"><?php echo $view_message; ?></textarea>
  </p>
          <p>Which database are you using?<br>
            <select name="dbfile" class="inputs">
               <option value="db_mssql.php" <?php if($dbfile == "db_mssql.php"){ echo "selected"; }?>>Microsoft SQL</option>
               <option value="db_mql.php" <?php if($dbfile == "db_mql.php"){ echo "selected"; }?>>MSql</option>
               <option value="db_mysql.php" <?php if($dbfile == "db_mysql.php"){ echo "selected"; }?>>MySQL</option>
               <option value="db_odbc.php" <?php if($dbfile == "db_odbc.php"){ echo "selected"; }?>>ODBC</option>
               <option value="db_oci8.php" <?php if($dbfile == "db_oci8.php"){ echo "selected"; }?>>Oracle/OCI8</option>
               <option value="db_oracle.php" <?php if($dbfile == "db_oracle.php"){ echo "selected"; }?>>Oracle</option>
               <option value="db_pgsql.php" <?php if($dbfile == "db_pgsql.php"){ echo "selected"; }?>>PostgreSQL</option>
               <option value="db_sybase.php" <?php if($dbfile == "db_sybase.php"){ echo "selected"; }?>>Sybase</option>
            </select>
          </p>
          <p>Please fill in your database details. We do not store these details
            anywhere. If you do not want to use your real details, put in something
            else and then replace them by hand later.</p>
          <p> Your database host<br>
            <input type="text" name="dbhost" value="<?php echo($dbhost); ?>">
          </p>
          <p>The name of your database<br>
            <input type="text" name="dbdatabase" value="<?php echo($dbdatabase); ?>">
          </p>
          <p>The username for your database<br>
            <input type="text" name="dbuser" value="<?php echo($dbuser); ?>">
          </p>
          <p>The password for your database<br>
            <input type="text" name="dbpass" value="<?php echo($dbpass); ?>">
          </p>
          <p>How many days do you want the postcards stored in the database?<br>
            <input type="text" name="kept" size="4" value="<?php echo($kept); ?>">
          </p>
          
          
  <p>The message that appears if the card cannot be found<br>
	<textarea name="no_card_msg" cols="60" rows="4">
<?php echo stripslashes($no_card_msg); ?>
</textarea>
  </p>
  <p>The error message if one of the email addresses is wrong. The current message 
	looks like:</p>
  <p><table><?php echo ($email_error); ?></table><br>
	<textarea name="email_error" cols="60" rows="4">
<?php echo stripslashes($email_error); ?>
</textarea>

 <p>The label to appear on the submit button on the preview screen<br>
	<input type="text" name="send_button_label" value="<?php echo($send_button_label); ?>">
  </p>

 <p>Please enter the address of the sendcard directory.  It must have a trailing slash:<br>
	<input type="text" name="sendcard_http_path" value="<?php echo($sendcard_http_path); ?>">
  </p>

  <p>&nbsp;
  <p>Will you allow the visitor to choose any of the following (if you choose no then it requires you to edit form.tpl:<br>
            Font Face: <br>
            <select name="use_fontface">
               <option value="1" <?php if($use_fontface == 1){ echo "selected"; }?>>YES</option>
               <option value="0" <?php if($use_fontface == 0){ echo "selected"; }?>>NO</option>
            </select>
            <br>
            Font Colour: <br>
            <select name="use_fontcolor">
               <option value="1" <?php if($use_fontcolor == 1){ echo "selected"; }?>>YES</option>
               <option value="0" <?php if($use_fontcolor == 0){ echo "selected"; }?>>NO</option>
            </select>
            <br>
            Background Colour: <br>
            <select name="use_bgcolor">
               <option value="1" <?php if($use_bgcolor == 1){ echo "selected"; }?>>YES</option>
               <option value="0" <?php if($use_bgcolor == 0){ echo "selected"; }?>>NO</option>
            </select>
            <br>
            Music: <br>
            <select name="use_music">
               <option value="1" <?php if($use_music == 1){ echo "selected"; }?>>YES</option>
               <option value="0" <?php if($use_music == 0){ echo "selected"; }?>>NO</option>
            </select>
            <br>
            Send at a future date (delayed send feature):<br>
            <select name="use_adv_date">
               <option value="1" <?php if($use_adv_date == 1){ echo "selected"; }?>>YES</option>
               <option value="0" <?php if($use_adv_date == 0){ echo "selected"; }?>>NO</option>
            </select>
           <br>
	Have you created the table for the statistics module?:<br>
            <select name="use_stats">
               <option value="1" <?php if($use_stats == 1){ echo "selected"; }?>>YES</option>
               <option value="0" <?php if($use_stats == 0){ echo "selected"; }?>>NO</option>
            </select>
          </p>
          <p>

  <h2>Advanced Options:</h2>
  <p>Path to the template directory: It can be either relative to sendcard.php 
	(if located in adirectory below sendcard.php) or the full directory path. 
	It must have a trailing slash. Default is templates/<br>
	<input type="text" name="tpl_path" value="<?php echo($tpl_path); ?>">
  </p>
  <p>Path to image directory. It should be relative to sendcard.php or an absolute 
	URL. It must have a trailing slash. Default is images/<br>
	<input type="text" name="img_path" value="<?php echo ($img_path); ?>">
  </p>
  <p>Path to the music directory. It can be relative be relative to sendcard.php 
	or an absolute URL. It must have a trailing slash. Default is music/<br>
	<input type="text" name="music_path" value="<?php echo ($music_path); ?>">
  </p>
<p>Please enter the version of sendcard (only necessary to change if upgrading sendcard):<br>
<input type="text" name="sc_version" value="<?php echo($sc_version); ?>">
</p>
  <p>Enable PHP in the templates?:<br>
            <select name="php_in_tpl">
               <option value="1" <?php if($php_in_tpl == 1){ echo "selected"; }?>>YES</option>
               <option value="0" <?php if($php_in_tpl == 0){ echo "selected"; }?>>NO</option>
            </select>
          </p>
            <input type="submit" name="submit" value="Save my settings" class="buttons">
            <br>
</form>
       <p><a href="mod_tables.php">Create the database tables</a></p>
    <!-- END content_block -->
</body>
</html>
