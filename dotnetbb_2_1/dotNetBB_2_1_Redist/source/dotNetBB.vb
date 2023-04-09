Imports Microsoft.VisualBasic
Imports System
Imports System.Collections
Imports System.Configuration
Imports System.Diagnostics
Imports System.Data
Imports System.Data.SqlClient
Imports System.IO
imports System.Net
Imports System.Text
Imports System.Web
Imports System.Web.Mail
Imports System.Web.UI
Imports System.Web.UI.WebControls
Imports System.Web.UI.HtmlControls
Imports System.Xml

Namespace ATPSoftware.dotNetBB
    Public Class bbForum
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
        Private Const LOWER_LIMIT As Long = 48              'ascii for 0
        Private Const UPPER_LIMIT As Long = 125             'ascii for {
        Private Const CHARMAP As Long = 39

        Private Const MAX_THREAD As Integer = 25

        '-- internal site globals
        Public siteRoot As String = ConfigurationSettings.AppSettings("rootPath")
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


        '-- Internal user items
        Private userGUID As String = string.empty
        Private isGuest As Boolean = True
        'Private userName As String = string.empty
        Private Structure userTitles
            Dim minVal As Integer
            Dim maxval As Integer
            Dim titleText As String
        End Structure

        Private Structure searchResult
            Dim parentID As Integer
            Dim messageID As Integer
            Dim messageText As String
        End Structure

        '-- string message holders
        Private mainStrLoaded As Boolean = False
        Private userStrLoaded As Boolean = False
        Private formStrLoaded As Boolean = False
        Private pmStrLoaded As Boolean = False
        Private searchStrLoaded As Boolean = False
        Private wizStrLoaded As Boolean = False

        '-- Updated initial values in v2.1
        Private mainStringHash As New Hashtable(162)
        Private userStringHash As New Hashtable(178)
        Private formStringHash As New Hashtable(114)
        Private pmStringHash As New Hashtable(55)
        Private searchStringHash As New Hashtable(35)
        Private wizStringHash As New Hashtable(30)

        '---------------
        '-- new in v2.1
        Private tb_eu37 As Boolean = True
        Private tb_searchIn As Integer = 1
        Private Property _searchIn() As Integer
            Get
                Return tb_searchIn
            End Get
            Set(ByVal Value As Integer)
                tb_searchIn = Value
            End Set
        End Property
        Private Property _eu37() As Boolean
            Get
                Return tb_eu37
            End Get
            Set(ByVal Value As Boolean)
                tb_eu37 = Value
            End Set
        End Property

        '-- end new in v2.1

        '-- internal post/querystring values
        Private tb_LoadForm As String = "x"                 '-- Holds the value of the form being loaded
        Private tb_categoryID As Integer = 0                '-- Holds the value of the selected category id
        Private tb_forumID As Integer = 0                   '-- Holds the value of the current forum ID
        Private tb_messageID As Integer = 0                 '-- Holds the value of the current message thread ID
        Private tb_currentPage As Integer = 1               '-- Holds the value of the current page number
        Private tb_perPage As Integer = 25                  '-- Holds the value of the max items per page to be viewed
        Private tb_setVal As String = String.Empty          '-- Holds the value of the cookie to be set
        Private tb_getVal As String = String.Empty          '-- Holds the value of the cookie being retreived
        Private tb_userIP As String = String.Empty          '-- Holds the user's IP Address
        Private tb_userName As String = String.Empty        '-- Holds the users login name on post
        Private tb_userPass As String = String.Empty        '-- Holds the users login password on post
        Private tb_userMail As String = String.Empty        '-- Holds the users email address on post
        Private tb_userTitle As String = String.Empty       '-- Holds the users custom title 
        Private tb_processForm As Boolean = False           '-- if processing the form
        Private tb_formSticky As Boolean = False            '-- moderator sticky post option
        Private tb_formLock As Boolean = False              '-- moderator lock post option
        Private tb_formSubj As String = String.Empty        '-- the subject of the post
        Private tb_formBody As String = String.Empty        '-- the body of the post
        Private tb_postIcon As String = String.Empty        '-- the name of the post icon used
        Private tb_formPreview As Boolean = False           '-- if the post is to be previewed
        Private tb_formMail As Boolean = False              '-- if the post is to have email reply notifications
        Private tb_formSig As Boolean = True                '-- if the post is to include the user signature
        Private tb_formParent As Boolean = False            '-- if the post is the first post
        Private tb_AsModerator As Boolean = False           '-- if user is posting or editing as a moderator
        Private tb_createNew As Boolean = False             '-- if post is newly created
        Private tb_passCoppa As Boolean = False             '-- if user has passed coppa lock
        Private tb_panelID As Integer = 0                   '-- selects the user control panel to be shown
        Private tb_isCoppa As Boolean = False               '-- if user is coppa locked
        Private tb_isPrintable As Boolean = False           '-- if printable page version to be shown
        Private tb_realName As String = String.Empty        '-- holds the user's real name
        Private tb_showEmail As Integer = 1                 '-- if e-mail address is shown
        Private tb_homePage As String = String.Empty        '-- holds the user's personal homepage
        Private tb_timeOffset As Double = 0                 '-- holds the user's timeoffset
        Private tb_editSignature As String = String.Empty   '-- holds the user's signature
        Private tb_wizardID As Integer = 0                  '-- Holds the Popup Wizard ID	
        Private tb_flashURL As String = String.Empty        '-- holds the url for user's flash image
        Private tb_flashHeight As String = "200"            '-- user's flash image hieght
        Private tb_flashWidth As String = "200"             '-- user's flash image width
        Private tb_flashVersion As String = "5"             '-- not used
        Private tb_userID As Integer = 0                    '-- userID for the user
        Private tb_maxReturn As Integer = 25                '-- Holds maximum number of return values
        Private tb_maxDays As Integer = 1                   '-- Holds maximum number of days back to look
        Private tb_searchWords As String = String.Empty     '-- Holds the keywords to search for
        Private tb_searchAs As Integer = 1                  '-- All or Any keywords
        Private tb_aimName As String = String.Empty         '-- holds the user's AIM name
        Private tb_icqNumber As Integer = 0                 '-- holds the users' ICQ number
        Private tb_yPager As String = String.Empty          '-- user's Y! name
        Private tb_msnName As String = String.Empty         '-- user's MSN Name
        Private tb_uLocation As String = String.Empty       '-- user's location
        Private tb_uOccupation As String = String.Empty     '-- user's occupation
        Private tb_uInterests As String = String.Empty      '-- user's interests
        Private tb_uAvatar As String = String.Empty         '-- user's avatar
        Private tb_usePM As Boolean = True                  '-- user selected use PM    
        Private tb_pmPopUp As Boolean = True                '-- user selected PM popup notification
        Private tb_pmEmail As Boolean = True                '-- user selected PM email notification
        Private tb_pmLock As Boolean = False                '-- admin selected PM lock for user
        Private tb_eu1 As Boolean = False                   '-- show thread/post totals
        Private tb_eu2 As Boolean = False                   '-- show newest member
        Private tb_eu3 As Boolean = False                   '-- show who's online
        Private tb_eu4 As Boolean = False                   '-- allow forum subscription
        Private tb_eu5 As Boolean = False                   '-- allow tbcode in posts
        Private tb_eu6 As Boolean = False                   '-- allow topic icons
        Private tb_eu7 As Boolean = False                   '-- allow emoticons
        Private tb_eu8 As Boolean = False                   '-- allow email notifiications
        Private tb_eu9 As Boolean = False                   '-- show end-user edited timestamps
        Private tb_eu10 As Boolean = False                  '-- show moderator edited timestamps
        Private tb_eu11 As Integer = 0                      '-- anti-spam timer
        Private tb_eu12 As Boolean = False                  '-- email verification as guest
        Private tb_eu13 As Boolean = False                  '-- view profile as guest
        Private tb_eu14 As Boolean = False                  '-- allow avatars
        Private tb_eu15 As Boolean = False                  '-- allow remote avatars
        Private tb_eu16 As String = String.Empty            '-- remote avatar size
        Private tb_eu17 As Boolean = False                  '-- Allow AIM
        Private tb_eu18 As Boolean = False                  '-- Allow Y!
        Private tb_eu19 As Boolean = False                  '-- Allow MSN
        Private tb_eu20 As Boolean = False                  '-- Allow ICQ
        Private tb_eu21 As Boolean = False                  '-- Allow E-mail
        Private tb_eu22 As Boolean = False                  '-- Allow Homepage
        Private tb_eu23 As Boolean = False                  '-- Allow Signature
        Private tb_eu24 As Boolean = False                  '-- Allow TBCode in signature
        Private tb_eu25 As String = String.Empty            '-- not used
        Private tb_eu26 As String = String.Empty            '-- not used
        Private tb_eu27 As Integer = 0                      '-- cookie expiration
        Private tb_eu28 As Boolean = False                  '-- not used
        Private tb_eu29 As Integer = 0                      '-- private messagebox size
        Private tb_eu30 As Boolean = False                  '-- allow private messaging
        Private tb_eu31 As Integer = 0                      '-- default timezone offset
        Private tb_eu32 As String = String.Empty            '-- default page theme
        Private tb_eu33 As String = String.Empty            '-- coppa fax #
        Private tb_eu34 As String = String.Empty            '-- coppa mail address
        Private tb_eu35 As Boolean = True                   '-- Show Forum Quick Post Form
        Private tb_eu36 As Boolean = False                  '-- Use NT Auth for login
        Private tb_edOrDel As String = String.Empty         '-- post variable for edit 
        Private tb_mVerify As String = String.Empty         '-- mail verification (?)
        Private tb_fSub As Integer = 0                      '-- ignore item variable
        Private tb_tSub As Integer = 0                      '-- ignore item variable
        Private tb_mp As String = "a"                       '-- member list page (defaults to alpha ordering)
        Private tb_ml As String = String.Empty              '-- member list key
        Private tb_pv1 As String = String.Empty             '-- poll value
        Private tb_pv2 As String = String.Empty             '-- poll value
        Private tb_pv3 As String = String.Empty             '-- poll value
        Private tb_pv4 As String = String.Empty             '-- poll value
        Private tb_pv5 As String = String.Empty             '-- poll value
        Private tb_pv6 As String = String.Empty             '-- poll value

        Private Property _pv1() As String
            Get
                Return tb_pv1
            End Get
            Set(ByVal Value As String)
                tb_pv1 = Value
            End Set
        End Property
        Private Property _pv2() As String
            Get
                Return tb_pv2
            End Get
            Set(ByVal Value As String)
                tb_pv2 = Value
            End Set
        End Property
        Private Property _pv3() As String
            Get
                Return tb_pv3
            End Get
            Set(ByVal Value As String)
                tb_pv3 = Value
            End Set
        End Property
        Private Property _pv4() As String
            Get
                Return tb_pv4
            End Get
            Set(ByVal Value As String)
                tb_pv4 = Value
            End Set
        End Property
        Private Property _pv5() As String
            Get
                Return tb_pv5
            End Get
            Set(ByVal Value As String)
                tb_pv5 = Value
            End Set
        End Property
        Private Property _pv6() As String
            Get
                Return tb_pv6
            End Get
            Set(ByVal Value As String)
                tb_pv6 = Value
            End Set
        End Property
        Private Property _ml() As String
            Get
                Return tb_ml
            End Get
            Set(ByVal Value As String)
                tb_ml = Value
            End Set
        End Property
        Private Property _mp() As String
            Get
                Return tb_mp
            End Get
            Set(ByVal Value As String)
                tb_mp = Value
            End Set
        End Property
        Private Property _tSub() As Integer
            Get
                Return tb_tSub
            End Get
            Set(ByVal Value As Integer)
                tb_tSub = Value
            End Set
        End Property
        Private Property _fSub() As Integer
            Get
                Return tb_fSub
            End Get
            Set(ByVal Value As Integer)
                tb_fSub = Value
            End Set
        End Property
        Private Property _mVerify() As String
            Get
                Return tb_mVerify
            End Get
            Set(ByVal Value As String)
                tb_mVerify = Value
            End Set
        End Property
        Private Property _isPrintable() As Boolean
            Get
                Return tb_isPrintable
            End Get
            Set(ByVal Value As Boolean)
                tb_isPrintable = Value
            End Set
        End Property
        Private Property _pmLock() As Boolean
            Get
                Return tb_pmLock
            End Get
            Set(ByVal Value As Boolean)
                tb_pmLock = Value
            End Set
        End Property
        Private Property _pmEmail() As Boolean
            Get
                Return tb_pmEmail
            End Get
            Set(ByVal Value As Boolean)
                tb_pmEmail = Value
            End Set
        End Property
        Private Property _pmPopUp() As Boolean
            Get
                Return tb_pmPopUp
            End Get
            Set(ByVal Value As Boolean)
                tb_pmPopUp = Value
            End Set
        End Property
        Private Property _usePM() As Boolean
            Get
                Return tb_usePM
            End Get
            Set(ByVal Value As Boolean)
                tb_usePM = Value
            End Set
        End Property
        Private Property _edOrDel() As String
            Get
                Return tb_edOrDel
            End Get
            Set(ByVal Value As String)
                tb_edOrDel = Value
            End Set
        End Property
        Private Property _eu1() As Boolean
            Get
                Return tb_eu1
            End Get
            Set(ByVal Value As Boolean)
                tb_eu1 = Value
            End Set
        End Property
        Private Property _eu2() As Boolean
            Get
                Return tb_eu2
            End Get
            Set(ByVal Value As Boolean)
                tb_eu2 = Value
            End Set
        End Property
        Private Property _eu3() As Boolean
            Get
                Return tb_eu3
            End Get
            Set(ByVal Value As Boolean)
                tb_eu3 = Value
            End Set
        End Property
        Private Property _eu4() As Boolean
            Get
                Return tb_eu4
            End Get
            Set(ByVal Value As Boolean)
                tb_eu4 = Value
            End Set
        End Property
        Private Property _eu5() As Boolean
            Get
                Return tb_eu5
            End Get
            Set(ByVal Value As Boolean)
                tb_eu5 = Value
            End Set
        End Property
        Private Property _eu6() As Boolean
            Get
                Return tb_eu6
            End Get
            Set(ByVal Value As Boolean)
                tb_eu6 = Value
            End Set
        End Property
        Private Property _eu7() As Boolean
            Get
                Return tb_eu7
            End Get
            Set(ByVal Value As Boolean)
                tb_eu7 = Value
            End Set
        End Property
        Private Property _eu8() As Boolean
            Get
                Return tb_eu8
            End Get
            Set(ByVal Value As Boolean)
                tb_eu8 = Value
            End Set
        End Property
        Private Property _eu9() As Boolean
            Get
                Return tb_eu9
            End Get
            Set(ByVal Value As Boolean)
                tb_eu9 = Value
            End Set
        End Property
        Private Property _eu10() As Boolean
            Get
                Return tb_eu10
            End Get
            Set(ByVal Value As Boolean)
                tb_eu10 = Value
            End Set
        End Property
        Private Property _eu11() As Integer
            Get
                Return tb_eu11
            End Get
            Set(ByVal Value As Integer)
                tb_eu11 = Value
            End Set
        End Property
        Private Property _eu12() As Boolean
            Get
                Return tb_eu12
            End Get
            Set(ByVal Value As Boolean)
                tb_eu12 = Value
            End Set
        End Property
        Private Property _eu13() As Boolean
            Get
                Return tb_eu13
            End Get
            Set(ByVal Value As Boolean)
                tb_eu13 = Value
            End Set
        End Property
        Private Property _eu14() As Boolean
            Get
                Return tb_eu14
            End Get
            Set(ByVal Value As Boolean)
                tb_eu14 = Value
            End Set
        End Property
        Private Property _eu15() As Boolean
            Get
                Return tb_eu15
            End Get
            Set(ByVal Value As Boolean)
                tb_eu15 = Value
            End Set
        End Property
        Private Property _eu16() As String
            Get
                Return tb_eu16
            End Get
            Set(ByVal Value As String)
                tb_eu16 = Value
            End Set
        End Property
        Private Property _eu17() As Boolean
            Get
                Return tb_eu17
            End Get
            Set(ByVal Value As Boolean)
                tb_eu17 = Value
            End Set
        End Property
        Private Property _eu18() As Boolean
            Get
                Return tb_eu18
            End Get
            Set(ByVal Value As Boolean)
                tb_eu18 = Value
            End Set
        End Property
        Private Property _eu19() As Boolean
            Get
                Return tb_eu19
            End Get
            Set(ByVal Value As Boolean)
                tb_eu19 = Value
            End Set
        End Property
        Private Property _eu20() As Boolean
            Get
                Return tb_eu20
            End Get
            Set(ByVal Value As Boolean)
                tb_eu20 = Value
            End Set
        End Property
        Private Property _eu21() As Boolean
            Get
                Return tb_eu21
            End Get
            Set(ByVal Value As Boolean)
                tb_eu21 = Value
            End Set
        End Property
        Private Property _eu22() As Boolean
            Get
                Return tb_eu22
            End Get
            Set(ByVal Value As Boolean)
                tb_eu22 = Value
            End Set
        End Property
        Private Property _eu23() As Boolean
            Get
                Return tb_eu23
            End Get
            Set(ByVal Value As Boolean)
                tb_eu23 = Value
            End Set
        End Property
        Private Property _eu24() As Boolean
            Get
                Return tb_eu24
            End Get
            Set(ByVal Value As Boolean)
                tb_eu24 = Value
            End Set
        End Property
        Private Property _eu25() As String
            Get
                Return tb_eu25
            End Get
            Set(ByVal Value As String)
                tb_eu25 = Value
            End Set
        End Property
        Private Property _eu26() As String
            Get
                Return tb_eu26
            End Get
            Set(ByVal Value As String)
                tb_eu26 = Value
            End Set
        End Property
        Private Property _eu27() As Integer
            Get
                Return tb_eu27
            End Get
            Set(ByVal Value As Integer)
                tb_eu27 = Value
            End Set
        End Property
        Private Property _eu28() As Boolean
            Get
                Return tb_eu28
            End Get
            Set(ByVal Value As Boolean)
                tb_eu28 = Value
            End Set
        End Property
        Private Property _eu29() As Integer
            Get
                Return tb_eu29
            End Get
            Set(ByVal Value As Integer)
                tb_eu29 = Value
            End Set
        End Property
        Private Property _eu30() As Boolean
            Get
                Return tb_eu30
            End Get
            Set(ByVal Value As Boolean)
                tb_eu30 = Value
            End Set
        End Property
        Private Property _eu31() As Integer
            Get
                Return tb_eu31
            End Get
            Set(ByVal Value As Integer)
                tb_eu31 = Value
            End Set
        End Property
        Private Property _eu32() As String
            Get
                Return tb_eu32
            End Get
            Set(ByVal Value As String)
                tb_eu32 = Value
            End Set
        End Property
        Private Property _eu33() As String
            Get
                Return tb_eu33
            End Get
            Set(ByVal Value As String)
                tb_eu33 = Value
            End Set
        End Property
        Private Property _eu34() As String
            Get
                Return tb_eu34
            End Get
            Set(ByVal Value As String)
                tb_eu34 = Value
            End Set
        End Property
        Private Property _eu35() As Boolean
            Get
                Return tb_eu35
            End Get
            Set(ByVal Value As Boolean)
                tb_eu35 = Value
            End Set
        End Property
        Private Property _eu36() As Boolean
            Get
                Return tb_eu36
            End Get
            Set(ByVal Value As Boolean)
                tb_eu36 = Value
            End Set
        End Property

        Private Property _uAvatar() As String
            Get
                Return tb_uAvatar
            End Get
            Set(ByVal Value As String)
                tb_uAvatar = Value
            End Set
        End Property
        Private Property _yPager() As String
            Get
                Return tb_yPager
            End Get
            Set(ByVal Value As String)
                tb_yPager = Value
            End Set
        End Property
        Private Property _msnName() As String
            Get
                Return tb_msnName
            End Get
            Set(ByVal Value As String)
                tb_msnName = Value
            End Set
        End Property
        Private Property _uLocation() As String
            Get
                Return tb_uLocation
            End Get
            Set(ByVal Value As String)
                tb_uLocation = Value
            End Set
        End Property
        Private Property _uOccupation() As String
            Get
                Return tb_uOccupation
            End Get
            Set(ByVal Value As String)
                tb_uOccupation = Value
            End Set
        End Property
        Private Property _uInterests() As String
            Get
                Return tb_uInterests
            End Get
            Set(ByVal Value As String)
                tb_uInterests = Value
            End Set
        End Property

        Private Property _maxReturn() As Integer
            Get
                Return tb_maxReturn
            End Get
            Set(ByVal Value As Integer)
                tb_maxReturn = Value
            End Set
        End Property
        Private Property _maxDays() As Integer
            Get
                Return tb_maxDays
            End Get
            Set(ByVal Value As Integer)
                tb_maxDays = Value
            End Set
        End Property
        Private Property _searchWords() As String
            Get
                Return tb_searchWords
            End Get
            Set(ByVal Value As String)
                tb_searchWords = Value
            End Set
        End Property
        Private Property _searchAs() As Integer
            Get
                Return tb_searchAs
            End Get
            Set(ByVal Value As Integer)
                tb_searchAs = Value
            End Set
        End Property
        Private Property _userID() As Integer
            Get
                Return tb_userID
            End Get
            Set(ByVal Value As Integer)
                tb_userID = Value
            End Set
        End Property
        Private Property _wizardID() As Integer
            Get
                Return tb_wizardID
            End Get
            Set(ByVal Value As Integer)
                tb_wizardID = Value
            End Set
        End Property
        Private Property _flashURL() As String
            Get
                Return tb_flashURL
            End Get
            Set(ByVal Value As String)
                tb_flashURL = Value
            End Set
        End Property
        Private Property _flashHeight() As String
            Get
                Return tb_flashHeight
            End Get
            Set(ByVal Value As String)
                tb_flashHeight = Value
            End Set
        End Property
        Private Property _flashWidth() As String
            Get
                Return tb_flashWidth
            End Get
            Set(ByVal Value As String)
                tb_flashWidth = Value
            End Set
        End Property
        Private Property _flashVersion() As String
            Get
                Return tb_flashVersion
            End Get
            Set(ByVal Value As String)
                tb_flashVersion = Value
            End Set
        End Property
        Public Property _createNew() As Boolean
            Get
                Return tb_createNew
            End Get
            Set(ByVal Value As Boolean)
                tb_createNew = Value
            End Set
        End Property
        Private Property _passCoppa() As Boolean
            Get
                Return tb_passCoppa
            End Get
            Set(ByVal Value As Boolean)
                tb_passCoppa = Value
            End Set
        End Property
        Private Property _isCoppa() As Boolean
            Get
                Return tb_isCoppa
            End Get
            Set(ByVal Value As Boolean)
                tb_isCoppa = Value
            End Set
        End Property
        Private Property _panelID() As Integer
            Get
                Return tb_panelID
            End Get
            Set(ByVal Value As Integer)
                tb_panelID = Value
            End Set
        End Property

        Private Property _realname() As String
            Get
                Return tb_realName
            End Get
            Set(ByVal Value As String)
                tb_realName = Value
            End Set
        End Property
        Private Property _showEmail() As Integer
            Get
                Return tb_showEmail
            End Get
            Set(ByVal Value As Integer)
                tb_showEmail = Value
            End Set
        End Property
        Private Property _homePage() As String
            Get
                Return tb_homePage
            End Get
            Set(ByVal Value As String)
                tb_homePage = Value
            End Set
        End Property
        Private Property _aimName() As String
            Get
                Return tb_aimName
            End Get
            Set(ByVal Value As String)
                tb_aimName = Value
            End Set
        End Property
        Private Property _icqNumber() As Integer
            Get
                Return tb_icqNumber
            End Get
            Set(ByVal Value As Integer)
                tb_icqNumber = Value
            End Set
        End Property
        Private Property _timeOffset() As Double
            Get
                Return tb_timeOffset
            End Get
            Set(ByVal Value As Double)
                tb_timeOffset = Value
            End Set
        End Property
        Private Property _editSignature() As String
            Get
                Return tb_editSignature
            End Get
            Set(ByVal Value As String)
                tb_editSignature = Value
            End Set
        End Property
        Private Property _processForm() As Boolean
            Get
                Return tb_processForm
            End Get
            Set(ByVal Value As Boolean)
                tb_processForm = Value
            End Set
        End Property
        Private Property _formSticky() As Boolean
            Get
                Return tb_formSticky
            End Get
            Set(ByVal Value As Boolean)
                tb_formSticky = Value
            End Set
        End Property
        Private Property _formLock() As Boolean
            Get
                Return tb_formLock
            End Get
            Set(ByVal Value As Boolean)
                tb_formLock = Value
            End Set
        End Property
        Private Property _formSubj() As String
            Get
                Return tb_formSubj
            End Get
            Set(ByVal Value As String)
                tb_formSubj = Value
            End Set
        End Property
        Private Property _formBody() As String
            Get
                Return tb_formBody
            End Get
            Set(ByVal Value As String)
                tb_formBody = Value
            End Set
        End Property
        Private Property _postIcon() As String
            Get
                Return tb_postIcon
            End Get
            Set(ByVal Value As String)
                tb_postIcon = Value
            End Set
        End Property
        Private Property _formPreview() As Boolean
            Get
                Return tb_formPreview
            End Get
            Set(ByVal Value As Boolean)
                tb_formPreview = Value
            End Set
        End Property
        Private Property _formMail() As Boolean
            Get
                Return tb_formMail
            End Get
            Set(ByVal Value As Boolean)
                tb_formMail = Value
            End Set
        End Property
        Private Property _formSig() As Boolean
            Get
                Return tb_formSig
            End Get
            Set(ByVal Value As Boolean)
                tb_formSig = Value
            End Set
        End Property
        Private Property _formParent() As Boolean
            Get
                Return tb_formParent
            End Get
            Set(ByVal Value As Boolean)
                tb_formParent = Value
            End Set
        End Property
        Private Property _asModerator()
            Get
                Return tb_AsModerator
            End Get
            Set(ByVal Value)
                tb_AsModerator = Value
            End Set
        End Property
        Private Property _userEmail() As String
            Get
                Return tb_userMail
            End Get
            Set(ByVal Value As String)
                tb_userMail = Value
            End Set
        End Property
        Private Property _userPass() As String
            Get
                Return tb_userPass
            End Get
            Set(ByVal Value As String)
                tb_userPass = Value
            End Set
        End Property
        Private Property _userName() As String
            Get
                Return tb_userName
            End Get
            Set(ByVal Value As String)
                tb_userName = Value
            End Set
        End Property
        Private Property _userTitle() As String
            Get
                Return tb_userTitle
            End Get
            Set(ByVal Value As String)
                tb_userTitle = Value
            End Set
        End Property
        Private Property _userIP() As String
            Get
                Return tb_userIP
            End Get
            Set(ByVal Value As String)
                tb_userIP = Value
            End Set
        End Property
        Private Property _perPage() As Integer
            Get
                Return tb_perPage
            End Get
            Set(ByVal Value As Integer)
                tb_perPage = Value
            End Set
        End Property
        Private Property _currentPage() As Integer
            Get
                Return tb_currentPage
            End Get
            Set(ByVal Value As Integer)
                tb_currentPage = Value
            End Set
        End Property
        Public Property _messageID() As String
            Get
                Return tb_messageID
            End Get
            Set(ByVal Value As String)
                tb_messageID = Value
            End Set
        End Property
        Public Property _loadForm() As String
            Get
                Return tb_LoadForm
            End Get
            Set(ByVal Value As String)
                tb_LoadForm = Value
            End Set
        End Property
        Public Property _forumID() As Integer
            Get
                Return tb_forumID
            End Get
            Set(ByVal Value As Integer)
                tb_forumID = Value
            End Set
        End Property
        Public Property _categoryID() As Integer
            Get
                Return tb_categoryID
            End Get
            Set(ByVal Value As Integer)
                tb_categoryID = Value
            End Set
        End Property
        Private Property _getVal() As String
            Get
                Return tb_getVal
            End Get
            Set(ByVal Value As String)
                tb_getVal = Value
            End Set
        End Property
        Private Property _setVal() As String
            Get
                Return tb_setVal
            End Get
            Set(ByVal Value As String)
                tb_setVal = Value
            End Set
        End Property

        '******************************************************
        '****   PUBLIC FUNCTIONS/SUBS
        '******************************************************

        '-- public copyright return
        Public Function doCopy() As String
            Return printCopyright()
        End Function

        '-- processes the login form information
        Public Function doLogon() As String
            Dim uGUID As String = String.Empty
            Dim retStr As String = String.Empty
            Dim uEnc As String = forumRotate(_userPass)
            Dim cGUID As Guid
            Dim mailVerify As Boolean = False
            Dim adminBan As Boolean = False
            Dim confID As Integer = 0
            If _eu36 = True Then
                Return forumLoginForm()
                Exit Function
            End If
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If formStrLoaded = False Then
                formStrLoaded = xmlLoadStringMsg("form")
            End If
            Try
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_UserEncLogon", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@UserName", SqlDbType.VarChar, 50)
                dataParam.Value = _userName
                dataParam = dataCmd.Parameters.Add("@UserPass", SqlDbType.VarChar, 100)
                dataParam.Value = uEnc
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Direction = ParameterDirection.Output
                dataParam = dataCmd.Parameters.Add("@MailVerify", SqlDbType.Bit)
                dataParam.Direction = ParameterDirection.Output
                dataParam = dataCmd.Parameters.Add("@AdminBan", SqlDbType.Bit)
                dataParam.Direction = ParameterDirection.Output
                dataParam = dataCmd.Parameters.Add("@ConfID", SqlDbType.Int)
                dataParam.Direction = ParameterDirection.Output

                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                cGUID = dataCmd.Parameters("@UserGUID").Value
                mailVerify = dataCmd.Parameters("@MailVerify").Value
                adminBan = dataCmd.Parameters("@AdminBan").Value
                confID = dataCmd.Parameters("@ConfID").Value
                dataConn.Close()
                uGUID = XmlConvert.ToString(cGUID)
                If uGUID.ToUpper = "A2DBADD2-1833-44B6-AC48-ACCB5B6C7CAE" Or uGUID = String.Empty Then '-- Guest
                    retStr = "<div align=""center"" class=""msgSM""><b>" + getHashVal("form", "0") + "<br /><br />" + getHashVal("form", "1") + "</b></div>"
                    retStr += forumLoginForm()
                    Return retStr
                    Exit Function
                Else
                    If mailVerify = False Then
                        retStr = "<div align=""center"" class=""msgSM""><b>" + getHashVal("form", "2") + "</b><br /><br />" + getHashVal("form", "3") + "</b></div>&nbsp;"
                        If confID > 0 Then
                            retStr += "<br />" + getHashVal("form", "4") + "<br /><a href=""javascript:ResendMailNofify('" + siteRoot + "/pop.aspx','" + confID.ToString + "');"">" + getHashVal("main", "26") + "</a>" + getHashVal("form", "5") + "<br />"
                        End If
                        retStr += forumLoginForm()
                        Return retStr
                        Exit Function
                    Else
                        If adminBan = True Then
                            retStr = "<div align=""center"" class=""msgSM""><b>" + getHashVal("form", "6") + "</b><br /><br />" + getHashVal("form", "7") + "</div>&nbsp;"
                            Return retStr
                            Exit Function
                        End If
                        setUserCookie("uld", "{" + uGUID + "}")
                        Dim ReDirTo As String = RedirBounce()
                        HttpContext.Current.Response.Redirect(ReDirTo)
                        Exit Function
                    End If

                End If
            Catch ex As Exception
                logErrorMsg("doLogon<br />" + ex.StackTrace.ToString, 1)
            End Try
        End Function

        '-- forgotten login/password form
        Public Function duhForm() As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If formStrLoaded = False Then
                formStrLoaded = xmlLoadStringMsg("form")
            End If
            Dim dfTable As String = "<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""300"" class=""tblStd"">"
            dfTable += "<tr><td class=""msgTopicHead"" align=""center"" colspan=""2"">" + getHashVal("form", "8") + "</td></tr>"
            dfTable += "<tr><td class=""msgTopic"" align=""center"" colspan=""2"">" + getHashVal("form", "9") + "<br />" + getHashVal("form", "10") + "</td></tr>"
            Dim errStr As String = String.Empty
            Dim mailSent As Boolean = False
            dfTable += "<form action=" + Chr(34) + siteRoot + "/lf.aspx"" method=""post"">"
            If _forumID > 0 Then
                dfTable += "<input type=""hidden"" name=""f"" value=" + Chr(34) + _forumID.ToString + Chr(34) + " />"
            End If
            If _messageID > 0 Then
                dfTable += "<input type=""hidden"" name=""m"" value=" + Chr(34) + _messageID.ToString + Chr(34) + " />"
            End If
            If _userEmail.Trim <> String.Empty Then
                If InStr(_userEmail, "@", CompareMethod.Binary) > 0 Then
                    If InStr(InStr(_userEmail, "@", CompareMethod.Binary), _userEmail, ".", CompareMethod.Binary) > 0 Then
                        If _userEmail.Length > 64 Then
                            _userEmail = Left(_userEmail, 64)
                        End If
                        Dim uNa As String = String.Empty
                        Dim uPw As String = String.Empty
                        dataConn = New SqlConnection(connStr)
                        dataCmd = New SqlCommand("TB_LookupLogin", dataConn)
                        dataCmd.CommandType = CommandType.StoredProcedure
                        dataParam = dataCmd.Parameters.Add("@EmailAddr", SqlDbType.VarChar, 64)
                        dataParam.Value = _userEmail
                        dataParam = dataCmd.Parameters.Add("@UserName", SqlDbType.VarChar, 50)
                        dataParam.Direction = ParameterDirection.Output
                        dataParam = dataCmd.Parameters.Add("@UserPassword", SqlDbType.VarChar, 50)
                        dataParam.Direction = ParameterDirection.Output
                        dataConn.Open()
                        dataCmd.ExecuteNonQuery()
                        uNa = dataCmd.Parameters("@UserName").Value
                        uPw = dataCmd.Parameters("@UserPassword").Value
                        dataConn.Close()
                        If uNa.ToString.Trim <> String.Empty And uPw.ToString.Trim <> String.Empty Then
                            uPw = forumRotate(uPw)
                            mailSent = True
                            Dim SMTPMailer As New MailMessage()
                            Dim mailHead As String = "<html><head><title>" + getHashVal("form", "11") + "</title></head><body><table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%""><tr><td><font face=""Tahoma, Verdana, Helvetica, Sans-Serif"" size=""2"">"
                            Dim mailFoot As String = "</font></td></tr></table></body></html>"
                            Dim mailMsg As String = String.Empty
                            Dim mailSubj As String = getHashVal("form", "11")
                            Dim mailCopy As String = "<br>&nbsp;<hr size=""1"" color=""#000000"" noshade>"
                            mailCopy += "<font size=""1""><a href=""http://www.dotnetbb.com"" target=""_blank"">dotNetBB</a> &copy;2002, <a href=""mailto:Andrew@dotNetBB.com"">Andrew Putnam</a></font>"
                            mailMsg += getHashVal("form", "12") + boardTitle.ToString + getHashVal("form", "13") + siteURL + ".<br /><br />" + getHashVal("form", "14") + "<br />"
                            mailMsg += "&nbsp;&nbsp;&nbsp;" + getHashVal("form", "15") + uNa + "<br />"
                            mailMsg += "&nbsp;&nbsp;&nbsp;" + getHashVal("form", "16") + uPw + "<br /><br />"
                            SMTPMailer.From = siteAdmin + "<" + siteAdminMail + ">"
                            SMTPMailer.To = _userEmail
                            SMTPMailer.Subject = mailSubj
                            SMTPMailer.BodyFormat = MailFormat.Html
                            SMTPMailer.Body = mailHead + mailMsg + mailCopy + mailFoot
                            SmtpMail.Send(SMTPMailer)
                            Server.ClearError()
                        Else
                            mailSent = False
                            errStr = getHashVal("form", "17")
                        End If
                    Else
                        mailSent = False
                        errStr = getHashVal("form", "18")
                    End If
                Else
                    mailSent = False
                    errStr = getHashVal("form", "18")
                End If
                mailSent = False
            End If


            If errStr <> String.Empty Then    '-- has error
                dfTable += "<tr><td class=""msgSm"" align=""center"" colspan=""2""><b>" + errStr + "</b></td></tr>"
            End If
            dfTable += "<tr><td class=""msgTopic"" align=""right"" width=""100"">" + getHashVal("form", "19") + "</td>"
            dfTable += "<td class=""msgTopic"" width=""150""><input type=""text"" name=""email"" size=""30"" class=""msgFormInput"" maxlength=""64"" value=" + Chr(34) + _userEmail + Chr(34) + " /></td></tr>"
            dfTable += "<tr><td class=""msgTopic"" align=""center"" colspan=""2""><input type=""submit"" class=""msgSmButton"" value=" + getHashVal("main", "59") + "></td>"
            If _userEmail <> String.Empty And errStr = String.Empty Then
                dfTable = "<table border=""0"" cellpadding=""3"" cellspacing=""0"">"
                dfTable += "<tr><td class=""msgSm"" align=""center"">" + getHashVal("form", "20") + "</td></tr>"
            End If


            dfTable += "</form></table>"
            dfTable += printCopyright()
            Return dfTable
        End Function

        '-- updates/creates the user profile
        Public Function doProfile(ByVal uGUID As String) As String
            Dim errStr As String = String.Empty
            Dim hSignature As String = String.Empty
            Dim mGUID As String = String.Empty
            Dim pGUID As String = String.Empty
            Dim uEnc As String = uGUID
            Dim dpTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" class=""tblStd"" height=""300"">")

            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If formStrLoaded = False Then
                formStrLoaded = xmlLoadStringMsg("form")
            End If
            Try
                If _editSignature <> String.Empty And _eu23 = True Then
                    hSignature = forumNoHTMLFix(_editSignature)
                    If _eu24 = True Then
                        hSignature = forumTBTagToHTML(hSignature, uGUID)
                    End If
                Else
                    _editSignature = String.Empty
                End If

                If _uInterests <> String.Empty Then
                    _uInterests = forumNoHTMLFix(_uInterests)
                End If
                If _homePage.ToString.Trim <> String.Empty Then
                    If Left(_homePage.ToString.ToLower, 7) <> "http://" Then
                        _homePage = "http://" + _homePage.ToString
                    End If
                End If

                '-- guest user, modify profile error
                If uGUID.ToLower = GUEST_GUID.ToLower And _createNew = False Then
                    dpTable.Append("<tr><td class=""msgSm"" valign=""top"" align=""center"" height=""20""><br />" + getHashVal("form", "21") + "</td></tr>")
                    dpTable.Append("<tr><td class=""msgSm"" valign=""top"" align=""center""><br />")
                    dpTable.Append(forumLoginForm())
                    dpTable.Append("</td></tr>")
                    dpTable.Append("</table>")
                    '-- non-guest, create new error
                ElseIf uGUID.ToLower <> GUEST_GUID.ToLower And _createNew = True Then
                    dpTable.Append("<tr><td class=""msgSm"" valign=""top"" align=""center"" height=""20""><br />" + getHashVal("form", "22") + "<br /><a href=" + Chr(34) + siteRoot + "/cp.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">" + getHashVal("main", "26") + "</a>" + getHashVal("form", "23") + "</td></tr>")
                    dpTable.Append("</table>")
                    dpTable.Append(printCopyright())
                    '-- guest user, create new profile
                ElseIf uGUID.ToLower = GUEST_GUID.ToLower And _createNew = True Then
                    If _realname.ToString.Trim <> String.Empty Then
                        If _userName.ToString.Trim <> String.Empty Then
                            If _userEmail.ToString.Trim <> String.Empty Then
                                If InStr(_userEmail, "@", CompareMethod.Binary) > 0 Then
                                    Dim userExist As Boolean = False
                                    dataConn = New SqlConnection(connStr)
                                    dataCmd = New SqlCommand("TB_CheckUserExist", dataConn)
                                    dataCmd.CommandType = CommandType.StoredProcedure
                                    dataParam = dataCmd.Parameters.Add("@UserName", SqlDbType.VarChar, 50)
                                    dataParam.Value = _userName.ToString.Trim
                                    dataParam = dataCmd.Parameters.Add("@UserExist", SqlDbType.Bit)
                                    dataParam.Direction = ParameterDirection.Output
                                    dataConn.Open()
                                    dataCmd.ExecuteNonQuery()
                                    userExist = dataCmd.Parameters("@UserExist").Value
                                    dataConn.Close()

                                    If userExist = False Then

                                        '-- check for email on ban list
                                        Dim bannedmail As Boolean = False
                                        dataConn = New SqlConnection(connStr)
                                        dataCmd = New SqlCommand("TB_CheckEmailBan", dataConn)
                                        dataCmd.CommandType = CommandType.StoredProcedure
                                        dataParam = dataCmd.Parameters.Add("@EmailAddress", SqlDbType.VarChar, 64)
                                        dataParam.Value = _userEmail
                                        dataParam = dataCmd.Parameters.Add("@IsBanned", SqlDbType.Bit)
                                        dataParam.Direction = ParameterDirection.Output
                                        dataConn.Open()
                                        dataCmd.ExecuteNonQuery()
                                        bannedmail = dataCmd.Parameters("@IsBanned").Value
                                        dataConn.Close()
                                        If bannedmail = False Then
                                            uEnc = forumRotate(_userPass)
                                            dataCmd = New SqlCommand("TB_AddNewProfile2", dataConn)
                                            dataCmd.CommandType = CommandType.StoredProcedure
                                            dataParam = dataCmd.Parameters.Add("@RealName", SqlDbType.VarChar, 100)
                                            dataParam.Value = _realname
                                            dataParam = dataCmd.Parameters.Add("@UserName", SqlDbType.VarChar, 50)
                                            dataParam.Value = _userName
                                            dataParam = dataCmd.Parameters.Add("@euPassword", SqlDbType.VarChar, 100)
                                            dataParam.Value = uEnc
                                            dataParam = dataCmd.Parameters.Add("@EmailAddress", SqlDbType.VarChar, 64)
                                            dataParam.Value = _userEmail
                                            dataParam = dataCmd.Parameters.Add("@ShowAddress", SqlDbType.Int)
                                            dataParam.Value = _showEmail
                                            dataParam = dataCmd.Parameters.Add("@Homepage", SqlDbType.VarChar, 200)
                                            dataParam.Value = _homePage
                                            dataParam = dataCmd.Parameters.Add("@AIMName", SqlDbType.VarChar, 100)
                                            dataParam.Value = _aimName
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
                                            dataParam = dataCmd.Parameters.Add("@ICQNumber", SqlDbType.Int)
                                            dataParam.Value = _icqNumber
                                            dataParam = dataCmd.Parameters.Add("@TimeOffset", SqlDbType.Int)
                                            dataParam.Value = _timeOffset
                                            dataParam = dataCmd.Parameters.Add("@EditSignature", SqlDbType.Text)
                                            dataParam.Value = _editSignature
                                            dataParam = dataCmd.Parameters.Add("@UserTheme", SqlDbType.VarChar, 50)
                                            dataParam.Value = defaultStyle
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
                                            dataParam = dataCmd.Parameters.Add("@MailVerify", SqlDbType.Bit)
                                            If _eu12 = True Then
                                                dataParam.Value = False
                                            Else
                                                dataParam.Value = True
                                            End If
                                            dataParam = dataCmd.Parameters.Add("@NTAuth", SqlDbType.Bit)
                                            dataParam.Value = _eu36
                                            dataParam = dataCmd.Parameters.Add("@CID", SqlDbType.UniqueIdentifier)
                                            dataParam.Direction = ParameterDirection.Output
                                            dataParam = dataCmd.Parameters.Add("@NID", SqlDbType.UniqueIdentifier)
                                            dataParam.Direction = ParameterDirection.Output
                                            dataConn.Open()
                                            dataCmd.ExecuteNonQuery()
                                            mGUID = XmlConvert.ToString(dataCmd.Parameters("@CID").Value)
                                            pGUID = XmlConvert.ToString(dataCmd.Parameters("@NID").Value)
                                            dataConn.Close()

                                            If _eu12 = True Then
                                                Call sendMailConfirm(mGUID, _userName, _userEmail)
                                                dpTable.Append("<tr><td class=""msgSm"" align=""center"" valign=""top""><br /><b>" + getHashVal("form", "24") + "</b><br />")
                                                dpTable.Append(getHashVal("form", "25") + "<br />" + getHashVal("form", "26") + "<br />" + getHashVal("form", "27") + "<br />&nbsp;")

                                            Else
                                                dpTable.Append("<tr><td class=""msgSm"" align=""center"" valign=""top""><br /><b>" + getHashVal("form", "24") + "</b><br />" + getHashVal("form", "28") + "<br />&nbsp;")
                                            End If

                                            dpTable.Append(forumLoginForm())
                                            dpTable.Append("</td></tr>")
                                        Else
                                            errStr = "<tr><td class=""msgSm"" align=""center"" valign=""top""><b>" + getHashVal("form", "29") + "</b></td></tr>"
                                        End If

                                    Else
                                        errStr = "<tr><td class=""msgSm"" align=""center"" valign=""top""><b>" + getHashVal("form", "30") + "</b></td></tr>"
                                    End If
                                Else
                                    errStr = "<tr><td class=""msgSm"" align=""center"" valign=""top""><b>" + getHashVal("form", "31") + "</b></td></tr>"
                                End If
                            Else
                                errStr = "<tr><td class=""msgSm"" align=""center"" valign=""top""><b>" + getHashVal("form", "31") + "</b></td></tr>"
                            End If
                        Else
                            errStr = "<tr><td class=""msgSm"" align=""center"" valign=""top""><b>" + getHashVal("form", "32") + "</b></td></tr>"
                        End If
                    Else
                        errStr = "<tr><td class=""msgSm"" align=""center"" valign=""top""><b>" + getHashVal("form", "33") + "</b></td></tr>"
                    End If
                    If errStr <> String.Empty Then
                        dpTable.Append(errStr + "<tr><td align=""center"">")
                        dpTable.Append(profileForm(uGUID))
                        dpTable.Append("</td></tr>")
                    End If
                    dpTable.Append("</table>")
                    '-- non-guest... modify profile
                ElseIf uGUID.ToLower <> GUEST_GUID.ToLower And _createNew = False Then
                    If _realname.ToString.Trim <> String.Empty Then
                        If _userName.ToString.Trim <> String.Empty Then
                            If _userEmail.ToString.Trim <> String.Empty Then
                                If InStr(_userEmail, "@", CompareMethod.Binary) > 0 Then
                                    uEnc = _userPass
                                    uEnc = forumRotate(uEnc)
                                    dataConn = New SqlConnection(connStr)
                                    dataCmd = New SqlCommand("TB_CheckUserExist", dataConn)
                                    dataCmd.CommandType = CommandType.StoredProcedure
                                    dataParam = dataCmd.Parameters.Add("@UserName", SqlDbType.VarChar, 50)
                                    dataParam.Value = _userName.ToString.Trim

                                    dataCmd = New SqlCommand("TB_UpdateProfile2", dataConn)
                                    dataCmd.CommandType = CommandType.StoredProcedure
                                    dataParam = dataCmd.Parameters.Add("@RealName", SqlDbType.VarChar, 100)
                                    dataParam.Value = _realname
                                    dataParam = dataCmd.Parameters.Add("@euPassword", SqlDbType.VarChar, 100)
                                    dataParam.Value = uEnc
                                    dataParam = dataCmd.Parameters.Add("@EmailAddress", SqlDbType.VarChar, 64)
                                    dataParam.Value = _userEmail
                                    dataParam = dataCmd.Parameters.Add("@ShowAddress", SqlDbType.Int)
                                    dataParam.Value = _showEmail
                                    dataParam = dataCmd.Parameters.Add("@Homepage", SqlDbType.VarChar, 200)
                                    dataParam.Value = _homePage
                                    dataParam = dataCmd.Parameters.Add("@AIMName", SqlDbType.VarChar, 100)
                                    dataParam.Value = _aimName
                                    dataParam = dataCmd.Parameters.Add("@ICQNumber", SqlDbType.Int)
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
                                    dataParam = dataCmd.Parameters.Add("@TimeOffset", SqlDbType.Int)
                                    dataParam.Value = _timeOffset
                                    dataParam = dataCmd.Parameters.Add("@UserTheme", SqlDbType.VarChar, 50)
                                    dataParam.Value = defaultStyle
                                    dataParam = dataCmd.Parameters.Add("@EditSignature", SqlDbType.Text)
                                    dataParam.Value = _editSignature
                                    dataParam = dataCmd.Parameters.Add("@Signature", SqlDbType.Text)
                                    dataParam.Value = hSignature
                                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                                    dataParam = dataCmd.Parameters.Add("@Avatar", SqlDbType.VarChar, 200)
                                    dataParam.Value = _uAvatar
                                    dataParam = dataCmd.Parameters.Add("@UsePM", SqlDbType.Bit)
                                    dataParam.Value = _usePM
                                    dataParam = dataCmd.Parameters.Add("@PMPopUp", SqlDbType.Bit)
                                    dataParam.Value = _pmPopUp
                                    dataParam = dataCmd.Parameters.Add("@PMEmail", SqlDbType.Bit)
                                    dataParam.Value = _pmEmail
                                    dataConn.Open()
                                    dataCmd.ExecuteNonQuery()
                                    dataConn.Close()
                                    dpTable.Append("<tr><td class=""msgSm"" align=""center"" valign=""top""><br /><b>" + getHashVal("form", "35") + "</b><br /><a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">" + getHashVal("main", "26") + "</a>" + getHashVal("main", "54") + "<br />&nbsp;")
                                    dpTable.Append("</td></tr>")
                                Else
                                    errStr = "<tr><td class=""msgSm"" align=""center"" valign=""top""><b>" + getHashVal("form", "31") + "</b></td></tr>"
                                End If
                            Else
                                errStr = "<tr><td class=""msgSm"" align=""center"" valign=""top""><b>" + getHashVal("form", "31") + "</b></td></tr>"
                            End If
                        Else
                            errStr = "<tr><td class=""msgSm"" align=""center"" valign=""top""><b>" + getHashVal("form", "32") + "</b></td></tr>"
                        End If
                    Else
                        errStr = "<tr><td class=""msgSm"" align=""center"" valign=""top""><b>" + getHashVal("form", "33") + "</b></td></tr>"
                    End If
                    If errStr <> String.Empty Then
                        dpTable.Append(errStr + "<tr><td align=""center"" valign=""top"">")
                        dpTable.Append(profileForm(uGUID))
                        dpTable.Append("</td></tr>")
                    End If
                    dpTable.Append("</table>")
                    dpTable.Append(printCopyright())
                End If

            Catch ex As Exception
                logErrorMsg("doProfile<br />" + ex.StackTrace.ToString, 1)
            End Try
            Return dpTable.ToString
        End Function

        '-- prints the available emoticons
        Public Function emoticonList() As String
            '-- emoticon replacements
            If formStrLoaded = False Then
                formStrLoaded = xmlLoadStringMsg("form")
            End If
            Dim wTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""350"" class=""tblStd"">")
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ActiveEmoticon", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            wTable.Append("<tr><td class=""msgFormHead"" align=""center"">" + getHashVal("form", "35") + "</td>")
            wTable.Append("<td class=""msgFormHead"" align=""center"">" + getHashVal("form", "36") + "</td></tr>")
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                        wTable.Append("<tr><td class=""msgSm"" align=""center"">")
                        wTable.Append(dataRdr.Item(1))
                        wTable.Append("</td><td class=""msgSm"" align=""center"">")
                        wTable.Append("<img src=" + Chr(34) + siteRoot + "/emoticons/" + dataRdr.Item(0) + Chr(34) + " border=""0"" ")
                        wTable.Append(" alt=" + Chr(34) + dataRdr.Item(1) + Chr(34))
                        wTable.Append("</td></tr>")
                    End If
                End While
                dataRdr.Close()
                dataConn.Close()
            End If
            wTable.Append("</table>")
            Return wTable.ToString
        End Function

        '-- returns a form used for new, reply or edit posting
        Public Function forumForm(ByVal uGUID As String) As String
            Dim eSubject As String = String.Empty
            Dim eBody As String = String.Empty
            Dim eIsParent As Boolean = False
            Dim ePostIcon As String = _postIcon
            Dim quoteName As String = String.Empty
            Dim parentID As Integer = 0
            Dim isModerator As Boolean = False

            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If formStrLoaded = False Then
                formStrLoaded = xmlLoadStringMsg("form")
            End If

            If _loadForm = "em" Then
                _loadForm = "e"
                isModerator = True
            End If
            If _loadForm = "dm" Then
                _loadForm = "d"
                isModerator = True
            End If
            If _loadForm = "ddm" Then
                _loadForm = "dd"
                isModerator = True
            End If
            If isModerator = False Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_GetCanModerate", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataParam = dataCmd.Parameters.Add("@CanModerate", SqlDbType.Bit)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                isModerator = dataCmd.Parameters("@CanModerate").Value
                dataConn.Close()
            End If

            Dim ntTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
            uGUID = checkValidGUID(uGUID)
            If checkForumActive() = False Then  '-- check if disabled  : new in v2.1
                ntTable.Append("<tr><td class=""msgTopic"" align=""center"" height=""400"" valign=""top""><br /><b>" + getHashVal("main", "162") + "</b><br /><br />")
                ntTable.Append("</td></tr>")

            ElseIf checkForumAccess(uGUID, _forumID) = False Then
                ntTable.Append("<tr><td class=""msgTopic"" align=""center"" height=""400"" valign=""top""><br /><b>" + getHashVal("main", "24") + "</b><br /><br />")
                If uGUID = GUEST_GUID Then
                    ntTable.Append("<a href=" + Chr(34) + siteRoot + "/l.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">")
                    ntTable.Append(getHashVal("main", "26") + "</a>" + getHashVal("main", "27"))
                End If
                ntTable.Append("</td></tr>")

            ElseIf uGUID = GUEST_GUID Then    '-- guest user, no posting as guest allowed
                ntTable.Append("<tr><td class=""msgTopic"" align=""center"" height=""400"" valign=""top""><br /><b>" + getHashVal("form", "37") + "</b><br /><br />" + getHashVal("form", "38") + "<br /><a href=")
                ntTable.Append(Chr(34) + siteRoot + "/l.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">")
                ntTable.Append(getHashVal("main", "26") + "</a>" + getHashVal("main", "27") + "<br /><br />" + getHashVal("form", "39") + "<br /><a href=")
                ntTable.Append(Chr(34) + siteRoot + "/r.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">")
                ntTable.Append(getHashVal("main", "26") + "</a>" + getHashVal("form", "40"))
                ntTable.Append("</td></tr>")
            Else
                '--- Anti-spam timer check...
                Dim lastTime As Date = DateTime.UtcNow
                '-- updated in v2.1 to use correct time value for differences
                Dim curTime As Date = lastTime
                Dim timeLapse As Integer = 0
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_GetLastPostTime", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataParam = dataCmd.Parameters.Add("@LastPostDate", SqlDbType.DateTime)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                lastTime = dataCmd.Parameters("@LastPostDate").Value
                dataConn.Close()
                If IsDate(lastTime) = True Then
                    timeLapse = DateDiff(DateInterval.Second, lastTime, curTime)
                    If timeLapse < _eu11 Then
                        ntTable.Append("<tr><td class=""msgSm"" align=""center"" valign=""top"">")
                        ntTable.Append("<br /><b>" + getHashVal("form", "41") + "</b><br />")
                        ntTable.Append(getHashVal("form", "42") + _eu11.ToString + getHashVal("form", "43") + "<br /><br />")
                        ntTable.Append("<a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">")
                        ntTable.Append(getHashVal("main", "26") + "</a>" + getHashVal("main", "54") + "<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p></td></tr></table><p>&nbsp;</p>")
                        ntTable.Append("<div align=""center""><br />" + getHashVal("form", "44") + lastTime.ToString + " GMT<br />")
                        ntTable.Append(getHashVal("form", "45") + curTime.ToString + " GMT<br /></div>")

                        ntTable.Append(printCopyright())
                        Return ntTable.ToString
                        Exit Function
                    End If
                End If

                If _loadForm.ToLower = "e" Or _loadForm.ToLower = "d" Or _loadForm.ToLower = "dd" Then
                    If _messageID > 0 Then
                        If _formBody = String.Empty Then      '-- first grab, not a preview
                            dataConn = New SqlConnection(connStr)
                            dataCmd = New SqlCommand("TB_GetForEdit", dataConn)
                            dataCmd.CommandType = CommandType.StoredProcedure
                            dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                            dataParam.Value = _messageID
                            dataParam = dataCmd.Parameters.Add("@IsModerator", SqlDbType.Bit)
                            dataParam.Value = isModerator
                            dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                            dataParam.Value = XmlConvert.ToGuid(uGUID)

                            dataConn.Open()
                            dataRdr = dataCmd.ExecuteReader
                            If dataRdr.IsClosed = False Then
                                While dataRdr.Read
                                    If dataRdr.IsDBNull(0) = False Then
                                        eSubject = dataRdr.Item(0)
                                    End If
                                    If dataRdr.IsDBNull(1) = False Then
                                        eBody = dataRdr.Item(1)
                                    End If
                                    If dataRdr.IsDBNull(2) = False Then
                                        eIsParent = dataRdr.Item(2)
                                    End If
                                    If dataRdr.IsDBNull(3) = False Then
                                        ePostIcon = dataRdr.Item(3)
                                    End If
                                    If dataRdr.IsDBNull(4) = False Then
                                        parentID = dataRdr.Item(4)
                                    End If
                                    If dataRdr.IsDBNull(5) = False Then
                                        _formLock = dataRdr.Item(5)
                                    End If
                                    If dataRdr.IsDBNull(6) = False Then
                                        _formSticky = dataRdr.Item(6)
                                    End If
                                End While
                                dataRdr.Close()
                                dataConn.Close()
                            End If
                        Else
                            eBody = _formBody
                            eSubject = _formSubj
                        End If
                    End If
                ElseIf _loadForm.ToLower = "q" And _messageID > 0 Then
                    If _formBody = String.Empty Then
                        dataConn = New SqlConnection(connStr)
                        dataCmd = New SqlCommand("TB_GetForQuote", dataConn)
                        dataCmd.CommandType = CommandType.StoredProcedure
                        dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                        dataParam.Value = _messageID
                        dataConn.Open()
                        dataRdr = dataCmd.ExecuteReader()
                        If dataRdr.IsClosed = False Then
                            While dataRdr.Read
                                If dataRdr.IsDBNull(0) = False Then
                                    quoteName = dataRdr.Item(0)
                                End If
                                If dataRdr.IsDBNull(1) = False Then
                                    eBody = dataRdr.Item(1)
                                End If
                                If dataRdr.IsDBNull(2) = False Then
                                    _messageID = dataRdr.Item(2)
                                End If
                            End While
                            If quoteName <> String.Empty Then
                                quoteName = "[quote=" + Chr(34) + quoteName.ToString + Chr(34) + "]"
                                eBody = quoteName + eBody.ToString + "[/quote]"
                            Else
                                quoteName = "[quote=""Somebody""]"
                                eBody = quoteName + eBody.ToString + "[/quote]"
                            End If
                            dataRdr.Close()
                            dataConn.Close()
                        End If
                    Else
                        eBody = _formBody
                        eSubject = _formSubj
                    End If
                    _loadForm = "r"  '-- change to reply posting
                Else    '-- _loadform != 'e'
                    eSubject = _formSubj
                    eBody = _formBody
                    eIsParent = _formParent
                    ePostIcon = _postIcon
                End If



                '-- new / reply / edit posting
                If _loadForm.ToLower = "n" Or _loadForm.ToLower = "r" Or _loadForm.ToLower = "e" Or _loadForm.ToLower = "q" Then        '-- new , reply or edit forms
                    ntTable.Append("<script src=" + Chr(34) + siteRoot + "/js/TBform.js""></script>")
                    ntTable.Append("<tr><td class=""msgFormTitle"" width=""165""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" width=""165"" height=""10""></td><td class=""msgFormTitle"" width=""100%"">")
                    Select Case _loadForm.ToLower
                        Case "n"
                            ntTable.Append(UCase(getHashVal("main", "2")))
                        Case "r", "q"
                            ntTable.Append(UCase(getHashVal("main", "1")))
                        Case "e"
                            ntTable.Append(UCase(getHashVal("main", "0")))
                    End Select
                    ntTable.Append("</td></tr>")
                    ntTable.Append("<form action=" + Chr(34) + siteRoot + "/p.aspx"" method=""post"" name=""pForm"">")
                    ntTable.Append("<input type=""hidden"" name=""r"" value=" + Chr(34) + _loadForm.ToLower + Chr(34) + " />")
                    ntTable.Append("<input type=""hidden"" name=""f"" value=" + Chr(34) + _forumID.ToString + Chr(34) + " />")
                    ntTable.Append("<input type=""hidden"" name=""am"" value=" + Chr(34) + isModerator.ToString + Chr(34) + " />")
                    If _messageID > 0 Then
                        ntTable.Append("<input type=""hidden"" name=""m"" value=" + Chr(34) + _messageID.ToString + Chr(34) + " />")
                        ntTable.Append("<input type=""hidden"" name=""p"" value=" + Chr(34) + eIsParent.ToString + Chr(34) + " />")
                    End If

                    '-- Post Icons
                    If _eu6 = True Then
                        ntTable.Append("<tr><td class=""msgFormDesc"" align=""right"">" + getHashVal("form", "46") + "</td>")
                        ntTable.Append("<td class=""msgFormBody"">")
                        Dim iNum As Integer = 0
                        Dim iStr As String = String.Empty
                        For iNum = 0 To 7
                            iStr = "icon" + iNum.ToString
                            If ePostIcon = iStr Then
                                ntTable.Append("<input type=""radio"" name=""posticon"" value=" + Chr(34) + iStr + Chr(34) + " checked> <img src=" + Chr(34) + siteRoot + "/posticons/" + iStr + ".gif"" border=""0"" height=""15"" width=""15"">")
                            Else
                                ntTable.Append("<input type=""radio"" name=""posticon"" value=" + Chr(34) + iStr + Chr(34) + "> <img src=" + Chr(34) + siteRoot + "/posticons/" + iStr + ".gif"" border=""0"" height=""15"" width=""15"">")
                            End If
                        Next
                        ntTable.Append("<br />")
                        For iNum = 8 To 14
                            iStr = "icon" + iNum.ToString
                            If ePostIcon = iStr Then
                                ntTable.Append("<input type=""radio"" name=""posticon"" value=" + Chr(34) + iStr + Chr(34) + " checked> <img src=" + Chr(34) + siteRoot + "/posticons/" + iStr + ".gif"" border=""0"" height=""15"" width=""15"">")
                            Else
                                ntTable.Append("<input type=""radio"" name=""posticon"" value=" + Chr(34) + iStr + Chr(34) + "> <img src=" + Chr(34) + siteRoot + "/posticons/" + iStr + ".gif"" border=""0"" height=""15"" width=""15"">")
                            End If
                        Next
                        If ePostIcon = String.Empty Then
                            ntTable.Append("<input type=""radio"" name=""posticon"" value=""none"" checked>" + getHashVal("form", "47"))
                        Else
                            ntTable.Append("<input type=""radio"" name=""posticon"" value=""none"">" + getHashVal("form", "47"))
                        End If
                        ntTable.Append("</td></tr>")
                    End If


                    '-- End Post Icons

                    '-- message subject
                    If _loadForm.ToLower = "n" Or (_loadForm.ToLower = "e" And eIsParent = True) Then
                        ntTable.Append("<tr><td class=""msgFormDesc"" align=""right"">" + getHashVal("form", "48") + "</td>")
                        ntTable.Append("<td class=""msgFormBody""><input type=""text"" onblur=""document.pForm.msgbody.focus();"" value=" + Chr(34) + eSubject.ToString.Trim + Chr(34) + " size=""30"" class=""msgFormInput"" name=""frmSubject"" tabindex=""1"" maxLength=""50""></td></tr>")
                    End If


                    '-- Message  Body
                    If _eu5 = True Then
                        ntTable.Append(forumFormButtons())
                        'ntTable.Append("<tr><td class=""msgFormDesc"" align=""right"" valign=""top"" width=""165""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" height=""6"" width=""10"" /><br />" + getHashVal("form", "49") + "<br /><br />" + getHashVal("form", "50") + "<br /><br /><a href=""javascript:TBTagsHelp('" + siteRoot + "/mCode.aspx');""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/help.gif"" border=""0"" alt=" + Chr(34) + getHashVal("form", "51") + Chr(34) + "> - " + getHashVal("form", "51") + "</a></td>")
                        'ntTable.Append("<td class=""msgFormBody"" valign=""bottom"">")
                        'ntTable.Append("<input type=""button"" name=""tbb0"" class=""msgSmButton"" value=""B"" accesskey=""b"" title=""Bold (Alt+B)"" style=""font-weight:bold;width:45px;height:20px;"" onclick=""TB_Baction(0);"" onmouseover=""TB_helpRoll('b',this,1)"" onmouseout=""TB_helpRoll('b',this,0)"">&nbsp;")
                        'ntTable.Append("<input type=""button"" name=""tbb2"" class=""msgSmButton"" value=""I"" accesskey=""i"" title=""Italic (Alt+I)"" style=""font-style:italic;width:45px;height:20px;"" onclick=""TB_Baction(2);"" onmouseover=""TB_helpRoll('i',this,1)"" onmouseout=""TB_helpRoll('i',this,0)"">&nbsp;")
                        'ntTable.Append("<input type=""button"" name=""tbb4"" class=""msgSmButton"" value=""U"" accesskey=""u"" title=""Underline (Alt+U)"" style=""text-decoration:underline;width:45px;height:20px;"" onclick=""TB_Baction(4);"" onmouseover=""TB_helpRoll('u',this,1)"" onmouseout=""TB_helpRoll('u',this,0)"">&nbsp;")
                        'ntTable.Append("<input type=""button"" name=""tbb6"" class=""msgSmButton"" value=""IMG"" title=""Add an image to your post"" style=""width:45px;height:20px;"" onclick=""TB_Baction(6);"" onmouseover=""TB_helpRoll('im',this,1)"" onmouseout=""TB_helpRoll('im',this,0)"">&nbsp;")
                        'ntTable.Append("<input type=""button"" name=""tbb8"" class=""msgSmButton"" value=""URL"" title=""Add a URL to your post"" style=""width:45px;height:20px;"" onclick=""TB_Baction(8);"" onmouseover=""TB_helpRoll('ur',this,1)"" onmouseout=""TB_helpRoll('ur',this,0)"">&nbsp;")
                        'ntTable.Append("<input type=""button"" name=""tbb10"" class=""msgSmButton"" value=""LIST"" title=""Add a list of things to your post"" style=""width:45px;height:20px;"" onclick=""TB_Baction(10);"" onmouseover=""TB_helpRoll('l',this,1)"" onmouseout=""TB_helpRoll('l',this,0)"">&nbsp;")
                        'ntTable.Append("<input type=""button"" name=""tbb12"" class=""msgSmButton"" value=""QUOTE"" title=""Add a quote to your post"" style=""width:45px;height:20px;"" onclick=""TB_Baction(12);"" onmouseover=""TB_helpRoll('q',this,1)"" onmouseout=""TB_helpRoll('q',this,0)"">&nbsp;")
                        'ntTable.Append("<input type=""button"" name=""tbb14"" class=""msgSmButton"" value=""CODE"" title=""Add code text to your post"" style=""width:45px;height:20px;"" onclick=""TB_Baction(14);"" onmouseover=""TB_helpRoll('c',this,1)"" onmouseout=""TB_helpRoll('c',this,0)"">&nbsp;")
                        'ntTable.Append("<input type=""button"" name=""flb"" class=""msgSmButton"" value=""FLASH"" title=""Add a flash image to your post"" style=""width:45px;height:20px;"" onclick=""TB_loadW('1','" + siteRoot + "');"" onmouseover=""TB_helpRoll('fl',this,1)"" onmouseout=""TB_helpRoll('fl',this,0)"">&nbsp;")
                        'If _eu7 = True Then
                        '    ntTable.Append("<a href=""javascript:TB_loadW('3','" + siteRoot + "');"" class=""nofade"" onmouseover=""window.status=' ';return true;""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/emoticonbutton.gif"" border=""0"" title=""Add an emoticon image to your post"" style=""position:relative;top:4px;""></a>")
                        'End If
                        'ntTable.Append("<br />")
                        'ntTable.Append("<input type=""text"" class=""msgFormHelp"" name=""helpbox"" style=""width:100%;"" value=""Use the buttons above for quick formatting and item additions.""><br />")
                        'ntTable.Append("<textarea class=""msgFormTextBox"" name=""msgbody"" rows=""35"">" + eBody.ToString.Trim + "</textarea>")
                        'ntTable.Append("</td></tr>")

                    Else
                        ntTable.Append("<tr><td class=""msgFormDesc"" align=""right"" valign=""top""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" height=""6""  width=""165"" /><br />")
                        ntTable.Append(getHashVal("form", "49") + "<br /><br />" + getHashVal("form", "52") + "<br /><br />")
                        If _eu7 = True Then
                            ntTable.Append(forumEmoticonMini())
                        End If
                        ntTable.Append("</td>")
                        ntTable.Append("<td class=""msgFormBody"" valign=""top"" width=""100%"">")

                        'ntTable.Append("<tr><td class=""msgFormDesc"" align=""right"" valign=""top"">" + getHashVal("form", "49") + "<br /><br />" + getHashVal("form", "50") + "<br />" + getHashVal("form", "52") + "</td>")
                        'ntTable.Append("<td class=""msgFormBody"" valign=""bottom"">")
                        'If _eu7 = True Then
                        '    ntTable.Append("<a href=""javascript:TB_loadW('3','" + siteRoot + "');"" onmouseover=""window.status=' ';return true;""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/emoticonbutton.gif"" border=""0"" style=""position:relative;top:4px;""></a>")
                        'End If

                    End If
                    ntTable.Append("<textarea class=""msgFormTextBox"" name=""msgbody"" tabindex=""2"" rows=""20"">" + eBody.ToString.Trim + "</textarea>")
                    ntTable.Append("</td></tr>")

                    '-- Post Options
                    ntTable.Append("<tr><td class=""msgFormDesc"" align=""right"" valign=""top""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" height=""4"" width=""165""><br />" + getHashVal("form", "53") + "</td>")
                    ntTable.Append("<td class=""msgFormBody"" valign=""top"">")
                    '------------------------------
                    '-- moderator only post options
                    If isModerator = True Then
                        If getAdminMenuAccess(26, uGUID) = True Then     '-- can lock thread
                            If _formLock = True Then
                                ntTable.Append("<input type=""checkbox"" name=""fml"" value=""1"" checked>" + getHashVal("form", "54") + "<br />")
                            Else
                                ntTable.Append("<input type=""checkbox"" value=""1"" name=""fml"">" + getHashVal("form", "54") + "<br />")
                            End If
                        End If
                        If getAdminMenuAccess(9, uGUID) = True Then     '-- can make sticky
                            If _formSticky = True Then
                                ntTable.Append("<input type=""checkbox"" value=""1"" name=""fms"" checked>" + getHashVal("form", "55") + "<br />")
                            Else
                                ntTable.Append("<input type=""checkbox"" value=""1"" name=""fms"">" + getHashVal("form", "55") + "<br />")
                            End If
                        End If
                    End If

                    If _eu8 = True Then
                        If checkForumSubscribe(uGUID) = False Then
                            If _formMail = True Then
                                ntTable.Append("<input type=""checkbox"" name=""nmail"" checked>" + getHashVal("form", "56") + "<br />")
                            Else
                                ntTable.Append("<input type=""checkbox"" name=""nmail"">" + getHashVal("form", "56") + "<br />")
                            End If
                        Else
                            ntTable.Append("<input type=""checkbox"" name=""mNull"" value=""1"" checked disabled>" + getHashVal("form", "57") + "<br />")
                            ntTable.Append("<input type=""hidden"" name=""nmail"" value="""">")
                        End If
                    Else
                        ntTable.Append("&nbsp;&nbsp;*&nbsp;&nbsp;" + getHashVal("form", "58") + "<br />")
                        ntTable.Append("<input type=""hidden"" name=""nmail"" value="""">")
                    End If

                    If _eu23 = True Then
                        If _formSig = True Then
                            ntTable.Append("<input type=""checkbox"" name=""sig"" checked>" + getHashVal("form", "59") + "<br />")
                        Else
                            ntTable.Append("<input type=""checkbox"" name=""sig"">" + getHashVal("form", "59") + "<br />")
                        End If
                    Else
                        ntTable.Append("&nbsp;&nbsp;*&nbsp;&nbsp;" + getHashVal("form", "60") + "<br />")
                    End If

                    ntTable.Append("<input type=""checkbox"" name=""preview"">" + getHashVal("form", "61") + "<br />")
                    ntTable.Append("</td></tr>")

                    '-- Post buttons
                    ntTable.Append("<tr><td class=""msgFormDesc"" align=""right"" valign=""top"">&nbsp;</td>")
                    ntTable.Append("<td class=""msgFormDesc"" valign=""top"">")
                    ntTable.Append("<input type=""button"" class=""msgButton"" value=" + Chr(34) + getHashVal("form", "63") + Chr(34) + " title=" + Chr(34) + getHashVal("form", "62") + Chr(34) + " name=""btnSubmit"" onclick=""JavaScript:postForm();"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"" accesskey=""s"">&nbsp;")
                    If parentID > 0 Then
                        ntTable.Append("<input type=""button"" class=""msgButton"" title=" + Chr(34) + getHashVal("form", "65") + Chr(34) + " value=" + Chr(34) + getHashVal("form", "64") + Chr(34) + " name=""btnCancel"" onclick=""window.location.href='" + siteRoot + "/?f=" + _forumID.ToString + "&m=" + parentID.ToString + "';"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"" accesskey=""x"">")
                    Else
                        ntTable.Append("<input type=""button"" class=""msgButton"" title=" + Chr(34) + getHashVal("form", "65") + Chr(34) + " value=" + Chr(34) + getHashVal("form", "64") + Chr(34) + " name=""btnCancel"" onclick=""window.location.href='" + siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + "';"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"" accesskey=""x"">")
                    End If

                    ntTable.Append("</td></form></tr>")
                    If _loadForm.ToLower = "r" Then
                        ntTable.Append("<tr><td colspan=""2"" class=""msgMd""><br /><b>" + getHashVal("form", "66") + "</b>")
                        ntTable.Append(forumListThread(uGUID, True))
                        ntTable.Append("</td</tr>")
                    End If
                    If _loadForm = "n" Then
                        ntTable.Append("<script language=javascript>" + vbCrLf)
                        ntTable.Append("<!--" + vbCrLf)
                        ntTable.Append("document.pForm.frmSubject.focus();" + vbCrLf)
                        ntTable.Append("-->" + vbCrLf)
                        ntTable.Append("</script>" + vbCrLf)
                    ElseIf _loadForm = "e" Or _loadForm = "r" Then
                        ntTable.Append("<script language=javascript>" + vbCrLf)
                        ntTable.Append("<!--" + vbCrLf)
                        ntTable.Append("document.pForm.msgbody.focus();" + vbCrLf)
                        ntTable.Append("-->" + vbCrLf)
                        ntTable.Append("</script>" + vbCrLf)
                    End If

                    '-- delete posting prompt
                ElseIf _loadForm.ToLower = "d" Then
                    '-- eBody will = string.empty if not correct user!
                    If eBody = String.Empty Then
                        ntTable.Append("<tr><td class=""msgSm"" align=""center"" valign=""top"" height=""300""><br />")
                        ntTable.Append(getHashVal("form", "67") + "<br /><br /><a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + Chr(34) + ">" + getHashVal("main", "26") + "</a>" + getHashVal("main", "54") + "</td></tr>")
                    Else
                        ntTable.Append("<tr><td class=""msgSm"" align=""center"" valign=""top"" height=""300""><br />")
                        ntTable.Append(getHashVal("form", "68") + "<br /><br />" + getHashVal("form", "69") + "<br /><br />")
                        If isModerator = True Then
                            ntTable.Append("<input type=""button"" class=""msgButton"" value=" + Chr(34) + getHashVal("form", "70") + Chr(34) + " name=""btnDelte"" onclick=""window.location.href='" + siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + "&r=ddm';"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"">&nbsp;")
                        Else
                            ntTable.Append("<input type=""button"" class=""msgButton"" value=" + Chr(34) + getHashVal("form", "70") + Chr(34) + " name=""btnDelte"" onclick=""window.location.href='" + siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + "&r=dd';"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"">&nbsp;")
                        End If
                        If parentID > 0 Then
                            ntTable.Append("<input type=""button"" class=""msgButton"" value=" + Chr(34) + getHashVal("form", "64") + Chr(34) + " name=""btnCancel"" onclick=""window.location.href='" + siteRoot + "/?f=" + _forumID.ToString + "&m=" + parentID.ToString + "';"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"">")
                        Else
                            ntTable.Append("<input type=""button"" class=""msgButton"" value=" + Chr(34) + getHashVal("form", "64") + Chr(34) + " name=""btnCancel"" onclick=""window.location.href='" + siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + "';"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"">")
                        End If
                        ntTable.Append("</td></tr>")
                    End If

                    '-- actually do the delete
                ElseIf _loadForm.ToLower = "dd" Then
                    If eBody = String.Empty Then
                        ntTable.Append("<tr><td class=""msgSm"" align=""center"" valign=""top"" height=""300""><br />")
                        ntTable.Append(getHashVal("form", "67") + "<br /><br /><a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + Chr(34) + ">" + getHashVal("main", "26") + "</a>" + getHashVal("main", "54") + "</td></tr>")
                    Else
                        dataConn = New SqlConnection(connStr)
                        dataCmd = New SqlCommand("TB_DeleteForumPost", dataConn)
                        dataCmd.CommandType = CommandType.StoredProcedure
                        dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                        dataParam.Value = XmlConvert.ToGuid(uGUID)
                        dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                        dataParam.Value = _messageID
                        dataConn.Open()
                        dataCmd.ExecuteNonQuery()
                        dataConn.Close()
                        logAdminAction(uGUID, "Message id " + _messageID.ToString + " deleted.")
                        ntTable.Append("<tr><td class=""msgSm"" align=""center"" valign=""top"" height=""300""><br />")
                        ntTable.Append(getHashVal("form", "72") + "<br /><br />")
                        ntTable.Append("<a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + Chr(34) + ">" + getHashVal("form", "71") + "</a>")
                        ntTable.Append("</td></tr>")
                    End If


                Else
                    ntTable.Append("<tr><td class=""msgTopic"" align=""center"" height=""350"" valign=""top""><br /><b>" + getHashVal("form", "73") + "</b><br /><br />")
                End If


            End If
            ntTable.Append("</table>")

            If _loadForm <> "r" Then
                ntTable.Append(printCopyright())
            End If

            Return ntTable.ToString
        End Function

        '-- just returns the printCopyright()
        Public Function forumIPLockInfo() As String
            Return printCopyright()
        End Function

        '-- Lists a specific forum 
        Public Function forumListForum(ByVal uGUID As String) As String
            Dim lfTable As New StringBuilder()
            Dim firstRec As Integer = 0
            Dim lastRec As Integer = 0
            Dim pageCount As Decimal = 0.0
            Dim i As Integer = 0
            Dim ipages As Integer = 0
            Dim mPages As Double = 0.0
            Dim whopost As Integer = whoCanPost()
            Dim canModerate As Boolean = False

            '-- template items
            Dim templStr As String = loadTBTemplate("style-listForum.htm", defaultStyle)
            Dim iconStr As String = String.Empty
            Dim topicStr As String = String.Empty
            Dim replyStr As String = String.Empty
            Dim viewStr As String = String.Empty
            Dim lastStr As String = String.Empty
            Dim firstStr As String = String.Empty
            Dim classStr As String = String.Empty
            Dim lastVisit As String = String.Empty
            Dim topicIcon As String = String.Empty

            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If

            If uGUID = GUEST_GUID Then
                lastVisit = DateTime.Now.ToString
            Else
                If HttpContext.Current.Session("lastVisit") = String.Empty Or IsDate(HttpContext.Current.Session("lastVisit")) = False Then
                    lastVisit = DateTime.Now.ToString
                    HttpContext.Current.Session("lastVisit") = lastVisit
                Else
                    lastVisit = HttpContext.Current.Session("lastVisit")
                End If
            End If


            Try

                uGUID = checkValidGUID(uGUID)
                lfTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
                If checkForumActive() = False Then  '-- check if disabled  : new in v2.1
                    lfTable.Append("<tr><td class=""msgTopic"" align=""center"" height=""400"" valign=""top""><br /><b>" + getHashVal("main", "162") + "</b><br /><br />")
                    lfTable.Append("</td></tr>")

                ElseIf checkForumAccess(uGUID, _forumID) = False Then
                    lfTable.Append("<tr><td class=""msgTopic"" align=""center"" height=""400"" valign=""top""><br /><b>" + getHashVal("main", "25") + "</b><br /><br />")

                    If uGUID = GUEST_GUID Then
                        lfTable.Append(getHashVal("main", "26") + "<br /><br />")
                        lfTable.Append("<a href=" + Chr(34) + siteRoot + "/l.aspx?f=" + _forumID.ToString + Chr(34) + ">")
                        lfTable.Append(getHashVal("main", "26") + "</a>" + getHashVal("main", "27"))
                    Else
                        lfTable.Append(getHashVal("main", "28") + "<br /><br />")
                    End If
                    lfTable.Append("</td></tr>")
                Else
                    If Left(templStr, 6) = "Unable" Then    '-- template missing
                        lfTable.Append("<div class=""msgFormError"">" + templStr + "</div>")
                    Else
                        '-- check if can moderate forum
                        dataConn = New SqlConnection(connStr)
                        dataCmd = New SqlCommand("TB_GetCanModerate", dataConn)
                        dataCmd.CommandType = CommandType.StoredProcedure
                        dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                        dataParam.Value = _forumID
                        dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                        dataParam.Value = XmlConvert.ToGuid(uGUID)
                        dataParam = dataCmd.Parameters.Add("@CanModerate", SqlDbType.Bit)
                        dataParam.Direction = ParameterDirection.Output
                        dataConn.Open()
                        dataCmd.ExecuteNonQuery()
                        canModerate = dataCmd.Parameters("@CanModerate").Value
                        dataConn.Close()

                        dataConn = New SqlConnection(connStr)
                        dataCmd = New SqlCommand("TB_ForumTopicCount", dataConn)
                        dataCmd.CommandType = CommandType.StoredProcedure
                        dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                        dataParam.Value = _forumID
                        dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                        dataParam.Value = XmlConvert.ToGuid(uGUID)
                        dataParam = dataCmd.Parameters.Add("@ForumCount", SqlDbType.Int)
                        dataParam.Direction = ParameterDirection.Output
                        dataConn.Open()
                        dataCmd.ExecuteNonQuery()
                        Dim tCount As Integer = dataCmd.Parameters("@ForumCount").Value
                        dataConn.Close()

                        If tCount > 0 Then
                            If tCount > 25 Then     '-- always show paging option if more than 25 records
                                firstRec = ((_currentPage - 1) * _perPage) + 1
                                lastRec = (_currentPage * _perPage)
                                pageCount = CDbl(tCount / _perPage)
                                If CInt(pageCount) < pageCount Then
                                    ipages += CInt(pageCount + 1)
                                Else
                                    ipages = CInt(pageCount)
                                End If
                                lfTable.Append("<tr><form action=" + Chr(34) + siteRoot + "/"" method=""get"" name=""cpf"">")
                                lfTable.Append("<td class=""msgHead"" align=""left"">&nbsp;</td>")
                                lfTable.Append("<td class=""msgHead"" align=""left"" colspan=""2"">")

                                '-- who can post to the forum?
                                Select Case whopost
                                    Case 1
                                        lfTable.Append("<a title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " name=""btnTopic"" href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=n" + Chr(34) + ">")
                                        lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " /></a>&nbsp;")
                                        lfTable.Append("<a title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=np" + Chr(34) + ">")
                                        lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " /></a>&nbsp;")

                                    Case 2, 3
                                        If canModerate = True Then
                                            lfTable.Append("<a title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " name=""btnTopic"" href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=n" + Chr(34) + ">")
                                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " /></a>&nbsp;")
                                            lfTable.Append("<a title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=np" + Chr(34) + ">")
                                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " /></a>&nbsp;")
                                        Else
                                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/nonewpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "159") + Chr(34) + " />&nbsp;")
                                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/nonewpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "160") + Chr(34) + " />&nbsp;")
                                        End If
                                End Select


                                lfTable.Append("<td class=""msgHead"" align=""right"" colspan=""4"">" + tCount.ToString + getHashVal("main", "29"))
                                lfTable.Append(perPageDrop(_forumID, , _currentPage, _perPage))
                                lfTable.Append(getHashVal("main", "30") + "<br />" + getHashVal("main", "31"))
                                For i = 1 To ipages
                                    If i = _currentPage Then
                                        lfTable.Append("&nbsp;<b>" + i.ToString + "</b>&nbsp;")
                                    Else
                                        lfTable.Append("&nbsp;<a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&p=" + i.ToString + "&x=" + _perPage.ToString + Chr(34) + ">")
                                        lfTable.Append(i.ToString + "</a>&nbsp;")
                                    End If
                                Next
                                lfTable.Append("</td></form></tr>")
                            Else
                                lfTable.Append("<tr>")
                                lfTable.Append("<td class=""msgHead"" align=""left"">&nbsp;</td>")
                                lfTable.Append("<td class=""msgHead"" align=""left"" colspan=""7"">")
                                '-- who can post to the forum?
                                Select Case whopost
                                    Case 1
                                        lfTable.Append("<a title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=n" + Chr(34) + ">")
                                        lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " /></a>&nbsp;")
                                        lfTable.Append("<a title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=np" + Chr(34) + ">")
                                        lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " /></a>&nbsp;")

                                    Case 2, 3
                                        If canModerate = True Then
                                            lfTable.Append("<a title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=n" + Chr(34) + ">")
                                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " /></a>&nbsp;")
                                            lfTable.Append("<a title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=np" + Chr(34) + ">")
                                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " /></a>&nbsp;")
                                        Else
                                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/nonewpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "159") + Chr(34) + " />&nbsp;")
                                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/nonewpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "160") + Chr(34) + " />&nbsp;")
                                        End If

                                End Select
                                firstRec = 1
                                lastRec = tCount
                                pageCount = 1
                            End If

                            Dim sbHead As New StringBuilder(templStr)
                            sbHead.Replace(vbCrLf, "")
                            sbHead.Replace("{IsNewIcon}", "&nbsp;")
                            sbHead.Replace("{ICON}", "&nbsp;")
                            sbHead.Replace("{TopicTitle}", getHashVal("main", "151"))
                            sbHead.Replace("{Replies}", getHashVal("main", "150"))
                            sbHead.Replace("{Views}", getHashVal("main", "152"))
                            sbHead.Replace("{LastPost}", getHashVal("main", "153"))
                            sbHead.Replace("{FirstPost}", getHashVal("main", "154"))
                            sbHead.Replace("{ClassTag}", "msgTopicHead")
                            lfTable.Append(sbHead.ToString)

                            lfTable.Append(forumStickyItems(_forumID))
                            dataConn = New SqlConnection(connStr)
                            dataCmd = New SqlCommand("TB_GetForumListPaged", dataConn)
                            dataCmd.CommandType = CommandType.StoredProcedure
                            dataCmd.Parameters.Clear()
                            dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                            dataParam.Value = _forumID
                            dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                            dataParam.Value = XmlConvert.ToGuid(uGUID)
                            dataParam = dataCmd.Parameters.Add("@FirstRec", SqlDbType.Int)
                            dataParam.Value = firstRec
                            dataParam = dataCmd.Parameters.Add("@LastRec", SqlDbType.Int)
                            dataParam.Value = lastRec
                            dataConn.Open()
                            dataRdr = dataCmd.ExecuteReader
                            i = 0
                            If dataRdr.IsClosed = False Then
                                While dataRdr.Read
                                    'i += 1
                                    'If i >= firstRec Then
                                    '    If i <= lastRec Then
                                    '-- reset values
                                    topicStr = String.Empty
                                    replyStr = String.Empty
                                    viewStr = String.Empty
                                    lastStr = String.Empty
                                    firstStr = String.Empty
                                    iconStr = String.Empty
                                    mPages = 0
                                    '-- post icon
                                    If dataRdr.IsDBNull(12) = True Then
                                        iconStr = "&nbsp;"
                                    Else
                                        If LCase(dataRdr.Item(12)) <> "none" And dataRdr.Item(12) <> String.Empty Then
                                            iconStr = "<img src=" + Chr(34) + siteRoot + "/posticons/" + dataRdr.Item(12) + ".gif"" border=""0"">"
                                        Else
                                            iconStr = "&nbsp;"
                                        End If
                                    End If
                                    '-- topic lock
                                    If dataRdr.Item(11) = True Then
                                        topicStr = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/lock.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "32") + Chr(34) + ">&nbsp"
                                    End If
                                    '-- topic title
                                    topicStr += "<a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&m=" + CStr(dataRdr.Item(0)) + Chr(34) + ">"
                                    topicStr += Server.HtmlEncode(dataRdr.Item(1)) + "</a>"
                                    '-- reply count
                                    If dataRdr.IsDBNull(3) = False Then
                                        replyStr = CStr(dataRdr.Item(3))
                                        If dataRdr.Item(3) > MAX_THREAD Then
                                            topicStr += "<br />View Page : "
                                            mPages = dataRdr.Item(3) / MAX_THREAD
                                            If CInt(mPages) < mPages Then
                                                For i = 1 To CInt(mPages) + 1
                                                    topicStr += "<a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&m=" + CStr(dataRdr.Item(0)) + "&p=" + i.ToString + Chr(34) + ">"
                                                    topicStr += i.ToString + "</a> "
                                                Next
                                            Else
                                                For i = 1 To CInt(mPages)
                                                    topicStr += "<a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&m=" + CStr(dataRdr.Item(0)) + "&p=" + i.ToString + Chr(34) + ">"
                                                    topicStr += i.ToString + "</a> "
                                                Next
                                            End If
                                        End If
                                    Else
                                        replyStr = "0"
                                    End If
                                    '-- view count
                                    If dataRdr.IsDBNull(4) = False Then
                                        viewStr = CStr(dataRdr.Item(4))
                                    Else
                                        viewStr = "0"
                                    End If

                                    '-- first post
                                    firstStr = "<a href=" + Chr(34) + siteRoot + "/vp.aspx?f=" + _forumID.ToString + "&p=" + CStr(dataRdr.Item(6)) + Chr(34) + " >"
                                    firstStr += Server.HtmlEncode(dataRdr.Item(7)) + "</a>"
                                    If dataRdr.IsDBNull(2) = False Then
                                        If IsDate(dataRdr.Item(2)) = True Then
                                            If CDate(lastVisit) <= dataRdr.Item(2) Then
                                                topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newtopic.gif"" alt=" + Chr(34) + getHashVal("main", "33") + Chr(34) + " border=""0"">"
                                            Else
                                                topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" alt=" + Chr(34) + getHashVal("main", "34") + Chr(34) + " border=""0"">"
                                            End If
                                        End If
                                    End If

                                    '-- last post
                                    If dataRdr.IsDBNull(8) = True Then '-- not a poll
                                        If dataRdr.IsDBNull(9) = False And dataRdr.IsDBNull(10) = False And dataRdr.IsDBNull(5) = False Then
                                            lastStr = "<a href=" + Chr(34) + siteRoot + "/vp.aspx?f=" + _forumID.ToString + "&p=" + CStr(dataRdr.Item(9)) + Chr(34) + " >"
                                            If _eu31 <> 0 And _timeOffset = 0 Then
                                                lastStr += Server.HtmlEncode(dataRdr.Item(10)) + "</a><br />" + FormatDateTime(DateAdd(DateInterval.Hour, _eu31, dataRdr.Item(5)), DateFormat.GeneralDate)

                                            ElseIf _timeOffset <> 0 Then
                                                lastStr += Server.HtmlEncode(dataRdr.Item(10)) + "</a><br />" + FormatDateTime(DateAdd(DateInterval.Hour, _timeOffset, dataRdr.Item(5)), DateFormat.GeneralDate)

                                            Else
                                                lastStr += Server.HtmlEncode(dataRdr.Item(10)) + "</a><br />" + CStr(dataRdr.Item(5))
                                            End If

                                            If uGUID = GUEST_GUID Then
                                                topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" alt=" + Chr(34) + getHashVal("main", "34") + Chr(34) + " border=""0"">"
                                            Else
                                                If IsDate(dataRdr.Item(5)) = True Then
                                                    If dataRdr.Item(5) > CDate(lastVisit) Then
                                                        topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newtopic.gif"" alt=" + Chr(34) + getHashVal("main", "33") + Chr(34) + " border=""0"">"
                                                    Else
                                                        topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" alt=" + Chr(34) + getHashVal("main", "34") + Chr(34) + " border=""0"">"
                                                    End If
                                                End If
                                            End If

                                        Else
                                            lastStr = "&nbsp;"
                                            topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" alt=" + Chr(34) + getHashVal("main", "34") + Chr(34) + " border=""0"">"
                                        End If


                                    Else    '-- is a poll
                                        If dataRdr.Item(8) = True Then
                                            If dataRdr.IsDBNull(9) = False And dataRdr.IsDBNull(10) = False And dataRdr.IsDBNull(5) = False Then
                                                lastStr = "<a href=" + Chr(34) + siteRoot + "/vp.aspx?f=" + _forumID.ToString + "&p=" + CStr(dataRdr.Item(9)) + Chr(34) + " >"
                                                If _eu31 <> 0 And _timeOffset = 0 Then
                                                    lastStr += Server.HtmlEncode(dataRdr.Item(10)) + "</a><br />" + FormatDateTime(DateAdd(DateInterval.Hour, _eu31, dataRdr.Item(5)), DateFormat.GeneralDate)

                                                ElseIf _timeOffset <> 0 Then
                                                    lastStr += Server.HtmlEncode(dataRdr.Item(10)) + "</a><br />" + FormatDateTime(DateAdd(DateInterval.Hour, _timeOffset, dataRdr.Item(5)), DateFormat.GeneralDate)

                                                Else
                                                    lastStr += Server.HtmlEncode(dataRdr.Item(10)) + "</a><br />" + CStr(dataRdr.Item(5))
                                                End If

                                                topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/pollicon.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "36") + Chr(34) + ">"

                                            Else
                                                lastStr = "&nbsp;"
                                                topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/pollicon.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "36") + Chr(34) + ">"
                                            End If

                                        Else    '-- just in case set to false
                                            If dataRdr.IsDBNull(9) = False And dataRdr.IsDBNull(10) = False And dataRdr.IsDBNull(5) = False Then
                                                lastStr = "<a href=" + Chr(34) + siteRoot + "/vp.aspx?f=" + _forumID.ToString + "&p=" + CStr(dataRdr.Item(9)) + Chr(34) + " >"
                                                If _eu31 <> 0 And _timeOffset = 0 Then
                                                    lastStr += Server.HtmlEncode(dataRdr.Item(10)) + "</a><br />" + FormatDateTime(DateAdd(DateInterval.Hour, _eu31, dataRdr.Item(5)), DateFormat.GeneralDate)

                                                ElseIf _timeOffset <> 0 Then
                                                    lastStr += Server.HtmlEncode(dataRdr.Item(10)) + "</a><br />" + FormatDateTime(DateAdd(DateInterval.Hour, _timeOffset, dataRdr.Item(5)), DateFormat.GeneralDate)

                                                Else
                                                    lastStr += Server.HtmlEncode(dataRdr.Item(10)) + "</a><br />" + CStr(dataRdr.Item(5))
                                                End If

                                                If uGUID = GUEST_GUID Then
                                                    topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" alt=" + Chr(34) + getHashVal("main", "34") + Chr(34) + " border=""0"">"
                                                Else
                                                    If IsDate(dataRdr.Item(5)) = True Then
                                                        If dataRdr.Item(5) > CDate(lastVisit) Then
                                                            topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newtopic.gif"" alt=" + Chr(34) + getHashVal("main", "33") + Chr(34) + " border=""0"">"
                                                        Else
                                                            topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" alt=" + Chr(34) + getHashVal("main", "34") + Chr(34) + " border=""0"">"
                                                        End If
                                                    End If
                                                End If

                                            Else
                                                lastStr = "&nbsp;"
                                                topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" alt=" + Chr(34) + getHashVal("main", "34") + Chr(34) + " border=""0"">"
                                            End If
                                        End If
                                    End If


                                    '-- build from template
                                    Dim sbRow As New StringBuilder(templStr)
                                    sbRow.Replace(vbCrLf, "")
                                    sbRow.Replace("{IsNewIcon}", topicIcon)
                                    If _eu6 = True Then
                                        sbRow.Replace("{ICON}", iconStr)
                                    Else
                                        sbRow.Replace("{ICON}", "&nbsp;")
                                    End If

                                    sbRow.Replace("{TopicTitle}", topicStr)
                                    sbRow.Replace("{Replies}", replyStr)
                                    sbRow.Replace("{Views}", viewStr)
                                    sbRow.Replace("{LastPost}", lastStr)
                                    sbRow.Replace("{FirstPost}", firstStr)
                                    sbRow.Replace("{ClassTag}", "msgTopic")
                                    lfTable.Append(sbRow.ToString)
                                    '    End If
                                    'End If
                                End While
                            End If
                            If tCount > 25 Then     '-- always show paging option if more than 25 records
                                lfTable.Append("<tr><form action=" + Chr(34) + siteRoot + "/"" method=""get"" name=""cpf2"">")
                                lfTable.Append("<td class=""msgHead"" align=""left"">&nbsp;</td>")
                                lfTable.Append("<td class=""msgHead"" align=""left"" colspan=""2"">")
                                '-- who can post to the forum?
                                Select Case whopost
                                    Case 1
                                        lfTable.Append("<a title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=n" + Chr(34) + ">")
                                        lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " /></a>&nbsp;")
                                        lfTable.Append("<a title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=np" + Chr(34) + ">")
                                        lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " /></a>&nbsp;")

                                    Case 2, 3
                                        If canModerate = True Then
                                            lfTable.Append("<a title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=n" + Chr(34) + ">")
                                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " /></a>&nbsp;")
                                            lfTable.Append("<a title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=np" + Chr(34) + ">")
                                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " /></a>&nbsp;")
                                        Else
                                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/nonewpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "159") + Chr(34) + " />&nbsp;")
                                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/nonewpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "160") + Chr(34) + " />&nbsp;")
                                        End If
                                End Select
                                lfTable.Append("<td class=""msgHead"" align=""right"" colspan=""4"">" + tCount.ToString + getHashVal("main", "29"))
                                lfTable.Append(perPageDrop2(_forumID, , _currentPage, _perPage))
                                lfTable.Append(getHashVal("main", "30") + "<br />" + getHashVal("main", "31"))
                                For i = 1 To ipages
                                    If i = _currentPage Then
                                        lfTable.Append("&nbsp;<b>" + i.ToString + "</b>&nbsp;")
                                    Else
                                        lfTable.Append("&nbsp;<a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&p=" + i.ToString + "&x=" + _perPage.ToString + Chr(34) + ">")
                                        lfTable.Append(i.ToString + "</a>&nbsp;")
                                    End If
                                Next
                                lfTable.Append("</td></form></tr>")
                            Else
                                lfTable.Append("<tr>")
                                lfTable.Append("<td class=""msgHead"" align=""left"">&nbsp;</td>")
                                lfTable.Append("<td class=""msgHead"" align=""left"" colspan=""7"">")
                                '-- who can post to the forum?
                                Select Case whopost
                                    Case 1
                                        lfTable.Append("<a title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=n" + Chr(34) + ">")
                                        lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " /></a>&nbsp;")
                                        lfTable.Append("<a title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=np" + Chr(34) + ">")
                                        lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " /></a>&nbsp;")

                                    Case 2, 3
                                        If canModerate = True Then
                                            lfTable.Append("<a title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=n" + Chr(34) + ">")
                                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " /></a>&nbsp;")
                                            lfTable.Append("<a title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=np" + Chr(34) + ">")
                                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " /></a>&nbsp;")
                                        Else
                                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/nonewpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "159") + Chr(34) + " />&nbsp;")
                                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/nonewpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "160") + Chr(34) + " />&nbsp;")
                                        End If
                                End Select
                                firstRec = 1
                                lastRec = tCount
                                pageCount = 1
                            End If
                        Else
                            lfTable.Append("<tr>")
                            lfTable.Append("<td class=""msgHead"" align=""left"">&nbsp;</td>")
                            lfTable.Append("<td class=""msgHead"" align=""left"" colspan=""7"">")
                            lfTable.Append("<a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=n" + Chr(34) + ">")
                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " /></a>&nbsp;")
                            lfTable.Append("<a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=np" + Chr(34) + ">")
                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " /></a>&nbsp;</td></tr>")
                            lfTable.Append("<tr><td class=""msgTopic"" colspan=""6"" align=""center"" valign=""top"" height=""150""><br /><br />" + getHashVal("main", "35") + "</td></tr>")
                            lfTable.Append("<tr>")
                            lfTable.Append("<td class=""msgHead"" align=""left"">&nbsp;</td>")
                            lfTable.Append("<td class=""msgHead"" align=""left"" colspan=""7"">")
                            lfTable.Append("<a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=n" + Chr(34) + " accesskey=""n"">")
                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " /></a>&nbsp;")
                            lfTable.Append("<a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=np" + Chr(34) + ">")
                            lfTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " /></a>&nbsp;</td></tr>")
                        End If

                    End If
                End If
                lfTable.Append("</table>")
                lfTable.Append(forumWhosOnline(_forumID))
                lfTable.Append(forumThreadIcons(2))
                lfTable.Append(printCopyright())

            Catch ex As Exception
                logErrorMsg("forumListForum<br />" + ex.StackTrace.ToString, 1)
            End Try
            Return lfTable.ToString

        End Function

        '-- Prints out the message thread
        Public Function forumListThread(ByVal uGUID As String, Optional ByVal replyThread As Boolean = False) As String
            Dim ltTable As New StringBuilder("<table border=""0"" cellpadding=""0"" cellspacing=""0"" width=""100%"" height=""200"">")
            Dim tCount As Integer = 0
            Dim firstRec As Integer = 0
            Dim lastRec As Integer = 0
            Dim pagecount As Double = 0.0
            Dim iPages As Integer = 0
            Dim i As Integer = 0
            Dim j As Integer = 0
            Dim topicLocked As Boolean = False
            Dim canModerate As Boolean = False
            Dim pTitles() As userTitles
            Dim modDrop As String = "&nbsp;"
            Dim canBanUser As Boolean = False
            Dim canBanIP As Boolean = False
            Dim canLock As Boolean = False
            Dim canStick As Boolean = False
            Dim whopost As Integer = whoCanPost()
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If userStrLoaded = False Then
                userStrLoaded = xmlLoadStringMsg("user")
            End If

            '-- template items
            Dim templStr As String = loadTBTemplate("style-listThread.htm", defaultStyle)
            Dim userStr As String = String.Empty
            Dim titleStr As String = String.Empty
            Dim postStr As String = String.Empty
            Dim joinStr As String = String.Empty
            Dim linkIconStr As String = String.Empty
            Dim avatarStr As String = String.Empty
            Dim threadStr As String = String.Empty
            Dim messageStr As String = String.Empty
            Dim classStr As String = String.Empty
            Dim editStr As String = String.Empty
            Dim iStr As String = _eu16
            Dim iSpl() As String
            If InStr(iStr, ",", CompareMethod.Binary) > 0 Then
                iSpl = iStr.Split(",")
                If UBound(iSpl) = 1 Then
                    iSpl(0) = iSpl(0).ToString.Trim
                    iSpl(1) = iSpl(1).ToString.Trim
                    If IsNumeric(iSpl(0)) = False Then
                        iSpl(0) = 75
                    End If
                    If IsNumeric(iSpl(1)) = False Then
                        iSpl(1) = 75
                    End If
                Else
                    ReDim iSpl(1)
                    iSpl(0) = 75
                    iSpl(1) = 75
                End If
            Else
                ReDim iSpl(1)
                iSpl(0) = 75
                iSpl(1) = 75
            End If
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_GetTitles", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False And dataRdr.IsDBNull(2) = False Then
                        i += 1
                        ReDim Preserve pTitles(i)
                        pTitles(i).minVal = dataRdr.Item(0)
                        pTitles(i).maxval = dataRdr.Item(1)
                        pTitles(i).titleText = Server.HtmlEncode(dataRdr.Item(2))

                    End If
                End While
                dataRdr.Close()

            Else '-- no titles, populate as empty
                ReDim pTitles(1)
                pTitles(1).maxval = 999999
                pTitles(1).minVal = 0
                pTitles(1).titleText = String.Empty
            End If
            dataConn.Close()


            uGUID = checkValidGUID(uGUID)

            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_GetCanModerate", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
            dataParam.Value = _forumID
            dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
            dataParam.Value = XmlConvert.ToGuid(uGUID)
            dataParam = dataCmd.Parameters.Add("@CanModerate", SqlDbType.Bit)
            dataParam.Direction = ParameterDirection.Output
            dataConn.Open()
            dataCmd.ExecuteNonQuery()
            canModerate = dataCmd.Parameters("@CanModerate").Value
            dataConn.Close()
            canBanUser = getAdminMenuAccess(7, uGUID)
            canBanIP = getAdminMenuAccess(20, uGUID)
            canLock = getAdminMenuAccess(26, uGUID)
            canStick = getAdminMenuAccess(9, uGUID)

            If checkForumActive() = False Then  '-- check if disabled : new in v2.1
                ltTable.Append("<tr><td class=""msgTopic"" align=""center"" height=""400"" valign=""top""><br /><b>" + getHashVal("main", "162") + "</b><br /><br />")
                ltTable.Append("</td></tr>")

            ElseIf checkForumAccess(uGUID, _forumID) = False Then                   '-- check access to forum
                ltTable.Append("<tr><td class=""msgTopic"" align=""center"" height=""400"" valign=""top""><br /><b>" + getHashVal("main", "24") + "</b><br /><br />")

                If uGUID = GUEST_GUID Then
                    ltTable.Append(getHashVal("main", "25") + "<br /><br />")
                    ltTable.Append("<a href=" + Chr(34) + siteRoot + "/l.aspx?f=" + _forumID.ToString + Chr(34) + ">")
                    ltTable.Append(getHashVal("main", "26") + "</a>" + getHashVal("main", "27"))
                Else
                    ltTable.Append(getHashVal("main", "28") + "<br /><br />")
                End If
                ltTable.Append("</td></tr>")
            Else
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ThreadCount", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                dataParam.Value = _messageID
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataParam = dataCmd.Parameters.Add("@ThreadCount", SqlDbType.Int)
                dataParam.Direction = ParameterDirection.Output
                dataParam = dataCmd.Parameters.Add("@IsLocked", SqlDbType.Bit)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                tCount = dataCmd.Parameters("@ThreadCount").Value
                topicLocked = dataCmd.Parameters("@IsLocked").Value
                dataConn.Close()

                i = 0

                If tCount > 0 Then
                    '-- paging
                    If tCount > MAX_THREAD Then
                        ltTable.Append("<tr><td class=""msgSm"" align=""right"" colspan=""3""><b>")
                        ltTable.Append(tCount.ToString + getHashVal("main", "37") + "<br />" + getHashVal("main", "38"))
                        firstRec = ((_currentPage - 1) * MAX_THREAD) + 1
                        lastRec = (_currentPage * MAX_THREAD)
                        pagecount = CDbl(tCount / MAX_THREAD)
                        If CInt(pagecount) < pagecount Then
                            iPages += CInt(pagecount + 1)
                        Else
                            iPages = CInt(pagecount)
                        End If
                        For i = 1 To iPages
                            If i = _currentPage Then
                                ltTable.Append("&nbsp;<b>" + i.ToString + "</b>&nbsp;")
                            Else
                                ltTable.Append("&nbsp;<a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&p=" + i.ToString + "&m=" + _messageID.ToString + Chr(34) + ">")
                                ltTable.Append(i.ToString + "</a>&nbsp;")
                            End If
                        Next
                        ltTable.Append("</b></td></tr>")
                    Else
                        firstRec = 1
                        lastRec = 25
                        pagecount = 1
                    End If

                    If replyThread = False Then
                        ltTable.Append("<tr>")
                        ltTable.Append("<td class=""msgHead"" align=""left"">&nbsp;</td>")
                        ltTable.Append("<td class=""msgHead"" height=""20"" align=""left"" valign=""bottom"" colspan=""2"" style=""padding-top:6px;padding-bottom:3px;"">")

                        '-- who can post to the forum?
                        Select Case whopost
                            Case 1
                                ltTable.Append("<a title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=n" + Chr(34) + ">")
                                ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " /></a>&nbsp;")
                                ltTable.Append("<a title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=np" + Chr(34) + ">")
                                ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " /></a>&nbsp;")
                                If topicLocked = False Then
                                    ltTable.Append("<a title=" + Chr(34) + getHashVal("main", "1") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=r&m=" + _messageID.ToString + Chr(34) + ">")
                                    ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/replypost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "1") + Chr(34) + " /></a>&nbsp;")
                                Else
                                    ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/lockedbtn.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "39") + Chr(34) + " />&nbsp;")
                                End If
                            Case 2
                                If canModerate = True Then
                                    ltTable.Append("<a title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=n" + Chr(34) + ">")
                                    ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " /></a>&nbsp;")
                                    ltTable.Append("<a title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=np" + Chr(34) + ">")
                                    ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " /></a>&nbsp;")
                                    If topicLocked = False Then
                                        ltTable.Append("<a title=" + Chr(34) + getHashVal("main", "1") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=r&m=" + _messageID.ToString + Chr(34) + ">")
                                        ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/replypost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "1") + Chr(34) + " /></a>&nbsp;")
                                    Else
                                        ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/lockedbtn.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "39") + Chr(34) + " />&nbsp;")
                                    End If
                                Else
                                    ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/nonewpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "159") + Chr(34) + " />&nbsp;")
                                    ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/nonewpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "160") + Chr(34) + " />&nbsp;")
                                    If topicLocked = False Then
                                        ltTable.Append("<a title=" + Chr(34) + getHashVal("main", "1") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=r&m=" + _messageID.ToString + Chr(34) + ">")
                                        ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/replypost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "1") + Chr(34) + " /></a>&nbsp;")
                                    Else
                                        ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/lockedbtn.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "39") + Chr(34) + " />&nbsp;")
                                    End If
                                End If

                            Case 3
                                If canModerate = True Then
                                    ltTable.Append("<a title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=n" + Chr(34) + ">")
                                    ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " /></a>&nbsp;")
                                    ltTable.Append("<a title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=np" + Chr(34) + ">")
                                    ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " /></a>&nbsp;")
                                    If topicLocked = False Then
                                        ltTable.Append("<a title=" + Chr(34) + getHashVal("main", "1") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=r&m=" + _messageID.ToString + Chr(34) + ">")
                                        ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/replypost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "1") + Chr(34) + " /></a>&nbsp;")
                                    Else
                                        ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/lockedbtn.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "39") + Chr(34) + " />&nbsp;")
                                    End If
                                Else
                                    ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/nonewpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "159") + Chr(34) + " />&nbsp;")
                                    ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/nonewpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "160") + Chr(34) + " />&nbsp;")
                                    ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/noreplypost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "161") + Chr(34) + " />&nbsp;")
                                End If

                        End Select
                        '-- printable
                        ltTable.Append("<a href=" + Chr(34) + siteRoot + "/pr.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + " target=""_blank""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/printable.gif"" valign=""bottom"" border=""0"" alt=" + Chr(34) + getHashVal("main", "40") + Chr(34) + " /></a>")

                        ltTable.Append("</td></tr>")
                    End If


                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_GetMessageThreadPaged", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                    dataParam.Value = _forumID
                    dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                    dataParam.Value = _messageID
                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                    dataParam = dataCmd.Parameters.Add("@FirstRec", SqlDbType.Int)
                    dataParam.Value = firstRec
                    dataParam = dataCmd.Parameters.Add("@LastRec", SqlDbType.Int)
                    dataParam.Value = lastRec
                    dataConn.Open()
                    dataRdr = dataCmd.ExecuteReader()
                    If dataRdr.IsClosed = False Then
                        While dataRdr.Read
                            '-- reset values
                            modDrop = "&nbsp;"
                            userStr = String.Empty
                            titleStr = String.Empty
                            postStr = String.Empty
                            joinStr = String.Empty
                            linkIconStr = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/imbar.gif"" height=""27"" width=""10"" border=""0"">"
                            threadStr = String.Empty
                            messageStr = String.Empty
                            classStr = String.Empty
                            editStr = String.Empty
                            i += 1

                            '-- user name
                            userStr = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" height=""1"" width=""150""><br />"
                            If dataRdr.IsDBNull(13) = False Then
                                userStr += "<a name=""m" + CStr(dataRdr.Item(13)) + Chr(34) + " />"
                            End If
                            userStr += "<a href=" + Chr(34) + siteRoot + "/vp.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + "&p=" + CStr(dataRdr.Item(4)) + Chr(34) + ">"
                            userStr += Server.HtmlEncode(dataRdr.Item(3)) + "</a>"
                            '-- user title
                            If dataRdr.IsDBNull(16) = False Then
                                '------------------------------
                                '-- updated in v2.1 : shows user title if entered, if not shows "Forum Moderator"
                                If dataRdr.IsDBNull(24) = False Then
                                    If Trim(dataRdr.Item(24)) <> "" Then
                                        titleStr = "<i><b>" + dataRdr.Item(24) + "</b></i><br />"
                                    Else
                                        titleStr = "<i><b>" + getHashVal("user", "1") + "</b></i><br />"
                                    End If
                                    postStr = getHashVal("user", "2") + CStr(dataRdr.Item(10))
                                End If
                                '-- end v2.1 update
                                '------------------------------
                            Else
                                If dataRdr.IsDBNull(10) = False Then
                                    If dataRdr.IsDBNull(24) = False And _eu37 = True Then       '-- if user's title is not null and custom titles are allowed
                                        If Trim(dataRdr.Item(24)) <> "" Then
                                            titleStr = "<i>" + dataRdr.Item(24) + "</i>"
                                        Else
                                            For j = 1 To UBound(pTitles)
                                                If pTitles(j).minVal <= dataRdr.Item(10) And pTitles(j).maxval >= dataRdr.Item(10) Then
                                                    If pTitles(j).titleText <> String.Empty Then  '-- ignore blank titles
                                                        titleStr = "<i>" + pTitles(j).titleText + "</i><br />"
                                                    End If
                                                End If
                                            Next
                                        End If
                                    Else
                                        For j = 1 To UBound(pTitles)
                                            If pTitles(j).minVal <= dataRdr.Item(10) And pTitles(j).maxval >= dataRdr.Item(10) Then
                                                If pTitles(j).titleText <> String.Empty Then  '-- ignore blank titles
                                                    titleStr = "<i>" + pTitles(j).titleText + "</i><br />"
                                                End If
                                            End If
                                        Next
                                    End If
                                    postStr = getHashVal("user", "2") + CStr(dataRdr.Item(10))
                                End If
                            End If

                            '-- date joined
                            joinStr = getHashVal("user", "3")
                            If dataRdr.IsDBNull(11) = False Then
                                If IsDate(dataRdr.Item(11)) = True Then
                                    Dim jDate As Date = dataRdr.Item(11)
                                    If _eu31 <> 0 And _timeOffset = 0 Then
                                        jDate = DateAdd(DateInterval.Hour, _eu31, jDate)
                                    ElseIf _timeOffset <> 0 Then
                                        jDate = DateAdd(DateInterval.Hour, _timeOffset, jDate)
                                    End If
                                    joinStr += MonthName(Month(jDate), True).ToString
                                    joinStr += "&nbsp;" + Year(jDate).ToString

                                End If
                            End If

                            '-- EMAIL LINK
                            If dataRdr.IsDBNull(5) = False And dataRdr.Item(6) = 1 Then
                                linkIconStr += "<a href=""mailto:" + dataRdr.Item(5) + Chr(34) + ">"
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/mail_on.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "4") + dataRdr.Item(3) + getHashVal("user", "5") + Chr(34) + "></a>"
                            Else
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/mail_off.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "6") + Chr(34) + "></a>"
                            End If
                            '-- HOMEPAGE LINK
                            If dataRdr.IsDBNull(7) = False Then
                                If dataRdr.Item(7) <> String.Empty And LCase(dataRdr.Item(7)) <> "http://" Then
                                    linkIconStr += "<a href=" + Chr(34) + dataRdr.Item(7) + Chr(34) + " target=""_blank"">"
                                    linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/home_on.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "7") + dataRdr.Item(3) + getHashVal("user", "8") + Chr(34) + "></a>"
                                Else
                                    linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/home_off.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "9") + Chr(34) + "></a>"
                                End If
                            Else
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/home_off.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "9") + Chr(34) + "></a>"
                            End If
                            '-- Private Message link
                            If _eu28 = False Then '-- pm not locked
                                If dataRdr.IsDBNull(19) = False And dataRdr.IsDBNull(20) = False Then
                                    If dataRdr.Item(19) = True And dataRdr.Item(20) = True Then
                                        linkIconStr += "<a href=" + Chr(34) + siteRoot + "/?r=pm&eod=n&uName=" + Server.UrlEncode(dataRdr.Item(3)) + Chr(34) + ">"
                                        linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/pm_on.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "10") + dataRdr.Item(3) + Chr(34) + "></a>"
                                    Else
                                        linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/pm_off.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "11") + Chr(34) + ">"
                                    End If
                                End If
                            End If

                            '-- AIM BUDDY LIST
                            If dataRdr.IsDBNull(8) = False Then
                                If CStr(dataRdr.Item(8)).Trim <> String.Empty Then
                                    linkIconStr += "<a href=""aim:addbuddy?screenname=" + dataRdr.Item(8) + Chr(34) + ">"
                                    linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/aim_on.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "12") + dataRdr.Item(3) + getHashVal("user", "13") + Chr(34) + "></a>"
                                Else
                                    linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/aim_off.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "14") + Chr(34) + ">"
                                End If
                            Else
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/aim_off.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "14") + Chr(34) + ">"
                            End If
                            '-- ICQ LIST
                            If dataRdr.IsDBNull(9) = False Then
                                If dataRdr.Item(9) > 0 Then
                                    linkIconStr += "<a href=""http://wwp.icq.com/scripts/search.dll?to=" + CStr(dataRdr.Item(9)) + Chr(34) + ">"
                                    linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/icq_on.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "12") + dataRdr.Item(3) + getHashVal("user", "15") + Chr(34) + "></a>"
                                Else
                                    linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/icq_off.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "16") + Chr(34) + ">"
                                End If
                            Else
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/icq_off.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "16") + Chr(34) + ">"
                            End If

                            '-- Y!
                            If dataRdr.IsDBNull(15) = False Then
                                If CStr(dataRdr.Item(15)).Trim <> String.Empty Then
                                    Dim buddyStr As String = "http://edit.yahoo.com/config/set_buddygrp?.src=&.cmd=a&.bg=Friends&.bdl="
                                    buddyStr += dataRdr.Item(15)
                                    buddyStr += "&.done=" + Server.UrlEncode(siteURL)
                                    linkIconStr += "<a href=" + Chr(34) + buddyStr + Chr(34) + " target=""_blank"">"
                                    linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/y_on.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "12") + dataRdr.Item(15) + getHashVal("user", "17") + Chr(34) + "></a>"
                                Else
                                    linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/y_off.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "18") + Chr(34) + ">"
                                End If
                            Else
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/y_off.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "18") + Chr(34) + ">"
                            End If

                            '-- MSN, TO PROFILE
                            If dataRdr.IsDBNull(14) = False Then
                                If CStr(dataRdr.Item(14)).Trim <> String.Empty Then
                                    linkIconStr += "<a href=" + Chr(34) + siteRoot + "/vp.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + "&p=" + CStr(dataRdr.Item(4)) + Chr(34) + ">"
                                    linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/msn_on.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "12") + dataRdr.Item(14) + getHashVal("user", "19") + Chr(34) + "></a>"
                                Else
                                    linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/msn_off.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "20") + Chr(34) + ">"
                                End If
                            Else
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/msn_off.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "20") + Chr(34) + ">"
                            End If

                            linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/imbar.gif"" height=""27"" width=""10"" border=""0"">"

                            '-- user avatar
                            If dataRdr.IsDBNull(17) = False And _eu14 = True Then
                                If CStr(dataRdr.Item(17)).Trim = String.Empty Then    '-- no avatar
                                    avatarStr = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" width=""1"" height=""2"" />"
                                Else
                                    If Left(CStr(dataRdr.Item(17)).ToString.Trim.ToLower, 7) = "http://" Then   '-- user uploaded avatar
                                        If _eu15 = True Then    '-- remote avatars allowed
                                            avatarStr = "<img src=" + Chr(34) + Server.HtmlEncode(CStr(dataRdr.Item(17)).ToString.Trim) + Chr(34) + " border=""0"" height=" + Chr(34) + iSpl(0).ToString + Chr(34) + " width=" + Chr(34) + iSpl(1).ToString + Chr(34) + " />"
                                        Else
                                            avatarStr = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" width=""1"" height=""2"" />"
                                        End If
                                    Else
                                        avatarStr = "<img src=" + Chr(34) + siteRoot + "/avatar/" + CStr(dataRdr.Item(17)).ToString.Trim + Chr(34) + " border=""0"" />"
                                    End If
                                End If

                            Else        '-- no avatar
                                avatarStr = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" width=""1"" height=""2"" />"
                            End If

                            If i Mod 2 = 0 Then
                                classStr = "msgThread1"
                            Else
                                classStr = "msgThread2"
                            End If

                            '-- post icon if used
                            If dataRdr.IsDBNull(12) = False Then
                                If dataRdr.Item(12) = "none" Or dataRdr.Item(12) = String.Empty Then
                                    threadStr = "<img src=" + Chr(34) + siteRoot + "/posticons/transdot.gif"" heignt=""15"" width=""15"" border=""0"" />&nbsp;&nbsp;&nbsp;"
                                Else
                                    threadStr = "<img src=" + Chr(34) + siteRoot + "/posticons/" + dataRdr.Item(12) + ".gif"" border=""0"" />&nbsp;&nbsp;&nbsp;"
                                End If
                            Else
                                threadStr = "<img src=" + Chr(34) + siteRoot + "/posticons/transdot.gif"" heignt=""15"" width=""15"" border=""0"" />&nbsp;&nbsp;&nbsp;"
                            End If

                            threadStr += "Posted "
                            Dim mDate As Date = dataRdr.Item(1)
                            Dim tOff As Integer = 0
                            If _eu31 <> 0 And _timeOffset = 0 Then
                                mDate = DateAdd(DateInterval.Hour, _eu31, mDate)
                                tOff = _eu31
                            ElseIf _timeOffset <> 0 Then
                                mDate = DateAdd(DateInterval.Hour, _timeOffset, mDate)
                                tOff = _timeOffset
                            End If
                            threadStr += FormatDateTime(mDate, DateFormat.LongDate)
                            threadStr += "&nbsp;-&nbsp;" + FormatDateTime(mDate, DateFormat.LongTime) + " (GMT "
                            If tOff > 0 Then
                                threadStr += "+" + tOff.ToString + ")"
                            Else
                                threadStr += tOff.ToString + ")"
                            End If
                            threadStr += "&nbsp;&nbsp;&nbsp;"

                            '-- edit/delete/quote/report/etc buttons

                            If dataRdr.IsDBNull(22) = False Then
                                If dataRdr.Item(22) = True Then     '-- parent message
                                    If canStick = True Then
                                        If dataRdr.IsDBNull(23) = False Then
                                            If dataRdr.Item(23) = True Then
                                                editStr += "<a href=" + Chr(34) + siteRoot + "/?r=ust&f=" + _forumID.ToString + "&m=" + CStr(dataRdr.Item(13)) + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/unstickybtn.gif"" border=""0"" alt=" + Chr(34) + getHashVal("main", "41") + Chr(34) + "></a>"
                                            Else
                                                editStr += "<a href=" + Chr(34) + siteRoot + "/?r=st&f=" + _forumID.ToString + "&m=" + CStr(dataRdr.Item(13)) + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/stickybtn.gif"" border=""0"" alt=" + Chr(34) + getHashVal("main", "42") + Chr(34) + "></a>"
                                            End If
                                        Else
                                            editStr += "<a href=" + Chr(34) + siteRoot + "/?r=st&f=" + _forumID.ToString + "&m=" + CStr(dataRdr.Item(13)) + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/unstickybtn.gif"" border=""0"" alt=" + Chr(34) + getHashVal("main", "41") + Chr(34) + "></a>"
                                        End If
                                    End If

                                    If canLock = True Then
                                        If topicLocked = False Then
                                            editStr += "<a href=" + Chr(34) + siteRoot + "/?r=lt&f=" + _forumID.ToString + "&m=" + CStr(dataRdr.Item(13)) + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/lockthreadbtn.gif"" border=""0"" alt=" + Chr(34) + getHashVal("main", "43") + Chr(34) + "></a>"
                                        Else
                                            editStr += "<a href=" + Chr(34) + siteRoot + "/?r=ut&f=" + _forumID.ToString + "&m=" + CStr(dataRdr.Item(13)) + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/unlockthreadbtn.gif"" border=""0"" alt=" + Chr(34) + getHashVal("main", "44") + Chr(34) + "></a>"
                                        End If
                                    End If
                                End If
                            End If

                            If uGUID <> "{" + XmlConvert.ToString(dataRdr.Item(2)) + "}" Then       '-- dont show ban buttons if posted by self
                                If canBanUser = True Then
                                    editStr += "<a href=" + Chr(34) + siteRoot + "/?r=bu&f=" + _forumID.ToString + "&m=" + CStr(dataRdr.Item(13)) + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/banuserbtn.gif"" border=""0"" alt=" + Chr(34) + getHashVal("main", "45") + Chr(34) + "></a>"
                                End If
                                If canBanIP = True Then
                                    If dataRdr.IsDBNull(18) = False Then
                                        editStr += "<a href=" + Chr(34) + siteRoot + "/?r=bi&f=" + _forumID.ToString + "&m=" + CStr(dataRdr.Item(13)) + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/banipbtn.gif"" border=""0"" alt=" + Chr(34) + getHashVal("main", "46") + dataRdr.Item(18) + Chr(34) + " ></a>"
                                    End If

                                End If
                            End If

                            If uGUID = "{" + XmlConvert.ToString(dataRdr.Item(2)) + "}" Then
                                editStr += "<a href=" + Chr(34) + siteRoot + "/?r=e&f=" + _forumID.ToString + "&m=" + CStr(dataRdr.Item(13)) + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/editbtn.gif"" border=""0"" alt=" + Chr(34) + getHashVal("main", "0") + Chr(34) + "></a>"
                                editStr += "<a href=" + Chr(34) + siteRoot + "/?r=d&f=" + _forumID.ToString + "&m=" + CStr(dataRdr.Item(13)) + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/deletebtn.gif"" border=""0"" alt=" + Chr(34) + getHashVal("main", "4") + Chr(34) + "></a>"

                            ElseIf canModerate = True Then
                                editStr += "<a href=" + Chr(34) + siteRoot + "/?r=em&f=" + _forumID.ToString + "&m=" + CStr(dataRdr.Item(13)) + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/editbtn.gif"" border=""0"" alt=" + Chr(34) + getHashVal("main", "6") + Chr(34) + " ></a>"
                                editStr += "<a href=" + Chr(34) + siteRoot + "/?r=dm&f=" + _forumID.ToString + "&m=" + CStr(dataRdr.Item(13)) + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/deletebtn.gif"" border=""0"" alt=" + Chr(34) + getHashVal("main", "7") + Chr(34) + " ></a>"
                                editStr += "<a href=" + Chr(34) + siteRoot + "/?r=q&f=" + _forumID.ToString + "&m=" + CStr(dataRdr.Item(13)) + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/quotebtn.gif"" border=""0"" alt=" + Chr(34) + getHashVal("main", "47") + Chr(34) + " ></a>"
                                editStr += "<a href=" + Chr(34) + siteRoot + "/?r=mi&p=" + CStr(dataRdr.Item(4)) + "&f=" + _forumID.ToString + "&m=" + CStr(dataRdr.Item(13)) + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/ignorebtn.gif"" border=""0"" alt=" + Chr(34) + getHashVal("main", "48") + Chr(34) + " ></a>"
                                editStr += "<a href=" + Chr(34) + siteRoot + "/?r=aa&f=" + _forumID.ToString + "&m=" + CStr(dataRdr.Item(13)) + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/alertbtn.gif"" border=""0"" alt=" + Chr(34) + getHashVal("main", "49") + Chr(34) + " ></a>"

                            Else
                                editStr += "<a href=" + Chr(34) + siteRoot + "/?r=q&f=" + _forumID.ToString + "&m=" + CStr(dataRdr.Item(13)) + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/quotebtn.gif"" border=""0"" alt=" + Chr(34) + getHashVal("main", "47") + Chr(34) + " ></a>"
                                If uGUID <> GUEST_GUID Then
                                    editStr += "<a href=" + Chr(34) + siteRoot + "/?r=mi&p=" + CStr(dataRdr.Item(4)) + "&f=" + _forumID.ToString + "&m=" + CStr(dataRdr.Item(13)) + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/ignorebtn.gif"" border=""0"" alt=" + Chr(34) + getHashVal("main", "48") + Chr(34) + " ></a>"
                                End If
                                editStr += "<a href=" + Chr(34) + siteRoot + "/?r=aa&f=" + _forumID.ToString + "&m=" + CStr(dataRdr.Item(13)) + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/alertbtn.gif"" border=""0"" alt=" + Chr(34) + getHashVal("main", "49") + Chr(34) + " ></a>"
                            End If

                            editStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/subjbar.gif"" height=""23"" width=""15"" />"

                            '-- message body
                            messageStr = dataRdr.Item(0)
                            '-- if a poll.. show it
                            If dataRdr.IsDBNull(21) = False Then
                                If dataRdr.Item(21) = True Then
                                    messageStr += "<br />" + getPollForm(uGUID, dataRdr.Item(13))
                                End If
                            End If

                            If uGUID = GUEST_GUID And _eu13 = False Then
                                linkIconStr = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/imbar.gif"" height=""27"" width=""10"" border=""0"">"
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/mail_off.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "6") + getHashVal("user", "21") + Chr(34) + "></a>"
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/home_off.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "9") + getHashVal("user", "21") + Chr(34) + "></a>"
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/pm_off.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "11") + getHashVal("user", "21") + Chr(34) + ">"
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/aim_off.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "14") + getHashVal("user", "21") + Chr(34) + ">"
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/icq_off.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "16") + getHashVal("user", "21") + Chr(34) + ">"
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/y_off.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "18") + getHashVal("user", "21") + Chr(34) + ">"
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/msn_off.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "20") + getHashVal("user", "21") + Chr(34) + ">"
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/imbar.gif"" height=""27"" width=""10"" border=""0"">"
                            End If

                            '-- build from template
                            Dim sbRow As New StringBuilder(templStr)
                            sbRow.Replace(vbCrLf, "")
                            sbRow.Replace("{UserName}", userStr)
                            sbRow.Replace("{UserTitle}", titleStr)
                            sbRow.Replace("{UserPosts}", postStr)
                            sbRow.Replace("{UserJoin}", joinStr)
                            sbRow.Replace("{UserLinkIcons}", linkIconStr)
                            sbRow.Replace("{ThreadInfo}", threadStr)
                            sbRow.Replace("{MessageBody}", messageStr)
                            sbRow.Replace("{ClassTag}", "msgUser")
                            sbRow.Replace("{ClassTag2}", classStr)
                            sbRow.Replace("{UserAvatar}", avatarStr)
                            sbRow.Replace("{EditControls}", editStr)
                            ltTable.Append(sbRow.ToString)

                        End While
                        dataRdr.Close()
                        dataConn.Close()
                    Else
                        Dim isIgnored As Integer = 0
                        dataConn = New SqlConnection(connStr)
                        dataCmd = New SqlCommand("TB_CheckIfIgnored", dataConn)
                        dataCmd.CommandType = CommandType.StoredProcedure
                        dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                        dataParam.Value = _messageID
                        dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                        dataParam.Value = XmlConvert.ToGuid(uGUID)
                        dataParam = dataCmd.Parameters.Add("@IID", SqlDbType.Int)
                        dataParam.Direction = ParameterDirection.Output
                        dataConn.Open()
                        dataCmd.ExecuteNonQuery()
                        isIgnored = dataCmd.Parameters("@IID").Value
                        dataConn.Close()
                        ltTable.Append("<tr><td class=""msgTopic"" align=""center"" valign=""top""><br />")
                        If isIgnored = 0 Then
                            ltTable.Append("<b>" + getHashVal("main", "50") + "</b>")
                        Else
                            ltTable.Append("<b>" + getHashVal("main", "51") + "</b><br />" + getHashVal("main", "52") + "<br />" + getHashVal("main", "53") + "<br />")
                        End If

                        ltTable.Append("<br /><a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + Chr(34) + ">" + getHashVal("main", "26") + "</a>" + getHashVal("main", "54") + "</td></tr>")

                    End If


                    If replyThread = False Then
                        ltTable.Append("<tr>")
                        ltTable.Append("<td class=""msgHead"" align=""left"">&nbsp;</td>")
                        ltTable.Append("<td class=""msgHead"" height=""20"" align=""left"" valign=""bottom"" colspan=""2"" style=""padding-top:6px;padding-bottom:3px;"">")

                        '-- who can post to the forum?
                        Select Case whopost
                            Case 1
                                ltTable.Append("<a title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=n" + Chr(34) + ">")
                                ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " /></a>&nbsp;")
                                ltTable.Append("<a title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=np" + Chr(34) + ">")
                                ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " /></a>&nbsp;")
                                If topicLocked = False Then
                                    ltTable.Append("<a title=" + Chr(34) + getHashVal("main", "1") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=r&m=" + _messageID.ToString + Chr(34) + ">")
                                    ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/replypost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "1") + Chr(34) + " /></a>&nbsp;")
                                Else
                                    ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/lockedbtn.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "39") + Chr(34) + " />&nbsp;")
                                End If

                            Case 2
                                If canModerate = True Then
                                    ltTable.Append("<a title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=n" + Chr(34) + ">")
                                    ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " /></a>&nbsp;")
                                    ltTable.Append("<a title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=np" + Chr(34) + ">")
                                    ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " /></a>&nbsp;")
                                    If topicLocked = False Then
                                        ltTable.Append("<a title=" + Chr(34) + getHashVal("main", "1") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=r&m=" + _messageID.ToString + Chr(34) + ">")
                                        ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/replypost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "1") + Chr(34) + " /></a>&nbsp;")
                                    Else
                                        ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/lockedbtn.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "39") + Chr(34) + " />&nbsp;")
                                    End If
                                Else
                                    If topicLocked = False Then
                                        ltTable.Append("<a title=" + Chr(34) + getHashVal("main", "1") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=r&m=" + _messageID.ToString + Chr(34) + ">")
                                        ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/replypost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "1") + Chr(34) + " /></a>&nbsp;")
                                    Else
                                        ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/lockedbtn.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "39") + Chr(34) + " />&nbsp;")
                                    End If
                                End If

                            Case 3
                                If canModerate = True Then
                                    ltTable.Append("<a title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=n" + Chr(34) + ">")
                                    ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "2") + Chr(34) + " /></a>&nbsp;")
                                    ltTable.Append("<a title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=np" + Chr(34) + ">")
                                    ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newpoll.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "3") + Chr(34) + " /></a>&nbsp;")
                                    If topicLocked = False Then
                                        ltTable.Append("<a title=" + Chr(34) + getHashVal("main", "1") + Chr(34) + " href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&r=r&m=" + _messageID.ToString + Chr(34) + ">")
                                        ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/replypost.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "1") + Chr(34) + " /></a>&nbsp;")
                                    Else
                                        ltTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/lockedbtn.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "39") + Chr(34) + " />&nbsp;")
                                    End If
                                End If

                        End Select
                        '-- printable
                        ltTable.Append("<a href=" + Chr(34) + siteRoot + "/pr.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + " target=""_blank""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/printable.gif"" valign=""bottom"" border=""0"" alt=" + Chr(34) + getHashVal("main", "40") + Chr(34) + " /></a>")

                        ltTable.Append("</td></tr>")

                        If iPages > 1 Then
                            ltTable.Append("<tr><td class=""msgSm"" align=""right"" colspan=""3""><b>")
                            ltTable.Append(tCount.ToString + getHashVal("main", "37") + "<br />" + getHashVal("main", "38"))
                            For i = 1 To iPages
                                If i = _currentPage Then
                                    ltTable.Append("&nbsp;<b>" + i.ToString + "</b>&nbsp;")
                                Else
                                    ltTable.Append("&nbsp;<a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&p=" + i.ToString + "&m=" + _messageID.ToString + Chr(34) + ">")
                                    ltTable.Append(i.ToString + "</a>&nbsp;")
                                End If
                            Next
                            ltTable.Append("</b></td></tr>")
                        Else
                            firstRec = 1
                            lastRec = 25
                            pagecount = 1
                        End If

                        If _eu35 = True And uGUID <> GUEST_GUID And topicLocked = False Then     '-- Show Quick Post box
                            Dim showQuick As Boolean = False
                            If (canModerate = False And (whopost = 1 Or whopost = 2)) Or canModerate = True Then
                                showQuick = True
                            End If
                            If showQuick = True Then
                                ltTable.Append("<form action=" + Chr(34) + siteRoot + "/p.aspx"" method=""post"" name=""pForm"">")
                                ltTable.Append("<input type=""hidden"" name=""r"" value=""r"" />")
                                ltTable.Append("<input type=""hidden"" name=""p"" value=""false"" />")
                                ltTable.Append("<input type=""hidden"" name=""f"" value=" + Chr(34) + _forumID.ToString + Chr(34) + " />")
                                If _messageID > 0 Then
                                    ltTable.Append("<input type=""hidden"" name=""m"" value=" + Chr(34) + _messageID.ToString + Chr(34) + " />")
                                End If
                                ltTable.Append("<tr><td class=""msgSm"" align=""left"" colspan=""6"">&nbsp;</td></tr>")
                                ltTable.Append("<tr><td class=""msgFormHead"" align=""left"" colspan=""6"" style=""padding:3px;""><b>" + getHashVal("main", "55") + "</b></td></tr>")
                                ltTable.Append("<tr>")
                                ltTable.Append("<td class=""msgUser"" align=""left"" valign=""top""><b>" + getHashVal("main", "56") + "</b><div class=""msgXsm"">" + getHashVal("main", "57") + "<br />" + getHashVal("main", "58") + "</div></td>")
                                ltTable.Append("<td class=""msgUser"" align=""left"" colspan=""5"">")
                                ltTable.Append("<textarea class=""msgFormSmTextBox"" name=""msgbody""></textarea><br />")
                                ltTable.Append("<input type=""submit"" class=""msgSmButton"" value=" + Chr(34) + getHashVal("main", "59") + Chr(34) + " />")
                                ltTable.Append("</td></tr></form>")
                            End If

                        End If

                    End If



                End If
                If i = 0 Then
                    Dim isIgnored As Integer = 0
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_CheckIfIgnored", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                    dataParam.Value = _messageID
                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                    dataParam = dataCmd.Parameters.Add("@IID", SqlDbType.Int)
                    dataParam.Direction = ParameterDirection.Output
                    dataConn.Open()
                    dataCmd.ExecuteNonQuery()
                    isIgnored = dataCmd.Parameters("@IID").Value
                    dataConn.Close()
                    ltTable.Append("<tr><td class=""msgTopic"" align=""center"" valign=""top""><br />")
                    If isIgnored = 0 Then
                        ltTable.Append("<b>" + getHashVal("main", "50") + "</b>")
                    Else
                        ltTable.Append("<b>" + getHashVal("main", "51") + "</b><br />" + getHashVal("main", "52") + "<br />" + getHashVal("main", "53") + "<br />")
                    End If

                    ltTable.Append("<br /><a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + Chr(34) + ">" + getHashVal("main", "26") + "</a>" + getHashVal("main", "54") + "</td></tr>")

                End If

            End If
            ltTable.Append("</table>")
            ltTable.Append(forumWhosOnline(_forumID, _messageID))
            ltTable.Append(printCopyright())
            Return ltTable.ToString
        End Function

        '-- creates the forum login form
        Public Function forumLoginForm() As String
            Dim lfTable As New StringBuilder("")
            If formStrLoaded = False Then
                formStrLoaded = xmlLoadStringMsg("form")
            End If
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            Try
                lfTable.Append("<form action=" + Chr(34) + siteRoot + "/l1.aspx"" method=""post"">")
                If _forumID > 0 Then
                    lfTable.Append("<input type=""hidden"" name=""f"" value=" + Chr(34) + _forumID.ToString + Chr(34) + ">")
                End If
                If _messageID > 0 Then
                    lfTable.Append("<input type=""hidden"" name=""m"" value=" + Chr(34) + _messageID.ToString + Chr(34) + ">")
                End If
                If _eu36 = False Then
                    lfTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" class=""tblStd"" width=""250"">")
                    lfTable.Append("<tr><td class=""msgTopicHead"" align=""center"" colspan=""2"">" + getHashVal("form", "74") + "</td></tr>")
                    lfTable.Append("<tr><td class=""msgTopic"" align=""right"" width=""100"">" + getHashVal("form", "15") + "</td>")
                    lfTable.Append("<td class=""msgTopic"" width=""150""><input type=""text"" name=""uName"" size=""30"" class=""msgFormInput"" maxlength=""100"" /></td></tr>")
                    lfTable.Append("<tr><td class=""msgTopic"" align=""right"">" + getHashVal("form", "16") + "</td>")
                    lfTable.Append("<td class=""msgTopic""><input type=""password"" name=""uPass"" size=""30"" class=""msgFormInput"" maxlength=""100"" /></td></tr>")
                    lfTable.Append("<tr><td class=""msgTopic"" align=""center"" colspan=""2""><input type=""submit"" value=" + Chr(34) + getHashVal("form", "63") + Chr(34) + " class=""msgSmButton"" /></td></tr>")
                    lfTable.Append("</form></table>")
                    lfTable.Append("<div class=""msgSm"" align=""center""><br />" + getHashVal("form", "75") + "&nbsp;<a href=" + Chr(34) + siteRoot + "/lf.aspx"">" + getHashVal("main", "26") + "</a>")
                Else
                    lfTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""500"">")
                    lfTable.Append("<tr><td class=""msgSm"" align=""center""><b>")
                    lfTable.Append(getHashVal("main", "156") + "</b><br /><br />")
                    lfTable.Append(getHashVal("main", "157") + "</td></tr>")
                    lfTable.Append("</form></table>")
                    lfTable.Append("<p>&nbsp;</p>")
                End If

                lfTable.Append("<p>&nbsp;</p>")
                lfTable.Append(printCopyright())
            Catch ex As Exception
                logErrorMsg("forumLoginForm<br />" + ex.StackTrace.ToString, 1)
            End Try
            Return lfTable.ToString
        End Function

        '-- no html fix
        Public Function forumNoHTMLFix(ByVal nonStr As String) As String
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

        '-- Private messages
        Public Function forumPM(ByVal uGUID As String) As String
            If pmStrLoaded = False Then
                pmStrLoaded = xmlLoadStringMsg("pm")
            End If
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If userStrLoaded = False Then
                userStrLoaded = xmlLoadStringMsg("user")
            End If
            Dim pmTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" height=""300"" >")
            If uGUID = GUEST_GUID Then
                pmTable.Append("<tr><td class=""msgSm"" align=""center"" height=""20""><br />" + getHashVal("pm", "0") + "</td></tr>")
                pmTable.Append("<tr><td >&nbsp;</td></tr></table>")
                pmTable.Append(printCopyright())
                Return pmTable.ToString
                Exit Function
            End If
            If _eu30 = False Then
                pmTable.Append("<tr><td class=""msgSm"" align=""center"" valign=""top"">")
                pmTable.Append("<br /><b>" + getHashVal("pm", "1") + "</b>")
                pmTable.Append("<br />" + getHashVal("pm", "2") + "</td></tr>")
                pmTable.Append("<tr><td >&nbsp;</td></tr></table>")
                pmTable.Append(printCopyright())
                Return pmTable.ToString
                Exit Function
            End If
            Dim pmCount As Integer = 0
            Dim pmInbox As Integer = 0
            Dim pmSent As Integer = 0
            Dim pmMax As Integer = 0
            Dim mCount As Integer = 0
            Dim pSize As Integer
            Dim iStr As String = _eu16
            Dim iSpl() As String
            Dim userStr As String = String.Empty
            Dim titleStr As String = String.Empty
            Dim postStr As String = String.Empty
            Dim joinStr As String = String.Empty
            Dim linkIconStr As String = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/imbar.gif"" height=""27"" width=""10"" border=""0"">"
            Dim threadStr As String = String.Empty
            Dim threadStr2 As String = String.Empty
            Dim messageStr As String = String.Empty
            Dim classStr As String = String.Empty
            Dim avatarStr As String = String.Empty
            Dim j As Integer = 0

            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_MyPMCount", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
            dataParam.Value = XmlConvert.ToGuid(uGUID)
            dataParam = dataCmd.Parameters.Add("@pmInbox", SqlDbType.Int)
            dataParam.Direction = ParameterDirection.Output
            dataParam = dataCmd.Parameters.Add("@pmSent", SqlDbType.Int)
            dataParam.Direction = ParameterDirection.Output
            dataParam = dataCmd.Parameters.Add("@pmCount", SqlDbType.Int)
            dataParam.Direction = ParameterDirection.Output
            dataParam = dataCmd.Parameters.Add("@pmMax", SqlDbType.Int)
            dataParam.Direction = ParameterDirection.Output
            dataParam = dataCmd.Parameters.Add("@UsePM", SqlDbType.Bit)
            dataParam.Direction = ParameterDirection.Output
            dataConn.Open()
            dataCmd.ExecuteNonQuery()
            pmCount = dataCmd.Parameters("@pmCount").Value
            pmInbox = dataCmd.Parameters("@pmInbox").Value
            pmSent = dataCmd.Parameters("@pmSent").Value
            pmMax = dataCmd.Parameters("@pmMax").Value
            _usePM = dataCmd.Parameters("@UsePM").Value
            dataConn.Close()

            pSize = 200 / pmMax

            If _usePM = False Then  '-- user disabled PM
                pmTable.Append("<tr><td class=""msgSm"" align=""center"" valign=""top"">")
                pmTable.Append("<br /><b>" + getHashVal("pm", "3") + "</b>")
                pmTable.Append("<br />" + getHashVal("pm", "4") + "</td></tr>")
                pmTable.Append("<tr><td >&nbsp;</td></tr></table>")
                pmTable.Append(printCopyright())
                Return pmTable.ToString
                Exit Function
            End If
            If _edOrDel <> "v" And _edOrDel <> "v2" Then
                pmTable.Append("<form action=" + Chr(34) + siteRoot + "/"" method=""get"" name=""bForm"">")
                pmTable.Append("<input type=""hidden"" name=""r"" value=""pm"">")
                pmTable.Append("<tr><td colspan=""2"" class=""msgFormHead"" height=""20"">" + getHashVal("pm", "5") + pmCount.ToString + getHashVal("pm", "6") + ")")
                pmTable.Append("<br /><select name=""eod"" class=""msgSm"" onchange=""bForm.submit()"">")
                pmTable.Append("<option value=""i" + Chr(34))
                If _edOrDel = String.Empty Or _edOrDel = "i" Then
                    pmTable.Append(" selected")
                End If
                pmTable.Append(">" + getHashVal("pm", "7") + "      </option>")
                pmTable.Append("<option value=""s" + Chr(34))
                If _edOrDel = "s" Then
                    pmTable.Append(" selected")
                End If
                pmTable.Append(">" + getHashVal("pm", "8") + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option></select> &nbsp; <input type=""submit"" value=" + Chr(34) + getHashVal("pm", "9") + Chr(34) + " class=""msgSmButton"">")
                pmTable.Append("</td>")
                pmTable.Append("</form>")
                pmTable.Append("<td colspan=""2"" class=""msgFormHead"" align=""right"" height=""20"">" + getHashVal("pm", "10") + (pmInbox + pmSent).ToString + getHashVal("pm", "11") + pmMax.ToString + getHashVal("pm", "12"))
                pmTable.Append("<table border=""0"" cellpadding=""2"" cellspacing=""0"" width=""200"" class=""tblStd"">")
                pmTable.Append("<tr><td class=""msgPmIn"" width=" + Chr(34) + (pmInbox * pSize).ToString + Chr(34) + " title=" + Chr(34) + getHashVal("pm", "7") + Chr(34) + " align=""center"">" + pmInbox.ToString + "</td>")
                pmTable.Append("<td class=""msgPmSent"" width=" + Chr(34) + (pmSent * pSize).ToString + Chr(34) + " title=" + Chr(34) + getHashVal("pm", "8") + Chr(34) + " align=""center"">" + pmSent.ToString + "</td>")
                pmTable.Append("<td class=""msgPmExtra"" width=" + Chr(34) + ((pmMax - (pmInbox + pmSent)) * pSize).ToString + Chr(34) + " title=" + Chr(34) + getHashVal("pm", "13") + Chr(34) + " align=""center"">" + (pmMax - (pmSent + pmInbox)).ToString + "</td></tr>")
                pmTable.Append("</table>")
                pmTable.Append("</td></tr>")
            End If


            If _edOrDel = String.Empty Or _edOrDel = "i" Or _edOrDel = "s" Then     '-- show the inbox/sentitems

                pmTable.Append("<tr><td class=""msgSmHead"" height=""20"">&nbsp;</td><td class=""msgSmHead"" colspan=""3"">")
                pmTable.Append("<input type=""button"" class=""msgButton"" value=" + Chr(34) + getHashVal("pm", "14") + Chr(34) + "  onclick=""window.location.href='" + siteRoot + "/?r=pm&eod=n';"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"">&nbsp;</td></tr>")
                pmTable.Append("<tr><td class=""msgTopicHead"" align=""center"" height=""20"" width=""100"">" + getHashVal("pm", "15") + "</td>")
                If _edOrDel = "s" Then
                    pmTable.Append("<td class=""msgTopicHead"" width=""150"">" + getHashVal("pm", "16") + "</td>")
                Else
                    pmTable.Append("<td class=""msgTopicHead"" width=""150"">" + getHashVal("pm", "17") + "</td>")
                End If

                pmTable.Append("<td class=""msgTopicHead"">" + getHashVal("pm", "18") + "</td>")
                pmTable.Append("<td class=""msgTopicHead"" align=""center"" width=""150"">" + getHashVal("pm", "19") + "</td></tr>")
                dataConn = New SqlConnection(connStr)
                If _edOrDel = "s" Then
                    dataCmd = New SqlCommand("TB_GetMySentPMs", dataConn)
                Else
                    dataCmd = New SqlCommand("TB_GetMyPMs", dataConn)
                End If
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False And dataRdr.IsDBNull(2) = False And dataRdr.IsDBNull(3) = False And dataRdr.IsDBNull(4) = False And dataRdr.IsDBNull(5) = False Then
                            mCount += 1
                            If dataRdr.Item(4) = 0 And dataRdr.Item(5) = 0 Then
                                pmTable.Append("<tr><td class=""msgTopicAnnounce"" align=""center"" height=""20"" width=""100"">")
                                If _edOrDel = "s" Then
                                    pmTable.Append("<a href=" + Chr(34) + siteRoot + "/?r=pm&m=" + CStr(dataRdr.Item(0)) + "&eod=ds" + Chr(34) + " title=" + Chr(34) + getHashVal("pm", "20") + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/smdelete.gif"" border=""0"" alt=""Delete""></a></td>")
                                Else
                                    pmTable.Append("<a href=" + Chr(34) + siteRoot + "/?r=pm&m=" + CStr(dataRdr.Item(0)) + "&eod=ri" + Chr(34) + " title=" + Chr(34) + getHashVal("pm", "21") + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/reply.gif"" border=""0"" alt=""Reply""></a> &nbsp; ")
                                    pmTable.Append("<a href=" + Chr(34) + siteRoot + "/?r=pm&m=" + CStr(dataRdr.Item(0)) + "&eod=di" + Chr(34) + " title=" + Chr(34) + getHashVal("pm", "20") + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/smdelete.gif"" border=""0"" alt=""Delete""></a></td>")
                                End If

                                pmTable.Append("<td class=""msgTopicAnnounce"" width=""150"">" + dataRdr.Item(3) + "</td>")
                                pmTable.Append("<td class=""msgTopicAnnounce""><a href=" + Chr(34) + siteRoot + "/?r=pm&m=" + CStr(dataRdr.Item(0)) + "&eod=v" + Chr(34) + " title=""Click to View"">")
                                If CStr(dataRdr.Item(1)).ToString.Trim = String.Empty Then
                                    pmTable.Append("(No Subject)</a></td>")
                                Else
                                    pmTable.Append(dataRdr.Item(1) + "</a></td>")
                                End If

                                Dim jDate As Date = dataRdr.Item(2)
                                If _eu31 <> 0 And _timeOffset = 0 Then
                                    jDate = DateAdd(DateInterval.Hour, _eu31, jDate)
                                ElseIf _timeOffset <> 0 Then
                                    jDate = DateAdd(DateInterval.Hour, _timeOffset, jDate)
                                End If
                                pmTable.Append("<td class=""msgTopicAnnounce"" align=""center"" width=""150"">" + FormatDateTime(jDate, DateFormat.GeneralDate) + "</td></tr>")
                            Else
                                pmTable.Append("<tr><td class=""msgTopic"" align=""center"" height=""20"" width=""100"">")
                                If _edOrDel = "s" Then
                                    pmTable.Append("<a href=" + Chr(34) + siteRoot + "/?r=pm&m=" + CStr(dataRdr.Item(0)) + "&eod=ds" + Chr(34) + " title=" + Chr(34) + getHashVal("pm", "20") + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/smdelete.gif"" border=""0"" alt=""Delete""></a></td>")
                                Else
                                    pmTable.Append("<a href=" + Chr(34) + siteRoot + "/?r=pm&m=" + CStr(dataRdr.Item(0)) + "&eod=ri" + Chr(34) + " title=" + Chr(34) + getHashVal("pm", "21") + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/reply.gif"" border=""0"" alt=""Reply""></a> &nbsp; ")
                                    pmTable.Append("<a href=" + Chr(34) + siteRoot + "/?r=pm&m=" + CStr(dataRdr.Item(0)) + "&eod=di" + Chr(34) + " title=" + Chr(34) + getHashVal("pm", "20") + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/smdelete.gif"" border=""0"" alt=""Delete""></a></td>")
                                End If
                                pmTable.Append("<td class=""msgTopic"" width=""150"">" + dataRdr.Item(3) + "</td>")
                                If _edOrDel = "i" Or _edOrDel = String.Empty Then
                                    pmTable.Append("<td class=""msgTopic""><a href=" + Chr(34) + siteRoot + "/?r=pm&m=" + CStr(dataRdr.Item(0)) + "&eod=v" + Chr(34) + " title=" + Chr(34) + getHashVal("pm", "22") + Chr(34) + ">")
                                    If CStr(dataRdr.Item(1)).ToString.Trim = String.Empty Then
                                        pmTable.Append(getHashVal("pm", "23") + "</a></td>")
                                    Else
                                        pmTable.Append(dataRdr.Item(1) + "</a></td>")
                                    End If
                                Else
                                    pmTable.Append("<td class=""msgTopic""><a href=" + Chr(34) + siteRoot + "/?r=pm&m=" + CStr(dataRdr.Item(0)) + "&eod=v2" + Chr(34) + " title=" + Chr(34) + getHashVal("pm", "22") + Chr(34) + ">")
                                    If CStr(dataRdr.Item(1)).ToString.Trim = String.Empty Then
                                        pmTable.Append(getHashVal("pm", "23") + "</a></td>")
                                    Else
                                        pmTable.Append(dataRdr.Item(1) + "</a></td>")
                                    End If

                                End If
                                Dim jDate As Date = dataRdr.Item(2)
                                If _eu31 <> 0 And _timeOffset = 0 Then
                                    jDate = DateAdd(DateInterval.Hour, _eu31, jDate)
                                ElseIf _timeOffset <> 0 Then
                                    jDate = DateAdd(DateInterval.Hour, _timeOffset, jDate)
                                End If
                                pmTable.Append("<td class=""msgTopic"" align=""center"" width=""150"">" + FormatDateTime(jDate, DateFormat.GeneralDate) + "</td></tr>")
                            End If
                        End If
                    End While
                    dataRdr.Close()
                    dataConn.Close()
                End If
                If mCount = 0 Then
                    pmTable.Append("<tr><td class=""msgtopic"" align=""center"" colspan=""4"" height=""20""><br /><b>" + getHashVal("pm", "24") + "</b></td></tr>")
                End If

                pmTable.Append("<tr><td colspan=""4"" class=""msgTopic"">&nbsp;</td></tr></table>")
                pmTable.Append(printCopyright())


            ElseIf _edOrDel = "di" Or _edOrDel = "ds" And _messageID > 0 Then   '-- delete message
                Dim redirURL As String = siteRoot + "/?r=pm&eod="
                If _edOrDel = "di" Then
                    redirURL += "i"
                Else
                    redirURL += "s"
                End If
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_DeleteMyPM", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataParam = dataCmd.Parameters.Add("@pType", SqlDbType.VarChar, 2)
                dataParam.Value = _edOrDel
                dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                dataParam.Value = _messageID
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                HttpContext.Current.Response.Redirect(redirURL)


            ElseIf _edOrDel = "n" Or _edOrDel = "ri" Then  '-- send new or reply

                pmTable.Append("<tr><td colspan=""4"" class=""msgSm"" height=""20"">")
                If (pmInbox + pmSent) < pmMax Then
                    pmTable.Append(forumPMForm(uGUID))
                Else        '-- exceeded mailbox max
                    pmTable.Append("<br /><b>" + Chr(34) + getHashVal("pm", "25") + "</b><br />")
                    pmTable.Append(getHashVal("pm", "26") + pmMax.ToString + getHashVal("pm", "27"))
                    pmTable.Append("<br />" + getHashVal("pm", "28") + pmMax.ToString + ".")

                End If

                pmTable.Append("</td></tr>")
                pmTable.Append("<tr><td colspan=""4"" class=""msgTopic"">&nbsp;</td></tr></table>")
                pmTable.Append(printCopyright())

            ElseIf (_edOrDel = "v" Or _edOrDel = "v2") And _messageID > 0 Then  '-- view message
                mCount = 0
                Dim templStr As String = loadTBTemplate("style-listThread.htm", defaultStyle)
                Dim i As Integer = 0
                pmTable.Append("<form action=" + Chr(34) + siteRoot + "/"" method=""get"" name=""bForm"">")
                pmTable.Append("<input type=""hidden"" name=""r"" value=""pm"">")
                pmTable.Append("<tr><td class=""msgFormHead"" height=""20"">" + getHashVal("pm", "29"))
                pmTable.Append("<br /><select name=""eod"" class=""msgSm"" onchange=""bForm.submit()"">")
                pmTable.Append("<option value=""i" + Chr(34))
                If _edOrDel = String.Empty Or _edOrDel = "i" Or _edOrDel = "v" Then
                    pmTable.Append(" selected")
                End If
                pmTable.Append(">" + getHashVal("pm", "7") + "      </option>")
                pmTable.Append("<option value=""s" + Chr(34))
                If _edOrDel = "s" Or _edOrDel = "v2" Then
                    pmTable.Append(" selected")
                End If
                pmTable.Append(">" + getHashVal("pm", "8") + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option></select> &nbsp; <input type=""submit"" value=" + Chr(34) + getHashVal("pm", "9") + Chr(34) + " class=""msgSmButton"">")
                pmTable.Append("</td>")
                pmTable.Append("<td class=""msgFormHead"" colspan=""2"" align=""right"" height=""20"">" + getHashVal("pm", "10") + (pmInbox + pmSent).ToString + getHashVal("pm", "11") + pmMax.ToString + getHashVal("pm", "12"))
                pmTable.Append("<table border=""0"" cellpadding=""2"" cellspacing=""0"" width=""200"" class=""tblStd"">")
                pmTable.Append("<tr><td class=""msgPmIn"" width=" + Chr(34) + (pmInbox * pSize).ToString + Chr(34) + " title=" + Chr(34) + getHashVal("pm", "7") + Chr(34) + " align=""center"">" + pmInbox.ToString + "</td>")
                pmTable.Append("<td class=""msgPmSent"" width=" + Chr(34) + (pmSent * pSize).ToString + Chr(34) + " title=" + Chr(34) + getHashVal("pm", "8") + Chr(34) + " align=""center"">" + pmSent.ToString + "</td>")
                pmTable.Append("<td class=""msgPmExtra"" width=" + Chr(34) + ((pmMax - (pmInbox + pmSent)) * pSize).ToString + Chr(34) + " title=" + Chr(34) + getHashVal("pm", "13") + Chr(34) + " align=""center"">" + (pmMax - (pmSent + pmInbox)).ToString + "</td></tr>")
                pmTable.Append("</table>")
                pmTable.Append("</td></tr>")
                pmTable.Append("</form>")

                pmTable.Append("<tr><td class=""msgSmHead"" height=""20"">&nbsp;</td><td class=""msgSmHead"">")
                pmTable.Append("<input type=""button"" class=""msgButton"" value=" + Chr(34) + getHashVal("pm", "14") + Chr(34) + "  onclick=""window.location.href='" + siteRoot + "/?r=pm&eod=n';"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"">&nbsp;")
                If _edOrDel = "v" Then
                    pmTable.Append("<input type=""button"" class=""msgButton"" value=" + Chr(34) + getHashVal("pm", "30") + Chr(34) + "  onclick=""window.location.href='" + siteRoot + "/?r=pm&eod=ri&m=" + _messageID.ToString + "';"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"">&nbsp;")
                    pmTable.Append("<input type=""button"" class=""msgButton"" value=" + Chr(34) + getHashVal("pm", "31") + Chr(34) + "  onclick=""window.location.href='" + siteRoot + "/?r=pm&eod=di&m=" + _messageID.ToString + "';"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"">&nbsp;")
                Else
                    pmTable.Append("<input type=""button"" class=""msgButton"" value=" + Chr(34) + getHashVal("pm", "31") + Chr(34) + "  onclick=""window.location.href='" + siteRoot + "/?r=pm&eod=ds&m=" + _messageID.ToString + "';"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"">&nbsp;")
                End If

                pmTable.Append("</td></tr>")


                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_GetPMMessage", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                dataParam.Value = _messageID
                dataParam = dataCmd.Parameters.Add("@vType", SqlDbType.VarChar, 2)
                dataParam.Value = _edOrDel
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        mCount += 1
                        '-- user name
                        userStr = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" height=""1"" width=""150""><br />"
                        If dataRdr.IsDBNull(13) = False Then
                            userStr += "<a name=""m" + CStr(dataRdr.Item(13)) + Chr(34) + " />"
                        End If
                        userStr += "<a href=" + Chr(34) + siteRoot + "/vp.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + "&p=" + CStr(dataRdr.Item(4)) + Chr(34) + ">"
                        userStr += Server.HtmlEncode(dataRdr.Item(3)) + "</a>"

                        '-- date joined
                        joinStr = "Joined "
                        If dataRdr.IsDBNull(11) = False Then
                            If IsDate(dataRdr.Item(11)) = True Then
                                Dim jDate As Date = dataRdr.Item(11)
                                joinStr += MonthName(Month(jDate), True).ToString
                                joinStr += "&nbsp;" + Year(jDate).ToString
                            End If
                        End If

                        '-- EMAIL LINK
                        If dataRdr.IsDBNull(5) = False And dataRdr.Item(6) = 1 Then
                            linkIconStr += "<a href=""mailto:" + dataRdr.Item(5) + Chr(34) + ">"
                            linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/mail_on.gif"" border=""0"" height=""27"" width=""26"" alt=" + Chr(34) + getHashVal("user", "4") + dataRdr.Item(3) + getHashVal("user", "5") + Chr(34) + "></a>"
                        Else
                            linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/mail_off.gif"" border=""0"" height=""27"" width=""26"" alt=" + Chr(34) + getHashVal("user", "6") + Chr(34) + ">"
                        End If
                        '-- HOMEPAGE LINK
                        If dataRdr.IsDBNull(7) = False Then
                            If dataRdr.Item(7) <> String.Empty And LCase(dataRdr.Item(7)) <> "http://" Then
                                linkIconStr += "<a href=" + Chr(34) + dataRdr.Item(7) + Chr(34) + " target=""_blank"">"
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/home_on.gif"" border=""0"" height=""27"" width=""22"" alt=" + Chr(34) + getHashVal("user", "7") + dataRdr.Item(3) + getHashVal("user", "8") + Chr(34) + "></a>"
                            Else
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/home_off.gif"" border=""0"" height=""27"" width=""22"" alt=" + Chr(34) + getHashVal("user", "9") + Chr(34) + ">"
                            End If
                        Else
                            linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/home_off.gif"" border=""0"" height=""27"" width=""22"" alt=" + Chr(34) + getHashVal("user", "9") + Chr(34) + ">"
                        End If
                        '-- AIM BUDDY LIST
                        If dataRdr.IsDBNull(8) = False Then
                            If CStr(dataRdr.Item(8)).Trim <> String.Empty Then
                                linkIconStr += "<a href=""aim:addbuddy?screenname=" + dataRdr.Item(8) + Chr(34) + ">"
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/aim_on.gif"" border=""0"" height=""27"" width=""25"" alt=" + Chr(34) + getHashVal("user", "12") + dataRdr.Item(3) + getHashVal("user", "13") + Chr(34) + "></a>"
                            Else
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/aim_off.gif"" border=""0"" height=""27"" width=""25"" alt=" + Chr(34) + getHashVal("user", "14") + Chr(34) + ">"
                            End If
                        Else
                            linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/aim_off.gif"" border=""0"" height=""27"" width=""25"" alt=" + Chr(34) + getHashVal("user", "14") + Chr(34) + ">"
                        End If
                        '-- ICQ LIST
                        If dataRdr.IsDBNull(9) = False Then
                            If dataRdr.Item(9) > 0 Then
                                linkIconStr += "<a href=""http://wwp.icq.com/scripts/search.dll?to=" + CStr(dataRdr.Item(9)) + Chr(34) + ">"
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/icq_on.gif"" border=""0"" height=""27"" width=""22"" alt=" + Chr(34) + getHashVal("user", "12") + dataRdr.Item(3) + getHashVal("user", "15") + Chr(34) + "></a>"
                            Else
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/icq_off.gif"" border=""0"" height=""27"" width=""22"" alt=" + Chr(34) + getHashVal("user", "16") + Chr(34) + ">"
                            End If
                        Else
                            linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/icq_off.gif"" border=""0"" height=""27"" width=""22"" alt=" + Chr(34) + getHashVal("user", "16") + Chr(34) + ">"
                        End If

                        '-- Y!
                        If dataRdr.IsDBNull(15) = False Then
                            If CStr(dataRdr.Item(15)).Trim <> String.Empty Then
                                Dim buddyStr As String = "http://edit.yahoo.com/config/set_buddygrp?.src=&.cmd=a&.bg=Friends&.bdl="
                                buddyStr += dataRdr.Item(15)
                                buddyStr += "&.done=" + Server.UrlEncode(siteURL)
                                linkIconStr += "<a href=" + Chr(34) + buddyStr + Chr(34) + " target=""_blank"">"
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/y_on.gif"" border=""0"" height=""27"" width=""22"" alt=" + Chr(34) + getHashVal("user", "12") + dataRdr.Item(15) + getHashVal("user", "17") + Chr(34) + "></a>"
                            Else
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/y_off.gif"" border=""0"" height=""27"" width=""22"" alt=" + Chr(34) + getHashVal("user", "18") + Chr(34) + ">"
                            End If
                        Else
                            linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/y_off.gif"" border=""0"" height=""27"" width=""22"" alt=" + Chr(34) + getHashVal("user", "18") + Chr(34) + ">"
                        End If

                        '-- MSN, TO PROFILE
                        If dataRdr.IsDBNull(14) = False Then
                            If CStr(dataRdr.Item(14)).Trim <> String.Empty Then
                                linkIconStr += "<a href=" + Chr(34) + siteRoot + "/vp.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + "&p=" + CStr(dataRdr.Item(4)) + Chr(34) + ">"
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/msn_on.gif"" border=""0"" height=""27"" width=""26"" alt=" + Chr(34) + getHashVal("user", "12") + dataRdr.Item(14) + getHashVal("user", "19") + Chr(34) + "></a>"
                            Else
                                linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/msn_off.gif"" border=""0"" height=""27"" width=""26"" alt=" + Chr(34) + getHashVal("user", "20") + Chr(34) + ">"
                            End If
                        Else
                            linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/msn_off.gif"" border=""0"" height=""27"" width=""26"" alt=" + Chr(34) + getHashVal("user", "20") + Chr(34) + ">"
                        End If

                        linkIconStr += "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/imbar.gif"" height=""27"" width=""10"" border=""0"">"


                        If i Mod 2 = 0 Then
                            classStr = "msgThread1"
                        Else
                            classStr = "msgThread2"
                        End If
                        If dataRdr.IsDBNull(18) = False Then
                            threadStr = "<b>" + dataRdr.Item(18) + "</b>"
                        End If
                        threadStr2 = getHashVal("pm", "32")
                        threadStr2 += FormatDateTime(dataRdr.Item(1), DateFormat.LongDate)
                        threadStr2 += "&nbsp;-&nbsp;" + FormatDateTime(dataRdr.Item(1), DateFormat.LongTime)
                        threadStr2 += "&nbsp;&nbsp;&nbsp;"
                        threadStr2 += "</div><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" height=""5"" width=""300""><br />"
                        messageStr = dataRdr.Item(0)
                        messageStr += "<br />&nbsp;"

                        '-- build from template
                        Dim sbRow As New StringBuilder(templStr)
                        sbRow.Replace(vbCrLf, "")
                        sbRow.Replace("{UserName}", userStr)
                        sbRow.Replace("{UserTitle}", titleStr)
                        sbRow.Replace("{UserPosts}", postStr)
                        sbRow.Replace("{UserJoin}", joinStr)
                        sbRow.Replace("{UserLinkIcons}", linkIconStr)
                        sbRow.Replace("{ThreadInfo}", threadStr)
                        sbRow.Replace("{MessageBody}", messageStr)
                        sbRow.Replace("{ClassTag}", "msgUser")
                        sbRow.Replace("{ClassTag2}", classStr)
                        sbRow.Replace("{UserAvatar}", avatarStr)
                        sbRow.Replace("{EditControls}", threadStr2)
                        pmTable.Append(sbRow.ToString)


                    End While
                    dataRdr.Close()
                    dataConn.Close()
                End If
                pmTable.Append("<tr><td colspan=""3"" class=""msgTopic"">&nbsp;</td></tr></table>")
                pmTable.Append(printCopyright())
            End If
            Return pmTable.ToString
        End Function

        '-- returns a form used for new, reply or edit posting
        Public Function forumPoll(ByVal uGUID As String) As String
            Dim eSubject As String = String.Empty
            Dim eBody As String = String.Empty
            Dim eIsParent As Boolean = False
            Dim ePostIcon As String = _postIcon
            Dim quoteName As String = String.Empty
            Dim parentID As Integer = 0
            Dim isModerator As Boolean = False

            If formStrLoaded = False Then
                formStrLoaded = xmlLoadStringMsg("form")
            End If
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If

            If _loadForm = "em" Then
                _loadForm = "e"
                isModerator = True
            End If
            If _loadForm = "dm" Then
                _loadForm = "d"
                isModerator = True
            End If
            If _loadForm = "ddm" Then
                _loadForm = "dd"
                isModerator = True
            End If
            If isModerator = False Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_GetCanModerate", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataParam = dataCmd.Parameters.Add("@CanModerate", SqlDbType.Bit)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                isModerator = dataCmd.Parameters("@CanModerate").Value
                dataConn.Close()
            End If

            Dim ntTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
            uGUID = checkValidGUID(uGUID)
            If checkForumActive() = False Then  '-- check if disabled  : new in v2.1
                ntTable.Append("<tr><td class=""msgTopic"" align=""center"" height=""400"" valign=""top""><br /><b>" + getHashVal("main", "162") + "</b><br /><br />")
                ntTable.Append("</td></tr>")

            ElseIf checkForumAccess(uGUID, _forumID) = False Then
                ntTable.Append("<tr><td class=""msgTopic"" align=""center"" height=""400"" valign=""top""><br /><b>" + getHashVal("main", "24") + "</b><br /><br />")
                If uGUID = GUEST_GUID Then
                    ntTable.Append("<a href=" + Chr(34) + siteRoot + "/l.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">")
                    ntTable.Append(getHashVal("main", "26") + "</a>" + getHashVal("main", "27"))
                End If
                ntTable.Append("</td></tr>")

            ElseIf uGUID = GUEST_GUID Then    '-- guest user, no posting as guest allowed
                ntTable.Append("<tr><td class=""msgTopic"" align=""center"" height=""400"" valign=""top""><br /><b>" + getHashVal("form", "37") + "</b><br /><br />" + getHashVal("form", "38") + "<br /><a href=")
                ntTable.Append(Chr(34) + siteRoot + "/l.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">")
                ntTable.Append(getHashVal("main", "26") + "</a>" + getHashVal("main", "27") + "<br /><br />" + getHashVal("form", "39") + "<br /><a href=")
                ntTable.Append(Chr(34) + siteRoot + "/r.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">")
                ntTable.Append(getHashVal("main", "26") + "</a>" + getHashVal("form", "40"))
                ntTable.Append("</td></tr>")
            Else
                '--- Anti-spam timer check...
                Dim lastTime As Date = DateTime.UtcNow
                Dim curTime As Date = DateTime.UtcNow
                Dim timeLapse As Integer = 0
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_GetLastPostTime", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataParam = dataCmd.Parameters.Add("@LastPostDate", SqlDbType.DateTime)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                lastTime = dataCmd.Parameters("@LastPostDate").Value
                dataConn.Close()
                If IsDate(lastTime) = True Then
                    timeLapse = DateDiff(DateInterval.Second, lastTime, curTime)
                    If timeLapse < _eu11 Then
                        ntTable.Append("<tr><td class=""msgSm"" align=""center"" valign=""top"">")
                        ntTable.Append("<br /><b>" + getHashVal("form", "41") + "</b><br />")
                        ntTable.Append(getHashVal("form", "42") + _eu11.ToString + getHashVal("form", "43") + "<br /><br />")
                        ntTable.Append("<a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">")
                        ntTable.Append(getHashVal("main", "26") + "</a>" + getHashVal("main", "54") + "<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p></td></tr></table><p>&nbsp;</p>")
                        ntTable.Append("<br />" + getHashVal("form", "44") + lastTime.ToString + " GMT<br />")
                        ntTable.Append(getHashVal("form", "45") + curTime.ToString + " GMT<br />")

                        ntTable.Append(printCopyright())
                        Return ntTable.ToString
                        Exit Function
                    End If
                End If

                eSubject = _formSubj
                eBody = _formBody
                eIsParent = _formParent
                ePostIcon = _postIcon
                ntTable.Append("<script src=" + Chr(34) + siteRoot + "/js/TBform.js""></script>")
                ntTable.Append("<tr><td class=""msgFormTitle"" width=""165""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" width=""165"" height=""10""></td><td class=""msgFormTitle"" width=""100%"">")
                ntTable.Append(UCase(getHashVal("main", "3")) + "<div class=""msgSm"">" + getHashVal("form", "76") + "</div>")
                ntTable.Append("</td></tr>")
                ntTable.Append("<form action=" + Chr(34) + siteRoot + "/p.aspx"" method=""post"" name=""pForm"">")
                ntTable.Append("<input type=""hidden"" name=""r"" value=" + Chr(34) + _loadForm.ToLower + Chr(34) + " />")
                ntTable.Append("<input type=""hidden"" name=""f"" value=" + Chr(34) + _forumID.ToString + Chr(34) + " />")
                ntTable.Append("<input type=""hidden"" name=""am"" value=" + Chr(34) + isModerator.ToString + Chr(34) + " />")
                If _messageID > 0 Then
                    ntTable.Append("<input type=""hidden"" name=""m"" value=" + Chr(34) + _messageID.ToString + Chr(34) + " />")
                    ntTable.Append("<input type=""hidden"" name=""p"" value=" + Chr(34) + eIsParent.ToString + Chr(34) + " />")
                End If

                '-- Post Icons
                If _eu6 = True Then
                    ntTable.Append("<tr><td class=""msgFormDesc"" align=""right"">" + getHashVal("form", "46") + "</td>")
                    ntTable.Append("<td class=""msgFormBody"">")
                    Dim iNum As Integer = 0
                    Dim iStr As String = String.Empty
                    For iNum = 0 To 7
                        iStr = "icon" + iNum.ToString
                        If ePostIcon = iStr Then
                            ntTable.Append("<input type=""radio"" name=""posticon"" value=" + Chr(34) + iStr + Chr(34) + " checked> <img src=" + Chr(34) + siteRoot + "/posticons/" + iStr + ".gif"" border=""0"" height=""15"" width=""15"">")
                        Else
                            ntTable.Append("<input type=""radio"" name=""posticon"" value=" + Chr(34) + iStr + Chr(34) + "> <img src=" + Chr(34) + siteRoot + "/posticons/" + iStr + ".gif"" border=""0"" height=""15"" width=""15"">")
                        End If
                    Next
                    ntTable.Append("<br />")
                    For iNum = 8 To 14
                        iStr = "icon" + iNum.ToString
                        If ePostIcon = iStr Then
                            ntTable.Append("<input type=""radio"" name=""posticon"" value=" + Chr(34) + iStr + Chr(34) + " checked> <img src=" + Chr(34) + siteRoot + "/posticons/" + iStr + ".gif"" border=""0"" height=""15"" width=""15"">")
                        Else
                            ntTable.Append("<input type=""radio"" name=""posticon"" value=" + Chr(34) + iStr + Chr(34) + "> <img src=" + Chr(34) + siteRoot + "/posticons/" + iStr + ".gif"" border=""0"" height=""15"" width=""15"">")
                        End If
                    Next
                    If ePostIcon = String.Empty Then
                        ntTable.Append("<input type=""radio"" name=""posticon"" value=""none"" checked>" + getHashVal("form", "47"))
                    Else
                        ntTable.Append("<input type=""radio"" name=""posticon"" value=""none"">" + getHashVal("form", "47"))
                    End If
                    ntTable.Append("</td></tr>")
                End If

                '-- End Post Icons

                '-- message subject
                ntTable.Append("<tr><td class=""msgFormDesc"" align=""right"" width=""165"">" + getHashVal("form", "48") + "</td>")
                ntTable.Append("<td class=""msgFormBody""><input type=""text"" onblur=""document.pForm.msgbody.focus();"" value=" + Chr(34) + eSubject.ToString.Trim + Chr(34) + " size=""30"" class=""msgFormInput"" name=""frmSubject"" maxLength=""50""></td></tr>")


                '-- Message  Body
                If _eu5 = True Then '-- if mCode enabled
                    ntTable.Append(forumFormButtons())

                Else
                    ntTable.Append("<tr><td class=""msgFormDesc"" align=""right"" valign=""top""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" height=""6""  width=""165"" /><br />")
                    ntTable.Append(getHashVal("form", "49") + "<br /><br />" + getHashVal("form", "52") + "<br /><br />")
                    If _eu7 = True Then
                        ntTable.Append(forumEmoticonMini())
                    End If
                    ntTable.Append("</td>")
                    ntTable.Append("<td class=""msgFormBody"" valign=""top"" width=""100%"">")
                End If
                ntTable.Append("<textarea class=""msgFormTextBox"" name=""msgbody"" tabindex=""2"" rows=""20"">" + eBody.ToString.Trim + "</textarea>")
                ntTable.Append("</td></tr>")

                '-- poll values
                ntTable.Append("<tr><td class=""msgFormDesc"" align=""right"" valign=""top"" width=""165"">" + getHashVal("form", "77") + "</td>")
                ntTable.Append("<td class=""msgFormBody"" valign=""bottom"">")
                Dim pl As Integer = 0
                For pl = 1 To 6
                    ntTable.Append(getHashVal("form", "78") + pl.ToString + " : <input type=""text"" name=""pv" + pl.ToString + Chr(34) + " class=""msgFormInput"" maxlength=""150"" ")
                    Select Case pl
                        Case 1
                            ntTable.Append("value=" + Chr(34) + _pv1 + Chr(34))
                        Case 2
                            ntTable.Append("value=" + Chr(34) + _pv2 + Chr(34))
                        Case 3
                            ntTable.Append("value=" + Chr(34) + _pv3 + Chr(34))
                        Case 4
                            ntTable.Append("value=" + Chr(34) + _pv4 + Chr(34))
                        Case 5
                            ntTable.Append("value=" + Chr(34) + _pv5 + Chr(34))
                        Case 6
                            ntTable.Append("value=" + Chr(34) + _pv6 + Chr(34))
                    End Select
                    ntTable.Append("><br />")
                Next

                ntTable.Append("</td></tr>")

                '-- Post Options
                ntTable.Append("<tr><td class=""msgFormDesc"" align=""right"" valign=""top"" width=""165""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" height=""4"" width=""50""><br />" + getHashVal("form", "53") + "</td>")
                ntTable.Append("<td class=""msgFormBody"" valign=""top"">")
                '------------------------------
                '-- moderator only post options
                If isModerator = True Then
                    If getAdminMenuAccess(26, uGUID) = True Then     '-- can lock thread
                        If _formLock = True Then
                            ntTable.Append("<input type=""checkbox"" name=""fml"" value=""1"" checked>" + getHashVal("form", "54") + "<br />")
                        Else
                            ntTable.Append("<input type=""checkbox"" value=""1"" name=""fml"">" + getHashVal("form", "54") + "<br />")
                        End If
                    End If
                    If getAdminMenuAccess(9, uGUID) = True Then     '-- can make sticky
                        If _formSticky = True Then
                            ntTable.Append("<input type=""checkbox"" value=""1"" name=""fms"" checked>" + getHashVal("form", "55") + "<br />")
                        Else
                            ntTable.Append("<input type=""checkbox"" value=""1"" name=""fms"">" + getHashVal("form", "55") + "<br />")
                        End If
                    End If
                End If

                If _eu8 = True Then
                    If checkForumSubscribe(uGUID) = False Then
                        If _formMail = True Then
                            ntTable.Append("<input type=""checkbox"" name=""nmail"" checked>" + getHashVal("form", "56") + "<br />")
                        Else
                            ntTable.Append("<input type=""checkbox"" name=""nmail"">" + getHashVal("form", "56") + "<br />")
                        End If
                    Else
                        ntTable.Append("<input type=""checkbox"" name=""mNull"" value=""1"" checked disabled>" + getHashVal("form", "57") + "<br />")
                        ntTable.Append("<input type=""hidden"" name=""nmail"" value="""">")
                    End If
                Else
                    ntTable.Append("&nbsp;&nbsp;*&nbsp;&nbsp;" + getHashVal("form", "58") + "<br />")
                    ntTable.Append("<input type=""hidden"" name=""nmail"" value="""">")
                End If

                If _eu23 = True Then
                    If _formSig = True Then
                        ntTable.Append("<input type=""checkbox"" name=""sig"" checked>" + getHashVal("form", "59") + "<br />")
                    Else
                        ntTable.Append("<input type=""checkbox"" name=""sig"">" + getHashVal("form", "59") + "<br />")
                    End If
                Else
                    ntTable.Append("&nbsp;&nbsp;*&nbsp;&nbsp;" + getHashVal("form", "60") + "<br />")
                End If

                ntTable.Append("<input type=""checkbox"" name=""preview"">" + getHashVal("form", "61") + "<br />")
                ntTable.Append("</td></tr>")

                '-- Post buttons
                ntTable.Append("<tr><td class=""msgFormDesc"" align=""right"" valign=""top"">&nbsp;</td>")
                ntTable.Append("<td class=""msgFormDesc"" valign=""top"">")
                ntTable.Append("<input type=""button"" class=""msgButton"" value=" + Chr(34) + getHashVal("form", "63") + Chr(34) + " title=""Submit (Alt+S)"" name=""btnSubmit"" onclick=""JavaScript:postForm();"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"" accesskey=""s"">&nbsp;")
                If parentID > 0 Then
                    ntTable.Append("<input type=""button"" class=""msgButton"" title=" + Chr(34) + getHashVal("form", "64") + " (Alt+X)"" value=" + Chr(34) + getHashVal("form", "64") + Chr(34) + " name=""btnCancel"" onclick=""window.location.href='" + siteRoot + "/?f=" + _forumID.ToString + "&m=" + parentID.ToString + "';"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"" accesskey=""x"">")
                Else
                    ntTable.Append("<input type=""button"" class=""msgButton"" title=" + Chr(34) + getHashVal("form", "64") + " (Alt+X)"" value=" + Chr(34) + getHashVal("form", "64") + Chr(34) + " name=""btnCancel"" onclick=""window.location.href='" + siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + "';"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"" accesskey=""x"">")
                End If

                ntTable.Append("</td></form></tr>")
                If _loadForm.ToLower = "r" Then
                    ntTable.Append("<tr><td colspan=""2"" class=""msgMd""><br /><b>" + getHashVal("form", "66") + "</b>")
                    ntTable.Append(forumListThread(uGUID, True))
                    ntTable.Append("</td</tr>")
                End If
                ntTable.Append("<script language=javascript>" + vbCrLf)
                ntTable.Append("<!--" + vbCrLf)
                ntTable.Append("document.pForm.frmSubject.focus();" + vbCrLf)
                ntTable.Append("-->" + vbCrLf)
                ntTable.Append("</script>" + vbCrLf)

            End If
            ntTable.Append("</table>")

            If _loadForm <> "r" Then
                ntTable.Append(printCopyright())
            End If

            Return ntTable.ToString
        End Function

        '-- process the form posting
        Public Function forumPostForm(ByVal uGUID As String) As String

            Dim hBody As String = String.Empty
            Dim hSubj As String = String.Empty
            Dim uSig As String = String.Empty
            Dim isModerator As Boolean = False
            Dim ntTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")

            If formStrLoaded = False Then
                formStrLoaded = xmlLoadStringMsg("form")
            End If
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If

            Try
                uGUID = checkValidGUID(uGUID)
                
                If checkForumActive() = False Then  '-- check if disabled  : new in v2.1                    
                    ntTable.Append("<tr><td class=""msgTopic"" align=""center"" height=""400"" valign=""top""><br /><b>" + getHashVal("main", "162") + "</b><br /><br />")
                    ntTable.Append("</td></tr>")
                ElseIf checkForumAccess(uGUID, _forumID) = False Then
                    ntTable.Append("<tr><td class=""msgTopic"" align=""center"" height=""400"" valign=""top""><br /><b>" + getHashVal("main", "24") + "</b><br /><br /><a href=")
                    ntTable.Append(Chr(34) + siteRoot + "/l.aspx?f=" + _forumID.ToString + Chr(34) + ">")
                    ntTable.Append(getHashVal("main", "26") + "</a>" + getHashVal("main", "27") + "</td></tr>")
                ElseIf uGUID = GUEST_GUID Then    '-- guest user, no posting as guest allowed                    
                    ntTable.Append("<tr><td class=""msgTopic"" align=""center"" height=""400"" valign=""top""><br /><b>" + getHashVal("form", "37") + "</b><br /><br />" + getHashVal("form", "38") + "<br /><a href=")
                    ntTable.Append(Chr(34) + siteRoot + "/l.aspx?f=" + _forumID.ToString + Chr(34) + ">")
                    ntTable.Append(getHashVal("main", "26") + "</a>" + getHashVal("main", "27") + "<br /><br />" + getHashVal("form", "39") + "<br /><a href=")
                    ntTable.Append(Chr(34) + siteRoot + "/l.aspx?f=" + _forumID.ToString + Chr(34) + ">")
                    ntTable.Append(getHashVal("main", "26") + "</a>" + getHashVal("form", "40"))
                    ntTable.Append("</td></tr>")
                Else
                    
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_GetCanModerate", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                    dataParam.Value = _forumID
                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                    dataParam = dataCmd.Parameters.Add("@CanModerate", SqlDbType.Bit)
                    dataParam.Direction = ParameterDirection.Output
                    dataConn.Open()
                    dataCmd.ExecuteNonQuery()
                    isModerator = dataCmd.Parameters("@CanModerate").Value
                    dataConn.Close()
                    
                    Dim processForm As Boolean = True
                    Dim subjErr As Boolean = False
                    Dim bodyErr As Boolean = False

                    '-- require subject on new posts
                    If _loadForm.ToString.ToLower = "n" Then
                        If _formSubj.ToString.Trim = String.Empty Then
                            subjErr = True
                            processForm = False
                        Else
                            hSubj = forumNoHTMLFix(_formSubj)
                        End If
                    End If
                    '-- requires message body
                    If _formBody.ToString.Trim = String.Empty Then
                        bodyErr = True
                        processForm = False
                    Else
                        hBody = forumNoHTMLFix(_formBody)
                        _pv1 = forumNoHTMLFix(_pv1)
                        _pv2 = forumNoHTMLFix(_pv2)
                        _pv3 = forumNoHTMLFix(_pv3)
                        _pv4 = forumNoHTMLFix(_pv4)
                        _pv5 = forumNoHTMLFix(_pv5)
                        _pv6 = forumNoHTMLFix(_pv6)
                    End If

                    If processForm = True Then
                        ntTable.Append("<tr><td class=""msgSm"">")
                        If _formPreview = True Then
                            ntTable.Append("<div class=""msgSm""><b>" + getHashVal("form", "114") + "</b><hr size=""1"" noshade />")
                            If _eu5 = True Then
                                If _loadForm.ToLower = "np" Then
                                    ntTable.Append(forumTBTagToHTML(hBody, uGUID))
                                    ntTable.Append("<br /><br /><b>Poll Choices<ul>")
                                    If _pv1 <> "" Then
                                        ntTable.Append("<li>" + _pv1 + "</li>")
                                    End If
                                    If _pv2 <> "" Then
                                        ntTable.Append("<li>" + _pv2 + "</li>")
                                    End If
                                    If _pv3 <> "" Then
                                        ntTable.Append("<li>" + _pv3 + "</li>")
                                    End If
                                    If _pv4 <> "" Then
                                        ntTable.Append("<li>" + _pv4 + "</li>")
                                    End If
                                    If _pv5 <> "" Then
                                        ntTable.Append("<li>" + _pv5 + "</li>")
                                    End If
                                    If _pv6 <> "" Then
                                        ntTable.Append("<li>" + _pv6 + "</li>")
                                    End If

                                    ntTable.Append("</ul></div><hr size=""1"" noshade /><table border=""0"" cellpadding=""0"" cellspacing=""0"" width=""100%""><tr><td class=""msgSm"">")
                                Else
                                    ntTable.Append(forumTBTagToHTML(hBody, uGUID) + "</td></tr></table></div><hr size=""1"" noshade />")
                                End If

                            Else
                                ntTable.Append(hBody + "</div><hr size=""1"" noshade />")
                            End If

                            '-- choose between post or poll
                            If _loadForm.ToLower = "np" Then
                                ntTable.Append(forumPoll(uGUID))
                            Else
                                ntTable.Append(forumForm(uGUID))
                            End If

                        Else
                            If _eu5 = True Then
                                hBody = forumTBTagToHTML(hBody, uGUID)
                                If _loadForm.ToLower = "np" Then
                                    _pv1 = forumTBTagToHTML(_pv1, uGUID)
                                    _pv2 = forumTBTagToHTML(_pv2, uGUID)
                                    _pv3 = forumTBTagToHTML(_pv3, uGUID)
                                    _pv4 = forumTBTagToHTML(_pv4, uGUID)
                                    _pv5 = forumTBTagToHTML(_pv5, uGUID)
                                    _pv6 = forumTBTagToHTML(_pv6, uGUID)
                                End If
                            End If
                            If _formSig = True Then
                                
                                dataConn = New SqlConnection(connStr)
                                dataCmd = New SqlCommand("TB_GetSignature", dataConn)
                                dataCmd.CommandType = CommandType.StoredProcedure
                                dataCmd.Parameters.Clear()
                                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                                dataParam.Value = XmlConvert.ToGuid(uGUID)
                                dataConn.Open()
                                dataRdr = dataCmd.ExecuteReader()
                                If dataRdr.IsClosed = False Then
                                    While dataRdr.Read
                                        '-- fixed in v2.1 : missing null check
                                        If dataRdr.IsDBNull(0) = False Then
                                            uSig = dataRdr.Item(0)
                                        End If
                                    End While
                                    dataRdr.Close()
                                    dataConn.Close()
                                End If
                            End If

                            Select Case _loadForm.ToLower
                                Case "n"        '-- new post
                                    dataConn = New SqlConnection(connStr)
                                    dataCmd = New SqlCommand("TB_AddNewTopic", dataConn)
                                    dataCmd.CommandType = CommandType.StoredProcedure
                                    dataParam = dataCmd.Parameters.Add("@forumid", SqlDbType.Int)
                                    dataParam.Value = _forumID
                                    dataParam = dataCmd.Parameters.Add("@MessageTitle", SqlDbType.VarChar, 100)
                                    dataParam.Value = Left(_formSubj, 100)       '-- trim to 100 char max
                                    dataParam = dataCmd.Parameters.Add("@NotifyUser", SqlDbType.Int)
                                    If _formMail = True Then
                                        dataParam.Value = 1
                                    Else
                                        dataParam.Value = 0
                                    End If
                                    dataParam = dataCmd.Parameters.Add("@PostIcon", SqlDbType.VarChar, 50)
                                    dataParam.Value = _postIcon
                                    dataParam = dataCmd.Parameters.Add("@PostIPAddr", SqlDbType.VarChar, 50)
                                    dataParam.Value = _userIP
                                    dataParam = dataCmd.Parameters.Add("@MessageText", SqlDbType.Text)
                                    If uSig <> String.Empty Then
                                        dataParam.Value = hBody + "<p>&nbsp;</p><p><hr size=""1"" width=""50%"" align=""left"" />" + uSig + "</p>"
                                    Else
                                        dataParam.Value = hBody
                                    End If
                                    dataParam = dataCmd.Parameters.Add("@EditText", SqlDbType.Text)
                                    dataParam.Value = _formBody
                                    dataParam = dataCmd.Parameters.Add("@userGUID", SqlDbType.UniqueIdentifier)
                                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                                    dataParam = dataCmd.Parameters.Add("@MessID", SqlDbType.Int)
                                    dataParam.Direction = ParameterDirection.Output
                                    dataConn.Open()
                                    dataCmd.ExecuteNonQuery()
                                    _messageID = dataCmd.Parameters("@MessID").Value
                                    dataConn.Close()
                                    If _formSticky = True Then
                                        dataConn = New SqlConnection(connStr)
                                        dataCmd = New SqlCommand("TB_ADMIN_MakeSticky", dataConn)
                                        dataCmd.CommandType = CommandType.StoredProcedure
                                        dataParam = dataCmd.Parameters.Add("@messageid", SqlDbType.Int)
                                        dataParam.Value = _messageID
                                        dataConn.Open()
                                        dataCmd.ExecuteNonQuery()
                                        dataConn.Close()
                                    End If
                                    If _formLock = True Then
                                        dataConn = New SqlConnection(connStr)
                                        dataCmd = New SqlCommand("TB_ADMIN_LockThread", dataConn)
                                        dataCmd.CommandType = CommandType.StoredProcedure
                                        dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                                        dataParam.Value = _forumID
                                        dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                                        dataParam.Value = _messageID
                                        dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                                        dataParam.Value = XmlConvert.ToGuid(uGUID)
                                        dataConn.Open()
                                        dataCmd.ExecuteNonQuery()
                                        dataConn.Close()
                                    End If
                                    Call forumPostNotification(_forumID, _messageID, _messageID, uGUID)
                                    Return siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString

                                Case "np"        '-- new poll
                                    dataConn = New SqlConnection(connStr)
                                    dataCmd = New SqlCommand("TB_AddNewPollTopic", dataConn)
                                    dataCmd.CommandType = CommandType.StoredProcedure
                                    dataParam = dataCmd.Parameters.Add("@forumid", SqlDbType.Int)
                                    dataParam.Value = _forumID
                                    dataParam = dataCmd.Parameters.Add("@MessageTitle", SqlDbType.VarChar, 100)
                                    dataParam.Value = Left(_formSubj, 100)       '-- trim to 100 char max
                                    dataParam = dataCmd.Parameters.Add("@NotifyUser", SqlDbType.Int)
                                    If _formMail = True Then
                                        dataParam.Value = 1
                                    Else
                                        dataParam.Value = 0
                                    End If
                                    dataParam = dataCmd.Parameters.Add("@PostIcon", SqlDbType.VarChar, 50)
                                    dataParam.Value = _postIcon
                                    dataParam = dataCmd.Parameters.Add("@PostIPAddr", SqlDbType.VarChar, 50)
                                    dataParam.Value = _userIP
                                    dataParam = dataCmd.Parameters.Add("@MessageText", SqlDbType.Text)
                                    If uSig <> String.Empty Then
                                        dataParam.Value = hBody + "<p>&nbsp;</p><p><hr size=""1"" width=""50%"" align=""left"" />" + uSig + "</p>"
                                    Else
                                        dataParam.Value = hBody
                                    End If
                                    dataParam = dataCmd.Parameters.Add("@EditText", SqlDbType.Text)
                                    dataParam.Value = _formBody
                                    dataParam = dataCmd.Parameters.Add("@userGUID", SqlDbType.UniqueIdentifier)
                                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                                    dataParam = dataCmd.Parameters.Add("@MessID", SqlDbType.Int)
                                    dataParam.Direction = ParameterDirection.Output
                                    dataConn.Open()
                                    dataCmd.ExecuteNonQuery()
                                    _messageID = dataCmd.Parameters("@MessID").Value
                                    dataConn.Close()

                                    '-- add poll choices
                                    dataConn = New SqlConnection(connStr)
                                    dataCmd = New SqlCommand("TB_AddPollValues", dataConn)
                                    dataCmd.CommandType = CommandType.StoredProcedure
                                    dataParam = dataCmd.Parameters.Add("@messageid", SqlDbType.Int)
                                    dataParam.Value = _messageID
                                    dataParam = dataCmd.Parameters.Add("@pv1", SqlDbType.VarChar, 150)
                                    dataParam.Value = _pv1
                                    dataParam = dataCmd.Parameters.Add("@pv2", SqlDbType.VarChar, 150)
                                    dataParam.Value = _pv2
                                    dataParam = dataCmd.Parameters.Add("@pv3", SqlDbType.VarChar, 150)
                                    dataParam.Value = _pv3
                                    dataParam = dataCmd.Parameters.Add("@pv4", SqlDbType.VarChar, 150)
                                    dataParam.Value = _pv4
                                    dataParam = dataCmd.Parameters.Add("@pv5", SqlDbType.VarChar, 150)
                                    dataParam.Value = _pv5
                                    dataParam = dataCmd.Parameters.Add("@pv6", SqlDbType.VarChar, 150)
                                    dataParam.Value = _pv6
                                    dataConn.Open()
                                    dataCmd.ExecuteNonQuery()
                                    dataConn.Close()

                                    If _formSticky = True Then
                                        dataConn = New SqlConnection(connStr)
                                        dataCmd = New SqlCommand("TB_ADMIN_MakeSticky", dataConn)
                                        dataCmd.CommandType = CommandType.StoredProcedure
                                        dataParam = dataCmd.Parameters.Add("@messageid", SqlDbType.Int)
                                        dataParam.Value = _messageID
                                        dataConn.Open()
                                        dataCmd.ExecuteNonQuery()
                                        dataConn.Close()
                                    End If
                                    If _formLock = True Then
                                        dataConn = New SqlConnection(connStr)
                                        dataCmd = New SqlCommand("TB_ADMIN_LockThread", dataConn)
                                        dataCmd.CommandType = CommandType.StoredProcedure
                                        dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                                        dataParam.Value = _forumID
                                        dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                                        dataParam.Value = _messageID
                                        dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                                        dataParam.Value = XmlConvert.ToGuid(uGUID)
                                        dataConn.Open()
                                        dataCmd.ExecuteNonQuery()
                                        dataConn.Close()
                                    End If
                                    Call forumPostNotification(_forumID, _messageID, _messageID, uGUID)
                                    Return siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString

                                Case "r"    '-- reply post
                                    '-- new in v2.1
                                    Dim rCount As Double = 0.0
                                    '-- end new in v2.1
                                    dataConn = New SqlConnection(connStr)
                                    dataCmd = New SqlCommand("TB_AddReplyPost", dataConn)
                                    dataCmd.CommandType = CommandType.StoredProcedure
                                    dataCmd.Parameters.Clear()
                                    dataParam = dataCmd.Parameters.Add("@forumid", SqlDbType.Int)
                                    dataParam.Value = _forumID
                                    dataParam = dataCmd.Parameters.Add("@NotifyUser", SqlDbType.Int)
                                    If _formMail = True Then
                                        dataParam.Value = 1
                                    Else
                                        dataParam.Value = 0
                                    End If
                                    dataParam = dataCmd.Parameters.Add("@PostIcon", SqlDbType.VarChar, 50)
                                    dataParam.Value = _postIcon
                                    dataParam = dataCmd.Parameters.Add("@ParentMsgID", SqlDbType.Int)
                                    dataParam.Value = _messageID
                                    dataParam = dataCmd.Parameters.Add("@PostIPAddr", SqlDbType.VarChar, 50)
                                    dataParam.Value = _userIP
                                    dataParam = dataCmd.Parameters.Add("@MessageText", SqlDbType.Text)
                                    If uSig <> String.Empty Then
                                        dataParam.Value = hBody + "<p>&nbsp;</p><p><hr size=""1"" width=""50%"" align=""left"" />" + uSig + "</p>"
                                    Else
                                        dataParam.Value = hBody
                                    End If
                                    Dim postID As Integer = _messageID
                                    dataParam = dataCmd.Parameters.Add("@EditText", SqlDbType.Text)
                                    dataParam.Value = _formBody
                                    dataParam = dataCmd.Parameters.Add("@userGUID", SqlDbType.UniqueIdentifier)
                                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                                    dataParam = dataCmd.Parameters.Add("@postID", SqlDbType.Int)
                                    dataParam.Direction = ParameterDirection.Output
                                    dataParam = dataCmd.Parameters.Add("@replyCount", SqlDbType.Int)
                                    dataParam.Direction = ParameterDirection.Output
                                    dataConn.Open()
                                    dataCmd.ExecuteNonQuery()
                                    postID = dataCmd.Parameters("@postID").Value
                                    '-- new in v2.1
                                    rCount = CInt(dataCmd.Parameters("@replyCount").Value)
                                    If CInt(rCount / 25) <> (rCount / 25) Then
                                        rCount = CInt(rCount / 25) + 1
                                    Else
                                        rCount = CInt(rCount / 25)
                                    End If
                                    '-- end new in v2.1
                                    dataConn.Close()
                                    If _formSticky = True And isModerator = True Then
                                        dataConn = New SqlConnection(connStr)
                                        dataCmd = New SqlCommand("TB_ADMIN_MakeSticky", dataConn)
                                        dataCmd.CommandType = CommandType.StoredProcedure
                                        dataParam = dataCmd.Parameters.Add("@messageid", SqlDbType.Int)
                                        dataParam.Value = _messageID
                                        dataConn.Open()
                                        dataCmd.ExecuteNonQuery()
                                        dataConn.Close()
                                        '-- v2.1 change : does not unsick on reply post
                                        'ElseIf _formSticky = False And isModerator = True Then
                                        '    dataConn = New SqlConnection(connStr)
                                        '    dataCmd = New SqlCommand("TB_ADMIN_MakeNonSticky", dataConn)
                                        '    dataCmd.CommandType = CommandType.StoredProcedure
                                        '    dataParam = dataCmd.Parameters.Add("@messageid", SqlDbType.Int)
                                        '    dataParam.Value = _messageID
                                        '    dataConn.Open()
                                        '    dataCmd.ExecuteNonQuery()
                                        '    dataConn.Close()

                                    End If
                                    If _formLock = True And isModerator = True Then
                                        dataConn = New SqlConnection(connStr)
                                        dataCmd = New SqlCommand("TB_ADMIN_LockThread", dataConn)
                                        dataCmd.CommandType = CommandType.StoredProcedure
                                        dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                                        dataParam.Value = _forumID
                                        dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                                        dataParam.Value = _messageID
                                        dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                                        dataParam.Value = XmlConvert.ToGuid(uGUID)
                                        dataConn.Open()
                                        dataCmd.ExecuteNonQuery()
                                        dataConn.Close()
                                        '-- v2.1 change : does not unlock on reply post
                                        'ElseIf _formLock = False And isModerator = True Then
                                        '    dataConn = New SqlConnection(connStr)
                                        '    dataCmd = New SqlCommand("TB_ADMIN_UnLockThread", dataConn)
                                        '    dataCmd.CommandType = CommandType.StoredProcedure
                                        '    dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                                        '    dataParam.Value = _forumID
                                        '    dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                                        '    dataParam.Value = _messageID
                                        '    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                                        '    dataParam.Value = XmlConvert.ToGuid(uGUID)
                                        '    dataConn.Open()
                                        '    dataCmd.ExecuteNonQuery()
                                        '    dataConn.Close()
                                    End If

                                    '--- reply notification mailer....
                                    Call forumPostNotification(_forumID, _messageID, postID, uGUID)

                                    Return siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + "&p=" + CInt(rCount).ToString '+ "#m" + postID.ToString


                                Case "e"        '-- edit post
                                    Dim parentMsgID As Integer = 0
                                    '-- new in v2.1
                                    Dim bIsUser As Boolean = False
                                    dataConn = New SqlConnection(connStr)
                                    dataCmd = New SqlCommand("TB_CheckPostGUID", dataConn)
                                    dataCmd.CommandType = CommandType.StoredProcedure
                                    dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                                    dataParam.Value = _messageID
                                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                                    dataParam = dataCmd.Parameters.Add("@IsUser", SqlDbType.Bit)
                                    dataParam.Direction = ParameterDirection.Output
                                    dataConn.Open()
                                    dataCmd.ExecuteNonQuery()
                                    bIsUser = dataCmd.Parameters("@IsUser").Value
                                    dataConn.Close()
                                    '-- end new in v2.1

                                    dataConn = New SqlConnection(connStr)
                                    dataCmd = New SqlCommand("TB_EditPost", dataConn)
                                    dataCmd.CommandType = CommandType.StoredProcedure
                                    dataCmd.Parameters.Clear()
                                    dataParam = dataCmd.Parameters.Add("@PostIcon", SqlDbType.VarChar, 50)
                                    dataParam.Value = _postIcon
                                    dataParam = dataCmd.Parameters.Add("@messageID", SqlDbType.Int)
                                    dataParam.Value = _messageID
                                    dataParam = dataCmd.Parameters.Add("@PostIPAddr", SqlDbType.VarChar, 50)
                                    dataParam.Value = _userIP
                                    dataParam = dataCmd.Parameters.Add("@MessageText", SqlDbType.Text)
                                    If uSig <> String.Empty And (_asModerator = False Or bIsUser = True) And _eu9 = True Then
                                        dataParam.Value = hBody + "<p>&nbsp;</p><p><hr size=""1"" width=""50%"" align=""left"" />" + uSig + "</p>" + "<p><i>" + getHashVal("form", "79") + DateTime.Now.ToString + " GMT</i></p>"
                                    ElseIf _asModerator = True And _eu10 = True And bIsUser = False Then
                                        dataParam.Value = hBody + "<p><i>" + getHashVal("form", "80") + DateTime.UtcNow.ToString + " GMT</i></p>"
                                    ElseIf _eu9 = True Then
                                        dataParam.Value = hBody + "<p><i>" + getHashVal("form", "79") + DateTime.UtcNow.ToString + " GMT</i></p>"
                                    Else
                                        dataParam.Value = hBody
                                    End If
                                    dataParam = dataCmd.Parameters.Add("@EditText", SqlDbType.Text)
                                    dataParam.Value = _formBody
                                    dataParam = dataCmd.Parameters.Add("@userGUID", SqlDbType.UniqueIdentifier)
                                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                                    dataParam = dataCmd.Parameters.Add("@ParentMsgID", SqlDbType.Int)
                                    dataParam.Direction = ParameterDirection.Output
                                    dataConn.Open()
                                    dataCmd.ExecuteNonQuery()
                                    parentMsgID = dataCmd.Parameters("@ParentMsgID").Value
                                    dataConn.Close()

                                    If _asModerator = True Then
                                        logAdminAction(uGUID, "Message id " + parentMsgID.ToString + " edited by moderator.")
                                    End If

                                    If _formSticky = True And isModerator = True Then
                                        dataConn = New SqlConnection(connStr)
                                        dataCmd = New SqlCommand("TB_ADMIN_MakeSticky", dataConn)
                                        dataCmd.CommandType = CommandType.StoredProcedure
                                        dataParam = dataCmd.Parameters.Add("@messageid", SqlDbType.Int)
                                        If _messageID = parentMsgID Then
                                            dataParam.Value = _messageID
                                        Else
                                            dataParam.Value = parentMsgID
                                        End If
                                        dataConn.Open()
                                        dataCmd.ExecuteNonQuery()
                                        dataConn.Close()
                                        If _messageID = parentMsgID Then
                                            logAdminAction(uGUID, "Message id " + _messageID.ToString + " made sticky.")
                                        Else
                                            logAdminAction(uGUID, "Message id " + parentMsgID.ToString + " made sticky.")
                                        End If

                                    ElseIf _formSticky = False And isModerator = True Then
                                        dataConn = New SqlConnection(connStr)
                                        dataCmd = New SqlCommand("TB_ADMIN_MakeNonSticky", dataConn)
                                        dataCmd.CommandType = CommandType.StoredProcedure
                                        dataParam = dataCmd.Parameters.Add("@messageid", SqlDbType.Int)
                                        If _messageID = parentMsgID Then
                                            dataParam.Value = _messageID
                                        Else
                                            dataParam.Value = parentMsgID
                                        End If
                                        dataConn.Open()
                                        dataCmd.ExecuteNonQuery()
                                        dataConn.Close()
                                        If _messageID = parentMsgID Then
                                            logAdminAction(uGUID, "Message id " + _messageID.ToString + " made unstuck.")
                                        Else
                                            logAdminAction(uGUID, "Message id " + parentMsgID.ToString + " made unstuck.")
                                        End If


                                    End If
                                    If _formLock = True And isModerator = True Then
                                        dataConn = New SqlConnection(connStr)
                                        dataCmd = New SqlCommand("TB_ADMIN_LockThread", dataConn)
                                        dataCmd.CommandType = CommandType.StoredProcedure
                                        dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                                        dataParam.Value = _forumID
                                        dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                                        If _messageID = parentMsgID Then
                                            dataParam.Value = _messageID
                                        Else
                                            dataParam.Value = parentMsgID
                                        End If
                                        dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                                        dataParam.Value = XmlConvert.ToGuid(uGUID)
                                        dataConn.Open()
                                        dataCmd.ExecuteNonQuery()
                                        dataConn.Close()
                                        If _messageID = parentMsgID Then
                                            logAdminAction(uGUID, "Message id " + _messageID.ToString + " locked.")
                                        Else
                                            logAdminAction(uGUID, "Message id " + parentMsgID.ToString + " locked.")
                                        End If
                                    ElseIf _formLock = False And isModerator = True Then
                                        dataConn = New SqlConnection(connStr)
                                        dataCmd = New SqlCommand("TB_ADMIN_UnLockThread", dataConn)
                                        dataCmd.CommandType = CommandType.StoredProcedure
                                        dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                                        dataParam.Value = _forumID
                                        dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                                        If _messageID = parentMsgID Then
                                            dataParam.Value = _messageID
                                        Else
                                            dataParam.Value = parentMsgID
                                        End If
                                        dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                                        dataParam.Value = XmlConvert.ToGuid(uGUID)
                                        dataConn.Open()
                                        dataCmd.ExecuteNonQuery()
                                        dataConn.Close()
                                        If _messageID = parentMsgID Then
                                            logAdminAction(uGUID, "Message id " + _messageID.ToString + " unlocked.")
                                        Else
                                            logAdminAction(uGUID, "Message id " + parentMsgID.ToString + " unlocked.")
                                        End If
                                    End If
                                    Return siteRoot + "/?f=" + _forumID.ToString + "&m=" + parentMsgID.ToString
                            End Select

                            'ntTable += hBody
                        End If
                        ntTable.Append("</td></tr>")
                    Else
                        ntTable.Append("<tr><td class=""msgSm"" align=""center""><b>" + getHashVal("form", "81") + "</b></td></tr>")
                        ntTable.Append("<tr><td class=""msgSm"" align=""center"">")
                        If subjErr = True Then
                            ntTable.Append(getHashVal("form", "82") + "<br />")
                        End If
                        If bodyErr = True Then
                            ntTable.Append(getHashVal("form", "83") + "<br />")
                        End If
                        If _loadForm.ToLower = "np" Then
                            ntTable.Append(forumPoll(uGUID))
                        Else
                            ntTable.Append(forumForm(uGUID))
                        End If


                        ntTable.Append("</td></tr>")

                    End If
                End If
            Catch ex As Exception
                logErrorMsg("forumPostForm<br />" + ex.InnerException.ToString + "<br />" + ex.StackTrace.ToString, 1)
            End Try

            ntTable.Append("</table>")
            Return ntTable.ToString

        End Function

        '-- search form
        Public Function forumSearchForm(ByVal uGUID As String) As String
            Dim whereStr As String = String.Empty
            Dim lockedPrivate As Boolean = False
            If searchStrLoaded = False Then
                searchStrLoaded = xmlLoadStringMsg("search")
            End If
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If userStrLoaded = False Then
                userStrLoaded = xmlLoadStringMsg("user")
            End If


            If _searchWords.ToString.Trim <> String.Empty Then
                whereStr = keywordFix(_searchWords, _searchAs)
            End If
            Dim sfTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
            sfTable.Append("<form action=" + Chr(34) + siteRoot + "/s.aspx"" method=""get"" name=""sForm"">")
            sfTable.Append("<tr><td class=""msgFormHead"" colspan=""2"" align=""center"">" + getHashVal("search", "0") + "</td></tr>")
            If _searchWords <> String.Empty And whereStr = String.Empty Then
                sfTable.Append("<tr><td class=""msgFormSearchError"" colspan=""2"" align=""center"">" + getHashVal("search", "1") + "<br />" + getHashVal("search", "2") + "</td></tr>")
            End If
            If checkForumAccess(uGUID, _forumID) = False And _forumID > 0 Then
                lockedPrivate = True
                sfTable.Append("<tr><td class=""msgFormSearchError"" colspan=""2"" align=""center"">" + getHashVal("search", "3") + "</td></tr>")
            End If
            '-- keywords
            sfTable.Append("<tr><td class=""msgFormBody"" width=""35%""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" height=""1"" width=""350""><br />" + getHashVal("search", "4") + "</td>")
            sfTable.Append("<td class=""msgFormBody""width=""65%""><input type=""text"" name=""keys"" value=" + Chr(34) + _searchWords + Chr(34) + " class=""msgFormInput"" maxlength=""100""></td></tr>")

            '-- new in v2.1.. search in option
            '-- search user or post
            sfTable.Append("<tr><td class=""msgFormBody"" width=""35%""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" height=""1"" width=""350""><br />" + getHashVal("search", "33") + "</td>")
            sfTable.Append("<td class=""msgFormBody""width=""65%""><select name=""sfd"" class=""msgSm"">")
            sfTable.Append("<option value=""1" + Chr(34))
            If _searchIn = 1 Then
                sfTable.Append(" selected")
            End If
            sfTable.Append(">" + getHashVal("search", "34") + "</option>")
            sfTable.Append("<option value=""2" + Chr(34))
            If _searchIn = 2 Then
                sfTable.Append(" selected")
            End If
            sfTable.Append(">" + getHashVal("search", "35") + "</option>")
            sfTable.Append("</select></td></tr>")
            '-- option bar
            sfTable.Append("<tr><td class=""msgTopicHead"" colspan=""2"" align=""center"">" + getHashVal("search", "5") + "</td></tr>")
            '-- search using
            sfTable.Append("<tr><td class=""msgFormBody""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" height=""1"" width=""350""><br />" + getHashVal("search", "6") + "</td>")
            sfTable.Append("<td class=""msgFormBody""><input type=""radio"" name=""sas"" value=""1" + Chr(34))
            If _searchAs = 1 Then
                sfTable.Append(" checked")
            End If
            sfTable.Append(">" + getHashVal("search", "7") + "<br />")
            sfTable.Append("<input type=""radio"" name=""sas"" value=""2" + Chr(34))
            If _searchAs = 2 Then
                sfTable.Append(" checked")
            End If
            sfTable.Append(">" + getHashVal("search", "8") + "</td></tr>")
            '-- max return
            sfTable.Append("<tr><td class=""msgFormBody""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" height=""1"" width=""350""><br />" + getHashVal("search", "9") + "</td>")
            sfTable.Append("<td class=""msgFormBody""><select name=""mPost"" class=""msgSm"">")
            sfTable.Append("<option value=""25" + Chr(34))
            If _maxReturn = 25 Then
                sfTable.Append(" selected")
            End If
            sfTable.Append(">25</option>")
            sfTable.Append("<option value=""50" + Chr(34))
            If _maxReturn = 50 Then
                sfTable.Append(" selected")
            End If
            sfTable.Append(">50</option>")
            sfTable.Append("<option value=""100" + Chr(34))
            If _maxReturn = 100 Then
                sfTable.Append(" selected")
            End If
            sfTable.Append(">100</option>")
            sfTable.Append("<option value=""150" + Chr(34))
            If _maxReturn = 150 Then
                sfTable.Append(" selected")
            End If
            sfTable.Append(">150</option>")
            sfTable.Append("<option value=""200" + Chr(34))
            If _maxReturn = 200 Then
                sfTable.Append(" selected")
            End If
            sfTable.Append(">200</option>")
            sfTable.Append("<option value=""0" + Chr(34))
            If _maxReturn = 0 Then
                sfTable.Append(" selected")
            End If
            sfTable.Append(">All Posts</option>")
            sfTable.Append("</select></td></tr>")
            '-- forum to search
            sfTable.Append("<tr><td class=""msgFormBody""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" height=""1"" width=""350""><br />" + getHashVal("search", "10") + "</td>")
            sfTable.Append("<td class=""msgFormBody""><select name=""f"" class=""msgSm""><option value=""0"">" + getHashVal("search", "11") + "</option>")
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ForumDropListing", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
            dataParam.Value = XmlConvert.ToGuid(uGUID)
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                        sfTable.Append("<option value=" + Chr(34) + CStr(dataRdr.Item(0)) + Chr(34))
                        If _forumID = dataRdr.Item(0) Then
                            sfTable.Append(" selected")
                        End If
                        sfTable.Append(">" + dataRdr.Item(1) + "</option>")
                    End If
                End While
                dataRdr.Close()
            End If
            dataConn.Close()
            sfTable.Append("</select></td></tr>")
            '-- max age
            sfTable.Append("<tr><td class=""msgFormBody""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" height=""1"" width=""350""><br />" + getHashVal("search", "12") + "</td>")
            sfTable.Append("<td class=""msgFormBody""><select name=""mDays"" class=""msgSm""><option value=""0"">" + getHashVal("search", "13") + "</option>")
            sfTable.Append("<option value=""7" + Chr(34))
            If _maxDays = 7 Then
                sfTable.Append(" selected")
            End If
            sfTable.Append(">" + getHashVal("search", "14") + "</option>")
            sfTable.Append("<option value=""14" + Chr(34))
            If _maxDays = 14 Then
                sfTable.Append(" selected")
            End If
            sfTable.Append(">" + getHashVal("search", "15") + "</option>")
            sfTable.Append("<option value=""30" + Chr(34))
            If _maxDays = 30 Then
                sfTable.Append(" selected")
            End If
            sfTable.Append(">" + getHashVal("search", "16") + "</option>")
            sfTable.Append("<option value=""60" + Chr(34))
            If _maxDays = 60 Then
                sfTable.Append(" selected")
            End If
            sfTable.Append(">" + getHashVal("search", "17") + "</option>")
            sfTable.Append("<option value=""90" + Chr(34))
            If _maxDays = 90 Then
                sfTable.Append(" selected")
            End If
            sfTable.Append(">" + getHashVal("search", "18") + "</option>")
            sfTable.Append("<option value=""180" + Chr(34))
            If _maxDays = 180 Then
                sfTable.Append(" selected")
            End If
            sfTable.Append(">" + getHashVal("search", "19") + "</option>")
            sfTable.Append("<option value=""365" + Chr(34))
            If _maxDays = 365 Then
                sfTable.Append(" selected")
            End If
            sfTable.Append(">" + getHashVal("search", "20") + "</option>")
            sfTable.Append("</select></td></tr>")

            sfTable.Append("<tr><td class=""msgFormDesc"">&nbsp;</td>")
            sfTable.Append("<td class=""msgFormDesc""><input type=""submit"" class=""msgButton"" value=" + Chr(34) + getHashVal("search", "21") + Chr(34) + " name=""btnSubmit"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);""></td></tr>")
            sfTable.Append("</form></table>")

            If _searchWords <> String.Empty And whereStr <> String.Empty And lockedPrivate = False Then

                Dim sSQL As New StringBuilder("SELECT ")
                Select Case _maxReturn
                    Case 25, 50, 100, 150, 200
                        sSQL.Append("TOP " + _maxReturn.ToString + " ")
                    Case Else
                        sSQL.Append("TOP 25 ")
                End Select
                sSQL.Append(" m.MessageID, m.ParentMsgID, ")
                sSQL.Append("(SELECT TOP 1 messageTitle FROM SMB_Messages WHERE (MessageID = m.ParentMsgID OR MessageID = m.MessageID) AND messageTitle IS NOT NULL), ")

                sSQL.Append(" m.editableText, m.PostDate, p.UserName, p.UserID, m.ForumID, f.ForumName, m.PostIcon FROM SMB_Messages m INNER JOIN SMB_Profiles p ON p.UserGUID = m.UserGUID INNER JOIN SMB_Forums f ON f.ForumID = m.ForumID WHERE " + whereStr)
                If _maxDays > 0 Then
                    sSQL.Append(" AND m.PostDate >= '")
                    sSQL.Append(FormatDateTime(DateAdd(DateInterval.Day, _maxDays * -1, DateTime.Now), DateFormat.ShortDate).ToString)
                    sSQL.Append("' ")
                End If
                If _forumID > 0 Then
                    If checkForumAccess(uGUID, _forumID) = False Then
                        sSQL.Append(" AND m.ForumID = 0")    '-- will return 0 records
                    Else
                        sSQL.Append(" AND m.ForumID = " + _forumID.ToString)
                    End If
                Else
                    sSQL.Append(" AND m.ForumID IN (SELECT ForumID FROM SMB_Forums WHERE IsPrivate = 0 OR ")
                    sSQL.Append("m.ForumID IN (SELECT DISTINCT ForumID FROM SMB_PrivateAccess pa INNER JOIN SMB_Profiles p ON p.UserID = pa.UserID WHERE p.UserGUID = '" + userGUID + "'))")
                End If
                sSQL.Append(" ORDER BY m.PostDate DESC")

                'sfTable.Append("<div>SEARCH SQL : <br />" + sSQL.ToString + "</div>")


                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand(sSQL.ToString, dataConn)
                dataCmd.CommandType = CommandType.Text
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader
                Dim rCount As Integer = 0
                Dim cPage As Integer = 0
                Dim sRes As New StringBuilder("")
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        rCount += 1
                        If dataRdr.IsDBNull(1) = True And dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(2) = False And dataRdr.IsDBNull(3) = False Then
                            sRes.Append("<tr><td class=""msgSmRow"">")
                            If dataRdr.IsDBNull(9) = False Then
                                If dataRdr.Item(9) <> "" And dataRdr.Item(9) <> "none" Then
                                    sRes.Append("<img src=" + Chr(34) + siteRoot + "/posticons/" + dataRdr.Item(9) + ".gif"" border=""0"">")
                                Else
                                    sRes.Append("&nbsp;")
                                End If
                            Else
                                sRes.Append("&nbsp;")
                            End If
                            sRes.Append("</td>")
                            sRes.Append("<td class=""msgSmRow"">" + getHashVal("search", "31"))
                            sRes.Append("<a href=" + Chr(34) + siteRoot + "/?f=" + CStr(dataRdr.Item(7)) + "&m=" + CStr(dataRdr.Item(0)) + Chr(34) + ">")

                            If dataRdr.IsDBNull(2) = False Then
                                If dataRdr.Item(2) <> "" Then
                                    sRes.Append(dataRdr.Item(2) + "</a>")
                                Else
                                    sRes.Append(getHashVal("search", "22") + "</a>")
                                End If
                            Else
                                sRes.Append(getHashVal("search", "22") + "</a>")
                            End If

                            sRes.Append("<div class=""msgQuoteWrap""><div class=""msgQuote"">")
                            If Len(dataRdr.Item(3)) > 200 Then
                                sRes.Append(Left(dataRdr.Item(3), 200) + " ...</div></div>")
                            Else
                                sRes.Append(dataRdr.Item(3) + "</div></div>")
                            End If
                            sRes.Append("</td>")
                            sRes.Append("<td class=""msgSmRow"" align=""center"" width=""200"">")
                            sRes.Append("<a href=" + Chr(34) + siteRoot + "/?f=" + CStr(dataRdr.Item(7)) + Chr(34) + ">" + dataRdr.Item(8) + "</a>")
                            sRes.Append("</td>")
                            sRes.Append("<td class=""msgSmRow"" align=""center"" width=""150"">")
                            sRes.Append("<a href=" + Chr(34) + siteRoot + "/vp.aspx?f=" + _forumID.ToString + "&p=" + CStr(dataRdr.Item(6)) + Chr(34) + ">" + dataRdr.Item(5) + "</a><br />")
                            sRes.Append(FormatDateTime(dataRdr.Item(4), DateFormat.GeneralDate) + "</td></tr>")


                        Else
                            sRes.Append("<tr><td class=""msgSmRow"">")
                            If dataRdr.IsDBNull(9) = False Then
                                If dataRdr.Item(9) <> "" And dataRdr.Item(9) <> "none" Then
                                    sRes.Append("<img src=" + Chr(34) + siteRoot + "/posticons/" + dataRdr.Item(9) + ".gif"" border=""0"">")
                                Else
                                    sRes.Append("&nbsp;")
                                End If
                            Else
                                sRes.Append("&nbsp;")
                            End If
                            sRes.Append("</td>")
                            sRes.Append("<td class=""msgSmRow"">" + getHashVal("search", "32"))
                            sRes.Append("<a href=" + Chr(34) + siteRoot + "/?f=" + CStr(dataRdr.Item(7)) + "&m=" + CStr(dataRdr.Item(1)) + "#m" + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                            If dataRdr.IsDBNull(2) = False Then
                                If dataRdr.Item(2) <> "" Then
                                    sRes.Append(dataRdr.Item(2) + "</a>")
                                Else
                                    sRes.Append("(no subject)</a>")
                                End If
                            Else
                                sRes.Append("(no subject)</a>")
                            End If

                            sRes.Append("<div class=""msgQuoteWrap""><div class=""msgQuote"">")
                            If Len(dataRdr.Item(3)) > 200 Then
                                sRes.Append(Left(dataRdr.Item(3), 200) + " ...</div></div>")
                            Else
                                sRes.Append(dataRdr.Item(3) + "</div></div>")
                            End If
                            sRes.Append("</td>")
                            sRes.Append("<td class=""msgSmRow"" align=""center"" width=""200"">")
                            sRes.Append("<a href=" + Chr(34) + siteRoot + "/?f=" + CStr(dataRdr.Item(7)) + Chr(34) + ">" + dataRdr.Item(8) + "</a>")
                            sRes.Append("</td>")
                            sRes.Append("<td class=""msgSmRow"" align=""center"" width=""150"">")
                            sRes.Append("<a href=" + Chr(34) + siteRoot + "/vp.aspx?f=" + _forumID.ToString + "&p=" + CStr(dataRdr.Item(6)) + Chr(34) + ">" + dataRdr.Item(5) + "</a><br />")
                            sRes.Append(FormatDateTime(dataRdr.Item(4), DateFormat.GeneralDate) + "</td></tr>")
                        End If

                    End While
                    dataRdr.Close()
                    dataConn.Close()
                    sfTable.Append("<br /><div class=""msgSm"" align=""center""><b>" + getHashVal("search", "23") + "</b><br />")
                    If rCount > 0 Then
                        sfTable.Append(getHashVal("search", "24") + rCount.ToString + getHashVal("search", "25") + "<br />" + getHashVal("search", "26") + "</div><table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" class=""tblStd"">")
                        sfTable.Append("<tr><td class=""msgSearchHead"" align=""center"" colspan=""2"">" + getHashVal("search", "27") + "</td>")
                        sfTable.Append("<td class=""msgSearchHead"" align=""center"" width=""200"">" + getHashVal("search", "28") + "</td>")
                        sfTable.Append("<td class=""msgSearchHead"" align=""center"" width=""150"">" + getHashVal("search", "29") + "</td></tr>")
                        sfTable.Append(sRes.ToString)
                    Else
                        sfTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" class=""tblStd""><tr><td class=""msgFormSearchError"" align=""center""><br /><b>" + getHashVal("search", "30") + "</b></td></tr>")
                    End If
                    sfTable.Append("</table>")
                End If
            End If
            sfTable.Append(printCopyright())
            Return sfTable.ToString
        End Function

        '-- presents/subscribes users to a specific forum
        Public Function forumSubscribe(ByVal uGUID As String) As String
            If formStrLoaded = False Then
                formStrLoaded = xmlLoadStringMsg("form")
            End If
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If


            Dim fsTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" class=""tblStd"" height=""300"">")
            If uGUID = GUEST_GUID Then
                fsTable.Append("<tr><td class=""msgFormError"" height=""20"" align=""center""><br />" + getHashVal("main", "60") + "</td></tr>")
                fsTable.Append("<tr><td class=""msgSm"" height=""20"" align=""center""><a href=" + Chr(34) + siteRoot + "/l.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">")
                fsTable.Append(getHashVal("main", "26") + "</a>" + getHashVal("main", "27") + "</td></tr>")
            Else
                If _forumID > 0 Then
                    If checkForumAccess(uGUID, _forumID) = False Then
                        fsTable.Append("<tr><td class=""msgTopic"" align=""center"" height=""400"" valign=""top""><br /><b>" + getHashVal("main", "24") + "</b><br /><br />")
                        If uGUID = GUEST_GUID Then
                            fsTable.Append("<a href=" + Chr(34) + siteRoot + "/l.aspx?f=" + _forumID.ToString + Chr(34) + ">")
                            fsTable.Append(getHashVal("main", "26") + "</a>" + getHashVal("main", "27"))
                        End If
                        fsTable.Append("</td></tr>")
                    Else

                        Select Case _loadForm.ToLower
                            Case "s"
                                If checkForumSubscribe(uGUID) = False Then
                                    Dim fName As String = String.Empty

                                    dataConn = New SqlConnection(connStr)
                                    dataCmd = New SqlCommand("TB_SubscribeToForum", dataConn)
                                    dataCmd.CommandType = CommandType.StoredProcedure
                                    dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                                    dataParam.Value = _forumID
                                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                                    dataParam = dataCmd.Parameters.Add("@ForumName", SqlDbType.VarChar, 50)
                                    dataParam.Direction = ParameterDirection.Output
                                    dataConn.Open()
                                    dataCmd.ExecuteNonQuery()
                                    fName = dataCmd.Parameters("@ForumName").Value
                                    dataConn.Close()
                                    If fName <> String.Empty Then
                                        fsTable.Append("<tr><td class=""msgSm"" height=""20"" align=""center""><br />" + getHashVal("main", "61") + fName + getHashVal("main", "62") + "</td></tr>")
                                    Else
                                        fsTable.Append("<tr><td class=""msgFormError"" height=""20"" align=""center""><br />" + getHashVal("main", "63") + "</td></tr>")
                                    End If
                                    fsTable.Append("<tr><td class=""msgSm"" height=""20"" align=""center""><a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">")
                                    fsTable.Append(getHashVal("main", "26") + "</a>" + getHashVal("main", "54") + "</td></tr>")

                                Else    '-- already subscribed
                                    fsTable.Append("<tr><td class=""msgFormError"" height=""20"" align=""center""><br />" + getHashVal("main", "64") + "</td></tr>")
                                    fsTable.Append("<tr><td class=""msgSm"" height=""20"" align=""center""><a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">")
                                    fsTable.Append(getHashVal("main", "26") + "</a>" + getHashVal("main", "54") + "</td></tr>")
                                End If

                            Case "u"

                                If checkForumSubscribe(uGUID) = True Then
                                    Dim fName As String = String.Empty

                                    dataConn = New SqlConnection(connStr)
                                    dataCmd = New SqlCommand("TB_UnsubscribeToForum", dataConn)
                                    dataCmd.CommandType = CommandType.StoredProcedure
                                    dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                                    dataParam.Value = _forumID
                                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                                    dataParam = dataCmd.Parameters.Add("@ForumName", SqlDbType.VarChar, 50)
                                    dataParam.Direction = ParameterDirection.Output
                                    dataConn.Open()
                                    dataCmd.ExecuteNonQuery()
                                    fName = dataCmd.Parameters("@ForumName").Value
                                    dataConn.Close()
                                    If fName <> String.Empty Then
                                        fsTable.Append("<tr><td class=""msgSm"" height=""20"" align=""center""><br />" + getHashVal("main", "66") + fName + getHashVal("main", "62") + "</td></tr>")
                                    Else
                                        fsTable.Append("<tr><td class=""msgFormError"" height=""20"" align=""center""><br />" + getHashVal("main", "65") + "</td></tr>")
                                    End If
                                    fsTable.Append("<tr><td class=""msgSm"" height=""20"" align=""center""><a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">")
                                    fsTable.Append(getHashVal("main", "26") + "</a>" + getHashVal("main", "54") + "</td></tr>")

                                Else    '-- already not subscribed
                                    fsTable.Append("<tr><td class=""msgFormError"" height=""20"" align=""center""><br />" + getHashVal("main", "67") + "</td></tr>")
                                    fsTable.Append("<tr><td class=""msgSm"" height=""20"" align=""center""><a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">")
                                    fsTable.Append(getHashVal("main", "26") + "</a>" + getHashVal("main", "54") + "</td></tr>")
                                End If
                        End Select

                    End If
                Else    '-- unknown forum
                    fsTable.Append("<tr><td class=""msgFormError"" height=""20"" align=""center""><br />" + getHashVal("main", "68") + "</td></tr>")
                    fsTable.Append("<tr><td class=""msgSm"" height=""20"" align=""center""><a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">")
                    fsTable.Append(getHashVal("main", "26") + "</a>" + getHashVal("main", "54") + "</td></tr>")
                End If
            End If
            fsTable.Append("<tr><td>&nbsp;</td></tr></table>")
            '-- added in v2.1
            fsTable.Append(printCopyright())

            Return fsTable.ToString
        End Function

        '-- returns the top level forum navigation
        Public Function forumTop(ByVal uGUID As String, Optional ByVal locationListing As Boolean = False, Optional ByVal linkForum As Boolean = False) As String
            Dim ftTable As New StringBuilder()
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            Try
                ftTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" bgColor=""#000000"">")
                If locationListing = True Then
                    'ftTable.Append("<tr><td class=""msgTitleRow"" align=""center"" colspan=""2"">" + boardTitle + "</td></tr>")
                    If _forumID > 0 Or _loadForm = "pm" Or _categoryID > 0 Then
                        ftTable.Append("<tr><td class=""msgPath"">")
                        ftTable.Append("<a href=" + Chr(34) + siteRoot + "/" + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/folder.gif"" border=""0""></a> &nbsp;<a href=" + Chr(34) + siteRoot + "/" + Chr(34) + ">" + boardTitle + getHashVal("main", "69") + "</a>")
                        If _forumID > 0 Then
                            If (_messageID > 0 And _loadForm = "x") Or linkForum = True Then
                                ftTable.Append("<br /> &nbsp; <img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/droplevel.gif"" border=""0"" /><a href=" + Chr(34) + siteRoot + "?f=" + _forumID.ToString + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/folder.gif"" border=""0""></a> &nbsp;<a href=" + Chr(34) + siteRoot + "?f=" + _forumID.ToString + Chr(34) + ">")
                            ElseIf _loadForm <> "x" Then
                                ftTable.Append("<br /> &nbsp; <img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/droplevel.gif"" border=""0"" /><a href=" + Chr(34) + siteRoot + "?f=" + _forumID.ToString + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/folder.gif"" border=""0""></a> &nbsp;<a href=" + Chr(34) + siteRoot + "?f=" + _forumID.ToString + Chr(34) + ">")
                            Else
                                ftTable.Append("<br /> &nbsp; <img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/droplevel.gif"" border=""0"" /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/folder.gif"" border=""0""> &nbsp;<b>")
                            End If

                            dataConn = New SqlConnection(connStr)
                            dataCmd = New SqlCommand("TB_ForumTitle", dataConn)
                            dataCmd.CommandType = CommandType.StoredProcedure
                            dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                            dataParam.Value = _forumID
                            dataParam = dataCmd.Parameters.Add("@ForumName", SqlDbType.VarChar, 50)
                            dataParam.Direction = ParameterDirection.Output
                            dataConn.Open()
                            dataCmd.ExecuteNonQuery()
                            ftTable.Append(dataCmd.Parameters("@ForumName").Value)
                            dataConn.Close()
                            If _messageID > 0 And (_loadForm = "x" Or linkForum = True) Then
                                If checkForumAccess(uGUID, _forumID) = True Then
                                    dataConn = New SqlConnection(connStr)
                                    dataCmd = New SqlCommand("TB_MessageTitle", dataConn)
                                    dataCmd.CommandType = CommandType.StoredProcedure
                                    dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                                    dataParam.Value = _messageID
                                    dataParam = dataCmd.Parameters.Add("@MessageTitle", SqlDbType.VarChar, 100)
                                    dataParam.Direction = ParameterDirection.Output
                                    dataConn.Open()
                                    dataCmd.ExecuteNonQuery()
                                    If dataCmd.Parameters("@MessageTitle").Value <> String.Empty Then
                                        ftTable.Append("</a> &nbsp;<br /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/droplevel.gif"" border=""0"" /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" border=""0""> &nbsp;<b>")
                                        If linkForum = True Then
                                            ftTable.Append("<a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">")
                                        End If
                                        ftTable.Append(dataCmd.Parameters("@MessageTitle").Value)
                                        If linkForum = True Then
                                            ftTable.Append("</a>")
                                        End If
                                        ftTable.Append("</b> &nbsp;")
                                    Else
                                        ftTable.Append("</a> &nbsp;<br /> &nbsp;")
                                    End If
                                    dataConn.Close()
                                End If

                            ElseIf _messageID > 0 And _loadForm <> "x" Then
                                If checkForumAccess(uGUID, _forumID) = True Then
                                    dataConn = New SqlConnection(connStr)
                                    dataCmd = New SqlCommand("TB_MessageTitle", dataConn)
                                    dataCmd.CommandType = CommandType.StoredProcedure
                                    dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                                    dataParam.Value = _messageID
                                    dataParam = dataCmd.Parameters.Add("@MessageTitle", SqlDbType.VarChar, 100)
                                    dataParam.Direction = ParameterDirection.Output
                                    dataConn.Open()
                                    dataCmd.ExecuteNonQuery()
                                    If dataCmd.Parameters("@MessageTitle").Value <> String.Empty Then
                                        ftTable.Append("</a> &nbsp;<br /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/droplevel.gif"" border=""0"" /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" border=""0""> &nbsp;<b>")
                                        ftTable.Append("<a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">")
                                        ftTable.Append(dataCmd.Parameters("@MessageTitle").Value)
                                        ftTable.Append("</a> &nbsp;<br /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/droplevel.gif"" border=""0"" /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" border=""0""> &nbsp;<b>")
                                    Else
                                        ftTable.Append("</a> &nbsp;<br /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/droplevel.gif"" border=""0"" /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" border=""0""> &nbsp;<b>")
                                    End If
                                    dataConn.Close()
                                Else
                                    ftTable.Append("</a> &nbsp;<br /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/droplevel.gif"" border=""0"" /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" border=""0"">** Private Topic **<b>")
                                End If


                                Select Case _loadForm
                                    Case "e"
                                        ftTable.Append(getHashVal("main", "0"))         '-- Editing your post
                                    Case "r", "q"
                                        ftTable.Append(getHashVal("main", "1"))         '-- Reply post
                                    Case "n"
                                        ftTable.Append(getHashVal("main", "2"))         '-- New Post
                                    Case "np"
                                        ftTable.Append(getHashVal("main", "3"))         '-- New Poll
                                    Case "d"
                                        ftTable.Append(getHashVal("main", "4"))         '-- Delete your post
                                    Case "dd"
                                        ftTable.Append(getHashVal("main", "5"))         '-- Post deleted
                                    Case "em"
                                        ftTable.Append(getHashVal("main", "6"))         '-- Edit this post (Moderator Function)
                                    Case "dm"
                                        ftTable.Append(getHashVal("main", "7"))         '-- Delete this post (Moderator Function)
                                    Case "aa"
                                        ftTable.Append(getHashVal("main", "8"))         '-- Send an Administrator Alert
                                    Case "mi"
                                        ftTable.Append(getHashVal("main", "9"))         '-- Add to your ignore list
                                    Case "bu"
                                        ftTable.Append(getHashVal("main", "10"))         '-- Ban user and lock access
                                    Case "bi"
                                        ftTable.Append(getHashVal("main", "11"))         '-- Ban IP Address
                                    Case "lt"
                                        ftTable.Append(getHashVal("main", "12"))         '-- Lock A Thread
                                    Case "ut"
                                        ftTable.Append(getHashVal("main", "13"))         '-- Unlock A Thread
                                    Case "st"
                                        ftTable.Append(getHashVal("main", "14"))         '-- Make A Thread Sticky
                                    Case "ust"
                                        ftTable.Append(getHashVal("main", "15"))         '-- Unstick A Thread
                                End Select

                            ElseIf _messageID = 0 And _loadForm <> "x" Then
                                ftTable.Append("</a> &nbsp;<br /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/droplevel.gif"" border=""0"" /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" border=""0""> &nbsp;<b>")
                                Select Case _loadForm
                                    Case "e"
                                        ftTable.Append(getHashVal("main", "0"))         '-- Editing your post
                                    Case "r", "q"
                                        ftTable.Append(getHashVal("main", "1"))         '-- Reply post
                                    Case "n"
                                        ftTable.Append(getHashVal("main", "2"))         '-- New Post
                                    Case "np"
                                        ftTable.Append(getHashVal("main", "3"))         '-- New Poll
                                    Case "d"
                                        ftTable.Append(getHashVal("main", "4"))         '-- Delete your post
                                    Case "dd"
                                        ftTable.Append(getHashVal("main", "5"))         '-- Post deleted
                                    Case "em"
                                        ftTable.Append(getHashVal("main", "6"))         '-- Edit this post (Moderator Function)
                                    Case "dm"
                                        ftTable.Append(getHashVal("main", "7"))         '-- Delete this post (Moderator Function)
                                    Case "aa"
                                        ftTable.Append(getHashVal("main", "8"))         '-- Send an Administrator Alert
                                    Case "mi"
                                        ftTable.Append(getHashVal("main", "9"))         '-- Add to your ignore list
                                    Case "bu"
                                        ftTable.Append(getHashVal("main", "10"))         '-- Ban user and lock access
                                    Case "bi"
                                        ftTable.Append(getHashVal("main", "11"))         '-- Ban IP Address
                                    Case "lt"
                                        ftTable.Append(getHashVal("main", "12"))         '-- Lock A Thread
                                    Case "ut"
                                        ftTable.Append(getHashVal("main", "13"))         '-- Unlock A Thread
                                    Case "st"
                                        ftTable.Append(getHashVal("main", "14"))         '-- Make A Thread Sticky
                                    Case "ust"
                                        ftTable.Append(getHashVal("main", "15"))         '-- Unstick A Thread
                                End Select
                            Else
                                ftTable.Append("</b>&nbsp;")
                            End If
                            dataConn.Close()
                        End If

                    End If
                    ftTable.Append("</td>")

                    '-- Forum Quick Jump
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_ForumDropListing", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                    dataConn.Open()
                    dataRdr = dataCmd.ExecuteReader
                    Dim isPriv As Boolean = True
                    Dim cName As String = String.Empty
                    If dataRdr.IsClosed = False Then

                        ftTable.Append("<form action=""#"" method=""get"" name=""quickJump""><td class=""msgPath"" align=""right"" valign=""bottom""><b>" + getHashVal("main", "16") + "</b><br />")

                        ftTable.Append("<select name=""f"" class=""msgFormDrop"" onchange=""quickJ(this.value)"">")

                        ftTable.Append("<option value=""0"">" + getHashVal("main", "158") + "</option>")
                        ftTable.Append("<option value=" + Chr(34) + siteRoot + "/default.aspx"" style=""color:#990000;"">" + getHashVal("main", "155") + "</option>")
                        While dataRdr.Read
                            If dataRdr.IsDBNull(3) = False Then
                                If cName <> dataRdr.Item(3) Then
                                    cName = dataRdr.Item(3)
                                    If dataRdr.Item(4) = _categoryID Then
                                        ftTable.Append("<option value=" + Chr(34) + siteRoot + "/default.aspx?c=" + CStr(dataRdr.Item(4)) + Chr(34) + " style=""color:#000099;"" selected>==== " + dataRdr.Item(3) + " ====</option>")
                                    Else
                                        ftTable.Append("<option value=" + Chr(34) + siteRoot + "/default.aspx?c=" + CStr(dataRdr.Item(4)) + Chr(34) + " style=""color:#000099;"">==== " + dataRdr.Item(3) + " ====</option>")
                                    End If

                                End If
                            End If
                            If dataRdr.Item(0) = _forumID Then
                                ftTable.Append("<option value=" + Chr(34) + siteRoot + "/default.aspx?f=" + CStr(dataRdr.Item(0)) + Chr(34) + " selected>" + dataRdr.Item(1) + "</option>")
                            Else
                                ftTable.Append("<option value=" + Chr(34) + siteRoot + "/default.aspx?f=" + CStr(dataRdr.Item(0)) + Chr(34) + ">" + dataRdr.Item(1) + "</option>")
                            End If


                        End While
                        ftTable.Append("</select></td></form>") ' &nbsp;<input type=""submit"" class=""msgSmButton"" value=" + Chr(34) + getHashVal("main", "70") + Chr(34) + ">
                        dataRdr.Close()
                        dataConn.Close()
                    End If


                    ftTable.Append("</tr>")

                Else
                    'ftTable.Append("<tr><td class=""msgTitleRow"" align=""center"">" + boardTitle + "</td></tr>")
                End If
                ftTable.Append("</table>")
            Catch ex As Exception
                logErrorMsg("forumTop<br />" + ex.StackTrace.ToString, 1)
            End Try
            Return ftTable.ToString
        End Function

        '--- Lists the top level forums
        Public Function forumTopLevel(ByVal uGUID As String) As String
            Dim tlTable As New StringBuilder()
            Dim isPrivate As Boolean = False
            Dim templStr As String = loadTBTemplate("style-topForum.htm", defaultStyle)
            Dim iconStr As String = String.Empty
            Dim forumStr As String = String.Empty
            Dim topicStr As String = String.Empty
            Dim postStr As String = String.Empty
            Dim lastStr As String = String.Empty
            Dim classStr As String = String.Empty
            Dim lCategory As String = String.Empty
            Dim fCount As Integer = 0
            Dim lastVisit As String = String.Empty
            Dim showCategory As Boolean = True

            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If

            If uGUID = GUEST_GUID Then
                lastVisit = DateTime.Now.ToString
            Else
                If HttpContext.Current.Session("lastVisit") = String.Empty Or IsDate(HttpContext.Current.Session("lastVisit")) = False Then
                    lastVisit = DateTime.Now.ToString
                    HttpContext.Current.Session("lastVisit") = lastVisit
                Else
                    lastVisit = HttpContext.Current.Session("lastVisit")
                End If
            End If
            Dim hf As Boolean = checkForumAccess(uGUID, 0)

            If Left(templStr, 6) = "Unable" Then    '-- template missing
                tlTable.Append("<div class=""msgFormError"">" + templStr + "</div>")
            Else
                Try
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_TopListing2", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                    dataConn.Open()
                    dataRdr = dataCmd.ExecuteReader
                    If dataRdr.IsClosed = False Then
                        tlTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
                        Dim sbHead As New StringBuilder(templStr)
                        While dataRdr.Read
                            iconStr = String.Empty
                            topicStr = String.Empty
                            forumStr = String.Empty
                            postStr = String.Empty
                            lastStr = String.Empty
                            classStr = String.Empty
                            If (uGUID = GUEST_GUID And dataRdr.Item(12) = 1) Or uGUID <> GUEST_GUID Then
                                If _categoryID > 0 Then
                                    If _categoryID = dataRdr.Item(16) Then
                                        showCategory = True
                                    Else
                                        showCategory = False
                                    End If
                                End If

                                fCount += 1
                                If lCategory <> dataRdr.Item(13) Then
                                    lCategory = dataRdr.Item(13)
                                    tlTable.Append("<tr><td class=""msgForumHead"" height=""25"" colspan=""5""><a href=" + Chr(34) + siteRoot + "/?c=" + CStr(dataRdr.Item(16)) + Chr(34) + ">")
                                    tlTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/category.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "20") + Chr(34) + " /></a> &nbsp;")
                                    tlTable.Append("<b>" + dataRdr.Item(13) + "</b>")
                                    If dataRdr.IsDBNull(14) = False Then
                                        If dataRdr.Item(14) <> "" Then
                                            tlTable.Append(" : " + dataRdr.Item(14))
                                        End If
                                    End If

                                    tlTable.Append("</td></tr>")
                                    If showCategory = True Then
                                        Dim sbSHead As New StringBuilder(templStr)
                                        sbSHead.Replace(vbCrLf, "")
                                        sbSHead.Replace("{ICON}", "&nbsp;")
                                        sbSHead.Replace("{ForumName}", getHashVal("main", "71"))
                                        sbSHead.Replace("{Topics}", getHashVal("main", "72"))
                                        sbSHead.Replace("{Posts}", getHashVal("main", "73"))
                                        sbSHead.Replace("{LastPost}", getHashVal("main", "74"))
                                        sbSHead.Replace("{ClassTag}", "msgTopicHead")
                                        tlTable.Append(sbSHead.ToString)
                                    End If
                                    
                                End If
                                If showCategory = True Then
                                    '-- post icon
                                    iconStr = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/"
                                    If uGUID = GUEST_GUID Then
                                        iconStr += "nonewfolder.gif"" alt=" + Chr(34) + getHashVal("main", "17") + Chr(34)
                                    Else
                                        If IsDate(dataRdr.Item(4)) = True Then
                                            If IsDate(lastVisit) = False Then
                                                iconStr += "u7.gif"" alt=" + Chr(34) + getHashVal("main", "18") + Chr(34)
                                            Else
                                                If CDate(lastVisit) <= dataRdr.Item(4) Then
                                                    iconStr += "newfolder.gif"" alt=" + Chr(34) + getHashVal("main", "17") + Chr(34)
                                                Else
                                                    iconStr += "nonewfolder.gif"" alt=" + Chr(34) + getHashVal("main", "18") + Chr(34)
                                                End If
                                            End If
                                        Else
                                            iconStr += "newfolder.gif"" alt=" + Chr(34) + getHashVal("main", "17") + Chr(34)
                                        End If
                                    End If

                                    iconStr += " border=""0"" />"

                                    '-- forum title
                                    If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                                        forumStr = "<a href=" + Chr(34) + siteRoot + "/?f=" + CStr(dataRdr.Item(0)) + Chr(34) + ">"
                                        forumStr += CStr(dataRdr.Item(1)) + "</a>"
                                    Else
                                        forumStr = "&nbsp;"
                                    End If

                                    If dataRdr.IsDBNull(11) = False Then
                                        forumStr += "<br />" + dataRdr.Item(11)
                                    Else
                                        forumStr += "&nbsp;"
                                    End If
                                    '-- who can post
                                    'If dataRdr.IsDBNull(18) = False Then
                                    '    Select Case dataRdr.Item(18)
                                    '        Case 1
                                    '            forumStr += "<div class=""msgXsm""><b>Posting Permissions : </b>Post New - Yes &nbsp;|&nbsp; Post Reply - Yes</div>"
                                    '        Case 2
                                    '            forumStr += "<div class=""msgXsm""><b>Posting Permissions : </b>Post New - No &nbsp;|&nbsp; Post Reply - Yes</div>"
                                    '        Case 3
                                    '            forumStr += "<div class=""msgXsm""><b>Posting Permissions : </b>Post New - No &nbsp;|&nbsp; Post Reply - No</div>"

                                    '    End Select
                                    'End If

                                    If dataRdr.IsDBNull(3) = False Then
                                        topicStr = CStr(dataRdr.Item(3))
                                    Else
                                        topicStr = "0"
                                    End If

                                    If dataRdr.IsDBNull(2) = False Then
                                        postStr = CStr(dataRdr.Item(2))
                                    Else
                                        postStr = "0"
                                    End If

                                    '-- last post
                                    lastStr = getHashVal("main", "19") + " : "
                                    If dataRdr.IsDBNull(4) = False Then
                                        If _eu31 <> 0 And _timeOffset = 0 Then
                                            lastStr += Server.HtmlEncode(CStr(DateAdd(DateInterval.Hour, _eu31, dataRdr.Item(4)))) + "<br />"
                                        ElseIf _timeOffset <> 0 Then
                                            lastStr += Server.HtmlEncode(CStr(DateAdd(DateInterval.Hour, _timeOffset, dataRdr.Item(4)))) + "<br />"
                                        Else
                                            lastStr += Server.HtmlEncode(CStr(dataRdr.Item(4))) + "<br />"
                                        End If

                                    Else
                                        lastStr += "&nbsp;<br />"
                                    End If

                                    '-- posted by
                                    If dataRdr.IsDBNull(10) = False And dataRdr.IsDBNull(9) = False Then
                                        lastStr += "Posted By : <a href=" + Chr(34) + siteRoot + "/vp.aspx?p=" + CStr(dataRdr.Item(8)) + Chr(34) + ">"
                                        lastStr += Server.HtmlEncode(CStr(dataRdr.Item(9))) + "</a><br />"
                                    Else
                                        lastStr += "&nbsp;<br />"
                                    End If
                                    If dataRdr.IsDBNull(5) = False And dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(6) = False And dataRdr.IsDBNull(15) = False And dataRdr.IsDBNull(17) = False Then
                                        Dim mPage As Double = 0.0
                                        mPage = dataRdr.Item(17)
                                        If mPage > MAX_THREAD Then
                                            mPage = mPage / MAX_THREAD
                                            If CInt(mPage) < mPage Then
                                                mPage = CInt(mPage) + 1
                                            Else
                                                mPage = CInt(mPage)
                                            End If
                                        Else
                                            mPage = 1
                                        End If

                                        lastStr += "<a href=" + Chr(34) + siteRoot + "/?m=" + CStr(dataRdr.Item(5)) + "&f=" + CStr(dataRdr.Item(0)) + "&p=" + mPage.ToString + "#m" + CStr(dataRdr.Item(15)) + Chr(34) + ">"

                                        If isPrivate = True Then
                                            lastStr += "** PRIVATE TOPIC **"
                                        Else
                                            lastStr += CStr(dataRdr.Item(6))
                                        End If
                                    Else
                                        lastStr += "&nbsp;"
                                    End If
                                    lastStr += " <img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/lastpost.gif"" border=""0"" alt=" + Chr(34) + getHashVal("main", "21") + Chr(34) + "></a>"
                                    Dim sbRow As New StringBuilder(templStr)
                                    sbRow.Replace(vbCrLf, "")
                                    sbRow.Replace("{ICON}", iconStr)
                                    sbRow.Replace("{ForumName}", forumStr)
                                    sbRow.Replace("{Topics}", topicStr)
                                    sbRow.Replace("{Posts}", postStr)
                                    sbRow.Replace("{LastPost}", lastStr)
                                    sbRow.Replace("{ClassTag}", "msgTopic")
                                    tlTable.Append(sbRow.ToString)
                                End If

                            End If

                        End While
                        dataRdr.Close()
                        dataConn.Close()
                        If fCount = 0 And _categoryID = 0 Then
                            tlTable.Append("<tr><td class=""msgTopic"" align=""center"" height=""300"" valign=""top""><br /><b>" + getHashVal("main", "22") + "</b><br /><br />")
                            tlTable.Append(forumLoginForm())
                            tlTable.Append("</td></tr>")
                            tlTable.Append("</table>")
                            tlTable.Append(printCopyright())
                        ElseIf fCount = 0 And _categoryID > 0 Then
                            tlTable.Append("<tr><td class=""msgTopic"" align=""center"" height=""300"" valign=""top""><br /><b>" + getHashVal("main", "23") + "</b><br /><br />")
                            tlTable.Append(forumLoginForm())
                            tlTable.Append("</td></tr>")
                            tlTable.Append("</table>")
                            tlTable.Append(printCopyright())
                        Else
                            tlTable.Append("</table>")
                            tlTable.Append(forumWhosOnline())
                            tlTable.Append(forumThreadIcons(1))
                            tlTable.Append(printCopyright())
                        End If

                    End If
                Catch ex As Exception
                    logErrorMsg("forumTopLevel<br />" + ex.StackTrace.ToString, 1)
                End Try
            End If
            Return tlTable.ToString
        End Function

        '-- unsubscribe from notifications
        Public Function forumUnSubscribe(ByVal uGUID As String) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If

            Dim usTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" height=""300"">")
            Try
                uGUID = checkValidGUID(uGUID)
                If uGUID <> GUEST_GUID Then
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_Unsubscribe", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                    dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                    dataParam.Value = _messageID
                    dataConn.Open()
                    dataCmd.ExecuteNonQuery()
                    dataConn.Close()
                    usTable.Append("<tr><td class=""msgSm"" align=""center""><br /><br />" + getHashVal("main", "75") + "</td></tr>")
                Else
                    usTable.Append("<tr><td class=""msgSm"" align=""center""><br /><br />" = getHashVal("main", "76") + "</td></tr>")
                End If
                usTable.Append("<tr><td>&nbsp;</td></tr>")
                usTable.Append("</table>")
                '-- added in v2.1
                usTable.Append(printCopyright())
            Catch ex As Exception
                logErrorMsg("forumUnSubscribe<br />" + ex.StackTrace.ToString, 1)
            End Try
            Return usTable.ToString
        End Function

        '-- processes confirmation email links
        Public Function forumValidate(ByVal uGUID As String) As String
            Dim mailG As String = String.Empty
            Dim validMail As Boolean = False
            Dim fvTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" class=""tblStd"" height=""300"">")
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            _mVerify = "{" + _mVerify + "}"
            mailG = checkValidGUID(_mVerify)
            If mailG <> GUEST_GUID Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_MailerVerify", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@ConfirmGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(mailG)
                dataParam = dataCmd.Parameters.Add("@mailConfirm", SqlDbType.Bit)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                validMail = dataCmd.Parameters("@mailConfirm").Value
                dataConn.Close()
                If validMail = True Then
                    fvTable.Append("<tr><td class=""msgSm"" align=""center"" valign=""top"" height=""20""><br />" + getHashVal("main", "77") + "<br />")
                    If _eu36 = False Then
                        fvTable.Append(forumLoginForm())

                    End If
                    fvTable.Append("</td></tr>")

                Else
                    fvTable.Append("<tr><td class=""msgSm"" align=""center"" valign=""top"" height=""20""><br />" + getHashVal("main", "78") + "</td></tr>")
                    fvTable.Append("<tr><td class=""msgSm"" align=""center"" valign=""top"" height=""20"">" + getHashVal("main", "79") + "</td></tr>")
                End If

            Else
                fvTable.Append("<tr><td class=""msgSm"" align=""center"" valign=""top"" height=""20""><br />" + getHashVal("main", "78") + "</td></tr>")
                fvTable.Append("<tr><td class=""msgSm"" align=""center"" valign=""top"" height=""20"">" + getHashVal("main", "79") + "</td></tr>")
            End If
            fvTable.Append("<tr><td>&nbsp</td></tr></table>")
            fvTable.Append("<p>&nbsp;</p>")
            fvTable.Append("<p>&nbsp;</p>")
            fvTable.Append(printCopyright())
            Return fvTable.ToString
        End Function

        '-- Lists who is online now
        Public Function forumWhosOnline(Optional ByVal forumID As Integer = 0, Optional ByVal messageID As Integer = 0) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            Dim woTable As New StringBuilder()
            Dim tUsers As Integer = 0
            Dim doneFirst As Boolean = False
            Dim cTime As Date = DateTime.UtcNow
            If _eu31 <> 0 And _timeOffset = 0 Then
                cTime = DateAdd(DateInterval.Hour, _eu31, cTime)
            ElseIf _timeOffset <> 0 Then
                cTime = DateAdd(DateInterval.Hour, _timeOffset, cTime)
            End If

            woTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
            woTable.Append("<tr><td class=""msgFormHead"" colspan=""3"">" + getHashVal("main", "80") + "</td></tr>")
            woTable.Append("<tr><td class=""msgSm"" valign=""top"" width=""40%"">" + getHashVal("main", "81"))
            If _eu31 <> 0 And _timeOffset = 0 Then
                If _eu31 > 0 Then
                    woTable.Append(" +" + _eu31.ToString + ")")
                Else
                    woTable.Append(" " + _eu31.ToString + ")")
                End If
            ElseIf _timeOffset <> 0 Then
                If _timeOffset > 0 Then
                    woTable.Append(" +" + _timeOffset.ToString + ")")
                Else
                    woTable.Append(" " + _timeOffset.ToString + ")")
                End If
            End If
            woTable.Append("<br />" + getHashVal("main", "82") + FormatDateTime(cTime, DateFormat.LongDate) + " " + FormatDateTime(cTime, DateFormat.LongTime))
            If _eu1 = True Or _eu2 = True Then
                woTable.Append("<hr size=""1"" width=""90%"" align=""left"" />")
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_GetSiteStats", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False And _eu1 = True Then
                            woTable.Append(getHashVal("main", "83") + FormatNumber((dataRdr.Item(0)), 0) + getHashVal("main", "84") + FormatNumber(CStr(dataRdr.Item(1)), 0) + getHashVal("main", "85") + "<br />")
                        End If
                        If dataRdr.IsDBNull(2) = False Then
                            tUsers = dataRdr.Item(2)
                        End If
                        If dataRdr.IsDBNull(3) = False And dataRdr.IsDBNull(4) = False And dataRdr.IsDBNull(5) = False And _eu2 = True Then
                            woTable.Append(getHashVal("main", "86") + "<a href=" & Chr(34) & siteRoot & "/vp.aspx?f=" & forumID.ToString & "&m=" & messageID.ToString & "&p=" & CStr(dataRdr.Item(3)) & Chr(34) & ">")
                            woTable.Append(dataRdr.Item(4) & "</a>" + getHashVal("main", "87"))
                            woTable.Append(FormatDateTime(dataRdr.Item(5), DateFormat.ShortDate) & ".")
                        End If

                    End While
                    dataRdr.Close()
                    dataConn.Close()
                End If
            End If

            woTable.Append("</td><td class=""msgSm"" valign=""top"" width=""60%"">")
            If _eu3 = True Then
                woTable.Append("<b>" + getHashVal("main", "88") + "</b><br />")
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_WhosOnlineNow", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(2) = False And dataRdr.IsDBNull(3) = False Then
                            If doneFirst = False Then
                                doneFirst = True

                                woTable.Append(CStr(dataRdr.Item(0)) + getHashVal("main", "89"))
                                If dataRdr.Item(0) <> 1 Then
                                    woTable.Append("s")
                                End If
                                woTable.Append(", " + CStr(dataRdr.Item(1)) + getHashVal("main", "90") + tUsers.ToString + getHashVal("main", "91"))
                                woTable.Append("<br />")
                                woTable.Append("<a href=" + Chr(34) + siteRoot + "/vp.aspx?p=" + CStr(dataRdr.Item(3)))
                                If forumID > 0 Then
                                    woTable.Append("&f=" + forumID.ToString)
                                End If
                                If messageID > 0 Then
                                    woTable.Append("&m=" + messageID.ToString)
                                End If
                                woTable.Append(Chr(34) + ">" + Server.HtmlEncode(dataRdr.Item(2)) + "</a>")
                            Else
                                woTable.Append(", ")
                                woTable.Append("<a href=" + Chr(34) + siteRoot + "/vp.aspx?p=" + CStr(dataRdr.Item(3)))
                                If forumID > 0 Then
                                    woTable.Append("&f=" + forumID.ToString)
                                End If
                                If messageID > 0 Then
                                    woTable.Append("&m=" + messageID.ToString)
                                End If
                                woTable.Append(Chr(34) + ">" + Server.HtmlEncode(dataRdr.Item(2)) + "</a>")
                            End If
                        Else
                            If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                                woTable.Append(CStr(dataRdr.Item(0)) + getHashVal("main", "89"))
                                If dataRdr.Item(0) <> 1 Then
                                    woTable.Append("s")
                                End If
                                woTable.Append(", " + CStr(dataRdr.Item(1)) + getHashVal("main", "91"))
                                woTable.Append("<br />")
                            End If
                        End If
                    End While
                    dataRdr.Close()
                    dataConn.Close()
                Else
                    woTable.Append(getHashVal("main", "92") + "<br />")
                End If


            Else
                woTable.Append("&nbsp;")
            End If

            woTable.Append("</td></tr></table>")
            Return woTable.ToString
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
                Try
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
                Catch
                    Return ""
                End Try
                
            End If
            
        End Function

        '-- returns <head></head> tag common items
        Public Function getHeadItems() As String
            

            Dim headStr As String = String.Empty
            headStr = vbTab + "<link rel=""stylesheet"" type=""text/css"" href=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/css/style.css"" />" + vbCrLf
            headStr += vbTab + "<script src=" + Chr(34) + siteRoot + "/js/TBMain.js""></script>" + vbCrLf
            headStr += vbTab + "<meta name=""Copyright"" content=""dotNetBB, Copyright 2000-2002, Andrew Putnam, Andrew@dotNetBB.com"" />" + vbCrLf
            headStr += vbTab + "<meta http-equiv=""Pragma"" content=""no_cache"">" + vbCrLf
            headStr += vbTab + "<meta http-equiv=""Cache-Control"" content=""no cache"">" + vbCrLf
            headStr += vbTab + "<meta http-equiv=""Expires"" content=""-1"">" + vbCrLf
            headStr += vbTab + "<title>" + boardTitle + "</title>" + vbCrLf
            Return headStr
        End Function

        '-- member listing
        Public Function getMembers(ByVal uGUID As String) As String
            Dim firstRec As Integer = 1
            Dim lastRec As Integer = 25
            Dim pageCount As Double = 0.0

            Dim iPages As Integer = 0
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If userStrLoaded = False Then
                userStrLoaded = xmlLoadStringMsg("user")
            End If
            If _eu12 = True Then
                If uGUID = GUEST_GUID Then
                    Dim vpTable As New StringBuilder("")
                    vpTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" height=""300"">")
                    vpTable.Append("<tr><td class=""msgSm"" align=""center"" height=""20"" ><br /><b>" + getHashVal("main", "93") + "</b><br /><br />" + getHashVal("main", "94") + "<a href=" + Chr(34) + siteRoot + "/l.aspx"">" + getHashVal("main", "95") + "</a>" + getHashVal("main", "96") + "</td></tr>")
                    vpTable.Append("<tr><td>&nbsp;</td></tr></table>")

                    Return vpTable.ToString
                    Exit Function
                End If
            End If

            _mp = _mp.ToLower
            _ml = _ml.ToLower
            '-- first top order by categories
            Dim ml As New StringBuilder("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" height=""3"" width=""50"" /><br /><table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""90%"" align=""center"" class=""tblStd"">")
            ml.Append("<tr><td class=""msgFormHead"" colspan=""3"" height=""20"" align=""center"">" + getHashVal("main", "97") + "</td></tr>")
            ml.Append("<tr><td class=""msgSm"" align=""center"" height=""20"" width=""33%"">")
            If _mp = "a" And _ml = "" Then
                ml.Append("<b>[" + getHashVal("main", "98") + "]</b></td>")
            Else
                ml.Append("<a href=" + Chr(34) + siteRoot + "/ml.aspx?mp=a"">" + getHashVal("main", "98") + "</a></td>")
            End If
            ml.Append("<td class=""msgSm"" align=""center"" width=""33%"">")
            If _mp = "t" And _ml = "" Then
                ml.Append("<b>[" + getHashVal("main", "99") + "]</b></td>")
            Else
                ml.Append("<a href=" + Chr(34) + siteRoot + "/ml.aspx?mp=t"">" + getHashVal("main", "99") + "</a></td>")
            End If

            ml.Append("<td class=""msgSm"" align=""center"" width=""33%"">")
            If _mp = "j" And _ml = "" Then
                ml.Append("<b>[" + getHashVal("main", "100") + "]</b></td></tr>")
            Else
                ml.Append("<a href=" + Chr(34) + siteRoot + "/ml.aspx?mp=j"">" + getHashVal("main", "100") + "</a></td></tr>")
            End If

            ml.Append("</table><br />")
            '-- no alpha char group list
            ml.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""90%"" align=""center"" class=""tblStd"">")
            ml.Append("<tr>")
            If _ml = "1" Then
                ml.Append("<td class=""msgSm"" align=""center"" width=""3.5%""><b>[#/9]</b></td>")
            Else
                ml.Append("<td class=""msgSm"" align=""center"" width=""3.5%""><a href=" + Chr(34) + siteRoot + "/ml.aspx?ml=1"" title=""Special and Numeric Characters""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" width=""3"" height=""10"" />#/9<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" width=""3"" height=""10"" /></a></td>")
            End If
            Dim i As Integer = 0
            For i = 65 To 90
                If _ml = Chr(i).ToString.ToLower Then
                    ml.Append("<td class=""msgSm"" align=""center"" width=""3.5%"" style=""border-left:1px outset threedshadow;""><b>[" + Chr(i) + "]</b></td>")
                Else
                    ml.Append("<td class=""msgSm"" align=""center"" width=""3.5%"" style=""border-left:1px outset threedshadow;""><a href=" + Chr(34) + siteRoot + "/ml.aspx?ml=" + Chr(i) + Chr(34) + " title=" + Chr(i) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" width=""3"" height=""10"" />" + Chr(i) + "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" width=""3"" height=""10"" /></a></td>")
                End If
            Next
            ml.Append("</tr>")
            ml.Append("</table><br />")

            '-- no output based on category/order type

            Dim uCount As Integer = 0
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_GetMemberCount", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            If (_mp.ToString.ToLower = "a" Or _mp.ToString.ToLower = "t" Or _mp.ToString.ToLower = "j") And _ml = "" Then
                dataParam = dataCmd.Parameters.Add("@SearchChar", SqlDbType.VarChar, 1)
                dataParam.Value = ""
            ElseIf _ml <> "" Then
                _ml = Left(_ml, 1)  '-- ensure only 1 char
                _ml = _ml.ToUpper
                If Asc(_ml) >= 65 And Asc(_ml) <= 90 Then
                    dataParam = dataCmd.Parameters.Add("@SearchChar", SqlDbType.VarChar, 1)
                    dataParam.Value = _ml

                ElseIf IsNumeric(_ml) = True Then
                    dataParam = dataCmd.Parameters.Add("@SearchChar", SqlDbType.VarChar, 1)
                    dataParam.Value = "#"

                Else '-- fall back to alpha load
                    dataParam = dataCmd.Parameters.Add("@SearchChar", SqlDbType.VarChar, 1)
                    dataParam.Value = ""
                End If
            Else        '-- load alpha if all else fails
                dataParam = dataCmd.Parameters.Add("@SearchChar", SqlDbType.VarChar, 1)
                dataParam.Value = ""
            End If
            dataParam = dataCmd.Parameters.Add("@MCount", SqlDbType.Int)
            dataParam.Direction = ParameterDirection.Output
            dataConn.Open()
            dataCmd.ExecuteNonQuery()
            uCount = dataCmd.Parameters("@MCount").Value
            dataConn.Close()

            ml.Append("<div class=""msgSm"" align=""center"">" + uCount.ToString + getHashVal("main", "101") + "</div>")
            If uCount > 25 Then
                firstRec = ((_currentPage - 1) * _perPage) + 1
                lastRec = (_currentPage * _perPage)
                pageCount = CDbl(uCount / _perPage)
                If CInt(pageCount) < pageCount Then
                    iPages += CInt(pageCount + 1)
                Else
                    iPages = CInt(pageCount)
                End If
                ml.Append("<div class=""msgSm"" align=""center"">")
                For i = 1 To iPages
                    If i = _currentPage Then
                        ml.Append("&nbsp;<b>[" + i.ToString + "]</b>&nbsp;")
                    Else
                        If _ml = "" Then
                            ml.Append("&nbsp;<a href=" + Chr(34) + siteRoot + "/ml.aspx?mp=" + _mp.ToString + "&p=" + i.ToString + Chr(34) + ">")
                        Else
                            ml.Append("&nbsp;<a href=" + Chr(34) + siteRoot + "/ml.aspx?ml=" + _ml.ToString + "&p=" + i.ToString + Chr(34) + ">")
                        End If

                        ml.Append(i.ToString + "</a>&nbsp;")
                    End If
                Next
                ml.Append("</div>")
            End If

            If uCount > 0 Then  '-- if more than 0 members found, print the list
                ml.Append("<table border=""0"" cellpadding=""5"" cellspacing=""0"" width=""90%"" align=""center"" class=""tblStd"">")
                ml.Append("<tr><td class=""msgTopicHead"" align=""center"" width=""16%"">" + getHashVal("user", "22") + "</td>")
                ml.Append("<td class=""msgTopicHead"" align=""center"" width=""16%"">" + getHashVal("user", "23") + "</td>")
                ml.Append("<td class=""msgTopicHead"" align=""center"" width=""16%"">" + getHashVal("user", "24") + "</td>")
                ml.Append("<td class=""msgTopicHead"" align=""center"" width=""16%"">" + getHashVal("user", "25") + "</td>")
                ml.Append("<td class=""msgTopicHead"" align=""center"" width=""16%"">" + getHashVal("user", "26") + "</td>")
                ml.Append("<td class=""msgTopicHead"" align=""center"" width=""16%"">" + getHashVal("user", "27") + "</td></tr>")


                dataConn = New SqlConnection(connStr)
                If (_mp.ToString.ToLower = "a" Or _mp.ToString.ToLower = "t" Or _mp.ToString.ToLower = "j") And _ml = "" Then
                    If _mp.ToString.ToLower = "a" Then      '-- order alpha
                        dataCmd = New SqlCommand("TB_GetMemberList", dataConn)
                        dataCmd.CommandType = CommandType.StoredProcedure
                        dataParam = dataCmd.Parameters.Add("@SearchChar", SqlDbType.VarChar, 1)
                        dataParam.Value = ""
                        dataParam = dataCmd.Parameters.Add("@FirstRec", SqlDbType.Int)
                        dataParam.Value = firstRec
                        dataParam = dataCmd.Parameters.Add("@LastRec", SqlDbType.Int)
                        dataParam.Value = lastRec


                    ElseIf _mp.ToString.ToLower = "t" Then      '-- order by post total
                        dataCmd = New SqlCommand("TB_GetMemberOrdered", dataConn)
                        dataCmd.CommandType = CommandType.StoredProcedure
                        dataParam = dataCmd.Parameters.Add("@OrderType", SqlDbType.Int)
                        dataParam.Value = 2
                        dataParam = dataCmd.Parameters.Add("@FirstRec", SqlDbType.Int)
                        dataParam.Value = firstRec
                        dataParam = dataCmd.Parameters.Add("@LastRec", SqlDbType.Int)
                        dataParam.Value = lastRec

                    ElseIf _mp.ToString.ToLower = "j" Then      '-- order by date joined
                        dataCmd = New SqlCommand("TB_GetMemberOrdered", dataConn)
                        dataCmd.CommandType = CommandType.StoredProcedure
                        dataParam = dataCmd.Parameters.Add("@OrderType", SqlDbType.Int)
                        dataParam.Value = 1
                        dataParam = dataCmd.Parameters.Add("@FirstRec", SqlDbType.Int)
                        dataParam.Value = firstRec
                        dataParam = dataCmd.Parameters.Add("@LastRec", SqlDbType.Int)
                        dataParam.Value = lastRec

                    End If

                ElseIf _ml <> "" Then
                    dataCmd = New SqlCommand("TB_GetMemberList", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@FirstRec", SqlDbType.Int)
                    dataParam.Value = firstRec
                    dataParam = dataCmd.Parameters.Add("@LastRec", SqlDbType.Int)
                    dataParam.Value = lastRec
                    _ml = Left(_ml, 1)  '-- ensure only 1 char
                    _ml = _ml.ToUpper
                    If Asc(_ml) >= 65 And Asc(_ml) <= 90 Then
                        dataParam = dataCmd.Parameters.Add("@SearchChar", SqlDbType.VarChar, 1)
                        dataParam.Value = _ml

                    ElseIf IsNumeric(_ml) = True Then
                        dataParam = dataCmd.Parameters.Add("@SearchChar", SqlDbType.VarChar, 1)
                        dataParam.Value = "#"

                    Else '-- fall back to alpha load
                        dataParam = dataCmd.Parameters.Add("@SearchChar", SqlDbType.VarChar, 1)
                        dataParam.Value = ""
                    End If
                Else        '-- load alpha if all else fails
                    dataCmd = New SqlCommand("TB_GetMemberList", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@SearchChar", SqlDbType.VarChar, 1)
                    dataParam.Value = ""
                End If
                Dim msR As Integer = 0
                Dim mClass As String = String.Empty
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If msR = 0 Then
                            msR = 1
                            mClass = "msgThread2"
                        Else
                            msR = 0
                            mClass = "msgThread1"
                        End If

                        ml.Append("<tr><td class=" + Chr(34) + mClass + Chr(34) + " align=""center"" width=""16%""><a href=" + Chr(34) + siteRoot + "/vp.aspx?p=")
                        ml.Append(CStr(dataRdr.Item(0)) + Chr(34) + ">" + dataRdr.Item(1) + "</a></td>")
                        ml.Append("<td class=" + Chr(34) + mClass + Chr(34) + " align=""center"" width=""16%"">")
                        If dataRdr.IsDBNull(4) = False Then
                            If dataRdr.Item(4) <> "" Then
                                If LCase(Left(dataRdr.Item(4), 4)) = "http" Then
                                    ml.Append("<a href=" + Chr(34) + dataRdr.Item(4) + Chr(34) + " target=""_blank"">")
                                Else
                                    ml.Append("<a href=""http://" + dataRdr.Item(4) + Chr(34) + " target=""_blank"">")
                                End If
                                ml.Append(getHashVal("user", "28") + "</a>")
                            Else
                                ml.Append("&nbsp;")
                            End If
                        Else
                            ml.Append("&nbsp;")
                        End If
                        ml.Append("</td>")
                        ml.Append("<td class=" + Chr(34) + mClass + Chr(34) + " align=""center"" width=""16%"">")
                        If dataRdr.IsDBNull(2) = False And dataRdr.IsDBNull(3) = False Then
                            If dataRdr.Item(3) = 1 And dataRdr.Item(2) <> "" Then
                                ml.Append("<a href=""mailto:" + dataRdr.Item(2) + Chr(34) + ">")
                                ml.Append(getHashVal("user", "29") + "</a>")
                            Else
                                ml.Append("&nbsp;")
                            End If
                        Else
                            ml.Append("&nbsp;")
                        End If
                        ml.Append("</td>")
                        ml.Append("<td class=" + Chr(34) + mClass + Chr(34) + " align=""center"" width=""16%"">")
                        If dataRdr.IsDBNull(1) = False And dataRdr.IsDBNull(7) = False And dataRdr.IsDBNull(8) = False Then
                            If dataRdr.Item(7) = True And dataRdr.Item(8) = True Then
                                ml.Append("<a href=" + Chr(34) + siteRoot + "/?r=pm&eod=n&uName=" + Server.UrlEncode(dataRdr.Item(1)) + Chr(34) + ">" + getHashVal("user", "30") + "</a>")
                            Else
                                ml.Append("&nbsp;")
                            End If
                        Else
                            ml.Append("&nbsp;")
                        End If
                        ml.Append("</td>")
                        ml.Append("<td class=" + Chr(34) + mClass + Chr(34) + " align=""center"" width=""16%"">")
                        If dataRdr.IsDBNull(5) = False Then
                            ml.Append(CStr(dataRdr.Item(5)))
                        Else
                            ml.Append("0")
                        End If
                        ml.Append("</td>")
                        ml.Append("<td class=" + Chr(34) + mClass + Chr(34) + " align=""center"" width=""16%"">")
                        If dataRdr.IsDBNull(6) = False Then
                            If IsDate(dataRdr.Item(6)) = True Then
                                ml.Append(MonthName(Month(dataRdr.Item(6)), True) + "&nbsp;")
                                ml.Append(CStr(Day(dataRdr.Item(6))) + ", ")
                                ml.Append(CStr(Year(dataRdr.Item(6))))
                            Else
                                ml.Append("&nbsp;")
                            End If
                        Else
                            ml.Append("&nbsp;")
                        End If
                        ml.Append("</td></tr>")


                    End While
                    dataRdr.Close()
                    dataConn.Close()
                End If
                ml.Append("</table>")
            End If

            ml.Append(printCopyright())
            Return ml.ToString
        End Function

        '-- returns the path to the current js include file
        Public Function getScript() As String
            Dim scriptFile As String
            scriptFile = "<script src=" + Chr(34) + siteRoot + "/js/TBMain.js""></script>"
            Return scriptFile
        End Function

        '-- sets up the board top user name and logon/logoff/profile info
        Public Function initializeBoard(ByVal uGUID As String) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            Dim initStr As New StringBuilder()
            Dim userName As String = userNameFromGUID(uGUID)
            Dim acti As Integer = 0
            Dim lastVisit As String = String.Empty
            Dim showPop As String = String.Empty
            Dim zoneCookie As Double = 0
            Dim userTheme As String = _eu32
            Dim tImgPath As String = ""
            If uGUID = String.Empty Then
                uGUID = GUEST_GUID
            End If
            If userTheme = String.Empty Then
                Call initializeLocks()
                userTheme = _eu32
            End If

            userGUID = uGUID
            uGUID = checkValidGUID(uGUID)

            '-- update the who's online and get last visit info.
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_UpdateOnlineUsers2", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
            dataParam.Value = XmlConvert.ToGuid(userGUID)
            dataParam = dataCmd.Parameters.Add("@UserIP", SqlDbType.VarChar, 20)
            dataParam.Value = _userIP
            dataParam = dataCmd.Parameters.Add("@LastForum", SqlDbType.Int)
            dataParam.Value = _forumID
            dataParam = dataCmd.Parameters.Add("@LastVisit", SqlDbType.DateTime)
            dataParam.Direction = ParameterDirection.Output
            dataParam = dataCmd.Parameters.Add("@TimeOffset", SqlDbType.Decimal)
            dataParam.Direction = ParameterDirection.Output
            dataParam = dataCmd.Parameters.Add("@UserTheme", SqlDbType.VarChar, 50)
            dataParam.Direction = ParameterDirection.Output
            dataConn.Open()
            dataCmd.ExecuteNonQuery()
            lastVisit = CStr(dataCmd.Parameters("@LastVisit").Value)
            zoneCookie = dataCmd.Parameters("@TimeOffset").Value
            userTheme = dataCmd.Parameters("@UserTheme").Value
            dataConn.Close()
            userGUID = uGUID


            If userTheme = String.Empty Or userTheme = _eu32 Then
                userTheme = _eu32
            End If
            defaultStyle = userTheme

            If zoneCookie <> 0 And _timeOffset = 0 Then
                _timeOffset = zoneCookie
            End If
            If uGUID <> GUEST_GUID Then
                If HttpContext.Current.Session("LastVisit") = String.Empty Then
                    HttpContext.Current.Session("LastVisit") = lastVisit.ToString
                Else
                    If IsDate(HttpContext.Current.Session("LastVisit")) = True Then
                        If CDate(HttpContext.Current.Session("LastVisit")) > lastVisit Then
                            HttpContext.Current.Session("LastVisit") = lastVisit.ToString
                        End If
                    End If
                End If
            End If
            If uGUID = GUEST_GUID Then
                lastVisit = DateTime.Now.ToString
            Else
                If HttpContext.Current.Session("lastVisit") = String.Empty Or IsDate(HttpContext.Current.Session("lastVisit")) = False Then
                    lastVisit = DateTime.Now.ToString
                    HttpContext.Current.Session("lastVisit") = lastVisit
                Else
                    lastVisit = HttpContext.Current.Session("lastVisit")
                End If
            End If
            '-- new in v2.1 add in double check for removed styles
            If File.Exists(Server.MapPath(siteRoot + "/styles/" + defaultStyle + "/css/style.css")) = False Then
                defaultStyle = _eu32
            End If
            tImgPath = siteRoot + "/styles/" + defaultStyle + "/images/"
            If userName.ToUpper = "GUEST" Or userName = String.Empty Then
                isGuest = True
                If _eu36 = True Then    '-- using NT AUTH, dont show login button
                    initStr.Append("<!-- dotNetBB Forums, Copyright 2000-2002, Andrew Putnam , Andrew@dotNetBB.com  //-->" + vbCrLf)
                    initStr.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" bgColor=""#000000""><tr><td class=""msgSm"">&nbsp; ")
                    initStr.Append(getHashVal("main", "102"))
                    initStr.Append("</td><td class=""msgSm"" align=""right"">")
                    '-- modified in v2.1 to include guest search
                    '-- home
                    initStr.Append("<a href=" + Chr(34) + siteRoot + "/""><img src=" + Chr(34) + tImgPath + "tp_home.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "103") + Chr(34) + " /></a>")
                    '-- register
                    initStr.Append("<a href=" + Chr(34) + siteRoot + "/r.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + "><img src=" + Chr(34) + tImgPath + "tp_register.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "105") + Chr(34) + " /></a>")
                    '-- search
                    initStr.Append("<a href=" + Chr(34) + siteRoot + "/s.aspx?f=" + _forumID.ToString + Chr(34) + "><img src=" + Chr(34) + tImgPath + "tp_search.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "109") + Chr(34) + " /></a>")
                    '-- help
                    initStr.Append("<a href=" + Chr(34) + siteRoot + "/help.aspx"" target=""_blank""><img src=" + Chr(34) + tImgPath + "tp_help.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "106") + Chr(34) + " /></a></td></tr></table>")

                Else
                    initStr.Append("<!-- dotNetBB Forums, Copyright 2000-2002, Andrew Putnam , Andrew@dotNetBB.com  //-->" + vbCrLf)
                    initStr.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" bgColor=""#000000""><tr><td class=""msgSm"">&nbsp; ")
                    initStr.Append(getHashVal("main", "102"))
                    initStr.Append("</td><td class=""msgSm"" align=""right"">")
                    '-- modified in v2.1 to include guest search
                    '-- home
                    initStr.Append("<a href=" + Chr(34) + siteRoot + "/""><img src=" + Chr(34) + tImgPath + "tp_home.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "103") + Chr(34) + " /></a>")
                    '-- log in
                    initStr.Append("<a href=" + Chr(34) + siteRoot + "/l.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + "><img src=" + Chr(34) + tImgPath + "tp_login.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "104") + Chr(34) + " /></a>")
                    '-- register
                    initStr.Append("<a href=" + Chr(34) + siteRoot + "/r.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + "><img src=" + Chr(34) + tImgPath + "tp_register.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "105") + Chr(34) + " /></a>")
                    '-- search
                    initStr.Append("<a href=" + Chr(34) + siteRoot + "/s.aspx?f=" + _forumID.ToString + Chr(34) + "><img src=" + Chr(34) + tImgPath + "tp_search.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "109") + Chr(34) + " /></a>")
                    '-- help
                    initStr.Append("<a href=" + Chr(34) + siteRoot + "/help.aspx"" target=""_blank""><img src=" + Chr(34) + tImgPath + "tp_help.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "106") + Chr(34) + " /></a></td></tr></table>")
                End If


            Else
                isGuest = False
                initStr.Append("<!-- dotNetBB Forums, Copyright 2000-2002, Andrew Putnam , Andrew@dotNetBB.com  //-->" + vbCrLf)
                initStr.Append("<table border=""0"" cellpadding=""0"" cellspacing=""0"" width=""100%"">")

                '-- user links
                initStr.Append("<tr><td class=""msgUserBar"" height=""15"" valign=""top"">")

                '-- log off
                If _eu36 = False Then '-- show logoff if not using NT Auth
                    initStr.Append("<a href=" + Chr(34) + siteRoot + "/lo.aspx""><img src=" + Chr(34) + tImgPath + "tp_logoff.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "114") + "  (" + userName + ")" + Chr(34) + " /></a>")
                End If
                '-- control panel
                initStr.Append("<a href=" + Chr(34) + siteRoot + "/cp.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + "><img src=" + Chr(34) + tImgPath + "tp_profile.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "115") + Chr(34) + " /></a>")
                If _eu30 = True Then
                    Dim pmCount As Integer = 0
                    Dim usePM As Boolean = False
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_MyNewPMCount", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                    dataParam = dataCmd.Parameters.Add("@pmCount", SqlDbType.Int)
                    dataParam.Direction = ParameterDirection.Output
                    dataParam = dataCmd.Parameters.Add("@UsePM", SqlDbType.Bit)
                    dataParam.Direction = ParameterDirection.Output
                    dataConn.Open()
                    dataCmd.ExecuteNonQuery()
                    pmCount = dataCmd.Parameters("@pmCount").Value
                    usePM = dataCmd.Parameters("@UsePM").Value
                    dataConn.Close()
                    If usePM = True Then
                        initStr.Append("<a href=" + Chr(34) + siteRoot + "/?r=pm"">")
                        If pmCount > 0 Then
                            initStr.Append("<img src=" + Chr(34) + tImgPath + "tp_privmsg_new.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "116") + "  (" + pmCount.ToString + getHashVal("main", "117") + Chr(34) + " /></a>")
                        Else
                            initStr.Append("<img src=" + Chr(34) + tImgPath + "tp_privmsg.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "116") + Chr(34) + " /></a>")
                        End If
                        '-- show popup notification if session count changed
                        If HttpContext.Current.Session("pmCount") = String.Empty Then
                            HttpContext.Current.Session("pmCount") = "0"
                        End If
                        If CInt(HttpContext.Current.Session("pmcount")) < pmCount And _loadForm <> "pm" Then
                            HttpContext.Current.Session("pmcount") = pmCount.ToString
                            showPop = "<script language=javascript>" + vbCrLf
                            showPop += "<!--" + vbCrLf
                            showPop += "var popURL='" + siteRoot + "/pop.aspx?w=5';	" + vbCrLf
                            showPop += "window.open(popURL, 'tbPop2', 'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,width=450,height=125');" + vbCrLf
                            showPop += "-->" + vbCrLf
                            showPop += "</script>"
                        Else
                            HttpContext.Current.Session("pmccount") = pmCount.ToString
                        End If
                    End If
                End If

                initStr.Append("</td><td class=""msgUserBar"" align=""right"">")
                '-- home
                initStr.Append("<a href=" + Chr(34) + siteRoot + "/""><img src=" + Chr(34) + tImgPath + "tp_home.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "103") + Chr(34) + " /></a>")

                '-- search
                initStr.Append("<a href=" + Chr(34) + siteRoot + "/s.aspx?f=" + _forumID.ToString + Chr(34) + "><img src=" + Chr(34) + tImgPath + "tp_search.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "109") + Chr(34) + " /></a>")

                '-- member list
                initStr.Append("<a href=" + Chr(34) + siteRoot + "/ml.aspx""><img src=" + Chr(34) + tImgPath + "tp_members.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "110") + Chr(34) + " /></a>")
                '-- subscribe
                If _forumID > 0 And _eu4 = True Then
                    If checkForumSubscribe(uGUID) = False Then
                        initStr.Append("<a href=" + Chr(34) + siteRoot + "/su.aspx?f=" + _forumID.ToString + "&r=s""><img src=" + Chr(34) + tImgPath + "tp_subscribe.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "111") + Chr(34) + " /></a>")
                    Else
                        initStr.Append("<a href=" + Chr(34) + siteRoot + "/su.aspx?f=" + _forumID.ToString + "&r=u""><img src=" + Chr(34) + tImgPath + "tp_unsub.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "112") + Chr(34) + " /></a>")
                    End If

                End If
                '-- admin
                If checkAdminAccess(uGUID) = True Then
                    initStr.Append("<a href=" + Chr(34) + siteRoot + "/admin/""><img src=" + Chr(34) + tImgPath + "tp_admin.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "113") + Chr(34) + " /></a>")
                End If

                '-- help
                initStr.Append("<a href=" + Chr(34) + siteRoot + "/help.aspx"" target=""_blank""><img src=" + Chr(34) + tImgPath + "tp_help.gif"" border=""0"" title=" + Chr(34) + getHashVal("main", "103") + Chr(34) + " /></a>")

                initStr.Append("</td></tr>")

                '-- show user info if at top of forum on message list page
                If _messageID = 0 And _forumID = 0 And _loadForm = "x" Then
                    initStr.Append("<tr><td class=""msgSm"" valign=""bottom""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" height=""3"" width=""100""><br />&nbsp; ")
                    initStr.Append(getHashVal("main", "107") + userName)
                    initStr.Append("</td><td class=""msgSm"" valign=""bottom"" align=""right"">&nbsp;")
                    Dim lTime As Date = lastVisit
                    If _eu31 <> 0 And _timeOffset = 0 Then
                        lTime = DateAdd(DateInterval.Hour, _eu31, lTime)
                    ElseIf _timeOffset <> 0 Then
                        lTime = DateAdd(DateInterval.Hour, _timeOffset, lTime)
                    End If
                    initStr.Append(getHashVal("main", "108") + WeekdayName(Weekday(CDate(lTime)), True))
                    initStr.Append(" " + MonthName(Month(CDate(lTime)), True))
                    initStr.Append(" " + Day(CDate(lTime)).ToString)
                    initStr.Append(", " + Year(CDate(lTime)).ToString + " ")
                    initStr.Append(FormatDateTime(CDate(lTime), DateFormat.LongTime).ToString)
                    If _eu31 <> 0 And _timeOffset = 0 Then
                        If _eu31 > 0 Then
                            initStr.Append(" (GMT +" + _eu31.ToString + ")")
                        Else
                            initStr.Append(" (GMT " + _eu31.ToString + ")")
                        End If

                    ElseIf _timeOffset <> 0 Then
                        If _timeOffset > 0 Then
                            initStr.Append(" (GMT +" + _timeOffset.ToString + ")")
                        Else
                            initStr.Append(" (GMT " + _timeOffset.ToString + ")")
                        End If

                    Else
                        initStr.Append(" GMT")
                    End If
                    initStr.Append("&nbsp;</td></tr>")
                End If


                initStr.Append("</table>")

                If showPop <> String.Empty Then
                    initStr.Append(showPop)
                End If

            End If

            Return initStr.ToString
        End Function

        '-- initializes which function to load for forumList literal
        Public Function initializeforumList(ByVal uguid As String, ByVal hasvalues As Boolean) As String
            If hasvalues = False Then '-- Top level forums
                Return forumTopLevel(userGUID)   '-- populate forumList literal
            Else

                If _forumID > 0 And _messageID = 0 And _loadForm = "x" Then
                    Return forumListForum(userGUID)  '-- populate forumList literal

                ElseIf _forumID > 0 And _messageID > 0 And _loadForm = "x" Then
                    Return forumListThread(userGUID)  '-- populate forumList literal

                ElseIf _forumID > 0 And _messageID > 0 And _loadForm = "aa" Then    '-- admin alert
                    Return adminAlertForm(userGUID)

                ElseIf _forumID > 0 And _messageID > 0 And _loadForm = "mi" Then    '-- admin alert
                    Return addIgnoreFilter(userGUID)

                ElseIf _messageID > 0 And _loadForm = "bu" Then     '-- ban user from thread view link
                    Return banUserFromThread(userGUID)

                ElseIf _messageID > 0 And _loadForm = "bi" Then     '-- ban IP from thread view link
                    Return banIPFromThread(userGUID)

                ElseIf _messageID > 0 And _loadForm = "lt" Then     '-- locks a thread from thread view link
                    Return lockThreadFromLink(userGUID)

                ElseIf _messageID > 0 And _loadForm = "ut" Then     '-- unlocks a thread from thread view link
                    Return unlockThreadFromLink(userGUID)

                ElseIf _messageID > 0 And _loadForm = "st" Then     '-- sticks a thread from thread view link
                    Return stickThreadFromLink(userGUID)

                ElseIf _messageID > 0 And _loadForm = "ust" Then     '-- unsticks a thread from thread view link
                    Return unstickThreadFromLink(userGUID)

                ElseIf _forumID = 0 And _loadForm = "pm" Then        '-- private messages
                    Return forumPM(userGUID)    '-- populate forumList literal

                ElseIf _forumID = 0 And _loadForm = "ca" Then        '-- private messages
                    Return forumValidate(userGUID)    '-- populate forumList literal

                ElseIf _forumID > 0 And _loadForm = "np" Then
                    Return forumPoll(userGUID)

                ElseIf _forumID > 0 And _loadForm <> "x" Then      '-- pass the same either way
                    Return forumForm(userGUID)    '-- populate forumList literal

                Else
                    Return forumTopLevel(userGUID)     '-- populate forumList literal		
                End If
            End If

        End Function

        '-- initialize querystring values
        Public Function initializeQSValues() As Boolean

            _userIP = HttpContext.Current.Request.ServerVariables("REMOTE_ADDR")
            Dim hasQSValues As Boolean = False
            With HttpContext.Current
                If .Request.ServerVariables("QUERY_STRING") <> String.Empty Then
                    If .Request.QueryString("c") <> String.Empty Then
                        hasQSValues = True
                        If IsNumeric(.Request.QueryString("c").ToString.Trim) = True Then
                            _categoryID = CInt(.Request.QueryString("c").ToString.Trim)
                        End If
                    End If
                    If .Request.QueryString("f") <> String.Empty Then
                        hasQSValues = True
                        If IsNumeric(.Request.QueryString("f").ToString.Trim) = True Then
                            _forumID = CInt(.Request.QueryString("f").ToString.Trim)
                        End If
                    End If
                    If .Request.QueryString("m") <> String.Empty Then
                        hasQSValues = True
                        If IsNumeric(.Request.QueryString("m").ToString.Trim) = True Then
                            _messageID = CInt(.Request.QueryString("m").ToString.Trim)
                        End If
                    End If
                    If .Request.QueryString("r") <> String.Empty Then
                        hasQSValues = True
                        If .Request.QueryString("r").ToString.Trim <> String.Empty Then
                            _loadForm = .Request.QueryString("r").ToString.Trim
                        End If
                    End If
                    If .Request.QueryString("p") <> String.Empty Then
                        hasQSValues = True
                        If IsNumeric(.Request.QueryString("p").ToString.Trim) = True Then
                            _currentPage = CInt(.Request.QueryString("p").ToString.Trim)
                            _userID = CInt(.Request.QueryString("p").ToString.Trim)
                        End If
                    End If
                    If .Request.QueryString("fsub") <> String.Empty Then
                        hasQSValues = True
                        If IsNumeric(.Request.QueryString("fsub").ToString.Trim) = True Then
                            _fSub = CInt(.Request.QueryString("fsub").ToString.Trim)
                        End If
                    End If
                    If .Request.QueryString("tsub") <> String.Empty Then
                        hasQSValues = True
                        If IsNumeric(.Request.QueryString("tsub").ToString.Trim) = True Then
                            _tSub = CInt(.Request.QueryString("tsub").ToString.Trim)
                        End If
                    End If
                    If .Request.QueryString("ml") <> String.Empty Then
                        hasQSValues = True
                        If .Request.QueryString("ml").ToString.Trim <> String.Empty Then
                            _ml = .Request.QueryString("ml").ToString.Trim
                        End If
                    End If
                    If .Request.QueryString("mp") <> String.Empty Then
                        hasQSValues = True
                        If .Request.QueryString("mp").ToString.Trim <> String.Empty Then
                            _mp = .Request.QueryString("mp").ToString.Trim
                        End If
                    End If
                    If .Request.QueryString("ui") <> String.Empty Then
                        hasQSValues = True
                        If .Request.QueryString("ui").ToString.Trim <> String.Empty Then
                            _mVerify = .Request.QueryString("ui").ToString.Trim
                        End If
                    End If
                    If .Request.QueryString("eod") <> String.Empty Then
                        hasQSValues = True
                        If .Request.QueryString("eod").ToString.Trim <> String.Empty Then
                            _edOrDel = .Request.QueryString("eod").ToString.Trim.ToLower
                        End If
                    End If
                    If .Request.QueryString("pfp") <> String.Empty Then
                        hasQSValues = True
                        If .Request.QueryString("pfp").ToString.Trim = "1" Then
                            _isPrintable = True
                        End If
                    End If
                    If .Request.QueryString("pco") <> String.Empty Then
                        hasQSValues = True
                        If .Request.QueryString("pco").ToString.Trim = "1" Then
                            _passCoppa = True
                        End If
                    End If
                    If .Request.QueryString("isc") <> String.Empty Then
                        hasQSValues = True
                        If .Request.QueryString("isc").ToString.Trim = "1" Then
                            _isCoppa = True
                        End If
                    End If
                    If .Request.QueryString("x") <> String.Empty Then
                        hasQSValues = True
                        If IsNumeric(.Request.QueryString("x").ToString.Trim) = True Then
                            _setVal = .Request.QueryString("x").ToString.Trim
                            _perPage = CInt(_setVal)
                            setUserCookie("x", _setVal)
                        End If
                    Else
                        _getVal = getUserCookie("x")
                        If _getVal <> String.Empty And IsNumeric(_getVal) = True Then
                            _perPage = CInt(_getVal)
                        End If
                    End If
                    If .Request.QueryString("uName") <> String.Empty Then
                        hasQSValues = True
                        If .Request.QueryString("uName").ToString.Trim <> String.Empty Then
                            _userName = .Request.QueryString("uName").ToString.Trim
                        End If
                    End If
                    If .Request.QueryString("w") <> String.Empty Then
                        hasQSValues = True
                        If IsNumeric(.Request.QueryString("w").ToString.Trim) = True Then
                            _wizardID = CInt(.Request.QueryString("w").ToString.Trim)
                        End If
                    End If
                    If .Request.QueryString("fl") <> String.Empty Then
                        hasQSValues = True
                        If .Request.QueryString("fl").ToString.Trim <> String.Empty Then
                            _flashURL = .Request.QueryString("fl").ToString.Trim
                        End If
                    End If
                    If .Request.QueryString("fh") <> String.Empty Then
                        hasQSValues = True
                        If .Request.QueryString("fh").ToString.Trim <> String.Empty Then
                            _flashHeight = .Request.QueryString("fh").ToString.Trim
                        End If
                    End If
                    If .Request.QueryString("fw") <> String.Empty Then
                        hasQSValues = True
                        If .Request.QueryString("fw").ToString.Trim <> String.Empty Then
                            _flashWidth = .Request.QueryString("fw").ToString.Trim
                        End If
                    End If
                    If .Request.QueryString("fv") <> String.Empty Then
                        hasQSValues = True
                        If .Request.QueryString("fv").ToString.Trim <> String.Empty Then
                            _flashVersion = .Request.QueryString("fv").ToString.Trim
                        End If
                    End If
                    If .Request.QueryString("mPost") <> String.Empty Then
                        hasQSValues = True
                        If IsNumeric(.Request.QueryString("mPost").ToString.Trim) = True Then
                            _maxReturn = CInt(.Request.QueryString("mPost").ToString.Trim)
                        End If
                    End If
                    If .Request.QueryString("sfd") <> String.Empty Then
                        hasQSValues = True
                        If IsNumeric(.Request.QueryString("sfd").ToString.Trim) = True Then
                            _searchIn = CInt(.Request.QueryString("sfd").ToString.Trim)
                        End If
                    End If
                    If .Request.QueryString("mDays") <> String.Empty Then
                        hasQSValues = True
                        If IsNumeric(.Request.QueryString("mDays").ToString.Trim) = True Then
                            _maxDays = CInt(.Request.QueryString("mDays").ToString.Trim)
                        End If
                    End If
                    If .Request.QueryString("pid") <> String.Empty Then
                        hasQSValues = True
                        If IsNumeric(.Request.QueryString("pid").ToString.Trim) = True Then
                            _panelID = CInt(.Request.QueryString("pid").ToString.Trim)
                        End If
                    End If
                    If .Request.QueryString("sas") <> String.Empty Then
                        hasQSValues = True
                        If IsNumeric(.Request.QueryString("sas").ToString.Trim) = True Then
                            _searchAs = CInt(.Request.QueryString("sas").ToString.Trim)
                        End If
                    End If
                    If .Request.QueryString("keys") <> String.Empty Then
                        hasQSValues = True
                        If .Request.QueryString("keys").ToString.Trim <> String.Empty Then
                            _searchWords = .Request.QueryString("keys").ToString.Trim
                        End If
                    End If
                End If
            End With

            Return hasQSValues
        End Function

        '-- initializes which function to load for forumTop literal
        Public Function initializeForumTop(ByVal uGUID As String, ByVal hasValues As Boolean) As String
            If hasValues = False Then '-- Top level forums
                Return forumTop(userGUID, False)   '-- populate forumTop literal
            Else

                If _forumID > 0 And _messageID = 0 And _loadForm = "x" Then
                    Return forumTop(userGUID, True)     '-- populate forumTop literal

                ElseIf _categoryID > 0 And _loadForm = "x" Then
                    Return forumTop(userGUID, True, True)     '-- populate forumTop literal

                ElseIf _forumID > 0 And _messageID > 0 And _loadForm = "x" Then
                    Return forumTop(userGUID, True)     '-- populate forumTop literal

                ElseIf _forumID = 0 And _loadForm = "pm" Then        '-- private messages
                    Return forumTop(userGUID, True)     '-- populate forumTop literal

                ElseIf _forumID = 0 And _loadForm = "ca" Then        '-- private messages
                    Return forumTop(userGUID, True)     '-- populate forumTop literal

                ElseIf _forumID > 0 And _loadForm <> "x" Then      '-- pass the same either way
                    Return forumTop(userGUID, True)     '-- populate forumTop literal
                Else
                    Return forumTop(userGUID, False)     '-- populate forumTop literal
                End If
            End If
        End Function

        '-- initialize form post values
        Public Function initializeFPValues() As Boolean
            _userIP = HttpContext.Current.Request.ServerVariables("REMOTE_ADDR")
            Dim hasQSValues As Boolean = False
            With HttpContext.Current
                If .Request.ServerVariables("REQUEST_METHOD").ToLower = "post" Then
                    If .Request.Form("f") <> String.Empty Then
                        hasQSValues = True
                        If IsNumeric(.Request.Form("f").ToString.Trim) = True Then
                            _forumID = CInt(.Request.Form("f").ToString.Trim)
                        End If
                    End If
                    If .Request.Form("eod") <> String.Empty Then
                        hasQSValues = True
                        If .Request.Form("eod").ToString.Trim <> String.Empty Then
                            _edOrDel = .Request.Form("eod").ToString.Trim.ToLower
                        End If
                    End If
                    If .Request.Form("w") <> String.Empty Then  '-- Which wizard to load
                        hasQSValues = True
                        If IsNumeric(.Request.Form("w").ToString.Trim) = True Then
                            _wizardID = CInt(.Request.Form("w").ToString.Trim)
                        End If
                    End If
                    If .Request.Form("m") <> String.Empty Then
                        hasQSValues = True
                        If IsNumeric(.Request.Form("m").ToString.Trim) = True Then
                            _messageID = CInt(.Request.Form("m").ToString.Trim)
                        End If
                    End If
                    If .Request.Form("verify") <> String.Empty Then
                        hasQSValues = True
                        If .Request.Form("verify").ToString.Trim = "1" Then
                            _processForm = True
                        Else
                            _processForm = False
                        End If
                    End If
                    If .Request.Form("fstyle") <> String.Empty Then
                        hasQSValues = True
                        If .Request.Form("fstyle").ToString.Trim <> String.Empty Then
                            defaultStyle = .Request.Form("fstyle").ToString.Trim
                        End If
                    End If
                    If .Request.Form("uti") <> String.Empty Then
                        hasQSValues = True
                        If .Request.Form("uti").ToString.Trim <> String.Empty Then
                            _userTitle = .Request.Form("uti").ToString.Trim
                        End If
                    End If

                    If .Request.Form("r") <> String.Empty Then
                        hasQSValues = True
                        If .Request.Form("r").ToString.Trim <> String.Empty Then
                            _loadForm = .Request.Form("r").ToString.Trim
                        End If
                    End If
                    If .Request.Form("p") <> String.Empty Then
                        hasQSValues = True
                        If IsNumeric(.Request.Form("p").ToString.Trim) = True Then
                            _currentPage = CInt(.Request.Form("p").ToString.Trim)
                        End If
                    End If
                    If .Request.Form("pid") <> String.Empty Then
                        hasQSValues = True
                        If IsNumeric(.Request.Form("pid").ToString.Trim) = True Then
                            _panelID = CInt(.Request.Form("pid").ToString.Trim)
                        End If
                    End If
                    If .Request.Form("pco") <> String.Empty Then
                        hasQSValues = True
                        If .Request.Form("pco").ToString.Trim = "1" Then
                            _passCoppa = True
                        End If
                    End If
                    If .Request.Form("isc") <> String.Empty Then
                        hasQSValues = True
                        If .Request.Form("isc").ToString.Trim = "1" Then
                            _isCoppa = True
                        End If
                    End If
                    If .Request.Form("x") <> String.Empty Then
                        hasQSValues = True
                        If IsNumeric(.Request.Form("x").ToString.Trim) = True Then
                            _setVal = .Request.Form("x").ToString.Trim
                            _perPage = CInt(_setVal)
                            setUserCookie("x", _setVal)
                        End If
                    Else
                        _getVal = getUserCookie("x")
                        If _getVal <> String.Empty And IsNumeric(_getVal) = True Then
                            _perPage = CInt(_getVal)
                        End If
                    End If
                    If .Request.Form("uName") <> String.Empty Then
                        hasQSValues = True
                        If .Request.Form("uName").ToString.Trim <> String.Empty Then
                            _userName = .Request.Form("uName").ToString.Trim
                        End If
                    End If
                    If hasQSValues = True And .Request.Form("uPass") <> String.Empty Then
                        hasQSValues = True
                        If .Request.Form("uPass").ToString.Trim <> String.Empty Then
                            _userPass = .Request.Form("uPass").ToString.Trim
                        End If
                    End If
                    If .Request.Form("email") <> String.Empty Then
                        hasQSValues = True
                        If .Request.Form("email").ToString.Trim <> String.Empty Then
                            _userEmail = .Request.Form("email").ToString.Trim
                        End If
                    End If

                    '-- form body
                    If .Request.Form("msgbody") <> String.Empty Then
                        hasQSValues = True
                        _formBody = .Request.Form("msgbody").ToString.Trim
                    End If

                    If .Request.Form("posticon") <> String.Empty Then
                        hasQSValues = True
                        _postIcon = .Request.Form("posticon").ToString.Trim
                    End If

                    '-- form subject
                    If .Request.Form("frmSubject") <> String.Empty Then
                        hasQSValues = True
                        _formSubj = .Request.Form("frmSubject").ToString.Trim
                    End If

                    '-- mail notification
                    If .Request.Form("nmail") <> String.Empty Then
                        hasQSValues = True
                        _formMail = True
                    End If

                    '-- include signature
                    If .Request.Form("sig") <> String.Empty Then
                        hasQSValues = True
                        _formSig = True
                    Else
                        _formSig = False
                    End If

                    '-- If moderator edit/delete
                    If .Request.Form("am") <> String.Empty Then
                        hasQSValues = True
                        If LCase(.Request.Form("am")) = "true" Then
                            _asModerator = True
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
                                    _uAvatar = forumNoHTMLFix(.Request.Form("ava2").ToString.Trim)
                            End Select

                        End If
                    End If

                    '-- PM stuff
                    If .Request.Form("upm") <> String.Empty Then
                        hasQSValues = True
                        If .Request.Form("upm").ToString.Trim = "1" Then
                            _usePM = True
                        Else
                            _usePM = False
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

                    If .Request.Form("p") <> String.Empty Then
                        hasQSValues = True
                        If LCase(.Request.Form("p")) = "true" Then
                            _formParent = True
                        Else
                            _formParent = False
                        End If
                    End If
                    '-- preview before post
                    If .Request.Form("preview") <> String.Empty Then
                        hasQSValues = True
                        _formPreview = True
                    End If
                    If .Request.Form("fms") <> String.Empty Then
                        hasQSValues = True
                        If .Request.Form("fms").ToString.Trim = "1" Then
                            _formSticky = True
                        End If
                    End If
                    If .Request.Form("fml") <> String.Empty Then
                        hasQSValues = True
                        If .Request.Form("fml").ToString.Trim = "1" Then
                            _formLock = True
                        End If
                    End If

                    If .Request.Form("np") <> String.Empty Then
                        hasQSValues = True
                        If .Request.Form("np").ToString.Trim <> String.Empty Then
                            If .Request.Form("np").ToString.Trim.ToLower = "true" Then
                                _createNew = True
                            Else
                                _createNew = False
                            End If
                        End If
                    End If
                    If .Request.Form("rn") <> String.Empty Then
                        hasQSValues = True
                        If .Request.Form("rn").ToString.Trim <> String.Empty Then
                            _realname = .Request.Form("rn").ToString.Trim
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
                            _userEmail = .Request.Form("em").ToString.Trim
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
                    If .Request.Form("pv1") <> String.Empty Then
                        hasQSValues = True
                        If .Request.Form("pv1").ToString.Trim <> String.Empty Then
                            _pv1 = .Request.Form("pv1").ToString.Trim
                        End If
                    End If
                    If .Request.Form("pv2") <> String.Empty Then
                        hasQSValues = True
                        If .Request.Form("pv2").ToString.Trim <> String.Empty Then
                            _pv2 = .Request.Form("pv2").ToString.Trim
                        End If
                    End If
                    If .Request.Form("pv3") <> String.Empty Then
                        hasQSValues = True
                        If .Request.Form("pv3").ToString.Trim <> String.Empty Then
                            _pv3 = .Request.Form("pv3").ToString.Trim
                        End If
                    End If
                    If .Request.Form("pv4") <> String.Empty Then
                        hasQSValues = True
                        If .Request.Form("pv4").ToString.Trim <> String.Empty Then
                            _pv4 = .Request.Form("pv4").ToString.Trim
                        End If
                    End If
                    If .Request.Form("pv5") <> String.Empty Then
                        hasQSValues = True
                        If .Request.Form("pv5").ToString.Trim <> String.Empty Then
                            _pv5 = .Request.Form("pv5").ToString.Trim
                        End If
                    End If
                    If .Request.Form("pv6") <> String.Empty Then
                        hasQSValues = True
                        If .Request.Form("pv6").ToString.Trim <> String.Empty Then
                            _pv6 = .Request.Form("pv6").ToString.Trim
                        End If
                    End If

                End If
            End With
            Return hasQSValues
        End Function

        '-- prints a table of the custom user titles
        Public Function listUserTitles() As String
            If userStrLoaded = False Then
                userStrLoaded = xmlLoadStringMsg("user")
            End If
            Dim lfTable As New StringBuilder("<table border=""0"" cellpadding=""1"" cellspacing=""0"" width=""450"" class=""tblstd"">")
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_ADMIN_ListTitles", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader()
            If dataRdr.IsClosed = False Then
                lfTable.Append("<tr><td class=""msgTopicHead"" height=""20"" align=""center"" width=""110"">" + getHashVal("user", "31") + "</td>")
                lfTable.Append("<td class=""msgTopicHead"" align=""center"" height=""20"" width=""110"">" + getHashVal("user", "32") + "</td>")
                lfTable.Append("<td class=""msgTopicHead"" height=""20"" align=""center"">" + getHashVal("user", "33") + "</td></tr>")


                While dataRdr.Read
                    If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False And dataRdr.IsDBNull(2) = False And dataRdr.IsDBNull(3) = False Then
                        lfTable.Append("<tr><td class=""msgTopic"" height=""20"" align=""center"">" + CStr(dataRdr.Item(1)) + "</td>")
                        lfTable.Append("<td class=""msgTopic"" align=""center"">" + CStr(dataRdr.Item(2)) + "</td>")
                        lfTable.Append("<td class=""msgTopic"" align=""center"">" + CStr(dataRdr.Item(3)) + "</td></tr>")
                    End If

                End While
                dataRdr.Close()
                dataConn.Close()
            End If
            lfTable.Append("</table>")

            Return lfTable.ToString
        End Function

        '-- returns the popup wizard items
        Public Function loadWizard() As String
            If wizStrLoaded = False Then
                wizStrLoaded = xmlLoadStringMsg("wiz")
            End If
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            Dim wTable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
            wTable.Append("<script src=" + Chr(34) + siteRoot + "/js/TBform.js""></script>")
            Dim i As Integer = 0
            If _wizardID > 0 Then
                Select Case _wizardID
                    Case 1  '-- Flash Animation Wizard
                        wTable.Append("<tr><td class=""msgSm"" align=""center"" colspan=""3""><br /><b>" + getHashVal("wiz", "0") + "</b></td></tr>")
                        wTable.Append("<tr><td class=""msgSm"" align=""center"" colspan=""3""><hr size=""1"" noshade />" + getHashVal("wiz", "1") + "<br />" + getHashVal("wiz", "2") + "<br />&nbsp;</td></tr>")
                        wTable.Append("<form action=""JavaScript:flashSubmit()"" name=""fform"">")
                        '-- URL
                        wTable.Append("<tr><td class=""msgFormDesc"" width=""100"" align=""right"" >" + getHashVal("wiz", "3") + "</td>")
                        wTable.Append("<td class=""msgFormBody"" width=""300"" colspan=""2""><input type=""text"" class=""msgFormInput"" size=""30"" name=""fu""></td></tr>")

                        '-- Size
                        wTable.Append("<tr><td class=""msgFormDesc"" width=""100"" align=""right"">" + getHashVal("wiz", "4") + "</td>")
                        wTable.Append("<td class=""msgFormBody"" width=""150"" valign=""top"">" + getHashVal("wiz", "5") + "<select name=""fh"" class=""msgSm"">")
                        For i = 100 To 300 Step 50
                            If i = 200 Then
                                wTable.Append("<option value=" + Chr(34) + i.ToString + Chr(34) + " selected>" + i.ToString + " px.</option>")
                            Else
                                wTable.Append("<option value=" + Chr(34) + i.ToString + Chr(34) + ">" + i.ToString + " px.</option>")
                            End If
                        Next
                        wTable.Append("</select></td><td class=""msgFormBody"" width=""150"" valign=""top"">" + getHashVal("wiz", "6") + "<select name=""fw"" class=""msgSm"">")
                        For i = 100 To 600 Step 50
                            If i = 200 Then
                                wTable.Append("<option value=" + Chr(34) + i.ToString + Chr(34) + " selected>" + i.ToString + " px.</option>")
                            Else
                                wTable.Append("<option value=" + Chr(34) + i.ToString + Chr(34) + ">" + i.ToString + " px.</option>")
                            End If
                        Next
                        wTable.Append("</select></td</tr>")


                        '-- buttons
                        wTable.Append("<tr><td colspan=""3"" class=""msgFormDesc"" align=""center"">")
                        wTable.Append("<input type=""submit"" class=""msgButton"" value=" + Chr(34) + getHashVal("wiz", "7") + Chr(34) + " name=""btnTopic"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"">&nbsp;")
                        wTable.Append("<input type=""button"" class=""msgButton"" value=" + Chr(34) + getHashVal("wiz", "8") + Chr(34) + " name=""btnTopic"" onclick=""flashPreview('" + siteRoot + "')"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"">")
                        wTable.Append("</td></form></tr>")

                    Case 2      '-- Flash Sample
                        wTable.Append("<tr><td><embed src=" + Chr(34) + _flashURL + Chr(34) + " height=" + Chr(34) + _flashHeight + Chr(34) + " width=" + Chr(34) + _flashWidth + Chr(34) + " quality=""high"" loop=""infinite"" TYPE=""application/x-shockwave-flash"" PLUGINSPAGE=""http://www.macromedia.com/shockwave/download/index.cgiP1_Prod_Version=Shockwaveflash""></td></tr>")

                    Case 3      '-- Emoticon listing
                        '-- emoticon replacements
                        dataConn = New SqlConnection(connStr)
                        dataCmd = New SqlCommand("TB_ActiveEmoticon", dataConn)
                        dataCmd.CommandType = CommandType.StoredProcedure
                        dataConn.Open()
                        dataRdr = dataCmd.ExecuteReader
                        wTable.Append("<tr><td class=""msgSm"" colspan=""2"" align=""center""><b>" + getHashVal("wiz", "9") + "</b><hr size=""1"" noshade /></td></tr>")
                        If dataRdr.IsClosed = False Then
                            While dataRdr.Read
                                If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                                    wTable.Append("<tr><td class=""msgSm"" align=""center"">")
                                    wTable.Append(dataRdr.Item(1))
                                    wTable.Append("</td><td class=""msgSm"" align=""center"">")
                                    wTable.Append("<img src=" + Chr(34) + siteRoot + "/emoticons/" + dataRdr.Item(0) + Chr(34) + " border=""0"" ")
                                    wTable.Append(" alt=" + Chr(34) + dataRdr.Item(1) + Chr(34))
                                    wTable.Append(" onClick=""window.opener.document.pForm.msgbody.value+=' ")
                                    wTable.Append(dataRdr.Item(1) + " ';" + Chr(34))
                                    wTable.Append(" style=""cursor:hand;"">")
                                    wTable.Append("</td></tr>")
                                End If
                            End While
                            dataRdr.Close()
                            dataConn.Close()
                        End If

                    Case 4  '-- pm user lookup
                        Dim uCount As Integer = 0
                        Dim unr As String = String.Empty
                        wTable.Append("<script language=javascript>" + vbCrLf)
                        wTable.Append("<!--" + vbCrLf)
                        wTable.Append("function selectUser() {" + vbCrLf)
                        wTable.Append("var list=document.forms[1].uDrop;" + vbCrLf)
                        wTable.Append("var listValue=list.options[list.selectedIndex].value;" + vbCrLf)
                        wTable.Append("window.opener.document.pForm.uName.value=listValue" + vbCrLf)
                        wTable.Append("window.close();" + vbCrLf)
                        wTable.Append("}" + vbCrLf)
                        wTable.Append("-->" + vbCrLf)
                        wTable.Append("</script>")
                        wTable.Append("<form action=" + Chr(34) + siteRoot + "/pop.aspx"" method=""post"">")
                        wTable.Append("<input type=""hidden"" name=""w"" value=""4"">")
                        wTable.Append("<tr><td align=""center"" class=""msgTopicHead""><b>" + getHashVal("wiz", "10") + "</b></td></tr>")
                        wTable.Append("<tr><td class=""msgFormBody"">" + getHashVal("wiz", "11") + "</td></tr>")
                        wTable.Append("<tr><td class=""msgFormBody""><input type=""text"" maxlength=""50"" name=""uName"" class=""msgFormInput"" value=" + Chr(34) + _userName + Chr(34) + "></td></tr>")
                        wTable.Append("<tr><td align=""center"" class=""msgFormBody""><input type=""submit"" class=""msgButton"" value=" + Chr(34) + getHashVal("wiz", "12") + Chr(34) + "></td></tr>")
                        wTable.Append("</form>")
                        If _userName <> String.Empty Then
                            wTable.Append("<form action=""#"" method=""post"" name=""uForm"">")
                            wTable.Append("<tr><td class=""msgFormBody"">" + getHashVal("wiz", "13") + "</td></tr>")
                            wTable.Append("<tr><td class=""msgFormBody""><select name=""uDrop"" class=""msgSm"">")
                            _userName = _userName.Replace("*", "%")
                            _userName = _userName.Replace("[", "_")

                            dataConn = New SqlConnection(connStr)
                            dataCmd = New SqlCommand("TB_GetUserForPM", dataConn)
                            dataCmd.CommandType = CommandType.StoredProcedure
                            dataParam = dataCmd.Parameters.Add("@UserName", SqlDbType.VarChar, 50)
                            dataParam.Value = _userName
                            dataConn.Open()
                            dataRdr = dataCmd.ExecuteReader
                            If dataRdr.IsClosed = False Then
                                While dataRdr.Read
                                    If dataRdr.IsDBNull(0) = False Then
                                        uCount += 1
                                        unr = dataRdr.Item(0)
                                        unr = unr.Replace("'", "\'")
                                        wTable.Append("<option value=" + Chr(34) + unr + Chr(34) + ">" + dataRdr.Item(0) + "</option>")

                                    End If
                                End While
                                dataRdr.Close()
                                dataConn.Close()
                            End If
                            If uCount = 0 Then
                                wTable.Append("<option value=" + Chr(34) + getHashVal("wiz", "14") + Chr(34) + ">" + getHashVal("wiz", "14") + "</option></select>")
                            Else
                                wTable.Append("</select> &nbsp; <input type=""button"" value=" + Chr(34) + getHashVal("wiz", "16") + Chr(34) + " class=""msgButton"" onclick=""javascript:selectUser();"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"">")
                            End If
                            wTable.Append("</td></tr></form>")
                        End If

                    Case 5      '-- new private mesage popup
                        wTable.Append("<script language=javascript>" + vbCrLf)
                        wTable.Append("<!--" + vbCrLf)
                        wTable.Append("function goToPM() {" + vbCrLf)
                        wTable.Append("var goURL='" + siteRoot + "/?r=pm';	" + vbCrLf)
                        wTable.Append("window.opener.location.href=goURL;" + vbCrLf)
                        wTable.Append("window.close();" + vbCrLf)
                        wTable.Append("}" + vbCrLf)
                        wTable.Append("-->" + vbCrLf)
                        wTable.Append("</script>")
                        wTable.Append("<tr><td class=""msgTopicHead"" align=""center"" height=""20"">" + getHashVal("wiz", "17") + "</td></tr>")
                        wTable.Append("<tr><td class=""msgSm"" align=""center"" valign=""top""><br />" + getHashVal("wiz", "18") + "<br /><a href=""javascript:goToPM();"">" + getHashVal("main", "26") + "</a>")
                        wTable.Append(getHashVal("wiz", "19") + "<br /><br />" + getHashVal("wiz", "20") + "</td></tr>")

                    Case 6
                        If _userID > 0 Then
                            Dim mailGUID As String = ""
                            Dim userName As String = ""
                            Dim userMail As String = ""
                            Dim m1 As Integer = 0
                            Dim m2 As Integer = 0
                            dataConn = New SqlConnection(connStr)
                            dataCmd = New SqlCommand("TB_GetReConfirmInfo", dataConn)
                            dataCmd.CommandType = CommandType.StoredProcedure
                            dataParam = dataCmd.Parameters.Add("@ConfID", SqlDbType.Int)
                            dataParam.Value = _userID
                            dataParam = dataCmd.Parameters.Add("@UserName", SqlDbType.VarChar, 50)
                            dataParam.Direction = ParameterDirection.Output
                            dataParam = dataCmd.Parameters.Add("@UserMail", SqlDbType.VarChar, 64)
                            dataParam.Direction = ParameterDirection.Output
                            dataParam = dataCmd.Parameters.Add("@MailGUID", SqlDbType.UniqueIdentifier)
                            dataParam.Direction = ParameterDirection.Output
                            dataConn.Open()
                            dataCmd.ExecuteNonQuery()
                            mailGUID = XmlConvert.ToString(dataCmd.Parameters("@MailGUID").Value)
                            userName = dataCmd.Parameters("@UserName").Value
                            userMail = dataCmd.Parameters("@UserMail").Value
                            dataConn.Close()
                            If mailGUID <> GUEST_GUID Then
                                m1 = InStr(userMail, "@", CompareMethod.Binary)
                                If m1 > 0 Then
                                    m2 = InStr(m1, userMail, ".", CompareMethod.Binary)
                                    If m2 > 0 Then
                                        sendMailConfirm(mailGUID, userName, userMail)
                                        wTable.Append("<tr><td class=""msgSm"" align=""center"" height=""200""><br /><br /><b>" + getHashVal("wiz", "21") + "</b></td></tr>")
                                    Else
                                        wTable.Append("<tr><td class=""msgSm"" align=""center"" height=""200""><br /><br /><b>" + getHashVal("wiz", "22") + "<br />" + getHashVal("wiz", "23") + "</b></td></tr>")
                                    End If
                                Else
                                    wTable.Append("<tr><td class=""msgSm"" align=""center"" height=""200""><br /><br /><b>" + getHashVal("wiz", "22") + "<br />" + getHashVal("wiz", "23") + "</b></td></tr>")
                                End If
                            Else
                                wTable.Append("<tr><td class=""msgSm"" align=""center"" height=""200""><br /><br /><b>" + getHashVal("wiz", "24") + "<br />" + getHashVal("wiz", "23") + "</b></td></tr>")
                            End If

                        Else
                            wTable.Append("<tr><td class=""msgSm"" align=""center"" height=""200""><br /><br /><b>" + getHashVal("wiz", "25") + "</b></td></tr>")
                        End If

                    Case 7
                        If _userID > 0 And _messageID > 0 Then     '-- using _userid to hold vote value
                            Dim vMsg As Integer = 0

                            dataConn = New SqlConnection(connStr)
                            dataCmd = New SqlCommand("TB_CastVote", dataConn)
                            dataCmd.CommandType = CommandType.StoredProcedure
                            dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                            dataParam.Value = _messageID
                            dataParam = dataCmd.Parameters.Add("@PollID", SqlDbType.Int)
                            dataParam.Value = _userID
                            dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                            dataParam.Value = XmlConvert.ToGuid(userGUID)
                            dataParam = dataCmd.Parameters.Add("@VoteVal", SqlDbType.Int)
                            dataParam.Direction = ParameterDirection.Output
                            dataConn.Open()
                            dataCmd.ExecuteNonQuery()
                            vMsg = dataCmd.Parameters("@VoteVal").Value
                            dataConn.Close()
                            Select Case vMsg
                                Case 0
                                    wTable.Append("<tr><td class=""msgFormError"" align=""center"" height=""150"" valign=""top""><br /><b>" + getHashVal("wiz", "26") + "</b><br />" + getHashVal("wiz", "27") + "</td></tr>")
                                Case 1
                                    wTable.Append("<tr><td class=""msgFormError"" align=""center"" height=""150"" valign=""top""><br /><b>" + getHashVal("wiz", "26") + "</b><br />" + getHashVal("wiz", "28") + "</td></tr>")
                                Case 2
                                    wTable.Append("<tr><td class=""msgFormError"" align=""center"" height=""200"" valign=""top""><br /><b>" + getHashVal("wiz", "26") + "</b><br />" + getHashVal("wiz", "29") + "</td></tr>")
                                Case 3
                                    wTable.Append("<tr><td class=""msgFormError"" align=""center"" height=""150"" valign=""top""><br /><b>" + getHashVal("wiz", "30") + "</b></td></tr>")

                                    wTable.Append("<script language=javascript>" + vbCrLf)
                                    wTable.Append("<!--" + vbCrLf)
                                    wTable.Append("window.opener.location.href=window.opener.location;" + vbCrLf)
                                    wTable.Append("-->" + vbCrLf)
                                    wTable.Append("</script>")
                            End Select
                            wTable.Append("<script language=javascript>" + vbCrLf)
                            wTable.Append("<!--" + vbCrLf)
                            wTable.Append("setTimeout('window.close()',2000);" + vbCrLf)
                            wTable.Append("-->" + vbCrLf)
                            wTable.Append("</script>")

                        End If


                    Case Else       '-- invalid wizardID
                        wTable.Append("<tr><td class=""msgSm"" align=""center"" height=""200""><br /><br /><b>" + getHashVal("wiz", "25") + "</b></td></tr>")

                End Select
            Else
                wTable.Append("<tr><td class=""msgSm"" align=""center"" height=""200""><br /><br /><b>" + getHashVal("wiz", "25") + "</b></td></tr>")
            End If
            wTable.Append("</table>")
            Return wTable.ToString

        End Function

        '-- generic profile form printout
        Public Function profileForm(ByVal uGUID As String) As String
            If userStrLoaded = False Then
                userStrLoaded = xmlLoadStringMsg("user")
            End If
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            Dim pfTable As New StringBuilder("<table border=""0"" cellpadding=""5"" cellspacing=""0"" width=""100%"" class=""tblStd"" height=""300"">")

            Dim htmlSignature As String = String.Empty
            Dim showForm As Boolean = True

            Try
                uGUID = checkValidGUID(uGUID)
                If uGUID = GUEST_GUID And _createNew = False Then
                    showForm = False
                    pfTable.Append("<tr><td class=""msgSm"" valign=""top"" align=""center"" height=""20""><br />" + getHashVal("user", "34") + "</td></tr>")
                    pfTable.Append("<tr><td class=""msgSm"" valign=""top"" align=""center""><br />")
                    pfTable.Append(forumLoginForm())
                    pfTable.Append("</td></tr>")
                ElseIf uGUID <> GUEST_GUID And _createNew = False And _processForm = False And _eu36 = False Then     '-- valid GUID format, get profile info
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_GetUserProfile2", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                    dataConn.Open()
                    dataRdr = dataCmd.ExecuteReader()
                    If dataRdr.IsClosed = False Then
                        While dataRdr.Read
                            If dataRdr.IsDBNull(0) = False Then
                                _realname = dataRdr.Item(0)
                            End If
                            If dataRdr.IsDBNull(1) = False Then
                                _userName = dataRdr.Item(1)
                            End If
                            If dataRdr.IsDBNull(2) = False Then
                                _userPass = dataRdr.Item(2)
                                _userPass = forumRotate(_userPass)
                            End If
                            If dataRdr.IsDBNull(3) = False Then
                                _userEmail = dataRdr.Item(3)
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
                                _msnName = dataRdr.Item(11)
                            End If
                            If dataRdr.IsDBNull(12) = False Then
                                _yPager = dataRdr.Item(12)
                            End If
                            If dataRdr.IsDBNull(13) = False Then
                                _uLocation = dataRdr.Item(13)
                            End If
                            If dataRdr.IsDBNull(14) = False Then
                                _uOccupation = dataRdr.Item(14)
                            End If
                            If dataRdr.IsDBNull(15) = False Then
                                _uInterests = dataRdr.Item(15)
                                _uInterests = _uInterests.Replace("<br>", vbCrLf)
                            End If
                            If dataRdr.IsDBNull(16) = False Then
                                _uAvatar = dataRdr.Item(16)
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

                        End While
                        dataRdr.Close()
                        dataConn.Close()
                    End If
                ElseIf _createNew = True And _passCoppa = False And _isPrintable = False Then       '-- first COPPA prompt
                    pfTable.Append("<tr><td class=""msgFormHead"" height=""20"">" + getHashVal("user", "35") + "</td></tr>")
                    pfTable.Append("<tr><td class=""msgTopicHead"" height=""20"">" + getHashVal("user", "36") + "</td></tr>")
                    pfTable.Append("<tr><td class=""msgSm"" height=""20"">" + getHashVal("user", "37") + "</td></tr>")
                    pfTable.Append("<tr><td class=""msgSm"" align=""center""heignt=""20"" valign=""top""><br /><a href=" + Chr(34) + siteRoot + "/r.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + "&isc=0&pco=1"">" + getHashVal("user", "38") + "</a><br /><br />")
                    pfTable.Append("<a href=" + Chr(34) + siteRoot + "/r.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + "&isc=1&pco=1"">" + getHashVal("user", "39") + "</a><br /></td></tr>")
                    pfTable.Append("<tr><td colspan=""2"" class=""msgSm"">&nbsp;</td></tr>")
                    pfTable.Append("</table>")
                    pfTable.Append(printCopyright())
                    Return pfTable.ToString
                    Exit Function
                ElseIf _createNew = True And _passCoppa = True And _isCoppa = True And _isPrintable = False Then    '-- using coppa, show link to form
                    pfTable.Append("<tr><td class=""msgFormHead"" height=""20"">" + getHashVal("user", "35") + "</td></tr>")
                    pfTable.Append("<tr><td class=""msgTopicHead"" height=""20"">" + getHashVal("user", "36") + "</td></tr>")
                    pfTable.Append("<tr><td class=""msgSm"" height=""20"">")
                    pfTable.Append(getHashVal("user", "40"))
                    pfTable.Append("<a href=" + Chr(34) + siteRoot + "/r.aspx?isc=1&pco=1&pfp=1"">" + getHashVal("main", "26") + "</a>.</td></tr>")

                    pfTable.Append("<tr><td colspan=""2"" class=""msgSm"">&nbsp;</td></tr>")
                    pfTable.Append("</table>")
                    pfTable.Append(printCopyright())
                    Return pfTable.ToString

                End If
                If showForm = True And _isPrintable = False Then    '-- normal account, not COPPA
                    pfTable.Append("<script language=javascript>" + vbCrLf)
                    pfTable.Append("<!--" + vbCrLf)
                    pfTable.Append("function swapAvatar(imgName) { " + vbCrLf)
                    pfTable.Append("nImg = new Image();" + vbCrLf)
                    pfTable.Append("nImg.src='" + siteRoot + "/avatar/'+imgName;" + vbCrLf)
                    pfTable.Append("document.images['avaImg'].src = eval('nImg.src');" + vbCrLf)
                    pfTable.Append("}" + vbCrLf)
                    pfTable.Append("-->" + vbCrLf)
                    pfTable.Append("</script>" + vbCrLf)
                    pfTable.Append("<tr><td colspan=""2"" class=""msgMd"" height=""10""><b>")
                    If _userName.ToString.Trim = String.Empty Then
                        pfTable.Append(getHashVal("user", "48"))
                    Else
                        pfTable.Append(getHashVal("user", "49"))
                    End If
                    pfTable.Append("</b></td></tr>")
                    pfTable.Append("<tr><td class=""msgFormHead"" colspan=""2"" align=""center"">" + getHashVal("user", "41") + "</td></tr>")
                    pfTable.Append("<form action=" + Chr(34) + siteRoot + "/mp1.aspx"" method=""post"">")
                    pfTable.Append("<input type=""hidden"" name=""f"" value=" + Chr(34) + _forumID.ToString + Chr(34) + ">")
                    pfTable.Append("<input type=""hidden"" name=""m"" value=" + Chr(34) + _messageID.ToString + Chr(34) + ">")
                    pfTable.Append("<input type=""hidden"" name=""np"" value=" + Chr(34) + _createNew.ToString + Chr(34) + ">")
                    pfTable.Append("<input type=""hidden"" name=""pco"" value=""1"">")
                    pfTable.Append("<input type=""hidden"" name=""ics"" value=""1"">")
                    '-- real name
                    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" width=""40%"" ><b>" + getHashVal("user", "42") + "</b><div class=""msgFormDescSm"">" + getHashVal("user", "43") + "</div></td>")
                    pfTable.Append("<td class=""msgFormBody"" width=""60%""><input type=""text"" class=""msgFormStdInput"" style=""width:150px;"" name=""rn"" maxLength=""100"" value=" + Chr(34) + _realname + Chr(34) + "></td></tr>")
                    '-- user name
                    If _eu36 = True Then
                        pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>" + getHashVal("user", "44") + "</b><div class=""msgFormDescSm"">")
                        pfTable.Append(getHashVal("user", "140"))
                        pfTable.Append("<input type=""hidden"" name=""un"" value=" + Chr(34) + HttpContext.Current.Request.ServerVariables("AUTH_USER").ToString + Chr(34) + ">")
                        pfTable.Append("</div></td><td class=""msgFormBody"">" + HttpContext.Current.Request.ServerVariables("AUTH_USER").ToString + "</td></tr>")

                        '-- password
                        pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>" + getHashVal("user", "46") + "</b><div class=""msgFormDescSm"">" + getHashVal("user", "176") + "</div></td>")
                        pfTable.Append("<td class=""msgFormBody"">************</td></tr>")
                        pfTable.Append("<input type=""hidden"" name=""pw"" value=""************"" />")

                    Else
                        pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>" + getHashVal("user", "44") + "</b><div class=""msgFormDescSm"">")
                        If _userName.ToString.Trim = String.Empty Or _createNew = True Then
                            pfTable.Append(getHashVal("user", "45"))
                            pfTable.Append("</div></td><td class=""msgFormBody""><input type=""text"" class=""msgFormStdInput"" style=""width:150px;"" name=""un"" maxLength=""50"" value=" + Chr(34) + _userName + Chr(34) + "></td></tr>")
                        Else
                            pfTable.Append(getHashVal("user", "140"))
                            pfTable.Append("<input type=""hidden"" name=""un"" value=" + Chr(34) + _userName + Chr(34) + ">")
                            pfTable.Append("</div></td><td class=""msgFormBody"">" + _userName + "</td></tr>")
                        End If
                        '-- password
                        pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>" + getHashVal("user", "46") + "</b><div class=""msgFormDescSm"">" + getHashVal("user", "47") + "</div></td>")
                        pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""msgFormStdInput"" name=""pw"" style=""width:150px;"" maxLength=""50"" value=" + Chr(34) + _userPass + Chr(34) + "></td></tr>")
                    End If
                    '-- email
                    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>" + getHashVal("user", "50") + "</b><div class=""msgFormDescSm"">" + getHashVal("user", "51") + "</div></td>")
                    pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""msgFormStdInput"" name=""em"" style=""width:200px;"" maxLength=""64"" value=" + Chr(34) + _userEmail + Chr(34) + "></td></tr>")
                    '------------------------
                    '-- begin optional items

                    '-- v2 NOTE : All optional items removed from initial registration

                    'pfTable.Append("<tr><td class=""msgFormHead"" colspan=""2"" align=""center"">Optional Information</td></tr>")
                    ''-- show email
                    'If _eu21 = True Then
                    '    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>Show Your E-Mail Address :</b><br /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/mail.gif"" border=""0"" height=""27"" width=""25"" alt=""Show your e-mail address"" align=""left""><div class=""msgFormDescSm"">You have the option to show your e-mail address with your posts.</div></td>")
                    '    pfTable.Append("<td class=""msgFormBody"">")
                    '    pfTable.Append("<input type=""radio"" name=""se"" value=""1" + Chr(34))
                    '    If _showEmail = 1 Then
                    '        pfTable.Append(" checked")
                    '    End If
                    '    pfTable.Append("> - Show my E-Mail address<br />")
                    '    pfTable.Append("<input type=""radio"" name=""se"" value=""0" + Chr(34))
                    '    If _showEmail = 0 Then
                    '        pfTable.Append(" checked")
                    '    End If
                    '    pfTable.Append("> - Hide my E-Mail address<br />")
                    '    pfTable.Append("</td></tr>")
                    'End If

                    ''-- homepage
                    'If _eu22 = True Then
                    '    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>Personal Homepage :</b><br /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/home.gif"" border=""0"" height=""27"" width=""25"" alt=""Personal Homepage"" align=""left""><div class=""msgFormDescSm"">If you have a web site, enter the URL here.</div></td>")
                    '    pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""msgFormStdInput"" name=""url"" style=""width:300px;"" maxLength=""200"" value=" + Chr(34) + _homePage + Chr(34) + "></td></tr>")
                    'End If

                    ''-- AOL IM
                    'If _eu17 = True Then
                    '    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>AOL Instant Messenger :</b><br /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/aim.gif"" border=""0"" height=""27"" width=""25"" alt=""AOL Instant Messenger"" align=""left""><div class=""msgFormDescSm"">Enter your AIM screen name so people can contact you using AIM.</div></td>")
                    '    pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""msgFormStdInput"" name=""aim"" style=""width:200px;"" maxLength=""50"" value=" + Chr(34) + _aimName + Chr(34) + "></td></tr>")
                    'End If

                    ''-- ICQ number
                    'If _eu20 = True Then
                    '    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>ICQ Number :</b><br /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/icq.gif"" border=""0"" height=""27"" width=""25"" alt=""ICQ Number"" align=""left""><div class=""msgFormDescSm"">Enter your ICQ number so people can contact you using ICQ.</div></td>")
                    '    pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""msgFormStdInput"" name=""icq"" style=""width:200px;"" maxLength=""20"" value=")
                    '    If _icqNumber > 0 Then
                    '        pfTable.Append(Chr(34) + _icqNumber.ToString + Chr(34) + "></td></tr>")
                    '    Else
                    '        pfTable.Append(Chr(34) + Chr(34) + "></td></tr>")
                    '    End If
                    'End If

                    ''-- Y! Pager
                    'If _eu18 = True Then
                    '    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>Y! Pager :</b><br /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/y!.gif"" border=""0"" height=""27"" width=""25"" alt=""Y! Pager"" align=""left""><div class=""msgFormDescSm"">Enter your Y! screen name so people can contact you using the Yahoo Pager.</div></td>")
                    '    pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""msgFormStdInput"" name=""ypa"" style=""width:200px;"" maxLength=""50"" value=" + Chr(34) + _yPager + Chr(34) + "></td></tr>")
                    'End If

                    ''-- MSN Messenger
                    'If _eu19 = True Then
                    '    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>MSN Messenger :</b><br /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/msnm.gif"" border=""0"" height=""27"" width=""25"" alt=""MSN Messenger"" align=""left""><div class=""msgFormDescSm"">Enter your MSN Messenger name so people can contact you using MSN Messenger.</div></td>")
                    '    pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""msgFormStdInput"" name=""msnm"" style=""width:200px;"" maxLength=""64"" value=" + Chr(34) + _msnName + Chr(34) + "></td></tr>")
                    'End If

                    ''-- City/state location
                    'pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>Location :</b><div class=""msgFormDescSm"">Where in the world people might find you if they were looking.</div></td>")
                    'pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""msgFormInput"" name=""loca"" maxLength=""100"" value=" + Chr(34) + _uLocation + Chr(34) + "></td></tr>")

                    ''-- Occupation
                    'pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>Occupation :</b><div class=""msgFormDescSm"">What do you do for a living?</div></td>")
                    'pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""msgFormInput"" name=""occu"" maxLength=""150"" value=" + Chr(34) + _uOccupation + Chr(34) + "></td></tr>")

                    ''-- Interests
                    'pfTable.Append("<tr><td class=""msgFormDesc"" height=""20""  valign=""top""><b>Personal Interests :</b><div class=""msgFormDescSm"">Any additional interests or hobbies you would like to share about yourself?</div></td>")
                    'pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""msgFormInput"" name=""inter"" maxLength=""150"" value=" + Chr(34) + _uInterests + Chr(34) + "></td></tr>")

                    ''-- Time Offset
                    'pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" valign=""top""><b>Time Offset :</b><div class=""msgFormDescSm"">All times shown are (GMT")
                    'If _eu31 <> 0 And _timeOffset = 0 Then
                    '    If _eu31 > 0 Then
                    '        pfTable.Append(" +" + _eu31.ToString)
                    '    Else
                    '        pfTable.Append(_eu31.ToString)
                    '    End If
                    'End If
                    'pfTable.Append(") unless you change it here.<br />NOTE : Daylight savings is not calculated in the time offset.</div></td>")
                    'pfTable.Append("<td class=""msgFormBody""><select name=""tof"" class=""msgSm"">")
                    'pfTable.Append("<option value=""-12" + Chr(34))
                    'If _timeOffset = -12 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -12:00 hours) Eniwetok, Kwajalein</option>")
                    'pfTable.Append("<option value=""-11" + Chr(34))
                    'If _timeOffset = -11 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -11:00 hours) Midway Island, Samoa</option>")
                    'pfTable.Append("<option value=""-10" + Chr(34))
                    'If _timeOffset = -10 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -10:00 hours) Hawaii</option>")
                    'pfTable.Append("<option value=""-9" + Chr(34))
                    'If _timeOffset = -9 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -9:00 hours) Alaska</option>")
                    'pfTable.Append("<option value=""-8" + Chr(34))
                    'If _timeOffset = -8 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -8:00 hours) Pacific Time (US & Canada)</option>")
                    'pfTable.Append("<option value=""-7" + Chr(34))
                    'If _timeOffset = -7 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -7:00 hours) Mountain Time (US & Canada)</option>")
                    'pfTable.Append("<option value=""-6" + Chr(34))
                    'If _timeOffset = -6 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -6:00 hours) Central Time (US & Canada), Mexico City</option>")
                    'pfTable.Append("<option value=""-5" + Chr(34))
                    'If _timeOffset = -5 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -5:00 hours) Eastern Time (US & Canada), Bogota</option>")
                    'pfTable.Append("<option value=""-4" + Chr(34))
                    'If _timeOffset = -4 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -4:00 hours) Atlantic Time (Canada), Caracas</option>")
                    'pfTable.Append("<option value=""-3.5" + Chr(34))
                    'If _timeOffset = -3.5 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -3:30 hours) Newfoundland</option>")
                    'pfTable.Append("<option value=""-3" + Chr(34))
                    'If _timeOffset = -3 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -3:00 hours) Brazil, Buenos Aires, Georgetown</option>")
                    'pfTable.Append("<option value=""-2" + Chr(34))
                    'If _timeOffset = -2 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -2:00 hours) Mid-Atlantic</option>")
                    'pfTable.Append("<option value=""-1" + Chr(34))
                    'If _timeOffset = -1 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -1:00 hours) Azores, Cape Verde Islands</option>")
                    'pfTable.Append("<option value=""0" + Chr(34))
                    'If _timeOffset = 0 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT) Western Europe Time, London, Lisbon</option>")
                    'pfTable.Append("<option value=""+1" + Chr(34))
                    'If _timeOffset = 1 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +1:00 hours) CET(Central Europe Time), Brussels, Paris</option>")
                    'pfTable.Append("<option value=""+2" + Chr(34))
                    'If _timeOffset = 1 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +2:00 hours) EET(Eastern Europe Time), South Africa</option>")
                    'pfTable.Append("<option value=""+3" + Chr(34))
                    'If _timeOffset = 3 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +3:00 hours) Baghdad, Riyadh, Moscow, St. Petersburg</option>")
                    'pfTable.Append("<option value=""+3.5" + Chr(34))
                    'If _timeOffset = 3.5 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +3:30 hours) Tehran</option>")
                    'pfTable.Append("<option value=""+4" + Chr(34))
                    'If _timeOffset = 4 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +4:00 hours) Abu Dhabi, Muscat, Baku, Tbilisi</option>")
                    'pfTable.Append("<option value=""+4.5" + Chr(34))
                    'If _timeOffset = 4.5 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +4:30 hours) Kabul</option>")
                    'pfTable.Append("<option value=""+5" + Chr(34))
                    'If _timeOffset = 5 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +5:00 hours) Ekaterinburg, Islamabad, Karachi, Tashkent</option>")
                    'pfTable.Append("<option value=""+5.5" + Chr(34))
                    'If _timeOffset = 5.5 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +5:30 hours) Bombay, Calcutta, Madras, New Delhi</option>")
                    'pfTable.Append("<option value=""+6" + Chr(34))
                    'If _timeOffset = 6 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +6:00 hours) Almaty, Dhaka, Colombo</option>")
                    'pfTable.Append("<option value=""+7" + Chr(34))
                    'If _timeOffset = 7 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +7:00 hours) Bangkok, Hanoi, Jakarta</option>")
                    'pfTable.Append("<option value=""+8" + Chr(34))
                    'If _timeOffset = 8 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +8:00 hours) Beijing, Perth, Singapore, Hong Kong</option>")
                    'pfTable.Append("<option value=""+9" + Chr(34))
                    'If _timeOffset = 9 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +9:00 hours) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>")
                    'pfTable.Append("<option value=""+9.5" + Chr(34))
                    'If _timeOffset = 9.5 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +9:30 hours) Adelaide, Darwin</option>")
                    'pfTable.Append("<option value=""+10" + Chr(34))
                    'If _timeOffset = 10 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +10:00 hours) EAST(East Australian Standard), Guam</option>")
                    'pfTable.Append("<option value=""+11" + Chr(34))
                    'If _timeOffset = 11 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +11:00 hours) Magadan, Solomon Islands, New Caledonia</option>")
                    'pfTable.Append("<option value=""+12" + Chr(34))
                    'If _timeOffset = 12 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +12:00 hours) Auckland, Wellington, Fiji, Kamchatka</option>")
                    'pfTable.Append("</select></td></tr>")

                    ''-- forum style
                    'pfTable.Append("<tr><td class=""msgFormDesc"" valign=""top"" height=""20"" ><b>Forum Style :</b><div class=""msgFormDescSm"">If enabled, you can select from multiple styles that will change the appearance of the forum.</div></td>")
                    'pfTable.Append("<td class=""msgFormBody""><select name=""fstyle"" class=""msgSm"">")
                    'Dim styleFolders() As String = Directory.GetFileSystemEntries(Server.MapPath(siteRoot + "/styles"))
                    'Dim di As New DirectoryInfo(Server.MapPath(siteRoot + "/styles"))
                    'Dim diArr As DirectoryInfo() = di.GetDirectories
                    'Dim dri As DirectoryInfo
                    'For Each dri In diArr
                    '    If dri.Name.ToString.ToLower = defaultStyle.ToLower Then
                    '        pfTable.Append("<option selected>" + Server.HtmlEncode(dri.Name.ToString) + "</option>")
                    '    Else
                    '        pfTable.Append("<option>" + Server.HtmlEncode(dri.Name.ToString) + "</option>")
                    '    End If
                    'Next
                    'pfTable.Append("</select></td></tr>")


                    ''-- Signature
                    'If _eu23 = True Then
                    '    pfTable.Append("<tr><td class=""msgFormDesc"" valign=""top"" height=""20"" ><b>Signature :</b><div class=""msgFormDescSm"">Please enter an optional signature to be included in your posts. &nbsp;HTML is not allowed.<br />Use <a href=" + Chr(34) + siteRoot + "/mCode.aspx"" target=""_blank"">TBCode</a> for common HTML replacements.</div></td>")
                    '    pfTable.Append("<td class=""msgFormBody""><textarea class=""msgFormTextBox"" name=""signa"">" + _editSignature + "</textarea></td></tr>")
                    'End If

                    ''-- Avatar
                    'If _eu14 = True Then
                    '    pfTable.Append("<tr><td class=""msgFormDesc"" valign=""top"" height=""20"" ><b>Avatar :</b><div class=""msgFormDescSm"">You can choose from the available avatar's on this site")
                    '    If _eu15 = True Then
                    '        pfTable.Append(", or you can enter the URL to your personal avatar hosted elsewhere.")
                    '    Else
                    '        pfTable.Append(".")
                    '    End If
                    '    pfTable.Append("</div></td>")
                    '    pfTable.Append("<td class=""msgFormBody"">Available avatars :<br /><table border=""0"" cellpadding=""3"" cellspacing=""0""><tr><td><select name=""ava1"" class=""msgSm"" size=""5"" onchange=""swapAvatar(this.value)"">")
                    '    pfTable.Append("<option value=""blank.gif"">No Avatar</option>")

                    '    dataConn = New SqlConnection(connStr)
                    '    dataCmd = New SqlCommand("TB_ActiveAvatars", dataConn)
                    '    dataCmd.CommandType = CommandType.StoredProcedure
                    '    dataConn.Open()
                    '    dataRdr = dataCmd.ExecuteReader
                    '    If dataRdr.IsClosed = False Then
                    '        While dataRdr.Read
                    '            If dataRdr.IsDBNull(0) = False Then
                    '                If dataRdr.Item(0) = _uAvatar Then
                    '                    pfTable.Append("<option value=" + Chr(34) + dataRdr.Item(0) + Chr(34) + " selected>" + dataRdr.Item(0) + "</option>")
                    '                Else
                    '                    pfTable.Append("<option value=" + Chr(34) + dataRdr.Item(0) + Chr(34) + ">" + dataRdr.Item(0) + "</option>")
                    '                End If

                    '            End If
                    '        End While
                    '        dataRdr.Close()
                    '        dataConn.Close()
                    '    End If
                    '    pfTable.Append("</select></td><td width=""150"" class=""msgFormBody"" align=""center"" valign=""top"">Avatar Preview<br />")
                    '    If _uAvatar <> String.Empty And Left(_uAvatar, 7).ToLower <> "http://" Then
                    '        pfTable.Append("<img src=" + Chr(34) + siteRoot + "/avatar/" + _uAvatar + Chr(34) + " name=""avaImg"" id=""avaImg"">")
                    '    ElseIf Left(_uAvatar, 7).ToLower = "http://" Then
                    '        pfTable.Append("<img src=" + Chr(34) + _uAvatar + Chr(34) + " name=""avaImg"" id=""avaImg"">")
                    '    Else
                    '        pfTable.Append("<img src=" + Chr(34) + siteRoot + "/avatar/blank.gif"" name=""avaImg"" id=""avaImg"">")
                    '    End If


                    '    pfTable.Append("</td></tr></table>")
                    '    If _uAvatar.Trim <> String.Empty Then
                    '        If Left(_uAvatar, 7).ToLower <> "http://" Then
                    '            _uAvatar = "http://www."
                    '        End If
                    '    Else
                    '        _uAvatar = "http://www."
                    '    End If
                    '    If _eu15 = True Then
                    '        pfTable.Append("OR<br />You can enter the URL to your avatar :<br /><input type=""text"" class=""msgFormInput"" name=""ava2"" maxLength=""150"" value=" + Chr(34) + _uAvatar + Chr(34) + "></td></tr>")
                    '    End If


                    'End If

                    ''-- Private messaging

                    'pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" valign=""top"">Private Messaging<div class=""msgFormDescSm"">This forum supports private messaging (PM) between registered members.  NOTE : Disabling PM will block both incoming and outgoing messages.</div></td>")
                    'pfTable.Append("<td class=""msgFormBody"" valign=""top"">")
                    'If _eu30 = False Then
                    '    pfTable.Append("Private messaging for the forum has been disabled by an administrator.")
                    'ElseIf _pmLock = False And uGUID <> GUEST_GUID Then
                    '    pfTable.Append("Private messaging for this account has been disabled by an administrator.")
                    'Else
                    '    pfTable.Append("Use Private Messaging : &nbsp; ")
                    '    pfTable.Append("<input type=""radio"" name=""upm"" value=""1" + Chr(34))
                    '    If _usePM = True Then
                    '        pfTable.Append(" checked")
                    '    End If
                    '    pfTable.Append("> - Yes &nbsp")
                    '    pfTable.Append("<input type=""radio"" name=""upm"" value=""0" + Chr(34))
                    '    If _usePM = False Then
                    '        pfTable.Append(" checked")
                    '    End If
                    '    pfTable.Append("> - No &nbsp<br />")
                    '    pfTable.Append("Popup notification of new messages : &nbsp; ")
                    '    pfTable.Append("<input type=""radio"" name=""pup"" value=""1" + Chr(34))
                    '    If _pmPopUp = True Then
                    '        pfTable.Append(" checked")
                    '    End If
                    '    pfTable.Append("> - Yes &nbsp")
                    '    pfTable.Append("<input type=""radio"" name=""pup"" value=""0" + Chr(34))
                    '    If _pmPopUp = False Then
                    '        pfTable.Append(" checked")
                    '    End If
                    '    pfTable.Append("> - No &nbsp<br />")
                    '    pfTable.Append("E-mail notification of new messages : &nbsp; ")
                    '    pfTable.Append("<input type=""radio"" name=""pem"" value=""1" + Chr(34))
                    '    If _pmEmail = True Then
                    '        pfTable.Append(" checked")
                    '    End If
                    '    pfTable.Append("> - Yes &nbsp")
                    '    pfTable.Append("<input type=""radio"" name=""pem"" value=""0" + Chr(34))
                    '    If _pmEmail = False Then
                    '        pfTable.Append(" checked")
                    '    End If
                    '    pfTable.Append("> - No &nbsp<br />")

                    'End If

                    'pfTable.Append("</td></tr>")


                    '-- Terms of Service
                    If File.Exists(Server.MapPath(siteRoot + "/xml/tos.xml")) = True Then
                        Dim isHead As Boolean = False
                        Dim isBody As Boolean = False
                        Dim xRdr As New XmlTextReader(Server.MapPath(siteRoot + "/xml/tos.xml"))
                        pfTable.Append("<tr><td class=""msgFormBody"" height=""20"" valign=""top"" colspan=""2""><b>" + getHashVal("user", "52") + "</b><br />")
                        'pfTable.Append("<td class=""msgFormBody"">")
                        While xRdr.Read
                            If xRdr.Name.ToString.ToLower = "sectionhead" Then
                                isHead = True
                                isBody = False
                            ElseIf xRdr.Name.ToString.ToLower = "sectionbody" Then
                                isBody = True
                                isHead = False
                            End If
                            Select Case xRdr.NodeType
                                Case XmlNodeType.Text
                                    If isHead = True Then
                                        pfTable.Append("<b>" + xRdr.Value + "</b><br />")
                                    End If
                                    If isBody = True Then
                                        pfTable.Append(xRdr.Value + "<br /><br />")
                                    End If
                            End Select
                        End While
                        xRdr.Close()
                        pfTable.Append("</td></tr>")
                    End If

                    '-- buttons
                    pfTable.Append("<tr><td class=""msgSmRow"" height=""20"" >&nbsp;</td>")
                    pfTable.Append("<td class=""msgSmRow"">")
                    pfTable.Append("<input type=""submit"" name=""sButton"" value=" + Chr(34) + getHashVal("user", "53") + Chr(34) + " class=""msgButton"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"">&nbsp;")
                    pfTable.Append("<input type=""button"" name=""cButton"" value=" + Chr(34) + getHashVal("user", "54") + Chr(34) + " class=""msgButton"" onclick=""window.location.href='" + siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + "';"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"">")

                    pfTable.Append("</td></tr></form>")

                    '-- end spacer
                    pfTable.Append("<tr><td colspan=""2"">&nbsp;</td></tr>")

                    '----------------
                    '-- COPPA PRINTABLE VERSION BELOW
                ElseIf showForm = True And _isPrintable = True Then     '-- not normal, using COPPA
                    pfTable.Append("<script language=javascript>" + vbCrLf)
                    pfTable.Append("<!--" + vbCrLf)
                    pfTable.Append("function swapAvatar(imgName) { " + vbCrLf)
                    pfTable.Append("nImg = new Image();" + vbCrLf)
                    pfTable.Append("nImg.src='" + siteRoot + "/avatar/'+imgName;" + vbCrLf)
                    pfTable.Append("document.images['avaImg'].src = eval('nImg.src');" + vbCrLf)
                    pfTable.Append("}" + vbCrLf)
                    pfTable.Append("-->" + vbCrLf)
                    pfTable.Append("</script>" + vbCrLf)
                    pfTable.Append("<tr><td class=""msgFormHead"" height=""20"" colspan=""2"">" + getHashVal("user", "55") + "</td></tr>")
                    pfTable.Append("<tr><td class=""msgSm"" height=""20"" colspan=""2""><b>" + getHashVal("user", "56") + "</b><br />")
                    pfTable.Append(getHashVal("user", "57"))
                    pfTable.Append(getHashVal("user", "58") + siteURL + siteRoot + "/.")
                    pfTable.Append("<br /<br />" + getHashVal("user", "59") + "<br />")
                    If _eu34 = "" Then
                        pfTable.Append(getHashVal("user", "60") + "<br /><br />")
                    Else
                        _eu34 = _eu34.Replace(vbCrLf, "<br />")
                        pfTable.Append(_eu34 + "<br /><br />")
                    End If
                    pfTable.Append("or fax to ")
                    If _eu33 = "" Then
                        pfTable.Append(getHashVal("use", "61"))
                    Else
                        pfTable.Append(_eu33)
                    End If
                    pfTable.Append("</td></tr>")

                    pfTable.Append("<tr><td class=""msgTopicHead"" colspan=""2"" align=""center"">" + getHashVal("user", "62") + "</td></tr>")
                    pfTable.Append("<form >")
                    pfTable.Append("<input type=""hidden"" name=""f"" value=" + Chr(34) + _forumID.ToString + Chr(34) + ">")
                    pfTable.Append("<input type=""hidden"" name=""m"" value=" + Chr(34) + _messageID.ToString + Chr(34) + ">")
                    pfTable.Append("<input type=""hidden"" name=""np"" value=" + Chr(34) + _createNew.ToString + Chr(34) + ">")
                    '-- real name
                    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>" + getHashVal("user", "42") + "</b><div class=""msgFormDescSm"">" + getHashVal("user", "43") + "</div></td>")
                    pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""coppaInput"" name=""rn"" maxLength=""100"" value=" + Chr(34) + _realname + Chr(34) + "></td></tr>")
                    '-- user name
                    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>" + getHashVal("user", "44") + "</b><div class=""msgFormDescSm"">")
                    If _userName.ToString.Trim = String.Empty Or _createNew = True Then
                        pfTable.Append(getHashVal("user", "45"))
                        pfTable.Append("</div></td><td class=""msgFormBody""><input type=""text"" class=""coppaInput"" name=""un"" maxLength=""50"" value=" + Chr(34) + _userName + Chr(34) + "></td></tr>")
                    Else
                        pfTable.Append(getHashVal("user", "140"))
                        pfTable.Append("<input type=""hidden"" name=""un"" value=" + Chr(34) + _userName + Chr(34) + ">")
                        pfTable.Append("</div></td><td class=""msgFormBody"">" + _userName + "</td></tr>")
                    End If
                    '-- password
                    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>" + getHashVal("user", "46") + "</b><div class=""msgFormDescSm"">" + getHashVal("user", "47") + "</div></td>")
                    pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""coppaInput"" name=""pw"" maxLength=""50"" value=" + Chr(34) + _userPass + Chr(34) + "></td></tr>")
                    '-- email
                    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>" + getHashVal("user", "50") + "</b><div class=""msgFormDescSm"">" + getHashVal("user", "51") + "</div></td>")
                    pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""coppaInput"" name=""em"" maxLength=""64"" value=" + Chr(34) + _userEmail + Chr(34) + "></td></tr>")
                    '------------------------
                    '-- begin optional items

                    '-- v2 NOTE : optional items removed from initial registration
                    'pfTable.Append("<tr><td class=""msgTopicHead"" colspan=""2"" align=""center"">Optional Information</td></tr>")

                    ''-- show email
                    'If _eu21 = True Then
                    '    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" width=""305""><b>Show Your E-Mail Address :</b><br /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/mail.gif"" border=""0"" height=""27"" width=""25"" alt=""Show your e-mail address"" align=""left""><div class=""msgFormDescSm"">You have the option to show your e-mail address with your posts.</div></td>")
                    '    pfTable.Append("<td class=""msgFormBody"">")
                    '    pfTable.Append("<input type=""radio"" name=""se"" value=""1" + Chr(34))
                    '    If _showEmail = 1 Then
                    '        pfTable.Append(" checked")
                    '    End If
                    '    pfTable.Append("> - Show my E-Mail address<br />")
                    '    pfTable.Append("<input type=""radio"" name=""se"" value=""0" + Chr(34))
                    '    If _showEmail = 0 Then
                    '        pfTable.Append(" checked")
                    '    End If
                    '    pfTable.Append("> - Hide my E-Mail address<br />")
                    '    pfTable.Append("</td></tr>")
                    'End If

                    ''-- homepage
                    'If _eu22 = True Then
                    '    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" width=""305""><b>Personal Homepage :</b><br /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/home.gif"" border=""0"" height=""27"" width=""25"" alt=""Personal Homepage"" align=""left""><div class=""msgFormDescSm"">If you have a web site, enter the URL here.</div></td>")
                    '    pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""coppaInput"" name=""url"" maxLength=""200"" value=" + Chr(34) + _homePage + Chr(34) + "></td></tr>")
                    'End If

                    ''-- AOL IM
                    'If _eu17 = True Then
                    '    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" width=""305""><b>AOL Instant Messenger :</b><br /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/aim.gif"" border=""0"" height=""27"" width=""25"" alt=""AOL Instant Messenger"" align=""left""><div class=""msgFormDescSm"">Enter your AIM screen name so people can contact you using AIM.</div></td>")
                    '    pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""coppaInput"" name=""aim"" style=""width:200px;"" maxLength=""50"" value=" + Chr(34) + _aimName + Chr(34) + "></td></tr>")
                    'End If

                    ''-- ICQ number
                    'If _eu20 = True Then
                    '    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" width=""305""><b>ICQ Number :</b><br /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/icq.gif"" border=""0"" height=""27"" width=""25"" alt=""ICQ Number"" align=""left""><div class=""msgFormDescSm"">Enter your ICQ number so people can contact you using ICQ.</div></td>")
                    '    pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""coppaInput"" name=""icq"" style=""width:200px;"" maxLength=""20"" value=")
                    '    If _icqNumber > 0 Then
                    '        pfTable.Append(Chr(34) + _icqNumber.ToString + Chr(34) + "></td></tr>")
                    '    Else
                    '        pfTable.Append(Chr(34) + Chr(34) + "></td></tr>")
                    '    End If
                    'End If

                    ''-- Y! Pager
                    'If _eu18 = True Then
                    '    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" width=""305""><b>Y! Pager :</b><br /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/y!.gif"" border=""0"" height=""27"" width=""25"" alt=""Y! Pager"" align=""left""><div class=""msgFormDescSm"">Enter your Y! screen name so people can contact you using the Yahoo Pager.</div></td>")
                    '    pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""coppaInput"" name=""ypa"" style=""width:200px;"" maxLength=""50"" value=" + Chr(34) + _yPager + Chr(34) + "></td></tr>")
                    'End If

                    ''-- MSN Messenger
                    'If _eu19 = True Then
                    '    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" width=""305""><b>MSN Messenger :</b><br /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/msnm.gif"" border=""0"" height=""27"" width=""25"" alt=""MSN Messenger"" align=""left""><div class=""msgFormDescSm"">Enter your MSN Messenger name so people can contact you using MSN Messenger.</div></td>")
                    '    pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""coppaInput"" name=""msnm"" style=""width:200px;"" maxLength=""64"" value=" + Chr(34) + _msnName + Chr(34) + "></td></tr>")
                    'End If

                    ''-- City/state location
                    'pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" width=""305""><b>Location :</b><div class=""msgFormDescSm"">Where in the world people might find you if they were looking.</div></td>")
                    'pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""coppaInput"" name=""loca"" maxLength=""100"" value=" + Chr(34) + _uLocation + Chr(34) + "></td></tr>")

                    ''-- Occupation
                    'pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" width=""305""><b>Occupation :</b><div class=""msgFormDescSm"">What do you do for a living?</div></td>")
                    'pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""coppaInput"" name=""occu"" maxLength=""150"" value=" + Chr(34) + _uOccupation + Chr(34) + "></td></tr>")

                    ''-- Interests
                    'pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" width=""305"" valign=""top""><b>Personal Interests :</b><div class=""msgFormDescSm"">Any additional interests or hobbies you would like to share about yourself?</div></td>")
                    'pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""coppaInput"" name=""inter"" maxLength=""150"" value=" + Chr(34) + _uInterests + Chr(34) + "></td></tr>")

                    ''-- Time Offset
                    'pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" valign=""top""><b>Time Offset :</b><div class=""msgFormDescSm"">All times shown are (GMT")
                    'If _eu31 <> 0 And _timeOffset = 0 Then
                    '    If _eu31 > 0 Then
                    '        pfTable.Append(" +" + _eu31.ToString)
                    '    Else
                    '        pfTable.Append(_eu31.ToString)
                    '    End If
                    'End If
                    'pfTable.Append(") unless you change it here.<br />NOTE : Daylight savings is not calculated in the time offset.</div></td>")
                    'pfTable.Append("<td class=""msgFormBody""><select name=""tof"" class=""msgSm"">")
                    'pfTable.Append("<option value=""-12" + Chr(34))
                    'If _timeOffset = -12 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -12:00 hours) Eniwetok, Kwajalein</option>")
                    'pfTable.Append("<option value=""-11" + Chr(34))
                    'If _timeOffset = -11 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -11:00 hours) Midway Island, Samoa</option>")
                    'pfTable.Append("<option value=""-10" + Chr(34))
                    'If _timeOffset = -10 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -10:00 hours) Hawaii</option>")
                    'pfTable.Append("<option value=""-9" + Chr(34))
                    'If _timeOffset = -9 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -9:00 hours) Alaska</option>")
                    'pfTable.Append("<option value=""-8" + Chr(34))
                    'If _timeOffset = -8 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -8:00 hours) Pacific Time (US & Canada)</option>")
                    'pfTable.Append("<option value=""-7" + Chr(34))
                    'If _timeOffset = -7 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -7:00 hours) Mountain Time (US & Canada)</option>")
                    'pfTable.Append("<option value=""-6" + Chr(34))
                    'If _timeOffset = -6 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -6:00 hours) Central Time (US & Canada), Mexico City</option>")
                    'pfTable.Append("<option value=""-5" + Chr(34))
                    'If _timeOffset = -5 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -5:00 hours) Eastern Time (US & Canada), Bogota</option>")
                    'pfTable.Append("<option value=""-4" + Chr(34))
                    'If _timeOffset = -4 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -4:00 hours) Atlantic Time (Canada), Caracas</option>")
                    'pfTable.Append("<option value=""-3.5" + Chr(34))
                    'If _timeOffset = -3.5 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -3:30 hours) Newfoundland</option>")
                    'pfTable.Append("<option value=""-3" + Chr(34))
                    'If _timeOffset = -3 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -3:00 hours) Brazil, Buenos Aires, Georgetown</option>")
                    'pfTable.Append("<option value=""-2" + Chr(34))
                    'If _timeOffset = -2 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -2:00 hours) Mid-Atlantic</option>")
                    'pfTable.Append("<option value=""-1" + Chr(34))
                    'If _timeOffset = -1 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT -1:00 hours) Azores, Cape Verde Islands</option>")
                    'pfTable.Append("<option value=""0" + Chr(34))
                    'If _timeOffset = 0 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT) Western Europe Time, London, Lisbon</option>")
                    'pfTable.Append("<option value=""+1" + Chr(34))
                    'If _timeOffset = 1 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +1:00 hours) CET(Central Europe Time), Brussels, Paris</option>")
                    'pfTable.Append("<option value=""+2" + Chr(34))
                    'If _timeOffset = 1 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +2:00 hours) EET(Eastern Europe Time), South Africa</option>")
                    'pfTable.Append("<option value=""+3" + Chr(34))
                    'If _timeOffset = 3 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +3:00 hours) Baghdad, Riyadh, Moscow, St. Petersburg</option>")
                    'pfTable.Append("<option value=""+3.5" + Chr(34))
                    'If _timeOffset = 3.5 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +3:30 hours) Tehran</option>")
                    'pfTable.Append("<option value=""+4" + Chr(34))
                    'If _timeOffset = 4 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +4:00 hours) Abu Dhabi, Muscat, Baku, Tbilisi</option>")
                    'pfTable.Append("<option value=""+4.5" + Chr(34))
                    'If _timeOffset = 4.5 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +4:30 hours) Kabul</option>")
                    'pfTable.Append("<option value=""+5" + Chr(34))
                    'If _timeOffset = 5 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +5:00 hours) Ekaterinburg, Islamabad, Karachi, Tashkent</option>")
                    'pfTable.Append("<option value=""+5.5" + Chr(34))
                    'If _timeOffset = 5.5 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +5:30 hours) Bombay, Calcutta, Madras, New Delhi</option>")
                    'pfTable.Append("<option value=""+6" + Chr(34))
                    'If _timeOffset = 6 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +6:00 hours) Almaty, Dhaka, Colombo</option>")
                    'pfTable.Append("<option value=""+7" + Chr(34))
                    'If _timeOffset = 7 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +7:00 hours) Bangkok, Hanoi, Jakarta</option>")
                    'pfTable.Append("<option value=""+8" + Chr(34))
                    'If _timeOffset = 8 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +8:00 hours) Beijing, Perth, Singapore, Hong Kong</option>")
                    'pfTable.Append("<option value=""+9" + Chr(34))
                    'If _timeOffset = 9 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +9:00 hours) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>")
                    'pfTable.Append("<option value=""+9.5" + Chr(34))
                    'If _timeOffset = 9.5 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +9:30 hours) Adelaide, Darwin</option>")
                    'pfTable.Append("<option value=""+10" + Chr(34))
                    'If _timeOffset = 10 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +10:00 hours) EAST(East Australian Standard), Guam</option>")
                    'pfTable.Append("<option value=""+11" + Chr(34))
                    'If _timeOffset = 11 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +11:00 hours) Magadan, Solomon Islands, New Caledonia</option>")
                    'pfTable.Append("<option value=""+12" + Chr(34))
                    'If _timeOffset = 12 Then
                    '    pfTable.Append(" selected")
                    'End If
                    'pfTable.Append(">(GMT +12:00 hours) Auckland, Wellington, Fiji, Kamchatka</option>")
                    'pfTable.Append("</select></td></tr>")

                    ''-- forum style
                    'pfTable.Append("<tr><td class=""msgFormDesc"" valign=""top"" height=""20"" width=""305""><b>Forum Style :</b><div class=""msgFormDescSm"">If enabled, you can select from multiple styles that will change the appearance of the forum.</div></td>")
                    'pfTable.Append("<td class=""msgFormBody""><select name=""fstyle"" class=""msgSm"">")
                    'Dim styleFolders() As String = Directory.GetFileSystemEntries(Server.MapPath(siteRoot + "/styles"))
                    'Dim di As New DirectoryInfo(Server.MapPath(siteRoot + "/styles"))
                    'Dim diArr As DirectoryInfo() = di.GetDirectories
                    'Dim dri As DirectoryInfo
                    'For Each dri In diArr
                    '    If dri.Name.ToString.ToLower = defaultStyle.ToLower Then
                    '        pfTable.Append("<option selected>" + Server.HtmlEncode(dri.Name.ToString) + "</option>")
                    '    Else
                    '        pfTable.Append("<option>" + Server.HtmlEncode(dri.Name.ToString) + "</option>")
                    '    End If
                    'Next
                    'pfTable.Append("</select></td></tr>")


                    ''-- Signature
                    'If _eu23 = True Then
                    '    pfTable.Append("<tr><td class=""msgFormDesc"" valign=""top"" height=""20"" width=""305""><b>Signature :</b><div class=""msgFormDescSm"">Please enter an optional signature to be included in your posts. &nbsp;HTML is not allowed.<br />Use <a href=" + Chr(34) + siteRoot + "/mCode.aspx"" target=""_blank"">TBCode</a> for common HTML replacements.</div></td>")
                    '    pfTable.Append("<td class=""msgFormBody""><textarea class=""coppaInput"" name=""signa"">" + _editSignature + "</textarea></td></tr>")
                    'End If

                    ''-- Avatar
                    'If _eu14 = True Then
                    '    pfTable.Append("<tr><td class=""msgFormDesc"" valign=""top"" height=""20"" width=""305""><b>Avatar :</b><div class=""msgFormDescSm"">You can choose from the available avatar's on this site")
                    '    If _eu15 = True Then
                    '        pfTable.Append(", or you can enter the URL to your personal avatar hosted elsewhere.")
                    '    Else
                    '        pfTable.Append(".")
                    '    End If
                    '    pfTable.Append("</div></td>")
                    '    pfTable.Append("<td class=""msgFormBody"">Available avatars :<br /><table border=""0"" cellpadding=""3"" cellspacing=""0""><tr><td><select name=""ava1"" class=""msgSm"" size=""5"" onchange=""swapAvatar(this.value)"">")
                    '    pfTable.Append("<option value=""blank.gif"">No Avatar</option>")

                    '    dataConn = New SqlConnection(connStr)
                    '    dataCmd = New SqlCommand("TB_ActiveAvatars", dataConn)
                    '    dataCmd.CommandType = CommandType.StoredProcedure
                    '    dataConn.Open()
                    '    dataRdr = dataCmd.ExecuteReader
                    '    If dataRdr.IsClosed = False Then
                    '        While dataRdr.Read
                    '            If dataRdr.IsDBNull(0) = False Then
                    '                If dataRdr.Item(0) = _uAvatar Then
                    '                    pfTable.Append("<option value=" + Chr(34) + dataRdr.Item(0) + Chr(34) + " selected>" + dataRdr.Item(0) + "</option>")
                    '                Else
                    '                    pfTable.Append("<option value=" + Chr(34) + dataRdr.Item(0) + Chr(34) + ">" + dataRdr.Item(0) + "</option>")
                    '                End If

                    '            End If
                    '        End While
                    '        dataRdr.Close()
                    '        dataConn.Close()
                    '    End If
                    '    pfTable.Append("</select></td><td width=""150"" class=""msgFormBody"" align=""center"" valign=""top"">Avatar Preview<br />")
                    '    If _uAvatar <> String.Empty And Left(_uAvatar, 7).ToLower <> "http://" Then
                    '        pfTable.Append("<img src=" + Chr(34) + siteRoot + "/avatar/" + _uAvatar + Chr(34) + " name=""avaImg"" id=""avaImg"">")
                    '    ElseIf Left(_uAvatar, 7).ToLower = "http://" Then
                    '        pfTable.Append("<img src=" + Chr(34) + _uAvatar + Chr(34) + " name=""avaImg"" id=""avaImg"">")
                    '    Else
                    '        pfTable.Append("<img src=" + Chr(34) + siteRoot + "/avatar/blank.gif"" name=""avaImg"" id=""avaImg"">")
                    '    End If


                    '    pfTable.Append("</td></tr></table>")
                    '    If _uAvatar.Trim <> String.Empty Then
                    '        If Left(_uAvatar, 7).ToLower <> "http://" Then
                    '            _uAvatar = "http://www."
                    '        End If
                    '    Else
                    '        _uAvatar = "http://www."
                    '    End If
                    '    If _eu15 = True Then
                    '        pfTable.Append("OR<br />You can enter the URL to your avatar :<br /><input type=""text"" class=""coppaInput"" name=""ava2"" maxLength=""150"" value=" + Chr(34) + _uAvatar + Chr(34) + "></td></tr>")
                    '    End If


                    'End If

                    ''-- Private messaging

                    'pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" valign=""top"">Private Messaging<div class=""msgFormDescSm"">This forum supports private messaging (PM) between registered members.  NOTE : Disabling PM will block both incoming and outgoing messages.</div></td>")
                    'pfTable.Append("<td class=""msgFormBody"" valign=""top"">")
                    'If _eu30 = False Then
                    '    pfTable.Append("Private messaging for the forum has been disabled by an administrator.")
                    'ElseIf _pmLock = False And uGUID <> GUEST_GUID Then
                    '    pfTable.Append("Private messaging for this account has been disabled by an administrator.")
                    'Else
                    '    pfTable.Append("Use Private Messaging : &nbsp; ")
                    '    pfTable.Append("<input type=""radio"" name=""upm"" value=""1" + Chr(34))
                    '    If _usePM = True Then
                    '        pfTable.Append(" checked")
                    '    End If
                    '    pfTable.Append("> - Yes &nbsp")
                    '    pfTable.Append("<input type=""radio"" name=""upm"" value=""0" + Chr(34))
                    '    If _usePM = False Then
                    '        pfTable.Append(" checked")
                    '    End If
                    '    pfTable.Append("> - No &nbsp<br />")
                    '    pfTable.Append("Popup notification of new messages : &nbsp; ")
                    '    pfTable.Append("<input type=""radio"" name=""pup"" value=""1" + Chr(34))
                    '    If _pmPopUp = True Then
                    '        pfTable.Append(" checked")
                    '    End If
                    '    pfTable.Append("> - Yes &nbsp")
                    '    pfTable.Append("<input type=""radio"" name=""pup"" value=""0" + Chr(34))
                    '    If _pmPopUp = False Then
                    '        pfTable.Append(" checked")
                    '    End If
                    '    pfTable.Append("> - No &nbsp<br />")
                    '    pfTable.Append("E-mail notification of new messages : &nbsp; ")
                    '    pfTable.Append("<input type=""radio"" name=""pem"" value=""1" + Chr(34))
                    '    If _pmEmail = True Then
                    '        pfTable.Append(" checked")
                    '    End If
                    '    pfTable.Append("> - Yes &nbsp")
                    '    pfTable.Append("<input type=""radio"" name=""pem"" value=""0" + Chr(34))
                    '    If _pmEmail = False Then
                    '        pfTable.Append(" checked")
                    '    End If
                    '    pfTable.Append("> - No &nbsp<br />")

                    'End If

                    'pfTable.Append("</td></tr>")

                    '-- approval information
                    pfTable.Append("<tr><td class=""msgTopicHead"" colspan=""2"" height=""20"">" + getHashVal("user", "63") + "</td></tr>")
                    pfTable.Append("<tr><td class=""msgFormBody"" colspan=""2"" height=""20"">" + getHashVal("user", "64") + "</td></tr>")
                    '-- 
                    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" width=""305""><b>" + getHashVal("user", "65") + "</b></td>")
                    pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""coppaInput"" maxLength=""200""></td></tr>")
                    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" width=""305""><b>" + getHashVal("user", "66") + "</b></td>")
                    pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""coppaInput"" maxLength=""200""></td></tr>")
                    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" width=""305""><b>" + getHashVal("user", "67") + "</b></td>")
                    pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""coppaInput"" maxLength=""200""></td></tr>")
                    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" width=""305""><b>" + getHashVal("user", "68") + "</b></td>")
                    pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""coppaInput"" maxLength=""200""></td></tr>")
                    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" width=""305""><b>" + getHashVal("user", "69") + "</b></td>")
                    pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""coppaInput"" maxLength=""200""></td></tr>")
                    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" width=""305""><b>" + getHashVal("user", "70") + "</b></td>")
                    pfTable.Append("<td class=""msgFormBody""><input type=""text"" class=""coppaInput"" maxLength=""200""></td></tr>")
                    pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" colspan=""2""><b>" + getHashVal("user", "71") + siteAdmin + getHashVal("user", "72") + siteAdminMail + getHashVal("user", "73") + "</b></td></tr>")

                    '-- Terms of Service
                    If File.Exists(Server.MapPath(siteRoot + "/xml/tos.xml")) = True Then
                        Dim isHead As Boolean = False
                        Dim isBody As Boolean = False
                        Dim xRdr As New XmlTextReader(Server.MapPath(siteRoot + "/xml/tos.xml"))
                        pfTable.Append("<tr><td class=""msgFormDesc"" height=""20"" width=""305"" valign=""top""><b>" + getHashVal("user", "52") + "</b></td>")
                        pfTable.Append("<td class=""msgFormBody"">")
                        While xRdr.Read
                            If xRdr.Name.ToString.ToLower = "sectionhead" Then
                                isHead = True
                                isBody = False
                            ElseIf xRdr.Name.ToString.ToLower = "sectionbody" Then
                                isBody = True
                                isHead = False
                            End If
                            Select Case xRdr.NodeType
                                Case XmlNodeType.Text
                                    If isHead = True Then
                                        pfTable.Append("<b>" + xRdr.Value + "</b><br />")
                                    End If
                                    If isBody = True Then
                                        pfTable.Append(xRdr.Value + "<br /><br />")
                                    End If
                            End Select
                        End While
                        xRdr.Close()
                        pfTable.Append("</td></tr>")
                    End If

                    '-- buttons
                    pfTable.Append("<tr><td class=""msgSmRow"" height=""20"" width=""305"">&nbsp;</td>")
                    pfTable.Append("<td class=""msgSmRow"">")
                    pfTable.Append("<input type=""button"" name=""cButton"" value=" + Chr(34) + getHashVal("user", "54") + Chr(34) + " class=""msgButton"" onclick=""window.location.href='" + siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + "';"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"">")

                    pfTable.Append("</td></tr></form>")

                    '-- end spacer
                    pfTable.Append("<tr><td colspan=""2"">&nbsp;</td></tr>")
                End If
                pfTable.Append("</table>")
                pfTable.Append(printCopyright())
            Catch ex As Exception
                logErrorMsg("profileForm<br />" + ex.StackTrace.ToString, 1)
            End Try
            Return pfTable.ToString
        End Function

        '-- returns the redirect string based on site root back to specified forum or message thread
        Public Function RedirBounce() As String
            Dim rb As String = siteRoot + "/"
            Try

                If _forumID > 0 Then
                    rb += "?f=" + _forumID.ToString
                    If _messageID > 0 Then
                        rb += "&m=" + _messageID.ToString
                    End If
                End If
            Catch ex As Exception
                logErrorMsg("RedirBounce<br />" + ex.StackTrace.ToString, 1)
            End Try
            Return rb
        End Function

        '-- sets the user cookies
        Public Sub setUserCookie(ByVal key As String, ByVal value As String)
            If _eu36 = False Then
                Dim cookie As New HttpCookie(key)
                Dim cookieAge As Integer = _eu27
                cookie.Values.Add(key, value)
                cookie.Expires = DateAdd(DateInterval.Day, cookieAge, DateTime.Now)
                HttpContext.Current.Response.AppendCookie(cookie)
            End If
        End Sub

        '-- loads the correct user control panel function
        Public Function userCP(ByVal uGUID As String) As String
            Dim ucp As New StringBuilder("")
            ucp.Append(userControlPanel(uGUID))
            Return ucp.ToString
        End Function

        '-- public forum profile view
        Public Function viewProfile(ByVal uGUID As String) As String
            Call initializeLocks()

            If userStrLoaded = False Then
                userStrLoaded = xmlLoadStringMsg("user")
            End If
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            Dim vpTable As New StringBuilder()
            If _eu13 = False Then    '-- view profiles as guest
                If uGUID = GUEST_GUID Then
                    vpTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" height=""300"">")
                    vpTable.Append("<tr><td class=""msgSm"" align=""center"" height=""20"" ><br /><b>" + getHashVal("user", "74") + "</b><br /><br />" + getHashVal("user", "75") + "<a href=" + Chr(34) + siteRoot + "/l.aspx"">" + getHashVal("user", "76") + "</a>" + getHashVal("user", "77") + "</td></tr>")
                    vpTable.Append("<tr><td>&nbsp;</td></tr></table>")
                    vpTable.Append(printCopyright())
                    Return vpTable.ToString
                    Exit Function
                End If
            End If
            vpTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
            Try
                If _userID > 0 Then
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_ViewProfile", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@UserID", SqlDbType.Int)
                    dataParam.Value = _userID
                    dataConn.Open()
                    dataRdr = dataCmd.ExecuteReader
                    If dataRdr.IsClosed = False Then
                        While dataRdr.Read
                            vpTable.Append("<tr><td class=""msgFormHead"" height=""20"" colspan=""2"">" + getHashVal("user", "78") + dataRdr.Item(0) + "</td></tr>")

                            vpTable.Append("<tr><td class=""msgSm"" height=""20"" valign=""top"" width=""40%""><table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
                            vpTable.Append("<tr><td class=""msgTopicHead"" height=""20""><b>" + getHashVal("user", "79") + "<b></td><td class=""msgTopicHead"" height=""20"">&nbsp;</td></tr>")
                            '-- profile create date
                            vpTable.Append("<tr><td class=""msgSm"" height=""20"" align=""right"" width=""125""><b>" + getHashVal("user", "80") + "</b></td><td class=""msgSm"">")
                            If dataRdr.IsDBNull(7) = False Then
                                If CStr(dataRdr.Item(7)).Trim <> String.Empty Then
                                    vpTable.Append(FormatDateTime(dataRdr.Item(7), DateFormat.LongDate) + "</td></tr>")
                                Else
                                    vpTable.Append(getHashVal("user", "81") + "</td></tr>")
                                End If
                            Else
                                vpTable.Append(getHashVal("user", "81") + "</td></tr>")
                            End If
                            '-- last post
                            vpTable.Append("<tr><td class=""msgSm"" height=""20"" align=""right""><b>" + getHashVal("user", "82") + "</b></td><td class=""msgSm"">")
                            If dataRdr.IsDBNull(13) = False Then
                                If CStr(dataRdr.Item(13)).Trim <> String.Empty Then
                                    vpTable.Append(FormatDateTime(dataRdr.Item(13), DateFormat.LongDate).ToString + "</td></tr>")
                                Else
                                    vpTable.Append(getHashVal("user", "81") + "</td></tr>")
                                End If
                            Else
                                vpTable.Append(getHashVal("user", "81") + "</td></tr>")
                            End If

                            '-- total posts
                            vpTable.Append("<tr><td class=""msgSm"" align=""right"" height=""20""><b>" + getHashVal("user", "26") + " : </b></td><td class=""msgSm"">")
                            If dataRdr.IsDBNull(6) = False Then
                                vpTable.Append(CStr(dataRdr.Item(6)) + "</td></tr>")
                            Else
                                vpTable.Append("0</td></tr>")
                            End If

                            '-- location
                            vpTable.Append("<tr><td class=""msgSm"" align=""right"" height=""20""><b>" + getHashVal("user", "83") + "</b></td><td class=""msgSm"">")
                            If dataRdr.IsDBNull(10) = False Then
                                If CStr(dataRdr.Item(10)).Trim <> String.Empty Then
                                    vpTable.Append(dataRdr.Item(10) + "</td></tr>")
                                Else
                                    vpTable.Append(getHashVal("user", "81") + "</td></tr>")
                                End If
                            Else
                                vpTable.Append(getHashVal("user", "81") + "</td></tr>")
                            End If
                            '-- occupation
                            vpTable.Append("<tr><td class=""msgSm"" align=""right"" height=""20""><b>" + getHashVal("user", "84") + "</b></td><td class=""msgSm"">")
                            If dataRdr.IsDBNull(11) = False Then
                                If CStr(dataRdr.Item(11)).Trim <> String.Empty Then
                                    vpTable.Append(dataRdr.Item(11) + "</td></tr>")
                                Else
                                    vpTable.Append(getHashVal("user", "81") + "</td></tr>")
                                End If
                            Else
                                vpTable.Append(getHashVal("user", "81") + "</td></tr>")
                            End If
                            '--  Interests
                            vpTable.Append("<tr><td class=""msgSm"" align=""right"" height=""20"" valign=""top""><b>" + getHashVal("user", "85") + "</b></td><td class=""msgSm"">")
                            If dataRdr.IsDBNull(12) = False Then
                                If CStr(dataRdr.Item(12)).Trim <> String.Empty Then
                                    vpTable.Append(dataRdr.Item(12) + "</td></tr>")
                                Else
                                    vpTable.Append(getHashVal("user", "81") + "</td></tr>")
                                End If
                            Else
                                vpTable.Append(getHashVal("user", "81") + "</td></tr>")
                            End If
                            vpTable.Append("</table></td><td class=""msgSm"" valign=""top"" width=""60%"">")
                            vpTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"">")
                            vpTable.Append("<tr><td class=""msgTopicHead"" height=""20""><b>" + getHashVal("user", "86") + "</b></td><td class=""msgTopicHead"" height=""20"">&nbsp;</td></tr>")

                            vpTable.Append("<tr><td class=""msgSm"" align=""right"" width=""155"" height=""20""><b>" + getHashVal("user", "50") + "</b></td><td class=""msgSm"">")
                            If dataRdr.IsDBNull(2) = False Then
                                If dataRdr.Item(2) = 1 Then
                                    If dataRdr.IsDBNull(1) = False Then
                                        If InStr(dataRdr.Item(1), "@", CompareMethod.Binary) > 0 Then
                                            vpTable.Append("<a href=""mailto:" + dataRdr.Item(1) + Chr(34) + ">" + dataRdr.Item(1) + "</a></td></tr>")
                                        Else
                                            vpTable.Append(getHashVal("user", "81") + "</td></tr>")
                                        End If
                                    Else
                                        vpTable.Append(getHashVal("user", "81") + "</td></tr>")
                                    End If
                                Else
                                    vpTable.Append(getHashVal("user", "81") + "</td></tr>")
                                End If
                            Else
                                vpTable.Append(getHashVal("user", "81") + "</td></tr>")
                            End If
                            If dataRdr.IsDBNull(3) = False Then
                                If dataRdr.Item(3) <> String.Empty Then
                                    vpTable.Append("<tr><td class=""msgSm"" align=""right"" height=""20""><b>" + getHashVal("user", "87") + "</b></td><td class=""msgSm"">")
                                    If Left(dataRdr.Item(3), 4).ToLower = "http" Then
                                        vpTable.Append("<a href=" + Chr(34) + dataRdr.Item(3) + Chr(34) + " target=""_blank"" title=" + Chr(34) + getHashVal("main", "118") + Chr(34) + ">")
                                    Else
                                        vpTable.Append("<a href=""http://" + dataRdr.Item(3) + Chr(34) + " target=""_blank"" title=" + Chr(34) + getHashVal("main", "118") + Chr(34) + ">")
                                    End If
                                    vpTable.Append(dataRdr.Item(3) + "</a></td></tr>")
                                End If
                            End If
                            If dataRdr.IsDBNull(4) = False Then
                                If dataRdr.Item(4) <> String.Empty Then
                                    vpTable.Append("<tr><td class=""msgSm"" align=""right"" height=""20""><b>" + getHashVal("user", "88") + "</b></td><td class=""msgSm"">")
                                    vpTable.Append("<a href=""aim:addbuddy?screenname=" + dataRdr.Item(4) + Chr(34) + ">" + dataRdr.Item(4) + "</a></td></tr>")
                                End If
                            End If
                            If dataRdr.IsDBNull(5) = False Then
                                If dataRdr.Item(5) <> 0 Then
                                    vpTable.Append("<tr><td class=""msgSm"" align=""right"" height=""20""><b>" + getHashVal("user", "89") + "</b></td><td class=""msgSm""><a href=""http://wwp.icq.com/scripts/search.dll?to=" + CStr(dataRdr.Item(5)) + Chr(34) + " target=""_blank"">" + CStr(dataRdr.Item(5)) + "</a></td></tr>")
                                End If
                            End If
                            '-- Y!
                            Dim linkIconStr As String = String.Empty
                            If dataRdr.IsDBNull(9) = False Then
                                If CStr(dataRdr.Item(9)).Trim <> String.Empty Then
                                    Dim buddyStr As String = "http://edit.yahoo.com/config/set_buddygrp?.src=&.cmd=a&.bg=Friends&.bdl="
                                    buddyStr += dataRdr.Item(9)
                                    buddyStr += "&.done=" + Server.UrlEncode(siteURL)
                                    linkIconStr += "<a href=" + Chr(34) + buddyStr + Chr(34) + " target=""_blank"">"
                                    linkIconStr += dataRdr.Item(9) + "</a>"
                                    vpTable.Append("<tr><td class=""msgSm"" align=""right"" height=""20""><b>" + getHashVal("user", "90") + "</b></td><td class=""msgSm"">" + linkIconStr + "</td></tr>")
                                End If
                            End If
                            '-- msn
                            If dataRdr.IsDBNull(8) = False Then
                                If CStr(dataRdr.Item(8)).Trim <> String.Empty Then
                                    vpTable.Append("<tr><td class=""msgSm"" align=""right"" height=""20""><b>" + getHashVal("user", "90") + "</b></td><td class=""msgSm"">" + dataRdr.Item(8) + "</td></tr>")
                                End If
                            End If
                            '-- private message
                            If dataRdr.IsDBNull(15) = False And dataRdr.IsDBNull(14) = False Then
                                If dataRdr.Item(14) = True And dataRdr.Item(15) = True Then        '-- PM enabled
                                    vpTable.Append("<tr><td class=""msgSm"" align=""right"" height=""20""><b>" + getHashVal("user", "92") + "</b></td><td class=""msgSm""><a href=" + Chr(34) + siteRoot + "/?r=pm&eod=n&uName=" + dataRdr.Item(0) + Chr(34) + ">" + getHashVal("main", "26") + "</a>" + getHashVal("user", "93") + "</td></tr>")
                                End If
                            End If

                            vpTable.Append("</table></td></tr>")

                        End While
                        dataRdr.Close()
                    End If
                    dataConn.Close()

                Else
                    vpTable.Append("<tr><td class=""msgSm"" align=""center""><br />" + getHashVal("user", "94") + "</td></tr>")
                End If
            Catch ex As Exception
                logErrorMsg("viewProfile<br />" + ex.StackTrace.ToString, 1)
            End Try
            vpTable.Append("<tr><td class=""msgSm"" colspan=""2"">&nbsp;</td></tr>")
            vpTable.Append("</table>")

            '-- Recent posts
            vpTable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" height=""200"">")
            vpTable.Append("<tr><td class=""msgTopicHead"" align=""center"" height=""20"" colspan=""4""><b>" + getHashVal("user", "95") + "</b></td></tr>")

            Dim sSQL As New StringBuilder("SELECT ")
            sSQL.Append("TOP 5 ")
            sSQL.Append("m.MessageID, m.ParentMsgID, ")
            sSQL.Append("(SELECT TOP 1 messageTitle FROM SMB_Messages WHERE (MessageID = m.ParentMsgID OR MessageID = m.MessageID) AND messageTitle IS NOT NULL), ")
            sSQL.Append(" m.editableText, m.PostDate, p.UserName, p.UserID, m.ForumID, f.ForumName, m.PostIcon  FROM SMB_Messages m INNER JOIN SMB_Forums f ON f.FOrumID = m.ForumID INNER JOIN SMB_Profiles p ON p.UserGUID = m.UserGUID WHERE UserID = " + _userID.ToString)
            sSQL.Append(" AND m.ForumID IN (SELECT ForumID FROM SMB_Forums WHERE IsPrivate = 0 OR ")
            sSQL.Append("m.ForumID IN (SELECT DISTINCT ForumID FROM SMB_PrivateAccess pa INNER JOIN SMB_Profiles p ON p.UserID = pa.UserID WHERE p.UserGUID = '" + uGUID + "'))")
            sSQL.Append(" ORDER BY m.PostDate DESC")

            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand(sSQL.ToString, dataConn)
            dataCmd.CommandType = CommandType.Text
            dataParam = dataCmd.Parameters.Add("@UserID", SqlDbType.Int)
            dataParam.Value = _userID
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            Dim sRes As New StringBuilder("")
            Dim rCount = 0
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    rCount += 1
                    If dataRdr.IsDBNull(1) = True And dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(2) = False And dataRdr.IsDBNull(3) = False Then
                        sRes.Append("<tr><td class=""msgSmRow"" valign=""top""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" height=""1"" width=""25"" /><br />")
                        If dataRdr.IsDBNull(9) = False Then
                            If dataRdr.Item(9) <> "" And dataRdr.Item(9) <> "none" Then
                                sRes.Append("<img src=" + Chr(34) + siteRoot + "/posticons/" + dataRdr.Item(9) + ".gif"" border=""0"">")
                            Else
                                sRes.Append("&nbsp;")
                            End If
                        Else
                            sRes.Append("&nbsp;")
                        End If
                        sRes.Append("</td>")
                        sRes.Append("<td class=""msgSmRow"" width=""100%"">")
                        sRes.Append("<a href=" + Chr(34) + siteRoot + "/?f=" + CStr(dataRdr.Item(7)) + "&m=" + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                        If dataRdr.IsDBNull(2) = False Then
                            If dataRdr.Item(2) <> "" Then
                                sRes.Append(dataRdr.Item(2) + "</a>")
                            Else
                                sRes.Append(getHashVal("user", "96") + "</a>")
                            End If
                        Else
                            sRes.Append(getHashVal("user", "96") + "</a>")
                        End If
                        sRes.Append("<div class=""msgQuoteWrap""><div class=""msgQuote"">")
                        If Len(dataRdr.Item(3)) > 200 Then
                            sRes.Append(Left(dataRdr.Item(3), 200) + " ...</div></div>")
                        Else
                            sRes.Append(dataRdr.Item(3) + "</div></div>")
                        End If

                        sRes.Append("</td>")
                        sRes.Append("<td class=""msgSmRow"" align=""center"" width=""200""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" height=""1"" width=""200"" /><br />")
                        sRes.Append("<a href=" + Chr(34) + siteRoot + "/?f=" + CStr(dataRdr.Item(7)) + Chr(34) + ">" + dataRdr.Item(8) + "</a>")
                        sRes.Append("</td>")
                        sRes.Append("<td class=""msgSmRow"" align=""center"" width=""150""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" height=""1"" width=""150"" /><br />")
                        sRes.Append("<a href=" + Chr(34) + siteRoot + "/vp.aspx?f=" + _forumID.ToString + "&p=" + CStr(dataRdr.Item(6)) + Chr(34) + ">" + dataRdr.Item(5) + "</a><br />")
                        sRes.Append(FormatDateTime(dataRdr.Item(4), DateFormat.GeneralDate) + "</td></tr>")


                    Else ' dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(2) = False And dataRdr.IsDBNull(3) = False Then
                        sRes.Append("<tr><td class=""msgSmRow"">")
                        If dataRdr.IsDBNull(9) = False Then
                            If dataRdr.Item(9) <> "" And dataRdr.Item(9) <> "none" Then
                                sRes.Append("<img src=" + Chr(34) + siteRoot + "/posticons/" + dataRdr.Item(9) + ".gif"" border=""0"">")
                            Else
                                sRes.Append("&nbsp;")
                            End If
                        Else
                            sRes.Append("&nbsp;")
                        End If
                        sRes.Append("</td>")
                        sRes.Append("<td class=""msgSmRow"">")
                        sRes.Append("<a href=" + Chr(34) + siteRoot + "/?f=" + CStr(dataRdr.Item(7)) + "&m=" + CStr(dataRdr.Item(1)) + "#m" + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                        If dataRdr.IsDBNull(2) = False Then
                            If dataRdr.Item(2) <> "" Then
                                sRes.Append(dataRdr.Item(2) + "</a>")
                            Else
                                sRes.Append("(no subject)</a>")
                            End If
                        Else
                            sRes.Append("(no subject)</a>")
                        End If
                        sRes.Append("<div class=""msgQuoteWrap""><div class=""msgQuote"">")
                        If Len(dataRdr.Item(3)) > 200 Then
                            sRes.Append(Left(dataRdr.Item(3), 200) + " ...</div></div>")
                        Else
                            sRes.Append(dataRdr.Item(3) + "</div></div>")
                        End If
                        sRes.Append("</td>")
                        sRes.Append("<td class=""msgSmRow"" height=""20"" align=""center"" width=""200"">")
                        sRes.Append("<a href=" + Chr(34) + siteRoot + "/?f=" + CStr(dataRdr.Item(7)) + Chr(34) + ">" + dataRdr.Item(8) + "</a>")
                        sRes.Append("</td>")
                        sRes.Append("<td class=""msgSmRow"" align=""center"" width=""150"">")
                        sRes.Append("<a href=" + Chr(34) + siteRoot + "/vp.aspx?f=" + _forumID.ToString + "&p=" + CStr(dataRdr.Item(6)) + Chr(34) + ">" + dataRdr.Item(5) + "</a><br />")
                        sRes.Append(FormatDateTime(dataRdr.Item(4), DateFormat.GeneralDate) + "</td></tr>")
                    End If

                End While
                dataRdr.Close()
                dataConn.Close()
            End If
            If rCount > 0 Then
                vpTable.Append("<tr><td class=""msgSearchHead"" height=""20"" align=""center"" colspan=""2"">" + getHashVal("user", "97") + "</td>")
                vpTable.Append("<td class=""msgSearchHead"" align=""center"" width=""200"">" + getHashVal("user", "98") + "</td>")
                vpTable.Append("<td class=""msgSearchHead"" align=""center"" width=""150"">" + getHashVal("user", "99") + "</td></tr>")
                vpTable.Append(sRes.ToString)
                vpTable.Append("<tr><td class=""msgSmRow"" colspan=""4"" height=""20"">&nbsp;</td></tr>")
            End If

            vpTable.Append("<tr><td class=""msgSm"">&nbsp;</td></tr>")
            vpTable.Append("</table>")
            vpTable.Append(printCopyright())

            Return vpTable.ToString
        End Function

        '-- Generic Error Logging Sub
        Public Sub logErrorMsg(ByVal eMsg As String, ByVal eType As Integer)
            HttpContext.Current.Response.Write("<!-- An Error has occurred :")
            HttpContext.Current.Response.Write(eMsg)
            HttpContext.Current.Response.Write(" -->")
        End Sub



        '******************************************************
        '****   PRIVATE FUNCTIONS/SUBS
        '******************************************************
        '-- sets ignore filter for user
        Private Function addIgnoreFilter(ByVal uGUID As String) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            Dim aif As New StringBuilder("")
            Dim pMsg As Integer = 0
            Dim spMsg As Integer = 0
            If _messageID > 0 And _forumID > 0 Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_GetParentID", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                dataParam.Value = _messageID
                dataParam = dataCmd.Parameters.Add("@ParentID", SqlDbType.Int)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                pMsg = dataCmd.Parameters("@ParentID").Value
                dataConn.Close()
                If pMsg <> _messageID Then
                    spMsg = _messageID
                Else
                    spMsg = pMsg
                End If
            End If
            aif.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" height=""300"">")

            If _userID > 0 And uGUID <> GUEST_GUID Then     '-- add to ignore
                Dim iaResult As Integer = 0
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_AddUserToIgnore", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataParam = dataCmd.Parameters.Add("@UserID", SqlDbType.Int)
                dataParam.Value = _userID
                dataParam = dataCmd.Parameters.Add("@IA", SqlDbType.Int)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                iaResult = dataCmd.Parameters("@IA").Value
                dataConn.Close()

                aif.Append("<tr><td class=""msgSm"" align=""center"" valign=""top""><br />")

                Select Case iaResult
                    Case 0
                        aif.Append(getHashVal("main", "119") + "</td></tr>")
                    Case 1
                        aif.Append(getHashVal("main", "119") + "<br />" + getHashVal("main", "120") + "</td></tr>")
                    Case 2
                        aif.Append(getHashVal("main", "119") + "<br />" + getHashVal("main", "121") + "</td></tr>")
                    Case 3
                        aif.Append(getHashVal("main", "119") + "<br />" + getHashVal("main", "122") + "</td></tr>")
                    Case 4
                        aif.Append(getHashVal("main", "123") + "</td></tr>")
                End Select



            Else
                aif.Append("<tr><td class=""msgSm"" align=""center"" valign=""top""><br />" + getHashVal("main", "124") + "</td></tr>")

            End If
            aif.Append("</table>")
            If spMsg <> 0 And pMsg <> 0 Then
                aif.Append("<script language=javascript>" + vbCrLf)
                aif.Append("<!--" + vbCrLf)
                aif.Append("function bouncePage() {" + vbCrLf)
                aif.Append("window.location.href='" + siteRoot + "/?f=" + _forumID.ToString + "&m=" + pMsg.ToString + "#m" + spMsg.ToString + "';" + vbCrLf)
                aif.Append("}" + vbCrLf)
                aif.Append("setTimeout('bouncePage()', 2000);" + vbCrLf)
                aif.Append("-->" + vbCrLf)
                aif.Append("</script>" + vbCrLf)
            End If
            aif.Append(printCopyright())
            Return aif.ToString
        End Function

        '-- sends user notified alerts to admin of posts
        Private Function adminAlertForm(ByVal uGUID) As String
            Dim af As New StringBuilder("")
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If _messageID > 0 And _forumID > 0 And _processForm = False Then
                af.Append("<form action=" + Chr(34) + siteRoot + "/default.aspx"" method=""post"">")
                af.Append("<input type=""hidden"" name=""r"" value=""aa"" />")
                af.Append("<input type=""hidden"" name=""verify"" value=""1"" />")
                af.Append("<input type=""hidden"" name=""m"" value=" + Chr(34) + _messageID.ToString + Chr(34) + " />")
                af.Append("<input type=""hidden"" name=""f"" value=" + Chr(34) + _forumID.ToString + Chr(34) + " />")
                af.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""75%"" align=""center"">")
                af.Append("<tr><td class=""msgSm"">" + getHashVal("main", "125") + "<br />")
                af.Append("<textarea class=""msgFormSmTextBox"" name=""msgBody""></textarea><br /><br />")
                af.Append("<input type=""submit"" class=""msgSmButton"" value=""Submit"">")

                af.Append("</td></tr></table></form>")
            ElseIf _messageID > 0 And _forumID > 0 And _processForm = True Then

                Dim SMTPMailer As New MailMessage()
                Dim mailHead As String = "<html><head><title>" + getHashVal("main", "126") + "</title></head><body><table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%""><tr><td><font face=""Tahoma, Verdana, Helvetica, Sans-Serif"" size=""2"">"
                Dim mailFoot As String = "</font></td></tr></table></body></html>"
                Dim mailMsg As String = String.Empty
                Dim mailCopy As String = "<br>&nbsp;<hr size=""1"" color=""#000000"" noshade>"
                mailCopy += "<font size=""1""><a href=""http://www.dotnetbb.com"" target=""_blank"">dotNetBB</a> &copy;2002, <a href=""mailto:Andrew@dotNetBB.com"">Andrew Putnam</a></font>"
                Dim mailTo As String = siteAdmin
                Dim mailToAddr As String = siteAdminMail
                Dim mailFrom As String = String.Empty
                Dim postUser As String = String.Empty
                Dim pMsg As Integer = 0
                Dim spMsg As Integer = 0

                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_GetParentID", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                dataParam.Value = _messageID
                dataParam = dataCmd.Parameters.Add("@ParentID", SqlDbType.Int)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                pMsg = dataCmd.Parameters("@ParentID").Value
                dataConn.Close()
                If pMsg <> _messageID Then
                    spMsg = _messageID
                Else
                    spMsg = pMsg
                End If

                If uGUID <> GUEST_GUID Then
                    postUser = userNameFromGUID(uGUID)
                Else
                    postUser = getHashVal("main", "127")
                End If

                mailMsg = getHashVal("main", "128") + mailTo + "<br />"
                mailMsg += postUser + getHashVal("main", "129") + "<br />"

                mailMsg += "<a href=" + Chr(34) + siteURL + siteRoot + "/?f=" + _forumID.ToString + "&m=" + pMsg.ToString + "#m" + spMsg.ToString + Chr(34) + " target=""_blank"">"
                mailMsg += siteURL + siteRoot + "/?f=" + _forumID.ToString + "&m=" + pMsg.ToString + "#m" + spMsg.ToString + "</a>"
                If _formBody <> "" Then
                    _formBody = Server.HtmlEncode(_formBody)
                    _formBody = _formBody.Replace(vbCrLf, "<br />")

                    mailMsg += "<hr size=""1"" noshade />" + getHashVal("main", "130") + _formBody
                End If
                SMTPMailer.Subject = boardTitle.ToString + getHashVal("main", "131")
                SMTPMailer.To = mailToAddr
                SMTPMailer.From = siteAdmin + "<" + siteAdminMail + ">"
                SMTPMailer.BodyFormat = MailFormat.Html
                SMTPMailer.Body = mailHead + mailMsg + mailCopy + mailFoot
                If smtpServerName <> "" Then
                    SmtpMail.SmtpServer = smtpServerName
                End If
                SmtpMail.Send(SMTPMailer)
                Server.ClearError()



                af.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""75%"" align=""center"" height=""300"">")
                af.Append("<tr><td class=""msgSm"" valign=""top"" align=""center""><br />" + getHashVal("main", "132"))
                af.Append("<script language=javascript>" + vbCrLf)
                af.Append("<!--" + vbCrLf)
                af.Append("function bouncePage() {" + vbCrLf)
                af.Append("window.location.href='" + siteRoot + "/?f=" + _forumID.ToString + "&m=" + pMsg.ToString + "#m" + spMsg.ToString + "';" + vbCrLf)
                af.Append("}" + vbCrLf)
                af.Append("setTimeout('bouncePage()', 2000);" + vbCrLf)
                af.Append("-->" + vbCrLf)
                af.Append("</script>" + vbCrLf)
                af.Append("</td></tr></table>")

            Else
                af.Append("<div class=""msgFormError"">" + getHashVal("main", "133") + "</div>")
            End If
            af.Append(printCopyright())
            Return af.ToString
        End Function

        '-- bans IP Address from quick link in threaded view
        Private Function banIPFromThread(ByVal uGUID) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            Dim banResult As Integer = 0
            Dim bf As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacint=""0"" width=""100%"" height=""300"">")
            If getAdminMenuAccess(20, uGUID) = False Then    '-- kick if no access
                bf.Append("<tr><td class=""msgSm"" valign=""top"">" + getHashVal("main", "134") + "</td></tr></table>")
                bf.Append(printCopyright())
                Return bf.ToString
                Exit Function
            End If
            bf.Append("<tr><td class=""msgFormError"" valign=""top"" align=""center""><br />")
            If _messageID > 0 Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_BanIPFromThread", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                dataParam.Value = _messageID
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataParam = dataCmd.Parameters.Add("@BanResult", SqlDbType.Int)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                banResult = dataCmd.Parameters("@BanResult").Value
                dataConn.Close()

                Select Case banResult
                    Case 0
                        bf.Append(getHashVal("main", "135"))
                    Case 1
                        bf.Append(getHashVal("main", "136"))
                    Case 2
                        bf.Append(getHashVal("main", "137"))
                        logAdminAction(uGUID, "IP Added to ban listing from message id " + _messageID.ToString + ".")
                End Select
            Else
                bf.Append(getHashVal("main", "135"))
            End If
            bf.Append("</td></tr></table>")
            bf.Append(printCopyright())

            Return bf.ToString
        End Function

        '-- bans user and locks their account from quick link in threaded view
        Private Function banUserFromThread(ByVal uGUID As String) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            Dim banResult As Integer = 0
            Dim bf As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacint=""0"" width=""100%"" height=""300"">")
            If getAdminMenuAccess(7, uGUID) = False Then    '-- kick if no access
                bf.Append("<tr><td class=""msgSm"" valign=""top"">" + getHashVal("main", "134") + "</td></tr></table>")
                bf.Append(printCopyright())
                Return bf.ToString
                Exit Function
            End If
            bf.Append("<tr><td class=""msgFormError"" valign=""top"" align=""center""><br />")
            If _messageID > 0 Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_BanUserFromThread", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                dataParam.Value = _messageID
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataParam = dataCmd.Parameters.Add("@BanResult", SqlDbType.Int)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                banResult = dataCmd.Parameters("@BanResult").Value
                dataConn.Close()

                Select Case banResult
                    Case 0
                        bf.Append(getHashVal("main", "135"))
                    Case 1
                        bf.Append(getHashVal("main", "136"))
                    Case 2
                        bf.Append(getHashVal("main", "137"))
                        logAdminAction(uGUID, "User added to ban listing from message id " + _messageID.ToString + ".")
                End Select
            Else
                bf.Append(getHashVal("main", "135"))
            End If
            bf.Append("</td></tr></table>")
            bf.Append(printCopyright())

            Return bf.ToString
        End Function

        '-- checks if site admin 
        Private Function checkAdminAccess(ByVal uGUID As String) As Boolean
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
            If dataCmd.Parameters("@IsGlobalAdmin").Value = True Then
                allowAdmin = True
            End If
            dataConn.Close()
            Return allowAdmin
        End Function

        '-- checks user guid for valid userID's on private forums
        Private Function checkForumAccess(ByVal uGUID As String, ByVal forumID As Integer) As Boolean
            Dim hasAccess As Boolean = False
            Dim cGUID As Guid
            Dim GUIDLock As Boolean = False
            Dim uIP As String = HttpContext.Current.Request.ServerVariables("REMOTE_ADDR")
            Dim tIP As String = String.Empty
            Dim tMark As Integer = 0
            Dim foundLock As Boolean = False
            Try
                If uGUID.ToString.ToLower = "guest" Then
                    uGUID = GUEST_GUID    '-- guest GUID
                Else
                    uGUID = checkValidGUID(uGUID)
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_CheckGUIDLock", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                    dataParam = dataCmd.Parameters.Add("@GUIDLock", SqlDbType.Bit)
                    dataParam.Direction = ParameterDirection.Output
                    dataConn.Open()
                    dataCmd.ExecuteNonQuery()
                    GUIDLock = dataCmd.Parameters("@GUIDLock").Value
                    dataConn.Close()
                    If GUIDLock = True Then
                        uGUID = GUEST_GUID
                        setUserCookie("uld", uGUID)
                    End If

                End If

                '-- check IP lock
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_CheckIPLock", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(0) = False Then
                            tIP = dataRdr.Item(0)
                            If InStr(tIP, "*", CompareMethod.Binary) > 0 Then
                                tMark = InStr(tIP, "*", CompareMethod.Binary) - 1
                                If tMark > 0 Then
                                    tIP = Left(tIP, tMark)
                                    If Left(uIP, tMark) = tIP Then
                                        foundLock = True
                                    Else
                                        HttpContext.Current.Response.Write(Left(uIP, tMark) + " :: " + tIP + vbCrLf)
                                    End If
                                End If
                            ElseIf uIP = tIP Then
                                foundLock = True
                            Else
                                HttpContext.Current.Response.Write(uIP + " :: " + tIP + vbCrLf)
                            End If
                        End If
                    End While
                    dataRdr.Close()
                    dataConn.Close()
                End If
                If foundLock = True Then
                    HttpContext.Current.Response.Redirect(siteRoot + "/ip.aspx")
                End If

                cGUID = XmlConvert.ToGuid(uGUID)
                '-- convert the string to GUID
                If forumID > 0 Then     '-- for forum level only
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_ForumAccessList", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                    dataParam.Value = forumID
                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                    dataParam.Value = cGUID
                    dataParam = dataCmd.Parameters.Add("@HasAccess", SqlDbType.Bit)
                    dataParam.Direction = ParameterDirection.Output
                    dataConn.Open()
                    dataCmd.ExecuteNonQuery()
                    hasAccess = dataCmd.Parameters("@HasAccess").Value
                    dataConn.Close()
                End If


            Catch ex As Exception
                logErrorMsg("checkForumAccess<br />" + ex.StackTrace.ToString, 1)
                Return False
            End Try
            Return hasAccess
        End Function

        '-- new in v2.1
        '-- check to see if the forum is temporarily disabled
        Private Function checkForumActive() As Boolean
            Dim fState As Boolean = True        '-- return true if not specificly disabled
            If _forumID > 0 Then
                Try
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_GetForumState", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                    dataParam.Value = _forumID
                    dataParam = dataCmd.Parameters.Add("@ActiveState", SqlDbType.Bit)
                    dataParam.Direction = ParameterDirection.Output
                    dataConn.Open()
                    dataCmd.ExecuteNonQuery()
                    fState = dataCmd.Parameters("@ActiveState").Value
                    dataConn.Close()
                Catch
                    Return True
                End Try

            End If
            Return fState
        End Function

        '-- checks if member is already subscribed to the forum
        Private Function checkForumSubscribe(ByVal uGUID As String) As Boolean
            Dim tsid As Integer = 0
            Dim isSub As Boolean = False
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_CheckIfSubscribed", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
            dataParam.Value = XmlConvert.ToGuid(uGUID)
            dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
            dataParam.Value = _forumID
            dataParam = dataCmd.Parameters.Add("@IsSub", SqlDbType.Int)
            dataParam.Direction = ParameterDirection.Output
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    tsid = dataRdr.Item(0)
                End While
                dataRdr.Close()
            End If
            dataConn.Close()
            If tsid > 0 Then
                isSub = True
            Else
                isSub = False
            End If
            Return isSub
        End Function

        '-- since there is no built in function to validate if a guid is valid...
        Private Function checkValidGUID(ByVal GUIDToTest As String) As String
            Dim isValid As Boolean = False
            Try
                If GUIDToTest <> String.Empty Then
                    If GUIDToTest.ToString.Length = 38 Then
                        If Microsoft.VisualBasic.Left(GUIDToTest, 1) = "{" Then
                            If Microsoft.VisualBasic.Right(GUIDToTest, 1) = "}" Then
                                If Mid(GUIDToTest, 10, 1) = "-" Then
                                    If Mid(GUIDToTest, 15, 1) = "-" Then
                                        If Mid(GUIDToTest, 20, 1) = "-" Then
                                            If Mid(GUIDToTest, 25, 1) = "-" Then
                                                Return GUIDToTest
                                            Else
                                                Return GUEST_GUID     '-- Guest account
                                            End If
                                        Else
                                            Return GUEST_GUID
                                        End If
                                    Else
                                        Return GUEST_GUID
                                    End If
                                Else
                                    Return GUEST_GUID
                                End If
                            Else
                                Return GUEST_GUID
                            End If
                        Else
                            Return GUEST_GUID
                        End If
                    Else
                        Return GUEST_GUID
                    End If
                Else
                    Return GUEST_GUID
                End If
            Catch ex As Exception
                logErrorMsg("checkValidGUID<br />" + ex.StackTrace.ToString, 1)
                Return GUEST_GUID
            End Try




        End Function

        '-- returns the user's ignored user listing
        Private Function cpIgnoreFilterList(ByVal uGUID As String) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If userStrLoaded = False Then
                userStrLoaded = xmlLoadStringMsg("user")
            End If
            Dim pftable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" align=""center"" height=""300"">")
            Dim showForm As Boolean = True
            Dim mCount As Integer = 0
            If uGUID = GUEST_GUID Then
                showForm = False
                pftable.Append("<tr><td class=""msgSm"" valign=""top"" align=""center"" height=""20""><br />" + getHashVal("user", "34") + "</td></tr>")
                pftable.Append("<tr><td class=""msgSm"" valign=""top"" align=""center""><br />")
                pftable.Append(forumLoginForm())
                pftable.Append("</td></tr>")
            Else     '-- valid GUID format, get profile info
                If _tSub > 0 Then
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_CPRemoveIgnoreUser", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                    dataParam = dataCmd.Parameters.Add("@IID", SqlDbType.Int)
                    dataParam.Value = _tSub
                    dataConn.Open()
                    dataCmd.ExecuteNonQuery()
                    dataConn.Close()

                End If
                pftable.Append("<tr><td class=""msgSm"" align=""center"" valign=""top"" height=""20"">" + getHashVal("user", "100") + "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/smdelete.gif"" border=""0"" /> ")
                pftable.Append(getHashVal("user", "101") + "</td></tr>")
                pftable.Append("<tr><td class=""msgSm"" align=""center"" valign=""top""><br /><table border=""0"" cellpadding=""3"" cellspacing=""0"" class=""tblStd"" width=""400"">")
                pftable.Append("<tr><td class=""msgTopicHead"" align=""center"" colspan=""2"">" + getHashVal("user", "102") + "</td></tr>")
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_CPListIgnored", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False Then
                            If dataRdr.Item(0) > 0 Then
                                mCount += 1
                                pftable.Append("<tr><td class=""msgSmRow"" align=""center""><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=5&tsub=" + CStr(dataRdr.Item(0)) + Chr(34) + ">")
                                pftable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/smdelete.gif"" border=""0"" title=" + Chr(34) + getHashVal("user", "104") + Chr(34) + " /></a></td>")
                                pftable.Append("<td class=""msgSmRow"">" + dataRdr.Item(1) + "</td></tr>")
                            End If
                        End If
                    End While
                    dataRdr.Close()
                    dataConn.Close()
                End If
                If mCount = 0 Then
                    pftable.Append("<tr><td class=""msgSm"" align=""center"" colspan=""2""><b>" + getHashVal("user", "104") + "</td></tr>")
                End If


            End If

            pftable.Append("</table>")
            Return pftable.ToString
        End Function

        '-- returns the user's current subscriptions for the cp
        Private Function cpUserSubscribe(ByVal uGUID As String) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If userStrLoaded = False Then
                userStrLoaded = xmlLoadStringMsg("user")
            End If
            Dim mCount As Integer = 0
            '-- template items
            Dim templStr As String = loadTBTemplate("style-listForum.htm", defaultStyle)
            Dim iconStr As String = String.Empty
            Dim topicStr As String = String.Empty
            Dim replyStr As String = String.Empty
            Dim viewStr As String = String.Empty
            Dim lastStr As String = String.Empty
            Dim firstStr As String = String.Empty
            Dim classStr As String = String.Empty
            Dim lastVisit As String = String.Empty
            Dim topicIcon As String = String.Empty
            Dim lftable As New StringBuilder("")
            Dim showRecord As Boolean = False


            If uGUID = GUEST_GUID Then
                lastVisit = DateTime.Now.ToString
            Else
                If HttpContext.Current.Session("lastVisit") = String.Empty Or IsDate(HttpContext.Current.Session("lastVisit")) = False Then
                    lastVisit = DateTime.Now.ToString
                    HttpContext.Current.Session("lastVisit") = lastVisit
                Else
                    lastVisit = HttpContext.Current.Session("lastVisit")
                End If
            End If
            '-- subsribed forums
            lftable.Append("<b>Subscribed Forums : </b><br /><table border=""0"" cellpadding=""3"" cellspacing=""0"" class=""tblStd"">")
            lftable.Append("<tr><td class=""msgTopicHead"" align=""center"">" + getHashVal("user", "105") + "</td>")
            lftable.Append("<td class=""msgTopicHead"" align=""center"" width=""300"">" + getHashVal("main", "71") + "</td></tr>")

            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_CPForumSubscribeList", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
            dataParam.Value = XmlConvert.ToGuid(uGUID)
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    mCount += 1
                    lftable.Append("<tr><td class=""msgTopic"" align=""center"">")
                    lftable.Append("<a href=" + Chr(34) + siteRoot + "/cp.aspx?p=4&f=" + _forumID.ToString + "&m=" + _messageID.ToString + "&fsub=" + CStr(dataRdr.Item(0)) + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/smdelete.gif"" border=""0"" ></a>")
                    lftable.Append("</td>")
                    lftable.Append("<td class=""msgTopic"" align=""center"" width=""300"">" + dataRdr.Item(1) + "</td></tr>")
                End While
                dataRdr.Close()
                dataConn.Close()
            End If
            If mCount = 0 Then
                lftable.Append("<tr><td class=""msgSm"" colspan=""2"" align=""center"" height=""30""><b>" + getHashVal("user", "106") + "</b></td></tr>")
            End If

            lftable.Append("</table>")
            '-- subscribed threads
            lftable.Append("<br /><b>" + getHashVal("user", "107") + "</b><br /><table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" class=""tblStd"">")
            Dim sbHead As New StringBuilder(templStr)
            sbHead.Replace(vbCrLf, "")
            sbHead.Replace("{IsNewIcon}", getHashVal("user", "108"))
            sbHead.Replace("{ICON}", "&nbsp;")
            sbHead.Replace("{TopicTitle}", getHashVal("user", "109"))
            sbHead.Replace("{Replies}", getHashVal("user", "110"))
            sbHead.Replace("{Views}", getHashVal("user", "111"))
            sbHead.Replace("{LastPost}", getHashVal("user", "112"))
            sbHead.Replace("{FirstPost}", getHashVal("user", "113"))
            sbHead.Replace("{ClassTag}", "msgTopicHead")
            lftable.Append(sbHead.ToString)

            lftable.Append(forumStickyItems(_forumID))
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_CPSubscribeList", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
            dataParam.Value = XmlConvert.ToGuid(uGUID)
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            mCount = 0
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    '-- reset values
                    mCount += 1
                    topicStr = String.Empty
                    replyStr = String.Empty
                    viewStr = String.Empty
                    lastStr = String.Empty
                    firstStr = String.Empty
                    showRecord = False

                    '-- post icon
                    If dataRdr.IsDBNull(12) = True Then
                        iconStr = "&nbsp;"
                    Else
                        If LCase(dataRdr.Item(12)) <> "none" And dataRdr.Item(12) <> String.Empty Then
                            iconStr = "<img src=" + Chr(34) + siteRoot + "/posticons/" + dataRdr.Item(12) + ".gif"" border=""0"">"
                        Else
                            iconStr = "&nbsp;"
                        End If
                    End If
                    '-- topic lock
                    If dataRdr.Item(11) = True Then
                        topicStr = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/lock.gif"" border=""0"">&nbsp"
                    End If
                    '-- topic title
                    topicStr += "<a href=" + Chr(34) + siteRoot + "/?f=" + CStr(dataRdr.Item(13)) + "&m=" + CStr(dataRdr.Item(0)) + Chr(34) + ">"
                    topicStr += Server.HtmlEncode(dataRdr.Item(1)) + "</a>"
                    '-- reply count
                    If dataRdr.IsDBNull(3) = False Then
                        replyStr = CStr(dataRdr.Item(3))
                    Else
                        replyStr = "0"
                    End If
                    '-- view count
                    If dataRdr.IsDBNull(4) = False Then
                        viewStr = CStr(dataRdr.Item(4))
                    Else
                        viewStr = "0"
                    End If

                    '-- first post
                    firstStr = "<a href=" + Chr(34) + siteRoot + "/vp.aspx?f=" + _forumID.ToString + "&p=" + CStr(dataRdr.Item(6)) + Chr(34) + " >"
                    firstStr += Server.HtmlEncode(dataRdr.Item(7)) + "</a>"
                    If dataRdr.IsDBNull(2) = False Then
                        If IsDate(dataRdr.Item(2)) = True Then
                            If CDate(lastVisit) <= dataRdr.Item(2) Then
                                topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newtopic.gif"" alt=" + Chr(34) + getHashVal("user", "17") + Chr(34) + " border=""0"">"
                            Else
                                topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" alt=" + Chr(34) + getHashVal("user", "18") + Chr(34) + " border=""0"">"
                            End If
                        End If
                    End If

                    '-- last post
                    If dataRdr.IsDBNull(9) = False And dataRdr.IsDBNull(10) = False And dataRdr.IsDBNull(5) = False Then
                        lastStr = "<a href=" + Chr(34) + siteRoot + "/vp.aspx?f=" + _forumID.ToString + "&p=" + CStr(dataRdr.Item(9)) + Chr(34) + " >"
                        If _eu31 <> 0 And _timeOffset = 0 Then
                            lastStr += Server.HtmlEncode(dataRdr.Item(10)) + "</a><br />" + FormatDateTime(DateAdd(DateInterval.Hour, _eu31, dataRdr.Item(5)), DateFormat.GeneralDate)

                        ElseIf _timeOffset <> 0 Then
                            lastStr += Server.HtmlEncode(dataRdr.Item(10)) + "</a><br />" + FormatDateTime(DateAdd(DateInterval.Hour, _timeOffset, dataRdr.Item(5)), DateFormat.GeneralDate)

                        Else
                            lastStr += Server.HtmlEncode(dataRdr.Item(10)) + "</a><br />" + CStr(dataRdr.Item(5))
                        End If
                    Else
                        lastStr = "&nbsp;"
                    End If
                    topicIcon = "<a href=" + Chr(34) + siteRoot + "/cp.aspx?p=4&f=" + _forumID.ToString + "&m=" + _messageID.ToString + "&tsub=" + CStr(dataRdr.Item(0)) + Chr(34) + "><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/smdelete.gif"" border=""0"" ></a>"

                    '-- build from template
                    Dim sbRow As New StringBuilder(templStr)
                    sbRow.Replace(vbCrLf, "")
                    sbRow.Replace("{IsNewIcon}", topicIcon)
                    If _eu6 = True Then
                        sbRow.Replace("{ICON}", iconStr)
                    Else
                        sbRow.Replace("{ICON}", "&nbsp;")
                    End If

                    sbRow.Replace("{TopicTitle}", topicStr)
                    sbRow.Replace("{Replies}", replyStr)
                    sbRow.Replace("{Views}", viewStr)
                    sbRow.Replace("{LastPost}", lastStr)
                    sbRow.Replace("{FirstPost}", firstStr)
                    sbRow.Replace("{ClassTag}", "msgTopic")
                    lftable.Append(sbRow.ToString)
                End While
            End If
            If mCount = 0 Then
                lftable.Append("<tr><td class=""msgSm"" colspan=""7"" align=""center"" height=""30""><b>" + getHashVal("user", "114") + "</b></td></tr>")
            End If

            lftable.Append("</table>")
            Return lftable.ToString

        End Function

        '-- returns the user's current unread pm list for the cp
        Private Function cpUnreadPM(ByVal uGUID As String) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If userStrLoaded = False Then
                userStrLoaded = xmlLoadStringMsg("user")
            End If
            Dim upm As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" class=""tblStd"">")
            Dim mCount As Integer = 0
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_CPUnreadPMs", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
            dataParam.Value = XmlConvert.ToGuid(uGUID)
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            If dataRdr.IsClosed = False Then
                upm.Append("<tr><td class=""msgTopicHead"" align=""center"" height=""20"" width=""100"">" + getHashVal("user", "115") + "</td>")
                upm.Append("<td class=""msgTopicHead"" width=""150"">" + getHashVal("user", "116") + "</td>")

                upm.Append("<td class=""msgTopicHead"">" + getHashVal("user", "117") + "</td>")
                upm.Append("<td class=""msgTopicHead"" align=""center"" width=""150"">" + getHashVal("user", "118") + "</td></tr>")
                While dataRdr.Read
                    If dataRdr.IsDBNull(0) = False And dataRdr.IsDBNull(1) = False And dataRdr.IsDBNull(2) = False And dataRdr.IsDBNull(3) = False And dataRdr.IsDBNull(4) = False And dataRdr.IsDBNull(5) = False Then
                        mCount += 1
                        If dataRdr.Item(4) = 0 And dataRdr.Item(5) = 0 Then
                            upm.Append("<tr><td class=""msgTopicAnnounce"" align=""center"" height=""20"" width=""100"">")
                            If _edOrDel = "s" Then
                                upm.Append("<a href=" + Chr(34) + siteRoot + "/?r=pm&m=" + CStr(dataRdr.Item(0)) + "&eod=ds" + Chr(34) + " title=""Click to Delete""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/smdelete.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "119") + Chr(34) + "></a></td>")
                            Else
                                upm.Append("<a href=" + Chr(34) + siteRoot + "/?r=pm&m=" + CStr(dataRdr.Item(0)) + "&eod=ri" + Chr(34) + " title=""Click to Reply""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/reply.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "120") + Chr(34) + "></a> &nbsp; ")
                                upm.Append("<a href=" + Chr(34) + siteRoot + "/?r=pm&m=" + CStr(dataRdr.Item(0)) + "&eod=di" + Chr(34) + " title=""Click to Delete""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/smdelete.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "119") + Chr(34) + "></a></td>")
                            End If

                            upm.Append("<td class=""msgTopicAnnounce"" width=""150"">" + dataRdr.Item(3) + "</td>")
                            upm.Append("<td class=""msgTopicAnnounce""><a href=" + Chr(34) + siteRoot + "/?r=pm&m=" + CStr(dataRdr.Item(0)) + "&eod=v" + Chr(34) + " title=" + Chr(34) + getHashVal("user", "121") + Chr(34) + ">")
                            If CStr(dataRdr.Item(1)).ToString.Trim = String.Empty Then
                                upm.Append("(No Subject)</a></td>")
                            Else
                                upm.Append(dataRdr.Item(1) + "</a></td>")
                            End If

                            upm.Append("<td class=""msgTopicAnnounce"" align=""center"" width=""150"">" + FormatDateTime(dataRdr.Item(2), DateFormat.GeneralDate) + "</td></tr>")
                        Else
                            upm.Append("<tr><td class=""msgTopic"" align=""center"" height=""20"" width=""100"">")
                            If _edOrDel = "s" Then
                                upm.Append("<a href=" + Chr(34) + siteRoot + "/?r=pm&m=" + CStr(dataRdr.Item(0)) + "&eod=ds" + Chr(34) + " title=""Click to Delete""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/smdelete.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "119") + Chr(34) + "></a></td>")
                            Else
                                upm.Append("<a href=" + Chr(34) + siteRoot + "/?r=pm&m=" + CStr(dataRdr.Item(0)) + "&eod=ri" + Chr(34) + " title=""Click to Reply""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/reply.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "120") + Chr(34) + "></a> &nbsp; ")
                                upm.Append("<a href=" + Chr(34) + siteRoot + "/?r=pm&m=" + CStr(dataRdr.Item(0)) + "&eod=di" + Chr(34) + " title=""Click to Delete""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/smdelete.gif"" border=""0"" alt=" + Chr(34) + getHashVal("user", "119") + Chr(34) + "></a></td>")
                            End If
                            upm.Append("<td class=""msgTopic"" width=""150"">" + dataRdr.Item(3) + "</td>")
                            If _edOrDel = "i" Or _edOrDel = String.Empty Then
                                upm.Append("<td class=""msgTopic""><a href=" + Chr(34) + siteRoot + "/?r=pm&m=" + CStr(dataRdr.Item(0)) + "&eod=v" + Chr(34) + " title=" + Chr(34) + getHashVal("user", "121") + Chr(34) + ">")
                                If CStr(dataRdr.Item(1)).ToString.Trim = String.Empty Then
                                    upm.Append("(No Subject)</a></td>")
                                Else
                                    upm.Append(dataRdr.Item(1) + "</a></td>")
                                End If
                            Else
                                upm.Append("<td class=""msgTopic""><a href=" + Chr(34) + siteRoot + "/?r=pm&m=" + CStr(dataRdr.Item(0)) + "&eod=v2" + Chr(34) + " title=" + Chr(34) + getHashVal("user", "121") + Chr(34) + ">")
                                If CStr(dataRdr.Item(1)).ToString.Trim = String.Empty Then
                                    upm.Append("(No Subject)</a></td>")
                                Else
                                    upm.Append(dataRdr.Item(1) + "</a></td>")
                                End If

                            End If

                            upm.Append("<td class=""msgTopic"" align=""center"" width=""150"">" + FormatDateTime(dataRdr.Item(2), DateFormat.GeneralDate) + "</td></tr>")
                        End If
                    End If
                End While
                dataRdr.Close()
                dataConn.Close()
            End If
            If mCount = 0 Then
                upm.Append("<tr><td class=""msgtopic"" align=""center"" colspan=""4""  height=""30""><b>" + getHashVal("user", "122") + "</b></td></tr>")
            End If
            upm.Append("</table>")
            Return upm.ToString
        End Function

        '-- returns the user options form for use with the cp
        Private Function cpUserOptions(ByVal uGUID As String) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If userStrLoaded = False Then
                userStrLoaded = xmlLoadStringMsg("user")
            End If
            Dim pftable As New StringBuilder("")
            Dim showform As Boolean = True
            Dim htmlSignature As String = ""
            pftable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" align=""center"" class=""tblStd"" height=""300"">")
            If uGUID = GUEST_GUID And _createNew = False Then
                showform = False
                pftable.Append("<tr><td class=""msgSm"" valign=""top"" align=""center"" height=""20""><br />" + getHashVal("user", "34") + "</td></tr>")
                pftable.Append("<tr><td class=""msgSm"" valign=""top"" align=""center""><br />")
                pftable.Append(forumLoginForm())
                pftable.Append("</td></tr>")
            ElseIf uGUID <> GUEST_GUID And _createNew = False And _processForm = False Then     '-- valid GUID format, get profile info

                pftable.Append("<script language=javascript>" + vbCrLf)
                pftable.Append("<!--" + vbCrLf)
                pftable.Append("function swapAvatar(imgName) { " + vbCrLf)
                pftable.Append("nImg = new Image();" + vbCrLf)
                pftable.Append("nImg.src='" + siteRoot + "/avatar/'+imgName;" + vbCrLf)
                pftable.Append("document.images['avaImg'].src = eval('nImg.src');" + vbCrLf)
                pftable.Append("}" + vbCrLf)
                pftable.Append("-->" + vbCrLf)
                pftable.Append("</script>" + vbCrLf)

                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_GetUserProfile2", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader()
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(0) = False Then
                            _realname = dataRdr.Item(0)
                        End If
                        If dataRdr.IsDBNull(1) = False Then
                            _userName = dataRdr.Item(1)
                        End If
                        If dataRdr.IsDBNull(2) = False Then
                            _userPass = dataRdr.Item(2)
                            _userPass = forumRotate(_userPass)
                        End If
                        If dataRdr.IsDBNull(3) = False Then
                            _userEmail = dataRdr.Item(3)
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
                            _msnName = dataRdr.Item(11)
                        End If
                        If dataRdr.IsDBNull(12) = False Then
                            _yPager = dataRdr.Item(12)
                        End If
                        If dataRdr.IsDBNull(13) = False Then
                            _uLocation = dataRdr.Item(13)
                        End If
                        If dataRdr.IsDBNull(14) = False Then
                            _uOccupation = dataRdr.Item(14)
                        End If
                        If dataRdr.IsDBNull(15) = False Then
                            _uInterests = dataRdr.Item(15)
                            _uInterests = _uInterests.Replace("<br>", vbCrLf)
                        End If
                        If dataRdr.IsDBNull(16) = False Then
                            _uAvatar = dataRdr.Item(16)
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
                            _userTitle = dataRdr.Item(21)
                        End If

                    End While
                    dataRdr.Close()
                    dataConn.Close()
                End If
            End If
            If showform = True Then

                pftable.Append("<tr><td class=""msgTopicHead"" colspan=""2"" align=""center"">" + getHashVal("main", "138") + "</td></tr>")
                pftable.Append("<form action=" + Chr(34) + siteRoot + "/cp.aspx"" method=""post"">")
                pftable.Append("<input type=""hidden"" name=""f"" value=" + Chr(34) + _forumID.ToString + Chr(34) + " />")
                pftable.Append("<input type=""hidden"" name=""m"" value=" + Chr(34) + _messageID.ToString + Chr(34) + " />")
                pftable.Append("<input type=""hidden"" name=""verify"" value=""1"" />")
                pftable.Append("<input type=""hidden"" name=""p"" value=""3"" />")

                '-- Time Offset
                pftable.Append("<tr><td class=""msgFormDesc"" height=""20"" valign=""top""><b>" + getHashVal("main", "139") + "</b><div class=""msgFormDescSm"">" + getHashVal("main", "81"))
                If _eu31 <> 0 And _timeOffset = 0 Then
                    If _eu31 > 0 Then
                        pftable.Append(" +" + _eu31.ToString)
                    Else
                        pftable.Append(_eu31.ToString)
                    End If
                End If
                pftable.Append(getHashVal("user", "123") + "<br />" + getHashVal("user", "124") + "</div></td>")
                pftable.Append("<td class=""msgFormBody""><select name=""tof"" class=""msgSm"">")
                pftable.Append("<option value=""-12" + Chr(34))
                If _timeOffset = -12 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT -12:00 hours) Eniwetok, Kwajalein</option>")
                pftable.Append("<option value=""-11" + Chr(34))
                If _timeOffset = -11 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT -11:00 hours) Midway Island, Samoa</option>")
                pftable.Append("<option value=""-10" + Chr(34))
                If _timeOffset = -10 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT -10:00 hours) Hawaii</option>")
                pftable.Append("<option value=""-9" + Chr(34))
                If _timeOffset = -9 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT -9:00 hours) Alaska</option>")
                pftable.Append("<option value=""-8" + Chr(34))
                If _timeOffset = -8 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT -8:00 hours) Pacific Time (US & Canada)</option>")
                pftable.Append("<option value=""-7" + Chr(34))
                If _timeOffset = -7 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT -7:00 hours) Mountain Time (US & Canada)</option>")
                pftable.Append("<option value=""-6" + Chr(34))
                If _timeOffset = -6 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT -6:00 hours) Central Time (US & Canada), Mexico City</option>")
                pftable.Append("<option value=""-5" + Chr(34))
                If _timeOffset = -5 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT -5:00 hours) Eastern Time (US & Canada), Bogota</option>")
                pftable.Append("<option value=""-4" + Chr(34))
                If _timeOffset = -4 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT -4:00 hours) Atlantic Time (Canada), Caracas</option>")
                pftable.Append("<option value=""-3.5" + Chr(34))
                If _timeOffset = -3.5 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT -3:30 hours) Newfoundland</option>")
                pftable.Append("<option value=""-3" + Chr(34))
                If _timeOffset = -3 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT -3:00 hours) Brazil, Buenos Aires, Georgetown</option>")
                pftable.Append("<option value=""-2" + Chr(34))
                If _timeOffset = -2 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT -2:00 hours) Mid-Atlantic</option>")
                pftable.Append("<option value=""-1" + Chr(34))
                If _timeOffset = -1 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT -1:00 hours) Azores, Cape Verde Islands</option>")
                pftable.Append("<option value=""0" + Chr(34))
                If _timeOffset = 0 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT) Western Europe Time, London, Lisbon</option>")
                pftable.Append("<option value=""+1" + Chr(34))
                If _timeOffset = 1 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT +1:00 hours) CET(Central Europe Time), Brussels, Paris</option>")
                pftable.Append("<option value=""+2" + Chr(34))
                If _timeOffset = 1 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT +2:00 hours) EET(Eastern Europe Time), South Africa</option>")
                pftable.Append("<option value=""+3" + Chr(34))
                If _timeOffset = 3 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT +3:00 hours) Baghdad, Riyadh, Moscow, St. Petersburg</option>")
                pftable.Append("<option value=""+3.5" + Chr(34))
                If _timeOffset = 3.5 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT +3:30 hours) Tehran</option>")
                pftable.Append("<option value=""+4" + Chr(34))
                If _timeOffset = 4 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT +4:00 hours) Abu Dhabi, Muscat, Baku, Tbilisi</option>")
                pftable.Append("<option value=""+4.5" + Chr(34))
                If _timeOffset = 4.5 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT +4:30 hours) Kabul</option>")
                pftable.Append("<option value=""+5" + Chr(34))
                If _timeOffset = 5 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT +5:00 hours) Ekaterinburg, Islamabad, Karachi, Tashkent</option>")
                pftable.Append("<option value=""+5.5" + Chr(34))
                If _timeOffset = 5.5 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT +5:30 hours) Bombay, Calcutta, Madras, New Delhi</option>")
                pftable.Append("<option value=""+6" + Chr(34))
                If _timeOffset = 6 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT +6:00 hours) Almaty, Dhaka, Colombo</option>")
                pftable.Append("<option value=""+7" + Chr(34))
                If _timeOffset = 7 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT +7:00 hours) Bangkok, Hanoi, Jakarta</option>")
                pftable.Append("<option value=""+8" + Chr(34))
                If _timeOffset = 8 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT +8:00 hours) Beijing, Perth, Singapore, Hong Kong</option>")
                pftable.Append("<option value=""+9" + Chr(34))
                If _timeOffset = 9 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT +9:00 hours) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>")
                pftable.Append("<option value=""+9.5" + Chr(34))
                If _timeOffset = 9.5 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT +9:30 hours) Adelaide, Darwin</option>")
                pftable.Append("<option value=""+10" + Chr(34))
                If _timeOffset = 10 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT +10:00 hours) EAST(East Australian Standard), Guam</option>")
                pftable.Append("<option value=""+11" + Chr(34))
                If _timeOffset = 11 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT +11:00 hours) Magadan, Solomon Islands, New Caledonia</option>")
                pftable.Append("<option value=""+12" + Chr(34))
                If _timeOffset = 12 Then
                    pftable.Append(" selected")
                End If
                pftable.Append(">(GMT +12:00 hours) Auckland, Wellington, Fiji, Kamchatka</option>")
                pftable.Append("</select></td></tr>")

                '-- forum style
                pftable.Append("<tr><td class=""msgFormDesc"" valign=""top"" height=""20""><b>" + getHashVal("user", "125") + "</b><div class=""msgFormDescSm"">" + getHashVal("user", "126") + "</div></td>")
                pftable.Append("<td class=""msgFormBody""><select name=""fstyle"" class=""msgSm"">")
                Dim styleFolders() As String = Directory.GetFileSystemEntries(Server.MapPath(siteRoot + "/styles"))
                Dim di As New DirectoryInfo(Server.MapPath(siteRoot + "/styles"))
                Dim diArr As DirectoryInfo() = di.GetDirectories
                Dim dri As DirectoryInfo
                For Each dri In diArr
                    '-- updated in v2.1 : do not show styles starting with a ~ for development use
                    If Left(dri.Name.ToString, 1) <> "~" Then
                        If dri.Name.ToString.ToLower = defaultStyle.ToLower Then
                            pftable.Append("<option selected>" + Server.HtmlEncode(dri.Name.ToString) + "</option>")
                        Else
                            pftable.Append("<option>" + Server.HtmlEncode(dri.Name.ToString) + "</option>")
                        End If
                    End If

                Next
                pftable.Append("</select></td></tr>")

                '-- custom user title
                '-- new in v2.1 : only show if enabled by admin
                If _eu37 = True Then
                    pftable.Append("<tr><td class=""msgFormDesc"" valign=""top"" height=""20""><b>" + getHashVal("user", "177") + "</b><div class=""msgFormDescSm"">" + getHashVal("user", "178") + "</div></td>")
                    pftable.Append("<td class=""msgFormBody""><input type=""text"" class=""msgFormStdInput"" name=""uti"" style=""width:300px;"" maxLength=""50"" value=" + Chr(34) + _userTitle + Chr(34) + ">")
                    pftable.Append("</td></tr>")
                End If


                '-- Avatar
                If _eu14 = True Then
                    pftable.Append("<tr><td class=""msgFormDesc"" valign=""top"" height=""20""><b>" + getHashVal("user", "127") + "</b><div class=""msgFormDescSm"">" + getHashVal("user", "128"))
                    If _eu15 = True Then
                        pftable.Append(getHashVal("user", "129"))
                    Else
                        pftable.Append(".")
                    End If
                    pftable.Append("</div></td>")
                    pftable.Append("<td class=""msgFormBody"">" + getHashVal("user", "130") + "<br /><table border=""0"" cellpadding=""3"" cellspacing=""0""><tr><td><select name=""ava1"" class=""msgSm"" size=""5"" onchange=""swapAvatar(this.value)"">")
                    pftable.Append("<option value=""blank.gif"">No Avatar</option>")

                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_ActiveAvatars", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataConn.Open()
                    dataRdr = dataCmd.ExecuteReader
                    If dataRdr.IsClosed = False Then
                        While dataRdr.Read
                            If dataRdr.IsDBNull(0) = False Then
                                If dataRdr.Item(0) = _uAvatar Then
                                    pftable.Append("<option value=" + Chr(34) + dataRdr.Item(0) + Chr(34) + " selected>" + dataRdr.Item(0) + "</option>")
                                Else
                                    pftable.Append("<option value=" + Chr(34) + dataRdr.Item(0) + Chr(34) + ">" + dataRdr.Item(0) + "</option>")
                                End If

                            End If
                        End While
                        dataRdr.Close()
                        dataConn.Close()
                    End If
                    pftable.Append("</select></td><td width=""150"" class=""msgFormBody"" align=""center"" valign=""top"">" + getHashVal("user", "131") + "<br />")
                    If _uAvatar <> String.Empty And Left(_uAvatar, 7).ToLower <> "http://" Then
                        pftable.Append("<img src=" + Chr(34) + siteRoot + "/avatar/" + _uAvatar + Chr(34) + " name=""avaImg"" id=""avaImg"">")
                    ElseIf Left(_uAvatar, 4).ToLower = "http" Then
                        pftable.Append("<img src=" + Chr(34) + _uAvatar + Chr(34) + " name=""avaImg"" id=""avaImg"">")
                    Else
                        pftable.Append("<img src=" + Chr(34) + siteRoot + "/avatar/blank.gif"" name=""avaImg"" id=""avaImg"">")
                    End If


                    pftable.Append("</td></tr></table>")
                    If _uAvatar.Trim <> String.Empty Then
                        If Left(_uAvatar, 4).ToLower <> "http" And Left(_uAvatar, 3).ToLower <> "ftp" Then
                            _uAvatar = "http://www."
                        End If
                    Else
                        _uAvatar = "http://www."
                    End If
                    If _eu15 = True Then
                        pftable.Append("OR<br />" + getHashVal("user", "132") + "<br /><input type=""text"" class=""msgFormStdInput"" style=""width:300px;"" name=""ava2"" maxLength=""150"" value=" + Chr(34) + _uAvatar + Chr(34) + "></td></tr>")
                    End If

                End If

                '-- Private messaging

                pftable.Append("<tr><td class=""msgFormDesc"" height=""20"" valign=""top"">" + getHashVal("user", "133") + "<div class=""msgFormDescSm"">" + getHashVal("user", "134") + "</div></td>")
                pftable.Append("<td class=""msgFormBody"" valign=""top"">")
                If _eu30 = False Then
                    pftable.Append(getHashVal("user", "135"))
                ElseIf _pmLock = False And uGUID <> GUEST_GUID Then
                    pftable.Append(getHashVal("user", "136"))
                Else
                    pftable.Append(getHashVal("uer", "137") + "&nbsp; ")
                    pftable.Append("<input type=""radio"" name=""upm"" value=""1" + Chr(34))
                    If _usePM = True Then
                        pftable.Append(" checked")
                    End If
                    pftable.Append(">" + getHashVal("user", "138") + "&nbsp")
                    pftable.Append("<input type=""radio"" name=""upm"" value=""0" + Chr(34))
                    If _usePM = False Then
                        pftable.Append(" checked")
                    End If
                    pftable.Append(">" + getHashVal("user", "139") + "&nbsp<br />")
                    pftable.Append("Popup notification of new messages : &nbsp; ")
                    pftable.Append("<input type=""radio"" name=""pup"" value=""1" + Chr(34))
                    If _pmPopUp = True Then
                        pftable.Append(" checked")
                    End If
                    pftable.Append(">" + getHashVal("user", "138") + "&nbsp")
                    pftable.Append("<input type=""radio"" name=""pup"" value=""0" + Chr(34))
                    If _pmPopUp = False Then
                        pftable.Append(" checked")
                    End If
                    pftable.Append(">" + getHashVal("user", "139") + "&nbsp<br />")
                    pftable.Append("E-mail notification of new messages : &nbsp; ")
                    pftable.Append("<input type=""radio"" name=""pem"" value=""1" + Chr(34))
                    If _pmEmail = True Then
                        pftable.Append(" checked")
                    End If
                    pftable.Append(">" + getHashVal("user", "138") + "&nbsp")
                    pftable.Append("<input type=""radio"" name=""pem"" value=""0" + Chr(34))
                    If _pmEmail = False Then
                        pftable.Append(" checked")
                    End If
                    pftable.Append(">" + getHashVal("user", "139") + "&nbsp<br />")

                End If

                pftable.Append("</td></tr>")

                '-- buttons
                pftable.Append("<tr><td class=""msgFormDesc"" height=""20"" >&nbsp;</td>")
                pftable.Append("<td class=""msgFormDesc"">")
                pftable.Append("<input type=""submit"" name=""sButton"" value=" + Chr(34) + getHashVal("user", "53") + Chr(34) + " class=""msgButton"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"">&nbsp;")
                pftable.Append("</td></tr></form>")
            End If
            pftable.Append("</table>")
            Return pftable.ToString
        End Function

        '-- returns the user profile form for use with the cp
        Private Function cpUserProfile(ByVal uGUID As String) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If userStrLoaded = False Then
                userStrLoaded = xmlLoadStringMsg("user")
            End If
            Dim pftable As New StringBuilder("")
            Dim showform As Boolean = True
            Dim htmlSignature As String = ""
            pftable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" align=""center"" class=""tblStd"" height=""300"">")
            If uGUID = GUEST_GUID And _createNew = False Then
                showform = False
                pftable.Append("<tr><td class=""msgSm"" valign=""top"" align=""center"" height=""20""><br />" + getHashVal("user", "34") + "</td></tr>")
                pftable.Append("<tr><td class=""msgSm"" valign=""top"" align=""center""><br />")
                pftable.Append(forumLoginForm())
                pftable.Append("</td></tr>")
            ElseIf uGUID <> GUEST_GUID And _createNew = False And _processForm = False Then     '-- valid GUID format, get profile info
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_GetUserProfile2", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataConn.Open()
                dataRdr = dataCmd.ExecuteReader()
                If dataRdr.IsClosed = False Then
                    While dataRdr.Read
                        If dataRdr.IsDBNull(0) = False Then
                            _realname = dataRdr.Item(0)
                        End If
                        If dataRdr.IsDBNull(1) = False Then
                            _userName = dataRdr.Item(1)
                        End If
                        If dataRdr.IsDBNull(2) = False Then
                            _userPass = dataRdr.Item(2)
                            _userPass = forumRotate(_userPass)
                        End If
                        If dataRdr.IsDBNull(3) = False Then
                            _userEmail = dataRdr.Item(3)
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
                            _msnName = dataRdr.Item(11)
                        End If
                        If dataRdr.IsDBNull(12) = False Then
                            _yPager = dataRdr.Item(12)
                        End If
                        If dataRdr.IsDBNull(13) = False Then
                            _uLocation = dataRdr.Item(13)
                        End If
                        If dataRdr.IsDBNull(14) = False Then
                            _uOccupation = dataRdr.Item(14)
                        End If
                        If dataRdr.IsDBNull(15) = False Then
                            _uInterests = dataRdr.Item(15)
                            _uInterests = _uInterests.Replace("<br>", vbCrLf)
                        End If
                        If dataRdr.IsDBNull(16) = False Then
                            _uAvatar = dataRdr.Item(16)
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

                    End While
                    dataRdr.Close()
                    dataConn.Close()
                End If
            End If
            If showform = True Then
                pftable.Append("<tr><td class=""msgTopicHead"" colspan=""2"" align=""center"">" + getHashVal("user", "41") + "</td></tr>")
                pftable.Append("<form action=" + Chr(34) + siteRoot + "/cp.aspx"" method=""post"">")
                pftable.Append("<input type=""hidden"" name=""f"" value=" + Chr(34) + _forumID.ToString + Chr(34) + " />")
                pftable.Append("<input type=""hidden"" name=""m"" value=" + Chr(34) + _messageID.ToString + Chr(34) + " />")
                pftable.Append("<input type=""hidden"" name=""verify"" value=""1"" />")
                pftable.Append("<input type=""hidden"" name=""p"" value=""2"" />")
                '-- real name
                pftable.Append("<tr><td class=""msgFormDesc"" height=""20"" width=""40%"" ><b>" + getHashVal("user", "42") + "</b><div class=""msgFormDescSm"">" + getHashVal("user", "43") + "</div></td>")
                pftable.Append("<td class=""msgFormBody"" width=""60%""><input type=""text"" class=""msgFormStdInput"" style=""width:150px;"" name=""rn"" maxLength=""100"" value=" + Chr(34) + _realname + Chr(34) + "></td></tr>")
                '-- user name
                pftable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>" + getHashVal("user", "44") + "</b><div class=""msgFormDescSm"">")
                If _userName.ToString.Trim = String.Empty Or _createNew = True Then
                    pftable.Append(getHashVal("user", "45"))
                    pftable.Append("</div></td><td class=""msgFormBody""><input type=""text"" class=""msgFormStdInput"" style=""width:150px;"" name=""un"" maxLength=""50"" value=" + Chr(34) + _userName + Chr(34) + "></td></tr>")
                Else
                    pftable.Append(getHashVal("user", "140"))
                    pftable.Append("<input type=""hidden"" name=""un"" value=" + Chr(34) + _userName + Chr(34) + ">")
                    pftable.Append("</div></td><td class=""msgFormBody"">" + _userName + "</td></tr>")
                End If
                '-- password
                If _eu36 = True Then
                    pftable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>" + getHashVal("user", "46") + "</b><div class=""msgFormDescSm"">" + getHashVal("user", "176") + "</div></td>")
                    pftable.Append("<td class=""msgFormBody"">************</td></tr>")
                    pftable.Append("<input type=""hidden"" name=""pw"" value=""************"" />")
                Else
                    pftable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>" + getHashVal("user", "46") + "</b><div class=""msgFormDescSm"">" + getHashVal("user", "47") + "</div></td>")
                    pftable.Append("<td class=""msgFormBody""><input type=""text"" class=""msgFormStdInput"" name=""pw"" style=""width:150px;"" maxLength=""50"" value=" + Chr(34) + _userPass + Chr(34) + "></td></tr>")
                End If

                '-- email
                pftable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>" + getHashVal("user", "50") + "</b><div class=""msgFormDescSm"">" + getHashVal("user", "51") + "</div></td>")
                pftable.Append("<td class=""msgFormBody""><input type=""text"" class=""msgFormStdInput"" name=""em"" style=""width:200px;"" maxLength=""64"" value=" + Chr(34) + _userEmail + Chr(34) + "></td></tr>")

                '------------------------
                '-- begin optional items
                pftable.Append("<tr><td class=""msgTopicHead"" colspan=""2"" align=""center"">" + getHashVal("main", "138") + "</td></tr>")
                '-- show email
                If _eu21 = True Then
                    pftable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>" + getHashVal("user", "141") + "</b><br /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/mail.gif"" border=""0"" height=""27"" width=""25"" alt=" + Chr(34) + getHashVal("user", "142") + Chr(34) + " align=""left""><div class=""msgFormDescSm"">" + getHashVal("user", "142") + "</div></td>")
                    pftable.Append("<td class=""msgFormBody"">")
                    pftable.Append("<input type=""radio"" name=""se"" value=""1" + Chr(34))
                    If _showEmail = 1 Then
                        pftable.Append(" checked")
                    End If
                    pftable.Append(">" + getHashVal("user", "143") + "<br />")
                    pftable.Append("<input type=""radio"" name=""se"" value=""0" + Chr(34))
                    If _showEmail = 0 Then
                        pftable.Append(" checked")
                    End If
                    pftable.Append(">" + getHashVal("user", "144") + "<br />")
                    pftable.Append("</td></tr>")
                End If

                '-- homepage
                If _eu22 = True Then
                    pftable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>" + getHashVal("user", "87") + "</b><br /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/home.gif"" border=""0"" height=""27"" width=""25"" alt=" + Chr(34) + getHashVal("user", "23") + Chr(34) + " align=""left""><div class=""msgFormDescSm"">" + getHashVal("user", "145") + "</div></td>")
                    pftable.Append("<td class=""msgFormBody""><input type=""text"" class=""msgFormStdInput"" name=""url"" style=""width:300px;"" maxLength=""200"" value=" + Chr(34) + _homePage + Chr(34) + "></td></tr>")
                End If

                '-- AOL IM
                If _eu17 = True Then
                    pftable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>" + getHashVal("user", "146") + " : </b><br /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/aim.gif"" border=""0"" height=""27"" width=""25"" alt=" + Chr(34) + getHashVal("user", "146") + Chr(34) + " align=""left""><div class=""msgFormDescSm"">" + getHashVal("user", "147") + "</div></td>")
                    pftable.Append("<td class=""msgFormBody""><input type=""text"" class=""msgFormStdInput"" name=""aim"" style=""width:200px;"" maxLength=""50"" value=" + Chr(34) + _aimName + Chr(34) + "></td></tr>")
                End If

                '-- ICQ number
                If _eu20 = True Then
                    pftable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>" + getHashVal("user", "89") + "</b><br /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/icq.gif"" border=""0"" height=""27"" width=""25"" alt=" + Chr(34) + getHashVal("user", "148") + Chr(34) + " align=""left""><div class=""msgFormDescSm"">" + getHashVal("user", "149") + "</div></td>")
                    pftable.Append("<td class=""msgFormBody""><input type=""text"" class=""msgFormStdInput"" name=""icq"" style=""width:200px;"" maxLength=""20"" value=")
                    If _icqNumber > 0 Then
                        pftable.Append(Chr(34) + _icqNumber.ToString + Chr(34) + "></td></tr>")
                    Else
                        pftable.Append(Chr(34) + Chr(34) + "></td></tr>")
                    End If
                End If

                '-- Y! Pager
                If _eu18 = True Then
                    pftable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>" + getHashVal("user", "90") + "</b><br /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/y!.gif"" border=""0"" height=""27"" width=""25"" alt=" + Chr(34) + getHashVal("user", "151") + Chr(34) + " align=""left""><div class=""msgFormDescSm"">" + getHashVal("user", "150") + "</div></td>")
                    pftable.Append("<td class=""msgFormBody""><input type=""text"" class=""msgFormStdInput"" name=""ypa"" style=""width:200px;"" maxLength=""50"" value=" + Chr(34) + _yPager + Chr(34) + "></td></tr>")
                End If

                '-- MSN Messenger
                If _eu19 = True Then
                    pftable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>" + getHashVal("user", "91") + "</b><br /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/msnm.gif"" border=""0"" height=""27"" width=""25"" alt=" + Chr(34) + getHashVal("user", "152") + Chr(34) + " align=""left""><div class=""msgFormDescSm"">" + getHashVal("user", "153") + "</div></td>")
                    pftable.Append("<td class=""msgFormBody""><input type=""text"" class=""msgFormStdInput"" name=""msnm"" style=""width:200px;"" maxLength=""64"" value=" + Chr(34) + _msnName + Chr(34) + "></td></tr>")
                End If

                '-- City/state location
                pftable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>" + getHashVal("user", "83") + "</b><div class=""msgFormDescSm"">" + getHashVal("user", "154") + "</div></td>")
                pftable.Append("<td class=""msgFormBody""><input type=""text"" class=""msgFormInput"" name=""loca"" maxLength=""100"" value=" + Chr(34) + _uLocation + Chr(34) + "></td></tr>")

                '-- Occupation
                pftable.Append("<tr><td class=""msgFormDesc"" height=""20"" ><b>" + getHashVal("user", "84") + "</b><div class=""msgFormDescSm"">" + getHashVal("user", "155") + "</div></td>")
                pftable.Append("<td class=""msgFormBody""><input type=""text"" class=""msgFormInput"" name=""occu"" maxLength=""150"" value=" + Chr(34) + _uOccupation + Chr(34) + "></td></tr>")

                '-- Interests
                pftable.Append("<tr><td class=""msgFormDesc"" height=""20""  valign=""top""><b>" + getHashVal("user", "85") + "</b><div class=""msgFormDescSm"">" + getHashVal("user", "156") + "</div></td>")
                pftable.Append("<td class=""msgFormBody""><input type=""text"" class=""msgFormInput"" name=""inter"" maxLength=""150"" value=" + Chr(34) + _uInterests + Chr(34) + "></td></tr>")


                '-- Signature
                If _eu23 = True Then
                    pftable.Append("<tr><td class=""msgFormDesc"" valign=""top"" height=""20"" ><b>" + getHashVal("user", "66") + "</b><div class=""msgFormDescSm"">" + getHashVal("user", "157") + "&nbsp;" + getHashVal("user", "158") + "<br />" + getHashVal("user", "159") + "<a href=" + Chr(34) + siteRoot + "/mCode.aspx"" target=""_blank"">" + getHashVal("user", "160") + "</a>" + getHashVal("user", "161") + "</div></td>")
                    pftable.Append("<td class=""msgFormBody""><textarea class=""msgFormTextBox"" name=""signa"">" + _editSignature + "</textarea></td></tr>")
                End If
                pftable.Append("<tr><td class=""msgFormDesc"" height=""20"" >&nbsp;</td>")
                pftable.Append("<td class=""msgFormDesc"">")
                pftable.Append("<input type=""submit"" name=""sButton"" value=" + Chr(34) + getHashVal("user", "53") + Chr(34) + " class=""msgButton"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"">&nbsp;")
                pftable.Append("</td></tr></form>")


            End If
            pftable.Append("</table>")
            Return pftable.ToString
        End Function

        '-- returns a list of new messages posted in subscribed forums/threads
        Private Function cpViewNewSubscribe(ByVal uGUID As String) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If userStrLoaded = False Then
                userStrLoaded = xmlLoadStringMsg("user")
            End If
            Dim mCount As Integer = 0
            '-- template items
            Dim templStr As String = loadTBTemplate("style-listForum.htm", defaultStyle)
            Dim iconStr As String = String.Empty
            Dim topicStr As String = String.Empty
            Dim replyStr As String = String.Empty
            Dim viewStr As String = String.Empty
            Dim lastStr As String = String.Empty
            Dim firstStr As String = String.Empty
            Dim classStr As String = String.Empty
            Dim lastVisit As String = String.Empty
            Dim topicIcon As String = String.Empty
            Dim lftable As New StringBuilder("")
            Dim showRecord As Boolean = False
            lftable.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" class=""tblStd"">")

            If uGUID = GUEST_GUID Then
                lastVisit = DateTime.Now.ToString
            Else
                If HttpContext.Current.Session("lastVisit") = String.Empty Or IsDate(HttpContext.Current.Session("lastVisit")) = False Then
                    lastVisit = DateTime.Now.ToString
                    HttpContext.Current.Session("lastVisit") = lastVisit
                Else
                    lastVisit = HttpContext.Current.Session("lastVisit")
                End If
            End If

            Dim sbHead As New StringBuilder(templStr)
            sbHead.Replace(vbCrLf, "")
            sbHead.Replace("{IsNewIcon}", "&nbsp;")
            sbHead.Replace("{ICON}", "&nbsp;")
            sbHead.Replace("{TopicTitle}", getHashVal("user", "109"))
            sbHead.Replace("{Replies}", getHashVal("user", "110"))
            sbHead.Replace("{Views}", getHashVal("user", "111"))
            sbHead.Replace("{LastPost}", getHashVal("user", "112"))
            sbHead.Replace("{FirstPost}", getHashVal("user", "113"))
            sbHead.Replace("{ClassTag}", "msgTopicHead")
            lftable.Append(sbHead.ToString)

            lftable.Append(forumStickyItems(_forumID))
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_CPNewSubscribeList", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
            dataParam.Value = XmlConvert.ToGuid(uGUID)
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader

            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    '-- reset values
                    topicStr = String.Empty
                    replyStr = String.Empty
                    viewStr = String.Empty
                    lastStr = String.Empty
                    firstStr = String.Empty
                    showRecord = False

                    '-- post icon
                    If dataRdr.IsDBNull(12) = True Then
                        iconStr = "&nbsp;"
                    Else
                        If LCase(dataRdr.Item(12)) <> "none" And dataRdr.Item(12) <> String.Empty Then
                            iconStr = "<img src=" + Chr(34) + siteRoot + "/posticons/" + dataRdr.Item(12) + ".gif"" border=""0"">"
                        Else
                            iconStr = "&nbsp;"
                        End If
                    End If
                    '-- topic lock
                    If dataRdr.Item(11) = True Then
                        topicStr = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/lock.gif"" border=""0"">&nbsp"
                    End If
                    '-- topic title
                    topicStr += "<a href=" + Chr(34) + siteRoot + "/?f=" + _forumID.ToString + "&m=" + CStr(dataRdr.Item(0)) + Chr(34) + ">"
                    topicStr += Server.HtmlEncode(dataRdr.Item(1)) + "</a>"
                    '-- reply count
                    If dataRdr.IsDBNull(3) = False Then
                        replyStr = CStr(dataRdr.Item(3))
                    Else
                        replyStr = "0"
                    End If
                    '-- view count
                    If dataRdr.IsDBNull(4) = False Then
                        viewStr = CStr(dataRdr.Item(4))
                    Else
                        viewStr = "0"
                    End If

                    '-- first post
                    firstStr = "<a href=" + Chr(34) + siteRoot + "/vp.aspx?f=" + _forumID.ToString + "&p=" + CStr(dataRdr.Item(6)) + Chr(34) + " >"
                    firstStr += Server.HtmlEncode(dataRdr.Item(7)) + "</a>"
                    If dataRdr.IsDBNull(2) = False Then
                        If IsDate(dataRdr.Item(2)) = True Then
                            If CDate(lastVisit) <= dataRdr.Item(2) Then
                                topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newtopic.gif"" alt=""New posts"" border=""0"">"
                            Else
                                topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" alt=""No new posts"" border=""0"">"
                            End If
                        End If
                    End If

                    '-- last post

                    If dataRdr.IsDBNull(9) = False And dataRdr.IsDBNull(10) = False And dataRdr.IsDBNull(5) = False Then
                        lastStr = "<a href=" + Chr(34) + siteRoot + "/vp.aspx?f=" + _forumID.ToString + "&p=" + CStr(dataRdr.Item(9)) + Chr(34) + " >"
                        If _eu31 <> 0 And _timeOffset = 0 Then
                            lastStr += Server.HtmlEncode(dataRdr.Item(10)) + "</a><br />" + FormatDateTime(DateAdd(DateInterval.Hour, _eu31, dataRdr.Item(5)), DateFormat.GeneralDate)

                        ElseIf _timeOffset <> 0 Then
                            lastStr += Server.HtmlEncode(dataRdr.Item(10)) + "</a><br />" + FormatDateTime(DateAdd(DateInterval.Hour, _timeOffset, dataRdr.Item(5)), DateFormat.GeneralDate)

                        Else
                            lastStr += Server.HtmlEncode(dataRdr.Item(10)) + "</a><br />" + CStr(dataRdr.Item(5))
                        End If

                        If uGUID = GUEST_GUID Then
                            topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" alt=" + Chr(34) + getHashVal("main", "18") + Chr(34) + " border=""0"">"
                        Else
                            If IsDate(dataRdr.Item(5)) = True Then
                                If dataRdr.Item(5) > CDate(lastVisit) Then
                                    topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newtopic.gif"" alt=" + Chr(34) + getHashVal("main", "17") + Chr(34) + " border=""0"">"
                                    showRecord = True
                                    mCount += 1
                                Else
                                    topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" alt=" + Chr(34) + getHashVal("main", "18") + Chr(34) + " border=""0"">"
                                End If
                            End If
                        End If

                    Else
                        lastStr = "&nbsp;"
                        topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" alt=" + Chr(34) + getHashVal("main", "18") + Chr(34) + " border=""0"">"
                    End If

                    '-- build from template
                    If showRecord = True Then
                        Dim sbRow As New StringBuilder(templStr)
                        sbRow.Replace(vbCrLf, "")
                        sbRow.Replace("{IsNewIcon}", topicIcon)
                        If _eu6 = True Then
                            sbRow.Replace("{ICON}", iconStr)
                        Else
                            sbRow.Replace("{ICON}", "&nbsp;")
                        End If

                        sbRow.Replace("{TopicTitle}", topicStr)
                        sbRow.Replace("{Replies}", replyStr)
                        sbRow.Replace("{Views}", viewStr)
                        sbRow.Replace("{LastPost}", lastStr)
                        sbRow.Replace("{FirstPost}", firstStr)
                        sbRow.Replace("{ClassTag}", "msgTopic")
                        lftable.Append(sbRow.ToString)
                    End If



                End While
            End If
            If mCount = 0 Then
                lftable.Append("<tr><td class=""msgSm"" colspan=""7"" align=""center"" height=""30""><b>" + getHashVal("user", "162") + "</b></td></tr>")
            End If

            lftable.Append("</table>")
            Return lftable.ToString
        End Function

        '-- mini emoticon pad
        Private Function forumEmoticonMini() As String
            Dim iEM As Integer = 0

            Dim em As New StringBuilder("<table border=""0"" cellpadding=""3"" align=""center"" class=""tblStd"" cellspacing=""0"">")
            em.Append("<tr><td colspan=""4"" align=""center"" class=""msgVoteHead"">" + getHashVal("form", "112") + "</td></tr><tr>")
            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_GetEmoticonMini", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataConn.Open()
            dataRdr = dataCmd.ExecuteReader
            If dataRdr.IsClosed = False Then
                While dataRdr.Read
                    If iEM > 3 Then
                        iEM = 0
                        em.Append("</tr><tr>")
                    End If
                    em.Append("<td class=""msgSm"" align=""center"">")
                    em.Append("<img src=" + Chr(34) + siteRoot + "/emoticons/" + dataRdr.Item(0) + Chr(34))
                    em.Append("onClick=""document.pForm.msgbody.value+=' " + dataRdr.Item(2) + " ';"" style=""cursor:hand;" + Chr(34))
                    em.Append(" alt=" + Chr(34) + dataRdr.Item(1) + Chr(34) + " />")
                    em.Append("</a></td>")
                    iEM += 1
                End While
                dataRdr.Close()
                dataConn.Close()
                If iEM < 3 Then
                    While iEM <= 3
                        em.Append("<td class=""msgSm"">&nbsp;</td>")
                        iEM += 1
                    End While
                End If
            Else
                em.Append("</tr>")
            End If

            em.Append("<tr><td colspan=""4"" align=""center"" class=""msgSm"">")
            em.Append("<a href=""javascript:TB_loadW('3','" + siteRoot + "');"" onmouseover=""window.status=' ';return true;"">" + getHashVal("form", "113") + "</a>")
            em.Append("</td></tr>")
            em.Append("</table>")
            Return em.ToString
        End Function

        '-- the post mCode buttons for forms
        Private Function forumFormButtons() As String
            Dim pb As New StringBuilder()
            pb.Append("<tr><td class=""msgFormDesc"" align=""right"" valign=""top""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" height=""6""  width=""165"" /><br />")
            pb.Append(getHashVal("form", "49") + "<br /><br />" + getHashVal("form", "50") + "<br /><br />")
            If _eu7 = True Then
                pb.Append(forumEmoticonMini())
            End If
            pb.Append("</td>")
            pb.Append("<td class=""msgFormBody"" valign=""top"" width=""100%"">")
            pb.Append("<input type=""button"" name=""tbb0"" class=""msgSmButton"" value=""B"" accesskey=""b"" title=""Bold (Alt+B)"" style=""font-weight:bold;width:25px;height:20px;"" onclick=""TB_Baction(0);"" onmouseover=""TB_helpRoll('b',this,1)"" onmouseout=""TB_helpRoll('b',this,0)"">&nbsp;")
            pb.Append("<input type=""button"" name=""tbb2"" class=""msgSmButton"" value=""I"" accesskey=""i"" title=""Italic (Alt+I)"" style=""font-style:italic;width:25px;height:20px;"" onclick=""TB_Baction(2);"" onmouseover=""TB_helpRoll('i',this,1)"" onmouseout=""TB_helpRoll('i',this,0)"">&nbsp;")
            pb.Append("<input type=""button"" name=""tbb4"" class=""msgSmButton"" value=""U"" accesskey=""u"" title=""Underline (Alt+U)"" style=""text-decoration:underline;width:25px;height:20px;"" onclick=""TB_Baction(4);"" onmouseover=""TB_helpRoll('u',this,1)"" onmouseout=""TB_helpRoll('u',this,0)"">&nbsp;")
            pb.Append("<input type=""button"" name=""tbb6"" class=""msgSmButton"" value="" S&nbsp;"" accesskey=""p"" title=""Striked (Alt+P)"" style=""text-decoration:line-through;width:25px;height:20px;"" onclick=""TB_Baction(6);"" onmouseover=""TB_helpRoll('s',this,1)"" onmouseout=""TB_helpRoll('s',this,0)"">&nbsp;")
            pb.Append("<input type=""button"" name=""tbb18"" class=""msgSmButton"" value=""SUB"" accesskey=""["" title=""Subscript (Alt+[)"" style=""width:45px;height:20px;"" onclick=""TB_Baction(18);"" onmouseover=""TB_helpRoll('su',this,1)"" onmouseout=""TB_helpRoll('su',this,0)"">&nbsp;")
            pb.Append("<input type=""button"" name=""tbb20"" class=""msgSmButton"" value=""SUP"" accesskey=""]"" title=""Subscript (Alt+])"" style=""width:45px;height:20px;"" onclick=""TB_Baction(20);"" onmouseover=""TB_helpRoll('sp',this,1)"" onmouseout=""TB_helpRoll('sp',this,0)"">&nbsp;")
            '-- color selector
            pb.Append("<select name=""cc"" class=""msgSm"" onchange=""javascript:TB_Daction(this.form, this.options[this.selectedIndex].value, 'color')"">")
            pb.Append("<option value=""0"">COLOR</option>")
            pb.Append("<option value=""red"" style=""color:990000;"">red</option>")
            pb.Append("<option value=""orange"" style=""color:#FFA500;"">orange</option>")
            pb.Append("<option value=""yellow"" style=""color:FFFF00;"">yellow</option>")
            pb.Append("<option value=""green"" style=""color:00FF00;"">green</option>")
            pb.Append("<option value=""cyan"" style=""color:008B8B;"">cyan</option>")
            pb.Append("<option value=""blue"" style=""color:000099;"">blue</option>")
            pb.Append("<option value=""purple"" style=""color:800080;"">purple</option>")
            pb.Append("<option value=""white"" style=""color:FFFFFF;"">white</option>")
            pb.Append("<option value=""gray"" style=""color:CCCCCC;"">gray</option>")
            pb.Append("<option value=""black"" style=""color:000000;"">black</option></select>&nbsp;")
            '-- size selector
            pb.Append("<select name=""ss"" class=""msgSm"" onchange=""javascript:TB_Daction(this.form, this.options[this.selectedIndex].value, 'size')"">")
            pb.Append("<option value=""0"">SIZE</option>")
            pb.Append("<option value=""1"">Small</option>")
            pb.Append("<option value=""2"">Medium</option>")
            pb.Append("<option value=""3"">Large</option>")
            pb.Append("<option value=""4"">X-Large</option>")
            pb.Append("<option value=""5"">Huge</option></select>&nbsp;")

            pb.Append("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=""javascript:TBTagsHelp('" + siteRoot + "/mCode.aspx');""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/help.gif"" border=""0"" alt=" + Chr(34) + getHashVal("form", "51") + Chr(34) + "> - " + getHashVal("form", "51") + "</a>")

            pb.Append("<br /><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" height=""2"" width=""50"" /><br />")

            pb.Append("<input type=""button"" name=""tbb8"" class=""msgSmButton"" value=""IMG"" title=""Add an image to your post"" style=""width:45px;height:20px;"" onclick=""TB_Baction(8);"" onmouseover=""TB_helpRoll('im',this,1)"" onmouseout=""TB_helpRoll('im',this,0)"">&nbsp;")
            pb.Append("<input type=""button"" name=""tbb10"" class=""msgSmButton"" value=""URL"" title=""Add a URL to your post"" style=""width:45px;height:20px;"" onclick=""TB_Baction(10);"" onmouseover=""TB_helpRoll('ur',this,1)"" onmouseout=""TB_helpRoll('ur',this,0)"">&nbsp;")
            pb.Append("<input type=""button"" name=""tbb12"" class=""msgSmButton"" value=""LIST"" title=""Add a list of things to your post"" style=""width:45px;height:20px;"" onclick=""TB_Baction(12);"" onmouseover=""TB_helpRoll('l',this,1)"" onmouseout=""TB_helpRoll('l',this,0)"">&nbsp;")
            pb.Append("<input type=""button"" name=""tbb14"" class=""msgSmButton"" value=""QUOTE"" title=""Add a quote to your post"" style=""width:45px;height:20px;"" onclick=""TB_Baction(14);"" onmouseover=""TB_helpRoll('q',this,1)"" onmouseout=""TB_helpRoll('q',this,0)"">&nbsp;")
            pb.Append("<input type=""button"" name=""tbb16"" class=""msgSmButton"" value=""CODE"" title=""Add code text to your post"" style=""width:45px;height:20px;"" onclick=""TB_Baction(16);"" onmouseover=""TB_helpRoll('c',this,1)"" onmouseout=""TB_helpRoll('c',this,0)"">&nbsp;")
            pb.Append("<input type=""button"" name=""flb"" class=""msgSmButton"" value=""FLASH"" title=""Add a flash image to your post"" style=""width:45px;height:20px;"" onclick=""TB_loadW('1','" + siteRoot + "');"" onmouseover=""TB_helpRoll('fl',this,1)"" onmouseout=""TB_helpRoll('fl',this,0)"">&nbsp;")
            pb.Append("<br />")
            pb.Append("<input type=""text"" class=""msgFormHelp"" name=""helpbox"" style=""width:100%;"" value=""Use the buttons above for quick formatting and item additions.""><br />")

            Return pb.ToString
        End Function

        '-- sends out mailer notifications of new postings
        Private Sub forumPostNotification(ByVal forumID As Integer, ByVal messageID As Integer, ByVal postID As Integer, ByVal uGUID As String)
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If formStrLoaded = False Then
                formStrLoaded = xmlLoadStringMsg("form")
            End If
            Dim pageNum As Integer = 1
            Dim pp As Double = 0.0
            Dim tPosts As Integer = 0

            If _eu8 = True Then '-- if reply notifications allowed
                Try
                    Dim SMTPMailer As New MailMessage()
                    Dim mailHead As String = "<html><head><title>" + getHashVal("form", "84") + "</title></head><body><table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%""><tr><td><font face=""Tahoma, Verdana, Helvetica, Sans-Serif"" size=""2"">"
                    Dim mailFoot As String = "</font></td></tr></table></body></html>"
                    Dim mailMsg As String = String.Empty
                    Dim mailCopy As String = "<br>&nbsp;<hr size=""1"" color=""#000000"" noshade>"
                    mailCopy += "<font size=""1""><a href=""http://www.dotnetbb.com"" target=""_blank"">dotNetBB</a> &copy;2002, <a href=""mailto:Andrew@dotNetBB.com"">Andrew Putnam</a></font>"
                    uGUID = checkValidGUID(uGUID)
                    '-- first do forum subscribers
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_GetForumSubscribe", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@ParentMsgID", SqlDbType.Int)
                    dataParam.Value = messageID
                    dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                    dataParam.Value = _forumID
                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                    dataConn.Open()
                    dataRdr = dataCmd.ExecuteReader()
                    If dataRdr.IsClosed = False Then
                        SMTPMailer.From = siteAdmin + "<" + siteAdminMail + ">"
                        If messageID = postID Then
                            SMTPMailer.Subject = boardTitle.ToString + getHashVal("form", "85")
                        Else
                            SMTPMailer.Subject = boardTitle.ToString + getHashVal("form", "86")
                        End If

                        SMTPMailer.BodyFormat = MailFormat.Html
                        While dataRdr.Read
                            If dataRdr.IsDBNull(1) = False Then
                                If dataRdr.IsDBNull(8) = False Then
                                    tPosts = dataRdr.Item(8) + 1
                                    If tPosts > MAX_THREAD Then
                                        pp = tPosts / MAX_THREAD
                                        If CInt(pp) < pp Then
                                            pageNum = CInt(pp) + 1
                                        Else
                                            pageNum = CInt(pp)
                                        End If
                                    End If
                                    If pageNum < 1 Then
                                        pageNum = 1
                                    End If
                                End If
                                If InStr(dataRdr.Item(1), "@", CompareMethod.Binary) > 0 Then
                                    SMTPMailer.To = dataRdr.Item(1)
                                    If dataRdr.IsDBNull(2) = False Then
                                        mailMsg = getHashVal("form", "96") + dataRdr.Item(2) + "<br />"
                                    End If

                                    mailMsg += getHashVal("form", "87") + Chr(34)
                                    If dataRdr.IsDBNull(7) = False Then
                                        mailMsg += dataRdr.Item(7)
                                    End If
                                    mailMsg += Chr(34) + getHashVal("form", "88") + boardTitle + getHashVal("form", "89")
                                    If dataRdr.IsDBNull(6) = False Then
                                        mailMsg += dataRdr.Item(6)
                                    End If
                                    mailMsg += getHashVal("form", "90") + Chr(34)
                                    If dataRdr.IsDBNull(5) = False Then
                                        mailMsg += dataRdr.Item(5)
                                    End If
                                    mailMsg += Chr(34) + ".<br /><br />"
                                    mailMsg += getHashVal("form", "91") + "<br /><br />"
                                    If messageID = postID Then
                                        mailMsg += getHashVal("form", "92") + "<br />"
                                        mailMsg += "<a href=" + Chr(34) + siteURL + siteRoot + "/?f=" + forumID.ToString + "&p=" + pageNum.ToString + "&m=" + messageID.ToString + Chr(34) + " target=""_blank"">"
                                        mailMsg += siteURL + siteRoot + "/?f=" + forumID.ToString + "&m=" + messageID.ToString + "</a>"
                                    Else
                                        mailMsg += getHashVal("form", "93") + "<br />"
                                        mailMsg += "<a href=" + Chr(34) + siteURL + siteRoot + "/?f=" + forumID.ToString + "&p=" + pageNum.ToString + "&m=" + messageID.ToString + "#m" + postID.ToString + Chr(34) + " target=""_blank"">"
                                        mailMsg += siteURL + siteRoot + "/?f=" + forumID.ToString + "&m=" + messageID.ToString + "#m" + postID.ToString + "</a>"
                                    End If

                                    mailMsg += "<br /><br />"
                                    mailMsg += "<br /><br /><hr size=""1"" color=""#000000"" noshade>"
                                    mailMsg += getHashVal("form", "94") + "<a href=""mailto:" + siteAdminMail + Chr(34) + ">" + siteAdminMail + "</a>"
                                    mailMsg += "<br /><br />"

                                    SMTPMailer.Body = mailHead + mailMsg + mailCopy + mailFoot
                                    If smtpServerName <> "" Then
                                        SmtpMail.SmtpServer = smtpServerName
                                    End If
                                    SmtpMail.Send(SMTPMailer)
                                    Server.ClearError()
                                End If
                            End If
                        End While
                        dataRdr.Close()
                    End If
                    dataConn.Close()


                    '-- now do thread subscribers
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_GetMailNotify", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@ParentMsgID", SqlDbType.Int)
                    dataParam.Value = messageID
                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                    dataConn.Open()
                    dataRdr = dataCmd.ExecuteReader()
                    If dataRdr.IsClosed = False Then
                        SMTPMailer.From = siteAdmin + "<" + siteAdminMail + ">"
                        SMTPMailer.Subject = boardTitle.ToString + getHashVal("form", "86")
                        SMTPMailer.BodyFormat = MailFormat.Html
                        While dataRdr.Read
                            If dataRdr.IsDBNull(1) = False Then
                                If dataRdr.IsDBNull(7) = False Then
                                    tPosts = dataRdr.Item(7) + 1
                                    If tPosts > MAX_THREAD Then
                                        pp = tPosts / MAX_THREAD
                                        If CInt(pp) < pp Then
                                            pageNum = CInt(pp) + 1
                                        Else
                                            pageNum = CInt(pp)
                                        End If
                                    End If
                                    If pageNum < 1 Then
                                        pageNum = 1
                                    End If
                                End If
                                If InStr(dataRdr.Item(1), "@", CompareMethod.Binary) > 0 Then
                                    SMTPMailer.To = dataRdr.Item(1)
                                    If dataRdr.IsDBNull(2) = False Then
                                        mailMsg = getHashVal("form", "96") + dataRdr.Item(2) + "<br />"
                                    End If

                                    mailMsg += getHashVal("form", "95") + Chr(34)
                                    If dataRdr.IsDBNull(5) = False Then
                                        mailMsg += dataRdr.Item(5)
                                    End If
                                    mailMsg += Chr(34) + getHashVal("form", "88") + boardTitle + getHashVal("form", "89")
                                    If dataRdr.IsDBNull(6) = False Then
                                        mailMsg += dataRdr.Item(6)
                                    End If
                                    mailMsg += getHashVal("form", "97") + "<br /><br />"
                                    mailMsg += getHashVal("form", "91") + "<br /><br />"
                                    mailMsg += getHashVal("form", "93") + "<br />"
                                    mailMsg += "<a href=" + Chr(34) + siteURL + siteRoot + "/?f=" + forumID.ToString + "&p=" + pageNum.ToString + "&m=" + messageID.ToString + "#m" + postID.ToString + Chr(34) + " target=""_blank"">"
                                    mailMsg += siteURL + siteRoot + "/?f=" + forumID.ToString + "&p=" + pageNum.ToString + "&m=" + messageID.ToString + "#m" + postID.ToString + "</a>"
                                    mailMsg += "<br /><br />"
                                    mailMsg += getHashVal("form", "98") + "<br />"
                                    mailMsg += "<a href=" + Chr(34) + siteURL + siteRoot + "/uns.aspx?m=" + messageID.ToString + Chr(34) + " target=""_blank"">"
                                    mailMsg += siteURL + siteRoot + "/uns.aspx?m=" + messageID.ToString + "</a>"
                                    mailMsg += "<br /><br /><hr size=""1"" color=""#000000"" noshade>"
                                    mailMsg += getHashVal("form", "94") + "<a href=""mailto:" + siteAdminMail + Chr(34) + ">" + siteAdminMail + "</a>"
                                    mailMsg += "<br /><br />"

                                    SMTPMailer.Body = mailHead + mailMsg + mailCopy + mailFoot
                                    If smtpServerName <> "" Then
                                        SmtpMail.SmtpServer = smtpServerName
                                    End If
                                    SmtpMail.Send(SMTPMailer)
                                    Server.ClearError()
                                End If
                            End If
                        End While
                        dataRdr.Close()
                        dataConn.Close()
                    End If
                Catch ex As Exception
                    logErrorMsg("forumPostNotification<br />" + ex.StackTrace.ToString, 1)
                End Try
            End If

        End Sub

        '-- processes/shows the PM message form
        Private Function forumPMForm(ByVal uGUID As String) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If formStrLoaded = False Then
                formStrLoaded = xmlLoadStringMsg("form")
            End If
            If pmStrLoaded = False Then
                pmStrLoaded = xmlLoadStringMsg("pm")
            End If
            Dim nttable As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%"" height=""300"" class=""tblStd"">")
            Dim eSubject As String = String.Empty
            Dim eBody As String = String.Empty
            Dim hBody As String = String.Empty
            Dim eTo As String = _userName
            Dim errStr As String = String.Empty
            Dim eIsParent As Boolean = False
            If uGUID = GUEST_GUID Then    '-- guest user, no posting as guest allowed
                nttable.Append("<tr><td class=""msgTopic"" align=""center"" height=""400"" valign=""top""><br /><b>" + getHashVal("pm", "0") + "</b><br /><br />" + getHashVal("pm", "33") + "<br /><a href=")
                nttable.Append(Chr(34) + siteRoot + "/l.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">")
                nttable.Append(getHashVal("main", "26") + "</a>" + getHashVal("main", "27") + "<br /><br />" + getHashVal("pm", "34") + "<br /><a href=")
                nttable.Append(Chr(34) + siteRoot + "/r.aspx?f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">")
                nttable.Append(getHashVal("main", "26") + "</a>" + getHashVal("pm", "35"))
                nttable.Append("</td></tr></table>")
                Return nttable.ToString
                Exit Function
            End If
            If _processForm = True And (_edOrDel = "n" Or _edOrDel = "ri") And _userName <> String.Empty And _formBody <> String.Empty And _formPreview = False Then
                '-- first check if valid username
                Dim validUser As Boolean = False
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_CheckUserForPM", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@UserName", SqlDbType.VarChar, 50)
                dataParam.Value = _userName
                dataParam = dataCmd.Parameters.Add("@ValidUser", SqlDbType.Bit)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                validUser = dataCmd.Parameters("@ValidUser").Value
                dataConn.Close()
                If validUser = False Then
                    errStr = "<tr><td class=""msgSm"" colspan=""2"" align=""center"" height=""20""><br /><b>" + getHashVal("pm", "36") + "</b></td></tr>"
                    eTo = _userName
                    eBody = _formBody
                    eSubject = _formSubj
                Else
                    eBody = _formBody
                    eSubject = _formSubj
                    hBody = _formBody
                    hBody = forumNoHTMLFix(hBody)
                    hBody = forumTBTagToHTML(hBody, uGUID)
                    Dim meID As Integer = 0
                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_AddNewPM", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@ToName", SqlDbType.VarChar, 50)
                    dataParam.Value = _userName
                    dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                    dataParam.Value = XmlConvert.ToGuid(uGUID)
                    dataParam = dataCmd.Parameters.Add("@Subject", SqlDbType.VarChar, 100)
                    dataParam.Value = eSubject
                    dataParam = dataCmd.Parameters.Add("@MessageEdit", SqlDbType.Text)
                    dataParam.Value = eBody
                    dataParam = dataCmd.Parameters.Add("@MessageHTML", SqlDbType.Text)
                    dataParam.Value = hBody
                    dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                    dataParam.Direction = ParameterDirection.Output
                    dataConn.Open()
                    dataCmd.ExecuteNonQuery()
                    meID = dataCmd.Parameters("@MessageID").Value
                    dataConn.Close()
                    If meID > 0 Then
                        Call forumSendPMNotify(meID)
                    End If
                    nttable.Append("<tr><td class=""msgSm"" align=""center"" height=""20""><br />" + getHashVal("pm", "37") + "<br /><br /><a href=" + Chr(34) + siteRoot + "/?r=pm"">" + getHashVal("main", "26") + "</a>" + getHashVal("pm", "38") + "</td></tr>")
                    nttable.Append("<tr><td>&nbsp;</td></tr></table>")
                    Return nttable.ToString
                    Exit Function
                End If
            ElseIf _formBody <> String.Empty And _formPreview = True Then
                eBody = _formBody
                hBody = _formBody
                hBody = forumNoHTMLFix(hBody)
                hBody = forumTBTagToHTML(hBody, uGUID)
                nttable.Append("<tr><td class=""msgSm"" colspan=""2""><b>" + getHashVal("pm", "39") + "</b><hr size=""1"" noshade />" + hBody + "<hr size=""1"" noshade /></td></tr>")
            End If

            If _edOrDel = "ri" And _messageID > 0 And _formPreview = False Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_GetForPMReply", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                dataParam.Value = _messageID
                dataParam = dataCmd.Parameters.Add("@UserName", SqlDbType.VarChar, 50)
                dataParam.Direction = ParameterDirection.Output
                dataParam = dataCmd.Parameters.Add("@Subject", SqlDbType.VarChar, 100)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                eTo = dataCmd.Parameters("@UserName").Value
                eSubject = dataCmd.Parameters("@Subject").Value
                dataConn.Close()
                If Left(eSubject, 4).ToLower <> "re :" Then
                    eSubject = "RE : " + eSubject
                End If
            ElseIf _formPreview = True Then
                eTo = _userName
                eSubject = _formSubj
            End If
            nttable.Append("<script src=" + Chr(34) + siteRoot + "/js/TBform.js""></script>")
            nttable.Append("<tr><td class=""msgFormTitle"" width=""165"" height=""20""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" width=""165"" height=""10""></td><td class=""msgFormTitle"" width=""100%"">")
            Select Case _edOrDel.ToLower
                Case "n"
                    nttable.Append(getHashVal("pm", "40"))
                Case "ri"
                    nttable.Append(getHashVal("pm", "41"))
            End Select
            nttable.Append("</td></tr>")
            If errStr <> String.Empty Then
                nttable.Append(errStr)
            End If
            nttable.Append("<form action=" + Chr(34) + siteRoot + "/default.aspx"" method=""post"" name=""pForm"">")
            nttable.Append("<input type=""hidden"" name=""r"" value=""pm"" />")
            nttable.Append("<input type=""hidden"" name=""eod"" value=" + Chr(34) + _edOrDel + Chr(34) + " />")
            nttable.Append("<input type=""hidden"" name=""verify"" value=""1"" />")
            If _messageID > 0 Then
                nttable.Append("<input type=""hidden"" name=""m"" value=" + Chr(34) + _messageID.ToString + Chr(34) + " />")
            End If

            nttable.Append("<tr><td class=""msgFormDesc"" align=""right"" width=""165""><a href=""javascript:TBUserLookup('" + siteRoot + "/pop.aspx');"">" + getHashVal("pm", "42") + "</a> &nbsp;" + getHashVal("pm", "16") + "  : </td>")
            nttable.Append("<td class=""msgFormBody""><input type=""text"" value=" + Chr(34) + eTo.ToString.Trim + Chr(34) + " size=""30"" class=""msgFormInput"" name=""uName"" maxLength=""50""></td></tr>")

            nttable.Append("<tr><td class=""msgFormDesc"" align=""right"" width=""165"">" + getHashVal("pm", "18") + " : </td>")
            nttable.Append("<td class=""msgFormBody""><input type=""text"" onblur=""document.pForm.msgbody.focus();"" value=" + Chr(34) + eSubject.ToString.Trim + Chr(34) + " size=""30"" class=""msgFormInput"" name=""frmSubject"" maxLength=""100""></td></tr>")


            '-- Message  Body
            If _eu5 = True Then
                nttable.Append(forumFormButtons())
            Else
                nttable.Append("<tr><td class=""msgFormDesc"" align=""right"" valign=""top""><img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/transdot.gif"" border=""0"" height=""6""  width=""165"" /><br />")
                nttable.Append(getHashVal("form", "49") + "<br /><br />" + getHashVal("form", "52") + "<br /><br />")
                If _eu7 = True Then
                    nttable.Append(forumEmoticonMini())
                End If
                nttable.Append("</td>")
                nttable.Append("<td class=""msgFormBody"" valign=""top"" width=""100%"">")
            End If
            nttable.Append("<textarea class=""msgFormTextBox"" name=""msgbody"" tabindex=""2"" rows=""20"">" + eBody.ToString.Trim + "</textarea>")
            nttable.Append("</td></tr>")

            '-- Post Options
            nttable.Append("<tr><td class=""msgFormDesc"" align=""right"" valign=""top"" width=""165"">" + getHashVal("pm", "48") + "</td>")
            nttable.Append("<td class=""msgFormBody"" valign=""top"">")
            nttable.Append("<input type=""checkbox"" name=""preview"">" + getHashVal("pm", "49") + "<br />")
            nttable.Append("</td></tr>")

            '-- Post buttons
            nttable.Append("<tr><td class=""msgFormDesc"" align=""right"" valign=""top"">&nbsp;</td>")
            nttable.Append("<td class=""msgFormDesc"" valign=""top"">")
            nttable.Append("<input type=""button"" class=""msgButton"" value=" + Chr(34) + getHashVal("pm", "50") + Chr(34) + " name=""btnSubmit"" onclick=""JavaScript:postForm();"" onmouseover=""JavaScript:bRoll2(this,1,0);"" onmouseout=""JavaScript:bRoll2(this,0,0);"">&nbsp;")
            nttable.Append("</td></form></tr></table>")
            Return nttable.ToString


        End Function

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

        '-- send pm email notification
        Private Sub forumSendPMNotify(ByVal newPMID As Integer)
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If pmStrLoaded = False Then
                pmStrLoaded = xmlLoadStringMsg("pm")
            End If
            Dim SMTPMailer As New MailMessage()
            Dim mailHead As String = "<html><head><title>" + getHashVal("pm", "51") + "</title></head><body><table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""100%""><tr><td><font face=""Tahoma, Verdana, Helvetica, Sans-Serif"" size=""2"">"
            Dim mailFoot As String = "</font></td></tr></table></body></html>"
            Dim mailMsg As String = String.Empty
            Dim mailCopy As String = "<br>&nbsp;<hr size=""1"" color=""#000000"" noshade>"
            Dim mailTo As String = String.Empty
            Dim mailToAddr As String = String.Empty
            Dim mailFrom As String = String.Empty
            Dim postUser As String = String.Empty

            mailCopy += "<font size=""1""><a href=""http://www.dotnetbb.com"" target=""_blank"">dotNetBB</a> &copy;2002, <a href=""mailto:Andrew@dotNetBB.com"">Andrew Putnam</a></font>"

            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_GetPMNotifyInfo", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataParam = dataCmd.Parameters.Add("@umpid", SqlDbType.Int)
            dataParam.Value = newPMID
            dataParam = dataCmd.Parameters.Add("@mailTo", SqlDbType.VarChar, 50)
            dataParam.Direction = ParameterDirection.Output
            dataParam = dataCmd.Parameters.Add("@mailToAddr", SqlDbType.VarChar, 64)
            dataParam.Direction = ParameterDirection.Output
            dataParam = dataCmd.Parameters.Add("@postUser", SqlDbType.VarChar, 50)
            dataParam.Direction = ParameterDirection.Output
            dataConn.Open()
            dataCmd.ExecuteNonQuery()
            mailTo = dataCmd.Parameters("@mailTo").Value
            mailToAddr = dataCmd.Parameters("@mailToAddr").Value
            postUser = dataCmd.Parameters("@postUser").Value
            dataConn.Close()
            If mailTo <> String.Empty And mailToAddr <> String.Empty And postUser <> String.Empty Then
                Dim i1 As Integer = 0
                Dim i2 As Integer = 0
                i1 = InStr(mailToAddr, "@", CompareMethod.Binary)
                If i1 > 1 Then
                    i2 = InStr(i1, mailToAddr, ".", CompareMethod.Binary)
                    If i2 > 1 Then
                        mailMsg = getHashVal("pm", "52") + mailTo + "<br />"
                        mailMsg += getHashVal("pm", "53") + postUser + ".<br />"
                        mailMsg += "<br />" + getHashVal("pm", "54")
                        mailMsg += "<a href=" + Chr(34) + siteURL + siteRoot + "?r=pm"" target=""_blank"">"
                        mailMsg += siteURL + siteRoot + "?r=pm</a>"
                        SMTPMailer.Subject = boardTitle.ToString + getHashVal("pm", "51")
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

        '-- prints out the 'sticky' posts
        Private Function forumStickyItems(ByVal forumID As Integer) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If formStrLoaded = False Then
                formStrLoaded = xmlLoadStringMsg("form")
            End If
            Dim stTable As New StringBuilder()
            '-- template items
            Dim templStr As String = loadTBTemplate("style-listForum.htm", defaultStyle)
            Dim iconStr As String = String.Empty
            Dim topicStr As String = String.Empty
            Dim replyStr As String = String.Empty
            Dim viewStr As String = String.Empty
            Dim lastStr As String = String.Empty
            Dim firstStr As String = String.Empty
            Dim classStr As String = String.Empty
            Dim lastVisit As String = String.Empty
            Dim topicIcon As String = String.Empty

            If HttpContext.Current.Session("lastVisit") = String.Empty Or IsDate(HttpContext.Current.Session("lastVisit")) = False Then
                lastVisit = DateTime.Now.ToString
                HttpContext.Current.Session("lastVisit") = lastVisit
            Else
                lastVisit = HttpContext.Current.Session("lastVisit")
            End If

            Try
                If Left(templStr, 6) = "Unable" Then    '-- template missing
                    stTable.Append("<div class=""msgFormError"">" + templStr + "</div>")
                Else

                    dataConn = New SqlConnection(connStr)
                    dataCmd = New SqlCommand("TB_GetStickyThreads", dataConn)
                    dataCmd.CommandType = CommandType.StoredProcedure
                    dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                    dataParam.Value = forumID
                    dataConn.Open()
                    dataRdr = dataCmd.ExecuteReader()
                    If dataRdr.IsClosed = False Then
                        While dataRdr.Read

                            '-- sticky icon
                            iconStr = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/sticky.gif"" border=""0"" alt=" + Chr(34) + getHashVal("form", "99") + Chr(34) + ">"
                            '-- topic lock
                            If dataRdr.Item(11) = True Then
                                topicStr = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/lock.gif"" border=""0"">&nbsp"
                            End If
                            '-- topic title
                            topicStr += getHashVal("form", "100") + "<a href=" + Chr(34) + siteRoot + "/?f=" + forumID.ToString + "&m=" + CStr(dataRdr.Item(0)) + Chr(34) + ">"
                            topicStr += dataRdr.Item(1) + "</a>"
                            '-- reply count
                            If dataRdr.IsDBNull(3) = False Then
                                replyStr = CStr(dataRdr.Item(3))
                            Else
                                replyStr = "0"
                            End If
                            '-- view count
                            If dataRdr.IsDBNull(4) = False Then
                                viewStr = CStr(dataRdr.Item(4))
                            Else
                                viewStr = "0"
                            End If

                            '-- first post
                            firstStr = "<a href=" + Chr(34) + siteRoot + "/vp.aspx?f=" + _forumID.ToString + "&p=" + CStr(dataRdr.Item(6)) + Chr(34) + " >"
                            firstStr += Server.HtmlEncode(dataRdr.Item(7)) + "</a>"
                            If dataRdr.IsDBNull(2) = False Then
                                If IsDate(dataRdr.Item(2)) = True Then
                                    If CDate(lastVisit) <= dataRdr.Item(2) Then
                                        topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newtopic.gif"" alt=" + Chr(34) + getHashVal("main", "17") + Chr(34) + " border=""0"">"
                                    Else
                                        topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" alt=" + Chr(34) + getHashVal("main", "18") + Chr(34) + " border=""0"">"
                                    End If
                                End If
                            End If

                            '-- last post
                            If dataRdr.IsDBNull(9) = False And dataRdr.IsDBNull(10) = False And dataRdr.IsDBNull(5) = False Then
                                lastStr = "<a href=" + Chr(34) + siteRoot + "/vp.aspx?f=" + _forumID.ToString + "&p=" + CStr(dataRdr.Item(9)) + Chr(34) + " >"
                                lastStr += Server.HtmlEncode(dataRdr.Item(10)) + "</a><br />" + CStr(dataRdr.Item(5))
                                If IsDate(dataRdr.Item(5)) = True Then
                                    If CDate(lastVisit) <= dataRdr.Item(5) Then
                                        topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newtopic.gif"" alt=" + Chr(34) + getHashVal("main", "17") + Chr(34) + " border=""0"">"
                                    Else
                                        topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" alt=" + Chr(34) + getHashVal("main", "17") + Chr(34) + " border=""0"">"
                                    End If
                                End If
                            Else
                                lastStr = "&nbsp;"
                                topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" alt=" + Chr(34) + getHashVal("main", "17") + Chr(34) + " border=""0"">"
                            End If
                            If dataRdr.IsDBNull(8) = False Then
                                If dataRdr.Item(8) = True Then
                                    topicIcon = "<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/pollicon.gif"" alt=" + Chr(34) + getHashVal("main", "36") + Chr(34) + " border=""0"">"
                                End If
                            End If
                            '-- build from template
                            Dim sbRow As New StringBuilder(templStr)
                            sbRow.Replace(vbCrLf, "")
                            sbRow.Replace("{IsNewIcon}", topicIcon)
                            sbRow.Replace("{ICON}", iconStr)
                            sbRow.Replace("{TopicTitle}", topicStr)
                            sbRow.Replace("{Replies}", replyStr)
                            sbRow.Replace("{Views}", viewStr)
                            sbRow.Replace("{LastPost}", lastStr)
                            sbRow.Replace("{FirstPost}", firstStr)
                            sbRow.Replace("{ClassTag}", "msgTopicAnnounce")
                            stTable.Append(sbRow.ToString)

                            topicIcon = String.Empty
                            iconStr = String.Empty
                            topicStr = String.Empty
                            replyStr = String.Empty
                            viewStr = String.Empty
                            lastStr = String.Empty
                            firstStr = String.Empty

                        End While
                        dataRdr.Close()
                        dataConn.Close()
                    End If
                End If
            Catch ex As Exception
                logErrorMsg("forumStickyItems<br />" + ex.StackTrace.ToString, 1)
            End Try
            Return stTable.ToString
        End Function

        '-- converts the form posting from TBTags to HTML
        Private Function forumTBTagToHTML(ByVal tbString As String, ByVal uGUID As String) As String
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
            Dim canModerate As Boolean = False
            Dim bWord As String = String.Empty
            Dim gWord As String = String.Empty
            Dim acl As Integer = 0

            dataConn = New SqlConnection(connStr)
            dataCmd = New SqlCommand("TB_GetCanModerate", dataConn)
            dataCmd.CommandType = CommandType.StoredProcedure
            dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
            dataParam.Value = _forumID
            dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
            dataParam.Value = XmlConvert.ToGuid(uGUID)
            dataParam = dataCmd.Parameters.Add("@CanModerate", SqlDbType.Bit)
            dataParam.Direction = ParameterDirection.Output
            dataConn.Open()
            dataCmd.ExecuteNonQuery()
            canModerate = dataCmd.Parameters("@CanModerate").Value
            dataConn.Close()


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
                outSTr = Microsoft.VisualBasic.Replace(outSTr, "[green]", "<font style=""color:009900;"">", , , CompareMethod.Text)
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

                outSTr = loopThruTags(outSTr, "quote")


                outSTr = Microsoft.VisualBasic.Replace(outSTr, QUOTE_START, "<div class=""msgQuoteWrap""><div class=""msgQuote""><b>" + getHashVal("form", "101") + "</b><br />", , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, QUOTE_END, "</div></div>", , , CompareMethod.Text)

                outSTr = Microsoft.VisualBasic.Replace(outSTr, IMG_START, "<img src=" + Chr(34), , , CompareMethod.Text)
                outSTr = Microsoft.VisualBasic.Replace(outSTr, IMG_END, Chr(34) + " border=""0"">", , , CompareMethod.Text)

                outSTr = loopThruTags(outSTr, "list")
                outSTr = loopThruTags(outSTr, "flash")
                outSTr = loopThruTags(outSTr, "url")
                outSTr = loopThruTags(outSTr, "code")


            Catch ex As Exception
                logErrorMsg("forumTBTagToHTML<br />" + ex.StackTrace.ToString, 1)
            End Try

            Return outSTr
        End Function

        '-- prints the footer page icons for the forum list or forum detail
        Private Function forumThreadIcons(ByVal iconList As Integer) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            Dim tiTable As New StringBuilder("<table border=""0"" cellspacing=""0"" cellpadding=""3"" width=""100%"">")
            tiTable.Append("<tr><td class=""msgSm"" colspan=""5""><hr size=""1"" noshade /></td></tr>")
            Select Case iconList
                Case 1
                    tiTable.Append("<tr><td class=""msgSm"" width=""20"">")
                    tiTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newfolder.gif"" border""0"" alt=" + Chr(34) + getHashVal("main", "17") + Chr(34) + ">")
                    tiTable.Append("</td><td class=""msgSm"" width=""200"">" + getHashVal("main", "17") + "</td>")
                    tiTable.Append("<td class=""msgSm"" width=""20"">")
                    tiTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/nonewfolder.gif"" border""0"" alt=" + Chr(34) + getHashVal("main", "18") + Chr(34) + ">")
                    tiTable.Append("</td><td class=""msgSm"" width=""200"">" + getHashVal("main", "18") + "</td><td class=""msgSm"">&nbsp;</td></tr>")
                Case 2
                    tiTable.Append("<tr><td class=""msgSm"" width=""20"">")
                    tiTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/newtopic.gif"" border""0"" alt=" + Chr(34) + getHashVal("main", "140") + Chr(34) + ">")
                    tiTable.Append("</td><td class=""msgSm"" width=""200"">" + getHashVal("main", "140") + "</td>")
                    tiTable.Append("<td class=""msgSm"" width=""20"">")
                    tiTable.Append("<img src=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/topic.gif"" border""0"" alt=" + Chr(34) + getHashVal("main", "141") + Chr(34) + ">")
                    tiTable.Append("</td><td class=""msgSm"" width=""250"">" + getHashVal("main", "141") + "</td><td class=""msgSm"">&nbsp;</td></tr>")

            End Select

            tiTable.Append("</table>")
            Return tiTable.ToString
        End Function

        '-- Checks Admin feature access
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
            Return hasAccess
        End Function

        '-- gets the string value from the selected hashtable
        Private Function getHashVal(ByVal hashRef As String, ByVal hashKey As String)
            Dim sVal As String = String.Empty
            Select Case hashRef.ToLower
                Case "main"
                    If mainStringHash.Contains(hashKey) Then
                        sVal = mainStringHash(hashKey)
                    Else
                        sVal = "Missing Key Value : 'main', '" + hashKey + "'"
                    End If
                Case "user"
                    If userStringHash.Contains(hashKey) Then
                        sVal = userStringHash(hashKey)
                    Else
                        sVal = "Missing Key Value : 'user', '" + hashKey + "'"
                    End If
                Case "form"
                    If formStringHash.Contains(hashKey) Then
                        sVal = formStringHash(hashKey)
                    Else
                        sVal = "Missing Key Value : 'form', '" + hashKey + "'"
                    End If

                Case "pm"
                    If pmStringHash.Contains(hashKey) Then
                        sVal = pmStringHash(hashKey)
                    Else
                        sVal = "Missing Key Value : 'pm', '" + hashKey + "'"
                    End If

                Case "search"
                    If searchStringHash.Contains(hashKey) Then
                        sVal = searchStringHash(hashKey)
                    Else
                        sVal = "Missing Key Value : 'search', '" + hashKey + "'"
                    End If

                Case "wiz"
                    If wizStringHash.Contains(hashKey) Then
                        sVal = wizStringHash(hashKey)
                    Else
                        sVal = "Missing Key Value : 'wiz', '" + hashKey + "'"
                    End If

            End Select
            Return sVal
        End Function

        '-- prints the user poll form or the poll values if voted already
        Private Function getPollForm(ByVal uGUID As String, ByVal messageID As Integer) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If formStrLoaded = False Then
                formStrLoaded = xmlLoadStringMsg("form")
            End If

            Dim hasVoted As Boolean = False
            Dim pf As New StringBuilder("")

            If uGUID = GUEST_GUID Then      '-- guest cannot vote, must be logged in
                hasVoted = True
            Else
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_CheckIfVoted", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                dataParam.Value = messageID
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataParam = dataCmd.Parameters.Add("@HasVoted", SqlDbType.Bit)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                hasVoted = dataCmd.Parameters("@HasVoted").Value
                dataConn.Close()
            End If

            Dim dc2 As New SqlConnection(connStr)
            Dim dcm2 = New SqlCommand("TB_GetPollValues", dc2)
            Dim dr As SqlDataReader
            dcm2.CommandType = CommandType.StoredProcedure
            dataParam = dcm2.Parameters.Add("@MessageID", SqlDbType.Int)
            dataParam.Value = messageID
            dc2.Open()
            dr = dcm2.ExecuteReader

            If dr.IsClosed = False Then
                If hasVoted = False Then    '-- return form

                    pf.Append("<script language=javascript>" + vbCrLf)
                    pf.Append("<!--" + vbCrLf)
                    pf.Append("var vc=0;" + vbCrLf)
                    pf.Append("function dv() {" + vbCrLf)
                    pf.Append("if (vc==0){" + vbCrLf)
                    pf.Append("alert('" + getHashVal("form", "102") + "');" + vbCrLf)
                    pf.Append("} else {" + vbCrLf)
                    pf.Append("var pURL='" + siteRoot + "/pop.aspx?w=7&m=" + messageID.ToString + "&p='+vc;" + vbCrLf)
                    pf.Append("window.open(pURL, 'tbPop7', 'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=1,width=400,height=150');" + vbCrLf)
                    pf.Append("}}" + vbCrLf)
                    pf.Append("-->" + vbCrLf)
                    pf.Append("</script>")
                    pf.Append("<br />&nbsp;<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""80%"" align=""center"" class=""tblStd"">")
                    pf.Append("<tr><td class=""msgVoteHead"" align=""center"">" + getHashVal("form", "103") + "</td></tr>")
                    pf.Append("<form action=" + Chr(34) + "/pop.aspx"" method=""get"" name=""vForm"">")
                    pf.Append("<input type=""hidden"" name=""w"" value=""7"" />")
                    pf.Append("<input type=""hidden"" name=""m"" value=" + Chr(34) + messageID.ToString + Chr(34) + " />")
                    While dr.Read
                        pf.Append("<tr><td class=""msgVoteRow""><input type=""radio"" name=""p"" onclick=""vc=this.value;"" value=" + Chr(34) + CStr(dr.Item(0)) + Chr(34) + " />")
                        pf.Append(" - " + dr.Item(1) + "</td></tr>")
                    End While
                    dr.Close()
                    dc2.Close()
                    pf.Append("<tr><td class=""msgVoteRow"" align=""center""><input type=""button"" onclick=""javascript:dv();"" class=""msgSmButton"" value=" + Chr(34) + getHashVal("form", "104") + Chr(34) + " /></td></tr></form>")
                    pf.Append("</table><br />&nbsp;")
                Else
                    pf.Append("<br />&nbsp;<table border=""0"" cellpadding=""5"" cellspacing=""0"" align=""center"" width=""500"" class=""tblStd"">")

                    Dim df As Boolean = False
                    While dr.Read
                        If df = False Then
                            df = True
                            pf.Append("<tr><td class=""msgVoteHead"" align=""center"">" + getHashVal("form", "105"))
                            pf.Append(CStr(dr.Item(3)))
                            If dr.Item(3) = 1 Then
                                pf.Append(getHashVal("form", "106"))
                            Else
                                pf.Append(getHashVal("form", "107"))
                            End If
                            pf.Append("</td></tr>")
                        End If
                        Dim wSize As Double = 10
                        Dim votePerc As Double = 0.0
                        Dim tVotes As Integer = 0
                        pf.Append("<tr><td class=""msgVoteRow"">")
                        pf.Append("<table border=""0"" cellpadding=""1"" cellspacing=""0"" height=""15"" class=""tblStd"" width=" + Chr(34))
                        If dr.Item(2) > 0 And dr.Item(3) > 0 Then
                            wSize = dr.Item(2) / dr.Item(3)
                            votePerc = dr.Item(2) / dr.Item(3)
                            wSize = (wSize * 500) + 10
                            pf.Append(FormatNumber(wSize, 0) + Chr(34) + ">")
                        Else
                            pf.Append("10"">")
                        End If

                        pf.Append("<tr><td class=""msgXsm"" align=""center"" background=" + Chr(34) + siteRoot + "/styles/" + defaultStyle + "/images/votebar.gif"" bgcolor=""#2F668C"">" + CStr(dr.Item(2)) + "</td></tr></table>")
                        pf.Append(dr.Item(1) + " - ")
                        pf.Append(FormatPercent(votePerc, 1))

                        pf.Append("</td></tr>")
                    End While
                    dr.Close()
                    dc2.Close()
                    pf.Append("</table><br />&nbsp;")
                End If
            End If



            Return pf.ToString
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
                    If dataRdr.IsDBNull(36) = False Then
                        _eu37 = dataRdr.Item(36)
                    End If
                End While
                dataRdr.Close()
                dataConn.Close()
            End If
            '-- override time offset with UTC to local time offset
            _eu31 = DateDiff(DateInterval.Hour, DateTime.UtcNow, DateTime.Now)

        End Sub

        '-- fixes input values and returns a modified string for the search page
        Private Function keywordFix(ByVal searchWords As String, ByVal asAndOr As Integer) As String
            Dim outKey As String = String.Empty
            Dim retStr As String = String.Empty
            Dim multiSpl() As String
            Dim keyOption As String = " AND "
            If asAndOr = 2 Then
                keyOption = " OR "
            End If

            Dim i As Integer = 0
            If searchWords <> String.Empty Then
                outKey = searchWords
            Else
                Return ""
                Exit Function
            End If
            '-- first strip out unwanted chars
            outKey = outKey.Replace(";", "")
            outKey = outKey.Replace("<", "")
            outKey = outKey.Replace(">", "")
            outKey = outKey.Replace(":", "")
            outKey = outKey.Replace("*", "")
            outKey = outKey.Replace("%", "")
            outKey = outKey.Replace(Chr(0), "")

            If InStr(outKey, ",", CompareMethod.Binary) > 0 Then
                multiSpl = outKey.Split(",")
                For i = LBound(multiSpl) To UBound(multiSpl)
                    If multiSpl(i).Trim = "the" Then
                        multiSpl(i) = String.Empty
                    End If
                    If multiSpl(i).Trim = "and" Then
                        multiSpl(i) = String.Empty
                    End If
                    If multiSpl(i).Trim = "or" Then
                        multiSpl(i) = String.Empty
                    End If
                    If multiSpl(i).Trim = "not" Then
                        multiSpl(i) = String.Empty
                    End If
                    If multiSpl(i).ToString.Length < 3 Then
                        multiSpl(i) = String.Empty
                    End If
                    If multiSpl(i).ToString.Trim <> String.Empty Then
                        '-- updated in v2.1 to search users
                        If _searchIn = 1 Then       '-- search in posts
                            If retStr <> String.Empty Then
                                retStr += keyOption + " m.EditableText LIKE '%" + multiSpl(i).ToString.Trim + "%' "
                            Else
                                retStr = " m.EditableText LIKE '%" + multiSpl(i).ToString.Trim + "%' "
                            End If
                        Else    '-- search for users
                            If retStr <> String.Empty Then
                                retStr += keyOption + " m.UserGUID = (SELECT UserGUID FROM SMB_Profiles WHERE UserName = '" + multiSpl(i).ToString.Trim + "') "
                            Else
                                retStr = " m.UserGUID = (SELECT UserGUID FROM SMB_Profiles WHERE UserName = '" + multiSpl(i).ToString.Trim + "') "
                            End If
                        End If

                    End If
                Next
            Else
                If outKey.Trim = "the" Then
                    outKey = String.Empty
                End If
                If outKey.Trim = "and" Then
                    outKey = String.Empty
                End If
                If outKey.Trim = "or" Then
                    outKey = String.Empty
                End If
                If outKey.Trim = "not" Then
                    outKey = String.Empty
                End If
                If outKey.ToString.Length < 3 Then
                    outKey = String.Empty
                End If
                If outKey.ToString.Length >= 3 Then
                    If _searchIn = 1 Then
                        retStr = "m.EditableText LIKE '%" + outKey.ToString.Trim + "%'"
                    Else
                        retStr = " m.UserGUID = (SELECT UserGUID FROM SMB_Profiles WHERE UserName = '" + outKey.ToString.Trim + "') "
                    End If

                End If
            End If

            outKey = retStr
            Return outKey
        End Function

        '-- loads the file template into a string
        Private Function loadTBTemplate(ByVal templateName As String, ByVal styleName As String) As String
            Dim templateStr As String = "Unable to load template : " & templateName
            Dim fReader As StreamReader
            If File.Exists(Server.MapPath(siteRoot & "/styles/" & styleName & "/" & templateName)) = True Then
                fReader = File.OpenText(Server.MapPath(siteRoot & "/styles/" & styleName & "/" & templateName))
                templateStr = fReader.ReadToEnd
                fReader.Close()
                Return templateStr
            ElseIf File.Exists(Server.MapPath(siteRoot & "/styles/" & defaultStyle & "/" & templateName)) = True Then
                fReader = File.OpenText(Server.MapPath(siteRoot & "/styles/" & styleName & "/" & templateName))
                templateStr = fReader.ReadToEnd
                fReader.Close()
                Return templateStr
            Else
                Return templateStr
            End If

        End Function

        '-- locks thread
        Private Function lockThreadFromLink(ByVal uGUID As String) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            Dim bf As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacint=""0"" width=""100%"" height=""300"">")
            If getAdminMenuAccess(26, uGUID) = False Then    '-- kick if no access
                bf.Append("<tr><td class=""msgSm"" valign=""top"">" + getHashVal("main", "23") + "</td></tr></table>")
                bf.Append(printCopyright())
                Return bf.ToString
                Exit Function
            End If
            bf.Append("<tr><td class=""msgFormError"" valign=""top"" align=""center""><br />")
            If _messageID > 0 Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_LockThread", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                dataParam.Value = _messageID
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                bf.Append(getHashVal("main", "142"))
                bf.Append("<script language=javascript>" + vbCrLf)
                bf.Append("<!--" + vbCrLf)
                bf.Append("function bounceMe() {" + vbCrLf)
                bf.Append("window.location.href='" + siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + "';" + vbCrLf)
                bf.Append("}" + vbCrLf)
                bf.Append("setTimeout('bounceMe()', 1500);" + vbCrLf)
                bf.Append("-->" + vbCrLf)
                bf.Append("</script>" + vbCrLf)
            Else
                bf.Append(getHashVal("main", "143"))
            End If
            bf.Append("</td></tr></table>")
            bf.Append(printCopyright())

            Return bf.ToString
        End Function

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

        '-- processes TBTags to HTML that have possible sub values
        Private Function loopThruTags(ByVal tagStr As String, ByVal tagType As String) As String
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

        '-- returns the drop listing for items per page (top of forum)
        Private Function perPageDrop(ByVal forumID As Integer, Optional ByVal messageID As Integer = 0, Optional ByVal currentPage As Integer = 1, Optional ByVal iAmount As Integer = 50) As String

            Dim pd As New StringBuilder()
            Try
                pd.Append("<input type=""hidden"" name=""f"" value=" + Chr(34) + forumID.ToString + Chr(34) + ">")
                If messageID > 0 Then
                    pd.Append("<input type=""hidden"" name=""m"" value=" + Chr(34) + messageID.ToString + Chr(34) + ">")
                End If
                If currentPage > 1 Then
                    pd.Append("<input type=""hidden"" name=""p"" value=" + Chr(34) + currentPage.ToString + Chr(34) + ">")
                End If
                pd.Append("<select name=""x"" class=""msgSm"" onchange=""cpf.submit()"">")
                If iAmount = 25 Then
                    pd.Append("<option selected>25</option>")
                Else
                    pd.Append("<option>25</option>")
                End If
                If iAmount = 50 Then
                    pd.Append("<option selected>50</option>")
                Else
                    pd.Append("<option>50</option>")
                End If
                If iAmount = 100 Then
                    pd.Append("<option selected>100</option>")
                Else
                    pd.Append("<option>100</option>")
                End If
                pd.Append("</select>&nbsp;")
            Catch ex As Exception
                logErrorMsg("pagePerDrop<br />" + ex.StackTrace.ToString, 1)
            End Try

            Return pd.ToString
        End Function

        '-- returns the drop listing for items per page (bottom of forum)
        Private Function perPageDrop2(ByVal forumID As Integer, Optional ByVal messageID As Integer = 0, Optional ByVal currentPage As Integer = 1, Optional ByVal iAmount As Integer = 50) As String
            Dim pd As New StringBuilder()
            Try
                pd.Append("<input type=""hidden"" name=""f"" value=" + Chr(34) + forumID.ToString + Chr(34) + ">")
                If messageID > 0 Then
                    pd.Append("<input type=""hidden"" name=""m"" value=" + Chr(34) + messageID.ToString + Chr(34) + ">")
                End If
                If currentPage > 1 Then
                    pd.Append("<input type=""hidden"" name=""p"" value=" + Chr(34) + currentPage.ToString + Chr(34) + ">")
                End If
                pd.Append("<select name=""x"" class=""msgSm"" onchange=""cpf2.submit()"">")
                If iAmount = 25 Then
                    pd.Append("<option selected>25</option>")
                Else
                    pd.Append("<option>25</option>")
                End If
                If iAmount = 50 Then
                    pd.Append("<option selected>50</option>")
                Else
                    pd.Append("<option>50</option>")
                End If
                If iAmount = 100 Then
                    pd.Append("<option selected>100</option>")
                Else
                    pd.Append("<option>100</option>")
                End If
                pd.Append("</select>&nbsp;")

            Catch ex As Exception
                logErrorMsg("pagePerDrop2<br />" + ex.StackTrace.ToString, 1)
            End Try
            Return pd.ToString
        End Function

        '-- Copyright message
        '-- NOTE ABOUT COPYRIGHT INFORMATION!
        '-- YOU MAY REMOVE THE IMAGE LINE, BUT YOU CANNOT REMOVE THE "Forum Powered By dotNetBB.." OR THE COPYRIGHT INFORMATION AFTER THAT POINT!
        Private Function printCopyright() As String
            Dim pcStr As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacing=""0"" style=""width:100%;height:100px;"">")


            pcStr.Append("<tr><td class=""copyRight"" align=""center"" valign=""bottom"">")
            '-- THIS LINE IS OPTIONAL
            'pcStr.Append("<a href=""http://www.dotNetBB.com"" target=""_blank""><img src=" + Chr(34) + siteRoot + "/images/dotnetbbsmlogo.gif"" border=""0"" alt=""dotNetBB Forums""></a><br />")

            '-- THESE LINES ARE REQUIRED!
            pcStr.Append("Forum powered by dotNetBB v2.1<br />")
            pcStr.Append("<a href=""http://www.dotnetbb.com"" target=""_blank"">dotNetBB</a>&nbsp;&copy;&nbsp;2000-2002 <a href=""mailto:Andrew@dotNetBB.com"">Andrew Putnam</a>")
            pcStr.Append("</td></tr></table>")
            Return pcStr.ToString
        End Function

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

        '-- make thread sticky
        Private Function stickThreadFromLink(ByVal uGUID As String) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            Dim bf As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacint=""0"" width=""100%"" height=""300"">")
            If getAdminMenuAccess(9, uGUID) = False Then    '-- kick if no access
                bf.Append("<tr><td class=""msgSm"" valign=""top"">" + getHashVal("main", "134") + "</td></tr></table>")
                bf.Append(printCopyright())
                Return bf.ToString
                Exit Function
            End If
            bf.Append("<tr><td class=""msgFormError"" valign=""top"" align=""center""><br />")
            If _messageID > 0 Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_MakeSticky", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@messageid", SqlDbType.Int)
                dataParam.Value = _messageID
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                bf.Append(getHashVal("main", "146"))
                bf.Append("<script language=javascript>" + vbCrLf)
                bf.Append("<!--" + vbCrLf)
                bf.Append("function bounceMe() {" + vbCrLf)
                bf.Append("window.location.href='" + siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + "';" + vbCrLf)
                bf.Append("}" + vbCrLf)
                bf.Append("setTimeout('bounceMe()', 1500);" + vbCrLf)
                bf.Append("-->" + vbCrLf)
                bf.Append("</script>" + vbCrLf)
            Else
                bf.Append(getHashVal("main", "147"))
            End If
            bf.Append("</td></tr></table>")
            bf.Append(printCopyright())

            Return bf.ToString
        End Function

        '-- make thread unsticky
        Private Function unstickThreadFromLink(ByVal uGUID As String) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            Dim bf As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacint=""0"" width=""100%"" height=""300"">")
            If getAdminMenuAccess(9, uGUID) = False Then    '-- kick if no access
                bf.Append("<tr><td class=""msgSm"" valign=""top"">" + getHashVal("main", "134") + "</td></tr></table>")
                bf.Append(printCopyright())
                Return bf.ToString
                Exit Function
            End If
            bf.Append("<tr><td class=""msgFormError"" valign=""top"" align=""center""><br />")
            If _messageID > 0 Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_MakeNonSticky", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@messageid", SqlDbType.Int)
                dataParam.Value = _messageID
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                bf.Append(getHashVal("main", "148"))
                bf.Append("<script language=javascript>" + vbCrLf)
                bf.Append("<!--" + vbCrLf)
                bf.Append("function bounceMe() {" + vbCrLf)
                bf.Append("window.location.href='" + siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + "';" + vbCrLf)
                bf.Append("}" + vbCrLf)
                bf.Append("setTimeout('bounceMe()', 1500);" + vbCrLf)
                bf.Append("-->" + vbCrLf)
                bf.Append("</script>" + vbCrLf)
            Else
                bf.Append(getHashVal("main", "147"))
            End If
            bf.Append("</td></tr></table>")
            bf.Append(printCopyright())

            Return bf.ToString
        End Function

        '-- unlocks thread
        Private Function unlockThreadFromLink(ByVal uGUID As String) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            Dim bf As New StringBuilder("<table border=""0"" cellpadding=""3"" cellspacint=""0"" width=""100%"" height=""300"">")
            If getAdminMenuAccess(26, uGUID) = False Then    '-- kick if no access
                bf.Append("<tr><td class=""msgSm"" valign=""top"">" + getHashVal("main", "134") + "</td></tr></table>")
                bf.Append(printCopyright())
                Return bf.ToString
                Exit Function
            End If
            bf.Append("<tr><td class=""msgFormError"" valign=""top"" align=""center""><br />")
            If _messageID > 0 Then
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_ADMIN_UnLockThread", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                dataParam.Value = _messageID
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = XmlConvert.ToGuid(uGUID)
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                dataConn.Close()
                bf.Append(getHashVal("main", "149"))
                bf.Append("<script language=javascript>" + vbCrLf)
                bf.Append("<!--" + vbCrLf)
                bf.Append("function bounceMe() {" + vbCrLf)
                bf.Append("window.location.href='" + siteRoot + "/?f=" + _forumID.ToString + "&m=" + _messageID.ToString + "';" + vbCrLf)
                bf.Append("}" + vbCrLf)
                bf.Append("setTimeout('bounceMe()', 1500);" + vbCrLf)
                bf.Append("-->" + vbCrLf)
                bf.Append("</script>" + vbCrLf)
            Else
                bf.Append(getHashVal("main", "147"))
            End If
            bf.Append("</td></tr></table>")
            bf.Append(printCopyright())

            Return bf.ToString
        End Function

        '-- user control panel (replaced modfy profile using profileform() )
        Private Function userControlPanel(ByVal uGUID As String) As String
            If mainStrLoaded = False Then
                mainStrLoaded = xmlLoadStringMsg("main")
            End If
            If userStrLoaded = False Then
                userStrLoaded = xmlLoadStringMsg("user")
            End If
            Dim cp As New StringBuilder("<br />")
            Dim errStr As String = String.Empty
            Dim uEnc As String = String.Empty
            Dim hsignature As String = String.Empty
            cp.Append("<table border=""0"" cellpadding=""3"" cellspacing=""0"" width=""98%"" align=""center"" height=""300"">")

            If _currentPage < 1 Or _currentPage > 5 Then
                _currentPage = 1
            End If

            Select Case _currentPage
                Case 1  '-- default
                    cp.Append("<tr><td class=""msgFormHead"" align=""center"" width=""20%"" height=""20"" style=""border-right:1px outset threedshadow;border-left:1px outset threedshadow;border-bottom:1px outset threedshadow;"">" + getHashVal("user", "163") + "</td>")
                    cp.Append("<td class=""msgFormHead"" align=""center"" width=""20%"" style=""border-right:1px outset threedshadow;border-bottom:1px outset threedshadow;""><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=2"">" + getHashVal("user", "164") + "</a></td>")
                    cp.Append("<td class=""msgFormHead"" align=""center"" width=""20%"" style=""border-right:1px outset threedshadow;border-bottom:1px outset threedshadow;""><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=3"">" + getHashVal("user", "165") + "</a></td>")
                    cp.Append("<td class=""msgFormHead"" align=""center"" width=""20%"" style=""border-right:1px outset threedshadow;border-bottom:1px outset threedshadow;""><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=4"">" + getHashVal("user", "166") + "</a></td>")
                    cp.Append("<td class=""msgFormHead"" align=""center"" width=""20%"" style=""border-right:1px outset threedshadow;border-bottom:1px outset threedshadow;""><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=5"">" + getHashVal("user", "167") + "</a></td></tr>")
                    cp.Append("<tr><td colspan=""5"" class=""msgSm"" valign=""top"" height=""20""><b>" + getHashVal("user", "168") + "</b>")
                    cp.Append(cpUnreadPM(uGUID))
                    cp.Append("</td></tr>")
                    cp.Append("<tr><td colspan=""5"" class=""msgSm"" valign=""top"" height=""20""><br /><b>" + getHashVal("user", "169") + "</b>")
                    cp.Append(cpViewNewSubscribe(uGUID))
                    cp.Append("</td></tr>")
                Case 2  '-- edit profile
                    cp.Append("<tr><td class=""msgFormHead"" align=""center"" width=""20%"" height=""20"" style=""border-right:1px outset threedshadow;border-left:1px outset threedshadow;border-bottom:1px outset threedshadow;""><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=1"">" + getHashVal("user", "163") + "</a></td>")
                    cp.Append("<td class=""msgFormHead"" align=""center"" width=""20%"" style=""border-right:1px outset threedshadow;border-bottom:1px outset threedshadow;"">" + getHashVal("user", "164") + "</td>")
                    cp.Append("<td class=""msgFormHead"" align=""center"" width=""20%"" style=""border-right:1px outset threedshadow;border-bottom:1px outset threedshadow;""><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=3"">" + getHashVal("user", "165") + "</a></td>")
                    cp.Append("<td class=""msgFormHead"" align=""center"" width=""20%"" style=""border-right:1px outset threedshadow;border-bottom:1px outset threedshadow;""><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=4"">" + getHashVal("user", "166") + "</a></td>")
                    cp.Append("<td class=""msgFormHead"" align=""center"" width=""20%"" style=""border-right:1px outset threedshadow;border-bottom:1px outset threedshadow;""><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=5"">" + getHashVal("user", "167") + "</a></td></tr>")
                    cp.Append("<tr><td colspan=""5"" class=""msgSm"" valign=""top"" height=""20"">")
                    If _processForm = False Then
                        cp.Append(cpUserProfile(uGUID))
                    Else
                        If _realname.ToString.Trim <> String.Empty Then
                            If _userName.ToString.Trim <> String.Empty Then
                                If _userEmail.ToString.Trim <> String.Empty Then
                                    If InStr(_userEmail, "@", CompareMethod.Binary) > 0 Then
                                        uEnc = _userPass
                                        uEnc = forumRotate(uEnc)
                                        '-- fixed in v2.1 : hsignature was missing previously
                                        hsignature = forumNoHTMLFix(_editSignature)
                                        hsignature = forumTBTagToHTML(hsignature, uGUID)
                                        '---------------
                                        dataConn = New SqlConnection(connStr)
                                        dataCmd = New SqlCommand("TB_CPUpdateProfile", dataConn)
                                        dataCmd.CommandType = CommandType.StoredProcedure
                                        dataParam = dataCmd.Parameters.Add("@RealName", SqlDbType.VarChar, 100)
                                        dataParam.Value = _realname
                                        dataParam = dataCmd.Parameters.Add("@euPassword", SqlDbType.VarChar, 100)
                                        dataParam.Value = uEnc
                                        dataParam = dataCmd.Parameters.Add("@EmailAddress", SqlDbType.VarChar, 64)
                                        dataParam.Value = _userEmail
                                        dataParam = dataCmd.Parameters.Add("@ShowAddress", SqlDbType.Int)
                                        dataParam.Value = _showEmail
                                        dataParam = dataCmd.Parameters.Add("@Homepage", SqlDbType.VarChar, 200)
                                        dataParam.Value = _homePage
                                        dataParam = dataCmd.Parameters.Add("@AIMName", SqlDbType.VarChar, 100)
                                        dataParam.Value = _aimName
                                        dataParam = dataCmd.Parameters.Add("@ICQNumber", SqlDbType.Int)
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
                                        dataParam = dataCmd.Parameters.Add("@EditSignature", SqlDbType.Text)
                                        dataParam.Value = _editSignature
                                        dataParam = dataCmd.Parameters.Add("@Signature", SqlDbType.Text)
                                        dataParam.Value = hsignature
                                        dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                                        dataParam.Value = XmlConvert.ToGuid(uGUID)

                                        dataConn.Open()
                                        dataCmd.ExecuteNonQuery()
                                        dataConn.Close()
                                        cp.Append("<tr><td class=""msgSm"" height=""20"" align=""center"" colspan=""5"" valign=""top""><br /><b>" + getHashVal("user", "170") + "</b><br /><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=2&f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">" + getHashVal("main", "26") + "</a>" + getHashVal("user", "171") + "<br />&nbsp;")
                                        cp.Append("</td></tr>")
                                    Else
                                        errStr = "<tr><td class=""msgFormError"" height=""20"" align=""center"" colspan=""5"" valign=""top""><b>" + getHashVal("user", "51") + "</b></td></tr>"
                                    End If
                                Else
                                    errStr = "<tr><td class=""msgFormError"" height=""20"" align=""center"" colspan=""5"" valign=""top""><b>" + getHashVal("user", "51") + "</b></td></tr>"
                                End If
                            Else
                                errStr = "<tr><td class=""msgFormError"" height=""20"" align=""center"" colspan=""5"" valign=""top""><b>" + getHashVal("user", "171") + "</b></td></tr>"
                            End If
                        Else
                            errStr = "<tr><td class=""msgFormError"" height=""20"" align=""center"" colspan=""5"" valign=""top""><b>" + getHashVal("user", "172") + "</b></td></tr>"
                        End If
                        If errStr <> String.Empty Then
                            cp.Append(errStr)
                            cp.Append("<tr><td colspan=""5"" class=""msgSm"" valign=""top"" height=""20"">")
                            cp.Append(cpUserProfile(uGUID))
                            cp.Append("</td></tr>")

                        End If
                    End If

                    cp.Append("</td></tr>")

                Case 3  '-- edit options
                    cp.Append("<tr><td class=""msgFormHead"" align=""center"" width=""20%"" height=""20"" style=""border-right:1px outset threedshadow;border-left:1px outset threedshadow;border-bottom:1px outset threedshadow;""><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=1"">" + getHashVal("user", "163") + "</a></td>")
                    cp.Append("<td class=""msgFormHead"" align=""center"" width=""20%"" style=""border-right:1px outset threedshadow;border-bottom:1px outset threedshadow;""><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=2"">" + getHashVal("user", "164") + "</a></td>")
                    cp.Append("<td class=""msgFormHead"" align=""center"" width=""20%"" style=""border-right:1px outset threedshadow;border-bottom:1px outset threedshadow;"">" + getHashVal("user", "165") + "</td>")
                    cp.Append("<td class=""msgFormHead"" align=""center"" width=""20%"" style=""border-right:1px outset threedshadow;border-bottom:1px outset threedshadow;""><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=4"">" + getHashVal("user", "166") + "</a></td>")
                    cp.Append("<td class=""msgFormHead"" align=""center"" width=""20%"" style=""border-right:1px outset threedshadow;border-bottom:1px outset threedshadow;""><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=5"">" + getHashVal("user", "167") + "</a></td></tr>")
                    cp.Append("<tr><td colspan=""5"" class=""msgSm"" valign=""top"" height=""20"">")
                    If _processForm = False Then
                        cp.Append(cpUserOptions(uGUID))
                    Else
                        '-- remove admin and moderator from title options
                        '-- updated in v2.1 to user "****" instead of "" for title filter
                        _userTitle = Microsoft.VisualBasic.Replace(_userTitle, "admin", "*****", 1, -1, CompareMethod.Text)
                        _userTitle = Replace(_userTitle, "moderator", "*********", 1, -1, CompareMethod.Text)

                        dataConn = New SqlConnection(connStr)
                        dataCmd = New SqlCommand("TB_CPUpdateOptions", dataConn)
                        dataCmd.CommandType = CommandType.StoredProcedure
                        dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                        dataParam.Value = XmlConvert.ToGuid(uGUID)
                        dataParam = dataCmd.Parameters.Add("@TimeOffset", SqlDbType.Int)
                        dataParam.Value = _timeOffset
                        dataParam = dataCmd.Parameters.Add("@Avatar", SqlDbType.VarChar, 200)
                        dataParam.Value = Left(_uAvatar, 200)

                        dataParam = dataCmd.Parameters.Add("@UsePM", SqlDbType.Bit)
                        dataParam.Value = _usePM
                        dataParam = dataCmd.Parameters.Add("@PMPopUp", SqlDbType.Bit)
                        dataParam.Value = _pmPopUp
                        dataParam = dataCmd.Parameters.Add("@PMEmail", SqlDbType.Bit)
                        dataParam.Value = _pmEmail
                        dataParam = dataCmd.Parameters.Add("@UserTheme", SqlDbType.VarChar, 50)
                        dataParam.Value = Left(defaultStyle, 50)
                        dataParam = dataCmd.Parameters.Add("@UserTitle", SqlDbType.VarChar, 50)
                        dataParam.Value = Left(_userTitle, 50)
                        dataConn.Open()
                        dataCmd.ExecuteNonQuery()
                        dataConn.Close()
                        cp.Append("<div align=""center""><br /><b>" + getHashVal("user", "174") + "</b><br /><br /><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=3&f=" + _forumID.ToString + "&m=" + _messageID.ToString + Chr(34) + ">" + getHashVal("main", "26") + "</a>" + getHashVal("user", "175") + "<br />&nbsp;</div>")
                    End If

                    cp.Append("</td></tr>")


                Case 4 '-- edit subscriptions
                    If _tSub > 0 Then
                        dataConn = New SqlConnection(connStr)
                        dataCmd = New SqlCommand("TB_CPRemoveThreadSubscribe", dataConn)
                        dataCmd.CommandType = CommandType.StoredProcedure
                        dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                        dataParam.Value = XmlConvert.ToGuid(uGUID)
                        dataParam = dataCmd.Parameters.Add("@MessageID", SqlDbType.Int)
                        dataParam.Value = _tSub
                        dataConn.Open()
                        dataCmd.ExecuteNonQuery()
                        dataConn.Close()
                    End If
                    If _fSub > 0 Then
                        dataConn = New SqlConnection(connStr)
                        dataCmd = New SqlCommand("TB_CPRemoveForumSubscribe", dataConn)
                        dataCmd.CommandType = CommandType.StoredProcedure
                        dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                        dataParam.Value = XmlConvert.ToGuid(uGUID)
                        dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                        dataParam.Value = _fSub
                        dataConn.Open()
                        dataCmd.ExecuteNonQuery()
                        dataConn.Close()
                    End If
                    cp.Append("<tr><td class=""msgFormHead"" align=""center"" width=""20%"" height=""20"" style=""border-right:1px outset threedshadow;border-left:1px outset threedshadow;border-bottom:1px outset threedshadow;""><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=1"">" + getHashVal("user", "163") + "</a></td>")
                    cp.Append("<td class=""msgFormHead"" align=""center"" width=""20%"" style=""border-right:1px outset threedshadow;border-bottom:1px outset threedshadow;""><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=2"">" + getHashVal("user", "164") + "</a></td>")
                    cp.Append("<td class=""msgFormHead"" align=""center"" width=""20%"" style=""border-right:1px outset threedshadow;border-bottom:1px outset threedshadow;""><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=3"">" + getHashVal("user", "165") + "</a></td>")
                    cp.Append("<td class=""msgFormHead"" align=""center"" width=""20%"" style=""border-right:1px outset threedshadow;border-bottom:1px outset threedshadow;"">" + getHashVal("user", "166") + "</td>")
                    cp.Append("<td class=""msgFormHead"" align=""center"" width=""20%"" style=""border-right:1px outset threedshadow;border-bottom:1px outset threedshadow;""><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=5"">" + getHashVal("user", "167") + "</a></td></tr>")
                    cp.Append("<tr><td colspan=""5"" class=""msgSm"" valign=""top"" height=""20"">")
                    cp.Append(cpUserSubscribe(uGUID))
                    cp.Append("</td></tr>")
                Case 5  '-- edit ignored users
                    cp.Append("<tr><td class=""msgFormHead"" align=""center"" width=""20%"" height=""20"" style=""border-right:1px outset threedshadow;border-left:1px outset threedshadow;border-bottom:1px outset threedshadow;""><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=1"">" + getHashVal("user", "163") + "</a></td>")
                    cp.Append("<td class=""msgFormHead"" align=""center"" width=""20%"" style=""border-right:1px outset threedshadow;border-bottom:1px outset threedshadow;""><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=2"">" + getHashVal("user", "164") + "</a></td>")
                    cp.Append("<td class=""msgFormHead"" align=""center"" width=""20%"" style=""border-right:1px outset threedshadow;border-bottom:1px outset threedshadow;""><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=3"">" + getHashVal("user", "165") + "</a></td>")
                    cp.Append("<td class=""msgFormHead"" align=""center"" width=""20%"" style=""border-right:1px outset threedshadow;border-bottom:1px outset threedshadow;""><a href=" + Chr(34) + siteRoot + "/cp.aspx?p=4"">" + getHashVal("user", "166") + "</a></td>")
                    cp.Append("<td class=""msgFormHead"" align=""center"" width=""20%"" style=""border-right:1px outset threedshadow;border-bottom:1px outset threedshadow;"">" + getHashVal("user", "167") + "</td></tr>")
                    cp.Append("<tr><td colspan=""5"" class=""msgSm"" valign=""top"" height=""20"">")
                    cp.Append(cpIgnoreFilterList(uGUID))
                    cp.Append("</td></tr>")

            End Select
            cp.Append("<tr><td colspan=""5"">&nbsp;</td></tr>")
            cp.Append("</table>")
            cp.Append(printCopyright())
            Return cp.ToString
        End Function

        '-- Returns the User Name from the GUID
        Private Function userNameFromGUID(ByVal userGUID As String) As String
            Dim uName As String = String.Empty
            Dim cGUID As Guid
            Try
                userGUID = checkValidGUID(userGUID)
                cGUID = XmlConvert.ToGuid(userGUID)
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_UserNameFromGUID", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@UserGUID", SqlDbType.UniqueIdentifier)
                dataParam.Value = cGUID
                dataParam = dataCmd.Parameters.Add("@UserName", SqlDbType.VarChar, 100)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                uName = dataCmd.Parameters("@UserName").Value
                dataConn.Close()
            Catch ex As Exception
                logErrorMsg("userNameFromGUID<br />" + ex.StackTrace.ToString, 1)
                Return "Guest"
            End Try


            Return uName
        End Function

        '-- checks who can post to the selected forum
        Private Function whoCanPost() As Integer
            If _forumID > 0 Then
                Dim wp As Integer = 0
                dataConn = New SqlConnection(connStr)
                dataCmd = New SqlCommand("TB_GetWhoCanPost", dataConn)
                dataCmd.CommandType = CommandType.StoredProcedure
                dataParam = dataCmd.Parameters.Add("@ForumID", SqlDbType.Int)
                dataParam.Value = _forumID
                dataParam = dataCmd.Parameters.Add("@WhoPost", SqlDbType.Int)
                dataParam.Direction = ParameterDirection.Output
                dataConn.Open()
                dataCmd.ExecuteNonQuery()
                wp = dataCmd.Parameters("@WhoPost").Value
                dataConn.Close()
                Return wp
            Else
                Return 0
            End If


        End Function

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


