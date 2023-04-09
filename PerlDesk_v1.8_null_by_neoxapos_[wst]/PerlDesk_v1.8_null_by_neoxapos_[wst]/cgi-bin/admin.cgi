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
#   Filename: staff.cgi                                                           #
#    Details: The main admin file                                                 #
#    Release: 1.7                                                                 #
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
 use CGI qw(:standard);                                 
 use DBI();                                             
 use Digest::MD5;   

 use lib 'include/mods';
 use Mail::Sender;

 require "include/pd.cgi";
 require "include/conf.cgi";

 
 if ((-e "install.cgi") || (-e "upgrade.cgi"))
  {
     script_error("You MUST delete install.cgi/upgrade.cgi before using the admin");
  }


eval {

   $dbh      =  DBI->connect("DBI:mysql:$dbname:$dbhost","$dbuser","$dbpass") or script_error("Could not connect to the help desk database");
   %global   =  get_vars();                                    
   $q        =  CGI->new();                         

   &get_time();

   my $lang = $q->param('language');        # Get the language choice, or set it 
      $lang ?                               # as the default.
           $language = $lang :             
           $language = $global{'language'};  

    require "include/admin_subs.cgi";       # Get the Required Files  
    require "include/lang/$language.inc";   # Get the specified lang file
    require "include/parse/admin.cgi";    # The template parsing 

    navigate();                             # Run the program
    $dbh->disconnect;
 };

if ($@)
 {                                               
    script_error("$@");
    exit;
 }                                                       


sub navigate 
   {         
          section($q->param('do')) if  defined $q->param('do');
          section("login")         if  !$q->param('do');  
        exit;	
   }



