/**************************************************************
* Formmail Abuse Reporting - Version 1.1
*
* (C)Copyright 2002 Home-port.net, Inc. All Rights Reserved 
* By using this software you release Home-port.net, Inc. from 
* all liability relating to this product.
*
* This module is released under the GNU General Public License. 
* See: http://www.gnu.org/copyleft/gpl.html
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*
* For latest version, visit:
* http://www.home-port.net/formmail/
***************************************************************/

------------------------------
Requirements:
------------------------------

Apache 1.3 or above
PHP 4.0 or above
*Sendmail
**httpd.conf

*Or properly configured php.ini file for another MTA so that the 
script can use the mail() function.

**Access to httpd.conf file for entering an Alias. This can be accomplished
Globally for the server or individually for certain domains. If you don't have
access to this file, have your server administrator enter the correct lines
under your domain settings in between the <VirtualHost> tags. 
See "Post Installation" for details.

------------------------------
Description:
------------------------------

See http://www.home-port.net/formmail/
For description and demo

------------------------------
Installation:
------------------------------

1. Change the following config.php variables for example:

// Url to your images dirctory that has the question_warning.gif
   $question = "http://yourdomain.com/Your_directory_choice/images/question_warning.gif";

// Your company name
   $company = "Your_company_name";
   
// The Reply e-mail address you want to use in the complaint e-mails.
   $from2 = "you@yourdomain.com";

// Send a copy of the information to this address for your records. 
// If you want a different address than above. Place it here.
   $to2 = "$from2";  
   
2. Create an arbitrarily named directory to house all the scripts at your web site.
   Ensure you use that directory name in the config.php $question line.
   
3. Chmod the directory you just created 0777 or drwxrwxrwx

4. Upload all files and the images sub-directory into this directory.

5. Chmod 0777 or -rwxrwxrwx the following files:
   complaint.php
   to.php
   ip.txt
   abuse.txt
   
6. Open your browser and go to the url of the directory you just created.
   The first time you do this the index.php file will ask you to create a 
   user name and password for logging in.
   
7. The first thing to do after logging in is to change your testing e-mail
   address. The text field with yourname@ is where you change this information.
   Note: For all testing please ensure the script is in "test mode" or you
   will report yourself to your ISP.
   
8. You then can change the complaint.php file to reflect what you want and 
   send a test e-mail with that information by pressing the multiple recipient
   button.
   
9. Run test until you are satisfied of all results.

10. Optional - The script returns a generic Cobalt Raq 404 error page. You may 
    customize the 404.php file to better match your web site. Note: All images 
	and links must have the full url.
	
------------------------------
How to run tests and 
their expected results:
------------------------------	  

1. Enter your testing e-mail address.

2. Ensure that "Formmail Report is in test mode". If "the script is active mode", 
   then conducting a test will send the results to your ISP's Abuse Team.

3. Innocent surfer test button - If your ip number is not yet listed in the ip.txt 
   file it will return the same thing an actual formmail version 1.6 would return. 
   If you ip number is listed in the ip.txt file, it will return the 404.php error 
   file. Note: You will need to refresh the index.php file so it can read the 
   ip.txt file.
   
4. One Recipient Test button - Ensure you ip number is not listed below the Clean ip.txt 
   file button. Then click "One Recipient Test" button, the script will send will send one 
   e-mail to your testing e-mail address  It will then write your IP number into the 
   ip.txt file and send another e-mail to the for your record address listed in the 
   config.php file. The first time this is done the script returns an actual formmail page
   with the information that it has sent. If you ip number is listed in the ip.txt file, it 
   will return the 404.php error file.
   
5. Mulitiple Recipient Test button - This button sends a complaint to the recipient listed 
   for the tests and also a copy to your record address listed in the config.php file. You 
   will need to use this button to see the modifications you make to the complaint section. 
   If the abuse e-mail address is not listed at Spamcop.net, then the script will return a 
   warning that their attempt has been recorded and that a complaint will be sent to thier 
   IP block owner. You will have to complete this manually, you will know that no abuse address
   is available if your record gives a blank for the "Abuse address listed at SpamCop.net:"
   
6. Clean ip.txt File button- To complete some tests you will need to ensure your IP number is not
   listed in the ip.txt file, with this button you will be able to erase it and start fresh with
   a new one. If you want to retrieve all the IP number listed for your records, you will have to
   download it before pressing this button.
   
7. Modify Complaint Letter button - This is where you can make changes to how your complaint to
   the abuse department will look. Use the legend to the right for variables you can use in the 
   complaint.



 

------------------------------
Post Installation after testing:
------------------------------

 Add the following lines to httpd.conf file:

# Global Alias for entire server. 
Alias /cgi-bin/formmail.pl /path/to/formmail.php
Alias /cgi-bin/formmail.cgi /path/to/formmail.php


or placed between <VirtualHost> tags for a specific domain.

<VirtualHost> 
Alias /cgi-bin/formmail.pl /path/to/formmail.php
Alias /cgi-bin/formmail.cgi /path/to/formmail.php
</VirtualHost>

Then restart httpd service for example:
/etc/rc.d/init.d/httpd restart

// You may use any spelling variation and or path changes you can think of i.e.
// Alias /cgi-bin/FormMail.cgi /path/to/formmail.php
// Alias /cgibin/formmail.pl /path/to/formmail.php
// Alias /cgi-local/Formmail.pl /path/to/formmail.php
// Special Thanks to Bob Smith Oak Ridge, TN for these suggestions.


   
