#!/usr/bin/perl

# This script allows administrators and/or specified users to view the
# validation queues for both forums and the board users, and optionally
# validate said users and posts.
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
# Author: Jonathan Bravata
# Revision: October 2001

require "global.cgi";
require "admin.lib";

# Check the cookie
$inf = get_cookie("mb-admin");
($cookieuser,$cookiepassword) = split(/\|/,$inf);

if(!$cookieuser) {   # Give them a chance to log in the admin cookie
  content();
  page_header("$config{'board_name'} > Queue Monitor");
  admin_login("$paths{'board_url'}queue.cgi");
  page_footer();
  exit;
}

if(check_account($cookieuser,$cookiepassword) == $FALSE) {
  redirect_die("We're sorry, but your username/password combination was
  invalid or you do not have access to this area.","","4","black","You Do Not Have Access");
}

# Output the content type
content();
page_header("$config{'board_name'} > Queue Monitor");

# Determine action and pass control to the appropriate function
$action = $Pairs{'action'};

# Check the action and pass control to the appropriate function
if($action eq 'viewusers')        { view_user_queue(); }   # done
elsif($action eq 'viewqueue')     { view_queue();      }
elsif($action eq 'validateusers') { validate_users();  }   # done
elsif($action eq 'validatequeue') { validate_queue();  }
else	      	 		  { view_user_queue(); }   # done


sub view_user_queue {
  # Check the permission first
  if(perms($cookieuser,'UQUEUE') == $FALSE) { noaccess('userqueue'); }
  
  # They have access at this point.  Gather the data to view the user queue.
  lock_open(QUEUE,"$cgi_path/data/users.queue","r");
  my @queueusers = <QUEUE>;
  close(QUEUE);
  
  # @queueusers contains a list of users that need to be validated.  Compile a table with
  # validation options.
  # First, the table header information
  my $output = qq~
    <table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" border="$color_config{'border_color'}"><tr><td>
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_bottom'}"><td colspan="3"><font face="Verdana" size="2"><b>&#187; User Queue</b></font></td></tr>
	<tr bgcolor="$color_config{'nav_top'}">
	  <td><font face="Verdana" size="2"><b>Approve/Deny</b></font></td>
	  <td><font face="Verdana" size="2"><b>Username</b></font></td>
	  <td><font face="Verdana" size="2"><b>Profile / Delete</b></font></td>
	</tr>
  ~;
  # Compile the body rows
  foreach my $user (@queueusers) {
    $user = strip($user);
    $output .= qq~
      <tr bgcolor="$color_config{'body_bgcolor'}">
        <td><input type="radio" name="$user" value="approved"><font face="Verdana" size="1"> Approve</font>&nbsp;&nbsp;<input type="radio" name="$user" value="denied"><font face="Verdana" size="1"> Deny</font></td>
	<td><font face="Verdana" size="2"><b>$user</b></font></td>
	<td><font face="Verdana" size="1">
	  <a href="$paths{'board_url'}profile.cgi?action=view&member=$user">View User Profile</a> | 
	  <a href="$paths{'board_url'}usereditor.cgi?action=edit&member=$user">Edit User</a>
	</font></td>
      </tr>
    ~;
  }
  # Compile the footer
  $output .= qq~
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="3" align="center"><input type="submit" name="submit" value="Approve Selected Users"></td></tr>
      </table>
    </td></tr></table>
  ~;
  
  # Print the form
  print $output;
}

sub view_queue {
  # Check the permission first
  if(perms($cookieuser,'QUEUE') == $FALSE) { noaccess('queue'); }
  
  # They have access at this point.  Gather the data to view the forum queues.
  my $forum = $Pairs{'forum'};   # The forum to view the queue for
  
  # Load the queue
}

sub vaidate_users {
  # Check the permission first
  if(perms($cookieuser,'UQUEUE') == $FALSE) { noaccess('userqueue'); }
 
  # They have access at this point.  Gather the data to modify the user queue.
  lock_open(QUEUE,"$cgi_path/data/users.queue","r");
  my @users = <QUEUE>;
  close(QUEUE);
  
  # Compile the subject/message for approval PMs
  my $subject = qq~Your Account Has Been Validated~;
  my $message = qq~
    [p]Your account has been validated by the administration.  It is now fully functional.  We thank
    you for your patience during the validation process.
    [p]- The Administration
  ~;
  $message =~ s/\n/\[br\]/ig;
  
  foreach my $user (@users) {
    $user = strip($user);
    # Check if they are deleted or approved
    if($Pairs{$user} eq 'approved') {
      get_member($user);                     # Load the user account into memory
      $users{$user}{'validated'} = "yes";    # Change their validation state
      saveuser($user);                       # Save the user back to file

      # Send the user a private message that they have been approved
      my $now = time();
      lock_open(PMS,"$cgi_path/private/$user\.in","a");
      print PMS "$now|$subject|$config{'board_name'}|$now|n|$message\n";
      close(PMS);
    
      # Increment total
      $total++;
    } elsif($Pairs{$user} eq 'denied') {
      get_member($user);                     # Load the user account into memory
      # Do not do anything to approve the account.  Delete it instead.
      unlink "$cgi_path/members/$user.dat";
      
      # Send them an email that they have been disapproved.
      send_mail($users{$user}{'email'}, "Your Account Has Been Disapproved", "The account you registered  at $config{'board_name'} has been disapproved and deleted.  You do not have user access to the message board.  We are sorry for any inconveinience.");
      
      $total++;
    } else {
      # Requeue it and do not approve or deny the entry (essentially say, "I'll deal with this later").
      $final .= "$user\n";
    }
  }
  
  # Rewrite those not approved and not denied back into the queue
  lock_open(QUEUE,"$cgi_path/data/users.queue","w");
  truncate(QUEUE,0);    seek(QUEUE,0,0);
  print QUEUE $final;
  close(QUEUE);
      
  # Update the user on the progress
  if($total == 0) {
    $message = qq~You did not approve or deny any users.  No users were removed from the queue.~;
  }
  elsif($total == 1) {
    $message = qq~The selected user has been handled and has been removed from the list.  Thank you!~;
  }
  else {
    $message = qq~The selected users have been handled and have been removed from the list.  Thank you!~;
  }
}

sub validate_queue {
  # Check the permission first
  if(perms($cookieuser,'QUEUE') == $FALSE) { noaccess('queue'); }
  
  # They have access at this point.  Gather the data to modify the forum queues.
}
