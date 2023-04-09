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
#   Filename: email.cgi                                                           #
#    Details: The main email gateway file                                         #
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
# Please set the path information below

   use lib '/home/perldesk/www/beta/1.8/include/mods';
   require "/home/perldesk/www/beta/1.8/include/conf.cgi"; 
   require "/home/perldesk/www/beta/1.8/include/lang/en.inc"; 


#~~ No further editing required

 use CGI qw(:standard);
 use DBI();

 use MIME::Parser;
 use Mail::Address;
 use MIME::Entity;
 use MIME::Body;
 use Data::Dumper;


   &get_time();

   $parser = new MIME::Parser;
   $parser->ignore_errors(1);
   $parser->output_to_core(1);



   my $MIME_entity = $parser->parse(\*STDIN);
   my $error       = ($@ || $parser->last_error);

   $header         =  $MIME_entity->head;
   $subject        =  $header->get('Subject') || "no subject"; 
   $cto            =  $header->get('To'); 
   $from           =  $header->get('From'); 

   $priority       =  $header->get('X-Priority'); 
   $priority       =  "3" if $priority eq "N";

   @to_addresses   = Mail::Address->parse($cto);
   @from_addresses = Mail::Address->parse($from);

   my $address;


   if (@to_addresses) {  $to = $to_addresses[0]->address(); } 
   else { exit; }

   if (@from_addresses) { 
                             $address = $from_addresses[0]->address(); 
                             if($address eq 'MAILER-DAEMON') { exit; }
                        } 
   else {  exit;   }


   $id = 0;

 if ($MIME_entity->parts > 0) 
  {

    for (my $i=0;$i<$MIME_entity->parts;$i++) 
     {
         my $subEntity    = $MIME_entity->parts($i);

          #~~
          # Get the $body of the email
          #~~

         my $ignore_plain = "0";
         my $ignore_html  = "0";
            $ishtml       = "1" if $subEntity->mime_type eq 'text/html';
            $ishtml       = "0" if $subEntity->mime_type eq 'text/plain';


          #~~
          # This is a multipart/alternative message


            if ($subEntity->mime_type eq 'multipart/alternative' && !$ignore_all )
              {
                   for (my $j=0;$j<$subEntity->parts;$j++) 
                     {
                               my $subSubEntity = $subEntity->parts($j);
                              if ($subSubEntity->mime_type eq 'text/plain' && $ignore_plain == "0" && !$ignore_all)  
                                    {
                                          if (my $io = $subSubEntity->open("r"))  
                                             {
                                                 while (defined($_=$io->getline)) {    $_ =~ s/"/\"/g;  $body .= $_;  }
                                               
                                                 $ignore_all   = 1;  last;
      
                                             }
                                    }
                     }
              }



          #~~
          # Test / Plain Email Body

          if ($subEntity->mime_type eq 'text/plain' && $ignore_plain == "0" && !$ignore_all)  
            {
               if (my $io = $subEntity->open("r"))  
                {
                    while (defined($_=$io->getline)) {    $_ =~ s/"/\"/g;  $body .= $_;  }
                    $io->close;
                    $ignore_html = 1;
                    $ignore_all  = 1;
                    last;
                }
            }

          #~~
          # Text / HTML Email Body


          if ($subEntity->mime_type eq 'text/html' && $ignore_html == "0" && !$ignore_all)  
           {
              if (my $io = $subEntity->open("r"))
                {
                   while (defined($_=$io->getline))  {    $_ =~ s/"/\"/g;  $body .= $_;  }
                   $io->close;
                   $ignore_plain = 1;
                   $ignore_all   = 1;
                }
           }


      

              $id++;


       }

 }  else  { $body = join "",  @{$MIME_entity->body}; }

     $to = $1 if $to =~ /<(\S+)>/;

    if ($from =~ /<(\S+)>/) { $newfrom = $1 } 
     else { $newfrom = $from } 

   $body =~ s/"/\"/g;
   chomp($newfrom);

#~~
# Remove JavaScript From BODY
#~~

  $body =~ s#<script[^>]*>.*?</script[^>]*>#NOTE: This email contained Javascript, which was removed upon arrival#ig;
  $body =~ s#document.cookie##gi;

#~~
# Remove FORM tags
#~~

  $body =~ s/<form>/&lt\;form&gt\;/gi;
  $body =~ s/<\/form>/&lt\;\/form&gt\;/gi;
  


#~~
# Establish Database Connection
#~~

     $dbh       = DBI->connect("DBI:mysql:$dbname:$dbhost","$dbuser","$dbpass");
  my $statement = 'SELECT * FROM perlDesk_settings'; 
  my $sth       = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
     $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
  while(my $ref = $sth->fetchrow_hashref()) 
       {
                  my $setting       = $ref->{'setting'};
                  $global{$setting} = $ref->{'value'};
       } 
  $sth->finish;


	if ((!$subject) || ($subject eq ""))
         {
               email( To => "$newfrom", From => "$ticketad", Subject => "Help Desk Response", Body => "Please send your request with a subject line intact, if you are replying to a staff response, please keep the subject line intact for tracking purposes. If this is a new request, please give it a suitable subject.\n\nThank you" );
               exit;
         }


   #$subject =~ s#?##gi;

#~~
# Check to see if the FROM address has been banned
#~~
  
   my ($alias, $domain) = split(/\@/, $newfrom);
   my $statement = qq|SELECT * FROM perlDesk_blocked_email WHERE (address = "$domain" OR address = "$newfrom")|;
   my $sth       = $dbh->prepare($statement) or die "Couldn't prepare statement: $DBI::errstr; stopped";
      $sth->execute() or die "Couldn't execute statement: $DBI::errstr; stopped";
  if ($sth->rows > 0) { exit; } # It found a result, so exit the parsing
      $sth->finish;
     
#~~~

    $epre = $global{'epre'};

#~~
# Is this a response to a call?
#~~

 if ($subject =~ /\{$epre-/gi)
  {
        $callid      = $1 if $subject =~ /\{(\S+)\}/;
	$callno      = $callid;
	$callno      =~ s/$epre-//g;
	$statement   = 'SELECT id, username, email, status, category, subject FROM perlDesk_calls WHERE id = ?'; 
	  	  $sth =  $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 		  $sth->execute($callno) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
		   {
			$user      =  $ref->{'username'};
			$callemail =  $ref->{'email'};
			$status    =  $ref->{'status'};
			$category  =  $ref->{'category'};
			$subj      =  $ref->{'subject'};
		   }

             $callemail = lc($callemail);
             $newfrom   = lc($newfrom);

	 if ($callemail ne $newfrom) 
           {
               email( To => "$newfrom", From => "$ticketad", Subject => "\{$callid\} Help Desk Response", Body => "Sorry, you seem to have sent this help desk response to a call which is not owned by you. If you believe this to be a mistake, please check that you are sending this response from the email address used when logging this call.\n\nThank you." );
       	       exit;
           } 

 	 if ($status eq "CLOSED") 
           {
               $dbh->do(qq|UPDATE perlDesk_calls SET status = "OPEN" WHERE id = "$callno"|);
 
            my $sdsth = $dbh->prepare( "INSERT INTO perlDesk_activitylog VALUES ( ?, ?, ?, ?, ?)" );
               $sdsth->execute( "NULL", $callno, $hdtime, "User", "Request Re-Opened" ) or die "Couldn't execute statement: $DBI::errstr; stopped";

           }

      my @chars =  (A..Z);          $key   =  $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)];          
      $sth = $dbh->prepare( "INSERT INTO perlDesk_notes VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )" ) or die "couldnt prepare statement";
      $sth->execute( "NULL", "0", "1", "NULL", $callno, $user, $hdtime, $key, $body, "IP Not Available" ) or die "Couldnt execute statement";

      $statement = 'UPDATE perlDesk_calls SET aw = "1" WHERE id = ?';
      $sth       =  $dbh->prepare($statement)or die print "Couldn't prepare statement: $DBI::errstr; stopped";
      $sth->execute($callno);

      $statement = qq|SELECT * FROM perlDesk_staff WHERE access LIKE "%$category::%" OR access LIKE "%GLOB::%" OR access="admin"|;
        $sth = $dbh->prepare($statement)or die print "Couldn't prepare statement: $DBI::errstr; stopped";
        $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
            while(my $ref = $sth->fetchrow_hashref()) {
  		if ($ref->{'notify'} eq "1") {
			open(MAIL, "|$global{'sendmail'} -t") || print "Unable to send mail: $!";

                                chomp($recipient = $ref->{'email'});
				print MAIL "To: $recipient\n";
				print MAIL "From: $global{'adminemail'}\n";
				print MAIL "Subject: New Help Desk Response (USER)\n\n";
				print MAIL "There is a new email response made by the user in request $callid. \n";
				print MAIL "\nCall Details\n";
				print MAIL "---------------------------------------\n";
				print MAIL "\tResponse by......: $newfrom\n";
				print MAIL "\tCategory.........: $category\n";
				print MAIL "\tSubject..........: $subj\n\n$body\n\n";
				print MAIL "---------------------------------------\n";
				print MAIL "\n\nThank You.";
			close(MAIL); 
		}
	}
      $sth->finish;
      exit;
  }
 
 else {

	$statement = qq|SELECT * FROM perlDesk_em_forwarders WHERE address = "$to"|; 
	$sth       = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 			$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
		  {
			$category   = $ref->{'category'};
                        $requirereg = $global{'ereqreg'};
                        $send_res   = $ref->{'respond'};
                        $fromemail  = $ref->{'address'} || $ticketad;
		  }

      if ($sth->rows == "0")
        {
               email( To => "$newfrom", From => "$ticketad", Subject => "Email Error", Body => "Sorry, the request you have emailed has been forwarded to perldesk, however, there was an error processing it further:\n\nThe e-mail address ($to) has not been setup in the perldesk admin\n\nThank you." );
               exit;
        }

	$sth->finish;


if ($requirereg == "1")
 {
        $current_time =  time();

    	$statement    = 'SELECT username, name, email, url FROM perlDesk_users WHERE email = ?'; 
	$sth          =  $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
	$sth->execute( $newfrom ) or die print "Couldn't execute statement: $DBI::errstr; stopped";
	   while(my $ref = $sth->fetchrow_hashref()) 
		{
		   $username = $ref->{'username'};
		   $name     = $ref->{'name'}; 
		   $email    = $ref->{'email'};
	  	   $url      = $ref->{'url'};

                my $newtime = $ref->{'lcall'};
                   $newtime = $newtime + $global{'floodwait'};
      
                exit if $newtime > $current_time;
 		}
     	
      	      if ($sth->rows == "0") 
                  {
                        email( To => "$newfrom", From => "$ticketad", Subject => "Help Desk Submission", Body => "Sorry, you do not seem to have an account at the help desk. To submit requests via e-mail you must register. To do so please visit:\n\n$global{'baseurl'}/pdesk.cgi\n\nThank you." );
              	        exit;
		  }

              $sth->finish;
	
    $subject =~ s/\n//g;
    $body    =~ s/\r//g;
    $body    =~ s/\n/<br>/g if $ishtml == "0";
    $body    =~ s/\n//g     if $ishtml == "1";

	$mbody    = $dbh->quote($body);
	$msubject = $dbh->quote($subject);

	$current_time = time();


      my @chars =  (A..Z);          $key   =  $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)];          
      $priority   = "3" if !$priority;

 
   my $dsth       = $dbh->prepare( "INSERT INTO perlDesk_calls VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)" )  or die print "Couldn't prepare statement: $DBI::errstr; stopped";
      $dsth->execute( "NULL", "OPEN", $username, "$newfrom", "$priority", $category, $subject, $body, $hdtime, "Unowned", "NULL", "em", $current_time, $current_time, "1", "0", "0", "0", "$key" ) or die "Couldn't prepare statement: $DBI::errstr; stopped";;

      $trackno    = $dbh->{'mysql_insertid'}; 

   my $sdsth = $dbh->prepare( "INSERT INTO perlDesk_activitylog VALUES ( ?, ?, ?, ?, ?)" );
      $sdsth->execute( "NULL", $trackno, $hdtime, "User", "Request Logged" ) or die "Couldn't execute statement: $DBI::errstr; stopped";

 
     email ( To => "$global{'pageraddr'}", From => "$global{'adminemail'}", Subject => "URGENT SUPPORT REQUEST", Body => "Priority 1 Ticket Logged - ID $trackno - User $newfrom" ) if $global{'pager'} && $priority == "1";


   my $statement  = 'SELECT * FROM perlDesk_ticket_fields WHERE name = "email" LIMIT 1'; 
    my $sth       = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
       $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
    while(my $ref = $sth->fetchrow_hashref()) 
      {	
         my $sth = $dbh->prepare( "INSERT INTO perlDesk_call_fields VALUES ( ?, ?, ?, ? )" ) or die $DBI->errstr;
            $sth->execute( "NULL", $trackno, $ref->{'id'}, "$newfrom" ) or die $DBI->errstr;              
      }
  
	notify_tech();

	open(MAIL, "|/usr/sbin/sendmail -t") || print "Unable to send mail: $!";
			print MAIL "To: $newfrom\n";
			print MAIL "From: $fromemail\n";
			print MAIL "Subject: \{$epre-$trackno\} Help Desk Submission\n\n";
			open (MAILNEWTPL,"$global{'data'}/include/tpl/newticket.txt");
				while (<MAILNEWTPL>) {
                                  lang_parse();
				  if ($_ =~ /\{*\}/i) { 
					s/\{name\}/$name/g;
					s/\{baseurl\}/$global{'baseurl'}/g;
					s/\{subject\}/$subject/g;
					s/\{description\}/$body/g;
                                        s/\{mainfile\}/pdesk\.cgi/g;
					s/\{date\}/$hdtime/g;		
					s/\{key\}/$key/g;
    					s/\{id\}/$trackno/g;					
				  }			
			print MAIL "$_";
			}
	close(MAIL);
	}
 
elsif (!$requirereg) 
 {
 	        $statement = 'SELECT username, email, name, url FROM perlDesk_users WHERE email = ?'; 
		$sth =  $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
 			$sth->execute($newfrom) or die print "Couldn't execute statement: $DBI::errstr; stopped";
		while(my $ref = $sth->fetchrow_hashref()) 
		{
				$username = $ref->{'username'};
				$name     = $ref->{'name'}; 
				$url      = $ref->{'url'};
		}
                      my $registered = "no" if $sth->rows == "0"; 
    	$sth->finish;

  if ($registered eq "no") 
    {
        $create_account  =  $global{'autoacc'};
	$username        =  "Unregistered";    
        $name            =  "Unregistered";
        $url             =  "Unregistered"; 
    }

    $subject =~ s/\n//g;
    $body    =~ s/\r//g;
    $body    =~ s/\n/<br>/g if $ishtml == "0";
    $body    =~ s/\n//g     if $ishtml == "1";

    $mbody        =  $dbh->quote($body);
    $msubject     =  $dbh->quote($subject);
    $current_time =  time();

      my @chars =  (A..Z);          $key   =  $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)] . $chars[rand(@chars)];          
      $priority = "3" if !$priority;

   my $dsth = $dbh->prepare( "INSERT INTO perlDesk_calls VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )" ) or die "Couldn't prepare statement: $DBI::errstr; stopped";
      $dsth->execute( "NULL", "OPEN", $username, "$newfrom", "$priority", $category, $subject, $body, $hdtime, "Unowned", "NULL", "em", $current_time, $current_time, "1", "0", "0", "0", "$key" ) or die "Couldn't prepare statement: $DBI::errstr; stopped";
      $trackno    = $dbh->{'mysql_insertid'};

   my $sdsth = $dbh->prepare( "INSERT INTO perlDesk_activitylog VALUES ( ?, ?, ?, ?, ?)" );
      $sdsth->execute( "NULL", $trackno, $hdtime, "User", "Request Logged" ) or die "Couldn't execute statement: $DBI::errstr; stopped";


        email ( To => "$global{'pageraddr'}", From => "$global{'adminemail'}", Subject => "URGENT SUPPORT REQUEST", Body => "Priority 1 Ticket Logged - ID $trackno - User $newfrom" ) if $global{'pager'} && $priority == "1";

 
   my $statement  = 'SELECT * FROM perlDesk_ticket_fields WHERE name = "email" LIMIT 1'; 
   my $sth = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
      $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
   while(my $ref = $sth->fetchrow_hashref()) 
      {	
           my $sth = $dbh->prepare( "INSERT INTO perlDesk_call_fields VALUES ( ?, ?, ?, ? )" ) or die $DBI->errstr;
              $sth->execute( "NULL", $trackno, $ref->{'id'}, "$newfrom" ) or die $DBI->errstr;              
      }

      notify_tech();

            open(MAIL, "|$global{'sendmail'} -t") || print "Unable to send mail: $!";
		print MAIL "To: $newfrom\n";
		print MAIL "From: $fromemail\n";
		print MAIL "Subject: \{$epre-$trackno\} Help Desk Submission\n\n";
		open (MAILNEWTPL,"$global{'data'}/include/tpl/newticket.txt");
		  while (<MAILNEWTPL>) 
                     {
                          lang_parse();
			  if ($_ =~ /\{*\}/i) 
                             { 
	      			s/\{name\}/$name/g;
			    	s/\{subject\}/$subject/g;
			    	s/\{baseurl\}/$global{'baseurl'}/g;
			    	s/\{description\}/$mbody/g;
			    	s/\{date\}/$hdtime/g;
				s/\{key\}/$key/g;						
                                s/\{mainfile\}/pdesk\.cgi/g;
    					s/\{id\}/$trackno/g;
	  		     }			
		        print MAIL "$_";
 		     }
    	       close(MAIL);
          }
  }


  $parser->filer->purge();

 sub notify_tech 
   {
        $statement = 'SELECT * FROM perlDesk_staff WHERE access LIKE "%' . "$category" . '::%" OR access LIKE "%GLOB::%" OR access="admin"';
        $sth       =  $dbh->prepare($statement)or die print "Couldn't prepare statement: $DBI::errstr; stopped";
        $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
            while(my $ref = $sth->fetchrow_hashref()) 
             {
		if ($ref->{'notify'} eq "1") 
                   {
			open(MAIL, "|$global{'sendmail'} -t") || print "Unable to send mail: $!";
                                chomp($recipient = $ref->{'email'});
				print MAIL "To: $recipient\n";
				print MAIL "From: $global{'adminemail'}\n";
				print MAIL "Subject: New Help Desk Request\n";
				print MAIL "There is a new help desk submission. \n";
				print MAIL "\nCall Details\n";
				print MAIL "-----------------------------------------\n";
				print MAIL "\tLogged by....: $newfrom\n";
				print MAIL "\tSubject......: $subject\n\n";
				print MAIL "\n";
				print MAIL "-----------------------------------------\n";
				print MAIL "\n\nLogin URL: $global{'baseurl'}/staff.cgi\n\n";
				print MAIL "\n\nThank You.";
			close(MAIL); 
		   }
	     }
	$sth->finish;
  }


sub lang_parse 
  {
      if ($_ =~ /\%*\%/) {  s/\%(\S+)\%/$LANG{$1}/g;  }
  }


1;