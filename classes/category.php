<?php
//Developer: Mounica Sykam
class Category
{
// function to get the particular category based on the id 
    public function getCategoryById($id, $db){
       //echo $id;
        $sql = "SELECT * FROM categories where id = :id";
        $pst = $db->prepare($sql);
        $pst->bindParam(':id', $id);
        $pst->execute();
        $categoriesArr = $pst->fetch(PDO::FETCH_OBJ);
        return  $categoriesArr;
    }
    // function to get all the categories
    public function getAllCategories($dbcon){
        $sql = "SELECT * FROM categories";
        $pdostm = $dbcon->prepare($sql);
        $pdostm->execute();

        $categories = $pdostm->fetchAll(PDO::FETCH_OBJ);
        return $categories;
    }
// function to add the category to the categories table
    public function addCategory($name, $description, $db)
    {
        $sql = "INSERT INTO categories (name, description) 
              VALUES (:name, :description) ";
        $pst = $db->prepare($sql);
        $pst->bindParam(':name', $name);
        $pst->bindParam(':description', $description);
        $count = $pst->execute();
        return $count;
    }
    // function to get delete category from the categories table

    public function deleteCategory($id, $db){
        $sql = "DELETE FROM categories WHERE  id = :id";

        $pst = $db->prepare($sql);
        $pst->bindParam(':id', $id);
        $count = $pst->execute();
        return $count;

    }
// function to update category from the categories table
    public function updateCategory($id, $name, $description, $db){
        $sql = "UPDATE categories
                set name = :name,
                description = :description                
                WHERE id = :id
        
        ";

        $pst =  $db->prepare($sql);

        $pst->bindParam(':name', $name);
        $pst->bindParam(':description', $description);
        $pst->bindParam(':id', $id);

        $count = $pst->execute();

        return $count;
    }
}
