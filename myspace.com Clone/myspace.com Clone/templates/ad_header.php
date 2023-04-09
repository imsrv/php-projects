<?
/*
           .ÜÜÜÜÜÜÜÜÜÜÜÜ,                                  .ÜÜÜÜÜÜÜÜÜ:     ,ÜÜÜÜÜÜÜÜ:
         ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ                             .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ,ÜÜÜÜÜÜÜÜÜÜÜÜÜ
        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ             D O N          ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ                           ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ.
         ÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜ          ÜÜÜÜÜÜÜ;        .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜ;
         ,ÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜ        ÜÜÜÜÜÜÜÜÜÜÜ        ,ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ;ÜÜÜÜÜÜÜÜ;
          ÜÜÜÜÜÜÜÜÜ :ÜÜÜÜÜÜÜÜÜ      ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;;ÜÜÜÜÜÜÜÜ
          ÜÜÜÜÜÜÜÜ: ÜÜÜÜÜÜÜÜÜÜ    .ÜÜÜÜÜÜÜ;;ÜÜÜÜÜÜ;      :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;ÜÜÜÜÜÜ.
         ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ   ;ÜÜÜÜÜÜÜ  .ÜÜÜÜÜÜÜ     .ÜÜÜÜÜÜÜÜ;ÜÜÜÜÜÜÜ;ÜÜÜÜÜÜ
        :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜ,,,ÜÜÜÜÜÜÜÜ    .ÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ    ÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
       ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ, ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  .ÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:
     .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
    ,ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ :ÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
   ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ,ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
  ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ.  :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
 ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;     ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:
 ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ.      ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ,  ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
 ,ÜÜÜÜLiquidIceÜÜÜÜÜÜ          ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ    ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜ
    .ÜÜÜÜÜÜÜÜÜÜ;                 ÜÜÜÜÜÜÜÜÜ        .ÜÜÜÜÜÜÜÜÜÜÜ    .ÜÜÜÜÜÜÜÜÜÜ,

*/
?>
<table cellpadding=0 cellspacing=0 width=100% bgcolor="Navy" class="lined" style="border-collapse: collapse" bordercolor="#111111">
  <tr>
    <td colspan="9">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
		<td height=70><img border="0" src="images/logo.gif"></td>
    <td height=70 colspan=7><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td> 
            <?=h_banners();?>
          </td>
        </tr>
      </table></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td align="center" class="button-system bodygray"><b><a href="admin.php?mode=users_manager&adsess=<? echo $adsess; ?>">Users 
      Manager</a></b></td>
    <td align="center" class="button-system bodygray"><b><a href="admin.php?mode=listings_manager&adsess=<? echo $adsess; ?>">Listings 
      Manager</a></b></td>
    <td align="center" class="button-system bodygray"><b><a href="admin.php?mode=tribes_manager&adsess=<? echo $adsess; ?>">Groups 
      Manager</a></b></td>
    <td align="center" class="button-system bodygray"><b><a href="admin.php?mode=forums_manager&adsess=<? echo $adsess; ?>">Forums 
      Manager</a></b></td>
    <td align="center" class="button-system bodygray"><b><a href="admin.php?mode=blogs_manager&adsess=<? echo $adsess; ?>">Blogs 
      Manager</a></b></td>
    <td align="center" class="button-system bodygray"><b><a href="admin.php?mode=events_manager&adsess=<? echo $adsess; ?>">Events 
      Manager</a></b></td>
    <td align="center" class="button-system bodygray"><b><a href="admin.php?mode=package_manager&adsess=<? echo $adsess; ?>">Package 
      Manager</a></b></td>
    <td align="center" class="button-system bodygray"><b><a href="admin.php?mode=statistics&adsess=<? echo $adsess; ?>">Statistics</a></b></td>
  </tr>
  <tr align="right"> 
    <td colspan="8" class="maingray"><b><a href="admin.php?mode=profilequestion_manager&adsess=<? echo $adsess; ?>">Profile Question 
      Manager</a></b>&nbsp;/&nbsp;<b><a href="admin.php?mode=ip_manager&adsess=<? echo $adsess; ?>">IP 
      Manager</a></b>&nbsp;/&nbsp;<b><a href="admin.php?mode=paypal_manager&adsess=<? echo $adsess; ?>">Paypal ID 
      Manager</a></b>&nbsp;/&nbsp;<b><a href="admin.php?mode=chatroom_manager&adsess=<? echo $adsess; ?>">Chat Rooms 
      Manager</a></b>&nbsp;/&nbsp;<b><a href="admin.php?mode=banner_manager&adsess=<? echo $adsess; ?>">Banner 
      Manager</a></b>&nbsp;/&nbsp;<b><a href="admin.php?mode=admin_feedback&adsess=<? echo $adsess; ?>">Listing 
      Feedbacks</a></b>&nbsp;/&nbsp;<b><a href="admin.php?mode=admin_login&act=logout&adsess=<? echo $adsess; ?>">Logout</a></b></td>
  </tr>
</table>
