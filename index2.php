<?php

require_once("./includes.php");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    var_dump($_POST);
}


?>
<form method="post" action="#">
    <select name="studentId">
        <?php
        $allStudents = Student::GetAllStudents($conn);
        foreach($allStudents as $student){
            echo("<option value='{$student->getId()}'>{$student->getName()}</option>");
        }
        ?>
    </select>
    <input type="submit">
</form>
