<?
$m_id=cookie_get("mem_id");
$m_acc=cookie_get("mem_acc");
$mem_list=cookie_get("mem_list");
$mem_grop=cookie_get("mem_grop");
$mem_eve=cookie_get("mem_eve");
$mem_blog=cookie_get("mem_blog");
$mem_chat=cookie_get("mem_chat");
$mem_forum=cookie_get("mem_forum");
$mem_forum=cookie_get("mem_forum");
?>
<table cellpadding=0 cellspacing=0 width=100% bgcolor="Navy" class="lined">
  <tr> 
    <td height=70><img border="0" src="images/logo.gif"></td>
    <td height=70 colspan="9" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <?=h_banners();?>
          </td>
        </tr>
      </table> </td>
  </tr>
  <tr align="right"> 
    <td colspan="10"><b>History:</b>&nbsp&nbsp&nbsp&nbsp&nbsp 
      <?
  $m_id=cookie_get("mem_id");
  if($m_id!=''){
  $sql_query="select history from members where mem_id='$m_id'";
  $hist=sql_execute($sql_query,'get');
  $items=split("\|",$hist->history);
  $items=if_empty($items);
  if($items!=''){
     for($i=0;$i<count($items);$i++){
           $k=$i+1;
           echo "<a href='$items[$i]'>$items[$k]</a>&nbsp&gt;";
           $i++;
     }//for
  }//if
  }//if
?>
    </td>
  </tr>
  <tr> 
    <td colspan="9"> <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <? if($m_id==''){ ?>
        <tr> 
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<u><font color="#FFFFFF"><font size="2">My</font></font></u><a href="index.php?mode=login&act=home"><font color="#FFFFFF"><font size="2">Home</font></font></a></b></td>
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<u><font color="#FFFFFF"><font size="2">My</font></font></u><font size="2"><a href="index.php?mode=user&act=inv"><font color="#FFFFFF">Invite</font></a></font><u><font color="#FFFFFF"><font size="2">s</font></font></u></b></td>
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<u><font color="#FFFFFF"><font size="2">My</font></font></u><a href="index.php?mode=messages&act=inbox"><font color="#FFFFFF"><font size="2">Messages</font></font></a></b></td>
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<u><font color="#FFFFFF"><font size="2">My</font></font></u><a href="index.php?mode=login&act=menu_err"><font color="#FFFFFF"><font size="2">Search</font></font></a></b></td>
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<u><font color="#FFFFFF"><font size="2">My</font></font></u><a href="index.php?mode=login&act=menu_err"><font color="#FFFFFF"><font size="2">Blog</font></font></a></b></td>
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<u><font color="#FFFFFF"><font size="2">My</font></font></u><a href="index.php?mode=login&act=menu_err"><font color="#FFFFFF"><font size="2">Classifieds</font></font></a></b></td>
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<u><font color="#FFFFFF"><font size="2">My</font></font></u><a href="index.php?mode=login&act=menu_err"><font color="#FFFFFF"><font size="2">Forums</font></font></a></b></td>
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<u><font color="#FFFFFF"><font size="2">My</font></font></u><a href="index.php?mode=login&act=menu_err"><font color="#FFFFFF"><font size="2">Events</font></font></a></b></td>
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<u><font color="#FFFFFF"><font size="2">My</font></font></u><a href="index.php?mode=login&act=menu_err"><font color="#FFFFFF"><font size="2">Groups</font></font></a></b></td>
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<u><font color="#FFFFFF"><font size="2">My</font></font></u><a href="index.php?mode=login&act=menu_err"><font color="#FFFFFF"><font size="2">Chat</font></font></a></b></td>
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<u><font size="2" color="#FFFFFF">My</font></u><a href="index.php?mode=login&act=menu_err"><font size="2" color="#FFFFFF">Calendar</font></a></b></td>
        </tr>
        <?php } else { ?>
        <tr> 
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<u><font color="#FFFFFF"><font size="2">My</font></font></u><a href="index.php?mode=login&act=home"><font color="#FFFFFF"><font size="2">Home</font></font></a></b></td>
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<u><font color="#FFFFFF"><font size="2">My</font></font></u><a href="index.php?mode=user&act=inv"><font color="#FFFFFF"><font size="2">Invite</font></font></a></b></td>
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<u><font color="#FFFFFF"><font size="2">My</font></font></u><a href="index.php?mode=messages&act=inbox"><font color="#FFFFFF"><font size="2">Messages</font></font></a></b></td>
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<font size="2"><u><?php if($m_acc==0) { ?></u><a href="index.php?mode=login&act=menu_up"><?php } else { ?><a href="index.php?mode=search"><font color="#FFFFFF"><?php } ?></font></a></font><font color="#FFFFFF"><u><font size="2">My</font></u><a href="index.php?mode=search"><font color="#FFFFFF"><font size="2">Search</font></font></a></font></b></td>
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<font size="2"><u><?php if($mem_blog=="Y") { ?></u><a href="index.php?mode=blogs"><?php } else { ?><a href="index.php?mode=login&act=menu_up"><font color="#FFFFFF"><?php } ?></font></a></font><font color="#FFFFFF"><u><font size="2">My</font></u><a href="index.php?mode=login&act=menu_up"><font size="2" color="#FFFFFF">Blog</font></a></font></b></td>
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<font size="2"><u><?php if($mem_list=="Y") { ?></u><a href="index.php?mode=listing&act=all"><?php } else { ?><a href="index.php?mode=login&act=menu_up"><font color="#FFFFFF"><?php } ?></font></a></font><font color="#FFFFFF"><u><font size="2">My</font></u><a href="index.php?mode=login&act=menu_up"><font size="2" color="#FFFFFF">Classifieds</font></a></font></b></td>
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<font size="2"><u><?php if($mem_forum=="Y") { ?></u><a href="index.php?mode=forums"><?php } else { ?><a href="index.php?mode=login&act=menu_up"><font color="#FFFFFF"><?php } ?></font></a></font><font color="#FFFFFF"><u><font size="2">My</font></u><a href="index.php?mode=login&act=menu_up"><font size="2" color="#FFFFFF">Forums</font></a></font></b></td>
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<font size="2"><u><?php if($mem_eve=="Y") { ?></u><a href="index.php?mode=events"><?php } else { ?><a href="index.php?mode=login&act=menu_up"><font color="#FFFFFF"><?php } ?></font></a></font><font color="#FFFFFF"><u><font size="2">My</font></u><a href="index.php?mode=login&act=menu_up"><font size="2" color="#FFFFFF">Events</font></a></font></b></td>
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<font size="2"><u><?php if($mem_grop=="Y") { ?></u><a href="index.php?mode=tribe"><?php } else { ?><a href="index.php?mode=login&act=menu_up"><font color="#FFFFFF"><?php } ?></font></a></font><font color="#FFFFFF"><u><font size="2">My</font></u><a href="index.php?mode=login&act=menu_up"><font size="2" color="#FFFFFF">Groups</font></a></font></b></td>
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<font size="2"><u><?php if($mem_chat=="Y") { ?></u><a href="chat"><?php } else { ?><a href="index.php?mode=login&act=menu_up"><font color="#FFFFFF"><?php } ?></font></a></font><font color="#FFFFFF"><u><font size="2">My</font></u><a href="index.php?mode=login&act=menu_up"><font size="2" color="#FFFFFF">Chat</font></a></font></b></td>
          <td align="center" bgcolor="#0099FF" class="button-system bodygray"><b>
			<u><font color="#FFFFFF"><font size="2">My</font></font></u><a href="calendar"><font color="#FFFFFF"><font size="2">Calendar</font></font></a></b></td>
        </tr>
        <?php } ?>
      </table></td>
  </tr>
  <tr align="right"> 
    <td colspan="9" class="maingray"><b><a href="index.php?mode=user&act=profile&pro=edit&type=account">
	<font color="#FFFFFF">Account</font></a>&nbsp&nbsp 
      <a href="index.php?mode=help"><font color="#FFFFFF">Help</font></a>&nbsp&nbsp 
      <? $m_id=cookie_get("mem_id");
		if($m_id==''){ ?>
      <a href="index.php?mode=login&act=form"><font color="#FFFFFF">Login</font></a>&nbsp&nbsp</b> 
      <? } else { ?>
      <a href="index.php?mode=login&act=logout"><font color="#FFFFFF">Logout</font></a>&nbsp</b> 
      <? } ?>
    </td>
  </tr>
</table>