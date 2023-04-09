<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->CHARSET; ?>">
<title><?php echo $this->ERROR; ?></title>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body topmargin="0" leftmargin="0">
<p align="center">&nbsp;</p>
<div align="left">
<table border="0" width="449" style="border-style:solid; border-color:#F6F6F6; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" class="tdcolor" width="64">
        <p align="right"><br><br></td>
        <td align="center" class="tdcolor" width="279"><b><?php echo $this->ERROR; ?></b><br><br>
        <span class="error">

        <?php echo $this->ERRORSTRING; ?>

        </span>
        <br><br>
         <a href="javascript:history.go(-1)"><?php echo $this->RETURN; ?></a> <br></td>
        <td align="center" class="tdcolor" width="106">
        <span class="error">

        <img border="0" src="hata.gif" align="right" width="100" height="100"></span></td>
    </tr>
</table>
</div>
</body>
</html>