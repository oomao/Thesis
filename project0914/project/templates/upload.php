<!DOCTYPE html>
<html>
<head>
    <title>Upload and Evaluate Paper</title>
    <style>
        body {
            display: flex;
        }
        .left-panel {
            flex: 1;
            padding: 20px;
        }
        .right-panel {
            flex: 1;
            padding: 20px;
            border-left: 1px solid #ddd;
            display: none; /* 初始隱藏 */
        }
        .spinner {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            display: none;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="left-panel">
        <h1>論文評分功能</h1>
        <form id="uploadForm" enctype="multipart/form-data">
            <input type="file" name="file" accept="application/pdf" />
            <input type="submit" value="Upload and Evaluate" />
        </form>

        <div class="spinner" id="spinner"></div>
        <div id="result"></div>

        <button id="runModelsButton" style="display: none;">Run Models</button>
    </div>

    <div class="right-panel" id="selected-sections">
        <h2>選中的章節</h2>
    </div>

    <script>
        let titlesData = [];

        async function uploadAndEvaluate(event) {
            event.preventDefault();
            const fileInput = document.querySelector('input[name="file"]');
            const file = fileInput.files[0];

            if (!file) {
                alert('Please select a file.');
                return;
            }

            const spinner = document.getElementById('spinner');
            spinner.style.display = 'block';

            const formData = new FormData();
            formData.append('file', file);

            try {
                const response = await fetch('/evaluate_paper', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();
                const resultDiv = document.getElementById('result');
                resultDiv.innerHTML = '';

                if (result.error) {
                    resultDiv.innerHTML = `<p style="color: red;">Error: ${result.error}</p>`;
                } else {
                    resultDiv.innerHTML = `<p style="color: green;">${result.message}</p>`;

                    titlesData = result.titles;

                    titlesData.forEach((title, index) => {
                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.id = `title_${index}`;
                        checkbox.name = 'titles';
                        checkbox.value = index;

                        const label = document.createElement('label');
                        label.htmlFor = `title_${index}`;
                        label.textContent = title.title;

                        // 當勾選框狀態改變時，更新選中的章節
                        checkbox.addEventListener('change', updateSelectedSections);

                        resultDiv.appendChild(checkbox);
                        resultDiv.appendChild(label);
                        resultDiv.appendChild(document.createElement('br'));
                    });

                    document.getElementById('runModelsButton').style.display = 'block';
                }
            } catch (error) {
                console.error('Error:', error);
                const resultDiv = document.getElementById('result');
                resultDiv.innerHTML = `<p style="color: red;">Error: ${error.message}</p>`;
            } finally {
                spinner.style.display = 'none';
            }
        }

        function updateSelectedSections() {
            const selectedDiv = document.getElementById('selected-sections');
            selectedDiv.innerHTML = '<h2>選中的章節</h2>';
            let hasSelected = false;

            titlesData.forEach((title, index) => {
                const checkbox = document.getElementById(`title_${index}`);
                if (checkbox && checkbox.checked) {
                    hasSelected = true;

                    // 在右側區域中創建相同的複選框
                    const selectedCheckbox = document.createElement('input');
                    selectedCheckbox.type = 'checkbox';
                    selectedCheckbox.checked = true;
                    selectedCheckbox.addEventListener('change', function () {
                        checkbox.checked = false; // 同步取消左側的勾選
                        updateSelectedSections(); // 更新顯示
                    });

                    const label = document.createElement('label');
                    label.textContent = title.title;

                    const sectionItem = document.createElement('div');
                    sectionItem.appendChild(selectedCheckbox);
                    sectionItem.appendChild(label);
                    selectedDiv.appendChild(sectionItem);
                }
            });

            // 如果有選中的項目，顯示右側面板，否則隱藏
            selectedDiv.style.display = hasSelected ? 'block' : 'none';
        }

        async function runModels() {
            const selectedTitles = titlesData.map((title, index) => {
                const checkbox = document.getElementById(`title_${index}`);
                title.selected = checkbox.checked;  // 更新選中狀態
                return title;
            });

            try {
                const response = await fetch('/run_models', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ sections: selectedTitles })
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();
                const resultDiv = document.getElementById('result');
                resultDiv.innerHTML = `<p style="color: green;">${result.message}</p>`;
                
                // 顯示勾選的章節及其 AI 率
                const selectedDiv = document.getElementById('selected-sections');
                selectedDiv.innerHTML = '<h2>選中的章節</h2>';
                result.results.forEach(section => {
                    selectedDiv.innerHTML += `<p>${section.title}: ${section.ai_probability.toFixed(2)}</p>`;
                });
            } catch (error) {
                console.error('Error:', error);
                alert(`Error: ${error.message}`);
            }
        }

        document.querySelector('#uploadForm').addEventListener('submit', uploadAndEvaluate);
        document.querySelector('#runModelsButton').addEventListener('click', runModels);
    </script>
</body>
</html>
