###################################################################################
#                                                                                 #
#                   PerlDesk - Customer Help Desk Software                        #
#                                                                                 #
###################################################################################
#                                                                                 #
#     Author: John Bennett	                                                  #
#      Email: j.bennett@perldesk.com                                              #
#        Web: http://www.perldesk.com                                             #
#   Filename: admin_subs.cgi                                                      #
#    Details: The main admin file                                                 #
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

   $uname = $q->cookie('admin');
   $apass = $q->cookie('apass');

   %Cookies  = ( admin => $uname,
                 apass => $apass);


 #~~ 
 # Check Valid Session 

  sub check_user 
    {

	if ((! $Cookies{'admin'}) || ($Cookies{'admin'} eq "")) 
         {
              print "Content-type: text/html\n\n";
	      print "<font face=Verdana size=2>Please login to access your account <a href=\"$global{'baseurl'}/admin.cgi\">Login</a>";
              exit;	
	 }

	$statement = 'SELECT * FROM perlDesk_staff WHERE username = ?'; 
	$sth       = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute("$Cookies{'admin'}") or die "Couldn't execute statement: $DBI::errstr; stopped";
	   while(my $ref = $sth->fetchrow_hashref()) 
             {   
	            $username      =   $ref->{'username'};
                    $password      =   $ref->{'password'};
                    $name          =   $ref->{'name'};
                    $accesslevel   =   $ref->{'access'};
                    $email         =   $ref->{'email'};
 		    $rkey          =   $ref->{'rkey'};
		    $sig           =   $ref->{'signature'};
             }

	$md5 = Digest::MD5->new;
	$md5->reset ;

	$yday     = (localtime)[7];

	$certif   = $Cookies{'admin'} . $yday . "pd-$rkey" . $ENV{'HTTP_USER_AGENT'}  . $ENV{'REMOTE_ADDR'} if  $IP_IN_COOKIE ;
	$certif   = $Cookies{'admin'} . $yday . "pd-$rkey" . $ENV{'HTTP_USER_AGENT'} if !$IP_IN_COOKIE ;

	$md5->add($certif);
	$enc_cert = $md5->hexdigest() ;

	if($enc_cert eq $Cookies{'apass'}) 
               {
   			# we're logged in !!
               } else {
         			print "Content-type: text/html\n\n";
        			print "<font face=Verdana size=2>Please login to access your account <a href=\"$global{'baseurl'}/admin.cgi\">Login</a>";
            	                exit;
                      }
      }



sub section 
 {
    my $section = "@_";

 #~~
 # Login Screen
 #~~

  if ($section eq "login")
    {
           print "Content-type: text/html\n\n";

           print qq|<html><head><title>PerlDesk Administration Login</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><STYLE type=text/css>
                A:active  { COLOR: #006699; TEXT-DECORATION: none      }
                A:visited { COLOR: #334A9B; TEXT-DECORATION: none      }
                A:hover   { COLOR: #334A9B; TEXT-DECORATION: underline }
                A:link    { COLOR: #334A9B; TEXT-DECORATION: none      }
                .gbox         { FONT-SIZE: 11px; FONT-FAMILY: Verdana; COLOR: #000000; BACKGROUND-COLOR: #EEEEEE }
                .forminput    { font-size: 8pt; background-color: #CCCCCC; font-family: verdana, helvetica, sans-serif; vertical-align:middle } 
                .tbox         { FONT-SIZE: 11px; FONT-FAMILY: Verdana; COLOR: #000000; BACKGROUND-COLOR: #ffffff }
                </STYLE></head><body bgcolor="#FFFFFF" text="#000000"><table width="350" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td colspan="2"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><br><img src="$global{'logo_url'}"><br><br><div align=right>Remote IP: $ENV{'REMOTE_ADDR'}</div></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br><b>Welcome, Administrator.</b><br><br>Please login to the perlDesk administration area below by entering your password.</font></td></tr><tr> <td colspan="2"><form name="form1" method="post" action="admin.cgi"><table width="66%" border="0" align="center" cellpadding="0" cellspacing="1"><tr><td width="42%">&nbsp;</td><td width="58%">&nbsp;</td></tr><tr><td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></td></tr><tr><td width="42%"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Password</font></div></td><td width="58%"><input type="password" name="password" 
                class="gbox"></td></tr><tr><td colspan="2">&nbsp;</td></tr><tr> 
                <td colspan="2"><div align="center"><input type="hidden" name="do" value="plogin"><input type="hidden" name="username" value="admin">
                <div align=center><input type="submit" name="Submit" value="Submit" class="forminput"></div></div></td></tr></table></form></td></tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr></table></body></html>|;

    }

#~~
# Process Admin Login
#~~

 if ($section eq "plogin")
   {
      my $pass      = $q->param('password');
      my $user      = $q->param('username');
      my $error     = "0";
      my $statement = 'SELECT * FROM perlDesk_staff WHERE username = "admin"'; 

      my $sth = $dbh->prepare($statement);# or die print "Couldn't prepare statement: $DBI::errstr; stopped";
	 $sth->execute();# or die print "Couldn't execute statement: $DBI::errstr; stopped";

	while(my $ref = $sth->fetchrow_hashref()) 
	  {	
	      $salt = $ref->{'rkey'};
	   my $cpass = crypt($pass, $salt);

			if ($cpass ne $ref->{'password'}) 
                          {
				$errorm = "1";
			  } else {
				$username =  $ref->{'username'};
				$password =  $ref->{'password'};
				$name     =  $ref->{'name'};
				$email    =  $ref->{'email'};
			} 		
	} 
	if ($error ne "1") 
      {
	       if ((!$username) || ($user ne "admin")) {  $errorm = "1";  }
	  }
    die_nice("Invalid Login") if $errorm;

	my $md5    = Digest::MD5->new ;
	   $md5->reset ;

	my $yday   = (localtime)[7];

	my $certif = $user . $yday .  "pd-$salt" . $ENV{'HTTP_USER_AGENT'}  .  $ENV{'REMOTE_ADDR'} if  $IP_IN_COOKIE;
	   $certif = $user . $yday .  "pd-$salt" . $ENV{'HTTP_USER_AGENT'} if  !$IP_IN_COOKIE;

	   $md5->add($certif);
 	my $enc_cert = $md5->hexdigest() ;

      my $cookie1 = $q->cookie(-name=>'admin',
                               -value=>$user,
                               -path    => '/',
                               -domain  => $cdomain);

      my $cookie2 = $q->cookie(-name=>'apass',
                               -value=>$enc_cert,
                               -path    =>  '/',
                               -domain  =>  $cdomain);

      print $q->header(-cookie=>[$cookie1,$cookie2]);

		print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=admin.cgi?do=main"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thanks for logging in</b>, you are now being taken to the administration area.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=main">click 
					here</a> if you are not automatically forwarded</font></p></html>
                        |;
   }
 
 #~~
 # Main Admin Page
 #~~

 if ($section eq "main")
  {

	my ($sth);
    
    check_user();    
    print "Content-type: text/html\n\n";
   
	$sth = $dbh->prepare( "SELECT COUNT(*) FROM perlDesk_staff WHERE username != \"admin\"" ) or die DBI->errstr;
		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	( $staff ) = $sth->fetchrow_array();
	$sth->finish;
     

	$sth = $dbh->prepare( "SELECT COUNT(*) FROM perlDesk_users" ) or die DBI->errstr;
		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	( $users ) = $sth->fetchrow_array();
	$sth->finish;

	$sth = $dbh->prepare( "SELECT COUNT(*) FROM perlDesk_calls" ) or die DBI->errstr;
		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	( $calls ) = $sth->fetchrow_array();
	$sth->finish;


      foreach (OPEN,HOLD,CLOSED)
       {
   	  $sth = $dbh->prepare( qq|SELECT COUNT(*) FROM perlDesk_calls WHERE status = "$_"| ) or die DBI->errstr;
    	  $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	     my $num_calls = $sth->fetchrow_array();
       	  $sth->finish;
 
            $template{$_} = $num_calls;

       }

	 $template{'total'} = $users + $staff;

    ## Percentages
 
    if ($template{'total'})
     {

          $template{'users_perc'}  =  ($users/$template{'total'})*100;
          $template{'staff_perc'}  =  ($staff/$template{'total'})*100;
          $template{'users_perc'}  =   sprintf("%.0f", $template{'users_perc'});
          $template{'staff_perc'}  =   sprintf("%.0f", $template{'staff_perc'});

      } else {
                $template{'users_perc'}  =  "0";
                $template{'staff_perc'}  =  "0";
             }



   $template{'calls'}  = $calls;
   $template{'users'}  = $users;
   $template{'staff'}  = $staff;   
   print parse("$global{'data'}/include/tpl/admin/adminmain");
 
 }


#~~
# Installation Information
#~~


  if ($section eq "info")
   {
        check_user();
         print "Content-type: text/html\n\n";

            $template{'perl_version'}    = $];
            $template{'os'}              = $^O;

              @server_software = split(/ /, $ENV{'SERVER_SOFTWARE'});
             
             foreach $software (@server_software)
                  {
                      $template{'server_software'} .= "$software <br>";
                  }

            $template{'server_name'}     = $ENV{'SERVER_NAME'};
            $template{'license_id'}      = $global{'license_id'};
            $template{'script_filename'} = $ENV{'SCRIPT_FILENAME'};           

         print parse("$global{'data'}/include/tpl/admin/info");
   }



#~~
# Pop Server Management

 
 if ($section eq "popserver")
  {
       check_user();
       print "Content-type: text/html\n\n";

        if (defined $q->param('del')) {  my $id = $q->param('del'); execute_sql(qq|DELETE FROM perlDesk_popservers WHERE id = "$id"|);}       

	my $query = 'SELECT * FROM perlDesk_popservers'; 
           $sth = $dbh->prepare($query) or die "Couldn't prepare statement: $DBI::errstr; stopped";
 	   $sth->execute() or die "Couldn't execute statement: $DBI::errstr; stopped";
	    while(my $ref = $sth->fetchrow_hashref()) 
               {
                   $template{'servers'} .= qq#<tr><td><font face="Verdana" size="2"><b>$ref->{'pop_host'}</b></font></td><td><div align="center"><a href="admin.cgi?do=popserver&del=$ref->{'id'}"><img src="$global{'imgbase'}/admin/delete.gif" border="0" width="81" height="19"></a></div></td></tr>#;
               }
            $template{'servers'} = qq#<tr><td><font face="Verdana" size="2"><div align="center">No POP Servers Setup</div></font></td></tr># if !$sth->rows;

       print parse("$global{'data'}/include/tpl/admin/pop_email");
  }


if ($section eq "save_pop")
 {
       check_user();
       print "Content-type: text/html\n\n";

          my $host     =  $q->param('host');
          my $user     =  $q->param('user');
          my $password =  $q->param('password');
          my $port     =  $q->param('port');

          if ($host && $user && $password && $port)
           { 
             $sth = $dbh->prepare( "INSERT INTO perlDesk_popservers VALUES ( ?, ?, ?, ?, ? )" ) or die "couldnt prepare statement";
             $sth->execute( "NULL", "$host", $user, $password, $port ) or die "Couldnt execute statement: $!";
           }
		print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=admin.cgi?do=popserver"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank you - Database Updated</b></font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=popserver">click 
					here</a> if you are not automatically forwarded</font></p></html>
                        |;
 }



 if ($section eq "download_pop")
   {
       check_user();
       print "Content-type: text/html\n\n";

              print qq#<html><head><title>Mail Retrieval</title></head><body><font face="Verdana" size="2"><b>POP Mail Retrieval Utility</b><br>#;
              exec("perl", "include/pop-email.cgi");
              print qq#</font></body></html>#;  
  }


#~~
# Delete Range
#~~


 if ($section eq "del_range")
  {
      check_user();
       print "Content-type: text/html\n\n";
       print parse("$global{'data'}/include/tpl/admin/del_range");
  }



 if ($section eq "delete_now")
  {
       check_user();
       print "Content-type: text/html\n\n";

          my $from   = $q->param('from');
          my $to     = $q->param('to');
          my $filter = $q->param('filter');

        if (defined $to && defined $from)
         {
           if ($filter eq "all")
             {
                  execute_sql(qq|DELETE FROM perlDesk_calls WHERE (id >= $from AND id <= $to)|);
             }
 
           if ($filter eq "closed")
             {
                  execute_sql(qq|DELETE FROM perlDesk_calls WHERE status = "CLOSED" AND (id >= $from AND id <= $to)|);
             }
          }
		print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=admin.cgi?do=listcalls&status=open"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank you - Database Updated</b></font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=listcalls&status=open">click 
					here</a> if you are not automatically forwarded</font></p></html>
                        |;

  }


#~~
# Logout of the Admin
#~~

 if ($section eq "logout")
  {


      my $cookie1 = $q->cookie(-name=>'admin',
                               -value=>'',
                               -path    => '/',
                               -domain  => '');

      my $cookie2 = $q->cookie(-name=>'apass',
                               -value=>'',
                               -path    =>  '/',
                               -domain  =>  '');

      print $q->header(-cookie=>[$cookie1,$cookie2]);

		print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=admin.cgi"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thanks for logging out</b></font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi">click 
					here</a> if you are not automatically forwarded</font></p></html>
                        |;
  }

  
 if ($section eq "anc_save")
  {
     check_user();
     print "Content-type: text/html\n\n";

	my $instaff  =  $q->param('staff');
	my $inusers  =  $q->param('users');
	my $inemail  =  $q->param('email');

	if ($instaff eq "yes") { $staff = 1; } else { $staff = 0; }
	if ($inusers eq "yes") { $users = 1; } else { $users = 0; }
	
	my $message  = $q->param('message');
	my $subject  = $q->param('subject');

    my $emessage = $message;

       $message  =~ s/\n/<br>/g;
 

      $sth = $dbh->prepare( "INSERT INTO perlDesk_announce VALUES ( ?, ?, ?, ?, ?, ?, ? )" ) or die "couldnt prepare statement";
      $sth->execute( "NULL", "$Cookies{'admin'}", $subject, $message, $staff, $users, $hdtime ) or die "Couldnt execute statement";


	if ($instaff eq "yes" && $inemail eq "yes" && $enablemail) {
           
	$statement = 'SELECT email FROM perlDesk_staff'; 
		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	while(my $ref = $sth->fetchrow_hashref()) {
          if ($enablemail) {	
                              chomp($recipient = $ref->{'email'});                  
                              email( To => "$recipient", From => "$global{'adminemail'}", Subject => "$subject", Body => "$emessage" );                      
                           }
	} }


	if ($inemail eq "yes" && $inusers eq "yes" && $enablemail) {

		$statement = 'SELECT email FROM perlDesk_users'; 
		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) {	
                 chomp($recipient = $ref->{'email'}); 

                          email( To => "$recipient", From => "$global{'adminemail'}", Subject => "$subject", Body => "$emessage" );                      
		
	} }

	$response = 'Announcement Saved. <a href="admin.cgi?do=announcements">Back to Announcements</a>';
        $template{'response'} = $response;

   print parse("$global{'data'}/include/tpl/admin/general");
   
  }


 if ($section eq "validate")
  {

     check_user();
     print "Content-type: text/html\n\n";

		$statement = 'SELECT * FROM perlDesk_users WHERE pending = "1"'; 
		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
         {	

            $template{'users'} .= qq|<form action="admin.cgi" method="post"><table width="85%" border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="#EAEAEA" bordercolor="#F7F7F7" bordercolorlight="#CCCCCC"><tr bgcolor="#DBDBDB"> 
                <td colspan="3" height="25"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'username'}</font></td></tr><tr> 
                <td colspan="2"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Name</font></td>
                <td width="60%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'name'}</font></td>
                </tr><tr><td colspan="2" height="14"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">E-mail Address</font></td><td width="60%" height="14"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'email'}</font></td>
                </tr><tr><td colspan="2" height="14"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">URL</font></td><td width="60%" height="14"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'url'}</font></td>
                </tr><tr><td width="29%"> <font size="1" face="Verdana, Arial, Helvetica, sans-serif"> <input type="radio" name="approve" value="1" checked>Approve</font></td>
                <td colspan="2"> <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><input type="radio" name="approve" value="0">Decline Reason</font></td></tr><tr> 
                <td width="29%">&nbsp;</td><td colspan="2"> <input type="hidden" name="user" value="$ref->{'username'}"> <input type="hidden" name="email" value="$ref->{'email'}"><input type="hidden" name="do" value="approve"><textarea name="reason"  class="tbox" cols="48" rows="2"></textarea></td></tr></table><input type=Submit name=Submit value=Submit></form><br>|;

         }
 
       $template{'users'} = qq|<font size=2>You have no outstanding users awaiting validation, this may be because you have not set this option in the settings</font>| if !$template{'users'};
        print parse("$global{'data'}/include/tpl/admin/pending");
  }


 
 if ($section eq "approve") 
  {

     check_user();
     print "Content-type: text/html\n\n";
     $user  = $q->param('user');
     $email = $q->param('email');

    if ($q->param('approve') == "1")
     {
        $dbh->do(qq|UPDATE perlDesk_users SET pending = "0" WHERE username = "$user"|);

#~
# Email Message
#~

        my $msg = qq|
You account on $global{'title'} has now been approved. You may login using the username/password you selected when you created your account.

$global{'baseurl'}/pdesk.cgi

Thank You

$global{'title'}
|;

#~

        email ( To => "$email", From => "$global{'adminemail'}", Subject => "Account Approved", Body => "$msg" );
        $template{'response'} = "Thank you, $user has been approved";
    }

  elsif ($q->param('approve') == "0")
   {
        $reason = $q->param('reason');

      $dbh->do(qq|DELETE FROM perlDesk_users WHERE username = "$user"|);

#~
# Send Decline Email
#~

      my $msg = qq|
Sorry, your request for an account on $global{'title'} has been declined for the following reason(s):

$reason
|;
        email ( To => "$email", From => "$global{'adminemail'}", Subject => "Account Declined", Body => "$msg" );
        $template{'response'} = "Thank you, $user has been declined on this system";
   } 

    print parse("$global{'data'}/include/tpl/admin/general");

 
  }

#~~
# Announcement Management
#~~
  
 if ($section eq "announcements")
  {

     check_user();
     print "Content-type: text/html\n\n";

	$statement = 'SELECT * FROM perlDesk_announce'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	while(my $ref = $sth->fetchrow_hashref())  
       {	
          	$notice .= '<table width="80%" border="0" cellspacing="1" cellpadding="2" align="center"><tr><td width="5%"> <div align="center"><img src="' . "$global{'imgbase'}" . '/note.gif" width="11" height="11"></div></td><td width="42%"><a href="admin.cgi?do=anc_view&nid=' . "$ref->{'id'}\"><font size=\"1\" face=\"Verdana, Arial, Helvetica, sans-serif\">$ref->{'subject'}" . '</font></a></td>
            		    <td width="25%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">' . "$ref->{'time'}" . '</font></td><td width="28%"> <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><div align=right><a href="admin.cgi?do=anc_edit&nid=' . "$ref->{'id'}" . '">Edit</a> | <a href="admin.cgi?do=anc_del&nid=' . "$ref->{'id'}" . '">Delete</a></font></div></td></tr></table>';
       }
 
       $notice                   =  '<div align=center><font face="verdana" size="2">0 Announcements</font></div>' if !$notice;
       $template{'announcement'} =   $notice;

     print parse("$global{'data'}/include/tpl/admin/anounce");
     
  }


 if ($section eq "anc_del")
  {
     check_user();
     print "Content-type: text/html\n\n";

    $nid = $q->param('nid');

	$statement = 'DELETE FROM perlDesk_announce WHERE id = ?'; 
		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute($nid) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	$response = 'Announcement Deleted. <a href="admin.cgi?do=announcements">Back to Announcements</a>';

   $template{'response'} = $response;
   my $output = parse("$global{'data'}/include/tpl/admin/general");
   print $output;

  }
  

 if ($section eq "anc_view")
  {

     check_user();
     print "Content-type: text/html\n\n";

    $nid = $q->param('nid');

	  $statement = 'SELECT * FROM perlDesk_announce WHERE id = ?'; 
	  $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	  $sth->execute($nid) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	     while(my $ref = $sth->fetchrow_hashref()) 
           {	
            	$notice .= '<table width="100%" border="0" cellspacing="1" cellpadding="0">
                            <tr><td width="24%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Author:</font></td>
                            <td width="76%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">' . "$ref->{'author'}" . '</font></td>
                            </tr><tr><td width="24%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Published:</font></td>
                            <td width="76%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">' . "$ref->{'time'}" . '</font></td>
                            </tr><tr><td width="24%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></td>
                            <td width="76%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></td>
                            </tr><tr><td width="24%" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Subject:</font></td>
                            <td width="76%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>' . "$ref->{'subject'}" . '</b><br><br></font></td>
                            </tr><tr><td width="24%" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Announcement</font></td>
                            <td width="76%"></td></tr><tr><td width="100%" colspan=2><hr size=1 width="85%" color="cccccc" align="left"></td><tr><td width="100%" colspan=2><font size="2" face="Verdana, Arial, Helvetica, sans-serif">' . "$ref->{'message'}" . '</font></td></table>';
        	}

   $template{'announcement'} = $notice;

   my $output = parse("$global{'data'}/include/tpl/admin/viewannouncement");

   print $output;

  }




 if ($section eq "anc_edit")
  {
     check_user();
     print "Content-type: text/html\n\n";

      $nid       =  $q->param('nid');
	  $statement =  'SELECT * FROM perlDesk_announce WHERE id = ?'; 
	  $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	  $sth->execute($nid) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	     while(my $ref = $sth->fetchrow_hashref()) 
           {	
              $template{'subject'} =  $ref->{'subject'};
              $template{'note'}    =  $ref->{'message'}; 
              $template{'note'}    =~ s/<br>/\n/g;

              $template{'nid'}     = $nid;
           }

   print parse("$global{'data'}/include/tpl/admin/anc_edit");

  }



if ($section eq "anc_esave")
 {
     check_user();
     print "Content-type: text/html\n\n";

     my $nid     =  $q->param('nid');
     my $subject =  $q->param('subject');
     my $message =  $q->param('notes');
        $message =~ s/\n/<br>/g;
     
	  $statement =  'UPDATE perlDesk_announce SET subject = ?, message = ? WHERE id = ?'; 
	  $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	  $sth->execute( $subject, $message, $nid ) or die print "Couldn't execute statement: $DBI::errstr; stopped";
 
    $template{'response'} = qq|<font face=Verdana size="2">Announcement Updated <a href=admin.cgi?do=announcements> Announcements</a>|;     
    print parse("$global{'data'}/include/tpl/admin/general");

 }




if ($section eq "adduser")
 {
     check_user();
     print "Content-type: text/html\n\n";

    my $statement = 'SELECT * FROM perlDesk_signup_fields ORDER BY dorder'; 
    my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
       $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
    while(my $ref = $sth->fetchrow_hashref()) 
      {	   
          $value = $q->param($ref->{'id'});

          $template{'fields'} .= qq|<tr><td width="5%"></td><td width="28%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'name'}</font></td><td width="67%">
                                  <input type="text" class="tbox"  name="$ref->{'id'}" value="$value" size="35"></font></td></tr>
                                 |;
      }
    $sth->finish;

     print parse("$global{'data'}/include/tpl/admin/adduser");

 }


if ($section eq "saveuser")
 {
   
     check_user();

     my $name     =   $q->param('name');
        $email    =   $q->param('email');
     my $company  =   $q->param('company');
     my $url      =   $q->param('url');
     my $user     =   $q->param('username');
     my $pass1    =   $q->param('pass1');
     my $pass2    =   $q->param('pass2');

    die_nice("Passwords do not match") if $pass1 != $pass2;

	my  $sth = $dbh->prepare("SELECT * FROM perlDesk_users WHERE username = ?") or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute($user) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref())  { }
        
        if ($sth->rows != "0") 
           {
                $error = "Username <b>$user</b> exists<br>";
           }
        
     	$sth->finish;   

           $error  = "$LANG{'error5'} $LANG{'name'}<br>"              if !$name;
           $error .= "$LANG{'error5'} $LANG{'email'}<br>"             if !$email;
           $error .= "The username cannot contain spaces<br>"         if $user =~ / /;
           $error .= "$LANG{'username'} <b>$user</b> $LANG{'error2'}" if $user =~ /^unregistered\b/i;
           
           die_nice("$error") if $error;

    	my @chars    =  (A..Z);
     	my $salt     =  $chars[rand(@chars)] . $chars[rand(@chars)];
    	 $password =   crypt($pass1, $salt);	
         $pending  = '0'; 
         $code     = '0';

   #~
   # Insert User into Database
   #~

    my $rv = $dbh->do(qq{INSERT INTO perlDesk_users values ("NULL", "$user", "$password", "$name", "$email", "$url", "$company", "$salt", "$pending", "0", "$code", "0")});

     $id   =  $dbh->{'mysql_insertid'}; 

     $template{'user'}     = $user;    
     $template{'username'} = $user;
     $template{'password'} = $pass1;
     $template{'cname'}    = $name; 
     $template{'baseurl'}  = $global{'baseurl'};
     $template{'mainfile'} = 'pdesk.cgi';


    my $statement = 'SELECT * FROM perlDesk_signup_fields ORDER BY dorder'; 
    my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
       $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
    while(my $ref = $sth->fetchrow_hashref()) 
      {	
         my $fid = $ref->{'id'};
         my $sth = $dbh->prepare( "INSERT INTO perlDesk_signup_values VALUES ( ?, ?, ?, ? )" ) or die $DBI->errstr;
            $sth->execute( "NULL", $id, "$fid", $q->param($fid) ) or die $DBI->errstr;              
      }
    $sth->finish;


      if ($q->param('notify') eq "yes")
        {
              my $body;
  		 open (MAILTPL, "$global{'data'}/include/tpl/welcome.txt");
			while (<MAILTPL>) 
                          {
                              lang_parse() if $_ =~ /%*%/;
                              s/\{(\S+)\}/$template{$1}/g;
            	              $body .= $_;
		 	  }  
		 close(MAILTPL);	
                 email ( To => "$email", From => "$global{'adminemail'}", Subject => "Help Desk Registration", Body => "$body");
        }

     print "Content-type: text/html\n\n";
     $template{'response'} = qq|<font size="2">Thank you, <b>$user</b> has been created on this help desk.|;        
     print parse("$global{'data'}/include/tpl/admin/general");   
 }


if ($section eq "hdsettings")
 {
     check_user();
     print "Content-type: text/html\n\n";

   $template{'achecked'} = ' checked' if $global{'validate'} == "1";
   $template{'bchecked'} = ' checked' if $global{'reqvalid'} == "1";

   $template{'achecked'} = '' if $global{'validate'} == "0";
   $template{'bchecked'} = '' if $global{'reqvalid'} == "0";


    if ($global{'pager'}) { $template{'pcheck'} = " checked"; } else { $template{'pcheck'} = ""; }
  
    $template{'pager'} = $global{'pageraddr'} || ""; 
 
    if ($global{'sess_ip'}) { $template{'ipc'} = qq| checked|;} else { $template{'ipc'} = ""; }

    if (get_setting_2("staff_rating")) { $template{'rat'} = qq| checked|;} else { $template{'rat'} = ""; }


    if (get_setting_2("access_submit"))       { $template{'a'} = qq| checked|;}      else { $template{'a'} = ""; }
    if (get_setting_2("access_view"))         { $template{'b'} = qq| checked|;}      else { $template{'b'} = ""; }
    if (get_setting_2("access_respond"))      { $template{'c'} = qq| checked|;}      else { $template{'c'} = ""; }
    if (get_setting_2("access_rate"))         { $template{'d'} = qq| checked|;}      else { $template{'d'} = ""; }
    if (get_setting_2("signup_notification")) { $template{'scheck'} = qq| checked|;} else { $template{'scheck'} = ""; }

    $template{'chars'} = get_setting_2("pass_chars");

    my $statement = 'SELECT * FROM perlDesk_ticket_fields ORDER BY dorder'; 
    my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
       $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
    while(my $ref = $sth->fetchrow_hashref()) 
        {	
          $template{'fields'} .= qq|  <input type="hidden" name="id" value="$ref->{'id'}"><table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
                                      <tr><td width="19%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Ticket Field</font></td><td width="40%"> <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><input type="text" name="$ref->{'id'}" value="$ref->{'name'}" class="tbox">
                                      </font></td><td width="10%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">ORDER</font></td><td width="11%"> <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><input type="text" name="order_$ref->{'id'}" value="$ref->{'dorder'}" class="tbox" size="2">
                                      </font></td> <td width="18%"> <font size="1" face="Verdana, Arial, Helvetica, sans-serif"> </font></td></tr></table>
                                   |;

        }

         $template{'fields'} = "" if !$sth->rows;

      $sth->finish;

       $statement = 'SELECT * FROM perlDesk_signup_fields ORDER BY dorder'; 
       $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
       $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
    while(my $ref = $sth->fetchrow_hashref()) 
        {	
          $template{'sfields'} .= qq|  <input type="hidden" name="id" value="$ref->{'id'}"><table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
                                      <tr><td width="19%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Ticket Field</font></td><td width="40%"> <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><input type="text" name="$ref->{'id'}" value="$ref->{'name'}" class="tbox">
                                      </font></td><td width="10%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">ORDER</font></td><td width="11%"> <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><input type="text" name="order_$ref->{'id'}" value="$ref->{'dorder'}" class="tbox" size="2">
                                      </font></td> <td width="18%"> <font size="1" face="Verdana, Arial, Helvetica, sans-serif"> </font></td></tr></table>
                                   |;

        }
         $template{'sfields'} = "" if !$sth->rows;
      $sth->finish;


   print parse("$global{'data'}/include/tpl/admin/websettings");
 }

#~~
# Signup Values


 if ($section eq "save_sfields")
  {
     check_user();    
     print "Content-type: text/html\n\n";

           my  $sth = $dbh->prepare(qq|SELECT * FROM perlDesk_signup_fields|) or die "Couldn't prepare statement: $DBI::errstr; stopped";
	       $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		 while(my $ref = $sth->fetchrow_hashref())
                   {
                        $order  = 'order_';
                        $order .= $ref->{'id'};
                        $name   = $q->param($ref->{'id'});
                        $yesno  = $q->param($order);
                        $id     = $ref->{'id'};

                        if (!$name) { $dbh->do(qq|DELETE FROM perlDesk_signup_fields WHERE id = "$id"|); } 
                        else        { $dbh->do(qq|UPDATE perlDesk_signup_fields SET name = "$name", dorder = "$yesno" WHERE id = "$id"|);    }
                   }
         
     	print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=admin.cgi?do=hdsettings"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank you, signup fields saved</b>.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=hdsettings">click 
					here</a> if you are not automatically forwarded</font></p></html>
                |;
 }

if ($section eq "sadform")
 {
     check_user();
     print "Content-type: text/html\n\n";

     my $name  = $q->param('field');
     my $order = $q->param('order');

        $dbh->do(qq~INSERT INTO perlDesk_signup_fields VALUES ( "NULL", "$name", "$value", "$order" )~);

     $template{'response'} = qq|<font face="Verdana" size="2">Signup Field <b>$name</b> has been saved|;
     print parse("$global{'data'}/include/tpl/admin/general");

 }



#~~

 if ($section eq "save_hdfields")
  {
     check_user();    
     print "Content-type: text/html\n\n";

           my  $sth = $dbh->prepare(qq|SELECT * FROM perlDesk_ticket_fields|) or die "Couldn't prepare statement: $DBI::errstr; stopped";
	       $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		 while(my $ref = $sth->fetchrow_hashref())
                   {
                        $order  = 'order_';
                        $order .= $ref->{'id'};
                        $name   = $q->param($ref->{'id'});
                        $yesno  = $q->param($order);
                        $id     = $ref->{'id'};

                        if (!$name) { $dbh->do(qq|DELETE FROM perlDesk_ticket_fields WHERE id = "$id"|); } 
                        else        { $dbh->do(qq|UPDATE perlDesk_ticket_fields SET name = "$name", dorder = "$yesno" WHERE id = "$id"|);    }
                   }
         
     	print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=admin.cgi?do=hdsettings"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank you, ticket fields saved</b>.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=hdsettings">click 
					here</a> if you are not automatically forwarded</font></p></html>
                |;

 }



 if ($section eq "upus")
 {
     check_user();
     print "Content-type: text/html\n\n";

      $pager     =  $q->param('pager')     || "0";
      $pageraddr =  $q->param('pageraddr');
      $reqvalid  =  $q->param('usvalid')   || "0";
      $emvalid   =  $q->param('sendvalid') || "0";
      $staff     =  $q->param('rating')    || "0";
      $sess      =  $q->param('ip')        || "0";
      $chars     =  $q->param('chars')     || "0";

    foreach("access_submit","access_view","access_respond","access_rate") 
        {
             my $var = $q->param($_) || "0";
                $dbh->do(qq|UPDATE perlDesk_settings_extra SET value = "$var"  WHERE setting = "$_"|);
        }

    $dbh->do(qq|UPDATE perlDesk_settings SET value = "$pager"  WHERE setting = "pager"|);
    $dbh->do(qq|UPDATE perlDesk_settings SET value = "$pageraddr"  WHERE setting = "pageraddr"|);
    $dbh->do(qq|UPDATE perlDesk_settings SET value = "$emvalid"  WHERE setting = "reqvalid"|);
    $dbh->do(qq|UPDATE perlDesk_settings SET value = "$reqvalid" WHERE setting = "validate"|);
    $dbh->do(qq|UPDATE perlDesk_settings_extra SET value = "$staff" WHERE setting = "staff_rating"|);
    $dbh->do(qq|UPDATE perlDesk_settings_extra SET value = "$chars" WHERE setting = "pass_chars"|);

    $dbh->do(qq|UPDATE perlDesk_settings SET value = "$sess" WHERE setting = "sess_ip"|);


    	print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=admin.cgi?do=hdsettings"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank You</b>, web based settings saved.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=hdsettings">click 
					here</a> if you are not automatically forwarded</font></p></html>
                |;





 }



#~~
# PerlDesk Settings
#~~

 if ($section eq "settings")
  {
     check_user();
     print "Content-type: text/html\n\n";


       if ($global{'kb_req_user'})    { $template{'kb'}   = qq| checked|; } else { $template{'kb'} = ""; }
       if ($global{'sdelete'})        { $template{'sdel'} = qq| checked|; } else { $template{'sdel'} = "";  }
       if (get_setting_2("use_smtp")) { $template{'smtp'} = " checked"; $template{'sendmail'} = ""; } else { $template{'sendmail'} = "checked"; $template{'smtp'} = ""; }

      $template{'smtp_add'}  =  get_setting_2("smtp_address");
      $template{'smtp_port'} =  get_setting_2("smtp_port");
      $template{'footer'}    =  get_setting_2("em_footer");
      $template{'logo'}      =  $global{'logo_url'};

       foreach (qw/pri1 pri2 pri3 pri4 pri5/)
         {
              $template{$_} = $global{$_};
         }


        $statement = 'SELECT notify FROM perlDesk_staff WHERE  username = "admin"'; 
        $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	   while(my $ref = $sth->fetchrow_hashref()) 
	     { $template{'alert'} = " checked" if $ref->{'notify'} == "1";  $template{'alert'} = "" if $ref->{'notify'} != "1"; } 

      $template{'sendmail_path'}   =  $global{'sendmail'};
      $template{'adminemail'} =  $global{'adminemail'};   
      $template{'name'}       =  $name;
      $template{'offset'}     =  $global{'timeoffset'};
      $template{'hdtime'}     =  $hdtime;
      $template{'file'}       = get_setting_2("file_path");

      if ((-e $template{'file'}) && (-W $template{'file'})) 
             { $template{'perm'} = ""; } else { if (defined $template{'file'} && $template{'file'} ne "") { $template{'perm'} = "<br>Directory Does Not Exist or Insufficient Permissions"; } else { $template{'perm'} = "";} } 

     print parse("$global{'data'}/include/tpl/admin/settings");
  }






 if ($section eq "savesettings")
  {
     check_user();
 
	$alert     =  $q->param('alert');
	$email     =  $q->param('email');
	$name      =  $q->param('name');
	$allowhtml =  "yes";
	$pass      =  $q->param('password');
        $title     =  $q->param('title');
	$pri1      =  $q->param('pri1');
	$pri2      =  $q->param('pri2');
	$pri3      =  $q->param('pri3');
	$pri4      =  $q->param('pri4');
	$pri5      =  $q->param('pri5');
	$sig       =  $q->param('sig');
        $sendmail  =  $q->param('sendmail_path');
        $baseurl   =  $q->param('baseurl');
        $imgbase   =  $q->param('imgbase');
        $language  =  $q->param('language');
        $adminemail = $q->param('email');
        $timeo      = $q->param('time');
        $fpath      = $q->param('file_path');
        $use_smtp   = $q->param('sendmail');
        $smtp_add   = $q->param('smtp_address');
        $smtp_port  = $q->param('smtp_port');
        $em_footer  = $q->param('footer');
        $logo       = $q->param('logo');

    if (! $langdetails{$language}) { die_nice("Invalid Language File <b>$language.inc</b>"); }

    execute_sql(qq|UPDATE perlDesk_settings_extra SET value = "$fpath" WHERE setting = "file_path"|);
    execute_sql(qq|UPDATE perlDesk_settings_extra SET value = "$use_smtp" WHERE setting = "use_smtp"|);
    execute_sql(qq|UPDATE perlDesk_settings_extra SET value = "$smtp_add" WHERE setting = "smtp_address"|);
    execute_sql(qq|UPDATE perlDesk_settings_extra SET value = "$smtp_port" WHERE setting = "smtp_port"|);

	$statement = 'UPDATE perlDesk_settings_extra SET value  = ? WHERE setting = "em_footer"'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
	$sth->execute( $em_footer ) or die print "Couldn't execute statement: $DBI::errstr; stopped";


    $dbh->do(qq|UPDATE perlDesk_settings SET value = "$logo" WHERE setting = "logo_url"|);
    $dbh->do(qq|UPDATE perlDesk_settings SET value = "$adminemail" WHERE setting = "adminemail"|);
    $dbh->do(qq|UPDATE perlDesk_settings SET value = "$sendmail" WHERE setting = "sendmail"|);
    $dbh->do(qq|UPDATE perlDesk_settings SET value = "$baseurl" WHERE setting = "baseurl"|);
    $dbh->do(qq|UPDATE perlDesk_settings SET value = "$imgbase" WHERE setting = "imgbase"|);
    $dbh->do(qq|UPDATE perlDesk_settings SET value = "$language" WHERE setting = "language"|);
    $dbh->do(qq|UPDATE perlDesk_settings SET value = "$timeo" WHERE setting = "timeoffset"|);
    $dbh->do(qq|UPDATE perlDesk_settings SET value  = "$title" WHERE setting = "title"|); 
	

	# UPDATE CALL SHADING
 
        my $kb = $q->param('kb');

         execute_sql(qq|UPDATE perlDesk_settings SET value = "$kb" WHERE setting = "kb_req_user"|);

	$statement = 'UPDATE perlDesk_settings SET value  = ? WHERE setting = "pri1"'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
	$sth->execute($pri1) or die print "Couldn't execute statement: $DBI::errstr; stopped";

	$statement = 'UPDATE perlDesk_settings SET value  = ? WHERE setting = "pri2"'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
	$sth->execute($pri2) or die print "Couldn't execute statement: $DBI::errstr; stopped";

	$statement = 'UPDATE perlDesk_settings SET value  = ? WHERE setting = "pri3"'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
	$sth->execute($pri3) or die print "Couldn't execute statement: $DBI::errstr; stopped";

	$statement = 'UPDATE perlDesk_settings SET value  = ? WHERE setting = "pri4"'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
	$sth->execute($pri4) or die print "Couldn't execute statement: $DBI::errstr; stopped";

	$statement = 'UPDATE perlDesk_settings SET value  = ? WHERE setting = "pri5"'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
	$sth->execute($pri5) or die print "Couldn't execute statement: $DBI::errstr; stopped";

	# UPDATE STAFF DELETE ACCESS

	$sdelete = $q->param('staffdelete');

	if ($sdelete eq "yes") { $snum = 1; } else { $snum = 0; }

	$statement = 'UPDATE perlDesk_settings SET value  = ? WHERE setting = "sdelete"'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
	$sth->execute($snum) or die print "Couldn't execute statement: $DBI::errstr; stopped";


	# UPDATE STAFF LOCK ACCESS

	$slock = $q->param('stafflock');

	if ($slock eq "yes") { $slnum = 1; } else { $slnum = 0; }

	$statement = 'UPDATE perlDesk_settings SET value  = ? WHERE setting = "slock"'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
	$sth->execute($slnum) or die print "Couldn't execute statement: $DBI::errstr; stopped";


	# UPDATE PROFILE

	if ($alert eq "yes") { $notify = 1; } else { $notify = 0; }
		$statement = 'UPDATE perlDesk_staff SET name = "' . "$name" . '", email = "' . "$email" . '", notify = "' . "$notify" . '", signature = "' . "$sig" . '" WHERE username = "' . "admin" . '"'; 
				$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 				$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";


	# UPDATE PASSWORD

 	if ($pass ne "") 
         {
			my @chars=(A..Z);

				$salt      =  $chars[rand(@chars)] . $chars[rand(@chars)];
				$epass     =  crypt($pass, $salt);

				$tatement =  qq|UPDATE perlDesk_staff SET password = "$epass", rkey = "$salt" WHERE username = "admin"|; 
				$sth       =  $dbh->prepare($tatement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 				$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
				$sth->finish;
	 }

     print "Content-type: text/html\n\n";

		print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=admin.cgi?do=settings"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank you</b>, you are now being re-directed.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=settings">click 
					here</a> if you are not automatically forwarded</font></p></html>
                        |;
  }






#~~
#  Template Management
#~~



 if ($section eq "tpl")
  {

     check_user();
     print "Content-type: text/html\n\n";

	opendir(FRL, "$global{'data'}/include/tpl");
			@files = readdir FRL;
	closedir(FRL);	

       $file = qq|<table width="80%" border="0" cellspacing="1" cellpadding="0" align="center">|;
       $num  = 0;

	foreach $fil (@files) 
	{
		next if $fil =~ /^\.+$/;
		next if $fil =~ /\.html/;
                               
		if ($fil =~ /\./) 
		{

                    $file .= "<tr>" if $num == "0";                   

			if ($fil =~ /txt/i) { $img = "$global{'imgbase'}/txt.gif"; }
			if ($fil =~ /tpl/i) { $img = "$global{'imgbase'}/tpl.gif"; }

			$file .= qq|<td width="24%"><div align="center"><img src="$img"></div></td><td width="76%"><a href="admin.cgi?do=edittpl&file=$fil"><font size=2>$fil</font></a></td>|;

                        $num++;

                        $file .= "</tr>" if $num == 2;
                        $num   = "0"     if $num == 2;
		} 

	}

              $file .= "</table>";

   $template{'files'}  =   $file;

   print parse("$global{'data'}/include/tpl/admin/temp");
 }


 if ($section eq "edittpl")
  {
     check_user();
     print "Content-type: text/html\n\n";
 
        my $vfile = $q->param('file');    

		open (FILE, "$global{'data'}/include/tpl/$vfile") || die "$!";
                    while (<FILE>) {  $content .= $_;  }
		close (FILE);


                $content =~ s/<!-- {{(.*?)}} -->//;
                $desc    = $1 || "No Description available for this file '$vfile'";
                

                $content =~ s/</&lt\;/gi;
                $content =~ s/>/&gt\;/gi;
                $content =~ s/\{/&#123;/gi;
                $content =~ s/\}/&#125;/gi;


		$template{'response'} = qq|<font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>EDIT FILE 
                                           $vfile </b></font><br><br><table width="90%" border="0" align="center" cellpadding="8" cellspacing="0"><tr><td bgcolor="#CDDEF3"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>TEMPLATE DESCRIPTION&nbsp;</strong></font><br><font size="1" face="Verdana, Arial, Helvetica, sans-serif">$desc</font></td></tr></table><br><table width="100%" border="0" align="center"><tr><td valign="top"> </td></tr><tr><td><div align="right"><font size="2"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"></font></font></font></div></td></tr><tr><td height="20"><form name="form1" method="post" action="admin.cgi">
                                           <div align="center"><textarea name="textfield" class="gbox" cols="80" rows="40">$content</textarea><br><br><input type="hidden" name="desc" value="$desc"><input type="hidden" name="file" value="$vfile"><input type=hidden name=do value=savetpl><input type="submit" name="Submit" value="Save"></div></form></td></tr><tr><td>&nbsp;</td></tr></table>|;

                print parse("$global{'data'}/include/tpl/admin/general");
  }



 if ($section eq "savetpl")
  {
     check_user();
     print "Content-type: text/html\n\n";

        my $textfield  = '<!-- {{'             if $q->param('file') !~ /\.txt/;
           $textfield .= $q->param('desc')     if $q->param('file') !~ /\.txt/;
           $textfield .= '}} -->'              if $q->param('file') !~ /\.txt/;

	   $textfield .= $q->param('textfield');
        my $vfile      = $q->param('file');
       
		open (FILE, ">$global{'data'}/include/tpl/$vfile") || ($response = "Error: $!");
			print FILE "$textfield";
		close (FILE);

		$response = qq|Thank you, $vfile Saved! <a href="admin.cgi?do=tpl">Back to Templates</a>| if !$response;

        $template{'response'} = $response;
        print parse("$global{'data'}/include/tpl/admin/general");
    }


#~~
# View a logged ticket 
#~~


 if ($section eq "ticket")
  {
   check_user(); 
    print "Content-type: text/html\n\n";

    my $trackedcall=$q->param('cid');

       $statement = 'SELECT * FROM perlDesk_calls WHERE  id = ? ORDER BY id'; 
        $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute($trackedcall) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		$number=0;
			  while(my $ref = $sth->fetchrow_hashref()) 
				{	
						$template{'trackno'}     =   $ref->{'id'};
						$template{'date'}        =   $ref->{'time'};
						$template{'uname'}       =   $ref->{'username'};
						$template{'username'}    =   $ref->{'username'};
						$template{'priority'}    =   $ref->{'priority'};
						$template{'status'}      =   $ref->{'status'};
						$template{'subject'}     =   $ref->{'subject'};
						$template{'category'}    =   $ref->{'category'};
						$template{'description'} =   $ref->{'description'};
						$template{'owned'}       =   $ref->{'ownership'};
						$template{'number'}      =   0;
                                                $template{'ckey'}        =   $ref->{'ikey'};
			  			$template{'email'}       =   $ref->{'email'};
						$template{'url'}         =   $ref->{'url'};
						$template{'name'}        =   $ref->{'name'};
                                                $template{'time_spent'}  =   $ref->{'time_spent'} || "0";
			        }
	if (@errors) 
	 {       print @errors;
		 $dbh->disconnect;
    		 exit;
  	 }

    my $statement = 'SELECT * FROM perlDesk_ticket_fields ORDER BY dorder'; 
    my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
       $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
    while(my $ref = $sth->fetchrow_hashref()) 
      {	
            my $tatement = qq|SELECT * FROM perlDesk_call_fields WHERE cid = "$trackedcall" AND fid = "$ref->{'id'}"|; 
            my $th = $dbh->prepare($tatement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
               $th->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
                 while(my $ef = $th->fetchrow_hashref()) 
                   {	
                        $template{'fields'} .= qq|
                                                    <tr> <td width="19%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'name'}</font></td>
                                                    <td width="72%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">$ef->{'value'}</font> </td></tr>
                                                 |;
      
                   }
      }
    $sth->finish;

   $template{'fields'} = '' if !$template{'fields'};
  
	my $statement = 'SELECT * FROM perlDesk_settings WHERE setting = "allowhtml"'; 
		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
		   {
				my $htmlcode = "$ref->{'value'}";
		   }
	$statemente = 'SELECT * FROM perlDesk_notes WHERE call = ? ORDER BY id;'; 
	$sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute($trackedcall) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	      while(my $ref = $sth->fetchrow_hashref()) {
        
            	$body = $ref->{'comment'};
                $body = pdcode("$body");

	if ($body =~ /^</) {	} else 
           {
    	 	$body =~ s/\n/<br>/g;
           }


	if ($ref->{'owner'} == "0") 
			{
				$notes .= '<tr><td width="30%" height="14" valign="top" bgcolor="#F2F2F2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>' . "$ref->{'author'}" . '<br>
   				           </b></font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . "$ref->{'time'}" . '<br><br><a href="staff.cgi?do=editnote&nid=' . "$ref->{'id'}" . '"></a> </font></td>
   					   <td width="70%" height="14" valign="top" bgcolor="#F2F2F2"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . "$body" . '</font></td></tr>';
			} 

	if ($ref->{'owner'} == "3") 
			{
                                           $statement = 'SELECT name FROM perlDesk_staff WHERE id = ?'; 
                                           $th        = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	                                   $th->execute($ref->{'author'}) or die print "Couldn't execute statement: $DBI::errstr; stopped";
         	                               while(my $f = $th->fetchrow_hashref()) {  $s_name = $f->{'name'}; }

 	     			           $notes .= '<tr><td width="30%" height="14" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>' . "$s_name" . '<br>
   						      </b></font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . "$ref->{'time'}" . '<br><br></font></td>
   						      <td width="70%" height="14" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . "<b>STAFF ACTION: $ref->{'action'}</b><br>$body" . '</font></td></tr>';
			} 

	if ($ref->{'owner'} == "1") 
			{
                                      $statement = 'SELECT name FROM perlDesk_staff WHERE id = ?'; 
                                      $th = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
                   	              $th->execute($ref->{'author'}) or die print "Couldn't execute statement: $DBI::errstr; stopped";
         	                        while(my $f = $th->fetchrow_hashref()) {  $s_name = $f->{'name'}; }
                         
                                      $statemente = 'SELECT id,nid,rating FROM perlDesk_reviews WHERE nid = ?';  
                                      $th = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
                                      $th->execute($ref->{'id'}) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	                                   while(my $ef = $th->fetchrow_hashref()) {  for(1..$ef->{'rating'}) { $rating .= "<a href=staff.cgi?do=view_review&nid=$ref->{'id'}><img src=$global{'imgbase'}/star_filled.gif heigh=12 border=0 width=10></a>"; } }
                                      if ($th->rows == "0") { $rating = "No Rating"; }

    	                              if ($ref->{'visible'} eq 0) { $notice = '<b>PRIVATE STAFF NOTE</b><br>'; } else { $notice = ''; }

					   $notes .= qq|<tr><td width="30%" height="14" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>$s_name<br>
   						        </b></font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">$ref->{'time'}<br><br>User Rating: $rating<br><br><br><a href="staff.cgi?do=editnote&nid=$ref->{'id'}"></a> </font></td>
   						        <td width="70%" height="14" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">$notice $body<br><Br><br><br>-------------<br>$filename</font></td></tr>|;
			}
			
		}


	if ($template{'description'} =~ /^</) {	} else 
          {
	 	# This is a Text Email, format it!
	    	$template{'description'} =~ s/\n/<br>/g;
	  }
  

       $statement = 'SELECT * FROM perlDesk_activitylog WHERE cid = ? ORDER BY id'; 
       $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
       $sth->execute($trackedcall) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	  while(my $ref = $sth->fetchrow_hashref()) 
	   {
                $template{'log'} .= qq|<tr bgcolor="#E8E8E8"><td width="25%" height="8"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'date'}</font></td>
                <td width="20%" height="8"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'user'}</font></td><td colspan="3" height="8" width="55%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'action'}</font></td></tr>|;
           }
        if ($sth->rows == "0") { $template{'log'} = ""; }



    $template{'notes'}    =  $notes || "";

    my $output = parse("$global{'data'}/include/tpl/admin/viewticket");
    print $output;

  }


#~~
# Delete a logged ticket
#~~

if ($section eq "del_ticket")
 {
    check_user();

      my $id = $q->param('id');
      my $st = $q->param('status');


      execute_sql(qq|DELETE FROM perlDesk_calls WHERE id = "$id"|);

		print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=admin.cgi?do=listcalls&status=$st"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank you, ticket $id has been removed</b></font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=listcalls&status=$st">click 
					here</a> if you are not automatically forwarded</font></p></html>
                        |;
 }


#~~
# View a users profile
#~~
 if ($section eq "viewuser")
   {

     check_user();
     print "Content-type: text/html\n\n";

        $uusername =  $q->param('user');
        $uusername =~ s/_/ /g;

     	$sth = $dbh->prepare( "SELECT COUNT(*) FROM perlDesk_calls WHERE username = ?" ) or die DBI->errstr;
		$sth->execute($uusername) or die print "Couldn't execute statement: $DBI::errstr; stopped";
        	( $requests ) = $sth->fetchrow_array();
     	$sth->finish;

    	$statement = 'SELECT id, username, email, company, url, name, acode FROM perlDesk_users WHERE username = ?'; 
     	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute($uusername) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
                 {	
			$template{'username'} =  $ref->{'username'};
                        $template{'userid'}   =  $ref->{'id'};
			$template{'email'}    =  $ref->{'email'};
			$template{'company'}  =  $ref->{'company'};
			$template{'url'}      =  $ref->{'url'};
			$template{'name'}     =  $ref->{'name'};
                        $template{'acode'}    =  $ref->{'acode'};
	         }

        if ($template{'acode'}) { $template{'activate'} = qq|<br><br><b>User Inactive</b> This user has not validated his/her email address <a href="pdesk.cgi?do=activate&key=$template{'acode'}&uid=$template{'userid'}">Validate</a><br>|;   } else { $template{'activate'} = ""; }

       #~~
       # Obtain Status Report
       #~~
 
        foreach("open","hold","closed")
          {
               	$sth = $dbh->prepare( "SELECT COUNT(*) FROM perlDesk_calls WHERE username = ? AND status = ?") or die DBI->errstr;
		$sth->execute($template{'username'}, $_) or die print "Couldn't execute statement: $DBI::errstr; stopped";
                 	 $template{$_} = $sth->fetchrow_array();
     	        $sth->finish;  
          }

        #~~
        # Get Extra Signup Fields
        #~~

          my $statement = 'SELECT * FROM perlDesk_signup_fields ORDER BY dorder'; 
          my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
             $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
      while(my $ref = $sth->fetchrow_hashref()) 
      {	
            my $tatement = qq|SELECT * FROM perlDesk_signup_values WHERE cid = "$template{'userid'}" AND sid = "$ref->{'id'}"|; 
            my $th = $dbh->prepare($tatement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
               $th->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
                 while(my $ef = $th->fetchrow_hashref()) 
                   {	                     
                        my $value = $ef->{'value'}; 
                           $value = '&nbsp;' if !$value;

                        $template{'fields'} .= qq|
                                                    <tr> <td width="19%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'name'}</font></td>
                                                    <td width="72%"><font face="Verdana" size="2">$value</font></td></tr>
                                                 |;    
                   } $template{'fields'} = "" if !$th->rows;

      }
    $sth->finish;


        #~~
        # Generate Graphical Departmental Submission Report
        #~~

          $template{'graph1'} = qq| <table width="90%" border="0" cellspacing="0" cellpadding="2" align="center">|;

      if ($requests)
        {
          $statement = 'SELECT level FROM perlDesk_departments'; 
	  $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	  $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	    while(my $ref = $sth->fetchrow_hashref()) 
		{
		               	$th = $dbh->prepare( "SELECT COUNT(*) FROM perlDesk_calls WHERE category = ? AND username = ?") or die DBI->errstr; 
                 		$th->execute($ref->{'level'}, $template{'username'}) or die print "Couldn't execute statement: $DBI::errstr; stopped";
                                	 my $calls = $th->fetchrow_array();
     	                        $th->finish; 

                                my $perc  =  ($calls/$requests)*100;  
                                my $aperc = "1" if !$perc;                     
                       
                                $template{'graph1'} .= qq|<tr><td colspan="3"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'level'}</font></td><td width="53%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">$calls</font></td></tr><tr><td width="29%"><div align="left"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><em>$perc%</em></font></div></td>
                                                          <td width="2%"><div align="right"><font color="#999999" size="2">\|</font></div></td><td colspan="2"><div align="left"></div><table width="$aperc%" height="9" border="00" align="left" cellpadding="0" cellspacing="0"><tr><td width="1" height="9" background="$global{imgbase}/admin_stats_bg_yellow.gif"><div align="right"><img src="$global{imgbase}/admin_stats_left_yellow.gif" width="2" height="9"></div></td><td width="50" height="9" background="$global{imgbase}/admin_stats_bg_yellow.gif"><img src="$global{imgbase}/admin_stats_bg_yellow.gif" width="1" height="9"></td><td width="3" height="9"><div align="left"><img src="$global{imgbase}/admin_stats_right_yellow.gif" width="3" height="9"></div></td></tr></table></td></tr>|;
 
                         $crm  = "1" if !$sql;
                         $sql  = qq|SELECT COUNT(*) FROM perlDesk_calls WHERE (username = "$template{'username'}" AND category != "$ref->{'level'}"| if !$sql;
                         $sql .= qq| OR category != "$ref->{'level'}"| if !$crm;
                 }
                          $sql .= qq|)|;

               if ($sth->rows > 0)
                 {
		               	$th = $dbh->prepare( $sql ) or die DBI->errstr; 
                 		$th->execute() or die "Couldn't execute statement $sql: $DBI::errstr; stopped";
                                	 my $scalls = $th->fetchrow_array();
     	                        $th->finish; 

                                $sperc  =  ($scalls/$requests)*100;
                                $operc  = "1" if !$sperc;
                  }
                                $template{'graph1'} .= qq|<tr><td colspan="3"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Other*</font></td><td width="53%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">$scalls</font></td></tr><tr><td width="29%"><div align="left"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><em>$sperc%</em></font></div></td>
                                                          <td width="2%"><div align="right"><font color="#999999" size="2">\|</font></div></td><td colspan="2"><div align="left"></div><table width="$operc%" height="9" border="00" align="left" cellpadding="0" cellspacing="0"><tr><td width="1" height="9" background="$global{imgbase}/admin_stats_bg_yellow.gif"><div align="right"><img src="$global{imgbase}/admin_stats_left_yellow.gif" width="2" height="9"></div></td><td width="50" height="9" background="$global{imgbase}/admin_stats_bg_yellow.gif"><img src="$global{imgbase}/admin_stats_bg_yellow.gif" width="1" height="9"></td><td width="3" height="9"><div align="left"><img src="$global{imgbase}/admin_stats_right_yellow.gif" width="3" height="9"></div></td></tr></table></td></tr>|;
     } else { $template{'graph1'} .= qq|<br><div align=center><font face="verdana" size="1">No Graph Data</font></div><br>|;}
                 

   $template{'graph1'}         .=   "</table>";
   $template{'requests'}        =   $requests;
   my $output = parse("$global{'data'}/include/tpl/admin/userview");
   print $output;

   } 
 


 if ($section eq "usercalls")
  {

     check_user();
     print "Content-type: text/html\n\n";

	$cusername = $q->param('user');

	$statement = 'SELECT * FROM perlDesk_calls WHERE  username = ? ORDER BY id'; 
		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute($cusername) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		$number=0;
			  while(my $ref = $sth->fetchrow_hashref()) {	
					
				if (($ref->{'category'} eq $accesslevel) || ($accesslevel = 'GLOB')) {
 				$number++;
					
            	if ($ref->{'priority'} eq 1) { $font = '#990000'; } else { $font = '#000000'; }			

     			if ($ref->{'method'}  eq "cc") { $img   = "phone.gif";     } elsif ($ref->{'method'} eq "em") { $img = "mail.gif"; } else { $img = "ticket.gif"; }

       			$subject="$ref->{'subject'}"; 
       			$subject=substr($subject,0,18).'..' if length($subject) > 20;

                 $call .= display_ticket($ref->{'id'}, $ref->{'username'}, $ref->{'category'}, $ref->{'status'}, $ref->{'time'});
   		  
					}
			}

      $template{'username'}    =   $cusername;
      $template{'numcalls'}    =   $number;   
      $template{'listcalls'}   =   $call;
   my $output = parse("$global{'data'}/include/tpl/admin/usercalls");
   print $output;

  }


 if ($section eq "emailusers")
  {

     check_user();
     print "Content-type: text/html\n\n";

     my $output = parse("$global{'data'}/include/tpl/admin/emailusers");
     print $output;

  }

 if ($section eq "emailstaff")
  {

     check_user();
     print "Content-type: text/html\n\n";

     my $output = parse("$global{'data'}/include/tpl/admin/emailstaff");
     print $output;

  }

 if ($section eq "usersend")
  {

     check_user();
     print "Content-type: text/html\n\n";

	$email = $q->param('email');
	$subje = $q->param('subject');
	$messg = $q->param('message');

	$statement = 'SELECT email FROM perlDesk_users'; 
		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	while(my $ref = $sth->fetchrow_hashref()) {	
      if ($enablemail) {

                              email( To => "$ref->{'email'}", From => "$email", Subject => "$subje", Body => "$messg" );                      

      }
	}


		print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=admin.cgi?do=users"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank you</b>, you are now being re-directed.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=users">click 
					here</a> if you are not automatically forwarded</font></p></html>
                        |;
   
  }


 if ($section eq "edituser")
  {
     check_user();
     print "Content-type: text/html\n\n";
 
    $uusername = $q->param('user');
	$statement = 'SELECT * FROM perlDesk_users WHERE username = ?'; 

		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute($uusername) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
                  {	
			$template{'username'} =  $ref->{'username'};
			$template{'email'}    =  $ref->{'email'};
			$template{'company'}  =  $ref->{'company'};
			$template{'url'}      =  $ref->{'url'};
			$template{'name'}     =  $ref->{'name'};
                        $userid               =  $ref->{'id'};
                        $template{'id'}       =  $ref->{'id'};
	          }

        #~~
        # Get Extra Signup Fields
        #~~

          my $statement = 'SELECT * FROM perlDesk_signup_fields ORDER BY dorder'; 
          my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
             $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
      while(my $ref = $sth->fetchrow_hashref()) 
        {	
            my $tatement = qq|SELECT * FROM perlDesk_signup_values WHERE cid = "$userid" AND sid = "$ref->{'id'}"|; 
            my $th = $dbh->prepare($tatement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
               $th->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
                 while(my $ef = $th->fetchrow_hashref()) 
                   {	                     
                        my $value = $ef->{'value'}; 
                           $value = '&nbsp;' if !$value;

                        $template{'fields'} .= qq|
                                                    <tr><td width="12%" height="18">&nbsp;</td> <td width="24%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'name'}</font></td>
                                                    <td width="64%"><input type="text"  class="gbox" name="ef_$ef->{'id'}" value="$value" size="30"> </td></tr>
                                                 |;    
                   } $template{'fields'} = "" if !$th->rows;
  
        }
       $sth->finish;

   $template{'staff'}        =   $staff;

   my $output = parse("$global{'data'}/include/tpl/admin/edituser");
   print $output;

  }


if ($section eq "savedd")
 {
     check_user();
     print "Content-type: text/html\n\n";

	my $department = $q->param('adddepartment');
		my $rv = $dbh->do(qq{INSERT INTO perlDesk_departments values (
			"$department")}
		);


		print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=admin.cgi?do=departments"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank you</b>, you are now being re-directed.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=departments">click 
					here</a> if you are not automatically forwarded</font></p></html>
                        |;
 }


if ($section eq "upform")
 {
     check_user();
     print "Content-type: text/html\n\n";

     $form_id = $q->param('id');
     $name    = $q->param('field');
     $order   = $q->param('order');

       if (!$name) 
        {
           $dbh->do(qq~DELETE FROM perlDesk_ticket_fields WHERE id = "$form_id"~);
        } 
       else {
              $dbh->do(qq|UPDATE perlDesk_ticket_fields SET name = "$name", dorder = "$order" WHERE id = "$form_id"|);
            }
       
     my $status = "deleted" if !$name;
        $status = "updated" if  $name;
   
     $template{'response'} = qq|<font face="Verdana" size="2">Ticket Field <b>$form_id</b> has been $status|;
     print parse("$global{'data'}/include/tpl/admin/general");
}


if ($section eq "adform")
 {
     check_user();
     print "Content-type: text/html\n\n";

     my $name  = $q->param('field');
     my $order = $q->param('order');

     my $value = '{name}'  if  $name eq "name";
        $value = '{email}' if  $name eq "email";
        $value = '{url}'   if  $name eq "url";
        $value = ''        if !$value;

     $dbh->do(qq~INSERT INTO perlDesk_ticket_fields VALUES ( "NULL", "$name", "$value", "$order" )~);

     $template{'response'} = qq|<font face="Verdana" size="2">Ticket Field <b>$name</b> has been saved|;
     print parse("$global{'data'}/include/tpl/admin/general");

 }






if ($section eq "departments")
 {

     check_user();
     print "Content-type: text/html\n\n";

	$statement = 'SELECT * FROM perlDesk_departments'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
		{	
		$link = "$ref->{'level'}";

		chomp($link);

		$link =~ s/ /_/g;
		
 		$list .= '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="2%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></td>
    				<td width="28%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Edit Department</font></td>
    				<td width="36%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>' . "$ref->{'level'}" . '</b></font></td><td width="34%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">[ 
      				<a href="admin.cgi?do=editdep&cat=' . "$link" . '">EDIT</a> | <a href="admin.cgi?do=removedep&cat=' . "$link" . '">DELETE</a> ] </font></td></tr></table>';
		}
	$sth->finish;


    $template{'departments'}  =   $list;
    my $output = parse("$global{'data'}/include/tpl/admin/departments");
    print $output;
}




 if ($section eq "editdep")
  {

     check_user();
     print "Content-type: text/html\n\n";

    $category = $q->param('cat');
  	 chomp($category);

    $category =~ s/_/ /g;

	$content = '<table width="100%" border="0"><tr><td></td></tr><tr><td>&nbsp;</td></tr><tr><td bgcolor="#C4C1DB"><p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>ADMINISTRATION: 
    		    EDIT DEPARTMENTS</b></font></p></td></tr><tr><td height="36" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">
      		    <tr><td colspan="3"><div align="center"></div></td></tr><tr><td colspan="3"><form name="form1" method="post" action="admin.cgi"><table width="100%" border="0" cellspacing="1" cellpadding="0">
                <tr> <td width="4%">&nbsp;</td><td width="28%">&nbsp;</td><td colspan="2" width="68%">&nbsp;</td>
                </tr><tr><td colspan="4"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <input type="hidden" name="old" value="' . "$category" . '">Edit</font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> <input type=hidden name=do value=savedep>
                Department <input type="text" name="department" size="30" value="' . "$category" . '"><input type="submit" name="Submit" value="Submit"></font></div></td></tr><tr><td colspan="4">&nbsp;</td></tr></table></form></td></tr></table><table width="100%" border="0" cellspacing="1" cellpadding="0"><tr><td></td></tr></table></td></tr></table>';
	
    $template{'response'}  =   $content;
    my $output = parse("$global{'data'}/include/tpl/admin/general");

    print $output;

  }


if ($section eq "savedep")
 {

     check_user();
     print "Content-type: text/html\n\n";

		$department = $q->param('department');
		$old = $q->param('old');

		$statementd = 'UPDATE perlDesk_departments SET level = "' . "$department" . '" WHERE  level = "' . "$old" . '";'; 
		$sth = $dbh->prepare($statementd) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	$sth->finish;

		$statementd = 'UPDATE perlDesk_calls SET category = "' . "$department" . '" WHERE  category = "' . "$old" . '";'; 
		$sth = $dbh->prepare($statementd) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	$sth->finish;


		print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=admin.cgi?do=departments"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank you</b>, you are now being re-directed.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=departments">click 
					here</a> if you are not automatically forwarded</font></p></html>
                        |;
 }
 



 if ($section eq "removedep")
 {
   
     check_user();
     print "Content-type: text/html\n\n";    

        $category =  $q->param('cat');
		$link     =  $category;
    	$category =~ s/_/ /g;
		$response = 'Are you sure you want to remove this department? Doing so will affect all techs which have access to this area. Please alter the staff profile for those techs in this area before clicking below. <br><br><a href="admin.cgi?do=rdep&cat=' . "$link" . '">Yes, Delete</a>';

    $template{'response'}  =   $response;
    my $output = parse("$global{'data'}/include/tpl/admin/general");

    print $output;

 }


 if ($section eq "rdep")
  {

     check_user();
     print "Content-type: text/html\n\n";    
      
        $category   =   $q->param('cat');
    	$category   =~  s/_/ /g;
		$statementd =  'DELETE FROM perlDesk_departments WHERE level = ?'; 
		$sth = $dbh->prepare($statementd) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
		$sth->execute($category) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	$sth->finish;


		print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=admin.cgi?do=departments"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank you</b>, you are now being re-directed.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=departments">click 
					here</a> if you are not automatically forwarded</font></p></html>
                        |;

  }



 if ($section eq "saveeuser")
  {
     check_user();
     print "Content-type: text/html\n\n";
 
        $user    =  $q->param('uname');
	$name    =  $q->param('name');
	$email   =  $q->param('email');
	$url     =  $q->param('url');
	$company =  $q->param('company');
        $pass1   =  $q->param('pass1');
        $pass2   =  $q->param('pass2'); 
        $userid  =  $q->param('id');
    
  
     if ($pass1 && $pass2)
      {
    	   my @chars    =  (A..Z);
              $salt     =  $chars[rand(@chars)] . $chars[rand(@chars)];
    	      $password =   crypt($pass1, $salt);	
    
              $dbh->do(qq|UPDATE perlDesk_users SET password ="$password", rkey = "$salt" WHERE username = "$user"|); 
     }


	 $statemente = qq|SELECT * FROM perlDesk_signup_values WHERE cid = "$userid"|; 
	 $sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
           while(my $ref = $sth->fetchrow_hashref())
             {
                my $field = 'ef_' . $ref->{'id'};
                my $value = $q->param($field);
                $dbh->do(qq|UPDATE perlDesk_signup_values SET value = "$value" WHERE id = "$ref->{'id'}"|);
                $template{'ef'} .= qq|<tr><td><font face="Verdana" size="2">$field_name</font></td><td><input type="textbox" name="ef_$ref->{'id'}" class="tbox" size="30" value="$ref->{'value'}"></td></tr>|;
              }

	$statement = 'UPDATE perlDesk_users SET name = "' . "$name" . '", email = "' . "$email" . '", url = "' . "$url" . '", company = "' . "$company" . '" WHERE username = "' . "$user" . '";'; 
	my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";

 
		print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=admin.cgi?do=users"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank you</b>, you are now being re-directed.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=users">click 
					here</a> if you are not automatically forwarded</font></p></html>
                        |;

  }



 if ($section eq "view_blocked")
  {
     
     print "Content-type: text/html\n\n";

         my $type = $q->param('type');

       my $statement = 'SELECT * FROM perlDesk_blocked_email WHERE type = ?'; 
       my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
          $sth->execute( $type ) or die print "Couldn't execute statement: $DBI::errstr; stopped";
       while(my $ref = $sth->fetchrow_hashref()) 
        {      
              $template{'list'} .= qq| <option>$ref->{'address'}</option>|;
        }

     print parse("$global{'data'}/include/tpl/admin/view_blocked")
  }

 if ($section eq "remove_blocked")
   {     
        print "Content-type: text/html\n\n";

         my $email = $q->param('email');
         execute_sql(qq|DELETE FROM perlDesk_blocked_email WHERE address = "$email" LIMIT 1|);

     	print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=admin.cgi?do=emailsettings"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank You</b>, you are now being re-directed.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=emailsettings">click 
					here</a> if you are not automatically forwarded</font></p></html>
                |;
  }


if ($section eq "emailsettings")
 {
     check_user();
     print "Content-type: text/html\n\n";


	$sth = $dbh->prepare(qq|SELECT COUNT(*) FROM perlDesk_blocked_email WHERE type = "domain"| ) or die DBI->errstr;
	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
        	 $template{'cdom'} = $sth->fetchrow_array();
	$sth->finish;


	$sth = $dbh->prepare( qq|SELECT COUNT(*) FROM perlDesk_blocked_email WHERE type = "address"| ) or die DBI->errstr;
	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
        	 $template{'cad'}  = $sth->fetchrow_array();
	$sth->finish;


	if (defined $q->param('email')) 
          {
        	my $address = $q->param('email');
	        my $type    = $q->param('type');
          
	        die_nice("You have specified an incoming e-mail address which is also used as the admin email, as external e-mails may be sent to this address it cannot be used. Using it would cause an e-mail loop - please go back and change the incoming e-mail address, or update the admin email in the main settings page") if $address eq $global{'adminemail'};

                if ($address && $type)
                 {
	             my $rv = $dbh->do(qq{INSERT INTO perlDesk_blocked_email values ("NULL", "$address", "$type")});
                 }
  	  }


	if (defined $q->param('address')) {

	my $address = $q->param('address');
	my $categor = $q->param('select');

    if ($categor && $address)
      {
	        $statement = 'SELECT * FROM perlDesk_em_forwarders WHERE address = ?'; 
		$sth = $dbh->prepare($statement) or die print "Couldnt prepare statement: $DBI::errstr; stopped";
 		$sth->execute( $address ) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		die_nice("There is already a staff member using the address $address as a personal contact email address. It is not possible to have staff members using the same email address as an incoming address, this would cause email looping for received tickets") if $sth->rows > 0;


	    	my $rv = $dbh->do(qq{INSERT INTO perlDesk_em_forwarders values (
	      		"$address", "$categor")}
	     	);
      }
	}
	if (defined $q->param('delete')) {
	$address = $q->param('email');
		$statementd = 'DELETE FROM perlDesk_em_forwarders WHERE address = ?'; 
		$sth = $dbh->prepare($statementd) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
		$sth->execute($address) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	$sth->finish;
	}

	
if (defined $q->param('reqreg')) {

	$reqreg = $q->param('reqreg');
	if ($reqreg eq "Yes") { $new = "1"; } else { $new = "0"; }
	$statement = 'UPDATE perlDesk_settings SET value  = ? WHERE setting = "ereqreg"'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
	$sth->execute($new) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	$result = "<br><b><font color=red>Saved</font></b><br>";
	}

	$statement = 'SELECT * FROM perlDesk_em_forwarders'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
		{	
		$link = "$ref->{'address'}";
		chomp($link);
		$link =~ s/ /_/g;
		
 	$option .= '<form action="admin.cgi" method="post"><input type=hidden name=do value=emailsettings><table width="90%" border="0" cellspacing="1" cellpadding="0"><tr> 
    <td height="16" width="42%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b>' . "$ref->{'address'}" . '</b></font></td>
    <td height="16" width="6%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">' . "<img src=$global{'imgbase'}/arrow.gif>" . '</font></td>
    <td height="16" width="32%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b>' . "$ref->{'category'}" . '</b></font></td>
    <td height="16" width="20%"><div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><input type="hidden" name="email" value="' . "$ref->{'address'}" . '"><input type="Submit" style="font-size: 12px" name="delete" value="Delete"></font></div></td></tr></table></form>';

		}
	$sth->finish;


	$statement = 'SELECT * FROM perlDesk_settings WHERE setting = "ereqreg"'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) {	
		if ($ref->{'value'} eq "0") { 
				$selected = '<option value="Yes">Yes</option><option value="No" selected>No</option>';
		 } else { 
                $selected = '<option value="Yes" selected>Yes</option><option value="No">No</option>';
		 }

	}
	$sth->finish;

	$statement = 'SELECT level FROM perlDesk_departments'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) {	
			$menu .= "<option value=\"$ref->{'level'}\">$ref->{'level'}</option>";

	}
	$sth->finish;


	if (!$result) { $result = ''; }


    $template{'directs'}    =   $option || "<font size=2>No Emails Specified</font>";
    $template{'selected'}   =   $selected;
    $template{'categories'} =   $menu;
    $template{'ifresult'}   =   $result;

    my $output = parse("$global{'data'}/include/tpl/admin/email");

    print $output;
}












 if ($section eq "deluser")
  {

     check_user();
     print "Content-type: text/html\n\n";

    $uusername =  $q->param('user');
    $confirm   =  $q->param('confirm');

	if ($confirm eq "yes") 
      {
			$page = "Username $uusername, completely deleted!";
			$statement = 'DELETE FROM perlDesk_users WHERE username = "' . "$uusername" . '"'; 
			my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		       $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	  }  
	    else {
		         $page = '<p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Are you sure you want to delete ' . "$uusername" . '? (Deleting this user will remove all their requests from the help desk.</font></p><p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=deluser&user=' . "$uusername" . '&confirm=yes">Yes, Im sure. Delete ' . "$uusername" . '</a></font></p>';
		     }
   
   $template{'username'} = $uusername;
   $template{'main'}    = $page;
 
   my $output = parse("$global{'data'}/include/tpl/admin/deluser");
   print $output;

  }


 if ($section eq "users")
  {
     check_user();
     print "Content-type: text/html\n\n";
 
     $sth = $dbh->prepare( "SELECT COUNT(*) FROM perlDesk_users" ) or die DBI->errstr;
     $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
         my ( $count ) = $sth->fetchrow_array();
  
 
         $total = $count;

         $limit = "30";  # Results per page
      my $pages = ($total/$limit);
         $pages = ($pages+0.5);
      my $nume  = sprintf("%.0f",$pages);
         $page  = $q->param('page') || "0";
         $nume  = "1" if !$nume;
         $to    = ($limit * $page) if  $page;
         $to    = "0"              if !$page;

     $tpage     =  $page;
     $tpage     =  $tpage + 1;
     $location  =  $page;
     $location  =  $location + 1;
     $lboundary = "1" if $location < 4;
     $lboundary =  $location - 3  if !$lboundary;

     $nav .= qq|<font face=Verdana size=1>$nume Page(s): </font>|;

      if ($location + 2 < $nume) { $tboundary = 3 + $location; } else { $tboundary = $nume; }

      $string =  $ENV{'QUERY_STRING'};
      $string =~ s/&page=(.*)//g;        
      $prev   =  $page;
      $prev   =  $prev - 1;

      if ($nume > 1 && $tpage > 1 ) { $nav .= qq|<font face="verdana" size="1"><a href="admin.cgi?$string&page=0" alt="First Page">&laquo;</a> <a href="admin.cgi?$string&page=$prev" alt="First Page">&#139;</a> </font>|; }   
 
      foreach ($lboundary..$tboundary) 
          {       
             my $nu     =  $_ -1;
                 if ($nu eq $page) { $link = "[<b>$_</b>]"; } else { $link = "$_"; }          
                $nav   .= qq|<font face="verdana" size="1"><a href="admin.cgi?$string&page=$nu">$link</a> </font>|;
          }

      $next = $page;
      $next = $next + 1;
      $last = $nume;
      $last = $last - 1;

      if ($tpage < $nume && $tpage >= 1) { $nav .= qq|<font face="verdana" size="1"><a href="admin.cgi?$string&page=$next" alt="Next Page">&#155;</a> <a href="admin.cgi?$string&page=$last" alt="Next Page">&raquo;</a></font>|; }   


            $template{'nav'} = $nav;
         my $show  = $limit *  $page;

		$statement = 'SELECT * FROM perlDesk_users WHERE username != "admin" LIMIT ' . "$show, $limit"; 
		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		$number=$show;
                $i = 1;
		while(my $ref = $sth->fetchrow_hashref()) {	
           my $user =  $ref->{'username'};
              $user =~ s/ /_/g;

 		 if ($i == "2") 
                   {
      			$bgcol = '#FFFFFF';
    			$i = 0;
     	 	   }
                  else {
			           $bgcol = '#F0F0F0';
             	  	}

        	$users .= qq|<table width="95%" border="0" cellspacing="1" cellpadding="5" align="center"> <tr bgcolor="$bgcol"><td width="22%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=viewuser&user=$user">$ref->{'username'}</a></font></td><td width="33%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'name'}</font></td><td width="45%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="mailto:$ref->{'email'}">$ref->{'email'}</a></font></td></tr></table>|;
		$number++;			
                $i++
	}

   $template{'navbar'}    =   $bar;
   $template{'userlist'}  =   $users;

  my $too = $number;

  $template{'from'}  = $show;
  $template{'to'}    = $too;
  $template{'total'} = $count;

   my $output = parse("$global{'data'}/include/tpl/admin/userlist");
   print $output;

  }



#~~
# Search Clients (Results)
#~~

 if ($section eq "search_clients")
  {
     check_user();
     print "Content-type: text/html\n\n";

       my $query = $q->param('query'); 
       my $cat   = $q->param('area');

     $sth = $dbh->prepare( qq|SELECT COUNT(*) FROM perlDesk_users WHERE $cat = "$query"| ) or die DBI->errstr;
     $sth->execute() or die "Couldn't execute statement: $DBI::errstr; stopped";
         my ( $count ) = $sth->fetchrow_array();
   
         $total = $count;

         $limit = "30";  # Results per page
      my $pages = ($total/$limit);
         $pages = ($pages+0.5);
      my $nume  = sprintf("%.0f",$pages);
         $page  = $q->param('page') || "0";
         $nume  = "1" if !$nume;
         $to    = ($limit * $page) if  $page;
         $to    = "0"              if !$page;

     $tpage     =  $page;
     $tpage     =  $tpage + 1;
     $location  =  $page;
     $location  =  $location + 1;
     $lboundary = "1" if $location < 4;
     $lboundary =  $location - 3  if !$lboundary;

     $nav .= qq|<font face=Verdana size=1>$nume Page(s): </font>|;

      if ($location + 2 < $nume) { $tboundary = 3 + $location; } else { $tboundary = $nume; }

      $string =  $ENV{'QUERY_STRING'};
      $string =~ s/&page=(.*)//g;        
      $prev   =  $page;
      $prev   =  $prev - 1;

      if ($nume > 1 && $tpage > 1 ) { $nav .= qq|<font face="verdana" size="1"><a href="admin.cgi?$string&page=0" alt="First Page">&laquo;</a> <a href="admin.cgi?$string&page=$prev" alt="First Page">&#139;</a> </font>|; }   
 
      foreach ($lboundary..$tboundary) 
          {       
             my $nu     =  $_ -1;
                 if ($nu eq $page) { $link = "[<b>$_</b>]"; } else { $link = "$_"; }          
                $nav   .= qq|<font face="verdana" size="1"><a href="admin.cgi?$string&page=$nu">$link</a> </font>|;
          }

      $next = $page;
      $next = $next + 1;
      $last = $nume;
      $last = $last - 1;

      if ($tpage < $nume && $tpage >= 1) { $nav .= qq|<font face="verdana" size="1"><a href="admin.cgi?$string&page=$next" alt="Next Page">&#155;</a> <a href="admin.cgi?$string&page=$last" alt="Next Page">&raquo;</a></font>|; }   


            $template{'nav'} = $nav;
         my $show  = $limit *  $page;

     
		$statement = qq|SELECT id,username,name,email FROM perlDesk_users WHERE $cat = "$query" LIMIT $show, $limit|; 
		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		$number=$show;
                $i = 1;
		while(my $ref = $sth->fetchrow_hashref()) {	
 
                 my $user =  $ref->{'username'};
                    $user =~ s/ /_/g;

   		 if ($i == "2") 
                   {
      			$bgcol = '#FFFFFF';
    			$i = 0;
     	 	   }
                  else {   $bgcol = '#F0F0F0';	}

        	$users .= qq|<table width="95%" border="0" cellspacing="1" cellpadding="5" align="center"> <tr bgcolor="$bgcol"><td width="22%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=viewuser&user=$user">$ref->{'username'}</a></font></td><td width="33%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'name'}</font></td><td width="45%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="mailto:$ref->{'email'}">$ref->{'email'}</a></font></td></tr></table>|;
		$number++;			
                $i++
	}

   $template{'navbar'}    =   $bar;
   $template{'userlist'}  =   $users;

  my $too = $number;

  $template{'from'}  = $show;
  $template{'to'}    = $too;
  $template{'total'} = $count;

   my $output = parse("$global{'data'}/include/tpl/admin/userlist");
   print $output;
  }


#~~
# EXPORT USERS
#~~

 if ($section eq "exportusers")
  {
    check_user();
    print "Content-type: text/html\n\n";
       my $output = parse("$global{'data'}/include/tpl/admin/export_users");
       print $output;
  }


 if ($section eq "start_export")
  {
     check_user();
    
     print 'Content-Disposition: attachment; filename="perldesk-users.txt"' . "\n";
     print "Content-Type: application/octet-stream\n\n";

     $delimeter =  $q->param('delimeter');
     $filter    =  $q->param('filter');

     print "ID" . $delimeter . "Name" . $delimeter . "Username" . $delimeter . "Email" . $delimeter . "URL\015\012";

     $statement = 'SELECT * FROM perlDesk_users';
     $sth       =  $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
     $sth->execute(  ) or die print "Couldn't execute statement: $DBI::errstr; stopped"; 
	  while(my $ref = $sth->fetchrow_hashref()) 
		{ 
                    print $ref->{'id'} . $delimeter . $ref->{'name'} . $delimeter . $ref->{'username'} . $delimeter . $ref->{'email'} . $delimeter . $ref->{'url'};
                    print qq~\015\012~;
                }
  }

#~~

 if ($section eq "staffactive")
  {
     check_user();
     print "Content-type: text/html\n\n";
 
    	$statement = 'SELECT * FROM perlDesk_staff WHERE username != "admin" ORDER BY callsclosed DESC LIMIT 10'; 
		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
			while(my $ref = $sth->fetchrow_hashref()) {	
				
				$staff .= '<table width="75%" border="0" cellspacing="1" cellpadding="3" align="center"><tr bgcolor="#F0F0F0"> 
                  <td width="42%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">' . "$ref->{'name'}" . '</font></td>
                  <td colspan="2" bgcolor="#F0F0F0" width="58%"><div align="right"></div><div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b>' . "$ref->{'callsclosed'}" . '</b> 
                  REQUESTS CLOSED</font></div></td></tr></table>';
				
			}

    $template{'navbar'}    = '';
    $template{'stafflist'} = $staff;

     my $output = parse("$global{'data'}/include/tpl/admin/staff");
     print $output;

  }



 if ($section eq "staff")
 {
     check_user();
     print "Content-type: text/html\n\n";

      my $online = $q->param('online');

      if (!$online)
       {
                $sth = $dbh->prepare( qq|SELECT COUNT(*) FROM perlDesk_staff WHERE username != "admin"| ) or die DBI->errstr;
		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		     ( $count ) = $sth->fetchrow_array();
         	if (!$ENV{'QUERY_STRING'}) { $pae = 0; }
                $template{'total'} = $count;
       }
          else {
                  $template{'total'} = "Online "; 
               }

	$showp = $pae*30;
        $i = 1;

         	$statement = 'SELECT * FROM perlDesk_staff WHERE username != "admin"'; 
		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) {	


	        $statement = 'SELECT * FROM perlDesk_staffactive WHERE username = ?'; 
		$sthb = $dbh->prepare($statement) or die print "Couldnt prepare statement: $DBI::errstr; stopped";
 		$sthb->execute($ref->{'username'}) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $refb = $sthb->fetchrow_hashref()) 
                  {	
				$time_last_active = $refb->{'date'};
		  }

	       $current_time = time();
	       $newtime =	$time_last_active + 900;

    		if ($newtime > $current_time) 
                    {
			        # Staff Member is online
                                $ostatus = 1;
			     	$status  = "<img src=\"$global{'imgbase'}/online.gif\" width=\"6\" height=\"6\">";
		    } else {
		                 # Staff Member is offline
                                $ostatus = 0;
		               	$status  = "<img src=\"$global{'imgbase'}/offline.gif\" width=\"6\" height=\"6\">";
		           }

                  if ($online && !$ostatus)
                        { next; }

 		 if ($i == "2") 
                   {
      			 $bgcol = '#FFFFFF';
    		  	 $i = 0;
     	 	   }
                  else {
			 $bgcol = '#F0F0F0';
             	       }


              #~~ 
              # Work Out Rating
              #~~

                $statement = qq|SELECT SUM(rating) FROM perlDesk_reviews WHERE staff = "$ref->{'id'}"|;
    	        $th       =  $dbh->prepare($statement) or die DBI->errstr;
   	        $th->execute( ) or die "Couldn't execute statement: $DBI::errstr; stopped";
                     $total_rating = $th->fetchrow_array(); 
                $th->finish;
 
                if ($total_rating)
                 {
                   $template{'rating'} = "";
                   $statement = qq|SELECT rating FROM perlDesk_reviews WHERE staff = "$ref->{'id'}"|;
                   $th       =  $dbh->prepare($statement) or die DBI->errstr;
   	           $th->execute( ) or die "Couldn't execute statement: $DBI::errstr; stopped";
                      my $total_reviews = $th->rows(); 
                   $th->finish;

                    my $crating  = $total_rating/$total_reviews;
                       $crating  = sprintf("%.0f", $crating);
                       $sc       = $crating;
                       $sc       = $sc+1;

                       # 4

                    for(1..$crating)
                     {
                         $template{'rating'} .= qq|<img src=$global{'imgbase'}/star_filled.gif>|;   
                     }
                    for ($sc..5)
                     {
                         $template{'rating'} .= qq|<img src=$global{'imgbase'}/star_empty.gif>|;   
                     }

                 } else {$template{'rating'} = "No Rating"; }


                        	$staff .= qq|<table width="90%" border="0" cellspacing="1" cellpadding="3" align="center"><tr bgcolor="$bgcol"><td width="4%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><div align="center">$status</div></font></td><td width="30%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'name'}</font></td><td width="30%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'email'}</font></td><td width="15%">
                                <a href="admin.cgi?do=editstaff&user=$ref->{'username'}"></a></font><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr> <td width="33%"><a href="admin.cgi?do=editstaff&user=$ref->{'username'}"><img src="$global{'imgbase'}/profileb.gif" width="16" border="0" height="16"></a></td>	<td width="33%"><a href="admin.cgi?do=staffcalls&user=$ref->{'username'}"><img src="$global{'imgbase'}/answered.gif" width="14" border="0" height="10"></a></td>
				<td width="33%"><a href="admin.cgi?do=staffperf&user=$ref->{'username'}"><img src="$global{'imgbase'}/perf.gif" width="15" border="0" height="15"></a></td></tr></table></td><td width="21%"><font size=1>$template{'rating'}</font></td></tr></table>|;
                      $i++;
 
	}

 
    $staff .= "<br><br><font size=1><img src=\"$global{'imgbase'}/online.gif\" width=\"7\" height=\"7\"> Currently Active <img src=\"$global{'imgbase'}/offline.gif\" width=\"7\" height=\"7\"> Currently Inactive";

   $template{'navbar'}    = $bar;
   $template{'stafflist'} = $staff;

   print parse("$global{'data'}/include/tpl/admin/staff");
 }


 if ($section eq "addstaff")
  {

     check_user();
     print "Content-type: text/html\n\n";

  	$statement = 'SELECT level FROM perlDesk_departments'; 
		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
		{
				if ($accesslevel =~ /$ref->{'level'}::/) 
                  {	
				        	$list .= "<input type=\"checkbox\" name=\"$ref->{'level'}\" value=\"yes\" checked> $ref->{'level'}<br>";
				  } else {
				         	$list .= "<input type=\"checkbox\" name=\"$ref->{'level'}\" value=\"yes\"> $ref->{'level'}<br>";
				         }
		push @list, $option;
		}

     if ($accesslevel =~ /GLOB::/) 
        {	
                   $list .= "<input type=\"checkbox\" name=\"glob\" value=\"yes\" checked> <b>Global Access</b>";
        } else {
                   $list .= "<input type=\"checkbox\" name=\"glob\" value=\"yes\"> <b>Global Access</b>";
               }
  
   $template{'category'}    = $list;
   my $output = parse("$global{'data'}/include/tpl/admin/addstaff");
   print $output;
 }


#~~
# PM


if ($section eq "pm")
 {
       check_user(); 
       print "Content-type: text/html\n\n";

       $too = $q->param('to');

    #~~
    # Reply To a PM

    if ($too eq "reply")
     {  
        $msg = $q->param('id');
        $statemente = 'SELECT * FROM perlDesk_messages WHERE id = ?'; 
	$sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
        $sth->execute($msg) or die print "Couldn't execute statement: $DBI::errstr; stopped";
          while(my $ref = $sth->fetchrow_hashref())
           {
	        $from    =  $ref->{'sender'};
		$subject =  $ref->{'subject'};    
           }

	open (IN, "$global{'data'}/include/tpl/admin/msgreply.tpl") ||
   			                                        	 die "Unable to open: $!";
	while (<IN>) {
			if ($_ =~ /\{*\}/i) 
                          {
				s/\{username\}/admin/i;	
				s/\{touser\}/$from/ig;				
			  }
		  print $_;
		} 		
	close (IN);
   }


 #~~
 # Remove a Message 
 #~~


 if ($too eq "delete")
   {
      $msg        =  $q->param('id');
      $statemente =  'SELECT * FROM perlDesk_messages WHERE id = "' . "$msg" . '"'; 
      $sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
      $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
        while(my $ref = $sth->fetchrow_hashref()) 
           {
		if ($ref->{'touser'} ne "admin") { print 'This is not your message to delete'; exit; } 
	   }

       execute_sql(qq|DELETE FROM perlDesk_messages WHERE id = "$msg"|); 

      $statemente = "SELECT * FROM perlDesk_messages WHERE touser = \"admin\" ORDER BY id DESC"; 
      $sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
      $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
      while(my $ref = $sth->fetchrow_hashref())
         {
		$message = '<tr bgcolor="#F1F1F8"><td width="7%"><font face="Verdana" size="1">' . "$ref->{'id'}" . '</font></td> <td width="26%"><font face="Verdana" size="1">' . "$ref->{'sender'}" . '</font></td>
                            <td width="28%"><font face="Verdana" size="1">' . "$ref->{'date'}" . '</font></td><td width="39%"><font face="Verdana" size="1">' . "<a href=\"admin.cgi?do=pm&action=view&id=$ref->{'id'}\">$ref->{'subject'}</font></a>" . '</td></tr>';

		push @messages, $message;
         }


	open (IN, "$global{'data'}/include/tpl/admin/inbox.tpl") ||
				 die "Unable to open: $!";
	while (<IN>) {
			 if ($_ =~ /\{*\}/i) {	s/\{messages\}/@messages/i;	}
    	 	         print $_;
		     }   		

	$dbh->disconnect;
        exit;
     }

  #~~
  # Message Inbox
  #~~

  if ($too eq "inbox")
   {
      $statemente = "SELECT * FROM perlDesk_messages WHERE touser = \"admin\" ORDER BY id DESC"; 
      $sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
      $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
        while(my $ref = $sth->fetchrow_hashref()) 
          {
			$message = '<tr bgcolor="#F1F1F8"><td width="7%"><font face="Verdana" size="1">' . "$ref->{'id'}" . '</font></td> <td width="26%"><font face="Verdana" size="1">' . "$ref->{'sender'}" . '</font></td>
                                    <td width="28%"><font face="Verdana" size="1">' . "$ref->{'date'}" . '</font></td><td width="39%"><font face="Verdana" size="1">' . "<a href=\"admin.cgi?do=pm&to=view&id=$ref->{'id'}\">$ref->{'subject'}</font></a>" . '</td></tr>';
			push @messages, $message;
          }

	$current_time = time();
     
	open (IN, "$global{'data'}/include/tpl/admin/inbox.tpl") || die "Unable to open: $!";
	  while (<IN>) {
			   if ($_ =~ /\{*\}/i) {  s/\{messages\}/@messages/i;  }
	           	   print $_;
		       }  		
	close (IN);
    }


 #~~
 # View Message
 #~~

 if ($too eq "view") 
  {

    $msg        = $q->param('id');
    $statemente = qq|SELECT * FROM perlDesk_messages WHERE id = "$msg" AND touser = "admin"|; 
    $sth        = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
    $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
      while(my $ref = $sth->fetchrow_hashref()) 
        {
            $from    =  $ref->{'sender'};
 	    $to      =  $ref->{'touser'};
	    $date    =  $ref->{'date'};
            $subject =  $ref->{'subject'};
            $message =  $ref->{'message'};          
        }

	if ($sth->rows == "0") { print 'This is not your message'; exit; }

       open (IN, "$global{'data'}/include/tpl/admin/msgview.tpl") ||
				 die "Unable to open: $!";
	while (<IN>) {
			if ($_ =~ /\{*\}/i) {
				s/\{subject\}/$subject/i;	
				s/\{from\}/$from/i;
				s/\{sent\}/$date/i;	
				s/\{id\}/$msg/ig;	
				s/\{message\}/$message/i;					
			}
		print $_;
		} 		
	close (IN);
	$dbh->disconnect;
        exit; 
   }

 #~~
 # Compose Message
 #~~

 if ($too eq "compose") 
  {
      $statemente = 'SELECT username FROM perlDesk_staff WHERE username != "admin"'; 
      $sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
      $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
         while(my $ref = $sth->fetchrow_hashref())
            {
			$ddopt = "<option value=\"$ref->{'username'}\">$ref->{'username'}</option>";
			push @dd, $ddopt;
  	    }

	if (not @dd) { @dd = '<option value="">No Other Users</option>'; }

	open (IN, "$global{'data'}/include/tpl/admin/msgcompose.tpl") ||
				 die "Unable to open: $!";
	while (<IN>) {
			if ($_ =~ /\{*\}/i)
                            {
				s/\{ddlist\}/@dd/i;	
				s/\{username\}/admin/i;				
			    }
		        print $_;
		} 		
	close (IN);
 }

 #~~
 # Save Message
 #~~

 if ($too eq "savenote") 
  {
    $from    =  $Cookies{'staff'};
    $to      =  $q->param('user');
    $subject =  $q->param('subject');
    $message =  $q->param('message');

    $statemente = 'SELECT * FROM perlDesk_staff WHERE username = "' . "$to" . '"'; 
    $sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
    $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";

	if ($sth->rows == "0") 
          {
		print "<div align=\"center\"><font face=\"Verdana\" size=\"2\"><br><b>Sorry,</b> user does not exist on this system <a href=\"javascript:history.back(1)\">Back</a></div>";
     	        $dbh->disconnect;	
      	        exit;
  	  }

	$current_time =   time();
	$message      =~  s/\"/\\"/g;

       die_nice("No Subject Specified") if !$subject;

      my $rv = $dbh->do(qq{INSERT INTO perlDesk_messages values (
         	"NULL", "$to", "admin", "$hdtime", "$subject", "$message", "$current_time")}
	);

	print "<div align=\"center\"><font face=\"Verdana\" size=\"2\"><br>Message has been sent to \'$to\' - Back to <a href=\"admin.cgi?do=pm&to=inbox\">Inbox</a></font></div>";

	$dbh->disconnect;	
       exit;
    }
}

#~~


 if ($section eq "savestaff")
  {


     check_user();
 
	$pass1    =   $q->param('pass1');
	$pass2    =   $q->param('pass2');
	$notinfy  =   $q->param('notify');
	$username =   $q->param('username');
	$name     =   $q->param('name');
	$email    =   $q->param('email');

	$statement = 'SELECT level FROM perlDesk_departments'; 
		$sth = $dbh->prepare($statement) or die print "Couldnt prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
		{
	             if ($q->param($ref->{'level'}) eq "yes") {  $add = "$ref->{'level'}::"; push @area,$add;  }
		}


	        $statement = 'SELECT * FROM perlDesk_em_forwarders WHERE address = ?'; 
		$sth = $dbh->prepare($statement) or die print "Couldnt prepare statement: $DBI::errstr; stopped";
 		$sth->execute( $email ) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		die_nice("It is not possible to have staff members using the same email address as an incoming address, this would cause email looping for received tickets") if $sth->rows > 0;


    if ($q->param('glob') eq "yes") {  $add = "GLOB::"; push @area,$add;  }
	
	die print "Passwords do not match" if $pass1 ne $pass2;

	if ($notinfy eq "yes") 	{	$notify = 1;	}
	else 	{		$notify = 0;	}

	my @chars = ("a..z","A..Z","0..9",'.','/');
	my $salt  = $chars[rand(@chars)] . $chars[rand(@chars)];

	$cdpass = crypt($pass1, $salt);

	execute_sql(qq{INSERT INTO perlDesk_staff values ("", "$username", "$cdpass", "$name", "$email", "@area", "$notify", "0", "0", "", "$salt", "", "0", "Never")});
	execute_sql(qq{INSERT INTO perlDesk_stafflogin values ("$username", "Never")});
	execute_sql(qq{INSERT INTO perlDesk_staffactive values ("$username", "0")});
	execute_sql(qq{INSERT INTO perlDesk_staffread values ("$username", "0")});

       print "Content-type: text/html\n\n";

		print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=admin.cgi?do=staff"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank you</b>, this staff member has been created.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=staff">click 
					here</a> if you are not automatically forwarded</font></p></html>
                        |;
 }




 if ($section eq "staffperf")
  {
     check_user();
     print "Content-type: text/html\n\n";

    $user = $q->param('user');

    $template{'name'} = $user;

	$statemente = 'SELECT * FROM perlDesk_stafflogin WHERE username = ?'; 
		$sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute($user) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	while(my $ref = $sth->fetchrow_hashref()) 
	{	
		$lastlogin = $ref->{'date'};
	}
	$sth->finish;

	$statement = 'SELECT * FROM perlDesk_staff WHERE username = ?'; 
		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute($user) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	while(my $ref = $sth->fetchrow_hashref()) 
	{	
    	$statement = 'SELECT * FROM perlDesk_staffactive WHERE username = ?'; 
		$sth2  = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth2->execute($ref->{'username'}) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		  while(my $ref2 = $sth2->fetchrow_hashref()) 
             {	
				$time_last_active = $ref2->{'date'};
             }
	$sth2->finish;

	 $current_time = time();
	 $newtime      = $time_last_active + 900;

 		if ($newtime > $current_time) 
             { 
                       # Staff Member is offline
			           $status = "<font color=green><b>ONLINE / ACTIVE</b></font>";
		     } else {
              	       # Staff Member is online
				       $status = "<font color=red><b>OFFLINE / INACTIVE</b></font>";
		     }

	$sth = $dbh->prepare('SELECT COUNT(*) FROM perlDesk_calls WHERE closedby = ?' ) or die DBI->errstr;
	$sth->execute($ref->{'username'}) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	 $closed = $sth->fetchrow_array();
	$sth->finish;

	$tsec = $ref->{'responsetime'};

 if ($closed > 0) {
 
     $sec = ($tsec/$closed);	
     $days    = int($sec/(24*60*60));
     $hours   = ($sec/(60*60))%24;
     $mins    = ($sec/60)%60;
     $secs    = $sec%60;
     $restime = "$hours hr(s) $mins min(s) $secs seconds";
 
 } else {
           $restime = "No calls closed";
        }

   $template{'name'}        = $ref->{'name'};
   $template{'lastlogin'}   = $lastlogin;
   $template{'status'}      = $status;
   $template{'callsclosed'} = $closed;
   $template{'avgtime'}     = $restime;

   my $output = parse("$global{'data'}/include/tpl/admin/staffperf");
   print $output;
}
  }



 if ($section eq "sendstaff")
  {

     check_user();
     print "Content-type: text/html\n\n";

	$email   = $q->param('email');
	$subject = $q->param('subject');
	$message = $q->param('message'); 

	$statement = 'SELECT * FROM perlDesk_staff'; 
		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	while(my $ref = $sth->fetchrow_hashref()) 
	 {	
            if ($enablemail) {
                                   email( To => "$ref->{'email'}", From => "$email", Subject => "$subject", Body => "$message" );                      
                             }
	 }

		print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=admin.cgi?do=staff"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank you</b>, you are now being re-directed.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=staff">click 
					here</a> if you are not automatically forwarded</font></p></html>
                        |;


  }


 
 if ($section eq "editstaff")
  {

     check_user();
     print "Content-type: text/html\n\n";

    my $user = $q->param('user');

	$statement = 'SELECT * FROM perlDesk_staff WHERE username = ?'; 
		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute($user) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
		{
			$sname     =  $ref->{'name'};
			$suser     =  $ref->{'username'};
			$semail    =  $ref->{'email'};
			$notif     =  $ref->{'notify'};
			$assigned  =  $ref->{'access'};
		}

	$statement = 'SELECT * FROM perlDesk_preans WHERE author = ?'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute($suser) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	   while(my $ref = $sth->fetchrow_hashref()) 
            {
	        $template{'preans'} .= ' <option value="admin.cgi?do=editpre&value=' . "$ref->{'id'}" . '">' . "$ref->{'subject'}" . '</option>';
            } $template{'preans'} = "" if $sth->rows == "0"; 

	$statement = 'SELECT level FROM perlDesk_departments'; 
		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
  		  {
				if ($assigned =~ /$ref->{'level'}::/) 
                  {	
			          		$list .= "<input type=\"checkbox\" name=\"$ref->{'level'}\" value=\"yes\" checked> $ref->{'level'}<br>";
			      } else {
			         		$list .= "<input type=\"checkbox\" name=\"$ref->{'level'}\" value=\"yes\"> $ref->{'level'}<br>";
			             }
		 }

       if ($assigned =~ /GLOB::/) 
             {	
                            $list .= "<input type=\"checkbox\" name=\"glob\" value=\"yes\" checked> <b>Global Access</b>";
             } else {
                            $list .= "<input type=\"checkbox\" name=\"glob\" value=\"yes\"> <b>Global Access</b>";
                    }


       if ($notif eq "1") 	
           {
                           $box ='<input type="checkbox" name="notify" value="yes" checked>';
           } else {
                           $box = '<input type="checkbox" name="notify" value="yes">';
                  }

   $template{'notify'}    = $box;
   $template{'sname'}      = $sname;
   $template{'user'}      = $suser;
   $template{'semail'}     = $semail;
   $template{'category'}  = $list;

   print parse("$global{'data'}/include/tpl/admin/editstaff");
  
  }


 #~~
 # Edit a Staff users pre-defined response 
 #~~


if ($section eq "editpre") {

 check_user();
 print "Content-type: text/html\n\n";

  $id = $q->param('value');
 
 	$statemente = 'SELECT * FROM perlDesk_preans WHERE id = ?'; 
	$sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 			$sth->execute( $id ) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		      while(my $ref = $sth->fetchrow_hashref()) {
					$template{'subject'} = $ref->{'subject'};
					$template{'content'} = $ref->{'text'};
 			  }
   
    $template{'id'}      = $id;
   
   my $output = parse("$global{'data'}/include/tpl/admin/editpre");
   print $output;
 }


if ($section eq "editsave")
  {
     check_user();
     print "Content-type: text/html\n\n";
     
        $id      =  $q->param('id');
        $subject =  $q->param('subject');
        $text    =  $q->param('content'); 

        execute_sql(qq|UPDATE perlDesk_preans SET subject = "$subject", `text` = "$text" WHERE id = "$id"|);

		print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=admin.cgi?do=editpre&value=$id"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Template Saved</b></font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=editpre&value=$id">click 
					here</a> if you are not automatically forwarded</font></p></html>
                        |;

  }

if ($section eq "del_pre")
  {
     check_user();
     print "Content-type: text/html\n\n";
     
        $id      =  $q->param('id');

        execute_sql(qq|DELETE FROM perlDesk_preans WHERE id = "$id"|);

         $template{'response'} = qq|Thank you, template deleted|;
    my $output = parse("$global{'data'}/include/tpl/admin/general");
    print $output;
  }


#~~

 if ($section eq "saveeditstaff")
  {
     check_user();
     print "Content-type: text/html\n\n";

    $user     =  $q->param('user');
    $notinput =  $q->param('notify');

	if ($notinput eq "yes") {   $notify = 1;}  
             else 	{ 
                       		$notify = 0;
                       	}

	$name  = $q->param('name');
	$email = $q->param('email'); 
        $pass1 = $q->param('pass1');
        $pass2 = $q->param('pass2');
  
      if ($pass1 eq $pass2 && $pass1 ne "")
       {
   	  my @chars=(A..Z);
	  my $salt= $chars[rand(@chars)] . $chars[rand(@chars)];
	  my $password = crypt($pass1, $salt);	
	
	     execute_sql(qq|UPDATE perlDesk_staff SET password = "$password", rkey = "$salt" WHERE username = "$user"|); 
       }
  

    my (@area);

	$statement = 'SELECT level FROM perlDesk_departments'; 
		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
		{
	       if ($q->param($ref->{'level'}) eq "yes") {  $add = "$ref->{'level'}::"; push @area,$add;  }
		}

    if ($q->param('glob') eq "yes") {  $add = "GLOB::"; push @area,$add;  }

        $dbh->do(qq|UPDATE perlDesk_staff SET name = "$name", email = "$email", notify = "$notify", access = "@area" WHERE username = "$user"|);	

		print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=admin.cgi?do=staff"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank you</b>, you are now being re-directed.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=staff">click 
					here</a> if you are not automatically forwarded</font></p></html>
                        |;


  }
 

 if ($section eq "delstaff")
  {

     check_user();
     print "Content-type: text/html\n\n";

    my $user = $q->param('user');

    $response = '<p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Are you sure you want to delete ' . "$user" . '? (Deleting this member of staff will remove them completely from the help desk.</font></p><p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=cdel&user=' . "$user" . '">Yes, Im sure. Delete ' . "$user" . '</a></font></p>';
    $template{'response'}  = $response;
    my $output = parse("$global{'data'}/include/tpl/admin/general");
    print $output;

  }


 if ($section eq "cdel")
  {
     check_user();
     print "Content-type: text/html\n\n";

        $user = $q->param('user');
	$statement = 'DELETE FROM perlDesk_staff WHERE username = ?'; 
		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute($user) or die print "Couldn't execute statement: $DBI::errstr; stopped";

		print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=admin.cgi?do=staff"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank you</b>, you are now being re-directed.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="admin.cgi?do=staff">click 
					here</a> if you are not automatically forwarded</font></p></html>
                        |;
   }




 if ($section eq "staffcalls")
  {

     check_user();
     print "Content-type: text/html\n\n";

     $user = $q->param('user');

   	$sth = $dbh->prepare( "SELECT COUNT(*) FROM perlDesk_calls WHERE status = \"CLOSED\" AND closedby = ? ORDER BY id" ) or die DBI->errstr;	
	$sth->execute($user) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	my ( $count ) = $sth->fetchrow_array();
	if ($ENV{'QUERY_STRING'} !~ /show/) { $pae = 0; }

	$showp = $pae*30;

	$statement = "SELECT * FROM perlDesk_calls WHERE status = \"CLOSED\" AND closedby = \"$user\" ORDER BY id LIMIT $showp,30\;"; 
		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		$number=0;
		  while(my $ref = $sth->fetchrow_hashref()) 
			{	
			$number++;
			$subject="$ref->{'subject'}"; 
			$subject=substr($subject,0,20).'..' if length($subject) > 22;
			if ($ref->{'priority'} == "1") { $font = '#990000'; } else { $font = '#000000'; }

     			if ($ref->{'method'}  eq "cc") { $img   = "phone.gif";     } elsif ($ref->{'method'} eq "em") { $img = "mail.gif"; } else { $img = "ticket.gif"; }


            $calls .= display_ticket($ref->{'id'}, $ref->{'username'}, $ref->{'category'}, $ref->{'status'}, $ref->{'time'});
   		  }
		if (!$calls) 
		{
				$calls = '<font face=Verdana size=2><b>0 Calls</b></font>';
		}

      $template{'viewtickets'}  = $calls;
      $template{'user'}  = $user;
   my $output = parse("$global{'data'}/include/tpl/admin/staffview");
   print $output;

 }


 if ($section eq "listcalls")
  {
      check_user();  
      print "Content-type: text/html\n\n";
     
      $status   =  $q->param('status');
      $type     =  $status;
      $dep      =  $q->param('dep');
      $assigned =  $q->param('assigned');

      $status   = lc($status);

    #~~
    # Get Department List
    #~~
       $statement = 'SELECT level FROM perlDesk_departments'; 
       $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
       $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
          while(my $ref = $sth->fetchrow_hashref()) 
            {	
               $template{'deps'} .= qq|<option value="admin.cgi?do=listcalls&status=$status&dep=$ref->{'level'}">$ref->{'level'}</option>|;
            }

    #~~
    # Get Staff List
    #~~
       $statement = 'SELECT username FROM perlDesk_staff WHERE username != "admin"'; 
       $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
       $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
          while(my $ref = $sth->fetchrow_hashref()) 
            {	
               $template{'staff'} .= qq|<option value="admin.cgi?do=listcalls&status=$status&assigned=$ref->{'username'}">$ref->{'username'}</option>|;
            }


       if (defined $q->param('sort')) {  $sort = $q->param('sort');  }
       else { $sort = "id"; }

       if (defined $q->param('method')) {   if ($q->param('method') eq "asc") { $method = "ASC"; } else { $method = "DESC"; }  }
       else { $method = "ASC"; }


   
    

     if ($status eq "open") 
       {
            if ($dep) 
                {
                 	$sth = $dbh->prepare( qq|SELECT COUNT(*) FROM perlDesk_calls WHERE status = "CLOSED" AND category = "$dep"| ) or die DBI->errstr; 
                }
             elsif ($assigned)
                {
                 	$sth = $dbh->prepare( qq|SELECT COUNT(*) FROM perlDesk_calls WHERE status = "CLOSED" AND ownership = "$assigned"| ) or die DBI->errstr; 
                }

             else {   	$sth = $dbh->prepare( "SELECT COUNT(*) FROM perlDesk_calls WHERE status != \"CLOSED\"" ) or die DBI->errstr;  }
       } else 
         {

            if ($dep) 
                {
                     	$sth = $dbh->prepare( qq|SELECT COUNT(*) FROM perlDesk_calls WHERE status = "CLOSED" AND category = "$dep"| ) or die DBI->errstr; 
                }
             else {   	$sth = $dbh->prepare( "SELECT COUNT(*) FROM perlDesk_calls WHERE status = \"CLOSED\"" ) or die DBI->errstr;  }         }

        $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
      	my ( $total ) = $sth->fetchrow_array();


         $limit = "30";  # Results per page
      my $pages = ($total/$limit);
         $pages = ($pages+0.5);
      my $nume  = sprintf("%.0f",$pages);
         $page  = $q->param('page') || "0";
         $nume  = "1" if !$nume;
         $to    = ($limit * $page) if  $page;
         $to    = "0"              if !$page;

     $tpage     =  $page;
     $tpage     =  $tpage + 1;
     $location  =  $page;
     $location  =  $location + 1;
     $lboundary = "1" if $location < 4;
     $lboundary =  $location - 3  if !$lboundary;

     $nav .= qq|<font face=Verdana size=1>$nume Page(s): </font>|;

      if ($location + 2 < $nume) { $tboundary = 3 + $location; } else { $tboundary = $nume; }

      $string =  $ENV{'QUERY_STRING'};
      $string =~ s/&page=(.*)//g;        
      $prev   =  $page;
      $prev   =  $prev - 1;

      if ($nume > 1 && $tpage > 1 ) { $nav .= qq|<font face="verdana" size="1"><a href="admin.cgi?$string&page=0" alt="First Page">&laquo;</a> <a href="admin.cgi?$string&page=$prev" alt="First Page">&#139;</a> </font>|; }   
 
      foreach ($lboundary..$tboundary) 
          {       
             my $nu     =  $_ -1;
                 if ($nu eq $page) { $link = "[<b>$_</b>]"; } else { $link = "$_"; }          
                $nav   .= qq|<font face="verdana" size="1"><a href="admin.cgi?$string&page=$nu">$link</a> </font>|;
          }

      $next = $page;
      $next = $next + 1;
      $last = $nume;
      $last = $last - 1;

      if ($tpage < $nume && $tpage >= 1) { $nav .= qq|<font face="verdana" size="1"><a href="admin.cgi?$string&page=$next" alt="Next Page">&#155;</a> <a href="admin.cgi?$string&page=$last" alt="Next Page">&raquo;</a></font>|; }   


            $template{'nav'} = $nav;
         my $show  = $limit *  $page;


    if ($status eq "open") 
     { 
            if ($dep) 
                {
                	$statement = qq|SELECT * FROM perlDesk_calls WHERE status != "CLOSED" AND category = "$dep" ORDER BY $sort $method LIMIT $show, $limit|; 
                 }
            elsif ($assigned)
                {
                   	$statement = qq|SELECT * FROM perlDesk_calls WHERE status != "CLOSED" AND ownership = "$assigned" ORDER BY $sort $method LIMIT $show, $limit|; 
                }
             else {     $statement = qq|SELECT * FROM perlDesk_calls WHERE status != "CLOSED" ORDER BY $sort $method LIMIT $show, $limit|;  }
    }
      else {
            if ($dep) 
                {
                	$statement = qq|SELECT * FROM perlDesk_calls WHERE status = "CLOSED" AND category = "$dep" ORDER BY $sort $method LIMIT $show, $limit|; 
                 }
             else {     $statement = qq|SELECT * FROM perlDesk_calls WHERE status = "CLOSED" ORDER BY $sort $method LIMIT $show, $limit|;  }
           }
   
 	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
    $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		$number=0;
 	    while($ref = $sth->fetchrow_hashref()) 
         {	
			$number++;
     		$subject = "$ref->{'subject'}"; 
			$subject = substr($subject,0,20).'..' if length($subject) > 22;

			$font   = '#000000';

     			if ($ref->{'method'}  eq "cc") { $img   = "phone.gif";     } elsif ($ref->{'method'} eq "em") { $img = "mail.gif"; } else { $img = "ticket.gif"; }
    			if ($ref->{'priority'} eq "1") { $color = $global{'pri1'}; } 
     			if ($ref->{'priority'} eq "2") { $color = $global{'pri2'}; } 
    			if ($ref->{'priority'} eq "3") { $color = $global{'pri3'}; } 
    			if ($ref->{'priority'} eq "4") { $color = $global{'pri4'}; } 
    			if ($ref->{'priority'} eq "5") { $color = $global{'pri5'}; } 

            $current_time = time();
            $difference = $current_time - $ref->{'track'};

            if ($difference >= 86400) 
               {
                   $period = "day";
                   $count = $difference / 86400;
               } 
            elsif ($difference >= 3600) 
               {
                   $period = "hour";
                   $count = $difference / 3600;
               }
            elsif ($difference >= 60)  
               {
                   $period = "minute";
                   $count = $difference / 60;
               }
            else {
                     $period = "second";
                     $count = $difference;
                 }

            $count = sprintf("%.0f", $count);

            if ($count != 1) { $period .= "s"; }
            $period .= " Ago";

            if ($ref->{'ownership'} eq $Cookies{'staff'}) { $otag = "<b>"; $ctag = "</b>"; } else { $otag = ''; $ctag=''; }

            $opencalls .= display_ticket($ref->{'id'}, $ref->{'username'}, $ref->{'category'}, $ref->{'status'}, $ref->{'time'});

     	 }
		
		$opencalls = '<font face=Verdana size=2><b>0 Calls</b></font>' if !$opencalls;
		
        $template{'listcalls'}  = $opencalls;
        $template{'navbar'}     = $bar;
        $template{'type'}       = $status;
 
      my $output = parse("$global{'data'}/include/tpl/admin/listcalls");
      print $output;
  }


 

 if ($section eq "stats")
   {
  
       check_user();  
       print "Content-type: text/html\n\n";
     
     my ($sth);

		$sth = $dbh->prepare( "SELECT COUNT(*) FROM perlDesk_staff WHERE username != \"admin\"" ) or die DBI->errstr;
		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
			my ( $staff ) = $sth->fetchrow_array();
        $sth->finish;

		$sth = $dbh->prepare( "SELECT COUNT(*) FROM perlDesk_users" ) or die DBI->errstr;
		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
			my ( $users ) = $sth->fetchrow_array();
        $sth->finish;

		$sth = $dbh->prepare( "SELECT COUNT(*) FROM perlDesk_calls" ) or die DBI->errstr;
		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
			my ( $calls ) = $sth->fetchrow_array();
        $sth->finish;


     foreach (OPEN,HOLD,CLOSED)
       {
		$sth = $dbh->prepare( qq|SELECT COUNT(*) FROM perlDesk_calls WHERE status = "$_"| ) or die DBI->errstr;
		$sth->execute() or die "Couldn't execute statement: $DBI::errstr; stopped";
			$template{$_} = $sth->fetchrow_array();
                $sth->finish;
       }

   foreach("em","cc","hd")
     {

		$sth = $dbh->prepare( qq|SELECT COUNT(*) FROM perlDesk_calls WHERE method = "$_"| ) or die DBI->errstr;
		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
			$template{$_} = $sth->fetchrow_array();
        $sth->finish;	
     }




## Percentages
 
    if ($calls)
     {
           $template{'open_perc'}    =  ($template{'OPEN'}/$calls)*100;
           $template{'hold_perc'}    =  ($template{'HOLD'}/$calls)*100;
           $template{'closed_perc'}  =  ($template{'CLOSED'}/$calls)*100;


          $template{'open_perc'}    =   sprintf("%.0f", $template{'open_perc'});
          $template{'hold_perc'}    =   sprintf("%.0f", $template{'hold_perc'});
          $template{'closed_perc'}  =   sprintf("%.0f", $template{'closed_perc'});
      }

	$closed =  $global{'ssi_closed'};
        $tsec   =  $global{'avgtime'};

       if ($template{'CLOSED'} > 0) 
        {
            $sec      =  ($tsec/$template{'CLOSED'});
            $days     =  int($sec/(24*60*60));
            $hours    =  ($sec/(60*60))%24;
            $mins     =  ($sec/60)%60;
            $secs     =  $sec%60;
            $restime  =  "$hours hr(s) $mins min(s) $secs seconds";
        } else {
                  $restime = "No calls closed";
               }

      $template{'avgresponse'}   =   $restime;
      $template{'calls'}         =   $calls;
      $template{'users'}         =   $users;
      $template{'staff'}         =   $staff;

      print parse("$global{'data'}/include/tpl/admin/stats");
   
 } 
 



 }


sub display_ticket 
 {
    my ($id, $username, $category, $status, $date) = @_;
    my $ticket = qq| <table width="100%" border="0" cellpadding="5" cellspacing="1"><tr bgcolor="#F1F1F8"><td width="3%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="$global{'imgbase'}/$img"></font></td>
                     <td width="6%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color=$font>$otag <div align="center">$id</div>  $ctag</font></td>
                     <td width="17%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color=$font>$otag $username $ctag</font></td><td width="25%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color=$font><a href="admin.cgi?do=ticket&cid=$id">$otag $subject $ctag</a></font></td>
                     <td width="22%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color=$font>$otag $category $ctag</font></td><td width="8%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color=$font>$otag <div align="center">$status</div> $ctag</font></td><td width="19%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color=$font>$otag $date $ctag</font></td>
                     </tr></table>
                   |;
    return $ticket;
 }







1;