Public Class editPost
    Inherits FormBase
    Protected WithEvents lblHeaderBoard As System.Web.UI.WebControls.Label
    Protected WithEvents lblHeaderThread As System.Web.UI.WebControls.Label
    Protected WithEvents Panel1 As System.Web.UI.WebControls.Panel


    Private mBoard As dotBoardObjects.Board
    Private mThread As dotBoardObjects.Thread
    Private mBoardName As String
    Private mThreadID As Long
    Private mPostID As Long
    Private mPost As dotBoardObjects.Post
    Protected WithEvents txtSubject As System.Web.UI.WebControls.TextBox
    Protected WithEvents Label1 As System.Web.UI.WebControls.Label
    Protected WithEvents Label2 As System.Web.UI.WebControls.Label
    Protected WithEvents txtMessage As System.Web.UI.WebControls.TextBox
    Protected WithEvents btnEditPost As System.Web.UI.WebControls.Button
    Protected WithEvents valSubject As System.Web.UI.WebControls.RequiredFieldValidator
    Protected WithEvents valMessage As System.Web.UI.WebControls.RequiredFieldValidator


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

    Private Sub Page_Load(ByVal sender As System.Object, _
        ByVal e As System.EventArgs) Handles MyBase.Load
        'only logged in users are allow in this page
        If Me.IsLoggedIn = False Then
            Response.Redirect("default.aspx")
        ElseIf Me.CurrentUser.IsAdmin = False Then
            Response.Redirect("default.aspx")
        End If

        mBoardName = Request.Item("boardName")
        mThreadID = CLng(Request.Item("threadId"))
        mPostID = CLng(Request.Item("postId"))

        mBoard = New dotBoardObjects.board(mBoardName)
        mThread = mBoard.ChildThread(mThreadID)
        mPost = mThread.ChildPost(mPostID)

        lblHeaderBoard.Text = mBoard.Name
        lblHeaderThread.Text = mThread.Subject

        If Not Me.IsPostBack Then
            txtSubject.Text = mPost.Subject
            txtMessage.Text = mPost.Body
        End If

        Me.ApplyStyles(Me.Controls)
    End Sub

    Private Sub btnEditPost_Click(ByVal sender As System.Object, _
        ByVal e As System.EventArgs) Handles btnEditPost.Click
        If Me.IsValid Then
            mPost.Subject = txtSubject.Text
            mPost.Body = txtMessage.Text
            mPost.Update(Me.CurrentUser)
            Response.Redirect("thread.aspx?boardID=" & _
                mBoard.Name & "&threadId=" & _
                mThread.ID.ToString())
        End If
    End Sub
End Class
