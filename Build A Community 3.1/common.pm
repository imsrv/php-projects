##############################################################################
# PROGRAM : BuildACommunity.com Perl Module                                  #
# VERSION : 3.1                                                              #
#                                                                            #
# NOTES   :                                                                  #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 1999 -> 2017                                                 #
#           Eric L. Pickup, Ecreations, BuildACommunity                      #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    ------ DO NOT MODIFY ANYTHING BELOW THIS POINT !!! ------               #
#                                                                            #
##############################################################################

use Text::Template;
($open_deliminator, $close_deliminator) = ("[<(", ")>]");

# The following grabs and sets the CONFIG Vars...
	require 'data.path'; 
	require "$data_dir/local.settings";
	($COMMUNITY_Database, $databaseconnect, $mail_cmd, $server_type, $CGI_DIR, $server_address, $server_cgibin) = &get_local_settings;
	require "$data_dir/global.settings";
	%CONFIG = &get_settings;
	$CONFIG{'data_dir'} = $data_dir;
	$CONFIG{'libpath'} = $libpath;
	$CONFIG{'mail_cmd'} = $mail_cmd;


	if ($CONFIG{'win_color'} ne "") {$CONFIG{'WINCOLOR'} = " BGCOLOR=\"$CONFIG{'win_color'}\" "; }
	if (-e "./cforum.cgi") {$CONFIG{'cforum_present'}++;}


if ($COMMUNITY_Database eq "MySQL") {
	%SERVER = &get_servers;
}
else {
	%SERVER = (
		'java'                            => $server_address,
		'user'                            => $server_address,
		'admin'                           => $server_address,
		'cf'                              => $server_address,
		'autohome'                        => $server_address,
		'weaver'                          => $server_address,
		'gallery'                         => $server_address,
		'postcards'                       => $server_address
	);
}


%GPath = (
	'ioascii.pm'                      => "$CONFIG{'libpath'}/ioascii.pm",
	'usermysql.pm'                    => "$CONFIG{'libpath'}/usermysql.pm",
	'iomysql.pm'                      => "$CONFIG{'libpath'}/iomysql.pm",

	'autoloader.language'             => "$CONFIG{'libpath'}/autoloader.language",

	'autoemail.pm'                    => "$CONFIG{'libpath'}/autoemail.pm",

	'cf.pm'                           => "$CONFIG{'libpath'}/cf.pm",
	'cf_email.pm'                     => "$CONFIG{'libpath'}/cf_email.pm",
	'cf_errors.pm'                    => "$CONFIG{'libpath'}/cf_errors.pm",
	'cf_logs.pm'                      => "$CONFIG{'libpath'}/cf_logs.pm",
	'cf_modify.pm'                    => "$CONFIG{'libpath'}/cf_modify.pm",
	'cf_search.pm'                    => "$CONFIG{'libpath'}/cf_search.pm",
	'cf_windows.pm'                   => "$CONFIG{'libpath'}/cf_windows.pm",

	'cgitoolkit.pm'                   => "$CONFIG{'libpath'}/cgitoolkit.pm",
	'colorforms.pm'                   => "$CONFIG{'libpath'}/colorforms.pm",
	'common.pm'                       => "$CONFIG{'libpath'}/common.pm",
	'community.pm'                    => "$CONFIG{'libpath'}/community.pm",
	'community_admin.pm'              => "$CONFIG{'libpath'}/community_admin.pm",
	'data.pm'                         => "$CONFIG{'libpath'}/data.pm",
	'ecreations.pm'                   => "$CONFIG{'libpath'}/ecreations.pm",
	'forms.pm'                        => "$CONFIG{'libpath'}/forms.pm",
	'forms_bbs.pm'                    => "$CONFIG{'libpath'}/forms_bbs.pm",
	'forms_easy.pm'                   => "$CONFIG{'libpath'}/forms_easy.pm",
	'forms_email.pm'                  => "$CONFIG{'libpath'}/forms_email.pm",
	'forms_guestbook.pm'              => "$CONFIG{'libpath'}/forms_guestbook.pm",
	'forms_ilink.pm'                  => "$CONFIG{'libpath'}/forms_ilink.pm",
	'forms_index.pm'                  => "$CONFIG{'libpath'}/forms_index.pm",
	'forms_links.pm'                  => "$CONFIG{'libpath'}/forms_links.pm",
	'forms_frames.pm'                 => "$CONFIG{'libpath'}/forms_frames.pm",
	'forms_poll.pm'                   => "$CONFIG{'libpath'}/forms_poll.pm",
	'forms_search.pm'                 => "$CONFIG{'libpath'}/forms_search.pm",
	'gallery.language'                => "$CONFIG{'libpath'}/gallery.language",
	'gallery_multi.pm'                => "$CONFIG{'libpath'}/gallery_multi.pm",
	'gallery_reports.pm'              => "$CONFIG{'libpath'}/gallery_reports.pm",
	'inserts.pm'                      => "$CONFIG{'libpath'}/inserts.pm",
	'postcards.language'              => "$CONFIG{'libpath'}/postcards.language",
	'links_lib.pm'                    => "$CONFIG{'libpath'}/links_lib.pm",
	'my.pm'                           => "$CONFIG{'libpath'}/my.pm",
	'plugins.pm'                      => "$CONFIG{'libpath'}/plugins.pm",
	'postcard_spider.pm'              => "$CONFIG{'libpath'}/postcard_spider.pm",
	'postcards_colors.pm'             => "$CONFIG{'libpath'}/postcards_colors.pm",
	'postcards_pictures.pm'           => "$CONFIG{'libpath'}/postcards_pictures.pm",
	'quiz.pm'                         => "$CONFIG{'libpath'}/quiz.pm",
	'generator.pm'                    => "$CONFIG{'libpath'}/generator.pm",
	'generator_sql.pm'                => "$CONFIG{'libpath'}/generator_sql.pm",

	'user.pm'                         => "$CONFIG{'libpath'}/user.pm",
	'usermysql.pm'                    => "$CONFIG{'libpath'}/usermysql.pm",
	'imagesize.pm'                    => "$CONFIG{'libpath'}/imagesize.pm",

	'admaster.pm'                     => "$CONFIG{'libpath'}/admaster.pm",
	'adm_dbm.pm'                      => "$CONFIG{'libpath'}/adm_dbm.pm",
	'adm_admindbm.pm'                 => "$CONFIG{'libpath'}/adm_admindbm.pm",

	'autoemail_data'                  => "$CONFIG{'data_dir'}/autoemail",
	'cforums_data'                    => "$CONFIG{'data_dir'}/cforums",
	'clubs_data'                      => "$CONFIG{'data_dir'}/clubs",
	'quiz_data'                       => "$CONFIG{'data_dir'}/quizzes",
	'generator_data'                  => "$CONFIG{'data_dir'}/generator",
	'community_data'                  => "$CONFIG{'data_dir'}/community",
	'dictionary'                      => "$CONFIG{'data_dir'}/dictionary",
	'gallery_data'                    => "$CONFIG{'data_dir'}/gallery",
	'mail_data'                       => "$CONFIG{'data_dir'}/mail",
	'autohome_data'                   => "$CONFIG{'data_dir'}/mystuff",
	'ecard_data'                      => "$CONFIG{'data_dir'}/postcards",
	'template_data'                   => "$CONFIG{'data_dir'}/templates",
	'memberindex'                     => "$CONFIG{'data_dir'}/memberindex",
	'source_templates'                => "$CONFIG{'data_dir'}/source",
	'admaster_data'                   => "$CONFIG{'data_dir'}/admaster",
	'counter_data'                    => "$CONFIG{'data_dir'}/counters",
	'userpath'                        => "$CONFIG{'data_dir'}/users",
	'userdirs'                        => "$CONFIG{'data_dir'}/users/userdirs",
	'plugins'                         => "$CONFIG{'libpath'}/plugins",
	'cm'                              => "$CONFIG{'libpath'}/cm",
	'locks'                           => "./locks"
);

%GUrl = (
	'javachat.cgi'                    => "$SERVER{'java'}$CONFIG{'CGI_DIR'}/javachat.cgi",

	'help.cgi'                        => "$SERVER{'java'}$CONFIG{'CGI_DIR'}/help.cgi",
	'register.cgi'                    => "$SERVER{'java'}$CONFIG{'CGI_DIR'}/register.cgi",

	'profile.cgi'                     => "$SERVER{'user'}$CONFIG{'CGI_DIR'}/profile.cgi",
	'icons.cgi'                       => "$SERVER{'user'}$CONFIG{'CGI_DIR'}/icons.cgi",
	'memberemail.cgi'                 => "$SERVER{'user'}$CONFIG{'CGI_DIR'}/memberemail.cgi",
	'moreinfo.cgi'                    => "$SERVER{'user'}$CONFIG{'CGI_DIR'}/moreinfo.cgi",
	'update_profile.cgi'              => "$SERVER{'user'}$CONFIG{'CGI_DIR'}/update_profile.cgi",
	'upgrade.cgi'                     => "$SERVER{'user'}$CONFIG{'CGI_DIR'}/upgrade.cgi",
	'upload_icons.cgi'                => "$SERVER{'user'}$CONFIG{'CGI_DIR'}/upload_icons.cgi",
	'users_utilities.cgi'             => "$SERVER{'user'}$CONFIG{'CGI_DIR'}/users_utilities.cgi",
	'cmail.cgi'                       => "$SERVER{'user'}$CONFIG{'CGI_DIR'}/cmail.cgi",

	'cmail_admin.cgi'                 => "$SERVER{'admin'}$CONFIG{'CGI_DIR'}/cmail_admin.cgi",
	'community_admin.cgi'             => "$SERVER{'admin'}$CONFIG{'CGI_DIR'}/community_admin.cgi",
	'postcards_admin.cgi'             => "$SERVER{'admin'}$CONFIG{'CGI_DIR'}/postcards_admin.cgi",
	'eadmin.cgi'                      => "$SERVER{'admin'}$CONFIG{'CGI_DIR'}/eadmin.cgi",
	'getip.cgi'                       => "$SERVER{'admin'}$CONFIG{'CGI_DIR'}/getip.cgi",
	'cf_admin.cgi'                    => "$SERVER{'admin'}$CONFIG{'CGI_DIR'}/cf_admin.cgi",

	'adm_admin.cgi'                   => "$SERVER{'admin'}$CONFIG{'CGI_DIR'}/adm_admin.cgi",
	'adm_click.cgi'                   => "$SERVER{'admin'}$CONFIG{'CGI_DIR'}/adm_click.cgi",
	'adm.cgi'                         => "$CONFIG{'CGI_DIR'}/adm.cgi",
	'adms.cgi'                        => "$SERVER{'admin'}$CONFIG{'CGI_DIR'}/adms.cgi",
	'admreport.cgi'                   => "$SERVER{'admin'}$CONFIG{'CGI_DIR'}/admreport.cgi",

	'cf_join.cgi'                     => "$SERVER{'cf'}$CONFIG{'CGI_DIR'}/cf_join.cgi",
	'cf_moderators.cgi'               => "$SERVER{'cf'}$CONFIG{'CGI_DIR'}/cf_moderators.cgi",
	'cf_utils.cgi'                    => "$SERVER{'cf'}$CONFIG{'CGI_DIR'}/cf_utils.cgi",
	'cforum.cgi'                      => "$SERVER{'cf'}$CONFIG{'CGI_DIR'}/cforum.cgi",
	'club_gallery.cgi'                => "$SERVER{'cf'}$CONFIG{'CGI_DIR'}/club_gallery.cgi",
	'club_links.cgi'                  => "$SERVER{'cf'}$CONFIG{'CGI_DIR'}/club_links.cgi",
	'club_news.cgi'                   => "$SERVER{'cf'}$CONFIG{'CGI_DIR'}/club_news.cgi",
	'club_upload_icon.cgi'            => "$SERVER{'cf'}$CONFIG{'CGI_DIR'}/club_upload_icon.cgi",
	'clubs.cgi'                       => "$SERVER{'cf'}$CONFIG{'CGI_DIR'}/clubs.cgi",
	'forumpoll.cgi'                   => "$SERVER{'cf'}$CONFIG{'CGI_DIR'}/forumpoll.cgi",
	'referitemail.cgi'                => "$SERVER{'cf'}$CONFIG{'CGI_DIR'}/referitemail.cgi",

	'my_content.cgi'                  => "$SERVER{'autohome'}$CONFIG{'CGI_DIR'}/my_content.cgi",
	'my_admin.cgi'                    => "$SERVER{'autohome'}$CONFIG{'CGI_DIR'}/my_admin.cgi",
	'my_newsfeed.cgi'                 => "$SERVER{'autohome'}$CONFIG{'CGI_DIR'}/my_newsfeed.cgi",
	'myaddressbook.cgi'               => "$SERVER{'autohome'}$CONFIG{'CGI_DIR'}/myaddressbook.cgi",
	'myforum.cgi'                     => "$SERVER{'autohome'}$CONFIG{'CGI_DIR'}/myforum.cgi",
	'myhome.cgi'                      => "$SERVER{'autohome'}$CONFIG{'CGI_DIR'}/myhome.cgi",
	'myhyperseek.cgi'                 => "$SERVER{'autohome'}$CONFIG{'CGI_DIR'}/myhyperseek.cgi",
	'mythreads.cgi'                   => "$SERVER{'autohome'}$CONFIG{'CGI_DIR'}/mythreads.cgi",
	'mylinks.cgi'                     => "$SERVER{'autohome'}$CONFIG{'CGI_DIR'}/mylinks.cgi",
	'mynews.cgi'                      => "$SERVER{'autohome'}$CONFIG{'CGI_DIR'}/mynews.cgi",
	'myoftheday.cgi'                  => "$SERVER{'autohome'}$CONFIG{'CGI_DIR'}/myoftheday.cgi",
	'myphoto.cgi'                     => "$SERVER{'autohome'}$CONFIG{'CGI_DIR'}/myphoto.cgi",
	'myreminder.cgi'                  => "$SERVER{'autohome'}$CONFIG{'CGI_DIR'}/myreminder.cgi",
	'mysendreminders.cgi'             => "$SERVER{'autohome'}$CONFIG{'CGI_DIR'}/mysendreminders.cgi",
	'mytodo.cgi'                      => "$SERVER{'autohome'}$CONFIG{'CGI_DIR'}/mytodo.cgi",

	'massspider.cgi'                  => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/massspider.cgi",
	'find.cgi_ssi'                    => "$CONFIG{'CGI_DIR'}/find.cgi",
	'find.cgi'                        => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/find.cgi",
	'imageeditor.cgi'                 => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/imageeditor.cgi",
	'filemanager.cgi'                 => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/filemanager.cgi",
	'massupload.cgi'                  => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/massupload.cgi",
	'frameit.cgi'                     => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/frameit.cgi",
	'linkchecker.cgi'                 => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/linkchecker.cgi",
	'spellchecker.cgi'                => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/spellchecker.cgi",
	'add.cgi'                         => "$CONFIG{'CGI_DIR'}/add.cgi",
	'backup_site.cgi'                 => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/backup_site.cgi",
	'cleanup.cgi'                     => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/cleanup.cgi",
	'community.cgi'                   => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/community.cgi",
	'count.cgi'                       => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/count.cgi",
	'count_ssi.cgi'                   => "$CONFIG{'CGI_DIR'}/count_ssi.cgi",
	'editor.cgi'                      => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/editor.cgi",
	'editor_fetch.cgi'                => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/editor_fetch.cgi",
	'form2email.cgi'                  => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/form2email.cgi",
	'frame.cgi'                       => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/frame.cgi",
	'free4all.cgi'                    => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/free4all.cgi",
	'gallery.cgi'                     => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/gallery.cgi",
	'gallery_admin.cgi'               => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/gallery_admin.cgi",
	'guestbook.cgi'                   => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/guestbook.cgi",
	'image_fetch.cgi'                 => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/image_fetch.cgi",
	'insertname.cgi'                  => "$CONFIG{'CGI_DIR'}/insertname.cgi",
	'links.cgi'                       => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/links.cgi",
	'links_admin.cgi'                 => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/links_admin.cgi",
	'log.cgi'                         => "$CONFIG{'CGI_DIR'}/log.cgi",
	'multisubmit.cgi'                 => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/multisubmit.cgi",
	'quiz.cgi'                        => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/quiz.cgi",
	'generator.cgi'                   => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/generator.cgi",
	'popup.cgi'                       => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/popup.cgi",
	'readlog.cgi'                     => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/readlog.cgi",
	'removef4aentry.cgi'              => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/removef4aentry.cgi",
	'removegbentry.cgi'               => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/removegbentry.cgi",
	'search.cgi'                      => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/search.cgi",
	'set_counter.cgi'                 => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/set_counter.cgi",
	'test_html.cgi'                   => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/test_html.cgi",
	'upload.cgi'                      => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/upload.cgi",
	'usr_vote.cgi'                    => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/usr_vote.cgi",
	'wwwadmin.cgi'                    => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/wwwadmin.cgi",
	'wwwboard.cgi'                    => "$SERVER{'weaver'}$CONFIG{'CGI_DIR'}/wwwboard.cgi",

	'pg_import.cgi'                   => "$SERVER{'gallery'}$CONFIG{'CGI_DIR'}/pg_import.cgi",
	'photogallery.cgi'                => "$SERVER{'gallery'}$CONFIG{'CGI_DIR'}/$CONFIG{'GALLERY_script_name'}",
	'show.cgi'                        => "$SERVER{'gallery'}$CONFIG{'CGI_DIR'}/show.cgi",

	'postcards.cgi'                   => "$SERVER{'postcards'}$CONFIG{'CGI_DIR'}/$CONFIG{'POSTCARD_script_name'}",
	'savecard.cgi'                    => "$SERVER{'postcards'}$CONFIG{'CGI_DIR'}/savecard.cgi",
	'viewcard.cgi'                    => "$SERVER{'postcards'}$CONFIG{'CGI_DIR'}/viewcard.cgi",

	'aecheckpop3.cgi'                 => "$SERVER{'autoemail'}$CONFIG{'CGI_DIR'}/aecheckpop3.cgi",
	'autoemail.cgi'                   => "$SERVER{'autoemail'}$CONFIG{'CGI_DIR'}/autoemail.cgi",
	'aeuploadattachment.cgi'          => "$SERVER{'autoemail'}$CONFIG{'CGI_DIR'}/aeuploadattachment.cgi",
	'autoemail_admin.cgi'             => "$SERVER{'autoemail'}$CONFIG{'CGI_DIR'}/autoemail_admin.cgi",
	'counter_base'                    => "$CONFIG{'button_dir'}/counters",
	'myphoto_base'                    => "$SERVER{'user'}$CONFIG{'button_dir'}/myphoto",
	'postcard_images'                 => "$SERVER{'user'}$CONFIG{'button_dir'}/postcardimages",  #must be on the same server as postcards.cgi
	'postcard_java'                   => "$SERVER{'user'}$CONFIG{'button_dir'}/java",            #must be on the same server as postcards.cgi
	'template_images'                 => "$SERVER{'user'}$CONFIG{'button_dir'}/templates",
	'zodiac_images'                   => "$SERVER{'user'}$CONFIG{'button_dir'}/zodiac",
	'icon_images'                     => "$SERVER{'user'}$CONFIG{'button_dir'}/tokens",
	'background_images'               => "$SERVER{'user'}$CONFIG{'button_dir'}/backgrounds"
);

require "$GPath{'imagesize.pm'}";


        
# Plugin Library Files, where to find the corresponding subroutines
%pluginlibs = (
	WEBADVERTS                        => 'advertising',
	FLYCAST                           => 'advertising',
	LINKEXCHANGE                      => 'advertising',
	AMAZON                            => 'advertising',
	RANDOMIMAGE                       => 'gallery',
	HELLO                             => 'user',
	TEXT                              => 'general',
	HYPERSEEKSEARCH                   => 'general',
	FINDSEARCH                        => 'memberindex',
	CENTRALAND                        => 'advertising',
	LOGIN                             => 'user',
	REGISTER                          => 'user',
	LOGOUT                            => 'user',
	RANDOMTEXT                        => 'general',
	NUMBERMEMBERS                     => 'user',
	PAGEVIEWS                         => 'general',
	
	
	GENERATORTITLENAME                => 'general',
	GENERATORRELEASEYEAR              => 'general',
	GENERATORMPAARATING               => 'general',
	GENERATORREVIEW                   => 'general',
	GENERATORBIOGRAPHY                => 'general',
	GENERATORNAME                     => 'general',
	GENERATORIMAGES                   => 'general',
	GENERATORRELATEDLINKS             => 'general',
	GENERATORMOVIESBYYEAR             => 'general',
	GENERATORBIOGRAPHY                => 'general',
	GENERATORACTORNAME                => 'general',
	GENERATORBIOGRAPHYMOVIES          => 'general',
	GENERATORMOVIEABRCOMMENTS         => 'general',
	GENERATORMOVIECOMMENTS            => 'general',
	GENERATORACTORABRCOMMENTS         => 'general',
	GENERATORACTORCOMMENTS            => 'general',


	QUIZOPEN                          => 'general',
	QUIZQUESTION                      => 'general',
	QUIZMESSAGE                       => 'general',
	QUIZSUBMIT                        => 'general',
	QUIZOPTIONS                       => 'general',
	QUIZCLOSE                         => 'general',
	QUIZPREVIOUSRESPONSE              => 'general',
	QUIZSCORE                         => 'general',
	QUIZQUESTIONNUMBER                => 'general',
	QUIZNUMBEROFQUESTIONS             => 'general',
	QUIZTITLE                         => 'general',
	QUIZCLOSINGINFO                   => 'general',
	QUIZOUTOF                         => 'general',
	QUIZQUESTIONSUMMARY               => 'general',
      QUIZFINALSUMMARY                  => 'general',




	DATE                              => 'general',
	SHORTDATE                         => 'general',
	USDATE                            => 'general',
	REFERER                           => 'general',
	BANNER                            => 'general',
	CONTROL_PANEL                     => 'cforum',
	USERNAME                          => 'user',
	BODY                              => 'general',
	CHATROOM                          => 'chat',
	MOREINFO                          => 'user',
	USEREMAIL                         => 'user',
	USERNAME                          => 'user',
	POPUP                             => 'user',
	ZIPCODE                           => 'user',
	COUNTRY                           => 'user',
	PHONENUMBER                       => 'user',
	FAXNUMBER                         => 'user',
	ADDRESS                           => 'user',
	STATE                             => 'user',
	COUNTRY                           => 'user',
	CITY                              => 'user',
	ICQ                               => 'user',
	PICKUP                            => 'postcard',
	SAVECARD                          => 'postcard',
	SENDANOTHER                       => 'postcard',
	BACKTOPOSTOFFICE                  => 'postcard',
	GALLERYLOCATION                   => 'gallery',
	DIRECTORIES                       => 'gallery',
	IMAGES                            => 'gallery',
	GALERYRATEIT                      => 'gallery',
	GALERYSIZE                        => 'gallery',
	GALERYDATE                        => 'gallery',
	GALERYHITS                        => 'gallery',
	USERDESCRIPTION                   => 'user',
	USERCOMMUNITY                     => 'user',
	HANDLE                            => 'user',
	USERREALNAME                      => 'user',
	FIRSTNAME                         => 'user',
	LASTNAME                          => 'user',
	MIDDLENAME                        => 'user',
	BIRTH                             => 'user',
	FILLER1                           => 'user',
	FILLER2                           => 'user',
	FILLER3                           => 'user',
	FILLER4                           => 'user',
	FILLER5                           => 'user',
	FILLER6                           => 'user',
	FILLER7                           => 'user',
	FILLER8                           => 'user',
	FILLER9                           => 'user',
	FILLER10                          => 'user',
	PASSWORD                          => 'user',
	COMMUNITYNAME                     => 'user',
	MODERATORNAME                     => 'cforum',
	FORUMNAME                         => 'cforum',
	SCREENNAME                        => 'user',
	ICON                              => 'user',
	_BUTTONDIR                        => 'general',
	_AUTOGALLERY                      => 'general',
	_VIEWCARDS                        => 'general',
	_WEBPAGEEDITOR                    => 'general',
	_WEBPAGE                          => 'general',
	_PROFILE                          => 'general',
	_POSTCARDS                        => 'general',
	_REGISTER                         => 'general',
	_CONTACTINFORMATION               => 'general',
	_MYREMINDERS                      => 'general',
	_MYHOME                           => 'general',

	TELEVISIONJOKES                   => 'dailycontent',
	GENERALJOKES                      => 'dailycontent',
	LOVELIFEJOKES                     => 'dailycontent',
	SCIENCEPOLITICSJOKES              => 'dailycontent',
	TRIVIA                            => 'dailycontent',
	BORNONTHISDAY                     => 'dailycontent',
	COMPUTERNERDS                     => 'dailycontent',
	MOVIEQUOTES                       => 'dailycontent',

	MYPHOTO                           => 'autohome',
	MYCUSTOM1                         => 'autohome',
	MYCUSTOM2                         => 'autohome',
	MYCUSTOM3                         => 'autohome',
	MYCUSTOM4                         => 'autohome',
	MYCUSTOM5                         => 'autohome',
	MYFORUMS                          => 'autohome',
	MYADDRESSBOOK                     => 'autohome',
	MYNEWS                            => 'autohome',
	MYHYPERSEEK                       => 'autohome',
	MYTODO                            => 'autohome',
	MYHOROSCOPE                       => 'autohome',
	MYCLOSED                          => 'autohome',
	MYLINKS                           => 'autohome',
	MYOFTHEDAY                        => 'autohome',
	MYTHREADS                         => 'autohome',
	CUSTOM                            => 'custom'
);

if (-e "autoemail.cgi") {
	$PRESENT{'autoemail.cgi'} = 1;
}
if (-e "myhome.cgi") {
	$PRESENT{'myhome.cgi'} = 1;
}

########

# Are we running Multi-Server Or Regular Strength, get the right libraries
if ($COMMUNITY_Database eq "MySQL") {
	if (-e "$GPath{'usermysql.pm'}") {
		require "$GPath{'usermysql.pm'}";
	}
	require "$GPath{'iomysql.pm'}";
}
else {
	if ((-e "$GPath{'user.pm'}") && ($userpm)) {
		require "$GPath{'user.pm'}";
	}
	require "$GPath{'ioascii.pm'}";
}
########



sub print_output {
	my ($template, $body, @ttemplate) = @_;

	my ($fn, @template) = (undef, undef);

	if ($template !~ /^NONE/) {
		($fn, @template) = &io_get_template ($template);
	}
	else {
		$fn = "NONE";
		@template = @ttemplate;
	}

	$BODY .= " <SCRIPT LANGUAGE=\"javascript\">\n";
	$BODY .= " <!--\n";
	$BODY .= " function OpenHelpWin(Loc) {\n";
	$BODY .= " 	wHelpWindow=window.open(Loc,\"wHelpWindow\",\"toolbar=no,scrollbars=yes,directories=no,resizable=yes,menubar=no,width=400,height=300\");\n";
	$BODY .= "  wHelpWindow.focus();\n";
	$BODY .= " 	   }\n";
	$BODY .= " 	// -->\n";
	$BODY .= " 	</SCRIPT>\n";

	$Group = $IUSER{'community'};
	$OUT = "";
	foreach $line (@template) {
		$OUT = "";
		&parse_iweb_plugins($body);
		$OUTPUT .= $line;
	}
	if (($IUSER{'username'} ne "") && ($IUSER{'password'} ne "") && ($PROGRAM_NAME ne "register.cgi") && ($PROGRAM_NAME ne "email.cgi") && ($CONFIG{'COMMUNITY_cookie_user'} eq "YES")) {
		&set_member_cookie;
	}
	else {
		print "Content-type: text/html\n\n";
	}
	print "$OUTPUT\n";

#	$PELAPSEDTIME = gettimeofday-$PSTART;
	print "<!--";
	print "Low-level template: $LOWLEVELTEMPLATE\n";
	print "Low-level errors: $Text::Template::ERROR\n";
	print "High-level template called: $template\n";
	print "High-level template returned: $fn\n";
	print "Running time: $PELAPSEDTIME\n";
	print ">";
	if ($no_exit ne "T") {
		exit;
	}
}

sub Page_Header {
	&print_output($_[0],"run");
}

sub parse_iweb_plugins {
	my ($return, $orgtext, $PLUGIN, $SubPLUGIN) = (undef, undef, undef, undef);

	if ($line =~ /PLUGIN:([a-zA-Z_0-9:|]+)[^a-zA-Z_0-9]/) {
		$orgtext = $1;
		($PLUGIN, $SubPLUGIN) = split(/[:|]/, $orgtext);
		$PLUGIN =~ s/\W//g;
		if (($PLUGIN =~ /\w/) && ($PLUGIN ne "")) {
			$SubPLUGIN =~ s/\W//g;
			if ($pluginlibs{$PLUGIN} =~ /\w/) {
				require "./plugins/$pluginlibs{$PLUGIN}.pm";
				if ($PLUGIN eq "CUSTOM") {
					if ($SubPLUGIN ne "") {
						$return = &$SubPLUGIN;
					}
				}
				else {
					if ($PLUGIN eq "BODY") {
						$SubPLUGIN = $_[0];
					}
					$return = &$PLUGIN($SubPLUGIN);
				}
				$line =~ s/PLUGIN:$orgtext/$return/;
			}
		}
	}
}


sub show_head_insert {
	$head_insert .="\n";
}

sub show_foot_insert {
	$foot_insert .="\n";
}

############################################


sub urlencode {
	my($toencode) = shift;
	$toencode =~ s/([^a-zA-Z0-9_\-.])/uc sprintf("%%%02x",ord($1))/eg;
	return $toencode;
}

sub unencode {
	my ($unencode) = shift;
	$unencode =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	return $unencode;
}

# Search for the lockfile and block until it dissapears
sub lock {

        my $PROG_NAME = $0;

        my ($t) = $_[0] || $PROG_NAME;

        my $MAX_SLEEP = 30;
        my $LOCK_LOCATION = $GPath{'locks'};
        my $time = time;


        my @FULL_PATH = split("/", $t);
        my $LOCK_NAME = pop(@FULL_PATH);
        my $LOCK_PATH = "$LOCK_LOCATION/$LOCK_NAME.lck";

        open(LCK,$LOCK_PATH);
          my $opened = <LCK>;
        close(LCK);

        
        my $how_long = $time-$opened;

        ## Unless the lock file is a minute old...##
        if ($how_long <= 60) {
		my $SLEEP_COUNT = undef;
		while (-e "$LOCK_PATH" || $how_long >= 60) {
			$SLEEP_COUNT++;
			sleep 1;
			if ($SLEEP_COUNT == $MAX_SLEEP) {
				$! = "Persistent lock file $LOCK_PATH exists.";
				return 0;
			}
		}
        }

        open (LOCK, "> $LOCK_PATH") || return 0;
        print LOCK $time;
        close (LOCK);
        1;
}

# Kill the lock file
sub unlock {
        my $PROG_NAME = $0;

        my($t) = $_[0] || $PROG_NAME;

        my $MAX_SLEEP = 15;
        my $LOCK_LOCATION = $GPath{'locks'};
        my $PID = $$;

        my @FULL_PATH = split("/", $t);
        my $LOCK_NAME = pop(@FULL_PATH);
        my $LOCK_PATH = "$LOCK_LOCATION/$LOCK_NAME.lck";

        return (unlink $LOCK_PATH);
}



sub Not_Valid_Email {
	my $email_address_to_check = $_[0];

	if ($email_address_to_check =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)|(\.$)/ || 
		($email_address_to_check !~ /^.+\@localhost$/ && 
		$email_address_to_check !~ /^.+\@\[?(\w|[-.])+\.[a-zA-Z]{2,3}|[0-9]{1,3}\]?$/)) {
		return(1);
	}

	else {
		return undef;
	}
}


sub Not_Valid_URL {
	my($url_to_check) = $_[0];

	if ($url_to_check !~ 'http://' || $url_to_check !~ /^(f|ht)tp:\/\/\S+\.\S+/) { return(1); }
	else { return undef; }
}


sub Remove_HTML_Tags {
	my($string_to_modify) = $_[0];
	$string_to_modify =~ s/<[^>]+>//ig;
	return($string_to_modify);
}


sub WordWrap {
	my $quotedtext = $_[0];
	my $returntext = "";
	my $length = length($quotedtext)-1;
	my $wrapcount = 0;
	foreach $key (0..$length) {
		my $char = substr($quotedtext,$key,1);
		$wrapcount++;
		if (($wrapcount > 70) && ($char eq " ")) {
			$char = "\n";
		}
		$returntext = $returntext.$char;
		if ($char =~ /\n/) {
			$wrapcount = 0;
		}
	}
	return $returntext;
}


sub parse_FORM {
	$buffer = undef;
	read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
	if (length($buffer) < 5) {
		$buffer = $ENV{QUERY_STRING};
	}
	my @pairs = split(/&/, $buffer);

	my $text2check = undef;
	my $rn = time;
	foreach $pair (@pairs) {
		my ($name, $value) = split(/=/, $pair);

		# Un-Webify plus signs and %-encoding
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		if ($0 !~ /admin/) {  #Let's assume that the admin knows what it's doing
			if ($value =~ /(exec cmd|exec cgi|include virtual)/i) {
				&io_flag_activity($rn, $ENV{'REMOTE_ADDR'}, $FORM{'UserName'}, "Serverside Include Attempted", $PROGRAM_NAME);
			}
			$value =~ s/exec cmd/ /ig;
			$value =~ s/exec cgi/ /ig;
			$value =~ s/include virtual/ /ig;
		}
		if (defined $FORM{$name}) {
			if (! $FORM2{$name}) {
				$FORM2{$name} = $FORM{$name} . " " . $value;
			}
			else {
				$FORM2{$name} .= " " . $value;
			}
		}
		$FORM{$name} = $value;
		if ($FORM{$name} eq "NA") {$FORM{$name} = "";}
		$text2check .= " " . $value;
	}
	if ($0 !~ /admin/) {  #Let's assume that the admin knows what it's doing
		if (($CONFIG{'COMMUNITY_monitor_Words'} eq "YES") && ($FORM{'badwords_override'} ne "T")) { 
			my $badwords = &Check_For_Bad_Words($text2check, "flagged"); 
			if ($badwords ne "") {
				$Bad_Words_Message =~ s/(\n|\cM)/ /g;
				&io_flag_activity($rn, $ENV{'REMOTE_ADDR'}, $FORM{'UserName'}, $Bad_Words_Message, $PROGRAM_NAME);
			}
		}
     		if (($CONFIG{'COMMUNITY_monitor_Words'} eq "YES") && ($FORM{'badwords_override'} ne "T"))  {
			my $badwords = &Check_For_Bad_Words($text2check, "bad");
	 		if ($badwords ne "") {
				print "Location: $CONFIG{'COMMUNITY_bad_words'}\n\n";
				exit 0;
			}
		}
	}

	$FORM{'UserName'} =~ tr/A-Z/a-z/;
	$FORM{'PassWord'} =~ tr/A-Z/a-z/;
}


############################################


sub diehtml {
	my ($Message) = $_[0];
   	print "Content-type: text/html\n\n";
	print "Nasty internal error.\n\n";
	print "$Message\n\n";
	warn("$Message");
	exit;
}



sub Spelling_Errors  {
	## Paramaters: String to check, path to dictionary ( no trailing slash )
	## This returns "1 or True if there are spelling errors...
	## And always returns $Spelling_Error_Message Global Variable which contains
	## informative text about the spelling errors, warnings, and status.
	## Example:  if ( &Spelling_Errors($text_string,"./data/dictionary") ) { &ERROR("$Spelling_Error_Message"); }

	my($d) = $_[0];
	my($dictionary) = $_[1];

	$d=~tr/A-Z/a-z/;
	$d=~tr/a-z/ /cs;
	while (substr($d,0,1) eq " "){$d=substr($d,1);} #trash leading spaces
	@f=split(/ /, $d); #split entire input string into array
	@f=sort(@f);       #sort damn you

	SORTER: 
	while($w=shift(@f)) {
		$pt++;
		if ($w eq $l){next;} #lose dupes
		$l=$w; 
		if (substr($w,0,1) ne $f) {
			undef($c);
			open (FILE, "$dictionary/".substr($w,0,1))|| &ERROR("couldn't open $w\n");
			$f = substr($w,0,1);
			while (<FILE>) {
				$c=$_;
				last;
			}
		}

		if (length($w)<3){$pp++;push(@p,$w);next SORTER;} #ignore short words, but remember what they were
		if ($c=~/\b$w\b/){$pm++;push(@m,$w);next SORTER;} 
		if (substr($w,-1,1) eq "s") {
			if ($c=~/\b$w?\b/) {
				$pq++;push(@q,$w);next SORTER;
			}
		}

		$pn++;
		push(@n,$w);
	}

	foreach $n(@n) {
		$message=~s/\b$n\b/<BLINK>$n<\/BLINK>/gi;
		$spelledtopic=~s/$n/<BLINK>$n<\/BLINK>/gi;
		$rl="<BR><CENTER>$rl | $n ";
	}

	foreach $n(@q) {
		$message=~s/$n/<BLINK>$n<\/BLINK>/gi;
		$spelledtopic=~s/$n/<BLINK>$n<\/BLINK>/gi;
	}

	$Spelling_Error_Message = "";
	$spelling_errors = 0;

	if (scalar(@n)==1) #single word not found in dictionary
	{ 
		$Spelling_Error_Message .= "<BR><B>This word isn't in our dictionary:<\/B> $rl \|</CENTER><BR>"; 
		$spelling_errors = 1;
	}

	elsif (scalar(@n)>0) #sevaral words not found in dictionary
	{ 
		$Spelling_Error_Message .= "<BR><B>These $pn words weren\'t in our dictionary:<\/B> $rl \|</CENTER><BR>"; 
		$spelling_errors = 1;  
	}

	else #all is good
	{ 
		$Spelling_Error_Message = "<BR><B>Our Spell Check indicates that all is good,<\/B> But double check your entry anyway.<BR>"; 
	}

	if (scalar(@q)==1) 
	{ 
		$Spelling_Error_Message .= "<BR><B>This word isn't in our dictionary, but is probably a plural:<\/B>".join(" ",@q); 
		$spelling_errors = 1;  
	}

	elsif (scalar(@q)>0) 
	{ 
		$Spelling_Error_Message .= "<BR><B>These words weren't in our dictionary, but are probably plurals:<\/B>".join(" ",@q); 
		$spelling_errors = 1;  
	}

	return $spelling_errors;
}

$myauthor = "pickup22\@yahoo.com";

sub Check_For_Bad_Words {
	my($d) = $_[0];
	my($bw_file) = $_[1];
	my($w,$l,@f,@bad,$bw_exist,$Bad_Words_Message) = (undef, undef, undef, undef, undef, undef);

	$d=~tr/A-Z/a-z/;
	$d=~tr/a-z/ /cs;
	while (substr($d,0,1) eq " "){$d=substr($d,1);} #trash leading spaces
	@f=split(/ /, $d); 
	@f=sort(@f);      

	my @list = &io_get_list($bw_file);

	foreach my $this_bad_word (@list) {
		$this_bad_word =~ s/\n//g;
		$this_bad_word =~ s/\cM//g;

		for $w( 0 .. $#f ) {
			$l=$f[$w]; 
			$l =~ s/\n//g;
			$l =~ s/\cM//g;
			if ($this_bad_word eq $l) { 
				push @bad,$l; 
				$bw_exist = 1;
			}
		}
	}


	@bad=sort(@bad);
	$l = "";

	for $z ( 0 .. $#bad ) { 
		if($bad[$z] ne $l) {
			$Bad_Words_Message .= "$bad[$z], "; 
		}
		$l = $bad[$z];
	}

	return $Bad_Words_Message;
}


sub allowedtype {
	my ($file, $ft) = @_;

	my @types = split(/,/, $ft);
	$file =~ s/.*\.//g;
	my $found = undef;

	foreach $t (@types) {
		$t =~ s/\W//g;
		if ($file =~ /^$t$/i) {
			$found = "TRUE";
			last;
		}
	}

	return $found;
}


sub GetCookies {
	my @Cookie_Decode_Chars = ('\+', '\%3A\%3A', '\%26', '\%3D', '\%2C', '\%3B', '\%2B', '\%25');
	my %Cookie_Decode_Chars = ('\+', ' ', '\%3A\%3A', '::', '\%26', '&', '\%3D', '=', '\%2C', '\,', '\%3B', ';', '\%2B', '+', '\%25', '%');

	my(@ReturnCookies) = @_;
	my($cookie_flag) = 0;
	my($cookie,$value);
	my(%Cookies) = undef;

	if ($ENV{'HTTP_COOKIE'}) {
		if ($ReturnCookies[0] ne '') {
			foreach (split(/; /,$ENV{'HTTP_COOKIE'})) {
				($cookie,$value) = split(/=/);
				foreach my $char (@Cookie_Decode_Chars) {
					$cookie =~ s/$char/$Cookie_Decode_Chars{$char}/g;
					$value =~ s/$char/$Cookie_Decode_Chars{$char}/g;
				}
				foreach $ReturnCookie (@ReturnCookies) {
					if ($ReturnCookie eq $cookie) {
						$Cookies{$cookie} = $value;
						$cookie_flag = "1";
					}
				}
			}
		}
		else {
			foreach (split(/; /,$ENV{'HTTP_COOKIE'})) {
				($cookie,$value) = split(/=/);
				foreach my $char (@Cookie_Decode_Chars) {
					$cookie =~ s/$char/$Cookie_Decode_Chars{$char}/g;
					$value =~ s/$char/$Cookie_Decode_Chars{$char}/g;
				}
				$Cookies{$cookie} = $value;

			}
			$cookie_flag = 1;
		}
	}
	return $cookie_flag, %Cookies;
}



sub SetCookies {
	my $Cookie_Path = '/';
	my $Cookie_Exp_Date = 'Wed, 31-Dec-2030 00:00:00 GMT';
	my @Cookie_Encode_Chars = ('\%', '\+', '\;', '\,', '\=', '\&', '\:\:', '\s');
	my %Cookie_Encode_Chars = ('\%', '%25', '\+', '%2B', '\;', '%3B', '\,', '%2C', '\=', '%3D', '\&', '%26', '\:\:', '%3A%3A', '\s',   '+');

	my(@cookies) = @_;
	my($cookie,$value,$char);
	while( ($cookie,$value) = @cookies ) {
		foreach my $char (@Cookie_Encode_Chars) {
			$cookie =~ s/$char/$Cookie_Encode_Chars{$char}/g;
			$value =~ s/$char/$Cookie_Encode_Chars{$char}/g;
		}
		print 'Set-Cookie: ' . $cookie . '=' . $value . ';';
		if ($Cookie_Exp_Date) {
			print ' expires=' . $Cookie_Exp_Date . ';';
		}

		if ($Cookie_Path) {
			print ' path=' . $Cookie_Path . ';';
		}
		print "\n";
		shift(@cookies); shift(@cookies);
	}
}





sub SetCompressedCookies {
	my @Cookie_Encode_Chars = ('\%', '\+', '\;', '\,', '\=', '\&', '\:\:', '\s');
	my %Cookie_Encode_Chars = ('\%', '%25', '\+', '%2B', '\;', '%3B', '\,', '%2C', '\=', '%3D', '\&', '%26', '\:\:', '%3A%3A', '\s',   '+');

	my($cookie_name,@cookies) = @_;
	my($cookie,$value,$cookie_value);

	while ( ($cookie,$value) = @cookies ) {
		foreach my $char (@Cookie_Encode_Chars) {
			$cookie =~ s/$char/$Cookie_Encode_Chars{$char}/g;
			$value =~ s/$char/$Cookie_Encode_Chars{$char}/g;
		}

		if ($cookie_value) {
			$cookie_value .= '&' . $cookie . '::' . $value;
		}

		else {
			$cookie_value = $cookie . '::' . $value;
		}

		shift(@cookies); shift(@cookies);
	}

	&SetCookies("$cookie_name","$cookie_value");
}

	
sub GetCompressedCookies {
	my @Cookie_Decode_Chars = ('\+', '\%3A\%3A', '\%26', '\%3D', '\%2C', '\%3B', '\%2B', '\%25');
	my %Cookie_Decode_Chars = ('\+', ' ', '\%3A\%3A', '::', '\%26', '&', '\%3D', '=', '\%2C', '\,', '\%3B', ';', '\%2B', '+', '\%25', '%');

	my($cookie_name,@ReturnCookies) = @_;
#	my($cookie_flag) = 0;
	my($ReturnCookie,$cookie,$value);

	my ($cookie_flag, %Cookies) = &GetCookies($cookie_name);
	if (defined %Cookies) {
		if ($ReturnCookies[0] ne '') {
			foreach (split(/&/,$Cookies{$cookie_name})) {
				($cookie,$value) = split(/::/);
				foreach my $char (@Cookie_Decode_Chars) {
					$cookie =~ s/$char/$Cookie_Decode_Chars{$char}/g;
					$value =~ s/$char/$Cookie_Decode_Chars{$char}/g;
				}

				foreach $ReturnCookie (@ReturnCookies) {
					if ($ReturnCookie eq $cookie) {
						$Cookies{$cookie} = $value;
						$cookie_flag = 1;
					}
				}
			}
		}

		else {
			foreach (split(/&/,$Cookies{$cookie_name})) {
				($cookie,$value) = split(/::/);
				foreach my $char (@Cookie_Decode_Chars) {
					$cookie =~ s/$char/$Cookie_Decode_Chars{$char}/g;
					$value =~ s/$char/$Cookie_Decode_Chars{$char}/g;
				}
				$Cookies{$cookie} = $value;
			}
			$cookie_flag = 1;
		}

		delete($Cookies{$cookie_name});
	}
	return %Cookies;
}



sub Long_Date {
	my ($time) = $_[0];
	my ( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst )= localtime( $time );

	$sec = "0$sec" if ($sec < 10);
	$min = "0$min" if ($min < 10);
	$hour = "0$hour" if ($hour < 10);
	$mon = "0$mon" if ($mon < 10);
	$mday = "0$mday" if ($mday < 10);
	my ( $month )= ($mon + 1);
	my ( @months )= ( "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" );

	my ( @weekday )=( "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday" );

	$year = $year + 1900;
	return "$weekday[$wday -1] $months[$month -1] $mday, $year $hour\:$min";
}


sub Short_Date {
	my ($time) = $_[0];
	my( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst )= localtime( $time );

	$sec = "0$sec" if ($sec < 10);
	$min = "0$min" if ($min < 10);
	$hour = "0$hour" if ($hour < 10);
	$mon = "0$mon" if ($mon < 10);
	$mday = "0$mday" if ($mday < 10);
	my ( $month )= ($mon + 1);
	my ( @months )= ( "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" );

	my ( @weekday )=( "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday" );

	$year = $year + 1900;
	return "$months[$month -1] $mday, $year";
}


sub US_Date {
	my ($time) = $_[0];
	my ( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst )= localtime( $time );

	$sec = "0$sec" if ($sec < 10);
	$min = "0$min" if ($min < 10);
	$hour = "0$hour" if ($hour < 10);
	$mon = "0$mon" if ($mon < 10);
	$mday = "0$mday" if ($mday < 10);
	my ( $month )= ($mon + 1);

	$year = $year + 1900;

	return "$month/$mday/$year";
}


sub ERROR {


   my ($ERROR_MESSAGE) = $_[0];

   if ( !($CONTENT) ) {
	print "Content-type: text/html\n\n";
   }

        print <<DONE;

	<HTML>
	<HEAD>
	  <TITLE>CGI Error</TITLE>
	</HEAD>
        <BODY BGCOLOR=\"white\">
        <CENTER>
        <BR><BR><BR>
        <TABLE BORDER=2 CELLSPACING=0 CELLPADDING=0 WIDTH=300>
          <TR><TD WIDTH=300> 

        <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH="100%">
          <TR><TD> 
            <TABLE BORDER=1 CELLSPACING=0 CELLPADDING=0 WIDTH="100%">
               <TR BGCOLOR="red"><TD> 
               <FONT FACE="Arial,Helvetica" COLOR="white" SIZE=+1>Unexpected Error.
            </TD><TR></TABLE>
          </TD></TR>

          <TR><TD> 
            <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH="100%"><TR BGCOLOR="silver"><TD> 
              <FONT COLOR="red">
              <BR><B>
              $ERROR_MESSAGE
              </B><BR><BR><I>
              <CENTER><A HREF="javascript:history.go(-1)">Return to Previous Screen</A></I></CENTER></FONT><BR><BR>
            </TD><TR></TABLE>

        </TD><TR></TABLE>
        </TD><TR></TABLE>
	</BODY>
	</HTML>
DONE
exit;
}


sub displaygraph {
	my $xlabel = $_[0];
	my $ylabel = $_[1];
	my $title = $_[2];
	my $name = $_[3];
	my $var = $_[4];
	my $pie = $_[5];
	my $sortby = $_[6];
	my $reverse = $_[7];
	my $hbar = $_[8];
	my $time = $_[9];

	my $data = undef;
	my $count = 0;

	if ($CONFIG{'NiceGraphs'} eq "YES") {
		my $x = 0;
		if ($sortby ne "key") {
			if (! $reverse) {
				foreach my $k(reverse sort { $$var{$a} <=> $$var{$b} } keys %$var) {
					if ($count > 50) {last;}
					$data .= "$$var{$k},";
					if ($time) {$k = &US_Date($k);}
					$data .= "$name$k|";
					$count++;
				}
			}
			else {
				foreach my $k(sort { $$var{$a} <=> $$var{$b} } keys %$var) {
					if ($count > 50) {last;}
					$data .= "$$var{$k},";
					if ($time) {$k = &US_Date($k);}
					$data .= "$name$k|";
					$count++;
				}
			}
		}
		else {
			if (! $reverse) {
				foreach my $k(reverse sort{$a <=> $b} keys %$var) {
					if ($count > 50) {last;}
					$data .= "$$var{$k},";
					if ($time) {$k = &US_Date($k);}
					$data .= "$name$k|";
					$count++;
				}
			}
			else {
				foreach my $k(sort{$a <=> $b} keys %$var) {
					if ($count > 50) {last;}
					$data .= "$$var{$k},";
					if ($time) {$k = &US_Date($k);}
					$data .= "$name$k|";
					$count++;
				}
			}
		}
		if ($data !~ /[\w\d]/) {return;}
		if ($pie) {$pie= "pie=T";}
		elsif ($hbar) {$pie= "hbar=T";}
		my $url = "$CONFIG{'GRAPH_Url'}?$pie&xlabel=" . &urlencode($xlabel) . "&ylabel=" . &urlencode($ylabel) . "&title=" . &urlencode($title) .  "&data=" . &urlencode($data);
		print "<IMG SRC=\"$url\"><P>\n";
	}
	else {
		my $count = 0;
		my $x = 0;
		my $length = 0;
		print "<H3>$title</H3>\n";
		print "<TABLE>\n";
		foreach my $k(reverse sort { $$var{$a} <=> $$var{$b} } keys %$var) {
			if ($$var{$k} > 0) {
				if ($x == 0) {
					$x = 300 / $$var{$k};
				}
				$length = $$var{$k} * $x;
			}
			$length++;
			print "<TR><TD>$k</TD><TD>$$var{$k}</TD><TD><IMG SRC=\"$CONFIG{'button_dir'}/bar.gif\" height=10 width=$length></TD></TR>\n";
			if ($count++ > 50) {last;}
		}
		print "</TABLE>\n";
	}
}

	

1;

