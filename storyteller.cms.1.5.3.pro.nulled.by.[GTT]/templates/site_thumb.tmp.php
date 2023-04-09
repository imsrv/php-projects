<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template site_thumb -->

<html>

<head>
<title>Image - $insert[thumb]</title>

<meta name="GENERATOR" content="CMS" />
<meta http-equiv="Content-Type" content="text/html;charset=windows-1251" />

<style type="text/css">
.textbox {
        SCROLLBAR-FACE-COLOR: #cccccc; FONT-SIZE: x-small; BACKGROUND: white; SCROLLBAR-HIGHLIGHT-COLOR: #ffffff; SCROLLBAR-SHADOW-COLOR: #ffffff; COLOR: #000000; SCROLLBAR-3DLIGHT-COLOR: #ffffff; SCROLLBAR-ARROW-COLOR: #000000; SCROLLBAR-TRACK-COLOR: #ffffff; FONT-FAMILY: Verdana,Arial,Helvetica; SCROLLBAR-DARKSHADOW-COLOR: #ffffff; TEXT-ALIGN: left
}
TD {
        FONT-SIZE: 10pt; FONT-FAMILY: Verdana,Arial,Helvetica
}
BODY {
        FONT-SIZE: 10pt; FONT-FAMILY: Verdana,Arial,Helvetica
}
</style>

</head>

<body text="#000000" vlink="#004364" alink="#004364" link="#004364" bgcolor="#66ff99" leftmargin="0" topmargin="5" rightmargin="0">

<center>

<img src="$insert[thumb]">
<br /><br />

<font face="Arial" size="2">
[ <a href="javascript:self.close()">Close Window</a> ]
</font>

</center>

</body>

</html>

TEMPLATE;
?>
