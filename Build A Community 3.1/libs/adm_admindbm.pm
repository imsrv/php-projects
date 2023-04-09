##############################################################################
# PROGRAM : BuildACommunity.com Perl Module                                  #
# VERSION : 3.1                                                              #
#                                                                            #
# NOTES   :                                                                  #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 1999 -> 2017                                                 #
#           Eric L. Pickup, Ecreations, BuildACommunity                      #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    ------ DO NOT MODIFY ANYTHING BELOW THIS POINT !!! -------              #
#                                                                            #
##############################################################################

require("$GPath{'adm_dbm.pm'}");

sub Define_Groups {
	tie my %groups, "DB_File", $groupsdb;

	my $group_rows = undef;

	foreach my $key (sort keys %groups) { 
		if ($key ne "default" && $key ne "exchange") {
			my $tk = &urlencode($key);
			$group_rows .= "<TR><TD><INPUT NAME=\"delete\" VALUE=\"$tk\" TYPE=\"checkbox\"></TD><TD><B>$key</B></TD></TR>\n";
		}
	}
  
	chomp($group_list);

	print "Content-Type: text/html\n\n";
	print <<DONE;

	<BODY BGCOLOR=\"#cccc99\">
	<BR>$message<BR><CENTER>
	<H3><CENTER>Edit Groups</CENTER></H3>
	<form ENCTYPE=\"application/x-www-form-urlencoded\"  ACTION="$GUrl{'adm_admin.cgi'}" METHOD="post">
	<TABLE BGCOLOR=\"#ffffcc\" BORDER=1><TR><TD>
	<TABLE BORDER=0 WIDTH=100%><TR BGCOLOR="$CONFIG{'title_color'}"><TD colspan=2>
	<TR><TD COLSPAN=2>Check the box to delete a group:</TD></TR>
	$group_rows
	<TR><TD COLSPAN=2>
	<CENTER>Add a new group (no spaces or punctutation): <INPUT NAME="add" NAME="group"><BR><BR>
	<INPUT NAME="action" TYPE="hidden" VALUE="Save Groups">
	<INPUT TYPE="submit" VALUE="Save Changes!">
	</TD></TR></TABLE>
	</TD></TR></TABLE>
	</FORM>
	</BODY>

	
DONE
   
    exit 0;     

}



sub Save_Groups {
	my @delete_us = split(/ /,$FORM2{'delete'});

	tie my %groups, "DB_File", $groupsdb;
	foreach my $group(@delete_us) {
		$group = &unencode($group); 
		delete $groups{$group};
		$message .= "Deleted $group<BR>\n";
	}

	if($FORM{'add'}) {
		$FORM{'add'} =~ s/\W//g;
		if (! $groups{$FORM{'add'}}) { 
			$groups{$FORM{'add'}} = "1"; 
			$message .= "Added $FORM{'add'}<BR>\n"; 
		}
		else { $message .= "$FORM{'add'} already exists<BR>\n"; }
	}
	$groups{'default'} = $groups{'default'} || $groups{'default'}++;

	untie %groups;

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=#cccc99>$message\n";
	print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'adm_admin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;

#	&Define_Groups;
}




sub Update_Group_Record {
	$FORM2{'account'} =~ s/ /\|/g;

	tie my %groups, "DB_File", $groupsdb;
	$groups{$FORM{'group'}} = $FORM2{'account'};
	untie %groups;

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=#cccc99>\n";
	print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'adm_admin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;

#	&Group_Manager;
}



sub Group_Manager {
	tie my %accounts, "DB_File", $accountsdb;
	tie my %groups, "DB_File", $groupsdb;

	print "Content-Type: text/html\n\n";
	print "<BODY BGCOLOR=\"#ffffcc\">\n";
	print "<CENTER><H3>Assign Banners to Groups</H3>\n";
       
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  ACTION=\"$GUrl{'adm_admin.cgi'}\">\n";
	print "<TABLE BORDER=2 WIDTH=75%><TR><TD>\n";
	print "<TABLE BORDER=1 WIDTH=100%CELLSPACING=0 CELLPADDING=3>\n";
	print "<TR BGCOLOR=\"$CONFIG{'title_color'}\">\n";
	print "<TD COLSPAN=3><FONT COLOR=\"$CONFIG{'ttxt_color'}\"><B>$groups[$x]</B></FONT></TD></TR>\n";
	print "<TR $WINCOLOR>\n";
       
	$Columns = 0;

	foreach my $key(keys %accounts) {
		print "<TD><FONT COLOR=\"$CONFIG{'text_color'}\">\n";
		$exists="F";
		if ($groups{$FORM{'group'}} =~ $key) { 
			print "<INPUT TYPE=\"checkbox\" NAME=\"account\" VALUE=\"$key\" CHECKED>$key\n";
		}
		else {
			print "<INPUT TYPE=\"checkbox\" NAME=\"account\" VALUE=\"$key\">$key\n";
		}

		print "</FONT></TD>\n";
		$Count++;
		if ($Count >= 2) { 
			$Count = 0;
			print "</TR><TR $WINCOLOR>\n"; 
		}
	}
	print "</TD></TR><TR $WINCOLOR><TD COLSPAN=3>\n";
	print "<INPUT NAME=\"group\" TYPE=\"hidden\" VALUE=\"$FORM{'group'}\">\n";
	print "<CENTER><INPUT NAME=\"action\" TYPE=\"hidden\" VALUE=\"Update Group Record\">\n";
	print "<CENTER><INPUT TYPE=\"submit\" VALUE=\"Save Changes!\">\n";
	print "</TD></TR></TABLE></TD></TR></TABLE><BR><BR>\n";
	print "</CENTER><BLOCKQUOTE>\n";

	exit 0;

}


sub Edit_Account {
	print "Content-Type: text/html\n\n";

	if ($FORM{'acct_name'}) {
		tie my %accounts, "DB_File", $accountsdb;
      	($acct_name,$acct_login,$acct_password,$target,$redirect_url,$alt_text,$under_text,$banner_type,$banner,$banner_width,$banner_height,$banner_text,$expiration_type,$num_clicks,$num_impressions,$start_date,$end_date) = split(/\|/,$accounts{$FORM{'acct_name'}});
		$TITLE = "Edit An Account";
	}
	else {
		$TITLE = "Create New Accounts";
	}

   	tie %groups, "DB_File", $groupsdb;

	my $count = 1;
	$GROUPS .= "<TABLE BORDER=3 WIDTH=100%>\n";
    	foreach $group(sort keys %groups) {
		if ($count == 1) {
			$bgcolor = "#ffffcc";
			$count = 2;
		}
		else {
			$bgcolor = "white";
			$count = 1;
		}
		if($groups{$group} =~ $acct_name) {
			$GROUPS .= "<TR BGCOLOR=$bgcolor><TD BGCOLOR=$bgcolor>$group</TD><TD BGCOLOR=$bgcolor><INPUT TYPE=\"checkbox\" NAME=\"group\" VALUE=\"$group\" CHECKED></TD></TR>\n";
		}
		else {
			$GROUPS .= "<TR BGCOLOR=$bgcolor><TD BGCOLOR=$bgcolor>$group</TD><TD BGCOLOR=$bgcolor><INPUT TYPE=\"checkbox\" NAME=\"group\" VALUE=\"$group\"></TD></TR>\n";
		}		
	}
	$GROUPS .= "</TABLE>\n";

	if ($banner_type eq "TEXT") {
		$type = "<TR><TD>Banner Type:</TD><TD><INPUT TYPE=\"radio\" NAME=\"banner_type\" VALUE=\"IMAGE\">Image or <INPUT TYPE=\"radio\" NAME=\"banner_type\" VALUE=\"TEXT\" CHECKED>Text</TD></TR>\n";

		$image = "<table width=$banner_width><tr><td height=$banner_height>$banner_text</td></tr></table>";
	}
	elsif ($banner_type eq "IMAGE") {
		$type = "<TR><TD>Banner Type:</TD><TD><INPUT TYPE=\"radio\" NAME=\"banner_type\" VALUE=\"IMAGE\" CHECKED>Image or <INPUT TYPE=\"radio\" NAME=\"banner_type\" VALUE=\"TEXT\">Text</TD></TR>\n";

		if ($banner =~ "http") {
			$image = "<a href=\"$redirect_url\" target=\"new\"><img src=\"$banner\" border=\"0\"></a>";
			$image =~ s/RAND/$RAND/g;
 		}
		else { 
			$image = "<a href=\"$redirect_url\" target=\"new\"><img src=\"$CONFIG{'banner_dir'}/$banner\" border=\"0\"></a>"; 
			$image =~ s/RAND/$RAND/g;
		}

	}  
	else {
		$type = "<TR><TD><B>Banner Type:</B></TD><TD><INPUT TYPE=\"radio\" NAME=\"banner_type\" VALUE=\"IMAGE\">Image <B>or</B> <INPUT TYPE=\"radio\" NAME=\"banner_type\" VALUE=\"TEXT\">Text</BR></TD></TR>\n";
	}


	print <<DONE;

<BODY BGCOLOR="\#cccc99\">
<CENTER><H3>$TITLE</H3></CENTER>
<CENTER>
<form ENCTYPE=\"application/x-www-form-urlencoded\" NAME=\"EditAd\" ACTION="$GUrl{'adm_admin.cgi'}">
<TABLE BGCOLOR=\"#ffffcc\" BORDER=1 WIDTH=600><TR><TD>
   <CENTER>$image<BR>
   <TABLE BORDER=0><TR BGCOLOR=\"#ffffcc\"><TD>
     <TR BGCOLOR=\"#ffffcc\"><TD>
        <TABLE>
        <TR><TD><B>Account Name:</B></TD><TD WIDTH=50%><INPUT NAME="acct_name" VALUE="$acct_name"></TD></TR>   
        <TR><TD><B>Login ID:</B></TD><TD><INPUT NAME="acct_login" VALUE="$acct_login"></TD></TR>
        <TR><TD><B>Login Password:</B></TD><TD><INPUT NAME="acct_password" VALUE="$acct_password"></TD></TR>

        <TR><TD><B>Target:</B></TD><TD><SELECT NAME="target">
          <OPTION VALUE="$target">$target
          <OPTION VALUE="NONE">No Target (Current Window/Frame)
          <OPTION VALUE="_top">Top of Current Window
          <OPTION VALUE="_blank">Blank Window (Always a new one)
          <OPTION VALUE="new">New Window (Re-use same)
          </SELECT>
        </TD></TR>

        <TR><TD><B>Redirect URL:</B></TD><TD><INPUT NAME="redirect_url" VALUE="$redirect_url"></TD></TR>
        <TR><TD><B>ALT Text:</B></TD><TD><INPUT NAME="alt_text" VALUE="$alt_text"></TD></TR>
        <TR><TD><B>Text Under Banner:</B></TD><TD><INPUT NAME="under_text" VALUE="$under_text"></TD></TR>

	<TR><TD COLSPAN=2><HR></TD></TR>
        <TR><TD COLSPAN=2>Please select your banner type, and then enter either the url for the banner image location, or the text/HTML for a text banner.  Enter just the filename if the banner image is in the <B>Banners</B> directory.  If the banner is being pulled from your client's site, enter the full URL here, including the <B>http://</B>
        <P>The keywords RANDNUM and GROUP, will insert a random number and the currect group name (where available) respectively.<BR><BR></TD></TR>

        $type

        <TR><TD><B>Banner URL:</B> <FONT SIZE=-1>If you selected Image</FONT></TD><TD><INPUT NAME="banner" VALUE="$banner"><BR><BR></TD></TR>

     
        <TR><TD COLSPAN=2><B>Banner Text:</B> <FONT SIZE=-1>If you selected Text</FONT>
        <BR>Use CLICK in your HREF tags.  For example, <B>&lt;A HREF="CLICK"&gt;Click Here&lt;/A&gt</B>.  Without this, we cannot track the number of click-throughs.
        <TEXTAREA NAME="banner_text" ROWS=5 COLS=50 WRAP="virtual">$banner_text</TEXTAREA>  
	</TD></TR>
 
	<TR><TD COLSPAN=2><HR></TD></TR>
	<TR><TD COLSPAN=2>Please enter the size of the banner.  This is necessary for <I>both</I> Image and Text banners.</TD></TR>
	<TR><TD><B>Size:</B></TD><TD><INPUT NAME="banner_width" SIZE=3 VALUE="$banner_width"> x <INPUT NAME="banner_height" SIZE=3 VALUE="$banner_height"></TD></TR>

	<TR><TD><B>Campaign Type:</B></TD><TD>
		<SELECT NAME="expiration_type">
		<OPTION VALUE="$expiration_type">$expiration_type
		<OPTION VALUE="clicks">Number of Clicks
		<OPTION VALUE="impressions">Number of Impressions
		<OPTION VALUE="date">Time Period
		</SELECT>
	</TD></TR>

	<TR><TD><B>Max Clicks:</B></TD>
	<TD><INPUT NAME="num_clicks" VALUE=\"$num_clicks\"></TD></TR>

	<TR><TD><B>Max Impressions:</B></TD>
	<TD><INPUT NAME="num_impressions" VALUE=\"$num_impressions\"></TD></TR>

        <TR><TD><B>Date Range:</B><BR></FONT></TD><TD><TABLE><TR><TD><INPUT NAME="start_date" SIZE=12 VALUE="$start_date"> <B>to</B> </TD><TD><INPUT NAME="end_date" SIZE=12 VALUE="$end_date"></TD></TR></TABLE></TD></TR>
           
	  <TR><TD COLSPAN=2><BR><B>This account should be included in the following groups:</B></TD></TR>
        <TR><TD><a href="javascript:SetChecked(1)">Check&nbsp;All</a></TD><TD><a href="javascript:SetChecked(0)">Clear&nbsp;All</a></TD></TR>
        <TR><TD COLSPAN=2>
		$GROUPS
        </TD></TR>
        <TR><TD COLSPAN=2><CENTER><INPUT NAME="action" TYPE="hidden" VALUE="Save New Account"></CENTER></TD></TR>
        <TR><TD COLSPAN=2><CENTER><INPUT TYPE="submit" VALUE="Save Changes!"></CENTER></TD></TR>
	  <TR><TD><IMG SRC=\"$CONFIG{'button_dir'}\" WIDTH=250 HEIGHT=1></TD><TD><BR></TD></TR>
     </TABLE>
  </TD></TR></TABLE>
  </CENTER>
</TD></TR></TABLE>
</FORM>
</BODY>
<script language="JavaScript">
<!--
function SetChecked(val) {
	dml=document.EditAd;
	len = dml.elements.length;
	var i=0;
	for( i=0 ; i<len ; i++) {
		if (dml.elements[i].name=='group') {
			dml.elements[i].checked=val;
		}
	}
}
//-->
</script>
DONE

exit 0;

}




##############################################################################
# List the categories and sub categories
##############################################################################
sub List_Accounts {
	tie %accounts,"DB_File",$accountsdb;

	print "Content-Type: text/html\n\n";

	print <<DONE;

	<BODY BGCOLOR=\"#cccc99\">
	<BR><BR><CENTER>
	<H3><CENTER>Edit Accounts</CENTER></H3>
	<TABLE BGCOLOR=\"#ffffcc\" BORDER=2 CELLPADDING=0 CELLSPACING=0><TR><TD>
	<TABLE BGCOLOR=\"#ffffcc\" BORDER=1 CELLSPACING=0 CELLPADDING=0><TR BGCOLOR=BLACK><TD COLSPAN="9">
	<TR>
	<TD><CENTER>Account</CENTER></TD>
	<TD><CENTER>Shown</CENTER></TD>
	<TD><CENTER>Clicked<CENTER></TD>
	<TD><CENTER>Ratio<CENTER></TD>
	<TD COLSPAN=4><CENTER>Admin...</CENTER></TD>
	</TR>
DONE

	foreach $key(sort keys %accounts) {
		($acct_name,$acct_login,$acct_password,$target,$redirect_url,$alt_text,$under_text,$banner_type,$banner,$banner_width,$banner_height,$banner_text,$expiration_type,$num_clicks,$num_impressions,$start_date,$end_date) = split(/\|/,$accounts{$key});

#		next if ($expiration_type eq "exchange" && $exchange ne "T");
#		next if ($expiration_type ne "exchange" && $exchange eq "T");

		($impressions, $clicks) = &Get_Account_Totals($key);

		if ($expiration_type eq "impressions") {
			$ri = ($num_impressions - $impressions);
			$info = "<TR $WINCOLOR><TD COLSPAN=8>$num_impressions Total impressions .... $ri Remaining<BR><BR></TD></TR>";
		}
		elsif ($expiration_type eq "clicks") {
			$rc = ($num_clicks - $clicks);
			$info = "<TR $WINCOLOR><TD COLSPAN=8>$num_clicks Total clicks .... $rc Remaining<BR><BR></TD></TR>";
		}
		elsif ($expiration_type eq "date") {
			$info = "<TR $WINCOLOR><TD COLSPAN=8>Account Expires on $end_date.<BR><BR></TD></TR>";
		}

		elsif ($expiration_type eq "exchange") {
			tie my %credits, "DB_File", $creditsdb;
			$m_credits = $credits{$key};
			$info = "<TR $WINCOLOR><TD COLSPAN=8>Accumulated Credits: $m_credits.<BR><BR></TD></TR>";
		}

		if ( $impressions >= 1 ) { 
			$pct = $clicks / $impressions;
			$pct = $pct*100;
		}
		else  {
			$pct = 0;
		}


		print "<TR $WINCOLOR>\n";
		print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  ACTION=\"$GUrl{'adm_admin.cgi'}\">\n";
		print "<TD ROWSPAN=2><B>$acct_name</B></TD>\n";
		print "<TD><CENTER><B>$impressions</B></CENTER></TD>\n";
		print "<TD><CENTER><B>$clicks</B></CENTER></TD>\n";
		print "<TD><CENTER><B>\n";

		printf ("( %2.2f \% )\n", $pct);
 
		print "</B></CENTER></TD>\n";
		print "<TD><CENTER><INPUT TYPE=\"SUBMIT\" NAME=\"action\" VALUE=\"Edit\"></CENTER></TD>\n";
#		print "<TD><CENTER><INPUT TYPE=\"SUBMIT\" NAME=\"action\" VALUE=\"Stats\"></CENTER></TD>\n";
		print "<TD><CENTER><INPUT TYPE=\"SUBMIT\" NAME=\"action\" VALUE=\"Delete\"></CENTER></TD>\n";

		if (-e "$GPath{'admaster_data'}/accounts/$key.DISABLED") {
			print "<TD><CENTER><INPUT TYPE=\"SUBMIT\" NAME=\"action\" VALUE=\"Re-Enable\"></TD>\n";
		}
		else {
			print "<TD><CENTER><INPUT TYPE=\"SUBMIT\" NAME=\"action\" VALUE=\"Disable\"></TD>\n";
		}
		print "<TD><CENTER><INPUT TYPE=\"SUBMIT\" NAME=\"action\" VALUE=\"Re-Initialize\"></TD>\n";
		print "<INPUT TYPE=\"HIDDEN\" NAME=\"acct_name\" VALUE=\"$key\"></TR></FORM><TR><TD>\n";
		print $info;
		print "</TD></TR>\n";
	}

	print "</TABLE>\n";
	print "</TD></TR></TABLE>\n";
	print "</BODY>\n";
	print "</HTML>\n";

	exit 0;
}





sub Account_Stats {
	$URL = "http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}";
	$URL =~ s/adm_admin/admreport/g;
	$URL .= "?account=$FORM{'acct_name'}&MODE=admin";

	print "Location: $URL\n\n";

	exit 0;
}


sub Delete_Account {
	print "Content-Type: text/html\n\n";

	### Delete the account Record
	tie %accounts, "DB_File", $accountsdb;
	delete $accounts{$FORM{'acct_name'}};
	untie %accounts;

	### Delete the log files
	opendir(FILES, "$GPath{'admaster_data'}/logs");
	@allfiles=readdir(FILES);
	closedir(FILES);   

	for $x ( 0 .. $#allfiles ) {
		if ($allfiles[$x] =~ "$FORM{'acct_name'}") {
			unlink "$GPath{'admaster_data'}/logs/$allfiles[$x]";
		}
	}

      unlink "$GPath{'admaster_data'}/accounts/$FORM{'acct_name'}.DISABLED";


	### Delete from all groups
	tie %groups, "DB_File", $groupsdb;
	foreach $key(keys %groups) {
		if($groups{$key} =~ "|$FORM{'acct_name'}") { $groups{$key} =~ s/\|$FORM{'acct_name'}//g; }
		if($groups{$key} =~ "$FORM{'acct_name'}") { $groups{$key} =~ s/$FORM{'acct_name'}//g; }
	}
	untie %groups;

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=#cccc99>\n";
	print "Account Deleted.<HR><BLOCKQUOTE>\n";
	print "All associated files are gone and the database has been updated.\n";
	print "However, we recommend that you check the directories via FTP or telnet to ensure that.\n";
	print "they were all properly removed.  If not, you will need to remove them by hand.\n";
	print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'adm_admin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;



#	&List_Accounts;
	exit 0;
}


sub Init_Account {
	$acct_name = $FORM{'acct_name'};

	print "Content-Type: text/html\n\n";

	opendir(FILES, "$GPath{'admaster_data'}/logs");
	@allfiles=readdir(FILES);
	closedir(FILES);           

	for $x ( 0 .. $#allfiles ) {
		if ($allfiles[$x] =~ "$acct_name") {
			unlink "$GPath{'admaster_data'}/logs/$allfiles[$x]";
		}
	}

	tie my %imps,"DB_File",$tot_imp;
	$imps{$acct_name} = 0;

      tie my %clks,"DB_File",$tot_clk;
	$clks{$acct_name} = 0;
  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=#cccc99>\n";
	print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'adm_admin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;
}


sub Disable_This_Account {
	$acct_name = $FORM{'acct_name'};
	open (DIS, ">$GPath{'admaster_data'}/accounts/$acct_name.DISABLED");
	close (DIS);

  	print "Content-type: text/html\n\n";
	print "$GPath{'admaster_data'}/accounts/$acct_name.DISABLED<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=#cccc99>\n";
	print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'adm_admin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;

#	&List_Accounts; 
  
	exit 0;
}

sub Enable_Account {
	$acct_name = $FORM{'acct_name'};

	unlink "$GPath{'admaster_data'}/accounts/$acct_name.DISABLED";

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=#cccc99>\n";
	print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'adm_admin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;

#	&List_Accounts; 

	exit 0;
}

sub Save_Account_Modification {
	$FORM{'acct_name'} =~ s/ /_/g;
	if (! $FORM2{'group'}) {
		@groups = split(/ /,$FORM{'group'});
	}
	else {
		@groups = split(/ /,$FORM2{'group'});
	}

	$LINE .= $FORM{'acct_name'} . "|";
	$LINE .= $FORM{'acct_login'} . "|";
	$LINE .= $FORM{'acct_password'} . "|";
	$LINE .= $FORM{'target'} . "|";
	$LINE .= $FORM{'redirect_url'} . "|";
	$LINE .= $FORM{'alt_text'} . "|";
	$LINE .= $FORM{'under_text'} . "|";
	$LINE .= $FORM{'banner_type'} . "|";
	$LINE .= $FORM{'banner'} . "|";
	$LINE .= $FORM{'banner_width'} . "|";
	$LINE .= $FORM{'banner_height'} . "|";
	$LINE .= $FORM{'banner_text'} . "|";
	$LINE .= $FORM{'expiration_type'} . "|";
	$LINE .= $FORM{'num_clicks'} . "|";
	$LINE .= $FORM{'num_impressions'} . "|";
	$LINE .= $FORM{'start_date'} . "|";
	$LINE .= $FORM{'end_date'};

	$LINE =~ s/(\n|\cM|\r)//g;

	tie my %accounts, "DB_File", $accountsdb or &diehtml("can't open $accountsdb: $!");
		$accounts{$FORM{'acct_name'}} = $LINE;
	untie %accounts;

	## Update the relevant group files
	tie my %groupsdata, "DB_File", $groupsdb;
	foreach $key(keys %groupsdata) {
		if($groupsdata{$key} =~ "|$FORM{'acct_name'}") { $groupsdata{$key} =~ s/\|$FORM{'acct_name'}//g; }
		if($groupsdata{$key} =~ "$FORM{'acct_name'}") { $groupsdata{$key} =~ s/$FORM{'acct_name'}//g; }
	}
	foreach my $group(@groups) {
		if ($groupsdata{$group} !~ $FORM{'acct_name'}) { $groupsdata{$group} .= "|$FORM{'acct_name'}"; }
	}

	if ($FORM{'expiration_type'} eq "exchange") {
		if ($groupsdata{"exchange"} !~ $FORM{'acct_name'}) { $groupsdata{"exchange"} .= "|$FORM{'acct_name'}"; }
	}
	untie %groupsdata;

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=#cccc99>\n";
	print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'adm_admin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	exit;

#	&List_Accounts;

	exit 0;
}



###########################################################################
#                 ___         __              _
#                /   |   ____/ / ____ ___    (_) ____
#               / /| |  / __  / / __ `__ \  / / / __ \
#              / ___ | / /_/ / / / / / / / / / / / / / _   _   _
#             /_/  |_| \__,_/ /_/ /_/ /_/ /_/ /_/ /_/ (_) (_) (_)
#
###########################################################################




sub Get_Account_Totals {
	my($acct) = @_;

	$impressions = 0;
	$clicks = 0;

	tie my %imps,"DB_File",$tot_imp;
	$impressions = $imps{$acct} || 0;

	tie my %clks,"DB_File",$tot_clk;
	$clicks = $clks{$acct} || 0;

	return $impressions, $clicks;
}

1;
