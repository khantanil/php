<?php


$str = "Hello, World! This is my first PHP script.";
echo "Length of string is ". strlen($str) . "<br>"; // Length of the string
echo "Word count of this string is " . str_word_count($str) . "<br>"; // Word count of the string
echo strrev($str) . "<br>"; // Reverse the string
echo strpos($str, "World") . "<br>"; // Find the position of the first occurrence of "World"
echo str_replace("World", "PHP", $str) . "<br>"; // Replace "World" with "PHP" in the string
echo strtoupper($str) . "<br>"; // Convert the string to uppercase
echo strtolower($str) . "<br>"; // Convert the string to lowercase
echo ucfirst("hello world") . "<br>"; // Convert the first character of the string to uppercase
echo ucwords("hello world") . "<br>"; // Convert the first character of each word to uppercase
echo trim("   Hello World!   ") . "<br>"; // Remove whitespace from the beginning and end of the string
echo str_repeat("Hello ", 3) . "<br>"; // Repeat the string 3 times
echo "Substring from index 7 to 12: " . substr($str, 7, 5) . "<br>"; // Get a substring from the string

echo "String to array: ";
$array = explode(" ", $str); // Convert string to array
print_r($array); // Print the array
echo "<br>Array to string: " . implode(" ", $array) . "<br>"; // Convert array to string


?>