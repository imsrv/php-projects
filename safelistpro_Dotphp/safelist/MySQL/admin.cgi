#!/usr/bin/perl
#########################################################
#     SafeList - A full pay to join Opt in mail site    #
#########################################################
#                                                       #
#                                                       #
# This script was created by:                           #
#                                                       #
# PerlCoders Web Development Division.                  #
# http://www.perlcoders.com/                            #
#                                                       #
# This script and all included modules, lists or        #
# images, documentation are copyright 2001              #
# PerlCoders (http://perlcoders.com) unless             #
# otherwise stated in the module.                       #
#                                                       #
# Purchasers are granted rights to use this script      #
# on any site they own. There is no individual site     #
# license needed per site.                              #
#                                                       #
# Any copying, distribution, modification with          #
# intent to distribute as new code will result          #
# in immediate loss of your rights to use this          #
# program as well as possible legal action.             #
#                                                       #
# This and many other fine scripts are available at     #
# the above website or by emailing the authors at       #
# staff@perlcoders.com or info@perlcoders.com           #
#                                                       #
#########################################################

use CGI ':cgi';
use Configs;
use Locking;
use Fcntl qw(:flock); 
use DBI;

$action=param('action');
$pass=param('p');
$ref=param('ref');
$scripturl=$scriptdirurl."/admin.cgi";
 $dbh=DBI->connect("DBI:mysql:database=$dbname;hostname=$dbhost", $dbuser, $dbpass, {RaiseError=>1}) or sqldie("$DBI::errstr");


	
	# see what we do now
	if($action eq "main") { &main; }
	elsif($action eq "add") { &add; }
        elsif($action eq "view") { &view; }
	elsif($action eq "add_process") { &add_process; }
	elsif($action eq "mod") { &mod; }
	elsif($action eq "mod_process") { &mod_process; }
	elsif($action eq "del") { &del; }
	elsif($action eq "val") { &validate; }
	else { &login; }

sub main {
if($pass ne $admin_pass) { &badpass; }
	$howmany=0;
	$sth=$dbh->prepare("SELECT * FROM users");
	$sth->execute; 
        $res=$sth->fetchrow_hashref;

	  while($res->{'ID'} ne undef) { 
		  $howmany++;   
		  $res=$sth->fetchrow_hashref;
	  }

	open(PAGE, "templates/admin/main.html");
	chomp(@page=<PAGE>);
	close(PAGE);
	$page_html=join("\n", @page);
	$page_html =~ s/%scripturl%/$scripturl/gi;
	$page_html =~ s/%pass%/$pass/gi;
	$page_html =~ s/%howmany%/$howmany/gi;
	print "Content-type: text/html\n\n";
	print "$page_html\n";
	exit;
}
sub view {
if($pass ne $admin_pass) { &badpass; }
	$howmany=0;
	$sth=$dbh->prepare("SELECT * FROM users");
	$sth->execute; 
        $res=$sth->fetchrow_hashref;

	  while($res->{'ID'} ne undef) { 
		  $howmany++;   
		  $res=$sth->fetchrow_hashref;
	  }
	$output="<table cellpadding=2 cellspacing=2>\n";
	$output.="<tr>\n";
	$output.="<td><font size=-1><b>User</b></font></td>\n";
	$output.="<td><font size=-1><b>Name</b></font></td>\n";
	$output.="<td><font size=-1><b>Status</b></font></td>\n";
	$output.="<td><font size=-1><b>Actions</b></font></td>\n";
	$output.="</tr>\n";
	$sth=$dbh->prepare("SELECT * FROM users");
	$sth->execute; 
        $res=$sth->fetchrow_hashref;

	  while($res->{'ID'} ne undef) {
                $iname = $res->{'Iname'}; 
                $iemail = $res->{'Iemail'};
                $ilogin = $res->{'Ilogin'};
                $ipass = $res->{'Ipass'};
                $status = $res->{'Status'};
                $dayjoined = $res->{'Dayjoined'};
		$realstatus="";
		
		if($status eq "1") { $realstatus="Active"; } else { $realstatus="InActive"; }
		$output.="<tr>\n";
		$output.="<td><font size=-1>$ilogin</font></td>\n";
		$output.="<td><font size=-1>$iname</font></td>\n";
		$output.="<td><font size=-1>$realstatus</font></td>\n";
		$output.="<td><a href=\"mailto:$iemail\"><font size=-1>mail</font></a> 	<a href=$scripturl?p=$pass&action=mod&who=$ilogin><font size=-1>modify</font></a>  <a href=$scripturl?p=$pass&action=del&who=$ilogin><font size=-1>delete</font></a></td>\n";
		$output.="</tr>\n";
                $res=$sth->fetchrow_hashref;
	}
	$output.="</table>\n";
	open(PAGE, "templates/admin/view.html");
	chomp(@page=<PAGE>);
	close(PAGE);
	$page_html=join("\n", @page);
	$page_html =~ s/%scripturl%/$scripturl/gi;
	$page_html =~ s/%pass%/$pass/gi;
	$page_html =~ s/%output%/$output/gi;
	$page_html =~ s/%howmany%/$howmany/gi; 
	print "Content-type: text/html\n\n";
	print "$page_html\n";
	exit;
}
sub add {
if($pass ne $admin_pass) { &badpass; }
	open(PAGE, "templates/admin/adduser.html");
	chomp(@page=<PAGE>);
	close(PAGE);
	$page_html=join("\n", @page);
	$page_html =~ s/%scripturl%/$scripturl/gi;
	$page_html =~ s/%pass%/$pass/gi;
	print "Content-type: text/html\n\n";
	print "$page_html\n";
	exit;
}
sub add_process {
if($pass ne $admin_pass) { &badpass; }
	$zname=param('iname');
	$zemail=param('iemail');
	$zlogin=param('ilogin');
	$zpass=param('ipass');
	$zstatus=param('status');
	$zdayjoined=param('dayjoined');
 
	  $sth=$dbh->prepare("SELECT Ilogin from users WHERE Ilogin=\"$zlogin\"");
	  $sth->execute; $res=$sth->fetchrow_hashref;

		  if($res->{'Ilogin'}) {$response .= "The username $zlogin is already taken.<br>\n";}

	  $sth=$dbh->prepare("SELECT Iemail from users WHERE Iemail=\"$zemail\"");
	  $sth->execute; $res=$sth->fetchrow_hashref;   

		  if($res->{'Iemail'}) {$response .= "That Email is already in our databases.<br>\n";}

	  $sth=$dbh->prepare("SELECT Ilogin from holding WHERE Ilogin=\"$zlogin\"");
	  $sth->execute; $res=$sth->fetchrow_hashref;

		  if($res->{'Ilogin'}) {$response .= "The username $zlogin is already taken.<br>\n";}

	  $sth=$dbh->prepare("SELECT Iemail from holding WHERE Iemail=\"$zemail\"");
	  $sth->execute; $res=$sth->fetchrow_hashref;   

		  if($res->{'Iemail'}) {$response .= "That Email is already in our databases.<br>\n";} 
 
	if($response ne "") {
		open(PAGE, "templates/admin/error.html");
		chomp(@page=<PAGE>);
		close(PAGE);
		$page_html=join("\n", @page);
		$page_html =~ s/%scripturl%/$scripturl/gi;
		$page_html =~ s/%pass%/$pass/gi;
		$page_html =~ s/%reason%/$response/gi;
		print "Content-type: text/html\n\n";
		print "$page_html\n";
		exit;
	} else {
		$dyj=(localtime)[3];

	$sth=$dbh->prepare("INSERT into users VALUES(\"\", \"$zname\", \"$zemail\", \"$zlogin\", \"$zpass\", \"$zstatus\", \"$dyj\")");
	$sth->execute; 
   
		print "Location: $scripturl?action=view&p=$pass\n\n";
		exit;
	}
}
sub mod {
if($pass ne $admin_pass) { &badpass; }
	$who=param('who');
  $sth=$dbh->prepare("SELECT * from users WHERE Ilogin=\"$who\"");
  $sth->execute; $res=$sth->fetchrow_hashref;
  if($res->{'Ilogin'}) {
  $setid = $res->{'ID'};
  $iname = $res->{'Iname'}; 
  $iemail = $res->{'Iemail'};
  $ilogin = $res->{'Ilogin'};
  $ipass = $res->{'Ipass'};
  $status = $res->{'Status'};
  $dayjoined = $res->{'Dayjoined'}; 

			if($status eq "1") { $rstatus="Active"; } else { $rstatus="Inactive"; }
			$output.="<form action=$scripturl method=POST>\n";
			$output.="<input type=hidden name=action value=mod_process>\n";
			$output.="<input type=hidden name=p value=$pass>\n";
			$output.="<input type=hidden name=who value=$who>\n";
			$output.="<table>\n";
			$output.="<tr><td>Real Name</td><td><input type=text name=iname value=\"$iname\"></td></tr>\n";
			$output.="<tr><td>Email Address</td><td><input type=text name=iemail value=\"$iemail\"></td></tr>\n";
			$output.="<tr><td>Username</td><td>$ilogin</td></tr>\n";
			$output.="<tr><td>Password</td><td><input type=text name=ipass value=\"$ipass\"></td></tr>\n";
			$output.="<tr><td>Status</td><td><select name=status><option value=\"$status\"> $rstatus </option><option value=\"0\"> Inactive </option><option value=\"1\"> Active </option></select></td></tr>\n";
			$output.="</table><br><br>\n";
			$output.="<input type=submit value=\"Modify Info\">\n";
			$output.="</form>\n";
			open(PAGE, "templates/admin/modify.html");
			chomp(@page=<PAGE>);
			close(PAGE);
			$page_html=join("\n", @page);
			$page_html =~ s/%scripturl%/$scripturl/gi;
			$page_html =~ s/%pass%/$pass/gi;
			$page_html =~ s/%output%/$output/gi;
			print "Content-type: text/html\n\n";
			print "$page_html\n";
			exit;
		
	}
}
sub mod_process {
if($pass ne $admin_pass) { &badpass; }
	$who=param('who');
	$zname=param('iname');
	$zemail=param('iemail');
	$zpass=param('ipass');
	$zstatus=param('status');
$sth=$dbh->prepare("UPDATE users SET Ipass=\"$zpass\",Status=\"$zstatus\",Iemail=\"$zemail\",Iname=\"$zname\" WHERE Ilogin=\"$who\"");
$sth->execute; 

        #dump out the email list to file
        $sth=$dbh->prepare("SELECT Iemail FROM users");
        $sth->execute;
        open MAIL, ">all_mails.txt";
        ($email)=$sth->fetchrow_array;
        while ($email) {
                print MAIL "$email\n";
                ($email)=$sth->fetchrow_array;
        };
        close MAIL;

	print "Location: $scripturl?action=view&p=$pass\n\n";
	exit;
}
sub del {
if($pass ne $admin_pass) { &badpass; }
	$who=param('who');
 
                $sth=$dbh->prepare("DELETE FROM users WHERE Ilogin=\"$who\"") or sqldie("$DBI::errstr");
                $sth->execute;  

	print "Location: $scripturl?action=view&p=$pass\n\n";
	exit;
}
sub login {
	open(PAGE, "templates/admin/login.html");
	chomp(@page=<PAGE>);
	close(PAGE);
	$page_html=join("\n", @page);
	$page_html =~ s/%scripturl%/$scripturl/gi;
	print "Content-type: text/html\n\n";
	print "$page_html\n";
	exit;
}
sub validate {

if($pass ne $admin_pass) { &badpass; }
  $sth=$dbh->prepare("SELECT * from holding WHERE OwnerID=\"$ref\"");
  $sth->execute; $res=$sth->fetchrow_hashref;

  if($res->{'OwnerID'}) {
  $id = $res->{'OwnerID'};
  $setid = $res->{'ID'};
  $iname = $res->{'Iname'}; 
  $iemail = $res->{'Iemail'};
  $ilogin = $res->{'Ilogin'};
  $ipass = $res->{'Ipass'};
  $status = $res->{'Status'};
  $dayjoined = $res->{'Dayjoined'}; 

			$set_found=1;

	$sth=$dbh->prepare("INSERT into users VALUES(\"\", \"$iname\", \"$iemail\", \"$ilogin\", \"$ipass\", \"1\", \"$dayjoined\")");
	$sth->execute; 
              
				open(OUT5, "+<$scriptdir/all_mails.txt");
				flock(OUT5, LOCK_EX);
                                @list_it = <OUT5>;
                                $ct1 = grep(/$iemail/, @list_it);
                                if ($ct1 < 1) {print OUT5 "$iemail\n";}
				close(OUT5);
			#mail user
			$ua_url="$scripturl/user.cgi";
			open(IN2, "templates/mail/user_validated.txt");
			chomp(@in2=<IN2>);
			close(IN2);
			$mail_body=join("\n", @in2);
			$mail_body =~ s/%name%/$iname/gi;
			$mail_body =~ s/%email%/$iemail/gi;
			$mail_body =~ s/%username%/$ilogin/gi;
			$mail_body =~ s/%password%/$ipass/gi;
			$mail_body =~ s/%userpage%/$ua_url/gi;

			open(MAIL, "|$sendmail -t");
			print MAIL<<"EOT";
From: $mail_from
To: $iemail
Subject: Congratulations!


$mail_body

EOT
			close(MAIL);
      }
	# remove this entry from holding dbase

                $sth=$dbh->prepare("DELETE FROM holding WHERE OwnerID=\"$ref\"");
                $sth->execute;   

	if($set_found eq "1") {
		open(PAGE, "templates/admin/aval_success.html");
		chomp(@page=<PAGE>);
		close(PAGE);
		$page_html=join("\n", @page);
		$page_html =~ s/%name%/$iname/gi;
		$page_html =~ s/%email%/$iemail/gi;
		$page_html =~ s/%username%/$ilogin/gi;
		$page_html =~ s/%password%/$ipass/gi;
		$page_html =~ s/%useradmin%/$ua_url/gi;
		$page_html =~ s/%userpage%/$up_url/gi;
		print "Content-type: text/html\n\n";
		print "$page_html\n";
		exit;
	} else {
		open(PAGE, "templates/admin/aval_failure.html");
		chomp(@page=<PAGE>);
		close(PAGE);
		$page_html=join("\n", @page);
		$page_html =~ s/%ref%/$ref/gi;
		print "Content-type: text/html\n\n";
		print "$page_html\n";
		exit;
	}
	exit;
}
sub badpass {
	open(PAGE, "templates/admin/admin_badpass.html");
	chomp(@page=<PAGE>);
	close(PAGE);
	$page_html=join("\n", @page);
	$page_html =~ s/%ref%/$ref/gi;
	print "Content-type: text/html\n\n";
	print "$page_html\n";
	exit;
}

sub sqldie {
  $error = $_[0];
  print "Content-type: text/html\n\n";
  print qq~ ERROR: $error
  ~;
  exit;
}

1;
