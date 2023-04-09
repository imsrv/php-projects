#!/usr/bin/perl

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



  require("./common.pm"); 

  require $GPath{'adm_admindbm.pm'};

  &parse_FORM;

  #### Buttons and HTML file locations
  $manual = $CONFIG{'html_dir'}."/bm_manual.htm";

  $groupsdb = "$GPath{'admaster_data'}/groups.db";
  $accountsdb = "$GPath{'admaster_data'}/accounts.db";
  $creditsdb = "$GPath{'admaster_data'}/excredits.db";

  #### What are we doing ???
  $action = $FORM{'action'};

   %passcookie= &split_cookie( $ENV{'HTTP_COOKIE'}, 'admin' );
   $password = $passcookie{'password'};
   if ($password ne $CONFIG{'admin_pw'}) { 
       &ERROR("Access Denied");
       exit 0;
   }


  ### If not readonly, or password is ok, do the right thing...
  if ($action eq "admin") { &bm_admin; }
  if ($action eq "menu")   {&nav_bar;}

  ## Group Management Stuff
    if ($action eq "Define Groups") {
		&Define_Groups;
	}
    if ($action eq "Save Groups") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&Save_Groups;}
    if ($action eq "Update Group Record") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&Update_Group_Record;}
    if ($action eq "Group Manager") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
&Group_Manager;}

  ## Account Management Stuff
    if ($action eq "Review") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&Review_Pending;}
    if ($action eq "Delete Account") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}&Delete_Pending;}
    if ($action eq "Add Account") {&Edit_Account;}
    if ($action eq "Save New Account") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&Save_Account_Modification;}

    if ($action eq "List Accounts" || $action eq "Link Exchange") {&List_Accounts;}
    if ($action eq "Edit") {&Edit_Account;}
    if ($action eq "Save Account Modification") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&Save_Account_Modification;}
    if ($action eq "Stats") {&Account_Stats;}
    if ($action eq "Delete") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&Delete_Account;}
    if ($action eq "Disable") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&Disable_This_Account;}
    if ($action eq "Re-Enable") {&Enable_Account;}
    if ($action eq "Re-Initialize") {&Init_Account;}

    if ($action eq "Edit Acceptance Email") { &Edit_Email; }
    if ($action eq "Save Email") {
	if ($demo_site eq "T") {
		&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
		exit 0; 
	}
	&Save_Email; }
    else { &bm_admin; }

exit 0;

###########################################################################
###########################################################################
sub bm_admin {

        open ("ACT", "$GPath{'admaster_data'}/pending/accounts.temp");
           @accounts = <ACT>;
        close(ACT);

        for $p (0 .. $#accounts) {
           $accounts[$p] =~ s/\n//g;
           $acct_list .= "<OPTION VALUE=\"$accounts[$p]\">$accounts[$p]\n";
        }

        $num_pending = $#accounts + 1;

        ## Groups

		tie %groups, "DB_File", $groupsdb;
		foreach $key(sort keys %groups) {
			if($key ne "default" && $key ne "exchange") {
				$group_list .= "<OPTION VALUE=\"$key\">$key\n";
			}
		}
		$EXC_SELECT = "<SELECT NAME=\"action\">\n";
		$EXC_SELECT .= "    <OPTION VALUE=\"List Accounts\">Normal Accounts\n";
		$EXC_SELECT .= "    <OPTION VALUE=\"Link Exchange\">Link Exchange Accounts\n";
		$EXC_SELECT .= "</SELECT><BR>";


	print "Content-type: text/html\n\n";
        print <<DONE;

	<HTML>

	<BODY BGCOLOR="#cccc99">
	<CENTER>
	<P><FONT COLOR="$CONFIG{'text_color'}"><H1>AdMaster Admin</H1></FONT><P>
<TABLE WIDTH=500><TR><TD>
<P><B>Warning:</B> We recommend using a recent version of Netscape while editing, as certain browsers may overwrite important changes that you make to your files.
</TD></TR></TABLE><BR><BR>
        <TABLE BGCOLOR="#ffffcc" BORDER=1 CELLSPACING=15 WIDTH=620>
         <TR>
          <TD WIDTH=50%><CENTER>
            <A HREF="$GUrl{'adm_admin.cgi'}?action=Define+Groups"><IMG SRC="$CONFIG{'button_dir'}/icon-cat-detail.gif" BORDER=0></A><BR>[Edit Groups]
          </TD>
          <TD WIDTH=50%><CENTER>
	     <form ENCTYPE=\"application/x-www-form-urlencoded\"  ACTION="$GUrl{'adm_admin.cgi'}" METHOD="POST">
               <SELECT NAME="group">
               <OPTION VALUE="default">Default Group
               <OPTION VALUE="exchange">Link Exchange Group
               $group_list
               </SELECT><BR>
 	       <INPUT TYPE="hidden" NAME="action" VALUE="Group Manager">
	       <INPUT TYPE="image" SRC="$CONFIG{'button_dir'}/icon-build.gif" BORDER=0><BR>[Assign Banners to Groups]
             </FORM>
          </TD>
         </TR>

         <TR>
      <TD><CENTER>
             <A HREF="$GUrl{'adm_admin.cgi'}?action=Add+Account"><IMG SRC="$CONFIG{'button_dir'}/icon-validate.gif" BORDER=0></A>
             <BR>[Create New Accounts]
          </TD>    
	<TD><CENTER>
	     <form ENCTYPE=\"application/x-www-form-urlencoded\"  ACTION="$GUrl{'adm_admin.cgi'}" METHOD="GET">
               $EXC_SELECT
	       <INPUT TYPE="image" SRC="$CONFIG{'button_dir'}/icon-cat-mgr.gif" BORDER=0><BR>
               [Edit Accounts]
             </FORM>
          </TD>
         </TR>

	</TABLE>
	</CENTER>
	</BODY>
	</HTML>
DONE

	exit 0;
}


##############################################################################
#                    ______               __    _
#                   / ____/____   ____   / /__ (_)___   _____
#                  / /    / __ \ / __ \ / //_// // _ \ / ___/
#                 / /___ / /_/ // /_/ // ,<  / //  __/(__  )
#                 \____/ \____/ \____//_/|_|/_/ \___//____/
#
##############################################################################

sub split_cookie {
	# put cookie into array
	my ( $incookie, $tag )= @_;
	my ( %cookie );
	$tester= $incookie;
	my ( @temp )= split( /; /, $incookie );
	foreach ( @temp ) {
		($temp, $temp2)= split(/=/);
		$cookie{$temp}= $temp2;
	}
	return &split_sub_cookie($cookie{$tag});
}

sub split_sub_cookie {
	my ( $cookie )= @_;
	my ( %newcookie );
	my ( @temp )= split( /\|/, $cookie );
	foreach ( @temp ) {
		($temp, $temp2)= split( /~/ );
		$newcookie{$temp}= $temp2;
	}
	return %newcookie;
}

sub join_cookie {
	my ( %set )= @_;
	my ( $newcookie );
	foreach my $key( keys %set ) {
		$newcookie.= "$key\~$set{ $key }:";
	}
	return $newcookie;
}

sub Cookie_Date {
	my ($time, $format)= @_;

	my ($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst)= localtime($time);

	$sec = "0$sec" if ($sec < 10);
	$min = "0$min" if ($min < 10);
	$hour = "0$hour" if ($hour < 10);

	$mday = "0$mday" if ($mday < 10);

	my ( $month )= ($mon + 1);
	$month = "0$month" if ($month < 10);

	#$year = $year + 1900;

	my (@months)= ("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

	my (@weekday)=("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");

	return "$weekday[$wday], $month-$mday-$year $hour\:$min\:$sec GMT";
}



