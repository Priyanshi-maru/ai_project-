<?php
session_start();
include "db.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_SESSION['username'];
    $num_questions = intval($_POST['num_questions']);
    $difficulty = $_POST['difficulty'];

    // Upload file
    $file = $_FILES['file'];
    $upload_dir = "uploads/";
    $filename = basename($file['name']);
    $file_path = $upload_dir . $filename;

    move_uploaded_file($file['tmp_name'], $file_path);

    // 🔹 STEP 1: Extract Text
    $python_path = "C:\\Users\\PIYU\\AppData\\Local\\Programs\\Python\\Python310\\python.exe";

    $text = shell_exec("\"$python_path\" backend/extract_text.py \"$file_path\"");

    if (!$text || strlen($text) < 100) {
        die("❌ Text extraction failed");
    }

    // 🔥 FIXED STEP 2 (NO escapeshellarg, NO 8192 ERROR)
    $cmd = "\"$python_path\" backend/generate_mcq.py $num_questions $difficulty";

    $descriptorspec = [
        0 => ["pipe", "r"],
        1 => ["pipe", "w"],
        2 => ["pipe", "w"]
    ];

    $process = proc_open($cmd, $descriptorspec, $pipes);

    if (is_resource($process)) {

        // SAFE LARGE TEXT INPUT
        fwrite($pipes[0], $text);
        fclose($pipes[0]);

        $output = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        fclose($pipes[2]);

        proc_close($process);

    } else {
        die("❌ Python execution failed");
    }

    // 🔥 SAFE JSON CHECK (IMPORTANT FIX)
    $questions = json_decode($output, true);

    if (!is_array($questions)) {
        die("❌ Question generation failed (Invalid JSON output)");
    }

    // 🔹 STEP 3: Create Quiz Session
    $quiz_id = uniqid("quiz_");

    $stmt = $conn->prepare("INSERT INTO quiz_sessions 
        (quiz_id, username, filename, difficulty, num_questions) 
        VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $quiz_id, $username, $filename, $difficulty, $num_questions);
    $stmt->execute();

    $_SESSION['quiz_id'] = $quiz_id;

    // 🔹 STEP 4: Insert Questions (SAFE VERSION)
    $stmtQ = $conn->prepare("INSERT INTO quizzes 
        (quiz_id, question, option1, option2, option3, option4, correct_answer, explanation) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($questions as $q) {

        // 🔥 SAFETY CHECK (PREVENT NULL ERROR)
        if (!isset($q['q']) || !isset($q['options']) || !is_array($q['options'])) {
            continue;
        }

        $question = $q['q'];
        $options = $q['options'];

        $opt1 = $options[0] ?? "N/A";
        $opt2 = $options[1] ?? "N/A";
        $opt3 = $options[2] ?? "N/A";
        $opt4 = $options[3] ?? "N/A";

        $answer = $q['answer'] ?? $opt1;
        $explanation = $q['explanation'] ?? "";

        // 🔥 FINAL VALIDATION (IMPORTANT)
        if (!$question || !$opt1) {
            continue;
        }

        $stmtQ->bind_param(
            "ssssssss",
            $quiz_id,
            $question,
            $opt1,
            $opt2,
            $opt3,
            $opt4,
            $answer,
            $explanation
        );

        $stmtQ->execute();
    }

    header("Location: quiz.php");
    exit();
}
?>