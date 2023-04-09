<?php
/* Copyright (C) 2000 Paulo Assis <paulo@coral.srv.br>
 
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.  */

include("phpdbform/phpdbform_core.php");
//if( AUTHDBFORM == "cookies" ) {
    setcookie("AuthName","",time()+3600);
    setcookie("AuthPasswd","",time()+3600);
//} else {
    //unset($PHP_AUTH_USER);
    //if(!isset($PHP_AUTH_USER)) {
    //  Header("WWW-authenticate: basic realm=\"restricted area\"");
    //    Header("HTTP/1.0 401 Unauthorized");
    //    Header("Location:menu.php3" );
    //    echo MSG11;
    //    exit;
    //} else {
    //    Header("Location:menu.php3" );
    //}
//}
$table1 = "width='60%'";

print_header("login");
?>
<form method="post" action="menu.php">
<table>
<tr>
<td><span class="text"><?php echo MSG_NAME; ?></span><br><input type="text" name="name"></td>
</tr>
<tr>
<td><span class="text"><?php echo MSG_PASSWORD; ?></span><br><input type="password" name="passwd"></td>
</tr>
<tr>
<td><input type="submit" class="bt" value="Login"></td>
</tr>
</table>
</form>
<?php
	print_logos(false,"<a href='http://sourceforge.net'>SourceForge</a>");
	print_tail();
?>
