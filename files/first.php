<?php

// include 'file_to_include.php';
// require 'file_to_include.php';


// If you  want to read only the content of a file without executing it, you can use readfile() function.
// This will read the content of the file and output it directly to the browser.

/*$file_to_read = readfile('temp.txt');
echo  $file_to_read;*/



// fopen() is used to open a file or URL. It returns a file pointer resource on success, or false on failure.
// 'r' mode is used to open the file for reading only. The file pointer is placed at the beginning of the file.
$file = fopen('temp.txt', 'r');
if(!$file){
    die("Unable to open file!");
}
$filecontent = fread($file, filesize('temp.txt'));
echo $filecontent;
fclose($file);



// If you want to write to a file, you can use fopen() with 'w' mode.
// This will create a new file or overwrite an existing file.
$file2 = fopen('temp2.txt', 'w');
fwrite($file2, "This is a new file created by PHP.\n");
fclose($file2);

?>