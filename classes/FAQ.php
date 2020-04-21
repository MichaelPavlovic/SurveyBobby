<?php

//DEVELOPER: Michael Pavlovic

Interface FAQInterface {
    public function listFAQs($dbcon);
    public function addFAQ($dbcon, $question, $answer);
    public function showFAQ($dbcon, $id);
    public function updateFAQ($dbcon, $id, $question, $answer);
    public function deleteFAQ($dbcon, $id);
}

class FAQ implements FAQInterface {
    //list all faqs from the database
    public function listFAQs($dbcon){
        //write sql statement
        $sql = 'SELECT * FROM faq';
        //prepare & execute sql statement
        $pdostm = $dbcon->prepare($sql);
        $pdostm->execute();

        //get results as an associative array
        $faqs = $pdostm->fetchAll(PDO::FETCH_ASSOC);

        //return results
        return $faqs;
    }
    //add faq based on passed in data
    public function addFAQ($dbcon, $question, $answer){
        //sql statement
        $sql = "INSERT INTO faq (question, answer) VALUES ('$question', '$answer')";

        //prepare & execute sql statement
        $pdostm = $dbcon->prepare($sql);
        $count = $pdostm->execute();

        //return number of rows affected
        return $count;
    }
    //get specific faq based on id
    public function showFAQ($dbcon, $id){
        //sql statement
        $sql = 'SELECT * FROM faq WHERE id = :id';

        //
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(':id', $id);
        $pst->execute();

        $faq = $pst->fetch(PDO::FETCH_OBJ);

        return $faq;
    }
    //update specific faq with passed in data
    public function updateFAQ($dbcon, $id, $question, $answer){
        $sql = 'UPDATE faq SET question = :question, answer = :answer WHERE id = :id';

        //prepare sql statement & bind params
        $pst = $dbcon->prepare($sql);

        $pst->bindParam(':question', $question);
        $pst->bindParam(':answer', $answer);
        $pst->bindParam(':id', $id);

        //execute sql statement
        $count = $pst->execute();

        //return number of affected rows
        return $count;
    }
    //delete specific faq based on id
    public function deleteFAQ($dbcon, $id){
        //sql statement
        $sql = "DELETE FROM faq WHERE id = :id";

        //prepare sql statement & bind params
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(':id', $id);

        //execute sql statement
        $count = $pst->execute();

        //return number of affected rows
        return $count;
    }
}