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

//initialize variables
$sectionerr = "";
$bodyerr = "";

//check if form is set
if (isset($_POST['addExp'])) {

    //get form input
    $section = $_POST['section'];
    $body = $_POST['body'];

    $valid1 = $valid2 = true;

    //if form input is empty return error message
    if ($section == "") {
        $sectionerr = 'Please enter a question';
        $valid1 = false;
    }
    if ($body == "") {
        $bodyerr = 'Please enter an answer';
        $valid2 = false;
    }

    //if form input is valid add to database and redirect to manageHome
    if ($valid1 == true && $valid2 == true) {
        require_once 'dbConnection.php';
        require_once 'classes/Explanation.php';

        $dbcon = Database::getDb();

        $f = new Explanation();
        $count = $f->addExp($dbcon, $section, $body);

        if ($count) {
            header('Location:manageHome.php');
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
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/darkly/bootstrap.min.css" rel="stylesheet" integrity="sha384-rCA2D+D9QXuP2TomtQwd+uP50EHjpafN+wruul0sXZzX/Da7Txn4tB9aLMZV4DZm" crossorigin="anonymous">
</head>
<body>
<?php include_once 'header.php'; ?>
    <main class="m-5">
        <h1 class="h3">Add a new explanation:</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="section">Title: </label>
                <input class="form-control" type="text" id="section" name="section" value=""
                       placeholder="Enter a title...">
                <span style="color: red"><?= $sectionerr; ?></span>
            </div>
            <div class="form-group">
                <label for="body">Body: </label>
                <input class="form-control" type="text" id="body" name="body" value="" placeholder="Enter body content...">
                <span style="color: red"><?= $bodyerr; ?></span>
            </div>
            <div class="text-center">
                <button class="btn btn-success btn-lg" type="submit" id="btn-submit" name="addExp">Add</button>
                <a href="manageHome.php" id="btn_back" class="btn btn-secondary btn-lg">Back</a>
            </div>
        </form>
    </main>
<?php include_once 'footer.php'; ?>
</body>
</html>