#!/usr/bin/perl

# This script will allow the viewing of the active user database.  The IP for
# guest users is only show to those with Administrator access.
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

# Output the content headers
content();

# Board headers
page_header("$config{'board_name'} > Move A Thread");
board_header();
user_line();
position_tracker("","Move a Thread");

# Update the active users list
activeusers("Moving a Post");

# Pass control to the appropriate function
$action = $Pairs{'action'};

if($action eq 'form' || !$action) { moveform(); }
elsif($action eq 'move')          { movepost(); }
else                              { moveform(); }

page_footer();  # Page footer


sub moveform {
  my $forum = $Pairs{'forum'};
  my $topic = $Pairs{'topic'};

  my $forummoveoptions = forumjump();

  my $inf = get_cookie("mb-user");
  my($user,$pass) = split(/\|/,$inf);
  print <<end;
    <form action="$paths{'board_url'}movepost.cgi" method="post">
    <table width="$config{'table_width'}" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}" align="center"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_top'}" align="center"><td colspan="2"><font face="Verdana" size="2"><b>Move A Thread</b></font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td width="35%"><font face="Verdana" size="1"><b>Username</b></font></td><td><input type="text" name="user" value="$user"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Password</b></font></td><td><input type="password" name="pass" value="$pass"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>When this post is moved...</b></font></td><td><input type="radio" name="moveaction" value="lock" checked><font face="Verdana" size="1">Leave a locked copy of this thread in the original forum</font><br><input type="radio" name="moveaction" value="delete"><font face="Verdana" size="1">Delete the thread in the original forum</font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td valign="top"><font face="Verdana" size="1"><br><b>Message</b><br><br>This field is <i>optional</i>.  Only specify a message if you are leaving the locked thread in place.  This is the last message that will appear in the newly locked thread.</font></td><td><textarea name="message" cols="40" rows="10"></textarea></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Move To</b></font></td><td><select name="moveto"><option value=""></option>$forummoveoptions</select></td></tr>
        <tr bgcolor="$color_config{'nav_top'}" align="center"><td colspan="2"><input type="submit" name="submit" value="Move Thread"></td></tr>
      </table>
    </td></tr></table>
    <input type="hidden" name="action" value="move">
    <input type="hidden" name="forum" value="$forum">
    <input type="hidden" name="topic" value="$topic">
    </form>
end
}

sub movepost {
  $user    = $Pairs{'user'};
  $pass    = $Pairs{'pass'};
  my $forum   = $Pairs{'forum'};
  my $topic   = $Pairs{'topic'};
  my $action  = $Pairs{'moveaction'};
  my $message = $Pairs{'message'};
  my $moveto  = $Pairs{'moveto'};

  # Check the user
  if(check_account($user,$pass) == $FALSE) {
    redirect_die("Sorry, you do not have access to this feature or did not log in properly.","","3","black","Move Aborted");
  }
  # Check the variables
  if(!$forum || !$topic || ($action ne 'delete' && $action ne 'lock') || !$moveto) {
    redirect_die("Sorry, but you did not supply the required arguments.  All fields are required except the message.","","3","black","Move Aborted");
  }

  # Figure out the action and pass control off to another function
  if($action eq 'delete') { deletemove($forum,$topic,$moveto); }
  if($action eq 'lock')   { lockmove($forum,$topic,$moveto,$message);   }

}

sub deletemove {
  my($forum,$topic,$moveto) = @_;
  my $final = "";    my $x = 0;

  # Load the thread in first
  lock_open(THREAD,"$cgi_path/forum$forum/$topic.thd","r");
  @entries = <THREAD>;
  close(THREAD);
  # Load the idx file
  lock_open(IDX,"$cgi_path/forum$forum/$topic.idx","r");
  $iline = <IDX>;
  close(IDX);

  # Delete the original thread
  unlink("forum$forum/$topic.thd");
  unlink("forum$forum/$topic.idx");

  # Remove the entry from the original forum's list
  rebuildlist($forum);
  #lock_open(LIST,"$cgi_path/forum$forum/forum.lst","rw");
  #seek(LIST,0,0);
  #while(my $in = <LIST>) {
  #  my($mid,@rest) = split(/\|/,$in);
  #  if($mid == $topic) { $lline = $in; }
  #  else { $final .= $in; }
  #}
  #truncate(LIST,0);
  #seek(LIST,0,0);
  #print LIST $final;
  #close(LIST);
  
  # Get the new message ID for the posts in the next forum
  $mmid = get_next_id($moveto);

  # Write the new .idx file
  $now = time();
  lock_open(IDX,"$cgi_path/forum$moveto/$mmid.idx","w");
  truncate(IDX,0);
  seek(IDX,0,0);
  @parts = split(/\|/,$iline);
  print IDX "$mmid|$parts[1]|$parts[2]|$parts[3]|$parts[4]|$parts[5]|$parts[6]|$parts[7]|$user|$now\n";
  close(IDX);

  # Write the entry into the new list
  lock_open(LIST,"$cgi_path/forum$moveto/forum.lst","rw");
  seek(LIST,0,0);
  @newentries = <LIST>;
  truncate(LIST,0);
  seek(LIST,0,0);
  @parts = split(/\|/,$iline);
  print LIST "$mmid|$parts[1]|$parts[2]|$parts[3]|$parts[4]|$parts[5]|$parts[6]|$parts[7]|$user|$now\n";
  foreach $entry (@newentries) {
    $entry = strip($entry);   $entry .= "\n";
    print LIST $entry;
  }
  close(LIST);

  # Write the new thread file
  lock_open(THREAD,"$cgi_path/forum$moveto/$mmid.thd","w");
  truncate(THREAD,0);
  seek(THREAD,0,0);
  foreach $entry (@entries) {
    $entry = strip($entry);
    $x++;
    @parts = split(/\|/,$entry);
    if($x == 1) {
      print THREAD "$mmid|$parts[1]|$parts[2]|$parts[3]|$parts[4]|$parts[5]|$parts[6]|$parts[7]|$parts[8]|$parts[9]|$parts[10]\n";
    }
    else {
      $mid = get_next_id($moveto);
      print THREAD "$mid|$parts[1]|$parts[2]|$parts[3]|$parts[4]|$parts[5]|$parts[6]|$parts[7]|$parts[8]|$parts[9]|$parts[10]\n";
    }
  }
  close(THREAD);
  
  # If there is a poll, move it.
  if(-e "$cgi_path/forum$forum/$topic.poll") {
    # Load the poll information into the @poll array
    lock_open(POLL,"$cgi_path/forum$forum/$topic.poll","r");
    my @poll = <POLL>;
    close(POLL);
    
    # Write the information into the new poll file
    lock_open(POLL,"$cgi_path/forum$moveto/$mmid.poll","w");
    truncate(POLL,0);   seek(POLL,0,0);
    foreach my $line (@poll) { print POLL $line; }
    close(POLL);
    
    # Remove the old poll
    unlink "$cgi_path/forum$forum/$topic.poll";
  }
  

  my $totalremoved = @entries;
  # Success!
  success($forum,$moveto,$totalremoved);
}

sub lockmove {
  my($forum,$topic,$moveto,$message) = @_;
  my $x = 0;

  # Get the current thread line
  lock_open(THREAD,"$cgi_path/forum$forum/$topic.idx","rw");
  seek(THREAD,0,0);
  $iline = <THREAD>;
  $iline = strip($iline);
  my @parts = split(/\|/,$iline);
  # Change the lastpost data and lock the thread
  $parts[3] = "locked";
  if($message) { $parts[4]++; increase_forum_count($forum,'posts',1); }
  $parts[8] = $user;
  $parts[9] = time;
  $newiline = join('|',@parts);
  truncate(THREAD,0);
  seek(THREAD,0,0);
  print THREAD "$newiline\n";
  close(THREAD);

  # Gather the current thread
  lock_open(THREAD,"$cgi_path/forum$forum/$topic.thd","r");
  @entries = <THREAD>;
  close(THREAD);

  # Append the locked message, if any, to the old forum
  if($message) {
    $message =~ s/\n\n/<p>/ig;     $message =~ s/\n/<br>/ig;
    $mid = get_next_id($forum);
    $now = time;
    lock_open(THREAD,"$cgi_path/forum$forum/$topic.thd","a");
    seek(THREAD,0,2);
    print THREAD "$mid|$user||$ENV{'REMOTE_ADDR'}|no|no|no|$now|0|0|$message\n";
    close(THREAD);
  }

  # Write the new index file
  $mmid = get_next_id($moveto);
  @parts = split(/\|/,$iline);
  lock_open(NEWIDX,"$cgi_path/forum$moveto/$mmid.idx","w");
  truncate(NEWIDX,0);
  seek(NEWIDX,0,0);
  $parts[0] = $mmid;
  $parts[3] = "open";
  $parts[8] = $user;
  $parts[9] = time;
  $iline = join('|',@parts);
  print NEWIDX "$iline\n";
  close(NEWIDX);

  # Write the new thread
  lock_open(THREAD,"$cgi_path/forum$moveto/$mmid.thd","w");
  truncate(THREAD,0);   seek(THREAD,0,0);
  $x = 0;
  foreach $entry (@entries) {
    $entry = strip($entry);
    $x++;
    @parts = split(/\|/,$entry);
    if($x == 1) {
      print THREAD "$mmid|$parts[1]|$parts[2]|$parts[3]|$parts[4]|$parts[5]|$parts[6]|$parts[7]|$parts[8]|$parts[9]|$parts[10]\n";
    }
    else {
      $mid = get_next_id($moveto);
      print THREAD "$mid|$parts[1]|$parts[2]|$parts[3]|$parts[4]|$parts[5]|$parts[6]|$parts[7]|$parts[8]|$parts[9]|$parts[10]\n";
    }
  }
  close(THREAD);


  # If there is a poll, move it.
  if(-e "$cgi_path/forum$forum/$topic.poll") {
    # Load the poll information into the @poll array
    lock_open(POLL,"$cgi_path/forum$forum/$topic.poll","r");
    my @poll = <POLL>;
    close(POLL);
    
    # Write the information into the new poll file
    lock_open(POLL,"$cgi_path/forum$moveto/$mmid.poll","w");
    truncate(POLL,0);   seek(POLL,0,0);
    foreach my $line (@poll) { print POLL $line; }
    close(POLL);
    
    # Set the poll as LOCKED in the array
    $poll[0] = "locked\n";
    # Write the poll back as locked into the original poll file
    lock_open(POLL,"$cgi_path/forum$forum/$topic.poll","w");
    truncate(POLL,0);   seek(POLL,0,0);
    foreach my $line (@poll) { print POLL $line; }
    close(POLL);
  }


  # Rebuild the forum lists
  rebuildlist($forum);
  rebuildlist($moveto);

  my $totalremoved = @entries;
  # Success!
  success($forum,$moveto,0,$totalremoved);

}

sub success {
  my($forum,$moveto,$totalremoved,$totaladded) = @_;
  my $final = "";

  # Update the last modified and last poster tags for both forums
  lock_open(FORUMS,"$cgi_path/data/forum.lst","rw");
  seek(FORUMS,0,0);
  while(my $in = <FORUMS>) {
    $in = strip($in);
    my @parts = split(/\|/,$in);
    if($parts[1] == $forum && $totalremoved != 0) {
      $parts[9] -= $totalremoved;
      $parts[10]--;
      $parts[11] = time;     $parts[12] = $user;
    }
    if($parts[1] == $moveto) {
      $parts[9] += $totaladded;
      $parts[10]++;
      $parts[11] = time;     $parts[12] = $user;
    }
    $in = join('|',@parts);
    $final .= "$in\n";
  }
  truncate(FORUMS,0);
  seek(FORUMS,0,0);
  print FORUMS $final;
  close(FORUMS);

  # Display the results
  notice_box("Move Successful!","Thank you!  The message has successfully been moved.");
}
