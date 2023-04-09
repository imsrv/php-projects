#!/usr/bin/perl
#-------------------------------------------------------------------------------
# $Id: new.cgi,v 1.4 2000/01/16 18:58:52 madcat Exp madcat $
#-------------------------------------------------------------------------------
#
# new.cgi
#
# Handles new user signups
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
	&dumphtml("templates/new/error.tmpl");
	exit(0);
}

sub	ac_default {
	&dumphtml("templates/new/intro.tmpl");
	exit(0);
}

sub	ac_signup {
	&dumphtml("templates/new/signup.tmpl");
	exit(0);
}

sub	ac_save {
	my $sth;
	my $error=0;
	my $result;
	my $dbserver=$config{"dbserver"};
	my $dbname=$config{"dbname"};
	my $dbuser=$config{"dbuser"};
	my $dbpass=$config{"dbpass"};
	# do save here


	$dbh=DBI->connect("DBI:mysql:database=$dbname;host=$dbserver", $dbuser, $dbpass, {RaiseError=>0}) || &cgi_error("Unable to connect to database $dbname on host $dbserver: $DBI::errstr");

	$sth=$dbh->prepare(q{
SELECT * FROM users WHERE username="?"
});

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
		$dbh->disconnect;
		&dumphtml("templates/new/signup_error.tmpl");
		exit(0);
	}

	$error=0;	
	$errormessage="";	

	$sth->execute($globals{"username"});

	if($sth->rows>0) {
		$error=1;
		$errormessage.="<li> Username ".$globals{"username"}." already exists!\n";
	}
	
	$sth->finish;
	
	if($error==1) {
		$dbh->disconnect;	
		&dumphtml("templates/new/signup_error.tmpl");
		exit(0);
	}

	# fix up the url and make it end with a /
	$globals{"siteurl"}.="/" if(substr(-1, $globals{"siteurl"} ne "/"));

	$sth=$dbh->prepare(q{
INSERT INTO users VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)
});
	
	$sth->execute($globals{'username'}, $globals{'password'}, $globals{'sitetitle'}, $globals{'sitedescription'}, $globals{'sitekeywords'}, $globals{'siteurl'}, $globals{'email'}) || &cgi_error("Error saving data to database: $DBI::errstr");
	
	$sth->finish;
	
	$sth=$dbh->prepare(q{
SELECT * FROM users WHERE id IS NULL
});
	$sth->execute;
	$result=$sth->fetchrow_hashref;
	$userid=$result->{'id'};
	$sth->finish;
	$dbh->disconnect;
		
	&dumphtml("templates/new/complete.tmpl");
	exit(0);	
}

sub	handle_form {
	return &tline(@_, $globals{$_[0]});
}

sub	handle_errormessage {
	return &tline(@_, $errormessage);
}

sub	handle_editlink {
	my $scripturl=$config{"scripturl"};
	
	$scripturl.="/account.cgi";
	return &tline(@_, $scripturl);
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
	&add_handler("editlink", \&handle_editlink);

	&add_action("default", \&ac_default);
	&add_action("signup", \&ac_signup);
	&add_action("save", \&ac_save);
	
	&template_init($query);	
	&get_globals($query);
	
	&cgi_error("Error loading configuration!") if(&load_config("maskurl.conf")==0); 
}


# main routine
&init;
&action_handler($globals{"action"});

#-------------------------------------------------------------------------------
# ChangeLog
# =========
# $Log: new.cgi,v $
# Revision 1.4  2000/01/16 18:58:52  madcat
# Fixed handle_editlink() to point to account.cgi instead of edit.cgi
#
# Revision 1.3  2000/01/16 18:29:15  madcat
# Added a check for spaces and illegal characters in the username
#
# Revision 1.2  2000/01/16 02:52:58  madcat
# Fixed SQL syntax, reversed order of checks on form fields,
# various cosmetic bugs worked away and changed order of
# database fields.
#
# Revision 1.1  2000/01/16 02:20:13  madcat
# Initial revision
#
#
#-------------------------------------------------------------------------------
