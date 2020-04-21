<?php
session_start();
date_default_timezone_set("America/Toronto");
require_once 'dbConnection.php';
require_once 'Survey.php';
include_once 'header.php';

//If user is not loggid in, will be re-directed to login page
if(!isset($_SESSION['userType']) && !isset($_SESSION['userID'])){
    header('login.php');
  }


$dbcon = Database::getDb();
$s = new Survey();
$surveys =  $s->listAllSurveys(Database::getDb());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/darkly/bootstrap.min.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>List of surveys for Users</title>
</head>
<body>

<main class="m-5">

<div>  
<table class="table table-bordered table-hover tbl">
  <thead class="text-center">
    <tr>
      <th scope="col">Survey Name</th>
      <th scope="col">Description</th>
      <th scope="col">Take Survey</th>
    </tr>
  </thead>
  <tbody>
        <?php foreach ($surveys as $survey) { ?>
            <tr>
                <td><?= $survey->title ?></td>
                <td><?= $survey->description ?></td>
                <td>
                    <form action="takeSurvey.php" method="post">
                        <input type="hidden" name="id" value="<?= $survey->id ?>"/>
                        <input type="submit" class="button btn btn-primary" name="takeSurvey" value="Take Survey"/>
                    </form>
                </td>
               
            </tr>
        <?php } ?>
        </tbody>
    </table>
    </div>

    <div><a class="btn btn-primary btn-lg" href="createSurvey.php" role="button">Create New Survey</a> </div>
</main>   
</body>
</html>
