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

%g_settings = &data_Load("SET00000000");

@mail = <STDIN>;

if (! @mail) {
    exit;
} # if

my($line);
foreach $line (@mail) {
    if (($line =~ /Subject: /) and ($subject eq '')) {
        $subject = $line;
        chomp ($subject);
        $subject =~ s/Subject: //;
    } # if

    if (($line =~ /From: /) and ($from_both eq '')) {
        $from_both = $line;
        chomp ($from_both);
        $from_both =~ s/From: //;
    } # if

    if (($line =~ /To: /) and ($to_both eq '')) {
        $to_both = $line;
        chomp ($to_both);
        $to_both =~ s/To: //;
    } # if

    if (($line =~ /Reply-To: /) and ($reply_both eq '')) {
        $reply_both = $line;
        chomp ($reply_both);
        $reply_both =~ s/Reply-To: //;
    } # if

    if (($line =~ /X-Arpidentifier: /) and ($arpidentifier eq '')) {
        $arpidentifier = $line;
        chomp ($arpidentifier);
        $arpidentifier =~ s/X-Arpidentifier: //;
    } # if
} # foreach

if (($arpidentifier) and ($from_both =~ /MAILER-DAEMON/i)) {
    if ($arpidentifier =~ /DIRECT /) {
        $arpidentifier =~ s/DIRECT //;
        my(%cam) = &data_Load($arpidentifier);
        if (%cam) {
            $cam{"failures"} = $cam{"failures"} + 1;
            if ($cam{"failures"} > $g_settings{'mail_failures'}) {
                $cam{"status"} = "X";
            } # if
            &data_Save(%cam);
        } # if
    } # if
    else {
        my(%cam) = &data_Load($arpidentifier);
        if (%cam) {
            $cam{"failures"} = $cam{"failures"} + 1;
            if ($cam{"failures"} > $g_settings{'mail_failures'}) {
                $cam{"status"} = "X";
            } # if
            else {
                if ($cam{"last_message"} > 0) {
                    $cam{"last_message"} = $cam{"last_message"} - 1;
                } # if
            } # else
            &data_Save(%cam);
        } # if
    } # else

    exit;
} # if

$from_name = &ExtractName($from_both);
$from_email = &ExtractEmail($from_both);
$to_email = &ExtractEmail($to_both);
$to_email = &Trim($to_email);
$to_email = lc($to_email);
$reply_name = &ExtractName($reply_both);
$reply_email = &ExtractEmail($reply_both);
$reply_email = &Trim($reply_email);
$reply_email = lc($reply_email);

if ($to_email eq "arptest\@$g_settings{'your_domain'}") {
    %campaign = &data_New("CAM");
    $campaign{"full_name"} = "Test Only";
    $campaign{"email"} = "Test Only - Please Delete";
    $campaign{"autoresponder_id"} = "System Test";
    $campaign{"source"} = "E";
    &data_Save(%campaign);

    exit;
} # if

if ($to_email eq "arplus\@$g_settings{'your_domain'}") {
    $subject = &Trim($subject);

    %validowner = &data_Load("OWN00000000");

    if (lc($subject) =~ /owner=(\w+)/) {
        $ownerin = &Trim(lc($1));
        if (lc($subject) =~ /password=(\w+)/) {
            $passin = &Trim(lc($1));
            if (($ownerin eq &Trim(lc($validowner{"name"}))) and ($passin eq &Trim(lc($validowner{"password"})))) {
                if (lc($subject) =~ /action=(\w+)/) {
                    $action = &Trim(lc($1));
                } # if
                if (lc($subject) =~ /name=(\w+)/) {
                    $reply_name = &Trim($1);
                } # if
                if (lc($subject) =~ /email=([\w.\-@]+)/) {
                    $reply_email = &Trim(lc($1));
                } # if
                if (lc($subject) =~ /autoresponder=(\w+)/) {
                    $to_email = &Trim(lc("$1\@$g_settings{'your_domain'}"));
                } # if
                $subject = $action;
            } # if
            else {
                exit;
            } # else
        } # if
    } # if
} # if

if (! $reply_email) {
    $reply_name = $from_name;
    $reply_email = $from_email;
} # if

if (! $reply_email) {
    exit;
} # if

if (! &IsValidEmailAddress($reply_email)) {
    exit
} # if

if (&IsBannedAddress($reply_email)) {
    exit;
} # exit

if (&IsBannedDomain($reply_email)) {
    exit;
} # exit

if (&IsListensOnAddress($reply_email)) {
    exit;
} # exit

my($arid) = &GetAutoresponderID($to_email);
if (! $arid) {
    exit;
} # if
else {
    my(%ar) = &data_Load($arid);
    if ($ar{"email_control"} ne "1") {
        exit;
    } # if

    if ($ar{"status"} ne "A") {
        exit;
    } # if

    dbmopen(%db_cam, "$_data_path/CAM", undef);
    if ($g_settings{'file_locking'}) {flock(db_cam, 2)}
    my(@keys) = keys(%db_cam);
    my($key, $fileline, %thiscam);
    my($campaign_exists) = 0;
    foreach $key (@keys) {
        $fileline = $db_cam{$key};
        %thiscam = &data_GetRecord($fileline);
        if ((lc(&Trim($reply_email)) eq lc(&Trim($thiscam{"email"}))) and ($arid eq $thiscam{"autoresponder_id"})) {
            $campaign_exists = 1;
            last;
        } # if
        
    } # foreach
    dbmclose(%db_cam);
    if ($g_settings{'file_locking'}) {flock(db_cam, 8)}

    if ($campaign_exists) {
        if ($subject =~ /unsubscribe/) {
            $thiscam{"status"} = "U";
            &data_Save(%thiscam);
            if ($g_settings{"send_unconf"}) {
                &SendUnsubscribeConfirmation($thiscam{"email"});
            } # if
            exit;
        } # if
    } # if

    my($tracking_tag, $tt_subject);
    $tt_subject = Trim(lc($subject));
    if ($tt_subject =~ /tra(\w+)/) {
        $tracking_tag = $1;
    } # if

    %campaign = &data_New("CAM");
    $campaign{"full_name"} = $reply_name;
    $campaign{"email"} = $reply_email;
    $campaign{"autoresponder_id"} = $arid;
    $campaign{"source"} = "E";
    $campaign{"tracking_tag"} = $tracking_tag;
    $subject = lc(&Trim($subject));
    if ($subject =~ /html/) {
        $campaign{"format_preference"} = "H";
    } # if
    elsif ($subject =~ /plain/) {
        $campaign{"format_preference"} = "T";
    } # elsif

    if (&data_Save(%campaign)) {
        &ProcessImmediateMessage($campaign{"id"})
    } # if
    else {
        exit;
    } # else
} # else

exit;

sub ExtractEmail {
    my($line) = @_;
    my($result);
    my($em);

    if ($line =~ /([a-zA-Z_.-0-9]+\@{1}[a-zA-Z_.-0-9]+)/) {
        $em = $1;
    } # if

    $result = &Trim($em);

    return $result;
} # sub ExtractEmail

sub ExtractName {
    my($line) = @_;
    my($result) = @_;
    my($em);

    if ($line =~ /([a-zA-Z_.-0-9<]+\@{1}[a-zA-Z_.-0-9>]+)/) {
        $em = $1;
    } # if

    $line =~s/$em//g;
    $line =~s/\"//g;

    $result = &Trim($line);

    return $result;
} # sub ExtractName

sub GetAutoresponderID {
    my($listens_on) = @_;
    my($result);

    dbmopen(%db_aut, "$_data_path/AUT", undef);
    if ($g_settings{'file_locking'}) {flock(db_aut, 2)}
    my(@keys) = sort(keys(%db_aut));

    if (! @keys) {
        dbmclose(%db_aut);
        if ($g_settings{'file_locking'}) {flock(db_aut, 8)}
        return $result;
    } # if

    my($key, $fileline, %ar);
    foreach $key (@keys) {
        $fileline = $db_aut{$key};
        %ar = &data_GetRecord($fileline);
        my($thisonelistens) = lc($ar{'listens_on'} . "\@$g_settings{'your_domain'}");
        if ($thisonelistens eq lc($listens_on)) {
            $result = $ar{"id"};
            last;
        } # if
    } # foreach

    dbmclose(%db_aut);
    if ($g_settings{'file_locking'}) {flock(db_aut, 8)}

    return $result;
} # sub GetAutoresponderID;

