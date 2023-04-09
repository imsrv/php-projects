#!/usr/bin/perl

# This script will allow an administrator to create, delete, reorganize or
# edit forums as they see fit.
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
require "admin.lib";

# Check the cookie
$inf = get_cookie("mb-admin");
($cookieuser,$cookiepassword) = split(/\|/,$inf);

if(!$cookieuser) {   # Give them a chance to log in the admin cookie
  content();
  page_header("$config{'board_name'} > Forum Manager");
  admin_login("$paths{'board_url'}forummanage.cgi");
  page_footer();
  exit;
}

if(check_account($cookieuser,$cookiepassword) == $FALSE || perms($cookieuser,'ADMINCP') == $FALSE) {
  redirect_die("We're sorry, but your username/password combination was
  invalid or you do not have access to this area..","","4","black","You Do Not Have Access");
}

# Output the content type
content();
page_header("$config{'board_name'} > Forum Manager");

# Get the action and pass control to the appropriate function
$action = $Pairs{'action'};

if($action eq 'edit')        { editforum();     }
elsif($action eq 'del')      { deleteforum();   }
elsif($action eq 'eforum')   { forumedit();     }
elsif($action eq 'censor')   { censorforum();   }
elsif($action eq 'ecensor')  { forumcensor();   }
elsif($action eq 'echelon')  { echelonform();   }
elsif($action eq 'eechelon') { echelonsave();   }
elsif($action eq 'add')      { addforum();      }
elsif($action eq 'aforum')   { forumadd();      }
elsif($action eq 'del')      { delforum();      }
elsif($action eq 'dforum')   { forumdelete();   }
elsif($action eq 'reorder')  { reorderforums(); }
elsif($action eq 'rforum')   { forumsreorder(); }
elsif($action eq 'rulelist') { rulelist();      }
elsif($action eq 'arule')    { ruleadd();       }
elsif($action eq 'addrule')  { addrule();       }
elsif($action eq 'drule')    { delrule();       }
else                         { listforums();    }

sub echelonform {
  # Get the forum
  my $forum = $Pairs{'forum'};
  
  if(!-d "$cgi_path/forum$forum") {  print "<b>No such forum $forum.</b>";  exit; }  # Check that it exists
  
  # Load the censors
  lock_open(CENSORS,"$cgi_path/forum$forum/ECHELON.TXT","r");
  while($in = <CENSORS>) {
    $censors .= $in;
  }
  close(CENSORS);
  
  # Print out the editting form and instructions
  print <<end;
    <b>Forum $forum Echelon Triggers</b>
    
    <p>The format of the echelon trigger is simple: just place to word to trigger an alert on a line
    by itself.  Note that all triggers are case insensitive, so HelL is no different than "hell".
    
    Here is the list of words currently set as triggers.  Simply add or remove those triggers you wish
    hanged:
    
    <form action="$paths{'board_url'}forummanage.cgi" method="post">
      <textarea name="censors" cols="42" rows="15">$censors</textarea><br><br>
      <input type="hidden" name="action" value="eechelon">
      <input type="hidden" name="forum" value="$forum">
      <input type="submit" name="submit" value="Submit Changes">
    </form>
end
}

sub echelonsave {
  # Get the variables
  my $forum = $Pairs{'forum'};
  my $censors = $Pairs{'censors'};
  
  # Well, that should do it--output the censors back out
  lock_open(CENSORS,"$cgi_path/forum$forum/ECHELON.TXT","w");
  truncate(CENSORS,0);  seek(CENSORS,0,0);
  print CENSORS $censors;
  close(CENSORS);
  
  print "<b>Thank you!</b>  The echelon trigger list for forum $forum has successfully been modified.<br>\n";

}

# Provides the form to reorder forums
sub reorderforums {
  # Get the category to begin reordering
  my $cat = $Pairs{'cat'};
  
  # Figure out how many options there are in total
  lock_open(FORUMS,"$cgi_path/data/forum.lst","r");
  while($in = <FORUMS>) {
    my($cid) = split(/\|/,$in);
    if($cat == $cid) { # Match
      $total++;
      push @forums,$in;
    }
  }
  close(FORUMS);
  
  # Compile the option list
  my $optionlist = qq~<option value="">&nbsp;</option>~;
  for($x = 1; $x <= $total; $x++) {
    $optionlist .= qq~<option value="$x">$x</option>~;
  }
  
  # Print out the form and the bit of javascript we'll need to (ostensibly) verify we don't have duplicates
  print <<end;    
    <!-- Begin the table -->
    <table width="98%" align="center" bgcolor="$color_config{'border_color'}" border="0" cellspacing="0" cellpadding="0"><tr><td>
      <form action="$paths{'board_url'}forummanage.cgi" method="post">
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_bottom'}"><td colspan="3"><font face="Verdana" size="2"><b>&#187; Reorder Forums in Category $cat</b></td></tr>
        <tr bgcolor="$color_config{'nav_top'}">
	  <td width="15%"><font face="Verdana" size="2"><b>Current Position</b></font></td>
	  <td width="15%"><font face="Verdana" size="2"><b>New Position</b></font></td>
	  <td width="70%"><font face="Verdana" size="2"><b>Forum Name/Description</b></font></td>
	</tr>
end
  
  # Loop through and print each entry
  foreach my $entry (@forums) {
    $position++;
    my @parts = split(/\|/,$entry);
    print <<end;
      <tr bgcolor="$color_config{'body_bgcolor'}">
        <td width="15%"><font face="Verdana" size="2">$position</font></td>
	<td width="15%">
	  <select name="forum-$parts[1]" onChange="checkStatus(this); return true;">
	    $optionlist
	  </select>
	</td>
	<td width="70%"><font face="Verdana" size="2"><b>$parts[2]</b><br>$parts[3]</font></td>
      </tr>
end
  }
  
  # Finish the table off
  print <<end;
      <tr bgcolor="$color_config{'nav_top'}"><td colspan="3" align="center"><input type="submit" name="submit" value="Reorder Forums"></td></tr>
      </table>
      <input type="hidden" name="cat" value="$cat">
      <input type="hidden" name="total" value="$total">
      <input type="hidden" name="action" value="rforum">
      </form>
    </td></tr></table>
end
}

# Physically reorders forums
sub forumsreorder {
  my $cat = $Pairs{'cat'};  # The category number to reorder
  my $total = $Pairs{'total'};  # The total number of forums in this category
  
  # Loop through the list of forums for this category and place them in the appropriate place.
  lock_open(FORUMS,"$cgi_path/data/forum.lst","r");
  while($in = <FORUMS>) {
    $in = strip($in);
    my($cid,$fid) = split(/\|/,$in);
    if($cid == $cat) {  # One to reorder -- do it.
      my $position = $Pairs{"forum-$fid"};
      if($positions[$position]) {
        print "<b>Duplicate entries for position $position.</b><br>\n";
	exit;
      }
      else {
        $positions[$position] = $in;
      }
    } else { push @other, $in; }
  }
  close(FORUMS);
  
  # Loop through and insert the changed versions in the proper place
  $lastcat = 0;
  foreach my $foruminf (@other) {
    my($cid,$fid) = split(/\|/,$foruminf);
    if($cid > $lastcat) {  # We're on a new number right now.
      $lastcat = $cid;     # Set the last number to this one
      # There are three conditions to check...

      if($cid < $cat || $cid == $cat) {
        # We haven't yet reached the point to insert.  Do nothing.
      } 
      elsif($cid > $cat) { # We've passed it up -- insert it NOW
        foreach my $a (@positions) { push @forums,$a; }  # Add all the reorganized forums
	$done = "yes";
      }
    }
    # Regardless of what we've done previous, append this entry back in place
    push @forums,$foruminf
  }
  # If we've never inserted it, here is the place
  if($done ne 'yes') { foreach my $a (@positions) { push @forums,$a; } }
  
  # Write the changes back out to the file
  lock_open(FORUMS,"$cgi_path/data/forum.lst","w");
  truncate(FORUMS,0);    seek(FORUMS,0,0);
  foreach my $forum (@forums) {
    if($forum) { print FORUMS "$forum\n"; }
  }
  close(FORUMS);
  
  print "<p><b>Thank you!</b>  The forums for category $cat have successfully be reordered.  The new order is as follows:<br></p><ul>";
  foreach my $forum (@positions) {
    if($forum) {
      my(@parts) = split(/\|/,$forum);
      print "<li>$parts[2]</li>";
    }
  }
  print "</ul>";  
}

# Provides a confirmation dialog box for deleting a forum
sub delforum {
  # Grab some variables
  my $forum = $Pairs{'forum'};
  my($user,$pass) = ($cookieuser,$cookiepassword);
  
  # Output the table
  print <<end;
    <form action="$path{'board_url'}usereditor.cgi" method="post">
    <table width="98%" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><font face="Verdana" size="2"><b>Please Log In to Delete Forum $forum</b></font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Username</b></font></td><td><input type="text" name="user" value="$user"></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td><font face="Verdana" size="1"><b>Password</b></font></td><td><input type="password" name="pass" value="$pass"></td></tr>
	<tr bgcolor="$color_config{'body_bgcolor'}"><td colspan="2"><font face="Verdana" size="1"><b>Warning!</b><br>
	Deleting a forum will remove ALL of the posts in the forum and is <i>irreversible</i>.  Proceed only
	if you are sure you wish to do this.</td></tr>
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Delete Forum $forum"></td></tr>
      </table>
    </td></tr></table>
    <input type="hidden" name="action" value="dforum">
    <input type="hidden" name="forum" value="$forum">
    </form>
end
}

# Physically removes the selected forum.
sub forumdelete {
  my $forum = $Pairs{'forum'};
  
  # Username/password was already verified if we're here.  The form made them log in only to verify that
  # they indeed wanted to delete the forum - which they do.  Remove it from the forum list file.
  lock_open(FORUMS,"$cgi_path/data/forum.lst","rw");
  seek(FORUMS,0,0);
  while($in = <FORUMS>) {
    my($cat,$fid) = split(/\|/,$in);
    if($forum == $fid) { $done = 1; }    # Delete this forum
    else               { $final .= $in; }
  }
  truncate(FORUMS,0);    seek(FORUMS,0,0);
  print FORUMS $final;
  close(FORUMS);
  
  # Now nuke the entire directory
  unlink "$cgi_path/forum$forum";
  
  # Update them on the progress.
  if($done == 1) {
    print "<b>Thank you!</b>  Forum $forum has successfully been deleted and all of its messages removed.<br>\n";
  } else {
    print "<b>We're sorry</b>, forum $forum does not exist.<br>\n";
  }
}

# Provides the form to add a forum to a specified category.
sub addforum {

  # Get a few variables before we send out the form.
  my $canpost  = get_grouplist($foruminformation{$forum}{'canpost'});
  my $canreply = get_grouplist($foruminformation{$forum}{'canreply'});
  my $canread  = get_grouplist($foruminformation{$forum}{'canread'});
  my $categories = get_categories($cat);

  print <<end;
    <form action="$paths{'board_url'}forummanage.cgi" method="post">
    <table width="98%" align="center" cellspacing="0" cellpadding="0" borer="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><font face="Verdana" size="2"><b>Adding a New Forum</b></font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">Forum Name</font></td>
	  <td><input type="text" name="name" value="$foruminformation{$forum}{'name'}"></td>
	</tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">Forum Description</font></td>
	  <td><input type="text" name="description" value="$foruminformation{$forum}{'description'}"></td>
	</tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">Moderators</font><br><font face="Verdana" size="1">A comma-separated
	  list of case-sensitive usernames.</font></td>
	  <td><input type="text" name="moderators" value="$foruminformation{$forum}{'moderators'}"></td>
	</tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">HTML Allowed?</font></td>
	  <td><input type="radio" name="htmlallow" value="on" $opt[0]> Yes <input type="radio" name="htmlallow" value="off" $opt[1]> No</td>
	</tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">ScareCrow Codes allowed?</font></td>
	  <td><input type="radio" name="sccallow" value="on" $opt[2]> Yes <input type="radio" name="sccallow" value="off" $opt[3]> No</td>
	</tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">Forum Status</font></td>
	  <td>
	    <select name="forumstatus">
	      <option value="open" $opt[4]>All Replies Accepted</option>
	      <option value="closed" $opt[5]>No Replies Accepted</option>
	      <option value="guest" $opt[6]>Guest Posting Allowed</option>
	      <option value="admin" $opt[7]>Only Administrators May Post</option>
  	      <option value="mod" $opt[8]>Only Moderators/Administrators May Post</option>
	      <option value="private" $opt[9]>Only Specified Members May Enter</option>
	    </select>
	  </td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">Groups That Can Read This Forum</font></td>
	  <td>
	    <select name="canread" multiple exclusive size="4">
	    $canread
	    </select>
	  </td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">Groups That Can Post In This Forum</font></td>
	  <td>
	    <select name="canpost" multiple exclusive size="4">
	    $canpost
	    </select>
	  </td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">Groups That Can Reply In This Forum</font></td>
	  <td>
	    <select name="canreply" multiple exclusive size="4">
	    $canreply
	    </select>
	  </td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">Forum Belongs To Category</font></td>
	  <td>
	    $categories
	  </td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">Allow Announcements in This Forum?</font></td>
	  <td>
	    <input type="checkbox" name="announcements" value="yes"> <font face="Verdana" size="2">Yes</font>
	  </td>
	</tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">Forum Logo URL</font></td>
	  <td><input type="text" name="forumlogo" value="$foruminformation{$forum}{'forumlogo'}"></td>
	</tr>
	$priv
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Submit Changes"></td></tr>
      </table>
    </td></tr></table>
    <input type="hidden" name="action" value="aforum">
    </form>
end

}

# Physically adds a forum to a category.
sub forumadd {
  # Get the variables from the form
  my $name        = $Pairs{'name'};
  my $description = $Pairs{'description'};
  my $moderators  = $Pairs{'moderators'};
  my $forumlogo   = $Pairs{'forumlogo'};
  my $htmlallow   = $Pairs{'htmlallow'};
  my $sccallow    = $Pairs{'sccallow'};
  my $forumstatus = $Pairs{'forumstatus'};
  my $privatestatus= $Pairs{'privatestatus'};
  my $category    = $Pairs{'category'};
  my $canread     = $Pairs{'canread'};
  my $canpost     = $Pairs{'canpost'};
  my $canreply    = $Pairs{'canreply'};
  my $announce    = $Pairs{'announcements'};
  
  # Get the next available forum number
  for($x = 1; ; $x++) {
    if(!-d "$cgi_path/forum$x") {
      $forum = $x;
      last;
    }
  }
  # Create the directory for the new forum
  mkdir "$cgi_path/forum$forum", 0755;
  
  # First write the forum.opt file, since that is the easiest to deal with
  # The rest of the changes are easy -- make any/all of them right here
  $foruminformation{$forum}{'moderators'}    = $moderators;
  $foruminformation{$forum}{'forumlogo'}     = $forumlogo;
  $foruminformation{$forum}{'htmlallow'}     = $htmlallow;
  $foruminformation{$forum}{'sccallow'}      = $sccallow;
  $foruminformation{$forum}{'forumstatus'}   = $forumstatus;
  $foruminformation{$forum}{'privatestatus'} = $privatestatus;
  $foruminformation{$forum}{'canread'}       = $canread;
  $foruminformation{$forum}{'canpost'}       = $canpost;
  $foruminformation{$forum}{'canreply'}      = $canreply;
  $foruminformation{$forum}{'announcements'} = $announce;
  
  # Now save that array back into the forum.opt file
  lock_open(OPT,"$cgi_path/forum$forum/forum.opt","w");
  my $ref = $foruminformation{$forum};   # A hash reference
  foreach my $key (keys %$ref) {  # Dereference this baby and save the changes
    if($key eq 'name' || $key eq 'description') { next; }
    print OPT "$key=$foruminformation{$forum}{$key}\n";
  }
  close(OPT);
  
  # Now that the forum.opt file is written, we have to step through the data/forum.lst file and find the
  # correct location to place the file (the last forum in the specified category), and write all the
  # necessary data for THAT file.  Hmph.
  # First, let's get the list of forums
  lock_open(FORUMLST,"$cgi_path/data/forum.lst","r");
  my @forums = <FORUMLST>;
  close(FORUMLST);
  # Now sort it so that the categories are in order.
  @forums = sortcat(@forums);
  
  # They're in order.  Step through now until we find the right place to stick it.  While we're going,
  # compile a $final variable to print back out upon completion.
  # Before we start, let's get some variables ready, including the line to place.
  my $final = "";     my $lastcat = 0;
  my $line = "$category|$forum|$name|$description|$moderators|$htmlallow|$sccallow|open|none|0|0|0|\n";
  foreach my $foruminf (@forums) {
    my($cid,$fid) = split(/\|/,$foruminf);
    if($cid > $lastcat) {  # We're on a new number right now.
      $lastcat = $cid;     # Set the last number to this one
      # There are three conditions to check...

      if($cid < $category || $cid == $category) {
        # We haven't yet reached the point to insert.  Do nothing.
      } 
      elsif($cid > $category) { # We've passed it up -- insert it NOW
        $final .= $line;
	$done = "yes";
      }
    }
    # Regardless of what we've done previous, append this entry back in place
    $final .= $foruminf;
  }
  # If we've never inserted it, here is the place
  if($done ne 'yes') { $final .= $line; }
  
  # Write the entries back out
  lock_open(FORUMLST,"$cgi_path/data/forum.lst","w");
  truncate(FORUMLST,0);   seek(FORUMLST,0,0);
  print FORUMLST $final;
  close(FORUMLST);
  
  # Update them on the progress
  print "<b>Thank you!</b>  $name has successfully been added as a new forum in category $category.<br>\n";
}

sub sortcat {
  my @data = @_;
  my @idx;
  # Compile the index array
  foreach $entry (@data) {
    my($cat) = split(/\|/,$entry);
    push @idx, $cat;
  }
  # Sort it
  @data = @data[ sort { $idx[$a] <=> $idx[$b] } 0 .. $#idx ];
  # Return
  return @data;

}


# Provides the form to add/remove censored words for a forum
sub censorforum {
  # Get the forum
  my $forum = $Pairs{'forum'};
  
  if(!-d "$cgi_path/forum$forum") {  print "<b>No such forum $forum.</b>";  exit; }  # Check that it exists
  
  # Load the censors
  lock_open(CENSORS,"$cgi_path/forum$forum/CENSOR.TXT","r");
  while($in = <CENSORS>) {
    $censors .= $in;
  }
  close(CENSORS);
  
  # Print out the editting form and instructions
  print <<end;
    <b>Forum $forum Word Censors</b>
    
    <p>The format of the forum censor is simple: badword=replacement, with one set per line.  For example, if
    you wanted to change any occurance of "hell" to "heck", you would put "hell=heck" on a line by itself.
    Note that all changes are case insensitive, so HelL is no different than "hell".
    
    Here is the list of words currently censored, and what they will be replaced with.  Simply add or remove
    those censors you wish changed:
    
    <form action="$paths{'board_url'}forummanage.cgi" method="post">
      <textarea name="censors" cols="42" rows="15">$censors</textarea><br><br>
      <input type="hidden" name="action" value="ecensor">
      <input type="hidden" name="forum" value="$forum">
      <input type="submit" name="submit" value="Submit Changes">
    </form>
end
}

# Makes the changes to the censored word list for a forum
sub forumcensor {
  # Get the variables
  my $forum = $Pairs{'forum'};
  my $censors = $Pairs{'censors'};
  
  # Well, that should do it--output the censors back out
  lock_open(CENSORS,"$cgi_path/forum$forum/CENSOR.TXT","w");
  truncate(CENSORS,0);  seek(CENSORS,0,0);
  print CENSORS $censors;
  close(CENSORS);
  
  print "<b>Thank you!</b>  The censored word list for forum $forum has successfully been modified.<br>\n";
}

sub editforum {
  my $forum = $Pairs{'forum'};
  # Get the forum data
  get_forum_information($forum);
  
  # Set up the @opt array
  # First, the HTML allows
  if($foruminformation{$forum}{'htmlallow'} eq 'on') { $opt[0] = "checked";  $opt[1] = ""; }
  else					       	      { $opt[0] = "";  $opt[1] = "checked"; }
  # SCC allows
  if($foruminformation{$forum}{'sccallow'} eq 'on')  { $opt[2] = "checked"; $opt[3] = "";  }
  else					      	      { $opt[2] = "";  $opt[3] = "checked"; }
  # Forum Status
  ($opt[4],$opt[5],$opt[6],$opt[7],$opt[8]) = "";   # Clear them all by default
  my $test = $foruminformation{$forum}{'forumstatus'};  # I'm lazy, I don't want to type all that...
  if($test eq 'open')      { $opt[4] = "selected"; }  elsif($test eq 'closed') { $opt[5] = "selected"; }
  elsif($test eq 'guest')  { $opt[6] = "selected"; }  elsif($test eq 'admin')  { $opt[7] = "selected"; }
  elsif($test eq 'mod')    { $opt[8] = "selected"; }  elsif($test eq 'private'){ $opt[9] = "selected"; }
  else      	 	   { $opt[4] = "selected"; }
  # Hide private information
  if($foruminformation{$forum}{'privatestatus'} eq 'hide')  { $opt[11] = "checked";  $opt[10] = ""; }
  else                                                      { $opt[11] = "";  $opt[10] = "checked"; }
  if($foruminformation{$forum}{'pollallow'} eq 'no')        { $opt[12] = "";  $opt[13] = "checked"; }
  else                                                      { $opt[12] = "checked";  $opt[13] = ""; }
  
  # Announcements in this forum?
  if($foruminformation{$forum}{'announcements'} eq 'yes')   { $opt[14] = "checked"; }
  else                                                      { $opt[14] = "";        }
  
  # The group lists with defaults
  my $canpost  = get_grouplist($foruminformation{$forum}{'canpost'});
  my $canreply = get_grouplist($foruminformation{$forum}{'canreply'});
  my $canread  = get_grouplist($foruminformation{$forum}{'canread'});
  
   
  # See if we need a private status marker
  $priv = qq~
    <tr bgcolor="$color_config{'body_bgcolor'}">
      <td><font face="Verdana" size="2">Show private forum details on index page?</font></td>
      <td><input type="radio" name="privatestatus" value="yes" $opt[10]> Yes <input type="radio" name="privatestatus" value="hide" $opt[11]> No</td>
    </tr>~;
  
  # Compile the category list
  $cat = get_current_category($forum);  # Get the category number it belongs to now
  $categories = get_categories($cat);
  
  # Set up the table now with the default values
  print <<end;
    <p><center><font face="Verdana" size="1">[ <a href="$paths{'board_url'}forummanage.cgi?action=censor&forum=$forum">Censor Words For This Forum</a> | <a href="$paths{'board_url'}forummanage.cgi?action=rulelist&forum=$forum">Modify Rules for This Forum</a> | <a href="$paths{'board_url'}forummanage.cgi?forum=$forum&action=echelon">Add Echelon Triggers</a> ]</font></center><br></p>
    <form action="$paths{'board_url'}forummanage.cgi" method="post">
    <table width="98%" align="center" cellspacing="0" cellpadding="0" borer="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><font face="Verdana" size="2"><b>Editting Forum $forum</b></font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">Forum Name</font></td>
	  <td><input type="text" name="name" value="$foruminformation{$forum}{'name'}"></td>
	</tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">Forum Description</font></td>
	  <td><input type="text" name="description" value="$foruminformation{$forum}{'description'}"></td>
	</tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">Moderators</font><br><font face="Verdana" size="1">A comma-separated
	  list of case-sensitive usernames.</font></td>
	  <td><input type="text" name="moderators" value="$foruminformation{$forum}{'moderators'}"></td>
	</tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">HTML Allowed?</font></td>
	  <td><input type="radio" name="htmlallow" value="on" $opt[0]> Yes <input type="radio" name="htmlallow" value="off" $opt[1]> No</td>
	</tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">ScareCrow Codes allowed?</font></td>
	  <td><input type="radio" name="sccallow" value="on" $opt[2]> Yes <input type="radio" name="sccallow" value="off" $opt[3]> No</td>
	</tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">Polls Allowed?</font></td>
	  <td><input type="radio" name="pollallow" value="yes" $opt[12]> Yes <input type="radio" name="pollallow" value="no" $opt[13]> No</td>
	</tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">Forum Status</font></td>
	  <td>
	    <select name="forumstatus">
	      <option value="open" $opt[4]>All Replies Accepted</option>
	      <option value="closed" $opt[5]>No Replies Accepted</option>
	      <option value="guest" $opt[6]>Guest Posting Allowed</option>
	      <option value="admin" $opt[7]>Only Administrators May Post</option>
  	      <option value="mod" $opt[8]>Only Moderators/Administrators May Post</option>
	      <option value="private" $opt[9]>Only Specified Members May Enter</option>
	    </select>
	  </td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">Groups That Can Read This Forum</font></td>
	  <td>
	    <select name="canread" multiple exclusive size="4">
	    $canread
	    </select>
	  </td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">Groups That Can Post In This Forum</font></td>
	  <td>
	    <select name="canpost" multiple exclusive size="4">
	    $canpost
	    </select>
	  </td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">Groups That Can Reply In This Forum</font></td>
	  <td>
	    <select name="canreply" multiple exclusive size="4">
	    $canreply
	    </select>
	  </td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">Forum Belongs To Category</font></td>
	  <td>
	    $categories
	  </td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">Allow Announcements in This Forum?</font></td>
	  <td>
	    <input type="checkbox" name="announcements" value="yes" $opt[14]> <font face="Verdana" size="2">Yes</font>
	  </td>
	</tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2">Forum Logo URL</font></td>
	  <td><input type="text" name="forumlogo" value="$foruminformation{$forum}{'forumlogo'}"></td>
	</tr>
	$priv
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Submit Changes"></td></tr>
      </table>
    </td></tr></table>
    <input type="hidden" name="action" value="eforum">
    <input type="hidden" name="forum" value="$forum">
    <input type="hidden" name="oldcat" value="$cat">
    </form>
end
}

# Physically submit the changes to the forum
sub forumedit {
  # Get the variables from the form
  my $name        = $Pairs{'name'};
  my $description = $Pairs{'description'};
  my $moderators  = $Pairs{'moderators'};
  my $forumlogo   = $Pairs{'forumlogo'};
  my $htmlallow   = $Pairs{'htmlallow'};
  my $sccallow    = $Pairs{'sccallow'};
  my $forumstatus = $Pairs{'forumstatus'};
  my $privatestatus= $Pairs{'privatestatus'};
  my $forum       = $Pairs{'forum'};
  my $category    = $Pairs{'category'};
  my $oldcat      = $Pairs{'oldcat'};
  my $canread     = $Pairs{'canread'};
  my $canpost     = $Pairs{'canpost'};
  my $canreply    = $Pairs{'canreply'};
  my $pollallow   = $Pairs{'pollallow'};
  my $announce    = $Pairs{'announcements'};
  
  # Get what the data is set to currently
  get_forum_information($forum);
  
  # IF and ONLY IF the name/description or category have changed, we have to make those changes the hard way.
  if($name ne $foruminformation{$forum}{'name'} ||
     $description ne $foruminformation{$forum}{'description'} ||
     $category != $oldcat) {  # <rolls up his sleeves> Let's do it.
       lock_open(FORUMS,"$cgi_path/data/forum.lst","rw");
       seek(FORUMS,0,0);
       while($in = <FORUMS>) {
         $in = strip($in);
	 my @parts = split(/\|/,$in);
	 if($parts[1] == $forum) {  # Match -- make the changes
	   $parts[0] = $category;
	   $parts[2] = $name;
	   $parts[3] = $description;
	 }
	 $in = join('|',@parts);   # Re-join the array
	 $final .= "$in\n";
       }
       truncate(FORUMS,0);
       seek(FORUMS,0,0);
       print FORUMS $final;
       close(FORUMS);
  }
  
  # The rest of the changes are easy -- make any/all of them right here
  $foruminformation{$forum}{'moderators'}    = $moderators;
  $foruminformation{$forum}{'forumlogo'}     = $forumlogo;
  $foruminformation{$forum}{'htmlallow'}     = $htmlallow;
  $foruminformation{$forum}{'sccallow'}      = $sccallow;
  $foruminformation{$forum}{'forumstatus'}   = $forumstatus;
  $foruminformation{$forum}{'privatestatus'} = $privatestatus;
  $foruminformation{$forum}{'canread'}       = $canread;
  $foruminformation{$forum}{'canpost'}       = $canpost;
  $foruminformation{$forum}{'canreply'}      = $canreply;
  $foruminformation{$forum}{'pollallow'}     = $pollallow;
  $foruminformation{$forum}{'announcements'} = $announce;
  
  # Now save that array back into the forum.opt file
  lock_open(OPT,"$cgi_path/forum$forum/forum.opt","w");
  my $ref = $foruminformation{$forum};   # A hash reference
  foreach my $key (keys %$ref) {  # Dereference this baby and save the changes
    if($key eq 'name' || $key eq 'description') { next; }
    print OPT "$key=$foruminformation{$forum}{$key}\n";
  }
  close(OPT);
  
  # We're done here.  Let them know.
  
  print "<b>Thank you!</b>  $name has successfully been modified to reflect your changes.<br>\n";

}

sub get_categories {
  my $cat = $_[0];
  my $output = qq~<select name="category">~;
  lock_open(CATS,"$cgi_path/data/catagories.lst","r");
  my $x = 0;
  while($in = <CATS>) {
    $in = strip($in);
    $x++;
    if($x == $cat) {
      $output .= qq~<option value="$x" selected>$in</option>~;
    } else {
      $output .= qq~<option value="$x">$in</option>~;
    }
  }
  close(CATS);
  $output .= qq~</select>~;
  
  return $output;
}

sub get_current_category {
  my $forum = $_[0];
  
  lock_open(LIST,"$cgi_path/data/forum.lst","r");
  while($in = <LIST>) {
    my($cat,$inforum) = split(/\|/,$in);
    if($forum == $inforum) {
      close(LIST);
      return $cat;
    }
  }
  close(LIST);
  
  return 0;
}

# Provide a forum list to select options from
sub listforums {
  # Start the table
  print <<end;
    <table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_bottom'}"><td colspan="2"><font face="Verdana" size="2"><b>&#187; Forum List</b></font></td></tr>
	<tr bgcolor="$color_config{'nav_top'}">
	  <td><font face="Verdana" size="2"><b>Category / Forum / Forum Name</b></font></td>
	  <td><font face="Verdana" size="2"><b>Options</b></font></td>
	</tr>
end

  # Loop through the list and print all entries
  lock_open(FORUMS,"$cgi_path/data/forum.lst","r");
  while($in = <FORUMS>) {
    my($catid,$fid,$name) = split(/\|/,$in);
    print <<end;
      <tr bgcolor="$color_config{'body_bgcolor'}">
        <td><font face="Verdana" size="2">$catid / $fid / $name</font></td>
        <td><font face="Verdana" size="2">
	  <a href="$paths{'board_url'}forummanage.cgi?action=edit&forum=$fid">Edit</a> |
	  <a href="$paths{'board_url'}forummanage.cgi?action=del&forum=$fid">Delete</a>
        </td>
      </tr>
end
  }
  close(FORUMS);
  
  # End the table
  print <<end;
      </table>
    </td></tr></table>
end
}


# Provides the form to delete/add rules
sub rulelist {
  my $forum = $Pairs{'forum'};
  lock_open(RULES,"$cgi_path/forum$forum/forum.rls","r");
  my @rules = <RULES>;
  close(RULES);
  
  # Print the form
  print <<end;
    <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'nav_bottom'}"><td colspan="2"><font face="Verdana" size="2"><b>&#187; Manage Forum $forum Rules</b> | <a href="$paths{'board_url'}forummanage.cgi?action=addrule&forum=$forum&type=time">Add Timer Rule</a> | <a href="$paths{'board_url'}forummanage.cgi?action=addrule&forum=$forum&type=count">Add Counter Rule</a></font></td></tr>
	<tr bgcolor="$color_config{'nav_top'}">
	  <td><font face="Verdana" size="2"><b>Rule</b></font></td>
	  <td><font face="Verdana" size="2"><b>Delete</b></font></td>
	</tr>
end

  # Print the rules entries
  foreach my $rule (@rules) {
    $rule = strip($rule);  $rulelink = $rule;
    $rulelink =~ s/ /\%20/ig;   # Convert spaces to %20's
    print <<end;
      <tr bgcolor="$color_config{'body_bgcolor'}">
        <td><font face="Verdana" size="2">$rule</font></td>
	<td><font face="Verdana" size="2"><a href="$paths{'board_url'}forummanage.cgi?forum=$forum&action=drule&rule=$rulelink">Delete</a></td>
      </tr>
end
  }
  
  # Finish the form
  print <<end;
      </table>
    </td></tr></table>
end
}

# Provides the form to add a timed forum rule
sub addrule {
  # Get the type and forum
  my $ruletype = $Pairs{'type'};
  my $forum = $Pairs{'forum'};
  
  # Start the neutral part of the form
  print <<end;
    <table width="98%" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="$color_config{'border_color'}"><tr><td>
      <form action="$paths{'board_url'}forummanage.cgi" method="post">
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="2"><b>&#187; Add a Forum Rule</b></font></td></tr>
end

  # Determine what kind of rule we're dealing with and output the form appropriately
  if($ruletype eq 'count')  {  # A counter rule
    print <<end;
          <tr bgcolor="$color_config{'body_bgcolor'}">
	    <td><font face="Verdana" size="2"><b>Number of threads to keep</b></font>
	    <td><input type="text" name="num"></td>
	  </tr>
end
  }
  else {                       # A timed rule
    print <<end;
          <tr bgcolor="$color_config{'body_bgcolor'}">
	    <td><font face="Verdana" size="2"><b>Number of Minutes/Days/Years/etc</b></font>
	    <td><input type="text" name="num"></td>
	  </tr>
          <tr bgcolor="$color_config{'body_bgcolor'}">
	    <td><font face="Verdana" size="2"><b>Unit Type</b></font>
	    <td>
	      <select name="units">
	        <option value="seconds">Seconds</option>
	        <option value="minutes">Minutes</option>
	        <option value="hours">Hours</option>
	        <option value="days" selected>Days</option>
	        <option value="months">Months</option>
	        <option value="years">Years</option>
	      </select>
	    </td>
	  </tr>
          <tr bgcolor="$color_config{'body_bgcolor'}">
	    <td><font face="Verdana" size="2"><b>Check Location</b></font>
	    <td>
	      <select name="type">
	        <option value="modified">Last Modified Date</option>
		<option value="created">Thread Creation Date</option>
	      </select>
	    </td>
	  </tr>
end
  }

  # End the neutral part of the form
  print <<end;
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Save Rule"></td></tr>
        <input type="hidden" name="ruletype" value="$ruletype">
        <input type="hidden" name="forum"    value="$forum">
	<input type="hidden" name="action"   value="arule">
      </table>
      </form>
    </td></tr></table>
end
}

# Physically adds the timed forum rule
sub ruleadd {
  # Get the type and forum
  my $ruletype = $Pairs{'ruletype'};
  my $forum = $Pairs{'forum'};
  
  # Figure out what type of rule it was and format the addition.
  if($ruletype eq 'count')  { # A counter rule
    $saverule = "$ruletype $Pairs{'num'}\n";
  }
  else {  # A time rule
    $saverule = "$ruletype $Pairs{'num'} $Pairs{'units'} $Pairs{'type'}\n";
  }
  
  # Add the rule
  lock_open(RULES,"$cgi_path/forum$forum/forum.rls","a");
  seek(RULES,0,2);
  print RULES $saverule;
  close(RULES);
  
  print "<font face=\"Verdana\" size=\"2\"><b>Thank you!</b>  Your rule ($saverule) has successfully been added.<br></font>\n";  
}

# Removes a rule
sub delrule {
  # Get the rule to delete and the forum to delete it from
  my $rule  = $Pairs{'rule'};
  my $forum = $Pairs{'forum'};
  
  # Delete the rule
  lock_open(RULES,"$cgi_path/forum$forum/forum.rls","rw");
  seek(RULES,0,0);
  while($in = <RULES>) {
    $in = strip($in);
    if($rule eq $in) { $done = 1;             }
    else             { $final .= $in;         }
  }
  truncate(RULES,0);   seek(RULES,0,0);
  print RULES $final;
  close(RULES);
  
  # Update the user on the progress
  if($done == 1) {
    print "<font face=\"Verdana\" size=\"2\"><b>Thank you!</b>  The selected rule has been removed.</font>";
  }
  else {
    print "<font face=\"Verdana\" size=\"2\"><b>Error!</b>  The selected rule ($rule) could not be found.";
  }
}
