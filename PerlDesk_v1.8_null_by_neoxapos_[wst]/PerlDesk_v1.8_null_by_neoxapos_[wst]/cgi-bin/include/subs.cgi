###################################################################################
#                                                                                 #
#                   PerlDesk - Customer Help Desk Software                        #
#                                                                                 #
###################################################################################
#                                                                                 #
#     Author: John Bennett	                                                  #
#      Email: j.bennett@perldesk.com                                              #
#        Web: http://www.perldesk.com                                             #
#   Filename: subs.cgi                                                            #
#    Details: The main user file                                                  #
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
 
   $use   = $q->cookie('id');
   $pas   = $q->cookie('pass');

   use vars qw/ $languages %global %LANG $q @languages $translation $language $hdtime $enablemail %template/;

   %Cookies = (
     id   => $use,
     pass => $pas
   );


sub check_user
  {
	if ((!$Cookies{'id'}) || ($Cookies{'id'} eq "") || (!$Cookies{'pass'}) || ($Cookies{'pass'} eq ""))
          {
               $ignore = 1;
               if ($q->param('do') ne "login" && $q->param('do')) {  $template{'error'} = qq|<br><br><b>Sorry, you must be logged in to view this page<b><br><br><br>|; }
               section("login"); 
 	  }

    $statement = 'SELECT * FROM perlDesk_users WHERE username = ?'; 
    $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
    $sth->execute("$Cookies{'id'}") or die print "Couldn't execute statement: $DBI::errstr; stopped";
	  while(my $ref = $sth->fetchrow_hashref()) 
		{
  	          $username             =   $ref->{'username'};
	          $password             =   $ref->{'password'};
	          $template{'company'}  =   $ref->{'company'};
	          $template{'fullname'} =   $ref->{'name'};
	          $template{'email'}    =   $ref->{'email'};
	          $template{'user'}     =   $ref->{'username'};
	          $template{'url'}      =   $ref->{'url'};
	          $template{'name'}     =   $ref->{'name'};
	          $rkey                 =   $ref->{'rkey'};
	          $userid               =   $ref->{'id'};
	       }

    my $md5 = Digest::MD5->new ;
       $md5->reset ;

    my $yday   = (localtime)[7];
    my @ipa = split(/\./,$ENV{'REMOTE_ADDR'});
    my $startip = $ipa[0] . $ipa[1];

  if ($global{'sess_ip'}) 
    {
          $certif = $Cookies{'id'} . "pd-$rkey" . $ENV{'HTTP_USER_AGENT'} . $startip;
    }
  else {
          $certif = $Cookies{'id'} . "pd-$rkey" . $ENV{'HTTP_USER_AGENT'};
       }


       $md5->add($certif);

    my $enc_cert = $md5->hexdigest();

    if($enc_cert eq $Cookies{'pass'}) 
      {
   		# we're logged in !! :)
                $loggedin = 1;
      } 
         else {
                 $ignore = 1;
                  if ($q->param('do') ne "login" && $q->param('do')) {  $template{'error'} = qq|<br><br><b>Sorry, you must be logged in to view this page<b><br><br><br>|; }
                  section("login");    	          
              } 

  my $time = time();
  my $sql  = 'SELECT active FROM perlDesk_users WHERE username = ?'; 
     $sth  = $dbh->prepare($sql) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
     $sth->execute("$Cookies{'id'}") or die print "Couldn't execute statement: $DBI::errstr; stopped";
    while(my $ref = $sth->fetchrow_hashref()) 
        {	
           $lastactive = $ref->{'active'};
        }

  }





sub lang_parse
  {
    if ($_ =~ /\%*\%/) 
           {
               s/\%(\S+)\%/$LANG{$1}/g;
           }
  }


 sub lang_bar
  {

    if ($_ =~ /\{languages\}/) 
     {
        my $querystring = $ENV{'QUERY_STRING'};
        my $and;
        my @htmllangbar;

        if ($querystring =~ /^lang/) { $querystring = ''; }
            $querystring =~ s/\&//g;

     if ($querystring) { $and = '&'; } else { $and =''; }
                 if ($and) 
                    { 
                        $querystring =~ s/lang=(.*)//g; 
                    }
     foreach $translation (@languages) 
        {
            $translation .= '.gif';
             my $htmlbar = " <img src=$global{'imgbase'}/lang/$translation> <a href=\"$ENV{'SCRIPT_NAME'}?$querystring" . "$and" . "lang=$translation\"><font size=1 face=Verdana, Arial, Helvetica, sans-serif>$langdetails{$translation}</font></a>";
             push @htmllangbar, $htmlbar;
        }
       s/\{languages\}/@htmllangbar/g;
   } else {
              s/\{languages\}//g;
          }   
   }


sub section {

  my $section = "@_";

  if ($section eq "main") {
     check_user();
     print "Content-type: text/html\n\n";

     $uname = $Cookies{'id'};
     my $sort;
     my $statement = 'SELECT * FROM perlDesk_announce WHERE users = "1"'; 
     my	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
        $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
      while(my $ref = $sth->fetchrow_hashref()) 
         {	
             $notice .= ' <table width="100%" border="0" cellspacing="1" cellpadding="2"><tr><td width="5%"> <div align="center"><img src="' . "$global{'imgbase'}" . '/note.gif" width="11" height="11"></div></td><td width="62%"><a href="' . "$template{'mainfile'}" . '?do=notice&nid=' . "$ref->{'id'}&lang=$language\"><font size=\"1\" face=\"Verdana, Arial, Helvetica, sans-serif\">$ref->{'subject'}" . '</font></a></td><td width="33%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">' . "$ref->{'time'}" . '</font></td></tr></table>';
         }

          $sth->finish;
          $notice = '<font face="verdana" size="1">No Announcements Set</font>' if !$notice;

      my $num  = 1;
         $sort = $q->param('sort') if defined $q->param('sort');
         $sort = "id" if !$sort; 

      my $method;

      if (defined $q->param('method')) {  if ($q->param('method') eq "asc") { $method = "ASC"; } else { $method = "DESC"; }  }
         else { $method = "ASC"; }

   my $sql = 'SELECT COUNT(*) FROM perlDesk_calls WHERE username = ? AND status != "CLOSED"'; 
      $sth = $dbh->prepare($sql) or die DBI->errstr;
	  $sth->execute("$Cookies{'id'}") or die print "Couldn't execute statement: $DBI::errstr; stopped";
		my ( $total ) = $sth->fetchrow_array();

         $limit = "20";  # Results per page

      my $pages = ($total/$limit);
         $pages = ($pages+0.5);
      my $nume  = sprintf("%.0f",$pages);

      my $page  = $q->param('page') || "0";
         $nume  = "1" if !$nume;
         $to    = ($limit * $page) if  $page;
         $to    = "0"              if !$page;

      foreach (1..$nume) 
          {       
             my $nu = $_ -1;
                  if ($nu eq $page) { $link = "[<b>$_</b>]"; } else { $link = "$_"; }          
             my $string =  $ENV{'QUERY_STRING'};
                $string =~ s/&page=(.*)//g;
              
                $nav .= qq|<font face="verdana" size="1"><a href="$template{'mainfile'}?$string&page=$nu">$link</a> </font>|;
           }

            $template{'nav'} = $nav;
         my $show  = $limit *  $page;

         $statement = qq|SELECT * FROM perlDesk_calls WHERE username = "$uname" AND status != "CLOSED" ORDER BY $sort $method LIMIT $show, $limit|; 
         $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
         $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
             my $number=0;
      while(my $ref = $sth->fetchrow_hashref()) 
         {	
             my $img = "$global{'imgbase'}/mail.gif"   if $ref->{'method'} eq "em";
                $img = "$global{'imgbase'}/ticket.gif" if $ref->{'method'} ne "em";   

             my $bgcol;
             my $text = '#000000';
             if ($num == "2")   
                {
                      $bgcol   =  '#FFFFFF';
                      $num     = 0;
                }
                  else {
                         $bgcol   = '#F1F1F1';
                       }
            $number++;
            $listofcalls .= '  <table width="100%" border="0" cellspacing="1" cellpadding="3" align="center"><tr bgcolor="' . "$bgcol" . '"><td height="11" width="6%"><center>' . "<img src=\"$img\">" . '</center></td>
            		       <td height="11" width="6%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="' . "$text\"><a href=\"$template{'mainfile'}?do=view&cid=$ref->{'id'}\">$ref->{'id'}" . '</a></font></td>
            	               <td height="11" width="10%"><font size="1" face="Verdana" color="' . "$text\">$ref->{'status'}" . '</font></td>
                 	       <td height="11" width="9%"><font size="1" face="Verdana"></font><font size=1 face=Verdana color=' . "$text><div align=center>$ref->{'priority'}</div>" . '</font></td>
                   	       <td height="11" width="45%"><a href="' . "$template{'mainfile'}" . '?do=view&cid=' . "$ref->{'id'}\&lang=$language" . '"><font size=1 face=Verdana color=' . "$text>$ref->{'subject'}" . '</a></font></td>
            		       <td height="11" width="24%"><font size=1 face=Verdana color=' . "$text>$ref->{'time'}" . '</font></td></tr></table>';
            $num++;
            $to++;
     	}
            $sth->finish;

        if (! $listofcalls)  
          {
                           $listofcalls = '<table width="100%" border="0" cellspacing="1" align="center">
                                           <tr bgcolor="#FBFBFB"><td height="11" colspan="5"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">0 
                                           ' . "$LANG{'request'}" . '</font></td></tr></table>';
          }
 
         my $opencalls = "<font size=2>$LANG{'inindex1'} <b>$total</b> $LANG{'inindex2'}.</font><br>";
        
        $template{'from'}         = $limit * $page;
        $template{'to'}           = $to; 
        $template{'total'}        = $total;
        $template{'announcement'} = $notice;
        $template{'numcalls'}     = $opencalls;
        $template{'listofcalls'}  = $listofcalls;

       parse("$global{'data'}/include/tpl/membermain");
      
 
 }

 if ($section eq "lpass") {
       print "Content-type: text/html\n\n";
       parse("$global{'data'}/include/tpl/resetpass");
       

   }


#~~
# TRACK CALL
#~~


 if ($section eq "track") 
   {
       print "Content-type: text/html\n\n";
       parse("$global{'data'}/include/tpl/track");
   }


 if ($section eq "track_reply")
  {
     if (get_setting_2("access_respond"))  
         {
             check_user();
         } 
            else { $ignorenav = 1;  }


        $template{'trackno'} =  $q->param('id');
	$statemente          = 'SELECT * FROM perlDesk_calls WHERE id = ?'; 
	$sth = $dbh->prepare($statemente) or die "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute( $template{'trackno'} ) or die "Couldn't execute statement: $DBI::errstr; stopped";
		   while(my $ref = $sth->fetchrow_hashref())
                        {
	         			$template{'username'}    = $ref->{'username'};
	        			$template{'email'}       = $ref->{'email'};
	        			$template{'url'}         = $ref->{'url'};
	        			$cuser                   = $ref->{'name'};
	         			$template{'priority'}    = $ref->{'priority'};
	        			$template{'category'}    = $ref->{'category'};
	         			$template{'subject'}     = $ref->{'subject'};
	        			$template{'description'} = $ref->{'description'};
	        			$template{'date'}        = $ref->{'time'};
	        			$template{'status'}      = $ref->{'status'};
                                        $active                  = $ref->{'active'}; 
                                        $logged                  = $ref->{'track'}; 
                                        $key                     = $ref->{'ikey'};
	        		
                        }
        if (($sth->rows == 0) || ($error == "1")) {  die_nice("Request `$trackedcall' does not exist or is not owned by you"); }      
        if ($key ne $q->param('key')) { die_nice("Invalid Key For Ticket");}

     print "Content-type: text/html\n\n";

	 $note   = $q->param('note');
	 $ticket = $q->param('ticket');
         $name   = $q->param('name');

      my $time = time();
         $dbh->do(qq|UPDATE perlDesk_calls SET active = "$time" WHERE id = "$ticket"|);

	execute_sql(qq|UPDATE perlDesk_calls SET aw = "1" WHERE id = "$ticket"|);

     if ($note ne "")  
     {
        $note  =~ s/</&lt;/g;
        $note  =~ s/>/&gt;/g;

      my @chars =  (A..Z);          $key   =  $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)];          

      $sth = $dbh->prepare( "INSERT INTO perlDesk_notes VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )" ) or die "couldnt prepare statement";
      $sth->execute( "NULL", "0", "1", "NULL", $ticket, $name, $hdtime, $key, $note, $ENV{'REMOTE_ADDR'} ) or die "Couldnt execute statement";

        notify_techs( tid => "$ticket", note => "$note", name => "$template{'name'}", time => "$hdtime" );
     }

       parse("$global{'data'}/include/tpl/track_save");
 
 }


 if ($section eq "track_call")
  {
     if (get_setting_2("access_view"))  
         {
             check_user();
         } 

        $template{'trackno'} =  $q->param('id');
        $trackedcall         =  $template{'trackno'};
        $template{'key'}     =  $q->param('key');

	$sql = 'SELECT * FROM perlDesk_calls WHERE id = ?'; 
	$sth = $dbh->prepare( $sql ) or die "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute( $template{'trackno'} ) or die "Couldn't execute statement: $DBI::errstr; stopped";
		   while(my $ref = $sth->fetchrow_hashref())
                        {
	         			$template{'username'}    = $ref->{'username'};
	        			$template{'email'}       = $ref->{'email'};
	        			$template{'url'}         = $ref->{'url'};
	        			$cuser                   = $ref->{'name'};
	         			$template{'priority'}    = $ref->{'priority'};
	        			$template{'category'}    = $ref->{'category'};
	         			$template{'subject'}     = $ref->{'subject'};
	        			$template{'description'} = $ref->{'description'};
	        			$template{'date'}        = $ref->{'time'};
	        			$template{'status'}      = $ref->{'status'};
                                        $active                  = $ref->{'active'}; 
                                        $logged                  = $ref->{'track'}; 
                                        $key                     = $ref->{'ikey'};
	        		
                        }

        if (($sth->rows == 0) || ($error == "1")) {  die_nice("Request `$trackedcall' does not exist or is not owned by you"); }
        if ($key ne $q->param('key'))             {  die_nice("Invalid Key For Ticket");}
 
     print "Content-type: text/html\n\n";

           $search_string = $q->param('highlight');
	my $statement = 'SELECT id, cid, filename FROM perlDesk_files WHERE cid = ?';  		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";  		$sth->execute( $trackedcall ) or die print "Couldn't execute statement: $DBI::errstr; stopped"; 		while(my $ref = $sth->fetchrow_hashref())  		   { 				$template{'filename'} = qq|$ref->{'filename'} (You must login to download attachments)|; 		   }
              if ($sth->rows == "0") { $template{'filename'} = qq|No File|; }

         $statemente = 'SELECT * FROM perlDesk_notes WHERE call = ? ORDER BY id;'; 
 	 $sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	 $sth->execute($trackedcall) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	     while(my $ref = $sth->fetchrow_hashref())  {

               $comment = "$ref->{'comment'}";
               $comment = pdcode("$comment");


    my $tatement = 'SELECT * FROM perlDesk_files WHERE nid = ?';      my $th = $dbh->prepare($tatement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";        $th->execute($ref->{'id'}) or die print "Couldn't execute statement: $DBI::errstr; stopped";     while(my $ef = $th->fetchrow_hashref())        {	
           $filename = qq|$ef->{'filename'} (You must login to download this file)|;
      }
    if ($th->rows == "0") { $filename = "No File Attached"; }

          if ($ref->{'owner'} eq 0) {
             if ($comment =~ /^</) { } else { $comment =~ s/\n/<br>/g; }
					$notes .= '<table width="100%" border="0" cellspacing="1" cellpadding="3"><tr class="userresponse">' . "<a name=\"$ref->{'id'}\">" . '</a> 
    						   <td width="30%" height="14" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>' . "$ref->{'author'}" . '<br>
    						   </b></font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . "$ref->{'time'}" . '<br><br><a href="' . "$template{'mainfile'}" . '?do=editnote&nid=' . "$ref->{'id'}&lang=$language" . '">EDIT</a> </font></td>
    						   <td width="70%" height="14" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . "$comment" . '</font></td></tr></table>';
		} elsif ($ref->{'owner'} eq 1) {
				next if $ref->{'visible'} eq 0;
			if ($comment =~ /^</) { } else {
					$comment =~ s/\n/<br>/g;
			}


         $statement = 'SELECT name FROM perlDesk_staff WHERE id = ?';           $th = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";  		$th->execute($ref->{'author'}) or die print "Couldn't execute statement: $DBI::errstr; stopped";          	  while(my $f = $th->fetchrow_hashref())  	            {  $template{'author'} = $f->{'name'}; }

			              $notes .= qq|<table width="100%" border="0" cellspacing="1" cellpadding="3"><tr class="userstaffresponse"><a name="$ref->{'id'}"></a>
    						   <td width="30%" height="14" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>$template{'author'}<br>
    						   </b></font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">$ref->{'time'}<br><br></font></td><td width="70%" height="14" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">$comment<br><BR><BR>-----------<br>$filename</font></td></tr><tr class="userstaffresponse"> <td colspan=2 valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><div align=right><a href=$template{'mainfile'}?do=rate_response&nid=$ref->{'id'}&key=$ref->{'ikey'}>Rate This Response</a></div></font></td></tr></table>|;
     		}
    	}

    	$dbh->disconnect;

    	if (!$notes) 
          {
     		$notes = '<table width="95%" border="0" cellspacing="0" align="center">
                          <tr><td colspan="3"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">No 
                           notes added.</font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></td></tr></table>';
    	  } 


      $template{'description'}  =~  s/\n/<br>/g if $template{'description'} !~ /^</;
      $template{'description'}  =   pdcode("$template{'description'}");
      $template{'description'}  =~ s/$search_string/<font color=#FF0000>$search_string<\/font>/ig if $search_string;
         
      $template{'notes'}        =   $notes;

      $current_time = time();

      my $now         =  $current_time;
      my $difference  =  $now - $active;

            if ($difference >= 86400) 
             {
                   $period    =  "day";
                   $count     =  $difference / 86400;
             } elsif ($difference >= 3600) 
               {
                   $period    =  "hour";
                   $count     =  $difference / 3600;
               } elsif ($difference >= 60)  
                  {
                     $period  =  "minute";
                     $count   =  $difference / 60;
                  } else
                     {
                        $period = "second";
                        $count = $difference;
                     }

            $count = sprintf("%.0f", $count);

            if ($count != 1) { $period .= "s"; }
      $template{'ltime'} =  $count . ' ' . $period; 
      $tdifference       =  $current_time - $logged;

            if ($tdifference >= 86400) 
             {
                   $tperiod   = "day";
                   $tcount    = $tdifference / 86400;
             } elsif ($tdifference >= 3600) 
               {
                   $tperiod   = "hour";
                   $tcount    = $tdifference / 3600;
               } elsif ($tdifference >= 60)  
                  {
                     $tperiod = "minute";
                     $tcount  = $tdifference / 60;
                  } else
                     {
                        $tperiod = "second";
                        $tcount = $difference;
                     }

            $tcount = sprintf("%.0f", $tcount);

            if ($tcount != 1) { $tperiod .= "s"; }

      $template{'ttime'} = $tcount . ' ' . $tperiod; 


      parse("$global{'data'}/include/tpl/track_view");

  }



#~~

#~~
# Rate a Response
#~~

 if ($section eq "rate_response")
  {
      my $nid = $q->param('nid');
      my $key = $q->param('key');

	$sth = $dbh->prepare(qq|SELECT id,author,ikey FROM perlDesk_notes WHERE id = "$nid"|)  or die "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute( ) or die "Couldn't execute statement: $DBI::errstr; stopped";
	      while(my $ref = $sth->fetchrow_hashref()) 
                {    
                      $author             =  $ref->{'author'};
                      $template{'id'}     =  $ref->{'id'};
                      $template{'key'}    =  $key;
                      die_nice("Sorry, you are not permitted to view this page") if $key ne $ref->{'ikey'} || !$key;
                }


         $statement = 'SELECT name FROM perlDesk_staff WHERE id = ?';           $th = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";  		$th->execute($author) or die print "Couldn't execute statement: $DBI::errstr; stopped";          	  while(my $f = $th->fetchrow_hashref())  	            {  $template{'author'} = $f->{'name'}; }


 	$statemente = 'SELECT nid FROM perlDesk_reviews WHERE nid = ?'; 
	$sth = $dbh->prepare($statemente)  or die "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute( $nid ) or die "Couldn't execute statement: $DBI::errstr; stopped";
        die_nice("Sorry, you seem to have already rated this response") if $sth->rows > "0";

        
  
       print "Content-type: text/html\n\n";
       parse("$global{'data'}/include/tpl/rate_response");
  }

 if ($section eq "save_rate")
  {
       my $nid    = $q->param('nid');
       my $author = $q->param('name');
       my $text   = $q->param('comments');
       my $key    = $q->param('key');
       my $rating = $q->param('rating');

    if ($nid)
     {
 	$statemente = 'SELECT id,author,ikey FROM perlDesk_notes WHERE id = ?'; 
	$sth = $dbh->prepare($statemente)  or die "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute( $nid ) or die "Couldn't execute statement: $DBI::errstr; stopped";
	      while(my $ref = $sth->fetchrow_hashref()) 
                {    
                      $template{'author'} = $ref->{'author'};
                      $template{'id'}     = $ref->{'id'};
                      die_nice("Sorry, you are not permitted to view this page") if $key ne $ref->{'ikey'};
                }

 	$statemente = 'SELECT nid FROM perlDesk_reviews WHERE nid = ?'; 
	$sth = $dbh->prepare($statemente)  or die "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute( $nid ) or die "Couldn't execute statement: $DBI::errstr; stopped";
        die_nice("Sorry, you seem to have already rated this response") if $sth->rows > "0";

    	     $rv = $dbh->do(qq{INSERT INTO perlDesk_reviews values (      	          "NULL", "$author", "$template{'author'}", "$nid", "$rating", "$text")}     	     );
        }
                print "Content-type: text/html\n\n";
		print qq| 					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=$template{'mainfile'}"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank you - your rating has been saved</b></font><br><br> 					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="$template{'mainfile'}">click  					here</a> if you are not automatically forwarded</font></p></html>                         |;
  }

#~~
# View File
#~~


#~~

if ($section eq "view_file")
  {
     check_user();

         $file = $q->param('id');

	my $statement = 'SELECT nid,filename, file FROM perlDesk_files WHERE id = ?';  		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";  		$sth->execute( $file ) or die print "Couldn't execute statement: $DBI::errstr; stopped"; 		while(my $ref = $sth->fetchrow_hashref())  		   { $nid = $ref->{'nid'}; $name = $ref->{'filename'}; $filename = $ref->{'file'}; }
        
      
 	$statemente = 'SELECT call FROM perlDesk_notes WHERE id = ?'; 
	$sth = $dbh->prepare($statemente)  or die "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute( $nid ) or die "Couldn't execute statement: $DBI::errstr; stopped";
	      while(my $ref = $sth->fetchrow_hashref()) 
                {
                      $call  =  $ref->{'call'};
                }

	$statement = 'SELECT username FROM perlDesk_calls WHERE id = ?'; 
	$sth = $dbh->prepare($statement) or die "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute($call) or die "Couldn't execute statement: $DBI::errstr; stopped";
	      while(my $ref = $sth->fetchrow_hashref()) 
                {
                      die_nice("Sorry you do not have access to this file") if $ref->{'username'} ne "$Cookies{'id'}";
                }


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




 if ($section eq "emailreq") {

       check_user();

         $template{'trackno'} = $q->param('cid');

       print "Content-type: text/html\n\n";

        parse("$global{'data'}/include/tpl/emailreq");
          }


 if ($section eq "emailreqsend") {

       check_user();
       my $trackno = $q->param('id');
          
 print "Content-type: text/html\n\n";
       
 my $email = $q->param('email');    
 my $id    = $q->param('id');
 
 die_nice("No Ticket Specified") if !$id;

 $statement = 'SELECT * FROM perlDesk_calls WHERE  id = ?'; 
   $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
   $sth->execute($id) or die print "Couldn't execute statement: $DBI::errstr; stopped";
      $number=0;
          while(my $ref = $sth->fetchrow_hashref()) {	

           if (($ref->{'username'} != $Cookies{'id'}) || ($ref->{'owner'})) 
             {
                 die_nice("ERROR: You are not authorised to view this call!");
             }			

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
			$url         =  $ref->{'url'};
			$name        =  $ref->{'name'};
       }

$body .= qq|
Below is a copy of your request, including any user/staff responses:

----------------------------------------------------------
REQUEST $id
----------------------------------------------------------  

STATUS....: $status 
LOGGED....: $date
SUBJECT...: $subject                 

----------------------------------------------------------
$description
---------------------------------------------------------- 
|;

	$statemente = 'SELECT * FROM perlDesk_notes WHERE call = ? ORDER BY id;'; 
	$sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute($id) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	      while(my $ref = $sth->fetchrow_hashref()) {
				$cbody = $ref->{'comment'};
                $cbody =~ s/<br>/\n/g;
                $body .= qq|
:: RESPONSE $ref->{'author'} ($ref->{'time'})
$cbody
---------------------------------------------------------- 

|;
 
  }
  
  email( To => "$email", From => "$global{'adminemail'}", Subject => "Support Request $id", Body => "$body");
       
    	print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=$template{'mainfile'}?do=view&cid=$id"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank You</b>, a copy of this request has been emailed to $email.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="$template{'mainfile'}?do=view&cid=$id">click 
					here</a> if you are not automatically forwarded</font></p></html>
                |;
  }

 if ($section eq "setpass") {

     $username  =  $q->param('username');
     $email     =  $q->param('email');
     $statement = 'SELECT * FROM perlDesk_users WHERE username = ?'; 
     $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
     $sth->execute($username) or die print "Couldn't execute statement: $DBI::errstr; stopped";
    while(my $ref = $sth->fetchrow_hashref()) 
     {	
         $name  = $ref->{'name'};
         $uname = $ref->{'username'};
         $salt  = $ref->{'rkey'};

         if ($email ne $ref->{'email'}) 
           {
             $error .= "Email/Username combination invalid";
          }
     }
     $sth->finish;

     if (!$uname) 
      {
         $error .= "Username does not exist";
      }

    die_nice("$error") if $error;
 
	my @chars=(A..Z);
	my $pass= $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)];
	my $password = crypt($pass, $salt);	
	
	$statementd = 'UPDATE perlDesk_users SET password = "' . "$password" . '" WHERE username = "' . "$username" . '";'; 
	 $sth = $dbh->prepare($statementd) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
    $sth->finish;

    my $subject = "Support Password";

    	open (MAILNEWTPL,"$global{'data'}/include/tpl/newpass.txt");
          while (<MAILNEWTPL>) 
               {
                    lang_parse();
      				  if ($_ =~ /\{*\}/i) 
                       { 
				        	s/\{baseurl\}/$global{'baseurl'}/g;
				        	s/\{name\}/$name/g;
				        	s/\{username\}/$username/g;
				        	s/\{password\}/$pass/g;
                            s/\{mainfile\}/$template{'mainfile'}/g;
				       }			
                   $body .= $_;
               }
           close(MAILNEWTPL);	

         email ( To => "$email", From => "$global{'adminemail'}", Subject => "$subject", Body => "$body" );
         print "Content-type: text/html\n\n";  
         parse("$global{'data'}/include/tpl/emailedpass");
         
  }

if ($section eq "closereq") {

   check_user();
   print "Content-type: text/html\n\n";

   my $trackno             =  $q->param('id');
      $template{'trackno'} =  $trackno;
   parse("$global{'data'}/include/tpl/closereq");
   
  exit;
}

if ($section eq "closesave") {

   check_user();
 
   print "Content-type: text/html\n\n";

  $callid    =  $q->param('id');
  $comments .=  "[b]TICKET CLOSED BY USER[/b]<br>";
  $comments .=  $q->param('reason'); 

      my @chars =  ("A..Z","0..9","a..z");          $key   =  $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)];           
    my $rv = $dbh->do(qq{INSERT INTO perlDesk_notes values (
        "NULL", "0", "1", "CLOSED", "$callid", "$Cookies{'id'}", "$hdtime", "$key", "$comments", "$ENV{'REMOTE_ADDR'}")}
   );

   $statement = 'UPDATE perlDesk_calls SET status = "CLOSED" WHERE id = ?'; 
   $sth       = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
   $sth->execute($callid) or die print "Couldn't execute statement: $DBI::errstr; stopped";

   my $sdsth = $dbh->prepare( "INSERT INTO perlDesk_activitylog VALUES ( ?, ?, ?, ?, ?)" );
      $sdsth->execute( "NULL", $callid, $hdtime, "User", "Request Closed By User" ) or die "Couldn't execute statement: $DBI::errstr; stopped";

     	print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=$template{'mainfile'}?do=view&cid=$callid"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank You</b>, this request has now been closed.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="$template{'mainfile'}?do=view&cid=$callid">click 
					here</a> if you are not automatically forwarded</font></p></html>
                |;
 }


if ($section eq "reopen") 
 {

    check_user();
    print "Content-type: text/html\n\n";

     my $trackno             =  $q->param('id');
        $template{'trackno'} =  $trackno;
     parse("$global{'data'}/include/tpl/reopen");
  

    exit;
 }

if ($section eq "re_open") {

     check_user();
     print "Content-type: text/html\n\n";

     $callid    =  $q->param('id');
     $comments .=  "[b]TICKET RE-OPENED BY USER[/b]<br>";
     $comments .=  $q->param('reason'); 
     $ecomment  =  $q->param('reason'); 
 
      my @chars =  ("A..Z","0..9","a..z");          $key   =  $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)];          
      my $rv = $dbh->do(qq{INSERT INTO perlDesk_notes values (
             "NULL", "0", "1", "RE-OPEN", "$callid", "$Cookies{'id'}", "$hdtime", "$key", "$comments", "$ENV{'REMOTE_ADDR'}")}
           );

       execute_sql(qq|UPDATE perlDesk_calls SET status = "OPEN", aw = "1" WHERE id = "$callid"|);

     my $sdsth = $dbh->prepare( "INSERT INTO perlDesk_activitylog VALUES ( ?, ?, ?, ?, ?)" );
        $sdsth->execute( "NULL", $callid, $hdtime, "User", "Request Re-Opened" ) or die "Couldn't execute statement: $DBI::errstr; stopped";


        # Send the email to the assigned staff member when the priority is changed
 
            $statement = qq#SELECT category, subject FROM perlDesk_calls WHERE id = "$callid"#; 
            $sth = $dbh->prepare($statement)or die print "Couldn't prepare statement: $DBI::errstr; stopped";
            $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
               while(my $ref = $sth->fetchrow_hashref()) 
                  { $category = $ref->{'category'}; $subject = $ref->{'subject'}; }

            $statement = qq#SELECT * FROM perlDesk_staff WHERE access LIKE "%GLOB::%" OR access LIKE "%$category%"#; 
            $sth = $dbh->prepare($statement)or die print "Couldn't prepare statement: $DBI::errstr; stopped";
            $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
               while(my $ref = $sth->fetchrow_hashref()) 
                  {
                        if ($ref->{'notify'} == "1" && $enablemail) {

                       my $to   =  $ref->{'email'};
                       my $esubject = "Request Re-Opened";

                       my $msg = qq|
Ticket Details
------------------------------------------
Ticket ID.............: $callid
Logged by.............: $Cookies{'id'}
Category..............: $category
subject...............: $subject

Reason
------------------------------------------
$ecomment

------------------------------------------

URL: $global{'baseurl'}/staff.cgi?do=login

Thank You
|;

email ( To => "$to", From => "$global{'adminemail'}", Subject => "$esubject", Body => "$msg" );
} 
}

$sth->finish;


     	print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=$template{'mainfile'}?do=view&cid=$callid"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank You</b>, this request has now been re-opened.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="$template{'mainfile'}?do=view&cid=$callid">click 
					here</a> if you are not automatically forwarded</font></p></html>
                |;
}

if ($section eq "changepri") 
 {
    check_user();
    print "Content-type: text/html\n\n";

     $callid     =  $q->param('cid');
     $statemente = 'SELECT * FROM perlDesk_calls WHERE id = ?'; 
	 $sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	 $sth->execute($callid) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	   while(my $ref = $sth->fetchrow_hashref()) 
             {
			if (($ref->{'username'} != $Cookies{'id'}) || ($ref->{'owner'})) 
			{
				die_nice("ERROR: You are not authorised to edit this call!");
				
			} 
       		      $priority = $ref->{'priority'};
             }
       $response = '<form action="' . "$template{'mainfile'}" . '" method="post"><table width="60%" border="0" align="center"><tr><td width="44%">&nbsp;</td>
            		<td width="21%">&nbsp;</td><td width="35%">&nbsp;</td></tr><tr><td width="44%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>' . "$LANG{'update'}" . ' 
              		' . "$LANG{'priority'}" . '</b></font></td><td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              		<div align=center><select name="priority"  style="font-size: 12px"><option value="1">1 - Urgent</option>
                	<option value="2">2</option><option value="3" selected>3</option><option value="4">4</option><option value="5">5 - Inquiry</option></select></div></font></td></tr><tr><td width="44%">&nbsp;</td>
            		<td colspan="2">&nbsp;</td></tr><tr><td colspan="3"><div align="center"><input type="hidden" name="do" value="savepri"><input type="hidden" name="ticket" value="' . "$callid" . '"><input type="submit" name="Submit2" value="Submit">
              		</div></td></tr></table></form>';

      $template{'response'}  = $response;

      parse("$global{'data'}/include/tpl/general");

}


if ($section eq "savepri") 
 {
    check_user(); 
    print "Content-type: text/html\n\n";

    my $ticket    = $q->param('ticket');
    my $priority  = $q->param('priority');

    $statement = 'UPDATE perlDesk_calls SET priority = "' . "$priority" . '" WHERE id = "' . "$ticket" . '";'; 
	$sth       = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";

     	print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=$template{'mainfile'}?do=view&cid=$ticket"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank You</b>, the priority of this request has been updated.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="$template{'mainfile'}?do=view&cid=$ticket">click 
					here</a> if you are not automatically forwarded</font></p></html>
                |;
 }

if ($section eq "login") 
  {

    if ($ignore != "1") 
     {
          check_user();
          print "Location: $global{'baseurl'}/$template{'mainfile'}?do=main\n\n" if $loggedin == "1";
          exit;
      }

    print "Content-type: text/html\n\n";
    parse("$global{'data'}/include/tpl/login");
    
   exit;

  }



#~~
# User Registration
#~~

if ($section eq "register")  
 {
    print "Content-type: text/html\n\n";
 
     foreach (qw/username password password2 error name email url company/)
        {
             $template{$_} = "";
        }

    my $statement = 'SELECT * FROM perlDesk_signup_fields ORDER BY dorder'; 
    my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
       $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
    while(my $ref = $sth->fetchrow_hashref()) 
      {	   
          $value = $q->param($ref->{'id'});

          $template{'fields'} .= qq|<tr><td width="32%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'name'}</font></td><td width="68%">
                                  <input type="text" class="tbox"  name="$ref->{'id'}" value="$value" size="35"></font></td></tr>
                                 |;
      }
    $sth->finish;


    parse("$global{'data'}/include/tpl/register");
 }



if ($section eq "register2")
 {

    print "Content-type: text/html\n\n";
 
    my  $user     =  $q->param('username');
    my  $pass     =  $q->param('password');
    my  $pass2    =  $q->param('password2');
    my  $name     =  $q->param('name');
    my  $email    =  $q->param('email');
    my  $url      =  $q->param('url');
    my  $company  =  $q->param('company');
    my  $exists; 	

     foreach (qw/username password password2 name email/)
        {
             $error .= qq|$LANG{'error3'} $_<br>| if !$q->param($_) && $_ ne "company";
             $template{$_} = $q->param($_);
        }

   if (!$error)
    {

    my  $sth = $dbh->prepare("SELECT * FROM perlDesk_users WHERE username = ?") or die print "Couldn't prepare statement: $DBI::errstr; stopped";
  	$sth->execute($user) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	while(my $ref = $sth->fetchrow_hashref())
         {         
            if ($user) {
 	   		   if ($ref->{'username'} eq "$user") 
                            {
                                $error .= "$LANG{'username'} <b>$user</b> $LANG{'error2'}<br>"; $exists =1;
                            }
                       }
         } 

        $error .= "$LANG{'username'} <b>$user</b> $LANG{'error2'}" if $user =~ /^unregistered\b/i;

		if (!$exists) 
                {

                          $pass_chars = get_setting_2("pass_chars");

                          $error .= "Your password must be a minimum of $pass_chars charachters<br>" if (length($pass) < $pass_chars);
                          $error  .= "$LANG{'error3'} $LANG{'username'}<br>"       if !$user;
                          $error  .= "$LANG{'error3'} $LANG{'password'}<br>"       if !$pass || !$pass2;
                          $error  .= "The username cannot contain spaces<br>"         if $user =~ / /;
                          $error  .= "$LANG{'username'} <b>$user</b> $LANG{'error2'}" if $user =~ /^unregistered\b/i;
                          $error  .= "$LANG{'error4'}"                                if $pass ne $pass2;
                 }
    }


   if ($error)
    {
       #~~ Problem with registration ~~#
 
       $template{'error'} = qq|<ul>$error</ul>|;

       my $statement = 'SELECT * FROM perlDesk_signup_fields ORDER BY dorder'; 
       my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
          $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
        while(my $ref = $sth->fetchrow_hashref()) 
           {  	   
              $value = $q->param($ref->{'id'});

              $template{'fields'} .= qq|<tr><td width="32%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'name'}</font></td><td width="68%">
                                        <input type="text" class="tbox"  name="$ref->{'id'}" value="$value" size="35"></font></td></tr>
                                       |;
           }
          $sth->finish;


       parse("$global{'data'}/include/tpl/register");
       exit;
    }
	
    $template{'email'} = $email;

	my  $sth = $dbh->prepare("SELECT * FROM perlDesk_users WHERE username = ?") or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute($user) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
        {
				if ($ref->{'username'} eq "$user") 
                   {
                      die_nice("Username <b>$user</b> alredy exists<br>");
             	   }
 	    } 
     	$sth->finish;   

    $template{'user'}     = $user;    
    $template{'username'} = $user;
    $template{'password'} = $pass;
    $template{'cname'}    = $name; 

        parse("$global{'data'}/include/tpl/register3");
        
     	my @chars =  (A..Z);
     	my $salt  =  $chars[rand(@chars)] . $chars[rand(@chars)];
  
    	my $password = crypt($pass, $salt);	

        my $validate = $global{'validate'};
        my $reqconf  = $global{'reqvalid'};
 
        my $pending = '0' if $validate eq "0";
           $pending = '1' if $validate eq "1"; 
    

    if (get_setting_2("signup_notification")) { 

     my $msg = qq|
Administrator,

A new account has been created on your perlDesk installation ($global{'baseurl'}). If you have selected to validate new accounts you may login to the administration and review this signup.

   Username: $user
      Email: $email

Admin: $global{'baseurl'}/admin.cgi


perlDesk Notifications
|;
        email( To => $global{'adminemail'}, From => $global{'adminemail'}, Subject => "perlDesk: New Support Account", Body => "$msg");
   }

   
        execute_sql(qq{INSERT INTO perlDesk_users values ("NULL", "$user", "$password", "$name", "$email", "$url", "$company", "$salt", "$pending", "0", "$code", "0")});



     $id   =  $dbh->{'mysql_insertid'}; 

    if ($reqconf) 
     { 
            my @numbers  = (1..10);
               foreach (1..15) 
                 { 
                    $code .= $numbers[rand(@numbers)];
                 }

           $template{'link'} =  qq| $global{'baseurl'}/$template{'mainfile'}?do=activate&key=$code&uid=$id |;      
        my $body;

		open (MAILTPL, "$global{'data'}/include/tpl/activate.txt");
			while (<MAILTPL>) 
                          {
                               lang_parse() if $_ =~ /%*%/;
                               s/\{(\S+)\}/$template{$1}/g;
          		       $body .= $_;
			  }  
		close(MAILTPL);	
            email( To => "$email", From => $global{'adminemail'}, Subject => "Activate Account", Body => "$body");
            execute_sql(qq|UPDATE perlDesk_users SET acode = "$code" WHERE id = "$id"|);
    }
      else {

        my $code =  "0";

      if ($enablemail) 
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


            execute_sql(qq|UPDATE perlDesk_users SET acode = "$code" WHERE id = "$id"|);

  } # End Else   

} # End Register 3






#~~
# DOWNLOAD ATTACHMENT
#~~


if ($section eq "logout")  
 {
     check_user();

     $cookie1 = $q->cookie(-name=>'id',
                           -value=>'',
                           -path    =>  '/',
                           -domain  =>'');
     $cookie2 = $q->cookie(-name=>'pass',
                           -value=>'',
                           -path    =>  '/',
                           -domain =>'');
 
     print $q->header(-cookie=>[$cookie1,$cookie2]);

     my $response = "<b><font size=2>$LANG{'loggedout'}. <a href=$template{'mainfile'}?do=login>$LANG{'logbackin'}</a></font></b>";
        $template{'response'} = $response;

     parse("$global{'data'}/include/tpl/general");
     
  }


if ($section eq "notice") {

    check_user();
    print "Content-type: text/html\n\n";
    
    my $notice = $q->param('nid');
	$statement = 'SELECT * FROM perlDesk_announce WHERE users = "1" AND id = ?'; 
	$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute($notice) or die print "Couldn't execute statement: $DBI::errstr; stopped";
     while(my $ref = $sth->fetchrow_hashref()) 
      {	
        $notices .= '<table width="100%" border="0" cellspacing="1" cellpadding="0">
               		 <tr><td width="24%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">' . "$LANG{'author'}" . ':</font></td><td width="76%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">' . "$ref->{'author'}" . '</font></td>
              		 </tr><tr><td width="24%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">' . "$LANG{'time'}" . ':</font></td><td width="76%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">' . "$ref->{'time'}" . '</font></td>
              		 </tr><tr><td width="24%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></td><td width="76%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></td>
              		 </tr><tr><td width="24%" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">' . "$LANG{'subject'}" . ':</font></td><td width="76%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>' . "$ref->{'subject'}" . '</b><br><br></font></td>
              		 </tr><tr><td width="24%" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">' . "$LANG{'announcement'}" . ':</font></td><td width="76%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">' . "$ref->{'message'}" . '</font></td></tr></table>';

      }
       $template{'announcement'} = $notices;
      parse("$global{'data'}/include/tpl/announcement");
      

  }

if ($section eq "listcalls") {

    check_user();
    print "Content-type: text/html\n\n";
    my $num    =  1;
    my $status =  $q->param('status');
    my $type   =  $status;

    if (defined $q->param('sort')) 
      { 
         $sort = $q->param('sort');
      }   
     else {
             $sort = "id"; 
          }

     if (defined $q->param('method')) {  if ($q->param('method') eq "asc") { $method = "ASC"; } else { $method = "DESC"; }  }
     else {  $method = "ASC"; }

     if ($status eq "closed") { $method = "DESC" if !$q->param('method'); } 
  

   my $sql = 'SELECT COUNT(*) FROM perlDesk_calls WHERE username = ? AND status != "CLOSED"' if $status eq "open"; 
      $sql = 'SELECT COUNT(*) FROM perlDesk_calls WHERE username = ? AND status = "CLOSED"'  if $status eq "closed"; 
  
   my $threaded = $q->param('threaded');

      $sth = $dbh->prepare($sql) or die DBI->errstr;
	  $sth->execute("$Cookies{'id'}") or die print "Couldn't execute statement: $DBI::errstr; stopped";
		my ( $total ) = $sth->fetchrow_array();

         $limit = "20";  # Results per page

      my $pages = ($total/$limit);
         $pages = ($pages+0.5);
      my $nume  = sprintf("%.0f",$pages);
      my $page  = $q->param('page') || "0";
         $nume  = "1" if !$nume;
         $to    = ($limit * $page) if  $page;
         $to    = "0"              if !$page;

      foreach (1..$nume) 
          {       
             my $nu = $_ -1;
                  if ($nu eq $page) { $link = "[<b>$_</b>]"; } else { $link = "$_"; }          
             my $string =  $ENV{'QUERY_STRING'};
                $string =~ s/&page=(.*)//g;
                $nav   .= qq|<font face="verdana" size="1"><a href="$template{'mainfile'}?$string&page=$nu">$link</a> </font>|;
           }

            $template{'nav'} = $nav;
         my $show  = $limit *  $page;

      $statemente = qq|SELECT * FROM perlDesk_calls WHERE username = ? AND status != "CLOSED" ORDER BY $sort $method LIMIT $show, $limit| if $status eq "open"; 
      $statemente = qq|SELECT * FROM perlDesk_calls WHERE username = ? AND status = "CLOSED" ORDER BY $sort $method LIMIT $show, $limit| if $status eq "closed"; 

      $sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
      $sth->execute("$Cookies{'id'}") or die print "Couldn't execute statement: $DBI::errstr; stopped";
      while(my $ref = $sth->fetchrow_hashref()) {
     
         my $img = "$global{'imgbase'}/mail.gif"   if $ref->{'method'} eq "em";
            $img = "$global{'imgbase'}/ticket.gif" if $ref->{'method'} ne "em"; 
         my $text = '#000000';
		 my $subject = $ref->{'subject'}; 
		    $subject = substr($subject,0,20).'..' if length($subject) > 22;     

       if ($threaded) { $bgcol = '#FOFOFO'; }
       else {
 		 if ($num eq "2") 
                  {
      			$bgcol = '#FFFFFF';
    			$num = 0;
     	 	  }
                  else {
			           $bgcol = '#F0F0F0';
             	  	}
         }
         		$listofcalls .= '<table width="100%" border="0" cellspacing="1" cellpadding="4" align="center"><tr bgcolor="' . "$bgcol". '"><td height="11" width="5%"><center>' . "<img src=\"$img\">" . '</center></td><td height="11" width="7%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="' . "$text\"><a href=\"$template{'mainfile'}?do=view&cid=$ref->{'id'}\">$ref->{'id'}" . '</a></font></td>
         					     <td height="11" width="10%"><font size="1" face="Verdana" color="' . "$text\">$ref->{'status'}" . '</font></td><td height="11" width="9%"><font size="1" face="Verdana"></font><font size=1 face=Verdana color=' . "$text><div align=center>$ref->{'priority'}</div>" . '</font></td>
            				     <td height="11" width="45%">' . "<a href=\"$template{'mainfile'}?do=view&cid=$ref->{'id'}\&lang=$language\">" . '<font size=1 face=Verdana color=' . "$text>$subject" . '</a></font></td>
        					     <td height="11" width="24%"><font size=1 face=Verdana color=' . "$text>$ref->{'time'}" . '</font></td></tr></table>';
               if ($threaded) 
                 {
                         my $sql = qq|SELECT * FROM perlDesk_notes WHERE call = $ref->{'id'} AND visible = "1" AND action != "ASSIGN" ORDER BY id|; 
	                        $ssth = $dbh->prepare($sql) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
                          	$ssth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";       
                	      while(my $sref = $ssth->fetchrow_hashref()) {
       
                           $sref->{'comment'} =~ s/\n//;

                           my $comment   =  substr($sref->{'comment'},0,54);
                              $comment  .=  '....' if length($sref->{'comment'}) > 54;
                              $comment   =~ s/\[b\]//g; 
                              $comment   =~ s/\[\/b\]//g;
                              $comment   =~ s/<br>//g;  
                      
                           $listofcalls .= qq~<table width="100%" border="0" cellpadding="1" cellspacing="1"><tr><td width="5%" bgcolor="#FFFFFF"></td>
                                              <td width="7%" bgcolor="#F9F9F9"><font size="1" face="Arial, Helvetica, sans-serif"><div align="center">[ - ]</div></font></td>
                                              <td width="19%" bgcolor="#F9F9F9"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="$template{'mainfile'}?do=view&cid=$ref->{'id'}&lang=$language#$sref->{'id'}"><font color="#000000">$sref->{'author'}</font></a></font></td>
                                              <td width="69%" bgcolor="#F9F9F9"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="$template{'mainfile'}?do=view&cid=$ref->{'id'}&lang=$language#$sref->{'id'}"><font color="#000000">$comment</font></a></font></td></tr></table>~;
                      }   
                   }
                     $num++;
		             $to++;
          		}

	if (! $listofcalls) 
         {
	          	$listofcalls = '<table width="100%" border="0" cellspacing="1" align="center">
                              	<tr bgcolor="#FBFBFB"><td height="11" colspan="5"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">0 Tickets</font></td></tr></table>';
		 }


    my $pm  = '-' if  $threaded;
       $pm  = '+' if !$threaded;

    my $inm  = 'COLLAPSE' if $threaded;
       $inm  = 'EXPAND'  if !$threaded;


    my $val = '0' if  $threaded;
       $val = '1' if !$threaded;
       $template{'path'} =  $template{'mainfile'} . '?' . $ENV{'QUERY_STRING'};

    $template{'path'} =~ s/&sort=(.*)//;
    $template{'path'} =~ s/&method=(.*)//;
   
    $ENV{'QUERY_STRING'} =~ s/&threaded=0//;
    $ENV{'QUERY_STRING'} =~ s/&threaded=1//;

    my $url = qq~<a href="$template{'mainfile'}?$ENV{'QUERY_STRING'}&threaded=$val">$inm ($pm)</a>~;

    $template{'url'}         =   $url;
    $template{'from'}        =   $page * $limit;
    $template{'to'}          =   $to;
    $template{'total'}       =   $total;
    $template{'listofcalls'} =   $listofcalls;
    $template{'text'}        =   $texti;
    $template{'type'}        =   $type;

   parse("$global{'data'}/include/tpl/list");
   
  }


if ($section eq "profile") 
 {
     check_user();
     print "Content-type: text/html\n\n";


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
                                                    <tr> <td width="30%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'name'}</font></td>
                                                    <td width="70%"><input type="text"  style="font-size: 12px" name="ef_$ef->{'id'}" value="$value" size="30"> </td></tr>
                                                 |;    
                   } $template{'fields'} = "" if !$th->rows;

      }
    $sth->finish;

     parse("$global{'data'}/include/tpl/profile");
 
  }

if ($section eq "update_profile") {

   check_user();

   my (@errors);
   my ($error);
   my ($password);

     $name   =   $q->param('name');
     $email  =   $q->param('email');
     $url    =   $q->param('url');
     $pass1  =   $q->param('pass1');
     $pass2  =   $q->param('pass2');

   if (!$name) 
     {
		$error = "$LANG{'error5'} name";
	    push (@errors, $error);
 	 }
   elsif (!$email)
    {
		$error = "$LANG{'error5'} email address";
   	push(@errors,$error);
	}


    elsif ($pass1 ne $pass2)	
      {
       		$error = "The passwords specified do not match";
          	push(@errors,$error);
      }
 
     if (@errors) {  die_nice("@errors"); }



     if (!@errors) {

     print "Content-type: text/html\n\n";


     $dbh->do(qq|UPDATE perlDesk_users SET name = "$name", email = "$email", url = "$url" WHERE username = "$Cookies{'id'}"|);

	 $statemente = 'SELECT * FROM perlDesk_users WHERE username = "' . "$Cookies{'id'}" . '"'; 
	 $sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
        while(my $ref = $sth->fetchrow_hashref()) {


            $user_id = $ref->{'id'};
          
			if ($ref->{'password'} ne $cpass) {

				if (($pass1) && ($pass2)) {

					my @chars=(A..Z);

					$salt= $chars[rand(@chars)] . $chars[rand(@chars)];
					$cpass = crypt($pass1, $salt);	

					$statementd = 'UPDATE perlDesk_users SET password = "' . "$cpass" . '", rkey = "' . "$salt" . '" WHERE username = "' . "$Cookies{'id'}" . '";'; 
					$sth = $dbh->prepare($statementd) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
					$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
			}	}
		}


	 $statemente = qq|SELECT * FROM perlDesk_signup_values WHERE cid = "$user_id"|;  	 $sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";  		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";            while(my $ref = $sth->fetchrow_hashref())
             {
                my $field = 'ef_' . $ref->{'id'};
                my $value = $q->param($field);
                $dbh->do(qq|UPDATE perlDesk_signup_values SET value = "$value" WHERE id = "$ref->{'id'}"|);
                $template{'ef'} .= qq|<tr><td><font face="Verdana" size="2">$field_name</font></td><td><input type="textbox" name="ef_$ref->{'id'}" class="tbox" size="30" value="$ref->{'value'}"></td></tr>|;
              }

      $response = "<div align=left><font face=Verdana size=2>$LANG{'thankyou'}.<br><br>$LANG{'profileup'}<br><br>Please <a href=\"$global{'mainfile'}?do=login\">$LANG{'login'}</a>";
      $template{'response'} = $response;
      parse("$global{'data'}/include/tpl/general");
      
  } }


if ($section eq "search") 
  {

    check_user();

	$select = $q->param('select');
	$query  = $q->param('query');

	if ($select eq "id")	   { 	$field = "id"; 			}
	if ($select eq "status")   {    $field = "status"; 	    }
	if ($select eq "subject")  { 	$field = "subject"; 	}
	if ($select eq "comments") { 	$field = "description"; }

    $feld   =  $q->param('field');
    $query  =  $q->param('query');

	$query =~ s/_/ /g;

	if (!$feld) {	$feld = $field;   } 

    if (defined $q->param('sort')) 
       { 
         $sort = $q->param('sort');
       }   
         else { 
                $sort = "id"; 
              }

    if (defined $q->param('method')) 
       { 
           if ($q->param('method') eq "asc") { $method = "ASC"; } else { $method = "DESC"; } 
       }
         else { 
                 $method = "ASC"; 
              }

if ($query) {

	$showp =  0*30;
    $num   =  1;
    
    $statement = 'SELECT COUNT(*) FROM perlDesk_calls WHERE ' . "$feld" . ' LIKE "%' . "$query" . '%" AND username = "' . "$Cookies{'id'}" . '"';
	$sth = $dbh->prepare($statement) or die print DBI->errstr;
	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
       $count = $sth->fetchrow_array();
    $sth->finish;

	 $statement = 'SELECT * FROM perlDesk_calls WHERE  ' . "$feld" . ' LIKE "%' . "$query" . '%" AND username = "' . "$Cookies{'id'}" . '" ORDER BY '. "$sort $method" . ' LIMIT ' . "$showp" . ',30'; 
	 $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		$number=0;
	 while(my $ref = $sth->fetchrow_hashref()) {	
		$number++;
			    $font = '#000000';
	
				$subject="$ref->{'subject'}"; 
				$subject=substr($subject,0,20).'..' if length($subject) > 22;
								if ($ref->{'method'} eq em) {  
									 $img = "$global{'imgbase'}/mail.gif";
								} else { 
									 $img = "$global{'imgbase'}/ticket.gif";
								}
      if ($num eq "2") 
        {
			$bgcol = '#FFFFFF';
			$num = 0;
	     } else {
	         		$bgcol = '#F0F0F0';
             	}

      if  ($feld eq "description")
         {
           $link = "&highlight=$query";
         }

         $link = "" if !$link; 

		        $opencalls .= '<table width="100%" border="0" cellspacing="1" cellpadding="4" align="center"><tr bgcolor="' . "$bgcol". '"><td height="11" width="5%"><center>' . "<img src=\"$img\">" . '</center></td>
   					<td height="11" width="7%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="' . "$text\"><a href=\"$template{'mainfile'}?do=view&cid=$ref->{'id'}\">$ref->{'id'}" . '</a></font></td>
   					<td height="11" width="10%"><font size="1" face="Verdana" color="' . "$text\">$ref->{'status'}" . '</font></td>
    				<td height="11" width="9%"><font size="1" face="Verdana"></font><font size=1 face=Verdana color=' . "$text><div align=center>$ref->{'priority'}</div>" . '</font></td>
    				<td height="11" width="45%">' . "<a href=\"$template{'mainfile'}?do=view&cid=$ref->{'id'}\&lang=$language$link\">" . '<font size=1 face=Verdana color=' . "$text>$subject" . '</a></font></td>
   					<td height="11" width="24%"><font size=1 face=Verdana color=' . "$text>$ref->{'time'}" . '</font></td></tr></table>';

                $num++;
		}
	$sth->finish;

} else { 
               $opencalls = qq|<font face="Verdana" size="2">You must enter a search term</font>|;
               $count     = 0;
       }

    $template{'field'}     = $feld;
    $template{'query'}     = $query;
    $template{'results'}   = $opencalls;
    $template{'noresults'} = $count;
    $template{'bar'}       = $bar;

     print "Content-type: text/html\n\n";

     parse("$global{'data'}/include/tpl/results");
     
  }

#~~
# Activate Account (Email Link)
#~~

if ($section eq "activate") {

   my $user      = $q->param('uid');
   my $code      = $q->param('key');

   my $statement = 'SELECT * FROM perlDesk_users WHERE id = ?'; 
   my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
      $sth->execute($user) or die print "Couldn't execute statement: $DBI::errstr; stopped";
 	while(my $ref = $sth->fetchrow_hashref()) 
      {
         $scode    =  $ref->{'acode'};
         $username =  $ref->{'username'};
         $email    =  $ref->{'email'};
         $name     =  $ref->{'name'};
      }
 

   $template{'user'}     = $username;
   $template{'username'} = $username;
   $template{'password'} = '(not shown)';
   $template{'cname'}    = $name;

   die_nice("This account is already activate") if !$scode;
   die_nice("Invalid Activation Key") if $scode != $code;
  
   my $page = qq~ <b>Thank You</b><br>The account <b>$username</b> has been activated ~;

      $dbh->do(qq|UPDATE perlDesk_users SET acode = "0" WHERE id = "$user"|);

        print "Content-type: text/html\n\n";

      	print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="3;URL=$template{'mainfile'}?do=login"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thank You</b>, the account <i>$username</i> has now been activated.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="$template{'mainfile'}?do=login">click 
					here</a> if you are not automatically forwarded</font></p></html>
                |;

  if ($enablemail) 
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
        email ( To => "$email", From => "$global{'adminemail'}", Subject => "Help Desk Registration", Body => "$body" );
   }


}


if ($section eq "pro_login") {

       $pass = $q->param('password');
       $user = $q->param('username');

    my ( $DBUSER,      # DB Username
         $DBNAME,      # DB Name
         $DBEMAIL,     # DB E-mail
         $DBURL        # DB URL
       );
 
    my $salt;
    my $statement = 'SELECT * FROM perlDesk_users WHERE username = ?'; 
    my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
      $sth->execute($user) or die print "Couldn't execute statement: $DBI::errstr; stopped";
 	while(my $ref = $sth->fetchrow_hashref()) 
      {

         die_nice("Invalid Username (case sensitive)") if $user ne $ref->{'username'};

          $salt  = $ref->{'rkey'};
       my $cpass = crypt($pass, $salt); 

       if ($cpass ne $ref->{'password'}) 
         {
				die_nice("Invalid Password");
         }
           else {
			      $DBUSER   = $ref->{'username'};
			      $DBNAME   = $ref->{'name'};
			      $DBEMAIL  = $ref->{'email'};
			      $DBURL    = $ref->{'url'};
                  $status   = $ref->{'pending'};
                  $code     = $ref->{'acode'};
		        } 		
     }

    $template{'name'}  = $DBUSER;
    $template{'user'}  = $DBUSER;
    $template{'email'} = $DBEMAIL;
    $template{'url'}   = $DBURL;

    die_nice("$LANG{'error6'}") if !$DBUSER;
    die_nice("The administrator has chosen to approve accounts before they become active. An email will be sent to you when this account is activated.") if $status eq "1";
    die_nice("You need to activate your account by clicking the link in the email sent to $DBEMAIL before you can access your account") if $code;

	my $md5 = Digest::MD5->new ;
	   $md5->reset ;

    my $yday    = (localtime)[7];
    my @ipa     = split(/\./,$ENV{'REMOTE_ADDR'});
    my $startip = $ipa[0] . $ipa[1];

  if ($global{'sess_ip'}) 
    {
          $certif  = $user . "pd-$salt" . $ENV{'HTTP_USER_AGENT'} . $startip;
    }
  else {
          $certif  = $user . "pd-$salt" . $ENV{'HTTP_USER_AGENT'};
       }


    $md5->add($certif);
    $enc_cert = $md5->hexdigest() ;
    $sth->finish;

    my $cookie1; 
    my $cookie2;

    $time = time();
  
    $dbh->do(qq|UPDATE perlDesk_users SET active = "$time" WHERE username = "$user"|);
    
    if ($q->param('remember') eq "yes") 
          {
               $cookie1 = $q->cookie(  -name=>'id',
                                       -value=>$user,
                                       -path    =>  '/',
                                       -domain  =>'',
                                       -expires=>'+1y'
                                    );
               $cookie2 = $q->cookie(  -name=>'pass',
                                       -value=>$enc_cert,
                                       -path    =>  '/',
                                       -domain  =>'',
                                       -expires=>'+1y'
                                    );

           } else {
                    $cookie1 = $q->cookie(  -name=>'id',
                                            -value=>$user,
                                            -path    =>  '/',
                                            -domain  =>''
                                         );
                    $cookie2 = $q->cookie(  -name=>'pass',
                                            -value=>$enc_cert,
                                            -path    => '/',
                                            -domain =>''
                                         );
                  }
         
        print $q->header(-cookie=>[$cookie1,$cookie2]);

        my $lang = $q->param('lang');

      	print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=$template{'mainfile'}?do=main&lang=$lang"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Thanks for logging in</b>, you are now being taken to the members area.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="$template{'mainfile'}?do=main&lang=$lang">click 
					here</a> if you are not automatically forwarded</font></p></html>
                |;

    }

#~~
# Submit Ticket
#~~

if ($section eq "submit_ticket") 
 {

   if (get_setting_2("access_submit"))  
         {
             check_user();
         } 
            else { $ignorenav = 1;  }

    print "Content-type: text/html\n\n";

    my $statement = 'SELECT * FROM perlDesk_ticket_fields ORDER BY dorder'; 
    my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
       $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
    while(my $ref = $sth->fetchrow_hashref()) 
      {	$value="";
     
        if (!$ignorenav)
         {
            foreach(qw/Name Email Company URL/) { $vl = lc($_);  $field = '{' . $vl . '}';  $value = $template{$vl} if $ref->{'value'} eq $field; }
         }

          $template{'form'} .= qq|<tr><td width="24%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'name'}</font></td><td width="76%"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                  <input type="text" class="tbox"  name="$ref->{'id'}" value="$value" size="35"></font></td></tr>
                                 |;
      }
    $sth->finish;

    my $statement = 'SELECT level FROM perlDesk_departments ORDER BY level'; 
    my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
       $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
    while(my $ref = $sth->fetchrow_hashref()) 
      {	
           $template{'category'} .= "<option value=\"$ref->{'level'}\">$ref->{'level'}</option>";
      }
    $sth->finish;


    $template{'uname'}    = $Cookies{'id'} || "Unregistered";

    parse("$global{'data'}/include/tpl/submitreq");

  }
#~~
# Save a logged call
#~~

if ($section eq "submit_req") 
 {
     if (get_setting_2("access_submit"))  
         {
             check_user();
         } 
            else { $ignorenav = 1;  }

   my $subject     = $q->param('subject');
   my $description = $q->param('description');
   my $username    = $q->param('username');
   my $priority    = $q->param('priority');
   my $category    = $q->param('category');
   my $file        = $q->param('file');
   my $cfile       = $q->param('file');
   my $email       = $q->param('email');

     foreach(qw/subject description email/) { $error .= qq|<li>$_</li>| if $q->param($_) eq ""; }

      if ($q-param('email') ne "" && $q->param('email') !~ /\./ && $q->param('email') !~ /\@/)
              {
                  $error .= "<li>Invalid email address</li>";
              } 

     if (defined $error)
      {
   if (get_setting_2("access_submit"))  
         {
             check_user();
         } 
            else { $ignorenav = 1;  }

    print "Content-type: text/html\n\n";

    my $statement = 'SELECT * FROM perlDesk_ticket_fields ORDER BY dorder'; 
    my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
       $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
    while(my $ref = $sth->fetchrow_hashref()) 
      {	   
          $value = $q->param($ref->{'id'});

          $template{'form'} .= qq|<tr><td width="24%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">$ref->{'name'}</font></td><td width="76%"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                                  <input type="text" class="tbox"  name="$ref->{'id'}" value="$value" size="35"></font></td></tr>
                                 |;
      }
    $sth->finish;

    my $statement = 'SELECT level FROM perlDesk_departments ORDER BY level'; 
    my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
       $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
       while(my $ref = $sth->fetchrow_hashref()) 
        {	
             $template{'category'} .= "<option value=\"$ref->{'level'}\">$ref->{'level'}</option>";
        }
      $sth->finish;

           $template{'uname'} =  $Cookies{'id'} || "Unregistered";
           $template{'email'}       = $q->param('email');
           $template{'subject'}     = $q->param('subject');
           $template{'description'} = $q->param('desc');
           
           $template{'error'} =  qq|The following fields were missing or invalid:<ul> $error</ul>|;
           parse("$global{'data'}/include/tpl/submitreq");
      }

  else {

 #~~ 
 # No Error: Continue Processing Submission
 #~~

       $current_time = time();

   if ($username ne "Unregistered")
   {
         $statement    = qq|SELECT lcall FROM perlDesk_users WHERE username = "$Cookies{'id'}"|; 
         $sth = $dbh->prepare($statement)or die print "Couldn't prepare statement: $DBI::errstr; stopped";
         $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
            while(my $ref = $sth->fetchrow_hashref()) 
             {
                my $newtime = $ref->{'lcall'};
                   $newtime = $newtime + $global{'floodwait'};
                   die_nice("You can only log a call every $global{'floodwait'} seconds") if $newtime > $current_time;
             }
    }

   my $edescription = $description;
      $description  =~ s/</&lt;/g;
      $description  =~ s/>/&gt;/g;

      my @chars =  (A..Z,0..9,a..z);          $key   =  $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)];          
   my $dsth = $dbh->prepare( "INSERT INTO perlDesk_calls VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)" );
      $dsth->execute( "NULL", "OPEN", $username, $email, $priority, $category, $subject, $description, $hdtime, "Unowned", "NULL", "hd", $current_time, $current_time, "1", "0", "0", "0", "$key" ) or die "Couldn't execute statement: $DBI::errstr; stopped";
         
        
      $callid = $dbh->{'mysql_insertid'}; 

   my $sdsth = $dbh->prepare( "INSERT INTO perlDesk_activitylog VALUES ( ?, ?, ?, ?, ?)" );
      $sdsth->execute( "NULL", $callid, $hdtime, "User", "Request Logged" ) or die "Couldn't execute statement: $DBI::errstr; stopped";

        

 if (defined $file && $file ne "") 
     {
         my $path2 = get_setting_2(qq|file_path|);

         $tfile =  $file;
         $tfile =~ s/\\/\//g;
   
         my @path    = split (/\//,$tfile);
         my $entries = @path;
   
         my $filename = $path[$entries-1];
   
                $i        =   1;

          my ($fname, $ext) = split /\./, $filename, 2;
 
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
          execute_sql(qq|INSERT INTO perlDesk_files VALUES ("", "$callid", "", "$file_name", "$path2/$file_name")|);

     } 
 
           $lby = $Cookies{'id'} || "Unregistered User";

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

    $dbh->do(qq|UPDATE perlDesk_users SET lcall = "$current_time" WHERE username = "$Cookies{'id'}"|);

	$statement = 'SELECT * FROM perlDesk_staff WHERE access LIKE "%' . "$category" . '::%" OR access LIKE "%GLOB::%" OR access = "admin";'; 
		$sth = $dbh->prepare($statement)or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
    while(my $ref = $sth->fetchrow_hashref()) {


   if ($ref->{'notify'} == "1") {
      if ($enablemail) {



        my $to       = $ref->{'email'};
        my $from     = $global{'adminemail'};
        my $esubject = "New Help Desk Request";
        my $msg      = qq|
There is a new help desk submission

Ticket Details
------------------------------------------
Ticket ID.............: $callid
Logged by.............: $lby
Category..............: $category
Subject...............: $subject

$edescription

------------------------------------------

URL: $global{'baseurl'}/staff.cgi?do=login

Thank You
|;
       email ( To => "$to", From => "$from", Subject => "$esubject", Body => "$msg" );

      } }
    }

	$sth->finish;
	close (MAILNEWTPL);
	$content = "<font size=2><b>$LANG{'thankyou'}</b><br><br>$LANG{'subrec'}<br><br>$LANG{'callid'}: $callid<br><Br><a href=$template{'mainfile'}?do=main>$LANG{'subrec2'}</a>";

    if ($enablemail) 
     {
        email ( To => "$global{'pageraddr'}", From => "$global{'adminemail'}", Subject => "URGENT SUPPORT REQUEST", Body => "Priority 1 Ticket Logged - ID $callid - User $email" ) if $global{'pager'} && $q->param('priority') == "1";

       my $body;
			open (MAILNEWTPL,"$global{'data'}/include/tpl/newticket.txt");
				while (<MAILNEWTPL>) {
                  lang_parse() if $_ =~ /%*%/;
				  if ($_ =~ /\{*\}/i) 
                    { 
     					s/\{baseurl\}/$global{'baseurl'}/g;
    					s/\{name\}/$lby/g;
    					s/\{subject\}/$subject/g;
    					s/\{description\}/$description/g;
    					s/\{mainfile\}/$template{'mainfile'}/g;
                     	                s/\{lang\}/$language/g;
    					s/\{date\}/$hdtime/g;
    					s/\{key\}/$key/g;
    					s/\{id\}/$callid/g;
    				}			
                		$body .= "$_";
        		  }
           	close(MAILNEWTPL);

        my $subject = "\{$global{'epre'}-$callid\} Help Desk Submission";
           email ( To => "$email", From => "$global{'adminemail'}", Subject => "$subject", Body => "$body" );
      }	

     $template{'response'} = $content;
 
     print "Content-type: text/html\n\n";
     parse("$global{'data'}/include/tpl/general");

   } # End No Error

  }

#~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if ($section eq "calender") 
 {

   check_user();

   if ($q->param('goto'))
      {
          if ($q->param('goto') eq "viewday")
               {
                    $day_no = $q->param('day');
               }
      }

  $day_no  = $q->param('day');
  $date_no = $day_no if $day_no;

  my @monthnames = qw(January February March April May June July August September October November December);
  my $prevmonth  = '&laquo;';
  my $nextmonth  = '&raquo;';

  my @dayabbrev = qw(S M T W T F S);
  my $daywidth = 20;      # per-column pixel width

  my $html = "";

  $day_no = $date_no if !$day_no; 

  $cmonth = $q->param('month') if defined $q->param('month');
  $cyear  = $q->param('year')  if defined $q->param('year');
  $cmonth = $month_no if !$cmonth;  
  $cyear  = $year     if !$cyear;
  
   if ($cmonth != "1") { $lastmo = $cmonth; $lastmo--; }
   if ($cmonth == "1") { $lastmo = "12";     }

   if ($cmonth != "12") { $nmonth = $cmonth; $nmonth++; }
   if ($cmonth == "12") { $nmonth = "1";     }

   $imonth = $cmonth;

   if ($imonth == "1") 
      {
          $pyear = $cyear;
          $pyear--;         
      } else {
                 $pyear = $cyear;
             }


  if ($imonth == "12") 
      {
                $nyear = $cyear;
                $nyear++;         
      } else {
                $nyear = $cyear;
             } 

 $cmonth--;
  
 $html .= qq|
             <table border=0 cellspacing=1 cellpadding=0><tr><td align=left><a href="$template{'mainfile'}?do=calender&month=$lastmo&year=$pyear&day=1">$prevmonth</a></td>\n
             <td colspan=5 align=center><font size=-1><b>$monthnames[$cmonth]</b></font>
             </td><td align=right><a href="$template{'mainfile'}?do=calender&month=$nmonth&year=$nyear&day=1">$nextmonth</a></td></tr>
            |;

    $html .= "<tr><font size=-1>\n";
    foreach ( @dayabbrev ) {
	$html .= "<td align=right width=" . $daywidth . ">"
              .  "<font size=-1>$_</font>"
              .  "</td>\n";
    }
    $html .= "</font></tr>\n";

    my @fifo = ();
    my $skip = &_first_dow($cmonth, $cyear);
    while ( $skip-- ) { push @fifo, "" }
      my $n = &_days_in($cmonth, $cyear);
      foreach ( 1 .. $n ) { push @fifo, $_ }
    while ( @fifo % 7 != 0 ) { push @fifo, "" }
    {
     $html .= "<tr>\n" if @fifo % 7 == 0;

     my $day = shift @fifo;

       $html .= "<td align=right><font size=-1><a href=$template{'mainfile'}?do=calender&goto=viewday&day=" . $day . "&month=$imonth>";
       $html .= $day;
       $html .= "</a></font></td>\n";
       $html .= "</tr>\n" if @fifo % 7 == 0;
  
     last if @fifo == 0;
     redo;
    }

   $html .= "</table>\n";

     $template{'date'}     = "$day_no/$imonth/$year";
     my $sqldate           = "$day_no-$imonth-$year";

	my $statement = qq|SELECT * FROM perlDesk_user_events WHERE user = "$Cookies{'id'}" AND date = "$template{'date'}"|; 
	my $sth = $dbh->prepare($statement)or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	   $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
        	while(my $ref = $sth->fetchrow_hashref()) {   $events .= "$ref->{'subject'}";	}
       $sth->finish;

     $num = 1;

	 $statement = qq|SELECT * FROM perlDesk_calls WHERE time LIKE "%$sqldate%" AND username = "$Cookies{'id'}"|; 
	 $sth = $dbh->prepare($statement)or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	 $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
	while(my $ref = $sth->fetchrow_hashref()) 
    {
      my $img  = "$global{'imgbase'}/mail.gif"   if $ref->{'method'} eq "em";
         $img  = "$global{'imgbase'}/ticket.gif" if $ref->{'method'} ne "em";   
      my $bgcol;
      my $text = '#000000';
    
      if ($num == "2")   
          {
                      $bgcol   =  '#FFFFFF';
                      $num     =   0;
          }
              else {
                      $bgcol   = '#F0F0F0';
                   }
      $number++;
      $listofcalls .= '  <table width="100%" border="0" cellspacing="1" cellpadding="3" align="center"><tr bgcolor="' . "$bgcol" . '"><td height="11" width="6%"><center>' . "<img src=\"$img\">" . '</center></td>
   			        	 <td height="11" width="6%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="' . "$text\"><a href=\"$template{'mainfile'}?do=view&cid=$ref->{'id'}\">$ref->{'id'}" . '</a></font></td>
   				         <td height="11" width="10%"><font size="1" face="Verdana" color="' . "$text\">$ref->{'status'}" . '</font></td>
    			         <td height="11" width="9%"><font size="1" face="Verdana"></font><font size=1 face=Verdana color=' . "$text><div align=center>$ref->{'priority'}</div>" . '</font></td>
    			         <td height="11" width="45%"><a href="' . "$template{'mainfile'}" . '?do=view&cid=' . "$ref->{'id'}\&lang=$language" . '"><font size=1 face=Verdana color=' . "$text>$ref->{'subject'}" . '</a></font></td>
   				         <td height="11" width="24%"><font size=1 face=Verdana color=' . "$text>$ref->{'time'}" . '</font></td></tr></table>';
	  $num++;
    }

	$sth->finish;

    $listofcalls = qq~ <br><div align="center"><font face="Verdana" size="2"><b>No Tickets Logged on $day_no/$imonth/$year</b></div>~ if !$listofcalls;
    $events      = qq~ <br><div align="center"><font face="Verdana" size="2">No Events Scheduled</div>~ if !$events;

   $template{'tickets'}  =  $listofcalls;
   $template{'events'}   =  $events;
   $template{'calender'} =  $html;
   $template{'month'}    =  $month;

      print "Content-type: text/html\n\n";

      parse("$global{'data'}/include/tpl/calender");
   
 }


if ($section eq "view")
  {
     check_user();
 
     if (defined $q->param('ticket')) { $trackedcall = $q->param('ticket'); } else { 
         	$trackedcall = $q->param('cid');
       } 

    $template{'trackno'} = $trackedcall;
	$statemente          = 'SELECT * FROM perlDesk_calls WHERE id = ?'; 

	$sth = $dbh->prepare($statemente) or die "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute( $trackedcall ) or die "Couldn't execute statement: $DBI::errstr; stopped";
		   while(my $ref = $sth->fetchrow_hashref()) {
			if ($ref->{'username'} ne $Cookies{'id'}) 
			{
				$error = 1;
			} else  {
	         			$template{'username'}    = $ref->{'username'};
	        			$template{'email'}       = $ref->{'email'};
	        			$template{'url'}         = $ref->{'url'};
	        			$cuser                   = $ref->{'name'};
	         			$template{'priority'}    = $ref->{'priority'};
	        			$template{'category'}    = $ref->{'category'};
	         			$template{'subject'}     = $ref->{'subject'};
	        			$template{'description'} = $ref->{'description'};
	        			$template{'date'}        = $ref->{'time'};
	        			$template{'status'}      = $ref->{'status'};
                        $active                  = $ref->{'active'}; 
                        $logged                  = $ref->{'track'}; 
	        		}
       }

        if (($sth->rows == 0) || ($error == "1")) {  die_nice("Request `$trackedcall' does not exist or is not owned by you"); }

     print "Content-type: text/html\n\n";
     $search_string = $q->param('highlight');

 	my $statement = 'SELECT id, cid, filename FROM perlDesk_files WHERE cid = ?';  		$sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";  		$sth->execute( $trackedcall ) or die print "Couldn't execute statement: $DBI::errstr; stopped"; 		while(my $ref = $sth->fetchrow_hashref())  		   { 				$template{'filename'} = qq|<a href="pdesk.cgi?do=view_file&cid=$ref->{'id'}">$ref->{'filename'}</a>|; 		   }
              if ($sth->rows == "0") { $template{'filename'} = qq|No File|; }

     $statemente = 'SELECT * FROM perlDesk_notes WHERE call = ? ORDER BY id;'; 
 	 $sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	 $sth->execute($trackedcall) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	     while(my $ref = $sth->fetchrow_hashref())  {

               $comment = "$ref->{'comment'}";
               $comment = pdcode("$comment");


    my $tatement = 'SELECT * FROM perlDesk_files WHERE nid = ?';      my $th = $dbh->prepare($tatement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";        $th->execute($ref->{'id'}) or die print "Couldn't execute statement: $DBI::errstr; stopped";     while(my $ef = $th->fetchrow_hashref())        {	
           $filename = qq|<a href=pdesk.cgi?do=view_file&id=$ef->{'id'}>$ef->{'filename'}</a>|;
      }
    if ($th->rows == "0") { $filename = "No File Attached"; }

          if ($ref->{'owner'} eq 0) {
             if ($comment =~ /^</) { } else { $comment =~ s/\n/<br>/g; }
					$notes .= '<table width="100%" border="0" cellspacing="1" cellpadding="3"><tr class="userresponse">' . "<a name=\"$ref->{'id'}\">" . '</a> 
    						   <td width="30%" height="14" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>' . "$ref->{'author'}" . '<br>
    						   </b></font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . "$ref->{'time'}" . '<br><br><a href="' . "$template{'mainfile'}" . '?do=editnote&nid=' . "$ref->{'id'}&lang=$language" . '">EDIT</a> </font></td>
    						   <td width="70%" height="14" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . "$comment" . '</font></td></tr></table>';
		} elsif ($ref->{'owner'} eq 1) {
				next if $ref->{'visible'} eq 0;
			if ($comment =~ /^</) { } else {
					$comment =~ s/\n/<br>/g;
			}


         $statement = 'SELECT name FROM perlDesk_staff WHERE id = ?';           $th = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";  		$th->execute($ref->{'author'}) or die print "Couldn't execute statement: $DBI::errstr; stopped";          	  while(my $f = $th->fetchrow_hashref())  	            {  $template{'author'} = $f->{'name'}; }

					   $notes .= qq|<table width="100%" border="0" cellspacing="1" cellpadding="3"><tr class="userstaffresponse"><a name="$ref->{'id'}"></a>
    						   <td width="30%" height="14" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>$template{'author'}<br>
    						   </b></font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">$ref->{'time'}<br><br></font></td>
    						   <td width="70%" height="14" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">$comment<br><BR><BR>-----------<br>$filename</font></td></tr>

<tr class="userstaffresponse"> <td colspan=2 valign="top"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><div align=right><a href=$template{'mainfile'}?do=rate_response&nid=$ref->{'id'}&key=$ref->{'ikey'}>Rate This Response</a></div></font></td></tr>

</table>|;
     		}
    	}
    	$dbh->disconnect;
    	if (!$notes) 
         {
     		$notes = '<table width="95%" border="0" cellspacing="0" align="center">
            <tr><td colspan="3"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">No 
            notes added.</font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></td>
            </tr></table>';
    	  } 

     	if ($template{'status'} eq CLOSED) 
         {
             		$template = "viewticket_closed";
     	 } else {
                  	$template = "viewticket";
            	}

      $template{'description'}  =~  s/\n/<br>/g if $template{'description'} !~ /^</;
      $template{'description'}  =   pdcode("$template{'description'}");
      $template{'description'}  =~ s/$search_string/<font color=#FF0000>$search_string<\/font>/ig if $search_string;
         
      $template{'notes'}        =   $notes;

      $current_time = time();

      my $now         =  $current_time;
      my $difference  =  $now - $active;

            if ($difference >= 86400) 
             {
                   $period    =  "day";
                   $count     =  $difference / 86400;
             } elsif ($difference >= 3600) 
               {
                   $period    =  "hour";
                   $count     =  $difference / 3600;
               } elsif ($difference >= 60)  
                  {
                     $period  =  "minute";
                     $count   =  $difference / 60;
                  } else
                     {
                        $period = "second";
                        $count = $difference;
                     }

            $count = sprintf("%.0f", $count);

            if ($count != 1) { $period .= "s"; }

      $template{'ltime'} = $count . ' ' . $period; 



      $tdifference  = $current_time - $logged;

            if ($tdifference >= 86400) 
             {
                   $tperiod   = "day";
                   $tcount    = $tdifference / 86400;
             } elsif ($tdifference >= 3600) 
               {
                   $tperiod   = "hour";
                   $tcount    = $tdifference / 3600;
               } elsif ($tdifference >= 60)  
                  {
                     $tperiod = "minute";
                     $tcount  = $tdifference / 60;
                  } else
                     {
                        $tperiod = "second";
                        $tcount = $difference;
                     }

            $tcount = sprintf("%.0f", $tcount);

            if ($tcount != 1) { $tperiod .= "s"; }

      $template{'ttime'} = $tcount . ' ' . $tperiod; 


      parse("$global{'data'}/include/tpl/$template");
       }



   



#~~
# PRINT CALL
#~~


if ($section eq "print") 
 {

  print "Content-type: text/html\n\n";

 my $id    = $q->param('cid');
 
 print  qq|
            <table width="90%" border="0" align="center"><tr><td width="48%"><img src="$global{'imgbase'}/logo.gif"></td><td width="52%"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>PRINT 
            REQUEST $id</b></font></div></td></tr><tr><td colspan="2" height="2">
          |;

 die_nice("No Ticket Specified") if !$id;

 $statement = 'SELECT * FROM perlDesk_calls WHERE  id = ?'; 
   $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
   $sth->execute($id) or die print "Couldn't execute statement: $DBI::errstr; stopped";
      $number=0;
          while(my $ref = $sth->fetchrow_hashref()) {	

           if (($ref->{'username'} ne $Cookies{'id'}) || ($ref->{'owner'})) 
             {
                 die_nice("ERROR: You are not authorised to view this call!");
             }			

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
       }


  $description =~ s/\n/<br>/g;

  print qq|
           <table width="99%" border="0" cellspacing="1" cellpadding="1" align="center"><tr><td colspan="2">&nbsp;</td>
           </tr><tr><td colspan="2"> <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">LOGGED: $date BY: $username</font></div>
           </td></tr><tr><td colspan="2">&nbsp;</td></tr><tr valign="middle"><td colspan="2" height="30">&nbsp;</td></tr><tr valign="middle"> 
           <td colspan="2" height="30"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>$subject</b></font></td></tr><tr> 
           <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">$description</font></td></tr><tr> <td>&nbsp;</td><td>&nbsp;</td>
           </tr><tr><td colspan="2">&nbsp;</td></tr><tr> <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>ACTIONS/RESPONSES</b></font></td></tr><tr><td colspan="2"><hr>
          |;

	$statemente = 'SELECT * FROM perlDesk_notes WHERE call = ? ORDER BY id;'; 
	$sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	$sth->execute($id) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	      while(my $ref = $sth->fetchrow_hashref()) {
				$body = $ref->{'comment'};
	if ($body =~ /^</)  
     {
	       		# Do nothing
	 } else {
	        	$body =~ s/\n/<br>/g;
	        }
	
    if (($ref->{'owner'} eq 0) || ($ref->{'owner'} eq 1))
		{
				print qq|<div align="left"><br><font face="Verdana" size="2"><b>$ref->{'author'}</b> <i>$ref->{'time'}</i><br><font size=1><blockquote>$body</blockquote></font></div><br><hr>| if $ref->{'visible'} == "1";
    	} 

	if ($ref->{'owner'} eq 3) 
		{
		    	print '<table width="100%" border="0" cellspacing="1" cellpadding="2"><tr> 
			   <td width="30%" height="14" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>' . "$ref->{'author'}" . '<br>
			   </b></font><font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . "$ref->{'time'}" . '<br><br></font></td>
			   <td width="70%" height="14" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">' . "<b>STAFF ACTION: $ref->{'action'}</b><br>$body" . '</font></td></tr></table><br><hr>' if $ref->{'visible'} == "1";
    	} 
   }
  
    print qq|</td></tr></table>|;
 
} 

if ($section eq "editnote") {

    check_user();
    print "Content-type: text/html\n\n";

    my $noteid  = $q->param('nid');
       $statemente = 'SELECT * FROM perlDesk_notes WHERE id = ?'; 
       $sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	   $sth->execute($noteid) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	     while(my $ref = $sth->fetchrow_hashref()) 
         {
			if (($ref->{'author'} != $Cookies{'id'}) || ($ref->{'owner'} eq "1")) 
			{
				print 'ERROR: You are not authorised to edit this note!';
                exit;
			}  

       $statement = 'SELECT status FROM perlDesk_calls WHERE id = ?'; 
       $st = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 	   $st->execute($ref->{'call'}) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	     while(my $re = $st->fetchrow_hashref()) 
         {
              $status = $re->{'status'};
         }

        if ($status eq "CLOSED") {

                 	print qq|
				            	<html><p>&nbsp;</p><p>&nbsp;</p><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Sorry</b>, the request associated with this response has been closed, please re-open it before you can edit any notes.</font><br><br>
				            	<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="$template{'mainfile'}?do=reopen&id=$ref->{'call'}&lang=$language">click 
				            	here to re-open ticket <b>$ref->{'call'}</b></a></font></p></html>
                            |;
 
           exit;
        }
       		if ($ref->{'author'} == $Cookies{'id'}) 
      	      {	
       			$response= '<table width="100%" border="0"><tr><td><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Edit 
       						[Call ID: ' . "$ref->{'call'}" . ']</b><BR><BR></font></td></tr><tr><td><form name="form1" method="post" action="' . "$template{'mainfile'}" . '">
    						<table width="100%" border="0"><tr><td width="39%" height="20" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">EDIT 
      						NOTE</font></td><td width="61%" height="20"><textarea name="comment" class="tbox" cols="55" rows="12">' . "$ref->{'comment'}" . '</textarea>
      						</td></tr><tr><td colspan="2"><div align="center"><input type="hidden" name="ticket" value="' . "$ref->{'call'}" . '"><input type="hidden" name="lang" value="' . "$language" . '"><input type="hidden" name="do" value="save_note"><input type="hidden" name="note" value="' . "$ref->{'id'}" . '">
      						<input type="submit" style="font-size: 12px" name="editnote" value="Submit"></div></td></tr></table></form>';
     		  }
	     }
 
      $template{'response'}  = $response;
   parse("$global{'data'}/include/tpl/general");
   
 }

if ($section eq "save_note") {


        check_user();

   my $comment  =  $q->param('comment');
   my $note     =  $q->param('note');
   my $ticket   =  $q->param('ticket');

      $comment  =~ s/</&lt;/g;
      $comment  =~ s/>/&gt;/g;
 
  my $time = time();

     $dbh->do(qq|UPDATE perlDesk_calls SET active = "$time" WHERE id = "$ticket"|);

     my $statement = 'UPDATE perlDesk_notes SET comment = ? WHERE id = ?'; 
     my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
        $sth->execute( $comment, $note) or die print "Couldn't execute statement: $DBI::errstr; stopped";

        print "Content-type: text/html\n\n";

        my $lang = $q->param('lang');
        
      	print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=$template{'mainfile'}?do=view&cid=$ticket&lang=$lang"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Response Updated</b>, you are now being taken back to your support request.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="$template{'mainfile'}?do=view&cid=$ticket&lang=$lang">click 
					here</a> if you are not automatically forwarded</font></p></html>
                |;

 }

if ($section eq "addnote") {


   check_user();

	 $note   = $q->param('note');
	 $ticket = $q->param('ticket');

  my $time = time();

     $dbh->do(qq|UPDATE perlDesk_calls SET active = "$time" WHERE id = "$ticket"|);

	$statement =  qq|UPDATE perlDesk_calls SET aw = "1" WHERE id = "$ticket"|; 
	$sth       =  $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";

     if ($note ne "")  
     {
        $note  =~ s/</&lt;/g;
        $note  =~ s/>/&gt;/g;

      my @chars =  ("A..Z","0..9","a..z");          $key   =  $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)];          

      $sth = $dbh->prepare( "INSERT INTO perlDesk_notes VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )" ) or die "couldnt prepare statement";
      $sth->execute( "NULL", "0", "1", "NULL", $ticket, $template{'name'}, $hdtime, $key, $note, "$ENV{'REMOTE_ADDR'}" ) or die "Couldnt execute statement $!";

        notify_techs( tid => "$ticket", note => "$note", name => "$template{'name'}", time => "$hdtime" );
     }

        print "Content-type: text/html\n\n";
 
        my $lang = $q->param('lang');

     	print qq|
					<html><p>&nbsp;</p><p>&nbsp;</p><meta http-equiv="refresh" content="1;URL=$template{'mainfile'}?do=view&cid=$ticket&lang=$lang"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Response Added</b>, you are now being taken back to your support request.</font><br><br>
					<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="$template{'mainfile'}?do=view&cid=$ticket&lang=$lang">click 
					here</a> if you are not automatically forwarded</font></p></html>
                |;
  }
}

sub _first_dow 
  {

    my($month, $year) = @_;	# $month in (0..11), $year as YYYY

    if ( $month < 2 ) 
     {
        $month += 12;
        --$year;
     }

     my $z1 = (26 * ($month + 2)) / 10;
     my $z2 = int((125 * $year) / 100);
     return ($z1 + $z2 - int($year / 100) + int($year / 400)) % 7;
  }

sub _days_in 
  {
    my($month, $year) = @_;     # $month in (0..11), $year is YYYY

    return 29 if $month == 1 && ($year % 4) == 0;
    (31,28,31,30,31,30,31,31,30,31,30,31)[$month];
  }

1;