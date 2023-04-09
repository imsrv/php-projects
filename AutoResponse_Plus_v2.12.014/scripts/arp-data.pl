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

# BAS = Base
# AUT = Autoresponder
# MES = Message
# CAM = Campaign
# TRA = Tracking tag
# OWN = Owner
# SET = System settings

sub data_New {
    my($data_type) = @_;
    my(%result);

    if (! &data_ValidDataType($data_type)) {
        return %result;
    } # if

    $result{"id"} = &data_GetID;
    $result{"parent_id"} = "";
    $result{"data_type"} = "BAS";
    $result{"date_created"} = time;
    $result{"date_modified"} = "";
    $result{"comment"} = "";

    if (! %result) {
        return %result;
    } # nothing to process

    if ($data_type eq "AUT") {
        $result{"id"} = "AUT" . $result{"id"};
        $result{"data_type"} = "AUT";
        $result{"listens_on"} = "";
        $result{"description"} = "";
        $result{"reply_name"} = "";
        $result{"reply_email"} = "";
        $result{"unsubscribe_link"} = "1";
        $result{"affiliate_link"} = "1";
        $result{"header_file_id"} = &data_GetID;
        $result{"header_file_id"} = "FIL" . $result{"header_file_id"};
        $result{"html_header_file_id"} = &data_GetID;
        $result{"html_header_file_id"} = "FIL" . $result{"html_header_file_id"};
        $result{"footer_file_id"} = &data_GetID;
        $result{"footer_file_id"} = "FIL" . $result{"footer_file_id"};
        $result{"html_footer_file_id"} = &data_GetID;
        $result{"html_footer_file_id"} = "FIL" . $result{"html_footer_file_id"};
        $result{"email_control"} = "1";
        $result{"form_control"} = "1";
        $result{"status"} = "A";
        $result{"message_order"} = "";
        $result{"immediate_message_id"} = "";
    } # AUT
    elsif ($data_type eq "OWN") {
        $result{"id"} = "OWN" . $result{"id"};
        $result{"data_type"} = "OWN";
        $result{"name"} = "";
        $result{"password"} = "";
        $result{"email"} = "";
        $result{"affiliate_nickname"} = "";
        $result{"last_login"} = "";
        $result{"my_title"} = "";
        $result{"my_firstname"} = "";
        $result{"my_lastname"} = "";
        $result{"my_fullname"} = "";
        $result{"my_position"} = "";
        $result{"my_company"} = "";
        $result{"my_address1"} = "";
        $result{"my_address2"} = "";
        $result{"my_address3"} = "";
        $result{"my_address4"} = "";
        $result{"my_address5"} = "";
        $result{"my_phone1"} = "";
        $result{"my_phone2"} = "";
        $result{"my_fax1"} = "";
        $result{"my_fax2"} = "";
        $result{"my_email1"} = "";
        $result{"my_email2"} = "";
        $result{"my_email3"} = "";
        $result{"my_email4"} = "";
        $result{"my_email5"} = "";
        $result{"my_web1"} = "";
        $result{"my_web2"} = "";
        $result{"my_web3"} = "";
        $result{"my_web4"} = "";
        $result{"my_web5"} = "";
        $result{"my_misc1"} = "";
        $result{"my_misc2"} = "";
        $result{"my_misc3"} = "";
        $result{"my_misc4"} = "";
        $result{"my_misc5"} = "";
    } # OWN
    elsif ($data_type eq "TRA") {
        $result{"id"} = "TRA" . $result{"id"};
        $result{"data_type"} = "TRA";
        $result{"tag"} = "";
        $result{"description"} = "";
        $result{"subscribe_success"} = "";
        $result{"subscribe_failure"} = "";
        $result{"unsubscribe_success"} = "";
        $result{"unsubscribe_failure"} = "";
    } # TRA
    elsif ($data_type eq "SET") {
        $result{"id"} = "SET" . $result{"id"};
        $result{"data_type"} = "SET";
        $result{"file_locking"} = "";
        $result{"cookie_life"} = "365";
        $result{"mail_failures"} = "3";
        $result{"your_domain"} = "";
        $result{"cgi_arplus_url"} = "";
        $result{"support_email"} = "";
        $result{"subscribe_success"} = "";
        $result{"subscribe_failure"} = "";
        $result{"unsubscribe_success"} = "";
        $result{"unsubscribe_failure"} = "";
        $result{"affiliate_text"} = "";
        $result{"send_unconf"} = "";
        $result{"unsubscribe_text"} = "";
        $result{"force_default_personalisation"} = "";
        $result{"system_email"} = "";
        $result{"max_list"} = 50;
        $result{"sendmail"} = "";
        $result{"tooltips"} = "";
        $result{"show_news"} = "1";
        $result{"spam_message"} = "";
    } # SET
    elsif ($data_type eq "MES") {
        $result{"id"} = "MES" . $result{"id"};
        $result{"data_type"} = "MES";
        $result{"subject"} = "Put the subject here";
        $result{"interval"} = "1";
        $result{"plain_file_id"} = &data_GetID;
        $result{"plain_file_id"} = "FIL" . $result{"plain_file_id"};
        $result{"html_file_id"} = &data_GetID;
        $result{"html_file_id"} = "FIL" . $result{"html_file_id"};
        $result{"use_header"} = "";
        $result{"use_footer"} = "";
        $result{"default_format"} = "";
        $result{"attachments"} = "";
        $result{"schedule"} = "INT";
    } # MES
    elsif ($data_type eq "CAM") {
        $result{"id"} = "CAM" . $result{"id"};
        $result{"data_type"} = "CAM";
        $result{"pin"} = time;
        $result{"autoresponder_id"} = "";
        $result{"last_message"} = "0";
        $result{"last_date"} = "";
        $result{"status"} = "A";
        $result{"subscribe_date"} = $result{"date_created"};
        $result{"source"} = "";
        $result{"format_preference"} = "D";
        $result{"tracking_tag"} = "";
        $result{"failures"} = 0;
    } # CAM

    return %result;
} # sub data_New

sub data_Save {
    my(%record) = @_;
    my($result) = 0;
    my($filename) = "$_data_path/" . $record{"data_type"};
    $record{"date_modified"} = time;
    my($fileline) = &data_GetFileLine(%record);

    my(%db);
    dbmopen(%db, $filename, 0666);
    if ($g_settings{"file_locking"}) {flock(db, 2)}
    $db{$record{"id"}} = $fileline;
    dbmclose(%db);
    if ($g_settings{"file_locking"}) {flock(db, 8)}

    $result = 1;
    return $result;
} # sub data_Save

sub data_Delete {
    my($id) = @_;
    my($result) = 0;
    my($filename) = "$_data_path/" . substr($id, 0, 3);

    my(%db);
    dbmopen(%db, $filename, 0666);
    if ($g_settings{"file_locking"}) {flock(db, 2)}
    delete($db{$id});
    dbmclose(%db);
    if ($g_settings{"file_locking"}) {flock(db, 8)}

    $result = 1;
    return $result;
} # sub data_Delete

sub data_Load {
    my($id) = @_;
    my(%result);
    my($filename) = "$_data_path/" . substr($id, 0, 3);

    my(%db);
    dbmopen(%db, $filename, undef);
    if ($g_settings{"file_locking"}) {flock(db, 2)}
    my($fileline) = $db{$id};
    dbmclose(%db);
    if ($g_settings{"file_locking"}) {flock(db, 8)}

    if ($fileline) {
        %result = &data_GetRecord($fileline);
    } # if

    return %result;
} # sub data_Load

sub data_GetFileLine {
    my(%record) = @_;
    my($result, $thiskey);

    if (! %record) {
        return $result;
    } # if

    my(@keylist) = keys(%record);

    foreach $thiskey (@keylist) {
        $result .= $thiskey . ":##:" . $record{$thiskey} . "\t";
    } # foreach
    
    return $result;  
} # sub data_GetFileLine

sub data_GetRecord {
    my($linein) = @_;
    my($pair, $name, $value, %result);
    my(@pairs) = split(/\t/, $linein);

    if ($linein eq "") {
        return %result;
    } # no line

    foreach $pair (@pairs) {
        ($name, $value) = split(/:##:/, $pair);
        $result{$name} = $value;
    } # foreach

    return %result;
} # sub data_GetRecord

sub data_GetID {
    my($result);

    if (! -e "$_data_path/serial.txt") {
        open (FILE, ">$_data_path/serial.txt");
        if ($g_settings{"file_locking"}) {flock(FILE, 2)}
        print FILE "0";
        close FILE;
        if ($g_settings{"file_locking"}) {flock(FILE, 8)}
    } # if

    open (FILE, "<$_data_path/serial.txt") or die;
    if ($g_settings{"file_locking"}) {flock(FILE, 2)}
    my(@file) = <FILE>;
    close FILE;
    if ($g_settings{"file_locking"}) {flock(FILE, 8)}
    $result = $file[0];
    $result++;
    open (FILE, ">$_data_path/serial.txt") or die;
    if ($g_settings{"file_locking"}) {flock(FILE, 2)}
    print FILE $result;
    close FILE;
    if ($g_settings{"file_locking"}) {flock(FILE, 8)}

    while (length($result) < 8) {
        $result = "0" . $result;
    } # while

    return $result;
} # sub data_GetID

sub data_ValidDataType {
    my($data_type) = @_;
    my($result) = 0;

    if ($data_type eq "AUT") {
        $result = 1;
    } # if
    elsif ($data_type eq "OWN") {
        $result = 1;
    } # elsif
    elsif ($data_type eq "TRA") {
        $result = 1;
    } # elsif
    elsif ($data_type eq "SET") {
        $result = 1;
    } # elsif
    elsif ($data_type eq "MES") {
        $result = 1;
    } # elsif
    elsif ($data_type eq "CAM") {
        $result = 1;
    } # elsif

    return $result;
} # sub data_ValidDataType

return 1;
