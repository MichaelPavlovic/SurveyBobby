<?php

class User {

    public function listUsers($dbcon){
        $sql = "SELECT * FROM users";
        $pdostm = $dbcon->prepare($sql);
        $pdostm->execute();

        $users = $pdostm->fetchAll(\PDO::FETCH_OBJ);
        return $users;
    }
    public function countUsers($dbcon){
        $sql = "SELECT COUNT(id) as total FROM users";
        $pdostm = $dbcon->prepare($sql);
        $pdostm->execute();

        $users = $pdostm->fetchAll(\PDO::FETCH_OBJ);
        return $users;
    }
    public function countUsers30($dbcon){
        $sql = "SELECT COUNT(id) as total30days FROM `users` WHERE DATE(reg_date) >= DATE(NOW()) - INTERVAL 30 DAY";
        $pdostm = $dbcon->prepare($sql);
        $pdostm->execute();

        $users = $pdostm->fetchAll(\PDO::FETCH_OBJ);
        return $users;
    }

    public function deleteUser($dbcon,$id){
        $sql = "DELETE FROM users WHERE id = :id";

        $pst = $dbcon->prepare($sql);
        $pst->bindParam(':id', $id);
        $count = $pst->execute();
        return $count;
    }
    public function displayUser($dbcon, $id){

        $sql = "SELECT * FROM users where id = :id";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(':id', $id);
        $pst->execute();
        $pageuser = $pst->fetch(PDO::FETCH_OBJ);
        return $pageuser;
    }
    public function updateUser($dbcon,$id, $fname, $lname, $email, $password, $isAdmin){
      $sql = "Update users
                set
                fname    = :fname,
                lname    = :lname,
                email    = :email,
                password = :password,
                isAdmin  = :isAdmin
                WHERE id = :id
        
        ";
        $pst = $dbcon->prepare($sql);

        $pst->bindParam(':fname', $fname);
        $pst->bindParam(':lname', $lname);
        $pst->bindParam(':email', $email);
        $pst->bindParam(':password', $password);
        $pst->bindParam(':isAdmin', $isAdmin);
        $pst->bindParam(':id', $id);
        
        $count = $pst->execute();
        return $count;
       
    }

}

?>