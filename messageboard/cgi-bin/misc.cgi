#!/usr/bin/perl

# This script will handle small, miscellanious functions such as generating
# a printable page, emailing a topic to somebody, sending a message to an ICQ
# user, etc.
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

# Send the content header
$action = $Pairs{'action'};
if($action ne 'allread') { content(); }

# Determine the action and send the position tag
if($action eq 'sendicq') { $pos = "Sending an ICQ Message"; }
elsif($action eq 'emailfriend' || $action eq 'sendemail') { $pos = "Email a Friend"; }
elsif($action eq 'newposts') { $pos = "Viewing New Posts"; }
elsif($action eq 'allread')  { $pos = "Marking All Posts as Read"; }
elsif($action eq 'lostpassword' || $action eq 'sendpass') { $pos = "Retrieving Lost Password"; }
elsif($action eq 'ipview') { $pos = "Viewing Post IP"; }
elsif($action eq 'report' || $action eq 'reporting') { $pos = "Reporting a Post"; }

# Start the page
if($action ne 'allread') {
  page_header("$config{'board_name'} > $pos");
}
if($action ne 'printable' && $action ne 'newposts' && $action ne 'allread') {
  board_header();
  user_line();
  position_tracker("",$pos);
}

# Get the action
if($action eq 'sendicq') { icq_form(); }
elsif($action eq 'printable') { printable(); }
elsif($action eq 'emailfriend') { emailfriend(); }
elsif($action eq 'sendemail')  { sendemail(); }
elsif($action eq 'newposts') { newposts(); }
elsif($action eq 'allread')  { allforumsread(); }
elsif($action eq 'lostpassword') { passwordform(); }
elsif($action eq 'sendpass') { sendpass(); }
elsif($action eq 'ipview') { ipview(); }
elsif($action eq 'report') { reportform(); }
elsif($action eq 'reporting') { reportpost(); }
page_footer();


# Gives the forum to report a specific post to the moderators
sub reportform {
  # Get some variables
  my $forum = $Pairs{'forum'};
  my $topic = $Pairs{'topic'};
  my $id    = $Pairs{'id'};
  # Check the cookie
  my $inf = get_cookie("mb-user");
  my($user,$pass) = split(/\|/,$inf);
  
  # Print out the form
  print <<form;
    <table width="$config{'table_width'}" border="0" bgcolor="$color_config{'border_color'}" cellspacing="0" cellpadding="0" align="center"><tr><td>
      <form action="$paths{'board_url'}misc.cgi" method="post">
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
         <!-- Header cell -->
	 <tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="2"><b>&#187; Report a Post to the Moderator</b></font></td></tr>
         <tr bgcolor="$color_config{'body_bgcolor'}">
	   <td valign="top" width="25%"><font face="Verdana" size="2"><b>Username</b></font></td>
	   <td valign="top" width="75%"><input type="text" name="user" value="$user"></td>
	 </tr>
         <tr bgcolor="$color_config{'body_bgcolor'}">
	   <td valign="top" width="25%"><font face="Verdana" size="2"><b>Password</b></font></td>
	   <td valign="top" width="75%"><input type="password" name="pass" value="$pass"</td>
	 </tr>
         <tr bgcolor="$color_config{'body_bgcolor'}">
	   <td valign="top" width="25%"><font face="Verdana" size="2"><b>Reason</b></font><br><font face="Verdana" size="1">Briefly give the reason you believe that this post needs to be reveiwed by the moderators.</font></td>
	   <td valign="top" width="75%"><textarea name="reason" cols="40" rows="10"></textarea></td>
	 </tr>
	 <tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><input type="submit" name="submit" value="Submit Report"></td></tr>
      </table>
      <input type="hidden" name="forum" value="$forum">
      <input type="hidden" name="topic" value="$topic">
      <input type="hidden" name="id"    value="$id">
      <input type="hidden" name="action" value="reporting">
      </form>
    </td></tr></table>
form
}

# Physically sends the report about a post to all moderators for a specific forum
sub reportpost {
  # Get the variables
  my $user   = $Pairs{'user'};
  my $pass   = $Pairs{'pass'};
  my $forum  = $Pairs{'forum'};
  my $topic  = $Pairs{'topic'};
  my $id     = $Pairs{'id'};
  my $reason = $Pairs{'reason'};
  
  # Check that the user exists and has logged in properly -- only users may report posts for accountability
  if(check_account($user,$pass) == $FALSE) {
    redirect_die("Your username/password combination was invalid or your account does not exist.  Please try again.","","5","black","Report Error");
  }
  # Check that the specified post exists and grab the information on it if it does
  if(!-e "$cgi_path/forum$forum/$topic.thd") {
    redirect_die("There was no such topic $topic in forum $forum.","","5","black","Report Error");
  }
  # Forum/Topic exist -- find the post and grab the data, or return the error
  lock_open(THREAD,"$cgi_path/forum$forum/$topic.thd","r");
  while($in = <THREAD>) {
    ($iid,$poster,$title,$ip,$disableemoticons,$showsignature,$emailreplies,$postedat,$votes,$score,$message) = split(/\|/,$in);
    if($iid == $id) { # Bingo!  We've got a match.
      $ok = 1;
      last;
    }
  }
  close(THREAD);
  if($ok != 1) {
    redirect_die("There was no such message $id in topic $topic under forum $forum.","","5","black","Report Error");
  }
  
  $posttime = get_time($postedat);
  
  # Alright, everything is good, compose the report
  my $subject = qq~$user thinks you should look at a post in thread $topic.~;
  my $message = qq~
    $user has reported a post to you for review for the following reason: $reason.
    
    Direct link to the post: $paths{'board_url'}topic.cgi?forum=$forum&topic=$topic#$id
    
    Here is a copy of the text of the message in question, posted by $poster ($ip) at $posttime:
    
    $message.
    
    Thank you.
  ~;
  

  # Get some basic forum data that will be necessary no matter what
  get_forum_information($forum);
  
  # Check which way the board is configured to send these reports
  if($config{'reportmethod'} eq 'pm')  {  # Send it as a private message
    my @moderators = split(/\,/,$foruminformation{$forum}{'moderators'});
    # Compose the line to add as a message
    $message =~ s/\n\n/\[p\]/ig;
    $message =~ s/\n/\[br\]/ig;
    my $id = time();
    my $line = "$id|A Post Has Been Reported|$config{'board_name'}|$id|n|$message\n";
    foreach my $moderator (@moderators) {
      lock_open(PMS,"$cgi_path/private/$moderator\.in","a");
      print PMS $line;
      close(PMS);
    }
  }
  else {   # Send it as an email
    # Format the message
    $message = codeify($message);
    require "mail.lib";    # Mail functions
    my @moderators = split(/\,/,$foruminformation{$forum}{'moderators'});
    foreach my $moderator (@moderators) {
      get_member($moderator);
      
      send_mail($users{$moderator}{'email'},$subject,$message);
    }
  }
  
  # Let them know it was sent
  redirect_die("<b>Thank you!</b>  Your report has successfully been sent to all moderators listed for forum $forum.  They will review your report and make their decision as quickly as possible.","","5","black","Report Sent!");
    
    
}

# Sets up a form to send an ICQ message to a specified ICQ#
sub icq_form {
  my $icq = $Pairs{'icq'} || "";

  # Set up the form
  my $form = qq~
    <form name="pagerform" action="http://web.icq.com/whitepages/page_me/1,,,00.html" method="post">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><font face="Verdana" size="3"><b>Send an ICQ Message to $icq</b></font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="2"><b>From</b></font></td><td><input type="text" name="from" size="20" maxlength="40"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="2"><b>Your Email</b></font></td><td><input type="text" name="fromemail" size="20" maxlength="40"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="2"><b>Message</b></font></td><td><textarea name="body" cols="40" rows="10"></textarea></td></tr>
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="Send" value="Send Message"></td></tr>
      </table>
    </td></tr></table>
    <input type="hidden" name="subject" value="Message from $config{'board_name'}">
    <input type="hidden" name="to" value="$icq">
    </form>~;

  #notice_box("Send an ICQ Message",$form);
  print $form;
}

# Displays a printer-friendly page for a topic
sub printable {
  my $forum = $Pairs{'forum'};
  my $topic = $Pairs{'topic'};
  if(!$forum || !$topic || !-e "$cgi_path/forum$forum/$topic.thd") {
    redirect_die("Sorry, but you did not supply a valid forum and topic.","","","black","Invalid Parameters");
  }

  # Load the forum information
  @foruminfo = get_forum_information($forum);

  # Load all the replies
  lock_open(thread,"$cgi_path/forum$forum/$topic.thd",'r');
  my @topicinfo = <thread>;
  close(thread);
  my @topicheaders = split(/\|/,$topicinfo[0]);

  # Start the output
  $output = qq~
    <p>- <b>$config{'board_name'}</b> ($paths{'board_url'}scarecrow.cgi)<br>
    -- <b>$foruminfo[2]</b> ($paths{'board_url'}forum.cgi?forum=$forum)<br>
    --- <b>$topicheaders[2]</b> ($paths{'board_url'}topic.cgi?forum=$forum&topic=$topic)<br></p><hr>~;

  foreach my $reply (@topicinfo) {
    my($id,$poster,$title,$ip,$disableemoticons,$showsignature,$emailreplies,$postedat,$votes,$score,$message) = split(/\|/,$reply);
    get_member($poster);
    $posted = get_time($postedat);

    # Optional message transformations
    if($foruminfo[5]  ne 'on')  {
      if($message =~ /\#\s?Moderation Mode/i) {  # Possible avoidance..
        if($users{$poster}{'memberstate'} eq 'admin' ||
           $users{$poster}{'memberstate'} eq 'moderator' ||
           is_moderator($poster,$forum)) {  }
        else {
          $message =~ s/</\&lt\;/ig;  $message =~ s/>/\&gt\;/ig;
        }
      }
      else {
        $message =~ s/</\&lt\;/ig;  $message =~ s/>/\&gt\;/ig;
      }
    }
    if($showsignature eq 'yes') {
      if($users{$poster}{'signature'}) {
        $message .= "<br><br><hr align=\"left\" width=\"10\%\"><br>$users{$poster}{'signature'}";
      }
    }
    if($foruminfo[6]  eq 'on' ) { $message = codeify($message); }

    # Required message transformations
    $message =~ s/\n\n/<p>/ig;     $message =~ s/\n/<br>/ig;

    # Output the entry
    $output .= qq~
      <p>-- Posted by $poster at $posted<br></p>
      $message<br>
      <hr>~;
  }
  print $output;
}

sub emailfriend {
  my $forum = $Pairs{'forum'};
  my $topic = $Pairs{'topic'};
  my $inf = get_cookie("mb-user");
  my($user,$pass) = split(/\|/,$inf);
  print <<end;
    <form action="$paths{'board_url'}misc.cgi" method="post">
    <table width="$config{'table_width'}" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}" border="0" align="center"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><font face="Verdana" size="2"><b>Email Topic to a Friend</b></font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td valign="top"><font face="Verdana" size="2"><b>Username</b></font></td><td valign="top"><input type="text" name="user" value="$user"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td valign="top"><font face="Verdana" size="2"><b>Password</b></font></td><td valign="top"><input type="password" name="pass" value="$pass"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td valign="top"><font face="Verdana" size="2"><b>Your Name</b></font></td><td valign="top"><input type="text" name="name"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td valign="top"><font face="Verdana" size="2"><b>Your Friends Email Address</b></font></td><td valign="top"><input type="text" name="email"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td valign="top"><font face="Verdana" size="2"><b>A Brief Message</b></font></td><td valign="top"><textarea name="message" cols="40" rows="15"></textarea></td></tr>
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Send Email"></td></tr>
      </table>
    </td></tr></table>
    <input type="hidden" name="forum" value="$forum">
    <input type="hidden" name="topic" value="$topic">
    <input type="hidden" name="action" value="sendemail">
    </form>
end
}

sub sendemail {
  my $user = $Pairs{'user'};
  my $pass = $Pairs{'pass'};
  my $forum = $Pairs{'forum'};
  my $topic = $Pairs{'topic'};
  my $email = $Pairs{'email'};
  my $name = $Pairs{'name'};
  my $message = $Pairs{'message'};

  # Check required variales
  if(!$forum || !$topic || !-e "$cgi_path/forum$forum/$topic.idx" || !$email || $email !~ /@/) {
    redirect_die("You did not supply all required fields.","","","black","Invalid Parameters");
  }
  if(check_account($user,$pass) == $FALSE) {
    redirect_die("Your login was invalid.  You must supply a valid login to send the page to prevent unauthorized spamming.","","","black","Invalid Login");
  }

  # Check that they have access
  my @foruminfo = get_forum_information($forum);
  check_private(@foruminfo);

  # Set some defaults
  if(!$name) { $name = "Your friend"; }

  # Get the topic information
  @topicinfo = get_topic_information($forum,$topic);
  @topicinfo = split(/\|/,$topicinfo[0]);

  # Prepare the email body
  $body = $message if $message;
  $body .= "\n\n----------------------\n\n";
  $body .= qq~
    $name ($users{$user}{'email'}) thought you would like to see this topic, entitled "$topicinfo[2]".\n\n

    <a href="$paths{'board_url'}topic.cgi?forum=$forum&topic=$topic">$paths{'board_url'}topic.cgi?forum=$forum&topic=$topic</a>\n
    $paths{'board_url'}topic.cgi?forum=$forum&topic=$topic\n\n

    Thank you,\n
    $config{'board_name'} Administration~;

  require "mail.lib";
  send_mail($email,"$name Thought You Would Like This",$body);

  redirect_die("Your friend has been successfully alerted.","$paths{'board_url'}topic.cgi?forum=$forum&topic=$topic","3","black","Thank You!");
}

sub newposts {
  for($forum = 1; ; $forum++) {
    if(!-d "$cgi_path/forum$forum") { last; }

    my $forumtime = get_cookie("mb-forums");
    if(!$forumtime) { $forumtime = get_lastvisited($forum); } else {
      my @forumtimes = split(/\|/,$forumtime);
      $forumtime = $forumtimes[$forum];
    }
    # Read the forum list and determine the new entries
    lock_open(forum,"$cgi_path/forum$forum/forum.lst","r");
    @threads = <forum>;
    close(forum);
    @threads = datesort(@threads);
    foreach $in (@threads) {
      my @parts = split(/\|/,$in);
      $line = "$forum|";
      $line .= $in;
      if($parts[9] > $forumtime) { push @results,$line; }
      else { last; }
    }
  }

  # Check if there are any results and if not, abort
  if(@results == 0) {
    print "<center>There were no new posts since your last visit.<br><br>";
    print "<a href=\"#\" onClick=\"self.close();\">Close this window</a></center>\n";
    page_footer();
    exit;
  }

  # Display the table with the results
  print <<end;
    <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'table_headers'}">
          <td><font face="Verdana" size="2"><b>Forum</b></font></td>
          <td><font face="Verdana" size="2"><b>Topic Title</b></font></td>
          <td><font face="Verdana" size="2"><b>Last Post</b></font></td>
        </tr>
end
  foreach $result (@results) {
    my @parts = split(/\|/,$result);
    $forum = $parts[0];
    $id = $parts[1];
    $title = $parts[2];
    $lastmod = $parts[10];
    $lastmod = get_time($lastmod);
    print <<end;
        <tr bgcolor="$color_config{'body_bgcolor'}">
          <td align="center" width="10%">$forum</td>
          <td width="50%"><a href="$paths{'board_url'}topic.cgi?forum=$forum&topic=$id" OnClick="parent.location = '$paths{'board_url'}topic.cgi?forum=$forum&topic=$id'; return false;" target="_parent">$title</a></td>
          <td width="40%">$lastmod</td>
        </tr>
end
  }
  print <<end;
        <tr bgcolor="$color_config{'table_headers'}>"><td bgcolor="$color_config{'table_headers'}" colspan="3" align="center"><font face="Verdana" size="1"><a href="#" onClick="self.close(); return false;" onMouseOver="mouseit('Close This Window'); return true;" onMouseOut="mouseit(''); return true;">Close this window</a></font></td></tr>
      </table>
    </td></tr></table>
end

}

sub allforumsread {
  $count = 0;
  for($forum = 1; ; $forum++) {
    if(!-d "$cgi_path/forum$forum") { last; }
    $count++;
  }
  if($count != 0) {
    for($forum = 1; $forum <= $count; $forum++) {
      if($forum == $count) { $opt = 1; }
      else                 { $opt = 2; }
      update_lastread($forum,$opt);
    }
  }

  redirect_die("All posts have successfully been marked as read.","","","black","Action Completed");
}

sub passwordform {
  $message = qq~
    <p><font face="Verdana" size="2">
      Fill in your username below to retrieve your password.  Please note
      that due to the encryption in place, your password will be altered
      before it is sent to you.  The password will be sent to the email
      address currently specified in your profile.
    </font></p>
    <form action="$paths{'board_url'}misc.cgi" method="post">
    <font face="Verdana" size="2"><b>Your Username</b></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" name="user"><br>
    <center><input type="submit" name="submit" value="Get Password"></center>
    <input type="hidden" name="action" value="sendpass">
    </form>~;

  notice_box("Retrieve Password",$message);
}

sub sendpass {
  my $user = $Pairs{'user'};

  if(get_member($user) == $FALSE) {
    redirect_die("No such username exists in our database.","","","No Such User");
  }

  # Change the password and save the new one
  $newpass = generate_random_string(7);
  $users{$user}{'password'} = crypt($newpass,$users{$user}{'salt'});
  saveuser($user);

  # Send the email
  require "mail.lib";
  send_mail($users{$user}{'email'},"Your Lost Password","You (or presumably you) recently requested your password for $config{'board_name'}.  Your password has been changed to the following:\n\nPassword: $newpass\n\nIf you did not request the password change, don't worry!  You can be assured that the new password was ONLY sent to this email address.  Thank you for your support.");

  # Results
  redirect_die("Thank you!  Your password should be arriving in the email
  account currently specified in your profile shortly.","","3","black","Action Successful!");
}

sub ipview {
  # Get variables
  my $forum = $Pairs{'forum'};
  my $topic = $Pairs{'topic'};
  my $id    = $Pairs{'id'};
  my $x = 0;

  # Check if they are logged in and have access
  my $inf = get_cookie("mb-user");
  my($user,$pass) = split(/\|/,$inf);
  if(!$inf) { redirect_die("Sorry, but you must be logged in to view the poster's ip.  Please log in and try again.","$paths{'board_url'}login.cgi","4","black","Not Logged In"); }
  if(check_account($user,$pass) == $FALSE || ($users{$user}{'memberstate'} ne 'admin' &&
     is_moderator($forum,$user) == $FALSE)) {
       redirect_die("Sorry, but your username/password combination was invalid or you do not have access to this feature.","","","","Invalid Login");
  }

  # Check the variables
  if(!-e "$cgi_path/forum$forum/$topic.thd") {
    redirect_die("Invalid arguments were supplied to the script.  Please follow only valid links or inform the administration","","","","Bad Data");
  }

  # They have access -- get the IP from the post
  lock_open(THREAD,"$cgi_path/forum$forum/$topic.thd","r");
  while($in = <THREAD>) {
    $x++;
    my($inid,$postuser,$a,$ips) = split(/\|/,$in);
    if($x == 1) { $msgtitle = $a; }
    if($id == $inid) {  # Got it!
      # Get the originating IP
      get_member($postuser);
      $oip = $users{$postuser}{'registerip'} || "n/a";

      # Get the message IPs
      my @parts = split(/\+/,$ips);
      $messageips = "<ul type=\"square\">\n";
      foreach $ip (@parts) {
        $messageips .= "<li>$ip</li>";
      }
      $messageips .= "</ul>\n";

      # Set the message and title
      $title = "$postuser\'s IP Information for thread \"$msgtitle\"";
      $message = qq~
        Here is the IP of the user who posted the message at the time they
        posted the message.  Subsequent post IP numbers are the IPs of the
        user at any subsequent edits.  The originating IP is the IP address
        that the user first registered their account with.<br><br>

        <p><b>Message IP(s):</b></p>
        <p>$messageips
        <b>Originating IP:</b> $oip</p>

        <br><ul>
          <li><a href="$path{'board_url'}topic.cgi?forum=$forum&topic=$topic">Return to the thread</a></li>
          <li><a href="$path{'board_url'}forum.cgi?forum=$forum">Return to the forum</a></li>
          <li><a href="$path{'board_url'}scarecrow.cgi">Return to the main page</a></li></ul>
        </ul>~;

        notice_box($title,$message);
        page_footer();  exit;
    }
  }
  close(THREAD);

  redirect_die("Invalid arguments were supplied to the script.  Please follow only valid links or inform the administration","","","","Bad Data");
}
