<?php
require_once("./includes.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $studentToChange = new Student();
    $studentToChange->loadFromDB($conn, $_POST['studentId']);
    $studentToChange->setName($_POST['studentName']);
    $studentToChange->setSurname($_POST['studentSurname']);
    $studentToChange->setDateOfBirth($_POST['studentDateOfBirth']);
    $studentToChange->saveToDB($conn);
    header("Location: show_student.php?studentId={$studentToChange->getId()}");
}


if(isset($_GET['studentId'])){
    $student = new Student();
    if($student->loadFromDB($conn, $_GET['studentId']) === false){
        unset($student);
    }
}

if(isset($student)){
    echo("
<form action='update_student.php' method='post'>
    <label>
        Imie:
        <input type='text' name='studentName' value='{$student->getName()}'>
    </label>
    <label>
        Nazwisko:
        <input type='text' name='studentSurname' value='{$student->getSurname()}'>
    </label>
    <label>
        Data urodzenia:
        <input type='text' name='studentDateOfBirth' value='{$student->getDateOfBirth()}'>
    </label>
    <input type='hidden' name='studentId' value='{$student->getId()}'>
    <input type='submit'>
</form>
    ");
}
else{
    echo("Brak studenta o podanym id");
}