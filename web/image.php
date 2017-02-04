<?php

$size = $_GET['size'];
$x = $_GET['x'];
$y = $_GET['y'];
$image = $_GET['image'];

$img = imagecreatefromjpeg($image);

# 必要に応じてUTF8へ変換(環境依存)
$text = mb_convert_encoding('文字列を書き込む', 'UTF-8', 'auto');

# 黒い文字を書き込む
$black = imagecolorallocate($img, 0, 0, 0);
imagettftext($img, $size, 0, $x, $y, $black,'ipagp.ttf', $text);

header('Content-Type: image/jpeg');
imagejpeg($img);

?>
