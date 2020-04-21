<?php

//DEVELOPER: Michael Pavlovic

Interface ExplanationInterface {
    public function listExps($dbcon);
    public function addExp($dbcon, $section, $body);
    public function showExp($dbcon, $id);
    public function updateExp($dbcon, $id, $section, $body);
    public function deleteExp($dbcon, $id);
}

class Explanation implements ExplanationInterface {
    //list all explanations in the database
    public function listExps($dbcon){
        //sql statement
        $sql = 'SELECT * FROM explanations';

        //prepare and execute sql statement
        $pdostm = $dbcon->prepare($sql);
        $pdostm->execute();

        //get the results as an associative array
        $exps = $pdostm->fetchAll(PDO::FETCH_ASSOC);

        //return results
        return $exps;
    }
    //add passed in data to the db
    public function addExp($dbcon, $section, $body){
        //sql statement
        $sql = "INSERT INTO explanations (section_name, body) VALUES ('$section', '$body')";

        //prepare and execute sql statement
        $pdostm = $dbcon->prepare($sql);
        $count = $pdostm->execute();

        //return number of rows affected
        return $count;
    }
    //get specific explanation data based on passed in id
    public function showExp($dbcon, $id){
        //sql statement
        $sql = 'SELECT * FROM explanations WHERE id = :id';

        //bind parameters
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(':id', $id);
        //execute sql statement
        $pst->execute();

        //get the results as an associative array
        $exp = $pst->fetch(PDO::FETCH_OBJ);

        //return the results
        return $exp;
    }
    //update specific explanation with passed in data
    public function updateExp($dbcon, $id, $section, $body){
        //sql statement
        $sql = 'UPDATE explanations SET section_name = :section, body = :body WHERE id = :id';

        //prepare sql statement and bind parameters
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(':section', $section);
        $pst->bindParam(':body', $body);
        $pst->bindParam(':id', $id);

        //execute sql statement
        $count = $pst->execute();

        //return number of affected rows
        return $count;
    }
    //delete specific explanation based on id
    public function deleteExp($dbcon, $id){
        //sql statement
        $sql = "DELETE FROM explanations WHERE id = :id";

        //prepare sql statement and bind params
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(':id', $id);
        //execute sql
        $count = $pst->execute();

        //return number of affected rows
        return $count;
    }
}