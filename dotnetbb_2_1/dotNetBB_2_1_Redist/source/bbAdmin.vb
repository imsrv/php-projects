Imports Microsoft.VisualBasic
Imports System
Imports System.Collections
Imports System.Configuration
Imports System.Diagnostics
Imports System.Data
Imports System.Data.SqlClient
Imports System.IO
Imports System.Net
Imports System.Text
Imports System.Web
Imports System.Web.Mail
Imports System.Web.UI
Imports System.Web.UI.WebControls
Imports System.Web.UI.HtmlControls
Imports System.Xml

Namespace ATPSoftware.dotNetBB
    Public Class bbAdmin
        Inherits Page

        '-- GLOBAL GUEST GUID
        Public Const GUEST_GUID As String = "{A2DBADD2-1833-44B6-AC48-ACCB5B6C7CAE}"

        '--- form processing constants
        Private Const B_START As String = "[b]"
        Private Const B_END As String = "[/b]"
        Private Const I_START As String = "[i]"
        Private Const I_END As String = "[/i]"
        Private Const U_START As String = "[u]"
        Private Const U_END As String = "[/u]"
        Private Const IMG_START As String = "[img]"
        Private Const IMG_END As String = "[/img]"
        Private Const URL1_START As String = "[url="
        Private Const URL2_START As String = "[url]"
        Private Const URL_END As String = "[/url]"
        Private Const LIST_START As String = "[list"
        Private Const LIST_END As String = "[/list]"
        Private Const QUOTE_EQ_START As String = "[quote=&quot;"
        Private Const QUOTE_START As String = "[quote]"
        Private Const QUOTE_END As String = "[/quote]"
        Private Const CODE_START As String = "[code]"
        Private Const CODE_END As String = "[/code]"
        Private Const SUB_START As String = "[sub]"
        Private Const SUB_END As String = "[/sub]"
        Private Const SUP_START As String = "[sup]"
        Private Const SUP_END As String = "[/sup]"
        Private Const FLASH_START As String = "[flash"
        Private Const FLASH_END As String = "[/flash]"
        Private Const LOWER_LIMIT As Long = 48   'ascii for 0
        Private Const UPPER_LIMIT As Long = 125  'ascii for {
        Private Const CHARMAP As Long = 39


        '-- internal site globals
        Private siteRoot As String = ConfigurationSettings.AppSettings("rootPath")
        Private defaultStyle As String = ConfigurationSettings.AppSettings("defaultStyle")
        Private boardTitle As String = ConfigurationSettings.AppSettings("boardTitle")
        Private siteAdmin As String = ConfigurationSettings.AppSettings("siteAdmin")
        Private siteAdminMail As String = ConfigurationSettings.AppSettings("siteAdminMail")
        Private siteURL As String = ConfigurationSettings.AppSettings("siteURL")
        Private smtpServerName As String = ConfigurationSettings.AppSettings("smtpServer")

        '--- Internal SQL Connection Items
        Protected connStr As String = ConfigurationSettings.AppSettings("dataStr")
        Protected dataConn As SqlConnection = Nothing
        Protected dataCmd As SqlCommand = Nothing
        Protected dataRdr As SqlDataReader = Nothing
        Protected dataParam As SqlParameter = Nothing

        '-- string message holders
        Private mainStrLoaded As Boolean = False
        Private mainStringHash As New Hashtable(100)
        Private userStrLoaded As Boolean = False
        Private userStringHash As New Hashtable(100)
        Private formStrLoaded As Boolean = False
        Private formStringHash As New Hashtable(100)
        Private pmStrLoaded As Boolean = False
        Private pmStringHash As New Hashtable(100)
        Private searchStrLoaded As Boolean = False
        Private searchStringHash As New Hashtable(100)
        Private wizStrLoaded As Boolean = False
        Private wizStringHash As New Hashtable(100)


        '-- possible form post items
        Private tba_forumID As Integer = 0
        Private tba_messageID As Integer = 0
        Private tba_forumName As String = String.empty
        Private tba_forumDesc As String = String.Empty
        Private tba_whoPost As Integer = 1
        Private tba_forumAccess As Integer = 0
        Private tba_hasPostValues As Boolean = False
        Private tba_formVerify As Boolean = False
        Private tba_userID As Integer = 0
        Private tba_userAction As Integer = 0
        Private tba_realName As String = String.empty
        Private tba_userName As String = String.empty
        Private tba_userPass As String = String.empty
        Private tba_emailAddr As String = String.empty
        Private tba_showEmail As Integer = 1
        Private tba_homePage As String = String.empty
        Private tba_aimName As String = String.empty
        Private tba_icqNumber As Integer = 0
        Private tba_yPager As String = String.empty
        Private tba_msnName As String = String.empty
        Private tba_uLocation As String = String.empty
        Private tba_uOccupation As String = String.empty
        Private tba_uInterests As String = String.empty
        Private tba_timeOffset As Integer = 0
        Private tba_editSignature As String = String.empty
        Private tba_edOrDel As String = "e"
        Private tba_mnPost As Integer = 0
        Private tba_mxPost As Integer = 0
        Private tba_cTitle As String = String.empty
        Private tba_tID As Integer = 0
        Private tba_formID As Integer = 0
        Private tba_userIP As String = String.empty
        Private tba_loadForm As String = String.empty
        Private tba_mailVerify As Boolean = False
        Private tba_adminBan As Boolean = False
        Private tba_eu1 As Boolean = False
        Private tba_eu2 As Boolean = False
        Private tba_eu3 As Boolean = False
        Private tba_eu4 As Boolean = False
        Private tba_eu5 As Boolean = False
        Private tba_eu6 As Boolean = False
        Private tba_eu7 As Boolean = False
        Private tba_eu8 As Boolean = False
        Private tba_eu9 As Boolean = False
        Private tba_eu10 As Boolean = False
        Private tba_eu11 As Integer = 0
        Private tba_eu12 As Boolean = False
        Private tba_eu13 As Boolean = False
        Private tba_eu14 As Boolean = False
        Private tba_eu15 As Boolean = False
        Private tba_eu16 As String = String.empty
        Private tba_eu17 As Boolean = False
        Private tba_eu18 As Boolean = False
        Private tba_eu19 As Boolean = False
        Private tba_eu20 As Boolean = False
        Private tba_eu21 As Boolean = False
        Private tba_eu22 As Boolean = False
        Private tba_eu23 As Boolean = False
        Private tba_eu24 As Boolean = False
        Private tba_eu25 As String = String.empty
        Private tba_eu26 As String = String.empty
        Private tba_eu27 As Integer = 0
        Private tba_eu28 As Boolean = False
        Private tba_eu29 As Integer = 0
        Private tba_eu30 As Boolean = False
        Private tba_eu31 As Integer = 0
        Private tba_eu32 As String = String.empty
        Private tba_eu33 As String = String.empty
        Private tba_eu34 As String = String.Empty
        Private tba_eu35 As Boolean = True
        Private tba_eu36 As Boolean = False

        Private tba_uAvatar As String = String.empty
        Private tba_usePM As Boolean = False
        Private tba_pmPopUp As Boolean = False
        Private tba_pmEmail As Boolean = False
        Private tba_pmLock As Boolean = False
        Private tba_bWord As String = String.empty
        Private tba_gWord As String = String.empty
        Private tba_bIP As String = String.empty
        Private tba_euguid As String = String.Empty

        '-- v2.1 addtions
        Private tba_userTheme As String = String.Empty
        Private tba_eu37 As Boolean = True
        Private Property _eu37() As Boolean
            Get
                Return tba_eu37
            End Get
            Set(ByVal Value As Boolean)
                tba_eu37 = Value
            End Set
        End Property
        Private Property _userTheme() As String
            Get
                Return tba_userTheme
            End Get
            Set(ByVal Value As String)
                tba_userTheme = Value
            End Set
        End Property

        '--------------------

        Private Property _eguid() As String
            Get
                Return tba_euguid
            End Get
            Set(ByVal Value As String)
                tba_euguid = Value
            End Set
        End Property
        Private Property _bIP() As String
            Get
                Return tba_bIP
            End Get
            Set(ByVal Value As String)
                tba_bIP = Value
            End Set
        End Property
        Private Property _gWord() As String
            Get
                Return tba_gWord
            End Get
            Set(ByVal Value As String)
                tba_gWord = Value
            End Set
        End Property
        Private Property _bWord() As String
            Get
                Return tba_bWord
            End Get
            Set(ByVal Value As String)
                tba_bWord = Value
            End Set
        End Property

        Private Property _pmLock() As Boolean
            Get
                Return tba_pmLock
            End Get
            Set(ByVal Value As Boolean)
                tba_pmLock = Value
            End Set
        End Property
        Private Property _pmEmail() As Boolean
            Get
                Return tba_pmEmail
            End Get
            Set(ByVal Value As Boolean)
                tba_pmEmail = Value
            End Set
        End Property
        Private Property _pmPopUp() As Boolean
            Get
                Return tba_pmPopUp
            End Get
            Set(ByVal Value As Boolean)
                tba_pmPopUp = Value
            End Set
        End Property
        Private Property _usePM() As Boolean
            Get
                Return tba_usePM
            End Get
            Set(ByVal Value As Boolean)
                tba_usePM = Value
            End Set
        End Property


        Private Property _yPager() As String
            Get
                Return tba_yPager
            End Get
            Set(ByVal Value As String)
                tba_yPager = Value
            End Set
        End Property
        Private Property _msnName() As String
            Get
                Return tba_msnName
            End Get
            Set(ByVal Value As String)
                tba_msnName = Value
            End Set
        End Property
        Private Property _uLocation() As String
            Get
                Return tba_uLocation
            End Get
            Set(ByVal Value As String)
                tba_uLocation = Value
            End Set
        End Property
        Private Property _uOccupation() As String
            Get
                Return tba_uOccupation
            End Get
            Set(ByVal Value As String)
                tba_uOccupation = Value
            End Set
        End Property
        Private Property _uInterests() As String
            Get
                Return tba_uInterests
            End Get
            Set(ByVal Value As String)
                tba_uInterests = Value
            End Set
        End Property
        Private Property _mailVerify() As Boolean
            Get
                Return tba_mailVerify
            End Get
            Set(ByVal Value As Boolean)
                tba_mailVerify = Value
            End Set
        End Property
        Private Property _adminBan() As Boolean
            Get
                Return tba_adminBan
            End Get
            Set(ByVal Value As Boolean)
                tba_adminBan = Value
            End Set
        End Property
        Private Property _uAvatar() As String
            Get
                Return tba_uAvatar
            End Get
            Set(ByVal Value As String)
                tba_uAvatar = Value
            End Set
        End Property
        Private Property _eu1() As Boolean
            Get
                Return tba_eu1
            End Get
            Set(ByVal Value As Boolean)
                tba_eu1 = Value
            End Set
        End Property
        Private Property _eu2() As Boolean
            Get
                Return tba_eu2
            End Get
            Set(ByVal Value As Boolean)
                tba_eu2 = Value
            End Set
        End Property
        Private Property _eu3() As Boolean
            Get
                Return tba_eu3
            End Get
            Set(ByVal Value As Boolean)
                tba_eu3 = Value
            End Set
        End Property
        Private Property _eu4() As Boolean
            Get
                Return tba_eu4
            End Get
            Set(ByVal Value As Boolean)
                tba_eu4 = Value
            End Set
        End Property
        Private Property _eu5() As Boolean
            Get
                Return tba_eu5
            End Get
            Set(ByVal Value As Boolean)
                tba_eu5 = Value
            End Set
        End Property
        Private Property _eu6() As Boolean
            Get
                Return tba_eu6
            End Get
            Set(ByVal Value As Boolean)
                tba_eu6 = Value
            End Set
        End Property
        Private Property _eu7() As Boolean
            Get
                Return tba_eu7
            End Get
            Set(ByVal Value As Boolean)
                tba_eu7 = Value
            End Set
        End Property
        Private Property _eu8() As Boolean
            Get
                Return tba_eu8
            End Get
            Set(ByVal Value As Boolean)
                tba_eu8 = Value
            End Set
        End Property
        Private Property _eu9() As Boolean
            Get
                Return tba_eu9
            End Get
            Set(ByVal Value As Boolean)
                tba_eu9 = Value
            End Set
        End Property
        Private Property _eu10() As Boolean
            Get
                Return tba_eu10
            End Get
            Set(ByVal Value As Boolean)
                tba_eu10 = Value
            End Set
        End Property
        Private Property _eu11() As Integer
            Get
                Return tba_eu11
            End Get
            Set(ByVal Value As Integer)
                tba_eu11 = Value
            End Set
        End Property
        Private Property _eu12() As Boolean
            Get
                Return tba_eu12
            End Get
            Set(ByVal Value As Boolean)
                tba_eu12 = Value
            End Set
        End Property
        Private Property _eu13() As Boolean
            Get
                Return tba_eu13
            End Get
            Set(ByVal Value As Boolean)
                tba_eu13 = Value
            End Set
        End Property
        Private Property _eu14() As Boolean
            Get
                Return tba_eu14
            End Get
            Set(ByVal Value As Boolean)
                tba_eu14 = Value
            End Set
        End Property
        Private Property _eu15() As Boolean
            Get
                Return tba_eu15
            End Get
            Set(ByVal Value As Boolean)
                tba_eu15 = Value
            End Set
        End Property
        Private Property _eu16() As String
            Get
                Return tba_eu16
            End Get
            Set(ByVal Value As String)
                tba_eu16 = Value
            End Set
        End Property
        Private Property _eu17() As Boolean
            Get
                Return tba_eu17
            End Get
            Set(ByVal Value As Boolean)
                tba_eu17 = Value
            End Set
        End Property
        Private Property _eu18() As Boolean
            Get
                Return tba_eu18
            End Get
            Set(ByVal Value As Boolean)
                tba_eu18 = Value
            End Set
        End Property
        Private Property _eu19() As Boolean
            Get
                Return tba_eu19
            End Get
            Set(ByVal Value As Boolean)
                tba_eu19 = Value
            End Set
        End Property
        Private Property _eu20() As Boolean
            Get
                Return tba_eu20
            End Get
            Set(ByVal Value As Boolean)
                tba_eu20 = Value
            End Set
        End Property
        Private Property _eu21() As Boolean
            Get
                Return tba_eu21
            End Get
            Set(ByVal Value As Boolean)
                tba_eu21 = Value
            End Set
        End Property
        Private Property _eu22() As Boolean
            Get
                Return tba_eu22
            End Get
            Set(ByVal Value As Boolean)
                tba_eu22 = Value
            End Set
        End Property
        Private Property _eu23() As Boolean
            Get
                Return tba_eu23
            End Get
            Set(ByVal Value As Boolean)
                tba_eu23 = Value
            End Set
        End Property
        Private Property _eu24() As Boolean
            Get
                Return tba_eu24
            End Get
            Set(ByVal Value As Boolean)
                tba_eu24 = Value
            End Set
        End Property
        Private Property _eu25() As String
            Get
                Return tba_eu25
            End Get
            Set(ByVal Value As String)
                tba_eu25 = Value
            End Set
        End Property
        Private Property _eu26() As String
            Get
                Return tba_eu26
            End Get
            Set(ByVal Value As String)
                tba_eu26 = Value
            End Set
        End Property
        Private Property _eu27() As Integer
            Get
                Return tba_eu27
            End Get
            Set(ByVal Value As Integer)
                tba_eu27 = Value
            End Set
        End Property
        Private Property _eu28() As Boolean
            Get
                Return tba_eu28
            End Get
            Set(ByVal Value As Boolean)
                tba_eu28 = Value
            End Set
        End Property
        Private Property _eu29() As Integer
            Get
                Return tba_eu29
            End Get
            Set(ByVal Value As Integer)
                tba_eu29 = Value
            End Set
        End Property
        Private Property _eu30() As Boolean
            Get
                Return tba_eu30
            End Get
            Set(ByVal Value As Boolean)
                tba_eu30 = Value
            End Set
        End Property
        Private Property _eu31() As Integer
            Get
                Return tba_eu31
            End Get
            Set(ByVal Value As Integer)
                tba_eu31 = Value
            End Set
        End Property
        Private Property _eu32() As String
            Get
                Return tba_eu32
            End Get
            Set(ByVal Value As String)
                tba_eu32 = Value
            End Set
        End Property
        Private Property _eu33() As String
            Get
                Return tba_eu33
            End Get
            Set(ByVal Value As String)
                tba_eu33 = Value
            End Set
        End Property
        Private Property _eu34() As String
            Get
                Return tba_eu34
            End Get
            Set(ByVal Value As String)
                tba_eu34 = Value
            End Set
        End Property
        Private Property _eu35() As Boolean
            Get
                Return tba_eu35
            End Get
            Set(ByVal Value As Boolean)
                tba_eu35 = Value
            End Set
        End Property
        Private Property _eu36() As Boolean
            Get
                Return tba_eu36
            End Get
            Set(ByVal Value As Boolean)
                tba_eu36 = Value
            End Set
        End Property

        Private Property _loadForm() As String
            Get
                Return tba_loadForm
            End Get
            Set(ByVal Value As String)
                tba_loadForm = Value
            End Set
        End Property
        Private Property _userIP() As String
            Get
                Return tba_userIP
            End Get
            Set(ByVal Value As String)
                tba_userIP = Value
            End Set
        End Property
        Public Property _formID() As Integer
            Get
                Return tba_formID
            End Get
            Set(ByVal Value As Integer)
                tba_formID = Value
            End Set
        End Property
        Private Property _forumAccess() As Integer
            Get
                Return tba_forumAccess
            End Get
            Set(ByVal Value As Integer)
                tba_forumAccess = Value
            End Set
        End Property
        Private Property _hasPostValues() As Boolean
            Get
                Return tba_hasPostValues
            End Get
            Set(ByVal Value As Boolean)
                tba_hasPostValues = Value
            End Set
        End Property
        Private Property _formVerify() As Boolean
            Get
                Return tba_formVerify
            End Get
            Set(ByVal Value As Boolean)
                tba_formVerify = Value
            End Set
        End Property
        Private Property _userID() As Integer
            Get
                Return tba_userID
            End Get
            Set(ByVal Value As Integer)
                tba_userID = Value
            End Set
        End Property
        Private Property _userAction() As Integer
            Get
                Return tba_userAction
            End Get
            Set(ByVal Value As Integer)
                tba_userAction = Value
            End Set
        End Property
        Private Property _realName() As String
            Get
                Return tba_realName
            End Get
            Set(ByVal Value As String)
                tba_realName = Value
            End Set
        End Property
        Private Property _userName() As String
            Get
                Return tba_userName
            End Get
            Set(ByVal Value As String)
                tba_userName = Value
            End Set
        End Property
        Private Property _userPass() As String
            Get
                Return tba_userPass
            End Get
            Set(ByVal Value As String)
                tba_userPass = Value
            End Set
        End Property
        Private Property _emailAddr() As String
            Get
                Return tba_emailAddr
            End Get
            Set(ByVal Value As String)
                tba_emailAddr = Value
            End Set
        End Property
        Private Property _showEmail() As Integer
            Get
                Return tba_showEmail
            End Get
            Set(ByVal Value As Integer)
                tba_showEmail = Value
            End Set
        End Property
        Private Property _homePage() As String
            Get
                Return tba_homePage
            End Get
            Set(ByVal Value As String)
                tba_homePage = Value
            End Set
        End Property
        Private Property _aimName() As String
            Get
                Return tba_aimName
            End Get
            Set(ByVal Value As String)
                tba_aimName = Value
            End Set
        End Property
        Private Property _icqNumber() As Integer
            Get
                Return tba_icqNumber
            End Get
            Set(ByVal Value As Integer)
                tba_icqNumber = Value
            End Set
        End Property
        Private Property _timeOffset() As Integer
            Get
                Return tba_timeOffset
            End Get
            Set(ByVal Value As Integer)
                tba_timeOffset = Value
            End Set
        End Property
        Private Property _editSignature() As String
            Get
                Return tba_editSignature
            End Get
            Set(ByVal Value As String)
                tba_editSignature = Value
            End Set
        End Property
        Private Property _edOrDel() As String
            Get
                Return tba_edOrDel
            End Get
            Set(ByVal Value As String)
                tba_edOrDel = Value
            End Set
        End Property
        Private Property _mnPost() As Integer
            Get
                Return tba_mnPost
            End Get
            Set(ByVal Value As Integer)
                tba_mnPost = Value
            End Set
        End Property
        Private Property _mxPost() As Integer
            Get
                Return tba_mxPost
            End Get
            Set(ByVal Value As Integer)
                tba_mxPost = Value
            End Set
        End Property
        Private Property _cTitle() As String
            Get
                Return tba_cTitle
            End Get
            Set(ByVal Value As String)
                tba_cTitle = Value
            End Set
        End Property
        Private Property _tID() As Integer
            Get
                Return tba_tID
            End Get
            Set(ByVal Value As Integer)
                tba_tID = Value
            End Set
        End Property
        Private Property _whoPost() As Integer
            Get
                Return tba_whoPost
            End Get
            Set(ByVal Value As Integer)
                tba_whoPost = Value
            End Set
        End Property
        Private Property _forumDesc() As String
            Get
                Return tba_forumDesc
            End Get
            Set(ByVal Value As String)
                tba_forumDesc = Value
            End Set
        End Property
        Private Property _forumName() As String
            Get
                Return tba_forumName
            End Get
            Set(ByVal Value As String)
                tba_forumName = Value
            End Set
        End Property
        Private Property _messageID() As Integer
            Get
                Return tba_messageID
            End Get
            Set(ByVal Value As Integer)
                tba_messageID = Value
            End Set
        End Property
        Private Property _forumID() As Integer
            Get
                Return tba_forumID
            End Get
            Set(ByVal Value As Integer)
                tba_forumID = Value
            End Set
        End Property

        Structure upt
            Dim uname As String
            Dim upass As String
            Dim uguid As String
        End Structure

        '-- checks if admin or moderator == true
        Public Function checkAdminAccess(ByVal uGUID As String) As Boolean
            Dim allowAdmin As Boolean = False

            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_CheckAdminAccess", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
            dataParam.Value = XmlConvert.ToGuid(uGUID)
            dataParam = dataCmd.Parameters.Add("@IsGlobalAdmin", SqlDbType.Bit)
            dataParam.Direction = ParameterDirection.Output
            dataParam = dataCmd.Parameters.Add("@IsModerator", SqlDbType.Bit)
            dataParam.Direction = ParameterDirection.Output
            dataConn.Open()
            dataCmd.ExecuteNonQuery()
            If dataCmd.Parameters("@IsGlobalAdmin").Value = False Then
                If dataCmd.Parameters("@IsModerator").Value = True Then
                    allowAdmin = True
                End If
            Else
                allowAdmin = True
            End If
            dataConn.Close()
            Return allowAdmin
        End Function

        '-- gets the meta and head tag items
        Public Function getHeadItems() As String
            Dim headStr As New StringBuilder()
            headStr.Append(vbTab + "<link rel=""stylesheet"" type=""text/css"" href=" + Chr(34) + siteRoot + "/admin/css/dotNetBBAdmin.css"" />" + vbCrLf)
            headStr.Append(vbTab + "<script src=" + Chr(34) + siteRoot + "/js/TBMain.js""></script>" + vbCrLf)
            headStr.Append(vbTab + "<meta name=""Copyright"" content=""dotNetBB, Copyright 2000-2002, Andrew Putnam, Andrew@dotNetBB.com"" />" + vbCrLf)
            headStr.Append(vbTab + "<meta http-equiv=""Pragma"" content=""no_cache"">" + vbCrLf)
            headStr.Append(vbTab + "<meta http-equiv=""Cache-Control"" content=""no cache"">" + vbCrLf)
            headStr.Append(vbTab + "<meta http-equiv=""Expires"" content=""-1"">" + vbCrLf)
            headStr.Append(vbTab + "<title>" + boardTitle + " Administration</title>" + vbCrLf)
            Return headStr.ToString
        End Function

        '-- redirects back to site root
        Public Function getRoot() As String
            Return siteRoot + "/"
        End Function

        '-- get user Cookies
        Public Function getUserCookie(ByVal key As String) As String
            Call initializeLocks()
            If HttpContext.Current.Request.ServerVariables("AUTH_USER") <> "" And _eu36 = True Then
                Dim uGUID As String = String.Empty
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_GetUserGUIDFROMNTAuth", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@AUTH_USER", SqlDbType.VarChar, 100)
                dataParam.Value = HttpContext.Current.Request.ServerVariables("AUTH_USER")
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                uGUID = XmlConvert.ToString(dataCmd.Parameters("@UserGUID").Value)
                uGUID = "{" + uGUID + "}"
                dataConn.Close()
                Return uGUID

            Else
                Dim cookie As HttpCookie
                cookie = HttpContext.Current.Request.Cookies(key)
                If Not cookie Is Nothing Then
                    Select Case key.ToLower
                        Case "uld"       '-- UserGUID
                            Return cookie.Values("uld")
                        Case "ia"       '-- Is Admin (no longer used)
                            Return cookie.Values("ia")
                        Case "x"        '-- perPage
                            Return cookie.Values("x")
                    End Select
                Else
                    Return ""
                End If
            End If
        End Function

        '-- form post values
        Public Function initializeFPValues() As Boolean
            Dim hasQSValues As Boolean = False

            With HttpContext.Current
                _userIP = .Request.ServerVariables("REMOTE_ADDR")

                '------------------------------
                '-- new in v2.1

                If .Request.Form("ut") <> String.Empty Then
                    hasQSValues = True
                    _hasPostValues = True
                    If .Request.Form("ut").ToString.Trim <> String.Empty Then
                        _userTheme = .Request.Form("ut").ToString.Trim
                    End If
                End If
                If .Request.Form("eu37") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu37").ToString.Trim) = True Then
                        If .Request.Form("eu37") = "1" Then
                            _eu37 = True
                        Else
                            _eu37 = False
                        End If
                    End If
                End If


                '-- End v2.1 additions
                '------------------------------
                If .Request.Form("tid") <> String.Empty Then
                    hasQSValues = True
                    _hasPostValues = True
                    If IsNumeric(.Request.Form("tid").ToString.Trim) = True Then
                        _tID = CInt(.Request.Form("tID").ToString.Trim)
                    End If
                End If
                If .Request.Form("r") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("r").ToString.Trim <> String.Empty Then
                        _loadForm = .Request.Form("r").ToString.Trim.ToLower
                    End If
                End If
                If .Request.Form("bip") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("bip").ToString.Trim <> String.Empty Then
                        _bIP = .Request.Form("bip").ToString.Trim.ToLower
                    End If
                End If
                If .Request.Form("eguid") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("eguid").ToString.Trim <> String.Empty Then
                        _eguid = .Request.Form("eguid").ToString.Trim.ToLower
                    End If
                End If
                If .Request.Form("mnp") <> String.Empty Then
                    hasQSValues = True
                    _hasPostValues = True
                    If IsNumeric(.Request.Form("mnp").ToString.Trim) = True Then
                        _mnPost = CInt(.Request.Form("mnp").ToString.Trim)
                    End If
                End If

                '-- Avatars
                If .Request.Form("ava1") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("ava1").ToString.Trim <> String.Empty And .Request.Form("ava1").ToString.Trim <> "blank.gif" Then
                        _uAvatar = .Request.Form("ava1").ToString.Trim

                    End If
                End If
                If .Request.Form("ava2") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("ava2").ToString.Trim <> "http://www." And Left(.Request.Form("ava2").ToString.Trim, 7) = "http://" Then
                        Select Case Right(.Request.Form("ava2").ToString.Trim, 4).ToLower
                            Case ".jpg", ".gif", "jpeg"
                                _uAvatar = .Request.Form("ava2").ToString.Trim
                        End Select

                    End If
                End If
                '-- private message
                If .Request.Form("upm") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("upm").ToString.Trim = "1" Then
                        _usePM = True
                    Else
                        _usePM = False
                    End If
                End If
                '-- email verified
                If .Request.Form("ev") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("ev").ToString.Trim = "1" Then
                        _mailVerify = True
                    Else
                        _mailVerify = False
                    End If
                End If
                '-- lock account
                If .Request.Form("lua") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("lua").ToString.Trim = "1" Then
                        _adminBan = True
                    Else
                        _adminBan = False
                    End If
                End If

                If .Request.Form("pup") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("pup").ToString.Trim = "1" Then
                        _pmPopUp = True
                    Else
                        _pmPopUp = False
                    End If
                End If
                If .Request.Form("pem") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("pem").ToString.Trim = "1" Then
                        _pmEmail = True
                    Else
                        _pmEmail = False
                    End If
                End If
                If .Request.Form("apl") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("apl").ToString.Trim = "1" Then
                        _pmLock = True
                    Else
                        _pmLock = False
                    End If
                End If


                If .Request.Form("wp") <> String.Empty Then
                    hasQSValues = True
                    _hasPostValues = True
                    If IsNumeric(.Request.Form("wp").ToString.Trim) = True Then
                        _whoPost = CInt(.Request.Form("wp").ToString.Trim)
                    End If
                End If

                If .Request.Form("mxp") <> String.Empty Then
                    hasQSValues = True
                    _hasPostValues = True
                    If IsNumeric(.Request.Form("mxp").ToString.Trim) = True Then
                        _mxPost = CInt(.Request.Form("mxp").ToString.Trim)
                    End If
                End If
                If .Request.Form("ct") <> String.Empty Then
                    hasQSValues = True
                    _hasPostValues = True
                    If .Request.Form("ct").ToString.Trim <> String.Empty Then
                        _cTitle = .Request.Form("ct").ToString.Trim
                    End If
                End If
                If .Request.Form("fn") <> String.Empty Then
                    hasQSValues = True
                    _hasPostValues = True
                    If .Request.Form("fn").ToString.Trim <> String.Empty Then
                        _forumName = .Request.Form("fn").ToString.Trim
                    End If
                End If
                If .Request.Form("fi") <> String.Empty Then
                    hasQSValues = True
                    _hasPostValues = True
                    If IsNumeric(.Request.Form("fi").ToString.Trim) = True Then
                        _formID = CInt(.Request.Form("fi").ToString.Trim)
                    End If
                End If
                If .Request.Form("fn") <> String.Empty Then
                    hasQSValues = True
                    _hasPostValues = True
                    If .Request.Form("fn").ToString.Trim <> String.Empty Then
                        _forumName = .Request.Form("fn").ToString.Trim
                    End If
                End If
                If .Request.Form("fd") <> String.Empty Then
                    hasQSValues = True
                    _hasPostValues = True
                    If .Request.Form("fd").ToString.Trim <> String.Empty Then
                        _forumDesc = .Request.Form("fd").ToString.Trim
                    End If
                End If

                If .Request.Form("access") <> String.Empty Then
                    hasQSValues = True
                    _hasPostValues = True
                    If IsNumeric(.Request.Form("access").ToString.Trim) = True Then
                        _forumAccess = CInt(.Request.Form("access").ToString.Trim)
                    End If
                End If
                If .Request.Form("verify") <> String.Empty Then
                    hasQSValues = True
                    _hasPostValues = True
                    If .Request.Form("verify").ToString = "1" Then
                        _formVerify = True
                    Else
                        _formVerify = False
                    End If
                End If
                If .Request.Form("fid") <> String.Empty Then
                    hasQSValues = True
                    _hasPostValues = True
                    If IsNumeric(.Request.Form("fid")) = True Then
                        _forumID = CInt(.Request.Form("fid"))
                    End If
                End If
                If .Request.Form("uid") <> String.Empty Then
                    hasQSValues = True
                    _hasPostValues = True
                    If IsNumeric(.Request.Form("uid")) = True Then
                        _userID = CInt(.Request.Form("uid"))
                    End If
                End If
                If .Request.Form("ua") <> String.Empty Then
                    hasQSValues = True
                    _hasPostValues = True
                    If IsNumeric(.Request.Form("ua")) = True Then
                        _userAction = CInt(.Request.Form("ua"))
                    End If
                End If
                If .Request.Form("msnm") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("msnm").ToString.Trim <> String.Empty Then
                        _msnName = .Request.Form("msnm").ToString.Trim
                    End If
                End If
                If .Request.Form("bWord") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("bWord").ToString.Trim <> String.Empty Then
                        _bWord = .Request.Form("bWord").ToString.Trim
                    End If
                End If
                If .Request.Form("gWord") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("gWord").ToString.Trim <> String.Empty Then
                        _gWord = .Request.Form("gWord").ToString.Trim
                    End If
                End If
                If .Request.Form("meid") <> String.Empty Then
                    hasQSValues = True
                    _hasPostValues = True
                    If IsNumeric(.Request.Form("meid")) = True Then
                        _messageID = CInt(.Request.Form("meid"))
                    End If
                End If
                If .Request.Form("inter") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("inter").ToString.Trim <> String.Empty Then
                        _uInterests = .Request.Form("inter").ToString.Trim
                    End If
                End If
                If .Request.Form("occu") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("occu").ToString.Trim <> String.Empty Then
                        _uOccupation = .Request.Form("occu").ToString.Trim
                    End If
                End If
                If .Request.Form("loca") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("loca").ToString.Trim <> String.Empty Then
                        _uLocation = .Request.Form("loca").ToString.Trim
                    End If
                End If
                If .Request.Form("msnm") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("msnm").ToString.Trim <> String.Empty Then
                        _msnName = .Request.Form("msnm").ToString.Trim
                    End If
                End If
                If .Request.Form("ypa") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("ypa").ToString.Trim <> String.Empty Then
                        _yPager = .Request.Form("ypa").ToString.Trim
                    End If
                End If

                If .Request.Form("rn") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("rn").ToString.Trim <> String.Empty Then
                        _realName = .Request.Form("rn").ToString.Trim
                    End If
                End If
                If .Request.Form("un") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("un").ToString.Trim <> String.Empty Then
                        _userName = .Request.Form("un").ToString.Trim
                    End If
                End If
                If .Request.Form("pw") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("pw").ToString.Trim <> String.Empty Then
                        _userPass = .Request.Form("pw").ToString.Trim
                    End If
                End If
                If .Request.Form("em") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("em").ToString.Trim <> String.Empty Then
                        _emailAddr = .Request.Form("em").ToString.Trim
                    End If
                End If
                If .Request.Form("se") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("se").ToString.Trim) = True Then
                        _showEmail = CInt(.Request.Form("se").ToString.Trim)
                    End If
                End If
                If .Request.Form("url") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("url").ToString.Trim <> String.Empty Then
                        _homePage = .Request.Form("url").ToString.Trim
                    End If
                End If
                If .Request.Form("aim") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("aim").ToString.Trim <> String.Empty Then
                        _aimName = .Request.Form("aim").ToString.Trim
                    End If
                End If
                If .Request.Form("icq") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("icq").ToString.Trim) = True Then
                        _icqNumber = CInt(.Request.Form("icq").ToString.Trim)
                    End If
                End If
                If .Request.Form("tof") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("tof").ToString.Trim <> String.Empty Then
                        _timeOffset = CInt(.Request.Form("tof").ToString.Trim)
                    End If
                End If
                If .Request.Form("signa") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("signa").ToString.Trim <> String.Empty Then
                        _editSignature = .Request.Form("signa").ToString.Trim
                    End If
                End If
                If .Request.Form("eod") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("eod").ToString.Trim <> String.Empty Then
                        _edOrDel = .Request.Form("eod").ToString.Trim.ToLower
                    End If
                End If
                If .Request.Form("eu1") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu1").ToString.Trim) = True Then
                        If .Request.Form("eu1") = "1" Then
                            _eu1 = True
                        Else
                            _eu1 = False
                        End If
                    End If
                End If
                If .Request.Form("eu2") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu2").ToString.Trim) = True Then
                        If .Request.Form("eu2") = "1" Then
                            _eu2 = True
                        Else
                            _eu2 = False
                        End If
                    End If
                End If
                If .Request.Form("eu3") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu3").ToString.Trim) = True Then
                        If .Request.Form("eu3") = "1" Then
                            _eu3 = True
                        Else
                            _eu3 = False
                        End If
                    End If
                End If
                If .Request.Form("eu4") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu4").ToString.Trim) = True Then
                        If .Request.Form("eu4") = "1" Then
                            _eu4 = True
                        Else
                            _eu4 = False
                        End If
                    End If
                End If
                If .Request.Form("eu5") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu5").ToString.Trim) = True Then
                        If .Request.Form("eu5") = "1" Then
                            _eu5 = True
                        Else
                            _eu5 = False
                        End If
                    End If
                End If
                If .Request.Form("eu6") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu6").ToString.Trim) = True Then
                        If .Request.Form("eu6") = "1" Then
                            _eu6 = True
                        Else
                            _eu6 = False
                        End If
                    End If
                End If
                If .Request.Form("eu7") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu7").ToString.Trim) = True Then
                        If .Request.Form("eu7") = "1" Then
                            _eu7 = True
                        Else
                            _eu7 = False
                        End If
                    End If
                End If
                If .Request.Form("eu8") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu8").ToString.Trim) = True Then
                        If .Request.Form("eu8") = "1" Then
                            _eu8 = True
                        Else
                            _eu8 = False
                        End If
                    End If
                End If
                If .Request.Form("eu9") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu9").ToString.Trim) = True Then
                        If .Request.Form("eu9") = "1" Then
                            _eu9 = True
                        Else
                            _eu9 = False
                        End If
                    End If
                End If
                If .Request.Form("eu10") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu10").ToString.Trim) = True Then
                        If .Request.Form("eu10") = "1" Then
                            _eu10 = True
                        Else
                            _eu10 = False
                        End If
                    End If
                End If
                If .Request.Form("eu11") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu11").ToString.Trim) = True Then
                        _eu11 = CInt(.Request.Form("eu11").ToString.Trim)
                    End If
                End If
                If .Request.Form("eu12") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu12").ToString.Trim) = True Then
                        If .Request.Form("eu12") = "1" Then
                            _eu12 = True
                        Else
                            _eu12 = False
                        End If
                    End If
                End If
                If .Request.Form("eu13") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu13").ToString.Trim) = True Then
                        If .Request.Form("eu13") = "1" Then
                            _eu13 = True
                        Else
                            _eu13 = False
                        End If
                    End If
                End If
                If .Request.Form("eu14") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu14").ToString.Trim) = True Then
                        If .Request.Form("eu14") = "1" Then
                            _eu14 = True
                        Else
                            _eu14 = False
                        End If
                    End If
                End If
                If .Request.Form("eu15") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu15").ToString.Trim) = True Then
                        If .Request.Form("eu15") = "1" Then
                            _eu15 = True
                        Else
                            _eu15 = False
                        End If
                    End If
                End If
                If .Request.Form("eu16") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("eu16").ToString.Trim <> String.Empty Then
                        _eu16 = .Request.Form("eu16").ToString.Trim
                    End If
                End If

                If .Request.Form("eu17") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu17").ToString.Trim) = True Then
                        If .Request.Form("eu17") = "1" Then
                            _eu17 = True
                        Else
                            _eu17 = False
                        End If
                    End If
                End If
                If .Request.Form("eu18") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu18").ToString.Trim) = True Then
                        If .Request.Form("eu18") = "1" Then
                            _eu18 = True
                        Else
                            _eu18 = False
                        End If
                    End If
                End If
                If .Request.Form("eu19") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu19").ToString.Trim) = True Then
                        If .Request.Form("eu19") = "1" Then
                            _eu19 = True
                        Else
                            _eu19 = False
                        End If
                    End If
                End If
                If .Request.Form("eu20") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu20").ToString.Trim) = True Then
                        If .Request.Form("eu20") = "1" Then
                            _eu20 = True
                        Else
                            _eu20 = False
                        End If
                    End If
                End If
                If .Request.Form("eu21") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu21").ToString.Trim) = True Then
                        If .Request.Form("eu21") = "1" Then
                            _eu21 = True
                        Else
                            _eu21 = False
                        End If
                    End If
                End If
                If .Request.Form("eu22") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu22").ToString.Trim) = True Then
                        If .Request.Form("eu22") = "1" Then
                            _eu22 = True
                        Else
                            _eu22 = False
                        End If
                    End If
                End If
                If .Request.Form("eu23") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu23").ToString.Trim) = True Then
                        If .Request.Form("eu23") = "1" Then
                            _eu23 = True
                        Else
                            _eu23 = False
                        End If
                    End If
                End If
                If .Request.Form("eu24") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu24").ToString.Trim) = True Then
                        If .Request.Form("eu24") = "1" Then
                            _eu24 = True
                        Else
                            _eu24 = False
                        End If
                    End If
                End If
                If .Request.Form("eu25") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("eu25").ToString.Trim <> String.Empty Then
                        _eu25 = .Request.Form("eu25").ToString.Trim
                    End If
                End If
                If .Request.Form("eu26") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("eu26").ToString.Trim <> String.Empty Then
                        _eu26 = .Request.Form("eu26").ToString.Trim
                    End If
                End If
                If .Request.Form("eu27") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu27").ToString.Trim) = True Then
                        _eu27 = CInt(.Request.Form("eu27").ToString.Trim)
                    End If
                End If
                If .Request.Form("eu28") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu28").ToString.Trim) = True Then
                        If .Request.Form("eu28") = "1" Then
                            _eu28 = True
                        Else
                            _eu28 = False
                        End If
                    End If
                End If
                If .Request.Form("eu29") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu29").ToString.Trim) = True Then
                        _eu29 = CInt(.Request.Form("eu29").ToString.Trim)
                    End If
                End If
                If .Request.Form("eu30") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu30").ToString.Trim) = True Then
                        If .Request.Form("eu30") = "1" Then
                            _eu30 = True
                        Else
                            _eu30 = False
                        End If
                    End If
                End If
                If .Request.Form("eu32") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("eu32").ToString.Trim <> String.Empty Then
                        _eu32 = .Request.Form("eu32").ToString.Trim
                    End If
                End If
                If .Request.Form("eu33") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("eu33").ToString.Trim <> String.Empty Then
                        _eu33 = .Request.Form("eu33").ToString.Trim
                    End If
                End If
                If .Request.Form("eu34") <> String.Empty Then
                    hasQSValues = True
                    If .Request.Form("eu34").ToString.Trim <> String.Empty Then
                        _eu34 = .Request.Form("eu34").ToString.Trim
                    End If
                End If
                If .Request.Form("eu35") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu35").ToString.Trim) = True Then
                        If .Request.Form("eu35") = "1" Then
                            _eu35 = True
                        Else
                            _eu35 = False
                        End If
                    End If
                End If
                If .Request.Form("eu36") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.Form("eu36").ToString.Trim) = True Then
                        If .Request.Form("eu36") = "1" Then
                            _eu36 = True
                        Else
                            _eu36 = False
                        End If
                    End If
                End If
            End With

            Return hasQSValues
        End Function

        '-- querystring values
        Public Function initializeQSValues() As Boolean
            Dim hasQSValues As Boolean = False
            With HttpContext.Current
                If .Request.QueryString("fi") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.QueryString("fi").ToString.Trim) = True Then
                        _formID = CInt(.Request.QueryString("fi").ToString.Trim)
                    End If
                End If
                If .Request.QueryString("tid") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.QueryString("tid").ToString.Trim) = True Then
                        _tID = CInt(.Request.QueryString("tid").ToString.Trim)
                    End If
                End If
                If .Request.QueryString("m") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.QueryString("m").ToString.Trim) = True Then
                        _messageID = CInt(.Request.QueryString("m").ToString.Trim)
                    End If
                End If
                If .Request.QueryString("uid") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.QueryString("uid")) = True Then
                        _userID = CInt(.Request.QueryString("uid"))
                    End If
                End If
                If .Request.QueryString("fid") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.QueryString("fid")) = True Then
                        _forumID = CInt(.Request.QueryString("fid"))
                    End If
                End If
                If .Request.QueryString("mnp") <> String.Empty Then
                    hasQSValues = True
                    If IsNumeric(.Request.QueryString("mnp")) = True Then
                        _mnPost = CInt(.Request.QueryString("mnp"))
                    End If
                End If
                If .Request.QueryString("eod") <> String.Empty Then
                    hasQSValues = True
                    If .Request.QueryString("eod").ToString.Trim <> String.Empty Then
                        _edOrDel = .Request.QueryString("eod").ToString.Trim.ToLower
                    End If
                End If
                If .Request.QueryString("r") <> String.Empty Then
                    hasQSValues = True
                    If .Request.QueryString("r").ToString.Trim <> String.Empty Then
                        _loadForm = .Request.QueryString("r").ToString.Trim.ToLower
                    End If
                End If
                If .Request.QueryString("fn") <> String.Empty Then
                    hasQSValues = True
                    If .Request.QueryString("fn").ToString.Trim <> String.Empty Then
                        _forumName = .Request.QueryString("fn").ToString.Trim.ToLower
                    End If
                End If
                If .Request.QueryString("verify") <> String.Empty Then
                    hasQSValues = True
                    _hasPostValues = True
                    If .Request.QueryString("verify").ToString = "1" Then
                        _formVerify = True
                    Else
                        _formVerify = False
                    End If
                End If
                If .Request.QueryString("c") <> String.Empty Then
                    hasQSValues = True
                    If .Request.QueryString("c").ToString.Trim <> String.Empty Then
                        _cTitle = .Request.QueryString("c").ToString.Trim
                    End If

                End If
            End With

            Return hasQSValues
        End Function

        '-- admin default page info
        Public Function loadAdminBase() As String
            Dim laTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
            laTable.Append("<tr><td class=""lg""><b>Welcome to the dotNetBB Forum Administration section.</b></td></tr>")
            laTable.Append("<tr><td class=""sm""><br />You are currently running version 2.0 of the dotNetBB forum. <br /><br />")
            laTable.Append("Please select from the administrative tasks on the left navigation menu.  If you do not see the ")
            laTable.Append("administrative menu link for the task you require, please contact the forum adminsitrator : <a href=""mailto:" + siteAdminMail + Chr(34) + ">" + siteAdmin + "</a>.</td></tr>")
            laTable.Append("</table><br />&nbsp;")

            '-- new in v2.1 : added database size information
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_SpaceUsed", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            Dim rC As Integer = 0
            Dim dbName As String = String.Empty
            Dim dbSize As String = String.Empty
            Dim dbUnalloc As String = String.Empty
            Dim dbReserve As String = String.Empty
            Dim dbData As String = String.Empty
            Dim dbIndex As String = String.Empty
            Dim dbUnused As String = String.Empty
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    rC += 1
                    If rC = 1 Then
                        If dataRdr.IsDBNull(0) = False Then
                            dbName = dataRdr.Item(0)
                        End If
                        If dataRdr.IsDBNull(1) = False Then
                            dbSize = dataRdr.Item(1)
                        End If
                        If dataRdr.IsDBNull(2) = False Then
                            dbunalloc = dataRdr.Item(2)
                        End If
                        If dataRdr.IsDBNull(3) = False Then
                            dbReserve = dataRdr.Item(3)
                        End If
                        If dataRdr.IsDBNull(4) = False Then
                            dbData = dataRdr.Item(4)
                        End If
                        If dataRdr.IsDBNull(5) = False Then
                            dbIndex = dataRdr.Item(5)
                        End If
                        If dataRdr.IsDBNull(6) = False Then
                            dbUnused = dataRdr.Item(6)
                        End If
                    ElseIf rC = 2 Then
                        If dataRdr.IsDBNull(0) = False Then
                            dbReserve = dataRdr.Item(0)
                        End If
                        If dataRdr.IsDBNull(1) = False Then
                            dbData = dataRdr.Item(1)
                        End If
                        If dataRdr.IsDBNull(2) = False Then
                            dbIndex = dataRdr.Item(2)
                        End If
                        If dataRdr.IsDBNull(3) = False Then
                            dbUnused = dataRdr.Item(3)
                        End If
                    End If

                End While
                dataRdr.Close()
                dataConn.Close()
            End If

            If dbName <> String.Empty Then
                laTable.Append("<hr size=""1"" noshade />")
                laTable.Append("<b>Current Database Information</b><br /><div class=""xsm"">NOTE : Database may include other data beyond what is being used by dotNetBB</div><br />")
                laTable.Append("&nbsp;&nbsp;&nbsp;Database Name : " + dbName + "<br />")
                laTable.Append("&nbsp;&nbsp;&nbsp;Database Physical Size : " + dbSize + "<br />")
                laTable.Append("&nbsp;&nbsp;&nbsp;Database Unallocated Space : " + dbUnalloc + "<br />")
                laTable.Append("&nbsp;&nbsp;&nbsp;Database Reserved Space : " + dbReserve + "<br />")
                laTable.Append("&nbsp;&nbsp;&nbsp;Database Data Size : " + dbData + "<br />")
                laTable.Append("&nbsp;&nbsp;&nbsp;Database Index Size : " + dbIndex + "<br />")
                laTable.Append("&nbsp;&nbsp;&nbsp;Database Unused Size : " + dbUnused + "<br />")

            End If
            Return laTable.ToString
        End Function

        '-- loads the selected admin form
        Public Function loadAdminForm(ByVal uGUID) As String
            Select Case _formID
                Case 4
                    Return loadForm4(uGUID)

                Case 7
                    Return loadForm7(uGUID)

                Case 8
                    Return loadForm8(uGUID)

                Case 9
                    Return loadForm9(uGUID)

                Case 10
                    Return loadForm10(uGUID)

                Case 11
                    Return loadForm11(uGUID)

                Case 12
                    Return loadForm12(uGUID)

                Case 13
                    Return loadForm13(uGUID)

                Case 15
                    Return loadForm15(uGUID)

                Case 16
                    Return loadForm16(uGUID)

                Case 17
                    Return loadForm17(uGUID)

                Case 18
                    Return loadForm18(uGUID)

                Case 19
                    Return loadForm19(uGUID)

                Case 20
                    Return loadForm20(uGUID)

                Case 22
                    Return loadForm22(uGUID)

                Case 23
                    Return loadForm23(uGUID)

                Case 24
                    Return loadForm24(uGUID)

                Case 25
                    Return loadForm25(uGUID)

                Case 26
                    Return loadForm26(uGUID)

                Case 27
                    Return loadForm27(uGUID)

                Case 28
                    Return loadForm28(uGUID)

                Case Else
                    Return "<div align=""center""><br /><b>You have selected something that does not exist.</b></div>"
            End Select

        End Function

        '-- returns the admin menu
        Public Function printAdminMenu(ByVal uGUID As String) As String
            Dim amTable As New StringBuilder()
            Dim p1 As Boolean = False
            Dim catName As String = String.Empty

            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_GetAdminMenu", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
            dataParam.Value = XmlConvert.ToGuid(uGUID)
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader()
            amTable.Append("<img src=" + Chr(34) + siteRoot + "/admin/images/transdot.gif"" border=""0"" height=""1"" width=""180"" /><br />")
            amTable.Append("<a href=" + Chr(34) + siteRoot + "/" + Chr(34) + ">Public Forum Home</a><br />")
            amTable.Append("<a href=" + Chr(34) + siteRoot + "/admin/"">Administration Home</a><br />")

            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False And dataRdr.IsDBNull(2) = False Then
                        If catName <> dataRdr.Item(2) Then
                            catName = dataRdr.Item(2)
                            amTable.Append("<br /><div class=""smRowHead""><b>" + dataRdr.Item(2) + "</b></div>")
                        End If
                        amTable.Append("<a href=" + Chr(34) + siteRoot + "/admin/?fi=" + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                        amTable.Append(dataRdr.Item(1) + "</a><br />")
                    End If
                End While
                dataRdr.Close()
            End If
            amTable.Append("<br /><div class=""smRowHead""><b>Resources</b></div>")
            amTable.Append("<a href=""help.aspx"" target=""_blank"">Administrative Help</a><br />")
            amTable.Append("<a href=""http://www.dotNetBB.com"" target=""_blank"">dotNetBB Online</a><br />")
            dataConn.Close()
            Return amTable.ToString
        End Function

        '-- sets the user cookies
        Public Sub setUserCookie(ByVal key As String, ByVal value As String)
            Dim cookie As New HttpCookie(key)
            cookie.Values.Add(key, value)
            cookie.Expires = DateAdd(DateInterval.Day, 365, DateTime.Now)
            HttpContext.Current.Response.AppendCookie(cookie)
        End Sub

        '-- ROT-39 weak encryption
        Private Function forumRotate(ByVal wordString As String) As String
            Dim sReturn As String = String.Empty
            Dim nCode As Integer = 0
            Dim nData As Integer = 0
            Try
                Dim AE As New ASCIIEncoding()
                Dim bData As Byte() = AE.GetBytes(wordString)
                For nData = 0 To UBound(bData)
                    nCode = bData(nData)
                    If ((nCode >= LOWER_LIMIT) And (nCode <= UPPER_LIMIT)) Then
                        nCode = nCode + CHARMAP
                        If nCode > UPPER_LIMIT Then
                            nCode = nCode - UPPER_LIMIT + LOWER_LIMIT - 1
                        End If
                    End If
                    bData(nData) = nCode
                Next
                sReturn = AE.GetString(bData).ToString
                Return sReturn
            Catch ex As Exception
                Return ex.StackTrace.ToString
            End Try

        End Function

        '-- gets the string value from the selected hashtable
        Private Function getHashVal(ByVal hashRef As String, ByVal hashKey As String)
            Dim sVal As String = String.Empty
            Select Case hashRef.ToLower
                Case "main"
                    If mainStringHash.Contains(hashKey) Then
                        sVal = mainStringHash(hashKey)
                    Else
                        sVal = "Missing Key Value"
                    End If
                Case "user"
                    If userStringHash.Contains(hashKey) Then
                        sVal = userStringHash(hashKey)
                    Else
                        sVal = "Missing Key Value"
                    End If
                Case "form"
                    If formStringHash.Contains(hashKey) Then
                        sVal = formStringHash(hashKey)
                    Else
                        sVal = "Missing Key Value"
                    End If

                Case "pm"
                    If pmStringHash.Contains(hashKey) Then
                        sVal = pmStringHash(hashKey)
                    Else
                        sVal = "Missing Key Value"
                    End If

                Case "search"
                    If searchStringHash.Contains(hashKey) Then
                        sVal = searchStringHash(hashKey)
                    Else
                        sVal = "Missing Key Value"
                    End If

                Case "wiz"
                    If wizStringHash.Contains(hashKey) Then
                        sVal = wizStringHash(hashKey)
                    Else
                        sVal = "Missing Key Value"
                    End If

            End Select
            Return sVal
        End Function

        '-- sets the values for admin feature locking
        Private Sub initializeLocks()
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_GetUserExperience", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    If dataRdr.IsDBNull(0) = False Then
                        _eu1 = dataRdr.Item(0)
                    End If
                    If dataRdr.IsDBNull(1) = False Then
                        _eu2 = dataRdr.Item(1)
                    End If
                    If dataRdr.IsDBNull(2) = False Then
                        _eu3 = dataRdr.Item(2)
                    End If
                    If dataRdr.IsDBNull(3) = False Then
                        _eu4 = dataRdr.Item(3)
                    End If
                    If dataRdr.IsDBNull(4) = False Then
                        _eu5 = dataRdr.Item(4)
                    End If
                    If dataRdr.IsDBNull(5) = False Then
                        _eu6 = dataRdr.Item(5)
                    End If
                    If dataRdr.IsDBNull(6) = False Then
                        _eu7 = dataRdr.Item(6)
                    End If
                    If dataRdr.IsDBNull(7) = False Then
                        _eu8 = dataRdr.Item(7)
                    End If
                    If dataRdr.IsDBNull(8) = False Then
                        _eu9 = dataRdr.Item(8)
                    End If
                    If dataRdr.IsDBNull(9) = False Then
                        _eu10 = dataRdr.Item(9)
                    End If
                    If dataRdr.IsDBNull(10) = False Then
                        _eu11 = dataRdr.Item(10)
                    End If
                    If dataRdr.IsDBNull(11) = False Then
                        _eu12 = dataRdr.Item(11)
                    End If
                    If dataRdr.IsDBNull(12) = False Then
                        _eu13 = dataRdr.Item(12)
                    End If
                    If dataRdr.IsDBNull(13) = False Then
                        _eu14 = dataRdr.Item(13)
                    End If
                    If dataRdr.IsDBNull(14) = False Then
                        _eu15 = dataRdr.Item(14)
                    End If
                    If dataRdr.IsDBNull(15) = False Then
                        _eu16 = dataRdr.Item(15)
                    End If
                    If dataRdr.IsDBNull(16) = False Then
                        _eu17 = dataRdr.Item(16)
                    End If
                    If dataRdr.IsDBNull(17) = False Then
                        _eu18 = dataRdr.Item(17)
                    End If
                    If dataRdr.IsDBNull(18) = False Then
                        _eu19 = dataRdr.Item(18)
                    End If
                    If dataRdr.IsDBNull(19) = False Then
                        _eu20 = dataRdr.Item(19)
                    End If
                    If dataRdr.IsDBNull(20) = False Then
                        _eu21 = dataRdr.Item(20)
                    End If
                    If dataRdr.IsDBNull(21) = False Then
                        _eu22 = dataRdr.Item(21)
                    End If
                    If dataRdr.IsDBNull(22) = False Then
                        _eu23 = dataRdr.Item(22)
                    End If
                    If dataRdr.IsDBNull(23) = False Then
                        _eu24 = dataRdr.Item(23)
                    End If
                    If dataRdr.IsDBNull(24) = False Then
                        _eu25 = dataRdr.Item(24)
                    End If
                    If dataRdr.IsDBNull(25) = False Then
                        _eu26 = dataRdr.Item(25)
                    End If
                    If dataRdr.IsDBNull(26) = False Then
                        _eu27 = dataRdr.Item(26)
                    End If
                    If dataRdr.IsDBNull(27) = False Then
                        _eu28 = dataRdr.Item(27)
                    End If
                    If dataRdr.IsDBNull(28) = False Then
                        _eu29 = dataRdr.Item(28)
                    End If
                    If dataRdr.IsDBNull(29) = False Then
                        _eu30 = dataRdr.Item(29)
                    End If
                    If dataRdr.IsDBNull(30) = False Then
                        _eu31 = dataRdr.Item(30)
                    End If
                    If dataRdr.IsDBNull(31) = False Then
                        _eu32 = dataRdr.Item(31)
                    End If
                    If dataRdr.IsDBNull(32) = False Then
                        _eu33 = dataRdr.Item(32)
                    End If
                    If dataRdr.IsDBNull(33) = False Then
                        _eu34 = dataRdr.Item(33)
                    End If
                    If dataRdr.IsDBNull(34) = False Then
                        _eu35 = dataRdr.Item(34)
                    End If
                    If dataRdr.IsDBNull(35) = False Then
                        _eu36 = dataRdr.Item(35)
                    End If
                End While
                dataRdr.Close()
                dataConn.Close()
            End If
            '-- override time offset with UTC to local time offset
            _eu31 = DateDiff(DateInterval.Hour, DateTime.UtcNow, DateTime.Now)

        End Sub

        '-- private forum access
        Private Function loadForm4(ByVal uGUID As String) As String
            Dim lfTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%""  height=""300"">")
            Dim AllIDs As String = String.Empty
            Dim idArr() As String
            Dim idLoop As Integer = 0
            Dim userList As String = String.Empty

            If getAdminMenuAccess(4, uGUID) = False Then
                lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                Return lfTable.ToString
                Exit Function
            End If

            lfTable.Append("<tr><td class=""md"" height=""20"" valign=""top""><b>Private Forum Access</b></td></tr>")
            lfTable.Append("<tr><td class=""sm"" height=""20"" valign=""top"">Use this form to grant/remove access to the private forums.</td></tr>")
            lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
            lfTable.Append("<input type=""hidden"" name=""fi"" value=""4"">")
            lfTable.Append("<tr><td class=""sm"" height=""20"">Select the forum to modify : ")
            lfTable.Append("<select name=""fid"" class=""smInput"">")
            Dim forumDrop As String = String.Empty
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_PrivateForumDropListing", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader()
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    If dataRdr.IsDBNull(0) = False Then
                        If dataRdr.Item(0) = _forumID Then
                            lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + " selected>")
                        Else
                            lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                        End If

                        lfTable.Append(dataRdr.Item(1) + "</option>")
                    End If
                End While
                dataRdr.Close()
            End If
            dataConn.Close()
            lfTable.Append("</select> &nbsp;<input type=""submit"" class=""smButton"" value="" GO ""></td></form></tr>")


            If _forumID > 0 And _userID > 0 And _userAction > 0 Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_UpdatePrivateUsers", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataParam = dataCmd.Parameters.Add("@UserID", SqlDbType.Int)
                dataParam.Value = _userID
                dataParam = dataCmd.Parameters.Add("@AddRemove", SqlDbType.Int)
                dataParam.Value = _userAction
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)

                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()

                Dim mailMsg As String = String.Empty

                Select Case _userAction
                    Case 1
                        lfTable.Append("<tr><td class=""sm"" valign=""bottom""><b>User Granted Access</b></td></tr>")
                        logAdminAction(uGUID, "Added private forum access to forum id " + _forumID.ToString + " for user id " + _userID.ToString + ".")
                    Case 2
                        lfTable.Append("<tr><td class=""sm"" valign=""bottom""><b>User Access Removed</b></td></tr>")
                        logAdminAction(uGUID, "Removed private forum access to forum id " + _forumID.ToString + " from user id " + _userID.ToString + ".")

                End Select
                '-- user lists
            End If
            '-- print out the user boxes
            If _forumID > 0 Then
                lfTable.Append("<tr><td valign=""top"" height=""20""><table border=""0"" cellpadding=""3"" cellspacing=""0"">")
                lfTable.Append("<tr><td class=""sm"" align=""center"" height=""20""><b>Users WITHOUT Access</b></td>")
                lfTable.Append("<td class=""sm"" align=""center"" width=""50"">&nbsp;</td>")
                lfTable.Append("<td class=""sm"" align=""center""><b>Users WITH Access</b></td></tr>")

                '-- no access
                lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                lfTable.Append("<input type=""hidden"" name=""fi"" value=""4"">")
                lfTable.Append("<input type=""hidden"" name=""fid"" value=" + Chr(34) + _forumID.ToString + Chr(34) + ">")
                lfTable.Append("<input type=""hidden"" name=""ua"" value=""1"">")
                lfTable.Append("<tr><td class=""sm"" align=""center"" height=""20"">")
                lfTable.Append("<select name=""uid"" class=""smInput"" size=""10"" style=""width:250px;"">")
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_GetNonPrivateUsers", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                            If dataRdr.Item(0) = _userID Then
                                lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + " selected>")
                            Else
                                lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                            End If

                            lfTable.Append(dataRdr.Item(1) + "</option>")
                        End If
                    End While
                    dataRdr.Close()
                End If
                dataConn.Close()

                lfTable.Append("</select></td>")
                lfTable.Append("<td class=""sm"" align=""center"">")
                lfTable.Append("<input type=""submit"" value="" >> "" class=""smButton""></form>")
                lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                lfTable.Append("<input type=""submit"" value="" << "" class=""smButton"">")
                lfTable.Append("<input type=""hidden"" name=""fi"" value=""4"">")
                lfTable.Append("<input type=""hidden"" name=""fid"" value=" + Chr(34) + _forumID.ToString + Chr(34) + ">")
                lfTable.Append("<input type=""hidden"" name=""ua"" value=""2"">")
                lfTable.Append("<td class=""sm"" align=""center"" height=""20"">")
                lfTable.Append("<select name=""uid"" class=""smInput"" size=""10"" style=""width:250px;"">")
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_GetPrivateUsers", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                            If dataRdr.Item(0) = _userID Then
                                lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + " selected>")
                            Else
                                lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                            End If

                            lfTable.Append(dataRdr.Item(1) + "</option>")
                        End If
                    End While
                    dataRdr.Close()
                End If
                dataConn.Close()

                lfTable.Append("</select></td></form></tr>")
                lfTable.Append("</table></td></tr>")
            End If

            lfTable.Append("<tr><td colspan=""3"">&nbsp;</td></tr></form></table>")
            Return lfTable.ToString
        End Function

        '-- edit user profiles
        Private Function loadForm7(ByVal uguid As String) As String

            Dim lfTable As New StringBuilder("<div class=""md""><b>Edit/Delete User Profiles</b></div>")

            If getAdminMenuAccess(7, uguid) = False Then    '-- No Access
                lfTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%""  height=""300"">")
                lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                Return lfTable.ToString
                Exit Function
            End If
            If _userID = 0 Then     '-- if no user selected, show member listing
                If _cTitle = String.Empty Then      '-- user filter
                    _cTitle = "*"
                End If
                _cTitle = Left(_cTitle, 1)
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_ProfileList", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@FilterChar", SqlDbType.VarChar, 1)
                dataParam.Value = _cTitle
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader()
                Dim isAdmin As Boolean = False
                Dim isMod As Boolean = False
                Dim i As Integer = 0
                If dataRdr.IsClosed = False Then
                    lfTable.Append("<div class=""sm"">Use the table below to edit or modify user profiles.  Moderators and Administrators are shown with an 'M' or 'A' in the Role column.</div>")
                    lfTable.Append("<br /><div class=""sm""><b>User Filter : </b>")
                    lfTable.Append("<a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=7&c=*"">Special Char</a> ")
                    For i = 65 To 90
                        lfTable.Append("| <a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=7&c=" + Chr(i) + Chr(34) + ">" + Chr(i).ToString.ToUpper + "</a> ")
                    Next
                    lfTable.Append("<br /><b>Access Role : </b>")
                    lfTable.Append("<a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=7&c=1"">All Users</a> | ")
                    lfTable.Append("<a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=7&c=2"">All Moderators</a> | ")
                    lfTable.Append("<a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=7&c=3"">All Administrators</a> ")

                    lfTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%""  height=""300"" class=""tblStd"">")
                    lfTable.Append("<tr><td align=""center"" class=""smRowHead"" height=""30"">")
                    lfTable.Append("<img src=" + siteRoot + "/admin/images/transdot.gif"" border=""0"" width=""50"" height=""1""><br />")
                    lfTable.Append("<b>Role</b></td>")
                    lfTable.Append("<td class=""smRowHead"">")
                    lfTable.Append("<img src=" + siteRoot + "/admin/images/transdot.gif"" border=""0"" width=""175"" height=""1""><br />")
                    lfTable.Append("<b>User Name</b></td>")
                    lfTable.Append("<td class=""smRowHead"">")
                    lfTable.Append("<img src=" + siteRoot + "/admin/images/transdot.gif"" border=""0"" width=""175"" height=""1""><br />")
                    lfTable.Append("<b>Real Name Name</b></td>")
                    lfTable.Append("<td class=""smRowHead"">")
                    lfTable.Append("<img src=" + siteRoot + "/admin/images/transdot.gif"" border=""0"" width=""175"" height=""1""><br />")
                    lfTable.Append("<b>E-mail Address</b></td>")
                    lfTable.Append("<td class=""smRowHead"" align=""center"" colspan=""2"">")
                    lfTable.Append("<img src=" + siteRoot + "/admin/images/transdot.gif"" border=""0"" width=""125"" height=""1""><br />")
                    lfTable.Append("<b>ACTION</b></td></tr>")
                    While dataRdr.Read
                        isAdmin = False
                        isMod = False
                        '-- is admin?
                        If dataRdr.IsDBNull(4) = False Then
                            If dataRdr.Item(4) = True Then
                                isAdmin = True
                            End If
                        End If
                        '-- is moderator?
                        If dataRdr.IsDBNull(5) = False Then
                            If dataRdr.Item(5) = True Then
                                isMod = True
                            End If
                        End If

                        lfTable.Append("<tr><td align=""center"" class=""smRow"" height=""20"">")
                        If isAdmin = True Then
                            lfTable.Append("<b>A</b> ")
                        End If
                        If isMod = True Then
                            lfTable.Append("<b>M</b>")
                        Else
                            lfTable.Append("&nbsp;")
                        End If
                        lfTable.Append("</td><td class=""smRow"">")
                        If dataRdr.IsDBNull(2) = False Then
                            lfTable.Append(dataRdr.Item(2))
                        Else
                            lfTable.Append("LOGIN NAME IS NULL!")
                        End If
                        lfTable.Append("</td><td class=""smRow"">")
                        If dataRdr.IsDBNull(1) = False Then
                            lfTable.Append(dataRdr.Item(1))
                        Else
                            lfTable.Append("REAL NAME IS BLANK!")
                        End If
                        lfTable.Append("</td><td class=""smRow"">")
                        If dataRdr.IsDBNull(3) = False Then
                            If dataRdr.Item(3) <> String.Empty Then
                                lfTable.Append(dataRdr.Item(3))
                            Else
                                lfTable.Append("E-MAIL IS BLANK!")
                            End If

                        Else
                            lfTable.Append("E-Mail IS BLANK!")
                        End If
                        lfTable.Append("</td><td class=""smRow"" align=""center"">")
                        If dataRdr.IsDBNull(0) = False Then
                            lfTable.Append("<a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=7&eod=e&uid=" + CStr(dataRdr.Item(0)) + Chr(34))
                            lfTable.Append(">EDIT</a>")
                        Else
                            lfTable.Append("&nbsp;")
                        End If
                        lfTable.Append("</td><td class=""smRow"" align=""center"">")
                        If dataRdr.IsDBNull(0) = False Then
                            lfTable.Append("<a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=7&eod=d&uid=" + CStr(dataRdr.Item(0)) + Chr(34))
                            lfTable.Append(">DELETE</a>")
                        Else
                            lfTable.Append("&nbsp;")
                        End If
                        lfTable.Append("</td></tr>")

                    End While
                End If
            Else        '-- load user profile for edit
                Dim htmlSignature As String = String.Empty
                Dim showForm As Boolean = True

                If _hasPostValues = False Then     '-- user profile info not found, get profile info
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_ADMIN_GetUserProfile", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@userid", SqlDbType.Int)
                    dataParam.Value = _userID
                    dataConn.Open()
                    dataRdr = dataCmd.ExecuteReader()
                    If dataRdr.IsClosed = False Then
                        While dataRdr.Read
                            If dataRdr.IsDBNull(0) = False Then
                                _realName = dataRdr.Item(0)
                            End If
                            If dataRdr.IsDBNull(1) = False Then
                                _userName = dataRdr.Item(1)
                            End If
                            If dataRdr.IsDBNull(2) = False Then
                                _userPass = dataRdr.Item(2)
                                If _userPass <> String.Empty Then
                                    _userPass = forumRotate(_userPass)
                                End If
                            End If
                            If dataRdr.IsDBNull(3) = False Then
                                _emailAddr = dataRdr.Item(3)
                            End If
                            If dataRdr.IsDBNull(4) = False Then
                                _showEmail = dataRdr.Item(4)
                            End If
                            If dataRdr.IsDBNull(5) = False Then
                                _homePage = dataRdr.Item(5)
                            End If
                            If dataRdr.IsDBNull(6) = False Then
                                _aimName = dataRdr.Item(6)
                            End If
                            If dataRdr.IsDBNull(7) = False Then
                                _icqNumber = dataRdr.Item(7)
                            End If
                            If dataRdr.IsDBNull(8) = False Then
                                _timeOffset = dataRdr.Item(8)
                            End If
                            If dataRdr.IsDBNull(9) = False Then
                                _editSignature = dataRdr.Item(9)
                            End If
                            If dataRdr.IsDBNull(10) = False Then
                                htmlSignature = dataRdr.Item(10)
                            End If
                            If dataRdr.IsDBNull(11) = False Then
                                _uAvatar = dataRdr.Item(11)
                            End If
                            If dataRdr.IsDBNull(12) = False Then
                                _msnName = dataRdr.Item(12)
                            End If
                            If dataRdr.IsDBNull(13) = False Then
                                _yPager = dataRdr.Item(13)
                            End If
                            If dataRdr.IsDBNull(14) = False Then
                                _uLocation = dataRdr.Item(14)
                            End If
                            If dataRdr.IsDBNull(15) = False Then
                                _uOccupation = dataRdr.Item(15)
                            End If
                            If dataRdr.IsDBNull(16) = False Then
                                _uInterests = dataRdr.Item(16)
                            End If
                            If dataRdr.IsDBNull(17) = False Then
                                _usePM = dataRdr.Item(17)
                            End If
                            If dataRdr.IsDBNull(18) = False Then
                                _pmPopUp = dataRdr.Item(18)
                            End If
                            If dataRdr.IsDBNull(19) = False Then
                                _pmEmail = dataRdr.Item(19)
                            End If
                            If dataRdr.IsDBNull(20) = False Then
                                _pmLock = dataRdr.Item(20)
                            End If
                            If dataRdr.IsDBNull(21) = False Then
                                _mailVerify = dataRdr.Item(21)
                            End If
                            If dataRdr.IsDBNull(22) = False Then
                                _adminBan = dataRdr.Item(22)
                            End If
                            If dataRdr.IsDBNull(23) = False Then
                                _userTheme = dataRdr.Item(23)
                            End If
                            If dataRdr.IsDBNull(24) = False Then
                                _cTitle = dataRdr.Item(24)
                            End If

                        End While
                        dataRdr.Close()
                        dataConn.Close()
                    End If
                    If showForm = True And _edOrDel = "e" Then
                        lfTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%""  height=""300"">")
                        lfTable.Append("<script language=javascript>" + vbCrLf)
                        lfTable.Append("<!--" + vbCrLf)
                        lfTable.Append("function swapAvatar(imgName) { " + vbCrLf)
                        lfTable.Append("nImg = new Image();" + vbCrLf)
                        lfTable.Append("nImg.src='" + siteRoot + "/avatar/'+imgName;" + vbCrLf)
                        lfTable.Append("document.images['avaImg'].src = eval('nImg.src');" + vbCrLf)
                        lfTable.Append("}" + vbCrLf)
                        lfTable.Append("-->" + vbCrLf)
                        lfTable.Append("</script>" + vbCrLf)

                        lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                        lfTable.Append("<input type=""hidden"" name=""uid"" value=" + Chr(34) + _userID.ToString + Chr(34) + ">")
                        lfTable.Append("<input type=""hidden"" name=""fi"" value=" + Chr(34) + _formID.ToString + Chr(34) + ">")
                        lfTable.Append("<input type=""hidden"" name=""eguid"" value=" + Chr(34) + _eguid.ToString + Chr(34) + ">")
                        lfTable.Append("<input type=""hidden"" name=""verify"" value=""1"">")

                        '-- Admin Ban
                        lfTable.Append("<tr><td class=""smRow"" height=""20"" width=""265""><b>Lock User Account :</b></td>")
                        lfTable.Append("<td class=""smRow"">")
                        lfTable.Append("<input type=""radio"" name=""lua"" value=""1" + Chr(34))
                        If _adminBan = True Then
                            lfTable.Append(" checked")
                        End If
                        lfTable.Append("> - Locked<br />")
                        lfTable.Append("<input type=""radio"" name=""lua"" value=""0" + Chr(34))
                        If _adminBan = False Then
                            lfTable.Append(" checked")
                        End If
                        lfTable.Append("> - Not Locked<br />")
                        lfTable.Append("</td></tr>")
                        '-- email verified
                        lfTable.Append("<tr><td class=""smRow"" height=""20"" width=""265""><b>Email verified :</b></td>")
                        lfTable.Append("<td class=""smRow"">")
                        lfTable.Append("<input type=""radio"" name=""ev"" value=""1" + Chr(34))
                        If _mailVerify = True Then
                            lfTable.Append(" checked")
                        End If
                        lfTable.Append("> - Validated<br />")
                        lfTable.Append("<input type=""radio"" name=""ev"" value=""0" + Chr(34))
                        If _mailVerify = False Then
                            lfTable.Append(" checked")
                        End If
                        lfTable.Append("> - Not Validated<br />")
                        lfTable.Append("</td></tr>")

                        '-- real name
                        lfTable.Append("<tr><td class=""smRow"" height=""20"" width=""265""><b>Real Name :</b></td>")
                        lfTable.Append("<td class=""smRow""><input type=""text"" class=""smInput"" name=""rn"" style=""width:100%;"" maxLength=""100"" value=" + Chr(34) + _realName + Chr(34) + "></td></tr>")
                        '-- user name
                        lfTable.Append("<tr><td class=""smRow"" height=""20"" width=""265""><b>User Name :</b>")
                        lfTable.Append("</td><td class=""smRow""><input type=""text"" class=""smInput"" style=""width:100%;"" name=""un"" maxLength=""50"" value=" + Chr(34) + _userName + Chr(34) + "></td></tr>")
                        '-- password
                        lfTable.Append("<tr><td class=""smRow"" height=""20"" width=""265""><b>Password :</b></td>")
                        lfTable.Append("<td class=""smRow""><input type=""text"" class=""smInput"" style=""width:100%;"" name=""pw"" maxLength=""50"" value=" + Chr(34) + _userPass + Chr(34) + "></td></tr>")
                        '-- email
                        lfTable.Append("<tr><td class=""smRow"" height=""20"" width=""265""><b>E-Mail Address :</b></td>")
                        lfTable.Append("<td class=""smRow""><input type=""text"" class=""smInput"" style=""width:100%;"" name=""em"" maxLength=""64"" value=" + Chr(34) + _emailAddr + Chr(34) + "></td></tr>")
                        '-- show email
                        lfTable.Append("<tr><td class=""smRow"" height=""20"" width=""265""><b>Show Your E-Mail Address :</b></td>")
                        lfTable.Append("<td class=""smRow"">")
                        lfTable.Append("<input type=""radio"" name=""se"" value=""1" + Chr(34))
                        If _showEmail = 1 Then
                            lfTable.Append(" checked")
                        End If
                        lfTable.Append("> - Show my E-Mail address<br />")
                        lfTable.Append("<input type=""radio"" name=""se"" value=""0" + Chr(34))
                        If _showEmail = 0 Then
                            lfTable.Append(" checked")
                        End If
                        lfTable.Append("> - Hide my E-Mail address<br />")
                        lfTable.Append("</td></tr>")

                        '----------------------------------------------------
                        '-- start v2 additions

                        '-- Custom User Title
                        lfTable.Append("<tr><td class=""smRow"" height=""20"" width=""265""><b>Custom Title :</b></td>")
                        lfTable.Append("<td class=""smRow""><input type=""text"" class=""smInput"" style=""width:100%;"" name=""ct"" maxLength=""200"" value=" + Chr(34) + _cTitle + Chr(34) + "></td></tr>")


                        '-- forum theme
                        lfTable.Append("<tr><td class=""smRow"" height=""20"" width=""265""><b>Forum Theme :</b></td>")
                        lfTable.Append("<td class=""smRow""><select name=""ut"" class=""smInput"">")
                        Dim styleFolders() As String = Directory.GetFileSystemEntries(Server.MapPath(siteRoot + "/styles"))
                        Dim di As New DirectoryInfo(Server.MapPath(siteRoot + "/styles"))
                        Dim diArr As DirectoryInfo() = di.GetDirectories
                        Dim dri As DirectoryInfo
                        For Each dri In diArr
                            If dri.Name.ToString.ToLower = _userTheme.ToLower Then
                                lfTable.Append("<option selected>" + Server.HtmlEncode(dri.Name.ToString) + "</option>")
                            Else
                                lfTable.Append("<option>" + Server.HtmlEncode(dri.Name.ToString) + "</option>")
                            End If
                        Next
                        lfTable.Append("</select></td></tr>")

                        '-- end v2 additions
                        '----------------------------------------------------

                        '-- _homepage
                        lfTable.Append("<tr><td class=""smRow"" height=""20"" width=""265""><b>Personal Homepage :</b></td>")
                        lfTable.Append("<td class=""smRow""><input type=""text"" class=""smInput"" style=""width:100%;"" name=""url"" maxLength=""200"" value=" + Chr(34) + _homePage + Chr(34) + "></td></tr>")
                        '-- AOL IM
                        lfTable.Append("<tr><td class=""smRow"" height=""20"" width=""265""><b>AOL Instant Messenger :</b></td>")
                        lfTable.Append("<td class=""smRow""><input type=""text"" class=""smInput"" style=""width:100%;"" name=""aim"" maxLength=""50"" value=" + Chr(34) + _aimName + Chr(34) + "></td></tr>")
                        '-- ICQ number
                        lfTable.Append("<tr><td class=""smRow"" height=""20"" width=""265""><b>ICQ Number :</b></td>")
                        lfTable.Append("<td class=""smRow""><input type=""text"" class=""smInput"" style=""width:100%;"" name=""icq"" maxLength=""20"" value=")
                        If _icqNumber > 0 Then
                            lfTable.Append(Chr(34) + _icqNumber.ToString + Chr(34) + "></td></tr>")
                        Else
                            lfTable.Append(Chr(34) + Chr(34) + "></td></tr>")
                        End If

                        '-- Y! Pager
                        lfTable.Append("<tr><td class=""smRow"" height=""20"" width=""265""><b>Y! Pager :</b></td>")
                        lfTable.Append("<td class=""smRow""><input type=""text"" style=""width:100%;"" class=""smInput"" name=""ypa"" style=""width:200px;"" maxLength=""50"" value=" + Chr(34) + _yPager + Chr(34) + "></td></tr>")

                        '-- MSN Messenger
                        lfTable.Append("<tr><td class=""smRow"" height=""20"" width=""265""><b>MSN Messenger :</b></td>")
                        lfTable.Append("<td class=""smRow""><input type=""text"" style=""width:100%;"" class=""smInput"" name=""msnm"" style=""width:200px;"" maxLength=""64"" value=" + Chr(34) + _msnName + Chr(34) + "></td></tr>")

                        '-- City/state location
                        lfTable.Append("<tr><td class=""smRow"" height=""20"" width=""265""><b>Location :</b></td>")

                        lfTable.Append("<td class=""smRow""><input type=""text"" style=""width:100%;"" class=""smInput"" name=""loca"" maxLength=""100"" value=" + Chr(34) + _uLocation + Chr(34) + "></td></tr>")

                        '-- Occupation
                        lfTable.Append("<tr><td class=""smRow"" height=""20"" width=""265""><b>Occupation :</b></td>")
                        lfTable.Append("<td class=""smRow""><input type=""text"" style=""width:100%;"" class=""smInput"" name=""occu"" maxLength=""150"" value=" + Chr(34) + _uOccupation + Chr(34) + "></td></tr>")

                        '-- Interests
                        lfTable.Append("<tr><td class=""smRow"" height=""20"" width=""265"" valign=""top""><b>Personal Interests :</b></td>")
                        lfTable.Append("<td class=""smRow""><input type=""text"" style=""width:100%;"" class=""smInput"" name=""inter"" maxLength=""150"" value=" + Chr(34) + _uInterests + Chr(34) + "></td></tr>")


                        '-- Time Offset
                        lfTable.Append("<input type=""hidden"" name=""tof"" value=""0"">")
                        '-- Signature
                        lfTable.Append("<tr><td class=""smRow"" valign=""top"" height=""20"" width=""265""><b>Signature :</b></td>")
                        lfTable.Append("<td class=""smRow""><textarea class=""smInput"" style=""height:120px;width:100%;"" name=""signa"">" + _editSignature + "</textarea></td></tr>")

                        '-- avatar
                        lfTable.Append("<tr><td class=""smRow"" valign=""top"" height=""20"" width=""265""><b>Avatar :</b><div class=""msgFormDescSm"">You can choose from the available avatar's on this site")
                        If _eu15 = True Then
                            lfTable.Append(", or you can enter the URL to your personal avatar hosted elsewhere.")
                        Else
                            lfTable.Append(".")
                        End If
                        lfTable.Append("</div></td>")
                        lfTable.Append("<td class=""smRow"">Available avatars :<br /><table border=""0"" cellpadding=""3"" cellspacing=""0""><tr><td><select name=""ava1"" class=""sm"" size=""5"" onchange=""swapAvatar(this.value)"">")
                        lfTable.Append("<option value=""blank.gif"">No Avatar</option>")

                        dataConn = New SqlConnection(connStr)
                        dataCmd = New SqlCommand("TB_ActiveAvatars", dataConn)
                        dataCmd.CommandType = CommandType.StoredProcedure
                        dataConn.Open()
                        dataRdr = dataCmd.ExecuteReader
                        If dataRdr.IsClosed = False Then
                            While dataRdr.Read
                                If dataRdr.IsDBNull(0) = False Then
                                    If dataRdr.Item(0) = _uAvatar Then
                                        lfTable.Append("<option value=" + Chr(34) + dataRdr.Item(0) + Chr(34) + " selected>" + dataRdr.Item(0) + "</option>")
                                    Else
                                        lfTable.Append("<option value=" + Chr(34) + dataRdr.Item(0) + Chr(34) + ">" + dataRdr.Item(0) + "</option>")
                                    End If

                                End If
                            End While
                            dataRdr.Close()
                            dataConn.Close()
                        End If
                        lfTable.Append("</select></td><td width=""150"" class=""smRow"" align=""center"" valign=""top"">Avatar Preview<br />")
                        If _uAvatar <> String.Empty And Left(_uAvatar, 7).ToLower <> "http://" Then
                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/avatar/" + _uAvatar + Chr(34) + " name=""avaImg"" id=""avaImg"">")
                        ElseIf Left(_uAvatar, 7).ToLower = "http://" Then
                            lfTable.Append("<img src=" + Chr(34) + _uAvatar + Chr(34) + " name=""avaImg"" id=""avaImg"">")
                        Else
                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/avatar/blank.gif"" name=""avaImg"" id=""avaImg"">")
                        End If


                        lfTable.Append("</td></tr></table>")
                        If _uAvatar.Trim <> String.Empty Then
                            If Left(_uAvatar, 7).ToLower <> "http://" Then
                                _uAvatar = "http://www."
                            End If
                        Else
                            _uAvatar = "http://www."
                        End If
                        lfTable.Append("OR<br />You can enter the URL to your avatar :<br /><input type=""text"" class=""smInput"" name=""ava2"" style=""width:100%;"" maxLength=""150"" value=" + Chr(34) + _uAvatar + Chr(34) + "></td></tr>")

                        '-- Private messaging
                        lfTable.Append("<tr><td class=""smRow"" height=""20"" valign=""top""><b>Private Messaging :</b></td>")
                        lfTable.Append("<td class=""smRow"" valign=""top"">Administrative PM Lockout : &nbsp; ")
                        lfTable.Append("<input type=""radio"" name=""apl"" value=""1" + Chr(34))
                        If _pmLock = True Then
                            lfTable.Append(" checked")
                        End If
                        lfTable.Append("> - Unlocked &nbsp")
                        lfTable.Append("<input type=""radio"" name=""apl"" value=""0" + Chr(34))
                        If _pmLock = False Then
                            lfTable.Append(" checked")
                        End If
                        lfTable.Append("> - Locked &nbsp<br />")

                        lfTable.Append("Use Private Messaging : &nbsp; ")
                        lfTable.Append("<input type=""radio"" name=""upm"" value=""1" + Chr(34))
                        If _usePM = True Then
                            lfTable.Append(" checked")
                        End If
                        lfTable.Append("> - Yes &nbsp")
                        lfTable.Append("<input type=""radio"" name=""upm"" value=""0" + Chr(34))
                        If _usePM = False Then
                            lfTable.Append(" checked")
                        End If
                        lfTable.Append("> - No &nbsp<br />")
                        lfTable.Append("Popup notification of new messages : &nbsp; ")
                        lfTable.Append("<input type=""radio"" name=""pup"" value=""1" + Chr(34))
                        If _pmPopUp = True Then
                            lfTable.Append(" checked")
                        End If
                        lfTable.Append("> - Yes &nbsp")
                        lfTable.Append("<input type=""radio"" name=""pup"" value=""0" + Chr(34))
                        If _pmPopUp = False Then
                            lfTable.Append(" checked")
                        End If
                        lfTable.Append("> - No &nbsp<br />")
                        lfTable.Append("E-mail notification of new messages : &nbsp; ")
                        lfTable.Append("<input type=""radio"" name=""pem"" value=""1" + Chr(34))
                        If _pmEmail = True Then
                            lfTable.Append(" checked")
                        End If
                        lfTable.Append("> - Yes &nbsp")
                        lfTable.Append("<input type=""radio"" name=""pem"" value=""0" + Chr(34))
                        If _pmEmail = False Then
                            lfTable.Append(" checked")
                        End If
                        lfTable.Append("> - No &nbsp<br />")

                        lfTable.Append("</td></tr>")

                        '-- buttons
                        lfTable.Append("<tr><td class=""smRow"" height=""20"" width=""265"">&nbsp;</td>")
                        lfTable.Append("<td class=""smRow"">")
                        lfTable.Append("<input type=""submit"" name=""sButton"" value=""SUBMIT"" class=""smButton"">&nbsp;")


                        lfTable.Append("</td></tr></form>")

                        '-- end spacer
                        lfTable.Append("<tr><td colspan=""2"">&nbsp;</td></tr>")
                    ElseIf _edOrDel = "d" Then
                        lfTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%""  height=""300"">")
                        lfTable.Append("<tr><td class=""sm"" valign=""top""><br /><b><div class=""lg"">User Account to be deleted : " + _userName + "</div><br />Are you sure you want to delete this profile AND ALL posts made by this user?<br /><br />THIS CANNOT BE UNDONE UNLESS YOU RESTORE THE DATABASE FROM A BACKUP COPY! <br />")
                        lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post""><input type=""hidden"" name=""fi"" value=""7"">")
                        lfTable.Append("<input type=""hidden"" name=""eod"" value=""d"">")
                        lfTable.Append("<input type=""hidden"" name=""verify"" value=""1"">")
                        lfTable.Append("<input type=""hidden"" name=""uid"" value=" + Chr(34) + _userID.ToString + Chr(34) + ">")
                        lfTable.Append("<input type=""submit"" value=""DELETE"" class=""smButton""> &nbsp;")
                        lfTable.Append("<input type=""button"" value=""CANCEL"" class=""smButton"" onclick=""window.location.href='" + siteRoot + "/admin/default.aspx?fi=7';""></form></td></tr>")
                        logAdminAction(uguid, "Preparing to delete user profile '" + _userName + "'.")
                    End If
                Else    '-- process profile
                    lfTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%""  height=""300"">")
                    If _edOrDel = "e" Then
                        Try
                            Dim hSignature As String = String.Empty
                            Dim errStr As String = String.Empty
                            If _editSignature <> String.Empty Then
                                hSignature = adminNoHTMLFix(_editSignature)
                                hSignature = adminTBTagToHTML(hSignature)
                            End If
                            If _homePage.ToString.Trim <> String.Empty Then
                                If Left(_homePage.ToString.ToLower, 7) <> "http://" Then
                                    _homePage = "http://" + _homePage.ToString
                                End If
                            End If

                            If _realName.ToString.Trim <> String.Empty Then
                                If _userName.ToString.Trim <> String.Empty Then
                                    Dim _usernameValid As Boolean = False
                                    dataConn = New SqlConnection(connStr)
                                    dataCmd = New SqlCommand("TB_ADMIN_CheckNameForProfileUpdate", dataConn)
                                    dataCmd.CommandType = CommandType.StoredProcedure
                                    dataParam = dataCmd.Parameters.Add("@username", SqlDbType.VarChar, 50)
                                    dataParam.Value = _userName.ToString.Trim
                                    dataParam = dataCmd.Parameters.Add("@userid", SqlDbType.Int)
                                    dataParam.Value = _userID
                                    dataConn.Open()
                                    dataRdr = dataCmd.ExecuteReader
                                    If dataRdr.IsClosed = False Then
                                        While dataRdr.Read
                                            If dataRdr.IsDBNull(0) = False Then
                                                _usernameValid = dataRdr.Item(0)
                                            End If
                                        End While
                                        dataRdr.Close()
                                    End If
                                    dataConn.Close()
                                    If _usernameValid = True Then
                                        Dim uEnc As String = _userPass
                                        uEnc = forumRotate(uEnc)
                                        dataConn = New SqlConnection(connStr)
                                        dataCmd = New SqlCommand("TB_ADMIN_UpdateProfile", dataConn)
                                        dataCmd.CommandType = CommandType.StoredProcedure
                                        dataParam = dataCmd.Parameters.Add("@realname", SqlDbType.VarChar, 100)
                                        dataParam.Value = _realName
                                        dataParam = dataCmd.Parameters.Add("@username", SqlDbType.VarChar, 50)
                                        dataParam.Value = _userName
                                        dataParam = dataCmd.Parameters.Add("@userid", SqlDbType.Int)
                                        dataParam.Value = _userID
                                        dataParam = dataCmd.Parameters.Add("@euPassword", SqlDbType.VarChar, 100)
                                        dataParam.Value = uEnc
                                        dataParam = dataCmd.Parameters.Add("@EmailAddress", SqlDbType.VarChar, 64)
                                        dataParam.Value = _emailAddr
                                        dataParam = dataCmd.Parameters.Add("@ShowAddress", SqlDbType.Int)
                                        dataParam.Value = _showEmail
                                        dataParam = dataCmd.Parameters.Add("@homepage", SqlDbType.VarChar, 200)
                                        dataParam.Value = _homePage
                                        dataParam = dataCmd.Parameters.Add("@aimname", SqlDbType.VarChar, 100)
                                        dataParam.Value = _aimName
                                        dataParam = dataCmd.Parameters.Add("@icqnumber", SqlDbType.Int)
                                        dataParam.Value = _icqNumber
                                        dataParam = dataCmd.Parameters.Add("@MSNM", SqlDbType.VarChar, 64)
                                        dataParam.Value = _msnName
                                        dataParam = dataCmd.Parameters.Add("@YPager", SqlDbType.VarChar, 50)
                                        dataParam.Value = _yPager
                                        dataParam = dataCmd.Parameters.Add("@HomeLocation", SqlDbType.VarChar, 100)
                                        dataParam.Value = _uLocation
                                        dataParam = dataCmd.Parameters.Add("@Occupation", SqlDbType.VarChar, 150)
                                        dataParam.Value = _uOccupation
                                        dataParam = dataCmd.Parameters.Add("@Interests", SqlDbType.Text)
                                        dataParam.Value = _uInterests
                                        dataParam = dataCmd.Parameters.Add("@timeoffset", SqlDbType.Int)
                                        dataParam.Value = _timeOffset
                                        dataParam = dataCmd.Parameters.Add("@EditSignature", SqlDbType.Text)
                                        dataParam.Value = _editSignature
                                        dataParam = dataCmd.Parameters.Add("@Signature", SqlDbType.Text)
                                        dataParam.Value = hSignature
                                        dataParam = dataCmd.Parameters.Add("@Avatar", SqlDbType.VarChar, 200)
                                        dataParam.Value = _uAvatar
                                        dataParam = dataCmd.Parameters.Add("@UsePM", SqlDbType.Bit)
                                        dataParam.Value = _usePM
                                        dataParam = dataCmd.Parameters.Add("@PMPopUp", SqlDbType.Bit)
                                        dataParam.Value = _pmPopUp
                                        dataParam = dataCmd.Parameters.Add("@PMEmail", SqlDbType.Bit)
                                        dataParam.Value = _pmEmail
                                        dataParam = dataCmd.Parameters.Add("@PMAdminLock", SqlDbType.Bit)
                                        dataParam.Value = _pmLock
                                        dataParam = dataCmd.Parameters.Add("@MailVerify", SqlDbType.Bit)
                                        dataParam.Value = _mailVerify
                                        dataParam = dataCmd.Parameters.Add("@AdminBan", SqlDbType.Bit)
                                        dataParam.Value = _adminBan
                                        '----------------------------------------------------
                                        '-- start v2 additions
                                        dataParam = dataCmd.Parameters.Add("@UserTheme", SqlDbType.VarChar, 50)
                                        dataParam.Value = _userTheme
                                        dataParam = dataCmd.Parameters.Add("@UserTitle", SqlDbType.VarChar, 50)
                                        dataParam.Value = _cTitle
                                        '-- end v2 additions
                                        '----------------------------------------------------
                                        dataConn.Open()
                                        dataCmd.ExecuteNonQuery()
                                        dataConn.Close()
                                        logAdminAction(uguid, "Updated userprofile for '" + _userName + "'.")
                                        lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top""><br /><b>The user profile has been updated.<br />&nbsp;")
                                        lfTable.Append("</td></tr>")
                                        lfTable.Append("<script language=javascript>" + vbCrLf)
                                        lfTable.Append("<!--" + vbCrLf)
                                        lfTable.Append("function bouncePage() {" + vbCrLf)
                                        lfTable.Append("window.location.href='" + siteRoot + "/admin/default.aspx?fi=7';" + vbCrLf)
                                        lfTable.Append("}" + vbCrLf)
                                        lfTable.Append("setTimeout('bouncePage()', 1500);" + vbCrLf)
                                        lfTable.Append("-->" + vbCrLf)
                                        lfTable.Append("</script>" + vbCrLf)
                                    Else
                                        errStr = "<tr><td class=""sm"" align=""center"" valign=""top""><b>That user name is already in use, please pick another.</b></td></tr>"
                                    End If
                                Else
                                    errStr = "<tr><td class=""sm"" align=""center"" valign=""top""><b>The 'User Name' Field is required.</b></td></tr>"
                                End If
                            Else
                                errStr = "<tr><td class=""sm"" align=""center"" valign=""top""><b>The 'Real Name' field is required.</b></td></tr>"
                            End If
                            If errStr <> String.Empty Then
                                lfTable.Append(errStr + "<tr><td align=""center"">")
                                lfTable.Append(loadForm7(uguid))
                                lfTable.Append("</td></tr>")
                            End If
                        Catch ex As Exception
                            lfTable.Append(ex.StackTrace.ToString)
                        End Try

                    ElseIf _edOrDel = "d" Then
                        lfTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%""  height=""300"">")
                        If getAdminMenuAccess(9, uguid) = False Then
                            lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                            Return lfTable.ToString
                            Exit Function
                        End If
                        dataConn = New SqlConnection(connStr)
                        dataCmd = New SqlCommand("TB_ADMIN_DeleteUserAndPosts", dataConn)
                        dataCmd.CommandType = CommandType.StoredProcedure
                        dataParam = dataCmd.Parameters.Add("@userid", SqlDbType.Int)
                        dataParam.Value = _userID
                        dataConn.Open()
                        dataCmd.ExecuteNonQuery()
                        dataConn.Close()
                        logAdminAction(uguid, "Deleted user profile.")
                        lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br />The user profile and message postings have been deleted.</td></tr>")
                        lfTable.Append("<script language=javascript>" + vbCrLf)
                        lfTable.Append("<!--" + vbCrLf)
                        lfTable.Append("function bouncePage() {" + vbCrLf)
                        lfTable.Append("window.location.href='" + siteRoot + "/admin/default.aspx?fi=7';" + vbCrLf)
                        lfTable.Append("}" + vbCrLf)
                        lfTable.Append("setTimeout('bouncePage()', 1500);" + vbCrLf)
                        lfTable.Append("-->" + vbCrLf)
                        lfTable.Append("</script>" + vbCrLf)

                    Else
                        lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br />You requested something that does not exist.</td></tr>")
                    End If

                End If
            End If
            'lfTable.Append("</table>")
            lfTable.Append("<tr><td colspan=""3"">&nbsp;</td></tr></form></table>")
            Return lfTable.ToString
        End Function

        '-- user titles
        Private Function loadForm8(ByVal uGUID As String) As String
            Dim lfTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%""  height=""300"">")
            Dim errStr As String = String.Empty
            Dim goodUpdate As Boolean = True
            If getAdminMenuAccess(8, uGUID) = False Then
                lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                Return lfTable.ToString
                Exit Function
            End If

            Select Case _edOrDel
                Case "a"
                    If _formVerify = True Then
                        dataConn = New SqlConnection(connStr)
                        dataCmd = New SqlCommand("TB_ADMIN_AddUserTitle", dataConn)
                        dataCmd.CommandType = CommandType.StoredProcedure
                        dataParam = dataCmd.Parameters.Add("@minPosts", SqlDbType.Int)
                        dataParam.Value = _mnPost
                        dataParam = dataCmd.Parameters.Add("@maxPosts", SqlDbType.Int)
                        dataParam.Value = _mxPost
                        dataParam = dataCmd.Parameters.Add("@titleText", SqlDbType.VarChar, 50)
                        dataParam.Value = _cTitle
                        dataParam = dataCmd.Parameters.Add("@GoodTitle", SqlDbType.Bit)
                        dataParam.Direction = ParameterDirection.Output
                        dataConn.Open()
                        dataCmd.ExecuteNonQuery()
                        goodUpdate = dataCmd.Parameters("@GoodTitle").Value
                        dataConn.Close()
                        If goodUpdate = True Then
                            logAdminAction(uGUID, "Added new user title '" + _cTitle + "'.")
                            _mnPost = 0
                            _mxPost = 0
                            _cTitle = String.Empty
                            _edOrDel = String.Empty
                        Else
                            errStr = "<div style=""color:#990000;"">A title already exists within the post range you specified.<br />Please modify the minimum or maximum posts to a value not already in use.</div>"
                        End If
                    End If

                Case "d"
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_ADMIN_DeleteUserTitle", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@titleid", SqlDbType.Int)
                    dataParam.Value = _tID
                    dataConn.Open()
                    dataCmd.ExecuteNonQuery()
                    dataConn.Close()
                    logAdminAction(uGUID, "Deleted user title.")
                Case "m"
                    If _formVerify = True Then
                        If _formVerify = True Then
                            dataConn = New SqlConnection(connStr)
                            dataCmd = New SqlCommand("TB_ADMIN_ModifyUserTitle", dataConn)
                            dataCmd.CommandType = CommandType.StoredProcedure
                            dataParam = dataCmd.Parameters.Add("@minPosts", SqlDbType.Int)
                            dataParam.Value = _mnPost
                            dataParam = dataCmd.Parameters.Add("@maxPosts", SqlDbType.Int)
                            dataParam.Value = _mxPost
                            dataParam = dataCmd.Parameters.Add("@titleText", SqlDbType.VarChar, 50)
                            dataParam.Value = _cTitle
                            dataParam = dataCmd.Parameters.Add("@titleid", SqlDbType.Int)
                            dataParam.Value = _tID
                            dataParam = dataCmd.Parameters.Add("@GoodTitle", SqlDbType.Bit)
                            dataParam.Direction = ParameterDirection.Output
                            dataConn.Open()
                            dataCmd.ExecuteNonQuery()
                            goodUpdate = dataCmd.Parameters("@GoodTitle").Value
                            dataConn.Close()

                            If goodUpdate = True Then
                                logAdminAction(uGUID, "Modified user title '" + _cTitle + "'.")
                                _mnPost = 0
                                _mxPost = 0
                                _cTitle = String.Empty
                                _edOrDel = String.Empty
                            Else
                                errStr = "<div style=""color:#990000;"">A title already exists within the post range you specified.<br />Please modify the minimum or maximum posts to a value not already in use.</div>"
                            End If
                        End If
                    End If

            End Select



            lfTable.Append("<tr><form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
            lfTable.Append("<input type=""hidden"" name=""fi"" value=""8"">")
            lfTable.Append("<input type=""hidden"" name=""eod"" value=""a"">")
            lfTable.Append("<input type=""hidden"" name=""verify"" value=""1"">")
            lfTable.Append("<tr><td colspan=""5"" height=""20"" class=""smRow""><div class=""md""><b>Add a new title</b></div>Use the form below to add/modify user titles based on the number of posts the user creates.<br />NOTE : Moderators will automatically have 'Forum Moderator' as their title." + errStr + "</td></tr>")
            lfTable.Append("<tr><td class=""smRowHead"" align=""center"" height=""20"">Minimum Posts</td>")
            lfTable.Append("<td class=""smRowHead"" align=""center"" height=""20"">Maximum Posts</td>")
            lfTable.Append("<td class=""smRowHead"" height=""20"">Custom Title</td>")
            lfTable.Append("<td class=""smRowHead"" align=""center"" colspan=""2"" height=""20"" width=""150"">&nbsp;</td></tr>")
            lfTable.Append("<tr><td class=""smRow"" align=""center"" height=""20""><input type=""text"" style=""text-align:center;"" maxlength=""6"" size=""5"" class=""smInput"" name=""mnp"" value=" + Chr(34) + _mnPost.ToString + Chr(34) + "></td>")
            lfTable.Append("<td class=""smRow"" align=""center""><input type=""text"" style=""text-align:center;"" maxlength=""6"" size=""5"" name=""mxp"" class=""smInput"" value=" + Chr(34) + _mxPost.ToString + Chr(34) + "></td>")
            lfTable.Append("<td class=""smRow""><input type=""text"" size=""35"" name=""ct"" class=""smInput"" maxlength=""50"" value=" + Chr(34) + _cTitle + Chr(34) + "></td>")
            lfTable.Append("<td class=""smRow"" colspan=""2""><input type=""submit"" class=""smButton"" value=""Add Me""></td></form></tr>")

            lfTable.Append("<tr><td colspan=""5"" height=""20"" class=""smRow""><br /><b>Edit Existing Titles</b></td></tr>")
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_ListTitles", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader()
            If dataRdr.IsClosed = False Then
                lfTable.Append("<tr><td class=""smRowHead"" height=""20"" align=""center"" width=""110"">Minimum Posts</td>")
                lfTable.Append("<td class=""smRowHead"" align=""center"" height=""20"" width=""110"">Maximum Posts</td>")
                lfTable.Append("<td class=""smRowHead"" height=""20"">Custom Title</td>")
                lfTable.Append("<td class=""smRowHead"" align=""center"" colspan=""2"" height=""20"" width=""150"">Action</td></tr>")

                While dataRdr.Read
                    If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False And dataRdr.IsDBNull(2) = False And dataRdr.IsDBNull(3) = False Then
                        If _edOrDel = "m" And dataRdr.Item(0) = _tID Then
                            lfTable.Append("<tr><form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                            lfTable.Append("<input type=""hidden"" name=""fi"" value=""8"">")
                            lfTable.Append("<input type=""hidden"" name=""eod"" value=""m"">")
                            lfTable.Append("<input type=""hidden"" name=""verify"" value=""1"">")
                            lfTable.Append("<input type=""hidden"" name=""tid"" value=" + Chr(34) + _tID.ToString + Chr(34) + ">")
                            lfTable.Append("<tr><td class=""smRow"" align=""center"" height=""20""><input type=""text"" maxlength=""6"" style=""text-align:center;"" size=""5"" class=""smInput"" name=""mnp"" value=" + Chr(34) + CStr(dataRdr.Item(1)) + Chr(34) + "></td>")
                            lfTable.Append("<td class=""smRow"" align=""center""><input type=""text""maxlength=""6"" style=""text-align:center;"" size=""5"" name=""mxp"" class=""smInput"" value=" + Chr(34) + CStr(dataRdr.Item(2)) + Chr(34) + "></td>")
                            lfTable.Append("<td class=""smRow""><input type=""text"" size=""35"" name=""ct"" maxlength=""50"" class=""smInput"" value=" + Chr(34) + CStr(dataRdr.Item(3)) + Chr(34) + "></td>")
                            lfTable.Append("<td class=""smRow""><input type=""submit"" class=""smButton"" value=""UPDATE""></td></form>")
                            lfTable.Append("<td class=""smRow""><input type=""button"" onclick=""window.location.href='" + siteRoot + "/admin/default.aspx?fi=8';"" class=""smButton"" value=""CANCEL""></td></tr>")
                        Else
                            lfTable.Append("<tr><td class=""smRow"" height=""20"" align=""center"">" + CStr(dataRdr.Item(1)) + "</td>")
                            lfTable.Append("<td class=""smRow"" align=""center"">" + CStr(dataRdr.Item(2)) + "</td>")
                            lfTable.Append("<td class=""smRow"">" + CStr(dataRdr.Item(3)) + "</td>")
                            lfTable.Append("<td class=""smRow""><a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=8&eod=d&tid=" + CStr(dataRdr.Item(0)) + Chr(34) + ">DELETE</a></td>")
                            lfTable.Append("<td class=""smRow""><a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=8&eod=m&tid=" + CStr(dataRdr.Item(0)) + Chr(34) + ">MODIFY</a></td></tr>")
                        End If


                    End If

                End While
                dataRdr.Close()
            End If
            dataConn.Close()

            lfTable.Append("<tr><td colspan=""5"">&nbsp;</td></tr></form></table>")
            Return lfTable.ToString
        End Function

        '-- sticky posting
        Private Function loadForm9(ByVal uGUID As String) As String

            Dim lfTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%""  height=""300"">")
            Dim errStr As String = String.Empty
            Dim goodUpdate As Boolean = True
            If getAdminMenuAccess(9, uGUID) = False Then
                lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                Return lfTable.ToString
                Exit Function
            End If
            lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
            lfTable.Append("<input type=""hidden"" name=""fi"" value=""9"">")

            lfTable.Append("<tr><td colspan=""2"" class=""md"" height=""20""><b>Sticky Threads</b></td></tr>")
            lfTable.Append("<tr><td colspan=""2"" class=""sm"" height=""20"">Use this form to lock/unlock message threads on the top of the listing.</td></tr>")
            lfTable.Append("<tr><td class=""sm"" width=""30%"" height=""20"" valign=""top"">Select the Forum : </td>")
            lfTable.Append("<td class=""sm"" width=""70%"" valign=""baseline""><select name=""fid"" class=""smInput"">")

            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_ModerateForums", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
            dataParam.Value = XmlConvert.ToGuid(uGUID)
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                        If dataRdr.Item(0) = _forumID Then
                            lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + " selected>")
                        Else
                            lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                        End If
                        lfTable.Append(dataRdr.Item(1) + "</option>")
                    End If
                End While
                dataRdr.Close()
            End If
            dataConn.Close()
            lfTable.Append("</select> &nbsp;<input type=""submit"" value=""  GO  "" class=""smButton""><br />&nbsp;</td></form></tr>")

            If _forumID > 0 Then
                If _messageID > 0 And _edOrDel <> String.Empty Then
                    Select Case _edOrDel
                        Case "p"
                            dataConn = New SqlConnection(connStr)
                            dataCmd = New SqlCommand("TB_ADMIN_MakeSticky", dataConn)
                            dataCmd.CommandType = CommandType.StoredProcedure
                            dataParam = dataCmd.Parameters.Add("@messageid", SqlDbType.Int)
                            dataParam.Value = _messageID
                            dataConn.Open()
                            dataCmd.ExecuteNonQuery()
                            dataConn.Close()
                            logAdminAction(uGUID, "Made message id " + _messageID.ToString + " sticky.")

                        Case "u"
                            dataConn = New SqlConnection(connStr)
                            dataCmd = New SqlCommand("TB_ADMIN_MakeNonSticky", dataConn)
                            dataCmd.CommandType = CommandType.StoredProcedure
                            dataParam = dataCmd.Parameters.Add("@messageid", SqlDbType.Int)
                            dataParam.Value = _messageID
                            dataConn.Open()
                            dataCmd.ExecuteNonQuery()
                            dataConn.Close()
                            logAdminAction(uGUID, "Removed message id " + _messageID.ToString + " from being sticky.")

                    End Select
                End If

                lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                lfTable.Append("<input type=""hidden"" name=""fi"" value=""9"">")
                lfTable.Append("<input type=""hidden"" name=""fid"" value=" + Chr(34) + _forumID.ToString + Chr(34) + ">")
                lfTable.Append("<input type=""hidden"" name=""eod"" value=""p"">")
                lfTable.Append("<tr><td colspan=""2"" class=""smRowHead"" height=""20"">Select Thread to make Sticky :</td></tr>")
                lfTable.Append("<tr><td colspan=""2"" class=""smRow"" height=""20"">")
                lfTable.Append("<select name=""meid"" class=""sm"">")
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_ModerateNonStickyThreads", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataParam = dataCmd.Parameters.Add("@forumid", SqlDbType.Int)
                dataParam.Value = _forumID
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                            If dataRdr.Item(0) = _messageID Then
                                lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + " selected>")
                            Else
                                lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                            End If
                            lfTable.Append(dataRdr.Item(1) + "</option>")
                        End If
                    End While
                    dataRdr.Close()
                End If
                dataConn.Close()
                lfTable.Append("</select> &nbsp;<input type=""submit"" value=""MAKE STICKY"" class=""smButton""><br />&nbsp;</td></form></tr>")

                lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                lfTable.Append("<input type=""hidden"" name=""fi"" value=""9"">")
                lfTable.Append("<input type=""hidden"" name=""fid"" value=" + Chr(34) + _forumID.ToString + Chr(34) + ">")
                lfTable.Append("<input type=""hidden"" name=""eod"" value=""u"">")
                lfTable.Append("<tr><td colspan=""2"" class=""smRowHead"" height=""20"">Select Thread to Unstick :</td></tr>")
                lfTable.Append("<tr><td colspan=""2"" class=""sm"" height=""20"">")
                lfTable.Append("<select name=""meid"" class=""sm"">")
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_ModerateStickyThreads", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataParam = dataCmd.Parameters.Add("@forumid", SqlDbType.Int)
                dataParam.Value = _forumID
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                            If dataRdr.Item(0) = _messageID Then
                                lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + " selected>")
                            Else
                                lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                            End If
                            lfTable.Append(dataRdr.Item(1) + "</option>")
                        End If
                    End While
                    dataRdr.Close()
                End If
                dataConn.Close()
                lfTable.Append("</select> &nbsp;<input type=""submit"" value=""UNSTICK"" class=""smButton""><br />&nbsp;</td></form></tr>")
            End If



            lfTable.Append("<tr><td colspan=""2"">&nbsp;</td></tr></table>")
            Return lfTable.ToString
        End Function

        '-- move message
        Private Function loadForm10(ByVal uGUID As String) As String
            Dim lfTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%""  height=""300"">")
            If getAdminMenuAccess(10, uGUID) = False Then
                lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                Return lfTable.ToString
                Exit Function
            End If
            lfTable.Append("<tr><td colspan=""2"" class=""md"" height=""20""><b>Move a Thread</b></td></tr>")
            lfTable.Append("<tr><td colspan=""2"" class=""sm"" height=""20"">Use this form to move threads between forums.<br />NOTE : You can only move COMPLETE threads.</td></tr>")
            If _forumID = 0 Then
                lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                lfTable.Append("<input type=""hidden"" name=""fi"" value=""10"">")
                lfTable.Append("<tr><td class=""sm"" width=""30%"" height=""20"" valign=""baseline"">Select the Source Forum : </td>")
                lfTable.Append("<td class=""sm"" width=""70%"" valign=""baseline""><select name=""fid"" class=""smInput"">")

                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_ModerateForums", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                            If dataRdr.Item(0) = _forumID Then
                                lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + " selected>")
                            Else
                                lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                            End If
                            lfTable.Append(dataRdr.Item(1) + "</option>")
                        End If
                    End While
                    dataRdr.Close()
                End If
                dataConn.Close()
                lfTable.Append("</select> &nbsp;<input type=""submit"" value=""  GO  "" class=""smButton""><br />&nbsp;</td></form></tr>")
            ElseIf _forumID > 0 And _formVerify = False Then
                lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                lfTable.Append("<tr><td class=""sm"" height=""20"" valign=""top"" width=""200"">Select the thread to move :</td><form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                lfTable.Append("<input type=""hidden"" name=""fi"" value=""10"">")
                lfTable.Append("<td class=""sm"" valign=""top""><select name=""meid"" class=""smInput"">")
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_GetForumTopics", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                            If dataRdr.Item(0) = _messageID Then
                                lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + " selected>")
                            Else
                                lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                            End If
                            lfTable.Append(dataRdr.Item(1) + "</option>")
                        End If
                    End While
                    dataRdr.Close()
                End If
                dataConn.Close()
                lfTable.Append("</select> &nbsp;</td></tr>")
                lfTable.Append("<tr><td class=""sm"" width=""200"" height=""20"" valign=""baseline"">Select the Destination Forum : </td>")
                lfTable.Append("<input type=""hidden"" name=""verify"" value=""1"">")
                lfTable.Append("<td class=""sm"" valign=""baseline""><select name=""fid"" class=""smInput"">")


                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_ModerateForums", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                            If dataRdr.Item(0) <> _forumID Then
                                lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                            End If
                            lfTable.Append(dataRdr.Item(1) + "</option>")
                        End If
                    End While
                    dataRdr.Close()
                End If
                dataConn.Close()
                lfTable.Append("</select> &nbsp;<input type=""submit"" value=""  GO  "" class=""smButton""><br />&nbsp;</td></form></tr>")

            ElseIf _forumID > 0 And _messageID > 0 And _formVerify = True Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_MoveThread", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                dataParam.Value = _messageID
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                logAdminAction(uGUID, "Moved message id " + _messageID.ToString + " to forum id " + _forumID.ToString + ".")
                lfTable.Append("<tr><td class=""sm"" colspan=""2"" height=""20"" valign=""top""><b>The thread has been moved</b></td></tr>")
                _messageID = 0
            End If


            lfTable.Append("<tr><td colspan=""2"">&nbsp;</td></tr></form></table>")
            Return lfTable.ToString
        End Function

        '-- add moderator
        Private Function loadForm11(ByVal uGUID As String) As String
            Dim lfTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%""  height=""300"">")
            If getAdminMenuAccess(11, uGUID) = False Then
                lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                Return lfTable.ToString
                Exit Function
            End If
            If _forumID > 0 And _userID > 0 And _userAction > 0 Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_EditModeratorAccess", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@forumid", SqlDbType.Int)
                dataParam.Value = _forumID
                dataParam = dataCmd.Parameters.Add("@userid", SqlDbType.Int)
                dataParam.Value = _userID
                dataParam = dataCmd.Parameters.Add("@AddRemove", SqlDbType.Int)
                dataParam.Value = _userAction
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                If _userAction = 1 Then
                    logAdminAction(uGUID, "Granted moderator permission to forum id " + _forumID.ToString + " to user id " + _userID.ToString + ".")
                Else
                    logAdminAction(uGUID, "Removed moderator permission to forum id " + _forumID.ToString + " to user id " + _userID.ToString + ".")
                End If
            End If
            lfTable.Append("<tr><td colspan=""2"" class=""md"" height=""20"" valign=""top""><b>Add/Edit Moderators</b></td></tr>")
            lfTable.Append("<tr><td class=""sm"" height=""20"" valign=""top"" colspan=""2"">Select the user who's access you would like to modify.</td></tr>")
            lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post""><input type=""hidden"" name=""fi"" value=""11"">")
            lfTable.Append("<tr><td class=""sm"" height=""20"" valign=""top"">User Name : </td>")
            lfTable.Append("<td class=""sm""><select name=""uid"" class=""smInput"">")
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_AllUsers", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader()
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                        If _userID = dataRdr.Item(0) Then
                            lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + " selected>")
                        Else
                            lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                        End If
                        lfTable.Append(dataRdr.Item(1) + "</option>")
                    End If
                End While
                dataRdr.Close()
            End If
            dataConn.Close()
            lfTable.Append("</select> &nbsp;<input type=""submit"" class=""smButton"" value=""SUBMIT""></td></form></tr>")

            If _userID > 0 Then
                lfTable.Append("<tr><td colspan=""2""><form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                lfTable.Append("<input type=""hidden"" name=""fi"" value=""11"">")
                lfTable.Append("<input type=""hidden"" name=""uid"" value=" + Chr(34) + _userID.ToString + Chr(34) + ">")
                lfTable.Append("<input type=""hidden"" name=""ua"" value=""1"">")
                lfTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"">")
                lfTable.Append("<tr><td class=""sm"" align=""center""><b>Not Moderating</b></td>")
                lfTable.Append("<td class=""sm"" align=""center"">&nbsp;</td>")
                lfTable.Append("<td class=""sm"" align=""center""><b>Moderating</b></td></tr>")
                lfTable.Append("<tr><td class=""sm""><select name=""fid"" class=""smInput"" size=""10"" style=""width:200px;"">")
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_NonModerateAccess", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@userid", SqlDbType.Int)
                dataParam.Value = _userID
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader()
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                            If dataRdr.Item(0) = _forumID Then
                                lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + " selectd>")
                            Else
                                lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                            End If
                            lfTable.Append(dataRdr.Item(1) + "</option>")
                        End If
                    End While
                    dataRdr.Close()
                End If
                dataConn.Close()
                lfTable.Append("</select></td><td class=""sm"" width=""65"" align=""center"">")
                lfTable.Append("<input type=""submit"" value="" >> "" class=""smButton""></form>")
                lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                lfTable.Append("<input type=""hidden"" name=""fi"" value=""11"">")
                lfTable.Append("<input type=""hidden"" name=""uid"" value=" + Chr(34) + _userID.ToString + Chr(34) + ">")
                lfTable.Append("<input type=""hidden"" name=""ua"" value=""2"">")
                lfTable.Append("<input type=""submit"" value="" << "" class=""smButton""></td>")
                lfTable.Append("<td class=""sm""><select name=""fid"" class=""smInput"" size=""10"" style=""width:200px;"">")
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_ModerateAccess", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@userid", SqlDbType.Int)
                dataParam.Value = _userID
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader()
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                            If dataRdr.Item(0) = _forumID Then
                                lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + " selectd>")
                            Else
                                lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                            End If
                            lfTable.Append(dataRdr.Item(1) + "</option>")
                        End If
                    End While
                    dataRdr.Close()
                End If
                dataConn.Close()
                lfTable.Append("</select></td></tr>")

                lfTable.Append("</table></form></td></tr>")

            End If
            lfTable.Append("<tr><td colspan=""2"" class=""sm""><hr size=""1"" noshade><b>Current Moderators :</b><br />Click the moderator's 'User Name' to modify their permissions.<hr size=""1"" noshade />")
            lfTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""400"" >")

            Dim lu As Integer = 0
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_ListModerators", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader()
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False And dataRdr.IsDBNull(2) = False And dataRdr.IsDBNull(3) = False Then
                        If lu <> dataRdr.Item(3) Then
                            If lu <> 0 Then
                                lfTable.Append("</td></tr>")
                                lfTable.Append("<tr><td colspan=""2"" style=""border-bottom:1px outset threedshadow;""><img src=" + Chr(34) + siteRoot + "/admin/images/transdot.gif"" border=""0"" height=""3"" width=""30""></td></tr>")
                            End If
                            lfTable.Append("<tr><td class=""sm"" valign=""top"">Real Name : ")

                            lfTable.Append(dataRdr.Item(0) + "<br />Login Name : <a href=" + Chr(34) + siteRoot + "/admin/?fi=11&uid=")
                            lfTable.Append(CStr(dataRdr.Item(3)) + Chr(34) + ">")
                            lfTable.Append(dataRdr.Item(1) + "</a></td><td class=""sm"" valign=""top"">")
                            lu = dataRdr.Item(3)
                        End If
                        lfTable.Append(dataRdr.Item(2) + "<br />")
                    End If
                End While
                dataRdr.Close()
            End If
            dataConn.Close()
            lfTable.Append("</td</tr></table></td></tr>")
            lfTable.Append("<tr><td colspan=""2"">&nbsp;</td></tr></form></table>")
            Return lfTable.ToString
        End Function

        '-- admin menu access
        Private Function loadForm12(ByVal uGUID As String) As String
            Dim lfTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%""  height=""300"">")
            If getAdminMenuAccess(12, uGUID) = False Then
                lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                Return lfTable.ToString
                Exit Function
            End If
            If _forumID > 0 And _userID > 0 And _userAction > 0 Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_EditMenuAccess", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@menuID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataParam = dataCmd.Parameters.Add("@userid", SqlDbType.Int)
                dataParam.Value = _userID
                dataParam = dataCmd.Parameters.Add("@AddRemove", SqlDbType.Int)
                dataParam.Value = _userAction
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                If _userAction = 1 Then
                    logAdminAction(uGUID, "Granted access to menu id " + _forumID.ToString + " to user id " + _userID.ToString + ".")
                Else
                    logAdminAction(uGUID, "Removed access to menu id " + _forumID.ToString + " to user id " + _userID.ToString + ".")
                End If
            End If
            lfTable.Append("<tr><td colspan=""2"" class=""md"" height=""20"" valign=""top""><b>Add/Edit Admin Menu Access</b></td></tr>")
            lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post""><input type=""hidden"" name=""fi"" value=""12"">")
            lfTable.Append("<tr><td class=""sm"" height=""20"" valign=""top"" colspan=""2"">Use this form to modify access permissions for the admin area.  By granting one or more menu items, the user will see the 'Forum Administration' link at the top of their public forum view.</td></tr>")
            lfTable.Append("<tr><td class=""sm"" height=""20"" valign=""top"" colspan=""2"">Select the user who's access you would like to modify.</td></tr>")
            lfTable.Append("<tr><td class=""sm"" height=""20"" valign=""top"">User Name : </td>")
            lfTable.Append("<td class=""sm""><select name=""uid"" class=""smInput"">")
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_AllUsers", dataConn)

            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader()
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                        If _userID = dataRdr.Item(0) Then
                            lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + " selected>")
                        Else
                            lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                        End If
                        lfTable.Append(dataRdr.Item(1) + "</option>")
                    End If
                End While
                dataRdr.Close()
            End If
            dataConn.Close()
            lfTable.Append("</select> &nbsp;<input type=""submit"" class=""smButton"" value=""SUBMIT""></td></form></tr>")

            If _userID > 0 Then
                lfTable.Append("<tr><td colspan=""2""><form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                lfTable.Append("<input type=""hidden"" name=""fi"" value=""12"">")
                lfTable.Append("<input type=""hidden"" name=""uid"" value=" + Chr(34) + _userID.ToString + Chr(34) + ">")
                lfTable.Append("<input type=""hidden"" name=""ua"" value=""1"">")
                lfTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"">")
                lfTable.Append("<tr><td class=""sm"" align=""center""><b>Unavailable Menu Items</b></td>")
                lfTable.Append("<td class=""sm"" align=""center"">&nbsp;</td>")
                lfTable.Append("<td class=""sm"" align=""center""><b>Available Menu Items</b></td></tr>")
                lfTable.Append("<tr><td class=""sm""><select name=""fid"" class=""smInput"" size=""10"" style=""width:200px;"">")
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_NoAdminMenuAccess", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@userid", SqlDbType.Int)
                dataParam.Value = _userID
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader()
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                            If dataRdr.Item(0) = _forumID Then
                                lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + " selectd>")
                            Else
                                lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                            End If
                            lfTable.Append(dataRdr.Item(1) + "</option>")
                        End If
                    End While
                    dataRdr.Close()
                End If
                dataConn.Close()
                lfTable.Append("</select></td><td class=""sm"" width=""65"" align=""center"">")
                lfTable.Append("<input type=""submit"" value="" >> "" class=""smButton""></form>")
                lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                lfTable.Append("<input type=""hidden"" name=""fi"" value=""12"">")
                lfTable.Append("<input type=""hidden"" name=""uid"" value=" + Chr(34) + _userID.ToString + Chr(34) + ">")
                lfTable.Append("<input type=""hidden"" name=""ua"" value=""2"">")
                lfTable.Append("<input type=""submit"" value="" << "" class=""smButton""></td>")
                lfTable.Append("<td class=""sm""><select name=""fid"" class=""smInput"" size=""10"" style=""width:200px;"">")
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_AdminMenuAccess", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@userid", SqlDbType.Int)
                dataParam.Value = _userID
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader()
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                            If dataRdr.Item(0) = _forumID Then
                                lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + " selectd>")
                            Else
                                lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                            End If
                            lfTable.Append(dataRdr.Item(1) + "</option>")
                        End If
                    End While
                    dataRdr.Close()
                End If
                dataConn.Close()
                lfTable.Append("</select></td></tr>")

                lfTable.Append("</table></form></td></tr>")


            End If

            lfTable.Append("<tr><td colspan=""2"" class=""sm"" valign=""top""><hr size=""1"" noshade><b>Current Menu Access :</b><br />Select the 'Login Name' link to modify the admin menu for an existing user.")

            Dim lu As Integer = 0
            Dim lm As String = String.Empty
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_GetAdminMenuUsers", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader()
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    If dataRdr.IsDBNull(3) = False And dataRdr.IsDBNull(4) = False Then
                        If lu <> dataRdr.Item(2) Then
                            If lu <> 0 Then
                                lfTable.Append("</td></tr></table>")
                                lm = String.Empty
                            End If
                            lu = dataRdr.Item(2)
                            lfTable.Append("<hr size=""1"" noshade /><table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
                            lfTable.Append("<tr><td class=""sm"" valign=""top"" width=""30%"">")
                            lfTable.Append("Real Name : " + dataRdr.Item(4) + "<br />")
                            lfTable.Append("Login Name : <a href=" + Chr(34) + siteRoot + "/admin/?fi=12&uid=" + CStr(dataRdr.Item(2)) + Chr(34))
                            lfTable.Append(">" + dataRdr.Item(3) + "</a></td><td class=""sm"" valign=""top"" width=""70%"">")
                        End If
                        If lm <> dataRdr.Item(5) Then
                            lm = dataRdr.Item(5)
                            lfTable.Append("<i>" + dataRdr.Item(5) + "</i><br />")
                        End If
                        lfTable.Append("&nbsp; &nbsp; " + dataRdr.Item(1) + "<br />")
                    End If
                End While
                dataRdr.Close()
            End If
            dataConn.Close()
            lfTable.Append("</td</tr></table></td></tr>")

            lfTable.Append("<tr><td colspan=""2"">&nbsp;</td></tr></form></table>")
            Return lfTable.ToString
        End Function

        '-- thread pruning
        Private Function loadForm13(ByVal uGUID As String) As String
            Dim lfTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
            If getAdminMenuAccess(13, uGUID) = False Then
                lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                Return lfTable.ToString
                Exit Function
            End If
            If _formVerify = False And _forumID = 0 Then
                lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                lfTable.Append("<input type=""hidden"" name=""fi"" value=""13"" />")
                lfTable.Append("<tr><td class=""md"" colspan=""2""><b>Thread Pruning</b></td></tr>")
                lfTable.Append("<tr><td class=""sm"" colspan=""2"">This will delete any topic which has not had any replies posted and is older than the number of days you select. It will not remove topics that are marked as 'sticky'.<br />NOTE : If you do not enter a number larger than 0 for the minimum age, then all topics without replies will be deleted.</td></tr>")
                lfTable.Append("<tr><td class=""sm"" width=""30%"" valign=""top"">Select the Forum to prune :</td>")
                lfTable.Append("<td class=""sm"" width=""70%"" valign=""baseline""><select name=""fid"" class=""smInput"">")
                lfTable.Append("<option value=""-1"">All Forums</option>")
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_ModerateForums", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                            lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                            lfTable.Append(dataRdr.Item(1) + "</option>")
                        End If
                    End While
                    dataRdr.Close()
                    dataConn.Close()
                End If

                lfTable.Append("</select></td></tr>")
                lfTable.Append("<tr><td class=""sm"" width=""30%"" valign=""top"">Enter the minimum age in days :</td>")
                lfTable.Append("<td class=""sm"" width=""70%"" valign=""baseline""><input type=""text"" size=""5"" maxlength=""4"" style=""text-align:center;"" class=""smInput"" name=""mxp"" value=""45""></td></tr>")
                lfTable.Append("<tr><td class=""sm"">&nbsp;</td><td class=""sm""><input type=""submit"" class=""smButton"" value=""  GO  ""></td></tr></form>")
            ElseIf _formVerify = False And _forumID <> 0 Then  '-- postback to verify
                Dim fName As String = String.Empty
                Dim fCount As Integer = 0
                If _mxPost > 0 Then
                    _mxPost = _mxPost * -1
                End If
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_ThreadPruneCheck", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataParam = dataCmd.Parameters.Add("@MinDays", SqlDbType.Int)
                dataParam.Value = _mxPost
                dataParam = dataCmd.Parameters.Add("@ForumName", SqlDbType.VarChar, 50)
                dataParam.Direction = ParameterDirection.Output
                dataParam = dataCmd.Parameters.Add("@ThreadCount", SqlDbType.Int)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                fCount = dataCmd.Parameters("@ThreadCount").Value
                fName = dataCmd.Parameters("@ForumName").Value
                dataConn.Close()
                If fCount > 0 Then
                    lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                    lfTable.Append("<input type=""hidden"" name=""fi"" value=""13"" />")
                    lfTable.Append("<input type=""hidden"" name=""verify"" value=""1"" />")
                    lfTable.Append("<input type=""hidden"" name=""fid"" value=" + Chr(34) + _forumID.ToString + Chr(34) + " />")
                    lfTable.Append("<input type=""hidden"" name=""mxp"" value=" + Chr(34) + _mxPost.ToString + Chr(34) + " />")
                    lfTable.Append("<tr><td class=""md""><b>Thread Pruning</b></td></tr>")
                    lfTable.Append("<tr><td class=""sm"">You are about to <b>DELETE</b> " + fCount.ToString + " posts from " + fName + ".  Are you sure you want to do this?</td></tr>")
                    lfTable.Append("<tr><td class=""sm"">When running this update, it might take a little time as the forum listings must be recalculated.  Please be patient and wait for the 'Completed' message after continuing.</td></tr>")
                    lfTable.Append("<tr><td class=""sm"" align=""center""><input type=""submit"" value=""CONTINUE"" class=""smButton"">&nbsp;")
                    lfTable.Append("<input type=""button"" value=""CANCEL"" class=""smButton"" onclick=""window.location.href='" + siteRoot + "/admin/';"">")
                    lfTable.Append("</td></tr></form>")
                    logAdminAction(uGUID, "Preparing to prune forum '" + fName + "'.")
                Else
                    lfTable.Append("<tr><td class=""md""><b>Thread Pruning</b></td></tr>")
                    lfTable.Append("<tr><td class=""sm"">You do not have any posts requiring pruning that match your request.</td></tr>")
                End If
            ElseIf _formVerify = True And _forumID <> 0 Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_DoThreadPrune", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataParam = dataCmd.Parameters.Add("@MinDays", SqlDbType.Int)
                dataParam.Value = _mxPost
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                logAdminAction(uGUID, "Forum Pruned.")
                lfTable.Append("<tr><td class=""md""><b>Thread Pruning</b></td></tr>")
                lfTable.Append("<tr><td class=""sm"">Your pruning request has been completed.</td></tr>")
            End If


            lfTable.Append("</table>")
            Return lfTable.ToString
        End Function

        '-- Web.Config viewer
        Private Function loadForm15(ByVal uGUID As String) As String
            Dim lfTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
            If getAdminMenuAccess(15, uGUID) = False Then
                lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                Return lfTable.ToString
                Exit Function
            End If
            logAdminAction(uGUID, "Accessed Web.Config viewer")
            lfTable.Append("<tr><td colspan=""2"" class=""md"" height=""20"" valign=""top""><b>Web.Config Viewer</b></td></tr>")
            lfTable.Append("<tr><td colspan=""2"" class=""sm"" height=""20"" valign=""top"">Due to security restrictions, the Web.Config file must be manually edited.<br />Below are the items related to the dotNetBB forum found in your current Web.Config file.<hr size=""1"" noshade /></td></tr>")
            lfTable.Append("<tr><td width=""30%"" class=""sm"" height=""20"" align=""right""><b>Base Site URL : </b></td>")
            lfTable.Append("<td width=""70%"" class=""sm"" height=""20"">" + siteURL + "</td></tr>")
            lfTable.Append("<tr><td width=""30%"" class=""sm"" height=""20"" align=""right""><b>dotNetBB Root Folder : </b></td>")
            lfTable.Append("<td width=""70%"" class=""sm"" height=""20"">" + siteRoot + "</td></tr>")
            lfTable.Append("<tr><td width=""30%"" class=""sm"" height=""20"" align=""right""><b>Forum Title : </b></td>")
            lfTable.Append("<td width=""70%"" class=""sm"" height=""20"">" + boardTitle + "</td></tr>")
            lfTable.Append("<tr><td width=""30%"" class=""sm"" height=""20"" align=""right""><b>SQL Connection String : </b></td>")
            lfTable.Append("<td width=""70%"" class=""sm"" height=""20"">" + connStr + "</td></tr>")
            lfTable.Append("<tr><td width=""30%"" class=""sm"" height=""20"" align=""right""><b>Forum Admin Name : </b></td>")
            lfTable.Append("<td width=""70%"" class=""sm"" height=""20"">" + siteAdmin + "</td></tr>")
            lfTable.Append("<tr><td width=""30%"" class=""sm"" height=""20"" align=""right""><b>Forum Admin E-Mail : </b></td>")
            lfTable.Append("<td width=""70%"" class=""sm"" height=""20"">" + siteAdminMail + "</td></tr>")

            lfTable.Append("<tr><td colspan=""2"">&nbsp;</td></tr></form></table>")
            Return lfTable.ToString
        End Function

        '-- emoticon replacements
        Private Function loadForm16(ByVal uGUID As String) As String
            Dim imageName As String = String.Empty
            Dim imageKeys As String = String.Empty
            Dim imageAltText As String = String.Empty
            Dim imageID As Integer = 0
            Dim addEditBox As New StringBuilder()
            Dim fileEntries() As String = Directory.GetFiles(Server.MapPath(siteRoot + "/emoticons"))
            Dim fileTotal As Integer = UBound(fileEntries)
            Dim fLoop As Integer = 0
            Dim cImg As String = String.Empty
            Dim imgStr As String = String.Empty
            Dim hasI As Boolean = False
            Dim infoStr As String = String.Empty

            Dim lfTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
            Dim validEmot() As String
            Dim iEmot As Integer = 0

            If getAdminMenuAccess(16, uGUID) = False Then
                lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                Return lfTable.ToString
                Exit Function
            End If
            If _loadForm = "a" And _forumName <> String.Empty Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_EnableEmoticon", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@Emoticon", SqlDbType.VarChar, 50)
                dataParam.Value = _forumName
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                logAdminAction(uGUID, "Enabled Emoticon '" + _forumName + "'.")
            ElseIf _loadForm = "d" And _forumID > 0 Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_DisableEmoticon", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@imageID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                logAdminAction(uGUID, "Deactivated emoticon")
            ElseIf (_loadForm = "e" Or _loadForm = "c") And _forumID > 0 And _formVerify = False Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_GetEmotForEdit", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@imageID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False And dataRdr.IsDBNull(2) = False Then
                            imageID = dataRdr.Item(0)
                            imageName = dataRdr.Item(1)
                            imageKeys = dataRdr.Item(2)
                            If dataRdr.IsDBNull(3) = False Then
                                imageAltText = dataRdr.Item(3)
                            End If
                        End If
                    End While
                    dataRdr.Close()
                    dataConn.Close()
                End If
            ElseIf _loadForm = "e" And _forumID > 0 And _formVerify = True Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_UpdateEmoticon", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@imageID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataParam = dataCmd.Parameters.Add("@imageName", SqlDbType.VarChar, 50)
                dataParam.Value = _forumName
                dataParam = dataCmd.Parameters.Add("@imageKeys", SqlDbType.VarChar, 50)
                dataParam.Value = _forumDesc
                dataParam = dataCmd.Parameters.Add("@imageAltText", SqlDbType.VarChar, 50)
                dataParam.Value = _cTitle
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                _loadForm = String.Empty
                _forumID = 0
                _formVerify = False
                infoStr = "Emoticon edited successfully."
                logAdminAction(uGUID, "Edited emoticon '" + _forumName + "'.")

            ElseIf _loadForm = "c" And _formVerify = True Then
                Dim goodKey As Integer = 0
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_AddClonedEmoticon", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@imageName", SqlDbType.VarChar, 50)
                dataParam.Value = _forumName
                dataParam = dataCmd.Parameters.Add("@imageKeys", SqlDbType.VarChar, 50)
                dataParam.Value = _forumDesc
                dataParam = dataCmd.Parameters.Add("@imageAltText", SqlDbType.VarChar, 50)
                dataParam.Value = _cTitle
                dataParam = dataCmd.Parameters.Add("@GoodKey", SqlDbType.Int)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                goodKey = dataCmd.Parameters("@GoodKey").Value
                dataConn.Close()
                If goodKey = 1 Then
                    _loadForm = String.Empty
                    _forumID = 0
                    _formVerify = False
                    infoStr = "Emoticon cloned successfully."
                    logAdminAction(uGUID, "Cloned emoticon '" + _forumName + "'.")
                Else
                    imageName = _forumName
                    imageKeys = _forumDesc
                    imageAltText = _cTitle
                    infoStr = "Unable to clone, code replacement already exists."
                End If

            End If

            addEditBox.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""400"" class=""tblStd"">")
            addEditBox.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
            addEditBox.Append("<input type=""hidden"" name=""fi"" value=""16"" />")

            If _loadForm = "c" Then
                addEditBox.Append("<input type=""hidden"" name=""r"" value=""c"" />")
                addEditBox.Append("<input type=""hidden"" name=""verify"" value=""1"" />")
            ElseIf _loadForm = "e" Then
                addEditBox.Append("<input type=""hidden"" name=""r"" value=""e"" />")
                addEditBox.Append("<input type=""hidden"" name=""verify"" value=""1"" />")
                addEditBox.Append("<input type=""hidden"" name=""fid"" value=" + Chr(34) + imageID.ToString + Chr(34) + " /")
            End If

            addEditBox.Append("<tr><td class=""smRowHead"" colspan=""2""><b>")
            If _loadForm = "c" Then
                addEditBox.Append("Cloned Emoticon Replacement")
            ElseIf _loadForm = "e" Then
                addEditBox.Append("Edit Emoticon Replacement")
            End If
            addEditBox.Append("</b></td></tr>")
            addEditBox.Append("<tr><td class=""smRow"" align=""right""><b>Image Name : </b></td>")
            addEditBox.Append("<td class=""smRow""><select name=""fn"" class=""smInput"">")

            If fileTotal > 0 Then
                For fLoop = 1 To fileTotal
                    hasI = False
                    Dim fn As New FileInfo(fileEntries(fLoop))
                    If Right(fn.Name.ToString, 3).ToLower = "gif" Then
                        cImg = fn.Name.ToString
                        If cImg = imageName Then
                            addEditBox.Append("<option selected>" + cImg + "</option>")
                        Else
                            addEditBox.Append("<option>" + cImg + "</option>")
                        End If
                    End If
                Next
            End If
            addEditBox.Append("</select></td></tr>")
            addEditBox.Append("<tr><td class=""smRow"" align=""right""><b>Code Replacement : </b></td>")
            addEditBox.Append("<td class=""smRow""><input type=""text"" size=""20"" class=""smInput"" name=""fd"" value=" + Chr(34) + imageKeys + Chr(34) + "></td></tr>")
            addEditBox.Append("<tr><td class=""smRow"" align=""right""><b>ALT tag text : </b></td>")
            addEditBox.Append("<td class=""smRow""><input type=""text"" size=""20"" class=""smInput"" name=""ct"" value=" + Chr(34) + imageAltText + Chr(34) + "></td></tr>")
            addEditBox.Append("<tr><td class=""smRow"" align=""center"" colspan=""2""><input type=""submit"" class=""smButton" + Chr(34))
            If _loadForm = "c" Then
                addEditBox.Append(" value=""Clone Emoticon" + Chr(34))
            ElseIf _loadForm = "e" Then
                addEditBox.Append(" value=""Update Emoticon" + Chr(34))
            End If
            addEditBox.Append("></td></tr>")

            addEditBox.Append("</table>")

            lfTable.Append("<tr><td class=""md"" height=""20"" valign=""top""><b>Emoticon Replacement Editing</b></td></tr>")
            lfTable.Append("<tr><td class=""sm"" height=""20"" valign=""top"">Add or Modify emoticon replacements that users can add to their posts.</td></tr>")
            If infoStr <> String.Empty Then
                lfTable.Append("<tr><td class=""smError"" height=""20"">" + infoStr + "</td></tr>")
            End If

            If _loadForm = "c" Or _loadForm = "e" Then
                lfTable.Append("<tr><td class=""sm"" height=""20"" align=""center"">" + addEditBox.ToString + "</td></tr>")
            End If
            lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top""><br /><b>Active Emoticons</b><br /><table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""75%"" class=""tblStd"">")
            lfTable.Append("<tr><td class=""smRowHead"" align=""center"" width=""20%""><b>Image</b></td>")
            lfTable.Append("<td class=""smRowHead"" align=""center"" width=""20%""><b>Code Replacement</b></td>")
            lfTable.Append("<td class=""smRowHead"" align=""center"" width=""20%""><b>Alt Text</b></td>")
            lfTable.Append("<td class=""smRowHead"" align=""center"" width=""40%""><b>Action</b></td></tr>")
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_ActiveEmoticon", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False And dataRdr.IsDBNull(2) = False Then
                        iEmot += 1
                        ReDim Preserve validEmot(iEmot)
                        validEmot(iEmot) = dataRdr.Item(1)
                        lfTable.Append("<tr><td class=""smRow"" align=""center"" width=""20%""><img src=" + Chr(34) + siteRoot + "/emoticons/" + dataRdr.Item(1) + Chr(34) + "></td>")
                        lfTable.Append("<td class=""smRow"" align=""center"" width=""20%"">" + dataRdr.Item(2) + "</td>")
                        lfTable.Append("<td class=""smRow"" align=""center"" width=""20%"">")
                        If dataRdr.IsDBNull(3) = False Then
                            lfTable.Append(dataRdr.Item(3))
                        Else
                            lfTable.Append("&nbsp;")
                        End If
                        lfTable.Append("</td>")
                        lfTable.Append("<td class=""smRow"" align=""center"" width=""40%""><a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=16&r=e&fid=" + CStr(dataRdr.Item(0)) + Chr(34) + ">EDIT</a> | ")
                        lfTable.Append("<a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=16&r=c&fid=" + CStr(dataRdr.Item(0)) + Chr(34) + ">CLONE</a>")
                        lfTable.Append(" | <a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=16&r=d&fid=" + CStr(dataRdr.Item(0)) + Chr(34) + ">DISABLE</a></td></tr>")
                    End If

                End While
                dataRdr.Close()
                dataConn.Close()
            End If
            lfTable.Append("</table>")
            If iEmot = 0 Then
                ReDim Preserve validEmot(1)
                validEmot(1) = String.Empty
            End If
            lfTable.Append("<br /><b>Inactive Emoticons</b><br /><table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""75%"" class=""tblStd"">")
            lfTable.Append("<tr><td class=""smRowHead"" align=""center"" width=""25%""><b>Image</b></td>")
            lfTable.Append("<td class=""smRowHead"" align=""center"" width=""25%""><b>Code Replacement</b></td>")
            lfTable.Append("<td class=""smRowHead"" align=""center"" width=""25%""><b>Alt Text</b></td>")
            lfTable.Append("<td class=""smRowHead"" align=""center"" width=""25%""><b>Action</b></td></tr>")
            If fileTotal > 0 Then
                For fLoop = 1 To fileTotal
                    hasI = False
                    Dim fn As New FileInfo(fileEntries(fLoop))
                    If Right(fn.Name.ToString, 3).ToLower = "gif" Then
                        cImg = Left(fn.Name.ToString, fn.Name.ToString.Length - 4).ToString
                        cImg = cImg
                        imgStr = "<img src=" + Chr(34) + siteRoot + "/emoticons/" + cImg + ".gif"" alt="":" + cImg + ":"" >"
                        For iEmot = 1 To UBound(validEmot)
                            If (cImg.ToLower + ".gif") = validEmot(iEmot).ToString.ToLower Then
                                hasI = True
                                Exit For
                            End If
                        Next
                        If hasI = False Then
                            lfTable.Append("<tr><td class=""smRow"" align=""center"" width=""25%"">" + imgStr + "</td>")
                            lfTable.Append("<td class=""smRow"" align=""center"" width=""25%"">:" + cImg + ":</td>")
                            lfTable.Append("<td class=""smRow"" align=""center"" width=""25%"">" + cImg + "</td>")
                            lfTable.Append("<td class=""smRow"" align=""center"" width=""25%""><a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=16&r=a&fn=" + Server.UrlEncode(cImg) + Chr(34) + ">ENABLE</a></td></tr>")
                        End If
                    End If
                Next
            End If



            lfTable.Append("</table></td></tr>")
            lfTable.Append("<tr><td>&nbsp;</td></tr></form></table>")
            Return lfTable.ToString

        End Function

        '-- avatars
        Private Function loadForm17(ByVal uGUID As String) As String
            Dim lfTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
            Dim fileEntries() As String = Directory.GetFiles(Server.MapPath(siteRoot + "/avatar/"))
            Dim fileTotal As Integer = UBound(fileEntries)
            Dim fLoop As Integer = 0
            Dim cImg As String = String.Empty
            Dim imgStr As String = String.Empty
            Dim hasI As Boolean = False
            Dim aI As Integer = 0
            Dim p1 As Boolean = False
            Dim aImages() As String
            Dim aCount As Integer = 0
            Dim inpStr As String = String.Empty
            Dim goodAdd As Integer = 0

            If getAdminMenuAccess(17, uGUID) = False Then
                lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                Return lfTable.ToString
                Exit Function
            End If
            If _forumName <> String.Empty And _loadForm = "a" Then

                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_ActivateAvatar", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@imageName", SqlDbType.VarChar, 50)
                dataParam.Value = _forumName
                dataParam = dataCmd.Parameters.Add("@goodAdd", SqlDbType.Int)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                goodAdd = dataCmd.Parameters("@goodAdd").Value
                dataConn.Close()
                If goodAdd = 0 Then
                    inpStr = "An avatar with the same name already exists."
                Else
                    inpStr = "Selected avatar activated."
                    logAdminAction(uGUID, "Activated avatar '" + _forumName + "'.")
                End If
                _forumName = String.Empty
                _loadForm = String.Empty

            ElseIf _loadForm = "ad" Then    '-- deactivate all
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_DeactivateAllAvatars", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                logAdminAction(uGUID, "Deactivated all available avatars")
                inpStr = "All Avatar's deactivated."

            ElseIf _loadForm = "ai" Then    '-- activate all
                For fLoop = 1 To fileTotal
                    Dim fn As New FileInfo(fileEntries(fLoop))
                    cImg = fn.Name.ToString
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_ADMIN_ActivateAvatar", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@imageName", SqlDbType.VarChar, 50)
                    dataParam.Value = cImg
                    dataParam = dataCmd.Parameters.Add("@goodAdd", SqlDbType.Int)
                    dataParam.Direction = ParameterDirection.Output
                    dataConn.Open()
                    dataCmd.ExecuteNonQuery()
                    goodAdd = dataCmd.Parameters("@goodAdd").Value
                    dataConn.Close()
                Next
                logAdminAction(uGUID, "Activated all available avatars")
                inpStr = "All Avatar's Activated."

            ElseIf _forumID > 0 And _loadForm = "d" Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_DeActivateAvatar", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@imageID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                logAdminAction(uGUID, "Deactivated avatar.")
                inpStr = "Selected avatar deactivated."
            End If

            lfTable.Append("<tr><td class=""md"" height=""20"" valign=""top""><b>User Avatars</b></td></tr>")
            lfTable.Append("<tr><td class=""sm"" height=""20"" valign=""top"">Use the tables activate or deactivate the available avatars from the site.<br />NOTE : External user avatar permissions can be set on the 'End User Experience' page.</td></tr>")

            If inpStr <> String.Empty Then
                lfTable.Append("<tr><td class=""smError"" height=""20"" valign=""top""><b>" + inpStr + "</b></td></tr>")
            End If
            lfTable.Append("<tr><td class=""sm"" height=""20"" valign=""top"" align=""center""><br /><b>Active Avatars</b> -- <a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=17&r=ad"">Remove all active avatars</a><br /><table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""75%"" class=""tblStd"">")
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_ActiveAvatars", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False And dataRdr.IsDBNull(2) = False Then
                        aI += 1
                        aCount += 1
                        ReDim Preserve aImages(aCount)
                        aImages(aCount) = dataRdr.Item(1)
                        cImg = dataRdr.Item(1)
                        imgStr = "<img src=" + Chr(34) + siteRoot + "/avatar/" + cImg + Chr(34) + " alt=""Click to disable"" border=""0"">"
                        If aI > 5 Then  '-- row marker...
                            aI = 1
                            If p1 = False Then  '-- first row
                                p1 = True
                                lfTable.Append("<tr>")
                            Else
                                lfTable.Append("</tr><tr>")
                            End If
                        End If
                        lfTable.Append("<td class=""smRow"" align=""center"" width=""20%"">")
                        lfTable.Append("<a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=17&fid=" + CStr(dataRdr.Item(0)) + "&r=d" + Chr(34) + ">")
                        lfTable.Append(imgStr + "</a><br />" + CStr(dataRdr.Item(2)) + " users</td>")
                    End If
                End While
                dataRdr.Close()
                dataConn.Close()
            End If
            If aCount = 0 Then
                ReDim aImages(1)
                aImages(1) = String.Empty
            End If
            If aI >= 1 And aI < 5 Then
                While aI < 5
                    aI += 1
                    lfTable.Append("<td class=""smRow"" align=""center"">&nbsp;</td>")
                End While
                lfTable.Append("</tr>")
            End If
            lfTable.Append("</table>")


            p1 = False
            aI = 1
            lfTable.Append("<br /><b>Inactive Avatars</b>")
            If fileTotal > 0 Then
                lfTable.Append(" -- <a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=17&r=ai"">Activate all inactive avatars</a>")
            End If
            lfTable.Append("<br /><table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""75%"" class=""tblStd"">")
            If fileTotal > 0 Then
                For fLoop = 1 To fileTotal
                    hasI = False
                    Dim fn As New FileInfo(fileEntries(fLoop))
                    cImg = fn.Name.ToString
                    imgStr = "<img src=" + Chr(34) + siteRoot + "/avatar/" + cImg + Chr(34) + " alt=""Click to enable"" border=""0"">"
                    If aI > 5 Then  '-- row marker...
                        aI = 1
                        If p1 = False Then  '-- first row
                            p1 = True
                            lfTable.Append("<tr>")
                        Else
                            lfTable.Append("</tr><tr>")
                        End If
                    End If
                    For aCount = 1 To UBound(aImages)
                        If aImages(aCount) = cImg Then
                            hasI = True
                            Exit For
                        End If
                    Next
                    If hasI = False Then
                        aI += 1 '-- cell count
                        lfTable.Append("<td class=""smRow"" align=""center""><a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=17&fn=" + Server.UrlEncode(cImg) + "&r=a"">" + imgStr + "</a></td>")
                    End If
                Next
                If aI >= 1 And aI < 5 Then
                    While aI < 5
                        aI += 1
                        lfTable.Append("<td class=""smRow"" align=""center"">&nbsp;</td>")
                    End While
                    lfTable.Append("</tr>")
                End If
            End If

            lfTable.Append("</table></td></tr></table>")
            Return lfTable.ToString
        End Function

        '-- End user experience
        Private Function loadForm18(ByVal uGUID As String) As String
            Dim userAdded As Boolean = False
            Dim lfTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
            If getAdminMenuAccess(18, uGUID) = False Then
                lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                Return lfTable.ToString
                Exit Function
            End If

            lfTable.Append("<tr><td colspan=""2"" class=""md"" height=""20"" valign=""top""><b>End User Experience</b></td></tr>")
            If _formVerify = True Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_UpdateUserExperience", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@eu1", SqlDbType.Bit)
                dataParam.Value = _eu1
                dataParam = dataCmd.Parameters.Add("@eu2", SqlDbType.Bit)
                dataParam.Value = _eu2
                dataParam = dataCmd.Parameters.Add("@eu3", SqlDbType.Bit)
                dataParam.Value = _eu3
                dataParam = dataCmd.Parameters.Add("@eu4", SqlDbType.Bit)
                dataParam.Value = _eu4
                dataParam = dataCmd.Parameters.Add("@eu5", SqlDbType.Bit)
                dataParam.Value = _eu5
                dataParam = dataCmd.Parameters.Add("@eu6", SqlDbType.Bit)
                dataParam.Value = _eu6
                dataParam = dataCmd.Parameters.Add("@eu7", SqlDbType.Bit)
                dataParam.Value = _eu7
                dataParam = dataCmd.Parameters.Add("@eu8", SqlDbType.Bit)
                dataParam.Value = _eu8
                dataParam = dataCmd.Parameters.Add("@eu9", SqlDbType.Bit)
                dataParam.Value = _eu9
                dataParam = dataCmd.Parameters.Add("@eu10", SqlDbType.Bit)
                dataParam.Value = _eu10
                dataParam = dataCmd.Parameters.Add("@eu11", SqlDbType.Int)
                dataParam.Value = _eu11
                dataParam = dataCmd.Parameters.Add("@eu12", SqlDbType.Bit)
                dataParam.Value = _eu12
                dataParam = dataCmd.Parameters.Add("@eu13", SqlDbType.Bit)
                dataParam.Value = _eu13
                dataParam = dataCmd.Parameters.Add("@eu14", SqlDbType.Bit)
                dataParam.Value = _eu14
                dataParam = dataCmd.Parameters.Add("@eu15", SqlDbType.Bit)
                dataParam.Value = _eu15
                dataParam = dataCmd.Parameters.Add("@eu16", SqlDbType.VarChar, 10)
                dataParam.Value = _eu16
                dataParam = dataCmd.Parameters.Add("@eu17", SqlDbType.Bit)
                dataParam.Value = _eu17
                dataParam = dataCmd.Parameters.Add("@eu18", SqlDbType.Bit)
                dataParam.Value = _eu18
                dataParam = dataCmd.Parameters.Add("@eu19", SqlDbType.Bit)
                dataParam.Value = _eu19
                dataParam = dataCmd.Parameters.Add("@eu20", SqlDbType.Bit)
                dataParam.Value = _eu20
                dataParam = dataCmd.Parameters.Add("@eu21", SqlDbType.Bit)
                dataParam.Value = _eu21
                dataParam = dataCmd.Parameters.Add("@eu22", SqlDbType.Bit)
                dataParam.Value = _eu22
                dataParam = dataCmd.Parameters.Add("@eu23", SqlDbType.Bit)
                dataParam.Value = _eu23
                dataParam = dataCmd.Parameters.Add("@eu24", SqlDbType.Bit)
                dataParam.Value = _eu24
                dataParam = dataCmd.Parameters.Add("@eu25", SqlDbType.VarChar, 150)
                dataParam.Value = _eu25
                dataParam = dataCmd.Parameters.Add("@eu26", SqlDbType.VarChar, 200)
                dataParam.Value = _eu26
                dataParam = dataCmd.Parameters.Add("@eu27", SqlDbType.Int)
                dataParam.Value = _eu27
                dataParam = dataCmd.Parameters.Add("@eu28", SqlDbType.Bit)
                dataParam.Value = _eu28
                dataParam = dataCmd.Parameters.Add("@eu29", SqlDbType.Int)
                dataParam.Value = _eu29
                dataParam = dataCmd.Parameters.Add("@eu30", SqlDbType.Bit)
                dataParam.Value = _eu30
                dataParam = dataCmd.Parameters.Add("@eu32", SqlDbType.VarChar, 50)
                dataParam.Value = _eu32
                dataParam = dataCmd.Parameters.Add("@eu33", SqlDbType.VarChar, 50)
                dataParam.Value = _eu33
                dataParam = dataCmd.Parameters.Add("@eu34", SqlDbType.VarChar, 400)
                _eu34 = _eu34.Replace(vbCrLf, "<br />")
                dataParam.Value = _eu34
                dataParam = dataCmd.Parameters.Add("@eu35", SqlDbType.Bit)
                dataParam.Value = _eu35
                dataParam = dataCmd.Parameters.Add("@eu36", SqlDbType.Bit)
                dataParam.Value = _eu36
                dataParam = dataCmd.Parameters.Add("@eu37", SqlDbType.Bit)
                dataParam.Value = _eu37
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()

                If HttpContext.Current.Request.ServerVariables("AUTH_USER") <> "" And _eu36 = True Then

                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_ADMIN_AddAuthUserAccount", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@AUTH_USER", SqlDbType.VarChar, 100)
                    dataParam.Value = HttpContext.Current.Request.ServerVariables("AUTH_USER")
                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                    dataParam = dataCmd.Parameters.Add("@UserAdded", SqlDbType.Bit)
                    dataParam.Direction = ParameterDirection.Output
                    dataParam = dataCmd.Parameters.Add("@outGUID", SqlDbType.UniqueIdentifier)
                    dataParam.Direction = ParameterDirection.Output
                    dataConn.Open()
                    dataCmd.ExecuteNonQuery()
                    userAdded = dataCmd.Parameters("@UserAdded").Value
                    uGUID = XmlConvert.ToString(dataCmd.Parameters("@outGUID").Value)
                    dataConn.Close()
                    setUserCookie("uld", uGUID)
                End If
                logAdminAction(uGUID, "Updated End-User Experience settings.")
                lfTable.Append("<tr><td colspan=""2"" class=""smError"" height=""20"" valign=""top"">'End User Experience' settings successfully updated</td></tr>")
                If _eu36 = True Then
                    lfTable.Append("<tr><td colspan=""2"" class=""smError"" height=""20"" valign=""top""><b>NT AUTHENTICATION ENABLED</b><br />Using NT Authentication any existing dotNetBB accounts will remain, however users will not be able to log in unless ")
                    lfTable.Append("they have an NT User Account. All NT user accounts must be created separate from existing dotNetBB accounts when accessing the forum.  Enabling NT Authentication after the forum is already in use may ")
                    lfTable.Append(" cause problems with current members (e.g. unable to edit pre-existing posts.).  Additionally all moderators and administrators must create NT accounts separate from any pre-existing dotNetBB login and have their administration permissions reset.</td></tr>")
                End If
                If userAdded = True Then
                    lfTable.Append("<tr><td colspan=""2"" class=""smError"" height=""20"" valign=""top""><b>NOTE : Your NT User Account has been added with the same administration settings as you currently have.</td></tr>")
                End If


            Else
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_GetUserExperience", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(0) = False Then
                            _eu1 = dataRdr.Item(0)
                        End If
                        If dataRdr.IsDBNull(1) = False Then
                            _eu2 = dataRdr.Item(1)
                        End If
                        If dataRdr.IsDBNull(2) = False Then
                            _eu3 = dataRdr.Item(2)
                        End If
                        If dataRdr.IsDBNull(3) = False Then
                            _eu4 = dataRdr.Item(3)
                        End If
                        If dataRdr.IsDBNull(4) = False Then
                            _eu5 = dataRdr.Item(4)
                        End If
                        If dataRdr.IsDBNull(5) = False Then
                            _eu6 = dataRdr.Item(5)
                        End If
                        If dataRdr.IsDBNull(6) = False Then
                            _eu7 = dataRdr.Item(6)
                        End If
                        If dataRdr.IsDBNull(7) = False Then
                            _eu8 = dataRdr.Item(7)
                        End If
                        If dataRdr.IsDBNull(8) = False Then
                            _eu9 = dataRdr.Item(8)
                        End If
                        If dataRdr.IsDBNull(9) = False Then
                            _eu10 = dataRdr.Item(9)
                        End If
                        If dataRdr.IsDBNull(10) = False Then
                            _eu11 = dataRdr.Item(10)
                        End If
                        If dataRdr.IsDBNull(11) = False Then
                            _eu12 = dataRdr.Item(11)
                        End If
                        If dataRdr.IsDBNull(12) = False Then
                            _eu13 = dataRdr.Item(12)
                        End If
                        If dataRdr.IsDBNull(13) = False Then
                            _eu14 = dataRdr.Item(13)
                        End If
                        If dataRdr.IsDBNull(14) = False Then
                            _eu15 = dataRdr.Item(14)
                        End If
                        If dataRdr.IsDBNull(15) = False Then
                            _eu16 = dataRdr.Item(15)
                        End If
                        If dataRdr.IsDBNull(16) = False Then
                            _eu17 = dataRdr.Item(16)
                        End If
                        If dataRdr.IsDBNull(17) = False Then
                            _eu18 = dataRdr.Item(17)
                        End If
                        If dataRdr.IsDBNull(18) = False Then
                            _eu19 = dataRdr.Item(18)
                        End If
                        If dataRdr.IsDBNull(19) = False Then
                            _eu20 = dataRdr.Item(19)
                        End If
                        If dataRdr.IsDBNull(20) = False Then
                            _eu21 = dataRdr.Item(20)
                        End If
                        If dataRdr.IsDBNull(21) = False Then
                            _eu22 = dataRdr.Item(21)
                        End If
                        If dataRdr.IsDBNull(22) = False Then
                            _eu23 = dataRdr.Item(22)
                        End If
                        If dataRdr.IsDBNull(23) = False Then
                            _eu24 = dataRdr.Item(23)
                        End If
                        If dataRdr.IsDBNull(24) = False Then
                            _eu25 = dataRdr.Item(24)
                        End If
                        If dataRdr.IsDBNull(25) = False Then
                            _eu26 = dataRdr.Item(25)
                        End If
                        If dataRdr.IsDBNull(26) = False Then
                            _eu27 = dataRdr.Item(26)
                        End If
                        If dataRdr.IsDBNull(27) = False Then
                            _eu28 = dataRdr.Item(27)
                        End If
                        If dataRdr.IsDBNull(28) = False Then
                            _eu29 = dataRdr.Item(28)
                        End If
                        If dataRdr.IsDBNull(29) = False Then
                            _eu30 = dataRdr.Item(29)
                        End If
                        If dataRdr.IsDBNull(30) = False Then
                            _eu31 = dataRdr.Item(30)
                        End If
                        If dataRdr.IsDBNull(31) = False Then
                            _eu32 = dataRdr.Item(31)
                        End If
                        If dataRdr.IsDBNull(32) = False Then
                            _eu33 = dataRdr.Item(32)
                        End If
                        If dataRdr.IsDBNull(33) = False Then
                            _eu34 = dataRdr.Item(33)
                            _eu34 = _eu34.Replace("<br />", vbCrLf)
                        End If
                        If dataRdr.IsDBNull(34) = False Then
                            _eu35 = dataRdr.Item(34)
                        End If
                        If dataRdr.IsDBNull(35) = False Then
                            _eu36 = dataRdr.Item(35)
                        End If
                        If dataRdr.IsDBNull(36) = False Then
                            _eu37 = dataRdr.Item(36)
                        End If

                    End While
                    dataRdr.Close()
                    dataConn.Close()
                End If


                lfTable.Append("<tr><td colspan=""2"" class=""sm"" height=""20"" valign=""top"">Using the form below you can modify the items that are available in your forum.</td></tr>")
                lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                lfTable.Append("<input type=""hidden"" name=""fi"" value=""18"" />")
                lfTable.Append("<input type=""hidden"" name=""verify"" value=""1"" />")
                '-------------
                '-- Site general
                lfTable.Append("<tr><td class=""smRow"" colspan=""2""><br /><b>Site General</b></td></tr>")
                '-- Authentication
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Forum Authentication : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu36"" value=""0" + Chr(34))
                If _eu36 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - dotNetBB Authentication &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu36"" value=""1" + Chr(34))
                If _eu36 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - NT Authentication &nbsp;")
                lfTable.Append("</td></tr>")

                '-- thread/post totals
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Show thread/post totals : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu1"" value=""1" + Chr(34))
                If _eu1 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu1"" value=""0" + Chr(34))
                If _eu1 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '-- newest member
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Show newest member : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu2"" value=""1" + Chr(34))
                If _eu2 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu2"" value=""0" + Chr(34))
                If _eu2 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")
                '-- who's online
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Show who's online : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu3"" value=""1" + Chr(34))
                If _eu3 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu3"" value=""0" + Chr(34))
                If _eu3 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '-- Allow users to subscribe to forums
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Allow users to subscribe to forums : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu4"" value=""1" + Chr(34))
                If _eu4 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu4"" value=""0" + Chr(34))
                If _eu4 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '-- site theme
                lfTable.Append("<tr><td class=""smRow"">Default Site Theme : </td>")
                lfTable.Append("<td class=""smRow""><select name=""eu32"" class=""sm"">")
                Dim styleFolders() As String = Directory.GetFileSystemEntries(Server.MapPath(siteRoot + "/styles"))
                Dim di As New DirectoryInfo(Server.MapPath(siteRoot + "/styles"))
                Dim diArr As DirectoryInfo() = di.GetDirectories
                Dim dri As DirectoryInfo
                For Each dri In diArr
                    If dri.Name.ToString.ToLower = _eu32.ToLower Then
                        lfTable.Append("<option selected>" + Server.HtmlEncode(dri.Name.ToString) + "</option>")
                    Else
                        lfTable.Append("<option>" + Server.HtmlEncode(dri.Name.ToString) + "</option>")
                    End If
                Next
                lfTable.Append("</select></td></tr>")

                '-- COPPA Fax
                lfTable.Append("<tr><td class=""smRow"">COPPA Fax Number : </td>")
                lfTable.Append("<td class=""smRow""><input type=""text"" size=""30"" class=""smInput"" maxlength=""50"" name=""eu33"" value=" + Chr(34) + _eu33 + Chr(34) + "></td></tr>")
                '-- COPPA Mail Address
                lfTable.Append("<tr><td class=""smRow"" valign=""top"">COPPA Mail Address : <br /><br />For more COPPA information go to :<br /><a href=""http://www.ftc.gov/opa/1999/9910/childfinal.htm"" target=""_blank"">http://www.ftc.gov/opa/1999/9910/childfinal.htm</a></td>")
                lfTable.Append("<td class=""smRow""><textarea cols=""50"" rows=""5"" class=""smInput"" name=""eu34"">" + _eu34 + "</textarea></td></tr>")


                '-------------
                '-- Posting
                lfTable.Append("<tr><td class=""smRow"" colspan=""2""><br /><b>Posting</b></td></tr>")
                '-- Show Quick post box
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Show Forum Quick Post Form : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu35"" value=""1" + Chr(34))
                If _eu35 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu35"" value=""0" + Chr(34))
                If _eu35 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '-- Allow mCode in posts
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Allow mCode in posts : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu5"" value=""1" + Chr(34))
                If _eu5 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu5"" value=""0" + Chr(34))
                If _eu5 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '-- Allow topic icons
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Allow topic icons : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu6"" value=""1" + Chr(34))
                If _eu6 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu6"" value=""0" + Chr(34))
                If _eu6 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '-- Allow Emoticons
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Allow emoticons : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu7"" value=""1" + Chr(34))
                If _eu7 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu7"" value=""0" + Chr(34))
                If _eu7 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '-- Allow e-mail notifications of reply posts
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Allow e-mail reply notifications : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu8"" value=""1" + Chr(34))
                If _eu8 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu8"" value=""0" + Chr(34))
                If _eu8 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '-- Show end-user edited timestamp
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Show end-user edited timestamp : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu9"" value=""1" + Chr(34))
                If _eu9 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu9"" value=""0" + Chr(34))
                If _eu9 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '-- Show moderator edited timestamp
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Show moderator edited timestamp : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu10"" value=""1" + Chr(34))
                If _eu10 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu10"" value=""0" + Chr(34))
                If _eu10 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '-- Spam Timer (in seconds)
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Anti-Spam Timer (in seconds) : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%""><input type=""text"" size=""5"" style=""text-align:center;"" class=""smInput"" name=""eu11"" value=" + Chr(34) + _eu11.ToString + Chr(34) + ">")
                lfTable.Append("</td></tr>")

                '-------------
                '-- Profile
                lfTable.Append("<tr><td class=""smRow"" colspan=""2""><br /><b>User Profiles</b></td></tr>")

                '-- Require E-mail verification for new accounts
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">E-mail verification for new accounts : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu12"" value=""1" + Chr(34))
                If _eu12 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu12"" value=""0" + Chr(34))
                If _eu12 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td>")

                '-- View profile details as guest
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">View user profiles as guest : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu13"" value=""1" + Chr(34))
                If _eu13 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu13"" value=""0" + Chr(34))
                If _eu13 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '----------------------------------------
                '-- new in v2.1

                '-- customizable titles
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Allow users to edit custom titles : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu37"" value=""1" + Chr(34))
                If _eu37 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu37"" value=""0" + Chr(34))
                If _eu37 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '-- end new in v2.1
                '----------------------------------------

                '-- Allow Avatars
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Allow Avatars : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu14"" value=""1" + Chr(34))
                If _eu14 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu14"" value=""0" + Chr(34))
                If _eu14 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '-- Allow Remote Avatars
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Allow Remote Avatars : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu15"" value=""1" + Chr(34))
                If _eu15 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu15"" value=""0" + Chr(34))
                If _eu15 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '-- Remote avatar size (h,w)
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Remote avatar size (h,w) : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%""><input type=""text"" size=""5"" style=""text-align:center;"" class=""smInput"" name=""eu16"" value=" + Chr(34) + _eu16 + Chr(34) + ">")
                lfTable.Append("</td></tr>")

                '-- Allow AIM
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Allow AIM : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu17"" value=""1" + Chr(34))
                If _eu17 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu17"" value=""0" + Chr(34))
                If _eu17 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '-- Allow Y!
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Allow Y! : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu18"" value=""1" + Chr(34))
                If _eu18 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu18"" value=""0" + Chr(34))
                If _eu18 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '-- Allow MSN
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Allow MSN : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu19"" value=""1" + Chr(34))
                If _eu19 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu19"" value=""0" + Chr(34))
                If _eu19 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '-- Allow ICQ
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Allow ICQ : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu20"" value=""1" + Chr(34))
                If _eu20 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu20"" value=""0" + Chr(34))
                If _eu20 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '-- Allow E-Mail
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Allow E-Mail : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu21"" value=""1" + Chr(34))
                If _eu21 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu21"" value=""0" + Chr(34))
                If _eu21 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '-- Allow Homepage
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Allow Homepage : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu22"" value=""1" + Chr(34))
                If _eu22 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu22"" value=""0" + Chr(34))
                If _eu22 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '-- Allow Signature
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Allow Signature : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu23"" value=""1" + Chr(34))
                If _eu23 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu23"" value=""0" + Chr(34))
                If _eu23 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '-- Allow mCode in Signature
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Allow mCode in Signature : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu24"" value=""1" + Chr(34))
                If _eu24 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu24"" value=""0" + Chr(34))
                If _eu24 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")
                '-------------
                '-- private messaging
                lfTable.Append("<tr><td class=""smRow"" colspan=""2""><br /><b>Private Messaging</b></td></tr>")
                '-- allow PM
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Allow Private Messaging : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%"">")
                lfTable.Append("<input type=""radio"" name=""eu30"" value=""1" + Chr(34))
                If _eu30 = True Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - Yes &nbsp;")
                lfTable.Append("<input type=""radio"" name=""eu30"" value=""0" + Chr(34))
                If _eu30 = False Then
                    lfTable.Append(" checked")
                End If
                lfTable.Append("> - No &nbsp;")
                lfTable.Append("</td></tr>")

                '-- max messages
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Maximum saved messages per user : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%""><input type=""text"" size=""5"" style=""text-align:center;"" class=""smInput"" name=""eu29"" value=" + Chr(34) + _eu29.ToString + Chr(34) + ">")
                lfTable.Append("</td></tr>")

                '-------------
                '-- cookie
                lfTable.Append("<tr><td class=""smRow"" colspan=""2""><br /><b>Cookie Settings</b></td></tr>")
                '-- cookie domain name
                'lfTable.Append("<tr><td class=""smRow"" width=""40%"">Cookie domain name : </td>")
                'lfTable.Append("<td class=""smRow"" width=""60%""><input type=""text"" size=""30"" class=""smInput"" maxlength=""150"" name=""eu25"" value=" + Chr(34) + _eu25.ToString + Chr(34) + ">")
                'lfTable.Append("</td>")
                '-- cookie path
                'lfTable.Append("<tr><td class=""smRow"" width=""40%"">Cookie path : </td>")
                'lfTable.Append("<td class=""smRow"" width=""60%""><input type=""text"" size=""30"" class=""smInput"" maxlength=""200"" name=""eu26"" value=" + Chr(34) + _eu26.ToString + Chr(34) + ">")
                'lfTable.Append("</td>")
                '-- cookie epiration
                lfTable.Append("<tr><td class=""smRow"" width=""40%"">Cookie expiration (in days) : </td>")
                lfTable.Append("<td class=""smRow"" width=""60%""><input type=""text"" size=""5"" style=""text-align:center;"" class=""smInput"" name=""eu27"" value=" + Chr(34) + _eu27.ToString + Chr(34) + ">")
                lfTable.Append("</td></tr>")

                '-- Allow saving login to cookie
                'lfTable.Append("<tr><td class=""smRow"" width=""40%"">Allow saving login to cookie : </td>")
                'lfTable.Append("<td class=""smRow"" width=""60%"">")
                'lfTable.Append("<input type=""radio"" name=""eu28"" value=""1" + Chr(34))
                'If _eu28 = True Then
                '    lfTable.Append(" checked")
                'End If
                'lfTable.Append("> - Yes &nbsp;")
                'lfTable.Append("<input type=""radio"" name=""eu28"" value=""0" + Chr(34))
                'If _eu28 = False Then
                '    lfTable.Append(" checked")
                'End If
                'lfTable.Append("> - No &nbsp;")
                'lfTable.Append("</td>")
                lfTable.Append("<tr><td>&nbsp;</td><td><input type=""submit"" value=""UPDATE"" class=""smButton"" /></td></tr>")

                lfTable.Append("</form>")


            End If
            lfTable.Append("<tr><td colspan=""2"">&nbsp;</td></tr></form></table>")
            Return lfTable.ToString
        End Function

        '-- Word Censoring
        Private Function loadForm19(ByVal uGUID As String) As String
            Dim lfTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
            Dim errMsg As String = String.Empty
            Dim didAdd As Boolean = False
            If getAdminMenuAccess(19, uGUID) = False Then
                lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                Return lfTable.ToString
                Exit Function
            End If
            If _edOrDel = "e" And _messageID > 0 And _formVerify = False Then   '-- get for edit

                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_EditWordFilter", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@wordID", SqlDbType.Int)
                dataParam.Value = _messageID
                dataParam = dataCmd.Parameters.Add("@badWord", SqlDbType.VarChar, 50)
                dataParam.Direction = ParameterDirection.Output
                dataParam = dataCmd.Parameters.Add("@goodWord", SqlDbType.VarChar, 50)
                dataParam.Direction = ParameterDirection.Output
                dataParam = dataCmd.Parameters.Add("@applyFilter", SqlDbType.Int)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                _bWord = dataCmd.Parameters("@badWord").Value
                _gWord = dataCmd.Parameters("@goodWord").Value
                _tID = dataCmd.Parameters("@applyFilter").Value
                dataConn.Close()

            ElseIf _edOrDel = "e" And _messageID > 0 And _formVerify = True Then    '-- update filter
                If _bWord.ToString.Trim = String.Empty Then
                    errMsg = "<div class=""smError"">You did not enter the word to be filtered.</div>"
                Else
                    If _gWord.ToString.Trim = String.Empty Then
                        errMsg = "<div class=""smError"">You did not enter the replacement text for the filter word.</div>"
                    Else
                        dataConn = New SqlConnection(connStr)
                        dataCmd = New SqlCommand("TB_ADMIN_UpdateFilterWord", dataConn)
                        dataCmd.CommandType = CommandType.StoredProcedure
                        dataParam = dataCmd.Parameters.Add("@wordID", SqlDbType.Int)
                        dataParam.Value = _messageID
                        dataParam = dataCmd.Parameters.Add("@badWord", SqlDbType.VarChar, 50)
                        dataParam.Value = _bWord
                        dataParam = dataCmd.Parameters.Add("@goodWord", SqlDbType.VarChar, 50)
                        dataParam.Value = _gWord
                        dataParam = dataCmd.Parameters.Add("@applyFilter", SqlDbType.Int)
                        dataParam.Value = _tID
                        dataParam = dataCmd.Parameters.Add("@didAdd", SqlDbType.Bit)
                        dataParam.Direction = ParameterDirection.Output
                        dataConn.Open()
                        dataCmd.ExecuteNonQuery()
                        didAdd = dataCmd.Parameters("@didAdd").Value
                        dataConn.Close()
                        logAdminAction(uGUID, "Edited word censor filter for '" + _bWord + "'.")
                        If didAdd = False Then
                            errMsg = "<div class=""smError"">Another filter already exists with the word you entered.</div>"
                        Else
                            _edOrDel = "n"
                            _bWord = String.Empty
                            _gWord = String.Empty
                            _formVerify = False
                            _messageID = 0
                            errMsg = "<div class=""smError"">The filter was updated successfully.</div>"
                        End If
                    End If
                End If
            ElseIf _edOrDel = "n" And _formVerify = True Then       '-- add filter
                If _bWord.ToString.Trim = String.Empty Then
                    errMsg = "<div class=""smError"">You did not enter the word to be filtered.</div>"
                Else
                    If _gWord.ToString.Trim = String.Empty Then
                        errMsg = "<div class=""smError"">You did not enter the replacement text for the filter word.</div>"
                    Else
                        dataConn = New SqlConnection(connStr)
                        dataCmd = New SqlCommand("TB_ADMIN_AddFilterWord", dataConn)
                        dataCmd.CommandType = CommandType.StoredProcedure
                        dataParam = dataCmd.Parameters.Add("@applyFilter", SqlDbType.Int)
                        dataParam.Value = _tID
                        dataParam = dataCmd.Parameters.Add("@badWord", SqlDbType.VarChar, 50)
                        dataParam.Value = _bWord
                        dataParam = dataCmd.Parameters.Add("@goodWord", SqlDbType.VarChar, 50)
                        dataParam.Value = _gWord
                        dataParam = dataCmd.Parameters.Add("@didAdd", SqlDbType.Bit)
                        dataParam.Direction = ParameterDirection.Output
                        dataConn.Open()
                        dataCmd.ExecuteNonQuery()
                        didAdd = dataCmd.Parameters("@didAdd").Value
                        dataConn.Close()
                        If didAdd = False Then
                            errMsg = "<div class=""smError"">Another filter already exists with the word you entered.</div>"
                        Else
                            logAdminAction(uGUID, "Added word censor filter for '" + _bWord + "'.")
                            _edOrDel = "n"
                            _bWord = String.Empty
                            _gWord = String.Empty
                            _formVerify = False
                            _messageID = 0
                            errMsg = "<div class=""smError"">The filter was added successfully.</div>"
                        End If

                    End If
                End If
            ElseIf _edOrDel = "d" And _messageID > 0 Then   '-- delete filter
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_DeleteFilterWord", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@wordID", SqlDbType.Int)
                dataParam.Value = _messageID
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                errMsg = "<div class=""smError"">The filter was successfully removed.</div>"
                logAdminAction(uGUID, "Deleted word censor filter.")

            End If
            lfTable.Append("<tr><td colspan=""2"" class=""md"" height=""20"" valign=""top""><b>Word Censoring</b></td></tr>")
            lfTable.Append("<tr><td colspan=""2"" class=""sm"" height=""20"" valign=""top"">Use this form to add, edit or remove words that are to be censored in the forum posts.<hr size=""1"" noshade /></td></tr>")

            lfTable.Append("<tr><td colspan=""2"" class=""sm"" height=""20"" valign=""top""><b>")
            If _edOrDel = "e" And _messageID > 0 Then
                lfTable.Append("Edit this filter</b>")
            Else
                lfTable.Append("Add a new filter</b>")
                _edOrDel = "n"
            End If
            If errMsg <> String.Empty Then
                lfTable.Append(errMsg)
            End If

            lfTable.Append("</td></tr>")
            lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
            lfTable.Append("<input type=""hidden"" name=""fi"" value=""19"" />")
            lfTable.Append("<input type=""hidden"" name=""verify"" value=""1"" />")
            lfTable.Append("<input type=""hidden"" name=""eod"" value=" + Chr(34) + _edOrDel + Chr(34) + " />")
            If _edOrDel = "e" And _messageID > 0 Then
                lfTable.Append("<input type=""hidden"" name=""meid"" value=" + Chr(34) + _messageID.ToString + Chr(34) + " />")
            End If
            lfTable.Append("<tr><td width=""30%"" class=""sm"" height=""20"" align=""right""><b>Word to be filtered : </b></td>")
            lfTable.Append("<td width=""70%"" class=""sm"" height=""20""><input type=""text"" size=""30"" class=""smInput"" name=""bWord"" value=" + Chr(34) + _bWord + Chr(34) + "></td></tr>")
            lfTable.Append("<tr><td width=""30%"" class=""sm"" height=""20"" align=""right""><b>Replacement text : </b></td>")
            lfTable.Append("<td width=""70%"" class=""sm"" height=""20""><input type=""text"" size=""30"" class=""smInput"" name=""gWord"" value=" + Chr(34) + _gWord + Chr(34) + "></td></tr>")
            lfTable.Append("<tr><td width=""30%"" class=""sm"" height=""20"" align=""right"" valign=""top""><b>Applies to : </b></td>")
            lfTable.Append("<td width=""70%"" class=""sm"" height=""20"">")
            lfTable.Append("<input type=""radio"" name=""tid"" value=""1" + Chr(34))
            If _tID = 1 Or _tID = 0 Then
                lfTable.Append(" checked")
            End If
            lfTable.Append("> - Users Only<br />")
            lfTable.Append("<input type=""radio"" name=""tid"" value=""2" + Chr(34))
            If _tID = 2 Then
                lfTable.Append(" checked")
            End If
            lfTable.Append("> - Users and Moderators<br />")
            'lfTable.Append("<input type=""radio"" name=""tid"" value=""3" + Chr(34))
            'If _tID = 3 Then
            '    lfTable.Append(" checked")
            'End If
            'lfTable.Append("> - Users, Moderators and Administrators<br />")
            lfTable.Append("</td></tr>")
            lfTable.Append("<tr><td width=""30%"" class=""sm"" height=""20"" align=""right"">&nbsp;</td>")
            lfTable.Append("<td width=""70%"" class=""sm"" height=""20""><input type=""submit"" class=""smButton"" value=" + Chr(34))
            If _edOrDel = "e" And _messageID > 0 Then
                lfTable.Append("UPDATE")
            Else
                lfTable.Append("ADD NEW")
            End If
            lfTable.Append(Chr(34) + ">")
            lfTable.Append("</td></tr>")

            lfTable.Append("</form><tr><td colspan=""2"" class=""sm"" height=""20"" valign=""top""><br /><hr size=""1"" noshade /><b>Current Filtered Word List</b></td></tr>")
            lfTable.Append("<tr><td colspan=""2"" class=""sm"" valign=""top"" align=""center""><table border=""0"" cellpaddding=""3"" cellspacing=""0"" width=""85%"" class=""tblStd"">")
            lfTable.Append("<tr><td class=""smRowHead"" align=""center"" width=""15%"">Action</td>")
            lfTable.Append("<td class=""smRowHead"" align=""center"" width=""35%"">Filtered Word</td>")
            lfTable.Append("<td class=""smRowHead"" align=""center"" width=""35%"">Replacement</td>")
            lfTable.Append("<td class=""smRowHead"" align=""center"" width=""15%"">Applies To</td></tr>")
            Dim wCount As Integer = 0
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_GetFilterWords", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False And dataRdr.IsDBNull(2) = False And dataRdr.IsDBNull(3) = False Then
                        wCount += 1
                        lfTable.Append("<tr><td class=""smRow"" align=""center"" width=""15%""><a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=19&eod=e&m=" + CStr(dataRdr.Item(0)) + Chr(34) + ">EDIT</a> | ")
                        lfTable.Append("<a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=19&eod=d&m=" + CStr(dataRdr.Item(0)) + Chr(34) + ">DELETE</a></td>")
                        lfTable.Append("<td class=""smRow"" align=""center"" width=""35%"">" + dataRdr.Item(1) + "</td>")
                        lfTable.Append("<td class=""smRow"" align=""center"" width=""35%"">" + dataRdr.Item(2) + "</td>")
                        lfTable.Append("<td class=""smRow"" align=""center"" width=""15%"">")
                        Select Case dataRdr.Item(3)
                            Case 0, 1
                                lfTable.Append("&nbsp;<b>U</b>&nbsp;")
                            Case 2
                                lfTable.Append("&nbsp;<b>U&nbsp;M&nbsp;")
                                'Case 3
                                '    lfTable.Append("&nbsp;<b>U&nbsp;M&nbsp;A&nbsp;")

                        End Select

                        lfTable.Append("</b></td></tr>")

                    End If

                End While
                dataRdr.Close()
                dataConn.Close()
            End If
            If wCount = 0 Then
                lfTable.Append("<tr><td colspan=""4"" align=""center"" class=""smRow""><br />You do not have any words being filtered.</td></tr>")
            End If

            lfTable.Append("</table></td></tr>")
            lfTable.Append("<tr><td colspan=""2"">&nbsp;</td></tr></form></table>")
            Return lfTable.ToString
        End Function

        '-- IP Address ban
        Private Function loadForm20(ByVal uGUID As String) As String
            Dim lfTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
            Dim msgStr As String = String.Empty
            If getAdminMenuAccess(20, uGUID) = False Then
                lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                Return lfTable.ToString
                Exit Function
            End If
            If _edOrDel = "n" And _bIP <> String.Empty Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_AddIPBan", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@IPMask", SqlDbType.VarChar, 16)
                dataParam.Value = _bIP
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                msgStr = "IP Address Added"
                logAdminAction(uGUID, "Added IP '" + _bIP + "' to the IP ban list.")
            ElseIf _edOrDel = "d" And _forumID > 0 Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_RemoveIPBan", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@IPID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                msgStr = "IP Address Removed"
                logAdminAction(uGUID, "Removed IP ban.")
            End If
            lfTable.Append("<tr><td class=""md"" colspan=""2"" height=""20"" valign=""top""><b>IP Ban</b></td></tr>")
            lfTable.Append("<tr><td class=""sm"" colspan=""2"" height=""20"" valign=""top"">Using the forms below you can add to or remove the banning of IP addresses and IP ranges.<hr size=""1"" noshade /></td></tr>")
            If msgStr <> String.Empty Then
                lfTable.Append("<tr><td class=""smError"" colspan=""2"">" + msgStr + "</td.</tr>")
            End If
            '-- new ban
            lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
            lfTable.Append("<input type=""hidden"" name=""fi"" value=""20"">")
            lfTable.Append("<input type=""hidden"" name=""eod"" value=""n"">")
            lfTable.Append("<tr><td class=""sm"" height=""20"" align=""center"" valign=""top""><b>Ban IP Address or IP Range : </b></td>")
            lfTable.Append("<td class=""sm"" height=""20"" ><input type=""text"" maxlength=""16"" name=""bip"" class=""smInput"" size=""30""><br />NOTE : Use * for wildcard matching IP ranges. (e.g. 127.0.0.*)</td></tr>")
            lfTable.Append("<tr><td>&nbsp;</td><td class=""sm"" height=""20"" ><input type=""submit"" value=""BAN IP"" class=""smButton""></td></tr></form>")

            '-- existing bans
            lfTable.Append("<tr><td colspan=""2"" class=""sm""><hr size=""1"" noshade />")
            lfTable.Append("<b>Existing IP Bans :</b></td></tr>")
            lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
            lfTable.Append("<tr><td class=""sm"" colspan=""2"">Select the IP Address or IP Range you would like to remove from the ban listing.</td></tr>")
            lfTable.Append("<tr><td>&nbsp;</td><td class=""sm""><select name=""fid"" class=""smInput"" size=""6"">")
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_GetIPBanList", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            Dim iCount As Integer = 0
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                        iCount += 1
                        lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                        lfTable.Append(dataRdr.Item(1) + "</option>")
                    End If
                End While
                dataRdr.Close()
                dataConn.Close()
            End If
            If iCount = 0 Then
                lfTable.Append("<option value=""0"">No Banned IP Addresses</option>")
            End If

            lfTable.Append("</select>")
            If iCount > 0 Then
                lfTable.Append("<br /><input type=""submit"" value=""REMOVE"" class=""smButton"">")
                lfTable.Append("<input type=""hidden"" name=""fi"" value=""20"" />")
                lfTable.Append("<input type=""hidden"" name=""eod"" value=""d"" />")
            End If
            lfTable.Append("</td></tr></form>")

            lfTable.Append("<tr><td colspan=""2"">&nbsp;</td></tr></form></table>")
            Return lfTable.ToString
        End Function

        '-- E-Mail ban
        Private Function loadForm22(ByVal uGUID As String) As String
            Dim lfTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
            Dim msgStr As String = String.Empty
            If getAdminMenuAccess(22, uGUID) = False Then
                lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                Return lfTable.ToString
                Exit Function
            End If
            If _edOrDel = "n" And _bIP <> String.Empty Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_AddEmailBan", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@EmailAddress", SqlDbType.VarChar, 64)
                dataParam.Value = _bIP
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                msgStr = "E-Mail Address Added"
                logAdminAction(uGUID, "Added '" + _bIP + "' to the email ban list.")

            ElseIf _edOrDel = "d" And _forumID > 0 Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_RemoveEmailBan", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@EAID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                msgStr = "E-Mail Address Removed"
                logAdminAction(uGUID, "Removed email ban.")
            End If
            lfTable.Append("<tr><td class=""md"" colspan=""2"" height=""20"" valign=""top""><b>E-Mail Ban</b></td></tr>")
            lfTable.Append("<tr><td class=""sm"" colspan=""2"" height=""20"" valign=""top"">Using the forms below you can add to or remove the banning of E-Mail addresses, blocking new registrations.<hr size=""1"" noshade /></td></tr>")
            If msgStr <> String.Empty Then
                lfTable.Append("<tr><td class=""smError"" colspan=""2"">" + msgStr + "</td.</tr>")
            End If
            '-- new ban
            lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
            lfTable.Append("<input type=""hidden"" name=""fi"" value=""22"">")
            lfTable.Append("<input type=""hidden"" name=""eod"" value=""n"">")
            lfTable.Append("<tr><td class=""sm"" height=""20"" align=""center"" valign=""top""><b>Ban E-Mail Address : </b></td>")
            lfTable.Append("<td class=""sm"" height=""20"" ><input type=""text"" maxlength=""64"" name=""bip"" class=""smInput"" size=""30""><br />NOTE : The entries are NOT case sensitive<br />(e.g. info@dotnetbb.com == Info@dotNetBB.com)</td></tr>")
            lfTable.Append("<tr><td>&nbsp;</td><td class=""sm"" height=""20"" ><input type=""submit"" value=""BAN E-MAIL"" class=""smButton""></td></tr></form>")

            '-- existing bans
            lfTable.Append("<tr><td colspan=""2"" class=""sm""><hr size=""1"" noshade />")
            lfTable.Append("<b>Existing E-Mail Address Bans :</b></td></tr>")
            lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
            lfTable.Append("<tr><td class=""sm"" colspan=""2"">Select the E-Mail Address you would like to remove from the ban listing.</td></tr>")
            lfTable.Append("<tr><td>&nbsp;</td><td class=""sm""><select name=""fid"" class=""smInput"" size=""6"">")
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_GetEmailBanList", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            Dim iCount As Integer = 0
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                        iCount += 1
                        lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                        lfTable.Append(dataRdr.Item(1) + "</option>")
                    End If
                End While
                dataRdr.Close()
                dataConn.Close()
            End If
            If iCount = 0 Then
                lfTable.Append("<option value=""0"">No Banned E-Mail Addresses</option>")
            End If

            lfTable.Append("</select>")
            If iCount > 0 Then
                lfTable.Append("<br /><input type=""submit"" value=""REMOVE"" class=""smButton"">")
                lfTable.Append("<input type=""hidden"" name=""fi"" value=""22"" />")
                lfTable.Append("<input type=""hidden"" name=""eod"" value=""d"" />")
            End If
            lfTable.Append("</td></tr></form>")

            lfTable.Append("<tr><td colspan=""2"">&nbsp;</td></tr></form></table>")
            Return lfTable.ToString
        End Function

        '-- new forum builder, replaces loadform 1, 2, 3, and 14
        Private Function loadForm23(ByVal uGUID As String) As String
            Dim lfTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
            Dim msgStr As String = String.Empty
            Dim lCategory As String = String.Empty
            Dim fO As Integer = 0
            Dim cO As Integer = 0
            Dim catDrop As String = ""

            If getAdminMenuAccess(23, uGUID) = False Then
                lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                Return lfTable.ToString
                Exit Function
            End If
            lfTable.Append("<tr><td class=""md"" height=""20"" valign=""top""><b>Forum Builder</b></td></tr>")
            lfTable.Append("<tr><td class=""sm"" height=""20"" valign=""top"">Using this tool you can create, modify, or delete the forums that will be available.<br />NOTE : To delete a category, you must delete all forums in the category first.<hr size=""1"" noshade /></td></tr>")
            lfTable.Append("<tr><td class=""sm"" height=""20"" valign=""top"">")

            '---------------------------------------
            '-- do any updating / querying required

            '-- change forum order within category
            If (_loadForm = "-1" Or _loadForm = "1") And _forumID > 0 And _formVerify = False Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_ChangeForumOrder", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataParam = dataCmd.Parameters.Add("@MoveVal", SqlDbType.Int)
                dataParam.Value = CInt(_loadForm)
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                logAdminAction(uGUID, "Changed forum order within a category.")

                '-- change forum category order
            ElseIf (_loadForm = "-1" Or _loadForm = "1") And _forumID > 0 And _formVerify = True Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_MoveCategory", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@CategoryID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataParam = dataCmd.Parameters.Add("@MoveVal", SqlDbType.Int)
                dataParam.Value = CInt(_loadForm)
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                logAdminAction(uGUID, "Changed forum category order.")

                '-- new in v2.1 : enable/disable forum
            ElseIf (_loadForm.ToLower = "df" Or _loadForm.ToLower = "af") And _forumID > 0 Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_SetForumState", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataParam = dataCmd.Parameters.Add("@ActiveState", SqlDbType.Bit)
                If _loadForm.ToLower = "df" Then
                    dataParam.Value = 0
                Else
                    dataParam.Value = 1
                End If
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                If _loadForm.ToLower = "df" Then
                    logAdminAction(uGUID, "Forum ID " + _forumID.ToString + " Disabled")
                    lfTable.Append("<div class=""smError"" align=""center"" ><br />The forum had been disabled.</div>")
                Else
                    logAdminAction(uGUID, "Forum ID " + _forumID.ToString + " Enabled")
                    lfTable.Append("<div class=""smError"" align=""center"" ><br />The forum had been enabled.</div>")
                End If


                '-- get edit info
            ElseIf _loadForm = "e" And _formVerify = False Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_ForumEditable", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(0) = False Then
                            _forumName = dataRdr.Item(0)
                        End If
                        If dataRdr.IsDBNull(1) = False Then
                            _forumDesc = dataRdr.Item(1)
                        End If
                        If dataRdr.IsDBNull(2) = False Then
                            _forumAccess = dataRdr.Item(2)
                        End If
                        If dataRdr.IsDBNull(3) = False Then
                            _mnPost = dataRdr.Item(3)
                        End If
                        If dataRdr.IsDBNull(4) = False Then
                            _whoPost = dataRdr.Item(4)
                        End If
                    End While
                    dataRdr.Close()
                    dataConn.Close()
                End If


                '-- update from edit
            ElseIf _loadForm = "e" And _forumID > 0 And _formVerify = True Then
                If _forumName.Trim <> String.Empty Then
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_ADMIN_UpdateForum", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@ForumName", SqlDbType.VarChar, 50)
                    dataParam.Value = _forumName
                    dataParam = dataCmd.Parameters.Add("@ForumDesc", SqlDbType.VarChar, 150)
                    dataParam.Value = _forumDesc
                    dataParam = dataCmd.Parameters.Add("@AccessPermission", SqlDbType.Int)
                    dataParam.Value = _forumAccess
                    dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                    dataParam.Value = _forumID
                    dataParam = dataCmd.Parameters.Add("@CategoryID", SqlDbType.Int)
                    dataParam.Value = _mnPost
                    dataParam = dataCmd.Parameters.Add("@WhoPost", SqlDbType.Int)
                    dataParam.Value = _whoPost
                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                    dataConn.Open()
                    dataCmd.ExecuteNonQuery()
                    dataConn.Close()
                    lfTable.Append("<div class=""smError"" align=""center"">The forum was successfully updated.</div>")
                    logAdminAction(uGUID, "Updated forum information for " + _forumName + ".")
                    _loadForm = ""
                    _forumID = 0
                    _formVerify = False
                    _forumName = ""
                    _forumDesc = ""
                    _forumAccess = 0
                    _mnPost = 0

                Else
                    lfTable.Append("<div class=""smError"" align=""center""><b>You must include the Forum Name!</b></div>")
                End If

                '-- delete forum
            ElseIf _loadForm = "d" And _forumID > 0 Then
                If _formVerify = False Then
                    lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                    lfTable.Append("<div style=""text-align:center;""><b>You are about to delete this forum : </b><br /><br />")
                    Dim forumName As String = String.Empty
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_ForumTitle", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                    dataParam.Value = _forumID
                    dataParam = dataCmd.Parameters.Add("@ForumName", SqlDbType.VarChar, 50)
                    dataParam.Direction = ParameterDirection.Output
                    dataConn.Open()
                    dataCmd.ExecuteNonQuery()
                    forumName = dataCmd.Parameters("@ForumName").Value
                    dataConn.Close()
                    lfTable.Append(forumName)
                    lfTable.Append("<input type=""hidden"" name=""verify"" value=""1"">")
                    lfTable.Append("<input type=""hidden"" name=""fid"" value=" + Chr(34) + _forumID.ToString + Chr(34) + ">")
                    lfTable.Append("<input type=""hidden"" name=""fi"" value=""23"" />")
                    lfTable.Append("<input type=""hidden"" name=""r"" value=""d"" />")

                    lfTable.Append("<br /><br />THIS WILL PERMANENTLY DELETE THE FORUM AND ALL POSTS WITHIN THE FORUM.<br />ARE YOU SURE YOU WANT TO DELETE THIS FORUM?<br /><b>THIS CANNOT BE UNDONE!</b>")
                    lfTable.Append("<br /><br /><input type=""submit"" value=""DELETE IT"" class=""smButton"">&nbsp;")
                    lfTable.Append("<input type=""button"" onclick=""window.location.href='" + siteRoot + "/admin/?fi=23';"" value=""CANCEL"" class=""smButton""></div>")
                    lfTable.Append("</td></tr></table>")
                    logAdminAction(uGUID, "Selected forum '" + forumName + "' for deletion.")
                    Return lfTable.ToString
                    Exit Function
                Else
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_ADMIN_DeleteForum", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                    dataParam.Value = _forumID
                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                    dataConn.Open()
                    dataCmd.ExecuteNonQuery()
                    dataConn.Close()
                    logAdminAction(uGUID, "Deleted forum.")
                    lfTable.Append("<div class=""smError"" align=""center"" ><br />The forum had been deleted.</div>")
                    _forumID = 0
                    _loadForm = ""
                End If



                '-- add new forum
            ElseIf _loadForm = "n" And _mnPost > 0 And _formVerify = True Then
                If _forumName <> String.Empty Then
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_ADMIN_AddNewForum", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@ForumName", SqlDbType.VarChar, 50)
                    dataParam.Value = _forumName
                    dataParam = dataCmd.Parameters.Add("@ForumDesc", SqlDbType.VarChar, 150)
                    dataParam.Value = _forumDesc
                    dataParam = dataCmd.Parameters.Add("@AccessPermission", SqlDbType.Int)
                    dataParam.Value = _forumAccess
                    dataParam = dataCmd.Parameters.Add("@CategoryID", SqlDbType.Int)
                    dataParam.Value = _mnPost
                    dataParam = dataCmd.Parameters.Add("@WhoPost", SqlDbType.Int)
                    dataParam.Value = _whoPost
                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                    dataConn.Open()
                    dataCmd.ExecuteNonQuery()
                    dataConn.Close()
                    logAdminAction(uGUID, "Added Forum : " + _forumName + ".")
                    lfTable.Append("<div class=""smError"" align=""center"">The forum was successfully added.</div>")
                    _loadForm = ""
                    _forumID = 0
                    _formVerify = False
                    _forumName = ""
                    _forumDesc = ""
                    _forumAccess = 0
                    _mnPost = 0
                Else
                    lfTable.Append("<div class=""smError"" align=""center""><b>You must include the Forum Name!</b></div>")
                End If

                '-- add forum category
            ElseIf _loadForm.ToString.ToLower.Trim = "nc" Then
                If _forumName.Trim <> "" Then
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_ADMIN_AddCategory", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@CategoryName", SqlDbType.VarChar, 50)
                    dataParam.Value = _forumName
                    dataParam = dataCmd.Parameters.Add("@CategoryDesc", SqlDbType.VarChar, 150)
                    dataParam.Value = _forumDesc
                    dataConn.Open()
                    dataCmd.ExecuteNonQuery()
                    dataConn.Close()
                    logAdminAction(uGUID, "Added forum category " + _forumName + ".")
                    _forumName = String.Empty
                    _forumDesc = String.Empty
                    lfTable.Append("<div class=""smError"" align=""center"">The category was successfully added.</div>")
                Else
                    lfTable.Append("<div class=""smError"" align=""center""><b>You must include the Category Name!</b></div>")
                End If

                '-- delete forum category
            ElseIf _loadForm.ToString.ToLower.Trim = "dc" Then
                If _formVerify = False Then '-- prompt to confirm
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_ADMIN_GetDescriptionForEdit", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@CategoryID", SqlDbType.Int)
                    dataParam.Value = _mnPost
                    dataConn.Open()
                    dataRdr = dataCmd.ExecuteReader
                    If dataRdr.IsClosed = False Then
                        While dataRdr.Read
                            If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                                _forumID = dataRdr.Item(0)
                                _forumName = dataRdr.Item(1)
                                If dataRdr.IsDBNull(2) = False Then
                                    _forumDesc = dataRdr.Item(2)
                                End If
                            End If
                        End While
                        dataRdr.Close()
                        dataConn.Close()
                    End If
                    logAdminAction(uGUID, "Select category '" + _forumName + "' for deletion.")
                    lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                    lfTable.Append("<input type=""hidden"" name=""fi"" value=""23"" />")
                    lfTable.Append("<input type=""hidden"" name=""mnp"" value=" + Chr(34) + _mnPost.ToString + Chr(34) + " />")
                    lfTable.Append("<input type=""hidden"" name=""r"" value=""dc"" />")
                    lfTable.Append("<input type=""hidden"" name=""verify"" value=""1"" />")
                    lfTable.Append("<div style=""font-weight:bold;text-align:center;"">YOU ARE ABOUT TO PERMANENTLY REMOVE THIS CATEGORY!<br /><br />")
                    lfTable.Append(_forumName)
                    If _forumDesc <> "" Then
                        lfTable.Append(" - " + _forumDesc)
                    End If
                    lfTable.Append("<br /></div><div class=""sm"" style=""text-align:center;""><br />Are you sure you want to do this?<br />")
                    lfTable.Append("<input type=""submit"" class=""smButton"" value=""DELETE CATEGORY""> &nbsp;")
                    lfTable.Append("<input type=""button"" class=""smButton"" value=""CANCEL"" onclick=""window.location.href='" + siteRoot + "/admin/?fi=23';"" /></div></form>")
                    lfTable.Append("</td></tr></table>")
                    Return lfTable.ToString
                    Exit Function



                Else
                    Dim tCount As Integer = 0
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_ADMIN_DeleteCategory", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@CategoryID", SqlDbType.Int)
                    dataParam.Value = _mnPost
                    dataParam = dataCmd.Parameters.Add("@tCount", SqlDbType.Int)
                    dataParam.Direction = ParameterDirection.Output
                    dataConn.Open()
                    dataCmd.ExecuteNonQuery()
                    tCount = dataCmd.Parameters("@tCount").Value
                    dataConn.Close()
                    logAdminAction(uGUID, "Deleted category.")
                    If tCount > 0 Then
                        lfTable.Append("<div class=""smError"" align=""center""><b>Unable to remove categories with forums still in use.</b></div>")
                    Else
                        lfTable.Append("<div class=""smError"" align=""center"">The forum category has been removed.</div>")
                    End If
                    _loadForm = ""
                End If




            End If

            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_GetForumCategories", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                        catDrop += "<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34)
                        If _mnPost = dataRdr.Item(0) Then
                            catDrop += " selected"
                        End If
                        catDrop += ">" + dataRdr.Item(1) + "</option>"
                    End If
                End While
                dataRdr.Close()
                dataConn.Close()
            End If

            lfTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" class=""tblStd"">")
            lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
            lfTable.Append("<tr><td class=""sm"" ><b>Add A New Forum Category : </b> &nbsp;&nbsp;<input type=""submit"" value=""ADD NEW"" class=""xsmButton""></td></tr>")
            lfTable.Append("<input type=""hidden"" name=""fi"" value=""23"" />")
            lfTable.Append("<input type=""hidden"" name=""r"" value=""nc"" />")
            lfTable.Append("<tr><td class=""sm"">Category Name : ")
            lfTable.Append("<input type=""text"" size=""40"" class=""smInput"" maxlength=""100"" name=""fn"" value=" + Chr(34) + _forumName + Chr(34) + " /></td></tr>")
            lfTable.Append("<tr><td class=""sm"">Category Description (optional) : ")
            lfTable.Append("<input type=""text"" style=""width:50%;"" class=""smInput"" maxlength=""250"" name=""fd"" value=" + Chr(34) + _forumDesc + Chr(34) + " /></td></tr>")
            lfTable.Append("</table></form><br />")

            '-- prevent values from running into the add forum boxes...
            If _loadForm = "fn" Then
                _forumName = String.Empty
                _forumDesc = String.Empty
            End If

            Dim d1 As Boolean = False

            '-- list the empty categories first
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_EmptyCatgegoryList", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    '-- if new forum category
                    If d1 = False Then
                        d1 = True
                        lfTable.Append("<div style=""font-weight:bold;"">Forum Categories Without Forums</div>")
                    End If
                    If lCategory <> dataRdr.Item(1) Then
                        If lCategory <> "" Then     '-- close off last category 
                            lfTable.Append("</table><br />")
                        End If
                        lCategory = dataRdr.Item(1)
                        lfTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" class=""tblStd"">")
                        lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                        lfTable.Append("<input type=""hidden"" name=""fi"" value=""23"" />")
                        lfTable.Append("<input type=""hidden"" name=""mnp"" value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + " />")
                        lfTable.Append("<input type=""hidden"" name=""r"" value=""n"" />")
                        lfTable.Append("<input type=""hidden"" name=""verify"" value=""1"" />")
                        lfTable.Append("<tr><td class=""sm"" colspan=""6""><b>Forum Category : </b>" + dataRdr.Item(1))
                        If dataRdr.IsDBNull(2) = False Then
                            If dataRdr.Item(2) <> "" Then
                                lfTable.Append(" - " + dataRdr.Item(2))
                            End If
                        End If
                        If _loadForm <> "e" And _loadForm <> "d" Then
                            lfTable.Append("<br /><b>Add New Forum to this Category :</b> &nbsp; <input type=""submit"" value=""ADD NEW"" class=""xsmButton"" /><br />")
                            lfTable.Append("Forum Name : <input type=""text"" value=" + Chr(34) + _forumName + Chr(34) + " size=""40"" maxlength=""50"" name=""fn"" class=""smInput""><br />")
                            lfTable.Append("Forum Description (optional) : <input type=""text"" value=" + Chr(34) + _forumDesc + Chr(34) + " style=""width:50%;"" maxlength=""150"" name=""fd"" class=""xsmInput""><br />")
                            lfTable.Append("Access Permission : <select name=""access"" class=""smInput"">")
                            Dim ac As Integer = 0
                            For ac = 1 To 3
                                lfTable.Append("<option value=" + Chr(34) + ac.ToString + Chr(34))
                                If ac = _forumAccess Then
                                    lfTable.Append(" selected")
                                End If
                                lfTable.Append(">")
                                Select Case ac
                                    Case 1
                                        lfTable.Append("Public</option>")
                                    Case 2
                                        lfTable.Append("Registered</option>")
                                    Case 3
                                        lfTable.Append("Private</option>")
                                End Select
                            Next
                            lfTable.Append("</select><br />")

                            lfTable.Append("Posting Permission : <select name=""wp"" class=""smInput"">")

                            For ac = 1 To 3
                                lfTable.Append("<option value=" + Chr(34) + ac.ToString + Chr(34))
                                If ac = _forumAccess Then
                                    lfTable.Append(" selected")
                                End If
                                lfTable.Append(">")
                                Select Case ac
                                    Case 1
                                        lfTable.Append("All Can Post & Reply</option>")
                                    Case 2
                                        lfTable.Append("Moderators Can Post, Users Can Reply</option>")
                                    Case 3
                                        lfTable.Append("Moderators Can Post, Users Cannot Reply</option>")
                                End Select
                            Next
                            lfTable.Append("</select>")

                        End If
                        lfTable.Append("</td></form>")
                        lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                        lfTable.Append("<input type=""hidden"" name=""fi"" value=""23"" />")
                        lfTable.Append("<input type=""hidden"" name=""mnp"" value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + " />")
                        lfTable.Append("<input type=""hidden"" name=""r"" value=""dc"" />")

                        lfTable.Append("<td class=""sm"" width=""50"" valign=""top""><input type=""submit"" class=""xsmButton"" value=""DELETE CATEGORY"" /></tr></form>")
                    End If
                    lfTable.Append("</table><br />")
                End While
                dataRdr.Close()
                dataConn.Close()

                lCategory = ""
            End If

            cO = 0
            lfTable.Append("<div style=""font-weight:bold;"">Forum Categories With Forums</div>")
            '-- output the categories with forums
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_ForumListForEdit", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    '-- if new forum category
                    If lCategory <> dataRdr.Item(13) Then
                        If lCategory <> "" Then     '-- close off last category 
                            lfTable.Append("</table><br />")
                        End If
                        cO += 1
                        lCategory = dataRdr.Item(13)
                        lfTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" class=""tblStd"">")
                        lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                        lfTable.Append("<input type=""hidden"" name=""fi"" value=""23"" />")
                        lfTable.Append("<input type=""hidden"" name=""mnp"" value=" + Chr(34) + CStr(dataRdr.Item(18)) + Chr(34) + " />")
                        lfTable.Append("<input type=""hidden"" name=""r"" value=""n"" />")
                        lfTable.Append("<input type=""hidden"" name=""verify"" value=""1"" />")
                        lfTable.Append("<tr><td class=""smRow"" colspan=""6""><b>Forum Category : </b>" + dataRdr.Item(13))
                        If dataRdr.IsDBNull(14) = False Then
                            If dataRdr.Item(14) <> "" Then
                                lfTable.Append(" - " + dataRdr.Item(14))
                            End If
                        End If
                        lfTable.Append("<br /><b>Move Category : </b>")
                        If (cO > 1 And cO < dataRdr.Item(19)) Or (cO = dataRdr.Item(19)) Then
                            lfTable.Append("&nbsp;<a href=" + Chr(34) + siteRoot + "/admin/?fi=23&r=-1&verify=1&fid=" + CStr(dataRdr.Item(18)) + Chr(34) + ">")
                            lfTable.Append("<img src=""images/up.gif"" title=""Move Up"" border=""0""></a>&nbsp;")
                        End If
                        If cO < dataRdr.Item(19) Then
                            lfTable.Append("&nbsp;<a href=" + Chr(34) + siteRoot + "/admin/?fi=23&r=1&verify=1&fid=" + CStr(dataRdr.Item(18)) + Chr(34) + ">")
                            lfTable.Append("<img src=""images/down.gif"" title=""Move Down"" border=""0""></a>&nbsp;")
                        End If
                        If _loadForm <> "e" And _loadForm <> "d" Then
                            lfTable.Append("<br /><b>Add New Forum to this Category :</b> &nbsp; <input type=""submit"" value=""ADD NEW"" class=""xsmButton"" /><br />")
                            lfTable.Append("Forum Name : <input type=""text"" value=" + Chr(34) + _forumName + Chr(34) + " size=""40"" maxlength=""50"" name=""fn"" class=""smInput""><br />")
                            lfTable.Append("Forum Description (optional) : <input type=""text"" value=" + Chr(34) + _forumDesc + Chr(34) + " style=""width:50%;"" maxlength=""150"" name=""fd"" class=""xsmInput""><br />")
                            lfTable.Append("Access Permission : <select name=""access"" class=""smInput"">")
                            Dim ac As Integer = 0
                            For ac = 1 To 3
                                lfTable.Append("<option value=" + Chr(34) + ac.ToString + Chr(34))
                                If ac = _forumAccess Then
                                    lfTable.Append(" selected")
                                End If
                                lfTable.Append(">")
                                Select Case ac
                                    Case 1
                                        lfTable.Append("Public</option>")
                                    Case 2
                                        lfTable.Append("Registered</option>")
                                    Case 3
                                        lfTable.Append("Private</option>")
                                End Select
                            Next
                            lfTable.Append("</select><br />")

                            lfTable.Append("Posting Permission : <select name=""wp"" class=""smInput"">")

                            For ac = 1 To 3
                                lfTable.Append("<option value=" + Chr(34) + ac.ToString + Chr(34))
                                If ac = _forumAccess Then
                                    lfTable.Append(" selected")
                                End If
                                lfTable.Append(">")
                                Select Case ac
                                    Case 1
                                        lfTable.Append("All Can Post & Reply</option>")
                                    Case 2
                                        lfTable.Append("Moderators Can Post, Users Can Reply</option>")
                                    Case 3
                                        lfTable.Append("Moderators Can Post, Users Cannot Reply</option>")
                                End Select
                            Next
                            lfTable.Append("</select>")

                        End If

                        fO = 0
                        lfTable.Append("</td></tr></form>")

                        lfTable.Append("<tr>")
                        lfTable.Append("<td class=""smRowHead"" align=""center"" width=""75""><img src=""images/transdot.gif"" border=""0"" height=""1"" width=""75"" /><br />Move</td>")
                        lfTable.Append("<td class=""smRowHead"" align=""center"" width=""75""><img src=""images/transdot.gif"" border=""0"" height=""1"" width=""75"" /><br />Status</td>")
                        lfTable.Append("<td class=""smRowHead"">Forum Name</td>")
                        lfTable.Append("<td class=""smRowHead"" width=""75"" align=""center""><img src=""images/transdot.gif"" border=""0"" height=""1"" width=""75"" /><br />Access</td>")
                        lfTable.Append("<td class=""smRowHead"" colspan=""2"" width=""150"" align=""center""><img src=""images/transdot.gif"" border=""0"" height=""1"" width=""150"" /><br />Action</td>")
                        lfTable.Append("</tr>")
                    End If
                    fO += 1
                    '------------------
                    '-- begin forum row
                    If (_loadForm = "e" Or _loadForm = "d") And _forumID = dataRdr.Item(0) Then
                        lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
                        lfTable.Append("<input type=""hidden"" name=""fi"" value=""23"" />")
                        lfTable.Append("<input type=""hidden"" name=""fid"" value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34) + " />")
                        lfTable.Append("<input type=""hidden"" name=""r"" value=" + Chr(34) + _loadForm + Chr(34) + " />")
                        lfTable.Append("<input type=""hidden"" name=""verify"" value=""1"" />")
                    End If
                    lfTable.Append("<tr>")

                    If _loadForm <> "e" And _loadForm <> "d" Then
                        lfTable.Append("<td class=""smRow"" align=""center"" width=""75"">&nbsp;")
                        If (fO > 1 And fO < dataRdr.Item(17)) Or (fO = dataRdr.Item(17) And fO > 1) Then
                            lfTable.Append("&nbsp;<a href=" + Chr(34) + siteRoot + "/admin/?fi=23&r=-1&fid=" + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                            lfTable.Append("<img src=""images/up.gif"" title=""Move Up"" border=""0""></a>&nbsp;")
                        End If
                        If fO < dataRdr.Item(17) And fO <> dataRdr.Item(17) Then
                            lfTable.Append("&nbsp;<a href=" + Chr(34) + siteRoot + "/admin/?fi=23&r=1&fid=" + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                            lfTable.Append("<img src=""images/down.gif"" title=""Move Down"" border=""0""></a>&nbsp;")
                        End If

                    ElseIf _forumID = dataRdr.Item(0) Then
                        lfTable.Append("<td class=""smRow"" align=""center"" width=""75"" bgcolor=""#DDDDDD"">")
                        lfTable.Append("&nbsp;")

                    Else
                        lfTable.Append("<td class=""smRow"" align=""center"" width=""75"">")
                        lfTable.Append("&nbsp;")
                    End If

                    lfTable.Append("&nbsp;</td>")

                    '-- running state
                    lfTable.Append("<td class=""smRow"" align=""center"" width=""75"">&nbsp;")
                    If dataRdr.IsDBNull(21) = False Then
                        If dataRdr.Item(21) = True Then
                            lfTable.Append("<a href=" + Chr(34) + siteRoot + "/admin/?fi=23&r=df&fid=" + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/admin/images/factive.gif"" border=""0"" alt=""Forum is Active, Click to Deactivate."" /></a>")
                        Else
                            lfTable.Append("<a href=" + Chr(34) + siteRoot + "/admin/?fi=23&r=af&fid=" + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/admin/images/finactive.gif"" border=""0"" alt=""Forum is Disabled, Click to Activate."" /></a>")
                        End If
                    Else
                        lfTable.Append("<a href=" + Chr(34) + siteRoot + "/admin/?fi=23&r=af&fid=" + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                        lfTable.Append("<img src=" + Chr(34) + siteRoot + "/admin/images/finactive.gif"" border=""0"" alt=""Forum is Disabled, Click to Activate."" /></a>")
                    End If

                    lfTable.Append("</td>")
                    If _loadForm = "e" And _forumID = dataRdr.Item(0) Then
                        lfTable.Append("<td class=""smRow"" bgcolor=""#DDDDDD"">")
                        lfTable.Append("<input type=""text"" value=" + Chr(34) + _forumName + Chr(34) + " size=""40"" maxlength=""50"" name=""fn"" class=""smInput""><br />")
                        lfTable.Append("<input type=""text"" value=" + Chr(34) + _forumDesc + Chr(34) + " style=""width:95%;"" maxlength=""150"" name=""fd"" class=""xsmInput""><br />")
                        lfTable.Append("<select name=""mnp"" class=""xsmInput"">" + catDrop + "</select><br />")
                        lfTable.Append("<select name=""wp"" class=""smInput"">")
                        Dim ac As Integer = 0
                        For ac = 1 To 3
                            lfTable.Append("<option value=" + Chr(34) + ac.ToString + Chr(34))
                            If ac = _whoPost Then
                                lfTable.Append(" selected")
                            End If
                            lfTable.Append(">")
                            Select Case ac
                                Case 1
                                    lfTable.Append("All Can Post & Reply</option>")
                                Case 2
                                    lfTable.Append("Moderators Can Post, Users Can Reply</option>")
                                Case 3
                                    lfTable.Append("Moderators Can Post, Users Cannot Reply</option>")
                            End Select
                        Next
                        lfTable.Append("</select>")

                    ElseIf _loadForm = "d" And _forumID = dataRdr.Item(0) Then
                        lfTable.Append("<td class=""smRow"" bgcolor=""#DDDDDD"">")
                        lfTable.Append("<b>ARE YOU SURE YOU WANT TO DELETE THIS FORUM AND ALL THE POSTS WITHIN? THIS CANNOT BE UNDONE!</b><br /><br />")
                        lfTable.Append(dataRdr.Item(1))
                        If dataRdr.IsDBNull(11) = False Then
                            If dataRdr.Item(11) <> "" Then
                                lfTable.Append("<div class=""xsm"">" + dataRdr.Item(11) + "</div>")
                            End If
                        End If
                    Else
                        lfTable.Append("<td class=""smRow"">")
                        lfTable.Append(dataRdr.Item(1))
                        If dataRdr.IsDBNull(11) = False Then
                            If dataRdr.Item(11) <> "" Then
                                lfTable.Append("<div class=""xsm"">" + dataRdr.Item(11) + "</div>")
                            End If
                        End If
                        Select Case dataRdr.Item(20)
                            Case 1
                                lfTable.Append("<div class=""xsm"" style=""font-style:italic;"">All can post and reply</div>")
                            Case 2
                                lfTable.Append("<div class=""xsm"" style=""font-style:italic;"">Moderators can post, Users can reply</div>")
                            Case 3
                                lfTable.Append("<div class=""xsm"" style=""font-style:italic;"">Moderators can post, Users cannot reply</div>")
                        End Select

                    End If

                    lfTable.Append("</td>")
                    If _loadForm = "e" And _forumID = dataRdr.Item(0) Then
                        lfTable.Append("<td class=""smRow"" align=""center"" width=""75"" bgcolor=""#DDDDDD"">")
                        lfTable.Append("<select name=""access"" class=""smInput"">")
                        Dim ac As Integer = 0
                        For ac = 1 To 3
                            lfTable.Append("<option value=" + Chr(34) + ac.ToString + Chr(34))
                            If ac = _forumAccess Then
                                lfTable.Append(" selected")
                            End If
                            lfTable.Append(">")
                            Select Case ac
                                Case 1
                                    lfTable.Append("Public</option>")
                                Case 2
                                    lfTable.Append("Registered</option>")
                                Case 3
                                    lfTable.Append("Private</option>")
                            End Select
                        Next
                        lfTable.Append("</select>")
                    Else
                        lfTable.Append("<td class=""smRow"" align=""center"" width=""75"">")
                        If dataRdr.IsDBNull(12) = False Then
                            Select Case dataRdr.Item(12)
                                Case 1
                                    lfTable.Append("Public")
                                Case 2
                                    lfTable.Append("Registered")
                                Case 3
                                    lfTable.Append("Private")
                            End Select
                        End If
                    End If

                    lfTable.Append("</td>")

                    If _loadForm <> "e" And _loadForm <> "d" Then
                        lfTable.Append("<td class=""smRow"" align=""center"" width=""75"">")
                        lfTable.Append("<a href=" + Chr(34) + siteRoot + "/admin/?fi=23&r=e&fid=" + CStr(dataRdr.Item(0)) + Chr(34) + ">EDIT</a>")
                    Else
                        If _forumID = dataRdr.Item(0) Then
                            lfTable.Append("<td class=""smRow"" align=""center"" width=""75"" bgcolor=""#DDDDDD"">")
                            If _loadForm = "e" Then
                                lfTable.Append("<input type=""submit"" value=""UPDATE"" class=""smButton"">")
                            ElseIf _loadForm = "d" Then
                                lfTable.Append("<input type=""submit"" value=""DELETE"" class=""smButton"">")
                            End If
                        Else
                            lfTable.Append("<td class=""smRow"" align=""center"" width=""75"">")
                            lfTable.Append("&nbsp;")
                        End If
                    End If

                    lfTable.Append("</td>")

                    If _loadForm <> "e" And _loadForm <> "d" Then
                        lfTable.Append("<td class=""smRow"" align=""center"" width=""75"">")
                        lfTable.Append("<a href=" + Chr(34) + siteRoot + "/admin/?fi=23&r=d&fid=" + CStr(dataRdr.Item(0)) + Chr(34) + ">DELETE</a>")
                    Else
                        If _forumID = dataRdr.Item(0) Then
                            lfTable.Append("<td class=""smRow"" align=""center"" width=""75"" bgcolor=""#DDDDDD"">")
                            lfTable.Append("<input type=""button"" value=""CANCEL"" onclick=""window.location.href='" + siteRoot + "/admin/?fi=23';"" class=""smButton"">")
                        Else
                            lfTable.Append("<td class=""smRow"" align=""center"" width=""75"">")
                            lfTable.Append("&nbsp;")
                        End If
                    End If
                    lfTable.Append("</td>")
                    lfTable.Append("</tr>")
                    If (_loadForm = "e" Or _loadForm = "d") And _forumID = dataRdr.Item(0) Then
                        lfTable.Append("</form>")
                    End If


                End While
                dataRdr.Close()
                dataConn.Close()
                lfTable.Append("</table>")
            End If


            lfTable.Append("</td></tr>")


            lfTable.Append("<tr><td colspan=""2"">&nbsp;</td></tr></form></table>")
            Return lfTable.ToString
        End Function

        '-- who voted poll information
        Private Function loadForm24(ByVal uGUID As String) As String
            Dim lfTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
            Dim vc As Integer = 0
            If getAdminMenuAccess(24, uGUID) = False Then
                lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                Return lfTable.ToString
                Exit Function
            End If
            lfTable.Append("<tr><td class=""md"" height=""20""><b>Who Voted</b></td></tr>")
            lfTable.Append("<tr><td class=""sm"" height=""20"">Using this tool you can see what members voted for on the various poll's that might be running on the forum. Click on the poll subject name to view an individual poll's results.<hr size=""1"" noshade /></td></tr>")
            lfTable.Append("<tr><td class=""sm"" height=""20"">")
            If _tID = 0 Then
                lfTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" class=""tblStd"">")
                lfTable.Append("<tr><td class=""smRowHead"" width=""100%"">Poll Subject</td>")
                lfTable.Append("<td class=""smRowHead"" align=""center""><img src=" + Chr(34) + siteRoot + "/admin/images/transdot.gif"" border=""0"" height=""1"" width=""150"" /><br />Forum Name</td>")
                lfTable.Append("<td class=""smRowHead"" align=""center""><img src=" + Chr(34) + siteRoot + "/admin/images/transdot.gif"" border=""0"" height=""1"" width=""150"" /><br />Date Posted</td>")
                lfTable.Append("<td class=""smRowHead"" align=""center""><img src=" + Chr(34) + siteRoot + "/admin/images/transdot.gif"" border=""0"" height=""1"" width=""100"" /><br />Vote Count</td></tr>")
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_GetPollListing", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        vc += 1
                        lfTable.Append("<tr><td class=""smRow""><a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=24&tid=" + CStr(dataRdr.Item(0)) + Chr(34) + ">" + dataRdr.Item(1) + "</a></td>")
                        lfTable.Append("<td class=""smRow"" align=""center"">" + dataRdr.Item(3) + "</td>")
                        lfTable.Append("<td class=""smRow"" align=""center"">" + FormatDateTime(dataRdr.Item(2), DateFormat.ShortDate) + "</td>")
                        lfTable.Append("<td class=""smRow"" align=""center"">" + CStr(dataRdr.Item(4)) + "</td></tr>")
                    End While
                    dataRdr.Close()
                    dataConn.Close()
                End If
                If vc = 0 Then
                    lfTable.Append("<tr><td colspan=""4"" class=""sm"" align=""center"">There are no polls running on the forums.</td></tr>")
                End If
                lfTable.Append("</table>")
            Else
                vc = 0
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_GetPollValues", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                dataParam.Value = _tID
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader

                If dataRdr.IsClosed = False Then
                    lfTable.Append("<table border=""0"" cellpadding=""5"" cellspacing=""0"" align=""center"" class=""tblStd"">")
                    Dim df As Boolean = False
                    While dataRdr.Read
                        vc += 1
                        If df = False Then
                            df = True
                            lfTable.Append("<tr><td class=""msgVoteHead"" align=""center"">Vote Results :: ")
                            lfTable.Append(CStr(dataRdr.Item(3)))
                            If dataRdr.Item(3) = 1 Then
                                lfTable.Append(" vote total")
                            Else
                                lfTable.Append(" votes total")
                            End If
                            lfTable.Append("</td></tr>")
                        End If
                        Dim wSize As Double = 10
                        Dim votePerc As Double = 0.0
                        Dim tVotes As Integer = 0
                        lfTable.Append("<tr><td class=""msgVoteRow"">")
                        lfTable.Append("<table border=""0"" cellpadding=""1"" cellspacing=""0"" height=""15"" class=""tblStd"" width=" + Chr(34))
                        If dataRdr.Item(2) > 0 And dataRdr.Item(3) > 0 Then
                            wSize = dataRdr.Item(2) / dataRdr.Item(3)
                            votePerc = dataRdr.Item(2) / dataRdr.Item(3)
                            wSize = (wSize * 500) + 10
                            lfTable.Append(FormatNumber(wSize, 0) + Chr(34) + ">")
                        Else
                            lfTable.Append("10"">")
                        End If

                        lfTable.Append("<tr><td class=""xsm"" align=""center"" background=" + Chr(34) + siteRoot + "/admin/images/votebar.gif"" bgcolor=""#2F668C"">" + CStr(dataRdr.Item(2)) + "</td></tr></table>")
                        lfTable.Append(dataRdr.Item(1) + " - ")
                        lfTable.Append(FormatPercent(votePerc, 1))

                        lfTable.Append("</td></tr>")
                    End While
                    dataRdr.Close()
                    dataConn.Close()
                    lfTable.Append("</table><br />&nbsp;")
                End If
                If vc > 0 Then
                    Dim uC As Integer = 0
                    Dim hF As Boolean = False
                    lfTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" class=""tblStd"">")
                    lfTable.Append("<tr><td colspan=""4"" class=""smRowHead"" align=""center"">Who Has Voted</td></tr>")
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_ADMIN_GetWhoVoted", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                    dataParam.Value = _tID
                    dataConn.Open()
                    dataRdr = dataCmd.ExecuteReader
                    If dataRdr.IsClosed = False Then
                        While dataRdr.Read
                            If hF = False Then
                                lfTable.Append("<tr>")
                                hF = True
                            End If
                            If uC >= 4 Then
                                lfTable.Append("</tr><tr>")
                                uC = 0
                            End If
                            If uC < 3 Then
                                lfTable.Append("<td class=""smRow"" align=""center"" width=""25%"" style=""border-right:1px outset threedshadow;"">" + dataRdr.Item(0) + "</td>")
                            Else
                                lfTable.Append("<td class=""smRow"" align=""center"" width=""25%"">" + dataRdr.Item(0) + "</td>")
                            End If

                            uC += 1
                        End While
                        dataRdr.Close()
                        dataConn.Close()
                    End If
                    If uC >= 1 And uC < 4 Then
                        Dim iC As Integer = 0
                        For iC = uC To 3
                            lfTable.Append("<td class=""smRow"" align=""center"" width=""25%"">&nbsp;</td>")
                        Next
                        lfTable.Append("</tr>")
                    End If

                    lfTable.Append("</table>")
                End If
            End If



            lfTable.Append("</td></tr>")
            lfTable.Append("<tr><td>&nbsp;</td></tr></table>")
            Return lfTable.ToString
        End Function

        '-- admin mailer
        Private Function loadForm25(ByVal uGUID As String) As String
            Dim lfTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
            Dim showForm As Boolean = True

            If getAdminMenuAccess(25, uGUID) = False Then
                lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                Return lfTable.ToString
                Exit Function
            End If
            lfTable.Append("<tr><td class=""md"" colspan=""2"" height=""20"" valign=""top""><b>Administrative Mailer</b></td></tr>")
            lfTable.Append("<tr><td class=""sm"" colspan=""2"" height=""20"" valign=""top"">Using this tool you can send out notification e-mail ")
            lfTable.Append(" to the members of the forum. The e-mail will be sent using the common administrator e-mail information ")
            lfTable.Append("supplied in your configuration settings, and will send the e-mail blind to the users so as to not redistribute ")
            lfTable.Append("your member's e-mail addresses.<br />")
            lfTable.Append("<br />NOTE : Depending on the number of members being mailed, it is not uncommon for there to be a delay once ")
            lfTable.Append("submitting the post. You will be notified when the mailer is complete, so do not refresh the page once submitted.<hr size=""1"" noshade /></td></tr>")
            lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" method=""post"">")
            lfTable.Append("<input type=""hidden"" name=""fi"" value=""25"">")
            If _formVerify = False Then
                If _forumName <> "" And _forumDesc = "" Then
                    lfTable.Append("<tr><td class=""smError"" align=""center"" colspan=""2"">You must include a message body for your mailer!</td></tr>")
                ElseIf _forumName = "" And _forumDesc <> "" Then
                    lfTable.Append("<tr><td class=""smError"" align=""center"" colspan=""2"">You must include a subject for your mailer!</td></tr>")
                ElseIf _forumName <> "" And _forumDesc <> "" Then
                    Dim mCount As Integer = 0
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_ADMIN_GetMailerCount", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@SendTo", SqlDbType.Int)
                    dataParam.Value = _tID
                    dataParam = dataCmd.Parameters.Add("@MCount", SqlDbType.Int)
                    dataParam.Direction = ParameterDirection.Output
                    dataConn.Open()
                    dataCmd.ExecuteNonQuery()
                    mCount = dataCmd.Parameters("@MCount").Value
                    dataConn.Close()
                    If mCount = 0 Then
                        lfTable.Append("<tr><td class=""smError"" align=""center"" colspan=""2"">Your user selection does not have any active members!</td></tr>")
                    Else
                        showForm = False
                        _forumDesc = _forumDesc.Replace(Chr(34), "")
                        lfTable.Append("<input type=""hidden"" name=""verify"" value=""1"">")
                        lfTable.Append("<input type=""hidden"" name=""tid"" value=" + Chr(34) + _tID.ToString + Chr(34) + ">")
                        lfTable.Append("<input type=""hidden"" name=""fn"" value=" + Chr(34) + _forumName + Chr(34) + ">")
                        lfTable.Append("<input type=""hidden"" name=""fd"" value=" + Chr(34) + _forumDesc + Chr(34) + ">")



                        lfTable.Append("<tr><td class=""sm"" colspan=""2"" height=""20"" valign=""top"">")
                        lfTable.Append("You are about to send the following to " + mCount.ToString)
                        Select Case _tID
                            Case 1
                                lfTable.Append(" members")
                            Case 2
                                lfTable.Append(" users")
                            Case 3
                                lfTable.Append(" moderators")
                            Case 4
                                lfTable.Append(" administrators")
                        End Select
                        lfTable.Append(" of the forum :<br />")
                        lfTable.Append("<div class=""smQuoteWrap""><div class=""smQuote"">")
                        lfTable.Append("<b>Subject : </b>" + _forumName + "<br /><br />")
                        lfTable.Append("<b>Message Body :</b><br />" + _forumDesc)
                        lfTable.Append("</div></div><br />")
                        lfTable.Append("Click on the button below to send this mailer.<br /><input type=""submit"" class=""smButton"" value=""SEND MAILER"" />")
                        lfTable.Append("<td></tr>")
                    End If

                End If
                If showForm = True Then
                    lfTable.Append("<tr><td class=""sm"" height=""20"" align=""right"" valign=""top"">Send To : </td><td class=""sm"" height=""20"">")
                    lfTable.Append("<select name=""tid"" class=""smInput"">")
                    lfTable.Append("<option value=""1" + Chr(34))
                    If _tID = 1 Then
                        lfTable.Append(" selected")
                    End If
                    lfTable.Append(">All Members</option>")
                    lfTable.Append("<option value=""2" + Chr(34))
                    If _tID = 2 Then
                        lfTable.Append(" selected")
                    End If
                    lfTable.Append(">Users Only</option>")
                    lfTable.Append("<option value=""3" + Chr(34))
                    If _tID = 3 Then
                        lfTable.Append(" selected")
                    End If
                    lfTable.Append(">Moderators Only</option>")
                    lfTable.Append("<option value=""4" + Chr(34))
                    If _tID = 4 Then
                        lfTable.Append(" selected")
                    End If
                    lfTable.Append(">Administrators Only</option>")
                    lfTable.Append("</select></td></tr>")
                    lfTable.Append("<tr><td class=""sm"" height=""20"" align=""right""><img src=" + Chr(34) + siteRoot + "/admin/images/transdot.gif"" border=""0"" height=""1"" width=""100"" /><br />Mail Subject : </td><td class=""sm"" height=""20"" width=""100%""><input type=""text"" class=""smInput"" style=""width:400px;"" name=""fn"" value=" + Chr(34) + _forumName + Chr(34) + " /></td></tr>")
                    lfTable.Append("<tr><td class=""sm"" height=""20"" align=""right"" valign=""top"">Mail Body : </td><td class=""sm"" height=""20"">")
                    lfTable.Append("<textarea name=""fd"" class=""smInput"" style=""width:100%;height:300px;"">" + _forumDesc + "</textarea></td></tr>")
                    lfTable.Append("<tr><td class=""sm"" height=""20"">&nbsp;</td><td class=""sm"" height=""20""><input type=""submit"" class=""smButton"" value=""CONTINUE"" /></td></tr>")
                End If
            Else
                Dim SMTPMailer As New MailMessage()
                Dim mailHead As String = "<html><head><title>" + _forumName + "</title></head><body><table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%""><tr><td><font face=""Tahoma, Verdana, Helvetica, Sans-Serif"" size=""2"">"
                Dim mailFoot As String = "</font></td></tr></table></body></html>"
                Dim mailMsg As String = String.Empty
                Dim mailCopy As String = "<br>&nbsp;<hr size=""1"" color=""#000000"" noshade>"
                Dim mailTo As String = String.Empty
                Dim mailToAddr As String = String.Empty
                Dim mailFrom As String = String.Empty

                mailCopy += "<font size=""1""><a href=""http://www.dotnetbb.com"" target=""_blank"">dotNetBB</a> &copy;2002, <a href=""mailto:Andrew@dotNetBB.com"">Andrew Putnam</a></font>"
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_GetMailerInfo", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@SendTo", SqlDbType.Int)
                dataParam.Value = _tID
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader
                Dim sCount As Integer = 0
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        Dim mAddr As String = String.Empty
                        Dim m1 As Integer = 0
                        Dim m2 As Integer = 0
                        If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                            mAddr = dataRdr.Item(0)
                            m1 = InStr(mAddr, "@", CompareMethod.Binary)
                            If m1 > 0 Then
                                m2 = InStr(m1, mAddr, ".", CompareMethod.Binary)
                                If m2 > 0 Then  '-- semi-valid email verified
                                    sCount += 1
                                    SMTPMailer.Subject = _forumName
                                    SMTPMailer.Body = mailHead + _forumDesc + mailCopy + mailFoot
                                    SMTPMailer.From = siteAdminMail
                                    SMTPMailer.BodyFormat = MailFormat.Html
                                    SMTPMailer.To = mAddr
                                    If smtpServerName <> "" Then
                                        SmtpMail.SmtpServer = smtpServerName
                                    End If
                                    SmtpMail.Send(SMTPMailer)
                                    Server.ClearError()
                                Else
                                    lfTable.Append("<tr><td class=""smError"" align=""center"" colspan=""2"">" + dataRdr.Item(1) + " had an invalid email address of " + dataRdr.Item(0) + "</td></tr>")
                                End If

                            End If
                        Else
                            lfTable.Append("<tr><td class=""smError"" align=""center"" colspan=""2"">" + dataRdr.Item(1) + " had an invalid email address of " + dataRdr.Item(0) + "</td></tr>")
                        End If
                    End While
                    dataRdr.Close()
                    dataConn.Close()
                End If
                If sCount > 0 Then
                    Select Case _tID
                        Case 1
                            logAdminAction(uGUID, "Administrative mailer used to send to " + sCount.ToString + " members.")
                        Case 2
                            logAdminAction(uGUID, "Administrative mailer used to send to " + sCount.ToString + " users.")
                        Case 3
                            logAdminAction(uGUID, "Administrative mailer used to send to " + sCount.ToString + " moderators.")
                        Case 4
                            logAdminAction(uGUID, "Administrative mailer used to send to " + sCount.ToString + " administrators.")
                    End Select

                End If
                lfTable.Append("<tr><td class=""smError"" align=""center"" colspan=""2"">Your mailer has been successfully sent to " + sCount.ToString + " members.</td></tr>")
            End If
            lfTable.Append("<tr><td>&nbsp;</td></tr></form></table>")
            Return lfTable.ToString
        End Function

        '-- lock/unlock thread notify
        Private Function loadForm26(ByVal uGUID As String) As String
            Dim lfTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
            Dim showForm As Boolean = True

            If getAdminMenuAccess(26, uGUID) = False Then
                lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                Return lfTable.ToString
                Exit Function
            End If
            lfTable.Append("<tr><td class=""md""><b>Lock / Unlock Threads</b></td></tr>")
            lfTable.Append("<tr><td class=""sm"">There is not a standalone tool for this feature, since this is done using links available in the forum threads. This menu item exists only to serve in allowing permission to access this feature in the forum thread.<br /><br />")
            lfTable.Append("To lock a thread locate the first post in a thread and click on the 'lock topic' image <img src=" + Chr(34) + siteRoot + "/styles/dotNetBB/images/lockthreadbtn.gif"" border=""0"" /> on the control toolbar.<br /><br />")
            lfTable.Append("To unlock a thread locate the first post in a thread and click on the 'unlock topic' image <img src=" + Chr(34) + siteRoot + "/styles/dotNetBB/images/unlockthreadbtn.gif"" border=""0"" /> on the control toolbar.<br /><br />")

            lfTable.Append("<tr><td>&nbsp;</td></tr></form></table>")
            Return lfTable.ToString
        End Function

        '-- shows users with pending mail verifications
        Private Function loadForm27(ByVal uGUID As String) As String
            Dim lfTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
            Dim showForm As Boolean = True

            If getAdminMenuAccess(27, uGUID) = False Then
                lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                Return lfTable.ToString
                Exit Function
            End If
            lfTable.Append("<tr><td class=""md"" height=""20""><b>Pending Mail Verifications</b></td></tr>")
            lfTable.Append("<tr><td class=""sm"" height=""20"">This tool will show any users who's mail verification is still pending and have not yet posted any items in the forum.  A user might still have the e-mail verification pending, but not show on this listing if their account was created when mail verification was not required and they have posted messages to the forum.<br /><br />You can choose to resend, authorize, or delete the account in the table below. </td></tr>")

            If _loadForm.ToLower = "a" And _userID > 0 Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_ApproveMailer", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@UserID", SqlDbType.Int)
                dataParam.Value = _userID
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                lfTable.Append("<tr><td class=""smError"" height=""20""><b>User Account Approved.</b></td></tr>")

            ElseIf _loadForm.ToLower = "d" And _userID > 0 Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_DeleteUserAndPosts", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@UserID", SqlDbType.Int)
                dataParam.Value = _userID
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()

                lfTable.Append("<tr><td class=""smError"" height=""20""><b>User Account Deleted.</b></td></tr>")

            ElseIf _loadForm.ToLower = "r" And _userID > 0 Then

                Dim rn As String = String.Empty
                Dim em As String = String.Empty
                Dim mg As Guid
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_GetUserForResend", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@UserID", SqlDbType.Int)
                dataParam.Value = _userID
                dataParam = dataCmd.Parameters.Add("@RealName", SqlDbType.VarChar, 100)
                dataParam.Direction = ParameterDirection.Output
                dataParam = dataCmd.Parameters.Add("@EmailAddress", SqlDbType.VarChar, 64)
                dataParam.Direction = ParameterDirection.Output
                dataParam = dataCmd.Parameters.Add("@mGUID", SqlDbType.UniqueIdentifier)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                rn = dataCmd.Parameters("@RealName").Value
                em = dataCmd.Parameters("@EmailAddress").Value
                mg = dataCmd.Parameters("@mGUID").Value
                dataConn.Close()
                If rn <> "" And em <> "" Then
                    sendMailConfirm(mg.ToString, rn, em)
                End If
                lfTable.Append("<tr><td class=""smError"" height=""20""><b>Mail Verification Resent.</b></td></tr>")

            End If


            lfTable.Append("<tr><td class=""sm"" valign=""top"" height=""20""><table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" class=""tblStd"">")
            lfTable.Append("<tr><td class=""smRowHead"" width=""15%"">User Name</td>")
            '-- updated in v2.1 : include profile create date
            lfTable.Append("<td class=""smRowHead"" width=""20%"">Create Date</td>")
            lfTable.Append("<td class=""smRowHead"" align=""center"" width=""20%"">E-Mail Address</td>")
            lfTable.Append("<td class=""smRowHead"" align=""center"" colspan=""3"" width=""45%"">Action</td></tr>")
            Dim uCount As Integer = 0
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_GetPendingMailers", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    uCount += 1
                    lfTable.Append("<tr><td class=""smRow"">" + dataRdr.Item(0) + "</td>")
                    '-- updated in v2.1 : include profile create date
                    lfTable.Append("<td class=""smRow"" width=""20%"">" + FormatDateTime(dataRdr.Item(3), DateFormat.ShortDate) + "</td>")
                    If dataRdr.IsDBNull(1) = False Then
                        lfTable.Append("<td class=""smRow"" align=""center"">" + dataRdr.Item(1) + "</td>")
                    Else
                        lfTable.Append("<td class=""smRow"" align=""center"">E-Mail is NULL!</td>")
                    End If
                    lfTable.Append("<td class=""smRow"" align=""center""><a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=27&r=r&uid=" + CStr(dataRdr.Item(2)) + Chr(34) + ">Resend</a></td>")
                    lfTable.Append("<td class=""smRow"" align=""center""><a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=27&r=a&uid=" + CStr(dataRdr.Item(2)) + Chr(34) + ">Approve</td>")
                    lfTable.Append("<td class=""smRow"" align=""center""><a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=27&r=d&uid=" + CStr(dataRdr.Item(2)) + Chr(34) + ">Delete</td></tr>")
                End While
                dataRdr.Close()
                dataConn.Close()
            End If
            If uCount = 0 Then
                lfTable.Append("<tr><td colspan=""5"" align=""center"" class=""sm"">There are no members with mail verification pending.</td></tr>")
            End If

            lfTable.Append("</table></td></tr>")
            lfTable.Append("<tr><td>&nbsp;</td></tr></form></table>")
            Return lfTable.ToString
        End Function

        '-- new in v2.1
        '-- shows the admin history log
        Private Function loadForm28(ByVal uGUID As String) As String
            Dim lfTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
            Dim showForm As Boolean = True
            Dim tRec As Integer = 0
            Dim fRec As Integer = 1
            Dim lRec As Integer = 50
            Dim i As Integer = 0

            If _tID = 0 Then
                _tID = 1
            End If
            If _tID > 1 Then
                fRec = ((_tID - 1) * 50) + 1
                lRec = (_tID * 50)
            End If
            If getAdminMenuAccess(28, uGUID) = False Then
                lfTable.Append("<tr><td class=""sm"" align=""center"" valign=""top"" height=""20""><br /><b>You do not have permission to access this item.</b></td></tr></table>")
                Return lfTable.ToString
                Exit Function
            End If
            lfTable.Append("<tr><td class=""md"" height=""20"" colspan=""2""><b>Administrator Action Log</b></td></tr>")
            lfTable.Append("<tr><td class=""sm"" height=""20"" colspan=""2"">This tool lists all adminstrator and moderator actions taken on the forum.  It is printed in date order (newest first), and you have the option of filtering by the user name of the person who performed the actions.<hr size=""1"" noshade /></td></tr>")

            '-- purge form...
            lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" />")
            lfTable.Append("<input type=""hidden"" name=""fi"" value=""28"" />")
            lfTable.Append("<tr><td class=""sm"" height=""20"" colspan=""2"">")
            If _mnPost > 7 Then         '-- dont allow anything under 7 days to be purged
                Dim dOlder As Date = DateAdd(DateInterval.Day, _mnPost * -1, DateTime.Now)
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_DeleteAdminLog", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@DateOlder", SqlDbType.DateTime)
                dataParam.Value = dOlder
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                logAdminAction(uGUID, "Admin Action log cleared of all items older than " + dOlder.ToString + ".")
                lfTable.Append("<div class=""smError"">All admin action items older than " + dOlder.ToString + " were deleted from the log.</div>")
            End If
            lfTable.Append("Delete log items from all users : <select name=""mnp"" class=""smInput""><option value=""0"">Select Minimum Range</option>")
            lfTable.Append("<option value=""7"">More than 1 week old</option>")
            lfTable.Append("<option value=""14"">More than 2 weeks old</option>")
            lfTable.Append("<option value=""30"">More than 1 month old</option>")
            lfTable.Append("<option value=""60"">More than 2 months old</option>")
            lfTable.Append("<option value=""90"">More than 3 months old</option>")
            lfTable.Append("<option value=""180"">More than 6 months old</option></select> &nbsp;<input type=""submit"" value=""DELETE"" class=""xsmButton""><hr size=""1"" noshade /></td></tr>")
            lfTable.Append("</form>")

            lfTable.Append("<form action=" + Chr(34) + siteRoot + "/admin/default.aspx"" name=""uForm"" />")
            lfTable.Append("<input type=""hidden"" name=""fi"" value=""28"" />")
            lfTable.Append("<tr><td class=""sm"" height=""20"">Filter By User : <select name=""uid"" onchange=""uForm.submit();"" class=""smInput""><option value=""0"">All Users</option>")
            '-- get user dropdown
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_GetAdminLogUsers", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    lfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(1)) + Chr(34))
                    If _userID = dataRdr.Item(1) Then
                        lfTable.Append(" selected")
                    End If
                    lfTable.Append(">" + dataRdr.Item(0) + "</option>")
                End While
                dataRdr.Close()
                dataConn.Close()
            End If

            lfTable.Append("</select></td></form>")
            '-- get record count for paging
            lfTable.Append("<td class=""sm"" align=""right"">")
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_GetAdminLogCount", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataParam = dataCmd.Parameters.Add("@UserID", SqlDbType.Int)
            dataParam.Value = _userID
            dataParam = dataCmd.Parameters.Add("@RecCount", SqlDbType.Int)
            dataParam.Direction = ParameterDirection.Output
            dataConn.Open()
            dataCmd.ExecuteNonQuery()
            tRec = dataCmd.Parameters("@RecCount").Value
            dataConn.Close()
            lfTable.Append(tRec.ToString + " Records Found")
            If tRec > 50 Then
                lfTable.Append("<br />Page Number : &nbsp;")
                If tRec Mod 50 = 0 Then
                    For i = 1 To CInt(tRec / 50)
                        If _tID = i Then
                            lfTable.Append("<b>[" + i.ToString + "]</b>&nbsp; ")
                        Else
                            lfTable.Append("<a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=28&tid=" + i.ToString + "&uid=" + _userID.ToString + Chr(34) + ">")
                            lfTable.Append(i.ToString + "</a>&nbsp; ")
                        End If
                    Next
                Else
                    For i = 1 To (Int(tRec / 50) + 1)
                        If _tID = i Then
                            lfTable.Append("<b>[" + i.ToString + "]</b>&nbsp; ")
                        Else
                            lfTable.Append("<a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=28&tid=" + i.ToString + "&uid=" + _userID.ToString + Chr(34) + ">")
                            lfTable.Append(i.ToString + "</a>&nbsp; ")
                        End If
                    Next
                End If
            End If
            lfTable.Append("</td></tr>")
            lfTable.Append("<tr><td class=""sm"" height=""20"" colspan=""2"">")
            lfTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" class=""tblStd"">")
            lfTable.Append("<tr><td class=""smRowHead"" align=""center"" width=""25%"">Log Date</td>")
            lfTable.Append("<td class=""smRowHead"" align=""center"" width=""15%"">User Name</td>")
            lfTable.Append("<td class=""smRowHead"" align=""center"" width=""60%"">Action Taken</td></tr>")
            '-- get records
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_GetAdminLogPage", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataParam = dataCmd.Parameters.Add("@UserID", SqlDbType.Int)
            dataParam.Value = _userID
            dataParam = dataCmd.Parameters.Add("@FirstRec", SqlDbType.Int)
            dataParam.Value = fRec
            dataParam = dataCmd.Parameters.Add("@LastRec", SqlDbType.Int)
            dataParam.Value = lRec
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    lfTable.Append("<tr><td class=""smRow"">" + FormatDateTime(dataRdr.Item(0), DateFormat.GeneralDate) + " (GMT)</td>")
                    lfTable.Append("<td align=""center"" class=""smRow""><a href=" + Chr(34) + siteRoot + "/admin/default.aspx?fi=28&uid=" + CStr(dataRdr.Item(1)) + Chr(34) + ">" + dataRdr.Item(3) + "</a></td>")
                    lfTable.Append("<td class=""smRow"">" + dataRdr.Item(2) + "</td></tr>")
                End While
                dataRdr.Close()
                dataConn.Close()
            End If
            lfTable.Append("</table></td></tr>")
            lfTable.Append("<tr><td>&nbsp;</td></tr></form></table>")
            Return lfTable.ToString
        End Function

        '-- no html fix
        Private Function adminNoHTMLFix(ByVal nonStr As String) As String
            Dim noHTML As String = nonStr
            Try

                If noHTML.ToString.Trim <> String.Empty Then
                    If Left(noHTML, 1) = "[" Then       '-- fixes tag items that begin the posts
                        noHTML = " " + noHTML
                    End If
                    noHTML = noHTML.Replace(Chr(34), "&quot;")      '-- fixes "
                    noHTML = noHTML.Replace("<", "&lt;")            '-- fixes <
                    noHTML = noHTML.Replace(">", "&gt;")            '-- Fixes >
                    noHTML = noHTML.Replace(vbCrLf, "<br>")         '-- fixes line breaks
                End If
            Catch ex As Exception
                logErrorMsg("forumNoHTMLFix<br />" + ex.StackTrace.ToString, 1)
            End Try
            Return noHTML
        End Function

        '-- converts the form posting from TBTags to HTML
        Private Function adminTBTagToHTML(ByVal tbString As String) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If formStrLoaded = False Then
                formStrLoaded = xmlLoadStringMsg("form")
            End If
            Dim outSTr As String = tbString
            Dim tStr As String = String.Empty
            Dim imgStr As String = String.Empty
            Dim tMark1 As Integer = 0
            Dim tMark2 As Integer = 0
            Dim canModerate As Boolean = True
            Dim bWord As String = String.Empty
            Dim gWord As String = String.Empty
            Dim acl As Integer = 0

            '-- emoticon replacements
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ActiveEmoticon", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                        imgStr = "<img src=" + Chr(34) + siteRoot + "/emoticons/" + dataRdr.Item(0) + Chr(34)
                        If dataRdr.IsDBNull(2) = False Then
                            imgStr += " alt=" + Chr(34) + dataRdr.Item(2) + Chr(34)
                        Else
                            imgStr += " alt=" + Chr(34) + Chr(34)
                        End If
                        imgStr += ">"
                        outSTr = outSTr.Replace(CStr(dataRdr.Item(1)), imgStr)
                    End If
                End While
            End If
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_GetFilterWords", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False And dataRdr.IsDBNull(2) = False Then
                        bWord = dataRdr.Item(0)
                        gWord = dataRdr.Item(1)
                        acl = dataRdr.Item(2)
                        If (canModerate = True And acl = 2) Or (canModerate = False And acl = 1) Then
                            outSTr = Microsoft.VisualBasic.Replace(outSTr, bWord, gWord, , , CompareMethod.Text)
                        End If
                    End If
                End While
                dataRdr.Close()
                dataConn.Close()

            End If

            Try
                outSTr = Microsoft.VisualBasic.Replace(outSTr, B_START, "<b>", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, B_END, "</b>", , , CompareMethod.Text)

                outSTr = Microsoft.VisualBasic.Replace(outSTr, U_START, "<u>", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, U_END, "</u>", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, I_START, "<i>", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, I_END, "</i>", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, SUP_START, "<sup>", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, SUP_END, "</sup>", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, SUB_START, "<sub>", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, SUB_END, "</sub>", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[s]", "<s>", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[/s]", "</s>", , , CompareMethod.Text)


                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[red]", "<font style=""color:990000;"">", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[/red]", "</font>", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[green]", "<font style=""color:00FF00;"">", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[/green]", "</font>", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[cyan]", "<font style=""color:008B8B;"">", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[/cyan]", "</font>", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[blue]", "<font style=""color:000099;"">", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[/blue]", "</font>", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[purple]", "<font style=""color:800080;"">", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[/purple]", "</font>", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[white]", "<font style=""color:FFFFFF;"">", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[/white]", "</font>", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[gray]", "<font style=""color:CCCCCC;"">", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[/gray]", "</font>", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[black]", "<font style=""color:000000;"">", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[/black]", "</font>", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[yellow]", "<font style=""color:FFFF00;"">", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[/yellow]", "</font>", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[orange]", "<font style=""color:FFA500;"">", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[/orange]", "</font>", , , CompareMethod.Text)

                Dim iw As Integer = 0
                For iw = 1 To 5
                    Select Case iw
                        Case 1
                            outSTr = Microsoft.VisualBasic.Replace(outSTr, "[" + iw.ToString + "]", "<font style=""font-size:7.5pt;"">", , , CompareMethod.Text)
                        Case 2
                            outSTr = Microsoft.VisualBasic.Replace(outSTr, "[" + iw.ToString + "]", "<font style=""font-size:8pt;"">", , , CompareMethod.Text)
                        Case 3
                            outSTr = Microsoft.VisualBasic.Replace(outSTr, "[" + iw.ToString + "]", "<font style=""font-size:10pt;"">", , , CompareMethod.Text)
                        Case 4
                            outSTr = Microsoft.VisualBasic.Replace(outSTr, "[" + iw.ToString + "]", "<font style=""font-size:12pt;"">", , , CompareMethod.Text)
                        Case 5
                            outSTr = Microsoft.VisualBasic.Replace(outSTr, "[" + iw.ToString + "]", "<font style=""font-size:14pt;"">", , , CompareMethod.Text)
                    End Select

                    outSTr = Microsoft.VisualBasic.Replace(outSTr, "[/" + iw.ToString + "]", "</font>", , , CompareMethod.Text)
                Next

                outSTr = adminLoopThruTags(outSTr, "quote")


                outSTr = Microsoft.VisualBasic.Replace(outSTr, QUOTE_START, "<div class=""msgQuoteWrap""><div class=""msgQuote""><b>" + getHashVal("form", "101") + "</b><br />", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, QUOTE_END, "</div></div>", , , CompareMethod.Text)

                outSTr = Microsoft.VisualBasic.Replace(outSTr, IMG_START, "<img src=" + Chr(34), , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, IMG_END, Chr(34) + " border=""0"">", , , CompareMethod.Text)

                outSTr = adminLoopThruTags(outSTr, "list")
                outSTr = adminLoopThruTags(outSTr, "flash")
                outSTr = adminLoopThruTags(outSTr, "url")
                outSTr = adminLoopThruTags(outSTr, "code")


            Catch ex As Exception
                logErrorMsg("forumTBTagToHTML<br />" + ex.StackTrace.ToString, 1)
            End Try

            Return outSTr
        End Function

        '-- processes TBTags to HTML that have possible sub values
        Private Function adminLoopThruTags(ByVal tagStr As String, ByVal tagType As String) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            Dim il As Integer = 0
            Dim i1 As Integer = 0
            Dim i2 As Integer = 0
            Dim i3 As Integer = 0
            Dim t1 As String = String.Empty
            Dim t2 As String = String.Empty
            Dim tagItem As String = String.Empty
            Dim tagText As String = String.Empty
            Dim retTag As String = String.Empty
            Dim hasTags As Boolean = True
            Try

                If tagStr.ToString.Length > 0 Then  '-- make sure not an empth string
                    retTag = tagStr '-- assign to return string value
                    Select Case tagType.ToString.ToLower
                        Case "list" '-- <ul><li></li></ul> items
                            While InStr(retTag, LIST_START, CompareMethod.Text) > 0
                                il += 1
                                If il >= 5 Then     '-- if they have more than 15 lists, also catches bad tag closes
                                    Exit While
                                End If
                                i1 = InStr(retTag, LIST_START, CompareMethod.Text)
                                If i1 > 0 Then
                                    i2 = InStr(i1, retTag, LIST_END, CompareMethod.Text)
                                    If i2 > 0 Then
                                        tagItem = Mid(retTag, i1 + 6, i2 - (i1 + 6))
                                        tagItem = "<ul>" + tagItem + "</ul>"
                                        tagItem = tagItem.Replace("*", "<li>")
                                        t1 = Left(retTag, i1 - 1)
                                        t2 = Right(retTag, retTag.Length - (i2 + 6))
                                        retTag = t1 + tagItem + t2
                                    Else
                                        tagItem = Right(retTag, retTag.Length - (i1 + 6))
                                        tagItem = "<ul>" + tagItem + "</ul>"
                                        tagItem = tagItem.Replace("*", "<li>")
                                        t1 = Left(retTag, i1 - 1)
                                        retTag = t1 + tagItem
                                    End If
                                End If
                            End While

                        Case "flash"
                            Dim flH As String = "200"       '-- default flash height
                            Dim flW As String = "200"       '-- default flash width
                            Dim sArr() As String
                            While InStr(retTag, FLASH_START, CompareMethod.Text) > 0
                                il += 1
                                If il >= 5 Then     '-- more than 5 flash in a post also catches bad tag closes
                                    Exit While
                                End If
                                i1 = InStr(retTag, FLASH_START, CompareMethod.Text)
                                If i1 > 0 Then
                                    i2 = InStr(i1 + 6, retTag, "]", CompareMethod.Text)
                                    '-- find the height/width sizing
                                    t1 = Mid(retTag, i1 + 6, i2 - (i1 + 6))
                                    If InStr(t1, "|", CompareMethod.Text) > 0 Then
                                        sArr = t1.Split("|")
                                        If UBound(sArr) >= 2 Then
                                            If IsNumeric(sArr(1)) = True Then
                                                flH = sArr(1)
                                            End If
                                            If IsNumeric(sArr(2)) = True Then
                                                flW = sArr(2)
                                            End If
                                        End If
                                    End If
                                    t1 = Left(retTag, i1 - 1)

                                    i3 = InStr(i2 + 1, retTag, FLASH_END, CompareMethod.Text)

                                    tagItem = Mid(retTag, i2 + 1, (i3 - (i2 + 1)))
                                    If i3 + 8 < retTag.Length Then
                                        t2 = Right(retTag, retTag.Length - (i3 + 7))
                                    Else
                                        t2 = String.Empty
                                    End If

                                    tagItem = "<br /><embed src=" + Chr(34) + tagItem + Chr(34) + " height=" + Chr(34) + flH + Chr(34)
                                    tagItem += " width=" + Chr(34) + flW + Chr(34) + " quality=""high"" loop=""infinite"" "
                                    tagItem += "TYPE=""application/x-shockwave-flash"" "
                                    tagItem += "PLUGINSPAGE=""www.macromedia.com/shockwave/download/index.cgiP1_Prod_Version=Shockwaveflash"">"
                                    retTag = t1 + tagItem + t2
                                End If
                                t1 = String.Empty
                                t2 = String.Empty
                            End While

                        Case "url"
                            '-- first do the '[url=...] tags...
                            il = 0
                            While InStr(retTag, URL1_START, CompareMethod.Text) > 0
                                il += 1
                                If il >= 16 Then     '-- v2.1 updated from 9 to 15 max url's
                                    Exit While
                                End If
                                i1 = InStr(retTag, URL1_START, CompareMethod.Text)
                                i2 = InStr(i1, retTag, "]", CompareMethod.Text)
                                If i2 > i1 Then
                                    tagItem = Mid(retTag, i1 + 5, i2 - (i1 + 5))
                                    'tagItem = tagItem.ToLower
                                    If Left(tagItem.ToLower, 4) <> "http" And Left(tagItem.ToLower, 7) <> "mailto:" And InStr(tagItem, "@", CompareMethod.Text) = 0 And Left(tagItem.ToLower, 3) <> "ftp" Then
                                        tagItem = "http://" + tagItem
                                    ElseIf Left(tagItem.ToLower, 4) <> "http" And Left(tagItem.ToLower, 7) <> "mailto:" And InStr(tagItem, "@", CompareMethod.Text) > 0 And Left(tagItem.ToLower, 3) <> "ftp" Then
                                        tagItem = "mailto:" + tagItem
                                    End If
                                    t1 = Left(retTag, i1 - 1)
                                    t2 = Right(retTag, retTag.Length - i2)
                                    retTag = t1 + "<a href=" + Chr(34) + tagItem + Chr(34) + " target=""_blank"">" + t2
                                End If

                            End While
                            '-- now the [url] tags...
                            il = 0
                            While InStr(retTag, URL2_START, CompareMethod.Text) > 0
                                il += 1
                                If il >= 16 Then '-- v2.1 updated from 9 to 15 max url's
                                    Exit While
                                End If
                                i1 = InStr(retTag, URL2_START, CompareMethod.Text)
                                i2 = InStr(i1, retTag, URL_END, CompareMethod.Text)
                                If i2 > i1 Then
                                    tagItem = Mid(retTag, i1 + 5, i2 - (i1 + 5))
                                    'tagItem = tagItem.ToLower
                                    If Left(tagItem.ToLower, 4) <> "http" And Left(tagItem.ToLower, 7) <> "mailto:" And InStr(tagItem, "@", CompareMethod.Text) = 0 And Left(tagItem.ToLower, 3) <> "ftp" Then
                                        tagItem = "http://" + tagItem
                                    ElseIf Left(tagItem.ToLower, 4) <> "http" And Left(tagItem.ToLower, 7) <> "mailto:" And InStr(tagItem, "@", CompareMethod.Text) > 0 And Left(tagItem.ToLower, 3) <> "ftp" Then
                                        tagItem = "mailto:" + tagItem
                                    End If
                                    tagText = Right(tagItem, tagItem.Length - 7)
                                    t1 = Left(retTag, i1 - 1)
                                    t2 = Right(retTag, retTag.Length - (i2 - 1))
                                    retTag = t1 + "<a href=" + Chr(34) + tagItem + Chr(34) + " target=""_blank"">" + tagText + t2
                                End If

                            End While
                            '-- close all [/url] tags... 
                            retTag = retTag.Replace(URL_END, "</a>")


                        Case "code"
                            il = 0
                            While InStr(retTag, CODE_START, CompareMethod.Text) > 0
                                il += 1
                                If il >= 5 Then
                                    Exit While
                                End If
                                i1 = InStr(retTag, CODE_START, CompareMethod.Text)
                                i2 = InStr(i1, retTag, CODE_END, CompareMethod.Text)
                                If i2 > i1 Then
                                    tagItem = Mid(retTag, i1 + 6, i2 - (i1 + 6))
                                    tagItem = tagItem.Trim()
                                    tagItem = tagItem.Replace(vbTab, "&nbsp;&nbsp;&nbsp;&nbsp;")
                                    tagItem = tagItem.Replace(" ", "&nbsp;")
                                    tagItem = tagItem.Replace("<br&nbsp;/> ", "<br />")
                                    t1 = Left(retTag, i1 - 1)
                                    t2 = Right(retTag, retTag.Length - (i2 + 6))
                                    retTag = t1 + "<div class=""msgQuoteWrap""><div class=""msgCode"">" + tagItem + "</div></div>" + t2
                                End If

                            End While
                        Case "quote"
                            il = 0
                            While InStr(retTag, QUOTE_EQ_START, CompareMethod.Text) > 0
                                il += 1
                                If il >= 16 Then    '-- v2.1 updated from 4 to 15 quote max
                                    Exit While
                                End If
                                i1 = InStr(retTag, QUOTE_EQ_START, CompareMethod.Text)
                                t1 = Left(retTag, i1 - 1)
                                If i1 > 1 Then
                                    i1 = i1 + QUOTE_EQ_START.Length
                                End If
                                i2 = InStr(i1, retTag, "&quot;", CompareMethod.Text)
                                ' i3 = InStr(i2, retTag, QUOTE_END, CompareMethod.Text)
                                If i2 > 0 Then  '-- i3 > 0 And 
                                    tagItem = Mid(retTag, i1, i2 - i1)
                                    tagItem = tagItem.Replace(Chr(34), "")
                                    tagItem = "<div class=""msgQuoteWrap""><div class=""msgQuote""><b>" + tagItem + getHashVal("main", "145") + "</b><br />"

                                    t2 = Right(retTag, retTag.Length - (i2 + 6))
                                    't2 = t2.Replace(QUOTE_END, "</div></div>")
                                    retTag = t1 + tagItem + t2
                                End If
                            End While

                    End Select

                End If
            Catch ex As Exception
                logErrorMsg("loopThruTags<br />" + ex.StackTrace.ToString, 1)
            End Try
            Return retTag
        End Function

        '-- Admin menu access
        Private Function getAdminMenuAccess(ByVal menuID As Integer, ByVal uGUID As String) As Boolean
            Dim hasAccess As Boolean = False
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_GetMenuAccess", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
            dataParam.Value = XmlConvert.ToGuid(uGUID)
            dataParam = dataCmd.Parameters.Add("@MenuID", SqlDbType.Int)
            dataParam.Value = menuID
            dataParam = dataCmd.Parameters.Add("@hasAccess", SqlDbType.Bit)
            dataParam.Direction = ParameterDirection.Output
            dataConn.Open()
            dataCmd.ExecuteNonQuery()
            hasAccess = dataCmd.Parameters("@hasAccess").Value
            dataConn.Close()
            If hasAccess = False Then
                logAdminAction(uGUID, "Denied access to admin tool " + menuID.ToString)
            End If
            Return hasAccess
        End Function

        '--- Copyright message
        Public Function printCopyright() As String
            Dim pcStr As New StringBuilder()
            pcStr.Append("Forum powered by dotNetBB v2.1<br />")
            pcStr.Append("<a href=""http://www.dotnetbb.com"" target=""_blank"">dotNetBB</a>&nbsp;&copy;&nbsp;2000-2002 <a href=""mailto:Andrew@dotNetBB.com"">Andrew Putnam</a>")
            Return pcStr.ToString
        End Function

        '*** Generic Error Logging Sub
        Private Sub logErrorMsg(ByVal eMsg As String, ByVal eType As Integer)
            HttpContext.Current.Response.Write("An Error has occurred :")
            HttpContext.Current.Response.Write(eMsg)
        End Sub

        '-- logs admin actions to the database
        Private Sub logAdminAction(ByVal uGUID As String, ByVal logMsg As String)
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_LogAction", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
            dataParam.Value = XmlConvert.ToGuid(uGUID)
            dataParam = dataCmd.Parameters.Add("@AdminAction", SqlDbType.VarChar, 400)
            dataParam.Value = Left(logMsg, 400)
            dataConn.Open()
            dataCmd.ExecuteNonQuery()
            dataConn.Close()
        End Sub

        '-- sends confirmation email for new accounts
        Private Sub sendMailConfirm(ByVal mGUID As String, ByVal userName As String, ByVal userMail As String)
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If formStrLoaded = False Then
                formStrLoaded = xmlLoadStringMsg("form")
            End If
            Dim SMTPMailer As New MailMessage()
            Dim mailHead As String = "<html><head><title>" + getHashVal("form", "108") + "</title></head><body><table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%""><tr><td><font face=""Tahoma, Verdana, Helvetica, Sans-Serif"" size=""2"">"
            Dim mailFoot As String = "</font></td></tr></table></body></html>"
            Dim mailMsg As String = String.Empty
            Dim mailCopy As String = "<br>&nbsp;<hr size=""1"" color=""#000000"" noshade>"
            Dim mailTo As String = String.Empty
            Dim mailToAddr As String = String.Empty
            Dim mailFrom As String = String.Empty
            Dim postUser As String = String.Empty

            mailCopy += "<font size=""1""><a href=""http://www.dotnetbb.com"" target=""_blank"">dotNetBB</a> &copy;2002, <a href=""mailto:Andrew@dotNetBB.com"">Andrew Putnam</a></font>"

            mailTo = userName
            mailToAddr = userMail
            If mailTo <> String.Empty And mailToAddr <> String.Empty Then
                Dim i1 As Integer = 0
                Dim i2 As Integer = 0
                i1 = InStr(mailToAddr, "@", CompareMethod.Binary)
                If i1 > 1 Then
                    i2 = InStr(i1, mailToAddr, ".", CompareMethod.Binary)
                    If i2 > 1 Then
                        mailMsg = getHashVal("form", "96") + mailTo + "<br />"
                        mailMsg += getHashVal("form", "109") + boardTitle.ToString + getHashVal("form", "110") + "<br />"
                        mailMsg += "<br />" + getHashVal("form", "110") + "<br /> "
                        mailMsg += "<a href=" + Chr(34) + siteURL + siteRoot + "/?r=ca&ui=" + Server.UrlEncode(mGUID) + Chr(34) + " target=""_blank"">"
                        mailMsg += siteURL + siteRoot + "/?r=ca&ui=" + mGUID + "</a>"
                        SMTPMailer.Subject = boardTitle.ToString + " " + getHashVal("form", "108")
                        SMTPMailer.To = mailToAddr
                        SMTPMailer.From = siteAdmin + "<" + siteAdminMail + ">"
                        SMTPMailer.BodyFormat = MailFormat.Html
                        SMTPMailer.Body = mailHead + mailMsg + mailCopy + mailFoot
                        If smtpServerName <> "" Then
                            SmtpMail.SmtpServer = smtpServerName
                        End If
                        SmtpMail.Send(SMTPMailer)
                        Server.ClearError()

                    End If
                End If

            End If

        End Sub

        '-- loads the string messages into a hashtable if not already loaded
        Private Function xmlLoadStringMsg(ByVal hashRef As String) As Boolean
            Dim goodLoad As Boolean = False
            Dim xmldoc As New XmlDocument()
            Dim stringNodes As XmlNodeList
            Dim stringNode As XmlNode
            Dim lFile As String = String.Empty
            Select Case hashRef.ToLower
                Case "main"
                    lFile = (Server.MapPath(siteRoot + "/xml/stringmain.xml"))
                    mainStringHash.Clear()

                Case "user"
                    lFile = (Server.MapPath(siteRoot + "/xml/stringuser.xml"))
                    userStringHash.Clear()

                Case "form"
                    lFile = (Server.MapPath(siteRoot + "/xml/stringform.xml"))
                    formStringHash.Clear()

                Case "pm"
                    lFile = (Server.MapPath(siteRoot + "/xml/stringpm.xml"))
                    pmStringHash.Clear()

                Case "search"
                    lFile = (Server.MapPath(siteRoot + "/xml/stringsearch.xml"))
                    searchStringHash.Clear()

                Case "wiz"
                    lFile = (Server.MapPath(siteRoot + "/xml/stringwizard.xml"))
                    wizStringHash.Clear()

            End Select
            Try
                If File.Exists(lFile) = True Then
                    xmldoc.Load(lFile)
                    '-- traverse each string message
                    stringNodes = xmldoc.GetElementsByTagName("S")
                    For Each stringNode In stringNodes
                        xmlTraverseAttributes(stringNode, hashRef)
                    Next
                    goodLoad = True
                End If

            Catch ex As Exception
                HttpContext.Current.Response.Write("ERROR LOADING XML STRING MESSAGE FILE : " + lFile + "<br />" + ex.Message.ToString)
            End Try

            Return goodLoad
        End Function

        '-- adds node attributes to selected hashtable
        Private Sub xmlTraverseAttributes(ByVal node As XmlNode, ByVal hashRef As String)
            Dim attributes As XmlAttributeCollection
            Dim attribute As XmlAttribute
            Dim sID As String = String.Empty
            Dim sVal As String = String.Empty
            attributes = node.Attributes()
            For Each attribute In attributes
                If 0 = String.Compare(attribute.Name, "N") Then
                    sID = attribute.InnerXml
                ElseIf 0 = String.Compare(attribute.Name, "V") Then
                    sVal = attribute.InnerXml
                End If
            Next
            If sID <> String.Empty And sVal <> String.Empty Then
                Select Case hashRef.ToLower
                    Case "main"
                        mainStringHash.Add(sID, sVal)

                    Case "user"
                        userStringHash.Add(sID, sVal)

                    Case "form"
                        formStringHash.Add(sID, sVal)

                    Case "pm"
                        pmStringHash.Add(sID, sVal)

                    Case "search"
                        searchStringHash.Add(sID, sVal)

                    Case "wiz"
                        wizStringHash.Add(sID, sVal)

                End Select
            End If


        End Sub

    End Class

End Namespace
