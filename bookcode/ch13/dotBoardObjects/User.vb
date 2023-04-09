Option Strict On

Public Class User
    Private mUsername As String
    Private mFirstName As String
    Private mLastName As String
    Private mUserID As Long
    Private mIsAdmin As Boolean
    Private mEmail As String
    Private mPassword As String
    Private mIsBanned As Boolean

    Public Sub New(ByVal userId As Long)
        Dim myData As DataSet
        myData = DataControl.GetDataSet("SELECT * FROM Users WHERE UserID = " & userId)

        If myData.Tables(0).Rows.Count <= 0 Then
            Throw New System.Exception("The requested user does not exist.")
        Else
            inflate(myData.Tables(0).Rows(0))
        End If

        myData.Dispose()
    End Sub

    Public Sub New(ByVal row As DataRow)
        inflate(row)
    End Sub

    Public Sub Update()
        Dim sql As String
        sql = "UPDATE [Users] SET [Password] = '" & mPassword & _
            "', [FirstName] = '" & mFirstName & _
            "', [LastName] = '" & mLastName & _
            "', [Email] = '" & mEmail & "'"
        If Me.IsAdmin = True Then
            sql = sql & ", [IsAdmin] = 1"
        Else
            sql = sql & ", [IsAdmin] = 0"
        End If
        If Me.IsBanned = True Then
            sql = sql & ", [IsBanned] = 1"
        Else
            sql = sql & ", [IsBanned] = 0"
        End If
        sql = sql & " WHERE [UserID] = " & mUserID.ToString()

        DataControl.ExecuteNonQuery(sql)
    End Sub

    Public Shared Function Validate(ByVal username As String, _
        ByVal password As String) As User

        If password.Equals("") Then
            Throw New ArgumentException("You must enter a password.")
        Else
            Dim myData As DataSet = DataControl.GetDataSet("SELECT * " & _
                "FROM [Users] WHERE [UserName] = '" & username & "'")
            If myData.Tables(0).Rows.Count <= 0 Then
                Throw New ArgumentException("Username does not exist.")
            Else
                If CBool(myData.Tables(0).Rows(0)("IsBanned")) = True Then
                    Throw New Exception("User is banned")
                Else
                    If password <> CStr(myData.Tables(0).Rows(0)("Password")) Then
                        Throw New ArgumentException("Invalid password")
                    Else
                        Return New User(myData.Tables(0).Rows(0))
                    End If
                End If
            End If
        End If
    End Function

    Public Shared Function CreateUser(ByVal userName As String, _
        ByVal password As String, _
        ByVal firstName As String, _
        ByVal lastName As String, ByVal email As String) As User

        Dim sql As String
        Dim myData As DataSet

        sql = "SELECT userName FROM Users WHERE userName = '" & userName & "'"
        myData = DataControl.GetDataSet(sql)
        If myData.Tables(0).Rows.Count <= 0 Then
            'this username has not been taken
            sql = "INSERT INTO [Users] ([Username], [Password], [FirstName], [LastName], " & _
                "[Email], [IsAdmin], [IsBanned]) VALUES ('" & userName & _
                "','" & password & "','" & firstName & "','" & lastName & _
                "','" & email & "',0,0)"
            Console.WriteLine(sql & vbCrLf & vbCrLf)
            DataControl.ExecuteNonQuery(sql)
            Return User.Validate(userName, password)
        Else
            'this username has already been taken
            Throw New ArgumentException("The username is already taken")
        End If
    End Function

    Public ReadOnly Property ID() As Long
        Get
            Return mUserID
        End Get
    End Property

    Public Property LastName() As String
        Get
            Return mLastName
        End Get
        Set(ByVal Value As String)
            mLastName = Value
        End Set
    End Property

    Public Property FirstName() As String
        Get
            Return mFirstName
        End Get
        Set(ByVal Value As String)
            mFirstName = Value
        End Set
    End Property

    Public Property Username() As String
        Get
            Return mUsername
        End Get
        Set(ByVal Value As String)
            mUsername = Value
        End Set
    End Property

    Public WriteOnly Property Password() As String
        Set(ByVal Value As String)
            mPassword = Value
        End Set
    End Property

    Public Property IsAdmin() As Boolean
        Get
            Return mIsAdmin
        End Get
        Set(ByVal Value As Boolean)
            mIsAdmin = Value
        End Set
    End Property

    Public Property IsBanned() As Boolean
        Get
            Return mIsBanned
        End Get
        Set(ByVal Value As Boolean)
            mIsBanned = Value
        End Set
    End Property

    Public Property Email() As String
        Get
            Return mEmail
        End Get
        Set(ByVal Value As String)
            mEmail = Value
        End Set
    End Property

    Private Sub inflate(ByVal row As DataRow)
        Me.mUsername = CStr(row("Username"))
        Me.mFirstName = CStr(row("FirstName"))
        Me.mLastName = CStr(row("LastName"))
        Me.mIsAdmin = CBool(row("IsAdmin"))
        Me.mEmail = CStr(row("Email"))
        Me.mUserID = CLng(row("UserID"))
        Me.mPassword = CStr(row("Password"))
    End Sub


End Class
