#!/usr/bin/perl
#-------------------------------------------------------------------------------
# $Id: mask.cgi,v 1.2 2000/01/16 18:32:45 madcat Exp $
#-------------------------------------------------------------------------------
#
# mask.cgi
#
# the actual URL masker, all the info will be passed in the QUERY_STRING variable
# in the CGI script. The item between the first / and second / is the user ID,
# if there is extra pathinfo this will be appended to the original URL saved
# in the database.
#
#-------------------------------------------------------------------------------
# This script is (c) 2000 PerlCoders PTY. Unauthorised use, duplication
# and distribution is prohibited by international copyright law. 
#-------------------------------------------------------------------------------
# Script Author: MadCat <madcat@gatekeeper.cistron.nl>
#-------------------------------------------------------------------------------
use DBI;
use Configuration;

sub	error {
	my ($message)=@_;
	
	print<<"EOT";
Content-Type: text/plain

PerlCoders MaskUrl
--------------------

$message
EOT
	exit(0);
}

&error("Error loading \"maskurl.conf\". Please notify the administrator.") if(&load_config("maskurl.conf")==0); 

$dbserver=$config{"dbserver"};
$dbname=$config{"dbname"};
$dbuser=$config{"dbuser"};
$dbpass=$config{"dbpass"};
$non_exist_url=$config{"non_exist_redir"};

$req_location=$ENV{"QUERY_STRING"};

# we know that this should have been redirected either as:
# username 	- plain username
# username/	- plain username as well
# username/...  - username with extra info

$req_location=~/^(.*?)\/(.*)/;
$userid=$1;
$extrapath=$2;
	
$dbh=DBI->connect("DBI:mysql:database=$dbname;host=$dbserver", $dbuser, $dbpass, {RaiseError=>0}) || &error("Unable to connect to database $dbname on host $dbserver: $DBI::errstr");

$sth=$dbh->prepare("SELECT * FROM users WHERE username=\"$userid\"");

$sth->execute;
$result=$sth->fetchrow_hashref;

if($result->{'username'} eq undef) {
 	$sth->finish;
 	$dbh->disconnect;
 	print("Location: $non_exist_url\n\n");
 	exit(0);
}

$url=$result->{'siteurl'};
$title=$result->{'siteitle'};
$keywords=$result->{'sitekeywords'};
$description=$result->{'sitedescription'};

$maskframeurl=$config{"mask_frame_url"};
$maskframesize=$config{"mask_frame_size"};

$sth->finish;
$dbh->disconnect;

if($extrapath ne undef) {
	$url.=$extrapath;
}

print<<"EOT";
Content-Type: text/html

<HTML>
<HEAD>
<TITLE>$title</TITLE>
<META NAME="keywords" CONTENT="$keywords">
<META NAME="description" CONTENT="$description">
</HEAD>
<FRAMESET ROWS="*,$maskframesize" BORDER="0" FRAMEBORDER="0" FRAMESPACING="0" FRAMECOLOR="#000000">
<FRAME SRC="$url" FRAMEBORDER="0" NORESIZE SCROLLING="AUTO" NAME="_userframe">
<FRAME SRC="$maskframeurl" FRAMEBORDER="0" NORESIZE SCROLLING="NO" MARGINWIDTH="0" MARGINHEIGHT="0" NAME="_maskframe">
<NOFRAMES>
<BODY>
<!-- 
 PerlCoders MaskURL (c) 2000 PerlCoders PTY
 http://perlcoders.com/
-->
$description
<BR>
<BR>
<A HREF="$url">Click here to continue</A>
</BODY>
</NOFRAMES>
</FRAMESET>
</HTML>
EOT

exit(0);

#-------------------------------------------------------------------------------
# ChangeLog
# =========
# $Log: mask.cgi,v $
# Revision 1.2  2000/01/16 18:32:45  madcat
# Cleaned up the HTML a bit
#
# Revision 1.1  2000/01/16 02:19:58  madcat
# Initial revision
#
#
#-------------------------------------------------------------------------------
