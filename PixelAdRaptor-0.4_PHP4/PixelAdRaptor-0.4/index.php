<?php
/**
 *
 * Main index file
 *
 * @date 2005-10-08
 * @file index.php
 *
 * Copyright (C) 2005  Karolis Tamutis
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA. 
 */
 
session_start();

define('MAIN', true);

/**
 *
 * Config and library inclusions
 */
require_once('config.php');
require_once('core/database.php');
require_once('core/template.php');
  
/**
 *
 * Object initializations
 */
$api['database'] = & new Database($config);
$api['template'] = & new Template();

require_once('core/request-mapper.php');

/**
 *
 * Setup config variables
 */
$q = 'SELECT value FROM config WHERE variable = "title" OR variable = "description" OR variable = "slogan" OR variable = "site_url"';
$settings = $api['database']->getArray($api['database']->query($q));

if (!get_magic_quotes_gpc()) {
        
    foreach ($settings as $key => $value) {
    
        $settings[$key] = array_map('stripslashes', $value);
        
    }
        
}

$api['template']->set('w_title', $settings[0]['value']);
$api['template']->set('w_description', $settings[1]['value']);
$api['template']->set('w_slogan', $settings[2]['value']);
$api['template']->set('w_siteurl', $settings[3]['value']);

/**
 *
 * Setup navigation links
 */
$q = 'SELECT url, title FROM navigation WHERE active = 1 ORDER BY weight DESC';
$links = $api['database']->getArray($api['database']->query($q));

if (!get_magic_quotes_gpc()) {

    foreach ($links as $key => $value) {
    
        $links[$key] = array_map('stripslashes', $value);
    
    }

}

/**
 *
 * An ugly hack, but I have no other ways to go around this now.
 */
$link_num = sizeof($links) - 1;

for ($i = 0; $i < $link_num; $i++) {

    $links[$i]['space'] = '&nbsp;|';

}

$api['template']->set('header_links', $links);

/**
 *
 * Setup sold / available statistics
 */
$q = 'SELECT SUM(size) as sold FROM ads WHERE active = 1';
$stats = $api['database']->getRow($api['database']->query($q));

$api['template']->set('sold', number_format($stats['sold']));
$api['template']->set('available', number_format(1000000 - $stats['sold']));

/**
 *
 * Setup adsense 
 */
$q = 'SELECT value FROM config WHERE variable = "adsense" OR variable = "adsense_enabled"';
$adsense = $api['database']->getArray($api['database']->query($q));

if (!empty($adsense)) {

    if (!get_magic_quotes_gpc()) {

        $adsense[0]['value'] = stripslashes($adsense[0]['value']);
        $adsense[1]['value'] = stripslashes($adsense[1]['value']);

    }
    
    if ($adsense[1]['value'] != 0) {
    
        $api['template']->set('adsense', $adsense[0]['value']);
        
    } else {
        /**
         *
         * Hide adsense div's
         */
        $api['template']->set('adsense_style', 'display: none;');
     
    }

}

$api['template']->show('templates/index.tpl', 'file');

?>