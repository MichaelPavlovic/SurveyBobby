
<?php
session_start();
require_once 'dbConnection.php';
require_once 'Survey.php';
require_once 'header.php';
$response ="";

if (ISSET($_POST['SurveyStats'])){
    $user_id = $_SESSION['userID'];
        $survey_id= $_POST['id'];
         $db = Database::getDb();
         $avg = new Survey();
         $averageResponse = $avg->avgResponse($db, $survey_id);
         if($averageResponse>2.5){
             $response = "POSITIVE";
         }
         $response = $averageResponse;
         if ($averageResponse == NULL){
            $response = $averageResponse;

         }
         else {
             $response = "NEGATIVE";
         }
         //code for 
         $db = Database::getDb();
         $number = new Survey();
         $noOfUsers = $number->numberofuserspersurvey($survey_id, $db);

}
?>



<html lang="en">
<head>
    <title>Categories</title>
    <meta name="description" content="Survey Bobby">
    <meta name="keywords" content="Survey, Category, User, Admin">
    <title>SurveyBobby</title>
    <meta charset="utf-8">
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/darkly/bootstrap.min.css" rel="stylesheet" integrity="sha384-rCA2D+D9QXuP2TomtQwd+uP50EHjpafN+wruul0sXZzX/Da7Txn4tB9aLMZV4DZm" crossorigin="anonymous">
</head>

<body>

<main  id= "surveyResult" style = "text-align: center" class="m-5">
<h1 class="h1">Stats for the Survey that you created</h1>
<h3 class="h3">The average response for the survey is <?= $response;?></h3>
<h3 class="h3">Total number of users who took the survey are <?= $noOfUsers['no_of_users'];?></h3>
<a href="list.php" id="btn_back" class="btn btn-secondary align-center btn-lg">Back to List</a>
</main>


</body>
</html>
