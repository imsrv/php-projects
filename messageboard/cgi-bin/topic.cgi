#!/usr/bin/perl

# This script will handle the display of a topic within a forum.
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
# Revision: June 2001

require 'global.cgi';

# Load and verify the variables
$forum = $Pairs{'forum'};
$topic = $Pairs{'topic'};

if(!$forum || ($topic && !-e "$cgi_path/forum$forum/$topic.thd")) {
  scarecrow_die("topic.cgi: Invalid parameters passed to script.  Valid forum and topic were not supplied.");
}

# Get the forum information
@foruminfo = get_forum_information($forum);

# Check if the user can even view this forum at all.
# Get the username/password for validation
my $inf = get_cookie("mb-user");
 ($user,$password) = split(/\|/,$inf);

# Get the topic information
@threadinfo = get_topic_information($forum,$topic);

# Find the previous and next topic numbers
($prev,$next) = prevnext_ids($forum,$topic);

# Get the moderators and pages
$mods      = get_moderators($foruminfo[4]);
$pages[0]  = get_pages(1);
$pages[1]  = get_pages();
$forumjump = forumjump();

# Get the forum times information
my $inf = get_cookie("mb-forums");
my @forumtimes = split(/\|/,$inf);
$forumtime = $forumtimes[$forum] || 0;


# Update cookie information and send the cookie if necessary
if($inf) { $option = 0; }
else     { $option = 1; }
update_lastread($forum,$option);

# Add a view to the counter
addview($forum,$topic);

# Start the page
my @info = split(/\|/,$threadinfo[0]);
page_header("$config{'board_name'} > $info[2]");   # Start the page
board_header();                           # Display the board header
user_line();                              # Display the user information box
my $line = "<a href=\"$paths{'board_url'}forum.cgi\?forum=$forum\">";
$line .= $foruminfo[2];
$line .= "</a>";
position_tracker($foruminfo[13],$line,$info[2]);

# Send the active user data
if($foruminformation{$forum}{'forumstatus'} eq 'private') {  # Private does not show active users
  check_private(@foruminfo);
} else {
  activeusers("Viewing <a href=\"$paths{'board_url'}topic.cgi?forum=$forum&topic=$topic\">$info[2]</a> in <a href=\"$paths{'board_url'}forum.cgi?forum=$forum\">$foruminfo[2]</a>");
}

# Check if it's a valid login at all
if($inf && $user && $password && check_account($user,$password) != $TRUE) { $user = ""; }

# Check if they have read access, by group
if(hasgroup($user,$foruminformation{$forum}{'canread'}) != $TRUE) { noaccess('read'); }

# Figure out the previous/next line
if($prev == 0) {
  $prevnext = qq~<a href="$paths{'board_url'}topic.cgi?forum=$forum&topic=$next">Next &#187~;
} elsif($next == 0) {
  $prevnext = qq~<a href="$paths{'board_url'}topic.cgi?forum=$forum&topic=$prev">&#171; Back</a>~;
} else {
  $prevnext = qq~<a href="$paths{'board_url'}topic.cgi?forum=$forum&topic=$prev">&#171; Back</a> | <a href="$paths{'board_url'}topic.cgi?forum=$forum&topic=$next">Next &#187~;
}


$|++;




# The header of the table
$output = qq~
  <!-- Forum information and topic navigation table -->
  <table align="center" width="$config{'table_width'}" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}" border="0"><tr><td>
    <table width="100%" cellspacing="1" cellpadding="4" border="0"><tr bgcolor="$color_config{'nav_bottom'}">
    <td width="17%">
      <font face="Verdana" size="1">
        <center>Topic Jump</center>
        <center>$prevnext</center>
      </font>
    </td>
    <td>
      <font face="Verdana" size="1">
        $pages[0]<br>
        $mods
      </font>
    </td>
    <td width="25%">
      <a href="$paths{'board_url'}misc.cgi?action=emailfriend&forum=$forum&topic=$topic"><img border="0" src="$paths{'noncgi_url'}/images/send_to_a_friend.gif"></a>&nbsp;&nbsp;<a href="$paths{'board_url'}misc.cgi?action=printable&forum=$forum&topic=$topic\"><img src="$paths{'noncgi_url'}/images/printable.gif" border="0"></a>
    </td>
    </tr></table>
  </td></tr></table><br>~;

# If there are any polls to output, do so here.
if(-e "$cgi_path/forum$forum/$topic.poll") {
  $output .= polldisplay($forum,$topic);
  $output .= "<br><br>";
}

$output .= qq~
  <!-- Topic display table -->
  <table align="center" width="$config{'table_width'}" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}" border="0"><tr><td>
    <table width="100%" cellspacing="1" cellpadding="5" border="0">
      <tr bgcolor="$color_config{'table_headers'}">
        <td colspan="2"><a href="$paths{'board_url'}post.cgi?forum=$forum"><img src="$paths{'noncgi_url'}/images/newtopic.gif" border="0"></a>&nbsp;&nbsp;<a href="$paths{'board_url'}post.cgi?forum=$forum&topic=$topic&type=reply&prev=$prev&next=$next"><img src="$paths{'noncgi_url'}/images/addreply.gif" border="0"></a>&nbsp;&nbsp;<a href="$paths{'board_url'}poll.cgi?action=howmany&forum=$forum"><img src="$paths{'noncgi_url'}/images/newpoll.gif" border="0"></a></td>
      </tr>
    </table>~;
    


# New tag
my $inf = get_cookie("mb-forums");
if(!$inf) { $forumtime = get_lastvisited($forum); } else {
  my @forumtimes = split(/\|/,$inf);
  $forumtime = $forumtimes[$forum];
}
# Calling user (for tolerance levels)
my $inf = get_cookie("mb-user");
($caller,$password) = split(/\|/,$inf);
get_member($caller);
$tolerance = $users{$caller}{'tolerance'} || 0;

# Pagination
$page = $Pairs{'page'};
if(!$page) { $page = 1; }
$startat = $page * $config{'messages_per_page'} - $config{'messages_per_page'};

# Loop through the data and print the tables
$|++;

foreach $reply (@threadinfo) {
  if($done == $config{'messages_per_page'}) { last; }
  if($count < $startat) { $count++; next; }
  $count++;

  my($id,$poster,$title,$ip,$disableemoticons,$showsignature,$emailreplies,$postedat,$votes,$score,$message) = split(/\|/,$reply);

  # Check the tolerance level or we don't need to do a thing
  if($votes) {
    $avg = int($score / $votes + .5);
    if($votes > 5 && $avg >= -1) {  # five votes before tolerance; spikes OK
      if($avg < $tolerance) { $done++; next; }  # Does not meet tolerance setting
    }
    # Get a truer average for display
    $avg = round($score / $votes,2);
  } else { $avg = "n/a"; }

  get_member($poster);

  # Optional message transformations
  if($foruminfo[5]  ne 'on')  {
    if($message =~ /\#\s?Moderation Mode/i) {  # Possible avoidance..
      if($users{$poster}{'memberstate'} eq 'admin' ||
         $users{$poster}{'memberstate'} eq 'mod' ||
         is_moderator($poster,$forum)) {  }
      else {
        $message =~ s/</\&lt\;/ig;  $message =~ s/>/\&gt\;/ig;
      }
    }
    else {
      $message =~ s/</\&lt\;/ig;  $message =~ s/>/\&gt\;/ig;
    }
  }
  if($disableemoticons ne 'yes') { $message = translate_emoticons($message); }
  if($showsignature eq 'yes') {
    if($users{$poster}{'signature'}) {
      $message .= "<br><br>-------<br>$users{$poster}{'signature'}";
    }
  }
  if($foruminfo[6]  eq 'on' ) { $message = codeify($message); }

  # Required message transformations
  $message =~ s/\n\n/<p>/ig;     $message =~ s/\n/<br>/ig;
  $message = badword_filter($message);

  # Assign a few variables now for easier entry output in the next step
    # Avatars
  $avatar = "";
  if($config{'avatars'} eq 'on') {
    my $av = $users{$poster}{'avatar'};
    if($av && $av ne 'noavatar') {
      # Determine ".gif" or ".jpg"
      if(-e "$paths{'noncgi_path'}/avatars/$av.gif") { $ext = "gif"; }
      else                                           { $ext = "jpg"; }
      $avatar = "<img src=\"$paths{'noncgi_url'}/avatars/$av.$ext\" height=\"64\" width=\"64\"><br>";
    }
  }
    # Moderator
  $dots = "";
  if($users{$poster}{'memberstate'} eq 'admin') {
    $class = $users{$poster}{'class'};
    if(!$class) { $class = "Administrator"; }
    $dots = "levelsix.gif";
    $namecolor = $color_config{'admin_color'};
  } 
  elsif($users{$poster}{'memberstate'} eq 'moderator' || is_moderator($poster,$forum) == $TRUE) {
    $class = $users{$poster}{'class'};
    if(!$class) { $class = "Moderator"; }
    #$dots = "levelfive.gif";
    $dots = $users{$poster}{'dots'};
    $namecolor = $color_config{'moderator_color'};
  } else {
    $class = $users{$poster}{'class'};
    if(!$class && $users{$poster}{'memberlevel'}) { $class = $users{$poster}{'memberlevel'}; }
    elsif(!$class)                                { $class = "Newbie";                       }
    $dots  = $users{$poster}{'dots'};
    $namecolor = $color_config{'user_color'};
  }
    # Registered on
  $regon    = get_time($users{$poster}{'registeredon'},"%mo/%md/%ye");
    # Posted on
  $postedon = get_time($postedat,"%hr:%mi %ap on %mn %md, %ye %th");
  if($x % 2 == 0) {
    $textcolor = $color_config{'text_alt1'};
    $topiccolor= $color_config{'topic_alt1'};
  } else {
    $textcolor = $color_config{'text_alt2'};
    $topiccolor= $color_config{'topic_alt2'};
  }
  $x++;
  # Compile the iconlist
  my $iconlist = "";
  if($users{$poster}{'showemail'} eq 'yes') {
    $iconlist .= qq~<a href="mailto:$users{$poster}{'email'}"><img src="$paths{'noncgi_url'}/images/email.gif" border="0")></a>&nbsp;~;
  }
  if($users{$poster}{'homepage'} || $users{$poster}{'homepage'} eq 'http://') {
    $iconlist .= qq~<a href="$users{$poster}{'homepage'}" target="_new"><img src="$paths{'noncgi_url'}/images/homepage.gif" border="0"></a>&nbsp;~;
  }
  if($users{$poster}{'icqnumber'}) {
    $iconlist .= qq~<a href="" onMouseOver="mouseit('Send an ICQ Message'); return true;" onMouseOut="mouseit(''); return true;" onClick="openScript('misc.cgi?action=sendicq&icq=$users{$poster}{'icqnumber'}','400','350'); return false;"><img src="http://wwp.icq.com/scripts/online.dll?icq=$users{$poster}{'icqnumber'}&img=5" border="0"><img src="$paths{'noncgi_url'}/images/icq.gif" border="0"></a>&nbsp;~;
  }
  $okposter = $poster;   $okposter =~ s/ /\%20/ig;
  $iconlist .= qq~<a href="$paths{'board_url'}profile.cgi?action=show&member=$okposter"><img src="$paths{'noncgi_url'}/images/profile.gif" border="0"></a>&nbsp;~;
  $iconlist .= qq~<a href="$paths{'board_url'}messanger.cgi?action=sendform&who=$poster"><img src="$paths{'noncgi_url'}/images/message.gif" border="0"></a>~;

  $tag = get_newtag($forumtime,$postedat,-1);

  # Output the entry
  $output .= qq~
    <a name="$id">
    <table width="100%" cellspacing="1" cellpadding="0" border="0">
      <tr bgcolor="$topiccolor"><td align="left">
        <table width="100%" cellspacing="1" cellpadding="5" border="0"><tr bgcolor="$topiccolor">
        <td valign="top" width="23%" align="left">
          <font face="Verdana" size="2"color="$namecolor"><b>$poster</b></font><br>
	</td>
	<td valign="top" align="center">
	  <p align="left"><a href="$paths{'board_url'}edit.cgi?forum=$forum&topic=$topic&id=$id"><img src="$paths{'noncgi_url'}/images/edit.gif" border="0"></a> | $iconlist | <a href="$paths{'board_url'}post.cgi?type=reply&forum=$forum&topic=$topic&quote=$id&next=$next&prev=$prev"><img src="$paths{'noncgi_url'}/images/reply.gif" border="0"></a>&nbsp;&nbsp; $tag &nbsp;&nbsp; <a href="$paths{'board_url'}misc.cgi?action=report&forum=$forum&topic=$topic&id=$id"><font face="Verdana" size="1" color="red">Report Post</font></a> <hr></p>
	</td></tr>
	<tr bgcolor="$topiccolor"><td valign="top" width="23%" align="left">
          $avatar
          <img src="$paths{'noncgi_url'}/images/$dots"><br>
          <font face="Verdana" size="1">$class</font><br>
          <font face="Verdana" size="1"><b>Average user rating:</b> $avg</font><br>
          <p><font face="Verdana" size="1">Rate this post:</font>
          <form action="$paths{'board_url'}ratepost.cgi" method="post" target="ratewindow" name="rater">
            <select name="vote" onChange="submit(); return false;">
              <option value=""></option>
              <option value="5">5</option>
              <option value="4">4</option>
              <option value="3">3</option>
              <option value="2">2</option>
              <option value="1">1</option>
              <option value="0">0</option>
              <option value="-1">-1</option>
            </select>
            <input type="hidden" name="forum" value="$forum">
            <input type="hidden" name="topic" value="$topic">
            <input type="hidden" name="id"    value="$id">
            <input type="submit" name="Vote" value="Vote">
          </form></p>
        </td>
	<td valign="top"><font face="Verdana" size="2" color="$textcolor">$message</font></td>
	</tr>
	<tr bgcolor="$topiccolor"><td width="23%" valign="top" align="left">&nbsp;</td>
	<td align="left">
          <p align="left"><hr>  
          <font face="Verdana" size="1" color="$textcolor"><b>Posts:</b> $users{$poster}{'posts'} | <b>Registered On:</b> $regon | <b>Posted:</b> $postedon | <a href="$paths{'board_url'}misc.cgi?action=ipview&forum=$forum&topic=$topic&id=$id">IP</a></font>
	</td></tr>
        </table>
      </td></tr>
    </table>~;
  $done++;
}
# The footer of the table
$output .= qq~
    <table width="100%" cellspacing="1" cellpadding="5" border="0">
      <tr bgcolor="$color_config{'table_headers'}">
        <td colspan="2"><a href="$paths{'board_url'}post.cgi?forum=$forum"><img src="$paths{'noncgi_url'}/images/newtopic.gif" border="0"></a>&nbsp;&nbsp;<a href="$paths{'board_url'}post.cgi?forum=$forum&topic=$topic&type=reply"><img src="$paths{'noncgi_url'}/images/addreply.gif" border="0"></a>&nbsp;&nbsp;<a href="$paths{'board_url'}poll.cgi?action=howmany&forum=$forum"><img src="$paths{'noncgi_url'}/images/newpoll.gif" border="0"></a></td>
      </tr>
    </table>
    <table width="100%" cellpadding="5" cellspacing="1" border="0">
      <tr bgcolor="$color_config{'nav_bottom'}">
        <td valign="top">
          <font face="Verdana" size="1">$pages[1]</font>
        </td>
        <td width="25%" valign="top">
          <font face="Verdana" size="1">
            <center>
            <form action="$paths{'board_url'}forum.cgi" method="get">
            <select name="forum">
              <option value="-1">Forum Jump</option>
              $forumjump
            </select><input type="submit" name="Submit" value="Go">
            </form>
            </center>
          </font>
        </td>
      </tr>
    </table>
  </td></tr></table>
  <!-- Forum information and topic navigation table -->
  <p><table align="center" width="$config{'table_width'}" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}" border="0"><tr><td>
    <table width="100%" cellspacing="1" cellpadding="4" border="0"><tr bgcolor="$color_config{'nav_bottom'}">
    <td width="17%">
      <font face="Verdana" size="1">
        <center>Topic Jump</center>
        <center>$prevnext</center>
      </font>
    </td>
    <td>
      <font face="Verdana" size="1">
        $pages[0]<br>
        $mods
      </font>
    </td>
    <td width="25%">
      <a href="$paths{'board_url'}misc.cgi?action=emailfriend&forum=$forum&topic=$topic"><img border="0" src="$paths{'noncgi_url'}/images/send_to_a_friend.gif"></a>&nbsp;&nbsp;<a href="$paths{'board_url'}misc.cgi?action=printable&forum=$forum&topic=$topic\"><img src="$paths{'noncgi_url'}/images/printable.gif" border="0"></a>
    </td>
    </tr></table>
  </td></tr></table><br>
  
  <table width="$config{'table_width'}" bgcolor="$color_config{'body_bgcolor'}" cellspacing="0" cellpadding="0" border="0">
    <tr bgcolor="$color_config{'body_bgcolor'}" align="right">
      <td align="right">
        <font face="Verdana" size="1">
          <b>Topic options:</b>
          <a href="$paths{'board_url'}admin.cgi?action=lock&forum=$forum&topic=$topic">Lock topic</a> | 
          <a href="$paths{'board_url'}admin.cgi?action=unlock&forum=$forum&topic=$topic">Unlock topic</a> |
          <a href="$paths{'board_url'}admin.cgi?action=sticky&forum=$forum&topic=$topic&type=stick">Make Topic Sticky</a> |
          <a href="$paths{'board_url'}admin.cgi?action=sticky&forum=$forum&topic=$topic&type=unstick">Remove Sticky</a> |
          <a href="$paths{'board_url'}admin.cgi?action=deletethread&forum=$forum&topic=$topic">Delete thread</a> | 
          <a href="$paths{'board_url'}movepost.cgi?action=form&forum=$forum&topic=$topic">Move thread</a></font></td>
    </tr>
  </table>~;


print $output;
page_footer();

sub prevnext_ids {
  my($forum,$topic) = @_;
  lock_open(list,"$cgi_path/forum$forum/forum.lst",'r');
  my @list = <list>;
  close(list);
  @list = datesort(@list);
  my $y = 0;
  for($y = 0; $y <= $#list; $y++) {
    my($num,@rest) = split(/\|/,$list[$y]);
    if($num == $topic) {  # FOUND IT!
      # Get the INFO on the previous and next
      my ($p,$n) = "";
      # Previous first
      if($y == 0) { $n = ""; }
      else { $n = $list[$y-1]; }
      if($n) { ($n,@rest) = split(/\|/,$n); }
      # Next
      if($y == $#list) { $p = ""; }
      else { $p = $list[$y+1]; }
      if($p) { ($p,@rest) = split(/\|/,$p); }

      return ($p,$n);
    }
  }

  # Could not find the specified entry
  return (0,0);
}

sub get_moderators {
  if(!$_[0]) { return ""; }
  my @moderators = split(/,/,$_[0]);
  my $final = "<b>Forum moderated by:</b> ";
  foreach $mod (@moderators) {
    $z++;
    $okmod = $mod;   $okmod =~ s/ /\%20/ig;
    if($z > 1) { $final .= ", <a href=\"$paths{'board_url'}profile.cgi?action=view&user=$okmod\">$mod</a>"; }
    else       { $final .=  "<a href=\"$paths{'board_url'}profile.cgi?action=view&user=$okmod\">$mod</a>"; }
  }

  return $final;
}

sub get_pages {
  my $currentpage = $Pairs{'page'};
  my $totaltopics = @threadinfo;
  if(!$config{'messages_per_page'}) { $config{'messages_per_page'} = 30; }

  my $pagesneeded = int($totaltopics / $config{'messages_per_page'});
  if($totaltopics % $config{'messages_per_page'} != 0) { $pagesneeded++; }
  my $counter = 0;
  if(!$currentpage) { $currentpage = 1; }

  if($totaltopics <= $config{'messages_per_page'}) { return "[ Single page for this topic ]"; }
  if($pagesneeded > 15 && $_[0] == 1) { return "[ Multiple pages for this topic ]"; }

  my $final = "Multiple pages for this topic [";
  for($counter = 1; $counter <= $pagesneeded; $counter++) {
    if($counter == $currentpage) {
      $final .= " $counter";
    }
    else {
      $final .= " <a href=\"$paths{'board_url'}topic.cgi?forum=$forum&topic=$topic&page=$counter\"><b>$counter</b></a>";
    }
  }
  $final .= " ]";

  return $final;
  
}

sub addview {
  my($forum,$topic) = @_;

  if(!-e "$cgi_path/forum$forum/$topic.idx") { return; }

  # Get the data
  lock_open(file,"$cgi_path/forum$forum/$topic.idx","r");
  my $line = <file>;
  close(file);
  lock_open(file,"$cgi_path/forum$forum/forum.lst","r");
  my @entries = <file>;
  close(file);
  foreach my $in (@entries) {
    $x++;
    my($test,@rest) = split(/\|/,$in);
    if($test == $topic) { $line2 = $in;  $found = $x; last; }
  }
  close(file);

  # Increment
  my @parts = split(/\|/,$line);
  my @parts2 = split(/\|/,$line2);
  $parts[5]++;
  $parts2[5]++;
  $line = join('|',@parts);
  $line2 = join('|',@parts2);
  $line = strip($line);   $line .= "\n";
  $line2 = strip($line2);  $line2 .= "\n";
                             
  # Re-write the new information
  lock_open(file,"$cgi_path/forum$forum/$topic.idx","w");
  truncate(file,0);
  seek(file,0,0);
  print file $line;
  close(file);

  lock_open(file,"$cgi_path/forum$forum/forum.lst","w");
  truncate(file,0);
  seek(file,0,0);
  $x = 0;
  foreach $in (@entries) {
    $in = strip($in);
    $in .= "\n";
    $x++;
    if($x == $found) { print file $line2; }
    else             { print file $in;    }
  }
  close(file);
}

sub badword_filter {
  my $message = $_[0];
  if(!$message || !-e "$cgi_path/data/badwords.txt") { return $message; }

  # Get the words to be filtered and their replacement words
  lock_open(FILTER,"$cgi_path/data/badwords.txt","r");
  @filters = <FILTER>;
  close(FILTER);

  # Loop through and make changes
  foreach my $filter (@filters) {
    my($word,$replacement) = split(/=/,$filter,2);
    $message =~ s/$word/$replacement/ig;
  }

  return $message;
}
