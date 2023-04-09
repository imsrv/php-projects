<html>
<head>
<title>PMC Issue Checklist</title>
<base href="{pmcurl}">
<link rel=stylesheet href="themes/{theme}/report.css" type=text/css>

<script type="text/javascript">
function alternate(id){
 if(document.getElementsByTagName){  
   var table = document.getElementById(id);  
   var rows = table.getElementsByTagName("tr");  
   for(i = 0; i < rows.length; i++){          
 //manipulate rows
     if(i % 2 == 0){
       rows[i].className = "even";
     }else{
       rows[i].className = "odd";
     }      
   }
 }
}
</script>

</head>

<body topmargin="0" bottommargin="0" rightmargin="0" leftmargin="0" marginwidth="0" marginheight="0" scroll="yes" onload="alternate('thetable')">

<table border="0" cellpadding="0" cellspacing="0" class="main">
	<tr>
		<td class="title" align="center">
			<img src="{imgfolder}/icon.jpg"><br />
			<font class="head1">PHPMYCOMIC</font><br />
			<font class="head2">ISSUE CHECKLIST</font><br />
		</td>
	</tr>
</table>

<br />

<table border="0" cellpadding="0" cellspacing="0" class="list" id="thetable">
	<tr>
		<td class="header" width="50%">Series Name</td>
		<td class="header" width="45%">Issue</td>
		<td class="header" width="5%">Check</td>
	</tr>

	<!-- START BLOCK : check_list -->
	
	<tr>
		<td class="cell" width="50%">{check_name} Volume: {volume}</td>
		<td class="cell" width="45%">Issue: #{check_num}</td>
		<td class="cell" width="5%" align="center"><img src="{imgfolder}/{check_image}"></td>	
    </tr>

	<!-- END BLOCK : check_list -->

</table>

<br /><center><font class="footer">Powered by: <b><a href="http://www.phpmycomic.net" class="defaultlink" target="_blank">PhpMyComic</a> {version}</b> &copy; 2004 Opencurve.net</font></center>
<br />
</body>
</html>