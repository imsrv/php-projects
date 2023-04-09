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
unset($login,$pwrd,$id);
session_start();
session_register("login","pwrd","id");

function pr_ref($id_r){
	global $it;
	global $t_user;
	global $ref_cr;

	if($it<=5){
		$query = "select cr_earn,id from ".$t_user." where own=".$id_r;      

		$result = MYSQL_QUERY($query);
		$num=mysql_num_rows($result); 
		for($i=0;$i<$num;$i++){
			$earn=$earn+round(mysql_result($result,$i,0)*100)/100;
		}
?>
  <tr> 
    <td align="center" width="133">Level<?print $it;?></td>
    <td align="center" width="197"><?print $num;?></td>
    <td align="center" width="62"><?print number_format($earn*$ref_cr[$it],4,',','');?></td>
  </tr>
<?
		$it++;
		for($i=0;$i<$num;$i++){
			pr_ref(mysql_result($result,$i,1));
		}
	}
}

if($logout==1){
	session_destroy();
	header("Location: ".$PHP_SELF);
}

require('error_inc.php');
require('config_inc.php');

function auth($log,$pass){
	global $t_user;
	$query = "select id from ".$t_user." where email=\"".$log."\" and pass=\"".$pass."\" ";      
	$result = MYSQL_QUERY($query);
	if(mysql_num_rows($result)>0){
		$id=mysql_result($result,0,"id");
		@mysql_free_result($result);  
		return $id;
	}else{
		@mysql_free_result($result); 
		return 0;
	}
}

if(auth($login,$pwrd)!=0){
	require('header_inc.php');
	require('menu.php');
?>
      <table width="70%" border="0" cellspacing="5" cellpadding="5">
        <tr align="justify"> 
          <td><b>Referral- Earn free credits</b></td>
        </tr>
        <tr>
          <td align="justify">Earn free credits when you refer people to our site.<br>
Your referral link is:<br>
<a href="<?print $path;?>/?ref=<?print $id;?>"><font color=blue><?print $path;?>/?ref=<?print $id;?></font></a><br>
</td>
        </tr>
        <tr align="justify"> 
<?
	$query = "select * from ".$t_user." where own=".$id;      
	$result = MYSQL_QUERY($query);
?>
          <td>You refer:(<?print mysql_num_rows($result);?>)<br>
<?	if(mysql_num_rows($result)==0){
		print "none";
	}
	while($row = mysql_fetch_array($result)){
	if($row["share"]==0){
		print $row["name"];
	}else{
?>
<a href="mailto:<?print $row["email"];?>"><font color=blue><?print $row["name"];?></font></a>
<?
	}
?>
<br>
<?
	}
?>
<br><br>
<table width="300" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr bgcolor="#006699"> 
    <td align="center" width="133"><b><font color="#FFFFFF">level</font></b></td>
    <td align="center" width="197"><b><font color="#FFFFFF">no.users</font></b></td>
    <td align="center" width="62"><b><font color="#FFFFFF">earned</font></b></td>
  </tr>
<?
	$id_r=$id;
	$it=1;
	pr_ref($id_r);
?>
</table>
</td>
        </tr>
      </table>
<?
}else{
	header("Location: login.php");
}
require('footer_inc.php');
?>