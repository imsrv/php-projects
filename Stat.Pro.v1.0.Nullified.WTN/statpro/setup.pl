##############################################################################
##                                                                          ##
##  Program Name         : Stat Pro                                         ##
##  Release Version      : 1.0                                              ##
##  Home Page            : http://www.cidex.ru                              ##
##  Supplied by          : CyKuH [WTN]                                      ##
##  Distribution         : via WebForum, ForumRU and associated file dumps  ##
##                                                                          ##
##############################################################################
# Файл конфигурации
################################

$cgidir       = ".";                             # Путь к скриптам
$gmtzone  = 4;                               # Временная зона (GMT)
$statun     = "temp/counter.unq";   # Файл уникальной статистики
$statall     = "temp/counter.all";     # Файл всей статистики
$imgfile    = "../../img";                   # Файл графика
$grfile      = "temp/graph.png";       # Заготовка файла статистики
$contur    = 0;                                  # Контур

$LOCK_SH=1;
$LOCK_UN=8;

$statn = "../../img/statn.gif";
$statd = "../../img/statd.gif";
$statu = "../../img/statu.gif";

$start  = "04 января 2004 года";  # Начало статистики

$thtml = "temp";             # Путь к временным файлам

%calendar=('Jan','31','Feb','28','Mar','31','Apr','30','May','31','Jun','30','Jul','31','Aug','31','Sep','30','Oct','31','Nov','30','Dec','31');
%rumonth=('Jan','Январь','Feb','Февраль','Mar','Март','Apr','Апрель','May','Май','Jun','Июнь','Jul','Июль','Aug','Август','Sep','Сентябрь','Oct','Октябрь','Nov','Ноябрь','Dec','Декабрь');
%rusmonth=('Jan','Января','Feb','Февраля','Mar','Марта','Apr','Апреля','May','Мая','Jun','Июня','Jul','Июля','Aug','Августа','Sep','Сентября','Oct','Октября','Nov','Ноября','Dec','Декабря');
%cal=('Jan','1','Feb','2','Mar','3','Apr','4','May','5','Jun','6','Jul','7','Aug','8','Sep','9','Oct','10','Nov','11','Dec','12');
@cal=('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');


$header = qq~
<html>
<head>
<title>Статистика</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Cache-Control" content="no-cache"> 
<meta http-equiv="Pragma" content="no-cache">
</head>
<body bgcolor="#ffffff" text="#000000" link="#0000cc" vlink="#0000cc">~;

$footer = qq~
<hr width="100%" size=1>
<p><b>Хиты</b> - количество просмотров страниц с установленным счетчиком на которых побывали посетители вашего ресурса.<br>
<b>Хосты</b> - количество посетителей с уникальным IP-адресом. </p>
<hr width="100%" size=1>
<small><p align="center"><!--CyKuH [WTN]-->Stat Pro v1.0</small>
</body>
</html>~;

1;
