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
settype($type,'string');
?>
<html>
</head>
<title>PhpDig : <? pmsg('statistics') ?> </title>
<?
include "$relative_script_path/includes/style.php";
?>
</head>
<body bgcolor="white">
<img src="../phpdiglogo.gif" width="246" height="77" alt="PhpDig <? print $phpdig_version ?>"><br>
<h1><? pmsg('statistics') ?></h1>
<p class='grey'>
<a href="statistics.php?type=mostkeys">Common keywords</a> |
<a href="statistics.php?type=mostpages">Large pages</a> |
</p>
<hr>
<center>
<?
if ($type)
    {
    $start_table_template = "<TABLE cellspacing='0' cellpadding='1'><TR><TD bgcolor='#220044'><TABLE cellspacing='1' cellpadding='2'>\n";
    $end_table_template = "</TABLE></TD></TR></TABLE>\n";
    $line_template = "<TR>@</TR>\n";
    $title_cell_template = "\t<TD bgcolor='#220044' align='center'><b><font size='2' color='#FFFFFF'>@</font></b></TD>\n";
    $cell_template[0] = "\t<TD bgcolor='#D7D7D7'>@</TD>\n";
    $cell_template[1] = "\t<TD bgcolor='#DFDFDF'>@</TD>\n";
    $cell_template[2] = "\t<TD bgcolor='#E7E7E7'>@</TD>\n";
    $cell_template[3] = "\t<TD bgcolor='#EFEFEF'>@</TD>\n";
    $cell_template[4] = "\t<TD bgcolor='#F7F7F7'>@</TD>\n";

    $mod_template = count($cell_template);
    print msg('pwait').'...<br>'."\n";
    flush();

    switch ($type)
            {
            case 'mostkeys':
                  $query = 'select k.keyword ,sum(e.weight) as num
                  FROM keywords k, engine e
                  WHERE k.key_id = e.key_id
                  GROUP BY k.keyword
                  HAVING num > 100
                  ORDER BY num DESC LIMIT 0,50';
            break;

            case 'mostpages':
                  $query = 'select CONCAT(st.site_url,s.path,s.file) as page,s.num_words
                  FROM spider s, sites st
                  WHERE s.site_id = st.site_id
                  AND s.num_words > 100
                  ORDER BY num_words DESC LIMIT 0,50';
            break;
            }
    $result = mysql_query($query,$id_connect);
    if (mysql_num_rows($result) > 0)
        {
        print $start_table_template;
        // title line
        $num_fields = mysql_num_fields($result);
        $title_line = '';
        for ($i = 0; $i < $num_fields; $i ++)
             {
             $title_line .= str_replace('@',mysql_field_name($result,$i),$title_cell_template);
             }
        print str_replace('@',$title_line,$line_template);
        $this_row = 0;
        while ($line = mysql_fetch_row($result))
               {
               $this_line = '';
               $id_row_style = $this_row % $mod_template;

               for ($i = 0; $i < $num_fields; $i ++)
                    {
                    $this_line .= str_replace('@',urldecode($line[$i]),$cell_template[$id_row_style]);
                    }
               print str_replace('@',$this_line,$line_template);
               $this_row ++;
               }
        print $end_table_template;
        }
    }
?>
</center>
<hr>
<A href="index.php" target="_top">[<? pmsg('back') ?>]</A> <? pmsg('to_admin') ?>.
</body>
</html>