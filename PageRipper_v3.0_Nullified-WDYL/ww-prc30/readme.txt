PageRipper v3.0 - Commercial Edition
===========================================
http://www.pageripper.com


Included Files

PageRipper.cgi
Readme.txt
Check.cgi - freeware server variable checker


Thank you for purchasing PageRipper v3.0.  PageRipper allows you to
fetch and use HTML from other web sites directly on your site.  You
simply supply the URL and the starting and ending points to start fetching
in minutes.  

This copyrighted script is not to be duplicated or sold without written permission
from ACDesigns or PageRipper.Com.  Violators will be prosecuted, and fined
accordingly.  Damages may also be personally levied against anyone violating
this rule.

Before installing PageRipper v3.0 be sure to read the Disclaimer
at the bottom of this file.  


======== Getting Started - PageRipper v3.0

Installation is simple and straight forward.

First make sure that the path to your PERL interpreter (first line of script) is
correct.  On most servers #!/usr/bin/perl or #!/usr/local/bin/perl
should work.  If your not sure ask your System Administrator for more help.  

There are three variables that need to be defined in order for the 
script to work.  I'll quickly go through each one to get you started.
=====================================================================
1.  You must define the URL to get.

It appears as: 
$url = '';

Example: $url = 'http://www.anydomain.com/';

Simply point this variable to the page you want content from.

=====================================================================
2.  You must define the starting HTML point.  A good starting point is to use <HTML> and </HTML> as your starting and ending points.  Then you can narrow down the HTML to the specific portion you need.

$start = '<br>blah blah blah</p><a/>';


=====================================================================
3.  You must define the ending HTML Point.
It appears as:

$finish = '<br>blah blah blah</p><a/>';

=====================================================================



DONE!  Your now ready to upload PageRipper v3.0 to you CGI Directory.  Usually called cgi-bin or cgi-local.  Don't forget to Set Permission or CHMOD to at least 755.

Now call the script from any browser such as Internet Explorer or Netscape.  It should
display the fetched HTML. 


If your fetched HTML contains links or photos and they don't appear correctly, work your way
down the script to the sections labelled "Image Grabber" and "Links Grabber"  Replace the 
www.blahblahblah.com with whatever the new URL is.  This must be done for images and links to
work that were not directly linked on the Source page.  

Important: Another way to correct broken images or links is to use the <BASE HREF="http://www.theirserver.com/"> in the Header portion of the SSI page.  This must be placed before the </HEAD> tag.


=====================================================================
Executing PageRipper v3.0


To call the script from your page using SSI you use the HTML code
<!--#exec cgi="/cgi-bin/pageripper.cgi"-->

Some servers require you to change the page name from test.html to test.shtml for SSI to work.

Well that's it.  Upload and Happy Ripping!


Included Files

PageRipper.cgi
Readme.txt
Check.cgi - freeware server variable checker

=====================================================================

Be sure to visit our FAQ section at http://www.pageripper.com/faq.htm
for more information regarding the requirments and installation of
PageRipper v3.0.

Thank you,

PageRipper Staff




===========Disclaimer, and Terms of Sale for PageRipper v3.0

All of our software is covered by this disclaimer: While ACDesigns &
PageRipper.Com make every effort to deliver high quality products, we 
do not guarantee that our products are free from defects. Our software
is provided as is," and you use the software at your own risk. We 
make no warranties as to performance, merchantability, fitness for 
a particular purpose, or any other warranties whether expressed or 
implied.

No oral or written communication from or information provided by
ACDesigns & PageRipper.Com shall create a warranty.

Under no circumstances shall ACDesigns & PageRipper.Com be liable for
direct, indirect, special, incidental, or consequential damages 
resulting from the use, misuse, or inability to use this software, 
even if ACDesigns & PageRipper.com has been advised of the possibility 
of such damages. 


PageRipper v3.0
http://www.pageripper.com
