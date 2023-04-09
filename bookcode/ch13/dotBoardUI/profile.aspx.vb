Public Class profile
    Inherits FormBase
    Protected WithEvents Label1 As System.Web.UI.WebControls.Label
    Protected WithEvents txtFirstName As System.Web.UI.WebControls.TextBox
    Protected WithEvents Label2 As System.Web.UI.WebControls.Label
    Protected WithEvents txtLastname As System.Web.UI.WebControls.TextBox
    Protected WithEvents Label3 As System.Web.UI.WebControls.Label
    Protected WithEvents txtNewPassword As System.Web.UI.WebControls.TextBox
    Protected WithEvents Label4 As System.Web.UI.WebControls.Label
    Protected WithEvents txtConfirmNewPassword As System.Web.UI.WebControls.TextBox
    Protected WithEvents Label5 As System.Web.UI.WebControls.Label
    Protected WithEvents txtEmailAddress As System.Web.UI.WebControls.TextBox
    Protected WithEvents btnUpdate As System.Web.UI.WebControls.Button
    Protected WithEvents valFirstName As System.Web.UI.WebControls.RequiredFieldValidator
    Protected WithEvents valLastName As System.Web.UI.WebControls.RequiredFieldValidator
    Protected WithEvents valEmailAddress As System.Web.UI.WebControls.RequiredFieldValidator
    Protected WithEvents valEmailAddress2 As System.Web.UI.WebControls.RegularExpressionValidator
    Protected WithEvents valPasswords As System.Web.UI.WebControls.CompareValidator
    Protected WithEvents ValidationSummary1 As System.Web.UI.WebControls.ValidationSummary
    Protected WithEvents lblMessage As System.Web.UI.WebControls.Label
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
        If Me.IsLoggedIn = False Then
            'only logged in users can access this site
            Response.Redirect("default.aspx")
        End If

        If Page.IsPostBack = False Then
            txtFirstName.Text = Me.CurrentUser.FirstName
            txtLastname.Text = Me.CurrentUser.LastName
            txtEmailAddress.Text = Me.CurrentUser.Email
        End If

        Me.ApplyStyles(Me.Controls)
    End Sub

    Private Sub btnUpdate_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnUpdate.Click
        If Page.IsValid Then
            If txtNewPassword.Text.Trim() <> "" Then
                Me.CurrentUser.Password = txtNewPassword.Text
            End If
            Me.CurrentUser.FirstName = txtFirstName.Text
            Me.CurrentUser.LastName = txtLastname.Text
            Me.CurrentUser.Email = txtEmailAddress.Text
            Me.CurrentUser.Update()
            lblMessage.Visible = True
        End If
    End Sub
End Class
