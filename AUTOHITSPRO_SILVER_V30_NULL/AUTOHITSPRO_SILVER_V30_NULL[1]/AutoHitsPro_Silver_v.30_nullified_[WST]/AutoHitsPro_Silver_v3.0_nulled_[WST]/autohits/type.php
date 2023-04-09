<?
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
	require('header_inc.php');
	if($REQUEST_METHOD=="POST"){
		if(isset($ok)){
			if($name==""){
				print "<p class=\"error\">".$err[3]."'Name'"."</p>";
			}else{
				$name=htmlspecialchars($name);
				$num=abs(intval($num));
				$query = "select total_credits from ".$t_main." where id=".$id;      
				$result = MYSQL_QUERY($query);
				$total=mysql_result($result,0,"total_credits");
				@mysql_free_result($result);
				$query = "select id from ".$t_main." where b=1 and name=".$name;      
				$result = MYSQL_QUERY($query);
				$nn=@mysql_num_rows($result);
				@mysql_free_result($result);
				if($num>$total){
					print "<p class=\"error\">".$err[10]."</p>";
				}else{
					if($nn==0){
						print "<p class=\"error\">".$err[11]."</p>";
					}else{
						$query = "update ".$t_main." set total_credits=total_credits-".$num." where id=".$id;      
						$result = MYSQL_QUERY($query);
						$query = "update ".$t_main." set total_credits=total_credits+".$num." where name=".$name;      
						$result = MYSQL_QUERY($query);
						print "<p class=\"error\">".$msg[6]."'Name'"."</p>";
					}
				}
			}
		}
	}
	require('menu.php');
?>
       <form name="form1" method="post" action="">
       
<table width="100%" border="0" cellspacing="5" cellpadding="5">
  <tr> 
         
    <td width="75%" align="right" class="text" valign="top"> 
			<? include 'prices1.inc.php'; ?>
			
    </td>
  </tr>
</table>
<?
}else{
	header("Location: login.php");
}
require('footer_inc.php');
?>