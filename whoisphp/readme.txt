****************************************************************************
This script was developed by Aero77.com .
Title: WhoisPHP
Version: 1.2
Homepage: www.Aero77.com
Copyright (c) 2004 Aero77.com and its owners.
All rights reserved.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
"AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
REGENTS OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED
OF THE POSSIBILITY OF SUCH DAMAGE.

USAGE:
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

More Info About The Licence At http://www.gnu.org/copyleft/gpl.html
****************************************************************************


The zip file contains several files as follows.

whoisphp.php contains the phpwhois function and support functions. You should include this in your pages.
checkdomain.php demo page that checks a freely entered domain name.
checkdomain2.php demo page that checks a domain name with a drop down list of any extensions you wish to accept.
checkdomain3.php demo page that uses checkboxes to check several domains simultaneously. (also requires whois.php)
lookup.php demo page that displays the domain name registration information.
whois.php is used with checkdomain3.php to show registration details.

Sample useage

Using WhoisPHP couldn't be easier. Just include the whoisphp.php file in your page. Here is a sample php call:-

include"whoisphp.php";
$allowed="";
$result=whoisphp($domain, $extension, $details);

$domain contains the domain to lookup such as yourdomain.com.
$extension optionally contains the domain extension such as .com if not included in $domain
$details is used to receive the returned registration details for the domain owner.
$result contains the functions return status:-
0=Domain is not registered and therefore should be available for registration.
1=Domain is registered. $details contains the registration details.
2=Domain extension not recognised or supported.
3=Domain name is not valid.
4=Referer is not allowed to use function. You can set this if required to control use.
5=Could not contact registry to lookup domain.
6=Domain is available at a premium (currently supported for .tv, .fm & .dj). Last line of $details should contain offered price.
Ther $allowed variable can be set to ensure that the call can only be made from a known server.
e.g.

$allowed="softlok.com";

You can set $allowed="" to disable this security check.

Please note that if you change the filename for any of the demo pages you must rename
all occurences of it in the script to match.

Domains that are supported by whoisphp such as .my, .gr, .es, .sa, .tv, .fm and .dj have no official whois server and we
therefore try to get the details via the registrars website whois service. This may result in loss of service if they make changes
or block access. For this reason you should regularly check that your installation of whoisphp is working and report any problems
to us.

If you are just checking availability and do not require the full whois details then you can speed up the function call with
some domain extensions by setting $details="*"; before calling whoisphp.

If you have any questions please email us.

support@aero77.com.com
