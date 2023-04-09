###################################################################################
#                                                                                 #
#                   PerlDesk - Customer Help Desk Software                        #
#                                                                                 #
###################################################################################
#                                                                                 #
#     Author: John Bennett                                                          #
#      Email: j.bennett@perldesk.com                                              #
#        Web: http://www.perldesk.com                                             #
#   Filename: conf.cgi                                                            #
#    Details: The main config file                                                #
#    Release: 1.8                                                                 #
#   Revision: 0                                                                   #
#                                                                                 #
###################################################################################
# Please direct bug reports,suggestions or feedback to the perldesk forums.       #
# www.perldesk.com/board                                                          #
#                                                                                 #
# (c) PerlDesk (JBSERVE LTD) 2002/2003                                            #
# PerlDesk is protected under copyright laws and cannot be resold, redistributed  #
# in any form without prior written permission from JBServe LTD.                  #
#                                                                                 #
# This program is commercial and only licensed customers may have an installation #
###################################################################################

#~~
# DATABASE SETTINGS
#~~

  $dbhost   = "localhost";
  $dbname   = "perldesk";
  $dbuser   = 'perldesk';
  $dbpass   = 'pass';

#~~
# Cookie Settings
#~~

  $cdomain      = '';

# This can be left blank, but if you experience difficulties logging in to the
# help desk please try putting your domain name in.


  $IP_IN_COOKIE = 1;            # 1 = Yes
                                # 0 = No

# If you are behind a proxy you may disable the use of IP addresses in the ADMIN
# AND STAFF cookies issued by PerlDesk. (You may disable/enable this for the users
# in the admin: settings.


#~~
# Main Ticket (From) Address
#~~

  $ticketad = 'ticket@your-domain.ext';

# This address will act as the center point for email
# control on perldesk. You can still setup multiple email
# addresses, but this will be the address which handles
# reply emails and email notifications.


#~~
# Permitted File Attachment Extensions
#~~

            %file_types = (
                             txt   => "1",
                             gif   => "1",
                             html  => "1",
                             htm   => "1",
                             jpg   => "1",
                             jpeg  => "1",
                             png   => "1",
                             bmp   => "1"
                        );

###################  YOU MUST NOW RUN INSTALL.CGI / UGRADE.CGI ######################
#
#
#


  $enablemail  = 1;
  $PD_VER      = '1.8';


 sub get_setting_2
  {
        my $sql = "@_";
        my $value;

     my $statement = 'SELECT * FROM perlDesk_settings_extra WHERE setting = ?';
     my $sth       = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
        $sth->execute( $sql ) or die print "Couldn't execute statement: $DBI::errstr; stopped";
          while(my $ref = $sth->fetchrow_hashref())
            {
                 $value = $ref->{'value'};
            }
         $sth->finish;

    return $value;
  }


 sub execute_sql
  {
        my $sql = "@_";
         my $tatement = qq|$sql|;

        my $sth = $dbh->prepare($tatement) or die "Couldn't prepare statement: $DBI::errstr; stopped";

           $sth->execute() or die "Couldn't execute statement: $DBI::errstr; stopped";

           $sth->finish;
  }


sub die_nice
  {
      my $error = "@_";
        print "Content-type: text/html\n\n";
        print qq|
                   <html><head><title>$global{'title'}: Error</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
                   </head><body bgcolor="#FFFFFF"><p>&nbsp;</p><table width="496" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td colspan="3"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>$global{'title'}:
                   <font color="#990000"> Error</font></b></font></td></tr><tr><td colspan="3" height="11">&nbsp;</td></tr><tr><td colspan="3" height="6"><font face="Courier New, Courier, mono" size="2">$error</font></td></tr><tr> <td colspan="3" height="2">&nbsp;</td></tr><tr> <td colspan="3" height="40"> <table width="60%" border="0" cellspacing="0" cellpadding="0" align="center"> <tr> <td width="50%"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="javascript:history.back(1)">BACK</a></font></b></td><td width="50%"><div align="right"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="$template{'mainfile'}?do=login">LOGIN</a></font></b></div></td></tr></table></td></tr></table><p align="center">&nbsp;</p></body></html>
                |;
        exit;
  }



sub script_fatal
  {
      my $error = "@_";
        print "Content-type: text/html\n\n";
        print qq|
                   <html><head><title>perlDesk Installation Error</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
                   </head><body bgcolor="#FFFFFF"><p>&nbsp;</p><table width="496" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td colspan="3"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Fatal Installation Error</b></font></td></tr><tr><td colspan="3" height="11">&nbsp;</td></tr><tr><td colspan="3" height="6"><font face="Courier New, Courier, mono" size="2">$error</font></td></tr><tr> <td colspan="3" height="2">&nbsp;</td></tr><tr> <td colspan="3" height="40"> <table width="60%" border="0" cellspacing="0" cellpadding="0" align="center"> <tr> <td width="50%"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="javascript:history.back(1)">BACK</a></font></b></td><td width="50%"><div align="right"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></b></div></td></tr></table></td></tr></table><p align="center">&nbsp;</p></body></html>
                |;
        exit;
  }




 sub email
  {
     my %contact = @_;

          chomp($contact{'To'});

     if ($enablemail == "1")
       {
         my $em_header = get_setting_2("em_header");
         my $em_footer = get_setting_2("em_footer");

            $contact{'Body'} = qq|$em_header $contact{'Body'} \n\n $em_footer|;

                $statement = 'SELECT * FROM perlDesk_em_forwarders WHERE address = ?';
                $sth = $dbh->prepare($statement) or die "Couldnt prepare statement: $DBI::errstr; stopped";
                 $sth->execute( $contact{'To'} ) or die "Couldn't execute statement: $DBI::errstr; stopped";
                my $skip_send = 1 if $sth->rows > 0;

    if (!$skip_send)
     {
         if (get_setting_2("use_smtp"))
          {
                               use Mail::Sender;

                               my $smtp_address  = get_setting_2("smtp_address");
                                my $smtp_port     = get_setting_2("smtp_port");

                                  $sender = new Mail::Sender
                                      {
                                             smtp => $smtp_address,
                                           from => $contact{'From'}
                                         };

                                      $sender->MailMsg(
                                      {
                                         to      => $contact{'To'},
                                          subject => $contact{'Subject'},
                                          msg     => $contact{'Body'}
                                        });
                                   $sender->Close;
          }
            else {
                    open(MAIL, "|$global{'sendmail'} -t") || die "Unable to send mail: $!";
                         print MAIL "To: $contact{'To'}\n";
                         print MAIL "Cc: $contact{'Cc'}\n" if $contact{'Cc'};
                         print MAIL "From: $contact{'From'}\n";
                         print MAIL "Subject: $contact{'Subject'}\n\n";
                         print MAIL "$contact{'Body'}\n";
                    close(MAIL);
                  }
     }


       }
 }

 sub get_data
   {
        my $sql = "@_";
        my $sth = $dbh->prepare($sql);

           $sth->execute();

        while(my $ref = $sth->fetchrow_hashref())

          {
               for (keys %$ref) {
                                  $template{$_} = $ref->{$_};
                                }
            }

   }


sub pdcode
 {
      # Format the code used in the desk

      my $text = "@_";

         $text =~ s/\[b\]/<b>/gi;
         $text =~ s/\[\/b\]/<\/b>/gi;
         $text =~ s/\[i\]/<i>/gi;
         $text =~ s/\[\/i\]/<\/i>/gi;

  return $text;

}



 sub script_error
  {

      my $error = "@_";

      print "Content-type: text/html\n\n";
      print qq~<html><head><title>perlDesk Error</title>
               <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
               </head><body bgcolor="#FFFFFF"><p>&nbsp;</p><table width="600" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td colspan="3"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>PerlDesk: <font color="#990000">Script Error</font></b></font></td>
               </tr><tr> <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr> <td colspan="3"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Perldesk was unable to launch due to the following errors:</font></td>
               </tr><tr><td colspan="3" height="40"><font face="Courier New, Courier, mono" size="2"><br>$error<br><br><br><Br><div align=center>[ <a href="">Support Board</a> | <a href="">PerlDesk Site</a> ]</font></td></tr></table><p align="center">&nbsp;</p></body></html>
              ~;

      exit;
 }


 sub redirect
  {
      my $url = "@_";

             print qq|

                                        <html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=$url"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank You</b>, you are now being re-directed.</font><br><br>

                                        <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="$url">click

                                        here</a> if you are not automatically forwarded</font></p></html>

                |;

  }


sub notify_techs
 {

    my %details = @_;

   $statement = 'SELECT * FROM perlDesk_calls WHERE id = ?';
   $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
   $sth->execute( $details{'tid'} ) or die print "Couldn't execute statement: $DBI::errstr; stopped";
      $number=0;
          while(my $ref = $sth->fetchrow_hashref())
            {
                               $category    =  $ref->{'category'};
            }

   $statement = qq|SELECT * FROM perlDesk_staff WHERE access LIKE "%$category::%" OR access LIKE "%GLOB::%" OR access="admin"|;
        $sth = $dbh->prepare($statement)or die print "Couldn't prepare statement: $DBI::errstr; stopped";
        $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
     while(my $ref = $sth->fetchrow_hashref()) {
                if ($ref->{'notify'}) {
           if ($enablemail) {
                                 $body  = "There is a new help desk response made by '$details{'name'}' in request $details{'tid'}\n";
                                $body .= "\nCall Details\n";
                                $body .= "---------------------------------------\n";
                                $body .= "\tResponse by......: $details{'name'}  \n";
                                $body .= "\tTime.............: $details{'time'}  \n";
                                $body .= "\t$details{'note'}                     \n";
                                $body .= "---------------------------------------\n";
                                $body .= "\n\nThank You.";

                                email( To => "$ref->{'email'}", From => "$global{'adminemail'}", Subject => "Help Desk User Response", Body => "$body");

                              }
                 }
        }
            $sth->finish;
}







@languages = ("en", "sw", "no", "es", "fr", "gm");

# en -> English
# sw -> Swedish
# es -> Spanish
# no -> Norweigan


%langdetails =
  (
       en     =>   "English",
       sw     =>   "Swedish",
       no     =>   "Norwegian",
       es     =>   "Spanish",
       fr     =>   "French",
       gm     =>   "German"
  );

# You can leave the above as it is, unless you need to
# remove or add any languages - in which case you must
# edit both @languages and %langdetails

$enablelang = 1;

# Enable multi-languages/translation,



###############################################################
# GLOBAL DATE AND TIME


sub get_time {

   $global{'timeoffset'} = "0" if !$global{'timeoffset'};

 my $timeoffset = $global{'timeoffset'};
 my @days   = ('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
 my @months = ('January','February','March','April','May','June','July','August','September','October','November','December');
        ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time + (3600*$timeoffset));
                   $hour = "0$hour" if ($hour < 10);
                $min  = "0$min" if ($min < 10);
                $sec  = "0$sec" if ($sec < 10);
      if ($hour >= 12) { $variable = "P.M."; }
            else { $variable  = "A.M."; }
      if ($hour == 0) { $hour = 12; }
      if ($hour > 12) { $hour -= 12; }
          $year = 1900 + $year;
        if ($mday eq "1") {       $hy = "st";
        } elsif ($mday eq "21") { $hy = "st";
        } elsif ($mday eq "31") { $hy = "st";
        } elsif ($mday eq "2")  { $hy = "nd";
        } elsif ($mday eq "22") { $hy = "nd";
        } elsif ($mday eq "3")  { $hy = "rd";
        } elsif ($mday eq "23") { $hy = "rd";
        } else { $hy = "th"; }
                     $day = $days[$wday];
                $month    = $months[$mon];
                $month_no = ++$mon;
                $date     = "$mday$hy";
                $date_no  = $mday;
                $time     = "$hour:$min:$sec $variable";
                $time_sv  = "$hour:$min $variable";
                $time_var = "$hour:$min:$sec";
                $time_sec = "$hour:$min";

      # TIME FORMAT IN PERLDESK

       $hdtime  = "$date_no-$month_no-$year-$time_sec";
       $timenow = "$time ($date_no/$month_no/$year)";

}






1;