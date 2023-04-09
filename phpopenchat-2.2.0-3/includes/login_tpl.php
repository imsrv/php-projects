<?
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
?>
<HTML>
<HEAD>
 <TITLE><?echo$CHATNAME?></TITLE>
 <script type="text/javascript">
   <!--
   //if(top.frames.length > 0)
   //top.location.href=self.location;
   if(parent.frames.length > 0)
     parent.location.href='index.<?=$FILE_EXTENSION?>';
   //-->
 </script>
</HEAD>
<body bgcolor="#FFFFFF" BACKGROUND="<?echo$BACKGROUNDIMAGE?>" text="#000000" link="#007b39" vlink="#007b39">
  <TABLE BORDER=0 cellpadding=0 cellspacing=0>
	<TR>
		<TD valign="top">
		 <A HREF="<?echo $CHATSERVERNAME?>/" target="_top">
		  <IMG SRC="<?echo $LOGO?>" ALT="[<?echo $NO_PARTICIPATE?>]" BORDER=0 /></A><P>
		 <FONT COLOR="#007b39" SIZE="-1">
		  <A HREF="<?echo $CHATSERVERNAME?>/" TARGET="_top">[<?echo $NO_PARTICIPATE?>]</A>
		 </FONT>
		</TD>
  		<TD align="right">
		 <form name="login" action="input.<?echo$FILE_EXTENSION?>" method="post">
  		  <P style="margin-top:0px; margin-bottom:0px; font-size:10px; font-family:arial,helvetica,sans-serif;"><?echo $fehler?><br />
  		  <?echo $NICK_NAME?>:
  		  <input name="nick" type="text" SIZE="<?echo$MAX_NICK_LENGTH?>" MAXLENGTH="<?echo$MAX_NICK_LENGTH?>" VALUE="<?echo $PHPOPENCHAT_USER?>" STYLE="font-size: 10px;"> <?echo $PASSWORD?>: <input type="password" name="password" value="" SIZE="8" MAXLENGTH="8" STYLE="font-size: 10px;">
		  <?echo $entry_channels?>
		  <br />
		  <P style="margin-top:0px; margin-bottom:0px; font-size:10px; font-family:arial,helvetica,sans-serif;">
		  
  		  <input name="action" type="submit" value="<?echo $GO?>" STYLE="font-size: 10px;">
  		  <P style="margin-top:0px; margin-bottom:0px; font-size:10px; font-family:arial,helvetica,sans-serif;">
  		   <?if($ENABLE_SESSION){?>
		  <input type="hidden" name="<?echo session_name()?>" value="<?echo session_id()?>">
		  <?}?>
  		  <input type="hidden" name="pictureURL" value="">
		  </P></P></P>
  		 </form>
		</TD>
	</TR> 
 </TABLE>
</BODY>
</HTML>
