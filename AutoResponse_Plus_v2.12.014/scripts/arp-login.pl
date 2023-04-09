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

sub Login {
    my(%fm);
    my($cookie);

    $cookie = &SetCookie("sessionname", "", 0);
    print $cookie;

    $cookie = &SetCookie("sessionpassword", "", 0);
    print $cookie;

    if ($g_a1 eq "pro") {
        $fm{"name"} = &Trim($FORM{"name"});
        $fm{"password"} = &Trim($FORM{"password"});
        $fm{"remember"} = $FORM{"remember"};

        if (&ValidLogin(%fm)) {
            if ($fm{"remember"} eq "ON") {
                $cookie = &SetCookie("name", $fm{"name"}, $g_settings{"cookie_life"});
                print $cookie;
                $cookie = &SetCookie("password", $fm{"password"}, $g_settings{"cookie_life"});
                print $cookie;
                $cookie = &SetCookie("remember", "ON", $g_settings{"cookie_life"});
                print $cookie;
            } # if
            else {
                $cookie = &RemoveCookie("name");
                print $cookie;
                $cookie = &RemoveCookie("password");
                print $cookie;
                $cookie = &RemoveCookie("remember");
                print $cookie;
            } # else

            $cookie = &SetCookie("sessionname", $fm{"name"}, 0);
            print $cookie;
            $cookie = &SetCookie("sessionpassword", $fm{"password"}, 0);
            print $cookie;

            &Redirect("$g_thisscript?a0=aut");
            exit;
        } # if
        else {
            $g_message = "Your name or password are incorrect";
        } # else
    } # if

    &PageHeading;
    &PageSubHeader("Login", "");

    &Spacer("1", "5");

    &OpenForm("form", "$g_thisscript?a0=log&a1=pro");

    if (! $fm{"name"}) {
        $fm{"name"} = &GetCookie("name");
    } # if

    if (! $fm{"password"}) {
        $fm{"password"} = &GetCookie("password");
    } # if

    $fm{"remember"} = &GetCookie("remember");

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Owner name</b></td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='text' name='name' size='$size' value='$fm{'name'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Password</b></td>\n";
    $size = &FieldSize(20);
    print "<td class='formcell' width='50%' valign='middle'><input type='password' name='password' size='$size' value='$fm{'password'}'></td>\n";
    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formcell' width='50%' valign='middle' align='right'><b>Remember next time?</b></td>\n";
    if ($fm{"remember"} eq 'ON') {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='remember' value='ON' checked></td>\n";
    } # if
    else {
        print "<td class='formcell' width='50%' valign='middle'><input type='checkbox' name='remember' value='ON'></td>\n";
    } # else

    print "</tr>\n";

    print "<tr>\n";
    print "<td class='formbuttoncell' colspan='2' valign='middle' align='center'><input type='submit' value='  Login  '></td>\n";
    print "</tr>\n";

    &CloseForm;

    &Spacer("1", "5");

    &PageCloser ('form.name');
} # sub Login

sub ValidLogin {
    my(%fm) = @_;
    my(%owner) = &data_Load("OWN00000000");
    my($result) = 0;

    if (($owner{"name"} eq $fm{"name"}) and ($owner{"password"} eq $fm{"password"})) {
        $result = 1;
    } # if

    return $result;
} # sub ValidLogin

return 1;
