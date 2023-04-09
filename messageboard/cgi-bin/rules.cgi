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
# Revision: November 2001

require "global.cgi";

# Output the content headers
content();

# Change the activity
activeusers("Viewing the board rules");

page_header("$config{'board_name'} > Message Board Rules");
board_header();
user_line();
position_tracker("","Message Board Rules");
$rules = get_rules();

print <<end;
  <!-- Insert your message board rules here -->

    <table cellpadding=0 cellspacing=0 border=0 width=$config{'table_width'} bgcolor=$color_config{'border_color'} align=center><tr><td>
      <table cellpadding=6 cellspacing=1 border=0 width=100%>
        <tr>
         <td bgcolor=$color_config{'nav_top'} align=center><font face="Verdana" size="3"><b>$config{'board_name'} Rules</b></td>
        </tr>
        <tr>
         <td bgcolor=$color_config{'body_bgcolor'} align=left><font face="Verdana" size=2>
     <br>
        $rules
      </td>
    </tr>
    </table>
    </td></tr></table>
end

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


page_footer();
