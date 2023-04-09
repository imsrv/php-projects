<?
/*
           .ÜÜÜÜÜÜÜÜÜÜÜÜ,                                  .ÜÜÜÜÜÜÜÜÜ:     ,ÜÜÜÜÜÜÜÜ:
         ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ                             .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ,ÜÜÜÜÜÜÜÜÜÜÜÜÜ
        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ             D O N          ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ                           ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ.
         ÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜ          ÜÜÜÜÜÜÜ;        .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜ;
         ,ÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜ        ÜÜÜÜÜÜÜÜÜÜÜ        ,ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ;ÜÜÜÜÜÜÜÜ;
          ÜÜÜÜÜÜÜÜÜ :ÜÜÜÜÜÜÜÜÜ      ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;;ÜÜÜÜÜÜÜÜ
          ÜÜÜÜÜÜÜÜ: ÜÜÜÜÜÜÜÜÜÜ    .ÜÜÜÜÜÜÜ;;ÜÜÜÜÜÜ;      :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;ÜÜÜÜÜÜ.
         ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ   ;ÜÜÜÜÜÜÜ  .ÜÜÜÜÜÜÜ     .ÜÜÜÜÜÜÜÜ;ÜÜÜÜÜÜÜ;ÜÜÜÜÜÜ
        :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜ,,,ÜÜÜÜÜÜÜÜ    .ÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ    ÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
       ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ, ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  .ÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:
     .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
    ,ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ :ÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
   ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ,ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
  ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ.  :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
 ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;     ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:
 ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ.      ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ,  ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
 ,ÜÜÜÜLiquidIceÜÜÜÜÜÜ          ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ    ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜ
    .ÜÜÜÜÜÜÜÜÜÜ;                 ÜÜÜÜÜÜÜÜÜ        .ÜÜÜÜÜÜÜÜÜÜÜ    .ÜÜÜÜÜÜÜÜÜÜ,

*/

$act=form_get("act");
if($act==''){
  que_list();
}
elseif($act=='c_del'){
  delete_que();
}
elseif($act=='q_add'){
  add_question();
}
elseif($act=='ans_add'){
  add_ans();
}

function que_list(){
$adsess=form_get("adsess");
admin_test($adsess);
$sql_query="select q_id from questions";
$res=sql_execute($sql_query,'res');
$cats=array();
while($cat=mysql_fetch_object($res)){
   array_push($cats,$cat->q_id);
}//while
//find middle of array
$mid=(int)(count($cats)/2)+2;
show_ad_header($adsess);
?>
  <table width=100% class='body'>
   <tr><td class='lined title'>Admin: Manage Profile Questions</td>
   <tr><td class='lined padded-6' align=center>
   <form action='admin.php' method=post>
   <input type='hidden' name='mode' value='profilequestion_manager'>
   <input type='hidden' name='act' value='q_add'>
   <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
   <input type=text name='new_que'>&nbsp<input type=submit value='Add New Question'>
   </td></form>
   <tr><td class='lined padded-6'>
   <table class='body' width=100%>
         <form action='admin.php' method=post>
         <input type='hidden' name='mode' value='profilequestion_manager'>
         <input type='hidden' name='act' value=''>
         <input type='hidden' name='adsess' value='<? echo $adsess; ?>'>
         <tr><td valign=top width=50%>
         <table class=body>
         <?
            for($i=0;$i<$mid;$i++){
            $sql_query="select * from questions where q_id='$cats[$i]'";
            $cat=sql_execute($sql_query,'get');
               echo "<tr><td colspan=2><input type=checkbox name='cat_id[]' value='$cat->q_id'></td><td><b>$cat->q_que</b></td>";
               $sql_query="select * from answers where a_qid='$cat->q_id'";
               $res2=sql_execute($sql_query,'res');
               while($sub=mysql_fetch_object($res2)){
                   echo "<tr><td>&nbsp</td><td><input type=checkbox name='sub_cat_id[]' value='$sub->a_id'></td><td class='form-comment'>$sub->a_ans</td>";
               }//while
            echo "<tr><td colspan=3>
            <input type=hidden name='cat_id_ex[]' value='$cats[$i]'>
            <input type='text' size=15 name='new_ans[]'>&nbsp<input type='submit' value='Add' onClick='this.form.act.value=\"ans_add\"'>
            </td>";
            }//for
         ?>
         </table></td>
         <td valign=top>
         <table class=body>
         <?
            for($i=$mid;$i<count($cats);$i++){
            $sql_query="select * from questions where q_id='$cats[$i]'";
            $cat=sql_execute($sql_query,'get');
               echo "<tr><td colspan=2><input type=checkbox name='cat_id[]' value='$cat->q_id'></td><td><b>$cat->q_que</b></td>";
               $sql_query="select * from answers where cat_id='$cat->q_id'";
               $res2=sql_execute($sql_query,'res');
               while($sub=mysql_fetch_object($res2)){
                   echo "<tr><td>&nbsp</td><td><input type=checkbox name='sub_cat_id[]' value='$sub->a_id'></td><td class='form-comment'>$sub->a_ans</td>";
               }//while
            echo "<tr><td colspan=3>
            <input type=hidden name='cat_id_ex[]' value='$cats[$i]'>
            <input type='text' size=15 name='new_ans[]'>&nbsp<input type='submit' value='Add' onClick='this.form.act.value=\"ans_add\"'>
            </td>";
            }//for
         ?>
         </table>
         </td>
         <tr><td colspan=2 align=right><input type='submit' value='Delete' onClick='this.form.act.value="c_del"'></td>
  </form></table></td></table>
<?
show_footer();
}//function

function add_question(){
$adsess=form_get("adsess");
admin_test($adsess);

$name=form_get("new_que");

$sql_query="insert into questions(q_que) values('$name')";
sql_execute($sql_query,'');

que_list();

}//function

function add_ans(){
$adsess=form_get("adsess");
admin_test($adsess);

$cat_ids=form_get("cat_id_ex");
$names=form_get("new_ans");

for($i=0;$i<count($names);$i++){
  if($names[$i]!=''){
    $stop=$i;break;
  }
}//for

$cat_id=$cat_ids[$stop];
$name=$names[$stop];

$sql_query="insert into answers(a_qid,a_ans) values('$cat_id','$name')";
sql_execute($sql_query,'');

que_list();

}//function

function delete_que(){
$adsess=form_get("adsess");
admin_test($adsess);

$cat_id=form_get("cat_id");
$sub_cat_id=form_get("sub_cat_id");

if($sub_cat_id!=''){
  foreach($sub_cat_id as $sid){
       $sql_query="delete from answers where a_id='$sid'";
       sql_execute($sql_query,'');
  }//foreach
}//if

if($cat_id!=''){
  foreach($cat_id as $cid){
      $sql_query="delete from questions where q_id='$cid'";
      sql_execute($sql_query,'');
      $sql_query="delete from answers where a_qid='$cid'";
      sql_execute($sql_query,'');
  }//foreach
}//if

que_list();

}//function


?>