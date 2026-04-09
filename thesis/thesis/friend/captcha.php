<?php
     // 檢查 PHP GD 套件是否已安裝
    if (!extension_loaded('gd')) {
        die('PHP GD 套件未安裝或未啟用。');
    }

    // 設定驗證碼影像寬度和高度
    $CaptchaWidth = 70;
    $CaptchaHeight = 20;

    // 生成驗證碼字串
    $CaptchaString = '';
    $CaptchaLength = 5;
    for ($i = 0; $i < $CaptchaLength; $i++) {
        $CaptchaString .= rand(0, 9);
    }

    // 將驗證碼字串存入 SESSION
    $_SESSION['CAPTCHA'] = $CaptchaString;

    // 創建影像資源
    $Captcha = imagecreate($CaptchaWidth, $CaptchaHeight);

    // 設定背景顏色和文字顏色
    $BackgroundColor = imagecolorallocate($Captcha, 255, 0, 0);
    $FontColor = imagecolorallocate($Captcha, 0, 0, 0);

    // 填充影像背景顏色
    imagefill($Captcha, 0, 0, $BackgroundColor);

    // 在影像上畫上驗證碼文字
    imagestring($Captcha, 6, 14, 3, $CaptchaString, $FontColor);

    // 添加雜訊點
    for ($i = 0; $i < 100; $i++) {
        imagesetpixel($Captcha, rand() % $CaptchaWidth, rand() % $CaptchaHeight, $FontColor);
    }

    // 輸出驗證碼影像並存儲到指定路徑
    $filename = sprintf('./images/check.png', time());
    imagepng($Captcha, $filename);
    imagedestroy($Captcha);
?>
