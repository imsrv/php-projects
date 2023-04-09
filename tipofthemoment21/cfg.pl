#######################################################
#             Tip of the Moment V2.1
#
# This program is distributed as freeware. We are not            	
# responsible for any damages that the program causes	
# to your system. It may be used and modified free of 
# charge, as long as the copyright notice
# in the program that give me credit remain intact.
# If you find any bugs in this program. It would be thankful
# if you can report it to us at cgifactory@cgi-factory.com.  
# However, that email address above is only for bugs reporting. 
# We will not  respond to the messages that are sent to that 
# address. If you have any trouble installing this program. 
# Please feel free to post a message on our CGI Support Forum.
# Selling this script is absolutely forbidden and illegal.
##################################################################
#
#               COPYRIGHT NOTICE:
#
#         Copyright 1999 The AHC CGI Factory 
#
#      Author:  Yutung Liu
#      web site: http://www.cgi-factory.com
#      E-Mail: cgifactory@cgi-factory.com
#
#   This program is protected by the U.S. and International Copyright Law
#
###################################################################
##################################Modify the area below

$mail_prog = "/usr/lib/sendmail -t";
#the system path to your mail program

$email = "cgifactory\@cgi-factory.com";
#your email. a slash is requried before @ --->  /@

$title = "Proverb of the Moment";
#the title

$showdate="1";
#set this variable to 1 if you want to display the time (0=off)

$tcolor="black";
#title text color

$dcolor="maroon";
#time text color

$mcolor="black";
#message text color

$messages_location = "/web4/home1/www/w143031/docs/tip/data";
#full system path to the place you store the data files. Make sure the location is the same as the path you set in manager.pl. chmod this directory to "777"
#Usually, you don't want to create the directory inside the cgi-bin, because some 
#cgi-bin do't allow you to read the files from a browser.

$messages_location2 = "http://www.cgi-factory.com/tip/data";
#www path to the location where stores the data files

$alert="n";
#send an alert mail to you if someone enters a wrong password (n=off, y=on)

$flock="y";
#"Dont change this variable" to n unless your system doesn't support file locking
