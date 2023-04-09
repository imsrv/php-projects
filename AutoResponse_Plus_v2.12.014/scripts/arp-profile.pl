##################################################
##                                              ##
##             AUTORESPONSE PLUS (tm)           ##
##       Sequential Autoresponder System        ##
##                Version 2.12                  ##
##                                              ##
##   Copyright Gobots Internet Solutions, 2001  ##
##             All rights reserved              ##
##                                              ##
##  For support and latest product information  ##
##    visit http://www.autoresponseplus.com.    ##
##                                              ##
##  Use of AutoResponse Plus is subject to our  ##
##   license agreement and limited warranty.    ##
##  See the file license.txt for more details.  ##
##                                              ##
##################################################

sub Profile {
    my(%fm);
    $fm{"name"} = $INFO{"o"};
    $fm{"password"} = $INFO{"p"};

    if (! &ValidateOwner(%fm)) {
        &Redirect("$g_thisscript?a0=log");
    } # if

    if ($g_a1 eq "pro") {
        $fm{"new_name"} = &Trim($FORM{"new_name"});
        $fm{"new_password"} = &Trim($FORM{"new_password"});
        $fm{"confirm_new_password"} = &Trim($FORM{"confirm_new_password"});
        $fm{"affiliate_nickname"} = &Trim($FORM{"affiliate_nickname"});
        $fm{"email"} = &Trim(lc($FORM{"email"}));
        $fm{"my_title"} = &Trim($FORM{"my_title"});
        $fm{"my_firstname"} = &Trim($FORM{"my_firstname"});
        $fm{"my_lastname"} = &Trim($FORM{"my_lastname"});
        $fm{"my_fullname"} = &Trim($FORM{"my_fullname"});
        $fm{"my_position"} = &Trim($FORM{"my_position"});
        $fm{"my_company"} = &Trim($FORM{"my_company"});
        $fm{"my_address1"} = &Trim($FORM{"my_address1"});
        $fm{"my_address2"} = &Trim($FORM{"my_address2"});
        $fm{"my_address3"} = &Trim($FORM{"my_address3"});
        $fm{"my_address4"} = &Trim($FORM{"my_address4"});
        $fm{"my_address5"} = &Trim($FORM{"my_address5"});
        $fm{"my_phone1"} = &Trim($FORM{"my_phone1"});
        $fm{"my_phone2"} = &Trim($FORM{"my_phone2"});
        $fm{"my_fax1"} = &Trim($FORM{"my_fax1"});
        $fm{"my_fax2"} = &Trim($FORM{"my_fax2"});
        $fm{"my_email1"} = &Trim($FORM{"my_email1"});
        $fm{"my_email2"} = &Trim($FORM{"my_email2"});
        $fm{"my_email3"} = &Trim($FORM{"my_email3"});
        $fm{"my_email4"} = &Trim($FORM{"my_email4"});
        $fm{"my_email5"} = &Trim($FORM{"my_email5"});
        $fm{"my_web1"} = &Trim($FORM{"my_web1"});
        $fm{"my_web2"} = &Trim($FORM{"my_web2"});
        $fm{"my_web3"} = &Trim($FORM{"my_web3"});
        $fm{"my_web4"} = &Trim($FORM{"my_web4"});
        $fm{"my_web5"} = &Trim($FORM{"my_web5"});
        $fm{"my_misc1"} = &Trim($FORM{"my_misc1"});
        $fm{"my_misc2"} = &Trim($FORM{"my_misc2"});
        $fm{"my_misc3"} = &Trim($FORM{"my_misc3"});
        $fm{"my_misc4"} = &Trim($FORM{"my_misc4"});
        $fm{"my_misc5"} = &Trim($FORM{"my_misc5"});
        $g_message = &validate_EditProfile(%fm);
        if (! $g_message) {
            my(%profile) = &data_Load("OWN00000000");
            $profile{"name"} = $fm{"new_name"};
            $profile{"password"} = $fm{"new_password"};
            $profile{"affiliate_nickname"} = $fm{"affiliate_nickname"};
            $profile{"email"} = $fm{"email"};
            $profile{"my_title"} = $fm{"my_title"};
            $profile{"my_firstname"} = $fm{"my_firstname"};
            $profile{"my_lastname"} = $fm{"my_lastname"};
            $profile{"my_fullname"} = $fm{"my_fullname"};
            $profile{"my_position"} = $fm{"my_position"};
            $profile{"my_company"} = $fm{"my_company"};
            $profile{"my_address1"} = $fm{"my_address1"};
            $profile{"my_address2"} = $fm{"my_address2"};
            $profile{"my_address3"} = $fm{"my_address3"};
            $profile{"my_address4"} = $fm{"my_address4"};
            $profile{"my_address5"} = $fm{"my_address5"};
            $profile{"my_phone1"} = $fm{"my_phone1"};
            $profile{"my_phone2"} = $fm{"my_phone2"};
            $profile{"my_fax1"} = $fm{"my_fax1"};
            $profile{"my_fax2"} = $fm{"my_fax2"};
            $profile{"my_email1"} = $fm{"my_email1"};
            $profile{"my_email2"} = $fm{"my_email2"};
            $profile{"my_email3"} = $fm{"my_email3"};
            $profile{"my_email4"} = $fm{"my_email4"};
            $profile{"my_email5"} = $fm{"my_email5"};
            $profile{"my_web1"} = $fm{"my_web1"};
            $profile{"my_web2"} = $fm{"my_web2"};
            $profile{"my_web3"} = $fm{"my_web3"};
            $profile{"my_web4"} = $fm{"my_web4"};
            $profile{"my_web5"} = $fm{"my_web5"};
            $profile{"my_misc1"} = $fm{"my_misc1"};
            $profile{"my_misc2"} = $fm{"my_misc2"};
            $profile{"my_misc3"} = $fm{"my_misc3"};
            $profile{"my_misc4"} = $fm{"my_misc4"};
            $profile{"my_misc5"} = $fm{"my_misc5"};
            &data_Save(%profile);
            if (&GetCookie("remember") eq "ON") {
                $cookie = &SetCookie("name", $fm{"new_name"}, $g_settings{'cookie_life'});
                print $cookie;
                $cookie = &SetCookie("password", $fm{"new_password"}, $g_settings{'cookie_life'});
                print $cookie;
                $cookie = &SetCookie("remember", "ON", $g_settings{'cookie_life'});
                print $cookie;
            } # if
            $cookie = &SetCookie("sessionname", $fm{"new_name"}, 0);
            print $cookie;
            $cookie = &SetCookie("sessionpassword", $fm{"new_password"}, 0);
            print $cookie;
            &Redirect("$g_thisscript?a0=pro");
        } # if
    } # if
    else {
        my(%profile) = &data_Load("OWN00000000");
        $fm{"new_name"} = $profile{"name"};
        $fm{"new_password"} = $profile{"password"};
        $fm{"confirm_new_password"} = $profile{"password"};
        $fm{"affiliate_nickname"} = $profile{"affiliate_nickname"};
        $fm{"email"} = $profile{"email"};
        $fm{"my_title"} = $profile{"my_title"};
        $fm{"my_firstname"} = $profile{"my_firstname"};
        $fm{"my_lastname"} = $profile{"my_lastname"};
        $fm{"my_fullname"} = $profile{"my_fullname"};
        $fm{"my_position"} = $profile{"my_position"};
        $fm{"my_company"} = $profile{"my_company"};
        $fm{"my_address1"} = $profile{"my_address1"};
        $fm{"my_address2"} = $profile{"my_address2"};
        $fm{"my_address3"} = $profile{"my_address3"};
        $fm{"my_address4"} = $profile{"my_address4"};
        $fm{"my_address5"} = $profile{"my_address5"};
        $fm{"my_phone1"} = $profile{"my_phone1"};
        $fm{"my_phone2"} = $profile{"my_phone2"};
        $fm{"my_fax1"} = $profile{"my_fax1"};
        $fm{"my_fax2"} = $profile{"my_fax2"};
        $fm{"my_email1"} = $profile{"my_email1"};
        $fm{"my_email2"} = $profile{"my_email2"};
        $fm{"my_email3"} = $profile{"my_email3"};
        $fm{"my_email4"} = $profile{"my_email4"};
        $fm{"my_email5"} = $profile{"my_email5"};
        $fm{"my_web1"} = $profile{"my_web1"};
        $fm{"my_web2"} = $profile{"my_web2"};
        $fm{"my_web3"} = $profile{"my_web3"};
        $fm{"my_web4"} = $profile{"my_web4"};
        $fm{"my_web5"} = $profile{"my_web5"};
        $fm{"my_misc1"} = $profile{"my_misc1"};
        $fm{"my_misc2"} = $profile{"my_misc2"};
        $fm{"my_misc3"} = $profile{"my_misc3"};
        $fm{"my_misc4"} = $profile{"my_misc4"};
        $fm{"my_misc5"} = $profile{"my_misc5"};
    } # else

    &EditProfilePage(%fm);
} # sub Profile

sub EditProfilePage {
    my(%fm) = @_;

    &PageHeading;
    &PageHeader("h_profile.htm");
    &PageSubHeader("Your Profile", "");

    &Spacer("1", "5");

    &OpenForm("form", "$g_thisscript?a0=pro&a1=pro");

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Owner name</b><br>5-40 letters or numbers</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='new_name' size='$size' maxlength='40' value='$fm{'new_name'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Password</b><br>5-40 letters or numbers</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='password' name='new_password' size='$size' maxlength='40' value='$fm{'new_password'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Confirm password</b><br>5-40 letters or numbers</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='password' name='confirm_new_password' size='$size' maxlength='40' value='$fm{'confirm_new_password'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Your e-mail address</b><br>For sending you system messages</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='email' size='$size' value='$fm{'email'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Affiliate nickname</b><br>5-10 letters or numbers</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='affiliate_nickname' size='$size' maxlength='10' value='$fm{'affiliate_nickname'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formtablesubheading' colspan='2' valign='middle' align='center'><b>My Record</b><br>Include these in your messages using the tags shown</td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Title</b><br>{MY_TITLE}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_title' size='$size' value='$fm{'my_title'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>First name</b><br>{MY_FIRSTNAME}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_firstname' size='$size' value='$fm{'my_firstname'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Last name</b><br>{MY_LASTNAME}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_lastname' size='$size' value='$fm{'my_lastname'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Full name</b><br>{MY_FULLNAME}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_fullname' size='$size' value='$fm{'my_fullname'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Position</b><br>{MY_POSITION}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_position' size='$size' value='$fm{'my_position'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Company</b><br>{MY_COMPANY}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_company' size='$size' value='$fm{'my_company'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Address 1</b><br>{MY_ADDRESS1}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_address1' size='$size' value='$fm{'my_address1'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Address 2</b><br>{MY_ADDRESS2}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_address2' size='$size' value='$fm{'my_address2'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Address 3</b><br>{MY_ADDRESS3}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_address3' size='$size' value='$fm{'my_address3'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Address 4</b><br>{MY_ADDRESS4}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_address4' size='$size' value='$fm{'my_address4'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Address 5</b><br>{MY_ADDRESS5}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_address5' size='$size' value='$fm{'my_address5'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Phone 1</b><br>{MY_PHONE1}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_phone1' size='$size' value='$fm{'my_phone1'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Phone 2</b><br>{MY_PHONE2}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_phone2' size='$size' value='$fm{'my_phone2'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Fax 1</b><br>{MY_FAX1}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_fax1' size='$size' value='$fm{'my_fax1'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Fax 2</b><br>{MY_FAX2}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_fax2' size='$size' value='$fm{'my_fax2'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>E-mail address 1</b><br>{MY_EMAIL1}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_email1' size='$size' value='$fm{'my_email1'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>E-mail address 2</b><br>{MY_EMAIL2}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_email2' size='$size' value='$fm{'my_email2'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>E-mail address 3</b><br>{MY_EMAIL3}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_email3' size='$size' value='$fm{'my_email3'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>E-mail address 4</b><br>{MY_EMAIL4}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_email4' size='$size' value='$fm{'my_email4'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>E-mail address 5</b><br>{MY_EMAIL5}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_email5' size='$size' value='$fm{'my_email5'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Web address 1</b><br>{MY_WEB1}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_web1' size='$size' value='$fm{'my_web1'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Web address 2</b><br>{MY_WEB2}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_web2' size='$size' value='$fm{'my_web2'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Web address 3</b><br>{MY_WEB3}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_web3' size='$size' value='$fm{'my_web3'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Web address 4</b><br>{MY_WEB4}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_web4' size='$size' value='$fm{'my_web4'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Web address 5</b><br>{MY_WEB5}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_web5' size='$size' value='$fm{'my_web5'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Miscellaneous 1</b><br>{MY_MISC1}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_misc1' size='$size' value='$fm{'my_misc1'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Miscellaneous 2</b><br>{MY_MISC2}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_misc2' size='$size' value='$fm{'my_misc2'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Miscellaneous 3</b><br>{MY_MISC3}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_misc3' size='$size' value='$fm{'my_misc3'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Miscellaneous 4</b><br>{MY_MISC4}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_misc4' size='$size' value='$fm{'my_misc4'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Miscellaneous 5</b><br>{MY_MISC5}</td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='my_misc5' size='$size' value='$fm{'my_misc5'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Save Changes  '> <input type='reset' value='  Reset Values  '></td>\n";
    print "</tr>\n";

    &CloseForm;

    &PageCloser("form.new_name");
} # sub EditProfilePage

return 1;
