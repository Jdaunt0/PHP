<?php 
class Employee{
    //data
    private $EID;
    private $name;
    private $surname;
    private $position;
    private $unit;
    private $salary;

    //constructor
    function __construct($EID, $name, $surname, $position, $unit, $salary){
        $this->EID = $EID;
        $this->name = $name;
        $this->surname = $surname;
        $this->position = $position;
        $this->unit = $unit;
        $this->salary = $salary;
    }

    //accessor
    function get_EID(){
        return $this->EID;
    }

    function get_name(){
        return $this->name;
    }

    function get_surname(){
        return $this->surname;
    }

    function get_position(){
        return $this->position;
    }

    function get_unit(){
        return $this->unit;
    }

    function get_salary(){
        return $this->salary;
    }

    //mutator
    function set_EID($EID){
        $this->EID = $EID;
    }

    function set_name($name){
        $this->name = $name;
    }

    function set_surname($surname){
        $this->surname = $surname;
    }

    function set_position($position){
        $this->position = $position;
    }

    function set_unit($unit){
        $this->unit = $unit;
    }

    function set_salary($salary){
        $this->salary = $salary;
    }

    //print function (echo)
    function print_employeeInfo(){
        echo "Name: {$this->name} <br>" .
             "Surname: {$this->surname} <br>" .
             "Position {$this->position} <br>" .
             "Unit: {$this->unit} <br>" .
             "Salary {$this->salary} <br>";
    }
}

$james = new Employee("101", "James", "Daunt", "coder", "unit", "$2,000,000");
$john = new Employee("101", "John", "Smith", "Manager", "unit", "$200,000");

$james->print_employeeInfo();
$john->print_employeeInfo();

?>