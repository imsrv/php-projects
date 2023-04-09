#!/usr/bin/perl

# This script will handle editting user accounts for the message board.
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

require "global.cgi";
require 'admin.lib';

# Check the cookie
$inf = get_cookie("mb-admin");
($cookieuser,$cookiepassword) = split(/\|/,$inf);

if(!$cookieuser) {   # Give them a chance to log in the admin cookie
  content();
  page_header("$config{'board_name'} > User Editor");
  admin_login("$paths{'board_url'}usereditor.cgi");
  page_footer();
  exit;
}

if(check_account($cookieuser,$cookiepassword) == $FALSE || perms($cookieuser,"USREDT") == $FALSE) {
  redirect_die("We're sorry, but your username/password combination was
  invalid or you do not have access to this area.","","4","black","You Do Not Have Access");
}

# Output the content type
content();
page_header("$config{'board_name'} > User Editor");

# Determine action and pass control to the appropriate function
$action = $Pairs{'action'};

if($action eq 'list')      { userlist();   }
elsif($action eq 'edit')   { useredit();   }
elsif($action eq 'delete') { deleteuser(); }
elsif($action eq 'removeuser') { removeuser(); }
elsif($action eq 'save')   { savedit();    }
else                       { userlist();   }

page_footer();


sub userlist {
  my $letter = $Pairs{'letter'} || 'A';

  # Get the member list
  opendir(MEMBERS,"$cgi_path/members/");
  @members = readdir(MEMBERS);
  close(MEMBERS);

  # Narrow it down only to user files
  @members = grep(/\.dat/,@members);
  # Only entries beginning with the proper letter
  @thesemembers = grep(/^$letter/i,@members);
  # Sort it alphabetically
  @thesemembers = sort { $a cmp $b } @thesemembers;

  # Get the letters header up
  letters_header();

  # Display the tables
  foreach my $memberfile (@thesemembers) {
    my $member = substr($memberfile,0,length($memberfile)-4);
    get_member($member);
    my $regon = get_time($users{$member}{'registeredon'});
    if($users{$member}{'memberstate'} eq 'admin')         { $memberstate = "Administrator"; }
    elsif($users{$member}{'memberstate'} eq 'moderator')  { $memberstate = "Moderator";     }
    elsif($users{$member}{'memberstate'} eq 'banned')     { $memberstate = "Banned";        }
    elsif($users{$member}{'memberstate'} eq 'member')     { $memberstate = "Member";        }
    else                                                  { $memberstate = "Member";        }

    $okmember = $member;  $okmember =~ s/ /\%20/ig;


    # Display the entry
    print <<end;
      <table width="99%" align="center">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font color="$color_config{'profilename_color'}" size="3"><b>$member\'s <font color="$color_config{'body_textcolor'}">Profile</font></b><div align="right"><a href="$paths{'board_url'}usereditor.cgi?action=edit&member=$okmember">[ Edit ]</a>&nbsp;&nbsp;<a href="$paths{'board_url'}usereditor.cgi?action=delete&member=$okmember">[ Delete ]</a>&nbsp;&nbsp;&nbsp;</div></font></b></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td width="20%"><font face="Verdana" size="1">Posts</font></td><td><font face="Verdana" size="1">$users{$member}{'posts'}</font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1">Registered On</font></td><td><font face="Verdana" size="1">$regon</font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1">Memberstate</font></td><td><font face="Verdana" size="1">$memberstate</font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1">Active Groups</font></td><td><font face="Verdana" size="1">$users{$member}{'groups'}</font></td></tr>
	<tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"># of User's Posts Deleted</font></td><td><font face="Verdana" size="1">$users{$member}{'deletepost'}</font></td></tr>
	<tr bgcolor="$color_config{'body_bgcolor'}"><td colspan="2">&nbsp;</td></tr>
      </table>
end
  }
}


sub deleteuser {
  my $member = $Pairs{'member'};
  my $inf = get_cookie("mb-admin");
  my($user,$pass) = split(/\|/,$inf);

  # Output the table
  print <<end;
    <form action="$path{'board_url'}usereditor.cgi" method="post">
    <table width="$config{'table_width'}" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><font face="Verdana" size="2"><b>Please Log In to Delete $member</b></font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Username</b></font></td><td><input type="text" name="user" value="$user"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Password</b></font></td><td><input type="password" name="pass" value="$pass"></td></tr>
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Delete Member"></td></tr>
      </table>
    </td></tr></table>
    <input type="hidden" name="action" value="removeuser">
    <input type="hidden" name="delete" value="$member">
    </form>
end

}

sub removeuser {
  my $user   = $Pairs{'user'};
  my $pass   = $Pairs{'pass'};
  my $delete = $Pairs{'delete'};

  # Access approved -- delete it!
  my $retval = remove_user($delete);

  if($retval == $TRUE) {
    print "<b>User deleted.</b>";
  }
  else {
    print "<b>User delete aborted.</b>";
  }
}

sub useredit {
  my $member = $Pairs{'member'};

  get_member($member);
  if($users{$member}{'memberstate'} eq 'admin') { $o[1] = "checked selected"; } else { $o[1] = ""; }
  if($users{$member}{'memberstate'} eq 'moderator') { $o[2] = "checked selected"; } else { $o[2] = ""; }
  if($users{$member}{'memberstate'} eq 'banned') { $o[3] = "checked selected"; } else { $o[3] = ""; }
  if($users{$member}{'memberstate'} eq 'member') { $o[4] = "checked selected"; } else { $o[4] = ""; }

  # Compile private forums list
  my $privateforums = "";
  for($fid = 1; -d "$cgi_path/forum$fid/"; $fid++) {
    @parts = get_forum_information($fid);
    if($foruminformation{$fid}{'forumstatus'} eq 'private') {
       $zz++;
       if($zz != 1) {
         if($allowed{$member}{$fid} eq 'yes') { $def = "checked"; } else { $def = ""; }
         $privateforums .= qq~<tr bgcolor="$color_config{'body_bgcolor'}"><td colspan="2"><input type="checkbox" name="forum$fid" value="yes" $def><font face="Verdana" size="1">$parts[2]</font></td></tr>~;
       }
       else {
         $privateforums = qq~<tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="1"><b>Private Forums (check box to allow accessed):</b></font></td></tr>~;
         if($allowed{$member}{$fid} eq 'yes') { $def = "checked"; } else { $def = ""; }
         $privateforums .= qq~<tr bgcolor="$color_config{'body_bgcolor'}"><td colspan="2"><input type="checkbox" name="forum$fid" value="yes" $def><font face="Verdana" size="1">$parts[2]</font></td></tr>~;
       }
    }
  }
  close(FORUMS);
  
  # Compile the list of groups (and which the user belongs to)
  # First, let's get a list of what groups they DO belong to
  my $grouplist = $users{$member}{'groups'};
  
  # Now, let's get the select box going and select all that we have to.
  my $groupselect = qq~
    <tr bgcolor="$color_config{'body_bgcolor'}">
      <td><font face="Verdana" size="2"><b>Groups the User Belongs To</b></font><br>
      <font face="Verdana" size="1">The list of groups that the user belongs to, which will determine their
      effective permissions for what they can and cannot do on the board.  Groups the user currently belongs
      to are highlighted here automatically..</font></td>
      <td> <select name="groups" exclusive multiple size="4" text="#000000" selcolor="#00BFFF">~;
  $groupselect   .= get_grouplist($grouplist);
  $groupselect   .= qq~</select></td></tr>\n~;
  
  # Set up the user permissions form
  $permissions  = qq~<tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="1"><b>User Permissions/Denies</b></font></td></tr>\n<tr bgcolor="$color_config{'body_bgcolor'}"><td colspan="2">~;
  $permissions .= permissions_form($users{$member}{'permissions'},$users{$member}{'denies'});
  $permissions .= "</td></tr>";
  
  # Signatures
  my $signature = $users{$member}{'signature'};
  $signature =~ s/\[p\]/\n\n/ig;     $signature =~ s/\[br\]/\n/ig;

  print <<end;
    <form action="$path{'board_url'}usereditor.cgi" method="post">
    <table width="80%" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><font face="Verdana" size="2"><b>Editting $member</b></font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1">Member Title</font></td><td><input type="text" name="membertitle" value="$users{$member}{'class'}"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1">Number of Posts</font></td><td><input type="text" name="posts" value="$users{$member}{'posts'}"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1">Password</font></td><td><input type="text" name="password"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1">Email Address</font></td><td><input type="text" name="email" value="$users{$member}{'email'}"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1">Homepage</font></td><td><input type="text" name="homepage" value="$users{$member}{'homepage'}"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1">AOL Name</font></td><td><input type="text" name="aimname" value="$users{$member}{'aimname'}"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1">Yahoo! ID</font></td><td><input type="text" name="yahoo" value="$users{$member}{'yahooid'}"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1">MSN ID</font></td><td><input type="text" name="msn" value="$users{$member}{'msnid'}"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1">User may post every</font></td><td><input type="text" name="posttimelimit" value="$users{$member}{'posttimelimit'}"> minutes</td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1">ICQ Number</font></td><td><input type="text" name="icqnumber" value="$users{$member}{'icqnumber'}"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1">Location</font></td><td><input type="text" name="location" value="$users{$member}{'location'}"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1">Time offset</font></td><td><input type="text" name="offset" value="$users{$member}{'timeoffset'}"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1">Memberstate</font></td><td><select name="memberstate"><option value="admin" $o[1]>Administrator</option><option value="moderator" $o[2]>Moderator</option><option value="banned" $o[3]>Ban Member</option><option value="member" $o[4]>Member</option></select></td></tr>
	<tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1">Signature</font></td><td><textarea name="signature" cols="30" rows="10">$signature</textarea></td></tr>
	$groupselect
        $privateforums
	$permissions
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Submit Changes"></td></tr>
      </table>
    </td></tr></table>
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="member" value="$member">
    </form>
end
}

sub savedit {
  my $inf = get_cookie("mb-admin");
  my($user,$pass) = split(/\|/,$inf);

  my $member = $Pairs{'member'};
  # They do -- load the variables
  my $membertitle   = $Pairs{'membertitle'};
  my $posts         = $Pairs{'posts'};
  my $password      = $Pairs{'password'};
  my $email         = $Pairs{'email'};
  my $homepage      = $Pairs{'homepage'};
  my $aimname       = $Pairs{'aimname'};
  my $msn           = $Pairs{'msn'};
  my $yahoo         = $Pairs{'yahoo'};
  my $icqnumber     = $Pairs{'icqnumber'};
  my $location      = $Pairs{'location'};
  my $offset        = $Pairs{'offset'};
  my $memberstate   = $Pairs{'memberstate'};
  my $posttimelimit = $Pairs{'posttimelimit'};
  my $groups        = $Pairs{'groups'};
  my $signature     = $Pairs{'signature'};
  # User permissions and denies
  my ($permissions,$denies) = form_permissions();

  # Load the member
  get_member($member);

  # Compile the private forums list
  my $privateforums = "";
  for($fid = 1; -d "$cgi_path/forum$fid/"; $fid++) {
    @parts = get_forum_information($fid);
    if($foruminformation{$fid}{'forumstatus'}) {
      if($Pairs{"forum$fid"} eq 'yes') {
        if($privateforums) { $privateforums .= ";$fid"; }
        else               { $privateforums  = $fid;    }
      }
    }
  }
  close(FORUMS);
  
  # Security check: If the calling user is not a member of the Administrators group, they cannot change
  # anybody else to be either.
  #my @grouplist = split(/,/,$groups);
  #foreach my $test (@grouplist) {
  #  if($test eq 'Administrators' && hasgroup($cookieuser,"Administrators") != $TRUE) {
  #    print "<b>Sorry!</b>  You cannot give any account Administrator access without having administrator access yourself.<br>\n";
  #    print "Your user modifications were <i>not</i> saved due to this security issue.<br>\n";
  #    exit;
  #  }
  #}

  # If the password was changed, crypt it now
  if($password) { $password = crypt($password,$users{$member}{'salt'}); }

  # Assign the variables to the corresponding entries
  $users{$member}{'class'}          = $membertitle;
  $users{$member}{'posts'}          = $posts;
  $users{$member}{'email'}          = $email;
  $users{$member}{'homepage'}       = $homepage;
  $users{$member}{'aimname'}        = $aimname;
  $users{$member}{'msnid'}          = $msn;
  $users{$member}{'yahooid'}        = $yahoo;
  $users{$member}{'icqnumber'}      = $icqnumber;
  $users{$member}{'location'}       = $location;
  $users{$member}{'timeoffset'}     = $offset;
  $users{$member}{'memberstate'}    = $memberstate;
  $users{$member}{'privateaccess'}  = $privateforums;
  $users{$member}{'posttimelimit'}  = $posttimelimit;
  $users{$member}{'groups'}         = $groups;
  $users{$member}{'permissions'}    = $permissions;
  $users{$member}{'denies'}         = $denies;
  $users{$member}{'signature'}      = $signature;
  if($password) { $users{$member}{'password'} = $password; }

  # Write the entire user entry back out
  $fmember = $member;  $fmember =~ s/ /_/ig;
  saveuser($member);
   print "<b>The user was editted successfully.</b>";
}

sub letters_header {
  my @list = @members;
  print "<table width=\"100%\"><tr bgcolor=\"$color_config{'nav_top'}\"><td colspan=\"2\" align=\"center\">";
  foreach my $letter (A..Z) {
    @list = grep(/^$letter/i,@list);
    if(@list != 0) { print "<a href=\"$paths{'board_url'}usereditor.cgi?action=list&letter=$letter\">$letter</a>&nbsp;&nbsp;&nbsp;"; }
    @list = @members;
  }
  print "</td></tr></table><br><br>\n";
}
