<?
if (!ini_get('register_globals')) 
   {
       $types_to_register = array('GET','POST','COOKIE','SESSION','SERVER');
       foreach ($types_to_register as $type)
       {
           if (@count(${'HTTP_' . $type . '_VARS'}) > 0)
           {
               extract(${'HTTP_' . $type . '_VARS'}, EXTR_OVERWRITE);
           }
       }
   }

?>
<html>
<head>
	<title>Select Color</title>
	<script language="JavaScript" type="text/javascript">
	function submitColor() {
		var frm = document.forms['frmcol'];
		if (validateCol(frm)) {
			frm.submit();
		}
	}
	function validateCol(frm) {
		var temp_value="";
		for(var i = 0; i < frm.colorlist.length; i++) {
			temp_value += frm.colorlist.options[i].value;
			if (i+1<frm.colorlist.length) {
				temp_value += "@";
			}
		}
		frm.send_actions.value = temp_value;
		return true;
	}
	
	function addColor() {
		var col = document.getElementById("selcolor");
		var list = document.getElementById("colorlist");
		var coln = document.getElementById("colorname");
		if (col.value !="") {
			var a = col.value;
			b = a.substr(1,a.length-1);
			list.options[list.length] = new Option(coln.value + ' ( #'+ b + ' )','0!~!' + b + '!#!' + coln.value);
			col.value="";
			coln.value="";
			coln.focus();
		}else {
			alert("Please insert a color");
		}
	}
	function delColor() {
		var list = document.getElementById("colorlist");
		if (list.selectedIndex !=-1) {
			list.options[list.selectedIndex] = null;
		}else {
			alert("Please select a color from Color list");
		}
	}
	function goAddColor() {
		var frm = document.forms['frmcol'];
		frm.action.value = 4;
		if (validateCol(frm)) {
			frm.submit();
		}
	}
	</script>
	<script language="JavaScript" for="ColorTable" event="onclick">
	  selhicolor.style.backgroundColor = event.srcElement.title;
	  selcolor.value = event.srcElement.title;
	</script>
	<script language="JavaScript" for="ColorTable" event="onmouseover">
		hicolortext.innerText = event.srcElement.title;
		hicolor.style.backgroundColor = event.srcElement.title;
	</script>
	<script language="JavaScript" for="ColorTable" event="onmouseout">
	  hicolortext.innerText = "";
	  hicolor.style.backgroundColor = "";
	</script>
	<script language="JavaScript" for="btnOK" event="onclick">
	  window.returnValue = selcolor.value;
	  window.close();
	</script>
	<script language="JavaScript" for="btnClear" event="onclick">
	  selhicolor.style.backgroundColor = '';
	  selcolor.value='';
	</script>
	<script language="JavaScript" for="selcolor" event="onpropertychange">
	  try{selhicolor.style.backgroundColor = selcolor.value;}
	  catch(e) {}
	</script>
	<?
	if ($actiontype=="ColorManage")
	{
		echo '
		<script language="JavaScript" type="text/javascript">
			self.opener.document.forms["formcolors"].'.$lb.'.value = "'.$selcolor.'";
			self.opener.document.forms["formcolors"].'.$lb.'Img.style.backgroundColor = "'.$selcolor.'";
			self.close();
        </script>';
	}
	?>
	<link href="../styles_adm.css" rel="stylesheet" type="text/css">
</head>

<body marginheight="0" marginwidth="0" leftmargin="0" rightmargin="0" bottommargin="0" topmargin="0">
<form action="<?=$PHP_SELF?>" method="post" name="searchCol">
<input type="hidden" name="actiontype">
<input type="hidden" name="lb" value="<?=$lb?>">
<img src="images/pixel.gif" width="1" height="5" border="0"><br>
<table cellspacing="0" cellpadding="0" border="0" align="center" height="175">
<tr>
	<td style="border:1px solid #000000">
		<table id="ColorTable" border="0" cellspacing="0" cellpadding="0" width="270" height="175" class="selcolor">
		<tr>
			<td bgcolor="#000000" title="000000"></td>
			<td bgcolor="#003300" title="003300"></td>
			<td bgcolor="#006600" title="006600"></td>
			<td bgcolor="#009900" title="009900"></td>
			<td bgcolor="#00CC00" title="00CC00"></td>
			<td bgcolor="#00FF00" title="00FF00"></td>
			<td bgcolor="#330000" title="330000"></td>
			<td bgcolor="#333300" title="333300"></td>
			<td bgcolor="#336600" title="336600"></td>
			<td bgcolor="#339900" title="339900"></td>
			<td bgcolor="#33CC00" title="33CC00"></td>
			<td bgcolor="#33FF00" title="33FF00"></td>
			<td bgcolor="#660000" title="660000"></td>
			<td bgcolor="#663300" title="663300"></td>
			<td bgcolor="#666600" title="666600"></td>
			<td bgcolor="#669900" title="669900"></td>
			<td bgcolor="#66CC00" title="66CC00"></td>
			<td bgcolor="#66FF00" title="66FF00"></td>
		</tr>
		<tr>
			<td bgcolor="#000033" title="000033"></td>
			<td bgcolor="#003333" title="003333"></td>
			<td bgcolor="#006633" title="006633"></td>
			<td bgcolor="#009933" title="009933"></td>
			<td bgcolor="#00CC33" title="00CC33"></td>
			<td bgcolor="#00FF33" title="00FF33"></td>
			<td bgcolor="#330033" title="330033"></td>
			<td bgcolor="#333333" title="333333"></td>
			<td bgcolor="#336633" title="336633"></td>
			<td bgcolor="#339933" title="339933"></td>
			<td bgcolor="#33CC33" title="33CC33"></td>
			<td bgcolor="#33FF33" title="33FF33"></td>
			<td bgcolor="#660033" title="660033"></td>
			<td bgcolor="#663333" title="663333"></td>
			<td bgcolor="#666633" title="666633"></td>
			<td bgcolor="#669933" title="669933"></td>
			<td bgcolor="#66CC33" title="66CC33"></td>
			<td bgcolor="#66FF33" title="66FF33"></td>
		</tr>
		<tr>
			<td bgcolor="#000066" title="000066"></td>
			<td bgcolor="#003366" title="003366"></td>
			<td bgcolor="#006666" title="006666"></td>
			<td bgcolor="#009966" title="009966"></td>
			<td bgcolor="#00CC66" title="00CC66"></td>
			<td bgcolor="#00FF66" title="00FF66"></td>
			<td bgcolor="#330066" title="330066"></td>
			<td bgcolor="#333366" title="333366"></td>
			<td bgcolor="#336666" title="336666"></td>
			<td bgcolor="#339966" title="339966"></td>
			<td bgcolor="#33CC66" title="33CC66"></td>
			<td bgcolor="#33FF66" title="33FF66"></td>
			<td bgcolor="#660066" title="660066"></td>
			<td bgcolor="#663366" title="663366"></td>
			<td bgcolor="#666666" title="666666"></td>
			<td bgcolor="#669966" title="669966"></td>
			<td bgcolor="#66CC66" title="66CC66"></td>
			<td bgcolor="#66FF66" title="66FF66"></td>
		</tr>
		<tr>
			<td bgcolor="#000099" title="000099"></td>
			<td bgcolor="#003399" title="003399"></td>
			<td bgcolor="#006699" title="006699"></td>
			<td bgcolor="#009999" title="009999"></td>
			<td bgcolor="#00CC99" title="00CC99"></td>
			<td bgcolor="#00FF99" title="00FF99"></td>
			<td bgcolor="#330099" title="330099"></td>
			<td bgcolor="#333399" title="333399"></td>
			<td bgcolor="#336699" title="336699"></td>
			<td bgcolor="#339999" title="339999"></td>
			<td bgcolor="#33CC99" title="33CC99"></td>
			<td bgcolor="#33FF99" title="33FF99"></td>
			<td bgcolor="#660099" title="660099"></td>
			<td bgcolor="#663399" title="663399"></td>
			<td bgcolor="#666699" title="666699"></td>
			<td bgcolor="#669999" title="669999"></td>
			<td bgcolor="#66CC99" title="66CC99"></td>
			<td bgcolor="#66FF99" title="66FF99"></td>
		</tr>
		<tr>
			<td bgcolor="#0000CC" title="0000CC"></td>
			<td bgcolor="#0033CC" title="0033CC"></td>
			<td bgcolor="#0066CC" title="0066CC"></td>
			<td bgcolor="#0099CC" title="0099CC"></td>
			<td bgcolor="#00CCCC" title="00CCCC"></td>
			<td bgcolor="#00FFCC" title="00FFCC"></td>
			<td bgcolor="#3300CC" title="3300CC"></td>
			<td bgcolor="#3333CC" title="3333CC"></td>
			<td bgcolor="#3366CC" title="3366CC"></td>
			<td bgcolor="#3399CC" title="3399CC"></td>
			<td bgcolor="#33CCCC" title="33CCCC"></td>
			<td bgcolor="#33FFCC" title="33FFCC"></td>
			<td bgcolor="#6600CC" title="6600CC"></td>
			<td bgcolor="#6633CC" title="6633CC"></td>
			<td bgcolor="#6666CC" title="6666CC"></td>
			<td bgcolor="#6699CC" title="6699CC"></td>
			<td bgcolor="#66CCCC" title="66CCCC"></td>
			<td bgcolor="#66FFCC" title="66FFCC"></td>
		</tr>
		<tr>
			<td bgcolor="#0000FF" title="0000FF"></td>
			<td bgcolor="#0033FF" title="0033FF"></td>
			<td bgcolor="#0066FF" title="0066FF"></td>
			<td bgcolor="#0099FF" title="0099FF"></td>
			<td bgcolor="#00CCFF" title="00CCFF"></td>
			<td bgcolor="#00FFFF" title="00FFFF"></td>
			<td bgcolor="#3300FF" title="3300FF"></td>
			<td bgcolor="#3333FF" title="3333FF"></td>
			<td bgcolor="#3366FF" title="3366FF"></td>
			<td bgcolor="#3399FF" title="3399FF"></td>
			<td bgcolor="#33CCFF" title="33CCFF"></td>
			<td bgcolor="#33FFFF" title="33FFFF"></td>
			<td bgcolor="#6600FF" title="6600FF"></td>
			<td bgcolor="#6633FF" title="6633FF"></td>
			<td bgcolor="#6666FF" title="6666FF"></td>
			<td bgcolor="#6699FF" title="6699FF"></td>
			<td bgcolor="#66CCFF" title="66CCFF"></td>
			<td bgcolor="#66FFFF" title="66FFFF"></td>
		</tr>
		<tr>
			<td bgcolor="#990000" title="990000"></td>
			<td bgcolor="#993300" title="993300"></td>
			<td bgcolor="#996600" title="996600"></td>
			<td bgcolor="#999900" title="999900"></td>
			<td bgcolor="#99CC00" title="99CC00"></td>
			<td bgcolor="#99FF00" title="99FF00"></td>
			<td bgcolor="#CC0000" title="CC0000"></td>
			<td bgcolor="#CC3300" title="CC3300"></td>
			<td bgcolor="#CC6600" title="CC6600"></td>
			<td bgcolor="#CC9900" title="CC9900"></td>
			<td bgcolor="#CCCC00" title="CCCC00"></td>
			<td bgcolor="#CCFF00" title="CCFF00"></td>
			<td bgcolor="#FF0000" title="FF0000"></td>
			<td bgcolor="#FF3300" title="FF3300"></td>
			<td bgcolor="#FF6600" title="FF6600"></td>
			<td bgcolor="#FF9900" title="FF9900"></td>
			<td bgcolor="#FFCC00" title="FFCC00"></td>
			<td bgcolor="#FFFF00" title="FFFF00"></td>
		</tr>
		<tr>
			<td bgcolor="#990033" title="990033"></td>
			<td bgcolor="#993333" title="993333"></td>
			<td bgcolor="#996633" title="996633"></td>
			<td bgcolor="#999933" title="999933"></td>
			<td bgcolor="#99CC33" title="99CC33"></td>
			<td bgcolor="#99FF33" title="99FF33"></td>
			<td bgcolor="#CC0033" title="CC0033"></td>
			<td bgcolor="#CC3333" title="CC3333"></td>
			<td bgcolor="#CC6633" title="CC6633"></td>
			<td bgcolor="#CC9933" title="CC9933"></td>
			<td bgcolor="#CCCC33" title="CCCC33"></td>
			<td bgcolor="#CCFF33" title="CCFF33"></td>
			<td bgcolor="#FF0033" title="FF0033"></td>
			<td bgcolor="#FF3333" title="FF3333"></td>
			<td bgcolor="#FF6633" title="FF6633"></td>
			<td bgcolor="#FF9933" title="FF9933"></td>
			<td bgcolor="#FFCC33" title="FFCC33"></td>
			<td bgcolor="#FFFF33" title="FFFF33"></td>
		</tr>
		<tr>
			<td bgcolor="#990066" title="990066"></td>
			<td bgcolor="#993366" title="993366"></td>
			<td bgcolor="#996666" title="996666"></td>
			<td bgcolor="#999966" title="999966"></td>
			<td bgcolor="#99CC66" title="99CC66"></td>
			<td bgcolor="#99FF66" title="99FF66"></td>
			<td bgcolor="#CC0066" title="CC0066"></td>
			<td bgcolor="#CC3366" title="CC3366"></td>
			<td bgcolor="#CC6666" title="CC6666"></td>
			<td bgcolor="#CC9966" title="CC9966"></td>
			<td bgcolor="#CCCC66" title="CCCC66"></td>
			<td bgcolor="#CCFF66" title="CCFF66"></td>
			<td bgcolor="#FF0066" title="FF0066"></td>
			<td bgcolor="#FF3366" title="FF3366"></td>
			<td bgcolor="#FF6666" title="FF6666"></td>
			<td bgcolor="#FF9966" title="FF9966"></td>
			<td bgcolor="#FFCC66" title="FFCC66"></td>
			<td bgcolor="#FFFF66" title="FFFF66"></td>
		</tr>
		<tr>
			<td bgcolor="#990099" title="990099"></td>
			<td bgcolor="#993399" title="993399"></td>
			<td bgcolor="#996699" title="996699"></td>
			<td bgcolor="#999999" title="999999"></td>
			<td bgcolor="#99CC99" title="99CC99"></td>
			<td bgcolor="#99FF99" title="99FF99"></td>
			<td bgcolor="#CC0099" title="CC0099"></td>
			<td bgcolor="#CC3399" title="CC3399"></td>
			<td bgcolor="#CC6699" title="CC6699"></td>
			<td bgcolor="#CC9999" title="CC9999"></td>
			<td bgcolor="#CCCC99" title="CCCC99"></td>
			<td bgcolor="#CCFF99" title="CCFF99"></td>
			<td bgcolor="#FF0099" title="FF0099"></td>
			<td bgcolor="#FF3399" title="FF3399"></td>
			<td bgcolor="#FF6699" title="FF6699"></td>
			<td bgcolor="#FF9999" title="FF9999"></td>
			<td bgcolor="#FFCC99" title="FFCC99"></td>
			<td bgcolor="#FFFF99" title="FFFF99"></td>
		</tr>
		<tr>
			<td bgcolor="#9900CC" title="9900CC"></td>
			<td bgcolor="#9933CC" title="9933CC"></td>
			<td bgcolor="#9966CC" title="9966CC"></td>
			<td bgcolor="#9999CC" title="9999CC"></td>
			<td bgcolor="#99CCCC" title="99CCCC"></td>
			<td bgcolor="#99FFCC" title="99FFCC"></td>
			<td bgcolor="#CC00CC" title="CC00CC"></td>
			<td bgcolor="#CC33CC" title="CC33CC"></td>
			<td bgcolor="#CC66CC" title="CC66CC"></td>
			<td bgcolor="#CC99CC" title="CC99CC"></td>
			<td bgcolor="#CCCCCC" title="CCCCCC"></td>
			<td bgcolor="#CCFFCC" title="CCFFCC"></td>
			<td bgcolor="#FF00CC" title="FF00CC"></td>
			<td bgcolor="#FF33CC" title="FF33CC"></td>
			<td bgcolor="#FF66CC" title="FF66CC"></td>
			<td bgcolor="#FF99CC" title="FF99CC"></td>
			<td bgcolor="#FFCCCC" title="FFCCCC"></td>
			<td bgcolor="#FFFFCC" title="FFFFCC"></td>
		</tr>
		<tr>
			<td bgcolor="#9900FF" title="9900FF"></td>
			<td bgcolor="#9933FF" title="9933FF"></td>
			<td bgcolor="#9966FF" title="9966FF"></td>
			<td bgcolor="#9999FF" title="9999FF"></td>
			<td bgcolor="#99CCFF" title="99CCFF"></td>
			<td bgcolor="#99FFFF" title="99FFFF"></td>
			<td bgcolor="#CC00FF" title="CC00FF"></td>
			<td bgcolor="#CC33FF" title="CC33FF"></td>
			<td bgcolor="#CC66FF" title="CC66FF"></td>
			<td bgcolor="#CC99FF" title="CC99FF"></td>
			<td bgcolor="#CCCCFF" title="CCCCFF"></td>
			<td bgcolor="#CCFFFF" title="CCFFFF"></td>
			<td bgcolor="#FF00FF" title="FF00FF"></td>
			<td bgcolor="#FF33FF" title="FF33FF"></td>
			<td bgcolor="#FF66FF" title="FF66FF"></td>
			<td bgcolor="#FF99FF" title="FF99FF"></td>
			<td bgcolor="#FFCCFF" title="FFCCFF"></td>
			<td bgcolor="#FFFFFF" title="FFFFFF"></td>
		</tr>
		<tr>
			<td bgcolor="#000000" title="000000"></td>
			<td bgcolor="#333333" title="333333"></td>
			<td bgcolor="#666666" title="666666"></td>
			<td bgcolor="#999999" title="999999"></td>
			<td bgcolor="#CCCCCC" title="CCCCCC"></td>
			<td bgcolor="#FFFFFF" title="FFFFFF"></td>
			<td bgcolor="#000000" title="000000"></td>
			<td bgcolor="#000000" title="000000"></td>
			<td bgcolor="#000000" title="000000"></td>
			<td bgcolor="#000000" title="000000"></td>
			<td bgcolor="#000000" title="000000"></td>
			<td bgcolor="#000000" title="000000"></td>
			<td bgcolor="#000000" title="000000"></td>
			<td bgcolor="#000000" title="000000"></td>
			<td bgcolor="#000000" title="000000"></td>
			<td bgcolor="#000000" title="000000"></td>
			<td bgcolor="#000000" title="000000"></td>
			<td bgcolor="#000000" title="000000"></td>
		</tr>
		</table>
	</td>
	<td><img src="images/pixel.gif" width="10" height="1" border="0"></td>
	<td valign="top">
		<table cellspacing="0" cellpadding="0" border="0" height="175">
		<tr>
			<td class="textblack11">Highlight:</td>
		</tr>
        <tr>
        	<td class="textblack11">
				<div style="height:20px; width:74px; border-width:1px; border-style:solid;" id="hicolor"></div>
				<div style="width:75px; text-align:right; margin-bottom:7px;" id="hicolortext"></div>
			</td>
        </tr>
		<tr>
			<td class="textblack11">
				Selected:
				<div style="height:20px; width:74px; border-width:1px; border-style:solid;" id="selhicolor"></div>
				<input type="text" id="selcolor" style="width:75px; height:20px; margin-top:0px; margin-bottom:7px;" maxlength="20" class="textbox" name="selcolor"></td>
		</tr>
		<tr>
			<td height="10"><button name="btnClear" style="width:75px; height:22px; margin-top:7px; margin-bottom:7px" onClick="" class="textbox">Clear</button></td>
		</tr>
		<tr>
			<td><input type="submit" value="Select Color" name="btnSelect" style="width:75px; height:22px; margin-top:7px; margin-bottom:7px" onClick="document.forms.searchCol.actiontype.value='ColorManage';" class="textbox" style="cursor: hand"></td>
		</tr>
        </table>
	</td>
</tr>	
</table>
</form>
</body>
</html>
