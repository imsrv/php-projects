# ==================================================================
# Plugins::SearchFeed_Results - Auto Generated Install Module
#
#   Plugins::SearchFeed_Results
#   Author  : Andy Newby
#   Version : 1
#   Updated : Sat Sep 14 13:49:47 2002
#
# ==================================================================
#

package Plugins::SearchFeed_Results;
# ==================================================================
    use strict;
    use vars  qw/$VERSION $DEBUG $NAME $META/;
    use GT::Base;
    use GT::Plugins qw/STOP CONTINUE/;
    use Links qw/$CFG $IN $DB/;

    $VERSION = '1';
    $DEBUG   = 0;
    $NAME    = 'SearchFeed_Results';
# Inhert from base class for debug and error methods
    @Plugins::SearchFeed_Results::ISA = qw(GT::Base);

    $META = {
    'prog_ver' => '2.1.0',
    'description' => 'This will grab the results from SearchFeed.com, and add them to the end (or beginning) of your results...',
    'license' => 'Freeware',
    'url' => 'http://www.ace-installer.com',
    'author' => 'Andy Newby',
    'version' => '1'
};


sub pre_install {
# -------------------------------------------------------------------
# This function displays an HTML formatted message that will display
# to the user any instructions/information before they install
# the plugin.
#
    my $inst_msg = 'Hi. Please consider sending me a donation for this plugin, <a href=http://www.ace-installer.com/php/modules.php?name=Content&pa=showpage&pid=9>here</a>, and also, when signing up for SearchFeed.com, please use us as your affiliate referer....we get some gredit then :) <a href=http://www.searchfeed.com/rd/AffiliateInfo.jsp?p=5491>CLICK HERE TO SIGNUP</a>';

    return $inst_msg;
}

sub pre_uninstall {
# -------------------------------------------------------------------
# This function displays an HTML formatted message that will display
# to the user any instructions/information before they remove the
# plugin.
#
    my $uninst_msg = 'Sorry to see you are uninstalling :(';

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
# $Plugins::SearchFeed_Results::error
#
    my ($mgr, $tar) = @_;

# The following section will unarchive attached files into the 
# proper location.
    my $file;

# if templates already exist...dont get rid of em!

            $file = $tar->get_file ("search_link.html");
             $file->name("$CFG->{admin_root_path}/templates/$CFG->{build_default_tpl}/search_link.html") or return Plugins::SearchFeed_Results->error("Error: $GT::Tar::error");
             unless ($file->write) {
		return Plugins::SearchFeed_Results->error("Unable to extract file: '$CFG->{admin_root_path}/templates/$CFG->{build_default_tpl}/search_link.html' ($GT::Tar::error)", 'WARN');
	     }
        
    
    $mgr->install_hooks ( 'SearchFeed_Results', [ ['search_results', 'PRE', 'Plugins::SearchFeed_Results::do_checks', 'FIRST'] ]);
    $mgr->install_menu ( 'SearchFeed_Results', [ ['Readme', 'admin.cgi?do=plugin&plugin=SearchFeed_Results&func=Readme'] ] );
    $mgr->install_options ( 'SearchFeed_Results', [ ['SearchFeed_Affiliate_ID', '5491', 'This is your ID number with SearchFeed. Make sure you change it, otherwise you won\'t get credit!', 'TEXT', [], [], '' ] ] );
    $mgr->install_options ( 'SearchFeed_Results', [ ['Active', '1', 'Set to 0 if you don\'t want this plugin to be active, or 1 if you want the results to be grabbed...', 'TEXT', [], [], '' ] ] );
   
    return "The plugin has been successfully installed!";
}

sub uninstall {
# -------------------------------------------------------------------
# This function removes the plugin. It's first argument is
# also a plugin manager which you can use to register hooks, install files,
# add menu options, etc. You should return an HTML formatted string
# that will be displayed to the user.
#
# If there is an error, return undef, and set the error message in
# $Plugins::SearchFeed_Results::error
#
    my $mgr = shift;
    
    $mgr->uninstall_hooks ( 'SearchFeed_Results', [ ['search_results', 'PRE', 'Plugins::SearchFeed_Results::do_checks', 'FIRST'] ]);
    $mgr->uninstall_menu ( 'SearchFeed_Results', [ ['Readme', 'admin.cgi?do=plugin&plugin=SearchFeed_Results&func=Readme'] ] );
    $mgr->uninstall_options ( 'SearchFeed_Results', [ ['SearchFeed_Affiliate_ID', '5491', 'This is your ID number with SearchFeed. Make sure you change it, otherwise you won\'t get credit!', 'TEXT', [], [], '' ] ] );
    $mgr->uninstall_options ( 'SearchFeed_Results', [ ['Active', '1', 'Set to 0 if you don\'t want this plugin to be active, or 1 if you want the results to be grabbed...', 'TEXT', [], [], '' ] ] );    

    return "The plugin has been successfully removed!";
}

1;
