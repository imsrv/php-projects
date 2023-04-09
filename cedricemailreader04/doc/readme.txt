Cedric email reader
http://www.isoca.com/creation/webmail/

Realisation : Cedric AUGUSTIN <cedric@isoca.com>
Web : www.isoca.com
Version : 0.4.1
Date : September 2001

---------------------------------------------------------------------------
Summary
A) Presentation
B) Links
C) Install
D) Running
E) Requirements
F) To do list
G) Contributions
H) Change log
I) FAQ

---------------------------------------------------------------------------
A) Presentation


This program is a Web Mail : it's an application permitting access and manage an 
electronic mailbox using a Web Browser. It also gives you the possibility to 
send emails. It shall be installed and configurated on your own web space, and 
not to be used from www.isoca.com, where you only have a demonstration version.

Main features : 
* This Web Mail is written in PHP 4 (version 0.2 for PHP 3), 
* No use of cookies or session. 
*  Read emails on an account IMAP (not yet POP). 
* Delete messages without reading them (very useful if you suspect viruses). 
* Display messages in text or html formats, 
* Read the attachements, 
* Send the messages in text format, with or without attachement, 
* Simple Address Book, 
* ... and still in GPL with sources... 

-------------------------------------------------------------------------------- 
B) Links
* Demonstration of Cedric Email Reader through IMAP Mailbox demo@isoca.com. 
http://www.isoca.com/creation/webmail/emailreader.php

* Demonstration of sending messages with, or without attachement through the 
account demo@isoca.com. http://www.isoca.com/creation/webmail/email.php

* The sources for version 0.4 in one zip-file of 65 kB : 
http://www.isoca.com/creation/webmail/cedricemailreader04.zip

* Send me a little message and tell me what you think about it (cedric@isoca.com 
or by contact). 

* If you have a problem then take a tour at the creation forum. There I publish 
the patches between the versions. http://www.isoca.com/creation/forum/

--------------------------------------------------------------------------------
C)Installation
1) Download the sources. When you have unpacked the archive on your hard drive, 
modify the following files :
   * In the directory /common you will found the default files
     /common/emailreader.ini.php -> general parameters.
     /common/adressbook.opt -> address book.
     /common/fromoption.opt -> email address for the from.
   * In the /perso directory, create a sub-directory with your login as name 
     (ex : mylogin1234). And then, copy the file from the /perso/template 
directory and custom this files.
   * Do the same for every person you want to have his own profil in the 
webmail.

2) Copy all files to a directory of your site.

3) If you want to send attachements, the sub directory named tmp-php should have 
the rights 777 (all rights to everybody).

4) Thats it! It should work. You are strongly recommended to send some words to 
(cedric@isoca.com).

--------------------------------------------------------------------------------
D) Running
Call the page emailreader.php from your bowser. You could specify the language 
by adding the parameter ?lang=XX, where XX can be replaced by fr for french, en 
for english, se for swedish, es for spanish, or de for german. 
If you have made a translation in an other language, please send it to me to 
share it.
In lack of parameter the default language is defined in the file 
emailreaderdefault.ini.php. 

--------------------------------------------------------------------------------
E) Requirements
The server hosting the site must have PHP 4.0.4 or more with the IMAP librairies 
(with php < 4.0.4 script file has to be modify for upload, but anything else 
shoul work). Your messenger must be an IMAP server. There is some Javascript, so 
you have to use a 4th generation (Mozilla, Netscape, ie...). To send 
attachements you have to upload to the server. This Webmail is concieved to be 
used on Hebergement Discount, but it should work elsewhere with some small 
modifications.

--------------------------------------------------------------------------------
F) To do list
Urgent
* Achieve the management of the address book 
* Achieve the multi users implementation 

Less urgent
* Implement the resending (with forwarding attachement).
* Give the choise between POP and IMAP with the same interface.
* Manage a "Sent" box.
* Add erasement of the browser history on the Leave page. 
* ...

--------------------------------------------------------------------------------
G) Contributions
* Programation
  Php and javascript : Cedric Augustin (cedric@isoca.com)

* Web Design & Graphics 
  Layout & graphics: Raphaël GRIGNANI (i@977design.com) from 977design 
(http://www.977design.com). 
  Color code: Joshua Davis

* Translations 
  Peter Arnmark (peter@arnmark.net) from Net Business Design 
(http://www.netbusinessdesign.com). 


--------------------------------------------------------------------------------
H) Change log
0.4
* New Design
* Performence optimisation for mail box ans message reading
* Read any kind of attachment
* Read html email
* Multi user capabilities (profil and address book)
* Directory structure modification
* Translation in 5 lang

0.3
* Read of attachments
* Use of php 4

0.2
* First public version under GNU licence

--------------------------------------------------------------------------------
I) FAQ

Q:Why is everything in english ?
A: To anticipate the notority... ;-) 

Q: Do I have the right to modify the code ?
A: Yes, sure. This work is distributed under the GNU Public Licence. This, among 
other things, means that you can modify the code, but under certain rules
(article 2):
a) Add to the files a clear indication over the effectuated modifications, with 
the date of every change. 
b) Distribute under the General Public Licence termes all realisations including 
all of, or a part of the program, with or without modifications. 
c) If the modifyed Program is reading the controls in an interactive manner when 
executing, make it display the appropriate copyright, during an ordinary 
invocation, indicating clearly the limitation of waranty (or the warranty you 
engage to give yourself), that it stipulate that every user can freely 
redistribute the Program under the GNU Géneral Public Licens, and that he show 
to all users how to read a copy of the licens. 

Q: Will there be new veraions?
A: I really hope so. The version 0.4 is build to evolve easely and to allow 
anybody to add new functionalities (I don't have time anymore). 

Q: Is it possible to install it elsewhera than Hebergement Discount ?
A: You do as you please. I doupt though, that all providers do not offer the PHP 
function "mail"(because of spammers). But if the IMAP librarys are installed it 
should work, at least to read the messages. 

Q: What about the support ?
A: Do not count to much on me. I'm nearly getting lynched by my wife if I go to 
near the computer. No, I'm joking. Advices and enhancements are welcome. 

Q: Responsabilitys ?
A: I'm responsible of nothing ! You assume all the consequences of using these 
scripts. 
--------------------------------------------------------------------------------
Cédric - http://www.isoca.com/ 