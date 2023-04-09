# ==================================================================
# Acc subscribe - create own subscriptions with easy
#
#   Website  : http://www.hotcgiscripts.com/
#   Support  : http://www.hotcgiscripts.com/?c=contact-us
#   Revision : $Id: README,v 1.4 2003/04/18 13:18:38 Exp $
# 
# Copyright (c) 2002-2003 HotCGIScripts.  All Rights Reserved.
# Redistribution in part or in whole strictly prohibited.
# ==================================================================
#
# COPYRIGHT NOTICE:
#
# Copyright 2002-2003 HotCGIScripts. All Rights Reserved.
#
# HotCGIScripts hereby grants you a single, non-exclusive, non-transferable
# license to use one copy of the SOFTWARE PRODUCT in accordance with the 
# terms and conditions of the EULA.  Any rights not expressly granted are
# reserved.  This license authorizes you to install and use a single copy of
# the SOFTWARE PRODUCT on a single server for usage on a single web site.
# If you install additional copies, even if such additional copies are
# located on the same web site and/or the same server, such usage is
# prohibited unless additional licenses are purchased.
#
# By using this program, you agree to HotCGIScripts user license agreement.
#                                                                
# For any questions on the licensing agreement, please contact
# HotCGIScripts via contact@hotcgiscripts.com
#
# =====================================================================

Welcome to Acc Subscribe v1.4!

TABLE OF CONTENTS

    1. Welcome
        1.1 About the Script
        1.2 System Requirements
    2. Installation
    3. Support

1. Welcome
=========================================================================

1.1 About the Script
-------------------------------------------------------------------------
Acc Subscribe v1.4 is an intelligent website mailing software suitable 
for any website that allows you to manage and automate your 
newsletters, customers mailing lists, back-end sale offers etc. 
With simple and tight integration, you will quickly see an increase 
in your site's traffic and revenue with an effective campaign 
through opt-in subscriptions. It combines powerful marketing and 
relationship tools with advanced personalization and tracking. And 
it can be easily integrated into your site - You can use any form 
you like to subscribe users on your mailing lists. Unlimited 
mailing lists can be created, scheduled newsletter, 
no timeouts - all critical tasks run in background. Supports 
unlimited number of attaches of any types, unlimited templates, 
no size limit, possibility to personalize emails for each user, 
advanced export and import feature. Easy form creator wizard.

For the full list of features, and details, please visit:

http://www.hotcgiscripts.com/?c=acc-subscribe

1.2 System Requirements
-------------------------------------------------------------------------
1. Perl 5.005 or higher.
2. UNIX based server.
3. CGI Access.
4. crontab (for schedule feature)
5. MySQL Database

2. Installation
=========================================================================
Acc Subscribe installation is very straight forward.

To install, please follow the following steps:

1. Step 1. Setup perl path.
  You can skip this step if the path to perl on your system is /usr/bin/perl
  Open admin.cgi, crontab.pl, install.cgi, subscribe.cgi in a text editor.
  The absolute first line of these files should read #!/usr/bin/perl .
  Change this to #! and then the path to perl. For example, if the path to 
  perl is /blah/directory/perl, you'd make the 
  first line #!/blah/directory/perl .


2. Step 2. Copy files to your server
  First of all, whenever uploading any perl script, use ASCII. This is 
  because if you upload as binary, it screws up the line breaks. 
  Upload all the files to a directory where you can run CGI. All of these 
  files *must* be in the same directory.
  Set the permissions for *.cgi and *.pl to 755 (rwx-rx-rx).


3. Step 3. - Install acc subscribe v1.4
   Open in your web-browser: install.cgi, and folow instructions.

4. Step 4. - Install script crontab.pl in crontab.
   crontab.pl should be runned every minute.
   For the crons, you need to change this to the path of these scripts, so 
   your cron will look like this:
   * * * * * (cd /home/path_to_installed_dir/acc_subscribe/; perl crontab.pl)

5. Step 5. - Delete install.cgi
   For more security you should delete install.cgi from server

6. Or our specialists will install it for you totally free!

4. Support
=========================================================================
If you run into any problems, please visit our online contact form:

http://www.hotcgiscripts.com/?c=contact-us

or via e-mail contact@hotcgiscripts.com

Best regards,

Your HotCGIScripts Team.
http://www.hotcgiscripts.com

