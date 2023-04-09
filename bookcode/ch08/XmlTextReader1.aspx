<!-- Chapter8\xmlTextReader1.aspx -->
<%@ Page Language = "VB" Debug ="True" %>
<%@ Import Namespace="System.Xml" %>
<Script runat="server">
Sub Page_Load(sender As Object, e As EventArgs)
	Dim myRdr As New XmlTextReader(Server.MapPath("Catalog2.xml"))
	Dim i As Integer
	While myRdr.Read()
	    Response.Write(myRdr.NodeType.ToString() + " : " + myRdr.Name _ 
	                                 +  ": " + myRdr.Value + "<br/>")
		If  myRdr.HasAttributes Then
			For i = 0 To myRdr.AttributeCount - 1
				myRdr.MoveToAttribute(i)
				Response.Write(myRdr.NodeType.ToString() + " : "+ myRdr.Name _
				                            + ": " + myRdr.Value + "</br>")
			Next i
			myRdr.MoveToElement()
		End If
	End While
	myRdr.Close() 
End Sub
</Script>
				