##################################################
##                                              ##
##             AUTORESPONSE PLUS (tm)           ##
##       Sequential Autoresponder System        ##
##                Version 2.12                  ##
##                                              ##
##   Copyright Gobots Internet Solutions, 2001  ##
##             All rights reserved              ##
##                                              ##
##  For support and latest product information  ##
##    visit http://www.autoresponseplus.com.    ##
##                                              ##
##  Use of AutoResponse Plus is subject to our  ##
##   license agreement and limited warranty.    ##
##  See the file license.txt for more details.  ##
##                                              ##
##################################################

sub ProcessImmediateMessage {
    my($cid) = @_;
    my(%campaign) = &data_Load($cid);
    my(%ar) = &data_Load($campaign{"autoresponder_id"});
    my($result) = 0;

    if ($ar{"immediate_message_id"}) {
        if (&SendMessage($cid, $ar{"immediate_message_id"})) {
            $campaign{"last_message"} = "1";
            $campaign{"last_date"} = time;
            &data_Save(%campaign);
            $result = 1;
        } # if
    } # if

    return $result;
} # sub ProcessImmediateMessage

sub SendMessage {
    my($cid, $mid) = @_;
    my($result);

    if ((! $cid) or (! $mid)) {
        return $result;
    } # if

    my(%profile) = &data_Load("OWN00000000");

    my(%campaign) = &data_Load($cid);
    if (! %campaign) {
        return $result;
    } # if

    my(%ar) = &data_Load($campaign{"autoresponder_id"});
    if (! %ar) {
        return $result;
    } # if

    my(%message) = &data_Load($mid);
    if (! %message) {
        return $result;
    } # if

    if ($campaign{"status"} ne "A") {
        return $result;
    } # if

    if ($ar{"status"} eq "S") {
        return $result;
    } # if

    my($mime_from, $mime_to, $mime_subject, $mime_format, $mime_body);

    if (! $ar{'reply_name'}) {
        $mime_from = $ar{'reply_email'};
    } # if
    else {
        $mime_from = "\"$ar{'reply_name'}\"   <$ar{'reply_email'}>";
    } # else

    $mime_to = &Trim(&Trim($campaign{"first_name"}) . " " . &Trim($campaign{"last_name"}));
    if (! $mime_to) {
        $mime_to = &Trim($campaign{"full_name"});
    } # if

    if (! $mime_to) {
        $mime_to = $campaign{'email'};
    } # if
    else {
        $mime_to = "\"$mime_to\"   <$campaign{'email'}>\n";
    } # else

    $mime_subject = &ReplaceTags($message{'subject'}, $campaign{"id"}, $ar{"id"});

    my($format);
    if ($campaign{"format_preference"} eq "H") {
        $format = "H";
    } # if
    elsif ($campaign{"format_preference"} eq "T") {
        $format = "T";
    } # elsif
    else {
        $format = $message{"default_format"};
    } # else

    if ($format eq "H") {
        $mime_format = "text/html";
    } # if
    else {
        $mime_format = "text/plain";
    } # else

    if ($mime_format eq "text/html") {
        $mime_body = &LoadText("$_data_path/$message{'html_file_id'}.mes");
    } # if
    else {
        $mime_body = &LoadText("$_data_path/$message{'plain_file_id'}.mes");
        $mime_body .= "\n\n";
    } # else

    if ($message{"use_header"}) {
        if ($mime_format eq "text/html") {
            $mime_body = &Trim(&LoadText("$_data_path/$ar{'html_header_file_id'}.hed")) . $mime_body;
        } # if
        else {
            $mime_body = &Trim(&LoadText("$_data_path/$ar{'header_file_id'}.hed")) . "\n\n" . $mime_body;
        } # else
    } # if

    if ($message{"use_footer"}) {
        if ($mime_format eq "text/html") {
            $mime_body .= &Trim(&LoadText("$_data_path/$ar{'html_footer_file_id'}.foo"));
        } # if
        else {
            $mime_body .= &Trim(&LoadText("$_data_path/$ar{'footer_file_id'}.foo")) . "\n\n";
        } # else
    } # if

    if ($ar{"unsubscribe_link"}) {
        my($un_cid) = substr($campaign{"id"},3,8) + 0;
        my($un_pin) = substr($campaign{"pin"},5,4);
        if ($mime_format eq "text/html") {
            $mime_body .= "<p><font face='Arial,Helvetica' size='2'>$g_settings{'unsubscribe_text'}<br><a href='$g_settings{'cgi_arplus_url'}/un.pl?c=$un_cid&p=$un_pin' target='_blank'>Click here to unsubscribe</a></font></p>";
        } # if
        else {
            $mime_body .= "$g_settings{'unsubscribe_text'}\n";
            $mime_body .= "$g_settings{'cgi_arplus_url'}/un.pl?c=$un_cid&p=$un_pin\n\n";
        } # else
    } # if

    if ($ar{"affiliate_link"}) {
        if ($mime_format eq "text/html") {
            if ($profile{"affiliate_nickname"}) {
                $mime_body .= "<a href='http://www.autoresponseplus.com/link.php?a=$profile{'affiliate_nickname'}'><p><font face='Arial,Helvetica' size='1'>$g_settings{'affiliate_text'}</font></p></a>";
            } # if
            else {
                $mime_body .= "<a href='http://www.autoresponseplus.com'><p><font face='Arial,Helvetica' size='1'>$g_settings{'affiliate_text'}</font></p></a>";
            } # else
        } # if
        else {
            $mime_body .= "$g_settings{'affiliate_text'}\n";
            if ($profile{"affiliate_nickname"}) {
                $mime_body .= "http://www.autoresponseplus.com/link.php?a=$profile{'affiliate_nickname'}";
            } # if
            else {
                $mime_body .= "http://www.autoresponseplus.com";
            } # else
        } # else
    } # if

    $mime_body = &ReplaceTags($mime_body, $campaign{"id"}, $ar{"id"});

    use MIME::Lite;
    MIME::Lite->send("sendmail", "$g_settings{'sendmail'} -t -oi -oem");

    $msg = MIME::Lite->new(
           From    => $mime_from,
           To      => $mime_to,
           Subject => $mime_subject,
           Type    => $mime_format,
           Data    => $mime_body,
           "X-Loop:" => "AutoresponsePlus",
           "X-Arpidentifier:" => $campaign{"id"}
    ); # $msg

    if ($message{"attachments"}) {
        my(@attachments) = split(/ /, $message{"attachments"});
        if (@attachments) {
            foreach $this_att (@attachments) {
                $att_format = &GetMimeFormat($this_att);
                $filespec = "$_data_path/$this_att";
                if (-e $filespec) {
                    $msg->attach(Type => $att_format->[0],
                                 Encoding => $att_format->[1],
                                 Path => $filespec,
                                 Filename => $this_att
                    ); # $msg
                } # if
            } # foreach
        } # if
    } # if

    if ($msg->send) {
        $result = 1;
    } # if

    return $result;
} # END OF SUB SendMessage

sub SendDirectMessage {
    my($camid, $from_name, $from_email, $subject, $plain_message, $html_message, $default_preference) = @_;
    my($result);

    my(%cam_in) = &data_Load($camid);

    if (! %cam_in) {
        return $result;
    } # if

    $email = &Trim(lc($cam_in{'email'}));
    $from_name = &Trim($from_name);
    $from_email = &Trim(lc($from_email));
    $subject = &Trim($subject);
    $plain_message = &Trim($plain_message);
    $html_message = &Trim($html_message);

    if (! $email) {
        return $result;
        exit;
    } # if

    if (! IsValidEmailAddress($email)) {
        return $result;
        exit;
    } # if

    my($format);
    if ($cam_in{'format_preference'} eq "H") {
        $format = "H";
    } # if
    elsif ($cam_in{'format_preference'} eq "T") {
        $format = "T";
    } # elsif
    else {
        $format = $default_preference;
    } # else

    if ($format eq "H") {
        $mime_format = "text/html";
        $subject = &ReplaceTags($subject, $cam_in{'id'}, "NONE");
        $message = &ReplaceTags($html_message, $cam_in{'id'}, "NONE");
    } # if
    else {
        $mime_format = "text/plain";
        $subject = &ReplaceTags($subject, $cam_in{'id'}, "NONE");
        $message = &ReplaceTags($plain_message, $cam_in{'id'}, "NONE");
    } # else

    use MIME::Lite;
    MIME::Lite->send("sendmail", "$g_settings{'sendmail'} -t -oi -oem");

    if ($from_name) {
        $from_line = "\"$from_name\"     <$from_email>";
    } # if
    else {
        $from_line = $from_email;
    } # else

    $msg = MIME::Lite->new(
           From    => $from_line,
           To      => $email,
           Subject => $subject,
           Type    => $mime_format,
           Data    => $message,
           "X-Arpidentifier:" => "DIRECT $camid"
    ); # $msg

    if ($msg->send) {
        $result = 1;
    } # if

    return $result;
} # sub SendDirectMessage

sub GetMimeFormat {
    my($filename) = @_;
    $filename = &Trim(lc($filename));
    my($result);

    my %extensions = ( 
        gif      => ['image/GIF' , 'base64'],
        txt      => ['text/plain' , '8bit'],
        com      => ['text/plain' , '8bit'],
        doc      => ['application/msword', 'base64'],
        class    => ['application/octet-stream' , 'base64'],
        htm      => ['text/html' , '8bit'],
        html     => ['text/html' , '8bit'],
        htmlx    => ['text/html' , '8bit'],
        htx      => ['text/html' , '8bit'],
        jpg      => ['image/jpeg' , 'base64'],
        pdf      => ['application/pdf' , 'base64'],
        mpeg     => ['video/mpeg' , 'base64'],
        mov      => ['video/quicktime' , 'base64'],
        exe      => ['application/octet-stream' , 'base64'],
        zip      => ['application/zip' , 'base64'],
        au       => ['audio/basic' , 'base64'],
        mid      => ['audio/midi' , 'base64'],
        midi     => ['audio/midi' , 'base64'],
        wav      => ['audio/x-wav' , 'base64'],
        tar      => ['application/tar' , 'base64']
    ); # %extensions

    if ($filename =~ /.*\.(.+)$/) {
        $ext = $1;
    } # if

    if (exists($extensions{$ext})) {
        $result = $extensions{$ext};
    } # if
    else {
        $result = ['text/plain', '8bit'];
    } # else

    return $result;
} # sub GetMimeFormat

return 1;
