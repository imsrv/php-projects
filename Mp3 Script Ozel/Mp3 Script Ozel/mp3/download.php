<? include ("pages-setting.php") ?>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?=$pagetitle;?></title>
	<link href="style.css" rel="stylesheet" type="text/css">
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
	font-weight: bold;
}
.style20 {font-size: 11px}
.style29 {font-size: 8px}
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
                                          <param name="movie" value="flash/header.swf">
                                          <param name="quality" value="high">
                                          <embed src="flash/header.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="702" height="159"></embed>
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
                                                  <param name="movie" value="flash/banner.swf">
                                                  <param name="quality" value="high">
                                                  <embed src="flash/banner.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="439" height="207"></embed>
											    </object></td>
											  </tr>
											  <tr>
												<td height="523" valign="top">												 											 	  <div style="margin-left:25px; margin-top:18px ">														
												  <div align="left">
												    <p align="left"><em><span class="style3"> <img src="images/1_w1.gif" width="34" height="34"></span></em><span class="style7">Music</span></p>
												    <p align="center">								                      <span class="style29"><a href="list.php?abc=a">A</a> | <a href="list.php?abc=b">B</a> | <a href="list.php?abc=c">C</a> | <a href="list.php?abc=d">D</a> | <a href="list.php?abc=e">E</a> | <a href="list.php?abc=f">F</a> | <a href="list.php?abc=g">G</a> | <a href="list.php?abc=h">H</a> | <a href="list.php?abc=i">I</a> | <a href="list.php?abc=j">J</a> | <a href="list.php?abc=k">K</a> | <a href="list.php?abc=l">L</a> | <a href="list.php?abc=m">M</a> | <a href="list.php?abc=n">N</a> | <a href="list.php?abc=o">O</a> | <a href="list.php?abc=p">P</a> | <a href="list.php?abc=q">Q</a> | <a href="list.php?abc=r">R</a> | <a href="list.php?abc=s">S</a> | <a href="list.php?abc=t">T</a> | <a href="list.php?abc=u">U</a> | <a href="list.php?abc=v">V</a> | <a href="list.php?abc=w">W</a> | <a href="list.php?abc=x">X</a> | <a href="list.php?abc=y">Y</a> | <a href="list.php?abc=z">Z</a> </span> </p>
												  </div>
												  <table  border="0" cellspacing="0" cellpadding="0">
												    <!--DWLayoutTable-->
														  <tr>
															<td height="18" colspan="11" valign="top" ><?php 

												$id = $_GET['id'];
												include("config.php");
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
?></td>
														  </tr>
														  <tr>
														    <td width="10" height="162" ></td>
														  <td width="81" ></td>
														    <td colspan="8" valign="top" ><? echo "<img border='0' src="; if ($img=="") { echo 'images/nopic.gif'; } else { echo "$img"; }  echo" width='200' height='200'>";?>&nbsp;</td>
														    <td width="90" ></td>
														  </tr>
														  <tr>
														    <td height="15" ></td>
														    <td ></td>
														    <td width="83" ></td>
														    <td width="23" ></td>
														    <td width="25" ></td>
														    <td width="19" ></td>
														    <td width="4" ></td>
														    <td width="26" ></td>
														    <td width="25" ></td>
														    <td width="22" ></td>
														    <td ></td>
												    </tr>
														  <tr>
														    <td height="18" ></td>
														    <td colspan="2" valign="top" ><div align="left">Song's name </div></td>
														    <td colspan="3" valign="top" ><div align="center">Play</div></td>
														    <td ></td>
														    <td colspan="3" valign="top" ><div align="center">Download</div></td>
														    <td ></td>
												    </tr>
														  <tr>
														    <td height="20" ></td>
														    <td colspan="2" valign="top" >1 - <?=$text1?></td>
														    <td >&nbsp;</td>
														    <td valign="top" ><a href="listen.php?dl=<?=$link1?>"><img src="images/mediaplayerIcon1.gif" width="16" height="16" border="0"></a></td>
														    <td >&nbsp;</td>
														    <td >&nbsp;</td>
														    <td >&nbsp;</td>
														    <td valign="top" ><a href="<?=$link1?>"><img src="images/download.gif" width="20" height="20" border="0"></a></td>
														    <td >&nbsp;</td>
														    <td ></td>
												    </tr>
														  <tr>
														    <td height="20" ></td>
														    <td colspan="2" valign="top" >2 - <?=$text2?></td>
														    <td ></td>
														    <td valign="top" ><a href="listen.php?dl=<?=$link2?>"><img src="images/mediaplayerIcon1.gif" width="16" height="16" border="0"></a></td>
														    <td >&nbsp;</td>
														    <td >&nbsp;</td>
														    <td >&nbsp;</td>
														    <td valign="top" ><a href="<?=$link2?>"><img src="images/download.gif" width="20" height="20" border="0"></a></td>
														    <td ></td>
														    <td ></td>
												    </tr>
														  <tr>
														    <td height="20" ></td>
														    <td colspan="2" valign="top" >3 - <?=$text3?></td>
														    <td ></td>
														    <td valign="top" ><a href="listen.php?dl=<?=$link3?>"><img src="images/mediaplayerIcon1.gif" width="16" height="16" border="0"></a></td>
														    <td >&nbsp;</td>
														    <td >&nbsp;</td>
														    <td >&nbsp;</td>
														    <td valign="top" ><a href="<?=$link3?>"><img src="images/download.gif" width="20" height="20" border="0"></a></td>
														    <td ></td>
														    <td ></td>
												    </tr>
														  <tr>
														    <td height="20" ></td>
														    <td colspan="2" valign="top" >4 - <?=$text4?></td>
														    <td >&nbsp;</td>
														    <td valign="top" ><a href="listen.php?dl=<?=$link4?>"><img src="images/mediaplayerIcon1.gif" width="16" height="16" border="0"></a></td>
														    <td >&nbsp;</td>
														    <td >&nbsp;</td>
														    <td >&nbsp;</td>
														    <td valign="top" ><a href="<?=$link4?>"><img src="images/download.gif" width="20" height="20" border="0"></a></td>
														    <td ></td>
														    <td ></td>
												    </tr>
														  <tr>
														    <td height="20" ></td>
														    <td colspan="2" valign="top" >5 - <?=$text5?></td>
														    <td >&nbsp;</td>
														    <td valign="top" ><a href="listen.php?dl=<?=$link5?>"><img src="images/mediaplayerIcon1.gif" width="16" height="16" border="0"></a></td>
														    <td >&nbsp;</td>
														    <td >&nbsp;</td>
														    <td >&nbsp;</td>
														    <td valign="top" ><a href="<?=$link5?>"><img src="images/download.gif" width="20" height="20" border="0"></a></td>
														    <td ></td>
														    <td ></td>
												    </tr>
														  <tr>
														    <td height="20" ></td>
														    <td colspan="2" valign="top" >6 - <?=$text6?></td>
														    <td ></td>
														    <td valign="top" ><a href="listen.php?dl=<?=$link6?>"><img src="images/mediaplayerIcon1.gif" width="16" height="16" border="0"></a></td>
														    <td >&nbsp;</td>
														    <td >&nbsp;</td>
														    <td >&nbsp;</td>
														    <td valign="top" ><a href="<?=$link6?>"><img src="images/download.gif" width="20" height="20" border="0"></a></td>
														    <td ></td>
														    <td ></td>
												    </tr>
														  <tr>
														    <td height="20" ></td>
														    <td colspan="2" valign="top" >7 - <?=$text7?></td>
														    <td ></td>
														    <td valign="top" ><a href="listen.php?dl=<?=$link7?>"><img src="images/mediaplayerIcon1.gif" width="16" height="16" border="0"></a></td>
														    <td >&nbsp;</td>
														    <td >&nbsp;</td>
														    <td >&nbsp;</td>
														    <td valign="top" ><a href="<?=$link7?>"><img src="images/download.gif" width="20" height="20" border="0"></a></td>
														    <td ></td>
														    <td ></td>
												    </tr>
														  <tr>
														    <td height="20" ></td>
														    <td colspan="2" valign="top" >8 - <?=$text8?></td>
														    <td ></td>
														    <td valign="top" ><a href="listen.php?dl=<?=$link8?>"><img src="images/mediaplayerIcon1.gif" width="16" height="16" border="0"></a></td>
														    <td >&nbsp;</td>
														    <td >&nbsp;</td>
														    <td >&nbsp;</td>
														    <td valign="top" ><a href="<?=$link8?>"><img src="images/download.gif" width="20" height="20" border="0"></a></td>
														    <td >&nbsp;</td>
														    <td ></td>
												    </tr>
														  <tr>
														    <td height="20" ></td>
														    <td colspan="2" valign="top" >9 - <?=$text9?></td>
														    <td ></td>
														    <td valign="top" ><a href="listen.php?dl=<?=$link9?>"><img src="images/mediaplayerIcon1.gif" width="16" height="16" border="0"></a></td>
														    <td >&nbsp;</td>
														    <td >&nbsp;</td>
														    <td >&nbsp;</td>
														    <td valign="top" ><a href="<?=$link9?>"><img src="images/download.gif" width="20" height="20" border="0"></a></td>
														    <td ></td>
														    <td ></td>
												    </tr>
														  <tr>
														    <td height="20" ></td>
														    <td colspan="2" valign="top" >10 - <?=$text10?></td>
														    <td ></td>
														    <td valign="top" ><a href="listen.php?dl=<?=$link10?>"><img src="images/mediaplayerIcon1.gif" width="16" height="16" border="0"></a></td>
														    <td >&nbsp;</td>
														    <td >&nbsp;</td>
														    <td >&nbsp;</td>
														    <td valign="top" ><a href="<?=$link10?>"><img src="images/download.gif" width="20" height="20" border="0"></a></td>
														    <td ></td>
														    <td ></td>
												    </tr>
														  <tr>
														    <td height="25" ></td>
														    <td >&nbsp;</td>
														    <td >&nbsp;</td>
														    <td ></td>
														    <td ></td>
														    <td ></td>
														    <td ></td>
														    <td ></td>
														    <td ></td>
														    <td ></td>
														    <td ></td>
												    </tr>
												  </table>
												  <? }?>
														<p>														    <img src="images/hl.gif" alt=""><br>
												      </p>
														<p>&nbsp;</p>
												</div></td>
											  </tr>
											  <tr>
											    <td height="13" valign="top"><div style="margin-left:25px; margin-top:18px "><br style="line-height:14px ">
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
														<td valign="top" width="243" height="150"><a href="#"><img src="images/ban2.jpg" alt="" border="0"></a></td>
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
																							<form action="musicrequest.php" method="post" name="form1" target="_blank">
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
							  <a href="#" class="pol"><? include ("dn-menu.php"); ?>						</td>
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