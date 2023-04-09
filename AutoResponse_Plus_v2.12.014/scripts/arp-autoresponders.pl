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

sub Autoresponders {
    if (! &ValidateOwner) {
        &Redirect("$g_thisscript?a0=log");
    } # if

    if ($g_a1 eq 'cre') {
        &CreateAutoresponder;
         exit;
    } # create
    elsif ($g_a1 eq 'edi') {
        &EditAutoresponder;
        exit;
    } # edit
    elsif ($g_a1 eq 'con') {
        &ConfirmDeleteAutoresponder;
        exit;
    } # confirm delete
    elsif ($g_a1 eq 'tes') {
        &TestAutoresponder;
        exit;
    } # test
    else {
        &AutoresponderList;
        exit;
    } # default action
} # sub Autoresponders

sub AutoresponderList {
    &PageHeading;
    &PageHeader("h_autoresponders.htm");
    &PageSubHeader("Autoresponders", "[<a class='subheaderlink' href='$g_thisscript?a0=aut&a1=cre' onmouseover='ShowTooltip(1);' onmouseout='HideTooltip(1);'>Create Autoresponder</a>]");

    &Spacer("1", "25");

    &ListTableHeading("Autoresponders");
    &OpenListTable;

    print "<tr>\n";

    print "<td class='listtablecolumnheaders'>\n";
    print "#\n";
    print "</td>\n";

    print "<td class='listtablecolumnheaders'>\n";
    print "Subscription address and description\n";
    print "</td>\n";

    print "<td class='listtablecolumnheaders'>\n";
    print "Status\n";
    print "</td>\n";

    print "<td class='listtablecolumnheaders'>\n";
    print "Subscribers\n";
    print "</td>\n";

    print "<td class='listtablecolumnheaders'>\n";
    print "Actions\n";
    print "</td>\n";

    print "</tr>\n";

    dbmopen(%db_aut, "$_data_path/AUT", undef);
    if ($g_settings{'file_locking'}) {flock(db_aut, 2)}

    my(@keys) = sort(keys(%db_aut));

    if (! @keys) {
        print "<tr>\n";
        print "<td class='listtableoddrow' colspan='5'>\n";
        print "There are no autoresponders\n";
        print "</td>\n";
        print "</tr>\n";
    } # if
    else {
        dbmopen(%db_cam, "$_data_path/CAM", undef);
        if ($g_settings{'file_locking'}) {flock(db_cam, 2)}
        my(%camcounter);
        @camkeys = keys(%db_cam);
        foreach $camkey (@camkeys) {
            $camfileline = $db_cam{$camkey};
            %thiscam = &data_GetRecord($camfileline);
            if ($thiscam{"status"} eq "A") {
                $camcounter{"$thiscam{'autoresponder_id'}A"} ++;
            } # if
            elsif ($thiscam{"status"} eq "S") {
                $camcounter{"$thiscam{'autoresponder_id'}S"} ++;
            } # elsif
            elsif ($thiscam{"status"} eq "U") {
                $camcounter{"$thiscam{'autoresponder_id'}U"} ++;
            } # elsif
            elsif ($thiscam{"status"} eq "F") {
                $camcounter{"$thiscam{'autoresponder_id'}F"} ++;
            } # elsif
            elsif ($thiscam{"status"} eq "X") {
                $camcounter{"$thiscam{'autoresponder_id'}X"} ++;
            } # elsif
        } # foreach
        dbmclose(%db_cam);
        if ($g_settings{'file_locking'}) {flock(db_cam, 8)}

        my($key, $fileline, %thisar);
        my($isodd) = 1;
        my($displaynum) = 1;
        foreach $key (@keys) {
            $fileline = $db_aut{$key};
            %thisar = &data_GetRecord($fileline);

            if (! $camcounter{"$thisar{'id'}A"}) {$camcounter{"$thisar{'id'}A"} = "0"}
            if (! $camcounter{"$thisar{'id'}S"}) {$camcounter{"$thisar{'id'}S"} = "0"}
            if (! $camcounter{"$thisar{'id'}U"}) {$camcounter{"$thisar{'id'}U"} = "0"}
            if (! $camcounter{"$thisar{'id'}F"}) {$camcounter{"$thisar{'id'}F"} = "0"}
            if (! $camcounter{"$thisar{'id'}X"}) {$camcounter{"$thisar{'id'}X"} = "0"}

            print "<tr>\n";

            if ($isodd) {
                print "<td class='listtableoddrow'>\n";
            } # if
            else {
                print "<td class='listtableevenrow'>\n";
            } # else
            print "$displaynum\n";
            print "</td>\n";

            if ($isodd) {
                print "<td class='listtableoddrow'>\n";
            } # if
            else {
                print "<td class='listtableevenrow'>\n";
            } # if
            print "$thisar{'listens_on'}\@$g_settings{'your_domain'}";
            print "<br>$thisar{'description'}\n";
            print "</td>\n";

            if ($isodd) {
                print "<td class='listtableoddrow'>\n";
            } # if
            else {
                print "<td class='listtableevenrow'>\n";
            } # if
            if ($thisar{'status'} eq 'A') {
                print "Active\n";
            } # if
            elsif ($thisar{'status'} eq 'S') {
                print "Suspended\n";
            } #elsif
            elsif ($thisar{'status'} eq 'D') {
                print "Dormant\n";
            } #elsif
            print "</td>\n";

            if ($isodd) {
                print "<td class='listtableoddrow'>\n";
                print "Act=$camcounter{\"$thisar{'id'}A\"} | Sus=$camcounter{\"$thisar{'id'}S\"} | Can=$camcounter{\"$thisar{'id'}U\"} | Fin=$camcounter{\"$thisar{'id'}F\"} | Failed=$camcounter{\"$thisar{'id'}X\"}\n";
            } # if
            else {
                print "<td class='listtableevenrow'>\n";
                print "Act=$camcounter{\"$thisar{'id'}A\"} | Sus=$camcounter{\"$thisar{'id'}S\"} | Can=$camcounter{\"$thisar{'id'}U\"} | Fin=$camcounter{\"$thisar{'id'}F\"} | Failed=$camcounter{\"$thisar{'id'}X\"}\n";
            } # else

            if ($isodd) {
                print "<td class='listtableoddrowlink'>\n";
                print "<a class='listtableoddrowlink' href='$g_thisscript?a0=aut&a1=edi&id=$thisar{'id'}'>Edit</a> | <a class='listtableoddrowlink' href='$g_thisscript?a0=aut&a1=tes&id=$thisar{'id'}'>Test</a> | <a class='listtableoddrowlink' href='$g_thisscript?a0=aut&a1=con&id=$thisar{'id'}'>Delete</a>\n";
            } # if
            else {
                print "<td class='listtableevenrowlink'>\n";
                print "<a class='listtableevenrowlink' href='$g_thisscript?a0=aut&a1=edi&id=$thisar{'id'}'>Edit</a> | <a class='listtableevenrowlink' href='$g_thisscript?a0=aut&a1=tes&id=$thisar{'id'}'>Test</a> | <a class='listtableevenrowlink' href='$g_thisscript?a0=aut&a1=con&id=$thisar{'id'}'>Delete</a>\n";
            } # else

            print "</td>\n";
            print "</tr>\n";

            $isodd = not $isodd;
            $displaynum ++;
        } # foreach
    } # else

    dbmclose(%db_aut);
    if ($g_settings{'file_locking'}) {flock(db_aut, 8)}

    &CloseListTable;

    &Spacer("1", "25");

    &PageCloser;
} # sub AutoresponderList

sub CreateAutoresponder {
    if ($g_a2 eq "pro") {
        $fm{"listens_on"} = &Trim(lc($FORM{"listens_on"}));
        $fm{"description"} = &Trim($FORM{"description"});
        $fm{"reply_name"} = &Trim($FORM{"reply_name"});
        $fm{"reply_email"} = &Trim(lc($FORM{"reply_email"}));
        $fm{"email_control"} = $FORM{"email_control"};
        $fm{"form_control"} = $FORM{"form_control"};
        $fm{"status"} = $FORM{"status"};
        $g_message = &validate_CreateAutoresponder(%fm);
        if (! $g_message) {
            my(%ar) = &data_New("AUT");
            $ar{"listens_on"} = $fm{"listens_on"};
            $ar{"description"} = $fm{"description"};
            $ar{"reply_name"} = $fm{"reply_name"};
            $ar{"reply_email"} = $fm{"reply_email"};
            $ar{"email_control"} = $fm{"email_control"};
            $ar{"form_control"} = $fm{"form_control"};
            $ar{"status"} = $fm{"status"};
            &data_Save(%ar);
            &Redirect("$g_thisscript?a0=aut&a1=edi&id=$ar{'id'}");
        } # if
    } # if
    else {
        my(%ar) = &data_New("AUT");
        $fm{"listens_on"} = $ar{"listens_on"};
        $fm{"description"} = $ar{"description"};
        $fm{"reply_name"} = $ar{"reply_name"};
        $fm{"reply_email"} = $ar{"reply_email"};
        $fm{"email_control"} = $ar{"email_control"};
        $fm{"form_control"} = $ar{"form_control"};
        $fm{"status"} = $ar{"status"};
    } # else

    &AutoresponderCreatePage(%fm);
} # sub CreateAutoresponder

sub AutoresponderCreatePage {
    my(%fm) = @_;

    &PageHeading;
    &PageHeader("h_aut_create.htm");
    &PageSubHeader("Autoresponders &gt; Create", "[<a class='subheaderlink' href='$g_thisscript?a0=aut' onmouseover='ShowTooltip(2);' onmouseout='HideTooltip(2);'>Return to Autoresponder List</a>]");

    &Spacer("1", "5");

    &OpenForm("form", "$g_thisscript?a0=aut&a1=cre&a2=pro");
    
    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>From name</b><br>eg Your Company Name</td>\n";
    $size = &FieldSize(30);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='reply_name' size='$size' value='$fm{'reply_name'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Reply address</b><br>eg sales\@yourcompany.com</td>\n";
    $size = &FieldSize(30);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='reply_email' size='$size' value='$fm{'reply_email'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Subscription address</b><br>eg info or course</td>\n";
    $size = &FieldSize(15);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='listens_on' size='$size' value='$fm{'listens_on'}'>\@$g_settings{'your_domain'}</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Description</b><br>eg 5 day web marketing course</td>\n";
    $size = &FieldSize(30);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='description' size='$size' value='$fm{'description'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Initial status</b></td>\n";

    if ($fm{"status"} eq "A") {
        print "<td class='formcell' width='50%' valign='middle'><select name='status' size='1'><option value='A' selected>Active</option><option value='S'>Suspended</option><option value='D'>Dormant</option></select></td>\n";
    } # if
    elsif ($fm{"status"} eq "S") {
        print "<td class='formcell' width='50%' valign='middle'><select name='status' size='1'><option value='A'>Active</option><option value='S' selected>Suspended</option><option value='D'>Dormant</option></select></td>\n";
    } # elsif
    elsif ($fm{"status"} eq "D") {
        print "<td class='formcell' width='50%' valign='middle'><select name='status' size='1'><option value='A'>Active</option><option value='S'>Suspended</option><option value='D' selected>Dormant</option></select></td>\n";
    } # elsif

    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>E-mail control</b><br>Allow subscripion and unsubscription via e-mail?</td>\n";

    if ($fm{"email_control"}) {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='email_control' value='1' checked></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='email_control' value='1'></td>\n";
    } # else

    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Form control</b><br>Allow subscripion via a web form?</td>\n";

    if ($fm{"form_control"}) {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='form_control' value='1' checked></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='form_control' value='1'></td>\n";
    } # else

    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Create  '></td>\n";
    print "</tr>\n";

    &CloseForm;

    &Spacer("1", "5");

    &PageCloser ('form.reply_name');
} # sub AutoresponderCreatePage

sub ConfirmDeleteAutoresponder {
    $fm{"id"} = $INFO{"id"};

    if ($g_a2 eq 'pro') {
        &DeleteAutoresponder($fm{"id"});
        &Redirect("$g_thisscript?a0=aut");
    } # if

    my(%ar) = &data_Load($fm{"id"});

    &PageHeading;
    &PageHeader("h_aut_delete.htm");
    &PageSubHeader("Autoresponders &gt; Confirm Delete", "[<a class='subheaderlink' href='$g_thisscript?a0=aut' onmouseover='ShowTooltip(2);' onmouseout='HideTooltip(2);'>Return to Autoresponder List</a>]");

    &Spacer("1", "25");

    &InfoHeading("$ar{'listens_on'}\@$g_settings{'your_domain'}");
    &InfoBox("Description: $ar{'description'}");

    &OpenForm("form", "$g_thisscript?a0=aut&a1=con&a2=pro&id=$fm{'id'}");

    print "<tr>\n";
    print "<td class='wrapcell' colspan='2' valign='middle'><p>When you click <b>Confirm Delete</b>, all messages, headers and footers for this autoresponder will also be deleted permanently.</p><p>Any active follow-up sequences for this autoresponder will not be completed.</p></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Confirm Delete  '></td>\n";
    print "</tr>\n";

    &CloseForm;

    &PageCloser('');
} # sub ConfirmDeleteAutoresponder

sub DeleteAutoresponder {
    my($arid) = @_;
    my(%ar) = &data_Load($arid);

    if (! %ar) {return}

    unlink ("$_data_path/$ar{'header_file_id'}.hed");
    unlink ("$_data_path/$ar{'html_header_file_id'}.hed");
    unlink ("$_data_path/$ar{'footer_file_id'}.foo");
    unlink ("$_data_path/$ar{'html_footer_file_id'}.foo");

    my(@message_keys) = split(/\|/, $ar{"message_order"});
    shift(@message_keys);

    my($key, %thismes);
    foreach $key (@message_keys) {
        %thismes = &data_Load($key);
        unlink ("$_data_path/$thismes{'plain_file_id'}.mes");
        unlink ("$_data_path/$thismes{'html_file_id'}.mes");
    } # foreach

    &data_Delete($arid);
} # sub DeleteAutoresponder

sub EditAutoresponder {
    my(%fm);
    $fm{"id"} = $INFO{"id"};

    if ($g_a2 eq 'add') {
        my($mid) = &AddMessage(%fm);
        &Redirect("$g_thisscript?a0=aut&a1=edi&a2=edi&mid=$mid");
    } # add
    elsif ($g_a2 eq 'pro') {
        &AutoresponderProperties(%fm);
        exit;
    } # properties
    elsif ($g_a2 eq 'edi') {
        &EditMessage(%fm);
        exit;
    } # edit
    elsif ($g_a2 eq 'con') {
        &ConfirmDeleteMessage(%fm);
        exit;
    } # confirm delete
    elsif ($g_a2 eq 'up') {
        &UpMessage(%fm);
        exit;
    } # up
    elsif ($g_a2 eq 'dow') {
        &DownMessage(%fm);
        exit;
    } # down
    elsif ($g_a2 eq 'pag') {
        &AutoresponderPageSetup(%fm);
        exit;
    } # page setup
    elsif ($g_a2 eq 'gen') {
        &AutoresponderGenCode(%fm);
        exit;
    } # generate code
    else {
        &MessageList(%fm);
        exit;
    } # default action
} # sub EditAutoresponder

sub MessageList {
    my(%fm) = @_;

    dbmopen(%db_aut, "$_data_path/AUT", undef);
    if ($g_settings{'file_locking'}) {flock(db_aut, 2)}

    my(@keys) = sort(keys(%db_aut));
    my($fileline) = $db_aut{$fm{"id"}};
    my(%ar) = &data_GetRecord($fileline);

    &PageHeading;
    &PageHeader("h_aut_edit.htm");
    &PageSubHeader("Autoresponders &gt; Edit", "[<a class='subheaderlink' href='$g_thisscript?a0=aut' onmouseover='ShowTooltip(2);' onmouseout='HideTooltip(2);'>Return to Autoresponder List</a> | <a class='subheaderlink' href='$g_thisscript?a0=aut&a1=edi&a2=add&id=$fm{'id'}' onmouseover='ShowTooltip(3);' onmouseout='HideTooltip(3);'>Add Message</a> | <a class='subheaderlink' href='$g_thisscript?a0=aut&a1=edi&a2=pro&id=$fm{'id'}' onmouseover='ShowTooltip(4);' onmouseout='HideTooltip(4);'>Properties</a> | <a class='subheaderlink' href='$g_thisscript?a0=aut&a1=edi&a2=pag&id=$fm{'id'}' onmouseover='ShowTooltip(5);' onmouseout='HideTooltip(5);'>Page Layout</a> | <a class='subheaderlink' href='$g_thisscript?a0=aut&a1=edi&a2=gen&id=$fm{'id'}' onmouseover='ShowTooltip(6);' onmouseout='HideTooltip(6);'>Generate Code</a>]");

    &Spacer("1", "25");

    &ListTableHeading("$ar{'listens_on'}\@$g_settings{'your_domain'}");
    &OpenListTable;

    print "<tr>\n";

    print "<td class='listtablecolumnheaders'>\n";
    print "#\n";
    print "</td>\n";

    print "<td class='listtablecolumnheaders'>\n";
    print "Subject\n";
    print "</td>\n";

    print "<td class='listtablecolumnheaders'>\n";
    print "Schedule\n";
    print "</td>\n";

    print "<td class='listtablecolumnheaders'>\n";
    print "Actions\n";
    print "</td>\n";

    print "</tr>\n";

    my(@message_keys) = split(/\|/, $ar{"message_order"});
    shift(@message_keys);

    if (! @message_keys) {
        print "<tr>\n";
        print "<td class='listtableoddrow' colspan='4'>\n";
        print "There are no messages\n";
        print "</td>\n";
        print "</tr>\n";
    } # if
    else {
        my($message_key, $message_fileline, %thismessage);
        my($isodd) = 1;
        my($counter) = 1;
        my($has_immediate) = 0;
        dbmopen(%db_mes, "$_data_path/MES", undef);
        if ($g_settings{'file_locking'}) {flock(db_mes, 2)}
        foreach $message_key (@message_keys) {
            $message_fileline = $db_mes{$message_key};
            %thismessage = &data_GetRecord($message_fileline);

            print "<tr>\n";

            if ($isodd) {
                print "<td class='listtableoddrow'>\n";
            } # if
            else {
                print "<td class='listtableevenrow'>\n";
            } # else
            print "$counter\n";
            print "</td>\n";

            if ($isodd) {
                print "<td class='listtableoddrow'>\n";
            } # if
            else {
                print "<td class='listtableevenrow'>\n";
            } # if
            print "$thismessage{'subject'}\n";
            print "</td>\n";

            if ($isodd) {
                print "<td class='listtableoddrow'>\n";
            } # if
            else {
                print "<td class='listtableevenrow'>\n";
            } # if
            if ($thismessage{"id"} eq $ar{"immediate_message_id"}) {
                $has_immediate = 1;
                print "Immediate\n";
            } # if
            elsif ($thismessage{"schedule"} eq "NEX") {
                print "At next run\n";
            } # elsif
            elsif ($thismessage{"schedule"} eq "1") {
                print "Monday\n";
            } # elsif
            elsif ($thismessage{"schedule"} eq "2") {
                print "Tuesday\n";
            } # elsif
            elsif ($thismessage{"schedule"} eq "3") {
                print "Wednesday\n";
            } # elsif
            elsif ($thismessage{"schedule"} eq "4") {
                print "Thursday\n";
            } # elsif
            elsif ($thismessage{"schedule"} eq "5") {
                print "Friday\n";
            } # elsif
            elsif ($thismessage{"schedule"} eq "6") {
                print "Saturday\n";
            } # elsif
            elsif ($thismessage{"schedule"} eq "7") {
                print "Sunday\n";
            } # elsif
            else {
                if ($thismessage{'interval'} == 1) {
                    print "$thismessage{'interval'} day\n";
                } # if
                else {
                    print "$thismessage{'interval'} days\n";
                } # else
            } # else
            print "</td>\n";

            if ($isodd) {
                print "<td class='listtableoddrowlink'>\n";
                print "<a class='listtableoddrowlink' href='$g_thisscript?a0=aut&a1=edi&a2=edi&mid=$thismessage{'id'}'>Edit</a> | <a class='listtableoddrowlink' href='$g_thisscript?a0=aut&a1=edi&a2=con&mid=$thismessage{'id'}'>Delete</a>\n";

                if (($counter == 1) or (($counter == 2) and ($has_immediate))) {
                    print " | Move Up";
                } # if
                else {
                    print " | <a class='listtableoddrowlink' href='$g_thisscript?a0=aut&a1=edi&a2=up&mid=$thismessage{'id'}'>Move Up</a>";
                } # else

                if (($counter == ($#message_keys+1)) or (($counter == 1) and ($has_immediate))) {
                    print " | Move Down";
                } # if
                else {
                    print " | <a class='listtableoddrowlink' href='$g_thisscript?a0=aut&a1=edi&a2=dow&mid=$thismessage{'id'}'>Move Down</a>";
                } # else
            } # if
            else {
                print "<td class='listtableevenrowlink'>\n";
                print "<a class='listtableevenrowlink' href='$g_thisscript?a0=aut&a1=edi&a2=edi&mid=$thismessage{'id'}'>Edit</a> | <a class='listtableevenrowlink' href='$g_thisscript?a0=aut&a1=edi&a2=con&mid=$thismessage{'id'}'>Delete</a>\n";

                if (($counter == 1) or (($counter == 2) and ($has_immediate))) {
                    print " | Move Up";
                } # if
                else {
                    print " | <a class='listtableevenrowlink' href='$g_thisscript?a0=aut&a1=edi&a2=up&mid=$thismessage{'id'}'>Move Up</a>";
                } # else

                if (($counter == ($#message_keys+1)) or (($counter == 1) and ($has_immediate))) {
                    print " | Move Down";
                } # if
                else {
                    print " | <a class='listtableevenrowlink' href='$g_thisscript?a0=aut&a1=edi&a2=dow&mid=$thismessage{'id'}'>Move Down</a>";
                } # else
            } # else

            print "</td>\n";
            print "</tr>\n";

            $isodd = not $isodd;
            $counter++;
        } # foreach
    } # else

    dbmclose(%db_aut);
    if ($g_settings{'file_locking'}) {flock(db_aut, 8)}
    dbmclose(%db_mes);
    if ($g_settings{'file_locking'}) {flock(db_mes, 8)}

    &CloseListTable;

    &Spacer("1", "25");

    &PageCloser('');
} # sub MessageList

sub AddMessage {
    my(%fm) = @_;

    my(%message) = &data_New("MES");
    $message{"parent_id"} = $fm{"id"};
    &data_Save(%message);

    my(%ar) = &data_Load($fm{"id"});
    $ar{"message_order"} = $ar{"message_order"} . "|" . $message{"id"};
    &data_Save(%ar);

    return $message{"id"};
} # sub AddMessage

sub AutoresponderProperties {
    my(%fm) = @_;

    if ($g_a3 eq "pro") {
        $fm{"listens_on"} = &Trim(lc($FORM{"listens_on"}));
        $fm{"description"} = &Trim($FORM{"description"});
        $fm{"reply_name"} = &Trim($FORM{"reply_name"});
        $fm{"reply_email"} = &Trim(lc($FORM{"reply_email"}));
        $fm{"email_control"} = $FORM{"email_control"};
        $fm{"form_control"} = $FORM{"form_control"};
        $fm{"status"} = $FORM{"status"};
        $fm{"old_listens_on"} = $FORM{"old_listens_on"};
        $g_message = &validate_EditAutoresponderProperties(%fm);
        if (! $g_message) {
            my(%ar) = &data_Load($fm{'id'});
            $ar{"listens_on"} = $fm{"listens_on"};
            $ar{"description"} = $fm{"description"};
            $ar{"reply_name"} = $fm{"reply_name"};
            $ar{"reply_email"} = $fm{"reply_email"};
            $ar{"email_control"} = $fm{"email_control"};
            $ar{"form_control"} = $fm{"form_control"};
            $ar{"status"} = $fm{"status"};
            &data_Save(%ar);
            &Redirect("$g_thisscript?a0=aut&a1=edi&id=$ar{'id'}");
        } # if
    } # if
    else {
        my(%ar) = &data_Load($fm{'id'});
        $fm{"listens_on"} = $ar{"listens_on"};
        $fm{"description"} = $ar{"description"};
        $fm{"reply_name"} = $ar{"reply_name"};
        $fm{"reply_email"} = $ar{"reply_email"};
        $fm{"email_control"} = $ar{"email_control"};
        $fm{"form_control"} = $ar{"form_control"};
        $fm{"status"} = $ar{"status"};
    } # else

    &AutoresponderPropertiesPage(%fm);
} # sub AutoresponderProperties

sub AutoresponderPropertiesPage {
    my(%fm) = @_;

    my(%ar) = &data_Load($fm{'id'});

    &PageHeading;
    &PageHeader("h_aut_properties.htm");
    &PageSubHeader("Autoresponders &gt; Edit &gt; Properties", "[<a class='subheaderlink' href='$g_thisscript?a0=aut&a1=edi&id=$fm{'id'}' onmouseover='ShowTooltip(7);' onmouseout='HideTooltip(7);'>Return to Message List</a>]");

    &Spacer("1", "25");

    &InfoHeading("$ar{'listens_on'}\@$g_settings{'your_domain'}");
    &InfoBox("Description: $ar{'description'}");

    &OpenForm("form", "$g_thisscript?a0=aut&a1=edi&a2=pro&a3=pro&id=$fm{'id'}");
    
    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>From name</b><br>eg Your Company Name</td>\n";
    $size = &FieldSize(30);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='reply_name' size='$size' value='$fm{'reply_name'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Reply address</b><br>eg sales\@yourcompany.com</td>\n";
    $size = &FieldSize(30);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='reply_email' size='$size' value='$fm{'reply_email'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Subscription address</b><br>eg info or course</td>\n";
    $size = &FieldSize(15);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='listens_on' size='$size' value='$fm{'listens_on'}'>\@$g_settings{'your_domain'}</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Description</b><br>eg 5 day web marketing course</td>\n";
    $size = &FieldSize(30);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='description' size='$size' value='$fm{'description'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Status</b></td>\n";

    if ($fm{"status"} eq "A") {
        print "<td class='formcell' width='50%' valign='middle'><select name='status' size='1'><option value='A' selected>Active</option><option value='S'>Suspended</option><option value='D'>Dormant</option></select></td>\n";
    } # if
    elsif ($fm{"status"} eq "S") {
        print "<td class='formcell' width='50%' valign='middle'><select name='status' size='1'><option value='A'>Active</option><option value='S' selected>Suspended</option><option value='D'>Dormant</option></select></td>\n";
    } # elsif
    elsif ($fm{"status"} eq "D") {
        print "<td class='formcell' width='50%' valign='middle'><select name='status' size='1'><option value='A'>Active</option><option value='S'>Suspended</option><option value='D' selected>Dormant</option></select></td>\n";
    } # elsif

    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>E-mail control</b><br>Allow subscripion and unsubscription via e-mail?</td>\n";

    if ($fm{"email_control"}) {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='email_control' value='1' checked></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='email_control' value='1'></td>\n";
    } # else

    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Form control</b><br>Allow subscripion via a web form?</td>\n";

    if ($fm{"form_control"}) {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='form_control' value='1' checked></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='form_control' value='1'></td>\n";
    } # else

    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Save Changes  '> <input type='reset' value='  Reset Values  '>\n";
    print "<input type='hidden' name='old_listens_on' value='$ar{'listens_on'}'>\n";
    print "</td>\n";
    print "</tr>\n";

    &CloseForm;

    &Spacer("1", "5");

    &PageCloser ('form.reply_name');
} # sub AutoresponderPropertiesPage

sub AutoresponderPageSetup {
    my(%fm) = @_;
    $fm{"id"} = $INFO{"id"};

    if ($g_a3 eq 'pro') {
        %ar = &data_Load($fm{'id'});
        $ar{'unsubscribe_link'} = $FORM{'unsubscribe_link'};
        $ar{'affiliate_link'} = $FORM{'affiliate_link'};
        &data_Save(%ar);
        &SaveText($FORM{'header_text'}, "$_data_path/$ar{'header_file_id'}.hed");
        &SaveText($FORM{'html_header_text'}, "$_data_path/$ar{'html_header_file_id'}.hed");
        &SaveText($FORM{'footer_text'}, "$_data_path/$ar{'footer_file_id'}.foo");
        &SaveText($FORM{'html_footer_text'}, "$_data_path/$ar{'html_footer_file_id'}.foo");
        &Redirect("$g_thisscript?a0=aut&a1=edi&id=$fm{'id'}");
    } # if

    my(%ar) = &data_Load($fm{'id'});
    my($header_text) = &LoadText("$_data_path/$ar{'header_file_id'}.hed");
    my($html_header_text) = &LoadText("$_data_path/$ar{'html_header_file_id'}.hed");
    my($footer_text) = &LoadText("$_data_path/$ar{'footer_file_id'}.foo");
    my($html_footer_text) = &LoadText("$_data_path/$ar{'html_footer_file_id'}.foo");

    &PageHeading;
    &PageHeader("h_aut_pagesetup.htm");
    &PageSubHeader("Autoresponders &gt; Edit &gt; Page Layout", "[<a class='subheaderlink' href='$g_thisscript?a0=aut&a1=edi&id=$fm{'id'}' onmouseover='ShowTooltip(7);' onmouseout='HideTooltip(7);'>Return to Message List</a>]");

    &Spacer("1", "25");

    &InfoHeading("$ar{'listens_on'}\@$g_settings{'your_domain'}");
    &InfoBox("Description: $ar{'description'}");

    &OpenForm("form", "$g_thisscript?a0=aut&a1=edi&a2=pag&a3=pro&id=$fm{'id'}");
    
    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Include unsubscribe link?</b><br>Append to all messages?</td>\n";
    if ($ar{"unsubscribe_link"}) {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='unsubscribe_link' value='1' checked></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='unsubscribe_link' value='1'></td>\n";
    } # else
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Include affiliate link?</b><br>Append to all messages?</td>\n";
    if ($ar{"affiliate_link"}) {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='affiliate_link' value='1' checked></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='affiliate_link' value='1'></td>\n";
    } # else
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>Plain Message Header Text</b><br>Type or use CTRL+V to paste from clipboard</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    $size = &FieldSize(70);
    print "<td class='formcell' colspan='2' align='center'><textarea rows='8' name='header_text' cols='$size'>\n";
    $header_text = &EncodeHTML($header_text);
    print $header_text;
    print "</textarea>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>HTML Message Header Code</b><br>Type or use CTRL+V to paste from clipboard</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    $size = &FieldSize(70);
    print "<td class='formcell' colspan='2' align='center'><textarea rows='8' name='html_header_text' cols='$size'>\n";
    $html_header_text = &EncodeHTML($html_header_text);
    print $html_header_text;
    print "</textarea>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>Plain Message Footer Text</b><br>Type or use CTRL+V to paste from clipboard</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    $size = &FieldSize(70);
    print "<td class='formcell' colspan='2' align='center'><textarea rows='8' name='footer_text' cols='$size'>\n";
    $footer_text = &EncodeHTML($footer_text);
    print $footer_text;
    print "</textarea>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>HTML Message Footer Code</b><br>Type or use CTRL+V to paste from clipboard</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    $size = &FieldSize(70);
    print "<td class='formcell' colspan='2' align='center'><textarea rows='8' name='html_footer_text' cols='$size'>\n";
    $html_footer_text = &EncodeHTML($html_footer_text);
    print $html_footer_text;
    print "</textarea>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Save Changes  '> <input type='reset' value='  Reset Values  '></td>\n";
    print "</tr>\n";

    &CloseForm;

    &Spacer("1", "5");

    &PageCloser ('');
} # sub AutoresponderPageSetup

sub AutoresponderGenCode {
    my(%fm) = @_;

    if ($g_a3 eq "pro") {
        $fm{"first_name"} = &Trim($FORM{"first_name"});
        $fm{"last_name"} = &Trim($FORM{"last_name"});
        $fm{"autoresponder_2"} = &Trim($FORM{"autoresponder_2"});
        $fm{"autoresponder_3"} = &Trim($FORM{"autoresponder_3"});
        $fm{"tracking_tag"} = &Trim($FORM{"tracking_tag"});
        $fm{"format"} = $FORM{"format"};
        $fm{"link_text"} = $FORM{"link_text"};
    } # if
    else {
        $fm{"first_name"} = "";
        $fm{"last_name"} = "";
        $fm{"tracking_tag"} = "";
        $fm{"autoresponder_2"} = "NONE";
        $fm{"autoresponder_3"} = "NONE";
        $fm{"format"} = "";
        $fm{"link_text"} = "";
    } # else

    my(%ar) = &data_Load($fm{"id"});

    &PageHeading;
    &PageHeader("h_aut_generatecode.htm");
    &PageSubHeader("Autoresponders &gt; Edit &gt; Generate Code", "[<a class='subheaderlink' href='$g_thisscript?a0=aut&a1=edi&id=$fm{'id'}' onmouseover='ShowTooltip(7);' onmouseout='HideTooltip(7);'>Return to Message List</a>]");

    &Spacer("1", "25");

    &InfoHeading("$ar{'listens_on'}\@$g_settings{'your_domain'}");
    &InfoBox("Description: $ar{'description'}<br>Autoresponder ID: $ar{'id'}");

    &OpenForm("form", "$g_thisscript?a0=aut&a1=edi&a2=gen&a3=pro&id=$fm{'id'}");
    
    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Ask for first name?</b><br>Only applies to web based forms</td>\n";
    if ($fm{"first_name"}) {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='first_name' value='1' checked></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='first_name' value='1'></td>\n";
    } # else
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Ask for last name?</b><br>Only applies to web based forms</td>\n";
    if ($fm{"last_name"}) {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='last_name' value='1' checked></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='last_name' value='1'></td>\n";
    } # else
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>2nd autoresponder</b><br>Only applies to web based forms</td>\n";
    print "<td class='formcell' width='50%' valign='middle'>\n";
    dbmopen(%db_aut, "$_data_path/AUT", undef);
    if ($g_settings{'file_locking'}) {flock(db_aut, 2)}
    my(@keys) = sort(keys(%db_aut));
    if (@keys) {
        print "<select name='autoresponder_2' size='1'>\n";

        if ($fm{"autoresponder_2"} eq "NONE") {
            print "<option value='NONE' selected>None</option>";
        } # if
        else {
            print "<option selected value='NONE'>None</option>";
        } # else

        my($key, $fileline, %thisar);
        foreach $key (@keys) {
            $fileline = $db_aut{$key};
            %thisar = &data_GetRecord($fileline);
            if ($fm{'autoresponder_2'} eq $thisar{'id'}) {
                print "<option value='$thisar{'id'}' selected>$thisar{'listens_on'}\@$g_settings{'your_domain'}</option>\n";
            } # if
            else {
                print "<option value='$thisar{'id'}'>$thisar{'listens_on'}\@$g_settings{'your_domain'}</option>\n";
            } # else
        } # foreach
        print "</select>\n";
    } # if
    else {
        print "There are no autoresponders\n";
    } # else
    dbmclose(%db_aut);
    if ($g_settings{'file_locking'}) {flock(db_aut, 8)}

    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>3rd autoresponder</b><br>Only applies to web based forms</td>\n";
    print "<td class='formcell' width='50%' valign='middle'>\n";
    dbmopen(%db_aut, "$_data_path/AUT", undef);
    if ($g_settings{'file_locking'}) {flock(db_aut, 2)}
    my(@keys) = sort(keys(%db_aut));
    if (@keys) {
        print "<select name='autoresponder_3' size='1'>\n";

        if ($fm{"autoresponder_3"} eq "NONE") {
            print "<option value='NONE' selected>None</option>";
        } # if
        else {
            print "<option selected value='NONE'>None</option>";
        } # else

        my($key, $fileline, %thisar);
        foreach $key (@keys) {
            $fileline = $db_aut{$key};
            %thisar = &data_GetRecord($fileline);
            if ($fm{'autoresponder_3'} eq $thisar{'id'}) {
                print "<option value='$thisar{'id'}' selected>$thisar{'listens_on'}\@$g_settings{'your_domain'}</option>\n";
            } # if
            else {
                print "<option value='$thisar{'id'}'>$thisar{'listens_on'}\@$g_settings{'your_domain'}</option>\n";
            } # else
        } # foreach
        print "</select>\n";
    } # if
    else {
        print "There are no autoresponders\n";
    } # else
    dbmclose(%db_aut);
    if ($g_settings{'file_locking'}) {flock(db_aut, 8)}

    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Tracking tag to include</b></td>\n";
    print "<td class='formcell' valign='middle'><select name='tracking_tag' size='1'>";
    if ($fm{"tracking_tag"} eq "NONE") {
        print "<option value='NONE' selected>None</option>";
    } # if
    else {
        print "<option selected value='NONE'>None</option>";
    } # else
    dbmopen(%db_tra, "$_data_path/TRA", undef);
    if ($g_settings{'file_locking'}) {flock(db_tra, 2)}
    my(@keys) = sort(keys(%db_tra));
    my($key, $fileline, %thistt);
    foreach $key (@keys) {
        $fileline = $db_tra{$key};
        %thistt = &data_GetRecord($fileline);

        if ($fm{"tracking_tag"} eq $thistt{"tag"}) {
            print "<option value='$thistt{'tag'}' selected>$thistt{'tag'}</option>";
        } #if
        else {
            print "<option value='$thistt{'tag'}'>$thistt{'tag'}</option>";
        } # else
    } # foreach
    dbmclose(%db_tra);
    if ($g_settings{'file_locking'}) {flock(db_tra, 8)}
    print "</select>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Offer choice of format?</b><br>Only applies to web based forms</td>\n";
    if ($fm{"format"}) {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='format' value='1' checked></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='format' value='1'></td>\n";
    } # else
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Link text</b><br>For web page links</td>\n";
    $size = &FieldSize(30);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='link_text' size='$size' value='$fm{'link_text'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Generate Code  '> <input type='reset' value='  Reset Values  '></td>\n";
    print "</tr>\n";

    if ($g_a3 eq 'pro') {
        print "<tr>\n";
        print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>Web Based Forms</b><br>Select and copy the code below</td>\n";
        print "</tr>\n";

        print "<tr>\n";
        $size = &FieldSize(70);
        print "<td class='formcell' colspan='2' align='center'><textarea rows='8' name='formcode' cols='$size'>\n";

        $html_code  = "<form method='POST' action='$g_settings{'cgi_arplus_url'}/formcapture.pl'>\n";

        if ($fm{"first_name"}) {
            $html_code .= "<div align='center'><center>\n";
            $html_code .= "<p>First name<br><input type='text' name='first_name' size='20'></p>\n";
            $html_code .= "</center></div>\n";
        } # if

        if ($fm{"last_name"}) {
            $html_code .= "<div align='center'><center>\n";
            $html_code .= "<p>Last name<br><input type='text' name='last_name' size='20'></p>\n";
            $html_code .= "</center></div>\n";
        } # if

        $html_code .= "<div align='center'><center>\n";
        $html_code .= "<p>E-mail address<br><input type='text' name='email' size='20'></p>\n";
        $html_code .= "</center></div>\n";

        if ($fm{"format"}) {
            $html_code .= "<div align='center'><center>\n";
            $html_code .= "<p>Plain text <input type='radio' value='T' checked name='format'>HTML <input type='radio' name='format' value='H'></p>\n";
            $html_code .= "</center></div>\n";
        } # if

        $html_code .= "<div align='center'><center>\n";
        $html_code .= "<p><input type='submit' value='Subscribe'></p>\n";
        $html_code .= "</center></div>\n";

        if ($fm{"tracking_tag"} ne "NONE") {
            $html_code .= "<input type='hidden' name='tracking_tag' value='$fm{'tracking_tag'}'>\n";
        } # if

        $html_code .= "<input type='hidden' name='id' value='$ar{'id'}'>\n";

        if ($fm{"autoresponder_2"} ne "NONE") {
            $html_code .= "<input type='hidden' name='ar_2' value='$fm{'autoresponder_2'}'>\n";
        } # if

        if ($fm{"autoresponder_3"} ne "NONE") {
            $html_code .= "<input type='hidden' name='ar_3' value='$fm{'autoresponder_3'}'>\n";
        } # if

        $html_code .= "</form>";

        $html_code = &EncodeHTML($html_code);
        print $html_code;

        print "</textarea>\n";
        print "</td>\n";
        print "</tr>\n";

        print "<tr>\n";
        print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>Web Page Mailto Link Code</b><br>Select and copy the code below</td>\n";
        print "</tr>\n";

        print "<tr>\n";
        $size = &FieldSize(70);
        print "<td class='formcell' colspan='2' align='center'><textarea rows='8' name='weblinkcode' cols='$size'>\n";

        $html_code  = "<a href='mailto:$ar{'listens_on'}\@$g_settings{'your_domain'}";

        if ($fm{"tracking_tag"} ne "NONE") {
            $html_code .= "?subject=TRA$fm{'tracking_tag'}";
        } # if

        if (&Trim($fm{'link_text'})) {
            $html_code .= "'>$fm{'link_text'}</a>";
        } # if
        else {
            $html_code .= "'>$ar{'listens_on'}\@$g_settings{'your_domain'}</a>";
        } # else

        $html_code = &EncodeHTML($html_code);
        print $html_code;

        print "</textarea>\n";
        print "</td>\n";
        print "</tr>\n";

        print "<tr>\n";
        print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>General Mailto Link Code</b><br>Select and copy the code below</td>\n";
        print "</tr>\n";

        print "<tr>\n";
        $size = &FieldSize(70);
        print "<td class='formcell' colspan='2' align='center'><textarea rows='8' name='emaillinkcode' cols='$size'>\n";

        $html_code  = "mailto:$ar{'listens_on'}\@$g_settings{'your_domain'}";

        if ($fm{"tracking_tag"} ne "NONE") {
            $html_code .= "?subject=TRA$fm{'tracking_tag'}";
        } # if

        $html_code = &EncodeHTML($html_code);
        print $html_code;

        print "</textarea>\n";
        print "</td>\n";
        print "</tr>\n";
    } # if

    &CloseForm;

    &Spacer("1", "5");

    &PageCloser ('form.first_name');
} # sub AutoresponderGenCode

sub ConfirmDeleteMessage {
    my(%fm) = @_;
    $fm{"mid"} = $INFO{"mid"};

    my(%message) = &data_Load($fm{"mid"});
    my(%ar) = &data_Load($message{"parent_id"});

    if ($g_a3 eq 'pro') {
        $ar{"message_order"} =~ s/\|$fm{"mid"}//g;
        &data_Save(%ar);
        unlink ("$_data_path/$message{'plain_file_id'}.mes");
        unlink ("$_data_path/$message{'html_file_id'}.mes");
        &data_Delete($fm{"mid"});
        &Redirect("$g_thisscript?a0=aut&a1=edi&id=$ar{'id'}");
    } # if

    &PageHeading;
    &PageHeader("h_aut_deletemessage.htm");
    &PageSubHeader("Autoresponders &gt; Confirm Delete Message", "[<a class='subheaderlink' href='$g_thisscript?a0=aut&a1=edi&id=$ar{'id'}' onmouseover='ShowTooltip(7);' onmouseout='HideTooltip(7);'>Return to Message List</a>]");

    &Spacer("1", "25");

    &InfoHeading("$ar{'listens_on'}\@$g_settings{'your_domain'}");
    &InfoBox("Subject: $message{'subject'}");

    &OpenForm("form", "$g_thisscript?a0=aut&a1=edi&a2=con&a3=pro&mid=$fm{'mid'}");

    print "<tr>\n";
    print "<td class='wrapcell' colspan='2' valign='middle'><p>When you click <b>Confirm Delete</b>, this message will be deleted permanently.</p></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Confirm Delete  '></td>\n";
    print "</tr>\n";

    &CloseForm;

    &PageCloser ('');
} # sub ConfirmDeleteMessage

sub EditMessage {
    my(%fm) = @_;
    $fm{"mid"} = $INFO{"mid"};

    if ($g_a3 eq 'pro') {
        $fm{'subject'} = &Trim($FORM{'subject'});
        $fm{'schedule'} = $FORM{'schedule'};
        $fm{'interval'} = &Trim($FORM{'interval'});
        $fm{'attachments'} = &Trim($FORM{'attachments'});
        $fm{'default_format'} = &Trim($FORM{'default_format'});
        $fm{'use_header'} = $FORM{'use_header'};
        $fm{'use_footer'} = $FORM{'use_footer'};
        $fm{"plain_text"} = $FORM{"plain_text"};
        $fm{"html_text"} = $FORM{"html_text"};
        $g_message = &validate_EditMessage(%fm);
        if (! $g_message) {
            my(%message) = &data_Load($fm{"mid"});
            my(%ar) = &data_Load($message{"parent_id"});
            $message{"subject"} = $fm{"subject"};
            $message{"interval"} = $fm{"interval"};
            $message{"attachments"} = $fm{"attachments"};
            $message{"default_format"} = $fm{"default_format"};
            $message{"use_header"} = $fm{"use_header"};
            $message{"use_footer"} = $fm{"use_footer"};
            $message{"schedule"} = $fm{"schedule"};
            &data_Save(%message);
            if ($fm{"schedule"} eq "IMM") {
                %immmess = &data_Load($ar{"immediate_message_id"});
                if (%immmess) {
                    $immmess{"schedule"} = "INT";
                    if (! $immmess{"interval"}) {
                        $immmess{"interval"} = 1;
                    } # if
                    &data_Save(%immmess);
                } # if
                $ar{"immediate_message_id"} = $message{"id"};
                $ar{"message_order"} =~ s/\|$message{"id"}//g;
                $ar{"message_order"} = "|" . $message{"id"} . $ar{"message_order"};
            } # if
            else {
                if ($ar{"immediate_message_id"} eq $message{"id"}) {
                    $ar{"immediate_message_id"} = "";
                } # if
            } # else
            &data_Save(%ar);
            &SaveText($FORM{'plain_text'}, "$_data_path/$message{'plain_file_id'}.mes");
            &SaveText($FORM{'html_text'}, "$_data_path/$message{'html_file_id'}.mes");
            &Redirect("$g_thisscript?a0=aut&a1=edi&id=$message{'parent_id'}");
        } # if
    } # if
    else {
        my(%message) = &data_Load($fm{"mid"});
        my(%ar) = &data_Load($message{"parent_id"});
        $fm{"subject"} = $message{"subject"};

        if ($ar{"immediate_message_id"} eq $message{"id"}) {
            $fm{"schedule"} = "IMM";
        } # if
        else {
            $fm{"schedule"} = $message{"schedule"};
        } # else

        $fm{"interval"} = $message{"interval"};
        $fm{"attachments"} = $message{"attachments"};
        $fm{"default_format"} = $message{"default_format"};
        $fm{"use_header"} = $message{"use_header"};
        $fm{"use_footer"} = $message{"use_footer"};
        $fm{"plain_text"} = &LoadText("$_data_path/$message{'plain_file_id'}.mes");
        $fm{"html_text"} = &LoadText("$_data_path/$message{'html_file_id'}.mes");
    } # else

    &EditMessagePage(%fm);
} # sub EditMessage

sub EditMessagePage {
    my(%fm) = @_;

    my(%message) = &data_Load($fm{"mid"});
    my(%ar) = &data_Load($message{"parent_id"});

    &PageHeading;
    &PageHeader("h_aut_editmessage.htm");
    &PageSubHeader("Autoresponders &gt; Edit Message", "[<a class='subheaderlink' href='$g_thisscript?a0=aut&a1=edi&id=$ar{'id'}' onmouseover='ShowTooltip(7);' onmouseout='HideTooltip(7);'>Return to Message List</a> | <a class='subheaderlink' href='$_help_url_path/h_tags.htm' target='help' onclick='Javascript:WindowPopup();' onmouseover='ShowTooltip(8);' onmouseout='HideTooltip(8);'>Dynamic Content</a>]");

    &Spacer("1", "25");

    &InfoHeading("$ar{'listens_on'}\@$g_settings{'your_domain'}");
    &InfoBox("Subject: $message{'subject'}");

    &OpenForm("form", "$g_thisscript?a0=aut&a1=edi&a2=edi&a3=pro&mid=$fm{'mid'}");

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Schedule</b><br>When should this message be sent?</td>\n";
    if ($fm{"schedule"} eq "IMM") {
        print "<td class='formcell' width='50%' valign='middle'><select name='schedule' size='1'><option value='IMM' selected>Immediately</option><option value='INT'>Use Interval</option><option value='NEX'>Next Run</option><option value='1'>Monday</option><option value='2'>Tuesday</option><option value='3'>Wednesday</option><option value='4'>Thursday</option><option value='5'>Friday</option><option value='6'>Saturday</option><option value='7'>Sunday</option></select></td>\n";
    } # if
    elsif ($fm{"schedule"} eq "NEX") {
        print "<td class='formcell' width='50%' valign='middle'><select name='schedule' size='1'><option value='IMM'>Immediately</option><option value='INT'>Use Interval</option><option value='NEX' selected>Next Run</option><option value='1'>Monday</option><option value='2'>Tuesday</option><option value='3'>Wednesday</option><option value='4'>Thursday</option><option value='5'>Friday</option><option value='6'>Saturday</option><option value='7'>Sunday</option></select></td>\n";
    } # elsif
    elsif ($fm{"schedule"} eq "1") {
        print "<td class='formcell' width='50%' valign='middle'><select name='schedule' size='1'><option value='IMM'>Immediately</option><option value='INT'>Use Interval</option><option value='NEX'>Next Run</option><option value='1' selected>Monday</option><option value='2'>Tuesday</option><option value='3'>Wednesday</option><option value='4'>Thursday</option><option value='5'>Friday</option><option value='6'>Saturday</option><option value='7'>Sunday</option></select></td>\n";
    } # elsif
    elsif ($fm{"schedule"} eq "2") {
        print "<td class='formcell' width='50%' valign='middle'><select name='schedule' size='1'><option value='IMM'>Immediately</option><option value='INT'>Use Interval</option><option value='NEX'>Next Run</option><option value='1'>Monday</option><option value='2' selected>Tuesday</option><option value='3'>Wednesday</option><option value='4'>Thursday</option><option value='5'>Friday</option><option value='6'>Saturday</option><option value='7'>Sunday</option></select></td>\n";
    } # elsif
    elsif ($fm{"schedule"} eq "3") {
        print "<td class='formcell' width='50%' valign='middle'><select name='schedule' size='1'><option value='IMM'>Immediately</option><option value='INT'>Use Interval</option><option value='NEX'>Next Run</option><option value='1'>Monday</option><option value='2'>Tuesday</option><option value='3' selected>Wednesday</option><option value='4'>Thursday</option><option value='5'>Friday</option><option value='6'>Saturday</option><option value='7'>Sunday</option></select></td>\n";
    } # elsif
    elsif ($fm{"schedule"} eq "4") {
        print "<td class='formcell' width='50%' valign='middle'><select name='schedule' size='1'><option value='IMM'>Immediately</option><option value='INT'>Use Interval</option><option value='NEX'>Next Run</option><option value='1'>Monday</option><option value='2'>Tuesday</option><option value='3'>Wednesday</option><option value='4' selected>Thursday</option><option value='5'>Friday</option><option value='6'>Saturday</option><option value='7'>Sunday</option></select></td>\n";
    } # elsif
    elsif ($fm{"schedule"} eq "5") {
        print "<td class='formcell' width='50%' valign='middle'><select name='schedule' size='1'><option value='IMM'>Immediately</option><option value='INT'>Use Interval</option><option value='NEX'>Next Run</option><option value='1'>Monday</option><option value='2'>Tuesday</option><option value='3'>Wednesday</option><option value='4'>Thursday</option><option value='5' selected>Friday</option><option value='6'>Saturday</option><option value='7'>Sunday</option></select></td>\n";
    } # elsif
    elsif ($fm{"schedule"} eq "6") {
        print "<td class='formcell' width='50%' valign='middle'><select name='schedule' size='1'><option value='IMM'>Immediately</option><option value='INT'>Use Interval</option><option value='NEX'>Next Run</option><option value='1'>Monday</option><option value='2'>Tuesday</option><option value='3'>Wednesday</option><option value='4'>Thursday</option><option value='5'>Friday</option><option value='6' selected>Saturday</option><option value='7'>Sunday</option></select></td>\n";
    } # elsif
    elsif ($fm{"schedule"} eq "7") {
        print "<td class='formcell' width='50%' valign='middle'><select name='schedule' size='1'><option value='IMM'>Immediately</option><option value='INT'>Use Interval</option><option value='NEX'>Next Run</option><option value='1'>Monday</option><option value='2'>Tuesday</option><option value='3'>Wednesday</option><option value='4'>Thursday</option><option value='5'>Friday</option><option value='6'>Saturday</option><option value='7' selected>Sunday</option></select></td>\n";
    } # elsif
    else {
        print "<td class='formcell' width='50%' valign='middle'><select name='schedule' size='1'><option value='IMM'>Immediately</option><option value='INT' selected>Use Interval</option><option value='NEX'>Next Run</option><option value='1'>Monday</option><option value='2'>Tuesday</option><option value='3'>Wednesday</option><option value='4'>Thursday</option><option value='5'>Friday</option><option value='6'>Saturday</option><option value='7'>Sunday</option></select></td>\n";
    } # else
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Interval</b><br>Only relevant if <b>Use Interval</b> is selected above</td>\n";
    $size = &FieldSize(4);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='interval' size='$size' maxlength='3' value='$fm{'interval'}'> day(s) after previous message</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Subject</b></td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='subject' size='$size' value='$fm{'subject'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Default format</b><br>What to send what your contact does not specify</td>\n";

    if ($fm{"default_format"} eq "H") {
        print "<td class='formcell' width='50%' valign='middle'><select name='default_format' size='1'><option value='T'>Plain text</option><option value='H' selected>HTML</option></select></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><select name='default_format' size='1'><option value='T' selected>Plain text</option><option value='H'>HTML</option></select></td>\n";
    } # else

    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>File attachments</b><br>Use only 8.3 filenames, separate filenames with a space<br>Filenames are case sensitive</td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='attachments' size='$size' value='$fm{'attachments'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Include header?</b></td>\n";
    if ($fm{"use_header"}) {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='use_header' value='1' checked></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='use_header' value='1'></td>\n";
    } # else
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Include footer?</b></td>\n";
    if ($fm{"use_footer"}) {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='use_footer' value='1' checked></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='use_footer' value='1'></td>\n";
    } # else
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>Plain Text Message</b><br>Type or use CTRL+V to paste from clipboard</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    $size = &FieldSize(70);
    print "<td class='formcell' colspan='2' align='center'><textarea rows='15' name='plain_text' cols='$size'>\n";
    $plain_message = &EncodeHTML($fm{"plain_text"});
    print $plain_message;
    print "</textarea>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>HTML Message Code</b><br>Type or use CTRL+V to paste from clipboard</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    $size = &FieldSize(70);
    print "<td class='formcell' colspan='2' align='center'><textarea rows='15' name='html_text' cols='$size'>\n";
    $html_message = &EncodeHTML($fm{"html_text"});
    print $html_message;
    print "</textarea>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Save Changes  '> <input type='reset' value='  Reset Values  '></td>\n";
    print "</tr>\n";

    &CloseForm;

    &PageCloser ('');
} # sub EditMessagePage

sub UpMessage {
    my(%fm) = @_;
    $fm{"mid"} = $INFO{"mid"};
    my(%message) = &data_Load($fm{"mid"});
    my(%ar) = &data_Load($message{"parent_id"});
    my(@list) = split(/\|/, $ar{"message_order"});
    shift(@list);

    my($thismid, $temp);
    my($counter) = 0;
    foreach $thismid (@list) {
        if ($thismid eq $fm{"mid"}) {
            if ($ar{"immediate_message_id"} ne @list[$counter-1]) {
                $temp = @list[$counter-1];
                @list[$counter-1] = @list[$counter];
                @list[$counter] = $temp;
            } # if
            last;
        } # if
        $counter++;
    } # foreach
    
    $ar{"message_order"} = "";
    foreach $thismid (@list) {
        $ar{"message_order"} = $ar{"message_order"} . "|" . $thismid;
    } # foreach

    &data_Save(%ar);

    &Redirect("$g_thisscript?a0=aut&a1=edi&id=$ar{'id'}");
} # sub UpMessage

sub DownMessage {
    my(%fm) = @_;
    $fm{"mid"} = $INFO{"mid"};
    my(%message) = &data_Load($fm{"mid"});
    my(%ar) = &data_Load($message{"parent_id"});
    my(@list) = split(/\|/, $ar{"message_order"});
    shift(@list);

    my($thismid, $temp);
    my($counter) = 0;
    foreach $thismid (@list) {
        if ($thismid eq $fm{"mid"}) {
            $temp = @list[$counter+1];
            @list[$counter+1] = @list[$counter];
            @list[$counter] = $temp;
            last;
        } # if
        $counter++;
    } # foreach
    
    $ar{"message_order"} = "";
    foreach $thismid (@list) {
        $ar{"message_order"} = $ar{"message_order"} . "|" . $thismid;
    } # foreach

    &data_Save(%ar);

    &Redirect("$g_thisscript?a0=aut&a1=edi&id=$ar{'id'}");
} # sub DownMessage

sub TestAutoresponder {
    my(%fm) = @_;
    $fm{"id"} = $INFO{"id"};

    my(%profile) = &data_Load("OWN00000000");

    if ((! $profile{"email"}) or (! IsValidEmailAddress($profile{"email"}))) {
        &Redirect("$g_thisscript?a0=aut&m=Your_profile_does_not_contain_a_valid_e-mail_address");
    } # if

    if ($g_a2 eq 'pro') {
        my(%campaign) = &data_New("CAM");
        $campaign{"full_name"} = "Autoresponse Plus Administrator";
        $campaign{"email"} = $profile{"email"};
        $campaign{"autoresponder_id"} = $fm{"id"};
        $campaign{"status"} = "A";
        $campaign{"subscribe_date"} = time;
        $campaign{"source"} = "T";

        $campaign{"format_preference"} = "T";
        &data_Save(%campaign);

        my(%ar) = &data_Load($fm{"id"});
        my(@message_keys) = split(/\|/, $ar{"message_order"});
        shift(@message_keys);
        my($key);
        foreach $key (@message_keys) {
            &SendMessage($campaign{"id"}, $key);
        } # foreach

        $campaign{"format_preference"} = "H";
        &data_Save(%campaign);

        my(%ar) = &data_Load($fm{"id"});
        my(@message_keys) = split(/\|/, $ar{"message_order"});
        shift(@message_keys);
        my($key);
        foreach $key (@message_keys) {
            &SendMessage($campaign{"id"}, $key);
        } # foreach

        &data_Delete($campaign{"id"});

        &Redirect("$g_thisscript?a0=aut&m=All_messages_have_been_sent_to_your_e-mail_address");
    } # if
    else {
        my(%ar) = &data_Load($fm{"id"});

        &PageHeading;
        &PageHeader("h_aut_test.htm");
        &PageSubHeader("Autoresponders &gt; Confirm Test", "[<a class='subheaderlink' href='$g_thisscript?a0=aut' onmouseover='ShowTooltip(2);' onmouseout='HideTooltip(2);'>Return to Autoresponder List</a>]");

        &Spacer("1", "25");

        &InfoHeading("$ar{'listens_on'}\@$g_settings{'your_domain'}");
        &InfoBox("Description: $ar{'description'}");

        &OpenForm("form", "$g_thisscript?a0=aut&a1=tes&a2=pro&id=$fm{'id'}");

        print "<tr>\n";
        print "<td class='wrapcell' colspan='2' valign='middle'><p>When you click <b>Confirm Test</b>, all plain text and HTML messages for this autoresponder will be sent to the e-mail address <b>$profile{'email'}</b>.</p></td>\n";
        print "</tr>\n";

        print "<tr>\n";
        print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Confirm Test  '></td>\n";
        print "</tr>\n";

        &CloseForm;

        &PageCloser('');
    } # else
} # sub TestAutoresponder

sub CountMessages {
    my($arid) = @_;
    my(%ar) = &data_Load($arid);
    my(@keys) = split(/\|/, $ar{"message_order"});
    shift(@keys);
    my($result) = $#keys+1;
    return $result;
} # sub CountMessages

return 1;
