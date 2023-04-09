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

//form for the search query.

// $query_string is the previous query if exists
// $option is search option
// $limite is the num results per page
// $result_page is path to the search.php script
// $site is the site to limit the results
// $path as the same purpose

function phpdig_form($query_string = "",$option="start",$limite=10,$result_page="index.php",$site="",$path="",$mode='classic')
{
if (!isset($option))
     $option = 'start';
settype($limite,'integer');
if ($limite == 0)
     $limite = 10;

$check_start = array('start' => 'checked' , 'any' => '', 'exact' => '');
$check_any = array('start' => '' , 'any' => 'checked', 'exact' => '');
$check_exact = array('start' => '' , 'any' => '', 'exact' => 'checked');

$limit10 = array(10 => 'selected', 30=> '', 100=> '');
$limit30 = array(10 => '', 30=> 'selected', 100=> '');
$limit100 = array(10 => '', 30=> '', 100=> 'selected');

$result['form_head'] = "<form action='$result_page' method='post'>
<input type='hidden' name='template_demo' value='$mode'>
<input type='hidden' name='site' value='$site'>
<input type='hidden' name='path' value='$path'>
<input type='hidden' name='result_page' value='$result_page'>
";
$result['form_foot'] = "</form>";
$result['form_title'] = msg('search');
$result['form_field'] = "<input type='text' name='query_string' size='24' value='".htmlentities(stripslashes($query_string))."'>";
$result['form_select'] = msg('display')."
  <select name='limite'>
  <option ".$limit10[$limite].">10</option>
  <option ".$limit30[$limite].">30</option>
  <option ".$limit100[$limite].">100</option>
  </select>
  ".msg('results')."
 ";
$result['form_button'] = "<input type='submit' name='search' value='Go...'>";
$result['form_radio'] = "<input type=\"radio\" name=\"option\" value=\"start\" ".$check_start[$option].">".msg('w_begin')."&nbsp;
 <input type=\"radio\" name=\"option\" value=\"exact\" ".$check_exact[$option].">".msg('w_whole')."&nbsp;
 <input type=\"radio\" name=\"option\" value=\"any\" ".$check_any[$option].">".msg('w_part')."&nbsp;
 ";
if ($mode == 'classic')
{
extract($result);
?>
<? print $form_head ?>
<table border="0" cellspacing='1' cellpadding='2' bgcolor="#000000">
 <tr>
  <td align="center" bgcolor='#AACCFF'>
  <B style="font-size:12;" ><? print $form_title ?></B>
  </td>
 </tr>
 <tr>
  <td align="left" bgcolor='#CCCCCC'>
  <? print $form_field ?>
  <? print $form_button ?>
  <? print $form_select ?>
  </td>
 </tr>
 <tr>
 <td align="center" bgcolor='#CCCCCC'>
 <? print $form_radio ?>
 </td>
 </tr>
</table>
</form>
<?
}
else
return $result;
}

//parse a phpdig template
function parse_phpdig_template($template,$t_strings,$table_results)
{
if (!is_file($template))
     {
     print "No template file found !";
     return 0;
     }

$in_loop = 0;
$f_handler = fopen($template,'r');
while ($line = fgets($f_handler,4096))
       {
       if (eregi('(.*)<phpdig:results>(.*)',$line,$regs))
           {
           $i = 0;
           $line .= $regs[1];
           $loop_part[$i++] = $regs[2];
           $in_loop = 1;
           $first_line = 1;
           }
       if ($in_loop == 1)
           {
           if (eregi('(.*)</phpdig:results>(.*)',$line,$regs))
               {
               $loop_part[$i++] = $regs[1];
               $line .= $line.$regs[2];
               $in_loop = 0;
               //parse the loop

               if (is_array($table_results) && is_array($loop_part))
                   {
                   reset($table_results);
                   while (list($id,$result) = each($table_results))
                          {
                          $result['n'] = $id;
                          reset($loop_part);
                          while(list($i,$this_loop) = each($loop_part))
                                {
                                print parse_phpdig_tags($this_loop,$result);
                                }
                          }

                   }
               }
           else if ($first_line == 1)
               {
               $first_line = 0;
               }
           else
               {
               $loop_part[$i++] = $line;
               }
           }

       if ($in_loop == 0)
           {
           print parse_phpdig_tags($line,$t_strings);
           }
       }
}

//replace <phpdig:/> tags by adequate value in a string
function  parse_phpdig_tags($line,$t_strings)
{
while(eregi('<phpdig:([a-z0-9_]*)[[:blank:]]*(src=)*["\']*([a-z0-9./_-]+)*["\']*[[:blank:]]*/>',$line,$regs))
                 {
                 if (!isset($t_strings[$regs[1]]))
                    $t_strings[$regs[1]] = '';
                 //links with images
                 if ($regs[2])
                     {
                     if ($regs[3] && $t_strings[$regs[1]])
                         {
                         if (ereg('^http',$t_strings[$regs[1]]))
                             $target = ' target="_blank"';
                         else
                             $target = '';

                         $replacement = '<A href="'.$t_strings[$regs[1]].'"'.$target.'><img src="'.$regs[3].'" border="0" align="bottom"></a>';
                         }
                     else
                         {
                         $replacement = '';
                         }
                     $line = str_replace($regs[0],$replacement,$line);
                     }
                 else
                     {
                     $line = str_replace($regs[0],$t_strings[$regs[1]],$line);
                     }
                 }

           return $line;
}
?>
