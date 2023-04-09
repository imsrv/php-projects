<!-- Aspbook\Chapter8\xmlDom2.aspx -->
<%@ Page Language = "VB"  Debug ="True" %>
<%@ Import Namespace="System.Xml" %>
<Script Language="vb" runat="server">
Sub Page_Load(s As Object, e As EventArgs)
    If Not Page.IsPostBack Then
	 Dim myXmlDoc As New XmlDocument()
	 Dim myRdr As New XmlTextReader(Server.MapPath("Catalog2.xml"))
	 myRdr.WhitespaceHandling = WhitespaceHandling.None
	 myXmlDoc.Load (myRdr)
	 TravelDownATree(myXmlDoc.DocumentElement)
	 myRdr.Close()
	End If
End Sub
Sub TravelDownATree(tree As XMLNode)
	If Not IsNothing(tree) Then
	      DisplayNode(tree)
	End If
	If tree.HasChildNodes Then
	   tree = tree.FirstChild
	   While Not IsNothing(tree)
	        TravelDownATree(tree)
	        tree = tree.NextSibling
	   End While
    End If
End Sub
Sub DisplayNode(node As XmlNode)
     If Not node.HasChildNodes Then
         Response.Write( "Name= " + node.Name + " Type= " _
         + node.NodeType.ToString() + " Value=  " + node.Value + "<br/>")
     Else
         Response.Write("Name= " + node.Name + " Type= "  _ 
         + node.NodeType.ToString() + "<br/>")
         If node.NodeType = XmlNodeType.Element  Then
                Dim x As XmlAttribute
                For each x In node.Attributes
                     Response.Write("Name= " + x.Name  +  " Type = " _ 
                     + x.NodeType.ToString()  + " Value = " +  x.Value + "<br/>")
                Next
         End If
      End If   
 End Sub
</Script>
				