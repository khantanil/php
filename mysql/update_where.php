<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connected successfully<br>";
}

$sql = "SELECT * FROM contact  WHERE name = 'Anil Khant'";
$result = mysqli_query($conn, $sql);

// Showing total records
$num_rows = mysqli_num_rows($result);
echo  $num_rows . " records found in database<br>";

$counter = 1; // Initialize counter for ID column
if ($num_rows > 0) {
    echo "<table class='table table-striped'>
            <thead>
                <tr>
                    <th scope='col'>Sno</th>
                    <th scope='col'>Name</th>
                    <th scope='col'>Email</th>
                    <th scope='col'>Concern</th>
                    <th scope='col'>Date</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                 <td>$counter</td>
                 <td>{$row['name']}</td>
                 <td>{$row['email']}</td>
                 <td>{$row['concern']}</td>
                 <td>{$row['date']}</td>
             </tr>";
             $counter++;
    }

    echo "</tbody></table>";
} else {
    echo "No records found.";
}

$sql = "UPDATE `contact` SET `name` = 'Meet' WHERE `sno` = 17";
$result = mysqli_query($conn, $sql);
if ($result) {
    echo "Record updated successfully.";
} else {
    echo "Error updating record: " . mysqli_error($conn);
}
