--------------------------------------------------------------
|Custom Contact Form version 1                               |
|(c)Mike Mason 2005                                          |
|For more scripts or assistance go to the forums at          |
| www.mikemason.org                                          |
|You may use this program only if the copyright & Authors    |
|Link remains intact. If it is not, it is a breach of your   |
|License                                                     |
--------------------------------------------------------------
Purpose
  This script has be created so it will be easy for anyone
  to create a custom contact email form for their site.
  You will find with a few modifications you can have dozens of 
  fields for the visitor to fill in or just one. Enjoy!
  
How to use
-Change the headers and footers of customcontact.php & contactprocess.php
 to suit your site (optional)
 
-Make the changes to these lines of the code:
--customcontact.php (lines 18-22)
  change the words Question # & Optional Text to your liking & 
  add or remove questions to suitBe sure to change the "name=" 
  value to the next higher #, & add to "contactprocess.php" (lines 31-43)
  example:
  Question 1: <input type="text" name="text1" value="Optional Text" size="15" maxlength="20"><br>
  Phone: <input type="text" name="text1" value="(xxx)xxx-xxxx" size="15" maxlength="20"><br>

--contactprocess.php
  (line 24) change to your email address
  (lines 31-35) add or remove to suit, example of next line: $text6 = stripslashes($text6);
  (lines 38-43) change the email you will receive to suit, example:
    Phone: $text1
    Address: $text2
    City: $text3
    State: $text4
    Zip: $text5
    Message: $message
  (line 52 + 58) as is visitor must fill in email, name, subject & message
    change to:
     line 52-($email&&$subject&&$name&&$emailcorrect)
     line 58-(!$email||!$subject||!$name)
     if you don't want to require a message
    
- upload to your site & add link to your site
  Tip: Here's a link that will popup your form in a small window
  <A HREF="http://www.YourSite.com/customcontact.php" onclick="window.open('http://www.YourSite.com/customcontact.php','popup','width=480,height=600,scrollbars=yes,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0'); return false">Contact Me</A>

-Your server needs php and the php mail function enabled.

-For more information or help go to the forums at www.mikemason.org

License

-To use this script, you have to keep the copyright notice & authors link intact. 

-You may distribute this program as long as it's NOT for Profit.


PS- a link to my site would be greatly appreciated:
<A HREF="http://www.mikemason.org"> Web Hosting and Free Website Design Forum - $2.49 mo. Web Hosting - Free Templates, Help Forum and Downloads. Domains for sale.</a>
