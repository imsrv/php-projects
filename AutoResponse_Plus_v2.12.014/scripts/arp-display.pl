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

sub PageHeading {
    my($date) = &LongDate(0);

    print "Content-type: text/html\n\n";
    print "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>\n";
    print "<html>\n";
    print "<head>\n";
    print "<meta http-equiv='Content-Type' content='text/html; charset=ISO-8859-1'>\n";
    print "<meta name='description' content='Sequential Autoresponder System'>\n";
    print "<meta name='keywords' content='autoresponder software'>\n";
    print "<title>\n";
    print "</title>\n";
    print "<link rel='stylesheet' href='/arplus/arpstyles.css'>\n";
    print "<script language='JavaScript' type='text/javascript'>\n";
    print "<!-- Begin\n";
    print "function WindowPopup() {\n";
    print "window.open('','help','toolbar=yes,location=no,directories=no,status=no,menubar=no,resizable=yes,copyhistory=no,scrollbars=yes,width=550,height=400');\n";
    print "}\n";
    print "//-->\n";
    print "</script>\n";
    print "<script language='JavaScript' type='text/javascript'>\n";
    print "<!-- Begin\n";
    print "function SelectField(field) {\n";
    print "full_field = eval('document.'  + field);\n";
    print "full_field.select();\n";
    print "full_field.focus();\n";
    print "}\n";
    print "//-->\n";
    print "</script>\n";

    if ($g_settings{'tooltips'}) {
        print "<script language='JavaScript' type='text/javascript'>\n";
        print "<!-- Begin\n";
    	print "function ShowTooltip(fArg)\n";
    	print "{\n";
		print "var tooltipOBJ = eval(\"document.all['tt\" + fArg + \"']\");\n";
		print "var tooltipOffsetTop = tooltipOBJ.scrollHeight + 35;\n";
		print "var testTop = (document.body.scrollTop + event.clientY) - tooltipOffsetTop;\n";
		print "var testLeft = event.clientX - 310;\n";
		print "var tooltipAbsLft = (testLeft < 0) ? 10 : testLeft;\n";
		print "var tooltipAbsTop = (testTop < document.body.scrollTop) ? document.body.scrollTop + 10 : testTop;\n";
		print "tooltipOBJ.style.posLeft = tooltipAbsLft; tooltipOBJ.style.posTop = tooltipAbsTop;\n";
		print "tooltipOBJ.style.visibility = \"visible\";\n";
		print "}\n";
		print "function HideTooltip(fArg)\n";
		print "{\n";
		print "var tooltipOBJ = eval(\"document.all['tt\" + fArg + \"']\");\n";
		print "tooltipOBJ.style.visibility = \"hidden\";\n";
		print "}\n";
        print "//-->\n";
	    print "</script>\n";
    } # if
    else {
        print "<script language='JavaScript' type='text/javascript'>\n";
        print "<!-- Begin\n";
    	print "function ShowTooltip(fArg)\n";
    	print "{\n";
		print "}\n";
		print "function HideTooltip(fArg)\n";
    	print "{\n";
		print "}\n";
        print "//-->\n";
	    print "</script>\n";
    } # else

    print "</head>\n";
    print "<body bgcolor='#FFFFFF' topmargin='0' leftmargin='0' rightmargin='0' marginwidth='0' marginheight='0'>\n";

	print "<div class='classTooltip' ID='tt1'>\n";
    print "Click here to create a new autoresponder.\n";
	print "</div>\n";
	print "<div class='classTooltip' ID='tt2'>\n";
	print "Click here to return to your list of autoresponders.\n";
	print "</div>\n";
	print "<div class='classTooltip' ID='tt3'>\n";
	print "Click here to add a new message to the follow-up sequence for this autoresponder.\n";
	print "</div>\n";
	print "<div class='classTooltip' ID='tt4'>\n";
	print "Click here to edit the properties of this autoresponder.\n";
	print "</div>\n";
	print "<div class='classTooltip' ID='tt5'>\n";
	print "Click here to edit the common page layout for all follow-up messages in this autoresponder.\n";
	print "</div>\n";
	print "<div class='classTooltip' ID='tt6'>\n";
	print "Click here to generate the subscription code needed for web pages, mailto links etc.\n";
	print "</div>\n";
	print "<div class='classTooltip' ID='tt7'>\n";
	print "Click here to return to the follow-up message list for this autoresponder.\n";
	print "</div>\n";
	print "<div class='classTooltip' ID='tt8'>\n";
	print "Click here to see a list of every available dynamic content tag. These allow you to create personalised messages and time-sensitive offers.\n";
	print "</div>\n";
	print "<div class='classTooltip' ID='tt9'>\n";
	print "Click here to create a new tracking tag. These are used to track the source of your subscribers.\n";
	print "</div>\n";
	print "<div class='classTooltip' ID='tt10'>\n";
	print "Click here to return to your list of tracking tags.\n";
	print "</div>\n";
	print "<div class='classTooltip' ID='tt11'>\n";
	print "Click here to perform a system test of the AutoResponse Plus e-mail engine.\n";
	print "</div>\n";
	print "<div class='classTooltip' ID='tt12'>\n";
	print "Click here to perform a system test of the AutoResponse Plus e-mail capture system. Every e-mail sent to your domain needs to be scanned by AutoResponse Plus. This test ensures that this is working correctly.\n";
	print "</div>\n";
	print "<div class='classTooltip' ID='tt13'>\n";
	print "Click here to return to the main system setup screen.\n";
	print "</div>\n";
	print "<div class='classTooltip' ID='tt14'>\n";
	print "Click here to return to your list of subscribers.\n";
	print "</div>\n";
	print "<div class='classTooltip' ID='tt15'>\n";
	print "Click here to filter your subscriber list by autoresponder, tracking tag, status, date or duplicate entries.\n";
	print "</div>\n";
	print "<div class='classTooltip' ID='tt16'>\n";
	print "Click here to clear the any active filter and return to viewing your full list of subscribers.\n";
	print "</div>\n";
	print "<div class='classTooltip' ID='tt17'>\n";
	print "Click here to change the status of all subscribers that match the current filter.\n";
	print "</div>\n";
	print "<div class='classTooltip' ID='tt18'>\n";
	print "Click here to manually add a new subscriber to one of your follow-up sequences.\n";
	print "</div>\n";
	print "<div class='classTooltip' ID='tt19'>\n";
	print "Click here to upload and import a batch of subscribers. The import file must be in comma separated variable (CSV) format.\n";
	print "</div>\n";
	print "<div class='classTooltip' ID='tt20'>\n";
	print "Click here to export all subscribers that match the current filter. The exported file will be in comma separated variable (CSV) format.\n";
	print "</div>\n";
	print "<div class='classTooltip' ID='tt21'>\n";
	print "Click here to send a one-off plain text or HTML e-mail to all subscribers that match the current filter.\n";
	print "</div>\n";
	print "<div class='classTooltip' ID='tt22'>\n";
	print "Click here to delete all subscribers that match the current filter. Deleted subscribers cannot be retrieved.\n";
	print "</div>\n";

    print "<table width='100%' cellspacing='0' cellpadding='3' border='0'>\n";
    print "<tr>\n";
    print "<td class='darkbluecell'>\n";
    print "<img src='$_images_url_path/logo.gif' width='350' height='60' alt='AutoResponse Plus'>";
    print "</td>\n";
    print "<td class='datecell' valign='bottom' align='right'>\n";
    print "$date\n";
    print "</td>\n";
    print "</tr>\n";

    if (! &ValidateSetup) {
        print "<tr>\n";
        print "<td class='redcell' colspan='2' align='center'>\n";
        print "&raquo; System setup is not complete -- click the Setup option after logging in &laquo;\n";
        print "</td>\n";
        print "</tr>\n";
    } # if

    print "</table>\n";
} # sub PageHeading

sub PageHeader {
    my($help) = @_;

    my(%profile) = &data_Load("OWN00000000");

    print "<table width='100%' height='20' cellspacing='0' cellpadding='3' border='0'>\n";
    print "<tr>\n";
    print "<td class='headerlink' valign='middle' align='center'>\n";
    print "<a class='headerlink' href='$g_thisscript?a0=aut'>Autoresponders</a>\n";
    print "</td>\n";
    print "<td class='headerlink' valign='middle' align='center'>\n";
    print "<a class='headerlink' href='$g_thisscript?a0=cam'>Subscribers</a>\n";
    print "</td>\n";
    print "<td class='headerlink' valign='middle' align='center'>\n";
    print "<a class='headerlink' href='$g_thisscript?a0=tra'>Tracking Tags</a>\n";
    print "</td>\n";
    print "<td class='headerlink' valign='middle' align='center'>\n";
    print "<a class='headerlink' href='$g_thisscript?a0=pro'>Your Profile</a>\n";
    print "</td>\n";
    print "<td class='headerlink' valign='middle' align='center'>\n";
    print "<a class='headerlink' href='$g_thisscript?a0=set'>Setup</a>\n";
    print "</td>\n";
    print "<td class='headerlink' valign='middle' align='center'>\n";
    if ($profile{"affiliate_nickname"}) {
        print "<a class='headerlink' href='$_affiliate_link?$profile{'affiliate_nickname'}' target='_blank'>Affiliates</a>\n";
    } # if
    else {
        print "<a class='headerlink' href='$_affiliate_link' target='_blank'>Affiliates</a>\n";
    } # else
    print "</td>\n";
    print "<td class='headerlink' valign='middle' align='center'>\n";
    print "<a class='headerlink' href='$g_thisscript?a0=log'>Logout</a>\n";
    print "</td>\n";
    print "<td class='headerlink' valign='middle' align='center'>\n";
    print "<a class='headerlink' href='$_help_url_path/$help' target='help' onclick='Javascript:WindowPopup();'>Help</a>\n";
    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";
} # sub PageHeader

sub PageSubHeader {
    my($locator, $subheader) = @_;

    print "<table width='100%' height='20' cellspacing='0' cellpadding='3' border='0'>\n";
    print "<tr>\n";
    print "<td class='locatorcell'>\n";
    print "$locator\n";
    print "</td>\n";
    print "<td class='subheaderlink' align='right'>\n";
    print "$subheader\n";
    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";
} # sub PageSubHeader

sub PageCloser {
    my($selectfield) = @_;

    print "<table width='100%' cellspacing='0' cellpadding='0' border='0'>\n";
    print "<tr>\n";
    print "<td valign='middle' align='center'>\n";
    print "Copyright Gobots Internet Solutions, 2001. All rights reserved.<br>\n";
    print "AutoResponse Plus Version $_version [<a href='$_upgrade_history_link' target='_blank'>Upgrade History</a>]<br>\n";
    print "<a class='standardlink' href='$_forums_link' target='_blank'>Click here to visit the AutoResponse Plus user community</a>\n";
    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";

    if ($g_settings{"show_news"}) {
        &Spacer('1', '30');
        print "<div align='center'><center>\n";
        print "<table width='468' cellspacing='0' cellpadding='0' border='0'>\n";
        print "<tr>\n";
        print "<td><a href='$_news_link' target='_blank'><img src='$_news_banner' width='468' height='60' border='0' alt='AutoResponse Plus News'></a></td>\n";
        print "</tr>\n";
        print "</table>\n";
        print "</center>\n";
        print "</div>\n";
        &Spacer('1', '30');
    } # if

    if (! $g_message) {
        $g_message = $INFO{"m"};
    } # if

    $g_message =~s/_/ /g;
    if ($g_message) {
        print "<script language='Javascript' type='text/javascript'>\n";
        print "<!--\n";
        print "alert('$g_message')\n";
        print "// -->\n";
        print "</script>\n";

        $g_message = "";
    } # if

    if ($selectfield ne '') {
        print "<script language='Javascript' type='text/javascript'>\n";
        print "<!--\n";
        print "SelectField('$selectfield');\n";
        print "// -->\n";
        print "</script>\n";
    } # if

    print "</body>\n";
    print "</html>";
} #sub PageCloser

sub ListTableHeading {
    my($heading) = @_;

    print "<div align='center'>\n";
    print "<center>\n";
    print "<table width='98%' cellspacing='0' cellpadding='6' border='0'>\n";
    print "<tr>\n";
    print "<td class='listtableheading'>\n";
    print "$heading\n";
    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";
    print "</center>\n";
    print "</div>\n";
} # sub ListTableHeading

sub OpenListTable {
    print "<div align='center'>\n";
    print "<center>\n";
    print "<table width='98%' cellspacing='0' cellpadding='0' border='0'>\n";
    print "<tr>\n";
    print "<td class='listtablebackground'>\n";

    print "<table width='100%' cellspacing='1' cellpadding='6' border='0'>\n";
} # sub OpenListTable

sub CloseListTable {
    print "</table>\n";

    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";
    print "</center>\n";
    print "</div>\n";
} # sub CloseListTable

sub FilterListTableSubHeading {
    my($heading) = @_;

    print "<div align='center'>\n";
    print "<center>\n";
    print "<table width='98%' cellspacing='0' cellpadding='6' border='0'>\n";
    print "<tr>\n";
    print "<td class='filterlistrightheading'>\n";
    print "$heading\n";
    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";
    print "</center>\n";
    print "</div>\n";
} # sub FilterListTableSubHeading

sub InfoHeading {
    my($data) = @_;

    print "<div align='center'>\n";
    print "<center>\n";
    print "<table width='98%' cellspacing='0' cellpadding='6' border='0'>\n";
    print "<tr>\n";
    print "<td class='listtableheading'>\n";
    print "$data\n";
    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";
    print "</center>\n";
    print "</div>\n";
} # sub InfoHeading

sub InfoBox {
    my($data) = @_;

    print "<div align='center'>\n";
    print "<center>\n";
    print "<table width='98%' cellspacing='0' cellpadding='6' border='0'>\n";
    print "<tr>\n";
    print "<td class='filterlistrightheading'>\n";
    print "$data\n";
    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";
    print "</center>\n";
    print "</div>\n";
} # sub InfoBox

sub OpenImportForm {
    my($name, $action) = @_;

    print "<form method='POST' name='$name' action='$action' enctype='multipart/form-data'>\n";
    print "<div align='center'>\n";
    print "<center>\n";
    print "<table width='70%' cellspacing='0' cellpadding='0' border='0'>\n";
    print "<tr>\n";
    print "<td class='formtablebackground'>\n";

    print "<table width='100%' cellspacing='1' cellpadding='6' border='0'>\n";
} # sub OpenImportForm

sub OpenForm {
    my($name, $action) = @_;

    print "<form method='POST' name='$name' action='$action'>\n";
    print "<div align='center'>\n";
    print "<center>\n";
    print "<table width='70%' cellspacing='0' cellpadding='0' border='0'>\n";
    print "<tr>\n";
    print "<td class='formtablebackground'>\n";

    print "<table width='100%' cellspacing='1' cellpadding='6' border='0'>\n";
} # sub OpenForm

sub CloseForm {
    print "</table>\n";

    print "</td>\n";
    print "</tr>\n";
    print "</table>\n";
    print "</center>\n";
    print "</div>\n";
    print "</form>\n";
} # sub CloseForm

sub Spacer {
    my($width, $height) = @_;

    print "<table border='0' cellpadding='0' cellspacing='0' width='$width' height='$height'>\n";
    print "<tr>\n";
    print "<td><img src='$_images_url_path/spacerdot.gif' width='$width' height='$height' alt=''></td>\n";
    print "</tr>\n";
    print "</table>\n";
} # sub Spacer

sub FieldSize {
    my($size) = @_;

    my($result) = $size;

    if (! &IsExplorer($g_browser)) {
        $result = int($result * $_form_ratio);
    } # if

    return $result;
} # sub FieldSize

sub PrintLn {
    my($text) = @_;
    print "$text\n";
} # sub PrintLn

return 1;
