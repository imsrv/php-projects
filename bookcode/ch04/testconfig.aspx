<html>

<script language="VB" runat="server">

Public tblBack As String = ""
Public tblFore As String = ""

    Sub Page_Load(source As Object, E As EventArgs)
        dim config As NameValueCollection=ConfigurationSettings.GetConfig("testConfig.group/mainAppSettings")

        dim strTblBack as string = config("tableBackgroundColor")
        dim strTblFore as string = config("tableForegroundColor")

        if strTblBack <> nothing then  
           tblBack=strTblBack
        else
           tblBack="lightgreen"
        end if
   
        if strTblFore <> nothing then  
           tblFore=strTblFore
        else
           tblFore="purple"
        end if

    End Sub

</script>

<head>
<title>Test Configuration</title>
</head>
<body>
<table border=1 bgcolor=<%=tblBack%> bordercolor=<%=tblFore%>>
    <tr>
        <td>Some</td>
        <td>Important</td>
        <td>Data</td>
    </tr>
    <tr>
        <td>Some</td>
        <td>More</td>
        <td>Data</td>
    </tr>
</table>
</body>
</html>
