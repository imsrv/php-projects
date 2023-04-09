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
function DSP_TABLE_DATAS($datas)
{
if(!is_array($datas))
    $datas[0] = 1;
else
    {
    list($id_one) = each($datas);
    reset($datas);
    }
if(!is_array($datas[$id_one]))
    {
    $id = 0;
    while (list($index,$value) = each($datas))
           {
           $datacopy[$id]['index'] = $index;
           $datacopy[$id]['value'] = $value;
           $id++;
           }
    $datas = $datacopy;
    }

    $rows = count($datas);
    $columns = count($datas[$id_one]);
    print "$rows rows & $columns columns<BR>";
    print "<TABLE border='1' cellspacing='0' cellpadding='3'>\n";
    print "\t<TR>\n";
    while(list($index) = each($datas[$id_one]))
          {
          print "\t\t<TD style='font-weight:bold; background-color:#CCCCCC'>$index</TD>\n";
          }
    print "\t</TR>\n";
    reset($datas);
    while(list($index) = each($datas))
           {
           print "\t<TR>\n";
           reset($datas[$index]);
           while(list($useless,$value) = each($datas[$index]))
                 {
                 print "\t\t<TD>$value</TD>\n";
                 }
           print "\t<TR>\n";
           }
    print "</TABLE>\n";

}
?>