<?php
require_once 'dbConnection.php';
require_once  'classes/category.php';
//initialize variables
$name = $description =  '';
$nameerr = $descriptionerr = '';
//check if form data from list category page is set
if(isset($_POST['updateCategory'])){
      //get id from that form
    $id= $_POST['id'];
     //connect to db
    $db = Database::getDb();
    //get specific category data based on id
    $c = new category();
    $category = $c->getCategoryById($id, $db);
    //set form data to db values
    $name =  $category->name;
    $description = $category->description;

    //var_dump($category);

}
//check if form on update page is set
if(isset($_POST['updCategory'])){
     //get form inputs
    $id= $_POST['sid'];
    $name = $_POST['name'];
    $description = $_POST['description'];

     //connect to db
    $db = Database::getDb();
    $c = new Category();
    $count = $c->updateCategory($id, $name, $description,$db);
      //update in db
    if($count){
       header('Location:  listCategories.php');
    } else {
        echo "Could not update the category";
    }
}
?>

<html lang="en">

<head>
    <title>Add Category - Survey Bobby</title>
    <meta name="description" content="SurveyBobby">
    <meta name="keywords" content="Survey, category, User, Admin">
    <title>SurveyBobby</title>
    <meta charset="utf-8">
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/darkly/bootstrap.min.css" rel="stylesheet" integrity="sha384-rCA2D+D9QXuP2TomtQwd+uP50EHjpafN+wruul0sXZzX/Da7Txn4tB9aLMZV4DZm" crossorigin="anonymous">
   
</head>

<body>
<main class="m-5">
<h1 class="h3">Update a category:</h1>
    <!--    Form to Update  Category -->
    <form action="" method="post">
        <input type="hidden" name="sid" value="<?= $id; ?>" />
        <div class="form-group">
            <label for="name">Name :</label>
            <input type="text" class="form-control" name="name" id="name" value="<?= $name; ?>"
                   placeholder="Enter category name..">
            <span style="color: red" >
            <?= $nameerr; ?>
            </span>
        </div>
        <div class="form-group">
            <label for="description">Description :</label>
            <input type="text" class="form-control" id="description" name="description"
                   value="<?= $description; ?>" placeholder="Enter category description..">
            <span style="color: red">
            <?= $descriptionerr; ?>
            </span>
        </div>
        </div>
        <a href="listCategories.php" id="btn_back" class="btn btn-secondary btn-lg">Back</a>
        <button type="submit" name="updCategory"
                class="btn btn-primary btn-lg" id="btn-submit">
            Update Category
        </button>
    </form>
</main>


</body>
</html

