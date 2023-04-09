<?php
/*

  File: include.php3
  
  E*Reminders: Copyright 1999 Benjamin Suto <ben@amvalue.com>
 
  You should have received a copy of the GNU Public License along
  with this package;  if not, write to the Free Software Foundation, Inc.
  59 Temple Palace - Suite 330, Boston, MA 02111-1307, USA.

*/

function msg_box($heading, $message, $messageclr) {
  echo "
<CENTER>
<TABLE BGCOLOR=#CCCCCC BORDER=0 CELLSPACING=0 CELLPADDING=5 WIDTH=75%>
<TR>
<TD COLSPAN=3 BGCOLOR=#6677DD>
<CENTER>
<FONT SIZE=+1 FACE='arial, helvetica' COLOR=#FFFFFF>
$heading</FONT></CENTER>
</TD>

<TR>
<TD><FONT FACE='arial,helvetica' COLOR=$messageclr>
$message</FONT>
</TD>
<TR>
<TD>
<CENTER>
<FONT COLOR=#000000>
<A HREF='help.html'>Help/About</A><BR>
<A HREF='adminoptions.html'>Account Options</A><BR>
<A HREF='index.php3'>Home</A>
</CENTER>
</TD>
</TABLE>
</CENTER>
";
}


?>

