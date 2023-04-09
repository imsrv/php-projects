# ==================================================================
# Auto Generated Plugin Configuration - Needed for Web Based Creator.
#
#   Plugins::Banner
#   Author  : Andy Newby
#   Version : 1.1
#   Updated : Sat Jun  1 15:18:15 2002
#
# ==================================================================
#

package Plugins::Banner;
# ==================================================================
    use strict;
    use vars qw/$WIZARD/;

$WIZARD = {
    'install' => 'This script will allow you to use a tag, SSI or a PHP include to show banners on your site. Every time someone clicks on a banner, money is debited from their account. They can top up with PayPal (ClickBank comming soon) instantly. Comes with full admin control, statistics, advertiser login page and more... ',
    'meta' => {
        'prog_ver' => '2.1.0',
        'description' => 'This script will allow you to use a tag, SSI or a PHP include to show banners on your site. Every time someone clicks on a banner, money is debited from their account. They can top up with PayPal (ClickBank comming soon) instantly. Comes with full admin control, statistics, advertiser login page and more... ',
        'license' => 'Commercial',
        'url' => 'http://www.ace-installer.com',
        'author' => 'Andy Newby',
        'version' => '1.1'
    },
    'menu' => [
        [
            'Purchase',
            'admin.cgi?do=plugin&plugin=Banner&func=Purchase'
        ],
        [
            'Readme',
            'admin.cgi?do=plugin&plugin=Banner&func=Readme'
        ],
        [
            'FAQ',
            'admin.cgi?do=plugin&plugin=Banner&func=FAQ'
        ]
    ],
    'hooks' => [],
    'files' => [
        [
            'banner/advertiser_signup.php',
            'user_cgi'
        ],
        [
            'banner/banner.php',
            'user_cgi'
        ],
        [
            'banner/click.php',
            'user_cgi'
        ],
        [
            'banner/admin/admin.php',
            'user_cgi'
        ],
        [
            'banner/admin/advertiser.php',
            'user_cgi'
        ],
        [
            'banner/admin/paypal.php',
            'user_cgi'
        ],
        [
            'banner/admin/settings.inc.php',
            'user_cgi'
        ]
    ],
    'uninstall' => 'I\'m sorry you decided not to use this plugin any more. Thanks for trying it.',
    'install_code' => '',
    'user' => [],
    'name' => 'Banner',
    'uninstall_code' => ''
};


1;
