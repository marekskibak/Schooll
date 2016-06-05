<?php
require_once("./includes.php");

if(isset($_GET['studentId'])){
    $student = new Student();
    if($student->loadFromDB($conn, $_GET['studentId']) === true){
        $student->deleteFromDB($conn);
        header("Location: show_all_students.php");
    }
}
?>
<h1>Coś poszło nie tak....</h1>
