+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
+ This readme file is written by Steven van den Elzen 
+ Via Milia, The Netherlands, www.viamilia.com
+ All comments need to go to Christian Leberfinger (www.krizleebear.de)
+ FAQ-Section by Christian Leberfinger
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


UPLOADING AND INSTALLING

After downloading PHPACCESS you unzip it and you use your ftp program to 
upload the file phpaccess*.php into the directory you want to protect.
Go up one directory and change it's CHMOD properties into 777 
(using you right mouse button). Go back to the file phpaccess*.php 
and change these CHMOD properties into 775.

Start your browser to open the file you just uploaded to your web server.
You will see a login screen, use test/test to login.

[ NOTE* You can also change the admin username and password in the file 
phpaccess*.php itself using your notepad (line 37/38). You can change it into 
whatever you want. Do this prior to uploading. ]


CREATING OR CHANGING USERS/PASSWORDS

Now you can create your own users and passwords by entering the information 
in the required fields.
Or you can use a set of users/passwords by making your own password list (notepad).


CREATING A PASSWORD LIST

Use a blank .txt file and enter comma separated usernames and passwords, 
each set on one line:

username,password [ NOTE* choose your own usernames and passwords! ]
username,password
username,password
etc.

Save the file as something.txt (local). 
[ NOTE* Do not upload this file, just import it using PHPACCESS ]


IMPORTANT

- There are 2 files generated by PHPACCESS, .htaccess and .htpasswd. 
Removing these files manually means removing the protection of the directory!
This files are hidden. If you can't see them be sure to configure your
ftp-client to show hidden files.



-------------------------------------------------------------------------------
FAQ
-------------------------------------------------------------------------------

- How do I log off?
+ Just close your browser. This should work... =)

-------------------------------------------------------------------------------

- I installed PHPAccess on my site, but i forgot user and password.. :( 
  And I can't find .htaccess and .htpassword - so I can't delete them!
+ You have to set your ftp-prog to show HIDDEN FILES!
  If you have SmartFTP:
  Tools > Settings > Transfer > Directory Listing Options > Show all files
  If you don't have SmartFTP I don't know where to set this option,
  but SmartFTP is free and you can download it at http://www.smartftp.com/

-------------------------------------------------------------------------------

- Does PHPAccess work on a Windows platform? Say Win XP running Apache 2? 
  I could not get it work on this platform.
+ Unix and Windows do not use the same encryption schemes to write "htpasswd" files. 
  If you look at Apache's documentation it says that, on Windows, Apache uses a 
  custom version of MD5 to encrypt passwords.

  This is the first beta-version of PHPAccess where this feature should be
  working. Just copy the file htpasswd.exe from your apache-bin-directory
  to c:\ and use the windows-beta. 
  Please try it and give me feedback. This is only a beta-version!
  
-------------------------------------------------------------------------------