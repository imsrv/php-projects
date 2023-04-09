<?
/********************************************************
	lang/jp/main.inc
	(C) 1999-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

	PURPOSE:
		Provide strings for "source/main.php"

********************************************************/

function formatStatusString($num, $folder, $type){
	$str="";
	if ($type=="delete"){
		$str = "メッセージ".$num."件削除しました";
	}else if ($type == "move"){
		$str = $folder."にメッセージ".$num."件移動しました";
	}
	
	return $str;
}

$mainStrings=array(
	0=>"%n件中%p表示",
	1=>"件見つかりました",
	2=>"前の",
	3=>"件",
	4=>"次の",
	5=>"件",
	6=>"件名",
	7=>"宛先",
	8=>"送信者",
	9=>"日付け",
	10=>"削除",
	11=>"ゴミ箱を空に",
	12=>"移動",
	13=>"検索",
	14=>"容量",
	15=>"件名未指定",
	16=>"表示",
	17=>"新着チェック",
	18=>"全て消去",
	19=>"キャンセル"
);

$mainErrors=array(
	0=>"この該当メッセージはありません",
	1=>"このフォルダーにメッセージはありません",
	2=>"メッセージの削除に失敗しました",
	3=>"メッセージの削除に失敗しました",
	4=>"メッセージの移動に失敗しました",
	5=>"ゴミ箱フォルダーが指定されていません",
	6=>"ゴミ箱を空にする事ができませんでした",
	7=>"「%f」フォルダ内の全てのメッセージを消去してよろしいですか？"
);
?>