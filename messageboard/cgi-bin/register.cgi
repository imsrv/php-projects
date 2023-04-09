#!/usr/bin/perl

# This script will handle user registrations based on global configuration
# data.
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
# Revision: July 2001

require "global.cgi";
require "mail.lib";
require "ban.lib";

# Start the page
# Output the content headers
content();

page_header("$config{'board_name'} > User Registration");
board_header();
position_tracker("","User Registration");

# Send the active user data
activeusers("Account Registration");

$stepnum = $Pairs{'stepnum'};

if($stepnum == 0)    { showterms(); }
elsif($stepnum == 1) { showrules();  }
elsif($stepnum == 2) { showform(); }
elsif($stepnum == 3) { infowrite(); }
else                 { showterms(); }


sub showterms {
  my $message = "";
  $message = qq~<p>Considering the real-time nature of this bulletin board, it is
              impossible for us to review messages or confirm the validity of
              information posted. Please remember that we at do not actively
              monitor the contents of and are not responsible for any
              messages posted. We do not vouch for or warrant the accuracy,
              completeness or usefulness of any message, and are not
              responsible for the contents of any message. The messages
              express the views of the author of the message, not
              necessarily the views of this Bulletin Board or any entity
              associated with this Bulletin Board. Any user who feels that
              a posted message is objectionable is encouraged to contact us
              immediately by email. We have the ability to remove
              objectionable messages and we will make every effort to do so,
              within a reasonable time frame, if we determine that removal
              is necessary. This is a manual process, however, so please
              realize that we may not be able to remove or edit particular
              messages immediately.~;
  $message .= qq~<p>You agree, through your use of this service, that you will
              not use this Bulletin Board to post any material which is
              knowingly false and/or defamatory, inaccurate, abusive,
              vulgar, hateful, harassing, obscene, profane, sexually oriented,
              threatening, invasive of a person's privacy, or otherwise
              violative of any law or rule. You agree not to post any
              copyrighted material unless the copyright is owned by you or by
              this Bulletin Board.~;
  $message .= "<form action=\"$paths{'board_url'}register.cgi\" method=\"post\">\n";
  $message .= "<center><input type=\"Submit\" name=\"Submit\" value=\"I Agree\"></center>\n";
  $message .= "<input type=\"hidden\" name=\"stepnum\"   value=\"1\">\n";
  $message .= "</form>\n";

  notice_box("<b>Terms and Conditions of Service</b>",$message);
  page_footer();
  exit;
}

sub showform {
  my $message = "";

  my $passwordline = "";
  if($config{'autopasswords'} eq 'yes') {
    $passwordline = "<tr><td colspan=\"2\" align=\"center\"><font face=\"Verdana\" size=\"1\">Your password will be emailed to you at the address you provide.</font></td></tr>\n";
  } else {
    $passwordline = "<tr><td><font face=\"Verdana\" size=\"2\"><b>Password</b></font><br><font face=\"Verdana\" size=\"1\">Your password should be at least five characters long.</font></td><td><input type=\"password\" name=\"pass\"></td></tr>\n";
    $passwordline .= "<tr><td><font face=\"Verdana\" size=\"2\"><b>Verify Password</b></font><br><font face=\"Verdana\" size=\"1\">Your password should be at least five characters long.</font></td><td><input type=\"password\" name=\"pass2\"></td></tr>\n";
  }
  if($config{'avatars'} eq 'on') {
    # Get the option for avatars
    opendir(avatars,"$paths{'noncgi_path'}/avatars/");
    my @list = readdir(avatars);
    closedir(avatars);

    @gifs = grep(/\.gif/,@list);
    @jpgs = grep(/\.jpeg/,@list);
    push @avlist,@gifs;
    push @avlist,@jpgs;
    $avataroptions = "";
    foreach my $item (@avlist) {
      # clean the name
      $item =~ s/\.gif//ig;
      if($item eq 'noavatar') {
        $avataroptions .= "<option value=\"noavatar\" selected>$item</option>";
      } else {
        $avataroptions .= "<option value=\"$item\">$item</option>";
      }
    }

    $avatars = qq~<script language="javascript">
      function showimage()
      {
        document.images.useravatars.src="$paths{'noncgi_url'}/avatars/"+document.creator.avatar.options[document.creator.avatar.selectedIndex].value+".gif";
      }
    </script>
    <tr bgcolor="$color_config{'body_bgcolor'}"><td><b>Avatars</b><br><font face="Verdana" size="1">If you wish, you may select an avatar here.</font></td>
    <td>
    <select name="avatar" size=6 onChange="showimage()">
      $avataroptions
    </select>&nbsp;
    <img src="$paths{'noncgi_url'}/avatars/noavatar.gif" name="useravatars" width="64" height="64" border=0 hspace=15>
    </td></tr>~;
  } else {
    $avatars = "";
  }
  
  $offsetcode = offsetcode();

  $message .= qq~
    <form action="$paths{'board_url'}register.cgi" method="post" name="creator">
    <table width="100%">
      <tr><td><font face="Verdana" size="2"><b>Membername</b></font><br><font face="Verdana" size="1">Member names cannot be longer than
      20 characters and may only consist of letters, numbers, hypen and underscore.</font></td>
      <td><input type="text" name="user" maxlength="20"></td></tr>
      $passwordline
      <tr><td><font face="Verdana" size="2"><b>Email Address</b></font><br><font face="Verdana" size="1">Please supply a valid email
      address.  You may keep this private if you wish.</font></td>
      <td><input type="text" name="email"></td></tr>
      <td><font face="Verdana" size="2"><b>Show Email Address</b></font><br><font face="Verdana" size="1">Would you like your email address
      visible to others?</font></td>
      <td><input type="radio" name="showemail" value="yes"> Yes&nbsp;&nbsp;<input type="radio" name="showemail" value="no"> No</td></tr>
      <tr><td><font face="Verdana" size="2"><b>Homepage</b></font><br><font face="Verdana" size="1">If you have a webpage, enter the URL here.</font></td>
      <td><input type="text" name="homepage" value="http://"></td></tr>
      <tr><td><font face="Verdana" size="2"><b>AOL Instant Messanger Name</b></font><br><font face="Verdana" size="1">If you have an AIM name, enter it here.</font></td>
      <td><input type="text" name="aimname"></td></tr>
      <tr><td><font face="Verdana" size="2"><b>ICQ Number</b></font><br><font face="Verdana" size="1">If you have an ICQ number, enter it here.</font></td>
      <td><input type="text" name="icqnumber"></td></tr>
      <tr><td><font face="Verdana" size="2"><b>Location</b></font><br><font face="Verdana" size="1">Optionally, you may enter your location here.</font></td>
      <td><input type="text" name="location"></td></tr>
      <tr><td><font face="Verdana" size="2"><b>Time Offset</b></font><br><font face="Verdana" size="1">All times on the server are $config{'times'}.<br>
      Enter the number of hours that you are offset from this timezone and all the
      times on the board will be altered to fit your timezone.</font></td>
      <td>$offsetcode</td></tr>
      <tr><td><font face="Verdana" size="2"><b>Receive Private Message Notification?</b></font><br><font face="Verdana" size="1">Optionally, you may choose to be
      sent an email whenever you receive a new private message on the message board.</font></td>
      <td><input type="checkbox" value="yes" name="pmnotification"> Yes</td>
      <tr><td><font face="Verdana" size="2"><b>Interests</b></font><br><font face="Verdana" size="1">You may enter your interests here.</font></td>
      <td><textarea name="interests" cols="35" rows="10"></textarea></td></tr>
      <tr><td><font face="Verdana" size="2"><b>Signature</b></font><br><font face="Verdana" size="1">Please enter a signature to be included
      with each post.  All ScareCrow tags will work the same as they work within
      a forum, but no HTML will be accepted.</font></td>
      <td><textarea name="signature" cols="35" rows="10"></textarea></td></tr>
      <tr><td><font face="Verdana" size="2"><b>How did you hear about us?</b></font><br><font face="Verdana" size="1">Please let us know how you heard about our website.</font></td>
      <td><textarea name="hearabout" cols="35" rows="10"></textarea></td></tr>
      $avatars
    </table>
    </font>
    <input type="hidden" name="stepnum" value="3">
    <input type="Submit" name="Submit" value="Submit Registration">
    </form>~;

  notice_box("<b>Registration Information</b>",$message);
  page_footer();
  exit;
}

sub infowrite {
  # Variables
  my $message   = "";
  my $user      = $Pairs{'user'};
  my $pass      = $Pairs{'pass'};
  my $pass2     = $Pairs{'pass2'};
  my $email     = $Pairs{'email'};
  my $showemail = $Pairs{'showemail'};
  my $homepage  = $Pairs{'homepage'};
  my $aimname   = $Pairs{'aimname'};
  my $icqnumber = $Pairs{'icqnumber'};
  my $location  = $Pairs{'location'};
  my $offset    = $Pairs{'offset'};
  my $interests = $Pairs{'interests'};
  my $signature = $Pairs{'signature'};
  my $avatar    = $Pairs{'avatar'} || "noavatar";
  my $hearabout = $Pairs{'hearabout'};
  my $pmnotify  = $Pairs{'pmnotification'};

  ## Check required variables
  if(!$user || !$email || $email !~ /\@/ || length($email) < 5 || !$showemail) {
    $message = "<b>You did not supply all required fields.</b><br><br>\n";
    $message .= "Please use the \"back\" button on your browser and fill in\n";
    $message .= "the required fields.<br>\n";
    notice_box("<b>Account Creation</b>",$message);
    page_footer();
    exit;
  }
  
  # Clean up the username
  if(length($user) > 20) {
    redirect_die("We're sorry, but your username was too long.  Please restrict
    the length of your username to 20 characters.","","3","black","Invalid Username");
  }
  if($user =~ /[^A-Za-z_\-0-9\s]/) {
    redirect_die("We're sorry, but your username contained illegal characters.
    Please choose a username that contains only letters, numbers, dash (-) and
    underscore (_).","","3","black","Invalid Username");
  }
  
  # Check to see if there are any email bans in effect for this email
  check_email_ban($email);
  # Check to see if this username is restricted
  check_username_restriction($user);

  # Make sure the account is available
  $fuser = $user;  $fuser =~ s/ /_/ig;
  $tuser = $user;  $tuser =~ tr/A-Z/a-z/;
  opendir(DIR,"$cgi_path/members/");  my @members = readdir(DIR);  closedir(DIR);
  foreach $member (@members) {
    $member =~ s/\.dat//ig;
    $member2 = $member;  $member2 =~ s/ /_/ig;
    $member =~ tr/A-Z/a-z/;    $member2 =~ tr/A-Z/a-z/;
    if($tuser eq $member || $tuser eq $member2) {
      redirect_die("That username already exists.  Please choose another and try again.","","2","black","<b>Member Already Exists</b>");
    }
  }
  lock_open(RES,"$cgi_path/reservednames.txt","r");  my @reserved = <RES>;  close(RES);
  foreach $member (@reserved) {
    $member2 = $member;  $member2 =~ s/ /_/ig;
    $member =~ tr/A-Z/a-z/;    $member2 =~ tr/A-Z/a-z/;
    if($tuser eq $member || $tuser eq $member2) {
      redirect_die("That username is reserved by the administration.  Please choose another and try again.","","2","black","<b>Member Already Exists</b>");
    }
  }
  
  # neuter and alter some variables
  $signature =~ s/\n\n/<p>/ig;        $interests =~ s/\n\n/<p>/ig;
  $signature =~ s/\n/<br>/ig;         $interests =~ s/\n/<br>/ig;
  $hearabout =~ s/\n/<br>/ig;         $hearabout =~ s/\n\n/<p>/ig;
  if($homepage eq 'http://')   { $homepage = "";   }
  if($avatar eq 'noavatar')    { $avatar = "";     }
  if($icqnumber =~ /[A-Za-z]/) { $icqnumber = "";  }
  if(!$pmnotify)               { $pmnotify = "no"; }
  # [song] tags
  if($config{'songtags'} eq 'yes') {
    while($signature =~ /\[song\]/i) {
      my $song = get_randomsong();
      $signature =~ s/\[song\]/$song/i;
    }
  }
  
  # [random] tags
  if($config{'randomtags'} eq 'yes') {
    while($signature =~ /\[random\]/i) {
      my $quote = get_randomquote();
      $signature =~ s/\[random\]/$quote/i;
    }
  }

if($config{'autopasswords'} eq 'yes') {
    $pass = "";
    $pass = generate_random_string(7);
    my $mssg = "";
    $mssg = "You, or presumably you, recently registered for an account on\n";
    $mssg .= "$config{'board_name'} at $paths{'website_url'}.  This email\n";
    $mssg .= "is meant to supply you with your password for the board.  Please\n";
    $mssg .= "keep it in a safe place.<br><br>\n";
    $mssg .= "Your password is: $pass\n";
    send_mail($email,"Welcome To $config{'board_name'}!",$mssg);
  } else {
    if($pass ne $pass2) {
      redirect_die("Sorry, but your passwords did not match.  Be sure to type
      your password the same way in box password boxes.","","3","black","Invalid Password");
    }
  }

  # Encrypt the password
  my $salt       = generate_random_string(3);
  my $crypted    = crypt($pass,$salt);
  my $registered = time();
  
  # Determine whether or not the account is validated by the offset.
  if($config{'validate_users'} eq 'yes') { $validated = "yes"; } else { $validated = "no"; }

  # Go ahead and write the account
  lock_open(member,"$cgi_path/members/$fuser.dat","w");
  truncate(member,0);
  seek(member,0,0);
  print member "username=$user\n";
  print member "password=$crypted\n";
  print member "salt=$salt\n";
  print member "email=$email\n";
  print member "interests=$interests\n";
  print member "homepage=$homepage\n";
  print member "showemail=$showemail\n";
  print member "aimname=$aimname\n";
  print member "icqnumber=$icqnumber\n";
  print member "signature=$signature\n";
  print member "avatar=$avatar\n";
  print member "location=$location\n";
  print member "memberstate=member\n";
  print member "registeredon=$registered\n";
  print member "timeoffset=$offset\n";
  print member "posts=0\n";
  print member "tolerance=0\n";
  print member "dots=levelone.gif\n";
  print member "registerip=$ENV{'REMOTE_ADDR'}\n";
  print member "hearabout=$hearabout\n";
  print member "pmnotification=$pmnotify\n";
  print member "groups=$config{'default_user_group'}\n";
  print member "validated=$validated\n";
  close(member);
  
  # If the user is NOT validated, write them to the queue list.
  if($validated ne 'yes') {
    # Write the user entry to the queue
    lock_open(QUEUE,"$cgi_path/data/users.queue","a");
    seek(QUEUE,0,2);
    print QUEUE "$user\n";
    close(QUEUE);
    
    # Compile the validated addendum to the registration message
    $validatemessage = qq~
      <p>The message board is currently set to require validate of user accounts before access is granted.
      Your registration will be reviewed as quickly as possible and you will be informed whether or not
      your account has been validated for use.
    ~;
  }

  # Write the "books"
  lock_open(BOOKS,"$cgi_path/data/books.inf","rw");
  seek(BOOKS,0,0);
  @parts = <BOOKS>;
  chomp @parts;
  $parts[0]++;
  $parts[1] = $user;
  truncate(BOOKS,0);
  seek(BOOKS,0,0);
  foreach my $part (@parts) {
    if($part !~ /\n/) { $part = "$part\n"; }
    print BOOKS $part;
  }
  close(BOOKS);

  # Send registration emails if necessary
  if($config{'registration_notification'} eq 'yes') {   # They ARE necessary
    $subject = "$config{'board_name'} - A New User Has Registered";
    $message = qq~
      A new user has registered on $config{'board_name'}.<br><br>\n\n
      
      -----------------------------------------------------<br>\n
      Username: $user<br>\n
      Email: $email<br>\n
      IP: $ENV{'REMOTE_ADDR'}<br>\n
      How did you hear about us?: $hearabout<br>\n
      -----------------------------------------------------<br><br>\n\n
      
      <a href="$paths{'board_url'}profile.cgi?action=view&who=$user">$paths{'board_url'}profile.cgi?action=view&who=$user</a> for profile<br>\n~;
    
    # Send the email
    send_mail($config{'email_in_addr'},$subject,$message);
  }
  
  #$message = "<br><b>Your account has been created</b>.<br><br>\n";
  if($config{'autopasswords'} eq 'yes') {
    $message = qq~
      <p><b>Your account has been created</b>.</p>
      
      <p>Please be patient while your password is emailed to the email address you specified
      during registration.  Unfortunately, email is not always as instant as we might like!
      If in one hour your confirmation email has still not arrived at the address you specified,
      please re-register your account.</p>
      
      $validatemessage
    ~;
  } else {
    $message = qq~
      <p><b>Your account has been created</b>.</p>
      
      <p>Thank you for your interest in the message board.  We hope you enjoy your stay!  Be sure to
      check out the FAQ page (located on the top of most message board screens) if you are wondering
      about something.</p>
      
      $validatemessage
    ~;
  }
    

  redirect_die($message,"$paths{'board_url'}scarecrow.cgi",0,"navy","<b>Account Creation</b>");
}

sub showrules {
  my $rules = get_rules();
  
  print <<end;
    <table cellpadding=0 cellspacing=0 border=0 width=$config{'table_width'} bgcolor=$color_config{'border_color'} align=center><tr><td>
      <table cellpadding=6 cellspacing=1 border=0 width=100%>
        <tr>
         <td bgcolor=$color_config{'nav_top'} align=center><font face="Verdana" size="3"><b>$config{'board_name'} Rules</b></td>
        </tr>
        <tr>
         <td bgcolor=$color_config{'body_bgcolor'} align=left><font face="Verdana" size=2>
     <br>
        <ol>
	  $rules
        </ol>
      </td>
    </tr>
    </table>
    </td></tr></table><br>
    
    <form action="$paths{'board_url'}register.cgi" method="post">
      <input type="hidden" name="stepnum" value="2">
      <center><input type="submit" name="submit" value="I Have Read And Agree To Abide By The Rules Above"></center>
    </form>
end
}

sub get_rules {
  my $rules = "<ol>";
  lock_open(RULES,"$cgi_path/data/rules.txt","r");
  while($in = <RULES>) {
    $in = strip($in);
    $rules .= "<li>$in</li>\n";
  }
  close(RULES);
  $rules .= "</ol><br>";
  
  # Attach a disclaimer
  $rules .= qq~<p><font face=\"Verdana\" size=\"1\">These rules and regulations may change at any time with or
  without notice, and be enforced under the new conditions immediately upon such change.  The user agrees, by
  use of this message board, to be censored in any form the administration of such board deems necessary
  or proper to be conducive to an environment best suited for their type of message board.</font>~;


  return $rules;
}
