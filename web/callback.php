<?php
$accessToken = getenv('LINE_CHANNEL_ACCESS_TOKEN');

//ユーザーからのメッセージ取得
$json_string = file_get_contents('php://input');
$jsonObj = json_decode($json_string);

$type = $jsonObj->{"events"}[0]->{"message"}->{"type"};
//メッセージ取得
$text = $jsonObj->{"events"}[0]->{"message"}->{"text"};
//ReplyToken取得
$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};

//メッセージ以外のときは何も返さず終了
if($type != "text"){
	exit;
}


//返信データ作成
if ($text == '天気を教えて？') {
	// 画像情報
	$url1 = "image.php?";
	$url2 = "text1=" . urlencode("文字列を書き込みます１。");
	$url3 = "&text2=" . urlencode("文字列を書き込みます１。");
	$url4 = "&text3=" . urlencode("文字列を書き込みます１。");
	$url5 = "&text4=" . urlencode("文字列を書き込みます１。");
	$url6 = "&text5=" . urlencode("文字列を書き込みます１。");
	$url7 = "&text6=" . urlencode("文字列を書き込みます１。");
	$url8 = "&text7=" . urlencode("文字列を書き込みます１。");
	$url9 = "&text8=" . urlencode("文字列を書き込みます１。");

	$image = $url1 . $url2 . $url3 . $url4 . $url5 . $url6 . $url7 . $url8 . $url9;
  $response_format_text = [
    "type" => "image",
    "originalContentUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/" . $image,
		"previewImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/" . $image
  ];
} else {
	exit;
}

$post_data = [
	"replyToken" => $replyToken,
	"messages" => [$response_format_text]
	];

$ch = curl_init("https://api.line.me/v2/bot/message/reply");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
// Heroku Addon の Fixie のプロキシURLを指定。詳細は後述。
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_PROXY, getenv('FIXIE_URL'));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'Authorization: Bearer ' . $accessToken
    ));
$result = curl_exec($ch);
error_log("result: " . $result);


curl_close($ch);
