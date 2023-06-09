<?
/********************************************************
	file
	(C) 1999-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

	PURPOSE:
		Provide strings for "source/prefs.php" and "source/pref_colors.php"
		
********************************************************/

$prefHeaderStrings = array(
											0=> "設定",
											1=>"一般",
											2=>"表示色"
											);
											
$prefsStrings = array(
									"0.0" => "ユーザー",
									"0.1" => "名前: ",
									"0.2" => "Email: ",
									"1.0" => "言語",
									"1.1" => "インターフェース言語: ",
									"1.2" => "標準文字コード: ",
									"1.3" => "時差: ",
									"2.0" => "リスト表示",
									"2.1" => "最高",
									"2.2" => " 件ずつ表示",
									"2.3" => "容量を表示",
									"2.4" => "",
									"2.5" => "順にソート",
									"2.6" => "",
									"2.7" => "表示",
									"2.8" => "フォルダーリストを表示",
									"3.0" => "オートセーブ機能",
									"3.1" => "送信済みアイテムを保存",
									"3.2"=> "送信済みアイテムは ",
									"3.3" => "フォルダに保存",
									"3.4" => "自動的にゴミ箱を空にする",
									"3.5" => "削除済みアイテムは",
									"3.6" => "フォルダーに移動",
									"3.7" => "ルートディレクトリ：",
									"3.8" => "その他",
									"4.0" => "メッセージ表示",
									"4.1" => "フレーム内で表示",
									"4.2" => "引用文を識別",
									"4.3" => "このオプションを選択すると処理に時間が掛かる事があります。",
									"4.4" => "自動的にURLを認識",
									"4.5" => "HTMLメールをフレーム内で表示",
									"4.6" => "添付画像をフレーム内で表示",
									"5.0" => "署名",
									"5.1" => "デフォルトで表示",
									"5.2" => "メッセージ作成ウインドウで署名の有無を選択する事もできます"
									);
									
$sort_fields=array("DATE"=>"日付け", "SUBJECT"=>"件名", "SIZE"=>"容量");
$sort_orders=array("ASC"=>"昇順", "DESC"=>"降順");

$prefsButtonStrings = array( 0=> "更新", 1=> "すぐに反映", 2=>"キャンセル", 3=>"デフォルト");

$prefs_new_user = "ようこうそ！";
$prefs_new_user .= "以下の設定を行ってから「すぐに反映」ボタンにクリックしてください。";
?>