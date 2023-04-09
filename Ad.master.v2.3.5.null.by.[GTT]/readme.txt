# ==================================================================
# Ad Master - manage your banners with easy
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
# =====================================================================

Welcome to Ad Master v2.3.5!

TABLE OF CONTENTS

    1. Welcome
        1.1 About the Script
        1.2 System Requirements
    2. Installation
    3. Upgrade from Ad Master v2.3
    4. Support

1. Welcome
=========================================================================

1.1 About the Script
-------------------------------------------------------------------------
Ad Master v2.3.5 is a professional banner advertisement package which helps you 
to optimize your banner campaigns. It provides the comprehensive and convenient 
way to control banners and campaigns.
Ad Master is the best solution for site owners, who would like to make money by 
selling banner place on their web sites.
Also this package is developed for webmasters, who pay for advertising campaigns.
Multiple campaigns can be created.
This allows you to organize your banners rotations with ease.
Multiply users system allows to give an access to another webmasters!

For the full list of features, and details, please visit:

1.2 System Requirements
-------------------------------------------------------------------------
1. Perl 5.005 or higher.
2. UNIX or Windows based server.
3. Mysql
4. CGI Access.
5. Crontab (only for send statistics to other)

2. Installation
=========================================================================
Ad Master installation is very straight forward.

To install, please follow the following steps:

1. Copy all files and dirs files to your cgi-bin directory.
   Upload script and templates in text mode, and images in binary mode
2. Then install the execution rights (755 or rwx-rx-rx) on admin.cgi, 
   bb.cgi and install.cgi
3. Run install.cgi (by typping in your browser 
   http://your_server_name/cgi-bin/install.cgi) 
   and follow instractions
4. Step 4. - Install script crontab.pl in crontab.
   crontab.pl should be runned every minute.
   For the crons, you need to change this to the path of these scripts, so 
   your cron will look like this:
   * * * * * (cd /home/path_to_installed_dir_ad_master/; perl crontab.pl)
5. Or our specialists will install it for you totally free!

Best regards,

Your HotCGIScripts Team.