<html>
  <head>
    <title><?echo $CHATNAME?></title>
      <meta name="distribution" content="global">
      <meta NAME="author" CONTENT="Michael Oertel; michael@ortelius.de">
          <script type="text/javascript">
            <!--
            //if(top.frames.length > 0)
            //top.location.href=self.location;
            if(parent.frames.length > 0)
            parent.location.href=self.location;
            //-->
          </script>
  </head>
  <body bgcolor="#FFFFFF" background="<?echo $BG_IMAGE?>">
      <div align="center">
        <table cellSpacing="0" cellPadding="0" border="0" width="80%">
          <tr>
            <td>
      <!-- start table -->
        <table cellSpacing="0" cellPadding="1" border="0">
          <tr>
            <td width="100%" bgColor=#468e31>
              <TABLE cellSpacing="0" cellPadding="4" border="0">
                <tr>
                  <td background="images/bg.gif" align="center">
                    <font size="+1">
                    <b>
                    <?if ($PHPOPENCHAT_USER) {
                        echo "".$REMOTE_USER.", ".$hello_message."";
                    }else{echo "Hallo!";}?>
                    </b>
                    </font>
                  </td>
                </tr>
                <tr>
                  <td bgColor="#ffffff" align="center">
                    <img src="images/leer.gif" alt="" width="480" height="1" border="0"><BR>
                        <form action="index.<?=$FILE_EXTENSION?>" method="post">
                          <?=$fehler?>
                          <table border="0">
                            <tr>
                              <td><?echo $NICK_NAME?>:</td>
                              <td><input name="nick" type="text" SIZE="<?echo$MAX_NICK_LENGTH?>" MAXLENGTH="<?echo$MAX_NICK_LENGTH?>" VALUE="<?echo $PHPOPENCHAT_USER?>" STYLE="font-size: 10px;"></td>
                            </tr>
                            <tr>
                              <td><?echo $PASSWORD?>:</td>
                              <td><input type="password" name="password" value="" SIZE="8" MAXLENGTH="8" STYLE="font-size: 10px;">
                              </td>
                            </tr>
                            <tr><td>&nbsp;</td>
                              <td><?echo$entry_channels?></td>
                            </tr>
                            <tr><td>&nbsp;</td>
                              <td>
                                <noscript>
                                  <font color="#ff0000"><?=$NO_SCRIPT?></font>
                                </noscript>
                                <input name="action" type="button" onClick="submit();" value="<?echo $GO?>" STYLE="font-size: 10px;">
                              </td>
                            </tr>
                          </table>
                          <a href="register.<?=$FILE_EXTENSION?>"><?=$REGISTER_NICK?></a><br>
                            <input type=hidden name="<?=session_name()?>" value="<?=session_id()?>">
                        </form>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <!-- end table -->
      </td>
      <td>&nbsp;</td>
      <td valign="top" align="right">
              <!-- start table -->
              <table width=180 border="0" cellspacing="0" cellpadding="0" bgcolor="#000000">
                <tr>
                  <td>
                    <table cellspacing="0" cellpadding="1" width="100%" border="0">
                      <TR>
                        <TD width="100%" bgColor=#468e31>
                          <TABLE cellSpacing=0 cellPadding=4 width="100%" border=0>
                            <TR>
                              <TD style="font-size:12px;" background=images/bg.gif><font size="+1"><b>Statistics</b></font></TD>
                            </TR>
                            <TR>
                              <TD class=tablebody bgColor=#ffffff>
                                <?echo $NUM_USER?>: <STRONG><?echo $num_reg_chatters?></STRONG><BR>
                                <?echo $LOCAL_TIME?>: <STRONG><?echo date(" H:i",time());?>h</STRONG><BR>
                                <?echo $CHATTERS_ONLINE?>:  <STRONG><?=$online_users?> </STRONG>
                              </TD>
                            </TR>
                          </TABLE>
                        </TD>
                      </TR>
                    </TABLE>
                    <img src="images/shadow_kl.gif" width="180" height="13" alt="" border="0"></td>
                </tr>
              </table>
              <!-- end table -->
      </td>
      </tr>
      <tr><td colspan="3">&nbsp;</td></tr>
      <tr><td colspan="3">
            <?echo $online_table?>
          </td>
      </tr>
      <tr><td colspan="3">&nbsp;</td></tr>
      <tr>
      <td colspan="3">
        <p>
        
        <table cellspacing="0" cellpadding="0" width="100%" border="0" style="margin-top:0px; margin-left:5px;">
          <tr>
            <td width="100%" bgcolor="#468e31"><img height="1" src="images/leer.gif" width="1"></td>
          </tr>
          <tr>
            <td width="100%" bgcolor="#c5dd80"><img height="1" src="images/leer.gif" width="1"></td>
          </tr>
        </table>

        <table cellspacing="0" cellpadding="1" width="100%" bgcolor="#468e31" background="images/bg.gif" border="0" style="margin-top:0px; margin-left:5px;">
          <tr>
            <td>&nbsp;&nbsp;
              <span style="font-size:11px;">
                <a href="<?echo $INSTALL_DIR?>/user_profile.<?echo $FILE_EXTENSION?>"><?echo $MY_PROFILE?></a>&nbsp;<b>|</b>&nbsp;<a href="<?echo $INSTALL_DIR?>/toplist.<?echo $FILE_EXTENSION?>"><?echo $TOPLIST?></a>&nbsp;<b>|</b>&nbsp;<a href="<?echo $INSTALL_DIR?>/sendpwd.<?echo $FILE_EXTENSION?>"><?echo $FORGOT_PWD?></a>
              </span></td>
          </tr>
        </table>
      <!--/table-->
      
      <table cellspacing="0" cellpadding="0" width="100%" border="0" style="margin-top:0px; margin-left:5px;">
        <tr>
          <td width="100%" bgcolor="#468e31"><img height="1" src="images/leer.gif" width="1"></td>
        </tr>
        <tr>
          <td width="100%" bgcolor="#c5dd80"><img height="1" src="images/leer.gif" width="1"></td>
        </tr>
      </table>
    </p>
      </td>
      </tr>
      </table>
      </div>
      <div align="center">
        <hr size="1" noshade="noshade">
        <A HREF="http://www.ortelius.de/phpopenchat/" target="_blank"><IMG SRC="<?echo $INSTALL_DIR?>/images/phpopenchat.gif" border="0"></A>
      </div>
  </body>
</html>