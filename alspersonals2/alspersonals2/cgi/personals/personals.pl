#!/usr/bin/perl 
use CGI::Carp qw(fatalsToBrowser);
use CGI qw(:standard);
$CGI::POST_MAX=1024 * 150;                # limit post data
$CGI::DISABLE_UPLOADS = 1;                # Disable uploads
$CGI::HEADERS_ONCE = 1;
####################################################################
# Copyright 2001
# Adela Lewis
# All Rights Reserved
####################################################################
require "login.lib"; 
require "gensubs.lib";   
require "configdat.lib";    
require "routines.lib";  
require "variables.lib";  
require "register.lib";  
require "createprofile.lib"; 
require "validate.lib"; 
require "continueappend.lib"; 
require "delprof.lib"; 
require "browseroutine.lib";
require "writeadmin.lib";
require "index.lib";
require "defaulttext.lib";
require "messagecenterform.lib";
require "mestransmitter.lib";
require "userspresent.lib";
require "lovescope.lib";
require "launchmessagecenter.lib";
require "editprofile.lib";
require "postroutine.lib";
require "searchads.lib";
require "feature.lib";
require "retrievepass.lib";
require "loginreminder.lib";
require "entry.lib";
require "upload.lib";
################################################################# 

&readparse;  

$query = new CGI;
$thisprog="personals.pl";
$cookiepath = $query->url(-absolute=>1);
$cookiepath =~ y/$thisprog//;

$inmembername=$query->param('inmembername');
$inpassword=$query->param('inpassword');

		if (! $inmembername) { $inmembername = cookie("amembernamecookie"); }
	    	if (! $inpassword)   { $inpassword   = cookie("apasswordcookie"); }
		if(! $inclass){$inclass=cookie("aclasscookie");}  
&routines;      


#################################################################    
1;