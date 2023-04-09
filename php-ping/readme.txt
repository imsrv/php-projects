PHP-Ping Readme.

Contents of the zip-package:

readme.txt - this one
php-ping.php - the php-script

Installation:
Drop it into a directory, and call it. You will need execute-rights for this file.

What for?:
The idea about this script was born when I needed to verify basic TCP/IP connection of some servers
from another location then the location they were on. Being on the same network and "pinging" a box 
is no magic. But are you really visible from the outside ? This one, installed at your little webserver 
at home or in another location will tell you.

I also saw people using it to check if a game-server is up, or to check that their firewall is really 
blocking ICMP packages. 

Can I change it?:
Sure, just sent me back the changed script and let's share your bright ideas (I doubt that there is 
much to add on, it's a simple script...).

It doesn't work, the error messages talks about a "fork?!?". 
Great. There are two possible causes. First, you use it on *nix and it is set to "win". Edit the script
check the $os variable.

Second, your webserver or php itself doesn't allow the execution of system command out of the script. Well,
if you own the server, you can change this in the php.ini or in the webserver settings. If you don't own 
the server, it's bad. The script needs to call "system" to do the ping. Not much I can do...or you, other 
than changing provider....or just use the demo at www.theworldsend.net whenever you need a "ping".

Support ??!
Hello, this isn't a complicated script. More likley you will have a problem with your PHP installation or
webserver, but not with the script itself...but if you really want to, write me or post your questions 
at my little forum (http://www.theworldsend.net) and webmaster@theworldsend.net

Enjoy and share,
webmaster@theworldsend.net



