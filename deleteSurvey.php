<?php

//DEVELOPER: Michael Pavlovic


//add if statement to check if user is logged in - if not redirect to login page
if(!isset($_SESSION['userID']) && !isset($_SESSION['username']) && !isset($_SESSION['userType'])){
    header('Location:signin.php');
}

//check if id is set
if(isset($_POST['id'])){
    //get id
    $id = $_POST['id'];


    require_once 'dbConnection.php';
    require_once 'Survey.php';
    require_once 'classes/Question.php';

    //connect to db
    $dbcon = Database::getDb();

    //delete survey from db
    $s = new Survey();
    $count = $s->deleteSurvey($dbcon, $id);

    //delete questions from db
    $q = new Question();
    $count2 = $q->deleteAllQuestions($dbcon, $id);

    //if deleted, redirect to user dashboard
    if($count && $count2){
        header('Location:userDashboard.php');
    }
    else {
        echo "Could not delete record";
    }
}