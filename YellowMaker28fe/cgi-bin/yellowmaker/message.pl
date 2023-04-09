########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# message.pl
########################################################################

sub letterofsignup {
$msgtxt =<<letterofsignup;
Dear Valued Member,

Thank you for registering $website!

Your E-mail Address: $form{'formemailaddress'}
Your Password: $form{'formpassword'}
Your Activation Code: $code


Best Regards,
$company


-----------------------------------------------------------
* From:: IP: $ipaddr | Date & Time: $date
* Powered by YellowMaker: http://www.yellowmaker.com


letterofsignup
}


sub letterofsignup2 {
$msgtxt2 =<<letterofsignup2;
Dear Valued Member,

Welcome to $website!

Your E-mail Address: $form{'formemailaddress'}
Your Password: $form{'formpassword'}
Your Activation Code: $code

To activate your Membership Account, please click:-
$homecgi/member.pl

****************************************************************
Note: this is not a spam email. This email was sent to you 
because your email was entered in on a website requesting 
to be a registered member.
****************************************************************
This application was submitted by the remote address from 
$ipaddr on $date.

Important Note:
This member account must be activated within 2 weeks.


Best Regards,
$company


-----------------------------------------------------------
* From:: IP: $ipaddr | Date & Time: $date
* Powered by YellowMaker: http://www.yellowmaker.com


letterofsignup2
}


sub letterofsignup3 {
$msgtxt3 =<<letterofsignup3;
This e-mail notification from $website Member Registration System.

Member's E-mail Address: $form{'formemailaddress'}


-----------------------------------------------------------
* From:: IP: $ipaddr | Date & Time: $date
* Powered by YellowMaker: http://www.yellowmaker.com


letterofsignup3
}


sub letterofactivate {
$msgtxt =<<letterofactivate;
Dear Valued Member,

Thank you for choosing our services.

Your membership account has been activated. Now you can list
your organization/business to $title.

Please click the URL shown below to member center:-
$homecgi/member.pl


Best Regards,
$company


-----------------------------------------------------------
* From:: IP: $ipaddr | Date & Time: $date
* Powered by YellowMaker: http://www.yellowmaker.com


letterofactivate
}


sub letterofactivate2 {
$msgtxt2 =<<letterofactivate2;
This e-mail notification from $website Member Registration System.

E-mail Address: $emailaddress


-----------------------------------------------------------
* From:: IP: $ipaddr | Date & Time: $date
* Powered by YellowMaker: http://www.yellowmaker.com


letterofactivate2
}


sub letterofcode {
$msgtxt =<<letterofcode;
Dear Valued Member,

Your E-mail Address: $emailaddress
Your Password: $password
Your Activation Code: $code


Best Regards,
$company


-----------------------------------------------------------
* From:: IP: $ipaddr | Date & Time: $date
* Powered by YellowMaker: http://www.yellowmaker.com


letterofcode
}


sub letterofpassword {
$msgtxt =<<letterofpassword;
Dear Valued Member,

Your E-mail Address: $form{'formemailaddress'}
Your Password: $pwd
Your Activation Code: $code


Best Regards,
$company


-----------------------------------------------------------
* From:: IP: $ipaddr | Date & Time: $date
* Powered by YellowMaker: http://www.yellowmaker.com


letterofpassword
}


sub letterofaccount {
$msgtxt =<<letterofaccount;
Dear Valued Member,

Your E-mail Address: $emailaddress
Your Password: $form{'newpassword'}
Your Activation Code: $form{'newcode'}


Best Regards,
$company


-----------------------------------------------------------
* From:: IP: $ipaddr | Date & Time: $date
* Powered by YellowMaker: http://www.yellowmaker.com


letterofaccount
}


sub letterofaccount2 {
$msgtxt =<<letterofaccount2;
Dear Valued Member,

New E-mail Address: $form{'newemailaddress'}
Initial Code: $emailcode

Please click the address below to activate your above new 
e-mail address:-
$homecgi/member.pl


Best Regards,
$company


-----------------------------------------------------------
* From:: IP: $ipaddr | Date & Time: $date
* Powered by YellowMaker: http://www.yellowmaker.com


letterofaccount2
}


sub letterofadd {
$msgtxt =<<letterofadd;
Dear $form{'name'},

Welcome to $title!
$slogan

This is an automatic reply from $website to acknowledge that your 
profile has been successfully added to $title. Your organization
details shown below:-

Your Organization Profile ID:$count
------------------------------------------------------------
 1. Category: $form{'category'}
 2. Organization Name: $form{'name'}
 3. Established in: $form{'establish'}
 4. Address 1: $form{'address1'}
 5. Address 2: $form{'address2'}
 6. City: $form{'city'}
 7. State: $form{'state'}
 8. Zip Code: $form{'zipcode'}
 9. Country: $form{'country'}
10. Phone Number: $form{'phone'}
11. Fax Number: $form{'fax'}
12. E-mail Address: $form{'companyemailaddress'}
13. Web site: $form{'homepage'}

<<Description>>
$form{'describe'}


Best Regards,
$company


-----------------------------------------------------------
* From:: IP: $ipaddr | Date & Time: $date
* Powered by YellowMaker: http://www.yellowmaker.com


letterofadd
}


sub letterofadd2 {
$msgtxt2 =<<letterofadd2;
This e-mail notification from $title.

New Member Profile ID:$count
------------------------------------------------------------
 1. Category: $form{'category'}
 2. Organization Name: $form{'name'}
 3. Established in: $form{'establish'}
 4. Address 1: $form{'address1'}
 5. Address 2: $form{'address2'}
 6. City: $form{'city'}
 7. State: $form{'state'}
 8. Zip Code: $form{'zipcode'}
 9. Country: $form{'country'}
10. Phone Number: $form{'phone'}
11. Fax Number: $form{'fax'}
12. E-mail Address: $form{'companyemailaddress'}
13. Web site: $form{'homepage'}

<<Description>>
$form{'describe'}


-----------------------------------------------------------
* From:: IP: $ipaddr | Date & Time: $date
* Powered by YellowMaker: http://www.yellowmaker.com


letterofadd2
}


sub letterofadminemail {
$msgtxt =<<letterofadminemail;
$content


-----------------------------------------------------------
* From:: IP: $ipaddr | Date & Time: $date
* Powered by YellowMaker: http://www.yellowmaker.com


letterofadminemail
}


sub letterofadminemailall {
$msgtxt =<<letterofadminemailall;
$content


-----------------------------------------------------------
* From:: IP: $ipaddr | Date & Time: $date
* Powered by YellowMaker: http://www.yellowmaker.com


letterofadminemailall
}



sub letterofremove {
$msgtxt =<<letterofremove;

Your membership account has been removed as your request!

E-mail Address: $emailaddress


-----------------------------------------------------------
* From:: IP: $ipaddr | Date & Time: $date
* Powered by YellowMaker: http://www.yellowmaker.com


letterofremove
}


sub letterofremove2 {
$msgtxt2 =<<letterofremove2;

E-mail Address: $emailaddress


-----------------------------------------------------------
* From:: IP: $ipaddr | Date & Time: $date
* Powered by YellowMaker: http://www.yellowmaker.com


letterofremove2
}


sub letteroftell {
$msgtxt =<<letteroftell;

Hi,

Our registered member: $emailaddress is inviting you 
to visit our web site ($title):-

$url

Thank you!


-----------------------------------------------------------
* From:: IP: $ipaddr | Date & Time: $date


letteroftell
}


sub letterofcontact {
$msgtxt =<<letterofcontact;

-----------------------------------------------------------
Sender: $yourname
Company: $yourcompany
E-mail Address: $youremailaddress
IP-Address: $ipaddr
Date & Time: $date
-----------------------------------------------------------

Subject: $subject

<< Message >>

$content


-----------------------------------------------------------
-----------------------------------------------------------


letterofcontact
}


sub letterofcontactus {
$msgtxt =<<letterofcontactus;

-----------------------------------------------------------
E-mail Address: $emailaddress
IP-Address: $ipaddr
Date & Time: $date
-----------------------------------------------------------

Topic: $topic
Subject: $subject

<< Message >>

$content


-----------------------------------------------------------
-----------------------------------------------------------


letterofcontactus
}




1;
