<html>
<head>
        <meta name="author" content="Paolo Ardoino">
        <meta name="copyright" content="2004 Paolo Ardoino under the terms of the GFDL">
        <meta name="keywords" content="Paolo 
Ardoino,Paolo,Ardoino,php,google,pagerank,rank,page,links,pr,increase,visits,unique,visitors,translate,translation,bot,googlebot,yahoo,translator,language,tools,main,native,search,engine,engines,surfer">
        <meta name="description" content="Paolo Ardoino's Home Page">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
<font size="2"><a href="http://ardoino.altervista.org"><b>Back to Home</b></a></font><br /><br />
<center><font size="5"><b>PHP WEBSITE TRANSLATOR</b></font></center><br />
<center><font size="5"><b>Increase visitors using not perfect translations</b></font><br />
<font size="2"><b>by <a href="http://ardoino.altervista.org" target="_blank">Paolo Ardoino</a> [ paolo.ardoino@gmail.com ]</b></font></center><br /><br />
<font size="4"><b>Disclaimer</b></font><br />
To the maximum extent permitted by law, the author disclaims all warranties and responsabilities regarding this software.<br />
In no event shall the author be liable for direct, indirect, special, consequential, incidental, punitive or any other kind of damages caused by or arising out of the use or inability to use this software even if he is aware of the possibility of such damages or a known defect.<br />
This software is provided without any warranty, and if you use it you do it at your own risk, with no support.<br />
No advice or information, whether oral or written, which you obtain from the author or through the material or third parties shall create any warranty not expressly made herein.<br />
By accessing or using this software, you are agreeing to these terms.<br />
<br /><br />
<font size="4"><b>Download Php Website Translator</b>&nbsp;&nbsp;<a href="http://ardoino.altervista.org/webmaster/phpwt/phpwt-0.1.tar.gz"><b>[ tar.gz ]</b></a>&nbsp;&nbsp;-&nbsp;&nbsp;<a href="http://ardoino.altervista.org/webmaster/phpwt/phpwt-0.1.zip"><b>[ .zip ]</b></a></font><br /><br />
<font size="4"><b>The idea</b></font><br />
<b>NOTE</b> : in this article I use Google language tools , but you could use Babel Fish or other 
translation resources . <br />
<ul><li>Languages supported by <b>Google language tools</b> : English , Spanish , German , French , Japanese , Portuguese , Italian .</li>
<li>Your website's main ( native ) language is one of the above , so only search queries performed in that 
language will bring users to your pages.</li>
<li>Surfers could understand also other languages than their native's one or than the one used in search queries, but for facility and habit they use the one they mostly undestand .</li>
</ul>
The goal of <b>php website translator</b> is to allow <b>search engine users</b> to find your
website between the results of <b>search engine queries</b> made in a language different from the one 
used in your pages . Using this tool you'll increase also the number of keywords related to your website .<br />
<b>php website translator</b> uses Google language tools to translate your pages in all supported 
languages.
Obviously resulting translations are not perfect, often wrong, so it's not good to show them to users but these could be used to feed search engine bots and to get more visitors each day.<br />
The <b>idea</b> is to create a link on the home page of your website to a <b>tree of translated pages</b> 
and to show it only to search engine bots. 
A search engine bot will find in that page X more links to translated 
trees ( where X is the number of languages supported by Google language tools ) and it will spider the 
true tree ( in the main ( native ) language ) , the translated trees and adds them to search results ; in
other words you give new keywords to the search engine increasing the chance that someone finds your 
website .<br />
When a real surfer finds a link of one of your translated pages in search engine results and tries to
reach it , his browser will be redirected ( by php website translator ) to the corresponding page in the 
main language .<br />
<br />
Translated pages will be saved in a mysql database, using a table for each language. The structure of a
language table is ('id', 'url', 'source'), where 'url' is the url of the real page ( the one in the 
website's main language )  and 'source' is the html of the translated page . 
To create a working translated tree  php website translator rewrites '&lt;a' html tags ( all internal links ) and make them pointing to the correct translated page .
<br />
Example of how could look your home page for a real surfer and a search engine bot :
<pre>
----- index.php ( for surfer using Firefox ) ------
|   Links:          |       Home page             |
|   Forums          | .......................     |
|   Blog            | .......................     |
|   ContactMe       |                             | 
---------------------------------------------------

----- index.php ( for search engine bots   ) ------
|   Links:          |       Home page             |
|   Forums          | .......................     |
|   Blog            | .......................     |
|   ContactMe       |                             | 
|   ENGLISH         |                             | 
|   SPANISH         |                             | 
|   ITALIAN         |                             | 
|   GERMAN          |                             | 
|   JAPANESE        |                             | 
|   FRENCH          |                             | 
|   PORTUGUESE      |                             | 
---------------------------------------------------
</pre>
Each link ( ENGLISH , SPANISH , ITALIAN , GERMAN , JAPANESE , FRENCH , PORTUGUESE ) is structured as follows : 
lang.php?lang=en&idlink=1 , lang.php?lang=de&idlink=1 , lang.php?lang=it&idlink=1 , lang.php?lang=sp&idlink=1 <br />
idlink=1 is the home of the translated tree ( the value of idlink corresponds to the 'id' table field ).<br />
Now clicking on lang.php?lang=it&idlink=1 your home page translated in Italian will appear . As you can 
see all links ( those internal to your website ) are like this : lang.php?lang=it&idlink=L ( where L is 
the id of the link in the mysql table ).
<br /><br />
<b>NOTE</b> : each time your website changes heavily you need to rebuild translated trees.<br /><br />
<font size="4"><b>How to create translated tree</b></font><br /><br />
<b>You need</b> :
<ul>
<li>PHP >= 4.3 with Curl support</li>
<li>Mysql >= 4.0</li>
<li>Apache</li>
</ul>
<b>php website translator supports translations from a language different from English 
to all other languages supported by Google only on websites hosted by servers that allows outgoing php connections .<br />
Instead for English websites there are no problems , so you can also create the translated trees 
on your local machine and then upload them on your website's mysql database .</b><br />
The reason is that Google supports translations from English to all languages and from all languages to 
English, but it doesn't support all to all translations. 
In other words you cannot directly translate from Italian to French, 
but you have to translate the page from Italian to English and then from English to French .<br />
So, if your website's main language is not English, php website translator needs to translate all pages
from the native language to English and it saves results in a mysql database . Then to perform translations
from English to other languages it asks Google to read pages from the database .
<br /><br />
<ul>
<li><b>Your hosting webserver allows outgoing connections</b> ( php website translator needs ): 
<ul>
<li>Upload php website translator directory on your website.</li>
<li>Edit configuration file config.php setting your database connection informations:
<pre>
$mysqlhost = "localhost"; // mysql host
$mysqluser = "root"; // mysql user
$mysqlpass = ""; // mysql password
$mysqldb = "translator"; // database
$baseurl = "http://www.yourwebsitehome.org"; // home page of your website ( without ending '/' character )
$scripturl = "http://www.yourwebsitehome/translator"; // php website translator url ( without ending '/' character )
</pre>
</li>
<li>Install php website translator tables opening install.php with your browser ( http://www.yourwebsitehome.org/translator/install.php ).</li>
<li>Open in your browser translator.php ( http://www.yourwebsitehome.org/translator/translator.php ), 
select the main ( native ) language of your website and the file containing the list of all the pages you 
want to translate ( it should be your sitemap ).
The file needs to be formatted with one url for each line and the first url must be the home page.
Example:
<pre>
------ urls.txt ------
http://www.yourwebsitehome.com/index.php
http://www.yourwebsitehome.com/forum.php
http://www.yourwebsitehome.com/guest/gb.php
----------------------
</pre></li>
<li>Pressing translate button, if everything is correct, php website translator will start to translate 
pages of the sitemap in all languages supported by Google and then it will check and rebuild link trees.
</li>
<li>Add this php code to your home page. This will show only to search engine bots the links to the 
translated trees. If you want to show them also to real surfers or if you want to have a look to 
translated trees set $visible = TRUE; in config.php file.
<pre>
&lt;?php include("translator/displaylinks.php"); ?&gt;
</pre>
</li>
</ul>
</li>
<li><b>Your hosting webserver doesn't allow outgoing connections and your website's main language is not English</b>: wait for next version</li>
</ul>
<br /><br />
Excuse me for my poor english
<br />
For any information , question , doubt please write me an email <a href="mailto:paolo.ardoino@gmail.com">paolo dot ardoino at gmail dot com</a>
</body>
</html>
