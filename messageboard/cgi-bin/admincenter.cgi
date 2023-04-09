#!/usr/bin/perl

# This script will provide those users with access, the main form for the
# Administator Control Panel.
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
require 'admin.lib';

# Check the cookie
$inf = get_cookie("mb-admin");
($cookieuser,$cookiepassword) = split(/\|/,$inf);

if(!$cookieuser) {   # Give them a chance to log in the admin cookie
  content();
  page_header("$config{'board_name'} > Administrator Control Panel");
  admin_login("$paths{'board_url'}admincenter.cgi");
  exit;
}

if(check_account($cookieuser,$cookiepassword) == $FALSE) {
  redirect_die("We're sorry, but your username/password combination was
  invalid or you are not an administrator on this message board.","","4","black","You Do Not Have Access");
}

# Output the content headers
content();

my $action = $Pairs{'action'};
if($action eq 'home') { homeinfo(); }
elsif($action eq 'nav')  { navigation_frame(); }
else                  { setframes(); }

page_footer();



sub setframes  { admin_header(); print "</body></html>"; exit; }

sub homeinfo {
  page_header("$config{'board_name'} > Administrator Control Panel");
  print <<end;
    <font face="Verdana" size="2">
      <p><b>Welcome to the Administrator Control Panel</b></p>
      
      Here you will find miscellanious functions to control the message board configuration and
      the user database.  Please select the desired subsection from the navigation on the left-hand
      side of your screen to continue on your way.
    </font>
end
}

# Set up the navigation frame of the Admin CP
sub navigation_frame {
  page_header("$config{'board_name'} > Administrator Control Panel");
  
  # New, collapsible sections
  my $expand = $Pairs{'expand'};
  $output = qq~<table width="100%" align="center" border="0"><tr><td align="center" bgcolor="$color_config{'nav_top'}"><a href="$paths{'board_url'}admincenter.cgi?action=nav&expand=1"><font face="Verdana" size="2" color="#000077"><b>User / Group Management</b></font></a></td></tr></table>~;
  if($expand == 1) {
    $output .= qq~
      <a href="$paths{'board_url'}usereditor.cgi" target="main"><font face="Verdana" size="2">User Editor</font></a><br>
      <a href="$paths{'board_url'}groupmanage.cgi?action=add" target="main"><font face="Verdana" size="2">Add Group</font></a><br>
      <a href="$paths{'board_url'}groupmanage.cgi" target="main"><font face="Verdana" size="2">Edit/Delete Group</font></a><br>
      <a href="$paths{'board_url'}banmanage.cgi?type=email" target="main"><font face="Verdana" size="2">Add/Remove Email Bans</font></a><br>
      <a href="$paths{'board_url'}banmanage.cgi?type=ip" target="main"><font face="Verdana" size="2">Add/Remove IP Bans</font></a><br>
      <a href="$paths{'board_url'}config.cgi?action=restrict" target="main"><font face="Verdana" size="2">Manage Restricted Usernames</font></a><br>
      <a href="$paths{'board_url'}queue.cgi?action=viewusers" target="main"><font face="Verdana" size="2">View User Approval Queue</font></a><br>
    ~;
  }

 $output .= qq~<p><table width="100%" align="center" border="0"><tr><td align="center" bgcolor="$color_config{'nav_top'}"><a href="$paths{'board_url'}admincenter.cgi?action=nav&expand=2"><font face="Verdana" size="2" color="#000077"><b>Board Configuration</b></font></a></td></tr></table>~;
 if($expand == 2) {
   $output .= qq~
     <a href="$paths{'board_url'}config.cgi?action=board" target="main"><font face="Verdana" size="2">Board Configurations</font></a><br>
     <a href="$paths{'board_url'}config.cgi?action=color" target="main"><font face="Verdana" size="2">Color Configurations</font></a><br>
     <a href="$paths{'board_url'}config.cgi?action=path" target="main"><font face="Verdana" size="2">Path Configurations</font></a><br></p>
     <a href="$paths{'board_url'}config.cgi?action=templateform" target="main"><font face="Verdana" size="2">Edit Board Template</font></a><br></p>
   ~;
 }

  $output .= qq~<p><table width="100%" align="center" border="0"><tr><td align="center" bgcolor="$color_config{'nav_top'}"><a href="$paths{'board_url'}admincenter.cgi?action=nav&expand=3"><font face="Verdana" size="2" color="#000077"><b>Notices Configuration</b></font></a></td></tr></table>~;
  if($expand == 3) {
    $output .= qq~
      <a href="$paths{'board_url'}fileedit.cgi?action=addrules" target="main"><font face="Verdana" size="2">Add Rules</font></a><br>
      <a href="$paths{'board_url'}fileedit.cgi?action=editrules" target="main"><font face="Verdana" size="2">Edit/Delete Rules</font></a><br>
      <a href="$paths{'board_url'}fileedit.cgi?action=addfaqs" target="main"><font face="Verdana" size="2">Add FAQ Entries</font></a><br>
      <a href="$paths{'board_url'}fileedit.cgi?action=editfaqs" target="main"><font face="Verdana" size="2">Edit/Delete FAQ Entries</font></a><br></p>
    ~;
  }

  $output .= qq~<p><table width="100%" align="center" border="0"><tr><td align="center" bgcolor="$color_config{'nav_top'}"><a href="$paths{'board_url'}admincenter.cgi?action=nav&expand=4"><font face="Verdana" size="2" color="#000077"><b>Category / Forum Management</b></font></a></td></tr></table>~;
  if($expand == 4) {
    $output .= qq~
      <a href="$paths{'board_url'}categorymanage.cgi?action=add" target="main"><font face="Verdana" size="2">Add Category</font></a><br>
      <a href="$paths{'board_url'}categorymanage.cgi" target="main"><font face="Verdana" size="2">Edit/Delete Category</font></a><br>
      <a href="$paths{'board_url'}categorymanage.cgi?action=reorder" target="main"><font face="Verdana" size="2">Reorder Categories</font></a><br>
      <a href="$paths{'board_url'}forummanage.cgi?action=add" target="main"><font face="Verdana" size="2">Add Forum</font></a><br>
      <a href="$paths{'board_url'}forummanage.cgi" target="main"><font face="Verdana" size="2">Edit/Delete Forum</font></a><br>
    ~;
  }
  
  # Attach the rest
  $output .= qq~
      <p>&nbsp;<br></p>
      <p><a href="$paths{'board_url'}scarecrow.cgi" target="_blank"><font face="Verdana" size="2">Visit your board</font></a><br>
      <a href="http://scarecrow.sourceforge.net" target="_blank"><font face="Verdana" size="2">Visit the ScareCrow Homepage</font></a><br></p>
      
      <p><font face="Verdana" size="1">Click on a category name to expand the options.</font></p>
      </BODY>
    </HTML>
  ~;
  
  # Output the data
  print $output;

  exit;  # We do NOT want a page footer on this one.
}
