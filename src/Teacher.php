<?php

class Teacher{
    private $id;
    private $name;
    private $surname;
    private $wagePerHour;

    public function __construct(){
        $this->id = -1;
        $this->name = "";
        $this->surname = "";
        $this->wagePerHour = 0;
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

    public function getWagePerHour(){
        return $this->wagePerHour;
    }

    public function setWagePerHour($wagePerHour){
        $this->wagePerHour = $wagePerHour;
    }

    public function saveToDB(mysqli $conn){
        if($this->id === -1){
            $sql = "INSERT INTO Teachers(name, surname, wage_per_hour)
                    VALUES ('{$this->getName()}',
                            '{$this->getSurname()}',
                            '{$this->getWagePerHour()}')";
            $result = $conn->query($sql);
            if($result === TRUE){
                $this->id = $conn->insert_id;
                return true;
            }
        }
        else{
            $sql = "UPDATE Teachers SET
                      name = '{$this->getName()}',
                      surname = '{$this->getSurname()}',
                      wage_per_hour = '{$this->getWagePerHour()}'
                    WHERE id={$this->getId()}";
            $result = $conn->query($sql);
            if($result != FALSE){
                return true;
            }
            echo($sql);
            echo("<br>");
            echo($conn->error);
        }

        return false;
    }

    public function loadFromDB(mysqli $conn, $idToFind){
        $sql = "SELECT * FROM Teachers WHERE id={$idToFind}";
        $result = $conn->query($sql);
        if($result != FALSE){
            if($result->num_rows === 1){
                $row = $result->fetch_assoc();
                $this->id = $row['id'];
                $this->setName($row['name']);
                $this->setSurname($row['surname']);
                $this->setWagePerHour($row['wage_per_hour']);
                return true;
            }
        }
        return false;
    }
}