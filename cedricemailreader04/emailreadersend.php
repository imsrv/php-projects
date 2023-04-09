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

?>
<html>
<head>
    <title><? $cer_title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <LINK href="style/style.css" rel=stylesheet>
</head>

<body bgcolor="#A9A9A9">

<?
$message = '';

// Send mail
if ($destinataire !=""){ // we want to send something
  if (!eregi("@",$destinataire)) {
    $message = $cer_error_invalid_email." ($destinataire)";
  } else {
    $destinataire=trim($destinataire); 
    $sujet=stripslashes(trim($sujet));
    $mailheaders  = "From: $from\r\n";
    $mailheaders .= "Reply-To: $from\r\n";
    if ($cc != ""){$mailheaders .= "Cc: $cc\r\n";};
    if ($cci != ""){$mailheaders .= "Bcc: $cci\r\n";};
    $mailheaders .= "Error-to: webmail@isoca.com\r\n";
    $mailheaders .= "X-Mailer: Cedric Webmail with PHP at www.isoca.com\r\n";
    $msg_body = stripslashes($body);
    if ($attach != "none"){
    $temp_file_name = "tmp-php/".$attach_name;
    if(move_uploaded_file($attach, $temp_file_name)){
        if($file = fopen($temp_file_name, "r")){
            $contents = fread($file, filesize($temp_file_name));
            $encoded_attach = chunk_split(base64_encode($contents));
            fclose($file);
        } else {
            $message = $cer_error_attachment." ($temp_file_name).";
            $encoded_attach = "";
        };
        unlink($temp_file_name);
        
        $mailheaders .= "MIME-version: 1.0\n";
        $mailheaders .= "Content-type: multipart/mixed; ";
        $mailheaders .= "boundary=\"Message-Boundary\"\n";
        $mailheaders .= "Content-transfer-encoding: 7BIT\n";
        $mailheaders .= "X-attachments: $attach_name";

        $body_top = "--Message-Boundary\n";
        $body_top .= "Content-type: text/plain; charset=US-ASCII\n";
        $body_top .= "Content-transfer-encoding: 7BIT\n";
        $body_top .= "Content-description: Mail message body\n\n";

        $msg_body = $body_top . $msg_body;
        $msg_body .= "\n\n--Message-Boundary\n";
        $msg_body .= "Content-type: $attach_type; name=\"$attach_name\"\n";		
        $msg_body .= "Content-Transfer-Encoding: BASE64\n";
        $msg_body .= "Content-disposition: attachment; filename=\"$attach_name\"\n\n";
        $msg_body .= "$encoded_attach\n";
        $msg_body .= "--Message-Boundary--\n";
    } else { // erreur upload
        $message = "$cer_error_upload<br>\n";
    };
    };

    mail($destinataire, $sujet, $msg_body, $mailheaders);
    print("$message<br>\r\n$cer_send_msg_from <b>$from</b> $cer_send_sended <b>$destinataire</b>");
    
  };
};

?>

<form>
<input type="button" name="close" value="<? print($cer_send_button_close); ?>" onClick="self.close()"></td>
</form>
<br>
</body>
</html>