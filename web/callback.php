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
	$image = "image.php";
  //$response_format_text = [
  //  "type" => "image",
  //  "originalContentUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/" . $image,
	//	"previewImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/" . $image
  //];
	$response_format_text = [
    "type" => "imagemap",
    "baseUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/" . $image,
		"altText" => "縦読み天気予報",
	  "baseSize" = [
			"width" => 1040,
			"height" => 846
	  ],
		"actions" = [
	      [
	          "type" => "uri",
	          "linkUri" => "https://www.yahoo.co.jp/",
	          "area" = [
	              "x" => 0,
	              "y" => 0,
	              "width" => 520,
	              "height" => 846
	          ]
	      ],
	      [
					"type" => "uri",
					"linkUri" => "https://www.google.co.jp/",
	          "area" = [
	              "x" => 520,
	              "y" => 0,
	              "width" => 520,
	              "height" => 846
	          ]
	      ]
	  ]
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
