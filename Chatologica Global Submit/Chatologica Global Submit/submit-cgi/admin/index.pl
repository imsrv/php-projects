#!/usr/bin/perl
#########################################################################################
# Chatologica ... admin/index.pl - your web-based Admin Panel
# All rights reserved (c) 2000; http://www.chatologica.com/
#########################################################################################
# 
#   PURPOSE: Manipulate the parameters.pl via the web interface of Admin Panel
# 
#########################################################################################

use strict;				# use strict pragma
my $path = $0;				# changing the current working directory to the directory
if($path =~ s{[/\\][^/\\]+$}{}) {	# where this script file resides
    chdir($path) || ((print "Content-type: text/html\n\nCouldn't navigate to '$path' directory!") && exit);	
};
chdir "../";
require 'lib/cgi-handler.pl';		# standard cgi input handler
require 'lib/common.pl';		# some frequently used procedures
require 'parameters.pl';		# load current parameters

# definition of global variables (imported from parameters.pl):
use vars qw(
	$timeout
	$log_it
	$full_header
);
use vars qw(
	$make_submit_data_code
	%profile
);
my( 				# definition of global for this file variables:
	%in,			# input data
	$i,			# index variable
) = ();
&Parse_CGI_Input(\%in);    	# read/parse the input data and put it in hash %in


if($in{'action'}) {			# we receive from browser new parameters that 
   $timeout = $in{'timeout'} + 0;	# have to save in parameters.pl
   $log_it = $in{'log_it'} + 0;
   $full_header = $in{'full_header'} + 0;
   if(($timeout < 1) || ($timeout !~ m/^\d+$/)) {
	&DieMsg("Timeout must be an integer number greater than 0!");
   };
   # AN IMPORTANT SECURITY CHECK - remove any ' sign in values
   $log_it =~ s/\'//g;
   $timeout =~ s/\'//g;
   $full_header =~ s/\'//g;
   my $tag_parameters = <<"end_of_parameters";
#####################################################################################
# Chatologica parameters.pl - manage this program behaviour through parameters
# All rights reserved (c) 2000; http://www.chatologica.com/
#####################################################################################
#
#	Edit this file and then save in ASCII mode. Alternatively you can use
#	web based Admin Panel (if available) to manipulate this file.
#
#	'#' sign means comment
# 	1 is TRUE
#	0 is FALSE
#
#####################################################################################

# Server-side http connection timeout (in seconds) for a submission.
# Example: \$timeout = '10';		# 10 seconds timeout
\$timeout = '$timeout';

# Log each submission in log file.
# Example: \$log_it = '1';		# log the queries
\$log_it = '$log_it';

# Send full http response header for nph-scripts.
# Example: \$full_header = '1';
\$full_header = '$full_header';



1; # this library must return TRUE


end_of_parameters
   open(F,'>parameters.pl');	# save this in ../parameters.pl file
   print F $tag_parameters;
   close(F);
};



# Preparing html components to be included in the response Admin Panel page:
my (%out) = ();
$out{'timeout'} = $timeout;
my (%log_it_select, %full_header_select) = ();
$log_it_select{$log_it} = ' SELECTED';
$full_header_select{$full_header} = ' SELECTED';
$out{'modules'} = &modules_installed;
open(F,'<admin/admin.htm');		# open and read from template file
my @admin_page = <F>;
close F;				# Show the page:
eval("print <<\"endofhtml\";\nContent-type: text/html\n\n@admin_page\nendofhtml\n");



sub modules_installed		# generate html code of the LIST OF ALL INSTALLED MODULES
{
   my(@modules,$mod, $code, $mod_tag, $all_mod_tags, $m, $num) = ();
   @modules = sort &dir('modules');
   $num = 0;
   foreach $m (@modules) {
     if($m =~ m/\.pl$/) { 			# modules are perl files
	(%profile,				# init module data
	$make_submit_data_code) = ();		
	$num ++;			
	eval{require "modules/$m";};		# load this module
	if($@) {
	    &DieMsg("error during compilation of module $m:<BR> $@");
	};
    	if(!%profile) {
	    &DieMsg("error: %profile is not defined for module $m\n");
    	};
    	if(!$make_submit_data_code) {
	    &DieMsg("error: \$make_submit_data_code is not defined for module $m\n");
    	};		
	$mod_tag = <<"endofhtml";
      <TR>
	<TD><P ALIGN=Center>
	  $m</TD>
	<TD><P ALIGN=Center>
	  $profile{'created_on'}</TD>
	<TD><P ALIGN=Center>
	  $profile{'version'}</TD>
	<TD><P ALIGN=Center>
	  <B><A HREF="$profile{'site_URL'}">$profile{'site_name'}</A></B> <SMALL>{<A HREF="$profile{'addurl_page'}">AddURL page</A>}</SMALL></TD>
      </TR>
endofhtml
         $all_mod_tags .= $mod_tag;
       };
   };
   # making the table code
   $code = <<"endofhtml";
<CENTER>
<I><FONT COLOR="#ff0000"><B>$num</B></FONT> Modules installed: </I>
    <TABLE BORDER="3" CELLPADDING="2" ALIGN="Center" WIDTH="90%">
    <TR BGCOLOR="#aaaaaa">
      <TD><P ALIGN=Center>
	<FONT COLOR="#000000">
	<FONT FACE="Arial"><SMALL><B>file name</B></SMALL></FONT></FONT></TD>
      <TD><P ALIGN=Center>
	<FONT COLOR="#000000"> <FONT FACE="Arial"><SMALL><B>date of
	creation</B></SMALL></FONT></FONT></TD>
      <TD><P ALIGN=Center>
	<FONT COLOR="#000000">
	<FONT FACE="Arial"><SMALL><B>version</B></SMALL></FONT></FONT></TD>
      <TD><P ALIGN=Center>
	<FONT COLOR="#000000">
	<FONT FACE="Arial"><SMALL><B>description</B></SMALL></FONT></FONT></TD>
    </TR>
      $all_mod_tags
    </TABLE>
  </CENTER>
endofhtml
   return $code;
};
    

   