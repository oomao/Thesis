<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Detector</title>
    <style>
        .high-score { color: red; }
        .medium-score { color: yellow; }
        .info { margin-top: 10px; }
    </style>
    <script>
        async function getPrediction() {
            const text = document.getElementById("inputText").value;
            const response = await fetch('/AI_Detector', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ text: text })
            });

            const result = await response.json();
            displayResult(result);
        }

        function displayResult(result) {
            const resultDiv = document.getElementById("result");
            resultDiv.innerHTML = '';
            
            const sentences = Object.keys(result);
            sentences.reverse();
            const newContent = document.createElement('div');

            let countAboveThreshold = 0;

            sentences.forEach(sentence => {
                const p = document.createElement("p");
                p.textContent = sentence;
                p.classList.add("sentence");

                const score = result[sentence];
                if (score !== undefined) {
                    if (score >= 0.8) {
                        p.classList.add("high-score");
                        countAboveThreshold++;
                    } else if (score >= 0.4) {
                        p.classList.add("medium-score");
                        countAboveThreshold++;
                    }
                }

                newContent.appendChild(p);
            });

            resultDiv.appendChild(newContent);

            const infoDiv = document.getElementById("info");
            const totalSentences = sentences.length;
            const percentage = (countAboveThreshold / totalSentences) * 100;
            infoDiv.textContent = `有 ${countAboveThreshold} 句分數大於0.4，佔總句子數的 ${percentage.toFixed(2)}%。`;
        }
    </script>
</head>
<body>
    <h1>AI 偵測功能</h1>
    <textarea id="inputText" rows="10" cols="50"></textarea><br>
    <button onclick="getPrediction()">提交</button>
    <div id="result"></div>
    <div id="info" class="info"></div>
</body>
</html>
