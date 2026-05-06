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

include "db.php"; 

$quiz_id = $_SESSION['quiz_id'];

// Fetch questions
$stmt = $conn->prepare("SELECT * FROM quizzes WHERE quiz_id = ? ORDER BY id ASC");
$stmt->bind_param("s", $quiz_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - <?php echo htmlspecialchars($_SESSION['username']); ?></title>
    <link rel="stylesheet" href="assets/style.css">

    <!-- 🔒 SECURITY + PRIVACY MODE -->
    <script>
    // Disable right click
    document.addEventListener('contextmenu', e => e.preventDefault());

    // Disable copy, paste, cut, view source
    document.onkeydown = function(e) {
        if (e.ctrlKey && ['c','v','x','u','s'].includes(e.key.toLowerCase())) {
            return false;
        }
    };

    // Disable text selection
    document.addEventListener('selectstart', e => e.preventDefault());

    // Auto submit if tab switch
    let submitted = false;
    document.addEventListener("visibilitychange", function() {
        if (document.hidden && !submitted) {
            submitted = true;
            alert("⚠️ Tab switched! Quiz will be submitted.");
            document.forms[0].submit();
        }
    });

    // Fullscreen mode
    window.onload = function() {
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        }
    };
    </script>
</head>

<body>
    <div class="container">
        <div class="quiz-header">
            <h1>Quiz Assessment</h1>
            <p>Candidate: <?php echo htmlspecialchars($_SESSION['username']); ?> • Answer all questions before submitting</p>
        </div>

<?php if ($result && $result->num_rows > 0): ?>
<form action="result.php" method="POST">

<?php 
$question_count = 1;
while($row = $result->fetch_assoc()) { 
?>

<div class="question-block">
    <p>
        <span style="color: var(--primary); margin-right: 8px;">Q<?php echo $question_count; ?>.</span> 
        <?php echo htmlspecialchars($row['question']); ?>
    </p>

    <?php if (!empty($row['option1']) && $row['option1'] !== 'N/A'): ?>
    <label class="option-label">
        <input type="radio" name="q<?php echo $row['id']; ?>" 
        value="<?php echo htmlspecialchars($row['option1']); ?>" required>
        <?php echo htmlspecialchars($row['option1']); ?>
    </label>
    <?php endif; ?>

    <?php if (!empty($row['option2']) && $row['option2'] !== 'N/A'): ?>
    <label class="option-label">
        <input type="radio" name="q<?php echo $row['id']; ?>" 
        value="<?php echo htmlspecialchars($row['option2']); ?>">
        <?php echo htmlspecialchars($row['option2']); ?>
    </label>
    <?php endif; ?>

    <?php if (!empty($row['option3']) && $row['option3'] !== 'N/A'): ?>
    <label class="option-label">
        <input type="radio" name="q<?php echo $row['id']; ?>" 
        value="<?php echo htmlspecialchars($row['option3']); ?>">
        <?php echo htmlspecialchars($row['option3']); ?>
    </label>
    <?php endif; ?>

    <?php if (!empty($row['option4']) && $row['option4'] !== 'N/A'): ?>
    <label class="option-label">
        <input type="radio" name="q<?php echo $row['id']; ?>" 
        value="<?php echo htmlspecialchars($row['option4']); ?>">
        <?php echo htmlspecialchars($row['option4']); ?>
    </label>
    <?php endif; ?>
</div>

<?php $question_count++; } ?>

<div style="text-align: right; margin-top: 30px;">
    <button type="submit" class="btn-auto">Submit Quiz</button>
</div>

</form>

<?php else: ?>
    <div style="text-align: center; padding: 40px;">
        <p>No quiz questions found!</p>
        <a href="index.php">Go back and upload a document</a>
    </div>
<?php endif; ?>

    </div>
</body>
</html>