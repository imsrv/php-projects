# ==================================================================
# Auto Generated Plugin Configuration - Needed for Web Based Creator.
#
#   Plugins::SearchFeed_Results
#   Author  : Andy Newby
#   Version : 1
#   Updated : Sat Sep 14 13:49:47 2002
#
# ==================================================================
#

package Plugins::SearchFeed_Results;
# ==================================================================
    use strict;
    use vars qw/$WIZARD/;

$WIZARD = {
    'install' => 'Hi. Please consider sending me a donation for this plugin, <a href=http://www.ace-installer.com/php/modules.php?name=Content&pa=showpage&pid=9>here</a>, and also, when signing up for SearchFeed.com, please use us as your affiliate referer....we get some gredit then :) <a href=http://www.searchfeed.com/rd/AffiliateInfo.jsp?p=5491>CLICK HERE TO SIGNUP</a>',
    'menu' => [
        [
            'Readme',
            'admin.cgi?do=plugin&plugin=SearchFeed_Results&func=Readme'
        ]
    ],
    'files' => [],
    'install_code' => '',
    'uninstall' => 'Sorry to see you are uninstalling :(',
    'user' => [
        [
            'SearchFeed_Affiliate_ID',
            '5491',
            'This is your ID number with SearchFeed. Make sure you change it, otherwise you won\'t get credit!',
            'TEXT',
            [],
            []
        ]
    ],
    'uninstall_code' => '',
    'name' => 'SearchFeed_Results',
    'meta' => {
        'prog_ver' => '2.1.0',
        'description' => 'This will grab the results from SearchFeed.com, and add them to the end (or beginning) of your results...',
        'license' => 'Freeware',
        'url' => 'http://www.ace-installer.com',
        'author' => 'Andy Newby',
        'version' => '1'
    },
    'hooks' => [
        [
            'search_results',
            'PRE',
            'Plugins::SearchFeed_Results::do_checks',
            'FIRST'
        ]
    ]
};


1;
