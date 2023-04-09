<?php
/**
 *
 * Static page handler
 *
 * @date 2005-10-23
 * @file static.php
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
 
if (!defined('MAIN')) {

    die('No direct access.');

}
 
if (isset($_GET['p']) && !empty($_GET['p'])) {

    $q = 'SELECT title, content FROM static WHERE active = 1 AND url = "'.$_GET['p'].'"';
    $page = $api['database']->getRow($api['database']->query($q));

    if (!empty($page)) {
    
        if (!get_magic_quotes_gpc()) {
        
            $page = array_map('stripslashes', $page);
        
        }
        
        $api['template']->set('page', 'templates/pages/static.tpl');
        $api['template']->set('w_subtitle', $page['title']);
        $api['template']->set('content', $page['content']);
    
    }
}
 
?>