<?php
session_start();
date_default_timezone_set("America/Toronto");
require_once 'dbConnection.php';

//If user is not loggid in, will be re-directed to login page
if (!isset($_SESSION['userType']) && !isset($_SESSION['userID'])) {
    header('Location: login.php');
}

$dbcon = Database::connectDB();

if (isset($_POST['surveySubmit'])){
    
    foreach ($_POST as $q=>$a) {
        if($q !== "surveySubmit")
            Database::insertAnswer($a, $q , $_SESSION['userID']);
    }
    header('Location: list.php');
}else{
    if (!isset($_POST['takeSurvey']))
        header('Location: list.php');

    $survey = Database::getSurvey($_POST['id']);
    $title = $survey->title;
    $category = Database::getCategoryName($survey->category_id);
    $creator = Database::getUserName($survey->user_id);
    $description = $survey->description;

    $questions = Database::getQuestions($survey->id);
//var_dump($questions);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/darkly/bootstrap.min.css">
    <link rel="stylesheet" href="css/takeSurvey.css">

    <title>Take Survey</title>
</head>

<body>

    <main id="takeSurvey">
        <!-- Intro Card -->
        <div id="surveyIntro" class="card text-white bg-primary mb-3" style="max-width: 20rem;">

            <div class="card-body">
                <h4 class="card-title"><?= $title ?></h4>
                <p class="card-text"><?= $description ?></p>
            </div>
            <div class="card-header">Created by <?= $creator ?></div>
            <div class="card-header"><?= $category ?></div>
        </div>
        <div class="surveyCancelLink"><a href="list.php">Go back to the list without taking survey</a></div>

        <!-- Survey Form -->
        <form method="post">

            <?php foreach ($questions as $index => $question) { ?>

                <fieldset class="form-group question">
                    <legend class="questionNo">Question <?= $index + 1 ?></legend>
                    <legend><?= $question->question_text ?></legend>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="<?= $question->id ?>" value="1" required>
                            Strongly Disagree
                        </label>
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="<?= $question->id ?>" value="2">
                            Disagree
                        </label>
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="<?= $question->id ?>" value="3">
                            Neutral
                        </label>
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="<?= $question->id ?>" value="4">
                            Agree
                        </label>
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="<?= $question->id ?>" value="5">
                            Strongly Agree
                        </label>
                    </div>

                </fieldset>

            <?php } ?>

            <button id="surveySubmit" name="surveySubmit" type="submit" class="btn btn-success btn-lg">Submit</button>
            <div class="surveyCancelLink"><a href="list.php">Go back to the list without taking survey</a></div>
        </form>
    </main>


</body>

</html>