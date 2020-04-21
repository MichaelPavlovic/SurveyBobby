<?php

class Survey {
    //Developer:Mounica Sykam
   public function listAllSurveys($dbcon){
        $sql = "SELECT * FROM surveys";
        $pdostm = $dbcon->prepare($sql);
        $pdostm->execute();
        $surveys = $pdostm->fetchAll(PDO::FETCH_OBJ);
        return $surveys;
    }
    //Developer: Vitaliy Bulyma
   
    public function AllSurveysTakenByUser($dbcon, $user_id){
        $sql = "select * from surveys where id in (SELECT distinct(survey_id) FROM `questions` where id in (SELECT DISTINCT(question_id) FROM `answers` where user_id = :user_id))";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(':user_id', $user_id);
        $pst->execute();
        $allsurveys= $pst->fetchAll(PDO::FETCH_OBJ);
        return $allsurveys;

    }
    //Developer: Vitaliy Bulyma
    public function countSurveys($dbcon){
        $sql = "SELECT COUNT(id) as total FROM surveys";
        $pdostm = $dbcon->prepare($sql);
        $pdostm->execute();

        $surveys = $pdostm->fetchAll(\PDO::FETCH_OBJ);
        return $surveys;
    }

    //Developer: Vitaliy Bulyma
    public function countSurveys30($dbcon){
        $sql = "SELECT COUNT(id) as total30days FROM `surveys` WHERE DATE(created_date) >= DATE(NOW()) - INTERVAL 30 DAY";
        $pdostm = $dbcon->prepare($sql);
        $pdostm->execute();

        $surveys = $pdostm->fetchAll(\PDO::FETCH_OBJ);
        return $surveys;
    }
   //Developer:Mounica Sykam
    public function addSurvey($name, $description, $userid, $categoryid, $dbcon)
    {
        $sql = "INSERT INTO surveys (title, description, user_id, category_id) 
              VALUES (:name, :description, :userid, :categoryid) ";
        $pst = $dbcon->prepare($sql);

        $pst->bindParam(':name', $name);
        $pst->bindParam(':description', $description);
        $pst->bindParam(':userid', $userid);
        $pst->bindParam(':categoryid', $categoryid);
        $count = $pst->execute();
        return $count;
    }
    //DEVELOPER: Michael Pavlovic
    public function showSurvey($dbcon, $id){
        //sql statement
        $sql = 'SELECT * FROM surveys WHERE id = :id';

        $pst = $dbcon->prepare($sql);
        $pst->bindParam(':id', $id);
        $pst->execute();

        $count = $pst->fetch(PDO::FETCH_OBJ);

        return $count;
    }
    //DEVELOPER: Michael Pavlovic
    public function updateSurvey($dbcon, $id, $title, $description, $category){
        $sql = 'UPDATE surveys SET title = :title, description = :description, category_id = :category_id WHERE id = :id';

        //prepare sql statement & bind params
        $pst = $dbcon->prepare($sql);

        $pst->bindParam(':title', $title);
        $pst->bindParam(':description', $description);
        $pst->bindParam(':category_id', $category);
        $pst->bindParam(':id', $id);

        //execute sql statement
        $count = $pst->execute();

        //return number of affected rows
        return $count;
    }
    //DEVELOPER: Michael Pavlovic
    public function deleteSurvey($dbcon, $id){
        $sql = "DELETE FROM surveys WHERE id = :id";

        $pst = $dbcon->prepare($sql);
        $pst->bindParam(':id', $id);
        $count = $pst->execute();
        return $count;
    }
    //Developer: Vitaliy Bulyma
    public function displaySurveys($dbcon, $user_id){

        $sql = "SELECT surveys.id as survey_id, surveys.title, surveys.description, surveys.created_date, users.fname, users.lname 
        FROM `surveys` JOIN categories on surveys.category_id = categories.id 
        JOIN users on surveys.user_id = users.id WHERE users.id= :user_id";
        $pst = $dbcon->prepare($sql);
        $pst->bindParam(':user_id', $user_id);
        $pst->execute();
        $indsurveys= $pst->fetchAll(PDO::FETCH_OBJ);
        return $indsurveys;

    }
    //Developer:Mounica Sykam
    public function displayAllSurveys($dbcon){

        $sql = "SELECT * FROM `surveys` JOIN categories on surveys.category_id = categories.id JOIN users on surveys.user_id = users.id";
        $pst = $dbcon->prepare($sql);
        $pst->execute();
        $allsurveys= $pst->fetchAll(PDO::FETCH_OBJ);
        return $allsurveys;

    }
    //Developer: Vitaliy Bulyma
    public function avgResponse($dbcon, $survey_id){
        $sql = "SELECT CAST(AVG(answer) AS DECIMAL(10,2)) as average FROM answers inner join questions on answers.question_id=questions.id  where  survey_id= :survey_id";
        
        $pdostm = $dbcon->prepare($sql);
        $pdostm->bindParam(':survey_id', $survey_id);
        $pdostm->execute();

        $average = $pdostm->fetchAll(\PDO::FETCH_OBJ);
        return $average;
    }
    //Developer:Mounica Sykam
    public function avgResponsePerUser($survey_id, $user_id, $db){
        $sql = "SELECT CAST(AVG(answer) AS DECIMAL(10,2)) as averageperuser from answers where user_id = :user_id AND question_id in (SELECT id from questions where survey_id = :survey_id)";
        
        $pdostm = $db->prepare($sql);
        $pdostm->bindParam(':user_id', $user_id);
        $pdostm->bindParam(':survey_id', $survey_id);
        $pdostm->execute();

        $averageperuser = $pdostm->fetch(\PDO::FETCH_ASSOC);
        return $averageperuser;
    }
    //Developer:Mounica Sykam
    public function numberofuserspersurvey($survey_id, $db){
        $sql = "SELECT count(distinct(user_id)) as no_of_users from answers WHERE question_id in (SELECT id from questions where survey_id = :survey_id)";
        
        $pdostm = $db->prepare($sql);
        $pdostm->bindParam(':survey_id', $survey_id);
        $pdostm->execute();

        $noOfUsers = $pdostm->fetch(\PDO::FETCH_ASSOC);
        return $noOfUsers;
    }
}
?>
