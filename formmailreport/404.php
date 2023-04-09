<?php
/**************************************************************
* Formmail Abuse Reporting - Version 1.1
*
* (C)Copyright 2002 Home-port.net, Inc. All Rights Reserved 
* By using this software you release Home-port.net, Inc. from 
* all liability relating to this product.
*
* This module is released under the GNU General Public License. 
* See: http://www.gnu.org/copyleft/gpl.html
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*
* For latest version, visit:
* http://www.home-port.net/formmail/
***************************************************************/

// You can customize your own 404 error below with simple html.
// At present this error page looks like it comes from a Cobalt RAQ.
// Note: You must use the full url for all images, links etc.!!
?>
<HTML>
<HEAD><TITLE>File Not Found</TITLE></HEAD>
<BODY BGCOLOR=#FFFFFF>
<CENTER>
<BR><BR>
<TABLE BORDER=1 WIDTH=416 CELLSPACING=0>
<TR>
<TD BGCOLOR=#6666CC>
<TABLE>
<TR>
<TD><FONT SIZE=5 COLOR=#FFFFFF><B>File Not Found</B></FONT></TD>
</TR>
</TABLE>
</TD>
</TR>
<TR>
<TD>
<BR>
<BLOCKQUOTE>
<TABLE>
<TR>
<TD><IMG SRC=<?php echo "$question"?> ALIGN=LEFT BORDER=0></TD>
<TD>
<FONT COLOR=#000000>The requested URL was not found on this server.</FONT>
</TD>
</TR>
</TABLE>
</BLOCKQUOTE>
</TD>
</TR>
</TABLE>
</CENTER>
</BODY>
</HTML>

