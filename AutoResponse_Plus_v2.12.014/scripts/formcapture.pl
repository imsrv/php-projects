#!/usr/bin/perl

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

eval {
    ($0 =~ m,(.*)/[^/]+,)   && unshift (@INC, "$1");
    ($0 =~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1");
 
    require "arp-paths.pl";
    require "arp-settings.pl";
    require "arp-library.pl";
    require "arp-data.pl";
    require "arp-mail.pl";
    require "arp-validate.pl";
}; # eval

%g_settings = &data_Load("SET00000000");

&ReadInput;

if (! %FORM) {
    &ExitPage("F01", "");
} # if

my($first_name) = &Trim($FORM{"first_name"});
my($last_name) = &Trim($FORM{"last_name"});
my($email) = &Trim(lc($FORM{"email"}));
my($format) = &Trim($FORM{"format"});
my($tracking_tag) = &Trim($FORM{"tracking_tag"});
my($id) = &Trim($FORM{"id"});
my($id_2) = &Trim($FORM{"ar_2"});
my($id_3) = &Trim($FORM{"ar_3"});

if (! $email) {
    &ExitPage("F02", $tracking_tag);
} # if

if (! &IsValidEmailAddress($email)) {
    &ExitPage("F03", $tracking_tag);
} # if

if (&IsBannedAddress($email)) {
    &ExitPage("F10", $tracking_tag);
} # exit

if (&IsBannedDomain($email)) {
    &ExitPage("F11", $tracking_tag);
} # exit

if (&IsListensOnAddress($email)) {
    &ExitPage("F04", $tracking_tag);
} # if

if (! &IsValidAutoresponderID($id)) {
    &ExitPage("F05", $tracking_tag);
} # if
else {
    my(%ar) = &data_Load($id);
    if ($ar{"form_control"} ne "1") {
        &ExitPage("F06", $tracking_tag);
    } # if

    if ($ar{"status"} ne "A") {
        &ExitPage("F07", $tracking_tag);
    } # if

    %campaign = &data_New("CAM");
    $campaign{"autoresponder_id"} = $id;
    $campaign{"email"} = $email;
    $campaign{"first_name"} = $first_name;
    $campaign{"last_name"} = $last_name;
    $campaign{"tracking_tag"} = $tracking_tag;
    $campaign{"source"} = "F";
    $subject = lc(&Trim($subject));
    if (uc($format) eq "H") {
        $campaign{"format_preference"} = "H";
    } # if
    elsif (uc($format) eq "T") {
        $campaign{"format_preference"} = "T";
    } # elsif

    if (&data_Save(%campaign)) {
        if (&ProcessImmediateMessage($campaign{"id"})) {
            if ((! $id_2) and (! $id_3)) {
                &ExitPage("S01", $tracking_tag);
            } # if
        } # if
        else {
            &data_Delete($campaign{"id"});
            &ExitPage("F09", $tracking_tag);
        } # else
    } # if
    else {
        &ExitPage("F08", $tracking_tag);
    } # else
} # else

if ($id_2) {
    if (! &IsValidAutoresponderID($id_2)) {
        &ExitPage("F05", $tracking_tag);
    } # if
    else {
        my(%ar) = &data_Load($id_2);
        if ($ar{"form_control"} ne "1") {
            &ExitPage("F06", $tracking_tag);
        } # if

        if ($ar{"status"} ne "A") {
            &ExitPage("F07", $tracking_tag);
        } # if

        %campaign = &data_New("CAM");
        $campaign{"autoresponder_id"} = $id_2;
        $campaign{"email"} = $email;
        $campaign{"first_name"} = $first_name;
        $campaign{"last_name"} = $last_name;
        $campaign{"tracking_tag"} = $tracking_tag;
        $campaign{"source"} = "F";
        $subject = lc(&Trim($subject));
        if (uc($format) eq "H") {
            $campaign{"format_preference"} = "H";
        } # if
        elsif (uc($format) eq "T") {
            $campaign{"format_preference"} = "T";
        } # elsif

        if (&data_Save(%campaign)) {
            if (&ProcessImmediateMessage($campaign{"id"})) {
            if (! $id_3) {
                &ExitPage("S01", $tracking_tag);
            } # if
            } # if
            else {
                &data_Delete($campaign{"id"});
                &ExitPage("F09", $tracking_tag);
            } # else
        } # if
        else {
            &ExitPage("F08", $tracking_tag);
        } # else
    } # else
} # if

if ($id_3) {
    if (! &IsValidAutoresponderID($id_3)) {
        &ExitPage("F05", $tracking_tag);
    } # if
    else {
        my(%ar) = &data_Load($id_3);
        if ($ar{"form_control"} ne "1") {
            &ExitPage("F06", $tracking_tag);
        } # if

        if ($ar{"status"} ne "A") {
            &ExitPage("F07", $tracking_tag);
        } # if

        %campaign = &data_New("CAM");
        $campaign{"autoresponder_id"} = $id_3;
        $campaign{"email"} = $email;
        $campaign{"first_name"} = $first_name;
        $campaign{"last_name"} = $last_name;
        $campaign{"tracking_tag"} = $tracking_tag;
        $campaign{"source"} = "F";
        $subject = lc(&Trim($subject));
        if (uc($format) eq "H") {
            $campaign{"format_preference"} = "H";
        } # if
        elsif (uc($format) eq "T") {
            $campaign{"format_preference"} = "T";
        } # elsif

        if (&data_Save(%campaign)) {
            if (&ProcessImmediateMessage($campaign{"id"})) {
                &ExitPage("S01", $tracking_tag);
            } # if
            else {
                &data_Delete($campaign{"id"});
                &ExitPage("F09", $tracking_tag);
            } # else
        } # if
        else {
            &ExitPage("F08", $tracking_tag);
        } # else
    } # else
} # if

exit;

sub IsValidAutoresponderID {
    my($arid) = @_;
    my($result) = 0;

    dbmopen(%db_aut, "$_data_path/AUT", undef);
    if ($g_settings{'file_locking'}) {flock(db_aut, 2)}
    my(@keys) = keys(%db_aut);

    if (! @keys) {
        dbmclose(%db_aut);
        if ($g_settings{'file_locking'}) {flock(db_aut, 8)}
        return $result;
    } # if

    my($fileline) = $db_aut{$arid};
    if ($fileline) {
        $result = 1;
    } # if

    dbmclose(%db_aut);
    if ($g_settings{'file_locking'}) {flock(db_aut, 8)}

    return $result;
} # sub IsValidAutoresponderID;

sub ExitPage {
    my($error, $tt) = @_;

    if (substr($error,0,1) eq "S") {
        $type = "success";

        $suc_page = &GetSubscribePage($tt, "success");
        if ($suc_page) {
            &Redirect ($suc_page);
        } # if
        elsif ($g_settings{'subscribe_success'}) {
            &Redirect ($g_settings{'subscribe_success'});
        } # elsif
    } # if
    elsif (substr($error,0,1) eq "F") {
        $type = "failure";

        $fal_page = &GetSubscribePage($tt, "failure");
        if ($fal_page) {
            &Redirect ($fal_page);
        } # if
        elsif ($g_settings{'subscribe_failure'}) {
            &Redirect ($g_settings{'subscribe_failure'});
        } # elsif
    } # elsif
    else {
        $type = "failure";
    } # else

    %profile = &data_Load("OWN00000000");

    my($support) = "If you would like further help, please contact our <a href='mailto:$g_settings{'support_email'}'>support department</a>.";
    my($back) = "Click the <strong>Back</strong> button on your browser to return to the page you came from.";
    my($thanks) = "Thank you for subscribing to our autoresponder.";
    my($sorry) = "Sorry, we could not process your subscription request.";
    my($apologies) = "Apologies for the inconvenience.";

    my($message);
    if ($error eq "F01") {
        $message = "$sorry <p>There is no form data to process.<p>$back";
    } # if
    elsif ($error eq "F02") {
        $message = "$sorry <p>You need to enter your e-mail address.<p>$back";
    } # elsif
    elsif ($error eq "F03") {
        $message = "$sorry <p>The e-mail address you entered is not valid.<p>$back";
    } # elsif
    elsif ($error eq "F04") {
        $message = "$sorry <p>The e-mail address you entered is not allowed.<p>$back";
    } # elsif
    elsif ($error eq "F05") {
        $message = "$sorry <p>The autoresponder you requested is no longer available.<p>$back";
    } # elsif
    elsif ($error eq "F06") {
        $message = "$sorry <p>This autoresponder cannot be requested through a web page form.<p>$back";
    } # elsif
    elsif ($error eq "F07") {
        $message = "$sorry <p>This autoresponder is not currently active.<p>$back";
    } # elsif
    elsif ($error eq "F08") {
        $message = "$sorry <p>Your details could not be saved in our database.<p>$support<p>$apologies";
    } # elsif
    elsif ($error eq "F09") {
        $message = "$sorry <p>We were unable to send you the first message from this autoresponder. It may have been suspended by the owner.<p>$support<p>$apologies";
    } # elsif
    elsif ($error eq "F10") {
        $message = "$sorry <p>You cannot subscribe to this autoresponder from this e-mail address.<p>$support<p>$apologies";
    } # elsif
    elsif ($error eq "F11") {
        $message = "$sorry <p>You cannot subscribe to this autoresponder from this server.<p>$support<p>$apologies";
    } # elsif
    elsif ($error eq "S01") {
        $message = "$thanks<p>$back";
    } # elsif
    else {
        $message = "$sorry <p>An unknown error has occurred. <p>$support";
    } # else

    print "Content-type: text/html\n\n";
    print '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
    print "<html>\n";
    print "<head>\n";
    print "<meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>\n";
    print "<title>\n";
    print "Autoresponse Plus: Smart Autoresponder System\n";
    print "</title>\n";
    print "</head>\n";
    print "<body>\n";
    print "<p><font face='Verdana,Arial,Helvetica' size='2'>$message</font>\n";
    print "</body>\n";
    print "</html>\n";

    exit;
} # sub ExitPage

# Message Codes
# F01: %FORM is undefined
# F02: e-mail address is blank
# F03: e-mail address is not valid
# F04: e-mail address is a listens on address
# F05: form does not contain a valid AR id
# F06: form control not allowed
# F08: could not save campaign
# F07: autoresponder is not active
# F09: failure processing immediate message
# F10: e-mail address is on banned list
# F11: server is on the banned list

# S01: successful subscription