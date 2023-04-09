<!-- Chapter8\XSLT1.aspx -->
<%@ Page Language="VB" Debug="True"%>
<%@ Import Namespace="System.Xml"%>
<%@ Import Namespace="System.Xml.Xsl"%>
<html><head></head><body><form runat="server">
<b>XSL Transformation Example&nbsp;</b><br/>
<asp:Xml id="ourXSLTransform" runat="server" 
     DocumentSource="Bank3.xml" TransformSource="XSLT1.xsl"/>
</form></body></html>
