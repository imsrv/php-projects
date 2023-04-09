                ******************************************************
                ******************************************************
                ***********       PHP-Affiliate v1.2       ***********
                ******************************************************
                ******************************************************


#########################################################
#                                                       #
# PHPSelect Web Development Division                    #
#                                                       #
# http://www.phpselect.com/                             #
#                                                       #
# This script and all included modules, lists or        #
# images, documentation are distributed through         #
# PHPSelect (http://www.phpselect.com/) unless          #
# otherwise stated.                                     #
#                                                       #
# Purchasers are granted rights to use this script      #
# on any site they own. There is no individual site     #
# license needed per site.                              #
#                                                       #
# This and many other fine scripts are available at     #
# the above website or by emailing the distriuters      #
# at admin@phpselect.com                                #
#                                                       #
#########################################################





--------------------------- GNU License ---------------------------

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

-------------------------------------------------------------------



The following are required to use PHP-Affiliate v1.2:

- PHP 4 or higher (The more up-to-date the version, the better)
- MySQL
- phpMyAdmin (downloadable from http://phpmyadmin.sourceforge.net)


This program has been tested on the following server spec:

- Red Hat Linux 7.2
- Apache Web Server 1.3.19
- PHP 4.1.2
- MySQL 3.23.36

I know that it works on these specs, and I give no guarantee of it working on other systems.


Before editing any files, I recommend downloading a great script editor called Crimson Editor.
You can download the FREEWARE program from http://www.crimsoneditor.com
If Windows asks for a program to open any of these scripts in (including .php and .290),
why not select Crimson Editor for stress free editing.


__________________________________________________________________________________

Installation of v1.2


- Download the zip or tar.gz file from www.organicphp.com

- Unzip it (try WinZip available at http://www.winzip.com)

- First you need to create the MySQL database and it's contents.
  Assuming you have phpMyAdmin installed:
  - Copy the contents of database.sql
  - Paste it into the text box on phpMyAdmin underneath "Run SQL query/queries on database affiliates:"
  - Press 'Go' and the tables will be created for you.
  - Then type the following into the same box, replacing 'change' with a password of your choice:
    UPDATE admin set pass = 'change' where user = 'admin';
  - Press 'Go' again and the password will update

- Open up the 'config.php' file in your favourite text editor (e.g. Crimson Editor)

	- For $domain, replace "www.domain.com" with the web address to your site.
	  eg. We would put "www.organicphp.com", you could be "example.domain.com"
	  or "www.domain.com/~you". Do not end with a forward slash (/) or start with
	  "http://"

	- For $server, replace "localhost" with the address to your MySQL server.
	  It is nearly always "localhost", although check with your host if unsure.

	- For $db_user, replace "username" with the username you have made or have been
	  given for your MySQL database.

	- For $db_pass, replace "password" with the password you need to access your MySQL
	  database. Make sure you give the username a password, or anyone can enter and
	  change your database.

	- For $database, replace "affiliates" with the name of your MySQL database, this
	  could be anything, it's up to you (or your host!)

	- For $currency, replace "UK Pounds" with the currency that you will be paying your
	  affiliates in. e.g. US sites may enter "US Dollars".

	- For $emailinfo, replace with your email address.

	- $yoursitename is simply your site name e.g. we would put "OrganicPHP"

	- Save these changes and exit the file

- Next open the file 'check1.php' in your favourite text editor

	- For $payment, replace "5.00" with the amount you would like to pay your affiliates
	  for every successful sale that they have sent you.
	  If you would like to pay different amounts for different products, duplicate the
	  'check1.php' file making files 'check2.php', 'check3.php' etc and enter the
	  different payment amounts in each.

- If your main page is not already named 'index.php' rename it to this.

- Open 'index.php' in your favourite text editor

	- Enter the following code above the <html> tag and any other code:
	  <?PHP include "affiliate.php"; ?>

	- Save the changes and exit the file

- Upload all of the files in their present directory structure to your hosting account,
  using your preferred FTP program. The files and folders must be uploaded into the
  Document Root where your HTML files are.

- To reward your affiliates you need to add the following line to the top of your order confirmation page:
  <?PHP include "check1.php"; ?>
  By adding this code to the page after an order has been submitted, you prevent affiliates
  from being awarded from people just going to the order page.
  Remember that you will need seperate order forms or confirmation pages if you want to
  award affiliates with different amounts.

- If you wish to customise the look of PHP-Affiliate, replace the HTML in the files
  header.290 and footer.290 from the 'user' directory, in your favourite text editor.

- Installation is now complete!








