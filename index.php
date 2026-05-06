<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - AI Quiz Generator</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
    <div class="header-bar">
        <div class="user-info">
            Welcome, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>
        </div>
        <a href="logout.php">Logout</a>
    </div>
    
    <div style="text-align: center; margin-bottom: 40px;">
        <h1>AI Quiz Generator</h1>
        <p>Upload a document and let AI generate a customized quiz for you.</p>
    </div>
    
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>How many questions do you want?</label>
            <input type="number" name="num_questions" min="1" max="100" value="10" required>
        </div>

        <div class="form-group">
            <label>Difficulty Level</label>
            <select name="difficulty" required>
                <option value="Easy">Easy</option>
                <option value="Medium" selected>Medium</option>
                <option value="Hard">Hard</option>
            </select>
        </div>

        <div class="form-group">
            <label>Upload Document (PDF/DOCX)</label>
            <div class="file-upload-wrapper">
                <div class="custom-file-upload">
                    <svg style="width:24px;height:24px;margin-right:10px" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M13.5,16V19H10.5V16H8L12,12L16,16H13.5M13,9V3.5L18.5,9H13Z" />
                    </svg>
                    <span>Click or drag file to upload</span>
                </div>
                <input type="file" name="file" required>
            </div>
        </div>

        <button type="submit">Generate My Quiz</button>
    </form>
</div>
</body>
</html>