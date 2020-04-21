<?php

//DEVELOPER: Michael Pavlovic

session_start();

//add if statement to check if user is logged in - if not redirect to login page
if(!isset($_SESSION['userID']) && !isset($_SESSION['username']) && !isset($_SESSION['userType'])){
    header('Location:signin.php');
}

require_once 'dbConnection.php';
require_once 'classes/Question.php';

//initialize variables
$questionerr = $question = "";

if(isset($_POST['updateQuestion'])) {
    $id = $_POST['id'];

    //connect to db
    $dbcon = Database::getDb();

    //get specific exp that was clicked on based on id
    $q = new Question();
    $ques = $q->showQuestion($dbcon, $id);

    //set form inputs to db values
    $question = $ques->question_text;
}
//check if form is set
if (isset($_POST['updQues'])) {
    //get form input
    $question = $_POST['question'];
    $id = $_POST['id'];

    $valid = "true";

    //if form input is empty return error message
    if ($question == "") {
        $questionerr = 'Please enter a question';
        $valid = false;
    }
    //if form input is valid add to database and redirect to manageHome
    if ($valid == true) {

        $dbcon = Database::getDb();

        $q = new Question();
        $count = $q->updateQuestion($dbcon, $id, $question);

        if ($count) {
            header('Location:userDashboard.php');
        } else {
            echo "Failed to insert data";
        }
    }
}
?>
<html lang="en">
<head>
    <title>SurveyBobby</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/footerStyle.css">
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/darkly/bootstrap.min.css" rel="stylesheet" integrity="sha384-rCA2D+D9QXuP2TomtQwd+uP50EHjpafN+wruul0sXZzX/Da7Txn4tB9aLMZV4DZm" crossorigin="anonymous">
</head>
<body>
<?php include_once 'header.php'; ?>
<main class="m-5">
    <h1 class="h3">Updating</h1>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= $id; ?>"/>
        <div class="form-group">
            <label for="section">Question: </label>
            <input class="form-control" type="text" id="question" name="question" value="<?= $question; ?>">
            <span style="color:red"><?= $questionerr; ?></span>
        </div>
        <div class="text-center">
            <button class="btn btn-primary btn-lg" type="submit" name="updQues">Update</button>
        </div>
    </form>
</main>
<?php include_once 'footer.php'; ?>
</body>
</html>