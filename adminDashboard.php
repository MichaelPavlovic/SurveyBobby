<?php
session_start();
date_default_timezone_set("America/Toronto");
require_once 'dbConnection.php';
require_once 'User.php';
require_once 'Survey.php';

//If user is not loggid in, will be re-directed to login page
if(!isset($_SESSION['userType']) && !isset($_SESSION['userID'])){
  header('login.php');
}

// Users
  // Show how many Users registered in total
    $dbcon = Database::getDb();

    $u = new User();

    $userscount = $u->countUsers($dbcon);
   
    $countU=$userscount[0]->total;
   
  // Show how many users registered in last 30 days 
    $users30days = $u->countUsers30($dbcon);
    $users30dayscount=$users30days[0]->total30days;
    

// Surveys
  // Show how many Surveys exist in total
  $dbcon = Database::getDb();

  $s = new Survey();

  $surveyscount = $s->countSurveys($dbcon);
  
  $countS=$surveyscount[0]->total;

// Show how many Surveys created in last 30 days 
  $surveys30days = $s->countSurveys30($dbcon);
  $surveys30dayscount=$surveys30days[0]->total30days;

// Show all Surveys
  $allsurveys = $s->listAllSurveys($dbcon);
//var_dump($allsurveys);
// Show All Users
  $allusers = $u->listUsers($dbcon);

//Reference Michael Pavlovic
    //delete survey from db
    if(isset($_POST['id'])){
     $s = new Survey();
    $count = $s->deleteSurvey($dbcon, ($_POST['id']));
    header("refresh: 0");  
    }
//Delete user 
if(isset($_POST['uid'])){
  $s = new User();
 $count = $s->deleteUser($dbcon, ($_POST['uid']));  
 header("refresh: 0");
 }
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/darkly/bootstrap.min.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/adminDashboard.css">
  <title>Admin Dashboard</title>
</head>

<body>
<div>
    <header class="header text-center">
    
    <a style="float: right" href="listCategories.php" class="btn">Manage Categories</a></div>
    <a style="float: right" class="btn" href="manageHome.php" target="">Manage Home Page</a>
    <a style="float: right" class="btn" href="list.php" target="">All Surveys</a>
    <a style="float: right" class="btn" href="index.php" target="">Home</a>
    </header>
  </div>

  <main class="main">
    <h1>Admin Dashboard</h1>
    <aside class="right">
      <h2>Survey stats at Glance</h2>
      <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center">
          New Surveys Created(Last 30 days) 
          <!-- Sql query SELECT COUNT(user_id) as total30days FROM `users` WHERE DATE(reg_date) >= DATE(NOW()) - INTERVAL 30 DAY -->
          <span class="badge badge-primary badge-pill"><?= $surveys30dayscount ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          Total Surveys registered
          <!-- sql query SELECT COUNT(user_id) as total FROM users -->
          <span class="badge badge-primary badge-pill"><?= $countS ?></span>
        </li>
      </ul>
    </aside>
    <aside class="left">
      <h2>User Stats at Glance</h2>
      <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center">
          New Users Registered(Last 30 days)
          <span class="badge badge-primary badge-pill"><?= $users30dayscount ?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          Total Users
          <span class="badge badge-primary badge-pill"><?= $countU ?></span>
        </li>

    </aside>

    
    <!-- <a href="listCategories.php" class="btn btn-primary btn-lg center-align">Manage Categories</a></div> -->


    <!-- Surveys Table Section -->
    <div class="survey">
      <h3>Surveys</h3>
  
      <hr />
  
      <table class="table table-hover">
  
        <thead>
          <tr>
            
            <th scope="col">Survey Name</th>
            
            <th scope="col">Survey Description</th>
            <th scope="col">Created</th>

            <th colspan="1" scope="col" style="text-align:center;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            for ($i=0; $i<count($allsurveys); $i++ ){
              echo '<tr class="table-primary">';

              // echo '<td scope="row">'.$allsurveys[$i]->survey_id.'</td>';
              echo '<td scope="row"><a href="#">'.$allsurveys[$i]->title.'</a></td>';
              // echo '<td scope="row">'.$allsurveys[$i]->name.'</td>';
              echo '<td scope="row">'.$allsurveys[$i]->description.'</td>';
              echo '<td scope="row">'.$allsurveys[$i]->created_date.'</td>';
              echo '<td scope="row">'. '<form action="adminDashboard.php" method="post" class="form-inline">
              <input type="hidden" name="id" value="'.$allsurveys[$i]->id.'">
              <input type="submit" class="button btn btn-danger" name="deleteSurvey" value="Delete Survey"  />
          </form></td>';
              echo '</tr>';
            }

          ?>
        </tbody>
      </table>
    </div >

<!-- Users Table Section -->
    <div class="users">
      <h3>Users</h3>
      <hr />
      <table class="table table-hover">
          <thead>
            <tr>            
              <th scope="col">User First Name</th>
              <th scope="col">User Last Name</th>
              <th scope="col">Date Registered</th>
              <th colspan="1" scope="col" style="text-align:center;">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php 
          for ($i=0; $i<count($allusers); $i++ ){
          echo '<tr class="table-primary">';
          // echo '<td scope="row"><a href="#">'.$allusers[$i]->user_id.'</a></td>';
          echo '<td scope="row">'.$allusers[$i]->fname.'</td>';
          echo '<td scope="row">'.$allusers[$i]->lname.'</td>';
          echo '<td scope="row">'.$allusers[$i]->reg_date.'</td>';
          echo '<td scope="row">'. '<form action="" method="POST">';
          echo '<td scope="row">'. '<form action="adminDashboard.php" method="post" class="form-inline">
          <input type="hidden" name="uid" value="'.$allusers[$i]->id.'">
          <input type="submit" class="button btn btn-danger" name="deleteUser" value="Delete User" />
          </form></td>';
                  
          echo '</tr>';
          }
        ?>
        </tbody>
      </table>
  
     </div>


  </main>
</body>

</html> 