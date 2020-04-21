<?php

//DEVELOPER: Michael Pavlovic

session_start();

require_once 'dbConnection.php';
require_once 'classes/FAQ.php';
require_once 'classes/Explanation.php';

//   List of users in Database
//petergriffin@gmail.com pumpkin is administrator
//cbing@gmail.com friends
//bobd@gmail.com password
//connect to db
$dbcon = Database::getDb();

//list faqs
$f = new FAQ();
$faqs = $f->listFAQs($dbcon);

//list explanations
$e = new Explanation();
$exps = $e->listExps($dbcon);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SurveyBobby</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/footerStyle.css">
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/darkly/bootstrap.min.css" rel="stylesheet" integrity="sha384-rCA2D+D9QXuP2TomtQwd+uP50EHjpafN+wruul0sXZzX/Da7Txn4tB9aLMZV4DZm" crossorigin="anonymous">
</head>
<body>
    <?php include_once 'header.php'; ?>
    <main>
        <div class="container-fluid text-center bg text">
            <h1>SurveyBobby</h1>
            <p>Where Surveys are not just created, they are Crafted</p>
            <div class="pad-top">
                <a href="#get-started" class="btn btn-success btn-lg">Get Started</a>
            </div>
        </div>
        <div class="container-fluid text-center">
            <h2>About Us</h2>
            <p class="pad-top">SurveyBobby is a completely free website that allows you to create as many surveys as you want and share them!</p>
        </div>
        <div class="container-fluid bg text-center" id="get-started">
            <h2 class="text">How it works</h2>
            <div class="row pad-top">
                <div class="col-2"></div>
                <div class="col-3">
                    <div class="list-group" id="list-exp" role="tablist">
                        <!-- loop through explanations and display -->
                        <?php foreach($exps as $exp){ ?>
                            <a class="list-group-item list-group-item-action" id="list-<?= $exp['id']; ?>-exp" data-toggle="list" href="#list-<?= $exp['id']; ?>" role="tab" aria-controls="prince"><?= $exp['section_name']; ?></a>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-5 text-left">
                    <div class="tab-content" id="nav-tabContent">
                        <?php foreach($exps as $exp){ ?>
                            <div class="tab-pane" id="list-<?= $exp['id']; ?>" role="tabpanel" aria-labelledby="list-<?= $exp['id']; ?>-exp">
                                <p><?= $exp['body']; ?></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-2"></div>
            </div>
        </div>
        <div class="container-fluid text-center">
            <h2>Frequently Asked Questions</h2>
            <div class="row pad-top">
                <div class="col-md-3"></div>
                <div class="accordion md-accordion col-md-6" id="accordionFAQ" role="tablist" aria-multiselectable="true">
                    <!-- loop through faqs and display -->
                    <?php foreach($faqs as $faq){ ?>
                    <div class="card">
                        <div class="card-header" role="tab" id="heading<?= $faq['id']; ?>">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordionFAQ" href="#collapse<?= $faq['id']; ?>" aria-expanded="false" aria-controls="collapse<?= $faq['id']; ?>">
                                <h3 class="mb-0 h5"><?= $faq['question']; ?></h3>
                            </a>
                        </div>
                        <div id="collapse<?= $faq['id']; ?>" class="collapse" role="tabpanel" aria-labelledby="heading<?= $faq['id']; ?>" data-parent="#accordionFAQ">
                            <div class="card-body"><?= $faq['answer']; ?></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>
    <!-- scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>