<?php
require 'friend/includes/init.php';
if(isset($_SESSION['user_id']) && isset($_SESSION['email'])){
    $user_data = $user_obj->find_user_by_id($_SESSION['user_id']);
    // if($user_data ===  false){
    //     header('Location: logout.php');
    //     exit;
    // }
    // FETCH ALL USERS WHERE ID IS NOT EQUAL TO MY ID
    $all_users = $user_obj->all_users($_SESSION['user_id']);
}
else{
    echo "123";
    // header('Location: logout.php');
    // exit;
}
// REQUEST NOTIFICATION NUMBER
$get_req_num = $frnd_obj->request_notification($_SESSION['user_id'], false);
// TOTAL FRIENDS
$get_frnd_num = $frnd_obj->get_all_friends($_SESSION['user_id'], false);
?>

<style>
    .custom-dropdown-menu {
        width: 100px; /* 設定固定寬度或根據需要調整 */
        max-width: 100vw; /* 限制最大寬度為視窗寬度 */
        white-space: nowrap; /* 防止內容換行 */
        overflow-x: auto; /* 如果內容超過寬度，顯示水平滾動條 */
        left: auto; /* 確保選單不會超出螢幕範圍 */
        right: 0; /* 確保選單靠近右邊界 */
    }

    .dropdown-menu {
        position: absolute; /* 使下拉選單脫離常規流 */
        transform: translateX(-25%); /* 調整選單位置，使其對齊 */
    }

    .dropdown-menu hr {
        margin: 1px 10px; /* 調整邊距以縮進 <hr> */
        width: calc(100% - 20px); /* 設定 <hr> 寬度，留出邊距 */
        border: 0; /* 去除預設邊框 */
        border-top: 1px solid #424651; /* 設定 <hr> 顏色 */
    }
</style>

<nav class="navbar navbar-expand-sm bg-light navbar-light">
    <div class="container-fluid">
        <ul class="navbar-nav me-auto">
            <a class="navbar-brand" href="/thesis/index.php">
                <img src="/thesis/images/study.png" alt="Logo" style="width:50px;" class="rounded">
            </a>
            <li class="nav-item fw-bold">
                <a class="nav-link" href="/thesis/function1/search.php">
                    <img src="/thesis/images/magnifier.png" style="width:20px;" class="rounded">
                    <br>
                    論文推薦功能
                </a>
            </li>
            <li class="nav-item fw-bold">
                <a class="nav-link" href="http://127.0.0.1:5000/ai_detector">
                    <img src="/thesis/images/AI.png" style="width:20px;" class="rounded">
                    <br>
                    ai偵測功能
                </a>
            </li>
            <li class="nav-item fw-bold">
                <a class="nav-link" href="/thesis/test.php">
                    <img src="/thesis/images/left.png" style="width:20px;" class="rounded">
                    <br>
                    論文排版輔助
                </a>
            </li>
            <li class="nav-item fw-bold">
                <a class="nav-link" href="http://127.0.0.1:5000/upload">
                    <img src="/thesis/images/scores.png" style="width:20px;" class="rounded">
                    <br>
                    論文評分功能
                </a>
            </li>
            <li class="nav-item fw-bold">
                <a class="nav-link" href="#">
                    <img src="/thesis/images/robot.png" style="width:20px;" class="rounded">
                    <br>    
                    論文聊天機器人
                </a>
            </li>
            <li class="nav-item fw-bold">
                <a class="nav-link" href="#">
                    <img src="/thesis/images/group.png" style="width:20px;" class="rounded">
                    <br>   
                    社群
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="/thesis/friend/profile_images/<?php echo $user_data->user_image; ?>" alt="Profile image" style="width:40px;" class="rounded-circle img-thumbnail">
                    <?php echo  $user_data->username;?>
                </a>
                <ul class="dropdown-menu custom-dropdown-menu" aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-item" href="/thesis/friend/profile.php">好友</a>
                    </li>
                    <hr>
                    <li>
                        <a class="dropdown-item" href="/thesis/logout.php">登出</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
