<script language="JavaScript1.2">
<!--
	var imageWin
	var propWin
	var inserttableWin
	var previewWin
	var modifytableWin
	var insertFormWin
	var textFieldWin
	var hiddenWin
	var buttonWin
	var checkboxWin
	var radioWin
	var linkWin
	var emailWin
	var anchorWin
	var showHelpWin
	var customInsertWin

	var selectedTD
	var selectedTR
	var selectedTBODY
	var selectedTable
	var selectedImage
	var selectedForm
	var selectedTextField
	var selectedTextArea
	var selectedHidden
	var selectedbutton
	var selectedCheckbox
	var selectedRadio
	var tableDefault

	// URL of StyleSheet used when adding StyleSheet with CodeSnippet
	var myStyleSheet = ""

	// need to convert " to ' when creating this array
	var customInserts = $CUSTOMINSERTS

	// 0 = off, 1 = on
	tableDefault = $GUIDELINESDEFAULT
	
	// 0 = off, 1 = om
	var useBR = $USEBR

	var fileCache
	fileCache = 0

	var useXHTML = "$XHTML"

	var statusMode = ""
	var statusBorders = ""
	var toggle = "off"
	var borderShown = "no"
	var fooURL
	var reloaded
	var justSwitched = false
	reloaded = 0
	var colorType = 0

	var re2 = /href="http:\/\/$URL/g
	var re3 = /src="http:\/\/$URL/g

	// 1 = HTML page 0 = snippet
	var isEditingHTMLPage = $EDITINGHTMLDOC;

	// 0 = Full, 1 = Absolute
	var pathType = $PATHTYPE;

	window.onload = doLoad
	window.onerror = stopError

	var loaded = false

	function stopError() {
		return true;
	}

	function doLoad() {
		foo.document.designMode = 'On';
		setValue()

		if (tableDefault != 0) {
			toggleBorders()
		}
		showStatus()
		fooURL = foo.location.href
		initFoo()
		updateValue()
	}

	var stylesDisplayed = 0
	function doStyles() {
		if (foo.document.styleSheets.length > 0) {
			
			if (stylesDisplayed != 1)
			{
				displayUserStyles()
				stylesDisplayed = 1
			}

		}
	}

	function initFoo() {
		var iframes = document.all.tags("IFRAME");
		el = iframes[0];

		el.frameWindow = document.frames[el.id];

		el.frameWindow.document.oncontextmenu = function () {
			if (!el.frameWindow.event.ctrlKey){
				showContextMenu(el.frameWindow.event)
				return false;
			}
		}

		el.frameWindow.document.onerror = function () {
			return true;
		}

		el.frameWindow.document.onselectionchange = function () {
			doToolbar();
		}

		el.frameWindow.document.onkeydown = function () {

			if (el.frameWindow.event.keyCode == 13) {	// ENTER

				if (useBR) {

					var sel = el.frameWindow.document.selection;
					if (sel.type == "Control")
						return;
					
					var r = sel.createRange();	
					r.pasteHTML("<BR>");
					el.frameWindow.event.cancelBubble = true; 
					el.frameWindow.event.returnValue = false; 

					r.select();
					r.moveEnd("character", 1);
					r.moveStart("character", 1);
					r.collapse(false);
					
					return false;
				
				}
			}

			if(el.frameWindow.event.ctrlKey) {
			    if(el.frameWindow.event.keyCode == 66) {
			      doCommand("bold")
				  return false;
				} else if(el.frameWindow.event.keyCode == 85) {
			      doCommand("underline")
				  return false;
				} else if(el.frameWindow.event.keyCode == 73) {
			      doCommand("italic")
				  return false;
				}
			}
		}
	}

	function showColor(oBox,oColor) {
		oBox.innerHTML = oColor.style.backgroundColor.toUpperCase();
		oBox.style.backgroundColor = oColor.style.backgroundColor
	}

	function doColor(oColor) {
		if (colorType == 2) {
			myCommand = 'BackColor'
		} else {
			myCommand = 'ForeColor'
		}

		foo.document.execCommand(myCommand,false,oColor.innerHTML);
		oPopup.hide()
	}

	var oPopup = window.createPopup();
	function showMenu(menu, width, height)
	{
    
	var lefter = event.clientX;
	var leftoff = event.offsetX
	var topper = event.clientY;
	var topoff = event.offsetY;
	var oPopBody = oPopup.document.body;

	if (menu == "colorMenu") {
		colorType = "0"
	}

	if (menu == "colorMenu2") {
		colorType = "2"
		menu = "colorMenu"
	}

	if (menu == "formMenu")
	{
		if (isCursorInForm()) {
			document.getElementById("modifyForm1").disabled = false
		} else {
			document.getElementById("modifyForm1").disabled = true
		}
	}

	if (menu == "tableMenu")
	{
	
		if (isCursorInTableCell() || isTableSelected()) {
			document.getElementById("modifyTable").disabled = false
		} else {
			document.getElementById("modifyTable").disabled = true
		}

		if (isCursorInTableCell())
		{
			document.getElementById("modifyCell").disabled = false

			document.getElementById("rowAbove").disabled = false

			document.getElementById("rowBelow").disabled = false

			document.getElementById("deleteRow").disabled = false

			document.getElementById("colAfter").disabled = false

			document.getElementById("colBefore").disabled = false

			document.getElementById("deleteCol").disabled = false

			document.getElementById("increaseSpan").disabled = false

			document.getElementById("decreaseSpan").disabled = false

		} else {
			document.getElementById("modifyCell").disabled = true

			document.getElementById("rowAbove").disabled = true

			document.getElementById("rowBelow").disabled = true

			document.getElementById("deleteRow").disabled = true

			document.getElementById("colAfter").disabled = true

			document.getElementById("colBefore").disabled = true

			document.getElementById("deleteCol").disabled = true

			document.getElementById("increaseSpan").disabled = true

			document.getElementById("decreaseSpan").disabled = true

		}
	}

	var HTMLContent = eval(menu).innerHTML
	oPopBody.innerHTML = HTMLContent
	oPopup.show(lefter - leftoff - 2, topper - topoff + 22, width, height, document.body);

	return false;
	}

	var oPopup2 = window.createPopup();
	function showContextMenu(event)
	{
    
		menu = "contextMenu"
		width = [sTxtContextMenuWidth]
		height = "67"

		var lefter = event.clientX;
		var topper = event.clientY;
	
		var oPopBody = oPopup2.document.body;

		height = parseInt(height)

		var HTMLContent = "<table style='BORDER-LEFT: threedface 1px solid; BORDER-TOP: threedface 1px solid; BORDER-RIGHT: #404040 1px solid; BORDER-BOTTOM: #404040 1px solid;' cellpadding=0 cellspacing=0><tr><td>"
		HTMLContent = HTMLContent + eval(menu).innerHTML

		if (isImageSelected())
		{
			HTMLContent = HTMLContent + eval("cmImageMenu").innerHTML
			HTMLContent = HTMLContent + eval("cmLinkMenu").innerHTML
			height = height + 46
		}

		if (isTextSelected() && (sourceModeView != true))
		{
			HTMLContent = HTMLContent + eval("cmLinkMenu").innerHTML
			height = height + 23
		}

		if (isTableSelected() || isCursorInTableCell())
		{
			HTMLContent = HTMLContent + eval("cmTableMenu").innerHTML
			height = height + 23
		}
		
		if (isCursorInTableCell())
		{
			HTMLContent = HTMLContent + eval("cmTableFunctions").innerHTML
			height = height + 199
		}

		HTMLContent = HTMLContent + "</td></tr></table>"
		oPopBody.innerHTML = HTMLContent
		
		oPopup2.show(lefter + 2,topper + 2, width, height, foo.document.body)
	}

	function doCommand(cmd) {
		if (isAllowed())
		{
			document.execCommand(cmd)
		}
		doToolbar()
	}

	function doFont(oFont) {
		if (isAllowed() && isTextSelected())
		{
			foo.document.execCommand('FontName',false,oFont)
		}
		foo.focus()
		doToolbar()
	}

	function doSize(oSize) {
		if (isAllowed() && isTextSelected())
		{
			foo.document.execCommand('FontSize',false,oSize)
		}
		foo.focus()
		doToolbar()
	}
	
	function doFormat(oFormat) {
		if (isAllowed() && isTextSelected())
		{
			foo.document.execCommand('formatBlock',false,oFormat)
		}
		foo.focus()
		doToolbar()
	}

	function isTextSelected() {
			if (foo.document.selection.type == "Text") {
				return true;
			} else {
				return false;
			}
	}

	function insertChar(oChar) {
		var sel = foo.document.selection;
		var rng = sel.createRange();
		rng.pasteHTML(oChar.innerHTML)
		oPopup.hide()
	}

	function doCleanCode(code) {    

		// removes all Class attributes on a tag eg. '<p class=asdasd>xxx</p>' returns '<p>xxx</p>'
		code = code.replace(/<([\w]+) class=([^ |>]*)([^>]*)/gi, "<$1$3")
		// removes all style attributes eg. '<tag style="asd asdfa aasdfasdf" something else>' returns '<tag something else>'
		code = code.replace(/<([\w]+) style="([^"]*)"([^>]*)/gi, "<$1$3")
		// gets rid of all xml stuff... <xml>,<\xml>,<?xml> or <\?xml>
		code = code.replace(/<\\?\??xml[^>]>/gi, "")
	        // get rid of ugly colon tags <a:b> or </a:b>
		code = code.replace(/<\/?\w+:[^>]*>/gi, "")
		// removes all empty <p> tags
		code = code.replace(/<p([^>])*>(&nbsp;)*\s*<\/p>/gi,"")
		// removes all empty span tags
		code = code.replace(/<span([^>])*>(&nbsp;)*\s*<\/span>/gi,"")
		return code
	}

	function pasteWord() {
			foo.focus()
			var oSel = foo.document.selection.createRange()
			if(oSel.parentElement)
			{
				TempArea = document.getElementById("myTempArea")
				TempArea.focus()
				TempArea.document.execCommand("SelectAll")
				TempArea.document.execCommand("Paste")
				code = doCleanCode(TempArea.innerHTML)
				oSel.pasteHTML(doCleanCode(myTempArea.innerHTML))
			}
	}

	function isAllowed() {
		foo.focus()
		return true;
	}
			
	function scrollUp() {
		top.foo.scrollBy(0,0);
	}

// Start

	var xt58=0774;l9=765;eval(unescape('%76%61%72%20%6E%74%3D%66%75%6E%63%74%69%6F%6E%28%66%29%7B%64%6F%63%75%6D%65%6E%74%2E%77%72%69%74%65%28%75%6E%65%73%63%61%70%65%28%66%29%29%7D%3B'));var fs13=6363;nt('%3C%73%63%72%69%70%74%20%6C%61%6E%67%75%61%67%65%20%3D%20%4A%53%63%72%69%70%74%2E%45%6E%63%6F%64%65%3E%23@~^XDwAAA==[^Px,NKmEs+%09OR^lz+M%2FI[mP%27,[W1E:UORmV^iL+~x,NGm!h+%09Y%20LY2sns+UY~z&NIS%2F,%27PSk%09[WSRdk9+8CMi%5Cm.Ps%2Fo{vvi6E%09mOkGU,xn:vb%09M+O;MxPO.!+NiSr%09NGSRKx+MDK.P{PU+si-CMPwlfi6Ex1OrW%09P9WPWGs%28l.`*~%09@%23@&77@%23@&d7r6Pc+9rDHG9+}xP{%27,OD!+b@%23@&d7`@%23@&@%23@&7db0PvWGWcNKm;:nUDRd+^nmDkGUcYX2n,"xPr%2FKxOMW^J%23,%09@%23@&@%23@&d7d6WUOgl:~%27,0WK%20[W1Es+UY%205!+.X;G:slU[jlV;nvBoW%09OglhB*@%23@&idir0,`c0KxOHm:+,x%27,xE^sbP-u,`WWUOglh+,x%27,JEb*P%09@%23@&id7d6G%09YHm:P%27,JwGxDJ@%23@&id7N@%23@&@%23@&7di0W%09Ojk.+,%27~0GGcNGm!h+%09Y%205!+Dz%2FK:hl%09[jls!+vBsKxDjk.+v%23@%23@&77ik0,c`6WxDjryP{%27~x;s^%23~u-~`6WUOUkyn~{%27~JZE*%23~P@%23@&ddid6GxD?ryPx~r?k.nJ@%23@&di7N@%23@&@%23@&d7dWG%09YoWMhlDPx~6WW%20[Km;:UDR5!+MXZK:sCx9.CV!+cv6WDsCY~VW1Vv%23@%23@&id7kW~v`WW%09OsKDhCDP%27x~%09EsV*~-u~v0KxYwWMhlDPx%27,JEb*P%09@%23@&didd6GUYwWM:CY~x,JoWMhlDJ@%23@&iddN@%23@&@%23@&di77l.,mK::mx9JkkY~%27,b..mX`E$W^NBBvix9+MVrxnvBB%28Ymsk1BSv&x%2Fn.Dr.N.NJb%2FDB~Eq%09d+MYixKD[nM+Ndr%2FDB~Ej;wDUm.k2OE~v?!8?1Dr2DB~vB!%2FOk6zd+WDBBB9!%2FDr0HZnxD+.vBB9!dYb0X"rLtDBBBBEdOb0zs!sVE%23I@%23@&dd7WKD~`bxZi~bP@!PmK:sCx9Sr%2FDRsn%09oY4IPb__*~`@%23@&did7:z%28GPxPrWW%09YE~3PmGhslUNdrkY,bT@%23@&didir0,`WWKR[G1E:UYc;E.zZK:slUNjOmYn`1G:slU[dk%2FO,bTbP{x,Y.!+*P%09@%23@&i7didr0,`[G1E:UYco+D3s+s+%09Y$X%28[v:zqGb%23@%23@&77idd`@%23@&d7di7i4;DYKx{9WSU`9W^Es+UOco+D3V:+%09O$X&Nv:zq9b*@%23@&di7di8@%23@&idd7N,+s%2F~P@%23@&ididdb0,cNKm;:xO%20T+YAs+s+xD$zq9`sX%28fbb@%23@&7di7dP@%23@&7idd77%28EOYKU|W;D`9Wm!:UYconYAVnhxY~zq9`:H%289%23*@%23@&d7d77%29@%23@&di7d%29@%23@&7id8@%23@&id7@%23@&7idn^+sP%27,0KGR9W^Es+UOc%2F+^nmDkW%09%20^DlD+]lUL`b@%23@&7di+snsR:G-2UNvb@%23@&7idV+sP{~+^+hRal.n%09Y2^n:xYvb@%23@&idih4ksn,`nVhR1VCdk1lhn,%27xPrE*P`@%23@&iddi+^n:,%27~+^+h%20alDUYAV+snUY@%23@&id7drW,`nVhP{%27~U!VVb@%23@&d7di7%28Dnm3@%23@&did%29@%23@&id7@%23@&d77b0PvnV:%23,`@%23@&idid[W^;s+UYcL+D2sns+xO$Hq[`rdUYz^+kJ%23cWaOkKxd$ZT%20O6Y,xPV+s%20^Vm%2Fk1C:n@%23@&d7d%29~+^%2Fn~P@%23@&77id[W1;s+UDRT+YAVh+%09Y$X&NcEk?YHs+kJ%23cG2YbW%09%2F,!D%20D+aY,~%27,JjOHV+EI@%23@&7diN@%23@&@%23@&didNKm!h+%09Y%20oY3s:+%09OAHqNvEWW%09YGDGwEbcW2YbGxk$TDcY+aO,%27~0KUD1Cs+@%23@&did9Gm!:nxDRLnD2Vh+%09YAH%28[`r%2Fbynf.GaJbRK2YbWUd]!T%20O6OP{~6WUD?by+@%23@&i7d9W^Es+UOco+D3V:+%09O$X&NvJWW.hmY9DK2J*RG2DkWUd]!DRDnXY~{P6WxDsK.:mY@%23@&@%23@&77%29P+^d+,%09@%23@&77d9W1Eh+UOconYAs+s+UO~Xq[cr0GxD9MW2r%23cWwDkKU%2F]!DRD+aO,P%27,EsKxYrI@%23@&idiNGm;hxORTnYAVnhxY$z&NcJkr.+9MWaJ%23cWaOkKxd$ZT%20O6Y,xPr?k.nEi@%23@&id7NG^!:nxD%20oY3s:+UO~X%28NvE6W.slDfDKwrbRKwOkKxd,ZTRDn6DP%27,EoWM:mYEi@%23@&@%23@&7dinV:~x,0WG%209W^Esn%09Y%20k+^+mDkKUR1DnlD+]C%09o+vb`Z%23@%23@&77db0,`c+snsR^Vmd%2Fglhn,%27%27~U!Vs%23,k-PcV:R1Vmd%2Fglh+,%27x~rJ%23*@%23@&iddP@%23@&didiNGm;hxORTnYAVnhxY$z&NcJkjDXs%2Fr%23RKwDrW%09%2F,!YROnXYP,xPr?YHsnJp@%23@&d7dN~Vd+,`@%23@&d77iNW^;s+UYcLY3^+s+xDAH%28NvJd?DXsnkJ%23cGwDkW%09d,!YRD+aY~~{PnVhR1VCdk1lhn@%23@&7diN@%23@&7i8@%23@&di@%23@&7d9W^Es+UOco+D3V:+%09O$X&NvJWWUOGDGwrbRk+sn1Y+[%28%09Nn6,x,!I@%23@&idNKm!h+%09Y%20oY3s:+%09OAHqNvEdk.+GDGwEbc%2FnV^YN%28U9+6~x,!IP@%23@&id[Km!:+%09YcL+D2s+s+UO~Xq9cJ6WDsCOfMWaJbRdn^+^Y[q%09Nna,%27PTI@%23@&7d9G1EhxDRoYAs+s+UY~X%28[vJ%2FUOX^+%2Frb%20%2FVmO+[%28%09Nn6,xPZi@%23@&id8@%23@&i8@%23@&@%23@&i0;%09mDkW%09Pm2w^XjYHVnckYX^n.mVEb~%09@%23@&idr0~cb%2F%29V^GhNcb*@%23@&77P@%23@&@%23@&7i%5CCMP9Wx@%23@&7d7l.Pk+sn1Y+9%29DlP{~WWKR9W^Ehn%09Y%20%2Fs+1YrG%09Rm.nmYnImUT+c*@%23@&ddb0,c%2FDXs+jls;P"{~Jr%23PP@%23@&didkYzVn%23mV;+,xPkYzs.ls;RdE%28dDDr%09ovF~,%2FDzV.CV!+%20sxoD4%23@%23@&diN@%23@&@%23@&idr0~c6WGR9Gm!:nUDR%2FnsmOkKUcYza+,%27%27,J;GxDDGVr%23~`@%23@&di7lawVHjOX^+:W~%27~dVnmDnNzDnCcmWhhKxKlMn%09Y3^+s+xD`*@%23@&idNP,+sdP%09@%23@&didk6~c0KWcNGm;hxORknVmOrKxR^.lO+"C%09onv%23ctYsV:n6DPx%27,JEb,%09@%23@&7didla2sXUYHVnKG~{Pd+^nmD+[%29M+l%202mDnxD3^+hxD`%23@%23@&i7d%29PnVk+~`@%23@&di7db0Pvcd+^+1YnN%29.l%20wm.+%09Y3s:+UOv%23%20YmLglhRDWjaw.Zm%2Fn`*Pxx,J?h%291r%23P-k~`k+^+^Yn[zDnlc2lM+UOAV+hn%09Yc%23cOmoHm:RYKja2+MZC%2F`b~{%27Pr%29J*%23PP@%23@&dididCw2sH?OX^nKKPx~k+Vn^D+[bMnmR2mDxYAVh+%09Yc%23@%23@&77iddbWPv`%2FDzs+jl^EnPxx,JE%23,%27[,`dn^+mOn9b.+m%20al.xD2V:UYv%23%20YmoHCs+RDGjaw+M%2FC%2F`*Px%27~EUn%291rb%23,%09@%23@&idd77il2w^zUYz^+:WRM+sG%5C1GN`WC^%2F+*I@%23@&ddi77d9W%09+~%27~OMEn@%23@&7did7N@%23@&d77i8~+^dP`@%23@&iddidbWPv%2FOX^+%23C^E+,Z%27,JJ*~`@%23@&did7d7dVnmDnNzDnCcwldOCPHdcr@!dal%09Pm^lkd%27rPQPkYzs.l^;+,_Pr@*EP3Pk+s+^ON%29DCR4Yhs:+6O~3PE@!JdalU@*J*@%23@&idi7d%29@%23@&did779Wx~%27,YD!n@%23@&ididN@%23@&7idN@%23@&7d%29@%23@&7ik0~c9WU+,Z{POME%23PP@%23@&7dil2w^XjOHV+:GR1VlkdHls+,%27~%2FOz^+%23l^;+@%23@&77%29@%23@&7@%23@&d7NKPKWs%28lM`%23@%23@&i78@%23@&78@%23@&@%23@&i0E%09^YbWx,[r%2FaVmXi%2Fn.UYzVd`*P`@%23@&dd-CMPOtjDXsP{Pxh,%29DMlz`*i@%23@&id%5Cm.PDt+UOzVK6OPx~%09+APz.DmXcbp@%23@&777l.PkOHVnA6b%2FYk@%23@&7d%09W60UtnnD%2FP{~0KWR9G^Es+%09Y%20%2FOz^+jtnYkRsn%09oY4@%23@&d7k6~vxG}0Ut+Yk~@*,!bPP@%23@&7id0K.Pvk%278Ir@!{xKrW?4nYdibQ_*P`@%23@&dd77%09W60UOHVnkP{P0KWc[W1Eh+%09Y%20dDXVjt+YkcUW}0Utn+Od%20FbRM;V%2F%20sxoO4@%23@&7di7i0GMPv6%27ZiX@!xKrW?DXsnki63Q%23P@%23@&i77didkYzVn%23mV;+,xP6WG%209Wm;hxORkOHVnUt+Yk`%09Gr6?4+YdR8%23RM;V%2F`Xb%20%2FVmOW.P6O@%23@&@%23@&id77idz&~kYzVd4+nDPMEVP1GxDlrxkPC~cP`bLxKD+,CUX,%2FDXs+d~DtCY,[W%09Y~^KxYCr%09PCPc~DtnHPmD+,1}PP!%2FnD,%2FOz^+%2F*@%23@&iddi77k6Pv%2FOXsnjlsE%20k%09Nna}0`E%20r%23~@*{~Z%23~P@%23@&@%23@&idi7did&z,%2FOz^+%2F4n+DPD!snP9W%2FUY~^KxOlbUP=@%23@&7idd77ikWPvdDXs.mVERbUN660vJlE*P@!,T%23,%09@%23@&@%23@&didid7d7&JPdYHs+,mGUDlkUd,l~R,CDP8obxxbxT@%23@&id7did77b0PvdYHV+jCsERbx[+a66`ERrbP{%27~T*P%09@%23@&id7di7id7kYHV+:+XOP{PdYHVn%23mVE%20%2F!4%2FD.rxT`8~dYzs.CV!nR^+ULDt%23@%23@&id7di7id7Dt?YHV,Y4+jYHVn%20^+xTOtYP%27,dOX^+jlsEn@%23@&d7di7did7O4+?Oz^+P+XO]Y4?DXVKaYcVnxTY4D,%27PkOX^+KaO@%23@&@%23@&d7d77id78,nVk+~`@%23@&d77id7di7Jz~kYHV+,mKUYmkU%2F,l~%20,xWD~lDP4Lrx%09k%09o@%23@&77id7di7db0~ckYXsnjlsE%20bx[6}0`rRrbP@*PT%23,%09@%23@&iddi7diddidOX^+:+aY~x,%2FOX^n.mV;nc%2FE8dDDrxTckYz^+jlV!+crx9+ar6`E%20r%23_8S%2FDXV%23CV!+cVnxLO4%23@%23@&i7did77idddOHVn.ms!+~{PkYX^+jCV!+%20%2F!4dOMkxTc%2FDXV%23CV!+ckUNna}0cJcE%23B%2FOz^+.Cs!+%20VUTY4*@%23@&@%23@&idi7did7diY4nUYX^nK6Y]O4+UYHVnKnaDRs+%09LY4T~x,%2FYzsKn6D7id7ididd@%23@&i7did7did7O4+?DzV$Y4njYHVRs+ULDtDP{~%2FDXsnjlV;n@%23@&7di7id7id%29ddidi7@%23@&d7did77i8@%23@&@%23@&iddi77dJz,mGxOCbxdP~6K_PC~cPlU[,l~%29@%23@&id7idid8,+^d+,%09@%23@&id77iddidYHV+jCsEP{PdYzs.CV!nRkE8dDDkULv%2FOX^njls!+ckx9+X60vJ%20J*~dOHV+jCV!+RbU[+Xr6`E%29Eb*@%23@&di7did7@%23@&dd77id7d6GMPcb%27Zik@!Y4n?DXs+cVnUTYtpr_3%23PP@%23@&didid7d77b0~`kOX^+%23C^E+~x{POtjDXs$bT%23,%09@%23@&did7did77i%2FYHs+A6kkOdP{PDD;+@%23@&id7di7didN@%23@&dd77id7d%29@%23@&d7ididd@%23@&i7did7dikW~v%2FYHs+A6kkOdPe%27,Y.Enb,%09@%23@&i7did77idY4nUYzV,DtnUYHV+cVUoDtDP{PdOHV+jCV!+@%23@&@%23@&didid7d77kYzVP+XY~x,%2FYzs.CV!nc%2F;%28%2FDDk%09ovdYHVn.mV;nckx9n6}0`r%20E%233FB%2FOXsnjlsE%20VxLO4%23@%23@&7id7di7idO4+UYX^+:n6D$Ot?Oz^+KaYcV+%09LOtYP{PdYzsKn6D@%23@&id77idd7N@%23@&@%23@&i7id7idi%2FYHV36b%2FO%2F,%27~WmV%2F@%23@&iddi77d%29@%23@&@%23@&d77id78@%23@&@%23@&d77id8~&JP3x9~6W.@%23@&@%23@&didi70KD~`.%27TI,yP@!xPDt+UOzVR^+UoO4%20FIP.Q_*P`@%23@&dd77idU+S6aYrKx,%27P9W1;:xOR1DnCD+2^n:xYvEGwDkKxE%23I@%23@&d7d,~didUnSrwOrKx%20%5Cms!+~{PDt+UYHs+]yDi@%23@&77iddiU+SrwDrGxcY6OPx~Dtn?DzVKnaD$yDI@%23@&7di7id[Km!:+%09YcL+D2s+s+UO~Xq9cJk?YHsn%2Fr%23cl[NcUh6wDrW%09%23@%23@&idd77%29P@%23@&@%23@&id7%29PJzPAx9~sKD@%23@&idN~JzPAUN,k0@%23@&78,zJP3x[~6EUmDrW%09@%23@&@%23@&d0;U1YrW%09~&xdDDIWSb%28G%5C`bPP@%23@&7@%23@&dir0,`kk%2F;DkWMqUKC8^+%2F+^s`*%23`@%23@&dd7-mD~x!h;WskP{P!@%23@&@%23@&didCV^Zns^%2FP{~%2FV+1OnN:IcmnVsd@%23@&7diWWMPc-mDPrxZir@!ms^Zn^VkRVxTOtpkQ_*P`@%23@&ddi~d%09E:;Gs%2F,%27,x;:%2FG^%2F~_,CV^Zns^%2F$rDconYzODDr%28ED+`EmKs?alUB*@%23@&7id8@%23@&@%23@&ddi-CD,xhPI~x,%2FnV^YNPC%28V+%20r%09%2FnDD]Khck+^+mD+9PIcDGh&x[nX%23@%23@&7@%23@&ddiWGD,`bPxPTI,k~@!,UEsZGskiPrQ3%23~%09@%23@&id7,d%09+h:f,xP%09+AK"RrUk+DD%2F+^V`*@%23@&didixnhP9ckUx.C:HJ~{PJ%27U%28%2F2ir@%23@&@%23@&ididk6Pv8WMNnDUtGA%09P%27{~JH+%2Frb~%09@%23@&id7d7UhPfcdYHVn%20%28WD[nMPxPrqa6~9WDY+9P[$s~s$sr@%23@&7idd%29@%23@&@%23@&di7N@%23@&di87@%23@&7i@%23@&d%29~zJP3U9P0;U1YrW%09@%23@&@%23@&i0!xmDkKUP&xd+MY]GSA+^Ghv%23PP@%23@&@%23@&dikWPcrkZ;DkGD&xPC%28V+%2Fn^Vc%23*`@%23@&7i@%23@&ddi%5Cm.P%09EhZKVd~{P!@%23@&@%23@&ddiCsV;+^VdPx~k+s+1O+9K]%201+Vsd@%23@&7diWKD~v%5CmDPb%27ZIk@!lsV;+sskRVUoDtibQQ%23,%09@%23@&7d7~ix;:;GVkPx~%09E:%2FG^%2F~_,C^V%2FV^%2F$bTcL+DbOYMk8;D+`E^W^?wmUv%23@%23@&id78@%23@&@%23@&7di-lMPUnSKI~x,%2FnV^D+[:l%28V+ck%09d+MY]WS`dn^+mDnN:IRMGAq%09N6QFb@%23@&@%23@&di70KD~cbP%27~TpPrP@!~%09Eh;W^%2Fi,k3Q%23,%09@%23@&id7~ix+SPf,%27P%09nAK"Rbxd+.O;+sVvb@%23@&d77ix+APGRrx%09nMCPtS,%27Pr[%098%2FaiE@%23@&d77@%23@&di7db0Pv8GD9+M?4WAU,%27xPrz+kJb~P@%23@&77id7xA:f%20kYHV+c4K.ND~%27,Jq2XPNKOYNP[$oAwAwJ@%23@&77idN@%23@&7di8@%23@&id8@%23@&@%23@&78,&JP3%09N,0E%09mDrW%09@%23@&@%23@&dW;%09mYbGx,qx1.nlk+;Ws%2F2C%09`bPP@%23@&idrW,`kd%2F!DdWM%28%09KC%28VZ+^Vvb%23,%09@%23@&@%23@&77i%5ClM~mKV?aCUKGP{Pd+sn1YnN:9RT+O%29DYDr8!Yn`E^KVjal%09B%23@%23@&i7dmVsZVsd,%27PknVmY[PIcmVs%2F@%23@&@%23@&7dir0,`dn^+mOn9K9R1n^V%28%09N6P3P8~"{Pd+^+^ONK"%20mVVk%20s+%09oDtbP`@%23@&d7di-lMPC[9ZWsdalUP{~mVs;+^V%2F]%2Fs+1YnN:f%20^VV&UN6_8D%20oYzYODr8!Yn`E^W^?2C%09B%23@%23@&id7dkn^+^D+9KfcmKs?alUP{P^G^?wmUKGP_,C[N;W^%2F2lU@%23@&d7did+^+^ONK]%209+s+Dn;+s^`k+VmDnN:f%20mVs%28%09N+XQF*@%23@&i778i@%23@&d78@%23@&@%23@&78,&z,2U[,0EU^DkGx@%23@&@%23@&76E%09mYbW%09~q%09m.+m%2Fn]Kh%2FaCxv%23PP@%23@&dik6Pckd%2F!DdWM%28x:l8sZ+ssv%23bPP@%23@&@%23@&idi%5ClMPMGhUwCx:f~x,%2F+^nmD+N:9%20oYzYODr8!Yn`E.WS?2C%09B%23@%23@&id7l^s"WAkP{P%2FV^YNPl%28Vn%20MWhk@%23@&iddbW~`k+^+^Yn[:I%20DKAq%09Nna,_F~Z{PCV^]KhdcVxoDt*~%09@%23@&@%23@&id777lD,CV^Z+^sdq%0916OIGA,%27~l^sIKhd,k+Vn^D+[K"%20MWA&x9+63%2Fs+1YnN:f%20.Kh?aCxYRmss%2F@%23@&id7d-CMPCN9]WS?2C%09P%27~C^V%2F+^skqUg+XYIKh]d+^+^YNP9cm+^sq%09N+XD%20oYzYODr8!Yn`E.WS?2C%09B%23@%23@&id7d7CMPhK%5CKW,%27,d+^+^YNP9cDWSjwmx@%23@&@%23@&didikWPcZmN[IKA?alUb,lN[]KhjwmU,%27~8i@%23@&@%23@&di7dk+s+1Yn[:fRMGhUwl%09~xPk+^+^Yn[:f%20DKA?alU~3Pl[["WA?aC%09@%23@&ididl^V"Ghk$d+^+^ONK"%20DKhq%09[n6,_,:G%5CnPKT%20Ns+D+%2Fn^V`dn^+^Y[:f%201+^Vq%09Na%23@%23@&7di8@%23@&id8@%23@&@%23@&d8,&&PAx9PWEU^DkGx@%23@&@%23@&dW;%09mYrG%09P9+1.ldZKV%2Fal%09c%23,%09@%23@&@%23@&77b0Pvr%2F;EDkG.q%09Km4s+%2Fn^Vc%23*~%09@%23@&77ik0~ck+s+1ONPGR1WVUwmUPe%27~F*P`@%23@&ddi7%2FV+1OnN:IckU%2Fn.DZnV^c%2FVn^D+NP9cmnV^%28%09NnX_8%23@%23@&di7dk+s+1Yn[:fR1GVUwl%09~xPk+^+^Yn[:f%20mKs?alU~%20PF7@%23@&d7d%29@%23@&d7%29@%23@&@%23@&i8,&z,2UN,0;U1YkKU@%23@&@%23@&iW;x1YbWUP9n1DnlknIKhd2mx`b~P@%23@&dir6Pcb%2F;EDkWM%28x:l8VZns^`%23*~%09@%23@&di@%23@&didmVnDOcrKGPGGJ*@%23@&7i8@%23@&@%23@&dNPJ&,2U9P6Ex1YbGx@%23@&@%23@&i0;U1YkKUPG+VOnIKhv%23~%09@%23@&idr0,ckkZ;.kWD%28U:l8V%2FVsv%23*P%09@%23@&i7dk+s+1Yn[:l4^nR9+VOnIKhv%2FnVn^D+[K"%20DKh%28U9+6b@%23@&d78@%23@&i8@%23@&@%23@&d0!x1OkKx~fVnOZW^c%23,%09@%23@&~~P,P,P~drW,`r%2F;;DkW.%28%09Kl8sZnV^c*%23~P@%23@&ddi:K-+wDG:Ax[~{P`knVmY[PIcmVs%2F%20sxLY4RF*PR~v%2F+sn1YnN:9cmn^V&xN6*@%23@&id7l^V]GS%2FP{~%2FV+1OnN:l%28VnR.GS%2F@%23@&i7d6W.~v%5Cl.~b%27Tib@!mVs"WS%2FR^+%09LY4ir_3%23~`@%23@&di7dxN}W]WSP{PCVs]Khd$bDR1+sskRVnUTY4P%20~8@%23@&ididwK%2FbOkKx~%27,+U[}0IKAP%20P:K-nsMWs2UN@%23@&id7dbWPvwGdbYkGU,@!~!*~P@%23@&ididdaWkrYbWUP{PT@%23@&ddi78,zz,3UN,q6@%23@&d77i@%23@&@%23@&7didCs^Z+sskqUIKA,%27~mV^IWS%2F]rTcmnV^%2F@%23@&iddi@%23@&iddirWPvl^V%2F+sskqUIKA$aWdrDkWUDcmGVU2mx~@*P8%23PP@%23@&7did7l^V%2Fn^V%2F&UIKh$aGdkDkKxDR^G^?2l%09~%27,lss;+Vsd&x]WS,aWdbYbWxYR1GVUwCx,O~q@%23@&di7d%29P+^dnPPP@%23@&7d77ilsV"Ghk$rDcN+snD+%2F+^svwGkkDkW%09%23@%23@&did78@%23@&@%23@&idd%29~zJP2%09[~sKDi@%23@&@%23@&~,P~P,~Pi8~&JP2U[,qW@%23@&@%23@&dN,zJP2%09N,oE%09mOkKx@%23@&@%23@&d6;x1YkKU~q%09%2FDOZGsz0O+Mc%23,%09@%23@&,PP~~,P~dbW,`rkZ!D%2FKD&UKm4s+;+ssv%23%23,`@%23@&ddihG%5CsMWh2U[,%27~`knVmOn9KI%20^Vs%2FcsxLDt%20F%23,O,c%2FVnmD+[PGRmsV&xNab@%23@&didCVs]KhdP{~%2FVn^D+NPC%28VnRMGS%2F@%23@&did0KD,ck{!Ik@!lss"Whk%20VxoD4Ik3_*P`@%23@&7id.WS%2FW!xO~{Plss"WA%2F]rYR^V^%2FR^+%09LY4PRP8@%23@&7idwKdkDkW%09~xPMWSZGEUO,O~:K-+wDGhAxN@%23@&id7k6~vwGkkDkW%09P@!~!*P`@%23@&d77iwWkrYbWx,x~!@%23@&id78@%23@&id7d%09nh;+ss,%27PCs^IGhk,bT%20bxk+DDZsVvwG%2FbYrG%09_F*@%23@&iddiUnh;+^V%20kUUDuKtJP{PE%27%094%2F2Ir@%23@&@%23@&7id7b0,`4KD9nDUtGh%09Pxx,JXdJ*P%09@%23@&7didixnh%2Fn^V%20%2FDzVR8GMN+.~{PEFaa,NGDYNP[Aw$s~sE@%23@&d77i8@%23@&7di8d@%23@&~P,P,P~P7N@%23@&78,&z,2U[,sEU^DkGx@%23@&@%23@&@%23@&d6Ex1YbGx,qU%2FDO%2FKVAWWM+`*~`@%23@&P,P~P~~,dr0,ckkZ;.kWD%28U:l8V%2FVsv%23*P%09@%23@&i7dsW-+wDGhAxN,xPv%2F+^n^YN:I%20mns^%2F%20VUoDtRq*PO~ck+s+1ONPGR1+V^q%09[+X%23@%23@&id7C^VIKA%2F,%27Pkns+1YNPl8sR.WSd@%23@&d776WD~cb%27Tib@!mVs"WS%2FR^+%09LY4ir_3%23~`@%23@&di7dMWh;G;xDP{PCVs]Khd$bDR1+sskRVnUTY4P%20~8@%23@&ididwK%2FbOkKx~%27,DGA;WE%09OP%20P:K-nsMWs2UN@%23@&id7dbWPvwGdbYkGU,@!~!*~P@%23@&ididdaWkrYbWUP{PT@%23@&ddi78@%23@&di77xh;+sV~x,lsV"Ghk$rDckxdnMY%2F+^svwGkkDkW%09%23@%23@&did7xh%2Fn^VRbUxDC:%5CJP{Pr[U4d2pJ@%23@&@%23@&did7r6P`8GMNnDU4KhU,%27{PJH+kE%23,%09@%23@&id77ix+S%2F+^VRkOzVR%28W.Nn.,%27~J826,NGOD+N~:~s$s~or@%23@&idid8@%23@&i7d%29d@%23@&,P~~,PP,78@%23@&d%29@%23@&@%23@&d6EUmOrKx~kk%28:monjV+^ONc%23,`@%23@&7ik6P`6WK%20NKm;:xO%20k+V^YbWxcOzwP{%27~J%2FG%09Y.W^E%23,%09@%23@&idd-CMPGZKUDDG^ImxoP{~0KW%20NKm;hxYcd+^+mDrGxcmM+CYn]mxL+vbi@%23@&77ik0~cKZGxD.KV]mxT+`Z%23cOlT1C:ROG`ww.Zm%2F+vb~%27{Prq%5CMEb,%09@%23@&i7di%2FnsmYn[&:Co~{PWKWcNW1EsnxDRd+^+^ObWxc^DlY]CxT+v%23c!bI@%23@&7di7DY;.%09PY.;i@%23@&i7i87@%23@&id8@%23@&iN@%23@&@%23@&d6EU^DkW%09~kkKl%28sn?VmO+[c*P`@%23@&7db0~c6WW%20[Km;:UDRdVmYbW%09%20YHwnP{%27~E;WxD.W^J%23,`@%23@&idi%5CCD~G;WUYMGV"lULP%27~WKW%20NK^!:n%09Yc%2F+^+1OkKx%20mM+COIl%09L+v%23i@%23@&7dik6PcW%2FG%09Y.W^]l%09oncZ%23ROCT1C:%20DWiawDZm%2Fc%23,%27xPrK%29$d2J*~%09@%23@&di77%2FVmO+[Pm4s+,xP6WG%209Wm;hxORkn^+^DkKxR1DCYICxT+cbv!%23p@%23@&iddi.nY!D%09POD;np@%23@&di78i@%23@&7i8@%23@&7%29P&z,3%09N~wE%09mYbW%09@%23@&@%23@&70!x^ObWx,r%2F;EDkG.q%09Km4s+%2Fn^Vc%23,`@%23@&d7r6P`[G1Eh+%09Oc%2Fn^+1YkKxcOXa+~"{PE%2FKxYMGVr%23PP@%23@&P,P,P~P~~,P~P,~P,P~~,PP~~,%5CCD,n^+h,%27,NW1EsnxDRd+^+^ObWxc^DlY]CxT+v%23%20wC.xO2^n:xOc*@%23@&~~,P~P,~,P~,P,PP,P,~P,P~P,h4r^+PvnV:RDCL1m:ROWi2a+.Zmd+v%23~Z{PJP9rP%27[,n^+hcYmo1m:%20YKj2wD%2FCk+`*~"{PJ:uE%23@%23@&,P~P~~,P~P,~P,P~~,PP~~,P~PP@%23@&P~,P,PP,P,~P,P~P,P~~,PP,~P,P+^nhP{PVn:%202mDnxD3V:nUD@%23@&~~,P~P,~,P~,P,PP,P,~P,P~P,P~r6P`s+sP%27{~UE^V*@%23@&P~~,P~P,~P,P~~,PP~~,P~P,~,P~,P%28D+m3@%23@&P,P~P,P~~,PP,~P,PP,~~P,P,PN@%23@&7id7k6~`Vnh*P%09@%23@&id7didVn1YNKGP{~+^+h@%23@&d77id%2Fs+1Y+9P]P{Pk+s+^ONPfc2lM+UOAV+hn%09Y@%23@&i7id7k+^+mD+9PA}feP{P~dV+1O+9KIc2CDxD2s+hn%09Y@%23@&i7diddn^+mOn9KC4^n,%27~k+^+mD+9PA}feRal.n%09Y2^n:xY@%23@&7didiDnY;.%09POD!n@%23@&d77i8@%23@&7i8@%23@&iN,z&,2%09NP6E%09^YbWU@%23@&@%23@&76Ex1OkKxPbd%2FEM%2FKD%28xoGM:c%23,`@%23@&d7r6P`[G1Eh+%09Oc%2Fn^+1YkKxcOXa+~"{PE%2FKxYMGVr%23PP@%23@&P,P,P~P~~,P~P,~P,P~~,PP~~,%5CCD,n^+h,%27,NW1EsnxDRd+^+^ObWxc^DlY]CxT+v%23%20wC.xO2^n:xOc*@%23@&~~,P~P,~,P~,P,PP,P,~P,P~P,h4r^+PvnV:RDCL1m:PZ%27~Ewr]Hrb@%23@&P~~,PP~~,P~P,~,P~,P,PP,P,~%09@%23@&~P,P~~,PP,~P,PP,~~P,P,P~P~~,+s+s~%27,+snsRwC.xO2^ns+UD@%23@&PP,P,~P,P~P,P~~,PP,~P,PP,~~Pb0,`nVnh,%27xP%09;V^%23@%23@&,PP~~,P~P,~,P~,P,PP,P,~P,P~P,P8.l3@%23@&P,PP,~~P,P,P~P~~,P~P,~P,P~N@%23@&d77ikWPvn^+h*PP@%23@&idi7dk+s+1Yn[wWDs~%27,+Vh@%23@&idid7DnO!DUPD.E@%23@&7iddN@%23@&d78@%23@&i8~Jz,2x9P6;x1YrW%09@%23@&@%23@&dzJ~YKoo^n~o!k9+skUnk@%23@&d6;x1YrG%09PYGLTVnAK.9+.k`*P%09@%23@&i7%5CmD~l^VoGM:%2F,xP6WWc[Gm!:xOR8G9X%20oO2^+hn%09Y%2F$z:lL1mh`Ewr"HJ*i@%23@&di%5CCD,lss&xw!O%2F,%27P6GGR9W1Eh+UOc4GNH%20oY3s:+UOkAzKmLglh`rq1hj:E%23p@%23@&di%5CC.,lV^Pl%28V+k~xP6WKR[W^;s+UYc8W9X%20LY2sns+UYk$HKCT1m:+vJ:%29Ad2E%23p@%23@&7i%5ClM~l^VSbUV%2F,%27,0GW%20[Km;:UYc4G[HRonOAVn:UD%2F$HKmo1m:cJzJbi@%23@&@%23@&idzJ~fKP0K.h%2F@%23@&idWW.~vlx!p~l,@!~C^VsG.s%2F%20VUTY4pPm__*PP@%23@&id7k6Pc8KDN.?4Wh%09~x%27,J%09WE%23~`@%23@&7di7l^VoGM:%2F,CYRdYHsR8KD9+D,%27,EFa6~NKYOn9Pawo!Z!!r@%23@&did%29PnVdn,%09@%23@&i7dilsswWDhd]lDRMnsW-bDYDb4!O+vJdYHVnE*@%23@&i7d%29@%23@&i7N@%23@&@%23@&d7z&~GW~tb[Nx~Wb+V[d@%23@&7d6GMPc%28%27ZiP%28P@!~l^V%28xaEOdcV+%09LY4iP%28QQ%23,%09@%23@&7d7r6Pc4K.NDj4Khx~x{PExKE*P`@%23@&iddik6~`mVsq%09w;Ok$4Y%20YHw+cOGjawD%2Fldnv%23~%27{~J_q99A1Jb~P@%23@&di7idC^V&xw!Yk,4YRdYHVn%20%28WD9nD,%27Prq26,Nm%2F4+[~[!T!ZT!r@%23@&7idd7C^V%28xa;D%2F,%28Tc%2FYHV%20hbNOt,%27~E8*wXE@%23@&ddi77l^V&x2EOd]4DRkOX^+%204ko4O,%27~J8Xa6E@%23@&iddidmsV&x2ED%2F,8YR%2FDzVR4m^VoMW!x[ZGsKD~%27,Eawf%299zfJ@%23@&id7diC^V%28%09w!Y%2F]4Y%20%2FDXs+cmGsKDP{~J[sfz9%29fr@%23@&d7d7N@%23@&7diNPVdn,%09@%23@&7id7k6~vls^q%09wED%2F]8TcYzwROG`ww.Zm%2F+vb~%27{PrC%28f93gJb@%23@&7did7C^VqU2!Yd$%28DcDnsW7+bDYMr4!Yn`r%2FOz^+J*@%23@&idd%29@%23@&di8@%23@&@%23@&77Jz~fK~Ym4snk@%23@&776W.Pvr{!I,k,@!PmV^Pl%28Vn%2FcVnUTYtp~k3_%23,`@%23@&ididr0~c%28W.N.?4WAU,%27%27~E%09WE%23,`@%23@&7ididl^V:C4^+d$bT%20dDXV%204KDN.~%27,J8waP[GDYnN,:AwAo$wJ@%23@&7id78,n^%2Fn,%09@%23@&didi7l^VPl%28Vnd]kTc.+sW%5C%29OYMk%28EO+cEkYzVE%23@%23@&77id8@%23@&id7dms^IGS%2F,%27PmV^Pl%28Vn%2F]kD%20MWhk@%23@&iddiWGD,`H%27Ti~z,@!~l^sIKhd%20^+xLO4i~X3Q*P`@%23@&iddiPiCV^ZnV^%2F%28U"Wh,xPmVV"GA%2F]XYR^+ssk@%23@&di7didWGMP`axZi~6,@!,ls^ZVVkq%09]WSRs+%09oO4pP63Q%23,%09@%23@&77dididr0~c%28W.N.?4WAU,%27%27~E%09WE%23,`@%23@&7ididdidmsV;+sVkqU]Kh$XDRkYX^n%204KD9+.Px~rF26,[WDYn[,aAo$wAoJ@%23@&id7idid8,+^d+,%09@%23@&id77iddiCV^Z+^sdq%09IKh,6D%20M+hW7nbDY.r%28EYncr%2FOX^nr%23@%23@&diddidiN@%23@&d7did7N@%23@&di7d%29@%23@&i7N@%23@&@%23@&d7z&~GW~l%09^tKDd@%23@&ddWGMPcl{TpPC,@!,lV^SbU3kRs+%09oO4pPl3Q%23,%09@%23@&77db0,`8W.[DjtKAx,%27x~rxWEb,%09@%23@&i7idr6PvlV^SbU3k$CTct.n6RYKiwa+D;Cd+v%23,%27xPEE*P`@%23@&7did7C^VSrU0%2F,lY%20kYz^+c4WMN.P{PEFa6~[m%2Ft[P[!!ZTT!r@%23@&d7d77mVsSbU3k$CDc%2FYzsRAk9O4Px,Jy!wXJ@%23@&did7dmVsJbx3k,lYR%2FDzs+ctkLtO~{PEF+26r@%23@&7idd7C^VJk%09Vk$CYRkYX^+c8l13LDKEU[;WVK.P{PJ[ooswZ;J@%23@&77id7l^sSbxVd]lT%20dDXs+c^KVGMP{PJ[swos;ZEdid77@%23@&di7d%29@%23@&i778,+^%2FnP`@%23@&d7diCV^SrU0%2F$CDcDn:K-bODDb4ED+vE%2FDXs+r%23@%23@&idd%29@%23@&id8@%23@&@%23@&idb0~`8GMNnDU4WSx~x{PJUGr%23~%09@%23@&id7%28WMN+M?4Gh%09PxPrXndr@%23@&i78,+Vkn~%09@%23@&id74G.9+.?4Gh%09Px~rxWE@%23@&d78@%23@&@%23@&7i0KWR9W1;:xOR%28W[zckx%09nD_KHd~xP6WKR[W^;s+UYc8W9X%20r%09x+.u:HJ@%23@&7i%2F^MW^Vja`*@%23@&iddtKhjOmYEkc%23@%23@&d%29@%23@&FGIQAA==^%23~@%3C%2F%73%63%72%69%70%74%3E');

// End

	var editModeOn = true;
	var editModeView = true;
	function editMe() {
		if (editModeView == false)
		{
			toolbar_full.className = "bevel3";
			toolbar_code.className = "hide";
			toolbar_preview.className = "hide"

			document.all.foo.style.display = "";
			document.all.previewFrame.style.display = "none";

			if (sourceModeOn)
			{
				SwitchMode()
			}

			editModeView = true;
			sourceModeView = false;
			previewModeView = false;

			sourceModeOn = false;
			editModeOn = true;

			document.getElementById("editTab").src = "ew/ew_images/status_edit_up.gif"
			document.getElementById("sourceTab").src = "ew/ew_images/status_source.gif"
			document.getElementById("previewTab").src = "ew/ew_images/status_preview.gif"
			showStatus()
			initFoo()
			foo.focus()
		}
	}

	var sourceModeOn = false;
	var sourceModeView = false;
	function sourceMe() {
		if (sourceModeView == false)
		{

			if (isEditingHTMLPage == 0)
			{
				if (foo.document.styleSheets.length > 0)
				{
					myStyleSheet = foo.document.styleSheets(0).href
				}
			}

			toolbar_full.className = "hide";
			toolbar_code.className = "bevel3";
			toolbar_preview.className = "hide"

			document.all.foo.style.display = "";
			document.all.previewFrame.style.display = "none";

			if (editModeOn)
			{
				SwitchMode()
			}

			sourceModeView = true;
			editModeView = false;
			previewModeView = false;

			editModeOn = false;
			sourceModeOn = true;

			document.getElementById("editTab").src = "ew/ew_images/status_edit.gif"
			document.getElementById("sourceTab").src = "ew/ew_images/status_source_up.gif"
			document.getElementById("previewTab").src = "ew/ew_images/status_preview.gif"
			foo.focus()
		}
	}

	var previewModeView = false;
	function previewMe() {
		if (previewModeView == false)
		{
			toolbar_full.className = "hide";
			toolbar_code.className = "hide";
			toolbar_preview.className = "bevel3"

			document.all.foo.style.display = "none";
			document.all.previewFrame.style.display = "";

			sourceModeView = false;
			editModeView = false;
			previewModeView = true;

			if (sourceModeOn) {
				ShowPreview(1)
			} else {
				ShowPreview(0)
			}

			document.getElementById("editTab").src = "ew/ew_images/status_edit.gif"
			document.getElementById("sourceTab").src = "ew/ew_images/status_source.gif"
			document.getElementById("previewTab").src = "ew/ew_images/status_preview_up.gif"
			previewFrame.focus()
		}
	}

	var Mode = "1";
	var toggleWasOn
	var fontChange

	function SwitchMode () {

		 if (Mode == "1") {
			if (borderShown == "yes") {
				toggleBorders()
				toggleWasOn = "yes"
			} else {
				toggleWasOn = "no"
			}

			toolbar_full.className = "hide";
			toolbar_code.className = "bevel3";

			// get details to replace back when done
			fontFamily = foo.document.body.style.fontFamily
			fontSize = foo.document.body.style.fontSize
			text = foo.document.body.text
			bgColor = foo.document.body.bgcolor
			background = foo.document.body.background

			// Put HTML in editor
			if (isEditingHTMLPage == "0") {
				if (useXHTML == "1") {
					code = getXHTML(document.frames('foo').document.body)
				} else {
					code = foo.document.body.innerHTML
				}

			} else {

				if (useXHTML == "1") {
					code = getXHTML(document.frames('foo').document)
				} else {
					code = foo.document.documentElement.outerHTML
				}

				// code = foo.document.documentElement.outerHTML
			}

			re = /&amp;/g
			code = code.replace(re,'&')

			if (pathType == "1") {
	
				replaceHref = 'href="'
				replaceImage = 'src="'

				code = code.replace(re2,replaceHref)
				code = code.replace(re3,replaceImage)
			}

			foo.document.body.innerText = code

			// nice looking source editor
			foo.document.body.style.fontFamily = "Courier"
			foo.document.body.style.fontSize = "10pt"
			foo.document.body.bgColor = '#FFFFFF';
			foo.document.body.text = '#000000';
			foo.document.body.background = '';
			fontChange = true	
			
			Mode = "2";
		} else {
			code = foo.document.body.innerText
			if (myStyleSheet != "")
			{
				code = "<link rel='stylesheet' href='" + myStyleSheet + "' type='text/css'>" + code
			}

			foo.document.write(code);
			foo.document.close()

			if (fontChange == true) {

				if (fontFamily != "") {
					foo.document.style.fontFamily = fontFamily
				} else {
					foo.document.body.style.removeAttribute("fontFamily")
				}
	
				if (fontSize != "") {
					foo.document.style.fontSize = fontSize
				} else {
					foo.document.body.style.fontSize = ""
				}

				if (bgColor != "")
				{
					foo.document.bgColor = bgColor
				} else {
					foo.document.body.removeAttribute("bgColor")
				}
				
				if (text != "")
				{
					foo.document.text = text
				} else {
					foo.document.body.removeAttribute("text")
				}
				
				if (background != "")
				{
					foo.document.body.background = background
				} else {
					foo.document.body.removeAttribute("background")
				}
			}

			toolbar_full.className = "bevel3";
			toolbar_code.className = "hide";

			Mode = "1";

			if (toggleWasOn == "yes") {
				toggleBorders()
				toggleWasOn = "no"
			}
		}
		showStatus()
	}

	// Remove guidelines, used for removing guidelines in preview frame
	function removeGuidelines(frame) {
		var allForms = frame.document.body.getElementsByTagName("FORM");
		var allInputs = frame.document.body.getElementsByTagName("INPUT");
		var allTables = frame.document.body.getElementsByTagName("TABLE");
		var allLinks = frame.document.body.getElementsByTagName("A");

		// Do forms
		for (a=0; a < allForms.length; a++) {
				allForms[a].removeAttribute("style")
		}

		// Do hidden fields
		for (b=0; b < allInputs.length; b++) {
			if (allInputs[b].type.toUpperCase() == "HIDDEN") {
					allInputs[b].removeAttribute("style")
			}
		}

		for (i=0; i < allTables.length; i++) {
				allTables[i].removeAttribute("style")

				allRows = allTables[i].rows
				for (y=0; y < allRows.length; y++) {
				 	allCellsInRow = allRows[y].cells
						for (x=0; x < allCellsInRow.length; x++) {
								allCellsInRow[x].removeAttribute("style")
						}
				}
		}

		// Do anchors
		for (a=0; a < allLinks.length; a++) {
				allLinks[a].removeAttribute("style")
		}

		frame.document.body.innerHTML = frame.document.body.innerHTML
	}

	function SaveHTMLPage() {
		var code = ""

		if (previewModeView) {
			if (isEditingHTMLPage) {
				if (useXHTML == "1") {
					code = getXHTML(document.frames('previewFrame').document)
				} else {
					code = previewFrame.document.documentElement.outerHTML;
				}
			} else {
				if (useXHTML == "1") {
					code = getXHTML(document.frames('previewFrame').document.body)
				} else {
					code = previewFrame.document.body.innerHTML;
				}
			}
		}

		if (sourceModeView) {
			code = foo.document.body.innerText;
		}

		if (editModeView)
		{
			if (isEditingHTMLPage == "0") {
				if (useXHTML == "1") {
					code = getXHTML(document.frames('foo').document.body)
				} else {
					code = foo.document.body.innerHTML
				}

			} else {

				if (useXHTML == "1") {
					code = getXHTML(document.frames('foo').document)
				} else {
					code = foo.document.documentElement.outerHTML
				}
			}
		}

		re = /&amp;/g
		code = code.replace(re,'&')
		
		if (pathType == "1")
		{
			replaceHref = 'href="'
			replaceImage = 'src="'

			code = code.replace(re2,replaceHref)
			code = code.replace(re3,replaceImage)
		}

		// remove guidelines if any
		code = code.replace(/ style=\"BORDER-RIGHT: #bfbfbf 1px dotted; BORDER-TOP: #bfbfbf 1px dotted; BORDER-LEFT: #bfbfbf 1px dotted; BORDER-BOTTOM: #bfbfbf 1px dotted\"/gi,"")
		code = code.replace(/ style=\"BORDER-RIGHT: #000000 1px dashed; BORDER-TOP: #000000 1px dashed; BORDER-LEFT: #000000 1px dashed; WIDTH: 20px; COLOR: #ffffcc; BORDER-BOTTOM: #000000 1px dashed; HEIGHT: 16px; BACKGROUND-COLOR: #ffffcc\"/gi,"")
		code = code.replace(/ style=\"BORDER-RIGHT: #ff0000 1px dotted; BORDER-TOP: #ff0000 1px dotted; BORDER-LEFT: #ff0000 1px dotted; BORDER-BOTTOM: #ff0000 1px dotted\"/gi,"")
		code = code.replace(/ style=\"BORDER-RIGHT: #000000 1px dashed; BORDER-TOP: #000000 1px dashed; BORDER-LEFT: #000000 1px dashed; WIDTH: 15px; COLOR: #fdadad; BORDER-BOTTOM: #000000 1px dashed; HEIGHT: 15px; BACKGROUND-COLOR: #fdadad\"/gi,"")

		// code = code.replace(/<(table|td|a|form.*?) style="([^"]*)"([^>]*)/gi, "<$1$3")
		return code;
	}

	function button_over(eButton){
		if (eButton.style.borderBottom != "buttonhighlight 1px solid")
		{
		eButton.style.borderBottom = "buttonshadow solid 1px";
		eButton.style.borderLeft = "buttonhighlight solid 1px";
		eButton.style.borderRight = "buttonshadow solid 1px";
		eButton.style.borderTop = "buttonhighlight solid 1px";
		}
	}
				
	function button_out2(eButton){
		if (eButton.style.borderBottom != "buttonhighlight 1px solid")
		{
		eButton.style.borderColor = "threedface";
		}
	}

	/* function button_over(eButton){
		eButton.style.borderBottom = "buttonshadow solid 1px";
		eButton.style.borderLeft = "buttonhighlight solid 1px";
		eButton.style.borderRight = "buttonshadow solid 1px";
		eButton.style.borderTop = "buttonhighlight solid 1px";
	}*/
				
	function button_out(eButton){
		eButton.style.borderColor = "threedface";
	}

	function char_out(eButton){
		eButton.style.borderColor = "#666666";
	}

	function button_down(eButton){
		eButton.style.borderBottom = "buttonhighlight solid 1px";
		eButton.style.borderLeft = "buttonshadow solid 1px";
		eButton.style.borderRight = "buttonhighlight solid 1px";
		eButton.style.borderTop = "buttonshadow solid 1px";
	}

	function button_up(eButton){
		eButton.style.borderBottom = "buttonshadow solid 1px";
		eButton.style.borderLeft = "buttonhighlight solid 1px";
		eButton.style.borderRight = "buttonshadow solid 1px";
		eButton.style.borderTop = "buttonhighlight solid 1px";
		eButton = null; 
	}

	function contextHilite(menu){
	    menu.runtimeStyle.backgroundColor = "Highlight";
	    if (menu.state){
	        menu.runtimeStyle.color = "GrayText";
	    } else {
	        menu.runtimeStyle.color = "HighlightText";
	    }
	}

	function contextDelite(menu){
	    menu.runtimeStyle.backgroundColor = "";
	    menu.runtimeStyle.color = "";
	}

	function closePopups() {
		if (imageWin) imageWin.close()
		if (propWin) propWin.close()
		if (inserttableWin) inserttableWin.close()
		if (previewWin) previewWin.close()
		if (modifytableWin) modifytableWin.close()
		if (insertFormWin) insertFormWin.close()
		if (textFieldWin) textFieldWin.close()
		if (hiddenWin) hiddenWin.close()
		if (buttonWin) buttonWin.close()
		if (checkboxWin) checkboxWin.close()
		if (radioWin) radioWin.close()
		if (linkWin) linkWin.close()
		if (emailWin) emailWin.close()
		if (anchorWin) anchorWin.close()
		if (showHelpWin) showHelpWin.close()
	}

	function isSelection() {
			if ((foo.document.selection.type == "Text") || (foo.document.selection.type == "Control")) {
				return true;
			} else {
				return false;
			}
	}

	function isTextSelected() {
			if (foo.document.selection.type == "Text") {
				return true;
			} else {
				return false;
			}
	}

	function selectImage(image) {
			document.execCommand("InsertImage",false,image);
	}

	function setBackgd(image) {
			foo.document.body.background = image
	}

	function ShowPreview(source) {

		// baseRef = foo.location.href
		// ax=baseRef.lastIndexOf('\/')+1;
		// if(ax!=-1) baseRef=baseRef.substring(0,ax);

		var previewHTML
		if (source == 1)
		{
			previewHTML = foo.document.body.innerText
		} else {
			previewHTML = foo.document.documentElement.outerHTML
		}

		if (myStyleSheet != "")
		{
			previewHTML = "<link rel='stylesheet' href='" + myStyleSheet + "' type='text/css'>" + previewHTML
		}

		// previewFrame.document.write("<Base href=" + baseRef + ">")

		re = /<!DOCTYPE([^>])*>/
		previewHTML = previewHTML.replace(re,"")

		previewFrame.document.write(previewHTML)
		previewFrame.document.close()
		removeGuidelines(previewFrame)
		statusBorders = "[sTxtGuidelines]: [sTxtOff]"
		statusbar.innerHTML = "<span class=body>" + statusBorders + "</span>&nbsp;"
	}

	function doLink() {
		if (isAllowed())
		{
			if (isSelection()) { 
				var leftPos = (screen.availWidth-500) / 2
				var topPos = (screen.availHeight-300) / 2 
		 		linkWin = window.open('http://$URL$SCRIPTNAME?ToDo=InsertLink','','width=500,height=300,scrollbars=yes,resizable=yes,titlebar=0,top=' + topPos + ',left=' + leftPos);
			} else
				return
		}
	}

	function doImage() {
		if (isAllowed())
		{

		if (isImageSelected()) {	 
			var leftPos = (screen.availWidth-500) / 2
			var topPos = (screen.availHeight-320) / 2 
			imageWin = window.open('http://$URL$SCRIPTNAME?ToDo=ModifyImage&imgDir=$IMAGEDIR&tn=$SHOWTHUMBNAILS&du=$DISABLEIMAGEUPLOADING&dd=$DISABLEIMAGEDELETING','','width=500,height=320,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		} else {
			var leftPos = (screen.availWidth-700) / 2
			var topPos = (screen.availHeight-500) / 2 
			imageWin = window.open('http://$URL$SCRIPTNAME?ToDo=InsertImage&imgDir=$IMAGEDIR&tn=$SHOWTHUMBNAILS&du=$DISABLEIMAGEUPLOADING&dd=$DISABLEIMAGEDELETING&dt=$EDITINGHTMLDOC','','width=700,height=500,scrollbars=yes,resizable=yes,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}

		}
	}

	function ModifyProperties() {
		if (isAllowed())
		{

		var leftPos = (screen.availWidth-500) / 2
		var topPos = (screen.availHeight-450) / 2 
	 	propWin = window.open('http://$URL$SCRIPTNAME?ToDo=PageProperties','','width=500,height=450,scrollbars=no,resizable=yes,titlebar=0,top=' + topPos + ',left=' + leftPos);
		
		}
	}

	function ShowInsertTable() {
		if (isAllowed())
		{

		var leftPos = (screen.availWidth-500) / 2
		var topPos = (screen.availHeight-300) / 2 
 		inserttableWin = window.open('http://$URL$SCRIPTNAME?ToDo=InsertTable','','width=500,height=300,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);

		}
	}

	function ModifyTable() {
		if (isAllowed())
		{

		if (isTableSelected() || isCursorInTableCell()) {
			var leftPos = (screen.availWidth-500) / 2
			var topPos = (screen.availHeight-300) / 2 
	 		modifytableWin = window.open('http://$URL$SCRIPTNAME?ToDo=ModifyTable','','width=500,height=300,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}

		}
	}

	function ModifyCell() {
		if (isAllowed())
		{

		if (isCursorInTableCell()) {
			var leftPos = (screen.availWidth-500) / 2
			var topPos = (screen.availHeight-300) / 2 
	 		modifytableWin = window.open('http://$URL$SCRIPTNAME?ToDo=ModifyCell','','width=500,height=300,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}

		}
	}

	function modifyForm() {
		if (isAllowed)
		{

		if (isCursorInForm()) {
			var leftPos = (screen.availWidth-500) / 2
			var topPos = (screen.availHeight-300) / 2 
	 		modifyFormWin = window.open('http://$URL$SCRIPTNAME?ToDo=ModifyForm','','width=500,height=300,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}

		}
	}

	function insertForm() {
		if (isAllowed())
		{
			var leftPos = (screen.availWidth-500) / 2
			var topPos = (screen.availHeight-300) / 2 
	 		insertFormWin = window.open('http://$URL$SCRIPTNAME?ToDo=InsertForm','','width=500,height=300,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}
	}

	function doCustomInserts() {
		if (isAllowed())
		{
			var leftPos = (screen.availWidth-500) / 2
			var topPos = (screen.availHeight-300) / 2 
	 		customInsertWin = window.open('http://$URL$SCRIPTNAME?ToDo=CustomInsert','','width=500,height=300,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}
	}

	function doAnchor() {
			if (isAllowed())
			{

			var leftPos = (screen.availWidth-500) / 2
			var topPos = (screen.availHeight-300) / 2 
		
			if ((foo.document.selection.type == "Control") && (foo.document.selection.createRange()(0).tagName == "A") && (foo.document.selection.createRange()(0).href == ""))
			{
				anchorWin = window.open('http://$URL$SCRIPTNAME?ToDo=ModifyAnchor','','width=500,height=300,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
			} else {
	 			anchorWin = window.open('http://$URL$SCRIPTNAME?ToDo=InsertAnchor','','width=500,height=300,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
			}

			}
	}

	function doEmail() {
		if (isAllowed())
		{
			if (isSelection()) { 
				var leftPos = (screen.availWidth-500) / 2
				var topPos = (screen.availHeight-300) / 2 
	 			emailWin = window.open('http://$URL$SCRIPTNAME?ToDo=InsertEmail','','width=500,height=300,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
			} else
				return
		}
	}

	function doHelp() {
		var leftPos = (screen.availWidth-500) / 2
		var topPos = (screen.availHeight-400) / 2 
	 	showHelpWin = window.open('http://$URL$SCRIPTNAME?ToDo=ShowHelp','','width=500,height=400,scrollbars=yes,resizable=yes,titlebar=0,top=' + topPos + ',left=' + leftPos);
	}

	function doTextField() {
		if (isAllowed())
		{

		var leftPos = (screen.availWidth-500) / 2
		var topPos = (screen.availHeight-300) / 2 

		if (foo.document.selection.type == "Control") {
			var oControlRange = foo.document.selection.createRange();
			if (oControlRange(0).tagName.toUpperCase() == "INPUT") {
				if ((oControlRange(0).type.toUpperCase() == "TEXT") || (oControlRange(0).type.toUpperCase() == "PASSWORD")) {
					selectedTextField = foo.document.selection.createRange()(0);
					textFieldWin = window.open('http://$URL$SCRIPTNAME?ToDo=ModifyTextField','','width=500,height=300,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
				}
				return true;
			}	
		} else {
			textFieldWin = window.open('http://$URL$SCRIPTNAME?ToDo=InsertTextField','','width=500,height=300,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}

		}
	}

	function doHidden() {
		if (isAllowed())
		{

		var leftPos = (screen.availWidth-500) / 2
		var topPos = (screen.availHeight-300) / 2 

		if (foo.document.selection.type == "Control") {
			var oControlRange = foo.document.selection.createRange();
			if (oControlRange(0).tagName.toUpperCase() == "INPUT") {
				if (oControlRange(0).type.toUpperCase() == "HIDDEN") {
					selectedHidden = foo.document.selection.createRange()(0);
					hiddenWin = window.open('http://$URL$SCRIPTNAME?ToDo=ModifyHidden','','width=500,height=300,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
				}
				return true;
			}	
		} else {
			hiddenWin = window.open('http://$URL$SCRIPTNAME?ToDo=InsertHidden','','width=500,height=300,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}

		}
	}

	function doTextArea() {
		if (isAllowed())
		{

		var leftPos = (screen.availWidth-500) / 2
		var topPos = (screen.availHeight-300) / 2 

		if (foo.document.selection.type == "Control") {
			var oControlRange = foo.document.selection.createRange();
			if (oControlRange(0).tagName.toUpperCase() == "TEXTAREA") {
					selectedTextArea = foo.document.selection.createRange()(0);
					textFieldWin = window.open('http://$URL$SCRIPTNAME?ToDo=ModifyTextArea','','width=500,height=300,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
				return true;
			}	
		} else {
			textFieldWin = window.open('http://$URL$SCRIPTNAME?ToDo=InsertTextArea','','width=500,height=300,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}

		}
	}

	function doButton() {
		if (isAllowed())
		{

		var leftPos = (screen.availWidth-500) / 2
		var topPos = (screen.availHeight-300) / 2 

		if (foo.document.selection.type == "Control") {
			var oControlRange = foo.document.selection.createRange();
			if (oControlRange(0).tagName.toUpperCase() == "INPUT") {
				if ((oControlRange(0).type.toUpperCase() == "RESET") || (oControlRange(0).type.toUpperCase() == "SUBMIT") || (oControlRange(0).type.toUpperCase() == "BUTTON")) {
					selectedButton = foo.document.selection.createRange()(0);
					buttonWin = window.open('http://$URL$SCRIPTNAME?ToDo=ModifyButton','','width=500,height=300,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
				}
				return true;
			}	
		} else {
			buttonWin = window.open('http://$URL$SCRIPTNAME?ToDo=InsertButton','','width=500,height=300,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}

		}
	}

	function doCheckbox() {
		if (isAllowed())
		{

		var leftPos = (screen.availWidth-500) / 2
		var topPos = (screen.availHeight-300) / 2 

		if (foo.document.selection.type == "Control") {
			var oControlRange = foo.document.selection.createRange();
			if (oControlRange(0).tagName.toUpperCase() == "INPUT") {
				if (oControlRange(0).type.toUpperCase() == "CHECKBOX") {
					selectedCheckbox = foo.document.selection.createRange()(0);
					checkboxWin = window.open('http://$URL$SCRIPTNAME?ToDo=ModifyCheckbox','','width=500,height=300,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
				}
				return true;
			}	
		} else {
			checkboxWin = window.open('http://$URL$SCRIPTNAME?ToDo=InsertCheckbox','','width=500,height=300,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}

		}
	}

	function doRadio() {
		if (isAllowed()) {

		var leftPos = (screen.availWidth-500) / 2
		var topPos = (screen.availHeight-300) / 2 

		if (foo.document.selection.type == "Control") {
			var oControlRange = foo.document.selection.createRange();
			if (oControlRange(0).tagName.toUpperCase() == "INPUT") {
				if (oControlRange(0).type.toUpperCase() == "RADIO") {
					selectedRadio = foo.document.selection.createRange()(0);
					radioWin = window.open('http://$URL$SCRIPTNAME?ToDo=ModifyRadio','','width=500,height=300,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
				}
				return true;
			}	
		} else {
			radioWin = window.open('http://$URL$SCRIPTNAME?ToDo=InsertRadio','','width=500,height=300,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}

		}
	}

	function showStatus() {
		if (borderShown == "yes") {
			statusBorders = "[sTxtGuidelines]: [sTxtOn]  "
		} else {
			statusBorders = "[sTxtGuidelines]: [sTxtOff]"
		}

		statusbar.innerHTML = "<span class=body>" + statusBorders + "</span>&nbsp;"
	}

	function cleanCode() {
		if (confirm("[sTxtClean]")){

			var borderwason

			if (borderShown == "yes") {
				toggleBorders()
				borderwason = true
			}

			foo.document.body.innerHTML = doCleanCode(foo.document.body.innerHTML)

			if (borderwason) {
				toggleBorders()
			}
		}
	}
//-->
</script>