======================================
||  Moiat Chat ver 4.05             ||
||  Copywright 2002-2003 by Bloody  ||
======================================



===================
1. About the script
===================

Moiat Chat is a realtime chat script. A place where you can talk with the visitors just like in live conversation, not having to wait the page to be refreshed. It supports unlimited number of rooms and smiley icons. There is a banning system to keep the unwanted people away. Has full cyrillic support. Everything is text based, so no database of any kind is needed. Simple and light design and yet still good looking.


===============
2. Requirements
===============

- PHP 4 installed as module (should work on PHP3, but not tested)
- "output_buffering" directive should be set to Off in pnp.ini
- "set_time_limit" command enabled (usually aviable if PHP is not in safe mode)


===============
3. Installation
===============

The installation proces is very simple, just extract the files from the archive and follow these steps:
- the following files must be given write permissions: users.txt, banned.txt, history.txt
- you can create the desired rooms by running "define_rooms.php" script
- the room files called "chatX.dat" where X is the number of the room must have write permissions too
- the direcotory "s" also must have write access 
- the variables $username and $password at the top of "ban_admin.php" and "define_rooms.php" files should be set to the desired values
- by default the file "language.php" has all the variables used in that chat in English language, you can translate them to other languages to suit your needs


============
4. Copyright
============

This software is copyright (C) 2002-2003 by Bloody.
You are not allowed to sell or distribute in any way the whole code of this program or portions of it. 
You can modify the code as long as you use it only for your own needs, you are not allowed to sell the modified code.

