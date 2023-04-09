<?
/***************************************************************************
 *                         AutoHits  PRO                                   *
 *                      -------------------                                *
 *   Version         : 1.0                                                 *
 *   Released        : 02.20.2003                                          *
 *   copyright       : (C) 2003 SupaTools.com                              *
 *   email           : info@supatools.com                                  *
 *   website         : www.supatools.com                                   *
 *   custom work     :http://www.gofreelancers.com                         *
 *   support         :http://suppo2rt.supatools.com                        *
 *                                                                         *
 ***************************************************************************/
if($page=="") $page = "1";
$err='';

if($pri=='Save Parameters'){
	$f=fopen('config_real_inc.php','w');
	fputs($f,"<?\n");
	fputs($f,"// your mysql database details\n");
	fputs($f,"\$hostnm = \"$hostnm\";\n");
	fputs($f,"\$usernm = \"$usernm\";\n");
	fputs($f,"\$pwd = \"$pwd\";\n");
	fputs($f,"\$dbName = \"$dbName\";\n");
	fputs($f,"// URL Where AutoHits Is Installed\n"); 
	fputs($f,"\$path=\"$path\";\n");
	fputs($f,"\$base=\"$path\";\n");
	fputs($f,"//Same as above but with '/' trailing slash\n");
	fputs($f,"\$url_default=\"$path/\";\n");
	fputs($f,"// your site name\n");
	fputs($f,"\$site_name=\"$site_name\";\n");
	fputs($f,"// email addresses \n");
	fputs($f,"\$admin_mail=\"$admin_mail\";\n");
	fputs($f,"\$support_email=\"$support_email\";\n");
	fputs($f,"// Your paypal account\n");
	fputs($f,"\$email_pay=\"$email_pay\";\n");
	fputs($f,"// Referral level credits\n");
	fputs($f,"\$ref_cr[1]=".str_replace(",",".",$ref_cr1).";\n");
	fputs($f,"\$ref_cr[2]=".str_replace(",",".",$ref_cr2).";\n");
	fputs($f,"\$ref_cr[3]=".str_replace(",",".",$ref_cr3).";\n");
	fputs($f,"\$ref_cr[4]=".str_replace(",",".",$ref_cr4).";\n");
	fputs($f,"\$ref_cr[5]=".str_replace(",",".",$ref_cr5).";\n");
	fputs($f,"// Account Credit Rates\n");
	fputs($f,"\$basic_min=".str_replace(",",".",$basic_min).";\n");
	fputs($f,"\$basic_max=".str_replace(",",".",$basic_max).";\n");
	fputs($f,"\$silver_min=".str_replace(",",".",$silver_min).";\n");
	fputs($f,"\$silver_max=".str_replace(",",".",$silver_max).";\n");
	fputs($f,"\$gold_min=".str_replace(",",".",$gold_min).";\n");
	fputs($f,"\$gold_max=".str_replace(",",".",$gold_max).";\n");
	fputs($f,"// Bonus credits at signup\n");
	fputs($f,"\$bonus_credits=".str_replace(",",".",$bonus_credits).";\n");
	fputs($f,"?>");
	fclose($f);
	$page = "2";
}
if($pri=='Create DataBase'){
  // connect to database server
	require_once('config_real_inc.php');
 	$db = mysql_connect($hostnm.":3306", $usernm, $pwd);
	if(mysql_error()==''){
	  mysql_select_db ($dbName);
		if(mysql_error()==''){
			// load sql dump to database
			$f=fopen('autohits.sql','r');
			$content = fread ($f, filesize ('autohits.sql'));
			$content = str_replace('&amp;','&',$content);
			$str = split(';',$content);
			foreach($str as $sqlstr){
				$sql = trim(str_replace("\n","",$sqlstr));
				if($sql != ''){
					$sql = str_replace('&','&amp;',$sql);
					mysql_query($sql);
					//echo $sql.";|<br>";
				}
			}
			fclose($f);
		}
		else $err = "Cant connect to $dbName database! DataBase name may by wrong.";
	}else $err = "Cant connectb to MySQl server! Host, user or password may by wrong.";
	$page = "3";
	
//	fputs($f,"<?\n");
}

require_once('config_real_inc.php');
?>
<style type="text/css">
	td{	
		text-align:right;
		font-family:Arial,Verdana;
		font-size:14;	}
	input{width:250;}
</style>
<div align="center">
	<div style="left:202px;position:absolute;top:12px;">
		<h1 style="color:#006699">Install AutoHits software</h1>
	</div>
	<div style="left:200px;position:absolute;top:10px;">
		<h1 style="color:#eeeeee">Install AutoHits software</h1>
	</div>
</div>
<br><br><br>
<form action="" method=post>
<?if($page=="1"){?>
<div style="left:140px;position:relative;">
<table bgcolor="#eeeeee">
	<tr bgcolor="#006699">	
		<td colspan="2" style="color:#eeeeee;text-align:center;"><b>System parameters</td>
	</tr>
	<tr>
		<td>MySQL Server host name</td>
		<td><input type=text name='hostnm' value='<?=$hostnm?>'></td>
	</tr>
	<tr>
		<td>MySQL Server user login</td>
		<td><input type=text name='usernm' value='<?=$usernm?>'></td>
	</tr>
	<tr>
		<td>MySQL Server user password</td>
		<td><input type=text name='pwd' value='<?=$pwd?>'></td>
	</tr>
	<tr>
		<td>Database name to create</td>
		<td><input type=text name='dbName' value='<?=$dbName?>'></td>
	</tr>
	<tr>
		<td>URL Where AutoHits Is Installed</td>
		<td><input type=text name='path' value='<?=$path?>'></td>
	</tr>
	<tr>
		<td>Your site name</td>
		<td><input type=text name='site_name' value='<?=$site_name?>'></td>
	</tr>
	<tr>
		<td>Administrator's e-mail</td>
		<td><input type=text name='admin_mail' value='<?=$admin_mail?>'></td>
	</tr>
	<tr>
		<td>Suport's e-mail</td>
		<td><input type=text name='support_email' value='<?=$support_email?>'></td>
	</tr>
	<tr>
		<td>Your paypal account(e-mail)</td>
		<td><input type=text name='email_pay' value='<?=$email_pay?>'></td>
	</tr>
	
	<tr bgcolor="#006699">	
		<td colspan="2" style="color:#eeeeee;text-align:center;"><b>Referral level credits</b></td>
	</tr>
	<tr>
		<td>Level 1</td>
		<td><input type=text name='ref_cr1' value='<?=number_format($ref_cr[1], 10, '.', '')?>'></td>
	</tr>
	<tr>
		<td>Level 2</td>
		<td><input type=text name='ref_cr2' value='<?=number_format($ref_cr[2], 10, '.', '')?>'></td>
	</tr>
	<tr>
		<td>Level 3</td>
		<td><input type=text name='ref_cr3' value='<?=number_format($ref_cr[3], 10, '.', '')?>'></td>
	</tr>
	<tr>
		<td>Level 4</td>
		<td><input type=text name='ref_cr4' value='<?=number_format($ref_cr[4], 10, '.', '')?>'></td>
	</tr>
	<tr>
		<td>Level 5</td>
		<td><input type=text name='ref_cr5' value='<?=number_format($ref_cr[5], 10, '.', '')?>'></td>
	</tr>
	
	<tr bgcolor="#006699">	
		<td colspan="2" style="color:#eeeeee;text-align:center;"><b>Account Credit Rates</b></td>
	</tr>
	<tr>
		<td>Basic min</td>
		<td><input type=text name='basic_min' value='<?=$basic_min?>'></td>
	</tr>
	<tr>
		<td>Basic max</td>
		<td><input type=text name='basic_max' value='<?=$basic_max?>'></td>
	</tr>
	<tr>
		<td>Silver min</td>
		<td><input type=text name='silver_min' value='<?=$silver_min?>'></td>
	</tr>
	<tr>
		<td>Silver max</td>
		<td><input type=text name='silver_max' value='<?=$silver_max?>'></td>
	</tr>
	<tr>
		<td>Gold min</td>
		<td><input type=text name='gold_min' value='<?=$gold_min?>'></td>
	</tr>
	<tr>
		<td>Gold max</td>
		<td><input type=text name='gold_max' value='<?=$gold_max?>'></td>
	</tr>
	<tr bgcolor="#006699">	
		<td colspan="2" style="color:#eeeeee;text-align:center;"><b></b></td>
	</tr>
	<tr>
		<td>Bonus credits at signup</td>
		<td><input type=text name='bonus_credits' value='<?=$bonus_credits?>'></td>
	</tr>
	<tr bgcolor="#006699">	
		<td colspan="2" style="color:#eeeeee;text-align:center;"><b></b></td>
	</tr>
	<tr><td colspan=2 style="text-align:center"><input type=submit name=pri value='Save Parameters'></td></tr>
</table>
</div>
<?}elseif($page == "2"){?>
<div style="left:220px;position:relative;">
<table bgcolor="#eeeeee">
	<tr bgcolor="#006699">	
		<td colspan="2" style="color:#eeeeee;text-align:center;"><b>MySQL server parameters</td>
	</tr>
	<tr>
		<td>MySQL Server host name:&nbsp;</td>
		<td style="text-align:left;"><b><?=$hostnm?></b></td>
	</tr>
	<tr>
		<td>User:&nbsp;</td>
		<td style="text-align:left;"><b><?=$usernm?></b></td>
	</tr>
	<tr>
		<td>Password:&nbsp;</td>
		<td style="text-align:left;"><b><?=$pwd?></b></td>
	</tr>
	<tr>
		<td>Database name to create:&nbsp;</td>
		<td style="text-align:left;"><b><?=$dbName?></b></td>
	</tr>
	<tr bgcolor="#006699">	
		<td colspan="2" style="color:#eeeeee;text-align:center;"><b></b></td>
	</tr>
	<tr><td colspan=2 style="text-align:center"><input type=submit name=pri value='Create DataBase'></td></tr>
</table>
</div>
<?}else{?>
<div style="left:220px;position:relative;">
	<? if($err!=''){?>
	<h2 style="font-color:red;"><?=$err?></h2>
	<?}else{?>
	<h2>DataBase created succesfully.</h2>
	<?}?>
</div>
<?}?>
</form>

<?

?>

