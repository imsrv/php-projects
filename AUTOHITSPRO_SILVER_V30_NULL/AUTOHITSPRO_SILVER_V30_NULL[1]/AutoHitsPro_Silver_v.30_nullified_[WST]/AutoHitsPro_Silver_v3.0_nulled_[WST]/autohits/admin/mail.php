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

if($REQUEST_METHOD=="POST"){
	if(isset($send)){ 
		if(is_array($us)){ 
			reset($us);    
			$query = "select distinct(email),name,credits from ".$t_user." where id=".(intval(current($us)));
			while(next($us)){
				$query=$query." or id=".(intval(current($us)));
			}
			$result = MYSQL_QUERY($query);
			$i=0;
			$text=stripslashes($text);
			$subj=stripslashes($subj);
			while($row = mysql_fetch_array($result)){
				$text1=preg_replace ("[\[name\]]",$row["name"], $text);
				$text1=preg_replace ("[\[email\]]",$row["email"], $text1);
				$text1=preg_replace ("[\[credits\]]",$row["credits"], $text1);
				if(!(@mail($row["email"],$subj,$text1,"From: $support_email"))){
					$errarr[$i]=$row["email"];
					$i++;
				} 
			}
			print "<div  align=center><font color=red>".$msg[3]."</font></div>";
			@mysql_free_result($result);
		} 
	}
	if(isset($sendstat)){ 
		if(is_array($us)){ 
			reset($us);    
			$query = "select distinct(email),name,credits,id from ".$t_user." where id=".(intval(current($us)));
			while(next($us)){
				$query=$query." or id=".(intval(current($us)));
			}
			$result = MYSQL_QUERY($query);
			$i=0;
			while($row = mysql_fetch_array($result)){
				$query1 = "select * from ".$t_site." where idu=".$row["id"]." ";      
				$result1 = MYSQL_QUERY($query1);

				$body_s=preg_replace ("[\[name\]]",$row["name"], $body[2][1]);
				$body_s=preg_replace ("[\[email\]]",$row["email"], $body_s);
				$body_s=preg_replace ("[\[id\]]",$row["id"], $body_s);
				$body_s=preg_replace ("[\[credits\]]",$row["credits"], $body_s);

				while($row1 = mysql_fetch_array($result1)){
					$str="";
					$str=preg_replace ("[\[site\]]",$row1["site"], $body[2][2]);
					$str=preg_replace ("[\[url\]]",$row1["url"], $str);
					$str=preg_replace ("[\[hits\]]",$row1["pokaz"], $str);

					$z=0;
					for($j=0;$j<=6;$j++){
						$z=$z+$row1["p$j"];
					}
					$str=preg_replace ("[\[last_mail\]]",$z, $str);

					$str=preg_replace ("[\[credits1\]]",$row1["credits"], $str);
					if($row1["b"]==0){$str=preg_replace ("[\[state\]]","Disabled", $str);}elseif($row1["b"]==1){$str=preg_replace ("[\[state\]]","Waiting", $str);}elseif($row1["b"]==2){$str=preg_replace ("[\[state\]]","Enabled", $str);};
					$body_s=$body_s.$str;
				}

				$query1 = "select sum(p1),sum(p2),sum(p3),sum(p4),sum(p5),sum(p6),sum(p0) from ".$t_site." where idu=".$row["id"]." ";      
				$result1 = MYSQL_QUERY($query1);

	  			$body_s=$body_s.$body[2][3];
				$vsego=0;
				for($i=0;$i<=date("w");$i++){
					$vsego=$vsego+round(100*mysql_result($result1,0,"sum(p$i)"))/100;
				}
				for($i=0;$i<=date("w");$i++){
					$str="";
					$str=preg_replace ("[\[date_r\]]",date( "m.d.Y", mktime(0,0,0,date("m"),date("d")-date("w")+$i,date("Y"))), $body[2][4]);
					$str=preg_replace ("[\[receive\]]",round(100*mysql_result($result1,0,"sum(p$i)"))/100, $str);;
					$body_s=$body_s.$str;
				}

				$query1 = "select sum(c1),sum(c2),sum(c3),sum(c4),sum(c5),sum(c6),sum(c0) from ".$t_user." where id=".$row["id"]." ";      
				$result1 = MYSQL_QUERY($query1);
				$body_s=$body_s.$body[2][5];

				$vsego=0;
				for($i=0;$i<=date("w");$i++){
					$vsego=$vsego+round(100*mysql_result($result1,0,"sum(c$i)"))/100;
				}
				for($i=0;$i<=date("w");$i++){
					$str="";
					$str=preg_replace ("[\[date_e\]]",date( "m.d.Y", mktime(0,0,0,date("m"),date("d")-date("w")+$i,date("Y"))), $body[2][6]);
					$str=preg_replace ("[\[earn\]]",round(100*mysql_result($result1,0,"sum(c$i)"))/100, $str);;
					$body_s=$body_s.$str;
				}
				$body_s=$body_s.$body[2][7];
				if(!(@mail($row["email"],$subject[2],$body_s,"From: $support_email"))){
					$errarr[$i]=$row["email"];
					$i++;
				} 
			}
			print "<div  align=center><font color=red>".$msg[3]."</font></div>";
			@mysql_free_result($result);
		} 
	}
}

@mysql_free_result($result);
$query = "select id,name,email from  ".$t_user." order by id ";      
$result = MYSQL_QUERY($query);
require('header_inc.php');
?>
<form name="form1" method="post" action="">
<? 
if(mysql_num_rows($result)==0){ 
?>
<font color=red>
<? 
	print $msg[2]; 
?>
</font>
<? 
}else{ 
?>
<p>
<h5>Users</h5>
</p>
<table width="100%" border=1 cellspacing=0 cellpadding=5 bordercolor="#FFFFFF" bgcolor="#E6E6E6">
  <tr>
    <td width="20%" align="center">
      <b>Name:</b>
    </td>
    <td align="center">
      <b>E-mail:</b>
    </td>
    <td align="center" valign="top" width="70"> 
      <b>Send mail</b>
    </td>
  </tr>
<? 
	$i=0;
	while($row = mysql_fetch_array($result)){
?>
  <tr>
    <td width="20%" align="center">
	<? print $row["name"]; ?>
    </td>
    <td align="center">
	<? print $row["email"]; ?>
    </td>
    <td align="center" valign="top" width="70"> 
      <input type="checkbox" name="us[<?print $i;?>]" value="<?print $row["id"];?>">
       </td>
  </tr>
<?
		$i++;
	}
?>
<script language="JavaScript">
<!--
function check() {
	for (var i=0; i<form1.elements.length; i++) {
		if (form1.elements[i].type == 'checkbox') {
			form1.elements[i].checked = !(form1.elements[i].checked);
		}
	}
	form1.all.checked=!(form1.all.checked);
}
//-->
</script>
  <tr>
    <td width="20%" align="center">
	&nbsp;
    </td>
    <td align="right">
	<b>Check All</b>
    </td>
    <td align="center" valign="top" width="70"> 
      <input type="checkbox" name="all" onClick="javascript: check();">
       </td>
  </tr>
</table>
<?
}
@mysql_free_result($result);            
$num=sizeof($errarr);
for($i=0;$i<$num;$i++){
?>
<font color=red>
	<? print $err[11].$errarr[$i]."<br>"; ?>
</font>
<? 
} 
?>
<br>
MACROSES<br>
==========================
<br>
[name] - name of user <br>
[email] - users email address  <br>
[credits] - credits on account of user  <br>
<b>Subject of message:</b>
  <p> 
    <textarea name="subj" cols="50" rows="7"></textarea>
  </p>
<b>Text of message:</b>
  <p> 
    <textarea name="text" cols="50" rows="7"></textarea>
  </p>
    <input type="submit" name="send" value="Send Mail">
    <input type="submit" name="sendstat" value="Send Statistics">
</form>
<?
require('footer_inc.php');
?>