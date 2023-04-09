# ==================================================================
# Plugins::Banner - Auto Generated Install Module
#
# Plugins::Banner
# Author : Andy Newby
# Version : 1.1
# Updated : Sat Jun 1 15:18:15 2002
#
# ==================================================================
#

package Plugins::PHP_PPC_Banner;
# ==================================================================
use strict;
use vars qw/$VERSION $DEBUG $NAME $META/;
use GT::Base;
use GT::Plugins qw/STOP CONTINUE/;
use Links qw/$CFG $IN $DB/;

$VERSION = '1.1';
$DEBUG = 0;
$NAME = 'PHP_PPC_Banner';
# Inhert from base class for debug and error methods
@Plugins::PHP_PPC_Banner::ISA = qw(GT::Base);

$META = {
'prog_ver' => '2.1.0',
'description' => 'This script will allow you to use a tag, SSI or a PHP include to show banners on your site. Every time someone clicks on a banner, money is debited from their account. They can top up with PayPal (ClickBank coming soon) instantly. Comes with full admin control, statistics, advertiser login page and more... <br> <br> <font color="red">This is NOT free! Please send money via the menu link to help support me in my work! Failure to do so will just result in my withdrawing my plugins!</font>',
'license' => 'Commercial',
'url' => 'http://www.ace-installer.com',
'author' => 'Andy Newby',
'version' => '1.1'
};


sub pre_install {
# -------------------------------------------------------------------
# This function displays an HTML formatted message that will display
# to the user any instructions/information before they install
# the plugin.
#
my $inst_msg = 'This script will allow you to use a tag, SSI or a PHP include to show banners on your site. Every time someone clicks on a banner, money is debited from their account. They can top up with PayPal (ClickBank coming soon) instantly. Comes with full admin control, statistics, advertiser login page and more... <br> <br> <font color="red">This is NOT free! Please send money via the menu link to help support me in my work! Failure to do so will just result in my withdrawing my plugins!</font>';

return $inst_msg;
}

sub pre_uninstall {
# -------------------------------------------------------------------
# This function displays an HTML formatted message that will display
# to the user any instructions/information before they remove the
# plugin.
#
my $uninst_msg = 'I\'m sorry you decided not to use this plugin any more. Thanks for trying it.';

return $uninst_msg;
}

sub install {
# -------------------------------------------------------------------
# This function does the actual installation. It's first argument is
# a plugin manager which you can use to register hooks, install files,
# add menu options, etc. The second argument is a GT::Tar object which
# you can use to access any files in your plugin module.
#
# You should return an HTML formatted string that will be displayed 
# to the user.
#
# If there is an error, return undef, and set the error message in
# $Plugins::PHP_PPC_Banner::error
#
my ($mgr, $tar) = @_;

$mgr->install_menu ( 'PHP_PPC_Banner', [ ['Purchase', 'admin.cgi?do=plugin&plugin=PHP_PPC_Banner&func=Purchase'] ] );
$mgr->install_menu ( 'PHP_PPC_Banner', [ ['Readme', 'admin.cgi?do=plugin&plugin=PHP_PPC_Banner&func=Readme'] ] );
$mgr->install_menu ( 'PHP_PPC_Banner', [ ['FAQ', 'admin.cgi?do=plugin&plugin=PHP_PPC_Banner&func=FAQ'] ] );
$mgr->install_menu ( 'PHP_PPC_Banner', [ ['Admin', 'admin.cgi?do=plugin&plugin=PHP_PPC_Banner&func=Admin'] ] );

# Silence warnings
$GT::Tar::error ||= '';

# The following section will unarchive attached files into the 
# proper location.
my $file;

# Copying banner/advertiser_signup.php to $CFG->{admin_root_path}/.. directory.
$file = $tar->get_file ('banner/advertiser_signup.php');
$file->name("$CFG->{admin_root_path}/../banner/advertiser_signup.php");
$file->write or return Plugins::PHP_PPC_Banner->error("Unable to extract file: '$CFG->{admin_root_path}/../banner/advertiser_signup.php' ($GT::Tar::error)", 'WARN');

# Copying banner/banner.php to $CFG->{admin_root_path}/.. directory.
$file = $tar->get_file ('banner/banner.php');
$file->name("$CFG->{admin_root_path}/../banner/banner.php");
$file->write or return Plugins::PHP_PPC_Banner->error("Unable to extract file: '$CFG->{admin_root_path}/../banner/banner.php' ($GT::Tar::error)", 'WARN');

# Copying banner/click.php to $CFG->{admin_root_path}/.. directory.
$file = $tar->get_file ('banner/click.php');
$file->name("$CFG->{admin_root_path}/../banner/click.php");
$file->write or return Plugins::PHP_PPC_Banner->error("Unable to extract file: '$CFG->{admin_root_path}/../banner/click.php' ($GT::Tar::error)", 'WARN');

# Copying banner/admin/admin.php to $CFG->{admin_root_path}/.. directory.
$file = $tar->get_file ('banner/admin/admin.php');
$file->name("$CFG->{admin_root_path}/../banner/admin/admin.php");
$file->write or return Plugins::PHP_PPC_Banner->error("Unable to extract file: '$CFG->{admin_root_path}/../banner/admin/admin.php' ($GT::Tar::error)", 'WARN');

# Copying banner/admin/advertiser.php to $CFG->{admin_root_path}/.. directory.
$file = $tar->get_file ('banner/admin/advertiser.php');
$file->name("$CFG->{admin_root_path}/../banner/admin/advertiser.php");
$file->write or return Plugins::PHP_PPC_Banner->error("Unable to extract file: '$CFG->{admin_root_path}/../banner/admin/advertiser.php' ($GT::Tar::error)", 'WARN');

# Copying banner/admin/paypal.php to $CFG->{admin_root_path}/.. directory.
$file = $tar->get_file ('banner/admin/paypal.php');
$file->name("$CFG->{admin_root_path}/../banner/admin/paypal.php");
$file->write or return Plugins::PHP_PPC_Banner->error("Unable to extract file: '$CFG->{admin_root_path}/../banner/admin/paypal.php' ($GT::Tar::error)", 'WARN');

# Copying banner/admin/settings.inc.php to $CFG->{admin_root_path}/.. directory.
$file = $tar->get_file ('banner/admin/settings.inc.php');
$file->name("$CFG->{admin_root_path}/../banner/admin/settings.inc.php");
$file->write or return Plugins::PHP_PPC_Banner->error("Unable to extract file: '$CFG->{admin_root_path}/../banner/admin/settings.inc.php' ($GT::Tar::error)", 'WARN');

# Copying banner/admin/settings.inc.php to $CFG->{admin_root_path}/.. directory.
$file = $tar->get_file ('banner/install.php');
$file->name("$CFG->{admin_root_path}/../banner/install.php");
$file->write or return Plugins::PHP_PPC_Banner->error("Unable to extract file: '$CFG->{admin_root_path}/../banner/install.php' ($GT::Tar::error)", 'WARN');
;

my $setup_url = "$CFG->{admin_root_url}/../banner/install.php";
return "The plugin has been successfully installed!<BR><BR><b>Now <a href=\"$setup_url\">click here</a> to setup the MySQL tables and your initial data</b>";
}

sub uninstall {
# -------------------------------------------------------------------
# This function removes the plugin. It's first argument is
# also a plugin manager which you can use to register hooks, install files,
# add menu options, etc. You should return an HTML formatted string
# that will be displayed to the user.
#
# If there is an error, return undef, and set the error message in
# $Plugins::PHP_PPC_Banner::error
#
my $mgr = shift;

$mgr->uninstall_menu ( 'PHP_PPC_Banner', [ ['Purchase', 'admin.cgi?do=plugin&plugin=PHP_PPC_Banner&func=Purchase'] ] );
$mgr->uninstall_menu ( 'PHP_PPC_Banner', [ ['Readme', 'admin.cgi?do=plugin&plugin=PHP_PPC_Banner&func=Readme'] ] );
$mgr->uninstall_menu ( 'PHP_PPC_Banner', [ ['FAQ', 'admin.cgi?do=plugin&plugin=PHP_PPC_Banner&func=FAQ'] ] );
$mgr->uninstall_menu ( 'PHP_PPC_Banner', [ ['Admin', 'admin.cgi?do=plugin&plugin=PHP_PPC_Banner&func=Admin'] ] );
;
return "The plugin has been successfully removed!";
}

1;
