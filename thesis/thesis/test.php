<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>排版輔助</title>
</head>
<style>
    body {
        font-size: 16px;
        font-family: 'PingFang TC', 'Heiti TC', '微軟正黑體', sans-serif;
        /* font-weight: bold; */
        text-align: center;
    }

    .form-step {
        display: none;
    }

    .form-step.active {
        display: block;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentStep = 0;
        const formSteps = document.querySelectorAll(".form-step");
        const prevBtn = document.getElementById("prevBtn");
        const nextBtn = document.getElementById("nextBtn");
        const submitBtn = document.getElementById("submitBtn");

        function showStep(step) {
            formSteps.forEach((formStep, index) => {
                formStep.classList.toggle("active", index === step);
            });
            prevBtn.style.display = step === 0 ? "none" : "inline-block";
            nextBtn.style.display = step === formSteps.length - 1 ? "none" : "inline-block";
            submitBtn.style.display = step === formSteps.length - 1 ? "inline-block" : "none";
        }

        function validateStep(step) {
            const inputs = formSteps[step].querySelectorAll("input, textarea");
            for (let input of inputs) {
                if (!input.value) {
                    alert("請填寫所有字段");
                    return false;
                }
            }
            return true;
        }

        function changeStep(direction) {
            if (direction === 1 && !validateStep(currentStep)) {
                return;
            }
            currentStep = Math.max(0, Math.min(formSteps.length - 1, currentStep + direction));
            showStep(currentStep);
        }

        prevBtn.addEventListener("click", () => changeStep(-1));
        nextBtn.addEventListener("click", () => changeStep(1));

        showStep(currentStep);
    });
</script>

<body>
    <?php include 'navbar.php';?>
    <br>
    <h2>Input Data to Generate PDF</h2>
    <div class="container mt-5">
        <form id="multiStepForm" action="/thesis/latex_templete/untitled folder/generate_pdf.php" method="post">
            <div class="form-step active">
                <label for="dept">Department:</label><br>
                <input class="form-control" type="text" id="dept" name="dept" required><br>
                <label for="degree">Degree:</label><br>
                <input class="form-control" type="text" id="degree" name="degree" required><br>
                <label for="title">Title:</label><br>
                <input class="form-control" type="text" id="title" name="title" required><br>
                <label for="subtitle">Subtitle:</label><br>
                <input class="form-control" type="text" id="subtitle" name="subtitle" required><br>
                <label for="author">Author:</label><br>
                <input class="form-control" type="text" id="author" name="author" required><br>
            </div>
            <div class="form-step">
                <label for="mprof">Main Professor:</label><br>
                <input class="form-control" type="text" id="mprof" name="mprof" required><br>
                <label for="sprofi">Co-Professor I:</label><br>
                <input class="form-control" type="text" id="sprofi" name="sprofi" required><br>
                <label for="sprofii">Co-Professor II:</label><br>
                <input class="form-control" type="text" id="sprofii" name="sprofii" required><br>
                <label for="degreedate">Degree Date:</label><br>
                <input class="form-control" type="text" id="degreedate" name="degreedate" required><br>
                <label for="copyyear">Copy Year:</label><br>
                <input class="form-control" type="text" id="copyyear" name="copyyear" required><br>
            </div>
            <div class="form-step">
                <label for="abstract1">Abstract (Chinese):</label><br>
                <textarea class="form-control" id="abstract1" name="abstract1" rows="4" cols="50" required></textarea><br><br>
            </div>
            <div class="form-step">
                <label for="abstract2">Abstract (English):</label><br>
                <textarea class="form-control" id="abstract2" name="abstract2" rows="4" cols="50" required></textarea><br><br>
            </div>
            <div class="form-step">
                <label for="acknowledge">Acknowledgements:</label><br>
                <textarea class="form-control" id="acknowledge" name="acknowledge" rows="4" cols="50" required></textarea><br><br>
            </div>
            <div class="form-step">
                <label for="introduction">Introduction:</label><br>
                <textarea class="form-control" id="introduction" name="introduction" rows="4" cols="50" required></textarea><br><br>
            </div>
            <div class="form-step">
                <label for="relateWork">Related Work:</label><br>
                <textarea class="form-control" id="relateWork" name="relateWork" rows="4" cols="50" required></textarea><br><br>
            </div>
            <div class="form-step">
                <label for="approach">Approach:</label><br>
                <textarea class="form-control" id="approach" name="approach" rows="4" cols="50" required></textarea><br><br>
            </div>
            <div class="form-step">
                <label for="conclusion">Conclusion:</label><br>
                <textarea class="form-control" id="conclusion" name="conclusion" rows="4" cols="50" required></textarea><br><br>
            </div>
            <div class="justify-content-between mt-3">
                <button type="button" class="btn btn-outline-secondary fw-bold" id="prevBtn" onclick="changeStep(-1)">上一頁</button>
                <button type="button" class="btn btn-outline-secondary fw-bold" id="nextBtn" onclick="changeStep(1)">下一頁</button>
                <input type="submit" class="btn btn-outline-secondary fw-bold" id="submitBtn" value="送出" style="display: none;">
            </div>
        </form>
    </div>
</body>
</html>