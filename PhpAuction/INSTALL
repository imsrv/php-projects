phpAdsNew

#########################################################
#                                                       #
# This script was provided by:                          #
#                                                       #
# PHPSelect Web Development Division.                   #
# http://www.phpselect.com/                             #
#                                                       #
# This script and all included modules, lists or        #
# images, documentation are © 2004                      #
# PHPSelect (http://www.phpselect.com/) unless          #
# otherwise stated in the script.                       #
#                                                       #
# Purchasers are granted rights to use this script      #
# on any site they own. There is no individual site     #
# license needed per site.                              #
#                                                       #
# Any copying, distribution, modification with          #
# intent to distribute as new code will result          #
# in immediate loss of your rights to use this          #
# program as well as possible legal action.             #
#                                                       #
# This and many other fine scripts are available at     #
# the above website or by emailing the authors at       #
# admin@phpselect.com or info@phpselect.com             #
#                                                       #
#########################################################



- Installation

  Quick Install :
    [1] Untar the distribution (be sure to untar the subdirectories)
        tar xvf phpAdsNew_x.x.x.tar
    [2] Open the file config.inc.php in your favourite editor and change
        the values to fit your environment.
    [3] Create the database you'll use for phpAdsNew (default name:
        "phpads"). Within this database, create the required tables as
        provided in all.sql. You can use the mysql-client for this:
        mysql <db-name> < all.sql
        or you can use phpMyAdmin <http://phpwizard.net/phpMyAdmin> to read
        in the dump.
    [4] Point your browser to 
        <www.your-host.com>/<your-install-dir>/admin/index.php
        and create a new client. Add a banner for that client.
    [5] To send automatically a weekly email to your clients with statistics,
        add a job to your crontab to parse the file mail.php:
        59 23 * * * fetch -o - http://www.profi.it/phpAdsNew/mail.php>>/var/log/messages
        The example uses fetch, you can also use wget or lynx -dump.

  Installation notes (replace PHP3 with PHP if you're using PHP4) :
  + PHP must be configured to have magic_quotes_gpc=on and 
    magic_quotes_runtime=off. In the module version of PHP3 this can also be set
    on a per-directory base with php3_magic_quotes_gpc on in an .htaccess file 
    or in your Apache's access.conf.
  + If you have the module version of PHP3, your .htaccess could look like this:
    php3_magic_quotes_runtime off
    php3_magic_quotes_gpc on
  + Keep in mind that in the current version you have to include the files 
    "config.inc.php", "view.inc.php" and "acl.inc.php" on every page you
    want to have a banner.
    
