<?php

require "helpers.php";

# from the $_SERVER global variable, check if the HTTP method used is POST, if its not POST, redirect to the index.php page
# Reference: https://www.php.net/manual/en/reserved.variables.server.php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$complete_name = $_POST['complete_name'];
$email = $_POST['email'];
$birthdate = $_POST['birthdate'];
$contact_number = $_POST['contact_number'];
$agree = $_POST['agree'];

$questions = retrieve_questions();
$questions_list = $questions['questions'];
?>
<html>
<head>
    <meta charset="utf-8">
    <title>IPT10 Laboratory Activity #3A</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css" />
</head>
<body>
<section class="section">
    <div class="container">
        <div class="level">
            <div class="level-left">
                <h1 class="title">Quiz</h1>
            </div>
            <div class="level-right">
                <div class="notification is-warning"style="background-color: #bbbbbbff;">
                    <p class="is-size-5">Time remaining: <span id="timer" class="has-text-weight-bold">60</span> seconds</p>
                </div>
            </div>
        </div>

        <form id="quiz-form" method="POST" action="result.php">
            <input type="hidden" name="complete_name" value="<?php echo htmlspecialchars($complete_name); ?>" />
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>" />
            <input type="hidden" name="birthdate" value="<?php echo htmlspecialchars($birthdate); ?>" />
            <input type="hidden" name="contact_number" value="<?php echo htmlspecialchars($contact_number); ?>" />
            <input type="hidden" name="agree" value="<?php echo htmlspecialchars($agree); ?>" />
            <input type="hidden" name="answers" id="answers_input" value="" />

            <?php foreach ($questions_list as $index => $q): ?>
            <div class="box mb-5">
                <h2 class="subtitle">
                    <strong>Question <?php echo $index + 1; ?>:</strong> <?php echo htmlspecialchars($q['question']); ?>
                </h2>

                <?php foreach ($q['options'] as $option): ?>
                <div class="field">
                    <div class="control">
                        <label class="radio">
                            <input type="radio"
                                name="q<?php echo $index; ?>"
                                value="<?php echo htmlspecialchars($option['key']); ?>" />
                                <?php echo htmlspecialchars($option['value']); ?>
                        </label>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>

            <div class="field mt-5">
                <button type="submit" id="btn-submit" class="button is-link">Submit Quiz</button>
            </div>
        </form>
    </div>
</section>

<script>
let timeLeft = 60;
const timerElement = document.getElementById('timer');
const quizForm = document.getElementById('quiz-form');
const totalQuestions = <?php echo count($questions_list); ?>;

function collectAnswers() {
    let answersStr = '';
    for (let i = 0; i < totalQuestions; i++) {
        const selected = document.querySelector('input[name="q' + i + '"]:checked');
        answersStr += selected ? selected.value : ' ';
    }
    document.getElementById('answers_input').value = answersStr;
}

quizForm.addEventListener('submit', function(e) {
    collectAnswers();
});

const countdown = setInterval(function() {
    timeLeft--;
    if (timerElement) {
        timerElement.textContent = timeLeft;
    }
    if (timeLeft <= 0) {
        clearInterval(countdown);
        collectAnswers();
        quizForm.submit();
    }
}, 1000);
</script>
</body>
</html>
