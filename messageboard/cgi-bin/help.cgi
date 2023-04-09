#!/usr/bin/perl

# This script will handle the help files.
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

require "global.cgi";

$topic = $Pairs{'topic'};
$topic =~ s/ /_/ig;

# Neuter possibly harmful combinations
$topic =~ s/\.\.//ig;   $topic =~ s/\///ig;    $topic =~ s/\&//ig;
$topic =~ s/\|//ig;

# Output the content headers
content();
page_header("$config{'board_name'} > Help");

if($topic && $topic ne 'emoticons' && !-e "$cgi_path/help/$topic.txt") {
  print "<b>Sorry, no such help topic ($topic) exists.</b>  Please follow only
  board-generated links.  If you are seeing this message in error, please
  contact the administration.\n";
  page_footer();

  exit;
}

if(!$topic)                  { helplist();        }
elsif($topic eq 'emoticons') { show_emoticons();  }
else                         { load_help($topic); }


sub load_help {
  my $file = "";

  if(substr($topic,0,1) eq '!') {
    my $inf = get_cookie("mb-user");
    my($user,$pass) = split(/\|/,$inf);
    if(check_account($user,$pass) == $FALSE) { $fail = $TRUE; }
    if($users{$user}{'memberstate'} ne 'admin' && $users{$user}{'memberstate'} ne 'moderator') {
      print "<b>Only administrators and board moderators have access to these help files.</b>";
      page_footer();
      exit;
    }
  }
  lock_open(HELPFILE,"$cgi_path/help/$topic.txt","r");
  while($in = <HELPFILE>) { $file .= $in; }
  close(HELPFILE);
  $file =~ s/notice\_box/help\_box/ig;

  # Output it -- evaluated
  eval($file);
}

sub show_emoticons {
  # Get a list of emoticons
  if($emoticons_done != 1) {
    opendir(emoticons,"$paths{'noncgi_path'}/emoticons/");
    @list = readdir(emoticons);
    closedir(emoticons);
    @list = grep(/gif/,@list);
    $emoticons_done = 1;
  }

  # Translate special emoticons first (ones explicitly declared)
  my $path = "$paths{'noncgi_url'}/emoticons";
  print <<end;
    <table width="80%" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'table_headers'}"><td colspan="2"><font face="Verdana" size="2"><center><b>Smilies/Emoticons Legend</b></center></font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
          <td>&nbsp;&nbsp;&nbsp;:)</td>
          <td><img src="$path/smile.gif"></td>
        </tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
          <td>&nbsp;&nbsp;&nbsp;:(</td>
          <td><img src="$path/frown.gif"></td>
        </tr>
end

  # Translate the list of emoticons
  foreach my $entry (@list) {
    my $filename  = $entry;
    my $smilename = $entry;
    $smilename =~ s/\.gif//ig;
    print <<end;
        <tr bgcolor="$color_config{'body_bgcolor'}">
          <td>&nbsp;&nbsp;&nbsp;:$smilename:</td>
          <td><img src="$path/$filename"></td>
        </tr>
end
  }
  print "    </table>\n";
  print "  </td></tr></table>\n";
  page_footer();
}

sub helplist {
  my $inf = get_cookie("mb-user");
  my($user,$pass) = split(/\|/,$inf);
  if(check_account($user,$pass) == $FALSE) { $fail = $TRUE; }

  # Generate the list of available helpfiles
  print <<end;
    <table width="80%" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'table_headers'}"><td colspan="2"><font face="Verdana" size="2"><center><b>Help Files</b></center></font></td></tr>
        <tr bgcolor="$color_config{'body_bgcolor'}"><td>
          <font face="Verdana" size="1"><p><b>Here is a list of the available help files:</b></p></font>
          <p><font face="Verdana" size="2"><a href=\"$paths{'board_url'}help.cgi?topic=emoticons">Smilies/Emoticons Legend</a></font><br><font face="Verdana" size="1">View the table of codes to type in order to get the graphical smilies to show up in your posts and private messages.</font></p>
end
  # Get all available files
  opendir(HELPFILES,"help/");
  @helpfiles = readdir(HELPFILES);
  closedir(HELPFILES);
  @helpfiles = grep(/\.txt/,@helpfiles);
  # Loop through each and print its title/link
  foreach my $file (@helpfiles) {
    if(substr($file,0,1) eq '!') { # Admin/moderator only
      if($users{$user}{'memberstate'} ne 'admin' &&
         $users{$user}{'memberstate'} eq 'moderator' || $fail == $TRUE) { next; }
    }
    lock_open(HELPFILE,"$cgi_path/help/$file","r");
    $title = <HELPFILE>;
    $description = <HELPFILE>;
    close(HELPFILE);
    eval($title);    eval($description);
    $topic = $file;   $topic =~ s/\.txt//ig;
    print "<p><font face=\"Verdana\" size=\"2\"><a href=\"$paths{'board_url'}help.cgi?topic=$topic\">$helpfiletitle</a></font><br><font face=\"Verdana\" size=\"1\">$description</font></p>\n";
  }
  # Table footers
  print <<end;
        </td></tr>
      </table>
    </td></tr></table>
end
}

sub help_box {
  local($box_title,$box_content) = @_;

    print <<end_box;
    <table cellpadding=0 cellspacing=0 border=0 width=98% bgcolor=$color_config{'border_color'} align=center><tr><td>
      <table cellpadding=6 cellspacing=1 border=0 width=100%>
        <tr>
         <td bgcolor=$color_config{'nav_top'} align=center><font face="Verdana" size="3"><b>$box_title</b></td>
        </tr>
        <tr>
         <td bgcolor=$color_config{'body_bgcolor'} align=left><font face="Verdana" size=2><br>
           <font face="Verdana" size="2">$box_content</font>
         </td>
        </tr>
      </table>
    </td></tr></table>
end_box
page_footer();  
}
