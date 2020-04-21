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
require_once 'classes/Explanation.php';

//initialize vars
$section = $body = '';
$sectionerr = $bodyerr = '';

//check if form from manageHome page is set
if (isset($_POST['updateExp'])) {
    //get id
    $id = $_POST['id'];

    //connect to db
    $dbcon = Database::getDb();

    //get specific exp that was clicked on based on id
    $e = new Explanation();
    $exp = $e->showExp($dbcon, $id);

    //set form inputs to db values
    $section = $exp->section_name;
    $body = $exp->body;
}

//check if form on update page is set
if (isset($_POST['updExp'])) {
    //get form input
    $section = $_POST['section'];
    $body = $_POST['body'];
    $id = $_POST['id'];

    //connect to db
    $dbcon = Database::getDb();

    //update data
    $e = new Explanation();
    $count = $e->updateExp($dbcon, $id, $section, $body);

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
                <label for="section">Title: </label>
                <input class="form-control" type="text" id="section" name="section" value="<?= $section; ?>"
                       placeholder="Enter a title...">
                <span style="color: red"><?= $sectionerr; ?></span>
            </div>
            <div class="form-group">
                <label for="body">Body: </label>
                <input class="form-control" type="text" id="body" name="body" value="<?= $body; ?>"
                       placeholder="Enter an body...">
                <span style="color: red"><?= $bodyerr; ?></span>
            </div>
            <div>
                <button class="btn btn-primary btn-lg" type="submit" id="btn-submit" name="updExp">Update</button>
                <a href="manageHome.php" id="btn_back" class="btn btn-secondary btn-lg">Back</a>
            </div>
        </form>
    </main>
<?php include_once 'footer.php'; ?>
</body>
</html>