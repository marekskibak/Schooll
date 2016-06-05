<?php
require_once("./includes.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $newStudent = new Student();
    $newStudent->setName($_POST['studentName']);
    $newStudent->setSurname($_POST['studentSurname']);
    $newStudent->setDateOfBirth($_POST['studentDateOfBirth']);
    $newStudent->saveToDB($conn);
}

$allStudents = Student::GetAllStudents($conn);

echo("<h1>Kursanci w szkole:</h1>");
if(count($allStudents) === 0){
    echo("Brak kursantów");
}
else{
    echo("<ul>");
    foreach($allStudents as $student){
        echo("<li>{$student->getName()}:
                   <a href='show_student.php?studentId={$student->getId()}'>Zobacz profil</a>
                   <a href='update_student.php?studentId={$student->getId()}'>Zmodyfikuj profil</a>
                   <a href='delete_student.php?studentId={$student->getId()}'>Usun profil</a>
             </li>");
    }
    echo("</ul>");
}
?>

<form action="show_all_students.php" method="post">
    <label>
        Imie:
        <input type="text" name="studentName">
    </label>
    <label>
        Nazwisko:
        <input type="text" name="studentSurname">
    </label>
    <label>
        Data urodzenia:
        <input type="text" name="studentDateOfBirth">
    </label>
    <input type="submit">
</form>
