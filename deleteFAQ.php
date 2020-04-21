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

//check if id is set
if(isset($_POST['id'])){
    //get id
    $id = $_POST['id'];

    require_once 'dbConnection.php';
    require_once 'classes/FAQ.php';

    //connect to db
    $dbcon = Database::getDb();

    //delete from db
    $f = new FAQ();
    $count = $f->deleteFAQ($dbcon, $id);

    //if deleted, redirect to manageHome
    if($count){
        header('Location:manageHome.php');
    }
    else {
        echo "Could not delete record";
    }
}