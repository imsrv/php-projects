' Adsense-config.vbs v5.0
' Downloaded from http://www.monetizers.com
' Copyright monetizers.com 2003-2005 with very major revisions by somacon.com
' Distributed under the GNU General Public License (GPL)
' Updated 17-14-2005

' Configure all your variables in this script
UserName = "YourUserName@YourDomain.com"
Password = "YourPassword"

' Leave blank unless your database file "adsense.mdb" is not located
' in the same directory as the script.
DatabasePath = ""

' Enter your GMT time zone in decimal
' Pacific Time [Default] = -8, Eastern Time = -5, Newfoundland = -3.5
GMTTimeZone = -8

' Remove the apostrophe (') in the next four lines and add your 
' information if you want email notification
'UseMail = "yes"
'MailFrom = "Adsense Tracker <YourName@YourAddress.com>"
'SendTo = "rcpt@mydomain.com" ' Separate multiple addresses with a comma (,)
'Server = "webmail.mydomain.com"

' Remove the apostrophe (') in the next four lines and 
' add your information if your email server requires authentication
'Authentication = "yes"
'POPServer = "mailserver.mydomain.com"
'AutUsername = "test"     ' POP server username
'AutPassword = "password" ' POP server password

' Insert an apostrophe (') in the 7th line down prevent an image
' of the actual output from Google from being created.  You can also modify the filename.
' Example: "c:\wwwroot\image.htm" or "image.htm"
' Good for dropping an image in a protected dir on your webserver.  This
' eliminates having to log in from home or an untrusted location with adsense
' account information.  Gives payment history and funds.
'ImagePathAndFilename = "esadmo-image.htm"

' Below are declarations of the variables.
' There is no need to change these.
Dim UserName, Password, DatabasePath
Dim UseMail, MailFrom, SendTo, Server, Authentication
Dim POPServer, AutUsername, AutPassword
Dim ImagePathAndFilename, GMTTimeZone
