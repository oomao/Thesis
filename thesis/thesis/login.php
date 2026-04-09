<?php
    require 'friend/includes/init.php';

    $errorMessage = ''; // 儲存錯誤訊息

    // IF USER MAKING LOGIN REQUEST
    if(isset($_POST['email']) && isset($_POST['password'])){
        $result = $user_obj->loginUser($_POST['email'],$_POST['password']);
        if (isset($result['errorMessage'])) {
            $errorMessage = $result['errorMessage'];
        }
    }
    // IF USER ALREADY LOGGED IN
    if(isset($_SESSION['email'])){
        header('Location: index.php');
        exit;
    }


    // session_start();
    // require_once("dbtools.inc.php");
    // //header("Content-type: text/html; charset=utf-8");
          
    // //取得表單資料
    // $user_email = $_POST["email"];
    // $user_password = $_POST["pwd"];
    
    // //建立資料連接
    // $link = create_connection();
    
    // //檢查帳號密碼是否正確
    // $sql = "SELECT * FROM `users` Where `user_email` = '$user_email' AND `user_password` = '$user_password'";
    // $result = execute_sql($link, "thesis", $sql);

    // $sql2 = "SELECT * FROM `users` Where `user_email` = '$user_email'";
    // $result2 = execute_sql($link, "thesis", $sql2);

    // //如果帳號密碼錯誤
    // if (mysqli_num_rows($result) == 0) {
    //     //釋放 $result 佔用的記憶體
    //     mysqli_free_result($result);
        
    //     //關閉資料連接
    //     mysqli_close($link);
        
    //     //顯示訊息要求使用者輸入正確的帳號密碼
    //     echo "<script type='text/javascript'>";
    //     echo "alert('帳號密碼錯誤，請查明後再登入');";
    //     echo "window.location.href = 'login1.php';";
    //     echo "</script>";
    // }

    // while ($row = mysqli_fetch_object($result)) {
    //     $row2 = mysqli_fetch_object($result2);
    //     $_SESSION["uname"]=$row->username;
    //     $_SESSION["nick"]=$row->nickname;
    //     $_SESSION["user_id"]=$row2->userId;
    //     $_SESSION["user_password"]=$row2->user_password;
    //     $_SESSION["email"]=$row2->user_email;
    // }
    // //釋放 $result 佔用的記憶體
    // mysqli_free_result($result);
    
    // //關閉資料連接
    // mysqli_close($link);
    // header(("location:  main.php"));
    // 在循环之外进行页面重定向
    // header("Location: index.php");
    // exit(); // 确保页面重定向后立即退出脚本执行
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>成功登入</title>
  </head>
  <body>
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
                    window.location.href = "index.php";
                  </script>';
            exit;
          }
        ?>
    </div>
  </body>
</html>