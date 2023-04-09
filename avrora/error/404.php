<?php

$text = "REQUEST_URI: ".getenv("REQUEST_URI")."\n";
$text.="HTTP_USER_AGENT: ".getenv("HTTP_USER_AGENT")."\n";
$text.="REMOTE_ADDR: ".getenv("REMOTE_ADDR")."\n";
$text.="HTTP_REFERER: ".getenv("HTTP_REFERER")."\n\n";


$fp=@fopen(getenv('DOCUMENT_ROOT')."/log/404-".date("Y-m-d").".log", "a");
if ($fp) {
	fwrite($fp, $text);
	fclose($fp);
}

header("HTTP/1.0 200 Ok");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">

<html>
<head>
<title>404: Not Found</title>
<meta http-equiv="REFRESH" content="5; url=http://<?php print getenv('SERVER_NAME'); ?>">
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#0000FF">
<pre>
<strong><?php print getenv("REQUEST_URI")?></strong>
�������� �� �������.

��������, �� ��������� ���� �������� �� ������ ������ �� ����������.
�������� �� ������� �� ���������� �����, ���� ��� �������� �������.
���������� ������ � ������ �������� �������, �������� �� ������� ��,
��� ��� ����������.

� ����� ������ ������� ��� ��������� �������������� � ��������� ������
� ��� �� ���� �� ���� �������������.

���� � ������� 5 ������ �� �� ������ �������������� �� �������
�������� �������, �� ���������� ������� ��� ������.
<a href="http://<?php print getenv('SERVER_NAME');?>">http://<?php print getenv('SERVER_NAME');?></a>

������� �� ��������.
</pre>
</body>
</html>

