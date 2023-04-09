#!/usr/bin/perl
##############################################################################
use CGI::Carp qw(fatalsToBrowser);
use CGI qw(:standard);                    # Saves loads of work
$CGI::POST_MAX=1024 * 150;                # limit post data
$CGI::DISABLE_UPLOADS = 1;                # Disable uploads

##############################################################################
require "configdat.lib";
require "gensubs.lib";
require "entry.lib";
require "createprofile.lib";
require "editprofile.lib";
require "browseroutine.lib";
require "variables.lib";
require "userspresent.lib";
require "send_message.lib";
require "register.lib";
require "messagecenterform.lib";
require "feature.lib";
require "retrievepass.lib";
require "defaulttext.lib";
require "postroutine.lib";
require "delprof.lib";
##############################################################################
   read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
   @pairs = split(/&/, $buffer);
   foreach $pair (@pairs) {
      ($name, $value) = split(/=/, $pair);
      $value =~ tr/+/ /;
      $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
      $value =~ s/<!--(.|\n)*-->//g;
      if ($allow_html != 1) {
      $value =~ s/<([^>]|\n)*>//g;
      }
      else {
         unless ($name eq 'body') {
         $value =~ s/<([^>]|\n)*>//g;
         }
         }
      $in{$name} = $value;
   }

##############################################################################
$query = new CGI;
$thisprog="postad.pl";

$inmembername=$query->param('inmembername');
$inpassword=$query->param('inpassword');

$cookiepath = $query->url(-absolute=>1);
$cookiepath =~ s/$thisprog//sg;

if (! $inmembername) { $inmembername = cookie("amembernamecookie"); }
if (! $inpassword)   { $inpassword   = cookie("apasswordcookie");   }

	if ($FORM{'thisdelb'} eq "Delete Ad") {
  	&delete;
	}

	elsif (($FORM{'retrievepass'} ne "") || ($ENV{'QUERY_STRING'} =~ /retrievepass/))
	{&retrievepass;	}
	
	elsif (($FORM{'addpicform'} ne "") || ($ENV{'QUERY_STRING'} =~ /addpicform/)){
	&print_header;	
	&addpicform;
  	exit;}

	elsif (($FORM{'placenew'} ne "") || ($ENV{'QUERY_STRING'} =~ /place_new/)){
  	&coutpostform;}

	elsif (($FORM{'edpro'} ne "") || ($ENV{'QUERY_STRING'} =~ /edpro/)){
  	&editprofile;}

	elsif (($FORM{'edad'} ne "") || ($ENV{'QUERY_STRING'} =~ /edad/)){
  	&edad;}

	elsif (($FORM{'browse_ads'} ne "") || ($ENV{'QUERY_STRING'} =~ /browse_ads/))
 	 {
  	&print_header;
  	&browse_ads;
  	exit;
  	}

	elsif (($FORM{'viewads'} ne "") || ($ENV{'QUERY_STRING'} =~ /viewads/))
 	 {&viewads;  	
  	}

	elsif (($FORM{'reg_form'} ne "") || ($ENV{'QUERY_STRING'} =~ /reg_form/))
  	{
  	&print_header;
  	&reg_form;
  	exit;
  	} 

	elsif (($FORM{'message_center'} ne "") || ($ENV{'QUERY_STRING'} =~ /message_center/))
  	{
  	&print_header;
  	&message_center;
  	exit;	
  	}  

	elsif (($FORM{'send_message'} ne "") || ($ENV{'QUERY_STRING'} =~ /send_message/))
  	{
  	&send_message;
  	exit;
  	} 

	elsif (($FORM{'launchindex'} ne "") || ($ENV{'QUERY_STRING'} =~ /launchindex/))
  	{
  	&launchindex;
  	exit;
  	}

	elsif (($FORM{'createprofile'} ne "") || ($ENV{'QUERY_STRING'} =~ /createprofile/))
  	{&createprofile;} 


	elsif (($FORM{'getfeatured'} ne "") || ($ENV{'QUERY_STRING'} =~ /getfeatured/))
  	{
  	&print_header;
  	&getfeatured;
  	exit;
  	}


	elsif (($FORM{'lovestories'} ne "") || ($ENV{'QUERY_STRING'} =~ /lovestories/))
  	{
  	&print_header;
  	&lovestories;
  	exit;
  	} 


 	elsif (($FORM{'delpersad'} ne "") || ($ENV{'QUERY_STRING'} =~ /del_persad/))
  	{
  	&print_header;
  	&coutdelsfrm;
  	exit;
  	} 


	elsif ($FORM{'clearcat'} ne "") {
	&print_header;
	&delete_all;
	}

	else  {
	print "Location: $cgiurl/index.pl\n\n";
	}

##############################################################################
