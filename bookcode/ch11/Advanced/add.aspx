<%--
vb_xml guestbook 
Jontohon Ortiz
Xnext, Inc.
--%>

<%--
all right, let's setup the basic namespaces that we
are going to use. 

System: handle basic ints, etc. etc.
System.IO: handle file open, file close
System.Data: handle other fun stuff
--%>

<%@ Page Language="VB" EnableSessionState="False"%>
<%@ Import Namespace="System" %>
<%@ Import Namespace="System.IO" %>
<%@ Import Namespace="System.Data" %>
<html>
<head>
<title>Add Entry</title>
<link rel="stylesheet" href="script/blog.css" type="text/css">
</head>
<script language="VB" runat="server" >
		
		Sub AddClick(Sender As Object, E As EventArgs)
			
			Try
					Dim dataFile as String = "gb/gbook.xml"
					Dim fin as New FileStream  (Server.MapPath(dataFile),FileMode.Open,FileAccess.Read,FileShare.ReadWrite)
					Dim fout as New FileStream (Server.MapPath(dataFile),FileMode.Open,FileAccess.Write,FileShare.ReadWrite)
					Dim guestData as New DataSet()
					Dim newRow as DataRow
															
					err.Text = ""
					guestData.ReadXml(fin)
					fin.Close()
					newRow = guestData.Tables(0).NewRow()
					newRow("Name")=Name.Text
					newRow("Emoticon")=Emoticon.Value
					newRow("Email")=Email.Text
					newRow("Comments")=Comments.Text
					newRow("Chrono")=DateTime.Now.ToString()
					guestData.Tables(0).Rows.Add(newRow)
					guestData.WriteXml(fout, XmlWriteMode.WriteSchema)
					fout.Close()
					pnlAdd.Visible=false
					pnlThank.Visible=true
					
			Catch edd As Exception
        		err.Text="XML File Error: " & edd.ToString()
			
			End Try

		End Sub
</script>
	
	</head>
	
<body topmargin="0" leftmargin="0" rightmargin="0" marginwidth="0" marginheight="0" bgcolor="#336699">
<br>
	
<h3 align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">Add 
  Entry</font></h3>
	<br>
	<asp:label id="err" text="" style="color:#FF0000" runat="server" />
<asp:Panel id=pnlAdd runat=server>
	<form action="add.aspx" runat=server>
  <table border="1"  width="500" align="center" bordercolor="#000000" cellpadding="2" cellspacing="0">
    <tr> 
      <td class="items"><b><font color="#FFFFFF" class="sign">Sign-in My GuestBook</font></b></td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td class="sign"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif" size="2">Name 
        :</font></td>
      <td ><asp:textbox text="" id="Name" runat="server" /><asp:RequiredFieldValidator ControlToValidate=Name display=static runat=server> 
        *</asp:RequiredFieldValidator></td>
    </tr>
    <tr> 
      <td class="sign"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif" size="2">Mood 
        :</font></td>
      <td> 
        <select id="Emoticon" runat="server" name="select">
          <option value="01.gif">Happy</option>
          <option value="02.gif">Sad</option>
          <option value="03.gif">Cute</option>
          <option value="04.gif">Ugly</option>
        </select>
      </td>
    </tr>
    <tr> 
      <td class="sign"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif" size="2">E-Mail 
        :</font></td>
      <td><asp:textbox test="" id="Email" runat="server"/><asp:RequiredFieldValidator ControlToValidate=Email display=static runat=server> 
        *</asp:RequiredFieldValidator><asp:RegularExpressionValidator  runat="server"
            ControlToValidate="Email"
            ValidationExpression="[\w-]+@([\w-]+\.)+[\w-]+"
            Display="Static"
            Font-Name="verdana" Font-Size="10pt">Please enter a valid e-mail address</asp:RegularExpressionValidator></td>
    </tr>
    <tr> 
      <td class="sign"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif" size="2">Comments 
        :</font></td>
      <td><asp:Textbox textmode=multiline id="Comments" columns="25" rows="4" runat="server" /></td>
    </tr>
    <tr> 
      <td colspan="2"><asp:Button Text="Submit" onClick="AddClick" runat="server" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</asp:Panel> <asp:Panel id=pnlThank visible=false runat=server> 
<p align=center><b><font color="#FFFFFF" face="Arial, Helvetica, sans-serif" size="2"><img src="img/ty.gif" width="150" height="150"><br>
  Thank you for posting in my Guestbook!</font></b><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><br>
  <a href="view.aspx">Click here </a> <font size="2">to view GuestBook. <br>
  </font></font></p>
</asp:Panel> 
</body>
</html>		