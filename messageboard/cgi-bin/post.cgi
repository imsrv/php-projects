#!/usr/bin/perl

# This script will handle posting a new thread or a reply to an existing
# topic, correct placement of the newly-modified topic in the forum list,
# and providing the forum to post a message to the user.
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
# Revision: April 2001

require 'global.cgi';

# No cookies to deal with, start the page
# Output the content headers
content();

$forum = $Pairs{'forum'};
$topic = $Pairs{'topic'};
$type  = $Pairs{'type'};

if(!$type) { $type = "new"; }

@foruminfo = get_forum_information($forum);
if(!$forum || !-d "$cgi_path/forum$forum") {
  page_header("$config{'board_name'} > Error");
  board_header();
  user_line();
  notice_box("<b>Error: No Forum Specified</b>","You did not specify a
  valid forum to add your post to.  Please make sure you are only using
  post links generated by the message board to ensure that your data is
  being correctly received.");
  page_footer();
  exit;
}
page_header("$config{'board_name'} > $foruminfo[2] > Post a Message");
board_header();
user_line();
position_tracker($foruminfo[13],"<a href=\"$paths{'board_url'}forum.cgi?forum=$forum\">$foruminfo[2]</a>","Post a Message");

# Check if this is a private forum and, if so, if the user has access
check_private(@foruminfo);

# Send the active user data
activeusers("Posting in <a href=\"$paths{'board_url'}forum.cgi?forum=$forum\">$foruminfo[2]</a>");

# Determine the action and show the appropriate
$action = $Pairs{'action'};

if(!$action)              { post_form(); }
elsif($action eq 'post')  { post();      }
else                      { post_form(); }
page_footer();

sub post_form {
  # Get the cookie information
  my $inf = get_cookie("mb-user");
  my($user,$pass) = split(/\|/,$inf);

  # Print the form
  show_form($user,$pass);
}

sub post {
   # Get the variables
   $user         = $Pairs{'user'};
   $pass         = $Pairs{'pass'};
   $title        = $Pairs{'title'};
   $description  = $Pairs{'description'};
   $message      = $Pairs{'message'};
   $signature    = $Pairs{'signature'};
   $emoticons    = $Pairs{'emoticons'};
   $emailnotify  = $Pairs{'emailreplies'};
   $preview      = $Pairs{'preview'};

   # Check required variables
   if($type eq 'new') {
     if(!$user || !$pass || !$title || !$message) {
       show_form($user,$pass,$title,$description,$message,$signature,$emoticons,$emailnotify,'yes');
       page_footer();  exit;
       #redirect_die("You did not supply the required fields.  Please check to
       #ensure that the following fields are filled in:<br><bR>
       #<ul><li>Username</li><li>Password</li><li>Message</li><li>Topic Title</li></ul>",
       #"","3","black","<b>Error: Invalid Arguments</b>");
     }
   } else {
     if(!$user || !$pass || !$message || !-e "$cgi_path/forum$forum/$topic.thd") {
       show_form($user,$pass,$title,$description,$message,$signature,$emoticons,$emailnotify,'yes');
       page_footer();  exit;
       #redirect_die("You did not supply the required fields.  Please check to
       #ensure that the following fields are filled in:<br><bR>
       #<ul><li>Username</li><li>Password</li><li>Message</li><li>Topic ID</li></ul>",
       #"","3","black","<b>Error: Invalid Arguments</b>");
     }
   }

   if(!$emoticons) { $emoticons = "no"; }
   if(!$signature) { $signature = "yes";  }
   if(!$emailreplies) { $emailreplies = "no"; }

   # Check if there is a board-wide posting shutdown
   if($config{'post_status'} eq 'disabled')  { # Yep, posts are disabled
     redirect_die("The administration has disabled all posts in all forums temporarily.  Please check back soon.","","","black","<b>Board Is Not Accepting Posts</b>");
   }
   # Check the forum status
   if($foruminfo[7] eq 'closed') {
     redirect_die("No new posts are being accepted for this forum.","","","black","<b>Closed Forum</b>");
   }
   if($foruminfo[7] ne 'guest') {
     # Check the account data
     if(check_account($user,$pass) == $FALSE) {
       redirect_die("You supplied an invalid username/password ($user/$pass) combination.  Please try again.","","2","black","<b>Login Error</b>");
     }
     if($foruminfo[7] eq 'admin') {
       if($account_data{'memberstate'} ne 'admin') {
         redirect_die("You do not have permission to post in this forum.","","2","black","<b>No Permission</b>");
       }
     }
     if($foruminfo[7] eq 'mod') {
       if($account_data{'memberstate'} ne 'admin' && $account_data{'memberstate'} ne 'mod') {
         redirect_die("You do not have permission to post in this forum.","","2","black","<b>No Permission</b>");
       }
     }
     if($users{$user}{'memberstate'} eq 'banned') {
         redirect_die("You have been banned from posting in any forum.","","2","black","<b>Account Banned</b>");
     }
   } else { # Guest posting
     if(check_account($user,$pass) == $FALSE) {  # A guest post
       $user = "Guest";
     }
   }
       
   
   # Check if they have waited long enough to post again
   $now = time;
   my $canpostat = $users{$user}{'lastposttime'} + ($users{$user}{'posttimelimit'} * 60);
   if($canpostat > $now) { # Cannot post yet
     $howlong = $canpostat - $now;   # How long until they can post again in seconds
     if($howlong >= 60) { $mins = ($howlong / 60); $nexttime = "$mins minute(s)"; }  # Convert to minutes
     else { $nexttime = "$howlong seconds"; }
     # Their post time limit in words
     $limit = get_postlimit($users{$user}{'posttimelimit'});
     
     redirect_die("We're sorry, but you have a post restriction set on your account and can only post once every $limit.  You may not post again for another $nexttime.","","5","black","<b>Post Time Restriction</b>");
   }
   if($config{'floodcontrol'} > 0 && perms($user,'NOFLOOD') == $FALSE) {
     $canpostat = $users{$user}{'lastposttime'} + $config{'floodcontrol'};
     if($canpostat > $now) { # Cannot post yet
       $howlong = $canpostat - $now;
       if($howlong >= 60) { $mins = ($howlong/60); $nexttime = "$mins minute(s)"; }
       else               { $nexttime = "$howlong seconds"; }
       redirect_die("We're sorry, but there is a global flood control in place.  You may only post every $config{'floodcontrol'} seconds.  You may post again in $nexttime.","","5","black","<b>Flood Control</b>");  
    }
  }

   # If it's a preview, do the preview and send it back to the form
   if($preview eq 'yes') {
     preview();
     show_form($user,$pass,$title,$description,$message,$signature,$emoticons,$emailnotify);
     page_footer();
     exit;
   }

   # If we reach this point, it is NOT a preview but a new post to be made.
   # Check if the topic is accepting new posts
   lock_open(thread,"$cgi_path/forum$forum/$topic.idx","r");
   $line = <thread>;
   close(thread);
   my @parts = split(/\|/,$line);

   # Autolocks?
   if($type ne 'new' &&
     $config{'autolock_time'} > 0 &&
     perms($user,'AUTOLCK') == $FALSE &&
     ($parts[9] + ($config{'autolock_time'} * 86400) < time)) {
       $cond = $TRUE;
   } else { $cond = 0; }
      
   if($parts[3] eq 'locked' || $parts[3] eq 'stickylocked' || $cond == $TRUE) {
     redirect_die("We're sorry, but this topic is not accepting any new
     replies at this time.  Locked topics are denoted by a lock image
     displaying next to the thread in the forum list.  You may:
     <ul>
       <li><a href=\"$paths{'board_url'}/forum.cgi?forum=$forum\">Return to the forum</a></li>
       <li><a href=\"$paths{'board_url'}/scarecrow.cgi\">Return to the board</a></li>
     </ul>","$paths{'board_url'}/forum.cgi?forum=$forum","4","black","This Thread Is Locked");
   }

   # Get some additional variables
   $time = time();     $ip = $ENV{'REMOTE_ADDR'};
   $mid = get_next_id($forum);

   # Attach any files if they are existant
   my $randomid = $Pairs{'randomid'};
   if(-e "$cgi_path/forum$forum/$randomid.attach") {
     lock_open(ATTACH,"$cgi_path/forum$forum/$randomid.attach","r");
     while($in = <ATTACH>) {
       $message .= $in;    # Attach each [file][/file] line that is necessary
     }
     # Remove the attachment file now
     unlink "$cgi_path/forum$forum/$randomid.attach";
   }

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
        echelon($forum,$message);
   $title        = substr($title,0,30);
   $title        = clean_input($title);
   $description  = clean_input($description);
   
   # Check again after cleanings if any required variables are blank
   if($type eq 'new') {
     if(!$title || !$message) {
       show_form($user,$pass,$title,$description,$message,$signature,$emoticons,$emailnotify,'yes');
       page_footer();  exit;
     }
   } else {
     if(!$message) {
       show_form($user,$pass,$title,$description,$message,$signature,$emoticons,$emailnotify,'yes');
       page_footer();  exit;
     }
   }
   
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

  # Previous/next options
  if($prev) { $prevline = "<li><a href=\"$paths{'board_url'}topic.cgi?forum=$forum&topic=$prev\">Go to the previous thread</a></li>"; } else { $prevline = ""; }
  if($next) { $nextline = "<li><a href=\"$paths{'board_url'}topic.cgi?forum=$forum&topic=$next\">Go to the next thread</a></li>"; } else { $nextline = ""; }

  # Determine the type of post and deal with it appropriately
   if($type eq 'new') {  # New thread
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

     redirect_die("Thank you!  Your post has successfully been made.  You may:<br><br>
     <ul><li><a href=\"$paths{'board_url'}topic.cgi?forum=$forum&topic=$mid\">Return to the new thread</a></li>
     $prevline
     $nextline
     <li><a href=\"$paths{'board_url'}forum.cgi?forum=$forum\">Return to the forum</a></li>
     <li><a href=\"$paths{'board_url'}scarecrow.cgi\">Return to the main page</a></li></ul>",
     "$paths{'board_url'}topic.cgi?forum=$forum&topic=$mid","5","black","<b>Message Posted Successfully!</b>");
   } else {  # A reply to an existing thread
     # Check if they can post a reply
     if(perms($user,'POSTREP') == $FALSE) { noaccess('postreply'); }
     if(hasgroup($user,$foruminformation{$forum}{'canreply'}) != $TRUE) { noaccess('postreply'); }
     
     if(!-e "$cgi_path/forum$forum/$topic.thd") {
       redirect_die("No valid topic ID file was supplied.  Please check that
       that are only using verified links and try again.","","","black","<b>Invalid Arguments</b>");
     }

     # The thread exists, let's append it
     my $line = "$mid|$user||$ip|$emoticons|$signature|$emailreplies|$time|0|0|$message\n";
     lock_open(newreply,"$cgi_path/forum$forum/$topic.thd","a");
     seek(newreply,0,2);
     print newreply $line;
     close(newreply);
     
     # Update the forum list and the list entry to the new modtime
     # Do the index file first
     lock_open(indexfile,"$cgi_path/forum$forum/$topic.idx","rw");
     seek(indexfile,0,0);
     my $in = <indexfile>;
     $in = strip($in);
     @inf = split(/\|/,$in);
     $inf[4]++;   $totaltopicreplies = $inf[4];
     $inf[8] = $user;
     $inf[9] = $time;
     $title = $inf[1];  # Set the topic for lastpost data
     $in = join('|',@inf);  # Got the update line
     $in .= "\n";
     truncate(indexfile,0);   seek(indexfile,0,0);
     print indexfile $in;
     close(indexfile);
     # Now the forum.lst file
     my $final = "";
     lock_open(list,"$cgi_path/forum$forum/forum.lst","rw");
     seek(list,0,0);
     while (my $e = <list>) {
       $e = strip($e);
       @inf = split(/\|/,$e);
       if($inf[0] == $topic) {
         $inf[4]++;
         $inf[8] = $user;
         $inf[9] = $time;
       }
       $e = join('|',@inf);
       $final .= "$e\n";
     }
     truncate(list,0);
     seek(list,0,0);
     print list $final;
     close(list);

     # Increase the forum post count
     increase_forum_count($forum,"postupdate",1,$time,$user);
     give_post($user,1);

     # Check for email reply requests
     emailreply($forum,$foruminfo[2],$topic,$title);
     
     # Check forum restrictions
     require "timedforums.lib";
     cleanforum($forum);
     lastpost($user,$forum,$foruminfo[2],$topic,$title,time);

     # Figure out the last page for the user to return to
     if($totaltopicreplies < $config{'messages_per_page'}) { $page = 1; }
     else {
       $page = int($totaltopicreplies / $config{'messages_per_page'});
       if($totaltopicreplies % $config{'messages_per_page'} != 0) { $page++; }
     }

     # If set, send a copy of this message to the administrator
     if($config{'emailallposts'} eq 'on') {
       send_copy($forum,$topic,$user,"",$ip,$time,$message);
     }

     redirect_die("Thank you!  Your post has successfully been made.  You are being returned to the LAST PAGE of the topic.  Alternately, you may:<br><br>
     <ul><li><a href=\"$paths{'board_url'}topic.cgi?forum=$forum&topic=$topic\">Return to the thread</a></li>
     $prevline
     $nextline
     <li><a href=\"$paths{'board_url'}forum.cgi?forum=$forum\">Return to the forum</a></li>
     <li><a href=\"$paths{'board_url'}scarecrow.cgi\">Return to the main page</a></li></ul>",
     "$paths{'board_url'}topic.cgi?forum=$forum&topic=$topic&page=$page","5","black","<b>Message Posted Successfully!</b>");
   }

   # If we hit here, we have got a fatal error
   scarecrow_die("post.cgi: No valid resolution for post.");
}

sub emailreply {
  my($forum,$forumname,$topic,$topictitle) = @_;   # Get the arguments
  my($message,$subject,$email)             = "";   # Localize some variables
  
  # Get the subscriber list
  lock_open(SUBSCRIBERS,"$cgi_path/forum$forum/$topic.sub","r");
  @subscribers = <SUBSCRIBERS>;
  close(SUBSCRIBERS);
  
  # Loop through it and send the emails
  foreach my $subscriber (@subscribers) {
    $subscriber = strip($subscriber);
    get_member($subscriber);  # Get the member information
    my $email = $users{$subscriber}{'email'};  # Get their email out of the hash
    if(!$message) {   # Compose the message if it hasn't been already
      $message = qq~ By your request, you are being notified of a new reply to $topictitle, a post in the
      $forumname forum of the $config{'board_name'}.\n\nPlease click the link below to view the topic,
       or paste the URL into your web browser if the link is not clickable.\n\n<a href="$paths{'board_url'}topic.cgi?forum=$forum&topic=$topic">$paths{'board_url'}topic.cgi?forum=$forum&topic=$topic</a>.\n\nThank you.\n~;
       require "mail.lib";   # Load the email-sending library
    }
    if(!$subject) {   # Compose the subject if it hasn't been already
      $subject = "Reply Notification - $topictitle has changed";
    }  
    # Send the email off to the recipient
    send_mail($email,$subject,$message);
  }
}

# arguments: username, password, title, description, message, signature,
# emoticons, email
sub show_form {
  my $conditional, @d = "";
  # Compile the default options
  if($_[5] eq 'yes' || !$_[5]) { $d[0] = "checked"; } else { $d[0] = ""; }
  if($_[6] eq 'yes')  { $d[1] = "checked"; } else { $d[1] = ""; }
  if($_[7] eq 'yes') { $d[2] = "checked"; } else { $d[2] = ""; }

  #show_form($user,$pass,$title,$description,$message,$signature,$emoticons,$emailnotify,'yes');
  if($_[8] eq 'yes')  { # This is being called because of an error
    # Compile the error message
    $error = qq~
      <table width="$config{'table_width'}" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'table_color'}"><tr><td>
        <table width="100%" border="0" cellspacing="1" cellpadding="5">
	  <tr bgcolor="$color_config{'nav_top'}"><td><font face="Verdana" size="2" color="red"><b>Error: You did not complete all required fields.</b></font></td></tr>
	  <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="2">
	    You did not supply all the required fields.  Please take a moment to fill in the fields below
	    that are marked in red, and resubmit your message.
	  </font></td></tr>
	</table>
      </td></tr></table>~;
    
    # Compile the error colors
    if(!$_[0]) { $colors[1] = "red"; }
    if(!$_[1]) { $colors[2] = "red"; }
    if(!$_[2]) { $colors[3] = "red"; }
    if(!$_[3]) { $colors[4] = "red"; }
    if(!$_[4]) { $colors[5] = "red"; }
  } else {  $error = ""; }


  # Normalize the error colors that haven't been changed
  if(!$colors[1]) { $colors[1] = $color_config{'body_textcolor'}; }
  if(!$colors[2]) { $colors[2] = $color_config{'body_textcolor'}; }
  if(!$colors[3]) { $colors[3] = $color_config{'body_textcolor'}; }
  if(!$colors[4]) { $colors[4] = $color_config{'body_textcolor'}; }
  if(!$colors[5]) { $colors[5] = $color_config{'body_textcolor'}; }


  # Compile the conditional
  if($type eq 'new') {
    $conditional = qq~
      <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1" color="$colors[3]"><b>Topic Title</b></font><br><font face="Verdana" size="1">The topic of your post.  <i>Required.</i></font></font></td><td><input type="text" name="title" maxlength="30" value="$_[2]"></td></tr>
      <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Topic Description</b></font><br><font face="Verdana" size="1">A brief topic description.</font></td><td><input type="text" name="description" maxlength="50" value="$_[3]"></td></tr>
    ~;
  } else { $conditional = ""; }

  # Get the fourm status
  if($foruminfo[7] eq 'guest')      { $forumstatus = "All registered and non-registered users may post in this forum."; }
  elsif($foruminfo[7] eq 'admin')   { $forumstatus = "Only administrators may post in this forum.";                     }
  elsif($foruminfo[7] eq 'mod')     { $forumstatus = "Only moderators or administrators may post in this forum.";       }
  elsif($foruminfo[7] eq 'closed')  { $forumstatus = "No new posts are being accepted for this forum.";                 }
  elsif($foruminfo[7] eq 'private') { $forumstatus = "Only authorized users may post in this forum";                    }
  else                              { $forumstatus = "All registered users may post in this forum.";                    }

  # Get the forum allows
  if($foruminfo[5] eq 'on') {
    $forumallows = "<font face=\"Verdana\" size=\"1\" color=\"$color_config{'body_textcolor'}\">HTML is <b>enabled</b>.</font><br><br>\n";
  } else {
    $forumallows = "<font face=\"Verdana\" size=\"1\" color=\"$color_config{'body_textcolor'}\">HTML is <b>disabled</b>.</font><br><br>\n";
  }
  if($foruminfo[6] eq 'on') {
    $forumallows .= "<font face=\"Verdana\" size=\"1\" color=\"$color_config{'body_textcolor'}\"><a href=\"\" onClick=\"openScript('$paths{'board_url'}help.cgi?topic=codes','400','350'); return false;\" onMouseOver=\"mouseit('View ScareCrow Codes'); return true;\" onMouseOut=\"mouseit(''); return true;\">ScareCrow Code</a> is <b>enabled</b>.</font><br>\n";
  } else {
    $forumallows .= "<font face=\"Verdana\" size=\"1\" color=\"$color_config{'body_textcolor'}\"><a href=\"\" onClick=\"openScript('$paths{'board_url'}help.cgi?topic=codes','400','350'); return false;\" onMouseOver=\"mouseit('View ScareCrow Codes'); return true;\" onMouseOut=\"mouseit(''); return true;\">ScareCrow Code</a> is <b>disabled</b>.</font><br>\n";
  }
  $forumallows .= "<br><br><br><br><a href=\"\" onClick=\"openScript('$paths{'board_url'}help.cgi?topic=emoticons','400','350'); return false;\" onMouseOver=\"mouseit('Smilies/Emoticons Legend'); return true;\" onMouseOut=\"mouseit(''); return true;\">Smilies/Emoticon legend</a>";
  
  # Generate a random ID
  my $randomid = time() . '-' . int(rand 1000000);

  # Attachments?
  my $inf = get_cookie("mb-user");   my($user,$pass) = split(/\|/,$inf);
  if(perms($user,'ATTACH') == $TRUE) { $button = qq~&nbsp;&nbsp;<input type="button" value="Attach File" name="button" onClick="javascript: openScript('$paths{'board_url'}attach.cgi?forum=$forum&randomid=$randomid','600','400'); return false;">~; }

  # Get a quote if necessary
  my $id = $Pairs{'quote'};
  my $quote = "";
  if($id) {
    $quote = get_quote($forum,$topic,$id);
    if($quote) { $quote .= "\n\n"; }
  }
  
  
print <<end;
    <form action="$paths{'board_url'}post.cgi" method="post" name="postform">
    <table width="$config{'table_width'}" cellspacing="0" cellpadding="0" border="0" bgcolor="$color_config{'border_color'}" align="center"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'table_headers'}"><td colspan="2"><font face="Verdana" size="1"><b>$forumstatus</font></b></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td width="30%"><font face="Verdana" size="1" color="$colors[1]"><b>Username</b></td><td><input type="text" name="user" value="$_[0]"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1" color="$colors[2]"><b>Password</b></td><td><input type="password" name="pass" value="$_[1]"></td></tr>
        $conditional
        <tr bgcolor="$color_config{'body_bgcolor'}"><td valign="top"><font face="Verdana" size="1" color="$colors[5]"><b>Message</b></font><br><font face="Verdana" size="1">The post you wish to make.<br><br>$forumallows</font></td><td><textarea name="message" cols="40" rows="9">$quote$_[4]</textarea></td></tr>
        <tr bgcolor="$color_config{'nav_top'}"><td valign="top"><font face="Verdana" size="1"><b>Post Options</b></td><td>
          <font face="Verdana" size="1">
            <input type="checkbox" name="signature" value="yes" $d[0]> Add your signature to this post?<br>
            <input type="checkbox" name="emoticons" value="yes" $d[1]> <b>Disable</b> emoticons in this post?<br>
            <b>Preview before posting?</b> <input type="radio" name="preview" value="yes"> Yes&nbsp;<input type="radio" name="preview" value="no" checked> No
          </font>
        </tr>
        <tr><td colspan="2" bgcolor="$color_config{'nav_top'}" align="center"><input type="submit" name="Submit" value="Submit" onClick="return clckcntr();">&nbsp;&nbsp;<input type="reset">$button</td></tr>
      </table>
    </td></tr></table>
    <input type="hidden" name="action" value="post">
    <input type="hidden" name="forum" value="$forum">
    <input type="hidden" name="topic" value="$topic">
    <input type="hidden" name="type" value="$type">
    <input type="hidden" name="randomid" value="$randomid">
    </form>
end
  if($type ne 'new') { threadreview($_[2]); }
  
  if($_[8] eq 'yes') { # Offering this as a way of fixing things.  Stop program execution.
    page_footer();
    exit;
  }
}

sub threadreview {
  # Load the thread from the file
  lock_open(FH,"$cgi_path/forum$forum/$topic.thd","r");
  my @posts = <FH>;
  close(FH);
  if(!$_[0]) {  # Get the thread title
    my @parts = split(/\|/,$posts[0]);
    $_[0] = $parts[2];
  }
  @posts = reverse(@posts);
  
  # Display the table header
  print <<end_header;
    <br><p><br><table width="$config{'table_width'}" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'table_headers'}"><td><font face="Verdana" size="2"><b>Thread Review For $_[0] (last 10 replies)</b></font></td></tr>
end_header
  
  # Display up to the last ten entries
  for($x = 0; $x <=9 && $posts[$x]; $x++) {
    my $data = $posts[$x];
    $data = strip($data);
    my($id,$poster,$title,$ip,$disableemoticons,$showsignature,$emailreplies,$postedat,$votes,$score,$message) = split(/\|/,$data);
    $posttime = get_time($postedat);
    $message =~ s/\n\n/[p]/ig;     $message =~ s/\n/[br]/ig;
    $message = codeify($message);  $message = translate_emoticons($message);
    $message = censor($forum,$message);
    print <<end_entry;
         <tr bgcolor="$color_config{'nav_top'}"><td><font face="Verdana" size="2"><b>Posted by $poster at $posttime</b></font></td></tr>
         <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="2">$message</font></td></tr>
end_entry
  }
  print <<end_footer;
      </table>
    </td></tr></table>
end_footer
}

sub preview {
  # Format the message properly
  $msg = $message;
  if($msg =~ /\#\s?Moderation Mode/i && ($users{$user}{'memberstate'} eq 'admin' ||
     $users{$user}{'memberstate'} eq 'moderator' || is_moderator($user,$forum))) {
  }
  else {
    $msg =~ s/</\&lt\;/ig;  $msg =~ s/>/\&gt\;/ig;
  }

  $msg =~ s/\n\n/[p]/ig;   $msg =~ s/\n/[br]/ig;
  $msg = codeify($msg);
  $msg = translate_emoticons($msg);
  print <<end;
      <tr bgcolor="$color_config{'text_alt1'}">
        <td valign="top" width="20%">
          <font face="Verdana" size="2" color="$color_config{'body_textcolor'}"><b>$poster</b></font><br>
        </td>
        <td valign="top">
          <p>&nbsp;<br><hr></p>
          <font face="Verdana" size="2" color="$color_config{'body_textcolor'}">
          $msg
          <p><hr>
          Post statistics.
        </td>
      </tr>
end
}

sub get_quote {
  my($forum,$topic,$id) = @_;

  if(!-d "$cgi_path/forum$forum" || !-e "$cgi_path/forum$forum/$topic.thd") { return ""; }

  lock_open(file,"$cgi_path/forum$forum/$topic.thd","r");
  while($in = <file>) {
     @parts = split(/\|/,$in);
     if($id == $parts[0]) {
       $time = get_time($parts[7],"%hr:%mi %ap on %mn %md, %ye %th");
       # Get rid of old quotes
       #$parts[10] =~ s/\[quote\](.+?)\[\/quote\]//ig;
       $parts[10] =~ s/\[p\]/\n\n/ig;   $parts[10] =~ s/\[br\]/\n/ig;
       my $quote = "[quote]";
       $quote .= "[b]Quote from $parts[1] at $time:[/b]\n";
       $quote .= "$parts[10]";
       $quote .= "[/quote]\n";
       return $quote;
     }
  }
  close(file);

  return "";
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
