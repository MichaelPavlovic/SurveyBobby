<?php

//DEVELOPER: Michael Pavlovic

session_start();

//add if statement to check if user is logged in - if not redirect to login page
if(!isset($_SESSION['userID']) && !isset($_SESSION['username']) && !isset($_SESSION['userType'])){
    header('Location:signin.php');
}

//initialize variables
$questionerr = $question = "";

if(isset($_POST['addQuestion'])){
    $surveyid = $_POST['surveyid'];
}

//check if form is set
if (isset($_POST['addQues'])) {
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
        require_once 'dbConnection.php';
        require_once 'classes/Question.php';

        $dbcon = Database::getDb();

        $q = new Question();
        $count = $q->addQuestion($dbcon, $question, $id);

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
    <h1 class="h3">Add a new question:</h1>
    <form action="" method="post">
        <div class="form-group">
            <input type="hidden" id="id" name="id" value="<?= $surveyid; ?>">
            <label for="section">Question: </label>
            <input class="form-control" type="text" id="question" name="question"
                   placeholder="Enter a question...">
            <span style="color: red"><?= $questionerr; ?></span>
        </div>
        <div class="text-center">
            <button class="btn btn-success btn-lg" type="submit" name="addQues">Add</button>
        </div>
    </form>
</main>
<?php include_once 'footer.php'; ?>
</body>
</html>