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

$id=intval($id);

if($REQUEST_METHOD=="POST"){
	if(isset($add)){
		$br=intval($br);
		$type=intval($type);
		$typeh=intval($typeh);
		$share=intval($share);
		$credits=intval($credits);
		if($name==""){
			die($err[3]);
		}
		$name=htmlspecialchars($name);
		if($pass==""){
			die($err[3]);
		}
		$pass=htmlspecialchars($pass);
		if($sel[1]==""){
			die($err[6]);
		}
		if($sel[2]==""){
			die($err[6]);
		}
		if($sel[3]==""){
			die($err[6]);
		}
		$query="delete from ".$t_idu_idc." where idu=".$id;
		if(!@mysql_query($query)){                
			print $err[6];
		}           
		for($i=1;$i<=3;$i++){
			$query="insert into ".$t_idu_idc." set  idu=".$id.", idc=".intval($sel[$i]);
			if(!@mysql_query($query)){                
				print($err[6]);
			} 
		} 
		$query="update ".$t_user." set  credits=".$credits.", name=\"".$name."\" , pass=\"".$pass."\" , br=\"".$br."\" ,type=\"".$type."\" ,share=\"".$share."\" where id=".$id;	
		if(!@mysql_query($query)){                
			die($err[6]);
		} 
		if($type!=$typeh){
			$query="update ".$t_user." set date=\"".date("Y")."-".date("m")."-".date("d")."\"  where id=".$id;	
			if(!@mysql_query($query)){                
				die($err[6]);
			}
		} 
		header("location:".$ref);
	}
}
$query = "select * from ".$t_user.",".$t_idu_idc." where id=".$id." and idu=id order by idc";      
$result = MYSQL_QUERY($query);
$i=1;
while($row = mysql_fetch_array($result)){
	$cat[$i]=$row["idc"];
	$i++;
}	

$name=mysql_result($result,0,"name");
$pass=mysql_result($result,0,"pass");
$credits=mysql_result($result,0,"credits");
$br=mysql_result($result,0,"br");
$share=mysql_result($result,0,"share");
$type=mysql_result($result,0,"type");
@mysql_free_result($result);

$query = "select * from ".$t_language." order by language";      
$result = MYSQL_QUERY($query);
require('header_inc.php');
?>
<FORM name=NewUser action="" method=post>
<table width="500" border="0" cellspacing="2" cellpadding="0" align="center">
<input type="hidden" name="ref" value="<?print $HTTP_REFERER;?>">
  <tr> 
     <td width="200" align="left">Name:</td>
     <td align="left" width="450"> 
       <input type="text" name="name" size="30" value="<?print $name;?>">
    </td>
  </tr>
  <tr> 
     <td width="200" align="left">Password:</td>
     <td align="left" width="450"> 
       <input type="text" name="pass" size="30" value="<?print $pass;?>">
    </td>
  </tr>
  <tr> 
     <td width="200" align="left">Credits:</td>
     <td align="left" width="450"> 
       <input type="text" name="credits" size="30" value="<?print $credits;?>">
    </td>
  </tr>
  <tr> 
     <td width="200" align="left">Share e-mail:</td>
     <td align="left" width="450"> 
	<SELECT name="share"><OPTION value=0 <?if($share==0){print "selected";}?>>No, Keep my email private</OPTION><OPTION value=1 <?if($share==1){print "selected";}?>>Yes, share it to my up and down line</OPTION></SELECT>
    </td>
  </tr>
  <tr> 
     <td width="200" align="left">Browser window:</td>
     <td align="left" width="450"> 
	<SELECT name="br"><OPTION value=0 <?if($br==0){print "selected";}?>>Allow minimized (0.8 credits per view)</OPTION><OPTION value=1 <?if($br==1){print "selected";}?>>Maximized (1 credits per view)</OPTION></SELECT>
    </td>
  </tr>
  <tr> 
     <td width="200" align="left">Account type:</td>
     <td align="left" width="450"> 
	<SELECT name="type"><OPTION value=0 <?if($type==0){print "selected";}?>>Basic</OPTION><OPTION value=1 <?if($type==1){print "selected";}?>>Silver</OPTION><OPTION value=2 <?if($type==2){print "selected";}?>>Gold</OPTION></SELECT>
	<input type="hidden" name="tipeh" value="<?print $type;?>">
    </td>
  </tr>
    <tr> 
      <td width="200" align="left" class="text" valign="top">Category:</td>
      <td align="left" class="text" width="450"> 
<?
$query = "select * from ".$t_cat." order by id";      
$result = MYSQL_QUERY($query);
$i=0;
while($row = mysql_fetch_array($result)){
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
@mysql_free_result($result);
?>
  </select>
      </td>
    </tr>
  <tr> 
     <td width="200" align="left"> </td>
     <td align="left" width="450"> 
<INPUT type=submit name="add" value="Submit"> 
    </td>
  </tr>
</table>
</form>
<?
require('footer_inc.php');
?>
