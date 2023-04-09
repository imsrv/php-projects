<?php
//  ___  ____       _  ______ _ _        _   _           _   
//  |  \/  (_)     (_) |  ___(_) |      | | | |         | |  
//  | .  . |_ _ __  _  | |_   _| | ___  | |_| | ___  ___| |_ 
//  | |\/| | | '_ \| | |  _| | | |/ _ \ |  _  |/ _ \/ __| __|
//  | |  | | | | | | | | |   | | |  __/ | | | | (_) \__ \ |_ 
//  \_|  |_/_|_| |_|_| \_|   |_|_|\___| \_| |_/\___/|___/\__|
//
// by MiniFileHost.co.nr                  version 1.1
//////////////////////////////////////////////////////// ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<META NAME="revisit-after" CONTENT="2 days">
<link rel="SHORTCUT ICON" href="favicon.ico">
</head>
<body>
<p><center>
  <h2>FileUploading - The world's biggest 1-Click Webhoster</h2>
</center></p>

<center>
  <center>
    Host your files with FileUploading FOR FREE!<br>
    1. Select your file and press upload<br>
    2. Receive download-link and share it
  </center>
</center>
	<br />
	<center>
	<form enctype="multipart/form-data" action="upload.php" id="form" method="post" onsubmit="a=document.getElementById('form').style;a.display='none';b=document.getElementById('part2').style;b.display='inline';" style="display: inline;">
	  <p><br />
	    <?php echo $filetypes; ?>
	    <input type="file" name="upfile" size="64" />
	    <input name="submit" type="submit" id="upload" value="Upload!" />
      </p>
	  <p><strong>Upload-limit: Unlimited!</strong> (Max. <strong><u>300 MB</u></strong> per file! Split-archives allowed!)<br>
      <strong>Download-limit: Unlimited!</strong> (Some files have more than 100.000 downloads!)</p>
	  <p><script type="text/javascript"><!--
google_ad_client = "pub-4464320630320644";
google_ad_width = 728;
google_ad_height = 90;
google_ad_format = "728x90_as";
google_ad_type = "text_image";
google_ad_channel ="0853535243";
google_color_border = "336699";
google_color_bg = "FFFFFF";
google_color_link = "0000FF";
google_color_text = "000000";
google_color_url = "008000";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></a>&nbsp;</p>
	  <p>RapidShare, the world's biggest (<strong>over 23 million files uploaded!</strong>)  and fastest (<strong>45 Gigabit/s up/down!</strong>) 1-click file-hoster.<br>
Burning the net with 360 Terabytes of hard-drive capacity right now and growing! Millions of users just can't be wrong.</p>
	  <p><center>
	</center>
	</form><div id="part2" style="display: none;">
<script language="javascript" src="xp_progress.js"></script>
Upload in progress. Please Wait... 
<BR><BR>
<script type="text/javascript">
var bar1= createBar(300,15,'white',1,'black','blue',85,7,3,"");</script>
</div>	
	<p></center></td></tr></table>
<p style="margin:3px;text-align:center">
