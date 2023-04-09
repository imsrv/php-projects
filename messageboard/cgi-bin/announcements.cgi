#!/usr/bin/perl

# This script will handle the addition, editting, and display of administrator
# announcements on the front page.
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
# Revision: November 2001

require "global.cgi";

# Send the content header
content();

# Determine the action
$action = $Pairs{'action'};
if(!$action || $action eq 'view') { $msg = "View Announcements";  $active = "Viewing Announcements";     }
elsif($action eq 'edit')          { $msg = "Edit Announcement";   $active = "Editing An Announcement";   }
elsif($action eq 'write_edit')    { $msg = "Edit Announcement";   $active = "Editing An Announcement";   }
elsif($action eq 'new')           { $msg = "Add Announcement";    $active = "Adding An Announcement";    }   
elsif($action eq 'write_new')     { $msg = "Add Announcement";    $active = "Adding An Announcement";    } 
elsif($action eq 'delete')        { $msg = "Delete Announcement"; $active = "Deleting An Announcement";  }
else                              { $msg = "View Announcements";  $active = "Viewing Announcements";     }

# Start the page
page_header("$config{'board_name'} > $msg");
board_header();
user_line();
position_tracker("",$msg);

# Set the user's activity
activeusers($active);

# Determine if it is a board-wide or per-forum announcement
my $forum = $Pairs{'forum'};
if($forum) { $dir = "forum$forum"; } else { $dir = "data"; }

# Pass control to the appopriate function
if(!$action || $action eq 'view') { view();         }
elsif($action eq 'edit')          { edit_form();    }
elsif($action eq 'write_edit')    { write_edit();   }
elsif($action eq 'new')           { add_form();     }
elsif($action eq 'write_new')     { write_new();    }
elsif($action eq 'delete')        { write_delete(); }
else                              { view();         }

page_footer();

# Display all active announcements
sub view {
  # Gather all the entries
  lock_open(ANNOUNCEMENTS,"$cgi_path/$dir/announcements.txt","r");
  @announcements = <ANNOUNCEMENTS>;
  close(ANNOUNCEMENTS);
  
  if(!$announcements[0]) { # No announcements
    print <<end;
      <font face="Verdana" size="2"><b>There are currently no announcements.</b>  Would you like 
      to <a href="$paths{'board_url'}announcements.cgi?action=new&forum=$forum">add one</a></font>?
end
  }

  # Loop through and display the entries
  foreach my $info (@announcements) {
    my($time,$poster,$title,$message) = split(/\|/,$info);
    $message = codeify($message);
    $message = translate_emoticons($message);
    my $postedat = get_time($time,"%th%wn %mn %md, %ye - %hr:%mi %ap");

    $okposter = $poster;   $okposter =~ s/ /\%20/ig;

    # Print this entry
    print <<end
      <table width="$config{'table_width'}" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="$color_config{'border_color'}"><tr><td>
        <table width="100%" cellspacing="1" cellpadding="5" border="0">
          <tr bgcolor="$color_config{'nav_top'}"><td align="center">
            <font face="Verdana" size="3"><b>$title</b></font>
          </td></tr>
          <tr bgcolor="$color_config{'body_bgcolor'}"><td>
            <p><font face="Verdana" size="2"><a href="$paths{'board_url'}announcements.cgi?action=new&forum=$forum">Add Announcement</a> |
            <a href="$paths{'board_url'}announcements.cgi?action=delete&id=$time&forum=$forum">Delete Announcement</a> |
            <a href="$paths{'board_url'}announcements.cgi?action=edit&id=$time&forum=$forum">Edit Announcement</a></font>
            <hr width="100%"></p>
            <font face="Verdana" size="2">$message</font>
            <p><hr width="100%">
            <font face="Verdana" size="1">
              <b>Posted at:</b> $postedat | <b>Posted by:</b> <a href="$paths{'board_url'}profile.cgi?action=view&user=$okposter">$poster</a>
            </font>
          </td></tr>
        </td></tr></table>
      </td></tr></table><br>
end
  }
}

# Delete the specified announcement (there is NO confirm)
sub write_delete {
  my($final,$found) = "";
  
  # Get the user information
  my $inf = get_cookie("mb-user");
  my($user,$pass) = split(/\|/,$inf);
  if(check_account($user,$pass) == $FALSE) {
    redirect_die("You are not logged in or have an invalid cookie.  We're
    redirecting you to the login page.  Please log in and issue your command
    again.","$paths{'board_url'}login.cgi","5","black","Invalid Account");
  }
  if(perms($user,'ANNOUNC') == $FALSE) { noaccess('announce'); }

  # They are logged in and have access, delete the specified entry
  my $id = $Pairs{'id'};
  lock_open(ANNOUNCEMENTS,"$cgi_path/$dir/announcements.txt","rw");
  seek(ANNOUNCEMENTS,0,0);
  while(my $in = <ANNOUNCEMENTS>) {
    my($aid,@rest) = split(/\|/,$in);
    if($id == $aid) { $found = 1; next; }
    $final .= $in;
  }
  # Delete the file
  truncate(ANNOUNCEMENTS,0);
  # Seek back to the top
  seek(ANNOUNCEMENTS,0,0);
  # Write the entry
  print ANNOUNCEMENTS $final;
  close(ANNOUNCEMENTS);

  # Display the status of the delete
  if($found == 1) {
    redirect_die("<b>Thank you!</b>  The announcement has been successfully removed.",
    "","2","black","Selected Announcement Deleted");
  }

  redirect_die("We're sorry, but there was no such announcement with ID \*$id.
  Please try again and be sure to follow only valid links.","","2","black","No Announcements Deleted");
}

sub add_form {
  # Get the cookie information
  my $inf = get_cookie("mb-user");
  my($user,$pass) = split(/\|/,$inf);

  # Compile the form and send it out
  my $form = qq~
    <form action="$paths{'board_url'}announcements.cgi" method="post">
      <table width="100%">
        <tr><td><font face="Verdana" size="1"><b>Username</b></font></td><td><input type="text" name="user" value="$user"></td></tr>
        <tr><td><font face="Verdana" size="1"><b>Password</b></font></td><td><input type="password" name="pass" value="$pass"></td></tr>
        <tr><td><font face="Verdana" size="1"><b>Announcement Title</b></font></td><td><input type="text" name="title"></td></tr>
        <tr><td valign="top"><font face="Verdana" size="1"><b>Announcement</b></font></td><td valign="top"><textarea name="message" cols="40" rows="10"></textarea></td></tr>
      </table>
    <input type="hidden" name="action" value="write_new">
    <input type="submit" name="submit" value="Submit Announcement">
    <input type="hidden" name="forum"  value="$forum">
    </form>~;

   # Send the form into a notice box
   notice_box("Add An Announcement",$form);
}

sub edit_form {
  # Get the cookie information
  my $inf = get_cookie("mb-user");
  my($user,$pass) = split(/\|/,$inf);
  my $id = $Pairs{'id'};
  my($message,$title) = "";

  # Get the announcement information
  lock_open(ANNOUNCEMENTS,"$cgi_path/$dir/announcements.txt","r");
  while(my $in = <ANNOUNCEMENTS>) {
    my($aid,$poster,$a_title,$a_message) = split(/\|/,$in);
    if($id == $aid) { $message = $a_message;  $title = $a_title;  last; }
  }
  close(ANNOUNCEMENTS);
  if(!$message || !$title) {
    redirect_die("There was no such announcement with id \*$id.  Redirecting
    you to the referring page.","","2","black","No Such Announcement");
  }
  $message =~ s/<p>/\n\n/ig;   $message =~ s/<br>/\n/ig;
  $message =~ s/\[p\]/\n\n/ig; $message =~ s/\[br\]/\n/ig;

  # Compile the form and send it out
  my $form = qq~
    <form action="$paths{'board_url'}announcements.cgi" method="post">
      <table width="100%">
        <tr><td><font face="Verdana" size="1"><b>Username</b></font></td><td><input type="text" name="user" value="$user"></td></tr>
        <tr><td><font face="Verdana" size="1"><b>Password</b></font></td><td><input type="password" name="pass" value="$pass"></td></tr>
        <tr><td><font face="Verdana" size="1"><b>Announcement Title</b></font></td><td><input type="text" name="title" value="$title"></td></tr>
        <tr><td valign="top"><font face="Verdana" size="1"><b>Announcement</b></font></td><td valign="top"><textarea name="message" cols="40" rows="10">$message</textarea></td></tr>
      </table>
    <input type="hidden" name="action" value="write_edit">
    <input type="hidden" name="id" value="$id">
    <input type="submit" name="submit" value="Submit Changes">
    <input type="hidden" name="forum"  value="$forum">
    </form>~;

  # Send the form into a notice box
  notice_box("Edit An Announcement", $form);
}

sub write_new {
  # Get the variables
  my $user    = $Pairs{'user'};
  my $pass    = $Pairs{'pass'};
  my $title   = $Pairs{'title'};
  my $message = $Pairs{'message'};
  my $id      = time;

  # Check that they have access to add an announcement
  if(check_account($user,$pass) == $FALSE) {
    redirect_die("Your username/password combination was incorrect.  Please
    try again.","","2","black","Invalid Login");
  }
  if(perms($user,'ANNOUNC') == $FALSE) { noaccess('announce'); }

  # Format the message
  $message =~ s/\n\n/<p>/ig;     $message =~ s/\n/<br>/ig;
  $message =~ s/\r//ig;

  # They have the authority, compile the line and write the entry
  my $line = "$id|$user|$title|$message\n";
  lock_open(ANNOUNCEMENTS,"$cgi_path/$dir/announcements.txt","rw");
  seek(ANNOUNCEMENTS,0,0);
  my @entries = <ANNOUNCEMENTS>;
  truncate(ANNOUNCEMENTS,0);
  seek(ANNOUNCEMENTS,0,0);
  print ANNOUNCEMENTS $line;
  foreach my $entry (@entries) {
    print ANNOUNCEMENTS $entry;
  }
  close(ANNOUNCEMENTS);

  redirect_die("<b>Thank you!</b>  Your announcement has been successfully
  added to the database with ID \*$id.","$paths{'board_url'}announcements.cgi",
  "3","black","Announcement Added");
}

sub write_edit {
  # Get the variables
  my $user    = $Pairs{'user'};
  my $pass    = $Pairs{'pass'};
  my $title   = $Pairs{'title'};
  my $message = $Pairs{'message'};
  my $id      = $Pairs{'id'};
  my($final,$found) = "";

  # Check that they have access to edit an announcement
  if(check_account($user,$pass) == $FALSE) {
    redirect_die("Your username/password combination was incorrect.  Please
    try again.","","2","black","Invalid Login");
  }
  if(perms($user,'ANNOUNC') == $FALSE) { noaccess('announce'); }

  # Format the message
  $message =~ s/\n\n/<p>/ig;     $message =~ s/\n/<br>/ig;
  $message =~ s/\r//ig;

  # Find the entry and replace it, and then write the modified file
  lock_open(ANNOUNCEMENTS,"$cgi_path/$dir/announcements.txt","rw");
  seek(ANNOUNCEMENTS,0,0);
  while(my $in = <ANNOUNCEMENTS>) {
    my($aid,@rest) = split(/\|/,$in);
    if($aid == $id) { $found = 1; $final .= "$aid|$user|$title|$message\n"; }
    else            { $final .= $in;               }
  }
  truncate(ANNOUNCEMENTS,0);
  seek(ANNOUNCEMENTS,0,0);
  print ANNOUNCEMENTS $final;
  close(ANNOUNCEMENTS);

  # Display the results
  if($found == 1) {
    redirect_die("<b>Thank you!</b>  The announcement has been successfully editted.",
    "","2","black","Success!");
  }

  redirect_die("We're sorry, but there was no such announcement with ID \*$id.
  Please try again and be sure to follow only valid links.","","2","black","No Announcements Edited");
}
