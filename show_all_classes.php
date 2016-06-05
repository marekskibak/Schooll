<?php

require_once("./includes.php");

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $newClass = new SchoolClass();
    $newClass->setTeacherId($_POST['teacherId']);
    $newClass->setName($_POST['className']);
    $newClass->setDescription($_POST['classDescription']);
    $newClass->saveToDB($conn);
}


$allClasses = SchoolClass::GetAllClasses($conn);

echo("<h1> Wszystkie kursy:</h1><br>");
echo("<ul>");
foreach($allClasses as $class){
    echo("<li>
              {$class->getName()}
              <a href='show_class.php?classId={$class->getId()}'>Zobacz profil klasy</a>
         </li>");
}
echo("</ul>");

?>

<form action="show_all_classes.php" method="post">
    <label>
        Teacher responsible for class:
        <input type="text" name="teacherId">
    </label>
    <label>
        Class name:
        <input type="text" name="className">
    </label>
    <label>
        Class description:
        <input type="text" name="classDescription">
    </label>
    <input type="submit">
</form>
