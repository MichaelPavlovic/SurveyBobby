<?php

//DEVELOPER: Michael Pavlovic

Interface QuestionInterface {
    public function getQuestionsByID($dbcon, $surveyID);
    public function addQuestion($dbcon, $question, $id);
    public function showQuestion($dbcon, $id);
    public function updateQuestion($dbcon, $id, $question);
    public function deleteQuestion($dbcon, $id);
    public function deleteAllQuestions($dbcon, $surveyid);
}

class Question implements QuestionInterface {
    public function getQuestionsByID($dbcon, $surveyID){
        //sql statement
        $sql = 'SELECT * FROM questions WHERE survey_id = :id';

        //prepare and execute sql statement
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(':id', $surveyID);
        $pst->execute();

        //get the results as an associative array
        $questions = $pst->fetchAll(PDO::FETCH_ASSOC);

        //return results
        return $questions;
    }
    public function addQuestion($dbcon, $question, $id){
        //sql statement
        $sql = "INSERT INTO questions (question_text, survey_id) VALUES ('$question', '$id')";

        //prepare and execute sql statement
        $pdostm = $dbcon->prepare($sql);
        $count = $pdostm->execute();

        //return number of rows affected
        return $count;
    }
    //get specific faq based on id
    public function showQuestion($dbcon, $id){
        //sql statement
        $sql = 'SELECT * FROM questions WHERE id = :id';

        //
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(':id', $id);
        $pst->execute();

        $q = $pst->fetch(PDO::FETCH_OBJ);

        return $q;
    }
    public function updateQuestion($dbcon, $id, $question){
        //sql statement
        $sql = 'UPDATE questions SET question_text = :question WHERE id = :id';

        //prepare sql statement and bind parameters
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(':question', $question);
        $pst->bindParam(':id', $id);

        //execute sql statement
        $count = $pst->execute();

        //return number of affected rows
        return $count;
    }
    public function deleteQuestion($dbcon, $id){
        //sql statement
        $sql = "DELETE FROM questions WHERE id = :id";

        //prepare sql statement and bind params
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(':id', $id);
        //execute sql
        $count = $pst->execute();

        //return number of affected rows
        return $count;
    }
    public function deleteAllQuestions($dbcon, $surveyid){
        //sql statement
        $sql = "DELETE FROM questions WHERE survey_id = :id";

        //prepare sql statement and bind params
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(':id', $surveyid);
        //execute sql
        $count = $pst->execute();

        //return number of affected rows
        return $count;
    }
}