<?php
/**
 * Created by PhpStorm.
 * User: skibak
 * Date: 04.04.16
 * Time: 21:49
 */
require_once("./includes.php");



if($_SERVER['REQUEST_METHOD'] == 'POST'){
   if($_POST["Password"] != $_POST["Password1"]) {
       echo "niewlasciwe hasla wpisz jeszcze raz ";
   }
   
    $newUser = new User();
    $newUser->setName($_POST["UserName"]);
    $newUser->setSurname($_POST["UserSurname"]);
    $newUser->setMail($_POST["mail"]);
    $newUser->setLogin($_POST["login"]);
    $newUser->setPassword($_POST["Password"]);
    $newUser->setDateOfBirth($_POST["dUserDateOfBirth"]);    
    $newUser->saveToDB($conn); 
    
    
    
    /*
    header("Location: show_student.php?studentId={$studentToChange->getId()}");
*/
    }



?>


<form action='addUser.php' method='post'>
    <label>
        Imie:
        <input type='text' name='UserName' value=''>
    </label>
    <label>
        Nazwisko:
        <input type='text' name='UserSurname' value=''>
    </label>
    <label>
        Mail:
        <input type='text' name='mail' value=''>
    </label>
    <label>
        Login:
        <input type='text' name='login' value=''>
    </label>
    <label>
        Password:
        <input type='text' name='Password' value=''>
    </label>
    <label>
        RepeatPassword:
        <input type='text' name='Password1' value=''>
    </label>

    <label>
        Data urodzenia:
        <input type='text' name='UserDateOfBirth' value=''>
    </label>
    <input type='submit'>
</form>

