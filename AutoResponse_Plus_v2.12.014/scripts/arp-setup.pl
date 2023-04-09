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

sub Setup {
    my(%fm);

    if (! &ValidateOwner) {
        &Redirect("$g_thisscript?a0=log");
    } # if

    if ($g_a1 eq "tst") {
        &EmailTest;
        exit;
    } # if
    elsif ($g_a1 eq "cap") {
        &CaptureTest;
        exit;
    } # elsif
    elsif ($g_a1 eq "pro") {
        $fm{"file_locking"} = &Trim($FORM{"file_locking"});
        $fm{"show_news"} = &Trim($FORM{"show_news"});
        $fm{"cookie_life"} = &Trim($FORM{"cookie_life"});
        $fm{"your_domain"} = &Trim($FORM{"your_domain"});
        $fm{"cgi_arplus_url"} = &Trim($FORM{"cgi_arplus_url"});
        $fm{"sendmail"} = &Trim($FORM{"sendmail"});
        $fm{"support_email"} = &Trim($FORM{"support_email"});
        $fm{"system_email"} = &Trim($FORM{"system_email"});
        $fm{"subscribe_success"} = &Trim($FORM{"subscribe_success"});
        $fm{"unsubscribe_success"} = &Trim($FORM{"unsubscribe_success"});
        $fm{"subscribe_failure"} = &Trim($FORM{"subscribe_failure"});
        $fm{"unsubscribe_failure"} = &Trim($FORM{"unsubscribe_failure"});
        $fm{"affiliate_text"} = &Trim($FORM{"affiliate_text"});
        $fm{"spam_message"} = &Trim($FORM{"spam_message"});
        $fm{"send_unconf"} = &Trim($FORM{"send_unconf"});
        $fm{"unsubscribe_text"} = &Trim($FORM{"unsubscribe_text"});
        $fm{"mail_failures"} = &Trim($FORM{"mail_failures"});
        $fm{"max_list"} = &Trim($FORM{"max_list"});
        $fm{"force_default_personalisation"} = &Trim($FORM{"force_default_personalisation"});
        $fm{"tooltips"} = &Trim($FORM{"tooltips"});
        $fm{"reserve_list"} = &Trim($FORM{"reserve_list"});
        $fm{"unsubscribe_email"} = &Trim($FORM{"unsubscribe_email"});
        $fm{"sig1"} = &Trim($FORM{"sig1"});
        $fm{"sig2"} = &Trim($FORM{"sig2"});
        $fm{"sig3"} = &Trim($FORM{"sig3"});
        $fm{"ad1"} = &Trim($FORM{"ad1"});
        $fm{"ad2"} = &Trim($FORM{"ad2"});
        $fm{"ad3"} = &Trim($FORM{"ad3"});
        $fm{"ban_list"} = &Trim($FORM{"ban_list"});
        $g_message = &validate_EditSetup(%fm);
        if (! $g_message) {
            my(%setup) = &data_Load("SET00000000");
            $setup{"file_locking"} = $fm{"file_locking"};
            $setup{"show_news"} = $fm{"show_news"};
            $setup{"cookie_life"} = $fm{"cookie_life"};
            $setup{"your_domain"} = $fm{"your_domain"};
            $setup{"cgi_arplus_url"} = $fm{"cgi_arplus_url"};
            $setup{"sendmail"} = $fm{"sendmail"};
            $setup{"support_email"} = $fm{"support_email"};
            $setup{"system_email"} = $fm{"system_email"};
            $setup{"subscribe_success"} = $fm{"subscribe_success"};
            $setup{"unsubscribe_success"} = $fm{"unsubscribe_success"};
            $setup{"subscribe_failure"} = $fm{"subscribe_failure"};
            $setup{"unsubscribe_failure"} = $fm{"unsubscribe_failure"};
            $setup{"affiliate_text"} = $fm{"affiliate_text"};
            $setup{"spam_message"} = $fm{"spam_message"};
            $setup{"unsubscribe_text"} = $fm{"unsubscribe_text"};
            $setup{"send_unconf"} = $fm{"send_unconf"};
            $setup{"mail_failures"} = $fm{"mail_failures"};
            $setup{"max_list"} = $fm{"max_list"};
            $setup{"force_default_personalisation"} = $fm{"force_default_personalisation"};
            $setup{"tooltips"} = $fm{"tooltips"};
            $setup{"reserve_list"} = $fm{"reserve_list"};
            $setup{"unsubscribe_email"} = $fm{"unsubscribe_email"};
            $setup{"sig1"} = $fm{"sig1"};
            $setup{"sig2"} = $fm{"sig2"};
            $setup{"sig3"} = $fm{"sig3"};
            $setup{"ad1"} = $fm{"ad1"};
            $setup{"ad2"} = $fm{"ad2"};
            $setup{"ad3"} = $fm{"ad3"};
            $setup{"ban_list"} = $fm{"ban_list"};
            &data_Save(%setup);
            &SaveText($fm{"reserve_list"}, "$_data_path/reserve.lst");
            &SaveText($fm{"unsubscribe_email"}, "$_data_path/unsub.txt");
            &SaveText($fm{"sig1"}, "$_data_path/sig1.sig");
            &SaveText($fm{"sig2"}, "$_data_path/sig2.sig");
            &SaveText($fm{"sig3"}, "$_data_path/sig3.sig");
            &SaveText($fm{"ad1"}, "$_data_path/ad1.ad");
            &SaveText($fm{"ad2"}, "$_data_path/ad2.ad");
            &SaveText($fm{"ad3"}, "$_data_path/ad3.ad");
            &SaveText($fm{"ban_list"}, "$_data_path/ban.lst");
            &Redirect("$g_thisscript?a0=set");
        } # if
    } # elsif
    else {
        my(%setup) = &data_Load("SET00000000");
        $fm{"file_locking"} = $setup{"file_locking"};
        $fm{"show_news"} = $setup{"show_news"};
        $fm{"cookie_life"} = $setup{"cookie_life"};
        $fm{"your_domain"} = $setup{"your_domain"};
        $fm{"cgi_arplus_url"} = $setup{"cgi_arplus_url"};
        $fm{"sendmail"} = $setup{"sendmail"};
        $fm{"support_email"} = $setup{"support_email"};
        $fm{"system_email"} = $setup{"system_email"};
        $fm{"subscribe_success"} = $setup{"subscribe_success"};
        $fm{"unsubscribe_success"} = $setup{"unsubscribe_success"};
        $fm{"subscribe_failure"} = $setup{"subscribe_failure"};
        $fm{"unsubscribe_failure"} = $setup{"unsubscribe_failure"};
        $fm{"affiliate_text"} = $setup{"affiliate_text"};
        $fm{"spam_message"} = $setup{"spam_message"};
        $fm{"unsubscribe_text"} = $setup{"unsubscribe_text"};
        $fm{"send_unconf"} = $setup{"send_unconf"};
        $fm{"mail_failures"} = $setup{"mail_failures"};
        $fm{"max_list"} = $setup{"max_list"};
        $fm{"force_default_personalisation"} = $setup{"force_default_personalisation"};
        $fm{"tooltips"} = $setup{"tooltips"};
        $fm{"reserve_list"} = &LoadText("$_data_path/reserve.lst");
        $fm{"ban_list"} = &LoadText("$_data_path/ban.lst");
        $fm{"unsubscribe_email"} = &LoadText("$_data_path/unsub.txt");
        $fm{"sig1"} = &LoadText("$_data_path/sig1.sig");
        $fm{"sig2"} = &LoadText("$_data_path/sig2.sig");
        $fm{"sig3"} = &LoadText("$_data_path/sig3.sig");
        $fm{"ad1"} = &LoadText("$_data_path/ad1.ad");
        $fm{"ad2"} = &LoadText("$_data_path/ad2.ad");
        $fm{"ad3"} = &LoadText("$_data_path/ad3.ad");
    } # else

    &EditSetupPage(%fm);
} # sub Setup

sub EditSetupPage {
    my(%fm) = @_;

    &PageHeading;
    &PageHeader("h_setup.htm");
    &PageSubHeader("System Setup", "[<a class='subheaderlink' href='$g_thisscript?a0=set&a1=tst' onmouseover='ShowTooltip(11);' onmouseout='HideTooltip(11);'>E-Mail Send Test</a> | <a class='subheaderlink' href='$g_thisscript?a0=set&a1=cap' onmouseover='ShowTooltip(12);' onmouseout='HideTooltip(12);'>E-Mail Capture Test</a>]");

    &Spacer("1", "5");

    &OpenForm("form", "$g_thisscript?a0=set&a1=pro");

    if (! &ValidateSetup) {
        print "<tr>\n";
        print "<td class='formcellredtext' colspan='2' valign='middle'>The values below shown in <b>red text</b> must be entered for the system to function correctly.</td>\n";
        print "</tr>\n";
    } # if

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Data file path</b><br>To change this value, edit the file <b>arp-paths.pl</b></td>\n";
    print "<td class='formcell' width='50%' valign='middle'>$_data_path</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Your web site URL</b><br>To change this value, edit the file <b>arp-paths.pl</b></td>\n";
    print "<td class='formcell' width='50%' valign='middle'>$_your_web_site_url</td>\n";
    print "</tr>\n";

    if ((&Trim(lc($fm{'your_domain'})) eq 'yourdomain.com') or (! &Trim($fm{'your_domain'}))) {
        print "<tr>\n";
        print "<td class='formcellredtext' width='50%' valign='middle' align='right'><b>Your domain</b><br>For example, yourdomain.com</td>\n";
        $size = &FieldSize(40);
        print "<td class='formcellredtext' width='50%' valign='middle'><input type='text' name='your_domain' size='$size' value='$fm{'your_domain'}'></td>\n";
        print "</tr>\n";
    } # if
    else {
        print "<tr>\n";
        print "<td class='formcell' width='50%' valign='middle' align='right'><b>Your domain</b><br>For example, yourdomain.com</td>\n";
        $size = &FieldSize(40);
        print "<td class='formcell' width='50%' valign='middle'><input type='text' name='your_domain' size='$size' value='$fm{'your_domain'}'></td>\n";
        print "</tr>\n";
    } # else

    if ((&Trim(lc($fm{'cgi_arplus_url'})) eq 'http://www.yourdomain.com/cgi-bin/arplus') or (! &Trim($fm{'cgi_arplus_url'}))) {
        print "<tr>\n";
        print "<td class='formcellredtext' width='50%' valign='middle' align='right'><b>URL of your Autoresponse Plus scripts directory</b><br>For example, http://yourdomain.com/cgi-bin/arplus<br>There should be <b>no</b> slash at the end</td>\n";
        $size = &FieldSize(40);
        print "<td class='formcellredtext' width='50%' valign='middle'><input type='text' name='cgi_arplus_url' size='$size' value='$fm{'cgi_arplus_url'}'></td>\n";
        print "</tr>\n";
    } # if
    else {
        print "<tr>\n";
        print "<td class='formcell' width='50%' valign='middle' align='right'><b>URL of your Autoresponse Plus scripts directory</b><br>For example, http://yourdomain.com/cgi-bin/arplus<br>There should be <b>no</b> slash at the end</td>\n";
        $size = &FieldSize(40);
        print "<td class='formcell' width='50%' valign='middle'><input type='text' name='cgi_arplus_url' size='$size' value='$fm{'cgi_arplus_url'}'></td>\n";
        print "</tr>\n";
    } # else

    if ((&Trim(lc($fm{'sendmail'})) eq '/path/to/your/sendmail') or (! &Trim($fm{'sendmail'}))) {
        print "<tr>\n";
        print "<td class='formcellredtext' width='50%' valign='middle' align='right'><b>Path to your sendmail program</b><br>For example, /usr/bin/sendmail<br>There should be <b>no</b> slash at the end</td>\n";
        $size = &FieldSize(40);
        print "<td class='formcellredtext' width='50%' valign='middle'><input type='text' name='sendmail' size='$size' value='$fm{'sendmail'}'></td>\n";
        print "</tr>\n";
    } # if
    else {
        print "<tr>\n";
        print "<td class='formcell' width='50%' valign='middle' align='right'><b>Path to your sendmail program</b><br>For example, /usr/bin/sendmail<br>There should be <b>no</b> slash at the end</td>\n";
        $size = &FieldSize(40);
        print "<td class='formcell' width='50%' valign='middle'><input type='text' name='sendmail' size='$size' value='$fm{'sendmail'}'></td>\n";
        print "</tr>\n";
    } # else

    if ((&Trim(lc($fm{'support_email'})) eq "support\@yourdomain.com") or (! &Trim($fm{'support_email'}))) {
        print "<tr>\n";
        print "<td class='formcellredtext' width='50%' valign='middle' align='right'><b>Your support e-mail address</b><br>For example, support\@yourdomain.com<br>Used when your subscribers have problems</td>\n";
        $size = &FieldSize(40);
        print "<td class='formcellredtext' width='50%' valign='middle'><input type='text' name='support_email' size='$size' value='$fm{'support_email'}'></td>\n";
        print "</tr>\n";
    } # if
    else {
        print "<tr>\n";
        print "<td class='formcell' width='50%' valign='middle' align='right'><b>Your support e-mail address</b><br>For example, support\@yourdomain.com<br>Used when your subscribers have problems</td>\n";
        $size = &FieldSize(40);
        print "<td class='formcell' width='50%' valign='middle'><input type='text' name='support_email' size='$size' value='$fm{'support_email'}'></td>\n";
        print "</tr>\n";
    } # else

    if ((&Trim(lc($fm{'system_email'})) eq "support\@yourdomain.com") or (! &Trim($fm{'system_email'}))) {
        print "<tr>\n";
        print "<td class='formcellredtext' width='50%' valign='middle' align='right'><b>System e-mail address</b><br>Used to send confirmation messages to your subscribers<br>when they subscribe or unsubscribe</td>\n";
        $size = &FieldSize(40);
        print "<td class='formcellredtext' width='50%' valign='middle'><input type='text' name='system_email' size='$size' value='$fm{'system_email'}'></td>\n";
        print "</tr>\n";
    } # if
    else {
        print "<tr>\n";
        print "<td class='formcell' width='50%' valign='middle' align='right'><b>System e-mail address</b><br>Used to send confirmation messages to your subscribers</td>\n";
        $size = &FieldSize(40);
        print "<td class='formcell' width='50%' valign='middle'><input type='text' name='system_email' size='$size' value='$fm{'system_email'}'></td>\n";
        print "</tr>\n";
    } # else

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Show news banner?</b></td>\n";
    if ($fm{"show_news"}) {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='show_news' value='1' checked></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='show_news' value='1'></td>\n";
    } # else
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Use file locking?</b><br>Recommended to prevent data corruption</td>\n";
    if ($fm{"file_locking"}) {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='file_locking' value='1' checked></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='file_locking' value='1'></td>\n";
    } # else
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Login cookie life</b></td>\n";
    $size = &FieldSize(10);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='cookie_life' size='$size' maxlength='3' value='$fm{'cookie_life'}'> days</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>E-mail failures</b><br>Number of failed e-mails allowed per subscriber</td>\n";
    $size = &FieldSize(10);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='mail_failures' size='$size' maxlength='2' value='$fm{'mail_failures'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Number of subscribers per page</b><br>Maximum number of subscribers shown on a<br>single screen</td>\n";
    $size = &FieldSize(10);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='max_list' size='$size' maxlength='4' value='$fm{'max_list'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Force default personalization?</b></td>\n";
    if ($fm{"force_default_personalisation"}) {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='force_default_personalisation' value='1' checked></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='force_default_personalisation' value='1'></td>\n";
    } # else
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Show sub menu bar tool tips?</b></td>\n";
    if ($fm{"tooltips"}) {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='tooltips' value='1' checked></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='tooltips' value='1'></td>\n";
    } # else
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Default custom subscribe success page URL</b><br>Optional</td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='subscribe_success' size='$size' value='$fm{'subscribe_success'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Default custom subscribe failure page URL</b><br>Optional</td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='subscribe_failure' size='$size' value='$fm{'subscribe_failure'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Default custom unsubscribe success page URL</b><br>Optional</td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='unsubscribe_success' size='$size' value='$fm{'unsubscribe_success'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Default custom unsubscribe failure page URL</b><br>Optional</td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='unsubscribe_failure' size='$size' value='$fm{'unsubscribe_failure'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Affiliate link text</b></td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='affiliate_text' size='$size' value='$fm{'affiliate_text'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Anti-spam message</b></td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='spam_message' size='$size' value='$fm{'spam_message'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Send e-mail confirmation on unsubscribe?</b></td>\n";
    if ($fm{"send_unconf"}) {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='send_unconf' value='1' checked></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='send_unconf' value='1'></td>\n";
    } # else
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Unsubscribe link text</b></td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='unsubscribe_text' size='$size' value='$fm{'unsubscribe_text'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>Unsubscribe Confirmation E-mail Text</b><br>The text of the confirmation message which will be sent to contacts who unsubscribe</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    $size = &FieldSize(70);
    print "<td class='formcell' colspan='2' align='center'><textarea rows='8' name='unsubscribe_email' cols='$size'>\n";
    print $fm{"unsubscribe_email"};
    print "</textarea>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>Signature 1</b><br>Include in messages with {SIGNATURE 1}</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    $size = &FieldSize(70);
    print "<td class='formcell' colspan='2' align='center'><textarea rows='8' name='sig1' cols='$size'>\n";
    print $fm{"sig1"};
    print "</textarea>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>Signature 2</b><br>Include in messages with {SIGNATURE 2}</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    $size = &FieldSize(70);
    print "<td class='formcell' colspan='2' align='center'><textarea rows='8' name='sig2' cols='$size'>\n";
    print $fm{"sig2"};
    print "</textarea>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>Signature 3</b><br>Include in messages with {SIGNATURE 1}</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    $size = &FieldSize(70);
    print "<td class='formcell' colspan='2' align='center'><textarea rows='8' name='sig3' cols='$size'>\n";
    print $fm{"sig3"};
    print "</textarea>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>Advert 1</b><br>Include in messages with {AD 1}</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    $size = &FieldSize(70);
    print "<td class='formcell' colspan='2' align='center'><textarea rows='8' name='ad1' cols='$size'>\n";
    print $fm{"ad1"};
    print "</textarea>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>Advert 2</b><br>Include in messages with {AD 2}</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    $size = &FieldSize(70);
    print "<td class='formcell' colspan='2' align='center'><textarea rows='8' name='ad2' cols='$size'>\n";
    print $fm{"ad2"};
    print "</textarea>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>Advert 3</b><br>Include in messages with {AD 3}</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    $size = &FieldSize(70);
    print "<td class='formcell' colspan='2' align='center'><textarea rows='8' name='ad3' cols='$size'>\n";
    print $fm{"ad3"};
    print "</textarea>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>Reserved E-mail Addresses</b><br>E-mail addresses which cannot be used for new autoresponder subscription addresses<br>One per line</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    $size = &FieldSize(70);
    print "<td class='formcell' colspan='2' align='center'><textarea rows='8' name='reserve_list' cols='$size'>\n";
    print $fm{"reserve_list"};
    print "</textarea>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>Ban List</b><br>E-mail addresses and domains from which subscriptions will be ignored<br>One per line</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    $size = &FieldSize(70);
    print "<td class='formcell' colspan='2' align='center'><textarea rows='8' name='ban_list' cols='$size'>\n";
    print $fm{"ban_list"};
    print "</textarea>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Save Changes  '> <input type='reset' value='  Reset Values  '></td>\n";
    print "</tr>\n";

    &CloseForm;

    &PageCloser("form.your_domain");
} # sub EditSetupPage

sub EmailTest {
    if (! &ValidateSetup) {
        &Redirect("$g_thisscript?a0=set&m=Your_system_setup_contains_invalid_items._These_are_shown_in_red.");
    } # if

    if ($g_a2 eq "pro") {
        $your_email = &Trim(lc($FORM{"email"}));

        if ((! $your_email) or (! &IsValidEmailAddress($your_email))) {
            &Redirect("$g_thisscript?a0=set&m=You_did_not_enter_a_valid_e-mail_address");
        } #if

        use MIME::Lite;
        MIME::Lite->send("sendmail", "$g_settings{'sendmail'} -t -oi -oem");

        $msg = MIME::Lite->new(
               From    => $g_settings{"system_email"},
               To      => $your_email,
               Subject => "Autoresponse Plus Send Test",
               Type    => "text/plain",
               Data    => "If you have received this message, the Autoresponse Plus e-mail engine is correctly configured and working."
        ); # $msg

        if ($msg->send) {
            &Redirect("$g_thisscript?a0=set&m=The_test_message_seemed_to_be_sent_successfully. Wait_a_minute_or_two_then_check_your_inbox.");
        } # if
        else {
            &Redirect("$g_thisscript?a0=set&m=The_test_message_could_not_be_sent");
        } # else
    } # if

    &PageHeading;
    &PageHeader("h_setup.htm");
    &PageSubHeader("System Setup &gt; E-Mail Send Test", "[<a class='subheaderlink' href='$g_thisscript?a0=set' onmouseover='ShowTooltip(13);' onmouseout='HideTooltip(13);'>Return to System Setup</a>]");

    &Spacer("1", "5");

    &OpenForm("form", "$g_thisscript?a0=set&a1=tst&a2=pro");

    print "<tr>\n";
    print "<td class='wrapcell' colspan='2' valign='middle'><p>This will test if Autoresponse is configured correctly to send e-mails.</p>\n";
    print "<p>Simply enter your e-mail address below and click <b>Send</b>. Autoresponse Plus will attempt to send a test e-mail to the address you enter.</p>\n";
    print "<p>If the test message appears in your inbox, the Autoresponse Plus e-mail engine is configured correctly. If not, go back over all of the installation instructions and try again.</p></td>\n";
    print "</tr>\n";
    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Enter your e-mail address</b></td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='email' size='$size' value=''}'></td>\n";
    print "</tr>\n";
    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Send  '></td>\n";
    print "</tr>\n";

    &CloseForm;

    &PageCloser("form.email");
} # sub EmailTest

sub CaptureTest {
    if (! &ValidateSetup) {
        &Redirect("$g_thisscript?a0=set&m=Your_system_setup_contains_invalid_items._These_are_shown_in_red.");
    } # if

    &PageHeading;
    &PageHeader("h_setup.htm");
    &PageSubHeader("System Setup &gt; E-Mail Capture Test", "[<a class='subheaderlink' href='$g_thisscript?a0=set' onmouseover='ShowTooltip(13);' onmouseout='HideTooltip(13);'>Return to System Setup</a>]");

    &Spacer("1", "5");

    &OpenForm("form", "$g_thisscript?a0=set&a1=pro");

    print "<tr>\n";
    print "<td class='wrapcell' colspan='2' valign='middle'><p>This test will check that Autoresponse Plus is correctly intercepting all e-mails sent to your domain.</p>\n";
    print "<p>This test will only work if you have set up your .forward or .procmailrc file and have entered your domain name in the <b>System Setup</b> screen. Your domain is currently set to <b>$g_settings{'your_domain'}</b>.</p>\n";
    print "<p>Simply send a blank e-mail to <b>arptest\@$g_settings{'your_domain'}</b>. Then view your subscriber list. It will contain a test subscriber called \"Test Only\" if the capturing process is working correctly. You can safely delete the test subscriber.</p>\n";
    print "<p>When you have sent the test e-mail, the time it takes to get to your domain and onto your subscriber list will depend on normal Internet delays. In most cases you should not have to wait more than a minute. <b>Note that you will not receive a reply when you do this test.</b></p>\n";
    print "<p><a href='mailto:arptest\@$g_settings{'your_domain'}'>Click here</a> to send the test e-mail.</p>\n";
    print "<p>Wait for a minute or so then...</p>\n";
    print "<p><a href='$g_thisscript?a0=cam'>Click here</a> to view the list of subscribers.</p></td>\n";
    print "</tr>\n";

    &CloseForm;

    &PageCloser("");
} # sub CaptureTest

sub ValidateSetup {
    $result = 1;

    if ((&Trim(lc($g_settings{'your_domain'})) eq 'yourdomain.com') or (! &Trim($g_settings{'your_domain'}))) {
        $result = 0;
    } # if

    if ((&Trim(lc($g_settings{'cgi_arplus_url'})) eq 'http://www.yourdomain.com/cgi-bin/arplus') or (! &Trim($g_settings{'cgi_arplus_url'}))) {
        $result = 0;
    } # if

    if ((&Trim(lc($g_settings{'support_email'})) eq "support\@yourdomain.com") or (! &Trim($g_settings{'support_email'}))) {
        $result = 0;
    } # if

    if ((&Trim(lc($g_settings{'system_email'})) eq "support\@yourdomain.com") or (! &Trim($g_settings{'system_email'}))) {
        $result = 0;
    } # if

    if ((&Trim(lc($g_settings{'sendmail'})) eq '/path/to/your/sendmail') or (! &Trim($g_settings{'sendmail'}))) {
        $result = 0;
    } # if

  return $result;
} # sub ValidateSetup

return 1;
