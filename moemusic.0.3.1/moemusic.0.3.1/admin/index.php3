<?
include moe_conf;


print "<SCRIPT LANGUAGE=\"JavaScript\">\n";
print "var wrong=\"../index.php3\";\n";
print "var pass=\"$admin_password\";\n";
print "var name = prompt(\"Enter the password\",\"Type in the Password\");\n";
print "var right=\"admin.php3\";\n";
print "if (name == pass) {\n";
print "        (confirm(\"Access Granted!\"))\n";
print "  location.href=right;\n";
print "   }\n";
print "else{  alert(\"Wrong Password!\");\n";
print "   location.href=wrong;\n";
print "  }\n";
print "</SCRIPT>\n";
?>
