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
	$query = "select * from ".$t_user." where id=".$id." ";      
	$result = MYSQL_QUERY($query);
	$credits=mysql_result($result,0,"credits");
	$email=mysql_result($result,0,"email");
	$flag=true;
	if($REQUEST_METHOD=="POST"){
		if(isset($edit)){
			if($name==""){
				$er[]=$err[3]."'Name'";
				$flag=false;
			}
			$name=htmlspecialchars($name);
			$br=intval($br);
			$share=intval($share);
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

			for($i=0,$summa=0;$i<sizeof($h);$i++){
				$summa=$summa+$cr[$i];
			}
			if($summa>$credits){
				require('header_inc.php');
				print $err[6]."<br>";
				require('footer_inc.php');
				exit;
			}
			$query="delete from ".$t_idu_idc." where idu=".$id;
			if(!@mysql_query($query)){                
				print $err[9];
			}           
			for($i=1;$i<=3;$i++){
				$query="insert into ".$t_idu_idc." set  idu=".$id.", idc=".intval($sel[$i]);
				if(!@mysql_query($query)){                
					print($err[9]);
				} 
			} 

			for($i=0;$i<sizeof($h);$i++){
				$query="update ".$t_site." set credits=credits+".intval($cr[$i])." where id=".$h[$i];
				if(!@mysql_query($query)){                
					print $err[9];
				} 
				$query="update ".$t_user." set credits=credits-".intval($cr[$i])." where id=".$id;
				if(!@mysql_query($query)){                
					print $err[9];
				} 
			}

			$query="update ".$t_user." set  name=\"".$name."\", share=".$share.", br=".$br;
			if(($pass!="")and($pass1!="")){
				if(($pass=="")and($pass!=htmlspecialchars($pass))){
					$er[]=$err[5];
					$flag=false;
				}
				if(($pass1=="")and($pass1!=htmlspecialchars($pass1))){
					$er[]=$err[5];
					$flag=false;
				}
				if($pass1!=$pass){
					$er[]=$err[1];
					$flag=false;
				}
				$query=$query.",pass=\"".$pass."\" ";
			}
			if($flag==true){
				$query=$query." where id=".$id;	
				if(!@mysql_query($query)){                
					print $err[9];
				} 
 
				if(($pass!="")and($pass1!="")){
					$pwrd=$pass;
					@mail($email,$subject[3],$body[2].$pass,"From: $support_email");
				}
			header("Location: user_menu.php?PHPSESSID=".$PHPSESSID);
			}else{
				require('header_inc.php');
				$str=join("<br>",$er);
				print "<p class=\"error\">".$str."</p><p class=\"smlink\">Please return to <a href=\"javascript: history.back()\">back</a> and check your form.</p>";
				require('footer_inc.php');
				exit;
			}
		}
	}
	require('header_inc.php');
	$query1 = "select * from ".$t_idu_idc." where idu=".$id." order by idc";      
	$result1 = MYSQL_QUERY($query1);
	$i=1;
	while($row = mysql_fetch_array($result1)){
		$cat[$i]=$row["idc"];
		$i++;
	}	
	$name=mysql_result($result,0,"name");
	$share=mysql_result($result,0,"share");
	$br=mysql_result($result,0,"br");
	@mysql_free_result($result);
	require('menu.php');
?>
<SCRIPT language=javascript1.2 type=text/javascript>
function EvaluateField()
{
	var userName		= document.NewUser.name.value;
	var userPassword	= document.NewUser.pass.value;
	var userPassword1	= document.NewUser.pass1.value;

	if(userName == "")
	{
		alert("The field \"Your name\" must be filled.");
		document.NewUser.name.focus();
		return false;
	}
	if(userPassword!= userPassword1)
	{
		alert("The fields \"Your password\" and \"Confirm your password\" must be identically.");
		document.NewUser.pass.focus();
		return false;
	}
	return true;
}


</SCRIPT>
<FORM name=NewUser action="" method=post>
<table width="500" border="0" cellspacing="2" cellpadding="0" align="center">
  <tr> 
     <td width="400" align="left">Your Name:</td>
     <td align="left" width="450"> 
       <input type="text" name="name" size="30" value="<?print $name;?>">
    </td>
  </tr>
  <tr> 
     <td width="200" align="left">Your E-mail address:</td>
     <td align="left" width="450"> 
	<?print $email;?>
    </td>
  </tr>
  <tr> 
     <td width="200" align="left">New password:</td>
     <td align="left" width="450"> 
       <input type="password" name="pass" size="10">
    </td>
  </tr>
  <tr> 
     <td width="200" align="left">Confirm your new password:</td>
     <td align="left" width="450"> 
       <input type="password" name="pass1" size="10">
    </td>
  </tr>
  <tr> 
     <td width="200" align="left">Share email:</td>
     <td align="left" width="450"> 
	<SELECT name="share"><OPTION value=0 <?if($share==0){print "selected";}?>>No, Keep my 
              email private</OPTION><OPTION value=1 <?if($share==1){print "selected";}?>>Yes, share it to my up and 
              down line</OPTION></SELECT>
    </td>
  </tr>
  <tr> 
     <td width="200" align="left">Browser window:</td>
     <td align="left" width="450"> 
	<SELECT name="br"><OPTION value=0 <?if($br==0){print "selected";}?>>Allow minimized (0.8 credits per view)</OPTION><OPTION value=1 <?if($br==1){print "selected";}?>>Maximized (1 credits per view)</OPTION></SELECT>
    </td>
  </tr>
    <tr> 
      <td width="200" align="left" class="text" valign="top">Category:</td>
      <td align="left" class="text" width="450"> 
<?
$query1 = "select * from ".$t_cat." order by id";      
$result1 = MYSQL_QUERY($query1);
$i=0;
while($row = mysql_fetch_array($result1)){
	$ch["id"][$i]=$row["id"];
	$ch["title"][$i]=$row["title"];
	$i++;
}?>
  <select name="sel[1]">
<?
$siz=$i;
for($i=0;$i<$siz;$i++){
?>
    <option value="<?
	print $ch["id"][$i];
?>
" <?if($ch["id"][$i]==$cat[1]){print "selected";}?>>
<?
	print $ch["title"][$i];
?>
</option>
<?
}
?>
  </select>
  <select name="sel[2]">
<?
for($i=0;$i<$siz;$i++){
?>
    <option value="<?
	print $ch["id"][$i];
?>
" <?if($ch["id"][$i]==$cat[2]){print "selected";}?>>
<?
	print $ch["title"][$i];
?>
</option>
<?
}
?>
  </select>
  <select name="sel[3]">
<?
for($i=0;$i<$siz;$i++){
?>
    <option value="<?
	print $ch["id"][$i];
?>
" <?if($ch["id"][$i]==$cat[3]){print "selected";}?>>
<?
	print $ch["title"][$i];
?>
</option>
<?
}
?>
  </select>
      </td>
    </tr>
  <tr> 
     <td width="200" align="left"> </td>
     <td align="left" width="450"> 
<INPUT onclick="return EvaluateField();" type=submit name="edit" value="Submit"> 
    </td>
  </tr>
  <tr height=20> 
     <td width="400" align="left"> </td>
     <td align="left" width="450"> </td>
  </tr>
  <tr> 
     <td width="400" align="left">Assign account credit</td>
     <td align="left" width="450"> 
(max: <?print $credits;?>)
    </td>
  </tr>
<?
	$i=0;
	$query = "select * from ".$t_site." where idu=".$id;      
	$result = MYSQL_QUERY($query);
	while($row = mysql_fetch_array($result)){
?>
  <tr> 
     <td width="400" align="left"><?print $row["site"];?></td>
     <td align="left" width="450"> 
       <input type="text" name="cr[<?print $i;?>]" size="4" value="0">
       <input type="hidden" name="h[<?print $i;?>]" value="<?print $row["id"];?>">
    </td>
  </tr>
<?
		$i++;
	}
?>
  <tr> 
     <td width="400" align="left"> </td>
     <td align="right" width="450"><a href="javascript:history.back();"><font color=blue>[back]</font></a></td>
  </tr>
</table>
</form>
<?
}else{
	header("Location: login.php");
}
require('footer_inc.php');
?>
