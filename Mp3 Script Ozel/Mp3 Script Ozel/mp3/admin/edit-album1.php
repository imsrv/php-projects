<? include ("../pages-setting.php") ?>
<?php

if (isset($_COOKIE['admincenter'])) {

   if ($_COOKIE['admincenter'] == md5($password.$randomword)) {

?>
<html>
<? 
$_GET["id"];
?>
<?
$id = $_GET["id"];
?>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?=$pagetitle?></title>
	<link href="../style.css" rel="stylesheet" type="text/css">
<!-- LEECHED FROM www.BestART.ws --->

<style type="text/css">
<!--
.style3 {
	font-size: 36px;
	font-family: "Baveuse 3D";
	color: #FF9300;
	font-weight: bold;
}
.style7 {
	font-family: "Times New Roman", Times, serif;
	font-size: 16px;
}
.style15 {
	font-size: 16px;
	font-weight: bold;
}
.style20 {font-size: 11px}
a:link {
	color: #009900;
}
-->
</style></head>

<body  >
<table cellpadding="0" cellspacing="0" border="0" align="center"   style="width:100%; height:900px ">
		  <tr>
			<td valign="top" style=" width:100%; height:900px " >
				<table  border="0" cellspacing="0" cellpadding="0" style="width:100% ">
				  <tr>
					<td valign="top"  style="width:100%; background:URL(images/tall1.jpg) repeat-x" height="799" align="center">
						<table  border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td valign="top" width="702" height="160">
									<table  border="0" cellspacing="0" cellpadding="0">
									  <!--DWLayoutTable-->
									  <tr>
										<td width="702" height="160" valign="top"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="749" height="170">
                                          <param name="movie" value="../flash/header.swf">
                                          <param name="quality" value="high">
                                          <embed src="../flash/header.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="702" height="159"></embed>
									    </object></td>
									  </tr>
									</table>
								</td>
							  </tr>
							  <tr>
								<td valign="top" width="702" height="639">
									<table  border="0" cellspacing="0" cellpadding="0">
									  <tr>
										<td valign="top" width="439" height="639" style="background-color:#292929 ">
											<table  border="0" cellspacing="0" cellpadding="0" style="background:URL(images/back_bot.gif) no-repeat bottom; height:100%">
											  <!--DWLayoutTable-->
											  <tr>
												<td width="439" height="207" valign="top"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="486" height="229">
                                                  <param name="movie" value="../flash/banner.swf">
                                                  <param name="quality" value="high">
                                                  <embed src="../flash/banner.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="479" height="247"></embed>
											    </object></td>
											  </tr>
											  <tr>
												<td height="529" valign="top">												 											 	  <div style="margin-left:25px; margin-top:18px ">														
												  <p><em><span class="style3"> </span></em>ADMIN:</p>
												  <p align="center"><a href="add-album.php">ADD NEW ALBUM</a> | <a href="add-video.php">ADD NEW VIDEO</a> | <a href="edit-album.php">EDIT ADDED ALBUM</a> | <a href="edit-video.php">EDIT ADDED VIDEO</a> | <a href="delete-album.php">DELETE ALBUM</a> | <a href="delete-video.php">DELETE VIDEO</a> | <a href="add-news.php">ADD NEWS</a>  </p>
												
  <?php 
include("../config.php");
mysql_connect($db_host,$db_user,$db_pass) or die(mysql_error()); 
mysql_select_db($db_name) or die(mysql_error());
?> 
<div align="left">
	<table cellpadding="0" cellspacing="0" width="461" height="144">
	   <?php
	   $id=$_GET["id"];
												include ("../config.php"); 
											mysql_connect($db_host,$db_user,$db_pass) or die(mysql_error()); 
											mysql_select_db($db_name) or die(mysql_error());

												$result = mysql_query("SELECT * FROM mp3 WHERE id LIKE '$id'");
												while($r=mysql_fetch_array($result))
												{
												$album=$r["album"];
												$date=$r["date"];
												$artist=$r["artist"];
												$id=$r["id"];
												$img=$r["img"];
												$text1=$r["text1"];
												$link1=$r["link1"];	
												$text2=$r["text2"];	
												$link2=$r["link2"];				
												$text3=$r["text3"];
												$link3=$r["link3"];
												$text4=$r["text4"];
												$link4=$r["link4"];
												$text5=$r["text5"];
												$link5=$r["link5"];
												$text6=$r["text6"];
												$link6=$r["link6"];
												$text7=$r["text7"];
												$link7=$r["link7"];
												$text8=$r["text8"];
												$link8=$r["link8"];
												$text9=$r["text9"];
												$link9=$r["link9"];
												$text10=$r["text10"];
												$link10=$r["link10"];
												$id=$r["id"];
												}
												?>

		<tr><td width="124" height="19"><form method="POST" action="edit-album-process.php">
	    <td colspan="2" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
	    <td colspan="3" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
	    
		<tr>
			<td height="17" valign="top">
			<p align="left"><font face="Verdana" style="font-size: 8pt">Album</font></td>
			<td colspan="2" valign="top">
													<p align="left">
													<input  name="album" size="15" style="font-family: Verdana; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff" value="<?=$album?>" size="20"></td>
			<td width="2" valign="top">
		  </td>
			<td width="113">
			<p align="left">
			<font face="Verdana" style="font-size: 8pt" color="#009900">Track 1 name </font></td>
			<td width="114" valign="top">
			<p align="left"><input type="text" name="text1" size="15"  style="font-family: Tahoma; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$text1?>" size="20"></td>
		</tr>
		<tr>
			<td height="17" valign="top">
			<p align="left"><font face="Verdana" style="font-size: 8pt">Artist</font></td>
			<td colspan="2" valign="top">
													<p align="left">
													<input  name="artist" size="15" style="font-family: Verdana; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$artist?>" size="20"></td>
			<td valign="top">
		  </td>
			<td>
			<p align="left"><font face="Verdana" style="font-size: 8pt">Track 1 Link</font></td>
			<td>
			<p align="left">
													<input type="text" name="link1" size="15" dir="ltr" style="font-family: Tahoma; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$link1?>" size="20"></td><?=?>
		</tr>
		<tr>
			<td height="17" valign="top">
			<p align="left">
			<font style="font-size: 8pt; font-style: normal" face="Verdana">
			Added Date </font></td>
			<td colspan="2" valign="top">
													<p align="left">
													<input name="date" size="15" style="font-family: Verdana; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$date?>" size="20"></td>
			<td valign="top">
		  </td>
			<td>
			<p align="left">
			<font face="Verdana" style="font-size: 8pt" color="#009900">Track 2 name</font></td>
			<td>
			<p align="left">
													<input type="text" name="text2" size="15" style="font-family: Tahoma; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$text2?>" size="20"></td>
		</tr>
		<tr>
			<td height="17" valign="top">
			<p align="left"><font face="Verdana" style="font-size: 8pt">Album Image (url)</font></td>
			<td colspan="2" valign="top">
													<p align="left">
													<input name="img" size="15"  style="font-family: Verdana; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$img?>" size="20"></td>
			<td valign="top">
		  </td>
			<td>
			<p align="left"><font face="Verdana" style="font-size: 8pt">Track 2 Link</font></td>
			<td>
			<p align="left">
													<input type="text" name="link2" size="15" dir="ltr" style="font-family: Tahoma; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$link2?>" size="20"></td>
		</tr>
		<tr>
			<td colspan="2" rowspan="2" valign="top">
			  <p align="left"><font face="Verdana" style="font-size: 8pt">First Letter Of artist name : </font></td>
			<td width="70" rowspan="2" valign="top">
													<p align="left">
													  <select size="1" name="artistabc" style="font-family: Verdana; font-size: 8pt; color: #009900; border: 1px dotted #000000; background-color: #ffffff">
													<option>A</option>
													<option>B</option>
													<option>C</option>
													<option>D</option>
													<option>E</option>
													<option>F</option>
													<option>G</option>
													<option>H</option>
													<option>I</option>
													<option>J</option>
													<option>K</option>
													<option>L</option>
													<option>M</option>
													<option>N</option>
													<option>O</option>
													<option>P</option>
													<option>Q</option>
													<option>R</option>
													<option>S</option>
													<option>T</option>
													<option>U</option>
													<option>V</option>
													<option>W</option>
													<option>X</option>
													<option>Y</option>
													<option>Z</option>
													</select>
			                                                                                </td>
			<td height="20" valign="top">
		  </td>
			<td>
			<p align="left">
			<font face="Verdana" style="font-size: 8pt" color="#009900">Track 3 name</font></td>
			<td>
			<p align="left">
													<input type="text"  name="text3" size="15" style="font-family: Tahoma; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$text3?>" size="20"></td>
		</tr>
		<tr>
			<td height="4" valign="top">
		  </td>
			<td rowspan="3">
			<p align="left"><font face="Verdana" style="font-size: 8pt">Track 3 Link</font></td>
			<td rowspan="3">
			<p align="left">
													<input type="text" name="link3" size="15" style="font-family: Tahoma; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$link3?>" size="20"></td>
		</tr>
		<tr>
		  <td height="19" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
		  <td colspan="2" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
		  <td valign="top"></td>
	  </tr>
		<tr>
		  <td rowspan="2" valign="top">
												  <p align="left">
													<input type="submit" value="Submit" name="submit" style="font-family: Verdana; font-size: 8pt; color: #009900; border: 1px solid #009900; background-color: #ffffff">
		  </td>
			<td colspan="2" rowspan="2" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
		  <td height="3" valign="top"></td>
	  </tr>
		<tr>
		  <td height="19" valign="top">
		  </td>
			<td>
			<p align="left">
			<font face="Verdana" style="font-size: 8pt" color="#009900">Track 4 name</font></td>
			<td>
			<p align="left">
													<input type="text"  name="text4" size="15" style="font-family: Tahoma; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$text4?>" size="20"></td>
		</tr>
		<tr>
			<td height="19">
			<p align="left"></td>
			<td colspan="2">
			<p align="left"></td>
			<td>
			</td>
			<td>
			<p align="left"><font face="Verdana" style="font-size: 8pt">Track 4 Link</font></td>
			<td>
			<p align="left">
													<input type="text" name="link4" size="15" dir="ltr" style="font-family: Tahoma; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$link4?>" size="20"></td>
		</tr>
		<tr>
			<td height="20" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
			<td colspan="2">
			<p align="left"></td>
			<td>
			</td>
			<td>
			<p align="left">
			<font face="Verdana" style="font-size: 8pt" color="#009900">Track 5 name</font></td>
			<td>
			<p align="left">
													<input type="text" name="text5" size="15" style="font-family: Tahoma; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$text5?>" size="20"></td>
		</tr>
		<tr>
			<td height="19">
			<p align="left"></td>
			<td colspan="2">
			<p align="left"></td>
			<td>
			</td>
			<td>
			<p align="left"><font face="Verdana" style="font-size: 8pt">Track 5 Link</font></td>
			<td>
			<p align="left">
													<input type="text" name="link5" size="15" dir="ltr" style="font-family: Tahoma; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$link5?>" size="20"></td>
		</tr>
		<tr>
			<td height="19">
			<p align="left"></td>
			<td colspan="2">
			<p align="left"></td>
			<td>
			</td>
			<td>
			<p align="left">
			<font face="Verdana" style="font-size: 8pt" color="#009900">Track 6 name</font></td>
			<td>
			<p align="left">
													<input type="text"  name="text6" size="15"  style="font-family: Tahoma; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$text6?>" size="20"></td>
		</tr>
		<tr>
			<td height="19">
			<p align="left"></td>
			<td colspan="2">
			<p align="left"></td>
			<td>
			</td>
			<td>
			<p align="left"><font face="Verdana" style="font-size: 8pt">Track 6 Link</font></td>
			<td>
			<p align="left">
													<input type="text" name="link6" size="15" dir="ltr" style="font-family: Tahoma; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$link6?>" size="20"></td>
		</tr>
		<tr>
			<td height="19">
			<p align="left"></td>
			<td colspan="2">
			<p align="left"></td>
			<td>
			</td>
			<td>
			<p align="left">
			<font face="Verdana" style="font-size: 8pt" color="#009900">Track 7 name</font></td>
			<td>
			<p align="left">
													<input type="text" name="text7" size="15" style="font-family: Tahoma; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$text7?>" size="20"></td>
		</tr>
		<tr>
			<td height="19">
			<p align="left"></td>
			<td colspan="2">
			<p align="left"></td>
			<td>
			</td>
			<td>
			<p align="left"><font face="Verdana" style="font-size: 8pt">Track 7 Link</font></td>
			<td>
			<p align="left">
													<input type="text" name="link7" size="15" dir="ltr" style="font-family: Tahoma; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$link7?>" size="20"></td>
		</tr>
		<tr>
			<td height="19">
			<p align="left"></td>
			<td colspan="2">
			<p align="left"></td>
			<td>
			</td>
			<td>
			<p align="left">
			<font face="Verdana" style="font-size: 8pt" color="#009900">Track 8 name</font></td>
			<td>
			<p align="left">
													<input type="text" name="text8" size="15" style="font-family: Tahoma; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$text8?>" size="20"></td>
		</tr>
		<tr>
			<td height="19">
			<p align="left"></td>
			<td colspan="2">
			<p align="left"></td>
			<td>
			</td>
			<td>
			<p align="left"><font face="Verdana" style="font-size: 8pt">Track 8 Link</font></td>
			<td>
			<p align="left">
													<input type="text" name="link8" size="15" dir="ltr" style="font-family: Tahoma; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$link8?>" size="20"></td>
		</tr>
		<tr>
			<td height="19">
			<p align="left"></td>
			<td colspan="2">
			<p align="left"></td>
			<td>
			</td>
			<td>
			<p align="left">
			<font face="Verdana" style="font-size: 8pt" color="#009900">Track 9 name</font></td>
			<td>
			<p align="left">
													<input type="text" name="text9" size="15" style="font-family: Tahoma; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$text9?>" size="20"></td>
		</tr>
		<tr>
			<td height="19">
			<p align="left"></td>
			<td colspan="2">
			<p align="left"></td>
			<td>
			</td>
			<td>
			<p align="left"><font face="Verdana" style="font-size: 8pt">Track 9 Link</font></td>
			<td>
			<p align="left">
													<input type="text" name="link9" size="15" dir="ltr" style="font-family: Tahoma; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$link9?>" size="20"></td>
		</tr>
		<tr>
			<td height="19">
			<p align="left"></td>
			<td colspan="2">
			<p align="left"></td>
			<td>
			</td>
			<td>
			<p align="left">
			<font face="Verdana" style="font-size: 8pt" color="#009900">Track 10 name</font></td>
			<td>
			<p align="left">
													<input type="text"  name="text10" size="15" style="font-family: Tahoma; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$text10?>" size="20"></td>
		</tr>
		<tr>
			<td height="19">
			<p align="left"></td>
			<td colspan="2">
			<p align="left"></td>
			<td>
			</td>
			<td>
			<p align="left"><font face="Verdana" style="font-size: 8pt">Track 10 Link</font></td>
			<td>
			<p align="left">
													<input type="text" name="link10" size="15" dir="ltr" style="font-family: Tahoma; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$link10?>" size="20"></td>
		</tr>
		<td>
			<p align="left"><font face="Verdana" style="font-size: 8pt">Write The Following Code:</font></td>
			<td>
			<p align="left">
													<input type="text" name="id" size="15" dir="ltr" style="font-family: Tahoma; font-size: 8pt; color: #FF6600; border: 1px dotted #000000; background-color: #ffffff"value="<?=$id?>" size="20"></td>
		</tr>
		<td>
			<p align="left"><font face="Verdana" style="font-size: 8pt"><?=$id?></font></td>
			<td>
		<tr>
			<td height="19">
			<p align="left"></td>
			<td colspan="3">
			<p align="left"></td>
			<td>
			<p align="left"></td>
			<td>
			<p align="left"></td>
		</tr>
		<tr>
		  <td height="3"></td>
		  <td width="26"></td>
		  <td></td>
		  <td></td>
		  <td></td>
		  <td></td>
	  </tr>
	</table>
</div>
</form>
														<br style="line-height:13px ">
														<br>
														<br style="line-height:20px ">
												</div></td>
											  </tr>
											</table>
										</td>
										<td valign="top" width="263" height="639" style="background-color:#404040 ">
											<table  border="0" cellspacing="0" cellpadding="0">
											  <tr>
												<td valign="top" width="10" height="639"></td>
												<td valign="top" width="243" height="639">
													<table  border="0" cellspacing="0" cellpadding="0">
													  <tr>
														<td valign="top" width="243" height="40">
															<table  border="0" cellspacing="0" cellpadding="0">
															  <!--DWLayoutTable-->
															  <tr>
																<td width="156" height="13"></td>
													    <td width="87" rowspan="2" align="right" valign="top" style="background:URL(images/back3.gif) no-repeat left top">
																	<div align="center"><br style="line-height:13px "><html>
<center>

<div id=Clock align=Center style="font-family Tahoma; font-size: 11; color:#9C9C9C"> </div>

<script language = "JavaScript">

//This script was created by Gary Perry 
//Email: shadow_chaser@hotmail.com
//Web: http://www.garyperry.com

//This script will display a real time clock at the top of your webpage.


//Put this code in the body section of your webpage, and that's all
//there is to it. No images to worry about, nothing, except it
//only works for IE 4 and above. 

//Change the color of the font above in the div tag to match your webpage
//colors. 


function tick() {
  var hours, minutes, seconds, ap;
  var intHours, intMinutes, intSeconds;
  var today;

  today = new Date();

  intHours = today.getHours();
  intMinutes = today.getMinutes();
  intSeconds = today.getSeconds();

  switch(intHours){
       case 0:
           intHours = 12;
           hours = intHours+":";
           ap = "A.M.";
           break;
       case 12:
           hours = intHours+":";
           ap = "P.M.";
           break;
       case 24:
           intHours = 12;
           hours = intHours + ":";
           ap = "A.M.";
           break;
       default:    
           if (intHours > 12)
           {
             intHours = intHours - 12;
             hours = intHours + ":";
             ap = "P.M.";
             break;
           }
           if(intHours < 12)
           {
             hours = intHours + ":";
             ap = "A.M.";
           }
    }       
  
          
  if (intMinutes < 10) {
     minutes = "0"+intMinutes+":";
  } else {
     minutes = intMinutes+":";
  }

  if (intSeconds < 10) {
     seconds = "0"+intSeconds+" ";
  } else {
     seconds = intSeconds+" ";
  } 

  timeString = hours+minutes+seconds+ap;

  Clock.innerHTML = timeString;

  window.setTimeout("tick();", 100);
}

window.onload = tick;

</script>

</html>
																	
																  </div></td>
															  </tr>
															  <tr>
															    <td height="27" valign="top"><div align="center"><html>
          <center>
          
<script language="JavaScript">
<!-- This figures out what day of the week it is, and the date, and year. -->
<!--
        s_date = new Date();
        var weekDay = "";

        selectMonth = new Array(12);
                selectMonth[0] = "January";
                selectMonth[1] = "February";
                selectMonth[2] = "March";
                selectMonth[3] = "April";
                selectMonth[4] = "May";
                selectMonth[5] = "June";
                selectMonth[6] = "July";
                selectMonth[7] = "August";
                selectMonth[8] = "September";
                selectMonth[9] = "October";
                selectMonth[10] = "November";
                selectMonth[11] = "December";

        if(s_date.getDay() == 1){
                weekDay = "Monday";
        }
        if(s_date.getDay() == 2){
                weekDay = "Tuesday";
        }
        if(s_date.getDay() == 3){
                weekDay = "Wednesday";
        }
        if(s_date.getDay() == 4){
                weekDay = "Thursday";
        }
        if(s_date.getDay() == 5){
                weekDay = "Friday";
        }
        if(s_date.getDay() == 6){
                weekDay = "Saturday";
        }
        if(s_date.getDay() == 7){
                weekDay = "Sunday";
        }
        if(s_date.getDay() == 0){
                weekDay = "Sunday";
        }


        var setYear = s_date.getYear();

 var BName = navigator.appName;

 if(BName == "Netscape"){
         var setYear = s_date.getYear() + 1900;
}

document.write(weekDay + ", " + selectMonth[s_date.getMonth()] + " " +
s_date.getDate() + ", " + setYear);

// -->

</script>
										                        </div></td>
													    </tr>
															</table>
														</td>
													  </tr>
													  <tr>
														<td valign="top" width="243" height="210" style="background-color:#292929 ">
															<table  border="0" cellspacing="0" cellpadding="0" style="background:URL(images/tall_b.gif) repeat-x top; width:100%; height:100%">
															  <tr>
																<td valign="top" style="background:URL(images/tall_b.gif) repeat-y right; width:100%; height:100%">
																	<table  border="0" cellspacing="0" cellpadding="0" style="background:URL(images/tall_b.gif) repeat-x bottom; width:100%; height:100%">
																	  <tr>
																		<td valign="top"  style="background:URL(images/tall_b.gif) repeat-y left; width:100%; height:100%">
																			<table  border="0" cellspacing="0" cellpadding="0" style="background:URL(images/l_t.gif) no-repeat left top; width:100%; height:100%">
																			  <tr>
																				<td valign="top" style="background:URL(images/r_t.gif) no-repeat right top; width:100%; height:100%">
																					<table  border="0" cellspacing="0" cellpadding="0" style="background:URL(images/l_b.gif) no-repeat left bottom; width:100%; height:100%">
																					  <tr>
																						<td valign="top" style="background:URL(images/r_b.gif) no-repeat right bottom; width:100%; height:100%">
																							<div style="margin-left:11px; margin-top:12px ">																						    
																							  <p align="center">Welcome To
                                                                                                  <?=$sitename?>
                                                                                              </p>
																							  <p align="center">This Website Powered By Persian MP3 Which is writen by A.Ghotbi (Persian Script Team),This Script Is Completely Free And You Can Download It From Www.Persianscript.com. If You Have Any Comments or Sugestion You can Contact us : nomad_6_6_6@hotmail.com and nomad_6_6_6@yahoo.com, And You Can Also contact Us With The Form In Contact Us page of Our Official Website. And If You Need Any CMS Script You Can Also Order It And We Will Do It For Free!!!</p>
																							</div>
																						</td>
																					  </tr>
																					</table>
																				</td>
																			  </tr>
																			</table>
																		</td>
																	  </tr>
																	</table>
																</td>
															  </tr>
															</table>
														</td>
													  </tr>
													  <tr>
														<td valign="top" width="243" height="10"></td>
													  </tr>
													  <tr>
														<td valign="top" width="243" height="150"><a href="#"><img src="../images/ban2.jpg" alt="" width="243" height="150" border="0"></a></td>
													  </tr>
													  <tr>
														<td valign="top" width="243" height="10"></td>
													  </tr>
													  <tr>
														<td valign="top" width="243" height="208" style="background-color:#292929 ">
															<table  border="0" cellspacing="0" cellpadding="0" style="background:URL(images/tall_b.gif) repeat-x top; width:100%; height:100%">
															  <tr>
																<td valign="top" style="background:URL(images/tall_b.gif) repeat-y right; width:100%; height:100%">
																	<table  border="0" cellspacing="0" cellpadding="0" style="background:URL(images/tall_b.gif) repeat-x bottom; width:100%; height:100%">
																	  <tr>
																		<td valign="top"  style="background:URL(images/tall_b.gif) repeat-y left; width:100%; height:100%">
																			<table  border="0" cellspacing="0" cellpadding="0" style="background:URL(images/l_t.gif) no-repeat left top; width:100%; height:100%">
																			  <tr>
																				<td valign="top" style="background:URL(images/r_t.gif) no-repeat right top; width:100%; height:100%">
																					<table  border="0" cellspacing="0" cellpadding="0" style="background:URL(images/l_b.gif) no-repeat left bottom; width:100%; height:100%">
																					  <tr>
																						<td valign="top" style="background:URL(images/r_b.gif) no-repeat right bottom; width:100%; height:100%">																						  
																						  <div style="margin-left:11px; margin-top:15px ">
																								<p>Request You Favorite Song/Video</p>
																							<form action="../musicrequest.php" method="post" name="form1" target="_blank">
                                                                                                  <p align="left">Your Name :
                                                                                                      <input name="your_name" type="text" id="your_name">
                                                                                                  </p>
                                                                                                  <p align="left">Your Email :
                                                                                                      <input name="your_email" type="text" id="your_email">
                                                                                                  </p>
                                                                                                  <p align="left">Type :
                                                                                                      <select name="type" id="type">
                                                                                                        <option>---------</option>
                                                                                                        <option>Album</option>
                                                                                                        <option>Music</option>
                                                                                                        <option>Video</option>
                                                                                                      </select>
                                                                                                  </p>
                                                                                                  <p align="left"><span class="style20">Artist : </span>
                                                                                                      <input name="artist" type="text" id="artist">
                                                                                                  </p>
                                                                                                  <p align="left"><span class="style20">Album/Music/Video name : </span>
                                                                                                      <input name="album_name" type="text" id="album_name">
                                                                                                  </p>
                                                                                              <p align="center">
                                                                                                <input type="submit" name="Submit" value="Submit">
                                                                                                <input type="reset" name="Submit2" value="Reset">
																							        <br>
																						  </p>
																						    </form>
																						  </div>
																						</td>
																					  </tr>
																					</table>
																				</td>
																			  </tr>
																			</table>
																		</td>
																	  </tr>
																	</table>
																</td>
															  </tr>
															</table>
														</td>
													  </tr>
													  <tr>
														<td valign="top" width="243" height="11"></td>
													  </tr>
													</table>
												</td>
												<td valign="top" width="10" height="639"></td>
											  </tr>
											</table>
										</td>
									  </tr>
									</table>
								</td>
							  </tr>
				    </table>					</td>
				  </tr>
				  <tr>
					<td valign="top"  style="width:100%; background:URL(images/tall2.gif) repeat-x;" height="101">
						<table  border="0" cellspacing="0" cellpadding="0" align="center">
						  <tr>
							<td valign="top" width="702" height="101" align="center" class="pol">
								<br style="line-height:30px ">
							  <a href="#" class="pol"><? include ("../dn-menu.php"); ?>
							  <?php

      exit;

   } else {

      echo "<p align='right'><font face='Tahoma'  style='font-size: 8pt'>Bad Login , Please Delete Cookies</font></p>";

      exit;

   }

}



if (isset($_GET['p']) && $_GET['p'] == "login") {

   if ($_POST['name'] != $username) {

      echo "<p align=right><font face='Tahoma' style='font-size: 8pt'>Your username or password is not correct!</font></p>";

      exit;

   } else if ($_POST['pass'] != $password) {

      echo "<p align=right><font face='Tahoma' ' style='font-size: 8pt'>Your username or password is not correct!</font></p>";

      exit;

   } else if ($_POST['name'] == $username && $_POST['pass'] == $password) {

      setcookie('admincenter', md5($_POST['pass'].$randomword));

      header("Location: $_SERVER[PHP_SELF]");

   } else {

      echo "<p align=right><font face='Tahoma' style='font-size: 8pt'>Your username or password is not correct!</font></p>";

   }

}

?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=login" method="post"><fieldset>

<label><font face='Tahoma' style='font-size: 8pt'>Username : </font></label> <input type="text" name="name" id="name" /><br />

<label><font face='Tahoma'  style='font-size: 8pt'>Password : </font></label> <input type="password" name="pass" id="pass" /><br />

<input type="submit" id="submit" value="Login" />

</fieldset></form>