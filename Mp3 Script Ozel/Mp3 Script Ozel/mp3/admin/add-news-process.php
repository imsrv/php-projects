<? include ("../pages-setting.php") ?>
<?php

if (isset($_COOKIE['admincenter'])) {

   if ($_COOKIE['admincenter'] == md5($password.$randomword)) {

?>
<html>
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
										<td width="702" height="160" valign="top"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="702" height="159">
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
												<td width="439" height="207" valign="top"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="439" height="207">
                                                  <param name="movie" value="../flash/banner.swf">
                                                  <param name="quality" value="high">
                                                  <embed src="../flash/banner.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="439" height="207"></embed>
											    </object></td>
											  </tr>
											  <tr>
												<td height="529" valign="top">												 											 	  <div style="margin-left:25px; margin-top:18px ">														
												  <p><em><span class="style3"> </span></em>ADMIN:</p>
												  <p align="center"><a href="add-album.php">ADD NEW ALBUM</a> | <a href="add-video.php">ADD NEW VIDEO</a> | <a href="edit-album.php">EDIT ADDED ALBUM</a> | <a href="edit-video.php">EDIT ADDED VIDEO</a> | <a href="delete-album.php">DELETE ALBUM</a> | <a href="delete-video.php">DELETE VIDEO</a> | <a href="add-news.php">ADD NEWS</a> </p>
												  <table  border="0" cellspacing="0" cellpadding="0">
												    <!--DWLayoutTable-->
														  <tr>
															<td width="400" height="107" valign="top" ><?
$headline = $_POST['headline'];
$news = $_POST['news'];
include ("../config.php"); 
mysql_connect($db_host,$db_user,$db_pass) or die(mysql_error()); 
mysql_select_db($db_name) or die(mysql_error());
											
mysql_query("INSERT INTO news (headline,news) VALUES ('$headline','$news')");
echo "<font face='Tahoma' color='#9C9C9C' style='font-size: 8pt'><span lang='fa'>News Added Successfully</span></font>";
?></td>
														  </tr>
												  </table>
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
							  <a href="#" class="pol"><? include ("../dn-menu.php"); ?>						</td>
						  </tr>
						</table>
					</td>
				  </tr>
				</table>
			</td>
		  </tr>
</table>
</body>
</html>
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









