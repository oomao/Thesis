<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keyword Recommendation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }

        .input-container {
            margin-bottom: 20px;
        }

        .output-container {
            border: 1px solid #ccc;
            padding: 10px;
            min-height: 100px;
            overflow-y: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        .spinner {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            display: none;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <script>
        async function findKeywords() {
            const text = document.getElementById("inputKeywordText").value;
            const mode = document.getElementById("searchMode").value;
            const spinner = document.getElementById("spinner");
            const outputDiv = document.getElementById("outputText");

            outputDiv.innerHTML = "";
            spinner.style.display = "block";

            const response = await fetch('/search_back', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ text: text, mode: mode })
            });

            const result = await response.json();
            spinner.style.display = "none";
            displayKeywordResult(result);
        }

        function displayKeywordResult(result) {
            const outputDiv = document.getElementById("outputText");

            if (Array.isArray(result.keywords)) {
                outputDiv.innerHTML = "<p>Keywords:</p><p>" + result.keywords.join(", ") + "</p>";
            } else if (typeof result.keywords === 'string') {
                outputDiv.innerHTML = "<p>Keywords:</p><p>" + result.keywords + "</p>";
            } else {
                outputDiv.innerHTML = "<p>Keywords:</p><p>Unexpected response format</p>";
            }

            if (Array.isArray(result.results) && result.results.length > 0) {
                const table = document.createElement('table');
                const thead = document.createElement('thead');
                const tbody = document.createElement('tbody');

                thead.innerHTML = `
                    <tr>
                        <th>Paper (ZH)</th>
                        <th>Paper (EN)</th>
                        <th>URL</th>
                    </tr>
                `;

                result.results.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.paper_zh}</td>
                        <td>${item.paper_en}</td>
                        <td><a href="${item.url}" target="_blank">Link</a></td>
                    `;
                    tbody.appendChild(row);
                });

                table.appendChild(thead);
                table.appendChild(tbody);
                outputDiv.appendChild(table);
            } else {
                outputDiv.innerHTML += "<p>No results found</p>";
            }
        }
    </script>
</head>
<body>
    <div class="input-container">
        <label for="inputKeywordText">Input:</label>
        <input type="text" id="inputKeywordText" placeholder="Enter text...">
        <br><br>
        <label for="searchMode">Select Search Mode:</label>
        <select id="searchMode">
            <option value="precise">精準</option>
            <option value="moderate">適中</option>
            <option value="fuzzy">模糊</option>
        </select>
        <button onclick="findKeywords()">Confirm</button>
    </div>
    <div class="spinner" id="spinner"></div>
    <div class="output-container" id="outputText"></div>
</body>
</html>
