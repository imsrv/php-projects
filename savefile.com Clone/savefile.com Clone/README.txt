

To install this website you can either use the install.php file to auto install the database tables or simply copy/paste the included mysql dump into your phpmyadmin.

To start:

Open the file config.php in the savefile_php folder and edit the values to your wishes.


Upload all files to your web server and point your browser to:

http://savefile_clone/install.html

This will auto install the default tables into your mysql database.

Then you can access the admin are by pointing your browser to:

http://savefile_clone/saveile_php/siteadmin25

Enter the default admin login: user/pass= admin25

**for security you need to change this with your first login. and delete the install.php file from your server as leaving it means someone can run it from their browser and delete your entire site!!

***Don't forget in config.php to add /savefile_php to the end, so for example if your site url's http://www.journeytonarnia.com, you would make the url http://www.journeytonarnia.com/savefile_php, because that's where all files will
be  uploaded to.
----------------------------------------------------------------------------------------------------

Chmod the folllowing folders to 777

images25
uploads
icons
----------------------------------------------------------------------------------------------------

