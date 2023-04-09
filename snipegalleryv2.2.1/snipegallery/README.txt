Snipe Gallery v2.2.1 
Released: 6/13/01
Last Updated: 7/14/2002

--------------------------------------------------------------------
| Snipe Gallery v2.2.1 was written and designed by A. Gianotto.            |
| ------------------------------------------------------------------|
| This software is free                                             |
| for personal and non-commercial use, as long as the HTML comment tags |
| containing the credits remains intact.  To report bugs, find out  |
| if an upgrade has been released, or for installation support, you |
| can e-mail snipe@snipe.net.                                       |
| ------------------------------------------------------------------|
| You may NOT, however, UNDER ANY CIRCUMSTANCES, include this       |
| in a collection which will be sold for any profit without         |
| consulting me first.  Free collections are alright as long as due |
| credit is given.                                                  |
| ------------------------------------------------------------------|
| When e-mailing, please specify the script you are using (in this  |
| case Snipe Gallery v2.2.1), and the specific problems or error           |
| messages you are receiving.  I am NOT a mind reader, so it's the  |
| ONLY way I will even attempt to help you!                         |
|                                                                   |
| If you make any improvements to this script, please let me know!  |
| I'm always interested in peeking at other people's code,          |
| especially if it's better than mine!                              |
|                                                                   |
| One final shameless plug: feel free to stop by my website, at     |
| www.snipe.net.  There are humourous articles, tech tips, graphics |
| tutorials, and more, so poke around a bit.  Who knows... Maybe    |
| I'll add some PHP or mySQL tutorials up there!  :-)               |
--------------------------------------------------------------------
--------------------------------------------------------------------
SCRIPT INFORMATION:
http://www.snipe.net/geek/scripts/gallery.php

FAQ:
http://www.snipe.net/faqs/index.php?category=gallery
(PLEASE check the FAQ before e-mailing with questions)
--------------------------------------------------------------------
FEATURE LIST:
--------------------------------------------------------------------
This is a photo gallery script with a web based admin for easy maintenance.  

1. Easy to install
2. Dynamic thumbnailing, but only in the admin, and ONLY if the thumbnail doesn't already exist, to keep the 
server load down
3. Ability for admin to supress images that should not appear in user view
4. Supports PNG, JPG, and GIF images (depending on your version of the GDlib)
5.  Error checking to prevent admin from being able to delete categories with images or subcategories within them
6.  Spiffy HTML QuickTips in the admin area
7.  Formatting using CSS file


--------------------------------------------------------------------
INSTALLATION:
--------------------------------------------------------------------
1. Create the database tables per the photos.mysql.sql file
2. All configuration variables are contained within the photos.config.php.  Edit
  these values to match your database and path settings
3. Create a directory named "pics" and another namd "thumbs" within your Snipe Gallery directory. 
  (These directory names can be whatever you want, as long as you change them in your config fle
   accordingly.)  CHMOD these directories to 777
4.  You will want to password protect your admin area using htaccess
5.  And that's it!  Have fun!  Email with any questions at snipe@snipe.net


CHANGELOG:
--------------------------------------------------------------------
!!!!!!!! IMPORTANT !!!!!!!!!!!!!!
New in v2.2.1:
--------------------------------------------------------------------
Version 2.2.1 consists of just a few lines of code that were changed, but they 
are pretty freakin' important.  If you don't feel like doing an "upgrade", 
at THE VERY LEAST do the following:

In header.php in the user's gallery directory, add the following line:

unset($is_admin);

A user brought this rather monstrous security hole to our attention (thanks Tom K).
I honestly have NO idea how the HELL we missed that one (not enough Dr Pepper 
that night is my guess), but its fixed now.  If you don't feel like going through the 
trouble of upgrading, you REALLY should at least add that line of code 
somewhere in your header.php file to prevent unwanted access to your admin functions.

A full "upgrade" isn't really necessary, as long as you make this change. The only other
thing that was changed was *finally* removing the random javascript file reference
as well as a few other useless variables that never related to the program in the first place.

--------------------------------------------------------------------
New in v2.2:
--------------------------------------------------------------------
* Fixed some small stupid bugs like leftover CSS file
* Added Insert to SQL to avoid confusion as to the GALLERY/ALBUM relationship
* Fixed View All bug
* Added more documentation in the functions file