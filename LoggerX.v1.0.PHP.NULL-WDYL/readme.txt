I N S T A L L A T I O N   I N S T R U C T I O N S
##############################################################
#                        LoggerX                             #
##############################################################

     I N S T A L L A T I O N   I N S T R U C T I O N S
     

* SYSTEM REQUIREMENTS:

- Any UNIX platform with at least PHP 3.15 + GD compiled (Apache webserver is strongly recommended)

or 

- Any Windows platform with at least PHP 3.15 + GD compiled (if using IIS, better to plugin PHP as ISAPI)

For better performance and security using Apache and mod_php is recommended for all the platforms.

-------------------
MySQL
-------------------

MySQL is simply a database that EXISTS SEPARATELY from your web server,
hosting account, etc...thus, it usually needs to be set up separately by
yourself (if you run the server) or by contacting your ISP to set it up.

It's quite simple - just send an email to your ISP's support saying:

"Hi! I'd like to have a MySQL database set up with my account. Please make
the database name 'whatever' and the password 'whatever'."

That's it! Sit back and a day or two later (if you have a good hosting 
company) you should get an email saying that the database is set up. Now,
the best thing to do is just test it out.

TELNET TO YOUR SERVER (in Windows, select Start->Run->then type "telnet mysite.com")

Once you have a prompt - type in:
mysql -u yourserverloginname -p

HIT RETURN
PUT IN YOUR PASSWORD

Then you should receive a prompt:
mysql>

simply type:
mysql> use yourdatabasename  <<RETURN>>
mysql> go

And it should say "database changed".
THIS MEANS YOU ARE SET UP!

-------------------
* INSTALLATION
-------------------
  Installation Instructions  

1. Unzip the archive to the temporary folder 

2. Upload all files from the temporary folder to the webhost
   NOTE: on some servers you should upload the files with .PHP extension in ASCII (text, not binary mode)
         and NEVER upload images in ASCII mode.

3. Set file permissions on the server to r+w+x+ r+w-x- r+w-x- (744) to all the files, including subdirectories
   Set file permissions r+w+x- r+w+x- r+w+x- (666) for file "config.php" in "dir" directory.
   NOTE: On some systems you may need to change the permissions of the password.php file to (766) and the config.php file to (777)

4. Go to http://www.yourdomain.com/dir/setup.php 

5. Fill in and submit the setup form according your current settings

6. Run http://www.yourdomain.com/dir/install.php 

7. If the red text saying "Installation Failed" appears, you did something wrong, or the system (its database) is already installed.
   Please check all the steps made and if you did everything right, contact the Developer Support.

8. If the green text saying "Installation Successfully completed" appears, then proceed the next steps.

9. Go to the main page to test the site. In case the site is not working properly, repeat steps 1-8. 

-------------------
* CONFIGURATION 
-------------------
The system can be configured via web-based interface: http://www.yourdomain.com/dir/setup.php
Manual configuration: You can manually edit the file "config.php" in the DIR directory.


--------------------------
* ADMINISTRATIVE INTERFACE
--------------------------

The administrative interface allows creating user accounts, deleting, submitting users and other operations.
The admin interface is located at: http://www.yourdomain.com/dir/

Initially the admin password is "password" (all letters small). 
Don't forget to change the password after the first entrance!


*******************************************************************************

FILES SHIPPED: 

		buttons...........................directory for buttons                       
                content...........................directory for includes with content for pages                       
                css...............................directory for stylesheets
                dir...............................directory for administrative area
                images............................directory for images
                include...........................directory for includes for common site elements (menus, headers/footers etc)
		jscripts..........................directory for DHTML menu functions

                operating_system.php..............DETECTION: OS 
                operating_systemex.php............DETECTION: OS example

                java_and_javascript.php...........DETECTION: Java and JavaScript Version 
                java_and_javascriptex.php.........DETECTION: Java and JavaScript Version example

                language.php......................DETECTION: language 
                languageex.php....................DETECTION: language example

                referrers.php.....................DETECTION: referrers
                referrersex.php...................DETECTION: referrers example

                screen_resolution.php.............DETECTION: screen resolution
                screen_resolutionex.php...........DETECTION: screen resolution example

                search_engine.php.................DETECTION: search engine 
                search_engineex.php...............DETECTION: search engine example           

                search_query.php..................DETECTION: search query
                search_queryex.php................DETECTION: search query example                       

                browser.php.......................DETECTION: browser type
                browserex.php.....................DETECTION: browser type example

                color_depth.php...................DETECTION: color depth 
                color_depthex.php.................DETECTION: color depth example

                visitors.php......................DETECTION: number of visitors
                visitorsex.php....................DETECTION: number of visitors example

                visitors_of_the_day.php...........DETECTION: number of visitors in the current day
                visitors_of_the_dayex.php.........DETECTION: number of visitors in the current day example     

                visitors_of_the_month.php.........DETECTION: number of visitors in the current month
                visitors_of_the_monthex.php.......DETECTION: number of visitors in the current month example e

                country.php.......................DETECTION: country detection 
                countryex.php.....................DETECTION: country detection example

                api.js............................javascript with all the client-side functions

                index.php.........................main page
                contact_us.php....................contact us page
                policy.php........................privacy policy
                terms.php.........................terms of use

                counter.php.......................counter, invoked from the user site
                script.htmlt......................template for code embedded in the client webpage
                sign_up.php.......................signup script
                signup.html.......................signup HTML template
                signup.php........................sign up script

                chart.php.........................INTERNAL: class for PieChart
                db.php............................INTERNAL: database class and routines
                image.php.........................INTERNAL: image generation script
                language..........................INTERNAL: language data
                country...........................INTERNAL: country data
                engines.php.......................INTERNAL: search engines data
                message.php.......................INTERNAL: email messages definitions (data)
                template.php......................INTERNAL: template
                user.php..........................INTERNAL: redirector

                login.php.........................login script
                login.htmlt.......................login HTML template

                readme.txt........................this file

*******************************************************************************
