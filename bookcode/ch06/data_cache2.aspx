<SCRIPT language="VB" runat=server>

Sub Page_Load(source As Object, e As EventArgs)
    dim MyValue as string
    MyValue=cache("MyKey")
    if MyValue <> nothing then  
       output.text=MyValue & "<P>This data retrieved from cache"
    else
       Dim StringArray() As string ={"Amy", "Bob", "Chris", "Dave", "Eli", "Franklin", "Gerald"}
       dim DependentString() as string ={server.mappath("partofmydata.xml"), server.mappath("theotherpart.xml")}
       dim MyString as string

       for each MyString in StringArray
          output.Text=output.Text & MyString & "<br>"
       next
       
       cache.insert("MyKey", output.text, new CacheDependency(DependentString))
    end if
End Sub
</SCRIPT>


<HTML>
<HEAD>
</HEAD>
<BODY>
    <P><asp:label id="output" runat="server"/>
</BODY>
</HTML>
