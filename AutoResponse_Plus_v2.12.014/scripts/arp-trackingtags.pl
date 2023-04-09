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

sub TrackingTags {
    my(%fm);

    if (! &ValidateOwner(%fm)) {
        &Redirect("$g_thisscript?a0=log");
    } # if

    if ($g_a1 eq 'cre') {
        &CreateTrackingTag(%fm);
         exit;
    } # create
    elsif ($g_a1 eq 'edi') {
        &EditTrackingTag(%fm);
        exit;
    } # edit
    elsif ($g_a1 eq 'con') {
        &ConfirmDeleteTrackingTag(%fm);
        exit;
    } # confirmdelete
    else {
        &TrackingTagList(%fm);
        exit;
    } # default action
} # sub TrackingTags

sub TrackingTagList {
    my(%fm) = @_;

    &PageHeading;
    &PageHeader("h_trackingtags.htm");
    &PageSubHeader("Tracking Tags", "[<a class='subheaderlink' href='$g_thisscript?a0=tra&a1=cre' onmouseover='ShowTooltip(9);' onmouseout='HideTooltip(9);'>Create Tracking Tag</a>]");

    &Spacer("1", "25");

    &ListTableHeading("Tracking Tags");
    &OpenListTable;

    print "<tr>\n";

    print "<td class='listtablecolumnheaders'>\n";
    print "#\n";
    print "</td>\n";

    print "<td class='listtablecolumnheaders'>\n";
    print "Tracking tag\n";
    print "</td>\n";

    print "<td class='listtablecolumnheaders'>\n";
    print "Description\n";
    print "</td>\n";

    print "<td class='listtablecolumnheaders'>\n";
    print "Actions\n";
    print "</td>\n";

    print "</tr>\n";

    dbmopen(%db_tra, "$_data_path/TRA", undef);
    if ($g_settings{'file_locking'}) {flock(db_tra, 2)}
    my(@keys) = sort(keys(%db_tra));

    if (! @keys) {
        print "<tr>\n";
        print "<td class='listtableoddrow' colspan='4'>\n";
        print "There are no tracking tags\n";
        print "</td>\n";
        print "</tr>\n";
    } # if
    else {
        my($key, $fileline, %thistt);
        my($isodd) = 1;
        my($displaynum) = 1;
        foreach $key (@keys) {
            $fileline = $db_tra{$key};
            %thistt = &data_GetRecord($fileline);

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
            print "$thistt{'tag'}";
            print "</td>\n";

            if ($isodd) {
                print "<td class='listtableoddrow'>\n";
            } # if
            else {
                print "<td class='listtableevenrow'>\n";
            } # if
            print "$thistt{'description'}";
            print "</td>\n";

            if ($isodd) {
                print "<td class='listtableoddrowlink'>\n";
                print "<a class='listtableoddrowlink' href='$g_thisscript?a0=tra&a1=edi&id=$thistt{'id'}'>Edit</a> | <a class='listtableoddrowlink' href='$g_thisscript?a0=tra&a1=con&id=$thistt{'id'}'>Delete</a>\n";
                print "</td>\n";
            } # if
            else {
                print "<td class='listtableevenrowlink'>\n";
                print "<a class='listtableevenrowlink' href='$g_thisscript?a0=tra&a1=edi&id=$thistt{'id'}'>Edit</a> | <a class='listtableevenrowlink' href='$g_thisscript?a0=tra&a1=con&id=$thistt{'id'}'>Delete</a>\n";
                print "</td>\n";
            } # else

            print "</tr>\n";

            $isodd = not $isodd;
            $displaynum ++;
        } # foreach
    } # else

    dbmclose(%db_tra);
    if ($g_settings{'file_locking'}) {flock(db_tra, 8)}

    &CloseListTable;

    &Spacer("1", "25");

    &PageCloser('');
} # sub TrackingTagList

sub CreateTrackingTag {
    my(%fm) = @_;

    if ($g_a2 eq "pro") {
        $fm{"tag"} = &Trim($FORM{"tag"});
        $fm{"description"} = &Trim($FORM{"description"});
        $fm{"subscribe_success"} = &Trim($FORM{"subscribe_success"});
        $fm{"subscribe_failure"} = &Trim($FORM{"subscribe_failure"});
        $fm{"unsubscribe_success"} = &Trim($FORM{"unsubscribe_success"});
        $fm{"unsubscribe_failure"} = &Trim($FORM{"unsubscribe_failure"});
        $g_message = &validate_CreateTrackingTag(%fm);
        if (! $g_message) {
            my(%tt) = &data_New("TRA");
            $tt{"tag"} = $fm{"tag"};
            $tt{"description"} = $fm{"description"};
            $tt{"subscribe_success"} = $fm{"subscribe_success"};
            $tt{"subscribe_failure"} = $fm{"subscribe_failure"};
            $tt{"unsubscribe_success"} = $fm{"unsubscribe_success"};
            $tt{"unsubscribe_failure"} = $fm{"unsubscribe_failure"};
            &data_Save(%tt);
            &Redirect("$g_thisscript?a0=tra");
        } # if
    } # if
    else {
        my(%tt) = &data_New("TRA");
        $fm{"tag"} = $tt{"tag"};
        $fm{"description"} = $tt{"description"};
        $fm{"subscribe_success"} = $tt{"subscribe_success"};
        $fm{"subscribe_failure"} = $tt{"subscribe_failure"};
        $fm{"unsubscribe_success"} = $tt{"unsubscribe_success"};
        $fm{"unsubscribe_failure"} = $tt{"unsubscribe_failure"};
    } # else

    &TrackingTagCreatePage(%fm);
} # sub CreateTrackingTag

sub TrackingTagCreatePage {
    my(%fm) = @_;

    &PageHeading;
    &PageHeader("h_tra_create.htm");
    &PageSubHeader("Tracking Tags &gt; Create", "[<a class='subheaderlink' href='$g_thisscript?a0=tra' onmouseover='ShowTooltip(10);' onmouseout='HideTooltip(10);'>Return to Tracking Tag List</a>]");

    &Spacer("1", "5");

    &OpenForm("form", "$g_thisscript?a0=tra&a1=cre&a2=pro");

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Tracking tag</b><br>Up to 8 characters</td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='tag' size='$size' maxlength='8' value='$fm{'tag'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Description</b></td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='description' size='$size' value='$fm{'description'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Custom subscribe success page URL</b><br>Optional</td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='subscribe_success' size='$size' value='$fm{'subscribe_success'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Custom subscribe failure page URL</b><br>Optional</td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='subscribe_failure' size='$size' value='$fm{'subscribe_failure'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Custom unsubscribe success page URL</b><br>Optional</td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='unsubscribe_success' size='$size' value='$fm{'unsubscribe_success'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Custom unsubscribe failure page URL</b><br>Optional</td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='unsubscribe_failure' size='$size' value='$fm{'unsubscribe_failure'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Create  '></td>\n";
    print "</tr>\n";

    &CloseForm;

    &Spacer("1", "5");

    &PageCloser('form.tag');
} # sub TrackingTagCreatePage

sub ConfirmDeleteTrackingTag {
    my(%fm) = @_;
    $fm{"id"} = $INFO{"id"};

    if ($g_a2 eq 'pro') {
        &data_Delete($fm{"id"});
        &Redirect("$g_thisscript?a0=tra");
    } # if

    my(%tt) = &data_Load($fm{"id"});

    &PageHeading;
    &PageHeader("h_tra_delete.htm");
    &PageSubHeader("Tracking Tags &gt; Confirm Delete", "[<a class='subheaderlink' href='$g_thisscript?a0=tra' onmouseover='ShowTooltip(10);' onmouseout='HideTooltip(10);'>Return to Tracking Tag List</a>]");

    &Spacer("1", "25");

    &InfoHeading("Tag: $tt{'tag'}");
    &InfoBox("Description: $tt{'description'}");

    &OpenForm("form", "$g_thisscript?a0=tra&a1=con&a2=pro&id=$fm{'id'}");

    print "<tr>\n";
    print "<td class='wrapcell' colspan='2' valign='middle'><p>When you click <b>Confirm Delete</b>, this tracking tag will be deleted permanently.</p></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Confirm Delete  '></td>\n";
    print "</tr>\n";

    &CloseForm;

    &PageCloser('');
} # sub ConfirmDeleteTrackingTag

sub EditTrackingTag {
    my(%fm) = @_;
    $fm{"id"} = $INFO{"id"};

    my(%tt) = &data_Load($fm{"id"});

    if ($g_a2 eq "pro") {
        $fm{"tag"} = &Trim($FORM{"tag"});
        $fm{"description"} = &Trim($FORM{"description"});
        $fm{"subscribe_success"} = &Trim($FORM{"subscribe_success"});
        $fm{"subscribe_failure"} = &Trim($FORM{"subscribe_failure"});
        $fm{"unsubscribe_success"} = &Trim($FORM{"unsubscribe_success"});
        $fm{"unsubscribe_failure"} = &Trim($FORM{"unsubscribe_failure"});
        $fm{"old_tag"} = &Trim($FORM{"old_tag"});
        $g_message = &validate_EditTrackingTag(%fm);
        if (! $g_message) {
            $tt{"tag"} = $fm{"tag"};
            $tt{"description"} = $fm{"description"};
            $tt{"subscribe_success"} = $fm{"subscribe_success"};
            $tt{"subscribe_failure"} = $fm{"subscribe_failure"};
            $tt{"unsubscribe_success"} = $fm{"unsubscribe_success"};
            $tt{"unsubscribe_failure"} = $fm{"unsubscribe_failure"};
            &data_Save(%tt);
            &Redirect("$g_thisscript?a0=tra");
        } # if
    } # if
    else {
        $fm{"tag"} = $tt{"tag"};
        $fm{"description"} = $tt{"description"};
        $fm{"subscribe_success"} = $tt{"subscribe_success"};
        $fm{"subscribe_failure"} = $tt{"subscribe_failure"};
        $fm{"unsubscribe_success"} = $tt{"unsubscribe_success"};
        $fm{"unsubscribe_failure"} = $tt{"unsubscribe_failure"};
        $fm{"old_tag"} = $tt{"tag"};
    } # else

    &TrackingTagEditPage(%fm);
} # sub EditTrackingTag

sub TrackingTagEditPage {
    my(%fm) = @_;

    &PageHeading;
    &PageHeader("h_tra_edit.htm");
    &PageSubHeader("Tracking Tags &gt; Edit", "[<a class='subheaderlink' href='$g_thisscript?a0=tra' onmouseover='ShowTooltip(10);' onmouseout='HideTooltip(10);'>Return to Tracking Tag List</a>]");

    &Spacer("1", "25");

    &InfoHeading("Tag: $fm{'tag'}");
    &InfoBox("Description: $fm{'description'}");

    &OpenForm("form", "$g_thisscript?a0=tra&a1=edi&a2=pro&id=$fm{'id'}");

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Tracking tag</b><br>Up to 8 characters</td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='tag' size='$size' maxlength='8' value='$fm{'tag'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Description</b></td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='description' size='$size' value='$fm{'description'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Custom subscribe success page URL</b><br>Optional</td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='subscribe_success' size='$size' value='$fm{'subscribe_success'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Custom subscribe failure page URL</b><br>Optional</td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='subscribe_failure' size='$size' value='$fm{'subscribe_failure'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Custom unsubscribe success page URL</b><br>Optional</td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='unsubscribe_success' size='$size' value='$fm{'unsubscribe_success'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Custom unsubscribe failure page URL</b><br>Optional</td>\n";
    $size = &FieldSize(40);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='unsubscribe_failure' size='$size' value='$fm{'unsubscribe_failure'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Save Changes  '> <input type='reset' value='  Reset Values  '>\n";
    print "<input type='hidden' name='old_tag' value='$fm{'old_tag'}'>\n";
    print "</td>\n";
    print "</tr>\n";

    &CloseForm;

    &Spacer("1", "5");

    &PageCloser('form.tag');
} # sub TrackingTagEditPage

return 1;
