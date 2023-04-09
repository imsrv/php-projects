<HTML>
<HEAD>

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title><? echo "$gallery_title"; ?></title>
	<META name="description" content="<? echo "$gallery_description"; ?>">
	<META name="keywords" content="<? echo "$gallery_keywords"; ?>">
	<META name="revisit-after" content="7days">
	<META name="robots" content="index, follow">

<style type="text/css">

	body,td		{ font-family: verdana, arial, helvetica; color: #<? echo "$gallery_text"; ?>; font-size: 12px; }

	A:link		{ text-decoration: none; color: #<? echo "$gallery_link"; ?>; }
	A:visited	{ text-decoration: none; color: #<? echo "$gallery_vlink"; ?>; }
	A:hover		{ text-decoration: underline; }

	.small		{ font-size: 10px; }
	.emph		{ font-weight: bold; }

</style>

</HEAD>
<BODY BGCOLOR=#<? echo "$gallery_bgcolor"; ?> LEFTMARGIN=5 TOPMARGIN=5 RIGHTMARGIN=5 MARGINWIDTH=5 MARGINHEIGHT=5>


<TABLE width="600" BORDER=0 CELLPADDING=3 CELLSPACING=0>
	<TR>
		<TD valign=top>

	<?

    $ress = mysql_query("SELECT username FROM freephp_gallery_admin WHERE username='$username' AND password='$password'");

    if(mysql_num_rows($ress) != 0) {

    	echo "

    	<TABLE WIDTH=219 BORDER=0 CELLPADDING=0 CELLSPACING=0>
    	<TR><TD><B>Admin Options</B></TD></TR>
    	<TR><TD><A HREF='category.php'>add category</A></TD></TR>
    	<TR><TD><A HREF='category-disp.php'>modify category</A></TD></TR>
    	<TR><TD><A HREF='additem.php'>add photo</A></TD></TR>
    	<TR><TD><A HREF='logout.php'>logout</A></TD></TR>
    	</TABLE>

    	";

	} else {

	    echo "";

	}

	echo "
    	<TABLE WIDTH=219 BORDER=0 CELLPADDING=0 CELLSPACING=0>
    	<TR><TD><B>Categories</B></TD></TR>
	";

	print_cat();

	echo "</TABLE>";

	?>


		</TD>

		<TD valign=top>