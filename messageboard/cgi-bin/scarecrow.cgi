#!/usr/bin/perl

# This script will handle displaying the main forum entries, along with
# catagory entries, and should serve as the FIRST script that is linked
# from a website.
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

page_header($config{'board_name'});    # Display the page header
board_header();   # Display the board header
user_line();      # Display the user information box
position_tracker("");

# Send the active user data
activeusers("Main Board Page");

my $type = $Pairs{'type'};
if($type eq 'rebuild') { buildit(); }

if($type eq 'subcatagory') {
  my $cid = $Pairs{'catagory'};
  if(!$cid || !-e "$cgi_path/data/subcat$cid.dat") {
    redirect_die("Sorry, but the subcatagory number you specified was invalid.
    Please check the validity of your data and try again.","$paths{'board_url'}scarecrow.cgi",
     "3","black","Invalid Subcatagory");
  }
  lock_open(forum_list,"$cgi_pdata/data/subcat$cid.dat","r");
  @forums = <forum_list>;
  close(forum_list);
} else {
  lock_open(forum_list,"data/forum.lst",'r');
  @forums = <forum_list>;
  close(forum_list);
}

## Organize the forums according to their catagory
foreach $forum (@forums) {
  my($catid,@rest) = split(/|/,$forum);
  push @idx,$catid;
}
@forums = @forums[ sort { $idx[$a] <=> $idx[$b] } 0 .. $#idx ];

## Get the catagory names
$x = 0;
lock_open(catagory_file,"data/catagories.lst",'r');
while($in = <catagory_file>) {
  $in = strip($in);
  $x++;
  $catagories{$x} = $in;
}
close(catagory_file);

# Sort the forums by category entry
@forums = sortcat(@forums);

  print <<head;
  <!-- Forums table -->
  <table width="$config{'table_width'}" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}" align="center" border="0"><tr><td>
    <table width="100%" cellspacing="1" cellpadding="4" border="0">
      <tr bgcolor="$color_config{'table_headers'}">
        <td>&nbsp;</td>
        <td>
        <font face="verdana" size="1"><b>Forum Information</b></font>
        </td>
        <td align="center">
        <font face="verdana" size="1"><b>Posts</b></font>
        </td>
        <td align="center">
        <font face="verdana" size="1"><b>Threads</b></font>
        </td>
        <td>
        <font face="verdana" size="1"><b>Last Post</b></font>
        </td>
      </tr>
head

  
if($config{'announcements'} eq 'yes') {
  lock_open(announcements,"data/announcements.txt",'r');
  $announce = <announcements>;
  close(announcements);
  my($posted,$posted_by,$topic_title,$message) = split(/\|/,$announce);
  my $postedat = get_time($posted,"%mn %md, %ye");
  #my $newtag = get_newtag($lastvisited,$posted,0) || "&nbsp;";
  print <<end
  <tr bgcolor="$color_config{'nav_bottom'}">
        <td colspan="5">
        <font face="Verdana" size="3"><b>&#187; Announcements</b></font>
        </td>
      </tr>
      <tr>
        <td bgcolor="$color_config{'nav_top'}">&nbsp;</td>
        <td bgcolor="$color_config{'nav_top'}">
        <font face="verdana" size="2">$topic_title</font>
        </td>
        <td colspan="2" bgcolor="$color_config{'nav_top'}" align="center">
        <font face="verdana" size="2">[ <a href="$paths{'board_url'}announcements.cgi">Read</a> ]</font>
        </td>
        <td bgcolor="$color_config{'nav_bottom'}">
        <font face="verdana" size="1">
        <b>$postedat</b>
        </font>
        </td>
      </tr>
end
}
  $lastcat = 0;   $totalposts = 0;   $totalthreads = 0;
  foreach $forum (@forums) {
    my($catid,$fid,$forumname,$forumdescription,$moderators,$htmlstatus,$sccstatus,$forumstatus,$postrequirements,$posts,$threads,$lastmod,$lastposter,$forumlogo) = split(/\|/,$forum);
    get_forum_information($fid);
    $moderators = $foruminformation{$fid}{'moderators'};
    $totalposts += $posts;
    $totalthreads += $threads;
    $oklastposter = $lastposter;   $oklastposter =~ s/ /\%20/ig;

    # Do the catagory thang!
    if($catid != $lastcat) {
      print "  <tr bgcolor=\"$color_config{'nav_bottom'}\"><td colspan=\"5\">";
      print "<font face=\"Verdana\" size=\"3\"><b>&#187; $catagories{$catid}</b></td></tr>\n";
      $lastcat = $catid;
    }
    # Get some variables
    if($foruminformation{$fid}{'forumstatus'} eq 'private' &&
       $foruminformation{$fid}{'privatestatus'} eq 'hide') {
         $date = "n/a";
	 $time = "n/a";
	 $lastposterline = "n/a";
    } else {
      $date = get_time($lastmod,"%mn %md, %ye");
      $time = get_time($lastmod,"%th%hr:%mi %ap");
      $lastposterline = qq~<a href="$paths{'board_url'}profile.cgi?action=view&user=$oklastposter">$lastposter</a>~;
    }
    # Get the last visited information
    my $lastvisited = get_cookie("mb-forums");
    if(!$lastvisited) { $lastvisited = get_lastvisited($fid); } else {
      my @forumtimes = split(/\|/,$lastvisited);
      $lastvisited = $forumtimes[$fid];
    }

    my $modline = get_moderators($moderators);
    my $newtag  = get_newtag($lastvisited,$lastmod,0) || "&nbsp;";

    # Check if this is--eep!--a subcatagory
    if(substr($fid,0,1) eq 's') {  # Yep, a subcatagory
      $catagory = substr($fid,1,length($fid));
      $link = "$paths{'board_url'}subcatagory.cgi?type=subcatagory&catagory=$catagory";
    }
    else {   # A normal catagory
      $link = "$paths{'board_url'}forum.cgi?forum=$fid";
    }

    # Output the line for the forum
    print <<end_forum;
      <tr bgcolor="$color_config{'nav_top'}">
      <td align="center" width="8%">
        $newtag
      </td>
      <td width="46%" align="left">
        <font face="verdana" size="2">
        <a href="$link" style=\"text-decoration:underline\"><b>$forumname</b></a>
        </font>
        <font face="Verdana" size="2">
        <br>$forumdescription
        </font>
        <font face="verdana" size="1" color="#770000">
        <br>$modline
        </font>
      </td>
      <td align="center" width="8%">
        <font face="verdana" size="2" align="center">$posts</font>
      </td>
      <td align="center" width="8%">
        <font face="verdana" size="2" align="center">$threads</font>
      </td>
      <td width="30%" bgcolor="$color_config{'nav_bottom'}">
        <font face="verdana" size="1">
        <b>Date:</b> $date<br>
        <b>Time:</b> $time<br>
        <b>By:</b> $lastposterline
        </font>
      </td>
      </td></tr>
end_forum
  }
  board_stats();
  active_users();
  print "</table>\n";
  print "</td></tr></table>\n";
taglist();

page_footer();


sub board_stats {
  # Get some data from the "books"
  lock_open(BOOKS,"$cgi_path/data/books.inf","r");
  my @parts = <BOOKS>;
  close(BOOKS);
  my $totalusers = $parts[0];   $totalusers = strip($totalusers);
  my $lastuser   = $parts[1];   $lastuser   = strip($lastuser);
  $recordact  = $parts[2];      $recordact  = strip($recordact);
  $oklastuser = $lastuser;   $oklastuser =~ s/ /\%20/ig;
  # Compile the statsline
  $statsline = qq~$config{'board_name'} welcomes its newest member,
  <a href="$paths{'board_url'}profile.cgi?action=show&member=$oklastuser">$lastuser</a>!
    We now have <b>$totalusers</b> users.<br>There are a total of <b>$totalposts</b>
     posts in <b>$totalthreads</b> threads.~;
  print "<tr bgcolor=\"$color_config{'table_headers'}\"><td colspan=\"5\"><font face=\"Verdana\" size=\"2\"><b>&#187; Board Statistics</b><br></td></tr>\n";
  print "<tr bgcolor=\"$color_config{'nav_top'}\"><td colspan=\"5\"><font face=\"Verdana\" size=\"2\">$statsline</font></td></tr>\n";
}

sub active_users {
  my $guests,$members = 0;
  my $final = "";
  my @list = "";
  lock_open(users,"$cgi_path/data/active.txt",'r');
  while($in = <users>) {
    my($lastactivity,$user) = split(/\|/,$in);
    if((time - 900) > $lastactivity) {} else {
      $final .= $in;
    }
    if(substr($user,0,5) eq 'Guest') {
      $user = 'Guest';  $guests++;
    } else { $members++; }
    push @list,$user;
  }
  close(users);
  lock_open(users,"$cgi_path/data/active.txt",'w');
  truncate(users,0);
  seek(user,0,0);
  print users $final;
  close(users);

  # Display the table entry
  $count = @list - 1;

  # Deal with active user records ( $recordact is set in board_stats() )
  if($recordact < $count) { # A new record!
    lock_open(BOOKS,"$cgi_path/data/books.inf","rw");  seek(BOOKS,0,0);
    my @parts = <BOOKS>;
    truncate(BOOKS,0);
    seek(BOOKS,0,0);
    $parts[2] = "$count\n";
    foreach my $part (@parts) {
      if($part !~ /\n/) { $part = "$part\n"; }
      print BOOKS $part;
    }
    close(BOOKS);
    $recordact = $count;
    $record = qq~&nbsp;&nbsp;<font face="Verdana" size="1" color="red">(Record: $recordact)</font>~;
  } else {
    $record = qq~&nbsp;&nbsp;<font face="Verdana" size="1" color="red">(Record: $recordact)</font>~;
  }
  if(!$guests)  { $guests = 0; }
  if(!$members) { $members = 0; }
  print "<tr bgcolor=\"$color_config{'table_headers'}\"><td colspan=\"5\"><font face=\"Verdana\" size=\"2\"><b>&#187; There were $count users active in the last 15 minutes</b><br></td></tr>\n";
  print "<tr bgcolor=\"$color_config{'nav_top'}\"><td colspan=\"5\"><font face=\"Verdana\">\n";
  print "<font face=\"Verdana\" size=\"1\">Guests: $guests&nbsp;Users: $members $record</font><br>\n";
  if($count != 0) {
    $out = 0;
    $ct = 0;
    foreach $user (@list) {
      if(substr($user,0,5) eq 'Guest') { $user = "Guest";  }
      if($user && $user ne 'Guest') {
        if($out != 1) {
          print " <font face=\"Verdana\" size=\"1\">&#187;&nbsp;</font>";  $out = 1;
        }
        $okuser = $user;   $okuser =~ s/ /\%20/ig;
        if($members == 1 || $ct == $members) {
          print "<font face=\"verdana\" size=\"1\"><a href=\"$paths{'board_url'}profile.cgi?action=show&user=$okuser\">$user</a></font>\n";
        } else {
          print "<font face=\"verdana\" size=\"1\"><a href=\"$paths{'board_url'}profile.cgi?action=show&user=$okuser\">$user</a>, </font>\n";
        }
      }
      if($user ne 'Guest') { $ct++; }
    }
    print "</td></tr>\n";
  } else { print "&nbsp;"; }
}

sub get_moderators {
  if(!$_[0]) { return ""; }
  my $z = 0;
  my @moderators = split(/,/,$_[0]);
  my $final = "(Moderated by: ";
  foreach $mod (@moderators) {
    if(!$mod) { next; }
    $z++;
    $okmod = $mod;   $okmod =~ s/ /\%20/ig;
    if($z > 1) { $final .= ", <a href=\"$paths{'board_url'}profile.cgi?action=view&user=$okmod\">$mod</a>"; }
    else       { $final .=  "<a href=\"$paths{'board_url'}profile.cgi?action=view&user=$okmod\">$mod</a>"; }
  }
  $final .= ")";

  return $final;

}

sub buildit {
  $forum = $Pairs{'forum'};
  rebuildlist($forum);
  print "Forum $forum rebuilt.\n";
  exit;
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
