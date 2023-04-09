<script type="text/javascript"><!--
var selectedbanner = '';
function opnew(myid, type, btype) {
    myop = open('','test','toolbar=no,menubar=no,scrollbars=yes,width=450,height=300');
	myop.document.open();
	myop.document.writeln('<html><head><title>Edit Banner HTML Code</title><link rel="stylesheet" href="css.css"></head><body>');
	myop.document.writeln('<script language="JavaScript">');
	myop.document.writeln('<!--');
	myop.document.writeln('function gotoandsave(iddd, btype) {');
	myop.document.writeln('    if (document.all) {');
	myop.document.writeln('         opener.document.all[iddd].innerHTML=document.myform.content.value;');
	myop.document.writeln('    }');
	myop.document.writeln('    else if (document.getElementById) {');
	myop.document.writeln('         opener.document.getElementById(iddd).innerHTML=document.myform.content.value;');
	myop.document.writeln('    }');
	myop.document.writeln('    else if (document.layers) {');
	myop.document.writeln('         opener.document.layers[iddd].document.open();');
	myop.document.writeln('         opener.document.layers[iddd].document.writeln(document.myform.content.value);');
	myop.document.writeln('         opener.document.layers[iddd].document.close();');
	myop.document.writeln('    }');
    myop.document.writeln('    if (btype == "top_banner") {');
	myop.document.writeln('         var filetosavefooter = eval(\'opener.document.form1.top_banner\'+opener.radiobut(opener.document.form1.topb));');
	myop.document.writeln('    }');
    myop.document.writeln('    else if (btype == "right_banner") {');
	myop.document.writeln('         var filetosavefooter = eval(\'opener.document.formr.right_banner\'+opener.radiobut(opener.document.formr.rightb));');
	myop.document.writeln('    }');
    myop.document.writeln('    else if (btype == "bottom_banner") {');
	myop.document.writeln('         var filetosavefooter = eval(\'opener.document.formb.bottom_banner\'+opener.radiobut(opener.document.formb.bottomb));');
	myop.document.writeln('    }');
	myop.document.writeln('    filetosavefooter.value=document.myform.content.value;');
	myop.document.writeln('    opener.adjusttopsel();');
	myop.document.writeln('    window.close();');
	myop.document.writeln('}	');
	myop.document.writeln('function newopen(url, width, height) {');
	myop.document.writeln('      op = open(url,\'\',\'toolbar=n,menubar=no,scrollbars=yes,width=\'+width+\',height=\'+height);');
	myop.document.writeln('}	');
	myop.document.writeln('function addImgCode(code) {');
	myop.document.writeln('      document.myform.content.value = document.myform.content.value + \'<img src="\'+code+\'">\';');
	myop.document.writeln('}	');
	myop.document.writeln('//--></script\>');
	if (type == '1') {
		myop.document.write('<table><tr><td><form name="myform"><textarea name="content" rows="12" cols="30">');
		if (document.all) {
			myop.document.write(document.all[myid].innerHTML);		    
		}
        else if (document.getElementById) {     
			myop.document.write(document.getElementById(myid).innerHTML);	    
        }
		else if (document.layers) {
			
			document.layers['topbanner'].document.open();	    
			document.layers['topbanner'].document.writeln(inputname.value);	    
			document.layers['topbanner'].document.close();	    
        }
		myop.document.write('</textarea><br><br>');
	}
	else {
		myop.document.write('<form name="myform"><textarea name="content" rows="12" cols="40"></textarea><br><br>');
	}
	myop.document.write('<center><input type="button" name="go" value="Update Banner Code" class="button" onClick="gotoandsave(\''+myid+'\', \''+btype+'\');"></center>');
	myop.document.write('</form></td><td><form action="banner_add_banner.php"><input type="button" name="admin_upload_banner" value="Upload Banner Image" class="button" style="width: 150px;" onClick="newopen(\'<?=HTTP_SERVER_ADMIN?>admin_upload.php\',350,150);"><br><br><input type="button" name="select" value="Select Banner Image" class="button" style="width: 150px;" onClick="newopen(\'<?=HTTP_SERVER_ADMIN?>admin_select_image.php\',350,350);"></form></td></tr></table>');
	myop.document.write('</body></html>');
	myop.document.close();

} // end func
function showbannermenu(selected) {
	selectedbanner = selected;
	hideall();
	if (document.all) {
		document.all[selected].style.visibility = 'visible';	    
	}
    else if (document.getElementById) {     
		document.getElementById(selected).style.visibility = 'visible';	    
    }
	else if (document.layers) {
    }
	adjusttopsel();
}

function hideall()
{
	if (document.all) {
		document.all['topsel'].style.visibility = 'hidden';	    
		document.all['rightsel'].style.visibility = 'hidden';	    
		document.all['bottomsel'].style.visibility = 'hidden';	    
	}
    else if (document.getElementById) {     
		document.getElementById('topsel').style.visibility = 'hidden';	    
		document.getElementById('rightsel').style.visibility = 'hidden';	    
		document.getElementById('bottomsel').style.visibility = 'hidden';	    
    }
	else if (document.layers) {
    }
}
function hide(theid)
{
	if (document.all) {
		document.all[theid].style.visibility = 'hidden';	    
	}
    else if (document.getElementById) {     
		document.getElementById(theid).style.visibility = 'hidden';	    
    }
	else if (document.layers) {
    }
	document.selectform.selbannertoedit.selectedIndex = 0;
}


function adjusttopsel()
{
    if (selectedbanner == "topsel") {
		if (document.all) {
    		document.all.topsel.style.top =	document.all.toptbl.offsetTop + document.all.toptbl.scrollHeight+5;
        	document.all.topsel.style.left = document.all.toptbl.offsetLeft +document.all.toptbl.clientWidth - document.all.topsel.clientWidth;
       		document.all.toselect.style.top = document.all.topsel.clientHeight + document.all.topsel.offsetTop + 5;
			document.all.toselect.style.left = document.all.toptbl.offsetLeft +document.all.toptbl.clientWidth - document.all.toselect.clientWidth;   
		}
		if (document.getElementById) {
    		document.getElementById('topsel').style.top =	document.getElementById('toptbl').offsetTop + document.getElementById('toptbl').offsetHeight+5;
        	document.getElementById('topsel').style.left = document.getElementById('toptbl').offsetLeft +document.getElementById('toptbl').offsetWidth - document.getElementById('topsel').offsetWidth;
       		document.getElementById('toselect').style.top = document.getElementById('topsel').offsetHeight + document.getElementById('topsel').offsetTop + 5;
			document.getElementById('toselect').style.left = document.getElementById('topsel').style.left;
		}
    }
	if (selectedbanner == "rightsel") {
		if (document.all) {
    		document.all.rightsel.style.top =	document.all.toptbl.offsetTop + document.all.toptbl.clientHeight +5;
			document.all.rightsel.style.left =	document.all.toptbl.offsetLeft +document.all.toptbl.clientWidth - document.all.rightsel.scrollWidth - document.all.righttbl.scrollWidth -5;
	  		document.all.toselect.style.top = document.all.rightsel.offsetTop +  document.all.rightsel.clientHeight+5;
			document.all.toselect.style.left = document.all.toptbl.offsetLeft +document.all.toptbl.clientWidth - document.all.toselect.clientWidth - document.all.righttbl.clientWidth -5;
		}
		else if (document.getElementById) {
			//alert(document.getElementById('righttbl').offsetLeft+' '+document.getElementById('rightsel').offsetLeft); 
    		document.getElementById('rightsel').style.top =	document.getElementById('toptbl').offsetTop + document.getElementById('toptbl').offsetHeight +5;
			document.getElementById('rightsel').style.left = document.getElementById('righttbl').offsetLeft-400;
	  		document.getElementById('toselect').style.top = document.getElementById('rightsel').offsetTop +  document.getElementById('rightsel').offsetHeight+5;
			document.getElementById('toselect').style.left = document.getElementById('rightsel').offsetLeft;
		}
    }
	if (selectedbanner == "bottomsel") {
		if (document.all) {
			document.all.bottomsel.style.top =	document.all.bottomtbl.offsetTop - document.all.bottomsel.scrollHeight-5;
        	document.all.bottomsel.style.left =	document.all.bottomtbl.offsetLeft+5;
       		document.all.toselect.style.top = document.all.bottomsel.offsetTop -  document.all.toselect.clientHeight-5;
			document.all.toselect.style.left = document.all.bottomsel.style.left;

		}
		else if (document.getElementById) {
			document.getElementById('bottomsel').style.top = document.getElementById('bottomtbl').offsetTop - document.getElementById('bottomsel').offsetHeight-5;
        	document.getElementById('bottomsel').style.left = document.getElementById('bottomtbl').offsetLeft+5;
       		document.getElementById('toselect').style.top = document.getElementById('bottomsel').offsetTop -  document.getElementById('toselect').offsetHeight-5;
			document.getElementById('toselect').style.left = document.getElementById('bottomsel').style.left;

		}
    }
} 

function selecttopbanner(theid)
{   
    var inputname = eval("document.form1.top_banner"+theid) ;
	if (document.all) {
		document.all.topbanner.innerHTML = inputname.value;	    
		adjusttopsel();
	}
    else if (document.getElementById) {     
		document.getElementById('topbanner').innerHTML = inputname.value;	    
		adjusttopsel();

    }
	else if (document.layers) {
    }
} 
function selectrightbanner(theid)
{
    var inputname = eval("document.formr.right_banner"+theid) ;
	if (document.all) {
		document.all.rightbanner.innerHTML = inputname.value;	    
		adjusttopsel();
	}
    else if (document.getElementById) {     
		document.getElementById('rightbanner').innerHTML = inputname.value;	    
		adjusttopsel();
    }
	else if (document.layers) {
    }
}
function selectbottombanner(theid)
{
    var inputname = eval("document.formb.bottom_banner"+theid) ;
	if (document.all) {
		document.all.bottombanner.innerHTML = inputname.value;	    
		adjusttopsel();
	}
    else if (document.getElementById) {     
		document.getElementById('bottombanner').innerHTML = inputname.value;	    
		adjusttopsel();
    }
	else if (document.layers) {
    }
}
function radiobut(radiobutton)
{
    //alert(document.form1.topb.checked);
	if (radiobutton.length>0) {
	   for (i=0;i<radiobutton.length ;i++ ) {
			if (radiobutton[i].checked == true) {
				return radiobutton[i].value;
			}
	   }
   }
   else {
		if (radiobutton.checked == true) {
				return radiobutton.value;
		}
  }
} // end func

function init()
{
		if (document.all) {
			document.all.topsel.style.top =	document.all.toptbl.offsetTop + document.all.toptbl.scrollHeight+10;
			document.all.topsel.style.left =	document.body.clientWidth - document.all.topsel.clientWidth - 10;
//			document.all.toselect.style.left = document.all.toptbl.offsetLeft +document.all.toptbl.clientWidth - document.all.toselect.clientWidth ;   
			document.all.rightsel.style.top =	document.all.toptbl.offsetTop + document.all.toptbl.clientHeight +5;
			document.all.rightsel.style.left =	document.all.toptbl.offsetLeft +document.all.toptbl.clientWidth - document.all.rightsel.scrollWidth - document.all.righttbl.scrollWidth -5;
			document.all.bottomsel.style.top =	document.all.bottomtbl.offsetTop - document.all.bottomsel.scrollHeight-5;
		   	document.all.bottomsel.style.left =	document.all.bottomtbl.offsetLeft+5;
			document.all.toselect.style.left = document.body.clientWidth - document.all.righttbl.clientWidth - document.all.toselect.clientWidth -50;   
		}
		if (document.getElementById) {
	    }
<?
if ($HTTP_GET_VARS['banner']) {
echo "         showbannermenu('".$HTTP_GET_VARS['banner']."');";
}
?>
} // end func
function screenres() {
 var width = 640, height = 480; // defaults
 if (document.layers) {
    width = window.innerWidth;
    height = window.innerHeight;
 }
 else if (document.all) {
    width = document.body.clientWidth;
    height = document.body.clientHeight;
 }
 else {
    width = window.innerWidth;
    height = window.innerHeight;
 }
screen_width_adj = Math.floor((width-800)/2);
}
//--></script>
</head>

<body onLoad="init();">
<div id="topsel" style="position:absolute; visibility: hidden; left: 160px; top: 100px;"><table border="0" cellpadding="0" cellspacing="0" align="center" style="border: 1px solid #000000;">
<tr bgcolor="#94B5DE"><td><table cellpadding="0" cellspacing="0" width="100%" border="0"><tr><td align="left"><font style="color: #FFFFFF; font-family: verdana; font-weight: bold; font-size: 11px;">&nbsp;Top Banner Panel</font></td><td align="right" width="30%"><a href="javascript:hide('topsel');" class="menu" style="color: #000000;"><img src="<?=HTTP_SERVER_ADMIN?>images/help1.gif" align="absmiddle" border="0" class="imgnoborder" onmouseover="this.className='imgborder';" onmouseout="this.className='imgnoborder';"></a><a href="javascript:hide('topsel');" class="menu" style="color: #000000;"><img src="<?=HTTP_SERVER_ADMIN?>images/close1.gif" align="absmiddle" border="0" onmouseover="this.className='imgborder';" onmouseout="this.className='imgnoborder';"></a><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" width="1" height="18" border="0" align="absmiddle"></td></tr></table></td></tr>	
<tr><td bgcolor="#D6D6CE"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="1" border="0" align="absmiddle"></td></tr>
<tr><td bgcolor="#000000"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="1" border="0" align="absmiddle"></td></tr>
<tr><td bgcolor="#FFFFFF"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="2" border="0" align="absmiddle"></td></tr>
<tr bgcolor="#FFFFFF">
		<td style="font-family: verdana,arial; font-size: 10px; font-weight: bold;" align="center">Please Select a "Top Banner" to edit:</td>
</tr>
<tr><td bgcolor="#FFFFFF"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="2" border="0" align="absmiddle"></td></tr>
<tr bgcolor="#FFFFFF">
		<td style="padding: 3px; font-family: verdana,arial; font-size: 14px; font-weight: bold;" align="center" nowrap>
<form method="post" action="banner_add_banner.php" name="form1">
<?
$t=array();
$banner_files = GetFiles(BANNER_DIR);
	for ($i=0;$i<sizeof($banner_files) ;$i++ ) {
		if (eregi("top_banner(.*)\.html",$banner_files[$i], $regs)) {
			$t[] = $regs[1];   
			$content = '';
			$content = fread(fopen(BANNER_DIR.$banner_files[$i],"r"), filesize(BANNER_DIR.$banner_files[$i]));
			echo "<input type=\"hidden\" name=\"top_banner".$regs[1]."\" value=\"".htmlspecialchars($content)."\">\n";
		}
	}
if (sizeof($t)) {
	for ($i=0; $i<sizeof($t);$i++ ) {
		echo "<input type=\"radio\" name=\"topb\" value=\"".($t[$i])."\" onClick=\"selecttopbanner('".($t[$i])."');\">".($t[$i]);
	}
}
else {
     echo "No top banner file!<br>Please add one..";
} 
?>
</td></tr>
<tr><td bgcolor="#FFFFFF"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="2" border="0" align="absmiddle"></td></tr>
<tr bgcolor="#FFFFFF">
		<td style="font-family: verdana,arial; font-size: 14px; font-weight: bold;" align="center" nowrap>
<input type="hidden" name="filetosave" value="">
<input type="hidden" name="filetype" value="top_banner">
<input type="button" name="edit" value="Edit" style="font-size: 10px" onClick="if (radiobut(document.form1.topb)) {opnew('topbanner',1, 'top_banner');} else {alert('Please Select File ID...');}" class="button">
&nbsp;<input type="submit" name="send" value="Save" style="font-size: 10px; width: 35px;" onClick="if (radiobut(document.form1.topb)) {document.form1.filetosave.value=radiobut(document.form1.topb);} else {alert('Please Select File ID...'); return false;}" class="button">
&nbsp;<input type="submit" name="del" value="Delete" class="button" style="font-size: 10px; width: 40px;" onClick="if (radiobut(document.form1.topb)) {document.form1.filetosave.value=radiobut(document.form1.topb); return confirm('Are you sure you want to delete Top Banner File '+document.form1.filetosave.value+' ?');} else {alert('Please Select File ID...'); return false;}">
&nbsp;<input type="submit" name="add" value="Add New Top Banner"  class="button" style="font-size: 10px; width: 125px; padding-right: 10px;">
</form>
	 </td>
	</tr>
<tr><td bgcolor="#FFFFFF"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="2" border="0" align="absmiddle"></td></tr>
</table></div>
<div id="rightsel" style="position:absolute; visibility: hidden; left: 600px; top: 150px;"><table border="0" cellpadding="0" cellspacing="0" align="center" style="border: 1px solid #000000;">
<tr bgcolor="#94B5DE"><td><table cellpadding="0" cellspacing="0" width="100%" border="0"><tr><td align="left"><font style="color: #FFFFFF; font-family: verdana; font-weight: bold; font-size: 11px;">&nbsp;Right Banner Panel</font></td><td align="right" width="30%"><a href="javascript:hide('rightsel');" class="menu" style="color: #000000;"><img src="<?=HTTP_SERVER_ADMIN?>images/help1.gif" align="absmiddle" border="0" class="imgnoborder" onmouseover="this.className='imgborder';" onmouseout="this.className='imgnoborder';"></a><a href="javascript:hide('rightsel');" class="menu" style="color: #000000;"><img src="<?=HTTP_SERVER_ADMIN?>images/close1.gif" align="absmiddle" border="0" onmouseover="this.className='imgborder';" onmouseout="this.className='imgnoborder';"></a><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" width="1" height="18" border="0" align="absmiddle"></td></tr></table></td></tr>	
<tr><td bgcolor="#D6D6CE"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="1" border="0" align="absmiddle"></td></tr>
<tr><td bgcolor="#000000"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="1" border="0" align="absmiddle"></td></tr>
<tr><td bgcolor="#FFFFFF"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="2" border="0" align="absmiddle"></td></tr>
<tr bgcolor="#FFFFFF">
		<td style="font-family: verdana,arial; font-size: 10px; font-weight: bold;" align="center" nowrap>Please Select a "Right Banner" to edit:</td>
</tr>
<tr><td bgcolor="#FFFFFF"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="2" border="0" align="absmiddle"></td></tr>
<tr bgcolor="#FFFFFF">
		<td style="font-family: verdana,arial; font-size: 12px; font-weight: bold;" align="center">
<form method="post" action="banner_add_banner.php" name="formr">
<?
$r=array();
$banner_files = GetFiles(BANNER_DIR);
	for ($i=0;$i<sizeof($banner_files) ;$i++ ) {
	    if (eregi("right_banner(.*)\.html",$banner_files[$i], $regs)) {
			$r[] = $regs[1];    
			$content = '';
			$content = fread(fopen(BANNER_DIR.$banner_files[$i],"r"), filesize(BANNER_DIR.$banner_files[$i]));
			echo "<input type=\"hidden\" name=\"right_banner".$regs[1]."\" value=\"".htmlspecialchars($content)."\">\n";
		}
	}
if (sizeof($r)) {
for ($i=0; $i<sizeof($r);$i++ ) {
    echo "<input type=\"radio\" name=\"rightb\" value=\"".$r[$i]."\" onClick=\"selectrightbanner('".$r[$i]."');\">".$r[$i];
}
}
else {
    echo "No right banner file!<br>Please add one..";
}
?>
</td></tr>
<tr><td bgcolor="#FFFFFF"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="2" border="0" align="absmiddle"></td></tr>
<tr bgcolor="#FFFFFF">
		<td style="font-family: verdana,arial; font-size: 14px; font-weight: bold;" align="center">
<input type="hidden" name="filetosave" value="">
<input type="hidden" name="filetype" value="right_banner">
<input type="button" name="edit" value="Edit" class="button" style="font-size: 10px;" onClick="opnew('rightbanner',1, 'right_banner');">
<input type="submit" name="del" value="Delete" class="button" style="font-size: 10px; width: 40px;" onClick="if (radiobut(document.formr.rightb)) {document.formr.filetosave.value=radiobut(document.formr.rightb);return confirm('Are you sure you want to delete Right Banner File '+document.formr.filetosave.value+' ?');} else {alert('Please Select File ID...'); return false;}">
<input type="submit" name="send" value="Save" class="button" style="font-size: 10px; width: 32px;" onClick="if (radiobut(document.formr.rightb)) {document.formr.filetosave.value=radiobut(document.formr.rightb);} else {alert('Please Select File ID...'); return false;}">
<input type="submit" name="add" value="Add new Right Banner" style="font-size: 10px;" class="button"><br>
</form>
	 </td>
	</tr>
<tr><td bgcolor="#FFFFFF"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="2" border="0" align="absmiddle"></td></tr>
</table></div>
<div id="bottomsel" style="position:absolute; visibility: hidden; left: 160px; top: 310px;"><table border="0" cellpadding="0" cellspacing="0" align="center" style="border: 1px solid #000000;">
<tr bgcolor="#94B5DE"><td><table cellpadding="0" cellspacing="0" width="100%" border="0"><tr><td align="left"><font style="color: #FFFFFF; font-family: verdana; font-weight: bold; font-size: 11px;">&nbsp;Bottom Banner Panel</font></td><td align="right" width="30%"><a href="javascript:hide('bottomsel');" class="menu" style="color: #000000;"><img src="<?=HTTP_SERVER_ADMIN?>images/help1.gif" align="absmiddle" border="0" class="imgnoborder" onmouseover="this.className='imgborder';" onmouseout="this.className='imgnoborder';"></a><a href="javascript:hide('bottomsel');" class="menu" style="color: #000000;"><img src="<?=HTTP_SERVER_ADMIN?>images/close1.gif" align="absmiddle" border="0" onmouseover="this.className='imgborder';" onmouseout="this.className='imgnoborder';"></a><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" width="1" height="18" border="0" align="absmiddle"></td></tr></table></td></tr>	
<tr><td bgcolor="#D6D6CE"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="1" border="0" align="absmiddle"></td></tr>
<tr><td bgcolor="#000000"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="1" border="0" align="absmiddle"></td></tr>
<tr><td bgcolor="#FFFFFF"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="2" border="0" align="absmiddle"></td></tr>
<tr bgcolor="#FFFFFF">
		<td style="font-family: verdana,arial; font-size: 10px; font-weight: bold;" align="center">Please Select a "Bottom Banner" to edit:</td>
</tr>
<tr><td bgcolor="#FFFFFF"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="2" border="0" align="absmiddle"></td></tr>
<tr bgcolor="#FFFFFF">
		<td style="padding: 3px; font-family: verdana,arial; font-size: 14px; font-weight: bold;" align="center">
<form method="post" action="banner_add_banner.php" name="formb">
<?
$b=array();
$banner_files = GetFiles(BANNER_DIR);
	for ($i=0;$i<sizeof($banner_files) ;$i++ ) {
	    if (eregi("bottom_banner(.*)\.html",$banner_files[$i], $regs)) {
			$b[] = $regs[1];    
			$content = '';
			$content = fread(fopen(BANNER_DIR.$banner_files[$i],"r"), filesize(BANNER_DIR.$banner_files[$i]));
			echo "<input type=\"hidden\" name=\"bottom_banner".$regs[1]."\" value=\"".htmlspecialchars($content)."\">\n";
		}
	}
if (sizeof($b)) {
	for ($i=0; $i<sizeof($b);$i++ ) {
		echo "<input type=\"radio\" name=\"bottomb\" value=\"".$b[$i]."\" onClick=\"selectbottombanner('".$b[$i]."');\">".$b[$i];
	}
}
else {
    echo "No bottom banner file!<br>Please add one..";
}
?>
</td></tr>
<tr><td bgcolor="#FFFFFF"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="2" border="0" align="absmiddle"></td></tr>
<tr bgcolor="#FFFFFF">
		<td style="font-family: verdana,arial; font-size: 14px; font-weight: bold;" align="center">
<input type="hidden" name="filetosave" value="">
<input type="hidden" name="filetype" value="bottom_banner">
<input type="button" name="edit" value="Edit" style="font-size: 10px;" onClick="if (radiobut(document.formb.bottomb)) {opnew('bottombanner',1, 'bottom_banner');}  else {alert('Please Select File ID...');}" class="button">
&nbsp;<input type="submit" name="send" value="Save" style="font-size: 10px; width: 35px;" onClick="if (radiobut(document.formb.bottomb)) {document.formb.filetosave.value=radiobut(document.formb.bottomb);} else {alert('Please Select File ID...'); return false;}" class="button">
&nbsp;<input type="submit" name="del" value="Delete" style="font-size: 10px; width: 40px;" onClick="if (radiobut(document.formb.bottomb)) {document.formb.filetosave.value=radiobut(document.formb.bottomb); return confirm('Are you sure you want to delete Bottom Banner File '+document.formb.filetosave.value+' ?');} else {alert('Please Select File ID...'); return false;}" class="button">
&nbsp;<input type="submit" name="add" value="Add new Bottom Banner" class="button" style="font-size: 10px; width: 145px;">
</form>
     </td>
	</tr>
<tr><td bgcolor="#FFFFFF"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="2" border="0" align="absmiddle"></td></tr>
</table></div>


<table border="0" id="toptbl" cellpadding="0" cellspacing="0" width="<?echo HTML_WIDTH;?>" height="80" bgcolor="#FFFFFF" align="center" style="border: 1px solid #000000">
		<tr>
			<td align="center"><div id="topbanner">Top Banner</div></td>
		</tr>
</table>
<div id="toselect" style="position: absolute; left: 200px; top: 200px;"><table border="0" cellpadding="0" cellspacing="0" align="center" style="border: 1px solid #000000;">
<tr bgcolor="#94B5DE"><td><table cellpadding="0" cellspacing="0" width="100%" border="0"><tr><td align="left"><font style="color: #FFFFFF; font-family: verdana; font-weight: bold; font-size: 11px;">&nbsp;Banner Rotator Panel</font></td><td align="right" width="30%"><a href="javascript:hide('topsel');" class="menu" style="color: #000000;"><img src="<?=HTTP_SERVER_ADMIN?>images/help1.gif" align="absmiddle" border="0" class="imgnoborder" onmouseover="this.className='imgborder';" onmouseout="this.className='imgnoborder';"></a><a href="javascript:hide('toselect');" class="menu" style="color: #000000;"><img src="<?=HTTP_SERVER_ADMIN?>images/close1.gif" align="absmiddle" border="0" onmouseover="this.className='imgborder';" onmouseout="this.className='imgnoborder';"></a><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" width="1" height="18" border="0" align="absmiddle"></td></tr></table></td></tr>	
<tr><td bgcolor="#D6D6CE"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="1" border="0" align="absmiddle"></td></tr>
<tr><td bgcolor="#000000"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="1" border="0" align="absmiddle"></td></tr>
<tr><td bgcolor="#D6D6CE"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="1" border="0" align="absmiddle"></td></tr>
<tr><td bgcolor="#FFFFFF"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="2" border="0" align="absmiddle"></td></tr>
<tr bgcolor="#FFFFFF">
		<td style="padding: 3px; font-family: verdana,arial; font-size: 12px; font-weight: bold;" nowrap><form name="selectform">Select <select name="selbannertoedit" onChange="showbannermenu(this.options[this.selectedIndex].value);"><option value="0">---- Banner ----</option><option value="topsel">Top Banners</option><option value="rightsel">Right Banners</option><option value="bottomsel">Bottom Banners</option></select> to edit</form>
	 </td>
	</tr>
<tr><td bgcolor="#FFFFFF"><img src="<?=HTTP_SERVER_ADMIN?>images/0.gif" height="2" border="0" align="absmiddle"></td></tr>
</table>
</div>