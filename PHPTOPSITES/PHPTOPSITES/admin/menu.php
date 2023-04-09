<? 
include "../config.php"; 

$fp = @fopen("http://itop10.net/free.txt","r");
$l_free = @fgets($fp,1024);
@fclose($fp);

$fp = @fopen("http://itop10.net/pro.txt","r");
$l_pro = @fgets($fp,1024);
@fclose($fp);
?>

<html>
	<head>
		<title></title>
		<base target="main">
	</head>
	<body topmargin="10" leftmargin="0" marginheight="10" marginwidth="0" bgcolor="#FFFFFF" link="#0000FF" vlink="#0000FF" alink="#0000FF">
		<table border="0" width="100%" cellpadding="5" cellspacing="0">
			<tr>
				<td>
					<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><A HREF="install.php">Install Tables</A><BR></font>
					<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><A HREF="check.php">Check Vars</A><BR></font>
				</td>
			</tr>
			<tr>
				<td>
					<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Categories:<BR></font>
					<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><A HREF="ceditor.php">Add/Edit Category</A><BR></font>
				</td>
			</tr>
			<tr>
				<td>
					<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Sites:<BR></font>
					<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><A HREF="validate.php">Validate Sites</A><BR></font>
					<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><A HREF="seditor.php">Edit Sites</A><BR></font>
					<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><A HREF="oldsites.php">Inactive Sites</A></font><BR><font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="1"> (no incoming hits)</font><BR>
				</td>
			</tr>
			<tr>
				<td>
					<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Version:<BR></font>
					<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size-1;?>"><? echo $ver?><BR></font>
					<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size-1;?>"><A HREF="http://itop10.net/products/" target="_blank">Latest Free</A>: <? echo $l_free;?></font><BR>
					<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size-1;?>"><A HREF="http://itop10.net/products/" target="_blank">Latest PRO</A>: <? echo $l_pro;?></font><BR>
				</td>
			</tr>
		</table>
	</body>
</html>
