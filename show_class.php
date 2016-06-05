<?php
require_once("./includes.php");

if(isset($_GET['classId'])){
    $class = new SchoolClass();
    if($class->loadFromDB($conn, $_GET['classId']) === false){
        unset($class);
    }
}

if(isset($class)){
    echo("<h1>{$class->getName()}</h1><br>");
    echo("<p>{$class->getDescription()}</p><br>");
    echo("<p>Glowny wykladowca: !! TODO !!");

    echo("<h1>Kursanci:</h1>");
    $classStudents = $class->getAllStudents($conn);
    if(count($classStudents) === 0){
        echo("Nikt nie jest zapisany....<br>");
    }
    else{
        echo("<ul>");
        foreach($classStudents as $student){
            echo("<li>
                  {$student->getName()}
                  <a href='remove_from_class.php?classId={$class->getId()}&studentId={$student->getId()}'>Usun z kursu</a>
                  </li>");
        }
        echo("</ul>");
    }

    echo("<h1> Kursanci nie zapisani na ten kurs</h1>");
    $studentNotInClass = Student::GetAllStudentsNotInClass($conn, $class->getId());
    if(count($studentNotInClass) === 0){
        echo("Wszyscy sa zapisani....<br>");
    }
    else{
        echo("<ul>");
        foreach($studentNotInClass as $student){
            echo("<li>
                  {$student->getName()}
                  <a href='add_to_class.php?classId={$class->getId()}&studentId={$student->getId()}'>Dodaj do kursu</a>
                  </li>");
        }
        echo("</ul>");
    }
}
else{
    echo("<h1> Nie ma takiej klasy....</h1>");
}