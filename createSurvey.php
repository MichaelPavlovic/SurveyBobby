<?php 
session_start();
require_once 'dbConnection.php';
require_once 'classes/category.php';
require_once 'Survey.php';
require_once 'User.php';
include_once 'header.php';


//If user is not loggid in, will be re-directed to login page
if(!isset($_SESSION['userType']) && !isset($_SESSION['userID'])){
    header('login.php');
  }

$userId= (int)$_SESSION['userID'];
//Calling the funtion to list out the categories in the drop down
//Connetion to db
$db = Database::getDb();
$c = new Category();
$categories =  $c->getAllCategories(Database::getDb());
//code to check if the add survey button is clicked 
if (isset($_POST['addSurvey'])) {
     $name = $_POST['name'];
     $description = $_POST['description'];
     $categoryid = $_POST['category'];
     // $user_isAdmin = $_POST['userisAdmin'];
     //$user_id = $_POST['sid'];
     //calling the funtion to add the new survey to the surveys table
     $dbcon = Database::getDb();
     $s = new Survey();
     $n =  $s->addSurvey($name, $description, $userId, $categoryid, $dbcon);
     //if condition to check for the survey addition and also to add the questions to the newly added survey
         if($n){           
       header("location: addQuestions.php");
        } else {
           echo "problem adding a new Survey, Please contact admin";
         } 
    
    }
?>

<html lang="en">

<head>
    <title>Add Survey</title>
    <title>SurveyBobby</title>
    <meta charset="utf-8">
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/darkly/bootstrap.min.css" rel="stylesheet" integrity="sha384-rCA2D+D9QXuP2TomtQwd+uP50EHjpafN+wruul0sXZzX/Da7Txn4tB9aLMZV4DZm" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/main.css" type="text/css">
</head>

<body>
<main class="m-5">
<div>
    <form class= "createSurvey" action="" method="post">
        <div>
            <h1>Create a new survey</h1>
        </div>
        <div class="form-group">
            <label for="Survey Name">Name :</label>
            <input type="text" class="form-control" name="name" id="name" value=""
                   placeholder="Enter name" required> 
            <span style="color: red">

            </span>
        </div>
        <div class="form-group">
            <label for="description">Description :</label>
            <input type="text" class="form-control" id="description" name="description"
                   value="" placeholder="Please enter the description" required>
            <span style="color: red">

            </span>
        </div>
        <div class="form-group ">
            <label for="category">Category :</label>    
            <select class="dropdown-toggle" name="category"> 
                <option value='' selected>--Select Category--</option>
                  <?php
                    foreach ($categories as $category) {                         
                  ?>
                <option value="<?= $category->id; ?>"> <?= htmlspecialchars($category->name);?></option>
                <?php } ?>
            </select>
        </div>
        <div>Click <a href="listCategories.php">here</a> to know more about categories</div>
        <div>
          <a href="list.php" id="btn_back" class="btn btn-success btn-lg">Back</a>
            <button type="submit" name="addSurvey"
                class="btn btn-primary btn-lg" id="btn-submit">
                Add Survey
            </button>
        </div>
    </form>    
</div>
</main>
</body>
</html>
<?php include_once 'footer.php';?>

