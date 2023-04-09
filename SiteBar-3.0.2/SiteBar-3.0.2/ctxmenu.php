<?
/******************************************************************************
 *  SiteBar 3 - The Bookmark Server for Personal and Team Use.                *
 *  Copyright (C) 2003  Ondrej Brablc <sitebar@brablc.com>                    *
 *                                                                            *
 *  This program is free software; you can redistribute it and/or modify      *
 *  it under the terms of the GNU General Public License as published by      *
 *  the Free Software Foundation; either version 2 of the License, or         *
 *  (at your option) any later version.                                       *
 *                                                                            *
 *  This program is distributed in the hope that it will be useful,           *
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of            *
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             *
 *  GNU General Public License for more details.                              *
 *                                                                            *
 *  You should have received a copy of the GNU General Public License         *
 *  along with this program; if not, write to the Free Software               *
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA *
 ******************************************************************************/

/******************************************************************************
 This file is called when selecting "Add Link to SiteBar" or
 "Add Page to SiteBar" menu item in context menu of Internet Explorer.

 Page code by Alexis ISAAC <moi@alexisisaac.net>, link code by Ondrej Brablc
 ******************************************************************************/

if (!isset($_GET)  && isset($HTTP_GET_VARS))  $_GET  = $HTTP_GET_VARS;
?>
<SCRIPT LANGUAGE="JavaScript" defer>
<?



if ($_GET['add'] == 'page') :
?>
    var parentwin = external.menuArguments;
    var tit = parentwin.document.title;
    var url = parentwin.location.href;
<?
else :
?>
    var obj = external.menuArguments.event.srcElement;
    var tit = obj.innerHTML;
    var url = obj.getAttribute('href');
<?
endif;
?>
    window.open('command.php?command=Add%20Link&name='+escape(tit)+
        '&url='+escape(url),'sitebar_gCmdWin',
        'resizable=yes,dependent=yes,width=210,height=280,top=200,left=300,titlebar=yes,scrollbars=yes');
    close();
</SCRIPT>
