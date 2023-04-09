#########################################################
#     SafeList - A full pay to join Opt in mail site    #
#########################################################
#                                                       #
#                                                       #
# This script was created by:                           #
#                                                       #
# PerlCoders Web Development Division.                  #
# http://www.perlcoders.com/                            #
#                                                       #
# This script and all included modules, lists or        #
# images, documentation are copyright 2001              #
# PerlCoders (http://perlcoders.com) unless             #
# otherwise stated in the module.                       #
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
# staff@perlcoders.com or info@perlcoders.com           #
#                                                       #
#########################################################


# server path to the directory holding the script
$scriptdir = "/path/to/script/safelist";

# web address (URL) to the directory holding the script
$scriptdirurl = "http://www.domain.com/safelist";

# your admin password for this script
$admin_pass = "pass";

# your email address
$adminmail = 'admin@domain.com';

# location of sendmail on your server 
$sendmail = "/usr/sbin/sendmail";

# do we email you when new users join?
$mail_admin = "yes";


# AUTOMATION LEVEL
# allow full automation = yes
# admin verifies users = no
$automate = "yes";

#maximum allowed mailings per day by users
$max_allowed = "2";

# email shown in from address on all mailings
$mail_from = 'you@domain.com';


# PAYPAL INFO
# ----------------------------------
# your paypal account email address
$paypal_account = 'you@domain.com';

# description of product you are selling
$paypal_item = "1 Year Safelist membership";

# amount of this transaction
$paypal_amount = "5.00";

# return URL from paypal if billing was unsuccessfull
$paypal_return = "http://domain.com";








1; # do not touch this line at all
