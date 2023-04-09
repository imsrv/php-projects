<?php
/*
           .мммммммммммм,                                  .ммммммммм:     ,мммммммм:
         мммммммммммммммммм                             .мммммммммммммм ,ммммммммммммм
        мммммммммммммммммммм             D O N          ;мммммммммммммм:ммммммммммммммм
        ммммммммммммммммммммм                           ;мммммммммммммммммммммммммммм.
         мммммммммм  ммммммммм          ммммммм;        .ммммммммммммммм мммммммммм;
         ,ммммммммм  ммммммммм        ммммммммммм        ,мммммммммммммм ;мммммммм;
          ммммммммм :ммммммммм      мммммммммммммм        мммммммммммммм;;мммммммм
          мммммммм: мммммммммм    .ммммммм;;мммммм;      :ммммммммммммммм;мммммм.
         ммммммммммммммммммммм   ;ммммммм  .ммммммм     .мммммммм;ммммммм;мммммм
        :ммммммммммммммммммммм  мммммммм,,,мммммммм    .мммммммм  мммммммммммммм
        мммммммммммммммммммммм ;ммммммммммммммммммм    ммммммммм  мммммммммммммм
       мммммммммммммммммммммм, мммммммммммммммммммм  .ммммммммммм мммммммммммммм:
     .ммммммммммммммммммммммм мммммммммммммммммммм  ммммммммммммм мммммммммммммм;
    ,ммммммммммммммммммммммм .мммммммммммммммммммм :ммммммммммммм мммммммммммммм;
   ;ммммммммммммммммммммммм  :ммммммммммммммммммм ,мммммммммммммм мммммммммммммм;
  ;ммммммммммммммммммммммм.  :ммммммммммммммммммм:мммммммммммммммммммммммммммммм;
 ммммммммммммммммммммммм;     мммммммммммммммммм ммммммммммммммммммммммммммммммм:
 мммммммммммммммммммммм.      мммммммммммммммм,  мммммммммммммммм мммммммммммммм
 ,ммммLiquidIceмммммм          мммммммммммммм    ммммммммммммммм  ммммммммммммм
    .мммммммммм;                 ммммммммм        .ммммммммммм    .мммммммммм,

*/

global $words_lang,$blocks_lang,$frazes_lang,$buttons_lang,$titles_lang,$lang_def,$date_format;
$adsess=form_get("adsess");
$act_me=form_get("act_me");
$pack_capt=form_get("pack_capt");
$seid=form_get("seid");
$second=form_get("second");
$amt=form_get("amt");
//if(empty($amt))	$amt=0.00;
$grp=form_get("grp");
$list=form_get("list");
$eve=form_get("eve");
$blog=form_get("blog");
$chat=form_get("chat");
$forum=form_get("forum");
$nop=form_get("nop");
if(empty($nop))	$nop=0;
admin_test($adsess);
switch($act_me){
  case 'Add Pack':
  	if(empty($pack_capt) or empty($amt))	{
		$mode="package_add";
		$matt="please fill the form properly.";
		$hed="Location:admin.php?mode=$mode&adsess=$adsess&err_mess=$matt&T1=$pack_capt&T2=$amt&T3=$grp&T4=$list&T6=$nop";
	}	else	{
		$sql_check="select * from member_package where package_nam='".addslashes($pack_capt)."'";
		$res_check=mysql_query($sql_check);
		if(!mysql_num_rows($res_check))	{
			if(empty($grp))	$grp="N";
			if(empty($list))	$list="N";
			if(empty($eve))	$eve="N";
			if(empty($blog))	$blog="N";
			if(empty($chat))	$chat="N";
			if(empty($forum))	$forum="N";
			$ins_testi="insert into member_package (package_nam,package_grp,package_list,package_eve,package_blog,package_chat,package_forum,package_nphot,package_amt) values ";
			$ins_testi.="('".addslashes($pack_capt)."','".$grp."','".$list."','".$eve."','".$blog."','".$chat."','".$forum."',$nop,$amt)";
			mysql_query($ins_testi);
			$mode="package_manager";
			$matt="this package added successfully.";
			$hed="Location:admin.php?mode=$mode&adsess=$adsess&err_mess=$matt";
		}	else	{
			$mode="package_add";
			$matt="this package exists. please try with some other.";
			$hed="Location:admin.php?mode=$mode&adsess=$adsess&err_mess=$matt&T1=$pack_capt&T2=$amt&T3=$grp&T4=$list&T6=$nop";
		}
	}
  break;
  case 'Mod Pack':
  	$mode="mod_package";
  	if(empty($pack_capt) or empty($amt))	{
		$matt="please fill the form properly.";
		$hed="Location:admin.php?mode=$mode&adsess=$adsess&err_mess=$matt&T1=$pack_capt&T2=$amt&T3=$grp&T4=$list&T6=$nop&seid=$seid";
	}	else	{
		$sql_check="select * from member_package where package_nam='".addslashes($pack_capt)."' and package_id<>$seid";
		$res_check=mysql_query($sql_check);
		if(!mysql_num_rows($res_check))	{
			if(empty($grp))	$grp="N";
			if(empty($list))	$list="N";
			if(empty($eve))	$eve="N";
			if(empty($blog))	$blog="N";
			if(empty($chat))	$chat="N";
			if(empty($forum))	$forum="N";
			$sql_up="update member_package set package_nam='".addslashes($pack_capt)."',package_grp='".$grp."',package_list='".$list."',package_eve='".$eve."',package_blog='".$blog."',package_chat='".$chat."',package_forum='".$forum."',package_nphot=$nop,package_amt=$amt where package_id=$seid";
			mysql_query($sql_up);
			$matt="updation completed.";
			$hed="Location:admin.php?mode=$mode&adsess=$adsess&act=$act&seid=$seid&err_mess=$matt";
		}	else	{
			$matt="this package exists. please try with some other.";
			$hed="Location:admin.php?mode=$mode&adsess=$adsess&err_mess=$matt&act=$act&T1=$pack_capt&T2=$amt&T3=$grp&T4=$list&T6=$nop&seid=$seid";
		}
	}
  break;
  case 'Modify Pack':
	$sql_up="update member_details set mem_pack=$pack where mem_id=$seid";
	mysql_query($sql_up);
	$matt="updation completed.";
	$hed="Location:index.php?act=$act&seid=$seid&err_mess=$matt";
  break;
  case 'rem':
	$mode="package_manager";
  	$sql_testirem="delete from member_package where package_id=$seid";
	mysql_query($sql_testirem);
	$matt="removal completed";
	$hed="Location:admin.php?mode=$mode&adsess=$adsess&page=$page&err_mess=$matt";
  break;
}
header($hed);
exit;
?>