Public Class board
    Inherits FormBase
    Protected WithEvents Repeater1 As System.Web.UI.WebControls.Repeater
    Protected WithEvents Panel1 As System.Web.UI.WebControls.Panel
    Protected WithEvents LinkButton1 As System.Web.UI.WebControls.LinkButton
    Protected WithEvents lblHeader As System.Web.UI.WebControls.Label


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
        Dim mBoard As dotBoardObjects.board
        Dim boardId As String
        boardId = Request.QueryString.Item("boardid")

        Dim myLabel As Label
        myLabel = CType(Me.FindControl("lblHeader"), Label)
        myLabel.Text = boardId

        mBoard = New dotBoardObjects.board(boardId)

        Dim myThreads As DataSet
        myThreads = New DataSet()
        myThreads.Tables.Add("threads")

        Dim myTable As DataTable
        myTable = myThreads.Tables(0)

        myTable.Columns.Add("threadLink", GetType(String))
        myTable.Columns.Add("threadSubject", GetType(String))
        myTable.Columns.Add("postCount", GetType(Integer))
        myTable.Columns.Add("creatorName", GetType(String))

        Dim i As Integer
        For i = 0 To mBoard.ChildThreads.Count - 1
            Dim myThread As dotBoardObjects.Thread
            myThread = mBoard.ChildThreads.Item(i)

            Dim fields(3) As Object
            fields(0) = "BoardId=" & boardId & _
                "&ThreadId=" & myThread.ID.ToString()
            fields(1) = myThread.Subject
            If Me.IsLoggedIn = True Then
                If Me.CurrentUser.IsAdmin = True Then
                    fields(1) &= "<br><br><a href='deleteThread.aspx?" & _
                        "boardName=" & mBoard.Name & _
                        "&threadId=" & myThread.ID.ToString() & _
                        "'>&gt;&gt;delete</a>"
                End If
            End If
            fields(2) = myThread.ChildPosts.Count
            fields(3) = myThread.Creator.Username

            myTable.Rows.Add(fields)
            myTable.AcceptChanges()
        Next i

        myThreads.AcceptChanges()

        Repeater1.DataMember = "threads"
        Repeater1.DataSource = myThreads
        Repeater1.DataBind()

        Me.ApplyStyles(Me.Controls)

        If Me.IsLoggedIn = False Then
            LinkButton1.Visible = False
        End If
    End Sub

    Private Sub LinkButton1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles LinkButton1.Click
        Dim boardId As String
        boardId = Request.QueryString.Item("boardid")
        Response.Redirect("createPost.aspx?boardName=" & boardId)
    End Sub
End Class
