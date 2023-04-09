<?php
/**
 *
 * Grid page handler
 *
 * @author Karolis Tamutis
 * @date 2005-10-08
 * @file grid.php
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

/**
 * 
 * Set the title of the page
 */
$api['template']->set('w_subtitle', 'Pixels');
 
$api['template']->set('page', 'templates/pages/grid.tpl');

/**
 *
 * A little CSS 'hack'
 */
$api['template']->set('grid_hack', ' top: 990px;');

/**
 *
 * Get ad info from database 
 */
$q = 'SELECT * FROM ads WHERE active = 1';
$ads = $api['database']->getArray($api['database']->query($q));
 
$api['template']->set('ads', $ads);
?>