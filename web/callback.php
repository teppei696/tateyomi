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
if ($text == '天気を教えて'
 			|| $text == '2017/02/06の天気を見る'
			|| $text == '2017/02/07の天気を見る'
			|| $text == '2017/02/08の天気を見る') {
	// 画像情報
	$image = "image.php?" . date("YmdHis");

  //$response_format_text = [
  //  "type" => "image",
  //  "originalContentUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/" . $image,
	//	"previewImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/" . $image
  //];
$url = "https://" . $_SERVER['SERVER_NAME'] . "/hare.json";
$json = file_get_contents($url);
$json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$arr = json_decode($json,true);

$title = [];
if ($arr === NULL) {
	return;
} else {
	$json_count = count($arr["articles"]);
	for ($i = 0; $i < $json_count; $i++) {
		$title[] = $arr["articles"][$i]["url"];
	}
}




	$response_format_text = [
    "type" => "imagemap",
    "baseUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/" . $image,
		"altText" => "縦読み天気予報",
	  "baseSize" => [
			"width" => 1040,
			"height" => 846
	  ],
		"actions" => [
	      [
	          "type" => "uri",
	          "linkUri" => $title[0],
	          "area" => [
	              "x" => 36,
	              "y" => 110,
	              "width" => 600,
	              "height" => 70
	          ]
	      ],
	      [
					"type" => "uri",
					"linkUri" => $title[1],
	          "area" => [
	              "x" => 36,
	              "y" => 180,
	              "width" => 600,
	              "height" => 70
	          ]
	      ],
				[
						"type" => "uri",
						"linkUri" => $title[2],
						"area" => [
								"x" => 36,
								"y" => 250,
								"width" => 600,
								"height" => 70
						]
				],
				[
						"type" => "uri",
						"linkUri" => $title[3],
						"area" => [
								"x" => 36,
								"y" => 320,
								"width" => 600,
								"height" => 70
						]
				],
				[
						"type" => "uri",
						"linkUri" => $title[4],
						"area" => [
								"x" => 36,
								"y" => 390,
								"width" => 600,
								"height" => 70
						]
				]
	  ]
  ];
} elseif ($text == '今週の天気を教えて') {
	// 画像情報
	$image = "image.php?" . date("YmdHis");

  //$response_format_text = [
  //  "type" => "image",
  //  "originalContentUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/" . $image,
	//	"previewImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/" . $image
  //];
	$response_format_text = [
		"type" => "template",
		"altText" => "縦読み天気予報",
		"template" => [
			"type" => "carousel",
			"columns" => [
				[
					"thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/" . $image,
					"title" => "天気予報",
					"text" => "月曜日の天気予報",
					"actions" => [
						[
							"type" => "message",
							"label" => "もっと詳細にみる",
							"text" => "2017/02/06の天気を見る"
						]
					]
				],
				[
					"thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/" . $image,
					"title" => "天気予報",
					"text" => "火曜日の天気予報",
					"actions" => [
						[
							"type" => "message",
							"label" => "もっと詳細にみる",
							"text" => "2017/02/07の天気を見る"
						]
					]
				],
				[
					"thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/" . $image,
					"title" => "天気予報",
					"text" => "水曜日の天気予報",
					"actions" => [
						[
							"type" => "message",
							"label" => "もっと詳細にみる",
							"text" => "2017/02/08の天気を見る"
						]
					]
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
