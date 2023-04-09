<?

	function EmailBody($ComposedID, $MemberID, $Format, $EmailBody="")
	{
		GLOBAL $ROOTURL;
		GLOBAL $SendID;
		GLOBAL $CURRENTADMIN;
		global $TABLEPREFIX;
		
		if($EmailBody)
		{
			$email=$EmailBody;
		}
		else
		{
			$email=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "composed_emails WHERE ComposedID='$ComposedID'"));
		}

		//decide which basic version of the email to use!
		if($Format=="HTML")
		{
			$BasicEmail=$email["HTMLBody"];
		}
		else
		{
			$BasicEmail=str_replace("\r\n", "\n", $email["TextBody"]);
		}
		
		$BasicEmail=stripslashes($BasicEmail);

		//now go through the basic fields!
		
		//list fields!
		if($SendID > 0)
		{
			$list_fields=mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_fields");
			
			while($f=mysql_fetch_array($list_fields))
			{
				$mv = mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "list_field_values WHERE FieldID='".$f["FieldID"]."' && UserID='$MemberID'"));
				
				if($f["FieldType"]=="checkbox")
				{
					if($mv["Value"]=="CHECKED")
					{
						$mv["Value"]="Yes";
					}
					else
					{
							$mv["Value"]="No";
					}
				}

				if($f["FieldType"]=="dropdown")
				{
					$opts=explode(";",$f["AllValues"]);
					
					foreach($opts as $opt)
					{
						list($name,$val)=explode("->",$opt);
						
						if($name==$mv["Value"])
						{
								$mv["Value"]=$val;
						}
					}
				}
				
				if($f["FieldType"]=="longtext" && $Format=="HTML")
				{
					$mv["Value"]=nl2br($mv["Value"]);
				}
				
				$BasicEmail  =str_replace("%FIELD:"  .$f["FieldID"] . "%", $mv["Value"], $BasicEmail);
			}
		}
			
		//images
		if($CURRENTADMIN["Manager"] == 1)
		{
			$images=mysql_query("SELECT * FROM " . $TABLEPREFIX . "images");
		}
		else
		{
			$images=mysql_query("SELECT * FROM " . $TABLEPREFIX . "images WHERE AdminID='" . $CURRENTADMIN["AdminID"] . "'");
		}
	
		while($i=mysql_fetch_array($images))
		{
			if($Format=="HTML")
			{
				$tv = '<img src="'.$ROOTURL.'/temp/images/'.$i["ImageID"].".".$i["ImageType"].'">';
			}
			else
			{
				$tv = $ROOTURL.'/temp/images/'.$i["ImageID"].".".$i["ImageType"];
			}

			$tv = str_replace("http:/", "http://", str_replace("//", "/", $tv));
			$BasicEmail=str_replace("%IMAGE:".$i["ImageID"]."%",$tv,$BasicEmail);
		}
			
		//links!
		if($CURRENTADMIN["Manager"] == 1)
		{
			$links=mysql_query("SELECT * FROM " . $TABLEPREFIX . "links");
		}
		else
		{
			$links=mysql_query("SELECT * FROM " . $TABLEPREFIX . "links WHERE AdminID='" . $CURRENTADMIN["AdminID"] . "'");
		}
	
		while($l=mysql_fetch_array($links))
		{
			if($Format=="HTML")
			{
				$tv='<a href="'.$ROOTURL.'users/link.php?LinkID='.$l["LinkID"].'&UserID='.$MemberID.'">'.$l["LinkName"].'</a>';
			}
			else
			{
				$tv=$ROOTURL.'users/link.php?LinkID='.$l["LinkID"].'&UserID='.$MemberID;
			}
			
			$BasicEmail=str_replace("%LINK:".$l["LinkID"]."%",$tv,$BasicEmail);
		}	
				
		//basic tags!
		$mem=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "members WHERE MemberID='$MemberID'"));
		$BasicEmail=str_replace("%BASIC:EMAIL%",$mem["Email"],$BasicEmail);
		
		if($mem["Confirmed"]==1)
		{
			$c="Confirmed";
		}
		else
		{
			$c="Unconfirmed";
		}
		
		$BasicEmail = str_replace("%BASIC:CONFIRMATION%",$c,$BasicEmail);

		if($mem["Status"]==1)
		{
			$c="Active";
		}
		else
		{
			$c="Inactive";
		}
		
		$BasicEmail=str_replace("%BASIC:STATUS%",$c,$BasicEmail);
		
		if($mem["Format"]==1)
		{
			$c="HTML";
		}
		else
		{
			$c="Text";
		}
		
		$BasicEmail=str_replace("%BASIC:FORMAT%",$c,$BasicEmail);
		$BasicEmail=str_replace("%BASIC:SUBDATE%",DisplayDate($mem["SubscribeDate"]),$BasicEmail);
	
		if($Format == "HTML")
			$BasicEmail=str_replace("%BASIC:UNSUBLINK%", "<a href=" . $ROOTURL . "users/unsub.php?Email=" . $mem["Email"] . "&ConfirmCode=" . $mem["ConfirmCode"] . ">" . $ROOTURL . "users/unsub.php?Email=" . $mem["Email"] . "&ConfirmCode=" . $mem["ConfirmCode"] . "</a>", $BasicEmail);
		else
			$BasicEmail=str_replace("%BASIC:UNSUBLINK%", $ROOTURL . "users/unsub.php?Email=" . $mem["Email"] . "&ConfirmCode=" . $mem["ConfirmCode"], $BasicEmail);
		
		return $BasicEmail;
	}


	function CreateEmail($SendID, $MemberID, $Format)
	{
		GLOBAL $ROOTURL;
		GLOBAL $TABLEPREFIX;

		$send=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "sends WHERE SendID='$SendID'"));
		$member=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "members WHERE MemberID='$MemberID'"));
		$email=mysql_fetch_array(mysql_query("SELECT * FROM " . $TABLEPREFIX . "composed_emails WHERE ComposedID='".$send["ComposedID"]."'"));

		if($Format==1)
		{
			//html version
			$EmailBody=EmailBody($email["ComposedID"],$MemberID,"HTML")."\n\n".'<img src="'.$ROOTURL.'users/sendopen.php?MemberID='.$MemberID.'&SendID='.$SendID.'" width="1" height="1">';
			$Headers="From: ".$send["SendFrom"]."\nX-Mailer: SendStudio\nContent-Type: text/html\nReply-To: " . $send["ReplyTo"] . "\nReturn-Path: " . $send["ReturnPath"];
			$SendTo=$member["Email"];
		}
		else if($Format==2)
		{
			//textbased
			$EmailBody=EmailBody($email["ComposedID"],$MemberID,"TEXT");
			$Headers="From: ".$send["SendFrom"]."\nX-Mailer: SendStudio\nContent-Type: text/plain\nReply-To: " . $send["ReplyTo"] . "\nReturn-Path: " . $send["ReturnPath"];
			$SendTo=$member["Email"];
		}
		else
		{
			//format==3 
			//multipart version

			$notice_text = "";

			$EmailBodyH = EmailBody($email["ComposedID"], $MemberID, "HTML") . "\n\n" . '<img src="' . $ROOTURL . 'users/sendopen.php?MemberID=' . $MemberID . '&SendID=' . $SendID . '" width="1" height="1">';
			
			$EmailBodyT = EmailBody($email["ComposedID"], $MemberID, "TEXT");

			$semi_rand = md5(time());
			$mime_boundary = "==MULTIPART_BOUNDARY_$semi_rand";
			$mime_boundary_header = chr(34) . $mime_boundary . chr(34);

$EmailBody = "$notice_text

--$mime_boundary
Content-Type: text/plain; charset=us-ascii
Content-Transfer-Encoding: 7bit

$EmailBodyT

--$mime_boundary
Content-Type: text/html; charset=us-ascii
Content-Transfer-Encoding: 7bit

$EmailBodyH

--$mime_boundary--";

			$SendTo = $member["Email"];

			$Headers  = "From: " . $send["SendFrom"] . "\n";
			$Headers .= "Reply-To: " . $send["ReplyTo"] . "\n";
			$Headers .= "Return-Path: " . $send["ReturnPath"] . "\n";
			$Headers .= "X-Mailer: SendStudio\n";
			$Headers .= "MIME-Version: 1.0\n";
			$Headers .= "Content-Type: multipart/alternative;\n" . 
			"     boundary=" . $mime_boundary_header;
		}

		$Email["Subject"]=$email["Subject"];
		$Email["Body"]=$EmailBody;
		$Email["Email"]=$SendTo;
		$Email["Headers"]=$Headers;

		return $Email;
	}

?>