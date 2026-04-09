<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
    </style>
    <script>
        function navigateTo(page) {
            window.location.href = page;
        }
    </script>
</head>
<body>
    <h1>主畫面</h1>
    <button onclick="navigateTo('/ai_detector')">AI 偵測功能</button>
    <button onclick="navigateTo('/upload')">論文評分功能</button>
    <button onclick="navigateTo('/keyword_recommendation')">論文推薦功能</button>
    <button onclick="navigateTo('/form')">論文排版功能</button>
    <button onclick="navigateTo('/ai_chat')">AI聊天機器人</button>
</body>
</html>
