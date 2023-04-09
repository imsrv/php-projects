#!/usr/bin/perl

# This script will allow the viewing of the active user database.  The IP for
# guest users is only show to those with Administrator access.
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

require "global.cgi";

# Output the content headers
content();

# Get the information of the user who called the script
my $inf = get_cookie("mb-user");
($caller,$pass) = split(/\|/,$inf);
if($caller != $FALSE) {
  get_member($caller);
}

# Change the calling user's activity
activeusers("Viewing Active Users List");

# Clean out old entries
clean_list();

# Start the page
page_header("$config{'board_name'} > Active Users List");
board_header();
user_line();
position_tracker("","Active Users List");

# Time to display the list
print <<end;
  <!-- Active Users Table -->
  <table width="$config{'table_width'}" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}" align="center"><tr><td>
    <table width="100%" border="0" cellspacing="1" cellpadding="5">
      <tr bgcolor="$color_config{'nav_top'}">
        <td align="center" width="25%"><b><font face="Verdana" size="2">User</font></b></td>
        <td align="center" width="25%"><b><font face="Verdana" size="2">Time</font></b></td>
        <td align="center"><b><font face="Verdana" size="2">Activity</font></b></td>
      </tr>
end
foreach $entry (@entries) {
  my($time,$who,$doing) = split(/\|/,$entry);
  $formattedtime = get_time($time,"%th%hr:%mi %ap on %mo/%md/%ye");
  if(substr($who,0,5) eq 'Guest') {
    if($users{$caller}{'memberstate'} ne 'admin') {
      $who = "Guest";
    }
  }
  print <<end;
      <tr bgcolor="$color_config{'body_bgcolor'}">
        <td align="center"><b><font face="Verdana" size="1">$who</font></b></td>
        <td align="center"><b><font face="Verdana" size="1">$formattedtime</font></b></td>
        <td><font face="Verdana" size="1">$doing</font></td>
      </tr>
end
}
print <<end;
    </table>
  </td></tr></table>
end
page_footer();


# This function cleans out entries older than 15 minutes, but also compiles
# @entries with those that are newer.
sub clean_list {
  my $final = "";
  lock_open(ACTIVEUSERS,"$cgi_path/data/active.txt","r");
  while($in = <ACTIVEUSERS>) {
    $in = strip($in);
    $time = time();
    my($last,@rest) = split(/\|/,$in);
    if($time - 900 > $last) { } else {
      $final .= "$in\n";
      push @entries,$in;
    }
  }
  close(ACTIVEUSERS);
  lock_open(ACTIVEUSERS,"$cgi_path/data/active.txt","w");
  truncate(ACTIVEUSERS,0);
  seek(ACTIVEUSERS,0,0);
  print ACTIVEUSERS $final;
  close(ACTIVEUSERS);
}
