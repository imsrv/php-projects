<?php
global $insert;
$EST_TEMPLATE = <<<TEMPLATE

<!-- Template story_printer -->

<head>
<title>$insert[story_title]</title>
<meta name="GENERATOR" content="CMS" />
<meta http-equiv="Content-Type" content="text/html;charset=windows-1251" />
</head>
<body>
<table width="640" border="1" cellSpacing="0" cellPadding="20" bgColor="#ffffff" bordercolorlight="#000000" bordercolor="#000000" bordercolordark="#000000">
        <tr>
        <td>
                <font face="Arial" size="4">
                        <b>$insert[story_title]</b>
                </font>
                <br />
                <font face="Arial" size="1">
                        Posted on: $insert[story_time]
                </font>
                <br /><br />
                <font face="Arial" size="2">
                        $insert[story_text]<br /><br />
                        $insert[story_extendedtext]
                </font>
                <br /><br />
                <hr>
                <center>
                <font face="Arial" size="2">
                        Printed from $insert[story_sitename] ($insert[story_siteurl]/story.php?id=$insert[story_id])
                </font>
                </center>
        </td>
        </tr>
</table>
</body>
</html>

TEMPLATE;
?>
