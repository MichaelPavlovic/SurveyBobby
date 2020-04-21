<?php

session_start();

//if the user is already logged in redirect them to the dashboard
if(isset($_SESSION['userID']) && isset($_SESSION['username']) && isset($_SESSION['userType'])){
    if($_SESSION['userType'] == 1){
        header('Location:adminDashboard.php');
    } else {
        header('Location:userDashboard.php');
    }
}

require_once 'dbConnection.php';
require_once 'Survey.php';
require_once 'User.php';
$warning = "none;";
// petergriffin@gmail.com
// pumpkin
if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

   
    $dbcon = Database::connectDB();
    
    $userObj = Database::checkUserCreds($email, $password);

    if ($userObj) {
        $_SESSION['userID'] = $userObj->id;
        $_SESSION['username'] = $userObj->fname;
        $_SESSION['userType'] = $userObj->isAdmin;

        if($userObj->isAdmin == 1) {
            header('Location:adminDashboard.php');
            exit();
        }
        else {
            header('Location:userDashboard.php');
            exit();
        }
            
    } else {
        $warning = "block;";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SurveyBobby</title>
    <link rel="stylesheet" href="css/signin.css">
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/darkly/bootstrap.min.css" rel="stylesheet" integrity="sha384-rCA2D+D9QXuP2TomtQwd+uP50EHjpafN+wruul0sXZzX/Da7Txn4tB9aLMZV4DZm" crossorigin="anonymous">

</head>

<body>
    <header style="border: 1px solid black" class="header text-center">
        <!-- <p style="float: left; position: absolute" ><&#129437;> Curious Raccoons <&#129437;></p>
        <a style="float: right; margin: 0 20px" class="btn" href="signup.php" target="_blank">Register Now</a>
        <a style="float: right" class="btn" href="signin.php" target="">Log In</a>  -->
    </header>

    <main id="signinSection">
        <!-- LOGIN SECTION BY HILMI -->
        <form id="signinForm" method="POST">
            <fieldset>
                <legend>Sign in to your account</legend>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>

                <button name="login" type="submit" class="btn btn-primary">Sign In</button>
            </fieldset>
        </form>

        <a href="signup.php">Don't have an account yet?</a>

        <div id="wrongUserCred" class="alert alert-dismissible alert-danger" <?= 'style="display: ' . $warning . '"' ?>>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Uh oh!</strong> Invalid username/password!
        </div>
    </main>
<!-- Footer -->
    <footer class="footer text-center">
    <p>&copy; <?php echo date ('Y');?> <&#129437;> Curious Raccoons <&#129437;></p>
    </footer>
<!-- END Footer -->
    <!-- scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>