<?php
  // require_once("dbtools.inc.php");
  require 'friend/includes/init.php';

  $errorMessage = ''; // 儲存錯誤訊息

  // 如果有提交表單
  if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['nickname']) && isset($_POST['bday']) && isset($_POST['sex'])) {
      // // 檢查驗證碼
      // if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'reg') {
      //     $checking = $_POST['captcha'];
      //     if ($_SESSION['CAPTCHA'] != $checking) {
      //         $errorMessage = '您輸入的驗證碼不正確，請再試一次。';
      //     } else {
              //確認密碼是否匹配
              echo "12333";
              if ($_POST['password'] !== $_POST['password2']) {
                  $errorMessage = '兩次輸入的密碼不同，請再試一次';
              } else {
                  $result = $user_obj->signUpUser($_POST['username'], $_POST['email'], $_POST['password'], $_POST['nickname'], $_POST['bday'], $_POST['sex']);
                  if (isset($result['errorMessage'])) {
                      $errorMessage = $result['errorMessage'];
                  }
              }
      //     }
      // }
  }

  // // 如果用戶已經登錄，重定向到個人資料頁面
  // if (isset($_SESSION['email'])) {
  //     header('Location: profile.php');
  //     exit;
  // }

  // // 包含 CAPTCHA 的代碼
  // if (!isset($_REQUEST['action']) || $_REQUEST['action'] != 'reg') {
  //     include('captcha.php');
  // }

  // //取得表單資料
  // $registerName = $_POST["registerName"];
  // $registerPwd = $_POST["registerPwd"];
  // $registerEmail = $_POST["registerEmail"];
  // $nickname = $_POST["nickname"];
  // $bday = $_POST["bday"];
  // $sex = $_POST["sex"];

  // //建立資料連接
  // $link = create_connection();

  // //檢查帳號是否有人申請
  // $sql = "SELECT * FROM users Where username = '$registerName'";
  // $result = execute_sql($link, "thesis", $sql);

  // //如果帳號已經有人使用
  // if (mysqli_num_rows($result) != 0)
  // {
  //   //釋放 $result 佔用的記憶體
  //   mysqli_free_result($result);

  //   //顯示訊息要求使用者更換帳號名稱 -- 直接產生網頁的程式碼！
  //   echo "<script type='text/javascript'>";
  //   echo "alert('您所指定的帳號已經有人使用，請使用其它帳號');";
  //   echo "history.back();";
  //   echo "</script>"; 
  // }

  // //如果帳號沒人使用
  // else
  // {
  //   //釋放 $result 佔用的記憶體
  //   mysqli_free_result($result);

  //   //執行 SQL 命令，新增此帳號
  //   $sql = "INSERT INTO `users` (`username`, `user_password`, `user_email`, `nickname`, `bday`, `sex`) 
  //   VALUES ('$registerName', '$registerPwd', '$registerEmail', '$nickname', '$bday', '$sex')";

  //   $result = execute_sql($link, "thesis", $sql);
  // }

  // //關閉資料連接
  // mysqli_close($link);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>新增帳號成功</title>
  </head>
  <style>
    p {
      font-size: 20px;
      font-family: sans-serif;
    }

    button {
            background-color: rgb(76, 117, 211);
            color: #fff;
            border: none;
            border-radius: 5px;
            padding:6px 122px;
            cursor: pointer;
            font-family: sans-serif;
            font-size: 20px;;
    }
  </style>
  <body bgcolor="#FFFFFF">
    <!-- <p align="center">恭喜您已經註冊成功了，您的資料如下：（請勿按重新整理鈕）<br>
      信箱：<font color="rgb(58, 117, 255)"><?php echo $registerEmail ?></font><br>
      密碼：<font color="rgb(58, 117, 255)"><?php echo $registerPwd ?></font><br>
      姓名：<font color="rgb(58, 117, 255)"><?php echo $registerName ?></font><br>
     </a>
    </p>
    <center><a href="login1.php"><button type="submit" href="">回到登入介面</button></a> </center> -->
      <div>  
        <?php
          // 檢查是否有錯誤訊息
          if (!empty($errorMessage)) {
            echo '<script type="text/javascript">
                    alert("'.$errorMessage.'");
                    window.location.href = "login1.php";
                  </script>';
            exit;
          }

          // 檢查是否有成功訊息
          if (isset($result['successMessage'])) {
            echo '<script type="text/javascript">
                    alert("'.$result['successMessage'].'");
                    window.location.href = "login1.php";
                  </script>';
            exit;
          }
        ?>
    </div>
  </body>
</html>