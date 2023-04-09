<html>
        <head></head>
        <script language="Javascript1.2">

        // ***********************************************
        // AUTHOR: localhost, LLC
        // URL: http://localhost
        // Use the script, just leave this message intact.
        // Download your FREE CGI/Perl Scripts today!
        // ( http://localhost/scripts.htm )
        // Nullified by AndyAN
        // ***********************************************

        message = "Function Disabled!";

        function NoRightClick(b) {
           if(((navigator.appName=="Microsoft Internet Explorer")&&(event.button > 1))
           ||((navigator.appName=="Netscape")&&(b.which > 1))){
           alert(message);
           return false;
           }
        }
        document.onmousedown = NoRightClick;

        // -->
</script>
                <STYLE TYPE="text/css">

                    .button2 {
                        background-color:#eeeeee;
                        font:verdana;
                        font-weight:bold;
                        color:#000080;
                        font-size:10pt;
                        }

                        .button {
                                BACKGROUND-COLOR: buttonface;
                                BORDER-BOTTOM: buttonface 1px solid;
                                BORDER-LEFT: buttonface 1px solid;
                                BORDER-RIGHT: buttonface 1px solid;
                                BORDER-TOP: buttonface 1px solid;
                                TOP: 1px;
                                WIDTH: 23px
                        }
                        .buttonOver {
                                BACKGROUND-COLOR: buttonface;
                                BORDER-BOTTOM: buttonshadow 1px solid;
                                BORDER-LEFT: buttonhighlight 1px solid;
                                BORDER-RIGHT: buttonshadow 1px solid;
                                BORDER-TOP: buttonhighlight 1px solid;
                                WIDTH: 23px
                        }
                        .buttonDown {
                                BACKGROUND-COLOR: buttonface;
                                BORDER-BOTTOM: buttonhighlight 1px solid;
                                BORDER-LEFT: buttonshadow 1px solid;
                                BORDER-RIGHT: buttonhighlight 1px solid;
                                BORDER-TOP: buttonshadow 1px solid;
                                WIDTH: 23px
                        }
                        .icon {
                                BORDER-LEFT: buttonface 1px solid;
                                BORDER-TOP: buttonface 1px solid;
                                BORDER-RIGHT: buttonface 1px solid;
                                BORDER-BOTTOM: buttonface 1px solid;
                                WIDTH: 22px
                        }
                        .iconDown {
                                BORDER-LEFT: buttonface 2px solid;
                                BORDER-TOP: buttonface 2px solid;
                                BORDER-RIGHT: buttonface 0px solid;
                                BORDER-BOTTOM: buttonface 0px solid;
                        }
                        .handle {
                                BACKGROUND-COLOR: buttonface;
                                BORDER-LEFT: buttonhighlight 1px solid;
                                BORDER-RIGHT: buttonshadow 1px solid;
                                BORDER-TOP: buttonhighlight 1px solid;
                                FONT-SIZE: 1px;
                                HEIGHT: 22px;
                                WIDTH: 3px
                        }
                        .sep {
                                BORDER-LEFT: buttonshadow 1px solid;
                                BORDER-RIGHT: buttonhighlight 1px solid;
                                FONT-SIZE: 0px;
                                HEIGHT: 22px;
                                WIDTH: 1px
                        }
                </STYLE>
                <script LANGUAGE="JavaScript">
                //variable check
                if(parent.window.opener.name != "editor"){
                  alert(parent.window.opener.name);
                  window.parent.location='http://localhost';
                  }
                     //variables for modal dialogbox
                        var arr;
                        var alt;

                        //Button states
                        function buttonOver() {
                                if (event.srcElement.tagName != "IMG")
                                        return false;
                                 var eButton = event.srcElement.parentElement;
                                eButton.className = "buttonOver";
                        }
                        function buttonOut(eButton) {
                                if (event.srcElement.tagName != "IMG")
                                        return false;
                                 var eButton = event.srcElement.parentElement;
                                eButton.className = "button";
                        }
                        function buttonDown(eButton) {
                                if (event.srcElement.tagName != "IMG")
                                        return false;
                                var icon  = event.srcElement;
                                var frame =        icon.parentElement;
                                frame.className = "buttonDown";
                                icon.className         = "iconDown";
                        }
                        function buttonUp(eButton) {
                                if (event.srcElement.tagName != "IMG")
                                        return false;
                                var icon  = event.srcElement;
                                var frame =        icon.parentElement;
                                frame.className = "button";
                                icon.className         = "icon";
                        }

                        //Initialize buttons
                        function InitBtn(btn) {
                                btn.onmouseover = buttonOver;
                                  btn.onmouseout  = buttonOut;
                                  btn.onmousedown = buttonDown;
                                 btn.onmouseup         = buttonUp;
                          return true;
                        }

                        //Support functions:
                        function isHTMLMode() {
                                if (HTMLMode) {
                                        alert("Please uncheck 'Edit HTML'");
                                        return false;
                                }
                                else {
                                        return true;
                                }
                        }

                        //Run inbuild editor functions
                        function cmdExec(cmd,opt) {
                                  if (!isHTMLMode())
                                          return;

                    editArea.document.execCommand(cmd,"",opt);
                                editArea.focus();
                        }

                        //Other editor functions
                        function insertImage() {

                                  if (!isHTMLMode())
                                          return;
                                var url =  "in(cgiurl)?command=showuploadEditor&database=in(database)";
                                h=250;
                                w=450;
                                newWindow = window.open(url,'upload','width='+w+',height='+h+',top='+(screen.height-h)/2+',left='+(screen.width-w)/2+',location=no,directories=no,status=no,menuBar=no,scrollBars=no,resizable=no');
                                newWindow.focus();

                        }


                        function createLink() {
                                  if (!isHTMLMode())
                                          return;
                                var url =  "in(htmlurl)/t_add_href.htm";
                                h=250;
                                w=450;
                                newWindow = window.open(url,'upload','width='+w+',height='+h+',top='+(screen.height-h)/2+',left='+(screen.width-w)/2+',location=no,directories=no,status=no,menuBar=no,scrollBars=no,resizable=no');
                                newWindow.focus();
                        }


                        function createLinkOLD() {
                                  if (!isHTMLMode())
                                          return;

                                  var str  = prompt("Enter URL :", "http:\/\/");

                                  if ((str!=null) && (str!="http://")) {
                                    if (editArea.document.selection.type=="None") {
                                                  var name = prompt("Enter link name :", "");
                                              var sel=editArea.document.selection.createRange();
                                                if(!name)
                                                        name = str;

                                                sel.pasteHTML("<A HREF=\""+str+"\">"+name+"</A> ");
                                              sel.select();
                                                  editArea.focus();
                                    }
                                    else
                                            cmdExec("CreateLink",str);
                                }
                                  else
                                          editArea.focus();
                        }

                        function storeDoc() {
                                  if (!isHTMLMode())
                                          return;
                                  if(in(bodyMode)){
                                  var s = editArea.document.body.outerHTML;
                                  s = s.replace(/\<\/*XMP\>/gi, "");
                                  parent.window.opener.form1.in(fld).value = s;
                                  }
                                  else{
                                  var s = editArea.document.body.innerHTML;
                                  s = s.replace(/\<\/*XMP\>/gi, "");
                                parent.window.opener.form1.in(fld).value = s;
                                  }
                                window.close();
                        }

                        function cleanDoc() {
                                  var conf=confirm("Warning!\nThis will clean the whole document")
                                  if (conf)
                                        editArea.document.body.innerHTML = "";
                                  editArea.focus();
                        }

                        function cancelAllChanges() {
                                  if (!isHTMLMode())
                                          return;

                                var conf=confirm("Warning!\nThis will undo all document changes !")
                                if (conf)
                                editArea.document.body.innerHTML=preLoadedDoc;
                                editArea.focus();
                        }

                        function foreColor() {
                                  if (!isHTMLMode())
                                          return;
                                  var arr = showModalDialog("in(htmlurl)/selcolor.html", "", "dialogWidth:22em; dialogHeight:23em" );
                                  if (arr != null)
                                          cmdExec('ForeColor',arr);
                                editArea.focus();
                        }

                        function backColor() {
                                  if (!isHTMLMode())
                                          return;
                                  var arr = showModalDialog("in(htmlurl)/selcolor.html", "", "dialogWidth:22em; dialogHeight:23em" );
                                  if (arr != null)
                                          editArea.document.bgColor = arr;
                                editArea.focus();
                        }

                        //switch between HTML mode and Text mode
                   function setMode(bMode) {
                     var sTmp;
                       HTMLMode = bMode;
                                if (HTMLMode){
                         sTmp=editArea.document.body.innerHTML;
                           editArea.document.body.innerText=sTmp;
                 }
                 else {
                         sTmp=editArea.document.body.innerText;
                            editArea.document.body.innerHTML=sTmp;
                 }
                 editArea.focus();
                        }

                        //Initialize Editor
                        function init() {
                                //global variables
                                HTMLMode                 = false;
                                preLoadedDoc = parent.window.opener.form1.in(fld).value;
                                if(!preLoadedDoc){
                                        preLoadedDoc = "   ";
                                        }
                                //initialize buttons
                                for (i=0; i<document.body.all.length; i++) {
                                    curr=document.body.all[i];
                                    if (curr.className == "button") {
                                              if (! InitBtn(curr)) {
                                                alert("Button: " + curr.id + " failed to initialize!");
                                              }
                                    }
                                }

                                //initialize edit window
                                editArea.document.open()
                                editArea.document.write(preLoadedDoc);
                                editArea.document.close()
                                editArea.document.designMode="On"
                                  setTimeout("editArea.focus()",0)
                        }

                </script>
<body onLoad='init();' bgcolor=silver>

<center>

<table bgcolor=silver  cellspacing=0 cellpadding=0 border=1 bordercolordark="white" bordercolorlight="black">
<tr>
<td>

<table bgcolor=silver cellspacing=2 cellpadding=0>
<tr>
        <td><div class="handle"></div></td>

        <td><div class="button" onClick="cleanDoc();">
                <img align=absmiddle src="in(htmlurl)/icons/new.gif"                 alt="Clean document"         class="icon">
        </div></td>

        <td><div class="button" onClick="cancelAllChanges();">
                <img align=absmiddle src="in(htmlurl)/icons/cancel.gif"         alt="Cancel all changes" class="icon">
        </div></td>

        <td> <div class="sep"></div></td>

        <td><div class="button" onClick="storeDoc()">
                <img align=absmiddle src="in(htmlurl)/icons/save.gif"                 alt="Store document"         class="icon">
        </div></td>

        <td> <div class="sep"></div></td>

        <td><div class="button" onClick="cmdExec('cut')">
                <img align=absmiddle src="in(htmlurl)/icons/cut.gif"         alt="Cut to clipboard"         class="icon">
        </div></td>

        <td><div class="button" onClick="cmdExec('copy')">
                <img align=absmiddle src="in(htmlurl)/icons/copy.gif"         alt="Copy to clipboard"  class="icon">
        </div></td>

        <td><div class="button" onClick="cmdExec('paste')">
                <img align=absmiddle src="in(htmlurl)/icons/paste.gif" alt="Paste to clipboard" class="icon">
        </div></td>

        <td> <div class="sep"></div></td>

        <td><div class="button" onClick="cmdExec('justifyleft')">
                <img align=absmiddle src="in(htmlurl)/icons/aleft.gif" alt="Align left" class="icon">
        </div></td>

        <td><div class="button" onClick="cmdExec('justifycenter')">
                <img align=absmiddle src="in(htmlurl)/icons/center.gif" alt="Center" class="icon">
        </div></td>

        <td><div class="button" onClick="cmdExec('justifyright')">
                <img align=absmiddle src="in(htmlurl)/icons/aright.gif" alt="Align right" class="icon">
        </div></td>

        <td> <div class="sep"></div></td>

        <td><div class="button" onClick="cmdExec('insertorderedlist')">
                <img align=absmiddle src="in(htmlurl)/icons/nlist.gif" alt="Numbered List" class="icon">
        </div></td>

        <td><div class="button" onClick="cmdExec('insertunorderedlist')">
                <img align=absmiddle src="in(htmlurl)/icons/blist.gif" alt="Bulletted List" class="icon">
        </div></td>

        <td> <div class="sep"></div></td>

        <td><div class="button" onClick="cmdExec('indent')">
                <img align=absmiddle src="in(htmlurl)/icons/iright.gif" alt="Increase Indent" class="icon">
        </div></td>

        <td><div class="button" onClick="cmdExec('outdent')">
                <img align=absmiddle src="in(htmlurl)/icons/ileft.gif" alt="Decrease Indent" class="icon">
        </div></td>

        <td> <div class="sep"></div></td>

        <td><div class="button" onClick="createLink();">
                <img align=absmiddle src="in(htmlurl)/icons/link.gif" alt="Insert link" class="icon">
        </div></td>

        <td><div class="button" onClick="insertImage()">
                <img align=absmiddle src="in(htmlurl)/icons/image.gif" alt="Insert lmage" class="icon">
        </div></td>

        <td><div class="button" onClick="cmdExec('InsertHorizontalRule')">
                <img align=absmiddle src="in(htmlurl)/icons/hr.gif" alt="Insert horizontal rule" class="icon">
        </div></td>

        <td> <div class="sep"></div></td>

         <td><div class="button" onclick="window.open('in(htmlurl)/help.html', 'helpwindow', 'width=250, height=300, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, copyhistory=no, resizable=yes')">
            <img align="absmiddle" src="in(htmlurl)/icons/help.gif" alt="Show help" class="icon">
          </div></td>

</tr>
</table>

</td>
</tr>
<tr>
<td>

<table bgcolor=silver cellspacing=2 cellpadding=0>
<tr>
        <td><div class="handle"></div></td>

        <td><div class="button" onClick="cmdExec('bold')">
                <img align=absmiddle src="in(htmlurl)/icons/bold.gif"         alt="Bold text"         class="icon">
        </div></td>

        <td><div class="button" onClick="cmdExec('italic')">
                <img align=absmiddle src="in(htmlurl)/icons/italic.gif" alt="Italic text"         class="icon">
        </div></td>

        <td><div class="button" onClick="cmdExec('underline')">
                <img align=absmiddle src="in(htmlurl)/icons/under.gif" alt="Underlined text"         class="icon">
        </div></td>

        <td> <div class="sep"></div></td>

        <td>
                <select onchange="cmdExec('fontname',this[this.selectedIndex].value);">
                        <option  selected>Font
                        <option value="Arial">Arial
                        <option value="Arial Black">Arial Black
                        <option value="Arial Narrow">Arial Narrow
                        <option value="Comic Sans MS">Comic Sans MS
                        <option value="Courier New">Courier New
                        <option value="System">System
                        <option value="Tahoma">Tahoma
                        <option value="Times New Roman">Times New Roman
                        <option value="Verdana">Verdana
                        <option value="Wingdings">Wingdings
                </select>
        </td>

        <td>
                <select ID="FontSize" onchange="cmdExec('fontsize',this[this.selectedIndex].value);">
                        <option selected>Size
                        <option value="1">1
                        <option value="2">2
                        <option value="3">3
                        <option value="4">4
                        <option value="5">5
                        <option value="6">6
                        <option value="7">7
                </select>
        </td>

        <td> <div class="sep"></div></td>

         <td><div class="button" onclick="backColor();">
            <img align="absmiddle" src="in(htmlurl)/icons/parea.gif" alt="Change background color" class="icon">
          </div></td>

         <td><div class="button" onclick="foreColor();">
            <img align="absmiddle" src="in(htmlurl)/icons/tpaint.gif" alt="Change foreground color" class="icon">
          </div></td>

</tr>
</table>

</td>
</tr>
<tr>
<td>
        <IFRAME width="750" ID="editArea" height="480"></IFRAME>
</td>
</tr>
<tr>
        <td>
                 <input type="checkbox" onclick="setMode(this.checked)"> <font face="verdana" size=2>Edit HTML</font>
        </td>
</tr>
</table>
<!--
                    <table border="1" cellpadding="5" cellspacing="0" bordercolorlight="#000000" bordercolordark="#FFFFFF" bgcolor="#C0C0C0" width="100%">
                      <tr>
                        <td width="100%" valign="middle" align="center">&nbsp;<INPUT CLASS="button2" type="button" value="-= Save =-" onClick="storeDoc()">
                        </td>
                      </tr>
                    </table>

-->
</center>

</body>

</html>

