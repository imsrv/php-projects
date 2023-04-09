<?php
/*------------------------------------\
| AvidNews Version 1.00               |
| News/article management system      |
+-------------------------------------+
| CONFIG.PHP - The script's config    |
| library to determine how it runs    |
+-------------------------------------+
| (C) Copyright 2003 Avid New Media   |
| Consult README for further details  |
+------------------------------------*/

# Database settings

$CONF["sitename"]        =      "The Name of your site"; # Database host

$CONF["domain"]        =      "http://yourdomain.com/news"; # this can also be a subdomain (whereve AvidNews will be)

$CONF["dbhost"]        =      "localhost"; # Database host

$CONF["dbuser"]        =      "db username"; # Database username

$CONF["dbpass"]        =      "db password";   # Database password

$CONF["dbname"]        =      "db name"; # Database name

$CONF["table_prefix"]  =      "";          # Please leave this blank

# Script settings

$CONF["limit_type"]    =      "number";    # Limit type, either number or date

$CONF["limit"]         =       "3";        # Either a number or a date (mm/dd/yyyy)

$CONF["image_upload_dir"] = "./images/";   # Image upload directory, including trailing slash
?>