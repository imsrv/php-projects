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
 do_log_in();
}
elseif($act=='logout'){
 do_log_out();
}
elseif($act=='home'){
 home_page();
}
elseif($act=='menu_err'){
 menu_error();
}
elseif($act=='menu_up'){
 menu_up();
}
elseif($act=='form'){
 login_form();
}

function login_form(){
show_header();
?>
  <table width=100% class='body'>
       <tr><td class='lined title'>Members Login</td>
       <tr><td>
            <table align=center class='body'>
            <form action='index.php' method='post'>
            <input type='hidden' name='mode' value='login'>
                <tr><td>E-mail</td><td>
                  <input type='text' name='email' size="20"></td>
                <tr><td>Password</td><td>
                  <input type='password' name='password' size="20"></td>
                <tr><td><input type='checkbox' name='remember' value="ON"></td><td>Remember me</td>
                <tr><td><a href='index.php?mode=forgot'>Forget your password?</a></td>
                <td><input type='submit' value='Sign In'></td>
            </table></form>
       </td>
  </table>
<?
show_footer();
}//function

function do_log_in(){
global $main_url,$cookie_url,$PHPSESSID;
if($PHPSESSID!=''){
if(session_unset($PHPSESSID)){
session_destroy($PHPSESSID);
}//if
}//if
$email=form_get("email");
$password=form_get("password");
$rem=form_get("remember");
//crypting pass and checking
$crypass=md5($password);
$sql_query="select mem_id,password,ban,current,verified,email,mem_stat,pay_stat,mem_acc from members where email='$email'";
$mem=sql_execute($sql_query,'get');
//if pass is incorrect
if($mem->password!=$crypass){
 error_screen(0);
}
//if user is banned
elseif($mem->ban=='y'){
 error_screen(8);
}
//if user payment is not success
elseif($mem->mem_stat=='P'){
	if($mem->pay_stat=='N')	error_screen(34);
}
//if account is verified
elseif($mem->verified!='y'){
 error_screen(16);
}
//if user want to be remembered
if($rem!='1'){
 $time=time()+3600*24;
}
else{
 $time=time()+3600*24*365;
}
//setting cookies and updating db
$sql_type="select * from member_package where package_id=$mem->mem_acc";
$res_type=mysql_query($sql_type);
$type=mysql_fetch_object($res_type);
SetCookie("mem_list",$type->package_list,$time,"/",$cookie_url);
SetCookie("mem_grop",$type->package_grp,$time,"/",$cookie_url);
SetCookie("mem_eve",$type->package_eve,$time,"/",$cookie_url);
SetCookie("mem_blog",$type->package_blog,$time,"/",$cookie_url);
SetCookie("mem_chat",$type->package_chat,$time,"/",$cookie_url);
SetCookie("mem_forum",$type->package_forum,$time,"/",$cookie_url);
SetCookie("mem_phot",$type->package_nphot,$time,"/",$cookie_url);
SetCookie("mem_type",$mem->mem_stat,$time,"/",$cookie_url);
SetCookie("mem_acc",$mem->mem_acc,$time,"/",$cookie_url);
SetCookie("mem_id",$mem->mem_id,$time,"/",$cookie_url);
SetCookie("mem_pass",$mem->password,$time,"/",$cookie_url);
SetCookie("mem_em",$mem->email,$time,"/",$cookie_url);
$now=time();
$sql_query="update members set online='on',visit='$mem->current',current='$now',history='' where mem_id='$mem->mem_id'";
sql_execute($sql_query,'');
$sql_query="update stats set day_sgnin=day_sgnin+1,week_sgnin=week_sgnin+1,month_sgnin=month_sgnin+1";
sql_execute($sql_query,'');
$link=$main_url."/index.php?mode=login&act=home";
show_screen($link);
}

function do_log_out(){
global $main_url,$cookie_url;
$m_id=cookie_get("mem_id");
$name=cookie_get("mem_em");
$sql_query="update members set online='off' where mem_id='$m_id'";
sql_execute($sql_query,'');
$sql_query="delete from chat_users where name='$name'";
//echo $sql_query;
sql_execute($sql_query,'');
$sql_query="delete from chat_messages where name='$name'";
//echo $sql_query;
sql_execute($sql_query,'');
//deleting cookies and redirecting to main page
SetCookie("mem_id","",time()-10,"/",$cookie_url);
SetCookie("mem_pass","",time()-10,"/",$cookie_url);
SetCookie("mem_em","",time()-10,"/",$cookie_url);
SetCookie("mem_list","",time()-10,"/",$cookie_url);
SetCookie("mem_grop","",time()-10,"/",$cookie_url);
SetCookie("mem_eve","",time()-10,"/",$cookie_url);
SetCookie("mem_blog","",time()-10,"/",$cookie_url);
SetCookie("mem_chat","",time()-10,"/",$cookie_url);
SetCookie("mem_forum","",time()-10,"/",$cookie_url);
SetCookie("mem_phot","",time()-10,"/",$cookie_url);
SetCookie("mem_type","",time()-10,"/",$cookie_url);
SetCookie("mem_acc","",time()-10,"/",$cookie_url);
show_screen($main_url);
}

function home_page(){
global $main_url,$base_path;
$m_id=cookie_get("mem_id");
$m_pass=cookie_get("mem_pass");
login_test($m_id,$m_pass);
$sql_query="select * from members where mem_id='$m_id'";
$mem=sql_execute($sql_query,'get');
$tribes=split("\|",$mem->tribes);
$tribes=if_empty($tribes);
show_header();
?>
<table width=100%>
<tr><td width=250 valign=top>
<table width=100% class="lined body">
<tr><td class="dark padded-6" valign="top" align=center width=65><? show_photo($m_id); ?></br>
<? show_online($m_id); ?>
</td>
<td valign=top class="padded-6">
Welcome, <? echo "$mem->fname $mem->lname";?></br>
<? show_views($m_id); ?> views on you.
<? show_views_visit($m_id); ?> since last visit on <? show_visit($m_id); ?></br></br>
<span class="title-box">
<a href="index.php?mode=people_card&p_id=<? echo $m_id; ?>">My Profile</a>&nbsp&nbsp<span class='action'><a href='index.php?mode=user&act=profile&pro=edit'>edit</a></span></br>
<a href="index.php?mode=user&act=inv_db">Invitations I've sent</a></br>
<a href="index.php?mode=user&act=bmarks">My Bookmarks</a></br>
<a href="index.php?mode=user&act=ignore">My Ignore List</a></br>
</span></table>
</br>
<table width=100% class='body'>
<tr><td colspan=2 class='dark header1 post-color1'>Action Items</td>
<tr><td colspan=2><table width=100% class="body post-color2 lined">
<? show_action($m_id); ?>
</table></td>
</table>
<table width=100% class='body'>
<tr><td colspan=2 class='dark header1 post-color1'>My Network</td>
<tr><td colspan=2><table width=100% class="body post-color2 lined">
<tr><td colspan=2 class='bold'>People</td>
<tr><td><? echo count_network($m_id,"1","num"); ?></td>
<td><a href='index.php?mode=user&act=friends_view&pro=1'><b>friends</b></a> (1&deg)</td>
<tr><td><? echo count_network($m_id,"2","num"); ?></td>
<td><a href='index.php?mode=user&act=friends_view&pro=2'><b>friends</b></a> of friends (2&deg)</td>
<tr><td><? echo count_network($m_id,"3","num"); ?></td>
<td><a href='index.php?mode=user&act=friends_view&pro=3'><b>people</b></a> 3 degrees away</td>
<tr><td><? echo count_network($m_id,"4","num"); ?></td>
<td><a href='index.php?mode=user&act=friends_view&pro=4'><b>people</b></a> 4 degrees away</td>
<tr><td colspan=2 height=1 bgcolor=black></td>
<tr><td><? echo count_network($m_id,"all","num"); ?></td>
<td><a href='index.php?mode=user&act=friends_view&pro=all'><b>person</b></a> in my network</td>
<tr><td colspan=2 align=right><a href="index.php?mode=user&act=inv"><b>Grow your Network</b> <img src="images/icon_action.gif" border=0></a></td>
<tr><td colspan=2>&nbsp;</td>
<? if ($tribes!=''){
echo "</td></table>";
echo "<tr><td colspan=2 class='dark header1 post-color1'>Events</td>";
echo "<tr><td colspan=2><table width=100% class='body post-color2 lined'>";
echo "<tr><td class='padded-6'>";
    foreach($tribes as $trb){
    //showing events of user's tribes
                 $sql_query="select * from events where trb_id='$trb'";
                 $res=sql_execute($sql_query,'res');
                 $sql_query="select name from tribes where trb_id='$trb'";
                 $nam=sql_execute($sql_query,'get');

                 while($evn=mysql_fetch_object($res)){
                    $date=date("m/d/Y",$evn->start_date);
                    echo "<a href='index.php?mode=tribe&act=event&pro=view&evn_id=$evn->evn_id&trb_id=$trb'>$evn->title</a> $date";
                    $start_time=date("h:i A",$evn->start_time);
                    if($evn->start_time!='0'){
                       echo " @ $start_time ";
                    }
                    echo "(<a href='index.php?mode=tribe&act=show&trb_id=$trb'>$nam->name</a>)";
                    if($m_id==$evn->mem_id){
                    echo "&nbsp<span class='action'><a href='index.php?mode=tribe&act=event&pro=del&evn_id=$evn->evn_id&trb_id=$trb&home=1'>delete</a></span>";
                    }//if
                    echo "</br>";
                 }//while
    }//foreach
echo "</td>";
echo "</td></table>";
echo "<tr><td colspan=2 class='dark header1 post-color1'>My Group</td>";
echo "<tr><td colspan=2><table width=100% class='body post-color2 lined'>";
echo "<tr><td class='padded-6'>";
reset($tribes);
    foreach($tribes as $trb){
    //showing user's tribes list
                 $sql_query="select name,mem_num from tribes where trb_id='$trb'";
                 $name=sql_execute($sql_query,'get');
                 echo "<b><a href='index.php?mode=tribe&act=show&trb_id=$trb'>$name->name</a></b></br>";
                 echo "$name->mem_num members, ".tribe_new_posts($m_id,$trb)."</br></br>";
    }
echo "</td>";
echo "<tr><td colspan=2 class='bold'>People</td>
<tr><td colspan=2>
Groups bring people together around an interest, team, hobby or just about anything.
<a href='index.php?mode=tribe'>Join or start a Group now.</a>
</td>
<tr><td colspan=2 align=right><a href='index.php?mode=tribe'><b>Browse Groups</b> <img src='images/icon_action.gif' border=0></a></td>";
}
?>
</table></td>
</table>
</td>
<td valign=top>
<table width=100% class="system_message body">
<tr><td><img src="images/bigicon_system_message.gif" border=0></td>
<td><? show_tip(); ?></td>
</table>
<table cellpadding=0 cellspacing=0>
<tr>
  <td class="title lined-left lined-top lined-bottom" bgcolor="#C0C0C0">Find 
  Friends</td>
<td align=right class="title-link lined-right lined-top lined-bottom" bgcolor="#C0C0C0">
<a href="index.php?mode=user&act=inv">Invite Friends&gt;&gt;</a></td>
</tr>
<tr>
  <td class="lined title" colspan=2 align=center>
<form action="index.php" method="post">
	        <input type=hidden name="mode" value="search">
	        <input type=hidden name="act" value="user">
	        <input type=hidden name="type" value="basic">
<p align="left" style="margin-top: 0; margin-bottom: 0"><strong style="font-weight: 400">
Grow your network.</strong> Search for people you know, or invite friends who 
haven't registered yet.</p>


</td>
</tr>
<tr>
  <td class="lined title" colspan=2 align=center>
<p style="margin-top: 0; margin-bottom: 0">First Name 
<input size="10" name="fname"> Last Name <input size="10" name="lname"> Email 
<input size="10" name="email">

<input type="submit" value="Go"></form></p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;</td>
</tr>
<tr>
  <td class="title lined-left lined-top lined-bottom" bgcolor="#C0C0C0">Join 
  Groups</td>
<td align=right class="title-link lined-right lined-top lined-bottom" bgcolor="#C0C0C0">
<a href="index.php?mode=tribe">Groups Directory&gt;&gt;</a></td>
</tr>
<tr>
  <td class="lined title" colspan=2 align=center>
<form action="index.php" method="post">
               <input type=hidden name="mode" value="search">
			   <input type=hidden name="act" value="tribe">
			   <input type=hidden name="type" value="normal">
<p align="left" style="margin-top: 0; margin-bottom: 0">
<strong style="font-weight: 400">What's a Group?</strong> People connect through 
Groups around an interest, school, team, hobby, or just about anything.</p>


</td>
</tr>
<tr>
  <td class="lined title" colspan=2 align=center>
<p style="margin-top: 0; margin-bottom: 0">Search Groups 
<input size="20" name="keywords" value="Enter Keywords">

<input type="submit" value="Go"></form></p>
<p style="margin-top: 0; margin-bottom: 0">&nbsp;</td>
</tr>
<tr><td class="title lined-left lined-top lined-bottom" bgcolor="#C0C0C0">Recent listings from My 
  Network</td>
<td align=right class="title-link lined-right lined-top lined-bottom" bgcolor="#C0C0C0"><a href="index.php?mode=listing&act=all">
View All&gt;&gt;</a></td>
<tr><td class="lined title" colspan=2 align=center>
<form action="index.php" method="post">
<input type=hidden name='mode' value='listing'>
<input type=hidden name='act' value='filter'>
Within <select name="distance">
<option value="any">any distance
<option value="5">5 miles
<option value="10">10 miles
<option value="25">25 miles
<option value="100">100 miles
</select>
of <input type="text" name="zip" size=5 value="<? echo $mem->zip; ?>">,
lister is <select name="degrees">
<option value="any">anyone
<option value="4">within 4&deg of me
<option value="3">within 3&deg of me
<option value="2">within 2&deg of me
<option value="1">a friend
</select>
<input type="submit" value="Go"></form>
</td>
<tr><td colspan=2 class="lined">
<? show_listings("recent",$m_id,''); ?></br>
<table class="lined bodytip">
<tr><td class="dark">Tip</td><td class="td-shade">Listings are the easy way to get help from your friends. Create one now. </td>
<td><input type="button" onClick="window.location='index.php?mode=listing&act=create'" value="Create A Listing"></td>
</table>
</br>
<table class="body" width=100%>
<tr><td class='lined'><table width=100% class="body" cellpadding=0 cellspacing=0>
<tr><td class="title" bgcolor="#C0C0C0">My Friends</td>
<td align=right class="title-link lined-right lined-top lined-bottom" bgcolor="#C0C0C0"><a href='index.php?mode=user&act=friends'>View 
All >></a></td></table>
<tr><td class="lined"><table><? show_friends($m_id,"12","6","1"); ?></table></td>
</table>
</td>
</table>
</td>
</table>
<?
show_footer();
}

//views on user
function show_views($m_id){
$sql_query="select views from members where mem_id='$m_id'";
$mem=sql_execute($sql_query,'get');
$views=split("\|",$mem->views);
$views=if_empty($views);
$num=count($views);
echo $num;
}

//views on user since last visit
function show_views_visit($m_id){
$sql_query="select views,visit from members where mem_id='$m_id'";
$mem=sql_execute($sql_query,'get');
$views=split("\|",$mem->views);
$views=if_empty($views);
$views_visit=array();
if($views!=''){
foreach ($views as $view){
 if($view>=$mem->visit){
  array_push($views_visit,$view);
 }
 }
 }
$num=count($views_visit);
echo $num;
}

//showing when user visited site last time
function show_visit($m_id){
$sql_query="select visit from members where mem_id='$m_id'";
$mem=sql_execute($sql_query,'get');
$visit=date("m/d",$mem->visit);
echo $visit;
}

//showing action items
function show_action($m_id){
	$sql_query1="select mes_id,frm_id from messages_system where type='friend' and mem_id='$m_id'";
	$num1=sql_execute($sql_query1,'num');
    $num2=mes_num($m_id);
    $sql_query3="select from_id,tst_id from testimonials where mem_id='$m_id' and stat='w'";
    $num3=sql_execute($sql_query3,'num');
    $sql_query4="select mes_id,frm_id,special from messages_system where type='trb_inv' and mem_id='$m_id'";
    $num4=sql_execute($sql_query4,'num');
    $sql_query5="select mes_id,frm_id,special from messages_system where type='trb_req' and mem_id='$m_id'";
    $num5=sql_execute($sql_query5,'num');

    //if there are tribe requests
    if($num5!=0){

	    $res=sql_execute($sql_query5,'res');
        while($frd=mysql_fetch_object($res)){

            $sql_query67="select name from tribes where trb_id='$frd->special'";
            $trb=sql_execute($sql_query67,'get');

            echo "<tr><td><img src='images/bigicon_exclam.gif' border=0></td><td>";
            echo name_header($frd->frm_id,$m_id);echo " wants to join $trb->name.";
            echo "<span class='action'><a href='index.php?mode=messages&act=view_trb_req&trb_req_id=$frd->mes_id'>view</a></span>";
            echo "</td>";

        }//while

    }//if
    //if there are tribe invitations
    if($num4!=0){

	    $res=sql_execute($sql_query4,'res');
        while($frd=mysql_fetch_object($res)){

            $sql_query="select name from tribes where trb_id='$frd->special'";
            $trb=sql_execute($sql_query,'get');

            echo "<tr><td><img src='images/bigicon_exclam.gif' border=0></td><td>";
            echo name_header($frd->frm_id,$m_id);echo " has invited you to join $trb->name.";
            echo "<span class='action'><a href='index.php?mode=messages&act=view_trb_inv&trb_inv_id=$frd->mes_id'>view</a></span>";
            echo "</td>";

        }//while

    }//if
    //new messages
    if($num2!=0){

        echo "<tr><td><img src='images/bigicon_exclam.gif' border=0></td><td>";
		echo "You have "; echo mes_num($m_id);echo " new messages in your inbox.
		<span class='action'><a href='index.php?mode=messages&act=inbox'>view</a></span>";
        echo "</td>";

    }//if
    //friendship invitations
	if($num1!=0){

	    $res=sql_execute($sql_query1,'res');
        while($frd=mysql_fetch_object($res)){

            echo "<tr><td><img src='images/bigicon_exclam.gif' border=0></td><td>";
            echo name_header($frd->frm_id,$m_id);echo " has invited you to join his network.";
            echo "<span class='action'><a href='index.php?mode=messages&act=view_inv&inv_id=$frd->mes_id'>view</a></span>";
            echo "</td>";

        }//while

	}//if
    //testimonal needs approval
    if($num3!=0){

        $res2=sql_execute($sql_query3,'res');
        while($tst=mysql_fetch_object($res2)){

            echo "<tr><td><img src='images/bigicon_exclam.gif' border=0></td><td>";
            echo name_header($tst->from_id,$m_id);echo " has written a testimonial that needs your approval.";
            echo "<span class='action'><a href='index.php?mode=messages&act=view_tst&tst_id=$tst->tst_id'>view</a></span>";
            echo "</td>";

        }//while

    }//if

}//function
function menu_error(){
 error_screen(35);
}//function
function menu_up(){
 error_screen(36);
}//function
?>