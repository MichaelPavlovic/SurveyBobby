<?php

//DEVELOPER: Michael Pavlovic

session_start();

//add if statement to check if user is logged in - if not redirect to login page
if(!isset($_SESSION['userID']) && !isset($_SESSION['username']) && !isset($_SESSION['userType'])){
    header('Location:signin.php');
}

//check if id is set
if(isset($_POST['id'])){
    //get id
    $id = $_POST['id'];

    require_once 'dbConnection.php';
    require_once 'classes/Question.php';

    //connect to db
    $dbcon = Database::getDb();

    //delete from db
    $q = new Question();
    $count = $q->deleteQuestion($dbcon, $id);

    //if deleted, redirect to manageHome
    if($count){
        header('Location:userDashboard.php');
    }
    else {
        echo "Could not delete record";
    }
}