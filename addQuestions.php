<?php
session_start();
require_once 'dbConnection.php';
require_once 'User.php';
require_once 'Survey.php';
require_once 'User.php';
require_once 'Question.php';
include_once 'header.php';

$survey_id = "";
// List the surveys
$dbcon      = Database::getDb();
$s          = new Survey();
// show Surveys that are related to the user
// var_dump($_SESSION);
$user_id = (int) $_SESSION['userID'];
$allsurveys = $s->displaySurveys($dbcon, $user_id);
//var_dump($allsurveys);

//Checking if the add questions button is set in order to send all the questons to the questions table
if (isset($_POST['addQuestion'])) {
       //var_dump($_POST);
       $dbcon = Database::getDb();
       $q = new question();
       $question_text = [$_POST['question1'], $_POST['question2'], $_POST['question3'], $_POST['question4'], $_POST['question5']];
       $questions =  $q->addQuestion($question_text, $_POST['id'], $dbcon);
    header('Location:userDashboard.php');

}
?>

<html lang="en">

<head>
       <title>Add Questions</title>
       <title>SurveyBobby</title>
       <meta charset="utf-8">
       <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/darkly/bootstrap.min.css" rel="stylesheet" integrity="sha384-rCA2D+D9QXuP2TomtQwd+uP50EHjpafN+wruul0sXZzX/Da7Txn4tB9aLMZV4DZm" crossorigin="anonymous">

       <script>
              function closediv() {
                     document.getElementById("wrap").style.display = "none";
              }
       </script>
</head>

<body>
       <main class="m-5">
              <div>
                     <?php

                     if (isset($_POST['startques'])) {
                            $survey_id = $_POST['id'];
                            //echo  $survey_id;
                            // num of questions that are present in the survey
                            $dbcon      = Database::getDb();
                            $q          = new Question();
                            $numQuestions = $q->numOfQuestions($dbcon, $survey_id);

                            if ($numQuestions > 3) {
                                   echo "Already have enough questions to the Survey";
                            } else {


                     ?>

                                   <main class="m-5">
                                          <h1 class="h3">Add a new question to the survey:</h1>
                                          <div class="form-group">
                                                 <form method="post">
                                                        <label for="name">Question 1 :</label>
                                                        <input type="text" class="form-control" name="question1" id="question1" value="" placeholder="Enter question for your survey.....">
                                                        <span style="color: red"> </span>
                                          </div>
                                          <div class="form-group">
                                                 <label for="name">Question 2 :</label>
                                                 <input type="text" class="form-control" name="question2" id="question2" value="" placeholder="Enter question for your survey.....">
                                                 <span style="color: red"> </span>
                                          </div>
                                          <div class="form-group">
                                                 <label for="name">Question 3 :</label>
                                                 <input type="text" class="form-control" name="question3" id="question3" value="" placeholder="Enter question for your survey.....">
                                                 <span style="color: red"> </span>
                                          </div>
                                          <div class="form-group">
                                                 <label for="name">Question 4 :</label>
                                                 <input type="text" class="form-control" name="question4" id="question4" value="" placeholder="Enter question for your survey.....">
                                                 <span style="color: red"> </span>
                                          </div>
                                          <div class="form-group">
                                                 <label for="name">Question 5 :</label>
                                                 <input type="text" class="form-control" name="question5" id="question5" value="" placeholder="Enter question for your survey.....">
                                                 <span style="color: red"> </span>
                                          </div>
                                          <input type="hidden" name="id" value="<?= $survey_id; ?>">
                                          <button type="submit" name="addQuestion" class="btn btn-success center-align btn-lg" id="btn-submit">
                                                 Add Questions
                                          </button>
                                          </form>
                                   <?php } ?>


                            <?php
                     } else {
                            ?>

                                   <!-- Code for adding questios to the just created survey -->
                                   <form class="addQuestions" id="wrap" action="" method="post">
                                          <h1 class="h3">Thanks for your interest in creating a Survey, please proceed with adding your questions...!!</h1>
                                          <table class="table table-hover">
                                                 <thead>
                                                        <tr>
                                                               <th scope="col">Survey Name</th>
                                                               <th scope="col">Survey Description</th>
                                                               <th scope="col">Add Questions</th>
                                                        </tr>
                                                 </thead>
                                                 <tbody>
                                                        <?php
                                                        for ($i = 0; $i < count($allsurveys); $i++) {
                                                        ?>
                                                               <tr class="table-primary">

                                                                      <td scope="row"><a href="#"><?= $allsurveys[$i]->title; ?></a></td>
                                                                      <td scope="row"><?= $allsurveys[$i]->description; ?></td>
                                                                      <td>
                                                                             <form action="" method="post">
                                                                                    <input type="hidden" name="id" value="<?= $allsurveys[$i]->survey_id; ?>">
                                                                                    <input type="submit" class="button btn btn-primary" name="startques" value="Add Questions" />
                                                                             </form>
                                                                      </td>
                                                               </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                 </tbody>
                                          </table>

                                   <?php
                            }
                                   ?>
              </div>
       </main>
</body>

</html>