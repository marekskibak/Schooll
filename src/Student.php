<?php

class Student{
    /* Funkcje repozytorium */
    static public function GetAllStudents(mysqli $conn){
        $allStudent = [];

        $sql = "SELECT * FROM Students";

        $response = $conn->query($sql);
        if($response != FALSE){
            if($response->num_rows > 0){
                while($row = $response->fetch_assoc()){
                    $student = new Student();
                    $student->id = $row["id"];
                    $student->setName($row["name"]);
                    $student->setSurname($row["surname"]);
                    $student->setDateOfBirth($row["birth_date"]);
                    $allStudent[] = $student;
                }
            }
        }

        return $allStudent;
    }

    static public function GetAllStudentsFromClass(mysqli $conn, $classId){
        $allStudent = [];

        $sql = "SELECT Students.id as id,
                       Students.name as name,
                       Students.surname as surname,
                       Students.birth_date as birth_date
                FROM Students
                       JOIN students_classes
                       ON Students.id = students_classes.student_id
                WHERE students_classes.class_id = {$classId}";

        $response = $conn->query($sql);
        if($response != FALSE){
            if($response->num_rows > 0){
                while($row = $response->fetch_assoc()){
                    $student = new Student();
                    $student->id = $row["id"];
                    $student->setName($row["name"]);
                    $student->setSurname($row["surname"]);
                    $student->setDateOfBirth($row["birth_date"]);
                    $allStudent[] = $student;
                }
            }
        }

        return $allStudent;
    }

    static public function GetAllStudentsNotInClass(mysqli $conn, $classId){
        $allStudent = [];

        $sql = "SELECT id, name, surname, birth_date
                 FROM Students
                WHERE Students.id NOT IN
                      (SELECT Students.id FROM Students
                       JOIN students_classes
                       ON Students.id = students_classes.student_id
                       WHERE students_classes.class_id = {$classId}
                       )";

        $response = $conn->query($sql);
        if($response != FALSE){
            if($response->num_rows > 0){
                while($row = $response->fetch_assoc()){
                    $student = new Student();
                    $student->id = $row["id"];
                    $student->setName($row["name"]);
                    $student->setSurname($row["surname"]);
                    $student->setDateOfBirth($row["birth_date"]);
                    $allStudent[] = $student;
                }
            }
        }

        return $allStudent;
    }

    /* Koniec funckji repozytorium */

    private $id;
    private $name;
    private $surname;
    private $dateOfBirth;

    public function __construct(){
        $this->id = -1;
        $this->name = "";
        $this->surname = "";
        $this->dateOfBirth = "";
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getSurname(){
        return $this->surname;
    }

    public function setSurname($surname){
        $this->surname = $surname;
    }

    public function getDateOfBirth(){
        return $this->dateOfBirth;
    }

    public function setDateOfBirth($dateOfBirth){
        $this->dateOfBirth = $dateOfBirth;
    }

    public function saveToDB(mysqli $conn){
        if($this->id === -1){
            $sql = "INSERT INTO Students(name, surname, birth_date)
                    VALUES ('{$this->getName()}',
                            '{$this->getSurname()}',
                            '{$this->getDateOfBirth()}')";
            $result = $conn->query($sql);
            if($result === TRUE){
                $this->id = $conn->insert_id;
                return true;
            }
        }
        else{
            $sql = "UPDATE Students SET
                      name = '{$this->getName()}',
                      surname = '{$this->getSurname()}',
                      birth_date = '{$this->getDateOfBirth()}'
                    WHERE id={$this->getId()}";
            $result = $conn->query($sql);
            if($result != FALSE){
                return true;
            }
        }

        return false;
    }

    public function loadFromDB(mysqli $conn, $idToFind){
        $sql = "SELECT * FROM Students WHERE id={$idToFind}";
        $result = $conn->query($sql);
        if($result != FALSE){
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();
                $this->id = $row['id'];
                $this->setName($row['name']);
                $this->setSurname($row['surname']);
                $this->setDateOfBirth($row['birth_date']);
                return true;
            }
        }
        return false;
    }

    public function deleteFromDB(mysqli $conn){
        if($this->id !== -1){
            $sql = "DELETE FROM Students WHERE id={$this->id}";
            $result = $conn->query($sql);
            if($result != false){
                $this->id = -1;
                $this->setName("");
                $this->setSurname("");
                $this->setDateOfBirth("");
                return true;
            }
        }
        return false;
    }

    public function getAllMarks(){
        $myMarks = [];

        // TODO: Load all marks for current Student

        return $myMarks;
    }

    public function getAllClasses(mysqli $conn){
        $myClasses = SchoolClass::GetAllClassesForStudent($conn, $this->getId());
        return $myClasses;
    }
}