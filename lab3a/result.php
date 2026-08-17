<?php

require "helpers.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
}

// Supply the missing code
$complete_name = $_POST['complete_name'];
$email = $_POST['email'];
$birthdate = $_POST['birthdate'];
$contact_number = $_POST['contact_number'];
$agree = $_POST['agree'];
$answer = $_POST['answer'] ?? null;
$answers = $_POST['answers'] ?? null;
if (!is_null($answer)) {
    $answers .= $answer;
}

// Use the compute_score() function from helpers.php
$score = compute_score($answers);

$formatted_birthdate = !empty($birthdate) ? date("F d, Y", strtotime($birthdate)) : '';
$hero_class = ($score > 200 || ($score > 2 && $score <= 5)) ? 'is-success' : 'is-danger';
?>
<html>
<head>
    <meta charset="utf-8">
    <title>IPT10 Laboratory Activity #3A</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/confetti-js@0.0.18/site/site.min.css">
    <script src="https://cdn.jsdelivr.net/npm/confetti-js@0.0.18/dist/index.min.js"></script>
</head>
<body style="background-color: black; min-height: 100vh;">
<section class="hero <?php echo $hero_class; ?>">
    <div class="hero-body">
        <p class="title">Your Score <?php echo $score; ?></p>
        <p class="subtitle">This is the IPT10 PHP Quiz Web Application Laboratory Activity.</p>
    </div>
</section>
<section class="section">
    <div class="table-container">
        <table class="table is-bordered is-hoverable is-fullwidth">
            <tbody>
                <tr>
                    <th>Input Field</th>
                    <th>Value</th>
                </tr>
                <tr>
                    <td>Complete Name</td>
                    <td><?php echo $complete_name; ?></td>
                </tr>
                <tr class="is-selected">
                    <td>Email</td>
                    <td><?php echo $email; ?></td>
                </tr>
                <tr>
                    <td>Birthdate</td>
                    <td><?php echo $formatted_birthdate; ?></td>
                </tr>
                <tr>
                    <td>Contact Number</td>
                    <td><?php echo $contact_number; ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-container mt-5">
        <h3 class="title is-4">Questions Breakdown</h3>
        <table class="table is-bordered is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th>Correct Answer</th>
                    <th>Your Answer</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $questions_data = retrieve_questions();
                $all_questions = $questions_data['questions'] ?? [];
                $correct_answers = $questions_data['answers'] ?? [];
                foreach ($all_questions as $index => $q): 
                    $correct_key = $correct_answers[$index] ?? '';
                    $user_key = isset($answers[$index]) ? trim($answers[$index]) : '';
                    
                    $correct_text = $correct_key;
                    $user_text = ($user_key !== '') ? $user_key : 'No Answer';
                    
                    foreach ($q['options'] as $opt) {
                        if ($opt['key'] === $correct_key) {
                            $correct_text = $opt['key'] . ') ' . $opt['value'];
                        }
                        if ($opt['key'] === $user_key) {
                            $user_text = $opt['key'] . ') ' . $opt['value'];
                        }
                    }
                ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($q['question']); ?></td>
                    <td><?php echo htmlspecialchars($correct_text); ?></td>
                    <td><?php echo htmlspecialchars($user_text); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if ($score == 500 || $score == 5): ?>
    <canvas id="confetti-canvas"></canvas>
    <?php endif; ?>
</section>

<?php if ($score == 500 || $score == 5): ?>
<script>
var confettiSettings = {
    target: 'confetti-canvas'
};
var confetti = new ConfettiGenerator(confettiSettings);
confetti.render();
</script>
<?php endif; ?>
</body>
</html>
