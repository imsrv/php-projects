<?

#	.................................................................................
#
#		������:	Manlix Site Grabber, ������: 1.0
#		�����:	Manlix (http://manlix.ru)
#	.................................................................................

function error($error,$file){exit('<font face="verdana" size="1" color="#de0000"><b>'.$error.'<br>['.htmlspecialchars($file).']</b></font>');}

if(!set_time_limit(0)) error("�������� ���� <font color=green>".__FILE__."</font> � ������� � �� <font color=green>".__LINE__."</font> �������",date("����: d.m.Y. �����: H:i:s",time()));

if(isset($_GET))
	while(list($key,$value)=each($_GET))
	$$key=$value;

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

function read_dir($dir)
{
	if($OpenDir=opendir($dir))
	{
		while(($file=readdir($OpenDir))!==false)
		{
			if($file!="."&&$file!="..")
			{
				if(is_dir($dir.chr(47).$file))
				{
					if(!is_readable($dir.chr(47).$file))
					error("��� ���� ��� ������ ������� �����",$dir.chr(47).$file);

					elseif(!is_writeable($dir.chr(47).$file))
					error("��� ���� ��� ������ � ������� �����",$dir.chr(47).$file);

					else
					read_dir($dir.chr(47).$file);
				}

				else
				{
					if(!is_readable($dir.chr(47).$file))
					error("��� ���� ��� ������ �����",$dir.chr(47).$file);

					elseif(!is_writeable($dir.chr(47).$file))
					error("��� ���� ��� ������ � ����",$dir.chr(47).$file);
				}
			}
		}
	}

	else error("��� ����",$dir);
}

function CheckConf($conf)
{
	while(list($section,$array)=each($conf))
		while(list($key,$value)=each($array))
			if(!strlen($value))
			error("� ����� ���������� �������, � ������ � ������ <font color=green>".$section."</font>, ���� ���� <font color=green>".$key."</font>",$conf['dir']['path']."/".$conf['dir']['inc']."/config.inc.dat");
}

if(!is_readable("./inc"))		error("��� ���� ��� ������ ������� �����","./inc");
elseif(!is_writeable("./inc"))		error("��� ���� ��� ������ � ������� �����","./inc");
else				read_dir("./inc");

$manlix=parse_ini_file("./inc/config.inc.dat",1);

CheckConf($manlix);

include("./inc/functions.inc.php");

if(isset($_SERVER['QUERY_STRING'])&&$_SERVER['QUERY_STRING']=="exit")
{
$_COOKIE=null;
setcookie($manlix['script']['prefix']."password",null);
}

$manlix['sections']=array(
		10	=>	"�������� ������������ ����",
		20	=>	"����� ������"
		);

function CheckPostRequest()
{
global $manlix;

	if(!count($_POST))				return 0;
	elseif(!isset($_POST['password']))		return 0;
	elseif(strlen($_POST['password'])==32)	return 0;
	else
	{
	setcookie($manlix['script']['prefix']."password",md5($_POST['password']));
	$_COOKIE[$manlix['script']['prefix']."password"]=md5($_POST['password']);
	return 1;
	}
}

function CheckAdminPassword($password)
{
global $manlix;

$PasswordFile=manlix_read_file("./inc/password.inc.dat");
	if(!isset($password))															return 0;
	elseif(!isset($PasswordFile[0]))														return 0;
	elseif(strlen($password)==32&&isset($_COOKIE[$manlix['script']['prefix']."password"])&&$_COOKIE[$manlix['script']['prefix']."password"]==$PasswordFile[0])	return 1;
	elseif($password==$PasswordFile[0])														return 1;
	else																	return 0;
}

if(CheckPostRequest())				$manlix['access']=CheckAdminPassword($_COOKIE[$manlix['script']['prefix']."password"]);
else						$manlix['access']=CheckAdminPassword((!isset($_COOKIE[$manlix['script']['prefix']."password"]))?null:$_COOKIE[$manlix['script']['prefix']."password"]);


if(empty($manlix['access']))
{
	if(isset($_POST['password']))	$manlix['status']="������ �� �������, ��������� ����";

$manlix['section']['name']="���� � ���������� ��������";
$manlix['result']='<br><table border="0" align="center" cellspacing="0" cellpadding="1">
<form method="post">
<tr><td align="right"><font face="verdana" size="1" color="maroon">������:</td>	<td><input type="password" name="password" size="30" class="name" onfocus="id=className" onblur="id=\'\'"" style="font: italic; width: 165px" value=""></td></tr>
<tr><td height="10"></td></tr>
<tr><td align="right" colspan="2">
				<table border="0" cellspacing="0" cellpadding="1" bgcolor="#000000">
				<tr><td><input type="submit" value="��������� ����" class="submit" style="width: 163px"></td></tr>
				</table>
</td></tr>
<tr><td height="20"></td></tr>
</form>
</table>';
}

else
{
$manlix['status']="���� ��������";
$manlix['result']=(!isset($manlix['result']))?null:$manlix['result'];

$manlix['section']['name']="�������� ������ ��� ��������";

$manlix['result'].="<table border=0 align=center>";
	while(list($a,$b)=each($manlix['sections']))
	$manlix['result'].="<tr><td><a href='?section=".(($a+1)*2*3*4*5*6*7*8*90)."'><font face=verdana size=1>".ucfirst($b)."</a></td></tr>";
$manlix['result'].="</table>";

$manlix['result'].="</td></tr><tr><tr><td bgcolor=maroon colspan=2></td></tr><tr><td colspan=2 bgcolor=#faedcf>";

	if(empty($section)) $manlix['result'].="<center><br><font face=verdana size=1 color=green>�������� �����</font></br><br></center>";
	elseif(!isset($manlix['sections'][($section-1)/2/3/4/5/6/7/8/90])) $manlix['result'].="<br><center><font face=verdana size=1 color=#de0000>�������� ���� ������ �� ����������</font></cebter><br><br>";
	else
	{
	$manlix['status'].=" <font color=blue>�</font> <font color=green>".$manlix['section']['name']=ucfirst($manlix['sections'][$case=floor(($section-1)/2/3/4/5/6/7/8/90)])."</font>";
	$manlix['result'].="<table border=0 width=98% align=center><tr><td><font face=verdana size=1>";

		switch($case)
		{
		case "10":
				if(empty($_POST['host']))
				$manlix['result'].=<<<HTML
<table border=0 width=100% cellspacing=0 cellpadding=0>
<form method=post>
<tr><td height=20><font face=verdana size=1 color=#de0000><i>1 ��� �� 5</b></td></tr>
<tr>
	<td align=right><font face=verdana size=1 color=maroon><i>������������ � ����� <font color=#de0000>http://&nbsp;<input type=text name=host size=50 class=name onfocus="id=className" onblur="id=''"" style="font: italic"></td>
</tr>
<tr><td height=20></td></tr>
<tr><td align=center><font face=verdana size=1><i>��������: manlix.ru</td></tr>
<tr><td height=20></td></tr>
<tr><td align=right>
	<table border=0 cellspacing=0 cellpadding=1 bgcolor=#000000>
	<tr><td><input type=submit value=&gt;&nbsp;&nbsp;&nbsp;������&nbsp;&nbsp;&nbsp;&gt; class=submit style="width: 100px"></td></tr>
	</table>
</td></tr>
<tr><td height=20></td></tr>
</form>
</table>
HTML;
				elseif(empty($_POST['port']))
				$manlix['result'].='
<table border=0 width=100% cellspacing=0 cellpadding=0>
<form method=post>
<input type=hidden name=host value="'.htmlspecialchars($_POST['host']).'">
<tr><td height=20><font face=verdana size=1 color=#de0000><i>2 ��� �� 5</b></td></tr>
<tr>
	<td align=right width=100%><font face=verdana size=1 color=maroon><i>������������&nbsp;�&nbsp;<font color=#de0000>http://'.htmlspecialchars($_POST['host']).'</font>, ����� ����:</td>
	<td><input type=text name=port size=3 class=name onfocus="id=className" onblur="id=\'\'"" style="font: italic" value=80></td>
</tr>
<tr><td height=20></td></tr>
<tr><td align=center><font face=verdana size=1><i>80 ���� - ��������, �� ������ ������ � 8080</td></tr>
<tr><td height=20></td></tr>
<tr><td colspan=2 align=right>
	<table border=0 cellspacing=0 cellpadding=1 bgcolor=#000000>
	<tr><td><input type=submit value=&gt;&nbsp;&nbsp;&nbsp;������&nbsp;&nbsp;&nbsp;&gt; class=submit style="width: 100px"></td></tr>
	</table>
</td></tr>
<tr><td height=20></td></tr>
</form>
</table>
';
				elseif(!isset($_POST['document']))
				$manlix['result'].='
<table border=0 width=100% cellspacing=0 cellpadding=0>
<form method=post>
<input type=hidden name=host value="'.htmlspecialchars($_POST['host']).'">
<input type=hidden name=port value="'.htmlspecialchars($_POST['port']).'">
<tr><td height=20><font face=verdana size=1 color=#de0000><i>3 ��� �� 5</b></td></tr>
<tr>
	<td align=right width=100%><font face=verdana size=1 color=maroon><i>������������&nbsp;�&nbsp;���������&nbsp;<font color=#de0000>http://'.htmlspecialchars($_POST['host']).':'.htmlspecialchars($_POST['port']).'/</td>
	<td><input type=text name=document size=30 class=name onfocus="id=className" onblur="id=\'\'"" style="font: italic"></td>
</tr>
<tr><td height=20></td></tr>
<tr><td align=center colspan=2><font face=verdana size=1><i>��������: index.php<br><br>���� �� �� ������� ��� ��������,<br>�� ��������� ����� ������������� �����������<br>� ���������� ����� ����� '.htmlspecialchars($_POST['host']).'</td></tr>
<tr><td height=20></td></tr>
<tr><td colspan=2 align=right>
	<table border=0 cellspacing=0 cellpadding=1 bgcolor=#000000>
	<tr><td><input type=submit value=&gt;&nbsp;&nbsp;&nbsp;������&nbsp;&nbsp;&nbsp;&gt; class=submit style="width: 100px"></td></tr>
	</table>
</td></tr>
<tr><td height=20></td></tr>
</form>
</table>
';
				elseif(empty($_POST['timeout']))
				$manlix['result'].='
<table border=0 width=100% cellspacing=0 cellpadding=0>
<form method=post>
<input type=hidden name=host value="'.htmlspecialchars($_POST['host']).'">
<input type=hidden name=port value="'.htmlspecialchars($_POST['port']).'">
<input type=hidden name=document value="'.htmlspecialchars($_POST['document']).'">
<tr><td height=20><font face=verdana size=1 color=#de0000><i>4 ��� �� 5</b></td></tr>
<tr><td align=center width=100%><font face=verdana size=1 color=maroon><i>������������&nbsp;�&nbsp;���������&nbsp;<font color=#de0000>http://'.htmlspecialchars($_POST['host']).':'.htmlspecialchars($_POST['port']).'/'.htmlspecialchars($_POST['document']).'</td></tr>
<tr><td height=20></td></tr>
<tr><td align=center><font face=verdana size=1>����������� ��� ����-���� <input type=text name=timeout size=3 class=name onfocus="id=className" onblur="id=\'\'"" style="font: italic" value=3>&nbsp;���.</td></tr>
<tr><td height=20></td></tr>
<tr><td colspan=2 align=right>
	<table border=0 cellspacing=0 cellpadding=1 bgcolor=#000000>
	<tr><td><input type=submit value=&gt;&nbsp;&nbsp;&nbsp;������&nbsp;&nbsp;&nbsp;&gt; class=submit style="width: 100px"></td></tr>
	</table>
</td></tr>
<tr><td height=20></td></tr>
</form>
</table>
';
				elseif(empty($_POST['request']))
				$manlix['result'].='
<table border=0 width=100% cellspacing=0 cellpadding=0>
<form method=post>
<input type=hidden name=host value="'.htmlspecialchars($_POST['host']).'">
<input type=hidden name=port value="'.htmlspecialchars($_POST['port']).'">
<input type=hidden name=document value="'.htmlspecialchars($_POST['document']).'">
<input type=hidden name=timeout value="'.htmlspecialchars($_POST['timeout']).'">
<tr><td height=20><font face=verdana size=1 color=#de0000><i>5 ��� �� 5</b></td></tr>
<tr><td align=center width=100%><font face=verdana size=1 color=maroon><i>�����������&nbsp;������������&nbsp;�&nbsp;<font color=#de0000>http://'.htmlspecialchars($_POST['host']).':'.htmlspecialchars($_POST['port']).'/'.htmlspecialchars($_POST['document']).'</td></tr>
<tr><td height=20></td></tr>
<tr><td align=center><font face=verdana size=1>���������� ��� ����-���� ������������, ����� <font color=maroon>'.$_POST['timeout'].'</font> ���.</td></tr>
<tr><td height=20></td></tr>
<tr><td><font face=verdana size=1>
	<font color=#de0000><b><i>������ �����������!!!</i></b></font>
	<ul type=square>
	<li>����� ���������: <font color=maroon>. \ \\ / | &lt; &gt; = + * ! ? [ ] { } ( ) ^ $</font> - ������� <font color=maroon>\</font><br>����� php ������������� ����� �������� ������.</li>
	<li>������ �������� �� ���������� ����������, ����� ������������ POSIX</li>
	<li>���� �� ������ ������� � POSIX, �� �� ���������� � ����� ������ <font color=maroon>\</font> � ���� ����� � �����, <font color=maroon>\</font> - ����������� ������������� � ����� ������ � ����� ������� � ������� <font color=maroon>/is</font></li>
	</ul>
	<font color=green><b><i>������:</i></b></font>
	<ul type=square>
	<li><font color=maroon>&lt;title>(.*)&lt;\/title></font> - ������ ������ � ���������� ��������� ��, ��� ���� ����� <font color=green>&lt;title></font> � <font color=green>&lt;/title></font></li>
	<li>� Windows � �������� <font color=maroon>�Ѩ</font> ����������� <font color=maroon>*</font>, � � ��� <font color=maroon>(.*)</font> (����� ������, �����, ��������, ������ ������) - �� ��������� ��� ���.</li>
	<li>���� ��� ����� ����� ������, �� ����������� �������, �������� �� ���� <a href="http://manlix.ru" target="_blank">manlix.ru</a></li>
	<li><font color=#de0000>��� �������� ���������� �������, ������� � ����� <a href="info.html" target="_blank">info.html</a></font></li>
	</ul>
	<font face=verdana size=1 color=maroon><b><i>���������� �������:</i></b></font><br>
	<input type=text name=request size=80 class=name onfocus="id=className" onblur="id=\'\'"" style="font: italic" value=&lt;html&gt;(.*)&lt;\/html&gt;>
</font></td></tr>
<tr><td height=20></td></tr>
<tr><td colspan=2>
	<table border=0 cellspacing=0 cellpadding=1 bgcolor=#000000 align=center>
	<tr><td><input type=submit value=������ class=submit style="width: 100px"></td></tr>
	</table>
</td></tr>
<tr><td height=20></td></tr>
</form>
</table>
';
				else
				{
					while(list($key,$value)=each($_POST))
						$_POST[$key]=manlix_stripslashes($value);

				$OpenRequestFile=fopen($manlix['file']['request'],'w');
				flock($OpenRequestFile,1);
				flock($OpenRequestFile,2);
				fwrite($OpenRequestFile,
							"GET /".$_POST['document']." HTTP/1.0".chr(13).chr(10).
							"User-Agent: Mozilla/4.0 (compatible; MSIE 5.0; Windows 98)".chr(13).chr(10).
							"Accept: */*".chr(13).chr(10).
							"Referer: http://".$_POST['host'].chr(13).chr(10).
							"Host: ".$_POST['host'].chr(13).chr(10).chr(13).chr(10)
							);
				fclose($OpenRequestFile);

				$OpenCaseFile=fopen($manlix['file']['case'],'w');
				flock($OpenCaseFile,1);
				flock($OpenCaseFile,2);
				fwrite($OpenCaseFile,$_POST['request']);
				fclose($OpenCaseFile);

				$OpenHostFile=fopen($manlix['file']['host'],'w');
				flock($OpenHostFile,1);
				flock($OpenHostFile,2);
				fwrite($OpenHostFile,$_POST['host'].chr(13).chr(10).$_POST['port'].chr(13).chr(10).$_POST['timeout']);
				fclose($OpenHostFile);

				$manlix['okay']=1;

				$manlix['result'].=<<<HTML
				<center><br><br><font face=verdana szie=1 color=green>������ ������ �������</font><br><br></center>
HTML;
				}
		break;
		case "20":
				if(empty($_POST))
				$manlix['result'].=<<<HTML
<br><i><font face=verdana color=#de0000>������ �����������!</font><br><i><ul type=square><li>����� ��������� ������ ������ ����������� ������ �� �����.</li><li>��� ���� ����� �� ������ ����� ������, �������� ��� ���-������.</li><li>� ������ ����� �������: �������, ��������� ����� � �����.</li><li>����������� �������.</li></ul></i>
<br>
<form method=post>
<center>����� ������: <input type=password name=NewPassword size=52 class=name onfocus="id=className" onblur="id=''"" style="font: italic; width: 346px"></center>
<br><br>
	<center>
	<table border=0 cellspacing=0 cellpadding=1 bgcolor=#000000>
	<tr><td><input type=submit value=��������� class=submit style="width: 70px"></td></tr>
	</table>
	</center>
</form>
HTML;

				else
				{
					if(empty($_POST['NewPassword']))			$manlix['result'].="<br><center><font color=#de0000>�� �� ����� ����� ������.</font><br><br>...<a href='?section=148780800'>��������� �� ��� �����</a><br><br></center>";
					elseif(!eregi("^[a-z�-��0-9]+$",$_POST['NewPassword']))	$manlix['result'].="<br><center><font color=#de0000>������ ������ ��������, ������ �� �������, ��������� ���� � ����.</font><br><br>...<a href='?section=148780800'>��������� �� ��� �����</a><br><br></center>";
					else
					{
					$manlix['okay']=1;

						$OpenPasswordFile=fopen("./inc/password.inc.dat","w");
						flock($OpenPasswordFile,1);
						flock($OpenPasswordFile,2);
						fwrite($OpenPasswordFile,md5($_POST['NewPassword']));
						fclose($OpenPasswordFile);

						setcookie($manlix['script']['prefix']."password",md5($_POST['NewPassword']));

					$manlix['result'].="<br><center><font color=green>����� ������ ������� ����� � ����.</font><br><br></center>";
					}
				}
		break;
		}

	$manlix['result'].="</font></td></tr></table>";
	}
}

if(empty($manlix['status']))			$manlix['status']="���� �� ��������";
?>
<html>
<head>
<title><?=$manlix['script']['name'],", ������: ",$manlix['script']['version']?> � ���������� � <?=ereg_replace("<[^>]+>", "",ucfirst($manlix['status']))?></title>
<meta http-equiv="content-type" content="text/html; charset=windows-1251">
<meta http-equiv="pragma" content="no-cache">
<? if(isset($manlix['okay'])) echo '<meta http-equiv="refresh" content="3; url=?'.manlix_char_generator("qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890",32).'">'; ?>
<style type="text/css">
<!--
a:link	{color: #000000; text-decoration: none;}
a:active	{color: #000000; text-decoration: none;}
a:visited	{color: #000000; text-decoration: none;}
a:hover	{color: #de0000; text-decoration: none;}

.name	{border: 1px; border-style: solid; height: 16px; border-color: #000000; background-color: #ffe6b7; font-family: verdana; font-size: 10px; color: #de0000;}
#name	{border: 1px; border-style: solid; height: 16px; border-color: #000000; background-color: #fef1d8; font-family: verdana; font-size: 10px; color: #de0000;}
.submit	{border: 0px; height: 14px; background-color: #ffe6b7; font-family: verdana; font-size: 10px; color: #000000;}
-->
</style>
</script>
</head>
<body bgcolor=#ffffff background="images/background.gif" style="cursor: default" topmargin=3>
<table border=0 align=center cellspacing=0 cellpadding=1>
<tr><td align=right><font face=verdana size=1 style="background-color: #ffffff" color=#de0000><?=$manlix['status']?></font></td></tr>
<tr><td>
	<table width=500 align=center cellspacing=1 cellpadding=1 bgcolor=#faad1e>
	<tr align=center bgcolor=#faedca height=44><td><font face=verdana size=6 color=#FAD27D><b><?=$manlix['script']['name']?></i></b></font></td></tr>
	<tr><td align=cetner bgcolor=#faedc0>
					<table border=0 align=center cellspacing=0 cellpadding=1 width=470>
					<tr><td height=10></td></tr>
					<tr><td bgcolor=maroon colspan=2></td></tr>
					<tr><td align=center bgcolor=#faedca colspan=2><font face=verdana color=maroon size=1><?=(isset($manlix['section']['name']))?$manlix['section']['name']:''?></font></td></tr>
					<tr><td bgcolor=maroon colspan=2></td></tr>
					<tr><td height=10></td></tr>
					<tr><td bgcolor=maroon colspan=2></td></tr>
					<tr><td colspan=2 bgcolor=#faedca><?=(isset($manlix['result']))?$manlix['result']:''?></td></tr>
					<tr><td bgcolor=maroon colspan=2></td></tr>
					<tr><td height=10></td></tr>
					</table>
	</td></tr>
	<tr align=center bgcolor=#faedca><td align=center><font face=verdana size=1><a href="http://manlix.ru" target="_blank">���������� �������: Manlix</a></font></td></tr>
	</table>
</td></tr>
<?
if(!empty($manlix['access']))
{
echo "<tr><td align=right><font face=verdana size=1>(<a href='?exit'>������� ������</a>)</font></td></tr>";
}
?>
</table>
</body>
</html>