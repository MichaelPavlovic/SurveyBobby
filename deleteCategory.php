<?php
require_once 'dbConnection.php';
require_once 'classes/category.php';
//check if id is set
if(isset($_POST['id'])){
    //get id
    $id = $_POST['id'];
     //connect to db
    $db = Database::getDb();
     //delete from db
    $c = new Category();
    $count = $c->deleteCategory($id, $db);
    //if deleted, redirect to list of categories
    if($count){
        header("Location: listCategories.php");
    }
    else {
        echo " problem deleting the category";
    }


}
