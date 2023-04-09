#!/usr/bin/perl

# This script will handle the initial initialization steps for the message
# board.  It is NOT PASSWORD PROTECTED and should be removed after its
# initial run.
#
# ScareCrow (C)opyright 2001 Jonathan Bravata.
#
# This file is part of ScareCrow.
#
# ScareCrow is free software; you can redistribute it and/or modify it under
# the terms of the GNU General Public License as published by the Free
# Software Foundation; either version 2 of the License, or (at your option),
# any later version.
#
# ScareCrow is distributed in the hope that it will be useful, but WITHOUT
# ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
# FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
# more details.
#
# You should have received a copy of the GNU General Public License along
# with ScareCrow; if not, write to the Free Software Foundation, Inc.,
# 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
# Revision: April 2001

require 'global.cgi';

# Output the content headers
content();

# If the necessary directories aren't in existance, create them now.
if(!-d "data")     { 
  mkdir "data",0700;
  if(!$!) { print "<i>Data directory missing.  Created.</i><br>\n"; }
}
if(!-d "members")     { 
  mkdir "members",0700;
  if(!$!) { print "<i>Members directory missing.  Created.</i><br>\n"; }
}
if(!-d "logs")     { 
  mkdir "logs",0700;
  if(!$!) { print "<i>Log directory missing.  Created.</i><br>\n"; }
}
if(!-d "private")     { 
  mkdir "private",0700;
  if(!$!) { print "<i>Private messages directory missing.  Created.</i><br>\n"; }
}
if(!-d "lastread")     { 
  mkdir "lastread",0700;
  if(!$!) { print "<i>Last read directory missing.  Created.</i><br>\n"; }
}
if(!-d "templates")     { 
  mkdir "templates",0700;
  if(!$!) { print "<i>Templates directory missing.  Created.</i><br>\n"; }
}

$step = $Pairs{'step'};

####### Configuration Steps ##################################################
# Step 0 - Required path information; required configuration variables
# Step 1 - Creation of the first Administrator account.
#############################################################################

page_header("ScareCrow Message Board Installation");

if(!$step || $step == 0) {  step_zero();        }
elsif($step == 1)        {  step_one();         }
elsif($step == 2)        {  step_two();         }
elsif($step == 3)        {  step_three();       }
#elsif($step == 4)        {  save_step_three();  }
else                     {  step_zero();        }

page_footer();


sub step_zero {
  # Get the absolutely required information as far as paths go, right here.
  # Compile some defaults
  my $cgi_path = $ENV{'SCRIPT_FILENAME'};    $cgi_path =~ s/installer\.cgi//ig;
  my $noncgi_path = $cgi_path;   $noncgi_path =~ s/cgi\-bin(.+?)//ig;  $noncgi_path .= substr($2,1,length($2)) if $2;
  my @parts = split(/\//,$noncgi_path);  my $noncgi_dirname = $parts[$#parts]; 
  my $cookie_domain = '.' . $ENV{'SERVER_NAME'};
  
  my $website_url  = "http://" . $ENV{'SERVER_NAME'};
  my $board_url    = "http://" . $ENV{'SERVER_NAME'} . "/cgi-bin/" . $noncgi_dirname;
  my $noncgi_url   = "http://" . $ENV{'SERVER_NAME'} . '/' . $noncgi_dirname;

  # Print out the form
  print <<end;
    <table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="#BEBEBE"><tr><td>
      <form action="installer.cgi" method="post">
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <!-- Header: Configuration Options -->
	<tr bgcolor="#EEEEEE"><td colspan="2"><font face="Verdana" size="3"><b>&#187; Configuration Options</b></font></td></tr>
	<!-- Board name -->
	<tr bgcolor="#FFFFFF">
	  <td><font face="Verdana" size="2"><b>Message Board Name</b></font></td>
	  <td><input type="text" name="board_name" value=""></td>
	</tr>
	<!-- Website name -->
	<tr bgcolor="#FFFFFF">
	  <td><font face="Verdana" size="2"><b>Website Name</b></font></td>
	  <td><input type="text" name="website_name" value=""></td>
	</tr>
	<!-- Default table width -->
	<tr bgcolor="#FFFFFF">
	  <td><font face="Verdana" size="2"><b>Default Table Width (pixels or %)</b></font></td>
	  <td><input type="text" name="table_width" value="700"></td>
	</tr>
	<!-- Default User Account -->
	<tr bgcolor="#FFFFFF">
	  <td><font face="Verdana" size="2"><b>Default User Group</b></font><br><font face="Verdana" size="1">The group that new users are assigned to by default.</font></td>
	  <td><input type="text" name="default_user_group" value="Users"></td>
	</tr>
	<!-- Divider: Paths -->
	<tr bgcolor="#EEEEEE"><td colspan="2"><font face="Verdana" size="2"><b>&#187; Board Paths</b></font></td></tr>
	<tr bgcolor="#FFFFFF">
	  <td><font face="Verdana" size="2"><b>CGI Path</b></font><br><font face="Verdana" size="1">The full <i>system</i> path to the ScareCrow CGI directory.</font></td>
	  <td><input type="text" name="cgi_path" value="$cgi_path">
	</tr>
	<tr bgcolor="#FFFFFF">
	  <td><font face="Verdana" size="2"><b>Non-CGI Path</b></font><br><font face="Verdana" size="1">The full system path to the non-cgi directory.  Do <i>not</i> include any of the directory names: "emoticons", "avatars", "images" on the end of this path!</font></td>
	  <td><input type="text" name="noncgi_path" value="$noncgi_path">
	</tr>
	<tr bgcolor="#FFFFFF">
	  <td><font face="Verdana" size="2"><b>Board URL</b></font><br><font face="Verdana" size="1">The fully-qualified URL to your ScareCrow CGI directory.</font></td>
	  <td><input type="text" name="board_url" value="$board_url">
	</tr>
	<tr bgcolor="#FFFFFF">
	  <td><font face="Verdana" size="2"><b>Website URL</b></font><br><font face="Verdana" size="1">The fully-qualified URL to the host website of the message board.</font></td>
	  <td><input type="text" name="website_url" value="$website_url">
	</tr>
	<tr bgcolor="#FFFFFF">
	  <td><font face="Verdana" size="2"><b>Non-CGI URL</b></font><br><font face="Verdana" size="1">The fully-qualified URL to the ScareCrow non-CGI files such as emoticons.  Do <i>not</i> include any of the directory names: "emoticons", "avatars", "images" on the end of this URL!</font></td>
	  <td><input type="text" name="noncgi_url" value="$noncgi_url">
	</tr>
	<tr bgcolor="#FFFFFF">
	  <td><font face="Verdana" size="2"><b>Cookie Domain</b></font><br><font face="Verdana" size="1">The domain to send the cookie from.  This <i>must</i> be the same domain your account is run under.  It is recommended that you prefix this domain with a period if you do not operate under a subdomain.</font></td>
	  <td><input type="text" name="cookie_domain" value="$cookie_domain">
	</tr>
	<!-- Footer: Submit Button -->
	<tr bgcolor="#EEEEEE"><td colspan="2" align="center"><input type="submit" name="submit" value="Submit Configuration Changes"></td></tr>
      </table>
      <input type="hidden" name="step" value="1">
      </form>
    </td></tr></table>
end
}

sub save_step_zero {
  my $cgi_path = $Pairs{'cgi_path'};
  my $cookie_domain = $Pairs{'cookie_domain'};
  my $noncgi_url = $Pairs{'noncgi_url'};
  my $noncgi_path = $Pairs{'noncgi_path'};
  my $website_url = $Pairs{'website_url'};
  
  # Required information by this point: cgi_path, board_url, website_url, noncgi_url, cookie_domain
  # board_name, website_name, table_width, default_user_group

  # Check that there are trailing slashes where needed, and not where not needed
  # We do NOT want a trailing slash for these variables
  if(substr($cgi_path,-1,1) eq '/')      { $cgi_path = substr($cgi_path,0,length($cgi_path)-1); }
  if(substr($cookie_domain,-1,1) eq '/') { $cookie_domain = substr($cookie_domain,0,length($cookie_domain)-1); }
  if(substr($noncgi_url,-1,1) eq '/')    { $noncgi_url = substr($noncgi_url,0,length($noncgi_url)-1); }
  if(substr($noncgi_path,-1,1) eq '/')   { $noncgi_path = substr($noncgi_path,0,length($noncgi_path)-1); }
  # We DO want a trailing slash for these variables
  if(substr($website_url,-1,1) eq '/')   { $website_url = substr($website_url,0,length($website_url)-1); }


  # Open the file to save the information to
  lock_open(CONFIG,"$cgi_path/data/paths.txt","w");
  truncate(CONFIG,0);   seek(CONFIG,0,0);
  print "<p><font face=\"Verdana\" size=\"2\"><b>The following information has been saved:</b></font></p>";
  for('cgi_path','board_url','website_url','noncgi_url','cookie_domain','noncgi_path') {
    my $value = $Pairs{$_};
    print CONFIG "$_=$value\n";
    print "$_=$value<br>\n";
  }
  close(CONFIG);
  # Do the configuration options part of it now.
  lock_open(CONFIG,"$cgi_path/data/config.txt","w");
  for('board_name', 'website_name', 'table_width', 'default_user_group') {
    my $value = $Pairs{$_};
    print CONFIG "$_=$value\n";
    print "$_=$value<br>\n";
  }
  close(CONFIG);
  
  print "<p><p><hr></p></p><br>";
}

sub step_one {
  save_step_zero();  # First, save the last step
  
  # Print out the form
  print <<end;
    <p><form action="installer.cgi" method="post">
    <table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#EEEEEE"><tr><td>
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr>
	  <td><font face="Verdana" size="2"><b>Username</b></font></td>
	  <td><input type="text" name="username"></td>
	</tr>
        <tr>
	  <td><font face="Verdana" size="2"><b>Password</b></font></td>
	  <td><input type="password" name="password"></td>
	</tr>
        <tr>
	  <td><font face="Verdana" size="2"><b>Verify Password</b></font></td>
	  <td><input type="password" name="password2"></td>
	</tr>
        <tr>
	  <td><font face="Verdana" size="2"><b>Email</b></font></td>
	  <td><input type="text" name="email"></td>
	</tr>
	<tr>
	  <td colspan="2"><font face="Verdana" size="2">
	    <p>Please set up your <b>Administrator's Account</b>.  This account will be granted FULL ACCESS to
	    the message board and the configuration scripts.  You will need this username and password to
	    continue on with the setup of the account.
	    
	    <p>You may change the email, password and other account information for this account through
	    the profile links on the message board or through the user editor in the Administrator
	    Control Panel.
	  </font></td>
	</tr>
	<tr><td colspan="2" align="center"><input type="submit" name="submit" value="Save User"></td></tr>
      </table>
    </td></tr></table>
    <input type="hidden" name="step" value="2">
    </form>
end
}

sub save_step_one {
  my $username  = $Pairs{'username'};
  my $password  = $Pairs{'password'};
  my $password2 = $Pairs{'password2'};
  my $email     = $Pairs{'email'};
  
  if($password ne $password2) {
    print "<b>Error</b>: Your passwords do not match.  Hit the \"Back\" button on your browser and try again.<br>\n";
    exit;
  }
  
  # Generate a salt
  my $salt       = generate_random_string(3);
  
  # Start setting up a quick-and-dirty account in the %users hash.
  $users{$username}{'password'}     = crypt($password,$salt);
  $users{$username}{'salt'}         = $salt;
  $users{$username}{'dots'}         = "levelsix.gif";
  $users{$username}{'showemail'}    = "yes";
  $users{$username}{'class'}        = "Administrator";
  $users{$username}{'memberstate'}  = "admin";
  $users{$username}{'username'}     = $username;
  $users{$username}{'email'}        = $email;
  $users{$username}{'registeredon'} = time;
  $users{$username}{'tolerance'}    = -1;
  $users{$username}{'posts'}        = 0;
  # Add them to the administrator's class
  $users{$username}{'groups'}       = "Administrators,$config{'default_user_group'}";
  
  # If the Administrators group does not exist, create it now.
  lock_open(GROUPS,"$cgi_path/data/groups.txt","rw");
  seek(GROUPS,0,0);
  while($in = <GROUPS>) {
    my($name) = split(/\|/,$in);
    if($name eq 'Administrators') { $ok = 1; last; }
  }
  if($ok != 1) {
    my $string = "";
    for($x = 1; $x <= $TOTAL_PERMISSIONS; $x++) { $string .= "1"; }   # They have ALL permissions.
    $string2 = $string;  $string2 =~ tr/1/0/;
    print GROUPS "Administrators|$string|$string2\n";
  }
  close(GROUPS);
  
  # Save the user
  saveuser($username);
  
  # Save the records
  lock_open(FILE,"$cgi_path/data/books.inf","w");
  truncate(FILE,0);   seek(FILE,0,0);
  print FILE "1\n$username\n0\n";
  close(FILE);
  
  print "<font face=\"Verdana\" size=\"2\"><b>Thank you!</b>  <i>$username</i> has successfully been created as the Administrator account for this message board.</font><br>\n";
}

sub step_two {
  save_step_one();      # First save the last step
  
  # Let them know that the basic configuration is done, and where to go next.  Also, flag this
  # installation script as a file to be deleted so that it is not sitting around.
  
  # Print the thank-you form and instructions.
  print <<end;
    <font face="Verdana" size="2">
      <h3><font face="Verdana">Thank You!</font></h3>
      
      <p>The setup of your new ScareCrow message board is partially complete.  The bare-bone essentials have
      been set up and should, hopefully, work properly by this point.  (If you would like to perform a
      check on the variables before proceeding, you may do so by using the <a href="installer.cgi?step=3" target="_blank">configuration self-check</a>.)
      
      <p>It is now time for you to move on to the asthetic configuration of your message board.  Note that
      if you have uploaded all of the default files that should have been contained in your distribution, and
      are happy with the way it appears, you can skip the "Color Configuration" section in the next
      configuration steps.
      
      <p>In the <b>Board Configuration</b> section, you will be setting up board preferences such as whether
      to allow users to have avatars, the type of email you want this board to send (if any at all), whether
      or not certain ScareCrow tags will show up, etc.
      
      <p>In the <b>Path Configuration</b> section, you will be setting up the ulta-important path options
      for the message board, including the path to sendmail or an SMTP server.  You will also have the
      ability to edit some of the paths that you have set up in this installation script.
      
      <p>In the <b>Color Configuration</b> section, you will be setting up what colors should be used on
      the message board.  Remember: If you uploaded all the default files and are satisfied with the
      appearance, you can skip this step.  It's always nice to tweak the values a little bit to fit your
      own site's color schemes, though.
      
      <p>When you have finished all of those configurations, you're ready to <b>add a catagory</b>.  Use
      the link to name the catagory and create it.  If you wish to have multiple catagories, repeat the
      process until you have created all the catagories you desire.
      
      <p>Once you have the catagories in place, you can move on to <b>adding forums</b>.  The forums are
      the basic organizational unit of the message board.  Every post belongs to a specific forum, which
      in turn belongs to a specific catagory.  Examples of forums are "Website Chat", "Suggestions", "Music",
      etc.  Catagories may be "Fan Chat", "News", etc.
      
      <p>After you have completed all the above configuration options, your message board should be ready to use!
      We hope you enjoy the ScareCrow Message Board software.  If you have any questions, comments, suggestions
      or want simply to keep up with all the latest releases of the software, you can head to the Official
      ScareCrow homepage at <a href="http://scarecrow.sourceforge.net">http://scarecrow.sourceforge.net</a>.
      
      <p>You may proceed with the board configuration by <a href="admincenter.cgi">clicking here</a> and
      logging in with the Administrator account you created in the previous step.
      
      <p>Please make sure to delete this configuration script as soon as you are done with it, or the
      security of your message board will be easily compromised by anybody with even a small degree of
      knowledge about the ScareCrow software.
      
      <p>Once again, thank you for your interest in the ScareCrow software, and thank you for your support
      of the Open Source Software movement.  Enjoy!
      
      <p>Jonathan Bravata<br>
      ScareCrow Message Board Programmer.
    </font>
end
  
  # Flag for deletion.
  #unlink "installer.cgi";
}

# Performs a self-check on some of the variables that this script set up.
sub step_three {
  # The %config and %paths hashes should be loaded by now.
  
  # First, just check the variables we're only checking existance of.
  print "<font face=\"Verdana\" size=\"2\">Checking <b>Board URL</b>...";
  if($paths{'board_url'}) { ok(); } else { $error++; print "<i>Missing.</i>"; }
  print "<br>Checking <b>Website URL</b>...";
  if($paths{'website_url'}) { ok(); } else { $error++; print "<i>Missing.</i>"; }
  print "<br>Checking <b>Non-CGI URL</b>...";
  if($paths{'noncgi_url'}) { ok(); } else { $error++; print "<i>Missing.</i>"; }
  print "<br>Checking <b>cookie domain</b>...";
  if($paths{'cookie_domain'}) { ok(); } else { $error++; print "<i>Missing.</i>"; }
  print "<br>Checking <b>board name</b>...";
  if($config{'board_name'}) { ok(); } else { $error++; print "<i>Missing.</i>"; }
  print "<br>Checking <b>website name</b>...";
  if($config{'website_name'}) { ok(); } else { $error++; print "<i>Missing.</i>"; }
  print "<br>Checking <b>table width</b>...";
  if($config{'table_width'}) { ok(); } else { $error++; print "<i>Missing.</i>"; }

  # Now check the variables that require additional checking
  print "<br>Checking <b>CGI path</b>...";
  if($paths{'cgi_path'}) { ok(); }
  $cgi_path = $paths{'cgi_path'};
  if(-d "$cgi_path") {  # The directory exists
    print "  <i>Is a directory.</i>";
    # Check if it's the RIGHT directory
    if(-e "$cgi_path/installer.cgi") {
      print "  <i>Is the correct path.</i>";
    } else {
      print "  <i>Is NOT the correct path.</i>";
      print "  <i>All further checking aborted.  Please correct this error immediately!</i>";  exit;
    }
  } else {
    print "<i>Is NOT a directory.  Is NOT the correct path.</i>";
    print "  <i>All further checking aborted.  Please correct this error immediately!</i>";  exit;
  }
  
  print "<br>Checking <b>Non-CGI path</b>...";
  if($paths{'noncgi_path'}) { ok(); }
  $noncgi_path = $paths{'noncgi_path'};
  if(-d "$noncgi_path") {  # The directory exists
    print "  <i>Is a directory.</i>";
    # Check if it has the proper directories in it.
    if(-d "$noncgi_path/images") {
      print "  <i>Contains the images directory.</i>";
    } else {
      print "  <i>Does NOT contain the images directory -- created.</i>";
      mkdir "$noncgi_path/images",0744;
    }
    if(-d "$noncgi_path/avatars") {
      print "  <i>Contains the avatars directory.</i>";
    } else {
      print "  <i>Does NOT contain the avatars directory -- created.</i>";
      mkdir "$noncgi_path/avatars",0744;
    }
    if(-d "$noncgi_path/emoticons") {
      print "  <i>Contains the emoticons directory.</i>";
    } else {
      print "  <i>Does NOT contain the emoticons directory -- created.</i>";
      mkdir "$noncgi_path/emoticons",0744;
    }
  } else {
    print "<i>Is NOT a directory.  Sub-directories could NOT be created.</i>";
    $error++;
  }

  print "<br>Checking <b>default user group</b>...";
  if($config{'default_user_group'}) {
    # Check if the GROUP really exists.
    lock_open(GROUPS,"$cgi_path/data/groups.txt","r");
    while($in = <GROUPS>) {
      my($name) = split(/\|/,$in);
      if($name eq $config{'default_user_group'}) { $ok = 1; }
    }
    close(GROUPS);
    if($ok == 1) { print "<i>Complete and accurate.</i>"; }
    else {
      $error++;
      print "<i>Complete, but the group does not exist.  Be sure to create it in the group manager.</i>";
   }
  } else { $error++; print "<i>Missing.</i>"; }
  
  # Display the results
  if($error == 0) {
    $message = qq~
      <b>Congratulations!</b>  All of the variables required by this script appear to exist and be in
      good form, at least as far as we can tell.  You're ready to move on to the
      <a href="admincenter.cgi">next step</a> of the configuration process.  Don't forget to delete this
      script as soon as you are done with it to avoid a huge security hole.</font>~;
  } else {
    $message = qq~
      <b>There were $error error(s) that should be corrected before you proceed.</b>  Note that these errors
      are <i>non-fatal</i> at this point.  That is, your message board will continue to run, but may not
      appear the way you wish or expect if you do not correct them.  You may correct them through this
      script, or you may do so through the <a href="admincenter.cgi">administrator control panel</a>.
      Don't forget to delete this script as soon as you are done with it to avoid a huge security hole.</font>~;
  }
  
  print "<br><p>$message";

 
}

sub ok { print "<i>Complete.</i>"; }
