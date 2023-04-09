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
	<body topmargin="0" leftmargin="0" rightmargin="0" marginwidth="0" marginheight="0">
	<br>
	<h3 align="center">Guestbook Post Page.</h3>
	<br>
	<asp:label id="err" text="" style="color:#FF0000" runat="server" />
<asp:Panel id=pnlAdd runat=server>
	<form action="add.aspx" runat=server>	
		<table border="0"  width="80%" align="Center">
			<tr>
				<td><b>Sign-in My GuestBook</b></td>
				<td>&nbsp;</td>
				
			</tr>
			<tr>
				<td>Name :</td>
				<td ><asp:textbox text="" id="Name" runat="server" /><asp:RequiredFieldValidator ControlToValidate=Name display=static runat=server>
*</asp:RequiredFieldValidator></td>
				
			</tr>

			<tr>
				<td>E-Mail :</td>
				<td><asp:textbox test="" id="Email" runat="server"/><asp:RequiredFieldValidator ControlToValidate=Email display=static runat=server>
*</asp:RequiredFieldValidator><asp:RegularExpressionValidator  runat="server"
            ControlToValidate="Email"
            ValidationExpression="[\w-]+@([\w-]+\.)+[\w-]+"
            Display="Static"
            Font-Name="verdana" Font-Size="10pt">Please enter a valid e-mail address</asp:RegularExpressionValidator></td>
				
			</tr>
			<tr>
				<td>Comments :</td>
				<td><asp:Textbox textmode=multiline id="Comments" columns="25" rows="4" runat="server" /></td>
				
			</tr>
			<tr>
				<td colspan="2" >
				<asp:Button Text="Submit" onClick="AddClick" runat="server" /></td>
				
			</tr>
		</table>
	</form></asp:Panel>

<asp:Panel id=pnlThank visible=false runat=server>
<p align=center><b>Thank you for posting in my Guestbook!</b><br>
  <a href="view.aspx">Click here </a> to view GuestBook.
</p>
</asp:Panel>
</body>
</html>