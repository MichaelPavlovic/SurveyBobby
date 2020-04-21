<?php 

class Question{
//Developer : Mounica Sykam
    public function addQuestion($question_text, $survey_id, $dbcon)
    {
        $totalInsert = 0;
        foreach($question_text as $question) {
            $sql = "INSERT INTO questions (question_text, survey_id) 
                VALUES (:question, :survey_id) ";
            $pst = $dbcon->prepare($sql);
            $pst->bindParam(':question', $question);
            $pst->bindParam(':survey_id', $survey_id);
            $totalInsert = $totalInsert + $pst->execute();
        }
        return $totalInsert;
    }

    public function numOfQuestions($dbcon, $survey_id)
    {
        $dbcon      = Database::getDb();
        $sql = "SELECT count(*) FROM `questions` where survey_id = :survey_id";
        $pst =  $dbcon->prepare($sql);
        $pst->bindParam(':survey_id', $survey_id);
        $num = $pst->execute();
        return $num;

    }


}

?>
