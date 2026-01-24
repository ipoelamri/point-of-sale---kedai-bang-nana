<?php
$targetDir = __DIR__ . '/../storage/app/public/fotos';
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}
$targetFile = $targetDir . '/default.jpg';
$im = imagecreatetruecolor(300,200);
$bg = imagecolorallocate($im, 230, 230, 230);
imagefilledrectangle($im, 0, 0, 300, 200, $bg);
$textcolor = imagecolorallocate($im, 100, 100, 100);
imagestring($im, 5, 50, 90, 'default', $textcolor);
imagejpeg($im, $targetFile, 85);
imagedestroy($im);
echo "Wrote: $targetFile\n";
