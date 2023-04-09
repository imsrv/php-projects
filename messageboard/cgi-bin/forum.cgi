#!/usr/bin/perl

# This script will handle displaying the contents of a forum, paginating it
# properly, displaying correct new tags, et cetera.
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

# Output the content headers
content();

# Get some variables
$forum = $Pairs{'forum'};
if($forum == -1) {
  use CGI;
  redirect("$paths{'board_url'}scarecrow.cgi");
  exit;
}

# Get the forum information
@foruminfo = get_forum_information($forum);

page_header("$config{'board_name'} > $foruminfo[2]");   # Start the page
board_header();                           # Display the board header
user_line();                              # Display the user information box
position_tracker($foruminfo[13],$foruminfo[2]);

## Check if this is a private forum and, if so, if the user has access
if($foruminformation{$forum}{'forumstatus'} eq 'private') {
  check_private(@foruminfo);
} else {
  # Send the active user data
  activeusers("Viewing <a href=\"$paths{'board_url'}forum.cgi?forum=$forum\">$foruminfo[2]</a>");
}

## Check the read list
my $inf = get_cookie("mb-user");
my($user,$pass) = split(/\|/,$inf);
if(hasgroup($user,$foruminformation{$forum}{'canread'}) != $TRUE) { noaccess('read'); }

## Load the forum information
lock_open(forum,"forum$forum/forum.lst",'r');
@entries = <forum>;
close(forum);

# Sort the entries by last posted date, or by creation date
@entries = datesortit(@entries);

my $pages = get_pages(1);
my $moderators = get_moderators($foruminfo[4]);

print <<end;
  <table width="$config{'table_width'}" bgcolor="$color_config{'border_color'}" align="center" cellspacing="0" cellpadding="1" border="0"><tr><td>
    <table width="100%" cellpadding="5" cellspacing="0" border="0">
      <tr bgcolor="$color_config{'info_box'}">
        <td align="left"><font face="Verdana" size="1">$pages</font></td><td align="right"><font face="Verdana" size="1"><b>Forum moderated by</b>: $moderators</td>
      </tr>
    </table>
  </td></tr></table><br>
end

print <<end;
  <table width="$config{'table_width'}" bgcolor="$color_config{'border_color'}" align="center" cellspacing="0" cellpadding="0" border="0"><tr><td>
    <table width="100%" cellpadding="5" cellspacing="1" border="0">
      <tr bgcolor="$color_config{'table_headers'}">
        <td colspan="2" width="40%">&nbsp;<a href="$paths{'board_url'}post.cgi?action=new&forum=$forum"><img src="$paths{'noncgi_url'}/images/newtopic.gif" border="0"></a> &nbsp; \&nbsp; <a href="$paths{'board_url'}poll.cgi?action=howmany&forum=$forum"><img src="$paths{'noncgi_url'}/images/newpoll.gif" border="0"></a></td>
        <td><font face="Verdana" size="1"><b>Topic Information</b></font></td>
        <td><font face="Verdana" size="1"><b>Last Modified</b></font></td>
      </tr>
end

# Check if announcements are allowed for this forum, and if there are any
if($foruminformation{$forum}{'announcements'} eq 'yes') {
  lock_open(announcements,"$cgi_path/forum$forum/announcements.txt",'r');
  $announce = <announcements>;
  close(announcements);
  my($posted,$posted_by,$topic_title,$message) = split(/\|/,$announce);
  my $postedat = get_time($posted,"%mn %md, %ye");
  if(!$topic_title) { $topic_title = "&nbsp;"; }
  print <<end
    <!-- Forum announcements header -->
    <tr bgcolor="$color_config{'nav_bottom'}"><td colspan="4"><font face="Verdana" size="3"><b>&#187; Forum Announcements</b></font></td></tr>
    <!-- Forum announcements bar -->
    <tr bgcolor="$color_config{'nav_top'}">
      <td width="4%">&nbsp;</td>
      <td width="40%"><font face="verdana" size="2">$topic_title</font></td>
      <td width="27%" align="center"><font face="verdana" size="2">[ <a href="$paths{'board_url'}announcements.cgi?forum=$forum">Read</a> ]</font></td>
      <td width="29%"><font face="Verdana" size="1"><b>$postedat</b></font></td>
    </tr>
    <!-- Forum posts header -->
    <tr bgcolor="$color_config{'nav_bottom'}"><td colspan="4"><font face="Verdana" size="3"><b>&#187; $foruminfo[2] Posts</b></font></td></tr>
end
}


$page = $Pairs{'page'};
$startat = $page * $config{'threads_per_page'} - $config{'threads_per_page'};

# Last read time for the forum
$forumtime = get_cookie("mb-forums");
if(!$forumtime) { $forumtime = get_lastvisited($forum); } else {
    my @forumtimes = split(/\|/,$forumtime);
    $forumtime = $forumtimes[$forum];
}

# Calling user (for tolerance levels)
my $inf = get_cookie("mb-user");
($caller,$password) = split(/\|/,$inf);
get_member($caller);
$tolerance = $users{$caller}{'tolerance'} || 0;

# Sticky posts
@sticky = datesort(@sticky);
foreach $entry (@sticky) {
  ($topicnumber,$topictitle,$topicdescription,$topicstate,$replies,$views,$poster,$posttime,$lastposter,$lastmodtime) = split(/\|/,$entry);
  $sticky = 1;
  format_and_print();
}

# Loop through and print the normal entries
$done = 0;
foreach my $entry (@entries) {
  # Pagination
  if($done == $config{'threads_per_page'}) { last; }
  if($count < $startat) { $count++; next; }
  $sticky = 0;

  ($topicnumber,$topictitle,$topicdescription,$topicstate,$replies,$views,$poster,$posttime,$lastposter,$lastmodtime) = split(/\|/,$entry);
  if($topicstate eq 'sticky' || $topicstate eq 'stickylocked') { next; }
  format_and_print();
  $done++;
}
$pages  = get_pages();
$forumjump = forumjump();

print <<end;
    </table>
    <table width="100%" cellpadding="5" cellspacing="1" border="0">
      <tr bgcolor="$color_config{'nav_bottom'}">
        <td valign="top">
          <font face="Verdana" size="1">$pages</font>
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
    <tr bgcolor="$color_config{'body_bgcolor'}"><td align="right">
      <font face="Verdana" size="1"><b>Forum Options:</b> <a href="$paths{'board_url'}admin.cgi?action=prune&forum=$forum">Prune Forum</a>&nbsp;</font>
    </td></tr>
  </table>
end

taglist();
page_footer();


sub get_moderators {
  if(!$_[0]) { return ""; }
  my @moderators = split(/,/,$_[0]);
  my $final = "";
  foreach $mod (@moderators) {
    $okmod = $mod;   $okmod =~ s/ /\%20/ig;
    $z++;
    if($z > 1) { $final .= ", <a href=\"$paths{'board_url'}profile.cgi?action=view&user=$okmod\">$mod</a>"; }
    else       { $final .=  "<a href=\"$paths{'board_url'}profile.cgi?action=view&user=$okmod\">$mod</a>"; }
  }

  return $final;

}

sub get_pages {
  my $totaltopics = @entries;
  if(!$config{'threads_per_page'}) { $config{'threads_per_page'} = 30; }

  my $pagesneeded = int($totaltopics / $config{'threads_per_page'});
  if($totaltopics % $config{'threads_per_page'} != 0) { $pagesneeded++; }
  my $counter = 0;
  $currentpage = $Pairs{'page'};
  if(!$currentpage) { $currentpage = 1; }

  if($totaltopics <= $config{'threads_per_page'}) { return "[ Single page for this forum ]"; }
  if($pagesneeded > 15 && $_[0] == 1) { return "[ Multiple pages for this forum ]"; }

  my $final = "<b>Multiple pages for this forum</b> [";
  for($counter = 1; $counter <= $pagesneeded; $counter++) {
    if($counter == $currentpage) {
      $final .= " $counter";
    }
    else {
      $final .= " <a href=\"$paths{'board_url'}forum.cgi?forum=$forum&page=$counter\"><b>$counter</b></a>";
    }
  }
  $final .= " ]";

  return $final;
}

sub get_topicpages {
  my $totaltopics = $_[0];
  if(!$config{'messages_per_page'}) { $config{'messages_per_page'} = 30; }

  my $pagesneeded = int($totaltopics / $config{'messages_per_page'});
  if($totaltopics % $config{'messages_per_page'} != 0) { $pagesneeded++; }
  my $counter = 0;

  if($totaltopics <= $config{'messages_per_page'}) { return ""; }

  my $final = "<font face=\"Verdana\" size=\"1\"><b>Pages</b> [";
  for($counter = 1; $counter <= $pagesneeded; $counter++) {
    $final .= " <a href=\"$paths{'board_url'}topic.cgi?forum=$forum&topic=$topicnumber&page=$counter\"><b>$counter</b></a>";
  }
  $final .= "&nbsp;]</font>";

  return $final;
  
}

sub datesortit {
  my @data = @_;
  my @idx;
  # Compile the index array
  foreach $entry (@data) {
    my($topicnumber,$topictitle,$topicdescription,$topicstate,$replies,$views,$poster,$posttime,$lastposter,$lastmodtime) = split(/\|/,$entry);
    # Sticky posts
    if($topicstate eq 'sticky' || $topicstate eq 'stickylocked') { push @sticky,$entry;
      push @idx, $posttime > $lastmodtime ? $posttime : $lastmodtime;
    } else {
      push @idx, $posttime > $lastmodtime ? $posttime : $lastmodtime;
    }
  }
  # Sort it
  @data = @data[ sort { $idx[$b] <=> $idx[$a] } 0 .. $#idx ];
  # Return
  return @data;
}

sub format_and_print {
  # Quickly check tolerance levels
  lock_open(THREAD,"$cgi_path/forum$forum/$topic.thd","r");
  $line = <THREAD>;
  close(THREAD);
  my @parts = split(/\|/,$line);
  my $votes = $parts[8];   my $score = $parts[9];
  # Check the tolerance level or we don't need to do a thing
  if($votes) {
    $avg = int($score / $votes + .5);
    if($votes > 5 && $avg >= -1) {  # five votes before tolerance; spikes OK
      if($avg < $tolerance) { return; }  # Does not meet tolerance setting
    }
  }

  # Get pages for the threads
  $topicpages = get_topicpages($replies+1) || "";
  $topictitle = qq~<a href="$paths{'board_url'}topic.cgi?forum=$forum&topic=$topicnumber"><b>$topictitle</b></a> $topicpages~;


  if($topicstate eq 'locked') {
    $new = "<img src=\"" . $paths{'noncgi_url'} . '/images/locked.gif' . "\">";
    $tagicons[4] = 1;
  } elsif($topicstate eq 'stickylocked') {
    $new = "<img src=\"$paths{'noncgi_url'}/images/stickylocked.gif\">";
    $tagicons[7] = 1;
  } elsif(
    $config{'autolock_time'} > 0 &&
    perms($caller,'AUTOLCK') == $FALSE &&
    $lastmodtime + ($config{'autolock_time'} * 86400) < time) {
      $new = qq~<img src="$paths{'noncgi_url'}/images/locked.gif">~;
      $tagicons[4] = 1;
  } else {
    $new = get_newtag($forumtime,$lastmodtime,$replies,$sticky);
  }
  $lasttime   = get_time($lastmodtime,"%mn %md, %ye - %th%hr:%mi %ap");
  if($topicdescription) { $topicdescription = "&#187; $topicdescription"; }
  if(!$replies) { $replies = 0; }
  if(!$views)   { $views = 0;   }
  $okposter = $poster;   $okposter =~ s/ /\%20/ig;
  $oklastposter = $lastposter;   $oklastposter =~ s/ /\%20/ig;

  print <<end;
      <tr>
        <td valign="middle" align="center" bgcolor="$color_config{'nav_top'}" width="4%">$new</td>
        <td bgcolor="$color_config{'nav_top'}" width="40%"><font face="Verdana" size="2">$topictitle</font><br>
        <font face="Verdana" size="1">$topicdescription</font></td>
        <td bgcolor="$color_config{'nav_top'}" width="27%"><font face="Verdana" size="1"><b>$replies</b> replies, viewed <b>$views</b> times<br>Started by: <a href="$paths{'board_url'}profile.cgi?action=show&user=$okposter">$poster</a></font></td>
        <td bgcolor="$color_config{'nav_bottom'}" width="29%"><font face="Verdana" size="1">$lasttime<br>by: <a href="$paths{'board_url'}profile.cgi?action=show&user=$oklastposter">$lastposter</a></font></td>
      </tr>
end
}
