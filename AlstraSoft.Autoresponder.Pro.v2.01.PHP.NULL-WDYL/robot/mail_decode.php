#!/usr/bin/php
<?php
/* Nullified by WDYL-WTN */
// read from stdin
$fd = fopen("php://stdin", "r");
$email = "";
while (!feof($fd)) {
    $email .= fread($fd, 1024);
}
fclose($fd);

// handle email
$lines = explode("\n", $email);

// empty vars
$from = "";
$subject = "";
$headers = "";
$message = "";
$splittingheaders = true;

for ($i=0; $i<count($lines); $i++) {
    if ($splittingheaders) {
        // this is a header
        $headers .= $lines[$i]."\n";

        // look out for special headers
        if (preg_match("/^Subject: (.*)/", $lines[$i], $matches)) {
            $subject = $matches[1];
        }
        if (preg_match("/^From: (.*)/", $lines[$i], $matches)) {
            $from = $matches[1];
        }
    } else {
        // not a header, but message
        $message .= $lines[$i]."\n";
    }

    if (trim($lines[$i])=="") {
        // empty line, header section has ended
        $splittingheaders = false;
    }
}

?>
