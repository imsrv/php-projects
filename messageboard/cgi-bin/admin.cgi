#!/usr/bin/perl

# This script will supply the administrative function interfaces for the
# message board.  Most of the behind-the-scenes functions will be contained
# in the admin library file.
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

require 'global.cgi';
require 'admin.lib';

# Output the content headers
content();

# Get the action and determine the location
$action = $Pairs{'action'};
if($action eq 'deletethread')   { $loc = "Deleting a Thread";  }
elsif($action eq 'killthread')  { $loc = "Deleting a Thread";  }
elsif($action eq 'lock')        { $loc = "Locking a Thread";   }
elsif($action eq 'unlock')      { $loc = "Unlocking a Thread"; }
elsif($action eq 'locktopic')   { $loc = "Locking a Thread";   }
elsif($action eq 'unlocktopic') { $loc = "Unlocking a Thread"; }
elsif($action eq 'prune')       { $loc = "Pruning a Forum";    }
elsif($action eq 'pruneforum')  { $loc = "Pruning a Forum";    }
elsif($action eq 'sticky') {
  $type = $Pairs{'type'};
  if($type eq 'stick') { $loc = "Making a Sticky Topic"; }
  else                 { $loc = "Unsticking a Topic";    }
}
# Get the page started
page_header("$config{'board_name'} > $loc");
board_header();
user_line();
position_tracker("","$loc");
activeusers($loc);

# Pass control off to the appropriate function
if($action eq 'deletethread')   { deletethread(); }
elsif($action eq 'killthread')  { killthread();   }
elsif($action eq 'lock')        { locktopic();    }
elsif($action eq 'locktopic')   { writelock();    }
elsif($action eq 'unlock')      { unlocktopic();  }
elsif($action eq 'unlocktopic') { writeunlock();  }
elsif($action eq 'prune')       { prune();        }
elsif($action eq 'pruneforum')  { prune_forum();  }
elsif($action eq 'sticky')      { sticky();       }
elsif($action eq 'sendstick')   { sendstick();    }
page_footer();

sub deletethread {
  my $forum = $Pairs{'forum'};
  my $topic = $Pairs{'topic'};
  my $inf = get_cookie("mb-user");
  my($user,$pass) = split(/\|/,$inf);

  # Output the table
  print <<end;
    <form action="$path{'board_url'}admin.cgi" method="post">
    <table width="$config{'table_width'}" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><font face="Verdana" size="2"><b>Please Log In to Delete This Thread</b></font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Username</b></font></td><td><input type="text" name="user" value="$user"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Password</b></font></td><td><input type="password" name="pass" value="$pass"></td></tr>
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Delete Thread"></td></tr>
      </table>
    </td></tr></table>
    <input type="hidden" name="action" value="killthread">
    <input type="hidden" name="forum" value="$forum">
    <input type="hidden" name="topic" value="$topic">
    </form>
end
}

sub killthread {
  my $forum = $Pairs{'forum'};
  my $topic = $Pairs{'topic'};
  $user  = $Pairs{'user'};
  $pass  = $Pairs{'pass'};

  # Check that they have access
  checkit(1);  # Check account, but not access level
  
  # Load the thread and see if they are the post originator or not.
  lock_open(POST,"$cgi_path/forum$forum/$topic.idx","r");
  my $line = <POST>;
  close(POST);
  my @parts = split(/\|/,$line);


  if($parts[6] eq $user) {  # They are -- do they have the delete own permission?
    if(perms($user,'DELEOWN') == $FALSE) { noaccess('deleteown'); }
  } else {  # They're not the owner -- do they have the delete other permission?
    if(perms($user,'DELEOTH') == $FALSE) { noaccess('deleteother'); }
  }
  
  # They have access -- nuke the thread!
  $retval = delete_thread($forum,$topic,1);

  # Check the results
  if($retval <= 0) {
    $message = "Sorry, no such thread ($thread) exists in the specified forum ($forum).  Please make sure to follow only the board-generated links.";
    $subject = "Delete Aborted";
  }
  else {
    $message = "Thank you!  The thread has successfully been deleted.";
    $subject = "Thread Deleted";
  }

  redirect_die($message,"$paths{'board_url'}forum.cgi?forum=$forum","3","black",$subject);
}

sub locktopic {
  my $forum = $Pairs{'forum'};
  my $topic = $Pairs{'topic'};
  my $inf = get_cookie("mb-user");
  my($user,$pass) = split(/\|/,$inf);

  # Output the table
  print <<end;
    <form action="$path{'board_url'}admin.cgi" method="post">
    <table width="$config{'table_width'}" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><font face="Verdana" size="2"><b>Please Log In to Lock This Thread</b></font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Username</b></font></td><td><input type="text" name="user" value="$user"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Password</b></font></td><td><input type="password" name="pass" value="$pass"></td></tr>
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Lock Thread"></td></tr>
      </table>
    </td></tr></table>
    <input type="hidden" name="action" value="locktopic">
    <input type="hidden" name="forum" value="$forum">
    <input type="hidden" name="topic" value="$topic">
    </form>
end
}

sub unlocktopic {
  my $forum = $Pairs{'forum'};
  my $topic = $Pairs{'topic'};
  my $inf = get_cookie("mb-user");
  my($user,$pass) = split(/\|/,$inf);

  # Output the table
  print <<end;
    <form action="$path{'board_url'}admin.cgi" method="post">
    <table width="$config{'table_width'}" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><font face="Verdana" size="2"><b>Please Log In to Unlock This Thread</b></font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Username</b></font></td><td><input type="text" name="user" value="$user"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Password</b></font></td><td><input type="password" name="pass" value="$pass"></td></tr>
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Unlock Thread"></td></tr>
      </table>
    </td></tr></table>
    <input type="hidden" name="action" value="unlocktopic">
    <input type="hidden" name="forum" value="$forum">
    <input type="hidden" name="topic" value="$topic">
    </form>
end
}

sub writelock {
  $user  = $Pairs{'user'};
  $pass  = $Pairs{'pass'};
  my $forum = $Pairs{'forum'};
  my $topic = $Pairs{'topic'};

  checkit();
  if(perms($user,'LOCK') == $FALSE) { noaccess('lock'); }

  $retval = changestatus($forum,$topic,"locked");
  if($retval == $TRUE) {
    $subject = "Lock Successful";
    $message = "The selected topic has successfully been locked.";
  }
  else {
    $subject = "Lock Aborted";
    $message = "The selected topic was not locked successfully.";
  }
  redirect_die($message,"","3","black",$subject);
}

sub writeunlock {
  $user  = $Pairs{'user'};
  $pass  = $Pairs{'pass'};
  my $forum = $Pairs{'forum'};
  my $topic = $Pairs{'topic'};

  checkit();
  if(perms($user,'LOCK') == $FALSE) { noaccess('lock'); }

  $retval = changestatus($forum,$topic,"open");

  if($retval == $TRUE) {
    $subject = "Unlock Successful";
    $message = "The selected topic has successfully been unlocked.";
  }
  else {
    $subject = "Unlock Aborted";
    $message = "The selected topic was not unlocked successfully.";
  }
  redirect_die($message,"","3","black",$subject);
}

sub checkit {
  if(check_account($user,$pass) == $FALSE) {
    redirect_die("Sorry, you're username/password combination was invalid.  Please try again.","","3","black","Invalid Login");
  }
}

sub prune {
  my $forum = $Pairs{'forum'};
  my $inf = get_cookie("mb-user");
  my($user,$pass) = split(/\|/,$inf);

  # Output the table
  print <<end;
    <form action="$path{'board_url'}admin.cgi" method="post">
    <table width="$config{'table_width'}" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><font face="Verdana" size="2"><b>Please Log In to Prune This Forum</b></font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Username</b></font></td><td><input type="text" name="user" value="$user"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Password</b></font></td><td><input type="password" name="pass" value="$pass"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Days</b><br>Delete all threads with no modifications in this many days.</font></td><td><input type="text" name="days"></td></tr>
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Prune Forum"></td></tr>
      </table>
    </td></tr></table>
    <input type="hidden" name="action" value="pruneforum">
    <input type="hidden" name="forum" value="$forum">
    </form>
end
}

sub prune_forum {
  $user  = $Pairs{'user'};
  $pass  = $Pairs{'pass'};
  my $forum = $Pairs{'forum'};
  my $days  = $Pairs{'days'};

  checkit();
  
  if(perms($user,'PRUNE') == $FALSE) { noaccess('prune'); }

  $retval = pruneforum($forum,$days);

  if($retval != $FALSE) {
    $subject = "Prune Successful";
    $message = qq~
      Thank you!  The forum has been successfully been pruned, and <b>$retval</b>
      threads were successfully removed for being older than <b>$days days</b>.<br><br>

      <ul>
        <li><a href="$paths{'board_url'}forum.cgi?forum=$forum">Back to the forum</a></li>
        <li><a href="$paths{'board_url'}scarecrow.cgi">Back to the forum list</a></li>
      </ul>~;
  }
  else {
    $subject = "Prune Aborted";
    $message = qq~
      Sorry, but the forum did not exist or there were no matching threads
      older than <b>$days days</b>.  No threads were removed.<br><br>

      <ul>
        <li><a href="$paths{'board_url'}forum.cgi?forum=$forum">Back to the forum</a></li>
        <li><a href="$paths{'board_url'}scarecrow.cgi">Back to the forum list</a></li>
      </ul>~;
  }

  # Show status
  redirect_die($message,"$paths{'board_url'}forum.cgi?forum=$forum","4","black",$subject);
}

sub sticky {
  my $inf = get_cookie("mb-user");
  my($user,$pass) = split(/\|/,$inf);
  my $forum = $Pairs{'forum'};
  my $topic = $Pairs{'topic'};
  print <<end;
    <form action="$path{'board_url'}admin.cgi" method="post">
    <table width="$config{'table_width'}" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><font face="Verdana" size="2"><b>$loc</b></font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Username</b></font></td><td><input type="text" name="user" value="$user"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Password</b></font></td><td><input type="password" name="pass" value="$pass"></td></tr>
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Make Changes"></td></tr>
      </table>
    </td></tr></table>
    <input type="hidden" name="action" value="sendstick">
    <input type="hidden" name="forum" value="$forum">
    <input type="hidden" name="type" value="$type">
    <input type="hidden" name="topic" value="$topic">
    </form>
end
}

sub sendstick {
  my $forum = $Pairs{'forum'};
  my $topic = $Pairs{'topic'};
  my $user  = $Pairs{'user'};
  my $pass  = $Pairs{'pass'};
  my $type  = $Pairs{'type'};

  # Check that they have access
  if(check_account($user,$pass) == $FALSE) {
       redirect_die("Invalid username/password combination.  Please check your login and try again.","","3","black","Invalid Login");
  }
  if(perms($user,'STICKY') == $FALSE) { noaccess('sticky'); }

  # Make sure required variables exist
  if(!$forum || !$topic || !-e "$cgi_path/forum$forum/$topic.idx" || !$type) {
    redirect_die("You did not supply the required arguments or your arguments
    were invalid.  Please check the data and try again.","","3","black","Bad Arguments");
  }

  # Make the required changes
  if($type eq 'stick') { $type = "sticky"; }
  else                 { $type = "open";   }

  if(changestatus($forum,$topic,$type) == $FALSE) { # Failure
    $message = "We're sorry, but we could not complete your request.  Please
    inform the administrators.";
    $title = "Action Failed";
  } else {
    $message = qq~<b>Thank you!</b>  Your changes have successfully been made.<br><br>
    <ul>
      <li><a href="$paths{'board_url'}topic.cgi?forum=$forum&topic=$topic">Back to the topic</a></li>
      <li><a href="$paths{'board_url'}forum.cgi?forum=$forum">Back to the forum</a></li>
      <li><a href="$paths{'board_url'}scarecrow.cgi">Back to the forums index</a></li>
    </ul>~;
    $title = "Action Successful!";
  }

  redirect_die($message,"$paths{'board_url'}topic.cgi?forum=$forum&topic=$topic","3","black",$title);
  
}
