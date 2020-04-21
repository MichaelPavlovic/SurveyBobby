<?php
session_start();
require_once 'dbConnection.php';
require_once 'User.php';
require_once 'Survey.php';

//If user is not loggid in, will be re-directed to login page
if(!isset($_SESSION['userType']) && !isset($_SESSION['userID'])){
  header('login.php');
}
if(isset($_SESSION['username']) && isset($_SESSION['userID']) && isset($_SESSION['userType'] )){

//echo $_SESSION['username'];

//         User 
$id=(int)$_SESSION['userID'];
//echo $id;

$dbcon = Database::getDb();

$s = new User();
// $users = $s->listUsers($dbcon); 

// show user
$pageuser = $s->displayUser($dbcon, $id);
//var_dump ($pageuser);
$user_fname=$pageuser->fname;
$user_lname=$pageuser->lname;
$user_email=$pageuser->email;
$user_password=$pageuser->password;
$user_isAdmin=$pageuser->isAdmin;

// end show user

// update User 

        // Update User
        if(isset($_POST['updUser'])) {
            $user_fname = $_POST['userfname'];
            $user_lname = $_POST['userlname'];
            $user_email = $_POST['useremail'];
            //$user_password = $_POST['userpassword'];
            // $user_isAdmin = $_POST['userisAdmin'];
            // $user_id = $_POST['sid'];

            $dbcon = Database::getDb();
            $s = new User();

            $count = $s->updateUser($dbcon, $id, $user_fname, $user_lname, $user_email, $user_password, $user_isAdmin);
          
            if($count){
                
                $message="Record Updated!";
                // echo "<script async type='text/javascript'>alert('$message');</script>";
                header("userDashboard.php");
            } else {
                echo "problem updating a user";
            }
        }


        // Delete User

        if(isset($_POST['deleteUser'])){
            $user_id = $_POST['sid'];

            $dbcon = Database::getDb();

            $s = new User();
            $count = $s->deleteUser($dbcon,$id);

            if($count){
                header("Location: signup.php");
            }
            else {
                echo " Problem Deleting your profile";
            }
        }

        // End Delete User

// end update User

//Begin List the surveys

$dbcon = Database::getDb();
$s = new Survey();

// show Surveys that are created  by the user
$allsurveys = $s->displaySurveys($dbcon, $id);
//var_dump($allsurveys);
//Show all surveys that user have taken

$takenSurveys= $s->AllSurveysTakenByUser($dbcon, $id);
//var_dump($takenSurveys);
// END List the surveys
      }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/darkly/bootstrap.min.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/userDashboard.css">
    <title>User Dashboard</title>
</head>
<body>
<?php include_once 'header.php'; ?>
  <div>
    <header class="header text-center">
    
    
    <a style="float: right" class="btn" href="list.php" target="">All Surveys</a>
    <a style="float: right" class="btn" href="index.php" target="">Home</a>
    </header>
  </div>

<main class="main">

<!-- Top buttons -->
<div .class="inline-block">

  <a class="btn btn-primary btn-lg" href="createSurvey.php" role="button">Create New Survey</a>
 
  
</div> 

</div>

<!-- end Top Buttons -->
<div id="tables">
<h2>Surveys Created</h2>
<table class="table table-hover">
  <thead>
    <tr>
      <!-- <th scope="col">Survey ID</th> -->
      <th scope="col">Survey Name</th>
      
      <th scope="col">Description</th>
      <th scope="col">Created Date</th>
      <th scope="col">Statistic</th>
    </tr>
  </thead>
  <tbody>
<?php 
    for ($i=0; $i<count($allsurveys); $i++ ){
      echo '<tr class="table-primary">';

      // echo '<td scope="row">'.$allsurveys[$i]->survey_id.'</td>';
      echo '<td scope="row"><form method="post" action="showSurvey.php"><input type="hidden" name="id" value="'.$allsurveys[$i]->survey_id.'"><button type="submit" class="btn btn-link">'.$allsurveys[$i]->title.'</button></form></td>';
      echo '<td scope="row">'.$allsurveys[$i]->description.'</td>';
      echo '<td scope="row">'.$allsurveys[$i]->created_date.'</td>';
      //input survey id to calculate average for specific survey   
        $avrg= $s->avgResponse($dbcon, $allsurveys[$i]->survey_id);
        $average= $avrg[0]->average;
       $avrg= $s->avgResponse($dbcon, $allsurveys[$i]->survey_id);
        $average= $avrg[0]->average;
      echo '<td scope="row"> 
      <form action="SurveyResults.php" method="post">
      <input type="hidden" name="id" value="'.$allsurveys[$i]->survey_id.'"/>
      <input type="submit" class="btn btn-link" name="SurveyStats" value="SurveyStats"/>
  </form>
  </td>';
      echo '</td>';
      echo '</tr>';
    }


    

?>
  </tbody>
</table> 




<!--Begin Table of Surveys User Taken-->
<h2>Surveys Taken</h2>
<table class="table table-hover">
  <thead>
    <tr>
      <!-- <th scope="col">Survey ID</th> -->
      <th scope="col">Survey Name</th>
      <th scope="col">Description</th>
      <th scope="col">Created Date</th>
      <th scope="col">Average</th>
    </tr>
  </thead>
  <tbody>
<?php 
    for ($i=0; $i<count($takenSurveys); $i++ ){
      echo '<tr class="table-primary">';

      // echo '<td scope="row">'.$takenSurveys[$i]->id.'</td>';
      echo '<td scope="row"><form method="post" action="showSurvey.php"><input type="hidden" name="id" value="'.$takenSurveys[$i]->id.'"><button type="submit"class="btn btn-link">'.$takenSurveys[$i]->title.'</button></form></td>';
      echo '<td scope="row">'.$takenSurveys[$i]->description.'</td>';
      echo '<td scope="row">'.$takenSurveys[$i]->created_date.'</td>';
      //input survey id to calculate average for specific survey   
        $avrg= $s->avgResponse($dbcon, $takenSurveys[$i]->id);
        $average= $avrg[0]->average;
      echo '<td scope="row">'.$average.'</td>';
      // echo '</td>';
      echo '</tr>';
    }

   

?>
  </tbody>
</table> 
</div>
<!--End Table of Surveys User Taken-->





<div class="jumbotron profile">
  <!-- <h1 class="display-3">Hello, <?= $user_fname ?></h1> -->
  <div class="profileImage">
<!-- https://www.iconfinder.com/icons/131511/account_boss_caucasian_chief_director_directory_head_human_lord_main_male_man_manager_profile_user_icon -->
  <!-- <img src="img/face.png" alt="generic face photo"></br> -->
 </div> 
<form action="" method="POST">
  <fieldset> 
    <input type="text" class="hidden" id="sid" name="sid" value="<?=$id;?>" />     
    <!-- <label for="uid">User ID</label>
        <input type="text" id="uid" name="uid" value="<?=$id;?>" disabled /></br>
    <label for="userisAdmin">Role</label>
        <input type="text" id="userisAdmin" name="userisAdmin" 
        value="<?php if ($user_isAdmin == 0){
                echo "User";
        }else{
          echo "Admin";
        }
        ?>" disabled  /></br> -->
    <label for="userfname">First Name: </label>
        <input type="text" id="userfname" name="userfname" value="<?=$user_fname?>" /> </br>
    <label for="userlname">Last Name: </label>
        <input type="text" id="userlname" name="userlname" value="<?=$user_lname?>" /></br>
    <label for="useremail">Email: </label>
        <input type="text" id="useremail" name="useremail" value="<?=$user_email?>" /></br>
    <!-- <label for="userpassword">Password: </label>
        <input type="password" id="userpassword" name="userpassword" value="<?=$user_password?>" /></br> -->
  
    <button type="submit" name="updUser" id="updUser" class="button"> Update User</button>
    <button type="submit" name="deleteUser" id="deleteUser" class="button"> Delete Account</button>
      </fieldset>  
  
</form>
<div> 
        <?php if(isset($message)){
        echo $message;
        } 
        ?>
</div>


</main> 


</body>
</html>
