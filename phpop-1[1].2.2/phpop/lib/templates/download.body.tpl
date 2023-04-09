<!-- $Id: download.body.tpl,v 1.1.1.1 1999/10/24 22:45:03 prenagha Exp $ -->
<p><strong>phpop</strong> was written to solve a very simple problem for me - How do I send and receive e-mail when all I have is a web browser. Hotmail like services would work, but I don't like the footer they append to each message. Something like IMAP using <a href="http://web.horde.org/imp/">IMP</a> or <a href="http://screwdriver.net/twig/">TWIG</a> would work, but I couldn't figure out how to handle mutliple IMAP accounts with my single user ID at my domain host. I was therefore forced to use POP access. My answer is <strong>phpop</strong>.<br>
It ain't fancy cause it ain't intended to be.
<p>What can phpop do:
<ul>
  <li>Read mail from POP server
  <li>Reply to mail
  <li>Forward mail
  <li>Delete mail
  <li>Send new messages
</ul>
<p><strong>phpop</strong> is written as a 
<a href="http://www.php.net/">PHP</a> application utilizing a
<a href="http://www.mysql.net/">MySQL</a> database on an
<a href="http://www.apache.org/">Apache</a> web server.

<p><strong>current version 0.2 released 07/08/1999</strong>.<br>
See history of <a href="CHANGES">CHANGES</a>.<br>
Download the latest source package <a href="phpop-0.2.tar.gz">here</a>.<br>
The PHP class library used for phpop is <strong>PHPLIB</strong>. Get <strong>PHPLIB</strong> <a href="http://phplib.netuse.de">here</a>.

<p><a href="../bookmarker/maillist.php3">Announcement and Discussion Mailing Lists</a>

<p>The POP3, Validator, and FastTemplate classes used in this application are courtesy of <a href="http://www.thewebmasters.net/php/">The Webmasters Net</a>.
