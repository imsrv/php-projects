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
	unshift(@INC, "$CONFIG{script_path}/scripts");
	require "admin.pl";
	require "admin_gateway.pl";
	require "admin_html.pl";
	require "database.pl";
	require "new_database.pl";
	require "display.pl";
	require "default_config.pl";
	require "display.pl";
	require "english.lng";
	require "gateway.pl";
	require "html.pl";
	require "library.pl";
	require "members.pl";
	require "mojoscripts.pl";
	require "parse_template.pl";
	require "serverinfo.pl";
	require "templates.pl";
	use CGI qw(:standard);
	use CGI::Carp qw(fatalsToBrowser);
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
	&BuildAdminLocation;
   if ($FORM{action} eq "login" or $FORM{'login'}) { 			&AdminLogin;		}
   elsif ($FORM{logout} or $FORM{'action'} eq 'logout') {	&AdminLogout;		}

   &CheckSession;

	if($FORM{'type'} eq "setup"){			require "admin_setup.pl";			&SetupMain;		}
	elsif($FORM{'type'} eq "ad"){			require "admin_ads.pl";				&AdMain;			}
	elsif($FORM{'type'} eq "account" and (-f "$CONFIG{script_path}/scripts/admin_accounts.pl")){	require "admin_accounts.pl";	&AccountMain;	}
	elsif($FORM{'type'} eq "admin"){		require "admin_admin.pl";			&AdminMain;		}
	elsif($FORM{'type'} eq "config"){	require "admin_setup.pl";			&SetupMain;		}
	elsif($FORM{'type'} eq "cat"){		require "admin_categories.pl";	&CategoryMain;	}
	elsif($FORM{'type'} eq "database"){	require "admin_database.pl";		&DatabaseMain;	}
	elsif($FORM{'type'} eq "gateway"){	require "admin_gateway.pl";		&GatewayMain;	}
	elsif($FORM{'type'} eq "group"){		require "admin_groups.pl";			&GroupMain;		}
	elsif($FORM{'type'} eq "member"){	require "admin_members.pl";		&MemberMain;	}
	elsif($FORM{'type'} eq "mail"){		require "admin_mails.pl";			&MailMain;		}
#	elsif($FORM{'type'} eq "protect"){	require "admin_protector.pl";		&ProtectorMain;}
#	elsif($FORM{'type'} eq "story"){		require "admin_story.pl";			&StoryMain;		}
	elsif($FORM{'type'} eq "security"){	require "admin_security.pl";		&SecurityMain;	}
	elsif($FORM{'type'} eq "template"){	require "admin_templates.pl";		&TemplateMain;	}
	elsif($FORM{'type'} eq "server"){	require "serverinfo.pl";			&ServerInfo;	}
	elsif($FORM{'type'} eq "support"){	require "admin_support.pl";		&SupportMain;	}
	elsif($FORM{'type'} eq "utils"){		require "admin_utils.pl";			&UtilsMain;		}

	elsif($FORM{'type'} eq "checkout" and -f "$CONFIG{script_path}/scripts/admin_checkout.pl"){	require "admin_checkout.pl";		&CheckoutMain;	}
	elsif($FORM{'type'} eq "clickbank" and -f "$CONFIG{script_path}/scripts/admin_clickbank.pl"){require "admin_clickbank.pl";		&ClickbankMain;}
	elsif($FORM{'type'} eq "ibill" and -f "$CONFIG{script_path}/scripts/admin_ibill.pl"){		require "admin_ibill.pl";				&iBillMain;		}
	elsif($FORM{'type'} eq "paypal" and -f "$CONFIG{script_path}/scripts/admin_paypal.pl"){	require "admin_paypal.pl";				&PaypalMain;	}

	elsif($FORM{'type'}){	&PrintError($mj{'error'}, $mj{'confuse'});	}
	&PrintAdmin;
}
###############################################################




