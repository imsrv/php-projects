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

/*
Don't remove tags containing php tags like <?echo $var?> from this file! You can disable features by editing the file default_inc.php
*/?>
<BODY BGCOLOR="#FFFFFF" BACKGROUND="<?echo "$INSTALL_DIR/$bgimage"?>" text="#000000" link="#007b39" vlink="#007b39" onLoad="<?echo $js_onload?>">

<SPAN STYLE="background-color:#f00"><?echo$choose_color_error?></SPAN>
   <TABLE cellpadding="0" cellspacing="5" border="0">
	<TR>
	  <TD valign="middle" align="center" colspan="1">
	     <P STYLE="margin-top: 5px; margin-bottom: 0px; margin-left: 3px;">
		<A HREF="<?echo $exit_link?>" TARGET="_top" onMouseOver="window.status='<?echo $LEAVE_CHAT?>'; return true;">
		  <img src="<?echo "$changrafik"?>" border="0" alt="<?echo $LEAVE_CHAT?>" /></A>
	     </P>
	  </TD>
	  <TD valign="top" rowspan="2">
	  	<form name="chanchange" action="input.<?echo$FILE_EXTENSION?>" method="post">
			<FONT STYLE="font-size: 12px;">
			 <NOBR>
			   &nbsp;<?echo $select_channel?>
			   &nbsp;<?echo $help_button?>
			   <?echo $forum_button?>
			   &nbsp;<?echo $button_whoisonline?>
			  </NOBR>
			  <BR>Hi <STRONG><?echo $nick?></STRONG>! <?echo urldecode($chanthese)?>
			</FONT>
			<?echo $chan_teilnehmer?>
			<?echo $get_privat_channel?>
			<?echo $hidden_fields?>
		</form>
		<form action="input.<?echo$FILE_EXTENSION?>" name="input" method="post">
			<NOBR>
			&nbsp;<input name="chat" type="text" maxlength="<?echo$MAX_LINE_LENGTH?>" size="53" STYLE="font-size: 10px;font-family:MONOSPACE;" />
			<FONT STYLE="font-size: 12px;">
			  <input type="submit" value="<?echo $SAY_IT?>!" STYLE="font-size: 10px;" onClick="return checkSubmit()" />
			</FONT>
			<BR />
			<TABLE cellpadding="0" cellspacing="0" border="0" STYLE="margin-left:3px;">
				<TR VALIGN="top">
				   <TD BGCOLOR="#7093DB" VALIGN="middle">
				     <FONT STYLE="font-size: 12px;">
     					<?echo $radio_say_to?><BR />
     					<?echo $radio_wisper_to?>
				     </FONT>
				   </TD>
				   <TD BGCOLOR="#7093DB" VALIGN="middle">
				     <FONT STYLE="font-size: 10px;margin-left:3px;margin-right:3px;">
					<?echo $select_user?>
				     </FONT><BR />
				   </TD><TD>&nbsp;</TD>
				   <TD BGCOLOR="#66B886">
				     <FONT STYLE="font-size: 12px;">
					<?echo $messages_button?>
					<?echo $ignore_invite_button?>
					<?echo $button_notify?>
				     </FONT>
				     <P STYLE="margin-top: 1px; margin-bottom: 1px;">
				       <?echo $button_twaddle_filter?>
				       <?echo $button_status_filter?>
				     </P>
				   </TD>
				</TR>
			</TABLE>
			</NOBR>
	  </TD>
	</TR>
	<TR>
	  <TD VALIGN="top" align="center">
		<P STYLE="margin-top: 5px; margin-bottom: 3px; margin-left: 3px; background-color: <?=$chanbgcolor?>">
			<?echo $change_color_link?>
		</P>
		
		<FONT STYLE="font-size: 10px;">
		  <?echo $switch_auto_scrolling?>
		</FONT>
   		<?echo $chan_teilnehmer?>
		<?echo $get_privat_channel?>
		<?echo $hidden_fields?>
		<?echo $hidden_fields_chat?>
		</form>
	  </TD>
	</TR>
   </TABLE>
</BODY>
