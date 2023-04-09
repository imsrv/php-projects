Option Strict On

Public Class Thread
    Private mThreadID As Long
    Private mSubject As String
    Private mCreator As User
    Private myPosts As PostList

    Public Sub New(ByVal myRow As DataRow)
        inflate(myRow)
    End Sub

    Private Sub inflate(ByVal myRow As DataRow)
        mSubject = CStr(myRow("ThreadSubject"))
        mThreadID = CLng(myRow("ThreadID"))
        mCreator = New User(myRow)
        myPosts = New PostList(mThreadID)
    End Sub

    Public Sub CreatePost(ByVal subject As String, _
    ByVal body As String, _
        ByVal creator As User)

        Dim sql As String
        sql = "INSERT INTO [Posts] ([PostSubject], " & _
            "[PostBody], " & _
            "[CreatorID], [ThreadID]) VALUES ('" & subject & _
            "','" & body & "'," & creator.ID.ToString() & "," & _
            mThreadID.ToString() & ")"
        DataControl.ExecuteNonQuery(sql)

        'reinitialize the thread list
        myPosts.InitializePosts()
    End Sub

    Public ReadOnly Property ChildPost(ByVal postId As Long) As Post
        Get
            'lookup the correct Post
            Dim i As Integer
            For i = 0 To Me.ChildPosts.Count - 1
                Dim myPost As Post = Me.ChildPosts.Item(i)
                If myPost.ID = postId Then
                    Return myPost
                End If
            Next i
            'if we've gotten to this point, there is no Post
            'with that id in this board. throw an exception
            Throw New ArgumentException("Post does not exist")
        End Get
    End Property

    Public ReadOnly Property ChildPosts() As PostList
        Get
            Return myPosts
        End Get
    End Property

    Public ReadOnly Property ID() As Long
        Get
            Return mThreadID
        End Get
    End Property

    Public Property Subject() As String
        Get
            Return mSubject
        End Get
        Set(ByVal Value As String)
            mSubject = Value
        End Set
    End Property

    Public ReadOnly Property Creator() As User
        Get
            Return mCreator
        End Get
    End Property
End Class
