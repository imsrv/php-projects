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
  users_list();
}
elseif($act=='edi'){
  $pro=form_get("pro");
  if($pro==''){
  edit_user(0);
  }
  else {
  edit_user(1);
  }
}
elseif($act=='del'){
  delete_user();
}
elseif($act=='ban'){
  ban_user();
}
elseif($act=='eml'){
  email_user();
}
elseif($act=='unban'){
  unban_user();
}
elseif($act=='emlall'){
  email_all();
}

function users_list(){
$adsess=form_get("adsess");
admin_test($adsess);

show_ad_header($adsess);
?>
   <table width=100%>
   <tr><td class='lined title'>Admin: Users Manager</td>
   <tr><td class='lined padded-6'>
   <table class='body' width=100%>

         <?
         $page=form_get("page");
         if($page==''){
           $page=1;
         }
         $start=($page-1)*20;
           $sql_query="select mem_id,fname,lname,email,ban,mem_acc from members limit $start,20";
           $res=sql_execute($sql_query,'res');
           $num=sql_execute($sql_query,'num');
           if($num==0){
              echo "<tr><td align=center>No users in the system.</td><tr><td>";
           }//if
           else {
           echo "<form action='admin.php' method=post>
           <input type=hidden name='mode' value='users_manager'>
           <input type=hidden name='act' value=''>
           <input type=hidden name='adsess' value='$adsess'>
           <tr><td>Select</td><td>First Name</td><td>Last Name</td><td>E-mail</td><td>Membership</td><td>Ban</td>";
              while($mem=mysql_fetch_object($res)){
			  	if($mem->mem_acc==0)	$dis_acc="Free Member";
				else	$dis_acc=acc_nam($mem->mem_acc);
                 echo "<tr><td><input type=checkbox name='mem_id[]' value='$mem->mem_id'></td>
                 <td>$mem->fname</td><td>$mem->lname</td><td><span class='action'><a href='admin.php?mode=users_manager&act=edi&mem_id=$mem->mem_id&adsess=$adsess'>$mem->email</a></span></td><td>$dis_acc</td>";
                 if($mem->ban!='y'){
                    echo "<td>Not Banned.</td>";
                 }//if
                 else{
                    echo "<td><span class='action'><a href='admin.php?mode=users_manager&act=unban&adsess=$adsess&mem_id=$mem->mem_id'>Unban</a></span></td>";
                 }//else
              }//while
           echo "<tr><td colspan=6 align=center class='lined'>";pages_line("$adsess","ad_users","$page","20");echo "</td>";
           echo "<tr><td colspan=6><input type='submit' value='Delete Users' onclick='javascript:this.form.act.value=\"del\"'>
           &nbsp<input type='submit' value='Ban Users' onclick='javascript:this.form.act.value=\"ban\"'>
           &nbsp<input type='submit' value='Email Users' onclick='javascript:this.form.act.value=\"eml\"'>";
           }//else

         ?>
   &nbsp<input type='button' value='Email All' onclick='window.location="admin.php?mode=users_manager&act=emlall&adsess=<? echo $adsess; ?>"'></td></form>
   </table>
   </td>
   </table>
<?
show_footer();
}//function

function delete_user(){
$adsess=form_get("adsess");
admin_test($adsess);

$mem_id=form_get("mem_id");
if(!empty($mem_id))	{
	foreach($mem_id as $mid){
	$sql_query="select photo,photo_thumb,photo_b_thumb from photo where mem_id='$mid'";
	$pho=sql_execute($sql_query,'get');
	$photos=split("\|",$pho->photo);
	$photosth=split("\|",$pho->photo_thumb);
	$photosbth=split("\|",$pho->photo_b_thumb);
	$photos=if_empty($photos);
	if($photos!=''){
	for($i=0;$i<count($photos);$i++){
	  if(file_exists($photos[$i])){
	     unlink($photos[$i]);
	  }
	  if(file_exists($photosth[$i])){
	     unlink($photosth[$i]);
	  }
	  if(file_exists($photosbth[$i])){
	     unlink($photosbth[$i]);
	  }
	}//for
	}//if

	$sql_query="select tribes from members where mem_id='$mid'";
	$mem=sql_execute($sql_query,'get');
	$tribes=split("\|",$mem->tribes);
	$tribes=if_empty($tribes);
	if($tribes!=''){
	  foreach($tribes as $tribe){
	      $sql_query="select members from tribes where trb_id='$tribes'";
	      $mems=sql_execute($sql_query,'get');
	      $membs=split("\|",$mems->members);
	      $line='';
	      foreach($membs as $one){
	          if($one!=$mid){
	             $line.="|$one";
	          }//if
	      }//foreach
	      $sql_query="update tribes set members='$line' where trb_id='$tribe'";
	      sql_execute($sql_query,'');
	  }//foreach
	}//if
	
	$sql_query="select top_id from board where mem_id='$mid'";
	$res=sql_execute($sql_query,'res');
	while($brd=mysql_fetch_object($res)){
	    $sql_query="delete from replies where top_id='$brd->top_id'";
	    sql_execute($sql_query,'');
	}//while

	$sql_query="select * from blogs where blog_own='$mid'";
	$num=sql_execute($sql_query,'num');
	if($num!=0)	{
		while($row_img=mysql_fetch_object($res)){
		    $pic_out="../".$row_img->blog_img;
			if(file_exists($pic_out))	@unlink($pic_out);
		}//while
	}//If
	$sql_query="select * from members where mem_id='$mid'";
	$mem=sql_execute($sql_query,'get');
	$pic_file="../blog/".$mem->profilenam."/index.php";
	if(file_exists($pic_file))	@unlink($pic_file);
	@rmdir("../blog/".$mem->profilenam);

   $sql_query="delete from members where mem_id='$mid'";
   sql_execute($sql_query,'');
   $sql_query="delete from bmarks where mem_id='$mid'";
   sql_execute($sql_query,'');
   $sql_query="delete from profiles where mem_id='$mid'";
   sql_execute($sql_query,'');
   $sql_query="delete from testimonials where mem_id='$mid'";
   sql_execute($sql_query,'');
   $sql_query="delete from messages_system where mem_id='$mid' or frm_id='$mid'";
   sql_execute($sql_query,'');
   $sql_query="delete from network where mem_id='$mid' or frd_id='$mid'";
   sql_execute($sql_query,'');
   $sql_query="delete from photo where mem_id='$mid'";
   sql_execute($sql_query,'');
   $sql_query="delete from listings where mem_id='$mid'";
   sql_execute($sql_query,'');
   $sql_query="delete from tribes where mem_id='$mid'";
   sql_execute($sql_query,'');
   $sql_query="delete from events where mem_id='$mid'";
   sql_execute($sql_query,'');
   $sql_query="delete from board where mem_id='$mid'";
   sql_execute($sql_query,'');
   $sql_query="delete from blogs where blog_own='$mid'";
   sql_execute($sql_query,'');
   $sql_query="delete from replies where mem_id='$mid'";
   sql_execute($sql_query,'');

	}//foreach
}//If

users_list();

}//function

function ban_user(){
$adsess=form_get("adsess");
admin_test($adsess);

$mem_id=form_get("mem_id");
if(!empty($mem_id))	{
	foreach($mem_id as $mid){
	$sql_query="update members set ban='y' where mem_id='$mid'";
	sql_execute($sql_query,'');
	$sql_query="update listings set stat='s' where mem_id='$mid'";
	sql_execute($sql_query,'');
	$sql_query="update tribes set stat='s' where mem_id='$mid'";
	sql_execute($sql_query,'');
	}//foreach
}//If
users_list();

}//function

function unban_user(){
$adsess=form_get("adsess");
admin_test($adsess);

$mem_id=form_get("mem_id");
if(!empty($mem_id))	{
	$sql_query="update members set ban='n' where mem_id='$mem_id'";
	sql_execute($sql_query,'');
	$sql_query="update listings set stat='a' where mem_id='$mem_id'";
	sql_execute($sql_query,'');
	$sql_query="update tribes set stat='a' where mem_id='$mem_id'";
	sql_execute($sql_query,'');
}//If
users_list();

}//function

function email_user(){
$adsess=form_get("adsess");
admin_test($adsess);

$mem_id=form_get("mem_id");
$pro=form_get("pro");
if(!empty($mem_id))	{
	if($pro==''){
	show_ad_header($adsess);
	?>
	<table width=100%>
	   <tr><td class='lined title'>Email Selected Users</td>
	   <tr><td class='lined padded-6'>
			<table class=body align=center>
			<form action='admin.php' method=post>
			<input type='hidden' name='mode' value='users_manager'>
			<input type='hidden' name='act' value='eml'>
			<input type='hidden' name='pro' value='done'>
			<input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
			<?
			foreach($mem_id as $mid){
				echo "<input type='hidden' name='mem_id[]' value='$mid'>";
			}//foreach
			?>
			<tr><td>Subject</td><td><input type='text' name='subj'></td>
			<tr><td colspan=2 align=center>Message</td>
			<tr><td colspan=2 align=center>
			<textarea name='message' rows=5 cols=45></textarea>
			<tr><td></td><td align=right><input type='submit' value='Send'></td>
			</td>
			</table></form>
	   </td>
	</table>
	<?
	show_footer();
	}//if
	elseif($pro=='done'){
	$data[0]=form_get("subj");
	$data[1]=form_get("message");
	
	foreach($mem_id as $mid){
	   $sql_query="select email from members where mem_id='$mid'";
	   $mem=sql_execute($sql_query,'get');
	   messages($mem->email,"5",$data);
	}//foreach
}//elseif
}//If
users_list();

}//function

function edit_user($mod){
$adsess=form_get("adsess");
admin_test($adsess);
$mem_id=form_get("mem_id");
$pro=form_get("pro");
if(($pro=='')||($mod==0)){
$sql_query="select * from members where mem_id='$mem_id'";
$mem=sql_execute($sql_query,'get');

$d=date("d",$mem->birthday);
$m=date("m",$mem->birthday);
$y=date("Y",$mem->birthday);

show_ad_header($adsess);
echo '<table width="600" align=center>';
?>
<form action="admin.php" method=post>
<input type="hidden" name="mode" value="users_manager">
<input type="hidden" name="act" value="edi">
<input type="hidden" name="pro" value="done">
<input type="hidden" name="mem_id" value="<? echo $mem_id; ?>">
<input type="hidden" name="adsess" value="<? echo $adsess; ?>">
<tr><td>&nbsp;</td>
<tr><td class="lined bold padded-6">Admin: Edit User</td>
<tr><td height="5"></td>
<tr><td class="lined"><table class="body" cellspacing=5 cellpadding=2>
<tr><td colspan=3>
<p class="orangebody">All fields are required!</br>&nbsp
</td>
<tr><td>First Name</td><td><input type="text" value='<? echo $mem->fname; ?>' name="fname"></td><td rowspan=2 class="lined form_tip">Full name will only be shown to user's friends.</td>
<tr><td>Last Name</td><td><input type="text" value='<? echo $mem->lname; ?>' name="lname"></td>
<tr><td>E-mail</td><td><input type="text" value='<? echo $mem->email; ?>' name="email"></td><td class="lined form_tip">This is user's login ID.</td>
<tr><td>Password</td><td><input type="password" name="password"></td><td class="lined form_tip">Leave blank if you don't want to change it.</td>
<tr><td>ZIP/Postal Code</td><td><input type="text" value='<? echo $mem->zip; ?>' name="zip"></td>
<td rowspan=2 class="lined form_tip">This information enables user to see local content. You may hide user's location from others.</br>
<input type=checkbox name="showloc"  <? checked($mem->showloc,'0'); ?> value="0">Don't show location</td>
<tr><td>Country</td><td><select name="country">
<option value='<? echo $mem->country; ?>'><? echo $mem->country; ?>
<? country_drop(); ?>
</select>
</td>
<tr><td>Gender</td><td><input type="radio" <? checked($mem->gender,'m'); ?> name="gender" value="m">Male</br>
<input type="radio" name="gender" <? checked($mem->gender,'f'); ?> value="f">Female</br>
<input type="radio" name="gender" <? checked($mem->gender,'n'); ?> value="n">I'd prefer not to say</br>
</td>
<td rowspan=2 class="lined form_tip">You may hide this information from others.</br>
<input type=checkbox name="showgender" <? checked($mem->showgender,'0'); ?> value="0">Don't show gender</br>
<input type=checkbox name="showage" <? checked($mem->showage,'0'); ?> value="0">Don't show age
</td>
<tr><td>Birthday</td>
<td><select name=month>
<? month_drop("$m"); ?>
</select>
<select name=day>
<? day_drop("$d"); ?>
</select>
<select name=year>
<? year_drop("$y"); ?>
</select>
</td>
<tr><td colspan=3></td></tr>
<tr><td valign="top">Select Membership</td><td valign="top">
<?php
	$sql_accc="select * from member_package order by package_amt";
	$res_accc=mysql_query($sql_accc);
	$ssco=1;
	if(mysql_num_rows($res_accc)) {
		while($row_accc=mysql_fetch_object($res_accc)) {
			if($ssco==1)	{
				if($mem->mem_acc==$row_accc->package_id)	$dis="<input type='radio' name='pack' value='$row_accc->package_id' checked>&nbsp;".$row_accc->package_nam."&nbsp;&nbsp;&#8249;&nbsp;$".$row_accc->package_amt."&nbsp;&#8250;";
				else	$dis="<input type='radio' name='pack' value='$row_accc->package_id'>&nbsp;".$row_accc->package_nam."&nbsp;&nbsp;&#8249;&nbsp;$".$row_accc->package_amt."&nbsp;&#8250;";
			}	else	{
				if($mem->mem_acc==$row_accc->package_id)	$dis="<input type='radio' name='pack' value='$row_accc->package_id' checked>&nbsp;".$row_accc->package_nam."&nbsp;&nbsp;&#8249;&nbsp;$".$row_accc->package_amt."&nbsp;&#8250;";
				else	$dis="<input type='radio' name='pack' value='$row_accc->package_id'>&nbsp;".$row_accc->package_nam."&nbsp;&nbsp;&#8249;&nbsp;$".$row_accc->package_amt."&nbsp;&#8250;";
			}
?>
<?=$dis?><br>
<?php
		$ssco++;
		$dis="";
	}
}
?>
</td>
<td rowspan=2 class="lined form_tip" valign="top">Select Membership Package</td>
<tr><td colspan=3></td></tr>
<tr><td colspan=3 align=center>Admin Notes</td>
<tr><td colspan=3 align=center><textarea name='ad_notes' rows=5 cols=45><? echo $mem->ad_notes; ?></textarea></td>
<tr><td colspan=3 align="right"><input type=submit value="Update"></td>
<tr><td colspan=3>&nbsp;</td>
</form>
</table></td>
</table>
<?
show_footer();
}//if
elseif($pro=='done'){
//getting values from form
$form_data=array ("password","fname","lname","gender",
"day","month","year","email","zip","country","showloc","showgender","showage","ad_notes","pack");
while (list($key,$val)=each($form_data)){
${$val}=form_get("$val");
}
$sql_query="select mem_id from members where email='$email' and mem_id!='$mem_id'";
$num2=sql_execute($sql_query,'num');
//values check
$password=trim($password);
$email=strtolower(trim($email));
$email=trim($email);
$email=str_replace( " ", "", $email );
$email=preg_replace( "#[\;\#\n\r\*\'\"<>&\%\!\(\)\{\}\[\]\?\\/]#", "", $email );
$passl=strlen($password);

//if required values empty
if(($email=='')||($fname=='')||($lname=='')
||($gender=='')||($day==0)||($month==0)||($year==0)||($zip=='')||($country=='')){
error_screen(3);
}
//checking if this e-mail is already used
elseif($num2!=0){
error_screen(4);
}
//checking password length
elseif(($passl!=0)&&(($passl<4)||($passl>12))){
error_screen(7);
}
else{
if($password==''){
  $sql_query="select password from members where mem_id='$mem_id'";
  $mem=sql_execute($sql_query,'get');
  $crypass=$mem->password;
}
else {
//crypting password
$crypass=md5($password);
}
//preparing sql query
if($showloc==''){
 $showloc=1;
}
if($showgender==''){
 $showgender=1;
}
if($showage==''){
 $showage=1;
}
if($pack==0)	{
	$mem_st="F";
	$ms_stat="N";
}	else	{
	$mem_st="P";
	$ms_stat="Y";
}
$birthday=maketime(0,0,0,$month,$day,$year);
//adding data to db
$sql_query="update members set email='$email',password='$crypass',fname='$fname',lname='$lname',zip='$zip',
country='$country',showloc='$showloc',showgender='$showgender',showage='$showage',gender='$gender',birthday='$birthday',ad_notes='$ad_notes',mem_stat='$mem_st',mem_acc='$pack',pay_stat='$ms_stat' where mem_id='$mem_id'";
sql_execute($sql_query,'');
 edit_user(0);
}//else
}//elseif

}//function

function email_all(){
$adsess=form_get("adsess");
admin_test($adsess);

$pro=form_get("pro");

if($pro==''){
show_ad_header($adsess);
?>
<table width=100%>
   <tr><td class='lined title'>Email All Users</td>
   <tr><td class='lined padded-6'>
        <table class=body align=center>
        <form action='admin.php' method=post>
        <input type='hidden' name='mode' value='users_manager'>
        <input type='hidden' name='act' value='emlall'>
        <input type='hidden' name='pro' value='done'>
        <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
        <tr><td>Subject</td><td><input type='text' name='subj'></td>
        <tr><td colspan=2 align=center>Message</td>
        <tr><td colspan=2 align=center>
        <textarea name='message' rows=5 cols=45></textarea>
        <tr><td></td><td align=right><input type='submit' value='Send'></td>
        </td>
        </table></form>
   </td>
</table>
<?
show_footer();
}//if
elseif($pro=='done'){
$data[0]=form_get("subj");
$data[1]=form_get("message");

   $sql_query="select email from members";
   $res=sql_execute($sql_query,'res');
   while($mem=mysql_fetch_object($res)){
   messages($mem->email,"5",$data);
   }//while

 users_list();

}//elseif


}//function
function acc_nam($id)	{
	$sql_query="select package_nam from member_package where package_id='$id'";
	$row=sql_execute($sql_query,'get');
	return stripslashes($row->package_nam);
}

?>