#!/usr/bin/perl

# This script will allow users to view one anothers profiles, as well as make
# changes to their own profiles.
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
# The latest version of this software can be found by pointing one's web
# browser to http://scarecrowmsgbrd.cjb.net
#
# Author: Jonathan Bravata
# Revision: October 2001

require "global.cgi";

# Output the content headers
content();

# Determine the course of action
$action = $Pairs{'action'};
if($action eq 'view' || $action eq 'show') { $loc = "View Profile"; }
else                  { $loc = "Edit Profile"; }

# Set the active users flag
activeusers($loc);

# Set up the page headers
page_header("$config{'board_name'} > $loc");
board_header();
user_line();
position_tracker("",$loc);

# Determine where we're going and pass it to the appropriate function
if($action eq 'view' || $action eq 'show')      { view(); }
elsif($action eq 'write')                       { write_profile(); }
elsif($action eq 'edit')                        { edit_profile();  }
else                                            { profile_login(); }

page_footer();

sub view
{
  # Get some variables
  my $user = $Pairs{'user'};
  if(!$user) { $user = $Pairs{'member'}; }
  get_member($user);
  
  # Figure out who is viewing the page
  my $inf = get_cookie("mb-user");   my($caller,$password) = split(/\|/,$inf);    get_member($caller);

  # Just pre-set the email, depending on their privacy preferences
  my $email = $users{$user}{'email'};
  if($users{$user}{'showemail'} ne 'yes') { $email = "N/A"; } else {
    $email = "<a href=\"mailto:$email\">$email</a>";
  }
  my $memberstate = $users{$user}{'memberstate'};
  if($memberstate eq 'admin')     { $memberstate = "Administrator"; }
  if($memberstate eq 'mod')       { $memberstate = "Moderator"; }
  if($memberstate eq 'member')    { $memberstate = "Member"; }
  if($memberstate eq 'banned')    { $memberstate = "Banned"; }
  my $icq = $users{$user}{'icqnumber'};
  if($icq) { $icqlogo = qq~<img src="http://wwp.icq.com/scripts/online.dll?icq=$icq&img=7" border="0">~; $icq = qq~<a href="" onMouseOver="mouseit('Send an ICQ Message'); return true;" onMouseOut="mouseit(''); return true;" onClick="openScript('misc.cgi?action=sendicq&icq=$icq','400','350'); return false;">$icq</a>~; }
  else     { $icqlogo = "";  $icq = ""; }
  if($users{$user}{'homepage'} && $users{$user}{'homepage'} ne 'http://') { $homepage = qq~<a href="$users{$user}{'homepage'}" target="_new">$users{$user}{'homepage'}</a>~; }
  else                                                                    { $homepage = "none"; }

  my $registered = get_time($users{$user}{'registeredon'},"%mo/%md/%ye") || "no posts";
  my $lastvisit  = get_time($users{$user}{'lastvisited'}) || "never";
  my $helpline   = helpline("Last_Visits");
  my $limitline  = get_postlimit($users{$user}{'posttimelimit'}) || "Anytime";
  my $votingtrends = votingdata($user);
  my $groups = $users{$user}{'groups'};  $groups =~ s/\,/\, /ig;
  
  # Compile the administrative data
  if(perms($caller,'VIEWADM') == $TRUE) {
    if($users{$user}{'totalvotes'}) {
      $avg = round($users{$user}{'totalscore'} / $users{$user}{'totalvotes'},2);
    } else { $avg = "0"; }
    # They CAN view the administrative data.
    $admindata = qq~
    <table width="$config{'table_width'}" border="0" cellspacing="1" cellpadding="0" bgcolor="$color_config{'border_color'}" align="center"><tr><td>
      <table width="100%" cellspacing="1" border="0" cellpadding="5">
        <tr bgcolor="$color_config{'nav_bottom'}"><td colspan="2" align="center"><font face="Verdana" size="2"><b>Administrative Data (restricted access)</b></font></td></tr>
        <tr>
	  <td bgcolor="$color_config{'nav_top'}" width="25%">
	    <font face="Verdana" size="2"><b># Posts by this User Deleted</b><font>
	  </td>
	  <td bgcolor="$color_config{'body_bgcolor'}" width="75%"><font face="Verdana" size="2">$users{$user}{'deleteposts'}</font></td>
	</tr>
        <tr>
	  <td bgcolor="$color_config{'nav_top'}" width="25%">
	    <font face="Verdana" size="2"><b>Total Votes on User's Posts</b><font>
	  </td>
	  <td bgcolor="$color_config{'body_bgcolor'}" width="75%"><font face="Verdana" size="2">$users{$user}{'totalvotes'}</font></td>
	</tr>
        <tr>
	  <td bgcolor="$color_config{'nav_top'}" width="25%">
	    <font face="Verdana" size="2"><b>Average Vote for User's Post</b><font>
	  </td>
	  <td bgcolor="$color_config{'body_bgcolor'}" width="75%"><font face="Verdana" size="2">$avg</font></td>
	</tr>
      </table>
    </td></tr></table>
    ~;
    
  } else { $admindata = ""; }
  
  

  # Got it!  Set up the table and display the results
  print <<end;
    <table width="$config{'table_width'}" border="0" cellspacing="1" cellpadding="0" bgcolor="$color_config{'border_color'}" align="center"><tr><td>
      <table width="100%" cellspacing="1" border="0" cellpadding="5">
        <tr><td colspan="2" bgcolor="$color_config{'nav_bottom'}" align="center"><font face="Verdana" size="3"><font color="$color_config{'profilename_color'}"><b>$user\'s</font> Profile</b></font></td></tr>
        <tr><td width="25%" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="2"><b>User Name</b></font></td><td bgcolor="$color_config{'body_bgcolor'}"><font face="Verdana" size="2">$user</font></td></tr>
        <tr><td width="25%" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="2"><b>Authority</b></font></td><td bgcolor="$color_config{'body_bgcolor'}"><font face="Verdana" size="2">$memberstate</font></td></tr>
        <tr><td width="25%" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="2"><b>Groups</b></font></td><td bgcolor="$color_config{'body_bgcolor'}"><font face="Verdana" size="2">$groups</font></td></tr>
        <tr><td width="25%" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="2"><b>Email</b></font></td><td bgcolor="$color_config{'body_bgcolor'}"><font face="Verdana" size="2">$email</font></td></tr>
        <tr><td width="25%" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="2"><b>Registered On</b></font></td><td bgcolor="$color_config{'body_bgcolor'}"><font face="Verdana" size="2">$registered</font></td></tr>
        <tr><td width="25%" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="2"><b>Posts</b></font></td><td bgcolor="$color_config{'body_bgcolor'}"><font face="Verdana" size="2">$users{$user}{'posts'}</font></td></tr>
        <tr><td width="25%" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="2"><b>You May Post...</b></font></td><td bgcolor="$color_config{'body_bgcolor'}"><font face="Verdana" size="2">$limitline</font></td></tr>
        <tr><td width="25%" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="2"><b>Last Post</b></font></td><td bgcolor="$color_config{'body_bgcolor'}"><font face="Verdana" size="2">$users{$user}{'lastpost'}</font></td></tr>
        <tr><td width="25%" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="2"><b>Last Visited $helpline</b></font></td><td bgcolor="$color_config{'body_bgcolor'}"><font face="Verdana" size="2">$lastvisit</font></td></tr>
        <tr><td width="25%" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="2"><b>ICQ Number</b></font></td><td bgcolor="$color_config{'body_bgcolor'}"><font face="Verdana" size="2">$icq&nbsp;&nbsp;$icqlogo</font></td></tr>
        <tr><td width="25%" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="2"><b>Yahoo! Messenger ID</b></font></td><td bgcolor="$color_config{'body_bgcolor'}"><font face="Verdana" size="2">$users{$user}{'yahooid'}</font></td></tr>
        <tr><td width="25%" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="2"><b>MSN Messenger ID</b></font></td><td bgcolor="$color_config{'body_bgcolor'}"><font face="Verdana" size="2">$users{$user}{'msnid'}</font></td></tr>
        <tr><td width="25%" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="2"><b>AIM Name</b></font></td><td bgcolor="$color_config{'body_bgcolor'}"><font face="Verdana" size="2">$users{$user}{'aimname'}</font></td></tr>
        <tr><td width="25%" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="2"><b>Homepage</b></font></td><td bgcolor="$color_config{'body_bgcolor'}"><font face="Verdana" size="2">$homepage</font></td></tr>
        <tr><td width="25%" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="2"><b>Location</b></font></td><td bgcolor="$color_config{'body_bgcolor'}"><font face="Verdana" size="2">$users{$user}{'location'}</font></td></tr>
        <tr><td width="25%" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="2"><b>Interests</b></font></td><td bgcolor="$color_config{'body_bgcolor'}"><font face="Verdana" size="2">$users{$user}{'interests'}</font></td></tr>
      </table>
    </td></tr></table><br><br>
    
    $votingtrends
    $admindata
end

}

sub write_profile
{
    # Get all the variables
    my $user      = $Pairs{'user'};
    my $pass      = $Pairs{'pass'};
    my $password  = $Pairs{'password'};
    my $email     = $Pairs{'email'};
    my $showemail = $Pairs{'showemail'};
    my $homepage  = $Pairs{'homepage'};
    my $aimname   = $Pairs{'aimname'};
    my $icq       = $Pairs{'icqnumber'};
    my $msn       = $Pairs{'msnid'};
    my $yahoo     = $Pairs{'yahooid'};
    my $location  = $Pairs{'location'};
    my $interests = $Pairs{'interests'};
    my $signature = $Pairs{'signature'};
    my $offset    = $Pairs{'offset'};
    my $avatar    = $Pairs{'avatar'};
    my $tolerance = $Pairs{'tolerance'} || 0;
    my $pmnotify  = $Pairs{'pmnotification'};
    my $activehide = $Pairs{'activehide'};
    if($tolerance > 5 || $tolerance < -1) { $tolerance = 0; }

    #my $inf = get_cookie("mb-user");
    #my($user,$pass) = split(/\|/,$inf);

    # Verify the account
    if(check_account($user,$pass) == $FALSE) {
      redirect_die("Your username/password combination was invalid.","","2","black","Invalid Login");
    }

    # If we're here, it's a valid account.  Get the current settings.
    get_member($user);
    
    # Check if they have the permission to change this
    if(perms($user,'PROFILE') == $FALSE)  { # Doesn't have this permission
      noaccess('profile');
    }

    # If the email has changed and the board uses autopasswords, generate a
    # new password and send it to force the user to always keep a valid email
    if($config{'autopasswords'} eq 'yes' && $email ne $users{$user}{'email'}) {
      require "mail.lib";
      $password = generate_random_string(7);
      $mssg = "You recently changed the email address for the message board at\n";
      $mssg .= "$paths{'website_url'}.  In order to verify the validity\n";
      $mssg .= "of the new address, we have changed your password.  You may\n";
      $mssg .= "change the password by editting your profile at any time.<br><br>\n";
      $mssg .= "Your password is: $password\n";
      send_mail($email,"$config{'board_name'} Profile Change",$mssg);
    }
    # Neuter and alter some variables
    $signature =~ s/\n\n/[p]/ig;        $interests =~ s/\n\n/[p]/ig;
    $signature =~ s/\n/[br]/ig;         $interests =~ s/\n/[br]/ig;
    $signature =~ s/</\&lt\;/ig;        $signature =~ s/>/\&gt\;/ig;
    if($homepage eq 'http://')   { $homepage = "&nbsp;";   }
    if($avatar eq 'noavatar')    { $avatar = "";           }
    if($icqnumber =~ /[A-Za-z]/) { $icqnumber = "&nbsp;";  }
    if(!$pmnotify)               { $pmnotify = "no";       }
  # [song] tags
  if($config{'songtags'} eq 'yes') {
    while($signature =~ /\[song\]/i) {
      my $song = get_randomsong();
      $signature =~ s/\[song\]/$song/i;
    }
  }
  
  # [random] tags
  if($config{'randomtags'} eq 'yes') {
    while($signature =~ /\[random\]/i) {
      my $quote = get_randomquote();
      $signature =~ s/\[random\]/$quote/i;
    }
  }

    # If there's a new password, encrypt it
    if($password) {
      $crypted = crypt($password,$users{$user}{'salt'});
    } else {
      $crypted = $users{$user}{'password'};
    }
    if(!$activehide) { $activehide = "no"; }
    
    # Set the changes in memory first - this guarantees that the ENTIRE user file gets written back out
    # when ready, automatically adding any expansions added by users
    $users{$user}{'email'} = $email;
    $users{$user}{'password'} = $crypted;
    $users{$user}{'interests'} = $interests;
    $users{$user}{'homepage'} = $homepage;
    $users{$user}{'showemail'} = $showemail;
    $users{$user}{'aimname'} = $aimname;
    $users{$user}{'yahooid'} = $yahoo;
    $users{$user}{'msnid'} = $msn;
    $users{$user}{'icqnumber'} = $icq;
    $users{$user}{'signature'} = $signature;
    $users{$user}{'avatar'} = $avatar;
    $users{$user}{'location'} = $location;
    $users{$user}{'timeoffset'} = $offset;
    $users{$user}{'tolerance'} = $tolerance;
    $users{$user}{'pmnotification'} = $pmnotify;
    # Active user list hiding, if applicable
    if($users{$user}{'activehide'} ne $activehide && perms($user,'ACTIVE') != $TRUE) {  } else {
      $users{$user}{'activehide'} = $activehide;
    }

    # Write the changes
    saveuser($user);
    
    redirect_die("The changes were made successfully!","$paths{'board_url'}scarecrow.cgi","2","black","Changes Made!");
}

sub edit_profile
{
    # Check the account first
    my $user = $Pairs{'user'};
    my $pass = $Pairs{'pass'};
    if(check_account($user,$pass) == $FALSE) {
      redirect_die("Your username/password combination was invalid.","","2","black","Invalid Login");
    }

    # It's a valid account, get the information
    get_member($user);

  # Check if they have the permission to change this
  if(perms($user,'PROFILE') == $FALSE)  { # Doesn't have this permission
    noaccess('profile');
  }

  # Set up some variables
  if($users{$user}{'showemail'} ne 'yes') { $blocked = "checked selected"; $ok = ""; }
  else                                    { $blocked = ""; $ok = "checked selected"; }
  if($config{'avatars'} eq 'on') {
    # Get the option for avatars
    opendir(avatars,"$paths{'noncgi_path'}/avatars/");
    my @list = readdir(avatars);
    closedir(avatars);

    @gifs = grep(/\.gif/,@list);
    push @avlist,@gifs;
    $avataroptions = "";
    foreach my $item (@avlist) {
      # clean the name
      $item =~ s/\.gif//ig;     $item =~ s/\.jpg//ig;
      if($item eq $users{$user}{'avatar'}) {  # Avatar match
        $avataroptions .= "<option value=\"$item\" selected>$item</option>";
      } else {
        $avataroptions .= "<option value=\"$item\">$item</option>";
      }
    }
    
    my $curavatar = $users{$user}{'avatar'} || "noavatar";
    if(-e "$paths{'noncgi_path'}/avatars/$curavatar.gif") { $ext = "gif"; }
    else                                           { $ext = "jpg"; }


    $avatars = qq~<script language="javascript">
      function showimage()
      {
        document.images.useravatars.src="$paths{'noncgi_url'}/avatars/"+document.creator.avatar.options[document.creator.avatar.selectedIndex].value+".gif";
      }
    </script>
    <tr bgcolor="$color_config{'body_bgcolor'}"><td><b>Avatars</b><br><font face="Verdana" size="1">If you wish, you may select an avatar here.</font></td>
    <td>
    <select name="avatar" size=6 onChange="showimage()">
      $avataroptions
    </select>&nbsp;
    <img src="$paths{'noncgi_url'}/avatars/$curavatar.$ext" name="useravatars" width="64" height="64" border=0 hspace=15>
    </td></tr>~;
  } else {
    $avatars = "";
  }
  # Default tolerance setting
  my $tol = $users{$user}{'tolerance'};
  if($tol == 0) { $t[0] = "checked selected"; } else { $t[0] = ""; }
  if($tol == 1) { $t[1] = "checked selected"; } else { $t[1] = ""; }
  if($tol == 2) { $t[2] = "checked selected"; } else { $t[2] = ""; }
  if($tol == 3) { $t[3] = "checked selected"; } else { $t[3] = ""; }
  if($tol == 4) { $t[4] = "checked selected"; } else { $t[4] = ""; }
  if($tol == 5) { $t[5] = "checked selected"; } else { $t[5] = ""; }
  if($tol == -1) { $t[6] = "checked selected"; } else { $t[6] = ""; }
  
  # Offset code
  $offsetcode = offsetcode();
  
  # Private message notification defaults
  if($users{$user}{'pmnotification'} eq 'yes')                            { $pmd = "checked";   }
  else				     					  { $pmd = "";          }
  # Active users list hiding
  if($users{$user}{'activehide'} eq 'yes')                                { $ah  = "checked";   }
  else                                                                    { $ah  = "";          }
  # Active user's hiding list
  if(perms($user,'ACTIVE') == $TRUE) {
    $ahl = qq~
      <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="2"><b>Do Not Display In Active User's List</b></font><br><font face="Verdana" size="1">If checked, will ensure that the user never shows up in the active users list.</font></td>
      <td><input type="checkbox" name="activehide" value="yes" $ah>&nbsp;<font face="Verdana" size="2">Yes</font></td></tr>
    ~;
  } else { $ahl = ""; }



    # Print out the table and allow the user to change their profile
    # information.
    print <<end;
    <form action="$paths{'board_url'}profile.cgi" method="post" name="creator">
    <table cellspacing="0" cellpadding="0" border="0" bgcolor="$color_config{'border_color'}" width="$config{'table_width'}" align="center"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'body_bgcolor'}"><td align="center" colspan="2" bgcolor="$color_config{'nav_bottom'}"><font face="Verdana" size="3"><b>Modify <font color="$color_config{'profilename_color'}">$user\'s</font> Profile</b></font></td></tr>
        <tr bgcolor="$color_config{'nav_top'}"><td><font face="Verdana" size="2"><b>Username</b></font><br><font face="Verdana" size="1">Please log in again to verify your identity.</font></td><td><input type="text" name="user" value="$user"></td></tr>
        <tr bgcolor="$color_config{'nav_top'}"><td><font face="Verdana" size="2"><b>Password</b></font></td><td><input type="password" name="pass" value="$pass"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td width="70%"><font face="Verdana" size="2"><b>Membername</b></font><br><font face="Verdana" size="1">Member names cannot be longer than
        20 characters and may only consist of letters, numbers, hypen and underscore.</font></td>
        <td>$user</td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="2"><b>Password</b></font><br><font face="Verdana" size="1">
        Your password should be at least five characters long.  Only fill in
        this box to CHANGE your password.</font></td>
        <td><input type="text" name="password"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="2"><b>Email Address</b></font><br><font face="Verdana" size="1">Please supply a valid email
        address.  You may keep this private if you wish.  <b>If you change your
        email address, your password will automatically be changed and mailed to
        you to verify the accuracy of the new email.</b></font></td>
        <td><input type="text" name="email" value="$users{$user}{'email'}"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="2"><b>Show Email Address</b></font><br><font face="Verdana" size="1">Would you like your email address
        visible to others?</font></td>
        <td><input type="radio" name="showemail" value="yes" $ok> Yes&nbsp;&nbsp;<input type="radio" name="showemail" value="no" $blocked> No</td></tr>
	<tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="2"><b>Receive private message notification by email?</b></font></td><td><input type="checkbox" name="pmnotification" value="yes" $pmd> Yes</td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="2"><b>Homepage</b></font><br><font face="Verdana" size="1">If you have a webpage, enter the URL here.</font></td>
        <td><input type="text" name="homepage" value="$users{$user}{'homepage'}"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="2"><b>AOL Instant Messanger Name</b></font><br><font face="Verdana" size="1">If you have an AIM name, enter it here.</font></td>
        <td><input type="text" name="aimname" value="$users{$user}{'aimname'}"></td></tr>

        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="2"><b>Yahoo! Messenger ID</b></font><br><font face="Verdana" size="1">If you have an AIM name, enter it here.</font></td>
        <td><input type="text" name="yahoo" value="$users{$user}{'yahooid'}"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="2"><b>MSN Messenger ID</b></font><br><font face="Verdana" size="1">If you have an AIM name, enter it here.</font></td>
        <td><input type="text" name="msnid" value="$users{$user}{'msnid'}"></td></tr>


        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="2"><b>ICQ Number</b></font><br><font face="Verdana" size="1">If you have an ICQ number, enter it here.</font></td>
        <td><input type="text" name="icqnumber" value="$users{$user}{'icqnumber'}"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="2"><b>Location</b></font><br><font face="Verdana" size="1">Optionally, you may enter your location here.</font></td>
        <td><input type="text" name="location" value="$users{$user}{'location'}"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="2"><b>Time Offset</b></font><br><font face="Verdana" size="1">All times on the server are $config{'times'}.<br>
        Enter the number of hours that you are offset from this timezone and all the
        times on the board will be altered to fit your timezone.</font></td>
        <td>$offsetcode</td></tr>
        $ahl
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="2"><b>Rating Tolerance</b></font><br><font face="Verdana" size="1">The minimum average rating a post must receive to be shown to you.</font></td>
        <td><select name="tolerance"><option $t[5]>5</option><option $t[4]>4</option><option $t[3]>3</option><option $t[2]>2</option><option $t[1]>1</option><option value="0" $t[0]>0</option><option value="-1"  $t[6]>Show all posts</option></select></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="2"><b>Interests</b></font><br><font face="Verdana" size="1">You may enter your interests here.</font></td>
        <td><textarea name="interests" cols="35" rows="10">$users{$user}{'interests'}</textarea></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="2"><b>Signature</b></font><br><font face="Verdana" size="1">Please enter a signature to be included
        with each post.  All ScareCrow tags will work the same as they work within
        a forum, but no HTML will be accepted.</font></td>
        <td><textarea name="signature" cols="35" rows="10">$users{$user}{'signature'}</textarea></td></tr>
        $avatars
        <tr bgcolor="$color_config{'body_bgcolor'}"><td colspan="2" bgcolor="$color_config{'nav_top'}" align="center"><input type="Submit" name="Submit" value="Submit Changes"><br></td></tr>
      </table>
      <input type="hidden" name="action" value="write">
    </td></tr></table>
    </form>
end


}

sub profile_login
{
  # Try to get the username/password for the user
  my $inf = get_cookie("mb-user");
  my($user,$pass) = split(/\|/,$inf);
  if(!$user || !$pass) { undef $user;   undef $pass; }

  my $message = qq~
    <form action="$paths{'board_url'}profile.cgi" method="post">
    <table width="100%" align="center" border="0">
      <tr><td><font face="Verdana" size="2"><b>Username</b></font></td><td><input type="text" name="user" value="$user"></td></tr>
      <tr><td><font face="Verdana" size="2"><b>Password</b></font></td><td><input type="password" name="pass" value="$pass"></td></tr>
      <tr><td colspan="2" align="center"><input type="submit" name="Login" value="Login"></td></tr>
    </table>
    <input type="hidden" name="action" value="edit">
    </form>~;

   notice_box("<b>Please Login to Verify Your Identity</b>",$message);
}

sub votingdata
{
  my($user) = @_;    # Assign the username to a local variable
  
  # The data for the member has already been loaded - get the list of their votes
  my $votes = $users{$user}{'votelist'} || "";
  
  # Begin compiling the table
  my $output = qq~
    <table width="$config{'table_width'}" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_bottom'}"><td colspan="2"><font face="Verdana" size="2"><center><b>Voting Trends</b></center></font></td></tr>~;
  
  # If they have no votes, denote that and return immediately
  if(!$votes) {
    $output .= qq~
          <tr bgcolor="$color_config{'body_bgcolor'}"><td colspan="2"><font face="Verdana" size="2"><center><b>This User Has Not Scored Any Posts</b></center></font></td></tr>
	</table>
      </td></tr></table>~;
    
    return $output;
  }
  
  # If we reach this point, the user has voted - start compiling data on them
  my @votelist = split(/\,/,$votes);
  @votelist = sort { $a <=> $b } @votelist;   # Sort from worst to best score
  foreach my $vote (@votelist) {
    # First, add the vote to the total score
    $totalscore += $vote;
    # Next, add that there has been another vote
    $totalvotes++;
  }
  
  # Determine the MEAN (average) vote - display to three decimals
  my $mean = round($totalscore / $totalvotes,3);
  my $rounded = int($totalscore / $totalvotes);
  
  # Determine the MEDIAN vote
  my $median = $votelist[int($#votelist / 2 + .5)];
  # Get a general status on this user - how aggressively do they vote?
  if($totalvotes >= 5) {  # Only if they have voted a few times
    if($rounded == -1)     { $status = "Very Aggressive";     }
    elsif($rounded == 0)   { $status = "Aggressive";          }
    elsif($rounded == 1)   { $status = "Somewhat Aggressive"; }
    elsif($rounded == 2)   { $status = "Average";             }
    elsif($rounded == 3)   { $status = "Somewhat Lenient";    }
    elsif($rounded == 4)   { $status = "Lenient";             }
    elsif($rounded == 5)   { $status = "Very Lenient";        }
    else                   { $status = "Indeterminable";      }
  } else { $status = "Indeterminable"; }
  
  # Format the vote list so that it can be paginated by HTML
  $votes =~ s/,/, \&nbsp\;/ig;
  
  # Display all this new data
  $output .= qq~
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td bgcolor="$color_config{'nav_top'}" width="25%"><font face="Verdana" size="2"><b>Total Votes</b></font></td>
	  <td><font face="Verdana" size="2">$totalvotes</font></td>
	</tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td bgcolor="$color_config{'nav_top'}" width="25%"><font face="Verdana" size="2"><b>Total Score</b></font></td>
	  <td><font face="Verdana" size="2">$totalscore</font></td>
	</tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td bgcolor="$color_config{'nav_top'}" width="25%"><font face="Verdana" size="2"><b>Average Vote</b></font></td>
	  <td><font face="Verdana" size="2">$mean</font></td>
	</tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td bgcolor="$color_config{'nav_top'}" width="25%"><font face="Verdana" size="2"><b>Median Vote</b></font></td>
	  <td><font face="Verdana" size="2">$median</font></td>
	</tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td bgcolor="$color_config{'nav_top'}" width="25%"><font face="Verdana" size="2"><b>Vote Status</b></font></td>
	  <td><font face="Verdana" size="2">$status</font></td>
	</tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td bgcolor="$color_config{'nav_top'}" width="25%"><font face="Verdana" size="2"><b>Vote List</b></font></td>
	  <td><font face="Verdana" size="2">$votes</font></td>
	</tr>
      </table>
    </td></tr></table><br><br>~;


  return $output;
}
