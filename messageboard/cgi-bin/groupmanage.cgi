#!/usr/bin/perl

# This script handles adding, removing and editting of groups within
# ScareCrow, including permissions, denies and titles.
#
# Revision: October 2001
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

require "global.cgi";    # Load the global functions
require "admin.lib";     # Require global admin functions

# Check the cookie
$inf = get_cookie("mb-admin");
($cookieuser,$cookiepassword) = split(/\|/,$inf);

if(!$cookieuser) {   # Give them a chance to log in the admin cookie
  content();
  page_header("$config{'board_name'} > Group Manager");
  admin_header();
  admin_login("$paths{'board_url'}groupmanage.cgi");
  admin_footer();
  exit;
}

if(check_account($cookieuser,$cookiepassword) == $FALSE || perms($cookieuser,"ADMINCP") == $FALSE) {
  redirect_die("We're sorry, but your username/password combination was
  invalid or you do not have access to this area.","","4","black","You Do Not Have Access");
}

content();
page_header("$config{'board_name'} > Group Manager");    # Set up the page

# Get the action and pass control to the proper function
$action = $Pairs{'action'};

if($action eq 'edit')     { groupedit(); }
elsif($action eq 'gedit') { editgroup(); }
elsif($action eq 'add')   { groupadd();  }
elsif($action eq 'gadd')  { addgroup();  }
elsif($action eq 'del')   { groupdel();  }
elsif($action eq 'gdel')  { delgroup();  }
else                      { grouplist(); }

page_footer();    # End the page gracefully


# Get the list of groups that are currently set up and provide a method for selecting one
sub grouplist {
  lock_open(GROUPS,"$cgi_path/data/groups.txt","r");
  my @groups = <GROUPS>;
  close(GROUPS);

  if(!-e "$cgi_path/data/groups.txt" || !$groups[0]) {  # No groups yet
    print "You currently do not have any groups set up.  Would you like to <a href=\"$paths{'board_url'}groupmanage.cgi?action=add\">add one</a>?<br>\n";
    exit;
  }
  
  # Begin creating the table
  print <<end;
    <table width="96%" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_top'}">
	  <td><font face="Verdana" size="2"><b>Group Name</b></font></td>
	  <td><font face="Verdana" size="2"><b>Options</b></font></td>
	</tr>
end

  foreach my $group (@groups) {
    $group = strip($group);
    my($name,$permissions,$denies) = split(/\|/,$group);
    $lname = $name;    $lname =~ s/ /\%20/ig;
    
    # Compile the table for this entry
    print <<end;
          <tr bgcolor="$color_config{'body_bgcolor'}">
	    <td><font face="Verdana" size="2">$name</font></td>
	    <td><font face="Verdana" size="2">
	      <a href="$paths{'board_url'}groupmanage.cgi?action=edit&group=$lname">Edit</a> |
	      <a href="$paths{'board_url'}groupmanage.cgi?action=del&group=$lname">Delete</a>
	    </font></td>
	  </tr>
end
  }
  
  # End the table
  print <<end;
      </table>
    </td></tr></table>
end
}

# Provides the form to add a group
sub groupadd {
  my $permissionsform = permissions_form();
  print <<end;
    <form action="$paths{'board_url'}groupmanage.cgi" method="post">
    <table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_bgcolor'}"><tr><td>
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><font face="Verdana" size="2"><b>Add a Group</b></font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Group Name</b></font></td>
	  <td><input type="text" name="name"></td>
	</tr>
	<tr><td colspan="2">$permissionsform</td></tr>
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Add Group"></td></tr>
    </td></tr></table>
    <input type="hidden" name="action" value="gadd">
    </font>
end
}

# Performs the actual addition of the group
sub addgroup {

  # Get permissions lists from variables
  ($permissions,$denies) = form_permissions();
  
  # Get the group name
  my $name = $Pairs{'name'};
  my $cname = $name;   $cname =~ tr/A-Z/a-z/;
  my $final = "";
  
  # Check that it doesn't conflict
  lock_open(GROUPS,"$cgi_path/data/groups.txt","r");
  while($in = <GROUPS>) {
    my($iname,$ipermissions,$idenies) = split(/\|/,$in);
    $iname =~ tr/A-Z/a-z/;
    if($cname eq $iname) {  # Case-insensitive match has been made
      print "That user already exists.  If you wish to change the permissions associated with it, please use the edit form instead.<br>\n";  exit;
      exit;
    }
    $final .= $in;
  }
  close(GROUPS);
  
  # If we reach this point, it is a new group to be added
  $final .= "$name|$permissions|$denies\n";
  
  # Re-write the file
  lock_open(GROUPS,"$cgi_path/data/groups.txt","w");
  truncate(GROUPS,0);   seek(GROUPS,0,0);
  print GROUPS $final;
  close(GROUPS);
  
  print "Thank you!  <b>$name</b> has successfully been added.<br>\n";
}


# Provides the form to edit a specific group
sub groupedit {
  # Get the name of the group
  my $name = $Pairs{'group'};
  
  # Get the data for the current group
  lock_open(GROUPS,"$cgi_path/data/groups.txt","r");
  while($in = <GROUPS>) {
    ($iname,$permissionlist,$denylist) = split(/\|/,$in);
    if($name eq $iname) { $ok = 1; last; }
  }
  close(GROUPS);
  if($ok != 1) {
    print "We're sorry, but we could not find the selected group.  Please try again.<br>\n";
    exit;
  }
  

  # Get the permission form with defaults placed in.
  my $permissionsform = permissions_form($permissionlist,$denylist);

  # Start the table
  print <<end;
    <form action="$paths{'board_url'}groupmanage.cgi" method="post">
    <table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_bgcolor'}"><tr><td>
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><font face="Verdana" size="2"><b>Editting Group: $name</b></font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Group Name</b></font></td>
	  <td><font face="Verdana" size="2"><b>$name</b></font></td>
	</tr>
	<tr><td colspan="2">$permissionsform</td></tr>
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Submit Changes"></td></tr>
      </table>
    </td></tr></table>
    <input type="hidden" name="action" value="gedit">
    <input type="hidden" name="group" value="$name">
    </font>
end
  

}

# Performs the actual edit to the group
sub editgroup {
  # Get the permissions that were made
  my($permissions,$denies) = form_permissions();
  # Get the group name
  my $name = $Pairs{'group'};
  my $final = "";
  
  # Make the changes to the file
  lock_open(GROUPS,"$cgi_path/data/groups.txt","rw");
  seek(GROUPS,0,0);
  while($in = <GROUPS>) {
    $in = strip($in);
    my($iname,$ipermissions,$idenies) = split(/\|/,$in);
    if($name eq $iname)  {  # Match!
      $ok = 1;
      $ipermissions = $permissions;
      $idenies = $denies;
    }
    # Recompile the string
    $in = "$iname|$ipermissions|$idenies\n";
    # Add it onto the end
    $final .= $in;
  }
  truncate(GROUPS,0);
  seek(GROUPS,0,0);
  print GROUPS $final;
  close(GROUPS);
  
  # Announce the progress
  if($ok != 1) {
    print "We're sorry, but we could not find the specified group.  Please try again.<br>\n";
  } else {
    print "Thank you!  <b>$name</b> has successfully been editted.<br>\n";
  }
}

# Provides confirmation for the delete
sub groupdel {
  # Get the name
  my $name = $Pairs{'group'};
  
  # Set up the form
  print <<end;
    <table width="98%" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <form action="$paths{'board_url'}groupmanage.cgi" method="post">
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <!-- Header -->
	<tr bgcolor="$color_config{'nav_top'}"><td align="center"><font face="Verdana" size="2"><b>Really Delete $name?</b></font></td></tr>
	<!-- Body/Warning -->
	<tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="2">
	<b>Warning!</b>  Deleting a group is <i>irreversible</i> and <i>permenant</i>.  Please click the
	button below only if you are sure you want to delete the group <b>$name</b>.
	</font></td></tr>
	<!-- Footer/Confirmation Button -->
	<tr bgcolor="$color_config{'nav_top'}"><td align="center"><input type="submit" name="submit" value="Delete $name"></td></tr>
      </table>
      <input type="hidden" name="group" value="$name">
      <input type="hidden" name="action" value="gdel">
      </form>
    </td></table>
end
}

# Performs the actual deletion of the group
sub delgroup {
  # Get the group name
  my $name = $Pairs{'group'};
  
  # Make sure it is not one of the restricted groups to delete
  if($name eq 'Administrators' || $name eq 'Guests') {
    print "<font face=\"Verdana\" size=\"2\"><b>Delete aborted.</b>  You may not delete either of the two mandatory groups: Administrators and
    Guests.  This is for security and practicality purposes.  <b>$name</b> was NOT deleted.</font>";
    exit;
  }
  
  # Look for it and delete it if found
  lock_open(GROUPS,"$cgi_path/data/groups.txt","rw");
  seek(GROUPS,0,0);
  while($in = <GROUPS>) {
    my($iname) = split(/\|/,$in);
    if($iname eq $name)  { # Found the one to delete -- do nothing but set the toggle that we got it
      $ok = 1;
    }
    else { $final .= $in; }
  }
  truncate(GROUPS,0);
  seek(GROUPS,0,0);
  print GROUPS $final;
  close(GROUPS);
  
  # Announce the progress
  if($ok == 1) {
    print "Thank you!  <b>$name</b> has successfully been removed from the system.<br>\n";
  } else {
    print "We're sorry, we could not locate <b>$name</b> in the group list.  Please try again.<br>\n";
  }
  
}
