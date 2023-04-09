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
    require "arp-display.pl";
    require "arp-mail.pl";
}; # eval

%g_settings = &data_Load("SET00000000");

&ReadInput;
my($cid) = $INFO{"c"};
my($pin) = $INFO{"p"};

while (length($cid) < 8) {
    $cid = "0" . $cid;
} # while
$cid = "CAM" . $cid;

my(%campaign) = &data_Load($cid);

if (! %campaign) {
    &UnsubscribePage($campaign{'tracking_tag'}, "failure");
} # if

my(%ar) = &data_Load($campaign{"autoresponder_id"});

if (substr($campaign{"pin"},5,4) eq $pin) {
    $campaign{"status"} = "U";
    &data_Save(%campaign);
    if ($g_settings{"send_unconf"}) {
        &SendUnsubscribeConfirmation(%campaign);
    } # if
    &UnsubscribePage($campaign{'tracking_tag'}, "success");
} # if
else {
    &UnsubscribePage($campaign{'tracking_tag'}, "failure");
} # else

sub UnsubscribePage {
    my($tt, $type) = @_;

    if ($type eq "success") {
        $suc_page = &GetUnsubscribePage($tt, "success");
        if ($suc_page) {
            &Redirect ($suc_page);
        } # if
        elsif ($g_settings{'unsubscribe_success'}) {
            &Redirect ($g_settings{'unsubscribe_success'});
        } # elsif
    } # if
    elsif ($type eq "failure") {
        $fal_page = &GetUnsubscribePage($tt, "failure");
        if ($fal_page) {
            &Redirect ($fal_page);
        } # if
        elsif ($g_settings{'unsubscribe_failure'}) {
            &Redirect ($g_settings{'unsubscribe_failure'});
        } # elsif
    } # elsif

    if ($type eq "success") {
        $message = "<p>Thank you for using our autoresponder. You have been successfully unsubscribed and will not receive any more messages.</p>\n";
    } # if
    else {
        $message = "<p>Sorry, for some reason we could not automatically unsubscribe you from this autoresponder. You may already have been removed from the database.</p></font><p><font face='Verdana,Arial,Helvetica' size='2'>Please <a href='mailto:$g_settings{'support_email'}'>contact us</a> if you need any assistance.</font></p><p><font face='Verdana,Arial,Helvetica' size='2'>Sorry for the inconvenience.</p>\n";
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
    print "<font face='Verdana,Arial,Helvetica' size='2'>$message</font>\n";
    print "</body>\n";
    print "</html>\n";

    exit;
} # sub UnsubscribePage

sub SendUnsubscribeConfirmation {
    my(%cam) = @_;

    if (! %cam) {
        return;
    } # if

    $un_text = &LoadText("$_data_path/unsub.txt");

    SendDirectMessage($cam{'id'}, "", $g_settings{'system_email'}, "Unsubscription Confirmation", $un_text, $un_text, "T");

    return;
} # sub SendUnsubscribeConfirmation
