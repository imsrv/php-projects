<?
/*
--------------------------------------------------------------------------------
PhpDig 1.4.x
This program is provided under the GNU/GPL license.
See LICENSE file for more informations
All contributors are listed in the CREDITS file provided with this package

PhpDig Website : http://phpdig.toiletoine.net/
Contact email : phpdig@toiletoine.net
Author and main maintainer : Antoine Bajolet (fr) bajolet@toiletoine.net
--------------------------------------------------------------------------------
*/
$relative_script_path = '..';
include "$relative_script_path/includes/config.php";
include "$relative_script_path/libs/auth.php";
include "$relative_script_path/admin/debug_functions.php";
include "$relative_script_path/admin/robot_functions.php";

echo test_url('http://user:password@test.antoine:80/protected.php');
$truc = file('http://user:password@test.antoine:80/protected.php');
dsp_table_datas($truc);
?>