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

sub Campaigns {
    if (! &ValidateOwner) {
        &Redirect("$g_thisscript?a0=log");
    } # if

    if ($g_a1 eq 'vie') {
        &CampaignList;
        exit;
    } # view
    elsif ($g_a1 eq 'fil') {
        &CampaignListFilter;
        exit;
    } # filter
    elsif ($g_a1 eq 'cre') {
        &CreateCampaign;
         exit;
    } # create
    elsif ($g_a1 eq 'edi') {
        &EditCampaign;
        exit;
    } # edit
    elsif ($g_a1 eq 'con') {
        &ConfirmDeleteCampaign;
        exit;
    } # confirm delete campaign
    elsif ($g_a1 eq 'dls') {
        &ConfirmDeleteMatchingCampaigns;
        exit;
    } # confirm delete matching campaigns
    elsif ($g_a1 eq 'exp') {
        &ConfirmExport;
        exit;
    } # confirm export
    elsif ($g_a1 eq 'dex') {
        &Export;
        exit;
    } # export
    elsif ($g_a1 eq 'cls') {
        &CampaignsFilterDelete;
        exit;
    } # delete matching campaigns
    elsif ($g_a1 eq 'imp') {
        &Import;
        exit;
    } # import
    elsif ($g_a1 eq 'ema') {
        &BatchEmail;
        exit;
    } # batch e-mail
    elsif ($g_a1 eq 'bae') {
        &BatchStatusEdit;
        exit;
    } # batch status edit
    elsif ($g_a1 eq 'bax') {
        &DoBatchStatusEdit;
        exit;
    } # do batch status edit
    else {
        &CampaignList;
        exit;
    } # default action
} # sub Campaigns

sub CampaignListFilter {
    $fm{"status"} = $INFO{"sta"};
    $fm{"autoresponder"} = $INFO{"aut"};
    $fm{"tracking_tag"} = $INFO{"tra"};
    $fm{"date_scope"} = $INFO{"dat"};
    $fm{"page"} = $INFO{"pag"};
    $fm{"omit_duplicates"} = $INFO{"dup"};

    &PageHeading;
    &PageHeader("h_cam_filter.htm");
    &PageSubHeader("Subscribers > Set Filter", "[<a class='subheaderlink' href='$g_thisscript?a0=cam&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$fm{'page'}&dup=$fm{'omit_duplicates'}' onmouseover='ShowTooltip(14);' onmouseout='HideTooltip(14);'>Return to Subscriber List</a>]");

    &Spacer("1", "5");

    &OpenForm("form", "$g_thisscript?a0=cam&a1=vie");
    
    print "<tr>\n";
    print "<td class='wrapcell' colspan='2' valign='middle'><p>Choose your filter criteria here. The more items you set, the more targeted the list will be.</p></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Autoresponder</b></td>\n";
    print "<td class='formcell' width='50%' valign='middle'>\n";
    print "<select name='autoresponder' size='1'>\n";
    print "<option value='all'>All</option>\n";
    dbmopen(%db_aut, "$_data_path/AUT", undef);
    if ($g_settings{'file_locking'}) {flock(db_aut, 2)}
    my(@keys) = sort(keys(%db_aut));
    if (@keys) {
        my($key, $fileline, %thisar);
        foreach $key (@keys) {
            $fileline = $db_aut{$key};
            %thisar = &data_GetRecord($fileline);
            if ($thisar{"id"} eq $fm{"autoresponder"}) {
                print "<option value='$thisar{'id'}' selected>$thisar{'listens_on'}\@$g_settings{'your_domain'}</option>\n";
            } # if
            else {
                print "<option value='$thisar{'id'}'>$thisar{'listens_on'}\@$g_settings{'your_domain'}</option>\n";
            } # else
        } # foreach
    } # if
    dbmclose(%db_aut);
    if ($g_settings{'file_locking'}) {flock(db_aut, 8)}
    print "</select>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Tracking tag</b></td>\n";
    print "<td class='formcell' width='50%' valign='middle'>\n";
    print "<select name='tracking_tag' size='1'>\n";
    print "<option value='all'>All</option>\n";
    if ($fm{"tracking_tag"} eq "none") {
        print "<option value='none' selected>None</option>\n";
    } # if
    else {
        print "<option value='none'>None</option>\n";
    } # else
    dbmopen(%db_tra, "$_data_path/TRA", undef);
    if ($g_settings{'file_locking'}) {flock(db_tra, 2)}
    my(@keys) = sort(keys(%db_tra));
    if (@keys) {
        my($key, $fileline, %thistt);
        foreach $key (@keys) {
            $fileline = $db_tra{$key};
            %thistt = &data_GetRecord($fileline);
            if ($thistt{"tag"} eq $fm{"tracking_tag"}) {
                print "<option value='$thistt{'tag'}' selected>$thistt{'tag'}</option>\n";
            } # if
            else {
                print "<option value='$thistt{'tag'}'>$thistt{'tag'}</option>\n";
            } # else
        } # foreach
    } # if
    dbmclose(%db_tra);
    if ($g_settings{'file_locking'}) {flock(db_tra, 8)}
    print "</select>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Current status</b></td>\n";
    print "<td class='formcell' width='50%' valign='middle'>\n";
    print "<select name='status' size='1'>\n";
    if ($fm{"status"} eq "all") {
        print "<option value='all' selected>All</option>\n";
    } # if
    else {
        print "<option value='all'>All</option>\n";
    } # else
    if ($fm{"status"} eq "A") {
        print "<option value='A' selected>Active</option>\n";
    } # if
    else {
        print "<option value='A'>Active</option>\n";
    } # else
    if ($fm{"status"} eq "S") {
        print "<option value='S' selected>Suspended</option>\n";
    } # if
    else {
        print "<option value='S'>Suspended</option>\n";
    } # else
    if ($fm{"status"} eq "U") {
        print "<option value='U' selected>User cancelled</option>\n";
    } # if
    else {
        print "<option value='U'>User cancelled</option>\n";
    } # else
    if ($fm{"status"} eq "F") {
        print "<option value='F' selected>Finished</option>\n";
    } # if
    else {
        print "<option value='F'>Finished</option>\n";
    } # else
    if ($fm{"status"} eq "X") {
        print "<option value='X' selected>Failed</option>\n";
    } # if
    else {
        print "<option value='X'>Failed</option>\n";
    } # else
    print "</select>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Date scope</b></td>\n";
    print "<td class='formcell' width='50%' valign='middle'>\n";
    print "<select name='date_scope' size='1'>\n";
    if ($fm{"date_scope"} eq "all") {
        print "<option value='all' selected>All</option>\n";
    } # if
    else {
        print "<option value='all'>All</option>\n";
    } # else
    if ($fm{"date_scope"} eq "T") {
        print "<option value='T' selected>Today</option>\n";
    } # if
    else {
        print "<option value='T'>Today</option>\n";
    } # else
    if ($fm{"date_scope"} eq "W") {
        print "<option value='W' selected>This week</option>\n";
    } # if
    else {
        print "<option value='W'>This week</option>\n";
    } # else
    if ($fm{"date_scope"} eq "M") {
        print "<option value='M' selected>This month</option>\n";
    } # if
    else {
        print "<option value='M'>This month</option>\n";
    } # else
    if ($fm{"date_scope"} eq "Y") {
        print "<option value='Y' selected>This year</option>\n";
    } # if
    else {
        print "<option value='Y'>This year</option>\n";
    } # else
    print "</select>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Omit duplicate subscribers?</b></td>\n";

    if ($fm{"omit_duplicates"}) {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='omit_duplicates' value='1' checked></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='omit_duplicates' value='1'></td>\n";
    } # else

    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Show List  '></td>\n";
    print "</tr>\n";

    &CloseForm;

    &Spacer("1", "5");

    &PageCloser('');
} # sub CampaignListFilter

sub CampaignList {
    $fm{"page"} = $INFO{"pag"};
    if (! $fm{"page"}) {
        $fm{"page"} = 1;
        $fm{"status"} = $FORM{"status"};
        $fm{"autoresponder"} = $FORM{"autoresponder"};
        $fm{"tracking_tag"} = $FORM{"tracking_tag"};
        $fm{"date_scope"} = $FORM{"date_scope"};
        $fm{"omit_duplicates"} = $FORM{"omit_duplicates"};
    } # if
    else {
        $fm{"status"} = $INFO{"sta"};
        $fm{"autoresponder"} = $INFO{"aut"};
        $fm{"tracking_tag"} = $INFO{"tra"};
        $fm{"date_scope"} = $INFO{"dat"};
        $fm{"omit_duplicates"} = $INFO{"dup"};
    } # else

    if (! $fm{"status"}) {$fm{"status"} = "all"}
    if (! $fm{"autoresponder"}) {$fm{"autoresponder"} = "all"}
    if (! $fm{"tracking_tag"}) {$fm{"tracking_tag"} = "all"}
    if (! $fm{"date_scope"}) {$fm{"date_scope"} = "all"}

    if (! &Trim($g_settings{"max_list"})) {
        $g_settings{"max_list"} = 50;
    } # if

    &PageHeading;
    &PageHeader("h_campaigns.htm");
    &PageSubHeader("Subscribers", "[<a class='subheaderlink' href='$g_thisscript?a0=cam&a1=fil&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$fm{'page'}&dup=$fm{'omit_duplicates'}' onmouseover='ShowTooltip(15);' onmouseout='HideTooltip(15);'>Set Filter</a> | <a class='subheaderlink' href='$g_thisscript?a0=cam' onmouseover='ShowTooltip(16);' onmouseout='HideTooltip(16);'>Clear Filter</a> | <a class='subheaderlink' href='$g_thisscript?a0=cam&a1=bae&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$fm{'page'}&dup=$fm{'omit_duplicates'}' onmouseover='ShowTooltip(17);' onmouseout='HideTooltip(17);'>Batch Status Change</a> | <a class='subheaderlink' href='$g_thisscript?a0=cam&a1=cre&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$fm{'page'}&dup=$fm{'omit_duplicates'}' onmouseover='ShowTooltip(18);' onmouseout='HideTooltip(18);'>Add Subscriber</a> | <a class='subheaderlink' href='$g_thisscript?a0=cam&a1=imp&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$fm{'page'}&dup=$fm{'omit_duplicates'}' onmouseover='ShowTooltip(19);' onmouseout='HideTooltip(19);'>Import</a> | <a class='subheaderlink' href='$g_thisscript?a0=cam&a1=exp&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$fm{'page'}&dup=$fm{'omit_duplicates'}' onmouseover='ShowTooltip(20);' onmouseout='HideTooltip(20);'>Export</a> | <a class='subheaderlink' href='$g_thisscript?a0=cam&a1=ema&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$fm{'page'}&dup=$fm{'omit_duplicates'}' onmouseover='ShowTooltip(21);' onmouseout='HideTooltip(21);'>Batch E-mail</a> | <a class='subheaderlink' href='$g_thisscript?a0=cam&a1=dls&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$fm{'page'}&dup=$fm{'omit_duplicates'}' onmouseover='ShowTooltip(22);' onmouseout='HideTooltip(22);'>Batch Delete</a>]");    

    &Spacer("1", "25");

    if (($fm{"status"} eq "all") and ($fm{"autoresponder"} eq "all") and ($fm{"tracking_tag"} eq "all") and ($fm{"date_scope"} eq "all") and (! $fm{"omit_duplicates"})) {
        &ListTableHeading("Subscribers: Unfiltered");
    } # if
    else {
        &ListTableHeading("Subscribers: Filtered");
    } # else

    my($disp_ar);
    if ($fm{"autoresponder"} eq "all") {
        $disp_ar = "All";
    } # if
    else {
        my(%ar) = &data_Load($fm{"autoresponder"});
        $disp_ar = "$ar{'listens_on'}\@$g_settings{'your_domain'}";
    } # else

    my($disp_tt);
    if ($fm{"tracking_tag"} eq "all") {
        $disp_tt = "All";
    } # if
    elsif ($fm{"tracking_tag"} eq "none") {
        $disp_tt = "None";
    } # elsif
    else {
        $disp_tt = $fm{"tracking_tag"};
    } # else

    my($disp_st);
    if ($fm{"status"} eq "all") {
        $disp_st = "All";
    } # if
    elsif ($fm{"status"} eq "A") {
        $disp_st = "Active";
    } # elsif
    elsif ($fm{"status"} eq "S") {
        $disp_st = "Suspended";
    } # elsif
    elsif ($fm{"status"} eq "U") {
        $disp_st = "User cancelled";
    } # elsif
    elsif ($fm{"status"} eq "F") {
        $disp_st = "Finished";
    } # elsif
    elsif ($fm{"status"} eq "X") {
        $disp_st = "Failed";
    } # elsif

    my($disp_ds);
    if ($fm{"date_scope"} eq "all") {
        $disp_ds = "All";
    } # if
    elsif ($fm{"date_scope"} eq "T") {
        $disp_ds = "Today";
    } # elsif
    elsif ($fm{"date_scope"} eq "W") {
        $disp_ds = "This week";
    } # elsif
    elsif ($fm{"date_scope"} eq "M") {
        $disp_ds = "This month";
    } # elsif
    elsif ($fm{"date_scope"} eq "Y") {
        $disp_ds = "This year";
    } # elsif

    if ($fm{"omit_duplicates"}) {
        $disp_omit = "Yes"
    } # if
    else {
        $disp_omit = "No"
    } # else

    &FilterListTableSubHeading("<b>Filter: </b>Autoresponder = $disp_ar | Tracking tag = $disp_tt | Status = $disp_st | Date scope = $disp_ds | Omit duplicate subscribers = $disp_omit");
    &OpenListTable;

    print "<tr>\n";

    print "<td class='listtablecolumnheaders'>\n";
    print "#\n";
    print "</td>\n";

    print "<td class='listtablecolumnheaders'>\n";
    print "Subscriber\n";
    print "</td>\n";

    print "<td class='listtablecolumnheaders'>\n";
    print "Autoresponder\n";
    print "</td>\n";

    print "<td class='listtablecolumnheaders'>\n";
    print "Tracking tag\n";
    print "</td>\n";

    print "<td class='listtablecolumnheaders'>\n";
    print "Subscribe date\n";
    print "</td>\n";

    print "<td class='listtablecolumnheaders'>\n";
    print "Status\n";
    print "</td>\n";

    print "<td class='listtablecolumnheaders'>\n";
    print "Last message\n";
    print "</td>\n";

    print "<td class='listtablecolumnheaders'>\n";
    print "Actions\n";
    print "</td>\n";

    print "</tr>\n";

    dbmopen(%db_cam, "$_data_path/CAM", undef);
    if ($g_settings{'file_locking'}) {flock(db_cam, 2)}
    my(@keys) = sort(keys(%db_cam));

    if (! @keys) {
        print "<tr>\n";
        print "<td class='listtableoddrow' colspan='8'>\n";
        print "There are no subscribers\n";
        print "</td>\n";
        print "</tr>\n";
    } # if
    else {
        my($totalcampaigns) = $#keys+1;
        my($key, $fileline, %thiscam);
        my($nummatches) = 0;
        my(%emaillist);
        my(@matches);
        my($isodd) = 1;
        foreach $key (@keys) {
            $fileline = $db_cam{$key};
            %thiscam = &data_GetRecord($fileline);
            my($ok) = 1;

            if (($fm{"autoresponder"} ne "all") and ($fm{"autoresponder"} ne $thiscam{"autoresponder_id"})) {
                $ok = 0;
            } # if
            if ($fm{"tracking_tag"} eq "none") {
                $fm{"tracking_tag"} = "";
                $reset_tt = 1;
            } # if
            if (($fm{"tracking_tag"} ne "all") and (lc($fm{"tracking_tag"}) ne lc($thiscam{"tracking_tag"}))) {
                $ok = 0;
            } # if
            if ($reset_tt) {$fm{"tracking_tag"} = "none"}
            if (($fm{"status"} ne "all") and ($fm{"status"} ne $thiscam{"status"})) {
                $ok = 0;
            } # if
            if ($fm{"date_scope"} ne "all") {
                if (($fm{"date_scope"} eq "T") and (! &IsToday($thiscam{"subscribe_date"}))) {
                    $ok = 0;
                } # if
                elsif (($fm{"date_scope"} eq "W") and (! &IsThisWeek($thiscam{"subscribe_date"}))) {
                    $ok = 0;
                } # if
                elsif (($fm{"date_scope"} eq "M") and (! &IsThisMonth($thiscam{"subscribe_date"}))) {
                    $ok = 0;
                } # if
                elsif (($fm{"date_scope"} eq "Y") and (! &IsThisYear($thiscam{"subscribe_date"}))) {
                    $ok = 0;
                } # if
            } # if

            if ($fm{"omit_duplicates"}) {
                if ($emaillist{$thiscam{"email"}}) {
                    $ok = 0;
                } # if
            } # if

            if (! $ok) {
                next;
            } # if
            else {
                $emaillist{$thiscam{"email"}} = 1;
                push(@matches, $fileline);
                $nummatches ++;
            } # else
        } # foreach

        if (@matches) {
            my($record) = 0;
            my($counter) = 0;
            my($numdisplayed) = 0;
            my($first) = (($fm{"page"}-1) * $g_settings{"max_list"});
            my($last) = $first + $g_settings{"max_list"} - 1;
            my($pages) = int($nummatches/$g_settings{"max_list"});

            if ($nummatches - ($pages * $g_settings{"max_list"}) > 0) {
                $pages ++;
            } # if

            if ($fm{"page"} eq "all") {
                $first = 0;
                $last = $nummatches;
            } # if

            if ($fm{"page"} > $pages) {
              $fm{"page"} = $pages;
            } # if

            foreach $key (@matches) {
                $counter ++;

                if ($record < $first) {
                    $record ++;
                    next;
                } # if

                if ($record > $last) {
                    last;
                } # if

                if (($numdisplayed >= $g_settings{"max_list"}) and ($fm{'page'} ne 'all')) {
                    last;
                } # if

                $numdisplayed ++;

                %thiscam = &data_GetRecord($matches[$record]);
                %thisar = &data_Load($thiscam{"autoresponder_id"});

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
                if ($thiscam{"failures"} > $g_settings{'mail_failures'}) {
                    if ($thiscam{"failures"} > 1) {
                        print "<font color='#FF0000'><b>$thiscam{'email'}<br>$thiscam{'failures'} failures</b></font>\n";
                    } # if
                    else {
                        print "<font color='#FF0000'><b>$thiscam{'email'}<br>$thiscam{'failures'} failure</b></font>\n";
                    } # else
                } # if
                else {
                    if ($thiscam{"failures"} > 0) {
                        if ($thiscam{"failures"} > 1) {
                            print "$thiscam{'email'}<br><font color='#FF0000'>$thiscam{'failures'} failures</font>\n";
                        } # if
                        else {
                            print "$thiscam{'email'}<br><font color='#FF0000'>$thiscam{'failures'} failure</font>\n";
                        } # else
                    } # if
                    else {
                        print "$thiscam{'email'}\n";
                    } # else
                } # else
                print "</td>\n";

                if ($isodd) {
                    print "<td class='listtableoddrow'>\n";
                } # if
                else {
                    print "<td class='listtableevenrow'>\n";
                } # if
                if (%thisar) {
                    print "$thisar{'listens_on'}\@$g_settings{'your_domain'}\n";
                } # if
                else {
                    print "Undefined\n";
                } # else
                print "</td>\n";

                if ($isodd) {
                    print "<td class='listtableoddrow'>\n";
                } # if
                else {
                    print "<td class='listtableevenrow'>\n";
                } # if
                if ($thiscam{'tracking_tag'}) {
                    print "$thiscam{'tracking_tag'}\n";
                } # if
                else {
                    print "None\n";
                } # else
                print "</td>\n";

                my($subscribe_date) = &FormatDate($thiscam{'subscribe_date'});

                if ($isodd) {
                    print "<td class='listtableoddrow'>\n";
                } # if
                else {
                    print "<td class='listtableevenrow'>\n";
                } # if
                print "$subscribe_date\n";
                print "</td>\n";

                if ($isodd) {
                    print "<td class='listtableoddrow'>\n";
                } # if
                else {
                    print "<td class='listtableevenrow'>\n";
                } # if
                if ($thiscam{'status'} eq 'A') {
                    print "Active\n";
                } # if
                elsif ($thiscam{'status'} eq 'S') {
                    print "Suspended\n";
                } # if
                elsif ($thiscam{'status'} eq 'U') {
                    print "User cancelled\n";
                } # if
                elsif ($thiscam{'status'} eq 'F') {
                    print "Finished\n";
                } # if
                elsif ($thiscam{'status'} eq 'X') {
                    print "Failed\n";
                } # if
                print "</td>\n";

                my($last_date) = &FormatDate($thiscam{'last_date'});

                if ($isodd) {
                    print "<td class='listtableoddrow'>\n";
                } # if
                else {
                    print "<td class='listtableevenrow'>\n";
                } # if
                if ($thiscam{"failures"} == 0) {
                    print "$thiscam{'last_message'} on $last_date\n";
                } # if
                else {
                    print "$thiscam{'last_message'} on $last_date\n";
                } # else

                print "</td>\n";

                if ($isodd) {
                    print "<td class='listtableoddrowlink'>\n";
                    print "<a class='listtableoddrowlink' href='$g_thisscript?a0=cam&a1=edi&cid=$thiscam{'id'}&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$fm{'page'}&dup=$fm{'omit_duplicates'}'>Edit</a> | <a class='listtableoddrowlink' href='$g_thisscript?a0=cam&a1=con&cid=$thiscam{'id'}&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$fm{'page'}&dup=$fm{'omit_duplicates'}'>Delete</a>\n";
                } # if
                else {
                    print "<td class='listtableevenrowlink'>\n";
                    print "<a class='listtableevenrowlink' href='$g_thisscript?a0=cam&a1=edi&cid=$thiscam{'id'}&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$fm{'page'}&dup=$fm{'omit_duplicates'}'>Edit</a> | <a class='listtableevenrowlink' href='$g_thisscript?a0=cam&a1=con&cid=$thiscam{'id'}&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$fm{'page'}&dup=$fm{'omit_duplicates'}'>Delete</a>\n";
                } # else
                print "</td>\n";
                print "</tr>\n";

                $isodd = not $isodd;
                $record ++;
            } # foreach

            print "<tr>\n";
            print "<td class='listtableoddrow' colspan='4'>\n";
            if ($fm{'page'} eq "all") {
                print "Matches: $nummatches | Total Subscribers: $totalcampaigns | Page 1 of 1";
            } # if
            else {
                print "Matches: $nummatches | Total Subscribers: $totalcampaigns | Page $fm{'page'} of $pages";
            } # else
            print "</td>\n";
            print "<td class='listtableoddrow' colspan='4' align='right'>\n";

            $previouspage = $fm{"page"} - 1;
            if ($previouspage < 1) {$previouspage = 1}
            $nextpage = $fm{"page"} + 1;
            if ($nextpage > $pages) {$nextpage = $pages}

            if ($fm{'page'} eq "all") {
                print "<a class='listtableoddrowlink' href='$g_thisscript?a0=cam&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=1&dup=$fm{'omit_duplicates'}'>Paginate</a>";
            } # if
            else {
                if ($pages == 1) {
                    print " ";
                } # if
                elsif ($fm{'page'} == 1) {
                    print "<a class='listtableoddrowlink' href='$g_thisscript?a0=cam&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=all&dup=$fm{'omit_duplicates'}'>All</a> | &lt;&lt; | &lt; | <a class='listtableoddrowlink' href='$g_thisscript?a0=cam&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$nextpage&dup=$fm{'omit_duplicates'}'>&gt;</a> | <a class='listtableoddrowlink' href='$g_thisscript?a0=cam&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$pages&dup=$fm{'omit_duplicates'}'>&gt;&gt;</a>";
                } # elsif
                elsif ($fm{'page'} == $pages) {
                    print "<a class='listtableoddrowlink' href='$g_thisscript?a0=cam&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=all&dup=$fm{'omit_duplicates'}'>All</a> | <a class='listtableoddrowlink' href='$g_thisscript?a0=cam&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=1&dup=$fm{'omit_duplicates'}'>&lt;&lt;</a> | <a class='listtableoddrowlink' href='$g_thisscript?a0=cam&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$previouspage&dup=$fm{'omit_duplicates'}'>&lt;</a> | &gt; | &gt;&gt;";
                } # elsif
                else {
                    print "<a class='listtableoddrowlink' href='$g_thisscript?a0=cam&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=all&dup=$fm{'omit_duplicates'}'>All</a> | <a class='listtableoddrowlink' href='$g_thisscript?a0=cam&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=1&dup=$fm{'omit_duplicates'}'>&lt;&lt;</a> | <a class='listtableoddrowlink' href='$g_thisscript?a0=cam&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$previouspage&dup=$fm{'omit_duplicates'}'>&lt;</a> | <a class='listtableoddrowlink' href='$g_thisscript?a0=cam&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$nextpage&dup=$fm{'omit_duplicates'}'>&gt; | <a class='listtableoddrowlink' href='$g_thisscript?a0=cam&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$pages&dup=$fm{'omit_duplicates'}'>&gt;&gt;</a></a>";
                } # else
            } # else

            print "</td>\n";
            print "</tr>\n";
        } # if
        else {
            print "<tr>\n";
            print "<td class='listtableoddrow' colspan='8'>\n";
            print "There are no matching subscribers\n";
            print "</td>\n";
            print "</tr>\n";
        } # else
    } # else

    dbmclose(%db_cam);
    if ($g_settings{'file_locking'}) {flock(db_cam, 8)}

    &CloseListTable;

    &Spacer("1", "25");

    &PageCloser('');
} # sub CampaignList

sub CreateCampaign {
    if ($g_a2 eq "pro") {
        $fm{"first_name"} = &Trim($FORM{"first_name"});
        $fm{"last_name"} = &Trim($FORM{"last_name"});
        $fm{"full_name"} = &Trim($FORM{"full_name"});
        $fm{"email"} = &Trim(lc($FORM{"email"}));
        $fm{"autoresponder_id"} = &Trim($FORM{"autoresponder_id"});
        $fm{"tracking_tag"} = &Trim($FORM{"tracking_tag"});
        $fm{"status"} = $FORM{"status"};
        $fm{"format_preference"} = $FORM{"format_preference"};
        $g_message = &validate_CreateCampaign(%fm);
        if (! $g_message) {
            my(%campaign) = &data_New("CAM");
            $campaign{"autoresponder_id"} = $fm{"autoresponder_id"};
            $campaign{"first_name"} = $fm{"first_name"};
            $campaign{"last_name"} = $fm{"last_name"};
            $campaign{"full_name"} = $fm{"full_name"};
            $campaign{"email"} = $fm{"email"};
            if ($fm{"tracking_tag"} eq "none") {
                $campaign{"tracking_tag"} = "";
            } # if
            else {
                $campaign{"tracking_tag"} = $fm{"tracking_tag"};
            } # else
            $campaign{"parent_id"} = $fm{"autoresponder_id"};
            $campaign{"status"} = $fm{"status"};
            $campaign{"source"} = "M";
            $campaign{"format_preference"} = $fm{"format_preference"};
            &data_Save(%campaign);
            &ProcessImmediateMessage($campaign{"id"});
            &Redirect("$g_thisscript?a0=cam");
        } # if
    } # if
    else {
        my(%campaign) = &data_New("CAM");
        $fm{"first_name"} = $campaign{"first_name"};
        $fm{"last_name"} = $campaign{"last_name"};
        $fm{"full_name"} = $campaign{"full_name"};
        $fm{"email"} = $campaign{"email"};
        $fm{"autoresponder_id"} = $campaign{"autoresponder_id"};
        if ($campaign{"tracking_tag"} eq "") {
            $fm{"tracking_tag"} = "none";
        } # if
        else {
            $fm{"tracking_tag"} = $campaign{"tracking_tag"};
        } # else
        $fm{"status"} = $campaign{"status"};
        $fm{"format_preference"} = $campaign{"format_preference"};
    } # else

    &CampaignCreatePage(%fm);
} # sub CreateCampaign

sub CampaignCreatePage {
    my(%fm) = @_;

    $fm{"list_status"} = $INFO{"sta"};
    $fm{"list_autoresponder"} = $INFO{"aut"};
    $fm{"list_tracking_tag"} = $INFO{"tra"};
    $fm{"list_date_scope"} = $INFO{"dat"};
    $fm{"list_page"} = $INFO{"pag"};
    $fm{"list_omit_duplicates"} = $INFO{"dup"};

    &PageHeading;
    &PageHeader("h_cam_create.htm");
    &PageSubHeader("Subscribers &gt; Add", "[<a class='subheaderlink' href='$g_thisscript?a0=cam&sta=$fm{'list_status'}&aut=$fm{'list_autoresponder'}&tra=$fm{'list_tracking_tag'}&dat=$fm{'list_date_scope'}&pag=$fm{'list_page'}&dup=$fm{'list_omit_duplicates'}' onmouseover='ShowTooltip(14);' onmouseout='HideTooltip(14);'>Return to Subscriber List</a>]");

    &Spacer("1", "5");

    &OpenForm("form", "$g_thisscript?a0=cam&a1=cre&a2=pro");

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Subscriber\'s first name</b><br>Optional</td>\n";
    $size = &FieldSize(30);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='first_name' size='$size' value='$fm{'first_name'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Subscriber\'s last name</b><br>Optional</td>\n";
    $size = &FieldSize(30);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='last_name' size='$size' value='$fm{'last_name'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Subscriber\'s full name</b><br>Optional</td>\n";
    $size = &FieldSize(30);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='full_name' size='$size' value='$fm{'full_name'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Subscriber\'s e-mail address</b></td>\n";
    $size = &FieldSize(30);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='email' size='$size' value='$fm{'email'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Autoresponder</b></td>\n";
    print "<td class='formcell' width='50%' valign='middle'>\n";
    dbmopen(%db_aut, "$_data_path/AUT", undef);
    if ($g_settings{'file_locking'}) {flock(db_aut, 2)}
    my(@keys) = sort(keys(%db_aut));
    if (@keys) {
        print "<select name='autoresponder_id' size='1'>\n";
        my($key, $fileline, %thisar);
        foreach $key (@keys) {
            $fileline = $db_aut{$key};
            %thisar = &data_GetRecord($fileline);
            if ($fm{'autoresponder_id'} eq $thisar{'id'}) {
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
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Tracking tag</b></td>\n";
    print "<td class='formcell' width='50%' valign='middle'>\n";
    print "<select name='tracking_tag' size='1'>\n";
    print "<option value='none'>None</option>\n";
    dbmopen(%db_tra, "$_data_path/TRA", undef);
    if ($g_settings{'file_locking'}) {flock(db_tra, 2)}
    my(@keys) = sort(keys(%db_tra));
    if (@keys) {
        my($key, $fileline, %thistt);
        foreach $key (@keys) {
            $fileline = $db_tra{$key};
            %thistt = &data_GetRecord($fileline);
            if ($fm{'tracking_tag'} eq $thistt{'tag'}) {
                print "<option value='$thistt{'tag'}' selected>$thistt{'tag'}</option>\n";
            } # if
            else {
                print "<option value='$thistt{'tag'}'>$thistt{'tag'}</option>\n";
            } # else
        } # foreach
        print "</select>\n";
    } # if
    dbmclose(%db_tra);
    if ($g_settings{'file_locking'}) {flock(db_tra, 8)}

    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Initial status</b></td>\n";

    if ($fm{"status"} eq "A") {
        print "<td class='formcell' width='50%' valign='middle'><select name='status' size='1'><option value='A' selected>Active</option><option value='S'>Suspended</option><option value='F'>Finished</option></select></td>\n";
    } # if
    elsif ($fm{"status"} eq "S") {
        print "<td class='formcell' width='50%' valign='middle'><select name='status' size='1'><option value='A'>Active</option><option value='S' selected>Suspended</option><option value='F'>Finished</option></select></td>\n";
    } # elsif
    elsif ($fm{"status"} eq "F") {
        print "<td class='formcell' width='50%' valign='middle'><select name='status' size='1'><option value='A'>Active</option><option value='S'>Suspended</option><option value='F' selected>Finished</option></select></td>\n";
    } # elsif

    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Preferred format</b></td>\n";

    if ($fm{"format_preference"} eq "H") {
        print "<td class='formcell' width='50%' valign='middle'><select name='format_preference' size='1'><option value='D'>Default</option><option value='T'>Plain text</option><option value='H' selected>HTML</option></select></td>\n";
    } # if
    elsif ($fm{"format_preference"} eq "D") {
        print "<td class='formcell' width='50%' valign='middle'><select name='format_preference' size='1'><option value='D' selected>Default</option><option value='T'>Plain text</option><option value='H'>HTML</option></select></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><select name='format_preference' size='1'><option value='D'>Default</option><option value='T' selected>Plain text</option><option value='H'>HTML</option></select></td>\n";
    } # else

    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Create  '></td>\n";
    print "</tr>\n";

    &CloseForm;

    &Spacer("1", "5");

    &PageCloser ('form.first_name');
} # sub CampaignCreatePage

sub EditCampaign {
    my(%fm) = @_;
    $fm{"cid"} = $INFO{"cid"};

    $fm{"list_status"} = $INFO{"sta"};
    $fm{"list_autoresponder"} = $INFO{"aut"};
    $fm{"list_tracking_tag"} = $INFO{"tra"};
    $fm{"list_date_scope"} = $INFO{"dat"};
    $fm{"list_page"} = $INFO{"pag"};
    $fm{"list_omit_duplicates"} = $INFO{"dup"};

    my(%campaign) = &data_Load($fm{"cid"});

    if ($g_a2 eq "pro") {
        $fm{"first_name"} = &Trim($FORM{"first_name"});
        $fm{"last_name"} = &Trim($FORM{"last_name"});
        $fm{"full_name"} = &Trim($FORM{"full_name"});
        $fm{"email"} = &Trim(lc($FORM{"email"}));
        $fm{"last_message"} = &Trim($FORM{"last_message"});
        $fm{"tracking_tag"} = &Trim($FORM{"tracking_tag"});
        $fm{"status"} = $FORM{"status"};
        $fm{"format_preference"} = $FORM{"format_preference"};
        $g_message = &validate_EditCampaign(%fm);
        if (! $g_message) {
            $campaign{"first_name"} = $fm{"first_name"};
            $campaign{"last_name"} = $fm{"last_name"};
            $campaign{"full_name"} = $fm{"full_name"};
            $campaign{"email"} = $fm{"email"};
            $campaign{"status"} = $fm{"status"};
            if ($campaign{"status"} ne "X") {
                $campaign{"failures"} = 0;
            } # if
            $campaign{"format_preference"} = $fm{"format_preference"};
            $campaign{"last_message"} = $fm{"last_message"};
            if ($fm{"tracking_tag"} eq "none") {
                $campaign{"tracking_tag"} = "";
            } # if
            else {
                $campaign{"tracking_tag"} = $fm{"tracking_tag"};
            } # else
            &data_Save(%campaign);
            if (($campaign{"status"} eq "A") and ($campaign{"last_message"} eq "0")) {
                &ProcessImmediateMessage($campaign{"id"});
            } # if
            &Redirect("$g_thisscript?a0=cam&sta=$fm{'list_status'}&aut=$fm{'list_autoresponder'}&tra=$fm{'list_tracking_tag'}&dat=$fm{'list_date_scope'}&pag=$fm{'list_page'}&dup=$fm{'list_omit_duplicates'}'");
        } # if
    } # if
    else {
        $fm{"first_name"} = $campaign{"first_name"};
        $fm{"last_name"} = $campaign{"last_name"};
        $fm{"full_name"} = $campaign{"full_name"};
        $fm{"email"} = $campaign{"email"};
        $fm{"last_message"} = $campaign{"last_message"};
        if ($campaign{"tracking_tag"} eq "") {
            $fm{"tracking_tag"} = "";
        } # if
        else {
            $fm{"tracking_tag"} = $campaign{"tracking_tag"};
        } # else
        $fm{"status"} = $campaign{"status"};
        $fm{"format_preference"} = $campaign{"format_preference"};
    } # else

    &CampaignEditPage(%fm);
} # sub EditCampaign

sub CampaignEditPage {
    my(%fm) = @_;
    my(%campaign) = &data_Load($fm{"cid"});
    my(%ar) = &data_Load($campaign{"autoresponder_id"});

    &PageHeading;
    &PageHeader("h_cam_edit.htm");
    &PageSubHeader("Subscribers &gt; Edit", "[<a class='subheaderlink' href='$g_thisscript?a0=cam&sta=$fm{'list_status'}&aut=$fm{'list_autoresponder'}&tra=$fm{'list_tracking_tag'}&dat=$fm{'list_date_scope'}&pag=$fm{'list_page'}&dup=$fm{'list_omit_duplicates'}' onmouseover='ShowTooltip(14);' onmouseout='HideTooltip(14);'>Return to Subscriber List</a>]");

    &Spacer("1", "25");

    my($sub_date) = &FormatDate($campaign{"subscribe_date"});
    my($disp_status);
    if ($campaign{"status"} eq "A") {$disp_status = "Active"}
    if ($campaign{"status"} eq "S") {$disp_status = "Suspended"}
    if ($campaign{"status"} eq "U") {$disp_status = "User cancelled"}
    if ($campaign{"status"} eq "F") {$disp_status = "Finished"}
    if ($campaign{"status"} eq "X") {$disp_status = "Failed"}

    &InfoHeading("$campaign{'email'}");
    &InfoBox("Autoresponder: $ar{'listens_on'}\@$g_settings{'your_domain'}<br>Follow-up sequence started on $sub_date<br>Current status: $disp_status");

    &OpenForm("form", "$g_thisscript?a0=cam&a1=edi&a2=pro&cid=$fm{'cid'}&sta=$fm{'list_status'}&aut=$fm{'list_autoresponder'}&tra=$fm{'list_tracking_tag'}&dat=$fm{'list_date_scope'}&pag=$fm{'list_page'}&dup=$fm{'list_omit_duplicates'}'");

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Subscriber\'s first name</b><br>Optional</td>\n";
    $size = &FieldSize(30);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='first_name' size='$size' value='$fm{'first_name'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Subscriber\'s last name</b><br>Optional</td>\n";
    $size = &FieldSize(30);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='last_name' size='$size' value='$fm{'last_name'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Subscriber\'s full name</b><br>Optional</td>\n";
    $size = &FieldSize(30);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='full_name' size='$size' value='$fm{'full_name'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Subscriber\'s e-mail address</b></td>\n";
    $size = &FieldSize(30);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='email' size='$size' value='$fm{'email'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Tracking tag</b></td>\n";
    print "<td class='formcell' width='50%' valign='middle'>\n";
    print "<select name='tracking_tag' size='1'>\n";
    print "<option value='none'>None</option>\n";
    dbmopen(%db_tra, "$_data_path/TRA", undef);
    if ($g_settings{'file_locking'}) {flock(db_tra, 2)}
    my(@keys) = sort(keys(%db_tra));
    if (@keys) {
        my($key, $fileline, %thistt);
        foreach $key (@keys) {
            $fileline = $db_tra{$key};
            %thistt = &data_GetRecord($fileline);
            if ($fm{'tracking_tag'} eq $thistt{'tag'}) {
                print "<option value='$thistt{'tag'}' selected>$thistt{'tag'}</option>\n";
            } # if
            else {
                print "<option value='$thistt{'tag'}'>$thistt{'tag'}</option>\n";
            } # else
        } # foreach
        print "</select>\n";
    } # if
    dbmclose(%db_tra);
    if ($g_settings{'file_locking'}) {flock(db_tra, 8)}

    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Previous message</b><br>0 = Return to start</td>\n";

    my($i);
    my($num_messages) = &CountMessages($ar{"id"});

    if ($num_messages) {
        print "<td class='formcell' width='50%' valign='middle'>\n";
        print "<select name='last_message' size='1'>\n";

        for ($i=0; $i<=$num_messages; $i++) {
            if ($i == $campaign{"last_message"}) {
                print "<option value='$i' selected>$i</option>\n";
            } #if
            else {
                print "<option value='$i'>$i</option>\n";
            } # else
        } # foreach

        print "</select>\n";
        print "</td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'>Current value: $campaign{'last_message'}<br>Autoresponder has no messages\n";
        print "<input type='hidden' name='last_message' value='$campaign{'last_message'}'>\n";
        print "</td>\n";
    } # else

    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Status</b></td>\n";

    if ($fm{"status"} eq "A") {
        print "<td class='formcell' width='50%' valign='middle'><select name='status' size='1'><option value='A' selected>Active</option><option value='S'>Suspended</option><option value='U'>User cancelled</option><option value='F'>Finished</option><option value='X'>Failed</option></select></td>\n";
    } # if
    elsif ($fm{"status"} eq "S") {
        print "<td class='formcell' width='50%' valign='middle'><select name='status' size='1'><option value='A'>Active</option><option value='S' selected>Suspended</option><option value='U'>User cancelled</option><option value='F'>Finished</option><option value='X'>Failed</option></select></td>\n";
    } # elsif
    elsif ($fm{"status"} eq "U") {
        print "<td class='formcell' width='50%' valign='middle'><select name='status' size='1'><option value='A'>Active</option><option value='S'>Suspended</option><option value='U' selected>User cancelled</option><option value='F'>Finished</option><option value='X'>Failed</option></select></td>\n";
    } # elsif
    elsif ($fm{"status"} eq "F") {
        print "<td class='formcell' width='50%' valign='middle'><select name='status' size='1'><option value='A'>Active</option><option value='S'>Suspended</option><option value='U'>User cancelled</option><option value='F' selected>Finished</option><option value='X'>Failed</option></select></td>\n";
    } # elsif
    elsif ($fm{"status"} eq "X") {
        print "<td class='formcell' width='50%' valign='middle'><select name='status' size='1'><option value='A'>Active</option><option value='S'>Suspended</option><option value='U'>User cancelled</option><option value='F'>Finished</option><option value='X' selected>Failed</option></select></td>\n";
    } # elsif

    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Preferred format</b></td>\n";

    if ($fm{"format_preference"} eq "H") {
        print "<td class='formcell' width='50%' valign='middle'><select name='format_preference' size='1'><option value='D'>Default</option><option value='T'>Plain text</option><option value='H' selected>HTML</option></select></td>\n";
    } # if
    elsif ($fm{"format_preference"} eq "D") {
        print "<td class='formcell' width='50%' valign='middle'><select name='format_preference' size='1'><option value='D' selected>Default</option><option value='T'>Plain text</option><option value='H'>HTML</option></select></td>\n";
    } # elsif
    else {
        print "<td class='formcell' width='50%' valign='middle'><select name='format_preference' size='1'><option value='D'>Default</option><option value='T' selected>Plain text</option><option value='H'>HTML</option></select></td>\n";
    } # else

    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Save Changes  '> <input type='reset' value='  Reset Values  '></td>\n";
    print "</tr>\n";

    &CloseForm;

    &Spacer("1", "5");

    &PageCloser('form.first_name');
} # sub CampaignEditPage

sub ConfirmDeleteCampaign {
    my(%fm) = @_;
    $fm{"cid"} = $INFO{"cid"};

    $fm{"status"} = $INFO{"sta"};
    $fm{"autoresponder"} = $INFO{"aut"};
    $fm{"tracking_tag"} = $INFO{"tra"};
    $fm{"date_scope"} = $INFO{"dat"};
    $fm{"page"} = $INFO{"pag"};
    $fm{"omit_duplicates"} = $INFO{"dup"};

    if ($g_a2 eq 'pro') {
        &data_Delete($fm{"cid"});
        &Redirect("$g_thisscript?a0=cam&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$fm{'page'}&dup=$fm{'omit_duplicates'}");
    } # if

    my(%campaign) = &data_Load($fm{"cid"});
    my(%ar) = &data_Load($campaign{"autoresponder_id"});

    &PageHeading;
    &PageHeader("h_cam_delete.htm");
    &PageSubHeader("Subscribers &gt; Confirm Delete", "[<a class='subheaderlink' href='$g_thisscript?a0=cam&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$fm{'page'}&dup=$fm{'omit_duplicates'}' onmouseover='ShowTooltip(14);' onmouseout='HideTooltip(14);'>Return to Subscriber List</a>]");

    &Spacer("1", "25");

    my($sub_date) = &FormatDate($campaign{"subscribe_date"});
    my($disp_status);
    if ($campaign{"status"} eq "A") {$disp_status = "Active"}
    if ($campaign{"status"} eq "S") {$disp_status = "Suspended"}
    if ($campaign{"status"} eq "U") {$disp_status = "User cancelled"}
    if ($campaign{"status"} eq "F") {$disp_status = "Finished"}
    if ($campaign{"status"} eq "X") {$disp_status = "Failed"}

    &InfoHeading("$campaign{'email'}");
    &InfoBox("Autoresponder: $ar{'listens_on'}\@$g_settings{'your_domain'}<br>Follow-up sequence started on $sub_date<br>Current status: $disp_status");

    &OpenForm("form", "$g_thisscript?a0=cam&a1=con&a2=pro&cid=$fm{'cid'}&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$fm{'page'}&dup=$fm{'omit_duplicates'}");

    print "<tr>\n";
    print "<td class='wrapcell' colspan='2' valign='middle'><p>When you click <b>Confirm Delete</b>, this subscriber will be deleted permanently.</p></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Confirm Delete  '></td>\n";
    print "</tr>\n";

    &CloseForm;

    &Spacer("1", "5");

    &PageCloser("");
} # sub ConfirmDeleteCampaign

sub ConfirmDeleteMatchingCampaigns {
    my($fm);
    $fm{"list_status"} = $INFO{"sta"};
    $fm{"list_autoresponder"} = $INFO{"aut"};
    $fm{"list_tracking_tag"} = $INFO{"tra"};
    $fm{"list_date_scope"} = $INFO{"dat"};
    $fm{"list_page"} = $INFO{"pag"};
    $fm{"list_omit_duplicates"} = $INFO{"dup"};

    &PageHeading;

    &PageHeader("h_cam_deletebatch.htm");
    &PageSubHeader("Subscribers &gt; Batch Delete", "[<a class='subheaderlink' href='$g_thisscript?a0=cam&sta=$fm{'list_status'}&aut=$fm{'list_autoresponder'}&tra=$fm{'list_tracking_tag'}&dat=$fm{'list_date_scope'}&pag=$fm{'list_page'}&dup=$fm{'list_omit_duplicates'}' onmouseover='ShowTooltip(14);' onmouseout='HideTooltip(14);'>Return to Subscriber List</a>]");

    &Spacer("1", "25");

    &ListTableHeading("Delete all subscribers matching these criteria?");

    my($disp_ar);
    if ($fm{"list_autoresponder"} eq "all") {
        $disp_ar = "All";
    } # if
    else {
        my(%ar) = &data_Load($fm{"list_autoresponder"});
        $disp_ar = "$ar{'listens_on'}\@$g_settings{'your_domain'}";
    } # else

    my($disp_tt);
    if ($fm{"list_tracking_tag"} eq "all") {
        $disp_tt = "All";
    } # if
    elsif ($fm{"list_tracking_tag"} eq "none") {
        $disp_tt = "None";
    } # elsif
    else {
        $disp_tt = $fm{"list_tracking_tag"};
    } # else

    my($disp_st);
    if ($fm{"list_status"} eq "all") {
        $disp_st = "All";
    } # if
    elsif ($fm{"list_status"} eq "A") {
        $disp_st = "Active";
    } # elsif
    elsif ($fm{"list_status"} eq "S") {
        $disp_st = "Suspended";
    } # elsif
    elsif ($fm{"list_status"} eq "U") {
        $disp_st = "User cancelled";
    } # elsif
    elsif ($fm{"list_status"} eq "F") {
        $disp_st = "Finished";
    } # elsif
    elsif ($fm{"list_status"} eq "X") {
        $disp_st = "Failed";
    } # elsif

    my($disp_ds);
    if ($fm{"list_date_scope"} eq "all") {
        $disp_ds = "All";
    } # if
    elsif ($fm{"list_date_scope"} eq "T") {
        $disp_ds = "Today";
    } # elsif
    elsif ($fm{"list_date_scope"} eq "W") {
        $disp_ds = "This week";
    } # elsif
    elsif ($fm{"list_date_scope"} eq "M") {
        $disp_ds = "This month";
    } # elsif
    elsif ($fm{"list_date_scope"} eq "Y") {
        $disp_ds = "This year";
    } # elsif

    if ($fm{"list_omit_duplicates"}) {
        $disp_omit = "Yes"
    } # if
    else {
        $disp_omit = "No"
    } # else

    &FilterListTableSubHeading("<b>Filter: </b>Autoresponder = $disp_ar | Tracking tag = $disp_tt | Status = $disp_st | Date scope = $disp_ds | Omit duplicate subscribers = $disp_omit");

    &OpenForm("form", "$g_thisscript?a0=cam&a1=cls&a2=pro&sta=$fm{'list_status'}&aut=$fm{'list_autoresponder'}&tra=$fm{'list_tracking_tag'}&dat=$fm{'list_date_scope'}&pag=$fm{'list_page'}&dup=$fm{'list_omit_duplicates'}");

    print "<tr>\n";
    print "<td class='wrapcell' colspan='2' valign='middle'><p>When you click <b>Confirm Delete</b>, all matching subscribers will be permanently deleted.</p><p>Please wait for confirmation that the process is complete before taking any further action. This may take some time for long lists.</p></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Confirm Delete  '></td>\n";
    print "</tr>\n";

    &CloseForm;

    &Spacer("1", "5");

    &PageCloser('');
} # sub ConfirmDeleteMatchingCampaigns

sub ConfirmExport {
    my($fm);
    $fm{"list_status"} = $INFO{"sta"};
    $fm{"list_autoresponder"} = $INFO{"aut"};
    $fm{"list_tracking_tag"} = $INFO{"tra"};
    $fm{"list_date_scope"} = $INFO{"dat"};
    $fm{"list_page"} = $INFO{"pag"};
    $fm{"list_omit_duplicates"} = $INFO{"dup"};

    &PageHeading;

    &PageHeader("h_cam_export.htm");
    &PageSubHeader("Subscribers &gt; Export", "[<a class='subheaderlink' href='$g_thisscript?a0=cam&sta=$fm{'list_status'}&aut=$fm{'list_autoresponder'}&tra=$fm{'list_tracking_tag'}&dat=$fm{'list_date_scope'}&pag=$fm{'list_page'}&dup=$fm{'list_omit_duplicates'}' onmouseover='ShowTooltip(14);' onmouseout='HideTooltip(14);'>Return to Subscriber List</a>]");

    &Spacer("1", "25");

    &ListTableHeading("Export all subscribers matching these criteria?");

    my($disp_ar);
    if ($fm{"list_autoresponder"} eq "all") {
        $disp_ar = "All";
    } # if
    else {
        my(%ar) = &data_Load($fm{"list_autoresponder"});
        $disp_ar = "$ar{'listens_on'}\@$g_settings{'your_domain'}";
    } # else

    my($disp_tt);
    if ($fm{"list_tracking_tag"} eq "all") {
        $disp_tt = "All";
    } # if
    elsif ($fm{"list_tracking_tag"} eq "none") {
        $disp_tt = "None";
    } # elsif
    else {
        $disp_tt = $fm{"list_tracking_tag"};
    } # else

    my($disp_st);
    if ($fm{"list_status"} eq "all") {
        $disp_st = "All";
    } # if
    elsif ($fm{"list_status"} eq "A") {
        $disp_st = "Active";
    } # elsif
    elsif ($fm{"list_status"} eq "S") {
        $disp_st = "Suspended";
    } # elsif
    elsif ($fm{"list_status"} eq "U") {
        $disp_st = "User cancelled";
    } # elsif
    elsif ($fm{"list_status"} eq "F") {
        $disp_st = "Finished";
    } # elsif
    elsif ($fm{"list_status"} eq "X") {
        $disp_st = "Failed";
    } # elsif

    my($disp_ds);
    if ($fm{"list_date_scope"} eq "all") {
        $disp_ds = "All";
    } # if
    elsif ($fm{"list_date_scope"} eq "T") {
        $disp_ds = "Today";
    } # elsif
    elsif ($fm{"list_date_scope"} eq "W") {
        $disp_ds = "This week";
    } # elsif
    elsif ($fm{"list_date_scope"} eq "M") {
        $disp_ds = "This month";
    } # elsif
    elsif ($fm{"list_date_scope"} eq "Y") {
        $disp_ds = "This year";
    } # elsif

    if ($fm{"list_omit_duplicates"}) {
        $disp_omit = "Yes"
    } # if
    else {
        $disp_omit = "No"
    } # else

    &FilterListTableSubHeading("<b>Filter: </b>Autoresponder = $disp_ar | Tracking tag = $disp_tt | Status = $disp_st | Date scope = $disp_ds | Omit duplicate subscribers = $disp_omit");

    &OpenForm("form", "$g_thisscript?a0=cam&a1=dex&sta=$fm{'list_status'}&aut=$fm{'list_autoresponder'}&tra=$fm{'list_tracking_tag'}&dat=$fm{'list_date_scope'}&pag=$fm{'list_page'}&dup=$fm{'list_omit_duplicates'}");

    print "<tr>\n";
    print "<td class='wrapcell' colspan='2' valign='middle'><p>Data will be exported to the file <b>export.csv</b> in the directory <b>$_data_path</b> on your server. The file format will be:</p><p>\"first_name\",\"last_name\",\"full_name\",\"email_address\"</p><p>There will be one subscriber per line.</p><p>Warning: If <b>export.csv</b> exists, it will be overwritten.</p><p>When you click <b>Confirm Export</b>, please wait for confirmation that the process is complete before taking any further action. This may take some time for long lists.</p></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Confirm Export  '></td>\n";
    print "</tr>\n";

    &CloseForm;

    &Spacer("1", "5");

    &PageCloser('');
} # sub ConfirmExport

sub CampaignsFilterDelete {
    my($fm);
    $fm{"status"} = $INFO{"sta"};
    $fm{"autoresponder"} = $INFO{"aut"};
    $fm{"tracking_tag"} = $INFO{"tra"};
    $fm{"date_scope"} = $INFO{"dat"};
    $fm{"page"} = $INFO{"pag"};
    $fm{"omit_duplicates"} = $INFO{"dup"};

    dbmopen(%db_cam, "$_data_path/CAM", 0666);
    if ($g_settings{'file_locking'}) {flock(db_cam, 2)}
    my(@keys) = keys(%db_cam);

    my($key, $fileline, %thiscam);
    $numdeleted = 0;
    my(%emaillist);
    foreach $key (@keys) {
        $fileline = $db_cam{$key};
        %thiscam = &data_GetRecord($fileline);
        my($ok) = 1;

        if (($fm{"autoresponder"} ne "all") and ($fm{"autoresponder"} ne $thiscam{"autoresponder_id"})) {
            $ok = 0;
        } # if
        if ($fm{"tracking_tag"} eq "none") {
            $fm{"tracking_tag"} = "";
            $reset_tt = 1;
        } # if
        if (($fm{"tracking_tag"} ne "all") and (lc($fm{"tracking_tag"}) ne lc($thiscam{"tracking_tag"}))) {
            $ok = 0;
        } # if
        if ($reset_tt) {$fm{"tracking_tag"} = "none"}
        if (($fm{"status"} ne "all") and ($fm{"status"} ne $thiscam{"status"})) {
            $ok = 0;
        } # if
        if ($fm{"date_scope"} ne "all") {
            if (($fm{"date_scope"} eq "T") and (! &IsToday($thiscam{"subscribe_date"}))) {
                $ok = 0;
            } # if
            elsif (($fm{"date_scope"} eq "W") and (! &IsThisWeek($thiscam{"subscribe_date"}))) {
                $ok = 0;
            } # if
            elsif (($fm{"date_scope"} eq "M") and (! &IsThisMonth($thiscam{"subscribe_date"}))) {
                $ok = 0;
            } # if
            elsif (($fm{"date_scope"} eq "Y") and (! &IsThisYear($thiscam{"subscribe_date"}))) {
                $ok = 0;
            } # if
        } # if

        if ($fm{"omit_duplicates"}) {
            if ($emaillist{$thiscam{"email"}}) {
                $ok = 0;
            } # if
        } # if

        if ($ok) {
            $emaillist{$thiscam{"email"}} = 1;
            $numdeleted ++;
            delete($db_cam{$key});
        } # if
    } # foreach

    dbmclose(%db_cam);
    if ($g_settings{'file_locking'}) {flock(db_cam, 8)}

    &Redirect ("$g_thisscript?a0=cam&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$fm{'page'}&dup=$fm{'omit_duplicates'}&m=$numdeleted subscribers deleted");
} # sub CampaignsFilterDelete

sub Export {
    my($fm);
    $fm{"status"} = $INFO{"sta"};
    $fm{"autoresponder"} = $INFO{"aut"};
    $fm{"tracking_tag"} = $INFO{"tra"};
    $fm{"date_scope"} = $INFO{"dat"};
    $fm{"page"} = $INFO{"pag"};
    $fm{"omit_duplicates"} = $INFO{"dup"};

    dbmopen(%db_cam, "$_data_path/CAM", 0666);
    if ($g_settings{'file_locking'}) {flock(db_cam, 2)}
    my(@keys) = keys(%db_cam);

    open (FILE, ">$_data_path/export.csv");
    if ($g_settings{'file_locking'}) {flock(FILE, 2)}

    my($key, $fileline, %thiscam);
    $numexported = 0;
    my(%emaillist);
    foreach $key (@keys) {
        $fileline = $db_cam{$key};
        %thiscam = &data_GetRecord($fileline);
        my($ok) = 1;

        if (($fm{"autoresponder"} ne "all") and ($fm{"autoresponder"} ne $thiscam{"autoresponder_id"})) {
            $ok = 0;
        } # if
        if ($fm{"tracking_tag"} eq "none") {
            $fm{"tracking_tag"} = "";
            $reset_tt = 1;
        } # if
        if (($fm{"tracking_tag"} ne "all") and (lc($fm{"tracking_tag"}) ne lc($thiscam{"tracking_tag"}))) {
            $ok = 0;
        } # if
        if ($reset_tt) {$fm{"tracking_tag"} = "none"}
        if (($fm{"status"} ne "all") and ($fm{"status"} ne $thiscam{"status"})) {
            $ok = 0;
        } # if
        if ($fm{"date_scope"} ne "all") {
            if (($fm{"date_scope"} eq "T") and (! &IsToday($thiscam{"subscribe_date"}))) {
                $ok = 0;
            } # if
            elsif (($fm{"date_scope"} eq "W") and (! &IsThisWeek($thiscam{"subscribe_date"}))) {
                $ok = 0;
            } # if
            elsif (($fm{"date_scope"} eq "M") and (! &IsThisMonth($thiscam{"subscribe_date"}))) {
                $ok = 0;
            } # if
            elsif (($fm{"date_scope"} eq "Y") and (! &IsThisYear($thiscam{"subscribe_date"}))) {
                $ok = 0;
            } # if
        } # if

        if ($fm{"omit_duplicates"}) {
            if ($emaillist{$thiscam{"email"}}) {
                $ok = 0;
            } # if
        } # if

        if ($ok) {
            $emaillist{$thiscam{"email"}} = 1;
            $numexported ++;
            print FILE "\"$thiscam{'first_name'}\",\"$thiscam{'last_name'}\",\"$thiscam{'full_name'}\",\"$thiscam{'email'}\"\n";
        } # if
    } # foreach

    close FILE;
    if ($g_settings{'file_locking'}) {flock(FILE, 8)}

    dbmclose(%db_cam);
    if ($g_settings{'file_locking'}) {flock(db_cam, 8)}

    &Redirect ("$g_thisscript?a0=cam&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$fm{'page'}&dup=$fm{'omit_duplicates'}&m=$numexported subscriber(s) exported");
} # sub Export

sub Import {
    my(%fm);
    $fm{"list_status"} = $INFO{"sta"};
    $fm{"list_autoresponder"} = $INFO{"aut"};
    $fm{"list_tracking_tag"} = $INFO{"tra"};
    $fm{"list_date_scope"} = $INFO{"dat"};
    $fm{"list_page"} = $INFO{"pag"};
    $fm{"list_omit_duplicates"} = $INFO{"dup"};

    if ($g_a2 eq "pro") {
        $fm{"first_name"} = &Trim($FORM{"first_name"});
        $fm{"last_name"} = &Trim($FORM{"last_name"});
        $fm{"full_name"} = &Trim($FORM{"full_name"});
        $fm{"email"} = &Trim(lc($FORM{"email"}));
        $fm{"format"} = &Trim(lc($FORM{"format"}));
        $fm{"plain_format"} = &Trim($FORM{"plain_format"});
        $fm{"html_format"} = &Trim($FORM{"html_format"});
        $fm{"default_format"} = $FORM{"default_format"};
        $fm{"autoresponder_id"} = &Trim($FORM{"autoresponder_id"});
        $fm{"tracking_tag"} = &Trim($FORM{"tracking_tag"});
        $fm{"status"} = &Trim($FORM{"status"});
        $fm{"import_data"} = &Trim($FORM{"import_data"});
        $g_message = &validate_Import(%fm);
        if (! $g_message) {
            my(@list) = split(/\n/, $fm{"import_data"});
            my($numadded) = 0;
            foreach $line (@list) {
                $line =~s/\s$//g;
                $line =~s/"//g;
                @fields = split(/,/, $line);

                if (! &IsValidEmailAddress($fields[$fm{"email"}-1])) {next}

                my(%campaign) = &data_New("CAM");
                $campaign{"autoresponder_id"} = $fm{"autoresponder_id"};
                if ($fm{"first_name"}) {
                    $campaign{"first_name"} = $fields[$fm{"first_name"}-1];
                } # if
                if ($fm{"last_name"}) {
                    $campaign{"last_name"} = $fields[$fm{"last_name"}-1];
                } # if
                if ($fm{"full_name"}) {
                    $campaign{"full_name"} = $fields[$fm{"full_name"}-1];
                } # if
                $campaign{"email"} = $fields[$fm{"email"}-1];

                $campaign{"format_preference"} = $fm{"default_format"};
                if ((&Trim(lc($fields[$fm{"format"}-1])) ne "") and (&Trim(lc($fm{"plain_format"})) ne "")) {
                    if (&Trim(lc($fields[$fm{"format"}-1])) eq &Trim(lc($fm{"plain_format"}))) {
                        $campaign{"format_preference"} = "T";
                    } # if
                } # if
                if ((&Trim(lc($fields[$fm{"format"}-1])) ne "") and (&Trim(lc($fm{"html_format"})) ne "")) {
                    if (&Trim(lc($fields[$fm{"format"}-1])) eq &Trim(lc($fm{"html_format"}))) {
                        $campaign{"format_preference"} = "H";
                    } # if
                } # if

                if ($fm{"tracking_tag"} eq "none") {
                    $campaign{"tracking_tag"} = "";
                } # if
                else {
                    $campaign{"tracking_tag"} = $fm{"tracking_tag"};
                } # else

                $campaign{"parent_id"} = $fm{"autoresponder_id"};
                $campaign{"status"} = $fm{"status"};
                $campaign{"source"} = "I";
                &data_Save(%campaign);
                $numadded ++;
            } # foreach
            &Redirect("$g_thisscript?a0=cam&m=$numadded subscribers successfully imported");
        } # if
        else {
            $g_a2 = "con";
        } # else
    } # if
    else {
        $fm{"email"} = "1";
        $fm{"first_name"} = "2";
        $fm{"last_name"} = "3";
        $fm{"full_name"} = "4";
        $fm{"format"} = "5";
        $fm{"plain_format"} = "";
        $fm{"html_format"} = "";
        $fm{"default_format"} = "D";
        $fm{"import_data"} = "";
        $fm{"status"} = "A";
    } # else

    &PageHeading;
    &PageHeader("h_cam_import.htm");
    &PageSubHeader("Subscribers &gt; Import", "[<a class='subheaderlink' href='$g_thisscript?a0=cam&sta=$fm{'list_status'}&aut=$fm{'list_autoresponder'}&tra=$fm{'list_tracking_tag'}&dat=$fm{'list_date_scope'}&pag=$fm{'list_page'}&dup=$fm{'list_omit_duplicates'}' onmouseover='ShowTooltip(14);' onmouseout='HideTooltip(14);'>Return to Subscriber List</a>]");
    &Spacer("1", "5");

    if ($g_a2 eq "con") {
        my($import_data) = &LoadText("$_data_path/import.csv");

        &OpenForm("form", "$g_thisscript?a0=cam&a1=imp&a2=pro");        

        print "<tr>\n";
        print "<td class='formcell' width='50%' valign='middle' align='right'><b>E-mail address field number (required)</b><br>eg 1</td>\n";
        $size = &FieldSize(4);
        print "<td class='formcell' width='50%' valign='middle'><input type='text' name='email' size='$size' maxlength='2' value='$fm{'email'}'></td>\n";
        print "</tr>\n";

        print "<tr>\n";
        print "<td class='formcell' width='50%' valign='middle' align='right'><b>First name field number (optional)</b><br>eg 2 - leave blank if not used</td>\n";
        $size = &FieldSize(4);
        print "<td class='formcell' width='50%' valign='middle'><input type='text' name='first_name' size='$size' maxlength='2' value='$fm{'first_name'}'></td>\n";
        print "</tr>\n";

        print "<tr>\n";
        print "<td class='formcell' width='50%' valign='middle' align='right'><b>Last name field number (optional)</b><br>eg 3 - leave blank if not used</td>\n";
        $size = &FieldSize(4);
        print "<td class='formcell' width='50%' valign='middle'><input type='text' name='last_name' size='$size' maxlength='2' value='$fm{'last_name'}'></td>\n";
        print "</tr>\n";

        print "<tr>\n";
        print "<td class='formcell' width='50%' valign='middle' align='right'><b>Full name field number (optional)</b><br>eg 4 - leave blank if not used</td>\n";
        $size = &FieldSize(4);
        print "<td class='formcell' width='50%' valign='middle'><input type='text' name='full_name' size='$size' maxlength='2' value='$fm{'full_name'}'></td>\n";
        print "</tr>\n";

        print "<tr>\n";
        print "<td class='formcell' width='50%' valign='middle' align='right'><b>Format preference field number (optional)</b><br>eg 5 - leave blank if not used</td>\n";
        $size = &FieldSize(4);
        print "<td class='formcell' width='50%' valign='middle'><input type='text' name='format' size='$size' maxlength='2' value='$fm{'format'}'></td>\n";
        print "</tr>\n";

        print "<tr>\n";
        print "<td class='formcell' width='50%' valign='middle' align='right'><b>Plain text format field entry (optional)</b><br>What entry in the format preference field denotes that<br>the format preference is plain text?</td>\n";
        $size = &FieldSize(30);
        print "<td class='formcell' width='50%' valign='middle'><input type='text' name='plain_format' size='$size' value='$fm{'plain_format'}'></td>\n";
        print "</tr>\n";

        print "<tr>\n";
        print "<td class='formcell' width='50%' valign='middle' align='right'><b>HTML format field entry (optional)</b><br>What entry in the format preference field denotes that<br>the format preference is HTML?</td>\n";
        $size = &FieldSize(30);
        print "<td class='formcell' width='50%' valign='middle'><input type='text' name='html_format' size='$size' value='$fm{'html_format'}'></td>\n";
        print "</tr>\n";

        print "<tr>\n";
        print "<td class='formcell' width='50%' valign='middle' align='right'><b>Default format</b><br>Use this format when the imported data<br>does not contain a preference</td>\n";

        if ($fm{"default_format"} eq "H") {
            print "<td class='formcell' width='50%' valign='middle'><select name='default_format' size='1'><option value='D'>Default</option><option value='T'>Plain text</option><option value='H' selected>HTML</option></select></td>\n";
        } # if
        elsif ($fm{"default_format"} eq "D") {
            print "<td class='formcell' width='50%' valign='middle'><select name='default_format' size='1'><option value='D' selected>Default</option><option value='T'>Plain text</option><option value='H'>HTML</option></select></td>\n";
        } # if
        else {
            print "<td class='formcell' width='50%' valign='middle'><select name='default_format' size='1'><option value='D'>Default</option><option value='T' selected>Plain text</option><option value='H'>HTML</option></select></td>\n";
        } # else

        print "</tr>\n";

	    print "<tr>\n";
	    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Autoresponder</b></td>\n";
	    print "<td class='formcell' width='50%' valign='middle'>\n";
	    dbmopen(%db_aut, "$_data_path/AUT", undef);
	    if ($g_settings{'file_locking'}) {flock(db_aut, 2)}
	    my(@keys) = sort(keys(%db_aut));
	    if (@keys) {
	        print "<select name='autoresponder_id' size='1'>\n";
	        my($key, $fileline, %thisar);
	        foreach $key (@keys) {
	            $fileline = $db_aut{$key};
	            %thisar = &data_GetRecord($fileline);
	            if ($fm{'autoresponder_id'} eq $thisar{'id'}) {
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
        print "<td class='formcell' width='50%' valign='middle' align='right'><b>Tracking tag</b><br>To be associated with the imported subscribers</td>\n";
        print "<td class='formcell' width='50%' valign='middle'>\n";
	    print "<select name='tracking_tag' size='1'>\n";
	    print "<option value='none'>None</option>\n";
	    dbmopen(%db_tra, "$_data_path/TRA", undef);
	    if ($g_settings{'file_locking'}) {flock(db_tra, 2)}
	    my(@keys) = sort(keys(%db_tra));
	    if (@keys) {
	        my($key, $fileline, %thistt);
	        foreach $key (@keys) {
	            $fileline = $db_tra{$key};
	            %thistt = &data_GetRecord($fileline);
	            if ($fm{'tracking_tag'} eq $thistt{'tag'}) {
	                print "<option value='$thistt{'tag'}' selected>$thistt{'tag'}</option>\n";
	            } # if
	            else {
	                print "<option value='$thistt{'tag'}'>$thistt{'tag'}</option>\n";
	            } # else
	        } # foreach
	        print "</select>\n";
	    } # if
	    dbmclose(%db_tra);
	    if ($g_settings{'file_locking'}) {flock(db_tra, 8)}

	    print "</td>\n";
	    print "</tr>\n";

        print "<tr>\n";
        print "<td class='formcell' width='50%' valign='middle' align='right'><b>Initial status</b></td>\n";

        if ($fm{"status"} eq "A") {
            print "<td class='formcell' width='50%' valign='middle'><select name='status' size='1'><option value='A' selected>Active</option><option value='S'>Suspended</option><option value='F'>Finished</option></select></td>\n";
        } # if
        elsif ($fm{"status"} eq "S") {
            print "<td class='formcell' width='50%' valign='middle'><select name='status' size='1'><option value='A'>Active</option><option value='S' selected>Suspended</option><option value='F'>Finished</option></select></td>\n";
        } # elsif
        elsif ($fm{"status"} eq "F") {
            print "<td class='formcell' width='50%' valign='middle'><select name='status' size='1'><option value='A'>Active</option><option value='S'>Suspended</option><option value='F' selected>Finished</option></select></td>\n";
        } # elsif

        print "</tr>\n";

        print "<tr>\n";
        print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>Imported Data</b></td>\n";
        print "</tr>\n";

        print "<tr>\n";
        $size = &FieldSize(70);
        print "<td class='formcell' align='center' colspan='2'><textarea rows='8' name='import_data' cols='$size'>\n";
        print $import_data;
        print "</textarea>\n";
        print "</td>\n";
        print "</tr>\n";

        print "<tr>\n";
        print "<td class='wrapcell' colspan='2' valign='middle'><p>Note: Entries which do not have a valid e-mail address in the stated field will be ignored.</p><p>If the autoresponder has an immediate message, it will be sent out with the next batch of follow-ups.</p><p>Click <b>Create Subscribers</b> once only and please wait for confirmation that the process is complete before taking any further action. This may take some time for long lists.</p></td>\n";
        print "</tr>\n";

        print "<tr>\n";
        print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Create Subscribers  '> <input type='reset' value='  Reset Values  '></td>\n";
        print "</tr>\n";

        &CloseForm;
        &Spacer("1", "5");
        &PageCloser("form.email");
    } # if
    else {
        &OpenImportForm("form", "$g_settings{'cgi_arplus_url'}/import.pl?a0=cam&a1=imp");

        print "<tr>\n";
        print "<td class='wrapcell' colspan='2' valign='middle'><p>You can upload a comma separated variable (CSV) file containing subscriber data. Follow-up sequences will be automatically created for each subscriber in the file.</p><p>The file must have one record per line. The field may be enclosed in double-quotes (\"\") although this is not necessary. Here is an example of a valid file structure...</p><p>field_1,field_2,field_3,field_4, ..., field_n<br>field_1,field_2,field_3,field_4, ..., field_n</p><p>When the import is complete, you will be shown the data and asked to say which of the fields represents the subscriber's first name, last name, full name, e-mail address and preferred message format. The e-mail address is the only required field.</p><p>After selecting your file and clicking <b>Start Import</b>, please wait for confirmation that the process is complete before taking any further action. This may take some time for long lists.</p><p>Note: The file you choose must have a standard DOS 8.3 filename (eg no spaces).</p></td>\n";
        print "</tr>\n";

        print "<tr>\n";
        print "<td class='formcell' width='50%' valign='middle' align='right'><b>File to upload</b></td>\n";
        print "<td class='formcell' valign='middle'>\n";
        print "<input type='file' name='upload_file'>\n";
        print "</td>\n";
        print "</tr>\n";

        print "<tr>\n";
        print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Start Import  '></td>\n";
        print "</tr>\n";

        &CloseForm;
        &Spacer("1", "5");
        &PageCloser("");
    } # else
} # sub Import

sub BatchEmail {
    $fm{"status"} = $INFO{"sta"};
    $fm{"autoresponder"} = $INFO{"aut"};
    $fm{"tracking_tag"} = $INFO{"tra"};
    $fm{"date_scope"} = $INFO{"dat"};
    $fm{"page"} = $INFO{"pag"};
    $fm{"omit_duplicates"} = $INFO{"dup"};

    if ($g_a2 eq "pro") {
        $fm{"from_name"} = &Trim($FORM{"from_name"});
        $fm{"from_email"} = &Trim(lc($FORM{"from_email"}));
        $fm{"subject"} = &Trim($FORM{"subject"});
        $fm{"plain_body"} = &Trim($FORM{"plain_body"});
        $fm{"html_body"} = &Trim($FORM{"html_body"});
        $fm{"format_preference"} = $FORM{"format_preference"};
        $fm{"schedule"} = $FORM{"schedule"};
        $fm{"omit_unsubscribers"} = $FORM{"omit_unsubscribers"};
        $fm{"test_only"} = $FORM{"test_only"};

        $g_message = &validate_BatchEmail(%fm);
        if (! $g_message) {
            if ($fm{"test_only"}) {
                my(%profile) = &data_Load("OWN00000000");

                if ((! $profile{"email"}) or (! IsValidEmailAddress($profile{"email"}))) {
                    $g_message = "Cannot Test. Your profile does not contain a valid e-mail address";
                } # if
                else {
                    my(%campaign) = &data_New("CAM");
                    $campaign{"full_name"} = "Autoresponse Plus Administrator";
                    $campaign{"email"} = $profile{"email"};
                    $campaign{"autoresponder_id"} = $fm{"id"};
                    $campaign{"status"} = "A";
                    $campaign{"subscribe_date"} = time;
                    $campaign{"source"} = "T";
                    $campaign{"format_preference"} = "T";
                    &data_Save(%campaign);
                    &SendDirectMessage($campaign{"id"}, $campaign{"full_name"}, $campaign{"email"}, $fm{"subject"}, $fm{"plain_body"}, $fm{"html_body"}, "T");
                    $campaign{"format_preference"} = "H";
                    &data_Save(%campaign);
                    &SendDirectMessage($campaign{"id"}, $campaign{"full_name"}, $campaign{"email"}, $fm{"subject"}, $fm{"plain_body"}, $fm{"html_body"}, "T");
                    &data_Delete($campaign{"id"});
                    $g_message = "Test messages have been sent to $campaign{'email'}";
                } # else
            } # if
            else {
                &DoBatchEmail(%fm);
                exit;
            } # else
        } # if
    } # if
    else {
        my(%profile) = &data_Load("OWN00000000");

        $fm{"from_name"} = $profile{'my_company'};
        $fm{"from_email"} = $profile{'my_email1'};
        $fm{"subject"} = '';
        $fm{"email"} = $campaign{"email"};
        $fm{"plain_body"} = '';
        $fm{"html_body"} = '';
        $fm{"format_preference"} = 'D';
        $fm{"schedule"} = "NEX";
        $fm{"omit_unsubscribers"} = "1";
        $fm{"test_only"} = "";
    } # else

    &PageHeading;

    &PageHeader("h_cam_batchemail.htm");
    &PageSubHeader("Subscribers &gt; Batch E-mail", "[<a class='subheaderlink' href='$g_thisscript?a0=cam&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$fm{'page'}&dup=$fm{'omit_duplicates'}' onmouseover='ShowTooltip(14);' onmouseout='HideTooltip(14);'>Return to Subscriber List</a>]");

    &Spacer("1", "25");

    &ListTableHeading("Send one-off e-mail to all subscribers matching these criteria");

    my($disp_ar);
    if ($fm{"autoresponder"} eq "all") {
        $disp_ar = "All";
    } # if
    else {
        my(%ar) = &data_Load($fm{"autoresponder"});
        $disp_ar = "$ar{'listens_on'}\@$g_settings{'your_domain'}";
    } # else

    my($disp_tt);
    if ($fm{"tracking_tag"} eq "all") {
        $disp_tt = "All";
    } # if
    elsif ($fm{"tracking_tag"} eq "none") {
        $disp_tt = "None";
    } # elsif
    else {
        $disp_tt = $fm{"tracking_tag"};
    } # else

    my($disp_st);
    if ($fm{"status"} eq "all") {
        $disp_st = "All";
    } # if
    elsif ($fm{"status"} eq "A") {
        $disp_st = "Active";
    } # elsif
    elsif ($fm{"status"} eq "S") {
        $disp_st = "Suspended";
    } # elsif
    elsif ($fm{"status"} eq "U") {
        $disp_st = "User cancelled";
    } # elsif
    elsif ($fm{"status"} eq "F") {
        $disp_st = "Finished";
    } # elsif
    elsif ($fm{"status"} eq "X") {
        $disp_st = "Failed";
    } # elsif

    my($disp_ds);
    if ($fm{"date_scope"} eq "all") {
        $disp_ds = "All";
    } # if
    elsif ($fm{"date_scope"} eq "T") {
        $disp_ds = "Today";
    } # elsif
    elsif ($fm{"date_scope"} eq "W") {
        $disp_ds = "This week";
    } # elsif
    elsif ($fm{"date_scope"} eq "M") {
        $disp_ds = "This month";
    } # elsif
    elsif ($fm{"date_scope"} eq "Y") {
        $disp_ds = "This year";
    } # elsif

    if ($fm{"omit_duplicates"}) {
        $disp_omit = "Yes"
    } # if
    else {
        $disp_omit = "No"
    } # else

    &FilterListTableSubHeading("<b>Filter: </b>Autoresponder = $disp_ar | Tracking tag = $disp_tt | Status = $disp_st | Date scope = $disp_ds | Omit duplicate subscribers = $disp_omit");

    &OpenForm("form", "$g_thisscript?a0=cam&a1=ema&a2=pro&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$fm{'page'}&dup=$fm{'omit_duplicates'}");

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>From name</b><br>eg Your Company Name</td>\n";
    $size = &FieldSize(30);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='from_name' size='$size' value='$fm{'from_name'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>From e-mail address</b><br>eg team\@yourcompany.com</td>\n";
    $size = &FieldSize(30);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='from_email' size='$size' value='$fm{'from_email'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Subject</b></td>\n";
    $size = &FieldSize(30);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='subject' size='$size' value='$fm{'subject'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>Plain Text Message</b><br>Type or use CTRL+V to paste from clipboard</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    $size = &FieldSize(70);
    print "<td class='formcell' align='center' colspan='2'><textarea rows='16' name='plain_body' cols='$size'>\n";
    print $fm{'plain_body'};
    print "</textarea>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>HTML Message Code</b><br>Type or use CTRL+V to paste from clipboard</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    $size = &FieldSize(70);
    print "<td class='formcell' align='center' colspan='2'><textarea rows='16' name='html_body' cols='$size'>\n";
    print $fm{'html_body'};
    print "</textarea>\n";
    print "</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Default format</b><br>Use this format when the subscriber record<br>does not contain a preference</td>\n";

    if ($fm{"format_preference"} eq "H") {
        print "<td class='formcell' width='50%' valign='middle'><select name='format_preference' size='1'><option value='T'>Plain text</option><option value='H' selected>HTML</option></select></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><select name='format_preference' size='1'><option value='T' selected>Plain text</option><option value='H'>HTML</option></select></td>\n";
    } # else

    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Schedule</b><br>When should this message be sent?</td>\n";
    if ($fm{"schedule"} eq "NEX") {
        print "<td class='formcell' width='50%' valign='middle'><select name='schedule' size='1'><option value='NEX' selected>Next Run</option><option value='1'>Monday</option><option value='2'>Tuesday</option><option value='3'>Wednesday</option><option value='4'>Thursday</option><option value='5'>Friday</option><option value='6'>Saturday</option><option value='7'>Sunday</option></select></td>\n";
    } # if
    elsif ($fm{"schedule"} eq "1") {
        print "<td class='formcell' width='50%' valign='middle'><select name='schedule' size='1'><option value='NEX'>Next Run</option><option value='1' selected>Monday</option><option value='2'>Tuesday</option><option value='3'>Wednesday</option><option value='4'>Thursday</option><option value='5'>Friday</option><option value='6'>Saturday</option><option value='7'>Sunday</option></select></td>\n";
    } # elsif
    elsif ($fm{"schedule"} eq "2") {
        print "<td class='formcell' width='50%' valign='middle'><select name='schedule' size='1'><option value='NEX'>Next Run</option><option value='1'>Monday</option><option value='2' selected>Tuesday</option><option value='3'>Wednesday</option><option value='4'>Thursday</option><option value='5'>Friday</option><option value='6'>Saturday</option><option value='7'>Sunday</option></select></td>\n";
    } # elsif
    elsif ($fm{"schedule"} eq "3") {
        print "<td class='formcell' width='50%' valign='middle'><select name='schedule' size='1'><option value='NEX'>Next Run</option><option value='1'>Monday</option><option value='2'>Tuesday</option><option value='3' selected>Wednesday</option><option value='4'>Thursday</option><option value='5'>Friday</option><option value='6'>Saturday</option><option value='7'>Sunday</option></select></td>\n";
    } # elsif
    elsif ($fm{"schedule"} eq "4") {
        print "<td class='formcell' width='50%' valign='middle'><select name='schedule' size='1'><option value='NEX'>Next Run</option><option value='1'>Monday</option><option value='2'>Tuesday</option><option value='3'>Wednesday</option><option value='4' selected>Thursday</option><option value='5'>Friday</option><option value='6'>Saturday</option><option value='7'>Sunday</option></select></td>\n";
    } # elsif
    elsif ($fm{"schedule"} eq "5") {
        print "<td class='formcell' width='50%' valign='middle'><select name='schedule' size='1'><option value='NEX'>Next Run</option><option value='1'>Monday</option><option value='2'>Tuesday</option><option value='3'>Wednesday</option><option value='4'>Thursday</option><option value='5' selected>Friday</option><option value='6'>Saturday</option><option value='7'>Sunday</option></select></td>\n";
    } # elsif
    elsif ($fm{"schedule"} eq "6") {
        print "<td class='formcell' width='50%' valign='middle'><select name='schedule' size='1'><option value='NEX'>Next Run</option><option value='1'>Monday</option><option value='2'>Tuesday</option><option value='3'>Wednesday</option><option value='4'>Thursday</option><option value='5'>Friday</option><option value='6' selected>Saturday</option><option value='7'>Sunday</option></select></td>\n";
    } # elsif
    elsif ($fm{"schedule"} eq "7") {
        print "<td class='formcell' width='50%' valign='middle'><select name='schedule' size='1'><option value='NEX'>Next Run</option><option value='1'>Monday</option><option value='2'>Tuesday</option><option value='3'>Wednesday</option><option value='4'>Thursday</option><option value='5'>Friday</option><option value='6'>Saturday</option><option value='7' selected>Sunday</option></select></td>\n";
    } # elsif
    else {
        print "<td class='formcell' width='50%' valign='middle'><select name='schedule' size='1'><option value='INT' selected>Use Interval</option><option value='NEX'>Next Run</option><option value='1'>Monday</option><option value='2'>Tuesday</option><option value='3'>Wednesday</option><option value='4'>Thursday</option><option value='5'>Friday</option><option value='6'>Saturday</option><option value='7'>Sunday</option></select></td>\n";
    } # else
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Omit unsubscribers?</b><br>Force the omission of unsubscribers<br>regardless of the current filter</td>\n";

    if ($fm{"omit_unsubscribers"}) {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='omit_unsubscribers' value='1' checked></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='omit_unsubscribers' value='1'></td>\n";
    } # else

    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Test only?</b><br>Send test messages to your e-mail address<br>as defined in Your Profile</td>\n";

    if ($fm{"test_only"}) {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='test_only' value='1' checked></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='test_only' value='1'></td>\n";
    } # else

    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Start  '></td>\n";
    print "</tr>\n";

    &CloseForm;

    &Spacer("1", "5");

    &PageCloser('form.from_name');
} # sub BatchEmail

sub DoBatchEmail {
    %fm = @_;

    $file_root = &RandomValue('abcdefghjklmnprstvwxyz',8);
    &SaveText($fm{'plain_body'}, "$_data_path/$file_root.pln");
    &SaveText($fm{'html_body'}, "$_data_path/$file_root.htm");

    open (FILE, ">>$_data_path/mail.queue");
    if ($g_settings{'file_locking'}) {flock(FILE, 2)}
    print FILE "$file_root" . "|" . $fm{"schedule"} . "\n";
    close FILE;
    if ($g_settings{'file_locking'}) {flock(FILE, 8)}

    open (FILE, ">$_data_path/$file_root.queue");
    if ($g_settings{'file_locking'}) {flock(FILE, 2)}        

    dbmopen(%db_cam, "$_data_path/CAM", 0666);
    if ($g_settings{'file_locking'}) {flock(db_cam, 2)}
    my(@keys) = keys(%db_cam);

    my($key, $fileline, %thiscam);
    $numsent = 0;
    my(%emaillist);
    foreach $key (@keys) {
        $fileline = $db_cam{$key};
        %thiscam = &data_GetRecord($fileline);
        my($ok) = 1;

        if (($fm{"autoresponder"} ne "all") and ($fm{"autoresponder"} ne $thiscam{"autoresponder_id"})) {
            $ok = 0;
        } # if
        if ($fm{"tracking_tag"} eq "none") {
            $fm{"tracking_tag"} = "";
            $reset_tt = 1;
        } # if
        if (($fm{"tracking_tag"} ne "all") and (lc($fm{"tracking_tag"}) ne lc($thiscam{"tracking_tag"}))) {
            $ok = 0;
        } # if
        if ($reset_tt) {$fm{"tracking_tag"} = "none"}
        if (($fm{"status"} ne "all") and ($fm{"status"} ne $thiscam{"status"})) {
            $ok = 0;
        } # if

        if ($fm{"date_scope"} ne "all") {
            if (($fm{"date_scope"} eq "T") and (! &IsToday($thiscam{"subscribe_date"}))) {
                $ok = 0;
            } # if
            elsif (($fm{"date_scope"} eq "W") and (! &IsThisWeek($thiscam{"subscribe_date"}))) {
                $ok = 0;
            } # if
            elsif (($fm{"date_scope"} eq "M") and (! &IsThisMonth($thiscam{"subscribe_date"}))) {
                $ok = 0;
            } # if
            elsif (($fm{"date_scope"} eq "Y") and (! &IsThisYear($thiscam{"subscribe_date"}))) {
                $ok = 0;
            } # if
        } # if

        if ($fm{"omit_duplicates"}) {
            if ($emaillist{$thiscam{"email"}}) {
                $ok = 0;
            } # if
        } # if

        if ($fm{"omit_unsubscribers"}) {
            if ($thiscam{"status"} eq "U") {
                $ok = 0;
            } # if
        } # if

        if ($ok) {
            $emaillist{$thiscam{"email"}} = 1;
            $numsent ++;
            print FILE "$thiscam{'id'}\t$fm{'from_name'}\t$fm{'from_email'}\t$fm{'subject'}\t$file_root\t$fm{'format_preference'}\n";
        } # if
    } # foreach

    dbmclose(%db_cam);
    if ($g_settings{'file_locking'}) {flock(db_cam, 8)}

    close FILE;
    if ($g_settings{'file_locking'}) {flock(FILE, 8)}

    &Redirect ("$g_thisscript?a0=cam&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$fm{'page'}&dup=$fm{'omit_duplicates'}&m=$numsent message(s) queued");
} # sub DoBatchEmail

sub BatchStatusEdit {
    my($fm);
    $fm{"list_status"} = $INFO{"sta"};
    $fm{"list_autoresponder"} = $INFO{"aut"};
    $fm{"list_tracking_tag"} = $INFO{"tra"};
    $fm{"list_date_scope"} = $INFO{"dat"};
    $fm{"list_page"} = $INFO{"pag"};
    $fm{"list_omit_duplicates"} = $INFO{"dup"};

    &PageHeading;

    &PageHeader("h_cam_batchedit.htm");
    &PageSubHeader("Subscribers &gt; Batch Status Change", "[<a class='subheaderlink' href='$g_thisscript?a0=cam&sta=$fm{'list_status'}&aut=$fm{'list_autoresponder'}&tra=$fm{'list_tracking_tag'}&dat=$fm{'list_date_scope'}&pag=$fm{'list_page'}&dup=$fm{'list_omit_duplicates'}' onmouseover='ShowTooltip(14);' onmouseout='HideTooltip(14);'>Return to Subscriber List</a>]");

    &Spacer("1", "25");

    &ListTableHeading("Change the status of all subscribers matching these criteria?");

    my($disp_ar);
    if ($fm{"list_autoresponder"} eq "all") {
        $disp_ar = "All";
    } # if
    else {
        my(%ar) = &data_Load($fm{"list_autoresponder"});
        $disp_ar = "$ar{'listens_on'}\@$g_settings{'your_domain'}";
    } # else

    my($disp_tt);
    if ($fm{"list_tracking_tag"} eq "all") {
        $disp_tt = "All";
    } # if
    elsif ($fm{"list_tracking_tag"} eq "none") {
        $disp_tt = "None";
    } # elsif
    else {
        $disp_tt = $fm{"list_tracking_tag"};
    } # else

    my($disp_st);
    if ($fm{"list_status"} eq "all") {
        $disp_st = "All";
    } # if
    elsif ($fm{"list_status"} eq "A") {
        $disp_st = "Active";
    } # elsif
    elsif ($fm{"list_status"} eq "S") {
        $disp_st = "Suspended";
    } # elsif
    elsif ($fm{"list_status"} eq "U") {
        $disp_st = "User cancelled";
    } # elsif
    elsif ($fm{"list_status"} eq "F") {
        $disp_st = "Finished";
    } # elsif
    elsif ($fm{"list_status"} eq "X") {
        $disp_st = "Failed";
    } # elsif

    my($disp_ds);
    if ($fm{"list_date_scope"} eq "all") {
        $disp_ds = "All";
    } # if
    elsif ($fm{"list_date_scope"} eq "T") {
        $disp_ds = "Today";
    } # elsif
    elsif ($fm{"list_date_scope"} eq "W") {
        $disp_ds = "This week";
    } # elsif
    elsif ($fm{"list_date_scope"} eq "M") {
        $disp_ds = "This month";
    } # elsif
    elsif ($fm{"list_date_scope"} eq "Y") {
        $disp_ds = "This year";
    } # elsif

    if ($fm{"list_omit_duplicates"}) {
        $disp_omit = "Yes"
    } # if
    else {
        $disp_omit = "No"
    } # else

    &FilterListTableSubHeading("<b>Filter: </b>Autoresponder = $disp_ar | Tracking tag = $disp_tt | Status = $disp_st | Date scope = $disp_ds | Omit duplicate subscribers = $disp_omit");

    &OpenForm("form", "$g_thisscript?a0=cam&a1=bax&sta=$fm{'list_status'}&aut=$fm{'list_autoresponder'}&tra=$fm{'list_tracking_tag'}&dat=$fm{'list_date_scope'}&pag=$fm{'list_page'}&dup=$fm{'list_omit_duplicates'}");

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>New status</b></td>\n";
    print "<td class='formcell' width='50%' valign='middle'><select name='newstatus' size='1'><option value='A' selected>Active</option><option value='S'>Suspended</option><option value='U'>User cancelled</option><option value='F'>Finished</option><option value='X'>Failed</option></select></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='wrapcell' colspan='2' valign='middle'><p>When you click <b>Confirm Status Change</b>, The status of all subscribers matching the criteria shown above will be changed.</p><p>Please wait for confirmation that the process is complete before taking any further action. This may take some time for long lists.</p></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Confirm Status Change  '></td>\n";
    print "</tr>\n";

    &CloseForm;

    &Spacer("1", "5");

    &PageCloser('');
} # sub BatchStatusEdit

sub DoBatchStatusEdit {
    my($fm);
    $newstatus = $FORM{"newstatus"};

    $fm{"status"} = $INFO{"sta"};
    $fm{"autoresponder"} = $INFO{"aut"};
    $fm{"tracking_tag"} = $INFO{"tra"};
    $fm{"date_scope"} = $INFO{"dat"};
    $fm{"page"} = $INFO{"pag"};
    $fm{"omit_duplicates"} = $INFO{"dup"};

    dbmopen(%db_cam, "$_data_path/CAM", 0666);
    if ($g_settings{'file_locking'}) {flock(db_cam, 2)}
    my(@keys) = keys(%db_cam);

    my($key, $fileline, %thiscam);
    $numupdated = 0;
    my(%emaillist);
    foreach $key (@keys) {
        $fileline = $db_cam{$key};
        %thiscam = &data_GetRecord($fileline);
        my($ok) = 1;

        if (($fm{"autoresponder"} ne "all") and ($fm{"autoresponder"} ne $thiscam{"autoresponder_id"})) {
            $ok = 0;
        } # if
        if ($fm{"tracking_tag"} eq "none") {
            $fm{"tracking_tag"} = "";
            $reset_tt = 1;
        } # if
        if (($fm{"tracking_tag"} ne "all") and (lc($fm{"tracking_tag"}) ne lc($thiscam{"tracking_tag"}))) {
            $ok = 0;
        } # if
        if ($reset_tt) {$fm{"tracking_tag"} = "none"}
        if (($fm{"status"} ne "all") and ($fm{"status"} ne $thiscam{"status"})) {
            $ok = 0;
        } # if
        if ($fm{"date_scope"} ne "all") {
            if (($fm{"date_scope"} eq "T") and (! &IsToday($thiscam{"subscribe_date"}))) {
                $ok = 0;
            } # if
            elsif (($fm{"date_scope"} eq "W") and (! &IsThisWeek($thiscam{"subscribe_date"}))) {
                $ok = 0;
            } # if
            elsif (($fm{"date_scope"} eq "M") and (! &IsThisMonth($thiscam{"subscribe_date"}))) {
                $ok = 0;
            } # if
            elsif (($fm{"date_scope"} eq "Y") and (! &IsThisYear($thiscam{"subscribe_date"}))) {
                $ok = 0;
            } # if
        } # if

        if ($fm{"omit_duplicates"}) {
            if ($emaillist{$thiscam{"email"}}) {
                $ok = 0;
            } # if
        } # if

        if ($ok) {
            $emaillist{$thiscam{"email"}} = 1;
            $numupdated ++;
            $thiscam{'status'} = $newstatus;
            $filelineout = &data_GetFileLine(%thiscam);
            $db_cam{$key} = $filelineout;
        } # if
    } # foreach

    dbmclose(%db_cam);
    if ($g_settings{'file_locking'}) {flock(db_cam, 8)}

    &Redirect ("$g_thisscript?a0=cam&sta=$fm{'status'}&aut=$fm{'autoresponder'}&tra=$fm{'tracking_tag'}&dat=$fm{'date_scope'}&pag=$fm{'page'}&dup=$fm{'omit_duplicates'}&m=$numupdated subscribers updated");
} # sub DoBatchStatusEdit

return 1;
