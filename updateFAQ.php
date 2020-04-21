<?php

//DEVELOPER: Michael Pavlovic


session_start();

//add if statement to check if user is logged in - if not redirect to login page
if(!isset($_SESSION['userID']) && !isset($_SESSION['username']) && !isset($_SESSION['userType'])){
    header('Location:signin.php');
}
//add if statement to check if user is an admin - if not deny access
if($_SESSION['userType'] == 0){
    header('Location:index.php');
}

require_once 'dbConnection.php';
require_once 'classes/FAQ.php';

//initialize variables
$question = $answer = '';
$questionerr = $answererr = '';

//check if form data from manageHome page is set
if (isset($_POST['updateFAQ'])) {
    //get id from that form
    $id = $_POST['id'];

    //connect to db
    $dbcon = Database::getDb();

    //get specific faq data based on id
    $f = new FAQ();
    $faq = $f->showFAQ($dbcon, $id);

    //set form data to db values
    $question = $faq->question;
    $answer = $faq->answer;
}

//check if form on update page is set
if (isset($_POST['updFAQ'])) {
    //get form inputs
    $question = $_POST['question'];
    $answer = $_POST['answer'];
    $id = $_POST['id'];

    //connect to db
    $dbcon = Database::getDb();

    //update in db
    $f = new FAQ();
    $count = $f->updateFAQ($dbcon, $id, $question, $answer);

    //if updated, redirect to manageHome
    if ($count) {
        header('Location:manageHome.php');
    } else {
        echo 'Could not update record';
    }
}
?>
<html lang="en">
<head>
    <title>SurveyBobby</title>
    <meta charset="utf-8">
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/darkly/bootstrap.min.css" rel="stylesheet" integrity="sha384-rCA2D+D9QXuP2TomtQwd+uP50EHjpafN+wruul0sXZzX/Da7Txn4tB9aLMZV4DZm" crossorigin="anonymous">
</head>
<body>
<?php include_once 'header.php'; ?>
    <main class="m-5">
        <h1 class="h3">Update a frequently asked question:</h1>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?= $id; ?>"/>
            <div class="form-group">
                <label for="question">Question: </label>
                <input class="form-control" type="text" id="question" name="question" value="<?= $question; ?>"
                       placeholder="Enter a question...">
                <span style="color: red"><?= $questionerr; ?></span>
            </div>
            <div class="form-group">
                <label for="answer">Answer: </label>
                <input class="form-control" type="text" id="answer" name="answer" value="<?= $answer; ?>"
                       placeholder="Enter an answer...">
                <span style="color: red"><?= $answererr; ?></span>
            </div>
            <div>
                <button class="btn btn-primary btn-lg" type="submit" id="btn-submit" name="updFAQ">Update</button>
                <a href="manageHome.php" id="btn_back" class="btn btn-secondary btn-lg">Back</a>
            </div>
        </form>
    </main>
<?php include_once 'footer.php'; ?>
</body>
</html>