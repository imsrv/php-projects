<SCRIPT language="VB" runat=server>

Sub Page_Load(source As Object, e As EventArgs)
    dim MyValue as string
    MyValue=cache("MyKey")
    if MyValue <> nothing then  
       output.text=MyValue & "<P>This data retrieved from cache"
    else
       Dim stringArray() As string ={"Amy", "Bob", "Chris", "Dave", "Eli", "Franklin", "Gerald"}
       dim MyString as string
       for each MyString in stringArray
          output.Text=output.Text & MyString & "<br>"
       next

       cache("MyKey")=output.Text
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
