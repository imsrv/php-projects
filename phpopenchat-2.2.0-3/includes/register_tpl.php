<HTML>
    <HEAD>
      <TITLE><?=$REGISTER_TITLE?></TITLE>
    </HEAD>
    <body bgcolor="#FFFFFF" BACKGROUND="<?echo$BACKGROUNDIMAGE?>" text="#000000" link="#007b39" vlink="#007b39">
      <div align="center">

        <table cellSpacing="0" cellPadding="0" border="0" width="80%">
          <tr>
            <td>
              <!-- start table -->


              <table cellSpacing="0" cellPadding="1" border="0">
                <tr>
                  <td width="100%" bgColor="#468e31">


                    <TABLE cellSpacing="0" cellPadding="4" border="0">
                      <tr>
                        <td background="images/bg.gif" align="center">
                          <font size="+1">
                            <b><?=$REGISTER_TITLE?>
                            </b>
                          </font>
                        </td>
                      </tr>
                      <tr>
                        <td bgColor="#ffffff" align="center">
                          <img src="images/leer.gif" alt="" width="480" height="1" border="0"><BR>
                              <font face="arial,helvetica,sans-serif" size="4" color="#000000"></font><br><br>


                                  <table border=0 cellpadding=0 cellspacing=1>
                                    <form name="register" action="register.<?echo$FILE_EXTENSION?>" method="post"> 
                                      <tr>
                                        <td></td>
                                        <td>
                                          <font face="arial,helvetica,sans-serif" size="2" color="#ff0000">
                                            <?=$fehler?>
                                          </font>
                                        </td>
                                      </tr><tr>
                                        <td align="right" valign="middle"><font face="arial,helvetica,sans-serif" size="2"><?echo $NICK_NAME?>:&nbsp;</font></td>
                                        <td align="left" valign="middle"><input name="nick" type="text" SIZE="<?echo$MAX_NICK_LENGTH?>" MAXLENGTH="<?echo$MAX_NICK_LENGTH?>"><?echo$entry_channels?></td>
                                      </tr><tr>
                                        <td align="right" valign="middle"><font face="arial,helvetica,sans-serif" size="2"><?echo $PASSWORD?>:&nbsp;</font></td>
                                        <td align="left" valign="middle"><input type="password" name="password" value="" SIZE="10" MAXLENGTH="8"></td>
                                      </tr><tr>
                                        <td><font face="arial,helvetica,sans-serif" size="2"><?echo $PASSWORD?> (<?echo $AGAIN?>):&nbsp;</font></td>
                                        <td><input type="password" name="password2" value="" SIZE="10" MAXLENGTH="8"></td>
                                      </tr><tr>
                                        <td align="right" valign="middle"><font face="arial,helvetica,sans-serif" size="2"><?echo $MAIL_ADDRESS?>:&nbsp;</font></td>
                                        <td><input name="user_email" type="text" value=""></td>
                                      </tr><tr>
                                        <td>&nbsp;</td>
                                      </tr><tr>
                                        <td></td><td><input name="register" type="submit" value="<?=$REGISTER_SUBMIT?>"></td>
                                      </tr>
                                      <input type="hidden" name="channel" value="">
                                        <input type="hidden" name="pictureURL" value="">
                                    </form> 
                                  </table>
                                  <?=$success?>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              <!-- end table -->
              
            </td>
          </tr>
        </table>
              
      </div>
    </BODY>
</HTML>