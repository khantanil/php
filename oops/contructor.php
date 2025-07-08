<?php


// This is a simple example of a class with a constructor in PHP
// A constructor is a special method that is called when an object is created
// It is used to initialize the properties of the class
// A class can have multiple properties and methods

class Employee {
    public $name;
    public $salary;

    function __construct($name, $salary) {
        $this->name = $name;
        $this->salary = $salary;
    }
}

$emp1 = new Employee("Anil", 50000);
$emp2 = new Employee("Jeet", 10000);

echo "Employee1 Name: " . $emp1->name . "<br>";
echo "Employee2 Salary: " . $emp2->salary . "<br>"; 