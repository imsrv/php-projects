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
Страница не найдена.

Извините, но указанная вами страница на данные момент не существует.
Возможно вы указали не правильный адрес, либо эта страница удалена.
Попробуйте начать с первой страницы сервера, возможно вы найдете то,
что вам необходимо.

В любом случае система уже известила администратора о возникшей ошибке
и вам не надо ни чего предпринимать.

Если в течении 5 секунд вы не будете перенаправлены на главную
страницу сервера, то пожалуйста нажмите эту ссылку.
<a href="http://<?php print getenv('SERVER_NAME');?>">http://<?php print getenv('SERVER_NAME');?></a>

Спасибо за внимание.
</pre>
</body>
</html>

