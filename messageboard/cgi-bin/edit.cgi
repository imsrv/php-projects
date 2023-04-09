#!/usr/bin/perl

# This script will allow users to edit their messages, or allow moderators and
# administrators to modify ANYBODY's message.
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

# Output the content header
content();

# Get the variables we'll need and test them
$forum = $Pairs{'forum'};
$topic = $Pairs{'topic'};
$id    = $Pairs{'id'};
if(!$forum || !$topic || !$id || !-d "$cgi_path/forum$forum" || !-e "$cgi_path/forum$forum/$topic.thd") {
  redirect_die("You did not supply the required variables to perform this task.",
  "","2","black","<b>Invalid Arguments</b>");
}

# Get the forum information
@foruminfo = get_forum_information($forum);

# Get the topic information
@threadinfo = get_topic_information($forum,$topic);

# Start the page
my @info = split(/\|/,$threadinfo[0]);
page_header("$config{'board_name'} > $info[2]");   # Start the page
board_header();                           # Display the board header
user_line();                              # Display the user information box
my $line = "<a href=\"$paths{'board_url'}forum.cgi\?forum=$forum\">";
$line .= $foruminfo[2];
$line .= "</a>";
position_tracker($foruminfo[13],$line,"Editing topic: $info[2]");

# Send active string
activeusers("Editting <a href=\"$paths{'board_url'}topic.cgi?forum=$forum&topic=$topic\">$info[2]</a> in <a href=\"$paths{'board_url'}forum.cgi?forum=$forum\">$foruminfo[2]</a>");

# Figure out where we're going
$action = $Pairs{'action'};
if($action eq 'postedit') { saveedit(); }

# If we get here, we've got what we need.  Search for the message, grab its
# parameters and pass it to the form
my $infoline = find_message($forum,$topic,$id);
edit_form($infoline);
page_footer();

sub find_message {
  my($forum,$topic,$id) = @_;
  lock_open(thread,"$cgi_path/forum$forum/$topic.thd","r");
  while(my $in = <thread>) {
    my($inid,@rest) = split(/\|/,$in);
    if($inid == $id) {
      close(thread);
      return $in;
    }
  }
  close(thread);
  return "";
}

sub edit_form {
  # Get some variable information
  my @threadinfo = split(/\|/,$_[0]);
  my $inf = get_cookie("mb-user");
  my($user,$pass) = split(/\|/,$inf);
  my $message = $threadinfo[10];
  $message =~ s/\[br\]/\n/ig;     $message =~ s/\[p\]/\n\n/ig;
  if($threadinfo[4] eq 'yes') { $d[0] = "checked"; } else { $d[0] = ""; }
  if($threadinfo[5] eq 'yes') { $d[1] = "checked"; } else { $d[1] = ""; }
  if($threadinfo[6] eq 'yes') { $d[2] = "checked"; } else { $d[2] = ""; }

  # Get the fourm status
  if($foruminfo[7] eq 'guest')      { $forumstatus = "All registered and non-registered users may post in this forum."; }
  elsif($foruminfo[7] eq 'admin')   { $forumstatus = "Only administrators may post in this forum.";                     }
  elsif($foruminfo[7] eq 'mod')     { $forumstatus = "Only moderators or administrators may post in this forum.";       }
  elsif($foruminfo[7] eq 'closed')  { $forumstatus = "No new posts are being accepted for this forum.";                 }
  elsif($foruminfo[7] eq 'private') { $forumstatus = "Only authorized users may post in this forum";                    }
  else                              { $forumstatus = "All registered users may post in this forum.";                    }

  # Get the forum allows
  if($foruminfo[5] eq 'on') {
    $forumallows = "<font face=\"Verdana\" size=\"1\">HTML is <b>enabled</b>.</font><br><br>\n";
  } else {
    $forumallows = "<font face=\"Verdana\" size=\"1\">HTML is <b>disabled</b>.</font><br><br>\n";
  }
  if($foruminfo[6] eq 'on') {
    $forumallows .= "<font face=\"Verdana\" size=\"1\"><a href=\"help.cgi?topic=codes\">ScareCrow Code</a> is <b>enabled</b>.</font><br>\n";
  } else {
    $forumallows .= "<font face=\"Verdana\" size=\"1\"><a href=\"help.cgi?topic=codes\">ScareCrow Code</a> is <b>disabled</b>.</font><br>\n";
  }
  
  # Set whether or not they can modify the title/description
  get_member($user);
  if(check_account($user,$pass) != $FALSE && perms($user,'EDITOTH') == $TRUE && $topic == $id) {
    # Load the title and description from the .idx file
    lock_open(IDX,"$cgi_path/forum$forum/$topic.idx","r");
    my $line = <IDX>;  close(IDX);   my @idxparts = split(/\|/,$line);
    my $title = $idxparts[1];
    my $desc  = $idxparts[2];
    
    $titlemods = qq~
      <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Topic Title</b></td><td><input type="text" name="title" value="$title" maxlength="30"></td></tr>
      <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Topic Description</b></td><td><input type="text" name="description" value="$desc"></td></tr>~;
  } else { $titlemods = ""; }


  # Print the form
  print <<end;
    <form action="$paths{'board_url'}edit.cgi" method="post">
    <table width="$config{'table_width'}" cellspacing="0" cellpadding="0" border="0" bgcolor="$color_config{'border_color'}" align="center"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="3" border="0">
        <tr bgcolor="$color_config{'table_headers'}"><td colspan="2"><font face="Verdana" size="1"><b>$forumstatus</font></b></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Username</b></td><td><input type="text" name="user" value="$user"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Password</b></td><td><input type="password" name="pass" value="$pass"></td></tr>
        $titlemods
        <tr bgcolor="$color_config{'body_bgcolor'}"><td valign="top"><font face="Verdana" size="1"><b>Message</b><br><small>The post you wish to make.<br><br>$forumallows</small></td><td><textarea name="message" cols="50" rows="7">$message</textarea></td></tr>
        <tr bgcolor="$color_config{'nav_top'}"><td valign="top"><font face="Verdana" size="1"><b>Post Options</b></td><td>
          <font face="Verdana" size="1">
            <input type="checkbox" name="signature" value="yes" $d[1]> Add your signature to this post?<br>
            <input type="checkbox" name="emoticons" value="yes" $d[0]> <b>Disable</b> emoticons in this post?<br>
            <input type="checkbox" name="emailreplies" value="yes" $d[2]> Receive email notification of replies?<br>
          </font>
        </tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td valign="top"><font face="Verdana" size="1"><b>Administrative Options</b></font></td><td>
          <font face="Verdana" size="1">
            <input type="checkbox" name="deletethis" value="yes"> Delete this post? (Administrators/moderators only)<br>
            <input type="checkbox" name="hidetag" value="yes"> Hide editted tag (Administrators/moderators only)<br>
          </font>
        </tr>
        <tr><td colspan="2" bgcolor="$color_config{'nav_top'}" align="center"><input type="submit" name="Submit" value="Submit">&nbsp;<input type="reset"></td></tr>
      </table>
    </td></tr></table>
    <input type="hidden" name="action" value="postedit">
    <input type="hidden" name="forum" value="$forum">
    <input type="hidden" name="topic" value="$topic">
    <input type="hidden" name="id" value="$id">
    </form>
end
}

sub saveedit {
  my $user         = $Pairs{'user'};
  my $pass         = $Pairs{'pass'};
  my $ip           = $ENV{'REMOTE_ADDR'};
  my $emoticons    = $Pairs{'emoticons'};
  my $signature    = $Pairs{'signature'};
  my $emailreplies = $Pairs{'emailreplies'};
  my $message      = $Pairs{'message'};
  my $forum        = $Pairs{'forum'};
  my $topic        = $Pairs{'topic'};
  my $id           = $Pairs{'id'};
  my $deletethis   = $Pairs{'deletethis'};
  my $title        = $Pairs{'title'};
  my $description  = $Pairs{'description'};

  # The forum/topic/id were checked earlier.  Move onwards -- get thread info
  my $ret = find_message($forum,$topic,$id);
  my @threadinfo = split(/\|/,$ret);

  # Check that the user is valid and allowed to edit this message.
  if(check_account($user,$pass) == $FALSE) {
    redirect_die("You do not have permission to modify this post.","","2",
                 "black","<b>You Are Not The Post Originator</b>");
  }

  # Check if they want the post deleted rather than edited.
  if($deletethis eq 'yes') {
    if($user eq $threadinfo[1]) {  # The same user is trying to delete it -- do they have permission?
      if(perms($user,'DELEOWN') == $FALSE) { noaccess('deleteown'); }
      deletepost($forum,$topic,$id);
    } else {  # Another user is trying to delete it -- do they have DELEOTH permission?
      if(perms($user,'DELEOTH') == $FALSE) { noaccess('deleteother'); }
      deletepost($forum,$topic,$id);
    }
  }


  # They're editting - If they're not the creator, check if they have permission to edit other posts or deny.
  if($user ne $threadinfo[1]) {
    if(perms($user,'EDITOTH') == $FALSE) { noaccess('editother'); }
  } else {   # If they ARE the creator, check if they have permission to edit their own posts, or deny.
    if(perms($user,'EDITOWN') == $FALSE) { noaccess('editown'); }
  }
  
  
  # Perform some variable neutering
  if($message =~ /\#\s?Moderation Mode/i) {  # Possible avoidance..
   if($users{$user}{'memberstate'} eq 'admin' ||
       $users{$user}{'memberstate'} eq 'moderator' ||
       is_moderator($user,$forum)) { 
         $message =~ s/<!--(.|\n)*-->//g;
         $message =~ s/<script>/\&lt;script\&gt;/ig;
         $message =~ s/\&/\&amp;/g;
         $message =~ s/"/\&quot;/g;
         $message =~ s/  / \&nbsp;/g;
         $message =~ s/\|/\&#0124;/g;
         $message =~ s/\t//g;
         $message =~ s/\r//g;
         $message =~ s/  / /g;
         $message =~ s/\n\n/[p]/g;
         $message =~ s/\n/[br]/g;
    }
   }
   else {
     $message = clean_input($message);
   }
   $title        = substr($title,0,30);
   $title        = clean_input($title);
   $description  = clean_input($description);

  if(!$emoticons) { $emoticons = "no"; }
  if(!$signature) { $signature = "yes";  }
  if(!$emailreplies) { $emailreplies = "no"; }

  # [song] tags
  if($config{'songtags'} eq 'yes') {
    while($message =~ /\[song\]/i) {
      my $song = get_randomsong();
      $message =~ s/\[song\]/$song/i;
    }
  }
  
  # [random] tags
  if($config{'randomtags'} eq 'yes') {
    while($message =~ /\[random\]/i) {
      my $quote = get_randomquote();
      $message =~ s/\[random\]/$quote/i;
    }
  }


   # Add the editted tag to the message if they don't or can't hide it.
  if($Pairs{'hidetag'} eq 'yes' && ($users{$user}{'memberstate'} eq 'admin' ||
     $users{$user}{'memberstate'} eq 'moderator' || is_moderator($user,$forum) == $TRUE)) { }
  else {
       $edittime = get_time(time,"%th%mo/%md/%ye at %hr:%mi %ap");
       $message .= "[br][br][size=1](Editted by $user $edittime.)[/size]";
  }

  # Compile the line by using some new and some old values.
  if(perms($user,'EDITOTH') == $TRUE && ($title || $description)) {
    $flag = 1;
    $line = "$threadinfo[0]|$threadinfo[1]|$title|$threadinfo[3]\+$ip|$emoticons|$signature|$emailreplies|$threadinfo[7]|$threadinfo[8]|$threadinfo[9]|$message\n";
  } else {
    $line = "$threadinfo[0]|$threadinfo[1]|$threadinfo[2]|$threadinfo[3]\+$ip|$emoticons|$signature|$emailreplies|$threadinfo[7]|$threadinfo[8]|$threadinfo[9]|$message\n";
  }
  
  # Look for and replace the line in question
  my $final = "";
  lock_open(editfile,"$cgi_path/forum$forum/$topic.thd","rw");
  seek(editfile,0,0);
  while(my $in = <editfile>) {
    $in = strip($in);
    my @info = split(/\|/,$in);
    if($info[0] == $id) {
      $final .= $line;
    } else {
      my $blah = join('|',@info);
      $final .= "$blah\n";
    }
  }
  truncate(editfile,0);
  seek(editfile,0,0);
  print editfile $final;
  close(editfile);
  
  if($flag == 1) {  # They have administratively modified the title or description
    lock_open(IDX,"$cgi_path/forum$forum/$topic.idx","rw");
    seek(IDX,0,0);
    my $line = <IDX>;
    my @parts = split(/\|/,$line);
    $parts[1] = $title;           # Replace the title
    $parts[2] = $description;     # Replace the description
    # Assemble the line again
    $line = join('|',@parts);
    truncate(IDX,0);    seek(IDX,0,0);
    print IDX $line;
    close(IDX);
    
    # Replace the line in the forum list
    my $final = "";
    lock_open(LIST,"$cgi_path/forum$forum/forum.lst","rw");
    seek(LIST,0,0);
    while($in = <LIST>) {
      my($in_id) = split(/\|/,$in);
      if($in_id == $topic) { # Match topic ID
        $final .= $line;
      } else { $final .= $in; }
    }
    truncate(LIST,0);     seek(LIST,0,0);
    print LIST $final;
    close(LIST);
  }

  redirect_die("Your message has been edited successfully!  You may:<br><br>
  <ul><li><a href=\"$paths{'board_url'}topic.cgi?forum=$forum&topic=$topic\">Return to the topic</a></li>
  <li><a href=\"$paths{'board_url'}forum.cgi?forum=$forum\">Return to the forum</a></li>
  <li><a href=\"$paths{'board_url'}scarecrow.cgi\">Return to the main page</a></li></ul><br>",
  "$paths{'board_url'}topic.cgi?forum=$forum&topic=$topic","3","black",
  "<b>Message Edited Successfully!</b>");
}

sub get_topic_information {
  my($forum,$topic) = @_;
  lock_open(thread,"$cgi_path/forum$forum/$topic.thd",'r');
  my @topicinfo = <thread>;
  close(thread);

  return @topicinfo;
}

sub deletepost {
  my($forum,$topic,$id) = @_;
  my $final = "";

  # Can't delete the thread this way
  if($topic == $id) {
    redirect_die("You cannot delete the first message in a thread.","","3","black","Delete Aborted");
  }

  # All the forum information has been checked, remove the post
  lock_open(THREAD,"$cgi_path/forum$forum/$topic.thd","rw");
  seek(THREAD,0,0);
  while(my $in = <THREAD>) {
    $in = strip($in);
    my($mid,$poster,@rest) = split(/\|/,$in);
    if($id == $mid) { $done = 1; }      # The post to remove
    else { $final .= "$in\n"; }
  }
  # Delete the file and seek to the start
  truncate(THREAD,0);
  seek(THREAD,0,0);
  # Replace the contents
  print THREAD $final;
  close(THREAD);

  # Remove one post from all the counts, including forum totals
  adjust_postcounts($forum,$topic,-1);
  
  # Increment the per-user "deleted post" variables for the poster who posted the deleted message
  get_member($poster);
  $users{$poster}{'deleteposts'}++;
  saveuser($poster);
  
  # Display the results
  if($done == 1) {
    $subject = "Thread Deleted";
    $message = qq~
      Thank you!  The post has been successfully deleted.  You may:<br><br>

      <ul>
        <li><a href="$paths{'board_url'}topic.cgi?forum=$forum&topic=$topic">Return to the topic</a>
        <li><a href="$paths{'board_url'}forum.cgi?forum=$forum">Return to the forum</a>
        <li><a href="$paths{'board_url'}scarecrow.cgi">Return to the forum list</a>
      </ul>~;
  }
  else {
    $subject = "Delete Aborted";
    $message = qq~
      We're sorry, but we could not locate the specified post.  You may:<br><br>

      <ul>
        <li><a href="$paths{'board_url'}topic.cgi?forum=$forum&topic=$topic">Return to the topic</a>
        <li><a href="$paths{'board_url'}forum.cgi?forum=$forum">Return to the forum</a>
        <li><a href="$paths{'board_url'}scarecrow.cgi">Return to the forum list</a>
      </ul>~;
  }

  redirect_die($message,"$paths{'board_url'}topic.cgi?forum=$forum&topic=$topic","3","black",$subject);
}
