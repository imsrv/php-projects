// convert all characters to lowercase to simplify testing
var agt = navigator.userAgent.toLowerCase();

// BROWSER VERSION:
// Note: On IE5, these return 4, so use is.ie5up to detect IE5.
var is_major = parseInt(navigator.appVersion);
var is_minor = parseFloat(navigator.appVersion);

// Netscape Navigator
var is_nav = ((agt.indexOf('mozilla') != -1) && (agt.indexOf('spoofer') == -1)
             && (agt.indexOf('compatible') == -1) && (agt.indexOf('opera') == -1)
             && (agt.indexOf('webtv') == -1));
var is_nav2 = (is_nav && (is_major == 2));
var is_nav3 = (is_nav && (is_major == 3));
var is_nav4 = (is_nav && (is_major == 4));
var is_nav4up = (is_nav && (is_major >= 4));
var is_navonly = (is_nav && ((agt.indexOf(";nav") != -1) ||
                 (agt.indexOf("; nav") != -1)) );
var is_nav5 = (is_nav && (is_major == 5));
var is_nav5up = (is_nav && (is_major >= 5));

// Internet Explorer
var is_ie = (agt.indexOf("msie") != -1);
var is_ie3 = (is_ie && (is_major < 4));
var is_ie4 = (is_ie && (is_major == 4) && (agt.indexOf("msie 5.0") == -1));
var is_ie4up = (is_ie  && (is_major >= 4));
var is_ie5 = (is_ie && (is_major == 4) && (agt.indexOf("msie 5.0") != -1));
var is_ie5up = (is_ie && !is_ie3 && !is_ie4);

// AOL
var is_aol = (agt.indexOf("aol") != -1);
var is_aol3 = (is_aol && is_ie3);
var is_aol4 = (is_aol && is_ie4);

// Opera and WebTV
var is_opera = (agt.indexOf("opera") != -1);
var is_webtv = (agt.indexOf("webtv") != -1);

// JAVASCRIPT VERSION:
// Useful to workaround Nav3 bug in which Nav3
// loads <SCRIPT LANGUAGE="JavaScript1.2">.
var is_js;
if(is_nav2 || is_ie3) is_js = 1.0
else if(is_nav3 || is_opera) is_js = 1.1
else if((is_nav4 && (is_minor <= 4.05)) || is_ie4) is_js = 1.2
else if((is_nav4 && (is_minor > 4.05)) || is_ie5) is_js = 1.3
else if(is_nav5) is_js = 1.4
// NOTE: In the future, update this code when newer versions of JS
// are released. For now, we try to provide some upward compatibility
// so that future versions of Nav and IE will show they are at
// *least* JS 1.x capable. Always check for JS version compatibility
// with > or >=.
else if(is_nav && (is_major > 5)) is_js = 1.4
else if(is_ie && (is_major > 5)) is_js = 1.3
// HACK: no idea for other browsers; always check for JS version with > or >=
else is_js = 0.0;

// ok here we go
if(is_nav2 || is_nav3) {
   alert("Your Netscape is < 3.0, now redirecting you to download the recent version.");
   self.location.href = "http://home.netscape.com/computing/download/index.html";
}
if(is_ie3) {
   alert("Your Internet Explorer is < 3.0, now redirecting you to download the recent version.");
   self.location.href = "http://www.microsoft.com/ie";
}

