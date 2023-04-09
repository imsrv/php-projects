<%@ Page Language = "VB" Debug="true" %>
<%@ Import Namespace="System.IO" %> 
<%@ Import Namespace="System.Data" %> 
<html>
<link rel="stylesheet" href="script/gbook.css" type="text/css">
 
<script language="VB" runat="server"> 
Sub Page_Load(Src As Object, E As EventArgs) 
        Dim ds As New DataSet 
        Dim FS As New FileStream(Server.MapPath("gb\gbook.xml"), FileMode.Open) 
        ds.ReadXml(FS) 
        gbook.DataSource = ds.Tables(0).DefaultView
        gbook.DataBind() 
        FS.close() 
End Sub 
</script> 

<body bgcolor="#336699">
<h3><font face="Arial, Helvetica, sans-serif" color="#FFFFFF">View Advanced Guestbook</font></h3> 

 <ASP:Repeater id="gbook" runat="server">

	<headertemplate>      
	<table width = "350" style="font: 12pt Arial" border="1" bordercolor="#000000" cellspacing="0" cellpadding="2">
	</headertemplate>
  
  <itemtemplate> 
  <tr> 
    <td class="info">
	<img src="img/<%# DataBinder.Eval(Container.DataItem, "Emoticon") %>" align="absmiddle"> 
    <%# DataBinder.Eval(Container.DataItem, "Name") %>
    <%# DataBinder.Eval(Container.DataItem, "Chrono") %>
	</td>
  </tr>
  <tr>
    <td>
    <a href="mailto: <%# DataBinder.Eval(Container.DataItem, "Email") %>">
    <%# DataBinder.Eval(Container.DataItem, "Email") %>
    </a>
	</td>
  </tr>
  <tr>
    <td class="msg"> 
    <%# DataBinder.Eval(Container.DataItem, "Comments") %>
	</td>
  </tr>
  </itemtemplate>
  <footertemplate>

</table>
        
  </footertemplate>
  </ASP:Repeater>
 <br>
</body> 
</html> 