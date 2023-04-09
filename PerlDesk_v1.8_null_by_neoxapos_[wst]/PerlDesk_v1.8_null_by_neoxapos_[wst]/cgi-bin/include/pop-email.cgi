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
#   Filename: pop-email.cgi                                                       #
#    Details: The main email gateway file  (pop server)                           #
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

 eval{
         use lib '/home/perldesk/www/beta/1.8/include/mods';
         require "/home/perldesk/www/beta/1.8/include/conf.cgi";

         $PIPE_FILE = "/home/perldesk/www/beta/1.8/include/email.cgi";            # EMAIL.CGI FILE

         #~~ No further editing required

         &grab_emails; 
      };

  if ($@) {                                               
           print "ERROR: $@";              # There was an error, exit!
           exit;
        }  

sub grab_emails
 {
  use CGI qw(:standard);
  use DBI();
  use Mail::POP3Client;


#~~
# Establish Database Connection


   $dbh  = DBI->connect("DBI:mysql:$dbname:$dbhost","$dbuser","$dbpass");


#~~
# Establish POP3 Connection


    my $AMODE = "PASS";            	      

    my $query = "SELECT * from perlDesk_popservers";
    my $sth   = $dbh->prepare($query);
       $sth->execute;

    while (my $ref = $sth->fetchrow_hashref)
      {
  	    my $pop_server = new Mail::POP3Client( USER   =>  $ref->{'pop_user'},
	   				        PASSWORD  =>  $ref->{'pop_password'},
					        HOST      =>  $ref->{'pop_host'},
					        PORT      =>  $ref->{'pop_port'},
					        AUTH_MODE =>  $AMODE,
					        DEBUG     =>  "0");

   	   my $state = $pop_server->State();

  	      die "Sorry, I was unable to establish a connection with $ref->{'pop_host'}: $state" unless ($state eq "TRANSACTION");

           $total = $pop_server->Count();

	for (my $i = 1; $i <= $pop_server->Count(); $i++)
           {
                open PERLDESK, "| $PIPE_FILE"
                                         		or die "Sorry, I was unable to open the PerlDesk email.cgi file: $!";

   	              local $SIG{PIPE} = sub { die "PERLDESK pipe broken" };

   	              my $line = $pop_server->HeadAndBody($i);
 
                      print PERLDESK $line;
                      $pop_server->Delete($i);

	        close PERLDESK or die "Could Not Close PIPE: $!";
	}

	$pop_server->Close() or die "Error closing connection: $!";

        print "$total Emails Downloaded from $ref->{'pop_user'} \@ $ref->{'pop_host'}\n";
    }

   print "You have not set any POP retrieval up\n" if !$sth->rows;
 }



1;

