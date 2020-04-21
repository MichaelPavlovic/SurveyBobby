<?php

//DEVELOPER: Michael Pavlovic

session_start();
//add if statement to check if user is logged in - if not redirect to login page
if(!isset($_SESSION['userID']) && !isset($_SESSION['username']) && !isset($_SESSION['userType'])){
    header('Location:signin.php');
}

require_once 'dbConnection.php';
require_once 'Survey.php';
require_once 'classes/category.php';


//initialize vars
$title = $description = $catID = $titleerr = $descriptionerr = '';

//check if form from manageHome page is set
$dbcon = Database::getDb();
if (isset($_POST['updateSurvey'])) {
    //get id
    $id = $_POST['id'];

    //get specific survey that was clicked on based on id
    $s = new Survey();
    $survey = $s->showSurvey($dbcon, $id);

    //get category id of the specific survey
    $catID = $survey->category_id;

    //connect to db

    $c = new Category();
    $cats = $c->getAllCategories($dbcon);

    //set form inputs to db values
    $title = $survey->title;
    $description = $survey->description;
}
//check if form on update page is set
if (isset($_POST['updSurvey'])) {
    //get form input
    $description = $_POST['description'];
    $title = $_POST['title'];
    $category = $_POST['category'];
    $id = $_POST['id'];

    //update data
    $s = new Survey();
    $count = $s->updateSurvey($dbcon, $id, $title, $description, $category);

    //if updated, redirect to list
    if ($count) {
        header('Location:userDashboard.php');
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
    <h1 class="h3">Update survey:</h1>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= 5 ?>"/>
        <div class="form-group">
            <label for="section">Title: </label>
            <input class="form-control" type="text" id="title" name="title" value="<?= $title; ?>"
                   placeholder="Enter a title...">
            <span style="color: red"><?= $titleerr; ?></span>
        </div>
        <div class="form-group">
            <label for="body">Description: </label>
            <input class="form-control" type="text" id="description" name="description" value="<?= $description; ?>"
                   placeholder="Enter a description">
            <span style="color: red"><?= $descriptionerr; ?></span>
        </div>
        <div class="form-group">
            <label for="category">Category: </label>
            <select id="category" name="category">
                <?php foreach($cats as $cat){?>
                    <option value="<?= $cat->id; ?>" <?php if($cat->id == $catID){ echo 'selected'; } ?>><?= $cat->name; ?></option>
                <?php } ?>
            </select>
        </div>
        <div>
            <button class="btn btn-primary btn-lg" type="submit" name="updSurvey">Update</button>
        </div>
    </form>
</main>
<?php include_once 'footer.php'; ?>
</body>
</html>