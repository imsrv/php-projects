<?
/* nulled by [GTT] :) */
function db_connect()
{
//   mysql_pconnect("localhost","root","");
//   mysql_select_db("mlm_matrix");

   mysql_pconnect("localhost","root","DB password");
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

function admin_menu()
{
?>
<script language="JavaScript">
<!--
function jumpMenu(targ,selObj,restore){
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<div align="center">
  <select name="select" onChange="jumpMenu('parent',this,0)" align="top">
    <option value="adminlogin.php" selected>Navigation Options</option>
    <option value="adminlogin.php">-------------</option>
    <option value="adminlogin.php">Main Menu</option>
    <option value="adminedit.php" >Modify Admin Login Details</option>
    <option value="admafflist.php" >List Current Affiliates</option>
    <option value="admpref.php" >Preferences</option>
    <option value="admbanners.php" >Banner and Text Link Setup</option>
    <option value="upload.php" >Manage Software Programs</option>
    <option value="admsubscr.php" >Manage Subscribtions</option>
    <option value="admitemset.php" >Affiliate Payment / Single Item Setup</option>
    <option value="admrefunds.php" >Cancel Payments / Refunds</option>
    <option value="adm-email-edit.php" >Customise emails to affiliates</option>
    <option value="admallaffmail.php" >Email all affiliates</option>
    <option value="admstartpages.php" >Customise affiliate start pages</option>
    <option value="adm-shift.php" >Shift Downline</option>
    <option value="addbanner.php" >Banners</option>
  </select>
  <?
}
function display_programs()
{
db_connect();
$programs=db_result_to_array("SELECT * FROM programs");
?>
  <table  cellpadding="4" cellspacing="0" class="ver"><tr">
    <td ><b>ID</b></td>
    <td><b>Title</b></td>
    <td><b>Description</b></td>
    <td><b>Price</b></td>
    <td><b>File</b></td>
    <td><b>Action</b></td>
    </tr>
    <? for ($i=0; $i<count($programs); $i++) {?><tr">
    <td ><?echo $programs[$i]['id']?></td>
    <td><?echo $programs[$i]['title']?></td>
    <td><?echo $programs[$i]['description']?></td>
    <td><?echo $programs[$i]['price']?></td>
    <td><?echo $programs[$i]['filename']?></td>
    <td><a href=upload.php?editid=<?echo $programs[$i]['id']?>>Edit</a>/<a href=upload.php?delid=<?echo $programs[$i]['id']?>>Delete</a></td>
    </tr>
    <?}?>
  </table>
  <?
}
function display_subscribtions()
{
db_connect();
$subscribtions=db_result_to_array("select * from subscribtions");
if ($subscribtions)
{
?>
  <table width=400 align=center>
    <tr>
      <td><b>ID</b></td>
      <td><b>Name</b></td>
      <td><b>Description</b></td>
      <td><b>Signup fee</b></td>
      <td><b>Duration (days)</b></td>
      <td><b>Re-occuring price</b></td>
      <td><b>Action</b></td>
    </tr>
    <?for ($i=0; $i<count($subscribtions); $i++)
echo "<tr><td>".$subscribtions[$i]['id']."</td><td>".$subscribtions[$i]['name']."</td><td>".$subscribtions[$i]['description']."</td><td>$".number_format($subscribtions[$i]['signupfee'],2)."</td><td>".$subscribtions[$i]['duration']."</td><td>$".number_format($subscribtions[$i]['reoccuringfee'],2)."</td><td><a href=admsubscr.php?editid=".$subscribtions[$i]['id'].">Edit</a>/<a href=admsubscr.php?delid=".$subscribtions[$i]['id'].">Delete</a>";
//echo "/<a href=admsubscr.php?codeid=".$subscribtions[$i]['id'].">Get code</a>";
echo "</td></tr>";
?>
  </table>
  <?
}
else echo "You have not set up any subscribtions yet.";
}
function display_item_form($id)
{
$query_progs = "SELECT * FROM programs";
$progs = mysql_query($query_progs) ;
$row_progs = mysql_fetch_assoc($progs);
$totalRows_progs = mysql_num_rows($progs);
$result=mysql_query("select * from aff_payments where id='$id'");
$result=mysql_fetch_array($result);?>
</div>
<FORM  method=post>
  <div align="center">
    <input type=hidden name=add value=1>
    <input type=hidden name=updateid value=<?echo $id?>>
    <TABLE width=510 border=0>
      <TBODY>
        <TR>
          <TD width=104>Choose a Program:<br>
            <br> <select name=programid>
              <option value="">Title | Description | Price
              <?php do { ?>
              <? $i++ ?>
              <option value="<?php echo $row_progs['id']; ?>" <?if ($result['programid']==$row_progs['id']) echo "selected";?>>
              <?php echo $row_progs['title']; ?> | <?php echo $row_progs['description']; ?>
              | $<?php echo number_format($row_progs['price'], 2); ?></option>
              <?php } while ($row_progs = mysql_fetch_assoc($progs)); ?>
            </select>
            <br>
            <br> <hr width=600> </TD>
        </TR>
        <TR>
          <TD width=104><br>
            <br>
            <b>OR</b><br>
            <br>
            Choose a Subscribtion:<br>
            <br> <select name=subscrid>
              <option value="">Name | Description | Signup Fee | Duration | Reuccuring
              Fee
              <?php
  $subscrs=mysql_query("select * from subscribtions");
  $row_subscrs = mysql_fetch_assoc($subscrs);
  do { ?>
              <? $j++ ?>
              <option value="<?php echo $row_subscrs['id']; ?>" <?if ($result['subscrid']==$row_subscrs['id']) echo "selected";?>>
              <?php echo $row_subscrs['name']; ?> | <?php echo $row_subscrs['description']; ?>
              | $<?php echo number_format($row_subscrs['signupfee'], 2); ?> |
              <?php echo $row_subscrs['duration']; ?> | $<?php echo number_format($row_subscrs['reoccuringfee'], 2); ?></option>
              <?php } while ($row_subscrs = mysql_fetch_assoc($subscrs)); ?>
            </select> <br> <hr width=600> </TD>
        </TR>
        <TR>
          <TD width=104><br>
            <br>
            <b>OR</b><br>
            <br>
            Add another <b>Single</b> Item:<br>
            <br> </TD>
        </TR>
        <TR>
          <TD width=104>Item Name:</TD>
          <TD width=396><INPUT maxLength=250 size=40 name=name value="<?echo $result['name'];?>">
          </TD>
        </TR>
        <TR>
          <TD width=104>Item Description:</TD>
          <TD width=396> <INPUT maxLength=250 size=40 name=description value="<?echo $result['description'];?>">
          </TD>
        </TR>
        <TR>
          <TD width=104>Item Price:</TD>
          <TD width=396>$
            <INPUT maxLength=15 size=7 name=price value="<?echo number_format($result['price'],2);?>">
          </TD>
        </TR>
        <TR>
          <TD colspan=2 align=left><hr width=600>
            <br>
            <br></TD>
        </TR>
        <TR>
          <TD colSpan=2> <H4>Affiliate Payments</H4></TD>
        </TR>
        <TR>
          <TD width=104>Direct Affiliate ($):</TD>
          <TD width=396><INPUT maxLength=7 size=7 name=directaf value="<?echo $result['directaf'];?>"></TD>
        </TR>
<?
$matrix_deep=db_result_to_array("select matrix_deep from admininfo");
for ($i=1; $i<=$matrix_deep[0][0]; $i++)
{
$aff_comm_db=db_result_to_array("select commission from levels_commisions where affitem_id=$id and level_num=$i");
?>
        <TR>
          <TD width=104>Level <?echo $i?> ($):</TD>
          <TD width=396><INPUT maxLength=7 size=7 name=aff_comm[<?echo $i?>] value="<?echo $aff_comm_db[0][0];?>"></TD>
        </TR>
<?}?>
        <TR>
          <TD width=104>&nbsp;</TD>
          <TD width=396>&nbsp;</TD>
        </TR>
        <TR align=middle>
          <TD colSpan=2><BR>
            <INPUT type=submit value="<?if ($id) echo "Edit Item"; else echo "Add Item";?>">
            <INPUT type=reset value="Clear Form"> </TD>
        </TR>
      </TBODY>
    </TABLE>
  </div>
</FORM>
<div align="center"><BR>
  <?

}
function display_product_form($id)
{
$result=mysql_query("select * from programs where id='$id'");
$result=mysql_fetch_array($result);
?>
</div>
<form action="" method="post" enctype="multipart/form-data" name="form1">
  <div align="center">
    <input type="hidden" name="add" value="<?if (!$id)echo "true"?>">
    <input type="hidden" name="editid" value="<?echo $id?>">
    <input type="hidden" name="edit" value="<?if ($id)echo "true"?>">
    <table>
      <tr>
        <td>Title</td>
        <td><INPUT maxLength=250 size=40 name=title value="<?echo $result['title'];?>"></td>
      </tr>
      <tr>
        <td>Description</td>
        <td><INPUT maxLength=250 size=40 name=description value="<?echo $result['description'];?>"></td>
      </tr>
      <tr>
        <td>Price</td>
        <td>$
          <INPUT maxLength=15 size=7 name=price value="<?echo number_format($result['price'],2);?>"></td>
      </tr>
      <tr>
        <td>File</td>
        <td><input type="file" name="file">
          <?if ($id) echo " (leave blank if the same)";?>
        </td>
      </tr>
    </table>
    <br>
    <INPUT type=submit value="<?if ($id) echo "Edit Item"; else echo "Add Item";?>">
    <INPUT type=reset value="Clear Form">
  </div>
</form>
  <?
}
?>