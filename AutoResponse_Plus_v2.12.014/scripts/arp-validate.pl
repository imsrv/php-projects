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

sub validate_CreateTrackingTag {
    my(%fm) = @_;
    my($result, $test);

    if ((length($fm{"tag"}) < 1) or (length($fm{"tag"}) > 8)) {
        $result = "\"Tag\" must be between 1 and 8 digits";
        return $result;
    } # if

    if (! &IsAlphaNumeric($fm{"tag"})) {
        $result = "\"Tag\" contains invalid characters";
        return $result;
    } # if

    $test = &Trim(lc($fm{"tag"}));
    if (&IsTrackingTag($test)) {
        $result = "\"Tag\" is already in use";
        return $result;
    } # if

    if ((length($fm{"description"}) < 1) or (length($fm{"description"}) > 100)) {
        $result = "\"Description\" must be between 1 and 100 characters";
        return $result;
    } # if

    if (! &IsAlphaNumericAndSpacesAndExtraChars($fm{"description"})) {
        $result = "\"Description\" contains invalid characters";
        return $result;
    } # if

    return $result;
} # sub validate_CreateTrackingTag

sub validate_EditTrackingTag {
    my(%fm) = @_;
    my($result, $test);

    if ((length($fm{"tag"}) < 1) or (length($fm{"tag"}) > 8)) {
        $result = "\"Tag\" must be between 1 and 8 digits";
        return $result;
    } # if

    if (! &IsAlphaNumeric($fm{"tag"})) {
        $result = "\"Tag\" contains invalid characters";
        return $result;
    } # if

    $test = &Trim(lc($fm{"tag"}));
    if ((&IsTrackingTag($test)) and ($test ne &Trim(lc($fm{"old_tag"})))) {
        $result = "\"Tag\" is already in use";
        return $result;
    } # if

    if ((length($fm{"description"}) < 1) or (length($fm{"description"}) > 100)) {
        $result = "\"Description\" must be between 1 and 100 characters";
        return $result;
    } # if

    if (! &IsAlphaNumericAndSpacesAndExtraChars($fm{"description"})) {
        $result = "\"Description\" contains invalid characters";
        return $result;
    } # if

    return $result;
} # sub validate_EditTrackingTag

sub validate_EditSetup {
    my(%fm) = @_;
    my($result, $test);

    if (length($fm{"your_domain"}) < 1) {
        $result = "\"Your Domain\" must be entered";
        return $result;
    } # if

    if (length($fm{"cgi_arplus_url"}) < 1) {
        $result = "\"Autoresponse Plus Scripts Directory URL\" must be entered";
        return $result;
    } # if

    if ($fm{"support_email"}) {
        if (! &IsValidEmailAddress($fm{"support_email"})) {
            $result = "\"Support E-mail Address\" is not a valid e-mail address";
            return $result;
        } # if
    } # if

    if ($fm{"system_email"}) {
        if (! &IsValidEmailAddress($fm{"system_email"})) {
            $result = "\"System E-mail Address\" is not a valid e-mail address";
            return $result;
        } # if
    } # if

    if ((length($fm{"cookie_life"}) < 1) or (length($fm{"cookie_life"}) > 3)) {
        $result = "\"Login Cookie Life\" must be between 1 and 3 digits";
        return $result;
    } # if

    if (! &IsInteger($fm{"cookie_life"})) {
        $result = "\"Login Cookie Life\" must be a number between 0 and 999";
        return $result;
    } # if

    if ($fm{"cookie_life"} > 999) {
        $result = "\"Login Cookie Life\" must be between 0 and 999";
        return $result;
    } # if

    if ((length($fm{"mail_failures"}) < 1) or (length($fm{"mail_failures"}) > 2)) {
        $result = "\"E-mail Failures\" must be between 1 and 2 digits";
        return $result;
    } # if

    if (! &IsInteger($fm{"mail_failures"})) {
        $result = "\"E-mail Failures\" must be a number between 0 and 10";
        return $result;
    } # if

    if ($fm{"mail_failures"} > 10) {
        $result = "\"E-mail Failures\" must be between 0 and 10";
        return $result;
    } # if

    if ((length($fm{"max_list"}) < 1) or (length($fm{"max_list"}) > 4)) {
        $result = "\"Number of Subscribers per Page\" must be between 1 and 4 digits";
        return $result;
    } # if

    if (! &IsInteger($fm{"max_list"})) {
        $result = "\"Number of Subscribers per Page\" must be a number";
        return $result;
    } # if

    if ($fm{"max_list"} > 9999) {
        $result = "\"Number of Subscribers per Page\" must be between 0 and 9999";
        return $result;
    } # if

    return $result;
} # sub validate_EditSetup

sub validate_EditProfile {
    my(%fm) = @_;
    my($result);

    if ((length($fm{"new_name"}) < 5) or (length($fm{"new_name"}) > 40)) {
        $result = "\"Owner Name\" must be between 5 and 40 characters";
        return $result;
    } # if

    if (! &IsAlphaNumericAndSpacesAndExtraChars($fm{"new_name"})) {
        $result = "\"Owner Name\" contains invalid characters";
        return $result;
    } # if

    if ((length($fm{"new_password"}) < 5) or (length($fm{"new_password"}) > 40)) {
        $result = "\"Password\" must be between 5 and 40 characters";
        return $result;
    } # if

    if (! &IsAlphaNumeric($fm{"new_password"})) {
        $result = "\"Password\" can only contain letters and digits";
        return $result;
    } # if

    if (&Trim(lc($fm{"new_password"})) ne &Trim(lc($fm{"confirm_new_password"}))) {
        $result = "The passwords do not match";
        return $result;
    } # if

    if ($fm{"email"}) {
        if ((length($fm{"email"}) < 1) or (length($fm{"email"}) > 40)) {
            $result = "\"Your E-mail Address\" must be between 1 and 40 characters";
            return $result;
        } # if
    } # if

    if ($fm{"email"}) {
        if (! &IsValidEmailAddress($fm{"email"})) {
            $result = "\"Your E-mail Address\" is not a valid e-mail address";
            return $result;
        } # if
    } # if

    if ($fm{"email"}) {
        if (&IsListensOnAddress($fm{"email"})) {
            $result = "\"Your E-mail Address\" cannot be an autoresponder subscription address";
            return $result;
        } # if
    } # if

    if ($fm{"affiliate_nickname"}) {
        if ((length($fm{"affiliate_nickname"}) < 5) or (length($fm{"affiliate_nickname"}) > 10)) {
            $result = "\"Affiliate Nickname\" must be between 5 and 10 characters";
            return $result;
        } # if
    } # if

    if ($fm{"affiliate_nickname"}) {
        if (! &IsAlphaNumeric($fm{"affiliate_nickname"})) {
            $result = "\"Affiliate Nickname\" can only contain letters and digits";
            return $result;
        } # if
    } # if

    return $result;
} # sub validate_EditProfile

sub validate_CreateAutoresponder {
    my(%fm) = @_;
    my($result, $test);

    if ((length($fm{"reply_name"}) < 1) or (length($fm{"reply_name"}) > 40)) {
        $result = "\"From Name\" must be between 1 and 40 characters";
        return $result;
    } # if

    if (! &IsAlphaNumericAndSpacesAndExtraChars($fm{"reply_name"})) {
        $result = "\"From Name\" contains invalid characters";
        return $result;
    } # if

    if ((length($fm{"reply_email"}) < 1) or (length($fm{"reply_email"}) > 40)) {
        $result = "\"Reply Address\" must be between 1 and 40 characters";
        return $result;
    } # if

    if (! &IsValidEmailAddress($fm{"reply_email"})) {
        $result = "\"Reply Address\" is not a valid e-mail address";
        return $result;
    } # if

    if (&IsListensOnAddress($fm{"reply_email"})) {
        $result = "\"Reply Address\" cannot be an autoresponder subscription address";
        return $result;
    } # if

    if ((length($fm{"listens_on"}) < 1) or (length($fm{"listens_on"}) > 40)) {
        $result = "\"Subscription Address\" must be between 1 and 40 characters";
        return $result;
    } # if

    if (! &IsValidEmailAddress("$fm{'listens_on'}\@$g_settings{'your_domain'}")) {
        $result = "\"Subscription Address\" is not a valid e-mail address";
        return $result;
    } # if

    if (&IsReservedAddress("$fm{'listens_on'}\@$g_settings{'your_domain'}")) {
        $result = "\"Subscription Address\" is a reserved e-mail address";
        return $result;
    } # if

    my($test) = lc(&Trim("$fm{'listens_on'}\@$g_settings{'your_domain'}"));
    if (&IsListensOnAddress($test)) {
        $result = "\"Subscription Address\" is already in use by another autoresponder";
        return $result;
    } # if

    my($test) = lc(&Trim("$fm{'listens_on'}\@$g_settings{'your_domain'}"));
    if (&IsReplyAddress($test)) {
        $result = "\"Subscription Address\" is in use as a reply address";
        return $result;
    } # if

    my($test) = lc(&Trim("$fm{'listens_on'}\@$g_settings{'your_domain'}"));
    if ($test eq lc(&Trim($fm{"reply_email"}))) {
        $result = "\"Subscription Address\" and \"Reply Address\" cannot be the same";
        return $result;
    } # if

    my($test) = lc(&Trim("$fm{'listens_on'}\@$g_settings{'your_domain'}"));
    if (&IsCampaignAddress($test)) {
        $result = "\"Subscription Address\" is in use as a subscriber address";
        return $result;
    } # if

    my($test) = lc(&Trim("$fm{'listens_on'}\@$g_settings{'your_domain'}"));
    if (&IsOwnerAddress($test)) {
        $result = "\"Subscription Address\" cannot be the same as your profile e-mail address";
        return $result;
    } # if

    if (($fm{"format"} eq "T") and ($fm{"default_format"} ne "T")) {
        $result = "\"Default Format\" must be set to plain text if the format is plain text";
        return $result;
    } # if

    if (($fm{"format"} eq "H") and ($fm{"default_format"} ne "H")) {
        $result = "\"Default Format\" must be set to HTML if the format is HTML";
        return $result;
    } # if

    if ((length($fm{"description"}) < 1)  or (length($fm{"description"}) > 100)) {
        $result = "\"Description\" must be between 1 and 100 characters";
    } # if

    if (! &IsAlphaNumericAndSpacesAndExtraChars($fm{"description"})) {
        $result = "\"Description\" contains invalid characters";
        return $result;
    } # if

    return $result;
} # sub validate_CreateAutoresponder

sub validate_EditAutoresponderProperties {
    my(%fm) = @_;
    my($result, $test);

    if ((length($fm{"reply_name"}) < 1) or (length($fm{"reply_name"}) > 40)) {
        $result = "\"From Name\" must be between 1 and 40 characters";
        return $result;
    } # if

    if (! &IsAlphaNumericAndSpacesAndExtraChars($fm{"reply_name"})) {
        $result = "\"From Name\" contains invalid characters";
        return $result;
    } # if

    if ((length($fm{"reply_email"}) < 1) or (length($fm{"reply_email"}) > 40)) {
        $result = "\"Reply Address\" must be between 1 and 40 characters";
        return $result;
    } # if

    if (! &IsValidEmailAddress($fm{"reply_email"})) {
        $result = "\"Reply Address\" is not a valid e-mail address";
        return $result;
    } # if

    if (&IsListensOnAddress($fm{"reply_email"})) {
        $result = "\"Reply Address\" cannot be an autoresponder subscription address";
        return $result;
    } # if

    if ((length($fm{"listens_on"}) < 1) or (length($fm{"listens_on"}) > 40)) {
        $result = "\"Subscription Address\" must be between 1 and 40 characters";
        return $result;
    } # if

    if (! &IsValidEmailAddress("$fm{'listens_on'}\@$g_settings{'your_domain'}")) {
        $result = "\"Subscription Address\" is not a valid e-mail address";
        return $result;
    } # if

    if (&IsReservedAddress("$fm{'listens_on'}\@$g_settings{'your_domain'}")) {
        $result = "\"Subscription Address\" is a reserved e-mail address";
        return $result;
    } # if

    my($test) = lc(&Trim("$fm{'listens_on'}\@$g_settings{'your_domain'}"));
    if ((&IsListensOnAddress($test)) and ($test ne lc(&Trim("$fm{'old_listens_on'}\@$g_settings{'your_domain'}")))) {
        $result = "\"Subscription Address\" is already in use by another autoresponder";
        return $result;
    } # if

    my($test) = lc(&Trim("$fm{'listens_on'}\@$g_settings{'your_domain'}"));
    if (&IsReplyAddress($test)) {
        $result = "\"Subscription Address\" is in use as a reply address";
        return $result;
    } # if

    my($test) = lc(&Trim("$fm{'listens_on'}\@$g_settings{'your_domain'}"));
    if ($test eq lc(&Trim($fm{"reply_email"}))) {
        $result = "\"Subscription Address\" and \"Reply Address\" cannot be the same";
        return $result;
    } # if

    my($test) = lc(&Trim("$fm{'listens_on'}\@$g_settings{'your_domain'}"));
    if (&IsCampaignAddress($test)) {
        $result = "\"Subscription Address\" is in use as a subscriber address";
        return $result;
    } # if

    my($test) = lc(&Trim("$fm{'listens_on'}\@$g_settings{'your_domain'}"));
    if (&IsOwnerAddress($test)) {
        $result = "\"Subscription Address\" cannot be the same as your profile e-mail address";
        return $result;
    } # if

    if (($fm{"format"} eq "T") and ($fm{"default_format"} ne "T")) {
        $result = "\"Default Format\" must be set to plain text if the format is plain text";
        return $result;
    } # if

    if (($fm{"format"} eq "H") and ($fm{"default_format"} ne "H")) {
        $result = "\"Default Format\" must be set to HTML if the format is HTML";
        return $result;
    } # if

    if ((length($fm{"description"}) < 1)  or (length($fm{"description"}) > 100)) {
        $result = "\"Description\" must be between 1 and 100 characters";
    } # if

    if (! &IsAlphaNumericAndSpacesAndExtraChars($fm{"description"})) {
        $result = "\"Description\" contains invalid characters";
        return $result;
    } # if

    return $result;
} # sub validate_EditAutoresponderProperties

sub validate_EditMessage {
    my(%fm) = @_;
    my($result);

    if (($fm{"schedule"} eq "INT") or ($fm{"interval"})) {
        if ((length($fm{"interval"}) < 1) or (length($fm{"interval"}) > 3)) {
            $result = "\"Interval\" must be between 1 and 3 digits";
            return $result;
        } # if

        if (! IsInteger($fm{"interval"})) {
            $result = "\"Interval\" must be a number between 1 and 999";
            return $result;
        } # if

        if (($fm{"interval"} < 1) or ($fm{"interval"} > 999)) {
            $result = "\"Interval\" must be between 1 and 999";
            return $result;
        } # if
    } # if

    if ((length(&Trim($fm{"subject"})) < 1) or (length(&Trim($fm{"subject"})) > 100)) {
        $result = "\"Subject\" must be between 1 and 100 characters";
        return $result;
    } # if

    if (! &IsAlphaNumericAndSpacesAndExtraChars(&Trim($fm{"subject"}))) {
        $result = "\"Subject\" contains invalid characters";
        return $result;
    } # if

    return $result;
} # sub validate_EditMessage

sub validate_CreateCampaign {
    my(%fm) = @_;
    my($result);

    if ($fm{"first_name"}) {
        if ((length($fm{"first_name"}) < 1) or (length($fm{"first_name"}) > 40)) {
            $result = "\"First Name\" must be between 1 and 40 characters";
            return $result;
        } # if
    } # if

    if ($fm{"first_name"}) {
        if (! &IsAlphaNumericAndSpaces($fm{"first_name"})) {
            $result = "\"First Name\" can only contain letters, digits and spaces";
            return $result;
        } # if
    } # if

    if ($fm{"last_name"}) {
        if ((length($fm{"last_name"}) < 1) or (length($fm{"last_name"}) > 40)) {
            $result = "\"Last Name\" must be between 1 and 40 characters";
            return $result;
        } # if
    } # if

    if ($fm{"last_name"}) {
        if (! &IsAlphaNumericAndSpaces($fm{"last_name"})) {
            $result = "\"Last Name\" can only contain letters, digits and spaces";
            return $result;
        } # if
    } # if

    if ($fm{"full_name"}) {
        if ((length($fm{"full_name"}) < 1) or (length($fm{"full_name"}) > 40)) {
            $result = "\"Full Name\" must be between 1 and 40 characters";
            return $result;
        } # if
    } # if

    if ($fm{"full_name"}) {
        if (! &IsAlphaNumericAndSpaces($fm{"full_name"})) {
            $result = "\"Full Name\" can only contain letters, digits and spaces";
            return $result;
        } # if
    } # if

    if ((length($fm{"email"}) < 1) or (length($fm{"email"}) > 40)) {
        $result = "\"Contact E-mail Address\" must be between 1 and 40 characters";
        return $result;
    } # if

    if (! &IsValidEmailAddress($fm{"email"})) {
        $result = "\"Contact E-mail Address\" is not a valid e-mail address";
        return $result;
    } # if

    if (! $fm{"autoresponder_id"}) {
        $result = "\"Autoresponder\" has not been selected";
        return $result;
    } # if

    if (&IsListensOnAddress($fm{"email"})) {
        $result = "\"Contact E-mail Address\" cannot be an autoresponder subscription address";
        return $result;
    } # if

    return $result;
} # sub validate_CreateCampaign

sub validate_EditCampaign {
    my(%fm) = @_;
    my($result);

    if ($fm{"first_name"}) {
        if ((length($fm{"first_name"}) < 1) or (length($fm{"first_name"}) > 40)) {
            $result = "\"First Name\" must be between 1 and 40 characters";
            return $result;
        } # if
    } # if

    if ($fm{"first_name"}) {
        if (! &IsAlphaNumericAndSpaces($fm{"first_name"})) {
            $result = "\"First Name\" can only contain letters, digits and spaces";
            return $result;
        } # if
    } # if

    if ($fm{"last_name"}) {
        if ((length($fm{"last_name"}) < 1) or (length($fm{"last_name"}) > 40)) {
            $result = "\"Last Name\" must be between 1 and 40 characters";
            return $result;
        } # if
    } # if

    if ($fm{"last_name"}) {
        if (! &IsAlphaNumericAndSpaces($fm{"last_name"})) {
            $result = "\"Last Name\" can only contain letters, digits and spaces";
            return $result;
        } # if
    } # if

    if ($fm{"full_name"}) {
        if ((length($fm{"full_name"}) < 1) or (length($fm{"full_name"}) > 40)) {
            $result = "\"Full Name\" must be between 1 and 40 characters";
            return $result;
        } # if
    } # if

    if ($fm{"full_name"}) {
        if (! &IsAlphaNumericAndSpaces($fm{"full_name"})) {
            $result = "\"Full Name\" can only contain letters, digits and spaces";
            return $result;
        } # if
    } # if

    if ((length($fm{"email"}) < 1) or (length($fm{"email"}) > 40)) {
        $result = "\"Contact E-mail Address\" must be between 1 and 40 characters";
        return $result;
    } # if

    if (! &IsValidEmailAddress($fm{"email"})) {
        $result = "\"Contact E-mail Address\" is not a valid e-mail address";
        return $result;
    } # if

    if (&IsListensOnAddress($fm{"email"})) {
        $result = "\"Contact E-mail Address\" cannot be an autoresponder subscription address";
        return $result;
    } # if

    return $result;
} # sub validate_EditCampaign

sub validate_Import {
    my(%fm) = @_;
    my($result);

    if ((length($fm{"email"}) < 1) or (length($fm{"email"}) > 2)) {
        $result = "\"E-mail Address Field Number\" must be entered";
        return $result;
    } # if

    if ($fm{"email"}) {
        if (! &IsInteger($fm{"email"})) {
            $result = "\"E-mail Address Field Number\" must be a number";
            return $result;
        } # if
    } # if

    if ($fm{"first_name"}) {
        if ((length($fm{"first_name"}) < 1) or (length($fm{"first_name"}) > 2)) {
            $result = "\"First Name Field Number\" must be a number";
            return $result;
        } # if
    } # if

    if ($fm{"first_name"}) {
        if (! &IsInteger($fm{"first_name"})) {
            $result = "\"First Name Field Number\" must be a number";
            return $result;
        } # if
    } # if

    if ($fm{"last_name"}) {
        if ((length($fm{"last_name"}) < 1) or (length($fm{"last_name"}) > 2)) {
            $result = "\"Last Name Field Number\" must be a number";
            return $result;
        } # if
    } # if

    if ($fm{"last_name"}) {
        if (! &IsInteger($fm{"last_name"})) {
            $result = "\"Last Name Field Number\" must be a number";
            return $result;
        } # if
    } # if

    if ($fm{"full_name"}) {
        if ((length($fm{"full_name"}) < 1) or (length($fm{"full_name"}) > 2)) {
            $result = "\"Full Name Field Number\" must be a number";
            return $result;
        } # if
    } # if

    if ($fm{"full_name"}) {
        if (! &IsInteger($fm{"full_name"})) {
            $result = "\"Full Name Field Number\" must be a number";
            return $result;
        } # if
    } # if

    if ($fm{"format"}) {
        if (! &IsInteger($fm{"format"})) {
            $result = "\"Format Preference Field Number\" must be a number";
            return $result;
        } # if
    } # if

    if (! $fm{"autoresponder_id"}) {
        $result = "You must choose an autoresponder";
        return $result;
    } # if

    return $result;
} # sub validate_Import

sub validate_BatchEmail {
    my($result, $test);

    if ((length($fm{"from_name"}) < 1) or (length($fm{"from_name"}) > 40)) {
        $result = "\"From Name\" must be between 1 and 40 characters";
        return $result;
    } # if

    if (! &IsAlphaNumericAndSpacesAndExtraChars($fm{"from_name"})) {
        $result = "\"From Name\" contains invalid characters";
        return $result;
    } # if

    if ((length($fm{"from_email"}) < 1) or (length($fm{"from_email"}) > 40)) {
        $result = "\"From E-mail Address\" must be between 1 and 40 characters";
        return $result;
    } # if

    if (! &IsValidEmailAddress($fm{"from_email"})) {
        $result = "\"From E-mail Address\" is not a valid e-mail address";
        return $result;
    } # if

    if (&IsListensOnAddress($fm{"from_email"})) {
        $result = "\"From E-mail Address\" cannot be an autoresponder subscription address";
        return $result;
    } # if

    if ((length(&Trim($fm{"subject"})) < 1) or (length(&Trim($fm{"subject"})) > 100)) {
        $result = "\"Subject\" must be between 1 and 100 characters";
        return $result;
    } # if
} # sub validate_BatchEmail

sub IsReservedAddress {
    my($add_in) = @_;
    my($result) = 0;
    $add_in = lc(Trim($add_in));

    open (FILE, "<$_data_path/reserve.lst");
    if ($g_settings{"file_locking"}) {flock(FILE, 2)}
    my(@list) = <FILE>;
    close FILE;
    if ($g_settings{"file_locking"}) {flock(FILE, 8)}

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
} # sub IsReservedAddress

sub IsReplyAddress {
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
        if (&Trim(lc($ar{"reply_email"})) eq &Trim(lc($add_in))) {
            $result = 1;
            last;
        } # if
    } # foreach

    dbmclose(%db_aut);
    if ($g_settings{"file_locking"}) {flock(db_aut, 8)}

    return $result;
} # sub IsReplyAddress

sub IsCampaignAddress {
    my($add_in) = @_;
    my($result) = 0;

    dbmopen(%db_cam, "$_data_path/CAM", undef);
    if ($g_settings{"file_locking"}) {flock(db_cam, 2)}
    my(@keys) = sort(keys(%db_cam));

    if (! @keys) {
        dbmclose(%db_cam);
        if ($g_settings{"file_locking"}) {flock(db_cam, 8)}
        return $result;
    } # if

    my($key, $fileline, %cam);
    foreach $key (@keys) {
        $fileline = $db_cam{$key};
        %cam = &data_GetRecord($fileline);
        if (&Trim(lc($cam{"email"})) eq &Trim(lc($add_in))) {
            $result = 1;
            last;
        } # if
    } # foreach

    dbmclose(%db_cam);
    if ($g_settings{"file_locking"}) {flock(db_cam, 8)}

    return $result;
} # sub IsCampaignAddress

sub IsOwnerAddress {
    my($add_in) = @_;
    my($result) = 0;
    my(%profile) = &data_Load("OWN00000000");

    if (&Trim(lc($profile{"email"})) eq &Trim(lc($add_in))) {
        $result = 1;
    } # if

    return $result;
} # sub IsOwnerAddress

sub IsTrackingTag {
    my($tt_in) = @_;
    my($result) = 0;

    dbmopen(%db_tra, "$_data_path/TRA", undef);
    if ($g_settings{"file_locking"}) {flock(db_tra, 2)}
    my(@keys) = sort(keys(%db_tra));

    if (! @keys) {
        dbmclose(%db_tra);
        if ($g_settings{"file_locking"}) {flock(db_tra, 8)}
        return $result;
    } # if

    my($key, $fileline, %tt);
    foreach $key (@keys) {
        $fileline = $db_tra{$key};
        %tt = &data_GetRecord($fileline);
        if (&Trim(lc($tt{"tag"})) eq &Trim(lc($tt_in))) {
            $result = 1;
            last;
        } # if
    } # foreach

    dbmclose(%db_tra);
    if ($g_settings{"file_locking"}) {flock(db_tra, 8)}

    return $result;
} # sub IsTrackingTag

return 1;
