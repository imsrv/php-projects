Public Class createboard
    Inherits FormBase
    Protected WithEvents Label1 As System.Web.UI.WebControls.Label
    Protected WithEvents txtBoardName As System.Web.UI.WebControls.TextBox
    Protected WithEvents Label2 As System.Web.UI.WebControls.Label
    Protected WithEvents txtBoardDescription As System.Web.UI.WebControls.TextBox
    Protected WithEvents btnCreate As System.Web.UI.WebControls.Button
    Protected WithEvents valName As System.Web.UI.WebControls.RequiredFieldValidator
    Protected WithEvents valDescription As System.Web.UI.WebControls.RequiredFieldValidator
    Protected WithEvents ValidationSummary1 As System.Web.UI.WebControls.ValidationSummary
    Protected WithEvents Panel1 As System.Web.UI.WebControls.Panel

#Region " Web Form Designer Generated Code "

    'This call is required by the Web Form Designer.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()

    End Sub

    Private Sub Page_Init(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Init
        'CODEGEN: This method call is required by the Web Form Designer
        'Do not modify it using the code editor.
        InitializeComponent()
    End Sub

#End Region

    Private Sub Page_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        'only logged-in admins can enter this page
        If Me.IsLoggedIn = False Then
            Response.Redirect("default.aspx")
        ElseIf Me.CurrentUser.IsAdmin = False Then
            Response.Redirect("default.aspx")
        End If
    End Sub

    Private Sub btnCreate_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnCreate.Click
        If Me.IsValid = True Then
            'create the new board
            dotBoardObjects.Board.CreateBoard(txtBoardName.Text, _
                txtBoardDescription.Text, _
                Me.CurrentUser)
            Response.Redirect("default.aspx")
        End If
    End Sub
End Class
