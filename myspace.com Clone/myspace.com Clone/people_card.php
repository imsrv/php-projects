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

$act=form_get("act");
if($act==''){
 basics_profile();
}
elseif($act=='pers'){
 personal_profile();
}
elseif($act=='prof'){
 professional_profile();
}
elseif($act=='friends'){
 profile_friends("1");
}
elseif($act=='network'){
 profile_friends("all");
}

//showing friends of viewed person
function profile_friends($deg){
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$p_id=form_get("p_id");
$page=form_get("page");
if($page==''){
  $page=1;
}
       show_header();
       echo "<table width=100% class=body>
       <tr><td class='lined title'>Friends</td>
       <tr><td><table align=center class='body'>";
       if($deg=='1'){
       show_friends_deg($p_id,"10","5","$page","1");echo "</table></td>
       <tr><td class='lined' align=center>";
       pages_line($p_id,"friends","$page","10");
       }
       elseif($deg=='all'){
       show_friends_deg($p_id,"10","5","$page","all");echo "</table></td>
       <tr><td class='lined' align=center>";
       pages_line($p_id,"friendsall","$page","10");
       }
       echo "</td>
       </table>";
       show_footer();
}//function

//showing basics prodile
function basics_profile(){
$p_id=form_get("p_id");
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
//updating user history of surfing the site
if($m_id!=''){
  $sql_query="select history from members where mem_id='$m_id'";
  $mem=sql_execute($sql_query,'get');
  $hist=split("\|",$mem->history);
  $hist=if_empty($hist);
  if($hist==''){
    $hist[]='';
  }
  $adding="index.php?mode=people_card&p_id=$p_id";
  if(!in_array($adding,$hist)){
  $addon="|$adding|".name_header($p_id,$m_id);
  if(count($hist)>=10){
     for($i=2;$i<count($hist);$i++){
         $line.=$hist[$i]."|";
     }//for
     $line.=$addon;
     $sql_query="update members set history='$line' where mem_id='$m_id'";
  }//if
  else {
  $sql_query="update members set history=concat(history,'$addon') where mem_id='$m_id'";
  }//else
  sql_execute($sql_query,'');
  }//if
}//if
$now=time();
//updatin viewed person value 'views on you'
$sql_query="update members set views=concat(views,'|$now') where mem_id='$p_id'";
sql_execute($sql_query,'');
show_header();
?>
<table width=100%>
<tr><td>
<table class="lined body" width=100%>
<tr><td class="padded-6">
    <table width=100% class="body">
    <tr><td class="lined-top lined-left lined-right" width=110>
    <b><a href="index.php?mode=people_card&p_id=<? echo $p_id; ?>">Basics</a></b>
    </td>
    <td class="lined" width=110>
    <a href="index.php?mode=people_card&p_id=<? echo $p_id; ?>&act=pers">Personal</a>
    </td>
    <td class="lined" width=110>
    <a href="index.php?mode=people_card&p_id=<? echo $p_id; ?>&act=prof">Professional</a>
    </td>
    <td align=right class='maingray'>updated
    <? echo show_profile_updated($p_id);
    if($p_id==$m_id){ ?>
    &nbsp<span class=action><a href='index.php?mode=user&act=profile&pro=edit'>edit</a></span>
    <? } ?>
    </td>
    <tr><td colspan=4>
    	<table width=100%>
        <tr><td>
            <table class="body">
            <tr><td class="lined" align=center>
            <? show_profile_photo($p_id); ?>
            </br>
            <? show_online($p_id); ?></br>
            <? photo_album_link($p_id); ?></br>
            </td>
            <tr><td class=lined>
            </br>
            <a href="index.php?mode=people_card&act=friends&p_id=<? echo $p_id; ?>">
            <? echo count_network($p_id,"1","num"); ?> Friends
            </a>
            </br>
            <a href='index.php?mode=people_card&act=network&p_id=<? echo $p_id; ?>'><? echo count_network($p_id,"all","num"); ?> in Network</a>
            </br>
            Member since <? echo member_since($p_id); ?>
            </td>
            </table>
        </td>
        <td valign=top width=50%>
            <table class="body" align=left>
            <tr><td colspan=2 class="orangeheader"><? echo name_header($p_id,$m_id); ?></td>
            <? show_profile($p_id,"basic"); ?>
            </table>
        </td>
    	</table>
        <tr><td valign=top colspan=4>
        <table width=100%><tr><td valign=top rowspan=2>
        <table class="body" width=100%>
        <tr><td class="lined title"><? echo name_header($p_id,$m_id); ?>'s Friends</a></span></td>
        <tr><td class="lined"><table width=100%><? show_friends($p_id,"6","2","1"); ?></table></td>
        </table>
        </td>
        <td valign=top height=100%><table class='body' width=100% height=100%>
        <tr><td class="lined title">Listings From <? echo name_header($p_id,$m_id); ?> & Friends</td>
        <tr><td class=lined height=100% valign=top>
        </br>
        <? show_listings("inprofile",$p_id,''); ?>
        </br>
        </td></table></td>
        <tr><td width=100% valign=bottom>
        <table class="body" width=100% height=100%>
        <tr><td class="lined title">Testimonials for <? echo name_header($p_id,$m_id); ?></td>
        <tr><td class="lined" height=100%><? show_testimonials($p_id,$m_id); ?></td>
        <?
          $sql_query="select mem_id from network where mem_id='$p_id' and frd_id='$m_id'";
          $num=sql_execute($sql_query,'num');
          if(($num!=0)&&($p_id!=$m_id)){
           echo "<tr><td class='lined body'>
           <table class='body'>
           <tr><td>Tell others how you feel about ";echo name_header($p_id,$m_id);echo "</td>
           <td><input type='button' onClick='window.location=\"index.php?mode=user&act=tst&p_id=$p_id\"' value='Write a Testimonial'></td>
           </table>
           </td>";
          }
        ?>
        </table></td>
        </table>
        </td>
    </td>
    </table>
</td>
</table>
</td>
<td valign=top>
	<table class="body" width=100%>
    <tr><td><table class="lined body">
    <tr><td class=lined><? show_photo($m_id); ?></br>
    <? show_online($m_id); ?>
    </td>
    <td>Member Since <? echo member_since($m_id); ?>
    </br></br>
    <a href='index.php?mode=people_card&act=friends&p_id=<? echo $m_id; ?>'><? echo count_network($m_id,"1","num"); ?> Friends</a></br>
    <a href='index.php?mode=people_card&act=network&p_id=<? echo $m_id; ?>'><? echo count_network($m_id,"all","num"); ?> in my Network</a></br>&nbsp
    </td>
    </table></td>
    <tr><td>
        <table class="shade lined body" width=100%>
        <tr><td bgcolor=white class="bodygray bold">WHAT CAN I DO NOW?</td>
        <? if($m_id!=$p_id){

           $sql_query2="select bmr_id from bmarks where mem_id='$m_id' and type='member' and sec_id='$p_id'";
           $num=sql_execute($sql_query2,'num');
           if($num==0){
           ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=bmarks&pro=add&sec_id=<? echo $p_id; ?>&type=member">
           Bookmark <? echo name_header($p_id,$m_id); ?>
           </a></td>
           <? } else{
           $bmr=sql_execute($sql_query2,'get'); ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=bmarks&pro=del&bmr_id=<? echo $bmr->bmr_id; ?>">
           Un-Bookmark <? echo name_header($p_id,$m_id); ?>
           </a></td>
           <? } ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=messages&act=compose&rec_id=<? echo $p_id; ?>">
           Send <? echo name_header($p_id,$m_id); ?> a message
           </a></td>
           <? $sql_query="select mem_id from network where mem_id='$m_id' and frd_id='$p_id'";
           $num=sql_execute($sql_query,'num');
           if($num!=0){
           ?>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=user&act=friends&pro=remove&frd_id=<? echo $p_id; ?>">
           Remove <? echo name_header($p_id,$m_id); ?> from friends
           </a></td>
           <?
           }
           else {
           ?>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=user&act=friends&pro=add&frd_id=<? echo $p_id; ?>">
           Add <? echo name_header($p_id,$m_id); ?> as a friend
           </a></td>
           <?
           }
           ?>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=user&act=intro&p_id=<? echo $p_id; ?>">
           Make an Intro
           </a></td>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=user&act=invite_tribe&p_id=<? echo $p_id; ?>">
           Invite <? echo name_header($p_id,$m_id); ?> to group
           </a></td>
           <?
           //setting user's ignore list
           $sql_query="select ignore_list from members where mem_id='$m_id'";
      	   $mem=sql_execute($sql_query,'get');
	              $ignore=split("\|",$mem->ignore_list);
	              $ignore=if_empty($ignore);
                  if($ignore!=''){
                  $status=0;
	              foreach($ignore as $ign){
	                  if($ign==$p_id){
	                   $status=1;
                       break;
	                  }
	              }//foreach
                  }//if
                  else {
                     $status=0;
                  }//else
           if($status==0){
           ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=ignore&pro=add&p_id=<? echo $p_id; ?>">
           Ignore <? echo name_header($p_id,$m_id); ?>
           </a></td>
           <? } elseif($status==1){ ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=ignore&pro=del&p_id=<? echo $p_id; ?>">
           Un-Ignore <? echo name_header($p_id,$m_id); ?>
           </a></td>
           <? } ?>
        <?
        }
        else {
        //if user is viewing his own profile
        ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=profile&pro=edit">
           Edit your profile
           </a></td>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=bmarks">
           Edit your bookmarks
           </a></td>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=ignore">
           Edit your igore list
           </a></td>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=user&act=listings">
           View your Listings
           </a></td>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=user&act=friends">
           View your Friends
           </a></td>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=listing&act=create">
           Create a Listing
           </a></td>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=messages&act=inbox">
           View your Message Center
           </a></td>
        <?
        }
        ?>
        </table></td>
             <?
             //setting user's bookmarks
     $sql_query="select * from bmarks where mem_id='$m_id'";
     $num=sql_execute($sql_query,'num');
     if($num==0){
     }
     else {
        echo "     <tr><td>
        <table class='td-shade lined body' width=100%>
             <tr><td bgcolor=white class='bodygray bold'>My Bookmarks</td>";
       $res=sql_execute($sql_query,'res');
       while($bmr=mysql_fetch_object($res)){

              if($bmr->type=="member"){

                  echo "<tr><td>
                  <img src='images/medicon_person.gif' border=0>
                  <a href='index.php?mode=people_card&p_id=$bmr->sec_id'>".
                  name_header($bmr->sec_id,$m_id)."</a>
                  </td>";

              }//if

              elseif($bmr->type=="listing"){

                  $sql_query="select title from listings where lst_id='$bmr->sec_id'";
                  $lst=sql_execute($sql_query,'get');

                  echo "<tr><td>
                  <img src='images/icon_listing.gif' border=0>
                  &nbsp&nbsp<a href='index.php?mode=listing&act=show&lst_id=$bmr->sec_id'>".
                  $lst->title."</a>
                  </td>";

              }//elseif

              elseif($bmr->type=="tribe"){

                  $sql_query="select name from tribes where trb_id='$bmr->sec_id'";
                  $trb=sql_execute($sql_query,'get');

                  echo "<tr><td>
                  <img src='images/medicon_tribe.gif' border=0>
                  <a href='index.php?mode=tribe&act=show&trb_id=$bmr->sec_id'>".
                  $trb->name."</a>
                  </td>";

              }//elseif

       }//while

     }//else
             ?>



        </table>
    </td>
    </table>
</td>
</table>
<?
show_footer();
}

function personal_profile(){
$p_id=form_get("p_id");
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
show_header();
?>
<table width=100%>
<tr><td>
<table class="lined body" width=100%>
<tr><td class="padded-6">
    <table width=100% class="body">
    <tr><td class="lined" width=110>
    <a href="index.php?mode=people_card&p_id=<? echo $p_id; ?>">Basics</a>
    </td>
    <td class="lined-top lined-left lined-right" width=110>
    <b><a href="index.php?mode=people_card&p_id=<? echo $p_id; ?>&act=pers">Personal</a></b>
    </td>
    <td class="lined" width=110>
    <a href="index.php?mode=people_card&p_id=<? echo $p_id; ?>&act=prof">Professional</a>
    </td>
    <td align=right class='maingray'>updated
    <? echo show_profile_updated($p_id);
    if($p_id==$m_id){ ?>
    &nbsp<span class=action><a href='index.php?mode=user&act=profile&pro=edit'>edit</a></span>
    <? } ?>
    </td>
    <tr><td colspan=4>
    	<table width=100%>
        <tr><td>
            <table class="body">
            <tr><td class="lined" align=center>
            <? show_profile_photo($p_id); ?>
            </br>
            <? show_online($p_id); ?></br>
            <? photo_album_link($p_id); ?></br>
            </td>
            <tr><td class=lined>
            </br>
            <a href="index.php?mode=people_card&act=friends&p_id=<? echo $p_id; ?>">
            <? echo count_network($p_id,"1","num"); ?> Friends
            </a>
            </br>
            <a href='index.php?mode=people_card&act=network&p_id=<? echo $p_id; ?>'><? echo count_network($p_id,"all","num"); ?> in Network</a>
            </br>
            Member since <? echo member_since($p_id); ?>
            </td>
            </table>
        </td>
        <td valign=top width=50%>
            <table class="body" align=left>
            <tr><td colspan=2 class="orangeheader"><? echo name_header($p_id,$m_id); ?></td>
            <? show_profile($p_id,"personal"); ?>
            </table>
        </td>
    	</table>
        <tr><td valign=top colspan=4>
        <table width=100%><tr><td valign=top rowspan=2>
        <table class="body" width=100%>
        <tr><td class="lined title"><? echo name_header($p_id,$m_id); ?>'s Friends</a></span></td>
        <tr><td class="lined"><table width=100%><? show_friends($p_id,"6","2","1"); ?></table></td>
        </table>
        </td>
        <td valign=top height=100%><table class='body' width=100% height=100%>
        <tr><td class="lined title">Listings From <? echo name_header($p_id,$m_id); ?> & Friends</td>
        <tr><td class=lined height=100% valign=top>
        </br>
        <? show_listings("inprofile",$p_id,''); ?>
        </br>
        </td></table></td>
        <tr><td width=100% valign=bottom>
        <table class="body" width=100% height=100%>
        <tr><td class="lined title">Testimonials for <? echo name_header($p_id,$m_id); ?></td>
        <tr><td class="lined" height=100%><? show_testimonials($p_id,$m_id); ?></td>
        <?
          $sql_query="select mem_id from network where mem_id='$p_id' and frd_id='$m_id'";
          $num=sql_execute($sql_query,'num');
          if(($num!=0)&&($p_id!=$m_id)){
           echo "<tr><td class='lined body'>
           <table class='body'>
           <tr><td>Tell others how you feel about ";echo name_header($p_id,$m_id);echo "</td>
           <td><input type='button' onClick='window.location=\"index.php?mode=user&act=tst&p_id=$p_id\"' value='Write a Testimonial'></td>
           </table>
           </td>";
          }
        ?>
        </table></td>
        </table>
        </td>
    </td>
    </table>
</td>
</table>
</td>
<td valign=top>
	<table class="body">
    <tr><td><table class="lined body">
    <tr><td vasilek class=lined><? show_photo($m_id); ?></br>
    <? show_online($m_id); ?>
    </td>
    <td>Member Since <? echo member_since($m_id); ?>
    </br></br>
    <a href='index.php?mode=people_card&act=friends&p_id=<? echo $m_id; ?>'><? echo count_network($m_id,"1","num"); ?> Friends</a></br>
    <a href='index.php?mode=people_card&act=network&p_id=<? echo $m_id; ?>'><? echo count_network($m_id,"all","num"); ?> in my Network</a></br>&nbsp
    </td>
    </table></td>
    <tr><td>
        <table class="shade lined body" width=100%>
        <tr><td bgcolor=white class="bodygray bold">WHAT CAN I DO NOW?</td>
        <? if($m_id!=$p_id){

           $sql_query2="select bmr_id from bmarks where mem_id='$m_id' and type='member' and sec_id='$p_id'";
           $num=sql_execute($sql_query2,'num');
           if($num==0){
           ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=bmarks&pro=add&sec_id=<? echo $p_id; ?>&type=member">
           Bookmark <? echo name_header($p_id,$m_id); ?>
           </a></td>
           <? } else{
           $bmr=sql_execute($sql_query2,'get'); ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=bmarks&pro=del&bmr_id=<? echo $bmr->bmr_id; ?>">
           Un-Bookmark <? echo name_header($p_id,$m_id); ?>
           </a></td>
           <? } ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=messages&act=compose&rec_id=<? echo $p_id; ?>">
           Send <? echo name_header($p_id,$m_id); ?> a message
           </a></td>
           <? $sql_query="select mem_id from network where mem_id='$m_id' and frd_id='$p_id'";
           $num=sql_execute($sql_query,'num');
           if($num!=0){
           ?>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=user&act=friends&pro=remove&frd_id=<? echo $p_id; ?>">
           Remove <? echo name_header($p_id,$m_id); ?> from friends
           </a></td>
           <?
           }
           else {
           ?>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=user&act=friends&pro=add&frd_id=<? echo $p_id; ?>">
           Add <? echo name_header($p_id,$m_id); ?> as a friend
           </a></td>
           <?
           }
           ?>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=user&act=intro&p_id=<? echo $p_id; ?>">
           Make an Intro
           </a></td>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=user&act=invite_tribe&p_id=<? echo $p_id; ?>">
           Invite <? echo name_header($p_id,$m_id); ?> to group
           </a></td>
           <?
           $sql_query="select ignore_list from members where mem_id='$m_id'";
      	   $mem=sql_execute($sql_query,'get');
	              $ignore=split("\|",$mem->ignore_list);
	              $ignore=if_empty($ignore);
                  if($ignore!=''){
                  $status=0;
	              foreach($ignore as $ign){
	                  if($ign==$p_id){
	                   $status=1;
                       break;
	                  }
	              }//foreach
                  }//if
                  else {
                     $status=0;
                  }//else
           if($status==0){
           ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=ignore&pro=add&p_id=<? echo $p_id; ?>">
           Ignore <? echo name_header($p_id,$m_id); ?>
           </a></td>
           <? } elseif($status==1){ ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=ignore&pro=del&p_id=<? echo $p_id; ?>">
           Un-Ignore <? echo name_header($p_id,$m_id); ?>
           </a></td>
           <? } ?>
        <?
        }
        else {
        ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=profile&pro=edit">
           Edit your profile
           </a></td>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=bmarks">
           Edit your bookmarks
           </a></td>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=ignore">
           Edit your igore list
           </a></td>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=user&act=listings">
           View your Listings
           </a></td>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=user&act=friends">
           View your Friends
           </a></td>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=listing&act=create">
           Create a Listing
           </a></td>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=messages&act=inbox">
           View your Message Center
           </a></td>
        <?
        }
        ?>
        </table></td>
             <?
             //setting user's bookmarks
     $sql_query="select * from bmarks where mem_id='$m_id'";
     $num=sql_execute($sql_query,'num');
     if($num==0){
     }
     else {
        echo "     <tr><td>
        <table class='td-shade lined body' width=100%>
             <tr><td bgcolor=white class='bodygray bold'>My Bookmarks</td>";
       $res=sql_execute($sql_query,'res');
       while($bmr=mysql_fetch_object($res)){

              if($bmr->type=="member"){

                  echo "<tr><td>
                  <img src='images/medicon_person.gif' border=0>
                  <a href='index.php?mode=people_card&p_id=$bmr->sec_id'>".
                  name_header($bmr->sec_id,$m_id)."</a>
                  </td>";

              }//if

              elseif($bmr->type=="listing"){

                  $sql_query="select title from listings where lst_id='$bmr->sec_id'";
                  $lst=sql_execute($sql_query,'get');

                  echo "<tr><td>
                  <img src='images/icon_listing.gif' border=0>
                  &nbsp&nbsp<a href='index.php?mode=listing&act=show&lst_id=$bmr->sec_id'>".
                  $lst->title."</a>
                  </td>";

              }//elseif

              elseif($bmr->type=="tribe"){

                  $sql_query="select name from tribes where trb_id='$bmr->sec_id'";
                  $trb=sql_execute($sql_query,'get');

                  echo "<tr><td>
                  <img src='images/medicon_tribe.gif' border=0>
                  <a href='index.php?mode=tribe&act=show&trb_id=$bmr->sec_id'>".
                  $trb->name."</a>
                  </td>";

              }//elseif

       }//while

     }//else
             ?>



        </table>
    </td>
    </table>
</td>
</table>
<?
show_footer();
}

function professional_profile(){
$p_id=form_get("p_id");
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
show_header();
?>
<table width=100%>
<tr><td>
<table class="lined body" width=100%>
<tr><td class="padded-6">
    <table width=100% class="body">
    <tr><td class="lined" width=110>
    <a href="index.php?mode=people_card&p_id=<? echo $p_id; ?>">Basics</a>
    </td>
    <td class="lined" width=110>
    <a href="index.php?mode=people_card&p_id=<? echo $p_id; ?>&act=pers">Personal</a>
    </td>
    <td class="lined-top lined-left lined-right" width=110>
    <b><a href="index.php?mode=people_card&p_id=<? echo $p_id; ?>&act=prof">Professional</a></b>
    </td>
    <td align=right class='maingray'>updated
    <? echo show_profile_updated($p_id);
    if($p_id==$m_id){ ?>
    &nbsp<span class=action><a href='index.php?mode=user&act=profile&pro=edit'>edit</a></span>
    <? } ?>
    </td>
    <tr><td colspan=4>
    	<table width=100%>
        <tr><td>
            <table class="body">
            <tr><td class="lined" align=center>
            <? show_profile_photo($p_id); ?>
            </br>
            <? show_online($p_id); ?></br>
            <? photo_album_link($p_id); ?></br>
            </td>
            <tr><td class=lined>
            </br>
            <a href="index.php?mode=people_card&act=friends&p_id=<? echo $p_id; ?>">
            <? echo count_network($p_id,"1","num"); ?> Friends
            </a>
            </br>
            <a href='index.php?mode=people_card&act=network&p_id=<? echo $p_id; ?>'><? echo count_network($p_id,"all","num"); ?> in Network</a>
            </br>
            Member since <? echo member_since($p_id); ?>
            </td>
            </table>
        </td>
        <td valign=top width=50%>
            <table class="body" align=left>
            <tr><td colspan=2 class="orangeheader"><? echo name_header($p_id,$m_id); ?></td>
            <? show_profile($p_id,"professional"); ?>
            </table>
        </td>
    	</table>
        <tr><td valign=top colspan=4>
        <table width=100%><tr><td valign=top rowspan=2>
        <table class="body" width=100%>
        <tr><td class="lined title"><? echo name_header($p_id,$m_id); ?>'s Friends</a></span></td>
        <tr><td class="lined"><table width=100%><? show_friends($p_id,"6","2","1"); ?></table></td>
        </table>
        </td>
        <td valign=top height=100%><table class='body' width=100% height=100%>
        <tr><td class="lined title">Listings From <? echo name_header($p_id,$m_id); ?> & Friends</td>
        <tr><td class=lined height=100% valign=top>
        </br>
        <? show_listings("inprofile",$p_id,''); ?>
        </br>
        </td></table></td>
        <tr><td width=100% valign=bottom>
        <table class="body" width=100% height=100%>
        <tr><td class="lined title">Testimonials for <? echo name_header($p_id,$m_id); ?></td>
        <tr><td class="lined" height=100%><? show_testimonials($p_id,$m_id); ?></td>
        <?
          $sql_query="select mem_id from network where mem_id='$p_id' and frd_id='$m_id'";
          $num=sql_execute($sql_query,'num');
          if(($num!=0)&&($p_id!=$m_id)){
           echo "<tr><td class='lined body'>
           <table class='body'>
           <tr><td>Tell others how you feel about ";echo name_header($p_id,$m_id);echo "</td>
           <td><input type='button' onClick='window.location=\"index.php?mode=user&act=tst&p_id=$p_id\"' value='Write a Testimonial'></td>
           </table>
           </td>";
          }
        ?>
        </table></td>
        </table>
        </td>
    </td>
    </table>
</td>
</table>
</td>
<td valign=top>
	<table class="body">
    <tr><td><table class="lined body">
    <tr><td class=lined><? show_photo($m_id); ?></br>
    <? show_online($m_id); ?>
    </td>
    <td>Member Since <? echo member_since($m_id); ?>
    </br></br>
    <a href='index.php?mode=people_card&act=friends&p_id=<? echo $m_id; ?>'><? echo count_network($m_id,"1","num"); ?> Friends</a></br>
    <a href='index.php?mode=people_card&act=network&p_id=<? echo $m_id; ?>'><? echo count_network($m_id,"all","num"); ?> in my Network</a></br>&nbsp
    </td>
    </table></td>
    <tr><td>
        <table class="shade lined body" width=100%>
        <tr><td bgcolor=white class="bodygray bold">WHAT CAN I DO NOW?</td>
        <? if($m_id!=$p_id){

           $sql_query2="select bmr_id from bmarks where mem_id='$m_id' and type='member' and sec_id='$p_id'";
           $num=sql_execute($sql_query2,'num');
           if($num==0){
           ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=bmarks&pro=add&sec_id=<? echo $p_id; ?>&type=member">
           Bookmark <? echo name_header($p_id,$m_id); ?>
           </a></td>
           <? } else{
           $bmr=sql_execute($sql_query2,'get'); ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=bmarks&pro=del&bmr_id=<? echo $bmr->bmr_id; ?>">
           Un-Bookmark <? echo name_header($p_id,$m_id); ?>
           </a></td>
           <? } ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=messages&act=compose&rec_id=<? echo $p_id; ?>">
           Send <? echo name_header($p_id,$m_id); ?> a message
           </a></td>
           <? $sql_query="select mem_id from network where mem_id='$m_id' and frd_id='$p_id'";
           $num=sql_execute($sql_query,'num');
           if($num!=0){
           ?>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=user&act=friends&pro=remove&frd_id=<? echo $p_id; ?>">
           Remove <? echo name_header($p_id,$m_id); ?> from friends
           </a></td>
           <?
           }
           else {
           ?>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=user&act=friends&pro=add&frd_id=<? echo $p_id; ?>">
           Add <? echo name_header($p_id,$m_id); ?> as a friend
           </a></td>
           <?
           }
           ?>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=user&act=intro&p_id=<? echo $p_id; ?>">
           Make an Intro
           </a></td>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=user&act=invite_tribe&p_id=<? echo $p_id; ?>">
           Invite <? echo name_header($p_id,$m_id); ?> to group
           </a></td>
           <?
           $sql_query="select ignore_list from members where mem_id='$m_id'";
      	   $mem=sql_execute($sql_query,'get');
	              $ignore=split("\|",$mem->ignore_list);
	              $ignore=if_empty($ignore);
                  if($ignore!=''){
                  $status=0;
	              foreach($ignore as $ign){
	                  if($ign==$p_id){
	                   $status=1;
                       break;
	                  }
	              }//foreach
                  }//if
                  else {
                     $status=0;
                  }//else
           if($status==0){
           ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=ignore&pro=add&p_id=<? echo $p_id; ?>">
           Ignore <? echo name_header($p_id,$m_id); ?>
           </a></td>
           <? } elseif($status==1){ ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=ignore&pro=del&p_id=<? echo $p_id; ?>">
           Un-Ignore <? echo name_header($p_id,$m_id); ?>
           </a></td>
           <? } ?>
        <?
        }
        else {
        ?>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=profile&pro=edit">
           Edit your profile
           </a></td>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=bmarks">
           Edit your bookmarks
           </a></td>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=user&act=ignore">
           Edit your igore list
           </a></td>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=user&act=listings">
           View your Listings
           </a></td>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=user&act=friends">
           View your Friends
           </a></td>
           <tr><td><img src="images/medicon_network.gif"><a href="index.php?mode=listing&act=create">
           Create a Listing
           </a></td>
           <tr><td><img src="images/medicon_person.gif"><a href="index.php?mode=messages&act=inbox">
           View your Message Center
           </a></td>
        <?
        }
        ?>
        </table></td>
             <?
             //setting user's bookmarks
     $sql_query="select * from bmarks where mem_id='$m_id'";
     $num=sql_execute($sql_query,'num');
     if($num==0){
     }
     else {
        echo "     <tr><td>
        <table class='td-shade lined body' width=100%>
             <tr><td bgcolor=white class='bodygray bold'>My Bookmarks</td>";
       $res=sql_execute($sql_query,'res');
       while($bmr=mysql_fetch_object($res)){

              if($bmr->type=="member"){

                  echo "<tr><td>
                  <img src='images/medicon_person.gif' border=0>
                  <a href='index.php?mode=people_card&p_id=$bmr->sec_id'>".
                  name_header($bmr->sec_id,$m_id)."</a>
                  </td>";

              }//if

              elseif($bmr->type=="listing"){

                  $sql_query="select title from listings where lst_id='$bmr->sec_id'";
                  $lst=sql_execute($sql_query,'get');

                  echo "<tr><td>
                  <img src='images/icon_listing.gif' border=0>
                  &nbsp&nbsp<a href='index.php?mode=listing&act=show&lst_id=$bmr->sec_id'>".
                  $lst->title."</a>
                  </td>";

              }//elseif

              elseif($bmr->type=="tribe"){

                  $sql_query="select name from tribes where trb_id='$bmr->sec_id'";
                  $trb=sql_execute($sql_query,'get');

                  echo "<tr><td>
                  <img src='images/medicon_tribe.gif' border=0>
                  <a href='index.php?mode=tribe&act=show&trb_id=$bmr->sec_id'>".
                  $trb->name."</a>
                  </td>";

              }//elseif

       }//while

     }//else
             ?>



        </table>
    </td>
    </table>
</td>
</table>
<?
show_footer();
}
?>