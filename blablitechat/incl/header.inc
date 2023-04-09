<?php 
print "<?xml version=\"1.1\" encoding=\"$lang[1]\"?>";
if(!isset($frameset)){
print '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';}
else{print '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">';}
print "\n<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"$lang[2]\">\n";
print "<head><title>$lang[0]</title>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=$lang[1]\" />\n";
print "<link rel=\"stylesheet\" type=\"text/css\" href=\"$skin_dir/style.css\" />\n";
print "<script type=\"text/javascript\">skin_dir='$skin_dir';use_rnd=$no_cache</script>\n";
print "<script type=\"text/javascript\" src=\"incl/all.js\"></script>\n";
?>