<?//-*- C -*-
/*   ********************************************************************   **
**   Copyright (C) 1995-2000 Michael Oertel                                 **
**   Copyright (C) 2000-     PHPOpenChat Development Team                   **
**   http://www.ortelius.de/phpopenchat/                                    **
**                                                                          **
**   This program is free software. You can redistribute it and/or modify   **
**   it under the terms of the PHPOpenChat License Version 1.0              **
**                                                                          **
**   This program is distributed in the hope that it will be useful,        **
**   but WITHOUT ANY WARRANTY, without even the implied warranty of         **
**   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                   **
**                                                                          **
**   You should have received a copy of the PHPOpenChat License             **
**   along with this program.                                               **
**   ********************************************************************   */

include("defaults_inc.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!--- A1 WebSite Developers UK Ltd of http://www.wsd.co.uk copyright 1998, 1999, 2000 All rights Reserved --->
<html>
<head>
	<title><?=$CHANGE_COLOR?></title>
</head>

<body bgcolor="#284628" text="#ffffff"leftmargin="15" topmargin="15" marginheight="15" marginwidth="15" onLoad="window-focus();">

      
          
        <div align="center"> 
          <table border="0"  cellspacing="1" cellpadding="1" name="clr">
            <tr>
			

<script language="JavaScript"><!-- hide
build();
function send_me(){
	
	var color;
		color = document.form.change_color.value;
		color = color.replace(/#/,"%23");
	
		<?if($ENABLE_SESSION){?>
			 opener.parent.input.location.href='<? echo "$INSTALL_DIR/input.$FILE_EXTENSION?channel=$channel&privat=$privat&no_gruentxt=$no_gruentxt&".session_name()."=".session_id()."&scroll=$scroll&scroll_old=$scroll&say_to_nick=".urlencode($say_to_nick)."&sprechen=say_to_nick_zu&color=";?>'+color+'<?echo"&change_color=";?>'+color;
		<?}else{?>		
			 opener.parent.input.location.href='<? echo "$INSTALL_DIR/input.$FILE_EXTENSION?channel=$channel&amp;privat=$privat&amp;no_gruentxt=$no_gruentxt&amp;Nick=".urlencode($nick)."&amp;pruef=$pruef&amp;scroll=$scroll&amp;scroll_old=$scroll&amp;say_to_nick=".urlencode($say_to_nick)."&amp;sprechen=say_to_nick_zu&amp;color=";?>'+color+'<?echo"&amp;change_color=";?>'+color;
		<?}?>
		window.close();
		return false;
	

}
function cl(col){
	document.form.change_color.value='#'+col;
}
function build(){
	var d="0369CF";
	var x=y=z=0;
	var i=1;
	var c,s1,s2;
	while (i<216) {
		c=d.substring(x,x+1)+d.substring(x,x+1)+d.substring(y,y+1)+d.substring(y,y+1)+d.substring(z,z+1)+d.substring(z,z+1);
		if(i %12 == 0 && i!=0){
			s1="<td bgcolor='#"+c+"'><a href=\"#\" onClick='cl(\""+c+"\");' alt=\"#"+c+"\"><img src='images/dot_clear.gif' border='0' width='8' height='8' ></a></td>";
			s2="</tr><tr>";
		}else{
			s1="<td bgcolor='#"+c+"'><a href=\"javascript:void(0);\" onClick='cl(\""+c+"\");' alt=\"#"+c+"\"><img src=images/dot_clear.gif border=0 width=8 height=8></a></td>";
			s2="</td>";
		}
		document.writeln(s1+s2);
		x++;
		i++;
		if(x==6){
			x=0;
			y++;
		}	
		if(y==6){
			y=0;
			z++;
		}
	}
}
// -->
</script>
</td></tr>
          </table>
   <form TARGET="input" ACTION="<?echo "$INSTALL_DIR/input.$FILE_EXTENSION";?>" name="form" onSubmit="return send_me()">
<?=$ENTER_YOUR_CODE?><br><input name="change_color" value="#" size=7 maxlength="7"><br>
<input type=submit value="<?=$GO?>">

<INPUT NAME="channel" TYPE="hidden" VALUE="<?=$channel?>">
<INPUT NAME="privat" TYPE="hidden" VALUE="<?=$privat?>">
<INPUT NAME="no_gruentxt" TYPE="hidden" VALUE="<?=$no_gruentxt?>">
<?if($ENABLE_SESSION){?>
  <INPUT NAME="<?=session_name()?>" TYPE="hidden" VALUE="<?=session_id()?>">
<?}else{?>
  <INPUT NAME="Nick" TYPE="hidden" VALUE="<?=$nick?>">
  <INPUT NAME="pruef" TYPE="hidden" VALUE="<?=$pruef?>">
<?}?>

<INPUT NAME="scroll" TYPE="hidden" VALUE="<?=$scroll?>">
<INPUT NAME="is_vip" TYPE="hidden" VALUE="<?=$is_vip?>">
<INPUT NAME="is_moderator" TYPE="hidden" VALUE="<?=$is_moderator?>">
<INPUT NAME="say_to_nick" TYPE="hidden" VALUE="<?=$say_to_nick?>">
<INPUT NAME="speaking" TYPE="hidden" VALUE="<?=$says_to_nick?>">
</form>   


</body>
</html>
