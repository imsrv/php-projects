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
$was=time()-3600*24;
$sql_query="delete from members where verified='n' and joined<$was";
sql_execute($sql_query,'');
sign_up_form();
}
elseif($act=='reg'){
do_register();
}
elseif($act=='val'){
validate();
}

//showing sign-up form
function sign_up_form(){
$inv_id=form_get("inv_id");
if($inv_id!=''){
  $sql_query="select mem_id from invitations where inv_id='$inv_id'";
  $inv=sql_execute($sql_query,'get');
  $sql_query="select fname,lname from members where mem_id='$inv->mem_id'";
  $mem=sql_execute($sql_query,'get');
}
$sql_accc="select * from member_package order by package_amt";
$res_accc=mysql_query($sql_accc);
show_header();
echo '<table width="600" align=center>';
?>
<form action="index.php" method=post>
<input type="hidden" name="mode" value="join">
<input type="hidden" name="act" value="reg">
<input type="hidden" name="inv_id" value="<? echo $inv_id; ?>">
<tr><td>&nbsp;</td>
<tr><td class="lined bold padded-6">Join our net</td>
<tr><td height="5"></td>
<tr><td class="lined"><table class="body" cellspacing=5 cellpadding=2>
<tr><td colspan=3>
<p class="bodygray bold">Become a Registered User
<? if($inv_id==''){ ?>
<p>Fill out the form below to become a member.
<? } else { ?>
<p><? echo "$mem->fname $mem->lname "; ?>invited you to become a member.
<? } ?>
<p>We take your <a href="index.php?mode=privacy">privacy</a> very seriously. We will not sell or exchange your e-mail address with anyone.</br></br>
<p class="orangebody">All fields are required!</br>&nbsp
</td>
<tr><td>First Name</td><td><input type="text" name="fname"></td><td rowspan=2 class="lined form_tip">Your full name will only be shown to your friends.</td>
<tr><td>Last Name</td><td><input type="text" name="lname"></td>
<tr><td>E-mail</td><td><input type="text" name="email"></td><td rowspan=2 class="lined form_tip">This is your login ID; this e-mail address must be verified before you can fully explore our site</td>
<tr><td>Confirm E-mail</td><td><input type="text" name="email2"></td>
<tr><td>Password</td><td><input type="password" name="password"></td><td class="lined form_tip">Passwords must be 4-12 characters.</td>
<tr><td>Confirm Password</td><td><input type="password" name="password2"></td><td></td>
<tr><td>ZIP/Postal Code</td><td><input type="text" name="zip"></td>
<td rowspan=2 class="lined form_tip">This information enables you to see local content. You may hide your location from others.</br>
<input type=checkbox name="showloc" value="0">Don't show my location</td>
<tr><td>Country</td><td><select name="country">
<? country_drop(); ?>
</select>
</td>
<tr><td>Gender</td><td><input type="radio" name="gender" value="m">Male</br>
<input type="radio" name="gender" value="f">Female</br>
<input type="radio" name="gender" value="n">I'd prefer not to say</br>
</td>
<td rowspan=2 class="lined form_tip">You may hide this information from others.</br>
<input type=checkbox name="showgender" value="0">Don't show my gender</br>
<input type=checkbox name="showage" value="0">Don't show my age
</td>
<tr><td>Birthday</td>
<td><select name=month>
<option selected value="0">Month
<? month_drop(0); ?>
</select>
<select name=day>
<option selected value="0">Day
<? day_drop(0); ?>
</select>
<select name=year>
<option selected value="0">Year
<? year_drop('0'); ?>
</select>
</td>
<tr><td colspan=3></td></tr>
<tr><td valign="top">Membership Type</td><td valign="top">
          <?php
	$ssco=1;
	if(mysql_num_rows($res_accc)) {
		while($row_accc=mysql_fetch_object($res_accc)) {
			if($ssco==1)	$dis="<input type='radio' name='pack' value='$row_accc->package_id' checked>&nbsp;".$row_accc->package_nam."&nbsp;";
			else	$dis="<input type='radio' name='pack' value='$row_accc->package_id'>&nbsp;".$row_accc->package_nam."&nbsp;";
			if($row_accc->package_amt!='0.00')	$dis.="&nbsp;&#8249;&nbsp;$".$row_accc->package_amt."&nbsp;&#8250;";
?>
          <?=$dis?>
          <br>
<?php
		$ssco++;
		$dis="";
	}
}
?>
</td>
<td rowspan=2 class="lined form_tip" valign="top">&nbsp;Select Membership Package
</td>
<tr><td colspan=3>&nbsp;</td>
<tr><td colspan=3 class="td-lined-top" height=3></td>
<tr><td colspan=3>&nbsp;</td>
<tr><td colspan=3 align="center"><input type=checkbox name="terms" value=1>I have read and agree to the
<a href='index.php?mode=terms'>Terms of Use</a></td>
<tr><td colspan=3>&nbsp;</td>
<tr><td colspan=3 align="right"><input type=submit value="Register"></td>
<tr><td colspan=3>&nbsp;</td>
</form>
</table></td>
<tr><td>
<table>
<tr><td class="lined body padded-6" valign=top>
<span class="subtitle">This site requires cookies</span></br></br>
Our site uses cookies to provide you with a reliable, consistent experience as you browse the site. Please make sure your browser can accept cookies.
</td>
<td class="lined body padded-6" valign=top>
<span class="subtitle">Using a Spam Filter?</span></br></br>
Add our site to your list of approved domains now so you can receive your registration confirmation and messages from other members.
</td>
<td class="lined body padded-6" valign=top>
<span class="subtitle">What's in a Name?</span></br></br>
<p>Your first and last name will only be visible to your 1 degree Friends -- people who are DIRECTLY CONNECTED to you.
<p>Anyone who is 2 degrees removed will see your FIRST NAME and the FIRST INITIAL of your last name.
<p>People who are 3 degrees removed or more will only see your FIRST name.
</td>
</table>
</td>

</table>
<?
show_footer();
}

function do_register(){
$m_id=cookie_get("mem_id");
if($m_id!=''){
  error_screen(25);
}
global $main_url;
//getting values from form
$form_data=array ("password","password2","fname","lname","gender","inv_id",
"day","month","year","email","email2","zip","country","terms","showloc","showgender","showage","pack");
while (list($key,$val)=each($form_data)){
${$val}=form_get("$val");
}
$sql="select * from member_package where package_id=$pack";
$res=mysql_query($sql);
$row=mysql_fetch_object($res);
$package_amt=$row->package_amt;
$sql_query="select mem_id from members where email='$email'";
$num2=sql_execute($sql_query,'num');
//values check
$password=trim($password);
$email=strtolower(trim($email));
$email=trim($email);
$email=str_replace( " ", "", $email );
$email=preg_replace( "#[\;\#\n\r\*\'\"<>&\%\!\(\)\{\}\[\]\?\\/]#", "", $email );
$email2=strtolower(trim($email2));
$email2=trim($email2);
$email2=str_replace( " ", "", $email2 );
$email2=preg_replace( "#[\;\#\n\r\*\'\"<>&\%\!\(\)\{\}\[\]\?\\/]#", "", $email2 );
$passl=strlen($password);
if(!isset($terms)){
$terms="no";
}
//checking if e-mail and confirm e-mail fields are equal
if($email!=$email2){
error_screen(1);
}
//checking if password and confirm password fields are equal
if($password!=$password2){
error_screen(2);
}
//if required values empty
elseif(($password=='')||($email=='')||($terms=='no')||($fname=='')||($lname=='')
||($gender=='')||($day==0)||($month==0)||($year==0)||($zip=='')||($country=='')){
error_screen(3);
}
//checking if this e-mail is already used
elseif($num2!=0){
error_screen(4);
}
//checking password length
elseif(($passl<4)||($passl>12)){
error_screen(7);
}
else{
//crypting password
$crypass=md5($password);
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
$birthday=maketime(0,0,0,$month,$day,$year);
//adding data to db
$joined=time();
$crypass=md5($password);
if($package_amt=='0.00')	{
	$mem_st="F";
	$p_stat="Y";
}	else	{
	$mem_st="P";
	$p_stat="N";
}
$sql_query="insert into members (email,password,fname,lname,zip,country,showloc,showgender,showage,gender,birthday,joined,mem_stat,mem_acc,pay_stat)
values ('$email','$crypass','$fname','$lname','$zip','$country','$showloc','$showgender','$showage','$gender','$birthday','$joined','$mem_st','$pack','$p_stat')";
sql_execute($sql_query,'');
$sql_query="select max(mem_id) as maxid from members";
$mem=sql_execute($sql_query,'get');
@mkdir("blog/".$mem->maxid,0777);
chmod("blog/".$mem->maxid,0777);
@copy("blog_url.php","blog/".$mem->maxid."/index.php");
//creating photo album
$sql_query="insert into photo(mem_id) values ('$mem->maxid')";
sql_execute($sql_query,'');
$time=time();
$sql_query="insert into profiles(mem_id,updated) values('$mem->maxid','$time')";
sql_execute($sql_query,'');
//sending sign-up e-mail (validation notice)
$val_key=$email.time();
$val_key=md5($val_key);
$sql_query="insert into validate (email,password,val_key) values ('$email','$password','$val_key')";
sql_execute($sql_query,'');
$data="<a href='$main_url/index.php?mode=join&act=val&val_key=$val_key&inv_id=$inv_id'>Verify Email</a>";
messages($email,'0',$data);
//showing a congratulation page
$sql_query="update stats set day_sgns=day_sgns+1,week_sgns=week_sgns+1,month_sgns=month_sgns+1";
sql_execute($sql_query,'');
if($package_amt=='0.00')	complete_screen(0);
else	{
	global $main_url;
	$link=$main_url."/index.php?mode=paypal&pack=$pack&mem_id=$mem->maxid";
	show_screen($link);
}
}
}

function validate(){
//getting validate key
$val_key=form_get("val_key");
$inv_id=form_get("inv_id");
$sql_query="select * from validate where val_key='$val_key'";
$num=sql_execute($sql_query,'num');
//if val key is invalid showing error
if($num==0){
 error_screen(6);
}
$val=sql_execute($sql_query,'get');
$data[0]=$val->email;
$data[1]=$val->password;
//sending user login info
messages($val->email,"2",$data);
//updating db (account verified)
$sql_query="delete from validate where val_key='$val_key'";
sql_execute($sql_query,'');
$sql_query="update members set verified='y' where email='$data[0]'";
sql_execute($sql_query,'');
if($inv_id!=''){
  $sql_query="select * from invitations where inv_id='$inv_id'";
  $frd=sql_execute($sql_query,'get');
  $sql_query="select mem_id from members where email='$data[0]'";
  $mem=sql_execute($sql_query,'get');
  $sql_query="insert into network (mem_id,frd_id)
  values ($mem->mem_id,$frd->mem_id),($frd->mem_id,$mem->mem_id)";
  sql_execute($sql_query,'');
  $sql_query="update invitations set stat='f' where inv_id='$inv_id'";
  sql_execute($sql_query,'');
}//if
$sql_query="select mem_id from invitations where email='$data[0]' and stat!='f'";
$res=sql_execute($sql_query,'res');
$num=mysql_num_rows($res);
if($num!=0){
  while($inv=mysql_fetch_object($res)){
     $now=time();
     $sql_query="select mem_id from members where email='$data[0]'";
     $mem=sql_execute($sql_query,'get');
     $subj="Invitation to Join ".name_header($inv->mem_id,"ad")."\'s Personal Network";
     $bod="After you push \"Confirm\" button user ".name_header($inv->mem_id,"ad").
     " will be added to your friends network.";
     $sql_query="insert into messages_system(mem_id,frm_id,subject,body,type,folder,date)
     values('$mem->mem_id','$inv->mem_id','$subj','$bod','friend','inbox','$now')";
     sql_execute($sql_query,'');
  }//while
}//if
complete_screen(2);
}
?>