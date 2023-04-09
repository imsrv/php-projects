<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template review_printer -->

<head>
<title>$insert[review_title]</title>
<meta name="GENERATOR" content="CMS" />
<meta http-equiv="Content-Type" content="text/html;charset=windows-1251" />
</head>
<body>
<table width="640" border="1" cellSpacing="0" cellPadding="20" bgColor="#ffffff" bordercolorlight="#000000" bordercolor="#000000" bordercolordark="#000000">
        <tr>
        <td>
                <font face="Arial" size="4">
                        <b>$insert[review_title]</b>
                </font>
                <br /><br />
                <font face="Arial" size="2">
                        $insert[review_text]
                </font>
                <br /><br />
                <hr>
                <center>
                <font face="Arial" size="2">
                        Printed from $insert[review_sitename] ($insert[review_siteurl]/review.php?id=$insert[review_id]&page=$insert[review_page])
                </font>
                </center>
        </td>
        </tr>
</table>
</body>
</html>

TEMPLATE;
?>
