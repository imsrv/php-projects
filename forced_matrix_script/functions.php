<?
/* nulled by [GTT] :) */

function db_connect()
{
//   mysql_pconnect("localhost","root","");
//   mysql_select_db("mlm_matrix");

   mysql_pconnect("localhost","root","password for DB");
   mysql_select_db("NAME DB");
}

function db_result_to_array($query)
{
   $result=mysql_query($query);
   $res_array = array();

   for ($count=0; $row = @mysql_fetch_array($result); $count++)
     $res_array[$count] = $row;

   return $res_array;
}

function add_new_matrix_entry($user_id)
{
  global $incomplete_users;
  $incomplete_users="";
  $user_referer=db_result_to_array("select referer from users where disabled=0 and id=$user_id");
  $admin=db_result_to_array("select matrix_deep, matrix_width from admininfo");
  $matrix_width=$admin[0]['matrix_width'];
  if (!$user_referer[0][0]) //if this is a non-referred user
  {
   $allmatrix_users=db_result_to_array("select DISTINCT user_id from matrix");  //taking all existing users from the matrix
   for ($j=0; $j<count($allmatrix_users); $j++)
   {
    $childs=db_result_to_array("select user_id from matrix where parent_id=".$allmatrix_users[$j]['user_id']." order by user_id");  //child_id changed to user_id
        if (count($childs)<$matrix_width||!$childs)      //choosing users with incomplete childs
         $incomplete_users[]=$allmatrix_users[$j]['user_id'];
   }
  }
  else //if this user was referred by someone (assuming he is already in the matrix)
  {
   $referrer=$user_referer[0][0];
   find_incomplete_matrix_users($referrer, $matrix_width); //creates global $incomplete_users array
  }
  $target_user_id=find_youngest_parent($incomplete_users);  //finding the target user
  $r=mysql_query("insert into matrix (id, user_id, parent_id) values ('', '".$user_id."', '".$target_user_id."')");
  return $r;
}

function find_incomplete_matrix_users($id, $matrix_width) //needs to be a function because of
{
 global $incomplete_users;
 $childs=db_result_to_array("select user_id from matrix where parent_id=$id");   //child_id changed to user_id
 if (count($childs)<$matrix_width||!$childs)
  $incomplete_users[]=$id;
 for ($i=0; $i<count($childs); $i++)
  find_incomplete_matrix_users($childs[$i][0], $matrix_width);
}

function find_youngest_parent($incomplete_users)
{
 $max_user=db_result_to_array("select max(user_id) from matrix");
 $target_user['minparent']=$max_user[0][0]+1;
 for ($k=0; $k<count($incomplete_users);$k++)
  if ($incomplete_users[$k]<$target_user['minparent'])   //detecting the minimum id of a parent
   $target_user['minparent']=$incomplete_users[$k];
 return $target_user['minparent'];
}

function calc_balance($id)
{
 $admin=db_result_to_array("select matrix_deep from admininfo");
 $matrix_deep=$admin[0][0];
 $directsaleam=db_result_to_array("select saleam from users where id='$id'");
 $balance=$directsaleam[0][0];
 $levels_sales=db_result_to_array("select salesamt from levels_sales where user_id='$id'");
 for ($i=0; $i<count($levels_sales); $i++)
  $balance+=$levels_sales[$i][0];
 return $balance;
}

function calc_sales($id) //not in use
{
 $levelsaleqt=db_result_to_array("select saleqt, lev1saleqt, lev2saleqt, lev3saleqt, lev4saleqt, lev5saleqt, lev6saleqt, lev7saleqt from users where id='$id'");
 for ($clicks=0, $i=0; $i<8; $i++)
  $clicks+=$levelsaleqt[0][$i];
 return $clicks;
}

check_order();

function check_order()
{
 db_connect();
 $admin=db_result_to_array("select cooloff, matrix_deep from admininfo");
 $cooloff=$admin[0][0];
 $matrix_deep=$admin[0][1];
 $orders=db_result_to_array("select txn_id, date, goodid, affid from orders where paid='0'");
 for ($i=0; $i<count($orders); $i++)
  {
   $good_direct=db_result_to_array("select directaf from aff_payments where id='".$orders[$i][2]."'");
   $date=$orders[$i][1];
   $timenow=time();
   if ((($timenow-$date)/(60*60*24))>$cooloff)
    {
         $user=db_result_to_array("select saleqt, saleam from users where id='".$orders[$i][3]."'");
     $user[0][0]++;
         $user[0][1]+=$good_direct[0][0];
         mysql_query("update users set saleqt='".$user[0][0]."', saleam='".$user[0][1]."' where id='".$orders[$i][3]."'");
         $id=$orders[$i][3];
         for ($level_num=1; $level_num<=$matrix_deep; $level_num++)
         {
          //$referer=db_result_to_array("select referer from users where id='$id'");
          $referer=db_result_to_array("select parent_id from matrix where user_id='$id'");
          $current_commision=db_result_to_array("select commission from levels_commisions where affitem_id=".$orders[$i][2]." and level_num=$level_num");
          if ($referer[0][0])
           {
            $sales_level=db_result_to_array("select salesquant, salesamt from levels_sales where user_id='".$referer[0][0]."' and level_num=$level_num");
                if ($sales_level)
                {
                 $sales_level[0]['salesquant']++;
                 $sales_level[0]['salesamt']+=$current_commision[0][0];
             mysql_query("update levels_sales set salesquant='".$sales_level[0]['salesquant']."', salesamt='".$sales_level[0]['salesamt']."' where user_id='".$referer[0][0]."' and level_num=$level_num");
                }
        else
                 mysql_query("insert into levels_sales (id, salesquant, salesamt, level_num) values ('', 1, '".$current_commision[0][0]."', $level_num)");
                $id=$referer[0][0];
           }
          else break;
         }
         mysql_query("update orders set paid='1' where txn_id='".$orders[$i][0]."'");
        }
  }
}

check_linkexpire();

function check_linkexpire()
{
db_connect();
$admin=db_result_to_array("select linklifehours from admininfo");
$linklifehours=$admin[0][0];


$links=db_result_to_array("select id, date, link from temp_link limit 1");
for ($i=0; $i<count($links); $i++)
{
 $timepassed=time()-$links[$i][1];
 $timepassed=($timepassed-$timepassed%3600)/3600;
 if ($timepassed>$linklifehours)
 {
  mysql_query("delete from temp_link where id='".$links[$i][0]."'");
  //echo $links[$i][2];
  unlink($links[$i][2]);
  $latsslash=strrpos($links[$i][2], "/");
  $dir=substr($links[$i][2], 0, $latsslash);
  rmdir($dir);
 }


}

}
?>