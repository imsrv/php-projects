Option Strict On

Public Class Board
    Private mBoardID As Long
    Private mName As String
    Private mDescription As String
    Private myThreads As ThreadList

    Public Sub New(ByVal name As String)
        Dim sql As String
        Dim myData As DataSet

        sql = "SELECT * FROM [Board] WHERE [BoardName] = '" & _
            name & "'"
        myData = DataControl.GetDataSet(sql)

        If myData.Tables(0).Rows.Count > 0 Then
            Me.inflate(myData.Tables(0).Rows(0))
        Else
            Throw New Exception("Board does not exist")
        End If
    End Sub

    Private Sub inflate(ByVal myRow As DataRow)
        mName = CStr(myRow("BoardName"))
        mDescription = CStr(myRow("BoardDescription"))
        mBoardID = CLng(myRow("BoardID"))

        myThreads = New ThreadList(mBoardID)
    End Sub

    Public Sub Update(ByVal requestor As User)
        If requestor.IsAdmin Then
            'update the database with this board's details
            Dim sql As String
            sql = "UPDATE [Board] SET [BoardName] = '" & mName & _
                "', BoardDescription = '" & mDescription & _
                " WHERE [BoardID] = " & mBoardID.ToString()
            DataControl.ExecuteNonQuery(sql)
        End If
    End Sub

    Public Sub CreateThread(ByVal subject As String, _
        ByVal creator As User)

        Dim sql As String
        sql = "INSERT INTO [Threads] ([ThreadSubject], " & _
            "[CreatorID], [BoardID]) VALUES ('" & subject & _
            "'," & creator.ID.ToString() & "," & _
            mBoardID.ToString() & ")"
        DataControl.ExecuteNonQuery(sql)

        'reinitialize the thread list
        myThreads.InitializeThreads()
    End Sub

    Public Sub Delete(ByVal requestor As User)
        'only admins can delete boards
        If requestor.IsAdmin Then
            Dim sql As String
            sql = "DELETE FROM Board WHERE BoardID = " & _
                mBoardID.ToString()
            DataControl.ExecuteNonQuery(sql)
        Else
            Throw New ArgumentException("User not permitted to delete")
        End If
    End Sub

    Public Sub DeleteThread(ByVal thread As Thread, ByVal requestor As User)
        If requestor.IsAdmin = True Then
            Dim sql As String
            sql = "DELETE FROM Threads WHERE ThreadID = " & _
                thread.ID.ToString()
            DataControl.ExecuteNonQuery(sql)
            'reinitialize the threads
            myThreads.InitializeThreads()
        Else
            Throw New ArgumentException("User not permitted to delete")
        End If
    End Sub

    Public Sub DeletePost(ByVal thread As Thread, ByVal post As Post, _
        ByVal requestor As User)

        If requestor.IsAdmin = True Then
            Dim sql As String
            sql = "DELETE FROM Posts WHERE PostID = " & _
                post.ID.ToString()
            DataControl.ExecuteNonQuery(sql)
            'reinitialize the posts in the thread
            thread.ChildPosts.InitializePosts()
        Else
            Throw New ArgumentException("User not permitted to delete")
        End If
    End Sub

    Public ReadOnly Property ChildThread(ByVal threadId As Long) As Thread
        Get
            'lookup the correct thread
            Dim i As Integer
            For i = 0 To Me.ChildThreads.Count - 1
                Dim myThread As Thread = Me.ChildThreads.Item(i)
                If myThread.ID = threadId Then
                    Return myThread
                End If
            Next i
            'if we've gotten to this point, there is no thread
            'with that id in this board. throw an exception
            Throw New ArgumentException("Thread does not exist")
        End Get
    End Property

    Public ReadOnly Property ChildThreads() As ThreadList
        Get
            Return myThreads
        End Get
    End Property

    Public ReadOnly Property ID() As Long
        Get
            Return mBoardID
        End Get
    End Property

    Public Property Name() As String
        Get
            Return mName
        End Get
        Set(ByVal Value As String)
            mName = Value
        End Set
    End Property

    Public Property Description() As String
        Get
            Return mDescription
        End Get
        Set(ByVal Value As String)
            mDescription = Value
        End Set
    End Property

    Public Shared Function CreateBoard(ByVal name As String, _
        ByVal description As String, _
        ByVal creator As User) As Board

        Dim sql As String
        Dim myData As DataSet

        If creator.IsAdmin = True Then
            sql = "SELECT BoardName FROM [Board] WHERE [BoardName] = '" & _
                    name & "'"
            myData = DataControl.GetDataSet(sql)
            If myData.Tables(0).Rows.Count <= 0 Then
                'this board name does not already exist. 
                sql = "INSERT INTO [Board] ([BoardName], [BoardDescription], " & _
                    ") VALUES ("
                sql &= "'" & name & "','" & description & _
                    "')"
                'create the board
                DataControl.ExecuteNonQuery(sql)
                'return the board
                Return New Board(name)
            Else
                'board name already exists
                Throw New Exception("This board name already exists")
            End If
        Else
            Throw New Exception("Only admins may create boards")
        End If
    End Function
End Class
