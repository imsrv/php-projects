#!/usr/bin/perl

# This script handles submission of votes for a poll, creation of new polls
# and display the results for a poll.  It also provides the forms and
# functionality for the administration to lock, unlock and delete polls,
# independent of the thread itself.
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

# Set up the page
$forum = $Pairs{'forum'};

# Get the forum information
@foruminfo = get_forum_information($forum);

# Check the action
my $action = $Pairs{'action'};

if($action eq 'vote')       { $loc = "Voting on a Poll"; }
elsif($action eq 'create')  { $loc = "Creating a Poll";  }
elsif($action eq 'howmany') { $loc = "Creating a Poll";  }
elsif($action eq 'save')    { $loc = "Creating a Poll";  }
else                        { $loc = "Creating a Poll";  }

# Start the page
content();
page_header("$config{'board_name'} > $loc");   # Start the page
board_header();                           # Display the board header
user_line();                              # Display the user information box
position_tracker($foruminfo[13],"<a href=\"$paths{'board_url'}forum.cgi?forum=$forum\">$foruminfo[2]</a>",$loc);

# Send the active user data
if($foruminformation{$forum}{'forumstatus'} eq 'private') {  # Private does not show active users
  check_private(@foruminfo);
} else {
  activeusers("$loc in <a href=\"$paths{'board_url'}forum.cgi?forum=$forum\">$foruminfo[2]</a>");
}

# Pass control to the appropriate function
if($action eq 'vote')       { submitvote(); }
elsif($action eq 'create')  { createpoll(); }
elsif($action eq 'howmany') { howmany();    }
elsif($action eq 'save')    { savepoll();   }
elsif($action eq 'modifypoll') { lockunlockdeletepoll(); }
elsif($action eq 'modify')  { lockunlockform(); }
else                        { createpoll(); }

page_footer();

sub howmany {
  my $forum = $Pairs{'forum'};
  get_forum_information($forum);
  if($foruminformation{$forum}{'pollallow'} eq 'no') {
    notice_box("This Forum Does Not Accept Polls","We're sorry, but this forum has been set not to accept any user polls.");
    exit;
  }
  
  print <<end;
    <table width="$config{'table_width'}" border="0" cellspacing="0" cellpadding="0" border="0" bgcolor="$color_config{'border_color'}" align="center"><tr><td>
      <form action="$paths{'board_url'}poll.cgi" method="post">
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="2"><b>Poll Configuration - Step 1</b></font></td></tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>How Many Options Will This Poll Have?</b></font></td>
	  <td><input type="text" name="howmany"></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>How Many Choices May The Voter Make?</b></font></td>
	  <td><input type="text" name="choices"></td>
	</tr>
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Continue"></td></tr>
      </table>
      <input type="hidden" name="action" value="create">
      <input type="hidden" name="forum"  value="$Pairs{'forum'}">
      </form>
    </td></tr></table>
end
}

# Prints the form for creating the actual poll
sub createpoll {
  my $forum = $Pairs{'forum'};
  
  get_forum_information($forum);
  if($foruminformation{$forum}{'pollallow'} eq 'no') {
    notice_box("This Forum Does Not Accept Polls","We're sorry, but this forum has been set not to accept any user polls.");
    exit;
  }

  my($user,$pass) = split(/\|/,get_cookie("mb-user"));
  
  print <<end;
    <table width="$config{'table_width'}" border="0" cellspacing="0" cellpadding="0" border="0" bgcolor="$color_config{'border_color'}" align="center"><tr><td>
      <form action="$paths{'board_url'}poll.cgi" method="post">
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_bottom'}"><td colspan="2"><font face="Verdana" size="2"><b>Poll Configuration - Step 2</b></font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td width="30%"><font face="Verdana" size="1" color="$colors[1]"><b>Username</b></td><td><input type="text" name="user" value="$user"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1" color="$colors[2]"><b>Password</b></td><td><input type="password" name="pass" value="$pass"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1" color="$colors[3]"><b>Topic Title</b></font><br><font face="Verdana" size="1">The topic of your post.  <i>Required.</i></font></font></td><td><input type="text" name="title" maxlength="30" value="$_[2]"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Topic Description</b></font><br><font face="Verdana" size="1">A brief topic description.</font></td><td><input type="text" name="description" maxlength="50" value="$_[3]"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td valign="top"><font face="Verdana" size="1" color="$colors[5]"><b>Message</b></font><br><font face="Verdana" size="1">The post you wish to make.<br><br>$forumallows</font></td><td><textarea name="message" cols="40" rows="9">$quote$_[4]</textarea></td></tr>
        <tr bgcolor="$color_config{'nav_top'}"><td valign="top"><font face="Verdana" size="1"><b>Post Options</b></td><td>
          <font face="Verdana" size="1">
            <input type="checkbox" name="signature" value="yes" checked> Add your signature to this post?<br>
            <input type="checkbox" name="emoticons" value="yes" $d[1]> <b>Disable</b> emoticons in this post?<br>
          </font>
        </tr>
	<tr bgcolor="$color_config{'nav_top'}">
	  <td><font face="Verdana" size="2"><b>Poll Question</b></font></td>
	  <td><input type="text" name="question"></td>
	</tr>
end
  # Print the option lines
  for($x = 1; $x <= $Pairs{'howmany'}; $x++) {
    print <<end;
          <tr bgcolor="$color_config{'nav_top'}">
	    <td><font face="Verdana" size="2"><b>Option $x</font></td>
	    <td><input type="text" name="option-$x"></td>
	  </tr>
end
  }
  
  # Finish the table
  print <<end;
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Continue"></td></tr>
      </table>
      <input type="hidden" name="action"  value="save">
      <input type="hidden" name="forum"   value="$Pairs{'forum'}">
      <input type="hidden" name="howmany" value="$Pairs{'howmany'}">
      </form>
    </td></tr></table>
end
}

sub savepoll {
  my $forum = $Pairs{'forum'};
  
  get_forum_information($forum);
  if($foruminformation{$forum}{'pollallow'} eq 'no') {
    notice_box("This Forum Does Not Accept Polls","We're sorry, but this forum has been set not to accept any user polls.");
    exit;
  }

  # Check all the variables
  $user        = $Pairs{'user'};
  $pass        = $Pairs{'pass'};
  $question    = $Pairs{'question'};
  $forum       = $Pairs{'forum'};
  $title       = $Pairs{'title'};
  $description = $Pairs{'description'};
  $message     = $Pairs{'message'};
  $signature   = $Pairs{'signature'};
  $emoticons   = $Pairs{'emoticons'};
  for($x = 1; ; $x++) {
    if($Pairs{"option-$x"}) { $options[$x] = $Pairs{"option-$x"}; }
    else { last; }
  }
  
  # Set some defaults
  if(!$signature) { $signature = "no"; }
  if(!$emoticons) { $emoticons = "no"; }
                    $emailreplies = "no";

  # Check that the account is valid
  if(check_account($user,$pass) == $FALSE) {
    redirect_die("Your username/password combination was invalid.","","4","black","Invalid Login");
  }
  # Check that all required variables exist
  if(!$question || !$forum || !-d "$cgi_path/forum$forum" || !$title || !$message || !$emoticons || !$signature) {
    redirect_die("The required variables were not specified or were not valid.  Please try again.","","3","black","Invalid Parameters");
  }
  
  # Neuter some variables before we continue
  # Get some additional variables
   $time = time();     $ip = $ENV{'REMOTE_ADDR'};
   $mid = get_next_id($forum);
   # Format some other variables
   if($foruminfo[5] eq 'on') { $message = cleanit($message); }
   elsif($message =~ /\#\s?Moderation Mode/i) {  # Possible avoidance..
    if($users{$user}{'memberstate'} eq 'admin' ||
       $users{$user}{'memberstate'} eq 'moderator' ||
       is_moderator($user,$forum)) {
         $message = cleanit($message);
    }
   }
   else {
     $message = clean_input($message);
   }
   $message      = censor($forum,$message);
   $title        = substr($title,0,30);
   $title        = clean_input($title);
   $description  = clean_input($description);
   $question     = clean_input($question);
   
   # Compile the option list, and set 0's for the vote list while we're doing it
   for($x = 1; ; $x++) {
     if(!$options[$x]) { last; }
     if($optionlist) { $optionlist .= "|$options[$x]"; }
     else            { $optionlist  = $options[$x];    }
     if(length($votelist) > 0)   { $votelist   .= "|0";            }
     else                        { $votelist    = "0";             }
   }
  
  # Save all the poll data before we handle anything else.
  lock_open(POLL,"$cgi_path/forum$forum/$mid.poll","w");
  truncate(POLL,0);   seek(POLL,0,0);
  print POLL "open\n$question\n$optionlist\n$votelist\n\n";
  close(POLL);
  
  # Now deal with the post that has to be made.
  # Check if they can post a new topic
  if(perms($user,'POSTNEW') == $FALSE) { noaccess('postnew'); }
  if(hasgroup($user,$foruminformation{$forum}{'canpost'}) != $TRUE) { noaccess('postnew'); }
  # Compile the line to save
  my $line   = "$mid|$title|$description|open|0|0|$user|$time|$user|$time\n";
  my $thline = "$mid|$user|$title|$ip|$emoticons|$signature|$emailreplies|$time|0|0|$message\n";

  # Open and write the index file
  lock_open(newthread,"$cgi_path/forum$forum/$mid.idx","w");
  truncate(newthread,0);   seek(newthread,0,0);
  print newthread $line;
  close(newthread);

  # Write the entry into the forum list
  lock_open(forumlist,"$cgi_path/forum$forum/forum.lst","r");
  my @entries = <forumlist>;
  push @entries,$line;
  close(forumlist);

  lock_open(forumlist,"$cgi_path/forum$forum/forum.lst","w");
  truncate(forumlist,0);   seek(forumlist,0,0);
  foreach my $entry (@entries) {
    $entry = strip($entry);       $entry .= "\n";
    print forumlist $entry;
  }
  close(forumlist);

  # Open and write the thread file
  lock_open(newthread,"$cgi_path/forum$forum/$mid.thd","w");
  truncate(newthread,0);
  seek(newthread,0,0);
  print newthread $thline;
  close(newthread);

  # Increase the post counts
  increase_forum_count($forum,"bothupdate",1,$time,$user);
  give_post($user,1);

  # Check forum restrictions
  require "timedforums.lib";
  cleanforum($forum);
  lastpost($user,$forum,$foruminfo[2],$mid,$title,time);
     
  # If set, send a copy of this message to the administrator
  if($config{'emailallposts'} eq 'on') {
    send_copy($forum,$topic,$user,$title,$ip,$time,$message);
  }

  # Update the user on the progress
  redirect_die("Thank you!  Your poll has successfully been created.  You may:<br><br>
    <ul><li><a href=\"$paths{'board_url'}topic.cgi?forum=$forum&topic=$mid\">Return to the new poll</a></li>
    <li><a href=\"$paths{'board_url'}forum.cgi?forum=$forum\">Return to the forum</a></li>
    <li><a href=\"$paths{'board_url'}scarecrow.cgi\">Return to the main page</a></li></ul>",
    "$paths{'board_url'}topic.cgi?forum=$forum&topic=$mid","5","black","<b>Poll Created Successfully!</b>");

}

sub submitvote {
  # Get the necessary variables
  my $pollid       = $Pairs{'pollid'};
  my $vote         = $Pairs{'voteid'};
  my $forum        = $Pairs{'forum'};
  my ($user,$pass) = split(/\|/,get_cookie("mb-user"));
  
  # Check that a poll exists and that it is not locked
  if(!-e "$cgi_path/forum$forum/$pollid.poll") {
    redirect_die("We're sorry, but there is no poll with id $pollid.  If you are receiving this page in error, please contact the administration.","","3","black","No Such Poll $pollid");
  }
  lock_open(POLL,"$cgi_path/forum$forum/$pollid.poll","r");
  my $pollstatus = <POLL>;     $pollstatus = strip($pollstatus);
  my $question   = <POLL>;     $question   = strip($question);
  my $optionlst  = <POLL>;     $optionlist = strip($optionlst);
  my $votelst    = <POLL>;     $votelst    = strip($votelst);
  my $voterlst   = <POLL>;     $voterlst   = strip($voterlst);
  close(POLL);
  if($pollstatus eq 'locked') {
    redirect_die("We're sorry, but this poll has been locked by the administration.","","3","black","This Poll Is Locked");
  }
  
  # The poll is open and valid -- check if the user has voted already
  # Check if they are a guest!
  if($user eq "Guest") {
    redirect_die("We're sorry, but guests cannot vote in polls.","","3","black","Guests May Not Vote");
  }
  # Check if this user has voted yet
  if($user) {
    my @voters = split(/\|/,$voterlst);
    foreach my $voter (@voters) {
      if($user eq $voter) {
        redirect_die("We're sorry, but you have already voted for this poll.","","3","black","You Have Already Voted");
      }
    }
  }
  
  # They are ready to vote.  Record that they have voted.
  if($voterlst) { $voterlst .= "|$user"; }
  else          { $voterlst  = $user;    }
  
  # Record their vote
  my @votes = split(/\|/,$votelst);
  $votes[$vote]++;
  $votelst = join('|',@votes);        # Recompile the variable properly.
  my @options = split(/\|/,$optionlst);
  my $votedfor = $options[$vote];
  
  # Save the data back out to the poll file
  lock_open(POLL,"$cgi_path/forum$forum/$pollid.poll","w");
  truncate(POLL,0);   seek(POLL,0,0);
  print POLL "$pollstatus\n$question\n$optionlst\n$votelst\n$voterlst";
  close(POLL);
  
  # Update the user on the progress
  redirect_die("<b>Thank you!</b>  Your vote for \"$votedfor\" has successfully been recorded.","","5","black","Your Vote Has Been Recorded");
}


sub send_copy {
  my($forum,$topic,$user,$title,$ip,$time,$message);
  my $time = get_time($time);
  my($ifa) = "";

  # Compose conditionals
  if($title) { $ifa = "entitled $title"; }
  
  # Compose the subject
  my $subject = qq~NEW post by $user on $config{'board_name'}!~;
  # Compose the message
  my $message = qq~
    <b>$user</b> has posted a new message $ifa on <b>$config{'board_name'}</b> on $time.<br><br>
    
    <b>The IP of the user who posted the message was:</b> $ip<br><br>
    
    <b>The content of the message is as follows:</b><br>
    $message<br><br>
    
    Here is a direct link to the message ($topic) in forum $forum:<br>
      <a href="$paths{'board_url'}topic.cgi?forum=$forum&topic=$topic">$paths{'board_url'}topic.cgi?forum=$forum&topic=$topic</a><br><br> 
  ~;
  
  # Include the mail header if necessary
  require "mail.lib";

  # Send the email off
  send_mail($config{'emailpoststo'},$subject,$message);
}

sub lockunlockform {
  my $forum = $Pairs{'forum'};
  my $id    = $Pairs{'pollid'};
  my $type  = $Pairs{'type'};
  my $inf = get_cookie("mb-user");
  my($user,$pass) = split(/\|/,$inf);
  
  # Print the form
  print <<end;
    <table width="$config{'table_width'}" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}" align="center"><tr><td>
      <form action="$paths{'board_url'}poll.cgi" method="post">
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="2"><b>&#187; $type A Poll</b></font></td></tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Username</b></font></td>
	  <td><input type="text" name="user" value="$user"></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Password</b></font></td>
	  <td><input type="password" name="pass" value="$pass"></td>
	</tr>
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" value="$type Poll" name="submit"></td></tr>	
      </table>
      <input type="hidden" name="action" value="modifypoll">
      <input type="hidden" name="type" value="$type">
      <input type="hidden" name="forum" value="$forum">
      <input type="hidden" name="pollid" value="$id">
    </td></tr></table>
end
}

# Locks or unlocks a poll.
sub lockunlockdeletepoll {
  # Get the forum and poll ID
  my $forum = $Pairs{'forum'};
  my $id    = $Pairs{'pollid'};
  my $user  = $Pairs{'user'};
  my $pass  = $Pairs{'pass'};
  my $type  = $Pairs{'type'};
  
  # Check the account and permissions
  if(check_account($user,$pass) == $FALSE) {
    redirect_die("Your username/password combination was invalid.","","4","black","Invalid Login");
  }
  # Determine if the poll is to be deleted, locked, or unlocked and check that permission
  if($type eq 'Lock' || $type eq 'Unlock') {
    if(perms($user,'LOCK') == $FALSE) { noaccess('lock'); }
  }
  else {  # Delete check
    if(perms($user,'DELEOTH') == $FALSE) { noaccess('lock'); }
  }
  
  # If it's a delete, call that function, otherwise do what we have to do here.
  if($type eq 'Delete') { deletepoll($forum,$id); }
  else {
    # Open up the poll and read entries in
    lock_open(POLL,"$cgi_path/forum$forum/$id.poll","rw");
    seek(POLL,0,0);
    my @lines = <POLL>;
    # Change the first line
    if($lines[0] eq "open\n") { $lines[0] = "locked\n"; }   # If it's open, lock it
    else                      { $lines[0] = "open\n";   }   # If it's locked, open it
    truncate(POLL,0);
    seek(POLL,0,0);
    foreach my $line (@lines) { print POLL $line; }
    close(POLL);  
    # Update the user on the progress
    if($lines[0] eq "open\n") {
      $message = "<font face=\"Verdana\" size=\"2\">Poll $id has successfully been unlocked.</font>";
    } else {
      $message = "<font face=\"Verdana\" size=\"2\">Poll $id has successfully been locked.</font>";
    }
  }
  
  # Update the user on the progress with a redirect box
  redirect_die($message,"","4","black","Poll \#$pollid Modifications");
}

sub deletepoll {
  # Get the poll information
  my ($forum,$pollid) = @_;
  
  # Remove the poll
  unlink "$cgi_path/forum$forum/$pollid.poll";
  
  # Update the user on the progress
  if($!) {
    $message = "<font face=\"Verdana\" size=\"2\">There was an error removing poll $pollid: $!<br></font>\n";
  } else {
    $message = "<font face=\"Verdana\" size=\"2\">Poll $pollid was successfully deleted.<br></font>\n";
  }
}
