<?php
    require 'includes/init.php';

    if(isset($_SESSION['user_id']) && isset($_SESSION['email'])){
        $user_data = $user_obj->find_user_by_id($_SESSION['user_id']);
        if($user_data ===  false){
            header('Location: logout.php');
            exit;
        }
    }
    else{
        header('Location: logout.php');
        exit;
    }
    // TOTAL REQUESTS
    $get_req_num = $frnd_obj->request_notification($_SESSION['user_id'], false);
    // TOTAL FRIENDS
    $get_frnd_num = $frnd_obj->get_all_friends($_SESSION['user_id'], false);
    $get_all_req_sender = $frnd_obj->request_notification($_SESSION['user_id'], true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo  $user_data->username;?></title>
    <link rel="stylesheet" href="./style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <script src="/socket.io/socket.io.js"></script>
    <script>
        var socket = io();
    </script>
    <style>
        /* Reset */
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
    
        /* Layout */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative; /* 設置父容器為相對定位 */
        }
    
        #container {
            width: 500px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative; /* 設置容器為相對定位 */
        }
    
        /* Header */
        #status-box {
            padding: 10px;
            text-align: right;
            font-size: 0.8em;
            color: #666;
        }
    
        /* Content */
        #content {
            height: 300px; /* 減少高度以容納底部登出按鈕 */
            overflow-y: auto;
            padding: 10px;
        }
    
        .msg {
            margin-bottom: 10px;
        }
    
        .msg > .name {
            font-weight: bold;
            color: #333;
        }
    
        .msg > .datetime {
            float: right;
            font-size: 0.8em;
            color: #999;
            margin-left: 10px;
        }
    
        /* Footer */
        #send-box {
            padding: 10px;
            border-top: 1px solid #ddd;
        }
    
        #send-form {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    
        input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 0.9em;
        }
    
        input#name {
            width: 25%;
            margin-right: 5px;
        }
    
        input#msg {
            flex: 1;
            margin-right: 5px;
        }
    
        input[type="submit"] {
            padding: 8px 15px;
            background-color: #3b6b91;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 0.9em;
            cursor: pointer;
        }
    
        input[type="submit"]:hover {
            background-color: #0f2b44;
        }
    
        /* 登出按鈕樣式 */
        #logout-btn {
            position: absolute; /* 設置絕對定位 */
            top: 10px; /* 與頂部距離 */
            right: 10px; /* 與右側距離 */
            padding: 8px 15px;
            background-color: #3b6b91;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 0.9em;
            cursor: pointer;
        }
    
        #logout-btn:hover {
            background-color: #0f2b44;
        }
    </style>
</head>
<body>
    <div class="profile_container">
        <!-- <div class="inner_profile">
            <div class="img">
                <img src="profile_images/<?php echo $user_data->user_image; ?>" alt="Profile image">
            </div>
            <h1><?php echo  $user_data->username;?></h1>
        </div> -->
        <nav>
            <ul>
                <li><a href="profile.php" rel="noopener noreferrer">首頁</a></li>
                <li><a href="notifications.php" rel="noopener noreferrer">好友邀請<span class="badge <?php
                if($get_req_num > 0){
                    echo 'redBadge';
                }
                ?>"><?php echo $get_req_num;?></span></a></li>
                <li><a href="friends.php" rel="noopener noreferrer">好友<span class="badge"><?php echo $get_frnd_num;?></span></a></li>
                <li><a href="chatroom.php" rel="noopener noreferrer" class="active">訊息</a></li>
                <li><a href="logout.php" rel="noopener noreferrer">登出</a></li>
            </ul>
        </nav>
        <div class="all_users">
            <div id="container">
                <div id="status-box">Server: <span id="status">-</span> / <span id="online">0</span> online.</div>
                <div id="content">
                </div>
                <div id="send-box">
                    <form id="send-form">
                        <input type="text" name="name" id="name" placeholder="name">
                        <input type="text" name="msg" id="msg" placeholder=".....">
                        <input type="submit" value="Send">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
 
            var status = document.getElementById("status");
            var online = document.getElementById("online");
            var sendForm = document.getElementById("send-form");
            var content = document.getElementById("content");
            var msgInput = document.getElementById("msg");
 
            socket.on("connect", function () {
                status.innerText = "Connected.";
            });
 
            socket.on("disconnect", function () {
                status.innerText = "Disconnected.";
            });
 
            socket.on("online", function (amount) {
                online.innerText = amount;
            });

            socket.on("msg", function (d) {
                var msgBox = document.createElement("div");
                msgBox.className = "msg";

                var nameBox = document.createElement("span");
                nameBox.className = "name";
                nameBox.innerText = d.name;

                var msgText = document.createTextNode(": " + d.msg);

                var datetimeBox = document.createElement("span");
                datetimeBox.className = "datetime";
                var now = new Date();
                var formattedDate = now.getFullYear() + '/' + (now.getMonth() + 1) + '/' + now.getDate() + ' ' + now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();
                datetimeBox.innerText = '(' + formattedDate + ')';

                msgBox.appendChild(nameBox);
                msgBox.appendChild(msgText);
                msgBox.appendChild(datetimeBox);
                content.appendChild(msgBox);
            });

            sendForm.addEventListener("submit", function (e) {
                e.preventDefault();
            
                var ok = true;
                var formData = {};
                var formChild = sendForm.children;
            
                for (var i=0; i< sendForm.childElementCount; i++) {
                    var child = formChild[i];
                    if (child.name !== "") {
                        var val = child.value;
                        if (val === "" || !val) {    // 如果值為空或不存在
                            ok = false;
                            child.classList.add("error");
                        } else {
                            child.classList.remove("error");
                            formData[child.name] = val;
                        }
                    }
                }
            
                // ok 為真才能送出
                if (ok) socket.emit("send", formData);
            });
        });
    </script>
</body>
</html>
