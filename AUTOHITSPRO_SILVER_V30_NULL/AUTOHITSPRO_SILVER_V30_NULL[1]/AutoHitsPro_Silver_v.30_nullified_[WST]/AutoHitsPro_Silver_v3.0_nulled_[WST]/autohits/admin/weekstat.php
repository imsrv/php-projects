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
	$query = "update ".$t_clear." set date=".(mktime(0,0,0,date("m"),date("d"),date("Y")));
	$result = MYSQL_QUERY($query);	
	$query = "select distinct(email),name,credits,id from ".$t_user." where tmp_mail<".(mktime()-(60*60*24));
//die($query);
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
				for($i=0;$i<=6;$i++){
					$str="";
					$str=preg_replace ("[\[date_r\]]",date( "m.d.Y", mktime(0,0,0,date("m"),date("d")-7+$i,date("Y"))), $body[2][4]);
					$str=preg_replace ("[\[receive\]]",round(100*mysql_result($result1,0,"sum(p$i)"))/100, $str);
					$body_s=$body_s.$str;
				}

				$query1 = "select sum(c1),sum(c2),sum(c3),sum(c4),sum(c5),sum(c6),sum(c0) from ".$t_user." where id=".$row["id"]." ";      
				$result1 = MYSQL_QUERY($query1);
				$body_s=$body_s.$body[2][5];

				for($i=0;$i<=6;$i++){
					$str="";
					$str=preg_replace ("[\[date_e\]]",date( "m.d.Y", mktime(0,0,0,date("m"),date("d")-7+$i,date("Y"))), $body[2][6]);
					$str=preg_replace ("[\[earn\]]",round(100*mysql_result($result1,0,"sum(c$i)"))/100, $str);
					$body_s=$body_s.$str;

				}
				$body_s=$body_s.$body[2][7];
print $row["email"]."<br>".$subject[2]."<br>".nl2br($body_s)."<br>";

				if(!(@mail($row["email"],$subject[2],$body_s,"From: $support_email"))){
					$errarr[$i]=$row["email"];
					$i++;
				}
			 	$query4 = "update ".$t_user." set tmp_mail=".mktime()." where id=".$row["id"];
				$result4 = MYSQL_QUERY($query4);	
			}
 	$query = "update ".$t_user." set c0=0,c1=0,c2=0,c3=0,c4=0,c5=0,c6=0";
	$result = MYSQL_QUERY($query);	
	$query = "update ".$t_site." set p0=0,p1=0,p2=0,p3=0,p4=0,p5=0,p6=0";
	$result = MYSQL_QUERY($query);	
?>