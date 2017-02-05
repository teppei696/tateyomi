<?php

$size = 22;
$x = 24;
$image = "bg_640_520_1.jpg";
$point1 = 21;
$point2 = 110;
$point3 = 57;
$point4 = 350;
$thickness = 3;
$y1 = 100;
$y2 = 140;
$y3 = 180;
$y4 = 220;
$y5 = 260;
$y6 = 300;
$y7 = 340;
$y8 = 380;
$y9 = 420;
$y10 = 460;
$text1 = "交際費の５０％非課税効果";
$text2 = "ある？ＨＫＴ若田部遥卒業";
$text3 = "し学業専念橋本マナミ変え";
$text4 = "た２７歳の決意ポケＧＯ「";
$text5 = "はやり過ぎ」の危機君の名";
$text6 = "は。中国＆タイで新記録憧";
$text7 = "れは俊輔１９歳にマンＵ注";
$text8 = "目";
$text9 = "";
$text10 = "";

$img = imagecreatefromjpeg($image);

# 必要に応じてUTF8へ変換(環境依存)
$text = mb_convert_encoding($text, 'UTF-8', 'auto');

# 黒い文字を書き込む
$black = imagecolorallocate($img, 51, 51, 51);
imagettftext($img, $size, 0, $x, $y1, $black,'font1.ttc', $text1);
imagettftext($img, $size, 0, $x, $y2, $black,'font1.ttc', $text2);
imagettftext($img, $size, 0, $x, $y3, $black,'font1.ttc', $text3);
imagettftext($img, $size, 0, $x, $y4, $black,'font1.ttc', $text4);
imagettftext($img, $size, 0, $x, $y5, $black,'font1.ttc', $text5);
imagettftext($img, $size, 0, $x, $y6, $black,'font1.ttc', $text6);
imagettftext($img, $size, 0, $x, $y7, $black,'font1.ttc', $text7);
imagettftext($img, $size, 0, $x, $y8, $black,'font1.ttc', $text8);
imagettftext($img, $size, 0, $x, $y9, $black,'font1.ttc', $text9);
imagettftext($img, $size, 0, $x, $y10, $black,'font1.ttc', $text10);

# 赤い四角を描画
// 四角形の線の色を指定（ここでは赤色）
$red = imagecolorallocate($img, 255, 0, 0);
imagesetthickness($img, $thickness);
// 画像リソースに四角形を描画
imagerectangle($img,$point1,$point2,$point3,$point4,$red);

$out = ImageCreateTrueColor(1040, 846);
ImageCopyResampled($out, $img, 0,0,0,0, 1040, 846, 640, 520);

error_log("old x: " . ImageSx($img));
error_log("old y: " . ImageSy($img));
error_log("new x: " . ImageSx($out));
error_log("new y: " . ImageSy($out));


header('Content-Type: image/jpeg');
imagejpeg($out);

?>
