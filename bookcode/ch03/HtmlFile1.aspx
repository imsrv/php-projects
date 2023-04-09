<!-- HtmlFile1.aspx --><html><head></head>
 <h3>Using Html File Control</h3>
 <form enctype="multipart/form-data" runat="server">
 Select a file to upload: 
 <input type="file" id="fileControl"  runat="server"><br>
      Save as: (Just the name only please): 
       <input id="txtTargetName" type="text" runat="server"><br>
       <input type=button  id="btnLoad" value="Upload" 
              OnServerClick="btnLoad_Click" runat="server"><br>
        <span id=span1 runat="server" /><br>
 </form></html>

<script language="VB" runat="server">
       Sub btnLoad_Click(s As Object, e As EventArgs)
            If txtTargetName.Value = "" Then
                span1.InnerHtml = "Error: you must enter a file name"
                Return
            End If
            If Not (fileControl.PostedFile Is Nothing) Then
                Try
                    fileControl.PostedFile.SaveAs(("c:\temp\" + txtTargetName.Value))
                    span1.InnerHtml = "Done: File loaded to <b>c:\temp\" & _
                                    txtTargetName.Value & "</b> on the Web server"
                Catch err As Exception
                    span1.InnerHtml = "Error saving file <b>c:\temp\" & _
                                    txtTargetName.Value & "</b><br>" & err.ToString()
                End Try
            End If
        End Sub  
    </script>
 