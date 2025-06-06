<?php
// This is a simple example of a class in PHP
// A class is a blueprint for creating objects
// An object is an instance of a class
// A class can have properties (variables) and methods (functions)
// Properties are used to store data, and methods are used to perform actions
// A class can also have a constructor, which is a special method that is called when an object is created

class Player {

    // Properties
    // Properties are variables that belong to the class
    // They are used to store data related to the class
    public $name;
    public $speed;
    public $running = false;

    // Methods
    // Methods are functions that belong to the class
    // They are used to perform actions related to the class
    function set_name($name){
        $this->name = $name;
    }

    function get_name(){
        return $this->name;
    }

    function run(){
        $this->running = true;
    }

    function stopRun(){
        $running = false;
    }
}

// Creating objects from the Player class
$player1 = new Player();
$player1->set_name("Rohit Sharma");
echo "Player1 Name : " . $player1->get_name() . "<br>";
echo "Player1 speed : ". $player1->speed . "<br>";

$player2 = new Player();
$player2->set_name("Virat Kohli");
echo "Player2 Name : " . $player2->get_name() . "<br>";
echo "Player2 speed : ". $player2->speed . "<br>";




?>