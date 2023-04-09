<div id="footer" class="small"> This site is using <a href="http://phpgraphy.sourceforge.net/">phpGraphy</a>
<?
 echo PHPGRAPHY_VERSION;
 if ($timegen) { ?> - Page generated in 
<?
  $timenow=gettimeofday();
  $gen=$timegen["sec"]+($timegen["usec"]/1000000);
  $now=$timenow["sec"]+($timenow["usec"]/1000000);
  echo substr(($now-$gen),0,5);
?>
s. 
<? } ?>
</div>
</div>
</body>
</html>
