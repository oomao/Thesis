<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>登入</title>

    <style>
        html, body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .form-container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<script>
    // Replace the current history state
    window.history.replaceState({}, document.title, window.location.pathname);
    // Push a new history state
    window.history.pushState({}, document.title, window.location.pathname);

    window.addEventListener('popstate', function() {
        window.history.pushState({}, document.title, window.location.pathname);
    });
</script>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-container col-md-4">
                <center><h2>使用者登入</h2></center>
                <!-- <form name="login" method="post" action="http://192.168.0.101:3000/login.php"> -->
                <form name="login" method="post" action="login.php">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="email" placeholder="Enter email" name="email" required>
                        <label class="text-secondary" for="email">Email</label>
                    </div>
                    <div class="form-floating mt-3">
                        <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
                        <label class="text-secondary" for="password">Password</label>
                    </div>
                    <center><button type="submit" class="btn btn-outline-dark mt-3">登入</button></center>
                    <center class="mt-2">尚未註冊？</center>
                    <hr>
                    <center><button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#registerModal">註冊</button></center>
                </form>
            </div>
        </div>
    </div>

    <!-- 註冊 -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="registerModalLabel">註冊</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- <form name="register" method="post" action="http://192.168.0.101:3000/register.php"> -->
                    <form name="register" method="post" action="register.php"> 
                        <div class="mb-3">
                            <input type="text" class="form-control form-control-lg" placeholder="姓名" name="username" spellcheck="false" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control form-control-lg" placeholder="信箱" name="email" spellcheck="false" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control form-control-lg" minlength="8" maxlength="20" placeholder="密碼(長度8~20)" name="password" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control form-control-lg" minlength="8" maxlength="20" placeholder="請再次輸入密碼" name="password2" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control form-control-lg" placeholder="暱稱" name="nickname" required>
                        </div>
                        <div class="mb-3">
                            <input type="date" class="form-control form-control-lg" name="bday" required>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-auto">
                                <div class="form-check">
                                    <input type="radio" id="Male" name="sex" value="1" class="form-check-input">
                                    <label class="form-check-label" for="Male">Male</label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-check">
                                    <input type="radio" id="Female" name="sex" value="0" class="form-check-input">
                                    <label class="form-check-label" for="Female">Female</label>
                                </div>
                            </div>
                        </div>
                        <center><button type="submit" class="btn btn-outline-dark">註冊</button></center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
