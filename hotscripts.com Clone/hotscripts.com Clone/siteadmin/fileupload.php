<html>
<head>
<Title>Select Image File for uploading</Title>

<script language="JavaScript">
function checkFile()
{
if (form1.userfile.value == "")
{
alert(" Please choose a file to upload");
return (false);
}
if (form1.userfile.value.indexOf(".jpg") == -1 &&form1.userfile.value.indexOf(".png") == -1 &&form1.userfile.value.indexOf(".bmp") == -1 &&form1.userfile.value.indexOf(".jpeg") == -1 && form1.userfile.value.indexOf(".gif") == -1)
{
alert(" Please upload .gif/.jpg/.jpeg/.bmp/.png files only");
form1.userfile.value="";
form1.userfile.focus();
return (false);
}
return(true);
}

</script>


</head>

<body>
<b><font size="3">Upload Image</font>.</b> 
<FORM ENCTYPE="multipart/form-data" ACTION="doupload.php?box=<?php echo $_REQUEST["box"]?>&func=2" METHOD=post ID=form1 NAME=form1 onSubmit="javscript:return checkFile(form1);"> 
<input type="hidden" name="id" value="<?php echo $_SESSION[ "username" ] ?>">
<input type="hidden" name="act" value="upload">
<table><tr><td>
<b><font size="3" color="#FFFFFF"><u><font color="#000000" size="2">Attachment</font></u></font></b> 
        <table>
          <tr> 
            <td valign="top" width="15"><font color="#000000">1.</font></td>
            <td width="470"><font color="#000000">To add an Attachment, click 
              the 'Browse' button to select the file to attach, or type the path 
              to the file in the Text-box below.</font></td>
          </tr>
          <tr> 
            <td valign="top" width="15"><font color="#000000">2.</font></td>
            <td width="470"><font color="#000000">Then click Upload button to 
              complete the upload</font></td>
          </tr>
          <tr> 
            <td valign="top" width="15"><font color="#000000">3.</font></td>
            <td width="470"><font color="#990000">NOTE</font><font color="#000000">: 
              The File transfer can take from a few seconds upto a few minutes 
              depending on the size of the attachment. Please be patient while 
              the attachment is being uploaded.</font></td>
          </tr>
          <tr> 
            <td valign="top" width="15"><font color="#000000">4.</font></td>
            <td width="470"><font color="#990000">NOTE</font><font color="#000000">: 
              The File will be renamed if the file with the same name is present</font></td>
          </tr>
        </table>
      </TD>
    </TR> 
<TR><TD><STRONG>Hit the [Browse] button to find the file on your computer.</STRONG><BR></TD></TR> 
<TR><TD><strong>Image</strong>
<INPUT NAME=userfile SIZE=30 TYPE=file   MaxFileSize="1000000"> 
<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
  </TD></TR>
  <TR><TD>&nbsp;</TD></TR>
  <TR><TD><input type="submit" value="Upload" name="uploadfile"></TD></TR>
<TR><TD>NOTE: Please be patient, you will not receive any notification until the 
file is completely transferred.<BR><BR></TD></TR>
</table>

</FORM>

   
<!--
<Script Language="JavaScript">
function listattach(filename)
{
window.opener.document.form123.<?php //request.QueryString("box") ?>.value=filename
window.close()
}
</script>
<Input type=button value=Done onClick="listattach('<?php //echo filename ?>')">
-->

</body>

</html>