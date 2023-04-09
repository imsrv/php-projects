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
#    Details: The main staff file                                                 #
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


   $CGI::DISABLE_UPLOADS = 0;
   $CGI::POST_MAX        = 500 * 1024;

 require "include/pd.cgi";
 require "include/conf.cgi";

 
eval {

   $dbh      =  DBI->connect("DBI:mysql:$dbname:$dbhost","$dbuser","$dbpass") or script_error("Could not connect to the help desk database");
   %global   =  get_vars();                                    
   $q        =  CGI->new();                         

   die_nice("Sorry, the file you are attempting to upload is above the specified file size limit") if $q->cgi_error =~ m/413/;

   &get_time();

   my $lang = $q->param('language');        # Get the language choice, or set it 
      $lang ?                               # as the default.
           $language = $lang :             
           $language = $global{'language'};  

    require "include/staff_subs.cgi";       # Get the Required Files  
    require "include/lang/$language.inc";   # Get the specified lang file
    require "include/parse/staff.cgi";    # The template parsing 
    navigate();                             # Run the program

    $dbh->disconnect;
 };

if ($@) {                                               
    script_error("$@");
    exit;
 }                                                       


sub navigate { 
               
          $action = $q->param('action');
          if ($action)
              {
                  check_user();
                  print "Content-type: text/html\n\n";
                  function("$action");
              }
           else {
                   section($q->param('do')) if  defined $q->param('do');
           
                    if (!$q->param('do'))
                     {
                         section("login");
                     }
                }
      exit;	
 }



