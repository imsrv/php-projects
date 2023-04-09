<?php

/*
	aterr - a threaded forum system.

	Copyright (c) 2005 Chris Jenkinson <chris@starglade.org>.
	All rights reserved.

	aterr is licensed under the GNU General Public License.
	<http://opensource.org/licenses/gpl-license.php>
*/

define('INCLUDE_PATH', 'include/');
include INCLUDE_PATH . 'common.inc.php';

redirect('http://' . $config['domain_name'] . $config['install_path'] . forums::furl());

?>
