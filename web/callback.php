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
	$image = "image.php?size=24&x=24&y=100&image=bg_640_520_1.jpg&text=%E6%96%87%E5%AD%97%E5%88%97%E3%82%92%E6%9B%B8%E3%81%8D%E8%BE%BC%E3%81%BF%E3%81%BE%E3%81%99%E3%80%82&point1=25&point2=55&point3=60&point4=300";


  $response_format_text = [
    "type" => "image",
    "originalContentUrl" => "https://" . $_SERVER['SERVER_NAME'] . $image,
		"previewImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . $image
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
