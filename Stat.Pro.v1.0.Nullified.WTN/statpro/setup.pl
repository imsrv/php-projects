##############################################################################
##                                                                          ##
##  Program Name         : Stat Pro                                         ##
##  Release Version      : 1.0                                              ##
##  Home Page            : http://www.cidex.ru                              ##
##  Supplied by          : CyKuH [WTN]                                      ##
##  Distribution         : via WebForum, ForumRU and associated file dumps  ##
##                                                                          ##
##############################################################################
# ���� ������������
################################

$cgidir       = ".";                             # ���� � ��������
$gmtzone  = 4;                               # ��������� ���� (GMT)
$statun     = "temp/counter.unq";   # ���� ���������� ����������
$statall     = "temp/counter.all";     # ���� ���� ����������
$imgfile    = "../../img";                   # ���� �������
$grfile      = "temp/graph.png";       # ��������� ����� ����������
$contur    = 0;                                  # ������

$LOCK_SH=1;
$LOCK_UN=8;

$statn = "../../img/statn.gif";
$statd = "../../img/statd.gif";
$statu = "../../img/statu.gif";

$start  = "04 ������ 2004 ����";  # ������ ����������

$thtml = "temp";             # ���� � ��������� ������

%calendar=('Jan','31','Feb','28','Mar','31','Apr','30','May','31','Jun','30','Jul','31','Aug','31','Sep','30','Oct','31','Nov','30','Dec','31');
%rumonth=('Jan','������','Feb','�������','Mar','����','Apr','������','May','���','Jun','����','Jul','����','Aug','������','Sep','��������','Oct','�������','Nov','������','Dec','�������');
%rusmonth=('Jan','������','Feb','�������','Mar','�����','Apr','������','May','���','Jun','����','Jul','����','Aug','�������','Sep','��������','Oct','�������','Nov','������','Dec','�������');
%cal=('Jan','1','Feb','2','Mar','3','Apr','4','May','5','Jun','6','Jul','7','Aug','8','Sep','9','Oct','10','Nov','11','Dec','12');
@cal=('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');


$header = qq~
<html>
<head>
<title>����������</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Cache-Control" content="no-cache"> 
<meta http-equiv="Pragma" content="no-cache">
</head>
<body bgcolor="#ffffff" text="#000000" link="#0000cc" vlink="#0000cc">~;

$footer = qq~
<hr width="100%" size=1>
<p><b>����</b> - ���������� ���������� ������� � ������������� ��������� �� ������� �������� ���������� ������ �������.<br>
<b>�����</b> - ���������� ����������� � ���������� IP-�������. </p>
<hr width="100%" size=1>
<small><p align="center"><!--CyKuH [WTN]-->Stat Pro v1.0</small>
</body>
</html>~;

1;
