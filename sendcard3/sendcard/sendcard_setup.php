<?php

// Enter your database details
 $dbhost     = "dbhost";
 $dbdatabase = "dbname";
 $dbuser     = "dbuser";
 $dbpass = "dbpass";

// Choose your database file
$dbfile = "db_mysql.php";

// The subject of the message sent to the receipient
$youhavecard_subject = "[from] has sent you a postcard!";

// This is the message sent to the recipient of the card.
//It can span multiple lines
$youhavecard = "Hello [to],

[from] has send you a postcard!

You can find it at [card_url]

Service provided by sendcard";

// The subject of the message sent to the sender
$cardreceived_subject = "Thank you for sending a postcard!";

// This is the message sent to the sender to notify him that the card
// has been received.  It can span multiple lines.
$cardreceived = "Hello [from],
Thank you for sending a postcard. [to] picked it up on [date].

Please keep visiting our site!";

// How long you want the postcard kept for in seconds e.g. 1209600 = 14 days!
// You can work it out using the following formula:
// {num of days} x 24 x 3600 = num of seconds.
// So 21 days is: 21 x 24 x 3600 = 1814400

$kept = 1209600;

// Message to appear at the bottom of the received card
$view_message = "<a href=\"sendcard.php?view=1&id=$id&print=1\">Print-friendly version</a><br>To send a postcard, please visit <a href=\"http://www.sendcard.f2s.com/sendcard2/\">sendcard</a>";

// Name of the table the postcards are stored in
$tbl_name = "sendcard";

// Message shown when the card has been sent
$thankyou = "Thankyou for sending a postcard.  To send another please <a href=\"index.php\">click here</a>.";

// If you want to use the feature that allows a visitor to send a card on an advance date, set this variable to 1.  Otherwise, set it to 0.  Remember to remove the "Send the card when?:" message from form.tpl :-)
$use_adv_date = 1;
$use_fontface = 1;
$use_fontcolor = 1;
$use_bgcolor = 1;
$use_music = 1;
$use_stats = 0;
$sc_version = "3.0.4";
$stats_table = "";
// Define the label to appear on the submit button
$send_button_label = "Send this card";

// Define the message that appears if the card cannot be found
$no_card_msg = "Sorry, we can\'t seem to find your card.<br>Please check that you copied the full URL, and that the time limit hasn\'t expired.";
$email_error = "<tr><td width=\"100%\" colspan=\"2\"><font color=\"#009966\" size=\"+1\"><b>Please enter a valid email address</b></font></td></tr>";
$sendcard_http_path = 'http://www.yoursite.com/sendcard/';
$music_path = "music/";

// Advanced options
// Path to the template directory: either relative to sendcard.php or the full directory path.
$tpl_path = "templates/";
// Path to image directory
$img_path = "images/";
$php_in_tpl = 0;
?>