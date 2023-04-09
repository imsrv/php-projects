<SCRIPT LANGUAGE=vbscript RUNAT=Server>
	'Clicksee AdNow V 2.0
	'http://www.clickseeadnow.com
	'Last modified 8/3/2000

''''''''''''''''''''''''''''''''''''''''''''''
''''''''''SET UP DATABASE CONNECTION''''''''''
''''''''''''''''''''''''''''''''''''''''''''''

	'******** DSN MS Access ********
	'Const DSNad=""
	'Const UID=""
	'Const PWD=""
	'*******************************

	'******** DSN MS SQL ***********
	'Const DSNad=""
	'Const UID="your_username"
	'Const PWD="your_password"
	'*******************************

	'***** DSNLess MS Access *******
	'Const DSNad="driver={Microsoft Access Driver (*.mdb)};DBQ=c:\yourdirectory\adnow2\csdb\adnow.mdb;"
	'Const UID=""
	'Const PWD=""
	'*******************************

	'***** DSNLess MS SQL **********
	'Const DSNad="driver={SQL Server};server=SQLservername;uid=SQLusername;pwd=SQLpassword;database=SQLdatabasename;"
	'Const UID="SQLusername"
	'Const PWD="SQLpassword"
	'*******************************


''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
''''''''''SET UP LOCATION OF CSANV2_redirect.asp''''''''''
''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

	'PATH TO CSANV2_redirect.asp
	Const redirectLocation="http://yourURL.com/adnow2/redirect/"



'''''''''''''''''''''''''''''''''''''''
''''''''''SET UP EMAIL SERVER''''''''''
'''''''''''''''''''''''''''''''''''''''

	'SMTP NAME
	Const Remote_Mail_Host=""



''''''''''''''''''''''''''''''''''''
''''''''''SET UP SECURITY''''''''''
''''''''''''''''''''''''''''''''''''

	'YOUR DOMAIN
	Const HostName=""

	'SECURITY TIME INCREMENT (MINUTES)
	Const Time_check=""

	'IMPRESSIONS ALLOWED PER TIME INCREMENT
	Const Count_check=""

</SCRIPT>
