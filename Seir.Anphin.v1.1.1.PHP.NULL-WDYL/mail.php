<?php

$wordbits='mailto,mailfrom,mailsub,mailmsg,mailsubmit,mailreset,mailsent,mailnotsent,';
$settings='mailer_is_on,';

include('./lib/config.php');

doHeader("$sitename: Public Mailer");

if (getSetting('mailer_is_on')==0) {
	showmsg('mailer_is_off');
	footer(1);
}

if ($action=='news') $action='mailer';
if ($action=='mailer') {

	$recipient = isset($HTTP_GET_VARS['id']) ? intval($HTTP_GET_VARS['id']) : '';
	if ($recipient!='')
		$recipientname = getdisplayname($recipient);
	else
		$recipientname = '';

	$recipientname = isset($HTTP_GET_VARS['addr']) ? $HTTP_GET_VARS['addr'] : $recipientname;

	require('adminfunctions.php');

	$inputs[]=formtop('mail.php?action=sendmail');
	$inputs[]=inputform('hidden', '', 'sendtouser',  $recipient);
	$inputs[]=inputform('text', getwordbit('mailto'), 'to',  $recipientname);
	$inputs[]=inputform('text', getwordbit('mailfrom'), 'from');
	$inputs[]=inputform('text', getwordbit('mailsub'), 'subject');
	$inputs[]=inputform('textarea', getwordbit('mailmsg'), 'message');
	$inputs[]=inputform('submitreset', getwordbit('mailsubmit'), getwordbit('mailreset'));

	doinputs();
	formbottom();

} elseif ($action=='sendmail') {

	$to=$HTTP_POST_VARS['to'];
	$sendtouser=$HTTP_POST_VARS['sendtouser'];
	$from=$HTTP_POST_VARS['from'];
	$subject=$HTTP_POST_VARS['subject'];
	$message=$HTTP_POST_VARS['message'];

	if (is_numeric($sendtouser) && $sendtouser!='0')
		$to = $dbr->result("SELECT email FROM arc_user WHERE userid=$sendtouser");


	$headers="From: $from";
	$semi_rand=md5(time());
	$mime_boundary="==Multipart_Boundary_x{$semi_rand}x";
	$headers .= "\nMIME-Version: 1.0\n" .
              "Content-Type: multipart/mixed;\n" .
              " boundary=\"$mime_boundary\"";
	$message="This is a multi-part message in MIME format.\n\n" .
             "--{$mime_boundary}\n" .
             "Content-Type: text/plain; charset=\"iso-8859-1\"\n" .
             "Content-Transfer-Encoding: 7bit\n\n" .
             $message . "\n\n";
	$message .= "--{$mime_boundary}\n" .
              "Content-Transfer-Encoding: base64\n\n" .
              "--{$mime_boundary}--\n";


	$send=mail($to,$subject,$message,$headers);
	if ($send) {
		showmsg('mailsent');
	} else {
		showmsg('mailnotsent');
	}
}

footer();

?>