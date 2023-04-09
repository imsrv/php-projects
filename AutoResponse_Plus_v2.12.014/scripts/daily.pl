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
}; # eval

my($sessionid) = &RandomValue("0123456789", 8);
%g_settings = &data_Load("SET00000000");

print "Content-type: text/html\n\n";
print "<HTML>\n";
print "<HEAD>\n";
print "<TITLE>Autoresponse Plus</TITLE>\n";
print "</HEAD>\n";
print "<BODY>\n";
print "<p><b>Autoresponse Plus Version $_version</b></p>\n";
print "<p>Step 1 of 3: Processing current follow-up sequences. <font color='#FF0000'>Do not interrupt.</font></p>\n";

dbmopen(%db_cam, "$_data_path/CAM", 0666);
if ($g_settings{'file_locking'}) {flock(db_cam, 2)}
my(@keys) = keys(%db_cam);

if (! @keys) {
    dbmclose(%db_cam);
    if ($g_settings{'file_locking'}) {flock(db_cam, 8)}
} # if

dbmopen(%db_aut, "$_data_path/AUT", undef);
if ($g_settings{'file_locking'}) {flock(db_aut, 2)}
dbmopen(%db_mes, "$_data_path/MES", undef);
if ($g_settings{'file_locking'}) {flock(db_mes, 2)}

my ($key, $fileline, %thiscam);
my(%thisar, %thismes);
my($last_message, $next_message, @message_keys);
my($last_date_secs);
foreach $key (@keys) {
    $fileline = $db_cam{$key};
    %thiscam = &data_GetRecord($fileline);

    if (! %thiscam) {
        next;
    } # if

    if ($thiscam{"status"} ne "A") {
        next;
    } # if

    %thisar = &data_GetRecord($db_aut{$thiscam{"autoresponder_id"}});

    if (! %thisar) {
        next;
    } # if

    if ($thisar{"status"} eq "S") {
        next;
    } # if

    @message_keys = split(/\|/, $thisar{"message_order"});
    shift(@message_keys);

    $last_message = $thiscam{"last_message"};
    $next_message = $last_message + 1;
    if ($next_message > ($#message_keys+1)) {
        $thiscam{"status"} = "F";
        $db_cam{$key} = &data_GetFileLine(%thiscam);
        next;
    } # if

    %thismes = &data_GetRecord($db_mes{$message_keys[$next_message-1]});
    if (! %thismes) {
        next;
    } # if

    my($sec, $min, $hour, $dayofmonth, $mon, $year, $weekday, $dayofyear, $IsDST) = localtime(time);

    if (! $thiscam{"last_date"}) {
        $last_date_secs = $thiscam{"date_created"};
    } # if
    else {
        $last_date_secs = $thiscam{"last_date"};
    } # else

    $oktosend = 0;
    if ($last_message == 0) {
        $oktosend = 1;
    } # if
    elsif ($thismes{"schedule"} eq "NEX") {
        $oktosend = 1;
    } # elsif
    elsif ($thismes{"schedule"} eq "INT") {
        if ((time - $last_date_secs) >= ($thismes{"interval"} * 86400)) {
            $oktosend = 1;
        } # if
    } # elsif
    elsif ($thismes{"schedule"} eq $weekday) {
        $oktosend = 1;
    } # elsif

    if ($oktosend) {
        open (FILE, ">>$_data_path/$sessionid.snd") or die;
        if ($g_settings{'file_locking'}) {flock(FILE, 2)}
        print FILE "$thiscam{'id'}\t$thismes{'id'}\n";
        close FILE;
        if ($g_settings{'file_locking'}) {flock(FILE, 8)}
        $thiscam{"last_message"} = $next_message;
        $thiscam{"last_date"} = time;
        $db_cam{$key} = &data_GetFileLine(%thiscam);
     } # if
} # foreach

dbmclose(%db_aut);
if ($g_settings{'file_locking'}) {flock(db_aut, 8)}
dbmclose(%db_cam);
if ($g_settings{'file_locking'}) {flock(db_cam, 8)}
dbmclose(%db_mes);
if ($g_settings{'file_locking'}) {flock(db_mes, 8)}

print "<p>Step 1 of 3: Finished processing current follow-up sequences.</p>\n";

print "<p>Step 2 of 3: Processing session e-mail queue. <font color='#FF0000'>Do not interrupt.</font></p>\n";
if (-e "$_data_path/$sessionid.snd") {
    open (FILE, "<$_data_path/$sessionid.snd") or die;
    if ($g_settings{'file_locking'}) {flock(FILE, 2)}
    my(@queue) = <FILE>;
    my($job, $cid, $mid);
    foreach $job (@queue) {
        chomp($job);
        ($cid, $mid) = split(/\t/, $job);
        if (($cid) and ($mid)) {
            &SendMessage($cid, $mid)
        } # if
    } # foreach
    close FILE;
    if ($g_settings{'file_locking'}) {flock(FILE, 8)}
    unlink ("$_data_path/$sessionid.snd");
} # if
print "<p>Step 2 of 3: Finished processing session e-mail queue.</p>\n";

print "<p>Step 3 of 3: Processing one-off e-mail queue. <font color='#FF0000'>Do not interrupt.</font></p>\n";
if (-e "$_data_path/mail.queue") {
    open (FILE, "<$_data_path/mail.queue") or die;
    if ($g_settings{'file_locking'}) {flock(FILE, 2)}
    my(@queue) = <FILE>;
    close FILE;
    if ($g_settings{'file_locking'}) {flock(FILE, 8)}
    unlink ("$_data_path/mail.queue");

    @remaining = ();

    my($sec, $min, $hour, $dayofmonth, $mon, $year, $weekday, $dayofyear, $IsDST) = localtime(time);

    foreach $line (@queue) {
        chomp($line);
        ($job, $schedule) = split(/\|/, $line);

        $oktosend = 0;
        if ($schedule eq "NEX") {
            $oktosend = 1;
        } # if
        elsif ($schedule eq $weekday) {
            $oktosend = 1;
        } # elsif

        if ($oktosend) {
            open (FILE, "<$_data_path/$job.queue") or die;
            if ($g_settings{'file_locking'}) {flock(FILE, 2)}
            my(@list) = <FILE>;
            close FILE;
            if ($g_settings{'file_locking'}) {flock(FILE, 8)}

            foreach $subscriber (@list) {
                chomp($subscriber);
                ($cam_id, $from_name, $from_email, $subject, $file_root, $def_pref) = split(/\t/, $subscriber);
                $plain_body = &LoadText("$_data_path/$job.pln");
                $html_body = &LoadText("$_data_path/$job.htm");
                &SendDirectMessage($cam_id, $from_name, $from_email, $subject, $plain_body, $html_body, $def_pref);
            } # foreach
            unlink ("$_data_path/$job.pln");
            unlink ("$_data_path/$job.htm");
            unlink ("$_data_path/$job.queue");
        } # if
        else {
            push(@remaining, $line);
        } # else
    } # foreach

    if (@remaining) {
        open (FILE, ">$_data_path/mail.queue") or die;
        if ($g_settings{'file_locking'}) {flock(FILE, 2)}

        foreach $line (@remaining) {
            print FILE "$line\n";
        } # foreach

        close FILE;
        if ($g_settings{'file_locking'}) {flock(FILE, 8)}
    } # if
} # if
print "<p>Step 3 of 3: Finished processing one-off e-mail queue.</p>\n";
print "<p>Processing complete. You can now close your browser.</p>\n";
print "</BODY>\n";
print "</HTML>\n";

exit;
