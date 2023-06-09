<script language=javascript>

var myPage = window.opener;

var pageTitle = myPage.foo.document.title;
var pageBgColor = myPage.foo.document.body.bgColor;
var pageLinkColor = myPage.foo.document.body.link;
var pageTextColor = myPage.foo.document.body.text;
var backgroundImage = myPage.foo.document.body.background;
var metaKeywords = ""
var metaDescription = ""
var oDescription
var oKeywords

var metaData = myPage.foo.document.getElementsByTagName('META')
for (var m = 0; m < metaData.length; m++) {
	if (metaData[m].name.toUpperCase() == "KEYWORDS") {
      metaKeywords = metaData[m].content
	  oKeywords = metaData[m]
	}
	  
	if (metaData[m].name.toUpperCase() == 'DESCRIPTION') {
      metaDescription = metaData[m].content
	  oDescription = metaData[m]
	}

}


window.onload = setValues;

function setValues() {

	pageForm.pagetitle.value = pageTitle;
	pageForm.description.value = metaDescription;
	pageForm.keywords.value = metaKeywords;
	pageForm.bgImage.value = backgroundImage;
	this.focus();
}

function doModify() {
	var bgImage = pageForm.bgImage.value
	var bgcolor = pageForm.bgcolor[pageForm.bgcolor.selectedIndex].text
	var linkcolor = pageForm.linkcolor[pageForm.linkcolor.selectedIndex].text
	var textcolor = pageForm.textcolor[pageForm.textcolor.selectedIndex].text

	if (bgImage != "") { myPage.foo.document.body.background = bgImage } else { myPage.foo.document.body.removeAttribute("background",0) }
	if (bgcolor != "None") { myPage.foo.document.body.bgColor = bgcolor } else { myPage.foo.document.body.removeAttribute("bgColor",0) }
	if (linkcolor != "None") { myPage.foo.document.body.link = linkcolor } else { myPage.foo.document.body.removeAttribute("link",0) }
	if (textcolor != "None") { myPage.foo.document.body.text = textcolor } else { myPage.foo.document.body.removeAttribute("text",0) }

	myPage.foo.document.title = pageForm.pagetitle.value
	
	var oHead = myPage.foo.document.getElementsByTagName('HEAD')

	if (oKeywords != null) {
		oKeywords.content = pageForm.keywords.value
	} else {
		var oMetaKeywords = myPage.foo.document.createElement("META");
		oMetaKeywords.name = "Keywords"
		oMetaKeywords.content = pageForm.keywords.value
		oHead(0).appendChild(oMetaKeywords)
	}

		if (oDescription != null){
			oDescription.content = pageForm.description.value
		} else {
			var oMetaDesc= myPage.foo.document.createElement("META");
			oMetaDesc.name = "Description"
			oMetaDesc.content = pageForm.description.value
			oHead(0).appendChild(oMetaDesc);
		}

	window.close()
}

function printBgColor() {
	if ((pageBgColor != undefined) && (pageBgColor != "")) {
		document.write('<option selected style="BACKGROUND-COLOR: ' + pageBgColor + '">' + pageBgColor)
		document.write('<option>None')
	} else {
		document.write('<option selected>None')
	}
}

function printLinkColor() {
	if ((pageLinkColor != undefined) && (pageLinkColor != "")) {
		document.write('<option selected style="BACKGROUND-COLOR: ' + pageLinkColor + '">' + pageLinkColor)
		document.write('<option>None')
	} else {
		document.write('<option selected>None')
	}
}

function printTextColor() {
	if ((pageTextColor != undefined) && (pageTextColor != "")) {
		document.write('<option selected style="BACKGROUND-COLOR: ' + pageTextColor + '">' + pageTextColor)
		document.write('<option>None')
	} else {
		document.write('<option selected>None')
	}
}

document.onkeydown = function () { 
	if (event.keyCode == 13) {	// ENTER
				doModify()			
	}
};

document.onkeypress = onkeyup = function () { 
	if (event.keyCode == 13) {	// ENTER
	event.cancelBubble = true;
	event.returnValue = false;
	return false;
	}
};

</script>

<form name=pageForm>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td width="15"><img src="ew/ew_images/1x1.gif" width="15" height="1"></td>
	  <td class="heading1">[sTxtPageProps]</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	  <td class="body">[sTxtPagePropsInst]<br>
		[sTxtCloseWin]</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td class="body">&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td class="body">
	  <table width="98%" border="0" cellspacing="0" cellpadding="0" class="bevel1">
  		<tr>
		    <td>&nbsp;&nbsp;[sTxtPageProps]</td>
		</tr>
	  </table>
	</td>
  </tr>
  <tr>
	<td colspan="2"><img src="ew/ew_images/1x1.gif" width="1" height="10"></td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td class="body">
	 	  
		<table border="0" cellspacing="0" cellpadding="5" width="98%" class="bevel2">
		  <tr>
			<td class="body" width="100">[sTxtPageTitle]:</td>
			<td class="body">
			  <input type="text" name="pagetitle" maxlength="100" class=text220>
			</td>
		  </tr>
		  <tr>
			<td class="body" valign="top">[sTxtDescription]:</td>
			<td class="body">
			  <textarea name="description" class="text220" rows="4"></textarea>
			</td>
		  </tr>
		  <tr>
			<td class="body">[sTxtKeywords]:</td>
			<td class="body">
			  <input type="text" name="keywords" maxlength="300" class=text220>
			</td>
		  </tr>
		  <tr>
			<td class="body">[sTxtBgImage]:</td>
			<td class="body">
			  <input type="text" name="bgImage" maxlength="300" class=text220>
			  </td>
		  </tr>
		  
		  <tr>
			<td class="body">[sTxtBgColor]:</td>
			<td class="body">
			  <select class=text70 name=bgcolor>
				<script>printBgColor()</script>
				<option style="BACKGROUND-COLOR: #ff0000">#FF0000
				<option style="BACKGROUND-COLOR: #ffff00">#FFFF00
				<option style="BACKGROUND-COLOR: #00ff00">#00FF00
				<option style="BACKGROUND-COLOR: #00ffff">#00FFFF
				<option style="BACKGROUND-COLOR: #0000ff">#0000FF
				<option style="BACKGROUND-COLOR: #ff00ff">#FF00FF
				<option style="BACKGROUND-COLOR: #ffffff">#FFFFFF
				<option style="BACKGROUND-COLOR: #f5f5f5">#F5F5F5
				<option style="BACKGROUND-COLOR: #dcdcdc">#DCDCDC
				<option style="BACKGROUND-COLOR: #d3d3d3">#D3D3D3
				<option style="BACKGROUND-COLOR: #c0c0c0">#C0C0C0
				<option style="BACKGROUND-COLOR: #a9a9a9">#A9A9A9
				<option style="BACKGROUND-COLOR: #808080">#808080
				<option style="BACKGROUND-COLOR: #696969">#696969
				<option style="BACKGROUND-COLOR: #000000">#000000
				<option style="BACKGROUND-COLOR: #2f4f4f">#2F4F4F
				<option style="BACKGROUND-COLOR: #708090">#708090
				<option style="BACKGROUND-COLOR: #778899">#778899
				<option style="BACKGROUND-COLOR: #4682b4">#4682B4
				<option style="BACKGROUND-COLOR: #4169e1">#4169E1
				<option style="BACKGROUND-COLOR: #6495ed">#6495ED
				<option style="BACKGROUND-COLOR: #b0c4de">#B0C4DE
				<option style="BACKGROUND-COLOR: #7b68ee">#7B68EE
				<option style="BACKGROUND-COLOR: #6a5acd">#6A5ACD
				<option style="BACKGROUND-COLOR: #483d8b">#483D8B
				<option style="BACKGROUND-COLOR: #191970">#191970
				<option style="BACKGROUND-COLOR: #000080">#000080
				<option style="BACKGROUND-COLOR: #00008b">#00008B
				<option style="BACKGROUND-COLOR: #0000cd">#0000CD
				<option style="BACKGROUND-COLOR: #1e90ff">#1E90FF
				<option style="BACKGROUND-COLOR: #00bfff">#00BFFF
				<option style="BACKGROUND-COLOR: #87cefa">#87CEFA
				<option style="BACKGROUND-COLOR: #87ceeb">#87CEEB
				<option style="BACKGROUND-COLOR: #add8e6">#ADD8E6
				<option style="BACKGROUND-COLOR: #b0e0e6">#B0E0E6
				<option style="BACKGROUND-COLOR: #f0ffff">#F0FFFF
				<option style="BACKGROUND-COLOR: #e0ffff">#E0FFFF
				<option style="BACKGROUND-COLOR: #afeeee">#AFEEEE
				<option style="BACKGROUND-COLOR: #00ced1">#00CED1
				<option style="BACKGROUND-COLOR: #5f9ea0">#5F9EA0
				<option style="BACKGROUND-COLOR: #48d1cc">#48D1CC
				<option style="BACKGROUND-COLOR: #00ffff">#00FFFF
				<option style="BACKGROUND-COLOR: #40e0d0">#40E0D0
				<option style="BACKGROUND-COLOR: #20b2aa">#20B2AA
				<option style="BACKGROUND-COLOR: #008b8b">#008B8B
				<option style="BACKGROUND-COLOR: #008080">#008080
				<option style="BACKGROUND-COLOR: #7fffd4">#7FFFD4
				<option style="BACKGROUND-COLOR: #66cdaa">#66CDAA
				<option style="BACKGROUND-COLOR: #8fbc8f">#8FBC8F
				<option style="BACKGROUND-COLOR: #3cb371">#3CB371
				<option style="BACKGROUND-COLOR: #2e8b57">#2E8B57
				<option style="BACKGROUND-COLOR: #006400">#006400
				<option style="BACKGROUND-COLOR: #008000">#008000
				<option style="BACKGROUND-COLOR: #228b22">#228B22
				<option style="BACKGROUND-COLOR: #32cd32">#32CD32
				<option style="BACKGROUND-COLOR: #00ff00">#00FF00
				<option style="BACKGROUND-COLOR: #7fff00">#7FFF00
				<option style="BACKGROUND-COLOR: #7cfc00">#7CFC00
				<option style="BACKGROUND-COLOR: #adff2f">#ADFF2F
				<option style="BACKGROUND-COLOR: #98fb98">#98FB98
				<option style="BACKGROUND-COLOR: #90ee90">#90EE90
				<option style="BACKGROUND-COLOR: #00ff7f">#00FF7F
				<option style="BACKGROUND-COLOR: #00fa9a">#00FA9A
				<option style="BACKGROUND-COLOR: #556b2f">#556B2F
				<option style="BACKGROUND-COLOR: #6b8e23">#6B8E23
				<option style="BACKGROUND-COLOR: #808000">#808000
				<option style="BACKGROUND-COLOR: #bdb76b">#BDB76B
				<option style="BACKGROUND-COLOR: #b8860b">#B8860B
				<option style="BACKGROUND-COLOR: #daa520">#DAA520
				<option style="BACKGROUND-COLOR: #ffd700">#FFD700
				<option style="BACKGROUND-COLOR: #f0e68c">#F0E68C
				<option style="BACKGROUND-COLOR: #eee8aa">#EEE8AA
				<option style="BACKGROUND-COLOR: #ffebcd">#FFEBCD
				<option style="BACKGROUND-COLOR: #ffe4b5">#FFE4B5
				<option style="BACKGROUND-COLOR: #f5deb3">#F5DEB3
				<option style="BACKGROUND-COLOR: #ffdead">#FFDEAD
				<option style="BACKGROUND-COLOR: #deb887">#DEB887
				<option style="BACKGROUND-COLOR: #d2b48c">#D2B48C
				<option style="BACKGROUND-COLOR: #bc8f8f">#BC8F8F
				<option style="BACKGROUND-COLOR: #a0522d">#A0522D
				<option style="BACKGROUND-COLOR: #8b4513">#8B4513
				<option style="BACKGROUND-COLOR: #d2691e">#D2691E
				<option style="BACKGROUND-COLOR: #cd853f">#CD853F
				<option style="BACKGROUND-COLOR: #f4a460">#F4A460
				<option style="BACKGROUND-COLOR: #8b0000">#8B0000
				<option style="BACKGROUND-COLOR: #800000">#800000
				<option style="BACKGROUND-COLOR: #a52a2a">#A52A2A
				<option style="BACKGROUND-COLOR: #b22222">#B22222
				<option style="BACKGROUND-COLOR: #cd5c5c">#CD5C5C
				<option style="BACKGROUND-COLOR: #f08080">#F08080
				<option style="BACKGROUND-COLOR: #fa8072">#FA8072
				<option style="BACKGROUND-COLOR: #e9967a">#E9967A
				<option style="BACKGROUND-COLOR: #ffa07a">#FFA07A
				<option style="BACKGROUND-COLOR: #ff7f50">#FF7F50
				<option style="BACKGROUND-COLOR: #ff6347">#FF6347
				<option style="BACKGROUND-COLOR: #ff8c00">#FF8C00
				<option style="BACKGROUND-COLOR: #ffa500">#FFA500
				<option style="BACKGROUND-COLOR: #ff4500">#FF4500
				<option style="BACKGROUND-COLOR: #dc143c">#DC143C
				<option style="BACKGROUND-COLOR: #ff0000">#FF0000
				<option style="BACKGROUND-COLOR: #ff1493">#FF1493
				<option style="BACKGROUND-COLOR: #ff00ff">#FF00FF
				<option style="BACKGROUND-COLOR: #ff69b4">#FF69B4
				<option style="BACKGROUND-COLOR: #ffb6c1">#FFB6C1
				<option style="BACKGROUND-COLOR: #ffc0cb">#FFC0CB
				<option style="BACKGROUND-COLOR: #db7093">#DB7093
				<option style="BACKGROUND-COLOR: #c71585">#C71585
				<option style="BACKGROUND-COLOR: #800080">#800080
				<option style="BACKGROUND-COLOR: #8b008b">#8B008B
				<option style="BACKGROUND-COLOR: #9370db">#9370DB
				<option style="BACKGROUND-COLOR: #8a2be2">#8A2BE2
				<option style="BACKGROUND-COLOR: #4b0082">#4B0082
				<option style="BACKGROUND-COLOR: #9400d3">#9400D3
				<option style="BACKGROUND-COLOR: #9932cc">#9932CC
				<option style="BACKGROUND-COLOR: #ba55d3">#BA55D3
				<option style="BACKGROUND-COLOR: #da70d6">#DA70D6
				<option style="BACKGROUND-COLOR: #ee82ee">#EE82EE
				<option style="BACKGROUND-COLOR: #dda0dd">#DDA0DD
				<option style="BACKGROUND-COLOR: #d8bfd8">#D8BFD8
				<option style="BACKGROUND-COLOR: #e6e6fa">#E6E6FA
				<option style="BACKGROUND-COLOR: #f8f8ff">#F8F8FF
				<option style="BACKGROUND-COLOR: #f0f8ff">#F0F8FF
				<option style="BACKGROUND-COLOR: #f5fffa">#F5FFFA
				<option style="BACKGROUND-COLOR: #f0fff0">#F0FFF0
				<option style="BACKGROUND-COLOR: #fafad2">#FAFAD2
				<option style="BACKGROUND-COLOR: #fffacd">#FFFACD
				<option style="BACKGROUND-COLOR: #fff8dc">#FFF8DC
				<option style="BACKGROUND-COLOR: #ffffe0">#FFFFE0
				<option style="BACKGROUND-COLOR: #fffff0">#FFFFF0
				<option style="BACKGROUND-COLOR: #fffaf0">#FFFAF0
				<option style="BACKGROUND-COLOR: #faf0e6">#FAF0E6
				<option style="BACKGROUND-COLOR: #fdf5e6">#FDF5E6
				<option style="BACKGROUND-COLOR: #faebd7">#FAEBD7
				<option style="BACKGROUND-COLOR: #ffe4c4">#FFE4C4
				<option style="BACKGROUND-COLOR: #ffdab9">#FFDAB9
				<option style="BACKGROUND-COLOR: #ffefd5">#FFEFD5
				<option style="BACKGROUND-COLOR: #fff5ee">#FFF5EE
				<option style="BACKGROUND-COLOR: #fff0f5">#FFF0F5
				<option style="BACKGROUND-COLOR: #ffe4e1">#FFE4E1
				<option style="BACKGROUND-COLOR: #fffafa">#FFFAFA</option>
			  </select>
			</td>
		  </tr>
		  <tr>
			<td class="body">[sTxtTextColor]:</td>
			<td class="body">
			  <select class=text70 name=textcolor> 
				<script>printTextColor()</script>
				<option style="BACKGROUND-COLOR: #ff0000">#FF0000
				<option style="BACKGROUND-COLOR: #ffff00">#FFFF00
				<option style="BACKGROUND-COLOR: #00ff00">#00FF00
				<option style="BACKGROUND-COLOR: #00ffff">#00FFFF
				<option style="BACKGROUND-COLOR: #0000ff">#0000FF
				<option style="BACKGROUND-COLOR: #ff00ff">#FF00FF
				<option style="BACKGROUND-COLOR: #ffffff">#FFFFFF
				<option style="BACKGROUND-COLOR: #f5f5f5">#F5F5F5
				<option style="BACKGROUND-COLOR: #dcdcdc">#DCDCDC
				<option style="BACKGROUND-COLOR: #d3d3d3">#D3D3D3
				<option style="BACKGROUND-COLOR: #c0c0c0">#C0C0C0
				<option style="BACKGROUND-COLOR: #a9a9a9">#A9A9A9
				<option style="BACKGROUND-COLOR: #808080">#808080
				<option style="BACKGROUND-COLOR: #696969">#696969
				<option style="BACKGROUND-COLOR: #000000">#000000
				<option style="BACKGROUND-COLOR: #2f4f4f">#2F4F4F
				<option style="BACKGROUND-COLOR: #708090">#708090
				<option style="BACKGROUND-COLOR: #778899">#778899
				<option style="BACKGROUND-COLOR: #4682b4">#4682B4
				<option style="BACKGROUND-COLOR: #4169e1">#4169E1
				<option style="BACKGROUND-COLOR: #6495ed">#6495ED
				<option style="BACKGROUND-COLOR: #b0c4de">#B0C4DE
				<option style="BACKGROUND-COLOR: #7b68ee">#7B68EE
				<option style="BACKGROUND-COLOR: #6a5acd">#6A5ACD
				<option style="BACKGROUND-COLOR: #483d8b">#483D8B
				<option style="BACKGROUND-COLOR: #191970">#191970
				<option style="BACKGROUND-COLOR: #000080">#000080
				<option style="BACKGROUND-COLOR: #00008b">#00008B
				<option style="BACKGROUND-COLOR: #0000cd">#0000CD
				<option style="BACKGROUND-COLOR: #1e90ff">#1E90FF
				<option style="BACKGROUND-COLOR: #00bfff">#00BFFF
				<option style="BACKGROUND-COLOR: #87cefa">#87CEFA
				<option style="BACKGROUND-COLOR: #87ceeb">#87CEEB
				<option style="BACKGROUND-COLOR: #add8e6">#ADD8E6
				<option style="BACKGROUND-COLOR: #b0e0e6">#B0E0E6
				<option style="BACKGROUND-COLOR: #f0ffff">#F0FFFF
				<option style="BACKGROUND-COLOR: #e0ffff">#E0FFFF
				<option style="BACKGROUND-COLOR: #afeeee">#AFEEEE
				<option style="BACKGROUND-COLOR: #00ced1">#00CED1
				<option style="BACKGROUND-COLOR: #5f9ea0">#5F9EA0
				<option style="BACKGROUND-COLOR: #48d1cc">#48D1CC
				<option style="BACKGROUND-COLOR: #00ffff">#00FFFF
				<option style="BACKGROUND-COLOR: #40e0d0">#40E0D0
				<option style="BACKGROUND-COLOR: #20b2aa">#20B2AA
				<option style="BACKGROUND-COLOR: #008b8b">#008B8B
				<option style="BACKGROUND-COLOR: #008080">#008080
				<option style="BACKGROUND-COLOR: #7fffd4">#7FFFD4
				<option style="BACKGROUND-COLOR: #66cdaa">#66CDAA
				<option style="BACKGROUND-COLOR: #8fbc8f">#8FBC8F
				<option style="BACKGROUND-COLOR: #3cb371">#3CB371
				<option style="BACKGROUND-COLOR: #2e8b57">#2E8B57
				<option style="BACKGROUND-COLOR: #006400">#006400
				<option style="BACKGROUND-COLOR: #008000">#008000
				<option style="BACKGROUND-COLOR: #228b22">#228B22
				<option style="BACKGROUND-COLOR: #32cd32">#32CD32
				<option style="BACKGROUND-COLOR: #00ff00">#00FF00
				<option style="BACKGROUND-COLOR: #7fff00">#7FFF00
				<option style="BACKGROUND-COLOR: #7cfc00">#7CFC00
				<option style="BACKGROUND-COLOR: #adff2f">#ADFF2F
				<option style="BACKGROUND-COLOR: #98fb98">#98FB98
				<option style="BACKGROUND-COLOR: #90ee90">#90EE90
				<option style="BACKGROUND-COLOR: #00ff7f">#00FF7F
				<option style="BACKGROUND-COLOR: #00fa9a">#00FA9A
				<option style="BACKGROUND-COLOR: #556b2f">#556B2F
				<option style="BACKGROUND-COLOR: #6b8e23">#6B8E23
				<option style="BACKGROUND-COLOR: #808000">#808000
				<option style="BACKGROUND-COLOR: #bdb76b">#BDB76B
				<option style="BACKGROUND-COLOR: #b8860b">#B8860B
				<option style="BACKGROUND-COLOR: #daa520">#DAA520
				<option style="BACKGROUND-COLOR: #ffd700">#FFD700
				<option style="BACKGROUND-COLOR: #f0e68c">#F0E68C
				<option style="BACKGROUND-COLOR: #eee8aa">#EEE8AA
				<option style="BACKGROUND-COLOR: #ffebcd">#FFEBCD
				<option style="BACKGROUND-COLOR: #ffe4b5">#FFE4B5
				<option style="BACKGROUND-COLOR: #f5deb3">#F5DEB3
				<option style="BACKGROUND-COLOR: #ffdead">#FFDEAD
				<option style="BACKGROUND-COLOR: #deb887">#DEB887
				<option style="BACKGROUND-COLOR: #d2b48c">#D2B48C
				<option style="BACKGROUND-COLOR: #bc8f8f">#BC8F8F
				<option style="BACKGROUND-COLOR: #a0522d">#A0522D
				<option style="BACKGROUND-COLOR: #8b4513">#8B4513
				<option style="BACKGROUND-COLOR: #d2691e">#D2691E
				<option style="BACKGROUND-COLOR: #cd853f">#CD853F
				<option style="BACKGROUND-COLOR: #f4a460">#F4A460
				<option style="BACKGROUND-COLOR: #8b0000">#8B0000
				<option style="BACKGROUND-COLOR: #800000">#800000
				<option style="BACKGROUND-COLOR: #a52a2a">#A52A2A
				<option style="BACKGROUND-COLOR: #b22222">#B22222
				<option style="BACKGROUND-COLOR: #cd5c5c">#CD5C5C
				<option style="BACKGROUND-COLOR: #f08080">#F08080
				<option style="BACKGROUND-COLOR: #fa8072">#FA8072
				<option style="BACKGROUND-COLOR: #e9967a">#E9967A
				<option style="BACKGROUND-COLOR: #ffa07a">#FFA07A
				<option style="BACKGROUND-COLOR: #ff7f50">#FF7F50
				<option style="BACKGROUND-COLOR: #ff6347">#FF6347
				<option style="BACKGROUND-COLOR: #ff8c00">#FF8C00
				<option style="BACKGROUND-COLOR: #ffa500">#FFA500
				<option style="BACKGROUND-COLOR: #ff4500">#FF4500
				<option style="BACKGROUND-COLOR: #dc143c">#DC143C
				<option style="BACKGROUND-COLOR: #ff0000">#FF0000
				<option style="BACKGROUND-COLOR: #ff1493">#FF1493
				<option style="BACKGROUND-COLOR: #ff00ff">#FF00FF
				<option style="BACKGROUND-COLOR: #ff69b4">#FF69B4
				<option style="BACKGROUND-COLOR: #ffb6c1">#FFB6C1
				<option style="BACKGROUND-COLOR: #ffc0cb">#FFC0CB
				<option style="BACKGROUND-COLOR: #db7093">#DB7093
				<option style="BACKGROUND-COLOR: #c71585">#C71585
				<option style="BACKGROUND-COLOR: #800080">#800080
				<option style="BACKGROUND-COLOR: #8b008b">#8B008B
				<option style="BACKGROUND-COLOR: #9370db">#9370DB
				<option style="BACKGROUND-COLOR: #8a2be2">#8A2BE2
				<option style="BACKGROUND-COLOR: #4b0082">#4B0082
				<option style="BACKGROUND-COLOR: #9400d3">#9400D3
				<option style="BACKGROUND-COLOR: #9932cc">#9932CC
				<option style="BACKGROUND-COLOR: #ba55d3">#BA55D3
				<option style="BACKGROUND-COLOR: #da70d6">#DA70D6
				<option style="BACKGROUND-COLOR: #ee82ee">#EE82EE
				<option style="BACKGROUND-COLOR: #dda0dd">#DDA0DD
				<option style="BACKGROUND-COLOR: #d8bfd8">#D8BFD8
				<option style="BACKGROUND-COLOR: #e6e6fa">#E6E6FA
				<option style="BACKGROUND-COLOR: #f8f8ff">#F8F8FF
				<option style="BACKGROUND-COLOR: #f0f8ff">#F0F8FF
				<option style="BACKGROUND-COLOR: #f5fffa">#F5FFFA
				<option style="BACKGROUND-COLOR: #f0fff0">#F0FFF0
				<option style="BACKGROUND-COLOR: #fafad2">#FAFAD2
				<option style="BACKGROUND-COLOR: #fffacd">#FFFACD
				<option style="BACKGROUND-COLOR: #fff8dc">#FFF8DC
				<option style="BACKGROUND-COLOR: #ffffe0">#FFFFE0
				<option style="BACKGROUND-COLOR: #fffff0">#FFFFF0
				<option style="BACKGROUND-COLOR: #fffaf0">#FFFAF0
				<option style="BACKGROUND-COLOR: #faf0e6">#FAF0E6
				<option style="BACKGROUND-COLOR: #fdf5e6">#FDF5E6
				<option style="BACKGROUND-COLOR: #faebd7">#FAEBD7
				<option style="BACKGROUND-COLOR: #ffe4c4">#FFE4C4
				<option style="BACKGROUND-COLOR: #ffdab9">#FFDAB9
				<option style="BACKGROUND-COLOR: #ffefd5">#FFEFD5
				<option style="BACKGROUND-COLOR: #fff5ee">#FFF5EE
				<option style="BACKGROUND-COLOR: #fff0f5">#FFF0F5
				<option style="BACKGROUND-COLOR: #ffe4e1">#FFE4E1
				<option style="BACKGROUND-COLOR: #fffafa">#FFFAFA</option>
				</select>
			</td>
		  </tr>
		  <tr>
			<td class="body">[sTxtLinkColor]:</td>
			<td class="body">
			  <select class=text70 name=linkcolor>
				<script>printLinkColor()</script>
				<option style="BACKGROUND-COLOR: #ff0000">#FF0000
				<option style="BACKGROUND-COLOR: #ffff00">#FFFF00
				<option style="BACKGROUND-COLOR: #00ff00">#00FF00
				<option style="BACKGROUND-COLOR: #00ffff">#00FFFF
				<option style="BACKGROUND-COLOR: #0000ff">#0000FF
				<option style="BACKGROUND-COLOR: #ff00ff">#FF00FF
				<option style="BACKGROUND-COLOR: #ffffff">#FFFFFF
				<option style="BACKGROUND-COLOR: #f5f5f5">#F5F5F5
				<option style="BACKGROUND-COLOR: #dcdcdc">#DCDCDC
				<option style="BACKGROUND-COLOR: #d3d3d3">#D3D3D3
				<option style="BACKGROUND-COLOR: #c0c0c0">#C0C0C0
				<option style="BACKGROUND-COLOR: #a9a9a9">#A9A9A9
				<option style="BACKGROUND-COLOR: #808080">#808080
				<option style="BACKGROUND-COLOR: #696969">#696969
				<option style="BACKGROUND-COLOR: #000000">#000000
				<option style="BACKGROUND-COLOR: #2f4f4f">#2F4F4F
				<option style="BACKGROUND-COLOR: #708090">#708090
				<option style="BACKGROUND-COLOR: #778899">#778899
				<option style="BACKGROUND-COLOR: #4682b4">#4682B4
				<option style="BACKGROUND-COLOR: #4169e1">#4169E1
				<option style="BACKGROUND-COLOR: #6495ed">#6495ED
				<option style="BACKGROUND-COLOR: #b0c4de">#B0C4DE
				<option style="BACKGROUND-COLOR: #7b68ee">#7B68EE
				<option style="BACKGROUND-COLOR: #6a5acd">#6A5ACD
				<option style="BACKGROUND-COLOR: #483d8b">#483D8B
				<option style="BACKGROUND-COLOR: #191970">#191970
				<option style="BACKGROUND-COLOR: #000080">#000080
				<option style="BACKGROUND-COLOR: #00008b">#00008B
				<option style="BACKGROUND-COLOR: #0000cd">#0000CD
				<option style="BACKGROUND-COLOR: #1e90ff">#1E90FF
				<option style="BACKGROUND-COLOR: #00bfff">#00BFFF
				<option style="BACKGROUND-COLOR: #87cefa">#87CEFA
				<option style="BACKGROUND-COLOR: #87ceeb">#87CEEB
				<option style="BACKGROUND-COLOR: #add8e6">#ADD8E6
				<option style="BACKGROUND-COLOR: #b0e0e6">#B0E0E6
				<option style="BACKGROUND-COLOR: #f0ffff">#F0FFFF
				<option style="BACKGROUND-COLOR: #e0ffff">#E0FFFF
				<option style="BACKGROUND-COLOR: #afeeee">#AFEEEE
				<option style="BACKGROUND-COLOR: #00ced1">#00CED1
				<option style="BACKGROUND-COLOR: #5f9ea0">#5F9EA0
				<option style="BACKGROUND-COLOR: #48d1cc">#48D1CC
				<option style="BACKGROUND-COLOR: #00ffff">#00FFFF
				<option style="BACKGROUND-COLOR: #40e0d0">#40E0D0
				<option style="BACKGROUND-COLOR: #20b2aa">#20B2AA
				<option style="BACKGROUND-COLOR: #008b8b">#008B8B
				<option style="BACKGROUND-COLOR: #008080">#008080
				<option style="BACKGROUND-COLOR: #7fffd4">#7FFFD4
				<option style="BACKGROUND-COLOR: #66cdaa">#66CDAA
				<option style="BACKGROUND-COLOR: #8fbc8f">#8FBC8F
				<option style="BACKGROUND-COLOR: #3cb371">#3CB371
				<option style="BACKGROUND-COLOR: #2e8b57">#2E8B57
				<option style="BACKGROUND-COLOR: #006400">#006400
				<option style="BACKGROUND-COLOR: #008000">#008000
				<option style="BACKGROUND-COLOR: #228b22">#228B22
				<option style="BACKGROUND-COLOR: #32cd32">#32CD32
				<option style="BACKGROUND-COLOR: #00ff00">#00FF00
				<option style="BACKGROUND-COLOR: #7fff00">#7FFF00
				<option style="BACKGROUND-COLOR: #7cfc00">#7CFC00
				<option style="BACKGROUND-COLOR: #adff2f">#ADFF2F
				<option style="BACKGROUND-COLOR: #98fb98">#98FB98
				<option style="BACKGROUND-COLOR: #90ee90">#90EE90
				<option style="BACKGROUND-COLOR: #00ff7f">#00FF7F
				<option style="BACKGROUND-COLOR: #00fa9a">#00FA9A
				<option style="BACKGROUND-COLOR: #556b2f">#556B2F
				<option style="BACKGROUND-COLOR: #6b8e23">#6B8E23
				<option style="BACKGROUND-COLOR: #808000">#808000
				<option style="BACKGROUND-COLOR: #bdb76b">#BDB76B
				<option style="BACKGROUND-COLOR: #b8860b">#B8860B
				<option style="BACKGROUND-COLOR: #daa520">#DAA520
				<option style="BACKGROUND-COLOR: #ffd700">#FFD700
				<option style="BACKGROUND-COLOR: #f0e68c">#F0E68C
				<option style="BACKGROUND-COLOR: #eee8aa">#EEE8AA
				<option style="BACKGROUND-COLOR: #ffebcd">#FFEBCD
				<option style="BACKGROUND-COLOR: #ffe4b5">#FFE4B5
				<option style="BACKGROUND-COLOR: #f5deb3">#F5DEB3
				<option style="BACKGROUND-COLOR: #ffdead">#FFDEAD
				<option style="BACKGROUND-COLOR: #deb887">#DEB887
				<option style="BACKGROUND-COLOR: #d2b48c">#D2B48C
				<option style="BACKGROUND-COLOR: #bc8f8f">#BC8F8F
				<option style="BACKGROUND-COLOR: #a0522d">#A0522D
				<option style="BACKGROUND-COLOR: #8b4513">#8B4513
				<option style="BACKGROUND-COLOR: #d2691e">#D2691E
				<option style="BACKGROUND-COLOR: #cd853f">#CD853F
				<option style="BACKGROUND-COLOR: #f4a460">#F4A460
				<option style="BACKGROUND-COLOR: #8b0000">#8B0000
				<option style="BACKGROUND-COLOR: #800000">#800000
				<option style="BACKGROUND-COLOR: #a52a2a">#A52A2A
				<option style="BACKGROUND-COLOR: #b22222">#B22222
				<option style="BACKGROUND-COLOR: #cd5c5c">#CD5C5C
				<option style="BACKGROUND-COLOR: #f08080">#F08080
				<option style="BACKGROUND-COLOR: #fa8072">#FA8072
				<option style="BACKGROUND-COLOR: #e9967a">#E9967A
				<option style="BACKGROUND-COLOR: #ffa07a">#FFA07A
				<option style="BACKGROUND-COLOR: #ff7f50">#FF7F50
				<option style="BACKGROUND-COLOR: #ff6347">#FF6347
				<option style="BACKGROUND-COLOR: #ff8c00">#FF8C00
				<option style="BACKGROUND-COLOR: #ffa500">#FFA500
				<option style="BACKGROUND-COLOR: #ff4500">#FF4500
				<option style="BACKGROUND-COLOR: #dc143c">#DC143C
				<option style="BACKGROUND-COLOR: #ff0000">#FF0000
				<option style="BACKGROUND-COLOR: #ff1493">#FF1493
				<option style="BACKGROUND-COLOR: #ff00ff">#FF00FF
				<option style="BACKGROUND-COLOR: #ff69b4">#FF69B4
				<option style="BACKGROUND-COLOR: #ffb6c1">#FFB6C1
				<option style="BACKGROUND-COLOR: #ffc0cb">#FFC0CB
				<option style="BACKGROUND-COLOR: #db7093">#DB7093
				<option style="BACKGROUND-COLOR: #c71585">#C71585
				<option style="BACKGROUND-COLOR: #800080">#800080
				<option style="BACKGROUND-COLOR: #8b008b">#8B008B
				<option style="BACKGROUND-COLOR: #9370db">#9370DB
				<option style="BACKGROUND-COLOR: #8a2be2">#8A2BE2
				<option style="BACKGROUND-COLOR: #4b0082">#4B0082
				<option style="BACKGROUND-COLOR: #9400d3">#9400D3
				<option style="BACKGROUND-COLOR: #9932cc">#9932CC
				<option style="BACKGROUND-COLOR: #ba55d3">#BA55D3
				<option style="BACKGROUND-COLOR: #da70d6">#DA70D6
				<option style="BACKGROUND-COLOR: #ee82ee">#EE82EE
				<option style="BACKGROUND-COLOR: #dda0dd">#DDA0DD
				<option style="BACKGROUND-COLOR: #d8bfd8">#D8BFD8
				<option style="BACKGROUND-COLOR: #e6e6fa">#E6E6FA
				<option style="BACKGROUND-COLOR: #f8f8ff">#F8F8FF
				<option style="BACKGROUND-COLOR: #f0f8ff">#F0F8FF
				<option style="BACKGROUND-COLOR: #f5fffa">#F5FFFA
				<option style="BACKGROUND-COLOR: #f0fff0">#F0FFF0
				<option style="BACKGROUND-COLOR: #fafad2">#FAFAD2
				<option style="BACKGROUND-COLOR: #fffacd">#FFFACD
				<option style="BACKGROUND-COLOR: #fff8dc">#FFF8DC
				<option style="BACKGROUND-COLOR: #ffffe0">#FFFFE0
				<option style="BACKGROUND-COLOR: #fffff0">#FFFFF0
				<option style="BACKGROUND-COLOR: #fffaf0">#FFFAF0
				<option style="BACKGROUND-COLOR: #faf0e6">#FAF0E6
				<option style="BACKGROUND-COLOR: #fdf5e6">#FDF5E6
				<option style="BACKGROUND-COLOR: #faebd7">#FAEBD7
				<option style="BACKGROUND-COLOR: #ffe4c4">#FFE4C4
				<option style="BACKGROUND-COLOR: #ffdab9">#FFDAB9
				<option style="BACKGROUND-COLOR: #ffefd5">#FFEFD5
				<option style="BACKGROUND-COLOR: #fff5ee">#FFF5EE
				<option style="BACKGROUND-COLOR: #fff0f5">#FFF0F5
				<option style="BACKGROUND-COLOR: #ffe4e1">#FFE4E1
				<option style="BACKGROUND-COLOR: #fffafa">#FFFAFA</option>
			  </select>
			</td>
		  </tr>
	    </table>
	</td>
  </tr>
  <tr>
	<td colspan="2"><img src="ew/ew_images/1x1.gif" width="1" height="10"></td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td>
	    <input type="button" name="modifyPage" value="[sTxtPageProps]" class="Text120" onClick="javascript:doModify();">
	<input type="button" name="Submit" value="[sTxtCancel]" class="Text50" onClick="javascript:window.close()">
	</td>
  </tr>
</table>
</form>
