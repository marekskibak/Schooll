<?php
require_once("./includes.php");

if(isset($_GET['classId']) && isset($_GET['studentId'])){
    $class = new SchoolClass();
    if($class->loadFromDB($conn, $_GET['classId']) === false){
        unset($class);
    }
    $student = new Student();
    if($student->loadFromDB($conn, $_GET['studentId']) === false){
        unset($student);
    }

    if(isset($class) && isset($student)){
        $class->addStudent($conn, $student->getId());
        header("Location: show_class.php?classId={$class->getId()}");
    }
}
echo("<h1>Cos poszlo nie tak</h1>");