<?php

$size = $_GET['size'];
$x = $_GET['x'];
$y = $_GET['y'];
$image = $_GET['image'];
$text = $_GET['text'];
$point1 = $_GET['point1'];
$point2 = $_GET['point2'];
$point3 = $_GET['point3'];
$point4 = $_GET['point4'];

$img = imagecreatefromjpeg($image);

# 必要に応じてUTF8へ変換(環境依存)
$text = mb_convert_encoding($text, 'UTF-8', 'auto');

# 黒い文字を書き込む
$black = imagecolorallocate($img, 0, 0, 0);
imagettftext($img, $size, 0, $x, $y, $black,'ipagp.ttf', $text);

# 赤い四角を描画
// 四角形の線の色を指定（ここでは赤色）
$red = imagecolorallocate($img, 255, 0, 0);
// 画像リソースに四角形を描画
imagerectangle($img,$point1,$point2,$point3,$point4,$red);



header('Content-Type: image/jpeg');
imagejpeg($img);

?>
