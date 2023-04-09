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
unset($id_site_ses);
session_start();
session_register("id_site_ses");
$id=intval($id);
$id1=intval($id1);
$id2=intval($id2);
require('error_inc.php');
require('config_inc.php');
require('admin/timer.inc.php');
//test for pages query frequency
$query = "SELECT unix_timestamp(now())-unix_timestamp(last_page_time) as subs FROM ".$t_user." where id=".$id;
$result = MYSQL_QUERY($query);
$row = mysql_fetch_array($result);
$subs = $row["subs"];
mysql_free_result($result);
if($subs >= $delay_t){ // test

	$query = "select br,type,own,idc from ".$t_user.",".$t_idu_idc." where id=".$id." and id=idu ";
	$result = MYSQL_QUERY($query);
	while($row = mysql_fetch_array($result)){
		$cat[]=$row["idc"];
	}
	$type=mysql_result($result,0,"type");
	$br=mysql_result($result,0,"br");
	$own=mysql_result($result,0,"own");
	@mysql_free_result($result); 
	if($type==0){
		if($br==0){
			$cr=$basic_min;
		}elseif($br==1){
			$cr=$basic_max;
		}
	}elseif($type==1){
		if($br==0){
			$cr=$silver_min;
		}elseif($br==1){
			$cr=$silver_max;
		}
	}elseif($type==2){
		if($br==0){
			$cr=$gold_min;
		}elseif($br==1){
			$cr=$gold_max;
		}
	}
	$query = "select id from ".$t_site." where idu=".$id." order by id";      
	$result = MYSQL_QUERY($query);
	$klv=mysql_num_rows($result);
	if($id2>=$klv-1){
		$id3=mysql_result($result,0,"id");
		$id2=0;
	}else{
		$id3=mysql_result($result,$id2+1,"id");
		$id2++;
	}
  if (!isset($id_site_ses[anticheat])) { $cr=0; } // If time hasn't been recorded, no credit.
  if (!is_numeric($id_site_ses[anticheat])) { $cr=0; } //
  if ($id_site_ses[anticheat]>(date("U")-$delay_t)) { $cr=0; } //
  $id_site_ses[anticheat]=date("U"); 
	$query = "update ".$t_site." set credits=credits+".$cr." where id=".$id3;      
	$result = MYSQL_QUERY($query);
	$query = "update ".$t_user." set c".date("w")."=c".date("w")."+".$cr.", cr_earn=cr_earn+".$cr." where id=".$id;      
	$result = MYSQL_QUERY($query);
	for($i=1;($i<=5)and($own!=0);$i++){
		$query = "update ".$t_user." set credits=credits+".($ref_cr[$i]*$cr).",  c".date("w")."=c".date("w")."+".($ref_cr[$i]*$cr)." where id=".$own;      
		$result = MYSQL_QUERY($query);
		$query = "select own from ".$t_user." where id=".$own;
		$result = MYSQL_QUERY($query);
		$own=mysql_result($result,0,0);
		@mysql_free_result($result); 
	}
	      
	mt_srand((double)microtime()*1000000);
	$query = "select distinct(id),url from ".$t_site.",".$t_idm_idc." where idu!=".$id." and id!=".$id1." and b=2 and credits>0 and idm=id and ( ";
	$klv=sizeof($cat);
	$query.=" idc=".$cat[0];
	for($i=1;$i<$klv;$i++){
		$query.=" or idc=".$cat[$i];
	}     
	$query=$query." ) ";
	for($i=1;$i<count($id_site_ses["id"]);$i++){
		if($id_site_ses["time"][$i]>mktime()-$time_autohit){
			$query=$query." and id!=".$id_site_ses["id"][$i]." ";
		}
	}
	$query=$query."  order by id";
	$result = MYSQL_QUERY($query);

	// update last_page_time in user record
	$query = "update ".$t_user." set last_page_time=now() where id=".$id;
	MYSQL_QUERY($query);
	// enf of update

	$fl=false;
	if(mysql_num_rows($result)==1){
		$k=0;
	}elseif(mysql_num_rows($result)==0){
		$fl=true;
	}else{
		$k=mt_rand(0,mysql_num_rows($result)-1);
	}
	if($fl==false){
		$query1 = "update ".$t_site." set credits=credits-1, pokaz=pokaz+1, p".date("w")."=p".date("w")."+1 where id=".mysql_result($result,$k,"id");      
		$n=count($id_site_ses["id"]);
		$id_site_ses["id"][$n+1]=mysql_result($result,$k,"id");
		$id_site_ses["time"][$n+1]=mktime();
		$result1 = MYSQL_QUERY($query1);
		$url1=mysql_result($result,$k,"url");
		$id1=mysql_result($result,$k,"id");
	}else{		
		?>
		<script language="Javascript">
		// parent.topFrame.pause();
		</script>
		<?
		$url1=$url_default;
	}
}// end of pages qurey frequency test
else{
	$url1 = "error.php?id=".$id;
}
	
?>
<script language="Javascript">
// if (parent.topFrame.form1.timer.value=='00') {
	parent.score=parseInt((parent.score+<?print $cr;?>)*10);
// }
parent.score=(parent.score)/10;
parent.topFrame.form1.score.value=parent.score;
parent.ida[1]=<?print $id1;?>;
parent.ida[2]=<?print $id2;?>;
parent.url[1]="<?print $url1;?>";
parent.mainFrame.location.href="<?print $url1;?>";
</script>
