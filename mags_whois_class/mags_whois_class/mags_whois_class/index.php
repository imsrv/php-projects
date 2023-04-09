<html>
<head>
	<title>
		[M]ag's [W]hois [C]lass
	</title>
	
	<script language="javascript">
	<!--
		function openW(url)
		{
			var x = window.open(url, "PopUp", "width=600, height=400, location=no, scrollbars=yes, toolbar=no");	
			return false;
		}
	-->
	</script>
</head>

<body bgcolor="white">

<div id="loader" style="position:absolute; top:30%; left:30%; visibility:hidden; border-style:solid; border-width:1px; border-color:black; width:300px; height:50px;">
	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td valign="middle" align="center">
				<span style="font-family:verdana; font-size:8pt; color:red;">
					<b>Please Wait While We Search For Your Domain...</b>
				</span>
			</td>
		</tr>
	</table>
</div>


<div align="center">
	<?php
		include("class/class.whois.php");
		
		$build = new Build();
		
		if( isset($HTTP_POST_VARS["domain"]) AND isset($HTTP_POST_VARS["extensions"]) AND $HTTP_POST_VARS["domain"] != "" )
		{
			echo <<<END
			<script language="javascript">
				document.title = "Finding Your Domain Information...";
				if( document.all )
				{
					document.all["loader"].style.visibility = "visible";
				}
				
				if( document.layers )
				{
					document.layers["loader"].visibility = "show";	
				}
			</script>
END;
		$whois = new Whois($HTTP_POST_VARS["domain"], $HTTP_POST_VARS["extensions"]);
		
		echo <<<END
		<script language="javascript">
				document.title = "[M]ag's [W]hois [C]lass";
				if( document.all )
				{
					document.all["loader"].style.visibility = "hidden";
				}
				
				if( document.layers )
				{
					document.layers["loader"].visibility = "hide";	
				}	
		</script>
END;
		
	?>
</div>

<div id="afterload" style="text-align:center; position:absolute; top:30%; left:30%; visibility:hidden; border-style:solid; border-width:1px; border-color:black; width:300px; height:50px;">
	<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td valign="middle" align="center">
				<b>
					<span style="font-family:verdana; font-size:8pt; color:red;">
						<?php
							$whois->PrintResults();
						?>
					</span>
				</b>
			</td>
		</tr>
	</table>
</div>

<script language="javascript">	
if( document.all )
{
	document.all["afterload"].style.visibility = "visible";
}

if( document.layers )
{
	document.layers["afterload"].visibility = "show";	
}
</script>

<?php
} // ends if statment
?>

</body>
</html>