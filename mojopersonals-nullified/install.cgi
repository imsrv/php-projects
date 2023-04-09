#!/usr/bin/perl
############################################################
eval {
   ($0=~ m,(.*)/[^/]+,)   && unshift (@INC, "$1");
   ($0=~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1");
	unshift(@INC, "./scripts");
#	require "config.pl";
        require "english.lng";
        require "scripts/admin.pl";
	require "scripts/admin_html.pl";
	require "scripts/default_config.pl";
	require "scripts/library.pl";
	require "scripts/database.pl";
        require "scripts/new_database.pl";
	require "scripts/mojoscripts.pl";
	require "scripts/parse_template.pl";
	require "scripts/html.pl";
	require "scripts/templates.pl";
        require "scripts/serverinfo.pl";

	use CGI::Carp qw(fatalsToBrowser);
	use CGI qw(:standard);
#	use strict;
#	use vars qw(%FORM $Cgi);
	&main;
};
if($@){
	print "Content-Type:text/html\n\n";
	print qq| Error including configuration file <br>Reason: $@ |;
#	&main;
	exit;
}
############################################################
sub main{
	$|++;
	$Cgi = new CGI;$Cgi{mojoscripts_created} = 1;
	&ParseForm;
	my($admin_db, $group_db, $message);


#	if(require "config.pl"){	&CheckSession if (-f $CONFIG{admin_db});	}
##Check if you have already install the program, if yes, then ask to enter a passowrd
	if($FORM{action} eq "disable"){
		chmod(0000, "install.cgi");
		print "Location:admin.$FORM{script_ext}?action=login&username=admin&password=mojoscripts\n\n";
	}
	elsif($FORM{action} eq "delete"){
		unlink ("install.$FORM{script_ext}");
		print "Location:admin.$FORM{script_ext}?action=login&username=admin&password=mojoscripts\n\n";
	}
	if($FORM{'step'} eq "final"){
		require "config.pl";
		$anonyminit=1;
                &Initialization;
                $message = &CheckConfiguration;
                $FORM{mysql_hostname}=$CONFIG{mysql_hostname};
                $FORM{mysql_database}=$CONFIG{mysql_database};
                $FORM{mysql_username}=$CONFIG{mysql_username};
                $FORM{mysql_password}=$CONFIG{mysql_password};
		%CONFIG = %FORM;
		&LoadDefaultConfig;
		&FileWrite($CONFIG{admin_db}, "admin|admin\ndemo|demo\n");
		&FileWrite($CONFIG{group_db}, "admin|111111111111111\nmoderator|001111111111111\ndemo|000010101110111\n");
		$message .= "<li>$mj{setup46}</li>" unless (-e $CONFIG{admin_db});
		$message .= "<li>$mj{setup47}</li>" unless (-e $CONFIG{group_db});
		&PrintInstallation($message) if $message;

		$message =qq|<br>$mj{setup50}<br>|;
#		&PrintHeader; foreach (keys %FORM){	print "<br>[$_] = [$FORM{$_}]";	}
		&WriteConfig;
		require "config.pl";
                &Initialization;
                &DbInit;
                &CreateMaster("admin", "admin");
		&CreateMaster("demo", "demo");
		&CreateDefaultCats;
                &CreateDefaultAccounts;
                &PrintInstallation($message);
	}
	elsif($FORM{step} eq "2"){
		if($FORM{agree}){	&PrintMysqlopt($ENV{SCRIPT_NAME});	}
		else{					print "Location:http://www.mojoscripts.com\n\n";	}
	}
	elsif($FORM{step} eq "3"){
	       $message=&CheckMysqlInput;
	       if ($message) { &PrintMysqlopt($ENV{SCRIPT_NAME},$message);}
              $CONFIG{mysql_hostname}=$FORM{mysql_hostname};
              $CONFIG{mysql_database}=$FORM{mysql_database};
              $CONFIG{mysql_username}=$FORM{mysql_username};
              $CONFIG{mysql_password}=$FORM{mysql_password};
	       &WriteConfig;
	       require "config.pl";
	       &Initialization;
               &PrintInstallation;
        }
	else{								&PrintLicenseAgreement;	}
}
################################################################
sub CheckMysqlInput{
	my($message,$dsn,$dbh);
    $dsn="DBI:mysql:$FORM{mysql_database}:$FORM{mysql_hostname}";
    $dbh=DBI->connect($dsn,$FORM{mysql_username},$FORM{mysql_password});
#$dsn="DBI:mysql:dev_personals:localhost";
#$dbh=DBI->connect($dsn,'personals','mojosql');
    if (!$dbh) {
         $message="ERROR: Unable to connect user \'$FORM{mysql_username}\' to base \'$FORM{mysql_database}\' on host
         \'$FORM{mysql_hostname}\'. Please check MySQL options.";
    }
    return $message;
}
##################################################################################
sub CreateDefaultCats{
        my @def_cats =(
        "Men Seeking Men",
        "Men Seeking Women",
        "Women Seeking Men",
        "Women Seeking Women",
        "Just Friends",
        "Activity Partners",
        "Penpals",
        "Others");

	$CAT{date_create}=  time;
	$CAT{date_end}=     time + 365 * 24 * 60 *60;
	$CAT{icon}=        qq||;
	$CAT{ricon}=qq||;       #qq|http://www.mojoscripts.com/demo/icons/personals.gif|;
	$CAT{subs}=        qq||;
	$CAT{files}=       qq||;
        foreach $cat(@def_cats){
                $CAT{name}=$cat;
                $CAT{description}= qq|Ads about $cat|;
                &AddCategoryDB(\%CAT);
	}
}
###############################################################
sub CreateMaster{
	my(%DB);
	($DB{username}, $DB{position}) = @_;
	$DB{password} = "mojoscripts";
	$DB{email}    = $FORM{myemail};
	$DB{email_notify}=  "off";
	$DB{fname} = "mojo";
	$DB{lname} = "scripts";
        $DB{ad_allowed}=$DB{media_allowed} = 1000;
	$DB{mailbox_size}='100';

	$DB{date_create} = $DB{premium_start} = &TimeNow;
	$DB{date_end} = $DB{premium_end} = &TimeNow + 10 * 365 * 24 * 60 *60;
	$DB{status}   = "active";
	&AddMemberDB(\%DB);
}
##############################################################################
sub CreateDefaultAccounts{
        my (%DB);

	unless (-d $CONFIG{account_path}){
		mkpath($CONFIG{account_path}, 0, 0777);
		chmod(0777, $CONFIG{account_path});
	}

        $DB{date_create}=time;
        $DB{date_end}='';
        $DB{ID}='guest';
        $DB{name}='Guest account (default account for non-registered visitors)';
        $DB{description}='Guest account (default account for non-registered visitors)';
        $DB{setup_finished}=qq|powered by mojoscripts.com|;
        $DB{trial_amount}='00.00';
        $DB{trial_period}='unlimited';
        $DB{trial_time}="D";
        $DB{trial_length}=2**32-2;
       $DB{recurring_amount}='00.00';
        $DB{recurring_period}="unlimited";
        $DB{recurring_time}="D";
        $DB{recurring_length}=2**32-2;
        $DB{email}='';
        $DB{gateway}='';
#        $DB{recurring}='';

        $DB{ad_browse}='checked';
        $DB{ad_search}='checked';
        $DB{ad_search_advanced}='checked';
        $DB{ad_view}='checked';
        $DB{cupid_search}='';
        $DB{member_view}='checked';
        unless(-d "$CONFIG{account_path}/guest"){
            mkdir("$CONFIG{account_path}/guest", 0777);
            chmod(0777, "$CONFIG{account_path}/guest");
        }

        &AddAccountDB(\%DB);
#Default
	$DB{ID}='member';
        $DB{name}='Member account';
        $DB{description}='Member account';
        $DB{setup_finished}=qq|powered by mojoscripts.com|;
        $DB{trial_amount}=0;
        $DB{trial_period}='unlimited';
        $DB{trial_time}="D";
        $DB{trial_length}=2**32-2;
        $DB{recurring_amount}=0;
        $DB{recurring_period}="unlimited";
        $DB{recurring_time}="D";
        $DB{recurring_length}=2**32-2;
        $DB{email}='';
        $DB{gateway}='';
#        $DB{recurring}='';
#	@fields=( "ad_browse", "ad_post", "ad_post_audio", "ad_post_pix", "ad_post_video", "ad_reply", "ad_save", "ad_search", "ad_search_advanced", "ad_view",
#	"photo_comment", "photo_upload", "photo_view", "photo_gallery",
#	"cupid_search", "mail_new_ad", "mail_notify", "mail_send", "mail_signature", "auto_reply",
#    "member_search", "member_search_advanced", "member_view");
	require "$CONFIG{program_files_path}/membership.txt";
	&AccountDef;

	foreach $perm(@order) {$DB{$perm}='checked' unless ($perm =~ /ad_allowed|media_allowed|mailbox_size/);}
	$DB{ad_allowed}='5';
	$DB{media_allowed}='5';
	$DB{mailbox_size}='100';
        unless(-d "$CONFIG{account_path}/member"){
            mkdir("$CONFIG{account_path}/member", 0777);
            chmod(0777, "$CONFIG{account_path}/member");
        }
	&AddAccountDB(\%DB);
}
###############################################################
sub WriteConfig{
	my($filename);
	if($ENV{PATH_TRANSLATED}){
		($filename = $ENV{PATH_TRANSLATED}) =~ s/\\/\//g;
		$filename  = &ParentDirectory($filename);
		$filename .=  "/config.pl";
	}
	else{
		$filename  = $ENV{SCRIPT_FILENAME};
		$filename  = &ParentDirectory($filename);
		$filename .= "/config.pl";
	}
	open(FILE, ">$filename") or &PrintFatal("$mj{file3}: \"$filename\"", (caller)[1], (caller)[2]);
#	flock(FILE,2);
	print FILE qq~
\$CONFIG{site_title}=    qq|$FORM{site_title}|;
\$CONFIG{document_root}= qq|$FORM{document_root}|;
\$CONFIG{backup_path}=   qq|$FORM{backup_path}|;
#\$CONFIG{data_path}=     qq|$FORM{data_path}|;
\$CONFIG{email_path}=    qq|$FORM{email_path}|;
\$CONFIG{image_path}=    qq|$FORM{image_path}|;
\$CONFIG{image_url}=     qq|$FORM{image_url}|;
\$CONFIG{log_path}=      qq|$FORM{log_path}|;
#\$CONFIG{member_path}=   qq|$FORM{member_path}|;
#\$CONFIG{mail_path}=     qq|$FORM{mail_path}|;
\$CONFIG{photo_path}=    qq|$FORM{photo_path}|;
\$CONFIG{photo_url}=     qq|$FORM{photo_url}|;
\$CONFIG{program_files_path}=qq|$FORM{program_files_path}|;
\$CONFIG{script_path}=   qq|$FORM{script_path}|;
\$CONFIG{script_url}=    qq|$FORM{script_url}|;
\$CONFIG{session_path}=  qq|$FORM{session_path}|;
\$CONFIG{template_path}= qq|$FORM{template_path}|;
\$CONFIG{var_path}=      qq|$FORM{var_path}|;
\$CONFIG{mysql_hostname}=qq|$CONFIG{mysql_hostname}|;
\$CONFIG{mysql_database}=      qq|$CONFIG{mysql_database}|;
\$CONFIG{mysql_username}=    qq|$CONFIG{mysql_username}|;
\$CONFIG{mysql_password}=    qq|$CONFIG{mysql_password}|;
\$CONFIG{myname}=        qq|$FORM{myname}|;
\$CONFIG{myemail}=       q|$FORM{myemail}|;
\$CONFIG{sendmail}=      qq|$FORM{sendmail}|;
\$CONFIG{smtp_server}=   qq|$FORM{smtp_server}|;
\$CONFIG{system}=        qq|$FORM{system}|;
\$CONFIG{language_lib}=  qq|$FORM{language_lib}|;
\$CONFIG{script_ext}=    qq|$FORM{script_ext}|;
~;

my $config_footer =<<'_END_OF_FILE_';
######### Configurations ##########
$CONFIG{lsh}=            qq|1|;
$CONFIG{lex}=            qq|2|;
$CONFIG{lun}=            qq|8|;
$CONFIG{flock}=          qq||;
$CONFIG{rename}=         qq|yes|;
$CONFIG{mpp}=            qq|40|;
$CONFIG{lpp}=            qq|25|;
$CONFIG{daysnew}=        qq|10|;

$CONFIG{ad_length}=      qq|45|;
$CONFIG{ad_type}=        qq|instant|;
#$CONFIG{ad_allowed}=     qq|3|;
$CONFIG{ad_email}=       q|webmaster@mojoscripts.com|;
$CONFIG{media_size}=     qq|50000|;
#$CONFIG{media_allowed}=  qq|5|;
$CONFIG{media_ext}=      q|jpg,jpeg,gif,png|;
$CONFIG{media_width}=    qq|75|;
$CONFIG{media_height}=   qq|100|;

$CONFIG{member_type}=    qq|instant|;
$CONFIG{member_notify}=   q|webmaster@mojoscripts.com|;
$CONFIG{member_length}=  qq|10|;
$CONFIG{advanced_expire_email}=qq||;
$CONFIG{duplicate_email}=qq|1|;
#$CONFIG{mailbox_size}=   qq|100|;
$CONFIG{username_length}=qq|5|;
$CONFIG{password_length}=qq|5|;

$CONFIG{max_wordlength}= qq|25|;
$CONFIG{max_description}=qq|700|;
$CONFIG{min_description}=qq|100|;
$CONFIG{short_description}=qq|200|;

$CONFIG{thumbnailer}=    qq|0|;
$CONFIG{show_empty_subs}=qq|1|;
$CONFIG{paysite}=        qq|0|;

$CONFIG{catlayout}=      qq|2|;

$CONFIG{default_account}=qq|member|;

$CONFIG{check_wholename}=qq|0|;
$CONFIG{check_case}=     qq|0|;
################ TABLE DEFINITION  ########################
$TABLE{media_width}=       qq|100%|;
$TABLE{media_border}=      qq|0|;
$TABLE{media_cellspacing}= qq|0|;
$TABLE{media_cellpadding}= qq|0|;
$TABLE{media_bgcolor}=     qq|#FFFFFF|;
$TABLE{media_bordercolor}= qq|#DDDDDD|;
$TABLE{media_rows}=        qq|5|;
$TABLE{media_cols}=        qq|4|;

$TABLE{cat_width}=         qq|100%|;
$TABLE{cat_border}=        qq|0|;
$TABLE{cat_cellspacing}=   qq|0|;
$TABLE{cat_cellpadding}=   qq|0|;
$TABLE{cat_bgcolor}=       qq|#FFFFFF|;
$TABLE{cat_bordercolor}=   qq|#DDDDDD|;
$TABLE{cat_rows}=          qq|2|;
$TABLE{cat_cols}=          qq|4|;

$TABLE{menu_width}=         qq|100%|;
$TABLE{menu_border}=        qq|0|;
$TABLE{menu_cellspacing}=   qq|0|;
$TABLE{menu_cellpadding}=   qq|0|;
$TABLE{menu_bgcolor}=       qq|#FFFFFF|;
$TABLE{menu_bordercolor}=   qq|#DDDDDD|;
$TABLE{menu_rows}=          qq|2|;
$TABLE{menu_cols}=          qq|4|;
################################################################
1;
_END_OF_FILE_
	print FILE $config_footer;
#	flock(FILE,8);
	close(FILE);
	chmod(0777, $filename);
	return 1;
}

################################################################################
sub PrintMysqlopt{
	my ($url, $message);
	($url,$message) = @_;
	print "Content-Type:text/html\n\n";
	print qq|<HTML>
<HEAD>
<TITLE>$mj{program}</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
</HEAD>
<BODY bgcolor="#FFFFFF">
<form name="mojoScripts" method="post" action="$url">
  <input type="hidden" name="type" value="config">
	<input type="hidden" name="class" value="config">
  	<input type="hidden" name="step" value="3">
  <table  cellpadding="5" cellspacing="0" width="100%" border="1" bordercolor="#EEEEEE">
    <tr> 
      <td valign="middle" align="center" height="42" colspan="2"> <b><font color="#0000FF" face="Verdana" size="5">$mj{program}</font><font color="#FFFFFF" face="Verdana" size="5"> 
        $mj{version}<br>
        </font><font color="#CCCCCC" face="Verdana" size="5"><font size="2" color="#CCCCCC">by 
        <a href="http://www.mojoscripts.com"><font size="2" color="#FF00FF">mojoscripts</font></a><br>
        <font color="#000000">$mj{title}</font></font></font></b></td>
    </tr>
    <tr> 
      <td valign="middle" align="center" height="32" colspan="2"><font color=red><b>$message</b></font></td>
    </tr>
    <tr> 
      <td  valign="middle" align="center" colspan="2"> 
        <b><font face="Tahoma" size="2">$mj{setup51}</font></b>
      </td>
    </tr>
    <tr> 
      <td width="164" valign="top" align="center"> 
        <div align="left"><b><font face="Tahoma" size="2">$mj{setup52}</font></b></div>
      </td>
      <td valign="top" align="center" width="797">
          <div align="left"><!-- <font face="Tahoma" size="2">$mj{setup53}<br> -->
          <input type="text" name="mysql_hostname" size="30" value="$FORM{mysql_hostname}">
          </font></div>
      </td>
    </tr>
    <tr> 
      <td width="164" valign="top" align="center"> 
        <div align="left"><b><font face="Tahoma" size="2">$mj{setup54}</font></b></div>
      </td>
      <td valign="top" align="center" width="797">
          <div align="left"><input type="text" name="mysql_username" size="30" value="$FORM{mysql_username}">
          </font></div>
      </td>
    </tr>
    <tr> 
      <td width="164" valign="top" align="center"> 
        <div align="left"><b><font face="Tahoma" size="2">$mj{setup55}</font></b></div>
      </td>
      <td valign="top" align="center" width="797">
          <div align="left"><input type="text" name="mysql_password" size="30" value="$FORM{mysql_password}">
          </font></div>
      </td>
    </tr>
    <tr> 
      <td width="164" valign="top" align="center"> 
        <div align="left"><b><font face="Tahoma" size="2">$mj{setup56}</font></b></div>
      </td>
      <td valign="top" align="center" width="797">
          <div align="left"><input type="text" name="mysql_database" size="30" value="$FORM{mysql_database}">
          </font></div>
      </td>
    </tr>
	<tr> 

	<tr> 
	  <td valign="middle" align="center" colspan="2"> 
        <input type="SUBMIT" value=" $TXT{save}" name="submit">
        <input type="reset" name="reset" value=" $TXT{reset}">
      </td>
    </tr>
  </table>
</form>
</BODY>
</HTML>
	|;
	&PrintFooter;
}










############################################################
sub PrintInstallation{
	my($error,$host, $message, $root_path, $this_url, $this_dir);
	$error = shift;
	if($ENV{PATH_TRANSLATED}){
		$message = qq|Our software detects that you are running Windows. You MUST substitute all instances of backslashes "\\" with forward slashes "/" in your paths. Failure to do so may result in Internal Server Errors. You may skip anything related to "File Permissions".|;
		$root_path = $ENV{PATH_TRANSLATED};
		$root_path =~ s/\\/\//g;
		$this_dir = &ParentDirectory($root_path);
		$root_path =~ s/$ENV{SCRIPT_NAME}//i;

		$this_url = $ENV{'HTTP_HOST'}. &ParentDirectory($ENV{'SCRIPT_NAME'});
	}
	else{
		$message = qq|<font size=5 color=red>$mj{setup7}</font>| unless (-w "config.pl");
		$root_path = $ENV{SCRIPT_FILENAME};
		$root_path =~ s/$ENV{SCRIPT_NAME}//i;

		$this_dir = &ParentDirectory($ENV{'SCRIPT_FILENAME'});
		$this_url = $ENV{'HTTP_HOST'}. &ParentDirectory($ENV{'SCRIPT_NAME'});
	}

	$FORM{site_title}=   qq|$mj{title}|                      unless $FORM{site_title};
	$FORM{root_path}=    qq|$root_path|                      unless $FORM{root_path};
	$FORM{document_root}=qq|$root_path| 				         unless $FORM{document_root};
	$FORM{program_files_path}="$this_dir/program_files" 		unless $FORM{program_files};
#	$FORM{data_path}=    qq|$FORM{program_files}/data|      	unless $FORM{data_path};
	$FORM{email_path}=   qq|$this_dir/emails|           	  	unless $FORM{email_path};
	$FORM{image_path}=   qq|$this_dir/images|             	unless $FORM{image_path};
#	$FORM{member_path}=  qq|$this_dir/members|            	unless $FORM{member_path};
#	$FORM{mail_path}=    qq|$FORM{program_files}/mails|    	unless $FORM{mail_path};
	$FORM{photo_path}=   qq|$this_dir/photos|             	unless $FORM{photo_path};
	$FORM{template_path}=qq|$this_dir/templates|          	unless $FORM{template_path};
	$FORM{session_path}= qq|$FORM{program_files}/sessions| 	unless $FORM{session_path};
	$FORM{script_path}=  qq|$this_dir|                       unless $FORM{script_path};
	$FORM{mysql_hostname}=qq|localhost| unless $FORM{mysql_hostname};
        $FORM{homelink}=     qq|http://$ENV{HTTP_HOST}|    		unless $FORM{homelink};
	$FORM{myemail}=      qq|$ENV{SERVER_ADMIN}|            	unless $FORM{myemail};
	my @myname= split(/\@/, $FORM{myemail});
	$FORM{'myname'} =    $myname[0]            			  		unless $FORM{myname};
	$FORM{'sendmail'} =  &MailProgram                    		unless $FORM{sendmail};

#	$FORM{smtp} = qq|mail.$host|                        unless $FORM{smtp};
#	$HTML_language = &BuildLanguageMenu;
	print "Content-Type:text/html\n\n";
	&ConfigTemplate($ENV{SCRIPT_NAME}, $error?$error:$message);
exit;
}
############################################################
sub PrintLicenseAgreement{
	my($license, $request, $response, $ua);
	if(&isModInstalled("LWP")){
		require LWP::UserAgent;
 		my $ua = LWP::UserAgent->new;
 		my $request = HTTP::Request->new('POST', 'http://www.mojoscripts.com/cgi-bin/license/agreement.cgi');
 		$request->content_type('application/x-www-form-urlencoded');
		$request->content("type=retail");
		my $response = $ua->request($request);
		$license = $response->content;
	}
	unless($license){
		$license =qq|
		1. License
This is not a freeware!!! It has to be paid to use.
Anyone found to be using an unlicensed version of this software will
be faced with legal action. This software is only distributed from
http://www.mojoscripts.com/. If you have purchased this script from
somewhere other than http://www.mojoscripts.com/ then please email
sales\@mojoscripts.com immediately.

This software may be modified free of charge as long as this copyright
notice and the comments above remain intact. Selling or distributing
the code of this software or a software derived from this software,
without our prior written consent is expressly forbidden.

2. Indemnification
Customer agrees that it shall defend, indemnify, save and hold
mojoscripts.com, Thi pham, and any persons affiliated with mojoscripts.com,
harmless from any and all demands, liabilities, losses, costs and claims,
including reasonable attorney's fees asserted against mojoScripts.com,
its agents, its customers, officers and employees, that may arise or result
from any service provided or performed or agreed to be performed or any product
sold by customer, its agents, employees or assigns. Customer agrees to defend,
indemnify and hold harmless mojoScripts.com, its agents, its cusomters, officers,
and employees, against liabilities arising out of:
(a) any injury to person or property caused by a products sold or  otherwise
 distributed in connection with mojoScripts.com products;
(b) any material supplied by customer infringing or allegedly infringing on the
proprietary rights of a third party;
(c) copyright infringement and
(d) any defective products sold to customer from mojoScripts.com
		|;
		$license = qq|<pre><br>$license</pre>|;
	}

#	print "Content-Type:text/html\n\n";
	&PrintHeader;
	print qq|<html>
<head>
<title>End User License Agreement</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000" background="#EBEBEB">
<table width=600 cellpadding=2 cellspacing=0 border=0 align="center" bgcolor=#FFFFFF>
  <tr>
    <td height="190" valign="top"><font face="Arial" size="2"><b>Terms of Use</b>
      <p>
<b>Before installing and using $mj{program} $mj{version}, you must agree to the terms below. If you do not agree, please stop using  this software and delete it from your server.</b>
      $license
         For complete <a href="http://www.mojoscripts.com/order/eula.html">term of use</a>, please visit our website.
      <p>&nbsp;
      </font></td>
  </tr>
  <tr>
    <td align=center height="43">
      <form name="mojo" method="post" action="">
        <input type="hidden" name="step" value="2">
        <input type="submit" name="agree" value="I fully understand and agree to the above!">
        <br>
        <input type="submit" name="disagree" value="I do not agree, take me somewhere else! ">
      </form>
      <font face="Arial" size="2">
      <p>
      </font></td>
  </tr>
</table>
</body>
</html>

	|;
	&PrintFooter;
}
############################################################
1;
