 ____      ___                                ____      __                 __
/\  _``\  /\_ \                              /\  _``\  /\ \               /\ \__
\ \ \/\_\ \//\ \       __      __      _ __  \ \ \/\_\ \ \ \___       __  \ \ ,_\
 \ \ \/_/_  \ \ \    /'__`\  /'__`\   /\`'__\ \ \ \/_/_ \ \  _ `\   /'__`\ \ \ \/
  \ \ \L\ \  \_\ \_ /\  __/ /\ \L\.\_ \ \ \/   \ \ \L\ \ \ \ \ \ \ /\ \L\.\ \ \ \_
   \ \____/  /\____\\ \____\\ \__/.\_\ \ \_\    \ \____/  \ \_\ \_\\ \__/.\_\\ \__\
    \/___/   \/____/ \/____/ \/__/\/_/  \/_/     \/___/    \/_/\/_/ \/__/\/_/ \/__/ v1.0 (16 July 2003)
    Copyright © 2003-2005 Petter Solås / StreamingSoundtracks.com



DESCRIPTION

ClearChat is a simple PHP/MySQL chat block with an HTML-interface. ClearChat is designed for use with PHP-Nuke 6.5 and 
uses the registered users data in its security system. It is only usable for registered users who are logged in.
Users can undock the chat from the site itself so that it operates almost like you are talking to someone with
MSN, ICQ etc. Also features smilies, autolinking of URLs, log, BB-code and a powerful admin area where you have full control
over the chatters. Developed for and tested on PHP-Nuke 6.5 only! Also tested for later versions of Internet Explorer,
Netscape Navigator/Mozilla and Opera.



DISCLAIMER

This application is supplied AS IS. We do not accept any responsibility for damages, losses, or any other problems
caused by the script.



INSTALLATION

After you unzip the file you should have one folder named "ClearChat", one text-file named "block-ClearChat.php",
one sql-file named "clearchat.sql", "License.txt" and this file ("Readme.txt").

1. Open the config file (Found in: ClearChat/common/config.php). You MUST change the database connection settings for the
chat to work. You should also change the password for the admin area ($adminpw found under admin area settings)
If you do not change this, people will be able to access the admin area. Take some time to look through the
different configuration settings in this file. Everything is explained with examples and alternative values.

2. Place the folder named "ClearChat" inside your PHP-Nuke modules-folder. (Path will be nuke-dir/modules/ClearChat/).

3. Place "block-ClearChat.php" inside your PHP-Nuke blocks-folder (Path will be nuke-dir/blocks/block-ClearChat.php).

4. Run "clearchat.sql" in your PHP-Nuke db, and it will create the two tables you will need (nuke_clearchat and nuke_ccerror).
There are several ways to run this file, if you have phpMyAdmin you can open your db and look for something like
"Run SQL query/queries on database nuke" where you can choose "Location of the textfile". You can also run it from Linux/DOS
prompt (For details see http://www.mysql.com/doc/en/Batch_Commands.html) Please make sure both tables are created successfully
in your PHP-Nuke database before proceeding.

5. Go to the admin area of your PHP-Nuke website and click on blocks. Scroll down and fill in the title
(E.g. Chat or ClearChat). Select "ClearChat" in the Filename dropdown. Position it right or left and make sure
Activate? "Yes" is selected. NOW, THIS IS IMPORTANT! Make sure you make this block viewable to "Registered Users Only".
This is because the security system checks the users password and username to see if they match. Due to obvious reasons,
a username and password does not exist for unregistered users. :)



ADMINISTRATION

Once you have set up your chat and it's working you can access the log via the admin area. To access the admin area
look for the ClarChat-link in your Administration-block. After entering the password you specified in config.php, you
should be in. From the admin area you can view logs, delete comments, delete the whole log etc. When you log in the chat
will be displayed. Click on "Chat log" to view the log, or "Error log" to view the error log. The numbers over the two
buttons represents the number of comments/errors that will be printed. (It can take some time to print 5 000 comments...)
When you want to go back to the chat, click on "View Chat". If you want to delete all the comments in the chat or error
log, use the links under the input field in the admin area. To delete a single comment use the link next to it in the
admin chat. From the admin area you have access to more information than from the normal chat. If you hover over a comment
in the admin chat or the log you will see which number the comment is, the time it was posted and the clients IP address.
If a user tries to send data to the chat without actually being logged in, the chat will compare the real user password
against the one the user is sending with the comment and if they do not match the comment will be ignored and the user
data will be stored in the error log instead. If you get a lot of entries in the error log someone is looking for a
security hole (or just using an old/crappy browser.) ;) With the IPCheck you will find out which usernames has been used
from an IP-address. With the NickCheck you can look up all the IP-addresses a user has had. Enter either the IP or
username in the input field above the two buttons. By default your own IP/Username will be displayed there. When you
do a check the result will be printed as links so that you can easily do more thorough checking. The nicknames in the
admin chat and log, as well as the IP and nicknames in the error log, will also show up as links so you easily can do a
check.



LICENSE

1. By using the script you agree to the terms of this license and the GNU general public license.
2. This application is supplied AS IS. We do not accept any responsibility for damages, losses, or any other problems caused
   by the script.
3. You may distribute this package for FREE as long as all files are included and still are as they were upon official release.
   If you have made a cool .css you can send it to adminsensei@streamingsoundtracks.com and we might add it to the official release.
4. We don't promise any new versions, updates, patches or anything like that. You can not demand any either. 
5. We do not have the resources or time to provide any kind of support.



CREATOR

Sensei/Petter Solås
Administrator,
http://www.streamingsoundtracks.com
adminsensei@streamingsoundtracks.com