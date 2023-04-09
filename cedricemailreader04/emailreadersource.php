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

// Open message box
$mbox = open_mailbox($server, $username, $password);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><? $cer_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="style/style.css" rel=stylesheet>
</head>
<body text="#000000" leftmargin="10" topmargin="10" marginwidth="0" marginheight="0">
<?
print("<pre>\r\n");
print(htmlspecialchars(get_header($mbox,$msgid)));
print("\r\n<hr>\r\n");
print(splittext(htmlspecialchars(getrawmessagebody($mbox,$msgid))));
print("</pre>\r\n");

close_mailbox($mbox);

print("<p>\n<center>\n<form>");
print("<input type=\"button\" name=\"close\" value=\"$cer_send_button_close\" onClick=\"self.close()\"></td>\n</form>\n</center>");

?>
</body>
</html>
