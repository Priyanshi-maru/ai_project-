<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
if (!isset($_SESSION['quiz_id'])) {
    header('Location: index.php');
    exit();
}
header('Content-Type: text/html; charset=utf-8');
include "db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results - AI Quiz Generator</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <div class="quiz-header">
            <h1>Assessment Results</h1>
            <p>Candidate: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        </div>
<?php
$quiz_id = $_SESSION['quiz_id'];
$result = $conn->query("SELECT * FROM quizzes WHERE quiz_id = '$quiz_id' ORDER BY id ASC");

$score = 0;
$total = $result->num_rows;
$questions_data = [];

while($row = $result->fetch_assoc()) {
    $qid = "q" . $row['id'];
    $user_answer = isset($_POST[$qid]) ? $_POST[$qid] : "Not Answered";
    $is_correct = false;

    if($user_answer !== "Not Answered" && $user_answer == $row['correct_answer']) {
        $is_correct = true;
        $score++;
    }

    $questions_data[] = [
        'question' => $row['question'],
        'user_answer' => $user_answer,
        'correct_answer' => $row['correct_answer'],
        'explanation' => $row['explanation'],
        'is_correct' => $is_correct
    ];
}

// Save result to database
$username = $conn->real_escape_string($_SESSION['username']);
$quiz_id_escaped = $conn->real_escape_string($quiz_id);
$percentage = ($total > 0) ? ($score / $total * 100) : 0;
$conn->query("INSERT INTO results(username, quiz_id, score, total, percentage) VALUES('$username', '$quiz_id_escaped', $score, $total, $percentage)");

// Display score
$percent = ($total > 0) ? round($percentage, 1) : 0;
$score_class = ($percent == 100) ? 'perfect' : '';

echo "<div class='score-card $score_class'>";
echo "<div class='score-value'>$percent%</div>";
echo "<div class='score-text'>You scored $score out of $total questions correct</div>";
echo "</div>";

// Display Explainable AI Answers
echo "<div class='explanations-container'>";
echo "<h2 class='explanations-title'>Detailed Explanations</h2>";

$q_num = 1;
foreach ($questions_data as $q) {
    $card_class = $q['is_correct'] ? 'correct' : 'incorrect';
    $user_ans_class = $q['is_correct'] ? 'correct-text' : 'incorrect-text';
    
    echo "<div class='explanation-card $card_class'>";
    echo "<div class='question-text'>Q$q_num. " . htmlspecialchars($q['question']) . "</div>";
    
    echo "<div class='answer-row'>";
    echo "<div class='answer-label'>Your Answer:</div>";
    echo "<div class='answer-value $user_ans_class'>" . htmlspecialchars($q['user_answer']) . "</div>";
    echo "</div>";
    
    if (!$q['is_correct']) {
        echo "<div class='answer-row'>";
        echo "<div class='answer-label'>Correct Answer:</div>";
        echo "<div class='answer-value correct-text'>" . htmlspecialchars($q['correct_answer']) . "</div>";
        echo "</div>";
    }
    
    if (!empty($q['explanation']) && $q['explanation'] !== 'N/A') {
        echo "<div class='ai-explanation'>";
        echo "<div class='ai-explanation-title'>";
        echo "<svg viewBox='0 0 24 24'><path fill='currentColor' d='M11,18H13V16H11V18M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M12,6A4,4 0 0,0 8,10H10A2,2 0 0,1 12,8A2,2 0 0,1 14,10C14,12 11,11.75 11,15H13C13,12.75 16,12.5 16,10A4,4 0 0,0 12,6Z' /></svg>";
        echo "AI Explanation";
        echo "</div>";
        echo htmlspecialchars($q['explanation']);
        echo "</div>";
    }
    
    echo "</div>";
    $q_num++;
}
echo "</div>";

// Clear quiz session
unset($_SESSION['quiz_id']);
?>
        <div class="action-buttons">
            <a href="index.php"><button type="button" class="btn-auto">Take Another Quiz</button></a>
        </div>
    </div>
</body>
</html>
