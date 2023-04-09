Public Class thread
    Inherits FormBase
    Protected WithEvents lblHeaderThread As System.Web.UI.WebControls.Label
    Protected WithEvents Repeater1 As System.Web.UI.WebControls.Repeater
    Protected WithEvents Panel1 As System.Web.UI.WebControls.Panel
    Protected WithEvents LinkButton1 As System.Web.UI.WebControls.LinkButton
    Protected WithEvents lblHeaderBoard As System.Web.UI.WebControls.Label

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
        Dim boardId As String
        Dim threadId As Long

        boardId = Request.QueryString.Item("boardId")
        threadId = CLng(Request.QueryString.Item("threadId"))

        Dim myBoard As dotBoardObjects.board
        myBoard = New dotBoardObjects.board(boardId)

        Dim myThread As dotBoardObjects.thread
        myThread = myBoard.ChildThread(threadId)

        lblHeaderBoard.Text = myBoard.Name
        lblHeaderThread.Text = myThread.Subject

        Dim myPosts As DataSet
        myPosts = New DataSet()
        myPosts.Tables.Add("posts")

        Dim myTable As DataTable
        myTable = myPosts.Tables(0)

        myTable.Columns.Add("postId", GetType(Long))
        myTable.Columns.Add("postSubject", GetType(String))
        myTable.Columns.Add("postBody", GetType(String))
        myTable.Columns.Add("postDate", GetType(Date))
        myTable.Columns.Add("postCreatorName", GetType(String))
        myTable.Columns.Add("postCreatorEmail", GetType(String))

        Dim i As Integer
        For i = 0 To myThread.ChildPosts.Count - 1
            Dim myPost As dotBoardObjects.Post
            myPost = myThread.ChildPosts.Item(i)

            Dim fields(5) As Object
            fields(0) = myPost.ID
            fields(1) = myPost.Subject
            fields(2) = myPost.Body
            If Me.IsLoggedIn = True Then
                If Me.IsLoggedIn = True Then
                    fields(2) &= "<br><br><a href='deletePost.aspx?" & _
                        "boardName=" & myBoard.Name & _
                        "&threadId=" & myThread.ID.ToString() & _
                        "&postId=" & myPost.ID.ToString() & _
                        "'>&gt;&gt;delete</a>"
                    fields(2) &= "&nbsp;&nbsp;&nbsp;" & _
                        "<a href='editPost.aspx?" & _
                        "boardName=" & myBoard.Name & _
                        "&threadId=" & myThread.ID.ToString() & _
                        "&postId=" & myPost.ID.ToString() & _
                        "'>&gt;&gt;edit</a>"
                End If
            End If
            fields(3) = myPost.PostDate
            fields(4) = myPost.Creator.Username
            If Me.IsLoggedIn = True Then
                fields(5) = "<a href='mailto:" & myPost.Creator.Email & _
                    "'>email</a>"
            Else
                fields(5) = ""
            End If

            myTable.Rows.Add(fields)
            myTable.AcceptChanges()
        Next i

        myPosts.AcceptChanges()

        Repeater1.DataMember = "posts"
        Repeater1.DataSource = myPosts
        Repeater1.DataBind()

        Me.ApplyStyles(Me.Controls)
    End Sub

    Private Sub LinkButton1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles LinkButton1.Click
        Dim boardId As String
        Dim threadId As Long

        boardId = Request.QueryString.Item("boardId")
        threadId = CLng(Request.QueryString.Item("threadId"))

        Response.Redirect("createPost.aspx?boardName=" & boardId & _
            "&threadId=" & threadId.ToString())
    End Sub
End Class
