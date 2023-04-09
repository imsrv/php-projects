<html>
<head>
<title>PMC Custom Comic Report</title>
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
			<font class="head2">CUSTOM COMIC REPORT</font><br />
		</td>
	</tr>
</table>

<br />

<table border="0" cellpadding="0" cellspacing="0" class="list" id="thetable">
	<tr>
		{cell1}{cell2}{cell3}{cell4}{cell5}
    </tr>
    
    <!-- START BLOCK : comic_report -->
    
    <tr>
    	{option1}{option2}{option3}{option4}{option5}
    </tr>
    
    <!-- END BLOCK : comic_report -->
</table>

<br /><center><font class="footer">Powered by: <b><a href="http://www.phpmycomic.net" class="defaultlink" target="_blank">PhpMyComic</a> {version}</b> &copy; 2004 Opencurve.net</font></center>

</body>
</html>