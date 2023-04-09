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

#use CGI::Carp qw(fatalsToBrowser); 


	require("common.pm"); 
	$ecreations = "T";
	require "$GPath{'ecreations.pm'}";

	&parse_form;


##############################################################################
#     ______                     __                 __
#    / ____/____   ____   _____ / /_ ____ _ ____   / /_ _____
#   / /    / __ \ / __ \ / ___// __// __ `// __ \ / __// ___/
#  / /___ / /_/ // / / /(__  )/ /_ / /_/ // / / // /_ (__  )
#  \____/ \____//_/ /_//____/ \__/ \__,_//_/ /_/ \__//____/
##############################################################################

	$database = $input{'db'};

	%admincookie= &split_cookie( $ENV{'HTTP_COOKIE'}, 'admin' );
	$password = $admincookie{'password'};

	if ($database ne "") { 
		$this_database = $database; 
	}
	else {
		$this_database = $admincookie{'database'};
	}

	if ($this_database ne "" && $this_database ne "MAINDB") {
		$global_cfg = "$CONFIG{'data_dir'}/$this_database/global.config";
		require ($global_cfg);
		$CONFIG{'data_dir'} .= "/$this_database";
	}
	else { $this_database = "MAINDB"; }

	$action = $input{'action'};

	$ME = "http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}";

	&Var_Setup;
	if (-e "$CONFIG{'data_dir'}/admin_ip.txt") {
		my $FLAG = undef;
		my $fn = "$CONFIG{'data_dir'}/admin_ip.txt";
		open(FILE, "$fn") || &diehtml("I can't read $fn");
 		my @IPaddress = <FILE>;
		close(FILE);
		chomp @IPaddress;
		foreach my $ip (@IPaddress) {
			if (($ENV{'REMOTE_ADDR'} =~ /$ip/) && ($ip ne "")) {
				$FLAG = "T";
				last;
			}
		}
		if ($FLAG ne "T") {
			&ERROR("Access Denied.  Your IP address is not allowed to access the Admin Scripts.  You need to set the allowed IP manually on the server.  You can find out what IP address you are currently using <A HREF=\"$GUrl{'getip.cgi'}\">here</A>.");
		}
	}
	if (! $password) {
		if ($action eq "login" || $action eq "") { &ccs_login($ENV{'SCRIPT_NAME'}); }
		else { &ERROR("Access Denied"); exit 0; }
	}
	elsif ($CONFIG{'admin_pw'} eq $password) {
		if ($action eq "admin") {&nav_bar;}
		elsif ($action eq "login" || $action eq "") { &ccs_login($ENV{'SCRIPT_NAME'}); }
		elsif ($action eq "menu") {&admin_menu;}
		elsif ($action eq "config") {&go_configure;}
		elsif ($action eq "security") {
			if ($demo_site eq "T") {
				&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
				exit 0; 
			}
			&security;
		}
		elsif ($action eq "setops") {
			if ($demo_site eq "T") {
				&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
				exit 0; 
			}
			&go_setops;
		}
		elsif ($action eq "Versions") {&Version_Info;}
		elsif ($action eq "Backup") {
			if ($demo_site eq "T") {
				&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
				exit 0; 
			}
			&Backup_Data;
		}
		elsif ($action eq "Permissions") {&Set_Permissions;}
		elsif ($action eq "edit_file") {&Edit_File;}
		elsif ($action eq "Save Security") {
			if ($demo_site eq "T") {
				&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
				exit 0; 
			}
			&save_security;
		}
		elsif ($action eq "Save File") {
			if ($demo_site eq "T") {
				&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
				exit 0; 
			}
			&Save_File;
		}
		elsif ($action eq "help") { &Admin_Help; }
		elsif ($action eq "moduletest") { &Module_Test; }
		elsif ($action eq "jump") { &Jump; }
		elsif ($action eq "Create A Backup") {
			if ($demo_site eq "T") {
				&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
				exit 0; 
			}
			&do_backup;
		}
		elsif ($action eq "download") {
			if ($demo_site eq "T") {
				&ERROR("This would have worked if it was installed on your server.  In order to prevent abuse, you cannnot change settings or send mailings in this online demonstration.");
				exit 0; 
			}
			&deliver_zip;
		}
		else { &ERROR("Access Denied"); exit 0; }
	}

	else {
		if ($action eq "help") { &Admin_Help; }
		else { &ERROR("Access Denied"); exit 0; }
	}
	exit 0;




sub Var_Setup {

   ############################################
   ## What Programs does this user have?
   ############################################

   if (-e "my_admin.cgi"          || -e "../my_admin.cgi")           {$MYHOME="T";}
   if (-e "adm_admin.cgi"          || -e "../adm_admin.cgi")           {$ADM="T";}
   if (-e "community.cgi"         || -e "../community.cgi")          {$COMMUNITY="T";}
   if (-e "postcards.cgi"         || -e "../postcards.cgi")          {$POSTCARDS="T";}
   if (-e "cforum.cgi"            || -e "../cforum.cgi")             {$CFORUMS="T";}
   if (-e "clubs.cgi"             || -e "../clubs.cgi")              {$CLUBS="T";}
   if (-e "gallery_admin.cgi"     || -e "../gallery_admin.cgi")      {$PGALLERY="T";}
   if (-e "$GPath{'user.pm'}"     || -e "../$GPath{'user.pm'}")      {$USER="T";}
   if (-e "cmail.cgi"             || -e "../cmail.cgi")              {$CMAIL="T";}
   if (-e "quiz.cgi"              || -e "../quiz.cgi")               {$QUIZ="T";}
   if (-e "autoemail.cgi"         || -e "../autoemail.cgi")          {$AUTOEMAIL="T";}


   ############################################
   ## Define some of the helper urls....
   ############################################

   $PROG_URL = $ENV{'SCRIPT_NAME'};

   $hyperseek_url = "$CONFIG{'CGI_DIR'}/$hyperseek_name";

   if ($CONFIG{'cgi_extension'} eq "PL") { $cext = "pl"; }
   elsif ($CONFIG{'cgi_extension'} eq "EXE") { $cext = "exe"; }
   else { $cext = "cgi"; }

      $admin_url = $ENV{'SCRIPT_NAME'};
      
	$community_admin_url = "$CONFIG{'CGI_DIR'}/community_admin.$cext";
	$adm_admin_url = "$CONFIG{'CGI_DIR'}/adm_admin.$cext";
	$postcards_admin_url = "$CONFIG{'CGI_DIR'}/postcards_admin.$cext";
	$cf_admin_url = "$CONFIG{'CGI_DIR'}/cf_admin.$cext";
	$pg_admin_url = "$CONFIG{'CGI_DIR'}/gallery_admin.$cext";
	$my_admin_url = "$CONFIG{'CGI_DIR'}/my_admin.$cext";
	$cmail_admin_url = "$CONFIG{'CGI_DIR'}/cmail_admin.$cext";
	$quiz_admin_url = "$CONFIG{'CGI_DIR'}/quiz_admin.$cext";
	$autoemail_admin_url = "$CONFIG{'CGI_DIR'}/autoemail_admin.$cext";

}


##############################################################################
#                          __                   _
#                         / /    ____   ____ _ (_)____
#                        / /    / __ \ / __ `// // __ \
#                       / /___ / /_/ // /_/ // // / / /
#                      /_____/ \____/ \__, //_//_/ /_/
#                                    /____/
#
##############################################################################
sub ccs_login {
	local($place_to_go) = @_;

	local $password = $input{'password'};

	if ($password eq $CONFIG{'admin_pw'}) {
		&nav_bar;
	}

	else {
		if ($password eq "") {&ccs_get_login($place_to_go);}
		else {&ccs_bad_login($place_to_go);}
	}

}


sub ccs_get_login {
	$now = time;
	$stop = $now + 86400;
	$cdate = &Cookie_Date($stop);

	local($place_to_go) = @_;
	if (-e "$CONFIG{'data_dir'}/installed.txt") {
		$place_to_go = "$GUrl{'eadmin.cgi'}";
	}
	print "Content-type: text/html\n\n";

	print <<EOLOGIN;

   <HTML>
   <HEAD><TITLE>Admin Logon</TITLE></HEAD>
   <BODY BGCOLOR="white" TEXT="#000000" LINK="#0000FF" VLINK="#0000FF">
   <form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD="post" NAME="logon" ACTION="$place_to_go" ENCTYPE="x-www-form-urlencoded" >
     <CENTER>
     <TABLE width=320 border=1 cellspacing=0 cellpadding=0 bgcolor="#C0C0C0">
       <TR>
       <TD>

         <TABLE width="100%" border=0 cellpadding=0>
         <TR>
           <TD bgcolor="#00007F" colspan=2 height=20>
             <FONT SIZE=-1 COLOR="FFFFFF" FACE="MS Sans Serif"><B>&#160;User Logon</B></FONT>
           </TD>
         </TR>
         <TR>
           <TD align="center" colspan=2><BR>
             <FONT SIZE=-1 COLOR="660000"><B>Please Logon <BR></B></FONT><P>
           </TD>
         </TR>
         <TR>
           <TD align="right">
             <FONT SIZE=-1 FACE="MS Sans Serif"><B>Password:</B></FONT><P>
           </TD>
           <TD>
             <INPUT TYPE="hidden" NAME="action" VALUE="login">
             <INPUT TYPE="hidden" NAME="db" VALUE="$database">
             <INPUT TYPE="hidden" NAME="x" VALUE="$brand">
             <INPUT type="password" name="password" maxlength=20><P>
           </TD>
   
         </TR>
       </TABLE>

     <TABLE width="100%" border=0 cellpadding=0>
       <TR>
         <TD align="right" width="50%">
           <INPUT type="submit" value="Login"></FORM></TD><TD align="left"><P>
         </TD>
       </TR>
     </TABLE>

   </TD></TR></TABLE>

   </CENTER>
   <SCRIPT>
   <!--
   document.logon.password.focus()
   // -->
   </SCRIPT>
   </BODY>
   </HTML>

EOLOGIN

exit 0;

}



sub ccs_bad_login {


        &ERROR("Access to the admin program is denied");

	exit 0;

}


sub Jump {
	$program = $input{'program'};
	$ME = $ENV{'HTTP_HOST'};
	$LOC = "http://" . $ME . $program;
	print "Location: $program\n\n";

	exit 0;
}

##############################################################################
#       ______
#      / ____/_____ ____ _ ____ ___   ___   _____
#     / /_   / ___// __ `// __ `__ \ / _ \ / ___/
#    / __/  / /   / /_/ // / / / / //  __/(__  )
#   /_/    /_/    \__,_//_/ /_/ /_/ \___//____/
##############################################################################

sub nav_bar {

        $acookie = "password\~$password|database\~$this_database";
        print "Set-Cookie:admin=$acookie;path=/\n";

	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<HEAD>\n";
  	print "<TITLE>BuildACommunity CGI Administration</TITLE>\n";
	print "</HEAD>\n";

	print "<frameset rows=\"65,*\" framespacing=0 frameborder=0 border=0>\n";
    	print "<!-- Top Frame:  Shows Welcome Message and a list of available forums -->\n";
	print "<frame name=\"top\" src=\"$PROG_URL?action=menu\" border=\"0\" scrolling=\"no\" frameborder=\"0\" noresize marginheight=0>\n";
  
    	print "<!-- Main frame, starts with home page, used for all internal links -->\n";
    	print "<frame name=\"main\" src=\"http://support.buildacommunity.com/cgi-bin/myhome.cgi\" scrolling=\"right\" border=\"0\" frameborder=\"0\" noresize marginheight=0>\n";
	print "</frameset\n";

	print "</FORM>\n";
	print "<CENTER>\n";
	print "</BODY>\n";
	print "</HTML>\n";

	exit 0;
}



##############################################################################
#       __  ___                       ____
#      /  |/  /___   ____   __  __   / __ ) ____ _ _____
#     / /|_/ // _ \ / __ \ / / / /  / __  |/ __ `// ___/
#    / /  / //  __// / / // /_/ /  / /_/ // /_/ // /
#   /_/  /_/ \___//_/ /_/ \__,_/  /_____/ \__,_//_/
##############################################################################


sub admin_menu {

         if ($ADM eq "T") {
           $admins{"AdMaster Administration"} = "$adm_admin_url?action=admin"; 
	   }
         if ($CMAIL eq "T") {
           $admins{"CommunityMail Administration"} = "$cmail_admin_url?action=admin"; 
	   }

         if ($QUIZ eq "T") {
           $admins{"Quiz Administration"} = "$quiz_admin_url?action=admin"; 
	   }

         if ($AUTOEMAIL eq "T") {
           $admins{"Auto-EmailPro Administration"} = "$autoemail_admin_url?action=admin"; 
	   }

         if ($COMMUNITY eq "T" || $USER eq "T") {
           $admins{"CommunityMembers/Weaver Administration"} = "$community_admin_url?action=admin"; 
	   }

         if ($POSTCARDS eq "T") {
           $admins{"EcardsPro Administration"} = "$postcards_admin_url?action=admin"; 
	   }

         if ($CFORUMS eq "T") {
           $admins{"CommunityForums/Clubs Administration"} = "$cf_admin_url?action=admin"; 
	   }

         if ($PGALLERY eq "T") {
           $admins{"Auto-Gallery Administration"} = "$pg_admin_url?action=admin"; 
	   }

         if ($MYHOME eq "T") {
           $admins{"Auto-HomePage Administration"} = "$my_admin_url?action=admin"; 
	   }

         if (-e "sql_admin.cgi") {
           $admins{"SQL Administration"} = "sqladmin.cgi";
         }

         if ($BBS eq "T") {
           $admins{"BBS Administration"} = "$bbs_admin_url?action=admin";
         }

         if ($HF eq "T") {
           $admins{"Hyperseek Forums Administration"} = "$hf_admin_url?action=admin";
         }
  
         if ($USERS eq "T") {
           $admins{"Users Administration"} = "$users_url?action=admin";
         }

         if ($CLASS eq "T") {
           $admins{"Classifieds Administration"} = "$class_admin_url?action=admin";
         }

         if ($GBOOK eq "T") {
           $admins{"Guestbook Administration"} = "$gb_admin_url?action=admin";
         }
   
         if ($COMMENTS eq "T") {
           $admins{"Hyperseek Comments Administration"} = "$cmt_admin_url?action=admin"; 
         }

         if ($FILES eq "T") {
           $admins{"File-Ex Administration"} = "$filex_admin_url?action=admin"; 
         }

         if ($SPLAT eq "T") {
           $admins{"Splat Administration"} = "$splat_admin_url?action=admin"; 
         }

         if ($FAQ eq "T") {
           $admins{"FAQ Administration"} = "$faq._urlaction=admin"; 
         }

         if ($MAIL eq "T") {
           $admins{"Mailman Administration"} = "$mailman_url?action=admin"; 
         }

         if ($HYPERSEEK eq "T") {
           $admins{"Hyperseek Administration"} = "$hs_admin_url?action=admin"; 
         }

         if ($WEBRING eq "T") {
           $admins{"Ringmaster Administration"} = "$ring_admin_url?action=admin"; 
         }

         if ($CLASSPRO eq "T") {
           $admins{"Classifieds Pro Administration"} = "$cp_admin_url?action=admin"; 
         }

         if ($ISHOP eq "T") {
           $admins{"iShop Administration"} = "$ishop_admin_url?action=admin"; 
         }

         if ($ISEEK eq "T") {
           $admins{"iSeek Administration"} = "$iseek_admin_url?action=admin"; 
         }

         if ($ILINK eq "T") {
           $admins{"iLink Administration"} = "$ilink_admin_url?action=admin"; 
         }

         if ($BANNERS eq "T") {
           $admins{"AdMaster Administration"} = "$CONFIG{'CGI_DIR'}/adm_admin.cgi?action=admin"; 
         }

         if ($TOP50 eq "T") {
           $admins{"Top 50 Administration"} = "$top_admin_url?action=admin"; 
         }

         if ($WHATSNEW eq "T") {
           $admins{"Whats New Administration"} = "$new_admin_url?action=admin"; 
         }

	   ### ERIC NEW



	print "Content-type: text/html\n\n";
	print "<HEAD>\n";
  	print "<TITLE>JavaScript BBS Menu Frame</TITLE>\n";
	print "</HEAD>\n";
	print "<BODY bgcolor=\"black\" link=\"gold\" vlink=\"gold\">\n";

        print "<CENTER><TABLE><TR><TD>\n";

	print "<form ENCTYPE=\"application/x-www-form-urlencoded\" ACTION=\"$GUrl{'eadmin.cgi'}\" NAME=\"admin_form\" METHOD=\"post\" TARGET=\"main\">\n";
	print "<FONT FACE=\"Arial\" COLOR=\"#ffffcc\" SIZE=2><B>Select Program: </B></FONT><BR><FONT SIZE=2>\n";   
	print "<SELECT NAME=\"program\">\n";

        print "<OPTION VALUE=\"\">Select Program to administer\n";
	foreach $key(sort keys %admins) {
		print "<OPTION VALUE=\"$admins{$key}\">$key\n";
	}

	print "</SELECT>\n";
        print "<INPUT TYPE=\"hidden\" NAME=\"action\" VALUE=\"jump\">\n";
        print "<INPUT TYPE=\"image\" SRC=\"$CONFIG{'button_dir'}/go.gif\" BORDER=0>\n";
	print "</FORM>\n";
	print "</TD>\n";


        print "<TD VALIGN=TOP>\n";
        print "<TABLE><TR><TD VALIGN=TOP>\n";
        print "<A HREF=\"$PROG_URL?action=config\" TARGET=\"main\"><FONT SIZE=2>Configuration Settings</A><BR>\n";
        print "<A HREF=\"$PROG_URL?action=security\" TARGET=\"main\"><FONT SIZE=2>Admin Security Settings</A></TD><TD VALIGN=TOP>\n";
        print "<A HREF=\"$PROG_URL?action=Backup\" TARGET=\"main\"><FONT SIZE=2>Backup Data</A><BR>\n";
        print "<A HREF=\"$PROG_URL?action=Permissions\" TARGET=\"main\"><FONT SIZE=2>Reset Permissions</A></TD><TD VALIGN=TOP>\n";
	print "<A HREF=\"$PROG_URL?action=Versions\" TARGET=\"main\"><FONT SIZE=2>Upgrade?</A><BR>\n";
	print "<A HREF=\"http://support.buildacommunity.com/cgi-bin/myhome.cgi\" TARGET=\"main\"><FONT SIZE=2>Support Area</A>\n";
        print "</TD></TR></TABLE>\n";

        print "</TD></TR></TABLE>\n";
	print "</CENTER>\n";
   
	print "</BODY>\n";
	print "</HTML>\n";

	exit 0;

}

sub security {
	$fn = "$CONFIG{'data_dir'}/admin_ip.txt";
	open(FILE, "$fn");
 		@IPs = <FILE>;
	close(FILE);

  	print "Content-type: text/html\n\n";
	print "<HTML>\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=\"#ffffcc\" BORDER=4 CELLPADDING=7 WIDTH=600>\n";
	print "<TR><TD><CENTER><H3>Admin Security</H3></TD></TR>\n";
	print "<TR><TD>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  METHOD=\"POST\" action=\"$GUrl{'eadmin.cgi'}\">\n";
	print "You can set the admin scripts to only accept logins from a list IP addresses.  This provides near-bulletproof protection against break-ins since the hacker/theif would need to have access to the computers listed <B>and</B> the password.\n";
	print "<P>You can either specify a single IP, or a range (255.255.255 would grant access to 255.255.255.0 to 255.255.255.255 (provided that they also have the password).\n";
	print "<P>This method is useless if the intruder has telnet/FTP access\n";

	print "<FONT SIZE=+1><B>IP Addresses:</B></FONT>\n";
	print "<TEXTAREA NAME=IPs COLS=60 ROWS=10>";
	foreach my $line (@IPs) {
		print "$line";
	}
	print "</TEXTAREA>\n";
	print "<P>\n";
	
	print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"Save Security\">\n";
	print "<CENTER><INPUT TYPE=SUBMIT VALUE=\"Save Changes!\"></CENTER>\n";
	print "</TD></TR></TABLE>\n";
	print "</HTML>\n";
	exit;
}

sub save_security  {
	$fn = "$CONFIG{'data_dir'}/admin_ip.txt";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	@IPs = split(/\n/, $input{'IPs'});
	foreach my $x (@IPs) {
		$x =~ s/(\n|\cM| )//g;
		$IPL .= "$x\n";
	}
	print FILE "$IPL";
	close(FILE);
	chmod 0777, "$fn";

  	print "Content-type: text/html\n\n";
	print "<body bgcolor=\"#cccc99\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=#ffffcc><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=#ffffcc>\n";
	print "<B>FILE ($fn) Saved.</B>\n";
	print "<CENTER><FORM METHOD=\"GET\" ACTION=\"$GUrl{'eadmin.cgi'}\"><INPUT TYPE=\"submit\" VALUE=\"--- OK ---\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE></CENTER>\n";
	exit;
}


##############################################################################
#    _    __              _         __     __         ______ ____
#   | |  / /____ _ _____ (_)____ _ / /_   / /___     / ____// __/____ _
#   | | / // __ `// ___// // __ `// __ \ / // _ \   / /    / /_ / __ `/
#   | |/ // /_/ // /   / // /_/ // /_/ // //  __/  / /___ / __// /_/ /
#   |___/ \__,_//_/   /_/ \__,_//_.___//_/ \___/   \____//_/   \__, /
#                                                             /____/
##############################################################################

sub go_configure {

	### ERIC NEW
	if ($ecreations eq "T") {
		&ecreations_vars;
	}

	exit 0;


}



##############################################################################
#      _____                        ______ ____
#     / ___/ ____ _ _   __ ___     / ____// __/____ _
#     \__ \ / __ `/| | / // _ \   / /    / /_ / __ `/
#    ___/ // /_/ / | |/ //  __/  / /___ / __// /_/ /
#   /____/ \__,_/  |___/ \___/   \____//_/   \__, /
#                                           /____/
##############################################################################

sub go_setops {
	&save_ecreations_vars;

	open (FILE, ">$CONFIG{'data_dir'}/installed.txt");
	print FILE time;
	close (FILE);

	### Check all permissions.
	if ($win eq "Y" || $win eq "y") {
		`chmod 666 *.cfg`;
		`chmod 777 *.cgi`;
	}
   
	$Title = "Success ($CONFIG{'data_dir'} /$database)";
	$Message = "<BR><i>If</i> you changed your <b>admin password</b> or the <b>virtual cgi directory</b>, then you'll need to reload the admin program for the new settings to take effect.";
	$click = "";
	$acookie = "password\~$input{'admin_pw'}|database\~$this_database";
	print "Content-type: text/html\n";
	print "Set-Cookie:admin=$acookie;path=/\n";
	print "\n<body bgcolor=\"#ffffcc\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE>\n";
	print "</TR>\n";
	print "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	print "<CENTER><FONT COLOR=\"#ffffcc\"><B>Changes Saved!</B></FONT></CENTER>\n";
	print "</TD></TR><TR>\n";
	print "<TD BGCOLOR=#cccc99>\n";
	print "$Message\n";
	print "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"history.go(-2);\"></FORM></CENTER>\n";
	print "</TD></TR></TABLE></CENTER>\n";
	exit 0;
}




sub Version_Info {

   if($ISP) { &ERROR("Access denied to the common CGI Directory"); exit 0; }

   if ($local_dir eq "T") {
    opendir(FILES, ".") || die ERROR("Can't open directory");
   }
   else {
    opendir(FILES, "../") || die ERROR("Can't open directory");
   }

    while($file = readdir(FILES)) {
        if($file =~ /.*\.cgi/ || $file =~ /.*\.pm/ ) {
           if ($local_dir eq "T") {
              push @files, "$file";
           }
           else {
              push @files, "../$file";
           }
        }
    }

    for $x( 1 .. $#files ) {
       $program = uc($files[$x]);
       $filename = lc("$files[$x]");

       open("F","$filename");
          while (<F>) {
            
            if ($_ =~ "PROGRAM") {
               s/\$//g;
               s/\"//g;
               s/\;//g;
               s/\=//g;
               s/\#//g;
               s/\://g;
               s/  //g;
               s/PROGRAM//g;
               $prog_name = $_; 
            }

            if ($_ =~ "VERSION") {
               s/\$//g;
               s/\"//g;
               s/\;//g;
               s/\=//g;
               s/\#//g;
               s/\://g;
               s/\ //g;
               s/VERSION//g;
               $prog_ver = $_; 
            }

            if ($prog_ver && $prog_name) { last; }

          }

          $prog_name =~ s/\n//g;
          $prog_name =~ s/\cM//g;
          $prog_ver =~ s/\n//g;
          $prog_ver =~ s/\cM//g;
          $SEND .= "$filename $prog_ver|";
          $prog_ver = "";
          $prog_name = "";

       close(F);

    }


    $j = "../";
    $SEND =~ s/$j//g;

	# print "Location: http://support.buildacommunity.com/cgi-bin/versions.cgi?files=$SEND\n\n";
	print "Content-Type: text/html\n\n";
	print "<CENTER><form ENCTYPE=\"application/x-www-form-urlencoded\"  ACTION=\"http://support.buildacommunity.com/cgi-bin/versions.cgi\" METHOD=\"post\">\n";
	print "<TABLE BORDER=1><TR><TD>\n";
	print "Please fill in your Support Area information and click the button below to check and see if there are new versions available....<BR><BR>\n";
 	print "UserName:<INPUT NAME=UserName SIZE=25><BR>\n";
	print "PassWord:<INPUT TYPE=password NAME=PassWord SIZE=25><BR>\n";
	print "<CENTER><INPUT TYPE=\"hidden\" NAME=\"files\" VALUE=\"$SEND\"><INPUT TYPE=\"submit\" VALUE=\"Check...\">\n";
	print "</TD></TR></TABLE></FORM></CENTER>\n";

	exit 0;
}



sub Set_Permissions {
	print "Content-Type: text/plain\n\n";
	print "Setting System Permissions...\n\n";

	$path = `pwd`;
	print "CHMODing $path\n";
	print "CGI and PM Files ... (755)\n";
	system("chmod 755 *.cgi *.pm");

	print "Lock Directory... (777)\n";
	system("chmod -R 777 locks");

	print "Data Directory...(777)\n";
	system("chmod -R 777 data");

	print "Build Directory...(777)\n";
	system("chmod -R 777 $DIR");

	print "\n\nDone.\n";

	exit 0;

}

sub Backup_Data {
	print "Content-Type: text/html\n\n";
	print "<body bgcolor=\"#e0e0e0\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE BGCOLOR=SILVER BORDER=5>\n";
	print "<TR><TD COLSPAN=2><CENTER><H3>Backup Your Files</H3></TD></TR>\n";
	print "<form ENCTYPE=\"application/x-www-form-urlencoded\"  ACTION=\"$GUrl{'eadmin.cgi'}\" METHOD=\"post\">\n";
	print "<TR><TD>Files to backup:</TD><TD><SELECT NAME=files>\n";
	print "<OPTION VALUE=data> Data Files </OPTION>\n";
	print "<OPTION VALUE=scripts> Scripts </OPTION>\n";
	print "</SELECT></TD></TR>\n";

	print "<TR><TD>Backup Method:</TD><TD><SELECT NAME=method>\n";
	print "<OPTION VALUE=zip> Zip </OPTION>\n";
	print "<OPTION VALUE=tar> Tar </OPTION>\n";
	print "</SELECT></TD></TR>\n";

	print "<TR><TD>Filename:</TD><TD><INPUT TYPE=TEXT NAME=filename SIZE=20></TD></TR>\n";
	print "<TR><TD COLSPAN=2><CENTER><INPUT TYPE=SUBMIT NAME=action VALUE=\"Create A Backup\"></TD></TR>\n";
	print "</FORM></TABLE>\n";
	exit;
}


sub do_backup {
	if ($input{'method'} eq "zip") {$command = "zip -9 -r";}
	else {$command = "tar cf";}

	if ($input{'filename'} ne "") {
		$filename = "$CONFIG{'data_dir'}/$input{'filename'}\.$input{'method'}";
	}
	else {
		$filename = "$CONFIG{'data_dir'}/" . time . "," . $$ . "\.$input{'method'}";
	}

	if ($input{'files'} eq "data") {
		$target = "$CONFIG{'data_dir'}";
	}
	else {
		$target = "./*";
	}

	$run = "$command $filename $target";

	$results = `$run`;
	chmod (0777, "$filename");

    	($dev,$ino,$mode,$nlink,$uid,$gid,$rdev,$size,$atime,$mtime,$ctime,$blksize,$block) = stat "$filename";

    	print "Content-Type: text/html\n\n";
#	print "<H2>$run</H2>\n";
	print "<body bgcolor=\"#e0e0e0\" link=navy vlink=navy text=black>\n";
	print "<CENTER><TABLE WIDTH=400 BGCOLOR=SILVER BORDER=5><TR><TD>\n";
    	if (-e "$filename") {
       	print "<CENTER><H3>Backup complete.</H3></CENTER>\n";
       	print "You can find the backup ($filename) in the directory where your data is stored, it is $size bytes\n";
		$fn = &urlencode($filename);
#		print "<CENTER><P><A HREF=\"$GUrl{'eadmin.cgi'}?action=download&file=$fn\">Download the file directly</A>.</CENTER>\n";
	}
    	else {
      	print "<CENTER><H1>Data could not be backed up.</H1>\n";
		print "<H4>Exited with the following message: $results</H4>\n";
	}
	print "</TD></TR></TABLE>\n";
	exit 0;
}


sub deliver_zip {
	if ($input{'file'} =~ /\.tar$/) {
		print "Content-type: application/x-tar\n\n";
	}
	elsif ($input{'file'} =~ /\.zip$/) {
		print "Content-type: application/zip\n\n";
	}
	else {
		exit;
	}
	open (ZIP, "$input{'file'}");
	print <ZIP>;
	close (ZIP);
}



sub Module_Test {
	eval {
		require DB_File;
	};
	if ($@) {
		$ERROR .= "DB_File <font color=red>not accessible</font> from this server. You must use an <b>ascii</b> database.";
	}
	else { $ERROR .= "DB_File <font color=blue>present</font>, you may use the binary database format."; }


	&ok_box("Test Results",$ERROR,"self.close();");
	exit 0;
}



sub Admin_Help {
	$Topic = $input{'topic'};
	if ($ecreations eq "T") {
		&help_lines;
	}
	print "Content-Type: text/html\n\n";
	print <<DONE;
<CENTER>
   <TABLE BORDER="1" CELLSPACING="2" CELLPADDING="10">
     <TR BGCOLOR="navy">
       <TD><FONT COLOR="ivory" FACE="Tahoma, Verdana, Arial, Helvetica"><B>Admin Settings Help</B></FONT></TD></TR>

     <TR BGCOLOR="#efefef">
       <TD><FONT COLOR="black" FACE="Tahoma,Verdana,Arial,Helvetica" SIZE=2>
           $$Topic
           <CENTER><H2><A HREF="javascript:self.close();">Close Window</A></H2></CENTER>

       </TD></TR></TABLE></CENTER>
DONE
   exit 0;
}


sub parse_form{
	read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
	if (length($buffer) < 5) {
		$buffer = $ENV{QUERY_STRING};
	}
	@pairs=split(/&/,$buffer);
	foreach $pair(@pairs) {
		($name, $value)=split(/=/,$pair);
		$encoded_value = $value;
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][A-F0-9])/pack("C",hex($1))/eg;
		if($input{$name} eq "") {
			$input{$name} = $value;
			$ENCODED{$name} = $encoded_value;
			push (@Fields,$name);
		}
		else {
			$input{$name} = $input{$name}." ".$value;
		}
	}
}

##############################################################################
#                    ______               __    _
#                   / ____/____   ____   / /__ (_)___   _____
#                  / /    / __ \ / __ \ / //_// // _ \ / ___/
#                 / /___ / /_/ // /_/ // ,<  / //  __/(__  )
#                 \____/ \____/ \____//_/|_|/_/ \___//____/
#
##############################################################################

sub split_cookie
	{
	# put cookie into array
	local( $incookie, $tag )= @_;
	local( %cookie );
	$tester= $incookie;
	local( @temp )= split( /; /, $incookie );
	foreach ( @temp )
	{
		( $temp, $temp2 )= split( /=/ );
		$cookie{ $temp }= $temp2;
	}
	return &split_sub_cookie( $cookie{ $tag } );
}

sub split_sub_cookie
{
   local( $cookie )= @_;
   local( %newcookie );
   local( @temp )= split( /\|/, $cookie );
   foreach ( @temp )
   {
      ( $temp, $temp2 )= split( /~/ );
      $newcookie{ $temp }= $temp2;
   }
   return %newcookie;
}

sub join_cookie
{
   local( %set )= @_;
   local( $newcookie );
   foreach $key( keys %set )
   {
      $newcookie.= "$key\~$set{ $key }:";
   }
   return $newcookie;
}

sub Cookie_Date
{
   local( $time, $format )= @_;

   local( $sec, $min, $hour, $mday, $mon, $year,
          $wday, $yday, $isdst )= localtime( $time );

   $sec = "0$sec" if ($sec < 10);
   $min = "0$min" if ($min < 10);
   $hour = "0$hour" if ($hour < 10);
   $mon = "0$mon" if ($mon < 10);
   $mday = "0$mday" if ($mday < 10);
   local( $month )= ($mon + 1);
   local( @months )= ( "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                       "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" );

   local( @weekday )=( "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun" );

   return "$weekday[$wday], $month-$mday-$year $hour\:$min\:$sec GMT";
}


##############################################
# SUB: Send E-mail (Using regular sendmail)
#
# Takes:
# (To, Subject, From, Mail Command, Message)

sub SendMail {
	$TO=$_[0];  @TO=split('\0',$TO);
	$SUBJECT=$_[1];
	$REPLYTO=$_[2];
	$COMMAND=$_[3];
	$THEMESSAGE = $_[4];

        open (SENDMAIL, "| $COMMAND") || die ERROR("Could not open $COMMAND");
             print SENDMAIL "To: $TO\n";
             print SENDMAIL "From: $REPLYTO\n";
             print SENDMAIL "Subject: $SUBJECT\n";
             print SENDMAIL "$THEMESSAGE\n";
          close SENDMAIL;

}


sub ERROR {


   local($ERROR_MESSAGE) = @_;

   if ( !($CONTENT) ) {
	print "Content-type: text/html\n\n";
   }

        print <<DONE;

	<HTML>
	<HEAD>
	  <TITLE>CGI Error</TITLE>
	</HEAD>
        <BODY BGCOLOR=\"white\">
        <CENTER>
        <BR><BR><BR>
        <TABLE BORDER=2 CELLSPACING=0 CELLPADDING=0 WIDTH=300>
          <TR><TD WIDTH=300> 

        <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH="100%">
          <TR><TD> 
            <TABLE BORDER=1 CELLSPACING=0 CELLPADDING=0 WIDTH="100%">
               <TR BGCOLOR="red"><TD> 
               <FONT FACE="Arial,Helvetica" COLOR="white" SIZE=+1>Unexpected Error.
            </TD><TR></TABLE>
          </TD></TR>

          <TR><TD> 
            <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH="100%"><TR BGCOLOR="silver"><TD> 
              <FONT COLOR="red">
              <BR><B>
              $ERROR_MESSAGE
              </B><BR><BR><I>
              <CENTER><A HREF="javascript:history.go(-1)">Return to Previous Screen</A></I></CENTER></FONT><BR><BR>
            </TD><TR></TABLE>

        </TD><TR></TABLE>
        </TD><TR></TABLE>
	</BODY>
	</HTML>
DONE


}
