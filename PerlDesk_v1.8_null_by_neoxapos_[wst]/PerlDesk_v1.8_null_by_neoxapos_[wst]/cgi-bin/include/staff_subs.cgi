#!/usr/bin/perl
###################################################################################
#                                                                                 #
#                   PerlDesk - Customer Help Desk Software                        #
#                                                                                 #
###################################################################################
#                                                                                 #
#     Author: John Bennett	                                                  #
#      Email: j.bennett@perldesk.com                                              #
#        Web: http://www.perldesk.com                                             #
#   Filename: staff_subs.cgi                                                      #
#    Details: The staff areas                                                     #
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

   my $spass = $q->cookie('spass');
   my $sname = $q->cookie('staff');

   %Cookies = (
        staff => $sname,
        spass => $spass
   );


  sub check_user 
   {
	if ((! $Cookies{'staff'}) || ($Cookies{'staff'} eq "")) 
         {
              $ignore = 1;
              section("login"); 
	 }

	my $statement = qq|SELECT * FROM perlDesk_staff WHERE username = "$Cookies{'staff'}"|; 
	my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	   $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	     while(my $ref = $sth->fetchrow_hashref()) 
               {
                    $uid           =   $ref->{'sid'};
                    $staff_id      =   $ref->{'id'};
	            $username      =   $ref->{'username'};
                    $password      =   $ref->{'password'};
                    $name          =   $ref->{'name'};
                    $accesslevel   =   $ref->{'access'};
                    $email         =   $ref->{'email'};
		    $rkey          =   $ref->{'rkey'};
                    $plsound       =   $ref->{'play_sound'};

                    $template{'ucname'} = $username;
                    $template{'name'}   = $name;
                    $template{'email'}  = $email;
	       }

	my $md5  = Digest::MD5->new ;
	   $md5->reset ;
	my $yday = (localtime)[7];

    my @ipa = split(/\./,$ENV{'REMOTE_ADDR'});

    my $startip = $ipa[0] . $ipa[1];

	my $certif = $Cookies{'staff'} . "pd-$rkey" . $ENV{'HTTP_USER_AGENT'} . $startip  if   $IP_IN_COOKIE;
	   $certif = $Cookies{'staff'} . "pd-$rkey" . $ENV{'HTTP_USER_AGENT'}  if  !$IP_IN_COOKIE;
	   $md5->add($certif);

	my $enc_cert = $md5->hexdigest();

	if($enc_cert eq $Cookies{'spass'})  
            {
                        $loggedin = 1;
   			# we're logged in !! :)
	    } else {
                        $ignore =1;
	            	section("login");
   	           }

        my $current_time = time();
	   execute_sql(qq|UPDATE perlDesk_staffactive SET date = "$current_time" WHERE username = "$Cookies{'staff'}"|); 

    	   $statement = 'SELECT level FROM perlDesk_departments'; 
           $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
           $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
            while(my $ref = $sth->fetchrow_hashref()) 
            {
               if (($accesslevel =~ /$ref->{'level'}::/) || ($accesslevel =~ /GLOB::/)) 
                { 
                   my $th    = $dbh->prepare( "SELECT COUNT(*) FROM perlDesk_calls WHERE category = ?" ) or die DBI->errstr;
                      $th->execute("$ref->{'level'}") or die print "Couldn't execute statement: $DBI::errstr; stopped";
                   my $total = $th->fetchrow_array();
       	                
                               $template{'depview'} .= qq|<table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                          <tr><td width="10%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src=$global{'imgbase'}/folder.gif></font></td><td width="70%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'level'}</font></td>
                                                          <td width="20%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">($total)</font></td></tr></table>|;
                }
            }
   }



 sub lang_parse 
  {
      if ($_ =~ /\%*\%/) 
           {
               s/\%(\S+)\%/$LANG{$1}/g;
           }
  }

 sub section {

    $section = "@_";
  

#~~ 
# Staff Login Form
#~~ 

if ($section eq "login") 
 {
    if (!$ignore) 
      {
          check_user();
          print "Location: $global{'baseurl'}/staff.cgi?do=main\n\n" if $loggedin == "1";
      }
           print "Content-type: text/html\n\n";


       print qq|<html><head><title>PerlDesk Staff Login</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><STYLE type=text/css>
                A:active  { COLOR: #006699; TEXT-DECORATION: none      }
                A:visited { COLOR: #334A9B; TEXT-DECORATION: none      }
                A:hover   { COLOR: #334A9B; TEXT-DECORATION: underline }
                A:link    { COLOR: #334A9B; TEXT-DECORATION: none      }
                .gbox         { FONT-SIZE: 11px; FONT-FAMILY: Verdana; COLOR: #000000; BACKGROUND-COLOR: #EEEEEE }
                .forminput    { font-size: 8pt; background-color: #CCCCCC; font-family: verdana, helvetica, sans-serif; vertical-align:middle } 
                .tbox         { FONT-SIZE: 11px; FONT-FAMILY: Verdana; COLOR: #000000; BACKGROUND-COLOR: #ffffff }
                </STYLE></head><body bgcolor="#FFFFFF" text="#000000"><p>&nbsp;</p><table width="400" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td colspan="2"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="$global{'logo_url'}"><br><div align=right>Remote IP: $ENV{'REMOTE_ADDR'}</div></font></td></tr><tr> <td colspan="2"><form name="form1" method="post" action="staff.cgi"><table width="66%" border="0" align="center" cellpadding="0" cellspacing="1"><tr><td width="42%">&nbsp;</td><td width="58%">&nbsp;</td></tr><tr><td width="42%"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Username</font></div></td><td width="58%"><input type="text" name="username" class="gbox"></td></tr><tr><td width="42%"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Password</font></div></td><td width="58%"><input type="password" name="password" class="gbox"></td></tr><tr><td colspan="2">&nbsp;</td></tr><tr> 
                <td colspan="2"><div align="center"><input type="hidden" name="do" value="pro_login">
                <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Remember 
                     me?<input type="checkbox" name="remember" value="yes"><br><br></font></div><div align=center><input type="submit" name="Submit" value="Submit" class="forminput"></div></div></td></tr></table></form></td></tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr></table></body></html>|;
 }



#~~
# Process a login request
#~~

if ($section eq "pro_login") 
 {

    $user      =   $q->param('username');
    $pass      =   $q->param('password');

	$statement = "SELECT * FROM perlDesk_staff WHERE username = ?"; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute("$user") or die print "Couldn't execute statement: $DBI::errstr; stopped";
    while(my $ref = $sth->fetchrow_hashref())
        {
                $salt  =  $ref->{'rkey'};
                $cpass =  crypt($pass, $salt);

                        if ((!$user) || ($user eq "admin") || ($cpass ne $ref->{'password'}))
                        {  $error = 1;
                        } else {
                                   $username    =   $ref->{'username'};
                                   $password    =   $ref->{'password'};
                                   $name        =   $ref->{'name'};
                                   $email       =   $ref->{'email'};
                                   $accesslevel =   $ref->{'access'};
                               }
        }
    
  $error = 1 if !$username;
  die_nice("Invalid username or password <br><a href=staff.cgi?do=login>Back To Login Form </a>") if $error;
 

	if (@errors) 
	{
			print "Content-type: text/html\n\n";
   	    	        print @errors;
	        	exit;
	}	 

	execute_sql(qq|UPDATE perlDesk_stafflogin SET date = "$hdtime" WHERE username = "$user"|);
        execute_sql(qq|UPDATE perlDesk_staff SET lpage = "0" WHERE username = "$user"|);


	my $md5 = Digest::MD5->new ;
	   $md5->reset ;

    my $yday    =  (localtime)[7];
    my @ipa     =  split(/\./,$ENV{'REMOTE_ADDR'});
    my $startip =  $ipa[0] . $ipa[1];
    my $certif  =  $user . "pd-$salt" . $ENV{'HTTP_USER_AGENT'} . $startip  if  $IP_IN_COOKIE;
       $certif  =  $user . "pd-$salt" . $ENV{'HTTP_USER_AGENT'}  if  !$IP_IN_COOKIE;

       $md5->add($certif);
 	my $enc_cert = $md5->hexdigest() ;


     if ($q->param('remember') eq "yes") 
       {
        $cookie1 = $q->cookie(-name=>'staff',
                              -value=>$user,
                              -domain  =>'',
                              -expires=>'+1y',
                              -path    =>  '/');
        $cookie2 = $q->cookie(-name=>'spass',
                              -value=>$enc_cert,
                              -expires=>'+1y',
                              -domain  =>'',
                              -path    =>  '/');
       } else {
                $cookie1 = $q->cookie(-name=>'staff',
                                      -value=>$user,
                                      -path    =>  '/',
                                      -domain  =>'');
                $cookie2 = $q->cookie(-name=>'spass',
                                      -value=>$enc_cert,
                                      -path    =>  '/',
                                      -domain  =>'');
            }

        print $q->header(-cookie=>[$cookie1,$cookie2]);

        print qq|	<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=staff.cgi?do=main"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thanks for logging in</b>, you are now being taken to the staff area.</font><br><br>
       			<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?do=main">click 
  			here</a> if you are not automatically forwarded</font></p></html>
                |;
        exit;
   }


#~~
# Change Priority
#~~
 
 if ($section eq "change_pri")
  {
       check_user(); 
       print "Content-type: text/html\n\n";

        $id     =  $q->param('id');
        $status =  $q->param('pri');
 
          execute_sql(qq|UPDATE perlDesk_calls SET priority = "$status" WHERE id = "$id"|);

           print qq|	<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=staff.cgi?do=ticket&cid=$id"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Ticket Updated</b></font><br><br>
       			<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?do=ticket&cid=$id">click 
  			here</a> if you are not automatically forwarded</font></p></html>
                   |;
  }


#~~
# Change Status
#~~

 
 if ($section eq "change_status")
  {
       check_user(); 
       print "Content-type: text/html\n\n";

        $id  = $q->param('id');
        $status = $q->param('status');
 
          execute_sql(qq|UPDATE perlDesk_calls SET status = "$status" WHERE id = "$id"|);

        my $sdsth = $dbh->prepare( "INSERT INTO perlDesk_activitylog VALUES ( ?, ?, ?, ?, ?)" );
           $sdsth->execute( "NULL", $id, $hdtime, "Staff: $Cookies{'staff'}", "Status Changed: $status" ) or die "Couldn't execute statement: $DBI::errstr; stopped";


          if ($status eq "CLOSED")
           { execute_sql(qq|UPDATE perlDesk_calls SET closedby = "$Cookies{'staff'}" WHERE id = "$id"|);}

        print qq|	<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=staff.cgi?do=ticket&cid=$id"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Ticket Updated</b></font><br><br>
       			<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?do=ticket&cid=$id">click 
  			here</a> if you are not automatically forwarded</font></p></html>
                |;
  }

#~~ 
# Search Page
#~~


 if ($section eq "search")
  {
       check_user(); 
       print "Content-type: text/html\n\n";

	 $statement = qq|SELECT username, name FROM perlDesk_staff WHERE username != "admin"|; 
	 $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die "Couldn't execute statement: $DBI::errstr; stopped";
   	  while(my $ref = $sth->fetchrow_hashref()) 
		{  $template{'staff'} .= qq|<option value="staff.cgi?do=sresults&ustaff=$ref->{'username'}">$ref->{'name'}</option>|; } 	

         parse("$global{'data'}/include/tpl/staff/search");
  } 


if ($section eq "sresults") {

       check_user(); 
       print "Content-type: text/html\n\n";

	$select = $q->param('select');
	$query  = $q->param('query');

	if ($select eq "id")		{    $field = "id"; 	      }
	if ($select eq "Username")      {    $field = "username";     }
	if ($select eq "subject") 	{    $field = "subject";      }
	if ($select eq "domain") 	{    $field = "url"; 	      }
	if ($select eq "priority")      {    $field = "priority";     }
	if ($select eq "description")   {    $field = "description";  }
	if ($select eq "email")         {    $field = "email";  }

	if ($ENV{'QUERY_STRING'} =~ /query/)
	 {
         $query =  $q->param('query');
         $feld  =  $q->param('field');
	 }

       	$query =~ s/_/ /g;

	if (!$feld) 
         {
		$feld = $field;	
	 } 


  my $ustaff = $q->param('ustaff');

  if ($q->param('ustaff'))
   {


  if ($accesslevel =~ /GLOB::/) 
     {
    	$statement = qq|SELECT COUNT(*) FROM perlDesk_calls WHERE ownership = "$ustaff"|;
     }
  else {

       @access = split(/::/, $accesslevel);
         $ac = 0;
        foreach $dep (@access) { $ac++; }
        	$statement = qq|SELECT COUNT(*) FROM perlDesk_calls WHERE ownership = "$ustaff" AND |;
            $i = 1;
        foreach $dep (@access) 
           {

              $dep        =~ s/^\s+//g;
              $statement .= qq|category = "$dep" |;

              if ($i < $ac) { $statement .= 'OR '; }
              $i++;
           }
        }

   }
 else {


  if ($accesslevel =~ /GLOB::/) 
     {
    	$statement = qq|SELECT COUNT(*) FROM perlDesk_calls WHERE $feld LIKE "%$query%"|;
     }
  else {

       @access = split(/::/, $accesslevel);
         $ac = 0;
        foreach $dep (@access) { $ac++; }
        	$statement = qq|SELECT COUNT(*) FROM perlDesk_calls WHERE $feld LIKE "%$query%" AND |;
            $i = 1;
        foreach $dep (@access) 
           {

              $dep        =~ s/^\s+//g;
              $statement .= qq|category = "$dep" |;

              if ($i < $ac) { $statement .= 'OR '; }
              $i++;
           }
        }
}
	$sth = $dbh->prepare($statement) or die DBI->errstr;
	$sth->execute() or die "Couldn't execute $statement: $DBI::errstr; stopped";
        	 $count = $sth->fetchrow_array();
	$sth->finish;

         $total = $count;

         $limit = $q->param('pae') || "20";  # Results per page
      my $pages = ($total/$limit);
         $pages = ($pages+0.5);
      my $nume  = sprintf("%.0f",$pages);
      my $page  = $q->param('page') || "0";
         $nume  = "1" if !$nume;
         $to    = ($limit * $page) if  $page;
         $to    = "0"              if !$page;

    $template{'path'} =  "staff.cgi" . '?' . $ENV{'QUERY_STRING'} . "&page=$page";
    $template{'path'} =~ s/&sort=(.*)//;
    $template{'path'} =~ s/&method=(.*)//;

      foreach (1..$nume) 
          {       
             my $nu = $_ -1;
                  if ($nu eq $page) { $link = "[<b>$_</b>]"; } else { $link = "$_"; }          
             my $string =  $ENV{'QUERY_STRING'};
                $string =~ s/&page=(.*)//g;
              
                $nav   .= qq|<font face="verdana" size="1"><a href="staff.cgi?do=sresults&query=$query&select=$feld&page=$nu&pae=$limit">$link</a> </font>| if !$ustaff;
                $nav   .= qq|<font face="verdana" size="1"><a href="staff.cgi?do=sresults&query=$query&select=$feld&page=$nu&pae=$limit&ustaff=$ustaff">$link</a> </font>| if  $ustaff;
           }

            $template{'nav'} = $nav;
         my $show  = $limit *  $page;

	 $statement = qq|SELECT * FROM perlDesk_calls WHERE $feld LIKE "%$query%" ORDER BY id LIMIT $show,$limit| if !$ustaff; 
	 $statement = qq|SELECT * FROM perlDesk_calls WHERE ownership = "$ustaff" ORDER BY id LIMIT $show,$limit| if  $ustaff;
	 $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die "Couldn't execute statement: $DBI::errstr; stopped";
		$number=0;
   	  while(my $ref = $sth->fetchrow_hashref()) 
		{	
                    my $cat  = $ref->{'category'};
                       $cat .= '::';

			if (($accesslevel =~ /$cat/)  || ($accesslevel =~ /GLOB::/)) 
			     {
			     	$number++;
			     	if ($ref->{'priority'} eq 1) { $font = '#990000'; } else { $font = '#000000'; }	
			         	 $subject    =  "$ref->{'subject'}"; 
			        	 $subject    =  substr($subject,0,20).'..' if length($subject) > 22;
			    		 $template{'results'} .= '<table width="100%" border="0" cellpadding="4"><tr bgcolor="#E4E7F8"> 
    		                     		<td width="5%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="' . "$global{'imgbase'}/ticket.gif" . '"></font></td>
   					                    <td width="4%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color=' . "$font> $ref->{'id'}" . '</font></td>
   					                    <td width="24%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color=' . "$font>$ref->{'username'}" . '</font></td><td width="29%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color=' . "$font>" . '<a href="staff.cgi?do=ticket&cid=' . "$ref->{'id'}\">$subject" . '</a></font></td>
   					                    <td width="11%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color=' . "$font>$ref->{'status'}" . '</font></td>
   					                    <td width="24%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color=' . "$font>$ref->{'time'}" . '</font></td></tr></table>';
			     }
		}

      	 $sth->finish;

         $template{'results'}   = qq|<font face="verdana" size="2">No results found</font>| if !$template{'results'};
         $template{'noresults'} = $total;
         parse("$global{'data'}/include/tpl/staff/search_results"); 
  }


#~~
# Staff Main Page
#~~

 if ($section eq "main") 
   {
       check_user(); 
       print "Content-type: text/html\n\n";

     my ($statement);

        if (defined $q->param('sort')) { $sort = $q->param('sort'); } else { $sort = "id"; }

      if (defined $q->param('method')) 
         { 
            if ($q->param('method') eq "asc") { $method = "ASC"; } else { $method = "DESC"; } 
         }
      else { $method = "ASC"; }

      if ($q->param('timer'))
        {
             $template{'rtime'}     =  $q->param('timer');

                        $template{'t1'} = " selected" if $q->param('timer') == "60000";
                        $template{'t2'} = " selected" if $q->param('timer') == "180000";
                        $template{'t3'} = " selected" if $q->param('timer') == "300000";
                        $template{'t4'} = " selected" if $q->param('timer') == "900000";
                        $template{'t5'} = " selected" if $q->param('timer') == "1800000";

             $template{'rdirector'} = ' onLoad=redirTimer();'; 
             $template{'rurl'}      = qq|&timer=| . $q->param('timer');
        }
       else { $template{'rdirector'} = ""; $template{'rurl'} = "";}


      $sth   = $dbh->prepare( qq|SELECT COUNT(*) FROM perlDesk_calls WHERE ownership = "$Cookies{'staff'}" AND status != "CLOSED"| ) or die DBI->errstr;
      $sth->execute() or die "Couldn't execute statement: $DBI::errstr; stopped";
          $owned = $sth->fetchrow_array();

      $statemet = 'SELECT * FROM perlDesk_announce WHERE staff = "1"'; 
      $sth = $dbh->prepare($statemet) or die "Couldn't prepare statement: $DBI::errstr; stopped";
      $sth->execute() or die "Couldn't execute statement: $DBI::errstr; stopped";
        while(my $ref = $sth->fetchrow_hashref()) 
           {	
                   $notice .= '<table width="100%" border="0" cellspacing="1" cellpadding="2"><tr><td width="5%"> <div align="center"><img src="' . "$global{'imgbase'}" . '/note.gif" width="11" height="11"></div></td><td width="62%"><a href="staff.cgi?do=notice&id=' . "$ref->{'id'}\"><font size=\"1\" face=\"Verdana, Arial, Helvetica, sans-serif\">$ref->{'subject'}" . '</font></a></td><td width="33%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">' . "$ref->{'time'}" . '</font></td></tr></table>';
           }
                   $notice  = '<font face="verdana" size="1">0 Announcements</font>' if !$notice;

         my $pri1  =  $global{'pri1'};
         my $pri2  =  $global{'pri2'};
         my $pri3  =  $global{'pri3'};
         my $pri4  =  $global{'pri4'};
         my $pri5  =  $global{'pri5'};
            $tnum  =  1;

        $statemen = 'SELECT level FROM perlDesk_departments'; 
        $sth      =  $dbh->prepare($statemen) or die "Couldn't prepare statement: $DBI::errstr; stopped";
        $sth->execute() or die "Couldn't execute statement: $DBI::errstr; stopped";
         while(my $ref = $sth->fetchrow_hashref()) {	

           if (($accesslevel =~ /$ref->{'level'}::/) || ($accesslevel =~ /GLOB::/)) 
            {
              $ssth = $dbh->prepare( "SELECT COUNT(*) FROM perlDesk_calls WHERE category = ? AND status != \"CLOSED\"" ) or die DBI->errstr;
              $ssth->execute( $ref->{'level'} ) or die "Couldn't execute statement: $DBI::errstr; stopped";
                my $queue = $ssth->fetchrow_array();
              $ssth->finish;   

              $ssth = $dbh->prepare( "SELECT COUNT(*) FROM perlDesk_calls WHERE (category = ? AND status != \"CLOSED\" AND aw = \"1\")" ) or die DBI->errstr;
              $ssth->execute( $ref->{'level'} ) or die "Couldn't execute statement: $DBI::errstr; stopped";
                my $staff = $ssth->fetchrow_array();
              $ssth->finish;   


              $ssth = $dbh->prepare( "SELECT COUNT(*) FROM perlDesk_calls WHERE (category = ? AND status != \"CLOSED\" AND aw = \"0\")" ) or die DBI->errstr;
              $ssth->execute( $ref->{'level'} ) or die "Couldn't execute statement: $DBI::errstr; stopped";
                my $user = $ssth->fetchrow_array();
              $ssth->finish;   

               $template{'dep_stats'} .= qq|<tr><td bgcolor="#E8E8E8"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'level'}</font></td><td bgcolor="#f2f2f2"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">$queue</font></div></td><td bgcolor="#f2f2f2"> <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">$staff</font></div>
                                            </td><td bgcolor="#f2f2f2"> <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">$user</font></div></td></tr>|;

           }
                $tnum++;
          }
        $sth->finish;

 $template{'dep_stats'} = "" if !$template{'dep_stats'};

 @types = ("em", "new","open");

 foreach $type (@types)
  {    
        chomp($type);

     	if ($accesslevel =~ /GLOB::/) 
          {  
              $statement = qq|SELECT perlDesk_calls.* FROM perlDesk_calls LEFT JOIN perlDesk_notes ON perlDesk_calls.id = perlDesk_notes.call WHERE perlDesk_calls.status = "OPEN" AND perlDesk_notes.id is NULL|  if $type eq "new"; 
              $statement = qq|SELECT * FROM perlDesk_calls WHERE status != "CLOSED"|                      if $type eq "open"; 
              $statement = qq|SELECT * FROM perlDesk_calls WHERE (status != "CLOSED" AND priority = "1")| if $type eq "em"; 

               if (%ticket)
                {
                   $statement .= qq| AND (|;
                   $num=0;

                 if ($type eq "new")
                  {

                  foreach my $key (keys %ticket) 
                     {
                         $statement .= qq|perlDesk_calls.id != "$key" |     if $ticket{$key} == "1" && $num == "0";
                         $statement .= qq|AND perlDesk_calls.id != "$key" | if $ticket{$key} == "1" && $num != "0";
                         $num++;
                     }
                   }
                     else {

                  foreach my $key (keys %ticket) 
                     {
                         $statement .= qq|id != "$key" |     if $ticket{$key} == "1" && $num == "0";
                         $statement .= qq|AND id != "$key" | if $ticket{$key} == "1" && $num != "0";
                         $num++;
                     }
                          }

                   $statement .= qq|)|;

                }

             $statement .= qq| ORDER BY id DESC LIMIT 0, 5|;

         }
        else {
                     die_nice("Sorry, the administrator has not given you access to any departments") if !$accesslevel;

                    @access = split(/::/,$accesslevel);
                    $ac     = 0;
                    foreach $ddep (@access) { $ac++; }

                    $statement =  'SELECT perlDesk_calls.* FROM perlDesk_calls LEFT JOIN perlDesk_notes ON perlDesk_calls.id = perlDesk_notes.call WHERE (perlDesk_calls.status = "OPEN" AND perlDesk_notes.id is NULL) AND ( ' if $type eq "new";
                    $statement =  'SELECT * FROM perlDesk_calls WHERE status != "CLOSED" AND priority = "1" AND ( ' if $type eq "em";
                    $statement =  'SELECT * FROM perlDesk_calls WHERE status != "CLOSED" AND ( '                    if $type eq "open";

                    $i         =   1;

                    foreach $dep (@access) 
                       {
                           $dep         =~  s/^\s+//g;
                           $statement  .=   "category = \"$dep\" ";

                           if ($i < $ac) { $statement .= 'OR '; }

                           $i++;
                       }

                      
               if (%ticket)
                {
                   $statement .= qq|) AND (|;
                   $num=0;


                 if ($type eq "new")
                  {

                  foreach my $key (keys %ticket) 
                     {
                         $statement .= qq|perlDesk_calls.id != "$key" |     if $ticket{$key} == "1" && $num == "0";
                         $statement .= qq|AND perlDesk_calls.id != "$key" | if $ticket{$key} == "1" && $num != "0";
                         $num++;
                     }
                   }
                     else {

                  foreach my $key (keys %ticket) 
                     {
                         $statement .= qq|id != "$key" |     if $ticket{$key} == "1" && $num == "0";
                         $statement .= qq|AND id != "$key" | if $ticket{$key} == "1" && $num != "0";
                         $num++;
                     }
                          }
                }

                         $statement .= ") ORDER BY ID DESC LIMIT 5"; 

             }


          	$sth    = $dbh->prepare($statement) or die "Couldn't prepare statement : $DBI::errstr; stopped";
         	$sth->execute() or die "Couldn't execute statement . $accesslevel . ($statement): $DBI::errstr; stopped";
      		$number = 0;
        while($ref = $sth->fetchrow_hashref()) 
         {	
           
           $id  =  $ref->{'id'};
           next if $ticket{$id} == "1";

           if ($ref->{'status'} ne "CLOSED") 
                {
                      if ($type eq "new")
                        {


                               $template{'soundb'} = qq|<BGSOUND SRC=$global{'imgbase'}/ding.wav"><EMBED SRC="$global{'imgbase'}/ding.wav" playmode=auto visualmode=background width=0 height=3 AUTOSTART=true>| if $plsound;

                            my $ssth       = $dbh->prepare('SELECT call, owner FROM perlDesk_notes WHERE call = ?') or die "Couldn't prepare statement: $DBI::errstr; stopped";
                               $ssth->execute( $id ) or die "Couldn't execute statement: $DBI::errstr; stopped";
           
                                 if ($ssth->rows > 0) { next; }

                        }
                                    
                         $number++;
                         $font    =   '#000000'; 
			 $subject =   $ref->{'subject'}; 
			 $subject =~  s/^\'(.*)\'$/$1/;	 
     	                 $subject =   substr($subject,0,20).'..' if length($subject) > 22;
	
			 if ($ref->{'method'} eq "cc" ) { $img = "phone.gif"; } elsif ($ref->{'method'} eq "em") { $img = "mail.gif"; } else { $img = "ticket.gif"; }
			 if ($subject =~ /^\'/)         { $subject = $1 if $subject =~ /\'(\S+)\'/;              }

 			 if ($ref->{'priority'} eq "1") { $color = $pri1; } 
 			 if ($ref->{'priority'} eq "2") { $color = $pri2; } 
			 if ($ref->{'priority'} eq "3") { $color = $pri3; } 
			 if ($ref->{'priority'} eq "4") { $color = $pri4; } 
			 if ($ref->{'priority'} eq "5") { $color = $pri5; } 
			 if ($ref->{'aw'} eq "1")       { $awt = "<img src=\"$global{'imgbase'}/online.gif\">"; } else { $awt = "<img src=\"$global{'imgbase'}/offline.gif\">"; }

                             $current_time  =  time();
                             $difference    =  $current_time - $ref->{'track'};

           #~~ 
           # Ticket Timestamp Conversion
           #~~

            if ($difference  >=  86400)  {    $period = "day";       $count = $difference / 86400; } 
            elsif ($difference >= 3600)  {    $period    = "hour";   $count = $difference / 3600;  } 
            elsif ($difference >= 60)    {    $period    = "minute"; $count = $difference / 60;     } 
            else                         {    $period = "second";     $count  = $difference;         }

            $count  =  sprintf("%.0f", $count);

            if ($count  != 1)  {  $period .= "s";  }
                $period .= " Ago";

            #~~

            if ($ref->{'ownership'} eq $Cookies{'staff'}) { $otag = "<b>"; $ctag = "</b>"; } else { $otag = ''; $ctag=''; }
     

                  $tcall             =  $type;
                  $tcall            .=  "_call";
                  $template{$tcall} .=  display_ticket($ref->{'id'}, $ref->{'username'}, $ref->{'category'}, $ref->{'status'});
                  $ticket{$id}       =  1 if !$match;
    }  }


                  $tcall             =  $type;
                  $tcall            .=  "_call";

	          $template{$tcall}  =  '<font face="Verdana" size="1">No Requests Found</font>' if !$template{$tcall};
  }


        $current_time      =   time();

        $statemente = 'SELECT * FROM perlDesk_staffread WHERE username = ?'; 
	$sth        =  $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
        $sth->execute($Cookies{'staff'}) or die print "Couldn't execute statement: $DBI::errstr; stopped";
           while(my $ref = $sth->fetchrow_hashref()) 
               {  $lastactive = $ref->{'date'}; }

        $unread     = 0;
        $statemente = 'SELECT stamp FROM perlDesk_messages WHERE touser = ?'; 
	$sth        =  $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
        $sth->execute($Cookies{'staff'}) or die print "Couldn't execute statement: $DBI::errstr; stopped";
          while(my $ref = $sth->fetchrow_hashref()) 
             {
			if ($ref->{'stamp'} > $lastactive) {    $unread++;   }
	     }

        $inbox   = "<div align=\"center\"><font face=\"Verdana\" size=\"1\">You have " . '<a href="#" onclick="Popup(\'staff.cgi?do=messanger&to=inbox\', \'Window\', 425, 400);' . "\">$unread</a> unread messages</font></div>";


        $template{'announcement'}   =   $notice;
        $template{'open'}           =   $owned;
        $template{'pm'}             =   $inbox;
        $template{'queue'}          =   $queue;
        $template{'user'}           =   $Cookies{'staff'};
        $template{'deplist'}        =   $depq;

         parse("$global{'data'}/include/tpl/staff/staffmain");

   }


#~~
# Knowledge Base Administration
#~~

  if ($section eq "kb")
   {
       check_user(); 
       print "Content-type: text/html\n\n";
       $goto = $q->param('goto');

     if ($goto eq "add") 
      {
        	$statement = 'SELECT category FROM perlDesk_kb_cat'; 
          	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
           	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
         		while(my $ref = $sth->fetchrow_hashref()) 
                 {	
         			$option .= "<option value=\"$ref->{'category'}\">$ref->{'category'}</option>";
                 }
        	$sth->finish;

            $template{'category'}   = $option;
            parse("$global{'data'}/include/tpl/staff/add_kb");
      }


    if ($goto eq "search")
     {

     	$select   =  $q->param('select');
      	$query    =  $q->param('query');
    	my $field =  $query;
           $feld  =  $q->param('field');

	$query =~ s/_/ /g;
	if (!$feld) 
      {
	    	$feld = $select;	
	  } 


	$sth = $dbh->prepare( 'SELECT COUNT(*) FROM perlDesk_kb_entries WHERE ' . "description" . ' LIKE "%' . "$query" . '%" AND category = "' . "$select" . '"' ) or die DBI->errstr;
	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	 $count = $sth->fetchrow_array();
	$sth->finish;

	if ($ENV{'QUERY_STRING'} !~ /show/) { $pae = 0; }
	if (($count > 30) || ($ENV{'QUERY_STRING'} =~ /show/)) { $showbar = "1"; }
		if ($showbar) 
		{
		if ($ENV{'QUERY_STRING'} =~ /show/) 
			{
				my $string = "$ENV{'QUERY_STRING'}";
 			 	 @values = split(/\&/,$ENV{'QUERY_STRING'});
   		      	foreach $i (@values) { 
                if ($i =~/show/) 
				{
                    ($action, $pae) = split(/=/,$i);
                }   }
	if ($pae eq "0") 		{
		$prevlink = '&laquo; prev';
		} else 		{
			$link = $query;
			$link =~ s/ /_/g;
			$prevpage = $pae-1;
			$prevlink = "<a href=\"staff.cgi?do=kb&goto=search&query=$link&show=$prevpage&field=$feld\">" . '&laquo; prev' . "</a>";
		} }	 else 		{
		$prevlink = '&laquo; prev';
		}
		$res = $pae+1;
		$total = (30*$res);
		if ($count > $total){
			$nextpage = $pae+1;
			$link = $query;
			$link =~ s/\s/_/g;
			$nextlink = "<a href=\"staff.cgi?do=kb&goto=search&query=$link&show=$nextpage&field=$feld\">" . 'next &raquo;' . "</a>";
		} else		 {
			$nextlink = 'next &raquo;';
		}
				$bar = '<table width="100%" border="0" cellspacing="0" cellpadding="3" align="center"><tr bgcolor="#E8E8E8"><td> 
      			<div align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">' . "$prevlink" . '</font></div></td><td><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">' . "$nextlink" . '</font></div></td></tr></table>';
		}
	$showp = $pae*30;

    $bar = '' if !$bar;

	 $statement = 'SELECT * FROM perlDesk_kb_entries WHERE description LIKE "%' . "$query" . '%"  AND category = "' . "$feld" . '" ORDER BY id LIMIT ' . "$showp" . ',30'; 
	 $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	 while(my $ref = $sth->fetchrow_hashref()) 
		{	
				if ($ref->{'read'} > 50) { $pop = "<img src=\"$global{'imgbase'}/hot.gif\">"; } else { $pop = ' '; }
				$opencalls .= '<table width="100%" border="0" cellspacing="1" cellpadding="2" align="center"><tr><td width="4%"> 
    			<div align="center"><img src="' . "$global{'imgbase'}" . '/article.gif"></div></td>
    			<td width="57%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">' . "<a href=staff.cgi?do=kb&goto=view&kid=$ref->{'id'}>$ref->{'subject'}</a>" . '</font></td>
    			<td width="29%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">' . "$ref->{'category'}" . '</font></td>
    			<td width="10%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">' . "$pop" . '</font></td>
  				</tr></table>';

		}
		$sth->finish;

       if (!$opencalls) { $opencalls = 'No Results'; }
       $template{'results'}   = $opencalls;
       $template{'bar'}       = $bar;
         parse("$global{'data'}/include/tpl/staff/kb_results");
      

    }


 
 



  if ($goto eq "cat")
   {
	$response .= '<div align=center><font face="Verdana" size="1">[ <a href="staff.cgi?do=kb">KB MAIN</a> | <a href="staff.cgi?do=kb&goto=addcat">ADD CATEGORY</a> ]</font></div><br><br>';

	$statement = 'SELECT * FROM perlDesk_kb_cat'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
		{	
    		$link = "$ref->{'category'}";
     		chomp($link);
     		$link =~ s/ /_/g;	
 			$response .= '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="2%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></td>
    					<td width="28%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Edit KB</font></td>
    					<td width="36%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>' . "$ref->{'category'}" . '</b></font></td><td width="34%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">[ 
      					<a href="staff.cgi?do=kb&goto=editcat&cat=' . "$link" . '">EDIT</a> | <a href="staff.cgi?do=kb&goto=delcat&cat=' . "$link" . '">DELETE</a> ] </font></td></tr></table>';             
		}
	  $sth->finish;
      $template{'response'} = $response;

      parse("$global{'data'}/include/tpl/staff/general");      
   }


  if ($goto eq "delcat")
   {
        $category = $q->param('cat');

		$link     =  $category;
    	$category =~  s/_/ /g;
		$response =  'Are you sure you want to remove this category? Doing so will affect all articles in it. <br><br><a href="staff.cgi?do=kb&goto=ccat&cat=' . "$link" . '">Yes, Delete</a>';
        $template{'response'} = $response;

   parse("$global{'data'}/include/tpl/staff/general");

  }


 if ($goto eq "ccat")
  {
     
       $category = $q->param('cat');
  
    	$category =~ s/_/ /g;
		$statementd = 'DELETE FROM perlDesk_kb_cat WHERE category = "' . "$category" . '";'; 
		$sth = $dbh->prepare($statementd) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	$sth->finish;

		$response = 'Category Removed <a href="staff.cgi?do=kb&goto=cat"> Back to Category Admin</a>';
      $template{'response'} = $response;

   parse("$global{'data'}/include/tpl/staff/general");

 }

   if ($goto eq "editcat")
    {

      $category = $q->param('cat');

      chomp($category);
      $category =~ s/_/ /g;
  	  $response = '<table width="100%" border="0" cellspacing="1" cellpadding="0">
      		    <tr><td colspan="3"><div align="center"></div></td></tr><tr><td colspan="3"><form name="form1" method="post" action="staff.cgi"><table width="100%" border="0" cellspacing="1" cellpadding="0">
                <tr> <td width="4%">&nbsp;</td><td width="28%">&nbsp;</td><td colspan="2" width="68%">&nbsp;</td>
                </tr><tr><td colspan="4"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <input type="hidden" name="old" value="' . "$category" . '">Edit</font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                Category <input type="text" name="department" size="30" value="' . "$category" . '"><input type=hidden name=do value=kb> <input type=hidden name=goto value=upcat><input type="submit" name="Submit" value="Submit"></font></div></td></tr><tr><td colspan="4">&nbsp;</td></tr></table></form></td></tr></table><table width="100%" border="0" cellspacing="1" cellpadding="0"><tr><td></td></tr></table></td></tr></table>';
      $template{'response'} = $response;
 
     parse("$global{'data'}/include/tpl/staff/general");
 

    }


  if ($goto eq "upcat")
  {
		$department = $q->param('department');
		$old = $q->param('old');
		$statementd = 'UPDATE perlDesk_kb_cat SET category = "' . "$department" . '" WHERE  category = "' . "$old" . '";'; 
		$sth = $dbh->prepare($statementd) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	$sth->finish;


	@response = 'Saved <a href="staff.cgi?do=kb&goto=cat">Back to Categories</a>';

	open (IN, "$global{'data'}/include/tpl/staff/general.tpl") ||
				 die "Unable to open: $!";
	while (<IN>) {
			if ($_ =~ /\{*\}/i) {
				s/\{response\}/@response/i;					
			}
		push (@content, $_);
		} 		
	close (IN);

	parse_template();
  }


  if ($goto eq "addcat")
   {

	$response = '<form name="form1" method="post" action="staff.cgi"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">KB 
    Category <input type="text" name="adddepartment"><input type=hidden name=do value=kb><input type=hidden name=goto value=savecat><input type="submit" name="Submit" value="Submit">
    </font></div></form>';

    $template{'response'} = $response;

   parse("$global{'data'}/include/tpl/staff/general");

  

   }

  if ($goto eq "savecat")
   {

	my $category = $q->param('adddepartment');
		my $rv = $dbh->do(qq{INSERT INTO perlDesk_kb_cat values (
			"$category")}
		);
    	$response = 'Category Added <a href="staff.cgi?do=kb">Back to KB</a>';
        $template{'response'} = $response;
 parse("$global{'data'}/include/tpl/staff/general");

  }


 

 if ($goto eq "view")
  {

    my $id = $q->param('kid');
 
	$statement = 'SELECT * FROM perlDesk_kb_entries WHERE id = ' . "$id"; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) {	
			$read = $ref->{'views'};
			$author = $ref->{'author'};
			$subject = $ref->{'subject'};
			$description = $ref->{'description'};
			$id = $ref->{'id'};

	}
      $template{'subject'} = $subject;
      $template{'author'} = $author;
      $template{'article'} = $description;
      $template{'read'} = $read;
      $template{'id'} = $id;
      $template{'response'} = $response;

   parse("$global{'data'}/include/tpl/staff/kb_article");
   
  }



 if ($goto eq "addsave")
  {

	$subject     = $q->param('subject');
	$description = $q->param('description');
	$category    = $q->param('select');

	$description =~ s/\"/\\"/g;

	$description =~ s/\n/<br>/g;

	my $rv = $dbh->do(qq{INSERT INTO perlDesk_kb_entries values (
	"NULL", "$category", "$name", "$subject", "$description", "0")}
	);
	$response = 'Thanks, entry added. <a href="staff.cgi?do=kb">KB MAIN</a>';

      $template{'response'} = $response;

   parse("$global{'data'}/include/tpl/staff/general");

  }


 if ($goto eq "delete")
  {

    my $id = $q->param('kid');

	$response = 'Are you sure you want to remove this article? <br><br><a href="staff.cgi?do=kb&goto=cdel&kid=' . "$id" . '">Yes, Delete</a>';
      $template{'response'} = $response;

   parse("$global{'data'}/include/tpl/staff/general");


  }



 if ($goto eq "cdel")
  {

     my $id = $q->param('kid');

 		$statementd = 'DELETE FROM perlDesk_kb_entries WHERE id = "' . "$id" . '";'; 
		$sth = $dbh->prepare($statementd) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		$sth->finish;
		$response = 'Article Removed <a href="staff.cgi?do=kb"> Back to Knowledge Base</a>';
      $template{'response'} = $response;

     parse("$global{'data'}/include/tpl/staff/general");
     
  }


 if ($goto eq "editart")
  {

    my $id = $q->param('kid');

	$statement = 'SELECT * FROM perlDesk_kb_entries WHERE id = ' . "$id"; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) {	
			$read = $ref->{'read'};
			$author = $ref->{'author'};
			$subject = $ref->{'subject'};
			$description = $ref->{'description'};
			$id = $ref->{'id'};
	}

   $template{'subject'}  = $subject; 
   $template{'author'}   = $author;
   $template{'article'}  = $description;
   $template{'response'} = $response;
   $template{'id'}       = $id;

   parse("$global{'data'}/include/tpl/staff/kb_edit");
   
 }


 if ($goto eq "editsave")
  {
       my $id = $q->param('kid');

		$department = $q->param('article');
        $department =~ s/\"/\\"/g;

		$statementd = 'UPDATE perlDesk_kb_entries SET description = "' . "$department" . '" WHERE  id = "' . "$id" . '";'; 
		$sth = $dbh->prepare($statementd) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	$sth->finish;

    $response = 'Saved <a href="staff.cgi?do=kb">Back to Knowledge Base</a>';

    $template{'response'} = $response;

    parse("$global{'data'}/include/tpl/staff/general");
   
  }







 if ((! $goto) || ($goto eq "main"))
  {
    $num = 1;
	$statement = 'SELECT * FROM perlDesk_kb_entries ORDER BY id DESC LIMIT 5'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) {	

		if ($ref->{'views'} > 50) { $pop = "<img src=\"$global{'imgbase'}/hot.gif\">"; } else { $pop = ' '; }
		if ($num eq "2") {
			$bgcol   =   '#FFFFFF';
			$num = 0;
		} else {
			$bgcol   =   '#F0F0F0';
		}

		$kb .= '<tr><td width="5%" bgcolor = "' . "$bgcol" . '"><div align="center"><img src="' . "$global{'imgbase'}" . '/article.gif"></div></td>
    	<td width="66%" bgcolor = "' . "$bgcol" . '"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">' . "<a href=staff.cgi?do=kb&goto=view&kid=$ref->{'id'}>$ref->{'subject'}</a>" . '</font></td>
    	<td width="29%" bgcolor = "' . "$bgcol" . '"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">' . "$ref->{'category'}" . '</font></td>
    	</tr>';
	$num++;
	}

	$statement = 'SELECT category FROM perlDesk_kb_cat'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
          {	
	    		$list .= "<option value=\"$ref->{'category'}\">$ref->{'category'}</option>";
	      }
	$sth->finish;

   $template{'category'} = $list;
   $template{'list'}     = $kb;
   parse("$global{'data'}/include/tpl/staff/kb");
   
 }
  }


#~~ 
# End Knowledge Base Administration
#~~




#~~ 
# Staff Messaging System
#~~


if ($section eq "messanger")
 {
       check_user(); 
       print "Content-type: text/html\n\n";

       $too = $q->param('to');

   if ($too eq "reply") {
   
    $msg = $q->param('id');

    $statemente = 'SELECT * FROM perlDesk_messages WHERE id = ?'; 
	$sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
    $sth->execute($msg) or die print "Couldn't execute statement: $DBI::errstr; stopped";
      while(my $ref = $sth->fetchrow_hashref())
         {
	        $from    =  $ref->{'sender'};
		$subject =  $ref->{'subject'};    
         }

	open (IN, "$global{'data'}/include/tpl/staff/msgreply.tpl") ||
   			                                        	 die "Unable to open: $!";
	while (<IN>) {
			if ($_ =~ /\{*\}/i) 
                          {
				s/\{username\}/$Cookies{'staff'}/i;	
				s/\{touser\}/$from/ig;				
			  }
		  print $_;
		} 		
	close (IN);

}


if ($too eq "delete") {

    $msg = $q->param('id');


      $statemente = 'SELECT * FROM perlDesk_messages WHERE id = "' . "$msg" . '"'; 
      $sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
      $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
        while(my $ref = $sth->fetchrow_hashref()) 
           {
		if ($ref->{'touser'} ne $Cookies{'staff'}) { print 'This is not your message to delete'; exit; } 
	   }


       execute_sql(qq|DELETE FROM perlDesk_messages WHERE id = "$msg"|); 


      $statemente = "SELECT * FROM perlDesk_messages WHERE touser = \"$Cookies{'staff'}\" ORDER BY id DESC"; 
      $sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
      $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
      while(my $ref = $sth->fetchrow_hashref())
         {
		$message = '<tr bgcolor="#F1F1F8"><td width="7%"><font face="Verdana" size="1">' . "$ref->{'id'}" . '</font></td> <td width="26%"><font face="Verdana" size="1">' . "$ref->{'sender'}" . '</font></td>
                            <td width="28%"><font face="Verdana" size="1">' . "$ref->{'date'}" . '</font></td><td width="39%"><font face="Verdana" size="1">' . "<a href=\"staff_messanger.pl?action=view&id=$ref->{'id'}\">$ref->{'subject'}</font></a>" . '</td></tr>';

			push @messages, $message;
         }


	open (IN, "$global{'data'}/include/tpl/staff/inbox.tpl") ||
				 die "Unable to open: $!";
	while (<IN>) {
			 if ($_ =~ /\{*\}/i) {	s/\{messages\}/@messages/i;	}
    	 	         print $_;
		     }   		

	$dbh->disconnect;
exit;
}



if ($too eq "inbox") {

    $statemente = "SELECT * FROM perlDesk_messages WHERE touser = \"$Cookies{'staff'}\" ORDER BY id DESC"; 
    $sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
    $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
      while(my $ref = $sth->fetchrow_hashref()) 
        {
			$message = '<tr bgcolor="#F1F1F8"><td width="7%"><font face="Verdana" size="1">' . "$ref->{'id'}" . '</font></td> <td width="26%"><font face="Verdana" size="1">' . "$ref->{'sender'}" . '</font></td>
                                    <td width="28%"><font face="Verdana" size="1">' . "$ref->{'date'}" . '</font></td><td width="39%"><font face="Verdana" size="1">' . "<a href=\"staff.cgi?do=messanger&to=view&id=$ref->{'id'}\">$ref->{'subject'}</font></a>" . '</td></tr>';
			push @messages, $message;
        }

	$current_time = time();

        execute_sql(qq|UPDATE perlDesk_staffread SET date = "$current_time" WHERE username = "$Cookies{'staff'}"|); 

	open (IN, "$global{'data'}/include/tpl/staff/inbox.tpl") ||
				 die "Unable to open: $!";
	while (<IN>) {
			if ($_ =~ /\{*\}/i) {
				s/\{messages\}/@messages/i;					
			}
		print $_;
		} 		
	close (IN);
 }

 if ($too eq "view") 
  {

    $msg = $q->param('id');
    $statemente = 'SELECT * FROM perlDesk_messages WHERE id = "' . "$msg" . '"'; 
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

	if ($to ne $Cookies{'staff'}) { print 'This is not your message'; exit; }

   open (IN, "$global{'data'}/include/tpl/staff/msgview.tpl") ||
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

if ($too eq "compose") {

 $statemente = 'SELECT username FROM perlDesk_staff WHERE username != "' . "$Cookies{'staff'}" . '"'; 
	$sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
    $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
      while(my $ref = $sth->fetchrow_hashref()) {
			$ddopt = "<option value=\"$ref->{'username'}\">$ref->{'username'}</option>";
			push @dd, $ddopt;

	 }

	if (not @dd) { @dd = '<option value="">No Other Users</option>'; }



	open (IN, "$global{'data'}/include/tpl/staff/msgcompose.tpl") ||
				 die "Unable to open: $!";
	while (<IN>) {
			if ($_ =~ /\{*\}/i) {
				s/\{ddlist\}/@dd/i;	
				s/\{username\}/$Cookies{'staff'}/i;				
			}
		print $_;
		} 		
	close (IN);
 }

if ($too eq "savenote") {


  $from = $Cookies{'staff'};
  $to   = $q->param('user');

 $subject = $q->param('subject');
 $message = $q->param('message');

 $statemente = 'SELECT * FROM perlDesk_staff WHERE username = "' . "$to" . '"'; 
	$sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
    $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
      while(my $ref = $sth->fetchrow_hashref()) {
 			$valid = $ref->{'name'};
	 }

	if (!$valid) 
      {
		print "<div align=\"center\"><font face=\"Verdana\" size=\"2\"><br><b>Sorry,</b> user does not exist on this system <a href=\"javascript:history.back(1)\">Back</a></div>";
     	$dbh->disconnect;	
      	exit;
  	  }

	$current_time =   time();
	$message      =~  s/\"/\\"/g;

       die_nice("No Subject Specified") if !$subject;

    my $rv = $dbh->do(qq{INSERT INTO perlDesk_messages values (
         	"NULL", "$to", "$from", "$hdtime", "$subject", "$message", "$current_time")}
	);

	print "<div align=\"center\"><font face=\"Verdana\" size=\"2\"><br>Message has been sent to \'$to\' - Back to <a href=\"staff.cgi?do=messanger&to=inbox\">Inbox</a></font></div>";

	$dbh->disconnect;	
  exit;
 }
}

#~~
# Delete Ticket
#~~

if ($section eq "delete")
 {
     check_user(); 
     print "Content-type: text/html\n\n";

    $callid = $q->param('cid');
    $statemente = 'SELECT * FROM perlDesk_settings WHERE setting = "sdelete"'; 
    $sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
    $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	     while(my $ref = $sth->fetchrow_hashref()) 
		{
				if (!$ref->{'value'}) 
				{
						print "<br><font face=Verdana size=2><div align=Center>Sorry. The administrator has removed delete access for staff members</div></font>";
						exit;
				}
		}

    $template{'response'} = "<b>Delete Request $callid?</b><br><br><a href=\"staff.cgi?do=confirmdel&cid=$callid\">Yes, delete.</a>";
   parse("$global{'data'}/include/tpl/staff/general");

}



if ($section eq "confirmdel") {

    check_user(); 
    print "Content-type: text/html\n\n";

  $callid = $q->param('cid');

	if ($accesslevel !~ /GLOB::/) {
	$statemente = 'SELECT category FROM perlDesk_calls WHERE id = ?'; 
	$sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute($callid) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	    while(my $ref = $sth->fetchrow_hashref()) {
		  if ($accesslevel =~ /$ref->{'category'}::/) {
					# OK
          } else {
            print "You do not have permission to delete this call.";
            exit;
          }
		}
	}
	$statemente = 'SELECT * FROM perlDesk_settings WHERE setting = "sdelete"'; 
	$sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	      while(my $ref = $sth->fetchrow_hashref()) 
		    {
		 		if (!$ref->{'value'}) 
				{
						print "You do not have permission to delete this call.";
						exit;
				}
		    }

	 $statement = 'DELETE FROM perlDesk_calls WHERE id = ?'; 
	 $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 			$sth->execute($callid) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	 $statement = 'DELETE FROM perlDesk_notes WHERE call = ?'; 
	 $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 			$sth->execute($callid) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	$response = "<b>Request Deleted</b> <a href=staff.cgi?do=listcalls&status=open>Back to Open calls</a>";
    $template{'response'} = $response;
     parse("$global{'data'}/include/tpl/staff/general");


}


#~~
# Staff Profile
#~~

 if ($section eq "profile")
 {

   $goto = $q->param('goto');

 if (! $goto) 
   { 
    check_user();
    print "Content-type: text/html\n\n";
	$statement = 'SELECT * FROM perlDesk_staff WHERE username = "' . "$Cookies{'staff'}" . '";'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	   while(my $ref = $sth->fetchrow_hashref()) {
	            $sig = $ref->{'signature'};

                    $template{'snd'} = "checked" if  $ref->{'play_sound'};
                    $template{'snd'} = ""        if !$ref->{'play_sound'};

                    $template{'ncheck'} = "checked" if  $ref->{'notify'};
                    $template{'ncheck'} = ""        if !$ref->{'notify'};


	   }
	$statement = 'SELECT * FROM perlDesk_preans WHERE author = "' . "$Cookies{'staff'}" . '";'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	   while(my $ref = $sth->fetchrow_hashref()) {
	        $ddmenu .= ' <option value="staff.cgi?do=profile&goto=editpre&value=' . "$ref->{'id'}" . '">' . "$ref->{'subject'}" . '</option>';

	}

  $template{'preans'}   = $ddmenu;
  $template{'sig'}      = $sig;

   parse("$global{'data'}/include/tpl/staff/profile");


}

if ($goto eq "updateprofile")
  {
    check_user();
    print "Content-type: text/html\n\n";
       $name  = $q->param('name');
       $email = $q->param('email');
       $pass1 = $q->param('pass1');
       $pass2 = $q->param('pass2');
       $notify = $q->param('notify');
       $sound  = $q->param('sound');

     if ($notify eq "yes") { $notif = 1; } else { $notif = 0; }

     if (!$name) 
     	{
       		$error = "You have not entered your name";
       		push (@errors, $error);
     	} elsif (!$email) {
       		$error = "Please enter your email address";
       		push(@errors,$error);
    	} elsif ($pass1 ne $pass2) {
      		$error = "The passwords specified do not match";
       		push(@errors,$error);
     	}
	 
     if (@errors) 
    	{
			print "Content-type: text/html\n\n";
			print @errors;
      		$dbh->disconnect;
          exit;	
    	}


	my @chars=("a..z","A..Z","0..9",'.','/');
	my $salt= $chars[rand(@chars)] . $chars[rand(@chars)];
	
	$cpass = crypt($pass1, $salt);
	$sig = $q->param('sig');

	$statemente = 'SELECT * FROM perlDesk_staff WHERE username = "' . "$Cookies{'staff'}" . '";'; 
	$sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 			$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		      while(my $ref = $sth->fetchrow_hashref()) {
		if ($ref->{'password'} ne $cpass) {
		if ($pass1 && $pass2) {
		if ($pass1 ne $pass2) {
			$error = "Error, Passwords entered do not match";
			push (@errors, $error);
		}
	else 
	{
		$statement = 'UPDATE perlDesk_staff SET play_sound = "' . $sound . '", name = "' . "$name" . '", email = "' . "$email" . '", password = "' . "$cpass" . '", rkey = "' . "$salt" . '", notify = "' . "$notif" . '", signature = "' . "$sig" . '" WHERE username = "' . "$Cookies{'staff'}" . '";'; 
	}
	} else 
	{
		$statement = 'UPDATE perlDesk_staff SET play_sound = "' . $sound . '", name = "' . "$name" . '", email = "' . "$email" . '", notify = "' . "$notif" . '", signature = "' . "$sig" . '" WHERE username = "' . "$Cookies{'staff'}" . '";'; 
	}
		}	}
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";

        print qq|	<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=staff.cgi?do=profile"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank you, profile updated</b></font><br><br>
       			<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?do=profile">click 
  			here</a> if you are not automatically forwarded</font></p></html>
                |;
 }



if ($goto eq "add_pre") {

    check_user();
    print "Content-type: text/html\n\n";

   parse("$global{'data'}/include/tpl/staff/predef");


 }



if ($goto eq "addpredef") {
check_user();
print "Content-type: text/html\n\n";

	if ((defined $q->param('subject')) && (defined $q->param('content'))) {

	$subject  =  $q->param('subject');
	$comments =  $q->param('content');

	$subject  =~ s/\"/\\"/g;
	$comments =~ s/\"/\\"/g;

		my $rv = $dbh->do(qq{INSERT INTO perlDesk_preans values (
			"NULL", "$Cookies{'staff'}", "$subject", "$comments", "$hdtime")}
		);
	} else {
		print 'Please enter all the fields';
		exit;
	}

	$response = "<font face=Verdana size=2>Thank you.<br><br> Your answer template has been added.</font>";
    $template{'response'}   = $response;

  parse("$global{'data'}/include/tpl/staff/general");


}


if ($goto eq "editpre") {

 check_user();
 print "Content-type: text/html\n\n";

  $id = $q->param('value');
 
 	$statemente = 'SELECT * FROM perlDesk_preans WHERE id = "' . "$id" . '";'; 
	$sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 			$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		      while(my $ref = $sth->fetchrow_hashref()) {
					$subject = $ref->{'subject'};
					$content = $ref->{'text'};
 			  }
   
    $template{'id'}      = $id;
    $template{'subject'} = $subject;
    $template{'content'} = $content;

    parse("$global{'data'}/include/tpl/staff/editpre");
   
 }


if ($goto eq "del_pre") {

 check_user();
 print "Content-type: text/html\n\n";

  $id = $q->param('value');
    
    execute_sql(qq|DELETE FROM perlDesk_preans WHERE id = "$id"|);

        print qq|	<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=staff.cgi?do=profile"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank you, response deleted</b></font><br><br>
       				<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?do=profile">click 
  					here</a> if you are not automatically forwarded</font></p></html>
                |;

 }


if ($goto eq "editsave")
 {
  check_user();
  print "Content-type: text/html\n\n";

	$id      = $q->param('id');
	$subject = $q->param('subject');
	$content = $q->param('content');

	$subject =~ s/\"/\\"/g;
	$content =~ s/\"/\\"/g;

	$statement = 'UPDATE perlDesk_preans SET subject = "' . "$subject" . '", text = "' . "$content" . '" WHERE id = "' . "$id" . '";'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";

	$response              = "<font face=Verdana size=2>Thank you.<br><br> Your answer template has been saved.</font>";
    $template{'response'}  = $response;

    parse("$global{'data'}/include/tpl/staff/general");
    
 }


}




#~~
# Claim Ownership of a ticket
#~~

if ($section eq "own") {

    check_user(); 
    print "Content-type: text/html\n\n";
    $callid = $q->param('cid');
	if ($accesslevel !~ /GLOB::/) 
	{
	 $statemente = 'SELECT category FROM perlDesk_calls WHERE id = ?'; 
	 $sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute($callid) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	while(my $ref = $sth->fetchrow_hashref()) 	
	{
			if ($accesslevel !~ /$ref->{'category'}::/) 
				{
						print "You do not have permission to view this call.";
						exit;
				}
		}
	}
	$response = "<div align=\"left\"><b>Claim ownership of request ID $callid?</b><br>Claiming ownership of this call will alert other techs that this call is being worked on by yourself.<br><br><a href=\"staff.cgi?do=claim&cid=$callid\">Claim Ownership</a></div>";
	    $template{'response'} = $response;
    parse("$global{'data'}/include/tpl/staff/general");
   
}


if ($section eq "claim") {

    check_user(); 
    print "Content-type: text/html\n\n";

       $cid  = $q->param('cid');

        execute_sql(qq|UPDATE perlDesk_calls SET ownership = "$Cookies{'staff'}" WHERE id = "$cid"|); 
        my $sdsth = $dbh->prepare( "INSERT INTO perlDesk_activitylog VALUES ( ?, ?, ?, ?, ?)" );
           $sdsth->execute( "NULL", $cid, $hdtime, "Staff: $Cookies{'staff'}", "$Cookies{'staff'} Claimed Ownership" ) or die "Couldn't execute statement: $DBI::errstr; stopped";

        print qq|	<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=staff.cgi?do=ticket&cid=$cid"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank you, you have claimed this ticket</b></font><br><br>
       			<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?do=ticket&cid=$cid">click 
  			here</a> if you are not automatically forwarded</font></p></html>
                |;


}




#~~
# View Reviews
#~~

 if ($section eq "view_review")
  {
    check_user(); 
    print "Content-type: text/html\n\n";

       my $nid    = $q->param('nid');

    if ($nid)
     {
 	$statemente = 'SELECT id,author,comment,call FROM perlDesk_notes WHERE id = ?'; 
	$sth = $dbh->prepare($statemente)  or die "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute( $nid ) or die "Couldn't execute statement: $DBI::errstr; stopped";
	      while(my $ref = $sth->fetchrow_hashref()) 
                {    
                      $author              = $ref->{'author'};
                      $template{'comment'} = $ref->{'comment'};
                      $template{'id'}      = $ref->{'id'};
                      $template{'cid'}     = $ref->{'call'};
                }


         $statement = 'SELECT name FROM perlDesk_staff WHERE id = ?'; 
         $th = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$th->execute($author) or die print "Couldn't execute statement: $DBI::errstr; stopped";
         	  while(my $f = $th->fetchrow_hashref()) 
	            {  $template{'author'} = $f->{'name'}; }
                         


 	$statemente = 'SELECT * FROM perlDesk_reviews WHERE nid = ?'; 
	$sth = $dbh->prepare($statemente)  or die "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute( $nid ) or die "Couldn't execute statement: $DBI::errstr; stopped";
	      while(my $ref = $sth->fetchrow_hashref()) 
                {   
                      $template{'rating'} = $ref->{'rating'};
                      $template{'user'}   = $ref->{'owner'};
                      $template{'review'} = $ref->{'comments'} || "No Review Given";
                }

     }

   parse("$global{'data'}/include/tpl/staff/view_review");

  }


#~~
# Download File Attachment
#~~

if ($section eq "view_file")
  {
     check_user();

         $file = $q->param('id');

	my $statement = 'SELECT filename, file FROM perlDesk_files WHERE id = ?'; 
		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute( $file ) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
		   { $name = $ref->{'filename'}; $filename = $ref->{'file'}; }

     print qq~Content-Disposition: attachment; filename="$name"\n~;
     print "Content-Type: application/octet-stream\n\n";
      
   if (defined $file && $file ne "") 
     { 
         open(LOCAL, "<$filename") or die $!;
           while(<LOCAL>)
             {
                print;
             }
          close(LOCAL);
     }
  }


#~~
# View a Ticket
#~~

if ($section eq "ticket")
 {
    check_user(); 
    print "Content-type: text/html\n\n";

    my $trackedcall =  $q->param('cid');
       $statement   = 'SELECT * FROM perlDesk_calls WHERE  id = ? ORDER BY id'; 
       $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute($trackedcall) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		$number=0;
			  while(my $ref = $sth->fetchrow_hashref()) 
				{	
					if (($accesslevel =~ /$ref->{'category'}::/) || ($accesslevel =~ /GLOB::/)) 
					{
						$template{'trackno'}     =   $ref->{'id'};
						$template{'date'}        =   $ref->{'time'};
						$template{'uname'}       =   $ref->{'username'};						
                                                $template{'uname'}       =   $ref->{'username'};
						$template{'username'}    =   $ref->{'username'};
						$template{'priority'}    =   $ref->{'priority'};
						$template{'status'}      =   $ref->{'status'};
						$template{'subject'}     =   $ref->{'subject'};
						$template{'category'}    =   $ref->{'category'};
						$template{'description'} =   $ref->{'description'};
						$template{'owned'}       =   $ref->{'ownership'};
						$template{'number'}      =   0;
			  			$template{'email'}       =   $ref->{'email'};
						$template{'url'}         =   $ref->{'url'};
						$template{'name'}        =   $ref->{'name'};
                                                $template{'time_spent'}  =   $ref->{'time_spent'} || "0";

					} else {
        	   			    	   $error= 'You do not have permission to view this call';
         	                	           push @errors, $error;
        	                               }								
			}
	if (@errors) 
	{
   		print @errors;
   		exit;
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
                        my $value = $ef->{'value'}; 
                           $value = '&nbsp;' if !$value;

                        $template{'fields'} .= qq|
                                                    <tr> <td width="19%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'name'}</font></td>
                                                    <td width="72%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">$value</font> </td></tr>
                                                 |;    
                   }
      }
    $sth->finish;

   $template{'fields'} = '' if !$template{'fields'};


	my $statement = 'SELECT id, cid, filename, file FROM perlDesk_files WHERE cid = ?'; 
		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute( $trackedcall ) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
		   {
                       $template{'filename'} = qq|<a href="staff.cgi?do=view_file&id=$ref->{'id'}">$ref->{'filename'}</a>|;
		   }

              if ($sth->rows == "0") { $template{'filename'} = qq|No File|; }
  
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
 
        $rating = "";     
        $body   = $ref->{'comment'};
        $body   = pdcode("$body");


    my $tatement = 'SELECT * FROM perlDesk_files WHERE nid = ?'; 
    my $h = $dbh->prepare($tatement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
       $h->execute($ref->{'id'}) or die print "Couldn't execute statement: $DBI::errstr; stopped";
    while(my $ef = $h->fetchrow_hashref()) 
      {	
           $filename = qq|<a href=staff.cgi?do=view_file&id=$ef->{'id'}>$ef->{'filename'}</a>|;
      }
    if ($h->rows == "0") { $filename = "No File Attached"; }


	if ($body =~ /^</) {	} else 
         {
    		$body =~ s/\n/<br>/g;
         }

	if ($ref->{'owner'} == "0") 
			{
				$notes .= '<tr><td width="30%" height="14" valign="top" bgcolor="#F2F2F2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>' . "$ref->{'author'}<br><i>$ref->{'poster_ip'}</i>" . '<br>
   				           </b></font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . "$ref->{'time'}" . '<br><br><a href="staff.cgi?do=editnote&nid=' . "$ref->{'id'}" . '">Edit Response</a> </font></td>
   					   <td width="70%" height="14" valign="top" bgcolor="#F2F2F2"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . "$body" . '</font></td></tr>';
			} 

	if ($ref->{'owner'} == "3") 
			{
                                           $statement = 'SELECT name FROM perlDesk_staff WHERE id = ?'; 
                                           $th        = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	                                   $th->execute($ref->{'author'}) or die print "Couldn't execute statement: $DBI::errstr; stopped";
         	                               while(my $f = $th->fetchrow_hashref()) {  $s_name = $f->{'name'}; }

 	     			           $notes .= '<tr><td width="30%" height="14" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>' . "$s_name<br><i>$ref->{'poster_ip'}</i>" . '<br>
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

					   $notes .= qq|<tr><td width="30%" height="14" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>$s_name<br><i>$ref->{'poster_ip'}</i><br>
   						        </b></font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">$ref->{'time'}<br><br>User Rating: $rating<br><br><br><a href="staff.cgi?do=editnote&nid=$ref->{'id'}">Edit Response</a> </font></td>
   						        <td width="70%" height="14" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">$notice $body<br><Br><br><br>-------------<br>$filename</font></td></tr>|;
			}
			
		}
	
	if ($template{'description'} =~ /^</) {	} else 
          {
	 	# This is a Text Email, format it!
	    	$template{'description'} =~ s/\n/<br>/g;
	  }
  
    $template{'notes'}    =  $notes;

   parse("$global{'data'}/include/tpl/staff/viewticket");
    

  }


#~~
# View all tickets by a certain user
#~~

if ($section eq "listbyuser") {

       check_user(); 
       print "Content-type: text/html\n\n";

    $userview = $q->param('user');

	if ($accesslevel =~ /GLOB::/) {	$statement = qq|SELECT * FROM perlDesk_calls WHERE username = "$userview" ORDER BY id|;  }
     else 
      {		
             @access =  split(/::/, $accesslevel);
             $ac     =  0;
           foreach $dep (@access) { $ac++; }
             $statement = qq|SELECT * FROM perlDesk_calls WHERE username = "$userview" AND |;
             $i         = 1;
           foreach $dep (@access) 
            {
               $dep        =~ s/^\s+//g;
               $statement .= qq|category = "$dep" |;

               if ($i < $ac) { $statement .= 'OR '; } 
                  $i++;
            }
            $statement .= qq| ORDER BY id|;
      }

  	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
    $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		$number=0;
			  while(my $ref = $sth->fetchrow_hashref()) 
				{			
					if (($accesslevel =~ /$ref->{'category'}::/) || ($accesslevel =~ /GLOB::/)) {
						$number++;
						$subject="$ref->{'subject'}"; 
						$subject=substr($subject,0,20).'..' if length($subject) > 22;
					if ($ref->{'priority'} eq 1) { $font = '#000000'; } else { $font = '#000000'; }			

						$call .= '<table width="100%" border="0" cellpadding="4"><tr bgcolor="#E4E7F8"> 
    						<td width="4%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="' . "$global{'imgbase'}/ticket.gif" . '"></font></td>
	   						<td width="4%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color=' . "$font> $ref->{'id'}" . '</font></td>
   							<td width="23%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color=' . "$font>$ref->{'name'}" . '</font></td>
    						<td width="30%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color=' . "$font>" . '<a href="staff.cgi?do=ticket&cid=' . "$ref->{'id'}\">$subject" . '</a></font></td>
   							<td width="10%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color=' . "$font>$ref->{'status'}" . '</font></td>  							<td width="24%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color=' . "$font>$ref->{'time'}" . '</font></td></tr></table>';
				}
	  }

    $template{'listcalls'} = $call;
    $template{'customer'}  = $userview;    

    parse("$global{'data'}/include/tpl/staff/viewbyuser");
  }


#~~
# Log a Ticket
#~~

  if ($section eq "log") 
   {
       check_user(); 
       print "Content-type: text/html\n\n";

    my $statement = 'SELECT * FROM perlDesk_ticket_fields'; 
    my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
       $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
    while(my $ref = $sth->fetchrow_hashref()) 
      {	
          $template{'form'} .= qq|<tr><td width="19%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'name'}</font></td><td width="72%"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                  <input type="text" style="font-size: 12px" name="$ref->{'id'}" size="35"></font></td></tr>
                                 |;
      }
    $sth->finish;

     $statement = 'SELECT level FROM perlDesk_departments'; 
    	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
    	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
       while(my $ref = $sth->fetchrow_hashref()) 
        {	
    		$list .= "<option value=\"$ref->{'level'}\">$ref->{'level'}</option>";
        }
    	$sth->finish;

     $template{'username'} = $q->param('user');
     $template{'email'}    = $q->param('email');
     $template{'category'} = $list;

   parse("$global{'data'}/include/tpl/staff/newcall");

  }


if ($section eq "logsave") {


       check_user(); 
       print "Content-type: text/html\n\n";

    if (defined $q->param('username') && $q->param('username') ne "") 
     {
    	$username   =  $q->param('username');
    	$statemente =  'SELECT * FROM perlDesk_users WHERE username = ?'; 
    	$sth        =  $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
    	$sth->execute($username) or die print "Couldn't execute statement: $DBI::errstr; stopped";
    	while(my $ref = $sth->fetchrow_hashref()) 
 		 {
			$name   =  $ref->{'name'};
			$email  =  $ref->{'email'};
                     	$url    =  $ref->{'url'};
		 }
     } else {
                $statement = 'SELECT * FROM perlDesk_ticket_fields WHERE (name = "email" OR name = "e-mail" OR name = "e mail") LIMIT 1'; 
                $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
                $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
                while(my $ref = $sth->fetchrow_hashref()) 
                 {	
                      $email = $q->param($ref->{'id'});
                 }


                $statement = 'SELECT * FROM perlDesk_ticket_fields WHERE name = "name" LIMIT 1'; 
                $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
                $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
                while(my $ref = $sth->fetchrow_hashref()) 
                 {	
                      $name = $q->param($ref->{'id'});
                 }
	           $url        =  $q->param('url');
	           $username   =  "Call-Center";
           }

	$subject      =   $q->param('subject');
	$description  =   $q->param('description');
	$priority     =   $q->param('priority');
	$category     =   $q->param('category');

   if ($q->param('subject')) 
    {
         $current_time = time();
	
      my @chars =  (A..Z);
         $key   =  $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)];
        
             my $sth = $dbh->prepare( "INSERT INTO perlDesk_calls VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)" );
                $sth->execute( "NULL", "OPEN", $username, $email, $priority, $category, $subject, $description, $hdtime, "Unowned", "NULL", "cc", $current_time, $current_time, "1", "0", "0", "0", "$key" );

  	   $callid    =  $dbh->{'mysql_insertid'};

   my $sdsth = $dbh->prepare( "INSERT INTO perlDesk_activitylog VALUES ( ?, ?, ?, ?, ?)" );
      $sdsth->execute( "NULL", $callid, $hdtime, "Staff: $Cookies{'staff'}", "Request Logged" ) or die "Couldn't execute statement: $DBI::errstr; stopped";

 
    my $statement = 'SELECT * FROM perlDesk_ticket_fields ORDER BY dorder'; 
    my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
       $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
    while(my $ref = $sth->fetchrow_hashref()) 
      {	
         my $fid = $ref->{'id'};
         my $sth = $dbh->prepare( "INSERT INTO perlDesk_call_fields VALUES ( ?, ?, ?, ? )" ) or die $DBI->errstr;
            $sth->execute( "NULL", $callid, "$fid", $q->param($fid) ) or die $DBI->errstr;              
      }
    $sth->finish;

    if ($enablemail && $q->param('email_user') == "1") 
     {
                        my $body;
			open (MAILNEWTPL,"$global{'data'}/include/tpl/newticket.txt");
				while (<MAILNEWTPL>) {
                                  lang_parse() if $_ =~ /%*%/;
				  if ($_ =~ /\{*\}/i) 
                                    { 
     					s/\{baseurl\}/$global{'baseurl'}/g;
    					s/\{name\}/$name/g;
    					s/\{subject\}/$subject/g;
    					s/\{key\}/$key/g;
    					s/\{mainfile\}/$template{'mainfile'}/g;
    					s/\{description\}/$description/g;
                     	                s/\{lang\}/$language/g;
    					s/\{date\}/$hdtime/g;
    					s/\{id\}/$callid/g;
    			            }			
                		$body .= "$_";
        		  }
           	close(MAILNEWTPL);

        my $subject = "\{$global{'epre'}-$callid\} Help Desk Submission";
           email ( To => "$email", From => "$global{'adminemail'}", Subject => "$subject", Body => "$body" );
      }	


  	 } else {
                   $response             =  '<font face=Verdana size=2>Please enter the required fields.</font>';
                   $template{'response'} =  $response;

                   parse("$global{'data'}/include/tpl/staff/general");
               exit;
           }

      $response              =  "Your call has been logged and assigned.";
      $template{'response'}  =  $response;
   parse("$global{'data'}/include/tpl/staff/general");
 }

#~~
# Lookup a username
#~~
 
  if ($section eq "lookup") {

       check_user(); 
       print "Content-type: text/html\n\n";

      parse("$global{'data'}/include/tpl/staff/lookup");


  }


 if ($section eq "lookupresults") {

    check_user(); 
    print "Content-type: text/html\n\n";

  $field   =   $q->param('select');
  $query   =   $q->param('query');

	push @html, "<div align=left><font face=Verdana size=2><b>USER LOOKUP</b></font><br><br></div>";

	$statemente = 'SELECT name,username,email FROM perlDesk_users WHERE ' . "$field" . ' LIKE "%' . "$query" . '%"'; 
	$sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	while(my $ref = $sth->fetchrow_hashref()) 
		{
			  $user .= qq|<table width="90%" border="0" cellpadding="3" align="center"><tr><td width="40%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'name'}</font></td>
                    	<td width="60%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">[ <a href="staff.cgi?do=log&user=$ref->{'username'}&email=$ref->{'email'}">LOG A CALL 
                     	ON BEHALF OF THIS USER</a>]</font></td></tr></table>|;
		}

	if ($sth->rows == "0") { $user  = '<br><div align="center"><font face="Verdana" size="2"><b>Sorry</b>, there were no results matching your query.</font></div>'; } 

   $template{'response'} = $user;
    parse("$global{'data'}/include/tpl/staff/general");
 


  }

if ($section eq "editnote") {

       check_user(); 
       print "Content-type: text/html\n\n";

    $noteid = $q->param('nid');

	$statemente = 'SELECT * FROM perlDesk_notes WHERE id = "' . "$noteid" . '";'; 
	$sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		   while(my $ref = $sth->fetchrow_hashref()) 
			{
				$response= '<table width="100%" border="0"><tr><td><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Edit Note 
				[Call ID: ' . "$ref->{'call'}" . ']</b><BR><BR></font></td></tr><tr><td><form name="form1" method="post" action="staff.cgi">
				<table width="100%" border="0"><tr><td width="29%" height="20" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">EDIT 
				NOTE</font></td><td width="71%" height="20"><textarea name="comment" cols="50" rows="10">' . "$ref->{'comment'}" . '</textarea>
				</td></tr><tr><td colspan="2"><div align="center"><input type="hidden" name="do" value="editnotesave"><input type="hidden" name="ticket" value="' . "$ref->{'call'}" . '"><input type="hidden" name="note" value="' . "$ref->{'id'}" . '">
				<input type="submit" name="seditnote" value="Submit"></div></td></tr></table></form>';
			}
      $template{'response'}       = $response;
    parse("$global{'data'}/include/tpl/staff/general");


 }






if ($section eq "update_list_calls")
 {
     check_user();

     my $status = $q->param('status');
     my $action = $q->param('action_call');
 

   if ($action eq "delete") 
     { 
           @checkbx = $q->param('ticket_check');  
           for ( @checkbx )
             {
                  die_nice("The administrator has removed staff deletion access") if $global{'sdelete'} == "0";
                  $dbh->do(qq|DELETE FROM perlDesk_calls WHERE id = "$_"|);          
             }
              if ($status eq "main") { $surl = "staff.cgi?do=main"; } else { $surl = "staff.cgi?do=listcalls&status=$statys"; }
         

                print "Content-type: text/html\n\n";
		print qq|
			    <html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=$surl"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Ticket List Updated</b>, you are now being taken back to the listings.</font><br><br>
			    <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="$surl">click 
			    here</a> if you are not automatically forwarded</font></p></html>
                        |;
     } 



    if ($action eq "own")
      {
           @checkbx = $q->param('ticket_check');  
           for ( @checkbx )
             {
                  $dbh->do(qq|UPDATE perlDesk_calls SET ownership = "$Cookies{'staff'}" WHERE id = "$_"|); 

               my $sdsth = $dbh->prepare( "INSERT INTO perlDesk_activitylog VALUES ( ?, ?, ?, ?, ?)" );
                  $sdsth->execute( "NULL", $_, $hdtime, "Staff $Cookies{'staff'}", "$Cookies{'staff'} Claimed Ownership" ) or die "Couldn't execute statement: $DBI::errstr; stopped";

         
             }

              if ($status eq "main") { $surl = "staff.cgi?do=main"; } else { $surl = "staff.cgi?do=listcalls&status=$statys"; }
         

                print "Content-type: text/html\n\n";
		print qq|
			    <html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=$surl"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Ticket List Updated</b>, you are now being taken back to the listings.</font><br><br>
			    <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="$surl">click 
			    here</a> if you are not automatically forwarded</font></p></html>
                        |;

      }


   if ($action eq "respond") 
     { 
           @checkbx = $q->param('ticket_check');  
           for ( @checkbx )
             {  $template{'hidden'} .= qq|<input type=hidden name=ticket_check value=$_>\n|; }
  
         print "Content-type: text/html\n\n";
         parse("$global{'data'}/include/tpl/staff/mass_respond");

    }

 }


if ($section eq "refresh_calls")
 {
     check_user();
     print "Content-type: text/html\n\n";

     my $status   = $q->param('status');
     my $comments = $q->param('comments');
        $mstatus  = "open"   if $status eq "OPEN";
        $mstatus  = "closed" if $status eq "CLOSED";

           @checkbx = $q->param('ticket_check');  
           for ( @checkbx )
             { 

      my @chars =  ("A..Z","0..9","a..z");
         $key   =  $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)];
         
                     $dbh->do(qq|UPDATE perlDesk_calls SET status = "$status", closedby = "$Cookies{'staff'}" WHERE id = "$_"|) if $status eq "CLOSED";
                     $dbh->do(qq|UPDATE perlDesk_calls SET status = "$status" WHERE id = "$_"|) if $status ne "CLOSED";
         	     $rv = $dbh->do(qq{INSERT INTO perlDesk_notes values (
     	                    "NULL", "1", "1", "$status", "$_", "$staff_id", "$hdtime", "$key", "$comments", "$ENV{'REMOTE_ADDR'}")}
                 	     );

             } 

		print qq|
			    <html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=staff.cgi?do=listcalls&status=$mstatus"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Ticket List Updated</b>, you are now being taken back to the listings.</font><br><br>
			    <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?do=listcalls&status=$mstatus">click 
			    here</a> if you are not automatically forwarded</font></p></html>
                        |;


  }








if ($section eq "editnotesave") {

   check_user(); 
   print "Content-type: text/html\n\n";

   my $comment = $q->param('comment');
   my $ticket  = $q->param('ticket'); 
   my $note = $q->param('note');

      $comment =~ s/\"/\\"/g;

    $statement = 'UPDATE perlDesk_notes SET comment = "' . "$comment" . '" WHERE id = "' . "$note" . '";'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";

    	print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=staff.cgi?do=ticket&cid=$ticket"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank You</b>, this ticket has been updated.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?do=ticket&cid=$ticket">click 
					here</a> if you are not automatically forwarded</font></p></html>
                |;

  }




  if ($section eq "logout") 
   {
        check_user();
     	$statement =  'UPDATE perlDesk_staffactive SET date = "0" WHERE username = "' . "$Cookies{'staff'}" . '";'; 
        $sth       =  $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
        $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
        $sth->finish;
   
	$cookie1 = $q->cookie(-name =>'staff', 
   	      		      -value =>'', 
			      -path =>'/', 
			      -domain=>''); 

	$cookie2 = $q->cookie(-name =>'spass', 
			      -value =>'', 
			      -path =>'/', 
			      -domain=>''); 
  
        print $q->header(-cookie=>[$cookie1,$cookie2]);

		print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=staff.cgi"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thanks for logging out</b></font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi">click 
					here</a> if you are not automatically forwarded</font></p></html>
                        |;
   }


  if ($section eq "notice") 
   {
       check_user(); 
       print "Content-type: text/html\n\n";
 
      $notic     =  $q->param('id');
      $statement = 'SELECT * FROM perlDesk_announce WHERE staff = "1" AND id = ?'; 
      $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
      $sth->execute($notic) or die print "Couldn't execute statement: $DBI::errstr; stopped";
      	while(my $ref = $sth->fetchrow_hashref()) 
          {	
                          $notice .= '<table width="100%" border="0" cellspacing="1" cellpadding="0"><tr><td width="24%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Author:</font></td><td width="76%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">' . "$ref->{'author'}" . '</font></td>
                          </tr><tr><td width="24%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Published:</font></td><td width="76%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">' . "$ref->{'time'}" . '</font></td></tr><tr><td width="24%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></td><td width="76%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></td>
                          </tr><tr><td width="24%" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Subject:</font></td><td width="76%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>' . "$ref->{'subject'}" . '</b><br><br></font></td></tr><tr><td width="24%" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Announcement:</font></td><td width="76%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">' . "$ref->{'message'}" . '</font></td></tr></table>';
          }
 
    $template{'announcement'}  =  $notice;
    parse("$global{'data'}/include/tpl/staff/announcement");


   }


  if ($section eq "myperformance") 
    {
       check_user(); 
       print "Content-type: text/html\n\n";

     $sth = $dbh->prepare(qq|SELECT COUNT(*) FROM perlDesk_calls WHERE status = "CLOSED" AND closedby = "$Cookies{'staff'}"|) or die DBI->errstr;
     $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
     	 my $closed = $sth->fetchrow_array();
     $sth->finish;
     $sth = $dbh->prepare('SELECT COUNT(*) FROM perlDesk_calls WHERE status = "CLOSED"' ) or die DBI->errstr;
     $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
     	 my $total = $sth->fetchrow_array();
     $sth->finish;
     $sth = $dbh->prepare('SELECT COUNT(*) FROM perlDesk_calls') or die DBI->errstr;
     $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
    	 my $count = $sth->fetchrow_array();
     $sth->finish;

             #~~ 
              # Work Out Rating
              #~~

                $statement = qq|SELECT SUM(rating) FROM perlDesk_reviews WHERE staff = "$staff_id"|;
    	        $th       =  $dbh->prepare($statement) or die DBI->errstr;
   	        $th->execute( ) or die "Couldn't execute statement: $DBI::errstr; stopped";
                     $total_rating = $th->fetchrow_array(); 
                $th->finish;
 
                if ($total_rating)
                 {
                   $statement = qq|SELECT rating FROM perlDesk_reviews WHERE staff = "$staff_id"|;
                   $th       =  $dbh->prepare($statement) or die DBI->errstr;
   	           $th->execute( ) or die "Couldn't execute statement: $DBI::errstr; stopped";
                      my $total_reviews = $th->rows(); 
                   $th->finish;
  
                       $template{'total_reviews'} = $total_reviews || "0";

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

                 } else {$template{'rating'} = "No Rating"; $template{'total_reviews'} = "0"; }



     if ($closed > 0) {
             $per  = ($closed/$total)*100;	
             $perc = sprintf("%.2f",$per);
     } else {
               $perc = "0"
            } 

	$statement = 'SELECT responsetime FROM perlDesk_staff WHERE  username = "' . "$Cookies{'staff'}" . '"'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	    while(my $ref = $sth->fetchrow_hashref()) 
              {	
                $tsec = $ref->{'responsetime'};
              }

     if ($closed > 0) 
      {
         $sec     =  ($tsec/$closed);	
         $days    =  int($sec/(24*60*60));
         $hours   =  ($sec/(60*60))%24;
         $mins    =  ($sec/60)%60;
         $secs    =  $sec%60;
         $restime = "$hours hr(s) $mins min(s) $secs seconds";
      } else {
                $restime = "No calls closed";
             }
 
        $template{'avgresp'}  = $restime;
        $template{'perc'}     = $perc;
        $template{'closed'}   = $closed;

        parse("$global{'data'}/include/tpl/staff/perf");


    }

  if ($section eq "listcalls")
    {
       check_user();  
       print "Content-type: text/html\n\n";
     
      $status             =  $q->param('status');
      $type               =  $status;
      $template{'status'} =  $status;
      $department         =  $q->param('department');

     if ($accesslevel !~ /$department}::/ && $accesslevel !~ /GLOB::/) { die_nice("Sorry $Cookies{'staff'}, You do not appear to have access to this department") if defined $department; }


       if (defined $q->param('sort')) { 
                                               $sort = $q->param('sort');
                                      } else { $sort = "id"; }

       if (defined $q->param('method')) { 
          if ($q->param('method') eq "asc") { $method = "ASC"; } else { $method = "DESC"; } 
       }
      else { $method = "ASC"; }

      if ($q->param('timer'))
        {
             $template{'rtime'}     =  $q->param('timer');

                        $template{'t1'} = " selected" if $q->param('timer') == "60000";
                        $template{'t2'} = " selected" if $q->param('timer') == "180000";
                        $template{'t3'} = " selected" if $q->param('timer') == "300000";
                        $template{'t4'} = " selected" if $q->param('timer') == "900000";
                        $template{'t5'} = " selected" if $q->param('timer') == "1800000";

             $template{'rdirector'} = ' onLoad=redirTimer()'; 
             $template{'rurl'}      = qq|&timer=| . $q->param('timer');
        }
       else { $template{'rdirector'} = ""; $template{'rurl'} = "";}


     #~~
     # Get The Number Of Open Tickets (Unresolved)

     if ($status eq "open") 
       {
           if ($accesslevel =~ /GLOB::/) 
             {
    	           	my $open_query  = qq#SELECT COUNT(*) FROM perlDesk_calls WHERE status != "CLOSED"#;
                           $open_query .= qq# AND category = "$department"# if defined $q->param('department');

                           $sth         = $dbh->prepare( $open_query ) or die DBI->errstr;
             } else {
     
                    @access = split(/::/, $accesslevel);
                    $ac = 0;
                    foreach $dep (@access) { $ac++; }
                 	$statement = 'SELECT COUNT(*) FROM perlDesk_calls WHERE status != "CLOSED" AND ';
                  $i = 1;
                    foreach $dep (@access) 
                      {
                          $dep=~s/^\s+//g;
                          $statement .= 'category = "' . "$dep" . '" ';
                          if ($i < $ac) { $statement .= 'OR '; }
                          $i++;
                      }
                        $statement .= qq# AND category = "$department"# if defined $q->param('department');

           		$sth = $dbh->prepare($statement) or die DBI->errstr;
	         }

      } else {

     #~~
     # View Closed Tickets (Resolved)

                    my $query  = qq#SELECT COUNT(*) FROM perlDesk_calls WHERE status = "CLOSED"#;
                       $query .= qq# AND closedby = "$Cookies{'staff'}"#   if !$q->param('filter');              
                       $query .= qq# AND category = "$department"#         if defined $q->param('department');	

                       $sth    = $dbh->prepare($query);	
 
             }

         	 $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
      	    my ( $total ) = $sth->fetchrow_array();


        if ($status eq "open" && defined $q->param('page'))
            {
                   $page = $q->param('page');

                     execute_sql(qq|UPDATE perlDesk_staff SET lpage = "$page" WHERE username = "$Cookies{'staff'}"|);
            }

         if ($status eq "open" && !$q->param('page'))
            {
                $statement = 'SELECT lpage FROM perlDesk_staff WHERE  username = ?'; 
                $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute( $Cookies{'staff'} ) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		  while(my $ref = $sth->fetchrow_hashref()) 
                      {	
                           $page = $ref->{'lpage'};
                      }
            }
 
         $page      = $q->param('page') || "0" if $status ne "open";
         $limit     = "30";  # Results per page
      my $pages     = ($total/$limit);
         $pages     = ($pages+0.5);
      my $nume      = sprintf("%.0f",$pages);
         $nume      = "1" if !$nume;
         $to        = ($limit * $page) if  $page;
         $to        = "0"              if !$page;   
         $tpage     =  $page;
         $tpage     =  $tpage + 1;
         $location  =  $page;
         $location  =  $location + 1;
         $lboundary = "1" if $location < 4;
         $lboundary =  $location - 3  if !$lboundary;


       # Get Department List

          $statement = 'SELECT level FROM perlDesk_departments'; 
       	  $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
    	  $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
             while(my $ref = $sth->fetchrow_hashref()) 
               {	 
         		$template{'departments'} .= "<option value=\"staff.cgi?do=listcalls&status=$status&department=$ref->{'level'}\">$ref->{'level'}</option>" if $accesslevel =~ /$ref->{'level'}::/ || $accesslevel =~ /GLOB::/; 
               }
          $sth->finish;
 
          $nav .= qq|<font face=Verdana size=1>$nume Page(s): </font>|;

           if ($location + 2 < $nume) { $tboundary = 3 + $location; } else { $tboundary = $nume; }
 
         $string =  $ENV{'QUERY_STRING'};
         $string =~ s/&page=(.*)//g;        
         $prev   =  $page;
         $prev   =  $prev - 1;

        if ($nume > 1 && $tpage > 1 ) { $nav .= qq|<font face="verdana" size="1"><a href="staff.cgi?$string&page=0" alt="First Page">&laquo;</a> <a href="staff.cgi?$string&page=$prev" alt="First Page">&#139;</a> </font>|; }   
 
        foreach ($lboundary..$tboundary) 
          {       
             my $nu     =  $_ -1;
                 if ($nu eq $page) { $link = "[<b>$_</b>]"; } else { $link = "$_"; }          
                   $nav   .= qq|<font face="verdana" size="1"><a href="staff.cgi?$string&page=$nu">$link</a> </font>|;
          }

      $next = $page;
      $next = $next + 1;
      $last = $nume;
      $last = $last - 1;

      if ($tpage < $nume && $tpage >= 1) { $nav .= qq|<font face="verdana" size="1"><a href="staff.cgi?$string&page=$next" alt="Next Page">&#155;</a> <a href="staff.cgi?$string&page=$last" alt="Next Page">&raquo;</a></font>|; }   

            $template{'nav'} = $nav;
         my $show  = $limit *  $page;

    if ($status eq "open") 
     {
        $template{'cc'} = "";
        
     	if ($accesslevel =~ /GLOB::/) 
          {
        		$statement  = qq|SELECT * FROM perlDesk_calls WHERE status != "CLOSED"|;
        		$statement .= qq| AND category = "$department" | if defined  $q->param('department');               
        		$statement .= qq|ORDER BY $sort $method LIMIT $show, $limit|;                      
          }
           else {
                    @access = split(/::/,$accesslevel);
                    $ac = 0;
                    foreach $ddep (@access) { $ac++; }
                    $statement = 'SELECT * FROM perlDesk_calls WHERE (';
                    $i = 1;
                    foreach $dep (@access) 
                       {
                           $dep=~s/^\s+//g;
                           $statement .= "category = \"$dep\" ";
                              if ($i < $ac) { $statement .= 'OR '; } else { $statement .= ")"; }
                                  $i++;
                              }
                           $statement .= " AND status != \"CLOSED\" ORDER BY $sort $method LIMIT $show, $limit"; 
                 }          
       }
      else {

                 $template{'cc'} = qq|<br>FILTER: ( <a href="staff.cgi?do=listcalls&status=closed&filter=0">CLOSED BY ME</a> / <a href="staff.cgi?do=listcalls&status=closed&filter=1">CLOSED BY ALL</a> )|;


                 if ($q->param('filter') == "1")
                   { 
                     	if ($accesslevel =~ /GLOB::/) 
                          { 
        	           	$statement  = qq|SELECT * FROM perlDesk_calls WHERE status = "CLOSED"|;
        	           	$statement .= qq| AND category = "$department" | if defined $q->param('department');        
        	           	$statement .= qq|ORDER BY $sort $method LIMIT $show, $limit|;                      
                          }
                        else {
                       @access = split(/::/,$accesslevel);
                       $ac = 0;
                         foreach $ddep (@access) { $ac++; }
                         $statement = 'SELECT * FROM perlDesk_calls WHERE (';
                         $i = 1;
                       foreach $dep (@access) 
                         {
                                    $dep=~s/^\s+//g;
                                    $statement .= "category = \"$dep\" ";
                                if ($i < $ac) { $statement .= 'OR '; } else { $statement .= ")"; }
                                    $i++;
                         }
                             $statement .= " AND status = \"CLOSED\"";
                             $statement .= " AND category = \"$department\"" if defined $q->param('department');
                             $statement .= "ORDER BY $sort $method LIMIT $show, $limit"; 

                         }

                   } else { 
                              $statement  = "SELECT * FROM perlDesk_calls WHERE status = \"CLOSED\" AND closedby = \"$Cookies{'staff'}\"";
                              $statement .= " AND category = \"$department\" " if defined $q->param('department');
                              $statement .= "ORDER BY $sort $method LIMIT $show,$limit"; 
                          }
           }

   	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement $stat: $DBI::errstr; stopped";
        $sth->execute() or die print "Couldn't execute statement $stat: $DBI::errstr; stopped";
	$number=0;
 	    while($ref = $sth->fetchrow_hashref()) {	
			$number++;
     		$subject="$ref->{'subject'}"; 
			$subject=substr($subject,0,20).'..' if length($subject) > 22;

			$font   = '#000000';

     			if ($ref->{'method'}  eq "cc") { $img   = "phone.gif";     } elsif ($ref->{'method'} eq "em") { $img = "mail.gif"; } else { $img = "ticket.gif"; }
    			if ($ref->{'priority'} eq "1") { $color = $global{'pri1'}; } 
     			if ($ref->{'priority'} eq "2") { $color = $global{'pri2'}; } 
    			if ($ref->{'priority'} eq "3") { $color = $global{'pri3'}; } 
    			if ($ref->{'priority'} eq "4") { $color = $global{'pri4'}; } 
    			if ($ref->{'priority'} eq "5") { $color = $global{'pri5'}; } 
                        if ($ref->{'aw'} eq "1") { $awt = "<img src=\"$global{'imgbase'}/online.gif\">"; } else { $awt = "<img src=\"$global{'imgbase'}/offline.gif\">"; }

            $current_time =  time();
            $difference   =  $current_time - $ref->{'track'};

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

            $opencalls .= display_ticket($ref->{'id'}, $ref->{'username'}, $ref->{'category'}, $ref->{'status'});

     	 }
		
	$opencalls = '<br><div align=center><font face=Verdana size=2>0 Requests Found</font></div><br>' if !$opencalls;
		
        $template{'listcalls'}  =  $opencalls;
        $template{'type'}       =  $status;
        $template{'path'}       =  "staff.cgi" . '?' . $ENV{'QUERY_STRING'};
        $template{'path'}       =~  s/&sort=(.*)//;
        $template{'path'}       =~  s/&method=(.*)//;

 
      parse("$global{'data'}/include/tpl/staff/listcalls");
    }



  exit;
 }



sub function {

      $action = "@_";

  if ($action eq "history") {

      $trackedcall = $q->param('callid');
      $statement = 'SELECT * FROM perlDesk_calls WHERE  id = ? ORDER BY id'; 
      $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute($trackedcall) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		$number=0;
	  while(my $ref = $sth->fetchrow_hashref()) {	
        print qq|<html><head><title>PerlDesk</title>
                 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><STYLE type=text/css>
                 A:active  { COLOR: #006699; TEXT-DECORATION: none       }
                 A:visited { COLOR: #334A9B; TEXT-DECORATION: none       }
                 A:hover   { COLOR: #334A9B; TEXT-DECORATION: underline  }
                 A:link    { COLOR: #334A9B; TEXT-DECORATION: none       }
           </STYLE><link rel="stylesheet" href="$global{'imgbase'}/style.css"></head><body><table width="100%" border="0"><tr> <td width="29%" height="23" class="toptab"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Subject</font></td>
           <td colspan="2" class="toptab" width="71%"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'subject'}</font></b></td>
           </tr><tr valign="top" class="stafftab">  <td colspan="3" height="56" class="stafftab"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">$ref->{description}</font></td>
           </tr><tr><td colspan="3" height="8">&nbsp;</td>
           </tr><tr><td colspan="3" height="8" class="toptab"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Responses</b></font></td>
           </tr><tr><td colspan="3" height="8"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">|;
    }
  $statemente = 'SELECT * FROM perlDesk_notes WHERE call = ? ORDER BY id;'; 
  $sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
  $sth->execute($trackedcall) or die print "Couldn't execute statement: $DBI::errstr; stopped";
   while(my $ref = $sth->fetchrow_hashref()) {
		$body = $ref->{'comment'};
	if ($body =~ /^</) { } else {  $body =~ s/\n/<br>/g; }
	if ($ref->{'owner'} eq 0)    {
	print '<table width="100%" border="0" cellspacing="1" cellpadding="2"><tr class="userresponse"> 
		   <td width="30%" height="14" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>' . "$ref->{'author'}" . '<br>
		   </b></font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . "$ref->{'time'}" . '<br><br></font></td>
		   <td width="70%" height="14" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . "$body" . '</font></td></tr></table>';
	} 
	if ($ref->{'owner'} eq 3) 	{
	print '<table width="100%" border="0" cellspacing="1" cellpadding="2"><tr class="staffaction"> 
		   <td width="30%" height="14" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>' . "$ref->{'author'}" . '<br>
		   </b></font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . "$ref->{'time'}" . '<br><br></font></td>
		   <td width="70%" height="14" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . "<b>STAFF ACTION: $ref->{'action'}</b><br>$body" . '</font></td></tr></table>';
	} 
	if ($ref->{'owner'} eq 1) 	{
            if ($ref->{'visible'} eq 0) { $notice = '<b>PRIVATE STAFF NOTE</b><br>'; } else { $notice = ''; }

    print '<table width="100%" border="0" cellspacing="1" cellpadding="2"><tr class="staffresponse"> 
    	   <td width="30%" height="14" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>' . "$ref->{'author'}" . '<br>
		   </b></font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . "$ref->{'time'}" . '<br><br></font></td>
		   <td width="70%" height="14" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . "$notice $body" . '</font></td></tr></table>';
	}
}
    print qq|</font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></div></td></tr></table></body></html>|;
	 
exit;
} 

  if ($action eq "print") 
   {
     if (defined $q->param('callid')) {
       $trackedcall = $q->param('callid');
       print qq|<html><head><title>$global{'title'}: Print Request</title></head><body><br><div align="center"><img src="$global{'imgbase'}/logo.gif"></div><br>|;
 
       $statement = 'SELECT * FROM perlDesk_calls WHERE  id = ?'; 
       $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
       $sth->execute($trackedcall) or die print "Couldn't execute statement: $DBI::errstr; stopped";
       $number=0;
          while(my $ref = $sth->fetchrow_hashref()) {	
			if (($accesslevel =~ /$ref->{'category'}::/) || ($accesslevel =~ /GLOB::/)) {
			$trackno     =  $ref->{'id'};
			$date        =  $ref->{'time'};
			$username    =  $ref->{'username'};
			$priority    =  $ref->{'priority'};
			$status      =  $ref->{'status'};
			$subject     =  $ref->{'subject'};
			$category    =  $ref->{'category'};
			$description =  $ref->{'description'};
			$owner       =  $ref->{'ownership'};
			$number      =  0;
  			$email       =  $ref->{'email'};
			$url         =  $ref->{'url'};
			$name        =  $ref->{'name'};
	} else {
			$error       =  'You do not have permission to view this call';
			push @errors, $error;
	}								
}

if (@errors) {
			@content = @errors;
			print @content;
			
	   		exit;
}
  print qq|<table width="80%" border="0" cellspacing="1" cellpadding="1" align="center"><tr><td colspan="2">&nbsp;</td>
    </tr><tr><td colspan="2"><font size="3" face="Verdana, Arial, Helvetica, sans-serif"><b>REQUEST ID $trackedcall</b></font></td>
    </tr><tr><td colspan="2"> <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">LOGGED: $date BY: $username</font></div>
    </td></tr><tr><td colspan="2">&nbsp;</td></tr><tr valign="middle"><td colspan="2" height="30">&nbsp;</td></tr><tr valign="middle"> 
    <td colspan="2" height="30"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>$subject</b></font></td></tr><tr> 
    <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">$description</font></td></tr><tr> <td>&nbsp;</td><td>&nbsp;</td>
    </tr><tr><td colspan="2">&nbsp;</td></tr><tr> <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>ACTIONS/RESPONSES</b><hr></font></td></tr><tr><td colspan="2">
   |;
	$statemente = 'SELECT * FROM perlDesk_notes WHERE call = ? ORDER BY id;'; 
	$sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute($trackedcall) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	      while(my $ref = $sth->fetchrow_hashref()) {
				$body = $ref->{'comment'};
	if ($body =~ /^</) {
			# Do nothing
 	} else {
		$body =~ s/\n/<br>/g;
 	}
			if (($ref->{'owner'} eq 0) || ($ref->{'owner'} eq 1))
				{
				  	 print qq|<div align="left"><br><font face="Verdana" size="2"><b>$ref->{'author'}</b> <i>$ref->{'time'}</i><br><font size=1><blockquote>$body</blockquote></font></div><br><hr>|;
				} 
			if ($ref->{'owner'} eq 3) 
				{
				    	print '<table width="100%" border="0" cellspacing="1" cellpadding="2"><tr> 
    						   <td width="30%" height="14" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>' . "$ref->{'author'}" . '<br>
    						   </b></font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . "$ref->{'time'}" . '<br><br></font></td>
    						   <td width="70%" height="14" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . "<b>STAFF ACTION: $ref->{'action'}</b><br>$body" . '</font></td></tr></table><br><hr>';
				} 
   }
        print qq|</td></tr></table>|;  
   } else 
        {
            print "No call defined!";
            exit;
        }
    exit;
} 

if ($action eq "movedep") {
   $callid    = $q->param('callid');
   $comments  = $q->param('comment');
   $dep       = $q->param('select');
   $tech      = $q->param('assignstaff');


      my @chars =  ("A..Z","0..9","a..z");
         $key   =  $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)];
         
     my $rv = $dbh->do(qq{INSERT INTO perlDesk_notes values (
        "NULL", "3", "1", "ASSIGN", "$callid", "$staff_id", "$hdtime", "$key", "$comments", "$ENV{'REMOTE_ADDR'}")}
     );

   my $sdsth = $dbh->prepare( "INSERT INTO perlDesk_activitylog VALUES ( ?, ?, ?, ?, ?)" );
      $sdsth->execute( "NULL", $callid, $hdtime, "Staff $Cookies{'staff'}", "Request Assigned Internal ($dep $tech)" ) or die "Couldn't execute statement: $DBI::errstr; stopped";


    execute_sql(qq|UPDATE perlDesk_calls SET category  = "$dep", ownership = "$tech" WHERE id = "$callid"|); 


   $response = "<div align=\"center\"><b>Thank you.</b> Call ID $callid has been assigned to $dep</div>"; 
   $template{'response'} = $response;

    parse("$global{'data'}/include/tpl/staff/general");

	
exit;
}

if ($action eq "assign") {
	$statement = 'SELECT level FROM perlDesk_departments'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) {	
			$option = "<option value=\"$ref->{'level'}\">$ref->{'level'}</option>";
			push @list, $option;
	}
	$sth->finish;
    push @slist, "<option value=\"Unowned\">Unassigned</option>";
	$statement = 'SELECT username, name FROM perlDesk_staff'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) {	
			$option = "<option value=\"$ref->{'username'}\">$ref->{'name'}</option>";
			push @slist, $option;
	}
	$sth->finish;
	$callid = $q->param('callid');
	$response = '<table width="100%" border="0" cellspacing="1" cellpadding="4"><tr><td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Assign 
      Internal</b></font></td></tr><tr><td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Below you 
      can assign this request to another department. </font></td></tr><tr><td><form method="post" action="staff.cgi"><input type="hidden" name="action" value="movedep"><input type="hidden" name="callid" value="' . "$callid" .'">
      <table width="100%" border="0" cellspacing="1" cellpadding="1"><tr><td width="7%">&nbsp;</td><td width="28%">&nbsp;</td><td width="65%">&nbsp;</td></tr><tr><td width="7%">&nbsp;</td><td width="28%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Department<br>Staff Member</font></td><td width="65%"> 
      <select name="select" class="gbox">' . "@list" . '</select><br> <select name="assignstaff" class="gbox">' . "@slist" . '</select></td></tr><tr> <td width="7%">&nbsp;</td><td width="28%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Comments</font></td><td width="65%"> 
      <textarea name="comment" cols="50" class="gbox" rows="10"></textarea></td></tr><tr><td colspan="3" height="35"><div align="center"> 
      <input type="submit" name="Submit" value="Submit"></div></td></tr></table></form></td></tr></table>';

    $template{'response'} = $response;
    parse("$global{'data'}/include/tpl/staff/general");

		
exit;
} 

if ($action eq 'addresponse') 
  {


     if (defined $q->param('callid')) {	$trackno = $q->param('callid'); }
     else {	$trackno = $q->param('ticket');    }
	


       $statement = 'SELECT * FROM perlDesk_calls WHERE  id = ? ORDER BY id'; 
        $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute($trackno) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		$number=0;
			  while(my $ref = $sth->fetchrow_hashref()) 
				{	
					if (($accesslevel =~ /$ref->{'category'}::/) || ($accesslevel =~ /GLOB::/)) 
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
			  			$template{'email'}       =   $ref->{'email'};
						$template{'url'}         =   $ref->{'url'};
						$template{'name'}        =   $ref->{'name'};

					} else {
        	   			    	$error= 'You do not have permission to view this call';
         	                	push @errors, $error;
        	                }								
			}

        $my_msg = $template{'description'};
        $my_msg =~ s/<br>/\n/gi;

        @msg = split(/\n/,$my_msg) if   $q->param('inc') == "1";
      
        foreach $lin (@msg) { $template{'msg'} .= qq|> $lin\n|; }         

        $template{'msg'} = ""                       if  !$q->param('inc');         



	if ($template{'description'} =~ /^</) {	} else 
         {
	 	# This is a Text Email, format it!
                
	    	$template{'description'} =~ s/\n/<br>/g;
	 }

        $statement = 'SELECT * FROM perlDesk_staff WHERE username = ?'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
		$sth->execute("$Cookies{'staff'}") or die print "Couldn't execute statement: $DBI::errstr; stopped";
         while(my $ref = $sth->fetchrow_hashref()
          ) {
               if ($ref->{'signature'}) {
				  $line = "\n\n\n\n";
				  push @signature, $line;	
                  push @signature, "$ref->{'signature'}";                        
           }   }
	
	if (!@signature) { @signature = ''; }
	        foreach $line (@signature) {
			$sig .= $line;
	}

	$statement = 'SELECT * FROM perlDesk_preans WHERE author = ? OR author = "admin"'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute("$Cookies{'staff'}") or die print "Couldn't execute statement: $DBI::errstr; stopped";
	   while(my $ref = $sth->fetchrow_hashref()) {
	 
		if ($ref->{'author'} eq "$Cookies{'staff'}") {
			      $ddmenu .= ' <option value="staff.cgi?action=addresponse&pretext=' . "$ref->{'id'}" . '&callid=' . "$trackno" . '">' . "$ref->{'subject'}" . '</option>';

		} if ($ref->{'author'} eq "admin") {
			       $dmenu .= ' <option value="staff.cgi?action=addresponse&pretext=' . "$ref->{'id'}" . '">' . "$ref->{'subject'}" . '</option>';

	    }
	}
	if (defined $q->param('pretext')) {
	   $id = $q->param('pretext');
       $statement = 'SELECT * FROM perlDesk_preans WHERE id = ?'; 
       $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
       $sth->execute($id) or die print "Couldn't execute statement: $DBI::errstr; stopped";
              while(my $ref = $sth->fetchrow_hashref()) {
                    $comments = $ref->{'text'};		
              }
       }	else { $comments = ''; }


       $statement = 'SELECT description FROM perlDesk_calls WHERE id = ?'; 
       $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
       $sth->execute($trackno) or die print "Couldn't execute statement: $DBI::errstr; stopped";
              while(my $ref = $sth->fetchrow_hashref()) {
                    $template{'body'} = $ref->{'description'};		
              }

   $template{'ifpre'}   = $comments;
   $template{'preans'}  = $ddmenu;
   $template{'apreans'} = $dmenu;
   $template{'sig'}     = $sig;
   $template{'trackno'} = $trackno;

   parse("$global{'data'}/include/tpl/staff/staffnote");


  $dbh->disconnect;
   exit;
}


if ($action eq "editticket") 
 {

    my $trackno = $q->param('ticket');
           
  	$statement = 'SELECT * FROM perlDesk_calls WHERE id = ?'; 
        $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
        $sth->execute($trackno) or die print "Couldn't execute statement: $DBI::errstr; stopped";
     while(my $ref = $sth->fetchrow_hashref()) 
            {
	           $template{'call'}     = $ref->{'description'};
            }
                 
    $template{'trackno'} = $trackno;

    parse("$global{'data'}/include/tpl/staff/editcall");


    $dbh->disconnect;
   exit;
 }

if ($action eq "save_edit_call") 
 {
       $trackno = $q->param('ticket');
       $text    = $q->param('comments');
       $text   .= "\n\n";
       $text   .= "[ Call last edited by $Cookies{'staff'}: $hdtime ]";

       $dbh->do(qq|UPDATE perlDesk_calls SET description = "$text" WHERE id = "$trackno"|);                       

       $template{'trackno'} = $trackno;
       $dbh->disconnect;

     	print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=staff.cgi?do=ticket&cid=$trackno"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank You</b>, this ticket has been updated.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?do=ticket&cid=$trackno">click 
					here</a> if you are not automatically forwarded</font></p></html>
                |;

     exit;
 }


#~~
# Save a Staff Response
#~~
if ($action eq 'submitnote')
  {

      $trackno    =  $q->param('ticket');
      $snewstatus =  $q->param('newstatus');
      $private    =  $q->param('private');
      $comments   =  $q->param('comments');
      $notific    =  $q->param('notify');
      $file       =  $q->param('file'); 
      $comments   =~ s/</&lt;/g;
      $comments   =~ s/>/&gt;/g;

        $dbh->do(qq|UPDATE perlDesk_calls SET ownership = "$Cookies{'staff'}" WHERE id = "$trackno"|) if $q->param('own') == "1";

        $action    = "CLOSED" if $snewstatus eq "Resolved";
        $action    = "OPEN"   if $snewstatus eq "Unresolved";
        $action    = "HOLD"   if $snewstatus eq "Hold";
	$ecomments =  $comments;
	$comments  =~ s/\"/\\"/g;

        execute_sql(qq|UPDATE perlDesk_calls SET aw = "0" WHERE id = "$trackno"|);

      my @chars =  (A..Z,0..9,a..z);
         $key   =  $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)];
         $template{'key'} = $key;

	if ($private eq "Yes") 
         {
     	     $rv  = $dbh->do(qq{INSERT INTO perlDesk_notes values ("NULL", "1", "0", "$action", "$trackno", "$staff_id", "$hdtime", "$key", "$comments", "$ENV{'REMOTE_ADDR'}")});

             $nid = $dbh->{'mysql_insertid'}; 
         }
        elsif ($private eq "No") 
         {
    	    $rv  = $dbh->do(qq{INSERT INTO perlDesk_notes values ("NULL", "1", "1", "$action", "$trackno", "$staff_id", "$hdtime", "$key", "$comments", "$ENV{'REMOTE_ADDR'}")});
            $nid = $dbh->{'mysql_insertid'}; 

             if ($snewstatus eq "Resolved") {

              	$statement = 'SELECT * FROM perlDesk_calls WHERE id = ?'; 
             	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
           	    $sth->execute($trackno) or die print "Couldn't execute statement: $DBI::errstr; stopped";
			        while(my $ref = $sth->fetchrow_hashref()) 
                        {
	           	    $logtime  = $ref->{'track'};
                            $pretrack = $ref->{'an'};
                            $problem  = $ref->{'description'};
                        }

              if (!$pretrack) {

       			$totalcalls = $glboal->{'ssi_closed'};
         
        		$totalcalls++;


                execute_sql(qq|UPDATE perlDesk_settings SET value = "$totalcalls" WHERE setting = "ssi_closed"|);

               $system_time     =  $global{'avgtime'};
               $current_time    =  time();
               $end_time        =  $current_time-$logtime;
               $system_newtime  =  $end_time+$system_time; 

               execute_sql(qq|UPDATE perlDesk_settings SET value = "$system_newtime" WHERE setting = "avgtime"|);

 
               $statement = 'SELECT responsetime FROM perlDesk_staff WHERE  username = "' . "$Cookies{'staff'}" . '"'; 
               $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
               $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
      			  while(my $ref = $sth->fetchrow_hashref()) 
                            {
          	                $stime = $ref->{'responsetime'};
          	          }
               $sth->finish;

               $res_time     = $current_time - $logtime;
               $newtime      = $res_time+$stime; 

               execute_sql(qq|UPDATE perlDesk_staff SET responsetime = "$newtime" WHERE username = "$Cookies{'staff'}"|); 
               execute_sql(qq|UPDATE perlDesk_calls SET an = "1" WHERE id = "$trackno"|);

	}
  }
}

   #~~
   # Get Call Variables
   #~~

        $statement = 'SELECT category, time_spent FROM perlDesk_calls WHERE id = ?';
        $sth = $dbh->prepare($statement)or die print "Couldn't prepare statement: $DBI::errstr; stopped";
        $sth->execute($trackno) or die print "Couldn't execute statement: $DBI::errstr; stopped";
          while(my $ref = $sth->fetchrow_hashref()) 
           {
              $cat    =  $ref->{'category'};
              $time_s =  $ref->{'time_spent'}; 
           }
       
          $this_time = $q->param('time');
       
          if (defined $this_time)
           {
              $new_time  = $this_time + $time_s;
              execute_sql(qq|UPDATE perlDesk_calls SET time_spent = "$new_time" WHERE id = "$trackno"|);
           }

       if ($private eq "Yes") 
        {  
           $statement = 'SELECT * FROM perlDesk_staff WHERE access LIKE "%' . "$cat" . '::%" OR access LIKE "%GLOB::%" OR access="admin" AND username != "' . "$Cookies{'staff'}" . '"';
           $sth = $dbh->prepare($statement)or die print "Couldnt prepare statement: $DBI::errstr; stopped";
           $sth->execute() or die print "Couldnt execute statement: $DBI::errstr; stopped";
           while(my $ref = $sth->fetchrow_hashref()) {
             if ($ref->{'notify'}) 
                   {
                       chomp($recipient = $ref->{'email'}); 

                            my $msg .= "There is a new help desk response made by a staff member:\n";
                               $msg .= "\nCall Details\n";
                               $msg .= "---------------------------------------\n";
                               $msg .= "\t Response by......: $name\n";
                               $msg .= "\t Time.............: $hdtime\n";
                               $msg .= "\t Ticket...........: $trackno\n";
                               $msg .= "\t Comments.........: $comments\n";
                               $msg .= "---------------------------------------\n";
                               $msg .= "\n\nThank You.";

                       email( To => "$recipient", From => "$global{'adminemail'}", Subject => "Help Desk Response (STAFF MESSAGE)", Body => "$msg" );                                              
                   }
           $sth->finish;
     }
   }

   if ($notific eq "Yes" && $private eq "No")  
     { 
  	$statement = 'SELECT * FROM perlDesk_calls WHERE  id = ?'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute($trackno) or die print "Couldn't execute statement: $DBI::errstr; stopped";
 		  while(my $ref = $sth->fetchrow_hashref()) {
	    
           if ($enablemail) 
             {
         	$st = $dbh->prepare('SELECT * FROM perlDesk_em_forwarders WHERE category = ?') or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	 	$st->execute( $ref->{'category'} ) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ef = $st->fetchrow_hashref()) 
		  {
			$category   = $ref->{'category'};
                        $fromemail  = $ef->{'address'};
		  }

                        $fromemail  = $ticketad if !$fromemail;

                        chomp($recipient = $ref->{'email'}); 

			open (MAILNEWTPL, "$global{'data'}/include/tpl/response.txt");
			 while (<MAILNEWTPL>)
                            {
                                      lang_parse();
                                     
                                       $template{'nid'}      =  $nid;
                                       $template{'name'}     =  $ref->{'name'};
                                       $template{'tech'}     =  $name;
                                       $template{'response'} =  $ecomments;
                                       $template{'hdtime'}   =  $hdtime;
                                       $template{'category'} =  $category;

    	  	 	 	       if ($_ =~ /\{*\}/i)
                                         { 
                                             foreach $key (keys %template) { s/\{$key\}/$template{$key}/eg; }
				         }		
  	
                 	               $msg .= "$_";
		 	    }
	  	       close(MAILNEWTPL);
                    
                       my $cc = $q->param('cc');

                       email( To => "$recipient", From => "$fromemail", Cc => "$cc", Subject => "\{$global{'epre'}-$trackno\} RE: $ref->{'subject'}", Body => "$msg" );                      

             }


	}
  } 

	if ($snewstatus eq "Resolved")
          { 

             my $sdsth = $dbh->prepare( "INSERT INTO perlDesk_activitylog VALUES ( ?, ?, ?, ?, ?)" );
                $sdsth->execute( "NULL", $trackno, $hdtime, "Staff $Cookies{'staff'}", "Request Closed" ) or die "Couldn't execute statement: $DBI::errstr; stopped";

		$statemente = 'SELECT * FROM perlDesk_staff WHERE username = ?'; 
		$sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute("$Cookies{'staff'}") or die print "Couldn't execute statement: $DBI::errstr; stopped";
	      while(my $ref = $sth->fetchrow_hashref())  
                  {
			$callsclosed = $ref->{'callsclosed'};
		  }

		$callsclosed++;

                execute_sql(qq|UPDATE perlDesk_staff SET callsclosed = "$callsclosed" WHERE username = "$Cookies{'staff'}"|);
	 }

	
	if ($snewstatus eq "Unresolved") {   $newstatus = OPEN;    }
	if ($snewstatus eq "Resolved") 	 {   $newstatus = CLOSED;  }
	if ($snewstatus eq "Hold") 	 {   $newstatus = HOLD;	   }


	if ($snewstatus eq "Resolved")	
          {
			$statement = 'UPDATE perlDesk_calls SET status = "' . "$newstatus" . '", closedby = "' . "$Cookies{'staff'}" . '" WHERE id = "' . "$trackno" . '";'; 
          } else    {
	                $statement = 'UPDATE perlDesk_calls SET status = "' . "$newstatus" . '" WHERE id = "' . "$trackno" . '";'; 
	            }

	my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";



 if (defined $file && $file ne "") 
     {
        my $path2 = get_setting_2(qq|file_path|);
           $tfile =  $file;
           $tfile =~ s/\\/\//g;
   
         my @path    = split (/\//,$tfile);
         my $entries = @path;
   
         my $filename = $path[$entries-1];

            $i        =  1;

         ($fname, $ext) = split(/\./, $filename);

 
           if ($file_types{$ext} == "1") {}
           else {
                    die_nice("Sorry, that file extension ($ext) is not accepted at present");
                }
 

         until($assigned == "1") { if (-e "$path2/$fname\.$ext") { $fname .= "$i"; $i++; } else { $assigned = "1";  } } 
          
         $file_name = "$fname" . '.' . "$ext";

         open(LOCAL, ">$path2/$file_name") or die $!;
           while(<$file>)
             {
                print LOCAL $_;
             }
          close(LOCAL);     

            execute_sql(qq|INSERT INTO perlDesk_files VALUES ("", "", "$nid", "$file_name", "$path2/$file_name")|);

     } 



  if ($q->param('addtokb') eq "1") 
   {
  	$statement = 'SELECT * FROM perlDesk_calls WHERE id = ?'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
        $sth->execute($trackno) or die print "Couldn't execute statement: $DBI::errstr; stopped";
			  while(my $ref = $sth->fetchrow_hashref()) 
                            {
                               $problem     = $ref->{'description'};
                            }
        $sth->finish;

	$statement = 'SELECT category FROM perlDesk_kb_cat'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
                  {
  		        $list .= "<option value=\"$ref->{'category'}\">$ref->{'category'}</option>";
                  }
        $sth->finish;

    $template{'q'}        =  $problem;
    $template{'a'}        =  $comments;
    $template{'trackno'}  =  $trackno;
    $template{'category'} =  $list;

      parse("$global{'data'}/include/tpl/staff/addtokb");

    exit;
   
   } }



  if ($action eq "addtokb") 
    {
       $category = $q->param('select');
       $article  = $q->param('article');
       $subject  = $q->param('subject');
       $article  =~ s/\"/\\"/g;
       $article  =~ s/\n/<br>/g;
       $subject  =~ s/\"/\\"/g;
       $trackno  = $q->param('ticket'); 

       if ($subject ne "")
        {
            my $rv = $dbh->do(qq{INSERT INTO perlDesk_kb_entries values ("NULL", "$category", "$name", "$subject", "$article", "0")});
        }
  
    }
 
     	print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=staff.cgi?do=ticket&cid=$trackno"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank You</b>, this ticket has been updated.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="staff.cgi?do=ticket&cid=$trackno">click 
					here</a> if you are not automatically forwarded</font></p></html>
                |;

}

sub display_ticket {

    my ($id, $username, $category, $status) = @_;

    my $ticket = qq| <table width="100%" border="0" cellpadding="5" cellspacing="1"><tr bgcolor="$color"><td width="3%"><font size="1" face="Verdana"><img src="$global{'imgbase'}/$img"></font></td>
                      <td width="4%"><font size="1" face="Verdana"><input type=checkbox name=ticket_check value=$id></font></td>
                      <td width="6%"><font size="1" face="Verdana" color=$font>$otag <div align="center">$id</div>  $ctag</font></td>
                      <td width="17%"><font size="1" face="Verdana" color=$font>$otag $username $ctag</font></td><td width="21%"><font size="1" face="Verdana" color=$font><a href="staff.cgi?do=ticket&cid=$id">$otag $subject $ctag</a></font></td>
                      <td width="22%"><font size="1" face="Verdana" color=$font>$otag $category $ctag</font></td><td width="8%"><font size="1" face="Verdana" color=$font>$otag <div align="center">$status</div> $ctag</font></td><td width="17%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color=$font>$otag $count $period $ctag</font></td>
                      <td width="2%"><font size="1" face="Verdana" color="$font">$awt</font></td></tr></table>
                   |;
    return $ticket;

}


1;