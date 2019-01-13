<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>メール送信完了｜メール送信フォーム</title>
</head>
<body>

<?php

require_once("./../php/MailService.php");


/*******************************
 データの受け取り 
*******************************/
$namae = $_POST["username"];		//お名前
$mailaddress = $_POST["usermail"];	//メールアドレス
$naiyou = $_POST["naiyou"];		//メッセージ

//エスケープ
$namae = htmlspecialchars($namae, ENT_QUOTES);
$mailaddress = htmlspecialchars($mailaddress, ENT_QUOTES);
$naiyou = htmlspecialchars($naiyou, ENT_QUOTES);


/*******************************
 値加工
*******************************/
//メールタイトル
$title = $namae . "さんからお問い合わせフォームからの連絡"; 
//メール本文作成
$body = createBody($namae, $mailaddress, $naiyou);
//メール宛先
$to = "chikatamoto@yahoo.co.jp";
//メールfromアドレス
$from = "no-reply@toiawaseform";

/*******************************
 メール送信の実行
*******************************/
$mailsousin = new MailService($to, "", $title, $body, $from);

//送信成功の場合trueが、失敗の場合エラーメッセージが返ってくる
$mailRet = $mailsousin->send();
if($mailRet === true) {
	echo '<p>お問い合わせメールを送信しました。</p>';
} else {
	echo '<p>メール送信でエラーが発生しました。</p>';
	echo '<p>' . $mailRet . '</p>';
}





/**
 * メール本文を加工します
 */
function createBody($namae, $mailaddress, $naiyou)
{
	$retBodyStr = "";
	
	$retBodyStr .="メールフォームよりお問い合わせがありました。";
	$retBodyStr .="\n\n";
	$retBodyStr .="【お名前】\n";
	$retBodyStr .= $namae;
	$retBodyStr .="\n\n";
	$retBodyStr .="【メールアドレス】\n";
	$retBodyStr .= $mailaddress;
	$retBodyStr .="\n\n";
	$retBodyStr .="【お問い合わせ内容】\n";
	$retBodyStr .= $naiyou;

	return $retBodyStr;

}



?>

</body>
</html>