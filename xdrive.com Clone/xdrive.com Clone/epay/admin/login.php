<HEAD>
	<TITLE><?=$sitename?> Administration</TITLE>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
	<!--
		a:hover {  font-weight: bold; text-decoration: none; text-transform: capitalize}
		a:link {  font-weight: bold; text-decoration: none; text-transform: capitalize}
		a:visited {  font-weight: bold; text-decoration: none; text-transform: capitalize}
		a:active {  font-weight: bold; text-decoration: none; text-transform: capitalize}
		.menu {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px; font-weight: bold; color: #FFFFFF; background-color: #000099; text-decoration: none}
		.label {  font-family: Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; text-decoration: none}
		.fields {  font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; color: #000099; text-decoration: none; background-color: #F3F3F3; border-color: #666666 #333333 #333333 #999999; font-style: normal; padding-top: 0px; padding-right: 2px; padding-bottom: 0px; padding-left: 2px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px}
		.fields_text {  font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: normal; color: #000000; background-color: #E5E5E5; border-color: #000099 #000099 #000099 #000033 border-top-width: thin; border-right-width: thin}
		.fields_text2 {  font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: normal; color: #000000; background-color: #DBDBDB; border-color: #000099 #000099 #000099 #000033 border-top-width: thin; border-right-width: thin}
		.fields_back {  background-color: #000099; font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; color: #FFFFFF}
		.main {  font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000099; background-color: #F9F9F9}
	-->
	</style>
</head>
<body rightmargin="0" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#EFEFEF" >
<tr>
	<td width="80%">
		<table width="95%" border="0" cellspacing="0" cellpadding="2" class="label">
		<tr>
			<td>
				<FONT FACE=VERDANA  size=5 color="#006699"><B>e<FONT color="#FFBB00">Pay</font> Admin</B>
			</td>
		</tr>
		</table>
	</td>
	<td width="20%" valign="middle" align=right style="padding-right:10px">
		&nbsp;
	</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fields_text">
<tr> 
	<td bgcolor="#CCCCCC"> 
		<table width="100%" border="0" cellspacing="0" cellpadding="0" height="21" class="fields_back" background="images/menu_back.gif">
		<tr> 
			<td>&nbsp; </td>
		</tr>
		</table>
	</td>
</tr>
<tr> 
	<td bgcolor="#CCCCCC"> 
		<table width="100%" border="0" cellspacing="10" cellpadding="10" align="center">
		<tr> 
			<td> 
				<div align="center"> 
				<FORM method=post action=index.php>
				<table width="250" border="0" cellspacing="0" cellpadding="1" class="fields_back">
				<tr> 
					<td> 
						<table border="0" cellpadding="3" align="center" cellspacing="0" class="fields_text" width="100%">
						<tr> 
							<td width="39%"> 
								<div align="right"><b>LOGIN:</b></div>
							</td>
							<td width="61%"> 
								<input type="text" name="username" value="" class="fields" size="12">
							</td>
						</tr>
						<tr> 
							<td width="39%"> 
								<div align="right"><b>PASSWORD:</b></div>
							</td>
							<td width="61%"> 
								<input type="password" name="password" value="" class="fields" size="12">
							</td>
						</tr>
						<tr> 
							<td width="39%">&nbsp;</td>
							<td width="61%"> 
								<input type="submit" name="Submit" value="Login" class="fields">
							</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
				<br>
				</div>
				</form>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
</body>
</html>