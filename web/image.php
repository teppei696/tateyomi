<?php

$img = ImageCreateFromJPEG('tenki1.jpg');

# 必要に応じてUTF8へ変換(環境依存)
$text = mb_convert_encoding('文字列を書き込む', 'UTF-8', 'auto');

# 白い文字を書き込む
$white = ImageColorAllocate($img, 0xff, 0xff, 0xff);
ImageTTFText($img, 16, 0, 5, 200, $white,'ipagp.ttf', $text);

header('Content-Type: image/jpeg');
ImageJPEG($img);

?>
