<?

/***************************************************************************
 *                         AutoHits  PRO                            *
 *                            -------------------
 *    Version          : 2.1                                                  *
 *   Released        : 04.22.2003                                     *
 *   copyright            : (C) 2003 SupaTools.com                           *
 *   email                : info@supatools.com                             *
 *   website              : www.supatools.com                 *
 *   custom work     :http://www.gofreelancers.com      *
 *   support             :http://support.supatools.com        *
 *                                                                         *
 *                                                                         *
 *                                                                         *
 ***************************************************************************/

require('error_inc.php');
require('config_inc.php');

$ref=intval($ref);
$share=intval($share);
$language=intval($language);
$flag=true;

if($name==""){
	$er[]=$err[3]."'name'";
	$flag=false;
}
$name=htmlspecialchars($name);
if($email==""){
	$er[]=$err[3]."'e-mail'";
	$flag=false;
}
$email=htmlspecialchars($email);

/*if($pass==""){
	$er[]=$err[3]."'password'";
	$flag=false;
}
$pass=htmlspecialchars($pass);*/

mt_srand((double)microtime()*1000000);
$pass=mt_rand(100,100000);
if($site==""){
	$er[]=$err[3]."'Site name'";
	$flag=false;
}
$site=htmlspecialchars($site);

if($url==""){
	$er[]=$err[3]."'URL'";
	$flag=false;
}
$url=htmlspecialchars($url);

if($sel[1]==""){
	$er[]=$err[8];
	$flag=false;
}
if($sel[2]==""){
	$er[]=$err[8];
	$flag=false;
}
if($sel[3]==""){
	$er[]=$err[8];
	$flag=false;
}
if($sel1[1]==""){
	$er[]=$err[8];
	$flag=false;
}
if($sel1[2]==""){
	$er[]=$err[8];
	$flag=false;
}
if($sel1[3]==""){
	$er[]=$err[8];
	$flag=false;
}

require('header_inc.php');
?>
<table width="100%" border="0" cellspacing="2" cellpadding="0" align="center">
  <tr> 
    <td align=center>
<?
if($flag==true){
	$query = "select * from ".$t_user." where email=\"".$email."\"";  
	$result = MYSQL_QUERY($query);
	if(mysql_num_rows($result)!=0){
?>
<br><br>
You are already registered in AutoHits.<BR>If you want 
      to add more sites to your account,<BR>just login and add the 
      sites.<BR><br>Team AutoHits<BR><br>
<A href="login.php" target=_top><font color=blue>Login now</font></A>
<br><br>
<?
	}else{
		$query="insert into ".$t_user." set  cr_earn=".$bonus_credits." ,name=\"".$name."\", email=\"".$email."\", pass=\"".$pass."\"  ,own=".$ref." ,share=".$share;
		if(!@mysql_query($query)){                
			print($err[4]);
		} 
		$idu=mysql_insert_id();                                                                                                                  
		
		$query="insert into ".$t_site." set  idu=".$idu." , site=\"".$site."\" , language=\"".$language."\" , url=\"".$url."\" , b=0 , credits=".$bonus_credits;
		if(!@mysql_query($query)){                
			print($err[4]);
		} 
		$idm=mysql_insert_id();
		
		for($i=1;$i<=3;$i++){
			$query="insert into ".$t_idm_idc." set  idm=".$idm.", idc=".intval($sel[$i]);
			if(!@mysql_query($query)){                
				print($err[4]);
			} 
		} 
		for($i=1;$i<=3;$i++){
			$query="insert into ".$t_idu_idc." set  idu=".$idu.", idc=".intval($sel1[$i]);
			if(!@mysql_query($query)){                
				print($err[4]);
			} 
		} 

		if($ref!=0){
			$own=$ref;
			for($i=1;($i<=5)and($own!=0);$i++){
				$query1 = "update ".$t_user." set credits=credits+".($ref_cr[$i]*$bonus_credits).",  c".date("w")."=c".date("w")."+".($ref_cr[$i]*$bonus_credits)." where id=".$own;      
				$result1 = MYSQL_QUERY($query1);
				$query1 = "select own from ".$t_user." where id=".$own;
				$result1 = MYSQL_QUERY($query1);
				$own=mysql_result($result1,0,0);
				@mysql_free_result($result1); 
			}
		}
		print $msg[1]."<br>".$msg[3];

		$body_s=preg_replace ("[\[id\]]",$idu, $body[4]);
		$body_s=preg_replace ("[\[email\]]",$email, $body_s);
		$body_s=preg_replace ("[\[pass\]]",$pass, $body_s);

		@mail($admin_mail,$subject[1],$body[1],"From: $support_email");
		@mail($email,$subject[4],$body_s,"From: $support_email");
	}		
	@mysql_free_result($result);

}else{
	$str=join("<br>",$er);
	print "<p>".$str."</p>";


}
?>
    </td>
  </tr>
</table>
<?
require('footer_inc.php');
?>
