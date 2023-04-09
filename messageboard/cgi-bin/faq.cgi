#!/usr/bin/perl

# This script will handle displaying the FAQ page.
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
activeusers("Viewing the board FAQ");

page_header("$config{'board_name'} > Message Board FAQs");
board_header();
user_line();
position_tracker("","Message Board FAQs");
$faqs = get_faqs();

print <<end;
    <table cellpadding=0 cellspacing=0 border=0 width=$config{'table_width'} bgcolor=$color_config{'border_color'} align=center><tr><td>
      <table cellpadding=6 cellspacing=1 border=0 width=100%>
        <tr>
         <td bgcolor=$color_config{'nav_top'} align=center><font face="Verdana" size="3"><b>$config{'board_name'} FAQs</b></td>
        </tr>
        <tr>
         <td bgcolor=$color_config{'body_bgcolor'} align=left><font face="Verdana" size=2>
     <br>
        <ol>
	  $faqs
        </ol>
      </td>
    </tr>
    </table>
    </td></tr></table>
end

page_footer();

sub get_faqs {
  my $rules = "<ol>";
  lock_open(RULES,"$cgi_path/data/faqs.txt","r");
  while($in = <RULES>) {
    $in = strip($in);
    my($question,$answer) = split(/\|/,$in);
    $rules .= qq~<li><font face="Verdana" size="2"><b>Question: $question</b></font><br><font face="Verdana" size="2">$answer</font></li>~;
  }
  close(RULES);
  $rules .= "</ol><br>";

  return $rules;
}
