Public Class admin
    Inherits FormBase
    Protected WithEvents Label1 As System.Web.UI.WebControls.Label
    Protected WithEvents dlUsers As System.Web.UI.WebControls.DropDownList
    Protected WithEvents lnkChooseUser As System.Web.UI.WebControls.LinkButton
    Protected WithEvents Panel1 As System.Web.UI.WebControls.Panel
    Protected WithEvents btnModify As System.Web.UI.WebControls.Button
    Protected WithEvents rblAdmin As System.Web.UI.WebControls.RadioButtonList
    Protected WithEvents rblBanned As System.Web.UI.WebControls.RadioButtonList
    Protected WithEvents pnlUsers As System.Web.UI.WebControls.Panel

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
        'get the users bound to the drop down list
        If Not Me.IsPostBack Then
            Dim myUsers As DataSet
            Dim sql As String
            sql = "SELECT UserID, UserName FROM Users"
            myUsers = dotBoardObjects.DataControl.GetDataSet(sql)
            dlUsers.DataTextField = "Username"
            dlUsers.DataValueField = "UserID"
            dlUsers.DataMember = "data"
            dlUsers.DataSource = myUsers
            dlUsers.DataBind()
        End If
        Me.ApplyStyles(Me.Controls)
    End Sub

    Private Sub lnkChooseUser_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lnkChooseUser.Click
        Dim userID As Long
        userID = CLng(dlUsers.SelectedItem.Value)
        Dim myUser As dotBoardObjects.User
        myUser = New dotBoardObjects.User(userID)

        If myUser.IsBanned = True Then
            rblBanned.Items(1).Selected = True
        Else
            rblBanned.Items(0).Selected = True
        End If

        If myUser.IsAdmin = True Then
            rblAdmin.Items(0).Selected = True
        Else
            rblAdmin.Items(1).Selected = True
        End If

        rblBanned.Visible = True
        rblAdmin.Visible = True

        Panel1.Visible = True
    End Sub

    Private Sub btnModify_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnModify.Click
        Dim userID As Long
        userID = CLng(dlUsers.SelectedItem.Value)
        Dim myUser As dotBoardObjects.User
        myUser = New dotBoardObjects.User(userID)

        'we now have the user, so let's set his admin/banned properties
        If rblBanned.Items(0).Selected = True Then
            'the user is not banned
            myUser.IsBanned = False
        Else
            myUser.IsBanned = True
        End If

        If rblAdmin.Items(0).Selected = True Then
            'the user is an admin
            myUser.IsAdmin = True
        Else
            myUser.IsAdmin = False
        End If

        myUser.Update()
    End Sub
End Class
