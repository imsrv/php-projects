#!/usr/bin/perl

###############################################################
#                                                             #
# Any use of this program is entirely at the risk of the      #
# user. No liability will be accepted by the author.          #
#                                                             #
# This code must not be sold, even in modified form, without  #
# the written permission of the author. This code must also   #
# not be distributed without the permission of the author.    #
#                                                             #
###############################################################

###############################################################
#                                                             #
# Nothing below needs to be modified. You can apply           #
# modifications if you know what you are doing. Remember that #
# all credits must remain intact.                             #
#                                                             #
###############################################################

# Locate and load required files
eval {
	# Get the script location (for UNIX and Windows)
	($0 =~ m,(.*)/[^/]+,)   && unshift (@INC, "$1");

	# Get the script location (for Windows)
	($0 =~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1");

	# Load files
	require "settings.cgi";
	require "common.sub";
	require "variables.sub";
	require "memb.sub";
	require "templates.sub";
};

# Read the form
&readform;

# Determine what part of the script we need
if ($FORM{'action'} eq "logincheck") {
	&logincheck;
} elsif ($FORM{'action'} eq "password") {
	&password;
} elsif ($FORM{'action'} eq "applypass") {
	&applypass;
} elsif ($FORM{'action'}) {
	&login;
}

# Check if administrative password has been set
&setpass if -z "adminpass.cgi";

if (-e "$membpath/memblist.cgi") {

	# Read in members list
	&readmembers;

	# Get the number of registered members
	$regmembers = scalar(@members);
} else {
	$regmembers = 0;
}

# Show administrative menu
print "Content-type:text/html\n\n";
print <<EOH;
<html>
<head>
<title>RankMaster Administrative Menu</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#F4F4FF" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<div align="center">
  <h3><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>RankMaster 
    Administrative Menu</b></font></h3>
  <table width="600" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td bgcolor="#000000">
        <table width="100%" border="0" cellspacing="1" cellpadding="5">
          <tr> 
            <td bgcolor="#F4F4FF"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b><a href="admin.cgi?action=variables" target="_blank">Configure 
              Script Variables</a></b></font></td>
          </tr>
          <tr> 
            <td bgcolor="#E8E8FF"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b><a href="admin.cgi?action=members" target="_blank">Manage 
              Members</a></b> <font size="-2">(Registered members: $regmembers)</font></font></td>
          </tr>
          <tr> 
            <td bgcolor="#F4F4FF"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b><a href="admin.cgi?action=templates" target="_blank">Template 
              Editor</a></b></font></td>
          </tr>
          <tr> 
            <td bgcolor="#E8E8FF"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b><a href="admin.cgi?action=password" target="_blank">Change 
              Administrative Password</a></b></font></td>
          </tr>
          <tr> 
            <td bgcolor="#F4F4FF"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b><a href="$scripturl/index.cgi" target="_blank">My 
              RankMaster</a></b></font></td>
          </tr>
          <tr> 
            <td bgcolor="#E8E8FF"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b><a href="http://scripts.21stcenturyhost.net/rm/faq.htm" target="_blank">RankMaster 
              FAQ</a></b></font></td>
          </tr>
          <tr> 
            <td bgcolor="#F4F4FF"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b><a href="http://scripts.21stcenturyhost.net/forums/cgi/Ultimate.cgi" target="_blank">RankMaster 
              Support Forums</a></b></font></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <br>
  <font face="Arial, Helvetica, sans-serif" size="-2"><a href="http://scripts.21stcenturyhost.net" target="_blank">Powered 
  by 21stCenturyScripts</a></font></div>
</body>
</html>
EOH
exit;


########################### SUBROUTINES ###########################


sub login {

	# Check the admin cookie
	&checkcookie;

	# Skip login screen if cookie is set
	if ($cookie{'rmadminpass'}) {
		$FORM{'display'}   = $FORM{'action'};
		$FORM{'adminpass'} = $cookie{'rmadminpass'};
		&logincheck;
	}

	# Display the Admin Login form
	print "Content-type: text/html\n\n";
	print <<EOH;
<html>
<head>
<title>RankMaster Admin Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#F4F4FF" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<div align="center">
  <h3><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Administrative 
    Password Required</b></font></h3>
  <form method="post" action="admin.cgi">
    <input type="hidden" name="action" value="logincheck">
    <input type="hidden" name="display" value="$FORM{'action'}">
    <table width="500" border="0" cellspacing="0" cellpadding="0">
      <tr> 
        <td bgcolor="#000000"> 
          <table width="100%" border="0" cellspacing="1" cellpadding="5">
            <tr> 
              <td bgcolor="#E8E8FF">
                <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><br>
                  Enter the administrative password below to proceed:</font><br>
                  <br>
                  <input type="password" name="adminpass" size="25" maxlength="15">
                  <input type="submit" name="submit" value="Proceed">
                  <br>
                  <br>
                </div>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </form>
  <font face="Arial, Helvetica, sans-serif" size="-2"><a href="http://scripts.21stcenturyhost.net" target="_blank">Powered 
  by 21stCenturyScripts</a></font></div>
</body>
</html>
EOH
	exit;
}


sub logincheck {

	# Check the admin password
	if ($FORM{'adminpass'} eq "" or $FORM{'adminpass'} =~ /\W/ or $FORM{'adminpass'} =~ /\s/) {
		push(@badfields, "You did not enter a valid admin password.");
		&adminerror;
	}

	# Read admin password
	open(PASS,"adminpass.cgi") || err("Could not open adminpass.cgi: $!");
	$adminpass = <PASS>;
	close(PASS);

	# Check admin password
	unless (crypt($FORM{'adminpass'}, "ad") eq $adminpass) {

		# Reset admin cookie
		print "Set-Cookie: rmadminpass=\n";

		# Show error
		push(@badfields, "The admin password that you entered is incorrect.");
		&adminerror;
	}

	# Set admin cookie
	print "Set-Cookie: rmadminpass=$FORM{'adminpass'}\n";

	# Determine which part of the script we need
	if ($FORM{'display'} eq "variables") {
		&variables;
	} elsif ($FORM{'display'} eq "savevariables") {
		&savevariables;
	} elsif ($FORM{'display'} eq "members") {
		&members;
	} elsif ($FORM{'display'} eq "membmanage") {
		&membmanage;
	} elsif ($FORM{'display'} eq "templates") {
		&templates;
	} elsif ($FORM{'display'} eq "tempselect") {
		&tempselect;
	} elsif ($FORM{'display'} eq "tempsave") {
		&tempsave;
	}

	exit;
}


# Set default administrative password
sub setpass {
	$newpass = "admin";
	open(PASS,">adminpass.cgi") || err("Could not open adminpass.cgi: $!");
	flock(PASS,2);
	seek(PASS,0,0);
	print PASS crypt($newpass, "ad");
	close(PASS);
	&adminconfirm("The administrative password has been set to <i>admin</i>", 
		 "Continue to Administrative Area", "admin.cgi");
}


# Change administrative password
sub password {

	# Check referring URL
	&urlcheck;

	# Check the admin cookie
	&checkcookie;

	# Display the Change Admin Password form
	print "Content-type: text/html\n\n";
	print <<EOH;
<html>
<head>
<title>RankMaster: Change Administrative Password</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#F4F4FF" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<div align="center">
  <h3><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>RankMaster: 
    Change Administrative Password</b></font></h3>
  <form method="post" action="admin.cgi">
    <input type="hidden" name="action" value="applypass">
    <table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr> 
        <td bgcolor="#000000"> 
          <table width="100%" border="0" cellspacing="1" cellpadding="5">
            <tr> 
              <td bgcolor="#F4E8EF" colspan="2"> <font face="Verdana, Arial, Helvetica, sans-serif" size="-2">Complete 
                all fields below to change your current administrative password.</font></td>
            </tr>
            <tr bgcolor="#F4F4FF"> 
              <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"> 
                Enter your current administrative password:</font></b></td>
              <td> 
                <input type="password" name="oldadminpass" size="25" maxlength="15" value="$cookie{'rmadminpass'}">
              </td>
            </tr>
            <tr bgcolor="#E8E8FF"> 
              <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"> 
                Enter the new administrative password:</font></b></td>
              <td> 
                <input type="password" name="newadminpass" size="25" maxlength="15">
              </td>
            </tr>
            <tr bgcolor="#F4F4FF"> 
              <td><b><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Enter 
                the new administrative password again to confirm:</font></b></td>
              <td>
                <input type="password" name="newadminpass2" size="25" maxlength="15">
              </td>
            </tr>
            <tr bgcolor="#E8E8FF"> 
              <td colspan="2" bgcolor="#F4E8EF"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2">Click 
                the &quot;Submit Changes&quot; button to save new password.</font></td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <br>
    <input type="submit" name="submit" value="Submit Changes">
    <input type="button" name="close" value="Close This Window" onClick="self.close()">
    <br>
  </form>
  <font face="Arial, Helvetica, sans-serif" size="-2"><a href="http://scripts.21stcenturyhost.net" target="_blank">Powered 
  by 21st Century Scripts</a></font></div>
</body>
</html>
EOH
	exit;
}


# Save new administrative password
sub applypass {

	# Check referring URL
	&urlcheck;

	# Check form fields
	if ($FORM{'oldadminpass'} eq "" or $FORM{'oldadminpass'} =~ /\W/ or $FORM{'oldadminpass'} =~ /\s/) {
		push(@badfields, "The current admin password that you entered is incorrect.");
	}

	if ($FORM{'newadminpass'} eq "" or $FORM{'newadminpass'} =~ /\W/ or $FORM{'newadminpass'} =~ /\s/) {
		push(@badfields, "The new admin password is invalid. Must be alphanumeric with no spaces.");
	}

	unless ($FORM{'newadminpass'} eq $FORM{'newadminpass2'}) {
		push(@badfields, "Your first and second entries of new password don't match. Please try again.");
	}

	# Show errors if any
	&adminerror;

	# Read admin password
	open(PASS,"$path/adminpass.cgi") || err("Could not open $path/adminpass.cgi: $!");
	$curpass = <PASS>;
	close(PASS);

	# Check the current admin password
	unless (crypt($FORM{'oldadminpass'}, "ad") eq $curpass) {
		push(@badfields, "The current admin password that you entered is incorrect.");
		&adminerror;
	}

	# Save new admin password
	open(PASS,">$path/adminpass.cgi") || err("Could not update $path/adminpass.cgi: $!");
	flock(PASS,2);
	seek(PASS,0,0);
	print PASS crypt($FORM{'newadminpass'}, "ad");
	close(PASS);

	# Save new admin password as cookie
	print "Set-Cookie: rmadminpass=$FORM{'newadminpass'}\n";

	# Display success screen
	&adminconfirm("The new administrative password has been saved!");
}


# Admin Update Confirmation
sub adminconfirm {

	# Localize incoming message
	my(@msg) = @_;

	# Display update confirmation
	print "Content-type:text/html\n\n";
	print <<EOH;
<html>
<head>
<title>RankMaster Admin Confirmation</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#F4F4FF" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<div align="center">
  <h3><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>RankMaster Admin Confirmation</b></font></h3>
  <table width="500" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td bgcolor="#000000"> 
        <table width="100%" border="0" cellspacing="1" cellpadding="5">
          <tr> 
            <td bgcolor="#E8E8FF">
              <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><br>
                $msg[0]<br>
                <br>
EOH

	for ($i = 1; $i < scalar(@msg); $i += 2) {
		print "          <a href=\"$msg[$i+1]\">$msg[$i]</a><br>\n          <br>";
	}

	print <<EOH;
                <a href="javascript:close();">Close this window</a><br>
                <br>
                </font></div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <font face="Arial, Helvetica, sans-serif" size="-2"><a href="http://scripts.21stcenturyhost.net" target="_blank"><br>
  Powered by 21st Century Scripts</a></font></div>
</body>
</html>
EOH
	exit;
}


# Admin submission errors display
sub adminerror {

	# Show submission errors
	if (scalar(@badfields) > 0) {
		print "Content-type: text/html\n\n";
		print <<EOH;
<html>
<head>
<title>RankMaster Error!</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#F4F4FF" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<div align="center">
  <h3><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><b>Error: Your 
    Submission Was Not Accepted!</b></font></h3>
  <table width="500" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td bgcolor="#000000"> 
        <table width="100%" border="0" cellspacing="1" cellpadding="5">
          <tr> 
            <td bgcolor="#E8E8FF"> 
              <center>
                <font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><a href="javascript:history.go(-1)"><br>
                Click here</a> to go back and make appropriate changes</font><br>
              </center>
                  <ul>
EOH

		foreach $field(@badfields) {
			print "        <li><b><font face=\"Verdana, Arial, Helvetica, sans-serif\" size=\"-1\">$field</font></b></li>\n";
		}

	print <<EOH;
              </ul>
              <br>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <font face="Arial, Helvetica, sans-serif" size="-2"><a href="http://scripts.21stcenturyhost.net" target="_blank"><br>
  Powered by 21st Century Scripts</a></font></div>
</body>
</html>
EOH
		exit;
	}
}