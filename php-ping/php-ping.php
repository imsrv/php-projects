<?php
//  This script was writen by webmaster@theworldsend.net, Aug. 2001
//  http://www.theworldsend.net 
//  This is my first script. Enjoy.
//  
// Put it into whatever directory and call it. That's all.
//
//-------------------------
$max_count = "10"; //maximum count for ping command
$os = "win";   // win or unix (unix means all flavors of linux as well)
// -------------------------
//
// nothing more to be done. 
If ($submit =="Ping!") {
  If ($count > $max_count) 
  {
     echo 'Maximum for count is '.$max_count;
     echo '<a href="php-ping.php">Back</a>';
     $again = True;
  }
  else 
  {
     If (ereg(" ",$host))  
     {
          echo 'No Space in Host field allowed !';
          echo '<a href="php-ping.php">Back</a>';
          $again= True;
     }
     else 
     {
          echo("Ping Output:<br>"); 
          echo("<pre>");
          $host = escapeshellarg($host); 
          $count = escapeshellarg($count);
          if ($os =="win") 
          {
             system("ping -n $count $host", $list);
          }
          else
          {
             system("ping -t $count $host", $list);
          }; 
          echo("</pre>");
      }
   }
} 
else 
{
  echo '
  <html><body>
  <form methode="post" action="php-ping.php">
  Enter IP or Host <input type="text" name="host"></input>
  Enter Count <input type="text" name="count" size="2" value="4"></input>
  <input type="submit" name="submit" value="Ping!"></input>
  </form>
  </body></html>';
}
?>	
