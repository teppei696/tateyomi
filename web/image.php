<?php

$size = $_GET['size'];
$x = $_GET['x'];
$image = $_GET['image'];
$point1 = $_GET['point1'];
$point2 = $_GET['point2'];
$point3 = $_GET['point3'];
$point4 = $_GET['point4'];
$y1 = $_GET['y1'];
$text1 = $_GET['text1'];
$y2 = $_GET['y2'];
$text2 = $_GET['text2'];
$y3 = $_GET['y3'];
$text3 = $_GET['text3'];
$y4 = $_GET['y4'];
$text4 = $_GET['text4'];
$y5 = $_GET['y5'];
$text5 = $_GET['text5'];
$y6 = $_GET['y6'];
$text6 = $_GET['text6'];
$y7 = $_GET['y7'];
$text7 = $_GET['text7'];
$y8 = $_GET['y8'];
$text8 = $_GET['text8'];
$y9 = $_GET['y9'];
$text9 = $_GET['text9'];
$y10 = $_GET['y10'];
$text10 = $_GET['text10'];

$img = imagecreatefromjpeg($image);

# 必要に応じてUTF8へ変換(環境依存)
$text = mb_convert_encoding($text, 'UTF-8', 'auto');

# 黒い文字を書き込む
$black = imagecolorallocate($img, 0, 0, 0);
imagettftext($img, $size, 0, $x, $y1, $black,'ipagp.ttf', $text1);
imagettftext($img, $size, 0, $x, $y2, $black,'ipagp.ttf', $text2);
imagettftext($img, $size, 0, $x, $y3, $black,'ipagp.ttf', $text3);
imagettftext($img, $size, 0, $x, $y4, $black,'ipagp.ttf', $text4);
imagettftext($img, $size, 0, $x, $y5, $black,'ipagp.ttf', $text5);
imagettftext($img, $size, 0, $x, $y6, $black,'ipagp.ttf', $text6);
imagettftext($img, $size, 0, $x, $y7, $black,'ipagp.ttf', $text7);
imagettftext($img, $size, 0, $x, $y8, $black,'ipagp.ttf', $text8);
imagettftext($img, $size, 0, $x, $y9, $black,'ipagp.ttf', $text9);
imagettftext($img, $size, 0, $x, $y10, $black,'ipagp.ttf', $text10);

# 赤い四角を描画
// 四角形の線の色を指定（ここでは赤色）
$red = imagecolorallocate($img, 255, 0, 0);
// 画像リソースに四角形を描画
imagerectangle($img,$point1,$point2,$point3,$point4,$red);



header('Content-Type: image/jpeg');
imagejpeg($img);

?>
