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
//executes a select and returns a whole resultset
function mysql_result_select($database,$id_connect,$query_select)
{
if (!eregi('^[^a-z]*select',$query_select))
     return -1;
$res_id = mysql_query($query_select,$id_connect);
if (mysql_num_rows($res_id) > 0)
    {
    $i = 0;
    while ($res_datas = mysql_fetch_array($res_id,MYSQL_ASSOC))
           {
           $result[$i] = $res_datas;
           $i++;
           }
    return $result;
    }
else
    return 0;
}
?>