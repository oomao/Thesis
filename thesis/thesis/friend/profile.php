<?php
    // require 'includes/init.php';
    // if(isset($_SESSION['user_id']) && isset($_SESSION['email'])){
    //     $user_data = $user_obj->find_user_by_id($_SESSION['user_id']);
    //     // if($user_data ===  false){
    //     //     header('Location: logout.php');
    //     //     exit;
    //     // }
    //     // FETCH ALL USERS WHERE ID IS NOT EQUAL TO MY ID
    //     $all_users = $user_obj->all_users($_SESSION['user_id']);
    // }
    // else{
    //     echo "123";
    //     // header('Location: logout.php');
    //     // exit;
    // }
    // // REQUEST NOTIFICATION NUMBER
    // $get_req_num = $frnd_obj->request_notification($_SESSION['user_id'], false);
    // // TOTAL FRIENDS
    // $get_frnd_num = $frnd_obj->get_all_friends($_SESSION['user_id'], false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>朋友</title>
    <!-- <link rel="stylesheet" href="./style.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet"> -->
</head>
<style>
    body {
        font-size: 16px;
        font-family: 'PingFang TC', 'Heiti TC', '微軟正黑體', sans-serif;
        /* font-weight: bold; */
        text-align: center;
    }

    .sidebar {
        width: 250px;
        height: 800vh;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #f8f9fa;
        padding-top: 20px;
        margin-top: 80px;
    }

    .badge {
    background: #FFF;
    display: inline-block;
    padding: 0 5px;
    margin-left: 3px;
    color: #000;
    border-radius: 20px;
}
</style>
<body>
    <?php include '../navbar.php'; ?>
    <div class="container-fluid mt-3">
        <div class="row mb-3 mt-3">
            <!-- <div class="inner_profile">
                <div class="img">
                    <img src="profile_images/<?php echo $user_data->user_image; ?>" alt="Profile image">
                </div>
                <h1><?php echo  $user_data->username;?></h1>
            </div> -->
            <div class="sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item fw-bold"><a class="nav-link" href="notifications.php" rel="noopener noreferrer">交友邀請<span class="badge <?php
                    if($get_req_num > 0){
                        echo 'redBadge';
                    }
                    ?>"><?php echo $get_req_num;?></span></a></li>
                    <li class="nav-item fw-bold"><a class="nav-link" href="friends.php" rel="noopener noreferrer">所有朋友<span class="badge"><?php echo $get_frnd_num;?></span></a></li>
                    <li class="nav-item fw-bold"><a class="nav-link" href="chatroom.php" rel="noopener noreferrer">訊息</a></li>
                </ul>
            </div>
        </div>
        <div class="all_users">
            <h3>所有用戶</h3>
            <div class="usersWrapper">
                <?php
                if($all_users){
                    foreach($all_users as $row){
                        echo '<div class="user_box">
                                <div class="user_img"><img src="profile_images/'.$row->user_image.'" alt="Profile image"></div>
                                <div class="user_info"><span>'.$row->username.'</span>
                                <span><a href="user_profile.php?id='.$row->id.'" class="see_profileBtn">查看個人檔案</a></div>
                            </div>';
                    }
                }
                else{
                    echo '<h4>查無使用者！</h4>';
                }
                ?>
            </div>
        </div>
        
    </div>
</body>
</html>