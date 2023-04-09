#!/usr/bin/perl

# ==================================================================
# MojoPersonals MySQL
#
#   Website  : http://mojoscripts.com/
#   Support  : http://mojoscripts.com/contact/
# 
# Copyright (c) 2002 mojoscripts.com Inc.  All Rights Reserved.
# Redistribution in part or in whole strictly prohibited.
# ==================================================================
#
#    End-User License Agreement for MojoPersonals MySQL:
#--------------------------------------------------------------------
# After reading this agreement carefully, if you do not agree
# to all of the terms of this agreement, you may not use this software.
#
# This software is owned by ascripts.com Inc. and is protected by
# national copyright laws and international copyright treaties.
#
# This software is licensed to you.  You are not obtaining title to
# the software or any copyrights.  You may not sublicense, sell, rent,
# lease or free-give-away the software for any purpose.  You are free
# to modify the code for your own personal use. The license may be
# transferred to another only if you keep NO copies of the software.
#
# This license covers one installation of the program on one domain/url only.
#
# THIS SOFTWARE AND THE ACCOMPANYING FILES ARE SOLD "AS IS" AND
# WITHOUT WARRANTIES AS TO PERFORMANCE OR MERCHANTABILITY OR ANY
# OTHER WARRANTIES WHETHER EXPRESSED OR IMPLIED.
#
# NO WARRANTY OF FITNESS FOR A PARTICULAR PURPOSE IS OFFERED.
# ANY LIABILITY OF THE SELLER WILL BE LIMITED EXCLUSIVELY TO PRODUCT
# REPLACEMENT OR REFUND OF PURCHASE PRICE. Failure to install the
# program is not a valid reason for refund of purchase price.
#
# The user assumes the entire risk of using the program.
#--------------------------------------------------------------------

############################################################
eval {
	($0=~ m,(.*)/[^/]+,)   && unshift (@INC, "$1");
	($0=~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1");
	require "config.pl";
	unshift(@INC, $CONFIG{script_path});
	unshift(@INC, "$CONFIG{script_path}/scripts");
  	require "database.pl";
  	require "new_database.pl";
	require "default_config.pl";
	require "display.pl";
	require "english.lng";
	require "gateway.pl";
	require "html.pl";
	require "library.pl";
	require "logs.pl";
	require "members.pl";
	require "templates.pl";
	require "mojoscripts.pl";
	require "parse_template.pl";
	require "serverinfo.pl";
	use CGI qw(:standard);
	use CGI::Carp qw(fatalsToBrowser);
	use File::Path;
	use strict;
#	use vars qw($Cgi, %FORM);
   &main;
};
if ($@) {
	print "content-type:text/html\n\n";
	print "Error Including configuration file, Reason: $@";
	exit;
}
################################################################
sub main {
	$|++;
	$Cgi = new CGI; $Cgi{mojoscripts_created} = 1;
	&ParseForm;
	&Initialization;
	&CheckAllRequiredFiles;
	&LogUser;
        if($FORM{action} eq "upgrade"){  require "gateway.pl"; &Upgrade;}
        elsif($FORM{type} eq "member"){  require "members.pl"; &MemberMain;}

	&CheckMemberPermission;
        if($FORM{type} eq "ad"){         require "ads.pl"; &AdMain;}
        elsif($FORM{type} eq "personal"){require "personals.pl"; &Personals;}
        elsif($FORM{type} eq "mail"){    require "mailbox.pl";  &Mailbox;}
        elsif($FORM{type} eq "gallery"){ require "gallery.pl"; &GalleryMain;}

        elsif($FORM{adid}){             &AdView;}
        elsif ($FORM{cat}){             &DisplayCategory;}
	&DisplayHome;
}
############################################################
sub DisplayHome{
	&BuildSubcategories;
	unless($MOJO{cats}){
		$MOJO{cats} =qq|<h2>No Ad category has been defined</h2>
              <BLOCKQUOTE>
 It appears that your installation of $mj{program} $mj{version} has been successfull.
 You can now login into the admin area to define some Ad categories of your own
 If you have not changed your admin password, the default of <b>admin/mojoscripts</b> will work.
 <br><br><br>
 Thanks<br>
 mojoStaff
 </BLOCKQUOTE> |;
	}
	&PrintTemplate($TEMPLATE{home});
}
############################################################
sub DisplayCategory{
#        &CheckCategory("$CONFIG{data_path}/$FORM{cat}");
	&BuildNextPrevCategory;
	&BuildSubcategories;
        &BuildCategoryAds;
	&PrintTemplate($TEMPLATE{category});
}
############################################################

