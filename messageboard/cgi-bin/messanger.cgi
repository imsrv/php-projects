#!/usr/bin/perl

# This script will allow users to send each other private messages within the
# message board.  If a user has an unread private message waiting, an icon
# will appear on all message board pages to alert them.
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

# Output the content headers
content();

$action = $Pairs{'action'};

# Use the action first to determine the name of the position
if($action eq 'sendform' || $action eq 'sendprivate')  { $pos = "Sending Private Message"; }
elsif($action eq 'inbox')                       { $pos = "Viewing Inbox"; }
elsif($action eq 'read')                        { $pos = "Reading Private Messages"; }
elsif($action eq 'delete'||$action eq 'delout') { $pos = "Deleting Private Messages"; }
elsif($action eq 'outbox')                      { $pos = "Viewing Outbox"; }
elsif($action eq 'view')                        { $pos = "Reading Outbox Message"; }
else                                            { $pos = "Private Messages"; }

# Set up the page
page_header("$config{'board_name'} > $pos");
board_header();
user_line();
position_tracker("",$pos);

# Send the user to the appropriate function

if($action eq 'sendform')          { sendform();       }
elsif($action eq 'inbox')          { inbox();          }
elsif($action eq 'sendprivate')    { sprivate();       }
elsif($action eq 'read')           { read_private();   }
elsif($action eq 'delete')         { delete_private(); }
elsif($action eq 'outbox')         { outbox();         }
elsif($action eq 'view')           { view();           }
elsif($action eq 'delout')         { deleteout();      }
else                               { summary();        }

page_footer();


sub check_login {
  my $inf = get_cookie("mb-user");
  if(!$inf) {
    redirect_die("You are not currently logged in.  Please log into your account and try again.","2","$paths{'board_url'}login.cgi","black","Not Logged In");
  }
  ($user,$pass) = split(/\|/,$inf);

  # Check the account
  if(check_account($user,$pass) == $FALSE) {
    redirect_die("Invalid username/password combination.","","2","black","Invalid Login");
  }
}

sub iconlist {
  if($action eq 'inbox')       { $span="4"; $conditional = qq~ | <a href="javascript:document.form1.submit();" onMouseOver="mouseit('Delete Selected Messages'); return true;" onMouseOut="mouseit(''); return true;">Delete Selected Messages</a>~; }
  elsif($action eq 'sendform') { $span="2"; }
  elsif($action eq 'outbox')   { $span="4"; $conditional = qq~ | <a href="javascript:document.form1.submit();" onMouseOver="mouseit('Delete Selected Messages'); return true;" onMouseOut="mouseit(''); return true;">Delete Selected Messages</a>~; }
  else                         { $span="1"; $conditional = ""; }

  print <<end;
    <tr bgcolor="$color_config{'body_bgcolor'}"><td colspan="$span" align="center">
      <font face="Verdana" size="1">
        <a href="$paths{'board_url'}messanger.cgi?action=inbox">Inbox</a> |
        <a href="$paths{'board_url'}messanger.cgi?action=outbox">Outbox</a> |
        <a href="$paths{'board_url'}messanger.cgi?action=sendform">Send a Private Message</a>
        $conditional
      </font>
    </td></tr>
end
}

sub summary {
  check_login();  # Verify they are properly logged in

  # Gather the summary information
  lock_open(private,"$cgi_path/private/$user.in","r");
  my @entries = <private>;
  close(private);

  foreach my $entry (@entries) {
    my($a,$a,$a,$a,$flags,$a) = split(/\|/,$entry);
    $total++;   # Increment total inbox messages
    if($flags =~ /n/) { $unread++; }
  }
  if(!$total)  { $total = 0;  }
  if(!$unread) { $unread = 0; }

  print <<end;
    <table border="0" width="$config{'table_width'}" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <table border="0" width="100%" cellspacing="1" cellpadding="5">
        <tr><td align="center" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="3"><b><font color="$color_config{'profilename_color'}">$user\'s</font> Private Messages</b></font></td></tr>
end
  iconlist();
  print <<end
      <tr bgcolor="$color_config{'body_bgcolor'}"><td>
        <br>
        <p><font face="Verdana" size="2">You have <b>$total</b> messages in your inbox.</font></p>
        <p><font face="Verdana" size="2">There are <font color="red">$unread</font> unread messages.</font></p><br>
      </td></tr></table>
    </td></tr></table>
end
}

sub inbox {
  check_login();  # Verify they are properly logged in

  # Get the entries
  lock_open(inbox,"$cgi_path/private/$user.in","r");
  my @entries = <inbox>;
  close(inbox);

  # Sort the entries
  @entries = privatesort(@entries);

  # Display the entries
  print <<end;
    <br><table border="0" width="$config{'table_width'}" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <form action="$paths{'board_url'}messanger.cgi" method="post" name="form1">
      <table border="0" width="100%" cellspacing="1" cellpadding="5">
        <tr><td colspan="4" align="center" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="3"><b><font color="$color_config{'profilename_color'}">$user\'s</font> Inbox</b></font></td></tr>
end
  iconlist();
  print <<end;
        <tr bgcolor="$color_config{'nav_top'}">
          <td width="15%" align="center"><font face="Verdana" size="1"><b>Delete?</b></td>
          <td width="25%" align="center"><font face="Verdana" size="1"><b>From</b></font></td>
          <td width="50%" align="center"><font face="Verdana" size="1"><b>Subject</b></font></td>
          <td width="10%" align="center"><font face="Verdana" size="1"><b>New?</b></font></td>
        </tr>
end
  foreach my $entry (@entries) {
    my($id,$title,$sender,$sentat,$flags,$message) = split(/\|/,$entry);
    if($flags =~ /n/) { $new = "yes"; }
    else              { $new = "no";  }
    print <<end
          <tr bgcolor="$color_config{'body_bgcolor'}">
            <td><font face="Verdana" size="1"><input type="checkbox" name="m-$id" value="yes"> Delete</td>
            <td><font face="Verdana" size="1"><a href="$paths{'board_url'}messanger.cgi?action=read&id=$id">$sender</a></font></td>
            <td><font face="Verdana" size="1"><a href="$paths{'board_url'}messanger.cgi?action=read&id=$id">$title</a></font></td>
            <td align="center"><font face="Verdana" size="1"><a href="$paths{'board_url'}messanger.cgi?action=read&id=$id"><b>$new</b></a></font></td>
          </tr>
end
  }
  print <<end
      <input type="hidden" name="action" value="delete">
      </form>
      </td></tr></table>
    </td></tr></table>
end
}

sub read_private {
  my $id = $Pairs{'id'};
  my $line = "";
  check_login();        # Verify they are properly logged in

  # Get the specified entry
  lock_open(file,"$cgi_path/private/$user.in","r");
  while(my $in = <file>) {
    my($in_id,$title,$sender,$sentat,$flags,$message) = split(/\|/,$in);
    if($id == $in_id) {
      $line = $in;
      $flags =~ s/n//ig;  # Remove the "new" status
      $in = "$in_id|$title|$sender|$sentat|$flags|$message";
    }
    $final .= $in;
  }
  close(file);
  if(!$line) {
    redirect_die("There was no such private message ID as was supplied.","","2","black","No Such ID");
  }
  my($in_id,$title,$sender,$sentat,$flags,$message) = split(/\|/,$line);

  # Re-write the file
  lock_open(file,"$cgi_path/private/$user.in","w");
  truncate(file,0);  seek(file,0,0);
  print file $final;
  close(file);

  # Get the date
  $date = get_time($sentat,"%th%mo/%md/%ye \@ %hr:%mi %ap");
  # Codeify message
  $message = codeify($message);
  $message = translate_emoticons($message);
  $oksender = $sender;   $oksender =~ s/ /\%20/ig;

  # Display the entry
  print <<end;
    <br><table border="0" width="$config{'table_width'}" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <form action="$paths{'board_url'}messanger.cgi" method="post" name="form1">
      <table border="0" width="100%" cellspacing="1" cellpadding="5">
        <tr><td colspan="2" align="center" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="3"><b><font color="$color_config{'profilename_color'}">$user\'s</font> Private Messages</b></font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td colspan="2" align="center">
          <font face="Verdana" size="1">
            <a href="$paths{'board_url'}messanger.cgi?action=inbox">Inbox</a> |
            <a href="$paths{'board_url'}messanger.cgi?action=outbox">Outbox</a> |
            <a href="$paths{'board_url'}messanger.cgi?action=sendform&who=$oksender&id=$id">Reply</a> |
            <a href="$paths{'board_url'}messanger.cgi?action=delete&m-$id=yes">Delete This Message</a>
          </font>
        </td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
          <td><font face="Verdana" size="1"><b>Sender</b></font></td>
          <td><font face="Verdana" size="1">$sender</font></td>
        </tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
          <td><font face="Verdana" size="1"><b>Date</b></font></td>
          <td><font face="Verdana" size="1">$date</font></td>
        </tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
          <td><font face="Verdana" size="1"><b>Subject</b></font></td>
          <td><font face="Verdana" size="1">$title</font></td>
        </tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
          <td colspan="2" valign="top"><font face="Verdana" size="1"><b>Message:</b><br><br>$message</font></td>
        </tr>
      </td></tr></table>
    </td></tr></table>
end
}

sub sendform {
  # Get some variables
  my $who = $Pairs{'who'} || "";
  my $id  = $Pairs{'id'};
  
  check_login();        # Verify that they are properly logged in
  
  # Make sure that the user has access to this feature
  if(perms($user,'PRIVMSG') == $FALSE) {
    noaccess('private');
  }
  
  if($who eq $config{'board_name'})  {  # If the sender is the board, you cannot reply
    redirect_die("You cannot respond to this message.  It was sent by the message board automatically and would never reach a real person.","$paths{'board_url'}messanger.cgi?action=inbox","5","black","Cannot Reply");
  }

  # Get a quote if we need one
  if($id) {
    lock_open(file,"$cgi_path/private/$user.in","r");
    while($in = <file>) {
      ($in_id,$title,$sender,$sentat,$flags,$msg) = split(/\|/,$in);
      if($in_id == $id) { $ftitle = $title; $quote = $msg; last; }
      $quote = "";
      $ftitle = "";
    }
    close(file);
  }
  if($quote) {
    $sentat = get_time($sentat);
    $quote =~ s/\[p\]/\n\n/ig;     $quote =~ s/\[br\]/\n/ig;
    $quote = "\[quote\]\[b\]Private Message From $sender at $sentat\[\/b\]\[br\]\[br\]$quote\[\/quote\]";   # Add the quote tags
  }
  if(substr($ftitle,0,3) ne 're:' && $ftitle) { $ftitle = "re: $ftitle"; }   # Add "re" if it doesn't already exist

  # Output the form
  print <<end;
   <br><table border="0" width="$config{'table_width'}" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <form action="$paths{'board_url'}messanger.cgi" method="post" name="form1">
      <table border="0" width="100%" cellspacing="1" cellpadding="5">
        <tr><td colspan="2" align="center" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="3"><b><font color="$color_config{'profilename_color'}">$user\'s</font> Private Messages > Send a Message</b></font></td></tr>
end
  iconlist();
  print <<end;
        <tr bgcolor="$color_config{'body_bgcolor'}">
          <td><font face="Verdana" size="1"><b>Message To</b></font></td>
          <td><input type="text" name="msgto" value="$who"></td>
        </tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
          <td><font face="Verdana" size="1"><b>Subject</b></font></td>
          <td><input type="text" name="subject" value="$ftitle"></td>
        </tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
          <td valign="top"><font face="Verdana" size="1"><b>Message</b></font></td>
          <td valign="top"><textarea name="message" cols="40" rows="10">$quote</textarea></td>
        </tr>
        <tr bgcolor="$color_config{'nav_top'}"><td align="center" colspan="2"><input type="submit" name="submit" value="Send Message"></td></tr>
      </td></tr></table>
    </td></tr></table>
    <input type="hidden" name="action" value="sendprivate">
    </form>
end
}

sub sprivate {
  check_login();        # Verify they are logged in properly

  # Get the variables
  my $message = $Pairs{'message'};
  my $subject = $Pairs{'subject'};
  my $msgto   = $Pairs{'msgto'};
  my $now     = time();

  # Verify we have all the variables we need
  if(!$message || !$subject || !$msgto || !$now) {
    redirect_die("You did not supply all required fields or supplied an invalid user to deliver the message to.  Please verify that your spelling and case matches a valid user and try again.","","2","black","Invalid Input");
  }

  # Neuter the message
  $message =~ s/\n\n/[p]/ig;    $message =~ s/\n/[br]/ig;
  $message =~ s/</\&lt\;/ig;    $message =~ s/>/\*gt\;/ig;
            $message = clean_input($message); 

  # We've got it, write the entry to the recipients inbox and sender's outbox
  my $line2 = "$now|$subject|$msgto|$now|n|$message\n";

  # Check if there are multiple recipients
  @recipients = ();  # Clear the array
  if($msgto =~ /\,/) {
    $msgto =~ s/\, /\,/ig;  # Change user, user => user,user
    if($sentto{$msgto} ne 'yes') {
      @recipients = split(/\,/,$msgto);   # Multiple recipients
    }
    $sentto{$msgto} = "yes";  # So it doesn't send multiple copies to one person
  } else {  # Just one!
    push @recipients,$msgto;
  }
  # Send the message to all intended recipients
  foreach my $msgto (@recipients) {
    if(!-e "$cgi_path/members/$msgto\.dat") {
      if($nmessage) { $nmessage .= ", <b>$msgto</b>"; }
      else          { $nmessage = "We could not deliver your message to the following recipients: <b>$msgto</b>"; }
    }
    
    if($pmessage)   { $pmessage .= ", <b>$msgto</b>"; }
    else            { $pmessage = "We have successfully delivered your message to: <b>$msgto</b>"; }

    my $line  = "$now|$subject|$user|$now|n|$message\n";
    lock_open(file,"$cgi_path/private/$msgto.in","a");
    seek(file,0,2);
    print file $line;
    close(file);
    
    # Check if they want email notification for a new PM or not
    check_notification($msgto,$user);
  }

  lock_open(file,"$cgi_path/private/$user.out","a");
  seek(file,0,2);
  print file $line2;
  close(file);

  redirect_die("Thank you!  $pmessage.  $nmessage","$paths{'board_url'}messanger.cgi?action=inbox","2","black","Message Delivered!");
}

sub delete_private {
  check_login();        # Verify they are properly logged in
  my $final = "";

  # Loop through all private messages and see if they are flagged to be
  # deleted
  lock_open(file,"$cgi_path/private/$user.in","r");
  while(my $in = <file>) {
    $in = strip($in);
    if(!$in) { next; }
    my($id,@rest) = split(/\|/,$in);
    my $checkvalue = $Pairs{"m-$id"} || "";
    if($checkvalue ne 'yes') { $final .= "$in\n"; }   # Not deleted
    else                     { $count++;      }       # Deleted
  }
  close(file);
  lock_open(file,"$cgi_path/private/$user.in","w");
  truncate(file,0);
  seek(file,0,0);
  print file $final;
  close(file);

  if($count == 0) {
    $message = "<b>We're sorry</b>, but no messages matched your parameters.  No messages were deleted.";
  }
  elsif($count == 1){
    $message = "<b>Thank you!</b>  The selected message has been removed from your inbox.";
  }
  else {
    $message = "<b>Thank you!</b>  The $count selected messages have been removed from your inbox.";
  }

  redirect_die($message,"$paths{'board_url'}messanger.cgi?action=inbox","3","black","Delete Results");
}

sub privatesort {
  my @data = @_;
  my @idx;

  # Compile the index array
  foreach $entry (@data) {
    my($id,$a,$a,$time) = split(/\|/,$entry);
    push @idx, $time;
  }

  # Sort it
  @data = @data[ sort { $idx[$b] <=> $idx[$a] } 0 .. $#idx ];

  # Return
  return @data;
}

sub outbox {
  check_login();  # Verify they are properly logged in

  # Get the entries
  lock_open(outbox,"$cgi_path/private/$user.out","r");
  my @entries = <outbox>;
  close(outbox);

  # Sort the entries
  @entries = privatesort(@entries);

  # Display the entries
  print <<end;
    <br><table border="0" width="$config{'table_width'}" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <form action="$paths{'board_url'}messanger.cgi" method="post" name="form1">
      <input type="hidden" name="action" value="delout">
      <table border="0" width="100%" cellspacing="1" cellpadding="5">
        <tr><td colspan="4" align="center" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="3"><b><font color="$color_config{'profilename_color'}">$user\'s</font> Outbox</b></font></td></tr>
end
  iconlist();
  print <<end;
        <tr bgcolor="$color_config{'nav_top'}">
          <td width="15%"  align="center"><font face="Verdana" size="1"><b>Delete?</b></font></td>
	  <td width="25%" align="center"><font face="Verdana" size="1"><b>Date</b></font></td>
          <td width="20%" align="center"><font face="Verdana" size="1"><b>Message To</b></font></td>
          <td width="40%" align="center"><font face="Verdana" size="1"><b>Subject</b></font></td>
        </tr>
end
  foreach my $entry (@entries) {
    my($id,$title,$sender,$sentat,$flags,$message) = split(/\|/,$entry);
    $date = get_time($sentat,"%th%mo/%md/%ye \@ %hr:%mi %ap");
    print <<end
          <tr bgcolor="$color_config{'body_bgcolor'}">
            <td><input type="checkbox" value="yes" name="m-$id"> Delete</td>
            <td><font face="Verdana" size="1">$date</font></td>
            <td><font face="Verdana" size="1">$sender</font></td>
            <td><font face="Verdana" size="1"><a href="$paths{'board_url'}messanger.cgi?action=view&id=$id">$title</a></font></td>
          </tr>
end
  }
  print <<end
      </td></tr></table>
    </td></tr></table>
end
}

sub view {
  my $id = $Pairs{'id'};
  my $line = "";
  check_login();        # Verify they are properly logged in

  # Get the specified entry
  lock_open(file,"$cgi_path/private/$user.out","r");
  while(my $in = <file>) {
    my($in_id,$title,$sender,$sentat,$flags,$message) = split(/\|/,$in);
    if($id == $in_id) { $line = $in;  last; }
  }
  close(file);
  if(!$line) {
    redirect_die("There was no such private message ID as was supplied.","","2","black","No Such ID");
  }
  my($in_id,$title,$sender,$sentat,$flags,$message) = split(/\|/,$line);

  # Get the date
  $date = get_time($sentat,"%th%mo/%md/%ye \@ %hr:%mi %ap");
  # Codeify message
  $message = codeify($message);
  $message = translate_emoticons($message);

  # Display the entry
  print <<end;
    <br><table border="0" width="$config{'table_width'}" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <form action="$paths{'board_url'}messanger.cgi" method="post" name="form1">
      <table border="0" width="100%" cellspacing="1" cellpadding="5">
        <tr><td colspan="2" align="center" bgcolor="$color_config{'nav_top'}"><font face="Verdana" size="3"><b><font color="$color_config{'profilename_color'}">$user\'s</font> Private Messages</b></font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td colspan="2" align="center">
          <font face="Verdana" size="1">
            <a href="$paths{'board_url'}messanger.cgi?action=inbox">Inbox</a> |
            <a href="$paths{'board_url'}messanger.cgi?action=outbox">Outbox</a> |
            <a href="$paths{'board_url'}messanger.cgi?action=delout&m-$id=yes">Delete This Message</a>
          </font>
        </td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
          <td><font face="Verdana" size="1"><b>Sent To</b></font></td>
          <td><font face="Verdana" size="1">$sender</font></td>
        </tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
          <td><font face="Verdana" size="1"><b>Date</b></font></td>
          <td><font face="Verdana" size="1">$date</font></td>
        </tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
          <td><font face="Verdana" size="1"><b>Subject</b></font></td>
          <td><font face="Verdana" size="1">$title</font></td>
        </tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
          <td colspan="2" valign="top"><font face="Verdana" size="1"><b>Message:</b><br><br>$message</font></td>
        </tr>
      </td></tr></table>
    </td></tr></table>
end
}

sub deleteout {
  check_login();        # Verify they are properly logged in
  my $final = "";

  # Loop through all private messages and see if they are flagged to be
  # deleted
  lock_open(file,"$cgi_path/private/$user.out","r");
  while(my $in = <file>) {
    $in = strip($in);
    if(!$in) { next; }
    my($id,@rest) = split(/\|/,$in);
    my $checkvalue = $Pairs{"m-$id"} || "";
    if($checkvalue ne 'yes') { $final .= "$in\n"; }   # Not deleted
    else                     { $count++;      }       # Deleted
  }
  close(file);
  lock_open(file,"$cgi_path/private/$user.out","w");
  truncate(file,0);
  seek(file,0,0);
  print file $final;
  close(file);

  if($count == 0) {
    $message = "<b>We're sorry</b>, but no messages matched your parameters.  No messages were deleted.";
  }
  elsif($count == 1){
    $message = "<b>Thank you!</b>  The selected message has been removed from your outbox.";
  }
  else {
    $message = "<b>Thank you!</b>  The $count selected messages have been removed from your outbox.";
  }

  redirect_die($message,"$paths{'board_url'}messanger.cgi?action=outbox","4","black","Delete Results");
}

sub check_notification {
  my ($recipient,$sender) = @_;
  
  get_member($recipient);   # Load the user data
  # Check their option
  if($users{$recipient}{'pmnotification'} eq 'yes') {   # They DO want notification
    require "mail.lib";   # Load the mail library
    # Compose the body and subject
    my $subject = qq~You have a NEW private message from $sender!~;
    my $message = qq~$sender has sent you a new private message at <a href="$paths{'board_url'}scarecrow.cgi">$config{'board_name'}</a>.<br><br>
    
    You may visit the above URL and click on the "private messages" link, or you may use the following URL
    to proceed directly to your messenger: <a href="$paths{'board_url'}messanger.cgi">$paths{'board_url'}messanger.cgi</a>.
    
    ~;
    
    # Send the email
    send_mail($users{$recipient}{'email'},$subject,$message);
  }  
  
  
}
