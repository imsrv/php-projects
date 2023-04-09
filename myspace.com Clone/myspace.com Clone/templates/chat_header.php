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
<html>
<head>
<title>Chat</title>
<link href="../styles/style.css" type="text/css" rel="stylesheet">
<?
$mode=form_get("mode");
$act=form_get("act");
if($mode=="user"){
   ?>
      <script language="JavaScript">
      <!--

         function formsubmit(type){
            document.profile.redir.value=type;
            document.profile.submit();
         }

      -->
      </script>
   <?
}
elseif(($mode=='listing')&&($act=='create')){
?>
<script language="Javascript" src="../DynamicOptionList.js"></script>
<SCRIPT LANGUAGE="JavaScript">

var listmessage_categoryId = new DynamicOptionList("message_categoryId","message_rootCategoryId");

<? listing_cats_java(2); ?>
																																					listmessage_categoryId.addOptions('8000','computer','8001','creative','8002','erotic','8003','event','8004','household','8005','garden / labor / haul','8006','lessons','8007','looking for','8008','skilled trade','8009','sm biz ads','8010','therapeutic','8011');


function init() {
	var theform = document.forms["manageListing"];
	listmessage_categoryId.init(theform);
	}
</SCRIPT>
<body marginwidth="5" bgcolor="#ffffff" leftmargin ="5" topmargin="5" marginheight="5" onLoad="listmessage_categoryId.init(document.forms['manageListing']);">
<?
}
elseif((($mode=='listing')&&($act!='create')&&($act!='show')&&($act!='feedback'))||(($mode=='search')&&($act=='listing'))){
?>
<script language="Javascript" src="../DynamicOptionList.js"></script>
<SCRIPT LANGUAGE="JavaScript">

var listCategory = new DynamicOptionList("Category","RootCategory");

<?
 listing_cats_java(1);
?>


	listCategory.addOptions('','Select Subcategory','');
 listCategory.setDefaultOption('','');

function init() {
	var theform = document.forms["searchListing"];
	listCategory.init(theform);
	}
</SCRIPT>

<body marginwidth="5" bgcolor="#ffffff" leftmargin ="5" topmargin="5" marginheight="5" onLoad="listCategory.init(document.forms['searchListing']);">
<?
}//elseif
?>
</head>
<body topmargin=2 leftmargin=2>
<table width="740">
<tr><td width=100%>
<table cellpadding=0 cellspacing=0 width=100% bgcolor="#d5d5d5" class="lined">
  <tr> 
    <td height=70><img border="0" src="../images/logo.gif"></td>
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
          <td align="center" bgcolor="#d5d5d5" class="button-system bodygray"><b><a href="../index.php?mode=login&act=home">Home</a></b></td>
          <td align="center" bgcolor="#d5d5d5" class="button-system bodygray"><b><a href="../index.php?mode=user&act=inv">Invite</a></b></td>
          <td align="center" bgcolor="#d5d5d5" class="button-system bodygray"><b><a href="../index.php?mode=messages&act=inbox">Messages</a></b></td>
          <td align="center" bgcolor="#d5d5d5" class="button-system bodygray"><b><a href="../index.php?mode=login&act=menu_err">Search</a></b></td>
          <td align="center" bgcolor="#d5d5d5" class="button-system bodygray"><b><a href="../index.php?mode=login&act=menu_err">Blog</a></b></td>
          <td align="center" bgcolor="#d5d5d5" class="button-system bodygray"><b><a href="../index.php?mode=login&act=menu_err">Classifieds</a></b></td>
          <td align="center" bgcolor="#d5d5d5" class="button-system bodygray"><b><a href="../index.php?mode=login&act=menu_err">Forums</a></b></td>
          <td align="center" bgcolor="#d5d5d5" class="button-system bodygray"><b><a href="../index.php?mode=login&act=menu_err">Events</a></b></td>
          <td align="center" bgcolor="#d5d5d5" class="button-system bodygray"><b><a href="../index.php?mode=login&act=menu_err">Groups</a></b></td>
          <td align="center" bgcolor="#d5d5d5" class="button-system bodygray"><b><a href="../index.php?mode=login&act=menu_err">Chat</a></b></td>
        </tr>
        <?php } else { ?>
        <tr> 
          <td align="center" bgcolor="#d5d5d5" class="button-system bodygray"><b><a href="../index.php?mode=login&act=home">Home</a></b></td>
          <td align="center" bgcolor="#d5d5d5" class="button-system bodygray"><b><a href="../index.php?mode=user&act=inv">Invite</a></b></td>
          <td align="center" bgcolor="#d5d5d5" class="button-system bodygray"><b><a href="../index.php?mode=messages&act=inbox">Messages</a></b></td>
          <td align="center" bgcolor="#d5d5d5" class="button-system bodygray"><b><?php if($m_acc==0) { ?><a href="../index.php?mode=login&act=menu_up"><?php } else { ?><a href="../index.php?mode=search"><?php } ?>Search</a></b></td>
          <td align="center" bgcolor="#d5d5d5" class="button-system bodygray"><b><?php if($mem_blog=="Y") { ?><a href="../index.php?mode=blogs"><?php } else { ?><a href="../index.php?mode=login&act=menu_up"><?php } ?>Blog</a></b></td>
          <td align="center" bgcolor="#d5d5d5" class="button-system bodygray"><b><?php if($mem_list=="Y") { ?><a href="../index.php?mode=listing&act=all"><?php } else { ?><a href="../index.php?mode=login&act=menu_up"><?php } ?>Classifieds</a></b></td>
          <td align="center" bgcolor="#d5d5d5" class="button-system bodygray"><b><?php if($mem_forum=="Y") { ?><a href="../index.php?mode=forums"><?php } else { ?><a href="../index.php?mode=login&act=menu_up"><?php } ?>Forums</a></b></td>
          <td align="center" bgcolor="#d5d5d5" class="button-system bodygray"><b><?php if($mem_eve=="Y") { ?><a href="../index.php?mode=events"><?php } else { ?><a href="../index.php?mode=login&act=menu_up"><?php } ?>Events</a></b></td>
          <td align="center" bgcolor="#d5d5d5" class="button-system bodygray"><b><?php if($mem_grop=="Y") { ?><a href="../index.php?mode=tribe"><?php } else { ?><a href="../index.php?mode=login&act=menu_up"><?php } ?>Groups</a></b></td>
          <td align="center" bgcolor="#d5d5d5" class="button-system bodygray"><b><?php if($mem_chat=="Y") { ?><a href="../chat"><?php } else { ?><a href="index.php?mode=../login&act=menu_up"><?php } ?>Chat</a></b></td>
          <td align="center" bgcolor="#d5d5d5" class="button-system bodygray"><b><a href="../calendar">Calendar</a></b></td>
	</tr>
        <?php } ?>
      </table></td>
  </tr>
  <tr align="right"> 
    <td colspan="9" class="maingray"><b><a href="../index.php?mode=user&act=profile&pro=edit&type=account">Account</a>&nbsp&nbsp 
      <a href="../index.php?mode=help">Help</a>&nbsp&nbsp 
      <? $m_id=cookie_get("mem_id");
		if($m_id==''){ ?>
      <a href="../index.php?mode=login&act=form">Login</a>&nbsp&nbsp</b> 
      <? } else { ?>
      <a href="../index.php?mode=login&act=logout">Logout</a>&nbsp</b> 
      <? } ?>
    </td>
  </tr>
</table>
</td>
<tr><td width=100%>