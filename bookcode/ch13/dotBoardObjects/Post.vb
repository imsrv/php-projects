Option Strict On

Public Class Post
    Private mPostID As Long
    Private mPostSubject As String
    Private mPostBody As String
    Private mCreator As User
    Private mPostDate As Date

    Public Sub New(ByVal myRow As DataRow)
        inflate(myRow)
    End Sub

    Public Sub Update(ByVal requestor As User)
        If requestor.ID = mCreator.ID Then
            Dim sql As String
            sql = "UPDATE [Posts] SET [PostSubject] = '" & _
                mPostSubject & "', [PostBody] = '" & mPostBody & _
                "' WHERE [PostID] = " & mPostID.ToString()
            DataControl.ExecuteNonQuery(sql)
        Else
            Throw New ArgumentException _
                ("Only the creator of a post can update it")
        End If
    End Sub

    Private Sub inflate(ByVal myRow As DataRow)
        mPostID = CLng(myRow("PostID"))
        mPostSubject = CStr(myRow("PostSubject"))
        mPostBody = CStr(myRow("PostBody"))
        mCreator = New User(myRow)
        mPostDate = CDate(myRow("PostDate"))
    End Sub

    Public ReadOnly Property ID() As Long
        Get
            Return mPostID
        End Get
    End Property

    Public Property Subject() As String
        Get
            Return mPostSubject
        End Get
        Set(ByVal Value As String)
            mPostSubject = Value
        End Set
    End Property

    Public Property Body() As String
        Get
            Return mPostBody
        End Get
        Set(ByVal Value As String)
            mPostBody = Value
        End Set
    End Property

    Public ReadOnly Property Creator() As User
        Get
            Return mCreator
        End Get
    End Property

    Public ReadOnly Property PostDate() As Date
        Get
            Return mPostDate
        End Get
    End Property
End Class
