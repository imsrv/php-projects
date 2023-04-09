<!-- Chapter8\XmlTextWriter1.aspx -->
<%@ Page Language="VB" Debug="True"%>
<%@ Import Namespace="System.Xml"%>
<HTML><HEAD><title>XMLTextWriter Example</title></HEAD>
<body><form runat="server">
<b>XmlTextWriter Example</b><br/><br/>
<asp:Label id="lblAcno" Text="Account Number :" runat="server"/>&nbsp;&nbsp;
<asp:TextBox id="txtAcno" runat="server" width="50" text=" ST124" /><br/>
<asp:Label id="lblName" Text="Name :" runat="server" />&nbsp;&nbsp;
<asp:TextBox id="txtName" runat="server" width="100" text="Vijay Ananth"/><br/>
<asp:Label id="lblCity" Text="City :" runat="server"/>&nbsp;&nbsp;
<asp:TextBox id="txtCity" runat="server" width="100" text="Toledo"/><br/>
<asp:Button id="cmdWriteXML" Text="Create XML File" runat="server"  onclick="writeXML"/>
<br>	</form>
		
<Script Language="vb" runat="server">

Sub writeXML(sender As Object,e As EventArgs)
   Dim myWriter As New XmlTextWriter _
                     (Server.MapPath("Customer.xml"), Nothing)
   myWriter.Formatting = Formatting.Indented
   myWriter.WriteStartDocument()     'Starts a new document 
   ' Write the Comment
   myWriter.WriteComment("XMLTextWriter Example")
   ' Insert an Start element tag
   myWriter.WriteStartElement("CustomerDetails")
   ' Write an attribute
   myWriter.WriteAttributeString("AccountType", "Saving")
   ' Write the Account element and its content
   myWriter.WriteStartElement("AccountNumber","")
   myWriter.WriteString(txtAcno.Text)
   myWriter.WriteEndElement()
   ' Write the Name Element and its data
   myWriter.WriteStartElement("Name","")
   myWriter.WriteString(txtName.Text)
   myWriter.WriteEndElement()
   'Write the City element and its data
   myWriter.WriteStartElement("City","")
   myWriter.WriteString(txtCity.Text)
   myWriter.WriteEndElement()

   'End all the tags here
   myWriter.WriteEndDocument()
		
   myWriter.Flush()
   myWriter.Close()
		        
   'Display the XML content on the screen
   Response.Redirect(Server.MapPath("Customer.xml"))

 End Sub
 
 </Script>
 </body>
 </HTML>