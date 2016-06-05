<?php

require_once("./includes.php");

if(isset($_GET['studentId'])){
    $student = new Student();
    if($student->loadFromDB($conn, $_GET['studentId']) === false){
        unset($student);
    }
}

if(isset($student)){
    echo("<h1>{$student->getName()} {$student->getSurname()}</h1><br>");
    echo("Na jakie zajecia chodzi<br>");
    $studentClasses = $student->getAllClasses($conn);
    if(count($studentClasses) > 0){
        echo("<ul>");
        foreach($studentClasses as $class){
            echo("<li>{$class->getName()}</li>");
        }
        echo("</ul>");
    }
    else{
        echo("Nie chodzi na zadne zajecia<br>");
    }
}
else{
    echo("Brak wybranego kursanta...");
}