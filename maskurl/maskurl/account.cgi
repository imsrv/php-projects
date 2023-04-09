#!/usr/bin/perl
#-------------------------------------------------------------------------------
# $Id: account.cgi,v 1.2 2000/01/16 18:33:51 madcat Exp $
#-------------------------------------------------------------------------------
#
# account.cgi
#
# Allows users to edit their details and view stats
#
#-------------------------------------------------------------------------------
# This script is (c) 2000 PerlCoders PTY. Unauthorised use, duplication
# and distribution is prohibited by international copyright law. 
#-------------------------------------------------------------------------------
# Script Author: MadCat <madcat@gatekeeper.cistron.nl>
#-------------------------------------------------------------------------------
use CGI;
use DBI;
use CgiTools;
use Configuration;
use CgiWrap;
use Template;
use ActionHandler;

# Global variables
$query=new CGI;
$errormessage="";
$userid=undef;

%form=(	"username"	=>	"",
	"password"	=>	"",
	"password_vfy"	=>	"",
	"sitetitle"	=>	"",
	"sitedescription"	=>	"",
	"sitekeywords"	=>	"",
	"siteurl"	=>	"",
	"email"		=>	"");

sub	cgi_error {
	my ($message)=@_;

	$errormessage=$message;	
	$dbh->disconnect if($dbh);
	&dumphtml("templates/account/error.tmpl");
	exit(0);
}

sub	finish {
	
	$dbh->disconnect if($dbh);
	exit(0);
}

sub	ac_default {
	&dumphtml("templates/account/login.tmpl");
	&finish;
}

sub	ac_login {
	my $username=$globals{"username"};
	my $password=$globals{"password"};
	my $sth;
	my $res;
	my $rpass;

	&db_init;
	
	$sth=$dbh->prepare("SELECT * FROM users WHERE username=\"$username\"");
	
	$sth->execute || &cgi_error("login: sth->execute error: $DBI::errstr");

	$res=$sth->fetchrow_hashref;
	
	if($res->{'username'} eq undef) {
		# invalid username
		$errormessage="<li> The username you entered is invalid!";
		&dumphtml("templates/account/error.tmpl");
		&finish;
	}
	
	$rpass=$res->{'password'};
	$sth->finish;
	
	if($password ne $rpass) {
		$errormessage="<li> You entered a bad password!";
		&dumphtml("templates/account/error.tmpl");
		&finish;
	}
	
	# okay it all makes sense so dump the main screen
	
	&dumphtml("templates/account/main.tmpl");
	&finish;
}

sub	ac_main {
	&dumphtml("templates/account/main.tmpl");
	&finish;
}

sub	ac_edit {
	my $username=$globals{"username"};
	my $sth;
	my $res;
	
	# we need to transport all these values *including* the password
	# to the globals they belong so the edit template can see them

	&db_init;
	
	$sth=$dbh->prepare("SELECT * FROM users WHERE username=\"$username\"");
	
	$sth->execute;
	$res=$sth->fetchrow_hashref;
	
	foreach $key (keys(%form)) {
		$globals{$key}=$res->{$key} if($key ne "password_vfy");
	}
	
	$globals{"password_vfy"}=$globals{"password"};
	
	$sth->finish;
	
	&dumphtml("templates/account/edit.tmpl");
	&finish;
} 

sub	ac_editsave {
	my $username=$globals{"username"};
	my $sth;
	my $error=0;

	$error=0;
	$errormessage="";

	if($globals{"username"} eq undef) {
		$error=1;
		$errormessage.="<li> You must enter a username!\n";
	}
	if(($globals{"username"}=~/\s/) || ($globals{"username"}=~/[\\\/\@\#\$\!\%\^\&\*\(\)\+\=\{\}\[\]\'\"\;\:\.\,\?\>\<]/)) {
		$error=1;
		$errormessage.="<li> Username contains illegal characters!\n";
	}
	if(($globals{"password"} eq undef) || ($globals{"password"} ne $globals{"password_vfy"})) {
		$error=1;
		$errormessage.="<li> You must enter two matching passwords!\n";
	}
	if($globals{"sitetitle"} eq undef) {
		$error=1;
		$errormessage.="<li> You must enter a title for your site!\n";
	}
	if($globals{"sitedescription"} eq undef) {
		$error=1;
		$errormessage.="<li> You must enter a description for your site!\n";
	}
	if(($globals{"siteurl"} eq undef) || ($globals{"siteurl"}!~/^http:\/\//i)) {
		$error=1;
		$errormessage.="<li> You must enter a valid URL to your site!\n";
	}
	if($globals{"sitekeywords"} eq undef) {
		$error=1;
		$errormessage.="<li> You must enter a few keywords for your site!\n";
	}
	if(($globals{"email"} eq undef)	|| ($globals{"email"}!~/\@/)) {
		$error=1;
		$errormessage.="<li> You must enter a valid e-mail address!\n";
	}

	if($error==1) {
		&dumphtml("templates/account/edit_error.tmpl");
		&finish;
	}

	# fix up the url and make it end with a /
	$globals{"siteurl"}.="/" if(substr(-1, $globals{"siteurl"} ne "/"));
	
	&db_init;
	
	foreach $key (keys(%form)) {
		if($key ne "password_vfy") {
			$sth=$dbh->prepare("UPDATE users SET $key=\"".$globals{$key}."\" WHERE username=\"$username\"");
			$sth->execute || &cgi_error("save: sth->execute error: $DBI::errstr");
			$sth->finish;
		}
	}
	
	&dumphtml("templates/account/editsaved.tmpl");
	&finish;
}

sub	handle_errormessage {
	return &tline(@_, $errormessage);
}

sub	handle_form {
	return &tline(@_, $globals{$_[0]});
}

sub	db_init {
	my $dbserver=$config{"dbserver"};
	my $dbname=$config{"dbname"};
	my $dbuser=$config{"dbuser"};
	my $dbpass=$config{"dbpass"};

	$dbh=DBI->connect("DBI:mysql:database=$dbname;host=$dbserver", $dbuser, $dbpass, {RaiseError=>0}) || &cgi_error("Unable to connect to database $dbname on host $dbserver: $DBI::errstr");
}

sub	init {
	my $key;

	&sethook(\&template_print_hook);

	&add_global("action");

	foreach $key (keys(%form)) {
		&add_global($key);
		&add_handler($key, \&handle_form);
	}
	
	&add_handler("errormessage", \&handle_errormessage);

	&add_action("default", \&ac_default);
	&add_action("main", \&ac_main);
	&add_action("login", \&ac_login);
	&add_action("edit", \&ac_edit);
	&add_action("editsave", \&ac_editsave);
	
	&template_init($query);	
	&get_globals($query);
	
	&cgi_error("Error loading configuration!") if(&load_config("maskurl.conf")==0); 
}

## main routine
&init;
&action_handler($globals{"action"});

#-------------------------------------------------------------------------------
# ChangeLog
# =========
# $Log: account.cgi,v $
# Revision 1.2  2000/01/16 18:33:51  madcat
# Added a check for spaces and illegal characters in the username.
#
# Revision 1.1  2000/01/16 15:54:11  madcat
# Initial revision
#
#
#-------------------------------------------------------------------------------
