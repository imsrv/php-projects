<?php

// what to say when the resultes return the domain is open and ready to be bought? 

$open_domain = <<<ENDH
Congratulations! <font color="black"> {$HTTP_POST_VARS["domain"]}.{$HTTP_POST_VARS["extensions"]}</font> 
Is Available, Get It Fast Before Someone Else Does. 						
ENDH;


// what to say when the resultes return the domain is already in use?

$closed_domain = <<<ENDH
Sorry! <font color="black">{$HTTP_POST_VARS["domain"]}.{$HTTP_POST_VARS["extensions"]}</font> Is Not Available.

<br>

<small>
	<a href="#" onclick="openW('stats.php?domain={$HTTP_POST_VARS['domain']}&extension={$HTTP_POST_VARS['extensions']}')" style="color:orange; text-decoration:underline; font-family:verdana;font-size:8pt;"><b>View Whois Information</b></a>
</small>
ENDH;
?>