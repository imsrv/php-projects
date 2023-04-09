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

sub ReadInput {
    read(STDIN, $input, $ENV{"CONTENT_LENGTH"});
    my(@pairs) = split(/&/, $input);
    my($pair, $name, $value);
    foreach $pair (@pairs) {
        ($name, $value) = split(/=/, $pair);
        $name =~ tr/+/ /;
        $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
        $value =~ tr/+/ /;
        $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
        $value =~ s/<!--(.|\n)*-->//g;
        $FORM{$name} = $value;
    } # foreach

    my(@vars) = split(/&/, $ENV{QUERY_STRING});
    my($var, $v, $i);
    foreach $var (@vars) {
        ($v,$i) = split(/=/, $var);
        $v =~ tr/+/ /;
        $v =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
        $i =~ tr/+/ /;
        $i =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
        $i =~ s/<!--(.|\n)*-->//g;
        $INFO{$v} = $i;
    } # foreach
} # sub ReadInput

sub IsExplorer {
    my($agent) = @_;

    if ($agent =~ /MSIE/) {
        return 1;
    } # if
    else {
        return 0;
    } # else
} # sub IsExplorer

sub Redirect {
    my($location) = @_;

    print "Content-type: text/html\n\n";
    print "<html><head>\n";
    print "<meta http-equiv='refresh' content='0; url=$location'>\n";
    print "</head></html>";
    exit;
} # sub Redirect

sub ValidateOwner {
    my(%owner) = &data_Load("OWN00000000");
    my($result) = 0;
    my($sessionname) = &GetCookie("sessionname");
    my($sessionpassword) = &GetCookie("sessionpassword");

    if (($owner{"name"} eq $sessionname) and ($owner{"password"} eq $sessionpassword)) {
        $result = 1;
    } # if

    return $result;
} # sub ValidateOwner

sub Trim {
    my($in) = @_;

    my($out, $i, $first, $last);

    for ($i = 0; $i <= length($in)-1; $i += 1)
        {if (substr($in,$i,1) ne ' ') {last}}
    $first = $i;

    for ($i = length($in)-1; $i >= 0; $i -= 1)
        {if (substr($in,$i,1) ne ' ') {last}}	
    $last = $i;

    $out = '';
    for ($i = $first; $i <= $last; $i += 1)
        {$out = $out . substr($in,$i,1)}

    return($out)
} # sub Trim

sub IsInteger {
    my($intin) = @_;

    if ($intin =~ /\D/) {
        return 0;
    } # if
    else {
        return 1;
    } # else
} # sub IsInteger

sub IsAlphaNumeric {
    my($textin) = @_;

    if ($textin =~ /[^a-zA-Z0-9]/) {
        return 0;
    } # if
    else {
        return 1;
    } # else
} # sub IsAlphaNumeric

sub IsAlphaNumericAndSpaces {
    my($textin) = @_;

    if ($textin =~ /[^a-zA-Z_0-9\ ]/) {
        return 0;
    } # if
    else {
        return 1;
    } # else
} # sub IsAlphaNumericAndSpaces

sub IsAlphaNumericAndSpacesAndExtraChars {
    my($textin) = @_;

    if ($textin =~ /[^a-zA-Z_.:!-?£,{}*\$&0-9\ ]/) {
        return 0;
    } # if
    else {
        return 1;
    } # else
} # sub IsAlphaNumericAndSpacesAndExtraChars

sub IsValidEmailAddress {
    my($email) = @_;
    my($result);

    unless ($email =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)|(,)/
	  || $email !~
	  /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/) {
        $result = 1;
    } # unless
    else {
        $result = 0;
    } # else

    if ($email =~ s/\s//g) {
        $result = 0;
    } # if

    return $result;
} # sub IsValidEmail

sub FormatDate {
    my($date) = @_;

    if (! $date) {
        return '---';
    } # if
    else {
        $date = localtime($date);
        my($day, $month, $num, $time, $year) = split(/\s+/,$date);

        if (length($num) < 2) {
            $num = '0' . $num;
        } # if

        return "$num $month $year";
    } # else
} # sub FormatDate

sub EuropeanDate {
    my($offset) = @_;
    $offset = $offset * 86400;

    my($sec, $min, $hour, $dayofmonth, $mon, $year, $weekday, $dayofyear, $IsDST) = localtime(time + $offset);
    $year = $year + 1900;
    $mon++;
    return "$dayofmonth/$mon/$year";
} # sub EuropeanDate

sub USDate {
    my($offset) = @_;
    $offset = $offset * 86400;

    my($sec, $min, $hour, $dayofmonth, $mon, $year, $weekday, $dayofyear, $IsDST) = localtime(time + $offset);
    $year = $year + 1900;
    $mon++;
    return "$mon/$dayofmonth/$year";
} # sub USDate

sub ShortDate {
    my($offset) = @_;
    $offset = $offset * 86400;

    my($sec, $min, $hour, $dayofmonth, $mon, $year, $weekday, $dayofyear, $IsDST) = localtime(time + $offset);
    $year = $year + 1900;
    my(@months) = ("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
    my($monthname) = $months[$mon];

    return "$dayofmonth $monthname $year";
} # sub ShortDate

sub LongDate {
    my($offset) = @_;
    $offset = $offset * 86400;

    my($sec, $min, $hour, $dayofmonth, $mon, $year, $weekday, $dayofyear, $IsDST) = localtime(time + $offset);
    $year = $year + 1900;
    my(@months) = ("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    my($monthname) = $months[$mon];
    my(@days) = ("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    my($dayname) = $days[$weekday-1];

    return "$dayname, $dayofmonth $monthname $year";
} # sub LongDate

sub TimeStamp {
   my($sec, $min, $hour, $dayofmonth, $mon, $year, $weekday, $dayofyear, $IsDST) = localtime(time);
   $mon++;
   $year = $year + 1900;

    if (length($sec) < 2) {$sec = "0" . $sec}
    if (length($min) < 2) {$min = "0" . $min}
    if (length($hour) < 2) {$hour = "0" . $hour}
    if (length($mon) < 2) {$mon = "0" . $mon}
    if (length($dayofmonth) < 2) {$dayofmonth = "0" . $dayofmonth}

   return "$hour:$min:$sec $mon\-$dayofmonth\-$year";
} # sub TimeStamp

sub EncodeHTML {
    my($text) = @_;
    my($result) = $text;

    $result =~s/&/&amp;/g;
    $result =~s/</&lt;/g;
    $result =~s/>/&gt;/g;
    $result =~s/"/&quot;/g;

    return $result;
} # sub EncodeHTML

sub DecodeHTML {
    my($text) = @_;
    my($result) = $text;

    $result =~s/&lt;/</g;
    $result =~s/&gt;/>/g;
    $result =~s/&quot;/"/g;
    $result =~s/&amp;/&/g;

    return $result;
} # sub DecodeHTML

sub RandomValue {
    my($chars, $length) = @_;
    my($result, @charlist);

    open (FILE, "<$_data_path/serial.txt") or die;
    if ($g_settings{"file_locking"}) {flock(FILE, 2)}
    my(@file) = <FILE>;
    close FILE;
    if ($g_settings{"file_locking"}) {flock(FILE, 8)}
    my($seed) = $file[0];
    $seed++;
    open (FILE, ">$_data_path/serial.txt") or die;
    if ($g_settings{"file_locking"}) {flock(FILE, 2)}
    print FILE $seed;
    close FILE;
    if ($g_settings{"file_locking"}) {flock(FILE, 8)}

    srand($seed);
	@charlist = split(/ */, $chars);
    while (length($result) < $length) {
        $result .= $charlist[int(rand(length($chars)))];
    } # while

    return $result;
} # sub RandomValue

sub LoadText {
    my($filename) = @_;
    my($result);

    if (! -e $filename) {
        return $result;
    } # if

    open(FILE, "<$filename") or &FatalError("LoadText", "006", "$filename", "---", "---", "---");
    if ($g_settings{"file_locking"}) {flock(FILE, 2)}
    my(@lines) = <FILE>;
    close FILE;
    if ($g_settings{"file_locking"}) {flock(FILE, 8)}

    my($line);
    foreach $line (@lines) {
        $result = $result . $line;
    } # foreach

    return $result;
} # sub LoadText

sub SaveText {
    my($text, $fname) = @_;

    if (! $text) {
        unlink ($fname);
        return 1;
    } # if

    open(FILE, ">$fname") or &FatalError("SaveText", "007", "$fname", "---", "---", "---");
    if ($g_settings{"file_locking"}) {flock(FILE, 2)}
    print FILE $text;
    close FILE;
    if ($g_settings{"file_locking"}) {flock(FILE, 8)}

    return 1;
} # sub SaveText

sub ReplaceTags {
    my($text_in, $cid_in, $arid_in) = @_;
    my($result) = $text_in;

    if (! $text_in) {
        return $result;
    } # if

    my(%campaign) = &data_Load($cid_in);
    if (! %campaign) {
        return $result;
    } # if

    my(%profile) = &data_Load("OWN00000000");
    if (! %profile) {
        return $result;
    } # if

    my($date, $replace, $sub);

    if ($result =~ /{FULLNAME (\w+)}/) {
        $sub = $1;
        if (($campaign{"full_name"} eq "") or ($g_settings{"force_default_personalisation"})) {
            $result =~s/{FULLNAME $sub}/$sub/g;
        } # if
        else {
            $result =~s/{FULLNAME $sub}/{FULLNAME}/g;
        } # else
    } # if

    if ($result =~ /{FIRSTNAME (\w+)}/) {
        $sub = $1;
        if (($campaign{"first_name"} eq "") or ($g_settings{"force_default_personalisation"})) {
            $result =~s/{FIRSTNAME $sub}/$sub/g;
        } # if
        else {
            $result =~s/{FIRSTNAME $sub}/{FIRSTNAME}/g;
        } # else
    } # if

    if ($result =~ /{LASTNAME (\w+)}/) {
        $sub = $1;
        if (($campaign{"last_name"} eq "") or ($g_settings{"force_default_personalisation"})) {
            $result =~s/{LASTNAME $sub}/$sub/g;
        } # if
        else {
            $result =~s/{LASTNAME $sub}/{LASTNAME}/g;
        } # else
    } # if

    if ($result =~ /{EMAIL (\w+)}/) {
        $sub = $1;
        if (($campaign{"email"} eq "") or ($g_settings{"force_default_personalisation"})) {
            $result =~s/{EMAIL $sub}/$sub/g;
        } # if
        else {
            $result =~s/{EMAIL $sub}/{EMAIL}/g;
        } # else
    } # if

    if ($result =~ /{TRACKINGTAG (\w+)}/) {
        $sub = $1;
        if (($campaign{"tracking_tag"} eq "") or ($g_settings{"force_default_personalisation"})) {
            $result =~s/{TRACKINGTAG $sub}/$sub/g;
        } # if
        else {
            $result =~s/{TRACKINGTAG $sub}/{TRACKINGTAG}/g;
        } # else
    } # if

    if ($result =~ /{AUTORESPONDER (\w+)}/) {
        $sub = $1;
        if (($ar{"listens_on"} eq "") or ($g_settings{"force_default_personalisation"})) {
            $result =~s/{AUTORESPONDER $sub}/$sub/g;
        } # if
        else {
            $result =~s/{AUTORESPONDER $sub}/{AUTORESPONDER}/g;
        } # else
    } # if

    $result =~s/{FULLNAME}/$campaign{"full_name"}/g;
    $result =~s/{FIRSTNAME}/$campaign{"first_name"}/g;
    $result =~s/{LASTNAME}/$campaign{"last_name"}/g;
    $result =~s/{EMAIL}/$campaign{"email"}/g;
    $result =~s/{TRACKINGTAG}/$campaign{"tracking_tag"}/g;

    if (%ar) {
        $result =~s/{AUTORESPONDER}/$ar{"listens_on"}/g;
    } # if
    else {
        $result =~s/{AUTORESPONDER}/Undefined/g;
    } # else

    my(%profile) = &data_Load("OWN00000000");
    if (! %profile) {
        return $result;
    } # if

    if ($result =~ /{SIGNATURE 1}/) {
        $signature = &LoadText("$_data_path/sig1.sig");
        $result =~s/{SIGNATURE 1}/$signature/g;
    } # if

    if ($result =~ /{SIGNATURE 2}/) {
        $signature = &LoadText("$_data_path/sig2.sig");
        $result =~s/{SIGNATURE 2}/$signature/g;
    } # if

    if ($result =~ /{SIGNATURE 3}/) {
        $signature = &LoadText("$_data_path/sig3.sig");
        $result =~s/{SIGNATURE 3}/$signature/g;
    } # if

    if ($result =~ /{AD 1}/) {
        $ad = &LoadText("$_data_path/ad1.ad");
        $result =~s/{AD 1}/$ad/g;
    } # if

    if ($result =~ /{AD 2}/) {
        $ad = &LoadText("$_data_path/ad2.ad");
        $result =~s/{AD 2}/$ad/g;
    } # if

    if ($result =~ /{AD 3}/) {
        $ad = &LoadText("$_data_path/ad3.ad");
        $result =~s/{AD 3}/$ad/g;
    } # if

    if ($result =~ /{SHORTDATE (\d+)}/) {
        $date = &ShortDate($1);
        $replace = "{SHORTDATE $1}";
        $result =~s/$replace/$date/g;
    } # if
    $date = &ShortDate(0);
    $result =~s/{SHORTDATE}/$date/g;

    if ($result =~ /{LONGDATE (\d+)}/) {
        $date = &LongDate($1);
        $replace = "{LONGDATE $1}";
        $result =~s/$replace/$date/g;
    } # if
    $date = &LongDate(0);
    $result =~s/{LONGDATE}/$date/g;

    if ($result =~ /{USDATE (\d+)}/) {
        $date = &USDate($1);
        $replace = "{USDATE $1}";
        $result =~s/$replace/$date/g;
    } # if
    $date = &USDate(0);
    $result =~s/{USDATE}/$date/g;

    if ($result =~ /{EUROPEANDATE (\d+)}/) {
        $date = &EuropeanDate($1);
        $replace = "{EUROPEANDATE $1}";
        $result =~s/$replace/$date/g;
    } # if
    $date = &EuropeanDate(0);
    $result =~s/{EUROPEANDATE}/$date/g;

    if ($result =~ /{MY_TITLE}/) {
        $replace = $profile{"my_title"};
        $result =~s/{MY_TITLE}/$replace/g;
    } # if

    if ($result =~ /{MY_FIRSTNAME}/) {
        $replace = $profile{"my_firstname"};
        $result =~s/{MY_FIRSTNAME}/$replace/g;
    } # if

    if ($result =~ /{MY_LASTNAME}/) {
        $replace = $profile{"my_lastname"};
        $result =~s/{MY_LASTNAME}/$replace/g;
    } # if

    if ($result =~ /{MY_FULLNAME}/) {
        $replace = $profile{"my_fullname"};
        $result =~s/{MY_FULLNAME}/$replace/g;
    } # if

    if ($result =~ /{MY_POSITION}/) {
        $replace = $profile{"my_position"};
        $result =~s/{MY_POSITION}/$replace/g;
    } # if

    if ($result =~ /{MY_COMPANY}/) {
        $replace = $profile{"my_company"};
        $result =~s/{MY_COMPANY}/$replace/g;
    } # if

    if ($result =~ /{MY_ADDRESS1}/) {
        $replace = $profile{"my_address1"};
        $result =~s/{MY_ADDRESS1}/$replace/g;
    } # if

    if ($result =~ /{MY_ADDRESS2}/) {
        $replace = $profile{"my_address2"};
        $result =~s/{MY_ADDRESS2}/$replace/g;
    } # if

    if ($result =~ /{MY_ADDRESS3}/) {
        $replace = $profile{"my_address3"};
        $result =~s/{MY_ADDRESS3}/$replace/g;
    } # if

    if ($result =~ /{MY_ADDRESS4}/) {
        $replace = $profile{"my_address4"};
        $result =~s/{MY_ADDRESS4}/$replace/g;
    } # if

    if ($result =~ /{MY_ADDRESS5}/) {
        $replace = $profile{"my_address5"};
        $result =~s/{MY_ADDRESS5}/$replace/g;
    } # if

    if ($result =~ /{MY_PHONE1}/) {
        $replace = $profile{"my_phone1"};
        $result =~s/{MY_PHONE1}/$replace/g;
    } # if

    if ($result =~ /{MY_PHONE2}/) {
        $replace = $profile{"my_phone2"};
        $result =~s/{MY_PHONE2}/$replace/g;
    } # if

    if ($result =~ /{MY_FAX1}/) {
        $replace = $profile{"my_fax1"};
        $result =~s/{MY_FAX1}/$replace/g;
    } # if

    if ($result =~ /{MY_FAX2}/) {
        $replace = $profile{"my_fax2"};
        $result =~s/{MY_FAX2}/$replace/g;
    } # if

    if ($result =~ /{MY_EMAIL1}/) {
        $replace = $profile{"my_email1"};
        $result =~s/{MY_EMAIL1}/$replace/g;
    } # if

    if ($result =~ /{MY_EMAIL2}/) {
        $replace = $profile{"my_email2"};
        $result =~s/{MY_EMAIL2}/$replace/g;
    } # if

    if ($result =~ /{MY_EMAIL3}/) {
        $replace = $profile{"my_email3"};
        $result =~s/{MY_EMAIL3}/$replace/g;
    } # if

    if ($result =~ /{MY_EMAIL4}/) {
        $replace = $profile{"my_email4"};
        $result =~s/{MY_EMAIL4}/$replace/g;
    } # if

    if ($result =~ /{MY_EMAIL5}/) {
        $replace = $profile{"my_email5"};
        $result =~s/{MY_EMAIL5}/$replace/g;
    } # if

    if ($result =~ /{MY_WEB1}/) {
        $replace = $profile{"my_web1"};
        $result =~s/{MY_WEB1}/$replace/g;
    } # if

    if ($result =~ /{MY_WEB2}/) {
        $replace = $profile{"my_web2"};
        $result =~s/{MY_WEB2}/$replace/g;
    } # if

    if ($result =~ /{MY_WEB3}/) {
        $replace = $profile{"my_web3"};
        $result =~s/{MY_WEB3}/$replace/g;
    } # if

    if ($result =~ /{MY_WEB4}/) {
        $replace = $profile{"my_web4"};
        $result =~s/{MY_WEB4}/$replace/g;
    } # if

    if ($result =~ /{MY_WEB5}/) {
        $replace = $profile{"my_web5"};
        $result =~s/{MY_WEB5}/$replace/g;
    } # if

    if ($result =~ /{MY_MISC1}/) {
        $replace = $profile{"my_misc1"};
        $result =~s/{MY_MISC1}/$replace/g;
    } # if

    if ($result =~ /{MY_MISC2}/) {
        $replace = $profile{"my_misc2"};
        $result =~s/{MY_MISC2}/$replace/g;
    } # if

    if ($result =~ /{MY_MISC3}/) {
        $replace = $profile{"my_misc3"};
        $result =~s/{MY_MISC3}/$replace/g;
    } # if

    if ($result =~ /{MY_MISC4}/) {
        $replace = $profile{"my_misc4"};
        $result =~s/{MY_MISC4}/$replace/g;
    } # if

    if ($result =~ /{MY_MISC5}/) {
        $replace = $profile{"my_misc5"};
        $result =~s/{MY_MISC5}/$replace/g;
    } # if

    if ($result =~ /{AFFILIATE_LINK_TEXT}/) {
        $replace = $g_settings{"affiliate_text"};
        $result =~s/{AFFILIATE_LINK_TEXT}/$replace/g;
    } # if

    if ($result =~ /{AFFILIATE_LINK}/) {
        if ($profile{"affiliate_nickname"}) {
            $replace = "http://www.autoresponseplus.com/link.php?a=$profile{'affiliate_nickname'}";
        } # if
        else {
            $replace = "http://www.autoresponseplus.com";
        } # else

        $result =~s/{AFFILIATE_LINK}/$replace/g;
    } # if

    if ($result =~ /{UNSUBSCRIBE_LINK}/) {
        $un_cid = substr($campaign{"id"},3,8) + 0;
        $un_pin = substr($campaign{"pin"},5,4);
        $replace = "$g_settings{'cgi_arplus_url'}/un.pl?c=$un_cid&p=$un_pin";
        $result =~s/{UNSUBSCRIBE_LINK}/$replace/g;
    } # if

    if ($result =~ /{UNSUBSCRIBE_LINK_TEXT}/) {
        $replace = $g_settings{'unsubscribe_text'};
        $result =~s/{UNSUBSCRIBE_LINK_TEXT}/$replace/g;
    } # if

    if ($result =~ /{SUPPORT_EMAIL}/) {
        $replace = $g_settings{"support_email"};
        $result =~s/{SUPPORT_EMAIL}/$replace/g;
    } # if

    if ($result =~ /{ANTISPAM_MESSAGE}/) {
        $replace = $g_settings{"spam_message"};
        $result =~s/{ANTISPAM_MESSAGE}/$replace/g;
    } # if

    $result =~s/_/ /g;

    return $result;
} # sub ReplaceTags

sub GetDomain {
    my($email) = @_;
    my($result);

    if ($email =~ /@([a-zA-Z0-9-.]+)/) {
        $result = $1;
    } # if
} # sub GetDomain

sub IsBannedAddress {
    my($add_in) = @_;
    my($result) = 0;
    my(@list);
    $add_in = lc(Trim($add_in));

    if (-e "$_data_path/ban.lst") {
        open (FILE, "<$_data_path/ban.lst");
        if ($g_settings{"file_locking"}) {flock(FILE, 2)}
        @list = <FILE>;
        close FILE;
        if ($g_settings{"file_locking"}) {flock(FILE, 8)}
    } # if

    if (! @list) {
        return $result;
    } # if

    my($address);
    foreach $address (@list) {
        if (! $address) {next}
        $address =~s/\s//g;
        if (lc(&Trim($address)) eq $add_in) {
            $result = 1;
            last;
        } # if
    } # foreach

    return $result;
} # sub IsBannedAddress

sub IsBannedDomain {
    my($add_in) = @_;
    my($result) = 0;
    my(@list);
    $add_in = lc(Trim($add_in));

    if (-e "$_data_path/ban.lst") {
        open (FILE, "<$_data_path/ban.lst");
        if ($g_settings{"file_locking"}) {flock(FILE, 2)}
        my(@list) = <FILE>;
        close FILE;
        if ($g_settings{"file_locking"}) {flock(FILE, 8)}
    } # if

    if (! @list) {
        return $result;
    } # if

    my($address);
    foreach $address (@list) {
        if (! $address) {next}
        if ($address =~ "@") {next}
        $address =~s/\s//g;
        $address = lc(&Trim($address));
        if ($add_in =~ $address) {
            $result = 1;
            last;
        } # if
    } # foreach

    return $result;
} # sub IsBannedDomain

sub IsToday {
    my($check) = @_;
    my($result) = 0;
    my($now) = time;
    ($sec, $min, $hour, $dayofmonth, $month, $year, $weekday, $dayofyear, $isdst) = localtime($now);
    $start = $now - ($hour*60*60) - ($min*60) - ($sec);
    $end = $start + 86399;
    if (($check >= $start) and ($check <= $end)) {
        $result = 1;
    } # if

    return $result;
} # sub IsToday

sub IsThisWeek {
    my($check) = @_;
    my($result) = 0;
    my($now) = time;
    ($sec, $min, $hour, $dayofmonth, $month, $year, $weekday, $dayofyear, $isdst) = localtime($now);
    $start = $now - ($weekday*24*60*60) - ($hour*60*60) - ($min*60) - ($sec);
    $end = $start + 604799;;
    if (($check >= $start) and ($check <= $end)) {
        $result = 1;
    } # if

    return $result;
} # sub IsThisWeek

sub IsThisMonth {
    my($check) = @_;
    my($result) = 0;
    my($now) = time;

    ($ch_sec, $ch_min, $ch_hour, $ch_dayofmonth, $ch_month, $ch_year, $ch_weekday, $ch_dayofyear, $ch_isdst) = localtime($check);
    ($sec, $min, $hour, $dayofmonth, $month, $year, $weekday, $dayofyear, $isdst) = localtime($now);
    if (($ch_month == $month) and ($ch_year == $year)) {
        $result = 1;
    } # if

    return $result;
} # sub IsThisMonth

sub IsThisYear {
    my($check) = @_;
    my($result) = 0;
    my($now) = time;

    ($ch_sec, $ch_min, $ch_hour, $ch_dayofmonth, $ch_month, $ch_year, $ch_weekday, $ch_dayofyear, $ch_isdst) = localtime($check);
    ($sec, $min, $hour, $dayofmonth, $month, $year, $weekday, $dayofyear, $isdst) = localtime($now);
    if ($ch_year == $year) {
        $result = 1;
    } # if

    return $result;
} # sub IsThisYear

sub IsListensOnAddress {
    my($add_in) = @_;
    my($result) = 0;

    dbmopen(%db_aut, "$_data_path/AUT", undef);
    if ($g_settings{"file_locking"}) {flock(db_aut, 2)}
    my(@keys) = sort(keys(%db_aut));

    if (! @keys) {
        dbmclose(%db_aut);
        if ($g_settings{"file_locking"}) {flock(db_aut, 8)}
        return $result;
    } # if

    my($key, $fileline, %ar);
    foreach $key (@keys) {
        $fileline = $db_aut{$key};
        %ar = &data_GetRecord($fileline);
        my($thisonelistens) = lc($ar{'listens_on'} . "\@$g_settings{'your_domain'}");
        if ($thisonelistens eq lc($add_in)) {
            $result = 1;
            last;
        } # if
    } # foreach

    dbmclose(%db_aut);
    if ($g_settings{"file_locking"}) {flock(db_aut, 8)}

    return $result;
} # sub IsListensOnAddress

sub GetSubscribePage {
    my($tt_in, $pagetype) = @_;
    $tin = &Trim(lc($tin));
    $result = "";
    
    dbmopen(%db_tra, "$_data_path/TRA", undef);
    if ($g_settings{"file_locking"}) {flock(db_tra, 2)}
    my(@keys) = keys(%db_tra);

    if (! @keys) {
        dbmclose(%db_tra);
        if ($g_settings{"file_locking"}) {flock(db_tra, 8)}
        return $result;
    } # if

    my($key, $fileline, %tr_tag);
    foreach $key (@keys) {
        $fileline = $db_tra{$key};
        %tr_tag = &data_GetRecord($fileline);
        if ($tr_tag{'tag'} eq $tt_in) {
            if (lc($pagetype) eq "success") {
                if ($tr_tag{'subscribe_success'}) {
                        $result = $tr_tag{'subscribe_success'};
                } # if
            } # if
            elsif (lc($pagetype) eq "failure") {
                if ($tr_tag{'subscribe_failure'}) {
                    $result = $tr_tag{'subscribe_failure'}
                } # if
            } # elsif
            last;
        } # if
        else {
            next;
        } # else
    } # foreach

    dbmclose(%db_tra);
    if ($g_settings{"file_locking"}) {flock(db_tra, 8)}

    return $result;
} # sub GetSubscribePage

sub GetUnsubscribePage {
    my($tt_in, $pagetype) = @_;
    $tin = &Trim(lc($tin));
    $result = "";
    
    dbmopen(%db_tra, "$_data_path/TRA", undef);
    if ($g_settings{"file_locking"}) {flock(db_tra, 2)}
    my(@keys) = keys(%db_tra);

    if (! @keys) {
        dbmclose(%db_tra);
        if ($g_settings{"file_locking"}) {flock(db_tra, 8)}
        return $result;
    } # if

    my($key, $fileline, %tr_tag);
    foreach $key (@keys) {
        $fileline = $db_tra{$key};
        %tr_tag = &data_GetRecord($fileline);
        if ($tr_tag{'tag'} eq $tt_in) {
            if (lc($pagetype) eq "success") {
                if ($tr_tag{'unsubscribe_success'}) {
                        $result = $tr_tag{'unsubscribe_success'};
                } # if
            } # if
            elsif (lc($pagetype) eq "failure") {
                if ($tr_tag{'unsubscribe_failure'}) {
                    $result = $tr_tag{'unsubscribe_failure'}
                } # if
            } # elsif
            last;
        } # if
        else {
            next;
        } # else
    } # foreach

    dbmclose(%db_tra);
    if ($g_settings{"file_locking"}) {flock(db_tra, 8)}

    return $result;
} # sub GetUnsubscribePage

return 1;
