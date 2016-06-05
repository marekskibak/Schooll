<?php
class SchoolClass{
    /* Funkcje repozytorium */
    static public function GetAllClasses(mysqli $conn){
        $allClasses = [];

        $sql = "SELECT * FROM Classes";

        $response = $conn->query($sql);
        if($response != FALSE){
            if($response->num_rows > 0){
                while($row = $response->fetch_assoc()){
                    $class = new SchoolClass();
                    $class->id = $row["id"];
                    $class->setName($row["name"]);
                    $class->setDescription($row["description"]);
                    $class->setTeacherId($row["teacher_id"]);
                    $allClasses[] = $class;
                }
            }
        }

        return $allClasses;
    }

    static public function GetAllClassesForStudent(mysqli $conn, $studentId){
        $allClasses = [];

        $sql = "SELECT Classes.id AS id ,
                       Classes.name as name,
                       Classes.teacher_id as teacher_id,
                       Classes.description as description
                FROM Classes
                       JOIN students_classes
                       ON Classes.id = students_classes.class_id
                WHERE  students_classes.student_id = {$studentId}";

        $response = $conn->query($sql);
        if($response != FALSE){
            if($response->num_rows > 0){
                while($row = $response->fetch_assoc()){
                    $class = new SchoolClass();
                    $class->id = $row["id"];
                    $class->setName($row["name"]);
                    $class->setDescription($row["description"]);
                    $class->setTeacherId($row["teacher_id"]);
                    $allClasses[] = $class;
                }
            }
        }

        return $allClasses;
    }

    /* Koniec funckji repozytorium */

    private $id;
    private $teacherId;
    private $name;
    private $description;

    public function __construct(){
        $this->id = -1;
        $this->setTeacherId(-1);
        $this->setName("");
        $this->setDescription("");
    }

    public function getId(){
        return $this->id;
    }

    public function getTeacherId(){
        return $this->teacherId;
    }

    public function setTeacherId($teacherId){
        $this->teacherId = $teacherId;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function saveToDB(mysqli $conn){
        if($this->id === -1){
            $sql = "INSERT INTO Classes(teacher_id, name, description) VALUES
                    ('{$this->getTeacherId()}',
                     '{$this->getName()}',
                     '{$this->getDescription()}')";
            $result = $conn->query($sql);
            if($result === true){
                $this->id = $conn->insert_id;
                return true;
            }
        }
        else{
            $sql = "UPDATE Classes SET
                      teacher_id = '{$this->getTeacherId()}',
                      name = '{$this->getName()}',
                      description = '{$this->getDescription()}'
                    WHERE id={$this->getId()}";
            $result = $conn->query($sql);
            if($result != FALSE){
                return true;
            }
        }
        return false;
    }

    public function loadFromDB(mysqli $conn, $id){
        $sql = "SELECT * FROM Classes WHERE id = {$id}";
        $result = $conn->query($sql);
        if($result != false){
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();
                $this->id = $row['id'];
                $this->setName($row['name']);
                $this->setTeacherId($row['teacher_id']);
                $this->setDescription($row['description']);
                return true;
            }
        }
        return false;
    }

    public function deleteFromDB(mysqli $conn){
        if($this->id != -1){
            $sql = "DELETE FROM Classes WHERE id = {$this->getId()}";
            $result = $conn->query($sql);
            if($result != false){
                $this->id = -1;
                $this->setName("");
                $this->setDescription("");
                $this->setTeacherId(-1);
                return true;
            }
        }
        return false;
    }

    public function addStudent(mysqli $conn, $studentId){
        if($this->id != -1 && $studentId != -1){
            $sql = "INSERT INTO students_classes(student_id, class_id) VALUES
                    ({$studentId}, {$this->getId()})";
            $result = $conn->query($sql);
            return $result;
        }
        return false;
    }

    public function removeStudent(mysqli $conn, $studendId){
        if($this->getId() != -1 && $studendId != -1){
            $sql = "DELETE FROM students_classes WHERE student_id={$studendId} AND class_id={$this->getId()}";
            $result = $conn->query($sql);
            return ($result != false);
        }
        return false;
    }

    public function getAllStudents(mysqli $conn){
        $myStudents = Student::GetAllStudentsFromClass($conn, $this->getId());

        return $myStudents;
    }
}