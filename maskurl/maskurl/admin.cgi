#!/usr/bin/perl
#-------------------------------------------------------------------------------
# $Id: admin.cgi,v 1.2 2000/01/22 16:38:40 madcat Exp $
#-------------------------------------------------------------------------------
#
# admin.cgi
#
# Admin Script for MaskURL
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
	&dumphtml("templates/admin/error.tmpl");
	exit(0);
}

sub	finish {
	
	$dbh->disconnect if($dbh);
	exit(0);
}

sub	ac_default {
	if(-e "./adminpass.dat") {
		&dumphtml("templates/admin/login.tmpl");
	} else {
		&dumphtml("templates/admin/newpass.tmpl");
	}
	&finish;
}

sub	ac_login {
	my $fpass;
	
	open(FILE, "./adminpass.dat") || &cgi_error("Error opening adminpass.dat for read: $!");
	chomp($fpass=<FILE>);
	close(FILE);
	
	&cgi_error("Bad Password!") if($fpass ne $globals{"password"});
	&dumphtml("templates/admin/main.tmpl");
	&finish;
}

sub	ac_main {
	&dumphtml("templates/admin/main.tmpl");
	&finish;
}

sub	ac_newpass {
	
	&cgi_error("Passwords do not match!") if(($globals{"password"} eq undef) || ($globals{"password"} ne $globals{"password_vfy"}));
	open(FILE, ">./adminpass.dat") || &cgi_error("Error opening adminpass.dat for write: $!");
	print(FILE $globals{"password"}."\n");
	close(FILE);
	
	&dumphtml("templates/admin/login.tmpl");
	&finish;
}

sub	ac_deleteuser {
	
	&db_init;
	&dumphtml("templates/admin/deleteuser.tmpl");
	&finish;
}

sub	ac_delete_exec {
	my $id=$globals{"selectuser"};
	
	&db_init;

	$dbh->do("DELETE FROM users WHERE id=\"$id\"");
	
	&dumphtml("templates/admin/deleteuser.tmpl");
	&finish	;
}

sub	ac_edituser {

	&db_init;
	&dumphtml("templates/admin/edituser.tmpl");
	&finish;
}

sub	ac_edituser_exec {
	my $id=$globals{"selectuser"};
	my $key;
	my $res;
	
	&db_init;

	$sth=$dbh->prepare("SELECT * FROM users WHERE id=\"$id\"");
	$sth->execute || &cgi_error("edituser_exec: sth->execute error: $DBI::errstr");
	$res=$sth->fetchrow_hashref;
	
	foreach $key (keys(%form)) {
		$globals{$key}=$res->{$key};
	}
	
	$sth->finish;
	
	&dumphtml("templates/admin/edituser.tmpl");
	&finish;
}

sub	ac_editsave {
	my $username=$globals{"username"};
	my $sth;

	&db_init;
	
	foreach $key (keys(%form)) {
		if($key ne "password_vfy") {
			$sth=$dbh->prepare("UPDATE users SET $key=\"".$globals{$key}."\" WHERE username=\"$username\"");
			$sth->execute || &cgi_error("save: sth->execute error: $DBI::errstr");
			$sth->finish;
		}
	}
	
	&dumphtml("templates/admin/edituser.tmpl");
	&finish;
}

sub	ac_editconfig {
	
	&dumphtml("templates/admin/editconfig.tmpl");
	&finish;
}

sub	ac_configsave {
	my $key;
	
	foreach $key (keys(%config)) {
		$config{$key}=$globals{$key};
	}
	&cgi_error("Error saving configuration: $!") if(&save_config("maskurl.conf")==0);
	
	&dumphtml("templates/admin/editconfig.tmpl");
	&finish;
}

sub	ac_sendemails {
	my $sth;
	my $res;
	my $temp;
	my $from=$config{"from_addr"};
	my $to=$config{"to_addr"};
	my $mailprog=$config{"mailprog"};

	&db_init;

	$temp=<<"EOT";
From: $from
To: $to
Subject: E-Mail Address List

List of all users currently using MaskURL
-----------------------------------------
EOT
	
	$sth=$dbh->prepare("SELECT * FROM users");
	$sth->execute;
	$res=$sth->fetchrow_hashref;

	while($res->{'id'} ne undef) {
		$temp.=$res->{'email'}."\n";
		$res=$sth->fetchrow_hashref;
	}
	$sth->finish;
	
	open(MAIL, "|$mailprog -t");
	print(MAIL $temp);
	close(MAIL);
	
	&dumphtml("templates/admin/mailsent.tmpl");
	&finish;
}

sub	handle_errormessage {
	return &tline(@_, $errormessage);
}

sub	handle_userlist {
	my $sth;
	my $res;
	my $temp;
	my $id;
	my $username;
	my $userurl;

	$temp=<<"EOT";	
<select name="selectuser">
EOT
	
	# assume that $dbh is already initialised
	$sth=$dbh->prepare("SELECT * FROM users ORDER BY id DESC");
	$sth->execute;
	$res=$sth->fetchrow_hashref;
	
	while($res->{'id'} ne undef) {
		$id=$res->{'id'};
		$username=$res->{'username'};
		$userurl=$res->{'siteurl'};
	
		$temp.=<<"EOT";
<OPTION VALUE="$id"> $username: redirect to $userurl (ID# $id)
EOT
		$res=$sth->fetchrow_hashref;
	}
	$sth->finish;
	$temp.=<<"EOT";
</select>
EOT
	return &tline(@_, $temp);
}

sub	handle_form {
	return &tline(@_, $globals{$_[0]});
}

sub	handle_config {
	return &tline(@_, $config{$_[0]});
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
	&add_global("password");
	&add_global("password_vfy");
	&add_global("selectuser");

	foreach $key (keys(%form)) {
		&add_global($key);
		&add_handler($key, \&handle_form);
	}

	
	&add_handler("errormessage", \&handle_errormessage);
	&add_handler("userlist", \&handle_userlist);

	&add_action("default", \&ac_default);
	&add_action("login", \&ac_login);
	&add_action("main", \&ac_main);
	&add_action("newpass", \&ac_newpass);
	&add_action("deleteuser", \&ac_deleteuser);
	&add_action("delete_exec", \&ac_delete_exec);
	&add_action("edituser", \&ac_edituser);
	&add_action("edituser_exec", \&ac_edituser_exec);
	&add_action("editsave", \&ac_editsave);
	&add_action("editconfig", \&ac_editconfig);
	&add_action("configsave", \&ac_configsave);
	&add_action("sendmail", \&ac_sendemails);
	
	&template_init($query);	
	
	&cgi_error("Error loading configuration!") if(&load_config("maskurl.conf")==0); 
	
	foreach $key (keys(%config)) {
		&add_global($key);
		&add_handler($key, \&handle_config);
	}

	&get_globals($query);
}

## main routine
&init;
&action_handler($globals{"action"});

#-------------------------------------------------------------------------------
# ChangeLog
# =========
# $Log: admin.cgi,v $
# Revision 1.2  2000/01/22 16:38:40  madcat
# Added the ability to e-mail a list of all email addresses
# used by the users to the admin for e-mail address collection
# purposes.
#
# Revision 1.1  2000/01/16 18:26:07  madcat
# Initial revision
#
#
#-------------------------------------------------------------------------------
