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

$ids=intval($ids);

if($REQUEST_METHOD=="POST"){
	if(isset($add)){
		$language=intval($language);
		if($site==""){
			die($err[3]);
		}
		$site=htmlspecialchars($site);
		if($url==""){
			die($err[3]);
		}
		$url=htmlspecialchars($url);
		if($sel[1]==""){
			die($err[6]);
		}
		if($sel[2]==""){
			die($err[6]);
		}
		if($sel[3]==""){
			die($err[6]);
		}
		$query="delete from ".$t_idm_idc." where idm=".$ids;
		if(!@mysql_query($query)){                
			print $err[6];
		}           
		for($i=1;$i<=3;$i++){
			$query="insert into ".$t_idm_idc." set  idm=".$ids.", idc=".intval($sel[$i]);
			if(!@mysql_query($query)){                
				print($err[6]);
			} 
		} 
		$query="update ".$t_site." set  language=".$language.", url=\"".$url."\" , site=\"".$site."\" , credits=\"".$credits."\" where id=".$ids;	
		if(!@mysql_query($query)){                
			die($err[6]);
		} 
		header("location:".$ref);
	}
}
$query = "select * from ".$t_site.",".$t_idm_idc." where id=".$ids." and idm=id order by idc";      
$result = MYSQL_QUERY($query);
$i=1;
while($row = mysql_fetch_array($result)){
	$cat[$i]=$row["idc"];
	$i++;
}	

$site=mysql_result($result,0,"site");
$language=mysql_result($result,0,"language");
$url=mysql_result($result,0,"url");
$credits=mysql_result($result,0,"credits");
$b=mysql_result($result,0,"b");
@mysql_free_result($result);

$query = "select * from ".$t_language." order by language";      
$result = MYSQL_QUERY($query);

require('header_inc.php');
?>
<SCRIPT language=javascript1.2 type=text/javascript>
function EvaluateField()
{
	var SiteName		= document.NewUser.site.value;
	var SiteURL		= document.NewUser.url.value;
	var SiteLanguage	= document.NewUser.language.selectedIndex;

	if(SiteLanguage==0 ){
		alert('You need to set your primary site language.');
		document.NewUser.language.focus();
		return false;
	}

	if(SiteName == "")
	{
		alert("The field \"Your site name\" must be filled.");
		document.NewUser.site.focus();
		return false;
	}

	if(SiteURL == "")
	{
		alert("The field \"Your site URL\" must be filled.");
		document.NewUser.url.focus();
		return false;
	}

	if(SiteURL == "http://")
	{
		alert("The field \"Your site URL\" must be filled.");
		document.NewUser.url.focus();
		return false;
	}
	return true;

}
</SCRIPT>
<FORM name=NewUser action="" method=post>
<table width="500" border="0" cellspacing="2" cellpadding="0" align="center">
<input type="hidden" name="ref" value="<?print $HTTP_REFERER;?>">
  <tr> 
     <td width="200" align="left">Your site name:</td>
     <td align="left" width="450"> 
       <input type="text" name="site" size="30" value="<?print $site;?>">
    </td>
  </tr>
  <tr> 
     <td width="200" align="left">Your site URL:</td>
     <td align="left" width="450"> 
       <input type="text" name="url" size="30" value="<?print $url;?>">
    </td>
  </tr>
  <tr> 
     <td width="200" align="left">Your site language:</td>
     <td align="left" width="450"> 
	<SELECT name=language><OPTION value=0 selected>Please 
              select</OPTION>
<?
while($row = mysql_fetch_array($result)){
?>
<OPTION value="<?print $row["id"];?>" <?if($row["id"]==$language){print "selected";}?>><?print $row["language"];?></OPTION>
<?
}
@mysql_free_result($result);
?>
</SELECT>
    </td>
  </tr>
  <tr> 
     <td width="200" align="left">Your site credits:</td>
     <td align="left" width="450"> 
       <input type="text" name="credits" size="5" value="<?print $credits;?>">
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
<INPUT onclick="return EvaluateField();" type=submit name="add" value="Submit"> 
    </td>
  </tr>
</table>
</form>
<?
require('footer_inc.php');
?>
