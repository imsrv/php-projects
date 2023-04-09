#!/usr/bin/perl
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
	require "html.pl";
	require "images.pl";
	require "library.pl";
	require "logs.pl";
	require "templates.pl";
	require "mojoscripts.pl";
	require "parse_template.pl";
	require "upgrade.pl";
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
	$t_start = time;
	$Cgi = new CGI; $Cgi{mojoscripts_created} = 1;
	&ParseForm;
	&CheckAllRequiredFiles;
#	rmtree($CONFIG{member_path}, 0);rmtree($CONFIG{data_path}, 0);rmtree($CONFIG{photo_path}, 0);rmtree($CONFIG{mail_path}, 0);&PrintWelcome;
	my $message;
        if($FORM{step} >= 2){&Initialization;}
	if ($FORM{step} eq '1'){
              $message = &CheckMysqlInput;
	      &PrintWelcome($message) if $message;
              $CONFIG{mysql_hostname}=$FORM{mysql_hostname};
              $CONFIG{mysql_database}=$FORM{mysql_database};
              $CONFIG{mysql_username}=$FORM{mysql_username};
              $CONFIG{mysql_password}=$FORM{mysql_password};
              &WriteConfig;
	      require "config.pl";
              &CorrectDatabaseFields;
	      $anonyminit=1;
              &Initialization;
              &DbInit;
              &PrintMessage('Step 2: going to copy members database');
        }
	elsif ($FORM{step} eq '2'){
             &ConvertMemberDB unless (defined $FORM{guestid});
	     $message=&CreateAccounts;
	     if ($message) { $FORM{step}=1; &PrintMessage($message);}
             &PrintMessage('Step 3: going to copy ads and categories database. Incomplete ads are not copied.');
        }
	elsif ($FORM{step} eq '3'){
             &ConvertData;
             &PrintMessage('Step 4: going to copy mails database');
        }
	elsif ($FORM{step} eq '4') {
            &ConvertMailDB;
	    &PrintEnd("Process completed.");
	}
        &PrintWelcome('Welcome<br> Step 1: set MySQL options');
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
############################################
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
	$CONFIG{default_account}='member';
	&WriteConfig;
}

##########################################################################
#version 2.10!
sub WriteConfig{
	my($filename);
	if($ENV{PATH_TRANSLATED}){
		($filename=$ENV{PATH_TRANSLATED}) =~ s/\\/\//g;
		$filename = &ParentDirectory($filename);
		$filename .=  "/config.pl";
	}
	else{
		$filename=$ENV{SCRIPT_FILENAME};
		$filename = &ParentDirectory($filename);
		$filename .=  "/config.pl";
	}

	open(FILE, ">$filename") or &PrintFatal("$mj{file3}: \"$filename\"", (caller)[1], (caller)[2]);
	print FILE qq~
\$CONFIG{site_title}=    qq|$CONFIG{site_title}|;
\$CONFIG{document_root}= qq|$CONFIG{document_root}|;
\$CONFIG{backup_path}=   qq|$CONFIG{backup_path}|;
\$CONFIG{data_path}=     qq|$CONFIG{data_path}|;
\$CONFIG{email_path}=    qq|$CONFIG{email_path}|;
\$CONFIG{image_path}=    qq|$CONFIG{image_path}|;
\$CONFIG{image_url}=     qq|$CONFIG{image_url}|;
\$CONFIG{log_path}=      qq|$CONFIG{log_path}|;
\$CONFIG{member_path}=   qq|$CONFIG{member_path}|;
\$CONFIG{mail_path}=     qq|$CONFIG{mail_path}|;
\$CONFIG{photo_path}=    qq|$CONFIG{photo_path}|;
\$CONFIG{photo_url}=     qq|$CONFIG{photo_url}|;
\$CONFIG{program_files_path}=qq|$CONFIG{program_files_path}|;
\$CONFIG{script_path}=   qq|$CONFIG{script_path}|;
\$CONFIG{script_url}=    qq|$CONFIG{script_url}|;
\$CONFIG{session_path}=  qq|$CONFIG{session_path}|;
\$CONFIG{template_path}= qq|$CONFIG{template_path}|;
\$CONFIG{var_path}=      qq|$CONFIG{var_path}|;
\$CONFIG{mysql_hostname}=qq|$CONFIG{mysql_hostname}|;
\$CONFIG{mysql_database}=qq|$CONFIG{mysql_database}|;
\$CONFIG{mysql_username}=qq|$CONFIG{mysql_username}|;
\$CONFIG{mysql_password}=qq|$CONFIG{mysql_password}|;
\$CONFIG{myname}=        qq|$CONFIG{myname}|;
\$CONFIG{myemail}=       q|$CONFIG{myemail}|;
\$CONFIG{sendmail}=      qq|$CONFIG{sendmail}|;
\$CONFIG{smtp_server}=   qq|$CONFIG{smtp_server}|;
\$CONFIG{system}=        qq|$CONFIG{system}|;
\$CONFIG{language_lib}=  qq|$CONFIG{language_lib}|;
\$CONFIG{script_ext}=    qq|$CONFIG{script_ext}|;
\$CONFIG{use_GD}=        qq|$CONFIG{use_GD}|;

######### Configurations ##########
\$CONFIG{flock}=          qq|$CONFIG{flock}|;
\$CONFIG{rename}=         qq|$CONFIG{rename}|;
\$CONFIG{lpp}=            qq|$CONFIG{lpp}|;
\$CONFIG{mpp}=            qq|$CONFIG{mpp}|;
\$CONFIG{daysnew}=        qq|$CONFIG{daysnew}|;

\$CONFIG{ad_length}=      qq|$CONFIG{ad_length}|;
\$CONFIG{ad_type}=        qq|$CONFIG{ad_type}|;
\$CONFIG{ad_allowed}=     qq|$CONFIG{ad_allowed}|;
\$CONFIG{ad_notify}=       q|$CONFIG{ad_notify}|;

\$CONFIG{media_size}=     qq|$CONFIG{media_size}|;
\$CONFIG{media_allowed}=  qq|$CONFIG{media_allowed}|;
\$CONFIG{media_ext}=      qq|$CONFIG{media_ext}|;
\$CONFIG{media_width}=    qq|$CONFIG{media_width}|;
\$CONFIG{media_height}=   qq|$CONFIG{media_height}|;

\$CONFIG{member_type}=    qq|$CONFIG{member_type}|;
\$CONFIG{member_notify}=   q|$CONFIG{member_notify}|;
\$CONFIG{member_length}=  qq|$CONFIG{member_length}|;
\$CONFIG{duplicate_email}=qq|$CONFIG{duplicate_email}|;
\$CONFIG{mailbox_size}=   qq|$CONFIG{mailbox_size}|;
\$CONFIG{username_length}=qq|$CONFIG{username_length}|;
\$CONFIG{password_length}=qq|$CONFIG{password_length}|;

\$CONFIG{max_wordlength}= qq|$CONFIG{max_wordlength}|;
\$CONFIG{max_description}=qq|$CONFIG{max_description}|;
\$CONFIG{min_description}=qq|$CONFIG{min_description}|;
\$CONFIG{short_description}=qq|$CONFIG{short_description}|;

\$CONFIG{thumbnailer}=    qq|$CONFIG{thumbnailer}|;
\$CONFIG{show_empty_subs}=qq|$CONFIG{show_empty_subs}|;
\$CONFIG{paysite}=        qq|$CONFIG{paysite}|;

\$CONFIG{catlayout}=      qq|$CONFIG{catlayout}|;

\$CONFIG{check_wholename}=qq|$CONFIG{check_wholename}|;
\$CONFIG{check_case}=     qq|$CONFIG{check_case}|;

\$CONFIG{default_account}=qq|$CONFIG{default_account}|;
\$CONFIG{payment_notify}= q|$CONFIG{payment_notify}|;
################ TABLE DEFINITION  ########################
\$TABLE{media_width}=      qq|$TABLE{media_width}|;
\$TABLE{media_border}=     qq|$TABLE{media_border}|;
\$TABLE{media_cellspacing}=qq|$TABLE{media_cellspacing}|;
\$TABLE{media_cellpadding}=qq|$TABLE{media_cellpadding}|;
\$TABLE{media_bgcolor}=    qq|$TABLE{media_bgcolor}|;
\$TABLE{media_bordercolor}=qq|$TABLE{media_bordercolor}|;
\$TABLE{media_rows}=       qq|$TABLE{media_rows}|;
\$TABLE{media_cols}=       qq|$TABLE{media_cols}|;

\$TABLE{cat_width}=        qq|$TABLE{cat_width}|;
\$TABLE{cat_border}=       qq|$TABLE{cat_border}|;
\$TABLE{cat_cellspacing}=  qq|$TABLE{cat_cellspacing}|;
\$TABLE{cat_cellpadding}=  qq|$TABLE{cat_cellpadding}|;
\$TABLE{cat_bgcolor}=      qq|$TABLE{cat_bgcolor}|;
\$TABLE{cat_bordercolor}=  qq|$TABLE{cat_bordercolor}|;
\$TABLE{cat_rows}=         qq|$TABLE{cat_rows}|;
\$TABLE{cat_cols}=         qq|$TABLE{cat_cols}|;

\$TABLE{menu_width}=       qq|$TABLE{menu_width}|;
\$TABLE{menu_border}=      qq|$TABLE{menu_border}|;
\$TABLE{menu_cellspacing}= qq|$TABLE{menu_cellspacing}|;
\$TABLE{menu_cellpadding}= qq|$TABLE{menu_cellpadding}|;
\$TABLE{menu_bgcolor}=     qq|$TABLE{menu_bgcolor}|;
\$TABLE{menu_bordercolor}= qq|$TABLE{menu_bordercolor}|;
\$TABLE{menu_rows}=        qq|$TABLE{menu_rows}|;
\$TABLE{menu_cols}=        qq|$TABLE{menu_cols}|;
########################################################
1;

~;

	close(FILE);
	return 1;
}

############################################################
sub PrintWelcome{
	my $message = shift;
	foreach (keys %CONFIG) {$FORM{$_}=$CONFIG{$_} unless defined $FORM{$_};}
        &PrintHeader;
	print qq|<html>
<head>
<title>\$mj{program} $mj{version} Upgrading procedure</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<table width="80%" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#330066">
  <tr>
    <td>
      <div align="center"><b><font size="4">$mj{program} $mj{version} Upgrading
        Procedure<br>
        from version 2.XX to $mj{version}</font></b></div>
    </td>
  </tr>
  <tr>
    <td>
      <ol>
        <li>Copy attached files to corresponding folders of your old version, replacing when offered.</li>
        <li>Run upgrage.cgi module. Your old data will be copied into mysql database.
          (If your server times out, you may need to run this from the shell.)</li>
        <li>Test everything.</li>
        <li>If everything works as expected, then run delete_old.cgi to delete old database.</li>
        <li>If there are any problems, please contact us or have us do the upgrading
          for you for \$50.</li>
      </ol>
    </td>
  </tr>
  <tr>
    <td>
      <div align="center"><b><font color="#FF0000">$message</font></b></div>
    </td>
  </tr>
  <tr>
    <td height="75">
      <form name="mojo" method="post" action="upgrade.cgi">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td  valign="middle" align="center" colspan="2"> 
        <b><font face="Tahoma" size="2">$mj{setup57}</font></b>
      </td>
    </tr>
    <tr> 
      <td width="164" valign="top" align="center"> 
        <b><font face="Tahoma" size="2">$mj{setup52}</font></b>
      </td>
      <td valign="top" align="center">
          <div align="left">
          <input type="text" name="mysql_hostname" size="30" value="$FORM{mysql_hostname}">
          </font></div>
      </td>
    </tr>
    <tr> 
      <td width="164" valign="top" align="center"> 
        <b><font face="Tahoma" size="2">$mj{setup54}</font></b>
      </td>
      <td valign="top" align="center">
          <div align="left"><input type="text" name="mysql_username" size="30" value="$FORM{mysql_username}">
          </font></div>
      </td>
    </tr>
    <tr> 
      <td width="164" valign="top" align="center"> 
        <b><font face="Tahoma" size="2">$mj{setup55}</font></b>
      </td>
      <td valign="top" align="center">
          <div align="left"><input type="text" name="mysql_password" size="30" value="$FORM{mysql_password}">
          </font></div>
      </td>
    </tr>
    <tr> 
      <td width="164" valign="top" align="center"> 
        <b><font face="Tahoma" size="2">$mj{setup56}</font></b>
      </td>
      <td valign="top" align="center">
          <div align="left"><input type="text" name="mysql_database" size="30" value="$FORM{mysql_database}">
          </font></div>
      </td>
    </tr>
	<tr> 

	<tr> 
	  <td valign="middle" align="center" colspan="2"> 
        <input type="SUBMIT" value="Next >>" name="submit">
        <input type="reset" name="reset" value=" $TXT{reset}">
      </td>
    </tr>
        </table>
        <input type="hidden" name="step" value="1">
      </form>
    </td>
  </tr>
</table>
</body>
</html>
	|;
	&PrintFooter;
}


