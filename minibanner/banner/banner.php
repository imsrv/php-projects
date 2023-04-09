<?php
	class Banner
	{
		var $banner_id;
		var $con;
		var $isExpired;

		function Banner($campaign_id)
		{
			$this->isExpired = 0;
			$this->con = mysql_connect('localhost','ykf2000','aspykf88');			
			mysql_select_db('ykf2000');
			$this->Expiration($campaign_id);
			$banner = $this->getBanner($campaign_id);
			$this->showBanner($banner);
			if($this->isExpired == 0)
				$this->updateStatistic($this->banner_id);
		}

		function Expiration($campaign_id)
		{
			$SQL = "SELECT clicks,views FROM campaign WHERE id = $campaign_id AND (NOW() BETWEEN start_date AND end_date)";
			$result = mysql_query($SQL,$this->con);
			if(mysql_affected_rows()>0)
			{
				$row = mysql_fetch_array($result);
				$target_clicks = $row['clicks'];
				$target_views = $row['views'];
				mysql_free_result($result);
				$SQL = "SELECT clicks, views FROM banner_stat WHERE campaign_id = $campaign_id";
				$result = mysql_query($SQL,$this->con);
				if(mysql_affected_rows()>0)
				{
					while($row = mysql_fetch_array($result))
					{
						$total_clicks += $row['clicks'];
						$total_views += $row['views'];
					}
				}
				else
				{
					$this->isExpired = 0;
				}
				if((($total_clicks >= $target_clicks) && ($target_clicks != 0)) || (($total_views >= $target_views) && ($target_views !=0)))
				{
					$this->isExpired = 1;
				}
				else
				{
					$this->isExpired = 0;
				}
			}
			else
			{
				$this->isExpired = 1;
			}				

		}

		function getBanner($campaign_id)
		{
			if($this->isExpired == 1)
			{
				$SQL = "SELECT banner.id, graphic, url, alt, banner_size.size FROM banner,banner_size WHERE campaign_id = $campaign_id AND banner.size=banner_size.id AND master='y'";
			}
			else
			{
				$SQL = "SELECT banner.id, graphic, url, alt, banner_size.size FROM banner,banner_size WHERE campaign_id = $campaign_id AND banner.size=banner_size.id ORDER BY RAND()";
			}
			$result = mysql_query($SQL,$this->con);
			$row = mysql_fetch_array($result);
			$this->banner_id = $row['id'];
			$dimension = explode('x',$row['size']);
			if($this->isExpired==1)
			{
				$banner = "document.write(\"<a href='http://www.miniscript.com/banner/redirect.php?bid=".$this->banner_id."&url=".$row['url']."&expired=1'><img src='".$row['graphic']."' border='0' width='".rtrim(ltrim($dimension[0]))."' height='".rtrim(ltrim($dimension[1]))."' alt=\\\"".$row['alt']."\\\"></a>\");";
			}
			else
			{
				$banner = "document.write(\"<a href='http://www.miniscript.com/banner/redirect.php?bid=".$this->banner_id."&url=".$row['url']."&expired=0'><img src='".$row['graphic']."' border='0' width='".rtrim(ltrim($dimension[0]))."' height='".rtrim(ltrim($dimension[1]))."' alt=\\\"".$row['alt']."\\\"></a>\");";
			}
			mysql_free_result($result);			
			return $banner;
		}
	
		function showBanner($banner)
		{
			print $banner;
		}

		function upDateStatistic($banner_id)
		{
			$SQL = "UPDATE banner_stat SET views = views + 1 WHERE banner_id = $banner_id";
			mysql_query($SQL,$this->con);					
		}
	}
?>
