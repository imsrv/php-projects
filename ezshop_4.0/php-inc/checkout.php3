<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
?>
	<h3 align="center">Thank you for placing an order with us!</h3>
    <p>This server is capable of Secure Transactions via SSL 3.0 with up to 128bit encryption.</p>
    <p>If you are using a relatively new browser which supports this security protocol, select the Secure Checkout button.</p>
	<center><p align="center"><form method="<? print($method) ?>" action="<? print($secure_url) ?>"><? EchoFormVars();?><input type="Hidden" name="secure" value="Yes"><input type="Hidden" name="checkout" value="True"><input type="submit" name="action" value="Secure Checkout"></form></center>
	<P><font color="Red">Important instructions for Netscape 3 and Internet Explorer 3 Users!</font> This server uses a Thawte Web Server certificate.  Just as this server's certificate is only valid for a year, Thawte's root certificates are only valid for a while.  The root certificates that we shipped with Navigator 3.x and MSIE 3.01 were valid from 1996 till 1998.  The roots we ship with newer browsers, including all 4.0 browsers and later, are valid from 1996 till 2020.  This means that people running 3.x generation browsers can upgrade their security to the same level as that supported by 4.0 generation browsers just by replacing the Thawte root in their older browser with the same root as is shipped with the newer browser.  The process takes about 2 minutes and ensures that your browser works with the tens of thousands of Thawte certified secure servers out there, well into the next century:</p>
	<p>To upgrade your Thawte Root Certificate, <a href="http://www.thawte.com/certs/server/rollover.html" target="_blank" name="Thawte Site">Click Here.</a></p>
    <p>If you are using a browser which is not capable of using the security provided by this server, select Unsecure Checkout.</p>
	<center><form method="<? print($method) ?>" action="<? print($unsecure_url) ?>"><? EchoFormVars();?><input type="Hidden" name="secure" value="No"><input type="Hidden" name="checkout" value="True"><input type="submit" name="action" value="Unsecure Checkout"></form></p></center>
    <p>In both cases, once you have completed filling out the order information, you may either submit the order On-Line, or use the alternative order methods of Fax or Telephone.</p>
