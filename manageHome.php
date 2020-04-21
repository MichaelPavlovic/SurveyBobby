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

require_once 'dbConnection.php';
require_once 'classes/FAQ.php';
require_once 'classes/Explanation.php';

//connect to db
$dbcon = Database::connectDB();

//list faqs
$f = new FAQ();
$faqs = $f->listFAQs($dbcon);

//list explanations
$e = new Explanation();
$exps = $e->listExps($dbcon);
?>
<html lang="en">
<head>
    <title>SurveyBobby</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/manageHome.css">
    <link rel="stylesheet" href="css/footerStyle.css">
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/darkly/bootstrap.min.css" rel="stylesheet" integrity="sha384-rCA2D+D9QXuP2TomtQwd+uP50EHjpafN+wruul0sXZzX/Da7Txn4tB9aLMZV4DZm" crossorigin="anonymous">
</head>
<?php include_once 'header.php' ?>
<body>
    <main id="main">
        <h1 class="h1 text-center pad-top">Manage home page content</h1>
        <div class="m-5 content">
            <h2 class="title">Explanations</h2>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">Question</th>
                    <th scope="col">Answer</th>
                </tr>
                </thead>
                <tbody>
                <!-- loop through explanations and display -->
                <?php foreach($exps as $exp) { ?>
                    <tr>
                        <td><?= $exp['section_name'] ?></td>
                        <td><?= $exp['body'] ?></td>
                        <td>
                            <form action="updateExplanation.php" method="post">
                                <input type="hidden" name="id" value="<?= $exp['id'] ?>">
                                <input type="submit" class="button btn btn-primary" name="updateExp" value="Update" />
                            </form>
                        </td>
                        <td>
                            <form action="deleteExplanation.php" method="post">
                                <input type="hidden" name="id" value="<?= $exp['id'] ?>"/>
                                <input type="submit" class="button btn btn-danger" name="deleteExp" value="Delete" onclick="return confirm('Are you sure you want to delete this record?')" />
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <div class="text-center">
                <a href="addExplanation.php" id="addExp" class="btn btn-success btn-lg">Add Explanation</a>
            </div>
        </div>
        <div class="m-5 content">
            <h2 class="title">FAQs</h2>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">Question</th>
                    <th scope="col">Answer</th>
                </tr>
                </thead>
                <tbody>
                <!-- loop through faqs and display -->
                <?php foreach($faqs as $faq) { ?>
                    <tr>
                        <td><?= $faq['question'] ?></td>
                        <td><?= $faq['answer'] ?></td>
                        <td>
                            <form action="updateFAQ.php" method="post">
                                <input type="hidden" name="id" value="<?= $faq['id'] ?>">
                                <input type="submit" class="button btn btn-primary" name="updateFAQ" value="Update" />
                            </form>
                        </td>
                        <td>
                            <form action="deleteFAQ.php" method="post">
                                <input type="hidden" name="id" value="<?= $faq['id'] ?>"/>
                                <input type="submit" class="button btn btn-danger" name="deleteFAQ" value="Delete" onclick="return confirm('Are you sure you want to delete this record?')" />
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <div class="text-center">
                <a href="addFAQ.php" id="addFAQ" class="btn btn-success btn-lg">Add FAQ</a>
            </div>
        </div>
    </main>
<?php include_once 'footer.php' ?>
</body>
</html>