<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>論文推薦&查詢</title>
</head>
<style>
    body {
        font-size: 16px;
        font-family: 'PingFang TC', 'Heiti TC', '微軟正黑體', sans-serif;
        /* font-weight: bold; */
        text-align: center;
    }
    .input-container {
        margin-bottom: 20px;
    }
    .output-container {
        border: 1px solid #ccc;
        padding: 10px;
        min-height: 100px;
        /* overflow-y: auto; */
    }
</style>

<script>
    function search(actionType) {
        if(actionType == 'search'){
            var inputText = document.getElementById('inputText').value;
            var selectedField = document.querySelector('input[name="thesis"]:checked');

            if (!selectedField) {
                alert('請選擇一個搜尋欄位');
                return;
            }

            if (!inputText) {
                alert('請在輸入框中輸入文字');
                return;
            }

            document.getElementById('actionType').value = actionType;
            document.getElementById('searchForm').submit();
        }else{
            var inputText = document.getElementById('inputText').value;

            if (!inputText) {
                alert('請在輸入框中輸入文字');
                return;
            }

            document.getElementById('actionType').value = actionType;
            document.getElementById('searchForm').submit();
        }
    }
</script>

<body>
    <?php include '../navbar.php';?>
    <div class="container-fluid mt-3 input-container">
        <form id="searchForm" action="search.php" method="POST">
        <div class="row mb-3 mt-3">
                <div class="col-md-12 d-flex justify-content-center align-items-center">
                    <input class="form-control me-2" type="text" id="inputText" placeholder="Enter text..." name="inputText" style="width: 300px;">
                    <input type="hidden" id="actionType" name="actionType">
                    <button type="button" class="btn btn-outline-secondary fw-bold me-2" onclick="search('search')">搜尋</button>
                    <button type="button" class="btn btn-outline-secondary fw-bold" onclick="search('recommend')">類似論文推薦</button>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md- d-flex justify-content-center">
                    <div class="form-check">
                        <input type="radio" id="paper_zh" name="thesis" value="paper_zh">
                        <label class="form-check-label" for="paper_zh">論文名稱</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="paper_en" name="thesis" value="paper_en">
                        <label class="form-check-label" for="paper_en">外文論文名稱</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="school" name="thesis" value="school">
                        <label class="form-check-label" for="school">學校</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="department" name="thesis" value="department">
                        <label class="form-check-label" for="department">系所</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="author" name="thesis" value="author">
                        <label class="form-check-label" for="author">作者</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="advisor" name="thesis" value="advisor">
                        <label class="form-check-label" for="advisor">指導教授</label>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="output-container " id="outputText">
        <!-- Output will appear here -->
        <?php
        require_once("../dbtools.inc.php");

        // 建立資料連接
        $link = create_connection();

        // 獲取使用者的輸入
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $inputText = $_POST["inputText"];
            $actionType = $_POST["actionType"];

            if ($actionType == 'search') {
                $thesis = $_POST["thesis"];
                // 搜尋的SQL語句
                $sql = "SELECT * FROM `paper_data` WHERE `$thesis` = '$inputText'";
                $result = execute_sql($link, "thesis", $sql);

                // 檢查結果並輸出
                if (mysqli_num_rows($result) > 0) {
                    echo "<div class='row'>";
                    echo "<div class='col-sm-1'></div>";
                    echo "<div class='col-sm-10'>";
                    echo "<table class='table table-bordered mt-3'>";
                    echo "<tr><th>論文名稱</th><th>外文論文名稱</th><th>學校</th><th>系所</th><th>作者</th><th>指導老師</th></tr>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['paper_zh']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['paper_en']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['school']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['department']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['author']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['advisor']) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                    echo "<div class='col-sm-1'></div>";
                    echo "</div>";
                } else {
                    echo "No results found.";
                }

                // 釋放資源並關閉連接
                mysqli_free_result($result);
            } elseif ($actionType == 'recommend') {
                // 類似論文推薦的邏輯
                echo "類似論文推薦功能尚未實現";
            }
        }

        // 關閉資料庫連接
        mysqli_close($link);
        ?>
    </div>
</body>
</html>
