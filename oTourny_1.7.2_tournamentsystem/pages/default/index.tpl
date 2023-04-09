<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>{SITE_NAME}</title>
  <link href="{LOCATION_CSS}" rel="stylesheet" type="text/css">
 </head>
<body marginwidth="0" marginheight="0">
<!--Scripts-->
 <script type="text/javascript" language="JavaScript" src="scripts/menu.js"></script>
 <script type="text/javascript" language="JavaScript">
  {MENU}
 </script>
<!--/Scripts-->
<div align="center">
<!--DWLayoutTable-->
  <table width="753" height="156" border="0" cellpadding="0" cellspacing="0" style="border: .4px solid gray;">
    <tr>
      <td height="155" colspan="3" valign="top">
       <table width="100%" height="131" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="753" height="131" cols="2"><img src="{LOCATION_IMAGES}tg7.jpg" width="753" height="131"></td>
          <td height="131" background="{LOCATION_IMAGES}header-end.jpg"></td>
        </tr>
       </table>
       <table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
        <tr>
         <td>
          <div id="Layer1" style="position: relative; z-index: 1; overflow: visible; visibility: visible; top:-5; background-color:gray; background-image: url({LOCATION_IMAGES}footerstretch.jpg); layer-background-image: url({LOCATION_IMAGES}footerstretch.jpg); border: 1px none #000000;">
           <script language="JavaScript">
            var menu = new COOLjsMenu("MainMenu", MENU_ITEMS);
           </script>
          </div>
         </td>
        </tr>
       </table>      </td>
    </tr>
     <tr>
      <td height="18" colspan="3" valign="top">
       <table width="100%" height="18" border="0" cellpadding="0" cellspacing="0" background="{LOCATION_IMAGES}top-chrome-filler.jpg">
         <tr>
           <td width="210">&nbsp;</td>
           <td>
            <template name="WND_LOGIN_IMAGE">
             <div align="left" valign="top"><img src="{LOCATION_IMAGES}2-long.jpg">
                </template name="WND_LOGIN_IMAGE">
             </div></td>
          </tr>
       </table>
      </td>
     </tr>
    <td width="175"><template name="WND_LOGIN">
    <tr>
      <td width="175" height="29" valign="top" bgcolor="#E8E8E8"><!--DWLayoutEmptyCell-->&nbsp;</td>
      <td colspan="2" valign="top" bgcolor="#E8E8E8">
        <table width="541" height="28" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="28" colspan="3" valign="top" bgcolor="#E8E8E8">
              <table class="login">
                <tr>
                  <form name="login_form" method="POST">
                    <td width="65"> Username:</td>
                    <td width="136">
                      <input type="text" maxlength="65535" name="{FIELD_TAB_NAME}" value="{FIELD_TAB_NAME_VALUE}" style="height:20px; width:120px;">
                    </td>
                    <td width="57">Password:</td>
                    <td width="130"><input type="password" maxlength="65535" size="16" name="{FIELD_TAB_PASS}">
                    </td>
                    <td width="143">
                      <input type="image" src="{LOCATION_IMAGES}login.jpg" name="submit">
                    </td>
                  </form>
                </tr>
            </table></td>
          </tr>
        </table>
    </template name="WND_LOGIN">
    <template name="WND_LOGIN_ERROR">
     Login Failed <span class="error"><b>WARNING:</b> Your Name and/or Password was incorrect. Please try again.</span>
    </template name="WND_LOGIN_ERROR">
    <tr bgcolor="#A3A3A3"> <!--CENTER AREA-->
      <td width="175" height="431" valign="top" bgcolor="#B6B6B6">
        <table width="175" height="100%" border="0" cellpadding="0" cellspacing="0" background="{LOCATION_IMAGES}fff.jpg">
          <!--DWLayoutTable-->
          <td width="175"><template name="WND_TEAMS">
          <tr>
            <td height="57" colspan="3" valign="top" background="{LOCATION_IMAGES}fff.jpg">
              <table width="175" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="100%" valign="top"><img src="{LOCATION_IMAGES}menu-left-1.jpg" width="175" height="18"></td>
                </tr>
                <tr>
                  <td valign="top" height="100%" style="padding-left:10px; padding-right:10px; padding-top:5px;"> </td>
                </tr>
                <tr>
                  <td height="4"></td>
                </tr>
              </table>
              <template name="WND_LINK_ACON"> <a href="?page=admin">&middot; Admin Console</a> <br>
              </template name="WND_LINK_ACON"> <a href="?page=logout">&middot; Log Out</a>
              <center>
                <a href="{SITE_URL}/forum/viewforum.php?f=3">Report a Bug!</a>
              </center>
              <template name="WND_TEAMS_HEADER">
              <table width="175" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td><img src="{LOCATION_IMAGES}teams.jpg" width="175" height="18"></td>
                </tr>
                <template name="WND_TEAMS_ROW">
				<tr>
				  <td>&middot; {WND_TEAM_NAME}</td>
				</tr>
				</template name="WND_TEAMS_ROW">
              </table>
              <br>
            </template name="WND_TEAMS_HEADER"> </td>
          </tr>
          </template name="WND_TEAMS">
          <tr>
            <td colspan="3" valign="top"> <template name="WND_ATOURNY">
              <table cellspacing="0" cellpadding="0" width="175">
                <tr>
                  <td width="175"><img src="{LOCATION_IMAGES}atourny.jpg" width="175" height="18"></td>
                </tr>
                <tr>
                  <td width="175">
                    <table cellspacing="0" cellpadding="0" border="0" width="175">
                      <tr>
                        <td width="175">
                          <template name="WND_ATOURNY_FOUNDER">
                           <a href="?page=admin&cmd=tourny&tournyid={WND_TOURNY_ID}">&middot; Founder: {WND_ATOURNY_NAME}</a><br>
                          </template name="WND_ATOURNY_FOUNDER">
                          <template name="WND_ATOURNY_ADMIN">
                           <a href="?page=tourny&tournyid={WND_TOURNY_ID}&cmd=matchs">&middot; {WND_ATOURNY_NAME}</a><br>
                          </template name="WND_ATOURNY_ADMIN">
                        </td>
                      </tr>
                  </table></td>
                </tr>
              </table>
              <p>
             </template name="WND_ATOURNY">
             <template name="WND_TOURNY">
              <table cellspacing="0" cellpadding="0" border="0" width="175">
                <tr>
                  <td width="175"><img src="{LOCATION_IMAGES}tourny.jpg" width="175" height="18"></td>
                </tr>
                <tr>
                  <td width="175">
                    <table cellspacing="0" cellpadding="0" border="0" width="175">
                      <tr>
                        <td width="175">
                        <template name="WND_TOURNY_LIST">
                         <a href="?page=tourny&tournyid={WND_TOURNY_ID}">{WND_TOURNY_NAME}</a>
                        </template name="WND_TOURNY_LIST">
                      </tr>
                  </table></td>
                </tr>
              </table>
              <p>
            </template name="WND_TOURNY">
              <table width="175" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="175" height="100%" valign="top"><img src="{LOCATION_IMAGES}menu-left-3.jpg" width="175" height="18"></td>
                </tr>
                <tr>
                  <td width="175" height="100%" valign="top" style="padding-left:10px; padding-right:10px; padding-top:5px;">&nbsp; </td>
                </tr>
            </table></td>
          </tr>
      </table></td>
      <td colspan="2" valign="top" bgcolor="#B6B6B6">
        <table border="0" cellpadding="0" cellspacing="0">
          <!--DWLayoutTable-->
          <tr>
            <td width="23" height="100%"></td>
            <td width="494"></td>
            <td width="3"></td>
            <td height="100%"></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td height="192"></td>
            <td valign="top"><br>
                <table width="494" border="0" cellpadding="0" cellspacing="0" class="news">
                  <!--DWLayoutTable-->
                  <tr>
                    <td height="22" align="center" valign="top">
                      <table width="100%" height="22" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="22" height="22" align="left" valign="bottom"> <img src="{LOCATION_IMAGES}menu-left.gif" width="22" height="22"></td>
                          <td width="100%" height="22" align="center" valign="bottom" background="{LOCATION_IMAGES}menu-center.gif"><img src="{LOCATION_IMAGES}menu-center.gif" width="15" height="22"></td>
                          <td width="22" height="22" align="right" valign="bottom">
                            <p><img src="{LOCATION_IMAGES}menu-right.gif" width="19" height="22"></p></td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td width="100%" valign="top" bgcolor="#E8E8E8" style="padding-left:10px; padding-right:10px; padding-top:5px;"> {CENTER} </td>
                  </tr>
                  <tr>
                    <td height="9" valign="top">
                      <table width="100%" height="9" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="20" height="9" align="left" valign="top"> <img src="{LOCATION_IMAGES}lmenu-left.gif" width="20" height="9"></td>
                          <td width="100%" height="9" align="center" valign="top" background="{LOCATION_IMAGES}lmenu-center.gif"> <img src="{LOCATION_IMAGES}lmenu-center.gif" width="11" height="9" hspace="0" vspace="0"></td>
                          <td width="22" height="9" align="right" valign="top"> <img src="{LOCATION_IMAGES}lmenu-right.gif" width="17" height="9"></td>
                        </tr>
                    </table></td>
                  </tr>
                </table></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </table>
        <br>
      </td>
    </tr>
    <tr>
      <td colspan="3" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <!--DWLayoutTable-->
          <tr>
            <td width="753" height="13" valign="top"><table width="754" border="0" cellpadding="0" cellspacing="0" background="{LOCATION_IMAGES}truba-bg-niz.jpg">
                <!--DWLayoutTable-->
                <tr>
                  <td height="12"></td>
                </tr>
                <!--DWLayoutTable-->
                <tr>
                  <td width="754" height="1"></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="25" valign="top" background="{LOCATION_IMAGES}footerstretch.jpg"><table width="753" border="0" cellpadding="0" cellspacing="0">
                <!--DWLayoutTable-->
                <tr>
                  <td width="753" height="26" valign="top" align="center">
                   <img src="{LOCATION_IMAGES}footernonstretch.jpg">
                  </td>
                </tr>
            </table></td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
</body>
</html>
